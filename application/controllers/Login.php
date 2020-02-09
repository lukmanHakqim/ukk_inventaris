<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_login');
	}

	public function index()
	{
		$this->load->view('templates/login_header');
		$this->load->view('v_login');
		$this->load->view('templates/login_footer');
	}

	public function auth()
	{
		$username = htmlspecialchars($this->input->post('username', TRUE), ENT_QUOTES);
		$password = htmlspecialchars($this->input->post('password', TRUE), ENT_QUOTES);

		$cek_admin = $this->m_login->auth_admin($username, $password);

		if ($cek_admin->num_rows() > 0) {
			$data = $cek_admin->row_array();
			$this->session->set_userdata('masuk', TRUE);
			if ($data['id_level'] == 1) {
				$this->session->set_userdata('akses', 1);
				$this->session->set_userdata('ses_id', $data['username']);
				$this->session->set_userdata('ses_nama', $data['nama_petugas']);
				redirect('page');
			} else {
				$this->session->set_userdata('akses', 2);
				$this->session->set_userdata('ses_id', $data['username']);
				$this->session->set_userdata('ses_nama', $data['nama_petugas']);
				redirect('page');
			}
		} else {
			if ($cek_admin->num_rows() > 2) {
				$data = $cek_admin->row_array();
				$this->session->set_userdata('masuk', TRUE);
				$this->session->set_userdata('akses', 3);
				$this->session->set_userdata('ses_id', $data['username']);
				$this->session->set_userdata('ses_nama', $data['nama_petugas']);
				redirect('page');
			} else {
				echo $this->session->set_flashdata('msg', 'Username atau password salah!');
				redirect('login');
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		echo $this->session->set_flashdata('msg', 'You have been logged out!');
		redirect('login');
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
