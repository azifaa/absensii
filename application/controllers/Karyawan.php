<?php
defined('BASEPATH') or exit('No direct script access allowed');

class karyawan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        if ($this->session->userdata('logged_in') != true || $this->session->userdata('role') != 'karyawan') {
             redirect(base_url() . 'auth/login');
     }
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
    public function history()
    {
        $this->load->model('Absensi_model');
        $data['absensi'] = $this->Absensi_model->getAbsensi();
        $this->load->view('karyawan/history', $data);
    }
    public function hapus_karyawan($id)
{
    $this->m_model->delete('absensi', 'id', $id);
    $this->session->set_flashdata(
        'berhasil_menghapus',
        'Data berhasil dihapus.'
    );
    redirect(base_url('karyawan/history'));
}

public function kegiatan()
{
    $data=array(
        'kegiatan'=> $this->input->post('kegiatan')
    );
    $this->m_model->ubah_data('absensi', $data, array('id_karyawan' => $this->input->post('id_karyawan')));redirect(base_url('karyawan/history'));
    
}
    public function izin()
    {       
     
        $this->load->view('karyawan/izin');
    }
public function absensi()
{

    $this->load->view('karyawan/absensi');
}
public function save_absensi()
{
    date_default_timezone_set('Asia/Jakarta');
    $current_datetime = date('Y-m-d H:i:s');

    $data = [
        'kegiatan' => $this->input->post('kegiatan'),
        'date' => $current_datetime,
        'jam_masuk' => $current_datetime,
        'jam_pulang' => $current_datetime,
    ];

    $this->load->model('Absensi_model');
    $this->Absensi_model->createAbsensi($data);

    redirect('karyawan/history');
}
public function tambah_absen()
    {
        $this->load->view('karyawan/tambah_absen');
    }
// public function ubah_absen()
// {
//     $this->load->view('karyawan/ubah_absen');
// }

public function aksi_ubah_izin()
{         
    
    date_default_timezone_set('Asia/Jakarta');
    $current_datetime = date('Y-m-d H:i:s');
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
public function aksi_pulang()
{
    $id_karyawan = $this->input->post('id_karyawan');
    
    // Set zona waktu ke "Asia/Jakarta"
    date_default_timezone_set('Asia/Jakarta');
    
    $current_datetime = date('Y-m-d H:i:s');
    
    list($date, $time) = explode(' ', $current_datetime);

    $absen = $this->m_model->getAbsenByKaryawan($id_karyawan);
    
    if ($absen->status != 'Done') {
        $data = [
            'jam_pulang' => $time, // Menggunakan waktu saat ini
            'status' => 'Done'
        ];
        $this->m_model->updateAbsen($absen->id_karyawan, $data);
    }
}
public function batal_pulang($absen_id) {
    if ($this->session->userdata('role') === 'karyawan') {
        $this->karyawan_model->batalPulang($absen_id);

        // Set pesan sukses
        $this->session->set_flashdata('success', 'Batal Pulang berhasil.');

        // Redirect kembali ke halaman riwayat absen
        redirect('karyawan/history');
    } else {
        redirect('other_page');
    }
}

public function akun()
{         
    $data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();


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
public function ubah_absen($id)
{
    $data['absen'] = $this-> m_model->get_by_id('absensi' , 'id', $id)->result();
    $this->load->view('karyawan/ubah_absen',$data);
}
public function aksi_ubah_absen()
{
    $data =  [
        'kegiatan' => $this->input->post('kegiatan'),
    ];
    $eksekusi = $this->m_model->ubah_data('absensi', $data, array('id'=>$this->input->post('id')));
    if($eksekusi) {
        $this->session->set_flashdata('sukses' , 'berhasil');
        redirect(base_url('karyawan/history'));
    } else {
        $this->session->set_flashdata('error' , 'gagal...');
        redirect(base_url('karyawan/ubah_absen'.$this->input->post('id')));
    }
}
}
?>