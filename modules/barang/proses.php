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
            $kode_barang  = mysqli_real_escape_string($mysqli, trim($_POST['kode_barang']));
            $nama_barang  = mysqli_real_escape_string($mysqli, trim($_POST['nama_barang']));
            $keterangan     = mysqli_real_escape_string($mysqli, trim($_POST['keterangan']));
            $satuan     = mysqli_real_escape_string($mysqli, trim($_POST['satuan']));
            $lokasi     = mysqli_real_escape_string($mysqli, trim($_POST['kode_lokasi']));
            $kelompok    = mysqli_real_escape_string($mysqli, trim($_POST['kode_kelompok']));

            $created_user = $_SESSION['id_user'];
        // cek apakah kode barang telah digunakan
            $query = mysqli_query($mysqli, "SELECT * FROM is_barang WHERE kode_barang='$kode_barang'")
                                    or die('Ada kesalahan pada query user: '.mysqli_error($mysqli));
                        $rows  = mysqli_num_rows($query);
 
    // jika data ada, jalankan perintah untuk membuat session
            if ($rows > 0) {
                    echo "<script>window.alert('kode barang yang anda masukan sudah ada')
                        window.location='location: ../../main.php?module=form_barang'</script>";
            }else{ 

            // perintah query untuk menyimpan data ke tabel barang
            $query = mysqli_query($mysqli, "INSERT INTO is_barang(kode_barang,nama_barang,kode_kb,keterangan,satuan,kode_lokasi,created_user,updated_user) 
                                            VALUES('$kode_barang','$nama_barang','$kelompok','$keterangan','$satuan','$lokasi','$created_user','$created_user')")
                                            or die('Ada kesalahan pada query insert : '.mysqli_error($mysqli));    

            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../main.php?module=barang&alert=1");
            } 
    }          
        }   
    }
    
    elseif ($_GET['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['kode_barang'])) {
                // ambil data hasil submit dari form
               $kode_barang  = mysqli_real_escape_string($mysqli, trim($_POST['kode_barang']));
            $nama_barang  = mysqli_real_escape_string($mysqli, trim($_POST['nama_barang']));
            $keterangan     = mysqli_real_escape_string($mysqli, trim($_POST['keterangan']));
            $satuan     = mysqli_real_escape_string($mysqli, trim($_POST['satuan']));
            $lokasi     = mysqli_real_escape_string($mysqli, trim($_POST['kode_lokasi']));
            $kelompok    = mysqli_real_escape_string($mysqli, trim($_POST['kode_kelompok']));

            $created_user = $_SESSION['id_user'];

                // perintah query untuk mengubah data pada tabel barang
                $query = mysqli_query($mysqli, "UPDATE is_barang SET kode_barang       = '$kode_barang',
                                                                    nama_barang   = '$nama_barang',
                                                                    kode_kb         = '$kelompok',
                                                                    keterangan      = '$keterangan',
                                                                    satuan          = '$satuan',
                                                                    kode_lokasi     = '$lokasi',
                                                                    kode_kb     = '$lokasi',
                                                                    stok     = '$stok',
                                                                    updated_user    = '$updated_user'
                                                              WHERE kode_barang      = '$kode_barang'")
                                                or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

                // cek query
                if ($query) {
                    // jika berhasil tampilkan pesan berhasil update data
                    header("location: ../../main.php?module=barang&alert=2");
                }         
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $kode_barang = $_GET['id'];
    
            // perintah query untuk menghapus data pada tabel barang
            $query = mysqli_query($mysqli, "DELETE FROM is_barang WHERE kode_barang='$kode_barang'")
                                            or die('Ada kesalahan pada query delete : '.mysqli_error($mysqli));

            // cek hasil query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil delete data
                header("location: ../../main.php?module=barang&alert=3");
            }
        }
    }       
}       
?>
