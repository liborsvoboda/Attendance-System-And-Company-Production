<?
//  menu
@$menu=@$_POST["menu"];
@$kategorie=@$_POST["kategorie"];if (@$kategorie<>"Všichni" and @$kategorie<>"") {$dkategorie=" and kategorie='".$kategorie."'";}
include ("./"."dbconnect.php");
?>

<form action="hlavicka.php?akce=<?echo base64_encode('Reporty');?>" method=post>

<h2><p align="center">Správa Reportù za Období:
<? if (StrPos (" " . $_SESSION["prava"], "r")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "r")){
   if (@$menu<>"Odprac.H. bez Pøes."){echo"<option>Odprac.H. bez Pøes.</option>";}
   if (@$menu<>"Report Nemocnosti"){echo"<option>Report Nemocnosti</option>";}
   if (@$menu<>"Report Úrazù"){echo"<option>Report Úrazù</option>";}
   if (@$menu<>"Report Pøesèasù / 60%"){echo"<option>Report Pøesèasù / 60%</option>";}
   if (@$menu<>"Práce na J.Støedisku"){echo"<option>Práce na J.Støedisku</option>";}
   if (@$menu<>"Souhrn Stavu Zamìstnancù"){echo"<option>Souhrn Stavu Zamìstnancù</option>";}
   if (@$menu<>"Detailní Výpis Stavu Zamìstnancù"){echo"<option>Detailní Výpis Stavu Zamìstnancù</option>";}

}?>



   </select> </p></h2>

<? if (!StrPos (" " . $_SESSION["prava"], "r")){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2 frame="border" rules=all>




<? if (StrPos (" " . $_SESSION["prava"], "r")){?>




<?if (@$menu=="Odprac.H. bez Pøes."){?>
<tr bgcolor="#C0FFC0"><td><center><b><?echo@$menu;?></b></center></td>
<td align=right>Kategorie:<select name=kategorie onchange=submit(this)>
<?if (@$kategorie<>"") {echo"<option>".$kategorie."</option>";}
@$data1 = mysql_query("select * from kategorie order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$kategorie<>mysql_result($data1,@$cykl,1)) {?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;if (@$kategorie<>"Všichni")?><option>Všichni</option></select></td>

<td align=right>Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$_POST["obdobi"]<>""){?><option value="<?echo @$_POST['obdobi'];?>"><?$obdobi1=explode("-",@$_POST["obdobi"]);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
@$data1 = mysql_query("select obdobi from zpracovana_dochazka group by obdobi order by obdobi DESC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select> (v èasomíøe <input name="casomira" type="checkbox" <?if (@$_POST["casomira"]=="on") {echo"checked";}?> onclick=submit(this) >)</td></tr>

<?if (@$_POST["obdobi"]<>"") {?><tr><td colspan=3><table border=1 frame="border" rules=all>
<tr bgcolor=#C7D0F1><td>Práce na<br />Støedisku</td>
<td>Os.Èíslo</td>
<td>Pøíjmení a Jméno</td>
<td>Kat.</td>
<?
//selekce svatku
@$aktmesic="-".$obdobi1[1]."-";$aktobdobi=@$obdobi."-";$aktobdobidate=@$obdobi."-31";
include ("./"."dbconnect.php");$sdny1=mysql_query("select datum from svatky where ((datum like '%$aktmesic%' and typ='Trvalý' and stav='Aktivní') or (datum like '$aktobdobi%' and typ='Jedineèný' and stav='Aktivní') or (datum like '%$aktmesic%' and datumdo<='$aktobdobidate' and typ='Trvalý' and stav='Neaktivní')) order by datum");
@$load=0;$sden="/";while(@$load<mysql_num_rows($sdny1)): @$casti=explode ("-", mysql_result($sdny1,$load,0));$sden=$sden.(int)@$casti[2]."/";@$load++;endwhile;
// konec selekce svatku

//hlavicka
$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):    // cykl souctu pracovniku k radku
if (@$dny<10) {$cyklus="0".$dny;} else {@$cyklus=$dny;}$datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));$tdne= date("W", strtotime($datum));
if (@$cdne==0) {$ndne="NE";}if (@$cdne==1) {$ndne="PO";}if (@$cdne==2) {$ndne="ÚT";}if (@$cdne==3) {$ndne="ST";}if (@$cdne==4) {$ndne="ÈT";}if (@$cdne==5) {$ndne="PÁ";}if (@$cdne==6) {$ndne="SO";}
if (@$cdne==0 or @$cdne==6 or StrPos (" " . $sden, "/".$dny."/")) {$barva="#FDCC5B";} else {$barva="#C7D0F1";}
echo"<td align=center bgcolor=".$barva.">".$ndne."<br />".$dny."</td>";
@$dny++;endwhile;echo"</tr>"; // konec hlavicky

// telo
// tvorba dotazu na slozky
$data1=mysql_query("select id,nazev,zkratka,sestava from ukony where prace = 'ANO' order by zkratka,id");
	$slozky="";@$cykl=0;while (@$cykl<@mysql_num_rows($data1)):
	$slozky.=" id_ukonu='".@mysql_result($data1,@$cykl,0)."' ";if (@mysql_result($data1,(@$cykl+1),0)<>"") {$slozky.=" or ";}
@$cykl++;endwhile;
// konec dotazu



// dotaz na stredisko
$vypsat="";
$data2=mysql_query("select stredisko,osobni_cislo from zpracovana_dochazka where (".$slozky.") and datum like'".securesql(@$_POST['obdobi'])."-%' and osobni_cislo in (select osobni_cislo from zamestnanci where export='ANO' and jen_pruchod='NE' $dkategorie ) group by stredisko,osobni_cislo order by stredisko,osobni_cislo,id");
@$spocet=0;while(@$spocet<@mysql_num_rows($data2)):

		$vypsat.="<tr><td>".@mysql_result($data2,$spocet,0)."</td><td>".@mysql_result($data2,$spocet,1)."</td>";
	@$data3 = mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul),kategorie from zamestnanci where osobni_cislo='".@mysql_result($data2,@$spocet,1)."' and jen_pruchod='NE' ") or Die(MySQL_Error());
		$vypsat.="<td>".@mysql_result($data3,0,0)."</td><td>".@mysql_result($data3,0,1)."</td>";


$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):    // cykl souctu pracovniku k radku
if (@$dny<10) {$cyklus="0".$dny;} else {@$cyklus=$dny;}$datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));$tdne= date("W", strtotime($datum));
if (@$cdne==0 or @$cdne==6 or StrPos (" " . $sden, "/".$dny."/")) {$barva="#FDCC5B";} else {$barva="#EDB745";}
@$data4=mysql_query("select pracovni_doba from zpracovana_dochazka where (".$slozky.")and stredisko='".@mysql_result($data2,$spocet,0)."' and datum='".securesql($datum)."' and osobni_cislo='".@mysql_result($data2,$spocet,1)."' order by id") or Die(MySQL_Error());

$prcas=0;@$secti=0;while(@$secti<@mysql_num_rows($data4)):
	@$pracrozklad = explode(":", @mysql_result($data4,$secti,0));
	$prcas=$prcas+(@$pracrozklad[0]*60)+@$pracrozklad[1];
@$secti++;endwhile;

$vypsat.="<td align=center bgcolor=".$barva." >";


if (@$_POST["casomira"]=="on") {$ppr=floor(@$prcas/60);$ppr1=$prcas-(60*$ppr);if (@$ppr1<10 and @$ppr1>=0){@$ppr1="0".@$ppr1;} if (@$ppr<>0 or @$ppr1<>0) {$vypsat.=@$ppr.":".@$ppr1;}}
if (@$_POST["casomira"]=="") {if (@$prcas<>0) {$vypsat.=(@$prcas/60);}}

$vypsat.="</td>";
@$dny++;endwhile;$vypsat.="</tr>";


@$spocet++;endwhile;

echo $vypsat;
?></table></td></tr>
<?}}?>







<?if (@$menu=="Detailní Výpis Stavu Zamìstnancù"){?>
<tr bgcolor="#C0FFC0"><td><center><b><?echo@$menu;?></b></center></td>
<td align=right>Kategorie:<select name=kategorie onchange=submit(this)>
<?if (@$kategorie<>"") {echo"<option>".$kategorie."</option>";}
@$data1 = mysql_query("select * from kategorie order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$kategorie<>mysql_result($data1,@$cykl,1)) {?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;if (@$kategorie<>"Všichni")?><option>Všichni</option></select></td>

<td align=right>Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$_POST["obdobi"]<>""){?><option value="<?echo @$_POST['obdobi'];?>"><?$obdobi1=explode("-",@$_POST["obdobi"]);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
@$data1 = mysql_query("select obdobi from zpracovana_dochazka group by obdobi order by obdobi DESC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<?if (@$_POST["obdobi"]<>"") {?><tr><td colspan=3><table border=1 frame="border" rules=all>
<tr bgcolor=#C7D0F1><td>Os.È.</td>
<td>Pøíjmení a Jméno</td>
<td>Útvar</td>
<td>Kat.</td>
<?
//selekce svatku
@$aktmesic="-".$obdobi1[1]."-";$aktobdobi=@$obdobi."-";$aktobdobidate=@$obdobi."-31";
include ("./"."dbconnect.php");$sdny1=mysql_query("select datum from svatky where ((datum like '%$aktmesic%' and typ='Trvalý' and stav='Aktivní') or (datum like '$aktobdobi%' and typ='Jedineèný' and stav='Aktivní') or (datum like '%$aktmesic%' and datumdo<='$aktobdobidate' and typ='Trvalý' and stav='Neaktivní')) order by datum");
@$load=0;$sden="/";while(@$load<mysql_num_rows($sdny1)): @$casti=explode ("-", mysql_result($sdny1,$load,0));$sden=$sden.(int)@$casti[2]."/";@$load++;endwhile;
// konec selekce svatku

//hlavicka
$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):    // cykl souctu pracovniku k radku
if (@$dny<10) {$cyklus="0".$dny;} else {@$cyklus=$dny;}$datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));$tdne= date("W", strtotime($datum));
if (@$cdne==0) {$ndne="NE";}if (@$cdne==1) {$ndne="PO";}if (@$cdne==2) {$ndne="ÚT";}if (@$cdne==3) {$ndne="ST";}if (@$cdne==4) {$ndne="ÈT";}if (@$cdne==5) {$ndne="PÁ";}if (@$cdne==6) {$ndne="SO";}
if (@$cdne==0 or @$cdne==6 or StrPos (" " . $sden, "/".$dny."/")) {$barva="#FDCC5B";} else {$barva="#EDB745";}
echo"<td align=center bgcolor=".$barva.">".$ndne."<br />".$dny."</td>";
@$dny++;endwhile;echo"</tr>"; // konec hlavicky

// telo



// tvorba dotazu na slozky
$data1=mysql_query("select id,nazev,zkratka,sestava from ukony where souhrn = 'ANO' order by zkratka,id");
	$slozky="";@$cykl=0;while (@$cykl<@mysql_num_rows($data1)):
	$slozky.=" id_ukonu='".@mysql_result($data1,@$cykl,0)."' ";if (@mysql_result($data1,(@$cykl+1),0)<>"") {$slozky.=" or ";}
@$cykl++;endwhile;
// konec dotazu

// dotaz na zamestnance
$data2=mysql_query("select osobni_cislo from zpracovana_dochazka where (".$slozky.") and datum like'".securesql(@$_POST['obdobi'])."-%' and osobni_cislo in (select osobni_cislo from zamestnanci where export='ANO' and jen_pruchod='NE' $dkategorie ) group by osobni_cislo order by stredisko,osobni_cislo,id");
@$spocet=0;while(@$spocet<(@mysql_num_rows($data2))):

    //nacteni dalsich informaci k zamestnanci
	@$pracdoba1 = mysql_query("select jmeno,prijmeni,titul,pracovni_doba,stredisko,kategorie from zamestnanci where osobni_cislo='".@mysql_result($data2,@$spocet,0)."' and jen_pruchod='NE' ") or Die(MySQL_Error());
		@$pracrozklad = explode(":", @mysql_result($pracdoba1,0,3));
	$pracdoba=(@$pracrozklad[0]*60)+@$pracrozklad[1];  // konec nacteni

// vyhodnoceni jednotlivych dni
$status="";
$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):    // cykl souctu pracovniku k radku
if (@$dny<10) {$cyklus="0".$dny;} else {@$cyklus=$dny;}$datum =@$_POST["obdobi"]."-".$cyklus;


$zedne1=mysql_query("select pracovni_doba,zkratka_ukonu,id_ukonu from zpracovana_dochazka where osobni_cislo='".@mysql_result($data2,@$spocet,0)."' and datum='".securesql($datum)."' and (".$slozky.") order by id");
$zedne=0;@$soucet=0;while(@$soucet<@mysql_num_rows($zedne1)):@$pracrozklad = explode(":", @mysql_result($zedne1,$soucet,0));$zedne=$zedne+(@$pracrozklad[0]*60)+@$pracrozklad[1];
if (@mysql_result($zedne1,$soucet,2)<>@mysql_result($zedne1,($soucet+1),2) and @mysql_num_rows($zedne1)>1 and @$pracdoba==$zedne) {$osoba[$dny]="JD";}
@$soucet++;endwhile;

if (@$pracdoba==$zedne) {$status="ANO";if ($osoba[$dny]<>"JD") {$osoba[$dny]=@mysql_result($zedne1,0,1);}}

$dny++;endwhile; // konec vyhodnoceni

if (@$status=="ANO") { //tvorba tela tabulky do promenne$vypsat.="<tr bgcolor=#C7D0F1><td>".@mysql_result($data2,@$spocet,0)."</td><td>".@mysql_result($pracdoba1,0,1)." ".@mysql_result($pracdoba1,0,0)." ".@mysql_result($pracdoba1,0,2)."</td><td align=center>".mysql_result(mysql_query("select stredisko from zam_strediska where osobni_cislo='".securesql(mysql_result($data2,$spocet,0))."' and ((datumod <='".securesql(@$_POST["obdobi"])."-31' and (datumdo>='".securesql(@$_POST["obdobi"])."-01' or datumdo='0000-00-00')) or datumod like '".securesql(@$_POST["obdobi"])."%') "),0,0)."</td><td>".@mysql_result($pracdoba1,0,5)."</td>";
$vdny=1;while( @$vdny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):    // cykl mesice
if (@$vdny<10) {$vcyklus="0".$vdny;} else {@$vcyklus=$vdny;}$vdatum =@$_POST["obdobi"]."-".$vcyklus;$vcdne= date("w", strtotime($vdatum));$vtdne= date("W", strtotime($vdatum));
if (@$vcdne==0 or @$vcdne==6 or StrPos (" " . $sden, "/".$vdny."/")) {$vbarva="#FDCC5B";} else {$vbarva="#EDB745";}
$vypsat.="<td bgcolor=".$vbarva." align=center>".$osoba[$vdny]."</td>";$osoba[$vdny]="";
@$vdny++;endwhile;$vypsat.="</tr>";}

@$spocet++;endwhile;

echo $vypsat;
?></table></td></tr>
<?}}?>







<?if (@$menu=="Souhrn Stavu Zamìstnancù"){?>
<tr bgcolor="#C0FFC0"><td><center><b><?echo@$menu;?></b></center></td>
<td align=right>Kategorie:<select name=kategorie onchange=submit(this)>
<?if (@$kategorie<>"") {echo"<option>".$kategorie."</option>";}
@$data1 = mysql_query("select * from kategorie order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$kategorie<>mysql_result($data1,@$cykl,1)) {?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;if (@$kategorie<>"Všichni")?><option>Všichni</option></select></td>

<td align=right>Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$_POST["obdobi"]<>""){?><option value="<?echo @$_POST['obdobi'];?>"><?$obdobi1=explode("-",@$_POST["obdobi"]);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
@$data1 = mysql_query("select obdobi from zpracovana_dochazka group by obdobi order by obdobi DESC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<?if (@$_POST["obdobi"]<>"") {?><tr><td colspan=3><table border=1 frame="border" rules=all>
<tr bgcolor=#C7D0F1><td>Kategorie</td>
<?
//selekce svatku
@$aktmesic="-".$obdobi1[1]."-";$aktobdobi=@$obdobi."-";$aktobdobidate=@$obdobi."-31";
include ("./"."dbconnect.php");$sdny1=mysql_query("select datum from svatky where ((datum like '%$aktmesic%' and typ='Trvalý' and stav='Aktivní') or (datum like '$aktobdobi%' and typ='Jedineèný' and stav='Aktivní') or (datum like '%$aktmesic%' and datumdo<='$aktobdobidate' and typ='Trvalý' and stav='Neaktivní')) order by datum");
@$load=0;$sden="/";while(@$load<mysql_num_rows($sdny1)): @$casti=explode ("-", mysql_result($sdny1,$load,0));$sden=$sden.(int)@$casti[2]."/";@$load++;endwhile;
// konec selekce svatku



 //hlavièka
$cykl=1;while( @$cykl< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):
if (@$cykl<10) {$cyklus="0".$cykl;} else {@$cyklus=$cykl;}$datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));$tdne= date("W", strtotime($datum));
if (@$cdne==0) {$ndne="NE";}if (@$cdne==1) {$ndne="PO";}if (@$cdne==2) {$ndne="ÚT";}if (@$cdne==3) {$ndne="ST";}if (@$cdne==4) {$ndne="ÈT";}if (@$cdne==5) {$ndne="PÁ";}if (@$cdne==6) {$ndne="SO";}
if (@$cdne==0 or @$cdne==6 or StrPos (" " . $sden, "/".$cykl."/")) {$barva="#FDCC5B";} else {$barva="#C7D0F1";}if (!StrPos (" ".$tydny, ">".$tdne."<")){$tydny.="<td bgcolor=#C7EFC0>TÝ<br />".$tdne."</td>";}
echo"<td align=center bgcolor=".$barva.">".$ndne."<br />".$cykl."</td>";
@$cykl++;endwhile;echo $tydny."<td bgcolor=#92DF84 align=center>M<br />".$obdobi1[1]."</td>"; // konec hlavièky



// telo
$data1=mysql_query("select id,nazev,zkratka,sestava from ukony where souhrn = 'ANO' order by sestava,zkratka,id");
@$cykl=0;while (@$cykl<@mysql_num_rows($data1)):
echo"<tr><td bgcolor=#C7D0F1>".@mysql_result($data1,@$cykl,1)."</td>";       // nazev radku

$slozky.=" id_ukonu='".@mysql_result($data1,@$cykl,0)."' ";$nslozky.=" id_ukonu<>'".@mysql_result($data1,@$cykl,0)."' ";if (@mysql_result($data1,(@$cykl+1),0)<>"") {$slozky.=" or ";$nslozky.=" and ";}

// nazvy souctovych sestav
if (@mysql_result($data1,@$cykl,3)<>"" and $sestava[@mysql_result($data1,@$cykl,3)]=="") {$sestava[@mysql_result($data1,@$cykl,3)]=@mysql_result($data1,@$cykl,3);$nazvysestav.=@mysql_result($data1,@$cykl,3)."/";}



$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):    // cykl souctu pracovniku k radku
if (@$dny<10) {$cyklus="0".$dny;} else {@$cyklus=$dny;}$datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));$tdne= date("W", strtotime($datum));

if (@$cdne==0 or @$cdne==6 or StrPos (" " . $sden, "/".$dny."/")) {$barva="#FDCC5B";} else {$barva="#EDB745";}
if ($firstweek=="") {$firstweek=$tdne;}if ($tdne<>$lastweek) {$lastweek=$tdne;}
if (@$cdne>0 and @$cdne<6 and $cykl==0 and !StrPos (" " . $sden, "/".$dny."/")) {$pracdni[$tdne]=$pracdni[$tdne]+1;}


$pocet=0;$popis="";
if (@$cdne>0 and @$cdne<6 and !StrPos (" " . $sden, "/".$dny."/")) { // vypis pouze prac dni
$data2=mysql_query("select osobni_cislo from zpracovana_dochazka where id_ukonu = '".securesql(@mysql_result($data1,@$cykl,0))."' and datum='".securesql($datum)."' and osobni_cislo in (select osobni_cislo from zamestnanci where export='ANO' and jen_pruchod='NE' $dkategorie ) group by osobni_cislo order by osobni_cislo,id");
@$spocet=0;while(@$spocet<(@mysql_num_rows($data2))):

	@$pracdoba1 = mysql_query("select jmeno,prijmeni,titul,pracovni_doba from zamestnanci where osobni_cislo='".@mysql_result($data2,@$spocet,0)."' and jen_pruchod='NE' ") or Die(MySQL_Error());
		@$pracrozklad = explode(":", @mysql_result($pracdoba1,0,3));
	$pracdoba=(@$pracrozklad[0]*60)+@$pracrozklad[1];

$zedne1=mysql_query("select pracovni_doba from zpracovana_dochazka where osobni_cislo='".@mysql_result($data2,@$spocet,0)."' and datum='".securesql($datum)."' and id_ukonu = '".securesql(@mysql_result($data1,@$cykl,0))."' order by id");
$zedne=0;@$soucet=0;while(@$soucet<@mysql_num_rows($zedne1)):@$pracrozklad = explode(":", @mysql_result($zedne1,$soucet,0));$zedne=$zedne+(@$pracrozklad[0]*60)+@$pracrozklad[1];@$soucet++;endwhile;



if (@$pracdoba==$zedne) {$popis.=@mysql_result($pracdoba1,0,1)." ".@mysql_result($pracdoba1,0,0)." ".@mysql_result($pracdoba1,0,2)." ".@mysql_result($data2,@$spocet,0)."\n";$pocet++;}
@$spocet++;endwhile;
}
// tvorba hodnot souctovych sestav
if (@mysql_result($data1,@$cykl,3)<>"") {$sestava[@mysql_result($data1,@$cykl,3)."/".$dny]=$sestava[@mysql_result($data1,@$cykl,3)."/".$dny]+@$pocet;}
$nepritomno[$dny]=$nepritomno[$dny]+@$pocet;

$tyden[@mysql_result($data1,@$cykl,0).$tdne]=$tyden[@mysql_result($data1,@$cykl,0).$tdne]+@$pocet;

echo "<td bgcolor=".$barva." align=center title='".$popis."' style=cursor:pointer>";if (@$pocet<>0) {echo@$pocet;}echo "</td>";
@$dny++;endwhile;

$ptydnu=0;$vypist=$firstweek;while ($vypist<>($lastweek+1)):
$ptydnu++;if ($vypist<10) {$vypisti="0".$vypist;} else {$vypisti=$vypist;}
$mesicv=$mesicv+round((@$tyden[@mysql_result($data1,@$cykl,0).$vypisti]/@$pracdni[$vypisti]),1);
echo "<td bgcolor=#C7EFC0>";
if (round((@$tyden[@mysql_result($data1,@$cykl,0).$vypisti]/@$pracdni[$vypisti]),1)<>0) {echo round((@$tyden[@mysql_result($data1,@$cykl,0).$vypisti]/@$pracdni[$vypisti]),1);}echo"</td>";@$vypist++;
if (date("W", strtotime(($obdobi1[0]-1)."-12-31"))<$vypist and ($lastweek+1)<$vypist){$vypist=1;}
endwhile;

echo "<td bgcolor=#92DF84 align=center>";if (round((@$mesicv/$ptydnu),1)<>0){echo round((@$mesicv/$ptydnu),1);}echo"</td></tr>";$mesicv=0;
@$cykl++;endwhile;
// konec hlavniho tela







// (JD)

echo"<tr><td bgcolor=#C7D0F1>Jiný Dùvod</td>";       // nazev radku
$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):    // cykl souctu pracovniku k radku
if (@$dny<10) {$cyklus="0".$dny;} else {@$cyklus=$dny;}$datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));$tdne= date("W", strtotime($datum));
if (@$cdne==0 or @$cdne==6 or StrPos (" " . $sden, "/".$dny."/")) {$barva="#FDCC5B";} else {$barva="#EDB745";}


$pocet=0;$popis="";
if (@$cdne>0 and @$cdne<6 and !StrPos (" " . $sden, "/".$dny."/")) { // vypis pouze prac dni
$data2=mysql_query("select osobni_cislo from zpracovana_dochazka where (".$slozky.") and datum='".securesql($datum)."' and osobni_cislo in (select osobni_cislo from zamestnanci where export='ANO' and jen_pruchod='NE' $dkategorie ) group by osobni_cislo order by osobni_cislo,id");
@$spocet=0;while(@$spocet<(@mysql_num_rows($data2))):

	@$pracdoba1 = mysql_query("select jmeno,prijmeni,titul,pracovni_doba from zamestnanci where osobni_cislo='".@mysql_result($data2,@$spocet,0)."' and jen_pruchod='NE' ") or Die(MySQL_Error());
		@$pracrozklad = explode(":", @mysql_result($pracdoba1,0,3));
	$pracdoba=(@$pracrozklad[0]*60)+@$pracrozklad[1];

$zedne1=mysql_query("select pracovni_doba from zpracovana_dochazka where osobni_cislo='".@mysql_result($data2,@$spocet,0)."' and datum='".securesql($datum)."' and (".$slozky.") order by id");
$zedne=0;@$soucet=0;while(@$soucet<@mysql_num_rows($zedne1)):@$pracrozklad = explode(":", @mysql_result($zedne1,$soucet,0));$zedne=$zedne+(@$pracrozklad[0]*60)+@$pracrozklad[1];@$soucet++;endwhile;

if (@$pracdoba==$zedne and @mysql_num_rows($zedne1)>1) {$popis.=@mysql_result($pracdoba1,0,1)." ".@mysql_result($pracdoba1,0,0)." ".@mysql_result($pracdoba1,0,2)." ".@mysql_result($data2,@$spocet,0)."\n";$pocet++;}
@$spocet++;endwhile;
}
$nepritomno[$dny]=$nepritomno[$dny]+@$pocet;
$tyden["JD".$tdne]=$tyden["JD".$tdne]+@$pocet;
echo "<td bgcolor=".$barva." align=center title='".$popis."' style=cursor:pointer>";if (@$pocet<>0) {echo@$pocet;}echo"</td>";
@$dny++;endwhile;

$ptydnu=0;$vypist=$firstweek;
while ($vypist<>($lastweek+1)):
$ptydnu++;if ($vypist<10) {$vypisti="0".$vypist;} else {$vypisti=$vypist;}
$mesicv=$mesicv+round((@$tyden["JD".$vypisti]/@$pracdni[$vypisti]),1);
echo "<td bgcolor=#C7EFC0>";if (round((@$tyden["JD".$vypisti]/@$pracdni[$vypisti]),1)<>0){echo round((@$tyden["JD".$vypisti]/@$pracdni[$vypisti]),1);}echo"</td>";@$vypist++;
if (date("W", strtotime(($obdobi1[0]-1)."-12-31"))<$vypist and ($lastweek+1)<$vypist){$vypist=1;}
endwhile;
echo "<td bgcolor=#92DF84 align=center>";if (round((@$mesicv/$ptydnu),1)<>0) {echo round((@$mesicv/$ptydnu),1);}echo"</td></tr>";$mesicv=0;
// konec (JD)





//  souctovych sestavy
$vsestavy=explode ("/", $nazvysestav);
@$cykl=0;while ($vsestavy[$cykl]<>""):
echo"<tr><td bgcolor=#F9B7F3>".$vsestavy[$cykl]."</td>";       // nazev radku
$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):    // cykl souctu pracovniku k radku
if (@$dny<10) {$cyklus="0".$dny;} else {@$cyklus=$dny;}$datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));$tdne= date("W", strtotime($datum));
if (@$cdne==0 or @$cdne==6 or StrPos (" " . $sden, "/".$dny."/")) {$barva="#FDCC5B";} else {$barva="#F9B7F3";}

echo "<td bgcolor=".$barva." align=center >";if ($sestava[$vsestavy[$cykl]."/".$dny]<>0) {echo $sestava[$vsestavy[$cykl]."/".$dny];}echo"</td>";
$tyden[$vsestavy[$cykl].$tdne]=$tyden[$vsestavy[$cykl].$tdne]+$sestava[$vsestavy[$cykl]."/".$dny];
@$dny++;endwhile;

$ptydnu=0;$vypist=$firstweek;
while ($vypist<>($lastweek+1)):
$ptydnu++;if ($vypist<10) {$vypisti="0".$vypist;} else {$vypisti=$vypist;}
$mesicv=$mesicv+round(($tyden[$vsestavy[$cykl].$vypisti]/@$pracdni[$vypisti]),1);
echo "<td bgcolor=#C7EFC0>";if (round(($tyden[$vsestavy[$cykl].$vypisti]/@$pracdni[$vypisti]),1)<>0){echo round(($tyden[$vsestavy[$cykl].$vypisti]/@$pracdni[$vypisti]),1);}echo"</td>";@$vypist++;
if (date("W", strtotime(($obdobi1[0]-1)."-12-31"))<$vypist and ($lastweek+1)<$vypist){$vypist=1;}
endwhile;
echo "<td bgcolor=#92DF84 align=center>";if (round((@$mesicv/$ptydnu),1)<>0) {echo round((@$mesicv/$ptydnu),1);}echo"</td></tr>";$mesicv=0;
@$cykl++;endwhile;
//  konec souctovych sestav


// ve stavu
echo"<tr><td bgcolor=#C7D0F1>ve stavu</td>";       // nazev radku
$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):    // cykl souctu pracovniku k radku
if (@$dny<10) {$cyklus="0".$dny;} else {@$cyklus=$dny;}$datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));$tdne= date("W", strtotime($datum));
if (@$cdne==0 or @$cdne==6 or StrPos (" " . $sden, "/".$dny."/")) {$barva="#FDCC5B";} else {$barva="#C7D0F1";}

$pocet=0;
if (@$cdne>0 and @$cdne<6 and !StrPos (" " . $sden, "/".$dny."/")) {$vprac[$dny]=$pocet=mysql_result(mysql_query("select count(id) from zamestnanci where datumin<='".securesql($datum)."' and (datumout>='".securesql($datum)."' or datumout='0000-00-00') and export='ANO' and jen_pruchod='NE' $dkategorie order by osobni_cislo,id"),0,0);
$tyden[$tdne]=$tyden[$tdne]+@$pocet;
}
echo "<td bgcolor=".$barva." align=center title='".$popis."' >";if (@$pocet<>0) {echo@$pocet;}echo"</td>";
@$dny++;endwhile;

$ptydnu=0;$vypist=$firstweek;
while ($vypist<>($lastweek+1)):
$ptydnu++;if ($vypist<10) {$vypisti="0".$vypist;} else {$vypisti=$vypist;}
$mesicv=$mesicv+round(($tyden[$vypisti]/@$pracdni[$vypisti]),1);
echo "<td bgcolor=#C7EFC0>";if (round(($tyden[$vypisti]/@$pracdni[$vypisti]),1)<>0){echo round(($tyden[$vypisti]/@$pracdni[$vypisti]),1);}echo"</td>";@$vypist++;
if (date("W", strtotime(($obdobi1[0]-1)."-12-31"))<$vypist and ($lastweek+1)<$vypist){$vypist=1;}
endwhile;
echo "<td bgcolor=#92DF84 align=center>";if (round((@$mesicv/$ptydnu),1)<>0) {echo round((@$mesicv/$ptydnu),1);}echo"</td></tr>";$mesicv=0;
// konec ve stavu


// nepøítomno
echo"<tr><td bgcolor=#C7D0F1>Nepøítomno</td>";       // nazev radku
$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):    // cykl souctu pracovniku k radku
if (@$dny<10) {$cyklus="0".$dny;} else {@$cyklus=$dny;}$datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));$tdne= date("W", strtotime($datum));
if (@$cdne==0 or @$cdne==6 or StrPos (" " . $sden, "/".$dny."/")) {$barva="#FDCC5B";} else {$barva="#C7D0F1";}


$neptyden[$tdne]=$neptyden[$tdne]+$nepritomno[$dny];
echo "<td bgcolor=".$barva." align=center title='".$popis."' >";if ($nepritomno[$dny]<>0) {echo@$nepritomno[$dny];}echo"</td>";
@$dny++;endwhile;

$ptydnu=0;$vypist=$firstweek;
while ($vypist<>($lastweek+1)):
$ptydnu++;if ($vypist<10) {$vypisti="0".$vypist;} else {$vypisti=$vypist;}
$mesicv=$mesicv+round(($neptyden[$vypisti]/@$pracdni[$vypisti]),1);
echo "<td bgcolor=#C7EFC0>";if (round(($neptyden[$vypisti]/@$pracdni[$vypisti]),1)<>0){echo round(($neptyden[$vypisti]/@$pracdni[$vypisti]),1);}echo"</td>";@$vypist++;
if (date("W", strtotime(($obdobi1[0]-1)."-12-31"))<$vypist and ($lastweek+1)<$vypist){$vypist=1;}
endwhile;
echo "<td bgcolor=#92DF84 align=center>";if (round((@$mesicv/$ptydnu),1)<>0) {echo round((@$mesicv/$ptydnu),1);}echo"</td></tr>";$mesicv=0;
// konec nepøítomno



// na pracovišti
echo"<tr><td bgcolor=#C7D0F1>na pracovišti</td>";       // nazev radku
$ne=0;$so=0;$sv=0;$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):    // cykl souctu pracovniku k radku
if (@$dny<10) {$cyklus="0".$dny;} else {@$cyklus=$dny;}$datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));$tdne= date("W", strtotime($datum));
if (@$cdne==0 or @$cdne==6 or StrPos (" " . $sden, "/".$dny."/")) {$barva="#FDCC5B";} else {$barva="#C7D0F1";}

$pocet=0;

if (@$cdne==0 or @$cdne==6 or StrPos (" " . $sden, "/".$dny."/")) { // vypis pouze neprac dni
$pocet=mysql_num_rows(mysql_query("select id from zpracovana_dochazka where $nslozky and datum='".securesql($datum)."' and osobni_cislo in (select osobni_cislo from zamestnanci where export='ANO' and jen_pruchod='NE'  $dkategorie ) group by osobni_cislo order by osobni_cislo,id"));
} else {$pocet=$vprac[$dny]-$nepritomno[$dny];}

if (@$cdne==0) {$ne++;$valuene=$valuene+$pocet;}
if (@$cdne==6) {$so++;$valueso=$valueso+$pocet;}
if (StrPos (" " . $sden, "/".$dny."/")) {$sv++;$valuesv=$valuesv+$pocet;}


echo "<td bgcolor=".$barva." align=center>";if ($pocet<>0) {echo $pocet;}echo"</td>";
@$dny++;endwhile;

$ptydnu=0;$vypist=$firstweek;
while ($vypist<>($lastweek+1)):
$ptydnu++;if ($vypist<10) {$vypisti="0".$vypist;} else {$vypisti=$vypist;}
$mesicv=$mesicv+round((($tyden[$vypisti]-$neptyden[$vypisti])/@$pracdni[$vypisti]),1);
echo "<td bgcolor=#C7EFC0>";if (round((($tyden[$vypisti]-$neptyden[$vypisti])/@$pracdni[$vypisti]),1)<>0){echo round((($tyden[$vypisti]-$neptyden[$vypisti])/@$pracdni[$vypisti]),1);}echo"</td>";@$vypist++;
if (date("W", strtotime(($obdobi1[0]-1)."-12-31"))<$vypist and ($lastweek+1)<$vypist){$vypist=1;}
endwhile;
echo "<td bgcolor=#92DF84 align=center>";if (round((@$mesicv/$ptydnu),1)<>0) {echo round((@$mesicv/$ptydnu),1);}echo"</td></tr>";$mesicv=0;
// konec na pracovišti
?></table></td></tr>
<tr><td></td><td align=center><table border=1 style=width:100% frame="border" rules=all>
<tr align=center bgcolor=#C7D0F1><td colspan=3 align=center>práce v:</td></tr>
<tr align=center bgcolor=#C7D0F1><td>sobota</td><td>nedìle</td><td>svátek</td></tr>
<tr align=center><td><?echo round (($valueso/$so),1);?></td><td><?echo round (($valuene/$ne),1);?></td><td><?echo round (($valuesv/$sv),1);?></td></tr>
</table>
<td></td></tr>
<?}?>




<?}?>







<?if (@$menu=="Report Nemocnosti"){?>
<tr bgcolor="#C0FFC0"><td><center><b><?echo@$menu;?></b></center></td>
<td align=right>Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$_POST["obdobi"]<>""){?><option value="<?echo @$obdobi;?>"><?$obdobi1=explode("-",@$_POST["obdobi"]);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
@$data1 = mysql_query("select obdobi from zpracovana_dochazka group by obdobi order by obdobi DESC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<?if (@$_POST["obdobi"]<>"") {?><tr><td colspan=2><table border=1>
<tr bgcolor=#C7D0F1><td>Poøadí</td><td>Os.Èíslo</td><td>Pøíjmení a jméno</td><td>Kat.</td><td>Støedisko</td>
<?$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):
echo"<td align=center>".$dny."</td>";@$dny++;endwhile;echo"</tr>";

@$aktmesic="-".$obdobi1[1]."-";$aktobdobi=@$_POST["obdobi"]."-";$aktobdobidate=@$_POST["obdobi"]."-31";
include ("./"."dbconnect.php");$sdny1=mysql_query("select datum from svatky where ((datum like '%$aktmesic%' and typ='Trvalý' and stav='Aktivní') or (datum like '$aktobdobi%' and typ='Jedineèný' and stav='Aktivní') or (datum like '%$aktmesic%' and datumdo<='$aktobdobidate' and typ='Trvalý' and stav='Neaktivní')) order by datum");
@$load=0;$sden="/";while(@$load<mysql_num_rows($sdny1)): @$casti=explode ("-", mysql_result($sdny1,$load,0));$sden=$sden.@$casti[2]."/";@$load++;endwhile;

@$data1 = mysql_query("select zpracovana_dochazka.*,zamestnanci.prijmeni,zamestnanci.jmeno,zamestnanci.titul,zamestnanci.kategorie from zpracovana_dochazka left outer join zamestnanci ON zpracovana_dochazka.osobni_cislo=zamestnanci.osobni_cislo where zpracovana_dochazka.nazev_ukonu='nemoc' and zpracovana_dochazka.obdobi='".mysql_real_escape_string(@$_POST["obdobi"])."' order by zamestnanci.stredisko,zpracovana_dochazka.osobni_cislo,zamestnanci.prijmeni,zamestnanci.jmeno,zpracovana_dochazka.datum,zpracovana_dochazka.id ") or Die(MySQL_Error());
@$cykl=0;$lidi=0;while(@$cykl<mysql_num_rows($data1)):

$denr=explode("-", mysql_result($data1,@$cykl,5));$den=$denr[2];
$vykazano1=explode(":", mysql_result($data1,@$cykl,2));$vykazanoinmin=($vykazano1[0]*60)+$vykazano1[1];
$hodnota[mysql_result($data1,@$cykl,1).$den]=$hodnota[mysql_result($data1,@$cykl,1)]+$vykazanoinmin;

if (mysql_result($data1,@$cykl,1)<>mysql_result($data1,(@$cykl+1),1)) {@$lidi++;echo"<tr><td align=right>$lidi</td><td align=right>".mysql_result($data1,@$cykl,1)."</td><td>".mysql_result($data1,@$cykl,16)." ".mysql_result($data1,@$cykl,17)." ".mysql_result($data1,@$cykl,18)."</td><td align=center>".mysql_result($data1,@$cykl,19)."</td><td align=right>".mysql_result(mysql_query("select stredisko from zam_strediska where osobni_cislo='".securesql(mysql_result($data1,@$cykl,1))."' and ((datumod <='".securesql(@$_POST["obdobi"])."-31' and (datumdo>='".securesql(@$_POST["obdobi"])."-01' or datumdo='0000-00-00')) or datumod like '".securesql(@$_POST["obdobi"])."%') "),0,0)."</td>";
$dny=1;
while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):
if (@$dny<10) {$dny="0".$dny;}$datum=@$_POST["obdobi"]."-".$dny;
 if ($cdne= date("w", strtotime($datum))==6 or $cdne= date("w", strtotime($datum))==0 or StrPos (" " . $sden, "/".$dny."/")) {$barva="#F2D18E";} else {$barva="#EDB745";}
@$vypsat=round(($hodnota[mysql_result($data1,@$cykl,1).$dny]/60),2);if (@$vypsat==0) {@$vypsat="";}
echo"<td align=center bgcolor=$barva >".@$vypsat."</td>";
@$dny++;endwhile;echo"</tr>";}
@$cykl++;endwhile;?>
</table></td></tr><?}?>
<?}?>




<?if (@$menu=="Report Úrazù"){?>
<tr bgcolor="#C0FFC0"><td><center><b><?echo@$menu;?></b></center></td>
<td align=right>Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$_POST["obdobi"]<>""){?><option value="<?echo @$obdobi;?>"><?$obdobi1=explode("-",@$_POST["obdobi"]);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
@$data1 = mysql_query("select obdobi from zpracovana_dochazka group by obdobi order by obdobi DESC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<?if (@$_POST["obdobi"]<>"") {?><tr><td colspan=2><table border=1>
<tr bgcolor=#C7D0F1><td>Poøadí</td><td>Os.Èíslo</td><td>Pøíjmení a jméno</td><td>Kat.</td><td>Støedisko</td>
<?$dny=1;while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):
echo"<td align=center>".$dny."</td>";@$dny++;endwhile;echo"</tr>";

@$aktmesic="-".$obdobi1[1]."-";$aktobdobi=@$_POST["obdobi"]."-";$aktobdobidate=@$_POST["obdobi"]."-31";
include ("./"."dbconnect.php");$sdny1=mysql_query("select datum from svatky where ((datum like '%$aktmesic%' and typ='Trvalý' and stav='Aktivní') or (datum like '$aktobdobi%' and typ='Jedineèný' and stav='Aktivní') or (datum like '%$aktmesic%' and datumdo<='$aktobdobidate' and typ='Trvalý' and stav='Neaktivní')) order by datum");
@$load=0;$sden="/";while(@$load<mysql_num_rows($sdny1)): @$casti=explode ("-", mysql_result($sdny1,$load,0));$sden=$sden.@$casti[2]."/";@$load++;endwhile;

@$data1 = mysql_query("select zpracovana_dochazka.*,zamestnanci.prijmeni,zamestnanci.jmeno,zamestnanci.titul,zamestnanci.kategorie from zpracovana_dochazka left outer join zamestnanci ON zpracovana_dochazka.osobni_cislo=zamestnanci.osobni_cislo where zpracovana_dochazka.nazev_ukonu='pracovní úraz' and zpracovana_dochazka.obdobi='".mysql_real_escape_string(@$_POST["obdobi"])."' order by zamestnanci.stredisko,zamestnanci.prijmeni,zamestnanci.jmeno,zpracovana_dochazka.datum,zpracovana_dochazka.id ") or Die(MySQL_Error());
@$cykl=0;$lidi=0;while(@$cykl<mysql_num_rows($data1)):

$denr=explode("-", mysql_result($data1,@$cykl,5));$den=$denr[2];
$vykazano1=explode(":", mysql_result($data1,@$cykl,2));$vykazanoinmin=($vykazano1[0]*60)+$vykazano1[1];
$hodnota[mysql_result($data1,@$cykl,1).$den]=$hodnota[mysql_result($data1,@$cykl,1)]+$vykazanoinmin;

if (mysql_result($data1,@$cykl,1)<>mysql_result($data1,(@$cykl+1),1)) {@$lidi++;echo"<tr><td align=right>$lidi</td><td align=right>".mysql_result($data1,@$cykl,1)."</td><td>".mysql_result($data1,@$cykl,16)." ".mysql_result(mysql_query("select stredisko from zam_strediska where osobni_cislo='".securesql(mysql_result($data1,@$cykl,1))."' and ((datumod <='".securesql(@$_POST["obdobi"])."-31' and (datumdo>='".securesql(@$_POST["obdobi"])."-01' or datumdo='0000-00-00')) or datumod like '".securesql(@$_POST["obdobi"])."%') "),0,0)." ".mysql_result($data1,@$cykl,18)."</td><td align=center>".mysql_result($data1,@$cykl,19)."</td><td align=right>".mysql_result($data1,@$cykl,7)."</td>";
$dny=1;
while( @$dny< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):
if (@$dny<10) {$dny="0".$dny;}$datum=@$_POST["obdobi"]."-".$dny;
 if ($cdne= date("w", strtotime($datum))==6 or $cdne= date("w", strtotime($datum))==0 or StrPos (" " . $sden, "/".$dny."/")) {$barva="#F2D18E";} else {$barva="#EDB745";}
@$vypsat=round(($hodnota[mysql_result($data1,@$cykl,1).$dny]/60),2);if (@$vypsat==0) {@$vypsat="";}
echo"<td align=center bgcolor=$barva >".@$vypsat."</td>";
@$dny++;endwhile;echo"</tr>";}
@$cykl++;endwhile;?>
</table></td></tr><?}?>
<?}?>




<?if (@$menu=="Report Pøesèasù / 60%"){?>
<tr bgcolor="#C0FFC0"><td><center><b><?echo@$menu;?></b></center></td>
<td align=right>Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$_POST["obdobi"]<>""){?><option value="<?echo @$_POST["obdobi"];?>"><?$obdobi1=explode("-",@$_POST["obdobi"]);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
@$data1 = mysql_query("select obdobi from zpracovana_dochazka group by obdobi order by obdobi DESC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select> (v èasomíøe <input name="casomira" type="checkbox" <?if (@$_POST["casomira"]=="on") {echo"checked";}?> onclick=submit(this) >)</td></tr>

<?if (@$_POST["obdobi"]<>"") {?>
<tr><td colspan=2><table border=1 style=font-size:12pt>
<tr bgcolor=#C7D0F1><td>Poøadí</td><td>Os.Èíslo</td><td>Pøíjmení a jméno</td><td>Støedisko</td><td>Kat.</td><td>Pøesèas</td><td>60%</td><td>Konto Minulé Období</td><td>Do konta za tento mìsíc</td><td>Èerpání náhradního volna</td><td>Konto aktuální stav</td></tr>
<?@$lide=mysql_query("select * from zamestnanci where osobni_cislo in (select osobni_cislo from zpracovana_dochazka where (nazev_ukonu like '%pøesèas%' or nazev_ukonu like '%60%') and obdobi='".securesql(@$_POST["obdobi"])."') and jen_pruchod='NE' order by stredisko,prijmeni,jmeno,id ") or Die(MySQL_Error());
@$osoby=0;while(@$osoby<mysql_num_rows($lide)):
@$vysledek=0;
echo"<tr><td>".(@$osoby+1)."</td><td>".mysql_result($lide,@$osoby,1)."</td><td>".mysql_result($lide,@$osoby,4)." ".mysql_result($lide,@$osoby,3)." ".mysql_result($lide,@$osoby,2)."</td><td align=center>".mysql_result(mysql_query("select stredisko from zam_strediska where osobni_cislo='".securesql(mysql_result($lide,@$osoby,1))."' and ((datumod <='".securesql(@$_POST["obdobi"])."-31' and (datumdo>='".securesql(@$_POST["obdobi"])."-01' or datumdo='0000-00-00')) or datumod like '".securesql(@$_POST["obdobi"])."%') "),0,0)."</td><td align=center>".mysql_result($lide,@$osoby,18)."</td>";

$column=0;while($column<6):
@$cykl=0;$cas=0;

if (@$column==0) {@$volba="pøesèas";}
if (@$column==1) {@$volba="60%";}
if (@$column==2) {$cas=mysql_result(mysql_query("select konecny_stav from import_system where osobni_cislo='".securesql(mysql_result($lide,@$osoby,1))."' and obdobi='".securesql(@$_POST["obdobi"])."' "),0,0)*60;}
if (@$column==3) {@$volba="nadpracováno";}
if (@$column==4) {@$volba="èerpané";}



if (@$column<=1 or @$column==3 or @$column==4) {
@$data1 = mysql_query("select * from zpracovana_dochazka where osobni_cislo='".securesql(mysql_result($lide,@$osoby,1))."' and nazev_ukonu like '%$volba%' and obdobi='".securesql(@$_POST["obdobi"])."' order by id ") or Die(MySQL_Error());
while(@$cykl<mysql_num_rows($data1)):
$rozbor=explode (":", mysql_result($data1,@$cykl,2));
$cas=$cas+(($rozbor[0]*60)+$rozbor[1]);
@$cykl++;endwhile;}

if (@$column==2) {$vysledek=$cas;}
if (@$column==3) {$vysledek=$vysledek+$cas;}
if (@$column==4) {$vysledek=$vysledek-$cas;}
if (@$column==5) {$cas=@$vysledek;}

if (@$_POST["casomira"]=="on") {$ppr=floor(@$cas/60);$ppr1=$cas-(60*$ppr);if (@$ppr1<10 and @$ppr1>=0){@$ppr1="0".@$ppr1;}echo"<td align=center>".@$ppr.":".@$ppr1."</td>";}
if (@$_POST["casomira"]=="") {echo"<td align=center>".(@$cas/60)."</td>";}


@$column++;endwhile;echo"</tr>";

@$osoby++;endwhile;?>

</table></td></tr><?}?>

<?}?>







<?if (@$menu=="Práce na J.Støedisku"){?>
<tr bgcolor="#C0FFC0"><td><center><b><?echo@$menu;?></b></center></td>
<td align=right>Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$_POST["obdobi"]<>""){?><option value="<?echo @$_POST["obdobi"];?>"><?$obdobi1=explode("-",@$_POST["obdobi"]);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
@$data1 = mysql_query("select obdobi from zpracovana_dochazka group by obdobi order by obdobi DESC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select> (v èasomíøe <input name="casomira" type="checkbox" <?if (@$_POST["casomira"]=="on") {echo"checked";}?> onclick=submit(this) >)</td></tr>

<?if (@$_POST["obdobi"]<>"") {?>
<tr><td colspan=2><table border=1 style=font-size:12pt>
<tr bgcolor=#C7D0F1><td>Poøadí</td><td>Os.Èíslo</td><td>Pøíjmení a jméno</td><td>Støedisko</td><td>Kat.</td><?$strediska=mysql_query("select stredisko from zpracovana_dochazka where obdobi='".securesql(@$_POST["obdobi"])."' and nazev_ukonu like '%støedisku%' group by stredisko order by stredisko");$column=0;while($column<mysql_num_rows($strediska)):echo"<td>".mysql_result($strediska,$column,0)."</td>";@$column++;endwhile;echo"<td>SUMA</td></tr>";

@$lide=mysql_query("select zamestnanci.* from zamestnanci left outer join zpracovana_dochazka ON zamestnanci.osobni_cislo=zpracovana_dochazka.osobni_cislo where zpracovana_dochazka.nazev_ukonu like '%støedisku%' and zpracovana_dochazka.obdobi='".securesql(@$_POST["obdobi"])."' and zamestnanci.jen_pruchod='NE'  group by zamestnanci.osobni_cislo order by zamestnanci.stredisko,zamestnanci.prijmeni,zamestnanci.jmeno,zamestnanci.id ") or Die(MySQL_Error());

@$osoby=0;while(@$osoby<mysql_num_rows($lide)):
$vysledek=0;
echo"<tr><td>".(@$osoby+1)."</td><td>".mysql_result($lide,@$osoby,1)."</td><td>".mysql_result($lide,@$osoby,4)." ".mysql_result($lide,@$osoby,3)." ".mysql_result($lide,@$osoby,2)."</td><td align=center>".mysql_result(mysql_query("select stredisko from zam_strediska where osobni_cislo='".securesql(mysql_result($lide,@$osoby,1))."' and ((datumod <='".securesql(@$_POST["obdobi"])."-31' and (datumdo>='".securesql(@$_POST["obdobi"])."-01' or datumdo='0000-00-00')) or datumod like '".securesql(@$_POST["obdobi"])."%') "),0,0)."</td><td align=center>".mysql_result($lide,@$osoby,18)."</td>";


$data1=mysql_query("select * from zpracovana_dochazka where osobni_cislo='".securesql(mysql_result($lide,@$osoby,1))."' and obdobi='".securesql(@$_POST["obdobi"])."' and nazev_ukonu like '%støedisku%' order by stredisko,id");
$column=0;while($column<mysql_num_rows($data1)):

$rozbor=explode (":", mysql_result($data1,@$column,2));
$cas[mysql_result($data1,@$column,7)]=$cas[mysql_result($data1,@$column,7)]+(($rozbor[0]*60)+$rozbor[1]);
$vysledek=$vysledek+(($rozbor[0]*60)+$rozbor[1]);

@$column++;endwhile;

	$column=0;while($column<mysql_num_rows($strediska)):
	if (@$_POST["casomira"]=="on") {$ppr=floor(@$cas[mysql_result($strediska,$column,0)]/60);$ppr1=$cas[mysql_result($strediska,$column,0)]-(60*$ppr);if (@$ppr1<10 and @$ppr1>=0){@$ppr1="0".@$ppr1;}echo"<td align=center>".@$ppr.":".@$ppr1."</td>";$cas[mysql_result($strediska,$column,0)]=0;}
	if (@$_POST["casomira"]=="") {echo"<td align=center>".(@$cas[mysql_result($strediska,$column,0)]/60)."</td>";@$cas[mysql_result($strediska,$column,0)]=0;}
	@$column++;endwhile;
	if (@$_POST["casomira"]=="on") {$ppr=floor($vysledek/60);$ppr1=$vysledek-(60*$ppr);if (@$ppr1<10 and @$ppr1>=0){@$ppr1="0".@$ppr1;}echo"<td align=center>".@$ppr.":".@$ppr1."</td>";}
	if (@$_POST["casomira"]=="") {echo"<td>".($vysledek/60)."</td></tr>";}

@$osoby++;endwhile;?>

</table></td></tr><?}?>

<?}?>









<?}?>






</table></center>
</form>



