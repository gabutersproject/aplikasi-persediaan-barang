<?php

include 'class/class.php'

?>  

<?php  
              // fungsi untuk membuat kode transaksi
              $query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_project,5) as kode FROM project
                                                ORDER BY kode_project DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil kode_project : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                  // mengambil data kode transaksi
                  $data_id = mysqli_fetch_assoc($query_id);
                  $koder    = $data_id['kode']+1;
              } else {
                  $koder = 1;
              }

              // buat kode_project
              $tahun          = date("Y");
              $buat_id        = str_pad($koder,5, "0", STR_PAD_LEFT);
              $kode= "TK-$tahun-$buat_id";
?>



<?php 
  
  $subtotal = $project->hitung_total_sementara($kode);
  $cekbarang = $project->cek_data_barangp($kode);
  $hari_ini = date("Y-m-d");
  $created_user = $_SESSION['username'];
  
  if (isset($_POST['tambah'])) {
    $cekitem = $project->cek_item($_GET['proses'],$_POST['item']);
    if ($cekitem === true) {
      $project->tambah_project_sementara($kode,$_GET['proses'],$_POST['item']);
      echo "<script>location='?module=form_project';</script>";
    }
  }

  
  if (isset($_POST['save'])) {
    
    $project->simpan_project($_POST['kdproject'],$_POST['tgltransaksi'],$_POST['nama_project'],$_POST['kdpurchase'],$_POST['kdklien'],$_POST['catatan'],$subtotal,$created_user);
    $pen = $project->ambil_kdpen();
    $kodepen = $pen['kode_project']; 
    echo "<script>location='?module=form_project';</script>";
    
    
  }

  if (isset($_GET['hapus'])) {
    $project->hapus_project_sementara($_GET['hapus']);
    echo "<script>location='?module=form_project';</script>";
  }

  $kdbar = "";
  $namabr = "";
  if (isset($_GET['proses'])) {
    $bar = $barang->ambil_barang($_GET['proses']);
    $namabr = $bar['nama_barang'];
    $kdbar = $_GET['proses'];
  }

?>

<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        FORM DATA BARANG
      </div>
      <div class="panel-body">
        <form method="POST">
          <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" class="form-control" id="kdbarang" name="kdbarang" disabled="disabled" value="<?php echo $kdbar; ?>">
          </div>
          <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" class="form-control" disabled="disabled" value="<?php echo $namabr; ?>">
          </div>
          <div class="form-group">
            <label>Jumlah Item</label>
            <input type="number" class="form-control" name="item" id="item" max="10000" min="0">
          </div>

      
          <div class="panel-footer">
          <?php if ($kdbar === ""): ?>        
            <button class="btn btn-info" name="tambah" id="tambah" disabled="disabled"><i class="fa fa-plus"></i> Tambah</button>
          <?php endif ?>
          <?php if ($kdbar !== ""): ?>
            <button class="btn btn-info" name="tambah" id="tambah"><i class="fa fa-plus"></i> Tambah</button>
          <?php endif ?>
          <a href="?module=project" class="btn btn-primary btn-info">Batal</a>
          </div>
      
        </form>
      </div>
    </div>

  <div class="col-md-6">
          <div class="panel panel-default">
              <div class="panel-heading">
              FORM PROJECT
              </div>
      
            <div class="panel-body">
              <!--Form-->
              <form method="POST">
                      <div class="form-group">
                        <label>Kode Project</label>
                        <input type="text" class="form-control" name="kdproject" id="kdproject" maxlength="20" readonly="true" value="<?php echo $kode; ?>">
                      </div>
                      <div class="form-group">
                          <label>Tanggal transaksi</label>
                          <input type="date" class="form-control" name="tgltransaksi" id="tgltransaksi"  >
                      </div>
                
                      <div class="form-group">
                          <label>Nama Project</label>
                          <input type="text" class="form-control" name="nama_project" id="nama_project">
                      </div>

               <div class="form-group">
                        <label class="col-sm-2 control-label">Kode Purchase</label>
                      <div class="col-sm-5">
                            <select class="chosen-select" name="kode_purchase" data-placeholder="-- Pilih Kode PO --"autocomplete="off" required>
                              <option value=""></option>
                              <?php
                                $query_purchase = mysqli_query($mysqli, "SELECT kode_purchase FROM purchase ORDER BY kode_purchase ASC")
                                                                      or die('Ada kesalahan pada query tampil barang: '.mysqli_error($mysqli));
                                while ($data_purchase = mysqli_fetch_assoc($query_purchase)) {
                                  echo"<option value=\"$data_purchase[kode_purchase]\"> $data_purchase[kode_purchase]  </option>";
                                }
                              ?>
                            </select>
                      </div>
                </div>

                      <div class="form-group">
                        <label>Kode Klien</label>
                        <input type="text" class="form-control" name="kdklien" id="kdklien">
                      </div>

                      <div class="form-group">
                        <label>Catatan</label>
                        <textarea class="form-control"  name="catatan" id="catatan" placeholder="catatan" ></textarea> 
                      </div>   

             
          </div>
        </div>
      </div>
