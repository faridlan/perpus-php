<?php if (!defined('BASEPATH')) exit('No direct script acess allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-edit" style="color:green"> </i> Daftar Data User
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
            <li class="active"><i class="fa fa-file-text"></i>&nbsp; Daftar Data User</li>
        </ol>
    </section>
    <section class="content">
        <?php if (!empty($this->session->flashdata())) {
            echo $this->session->flashdata('pesan');
        } ?>
        <!-- Display status message -->
        <?php if (!empty($success_msg)) { ?>
            <div class="col-xs-12">
                <div class="alert alert-success"><?php echo $success_msg; ?></div>
            </div>
        <?php } ?>
        <?php if (!empty($error_msg)) { ?>
            <div class="col-xs-12">
                <div class="alert alert-danger"><?php echo $error_msg; ?></div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <a href="anggota/tambah"><button class="btn btn-primary"><i class="fa fa-plus"> </i> Tambah User</button></a>
                        <!-- <a href="anggota/tambah"><button class="btn btn-danger"><i class="fa fa-download"> </i> Laporan</button></a> -->
                        <a data-toggle="modal" data-target="#TableBuku1"><button class="btn btn-primary"><i class="fa fa-plus"> </i> Tambah CSV</button></a>
                        <a data-toggle="modal" data-target="#TableBuku"><button class="btn btn-danger"><i class="fa fa-download"> </i> Laporan</button></a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <br />
                            <table id="example1" class="table table-bordered table-striped table" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>User</th>
                                        <th>Jenkel</th>
                                        <th>Telepon</th>
                                        <th>Level</th>
                                        <th>Alamat</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($user as $isi) { ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $isi['anggota_id']; ?></td>
                                            <td>
                                                <center>
                                                    <?php if (!empty($isi['foto'] !== "-")) { ?>
                                                        <img src="<?php echo base_url(); ?>assets_style/image/<?php echo $isi['foto']; ?>" alt="#" class="img-responsive" style="height:auto;width:100px;" />
                                                    <?php } else { ?>
                                                        <!--<img src="" alt="#" class="user-image" style="border:2px solid #fff;"/>-->
                                                        <i class="fa fa-user fa-3x" style="color:#333;"></i>
                                                    <?php } ?>
                                                </center>
                                            </td>
                                            <td><?= $isi['nama']; ?></td>
                                            <td><?= $isi['user']; ?></td>
                                            <td><?= $isi['jenkel']; ?></td>
                                            <td><?= $isi['telepon']; ?></td>
                                            <td><?= $isi['level']; ?></td>
                                            <td><?= $isi['alamat']; ?></td>
                                            <td><?= $isi['kelas']; ?></td>
                                            <td><?= $isi['jurusan']; ?></td>
                                            <td style="width:20%;">
                                                <a href="<?= base_url('anggota/edit/' . $isi['id_login']); ?>"><button class="btn btn-success"><i class="fa fa-edit"></i></button></a>
                                                <a href="<?= base_url('anggota/del/' . $isi['id_login']); ?>" onclick="return confirm('Anda yakin user akan dihapus ?');">
                                                    <button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
                                                <a href="<?= base_url('anggota/detail/' . $isi['id_login']); ?>" target="_blank"><button class="btn btn-primary">
                                                        <i class="fa fa-print"></i> Cetak Kartu</button></a>
                                            </td>
                                        </tr>
                                    <?php $no++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--modal import -->
    <div class="modal fade" id="TableBuku">
        <div class="modal-dialog" style="width:40%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Buku</h4>
                </div>
                <div id="modal_body" class="modal-body fileSelection1">
                    <form action="<?php echo base_url('anggota/report'); ?>" method="POST">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Level</label>
                                    <select name="level" class="form-control" required="required">
                                        <option>Petugas</option>
                                        <option>Anggota</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Level</label>
                                    <select name="level" class="form-control" required="required">
                                        <option>Petugas</option>
                                        <option>Anggota</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Level</label>
                                    <select name="level" class="form-control" required="required">
                                        <option>Petugas</option>
                                        <option>Anggota</option>
                                    </select>
                                </div>
                                <div class="pull-left">
                                    <button type="submit" class="btn btn-primary btn-md">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->



    <!--modal import -->
    <div class="modal fade" id="TableBuku1">
        <div class="modal-dialog" style="width:40%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Buku</h4>
                </div>
                <div id="modal_body" class="modal-body fileSelection1">
                    <!-- <form action="<?php echo base_url('anggota/import'); ?>" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" accept=".csv" required />
                        <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
                    </form> -->
                    <form action="<?php echo base_url('anggota/import'); ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Level</label>
                                    <input type="file" name="file" class="form-control" accept=".csv" required />
                                </div>
                                <div class="pull-left">
                                    <input type="submit" class="btn btn-primary" name="importSubmit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>