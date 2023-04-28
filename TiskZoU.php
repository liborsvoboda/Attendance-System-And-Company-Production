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
$pdf->SetFont('tahomab','',14);$pdf->Cell(191,5,"ZÁZNAM O ÚRAZU",'',0,'C');
$pdf->Ln();
if ($data[($poradi)]=="1") {$priznak1="X";} else {{$priznak1=" ";}}
if ($data[($poradi)]=="3") {$priznak2="X";} else {{$priznak2=" ";}}
if ($data[($poradi++)]=="5") {$priznak3="X";} else {{$priznak3=" ";}}

$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak1,'LBTR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(90,5,"    smrtelném",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak2,'LBTR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(90,5,"    s hospitalizací delší než 5 dnù",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak3,'LBTR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(90,5,"    ostatním",'',0,'L');$pdf->Ln(5);

$pdf->Cell(110,5,"",'',0,'R');$pdf->Cell(40,5,"Evidenèní èíslo záznamu ",'LBT',0,'R');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"a)",'T');$pdf->SetFont('tahomab','',10);$pdf->Cell(36,5,": ".$data[($poradi++)],'BTR',0,'L');$pdf->Ln(5);$pdf->SetFont('tahomai','',10);
$pdf->Cell(110,5,"",'',0,'R');$pdf->Cell(50,5,"Evidenèní èíslo zamìstnavatele ",'LBT',0,'R');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"b)",'T');$pdf->SetFont('tahomab','',10);$pdf->Cell(26,5,": ".$data[($poradi++)],'BTR',0,'L');$pdf->Ln(5);
$pdf->Cell(160,5,"",'',0,'R');$pdf->Cell(31,5,"",'T',0,'R');$pdf->Ln(5);

$pdf->Cell(191,5,"   A. Údaje o zamìstnavateli, u kterého je úrazem postižený zamìstnanec v základním pracovnìprávním vztahu",'',0,'L');$pdf->Ln(5);
$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(15,5," 1. IÈO:",'LT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(80,5,$data[($poradi++)],'TR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," 2. Pøedmìt podnikání (CZ-NACE), v jehož rámci k úrazu došlo:",'LTR',0,'L');$pdf->Ln(5);
$pdf->Cell(95,5," Název zamìstnavatele a jeho sídlo (adresa):",'LR',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5," ".$data[($poradi+1)],'LR',0,'L');$pdf->Ln(5);

$vypis=explode ("
",$data[$poradi++]);
$vypis1=explode ("
",$data[($poradi+1)]);
@$cykl=0;while(@$cykl<7 ):if (@$cykl==0) {$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(43,5," 3. Místo, kde k úrazu došlo",'LT',0,'L');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"c)",'T');$pdf->SetFont('tahomai','',10);$pdf->Cell(48,5,":",'TR',0,'L');$pdf->Ln();}


if (@$cykl>0 and @$cykl<4) {$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->Cell(96,5," ".$vypis1[($cykl-1)],'LR',0,'L');$pdf->Ln(5);}
if (@$cykl==4) {$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->Cell(96,5," 4. Bylo místo úrazu pravidelným pracovištìm",'LTR',0,'L');$pdf->Ln(5);}
if (@$cykl==5) {$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->Cell(96,5," úrazem postiženého zamìstnance?",'LR',0,'L');$pdf->Ln(5);}
if (@$cykl==6) {$poradi++;$poradi++;$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5," ".$vypis[$cykl],'LBR',0,'L');$pdf->Cell(96,5," ".$data[($poradi++)],'LBR',0,'C');$pdf->Ln(5);}
@$cykl++;endwhile;

$pdf->Ln(5);
$pdf->Cell(80,5,"   B. Údaje o zamìstnavateli, u kterého k úrazu došlo ",'',0,'L');$pdf->SetFont('tahoma','',10);$pdf->Cell(91,5,"(pokud se nejedná o zamìstnavatele uvedeného v èásti A záznamu):",'',0,'L');$pdf->Ln(5);
$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(15,5," 1. IÈO:",'LT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(80,5,$data[($poradi++)],'TR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," 2. Pøedmìt podnikání (CZ-NACE), v jehož rámci k úrazu došlo:",'LTR',0,'L');$pdf->Ln(5);
$pdf->Cell(95,5," Název zamìstnavatele a jeho sídlo (adresa):",'LR',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5," ".$data[($poradi+1)],'LR',0,'L');$pdf->Ln(5);
$vypis=explode ("
",$data[$poradi++]);
$vypis1=explode ("
",$data[($poradi+1)]);
@$cykl=0;while(@$cykl<4 ):if (@$cykl==0) {$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(43,5," 3. Místo, kde k úrazu došlo",'LT',0,'L');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"c)",'T');$pdf->SetFont('tahomai','',10);$pdf->Cell(48,5,":",'TR',0,'L');$pdf->Ln();}
if (@$cykl>0 and @$cykl<4) {$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->Cell(96,5," ".$vypis1[($cykl-1)],'LR',0,'L');$pdf->Ln(5);}
@$cykl++;endwhile;

$pdf->Cell(191,5,"",'T',0,'C');$pdf->Ln(5);
$pdf->Cell(191,5,"   C. Údaje o úrazem postiženém zamìstnanci ",'',0,'L');$pdf->Ln(5);
$pdf->Ln(5);
$poradi++;$poradi++;
$pdf->SetFont('tahomai','',10);$pdf->Cell(15,5," 1. Jméno:",'LTB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(80,5,$data[($poradi++)],'TRB',0,'L');$poradi++;
$pdf->SetFont('tahomai','',10);$pdf->Cell(15,5," Pohlaví:",'LBT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(81,5,$data[($poradi++)],'TRB',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(30,5," 2. Datum narození:",'LTB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(65,5,$data[($poradi++)],'TRB',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(30,5," 3. Státní Obèanství:",'LBT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(66,5,$data[($poradi++)],'TRB',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," 4. Druh práce (CZ-ISCO):",'LT',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(51,5," 5. Èinnost, pøi které k úrazu došlo",'LT',0,'L');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"d)",'T');$pdf->SetFont('tahomab','',10);$pdf->Cell(40,5,": ",'TR',0,'L');$pdf->Ln(5);

$vypis=explode ("
",$data[$poradi++]);
$vypis1=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<3 ):
$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5,$vypis[$cykl],'LR',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5,$vypis1[$cykl],'LR',0,'L');
$pdf->Ln(5);
@$cykl++;endwhile;

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5," 6. Délka trvání základního pracovnìprávního vztahu u zamìstnavatele",'LTR',0,'L');$pdf->Ln(5);
$pdf->Cell(47,5,"      rokù:",'LB',0,'R');$pdf->SetFont('tahomab','',10);$pdf->Cell(48,5,$data[($poradi++)],'B',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(48,5,"      mìsícù:",'B',0,'R');$pdf->SetFont('tahomab','',10);$pdf->Cell(48,5,$data[($poradi++)],'BR',0,'L');$pdf->Ln(5);


if ($data[($poradi)]=="1") {$priznak1="X";} else {{$priznak1=" ";}}
if ($data[($poradi)]=="2") {$priznak2="X";} else {{$priznak2=" ";}}
if ($data[($poradi)]=="3") {$priznak3="X";} else {{$priznak3=" ";}}
if ($data[($poradi++)]=="4") {$priznak4="X";} else {{$priznak4=" ";}}

$pdf->SetFont('tahomai','',10);$pdf->Cell(50,5," 7. Úrazem postižený je",'LT',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak1,'LBTR',0,'L');$pdf->Cell(136,5," zamìstnanec v pracovnìprávním pomìru",'TR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(50,5,"",'L',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak2,'LTBR',0,'L');$pdf->Cell(136,5," zamìstnanec zamìstnaný na základì dohod o pracích konaných mimo pracovní pomìr",'R',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(50,5,"",'L',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak3,'LTBR',0,'L');$pdf->Cell(136,5," osoba vykonávající èinnost nebo poskytující služby mimo pracovnìprávní vztahy",'R',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               (§ 12 zákona è. 309/2006 Sb.)",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(50,5,"",'L',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak4,'LTBR',0,'L');$pdf->Cell(136,5," zamìstnanec agentury práce nebo doèasnì pøidìlený k výkonu práce za úèelem",'R',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               prohloubení kvalifikace u jíné právnické nebo fyzické osoby [§ 38a zákona è. 95/2004 Sb.,",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               o podmínkách získávání a uznávání odborné zpùsobilosti a specializované zpùsobilosti",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               k výkonu zdraotnického povolání lékaøe, zubního lékaøe a farmaceuta, ve znìní",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               pozdìjších pøedpisù, § 91a zákona è. 96/2004 Sb., o podmínkách získávání a uznávání",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               zpùsobilosti k výkonu nelékaøských zdravotnických povolání a k výkonu èinností",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               souvisejících s poskytováním zdravotní péèe a o zmìnì nìkterých souvisejících zákonù",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               (zákon o nelékaøských zdravotnických povoláních), ve znìní pozdìjších pøedpisù].",'LBR',0,'L');
$pdf->Ln(5);


$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5," 8. Trvání doèasné pracovní neschopnosti následkem úrazu:",'LTR',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(10,5," od:",'LB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(50,5,$data[($poradi++)],'B',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(10,5,"do:",'B',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(50,5,$data[($poradi++)],'B',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(40,5,"celkem kalendáøních dnù:",'B',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(31,5,$data[($poradi++)],'BR',0,'L');
$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5,"Strana 1 (celkem 3)",'',0,'C');$pdf->Ln(5);


$pdf->Cell(191,5,"   D. Údaje o úrazu ",'',0,'L');$pdf->Ln(5);$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(25,5," 1. Datum úrazu:",'LT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(70,5,$data[($poradi++)],'TR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," 2. Poèet hodin odpracovaných bezprostøednì pøed vznikem úrazu:",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(25,5,"    Hodina úrazu:",'L',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(70,5,$data[($poradi++)],'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5,$data[($poradi+1)],'LR',0,'C');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5,"    Datum úmrtí úrazem postiženého zamìstnance:",'LR',0,'L');$pdf->Cell(96,5,"",'LR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5,$data[($poradi++)],'LBR',0,'C');$pdf->Cell(96,5,"",'LBR',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(25,5," 3. Druh zranìní:",'LT',0,'L');$pdf->SetFont('tahomai','',7);$pdf->Cell(5,5,"e)",'T',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(65,5,":",'T',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," 4. Zranìná èást tìla:",'LR',0,'L');$pdf->Ln(5);
$poradi++;$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5,$data[($poradi++)],'LB',0,'L');$pdf->Cell(96,5,$data[($poradi++)],'LRB',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(56,5," 5. Poèet zranìných osob celkem:",'LBT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(135,5,$data[($poradi++)],'BTR',0,'L');$pdf->Ln(5);




if ($data[($poradi)]=="1") {$priznak1="X";} else {{$priznak1=" ";}}
if ($data[($poradi)]=="2") {$priznak2="X";} else {{$priznak2=" ";}}
if ($data[($poradi)]=="3") {$priznak3="X";} else {{$priznak3=" ";}}
if ($data[($poradi)]=="4") {$priznak4="X";} else {{$priznak4=" ";}}
if ($data[($poradi)]=="5") {$priznak5="X";} else {{$priznak5=" ";}}
if ($data[($poradi)]=="6") {$priznak6="X";} else {{$priznak6=" ";}}
if ($data[($poradi)]=="7") {$priznak7="X";} else {{$priznak7=" ";}}
if ($data[($poradi)]=="8") {$priznak8="X";} else {{$priznak8=" ";}}
if ($data[($poradi)]=="9") {$priznak9="X";} else {{$priznak9=" ";}}
if ($data[($poradi)]=="10") {$priznak10="X";} else {{$priznak10=" ";}}
if ($data[($poradi++)]=="11") {$priznak11="X";} else {{$priznak11=" ";}}

$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," 6. Co bylo zdrojem úrazu?",'LR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5,"",'LR',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak1,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," dopravní prostøedek",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak6,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," prùmyslové škodliviny, chemické látky, biologické èinitele",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak2,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," stroje a zaøízení pøenosná nebo mobilní",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak7,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," horké látky a pøedmìty, oheò a výbušniny",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak3,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," materiál, bøemena, pøedmìty (pád, pøiražení, odlétnutí,",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak8,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," stroje a zaøízení stabilní",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,"",'',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," náraz, zavalení)",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak9,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," lidé, zvíøata, nebo pøírodní živly",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak4,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," pád na rovinì, z výšky, do hloubky, propadnutí",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak10,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," elektrická energie",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak5,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," nástroj, pøístroj, náøadí",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak11,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," jiný blíže nespecifikovaný zdroj",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5,"",'L',0,'R');$pdf->Cell(96,5,"",'LR',0,'R');$pdf->Ln(5);

$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5,"",'LBR',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(71,5,"",'LB',0,'R');$pdf->SetFont('tahomai','',7);$pdf->Cell(5,5,"a)",'',0,'L');
$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Ln(5);


if ($data[($poradi)]=="1") {$priznak1="X";} else {{$priznak1=" ";}}
if ($data[($poradi)]=="2") {$priznak2="X";} else {{$priznak2=" ";}}
if ($data[($poradi)]=="3") {$priznak3="X";} else {{$priznak3=" ";}}
if ($data[($poradi)]=="4") {$priznak4="X";} else {{$priznak4=" ";}}
if ($data[($poradi)]=="5") {$priznak5="X";} else {{$priznak5=" ";}}
if ($data[($poradi)]=="6") {$priznak6="X";} else {{$priznak6=" ";}}
if ($data[($poradi++)]=="7") {$priznak7="X";} else {{$priznak7=" ";}}

$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," 7. Proè k úrazu došlo? (pøíèiny)",'LTR',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5,"",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak1,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," pro poruchu nebo vadný stav nìkterého ze zdrojù úrazu",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak5,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," pro porušení pøedpisù vztahujících se k práci nebo pokynù",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak2,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," pro špatné nebo nedostateèné vyhodnocení rizika",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(10,5,"",'L',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," zamìstnavatele",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak3,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," pro závady na pracovišti",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak6,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," pro nedpøedvídatelné riziko práce nebo selhání lidského",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak4,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," pro nedostateèné osobní zajištìní zamìstnance vèetnì ",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(10,5,"",'L',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," èinitele",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(10,5,"",'L',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," osobních ochranných pracovních prostøedkù",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak7,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," pro jiný, blíže nespecifikovaný dùvod ",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5,"",'LBR',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(81,5,"",'LB',0,'R');$pdf->SetFont('tahomai','',7);$pdf->Cell(5,5,"a)",'',0,'L');
$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," 8. Byla u úrazem postiženého zamìstnance zjištìna pøítomnost",'LTR',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5,"",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(65,5," alkoholu nebo jiných návykových látek?  ",'LB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(30,5,$data[($poradi++)],'BR',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5,"",'LBR',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5," 9. Popis úrazového dìje, rozvedení popisu místa, pøíèin a okolností, za nichž došlo k úrazu. (v Pøípadì potøeby pøipojte další list).",'LTR',0,'L');$pdf->Ln(5);

$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<10 ):
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5," ".$vypis[@$cykl],'LR',0,'L');$pdf->Ln(5);
@$cykl++;endwhile;

$pdf->Cell(6,5,"",'LT',0,'L');$pdf->SetFont('tahomai','',7);$pdf->Cell(160,3,"a) ",'TR',0,'R');
$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(166,5,"",'LR',0,'R');
$pdf->Cell(5,5,"",'LRT',0,'R');$pdf->Cell(5,5,"",'LRT',0,'R');$pdf->Cell(5,5,"",'LRT',0,'R');$pdf->Cell(5,5,"",'LRT',0,'R');$pdf->Cell(5,5,"",'LRT',0,'R');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(166,5,"",'LBR',0,'R');
$pdf->Cell(5,5,"",'LRB',0,'R');$pdf->Cell(5,5,"",'LRB',0,'R');$pdf->Cell(5,5,"",'LRB',0,'R');$pdf->Cell(5,5,"",'LRB',0,'R');$pdf->Cell(5,5,"",'LRB',0,'R');$pdf->Ln(5);


$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5," 10. Uveïte, jaké pøedpisy byly v souvislosti s úrazem porušeny a kým, pokud bylo jejich porušení do doby odeslání záznamu zjištìno.",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(55,5," (V pøípadì potøeby pøipojte další list)",'L',0,'L');$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"f) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(133,5,".",'R',0,'L');$pdf->Ln(5);
$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<10 ):
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5," ".$vypis[@$cykl],'LR',0,'L');$pdf->Ln(5);
@$cykl++;endwhile;


$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5,"Strana 2 (celkem 3)",'T',0,'C');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5," 11. Opatøení pøijatá k zabránìní opakování pracovního úrazu",'LTR',0,'L');$pdf->Ln(5);
$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<10 ):
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5," ".$vypis[@$cykl],'LR',0,'L');$pdf->Ln(5);
@$cykl++;endwhile;

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5,"",'T',0,'C');$pdf->Ln(1);
$pdf->Cell(191,5,"   E. Vyjádøení úrazem postiženého zamìstnance a svìdkù úrazu",'',0,'L');$pdf->Ln(2);

$pdf->Cell(191,5,"",'B',0,'L');$pdf->Ln(5);
$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<10 ):
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5," ".$vypis[@$cykl],'LR',0,'L');$pdf->Ln(5);
@$cykl++;endwhile;

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5,"",'T',0,'C');$pdf->Ln(5);

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
$pdf->Ln(5);

$pdf->Cell(81,5,"Jméno a pracovní zaøazení toho, kdo údaje",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"zaznamenal:",'LBR',0,'L');
$pdf->Cell(110,5,"(datum, jméno, podpis)",'LBR',0,'C');
$pdf->Ln(10);


$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"a) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Vyplní orgán inspekce práce, popøípadì orgán báòské správy.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"b) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Vyplní zamìstnavatel.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"c) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Uvede se typ pracovištì, pracovní plochy nebo lokality, kde byl úrazem postižený zamìstnanec pøítomen nebo pracoval tìsnì",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    pøed úrazem, a kde došlo k úrazu, napøíklad prùmyslová plocha, stavební plocha, zemìdìlská nebo lesní plocha, zdravotnická",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    zaøízení, terciální sféra - úøad.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"d) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Èinností se rozumí hlavní typ práce s urèitou délkou trvání, kterou úrazem postižený zamìstnanec vykonával v èase, kdy",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    k úrazu došlo, napøíklad svaøování plamenem. Nejedná se o konkrétní úkon, napøíklad zapálení hoøáku pøi svaøování plamenem.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"e) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Uvede se následek zranìní, napøíklad zlomenina, øezné poranìní, traumatická amputace, pohmoždìní, popálení, otrava, utonutí.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"f) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Porušení pøedpisù se týká jak pøedpisù právních, tak i ostatních a konkrétních pokynù k zajištìní bezpeènosti a ochrany zdraví",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    pøi práci, daných zamìstnanci vedoucími zamìstnanci, kteøí jsou mu nadøízeni ve smyslu § 349 odst. 1 a 2 zákoníku práce. Pøedpisy",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    se rozumí pøedpisy na ochranu života a zdraví, pøedpisy hygienické a protiepidemické, technické pøedpisy, technické dokumenty ",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    a technické normy, stavební pøedpisy, dopravní pøedpisy, pøedpisy o požární ochranì a pøedpisy o zacházení s hoølavinami",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    , výbušninami, zbranìmi, radioaktivními látkami, chemickými látkami a chemickými pøípravky a jinými látkami škodlivými zdraví,",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    , pokud upravují otázky týkající se ochrany života a zdraví.",'',0,'L');$pdf->Ln(5);


$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"g) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," V pøípadì, že nìkterá z osob, které záznam o úrazu podepisují, chce podat vyjádøení, uèiní tak na zvláštním listì, který se",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5," k záznamu o úrazu pøipojí.",'',0,'L');$pdf->Ln(8);

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5,"Strana 3 (celkem 3)",'',0,'C');

$pdf->Output();





