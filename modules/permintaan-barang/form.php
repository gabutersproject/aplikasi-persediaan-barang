<?php

include 'class/class.php'

?>  

<?php  
              // fungsi untuk membuat kode transaksi
              $query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_transaksi,5) as kode FROM permintaan
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
	
	$subtotal = $permintaan->hitung_total_sementara($kode);
	$cekbarang = $permintaan->cek_data_barangp($kode);
	
	$hari_ini = date("Y-m-d");
	$created_user = $_SESSION['username'];
	
	if (isset($_POST['tambah'])) {
		$cekitem = $permintaan->cek_item($_GET['proses'],$_POST['item']);
		if ($cekitem === true) {
			$permintaan->tambah_permintaan_sementara($kode,$_GET['proses'],$_POST['item']);
			echo "<script>location='?module=form_permintaan_barang';</script>";
		}
	}

  
	if (isset($_POST['save'])) {
		
		$permintaan->simpan_permintaan($_POST['kdpermintaan'],$_POST['tglpermintaan'],$_POST['kdproject'],$subtotal,$created_user);
		$pen = $permintaan->ambil_kdpen();
		$kodepen = $pen['kode_transaksi']; 
		echo "<script>location='?module=form_permintaan_barang';</script>";
		
		
	}

	if (isset($_GET['hapus'])) {
		$permintaan->hapus_permintaan_sementara($_GET['hapus']);
		echo "<script>location='?module=form_permintaan_barang';</script>";
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
				FORM PERMINTAAN BARANG
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
			<a href="?module=permintaan" class="btn btn-primary btn-info">Batal</a>
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
						<label>Tanggal transaksi</label>
						<input type="date" class="form-control" name="tglbrgkeluar" id="tglbrgkeluar"  >
					</div>
					
					
					 <div class="form-group">
		                <label class="col-sm-2 control-label">Kode Project</label>
		                <div class="col-md-6">
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
					$br = $permintaan->tampil_permintaan_sementara($kode);
					foreach ($br as $index => $data) {
				?>
				<tr>
					<td><?php echo $index + 1; ?></td>
					<td><?php echo $data['nama_barang']; ?></td>
					<td><?php echo $data['satuan']; ?></td>
					<td><?php echo number_format($data['harga']); ?></td>
					<td><?php echo $data['item']; ?></td>
					
					<td>
						<a href="?module=form_permintaan_barang&hapus=<?php echo $data['id_permintaan_sementara']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
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
                                $brg = $permintaan->tampil_barang_permintaan();
                                foreach ($brg as $index => $data) {
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $data['kode_barang']; ?></td>
                                <td><?php echo $data['nama_barang']; ?></td>
                                <td><?php echo $data['satuan']; ?></td>
                                <td><?php echo number_format($data['stok']); ?></td>
                                <td>
                                    <a href="?module=form_permintaan_barang&proses=<?php echo $data['kode_barang']; ?>" class="btn btn-success btn-xs"><i class="fa fa-download"></i> Prosess</a>
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
