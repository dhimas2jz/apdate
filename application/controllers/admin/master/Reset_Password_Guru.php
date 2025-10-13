<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_Password_Guru extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dbhelper');
        $this->load->model('kesiswaan/Guru_model');

        // Check if user is logged in as admin
        $session = $this->session->userdata('user_dashboard');
        if (empty($session)) {
            redirect('login_dashboard');
        }

        $this->own_link = admin_url('reset_password_guru');
    }

    public function index() {
        $data['judul'] = 'Reset Password Guru';
        $data['subjudul'] = 'Daftar Guru';
        $data['own_link'] = $this->own_link;

        $this->template->_v('master/reset_password_guru/index', $data);
    }

    public function datatables() {
        $list = $this->Guru_model->get_datatables();
        $data = array();
        $no = isset($_POST['start']) ? $_POST['start'] : 0;

        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nip;
            $row[] = $field->nama;
            $row[] = $field->email;
            $row[] = $field->nomor_hp;
            $row[] = $field->tahun_ajaran;

            // Action buttons - escape nama untuk menghindari masalah JavaScript
            $nama_escaped = htmlspecialchars($field->nama, ENT_QUOTES, 'UTF-8');
            $nip_escaped = htmlspecialchars($field->nip, ENT_QUOTES, 'UTF-8');
            $action = '<button type="button" class="btn btn-warning btn-sm" onclick="resetPassword('.$field->id.', \''.$nama_escaped.'\', \''.$nip_escaped.'\')">
                        <i class="fa fa-key"></i> Reset Password
                       </button>';

            $row[] = $action;
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
            "recordsTotal" => $this->Guru_model->count_all(),
            "recordsFiltered" => $this->Guru_model->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function submit() {
        $guru_id = $this->input->post('guru_id');
        $guru_nama = $this->input->post('guru_nama');

        if (empty($guru_id)) {
            $this->session->set_flashdata('error', 'Guru ID tidak valid');
            redirect($this->own_link);
            return;
        }

        // Get guru data
        $guru = $this->Guru_model->find($guru_id);

        if (empty($guru)) {
            $this->session->set_flashdata('error', 'Data guru tidak ditemukan');
            redirect($this->own_link);
            return;
        }

        // Generate default password: guru#6digitnomornipdaribelakang
        // Ambil 6 digit terakhir dari NIP
        $nip_last_6 = substr($guru->nip, -6);
        $default_password = "guru#" . $nip_last_6;
        $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

        // Get user_id from mt_users_guru
        $guru_detail = $this->Dbhelper->selectTabelOne('users_id', 'mt_users_guru', array('id' => $guru_id));

        if (empty($guru_detail) || empty($guru_detail['users_id'])) {
            $this->session->set_flashdata('error', 'User ID tidak ditemukan untuk guru ini');
            redirect($this->own_link);
            return;
        }

        $users_id = $guru_detail['users_id'];

        // Update password in m_users table
        $user = $this->Dbhelper->selectTabel('*', 'm_users', array('id' => $users_id));

        if (!empty($user)) {
            $update_data = array(
                'password' => $hashed_password,
                'password_raw' => $default_password,
                'updated_at' => date('Y-m-d H:i:s')
            );

            $result = $this->Dbhelper->updateData('m_users', array('id' => $users_id), $update_data);

            if ($result !== false) {
                $this->session->set_flashdata('success', 'Password berhasil direset untuk guru: ' . $guru->nama);
                $this->session->set_flashdata('password', $default_password);
            } else {
                $this->session->set_flashdata('error', 'Gagal mereset password. Silakan coba lagi');
            }
        } else {
            $this->session->set_flashdata('error', 'Akun user tidak ditemukan untuk guru ini');
        }

        redirect($this->own_link);
    }
}
