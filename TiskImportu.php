<?php

@$obdobi=base64_decode(@$_GET["obdobi"]);

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

$pdf->Write(12,"Tisk Importù z Období: ".$obdobi."                                                                                          Tisk Dne: ".date("d.n.Y"));

$pdf->SetFont('tahoma','',10);
$pdf->Ln();
$pdf->SetLineWidth(0.4);
$pdf->SetFillColor(200,200,200);
$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();
$pdf->Cell(15,6,"Poøadí",'LB');
$pdf->Cell(25,6,"Osobní Èíslo",'LBR');
$pdf->Cell(20,6,"Období",'LBR');
$pdf->Cell(25,6,"Èerpat z MR",'LBR');
$pdf->Cell(35,6,"Zùstatek v BR",'LBR');
$pdf->Cell(25,6,"Odpracováno",'LBR');
$pdf->Cell(26,6,"Koneèný Stav",'LBR');
$pdf->Cell(20,6,"Plán.Harm.",'LBR');
$pdf->Ln();
$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();

mysql_connect('localhost', 'root', ''); // Pøipojení k MySQL serveru
mysql_select_db('dochazkovy_system'); // Výbìr databáze

$data1= mysql_query("select * from import_system where obdobi='$obdobi' order by obdobi,osobni_cislo,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
@$nazev= mysql_result($data1,@$cykl,1);


$pdf->Cell(15,6,@$cykl+1,'LBR');
$pdf->Cell(25,6,mysql_result($data1,@$cykl,1),'LBR');
$pdf->Cell(20,6,mysql_result($data1,@$cykl,2),'LBR');
$pdf->Cell(25,6,mysql_result($data1,@$cykl,3)." Dní",'LBR');
$pdf->Cell(35,6,mysql_result($data1,@$cykl,4)." Dní",'LBR');
$pdf->Cell(25,6,mysql_result($data1,@$cykl,5)." Hod.",'LBR');
$pdf->Cell(26,6,mysql_result($data1,@$cykl,6)." Hod.",'LBR');
$pdf->Cell(20,6,mysql_result($data1,@$cykl,9)." Hod.",'LBR');
$pdf->Ln();

  @$cykl++;
endwhile;

$pdf->Output();





