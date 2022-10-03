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
            $kode_project = mysqli_real_escape_string($mysqli, trim($_POST['kode_project']));
            $nama_project = mysqli_real_escape_string($mysqli, trim($_POST['nama_project']));

            $tanggal         = mysqli_real_escape_string($mysqli, trim($_POST['tanggal_order']));
            $exp             = explode('-',$tanggal);
            $tanggal_order   = $exp[2]."-".$exp[1]."-".$exp[0];

            $tanggal1         = mysqli_real_escape_string($mysqli, trim($_POST['tanggal_kirim']));
            $exp1             = explode('-',$tanggal1);
            $tanggal_kirim   = $exp[2]."-".$exp[1]."-".$exp[0];
            
            $kode_klien     = mysqli_real_escape_string($mysqli, trim($_POST['kode_klien']));
            $status    = mysqli_real_escape_string($mysqli, trim($_POST['status']));
            $kontak      = mysqli_real_escape_string($mysqli, trim($_POST['kontak']));
            
            $created_user    = $_SESSION['id_user'];

            // perintah query untuk menyimpan data ke tabel barang masuk
            $query = mysqli_query($mysqli, "INSERT INTO project(kode_project,nama_project,tanggal_order,tanggal_kirim,kode_klien,status,kontak,username) 
                                            VALUES('$kode_project','$nama_project','$tanggal_order','$tanggal_kirim','$kode_klien','$status','$kontak','$created_user')")
                                            or die('Ada kesalahan pada query insert : '.mysqli_error($mysqli));    

           // cek query
                if ($query) {                       
                    // jika berhasil tampilkan pesan berhasil simpan data
                    header("location: ../../main.php?module=project&alert=1");
                }
            }   
        }   
       elseif ($_GET['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['kode_project'])) {
                $kode_project = mysqli_real_escape_string($mysqli, trim($_POST['kode_project']));
                $nama_project = mysqli_real_escape_string($mysqli, trim($_POST['nama_project']));
                    $tanggal         = mysqli_real_escape_string($mysqli, trim($_POST['tanggal_order']));
                    $exp             = explode('-',$tanggal);
                    $tanggal_order   = $exp[2]."-".$exp[1]."-".$exp[0];

                    $tanggal1         = mysqli_real_escape_string($mysqli, trim($_POST['tanggal_kirim']));
                    $exp1             = explode('-',$tanggal1);
                    $tanggal_kirim   = $exp[2]."-".$exp[1]."-".$exp[0];
                    
                    $kode_klien     = mysqli_real_escape_string($mysqli, trim($_POST['kode_klien']));
                    $status    = mysqli_real_escape_string($mysqli, trim($_POST['status']));
                    $kontak      = mysqli_real_escape_string($mysqli, trim($_POST['kontak']));
                

                $updated_user = $_SESSION['id_user'];

                // perintah query untuk mengubah data pada tabel supplier
                $query = mysqli_query($mysqli, "UPDATE project SET  nama_project = '$nama_project',
                                                                    tanggal_order   = '$tanggal_order',
                                                                    tanggal_kirim   = '$tanggal_kirim',
                                                                    kode_klien      = '$kode_klien',
                                                                    status      = '$status',
                                                                    kontak      = '$kontak',
                                                                    username    = '$updated_user'
                                                              WHERE kode_project       = '$kode_project'")
                                                or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

                // cek query
                if ($query) {
                    // jika berhasil tampilkan pesan berhasil update data
                    header("location: ../../main.php?module=project&alert=2");
                }         
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $kdsupplier = $_GET['id'];
    
            // perintah query untuk menghapus data pada tabel supplier
            $query = mysqli_query($mysqli, "DELETE FROM project WHERE kode_project='$kode_project'")
                                            or die('Ada kesalahan pada query delete : '.mysqli_error($mysqli));

            // cek hasil query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil delete data
                header("location: ../../main.php?module=project&alert=3");
            }
        }
    }       
}       


?>
