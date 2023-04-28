<?php
include ("./"."dbconnect.php");
@$prev_id=base64_decode(@$_GET["prev_id"]);

$data1=mysql_query("select * from kniha_urazu where prev_id='".mysql_real_escape_string($prev_id)."' ");
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
$pdf->SetFont('tahomab','',14);$pdf->Cell(191,5,"ZÁZNAM O ÚRAZU - HLÁŠENÍ ZMÌN",'',0,'C');
$pdf->Ln(15);

$pdf->SetFont('tahomai','',10);
$pdf->Cell(110,5,"",'',0,'R');$pdf->Cell(40,5,"Evidenèní èíslo záznamu ",'LBT',0,'R');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"a)",'T');$pdf->SetFont('tahomab','',10);$pdf->Cell(36,5,": ".$data[($poradi++)],'BTR',0,'L');$pdf->Ln(5);$pdf->SetFont('tahomai','',10);
$pdf->Cell(110,5,"",'',0,'R');$pdf->Cell(50,5,"Evidenèní èíslo zamìstnavatele ",'LBT',0,'R');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"b)",'T');$pdf->SetFont('tahomab','',10);$pdf->Cell(26,5,": ".$data[($poradi++)],'BTR',0,'L');$pdf->Ln(5);
$pdf->Cell(160,5,"",'',0,'R');$pdf->Cell(31,5,"",'T',0,'R');$pdf->Ln(5);

$pdf->SetFont('tahomab','',10);
$pdf->Cell(191,5,"   Údaje o zamìstnavateli, který záznam o úrazu odeslal:",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);
$pdf->Cell(95,5," Název zamìstnavatele:",'LTR',0,'L');$pdf->Cell(10,5," IÈO: ",'LT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(86,5,$data[($poradi+1)],'TR',0,'L');$pdf->Ln(5);

$pdf->Cell(95,5," ".$data[($poradi++)],'LR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," Adresa:",'LTR',0,'L');$pdf->Ln(5);$poradi++;
$pdf->Cell(95,5," ",'LBR',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5," ".$data[($poradi++)],'LBR',0,'L');$pdf->Ln(15);


$pdf->SetFont('tahomab','',10);
$pdf->Cell(191,5,"   Údaje o úrazem postiženém zamìstnanci a o úrazu:",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(15,5," Jméno:",'LTB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(80,5," ".$data[($poradi++)],'TBR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(20,5," Datum úrazu:",'LTB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(76,5," ".$data[($poradi++)],'TBR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(25,5," Datum narození:",'LT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(70,5," ".$data[($poradi++)],'TR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," Místo kde k úrazu došlo:",'LTR',0,'L');$pdf->Ln(5);
$pdf->Cell(95,5,"",'LBR',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5," ".$data[($poradi++)],'LBR',0,'L');$pdf->Ln(15);


$pdf->SetFont('tahomai','',10);
$pdf->Cell(191,5,"   Hospitalizace úrazem postiženého zamìstnance pøesáhla 5 kalendáøních dnù:",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);
$pdf->Cell(191,5,$data[($poradi++)],'LBR',0,'C');$pdf->Ln(15);

$pdf->SetFont('tahomai','',10);
$pdf->Cell(191,5,"   C 8 - Trvání doèasné pracovní neschopnosti následkem úrazu",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(10,5," od:",'LB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(54,5,$data[($poradi++)],'B',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(10,5," do:",'B',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(54,5,$data[($poradi++)],'B',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(40,5," celkem kalendáøních dnù:",'B',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(23,5,$data[($poradi++)],'BR',0,'L');
$pdf->Ln(15);

$pdf->SetFont('tahomai','',10);
$pdf->Cell(130,5,"   D 1 - Úrazem postižený zamìstnanec na následky poškození zdraví pøi úrazu zemøel dne:",'LBT',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(61,5,$data[($poradi++)],'BTR',0,'L');$pdf->Ln(15);

$pdf->SetFont('tahomai','',10);
$pdf->Cell(191,5,"   Jiné zmìny:",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);
$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<14 ):
$pdf->Cell(191,5," ".$vypis[$cykl],'LR',0,'L');$pdf->Ln(5);
@$cykl++;endwhile;
$pdf->Cell(191,5,"",'T',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"Úrazem postižený zamìstnanec:",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln();
$pdf->Cell(81,5,"",'LBR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(110,5,"(datum, jméno, podpis)",'LBR',0,'C');
$pdf->Ln();

$pdf->Cell(81,5,"Jméno a pracovní zaøazení toho, kdo údaje",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"zaznamenal:",'LBR',0,'L');
$pdf->Cell(110,5,"(datum, jméno, podpis)",'LBR',0,'C');
$pdf->Ln(10);

$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"a) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Vyplní orgán inspekce práce, popøípadì orgán báòské správy.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"b) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Vyplní zamìstnavatel.",'',0,'L');$pdf->Ln(5);




$pdf->Output();





