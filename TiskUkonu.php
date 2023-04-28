<?php

@$dnes=date("Y-n-d");
/*tvorba n�hledu po��zen�ho z�znamu pomoci n�stroje FPDF*/
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

$pdf->Write(12,"Tisk Druh� Z�znam�                                                                                                               Tisk Dne: ".date("d.n.Y"));

$pdf->SetFont('tahoma','',7);
$pdf->Ln();
$pdf->SetLineWidth(0.4);
$pdf->SetFillColor(200,200,200);
$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();
$pdf->Cell(9,6,"Po�ad�",'LB');
$pdf->Cell(30,6,"N�zev Z�znamu",'LBR');
$pdf->Cell(20,6,"Zkratka",'LBR');
$pdf->Cell(20,6,"Syst�mov� ��slo",'LBR');
$pdf->Cell(40,6,"Syst�mov� N�zev",'LBR');
$pdf->Cell(52,6,"Popis",'LBR');
$pdf->Cell(10,6,"Stav",'LBR');
$pdf->Cell(10,6,"Pou�ito",'LBR');
$pdf->Ln();
$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();

mysql_connect('localhost', 'root', ''); // P�ipojen� k MySQL serveru
mysql_select_db('dochazkovy_system'); // V�b�r datab�ze

@$data1=mysql_query("select * from ukony order by nazev,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
@$nazev= mysql_result($data1,@$cykl,1);


$pdf->Cell(9,6,@$cykl+1,'LBR');
$pdf->Cell(30,6,mysql_result($data1,@$cykl,1),'LBR');
$pdf->Cell(20,6,mysql_result($data1,@$cykl,10),'LBR');
$pdf->Cell(20,6,mysql_result($data1,@$cykl,2),'LBR');
$pdf->Cell(40,6,mysql_result($data1,@$cykl,3),'LBR');
$pdf->Cell(52,6,mysql_result($data1,@$cykl,5),'LBR');
$pdf->Cell(10,6,mysql_result($data1,@$cykl,4),'LBR');

@$control= mysql_result($data1,@$cykl,0);
@$control1=mysql_query("select id from zpracovana_dochazka where id_ukonu='$control'");
@$control=mysql_num_rows($control1);

if (@$control<>"") {$pdf->Cell(10,6,"ANO",'LBR');} else {$pdf->Cell(10,6,"NE",'LBR');}
$pdf->Ln(6);

  @$cykl++;
endwhile;

$pdf->Output();





