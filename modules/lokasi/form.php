 <?php  
// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form']=='add') { ?> 
  <!-- tampilan form add data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Input Lokasi
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=barang"> Kelompok Lokasi </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/lokasi/proses.php?act=insert" method="POST">
            <div class="box-body">
              <?php  
              // fungsi untuk membuat id transaksi
              $query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_lokasi,5) as kode FROM lokasi
                                                ORDER BY kode_lokasi DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil kode_kb : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                  // mengambil data kode_barang
                  $data_id = mysqli_fetch_assoc($query_id);
                  $kode    = $data_id['kode']+1;
              } else {
                  $kode = 1;
              }

              // buat kode_barang
              $buat_id   = str_pad($kode, 5, "0", STR_PAD_LEFT);
              $kode_lokasi = "LK$buat_id";
              ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Lokasi</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_lokasi" value="<?php echo $kode_lokasi; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Lokasi</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_lokasi" autocomplete="off" required>
                </div>
              </div>

               <div class="form-group">
                <label class="col-sm-2 control-label">Gedung Utama</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="gedung" data-placeholder="-- Pilih --" autocomplete="off" required>
                    <option value=""></option>
                    <option value="gudang1">Gudang 1</option>
                    <option value="gudang2">Gudang 2</option>
                    <option value="gudang3">Gudang 3</option>
                    <option value="gudang4">Gudang 4</option>
                    <option value="staging">Staging Area</option>
                    <option value="ba">Block Area</option>
                  </select>
                </div>
              </div>
                
              
            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=lokasi" class="btn btn-default btn-reset">Batal</a>
                </div>
              </div>
            </div><!-- /.box footer -->
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<?php
}
// jika form edit data yang dipilih
// isset : cek data ada / tidak
elseif ($_GET['form']=='edit') { 
  if (isset($_GET['id'])) {
      // fungsi query untuk menampilkan data dari tabel kelompok
      $query = mysqli_query($mysqli, "SELECT kode_lokasi,nama_lokasi,gedung FROM lokasi WHERE kode_lokasi='$_GET[id]'") 
                                      or die('Ada kesalahan pada query tampil Data kelompok : '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
    }
?>
  <!-- tampilan form edit data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Ubah Lokasi
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=barang"> Lokasi </a></li>
      <li class="active"> Ubah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/lokasi/proses.php?act=update" method="POST">
            <div class="box-body">
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Lokasi</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_lokasi" value="<?php echo $data['kode_lokasi']; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Lokasi</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_lokasi" autocomplete="off" value="<?php echo $data['nama_lokasi']; ?>" required>
                </div>
              </div>

              
               <div class="form-group">
                <label class="col-sm-2 control-label">Gedung Utama</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="gedung" data-placeholder="-- Pilih --" autocomplete="off" required>
                    <option value="<?php echo $data['gedung']; ?>"></option>
                    <option value="gudang1">Gudang 1</option>
                    <option value="gudang2">Gudang 2</option>
                    <option value="gudang3">Gudang 3</option>
                    <option value="gudang4">Gudang 4</option>
                    <option value="staging">Staging Area</option>
                    <option value="ba">Block Area</option>
                  </select>
                </div>
              </div>


            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=lokasi" class="btn btn-default btn-reset">Batal</a>
                </div>
              </div>
            </div><!-- /.box footer -->
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<?php
}
?>
