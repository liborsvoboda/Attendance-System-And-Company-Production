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
$pdf->SetFont('tahoma','',8);

$pdf->Write(12,"Tisk ��seln�ch �ad Evidence Palet                                                                                                                           Tisk Dne: ".date("d.n.Y"));

$pdf->Ln();
$pdf->SetLineWidth(0.4);
$pdf->SetFillColor(200,200,200);
$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();
$pdf->Cell(10,6,"Po�ad�",'LB');
$pdf->Cell(47,6,"N�zev",'LBR');
$pdf->Cell(31,6,"Akt.Hodnota ��s. �ady",'LBR');
$pdf->Cell(24,6,"Stav",'LBR');
$pdf->Cell(67,6,"Popis",'LBR');
$pdf->Cell(12,6,"Pou�ito",'LBR');
$pdf->Ln();
$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();

mysql_connect('localhost', 'root', ''); // P�ipojen� k MySQL serveru
mysql_select_db('dochazkovy_system'); // V�b�r datab�ze


@$data1=mysql_query("select * from ciselnarada order by nazev,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):

$pdf->Cell(10,6,@$cykl+1,'LB');
$pdf->Cell(47,6,mysql_result($data1,@$cykl,1),'LBR');

if (mysql_num_rows($data1)) {$cislo=mysql_result($data1,0,3);@$high=0;while (@$high<(mysql_result($data1,0,4)- StrLen(mysql_result($data1,0,3)))):  $cislo="0".$cislo;@$high++;endwhile;} else {$cislo="";}

$pdf->Cell(31,6,mysql_result($data1,@$cykl,2).@$cislo,'LBR');
if (mysql_result($data1,$cykl,5)=="A") {$pdf->Cell(24,6,"Aktivn�",'LBR');}
if (mysql_result($data1,$cykl,5)=="P") {$pdf->Cell(24,6,"Pozastaveno",'LBR');}
if (mysql_result($data1,$cykl,5)=="N") {$pdf->Cell(24,6,"Neaktivn�",'LBR');}
$pdf->Cell(67,6,mysql_result($data1,@$cykl,6),'LBR');
if (mysql_result($data1,@$cykl,3)<>mysql_result($data1,@$cykl,7)) {$pdf->Cell(12,6,"ANO",'LBR');} else {$pdf->Cell(12,6,"NE",'LBR');}
$pdf->Ln();


@$cykl++;endwhile;



$pdf->Output();





