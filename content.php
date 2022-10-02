<?php
/* panggil file database.php untuk koneksi ke database */
require_once "config/database.php";
/* panggil file fungsi tambahan */
require_once "config/fungsi_tanggal.php";
require_once "config/fungsi_rupiah.php"; 

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan message = 1
if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}
// jika user sudah login, maka jalankan perintah untuk pemanggilan file halaman konten
else {
	// jika halaman konten yang dipilih beranda, panggil file view beranda
	if ($_GET['module'] == 'beranda') {
		include "modules/beranda/view.php";
	}

	// jika halaman konten yang dipilih barang, panggil file view barang
	elseif ($_GET['module'] == 'barang') {
		include "modules/barang/view.php";
	}

	// jika halaman konten yang dipilih form barang, panggil file form barang
	elseif ($_GET['module'] == 'form_barang') {
		include "modules/barang/form.php";
	}
	// -----------------------------------------------------------------------------

	// jika halaman konten yang dipilih form klien, panggil file form klien
	elseif ($_GET['module'] == 'form_klien') {
		include "modules/klien/form.php";
	}
	// -----------------------------------------------------------------------------
		// jika halaman konten yang dipilih barang masuk, panggil file view barang masuk
	elseif ($_GET['module'] == 'klien') {
		include "modules/klien/view.php";
	}

	
	// jika halaman konten yang dipilih form project panggil file form project
	elseif ($_GET['module'] == 'form_project') {
		include "modules/project/form.php";
	}
	// -----------------------------------------------------------------------------
		// jika halaman konten yang dipilih project, panggil file view project
	elseif ($_GET['module'] == 'project') {
		include "modules/project/view.php";
	}
	// -----------------------------------------------------------------------------
	// jika halaman konten yang dipilih form purchase panggil file form purchase
	elseif ($_GET['module'] == 'form_purchase') {
		include "modules/purchase/form.php";
	}
	// -----------------------------------------------------------------------------
		// jika halaman konten yang dipilih purchase, panggil file view purchase
	elseif ($_GET['module'] == 'purchase') {
		include "modules/purchase/view.php";
	}
	// -----------------------------------------------------------------------------
	// jika halaman konten yang dipilih form permintaan barang panggil file form permintaan barang
	elseif ($_GET['module'] == 'form_permintaan_barang') {
		include "modules/permintaan-barang/form.php";
	}
	// -----------------------------------------------------------------------------
		// jika halaman konten yang dipilih permintaan barang, panggil file view permintaan barang
	elseif ($_GET['module'] == 'permintaan_barang') {
		include "modules/permintaan-barang/view.php";
	}
	// -----------------------------------------------------------------------------
	// -----------------------------------------------------------------------------
	// jika halaman konten yang dipilih form minta harga barang panggil file form minta harga
	elseif ($_GET['module'] == 'form_minta_harga') {
		include "modules/permintaan-harga/form.php";
	}
	// -----------------------------------------------------------------------------
		// jika halaman konten yang dipilih permintaan harga, panggil file view permintaan harga
	elseif ($_GET['module'] == 'permintaan_harga') {
		include "modules/permintaan-harga/view.php";
	}
	// -----------------------------------------------------------------------------
	// -----------------------------------------------------------------------------
	// jika halaman konten yang dipilih form penawaran harga barang panggil file form penawaran harga
	elseif ($_GET['module'] == 'form_penawaran_harga') {
		include "modules/penawaran-harga/form.php";
	}
	// -----------------------------------------------------------------------------
		// jika halaman konten yang dipilih penawaran harga, panggil file view penawaran harga
	elseif ($_GET['module'] == 'penawaran_harga') {
		include "modules/penawaran-harga/view.php";
	}
	// -----------------------------------------------------------------------------
	// jika halaman konten yang dipilih form sales order panggil file form sales order
	elseif ($_GET['module'] == 'form_sales_order') {
		include "modules/sales-order/form.php";
	}
	// -----------------------------------------------------------------------------
		// jika halaman konten yang dipilih sales order, panggil file view sales order
	elseif ($_GET['module'] == 'sales_order') {
		include "modules/sales-order/view.php";
	}
	// -----------------------------------------------------------------------------
	// jika halaman konten yang dipilih form kelompok barang panggil file form kelompok barang
	elseif ($_GET['module'] == 'form_kelompok_barang') {
		include "modules/kelompok-barang/form.php";
	}
	// -----------------------------------------------------------------------------
		// jika halaman konten yang dipilih kelompok barang, panggil file view kelompok barang
	elseif ($_GET['module'] == 'kelompok_barang') {
		include "modules/kelompok-barang/view.php";
	}
	// -----------------------------------------------------------------------------
	// jika halaman konten yang dipilih form lokasi barang panggil file form kelompok lokasi
	elseif ($_GET['module'] == 'form_lokasi') {
		include "modules/lokasi/form.php";
	}
	// -----------------------------------------------------------------------------
		// jika halaman konten yang dipilih lokasi, panggil file view lokasi
	elseif ($_GET['module'] == 'lokasi') {
		include "modules/lokasi/view.php";
	}
	// -----------------------------------------------------------------------------
	// jika halaman konten yang dipilih barang masuk, panggil file view barang masuk
	elseif ($_GET['module'] == 'barang_masuk') {
		include "modules/barang-masuk/view.php";
	}

	// jika halaman konten yang dipilih form barang masuk, panggil file form barang masuk
	elseif ($_GET['module'] == 'form_barang_masuk') {
		include "modules/barang-masuk/form.php";
	}
	// -----------------------------------------------------------------------------

		// jika halaman konten yang dipilih barang keluar, panggil file view barang keluar
		elseif ($_GET['module'] == 'barang_keluar') {
			include "modules/barang-keluar/view.php";
		}

    // jika halaman konten yang dipilih form barang masuk, panggil file form barang masuk
	elseif ($_GET['module'] == 'form_barang_keluar') {
		include "modules/barang-keluar/form.php";
	}

	// -----------------------------------------------------------------------------

	// -----------------------------------------------------------------------------

		// jika halaman konten yang dipilih supplier, panggil file view supplier
		elseif ($_GET['module'] == 'supplier') {
			include "modules/supplier/view.php";
		}

    // jika halaman konten yang dipilih form supplier, panggil file form supplier
	elseif ($_GET['module'] == 'form_supplier') {
		include "modules/supplier/form.php";
	}

	// -----------------------------------------------------------------------------
		// jika halaman konten yang dipilih cetak faktur, panggil file view cetak faktur 
	elseif ($_GET['module'] == 'cetak_faktur_keluar') {
			include "modules/nota/view.php";
		}
	// -----------------------------------------------------------------------------
	


	// jika halaman konten yang dipilih laporan stok, panggil file view laporan stok
	elseif ($_GET['module'] == 'lap_stok') {
		include "modules/lap-stok/view.php";
	}
	// -----------------------------------------------------------------------------

	// jika halaman konten yang dipilih laporan barang masuk, panggil file view laporan barang masuk
	elseif ($_GET['module'] == 'lap_barang_masuk') {
		include "modules/lap-barang-masuk/view.php";
	}
	// -----------------------------------------------------------------------------
   
    // -----------------------------------------------------------------------------

	// jika halaman konten yang dipilih laporan barang masuk, panggil file view laporan barang masuk
	elseif ($_GET['module'] == 'lap_barang_keluar') {
		include "modules/lap-barang-keluar/view.php";
	}
	// -----------------------------------------------------------------------------


	// jika halaman konten yang dipilih user, panggil file view user
	elseif ($_GET['module'] == 'user') {
		include "modules/user/view.php";
	}

	// jika halaman konten yang dipilih form user, panggil file form user
	elseif ($_GET['module'] == 'form_user') {
		include "modules/user/form.php";
	}
	// -----------------------------------------------------------------------------

	// jika halaman konten yang dipilih profil, panggil file view profil
	elseif ($_GET['module'] == 'profil') {
		include "modules/profil/view.php";
	}

	// jika halaman konten yang dipilih form profil, panggil file form profil
	elseif ($_GET['module'] == 'form_profil') {
		include "modules/profil/form.php";
	}
	// -----------------------------------------------------------------------------
	
	// jika halaman konten yang dipilih password, panggil file view password
	elseif ($_GET['module'] == 'password') {
		include "modules/password/view.php";
	}
}
?>
