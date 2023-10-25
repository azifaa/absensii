<?php
defined('BASEPATH') or exit('No direct script access allowed');

class karyawan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');
        $this->load->library('upload');
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
        $data['absensi'] = $this->m_model->get_absensi_data();
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
    $id_karyawan = $this->session->userdata('id');
    date_default_timezone_set('Asia/Jakarta');
    $current_datetime = date('Y-m-d H:i:s');

    $tanggal = date('Y-m-d', strtotime($current_datetime));
    $jam = date('H:i:s', strtotime($current_datetime));

    // Ambil nilai $keterangan dari formulir POST
    $keterangan_izin = $this->input->post('keterangan_izin');

    // Periksa apakah $keterangan memiliki nilai, jika tidak, beri nilai default (misalnya, '')
    if ($keterangan_izin === NULL) {
        $keterangan_izin = '';
    }

    $data = [
        'id_karyawan' => $id_karyawan, 
        'kegiatan' => $this->input->post('kegiatan'),
        'date' => $tanggal,
        'jam_masuk' => $jam,
        'jam_pulang' => '',
        'keterangan_izin' => $keterangan_izin,
        'status' => 'Not',
    ];        

    $this->load->model('Absensi_model');
    $this->Absensi_model->createAbsensi($data);

    redirect('karyawan/history');
}

// untuk aksi izin
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
        
    
        $this->m_model->add('absensi', $data);
         
         redirect(base_url('karyawan/history'));
}
}
//  untuk pulang
// public function pulang($absen_id) { 
//     if ($this->session->userdata('role') === 'karyawan') { 
//         $this->m_model->setAbsensiPulang($absen_id); 
 
//         // Set pesan sukses 
//         $this->session->set_flashdata('success', 'Jam pulang berhasil diisi.'); 
 
//         redirect('karyawan/history'); 
//     } else { 
//         redirect('karyawan/history'); 
//     } 
// }
public function aksi_pulang($id)
{
    date_default_timezone_set('Asia/Jakarta');
    $waktu_sekarang = date('Y-m-d H:i:s');
    
    // Pisahkan tanggal dan waktu
    list($date, $waktu) = explode(' ', $waktu_sekarang);

    $data = [
        'date' => $date, // Menggunakan tanggal yang telah dipisahkan
        'jam_pulang' => $waktu, // Menggunakan waktu yang telah dipisahkan
        'status' => 'Done'
    ];

    $this->m_model->update('absensi', $data, array('id'=> $id));
    redirect(base_url('karyawan/history'));
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
    $data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'));
        $this->load->view('karyawan/akun', $data);

}
// update profile
public function aksi_ubah_profil() {
    // Mengambil input dari formulir
    $email = $this->input->post('email');
    $username = $this->input->post('username');
    $nama_depan = $this->input->post('nama_depan');
    $nama_belakang = $this->input->post('nama_belakang');
    $password_baru = $this->input->post('password_baru');
    $konfirmasi_password = $this->input->post('konfirmasi_password');
    $password_lama = $this->input->post('password_lama'); // Tambahkan input password lama

    // Mengambil data pengguna dari database berdasarkan ID pengguna yang disimpan dalam sesi
    $user_data = $this->m_model->getwhere('user', array('id' => $this->session->userdata('id')))->row_array();

    // Validasi password lama
    if (md5($password_lama) !== $user_data['password']) {
        $error_password_lama = '*Password lama salah' ; // Pesan kesalahan
        $this->session->set_flashdata('error_password_lama', '*Password lama salah');
        redirect(base_url('karyawan/profil'));
    }

    // Buat data yang akan diubah
    $data = array(
        'email' => $email,
        'username' => $username,
        'nama_depan' => $nama_depan,
        'nama_belakang' => $nama_belakang
    );

    // Jika ada password baru
    if (!empty($password_baru)) {
        // Pastikan password baru dan konfirmasi password sama
        if ($password_baru === $konfirmasi_password) {
            // Hash password baru
            $data['password'] = md5($password_baru);
        } else {
            $this->session->set_flashdata('konfirmasi_password', '*Password baru dan konfirmasi password harus sama');
            redirect(base_url('karyawan/profil'));
        }
    }

    $this->session->set_userdata($data);
    $update_result = $this->m_model->ubah_data('user', $data, array('id' => $this->session->userdata('id')));

    if ($update_result) {
        redirect(base_url('karyawan/profil'));
    } else {
        echo 'error';
        // redirect(base_url('karyawan/profil'));
    }
}
// Upload i
public function upload_img($value)
{
    $kode = round(microtime(true) * 1000);
    $config['upload_path'] = '../../image/';
    $config['allowed_types'] = 'jpg|png|jpeg';
    $config['max_size'] = '30000';
    $config['file_name'] = $kode;
    
    $this->load->library('upload', $config); // Load library 'upload' with config
    
    if (!$this->upload->do_upload($value)) {
        return array(false, '');
    } else {
        $fn = $this->upload->data();
        $nama = $fn['file_name'];
        return array(true, $nama);
    }
}
public function aksi_ubah_password()
{
  
    $data = [
        'email' => $this->input->post('email'),
        'password' =>$this->input->post('password'),
        'username' => md5($this->input->post('username'))
    ];
    $eksekusi = $this->m_model->update(  'user', $data,   array('id ' => $this->input->post('id '))
    );
    if ($eksekusi) {
       echo redirect(base_url('karyawan/akun'));
    }else {
      echo 'erorr';
    }
}
// public function ubah_absen($id)
// {
//     $data['absen'] = $this->m_model->get_by_id('absensi', 'id', $id);
//     $this->load->view('karyawan/ubah_absen', $data);
// }

public function ubah_absen($id)
 {
  $data['absensi']=$this->m_model->get_by_id('absensi', 'id', $id);
  $this->load->view('karyawan/ubah_absen', $data);
 }
public function aksi_ubah_absen()
{
    $data =  [
        'kegiatan' => $this->input->post('kegiatan')
    ];
    $eksekusi = $this->m_model->update('absensi', $data, array('id'=>$this->input->post('id')));
    if($eksekusi) {
        $this->session->set_flashdata('sukses' , 'berhasil');
        redirect(base_url('karyawan/history'));
    } else {
        $this->session->set_flashdata('error' , 'gagal...');
        redirect(base_url('karyawan/ubah_absen'.$this->input->post('id')));
    }
}
public function aksi_ubah_akun()
    {
        $password_baru = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $nama_depan = $this->input->post('nama_depan'); // Tambahkan nama_depan
        $nama_belakang = $this->input->post('nama_belakang'); // Tambahkan nama_belakang
    
        $data = [
            'email' => $email,
            'username' => $username,
            'nama_depan' => $nama_depan, // Tambahkan nama_depan
            'nama_belakang' => $nama_belakang, // Tambahkan nama_belakang
        ];
    
        if (!empty($password_baru)) {
            if ($password_baru === $konfirmasi_password) {
                $data['password'] = md5($password_baru);
            } else {
                $this->session->set_flashdata('message', 'Password baru dan Konfirmasi password harus sama');
                redirect(base_url('karyawan/profile'));
            }
        }   
    
        $this->session->set_userdata($data);
        $update_result = $this->m_model->update('user', $data, ['id' => $this->session->userdata('id')]);
    
        if ($update_result) {
            redirect(base_url('karyawan/akun'));
        } else {
            redirect(base_url('karyawan/akun'));
        }
    }
    
    public function aksi_ubah_foto()
    {
        $image = $this->upload_image('image'); 
        
        if ($image[0] === false) {
            redirect(base_url('karyawan/profile'));
        } else {
            $data = [
                'image' => $image[1],
            ];
            
            $this->session->set_userdata('image', $data['image']);
            $update_result = $this->m_model->update('user', $data, ['id' => $this->session->userdata('id')]);
            
            if ($update_result) {
                redirect(base_url('karyawan/akun'));
            } else {
                redirect(base_url('karyawan/akun'));
            }
        }
    }
    public function upload_image($value)
    {
        $kode = round(microtime(true) * 1000);
        $config['upload_path'] = './images/karyawan/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 30000;
        $config['file_name'] = $kode;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($value)) {
            return array(false, '');
        } else {
            $fn = $this->upload->data();
            $nama = $fn['file_name'];
            return array(true, $nama);
        }
    }


}
?>