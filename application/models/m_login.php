<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{

	// cek admin
	function auth_admin($username, $password)
	{
		$query = $this->db->query("SELECT * FROM petugas WHERE username = '$username' AND password = '$password' LIMIT 1 ");
		return $query;
	}
}
