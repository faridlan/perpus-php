<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Anggota extends CI_Model
{

  function __construct()
  {
    // Set table name
    $this->table = 'tbl_login';
  }

  /*
     * Fetch members data from the database
     * @param array filter data based on the passed parameters
     */
  function getRows($params = array())
  {
    $this->db->select('*');
    $this->db->from($this->table);

    if (array_key_exists("where", $params)) {
      foreach ($params['where'] as $key => $val) {
        $this->db->where($key, $val);
      }
    }

    if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
      $result = $this->db->count_all_results();
    } else {
      if (array_key_exists("id", $params)) {
        $this->db->where('id', $params['id']);
        $query = $this->db->get();
        $result = $query->row_array();
      } else {
        $this->db->order_by('id', 'desc');
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
          $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
          $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
      }
    }

    // Return fetched data
    return $result;
  }

  /*
     * Insert members data into the database
     * @param $data data to be insert based on the passed parameters
     */
  public function insert($data = array())
  {
    if (!empty($data)) {
      // Add created and modified date if not included
      // if (!array_key_exists("created", $data)) {
      //   $data['created'] = date("Y-m-d H:i:s");
      // }
      // if (!array_key_exists("modified", $data)) {
      //   $data['modified'] = date("Y-m-d H:i:s");
      // }

      // Insert member data
      $insert = $this->db->insert($this->table, $data);

      // Return the status
      return $insert ? $this->db->insert_id() : false;
    }
    return false;
  }

  /*
     * Update member data into the database
     * @param $data array to be update based on the passed parameters
     * @param $condition array filter data
     */
  public function update($data, $condition = array())
  {
    if (!empty($data)) {
      // Add modified date if not included
      // if (!array_key_exists("modified", $data)) {
      //   $data['modified'] = date("Y-m-d H:i:s");
      // }

      // Update member data
      $update = $this->db->update($this->table, $data, $condition);

      // Return the status
      return $update ? true : false;
    }
    return false;
  }

  function gettahun()
  {
    $query = $this->db->query("SELECT YEAR(tgl_bergabung) AS tahun FROM tbl_login WHERE level = 'Anggota' GROUP BY YEAR(tgl_bergabung) ORDER BY YEAR(tgl_bergabung) ASC");
    return $query->result();
  }

  function filterbytanggal($tanggalawal, $tanggalakhir)
  {
    $this->db->select('tbl_login.*');
    $this->db->where('level = "Anggota"');
    $this->db->where('tgl_bergabung >=', $tanggalawal);
    $this->db->where('tgl_bergabung <=', $tanggalakhir);
    $this->db->order_by('kelas ASC');
    $this->db->from('tbl_login');
    $query = $this->db->get();

    return $query->result();
  }

  function filterbybulan($tahun1, $bulanawal)
  {
    $this->db->select('tbl_login.*');
    $this->db->where('level = "Anggota"');
    $this->db->where('year(tgl_bergabung)', $tahun1);
    $this->db->where('MONTH(tgl_bergabung)', $bulanawal);
    $this->db->order_by('kelas ASC');
    $this->db->from('tbl_login');
    $query = $this->db->get();

    return $query->result();
  }

  function filterbytahun($tahun2)
  {
    $this->db->select('tbl_login.*');
    $this->db->where('level = "Anggota"');
    $this->db->where('year(tgl_bergabung)', $tahun2);
    $this->db->order_by('kelas ASC');
    $this->db->from('tbl_login');
    $query = $this->db->get();

    return $query->result();
  }
}
