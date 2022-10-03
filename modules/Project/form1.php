 <?php  
// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form']=='add') { ?> 
  <!-- tampilan form add data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Input Project
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=project"> project </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/project/proses.php?act=insert" method="POST">
            <div class="box-body">
              
              <?php  
              // fungsi untuk membuat kode transaksi
              $query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_project,20) as kode FROM project
                                                ORDER BY kode_project DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil kode_project : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                  // mengambil data kode transaksi
                  $data_id = mysqli_fetch_assoc($query_id);
                  $kode    = $data_id['kode']+1;
              } else {
                  $kode = 1;
              }

              // buat kode_transaksi
              $array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
              $bulan = $array_bulan[date('n')];
              $tahun          = date("Y");
              $buat_id        = str_pad($kode,5, "0", STR_PAD_LEFT);

              $kode= "$buat_id/PJ/$bulan/$tahun";
              ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Project</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_project" value="<?php echo $kode; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Project</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_project" autocomplete="off" required>
                </div>
              </div>

               <div class="form-group">
                <label class="col-sm-2 control-label">Pemesan</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="kode_klien" data-placeholder="-- Pilih klien --" autocomplete="off" required>
                    <option value=""></option>
                    <?php
                      $query_klien = mysqli_query($mysqli, "SELECT kode_klien, nama_klien FROM klien ORDER BY nama_klien ASC")
                                                            or die('Ada kesalahan pada query tampil klien: '.mysqli_error($mysqli));
                      while ($data_klien = mysqli_fetch_assoc($query_klien)) {
                        echo"<option value=\"$data_klien[kode_klien]\"> $data_klien[kode_klien] | $data_klien[nama_klien] </option>";
                      }
                    ?>
                  </select>
                </div>
              </div>

             <div class="form-group">
                <label class="col-sm-2 control-label">Tanggal Order</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal_order" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                </div>
              </div>


               <div class="form-group">
                <label class="col-sm-2 control-label">Tanggal Kirim</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal_kirim" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">kontak</label>
                <div class="col-sm-5">
                  <div class="input-group">
                  
                    <input type="text" class="form-control" id="kontak" name="kontak" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" required>
                  </div>
                </div>
              </div>

             

              <div class="form-group">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="status" data-placeholder="-- Pilih --" autocomplete="off" required>
                    <option value=""></option>
                    <option value="Not Started">Not Started</option>
                    <option value="Inprogress">Inprogress</option>
                    <option value="Finished">Finished</option>
                    <option value="Pending">Pending</option>
                    
                  </select>
                </div>
              </div>

            

               

            
            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=project" class="btn btn-default btn-reset">Batal</a>
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
      // fungsi query untuk menampilkan data dari tabel barang
      $query = mysqli_query($mysqli, "SELECT kode_project,nama_project,tanggal_order,tanggal_kirim,kode_klien,kontak,status FROM project WHERE kode_project='$_GET[id]'") 
                                      or die('Ada kesalahan pada query tampil Data Project : '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
    }
?>
  <!-- tampilan form edit data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Ubah Project
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=project"> Project</a></li>
      <li class="active"> Ubah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/project/proses.php?act=update" method="POST">
            <div class="box-body">
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Project</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_project" value="<?php echo $data['kode_project']; ?>" readonly required>
                </div>
              </div>
                <div class="form-group">
                <label class="col-sm-2 control-label">Nama Project</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_project" value="<?php echo $data['nama_project']; ?>" autocomplete="off" required>
                </div>
              </div>

               <div class="form-group">
                <label class="col-sm-2 control-label">Pemesan</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="kode_klien" data-placeholder="-- Pilih klien --" autocomplete="off" required>
                    <option value="<?php echo $data['kode_klien']; ?>"></option>
                    <?php
                      $query_klien = mysqli_query($mysqli, "SELECT kode_klien, nama_klien FROM klien ORDER BY nama_klien ASC")
                                                            or die('Ada kesalahan pada query tampil klien: '.mysqli_error($mysqli));
                      while ($data_klien = mysqli_fetch_assoc($query_klien)) {
                        echo"<option value=\"$data_klien[kode_klien]\"> $data_klien[kode_klien] | $data_klien[nama_klien] </option>";
                      }
                    ?>
                  </select>
                </div>
              </div>

                <div class="form-group">
                <label class="col-sm-2 control-label">Tanggal Order</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal_order" autocomplete="off" value="<?php echo $data['tanggal_order']; ?>" required>
                </div>
              </div>


               <div class="form-group">
                <label class="col-sm-2 control-label">Tanggal Kirim</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal_kirim" autocomplete="off" value="<?php echo $data['tanggal_kirim']; ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">kontak</label>
                <div class="col-sm-5">
                  <div class="input-group">
                  
                    <input type="text" class="form-control" id="kontak" name="kontak" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo $data['kontak']; ?>" required>
                  </div>
                </div>
              </div>

             

              <div class="form-group">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="status" data-placeholder="-- Pilih --" autocomplete="off" required>
                   <option value="<?php echo $data['status']; ?>"></option>
                    <option value="Not Started">Not Started</option>
                    <option value="Inprogress">Inprogress</option>
                    <option value="Finished">Finished</option>
                    <option value="Pending">Pending</option>
                    
                  </select>
                </div>
              </div>
              
            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=project" class="btn btn-default btn-reset">Batal</a>
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
