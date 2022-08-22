<?php if (!defined('BASEPATH')) exit('No direct script acess allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-edit" style="color:green"> </i> <?= $title_web; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
            <li class="active"><i class="fa fa-file-text"></i>&nbsp; <?= $title_web; ?></li>
        </ol>
    </section>
    <section class="content">
        <?php if (!empty($this->session->flashdata())) {
            echo $this->session->flashdata('pesan');
        } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <?php if ($this->session->userdata('level') == 'Petugas') { ?>
                            <a href="data/bukutambah"><button class="btn btn-primary">
                                    <i class="fa fa-plus"> </i> Tambah Buku</button></a>
                            <a data-toggle="modal" data-target="#TableBuku"><button class="btn btn-danger">
                                    <i class="fa fa-download"> </i> Laporan</button></a>
                        <?php } ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br />
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sampul</th>
                                        <th>ISBN</th>
                                        <th>Title</th>
                                        <th>Penerbit</th>
                                        <th>Tahun Buku</th>
                                        <th>Stok Buku</th>
                                        <th>Dipinjam</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($buku->result_array() as $isi) { ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td>
                                                <center>
                                                    <?php if (!empty($isi['sampul'] !== "0")) { ?>
                                                        <img src="<?php echo base_url(); ?>assets_style/image/buku/<?php echo $isi['sampul']; ?>" alt="#" class="img-responsive" style="height:auto;width:100px;" />
                                                    <?php } else { ?>
                                                        <!--<img src="" alt="#" class="user-image" style="border:2px solid #fff;"/>-->
                                                        <i class="fa fa-book fa-3x" style="color:#333;"></i> <br /><br />
                                                        Tidak Ada Sampul
                                                    <?php } ?>
                                                </center>
                                            </td>
                                            <td><?= $isi['isbn']; ?></td>
                                            <td><?= $isi['title']; ?></td>
                                            <td><?= $isi['penerbit']; ?></td>
                                            <td><?= $isi['thn_buku']; ?></td>
                                            <td><?= $isi['jml']; ?></td>
                                            <td>
                                                <?php
                                                $id = $isi['buku_id'];
                                                $dd = $this->db->query("SELECT * FROM tbl_pinjam WHERE buku_id= '$id' AND status = 'Dipinjam'");
                                                if ($dd->num_rows() > 0) {
                                                    echo $dd->num_rows();
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </td>
                                            <td><?= $isi['tgl_masuk']; ?></td>
                                            <td <?php if ($this->session->userdata('level') == 'Petugas') { ?>style="width:17%;" <?php } ?>>

                                                <?php if ($this->session->userdata('level') == 'Petugas') { ?>
                                                    <a href="<?= base_url('data/bukuedit/' . $isi['id_buku']); ?>"><button class="btn btn-success"><i class="fa fa-edit"></i></button></a>
                                                    <a href="<?= base_url('data/bukudetail/' . $isi['id_buku']); ?>">
                                                        <button class="btn btn-primary"><i class="fa fa-sign-in"></i> Detail</button></a>
                                                    <a href="<?= base_url('data/prosesbuku?buku_id=' . $isi['id_buku']); ?>" onclick="return confirm('Anda yakin Buku ini akan dihapus ?');">
                                                        <button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('data/bukudetail/' . $isi['id_buku']); ?>">
                                                        <button class="btn btn-primary"><i class="fa fa-sign-in"></i> Detail</button></a>
                                                <?php } ?>
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
                    <h4 class="modal-title">Laporan Anggota</h4>
                </div>
                <div id="modal_body" class="modal-body fileSelection1">
                    <div class="report1" style="background-color: rgba(230, 230, 230, 0.5); padding: 10px;">
                        <p class="h3" style="margin: 0px;">Laporan Pertanggal</p>
                        <form target="_blank" action="<?php echo base_url('Data/report'); ?>" method="POST">
                            <input type="hidden" name="nilaifilter" value="1">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tanggal Awal</label>
                                        <input class="form-control" type="date" name="tanggalawal" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <input class="form-control" type="date" name="tanggalakhir" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="pull-left">
                                        <button type="submit" class="btn btn-primary btn-md">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="report1" style="background-color: rgba(230, 230, 230, 0.5); padding: 10px; margin-top: 10px;">
                        <p class="h3" style="margin: 0px;">Laporan Perbulan</p>
                        <form target="_blank" action="<?php echo base_url('Data/report'); ?>" method="POST">
                            <input type="hidden" name="nilaifilter" value="2">
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Pilih Tahun</label>
                                        <select name="tahun1" class="form-control" required="required">
                                            <?php foreach ($tahun as $row) : ?>
                                                <option value="<?php echo $row->tahun ?>">
                                                    <?php echo $row->tahun ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Pilih Bulan</label>
                                        <select name="bulanawal" class="form-control" required="required">
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="pull-left">
                                        <button type="submit" class="btn btn-primary btn-md">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="report1" style="background-color: rgba(230, 230, 230, 0.5); padding: 10px; margin-top: 10px;">
                        <p class="h3" style="margin: 0px;">Laporan Pertahun</p>
                        <form target="_blank" action="<?php echo base_url('Data/report'); ?>" method="POST">
                            <input type="hidden" name="nilaifilter" value="3">
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Pilih Tahun</label>
                                        <select name="tahun2" class="form-control" required="required">
                                            <?php foreach ($tahun as $row) : ?>
                                                <option value="<?php echo $row->tahun ?>">
                                                    <?php echo $row->tahun ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="pull-left">
                                        <button type="submit" class="btn btn-primary btn-md">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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