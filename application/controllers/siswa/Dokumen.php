<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumen extends CI_Controller {
	public function __Construct() {
		parent::__construct();
		$this->cekLogin();
		$this->load->model('master/Dokumen_model');
	}

	public function index() {
		$session = $this->session->userdata('user_dashboard');

		// Get all dokumen
		$listdata = $this->Dokumen_model->findAll();

		$data['judul'] 		= 'Dokumen';
		$data['subjudul'] 	= 'List Data';
		$data['listdata'] 	= $listdata;
		$this->template->_vSiswa('dokumen/index', $data);
	}

	private function cekLogin() {
		$session = $this->session->userdata('user_dashboard');
		if (empty($session)) {
			redirect('siswa/login');
		}
	}
}
