<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-file-text-o icon-title"></i> Laporan Stok barang

    <a class="btn btn-primary btn-social pull-right" href="modules/lap-stok/cetak.php" target="_blank">
      <i class="fa fa-print"></i> Cetak
    </a>
    <a class="btn btn-primary btn-social pull-right" href="modules/lap-stok/export.php" target="_blank">
      <i class="fa fa-excel"></i> Excel
    </a>
  </h1>

</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-body">
          <!-- tampilan tabel barang -->
          <table id="dataTables1" class="table table-bordered table-striped table-hover">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">Kode barang</th>
                <th class="center">Nama barang</th>
                <th class="center">Harga Beli</th>
                <th class="center">Harga Jual</th>
                <th class="center">Stok</th>
                <th class="center">Satuan</th>
                <th class="center">Lokasi</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
            $no = 1;
            // fungsi query untuk menampilkan data dari tabel barang
           $query = mysqli_query($mysqli, "SELECT a.kode_barang,a.nama_barang,a.harga_beli,a.harga_jual,a.stok,a.kode_lokasi,a.satuan,b.kode_lokasi,b.nama_lokasi
                                            FROM is_barang as a INNER JOIN lokasi as b ON a.kode_lokasi=b.kode_lokasi ")
                                            or die('Ada kesalahan pada query tampil Data barang Masuk: '.mysqli_error($mysqli));

            // tampilkan data
            while ($data = mysqli_fetch_assoc($query)) { 
              $harga_beli = format_rupiah($data['harga_beli']);
              $harga_jual = format_rupiah($data['harga_jual']);
              // menampilkan isi tabel dari database ke tabel di aplikasi
              echo "<tr>
                      <td width='30' class='center'>$no</td>
                      <td width='80' class='center'>$data[kode_barang]</td>
                      <td width='180'>$data[nama_barang]</td>
                      <td width='60' align='right'>Rp. $harga_beli</td>
                      <td width='60' align='right'>Rp. $harga_jual</td>
                      <td width='60' align='right'>$data[stok]</td>
                      <td width='60' class='center'>$data[satuan]</td>
                      <td width='60' class='center'>$data[nama_lokasi]</td>
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
