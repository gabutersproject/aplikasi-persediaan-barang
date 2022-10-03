<?php
session_start(); 

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";

if(isset($_POST['dataidbarang'])) {
	$kode_barang = $_POST['dataidbarang'];

  // fungsi query untuk menampilkan data dari tabel barang
  $query = mysqli_query($mysqli, "SELECT kode_barang,nama_barang,satuan,stok FROM is_barang WHERE kode_barang='$kode_barang'")
                                  or die('Ada kesalahan pada query tampil data barang: '.mysqli_error($mysqli));
 
  // tampilkan data
  $data = mysqli_fetch_assoc($query);

  $stok   = $data['stok'];
  $satuan = $data['satuan'];

	if($stok != '') {
		echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Stok</label>
                <div class='col-sm-5'>
                  <div class='input-group'>
                    <input type='text' class='form-control' id='stok' name='stok' value='$stok' readonly>
                    <span class='input-group-addon'>$satuan</span>
                  </div>
                </div>
              </div>";
	} else {
		echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Stok</label>
                <div class='col-sm-5'>
                  <div class='input-group'>
                    <input type='text' class='form-control' id='stok' name='stok' value='Stok barang tidak ditemukan' readonly>
                    <span class='input-group-addon'>Satuan barang tidak ditemukan</span>
                  </div>
                </div>
              </div>";
	}		
}
?> 
