<?php
include "./dbconnect.php";

@$dnes=date("Y-m-d");
/*tvorba náhledu poøízeného záznamu pomoci nástroje FPDF*/
define('FPDF_FONTPATH',"fPDF/fnt/");
require("fPDF/fpdf.php");

//$pdf = new FPDF('L','mm','A4');
$pdf = new FPDF('P','mm','A4');

$pdf->Open();
$pdf->AddFont('tahoma','',"tahoma.php");
$pdf->SetMargins(10,5);
$pdf->AddPage();
//$pdf->Image("img/stempl.jpg",149,5,40);
$pdf->SetFont('tahoma','',10);

$pdf->Write(12,"Tisk Turniketu                                                                                                                Tisk Dne: ".date("d.m.Y"));

$pdf->Ln();
$pdf->SetLineWidth(0.4);
$pdf->SetFillColor(200,200,200);
$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();
$pdf->Cell(25,6,"Poøadí",'LB');
$pdf->Cell(65,6,"Název",'LBR');
$pdf->Cell(45,6,"IP Adresa",'LBR');
$pdf->Cell(56,6,"Stav",'LBR');
$pdf->Ln();
$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();


@$data1=mysql_query("select * from turnikety order by nazev,id");
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):



$pdf->Cell(25,6,@$cykl+1,'LBR');
$pdf->Cell(65,6,mysql_result($data1,@$cykl,1),'LBR');
$pdf->Cell(45,6,mysql_result($data1,@$cykl,2),'LBR');
$pdf->Cell(56,6,mysql_result($data1,@$cykl,3),'LBR');
$pdf->Ln(6);

  @$cykl++;
endwhile;

$pdf->Output();





