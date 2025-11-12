<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aspirasi extends CI_Controller {
	var $menu_id = "";
	var $session_data = "";
	var $user_access_detail = "";
	var $table = "";
	var $judul = "";
	public function __Construct() {
		parent::__construct();
		$this->menu_id = 44;
		$this->session_data = $this->session->userdata('user_dashboard');
		// $this->user_access_detail = $this->session_data['user_access_detail'];

		$this->cekLogin();
		$this->own_link = admin_url('aspirasi');
		$this->load->model('Aspirasi_model');
		$this->table = "tref_aspirasi";
		$this->judul = "Aspirasi Siswa";
	}

	public function index() {
		// Get aspirasi setting
		$aspirasi_setting = $this->db->where('code', 'aspirasi_status')->get('mt_setting_lms')->row_array();

		$data['judul'] 		= $this->judul;
		$data['subjudul'] 	= 'List Aspirasi';
		$data['own_link'] 	= $this->own_link;
		$data['aspirasi_setting'] = $aspirasi_setting;
		$this->template->_v('aspirasi', $data);
	}

	public function do_update() {
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			$aspirasi_status = isset($post['aspirasi_status']) ? $post['aspirasi_status'] : '';

			$this->db->trans_begin();
			try {
				$update = $this->db->where('code', 'aspirasi_status')->update('mt_setting_lms', ['value' => $aspirasi_status]);
				if (!$update) {
					throw new Exception("Gagal mengubah setting menu aspirasi");
				}

				$this->db->trans_commit();
				success('Perubahan berhasil disimpan');
			} catch (Exception $e) {
				$this->db->trans_rollback();
				error($e->getMessage());
			}
		}
		badrequest('Method not allowed');
	}

	public function datatables() {
		$user_access_detail = $this->user_access_detail;
		$list = $this->Aspirasi_model->get_datatables();
        $data = array();
        $no = isset($_POST['start']) ? $_POST['start'] : 0;
        foreach ($list as $field) {
            $no++;
            $row_menu = array();
            $row_menu[] = $no;
            $row_menu[] = $field->nisn.' - '.$field->nama;
            $row_menu[] = $field->kelas;
						$row_menu[] = $field->judul;
						$row_menu[] = $field->deskripsi;
						$row_menu[] = date('d-m-Y H:i:s', strtotime($field->created_at));
            $data[] = $row_menu;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Aspirasi_model->count_all(),
            "recordsFiltered" => $this->Aspirasi_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	// CHANGE NECESSARY POINT
	private function cekLogin() {
		$session = $this->session_data;
		if (empty($session)) {
			redirect('login_dashboard');
		}

		// $user_access = $session['user_access'];
		// if (!in_array($this->menu_id, $user_access)) {
		// 	redirect('dashboard');
		// }
	}

	private function validation($post_data) {
		$errMessage 	= [];
		$id 			= $post_data["id"];
		// $name			= $post_data["name"];

		if (!empty($id)) {
			$data = $this->Siswa_model->find($id);
			if (empty($data)) {
				$this->session->set_flashdata('error', "Data not found");
	        	return redirect($this->own_link);
	        }
		}

		// if (empty($name)) {
		// 	$errMessage[] = "Name is required";
		// }

		return $errMessage;
	}
	
	private function privilege($field, $id = null) {
		// $user_access_detail = $this->user_access_detail;
		// if ($user_access_detail[$this->menu_id][$field] != 1) {
		// 	$this->session->set_flashdata('error', "Access denied");
        // 	return redirect($this->own_link);
        // }
	}
}
