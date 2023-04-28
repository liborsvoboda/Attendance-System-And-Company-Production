<?
//  menu
@$menu=@$_REQUEST["menu"];
@$obdobi=@$_REQUEST["obdobi"];
@$souhrn=@$_REQUEST["souhrn"];

include ("./"."dbconnect.php");



?>

<form action="hlavicka.php?akce=<?echo base64_encode('FakturaceObedu');?>" method=post>

<h2><p align="center">Reporty odbìru Obìdù:
<select name=menu size="1" onchange=submit(this)>
<option><?if (@$menu<>""){echo@$menu;}?></option>
<? if (StrPos (" " . $_SESSION["prava"], "C")){
   if (@$menu<>"Export Odbìru Obìdù"){echo"<option>Export Odbìru Obìdù</option>";}
   if (@$menu<>"Pøehled Exportù Odbìru Obìdù"){echo"<option>Pøehled Exportù Odbìru Obìdù</option>";}
}
   if (StrPos (" " . $_SESSION["prava"], "c")){
   if (@$menu<>"Pøehled Objednávek"){echo"<option>Pøehled Objednávek</option>";}
   if (@$menu<>"Pøehled Objednaných Obìdù"){echo"<option>Pøehled Objednaných Obìdù</option>";}
}?>
</select> </p></h2>









<? if (!StrPos (" " . $_SESSION["prava"], "C") and !StrPos (" " . $_SESSION["prava"], "c")){?>Nemáte Pøístupová Práva<?}?>
<center><table  bgcolor="#EDB745" border=2 frame="border" rules=all>




<? if (StrPos (" " . $_SESSION["prava"], "C")){?>







<?if (@$menu=="Export Odbìru Obìdù"){?>

<tr bgcolor="#C0FFC0"><td colspan=<?if (@$souhrn=="on") {echo"1";}if (@$souhrn<>"on") {echo"3";}?> ><center><b><?echo@$menu;?> </b>

<select size="1" name="manager" onchange=submit(this)><?
if (@$_REQUEST["manager"]=="" or @$_REQUEST["manager"]=="Zamìstnanci")  {echo"<option>Zamìstnanci</option><option>Manageøi</option>";}
if (@$_REQUEST["manager"]=="Manageøi")  {echo"<option>Manageøi</option><option>Zamìstnanci</option>";}?>
</select></center></td>

<td align=right> Období:<select size="1" name="obdobi" onchange=submit(this)>

<?
if (@$obdobi) {echo"<option>".@$obdobi."</option>";} else {echo"<option></option>";}
$data2=mysql_query("select datum from objednavky_obedu order by datum DESC") or Die(MySQL_Error());
$cykl=0;while(@$cykl<mysql_num_rows($data2)):


if (substr(mysql_result($data2,$cykl,0),0,7)<>substr(mysql_result($data2,($cykl+1),0),0,7) and substr(mysql_result($data2,$cykl,0),0,7)<>@$obdobi) {echo "<option>".substr(mysql_result($data2,$cykl,0),0,7)."</option>";}
@$cykl++;endwhile;?></select></td>

<td> Souhrn: <input name="souhrn" type="checkbox" onclick=submit(this) <?if (@$souhrn=="on") {echo"checked";}?> ></td></tr>
<?
if (@$obdobi){
// vyber jednotlivce
echo"<tr bgcolor=#C0FFC0 align=center style=font-weight:bold >";if (@$_REQUEST["manager"]=="" or @$_REQUEST["manager"]=="Zamìstnanci")  {$manager="NE";} else {$manager="ANO";}
	if (@$souhrn<>"on") {echo"<td>Osobní Èíslo</td><td>";echo"<select size=1 name=osoba onchange=submit(this) >";if (@$_POST["osoba"]<>"" and @$_POST["osoba"]<>"Všichni") {echo "<option value='".securesql(@$_POST["osoba"])."' >".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(@$_POST["osoba"])."' "),0,0)."</option>";$dotaz=" and objednavky_obedu.osobni_cislo='".securesql(@$_POST["osoba"])."' ";} echo"<option>Všichni</option>";
	$data4=mysql_query("select objednavky_obedu.osobni_cislo from objednavky_obedu left outer join zamestnanci ON objednavky_obedu.osobni_cislo = zamestnanci.osobni_cislo where objednavky_obedu.datum like '".securesql($obdobi)."%' and zamestnanci.manager='".securesql($manager)."' group by objednavky_obedu.osobni_cislo order by objednavky_obedu.osobni_cislo,objednavky_obedu.id") or Die(MySQL_Error());
	@$cykl=0;while(@$cykl<mysql_num_rows(@$data4)):
	if (mysql_result($data4,$cykl,0)<>@$_POST["osoba"]) {echo "<option value=".mysql_result($data4,$cykl,0)." >".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(mysql_result($data4,$cykl,0))."' "),0,0)."</option>";}
	@$cykl++;endwhile;echo"</select>";echo"</td><td>Datum</td><td>Obìd</td><td>Cena</td></tr>";}

	if (@$souhrn=="on") {echo"<td>Osobní Èíslo</td><td>";echo"<select size=1 name=osoba onchange=submit(this) >";if (@$_POST["osoba"]<>"" and @$_POST["osoba"]<>"Všichni") {echo "<option value='".securesql(@$_POST["osoba"])."' >".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(@$_POST["osoba"])."' "),0,0)."</option>";$dotaz=" and objednavky_obedu.osobni_cislo='".securesql(@$_POST["osoba"])."' ";} echo"<option>Všichni</option>";
	$data4=mysql_query("select objednavky_obedu.osobni_cislo from objednavky_obedu left outer join zamestnanci ON objednavky_obedu.osobni_cislo = zamestnanci.osobni_cislo where objednavky_obedu.datum like '".securesql($obdobi)."%' and zamestnanci.manager='".securesql($manager)."' group by objednavky_obedu.osobni_cislo order by objednavky_obedu.osobni_cislo,objednavky_obedu.id") or Die(MySQL_Error());
	@$cykl=0;while(@$cykl<mysql_num_rows(@$data4)):
	if (mysql_result($data4,$cykl,0)<>@$_POST["osoba"]) {echo "<option value=".mysql_result($data4,$cykl,0)." >".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(mysql_result($data4,$cykl,0))."' "),0,0)."</option>";}
	@$cykl++;endwhile;echo"</select>";echo"</td><td>Cena</td>";}
echo"</tr>";


$data1=mysql_query("select objednavky_obedu.id,objednavky_obedu.osobni_cislo,date_format(objednavky_obedu.datum,'%d.%m.%Y'),objednavky_obedu.skupina,objednavky_obedu.obed,objednavky_obedu.cena,objednavky_obedu.priloha,objednavky_obedu.vedlejsi_strava from objednavky_obedu left outer join zamestnanci ON objednavky_obedu.osobni_cislo = zamestnanci.osobni_cislo where objednavky_obedu.datum like '".securesql($obdobi)."%' $dotaz and zamestnanci.manager='".securesql($manager)."' order by objednavky_obedu.osobni_cislo,objednavky_obedu.datum,objednavky_obedu.id") or Die(MySQL_Error());
$cykl=0;while(@$cykl<mysql_num_rows($data1)):

$jmeno=mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(mysql_result($data1,$cykl,1))."' "),0,0);
@$vedlejsi=explode("+:+",mysql_result($data1,$cykl,7));

if (@$souhrn=="on") {$cena=$cena+mysql_result($data1,$cykl,5)+@$vedlejsi[2];$cenao=$cenao+mysql_result($data1,$cykl,5)+@$vedlejsi[2];}

if (@$souhrn=="on" and mysql_result($data1,$cykl,1)<>mysql_result($data1,($cykl+1),1)) {	if (@$_GET["save"]<>""){$telo.=mysql_result($data1,$cykl,1).";".@$obdobi.";".@$cenao.";\r\n";}
	echo"<tr><td>".mysql_result($data1,$cykl,1)."</td><td>".@$jmeno."</td><td align=right>".@$cenao." Kè</td></tr>";$cenao=0;}

if (@$souhrn<>"on") {	if (@$_GET["save"]<>""){$telo.=mysql_result($data1,$cykl,1).";".@$obdobi.";".(mysql_result($data1,$cykl,5)+@$vedlejsi[2]).";\r\n";}
	echo"<tr><td>".mysql_result($data1,$cykl,1)."</td><td>".@$jmeno."</td><td align=center>".mysql_result($data1,$cykl,2)."</td><td align=center><b>".mysql_result($data1,$cykl,3)."</b>-".mysql_result($data1,$cykl,4);if (mysql_result($data1,$cykl,6)) {echo"<br /><b>Jiná Pøíloha:".mysql_result($data1,$cykl,6)."</b>";}if (@$vedlejsi[1]){echo"<br /><b>".@$vedlejsi[0]."</b> - ".@$vedlejsi[1];}echo"</td><td align=right>".(mysql_result($data1,$cykl,5)+@$vedlejsi[2])." Kè</td></tr>";$cena=$cena+mysql_result($data1,$cykl,5)+@$vedlejsi[2];}

@$cykl++;endwhile;

// ulozeni souboru
if (@$_REQUEST["manager"]=="" or @$_REQUEST["manager"]=="Zamìstnanci") {$soubor="Obedy/ObedyZamestnanci".$obdobi.".csv";}
if (@$_REQUEST["manager"]=="Manageøi") {$soubor="Obedy/ObedyManageri".$obdobi.".csv";}
if (@$_GET["save"]<>""){
$sestava="OSC;OBDOBI;CENA;\r\n".$telo;
$f=fopen($soubor,"w");
fwrite($f,"$sestava");fclose($f);?>
<script type="text/javascript">
alert("Uložení Exportu Obìdù za Období <?echo@$obdobi;?> Probìhlo Úspìšnì");
</script>
<?}
// konec Ulozeni


IF(File_Exists($soubor))   {?>
<script type="text/javascript">
function Export(){
	if (confirm('Chcete Pøepsat Exportované Soubory Obìdù za Období: <?echo @$obdobi;?> ?')) {window.location.href('hlavicka.php?akce=<?echo base64_encode('FakturaceObedu');?>&obdobi=<?echo @$obdobi;?>&menu=<?echo $menu;?>&souhrn=<?echo @$souhrn;?>&save=ok&manager=<?echo @$_REQUEST["manager"];?>');}
	else {alert("Uložení Exportù Bylo Zrušeno");}
}
</script>
<?} else {?>
<script type="text/javascript">
function Export(){
	if (confirm('Chcete Exporty Obìdù za Období <?echo @$obdobi;?> Skuteènì Uložit?')) {window.location.href('hlavicka.php?akce=<?echo base64_encode('FakturaceObedu');?>&obdobi=<?echo @$obdobi;?>&menu=<?echo $menu;?>&souhrn=<?echo @$souhrn;?>&save=ok&manager=<?echo @$_REQUEST["manager"];?>');}
	else {alert("Uložení Exportù Bylo Zrušeno");}
}
</script>
<?}

echo"<tr bgcolor=#A89FF4><td>";
if (@$_POST["osoba"]=="" or @$_POST["osoba"]=="Všichni") {echo"<input type=button value=Exportovat onclick=Export(); style=width:100%>";}echo"</td><td colspan=";if (@$souhrn=="on") {echo"1";}if (@$souhrn<>"on") {echo"3";}echo">Cena Celkem:</td><td align=right>".$cena." Kè</td></tr>";}

}






if (@$menu=="Pøehled Exportù Odbìru Obìdù"){?>
<tr bgcolor="#B4ADFC"><td colspan=3><center><b><?echo@$menu;?></b></center></td>
<td align=right>Rok: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$obdobi<>""){?><option value="<?echo @$obdobi;?>"><?$obdobi1=explode("-",$obdobi);echo $obdobi1[0];?></option><?}?><option></option><?
@$celek="Je";@$export="Je";
@$data1 = mysql_query("select date_format(datum,'%Y') from objednavky_obedu  order by datum,id ASC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi and substr(mysql_result($data1,@$cykl,0),0,4)<>substr(mysql_result($data1,@$cykl-1,0),0,4)){?><option value="<?echo substr(mysql_result($data1,@$cykl,0),0,4);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<?$slozka = dir("Obedy");@$cykl=0;
while($soubory=$slozka->read()) {if (@$obdobi=="") {@$obdobi=".";}
if ($soubory<>"." and $soubory<>".." and StrPos (" " . $soubory, $obdobi)) {
@$cykl++;
echo "<tr><td colspan=3> ".$cykl." </td><td align=right width=200> <a href=\"Obedy/$soubory\" target=_blank>".$soubory."</a> </td></tr>";}}
$slozka->close();
}









}?>



<? if (StrPos (" " . $_SESSION["prava"], "C") or StrPos (" " . $_SESSION["prava"], "c")){




if (@$menu=="Pøehled Objednávek"){?>
<form action="hlavicka.php?akce=<?echo base64_encode('FakturaceObedu');?>" method=post>
<tr bgcolor="#C0FFC0"><td colspan=<?if (@$_POST["obdobi"]){echo"5";} else {echo"4";}?> ><center><b><?echo@$menu;?> </b></center></td></tr>
<tr bgcolor=#A89FF4><td colspan=2 align=left>Den: <select name=obdobi size=1 onchange=submit(this) >
<? if (strlen(@$_POST["obdobi"])==10) {echo"<option>".@$_POST["obdobi"]."</option>";} else {echo "<option></option>";}
@$data1=mysql_query("select date_format(datum,'%d.%m.%Y') from objednavky_obedu group by datum order by datum DESC,id") or Die(MySQL_Error());
@$cykl=0;while($cykl<mysql_num_rows(@$data1)):
if (@$_POST["obdobi"]<>mysql_result($data1,$cykl,0)) {echo"<option>".mysql_result($data1,$cykl,0)."</option>";}
$cykl++;endwhile;?></select></td></form>

<form action="hlavicka.php?akce=<?echo base64_encode('FakturaceObedu');?>" method=post>
<input name="menu" type="hidden" value="<?echo @$menu;?>">
<td align=center>Mìsíc: <select name=obdobi size=1 onchange=submit(this) >
<? if (strlen(@$_POST["obdobi"])==7) {echo"<option>".@$_POST["obdobi"]."</option>";} else {echo "<option></option>";}
@$data1=mysql_query("select date_format(datum,'%m.%Y') from objednavky_obedu group by date_format(datum,'%m.%Y') order by date_format(datum,'%m.%Y') DESC,id") or Die(MySQL_Error());
@$cykl=0;while($cykl<mysql_num_rows(@$data1)):
if (@$_POST["obdobi"]<>mysql_result($data1,$cykl,0)) {echo"<option>".mysql_result($data1,$cykl,0)."</option>";}
$cykl++;endwhile;?></select></td></form>

<form action="hlavicka.php?akce=<?echo base64_encode('FakturaceObedu');?>" method=post>
<input name="menu" type="hidden" value="<?echo @$menu;?>">
<td align=right>Rok: <select name=obdobi size=1 onchange=submit(this) >
<? if (strlen(@$_POST["obdobi"])==4) {echo"<option>".@$_POST["obdobi"]."</option>";} else {echo "<option></option>";}
@$data1=mysql_query("select date_format(datum,'%Y') from objednavky_obedu group by date_format(datum,'%Y') order by date_format(datum,'%Y') DESC,id") or Die(MySQL_Error());
@$cykl=0;while($cykl<mysql_num_rows(@$data1)):
if (@$_POST["obdobi"]<>mysql_result($data1,$cykl,0)) {echo"<option>".mysql_result($data1,$cykl,0)."</option>";}
$cykl++;endwhile;?></select></td></form>

<?if (@$_POST["obdobi"]){?><td>
<form action="hlavicka.php?akce=<?echo base64_encode('FakturaceObedu');?>" method=post>
<input name="menu" type="hidden" value="<?echo @$menu;?>"><input name="obdobi" type="hidden" value="<?echo @$_POST["obdobi"];?>">
<select name=skupina size=1 style=width:100px onchange=submit(this) ><?
if (@$_POST["skupina"]) {echo"<option>".@$_POST["skupina"]."</option>";} else {echo"<option>Skupiny</option>";}
$data1=mysql_result(mysql_query("select hodnota from setting where nazev='Obìdy'"),0,0);$seznam=explode("/",$data1);$skupiny=explode(",",$seznam[1]);
@$cykl=1;while(@$skupiny[$cykl]):
if (@$_POST["skupina"]<>$skupiny[$cykl]) {echo"<option>".$skupiny[$cykl]."</option>";}
@$cykl++;endwhile;?>
</select></td></form><?}?></tr>

<style type="text/css">
tr.menuon  {background-color:#F1BEED;}
tr.menuoff {background-color:#EDB745;}
</style>
<?
//  prehled objednavek vsechny skupiny
if (@$_POST["obdobi"] and (@$_POST["skupina"]=="" or @$_POST["skupina"]=="Skupiny")){echo"<tr bgcolor=#A89FF4 align=center><td colspan=3><b>Skupina</b></td><td colspan=2><b>Poèet</b></td></tr>";$data1=mysql_query("select * from objednavky_obedu where date_format(datum,'%d.%m.%Y') like '%".@$_POST["obdobi"]."' order by skupina,priloha,id") or Die(MySQL_Error());
@$ps=0;@$cykl=0;$pocet=0;while(@$cykl<mysql_num_rows($data1)): $pocet++;
@$vedlejsi=explode("+:+",mysql_result($data1,@$cykl,12));
if (@$vedlejsi[0]=="PS") {@$ps++;}
if (mysql_result($data1,@$cykl,3)<>mysql_result($data1,(@$cykl+1),3) or
(mysql_result($data1,@$cykl,3)==mysql_result($data1,(@$cykl+1),3) and mysql_result($data1,@$cykl,11)<>mysql_result($data1,(@$cykl+1),11))) {echo"<tr onmouseover=className='menuon'; onmouseout=className='menuoff'; align=center><td colspan=3>".mysql_result($data1,@$cykl,3);if (mysql_result($data1,@$cykl,11)<>"") {echo" s: ".mysql_result($data1,(@$cykl),11);}echo"</td><td colspan=2>".$pocet."</td></tr>";$pocet=0;}
@$cykl++;endwhile;
if (@$ps) {echo"<tr onmouseover=className='menuon'; onmouseout=className='menuoff'; align=center><td colspan=3>PS</td><td colspan=2>".$ps."</td></tr>";}
}



if (@$_POST["obdobi"] and @$_POST["skupina"]<>"" and @$_POST["skupina"]<>"Skupiny"){
echo"<tr bgcolor=#A89FF4 align=center colspan=2><td><b>Osobní Èíslo</b></td><td><b>Pøíjmení Jméno</b></td><td><b>Datum</b></td><td><b>Obìd</b></td><td><b>Cena</b></td></tr>";
$data1=mysql_query("select id,osobni_cislo,date_format(datum,'%d.%m.%Y'),skupina,obed,cena,priloha,vedlejsi_strava from objednavky_obedu where date_format(datum,'%d.%m.%Y') like '%".@$_POST["obdobi"]."' and (skupina='".securesql(@$_POST["skupina"])."' or vedlejsi_strava like '".securesql(@$_POST["skupina"])."+:+%') order by osobni_cislo,datum,id") or Die(MySQL_Error());
@$cykl=0;$pocet=0;while(@$cykl<mysql_num_rows($data1)):
if (@$_POST["skupina"]<>"PS") {echo"<tr onmouseover=className='menuon'; onmouseout=className='menuoff'; align=center><td>".mysql_result($data1,@$cykl,1)."</td>
<td>".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(mysql_result($data1,$cykl,1))."' "),0,0)."</td>
<td>".mysql_result($data1,@$cykl,2)."</td><td><b>".mysql_result($data1,@$cykl,3)."</b> - ".mysql_result($data1,@$cykl,4);
if (mysql_result($data1,@$cykl,6)){echo"<br /><b>Jiná Pøíloha: ".mysql_result($data1,@$cykl,6)."</b>";}echo"</td><td>".mysql_result($data1,@$cykl,5)."</td></tr>";}

else {@$vedjlejsi=explode("+:+",mysql_result($data1,@$cykl,7));
echo"<tr onmouseover=className='menuon'; onmouseout=className='menuoff'; align=center><td>".mysql_result($data1,@$cykl,1)."</td>
<td>".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(mysql_result($data1,$cykl,1))."' "),0,0)."</td>
<td>".mysql_result($data1,@$cykl,2)."</td><td><b>".$vedjlejsi[0]."</b> - ".$vedjlejsi[1]."</td><td>".$vedjlejsi[2]."</td></tr>";}

@$cykl++;endwhile;}


}





if (@$menu=="Pøehled Objednaných Obìdù"){?>

<tr bgcolor="#C0FFC0"><td colspan=<?if (@$souhrn=="on") {echo"1";}if (@$souhrn<>"on") {echo"3";}?> ><center><b><?echo@$menu;?> </b></center></td>
<td align=right> Období:<select size="1" name="obdobi" onchange=submit(this)>

<?
if (@$obdobi) {echo"<option>".@$obdobi."</option>";} else {echo"<option></option>";}
$data2=mysql_query("select datum from objednavky_obedu order by datum DESC") or Die(MySQL_Error());
$cykl=0;while(@$cykl<mysql_num_rows($data2)):


if (substr(mysql_result($data2,$cykl,0),0,7)<>substr(mysql_result($data2,($cykl+1),0),0,7) and substr(mysql_result($data2,$cykl,0),0,7)<>@$obdobi) {echo "<option>".substr(mysql_result($data2,$cykl,0),0,7)."</option>";}
@$cykl++;endwhile;?></select>

Den: <select size="1" name="den" onchange=submit(this)>
<?if (@$_POST["den"]){echo"<option>".@$_POST["den"]."</option><option></option>";} else {echo "<option></option>";}

$cykl=1;
while( @$cykl< date("t", strtotime($obdobi."-01"))+1 ):
if (@$cykl<10) {echo "<option>0".$cykl."</option>";} else {echo "<option>".$cykl."</option>";}
@$cykl++;endwhile;?>

</select></td>
<td colspan=2 align=right> Souhrn: <input name="souhrn" type="checkbox" onclick=submit(this) <?if (@$souhrn=="on") {echo"checked";}?> ></td></tr>
<?
if (@$obdobi){

// vyber jednotlivce
echo"<tr bgcolor=#C0FFC0 align=center style=font-weight:bold >"; $obdobi1=$obdobi."-".@$_POST["den"];
	if (@$souhrn<>"on") {echo"<td>Osobní Èíslo</td><td>";echo"<select size=1 name=osoba onchange=submit(this) >";if (@$_POST["osoba"]<>"" and @$_POST["osoba"]<>"Všichni") {echo "<option value='".securesql(@$_POST["osoba"])."' >".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(@$_POST["osoba"])."' "),0,0)."</option>";$dotaz=" and osobni_cislo='".securesql(@$_POST["osoba"])."' ";} echo"<option>Všichni</option>";
	$data4=mysql_query("select osobni_cislo from objednavky_obedu where datum like '".securesql($obdobi1)."%' group by osobni_cislo order by osobni_cislo,id") or Die(MySQL_Error());
	@$cykl=0;while(@$cykl<mysql_num_rows(@$data4)):
	if (mysql_result($data4,$cykl,0)<>@$_POST["osoba"]) {echo "<option value=".mysql_result($data4,$cykl,0)." >".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(mysql_result($data4,$cykl,0))."' "),0,0)."</option>";}
	@$cykl++;endwhile;echo"</select>";echo"</td><td>Datum</td><td>Obìd</td><td>Stav</td><td>Cena</td></tr>";}

	if (@$souhrn=="on") {echo"<td>Osobní Èíslo</td><td>";echo"<select size=1 name=osoba onchange=submit(this) >";if (@$_POST["osoba"]<>"" and @$_POST["osoba"]<>"Všichni") {echo "<option value='".securesql(@$_POST["osoba"])."' >".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(@$_POST["osoba"])."' "),0,0)."</option>";$dotaz=" and osobni_cislo='".securesql(@$_POST["osoba"])."' ";} echo"<option>Všichni</option>";
	$data4=mysql_query("select osobni_cislo from objednavky_obedu where datum like '".securesql($obdobi1)."%' group by osobni_cislo order by osobni_cislo,id") or Die(MySQL_Error());
	@$cykl=0;while(@$cykl<mysql_num_rows(@$data4)):
	if (mysql_result($data4,$cykl,0)<>@$_POST["osoba"]) {echo "<option value=".mysql_result($data4,$cykl,0)." >".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(mysql_result($data4,$cykl,0))."' "),0,0)."</option>";}
	@$cykl++;endwhile;echo"</select>";echo"</td><td>Stav</td><td>Cena</td>";}
echo"</tr>";


$data1=mysql_query("select id,osobni_cislo,date_format(datum,'%d.%m.%Y'),skupina,obed,cena,priloha,vedlejsi_strava,stav from objednavky_obedu where datum like '".securesql($obdobi1)."%' $dotaz order by osobni_cislo,datum,id") or Die(MySQL_Error());
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
@$vedlejsi=explode("+:+",mysql_result($data1,$cykl,7));

$jmeno=mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(mysql_result($data1,$cykl,1))."' "),0,0);

if (@$souhrn=="on") {$cena=$cena+mysql_result($data1,$cykl,5)+@$vedlejsi[2];$cenao=$cenao+mysql_result($data1,$cykl,5)+@$vedlejsi[2];}

if (@$souhrn=="on" and mysql_result($data1,$cykl,1)<>mysql_result($data1,($cykl+1),1)) {echo"<tr><td>".mysql_result($data1,$cykl,1)."</td><td>".@$jmeno."</td><td align=center>".mysql_result($data1,$cykl,8)."</td><td align=right>".@$cenao." Kè</td></tr>";$cenao=0;}

if (@$souhrn<>"on") {echo"<tr><td>".mysql_result($data1,$cykl,1)."</td><td>".@$jmeno."</td><td align=center>".mysql_result($data1,$cykl,2)."</td><td align=center><b>".mysql_result($data1,$cykl,3)."</b>-".mysql_result($data1,$cykl,4);
if (mysql_result($data1,$cykl,6)) {echo "<br /><b>Jiná Pøíloha: ".mysql_result($data1,$cykl,6)."</b>";}if (@$vedlejsi[0]){echo"<br /><b>".@$vedlejsi[0]."</b>-".@$vedlejsi[1];}echo"</td><td align=center>".mysql_result($data1,$cykl,8)."</td><td align=right>".(mysql_result($data1,$cykl,5)+@$vedlejsi[2])." Kè</td></tr>";$cena=$cena+mysql_result($data1,$cykl,5)+@$vedlejsi[2];}

@$cykl++;endwhile;
echo"<tr bgcolor=#A89FF4><td><input type=button value=Tisk onclick=\"window.open('TiskOdebranychObedu.php?obdobi=".@$obdobi1."&osoba=".@$_POST["osoba"]."&souhrn=".@$souhrn."');\" style=width:100%></td><td colspan=";if (@$souhrn=="on") {echo"2";}if (@$souhrn<>"on") {echo"4";}echo">Cena Celkem:</td><td align=right>".$cena." Kè</td></tr>";
}
}

}?>




</table></center>
</form>



