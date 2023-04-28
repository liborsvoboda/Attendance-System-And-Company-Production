<?php
@$stredisko=base64_decode(@$_GET["stredisko"]);
@$obdobi=base64_decode($_GET["obdobi"]);$obdobi1=explode("-",$obdobi);

@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");

//nacteni svatku
@$aktmesic="-".$obdobi1[1]."-";$aktobdobi=$obdobi."-";$aktobdobidate=$obdobi."-31";
$sdny1=mysql_query("select datum from svatky where ((datum like '%$aktmesic%' and typ='Trvalý' and stav='Aktivní') or (datum like '$aktobdobi%' and typ='Jedineèný' and stav='Aktivní') or (datum like '%$aktmesic%' and datumdo<='$aktobdobidate' and typ='Trvalý' and stav='Neaktivní')) order by datum");
@$load=0;$sden="/";while(@$load<mysql_num_rows($sdny1)): @$casti=explode ("-", mysql_result($sdny1,$load,0));$sden=$sden.(int)@$casti[2]."/";@$load++;endwhile;
//konec nacteni svatku

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
$pdf->SetFont('tahoma','',8);
$pdf->SetLineWidth(0.4);
$pdf->SetFillColor(200,200,200);

$pdf->Write(12,"Tisk Docházky Støediska: ".@$stredisko." za Období: ".$obdobi1[1].".".$obdobi1[0]."                                                                                                           Tisk Dne: ".date("d.n.Y"));$pdf->Ln(6);
$pdf->Write(7,$jmeno);$pdf->Ln(5);



// cely mesic uzivatele v poli a cisla operaci
$prichod= mysql_result(mysql_query("select cislo from klavesnice where text='Pøíchod'"),0,0);
$odchod1=mysql_query("select cislo from klavesnice where text like 'Odchod%'");@$cykl=0;while (@$cykl<mysql_num_rows($odchod1)):$odchod[@$cykl]= mysql_result($odchod1,$cykl,0);@$cykl++;endwhile;

@$osoby = mysql_query("select zamestnanci.osobni_cislo,zamestnanci.prijmeni,zamestnanci.jmeno,zamestnanci.titul from zamestnanci left outer join dochazka ON zamestnanci.osobni_cislo=dochazka.osobni_cislo where dochazka.stredisko='$stredisko' and dochazka.obdobi='$obdobi' group by zamestnanci.osobni_cislo order by zamestnanci.prijmeni,zamestnanci.jmeno,zamestnanci.id ") or Die(MySQL_Error());
@$osoba=0;while (@$osoba<mysql_num_rows(@$osoby)):

$zamestnanec=mysql_result(@$osoby,@$osoba,0);
@$vysledek = mysql_query("select * from dochazka where osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by osobni_cislo,cas,datum,id") or Die(MySQL_Error());

if (@$osoba>0) {$pdf->AddPage();}
$pdf->Cell(191,5,mysql_result(@$osoby,@$osoba,0)." / ".mysql_result(@$osoby,@$osoba,3)." ".mysql_result(@$osoby,@$osoba,2)." ".mysql_result(@$osoby,@$osoba,1),'');
$pdf->Ln();


// sumar

@$inform1 = mysql_query("select * from import_system where osobni_cislo='$zamestnanec' and obdobi='$obdobi'") or Die(MySQL_Error());
@$karta1 = mysql_query("select * from zamestnanci where osobni_cislo='$zamestnanec'") or Die(MySQL_Error());

@$pracdoba = explode(":", @mysql_result($karta1,0,20));@$prachod=@$pracdoba[0];@$pracmin=@$pracdoba[1];
@$pocetprdnimin=@mysql_result($inform1,0,9)*60;
$ppr=floor(@$pocetprdnimin/60);@$ppr1=@$pocetprdnimin-(@$ppr*60);if (@$ppr1<10) {@$ppr1="0".@$ppr1;}
@$pocetprdnitime=$ppr.":".$ppr1;

$nochod=0;$nocmin=0;@$noc1 = mysql_query("select id from ukony where nazev like '%noci%'") or Die(MySQL_Error());
$dotaznoc=" where ( ";
@$menza=0;while (@$menza<mysql_num_rows($noc1)):
$dotaznoc.=" id_ukonu='".mysql_result($noc1,$menza,0)."'"; if (mysql_result($noc1,$menza+1,0)<>"") {$dotaznoc.=" or ";} else {$dotaznoc.=" ) ";}
@$menza++;endwhile;
@$noc1 = mysql_query("select pracovni_doba from zpracovana_dochazka $dotaznoc and osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by id") or Die(MySQL_Error());
@$menza=0;while (@$menza<mysql_num_rows($noc1)):
@$nocni = explode(":", @mysql_result($noc1,@$menza,0));
$nochod=$nochod+@$nocni[0];$nocmin=$nocmin+@$nocni[1];
@$menza++;endwhile;
if (@$nocmin>=60) {$ppr=floor(@$nocmin/60);@$nochod=@$nochod+$ppr;@$nocmin=@$nocmin-(@$ppr*60);}if (@$nocmin<10) { if (@$nocmin<>0) {@$nocmin="0".@$nocmin;} else {@$nocmin="00";}}

$preshod=0;$presmin=0;@$prescas1 = mysql_query("select id from ukony where nazev like '%pøesèas%'") or Die(MySQL_Error());
$dotazprescas=" where ( ";
@$menza=0;while (@$menza<mysql_num_rows($prescas1)):
$dotazprescas.=" id_ukonu='".mysql_result($prescas1,$menza,0)."'"; if (mysql_result($prescas1,$menza+1,0)<>"") {$dotazprescas.=" or ";} else {$dotazprescas.=" ) ";}
@$menza++;endwhile;
@$prescas1 = mysql_query("select pracovni_doba from zpracovana_dochazka $dotazprescas and osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by id") or Die(MySQL_Error());
@$menza=0;while (@$menza<mysql_num_rows($prescas1)):
@$prescas = explode(":", @mysql_result($prescas1,@$menza,0));
$preshod=$preshod+@$prescas[0];$presmin=$presmin+@$prescas[1];
@$menza++;endwhile;
if (@$presmin>=60) {$ppr=floor(@$presmin/60);@$preshod=@$preshod+$ppr;@$presmin=@$presmin-(@$ppr*60);}if (@$presmin<10) { if (@$presmin<>0) {@$presmin="0".@$presmin;} else {@$presmin="00";}}

$nadprachod=0;$nadpracmin=0;@$nadprac1 = mysql_query("select id from ukony where nazev like '%nadpracováno%'") or Die(MySQL_Error());
$dotaznadprac=" where ( ";
@$menza=0;while (@$menza<mysql_num_rows($nadprac1)):
$dotaznadprac.=" id_ukonu='".mysql_result($nadprac1,$menza,0)."'"; if (mysql_result($nadprac1,$menza+1,0)<>"") {$dotaznadprac.=" or ";} else {$dotaznadprac.=" ) ";}
@$menza++;endwhile;
@$nadprac1 = mysql_query("select pracovni_doba from zpracovana_dochazka $dotaznadprac and osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by id") or Die(MySQL_Error());
@$menza=0;while (@$menza<mysql_num_rows($nadprac1)):
@$nadprac = explode(":", @mysql_result($nadprac1,@$menza,0));
$nadprachod=$nadprachod+@$nadprac[0];$nadpracmin=$nadpracmin+@$nadprac[1];
@$menza++;endwhile;
if (@$nadpracmin>=60) {$ppr=floor(@$nadpracmin/60);@$nadprachod=@$nadprachod+$ppr;@$nadpracmin=@$nadpracmin-(@$ppr*60);}if (@$nadpracmin<10) { if (@$nadpracmin<>0) {@$nadpracmin="0".@$nadpracmin;} else {@$nadpracmin="00";}}

$cerpnvhod=0;$cerpnvmin=0;@$cerpnv1 = mysql_query("select id from ukony where nazev like '%èerpané volno%'") or Die(MySQL_Error());
$dotazcerpnv=" where ( ";
@$menza=0;while (@$menza<mysql_num_rows($cerpnv1)):
$dotazcerpnv.=" id_ukonu='".mysql_result($cerpnv1,$menza,0)."'"; if (mysql_result($cerpnv1,$menza+1,0)<>"") {$dotazcerpnv.=" or ";} else {$dotazcerpnv.=" ) ";}
@$menza++;endwhile;
@$cerpnv1 = mysql_query("select pracovni_doba from zpracovana_dochazka $dotazcerpnv and osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by id") or Die(MySQL_Error());
@$menza=0;while (@$menza<mysql_num_rows($cerpnv1)):
@$cerpnv = explode(":", @mysql_result($cerpnv1,@$menza,0));
$cerpnvhod=$cerpnvhod+@$cerpnv[0];$cerpnvmin=$cerpnvmin+@$cerpnv[1];
@$menza++;endwhile;
if (@$cerpnvmin>=60) {$ppr=floor(@$cerpnvmin/60);@$cerpnvhod=@$cerpnvhod+$ppr;@$cerpnvmin=@$cerpnvmin-(@$ppr*60);}if (@$cerpnvmin<10) { if (@$cerpnvmin<>0) {@$cerpnvmin="0".@$cerpnvmin;} else {@$cerpnvmin="00";}}

$odprachod=0;$odpracmin=0;@$mzdprep = mysql_query("select hodnota from sumhodnoty where nazev='Odpracováno Celkem' ") or Die(MySQL_Error());@$rozbor = explode(",", @mysql_result($mzdprep,0,0));
$dotazmzd=" where ( ";
@$menza=1;while (@$rozbor[@$menza]<>""):
$dotazmzd.=" mzd1='".@$rozbor[@$menza]."'"; if (@$rozbor[(@$menza+1)]<>"") {$dotazmzd.=" or ";} else {$dotazmzd.=" ) ";}
@$menza++;endwhile;
@$odprac1 = mysql_query("select id from ukony $dotazmzd ") or Die(MySQL_Error());
$dotazodprac=" where ( ";
@$menza=0;while (@$menza<mysql_num_rows($odprac1)):
$dotazodprac.=" id_ukonu='".mysql_result($odprac1,$menza,0)."'"; if (mysql_result($odprac1,$menza+1,0)<>"") {$dotazodprac.=" or ";} else {$dotazodprac.=" ) ";}
@$menza++;endwhile;
@$odprac1 = mysql_query("select pracovni_doba from zpracovana_dochazka $dotazodprac and osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by id") or Die(MySQL_Error());
@$menza=0;while (@$menza<mysql_num_rows($odprac1)):
@$odprac = explode(":", @mysql_result($odprac1,@$menza,0));
$odprachod=$odprachod+@$odprac[0];$odpracmin=$odpracmin+@$odprac[1];
@$menza++;endwhile;
if (@$odpracmin>=60) {$ppr=floor(@$odpracmin/60);@$odprachod=@$odprachod+$ppr;@$odpracmin=@$odpracmin-(@$ppr*60);}if (@$odpracmin<10) { if (@$odpracmin<>0) {@$odpracmin="0".@$odpracmin;} else {@$odpracmin="00";}}

$cerprdhod=0;$cerprdmin=0;@$cerprd1 = mysql_query("select id from ukony where nazev like '%dovolená%'") or Die(MySQL_Error());
$dotazcerprd=" where ( ";
@$menza=0;while (@$menza<mysql_num_rows($cerprd1)):
$dotazcerprd.=" id_ukonu='".mysql_result($cerprd1,$menza,0)."'"; if (mysql_result($cerprd1,$menza+1,0)<>"") {$dotazcerprd.=" or ";} else {$dotazcerprd.=" ) ";}
@$menza++;endwhile;
@$cerprd1 = mysql_query("select pracovni_doba from zpracovana_dochazka $dotazcerprd and osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by id") or Die(MySQL_Error());
@$menza=0;while (@$menza<mysql_num_rows($cerprd1)):
@$cerprd = explode(":", @mysql_result($cerprd1,@$menza,0));
$cerprdhod=$cerprdhod+@$cerprd[0];$cerprdmin=$cerprdmin+@$cerprd[1];
@$menza++;endwhile;
if (@$cerprdmin>=60) {$ppr=floor(@$cerprdmin/60);@$cerprdhod=@$cerprdhod+$ppr;@$cerprdmin=@$cerprdmin-(@$ppr*60);}
if (@$cerprdmin<10) { if (@$cerprdmin<>0) {@$cerprdmin="0".@$cerprdmin;} else {@$cerprdmin="00";}}
$pocetrddnimin=(@$cerprdhod*60)+@$cerprdmin;@$pracdeninmin=(@$prachod*60)+@$pracmin;@$dovolena=round ($pocetrddnimin/@$pracdeninmin,1);

// výpocet zustatku náhradního volna
@$rozbor = explode(".", mysql_result($inform1,0,6));if (@$rozbor[0]=="") {@$rozbor[0]=0;}if (@$rozbor[1]=="") {@$rozbor[1]=0;}if (StrPos (" " . mysql_result($inform1,0,6), "-")) {@$rozbor[1]=-@$rozbor[1];}

@$zrozdilinmin=(((@$rozbor[0]+@$nadprachod)*60)+((@$rozbor[1]/100)*60)+@$nadpracmin)-((@$cerpnvhod*60)+@$cerpnvmin);
if (@$zrozdilinmin>=0) {$ppr=floor(@$zrozdilinmin/60);} else {$ppr="-".floor(-@$zrozdilinmin/60);}
@$znvhod=$ppr;
if (@$zrozdilinmin>=0) {@$znvmin=$zrozdilinmin-($ppr*60);} else {@$znvmin=$zrozdilinmin-($ppr*60);@$znvmin=-@$znvmin;}
if (strlen(@$znvmin)==1) {@$znvmin="0".@$znvmin;}if (strlen(@$znvmin)==0) {@$znvmin="00";}
// konec výpoctu

$pdf->Cell(16,6,"NV Zbývá",'LBRT');
$pdf->Cell(16,6,"ØD Zbývá",'LBRT');
$pdf->Cell(18,6,"Plán.Hodiny",'LBRT');
$pdf->Cell(29,6,"Odpracováno Celkem",'LBRT');
$pdf->Cell(27,6,"Z toho Práce v Noci",'LBRT');
$pdf->Cell(23,6,"Z Toho Pøesèas",'LBRT');
$pdf->Cell(23,6,"Z Toho Nadprac.",'LBRT');
$pdf->Cell(20,6,"Èerpané NV",'LBRT');
$pdf->Cell(19,6,"Èerpaná ØD",'LBRT');
$pdf->Ln();

$pdf->Cell(16,6,@$znvhod.":".@$znvmin." hod.",'LBRT');
$pdf->Cell(16,6,(mysql_result($inform1,0,4)-@$dovolena)." Dní",'LBRT');
$pdf->Cell(18,6,$pocetprdnitime." hod.",'LBRT');
$pdf->Cell(29,6,@$odprachod.":".@$odpracmin." hod.",'LBRT');
$pdf->Cell(27,6,@$nochod.":".@$nocmin." hod.",'LBRT');
$pdf->Cell(23,6,@$preshod.":".@$presmin." hod.",'LBRT');
$pdf->Cell(23,6,@$nadprachod.":".@$nadpracmin." hod.",'LBRT');
$pdf->Cell(20,6,@$cerpnvhod.":".@$cerpnvmin." hod.",'LBRT');
$pdf->Cell(19,6,@$dovolena." Dny",'LBRT');
$pdf->Ln();
// konec sumare




$pdf->Ln();
$pdf->Cell(20,6,"Datum",'LBRT');
$pdf->Cell(25,6,"Pøíchod",'LBRT');
$pdf->Cell(25,6,"Odchod",'LBRT');
$pdf->Cell(24,6,"Celk.Èas.Def.",'LBRT');
$pdf->Cell(36,6,"Definováno",'LBRT');
$pdf->Cell(61,6,"Poznámka",'LBRT');
$pdf->Ln();

$cykl=1;
while( @$cykl< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):

if (@$cykl<10) {$cyklus="0".$cykl;} else {@$cyklus=$cykl;} $datum =$obdobi."-".$cyklus;$in="";$out="";$cdne= date("w", strtotime($datum));



if ($cdne==0 or @$cdne==6) {$barva=1;} else {$barva=0;}if (StrPos (" " . $sden, "/".@$cykl."/")) {$barva=1;$pozn="Svátek, ";} else {$pozn="";}

$pdf->Cell(20,5,$cykl.".".$obdobi1[1].".".$obdobi1[0],'LBR',0,1,$barva);

$vypis=0;while($vypis<mysql_num_rows($vysledek)):
if (mysql_result($vysledek,@$vypis,4)==$prichod and mysql_result($vysledek,@$vypis,2)==$datum and mysql_result($vysledek,@$vypis,6)==mysql_result(@$osoby,@$osoba,0)) {$in =@$in.substr(mysql_result($vysledek,@$vypis,3),0,5).",";}
@$vypis++;endwhile;
$pdf->SetFont('tahoma','',6);$pdf->Cell(25,5,$in,'LBR',0,1,$barva);

$vypis=0;while($vypis<mysql_num_rows($vysledek)):
@$write=0;$odchody="NO";while ($odchod[@$write]<>""): if (mysql_result($vysledek,@$vypis,4) == $odchod[@$write]) {$odchody="YES";}@$write++;endwhile;
if ( $odchody=="YES" and mysql_result($vysledek,@$vypis,2)==$datum and mysql_result($vysledek,@$vypis,6)==mysql_result(@$osoby,@$osoba,0)) {$out =@$out.substr(mysql_result($vysledek,@$vypis,3),0,5).",";}
@$vypis++;endwhile;
$pdf->Cell(25,5,$out,'LBR',0,1,$barva);

//již definováno
@$nastaveno1=mysql_query("select * from zpracovana_dochazka where osobni_cislo = '$zamestnanec' and datum='$datum' order by id");
$nhod=0;$nmin=0;@$cykla=0;$definovano="";while(@$cykla<@mysql_num_rows($nastaveno1)):
@$casti = explode(":", @mysql_result($nastaveno1,@$cykla,2));
$nhod=@$nhod+@$casti[0];@$nmin=@$nmin+@$casti[1];
if (@$definovano=="") {$definovano=@mysql_result($nastaveno1,@$cykla,15)." ".@mysql_result($nastaveno1,@$cykla,2);} else {$definovano=$definovano.",".@mysql_result($nastaveno1,@$cykla,15)." ".@mysql_result($nastaveno1,@$cykla,2);}
@$cykla++;endwhile;
if (@$nmin>=60) {$ppr=floor(@$nmin/60);@$nhod=@$nhod+$ppr;@$nmin=@$nmin-(@$ppr*60);}if (@$nhod<10) {@$nhod="0".@$nhod;}if (@$nmin<10) {@$nmin="0".@$nmin;}
@$cas=@$nhod.":".@$nmin; if (@$cas=="00:00") {@$cas="";}
$pdf->Cell(24,5,@$cas,'LBR',0,1,$barva);
$pdf->Cell(36,5,@$definovano,'LBR',0,1,$barva);$pdf->SetFont('tahoma','',8);
$pdf->Cell(61,5,$pozn.mysql_result(mysql_query("select poznamka from poznamky where osobni_cislo='$zamestnanec' and datum='$datum'"),0,0),'LBR',0,1,$barva);
$pdf->Ln();

$cykl++;endwhile;
@$osoba++;endwhile;


$pdf->Output();





