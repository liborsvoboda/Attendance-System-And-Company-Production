<html>
<head>
<title>Docházkový Systém</title>
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





@$dnes=date("Y-m-d");@$obdobi=date("Y-m");
@$cas=StrFTime("%H:%M:%S", Time());
@$dnescs=date("d.m.Y");

include ("./"."dbconnect.php");

@$timetype=mysql_result(mysql_query("select hodnota from setting where nazev='Čas'"),0,0);
include ("./"."Dnumlock$timetype.php");
include ("./"."knihovna.php");


@$numlock=base64_decode(@$_GET["numlock"]);
@$text=@$_GET["text"];
@$pokus=@$_GET["pokus"];
if (mysql_result(mysql_query("select hodnota from setting where nazev='Snímač' "),0,0)=="Windows") {@$oscislo=@$_GET["oscislo"];}
if (mysql_result(mysql_query("select hodnota from setting where nazev='Snímač' "),0,0)=="Linux") {@$oscislo=@$_GET["oscislo"];
// prevod cisla na spravny pin
}

@$cyklus=base64_decode(@$_GET["cyklus"])+1;if (@$cyklus==3) {@$numlock="";@$oscislo="";@$text="";$cyklus=0;}
if (@$oscislo<>"") {include ("./"."dbconnect.php");
@$zamestnanec=@$usernumber=mysql_result(mysql_query("select osobni_cislo from cipy where cip='$oscislo' and (platnostdo='0000-00-00' or platnostdo>='$dnes') "),0,0);
@$data1 =mysql_query("select * from zamestnanci where osobni_cislo='$usernumber' and (datumout='0000-00-00' or datumout>='$dnes') ") or Die(MySQL_Error());
//$smena=mysql_result($data1,0,24); // omezeni presunu obedu na smeny
$smena="Všechny";
$vykaz=mysql_result($data1,0,26);

@$stredisko=mysql_result(mysql_query("select stredisko from zam_strediska where osobni_cislo='$zamestnanec' and (datumdo='0000-00-00' or datumdo>='$dnes') "),0,0);
if (mysql_num_rows($data1)<>0) {@$jmeno=mysql_result(@$data1,0,2)." ".mysql_result(@$data1,0,3)." ".mysql_result(@$data1,0,4);$pravo=mysql_result(@$data1,0,27);} else {@$jmeno="";}}


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




</head>


<body onload="updateClock(); setInterval('updateClock()', 1000 );" bgcolor="#E6AD6F" style=margin:0;overflow:hidden;>
<center><table width=100% style=margin:0 cellpadding="0" cellspacing="0" border=0px>
<tr bgcolor=#E6AD6F style=margin:0><td colspan=2 align=center><span style=font-size:50pt><b>DOCHÁZKOVÝ SYSTÉM</b></span></td></tr>
<tr><td colspan=2 align=center><div id="clock" style=width:100%;font-size:60pt>&nbsp;</div></td></tr>



<?
//  numlock dotyku
if ((mysql_result(mysql_query("select hodnota from setting where nazev='MSnímač' "),0,0)<>"Numlock" and @$numlock=="") or (mysql_result(mysql_query("select hodnota from setting where nazev='MSnímač' "),0,0)<>"Numlock" and $pokus=="false")) {?><tr><td width=50%></td><td width=50% align=right>
<table width=70% style=margin-top:2px;margin-right:20px>
<?$vykresli=1;while ($vykresli<(mysql_result(mysql_query("select poradi from klavesnice where stav='Aktivní'  order by poradi DESC LIMIT 1"),0,0)+1)):
$data100=mysql_query("select text,poradi,cislo from klavesnice where stav='Aktivní' and poradi='$vykresli' order by poradi,id ");
if (mysql_result($data100,0,0)<>""){echo "<tr><td width=100%><input type=button value='".mysql_result($data100,0,0)."' style=width:100%;height:70px;font-size:45px;";?> onclick="window.location.href=('DScan.php?numlock=<?echo base64_encode(mysql_result($data100,0,2));?>&text=<?echo mysql_result($data100,0,0);?>')" <?echo" ></td></tr>";}
else {echo"<tr><td style=width:100%;height:20px;></td></tr>";}

$vykresli++;endwhile;?>

</table>
</td></tr>
<?}?>








<?   // vyber menu a nacteni cipu
if (@$numlock<>"" and @$oscislo=="") {?>
<tr><td width=50% align=center vertical-align=bottom><span style="font-size: 60pt;color=#EA1318"><b><?echo @$text;?></b></span></td>
<td width=50% align=center><span style="font-size: 30pt;color:#000000"><b>IDENTIFIKACE:</span>
<br /><br />
<span style="font-size: 50pt;color:#8249DE">
Přiložte Čip nebo stiskněte STORNO<br />
<br /><br /></b></span></td>
</tr></table>



<? // nacteni osobnich cisel
include ("./"."dbconnect.php");
@$data1 = mysql_query("select cip from cipy where (platnostdo='0000-00-00' or platnostdo>='$dnes') order by cip ASC") or Die(MySQL_Error());
@$cykl=0;@$oscisla=",";while ( @$cykl< mysql_num_rows($data1)): $oscisla.=mysql_result($data1,@$cykl,0).",";@$cykl++;endwhile;?>
<SCRIPT language="JavaScript">
var oscislo;
oscislo=window.prompt('<?echo $text.":";?>','');
<?if (mysql_result(mysql_query("select hodnota from setting where nazev='Snímač' "),0,0)=="Windows") {?>
if (oscislo==null) {window.location.href="DScan.php?pokus=false&oscislo="+oscislo;}
if (oscislo.length> 12) {window.location.href="DScan.php?pokus=false&oscislo="+oscislo;}
if (oscislo.length!=12 && oscislo.length< 12) {window.location.href="DScan.php?pokus=false&oscislo="+oscislo;}
if ("<?echo $oscisla?>".search(","+oscislo+",")<0 && "<?echo $text?>" != "Žádost o Aktivaci" && oscislo.length==12) {window.location.href="DScan.php?numlock=<?echo base64_encode(@$numlock);?>&text=<?echo @$text;?>&cyklus=<?echo base64_encode(@$cyklus);?>&oscislo="+oscislo;}
if ("<?echo $oscisla?>".search(","+oscislo+",")>=0 && "<?echo $text?>" != "Žádost o Aktivaci" && oscislo.length==12) {window.location.href="DScan.php?numlock=<?echo base64_encode(@$numlock);?>&text=<?echo @$text;?>&cyklus=<?echo base64_encode(@$cyklus);?>&oscislo="+oscislo;}
if ("<?echo $text?>"=="Žádost o Aktivaci" && oscislo!="null" && oscislo.length==12) {window.location.href="DScan.php?numlock=<?echo base64_encode(@$numlock);?>&text=<?echo @$text;?>&cyklus=<?echo base64_encode(@$cyklus);?>&oscislo="+oscislo;}
<?}?>
<?if (mysql_result(mysql_query("select hodnota from setting where nazev='Snímač' "),0,0)=="Linux") {?>
if (oscislo==null) {window.location.href="DScan.php?pokus=false";}
if (oscislo.length< 20) {window.location.href="DScan.php?pokus=false";}
if ("<?echo $text?>" != "Žádost o Aktivaci" && oscislo!="null") {window.location.href="DScan.php?numlock=<?echo base64_encode(@$numlock);?>&text=<?echo @$text;?>&cyklus=<?echo base64_encode(@$cyklus);?>&oscislo="+oscislo;}
if ("<?echo $text?>"=="Žádost o Aktivaci" && oscislo!="null") {window.location.href="DScan.php?numlock=<?echo base64_encode(@$numlock);?>&text=<?echo @$text;?>&cyklus=<?echo base64_encode(@$cyklus);?>&oscislo="+oscislo;}
<?}?>
</SCRIPT>
<script language="JavaScript">setTimeout('window.location.href="DScan.php"', 1000)</script>
<?}






include ("./"."dbconnect.php");
if (mysql_result(mysql_query("select hodnota from setting where nazev='Snímač' "),0,0)=="Windows") {if (strlen(@$oscislo)==12) {$delka="YES";} else {$delka="NO";}}
if (mysql_result(mysql_query("select hodnota from setting where nazev='Snímač' "),0,0)=="Linux") {if (strlen(@$oscislo)>20 or strlen(@$oscislo)<30) {$delka="YES";} else {$delka="NO";}}


//  VYHODNOCENI CIPU


// zobrazit stav

if (@$numlock<>"" and @$text=="Zobrazit Stav Docházky" and @$jmeno<>"" and @$oscislo<>"null" and $delka=="YES"){include ("./"."dbconnect.php");?>
<tr><td width=100% align=center vertical-align=top><span style="font-size: 20pt;color=#EA1318"><b><?echo @$text." ".@$usernumber." ".@$jmeno;?></b></span>
<?$obdobi1=explode("-",$obdobi);include ("./"."infocard.php");?><table width=100% height=100%><tr style=valign:top><td><table width=100% border=1 style="font-size: 10pt">
<tr bgcolor="#C0FFC0" align=center><td> Datum </td><td><center>Příchod</center></td><td><center>Odchod</center></td><td>Celkový Čas / Definováno / Zbývá Def.</td><td><b>Poznámka</b></td></tr>
<?$prichod= mysql_result(mysql_query("select cislo from klavesnice where text='Příchod'"),0,0);
$odchod1=mysql_query("select cislo,barva,text from klavesnice where text like 'Odchod%'");@$cykl=0;while (@$cykl<mysql_num_rows($odchod1)):$odchod[@$cykl]= mysql_result($odchod1,$cykl,0);$barvy[@$cykl]= mysql_result($odchod1,$cykl,1);$plky[@$cykl]= mysql_result($odchod1,$cykl,2);@$cykl++;endwhile;
@$vysledek = mysql_query("select * from dochazka where osobni_cislo='$usernumber' and obdobi='$obdobi' order by cas,datum,id ") or Die(MySQL_Error());
$cykl=1;while( @$cykl< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):
if (@$cykl<10) {$cyklus="0".$cykl;} else {@$cyklus=$cykl;} $datum =$obdobi."-".$cyklus;$in="";$out="";$wout="";$cdne= date("w", strtotime($datum));
$dsvatku="-".$obdobi1[1]."-".$cyklus;$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$datum' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trvalý' and stav='Neaktivní')) "),0,0);?>
<tr <?if (@$cdne>0 and @$cdne<6 and $svatek=="") {?>bgcolor=#FDCC5B<?} else {?>bgcolor=#F7FBA4<?}?> >
<td><?echo $cykl.".".$obdobi1[1].".".$obdobi1[0];?></td>
<td valign=bottom align=center><?$vypis=0;$narust=0;while($vypis<mysql_num_rows($vysledek)):
if (mysql_result($vysledek,@$vypis,4)==$prichod and mysql_result($vysledek,@$vypis,2)==$datum) {$in[$narust] =substr(mysql_result($vysledek,@$vypis,3),0,5);echo $in[$narust]."<br />";$narust++;}
@$vypis++;endwhile;?></td>
<td valign=bottom align=center><?$vypis=0;$narust=0;while($vypis<mysql_num_rows($vysledek)):
@$write=0;$odchody="NO";while ($odchod[@$write]<>""): if (mysql_result($vysledek,@$vypis,4) == $odchod[@$write]) {$plk=$plky[@$write];$barva=$barvy[@$write];$odchody="YES";}@$write++;endwhile;
if ( $odchody=="YES" and mysql_result($vysledek,@$vypis,2)==$datum) {$out[$narust] =substr(mysql_result($vysledek,@$vypis,3),0,5);echo "<span style=background-color:".$barva." title='".$plk."'>".$out[$narust]."</span><br />";@$narust++;}
@$vypis++;endwhile;?></td>
<td valign=bottom align=center><table width=100%><tr><?
$vypis=0;@$celkhod="";@$celkmin="";while($in[$vypis]<>"" and $out[$vypis]<>""):
@$castipr = explode(":", $in[$vypis]);@$prhod=@$castipr[0];@$prmin=@$castipr[1];
@$castiod = explode(":", $out[$vypis]);@$odhod=@$castiod[0];@$odmin=@$castiod[1];
if (@$odmin<@$prmin){@$vysmin=60-(@$prmin-@$odmin);@$vyshod=@$odhod-@$prhod-1;}
if (@$odmin>=@$prmin){@$vysmin=@$odmin-@$prmin;@$vyshod=@$odhod-@$prhod;}
if (@$vysmin<10){@$vysmin="0".@$vysmin;}
@$celkhod=@$celkhod+@$vyshod;@$celkmin=@$celkmin+@$vysmin;
@$vypis++;endwhile;while(@$celkmin>=60):@$celkhod++;@$celkmin=@$celkmin-60;endwhile;echo " <td align=center width=33%";if (@$celkhod<>"") {echo" style=background-color:#F05139 >";}if (@$celkhod<>"") {echo @$celkhod.":";}if ((@$celkmin<10 and @$celkmin<>"") or (@$celkhod<>"" and @$celkmin<10)) {echo"0";}echo @$celkmin." </td>";
@$vyshod="";@$vysmin="";@$celkhod="";@$celkmin="";
$vypis=0;while($in[$vypis]<>"" and $out[$vypis]<>""):
@$castipr = explode(":", $in[$vypis]);@$prhod=@$castipr[0];@$prmin=@$castipr[1];
@$castiod = explode(":", $out[$vypis]);@$odhod=@$castiod[0];@$odmin=@$castiod[1];
if (@$odmin<@$prmin){@$vysmin=60-(@$prmin-@$odmin);@$vyshod=@$odhod-@$prhod-1;}
if (@$odmin>=@$prmin){@$vysmin=@$odmin-@$prmin;@$vyshod=@$odhod-@$prhod;}
if (@$vysmin<10){@$vysmin="0".@$vysmin;}
@$celkhod=@$celkhod+@$vyshod;@$celkmin=@$celkmin+@$vysmin;
@$vypis++;endwhile;while(@$celkmin>=60):@$celkhod++;@$celkmin=@$celkmin-60;endwhile;

// přestávky
if (@$celkhod<>""){@$prestavek=floor(@$celkhod/(@mysql_result(mysql_query("select * from setting where nazev='Přestávka' order by id"),0,2)));
if (@$prestavek/2==ceil(@$prestavek/2)) {@$celkhod=@$celkhod-(0.5*@$prestavek);} else {$ppr=floor(@$prestavek/2);
if (@$celkmin>=30) {@$celkmin=@$celkmin-30;@$celkhod=@$celkhod-(0.5*@$ppr);} else {@$celkmin=@$celkmin+30;@$celkhod=@$celkhod-(0.5*@$ppr)-1;}}if (@$celkmin<10) {$celkmin="0".$celkmin;}}

//již definováno
@$nastaveno1=mysql_query("select * from zpracovana_dochazka where osobni_cislo = '$usernumber' and datum='$datum' order by id");
$nhod=0;$nmin=0;$dhod=0;$dmin=0;@$cykla=0;while(@$cykla<@mysql_num_rows($nastaveno1)):
@$casti = explode(":", @mysql_result($nastaveno1,@$cykla,2));
@$nhod=@$nhod+@$casti[0];@$nmin=@$nmin+@$casti[1];$dhod=@$dhod+@$casti[0];@$dmin=@$dmin+@$casti[1];
@$cykla++;endwhile;
if (@$nmin>60) {$ppr=floor(@$nmin/60);@$nhod=@$nhod+$ppr;@$nmin=@$nmin-(@$ppr*60);}if (@$dmin>60) {$ppr=floor(@$dmin/60);@$dhod=@$dhod+$ppr;@$dmin=@$dmin-(@$ppr*60);}
@$zmin=@$celkmin-@$nmin;if (@$zmin<0) {@$nhod=@$nhod+1;@$zmin=60+@$celkmin-@$nmin;}if (@$zmin<10) {@$zmin="0".@$zmin;}@$zbyva=(@$celkhod-@$nhod).":".@$zmin;if (@$zbyva<>"0:00" and StrPos (" " . @$zbyva, "-")==false) {@$zbyva=@$zbyva;} else {@$zbyva="";}
//  konec definováno
echo "<td align=center width=33%";if (@$dhod<>"") {echo" style=background-color:#6BF968 > ";}if (@$dhod<>"") {if (@$dmin<10) {@$dmin="0".@$dmin;}echo @$dhod.":".@$dmin;}echo"</td><td align=center width=33%";if (@$zbyva<>"") {echo" style=background-color:#FEEE81 > ";}echo @$zbyva." </td>";?></tr></table></td>

<td><?echo mysql_result(mysql_query("select poznamka from poznamky where osobni_cislo='$usernumber' and datum='$datum'"),0,0);?></td></tr>

<?if ( @$cykl== (floor((date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1)/2)) ) {?></table></td><td valign=top><table width=100% border=1 style="font-size: 10pt"><tr bgcolor="#C0FFC0" align=center><td> Datum </td><td><center>Příchod</center></td><td><center>Odchod</center></td><td>Celkový Čas / Definováno / Zbývá Def.</td><td><b>Poznámka</b></td></tr><?}?>


<?$cykl++;endwhile;?>
</table>

</td></tr></table></td></tr>
<script language="JavaScript">setTimeout('window.location.href="DScan.php"', 30000)</script>
<?}
















// Objednávka Obědů

if (@$numlock<>"" and @$text=="Objednání Obědů" and @$jmeno<>"" and @$oscislo<>"null" and  $delka=="YES" and $pravo=="ANO"){include ("./"."dbconnect.php");

?>
<tr><td width=55% align=center style=vertical-align:top><span style="font-size: 30pt;vertical-align:top;color=#EA1318"><b>Objednání Obědu</span></td>
<td width=45% align=center><span style="font-size: 20pt;color:#000000"><b>IDENTIFIKACE:</span><span style="font-size: 20pt;color:#8249DE"><?echo@$usernumber."<br />".@$jmeno."<br />";?></b></span></td></tr>
<tr><td width=55% align=center style=vertical-align:top><table border=1 bgcolor=#DFDFDF style="font-size: 20pt;" frame="border" rules=all width=100%><?
$numberlaunch1= explode ("/", mysql_result(mysql_query("select hodnota from setting where nazev='Obědy'"),0,0));$numberlaunch=explode(",", $numberlaunch1[0]);$numberlaunch2=explode(",", $numberlaunch1[1]);$numberlaunch[0]=$numberlaunch[0]-1;$numberlaunch3=explode(",", $numberlaunch1[3]);$numberlaunch4=explode(",", $numberlaunch1[4]);$numberlaunch5=explode(",", $numberlaunch1[5]);$numberlaunch6=explode(",", $numberlaunch1[6]);$numberlaunch7=explode(",", $numberlaunch1[7]);$numberlaunch8=explode(",", $numberlaunch1[8]);
$cdne= date("w", strtotime($dnes));if (@$cdne>0) {$nextwoche=(1-$cdne)." day ";if (!StrPos (" " . $nextwoche, "-")) {$nextwoche="+".$nextwoche;}$lastwoche=(1-$cdne+$numberlaunch[0])." day ";} else {$nextwoche="+1 day ";$lastwoche=(1+$numberlaunch[0])." day ";}

//ulozeni vyberu
if (@$_GET["vybrano"]<>"") { // ulozeni hlavniho jidla
$value1="(".mysql_result(mysql_query("select obed from seznam_obedu where datum='".securesql(@$_GET["odatum"])."' and skupina='$numberlaunch2[0]' "),0,0).")</br>";
$value1.=mysql_result(mysql_query("select obed from seznam_obedu where datum='".securesql(@$_GET["odatum"])."' and skupina='".securesql(@$_GET["vybrano"])."' "),0,0);
$cena=mysql_result(mysql_query("select cena from seznam_obedu where datum='".securesql(@$_GET["odatum"])."' and skupina='".securesql(@$_GET["vybrano"])."' "),0,0);

$control=mysql_result(mysql_query("select id from objednavky_obedu where datum='".securesql(@$_GET["odatum"])."' and osobni_cislo='".securesql(@$usernumber)."' "),0,0);
if (@$control=="") {
mysql_query ("INSERT INTO objednavky_obedu (osobni_cislo,datum,skupina,obed,cena,vlozil,datumvkladu,casobj)VALUES('".securesql(@$usernumber)."','".securesql(@$_GET["odatum"])."','".securesql(@$_GET["vybrano"])."','$value1','".securesql($cena)."','".securesql(@$usernumber)."','$dnes','$cas')") or Die(MySQL_Error());}
else {mysql_query ("update objednavky_obedu  set skupina = '".securesql(@$_GET["vybrano"])."',obed = '$value1',cena='".securesql($cena)."',vlozil='".securesql($usernumber)."',datumvkladu='".securesql($dnes)."',priloha='',casobj='$cas' where  id = '".securesql($control)."' ")or Die(MySQL_Error());}

unset($_GET["odatum"]);
unset($_GET["vybrano"]);
}

if (@$_GET["vvybrano"]<>"") { // ulozeni vedlejsiho jidla
$value1=mysql_result(mysql_query("select CONCAT(skupina,'+:+',obed,'+:+',cena) from seznam_obedu where datum='".securesql(@$_GET["odatum"])."' and skupina='".securesql(@$_GET["vvybrano"])."' "),0,0);
$control=mysql_result(mysql_query("select id from objednavky_obedu where datum='".securesql(@$_GET["odatum"])."' and osobni_cislo='".securesql(@$usernumber)."' "),0,0);
if (@$control=="") {
mysql_query ("INSERT INTO objednavky_obedu (osobni_cislo,datum,vedlejsi_strava,vlozil,datumvkladu,casobj)VALUES('".securesql(@$usernumber)."','".securesql(@$_GET["odatum"])."','$value1','".securesql(@$usernumber)."','$dnes','$cas')") or Die(MySQL_Error());}
else {mysql_query ("update objednavky_obedu  set vedlejsi_strava ='$value1',vlozil='".securesql($usernumber)."',datumvkladu='".securesql($dnes)."',casobj='$cas' where  id = '".securesql($control)."' ")or Die(MySQL_Error());}
unset($_GET["odatum"]);
unset($_GET["vvybrano"]);
}



if (@$_GET["delete"]<>"") {deleteobed(@$_GET["delete"]);
unset($_GET["odatum"]);
unset($_GET["vybrano"]);
}

if (@$_POST["transfer"]<>"") { giveobed($_POST["tosoba"],$_POST["transfer"]);unset($_POST["transfer"]);
unset($_POST["tosoba"]);
}

if (@$_GET["remove"]<>"") { removegiveobed($_GET["remove"]);
unset($_GET["remove"]);
unset($_POST["tosoba"]);
}

if (@$_POST["priloha"]<>"") { priloha($_POST["vpriloha"],$_POST["priloha"]);
unset($_POST["vpriloha"]);
unset($_POST["priloha"]);
}

if (@$_GET["removep"]<>"") { removepriloha($_GET["removep"]);
unset($_GET["removep"]);
unset($_POST["vpriloha"]);
}

// konec ulozeni vyberu

// konec ulozeni vyberu


if (@$_GET["styden"]=="" and @$styden=="") {$styden=0;} else {$styden=@$_GET["styden"];}

$rozpadadresy=explode("&", $_SERVER['REQUEST_URI']);$adresa="";$sekce=0; while ($rozpadadresy[$sekce]<>""):
if (!StrPos (" " . $rozpadadresy[$sekce], "styden") and !StrPos (" " . $rozpadadresy[$sekce], "odatum") and !StrPos (" " . $rozpadadresy[$sekce], "vvybrano") and !StrPos (" " . $rozpadadresy[$sekce], "vybrano") and !StrPos (" " . $rozpadadresy[$sekce], "delete") and !StrPos (" " . $rozpadadresy[$sekce], "transfer") and !StrPos (" " . $rozpadadresy[$sekce], "remove") and !StrPos (" " . $rozpadadresy[$sekce], "priloha") and !StrPos (" " . $rozpadadresy[$sekce], "removep")) {$adresa.=$rozpadadresy[$sekce]."&";}
@$sekce++;endwhile;

$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".$styden." weeks"));
$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".$styden." weeks"));$endwochea= date("Y-m-d", strtotime( $dnes." + ".$lastwoche."+".$styden." weeks"));
$tyden= date("W", strtotime( $dnes.$nextwoche." + ".$styden." weeks"));?>

<style type="text/css">
tr.menuon  {background-color:#49D651;}
tr.menuoff {background-color:#DFDFDF;}
tr.menuonv  {background-color:#49D651;}
tr.menuoffv {background-color:#B0ABEB;}
</style>

<tr width=100% bgcolor=#CDC5FC><td width=10% height=60px><?if ($styden>0) {?><input type="button" value="Předch." style=width:100%;height:58px;font-size:16pt; style="cursor: pointer;" onclick="window.location.href=('<?echo$adresa;?>styden=<?echo ($styden-1);?>&odatum=<?echo $dsvatku1;?>')" ><?}?></td>
<td colspan=3 align=center style=width:83%>TÝDEN: <?echo $startwoche." - ".$endwoche." / ".$tyden."T";?> </td>
<td style=width:10%;height:60px><?if ($endwochea<mysql_result(mysql_query("select datum from seznam_obedu order by datum DESC Limit 1"),0,0)){?><input type="button" value="Další" onclick="window.location.href=('<?echo$adresa;?>styden=<?echo ($styden+1);?>&odatum=<?echo $dsvatku1;?>')" style=width:100%;height:58px;font-size:16pt; style="cursor: pointer;"><?}?></td></tr>

<?$vypis=0;while($vypis<($numberlaunch[0]+1)):
$data40=mysql_query("select id,skupina,obed,cena,stav,tr_osobni_cislo,priloha,vedlejsi_strava from objednavky_obedu where osobni_cislo='".securesql($usernumber)."' and datum='".date("Y-m-d", strtotime($startwoche." + ".$vypis." day"))."' ");
@$vedlejsi=explode("+:+",mysql_result($data40,0,7));


$lnajdi=0;$lnajdi1=0;$lnajdi2=0;
$najdi=0;$tnajdi=0;$tnajdi1=0;$poradi="";$lporadi="";while($najdi<$numberlaunch[1]):
@$objcas= explode(":",$numberlaunch4[$najdi]);
if (mysql_result($data40,0,1)==$numberlaunch2[$najdi]){$poradi=$najdi;}
if (mysql_result($data40,0,1)=="" and (@$objcas[0]>$tnajdi or (@$objcas[0]==$tnajdi and @$objcas[1]>$tnajdi1))){$nporadi=$najdi;$tnajdi=$objcas[0];$tnajdi1=$objcas[1];}
@$najdi++;endwhile;if (@$poradi=="") {$poradi=$nporadi;} // nejvyssi ci vybrany cas pro vyber obedu

// vypocet limit casu pro objednani
	$aktdatetime = $dnes." ".$cas;
	@$objcas= explode(":",$numberlaunch4[$poradi]);

if (@$objcas[0]>=0) {if (@$objcas[0]<10) {$maxobjdatetime = date("Y-m-d", strtotime($startwoche." + ".$vypis." day"))." 0".@$objcas[0].":".@$objcas[1].":00";} else {$maxobjdatetime = date("Y-m-d", strtotime($startwoche." + ".$vypis." day"))." ".@$objcas[0].":".@$objcas[1].":00";}}
if (@$objcas[0]<0) {$anumberlaunch4[$poradi]=-@$objcas[0];$pdni=ceil ($anumberlaunch4[$poradi]/24);

// kontrola svatku je dvakrat z duvodu mozneho casoveho odsunu svatkem na vikend
$dsvatku= date("-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$pdni." day"));$dsvatku1= date("Y-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$pdni." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
while ($svatek<>"" and $numberlaunch6[0]=="NE"):$pdni++;
$dsvatku= date("-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$pdni." day"));$dsvatku1= date("Y-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$pdni." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
endwhile;
//kontrola vikendu
if ($numberlaunch5[0]=="NE" and date("w", strtotime( $startwoche." + ".$vypis." day"." - ".$pdni." day"))==0) {$pdni=$pdni+2;}
if ($numberlaunch5[0]=="NE" and date("w", strtotime( $startwoche." + ".$vypis." day"." - ".$pdni." day"))==6) {$pdni=$pdni+1;}
// kontrola svatku
$dsvatku= date("-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$pdni." day"));$dsvatku1= date("Y-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$pdni." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
while ($svatek<>"" and $numberlaunch6[0]=="NE"):$pdni++;
$dsvatku= date("-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$pdni." day"));$dsvatku1= date("Y-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$pdni." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
endwhile;

	$maxobjdatetime= date("Y-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$pdni." day"));
	if (@$objcas[1]>0) {$chod=23;} else {$chod=24;}
	if ((24-$anumberlaunch4[$poradi])<10) {$maxobjdatetime.=" 0".($chod-$anumberlaunch4[$poradi]).":".(60-@$objcas[1]).":00";} else {$maxobjdatetime.=" ".($chod-$anumberlaunch4[$poradi]).":".(60-@$objcas[1]).":00";}
}// konec vypoctu



// vypocet nejnizsiho casu pro prilohu
    @$lobjcas= explode(":",$numberlaunch8[0]); // nejnizsi cas pro vyber prilohy
	if (@$lobjcas[0]>=0) {if (@$lobjcas[0]<10) {$lmaxobjdatetime = date("Y-m-d", strtotime($startwoche." + ".$vypis." day"))." 0".@$lobjcas[0].":".@$lobjcas[1].":00";} else {$lmaxobjdatetime = date("Y-m-d", strtotime($startwoche." + ".$vypis." day"))." ".@$lobjcas[0].":".@$lobjcas[1].":00";}}
	if (@$lobjcas[0]<0) {$lanumberlaunch4[$lporadi]=-@$lobjcas[0];$lpdni=ceil ($lanumberlaunch4[$lporadi]/24);

		// kontrola svatku je dvakrat z duvodu mozneho casoveho odsunu svatkem na vikend
		$dsvatku= date("-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$lpdni." day"));$dsvatku1= date("Y-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$lpdni." day"));
		$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
		while ($svatek<>"" and $numberlaunch6[0]=="NE"):$lpdni++;
		$dsvatku= date("-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$lpdni." day"));$dsvatku1= date("Y-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$lpdni." day"));
		$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
		endwhile;
			//kontrola vikendu  vraci datum a cas zpet pro datovou možnost posledniho objednani v pripade svatku ci vikendu z nedele o 2 dny
			if ($numberlaunch5[0]=="NE" and date("w", strtotime( $startwoche." + ".$vypis." day"." - ".$lpdni." day"))==0) {$lpdni=$lpdni+2;}
			if ($numberlaunch5[0]=="NE" and date("w", strtotime( $startwoche." + ".$vypis." day"." - ".$lpdni." day"))==6) {$lpdni=$lpdni+1;}
		// kontrola svatku
		$dsvatku= date("-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$lpdni." day"));$dsvatku1= date("Y-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$lpdni." day"));
		$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
		while ($svatek<>"" and $numberlaunch6[0]=="NE"):$lpdni++;
		$dsvatku= date("-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$lpdni." day"));$dsvatku1= date("Y-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$lpdni." day"));
		$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
		endwhile;

	$lmaxobjdatetime= date("Y-m-d", strtotime( $startwoche." + ".$vypis." day"." - ".$lpdni." day"));
	if (@$lobjcas[1]>0) {$chod=23;} else {$chod=24;}
	if ((24-$lanumberlaunch4[$lporadi])<10) {$lmaxobjdatetime.=" 0".($chod-$lanumberlaunch4[$lporadi]).":".(60-@$lobjcas[1]).":00";} else {$lmaxobjdatetime.=" ".($chod-$lanumberlaunch4[$lporadi]).":".(60-@$lobjcas[1]).":00";}
}// konec vypoctu nejnizsiho casu
$maxdencas[($vypis+1)]=$lmaxobjdatetime; // promena pro kontrolu posledniho moyneho korektniho objednani


$cdne= date("w", strtotime($startwoche." + ".$vypis." day"));
if(@$cdne==1) {$dname="Pondělí";}if(@$cdne==2) {$dname="Úterý";}if(@$cdne==3) {$dname="Středa";}if(@$cdne==4) {$dname="Čtvrtek";}if(@$cdne==5) {$dname="Pátek";}if(@$cdne==6) {$dname="Sobota";}if(@$cdne==0) {$dname="Neděle";}

$dsvatku= date("-m-d", strtotime( $startwoche." + ".@$vypis." day"));$dsvatku1= date("Y-m-d", strtotime( $startwoche." + ".@$vypis." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
if ($svatek<>"" and $numberlaunch1[2]=="NE") {$barva="#F7FBA4";} else {$barva="#DFDFDF";}

echo "<tr bgcolor=".$barva." style=height:60px;"; if (($svatek=="" or ($svatek<>"" and $numberlaunch1[2]=="ANO")) and ($aktdatetime<$maxobjdatetime) and (@mysql_result($data40,0,4)=="Čeká" or @mysql_result($data40,0,4)=="") and (@mysql_result($data40,0,0)=="" or (@mysql_result($data40,0,0)<>"" and $aktdatetime<$lmaxobjdatetime)) ){echo"cursor:pointer; onmouseover=className='menuon'; onmouseout=className='menuoff'; ";} else {echo " style=color:#B0B0B0";}echo" ><td"; if (($svatek=="" or ($svatek<>"" and $numberlaunch1[2]=="ANO")) and ($aktdatetime<$maxobjdatetime) and (@mysql_result($data40,0,4)=="Čeká" or @mysql_result($data40,0,4)=="") and (@mysql_result($data40,0,0)=="" or (@mysql_result($data40,0,0)<>"" and $aktdatetime<$lmaxobjdatetime))){ echo " onclick=window.location.href=('".$adresa."styden=".$styden."&odatum=".$dsvatku1."')"; }echo ">".$dname."</td>";

if (@$svatek=="" or (@$svatek<>"" and $numberlaunch1[2]=="ANO")) {echo "<td style=width:8% align=center"; if (($svatek=="" or ($svatek<>"" and $numberlaunch1[2]=="ANO")) and ($aktdatetime<$maxobjdatetime) and (@mysql_result($data40,0,4)=="Čeká" or @mysql_result($data40,0,4)=="") and (@mysql_result($data40,0,0)=="" or (@mysql_result($data40,0,0)<>"" and $aktdatetime<$lmaxobjdatetime)) ){ echo " onclick=window.location.href=('".$adresa."styden=".$styden."&odatum=".$dsvatku1."')"; }echo ">".mysql_result($data40,0,1);if (@mysql_result($data40,0,1)){echo"<br />";}echo $vedlejsi[0]."</td>";
 echo "<td style=width:58% align=center style=font-size:18px "; if (($svatek=="" or ($svatek<>"" and $numberlaunch1[2]=="ANO")) and ($aktdatetime<$maxobjdatetime) and (@mysql_result($data40,0,4)=="Čeká" or @mysql_result($data40,0,4)=="") and (@mysql_result($data40,0,0)=="" or (@mysql_result($data40,0,0)<>"" and $aktdatetime<$lmaxobjdatetime)) ){ echo " onclick=window.location.href=('".$adresa."styden=".$styden."&odatum=".$dsvatku1."')"; }echo " >".mysql_result($data40,0,2);if (mysql_result($data40,0,5)) {echo "<br />"; if (mysql_result($data40,0,4)=="Čeká"  and $dsvatku1>=date("Y-m-d")) {echo "<font color=#000000>Oběd Vyzvedne: ";} else {echo"Oběd Vyzvedl: ";}echo mysql_result($data40,0,5)." ".mysql_result(mysql_query("select CONCAT(prijmeni,' ', jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(mysql_result($data40,0,5))."' "),0,0);}


 echo"</font>";if (@mysql_result($data40,0,6)) {echo "<font color=#3329AF><br />Jiná Příloha:".@mysql_result($data40,0,6)."</font>";}
 if ($vedlejsi[1]) {echo "<font color=#9A7318>";if (@mysql_result($data40,0,2)){echo"<br />";}echo $vedlejsi[1]."</font>";}echo"</td>";
 echo"<td style=width:7% align=right style=font-size:14px>";if (@mysql_result($data40,0,3)){ if (@mysql_result($data40,0,2)<>"" and mysql_result($data40,0,1)<>"" and ($aktdatetime<$lmaxobjdatetime) and @mysql_result($data40,0,4)=="Čeká" and mysql_result(mysql_query("select priloha from seznam_obedu where datum='".securesql($dsvatku1)."' and skupina='".mysql_result($data40,0,1)."' and priloha<>'' and priloha<>',' "),0,0)) {echo "<input type=button style=width:100%;height:40px;font-size:30pt;background:url(picture\priloha.jpg); style=cursor:pointer;  onclick=window.location.href=('".$adresa."styden=".$styden."&priloha=".mysql_result($data40,0,0)."') >";}
	$tccelkem=$tccelkem+@mysql_result($data40,0,3)+$vedlejsi[2];echo (@mysql_result($data40,0,3)+$vedlejsi[2])." Kč";}echo"</td>";
 echo"<td style=width:15%>";
 if (@mysql_result($data40,0,4)=="Čeká" and mysql_result($data40,0,1)<>"" and $dsvatku1>=date("Y-m-d") and ($aktdatetime>$maxobjdatetime or ($aktdatetime<$maxobjdatetime and $smena<>'Ranní'))) {?><input type="button" onclick=window.location.href=('<?echo$adresa;?>styden=<?echo $styden;?>&transfer=<?echo mysql_result($data40,0,0);?>"') style=width:50%;height:60px;font-size:10pt;background:url(picture\jidlonosic.bmp); style="cursor: pointer;"> <?}
 if (@mysql_result($data40,0,0)<>"" and ($aktdatetime<$maxobjdatetime) and @mysql_result($data40,0,4)=="Čeká" and (@mysql_result($data40,0,0)=="" or (@mysql_result($data40,0,0)<>"" and $aktdatetime<$lmaxobjdatetime))) {?><input type="button" value="X" onclick=window.location.href=('<?echo$adresa;?>styden=<?echo $styden;?>&delete=<?echo mysql_result($data40,0,0);?>"') style=width:42%;height:60px;font-size:30pt; style="cursor: pointer;"> <?}
 echo"</td></tr>";}

if (@$svatek<>"" and $numberlaunch1[2]=="NE") {echo "<td colspan=4 align=center>Svátek</td></tr>";}
@$vypis++;endwhile;?>

<tr bgcolor=#F3E8BA><td colspan=2 style=font-size:16px>Cena za Týden / <?echo $startwoche= date("m", strtotime( $dnes.$nextwoche." + ".$styden." weeks"));?> Měsíc</td><td colspan=3 align=right style=font-size:16px><?echo $tccelkem." Kč";
$sdate= date("Y-m-", strtotime( $dnes.$nextwoche." + ".$styden." weeks"));echo " / ".mysql_result(mysql_query("select SUM(cena) from objednavky_obedu where osobni_cislo='".securesql($usernumber)."' and datum like '$sdate%' "),0,0)." Kč";?></td></tr>

</table></td><td width=45% align=center>


<?// vyber jinou prilohu
if (@$_GET["priloha"]<>""){
$data1000=mysql_query("select * from objednavky_obedu where id='".securesql(@$_GET["priloha"])."' ");
$cdne= date("w", strtotime(mysql_result($data1000,0,2)));if(@$cdne==1) {$dname="Pondělí";}if(@$cdne==2) {$dname="Úterý";}if(@$cdne==3) {$dname="Středa";}if(@$cdne==4) {$dname="Čtvrtek";}if(@$cdne==5) {$dname="Pátek";}if(@$cdne==6) {$dname="Sobota";}if(@$cdne==0) {$dname="Neděle";}
$seldate=explode ("-",mysql_result($data1000,0,2));
?><form action="<?echo $adresa;?>styden=<?echo $styden;?>" method="post">
<input name="priloha" type="hidden" value="<?echo @$_GET["priloha"];?>">

<table border=1 bgcolor=#DFDFDF style="font-size: 20pt;" frame="border" rules=all width=95%>
<tr bgcolor=#CDC5FC><td align=center colspan=3 bgcolor=#CDC5FC >Vyber jinou přílohu: <b><?echo mysql_result($data1000,0,3)." z ".$dname." ".$seldate[2].".".$seldate[1].".".$seldate[0];?></b></td></tr>
<tr bgcolor=#CDC5FC><td align=center bgcolor=#CDC5FC colspan=2 width=80%><select style="direction:rtl" size="8" name="vpriloha" style=width:100%;font-size:30pt; >
<?echo $data140=explode (",",mysql_result(mysql_query("select priloha from seznam_obedu where skupina='". mysql_result($data1000,0,3)."' and datum='".mysql_result($data1000,0,2)."' and priloha<>''"),0,0));
@$vpriloha=1;while (@$data140[$vpriloha]<>""):
echo "<option ";if (mysql_result($data1000,0,11)==@$data140[$vpriloha]) {echo" selected";}echo " >".@$data140[$vpriloha]."</option>";
@$vpriloha++;endwhile;
?></select></td>

<td style=width:20%><input type="submit" value="OK" style=width:100%;height:60px;font-size:30pt; style="cursor: pointer;"><br /><br />
<input type="button" value="ZPĚT" style=width:100%;height:60px;font-size:30pt; style="cursor: pointer;" onclick=window.location.href=('<?echo $adresa;?>styden=<?echo $styden;?>') style=width:100%;height:60px;font-size:20pt; ><br /><br />
<?if (mysql_result($data1000,0,11)) {?><input type="button" value="ZRUŠ" style=width:100%;height:60px;font-size:30pt; style="cursor: pointer;" onclick=window.location.href=('<?echo $adresa;?>styden=<?echo $styden;?>&removep=<?echo @$_GET["priloha"];?>') style=width:100%;height:60px;font-size:20pt;background:url(picture\priloha.jpg); ><?}?>
</td>
</tr></table></form>
<?} // konec vybrani prilohy


// presun obedu na nekoho jineho
if (@$_GET["transfer"]<>""){$data1000=mysql_query("select * from objednavky_obedu where id='".securesql(@$_GET["transfer"])."' ");
$cdne= date("w", strtotime(mysql_result($data1000,0,2)));if(@$cdne==1) {$dname="Pondělí";}if(@$cdne==2) {$dname="Úterý";}if(@$cdne==3) {$dname="Středa";}if(@$cdne==4) {$dname="Čtvrtek";}if(@$cdne==5) {$dname="Pátek";}if(@$cdne==6) {$dname="Sobota";}if(@$cdne==0) {$dname="Neděle";}
$seldate=explode ("-",mysql_result($data1000,0,2));
?><form action="<?echo $adresa;?>styden=<?echo $styden;?>" method="post">
<input name="transfer" type="hidden" value="<?echo @$_GET["transfer"];?>">

<table border=1 bgcolor=#DFDFDF style="font-size: 20pt;" frame="border" rules=all width=95%>
<tr bgcolor=#CDC5FC><td align=center colspan=3 bgcolor=#CDC5FC >Vyber Zaměstnance pro vyzvednutí obědu: <b><?echo mysql_result($data1000,0,3)." z ".$dname." ".$seldate[2].".".$seldate[1].".".$seldate[0];?></b></td></tr>
<tr bgcolor=#CDC5FC><td align=center bgcolor=#CDC5FC colspan=2 width=80%><select style="direction:rtl" size="8" name="tosoba" style=width:100%;font-size:30pt;VerticalScrollBarWidth:30px"; >
<?$data140=mysql_query("select osobni_cislo,prijmeni,jmeno,titul from zamestnanci where ((datumout='0000-00-00' or datumout>='$dnes') and osobni_cislo<>'".securesql(@$usernumber)."' and obed='ANO') order by prijmeni,jmeno,id");
@$vosoba=0;while (@$vosoba< mysql_num_rows($data140) ):
echo "<option value='".mysql_result($data140,$vosoba,0)."'>".mysql_result($data140,$vosoba,1)." ".mysql_result($data140,$vosoba,2)." ".mysql_result($data140,$vosoba,3)."</option>";
@$vosoba++;endwhile;
?></select></td>

<td style=width:20%><input type="submit" value="OK" style=width:100%;height:60px;font-size:30pt; style="cursor: pointer;"><br /><br />
<input type="button" value="ZPĚT" style=width:100%;height:60px;font-size:30pt; style="cursor: pointer;" onclick=window.location.href=('<?echo $adresa;?>styden=<?echo $styden;?>') style=width:100%;height:60px;font-size:20pt; ><br /><br />
<?if (mysql_result($data1000,0,8)) {?><input type="button" value="ZRUŠ" style=width:100%;height:60px;font-size:30pt; style="cursor: pointer;" onclick=window.location.href=('<?echo $adresa;?>styden=<?echo $styden;?>&remove=<?echo @$_GET["transfer"];?>') style=width:100%;height:60px;font-size:20pt;background:url(picture\jidlonosic1.bmp); ><?}?>
</td>
</tr></table></form><?} // konec přesunu







 // vyber obedu a vedlejsi stravy
if (@$_GET["odatum"]<>""){ $rozklad=explode("-",@$_GET["odatum"]);$cdne= date("w", strtotime($rozklad[2]."-".$rozklad[1]."-".$rozklad[0]));
if(@$cdne==1) {$dname="Pondělí";}if(@$cdne==2) {$dname="Úterý";}if(@$cdne==3) {$dname="Středa";}if(@$cdne==4) {$dname="Čtvrtek";}if(@$cdne==5) {$dname="Pátek";}if(@$cdne==6) {$dname="Sobota";}if(@$cdne==0) {$dname="Neděle";}
$hlavicka=$dname." ".date("d.m.Y", strtotime($rozklad[2]."-".$rozklad[1]."-".$rozklad[0]));
@$polevka=mysql_result(mysql_query("select obed from seznam_obedu where datum='".securesql(@$_GET["odatum"])."' and skupina='$numberlaunch2[0]' "),0,0);?>
<table border=1 bgcolor=#DFDFDF style="font-size: 20pt;" frame="border" rules=all width=95%>
<tr bgcolor=#CDC5FC><td align=center colspan=3 bgcolor=#CDC5FC >Menu: <?echo $hlavicka;?></td></tr><tr><td colspan=3 align=center style=font-size:18px>Polévka: <?echo@$polevka;?></td></tr>
<?
// vypis=1 : vynecha polivku na prvni pozici
$vypis=1;while($vypis<($numberlaunch[1])):

// vypocet limit casu pro objednani
$aktdatetime = $dnes." ".$cas;@$objcas=explode(":",$numberlaunch4[$vypis]);
if (@$objcas[0]>=0) {if (@$objcas[0]<10) {$maxobjdatetime = $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." 0".@$objcas[0].":".@$objcas[1].":00";} else {$maxobjdatetime = $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." ".@$objcas[0].":".@$objcas[1].":00";}}
if (@$objcas[0]<0) {$numberlaunch4[$vypis]=-@$objcas[0];$pdni=ceil ($numberlaunch4[$vypis]/24);

// kontrola svatku je dvakrat z duvodu mozneho odsunu na vikend
$dsvatku= date("-m-d", strtotime( $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." - ".$pdni." day"));$dsvatku1= date("Y-m-d", strtotime( $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." - ".$pdni." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
while ($svatek<>"" and $numberlaunch6[0]=="NE"):$pdni++;
$dsvatku= date("-m-d", strtotime( $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." - ".$pdni." day"));$dsvatku1= date("Y-m-d", strtotime( $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." - ".$pdni." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
endwhile;
//kontrola vikendu
if ($numberlaunch5[0]=="NE" and date("w", strtotime( $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." - ".$pdni." day"))==0) {$pdni=$pdni+2;}
if ($numberlaunch5[0]=="NE" and date("w", strtotime( $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." - ".$pdni." day"))==6) {$pdni=$pdni+1;}
// kontrola svatku
$dsvatku= date("-m-d", strtotime( $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." - ".$pdni." day"));$dsvatku1= date("Y-m-d", strtotime( $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." - ".$pdni." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
while ($svatek<>"" and $numberlaunch6[0]=="NE"):$pdni++;
$dsvatku= date("-m-d", strtotime( $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." - ".$pdni." day"));$dsvatku1= date("Y-m-d", strtotime( $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." - ".$pdni." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedinečný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
endwhile;


	$maxobjdatetime= date("Y-m-d", strtotime( $rozklad[0]."-".$rozklad[1]."-".$rozklad[2]." - ".$pdni." day"));
	if (@$objcas[1]>0) {$chod=23;} else {$chod=24;}
	if ((24-$numberlaunch4[$vypis])<10) {$maxobjdatetime.=" 0".($chod-$numberlaunch4[$vypis]).":".(60-@$objcas[1]).":00";} else {$maxobjdatetime.=" ".($chod-$numberlaunch4[$vypis]).":".(60-@$objcas[1]).":00";}
}
// konec vypoctu

// posledni datum objednani pro aktualni obed po casovem terminu
$rozpad=explode (" ",$maxdencas[$cdne]);$maxden=$rozpad[0];$maxcas=$rozpad[1];

echo"<tr style=height:60px;";if ($aktdatetime<$maxobjdatetime and (!StrPos (" " . @$numberlaunch7[$vypis], "HPL") or (StrPos (" " . @$numberlaunch7[$vypis], "HPL") and (@$_GET["odatum"]>$dnes or (@$_GET["odatum"]==$dnes and mysql_result(mysql_query("select COUNT(id) from objednavky_obedu where datum='".securesql(@$_GET["odatum"])."' and (datumvkladu>'$maxden' or (datumvkladu='$maxden' and casobj>'$maxcas')) and skupina='".securesql($numberlaunch2[$vypis])."' "),0,0)<$numberlaunch1[9]))) )) {echo"cursor:pointer; ";
if (mysql_result(mysql_query("select obed from seznam_obedu where datum='".securesql(@$_GET["odatum"])."' and skupina='$numberlaunch2[$vypis]' "),0,0)) {
if (!StrPos (" " . @$numberlaunch7[$vypis], "H")) {echo " onmouseover=className='menuonv'; onmouseout=className='menuoffv';  bgcolor=#B0ABEB onclick=window.location.href=('".$_SERVER['REQUEST_URI']."&vvybrano=".$numberlaunch2[$vypis]."') ";} else {echo " onmouseover=className='menuon'; onmouseout=className='menuoff'; onclick=window.location.href=('".$_SERVER['REQUEST_URI']."&vybrano=".$numberlaunch2[$vypis]."')";}} else {echo " style=color:#B0B0B0";}} else {echo " style=color:#B0B0B0";}
echo"> <td align=center>".$numberlaunch2[$vypis]."</td><td style=width:75% align=center style=font-size:18px wrap=on>".
mysql_result(mysql_query("select obed from seznam_obedu where datum='".securesql(@$_GET["odatum"])."' and skupina='$numberlaunch2[$vypis]' "),0,0)."</td>
<td align=right style=font-size:18px>".mysql_result(mysql_query("select cena from seznam_obedu where datum='".securesql(@$_GET["odatum"])."' and skupina='$numberlaunch2[$vypis]' "),0,0)." Kč</td></tr>";

@$vypis++;endwhile;?>
</table><?} //konec vyberu obedu a vedlejsi stravy
?>
</td></tr>

<?}

















// spatny pokus
if (@$pokus=="false"){if (@$oscislo<>"" and @$oscislo<>"null"){	?>
<div style=position:relative;top:185px;left:-500px; align=center><div style=position:absolute;top:155px;left:15%; align=center><span style="font-size: 50pt;color=#EA1318;" ><b><?echo @$text;?>
ŠPATNÝ POKUS<br /><IMG SRC=picture/no.gif width=100>
</b></span></div><div><?}?>
<script language="JavaScript">setTimeout('window.location.href="DScan.php"', 2000)</script>
<?}

// nema pravo na obed
if (@$pravo=="NE" and @$text=="Objednání Obědů" ){?>
<div style=position:relative;top:185px;left:-500px; align=center><div style=position:absolute;top:155px;left:15%; align=center><span style="font-size: 50pt;color=#EA1318;" ><b><?echo @$text;?>
<br />Nemáte Právo na Dotovaný Oběd<br /><IMG SRC=picture/no.gif width=100>
</b></span></div><div>
<script language="JavaScript">setTimeout('window.location.href="DScan.php"', 3000)</script>
<?}




// zadost o aktivaci
if (@$numlock<>"" and @$text=="Žádost o Aktivaci" and @$jmeno=="" and @$oscislo<>"null" and  $delka=="YES"){include ("./"."dbconnect.php");?>
<tr><td width=100% align=center vertical-align=bottom><span style="font-size: 50pt;color=#EA1318"><b><?echo @$text;?>
<?$control= mysql_num_rows(mysql_query("select cip from zadost where cip='$oscislo'"));

$control1= mysql_num_rows(mysql_query("select cip from cipy where cip='$oscislo' and (platnostdo='0000-00-00' or platnostdo>='$dnes') "));

if (@$control==false and $control1==false) {mysql_query ("INSERT INTO zadost (cip,datum,cas,operace,potvrzeno) VALUES('$oscislo','$dnes','$cas','$numlock','NE')") or Die(MySQL_Error());echo " byla zaregistrována";}
if (@$control<>false) {echo " již byla přijata";}
if (@$control1<>false) {echo " Čip je již Aktivní";}?>
</b></span></td>
<script language="JavaScript">setTimeout('window.location.href="DScan.php"', 2000)</script>
<?}





// zadost o aktivaci cip je aktivni
if (@$numlock<>"" and @$text=="Žádost o Aktivaci" and @$jmeno<>"" and @$oscislo<>"null" and  $delka=="YES" ){?>
<tr><td width=50% align=center vertical-align=bottom><span style="font-size: 50pt;color=#EA1318"><b>Čip je Aktivní</b></span></td>
<td width=50% align=center><span style="font-size: 30pt;color:#000000"><b>IDENTIFIKACE:</span>
<br /><br />
<span style="font-size: 50pt;color:#8249DE">
<?echo@$usernumber."<br />".@$jmeno."<br />";?>
<br /></b></span></td></tr>
<script language="JavaScript">setTimeout('window.location.href="DScan.php"', 2000)</script>
<?}




// ulozeni pri,odch,.... krome zadosti o aktivaci
if (@$numlock<>"" and @$oscislo<>"null" and @$text<>"Objednání Obědů" and @$text<>"Žádost o Aktivaci" and @$text<>"Zobrazit Stav Docházky" and @$jmeno<>"" and  $delka=="YES"){if ($vykaz=="ANO") {?><script language="JavaScript">window.location.href="DScan.php"</script><?}?>

<tr><td width=50% align=center vertical-align=bottom><span style="font-size: 60pt;color=#EA1318"><b><?echo @$text;?></b></span><br /><image src="picture/yes.gif" width=100px>

<!--//vypis obedu//-->
<br /><?$data150=mysql_query("select * from objednavky_obedu where (osobni_cislo='".securesql($usernumber)."' or tr_osobni_cislo='".securesql($usernumber)."') and datum='$dnes' order by skupina,id");
if (mysql_num_rows($data150)) {?><table style="font-size: 30pt;color=#000000" border=1 width=98%><tr align=center bgcolor=#CDC9F5><td colspan=2>Dnešní Oběd</td></tr>
<?$write=0;while(@$write<mysql_num_rows($data150)):
$vedlejsi=explode("+:+",mysql_result(@$data150,@$write,12));
echo "<tr align=center bgcolor=#CEDCEA><td width=10%>".mysql_result(@$data150,@$write,3);if ($vedlejsi[0]){echo "<br />".$vedlejsi[0];}echo"</td><td>".mysql_result(@$data150,@$write,4);if ($vedlejsi[1]){echo "<br />".$vedlejsi[1];}
if (mysql_result(@$data150,@$write,8)){echo"<br />Vyzvedne: ".mysql_result(@$data150,@$write,8)." ".mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno) from zamestnanci where osobni_cislo='".securesql(mysql_result(@$data150,@$write,8))."' "),0,0);}echo"</td></tr>";
@$write++;endwhile;?></table><?}?>


</td>
<td width=50% align=center><span style="font-size: 30pt;color:#000000"><b>IDENTIFIKACE:</span>
<br /><br />
<span style="font-size: 50pt;color:#8249DE">
<?echo@$usernumber."<br />".@$jmeno."<br />"; include ("./dbconnect.php");
mysql_query ("INSERT INTO dochazka (cip,datum,cas,operace,potvrzeno,osobni_cislo,obdobi,stredisko) VALUES('$oscislo','$dnes','$cas','$numlock','NE','$usernumber','$obdobi','$stredisko')") or Die(MySQL_Error());
?>
<br /></b></span></td>
</tr>
<script language="JavaScript">setTimeout('window.location.href="DScan.php"', 4000)</script>
<?}





// pokus o ulozeni pri,odch,.... krome zadosti o aktivaci  cip neni aktivni
if (@$numlock<>"" and @$oscislo<>"null" and @$text<>"Objednání Obědů" and @$text<>"Žádost o Aktivaci" and @$text<>"Zobrazit Stav Docházky" and @$jmeno=="" and  $delka=="YES" ){?>
<tr><td width=50% align=center vertical-align=bottom><span style="font-size: 50pt;color=#EA1318"><b><?echo @$text;?></b></span></td>
<td width=50% align=center><span style="font-size: 30pt;color:#000000"><b>IDENTIFIKACE:</span>
<br /><br />
<span style="font-size: 50pt;color:#8249DE">
<?echo" Čip není Aktivní <br /> Zažádejte o jeho Aktivaci<br />";
include ("./"."dbconnect.php");
$vlastnik=mysql_result(mysql_query("select osobni_cislo from cipy where cip='$oscislo' order by id DESC"),0,0);
if (@$vlastnik=="") {@$vlastnik="Čip není veden v Databázi";}

// poslat všem email
  require "class.phpmailer.php";
  $mail = new PHPMailer();
  $mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
  $mail->Host = "192.168.200.1";  // zadáme adresu SMTP serveru
  $mail->SMTPAuth = false;               // nastavíme true v případě, že server vyžaduje SMTP autentizaci
  $mail->Username = "admin";   // uživatelské jméno pro SMTP autentizaci
  $mail->Password = "";            // heslo pro SMTP autentizaci
  $mail->From = "admin@heunisch-brno.cz";   // adresa odesílatele skriptu
  $mail->FromName = "Docházkový Systém"; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)

@$data1 = mysql_query("select * from security order by id ASC") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($data1)):
$mail->AddAddress (mysql_result(@$data1,@$cykl,1),"");
@$cykl++;endwhile;

  $mail->Subject = "Pokus o Přístup cizím čipem";    // nastavíme předmět e-mailu
  $mail->Body = "Čip:".$oscislo."\r\n v: ".@$dnescs." ".@$cas."\r\n Poslední Vlastník Čipu: ".$vlastnik;  // nastavíme tělo e-mailu
  $mail->WordWrap = 50;   // je vhodné taky nastavit zalomení (po 50 znacích)
  $mail->CharSet = "windows-1250";   // nastavíme kódování, ve kterém odesíláme e-mail

  if(!$mail->Send()) {  // odešleme e-mail
     echo 'Došlo k chybě při odeslání e-mailu.';
     echo 'Chybová hláška: ' . $mail->ErrorInfo;
  }

?>

<br /></b></span></td>
</tr>
<script language="JavaScript">setTimeout('window.location.href="DScan.php"', 2000)</script>
<?}?>






<?mysql_close();?>
</table></center>

<?
if (@$numlock<>"" and @$text=="Zobrazit Stav Docházky" and @$jmeno<>"" and @$oscislo<>"null" and $delka=="YES"){?><div style="position:absolute;top:0%;left:0%"><input type="button" value="Dnešní Oběd" style=width:240px;height:70px;font-size:30pt;color:red; style="cursor: pointer;" onclick=window.open('aktobed.php?usernumber=<?echo $usernumber;?>','Dnešní_Oběd','fullscreen=yes,titlebar=no,toolbar=no,location=no,addressbar=no,statusbar=yes,scrollbars=yes,resizable=no,left=300,top=200')></div><?}

if (@$numlock<>"" and oscislo<>"null") {?><div style="position:absolute;top:0%;right:0%"><input type="button" value="HOTOVO" style="width:200px;height:70px;font-size:30pt;color:red;cursor:pointer;" onclick=window.location.href=('<?echo $_SERVER['SCRIPT_NAME'];?>') ></div><?}?>
</body>