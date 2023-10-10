<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

 function __construct()
 {
  parent::__construct();
  $this->load->model('m_model');
  $this->load->helper('my_helper');
 }

// untuk login
    public function index()
        {
            $this->load->view('auth/login');
        }
    //  aksi login
 public function aksi_login()
 {
  $email = $this->input->post('email', 'Email', 'required|valid_email'); 
  $password = $this->input->post('password', 'required|min_length[8]');
  $data = [ 'email' => $email, ];
  $query = $this->m_model->getwhere('admin', $data);
  $result = $query->row_array();

  if (!empty($result) && md5($password) === $result['password']) {
   $data = [
    'logged_in' => TRUE,
    'email' => $result['email'],
    'username' => $result['username'],
    'role' => $result['role'],
    'id' => $result['id'],
   ];
   $this->session->set_userdata($data);
   if ($this->session->userdata('role') == 'admin') {
    redirect(base_url()."admin");
   } else {
    redirect(base_url()."auth");
   }
  } else {
   redirect(base_url()."auth");
  }
}
// register
public function register() { 
    $this->load->view('auth/register'); 
  } 
  
  public function aksi_register()
{
    $username = $this->input->post('username', true);
    $email = $this->input->post('email', true);
    $nama_depan = $this->input->post('nama_depan', true);
    $nama_belakang = $this->input->post('nama_belakang', true);
    $password = $this->input->post('password', true);

    // Validasi input
    if (empty($username) || empty($email) || empty($nama_depan) || empty($nama_belakang) || empty($password)) {
        // Tampilkan pesan error jika ada input yang kosong
        $this->session->set_flashdata('error', 'Semua field harus diisi.');
        redirect(base_url() . 'auth'); // Gantilah dengan URL halaman registrasi Anda.
    }

    // Anda perlu menambahkan logika untuk memasukkan data pengguna ke dalam database
    // Sesuai dengan framework atau model yang Anda gunakan.

    // Misalnya, dengan menggunakan model untuk menyimpan data pengguna
    $data = array(
        'username' => $username,
        'email' => $email,
        'nama_depan' => $nama_depan,
        'nama_belakang' => $nama_belakang,
        'password' => md5($password), // Simpan kata sandi yang telah di-MD5
        'role' => 'admin' // Atur peran sesuai dengan kebutuhan aplikasi Anda
    );

    // Panggil model Anda untuk menyimpan data pengguna
    $this->m_model->tambah_data('user', $data);

    // Setelah data pengguna berhasil disimpan, Anda dapat mengarahkan pengguna
    // ke halaman login atau halaman lain yang sesuai.
    redirect(base_url() . 'auth'); // Gantilah dengan URL halaman login Anda.
}

 
public function aksi_register_karyawan() 
{ 
    $username = $this->input->post('username', true); 
    $email = $this->input->post('email', true); 
    $nama_depan = $this->input->post('nama_depan', true); 
    $nama_belakang = $this->input->post('nama_belakang', true); 
    $password = $this->input->post('password', true); 
 
     // Validasi input 
     if (empty($username) || empty($email) || empty($nama_depan) || empty($nama_belakang) || empty($password)) { 
        // Tampilkan pesan error jika ada input yang kosong 
        $this->session->set_flashdata('error', 'Semua field harus diisi.'); 
        redirect(base_url().'auth'); // Gantilah dengan URL halaman registrasi Anda. 
    } 
 
    // Anda perlu menambahkan logika untuk memasukkan data pengguna ke dalam database 
    // Sesuai dengan framework atau model yang Anda gunakan. 
 
    // Misalnya, dengan menggunakan model untuk menyimpan data pengguna 
    $data = array( 
        'username' => $username, 
        'email' => $email, 
        'nama_depan' => $nama_depan, 
        'nama_belakang' => $nama_belakang, 
        'password' => md5($password), // Simpan kata sandi yang telah di-MD5 
        'role' => 'karyawan' // Atur peran sesuai dengan kebutuhan aplikasi Anda 
    ); 
 
    // Panggil model Anda untuk menyimpan data pengguna 
    $this->m_model->tambah_data('user', $data); 
 
    // Setelah data pengguna berhasil disimpan, Anda dapat mengarahkan pengguna 
    // ke halaman login atau halaman lain yang sesuai. 
    redirect(base_url().'auth'); // Gantilah dengan URL halaman login Anda. 
}

 
function logout() { 
    $this->session->sess_destroy(); // Menggunakan sess_destroy() untuk mengakhiri sesi 
    redirect(base_url('auth')); 
   }   
}