<?php
include ("./"."dbconnect.php");
@$prev_id=base64_decode(@$_GET["prev_id"]);

$data1=mysql_query("select * from kniha_urazu where prev_id='".mysql_real_escape_string($prev_id)."' ");
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
$pdf->SetFont('tahomab','',14);$pdf->Cell(191,5,"Z�ZNAM O �RAZU - HL��EN� ZM�N",'',0,'C');
$pdf->Ln(15);

$pdf->SetFont('tahomai','',10);
$pdf->Cell(110,5,"",'',0,'R');$pdf->Cell(40,5,"Eviden�n� ��slo z�znamu ",'LBT',0,'R');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"a)",'T');$pdf->SetFont('tahomab','',10);$pdf->Cell(36,5,": ".$data[($poradi++)],'BTR',0,'L');$pdf->Ln(5);$pdf->SetFont('tahomai','',10);
$pdf->Cell(110,5,"",'',0,'R');$pdf->Cell(50,5,"Eviden�n� ��slo zam�stnavatele ",'LBT',0,'R');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"b)",'T');$pdf->SetFont('tahomab','',10);$pdf->Cell(26,5,": ".$data[($poradi++)],'BTR',0,'L');$pdf->Ln(5);
$pdf->Cell(160,5,"",'',0,'R');$pdf->Cell(31,5,"",'T',0,'R');$pdf->Ln(5);

$pdf->SetFont('tahomab','',10);
$pdf->Cell(191,5,"   �daje o zam�stnavateli, kter� z�znam o �razu odeslal:",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);
$pdf->Cell(95,5," N�zev zam�stnavatele:",'LTR',0,'L');$pdf->Cell(10,5," I�O: ",'LT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(86,5,$data[($poradi+1)],'TR',0,'L');$pdf->Ln(5);

$pdf->Cell(95,5," ".$data[($poradi++)],'LR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," Adresa:",'LTR',0,'L');$pdf->Ln(5);$poradi++;
$pdf->Cell(95,5," ",'LBR',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5," ".$data[($poradi++)],'LBR',0,'L');$pdf->Ln(15);


$pdf->SetFont('tahomab','',10);
$pdf->Cell(191,5,"   �daje o �razem posti�en�m zam�stnanci a o �razu:",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(15,5," Jm�no:",'LTB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(80,5," ".$data[($poradi++)],'TBR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(20,5," Datum �razu:",'LTB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(76,5," ".$data[($poradi++)],'TBR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(25,5," Datum narozen�:",'LT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(70,5," ".$data[($poradi++)],'TR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," M�sto kde k �razu do�lo:",'LTR',0,'L');$pdf->Ln(5);
$pdf->Cell(95,5,"",'LBR',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5," ".$data[($poradi++)],'LBR',0,'L');$pdf->Ln(15);


$pdf->SetFont('tahomai','',10);
$pdf->Cell(191,5,"   Hospitalizace �razem posti�en�ho zam�stnance p�es�hla 5 kalend��n�ch dn�:",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);
$pdf->Cell(191,5,$data[($poradi++)],'LBR',0,'C');$pdf->Ln(15);

$pdf->SetFont('tahomai','',10);
$pdf->Cell(191,5,"   C 8 - Trv�n� do�asn� pracovn� neschopnosti n�sledkem �razu",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(10,5," od:",'LB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(54,5,$data[($poradi++)],'B',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(10,5," do:",'B',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(54,5,$data[($poradi++)],'B',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(40,5," celkem kalend��n�ch dn�:",'B',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(23,5,$data[($poradi++)],'BR',0,'L');
$pdf->Ln(15);

$pdf->SetFont('tahomai','',10);
$pdf->Cell(130,5,"   D 1 - �razem posti�en� zam�stnanec na n�sledky po�kozen� zdrav� p�i �razu zem�el dne:",'LBT',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(61,5,$data[($poradi++)],'BTR',0,'L');$pdf->Ln(15);

$pdf->SetFont('tahomai','',10);
$pdf->Cell(191,5,"   Jin� zm�ny:",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);
$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<14 ):
$pdf->Cell(191,5," ".$vypis[$cykl],'LR',0,'L');$pdf->Ln(5);
@$cykl++;endwhile;
$pdf->Cell(191,5,"",'T',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"�razem posti�en� zam�stnanec:",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LBR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(110,5,"(datum, jm�no, podpis)",'LBR',0,'C');
$pdf->Ln();

$pdf->Cell(81,5,"Jm�no a pracovn� za�azen� toho, kdo �daje",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"zaznamenal:",'LBR',0,'L');
$pdf->Cell(110,5,"(datum, jm�no, podpis)",'LBR',0,'C');
$pdf->Ln(10);

$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"a) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Vypln� org�n inspekce pr�ce, pop��pad� org�n b��sk� spr�vy.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"b) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Vypln� zam�stnavatel.",'',0,'L');$pdf->Ln(5);




$pdf->Output();





