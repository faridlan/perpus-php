<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Buku extends CI_Model
{

  function gettahun()
  {
    $query = $this->db->query("SELECT YEAR(tgl_masuk) AS tahun FROM tbl_buku GROUP BY YEAR(tgl_masuk) ORDER BY YEAR(tgl_masuk) ASC");
    return $query->result();
  }

  function filterbytanggal($tanggalawal, $tanggalakhir)
  {
    $this->db->select('tbl_buku.*, tbl_rak.nama_rak AS rak');
    $this->db->join('tbl_rak', 'tbl_buku.id_rak = tbl_rak.id_rak', 'inner');
    $this->db->where('tgl_masuk >=', $tanggalawal);
    $this->db->where('tgl_masuk <=', $tanggalakhir);
    $this->db->order_by('title ASC');
    $this->db->from('tbl_buku');
    $query = $this->db->get();

    return $query->result();
  }

  function filterbybulan($tahun1, $bulanawal)
  {
    $this->db->select('tbl_buku.*, tbl_rak.nama_rak AS rak');
    $this->db->join('tbl_rak', 'tbl_buku.id_rak = tbl_rak.id_rak', 'inner');
    $this->db->where('year(tgl_masuk)', $tahun1);
    $this->db->where('MONTH(tgl_masuk)', $bulanawal);
    $this->db->order_by('title ASC');
    $this->db->from('tbl_buku');
    $query = $this->db->get();

    return $query->result();
  }

  function filterbytahun($tahun2)
  {
    $this->db->select('tbl_buku.*, tbl_rak.nama_rak AS rak');
    $this->db->join('tbl_rak', 'tbl_buku.id_rak = tbl_rak.id_rak', 'inner');
    $this->db->where('year(tgl_masuk)', $tahun2);
    $this->db->order_by('title ASC');
    $this->db->from('tbl_buku');
    $query = $this->db->get();

    return $query->result();
  }
}
