<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		is_logged_in();
	}

	public function index()
	{
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

		$data['title'] = "Dashboard";
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('layouts/topbar', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function roles()
	{
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$data['roles'] = $this->db->get('user_roles')->result_array();

		$data['title'] = "Roles Access";

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('layouts/topbar', $data);
		$this->load->view('admin/roles', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function roleAccess($role_id)
	{
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$data['roles'] = $this->db->get_where('user_roles', ['id' => $role_id])->row_array();
		$this->db->where('id !=', 1);
		$data['menus'] = $this->db->get('user_menus')->result_array();
		$data['title'] = "Roles Access";

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('layouts/topbar', $data);
		$this->load->view('admin/role-access', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function changeAccess()
	{
		$menu_id = $this->input->post('menu_id');
		$role_id = $this->input->post('role_id');

		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		];

		$check = $this->db->get_where('user_access_menus', $data);

		if ($check->num_rows() < 1) {
			$this->db->insert('user_access_menus', $data);
		} else {
			$this->db->delete('user_access_menus', $data);
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success">Success update role access menus</a></div>');
	}
}
