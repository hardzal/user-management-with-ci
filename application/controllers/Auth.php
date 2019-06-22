<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Auth_model', 'auth');
	}

	public function index()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		}
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
		if ($this->form_validation->run() == false) {
			$data['title'] = "Login Page";
			$this->load->view('layouts/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('layouts/auth_footer');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		// jika user tersedia
		if ($user) {
			// jika user telah aktivasi
			if ($user['is_active'] == 1) {
				if (password_verify($password, $user['password'])) {
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id']
					];

					$this->session->set_userdata($data);
					if ($data['role_id'] == 1) {
						redirect('admin');
					} else if ($data['role_id'] == 2) {
						redirect('user');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong password!</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">This email has not been activated!</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">This email not registered!</div>');
			redirect('auth');
		}
	}

	public function signup()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		}
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]', [
			'is_unique' => 'This email has already registered'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[confirm_password]', [
			'min_length' => "Password too short!",
			'matches' => "Password don't match!"
		]);
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]', [
			'min_length' => "Password too short!",
			'matches' => "Password don't match!"
		]);

		if ($this->form_validation->run() == false) {
			$data['title'] = "Signup!";
			$this->load->view('layouts/auth_header', $data);
			$this->load->view('auth/signup');
			$this->load->view('layouts/auth_footer');
		} else {

			$email = $this->input->post('email', true);
			// user token
			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];

			$this->db->insert('user_token', $user_token);

			if ($this->auth->insertUser()) {

				$this->_sendEmail($token, 'verify');

				$this->session->set_flashdata('message', '<div class="alert alert-success">Congratulation! your account has been created. Please activate your account!</div>');
				redirect('auth');
			} else {
				echo "GAGAL MENDAFTARKAN AKUN!";
			}
		}
	}

	private function _sendEmail($token, $type)
	{
		$config = [
			'protocol' 	=> 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'langkahkita01@gmail.com',
			'smtp_pass' => 'qwerty1070',
			'smtp_port' => 465,
			'mail_type' => 'html',
			'charset' 	=> 'utf-8',
			'newline' 	=> "\r\n",
		];

		$this->load->library('email', $config);
		$this->email->initialize($config);

		$this->email->from('langkahkita01@gmail.com', 'LS Admin');
		$this->email->to($this->input->post('email'));

		if ($type == 'verify') {
			$this->email->subject('Account Verification | LS Admin');
			$this->email->message('Click this link to verify your account : <a href="' . base_url('auth/verify?email=') . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
		} else if ($type == 'forgot') {
			$this->email->subject('Reset Password | LS Admin');
			$this->email->message('Click this link to reset your password account : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset</a>');
		}

		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
		}
	}

	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
					$this->db->set('is_active', 1);
					$this->db->where('email', $email);
					$this->db->update('users');

					$this->db->delete('user_token', ['email' => $email]);

					$this->session->set_flashdata('message', '<div class="alert alert-success">Congratulation! your account has been created ' . $email . ' has been activated. Please Login!</div>');
					redirect('auth');
				} else {

					$this->db->delete('users', ['email' => $email]);
					$this->db->delete('user_token', ['email' => $email]);

					$this->session->set_flashdata('message', '<div class="alert alert-danger">Account activation failed! Token expired.</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Account activation failed! Token invalid.</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Account activation failed! Wrong email.</div>');
			redirect('auth');
		}
	}

	public function forgotPassword()
	{
		$data['title'] = "Forgot Password";

		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('layouts/auth_header', $data);
			$this->load->view('auth/forgot-password', $data);
			$this->load->view('layouts/auth_footer');
		} else {
			$email = $this->input->post('email');

			$check_email = $this->db->get_where('users', ['email' => $email, 'is_active' => 1])->row_array();
			if ($check_email) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];

				$this->db->insert('user_token', $user_token);

				$this->_sendEmail($token, 'forgot');

				$this->session->set_flashdata('message', '<div class="alert alert-success">Please your check email to reset your password.</div>');
				redirect('auth/forgotpassword');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Email is not registered or activated</div>');
				redirect('auth/forgotpassword');
			}
		}
	}

	public function resetPassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Reset password failed! Token invalid.</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Reset password failed! Wrong email.</div>');
			redirect('auth');
		}
	}

	public function changePassword()
	{
		if (!$this->session->userdata('reset_email')) {
			redirect('auth');
		}

		$data['title'] = "Change Password";
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('layouts/auth_header', $data);
			$this->load->view('auth/change-password', $data);
			$this->load->view('layouts/auth_footer');
		} else {
			$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');

			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('users');

			$this->session->unset_userdata('reset_email');

			$this->session->set_flashdata('message', '<div class="alert alert-success">Password has been changed!. Please login</div>');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->set_flashdata('message', '<div class="alert alert-primary">You\'ve been logout.</div>');
		redirect('auth');
	}

	public function blocked()
	{
		$data['title'] = "403 Access Blocked";
		$this->load->view('layouts/header', $data);
		$this->load->view('auth/blocked', $data);
		$this->load->view('layouts/footer');
	}
}
