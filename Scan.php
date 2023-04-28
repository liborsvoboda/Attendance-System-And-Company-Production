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
?>
</head>





<?
@$dnes=date("Y-m-d");@$obdobi=date("Y-m");
@$cas=StrFTime("%H:%M:%S", Time());
@$dnescs=date("d.m.Y");

include ("./"."dbconnect.php");@$timetype=mysql_result(mysql_query("select hodnota from setting where nazev='Čas'"),0,0);
include ("./"."numlock$timetype.php");
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
@$zamestnanec=@$usernumber=mysql_result(mysql_query("select osobni_cislo from cipy where cip='$oscislo' and (platnostdo='0000-00-00' or platnostdo>='$dnes')"),0,0);
@$data1 =mysql_query("select * from zamestnanci where osobni_cislo='$usernumber' and (datumout='0000-00-00' or  datumout>='$dnes') and jen_pruchod='NE' ") or Die(MySQL_Error());
@$stredisko=mysql_result(mysql_query("select stredisko from zam_strediska where osobni_cislo='$zamestnanec' and (datumdo='0000-00-00' or datumdo>='$dnes')"),0,0);
if (mysql_num_rows($data1)<>0) {@$jmeno=mysql_result(@$data1,0,2)." ".mysql_result(@$data1,0,3)." ".mysql_result(@$data1,0,4);} else {@$jmeno="";}}


?>


<body onload="updateClock(); setInterval('updateClock()', 1000 );" bgcolor="#E6AD6F" style=margin:0;overflow:hidden;>
<center><table width=100% style=margin:0 cellpadding="0" cellspacing="0" border=0px>
<tr bgcolor=#E6AD6F style=margin:0><td colspan=2 align=center><span style=font-size:50pt><b>DOCHÁZKOVÝ SYSTÉM</b></span></td></tr>
<tr><td colspan=2 align=center><div id="clock" style=width:100%;font-size:60pt>&nbsp;</div></td></tr>







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
if (oscislo==null) {window.location.href="Scan.php?&oscislo="+oscislo;}
if (oscislo.length> 12) {window.location.href="Scan.php?pokus=false&oscislo="+oscislo;}
if (oscislo.length!=12 && oscislo.length< 12) {window.location.href="Scan.php?&oscislo="+oscislo;}
if ("<?echo $oscisla?>".search(","+oscislo+",")<0 && "<?echo $text?>" != "Žádost o Aktivaci" && oscislo.length==12) {window.location.href="Scan.php?numlock=<?echo base64_encode(@$numlock);?>&text=<?echo @$text;?>&cyklus=<?echo base64_encode(@$cyklus);?>&oscislo="+oscislo;}
if ("<?echo $oscisla?>".search(","+oscislo+",")>=0 && "<?echo $text?>" != "Žádost o Aktivaci" && oscislo.length==12) {window.location.href="Scan.php?numlock=<?echo base64_encode(@$numlock);?>&text=<?echo @$text;?>&cyklus=<?echo base64_encode(@$cyklus);?>&oscislo="+oscislo;}
if ("<?echo $text?>"=="Žádost o Aktivaci" && oscislo!="null" && oscislo.length==12) {window.location.href="Scan.php?numlock=<?echo base64_encode(@$numlock);?>&text=<?echo @$text;?>&cyklus=<?echo base64_encode(@$cyklus);?>&oscislo="+oscislo;}
<?}?>
<?if (mysql_result(mysql_query("select hodnota from setting where nazev='Snímač' "),0,0)=="Linux") {?>
if (oscislo==null) {window.location.href="Scan.php";}
if (oscislo.length< 20) {window.location.href="Scan.php?pokus=false";}
if ("<?echo $text?>" != "Žádost o Aktivaci" && oscislo!="null") {window.location.href="Scan.php?numlock=<?echo base64_encode(@$numlock);?>&text=<?echo @$text;?>&cyklus=<?echo base64_encode(@$cyklus);?>&oscislo="+oscislo;}
if ("<?echo $text?>"=="Žádost o Aktivaci" && oscislo!="null") {window.location.href="Scan.php?numlock=<?echo base64_encode(@$numlock);?>&text=<?echo @$text;?>&cyklus=<?echo base64_encode(@$cyklus);?>&oscislo="+oscislo;}
<?}?>
</SCRIPT>
<script language="JavaScript">setTimeout('window.location.href="Scan.php"', 1000)</script>
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
if (@$cykl<10) {$cyklus="0".$cykl;} else {@$cyklus=$cykl;} $datum =$obdobi."-".$cyklus;$in="";$out="";$wout="";$cdne= date("w", strtotime($datum));?>
<tr bgcolor=#FDCC5B >
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

</td></tr></table></td>
<script language="JavaScript">setTimeout('window.location.href="Scan.php"', 30000)</script>
<?}




// spatny pokus
if (@$pokus=="false"){?>
<tr><td width=100% align=center vertical-align=bottom><span style="font-size: 50pt;color=#EA1318"><b><?echo @$text;?>
ŠPATNÝ POKUS<br /><IMG SRC=picture/no.gif width=100>
</b></span></td>
<script language="JavaScript">setTimeout('window.location.href="Scan.php"', 2000)</script>
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
<script language="JavaScript">setTimeout('window.location.href="Scan.php"', 2000)</script>
<?}





// zadost o aktivaci cip je aktivni
if (@$numlock<>"" and @$text=="Žádost o Aktivaci" and @$jmeno<>"" and @$oscislo<>"null" and  $delka=="YES" ){?>
<tr><td width=50% align=center vertical-align=bottom><span style="font-size: 50pt;color=#EA1318"><b>Čip je Aktivní</b></span></td>
<td width=50% align=center><span style="font-size: 30pt;color:#000000"><b>IDENTIFIKACE:</span>
<br /><br />
<span style="font-size: 50pt;color:#8249DE">
<?echo@$usernumber."<br />".@$jmeno."<br />";?>
<br /></b></span></td></tr>
<script language="JavaScript">setTimeout('window.location.href="Scan.php"', 2000)</script>
<?}




// ulozeni pri,odch,.... krome zadosti o aktivaci
if (@$numlock<>"" and @$oscislo<>"null" and @$text<>"Žádost o Aktivaci" and @$text<>"Zobrazit Stav Docházky" and @$jmeno<>"" and  $delka=="YES"){?><tr><td width=50% align=center vertical-align=bottom><span style="font-size: 60pt;color=#EA1318"><b><?echo @$text;?></b></span><br /><image src="picture/yes.gif" width=100px></td>
<td width=50% align=center><span style="font-size: 30pt;color:#000000"><b>IDENTIFIKACE:</span>
<br /><br />
<span style="font-size: 50pt;color:#8249DE">
<?echo@$usernumber."<br />".@$jmeno."<br />"; include ("./dbconnect.php");
mysql_query ("INSERT INTO dochazka (cip,datum,cas,operace,potvrzeno,osobni_cislo,obdobi,stredisko) VALUES('$oscislo','$dnes','$cas','$numlock','NE','$usernumber','$obdobi','$stredisko')") or Die(MySQL_Error());
?>
<br /></b></span></td>
</tr>
<script language="JavaScript">setTimeout('window.location.href="Scan.php"', 2000)</script>
<?}





// pokus o ulozeni pri,odch,.... krome zadosti o aktivaci  cip neni aktivni
if (@$numlock<>"" and @$oscislo<>"null" and @$text<>"Žádost o Aktivaci" and @$text<>"Zobrazit Stav Docházky" and @$jmeno=="" and  $delka=="YES" ){?>
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
<script language="JavaScript">setTimeout('window.location.href="Scan.php"', 2000)</script>
<?}?>






<?mysql_close();?>
</table></center>
</body>