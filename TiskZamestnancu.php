<?php


@$stav=base64_decode(@$_GET["stav"]);if (@$stav=="A") {$filtr="where datumout='0000-00-00'";} if (@$stav=="N") {$filtr="where datumout<>'0000-00-00'";}if (@$stav=="") {$filtr="where datumout<>''";}
@$dnes=date("Y-n-d");
/*tvorba náhledu poøízeného záznamu pomoci nástroje FPDF*/
define('FPDF_FONTPATH',"fPDF/fnt/");
require("fPDF/fpdf.php");

//$pdf = new FPDF('L','mm','A4');
$pdf = new FPDF('L','mm','A4');

$pdf->Open();
$pdf->AddFont('tahoma','',"tahoma.php");
$pdf->SetMargins(10,5);
$pdf->AddPage();
//$pdf->Image("img/stempl.jpg",149,5,40);
$pdf->SetFont('tahoma','',7);

if (@$stav=="A") {$text="Tisk Aktivních Zamìstnancù";}if (@$stav=="N") {$text="Tisk Neaktivních Zamìstnancù";}if (@$stav=="") {$text="Tisk Všech Zamìstnancù";}

@$stredisko=base64_decode(@$_GET["stredisko"]);if (@$stredisko<>"") {$filtr=$filtr." and stredisko='".$stredisko."'";$text=$text." støediska: ".$stredisko;}


$pdf->Write(12,$text."                                                                                                                                                                                                                                       Tisk Dne: ".date("d.n.Y"));

$pdf->Ln();
$pdf->SetLineWidth(0.4);
$pdf->SetFillColor(200,200,200);
$pdf->Cell(278,0.4,"",'T');
$pdf->Ln();
$pdf->Cell(7,6,"Poø.",'LB');
$pdf->Cell(12,6,"Os. Èíslo",'LBR');
$pdf->Cell(18,6,"Platný Èip",'LB');
$pdf->Cell(7,6,"Titul",'LBR');
$pdf->Cell(16,6,"Jméno",'LBR');
$pdf->Cell(17,6,"Pøíjmení",'LBR');
$pdf->Cell(15,6,"Rodné Èíslo",'LBR');
$pdf->Cell(16,6,"Datum Nást.",'LBR');
$pdf->Cell(16,6,"Datum Ukon.",'LBR');
$pdf->Cell(27,6,"Ulice",'LBR');
$pdf->Cell(20,6,"Mìsto",'LBR');
$pdf->Cell(7,6,"PSÈ",'LBR');
$pdf->Cell(12,6,"Telefon",'LBR');
$pdf->Cell(29,6,"Email",'LBR');
$pdf->Cell(9,6,"Kateg.",'LBR');
$pdf->Cell(12,6,"Akt.Stø.",'LBR');
$pdf->Cell(10,6,"Pr.Doba",'LBR');
$pdf->Cell(8,6,"Export",'LBR');
$pdf->Cell(10,6,"Ved Pr.",'LBR');
$pdf->SetFont('tahoma','',5);$pdf->Cell(10,6,"Záznamy",'LBR');$pdf->SetFont('tahoma','',7);
$pdf->Ln();
$pdf->Cell(278,0.4,"",'T');
$pdf->Ln();

mysql_connect('localhost', 'root', ''); // Pøipojení k MySQL serveru
mysql_select_db('dochazkovy_system'); // Výbìr databáze

@$data1=mysql_query("select * from zamestnanci $filtr order by osobni_cislo,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):

$pdf->Cell(7,6,$cykl,'LB'); @$oscislo=mysql_result($data1,@$cykl,1);
$pdf->Cell(12,6,mysql_result($data1,@$cykl,1),'LBR');
$pdf->Cell(18,6,mysql_result(mysql_query("select cip from cipy where osobni_cislo='$oscislo' and platnostdo='0000-00-00'"),0,0),'LBR');
$pdf->Cell(7,6,mysql_result($data1,@$cykl,2),'LBR');
$pdf->Cell(16,6,mysql_result($data1,@$cykl,3),'LBR');
$pdf->Cell(17,6,mysql_result($data1,@$cykl,4),'LBR');
$pdf->Cell(15,6,mysql_result($data1,@$cykl,5),'LBR');
$casti = explode("-", mysql_result($data1,@$cykl,11));$pdf->Cell(16,6,$casti[2].".".$casti[1].".".$casti[0],'LBR');
$casti = explode("-", mysql_result($data1,@$cykl,12));if ($casti[2].".".$casti[1].".".$casti[0]<>"00.00.0000") {$pdf->Cell(16,6,$casti[2].".".$casti[1].".".$casti[0],'LBR');} else {$pdf->Cell(16,6,"",'LBR');}
$pdf->Cell(27,6,mysql_result($data1,@$cykl,6),'LBR');
$pdf->Cell(20,6,mysql_result($data1,@$cykl,7),'LBR');
$pdf->Cell(7,6,mysql_result($data1,@$cykl,8),'LBR');
$pdf->SetFont('tahoma','',6);$pdf->Cell(12,6,mysql_result($data1,@$cykl,9),'LBR');
$pdf->Cell(29,6,mysql_result($data1,@$cykl,10),'LBR');$pdf->SetFont('tahoma','',8);
$pdf->Cell(9,6,mysql_result($data1,@$cykl,18),'LBR');
$pdf->Cell(12,6,mysql_result($data1,@$cykl,17),0,0),'LBR');
$pdf->Cell(10,6,mysql_result($data1,@$cykl,20),'LBR');
$pdf->Cell(8,6,mysql_result($data1,@$cykl,21),'LBR');
if (mysql_result($data1,@$cykl,19)=="A"){$pdf->Cell(10,6,"ANO",'LBR');} else {$pdf->Cell(10,6,"NE",'LBR');};

@$control= mysql_result($data1,@$cykl,0);@$control1=mysql_query("select id from dochazka where osobni_cislo='$oscislo'");@$control=mysql_num_rows($control1);
$pdf->SetFont('tahoma','',5);if (@$control<>"") {$pdf->Cell(10,6,"ANO",'LBR');} else {$pdf->Cell(10,6,"NE",'LBR');}$pdf->SetFont('tahoma','',6);
$pdf->Ln();


@$cykl++;endwhile;



$pdf->Output();





