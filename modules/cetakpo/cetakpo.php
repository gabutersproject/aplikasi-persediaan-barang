cetakpo.php
<?php
require('../../fpdf17/fpdf.php');
include "../../class/fungsi_terbilang.php";
class PDF extends FPDF
{
function Header()
{
   $this->SetFont('Arial','B',20);
    $this->Cell(30,10,'PURCHASE ORDER');

    
    $this->Ln(5);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'No  : '.base64_decode($_GET['inf']).'');

    $this->Ln(10);

    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'PT.KHANZA');

    $this->ln(5);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Jl kol.Sugiono No.37a Duren sawit Jakarta Timur');
 
    $this->cell(80);
    $this->SetFont('Arial','',10);
    $this->cell(30,10,'Jakarta, '.base64_decode($_GET['uuid']).'');
    

    $this->Ln(5);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Telp/Fax : 02170885532');
    

    $this->Cell(80);
    $this->SetFont('Arial','b',15);
    $this->Cell(30,10,'Kepada : '.base64_decode($_GET['id-uid']).'',0,'C');

    $this->Line(10,50,150,50);

    
}
function LoadData(){
	mysql_connect("localhost","root","");
	mysql_select_db("khanza");
	$id=base64_decode($_GET['oid']);
	$data=mysql_query("select kode_purchase,nama_barangp,detail,harga_barangp from dpurchase where kode_purchase='$id'");
	
	while ($r=  mysql_fetch_array($data))
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
        $this->Cell(40,7,$header[3],1);
    $this->Ln();
    
    $this->SetFont('Arial','',12);
    foreach($data as $row)
    {
        $this->Cell(35,7,$row['nama_barang'],1);
        $this->Cell(100,7,$row['detail'],1);
        $this->Cell(40,7,$row['harga_barangp'],1);
        $this->Cell(40,7,$row['jumlah'],1);
        $this->Ln();
    }

    mysql_connect("localhost","root","");
	mysql_select_db("khanza");
	$id=base64_decode($_GET['oid']);

    $getsum=mysql_query("select sum(jumlah) as jumlah from dpurchase where kode_purchase='$id'");
	$getsum1=mysql_fetch_array($getsum);
	$this->cell(5);
	$this->cell(90);
	$this->cell(40,7,'Sub total : ');
    $this->cell(40,7,number_format($getsum1['jumlah']).'',1);
    
    $this->Ln(30);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Menyetujui');

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
