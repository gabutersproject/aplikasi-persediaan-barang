<?php

include 'class/class.php'

?>  

<?php  
              // fungsi untuk membuat kode transaksi
              $query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_transaksi,5) as kode FROM barang_keluar
                                                ORDER BY kode_transaksi DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil kode_transaksi : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                  // mengambil data kode transaksi
                  $data_id = mysqli_fetch_assoc($query_id);
                  $koder    = $data_id['kode']+1;
              } else {
                  $koder = 1;
              }

              // buat kode_transaksi
              $tahun          = date("Y");
              $buat_id        = str_pad($koder,5, "0", STR_PAD_LEFT);
              $kode= "TK-$tahun-$buat_id";
?>



<?php 

	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}




	
	$subtotal = $barangkeluar->hitung_total_sementara($kode);
	$cekbarang = $barangkeluar->cek_data_barangp($kode);
	$hari_ini = date("Y-m-d");
	$created_user = $_SESSION['username'];
	
	if (isset($_POST['tambah'])) {
		$cekitem = $barangkeluar->cek_item($_GET['proses'],$_POST['item']);
		if ($cekitem === true) {
			$barangkeluar->tambah_keluar_sementara($kode,$_GET['proses'],$_POST['item']);
			echo "<script>location='?module=form_barang_keluar';</script>";
		}
	}

  
	if (isset($_POST['save'])) {
		
		$barangkeluar->simpan_brgkeluar($_POST['kdbrgkeluar'],$_POST['tglbrgkeluar'],$_POST['kdproject'],$_POST['penerima'],$_POST['alamat'],$subtotal,$created_user);
		$pen = $barangkeluar->ambil_kdpen();
		$kodepen = $pen['kode_transaksi']; 
		echo "<script>location='?module=form_barang_keluar';</script>";
		
		
	}

	if (isset($_GET['hapus'])) {
		$barangkeluar->hapus_keluar_sementara($_GET['hapus']);
		echo "<script>location='?module=form_barang_keluar';</script>";
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
      <i class="fa fa-edit icon-title"></i> Input Data Barang Keluar
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=barang_keluar"> Barang Keluar </a></li>
     <li class="active"> Tambah </li>
    </ol>
  </section>

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				FORM PENGELUARAN BARANG
			</div>
			<div class="panel-body">
				<form method="POST">
					<div class="form-group">
						<label>Kd Barang</label>
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
			<a href="?module=barang_keluar" class="btn btn-primary btn-info">Batal</a>
			</div>
			
				</form>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
			FORM PENGELUARAN BARANG
			</div>
			
			<div class="panel-body">
				<!--Form-->
				<form method="POST">
					<div class="form-group">
						<label>Kode Transaksi</label>
						<input type="text" class="form-control" name="kdbrgkeluar" id="kdbrgkeluar" maxlength="20" readonly="true" value="<?php echo $kode; ?>">
					</div>
					<div class="form-group">
						<label>Tanggal Transaksi</label>
						<input type="date" class="form-control" name="tglbrgkeluar" id="tglbrgkeluar"  >
					</div>
					
					 <div class="form-group">
		                <label >Kode Project</label>
		              
		                  <select class="chosen-select" name="kode_project" data-placeholder="-- Pilih No Project --"  autocomplete="off" required>
		                    <option value=""></option>
		                    <?php
		                      $query_project = mysqli_query($mysqli, "SELECT kode_project, nama_project FROM project ORDER BY nama_project ASC")
		                                                            or die('Ada kesalahan pada query tampil project: '.mysqli_error($mysqli));
		                      while ($data_project = mysqli_fetch_assoc($query_project)) {
		                        echo"<option value=\"$data_project[kode_project]\"> $data_project[kode_project] | $data_project[nama_project] </option>";
		                      }
		                    ?>
		                  </select>
		                </div>
		              


					<div class="form-group">
						<label>Penerima</label>
						<input type="text" class="form-control" name="penerima" id="penerima">
					</div>

					  <div class="form-group">
						<label>Alamat</label>
						<textarea class="form-control"  name="alamat" id="alamat" placeholder="Masukan Alamat" ></textarea>	
			</div>	   </div>
			
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
					$br = $barangkeluar->tampil_barang_sementara($kode);
					foreach ($br as $index => $data) {
				?>
				<tr>
					<td><?php echo $index + 1; ?></td>
					<td><?php echo $data['nama_barang']; ?></td>
					<td><?php echo $data['satuan']; ?></td>
					<td><?php echo number_format($data['harga']); ?></td>
					<td><?php echo $data['item']; ?></td>
					
					<td>
						<a href="?module=form_barang_keluar&hapus=<?php echo $data['id_keluar_sementara']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
					</td>
				</tr>
				<?php } }?>
				<tr class="active">
					<td colspan="5" align="center"><strong>Subtotal</strong></td>
					<td colspan="2"><?php echo number_format($subtotal); ?></td>

			
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
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php  
                                $brg = $barangkeluar->tampil_barang_keluar();
                                foreach ($brg as $index => $data) {
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $data['kode_barang']; ?></td>
                                <td><?php echo $data['nama_barang']; ?></td>
                                <td><?php echo $data['satuan']; ?></td>
                                <td><?php echo number_format($data['stok']); ?></td>
                                <td>
                                    <a href="?module=form_barang_keluar&proses=<?php echo $data['kode_barang']; ?>" class="btn btn-success btn-xs"><i class="fa fa-download"></i> Prosess</a>
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
			if (!validateText('tglbrgkeluar')) {
				$('#tglbrgkeluar').focus();
				return false;
			}
			else if (!validateText('penerima')) {
				$('#penerima').focus();
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
