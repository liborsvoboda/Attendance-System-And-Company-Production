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
$pdf->SetFont('tahomab','',14);$pdf->Cell(191,5,"Z�ZNAM O �RAZU",'',0,'C');
$pdf->Ln();
if ($data[($poradi)]=="1") {$priznak1="X";} else {{$priznak1=" ";}}
if ($data[($poradi)]=="3") {$priznak2="X";} else {{$priznak2=" ";}}
if ($data[($poradi++)]=="5") {$priznak3="X";} else {{$priznak3=" ";}}

$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak1,'LBTR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(90,5,"    smrteln�m",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak2,'LBTR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(90,5,"    s hospitalizac� del�� ne� 5 dn�",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak3,'LBTR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(90,5,"    ostatn�m",'',0,'L');$pdf->Ln(5);

$pdf->Cell(110,5,"",'',0,'R');$pdf->Cell(40,5,"Eviden�n� ��slo z�znamu ",'LBT',0,'R');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"a)",'T');$pdf->SetFont('tahomab','',10);$pdf->Cell(36,5,": ".$data[($poradi++)],'BTR',0,'L');$pdf->Ln(5);$pdf->SetFont('tahomai','',10);
$pdf->Cell(110,5,"",'',0,'R');$pdf->Cell(50,5,"Eviden�n� ��slo zam�stnavatele ",'LBT',0,'R');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"b)",'T');$pdf->SetFont('tahomab','',10);$pdf->Cell(26,5,": ".$data[($poradi++)],'BTR',0,'L');$pdf->Ln(5);
$pdf->Cell(160,5,"",'',0,'R');$pdf->Cell(31,5,"",'T',0,'R');$pdf->Ln(5);

$pdf->Cell(191,5,"   A. �daje o zam�stnavateli, u kter�ho je �razem posti�en� zam�stnanec v z�kladn�m pracovn�pr�vn�m vztahu",'',0,'L');$pdf->Ln(5);
$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(15,5," 1. I�O:",'LT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(80,5,$data[($poradi++)],'TR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," 2. P�edm�t podnik�n� (CZ-NACE), v jeho� r�mci k �razu do�lo:",'LTR',0,'L');$pdf->Ln(5);
$pdf->Cell(95,5," N�zev zam�stnavatele a jeho s�dlo (adresa):",'LR',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5," ".$data[($poradi+1)],'LR',0,'L');$pdf->Ln(5);

$vypis=explode ("
",$data[$poradi++]);
$vypis1=explode ("
",$data[($poradi+1)]);
@$cykl=0;while(@$cykl<7 ):if (@$cykl==0) {$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(43,5," 3. M�sto, kde k �razu do�lo",'LT',0,'L');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"c)",'T');$pdf->SetFont('tahomai','',10);$pdf->Cell(48,5,":",'TR',0,'L');$pdf->Ln();}


if (@$cykl>0 and @$cykl<4) {$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->Cell(96,5," ".$vypis1[($cykl-1)],'LR',0,'L');$pdf->Ln(5);}
if (@$cykl==4) {$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->Cell(96,5," 4. Bylo m�sto �razu pravideln�m pracovi�t�m",'LTR',0,'L');$pdf->Ln(5);}
if (@$cykl==5) {$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->Cell(96,5," �razem posti�en�ho zam�stnance?",'LR',0,'L');$pdf->Ln(5);}
if (@$cykl==6) {$poradi++;$poradi++;$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5," ".$vypis[$cykl],'LBR',0,'L');$pdf->Cell(96,5," ".$data[($poradi++)],'LBR',0,'C');$pdf->Ln(5);}
@$cykl++;endwhile;

$pdf->Ln(5);
$pdf->Cell(80,5,"   B. �daje o zam�stnavateli, u kter�ho k �razu do�lo ",'',0,'L');$pdf->SetFont('tahoma','',10);$pdf->Cell(91,5,"(pokud se nejedn� o zam�stnavatele uveden�ho v ��sti A z�znamu):",'',0,'L');$pdf->Ln(5);
$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(15,5," 1. I�O:",'LT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(80,5,$data[($poradi++)],'TR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," 2. P�edm�t podnik�n� (CZ-NACE), v jeho� r�mci k �razu do�lo:",'LTR',0,'L');$pdf->Ln(5);
$pdf->Cell(95,5," N�zev zam�stnavatele a jeho s�dlo (adresa):",'LR',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5," ".$data[($poradi+1)],'LR',0,'L');$pdf->Ln(5);
$vypis=explode ("
",$data[$poradi++]);
$vypis1=explode ("
",$data[($poradi+1)]);
@$cykl=0;while(@$cykl<4 ):if (@$cykl==0) {$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(43,5," 3. M�sto, kde k �razu do�lo",'LT',0,'L');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"c)",'T');$pdf->SetFont('tahomai','',10);$pdf->Cell(48,5,":",'TR',0,'L');$pdf->Ln();}
if (@$cykl>0 and @$cykl<4) {$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5," ".$vypis[$cykl],'LR',0,'L');$pdf->Cell(96,5," ".$vypis1[($cykl-1)],'LR',0,'L');$pdf->Ln(5);}
@$cykl++;endwhile;

$pdf->Cell(191,5,"",'T',0,'C');$pdf->Ln(5);
$pdf->Cell(191,5,"   C. �daje o �razem posti�en�m zam�stnanci ",'',0,'L');$pdf->Ln(5);
$pdf->Ln(5);
$poradi++;$poradi++;
$pdf->SetFont('tahomai','',10);$pdf->Cell(15,5," 1. Jm�no:",'LTB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(80,5,$data[($poradi++)],'TRB',0,'L');$poradi++;
$pdf->SetFont('tahomai','',10);$pdf->Cell(15,5," Pohlav�:",'LBT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(81,5,$data[($poradi++)],'TRB',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(30,5," 2. Datum narozen�:",'LTB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(65,5,$data[($poradi++)],'TRB',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(30,5," 3. St�tn� Ob�anstv�:",'LBT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(66,5,$data[($poradi++)],'TRB',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," 4. Druh pr�ce (CZ-ISCO):",'LT',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(51,5," 5. �innost, p�i kter� k �razu do�lo",'LT',0,'L');$pdf->SetFont('tahomai','',6);$pdf->Cell(5,3,"d)",'T');$pdf->SetFont('tahomab','',10);$pdf->Cell(40,5,": ",'TR',0,'L');$pdf->Ln(5);

$vypis=explode ("
",$data[$poradi++]);
$vypis1=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<3 ):
$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5,$vypis[$cykl],'LR',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5,$vypis1[$cykl],'LR',0,'L');
$pdf->Ln(5);
@$cykl++;endwhile;

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5," 6. D�lka trv�n� z�kladn�ho pracovn�pr�vn�ho vztahu u zam�stnavatele",'LTR',0,'L');$pdf->Ln(5);
$pdf->Cell(47,5,"      rok�:",'LB',0,'R');$pdf->SetFont('tahomab','',10);$pdf->Cell(48,5,$data[($poradi++)],'B',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(48,5,"      m�s�c�:",'B',0,'R');$pdf->SetFont('tahomab','',10);$pdf->Cell(48,5,$data[($poradi++)],'BR',0,'L');$pdf->Ln(5);


if ($data[($poradi)]=="1") {$priznak1="X";} else {{$priznak1=" ";}}
if ($data[($poradi)]=="2") {$priznak2="X";} else {{$priznak2=" ";}}
if ($data[($poradi)]=="3") {$priznak3="X";} else {{$priznak3=" ";}}
if ($data[($poradi++)]=="4") {$priznak4="X";} else {{$priznak4=" ";}}

$pdf->SetFont('tahomai','',10);$pdf->Cell(50,5," 7. �razem posti�en� je",'LT',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak1,'LBTR',0,'L');$pdf->Cell(136,5," zam�stnanec v pracovn�pr�vn�m pom�ru",'TR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(50,5,"",'L',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak2,'LTBR',0,'L');$pdf->Cell(136,5," zam�stnanec zam�stnan� na z�klad� dohod o prac�ch konan�ch mimo pracovn� pom�r",'R',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(50,5,"",'L',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak3,'LTBR',0,'L');$pdf->Cell(136,5," osoba vykon�vaj�c� �innost nebo poskytuj�c� slu�by mimo pracovn�pr�vn� vztahy",'R',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               (� 12 z�kona �. 309/2006 Sb.)",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(50,5,"",'L',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,$priznak4,'LTBR',0,'L');$pdf->Cell(136,5," zam�stnanec agentury pr�ce nebo do�asn� p�id�len� k v�konu pr�ce za ��elem",'R',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               prohlouben� kvalifikace u j�n� pr�vnick� nebo fyzick� osoby [� 38a z�kona �. 95/2004 Sb.,",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               o podm�nk�ch z�sk�v�n� a uzn�v�n� odborn� zp�sobilosti a specializovan� zp�sobilosti",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               k v�konu zdraotnick�ho povol�n� l�ka�e, zubn�ho l�ka�e a farmaceuta, ve zn�n�",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               pozd�j��ch p�edpis�, � 91a z�kona �. 96/2004 Sb., o podm�nk�ch z�sk�v�n� a uzn�v�n�",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               zp�sobilosti k v�konu nel�ka�sk�ch zdravotnick�ch povol�n� a k v�konu �innost�",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               souvisej�c�ch s poskytov�n�m zdravotn� p��e a o zm�n� n�kter�ch souvisej�c�ch z�kon�",'LR',0,'L');
$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5,"                                                               (z�kon o nel�ka�sk�ch zdravotnick�ch povol�n�ch), ve zn�n� pozd�j��ch p�edpis�].",'LBR',0,'L');
$pdf->Ln(5);


$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5," 8. Trv�n� do�asn� pracovn� neschopnosti n�sledkem �razu:",'LTR',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(10,5," od:",'LB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(50,5,$data[($poradi++)],'B',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(10,5,"do:",'B',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(50,5,$data[($poradi++)],'B',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(40,5,"celkem kalend��n�ch dn�:",'B',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(31,5,$data[($poradi++)],'BR',0,'L');
$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5,"Strana 1 (celkem 3)",'',0,'C');$pdf->Ln(5);


$pdf->Cell(191,5,"   D. �daje o �razu ",'',0,'L');$pdf->Ln(5);$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(25,5," 1. Datum �razu:",'LT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(70,5,$data[($poradi++)],'TR',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," 2. Po�et hodin odpracovan�ch bezprost�edn� p�ed vznikem �razu:",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(25,5,"    Hodina �razu:",'L',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(70,5,$data[($poradi++)],'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5,$data[($poradi+1)],'LR',0,'C');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5,"    Datum �mrt� �razem posti�en�ho zam�stnance:",'LR',0,'L');$pdf->Cell(96,5,"",'LR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5,$data[($poradi++)],'LBR',0,'C');$pdf->Cell(96,5,"",'LBR',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(25,5," 3. Druh zran�n�:",'LT',0,'L');$pdf->SetFont('tahomai','',7);$pdf->Cell(5,5,"e)",'T',0,'L');
$pdf->SetFont('tahomai','',10);$pdf->Cell(65,5,":",'T',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5," 4. Zran�n� ��st t�la:",'LR',0,'L');$pdf->Ln(5);
$poradi++;$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5,$data[($poradi++)],'LB',0,'L');$pdf->Cell(96,5,$data[($poradi++)],'LRB',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(56,5," 5. Po�et zran�n�ch osob celkem:",'LBT',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(135,5,$data[($poradi++)],'BTR',0,'L');$pdf->Ln(5);




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

$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," 6. Co bylo zdrojem �razu?",'LR',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(96,5,"",'LR',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak1,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," dopravn� prost�edek",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak6,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," pr�myslov� �kodliviny, chemick� l�tky, biologick� �initele",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak2,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," stroje a za��zen� p�enosn� nebo mobiln�",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak7,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," hork� l�tky a p�edm�ty, ohe� a v�bu�niny",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak3,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," materi�l, b�emena, p�edm�ty (p�d, p�ira�en�, odl�tnut�,",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak8,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," stroje a za��zen� stabiln�",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,"",'',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," n�raz, zavalen�)",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak9,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," lid�, zv��ata, nebo p��rodn� �ivly",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak4,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," p�d na rovin�, z v��ky, do hloubky, propadnut�",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak10,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," elektrick� energie",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak5,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," n�stroj, p��stroj, n��ad�",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak11,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," jin� bl�e nespecifikovan� zdroj",'R',0,'L');$pdf->Ln(5);
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

$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," 7. Pro� k �razu do�lo? (p���iny)",'LTR',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5,"",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak1,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," pro poruchu nebo vadn� stav n�kter�ho ze zdroj� �razu",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak5,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," pro poru�en� p�edpis� vztahuj�c�ch se k pr�ci nebo pokyn�",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak2,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," pro �patn� nebo nedostate�n� vyhodnocen� rizika",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(10,5,"",'L',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," zam�stnavatele",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak3,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," pro z�vady na pracovi�ti",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak6,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," pro nedp�edv�dateln� riziko pr�ce nebo selh�n� lidsk�ho",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak4,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," pro nedostate�n� osobn� zaji�t�n� zam�stnance v�etn� ",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(10,5,"",'L',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," �initele",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(10,5,"",'L',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(85,5," osobn�ch ochrann�ch pracovn�ch prost�edk�",'R',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(5,5,"",'L',0,'R');$pdf->Cell(5,5,$priznak7,'LBTR',0,'R');$pdf->SetFont('tahomai','',10);$pdf->Cell(86,5," pro jin�, bl�e nespecifikovan� d�vod ",'R',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomab','',10);$pdf->Cell(95,5,"",'LBR',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(81,5,"",'LB',0,'R');$pdf->SetFont('tahomai','',7);$pdf->Cell(5,5,"a)",'',0,'L');
$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Cell(5,5,"",'LBRT',0,'R');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(95,5," 8. Byla u �razem posti�en�ho zam�stnance zji�t�na p��tomnost",'LTR',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5,"",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(65,5," alkoholu nebo jin�ch n�vykov�ch l�tek?  ",'LB',0,'L');$pdf->SetFont('tahomab','',10);$pdf->Cell(30,5,$data[($poradi++)],'BR',0,'L');
$pdf->SetFont('tahomab','',10);$pdf->Cell(96,5,"",'LBR',0,'L');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5," 9. Popis �razov�ho d�je, rozveden� popisu m�sta, p���in a okolnost�, za nich� do�lo k �razu. (v P��pad� pot�eby p�ipojte dal�� list).",'LTR',0,'L');$pdf->Ln(5);

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


$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5," 10. Uve�te, jak� p�edpisy byly v souvislosti s �razem poru�eny a k�m, pokud bylo jejich poru�en� do doby odesl�n� z�znamu zji�t�no.",'LTR',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(55,5," (V p��pad� pot�eby p�ipojte dal�� list)",'L',0,'L');$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"f) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(133,5,".",'R',0,'L');$pdf->Ln(5);
$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<10 ):
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5," ".$vypis[@$cykl],'LR',0,'L');$pdf->Ln(5);
@$cykl++;endwhile;


$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5,"Strana 2 (celkem 3)",'T',0,'C');$pdf->Ln(5);

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5," 11. Opat�en� p�ijat� k zabr�n�n� opakov�n� pracovn�ho �razu",'LTR',0,'L');$pdf->Ln(5);
$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<10 ):
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5," ".$vypis[@$cykl],'LR',0,'L');$pdf->Ln(5);
@$cykl++;endwhile;

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5,"",'T',0,'C');$pdf->Ln(1);
$pdf->Cell(191,5,"   E. Vyj�d�en� �razem posti�en�ho zam�stnance a sv�dk� �razu",'',0,'L');$pdf->Ln(2);

$pdf->Cell(191,5,"",'B',0,'L');$pdf->Ln(5);
$vypis=explode ("
",$data[$poradi++]);
@$cykl=0;while(@$cykl<10 ):
$pdf->SetFont('tahomab','',10);$pdf->Cell(191,5," ".$vypis[@$cykl],'LR',0,'L');$pdf->Ln(5);
@$cykl++;endwhile;

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5,"",'T',0,'C');$pdf->Ln(5);

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
$pdf->Ln(5);

$pdf->Cell(81,5,"Jm�no a pracovn� za�azen� toho, kdo �daje",'LTR',0,'L');
$pdf->SetFont('tahoma','',10);$pdf->Cell(110,5,$data[$poradi++],'LTR',0,'C');
$pdf->Ln(5);
$pdf->SetFont('tahomai','',10);$pdf->Cell(81,5,"zaznamenal:",'LBR',0,'L');
$pdf->Cell(110,5,"(datum, jm�no, podpis)",'LBR',0,'C');
$pdf->Ln(10);


$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"a) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Vypln� org�n inspekce pr�ce, pop��pad� org�n b��sk� spr�vy.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"b) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Vypln� zam�stnavatel.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"c) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Uvede se typ pracovi�t�, pracovn� plochy nebo lokality, kde byl �razem posti�en� zam�stnanec p��tomen nebo pracoval t�sn�",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    p�ed �razem, a kde do�lo k �razu, nap��klad pr�myslov� plocha, stavebn� plocha, zem�d�lsk� nebo lesn� plocha, zdravotnick�",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    za��zen�, terci�ln� sf�ra - ��ad.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"d) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," �innost� se rozum� hlavn� typ pr�ce s ur�itou d�lkou trv�n�, kterou �razem posti�en� zam�stnanec vykon�val v �ase, kdy",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    k �razu do�lo, nap��klad sva�ov�n� plamenem. Nejedn� se o konkr�tn� �kon, nap��klad zap�len� ho��ku p�i sva�ov�n� plamenem.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"e) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Uvede se n�sledek zran�n�, nap��klad zlomenina, �ezn� poran�n�, traumatick� amputace, pohmo�d�n�, pop�len�, otrava, utonut�.",'',0,'L');$pdf->Ln(5);
$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"f) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," Poru�en� p�edpis� se t�k� jak p�edpis� pr�vn�ch, tak i ostatn�ch a konkr�tn�ch pokyn� k zaji�t�n� bezpe�nosti a ochrany zdrav�",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    p�i pr�ci, dan�ch zam�stnanci vedouc�mi zam�stnanci, kte�� jsou mu nad��zeni ve smyslu � 349 odst. 1 a 2 z�kon�ku pr�ce. P�edpisy",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    se rozum� p�edpisy na ochranu �ivota a zdrav�, p�edpisy hygienick� a protiepidemick�, technick� p�edpisy, technick� dokumenty ",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    a technick� normy, stavebn� p�edpisy, dopravn� p�edpisy, p�edpisy o po��rn� ochran� a p�edpisy o zach�zen� s ho�lavinami",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    , v�bu�ninami, zbran�mi, radioaktivn�mi l�tkami, chemick�mi l�tkami a chemick�mi p��pravky a jin�mi l�tkami �kodliv�mi zdrav�,",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5,"    , pokud upravuj� ot�zky t�kaj�c� se ochrany �ivota a zdrav�.",'',0,'L');$pdf->Ln(5);


$pdf->SetFont('tahomai','',7);$pdf->Cell(3,3,"g) ",'',0,'L');$pdf->SetFont('tahomai','',10);$pdf->Cell(186,5," V p��pad�, �e n�kter� z osob, kter� z�znam o �razu podepisuj�, chce podat vyj�d�en�, u�in� tak na zvl�tn�m list�, kter� se",'',0,'L');$pdf->Ln(5);
$pdf->Cell(191,5," k z�znamu o �razu p�ipoj�.",'',0,'L');$pdf->Ln(8);

$pdf->SetFont('tahomai','',10);$pdf->Cell(191,5,"Strana 3 (celkem 3)",'',0,'C');

$pdf->Output();





