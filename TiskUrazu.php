<?php
include ("./"."dbconnect.php");

$data1=mysql_query("select * from kniha_urazu where osobni_cislo='".mysql_real_escape_string(base64_decode(@$_GET["zamestnanec"]))."' and id='".mysql_real_escape_string(base64_decode(@$_GET["id"]))."'");
$data=explode(":+:",mysql_result($data1,0,2));$poradi=0;


@$dnes=date("Y-m-d");
/*tvorba n�hledu po��zen�ho z�znamu pomoci n�stroje FPDF*/
define('FPDF_FONTPATH',"fPDF/fnt/");
require("fPDF/fpdf.php");

//$pdf = new FPDF('L','mm','A4');
$pdf = new FPDF('P','mm','A4');

$pdf->Open();
$pdf->AddFont('tahoma','',"times.php");
$pdf->AddFont('tahomab','',"timesbd.php");
$pdf->AddFont('tahomai','',"timesi.php");
$pdf->SetMargins(10,5);
$pdf->AddPage();
//$pdf->Image("img/stempl.jpg",149,5,40);

$pdf->SetFont('tahomab','',14);
$pdf->Ln(5);
$pdf->SetLineWidth(0.4);
$pdf->SetFillColor(200,200,200);
$pdf->SetFont('tahomab','',14);$pdf->Cell(140,5,"KNIHA �RAZ� - EVIDOVAN� �RAZ ZAM�STNANCE",'',0,'R');
$pdf->SetFont('tahomab','',5);$pdf->Cell(5,3,"1",'');
$pdf->SetFont('tahomab','',14);$pdf->Cell(30,5,"�. .........".$data[$poradi++],'',0,'L');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);
$pdf->Cell(90,5,"Jm�no a p��jmen� �razem posti�en�ho zam�stnance:",'LRT',0,'L');
$pdf->Cell(30,5,"Datum narozen�:",'LRT',0,'L');
$pdf->Cell(71,5,"Adresa bydli�t�:",'LRT',0,'L');
$pdf->Ln();

$pdf->SetFont('tahoma','',10);
$pdf->Cell(90,5,mysql_result(mysql_query("select concat(titul,' ',jmeno,' ',prijmeni) from zamestnanci where osobni_cislo='".mysql_real_escape_string($data[$poradi++])."' "),0,0),'LR',0,'L');
$pdf->Cell(30,5,$data[$poradi++],'LR',0,'C');
$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while($vypis[@$cykl]):if (@$cykl==0) {$pdf->Cell(71,5,$vypis[$cykl],'LR',0,'L');}
else {$pdf->Ln();$pdf->Cell(90,5,"",'LR',0,'L');$pdf->Cell(30,5,"",'LR',0,'L');$pdf->Cell(71,5,$vypis[$cykl],'LR',0,'L');}
@$cykl++;endwhile;
$pdf->Ln();

$pdf->SetFont('tahomai','',10);
$pdf->Cell(80,5,"Druh Pr�ce:",'LRT',0,'L');
$pdf->Cell(111,5,"D�lka trv�n� z�kladn�ho pracovn�pr�vn�ho vztahu u zam�stnavatele:",'LRT',0,'L');
$pdf->Ln();

$pdf->SetFont('tahoma','',10);
$pdf->Cell(80,5,$data[$poradi++],'LRB',0,'L');
$pdf->Cell(111,5,"rok�...".$data[$poradi++]."...     m�s�c�...".$data[$poradi++]."...",'LRB',0,'C');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);
$pdf->Cell(60,5,"Datum �razu:        ".$data[$poradi++],'LRB',0,'L');
$pdf->Cell(60,5,"Po�et hodin odpracovan�ch",'LRT',0,'L');$text=$data[$poradi++];
$pdf->Cell(71,5,"�innost, p�i n� k �razu do�lo:",'LRT',0,'L');



$vypis=explode ("
",$data[$poradi++]);
$pdf->Ln();
$pdf->Cell(60,5,"Hodina �razu:        ".$data[$poradi++],'LR',0,'L');
$pdf->Cell(60,5,"bezprost�edn� p�ed vznikem ",'LR',0,'L');
$pdf->Cell(71,5,$vypis[0],'LR',0,'L');
$pdf->Ln();
$pdf->Cell(60,5,"",'LRB',0,'L');
$pdf->Cell(60,5,"�razu:              ".$text,'LRB',0,'L');
$pdf->Cell(71,5,$vypis[1],'LRB',0,'L');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);
$pdf->Cell(111,5,"M�sto kde k �razu do�lo:",'LR',0,'L');
$pdf->Cell(80,5,"Bylo m�sto �razu pravideln�m pracovi�t�m",'LR',0,'L');
$pdf->Ln();

$pdf->SetFont('tahoma','',10);
$vypis=explode ("
",$data[$poradi++]);
$pdf->Cell(111,5,$vypis[0],'LR',0,'L');
$pdf->Cell(80,5,"zam�stnance?                     ",'LR',0,'L');
$pdf->Ln();
$pdf->Cell(111,5,$vypis[1],'LRB',0,'L');
$pdf->Cell(80,5,"".$data[$poradi++],'LRB',0,'C');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);
$pdf->Cell(111,5,"Druh zran�n�:",'LR',0,'L');
$pdf->Cell(40,5,"O�et�en u l�ka�e:",'LR',0,'L');
$pdf->Cell(40,5,"Celkov� po�et",'LR',0,'L');
$pdf->Ln();

$pdf->SetFont('tahoma','',10);
$pdf->Cell(111,5,$data[$poradi++],'LR',0,'L');
$pdf->Cell(40,5,"",'LR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(40,5,"zran�n�ch osob:",'LR',0,'L');
$pdf->Ln();
$pdf->Cell(111,5,"Zran�n� ��st t�la:",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(40,5,$data[$poradi++],'LR',0,'C');
$pdf->Cell(40,5,$data[$poradi++],'LR',0,'C');
$pdf->Ln();
$pdf->Cell(111,5,$data[$poradi++],'LBR',0,'L');
$pdf->Cell(40,5,"",'LBR',0,'L');
$pdf->Cell(40,5,"",'LBR',0,'L');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);$pdf->Cell(131,5,"Druh �razu:",'LTR',0,'L');
$pdf->Cell(60,5,"Z�znam o �razu seps�n dne:",'LTR',0,'L');
$pdf->Ln();

$pdf->SetFont('tahoma','',10);
$text=$data[$poradi++];if ($text==1) {$dodat="          X  ";} else {$dodat="              ";}
$pdf->Cell(131,5,$dodat."Smrteln�",'LR',0,'L');
$pdf->Cell(60,5,"",'LR',0,'C');
$pdf->Ln();
if ($text==2) {$dodat="          X  ";} else {$dodat="              ";}
$pdf->Cell(131,5,$dodat."S pracovn� neschopnost� del�� ne� 3 kalen��n� dny",'LR',0,'L');
$pdf->SetFont('tahoma','',16);$pdf->Cell(60,5,$data[$poradi++],'LR',0,'C');
$pdf->SetFont('tahoma','',10);$pdf->Ln();
if ($text==3) {$dodat="          X  ";} else {$dodat="              ";}
$pdf->Cell(131,5,$dodat."S hospitalizac� p�esahuj�c� 5 dn�",'LR',0,'L');
$pdf->Cell(60,5,"",'LR',0,'C');
$pdf->Ln();
if ($text==4) {$dodat="          X  ";} else {$dodat="              ";}
$pdf->Cell(131,5,$dodat."S pracovn� neschopnost� krat�� ne� 3 kalen��n� dny",'LR',0,'L');
$pdf->Cell(60,5,"",'LR',0,'C');
$pdf->Ln();
if ($text==5) {$dodat="          X  ";} else {$dodat="              ";}
$pdf->Cell(131,5,$dodat."Bez pracovn� neschopnosti",'LBR',0,'L');
$pdf->Cell(60,5,"",'LBR',0,'C');
$pdf->Ln();

$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<6):
if (@$cykl==0) {$pdf->Cell(191,5,"Popis �razov�ho d�je:  ".$vypis[$cykl],'LR',0,'L');}
if (@$cykl>0 and @$cykl<5) {$pdf->Cell(191,5,$vypis[$cykl],'LR',0,'L');}
if (@$cykl==5) {$pdf->Cell(191,5,$vypis[$cykl],'LBR',0,'L');}
$pdf->Ln();
@$cykl++;endwhile;


$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"Pro� k �razu do�lo? (p����ny):",'LTR',0,'L');
$pdf->Cell(110,5,"Co bylo zdrojem �razu?",'LTR',0,'L');
$pdf->Ln();
$pdf->SetFont('tahoma','',10);$pdf->Cell(81,5,$data[$poradi++],'LBR',0,'L');
$pdf->Cell(110,5,$data[$poradi++],'LBR',0,'L');
$pdf->Ln();

$pdf->Cell(191,5,"Byla u �razem posti�en�ho zam�stnance zji�t�na p��tomnost alkoholu (jin�ch n�vykov�ch l�tek)?           ".$data[$poradi++],'LBRT',0,'L');
$pdf->Ln();

$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<3):
if (@$cykl==0) {$pdf->Cell(191,5,"Jak� p�edpisy byly v souvislosti s poran�n�m poru�eny a k�m?  ".$vypis[$cykl],'LR',0,'L');}
if (@$cykl>0 and @$cykl<2) {$pdf->Cell(191,5,$vypis[$cykl],'LR',0,'L');}
if (@$cykl==2) {$pdf->Cell(191,5,$vypis[$cykl],'LBR',0,'L');}
$pdf->Ln();
@$cykl++;endwhile;

$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"�razem posti�en� zam�stnanec:",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LBR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(110,5,"(datum, jm�no, podpis)",'LBR',0,'C');
$pdf->Ln();

$pdf->Cell(81,5,"Sv�dci �razu:",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(110,5,"(datum, jm�no, podpis)",'LBR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(110,5,"(datum, jm�no, podpis)",'LBR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LBR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(110,5,"(datum, jm�no, podpis)",'LBR',0,'C');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"Z�stupce odborov� organizace",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"(z�stupce zam�stnanc� pro BOZP):",'LBR',0,'L');
$pdf->Cell(110,5,"(datum, jm�no, podpis)",'LBR',0,'C');
$pdf->Ln();

$pdf->Cell(81,5,"Jm�no a pracovn� za�azen� toho, kdo �daje",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"zaznamenal:",'LBR',0,'L');
$pdf->Cell(110,5,"(datum, jm�no, podpis)",'LBR',0,'C');
$pdf->Ln();

$pdf->SetFont('tahoma','',10);
$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<3):
if (@$cykl==0) {$pdf->Cell(191,5,"Pozn�mka:   ".$vypis[$cykl],'LR',0,'L');}
if (@$cykl>0 and @$cykl<2) {$pdf->Cell(191,5,$vypis[$cykl],'LR',0,'L');}
if (@$cykl==2) {$pdf->Cell(191,5,$vypis[$cykl],'LBR',0,'L');}
$pdf->Ln();
@$cykl++;endwhile;


$pdf->Cell(191,10,"_____________________________",'',0,'L');
$pdf->Ln(8);

$pdf->SetFont('tahomai','',5);$pdf->Cell(2,3,"1",'');
$pdf->SetFont('tahomai','',10);$pdf->Cell(189,5,"Zam�stnavatel vede v knize �raz� evidenci o v�ech �razech, i kdy� jimi nebyla zp�sobena pracovn� neschopnost nebo",'',0,'L');
$pdf->Ln();
$pdf->Cell(191,5,"byla zp�sobena pracovn� neschopnost nep�esahuj�c� 3 kalend��n� dny.",'',0,'L');

$pdf->Output();





