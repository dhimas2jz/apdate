<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_Password extends CI_Controller {
    public function index() {
        // Tampilkan form reset password
        $this->load->view('admin/master/reset_password/index');
    }

    public function submit() {
        // Proses reset password di sini
        $email = $this->input->post('email');
        // Validasi dan proses reset password...
        // Redirect atau tampilkan pesan
    }
}