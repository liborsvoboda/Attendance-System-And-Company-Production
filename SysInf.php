<?session_start();
session_register("loginname");
session_register("prava");
if ($_SESSION["loginname"]<>"") {$loginname=$_SESSION["loginname"];
$prava=$_SESSION["prava"];}

@$oscislo=base64_decode(@$_GET["oscislo"]);if (@$oscislo=="") {@$oscislo=@$_POST["oscislo"];}
@$typ=base64_decode(@$_GET["typ"]);if (@$typ=="") {@$typ=@$_POST["typ"];}

@$obdobi=@$_POST["obdobi"];$pocetdni=date("t", strtotime($obdobi."-01"))+1;
@$info=@$_POST["info"];


@$dnes=date("Y-n-d");
@$dnescs=date("d.m.Y");

include ("./"."knihovna.php");
include ("./"."dbconnect.php");
@$karta1 = mysql_query("select * from zamestnanci where osobni_cislo='$oscislo'") or Die(MySQL_Error());
@$casti = explode(":", mysql_result($karta1,0,20));@$prachod=@$casti[0];@$pracmin=@$casti[1];@$pracdaymin=(@$prachod*60)+@$pracmin;

?>
<html>
<head>
<title><?echo " ".mysql_result($karta1,0,2)." ".mysql_result($karta1,0,3)." ".mysql_result($karta1,0,4)." / ".mysql_result($karta1,0,1);?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">

<!--// 3 ochrany proti navratu zpet, zmacknuti F5 jako reload, a zakaz praveho tlacitka mysi//-->
<SCRIPT LANGUAGE="JavaScript">
javascript:window.history.forward(1);
</SCRIPT>

<script language="JavaScript">
if (document.all){
document.onkeydown = function (){    var key_f5 = 116; // 116 = F5
if (key_f5==event.keyCode){ event.keyCode = 27;return false;}}}
</script>

<script language ="javascript">
function Disable() {
if (event.button == 2)
{
alert("Akce je Zak�z�na!! / Verbotene Aktion!!")
}}
document.onmousedown=Disable;
</script>


 <!--// skrolovani zpet na misto stranky odkud byl vyvolan reload jeste musi byt nastaven v body  onload="doScroll()" onunload="window.name=document.body.scrollTop"//-->
<script type="text/JavaScript">
function doScroll(){
  if (window.name) window.scrollTo(0, window.name);
}
</script>
</head>

<style type="text/css">
tr.menuon  {background-color:#F1BEED;}
tr.menuoff {background-color:#EDB745;}
</style>

<body bgcolor="#DEDCDC" text="BLACK" border=2 onload="doScroll()" onunload="window.name=document.body.scrollTop" style=margin:0px ><center>

<script type="text/JavaScript">
window.status='<?echo " ".mysql_result($karta1,0,2)." ".mysql_result($karta1,0,3)." ".mysql_result($karta1,0,4)." / ".mysql_result($karta1,0,1);?>';
window.resizeTo(900,600);
</script>

<form action="SysInf.php" method=post>
<input name="oscislo" type="hidden" value="<?echo@$oscislo;?>">

<table width=100%><tr>
<td width=40%>Vyber Obdob�:<select size="1" name="obdobi" onchange=submit(this)>
<?if (@$obdobi<>"") {echo"<option>".@$obdobi."</option>";} else {echo "<option>".date("Y-m")."</option>";@$obdobi=date("Y-m");}
$data1= mysql_query("select obdobi from zpracovana_dochazka where osobni_cislo='$oscislo' group by obdobi order by obdobi,id");
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if ((mysql_result($data1,@$cykl,0)<>@$obdobi and @$obdobi<>"") or (@$obdobi=="" and mysql_result($data1,@$cykl,0)<>date("Y-m"))) {echo"<option>".mysql_result($data1,@$cykl,0)."</option>";}
@$cykl++;endwhile;?>
</select></td>
<td align=center width=20%><button onClick="window.close()" >Zav��t Okno</button></td>
<td align=right width=40%>Vyber Informaci:
<select size="1" name="info" onchange=submit(this)>
<?if (@$info<>"") {echo"<option>".$info."</option>";} else {?><option><?echo @$info="STATUS";?></option><?}?>
<?if (@$info<>"STATUS") {?><option>STATUS</option><?}?>
<?if (@$info<>"Dovolen�") {?><option>Dovolen�</option><?}?>
<?if (@$info<>"Nadpracov�no / �erp�no") {?><option>Nadpracov�no / �erp�no</option><?}?>
<?if (@$info<>"P�es�as") {?><option>P�es�as</option><?}?>
<?if (@$info<>"Importovan� Hodnoty") {?><option>Importovan� Hodnoty</option><?}?>
<?if (@$info<>"Nemoc/�raz/O�R") {?><option>Nemoc/�raz/O�R</option><?}?>
</select></td>
</tr></table>




<table width=100% border=1 bgcolor="#EDB745" cellpadding="0" cellspacing="0" >

<? // telo
if (@$info=="Dovolen�") { // detailn� tabulka Dovolen�@$vysledek=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi='$obdobi' and nazev_ukonu='dovolen�' order by obdobi,datum,id");
?><tr><td colspan="<?echo@$pocetdni;?>" align=center bgcolor=#C0FFC0><b><?echo@$info;?> (hod)</b></td></tr>
<tr>
<?$cykl=1;
while( @$cykl< $pocetdni ):
if (@$cykl<10) {@$datum=$obdobi."-0".@$cykl;} else {@$datum=$obdobi."-".@$cykl;}  //tvorba datumu
$cdne= date("w", strtotime($datum));
$dsvatku=substr(@$datum,4,10);
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$datum' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trval�' and stav='Neaktivn�')) "),0,0);
if ($cdne>0 and $cdne<6 and $svatek=="") {$barva="#B4ADFC";}if ($cdne==0 or @$cdne==6){$barva="#FDCC5B";}if (@$svatek<>"") {$barva="#F7FBA4";}

echo"<td align=center bgcolor=".$barva." >".$cykl."</td>";
@$cykl++;endwhile;
?></tr><tr>
<?$cykl=1;
while( @$cykl< $pocetdni ):
if (@$cykl<10) {@$datum=$obdobi."-0".@$cykl;} else {@$datum=$obdobi."-".@$cykl;}  //tvorba datumu
$cdne= date("w", strtotime($datum));$dsvatku=substr(@$datum,4,10);
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$datum' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trval�' and stav='Neaktivn�')) "),0,0);
if ($cdne>0 and $cdne<6 and $svatek=="") {$barva="#B4ADFC";}if ($cdne==0 or @$cdne==6){$barva="#FDCC5B";}if (@$svatek<>"") {$barva="#F7FBA4";}

$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek)):
if (mysql_result($vysledek,@$vypis,5)==$datum) {@$casti = explode(":", mysql_result($vysledek,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;

if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;}echo"<td  width=".(100/@$pocetdni)."% align=center bgcolor=".$barva." >".$cas."</td>";$celkhodin=$celkhodin+$hodin;$celkminut=$celkminut+$minut;@$cas="";
@$cykl++;endwhile;
?></tr>
<?if (@$celkminut>=60) {$ppr=floor(@$celkminut/60);@$celkhodin=@$celkhodin+$ppr;@$celkminut=@$celkminut-($ppr*60);if (@$celkminut<10 and @$celkminut<>""){@$celkminut="0".@$celkminut;}}
if (@$celkhodin<>"" or @$celkminut<>"") {if (strlen(@$celkminut)==1){@$celkminut="0".@$celkminut;}$celkcas=$celkhodin.":".$celkminut;}
?>
<tr><td colspan=10>Celkem �erp�no</td><td colspan="<?echo@$pocetdni-10;?>" align=right><?echo@$celkcas." hod";?></td></tr>
</table><br /><br />



<!--//cely rok//-->
<?@$celkcas="";@$celkhodin="";@$celkminut="";?>
<table width=100% border=1 bgcolor="#EDB745" cellpadding="0" cellspacing="0" >
<tr><td colspan="<?echo@$pocetdni;?>" align=center bgcolor=#C0FFC0><b><?echo@$info;?> za Cel� Rok (dny)</b></td></tr>
<?$rok=substr(@$datum,0,4)."-";
@$vysledek=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi like '$rok%' and nazev_ukonu='dovolen�' order by obdobi,datum,id");
?>
<tr bgcolor=#B4ADFC><?
@$cykl=1;while( @$cykl< 13 ):
echo"<td align=center>".$cykl."</td>";
@$cykl++;endwhile;?></tr>

<tr bgcolor=#B4ADFC><?
@$cykl=1;while( @$cykl< 13 ):
if (@$cykl<10) {$datum=@$rok."0".@$cykl;} else {$datum=@$rok.@$cykl;}

$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek)):
if (mysql_result($vysledek,@$vypis,6)==$datum) {@$casti = explode(":", mysql_result($vysledek,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;

if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;$dny=((($hodin*60)+$minut)/@$pracdaymin)." dny";}

// zadat v echu cas =hodiny , nebo dny

echo"<td width=100/12% align=center>".$dny."</td>";$celkhodin=$celkhodin+$hodin;$celkminut=$celkminut+$minut;@$cas="";$dny="";
@$cykl++;endwhile;?></tr>
<tr><td colspan=6>Celkem �erp�no</td>
<?
// zadat v echu celkcas =hodiny , nebo celkdny
if (@$celkminut>=60) {$ppr=floor(@$celkminut/60);@$celkhodin=@$celkhodin+$ppr;@$celkminut=@$celkminut-($ppr*60);if (@$celkminut<10 and @$celkminut<>""){@$celkminut="0".@$celkminut;}}
if (@$celkhodin<>"" or @$celkminut<>"") {if (strlen(@$celkminut)==1){@$celkminut="0".@$celkminut;}$celkcas=$celkhodin.":".$celkminut;$celkdny=((($celkhodin*60)+$celkminut)/@$pracdaymin)." dny";}?>
<td colspan=6 align=right><?echo@$celkdny."";?></td></tr></table><br /><br />

<? // nacist importy dovolene / sumarni tabulka
$staradovolena=mysql_result(mysql_query("select stara_dovolena from import_system where osobni_cislo='$oscislo' order by obdobi desc,id desc"),0,0);
$novadovolena=mysql_result(mysql_query("select (celkova_dovolena-stara_dovolena) from import_system where osobni_cislo='$oscislo' order by obdobi desc,id desc"),0,0);;
@$celkemdovolena=@$staradovolena+@$novadovolena;@$celkemdovolenamin=@$celkemdovolena*@$pracdaymin;
$cerpanomin=(@$celkhodin*60)+@$celkminut;$zustatekinmin=@$celkemdovolenamin-@$cerpanomin;
@$zustatek=@$zustatekinmin/@$pracdaymin;

if ($staradovolena*@$pracdaymin>=$cerpanomin) {@$cerpst=@$cerpanomin/@$pracdaymin;@$cerpnv="0";}
if ($staradovolena*@$pracdaymin<$cerpanomin) {@$cerpst=$staradovolena;@$cerpnv=($cerpanomin-($staradovolena*@$pracdaymin))/@$pracdaymin;}

?>
<table border=1 bgcolor="#EDB745" cellpadding="0" cellspacing="0" >

<tr bgcolor=#B4ADFC><td colspan=4 align=center><b>Ro�n� Sum�� Dovolen�</b></td></tr>
<tr bgcolor=#B4ADFC><td>Pracovn� Doba <?echo mysql_result($karta1,0,20);?></td><td align=center width=100>na Za�.Roku</td><td width=100 align=center>�erp�n�</td><td width=100 align=center bgcolor=#F8F289>Akt. Z�statek</td></tr>
<tr><td>Star� Dovolen�</td><td align=right width=100><?echo@$staradovolena;?> Dn�</td><td align=right><?echo@$cerpst;?> Dn�</td><td align=right bgcolor=#F8F289><?echo (@$staradovolena-@$cerpst);?> Dn�</td></tr>
<tr><td>Nov� Dovolen�</td><td align=right width=100><?echo@$novadovolena;?> Dn�</td><td align=right><?echo@$cerpnv;?> Dn�</td><td align=right bgcolor=#F8F289><?echo (@$novadovolena-@$cerpnv);?> Dn�</td></tr>
<tr bgcolor=#F8F289><td>Celkem</td><td align=right width=100><?echo (@$staradovolena+@$novadovolena);?> Dn�</td><td align=right width=100><?echo (@$cerpst+@$cerpnv);?> Dn�</td><td align=right width=100><?echo @$zustatek;?> Dn�</td></tr>
</table>
<?}





if (@$info=="Importovan� Hodnoty") { // detailn� tabulka importovan�ch hodnot
@$casti = explode("-", $obdobi);$rok=@$casti[0];$data1= mysql_query("select * from import_system where osobni_cislo='$oscislo' and obdobi like '$rok%' order by obdobi,id");
?><tr><td colspan="8" align=center bgcolor=#C0FFC0><b><?echo@$info." v roce: <font color=#BB3711>".$rok."</font>";?></b></td></tr>
<tr align=center bgcolor=#C4C0FE><td>Po�ad�</td><td>Obdob�</td><td>Star� Dovolen�</td><td>Celkem Dovolen�</td><td>Celkem P�es�as</td><td>Po��te�n� Stav</td><td>Pl�novan� Harmonogram</td><td>Datum Importu</td></tr>
<?@$cykl=0;while (@$cykl<mysql_num_rows($data1)): $casti= explode ("-", mysql_result($data1,@$cykl,8));$casti1= explode (".", mysql_result($data1,@$cykl,6));$casti2= explode (".", mysql_result($data1,@$cykl,5));
echo "<tr align=center><td>".($cykl+1)."</td><td>".mysql_result($data1,@$cykl,2)."</td><td>".mysql_result($data1,@$cykl,3)."</td><td>".mysql_result($data1,@$cykl,4)."</td><td>".@$casti2[0].":".((@$casti2[1]/100)*60)."</td><td>".@$casti1[0].":".((@$casti1[1]/100)*60)."</td><td>".mysql_result($data1,@$cykl,9)."</td><td>".@$casti[2].".".@$casti[1].".".@$casti[0]."</td><tr>";
@$cykl++;endwhile;
}






if (@$info=="Nadpracov�no / �erp�no") { // detailn� tabulka Dovolen�
@$vysledek=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi='$obdobi' and nazev_ukonu like '%nadpracov�no%' order by obdobi,datum,id");
@$vysledek1=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi='$obdobi' and nazev_ukonu like '%�erpan� volno%' order by obdobi,datum,id");
@$vysledek2=mysql_query("select konecny_stav from import_system where osobni_cislo='$oscislo' and obdobi='$obdobi' order by obdobi,id");
?><tr><td colspan="<?echo@$pocetdni;?>" align=center bgcolor=#C0FFC0><b><?echo@$info;?> (hod.)</b></td></tr>
<tr>
<?$cykl=1;
while( @$cykl< $pocetdni ):
if (@$cykl<10) {@$datum=$obdobi."-0".@$cykl;} else {@$datum=$obdobi."-".@$cykl;}  //tvorba datumu
$cdne= date("w", strtotime($datum));
$dsvatku=substr(@$datum,4,10);
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$datum' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trval�' and stav='Neaktivn�')) "),0,0);
if ($cdne>0 and $cdne<6 and $svatek=="") {$barva="#B4ADFC";}if ($cdne==0 or @$cdne==6){$barva="#FDCC5B";}if (@$svatek<>"") {$barva="#F7FBA4";}

echo"<td align=center bgcolor=".$barva." >".$cykl."</td>";
@$cykl++;endwhile;
?></tr><tr>
<?$cykl=1;
while( @$cykl< $pocetdni ):
if (@$cykl<10) {@$datum=$obdobi."-0".@$cykl;} else {@$datum=$obdobi."-".@$cykl;}  //tvorba datumu
$cdne= date("w", strtotime($datum));$dsvatku=substr(@$datum,4,10);
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$datum' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trval�' and stav='Neaktivn�')) "),0,0);
if ($cdne>0 and $cdne<6 and $svatek=="") {$barva="#B4ADFC";}if ($cdne==0 or @$cdne==6){$barva="#FDCC5B";}if (@$svatek<>"") {$barva="#F7FBA4";}

$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek)):
if (mysql_result($vysledek,@$vypis,5)==$datum) {@$casti = explode(":", mysql_result($vysledek,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;

if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;}echo"<td  width=".(100/@$pocetdni)."% align=center bgcolor=".$barva." >".$cas."</td>";$celkhodin=$celkhodin+$hodin;$celkminut=$celkminut+$minut;@$cas="";
@$cykl++;endwhile;
?></tr><tr>
<?$cykl=1;
while( @$cykl< $pocetdni ):
if (@$cykl<10) {@$datum=$obdobi."-0".@$cykl;} else {@$datum=$obdobi."-".@$cykl;}  //tvorba datumu
$cdne= date("w", strtotime($datum));$dsvatku=substr(@$datum,4,10);
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$datum' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trval�' and stav='Neaktivn�')) "),0,0);
if ($cdne>0 and $cdne<6 and $svatek=="") {$barva="#B4ADFC";}if ($cdne==0 or @$cdne==6){$barva="#FDCC5B";}if (@$svatek<>"") {$barva="#F7FBA4";}

$vypis=0;@$chodin="";@$cminut="";while($vypis<mysql_num_rows($vysledek1)):
if (mysql_result($vysledek1,@$vypis,5)==$datum) {@$casti = explode(":", mysql_result($vysledek1,@$vypis,2));@$chodin=@$chodin+@$casti[0];@$cminut=@$cminut+@$casti[1];if (@$cminut>=60) {$ppr=floor(@$cminut/60);@$chodin=@$chodin+$ppr;@$cminut=@$cminut-($ppr*60);}}
@$vypis++;endwhile;

if (@$chodin<>"" or @$cminut<>"") {if (strlen(@$cminut)==1){@$cminut="0".@$cminut;}$ccas=$chodin.":".$cminut;}echo"<td  width=".(100/@$pocetdni)."% align=center bgcolor=".$barva." >".$ccas."</td>";$ccelkhodin=$ccelkhodin+$chodin;$ccelkminut=$ccelkminut+$cminut;@$ccas="";
@$cykl++;endwhile;
?></tr>
<?if (@$celkminut>=60) {$ppr=floor(@$celkminut/60);@$celkhodin=@$celkhodin+$ppr;@$celkminut=@$celkminut-($ppr*60);}
if (@$celkminut<0) {@$celkhodin=@$celkhodin-1;@$celkminut=60-@$celkminut;}if (@$celkminut<10 and @$celkminut<>""){@$celkminut="0".@$celkminut;}
if (@$celkhodin==""  and @$celkminut=="") {@$celkhodin=0;@$celkminut="0";}
if (@$celkhodin<>"" or @$celkminut<>"") {if (strlen(@$celkminut)==1){@$celkminut="0".@$celkminut;}$celkcas=$celkhodin.":".$celkminut;}

if (@$ccelkminut>=60) {$ppr=floor(@$ccelkminut/60);@$ccelkhodin=@$ccelkhodin+$ppr;@$ccelkminut=@$ccelkminut-($ppr*60);if (@$ccelkminut<10 and @$ccelkminut<>""){@$ccelkminut="0".@$ccelkminut;}}
if (@$ccelkhodin<>"" or @$ccelkminut<>"") {if (strlen(@$ccelkminut)==1){@$ccelkminut="0".@$ccelkminut;}$ccelkcas=$ccelkhodin.":".$ccelkminut;}

@$casti= explode (".", mysql_result($vysledek2,0,0));if (@$casti[0]=="") {@$casti[0]=0;}if (@$casti[1]=="") {@$casti[1]=0;}if (StrPos (" " . mysql_result($vysledek2,0,0), "-")) {@$casti[1]=-@$casti[1];}
@$zrozdilinmin=(((@$casti[0]+@$celkhodin)*60)+((@$casti[1]/100)*60)+@$celkminut)-((@$ccelkhodin*60)+@$ccelkminut);
if (@$zrozdilinmin>=0) {$ppr=floor(@$zrozdilinmin/60);} else {$ppr="-".floor(-@$zrozdilinmin/60);}
@$zhod=$ppr;
if (@$zrozdilinmin>=0) {@$zmin=$zrozdilinmin-($ppr*60);} else {@$zmin=$zrozdilinmin-($ppr*60);@$zmin=-@$zmin;}
if (strlen(@$zmin)==1) {@$zmin="0".@$zmin;}if (strlen(@$zmin)==0) {@$zmin="00";}
@$ztime=$zhod.":".$zmin;


if ($casti[1]<0) {$casti[1]=-$casti[1];}?>
<tr><td colspan=10>PS + Celkem Nadpracov�no</td><td colspan="<?echo@$pocetdni-10;?>" align=right><?echo @$casti[0].":".((@$casti[1]/100)*60)." + ".@$celkcas." hod";?></td></tr>
<tr><td colspan=10>Celkem �erp�no</td><td colspan="<?echo@$pocetdni-10;?>" align=right><?echo@$ccelkcas." hod";?></td></tr>
<tr><td colspan=10>Z�statek</td><td colspan="<?echo@$pocetdni-10;?>" align=right><?echo @$nakonec=@$ztime." hod";?></td></tr>
</table><br /><br />



<!--//cely rok//-->
<?@$celkcas="";@$celkhodin="";@$celkminut="";@$ccelkcas="";@$ccelkhodin="";@$ccelkminut="";?>
<table width=100% border=1 bgcolor="#EDB745" cellpadding="0" cellspacing="0" >
<tr><td colspan="<?echo@$pocetdni;?>" align=center bgcolor=#C0FFC0><b><?echo@$info;?> za Cel� Rok (hod.)</b></td></tr>
<?$rok=substr(@$datum,0,4)."-";
@$vysledek=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi like '$rok%' and nazev_ukonu like '%nadpracov�no%' order by obdobi,datum,id");
@$vysledek1=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi like '$rok%' and nazev_ukonu like '%�erpan� volno%' order by obdobi,datum,id");
?>
<tr bgcolor=#B4ADFC><?
@$cykl=1;while( @$cykl< 13 ):
echo"<td align=center>".$cykl."</td>";
@$cykl++;endwhile;?></tr>

<tr bgcolor=#B4ADFC><?
@$cykl=1;while( @$cykl< 13 ):
if (@$cykl<10) {$datum=@$rok."0".@$cykl;} else {$datum=@$rok.@$cykl;}
$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek)):
if (mysql_result($vysledek,@$vypis,6)==$datum) {@$casti = explode(":", mysql_result($vysledek,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;
if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;}
echo"<td width=100/12% align=center>".$cas."</td>";$celkhodin=$celkhodin+$hodin;$celkminut=$celkminut+$minut;@$cas="";
@$cykl++;endwhile;?></tr><tr bgcolor=#B4ADFC><?
@$cykl=1;while( @$cykl< 13 ):
if (@$cykl<10) {$datum=@$rok."0".@$cykl;} else {$datum=@$rok.@$cykl;}
$vypis=0;@$chodin="";@$cminut="";while($vypis<mysql_num_rows($vysledek1)):
if (mysql_result($vysledek1,@$vypis,6)==$datum) {@$casti = explode(":", mysql_result($vysledek1,@$vypis,2));@$chodin=@$chodin+@$casti[0];@$cminut=@$cminut+@$casti[1];if (@$cminut>=60) {$ppr=floor(@$cminut/60);@$chodin=@$chodin+$ppr;@$cminut=@$cminut-($ppr*60);}}
@$vypis++;endwhile;
if (@$chodin<>"" or @$cminut<>"") {if (strlen(@$cminut)==1){@$cminut="0".@$cminut;}$ccas=$chodin.":".$cminut;}
echo"<td width=100/12% align=center>".$ccas."</td>";$ccelkhodin=$ccelkhodin+$chodin;$ccelkminut=$ccelkminut+$cminut;@$ccas="";
@$cykl++;endwhile;?></tr>


<tr><td colspan=6>Celkem Nadpracov�no</td><?
if (@$celkminut>=60) {$ppr=floor(@$celkminut/60);@$celkhodin=@$celkhodin+$ppr;@$celkminut=@$celkminut-($ppr*60);if (@$celkminut<10 and @$celkminut<>""){@$celkminut="0".@$celkminut;}}
if (@$celkhodin<>"" or @$celkminut<>"") {if (strlen(@$celkminut)==1){@$celkminut="0".@$celkminut;}$celkcas=$celkhodin.":".$celkminut;}?>
<td colspan=6 align=right><?echo@$celkcas."";?></td></tr>
<tr><td colspan=6>Celkem �erp�no</td><?
if (@$ccelkminut>=60) {$ppr=floor(@$ccelkminut/60);@$ccelkhodin=@$ccelkhodin+$ppr;@$ccelkminut=@$ccelkminut-($ppr*60);if (@$ccelkminut<10 and @$ccelkminut<>""){@$ccelkminut="0".@$ccelkminut;}}
if (@$ccelkhodin<>"" or @$ccelkminut<>"") {if (strlen(@$ccelkminut)==1){@$ccelkminut="0".@$ccelkminut;}$ccelkcas=$ccelkhodin.":".$ccelkminut;}?>
<td colspan=6 align=right><?echo@$ccelkcas."";?></td></tr></table><br />

<?if (@$obdobi==date("Y-m")) {?>
<table border=1 bgcolor="#EDB745" cellpadding="0" cellspacing="0" >
<tr bgcolor=#C0FFC0><td align=center><b>Aktu�ln� k Dispozici</b></td></tr>
<tr bgcolor=#B4ADFC><td align=center><?echo @$nakonec;?></td>
</tr></table><?}?>
<?}





if (@$info=="P�es�as") { // detailn� tabulka P�es�asu
@$vysledek=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi='$obdobi' and nazev_ukonu like '%p�es�as%' order by obdobi,datum,id");
?><tr><td colspan="<?echo@$pocetdni;?>" align=center bgcolor=#C0FFC0><b><?echo@$info;?> (hod.)</b></td></tr>
<tr>
<?$cykl=1;
while( @$cykl< $pocetdni ):
if (@$cykl<10) {@$datum=$obdobi."-0".@$cykl;} else {@$datum=$obdobi."-".@$cykl;}  //tvorba datumu
$cdne= date("w", strtotime($datum));
$dsvatku=substr(@$datum,4,10);
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$datum' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trval�' and stav='Neaktivn�')) "),0,0);
if ($cdne>0 and $cdne<6 and $svatek=="") {$barva="#B4ADFC";}if ($cdne==0 or @$cdne==6){$barva="#FDCC5B";}if (@$svatek<>"") {$barva="#F7FBA4";}

echo"<td align=center bgcolor=".$barva." >".$cykl."</td>";
@$cykl++;endwhile;
?></tr><tr>
<?$cykl=1;
while( @$cykl< $pocetdni ):
if (@$cykl<10) {@$datum=$obdobi."-0".@$cykl;} else {@$datum=$obdobi."-".@$cykl;}  //tvorba datumu
$cdne= date("w", strtotime($datum));$dsvatku=substr(@$datum,4,10);
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$datum' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trval�' and stav='Neaktivn�')) "),0,0);
if ($cdne>0 and $cdne<6 and $svatek=="") {$barva="#B4ADFC";}if ($cdne==0 or @$cdne==6){$barva="#FDCC5B";}if (@$svatek<>"") {$barva="#F7FBA4";}

$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek)):
if (mysql_result($vysledek,@$vypis,5)==$datum) {@$casti = explode(":", mysql_result($vysledek,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;

if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;}echo"<td  width=".(100/@$pocetdni)."% align=center bgcolor=".$barva." >".$cas."</td>";$celkhodin=$celkhodin+$hodin;$celkminut=$celkminut+$minut;@$cas="";
@$cykl++;endwhile;
?></tr>

<?if (@$celkminut>=60) {$ppr=floor(@$celkminut/60);@$celkhodin=@$celkhodin+$ppr;@$celkminut=@$celkminut-($ppr*60);if (@$celkminut<10 and @$celkminut<>""){@$celkminut="0".@$celkminut;}}
if (@$celkhodin<>"" or @$celkminut<>"") {if (strlen(@$celkminut)==1){@$celkminut="0".@$celkminut;}$celkcas=$celkhodin.":".$celkminut;}
?>
<tr><td colspan=10>Celkem P�es�as</td><td colspan="<?echo@$pocetdni-10;?>" align=right><?echo @$nakonec=@$celkcas." hod";?></td></tr>
</table><br /><br />



<!--//cely rok//-->
<?@$celkcas="";@$celkhodin="";@$celkminut="";@$ccelkcas="";@$ccelkhodin="";@$ccelkminut="";?>
<table width=100% border=1 bgcolor="#EDB745" cellpadding="0" cellspacing="0" >
<tr><td colspan="<?echo@$pocetdni;?>" align=center bgcolor=#C0FFC0><b><?echo@$info;?> za Cel� Rok (hod.)</b></td></tr>
<?$rok=substr(@$datum,0,4)."-";
@$vysledek=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi like '$rok%' and nazev_ukonu like '%p�es�as%' order by obdobi,datum,id");
?>
<tr bgcolor=#B4ADFC><?
@$cykl=1;while( @$cykl< 13 ):
echo"<td align=center>".$cykl."</td>";
@$cykl++;endwhile;?></tr>

<tr bgcolor=#B4ADFC><?
@$cykl=1;while( @$cykl< 13 ):
if (@$cykl<10) {$datum=@$rok."0".@$cykl;} else {$datum=@$rok.@$cykl;}
$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek)):
if (mysql_result($vysledek,@$vypis,6)==$datum) {@$casti = explode(":", mysql_result($vysledek,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;
if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;}
echo"<td width=100/12% align=center>".$cas."</td>";$celkhodin=$celkhodin+$hodin;$celkminut=$celkminut+$minut;@$cas="";
@$cykl++;endwhile;?></tr>


<tr><td colspan=6>Celkem P�es�as</td><?
if (@$celkminut>=60) {$ppr=floor(@$celkminut/60);@$celkhodin=@$celkhodin+$ppr;@$celkminut=@$celkminut-($ppr*60);if (@$celkminut<10 and @$celkminut<>""){@$celkminut="0".@$celkminut;}}
if (@$celkhodin<>"" or @$celkminut<>"") {if (strlen(@$celkminut)==1){@$celkminut="0".@$celkminut;}$celkcas=$celkhodin.":".$celkminut;}?>
<td colspan=6 align=right><?echo@$celkcas."";?></td></tr>
</table><br />




<table border=1 bgcolor="#EDB745" cellpadding="0" cellspacing="0" >
<tr bgcolor=#C0FFC0><td align=center><b>K Proplacen� za vybran� Obdob�</b></td></tr>
<tr bgcolor=#B4ADFC><td align=center><?echo @$nakonec;?></td>
</tr>
</table>
<?}




if (@$info=="STATUS") { // STATUS
?><tr><td colspan="<?echo@$pocetdni;?>" align=center bgcolor=#C0FFC0><b><?echo@$info;?></b></td></tr>
<tr><td><?@$zamestnanec=$oscislo;include ("./"."infocard.php");?></td></tr>
<?}








if (@$info=="Nemoc/�raz/O�R") { // detailn� tabulka nemoci
@$vysledek=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi='$obdobi' and nazev_ukonu = 'nemoc' order by obdobi,datum,id");
@$vysledek1=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi='$obdobi' and nazev_ukonu = 'pracovn� �raz' order by obdobi,datum,id");
@$vysledek2=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi='$obdobi' and nazev_ukonu = 'O�R' order by obdobi,datum,id");
?><tr><td colspan="<?echo@$pocetdni;?>" align=center bgcolor=#C0FFC0><b><?echo@$info;?> (hod.)</b></td></tr>
<tr>
<?$cykl=1;
while( @$cykl< $pocetdni ):
if (@$cykl<10) {@$datum=$obdobi."-0".@$cykl;} else {@$datum=$obdobi."-".@$cykl;}  //tvorba datumu
$cdne= date("w", strtotime($datum));
$dsvatku=substr(@$datum,4,10);
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$datum' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trval�' and stav='Neaktivn�')) "),0,0);
if ($cdne>0 and $cdne<6 and $svatek=="") {$barva="#B4ADFC";}if ($cdne==0 or @$cdne==6){$barva="#FDCC5B";}if (@$svatek<>"") {$barva="#F7FBA4";}

echo"<td align=center bgcolor=".$barva." >".$cykl."</td>";
@$cykl++;endwhile;
?></tr><tr>
<?$cykl=1;
while( @$cykl< $pocetdni ):
if (@$cykl<10) {@$datum=$obdobi."-0".@$cykl;} else {@$datum=$obdobi."-".@$cykl;}  //tvorba datumu
$cdne= date("w", strtotime($datum));$dsvatku=substr(@$datum,4,10);
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$datum' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trval�' and stav='Neaktivn�')) "),0,0);
if ($cdne>0 and $cdne<6 and $svatek=="") {$barva="#B4ADFC";}if ($cdne==0 or @$cdne==6){$barva="#FDCC5B";}if (@$svatek<>"") {$barva="#F7FBA4";}

$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek)):
if (mysql_result($vysledek,@$vypis,5)==$datum) {@$casti = explode(":", mysql_result($vysledek,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;
if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;} else {@$cas=" . ";}echo"<td  width=".(100/@$pocetdni)."% align=center bgcolor=".$barva." >".$cas."</td>";$celkhodin=$celkhodin+$hodin;$celkminut=$celkminut+$minut;@$cas="";
@$cykl++;endwhile;
?></tr>

<tr>
<?$cykl=1;
while( @$cykl< $pocetdni ):
if (@$cykl<10) {@$datum=$obdobi."-0".@$cykl;} else {@$datum=$obdobi."-".@$cykl;}  //tvorba datumu
$cdne= date("w", strtotime($datum));$dsvatku=substr(@$datum,4,10);
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$datum' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trval�' and stav='Neaktivn�')) "),0,0);
if ($cdne>0 and $cdne<6 and $svatek=="") {$barva="#B4ADFC";}if ($cdne==0 or @$cdne==6){$barva="#FDCC5B";}if (@$svatek<>"") {$barva="#F7FBA4";}

$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek1)):
if (mysql_result($vysledek1,@$vypis,5)==$datum) {@$casti = explode(":", mysql_result($vysledek1,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;

if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;} else {@$cas=" . ";}echo"<td  width=".(100/@$pocetdni)."% align=center bgcolor=".$barva." >".$cas."</td>";$celkhodin1=$celkhodin1+$hodin;$celkminut1=$celkminut1+$minut;@$cas="";
@$cykl++;endwhile;
?></tr>

<tr>
<?$cykl=1;
while( @$cykl< $pocetdni ):
if (@$cykl<10) {@$datum=$obdobi."-0".@$cykl;} else {@$datum=$obdobi."-".@$cykl;}  //tvorba datumu
$cdne= date("w", strtotime($datum));$dsvatku=substr(@$datum,4,10);
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$datum' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trval�' and stav='Neaktivn�')) "),0,0);
if ($cdne>0 and $cdne<6 and $svatek=="") {$barva="#B4ADFC";}if ($cdne==0 or @$cdne==6){$barva="#FDCC5B";}if (@$svatek<>"") {$barva="#F7FBA4";}

$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek2)):
if (mysql_result($vysledek2,@$vypis,5)==$datum) {@$casti = explode(":", mysql_result($vysledek2,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;

if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;} else {@$cas=" . ";}echo"<td  width=".(100/@$pocetdni)."% align=center bgcolor=".$barva." >".$cas."</td>";$celkhodin2=$celkhodin2+$hodin;$celkminut2=$celkminut2+$minut;@$cas="";
@$cykl++;endwhile;
?></tr>



<?if (@$celkminut>=60) {$ppr=floor(@$celkminut/60);@$celkhodin=@$celkhodin+$ppr;@$celkminut=@$celkminut-($ppr*60);if (@$celkminut<10 and @$celkminut<>""){@$celkminut="0".@$celkminut;}}
if (@$celkhodin<>"" or @$celkminut<>"") {if (strlen(@$celkminut)==1){@$celkminut="0".@$celkminut;}$celkcas=$celkhodin.":".$celkminut;}?>
<tr><td colspan=10>Celkem Nemoc</td><td colspan="<?echo@$pocetdni-10;?>" align=right><?echo @$nakonec=@$celkcas." Hod.";?></td></tr>

<?if (@$celkminut1>=60) {$ppr=floor(@$celkminut1/60);@$celkhodin1=@$celkhodin1+$ppr;@$celkminut1=@$celkminut1-($ppr*60);if (@$celkminut1<10 and @$celkminut1<>""){@$celkminut1="0".@$celkminut1;}}
if (@$celkhodin1<>"" or @$celkminut1<>"") {if (strlen(@$celkminut1)==1){@$celkminut1="0".@$celkminut1;}$celkcas1=$celkhodin1.":".$celkminut1;}?>
<tr><td colspan=10>Celkem Pracovn� �raz</td><td colspan="<?echo@$pocetdni-10;?>" align=right><?echo @$nakonec1=@$celkcas1." Hod.";?></td></tr>

<?if (@$celkminut2>=60) {$ppr=floor(@$celkminut2/60);@$celkhodin2=@$celkhodin2+$ppr;@$celkminut2=@$celkminut2-($ppr*60);if (@$celkminut2<10 and @$celkminut2<>""){@$celkminut2="0".@$celkminut2;}}
if (@$celkhodin2<>"" or @$celkminut2<>"") {if (strlen(@$celkminut2)==1){@$celkminut2="0".@$celkminut2;}$celkcas2=$celkhodin2.":".$celkminut2;}?>
<tr><td colspan=10>Celkem O�R</td><td colspan="<?echo@$pocetdni-10;?>" align=right><?echo @$nakonec2=@$celkcas2." Hod.";?></td></tr>
</table><br /><br />



<!--//cely rok//-->
<?@$celkcas="";@$celkhodin="";@$celkminut="";@$celkhodin1="";@$celkminut1="";@$celkhodin2="";@$celkminut2="";@$ccelkcas="";@$ccelkhodin="";@$ccelkminut="";?>
<table width=100% border=1 bgcolor="#EDB745" cellpadding="0" cellspacing="0" >
<tr><td colspan="<?echo@$pocetdni;?>" align=center bgcolor=#C0FFC0><b><?echo@$info;?> za Cel� Rok (hod.)</b></td></tr>
<?$rok=substr(@$datum,0,4)."-";
@$vysledek=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi like '$rok%' and nazev_ukonu = 'nemoc' order by obdobi,datum,id");
@$vysledek1=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi like '$rok%' and nazev_ukonu ='pracovn� �raz' order by obdobi,datum,id");
@$vysledek2=mysql_query("select * from zpracovana_dochazka where osobni_cislo='$oscislo' and obdobi like '$rok%' and nazev_ukonu ='O�R' order by obdobi,datum,id");
?>
<tr bgcolor=#B4ADFC><?
@$cykl=1;while( @$cykl< 13 ):
echo"<td align=center>".$cykl."</td>";
@$cykl++;endwhile;?></tr>

<tr bgcolor=#B4ADFC><?
@$cykl=1;while( @$cykl< 13 ):
if (@$cykl<10) {$datum=@$rok."0".@$cykl;} else {$datum=@$rok.@$cykl;}
$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek)):
if (mysql_result($vysledek,@$vypis,6)==$datum) {@$casti = explode(":", mysql_result($vysledek,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;
if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;}
echo"<td width=100/12% align=center>".$cas."</td>";$celkhodin=$celkhodin+$hodin;$celkminut=$celkminut+$minut;@$cas="";
@$cykl++;endwhile;?></tr>

<tr bgcolor=#B4ADFC><?
@$cykl=1;while( @$cykl< 13 ):
if (@$cykl<10) {$datum=@$rok."0".@$cykl;} else {$datum=@$rok.@$cykl;}
$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek1)):
if (mysql_result($vysledek1,@$vypis,6)==$datum) {@$casti = explode(":", mysql_result($vysledek1,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;
if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;}
echo"<td width=100/12% align=center>".$cas."</td>";$celkhodin1=$celkhodin1+$hodin;$celkminut1=$celkminut1+$minut;@$cas="";
@$cykl++;endwhile;?></tr>

<tr bgcolor=#B4ADFC><?
@$cykl=1;while( @$cykl< 13 ):
if (@$cykl<10) {$datum=@$rok."0".@$cykl;} else {$datum=@$rok.@$cykl;}
$vypis=0;@$hodin="";@$minut="";while($vypis<mysql_num_rows($vysledek2)):
if (mysql_result($vysledek2,@$vypis,6)==$datum) {@$casti = explode(":", mysql_result($vysledek2,@$vypis,2));@$hodin=@$hodin+@$casti[0];@$minut=@$minut+@$casti[1];if (@$minut>=60) {$ppr=floor(@$minut/60);@$hodin=@$hodin+$ppr;@$minut=@$minut-($ppr*60);}}
@$vypis++;endwhile;
if (@$hodin<>"" or @$minut<>"") {if (strlen(@$minut)==1){@$minut="0".@$minut;}$cas=$hodin.":".$minut;}
echo"<td width=100/12% align=center>".$cas."</td>";$celkhodin2=$celkhodin2+$hodin;$celkminut2=$celkminut2+$minut;@$cas="";
@$cykl++;endwhile;?></tr>



<tr><td colspan=6>Celkem Nemoc</td><?
if (@$celkminut>=60) {$ppr=floor(@$celkminut/60);@$celkhodin=@$celkhodin+$ppr;@$celkminut=@$celkminut-($ppr*60);if (@$celkminut<10 and @$celkminut<>""){@$celkminut="0".@$celkminut;}}
if (@$celkhodin<>"" or @$celkminut<>"") {if (strlen(@$celkminut)==1){@$celkminut="0".@$celkminut;}$celkcas=$celkhodin.":".$celkminut;}?>
<td colspan=6 align=right><?echo@$celkcas." Hod.";?></td></tr>

<tr><td colspan=6>Celkem Pracovn� �raz</td><?
if (@$celkminut1>=60) {$ppr=floor(@$celkminut1/60);@$celkhodin1=@$celkhodin1+$ppr;@$celkminut1=@$celkminut1-($ppr*60);if (@$celkminut1<10 and @$celkminut1<>""){@$celkminut1="0".@$celkminut1;}}
if (@$celkhodin1<>"" or @$celkminut1<>"") {if (strlen(@$celkminut1)==1){@$celkminut1="0".@$celkminut1;}$celkcas1=$celkhodin1.":".$celkminut1;}?>
<td colspan=6 align=right><?echo@$celkcas1." Hod.";?></td></tr>

<tr><td colspan=6>Celkem O�R</td><?
if (@$celkminut2>=60) {$ppr=floor(@$celkminut2/60);@$celkhodin2=@$celkhodin2+$ppr;@$celkminut2=@$celkminut2-($ppr*60);if (@$celkminut2<10 and @$celkminut2<>""){@$celkminut2="0".@$celkminut2;}}
if (@$celkhodin2<>"" or @$celkminut2<>"") {if (strlen(@$celkminut2)==1){@$celkminut2="0".@$celkminut2;}$celkcas2=$celkhodin2.":".$celkminut2;}?>
<td colspan=6 align=right><?echo@$celkcas2." Hod.";?></td></tr>
</table><br />

<?}

//  konec t�la
?>





</form></center></body>

</html>