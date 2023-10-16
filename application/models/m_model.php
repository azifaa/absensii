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
    
}