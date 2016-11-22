<?php

defined("BASEPATH") or exit("No diret script access allowed");

class M_User extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function findUserByUsername($username)
	{
		$this->db->where(['username' => $username, 'user_active' => 1]);
		$query = $this->db->get('tbl_users');

		return $query->row();
	}

	function addUser($userdata)
	{
		$this->db->insert('tbl_users', $userdata);
	}
	
}