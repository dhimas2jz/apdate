<?php
// Load PhpSpreadsheet only if vendor/autoload.php exists
if (file_exists(FCPATH . 'vendor/autoload.php')) {
	require_once FCPATH . 'vendor/autoload.php';
}
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
class Siswa extends CI_Controller {
	var $menu_id = "";
	var $session_data = "";
	var $user_access_detail = "";
	var $table = "";
	var $judul = "";
	public function __Construct() {
		parent::__construct();
		$this->menu_id = 8;
		$this->session_data = $this->session->userdata('user_dashboard');
		// $this->user_access_detail = $this->session_data['user_access_detail'];

		$this->cekLogin();
		$this->own_link = admin_url('kesiswaan/siswa');
		$this->load->model('kesiswaan/Siswa_model');
		$this->table = "mt_users_siswa";
		$this->judul = "Siswa";
	}

	public function index() {
		$active_periode = active_periode();
		$user_access_detail = $this->user_access_detail;
		// $is_create 			= $user_access_detail[$this->menu_id]["is_create"];
		$is_create = 1;

		$data['judul'] 		= $this->judul;
		$data['subjudul'] 	= 'List Data';
		$data['own_link'] 	= $this->own_link;
		$data['is_create'] 	= $is_create;
		$data['active_periode'] = $active_periode;
		$this->template->_v('kesiswaan/siswa/index', $data);
	}

	public function datatables() {
		$user_access_detail = $this->user_access_detail;
		$list = $this->Siswa_model->get_datatables();
        $data = array();
        $no = isset($_POST['start']) ? $_POST['start'] : 0;
        foreach ($list as $field) {
            $no++;
            $row_menu = array();
            $row_menu[] = $no;
            $row_menu[] = $field->nisn;
            $row_menu[] = $field->nama;
            $row_menu[] = $field->tanggal_lahir;
            $row_menu[] = 'Tahun Ajaran '.$field->tahun_ajaran;
            $row_menu[] = $field->kelas;
            // $row_menu[] = $field->is_active == 1 ? '<span class="p-2 bg-success">Aktif</span>' : '<span class="p-2 bg-secondary">Non Aktif</span>';

            $btn_update = "";
            $btn_delete = "";
        	// if ($user_access_detail[$this->menu_id]['is_update'] == 1) {
            	$btn_update = '<a href="'.$this->own_link.'/edit/'.$field->id.'" class="btn btn-info btn-sm btn-flat mb-2 mb-sm-0"><i class="fas fa-edit"></i></a>';
            // }
            // if ($user_access_detail[$this->menu_id]['is_delete'] == 1) {
            	$btn_delete = '<a onclick="deleteConfirm(`'.$field->id.'`)" data-id="'.$field->id.'" href="javascript:void(0)" class="btn btn-danger btn-sm btn-flat delete"><i class="fas fa-trash"></i></a>';
            // }
            $action = $btn_update." ".$btn_delete;
            $row_menu[] = $action;
            $data[] = $row_menu;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Siswa_model->count_all(),
            "recordsFiltered" => $this->Siswa_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function create() {
		$this->privilege('is_create');
		$periode = $this->Dbhelper->selectTabelOne('id, tahun_ajaran', 'mt_periode', array("is_active" => 1));

		$data['judul'] 		= $this->judul;
		$data['subjudul'] = 'Create Data';
		$data['own_link'] = $this->own_link;

		$data['action']		= "do_create";
		$data['periode']	= $periode;

		$this->template->_v('kesiswaan/siswa/form', $data);
	}

	public function edit($id) {
		$id = (int) $id;
		$this->privilege('is_update');
        $model = $this->Siswa_model->find($id);
        if (empty($model)) {
			$this->session->set_flashdata('error', "Data not found");
        	return redirect($this->own_link);
        }

		$periode = $this->Dbhelper->selectTabelOne('id, tahun_ajaran', 'mt_periode', array("id" => $model->join_periode_id));
		$data['judul'] 			= $this->judul;
		$data['subjudul'] 		= 'Edit Data';
		$data['own_link'] 		= $this->own_link;
		$data['periode']		= $periode;


		$data['model']			= $model;
		$data['action']			= "do_update";

		$this->template->_v('kesiswaan/siswa/form', $data);
	}

	public function do_update() {
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();

			$id = (int) $post["id"];
			$this->privilege('is_update');
			$post_data = [];
			foreach ($post as $key => $value) {
				$val = dbClean($value);
				$post_data[$key] = $val;
			}
			$validation 	= $this->validation($post_data);
			$htmlMessage 	= "";
			if (count($validation) > 0) {
				$htmlMessage .= "<ul>";
				foreach ($validation as $value) {
					$htmlMessage .= "<li>".$value."</li>";
				}
				$htmlMessage .= "</ul>";
				$this->session->set_flashdata('alert', $htmlMessage);
				return redirect($this->own_link."/edit/".$id);
			}
			// $post_data["updated_at"] = date("Y-m-d H:i:s");
			unset($post_data["id"]);
			$save = $this->Dbhelper->updateData($this->table, array('id'=>$id), $post_data);
			if ($save) {
				$this->session->set_flashdata('success', "Update data success");
				return redirect($this->own_link."/edit/".$id);
			}
			$this->session->set_flashdata('error', "Update data failed");
			return redirect($this->own_link."/edit/".$id);
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect($this->own_link);
	}

	public function do_create() {
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();

			$id = (int) $post["id"];
			$this->privilege('is_create');
			$post_data = [];
			foreach ($post as $key => $value) {
				$val = dbClean($value);
				$post_data[$key] = $val;
			}
			$validation 	= $this->validation($post_data);
			$htmlMessage 	= "";
			if (count($validation) > 0) {
				$htmlMessage .= "<ul>";
				foreach ($validation as $value) {
					$htmlMessage .= "<li>".$value."</li>";
				}
				$htmlMessage .= "</ul>";
				$this->session->set_flashdata('alert', $htmlMessage);
				return redirect($this->own_link."/create");
			}
			unset($post_data["id"]);
			$siswa_data 	= $post_data;

			$password = "negrac#" . date('dmY', strtotime($siswa_data["tanggal_lahir"]));
			$users_data 			= [
				"user_group_id"	=> 3,
				"username"			=> $siswa_data['nisn'],
				"name"					=> $siswa_data['nama'],
				"email"					=> "",
				"password"			=> password_hash($password, PASSWORD_DEFAULT),
				"password_raw"	=> $password,
				"created_at"		=> date('Y-m-d H:i:s')
			];

			$usersID = $this->Dbhelper->insertDataWithReturnID('m_users', $users_data, 'id');
			$siswa_data['users_id'] = $usersID;

			$save = $this->Dbhelper->insertData($this->table, $siswa_data);
			if ($save) {
				$this->session->set_flashdata('success', "Create data success");
				return redirect($this->own_link);
			}
			$this->session->set_flashdata('error', "Create data failed");
			return redirect($this->own_link."/create");
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect($this->own_link);
	}

	public function delete($id) {
		// $this->privilege('is_delete');
		$id = (int) $id;

		$active_periode = active_periode();
		$active_siswa = $this->Siswa_model->find_active_siswa($active_periode['periode_id'], $id);
		// dd($active_periode, $active_siswa);
		if (!empty($active_siswa)) {
			$this->session->set_flashdata('error', "Data siswa sedang aktif di periode ".$active_periode['tahun_ajaran'].", tidak dapat dihapus.");
			return redirect($this->own_link);
		}

		$model = $this->Siswa_model->find($id);
    if (empty($model)) {
			$this->session->set_flashdata('error', "Data not found");
    	return redirect($this->own_link);
    }

    $deleted_at = date("Y-m-d H:i:s");

    // Mulai transaction dengan mode strict
    $this->db->trans_strict(TRUE);
    $this->db->trans_start();

    // 1. Hapus data siswa utama (soft delete)
    $this->db->where('id', $id);
    $this->db->update($this->table, array("deleted_at" => $deleted_at));

    // 2. Hapus data user terkait (soft delete)
    $this->db->where('id', $model->users_id);
    $this->db->update('m_users', array("deleted_at" => $deleted_at));

    // 3. Hapus data orang tua siswa (hard delete karena tidak ada deleted_at)
    $this->db->where('users_id', $model->users_id);
    $this->db->delete('mt_users_siswa_orangtua');

    // 4. Hapus data kelas siswa (hard delete)
    $this->db->where('siswa_id', $id);
    $this->db->delete('tref_kelas_siswa');

    // 5. Hapus data ekstrakulikuler siswa (hard delete)
    $this->db->where('siswa_id', $id);
    $this->db->delete('tref_kelas_siswa_ekskul');

    // 6. Hapus data grading siswa (hard delete)
    $this->db->where('siswa_id', $id);
    $this->db->delete('tr_egrading_siswa');

    // 7. Hapus data rapor siswa (hard delete)
    $this->db->where('siswa_id', $id);
    $this->db->delete('tr_rapor');

    // 8. Hapus data absensi siswa (hard delete)
    $this->db->where('siswa_id', $id);
    $this->db->delete('tref_pertemuan_absensi');

    // 9. Hapus data tugas siswa (hard delete)
    $this->db->where('siswa_id', $id);
    $this->db->delete('tref_pertemuan_tugas');

    // 10. Hapus data diskusi siswa (hard delete)
    $this->db->where('siswa_id', $id);
    $this->db->delete('tref_pertemuan_diskusi');

    // 11. Hapus data aspirasi siswa (soft delete jika ada deleted_at)
    $this->db->where('siswa_id', $id);
    $this->db->update('tref_aspirasi', array("deleted_at" => $deleted_at));

    // 12. Hapus data konseling siswa (soft delete jika ada deleted_at)
    $this->db->where('siswa_id', $id);
    $this->db->update('tref_konseling', array("deleted_at" => $deleted_at));

    // Selesaikan transaction
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
    	$this->session->set_flashdata('error', "Gagal menghapus data siswa. Terjadi kesalahan database.");
    	return redirect($this->own_link);
    }

    $this->session->set_flashdata('success', "Data siswa dan semua data terkait berhasil dihapus");
    return redirect($this->own_link);
	}

	public function export() {
		if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
			$this->session->set_flashdata('error', 'PhpSpreadsheet library tidak tersedia. Silakan install composer dependencies terlebih dahulu.');
			return redirect($this->own_link);
		}
		$list = $this->Siswa_model->all();
		$this->toExcel($list);
		die();
	}

	public function template() {
		if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
			// Fallback ke template lama jika PhpSpreadsheet tidak tersedia
			force_download('assets/template_siswa.xlsx',NULL);
			return;
		}

		// Generate template baru dengan field lengkap sesuai urutan form
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Style untuk header
		$styleHeader = [
			'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
			'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
			'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
		];

		// Set header columns sesuai urutan form
		// DATA PRIBADI
		$sheet->setCellValue('A1', 'NISN *');
		$sheet->setCellValue('B1', 'Nomor Induk');
		$sheet->setCellValue('C1', 'Nama Lengkap *');
		$sheet->setCellValue('D1', 'Tempat Lahir');
		$sheet->setCellValue('E1', 'Tanggal Lahir *');
		$sheet->setCellValue('F1', 'Jenis Kelamin');
		$sheet->setCellValue('G1', 'Agama');
		$sheet->setCellValue('H1', 'Status Keluarga');
		$sheet->setCellValue('I1', 'Anak Ke');
		// DATA PENDIDIKAN
		$sheet->setCellValue('J1', 'Sekolah Asal');
		$sheet->setCellValue('K1', 'Tanggal Diterima');
		$sheet->setCellValue('L1', 'Diterima di Kelas');
		// KONTAK
		$sheet->setCellValue('M1', 'Nomor HP');
		$sheet->setCellValue('N1', 'Alamat');
		// DATA ORANG TUA
		$sheet->setCellValue('O1', 'Nama Orang Tua');
		$sheet->setCellValue('P1', 'Hubungan Keluarga');
		$sheet->setCellValue('Q1', 'Alamat Orang Tua');
		$sheet->setCellValue('R1', 'Nomor HP Orang Tua');
		$sheet->setCellValue('S1', 'Email Orang Tua');
		$sheet->setCellValue('T1', 'Pekerjaan Orang Tua');

		// Apply style ke header
		$sheet->getStyle('A1:T1')->applyFromArray($styleHeader);

		// Set column widths
		$sheet->getColumnDimension('A')->setWidth(15);
		$sheet->getColumnDimension('B')->setWidth(15);
		$sheet->getColumnDimension('C')->setWidth(25);
		$sheet->getColumnDimension('D')->setWidth(15);
		$sheet->getColumnDimension('E')->setWidth(15);
		$sheet->getColumnDimension('F')->setWidth(15);
		$sheet->getColumnDimension('G')->setWidth(12);
		$sheet->getColumnDimension('H')->setWidth(18);
		$sheet->getColumnDimension('I')->setWidth(10);
		$sheet->getColumnDimension('J')->setWidth(20);
		$sheet->getColumnDimension('K')->setWidth(15);
		$sheet->getColumnDimension('L')->setWidth(15);
		$sheet->getColumnDimension('M')->setWidth(15);
		$sheet->getColumnDimension('N')->setWidth(30);
		$sheet->getColumnDimension('O')->setWidth(25);
		$sheet->getColumnDimension('P')->setWidth(18);
		$sheet->getColumnDimension('Q')->setWidth(30);
		$sheet->getColumnDimension('R')->setWidth(15);
		$sheet->getColumnDimension('S')->setWidth(25);
		$sheet->getColumnDimension('T')->setWidth(20);

		// Add contoh data
		$sheet->setCellValue('A2', '1234567890');
		$sheet->setCellValue('B2', 'NIS001');
		$sheet->setCellValue('C2', 'Nama Siswa Contoh');
		$sheet->setCellValue('D2', 'Jakarta');
		$sheet->setCellValue('E2', '2010-01-15');
		$sheet->setCellValue('F2', 'Laki-laki');
		$sheet->setCellValue('G2', 'Islam');
		$sheet->setCellValue('H2', 'Anak Kandung');
		$sheet->setCellValue('I2', '1');
		$sheet->setCellValue('J2', 'SD Negeri 1');
		$sheet->setCellValue('K2', '2023-07-01');
		$sheet->setCellValue('L2', 'VII');
		$sheet->setCellValue('M2', '08123456789');
		$sheet->setCellValue('N2', 'Jl. Contoh No. 123');
		$sheet->setCellValue('O2', 'Nama Orang Tua');
		$sheet->setCellValue('P2', 'Ayah');
		$sheet->setCellValue('Q2', 'Jl. Contoh No. 123');
		$sheet->setCellValue('R2', '08123456789');
		$sheet->setCellValue('S2', 'orangtua@email.com');
		$sheet->setCellValue('T2', 'PNS');

		// Add note
		$sheet->setCellValue('A3', 'Catatan:');
		$sheet->mergeCells('A3:T3');
		$sheet->setCellValue('A4', '* Field wajib diisi');
		$sheet->mergeCells('A4:T4');
		$sheet->setCellValue('A5', 'Format Tanggal: YYYY-MM-DD (contoh: 2010-01-15)');
		$sheet->mergeCells('A5:T5');
		$sheet->setCellValue('A6', 'Jenis Kelamin: Laki-laki atau Perempuan');
		$sheet->mergeCells('A6:T6');
		$sheet->setCellValue('A7', 'Diterima di Kelas: VII, VIII, atau IX');
		$sheet->mergeCells('A7:T7');

		$sheet->getStyle('A3:A7')->getFont()->setItalic(true)->setSize(9);
		$sheet->getStyle('A3:A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

		$writer = new Xlsx($spreadsheet);
		$filename = 'template_siswa_lengkap.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'. $filename .'"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		exit;
	}

	public function import() {
	if ($this->input->server('REQUEST_METHOD') === 'POST') {
		if (!class_exists('PhpOffice\PhpSpreadsheet\IOFactory')) {
			$this->session->set_flashdata('error', 'PhpSpreadsheet library tidak tersedia. Silakan install composer dependencies terlebih dahulu.');
			return redirect($this->own_link);
		}

		if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
			set_time_limit(600);
			$fileTmpPath = $_FILES['file']['tmp_name'];
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileTmpPath);
			$sheet = $spreadsheet->getActiveSheet();

			// 1. Menambahkan kolom siswa lengkap dan orang tua ke $headcol
			$headcol = [
								"A"	=> "nisn",
                "B" => "nomor_induk",
                "C" => "nama",
                "D" => "tempat_lahir",
                "E" => "tanggal_lahir",
                "F" => "jenis_kelamin",
                "G" => "agama",
                "H" => "status_keluarga",
                "I" => "anak_ke",
								"J" => "sekolah_asal",
								"K" => "tanggal_diterima",
								"L" => "kelas_diterima",
								"M" => "nomor_hp",
                "N" => "alamat",
                // Kolom untuk data orang tua
                "O" => "nama_lengkap_orangtua",
                "P" => "hubungan_keluarga",
                "Q" => "alamat_orangtua",
                "R" => "nomor_hp_orangtua",
                "S" => "email_orangtua",
                "T" => "pekerjaan_orangtua",
            ];

            $rowsDataSiswa = [];
            $rowsDataOrangtua = [];
            $rowsUsersData = [];
            $nisn_list = [];
            
            $periode_list = [];
            $kelas_list = [];

			$active_periode = active_periode();
			// dd($active_periode);

            // Memulai iterasi dari baris ke-2 (untuk melewati header)
            foreach ($sheet->getRowIterator() as $i => $row) {
				if ($i > 1) {
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);
					$rowData = [];
					foreach ($cellIterator as $index_headcol => $cell) {
						if (isset($headcol[$index_headcol])) {
							$value = trim($cell->getValue());
							if ($index_headcol == "A") { // NISN
								if (empty($value)) continue 2; // Lewati baris jika NISN kosong
								$rowData['nisn'] = $value;
							}
							if ($index_headcol == "E") { // Tanggal Lahir
								if (!empty($value) && is_numeric($value)) {
									$timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value);
									$value = date('Y-m-d', $timestamp);
								}
							}
							if ($index_headcol == "K") { // Tanggal Diterima
								if (!empty($value) && is_numeric($value)) {
									$timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value);
									$value = date('Y-m-d', $timestamp);
								}
							}
							$rowData[$headcol[$index_headcol]] = $value;
						}
					}

					// Hanya proses jika ada NISN
					if (!empty($rowData['nisn'])) {
						$nisn_list[] = $rowData['nisn'];

						// Menyiapkan data untuk tabel m_users
						$password_raw = 'negrac#' . date('dmY', strtotime($rowData['tanggal_lahir']));
						$rowsUsersData[] = [
							"user_group_id" => 3,
							"username"      => $rowData["nisn"],
							"name"          => $rowData["nama"],
							"password"      => password_hash($password_raw, PASSWORD_DEFAULT),
							"password_raw"  => $password_raw,
							"created_at"    => date('Y-m-d H:i:s'),
							"updated_at"    => date('Y-m-d H:i:s'),
						];

						$rowSiswa = $rowData;
						// Menyimpan data siswa dan orang tua dengan key NISN untuk relasi nanti
						unset($rowSiswa['nama_lengkap_orangtua']);
						unset($rowSiswa['hubungan_keluarga']);
						unset($rowSiswa['alamat_orangtua']);
						unset($rowSiswa['nomor_hp_orangtua']);
						unset($rowSiswa['email_orangtua']);
						unset($rowSiswa['pekerjaan_orangtua']);

						$rowSiswa['join_periode_id'] = $active_periode['periode_id'];
						$rowsDataSiswa[$rowData["nisn"]] = $rowSiswa;

						// 2. Menyiapkan data untuk tabel orang tua
						$rowsDataOrangtua[$rowData["nisn"]] = [
							'nama_lengkap'      => $rowData['nama_lengkap_orangtua'],
							'hubungan_keluarga' => $rowData['hubungan_keluarga'],
							'alamat'            => $rowData['alamat_orangtua'],
							'nomor_hp'          => $rowData['nomor_hp_orangtua'],
							'email'             => $rowData['email_orangtua'],
							'pekerjaan'         => $rowData['pekerjaan_orangtua'],
						];
					}
                }
            }

			// Validasi duplikat NISN sekaligus sebelum insert (DI LUAR LOOP)
			// Hanya cek data yang belum dihapus (deleted_at IS NULL)
			if (!empty($nisn_list)) {
				// Cek duplikat di tabel mt_users_siswa
				$this->db->select('nisn');
				$this->db->from('mt_users_siswa');
				$this->db->where_in('nisn', $nisn_list);
				$this->db->where('deleted_at IS NULL', NULL, FALSE);
				$existing_nisn = $this->db->get()->result_array();

				if (!empty($existing_nisn)) {
					$duplikat = array_column($existing_nisn, 'nisn');
					$this->session->set_flashdata('error', 'Error: Duplikat NISN yang masih aktif di database: ' . implode(', ', $duplikat));
					return redirect($this->own_link);
				}

				// Cek duplikat di tabel m_users (username)
				$this->db->select('username');
				$this->db->from('m_users');
				$this->db->where_in('username', $nisn_list);
				$this->db->where('deleted_at IS NULL', NULL, FALSE);
				$existing_username = $this->db->get()->result_array();

				if (!empty($existing_username)) {
					$duplikat = array_column($existing_username, 'username');
					$this->session->set_flashdata('error', 'Error: Username (NISN) sudah digunakan: ' . implode(', ', $duplikat));
					return redirect($this->own_link);
				}
			}

            // 3. Menggunakan Transaction untuk keamanan data
            $this->db->trans_start();

            // Insert batch ke m_users
            $this->db->insert_batch("m_users", $rowsUsersData);

            // Ambil data user yang baru saja di-insert untuk mendapatkan ID-nya
            // PENTING: Hanya ambil yang BARU di-insert (deleted_at IS NULL dan created_at paling baru)
            $get_users = $this->db->where_in('username', $nisn_list)
                                  ->where('deleted_at IS NULL', NULL, FALSE)
                                  ->order_by('id', 'DESC')
                                  ->from('m_users')
                                  ->get()
                                  ->result_array();

            // Deduplikasi berdasarkan username untuk memastikan hanya 1 user per NISN
            $unique_users = [];
            foreach ($get_users as $user) {
                if (!isset($unique_users[$user['username']])) {
                    $unique_users[$user['username']] = $user;
                }
            }
            $get_users = array_values($unique_users);
            
            if (!empty($get_users)) {
                $finalSiswaData = [];
                $finalOrangtuaData = [];

                foreach ($get_users as $user) {
                    $nisn = $user['username'];
                    
                    // Menambahkan users_id ke data siswa
                    if (isset($rowsDataSiswa[$nisn])) {
                        $rowsDataSiswa[$nisn]['users_id'] = $user['id'];
                        $finalSiswaData[] = $rowsDataSiswa[$nisn];
                    }
                    
                    // Menambahkan users_id ke data orang tua
                    if (isset($rowsDataOrangtua[$nisn])) {
                        $rowsDataOrangtua[$nisn]['users_id'] = $user['id'];
                        $finalOrangtuaData[] = $rowsDataOrangtua[$nisn];
                    }
                }
                
                // Insert batch ke tabel siswa dan orang tua
                if (!empty($finalSiswaData)) {
                    $this->db->insert_batch("mt_users_siswa", $finalSiswaData);
                }
                if (!empty($finalOrangtuaData)) {
                    $this->db->insert_batch("mt_users_siswa_orangtua", $finalOrangtuaData);
                }
            }
            
            // 4. Finalisasi Transaction
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', "Gagal mengimpor data siswa. Terjadi kesalahan database.");
            } else {
                $this->session->set_flashdata('success', "Berhasil mengimpor " . count($rowsUsersData) . " data siswa dan orang tua.");
            }
            return redirect($this->own_link);
        }
        $this->session->set_flashdata('error', "Gagal mengunggah file.");
        return redirect($this->own_link);
    }
    
    $this->session->set_flashdata('error', "Akses ditolak.");
    return redirect($this->own_link);
}

	// CHANGE NECESSARY POINT
	private function toExcel($data = null) {
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $styleBoldCenter = [
		    'font' => [
		        'bold' => true,
		        'size' => 12
		    ],
		    'alignment' => [
		        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
		    ],
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
		            'color' => ['argb' => '00000000'],
		        ],
		    ],
		];

		$styleBorder = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
		            'color' => ['argb' => '00000000'],
		        ],
		    ],
		];
		$rowCell = 1;
		$sheet->setCellValue("A".$rowCell, "NO");
		$sheet->setCellValue("B".$rowCell, "NISN");
		$sheet->setCellValue("C".$rowCell, "NAMA");
		$sheet->setCellValue("D".$rowCell, "TANGGAL LAHIR");
		$sheet->setCellValue("E".$rowCell, "PERIODE BERGABUNG");
		$sheet->setCellValue("F".$rowCell, "KELAS SAAT INI");

		$sheet->getStyle('A'.$rowCell.':F'.$rowCell)->applyFromArray($styleBorder);
		$rowCell++;
        $no = 1;
        if (!empty($data)) {
        	foreach ($data as $items) {
	        	$item = (object) $items;
	        	$sheet->setCellValue("A".$rowCell, $no);
	        	$sheet->setCellValue("B".$rowCell, $item->nisn);
	        	$sheet->setCellValue("C".$rowCell, $item->nama);
	        	$sheet->setCellValue("D".$rowCell, date('Y-m-d', strtotime($item->tanggal_lahir)));
	        	$sheet->setCellValue("E".$rowCell, $item->tahun_ajaran);
	        	$sheet->setCellValue("F".$rowCell, $item->kelas);

	        	$sheet->getStyle('A'.$rowCell.':F'.$rowCell)->applyFromArray($styleBorder);

	        	$no++;
		        $rowCell++;
	        }
        }
        
        $writer = new Xlsx($spreadsheet);
 	
 		$today = strtotime('now');
        $filename = 'data-siswa-'.$today;
 
        ob_end_clean();
 
        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
	}

	private function toPDF($kode_klasifikasi, $data = null) {
		$header_html = '
			<center>
				<h2><strong>Daftar Draft Arsip '.$kode_klasifikasi->name.' - '.$kode_klasifikasi->description.'</strong></h2>
				<h3><strong>LIPI BOGOR</strong></h3>
			</center>
		';
		$table = '';
		if (!empty($data)) {
			$no = 1;
			$table = '<table width="100%"" style="border-collapse: collapse">';
			$header_table = '
				<tr>
					<td align="center" rowspan="2" style="border:1px solid black;">NO</td>
					<td align="center" rowspan="1" colspan="3" style="border:1px solid black;">JENIS/SERI ARSIP</td>
					<td align="center" rowspan="2" style="border:1px solid black;">TINGKAT PERKEMBANGAN</td>
					<td align="center" rowspan="2" style="border:1px solid black;">KURUN WAKTU</td>
					<td align="center" rowspan="2" style="border:1px solid black;">JUMLAH (LEMBAR)</td>
					<td align="center" rowspan="2" style="border:1px solid black;">KETERANGAN NASIB AKHIR</td>
				</tr>
				<tr>
					<td align="center" style="border:1px solid black;">KODE KLASIFIKASI</td>
					<td align="center" style="border:1px solid black;">URAIAN INFORMASI BERKAS</td>
					<td align="center" style="border:1px solid black;">URAIAN INFORMASI ARSIP</td>
				</tr>
			';
			$table .= $header_table;
			$body_table = '';
			foreach ($data as $items) {
				$item = (object) $items;

	        	$lembar = "0 Lembar";
	        	if (is_numeric($item->jumlah_lembar) && $item->jumlah_lembar > 0) {
	        		$lembar = $item->jumlah_lembar." Lembar";
	        	}

	        	$body_table .= '<tr>';
	        		$body_table .= '<td align="center" style="border:1px solid black;">'.$no.'</td>';
	        		$body_table .= '<td align="center" style="border:1px solid black;">'.$kode_klasifikasi->name.'</td>';
	        		$body_table .= '<td align="center" style="border:1px solid black;">'.$kode_klasifikasi->description.'</td>';
	        		$body_table .= '<td align="center" style="border:1px solid black;">'.$item->uraian_informasi_arsip.'</td>';
	        		$body_table .= '<td align="center" style="border:1px solid black;">'.$item->tingkat_perkembangan.'</td>';
	        		$body_table .= '<td align="center" style="border:1px solid black;">'.$item->kurun_waktu.'</td>';
	        		$body_table .= '<td align="center" style="border:1px solid black;">'.$lembar.'</td>';
	        		$body_table .= '<td align="center" style="border:1px solid black;">'.$item->keterangan.'</td>';
	        	$body_table .= '</tr>';

	        	$no++;
	        }
	        $table .= $body_table;
			$table .= "</table>";
			unset($body_table);
			unset($header_table);
		}
		$html = $header_html.$table;
		$today = strtotime('now');
        $filename = 'arsip-'.$kode_klasifikasi->name.'-'.$today;
        
        // Load pdf library
        $this->load->library('pdf');
        
        // Load HTML content
        $this->dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'landscape');
        
        // Render the HTML as PDF
        $this->dompdf->render();
        
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream($filename.".pdf", array("Attachment"=>0));
	}

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
