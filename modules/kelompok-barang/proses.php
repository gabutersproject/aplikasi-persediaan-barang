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
            $kode_kelompok = mysqli_real_escape_string($mysqli, trim($_POST['kode_kelompok']));
            $nama_kelompok  = mysqli_real_escape_string($mysqli, trim($_POST['nama_kelompok']));
           
            $created_user = $_SESSION['id_user'];

            // perintah query untuk menyimpan data ke tabel barang
            $query = mysqli_query($mysqli, "INSERT INTO kategori(kode_kb,nama_kb) 
                                            VALUES('$kode_kelompok','$nama_kelompok')")
                                            or die('Ada kesalahan pada query insert : '.mysqli_error($mysqli));    

            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../main.php?module=kelompok_barang&alert=1");
            }   
        }   
    }
    
    elseif ($_GET['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['kode_kelompok'])) {
                // ambil data hasil submit dari form
                $kode_kelompok  = mysqli_real_escape_string($mysqli, trim($_POST['kode_kelompok']));
                $nama_kelompok  = mysqli_real_escape_string($mysqli, trim($_POST['nama_kelompok']));
               

                $updated_user = $_SESSION['id_user'];

                // perintah query untuk mengubah data pada tabel barang
                $query = mysqli_query($mysqli, "UPDATE kategori SET  nama_kb   = '$nama_kelompok'
                                                                    
                                                              WHERE kode_kb       = '$kode_kelompok'")
                                                or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

                // cek query
                if ($query) {
                    // jika berhasil tampilkan pesan berhasil update data
                    header("location: ../../main.php?module=kelompok_barang&alert=2");
                }         
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $kode_barang = $_GET['id'];
    
            // perintah query untuk menghapus data pada tabel barang
            $query = mysqli_query($mysqli, "DELETE FROM kategori WHERE kode_kb='$kode_kelompok'")
                                            or die('Ada kesalahan pada query delete : '.mysqli_error($mysqli));

            // cek hasil query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil delete data
                header("location: ../../main.php?module=kelompok_barang&alert=3");
            }
        }
    }       
}       
?>
