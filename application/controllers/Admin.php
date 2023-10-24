<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        $this->load->library('upload' , 'pagination');
        if ($this->session->userdata('logged_in') != true || $this->session->userdata('role') != 'admin') {
            redirect(base_url());
        }
    }
    public function profile()
	{
        $data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();
		$this->load->view('admin/profile',$data);
	}
    public function karyawan()
	{
        $this->load->library('pagination');
        $config = array(
            'base_url' => site_url('admin/karyawan'),
            'total_rows' => $this->m_model->count_karyawan(),
            'per_page' => 5,
            'num_links' => 4,
            'use_page_numbers' => TRUE,
        );
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        
        $data['karyawan'] = $this->m_model->get_karyawan_page($config['per_page'], ($page - 1) * $config['per_page']);
        $data['links'] = $this->pagination->create_links();
		$this->load->view('admin/karyawan',$data);
	}
    public function hapus_karyawan($id)
{
   $this->m_model->delete('user', 'id', $id);
    redirect(base_url('admin/data_karyawan'));
}
public function hapus_absen($id)
{ 
    $this->m_model->delete('absen', 'id_karyawan', $id); 
    switch($this->uri->segment(2)){
        case 'rekap_keseluruhan':
            redirect(base_url('admin/rekap_keseluruhan')); 
        case 'rekap_harian':
            redirect(base_url('admin/rekap_harian')); 
        case 'rekap_mingguan':
            redirect(base_url('admin/rekap_mingguan'));
        default:
        redirect(base_url('admin/rekap_mingguan')); 
    }
}

    // rekap bulanan
    public function rekap_bulanan() {
        $bulan = $this->input->post('bulan'); // Mengambil bulan dari input form
        $data['absensi'] = $this->m_model->get_bulanan($bulan); // Ganti dengan fungsi yang sesuai
        $this->session->set_flashdata('bulan', $bulan);
        $this->load->view('admin/rekap_bulanan', $data);
    }
    // rekap harian
    public function rekap_harian()
{
    $this->load->library('pagination'); // Memuat pustaka pagination

    $tanggal = date('Y-m-d');
    $config = array(
        'base_url' => site_url('admin/rekap_harian'),
        'total_rows' => $this->m_model->count_harian($tanggal),
        'per_page' => 10,
        'num_links' => 4,
        'use_page_numbers' => TRUE,
    );
    $config['full_tag_open'] = '<div class="pagination">';
    $config['full_tag_close'] = '</div>';

    $this->pagination->initialize($config); // Menginisialisasi objek pagination

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
    $data['data_harian'] = $this->m_model->get_harian_page($config['per_page'], ($page - 1) * $config['per_page'], $tanggal);
    $data['links'] = $this->pagination->create_links();

    $this->load->view('admin/rekap_harian', $data);
}

public function rekapPerHari() {
    $tanggal = $this->input->get('tanggal');
          $data['perhari'] = $this->m_model->getPerHari($tanggal);
          $this->load->view('admin/rekap_harian', $data);
      }
    // rekap mingguan
    public function rekap_mingguan() {
        $data['absensi'] = $this->m_model->get_mingguan(); 
        $this->load->view('admin/rekap_mingguan',$data);
    }
    // detail karyawan
    public function detail_karyawan($id)
	{
        $data['karyawan'] = $this-> m_model->get_by_id('user' , 'id', $id)->result();
		$this->load->view('admin/detail_karyawan',$data);
	}
    // dashboard
    public function dashboard()
	{
        $this->load->library('pagination');
        $config = array(
            'base_url' => site_url('admin/dashboard'),
            'total_rows' => $this->m_model->count_absen(),
            'per_page' => 10,
            'num_links' => 4,
            'use_page_numbers' => TRUE,
        );
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        $data['data_keseluruhan'] = $this->m_model->get_absen_page($config['per_page'], ($page - 1) * $config['per_page']);
        $data['links'] = $this->pagination->create_links();
        $data['karyawan'] = $this-> m_model->get_karyawan('user')->num_rows();
        $data['absen'] = $this-> m_model->get_data('absensi')->num_rows();
		$this->load->view('admin/dashboard',$data);
	}
    // ubah profile
    public function aksi_ubah_profile()
{
    $foto = $_FILES['image']['name'];
    $foto_temp = $_FILES['image']['tmp_name'];
    $password_baru = $this->input->post('password');
    $konfirmasi_password = $this->input->post('con_pass');
    $username = $this->input->post('username');
    $nama_depan = $this->input->post('nama_depan');
    $nama_belakang = $this->input->post('nama_belakang');

    if ($foto) {
        $kode = round(microtime(true) * 1000);
        $file_name = $kode . '_' . $foto;
        $upload_path = './images/' . $file_name;
        $old_file = $this->m_model->get_foto_by_id($this->session->userdata('id'));
        if ($old_file != 'User.png') {
            unlink('./images/' . $old_file);
        }
        if (move_uploaded_file($foto_temp, $upload_path)) {
            $data = [
                'image' => $file_name,
                'username' => $username,
                'nama_depan' => $nama_depan,
                'nama_belakang' => $nama_belakang,
            ];
            
            if (!empty($password_baru) && strlen($password_baru) >= 8) {
                if ($password_baru === $konfirmasi_password) {
                    $data['password'] = md5($password_baru);
                } else {
                    $this->session->set_flashdata('message', 'Password baru dan konfirmasi password harus sama');
                    redirect(base_url('admin/profile'));
                }
            }
            
            $this->session->set_userdata($data);
            $update_result = $this->m_model->update('user', $data, array('id' => $this->session->userdata('id')));
            redirect(base_url('admin/profile'));
        } else {
            // Gagal mengunggah foto baru
            redirect(base_url('admin/profile'));
        }
    } else {
        // Jika tidak ada foto yang diunggah
        $data = [
            'username' => $username,
            'nama_depan' => $nama_depan,
            'nama_belakang' => $nama_belakang,
        ];
        
        if (!empty($password_baru) && strlen($password_baru) >= 8) {
            if ($password_baru === $konfirmasi_password) {
                $data['password'] = md5($password_baru);
            } else {
                $this->session->set_flashdata('message', 'Password baru dan konfirmasi password harus sama');
                redirect(base_url('admin/profile'));
            }
        }
        
        $this->session->set_userdata($data);
        $update_result = $this->m_model->update('user', $data, array('id' => $this->session->userdata('id')));
        redirect(base_url('admin/profile'));
    }
}
// hapus foto
    public function hapus_foto()
    {
     $foto= $this->m_model->get_foto_by_id($this->session->userdata('id'));
     if($foto != 'User.png'){
        unlink('./images/' . $foto);
        $data =[
            'image' => 'User.png'
        ];
        $update_result = $this->m_model->update('user', $data, array('id' => $this->session->userdata('id')));
        redirect(base_url('admin/profile'));
     } else{
        redirect(base_url('admin/profile'));
     }
    }
    // EXPORT
    public function exportToExcel() {

        // Load autoloader Composer
        require 'vendor/autoload.php';
        
        $spreadsheet = new Spreadsheet();

        // Buat lembar kerja aktif
       $sheet = $spreadsheet->getActiveSheet();
        // Data yang akan diekspor (contoh data)
        $data = $this->m_model->get_karyawan('user')->result();
        
        // Buat objek Spreadsheet
        $headers = ['ID','NAMA DEPAN','NAMA BELAKANG','USERNAME', 'EMAIL'];
        $rowIndex = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($rowIndex, 1, $header);
            $rowIndex++;
        }
        
        // Isi data dari database
        $rowIndex = 2;
        foreach ($data as $rowData) {
            $columnIndex = 1;
            $id = '';
            $nama_depan = '';
            $nama_belakang = '';
            $username = '';
            $email = ''; 
            foreach ($rowData as $cellName => $cellData) {
                if($cellName == 'id'){
                    $id = $cellData;
                }elseif ($cellName == 'nama_depan') {
                   $nama_depan = $cellData;
                } elseif ($cellName == 'nama_belakang') {
                    $nama_belakang = $cellData;
                } elseif ($cellName == 'username') {
                    $username = $cellData;
                } elseif ($cellName == 'email') {
                    $email = $cellData;
                }
        
                // Anda juga dapat menambahkan logika lain jika perlu
                
                // Contoh: $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $cellData);
                $columnIndex++;
            }
        
            // Setelah loop, Anda memiliki data yang diperlukan dari setiap kolom
            // Anda dapat mengisinya ke dalam lembar kerja Excel di sini
            $sheet->setCellValueByColumnAndRow(1, $rowIndex, $id);
            $sheet->setCellValueByColumnAndRow(2, $rowIndex, $nama_depan);
            $sheet->setCellValueByColumnAndRow(3, $rowIndex, $nama_belakang);
            $sheet->setCellValueByColumnAndRow(4, $rowIndex, $username);
            $sheet->setCellValueByColumnAndRow(5, $rowIndex, $email);
        
            $rowIndex++;
        }
        // Auto size kolom berdasarkan konten
        foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set style header
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:' . $sheet->getHighestDataColumn() . '1')->applyFromArray($headerStyle);
        
        // Konfigurasi output Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'DATA_KARYAWAN.xlsx'; // Nama file Excel yang akan dihasilkan
        
        // Set header HTTP untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Outputkan file Excel ke browser
        $writer->save('php://output');
        
    }
    // EXPORT REKAP
    public function export_rekap() {

        // Load autoloader Composer
        require 'vendor/autoload.php';
        
        $spreadsheet = new Spreadsheet();

        // Buat lembar kerja aktif
       $sheet = $spreadsheet->getActiveSheet();
        // Data yang akan diekspor (contoh data)
         // Ambil nilai bulan yang dipilih dari form
        $data = $this->m_model->get_data('absensi')->result();
        
        // Buat objek Spreadsheet
        $headers = ['NO','NAMA KARYAWAN','KEGIATAN','TANGGAL','JAM MASUK', 'JAM PULANG' , 'KETERANGAN IZIN' , 'STATUS'];
        $rowIndex = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($rowIndex, 1, $header);
            $rowIndex++;
        }
        
        // Isi data dari database
        $rowIndex = 2;
        $no = 1;
        foreach ($data as $rowData) {
            $columnIndex = 1;
            $nama_karyawan = '';
            $kegiatan = '';
            $tanggal = '';
            $jam_masuk = '';
            $jam_pulang = '';
            $izin = ''; 
            $status = ''; 
            foreach ($rowData as $cellName => $cellData) {
                if ($cellName == 'kegiatan') {
                   $kegiatan = $cellData;
                } else if($cellName == 'id_karyawan') {
                    $nama_karyawan = tampil_nama_karawan_byid($cellData);
                } elseif ($cellName == 'date') {
                    $tanggal = $cellData;
                } elseif ($cellName == 'jam_masuk') {
                    if($cellData == NULL) {
                        $jam_masuk = '-';
                    }else {
                        $jam_masuk = $cellData;
                    }
                } elseif ($cellName == 'jam_pulang') {
                    if($cellData == NULL) {
                        $jam_pulang = '-';
                    }else {
                        $jam_pulang = $cellData;
                    }
                } elseif ($cellName == 'keterangan_izin') {
                    $izin = $cellData;
                } elseif ($cellName == 'status') {
                    $status = $cellData;
                }
        
                // Anda juga dapat menambahkan logika lain jika perlu
                
                // Contoh: $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $cellData);
                $columnIndex++;
            }
            // Setelah loop, Anda memiliki data yang diperlukan dari setiap kolom
            // Anda dapat mengisinya ke dalam lembar kerja Excel di sini
            $sheet->setCellValueByColumnAndRow(1, $rowIndex, $no);
            $sheet->setCellValueByColumnAndRow(2, $rowIndex, $nama_karyawan);
            $sheet->setCellValueByColumnAndRow(3, $rowIndex, $kegiatan);
            $sheet->setCellValueByColumnAndRow(4, $rowIndex, $tanggal);
            $sheet->setCellValueByColumnAndRow(5, $rowIndex, $jam_masuk);
            $sheet->setCellValueByColumnAndRow(6, $rowIndex, $jam_pulang);
            $sheet->setCellValueByColumnAndRow(7, $rowIndex, $izin);
            $sheet->setCellValueByColumnAndRow(8, $rowIndex, $status);
            $no++;
        
            $rowIndex++;
        }
        // Auto size kolom berdasarkan konten
        foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set style header
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:' . $sheet->getHighestDataColumn() . '1')->applyFromArray($headerStyle);
        
        // Konfigurasi output Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'DATA_REKAP_ABSEN.xlsx'; // Nama file Excel yang akan dihasilkan
        
        // Set header HTTP untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Outputkan file Excel ke browser
        $writer->save('php://output');
        
    }
    // REKAP BULANAN
    public function export_rekap_bulanan() {

        // Load autoloader Composer
        require 'vendor/autoload.php';
        
        $spreadsheet = new Spreadsheet();

        // Buat lembar kerja aktif
       $sheet = $spreadsheet->getActiveSheet();
        // Data yang akan diekspor (contoh data)
        $bulan = date('m');; // Ambil nilai bulan yang dipilih dari form
        $data = $this->m_model->get_bulanan($bulan);
        
        // Buat objek Spreadsheet
        $headers = ['NO','NAMA KARYAWAN','KEGIATAN','TANGGAL','JAM MASUK', 'JAM PULANG' , 'KETERANGAN IZIN' ,'STATUS'];
        $rowIndex = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($rowIndex, 1, $header);
            $rowIndex++;
        }
        
        // Isi data dari database
        $rowIndex = 2;
        $no = 1;
        foreach ($data as $rowData) {
            $columnIndex = 1;
            $nama_karyawan = '';
            $kegiatan = '';
            $tanggal = '';
            $jam_masuk = '';
            $jam_pulang = '';
            $izin = ''; 
            $status = ''; 
            foreach ($rowData as $cellName => $cellData) {
                if ($cellName == 'kegiatan') {
                   $kegiatan = $cellData;
                } else if($cellName == 'id_karyawan') {
                    $nama_karyawan = tampil_nama_karawan_byid($cellData);
                } elseif ($cellName == 'date') {
                    $tanggal = $cellData;
                } elseif ($cellName == 'jam_masuk') {
                    if($cellData == NULL) {
                        $jam_masuk = '-';
                    }else {
                        $jam_masuk = $cellData;
                    }
                } elseif ($cellName == 'jam_pulang') {
                    if($cellData == NULL) {
                        $jam_pulang = '-';
                    }else {
                        $jam_pulang = $cellData;
                    }
                } elseif ($cellName == 'keterangan_izin') {
                    $izin = $cellData;
                } elseif ($cellName == 'status') {
                    $status = $cellData;
                }
        
                // Anda juga dapat menambahkan logika lain jika perlu
                
                // Contoh: $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $cellData);
                $columnIndex++;
            }
            // Setelah loop, Anda memiliki data yang diperlukan dari setiap kolom
            // Anda dapat mengisinya ke dalam lembar kerja Excel di sini
            $sheet->setCellValueByColumnAndRow(1, $rowIndex, $no);
            $sheet->setCellValueByColumnAndRow(2, $rowIndex, $nama_karyawan);
            $sheet->setCellValueByColumnAndRow(3, $rowIndex, $kegiatan);
            $sheet->setCellValueByColumnAndRow(4, $rowIndex, $tanggal);
            $sheet->setCellValueByColumnAndRow(5, $rowIndex, $jam_masuk);
            $sheet->setCellValueByColumnAndRow(6, $rowIndex, $jam_pulang);
            $sheet->setCellValueByColumnAndRow(7, $rowIndex, $izin);
            $sheet->setCellValueByColumnAndRow(8, $rowIndex, $status);
            $no++;
        
            $rowIndex++;
        }
        // Auto size kolom berdasarkan konten
        foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set style header
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:' . $sheet->getHighestDataColumn() . '1')->applyFromArray($headerStyle);
        
        // Konfigurasi output Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'DATA_REKAP_BULANAN.xlsx'; // Nama file Excel yang akan dihasilkan
        
        // Set header HTTP untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Outputkan file Excel ke browser
        $writer->save('php://output');
        
    }
    // EXPORT HARIAN
    public function export_rekap_harian() {

        // Load autoloader Composer
        require 'vendor/autoload.php';
        
        $spreadsheet = new Spreadsheet();

        // Buat lembar kerja aktif
       $sheet = $spreadsheet->getActiveSheet();
        // Data yang akan diekspor (contoh data)
        $tanggal = date('Y-m-d'); // Ambil nilai tanggal yang dipilih dari form
        $data = $this->m_model->get_harian($tanggal);
        
        // Buat objek Spreadsheet
        $headers = ['NO','NAMA KARYAWAN','KEGIATAN','TANGGAL','JAM MASUK', 'JAM PULANG' , 'KETERANGAN IZIN', 'STATUS'];
        $rowIndex = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($rowIndex, 1, $header);
            $rowIndex++;
        }
        
        // Isi data dari database
        $rowIndex = 2;
        $no = 1;
        foreach ($data as $rowData) {
            $columnIndex = 1;
            $nama_karyawan = '';
            $kegiatan = '';
            $tanggal = '';
            $jam_masuk = '';
            $jam_pulang = '';
            $izin = ''; 
            $status = ''; 
            foreach ($rowData as $cellName => $cellData) {
                if ($cellName == 'kegiatan') {
                   $kegiatan = $cellData;
                } else if($cellName == 'id_karyawan') {
                    $nama_karyawan = tampil_nama_karawan_byid($cellData);
                } elseif ($cellName == 'date') {
                    $tanggal = $cellData;
                } elseif ($cellName == 'jam_masuk') {
                    if($cellData == NULL) {
                        $jam_masuk = '-';
                    }else {
                        $jam_masuk = $cellData;
                    }
                } elseif ($cellName == 'jam_pulang') {
                    if($cellData == NULL) {
                        $jam_pulang = '-';
                    }else {
                        $jam_pulang = $cellData;
                    }
                } elseif ($cellName == 'keterangan_izin') {
                    $izin = $cellData;
                } elseif ($cellName == 'status') {
                    $status = $cellData;
                }
        
                // Anda juga dapat menambahkan logika lain jika perlu
                
                // Contoh: $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $cellData);
                $columnIndex++;
            }
            // Setelah loop, Anda memiliki data yang diperlukan dari setiap kolom
            // Anda dapat mengisinya ke dalam lembar kerja Excel di sini
            $sheet->setCellValueByColumnAndRow(1, $rowIndex, $no);
            $sheet->setCellValueByColumnAndRow(2, $rowIndex, $nama_karyawan);
            $sheet->setCellValueByColumnAndRow(3, $rowIndex, $kegiatan);
            $sheet->setCellValueByColumnAndRow(4, $rowIndex, $tanggal);
            $sheet->setCellValueByColumnAndRow(5, $rowIndex, $jam_masuk);
            $sheet->setCellValueByColumnAndRow(6, $rowIndex, $jam_pulang);
            $sheet->setCellValueByColumnAndRow(7, $rowIndex, $izin);
            $sheet->setCellValueByColumnAndRow(8, $rowIndex, $status);
            $no++;
        
            $rowIndex++;
        }
        // Auto size kolom berdasarkan konten
        foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set style header
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:' . $sheet->getHighestDataColumn() . '1')->applyFromArray($headerStyle);
        
        // Konfigurasi output Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'DATA_REKAP_HARIAN.xlsx'; // Nama file Excel yang akan dihasilkan
        
        // Set header HTTP untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Outputkan file Excel ke browser
        $writer->save('php://output');
        
    }
    // EXPORT MINGGUAN
    public function export_rekap_mingguan() {

        // Load autoloader Composer
        require 'vendor/autoload.php';
        
        $spreadsheet = new Spreadsheet();

        // Buat lembar kerja aktif
       $sheet = $spreadsheet->getActiveSheet();
        // Data yang akan diekspor (contoh data)
        $data = $this->m_model->get_mingguan();
        
        // Buat objek Spreadsheet
        $headers = ['NO','NAMA KARYAWAN','KEGIATAN','TANGGAL','JAM MASUK', 'JAM PULANG' , 'KETERANGAN IZIN' ,'STATUS'];
        $rowIndex = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($rowIndex, 1, $header);
            $rowIndex++;
        }
        
        // Isi data dari database
        $rowIndex = 2;
        $no = 1;
        foreach ($data as $rowData) {
            $columnIndex = 1;
            $nama_karyawan = '';
            $kegiatan = '';
            $tanggal = '';
            $jam_masuk = '';
            $jam_pulang = '';
            $izin = ''; 
            $status = ''; 
            foreach ($rowData as $cellName => $cellData) {
                if ($cellName == 'kegiatan') {
                   $kegiatan = $cellData;
                } else if($cellName == 'id_karyawan') {
                    $nama_karyawan = tampil_nama_karawan_byid($cellData);
                } elseif ($cellName == 'date') {
                    $tanggal = $cellData;
                } elseif ($cellName == 'jam_masuk') {
                    if($cellData == NULL) {
                        $jam_masuk = '-';
                    }else {
                        $jam_masuk = $cellData;
                    }
                } elseif ($cellName == 'jam_pulang') {
                    if($cellData == NULL) {
                        $jam_pulang = '-';
                    }else {
                        $jam_pulang = $cellData;
                    }
                } elseif ($cellName == 'keterangan_izin') {
                    $izin = $cellData;
                }
        
                // Anda juga dapat menambahkan logika lain jika perlu
                
                // Contoh: $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $cellData);
                $columnIndex++;
            }
            // Setelah loop, Anda memiliki data yang diperlukan dari setiap kolom
            // Anda dapat mengisinya ke dalam lembar kerja Excel di sini
            $sheet->setCellValueByColumnAndRow(1, $rowIndex, $no);
            $sheet->setCellValueByColumnAndRow(2, $rowIndex, $nama_karyawan);
            $sheet->setCellValueByColumnAndRow(3, $rowIndex, $kegiatan);
            $sheet->setCellValueByColumnAndRow(4, $rowIndex, $tanggal);
            $sheet->setCellValueByColumnAndRow(5, $rowIndex, $jam_masuk);
            $sheet->setCellValueByColumnAndRow(6, $rowIndex, $jam_pulang);
            $sheet->setCellValueByColumnAndRow(7, $rowIndex, $izin);
            $sheet->setCellValueByColumnAndRow(8, $rowIndex, $status);
            $no++;
        
            $rowIndex++;
        }
        // Auto size kolom berdasarkan konten
        foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set style header
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:' . $sheet->getHighestDataColumn() . '1')->applyFromArray($headerStyle);
        
        // Konfigurasi output Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'DATA_REKAP_MINGGUAN.xlsx'; // Nama file Excel yang akan dihasilkan
        
        // Set header HTTP untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Outputkan file Excel ke browser
        $writer->save('php://output');
        
    }
}