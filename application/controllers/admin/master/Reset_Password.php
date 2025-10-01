<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_Password extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dbhelper');
        $this->load->model('kesiswaan/Siswa_model');

        // Check if user is logged in as admin
        $session = $this->session->userdata('user_dashboard');
        if (empty($session)) {
            redirect('login_dashboard');
        }

        $this->own_link = admin_url('reset_password');
    }

    public function index() {
        $data['judul'] = 'Reset Password Siswa';
        $data['subjudul'] = 'Daftar Siswa';
        $data['own_link'] = $this->own_link;

        $this->template->_v('master/reset_password/index', $data);
    }

    public function datatables() {
        $list = $this->Siswa_model->get_datatables(0);
        $data = array();
        $no = isset($_POST['start']) ? $_POST['start'] : 0;

        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nisn;
            $row[] = $field->nama;
            $row[] = convDate($field->tanggal_lahir);
            $row[] = $field->tahun_ajaran;
            $row[] = !empty($field->kelas) ? $field->kelas : '-';

            // Action buttons - escape nama untuk menghindari masalah JavaScript
            $nama_escaped = htmlspecialchars($field->nama, ENT_QUOTES, 'UTF-8');
            $action = '<button type="button" class="btn btn-warning btn-sm" onclick="resetPassword('.$field->id.', \''.$nama_escaped.'\')">
                        <i class="fa fa-key"></i> Reset Password
                       </button>';

            $row[] = $action;
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
            "recordsTotal" => $this->Siswa_model->count_all(0),
            "recordsFiltered" => $this->Siswa_model->count_filtered(0),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function submit() {
        $siswa_id = $this->input->post('siswa_id');
        $siswa_nama = $this->input->post('siswa_nama');

        if (empty($siswa_id)) {
            $this->session->set_flashdata('error', 'Siswa ID tidak valid');
            redirect($this->own_link);
            return;
        }

        // Get siswa data
        $siswa = $this->Siswa_model->findSiswa($siswa_id);

        if (empty($siswa)) {
            $this->session->set_flashdata('error', 'Data siswa tidak ditemukan');
            redirect($this->own_link);
            return;
        }

        // Generate default password same as create siswa: negrac#ddmmyyyy
        $default_password = "negrac#" . date('dmY', strtotime($siswa['tanggal_lahir']));
        $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

        // Get user_id from mt_users_siswa
        $siswa_detail = $this->Dbhelper->selectTabelOne('users_id', 'mt_users_siswa', array('id' => $siswa_id));

        if (empty($siswa_detail) || empty($siswa_detail['users_id'])) {
            $this->session->set_flashdata('error', 'User ID tidak ditemukan untuk siswa ini');
            redirect($this->own_link);
            return;
        }

        $users_id = $siswa_detail['users_id'];

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
                $this->session->set_flashdata('success', 'Password berhasil direset untuk siswa: ' . $siswa['nama']);
                $this->session->set_flashdata('password', $default_password);
            } else {
                $this->session->set_flashdata('error', 'Gagal mereset password. Silakan coba lagi');
            }
        } else {
            $this->session->set_flashdata('error', 'Akun user tidak ditemukan untuk siswa ini');
        }

        redirect($this->own_link);
    }
}