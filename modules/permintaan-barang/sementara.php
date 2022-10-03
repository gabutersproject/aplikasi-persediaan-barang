<?php
include 'class/class.php'
?>

<?php 
	$kode = $barangkeluar->kode_otomatis();
	$subtotal = $barangkeluar->hitung_total_sementara($kode);
	$cekbarang = $barangkeluar->cek_data_barangp($kode);
	
	if (isset($_POST['tambah'])) {
		$cekitem = $barangkeluar->cek_item($_GET['proses'],$_POST['item']);
		if ($cekitem === true) {
			$barangkeluar->tambah_penjualan_sementara($kode,$_GET['proses'],$_POST['item']);
			echo "<script>location='?module=form_barang_keluar';</script>";
		}
	}

	if (isset($_GET['hapus'])) {
		$barangkeluar->hapus_penjualan_sementara($_GET['hapus']);
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

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Barang
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
			</div>
				</form>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Barang keluar
			</div>
			<div class="panel-body">
				<!--Form-->
				<form method="POST">
					<div class="form-group">
						<label>Kode Transaksi</label>
						<input type="text" class="form-control" name="kdpenjualan" id="kdpenjualan" maxlength="8" readonly="true" value="<?php echo $kode; ?>">
					</div>
					<div class="form-group">
						<label>Tanggal transaksi</label>
						<input type="date" class="form-control" name="tglpenjualan" id="tglpenjualan">
					</div>
					<div class="form-group">
						<label>Penerima</label>
						<input type="text" class="form-control" name="penerima" id="penerima">
					</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="panel-footer" align="center">
		<?php if ($cekbarang === true): ?>
			<button id="formbtn" class="btn btn-primary" name="simpan" value="Simpan"><i class="fa fa-save"></i> Simpan</button>
		<?php endif ?>
		<?php if ($cekbarang === false): ?>
			<button id="formbtn" class="btn btn-primary" name="simpan" disabled="disabled"><i class="fa fa-save"></i> Simpan</button>
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
            <div class="panel-body">
                <div class="table">
                    <table class="table table-striped table-bordered table-hover" id="tabelku">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                                $brg = $barangkeluar->tampil_barang_penjualan();
                                foreach ($brg as $index => $data) {
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $data['kode_barang']; ?></td>
                                <td><?php echo $data['nama_barang']; ?></td>
                                <td><?php echo $data['satuan']; ?></td>
                                <td><?php echo number_format($data['harga_jual']); ?></td>
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
			if (!validateText('tglpenjualan')) {
				$('#tglpenjualan').focus();
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
