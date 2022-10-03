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
            $kode_klien  = mysqli_real_escape_string($mysqli, trim($_POST['kode_klien']));
            $nama_klien  = mysqli_real_escape_string($mysqli, trim($_POST['nama_klien']));
            $company = mysqli_real_escape_string($mysqli, trim($_POST['company']));
            $divisi  = mysqli_real_escape_string($mysqli, trim($_POST['divisi']));
            $alamat = mysqli_real_escape_string($mysqli, trim($_POST['alamat']));
            $no_telp = mysqli_real_escape_string($mysqli, trim($_POST['no_telp']));
            

            $created_user = $_SESSION['id_user'];

            // perintah query untuk menyimpan data ke tabel klien
            $query = mysqli_query($mysqli, "INSERT INTO klien(kode_klien,nama_klien,company,divisi,alamat,no_telp) 
                                            VALUES('$kode_klien','$nama_klien','$company','$divisi','$alamat','$no_telp')")
                                            or die('Ada kesalahan pada query insert : '.mysqli_error($mysqli));    

            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../main.php?module=klien&alert=1");
            }   
        }   
    }
    
    elseif ($_GET['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['kode_klien'])) {
                // ambil data hasil submit dari form
                $kode_klien  = mysqli_real_escape_string($mysqli, trim($_POST['kode_klien']));
                $nama_klien  = mysqli_real_escape_string($mysqli, trim($_POST['nama_klien']));
                 $company  = mysqli_real_escape_string($mysqli, trim($_POST['company']));
                $divisi  = mysqli_real_escape_string($mysqli, trim($_POST['divisi']));
                $alamat = mysqli_real_escape_string($mysqli, trim($_POST['alamat']));
                $no_telp = mysqli_real_escape_string($mysqli, trim($_POST['no_telp']));

                $updated_user = $_SESSION['id_user'];

                // perintah query untuk mengubah data pada tabel klien
                $query = mysqli_query($mysqli, "UPDATE klien SET    nama_klien  = '$nama_klien',
                                                                    company     ='$company',
                                                                    divisi     ='$divisi',
                                                                    alamat      = '$alamat',
                                                                    no_telp     = '$no_telp'
                                                                    
                                                              WHERE kode_klien       = '$kode_klien'")
                                                or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

                // cek query
                if ($query) {
                    // jika berhasil tampilkan pesan berhasil update data
                    header("location: ../../main.php?module=klien&alert=2");
                }         
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $kode_klien = $_GET['id'];
    
            // perintah query untuk menghapus data pada tabel klien
            $query = mysqli_query($mysqli, "DELETE FROM klien WHERE kode_klien='$kode_klien'")
                                            or die('Ada kesalahan pada query delete : '.mysqli_error($mysqli));

            // cek hasil query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil delete data
                header("location: ../../main.php?module=klien&alert=3");
            }
        }
    }       
}       
?>
