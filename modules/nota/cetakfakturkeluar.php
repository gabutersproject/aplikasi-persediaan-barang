<?php
require('../../fpdf17/fpdf.php');
include "../../class/fungsi_terbilang.php";






class PDF extends FPDF
{

function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = kekata($x/10)." puluh". kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x <1000) {
        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
    }     
        return $temp;
}
  
 
function Terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }     
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }     
    return $hasil;
}




function Header()
{
   $this->SetFont('Arial','B',20);
    $this->Cell(30,10,'FAKTUR BARANG KELUAR');

    
    $this->Ln(5);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'No  : '.base64_decode($_GET['inf']).'');

    $this->Ln(10);

    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'PT.KHANZA');

    $this->ln(5);
    $this->SetFont('Arial','i',8);
    $this->cell(30,10,'Jl kol.Sugiono No.37a Duren sawit Jakarta Timur');
 
    $this->cell(80);
    $this->SetFont('Arial','',8);
    $this->cell(30,10,'Jakarta, '.base64_decode($_GET['uuid']).'');
    

    $this->Ln(5);
    $this->SetFont('Arial','i',8);
    $this->cell(30,10,'Telp/Fax : 02170885532');
    

    $this->Cell(80);
    $this->SetFont('Arial','b',9);
    $this->Cell(30,10,'Kepada : '.base64_decode($_GET['id-uid']).'',0,'C');
   

    $this->ln(5);
     $this->SetFont('Arial','i',10);
    $this->cell(30,10,'');

    $this->Cell(80);
    $this->SetFont('Arial','',8);
    $this->Cell(5,10,''.base64_decode($_GET['almt']).'',0,'C','50%');

    $this->Line(10,50,150,50);
}
function LoadData(){
	mysql_connect("localhost","root","");
	mysql_select_db("khanza");
	$id=base64_decode($_GET['oid']);
	$data=mysql_query("select dbarang_keluar.jumlah,dbarang_keluar.kode_barang,dbarang_keluar.nama_barang from dbarang_keluar  where dbarang_keluar.kode_transaksi='$id'");
	
	while ($r=mysql_fetch_assoc($data))
		        {
		            $hasil[]=$r;
		        }
		        return $hasil;
}
function BasicTable($header, $data)
{
    
    $this->SetFont('Arial','B',12);
        $this->Cell(35,7,$header[0],1);
        $this->Cell(100,7,$header[1],1);
        $this->Cell(40,7,$header[2],1);
    $this->Ln();
    
    $this->SetFont('Arial','',12);
    foreach($data as $row)
    {
        $this->Cell(35,7,$row['kode_barang'],1);
        $this->Cell(100,7,$row['nama_barang'],1);
        $this->Cell(40,7,$row['jumlah'],1);
        $this->Ln();
    }

    mysql_connect("localhost","root","");
	mysql_select_db("khanza");
	$id=base64_decode($_GET['oid']);

    $getsum=mysql_query("select sum(jumlah) as jumlah from dbarang_keluar where kode_transaksi='$id'");
	$getsum1=mysql_fetch_array($getsum);
	$this->cell(5);
	$this->cell(90);
	$this->cell(40,7,'Sub total : ');
    $this->cell(40,7,number_format($getsum1['jumlah']).'',1);

   
    $this->Ln(30);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Catatan :');
    
    $this->Ln(30);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Pengirim');

    $this->cell(40);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Gudang');
 
    $this->cell(50);
    $this->SetFont('Arial','',10);
    $this->cell(30,10,'Penerima');
    $this->Line(10,50,185,50);

        
    $this->Ln(20);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'(..............)');

    $this->cell(40);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'(..............)');
 
    $this->cell(50);
    $this->SetFont('Arial','',10);
    $this->cell(30,10,'(..............)');
    $this->Line(10,50,185,50);
}
}

$pdf = new PDF();
$pdf->SetTitle('Faktur : '.base64_decode($_GET['inf']).'');
$pdf->AliasNbPages();
$header = array('Kode Barang','Nama Barang', 'Jumlah');
$data = $pdf->LoadData();

$pdf->AddPage();
$pdf->Ln(20);
$pdf->BasicTable($header,$data);
$filename=base64_decode($_GET['inf']);
$pdf->Output('','','faktur.pdf');
?>
