<?php
defined('BASEPATH') or exit('No direct script access allowed');

class karyawan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        // if ($this->session->userdata('logged_in') != true || $this->session->userdata('role') != 'karyawan') {
        //     redirect(base_url() . 'auth/login');
        // }
    }
    public function index()
    {
        // Mengisi data yang diperlukan untuk tampilan
        $data = array(
            'title' => 'Dashboard Karyawan', // Judul halaman
            'content' => 'Selamat datang di dashboard karyawan.', // Konten halaman
        );

        // Menampilkan tampilan (sesuaikan dengan nama tampilan Anda)
        $this->load->view('karyawan/index', $data);
    }
    public function izin()
    {       
     
        $this->load->view('karyawan/izin');
    }
    public function history()
    {       
        $data['history'] = $this->m_model->get_data('absensi' , $this->session->userdata('id'))->result();

        $this->load->view('karyawan/history',$data);
    }
public function hapus_karyawan($id)
{
    $this->m_model->delete('absensi', 'id', $id);
    redirect(base_url('history'));
}

public function kegiatan()
{
    $data=array(
        'kegiatan'=> $this->input->post('kegiatan')
    );
    $this->m_model->ubah_data('absensi', $data, array('id_karyawan' => $this->input->post('id_karyawan')));redirect(base_url('karyawan/history'));
 
}
public function absensi()
{

    $this->load->view('karyawan/absensi');
}
public function aksi_absensi()
{        
    date_default_timezone_set('Asia/Jakarta');
    $waktu_sekarang = date('Y-m-d H:i:s');
    $id_karyawan = $this->session->userdata('id');
    $tanggal_absensi = date('Y-m-d');

    //  apakah karyawan sudah memiliki catatan absensi pada tanggal yang sama
    $absen = $this->m_model->getwhere('absensi', array(
        'id_karyawan' => $id_karyawan,
        'date' => $tanggal_absensi
    ));

    if ($absen->num_rows() > 0) {
      
        // Karyawan sudah melakukan absensi pada tanggal yang sama
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       Anda Sudah Absensi Atau Izin Hari Ini
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    
      </div>');
        redirect(base_url('karyawan/absensi')); 
    } else {
        // Karyawan belum melakukan absensi pada tanggal yang sama, bisa melanjutkan dengan absensi
        $data = [
            'id_karyawan' => $id_karyawan,
            'kegiatan' => $this->input->post('kegiatan'),
            'jam_keluar' => NULL,
            'jam_masuk' => $waktu_sekarang, 
            'date' => $tanggal_absensi,  
            'keterangan_izin' => '-',
            'status' => 'not'
        ];

        $this->m_model->tambah_data('absensi', $data);
        redirect(base_url('karyawan/history'));
    }
}
public function aksi_izin()
{         
    
    date_default_timezone_set('Asia/Jakarta');
    $waktu_sekarang = date('Y-m-d H:i:s');
    $id_karyawan = $this->session->userdata('id');
    $tanggal_izin = date('Y-m-d');

    //  apakah karyawan sudah memiliki catatan izin pada tanggal yang sama
    $izin = $this->m_model->getwhere('absensi', array(
        'id_karyawan' => $id_karyawan,
        'date' => $tanggal_izin 
    ));

    if ($izin->num_rows() > 0) {
        // Karyawan sudah melakukan izin pada tanggal yang sama
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
       Anda Sudah Absensi Atau Izin Hari Ini
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    
      </div>');
        redirect(base_url('karyawan/izin')); 
    } else {
        // Karyawan belum melakukan izin pada tanggal yang sama,  bisa melanjutkan 
        $data = [
            'id_karyawan' => $id_karyawan,
            'kegiatan' => '-',
            'jam_masuk' => NULL,
            'jam_pulang' => NULL, 
            'date' => $tanggal_izin,  
            'keterangan_izin' => $this->input->post('izin'),
            'status' => 'done'
        ];
        
    
        $this->m_model->tambah_data('absensi', $data);
         
         redirect(base_url('karyawan/history'));
}
}
public function pulang($id)
{
    date_default_timezone_set('Asia/Jakarta');
    $waktu_sekarang = date('Y-m-d H:i:s');
    $data = [
        'jam_keluar' => $waktu_sekarang,
        'status' => 'done'
    ];
    $this->m_model->ubah_data('absensi', $data, array('id'=> $id));
    redirect(base_url('karyawan/history'));
}
public function akun()
{         
    $data['user'] = $this-> m_model->get_data ('user' , $this->session->userdata('id'))->result();


    $this->load->view('karyawan/akun',$data);

}


public function upload_image()
{  
    $base64_image = $this->input->post('base64_image');

    $binary_image = base64_encode($base64_image);

    $data = array(
        'foto' => $binary_image
    );

    $eksekusi = $this->m_model->ubah_data('user', $data, array('id'=>$this->input->post('id')));
    if($eksekusi) {
        $this->session->set_flashdata('sukses' , 'berhasil');
        redirect(base_url('karyawan/akun'));
    } else {
        $this->session->set_flashdata('error' , 'gagal...');
       echo "error gais";
    }
}

public function hapus_image()
{ 
    $data = array(
        'foto' => NULL
    );

    $eksekusi = $this->m_model->ubah_data('user', $data, array('id'=>$this->session->userdata('id')));
    if($eksekusi) {
        $this->session->set_flashdata('sukses' , 'berhasil');
        redirect(base_url('karyawan/akun'));
    } else {
        $this->session->set_flashdata('error' , 'gagal...');
       echo "error gais";
    }
}
public function aksi_ubah_password()
{
  
    $data = [
        'email' => $this->input->post('email'),
        'password' =>$this->input->post('password'),
        'username' => md5($this->input->post('username'))
    ];
    $eksekusi = $this->m_model->ubah_data(  'user',  $data,   array('id ' => $this->input->post('id '))
    );
    if ($eksekusi) {
       echo redirect(base_url('karyawan/akun'));
    }else {
      echo 'erorr';
    }
    
   
    
}
}
?>