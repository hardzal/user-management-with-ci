<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

		$data['title'] = "My Profile";
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('layouts/topbar', $data);
		$this->load->view('users/index', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function edit()
	{
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

		$data['title'] = "Edit Profile";

		$this->form_validation->set_rules('name', 'Full Name', 'required|trim');
		$this->form_validation->set_rules('image', 'Image', 'trim');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('layouts/header', $data);
			$this->load->view('layouts/sidebar', $data);
			$this->load->view('layouts/topbar', $data);
			$this->load->view('users/editpassword', $data);
			$this->load->view('layouts/footer', $data);
		} else {
			$name = $this->input->post('name');
			$email = $this->input->post('email');

			// check jika ada gambar yang diterima
			$image_name = $_FILES['image']['name'];
			if ($image_name) {
				$config['allowed_types'] = "gif|jpg|png";
				$config['max_sizes'] = "2048";
				$config['upload_path'] = './assets/img/profile/';

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('image')) {
					$old_image = $data['user']['image'];

					if ($old_image != 'default.jpg') {
						unlink(FCPATH . 'assets/img/profile/' . $old_image);
					}

					$new_image = $this->upload->data('file_name');
					$this->db->set('image', $new_image);
				} else {
					echo $this->upload->display_errors();
				}
			}

			$this->db->set('name', $name);
			$this->db->where('email', $email);
			$this->db->update('users');

			$this->session->set_flashdata('message', '<div class="alert alert-success">Your profile has been updated!</div>');
			redirect('user');
		}
	}

	public function changepassword()
	{
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

		$data['title'] = "Change Password";

		$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|trim|min_length[6]|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[new_password]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('layouts/header', $data);
			$this->load->view('layouts/sidebar', $data);
			$this->load->view('layouts/topbar', $data);
			$this->load->view('users/changepassword', $data);
			$this->load->view('layouts/footer', $data);
		} else {
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');
			if (!password_verify($current_password, $data['user']['password'])) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong current password!</div>');
				redirect('user/changepassword');
			} else {
				if ($current_password == $new_password) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">New password cannot be same as current password!</div>');
					redirect('user/changepassword');
				} else {
					$password_hash = password_hash($new_password, PASSWORD_DEFAULT);
					$this->db->set('password', $password_hash);
					$this->db->where('email', $this->session->userdata['email']);
					$this->db->update('users');

					$this->session->set_flashdata('message', '<div class="alert alert-success">Successful change password!</div>');
					redirect('user/changepassword');
				}
			}
		}
	}
}
