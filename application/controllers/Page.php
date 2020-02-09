<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// validasi jika user belum login
		if ($this->session->userdata('masuk') != TRUE) {
			redirect('login');
		}
	}

	public function index()
	{
		$this->load->view('v_dashboard');
	}

	public function inventaris()
	{
		$this->load->view('v_inventaris');
	}

	public function level()
	{
		$this->load->view('v_level');
	}

	public function petugas()
	{
		$this->load->view('v_petugas');
	}

	public function pegawai()
	{
		$this->load->view('v_pegawai');
	}

	public function jenis()
	{
		$this->load->view('v_jenis');
	}

	public function ruang()
	{
		$this->load->view('v_ruang');
	}

	public function peminjaman()
	{
		$this->load->view('v_peminjaman');
	}

	public function detail_pinjam()
	{
		$this->load->view('v_detail_pinjam');
	}

	// public function data_peminjaman()
	// {
	// 	// hanya boleh di akses oleh 1 dan 2
	// 	if ($this->session->userdata('akses') == 1 || $this->session->userdata('akses') == 2 || $this->session->userdata('akses') == 3) {
	// 		$this->load->view('v_peminjaman');
	// 	} else {
	// 		echo "Anda tidak berhak mengakses halaman ini";
	// 	}
	// }

	// public function pengembalian()
	// {
	// 	// function ini hanya boleh diakses oleh 1 dan 2
	// 	if ($this->session->userdata('akses') == 1 || $this->session->userdata('akses') == 2) {
	// 		$this->load->view('v_detail_pinjam');
	// 	} else {
	// 		echo "Anda tidak berhak mengakses halaman ini";
	// 	}
	// }
}

/* End of file Page.php */
/* Location: ./application/controllers/Page.php */
