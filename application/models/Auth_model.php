<?php

class Auth_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function insertUser()
	{
		$email = $this->input->post('email', true);
		$data = [
			// mensanitasi input
			'name' => htmlspecialchars($this->input->post('name', true)), // menghindari xss 
			'email' => htmlspecialchars($email),
			'image' => 'default.jpg',
			'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
			'role_id' => 2,
			'is_active' => 0,
			'date_created' => time()
		];

		$this->db->insert('users', $data);
		return $this->db->affected_rows();
	}
}
