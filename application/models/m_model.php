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
    function tambah_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    public function get_by_id($tabel, $id_column, $id)
    {
        $data = $this->db->where($id_column, $id)->get($tabel);
        return $data;
    }
    public function ubah_data($tabel, $data, $where)
    {
        $data = $this->db->update($tabel, $data, $where);
        return $this->db->affected_rows();
    }
    public function absensi($data) {
        $this->db->insert('absensi', $data);
    }
    public function register_user($data) { 
        // Masukkan data ke dalam tabel 'users' dan kembalikan hasilnya 
        return $this->db->insert('user', $data); 
    }
    public function get_history($table, $id_karyawan)
    {
        return $this->db->where('id_karyawan', $id_karyawan)->get($table);
    }
}