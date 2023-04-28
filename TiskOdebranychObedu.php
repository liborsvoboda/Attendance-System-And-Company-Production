<?
@$dnes=date("Y-m-d");

@$obdobi=@$_GET["obdobi"];
@$osoba=@$_GET["osoba"];
@$souhrn=@$_GET["souhrn"];

if (@$osoba<>"" and @$osoba<>"Všichni") {$dotaz=" and osobni_cislo = '".@$osoba."' ";} else {$text="Všech";}

include ("./"."dbconnect.php");

/*tvorba náhledu poøízeného záznamu pomoci nástroje FPDF*/
define('FPDF_FONTPATH',"fPDF/fnt/");
require("fPDF/fpdf.php");

//$pdf = new FPDF('L','mm','A4');
$pdf = new FPDF('P','mm','A4');

$pdf->Open();
$pdf->AddFont('tahoma','',"tahoma.php");
$pdf->AddFont('tahomabd','',"tahomabd.php");
$pdf->SetMargins(10,5);
$pdf->AddPage();
//$pdf->Image("img/stempl.jpg",149,5,40);
$pdf->SetFont('tahomabd','',10);

$pdf->Write(12,"Tisk ".$text." Odebraných Obìdù za období: ".$obdobi."                                                       Tisk Dne: ".date("d.n.Y"));$pdf->Ln(5);
if (@$osoba<>"" and @$osoba<>"Všichni") {$pdf->SetFont('tahoma','',10);$pdf->Write(12,"Pouze: ".$osoba." ".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".mysql_real_escape_string($osoba)."' "),0,0));}
//$pdf->Ln();
//$pdf->SetLineWidth(0.4);
$pdf->SetFillColor(220,220,220);
//$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();
$pdf->SetFont('tahoma','',10);

//hlavicka
if (@$souhrn) {$pdf->Cell(50,6,"Osobní Èíslo",'LBRT',0,1,0);$pdf->Cell(100,6,"Pøíjmení Jméno",'LBRT',0,1,0);$pdf->Cell(20,6,"Stav",'LBRT',0,0,0);$pdf->Cell(21,6,"Cena",'LBRT',0,0,0);}
else {$pdf->Cell(15,6,"Os. Èíslo",'LBRT',0,1,0);$pdf->Cell(31,6,"Pøíjmení Jméno",'LBRT',0,1,0);$pdf->Cell(14,6,"Datum",'LBRT',0,1,0);$pdf->Cell(96,6,"Obìd",'LBRT',0,1,0);$pdf->Cell(15,6,"Stav",'LBRT',0,0,0);$pdf->Cell(20,6,"Cena",'LBRT',0,0,0);}
$pdf->Ln();

//telo
$data1=mysql_query("select id,osobni_cislo,date_format(datum,'%d.%m.%Y'),skupina,obed,cena,priloha,vedlejsi_strava,stav from objednavky_obedu where datum like '".mysql_real_escape_string($obdobi)."%' $dotaz order by osobni_cislo,datum,id") or Die(MySQL_Error());
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
@$vedlejsi=explode("+:+",mysql_result($data1,$cykl,7));

$jmeno=mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".mysql_real_escape_string(mysql_result($data1,$cykl,1))."' "),0,0);

if (@$souhrn=="on") {$cena=$cena+mysql_result($data1,$cykl,5)+$vedlejsi[2];$cenao=$cenao+mysql_result($data1,$cykl,5)+$vedlejsi[2];}

if (@$souhrn=="on" and mysql_result($data1,$cykl,1)<>mysql_result($data1,($cykl+1),1)) {$pdf->Cell(50,6,mysql_result($data1,$cykl,1),'LBRT',0,1,0);
$pdf->Cell(100,6,$jmeno,'LBRT',0,1,0);
$pdf->Cell(20,6,mysql_result($data1,$cykl,8),'LBRT',0,0,0);
$pdf->Cell(21,6,$cenao." Kè",'LBRT',0,0,0);
$pdf->Ln();$cenao=0;}

if (@$souhrn<>"on") {

if (mysql_result($data1,$cykl,6)) {$priloha="(".mysql_result($data1,$cykl,6).")";} else {@$priloha="";}

$obed=str_replace ("</br>",";",mysql_result($data1,$cykl,4));$pdf->Cell(15,6,mysql_result($data1,$cykl,1),'LBRT',0,1,0);
$pdf->SetFont('tahoma','',8);
$pdf->Cell(31,6,$jmeno,'LBRT',0,1,0);
$pdf->SetFont('tahoma','',7);
$pdf->Cell(14,6,mysql_result($data1,$cykl,2),'LBRT',0,1,0);

$pdf->SetFont('tahoma','',5);
$pdf->Cell(96,6,mysql_result($data1,$cykl,3)." - ".$obed.$priloha.",".$vedlejsi[0]."-".$vedlejsi[1],'LBRT',0,1,0);
$pdf->SetFont('tahoma','',8);$pdf->Cell(15,6,mysql_result($data1,$cykl,8),'LBRT',0,0,0);

$pdf->SetFont('tahoma','',10);
$pdf->Cell(20,6,(mysql_result($data1,$cykl,5)+$vedlejsi[2])." Kè",'LBRT',0,0,0);
$pdf->Ln();$cena=$cena+mysql_result($data1,$cykl,5)+$vedlejsi[2];}


$cykl++;endwhile;

$pdf->SetFont('tahomabd','',10);
if (@$souhrn) {$pdf->Cell(150,6,"Cena Celkem",'LBRT',0,1,0);$pdf->Cell(41,6,$cena." Kè",'LBRT',0,0,0);}
		 else {$pdf->Cell(171,6,"Cena Celkem",'LBRT',0,1,0);$pdf->Cell(20,6,$cena." Kè",'LBRT',0,0,0);}


$pdf->Output();
?>

