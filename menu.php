<?echo@$datum;?>
<form action=hlavicka.php method=post>
<table width=100% Border=1 bgcolor="#1CBDFB"><tr>

<td width=12% rowspan=6 bgcolor="#1CBDFB" valign=middle align=center><?include "kalendar.php";?><input type="button" value="Napi�te Administr�torovi" style=width:100% onClick="parent.location='mailto:lsvoboda@heunisch-brno.cz'"></td>
<td align="center" style=font-size:20px width=72%><b>Doch�zkov�/Stravovac�/Turniket Syst�m</b></td><td align=center width=19% bgcolor=#DDC6BF><b><?echo "<font color=#7C52C2>P�ihl�en: </font>".$_SESSION['loginname'];?></b></td></tr>
<tr><td colspan=2><table width=100% Border=1 bgcolor="#FFC891">
<tr align=middle style=font-size:20px>
<td width=17% bgcolor="#CBD73E" colspan=2><center><b>��seln�ky</b></center></td>
<td width=17% bgcolor="#CBD73E"><b>V�kazy a Reporty <a href="UserManual.pdf" target=_blank><img src="picture/help.png" width="16" height="16" title="Manu�l" border="0"></a></b></td>
<td width=17% bgcolor="#CBD73E"><b>Extern� Moduly</b></td>
<td width=17% bgcolor="#CBD73E"><b>Spr�va Syst�mu</b></td>
<td width=17% rowspan=5 bgcolor="#FFFFFF" valign=top style="background-image : URL(logo.php);background-repeat: no-repeat;background-position:center top;">
<?
$preskoc=mysql_result(mysql_query("select odkaz from firma where id='1' "),0,0);
if (mysql_result(mysql_query("select hodnota from setting where nazev='MSn�ma�' "),0,0)=="Numlock") {$loadhardware="Scan";}
if (mysql_result(mysql_query("select hodnota from setting where nazev='MSn�ma�' "),0,0)=="Dotykov� Obrazovka (+Ob�dy)") {$loadhardware="DScan";}
if (mysql_result(mysql_query("select hodnota from setting where nazev='MSn�ma�' "),0,0)=="Dot. Obr. (+Ob�dy&Info)") {$loadhardware="DIScan";}


if (@$preskoc<>"") {?><a href="<?echo@$preskoc;?>" target=_blank><?} else {?><a href=http://www.Kliknetezde.Cz target=_blank><?}?></a>
<marquee direction="up" width=256pt height=150pt scrolldelay="50" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start();"><center>
<font face="Monotype Corsiva" style="font-size: 15pt"><br />
V p��pad� nalezen� chyby<br /> Napi�te administr�torovi<br />nebo volejte klapku 573</font></center>
</marquee><br /><br />
<center><font style="font-size: 7pt;">Copyright � 2008 - 2011, <a href="mailto:Libor.Svoboda@KlikneteZde.Cz" title="KlikneteZde.Cz">Libor Svoboda</a> <a href="http://www.KlikneteZde.Cz" title="KlikneteZde.Cz" target="_blank">KlikneteZde.Cz</a>
</td>
</tr>

<tr bgcolor="#FFC891">
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('CiselnaRada');?>')" value="Automatick� ��seln� �ada" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('NastaveniKlaves');?>')" value="Syst�mov� Nastaven�" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Ukoly');?>')" value="V�kaz Pr�ce-�kol" style=width:100%;></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Stravovani');?>')" value="Stravov�n�" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('FiremniUdaje');?>')" value="Firemn� �daje" style=width:100%></td>

</tr>
<tr bgcolor="#FFC891">
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Kategorie');?>')" value="Nastaven� Kategori�" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Security');?>')" value="Nastaven� Zabezpe�en�" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Karty');?>')" value="Doch�zka Zam�stnanc�" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('FakturaceObedu');?>')"  value="Exporty/Reporty Ob�d�" style=width:100%;></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('SpravaUzivatelu');?>')" value="Spr�va U�ivatel�" style=width:100%></td>

</tr>

<tr bgcolor="#FFC891">
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Strediska');?>')" value="Nastaven� St�edisek" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Ukony');?>')" value="Nastaven� Druh� Z�znam�" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Reporty');?>')" value="Reporty" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Turnikety');?>')" value="Turnikety" style=width:100%;></td>
<td width=13.3%><input type=button onClick="window.location.href('index.php');" style=width:100% value="Na��st Zm�ny P��stupov�h Pr�v"></td>

</tr>

<tr bgcolor="#FFC891">
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('Zamestnanci');?>')" value="Nastaven� Zam�stnanc�" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('import');?>')" value="Import z Heliosu" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('export');?>')" value="Export pro Helios" style=width:100%></td>
<td width=13.3%><input type="Button" onclick="window.location.assign('hlavicka.php?akce=<?echo base64_encode('KnihaUrazu');?>')" value="Kniha �raz�" style=width:100%></td>
<td width=13.3%><button onClick="window.close()" style=width:100%>Zav��t Program</button></td>

</tr>


</table></td></tr></table></form>