<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print laporan</title>
</head>
<style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td,
  th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }
</style>

<body>

  <center>
    <H3><?php echo $title ?></H1>
  </center>
  <H5><?php echo $subtitle ?>
    <hr>

    <table border="1">
      <thead>
        <tr>
          <th>NO</th>
          <th>ISBN</th>
          <th>JUDUL</th>
          <th>PENERBIT</th>
          <th>PENGARANG</th>
          <th>TAHUN BUKU</th>
          <th>TANGGAL MASUK</th>
          <th>JUMLAH</th>
          <th>RAK</th>

        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        foreach ($datafilter as $row) : ?>
          <tr>

            <td><?php echo $no++; ?></td>
            <td><?php echo $row->isbn; ?></td>
            <td><?php echo $row->title; ?></td>
            <td><?php echo $row->penerbit; ?></td>
            <td><?php echo $row->pengarang; ?></td>
            <td><?php echo $row->thn_buku; ?></td>
            <td><?php echo $row->tgl_masuk; ?></td>
            <td><?php echo $row->jml; ?></td>
            <td><?php echo $row->rak; ?></td>

          </tr>

        <?php endforeach ?>

        </tr>
      </tbody>

    </table>
    <script type="text/javascript">
      window.print();
    </script>

</body>

</html>