<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}
// jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
else {
    if ($_GET['act']=='insert') {
        if (isset($_POST['simpan'])) {
            // ambil data hasil submit dari form
            $kode_supplier  = mysqli_real_escape_string($mysqli, trim($_POST['kode_supplier']));
            $nama_supplier  = mysqli_real_escape_string($mysqli, trim($_POST['nama_supplier']));
            $alamat = mysqli_real_escape_string($mysqli, trim($_POST['alamat']));
            $no_telp = mysqli_real_escape_string($mysqli, trim($_POST['no_telp']));
            $norek = mysqli_real_escape_string($mysqli, trim($_POST['norek']));

            $created_user = $_SESSION['id_user'];

            // perintah query untuk menyimpan data ke tabel klien
            $query = mysqli_query($mysqli, "INSERT INTO supplier(kd_supplier,nama_supplier,alamat,telp,norek) 
                                            VALUES('$kode_supplier','$nama_supplier','$alamat','$no_telp','$norek')")
                                            or die('Ada kesalahan pada query insert : '.mysqli_error($mysqli));    

            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../main.php?module=supplier&alert=1");
            }   
        }   
    }
    
    elseif ($_GET['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['kode_supplier'])) {
                // ambil data hasil submit dari form
                $kode_supplier  = mysqli_real_escape_string($mysqli, trim($_POST['kode_supplier']));
                $nama_supplier  = mysqli_real_escape_string($mysqli, trim($_POST['nama_supplier']));
                $alamat = mysqli_real_escape_string($mysqli, trim($_POST['alamat']));
                $no_telp = mysqli_real_escape_string($mysqli, trim($_POST['no_telp']));
                $norek = mysqli_real_escape_string($mysqli, trim($_POST['norek']));

                $updated_user = $_SESSION['id_user'];

                // perintah query untuk mengubah data pada tabel klien
                $query = mysqli_query($mysqli, "UPDATE supplier SET    nama_supplier  = '$nama_supplier',
                                                                    alamat      = '$alamat',
                                                                    telp     = '$no_telp',
                                                                    norek     = '$norek'
                                                              WHERE kd_supplier       = '$kode_supplier'")
                                                or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

                // cek query
                if ($query) {
                    // jika berhasil tampilkan pesan berhasil update data
                    header("location: ../../main.php?module=supplier&alert=2");
                }         
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $kode_klien = $_GET['id'];
    
            // perintah query untuk menghapus data pada tabel klien
            $query = mysqli_query($mysqli, "DELETE FROM supplier WHERE kd_supplier='$kode_supplier'")
                                            or die('Ada kesalahan pada query delete : '.mysqli_error($mysqli));

            // cek hasil query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil delete data
                header("location: ../../main.php?module=supplier&alert=3");
            }
        }
    }       
}       
?>
