<?php

@$dnes=date("Y-n-d");
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

$pdf->Write(12,"Tisk Nastavení Funkèních Kláves                                                                                         Tisk Dne: ".date("d.n.Y"));

$pdf->Ln();
$pdf->SetLineWidth(0.4);
$pdf->SetFillColor(200,200,200);
$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();
$pdf->Cell(15,6,"Poøadí",'LB');
$pdf->Cell(30,6,"ASCII Hodnota",'LBR');
$pdf->Cell(30,6,"Èíslo Klávesy",'LBR');
$pdf->Cell(60,6,"Název Funkce",'LBR');
$pdf->Cell(30,6,"Stav Klávesy",'LBR');
$pdf->Cell(26,6,"Použito",'LBR');
$pdf->Ln();
$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();

mysql_connect('localhost', 'root', ''); // Pøipojení k MySQL serveru
mysql_select_db('dochazkovy_system'); // Výbìr databáze

@$data1=mysql_query("select * from klavesnice order by cislo,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
@$nazev= mysql_result($data1,@$cykl,1);


$pdf->Cell(15,6,@$cykl+1,'LBR');
$pdf->Cell(30,6,mysql_result($data1,@$cykl,1),'LBR');
$pdf->Cell(30,6,mysql_result($data1,@$cykl,2),'LBR');
$pdf->Cell(60,6,mysql_result($data1,@$cykl,3),'LBR');
$pdf->Cell(30,6,mysql_result($data1,@$cykl,4),'LBR');

@$control= mysql_result($data1,@$cykl,2);
@$control1=mysql_query("select id from dochazka where operace='$control'");
@$control=mysql_num_rows($control1);

if (@$control<>"") {$pdf->Cell(26,6,"ANO",'LBR');} else {$pdf->Cell(26,6,"NE",'LBR');}
$pdf->Ln(6);

  @$cykl++;
endwhile;

$pdf->Output();





