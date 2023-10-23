<?php

class M_model extends CI_Model
{
    function get_data($table)
    {
        return $this->db->get($table);
    }
    // Get where
    function getwhere($table, $data)
    {
        return $this->db->get_where($table, $data);
    }
    // Hapus Data
    function delete($table, $field, $id)
    {
        $data = $this->db->delete($table, array($field => $id));
        return $data;
    }
    // Tambah Data
    function add($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    // Get Id
    public function get_by_id($table, $field, $id)
    {
        return $this->db->get_where($table, array($field => $id))->row();
    }
    // Update Data
    public function update($tabel, $data, $where)
    {
        $data = $this->db->update($tabel, $data, $where);
        return $this->db->affected_rows();
    }
    // Register
    public function register_user($data)
    {
        // Masukkan data ke dalam tabel 'users' dan kembalikan hasilnya 
        return $this->db->insert('user', $data);
    }
    // Update Absen
    public function updateAbsen($id_karyawan, $data)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->update('absen', $data);
    }
    // Status Absen
    public function getStatusAbsen($id_karyawan, $tanggal)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('date', $tanggal);
        $result = $this->db->get('absen')->row();
        
        if ($result) {
            return $result->status;
        }
        
        // Jika tidak ada data absen untuk tanggal tersebut, maka karyawan belum absen
        return 'belum_absen';
    }
    // Update Status Absen
    public function updateStatusAbsen($id_karyawan, $tanggal, $status)
    {
        $data = array('status' => $status);
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('date', $tanggal);
        $this->db->update('absen', $data);
    }
    // Get karyawan page
    public function get_karyawan_page($limit, $offset)
    {
        $this->db->where('role', 'karyawan');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('user');
        return $query->result();
    }
    // Mendapatkan data absen berdasarkan ID karyawan
    public function getAbsenByKaryawan($id_karyawan)
    {
        return $this->db->get_where('absen', ['id_karyawan' => $id_karyawan])->row();
    }
    // Get Data karyawan
    public function get_karyawan($table)
    {
        return $this->db->where('role', 'karyawan')
        ->get($table);
    }
    public function count_karyawan()
    {
        $this->db->where('role', 'karyawan');
        return $this->db->count_all_results('user');
    }
    // History
    public function get_history($table, $id_karyawan)
    {
        return $this->db->where('id_karyawan', $id_karyawan)->get($table);
    }
    public function get_history_page($limit, $offset, $karyawan_id)
    {
        $this->db->where('id_karyawan', $karyawan_id);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('absensi');
        return $query->result();
    }
    public function count_history($karyawan_id)
    {
        $this->db->where('id_karyawan', $karyawan_id);
        return $this->db->count_all_results('absensi');
    }
    // Mingguan
    public function count_mingguan()
    {
        $this->load->database();
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-7 days', strtotime($end_date)));
        $query = $this->db->select('date, kegiatan,id_karyawan, jam_masuk, jam_pulang, keterangan_izin, status, COUNT(*) AS total_absences')
            ->from('absensi')
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->group_by('date, id_karyawan, kegiatan, jam_masuk, jam_pulang, keterangan_izin, status')
            ->get();
        return $this->db->count_all_results();
    }
    public function get_mingguan_page($limit, $offset)
    {
        $this->load->database();
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-7 days', strtotime($end_date)));
        $query = $this->db->select('date, kegiatan,id_karyawan, jam_masuk, jam_pulang, keterangan_izin, status, COUNT(*) AS total_absences')
            ->from('absensi')
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->limit($limit, $offset)
            ->group_by('date, id_karyawan, kegiatan, jam_masuk, jam_pulang, keterangan_izin, status')
            ->get();
        return $query->result_array();
    }
    public function get_mingguan()
    {
        $this->load->database();
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-7 days', strtotime($end_date)));
        $query = $this->db->select('date, kegiatan,id_karyawan, jam_masuk, jam_pulang, keterangan_izin, status, COUNT(*) AS total_absences')
            ->from('absensi')
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->group_by('date, id_karyawan, kegiatan, jam_masuk, jam_pulang, keterangan_izin, status')
            ->get();
        return $query->result_array();
    }
    // Harian
    public function count_harian($date)
    {
        $this->db->where('date =', $date);
        return $this->db->count_all_results('absensi');
    }
    public function get_harian($date)
    {
        $this->db->from('absensi');
        $this->db->where('date =', $date);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_harian_page($limit, $offset, $date)
    {
        $this->db->where('date =', $date);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('absensi');
        return $query->result();
    }
    public function getPerHari($tanggal)
        {
            $this->db->select('absensi.id, absensi.date, absensi.kegiatan, absensi.id_karyawan, absensi.jam_masuk, absensi.jam_pulang, absensi.keterangan_izin');
            $this->db->from('absensi');
            $this->db->where('absensi.date', $tanggal); // Menyaring data berdasarkan tanggal
            $query = $this->db->get();
            return $query->result_array();
        }
        public function get_data_perhari() {
            $this->db->select('*');
            $this->db->from('absensi');
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return array(); // Mengembalikan array kosong jika tidak ada data
            }
        }
    // Absen Page
    public function count_absen()
    {
        return $this->db->count_all_results('absensi');
    }
    public function get_absen_page($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $query = $this->db->get('absensi');
        return $query->result();
    }
    // bulanan
    public function get_bulanan($date)
    {
        $this->db->from('absensi');
        $this->db->where("DATE_FORMAT(absensi.date, '%m') =", $date);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_bulanan_page($limit, $offset, $date)
    {
        $this->db->where("DATE_FORMAT(absensi.date, '%m') =", $date);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('absensi');
        return $query->result();
    }
    public function count_bulanan($date)
    {
        $this->db->where("DATE_FORMAT(absensi.date, '%m') =", $date);
        return $this->db->count_all_results('absensi');
    }
    // foto lama
    public function get_foto_by_id($id)
    {
        $this->db->select('foto');
        $this->db->from('user');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->f;
        } else {
            return false;
        }
    }
    public function get_absensi_data() {
        $query = $this->db->get('absensi'); // Misalnya, tabel absensi disimpan dalam database

        if ($query->num_rows() > 0) {
            return $query->result(); // Mengembalikan data absensi sebagai objek
        } else {
            return array(); // Mengembalikan array kosong jika tidak ada data
        }
    }
}