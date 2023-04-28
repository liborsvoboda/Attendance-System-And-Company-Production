<table width=100% bgcolor=#FFFFFF border=1 cellpadding="0" cellspacing="0">
<?
include ("./"."dbconnect.php");
@$inform1 = mysql_query("select * from import_system where osobni_cislo='$zamestnanec' and obdobi='$obdobi'") or Die(MySQL_Error());
@$karta1 = mysql_query("select * from zamestnanci where osobni_cislo='$zamestnanec'") or Die(MySQL_Error());

@$pracdoba = explode(":", @mysql_result($karta1,0,20));@$prachod=@$pracdoba[0];@$pracmin=@$pracdoba[1];





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






//nacteni svatku a vikendu
$obdobi1=explode("-",$obdobi);@$mesic="-".$obdobi1[1]."-";$obdobidate=$obdobi."31";
$sdny1=mysql_query("select datum from svatky where ((datum like '%$mesic%' and typ='Trvalý' and stav='Aktivní') or (datum like '$obdobi%' and typ='Jedineèný' and stav='Aktivní') or (datum like '%$mesic%' and datumdo<='$obdobidate' and typ='Trvalý' and stav='Neaktivní')) order by datum");
@$load=0;$pracsv=0;$svandweek="";while(@$load<mysql_num_rows($sdny1)): @$casti=explode ("-", mysql_result($sdny1,$load,0));
$svandweek.=" and datum<>'".$obdobi."-".@$casti[2]."' ";$cdatum =$obdobi."-".@$casti[2];$cisdne= date("w", strtotime($cdatum));
if (@$cisdne>=1 and @$cisdne<=5) {$pracsv++;}
@$load++;endwhile;

$load=1;while( @$load< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):
if (@$load<10) {$cyklus="0".$load;} else {@$cyklus=$load;}$cdatum =$obdobi."-".$cyklus;$cisdne= date("w", strtotime($cdatum));
if (@$cisdne==0 or @$cisdne==6) {$svandweek.=" and datum<>'".$cdatum."' ";}
@$load++;endwhile;
//kone nacteni svatku a vikendu
@$sum1= mysql_query("select nazev,hodnota from sumhodnoty order by id ") or Die(MySQL_Error());
@$tocna=0;while (@$tocna<mysql_num_rows($sum1)):
@$sumarizace[$tocna]=mysql_result($sum1,$tocna,0);@$rozbor = explode(",", @mysql_result($sum1,$tocna,1));$dotazsum=" where ( ";
@$menza=1;while (@$rozbor[@$menza]<>""):
$dotazsum.=" mzd1='".@$rozbor[@$menza]." '";
if (@$rozbor[(@$menza+1)]<>"") {$dotazsum.=" or ";} else {$dotazsum.=" ) ";}
@$menza++;endwhile;
// osetreni prescasu pro kontrolni sestavu
if (@$tocna<>0) {@$sum2 = mysql_query("select id,nazev from ukony $dotazsum group by id order by id") or Die(MySQL_Error());}
if (@$tocna==0) {@$sum2 = mysql_query("select id,nazev from ukony $dotazsum and mzd2<>'003' and mzd3<>'003' group by id order by id") or Die(MySQL_Error());}
$dotazodprac=" where ( ";
@$menza=0;while (@$menza<mysql_num_rows($sum2)):
// osetreni nepocitani vikendu a svatku v sestave kontroly
if (@$tocna<>0) {$dotazodprac.=" id_ukonu='".mysql_result($sum2,$menza,0)."' ";}
if (@$tocna==0) {	if (mysql_result($sum2,$menza,1)=="nemoc" or mysql_result($sum2,$menza,1)=="pracovní úraz" or mysql_result($sum2,$menza,1)=="OÈR") {$dotazodprac.=" (id_ukonu='".mysql_result($sum2,$menza,0)."' ".$svandweek." ) ";}
	else {$dotazodprac.=" id_ukonu='".mysql_result($sum2,$menza,0)."' ";}
}
if (mysql_result($sum2,$menza+1,0)<>"") {$dotazodprac.=" or ";} else {$dotazodprac.=" ) ";}
@$menza++;endwhile;
@$sum3 = mysql_query("select pracovni_doba,nazev_ukonu,datum from zpracovana_dochazka $dotazodprac and osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by datum,id") or Die(MySQL_Error());
@$menza=0;@$odprachod="";@$odpracmin="";while (@$menza<mysql_num_rows($sum3)):
@$odprac = explode(":", @mysql_result($sum3,@$menza,0));
 $odprachod=$odprachod+@$odprac[0];$odpracmin=$odpracmin+@$odprac[1];
@$menza++;endwhile;
if (@$odpracmin>=60) {$ppr=floor(@$odpracmin/60);@$odprachod=@$odprachod+$ppr;@$odpracmin=@$odpracmin-(@$ppr*60);}
if (@$odpracmin<10) { if (@$odpracmin<>0) {@$odpracmin="0".@$odpracmin;} else {@$odpracmin="00";}}
@$sumarizace1[$tocna]=@$odprachod.":".@$odpracmin." hod.";
@$sumarizace2[$tocna]=(@$odprachod*60)+@$odpracmin;
@$tocna++;endwhile;




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

// výpoèet zùstatku náhradního volna
@$rozbor = explode(".", mysql_result($inform1,0,6));if (@$rozbor[0]=="") {@$rozbor[0]=0;}if (@$rozbor[1]=="") {@$rozbor[1]=0;}if (StrPos (" " . mysql_result($inform1,0,6), "-")) {@$rozbor[1]=-@$rozbor[1];}

@$zrozdilinmin=(((@$rozbor[0]+@$nadprachod)*60)+((@$rozbor[1]/100)*60)+@$nadpracmin)-((@$cerpnvhod*60)+@$cerpnvmin);
if (@$zrozdilinmin>=0) {$ppr=floor(@$zrozdilinmin/60);} else {$ppr="-".floor(-@$zrozdilinmin/60);}
@$znvhod=$ppr;
if (@$zrozdilinmin>=0) {@$znvmin=$zrozdilinmin-($ppr*60);} else {@$znvmin=$zrozdilinmin-($ppr*60);@$znvmin=-@$znvmin;}
if (strlen(@$znvmin)==1) {@$znvmin="0".@$znvmin;}if (strlen(@$znvmin)==0) {@$znvmin="00";}
// konec výpoètu


//  výpoèet pracovního èasu bez svátkù
@$pocetprdnimin=(@mysql_result($inform1,0,9)*60)-(@$pracsv*@$pracdeninmin);
$ppr=floor(@$pocetprdnimin/60);@$ppr1=@$pocetprdnimin-(@$ppr*60);if (@$ppr1<10) {@$ppr1="0".@$ppr1;}
@$pocetprdnitime=$ppr.":".$ppr1;

@$pocetprdnimin=(@mysql_result($inform1,0,9)*60);
$ppr=floor(@$pocetprdnimin/60);@$ppr1=@$pocetprdnimin-(@$ppr*60);if (@$ppr1<10) {@$ppr1="0".@$ppr1;}
@$pocetprdnitime1=($ppr*60)+$ppr1;

?>
<tr>
<td align=center bgcolor=#F9EABD><?echo "NV Zbývá<br />".@$znvhod.":".@$znvmin." hod.";?></td>
<td align=center bgcolor=#F9EABD><?echo "ØD Zbývá<br />".(mysql_result($inform1,0,4)-@$dovolena)." Dní";?></td>
<td align=center><?echo "Plán.Hodiny<br />".$pocetprdnitime." hod.+{SV ".((@$pracsv*@$pracdeninmin)/60)."h.}";?></td>

<?
@$vypis=0;while(@$vypis<@$tocna):
if (@$vypis==0 and @$pocetprdnitime1-@$sumarizace2[($vypis)]<>0 and @$pocetprdnitime1-@$sumarizace2[($vypis)]-(@$pracsv*@$pracdeninmin)<>0) {$pozadi="#FE505C";} else {$pozadi="#FFFFFF";}
if (mysql_result(mysql_query("select id from zpracovana_dochazka where export='ANO' and obdobi='".securesql($obdobi)."' "),0,0)==0 or $vypis>0) {echo"<td align=center bgcolor=".$pozadi.">".@$sumarizace[$vypis]."<br />".@$sumarizace1[$vypis]."</td>";}@$vypis++;endwhile;?>
<!--//<td align=center><?echo "Odpracováno Celkem<br />".@$odprachod.":".@$odpracmin." hod.";?></td>//-->

<td align=center><?echo "Z toho Práce v Noci<br />".@$nochod.":".@$nocmin." hod.";?></td>
<td align=center><?echo "Z Toho Pøesèas<br />".@$preshod.":".@$presmin." hod.";?></td>
<td align=center><?echo "Z Toho Nadprac.<br />".@$nadprachod.":".@$nadpracmin." hod.";?></td>
<td align=center><?echo "Èerpané NV<br />".@$cerpnvhod.":".@$cerpnvmin." hod.";?></td>
<td align=center><?echo "Èerpaná ØD<br />".@$dovolena." Dny";?></td>
</tr>
</table>