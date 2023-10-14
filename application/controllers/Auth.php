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
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);
        $data = ['email' => $email,];
        $query = $this->m_model->getwhere('user', $data);
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
                redirect(base_url() . "admin");
            }elseif ($this->session->userdata('role') == 'karyawan') {  
                redirect(base_url()."karyawan/index");
            }
        } else {
            redirect(base_url() . "karyawan/index");
        }
    }
// register
public function register_admin() { 
    $this->load->view('auth/admin'); 
  } 
public function register_karyawan() { 
    $this->load->view('auth/register_karyawan'); 
  } 
  
  public function aksi_register_karyawan() 
    { 
        $this->load->library('form_validation'); 
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); 
        $this->form_validation->set_rules('username', 'username');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('role', 'role');
        $this->form_validation->set_rules('nama_depan', 'nama_depan');
        $this->form_validation->set_rules('nama_belakang', 'nama_belakang');
        $this->form_validation->set_rules('image', 'image');

        $email = $this->input->post('email', true);
        $username = $this->input->post('username', true);
        $password = md5($this->input->post('password', true));
        $role = 'karyawan';
        $nama_depan = $this->input->post('nama_depan', true);
        $nama_belakang = $this->input->post('nama_belakang', true);
        $image = $this->input->post('image', true);

        // Membuat array data
        $data = [
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'role' => 'karyawan',
            'nama_depan' => $nama_depan,
            'nama_belakang' => $nama_belakang,
            'image' => 'User.png'
        ];

        $this->db->insert('user', $data);

        redirect('auth');
    }
  public function aksi_register_admin() 
    { 
        $this->load->library('form_validation'); 
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); 
        $this->form_validation->set_rules('username', 'username');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('role', 'role');
        $this->form_validation->set_rules('nama_depan', 'nama_depan');
        $this->form_validation->set_rules('nama_belakang', 'nama_belakang');
        $this->form_validation->set_rules('image', 'image');

        $email = $this->input->post('email', true);
        $username = $this->input->post('username', true);
        $password = md5($this->input->post('password', true));
        $role = 'admin';
        $nama_depan = $this->input->post('nama_depan', true);
        $nama_belakang = $this->input->post('nama_belakang', true);
        $image = $this->input->post('image', true);

        // Membuat array data
        $data = [
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'role' => 'admin',
            'nama_depan' => $nama_depan,
            'nama_belakang' => $nama_belakang,
            'image' => 'User.png'
        ];

        $this->db->insert('user', $data);

        redirect(base_url(('auth/admin')));
    }

function logout() { 
    $this->session->sess_destroy(); // Menggunakan sess_destroy() untuk mengakhiri sesi 
    redirect(base_url('auth')); 
   }   
}