<?php

if (!defined('BASEPATH')) exit('No direct script acess allowed');


class M_Transaksi extends CI_Model
{

  function gettahun()
  {
    $query = $this->db->query("SELECT YEAR(tgl_pinjam) AS tahun  FROM tbl_pinjam GROUP BY YEAR(tgl_pinjam) ORDER BY YEAR(tgl_pinjam) ASC");
    return $query->result();
  }

  function filterbytanggal($tanggalawal, $tanggalakhir, $status)
  {
    //$query = $this->db->query("SELECT * FROM tbl_pinjam where tgl_pinjam BETWEEN '$tanggalawal' and '$tanggalakhir' ORDER BY tgl_pinjam ASC");

    $this->db->select('tbl_pinjam.*, tbl_buku.buku_id AS buku_id, tbl_buku.title, tbl_denda.pinjam_id AS pinjam_id, tbl_denda.denda');
    // $this->db->select('tbl_pinjam.*, tbl_buku.buku_id AS buku_id, tbl_buku.title, tbl_anggota.no_anggota as no_anggota, tbl_anggota.nama,
    // tbl_denda.pinjam_id AS pinjam_id, tbl_denda.denda');
    $this->db->join('tbl_buku', 'tbl_pinjam.buku_id = tbl_buku.buku_id', 'left');
    // $this->db->join('tbl_anggota', 'tbl_pinjam.no_anggota = tbl_anggota.no_anggota', 'left');
    $this->db->join('tbl_denda', 'tbl_denda.pinjam_id = tbl_pinjam.pinjam_id', 'left');
    if ($status == 'Dipinjam') {
      $this->db->where('status = "Dipinjam"');
      $this->db->where('tgl_pinjam >=', $tanggalawal);
      $this->db->where('tgl_pinjam <=', $tanggalakhir);
      $this->db->order_by('tgl_pinjam ASC');
    } else {
      $this->db->where('status = "Di Kembalikan"');
      $this->db->where('tgl_kembali >=', $tanggalawal);
      $this->db->where('tgl_kembali <=', $tanggalakhir);
      $this->db->order_by('tgl_kembali ASC');
    }
    $this->db->from('tbl_pinjam');
    $query = $this->db->get();

    return $query->result();
  }

  function filterbybulan($tahun1, $bulanawal, $status)
  {
    $this->db->select('tbl_pinjam.*, tbl_buku.buku_id AS buku_id, tbl_buku.title,tbl_denda.pinjam_id AS pinjam_id, tbl_denda.denda');
    // $this->db->select('tbl_pinjam.*, tbl_buku.buku_id AS buku_id, tbl_buku.title, tbl_anggota.no_anggota as no_anggota, tbl_anggota.nama,
    // tbl_denda.pinjam_id AS pinjam_id, tbl_denda.denda');
    $this->db->join('tbl_buku', 'tbl_pinjam.buku_id = tbl_buku.buku_id', 'left');
    // $this->db->join('tbl_anggota', 'tbl_pinjam.no_anggota = tbl_anggota.no_anggota', 'left');
    $this->db->join('tbl_denda', 'tbl_denda.pinjam_id = tbl_pinjam.pinjam_id', 'left');
    if ($status == 'Dipinjam') {
      $this->db->where('status = "Dipinjam"');
      $this->db->where('year(tgl_pinjam)', $tahun1);
      $this->db->where('MONTH(tgl_pinjam)', $bulanawal);
      $this->db->order_by('tgl_pinjam ASC');
    } else {
      $this->db->where('status = "Di Kembalikan"');
      $this->db->where('year(tgl_kembali)', $tahun1);
      $this->db->where('MONTH(tgl_kembali)', $bulanawal);
      $this->db->order_by('tgl_kembali ASC');
    }

    $this->db->from('tbl_pinjam');
    $query = $this->db->get();

    return $query->result();
  }

  function filterbytahun($tahun2, $status)
  {

    $this->db->select('tbl_pinjam.*, tbl_buku.buku_id AS buku_id, tbl_buku.title,tbl_denda.pinjam_id AS pinjam_id, tbl_denda.denda');
    // $this->db->select('tbl_pinjam.*, tbl_buku.buku_id AS buku_id, tbl_buku.title, tbl_anggota.no_anggota as no_anggota, tbl_anggota.nama,
    // tbl_denda.pinjam_id AS pinjam_id, tbl_denda.denda');
    $this->db->join('tbl_buku', 'tbl_pinjam.buku_id = tbl_buku.buku_id', 'left');
    // $this->db->join('tbl_anggota', 'tbl_pinjam.no_anggota = tbl_anggota.no_anggota', 'left');
    $this->db->join('tbl_denda', 'tbl_denda.pinjam_id = tbl_pinjam.pinjam_id', 'left');
    if ($status == 'Dipinjam') {
      $this->db->where('status = "Dipinjam"');
      $this->db->where('year(tgl_pinjam)', $tahun2);
      $this->db->order_by('tgl_pinjam ASC');
    } else {
      $this->db->where('status = "Di Kembalikan"');
      $this->db->where('year(tgl_kembali)', $tahun2);
      $this->db->order_by('tgl_kembali ASC');
    }

    $this->db->from('tbl_pinjam');
    $query = $this->db->get();

    return $query->result();
  }
}
