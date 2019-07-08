<?php

class Submenu extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$query = "SELECT user_sub_menus.id, 
				user_menus.id AS menu_id, 
				user_menus.menu,
				user_sub_menus.title, 
				user_sub_menus.url,
				user_sub_menus.icon,
				user_sub_menus.is_active FROM user_sub_menus 
				JOIN user_menus ON user_sub_menus.menu_id = user_menus.id
				ORDER BY user_menus.id ASC
		";
		$data['submenus'] = $this->db->query($query)->result_array();
		$data['menus'] = $this->db->get('user_menus')->result_array();

		$data['title'] = "Submenu Management";

		$this->form_validation->set_rules('submenu', 'Submenu Title', 'required');
		$this->form_validation->set_rules('menu_id', 'Menu', 'required');
		$this->form_validation->set_rules('url', 'Submenu Url', 'required');
		$this->form_validation->set_rules('icon', 'Submenu Icon', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('layouts/header', $data);
			$this->load->view('layouts/sidebar', $data);
			$this->load->view('layouts/topbar', $data);
			$this->load->view('menu/submenu', $data);
			$this->load->view('layouts/footer', $data);
		} else {
			$data = [
				'menu_id' => $this->input->post('menu_id'),
				'title' => $this->input->post('submenu'),
				'url' => $this->input->post('url'),
				'icon' => $this->input->post('icon'),
				'is_active' => $this->input->post('is_active')
			];

			$this->db->insert('user_sub_menus', $data);

			$this->session->set_flashdata('message', '<div class="alert alert-success">Successful <strong>add</strong> Submenu</div>');
			redirect('menu/submenu');
		}
	}

	public function edit()
	{
		if (empty($_POST)) redirect('menu/submenu');

		$this->form_validation->set_rules('menu_id', 'Menu Id', 'required');
		$this->form_validation->set_rules('submenu', 'Submenu Title', 'required|trim|min_length[3]');
		$this->form_validation->set_rules('url', 'Submenu Url', 'required|trim');
		$this->form_validation->set_rules('icon', 'Submenu Icon', 'required|trim');
		$this->form_validation->set_rules('is_active', 'Is Active', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode($this->db->get_where('user_sub_menus', ['id' => $this->input->post('id')])->row_array());
		} else {
			$data = [
				'menu_id' => $this->input->post('menu_id'),
				'title' => $this->input->post('submenu'),
				'url' => $this->input->post('url'),
				'icon' => $this->input->post('icon'),
				'is_active' => $this->input->post('is_active')
			];

			$this->db->update('user_sub_menus', $data, ['id' => $this->input->post('id')]);
			$this->session->set_flashdata('message', '<div class="alert alert-success">Successful <strong>deleting</strong> menu</div>');
			redirect('menu/submenu');
		}
	}

	public function delete($id)
	{
		$this->db->delete('user_sub_menus', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Successful deleting sub	menu</div>');
		redirect('menu');
	}
}
