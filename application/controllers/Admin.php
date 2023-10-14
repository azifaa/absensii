<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        $this->load->library('upload');
        if ($this->session->userdata('logged_in') != true || $this->session->userdata('role') != 'admin') {
            redirect(base_url() . 'auth/login');
        }
    }
    public function dashboard()
    {
        $data['absen'] = $this-> m_model->get_data('absensi' , $this->session->userdata('id'))->result();
        $data['jumlah_absen'] = $this-> m_model->get_data('absensi' , $this->session->userdata('id'))->num_rows();
         $this->load->view('admin/dashboard',$data);
    }
   
    public function rekap_bulan()
    {   $data['absensi'] = $this->m_model->getAbsensiLast7Days();
        $this->load->view('admin/rekap_bulan',$data);
    }
    public function karyawan()
    {
        $this->load->view('admin/karyawan');
    }
   
    
}  