<html>
<head>
<title>Výdej Obědů</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

   <?php
    $u_agent = $_SERVER['HTTP_USER_AGENT'];$ub = '';
    if(preg_match('/MSIE/i',$u_agent)) {$ub = "ie";}
    elseif(preg_match('/Firefox/i',$u_agent)) {$ub = "firefox";}
    elseif(preg_match('/Safari/i',$u_agent)) {$ub = "safari";}
    elseif(preg_match('/Chrome/i',$u_agent)) {$ub = "chrome";}
    elseif(preg_match('/Flock/i',$u_agent)) {$ub = "flock";}
    elseif(preg_match('/Opera/i',$u_agent)) {$ub = "opera";}





@$dnes=date("Y-m-d");
@$cas=StrFTime("%H:%M:%S", Time());
@$dnescs=date("d.m.Y");

include ("./"."dbconnect.php");

@$timetype=mysql_result(mysql_query("select hodnota from setting where nazev='Čas'"),0,0);
include ("./"."Onumlock$timetype.php");
include ("./"."knihovna.php");

if (@$_POST["oscislo"]<>"") {$oscislo=@$_POST["oscislo"];}

if (mysql_result(mysql_query("select hodnota from setting where nazev='Snímač' "),0,0)=="Windows") {@$osnumber=@$_GET["osnumber"];}
if (mysql_result(mysql_query("select hodnota from setting where nazev='Snímač' "),0,0)=="Linux") {@$osnumber=@$_GET["osnumber"];}
// prevod cisla na spravny pin

?>
 <!--//zakaz oznaceni / vybrani textu//-->
<SCRIPT language="JavaScript">
// Internet Explorer:
if (document.all)
  document.onselectstart =
    function () { return false; };
// Netscape 4:
if (document.layers) {
  document.captureEvents(Event.MOUSEDOWN);
  document.onmousedown =
    function (evt) { return false; };
}
// Netscape 6:
document.onmousedown = function () { return false; };
</script>

<!--// 3 ochrany proti navratu zpet, zmacknuti F5 jako reload, a zakaz praveho tlacitka mysi//-->
<SCRIPT LANGUAGE="JavaScript">
javascript:window.history.forward(0);
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
alert("Akce je Zakázána!! / Verbotene Aktion!!")
}}
document.onmousedown=Disable;
</script>

</head>


<body onload="updateClock(); setInterval('updateClock()', 1000 );" bgcolor="#E6AD6F" style=margin:0;overflow:hidden;>
<center><table width=100% style=margin:0 cellpadding="0" cellspacing="0" border=0px>
<tr bgcolor=#E6AD6F style=margin:0><td colspan=2 align=center><span style=font-size:50pt><b>VÝDEJ OBĚDŮ</b></span></td></tr>
<tr><td colspan=2 align=center><div id="clock" style=width:100%;font-size:60pt>&nbsp;</div></td></tr>

<?

// nacteni osobniho cisla
if ($osnumber<>"") {@$oscislo= @mysql_result(mysql_query("select osobni_cislo from cipy where (cip='".securesql($osnumber)."' and platnostod<='$dnes' and (platnostdo='0000-00-00' or platnostdo>='$dnes')) "),0,0);if ($oscislo=="") {$pokus="false";}}

// overeni prava
if (@$oscislo<>"") {if (@mysql_result(mysql_query("select id from objednavky_obedu where (osobni_cislo='".securesql($oscislo)."' or tr_osobni_cislo='".securesql($oscislo)."') and datum='$dnes'"),0,0)<>""){$pravo="ANO";} else {$pravo="NE";}
//if (@$pravo=="NE") {$pravo=@mysql_result(mysql_query("select obed from zamestnanci where (osobni_cislo='".securesql($oscislo)."' and datumin<='$dnes' and (datumout='0000-00-00' or datumout>='$dnes')) "),0,0);}
}

// vypis informaci k osobnimu cislu
if (@$oscislo<>"" and @$pravo=="ANO") {

// db akceif (@$_GET["vydat"]<>"") {launchobed(desifra(@$_GET['vydat']));
unset($_GET["vydat"]);}
if (@$_GET["nevydat"]<>"") {delaunchobed(desifra(@$_GET['nevydat']));
unset($_GET["nevydat"]);
}

// konec db akci
$rozpadadresy=explode("&", $_SERVER['REQUEST_URI']);$adresa="";$sekce=0; while ($rozpadadresy[$sekce]<>""):
if (!StrPos (" " . $rozpadadresy[$sekce], "vydat") and !StrPos (" " . $rozpadadresy[$sekce], "nevydat")) {$adresa.=$rozpadadresy[$sekce];}
@$sekce++;endwhile;
if (@$osnumber=="") {$adresa.="?osnumber=".mysql_result(mysql_query("select cip from cipy where (osobni_cislo='".securesql($oscislo)."' and platnostod<='$dnes' and (platnostdo='0000-00-00' or platnostdo<='$dnes')) "),0,0);}


$data1=mysql_query("select * from zamestnanci where osobni_cislo='".securesql($oscislo)."'");
$data2=mysql_query("select * from objednavky_obedu where (osobni_cislo='".securesql($oscislo)."' or tr_osobni_cislo='".securesql($oscislo)."') and datum='$dnes' order by skupina,id");
	?>
<tr><td width=50% align=center vertical-align=middle><table border=1 bgcolor=#DFDFDF style="font-size: 25pt;" frame="border" rules=all width=98%>
<tr align=center bgcolor=#1FD15E><td>Skupina</td><td>Název Obědu</td><td>Stav</td></tr>
<?$cykl=0;while($cykl<mysql_num_rows($data2)):
 $vedlstrava=explode("+:+",mysql_result(@$data2,$cykl,12));
echo "<tr><td align=center style=font-size:45pt;>".mysql_result(@$data2,$cykl,3);if ($vedlstrava[0]){echo ",".$vedlstrava[0];}echo "</td><td align=center>".mysql_result(@$data2,$cykl,4);if (mysql_result(@$data2,$cykl,11)){echo"<br /><span style=color:#DB3337>Jiná příloha: ".mysql_result(@$data2,$cykl,11)."</span>";}if ($vedlstrava[0]){echo "<br /><span style=color:#1C1FA8>".$vedlstrava[1]."</span>";}echo"</td><td align=center>";
if (mysql_result(@$data2,$cykl,9)=="Čeká") {echo"<input type=button value=Vydat onclick=window.location.href=('".$adresa."&vydat=".sifra(mysql_result(@$data2,$cykl,0))."') style=width:100%;height:100px;font-size:30pt;cursor:pointer;background:#E90F0A; >";}
//else {echo"<input type=button value='Zrušit' onclick=window.location.href=('".$adresa."&nevydat=".sifra(mysql_result(@$data2,$cykl,0))."') style=width:100%;height:100%;font-size:30pt; style=cursor:pointer; >";}
else {echo "Vydáno<br />".mysql_result(@$data2,$cykl,10);}
echo"</td></tr>";

@$cykl++;endwhile;?>
</table></td>



<td width=50% align=center><span style="font-size: 30pt;color:#000000"><b>IDENTIFIKACE:</span><br /><br />
<span style="font-size: 50pt;color:#8249DE">
<?echo@$oscislo."<br />".mysql_result(@$data1,0,4)." ".mysql_result(@$data1,0,3)." ".mysql_result(@$data1,0,2)."<br />";?>
<br /></b></span></td>
</tr>

<script language="JavaScript">setTimeout('window.location.href="OScan.php"', 120000)</script>
<?}







// nema pravo na dotovany obed
if (@$pravo=="NE"){?><tr><td colspan=2 style="font-size: 45pt;" align=center><br />
NEMÁ PRÁVO NA DOTOVANÝ OBĚD<br /><IMG SRC=picture/no.gif width=100></b></td></tr>
<script language="JavaScript">setTimeout('window.location.href="OScan.php"', 3000)</script>
<?}




// spatny pokus
if (@$pokus=="false"){?>
ŠPATNÝ POKUS<br /><IMG SRC=picture/no.gif width=100></b>
<script language="JavaScript">setTimeout('window.location.href="OScan.php"', 2000)</script>
<?}?>


</table></center>


<?

// celkovy dnesni vydej tabulka
$data3=mysql_query("select * from objednavky_obedu where datum='$dnes' order by skupina,id ");
@$setting=mysql_result(mysql_query("select hodnota from setting where nazev='Obědy' "),0,0);@$rozpad= explode("/", $setting);@$typchodu= explode(",",$rozpad[7]);
@$setting= $rozpad[1];@$rozpad= explode(",",$setting);
$pocetsk=0;while(@$rozpad[$pocetsk]<>""):
$pocetsk++;endwhile;?>
<div style=position:absolute;bottom:0;>
<table border=1 bgcolor=#E2CD76 style="font-size: 45pt;" frame="border" rules=all width=100%>
<tr align=center><?  //hlavicka
$cykl=0;while($cykl<$pocetsk):
if ($rozpad[$cykl]<>"Polévka") {if ( StrPos (" " . @$typchodu[$cykl], "H"))	{echo"<td>".$rozpad[$cykl]."</td>";}else {echo"<td bgcolor=#C2F8C4>".$rozpad[$cykl]."</td>";}} else {echo "<td width=50%>Počty Obědů</td>";}
$cykl++;endwhile;?></tr>

<tr align=center><? //celkem
$cykl=0;while($cykl<$pocetsk):
if ($rozpad[$cykl]<>"Polévka") {if ( StrPos (" " . @$typchodu[$cykl], "H"))	{echo"<td>";echo  $pocty[$cykl]=mysql_num_rows(mysql_query("select id from objednavky_obedu where datum='$dnes' and skupina='".$rozpad[$cykl]."' "));echo "</td>";}
else {echo"<td bgcolor=#C2F8C4>";echo  $pocty[$cykl]=mysql_num_rows(mysql_query("select id from objednavky_obedu where datum='$dnes' and vedlejsi_strava like '".$rozpad[$cykl]."+:+%' "));echo "</td>";}
}
 else {echo "<td>Objednáno: ";echo $pocty["celkem"]=mysql_num_rows(mysql_query("select id from objednavky_obedu where datum='$dnes' "));echo "</td>";}
$cykl++;endwhile;?></tr>

<tr align=center><? //vydano
$cykl=0;while($cykl<$pocetsk):
if ($rozpad[$cykl]<>"Polévka") {if ( StrPos (" " . @$typchodu[$cykl], "H"))	{echo"<td>".mysql_num_rows(mysql_query("select id from objednavky_obedu where datum='$dnes' and skupina='".$rozpad[$cykl]."' and stav='Vydáno' "))."</td>";}
else {echo"<td bgcolor=#C2F8C4>";echo mysql_num_rows(mysql_query("select id from objednavky_obedu where datum='$dnes' and vedlejsi_strava like '".$rozpad[$cykl]."+:+%' and stav='Vydáno' "));echo "</td>";}
}
 else {echo "<td>Vydáno: ".mysql_num_rows(mysql_query("select id from objednavky_obedu where datum='$dnes' and stav='Vydáno' "))."</td>";}
$cykl++;endwhile;?></tr>

<tr align=center><? //zbyva vydat
$cykl=0;while($cykl<$pocetsk):
if ($rozpad[$cykl]<>"Polévka") {if ( StrPos (" " . @$typchodu[$cykl], "H"))	{echo"<td>";echo (@$pocty[$cykl]-@mysql_num_rows(mysql_query("select id from objednavky_obedu where datum='$dnes' and skupina='".$rozpad[$cykl]."' and stav='Vydáno' ")));echo "</td>";}
else {echo"<td bgcolor=#C2F8C4>";echo  $pocty[$cykl]-mysql_num_rows(mysql_query("select id from objednavky_obedu where datum='$dnes' and vedlejsi_strava like '".$rozpad[$cykl]."+:+%' and stav='Vydáno' "));echo "</td>";}
}
 else {echo "<td>Zbývá: ";echo (@$pocty["celkem"]-@mysql_num_rows(mysql_query("select id from objednavky_obedu where datum='$dnes' and stav='Vydáno' ")));echo"</td>";}
$cykl++;endwhile;?></tr>
</table></div>

<!--// konec celkoveho vydeje//-->

<!--//Dotaz na osobni cislo//-->
<div style=position:absolute;left:10px;top:10px;>
<form name="cislo" action="OScan.php" method="POST">
<input name="oscislo" type="text" value="Osobní Číslo" onclick="document.cislo.oscislo.value='';" style=background-color:#6DF871;font-size:15pt;>
</form>
</div>




<?mysql_close();?>

<?if (@$pokus<>"false" and @$oscislo<>"") {?><div style="position:absolute;top:0%;right:0%"><input type="button" value="HOTOVO" style=width:200px;height:70px;font-size:30pt;color:red; style="cursor: pointer;" onclick=window.location.href=('<?echo $_SERVER['SCRIPT_NAME'];?>') ></div><?}?>
</body>