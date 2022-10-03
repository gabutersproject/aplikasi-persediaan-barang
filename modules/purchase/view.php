<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-sign-in icon-title"></i> Data Purchase

    <a class="btn btn-primary btn-social pull-right" href="?module=form_purchase&form" title="Tambah Data" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Tambah
    </a>
  </h1>

</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">

    <?php  
    // fungsi untuk menampilkan pesan
    // jika alert = "" (kosong)
    // tampilkan pesan "" (kosong)
    if (empty($_GET['alert'])) {
      echo "";
    } 
    // jika alert = 1
    // tampilkan pesan Sukses "Data barang keluar berhasil disimpan"
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Purchase berhasil disimpan.
            </div>";
    }
    ?>

      <div class="box box-primary">
        <div class="box-body">
          <!-- tampilan tabel barang -->
          <table id="dataTables1" class="table table-bordered table-striped table-hover">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">Kode Purchase</th>
                <th class="center">Tanggal</th>
                <th class="center">Kode Project</th>
                <th class="center">Nama barang</th>
                <th class="center">Detail</th>
                <th class="center">Harga Barang</th>
                <th class="center">Jumlah Barang</th>
                <th class="center">Satuan</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
            $no = 1;
            // fungsi query untuk menampilkan data dari tabel barang
            $query = mysqli_query($mysqli, "SELECT b.kode_purchase,b.tanggal_po,b.kode_project,a.kode_purchase,a.nama_barang,a.detail ,a.satuan,a.harga_barangp,a.jumlah
                                            FROM dpurchase as a INNER JOIN purchase as b ON a.kode_purchase=b.kode_purchase ")
                                            or die('Ada kesalahan pada query tampil Data Purchase: '.mysqli_error($mysqli));

            // tampilkan data
            while ($data = mysqli_fetch_assoc($query)) { 
              $tanggal         = $data['tanggal_po'];
              $exp             = explode('-',$tanggal);
              $tanggal_keluar   = $exp[2]."-".$exp[1]."-".$exp[0];

              // menampilkan isi tabel dari database ke tabel di aplikasi
              echo "<tr>
                      <td width='30' class='center'>$no</td>
                      <td width='100' class='center'>$data[kode_purchase]</td>
                      <td width='100' class='center'>$data[tanggal_po]</td>
                      <td width='150' class='center'>$data[kode_project]</td>
                      <td width='200'>$data[nama_barang]</td>
                      <td width='200'>$data[detail]</td>
                      <td width='50' align='right'>$data[harga_barangp]</td>
                      <td width='50' align='right'>$data[jumlah]</td>
                      <td width='80' class='center'>$data[satuan]</td>
                    </tr>";
              $no++;
            }
            ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col -->
  </div>   <!-- /.row -->
</section><!-- /.content
