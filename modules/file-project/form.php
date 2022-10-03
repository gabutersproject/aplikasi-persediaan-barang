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

 <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Input barang
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=project"> Project </a></li>
      <li><a href="?module=form_project"> Input Data Project </a></li>
     
    </ol>
  </section>


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
        </div>

                  <div class="panel-footer">
                      <?php if ($kdbar === ""): ?>        
                        <button class="btn btn-info" name="tambah" id="tambah" disabled="disabled"><i class="fa fa-plus"></i> Tambah</button>
                      <?php endif ?>
                      <?php if ($kdbar !== ""): ?>
                        <button class="btn btn-info" name="tambah" id="tambah"><i class="fa fa-plus"></i> Tambah</button>
                      <?php endif ?>
                      <a href="?module=form_project" class="btn btn-primary btn-info">Batal</a>
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
                                  <label >Kode Purchase</label>
                                  
                                      <select class="chosen-select" name="kdpurchase" data-placeholder="-- Pilih Kode PO --"autocomplete="off" required>
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

                         <div class="form-group">
                                  <label >Kode klien</label>
                                  
                                      <select class="chosen-select" name="kdklien" data-placeholder="-- Pilih klien--"autocomplete="off" required>
                                        <option value=""></option>
                                        <?php
                                          $query_klien = mysqli_query($mysqli, "SELECT kode_klien,nama_klien FROM klien ORDER BY kode_klien ASC")
                                                                                or die('Ada kesalahan pada query tampil klien: '.mysqli_error($mysqli));
                                          while ($data_klien = mysqli_fetch_assoc($query_klien)) {
                                            echo"<option value=\"$data_klien[kode_klien]\"> $data_klien[kode_klien] | $data_klien[nama_klien]  </option>";
                                          }
                                        ?>
                                      </select>
                                  
                          </div>

                          <div class="form-group">
                            <label>Catatan</label>
                            <textarea class="form-control"  name="catatan" id="catatan" placeholder="catatan" ></textarea> 
                          </div>   

             
          </div>
        </div>
      </div>



  <div class="col-md-12">
    <div class="panel-footer" align="center">
    <?php if ($cekbarang === true): ?>
      <button id="formbtn" class="btn btn-primary" name="save" value="save"><i class="fa fa-save"></i> Simpan</button>
      
    <?php endif ?>
    <?php if ($cekbarang === false): ?>
      <button id="formbtn" class="btn btn-primary" name="save" disabled="disabled"><i class="fa fa-save"></i> Simpan</button>
      
    <?php endif ?>
    
    </div>        
        </form><!--End Form-->
  </div>
  
  <div class="col-md-12">
    <table class="table table-bordered table-responsive table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Satuan</th>
          <th>Harga</th>
          <th>Jumlah</th>
        
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php  
          if ($cekbarang === false) {
            echo "<tr><td colspan='7' align='center'>Data saat ini kosong</td></tr>";
          }
          else{
          $br = $project->tampil_project_sementara($kode);
          foreach ($br as $index => $data) {
        ?>
        <tr>
          <td><?php echo $index + 1; ?></td>
          <td><?php echo $data['nama_barangp']; ?></td>
          <td><?php echo $data['satuan']; ?></td>
          <td><?php echo number_format($data['harga']); ?></td>
          <td><?php echo $data['item']; ?></td>
          
          <td>
            <a href="?module=form_project&hapus=<?php echo $data['id_keluar_sementara']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
          </td>
        </tr>
        <?php } }?>
        <tr class="active">
          <td colspan="5" align="center"><strong>Subtotal</strong></td>
          <td colspan="2"><?php echo number_format($subtotal); ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!--data barangnya-->
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Barang
            </div>
            <div class="box-body">
                <div class="table">
                    <table class="table table-striped table-bordered table-hover" id="dataTables1">
                        
            <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th>stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php  
                                $brg = $project->tampil_barang_project();
                                foreach ($brg as $index => $data) {
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $data['kode_barang']; ?></td>
                                <td><?php echo $data['nama_barang']; ?></td>
                                <td><?php echo $data['satuan']; ?></td>
                                <td><?php echo number_format($data['stok']); ?></td>
                                <td>
                                    <a href="?module=form_project&proses=<?php echo $data['kode_barang']; ?>" class="btn btn-success btn-xs"><i class="fa fa-download"></i> Prosess</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>   
            </div>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>

<?php  
  if (isset($_GET['proses'])) {
    echo "<script>
      $('#item').focus();
    </script>";
  }
?>

<script>
  //upper
  $(function(){
      $('#satuan').focusout(function() {
          // Uppercase-ize contents
          this.value = this.value.toLocaleUpperCase();
      });
  });
  //fungsi hide div
  $(function(){
    setTimeout(function(){$("#divAlert").fadeOut(900)}, 500);
  });
  //validasi form
  function validateText(id){
    if ($('#'+id).val()== null || $('#'+id).val()== "") {
      var div = $('#'+id).closest('div');
      div.addClass("has-error has-feedback");
      return false;
    }
    else{
      var div = $('#'+id).closest('div');
      div.removeClass("has-error has-feedback");
      return true;  
    }
  }
  $(document).ready(function(){
    $("#formbtn").click(function(){
      if (!validateText('tgltransaksi')) {
        $('#tgltransaksi').focus();
        return false;
      }
      else if (!validateText('kdpurchase')) {
        $('#kdpurchase').focus();
        return false;
      }
      return true;
    });
  });
  $(document).ready(function(){
    $("#tambah").click(function(){
      if (!validateText('item')) {
        $('#item').focus();
        return false;
      }
      return true;
    });
  });
</script>
