<script type="text/javascript">
  function tampil_barang(input){
    var num = input.value;  

    $.post("modules/barang/barang.php", {
      dataidbarang: num,
    }, function(response) {      
      $('#stok').html(response)

      document.getElementById('stokakhir').focus();
    });
  }

  function cek_jumlah_masuk(input) {
    jml = document.barang.stokakhir.value;
    var jumlah = eval(jml);
    if(jumlah < 1){
      alert('Jumlah barangTidak Boleh Nol !!');
      input.value = input.value.substring(0,input.value.length-1);
    }
  }

  function hitung_total_stok() {
    bil1 = document.barang.stokawal.value;
    bil2 = document.barang.stokakhir.value;

    if (bil2 == "") {
      var hasil = "";
    }
    else {
      var hasil =  eval(bil2);
    }

    document.barang.stok.value = (hasil);

  }
</script>




 <?php  
// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form']=='add') { ?> 
  <!-- tampilan form add data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Input Barang
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=barang"> Barang </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/barang/proses.php?act=insert" method="POST">
            <div class="box-body"> 
             

              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Barang</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_barang" maxlength="8" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Barang</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_barang" autocomplete="off" maxlength="50" required>
                </div>
              </div>

               <div class="form-group">
                <label class="col-sm-2 control-label">Kelompok Barang</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="kode_kelompok" data-placeholder="-- Pilih kelompok --" autocomplete="off" required>
                    <option value=""></option>
                    <?php
                      $query_kelompok = mysqli_query($mysqli, "SELECT kode_kb, nama_kb FROM kategori ORDER BY nama_kb ASC")
                                                            or die('Ada kesalahan pada query tampil lokasi: '.mysqli_error($mysqli));
                      while ($data_kelompok = mysqli_fetch_assoc($query_kelompok)) {
                        echo"<option value=\"$data_kelompok[kode_kb]\"> $data_kelompok[kode_kb] | $data_kelompok[nama_kb] </option>";
                      }
                    ?>
                  </select>
                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-2 control-label">Harga Beli</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="text" class="form-control" id="harga_beli" name="harga_beli" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)"  required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Harga Jual</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="text" class="form-control" id="harga_jual" name="harga_jual" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="satuan" data-placeholder="-- Pilih --" autocomplete="off" required>
                    <option value=""></option>
                    <option value="PCS">PCS</option>
                    <option value="Box">Box</option>
                    <option value="Lembar">Lembar</option>
                    <option value="Kotak">Kotak</option>
                    <option value="Strip">Strip</option>
                    <option value="Tube">Tube</option>
                  </select>
                </div>
              </div>

             <div class="form-group">
                <label class="col-sm-2 control-label">Lokasi</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="kode_lokasi" data-placeholder="-- Pilih lokasi --"  autocomplete="off" required>
                    <option value=""></option>
                    <?php
                      $query_lokasi = mysqli_query($mysqli, "SELECT kode_lokasi, nama_lokasi FROM lokasi ORDER BY nama_lokasi ASC")
                                                            or die('Ada kesalahan pada query tampil lokasi: '.mysqli_error($mysqli));
                      while ($data_lokasi = mysqli_fetch_assoc($query_lokasi)) {
                        echo"<option value=\"$data_lokasi[kode_lokasi]\"> $data_lokasi[kode_lokasi] | $data_lokasi[nama_lokasi] </option>";
                      }
                    ?>
                  </select>
                </div>
              </div>

               
            <div class="form-group">
                <label class="col-sm-2 control-label">Keterangan</label>
                <div class="col-sm-5">
                <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan" maxlength="80" ></textarea>           
               </div>
            </div>

            
            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=barang" class="btn btn-default btn-reset">Batal</a>
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
      $query = mysqli_query($mysqli, "SELECT kode_barang,nama_barang,harga_beli,harga_jual,satuan,stok,keterangan FROM is_barang WHERE kode_barang='$_GET[id]'") 
                                      or die('Ada kesalahan pada query tampil Data barang : '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
    }
?>
  <!-- tampilan form edit data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Ubah Barang
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=barang"> Barang </a></li>
      <li class="active"> Ubah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/barang/proses.php?act=update" method="POST">
            <div class="box-body">
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Kode barang</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_barang" value="<?php echo $data['kode_barang']; ?>"  maxlength="8"  required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama barang</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_barang" autocomplete="off" value="<?php echo $data['nama_barang']; ?>" maxlength="50"  required>
                </div>
              </div>

                <div class="form-group">
                <label class="col-sm-2 control-label">Kelompok Barang</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="kode_kelompok" data-placeholder="-- Pilih kelompok --" autocomplete="off" required>
                    <option value="<?php echo $data['kode_kb']; ?>"></option>
                    <?php
                      $query_kelompok = mysqli_query($mysqli, "SELECT kode_kb, nama_kb FROM kategori ORDER BY nama_kb ASC")
                                                            or die('Ada kesalahan pada query tampil lokasi: '.mysqli_error($mysqli));
                      while ($data_kelompok = mysqli_fetch_assoc($query_kelompok)) {
                        echo"<option value=\"$data_kelompok[kode_kb]\"> $data_kelompok[kode_kb] | $data_kelompok[nama_kb] </option>";
                      }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Harga Beli</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="text" class="form-control" id="harga_beli" name="harga_beli" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo format_rupiah($data['harga_beli']); ?>" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Harga Jual</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="text" class="form-control" id="harga_jual" name="harga_jual" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo format_rupiah($data['harga_jual']); ?>" required>
                  </div>
                </div>
              </div>

                <div class="form-group">
                <label class="col-sm-2 control-label">Stok</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    
                    <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $data['stok']; ?>" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)"  required>
                  </div>
                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="satuan" data-placeholder="-- Pilih --" autocomplete="off" required>
                    <option value="<?php echo $data['satuan']; ?>"><?php echo $data['satuan']; ?></option>
                    <option value="Pcs">Pcs</option>
                    <option value="Box">Box</option>
                    <option value="Kotak">Kotak</option>
                    <option value="Strip">Strip</option>
                    <option value="Tube">Tube</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Lokasi</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="kode_lokasi" data-placeholder="-- Pilih lokasi --"  autocomplete="off" required>
                    <option value="<?php echo $data['kode_lokasi']; ?>"></option>
                    <?php
                      $query_lokasi = mysqli_query($mysqli, "SELECT kode_lokasi, nama_lokasi FROM lokasi ORDER BY nama_lokasi ASC")
                                                            or die('Ada kesalahan pada query tampil lokasi: '.mysqli_error($mysqli));
                      while ($data_lokasi = mysqli_fetch_assoc($query_lokasi)) {
                        echo"<option value=\"$data_lokasi[kode_lokasi]\"> $data_lokasi[kode_lokasi] | $data_lokasi[nama_lokasi] </option>";
                      }
                    ?>
                  </select>
                </div>
              </div>
              
               <div class="form-group">
                <label class="col-sm-2 control-label">Keterangan</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control"  name="keterangan" autocomplete="off" value="<?php echo $data['keterangan']; ?>" maxlength="50"  required>
                </div>
              </div>

            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=barang" class="btn btn-default btn-reset">Batal</a>
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
