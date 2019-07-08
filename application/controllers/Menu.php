<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
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
		$data['menus'] = $this->db->get('user_menus')->result_array();

		$data['title'] = "Menu Management";

		$this->form_validation->set_rules('menu', 'Menu', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('layouts/header', $data);
			$this->load->view('layouts/sidebar', $data);
			$this->load->view('layouts/topbar', $data);
			$this->load->view('menu/index', $data);
			$this->load->view('layouts/footer', $data);
		} else {
			$this->db->insert('user_menus', ['menu' => $this->input->post('menu')]);

			$this->session->set_flashdata('message', '<div class="alert alert-success">Successful <strong>add</strong> menu</div>');
			redirect('menu');
		}
	}

	public function edit()
	{
		if (empty($_POST)) redirect('menu');

		$data = [
			'menu' => $this->input->post('menu')
		];

		$this->form_validation->set_rules('menu', 'Menu', 'required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode($this->db->get_where('user_menus', ['id' => $this->input->post('id')])->row_array());
		} else {
			$this->db->update('user_menus', $data, ['id' => $this->input->post('id')]);
			$this->session->set_flashdata('message', '<div class="alert alert-success">Successful <strong>deleting</strong> menu</div>');
			redirect('menu');
		}
	}

	public function delete($id)
	{
		$this->db->delete('user_menus', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Successful deleting menu</div>');
		redirect('menu');
	}
}
