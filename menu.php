<?echo@$datum;?>
<form action=hlavicka.php method=post>
<table width=100% Border=1 bgcolor="#1CBDFB"><tr>

<td width=12% rowspan=6 bgcolor="#1CBDFB" valign=middle align=center><?include "kalendar.php";?><input type="button" value="Napište Administrátorovi" style=width:100% onClick="parent.location='mailto:lsvoboda@heunisch-brno.cz'"></td>
<td align="center" style=font-size:20px width=72%><b>Docházkový/Stravovací/Turniket Systém</b></td><td align=center width=19% bgcolor=#DDC6BF><b><?echo "<font color=#7C52C2>Pøihlášen: </font>".$_SESSION['loginname'];?></b></td></tr>
<tr><td colspan=2><table width=100% Border=1 bgcolor="#FFC891">
<tr align=middle style=font-size:20px>
<td width=17% bgcolor="#CBD73E" colspan=2><center><b>Èíselníky</b></center></td>
<td width=17% bgcolor="#CBD73E"><b>Výkazy a Reporty <a href="UserManual.pdf" target=_blank><img src="picture/help.png" width="16" height="16" title="Manuál" border="0"></a></b></td>
<td width=17% bgcolor="#CBD73E"><b>Externí Moduly</b></td>
<td width=17% bgcolor="#CBD73E"><b>Správa Systému</b></td>
<td width=17% rowspan=5 bgcolor="#FFFFFF" valign=top style="background-image : URL(logo.php);background-repeat: no-repeat;background-position:center top;">
<?
$preskoc=mysql_result(mysql_query("select odkaz from firma where id='1' "),0,0);
if (mysql_result(mysql_query("select hodnota from setting where nazev='MSnímaè' "),0,0)=="Numlock") {$loadhardware="Scan";}
if (mysql_result(mysql_query("select hodnota from setting where nazev='MSnímaè' "),0,0)=="Dotyková Obrazovka (+Obìdy)") {$loadhardware="DScan";}
if (mysql_result(mysql_query("select hodnota from setting where nazev='MSnímaè' "),0,0)=="Dot. Obr. (+Obìdy&Info)") {$loadhardware="DIScan";}


if (@$preskoc<>"") {?><a href="<?echo@$preskoc;?>" target=_blank><?} else {?><a href=http://www.Kliknetezde.Cz target=_blank><?}?></a>
<marquee direction="up" width=256pt height=150pt scrolldelay="50" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start();"><center>
<font face="Monotype Corsiva" style="font-size: 15pt"><br />
V pøípadì nalezení chyby<br /> Napište administrátorovi<br />nebo volejte klapku 573</font></center>
</marquee><br /><br />
<center><font style="font-size: 7pt;">Copyright © 2008 - 2011, <a href="mailto:Libor.Svoboda@KlikneteZde.Cz" title="KlikneteZde.Cz">Libor Svoboda</a> <a href="http://www.KlikneteZde.Cz" title="KlikneteZde.Cz" target="_blank">KlikneteZde.Cz</a>
</td>
</tr>

<tr bgcolor="#FFC891">
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('CiselnaRada');?>')" value="Automatická Èíselná Øada" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('NastaveniKlaves');?>')" value="Systémová Nastavení" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Ukoly');?>')" value="Výkaz Práce-Úkol" style=width:100%;></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Stravovani');?>')" value="Stravování" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('FiremniUdaje');?>')" value="Firemní Údaje" style=width:100%></td>

</tr>
<tr bgcolor="#FFC891">
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Kategorie');?>')" value="Nastavení Kategorií" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Security');?>')" value="Nastavení Zabezpeèení" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Karty');?>')" value="Docházka Zamìstnancù" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('FakturaceObedu');?>')"  value="Exporty/Reporty Obìdù" style=width:100%;></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('SpravaUzivatelu');?>')" value="Správa Uživatelù" style=width:100%></td>

</tr>

<tr bgcolor="#FFC891">
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Strediska');?>')" value="Nastavení Støedisek" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Ukony');?>')" value="Nastavení Druhù Záznamù" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Reporty');?>')" value="Reporty" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Turnikety');?>')" value="Turnikety" style=width:100%;></td>
<td width=13.3%><input type=button onClick="window.location.href('index.php');" style=width:100% value="Naèíst Zmìny Pøístupovýh Práv"></td>

</tr>

<tr bgcolor="#FFC891">
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Zamestnanci');?>')" value="Nastavení Zamìstnancù" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('import');?>')" value="Import z Heliosu" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('export');?>')" value="Export pro Helios" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('KnihaUrazu');?>')" value="Kniha Úrazù" style=width:100%></td>
<td width=13.3%><button onClick="window.close()" style=width:100%>Zavøít Program</button></td>

</tr>


</table></td></tr></table></form>