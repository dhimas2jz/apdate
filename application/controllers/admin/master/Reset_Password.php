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
    }

    public function index() {
        $data['judul'] = 'Reset Password Siswa';
        $data['own_link'] = base_url('dashboard/resetpassword');

        $this->load->view('admin/layouts/header');
        $this->load->view('admin/layouts/sidebar');
        $this->load->view('admin/master/reset_password/index', $data);
        $this->load->view('admin/layouts/footer');
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

            // Action buttons
            $action = '<button type="button" class="btn btn-warning btn-sm" onclick="resetPassword('.$field->id.', \''.$field->nama.'\')">
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
        header('Content-Type: application/json');

        $siswa_id = $this->input->post('siswa_id');

        if (empty($siswa_id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Siswa ID tidak valid'
            ]);
            return;
        }

        // Get siswa data
        $siswa = $this->Siswa_model->findSiswa($siswa_id);

        if (empty($siswa)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data siswa tidak ditemukan'
            ]);
            return;
        }

        // Generate default password (NISN)
        $default_password = $siswa['nisn'];
        $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

        // Update password in m_users table
        $user = $this->Dbhelper->selectTabel('*', 'm_users', array('siswa_id' => $siswa_id));

        if (!empty($user)) {
            $update_data = array(
                'password' => $hashed_password,
                'updated_at' => date('Y-m-d H:i:s')
            );

            $result = $this->Dbhelper->updateData('m_users', array('siswa_id' => $siswa_id), $update_data);

            if ($result) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Password berhasil direset menjadi NISN: ' . $default_password
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal mereset password'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Akun user tidak ditemukan'
            ]);
        }
    }
}