<?php
include ("./"."dbconnect.php");

$data1=mysql_query("select * from kniha_urazu where osobni_cislo='".mysql_real_escape_string(base64_decode(@$_GET["zamestnanec"]))."' and id='".mysql_real_escape_string(base64_decode(@$_GET["id"]))."'");
$data=explode(":+:",mysql_result($data1,0,2));$poradi=0;


@$dnes=date("Y-m-d");
/*tvorba náhledu poøízeného záznamu pomoci nástroje FPDF*/
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
$pdf->SetFont('tahomab','',14);$pdf->Cell(140,5,"KNIHA ÚRAZÙ - EVIDOVANÝ ÚRAZ ZAMÌSTNANCE",'',0,'R');
$pdf->SetFont('tahomab','',5);$pdf->Cell(5,3,"1",'');
$pdf->SetFont('tahomab','',14);$pdf->Cell(30,5,"è. .........".$data[$poradi++],'',0,'L');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);
$pdf->Cell(90,5,"Jméno a pøíjmení úrazem postiženého zamìstnance:",'LRT',0,'L');
$pdf->Cell(30,5,"Datum narození:",'LRT',0,'L');
$pdf->Cell(71,5,"Adresa bydlištì:",'LRT',0,'L');
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
$pdf->Cell(80,5,"Druh Práce:",'LRT',0,'L');
$pdf->Cell(111,5,"Délka trvání základního pracovnìprávního vztahu u zamìstnavatele:",'LRT',0,'L');
$pdf->Ln();

$pdf->SetFont('tahoma','',10);
$pdf->Cell(80,5,$data[$poradi++],'LRB',0,'L');
$pdf->Cell(111,5,"rokù...".$data[$poradi++]."...     mìsícù...".$data[$poradi++]."...",'LRB',0,'C');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);
$pdf->Cell(60,5,"Datum úrazu:        ".$data[$poradi++],'LRB',0,'L');
$pdf->Cell(60,5,"Poèet hodin odpracovaných",'LRT',0,'L');$text=$data[$poradi++];
$pdf->Cell(71,5,"Èinnost, pøi níž k úrazu došlo:",'LRT',0,'L');



$vypis=explode ("
",$data[$poradi++]);
$pdf->Ln();
$pdf->Cell(60,5,"Hodina úrazu:        ".$data[$poradi++],'LR',0,'L');
$pdf->Cell(60,5,"bezprostøednì pøed vznikem ",'LR',0,'L');
$pdf->Cell(71,5,$vypis[0],'LR',0,'L');
$pdf->Ln();
$pdf->Cell(60,5,"",'LRB',0,'L');
$pdf->Cell(60,5,"úrazu:              ".$text,'LRB',0,'L');
$pdf->Cell(71,5,$vypis[1],'LRB',0,'L');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);
$pdf->Cell(111,5,"Místo kde k úrazu došlo:",'LR',0,'L');
$pdf->Cell(80,5,"Bylo místo úrazu pravidelným pracovištìm",'LR',0,'L');
$pdf->Ln();

$pdf->SetFont('tahoma','',10);
$vypis=explode ("
",$data[$poradi++]);
$pdf->Cell(111,5,$vypis[0],'LR',0,'L');
$pdf->Cell(80,5,"zamìstnance?                     ",'LR',0,'L');
$pdf->Ln();
$pdf->Cell(111,5,$vypis[1],'LRB',0,'L');
$pdf->Cell(80,5,"".$data[$poradi++],'LRB',0,'C');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);
$pdf->Cell(111,5,"Druh zranìní:",'LR',0,'L');
$pdf->Cell(40,5,"Ošetøen u lékaøe:",'LR',0,'L');
$pdf->Cell(40,5,"Celkový poèet",'LR',0,'L');
$pdf->Ln();

$pdf->SetFont('tahoma','',10);
$pdf->Cell(111,5,$data[$poradi++],'LR',0,'L');
$pdf->Cell(40,5,"",'LR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(40,5,"zranìných osob:",'LR',0,'L');
$pdf->Ln();
$pdf->Cell(111,5,"Zranìná èást tìla:",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(40,5,$data[$poradi++],'LR',0,'C');
$pdf->Cell(40,5,$data[$poradi++],'LR',0,'C');
$pdf->Ln();
$pdf->Cell(111,5,$data[$poradi++],'LBR',0,'L');
$pdf->Cell(40,5,"",'LBR',0,'L');
$pdf->Cell(40,5,"",'LBR',0,'L');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);$pdf->Cell(131,5,"Druh úrazu:",'LTR',0,'L');
$pdf->Cell(60,5,"Záznam o úrazu sepsán dne:",'LTR',0,'L');
$pdf->Ln();

$pdf->SetFont('tahoma','',10);
$text=$data[$poradi++];if ($text==1) {$dodat="          X  ";} else {$dodat="              ";}
$pdf->Cell(131,5,$dodat."Smrtelný",'LR',0,'L');
$pdf->Cell(60,5,"",'LR',0,'C');
$pdf->Ln();
if ($text==2) {$dodat="          X  ";} else {$dodat="              ";}
$pdf->Cell(131,5,$dodat."S pracovní neschopností delší než 3 kalenáøní dny",'LR',0,'L');
$pdf->SetFont('tahoma','',16);$pdf->Cell(60,5,$data[$poradi++],'LR',0,'C');
$pdf->SetFont('tahoma','',10);$pdf->Ln();
if ($text==3) {$dodat="          X  ";} else {$dodat="              ";}
$pdf->Cell(131,5,$dodat."S hospitalizací pøesahující 5 dnù",'LR',0,'L');
$pdf->Cell(60,5,"",'LR',0,'C');
$pdf->Ln();
if ($text==4) {$dodat="          X  ";} else {$dodat="              ";}
$pdf->Cell(131,5,$dodat."S pracovní neschopností kratší než 3 kalenáøní dny",'LR',0,'L');
$pdf->Cell(60,5,"",'LR',0,'C');
$pdf->Ln();
if ($text==5) {$dodat="          X  ";} else {$dodat="              ";}
$pdf->Cell(131,5,$dodat."Bez pracovní neschopnosti",'LBR',0,'L');
$pdf->Cell(60,5,"",'LBR',0,'C');
$pdf->Ln();

$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<6):
if (@$cykl==0) {$pdf->Cell(191,5,"Popis úrazového dìje:  ".$vypis[$cykl],'LR',0,'L');}
if (@$cykl>0 and @$cykl<5) {$pdf->Cell(191,5,$vypis[$cykl],'LR',0,'L');}
if (@$cykl==5) {$pdf->Cell(191,5,$vypis[$cykl],'LBR',0,'L');}
$pdf->Ln();
@$cykl++;endwhile;


$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"Proè k úrazu došlo? (pøíèíny):",'LTR',0,'L');
$pdf->Cell(110,5,"Co bylo zdrojem úrazu?",'LTR',0,'L');
$pdf->Ln();
$pdf->SetFont('tahoma','',10);$pdf->Cell(81,5,$data[$poradi++],'LBR',0,'L');
$pdf->Cell(110,5,$data[$poradi++],'LBR',0,'L');
$pdf->Ln();

$pdf->Cell(191,5,"Byla u úrazem postiženého zamìstnance zjištìna pøítomnost alkoholu (jiných návykových látek)?           ".$data[$poradi++],'LBRT',0,'L');
$pdf->Ln();

$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<3):
if (@$cykl==0) {$pdf->Cell(191,5,"Jaké pøedpisy byly v souvislosti s poranìním porušeny a kým?  ".$vypis[$cykl],'LR',0,'L');}
if (@$cykl>0 and @$cykl<2) {$pdf->Cell(191,5,$vypis[$cykl],'LR',0,'L');}
if (@$cykl==2) {$pdf->Cell(191,5,$vypis[$cykl],'LBR',0,'L');}
$pdf->Ln();
@$cykl++;endwhile;

$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"Úrazem postižený zamìstnanec:",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LBR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(110,5,"(datum, jméno, podpis)",'LBR',0,'C');
$pdf->Ln();

$pdf->Cell(81,5,"Svìdci úrazu:",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(110,5,"(datum, jméno, podpis)",'LBR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(110,5,"(datum, jméno, podpis)",'LBR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LBR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(110,5,"(datum, jméno, podpis)",'LBR',0,'C');
$pdf->Ln();

$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"Zástupce odborové organizace",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"(zástupce zamìstnancù pro BOZP):",'LBR',0,'L');
$pdf->Cell(110,5,"(datum, jméno, podpis)",'LBR',0,'C');
$pdf->Ln();

$pdf->Cell(81,5,"Jméno a pracovní zaøazení toho, kdo údaje",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"zaznamenal:",'LBR',0,'L');
$pdf->Cell(110,5,"(datum, jméno, podpis)",'LBR',0,'C');
$pdf->Ln();

$pdf->SetFont('tahoma','',10);
$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<3):
if (@$cykl==0) {$pdf->Cell(191,5,"Poznámka:   ".$vypis[$cykl],'LR',0,'L');}
if (@$cykl>0 and @$cykl<2) {$pdf->Cell(191,5,$vypis[$cykl],'LR',0,'L');}
if (@$cykl==2) {$pdf->Cell(191,5,$vypis[$cykl],'LBR',0,'L');}
$pdf->Ln();
@$cykl++;endwhile;


$pdf->Cell(191,10,"_____________________________",'',0,'L');
$pdf->Ln(8);

$pdf->SetFont('tahomai','',5);$pdf->Cell(2,3,"1",'');
$pdf->SetFont('tahomai','',10);$pdf->Cell(189,5,"Zamìstnavatel vede v knize úrazù evidenci o všech úrazech, i když jimi nebyla zpùsobena pracovní neschopnost nebo",'',0,'L');
$pdf->Ln();
$pdf->Cell(191,5,"byla zpùsobena pracovní neschopnost nepøesahující 3 kalendáøní dny.",'',0,'L');

$pdf->Output();





