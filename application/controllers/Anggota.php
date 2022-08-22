<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    //validasi jika user belum login
    $this->data['CI'] = &get_instance();
    $this->load->helper(array('form', 'url'));
    $this->load->model('M_Admin');
    $this->load->model('M_Anggota');
    if ($this->session->userdata('masuk_sistem_rekam') != TRUE) {
      $url = base_url('login');
      redirect($url);
    }

    $this->load->library('form_validation');
    // $this->load->helper(array('file', 'url'));
  }

  public function index()
  {
    $this->data['idbo'] = $this->session->userdata('ses_id');
    // $this->data['user'] = $this->M_Admin->get_table('tbl_login');
    $this->data['user'] = $this->M_Admin->get_tableid('tbl_login', 'level', 'Anggota');

    $this->data['title_web'] = 'Data User ';
    $this->load->view('header_view', $this->data);
    $this->load->view('sidebar_view', $this->data);
    $this->load->view('user/anggota/user_view', $this->data);
    $this->load->view('footer_view', $this->data);
  }

  public function tambah()
  {
    $this->data['idbo'] = $this->session->userdata('ses_id');
    $this->data['user'] = $this->M_Admin->get_table('tbl_login');

    $this->data['title_web'] = 'Tambah User ';
    $this->load->view('header_view', $this->data);
    $this->load->view('sidebar_view', $this->data);
    $this->load->view('user/anggota/tambah_view', $this->data);
    $this->load->view('footer_view', $this->data);
  }

  public function add()
  {
    // format tabel / kode baru 3 hurup / id tabel / order by limit ngambil data terakhir
    $id = $this->M_Admin->buat_kode('tbl_login', 'AG', 'id_login', 'ORDER BY id_login DESC LIMIT 1');
    $nama = htmlentities($this->input->post('nama', TRUE));
    $user = htmlentities($this->input->post('user', TRUE));
    $pass = md5(htmlentities($this->input->post('pass', TRUE)));
    // $level = htmlentities($this->input->post('level', TRUE));
    $level = 'Anggota';
    $jenkel = htmlentities($this->input->post('jenkel', TRUE));
    $telepon = htmlentities($this->input->post('telepon', TRUE));
    $status = htmlentities($this->input->post('status', TRUE));
    $alamat = htmlentities($this->input->post('alamat', TRUE));
    $jurusan = htmlentities($this->input->post('jurusan', TRUE));
    $kelas = htmlentities($this->input->post('kelas', TRUE));
    $email = $_POST['email'];

    $dd = $this->db->query("SELECT * FROM tbl_login WHERE user = '$user' OR email = '$email'");
    if ($dd->num_rows() > 0) {
      $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-warning">
			<p> Gagal Update User : ' . $nama . ' !, Username / Email Anda Sudah Terpakai</p>
			</div></div>');
      redirect(base_url('user/anggota/tambah'));
    } else {
      // setting konfigurasi upload
      $nmfile = "user_" . time();
      $config['upload_path'] = './assets_style/image/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['file_name'] = $nmfile;
      // load library upload
      $this->load->library('upload', $config);
      // upload gambar 1
      $this->upload->do_upload('gambar');
      $result1 = $this->upload->data();
      $result = array('gambar' => $result1);
      $data1 = array('upload_data' => $this->upload->data());
      $data = array(
        'anggota_id' => $id,
        'nama' => $nama,
        'user' => $user,
        'pass' => $pass,
        'level' => $level,
        'tempat_lahir' => $_POST['lahir'],
        'tgl_lahir' => $_POST['tgl_lahir'],
        'level' => $level,
        'email' => $_POST['email'],
        'telepon' => $telepon,
        'foto' => $data1['upload_data']['file_name'],
        'jenkel' => $jenkel,
        'alamat' => $alamat,
        'tgl_bergabung' => date('Y-m-d'),
        'kelas' => $kelas,
        'jurusan' => $jurusan
      );
      $this->db->insert('tbl_login', $data);

      $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
            <p> Daftar User telah berhasil !</p>
            </div></div>');
      redirect(base_url('anggota'));
    }
  }

  public function edit()
  {
    if ($this->session->userdata('level') == 'Petugas') {
      if ($this->uri->segment('3') == '') {
        echo '<script>alert("halaman tidak ditemukan");window.location="' . base_url('anggota') . '";</script>';
      }
      $this->data['idbo'] = $this->session->userdata('ses_id');
      $count = $this->M_Admin->CountTableId('tbl_login', 'id_login', $this->uri->segment('3'));
      if ($count > 0) {
        $this->data['user'] = $this->M_Admin->get_tableid_edit('tbl_login', 'id_login', $this->uri->segment('3'));
      } else {
        echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('anggota') . '"</script>';
      }
    } elseif ($this->session->userdata('level') == 'Anggota') {
      $this->data['idbo'] = $this->session->userdata('ses_id');
      $count = $this->M_Admin->CountTableId('tbl_login', 'id_login', $this->uri->segment('3'));
      if ($count > 0) {
        $this->data['user'] = $this->M_Admin->get_tableid_edit('tbl_login', 'id_login', $this->session->userdata('ses_id'));
      } else {
        echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('anggota') . '"</script>';
      }
    }
    $this->data['title_web'] = 'Edit User ';
    $this->load->view('header_view', $this->data);
    $this->load->view('sidebar_view', $this->data);
    $this->load->view('user/anggota/edit_view', $this->data);
    $this->load->view('footer_view', $this->data);
  }

  public function detail()
  {
    if ($this->session->userdata('level') == 'Petugas') {
      if ($this->uri->segment('3') == '') {
        echo '<script>alert("halaman tidak ditemukan");window.location="' . base_url('anggota') . '";</script>';
      }
      $this->data['idbo'] = $this->session->userdata('ses_id');
      $count = $this->M_Admin->CountTableId('tbl_login', 'id_login', $this->uri->segment('3'));
      if ($count > 0) {
        $this->data['user'] = $this->M_Admin->get_tableid_edit('tbl_login', 'id_login', $this->uri->segment('3'));
      } else {
        echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('anggota') . '"</script>';
      }
    } elseif ($this->session->userdata('level') == 'Anggota') {
      $this->data['idbo'] = $this->session->userdata('ses_id');
      $count = $this->M_Admin->CountTableId('tbl_login', 'id_login', $this->session->userdata('ses_id'));
      if ($count > 0) {
        $this->data['user'] = $this->M_Admin->get_tableid_edit('tbl_login', 'id_login', $this->session->userdata('ses_id'));
      } else {
        echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('anggota') . '"</script>';
      }
    }
    $this->data['title_web'] = 'Print Kartu Anggota ';
    $this->load->view('user/anggota/detail', $this->data);
  }

  public function upd()
  {
    $nama = htmlentities($this->input->post('nama', TRUE));
    $user = htmlentities($this->input->post('user', TRUE));
    $pass = htmlentities($this->input->post('pass'));
    $level = htmlentities($this->input->post('level', TRUE));
    $jenkel = htmlentities($this->input->post('jenkel', TRUE));
    $telepon = htmlentities($this->input->post('telepon', TRUE));
    $kelas = htmlentities($this->input->post('kelas', TRUE));
    $jurusan = htmlentities($this->input->post('jurusan', TRUE));
    $status = htmlentities($this->input->post('status', TRUE));
    $alamat = htmlentities($this->input->post('alamat', TRUE));
    $id_login = htmlentities($this->input->post('id_login', TRUE));

    // setting konfigurasi upload
    $nmfile = "user_" . time();
    $config['upload_path'] = './assets_style/image/';
    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['file_name'] = $nmfile;
    // load library upload
    $this->load->library('upload', $config);
    // upload gambar 1


    if (!$this->upload->do_upload('gambar')) {
      if ($this->input->post('pass') !== '') {
        $data = array(
          'nama' => $nama,
          'user' => $user,
          'pass' => md5($pass),
          'tempat_lahir' => $_POST['lahir'],
          'tgl_lahir' => $_POST['tgl_lahir'],
          'level' => $level,
          'email' => $_POST['email'],
          'telepon' => $telepon,
          'jenkel' => $jenkel,
          'alamat' => $alamat,
          'kelas' => $kelas,
          'jurusan' => $jurusan
        );
        $this->M_Admin->update_table('tbl_login', 'id_login', $id_login, $data);
        if ($this->session->userdata('level') == 'Petugas') {

          $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
					<p> Berhasil Update User : ' . $nama . ' !</p>
					</div></div>');
          redirect(base_url('user'));
        } elseif ($this->session->userdata('level') == 'Anggota') {

          $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
					<p> Berhasil Update User : ' . $nama . ' !</p>
					</div></div>');
          redirect(base_url('user/anggota/edit/' . $id_login));
        }
      } else {
        $data = array(
          'nama' => $nama,
          'user' => $user,
          'tempat_lahir' => $_POST['lahir'],
          'tgl_lahir' => $_POST['tgl_lahir'],
          'level' => $level,
          'email' => $_POST['email'],
          'telepon' => $telepon,
          'jenkel' => $jenkel,
          'alamat' => $alamat,
          'kelas' => $kelas,
          'jurusan' => $jurusan
        );
        $this->M_Admin->update_table('tbl_login', 'id_login', $id_login, $data);

        if ($this->session->userdata('level') == 'Petugas') {

          $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
					<p> Berhasil Update User : ' . $nama . ' !</p>
					</div></div>');
          redirect(base_url('anggota'));
        } elseif ($this->session->userdata('level') == 'Anggota') {

          $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
					<p> Berhasil Update User : ' . $nama . ' !</p>
					</div></div>');
          redirect(base_url('user/anggota/edit/' . $id_login));
        }
      }
    } else {
      $result1 = $this->upload->data();
      $result = array('gambar' => $result1);
      $data1 = array('upload_data' => $this->upload->data());
      unlink('./assets_style/image/' . $this->input->post('foto'));
      if ($this->input->post('pass') !== '') {
        $data = array(
          'nama' => $nama,
          'user' => $user,
          'tempat_lahir' => $_POST['lahir'],
          'tgl_lahir' => $_POST['tgl_lahir'],
          'pass' => md5($pass),
          'level' => $level,
          'email' => $_POST['email'],
          'telepon' => $telepon,
          'foto' => $data1['upload_data']['file_name'],
          'jenkel' => $jenkel,
          'alamat' => $alamat
        );
        $this->M_Admin->update_table('tbl_login', 'id_login', $id_login, $data);

        if ($this->session->userdata('level') == 'Petugas') {

          $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
					<p> Berhasil Update User : ' . $nama . ' !</p>
					</div></div>');
          redirect(base_url('anggota'));
        } elseif ($this->session->userdata('level') == 'Anggota') {

          $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
					<p> Berhasil Update User : ' . $nama . ' !</p>
					</div></div>');
          redirect(base_url('user/anggota/edit/' . $id_login));
        }
      } else {
        $data = array(
          'nama' => $nama,
          'user' => $user,
          'tempat_lahir' => $_POST['lahir'],
          'tgl_lahir' => $_POST['tgl_lahir'],
          'level' => $level,
          'email' => $_POST['email'],
          'telepon' => $telepon,
          'foto' => $data1['upload_data']['file_name'],
          'jenkel' => $jenkel,
          'alamat' => $alamat
        );
        $this->M_Admin->update_table('tbl_login', 'id_login', $id_login, $data);

        if ($this->session->userdata('level') == 'Petugas') {

          $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
					<p> Berhasil Update User : ' . $nama . ' !</p>
					</div></div>');
          redirect(base_url('user'));
        } elseif ($this->session->userdata('level') == 'Anggota') {

          $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
					<p> Berhasil Update User : ' . $nama . ' !</p>
					</div></div>');
          redirect(base_url('user/anggota/edit/' . $id_login));
        }
      }
    }
  }
  public function del()
  {
    if ($this->uri->segment('3') == '') {
      echo '<script>alert("halaman tidak ditemukan");window.location="' . base_url('user') . '";</script>';
    }

    $user = $this->M_Admin->get_tableid_edit('tbl_login', 'id_login', $this->uri->segment('3'));
    unlink('./assets_style/image/' . $user->foto);
    $this->M_Admin->delete_table('tbl_login', 'id_login', $this->uri->segment('3'));

    $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-warning">
		<p> Berhasil Hapus User !</p>
		</div></div>');
    redirect(base_url('anggota'));
  }

  public function importView()
  {

    $this->data['title_web'] = 'Data User ';
    $this->load->view('user/anggota/import_csv', $this->data);
  }

  public function import()
  {
    $memData = array();

    // If import request is submitted
    // if ($this->input->post('importSubmit')) {
    //   // Form field validation rules
    //   $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');

    //   // Validate submitted form data
    //   if ($this->form_validation->run() == true) {
    //     $insertCount = $updateCount = $rowCount = $notAddCount = 0;

    //     // If file uploaded
    //     if (is_uploaded_file($_FILES['file']['tmp_name'])) {
    //       // Load CSV reader library
    //       $this->load->library('CSVReader');

    //       // Parse data from CSV file
    //       $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
    //       $id = $this->M_Admin->buat_kode('tbl_login', 'AG', 'id_login', 'ORDER BY id_login DESC LIMIT 1');

    //       // Insert/update CSV data into database
    //       if (!empty($csvData)) {
    //         foreach ($csvData as $row) {
    //           $rowCount++;

    //           // Prepare data for DB insertion
    //           $memData = array(
    //             'anggota_id' => $id,
    //             'nama' => $row['nama'],
    //             'user' => $row['user'],
    //             'pass' => $row['pass'],
    //             'level' => 'Anggota',
    //             'tempat_lahir' => $row['tempat_lahir'],
    //             'tgl_lahir' => $row['tgl_lahir'],
    //             'email' => $row['email'],
    //             'telepon' => $row['telepon'],
    //             'foto' => $row['foto'],
    //             'jenkel' => $row['jenkel'],
    //             'alamat' => $row['alamat'],
    //             'tgl_bergabung' => date('Y-m-d'),
    //             'kelas' => $row['kelas'],
    //             'jurusan' => $row['jurusan']
    //           );

    //           // Check whether email already exists in the database
    //           $con = array(
    //             'where' => array(
    //               'email' => $row['email']
    //             ),
    //             'returnType' => 'count'
    //           );
    //           $prevCount = $this->M_Anggota->getRows($con);

    //           if ($prevCount > 0) {
    //             // Update member data
    //             $condition = array('email' => $row['email']);
    //             $update = $this->M_Anggota->update($memData, $condition);

    //             if ($update) {
    //               $updateCount++;
    //             }
    //           } else {
    //             // Insert member data
    //             $insert = $this->M_Anggota->insert($memData);

    //             if ($insert) {
    //               $insertCount++;
    //             }
    //           }
    //         }

    //         // Status message with imported data count
    //         $notAddCount = ($rowCount - ($insertCount + $updateCount));
    //         $successMsg = 'Members imported successfully. Total Rows (' . $rowCount . ') | Inserted (' . $insertCount . ') | Updated (' . $updateCount . ') | Not Inserted (' . $notAddCount . ')';
    //         $this->session->set_userdata('success_msg', $successMsg);
    //       }
    //     } else {
    //       $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
    //     }
    //   } else {
    //     $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
    //   }
    // }
    // redirect('/anggota');

    if ($this->input->post('importSubmit')) {
      $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
      if ($this->form_validation->run() == false) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
          echo "ANJING BERHASIL";
        } else {
          echo 'hehe';
        }
      } else {
        echo "ANJING GA BERHASIL";
      }
    } else {
      echo "ANJING TEU KAPENCET";
    }

    // $this->load->helper(array('form', 'url'));

    // $this->load->library('form_validation');

    // if ($this->form_validation->run() == FALSE) {
    //   echo "ANJING BERHASIL";
    // } else {
    //   echo "ANJING GA BERHASIL";
    // }
  }

  public function addMany()
  {
  }

  public function report()
  {
    # code...
  }
}
