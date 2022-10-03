<?php 
//memanggil fungsi
require('../../class/fungsi.php');
include "../../class/class.php";
 
//koneksi ke database dan jalankan query
mysql_connect('localhost', 'root', '');
mysql_select_db('khanza');
$result = mysql_query("SELECT * FROM kategori ORDER BY kode_kb ASC");
!$result?die(mysql_error()):'';
 
//pengaturan nama file
$namaFile = "barang.xls";
//pengaturan judul data
$judul = "DATA BARANG";
//baris berapa header tabel di tulis
$tablehead = 2;
//baris berapa data mulai di tulis
$tablebody = 3;
//no urut data
$nourut = 1;
 
//penulisan header
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=".$namaFile."");
header("Content-Transfer-Encoding: binary ");
 
 
xlsBOF();
 
xlsWriteLabel(0,0,$judul);  
 
$kolomhead = 0;
xlsWriteLabel($tablehead,$kolomhead++,"NO ");              
xlsWriteLabel($tablehead,$kolomhead++,"KODE BARANG");             
xlsWriteLabel($tablehead,$kolomhead++,"NAMA BARANG");
xlsWriteLabel($tablehead,$kolomhead++,"HARGA BELI");
xlsWriteLabel($tablehead,$kolomhead++,"HARGA JUAL");
xlsWriteLabel($tablehead,$kolomhead++,"STOK");
xlsWriteLabel($tablehead,$kolomhead++,"SATUAN");
xlsWriteLabel($tablehead,$kolomhead++,"LOKASI"); 
while ($data = mysql_fetch_array($result))
{
$kolombody = 0;
 
//gunakan xlsWriteNumber untuk penulisan nomor dan xlsWriteLabel untuk penulisan string
xlsWriteNumber($tablebody,$kolombody++,$nourut);
xlsWriteLabel($tablebody,$kolombody++,$data['kode_barang']);
xlsWriteLabel($tablebody,$kolombody++,$data['nama_barang']);
xlsWriteNumber($tablebody,$kolombody++,$data['harga_beli']);
xlsWriteNumber($tablebody,$kolombody++,$data['harga_jual']);
xlsWriteNumber($tablebody,$kolombody++,$data['stok']);
xlsWriteLabel($tablebody,$kolombody++,$data['satuan']);
xlsWriteLabel($tablebody,$kolombody++,$data['lokasi']); 
$tablebody++;
$nourut++;
}
 
xlsEOF();
exit();
?>
