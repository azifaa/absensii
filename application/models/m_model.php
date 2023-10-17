<?php

class M_model extends CI_Model
{
    function get_data($table)
    {
        return $this->db->get($table);
    }
    function getwhere($table, $data)
    {
        return $this->db->get_where($table, $data);
    }
    function delete($table, $field, $id)
    {
        $data = $this->db->delete($table, array($field => $id));
        return $data;
    }
    function add($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    public function get_by_id($tabel, $id_column, $id)
    {
        $data = $this->db->where($id_column, $id)->get($tabel);
        return $data;
    }
    public function update($tabel, $data, $where)
    {
        $data = $this->db->update($tabel, $data, $where);
        return $this->db->affected_rows();
    }
    public function register_user($data) { 
        // Masukkan data ke dalam tabel 'users' dan kembalikan hasilnya 
        return $this->db->insert('user', $data); 
    }
    public function get_history($table, $id_karyawan)
    {
        return $this->db->where('id_karyawan', $id_karyawan)->get($table);
    }
    
    public function updateAbsen($id_karyawan, $data) {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->update('absen', $data);
    }
    public function getStatusAbsen($id_karyawan, $tanggal) {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('date', $tanggal);
        $result = $this->db->get('absen')->row();

        if ($result) {
            return $result->status;
        }

        // Jika tidak ada data absen untuk tanggal tersebut, maka karyawan belum absen
        return 'belum_absen';
    }

    public function updateStatusAbsen($id_karyawan, $tanggal, $status) {
        $data = array('status' => $status);
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('date', $tanggal);
        $this->db->update('absen', $data);
    }
    // Mendapatkan data absen berdasarkan ID karyawan
    public function getAbsenByKaryawan($id_karyawan) {
        return $this->db->get_where('absen', ['id_karyawan' => $id_karyawan])->row();
    }
    // get karyawan page
    public function get_karyawan_page($limit, $offset) {
        $this->db->where('role', 'karyawan');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('user'); 
        return $query->result();
    }
    // count karyawan
    public function count_karyawan() {
        $this->db->where('role', 'karyawan');
        return $this->db->count_all_results('user'); 
    }
    // get history
    public function get_history_page($limit, $offset, $karyawan_id) {
        $this->db->where('id_karyawan', $karyawan_id);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('absensi'); 
        return $query->result();
    }
    // count history
    public function count_history($karyawan_id) {
        $this->db->where('id_karyawan', $karyawan_id);
        return $this->db->count_all_results('absensi'); 
    }
    // get karyawan
    public function get_karyawan($table)
    {
    return $this->db->where('role', 'karyawan')
                    ->get($table);
    }
    // count mingguan
    public function count_mingguan() {
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
    // page mingguan
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
    // get mingguan
    public function get_mingguan() {
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
    // harian
    public function count_harian($date) {
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
    public function get_harian_page($limit, $offset ,$date)
    {
        $this->db->where('date =', $date);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('absensi');
        return $query->result();
    }
    // Tahunan
    public function get_tahunan_page($limit, $offset ,$date)
    {
        $this->db->where("DATE_FORMAT(absensi.date, '%Y') =", $date);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('absensi');
        return $query->result();
    }
    public function count_tahunan($date) {
        $this->db->where("DATE_FORMAT(absensi.date, '%Y') =", $date);
        return $this->db->count_all_results('absensi'); 
    }
    public function get_tahunan($date)
    {
        $this->db->from('absensi');
        $this->db->where("DATE_FORMAT(absensi.date, '%Y') =", $date);
        $query = $this->db->get();
        return $query->result();
    }
    // absen
    public function count_absen() {
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
    public function get_bulanan_page($limit, $offset ,$date)
    {
        $this->db->where("DATE_FORMAT(absensi.date, '%m') =", $date);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('absensi');
        return $query->result();
    }
    public function count_bulanan($date) {
        $this->db->where("DATE_FORMAT(absensi.date, '%m') =", $date);
        return $this->db->count_all_results('absensi'); 
    }
}