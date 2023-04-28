<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];

@$nazev=@$_POST["nazev"];
@$stav=@$_POST["stav"];
@$ipadresa=@$_POST["ipadresa"];
@$user=@$_POST["user"];


// práce s DB


if (@$menu=="Založení Nového Turniketu" and @$tlacitko=="Uložit Nový Turniket") {mysql_query ("INSERT INTO turnikety (nazev,ip_adresa,stav,datumvkladu,vlozil,den1,den2,den3,den4,den5,den6,den7,ip_kamery,jmeno,heslo,typ) VALUES('".securesql($nazev)."','".securesql($ipadresa)."','".securesql($stav)."', '$dnes','$loginname','".securesql(@$_POST["den1"])."','".securesql(@$_POST["den2"])."','".securesql(@$_POST["den3"])."','".securesql(@$_POST["den4"])."','".securesql(@$_POST["den5"])."','".securesql(@$_POST["den6"])."','".securesql(@$_POST["den7"])."','".securesql(@$_POST["ipkamera"])."','".securesql(@$_POST["kname"])."','".securesql(@$_POST["kpasswd"])."','".securesql(@$_POST["typkamera"])."')") or Die(MySQL_Error());
$lastid= mysql_insert_id();

if (@$user=="on") {$vsichni=mysql_query("select osobni_cislo,turnikety from zamestnanci where (datumout='0000-00-00' or datumout >= '$dnes') order by osobni_cislo,id") or Die(MySQL_Error());
$cykl=0;while (@$cykl<mysql_num_rows($vsichni)):
if (!StrPos (" " . mysql_result($vsichni,@$cykl,1), ",".$lastid.",")) {mysql_query("update zamestnanci set turnikety='".mysql_result($vsichni,@$cykl,1).$lastid.",' where osobni_cislo='".mysql_result($vsichni,@$cykl,0)."' ") or Die(MySQL_Error());}
@$cykl++;endwhile;}?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Nového Turnikeu Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";@$ipadresa="";@$user="";$nazev="";}


if (@$menu=="Upravení Existujícího Turniketu" and @$tlacitko=="Uložit Upravený Turniket") {
mysql_query ("update turnikety set ip_adresa='".securesql($ipadresa)."' ,stav='".securesql($stav)."' ,datumzmeny='$dnes',zmenil='$loginname',den1='".securesql(@$_POST["den1"])."',den2='".securesql(@$_POST["den2"])."',den3='".securesql(@$_POST["den3"])."',den4='".securesql(@$_POST["den4"])."',den5='".securesql(@$_POST["den5"])."',den6='".securesql(@$_POST["den6"])."',den7='".securesql(@$_POST["den7"])."',ip_kamery='".securesql(@$_POST["ipkamera"])."',jmeno='".securesql(@$_POST["kname"])."',heslo='".securesql(@$_POST["kpasswd"])."',typ='".securesql(@$_POST["typkamera"])."' where nazev='".securesql($nazev)."' ") or Die(MySQL_Error());
$lastid= mysql_result(mysql_query ("select id from turnikety where nazev='".securesql($nazev)."' "),0,0);

if (@$user=="on") {
$vsichni=mysql_query("select osobni_cislo,turnikety from zamestnanci where (datumout='0000-00-00' or datumout >= '$dnes') order by osobni_cislo,id") or Die(MySQL_Error());
$cykl=0;while (@$cykl<mysql_num_rows($vsichni)):
if (!StrPos (" " . mysql_result($vsichni,@$cykl,1), ",".$lastid.",")) {mysql_query("update zamestnanci set turnikety='".mysql_result($vsichni,@$cykl,1).$lastid.",' where osobni_cislo='".mysql_result($vsichni,@$cykl,0)."' ") or Die(MySQL_Error());}
@$cykl++;endwhile;}?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Nového Turnikeu Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";@$ipadresa="";@$user="";$nazev="";}


if (@$menu=="Odstranìní Existujícího Turniketu" and @$tlacitko=="Odstranit Vybraný Turniket") {

mysql_query("delete from turnikety where nazev='".securesql($nazev)."' ");

?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Nového Turnikeu Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";@$ipadresa="";$nazev="";}

?>

<form action="hlavicka.php?akce=<?echo base64_encode('Turnikety');?>" method=post>

<h2><p align="center">Nastavení Turniketù:
<? if (StrPos (" " . $_SESSION["prava"], "T") or StrPos (" " . $_SESSION["prava"], "t")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "T")){?>
   <?if (@$menu<>"Založení Nového Turniketu"){?><option>Založení Nového Turniketu</option><?}?>
   <?if (@$menu<>"Upravení Existujícího Turniketu"){?><option>Upravení Existujícího Turniketu</option><?}?>
   <?if (@$menu<>"Odstranìní Existujícího Turniketu"){?><option>Odstranìní Existujícího Turniketu</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "T") or StrPos (" " . $_SESSION["prava"], "t")){?>
   <?if (@$menu<>"Pøehled Existujících Turniketù"){?><option>Pøehled Existujících Turniketù</option><?}?>
   <?if (@$menu<>"Tisk Turniketù"){?><option>Tisk Turniketù</option><?}?>
<?}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "T") and (!StrPos (" " . $_SESSION["prava"], "t")) ){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "T")){?>


<?if (@$menu=="Založení Nového Turniketu"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Zde založíte turniket, dále je nutné nastavit daný turniket aktivním uživatelùm" border="0"> </b></center></td></tr>
<tr><td>Název Turniketu :</td><td colspan=2><input type="text" name=nazev value="" size="28"></td></tr>
<tr><td>IP Adresa Turniketu :</td><td colspan=2><input type="text" name=ipadresa value="" size="28"></td></tr>
<tr><td>Stav Turniketu :</td><td colspan=2><select size="1" width=100% name="stav"><option>Aktivní</option><option>Neaktivní</option></select>
 Pøiøadit Všem:<input name="user" type="checkbox"></td></tr>
<tr><td colspan=3 bgcolor="#C0FFC0" align=center><b>Nastavení Prùchodù <img src="picture/help.png" width="16" height="16" title="èas se zapisuje formou 08:00-23:59" border="0"> </b></td></tr>
<tr><td>Pondìlí: </td><td colspan=2><input name="den1" type="text" value="" style=width:100%></td></tr>
<tr><td>Úterý: </td><td colspan=2><input name="den2" type="text" value="" style=width:100%></td></tr>
<tr><td>Støeda: </td><td colspan=2><input name="den3" type="text" value="" style=width:100%></td></tr>
<tr><td>Ètvrtek: </td><td colspan=2><input name="den4" type="text" value="" style=width:100%></td></tr>
<tr><td>Pátek: </td><td colspan=2><input name="den5" type="text" value="" style=width:100%></td></tr>
<tr><td>Sobota: </td><td colspan=2><input name="den6" type="text" value="" style=width:100%></td></tr>
<tr><td>Nedìle: </td><td colspan=2><input name="den7" type="text" value="" style=width:100%></td></tr>
<tr><td colspan=3 bgcolor="#C0FFC0" align=center><b>Nastavení Kamery</b></td></tr>
<tr><td>Typ Kamery: </td><td colspan=2><select size="1" name="typkamera" style=width:100%><option value="value1">AIRLIVE</option><option value="value1">TPLINK</option></select></td></tr>
<tr><td>IP Adresa Kamery: </td><td colspan=2><input name="ipkamera" type="text" value="" style=width:100%></td></tr>
<tr><td>Login Name: </td><td colspan=2><input name="kname" type="text" value="" style=width:100%></td></tr>
<tr><td>Login Passwd: </td><td colspan=2><input name="kpasswd" type="text" value="" style=width:100%></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uložit Nový Turniket"></center><BR></td></tr><?}?>



<?if (@$menu=="Upravení Existujícího Turniketu"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Zde upravíte turniket, dále je nutné nastavit daný turniket aktivním uživatelùm" border="0"></b></center></td></tr>
<tr><td>Název Turniketu :</td><td colspan=2><select size="1" <?if (@$nazev<>"") {echo"style=width:100%";}?> name="nazev" onchange=submit(this)>
<?if (@$nazev<>"") {echo"<option>".@$nazev."</option>";} else {echo"<option></option>";}
@$data1=mysql_query("select * from turnikety order by nazev,id");
@$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,1)<>@$nazev){echo"<option>".mysql_result($data1,@$cykl,1)."</option>";}
@$cykl++;endwhile;?></select></td></tr>
<?if (@$nazev<>"") {@$data2=mysql_query("select * from turnikety where nazev='".securesql($nazev)."' ");?>
<tr><td>IP Adresa Turniketu :</td><td colspan=2><input type="text" name=ipadresa value="<?echo mysql_result($data2,0,2);?>" size="28"></td></tr>
<tr><td>Stav Turniketu :</td><td colspan=2><select size="1" width=100% name="stav">
<?if (mysql_result($data2,0,3)=="Aktivní") {echo "<option>Aktivní</option><option>Neaktivní</option>";} else {echo "<option>Neaktivní</option><option>Aktivní</option>";}?>
</select>
 Pøiøadit Všem:<input name="user" type="checkbox"></td></tr>
<tr><td colspan=3 bgcolor="#C0FFC0" align=center><b>Nastavení Prùchodù <img src="picture/help.png" width="16" height="16" title="èas se zapisuje formou 08:00-23:59" border="0"> </b></td></tr>
<tr><td>Pondìlí: </td><td colspan=2><input name="den1" type="text" value="<?echo mysql_result(@$data2,0,8);?>" style=width:100%></td></tr>
<tr><td>Úterý: </td><td colspan=2><input name="den2" type="text" value="<?echo mysql_result(@$data2,0,9);?>" style=width:100%></td></tr>
<tr><td>Støeda: </td><td colspan=2><input name="den3" type="text" value="<?echo mysql_result(@$data2,0,10);?>" style=width:100%></td></tr>
<tr><td>Ètvrtek: </td><td colspan=2><input name="den4" type="text" value="<?echo mysql_result(@$data2,0,11);?>" style=width:100%></td></tr>
<tr><td>Pátek: </td><td colspan=2><input name="den5" type="text" value="<?echo mysql_result(@$data2,0,12);?>" style=width:100%></td></tr>
<tr><td>Sobota: </td><td colspan=2><input name="den6" type="text" value="<?echo mysql_result(@$data2,0,13);?>" style=width:100%></td></tr>
<tr><td>Nedìle: </td><td colspan=2><input name="den7" type="text" value="<?echo mysql_result(@$data2,0,14);?>" style=width:100%></td></tr>
<tr><td colspan=3 bgcolor="#C0FFC0" align=center><b>Nastavení Kamery</b></td></tr>
<tr><td>Typ Kamery: </td><td colspan=2><select size="1" name="typkamera" style=width:100%>
<?if (mysql_result(@$data2,0,18)=="AIRLIVE"){echo "<option>AIRLIVE</option><option>TPLINK</option>";}
  if (mysql_result(@$data2,0,18)=="TPLINK"){echo"<option>TPLINK</option><option>AIRLIVE</option>";}?>
</select></td></tr>
<tr><td>IP Adresa Kamery: </td><td colspan=2><input name="ipkamera" type="text" value="<?echo mysql_result(@$data2,0,15);?>" style=width:100%></td></tr>
<tr><td>Login Name: </td><td colspan=2><input name="kname" type="text" value="<?echo mysql_result(@$data2,0,16);?>" style=width:100%></td></tr>
<tr><td>Login Passwd: </td><td colspan=2><input name="kpasswd" type="text" value="<?echo mysql_result(@$data2,0,17);?>" style=width:100%></td></tr>

<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uložit Upravený Turniket"></center></td></tr><?}}?>


<?if (@$menu=="Odstranìní Existujícího Turniketu"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Zde upravíte turniket, dále je nutné nastavit daný turniket aktivním uživatelùm" border="0"></b></center></td></tr>
<tr><td>Název Turniketu :</td><td colspan=2><select size="1" <?if (@$nazev<>"") {echo"style=width:100%";}?> name="nazev" onchange=submit(this)>
<?if (@$nazev<>"") {echo"<option>".@$nazev."</option>";} else {echo"<option></option>";}
@$data1=mysql_query("select * from turnikety where id not in (select id_turniketu from pruchody group by id_turniketu order by id_turniketu,id) order by nazev,id");
@$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,1)<>@$nazev){echo"<option>".mysql_result($data1,@$cykl,1)."</option>";}
@$cykl++;endwhile;?></select></td></tr>
<?if (@$nazev<>"") {@$data2=mysql_query("select * from turnikety where nazev='".securesql($nazev)."' ");?>
<tr><td>IP Adresa Turniketu :</td><td colspan=2><input type="text" name=ipadresa value="<?echo mysql_result($data2,0,2);?>" size="28" readonly=yes></td></tr>
<tr><td>Stav Turniketu :</td><td colspan=2><select size="1" width=100% name="stav" disabled>
<?if (mysql_result($data2,0,3)=="Aktivní") {echo "<option>Aktivní</option><option>Neaktivní</option>";} else {echo "<option>Neaktivní</option><option>Aktivní</option>";}?>
</select>
 Pøiøadit Všem:<input name="user" type="checkbox" disabled></td></tr>
 <tr><td colspan=3 bgcolor="#C0FFC0" align=center><b>Nastavení Prùchodù <img src="picture/help.png" width="16" height="16" title="èas se zapisuje formou 08:00-23:59" border="0"> </b></td></tr>
<tr><td>Pondìlí: </td><td colspan=2><input name="den1" type="text" value="<?echo mysql_result(@$data2,0,8);?>" style=width:100% disabled></td></tr>
<tr><td>Úterý: </td><td colspan=2><input name="den2" type="text" value="<?echo mysql_result(@$data2,0,9);?>" style=width:100% disabled></td></tr>
<tr><td>Støeda: </td><td colspan=2><input name="den3" type="text" value="<?echo mysql_result(@$data2,0,10);?>" style=width:100% disabled></td></tr>
<tr><td>Ètvrtek: </td><td colspan=2><input name="den4" type="text" value="<?echo mysql_result(@$data2,0,11);?>" style=width:100% disabled></td></tr>
<tr><td>Pátek: </td><td colspan=2><input name="den5" type="text" value="<?echo mysql_result(@$data2,0,12);?>" style=width:100% disabled></td></tr>
<tr><td>Sobota: </td><td colspan=2><input name="den6" type="text" value="<?echo mysql_result(@$data2,0,13);?>" style=width:100% disabled></td></tr>
<tr><td>Nedìle: </td><td colspan=2><input name="den7" type="text" value="<?echo mysql_result(@$data2,0,14);?>" style=width:100% disabled></td></tr>
<tr><td colspan=3 bgcolor="#C0FFC0" align=center><b>Nastavení Kamery</b></td></tr>
<tr><td>Typ Kamery: </td><td colspan=2><select size="1" name="typkamera" style=width:100% disabled=disabled>
<?if (mysql_result(@$data2,0,18)=="AIRLIVE"){echo "<option>AIRLIVE</option><option>TPLINK</option>";}
  if (mysql_result(@$data2,0,18)=="TPLINK"){echo"<option>TPLINK</option><option>AIRLIVE</option>";}?>
</select></td></tr>
<tr><td>IP Adresa Kamery: </td><td colspan=2><input name="ipkamera" type="text" value="<?echo mysql_result(@$data2,0,15);?>" style=width:100% disabled></td></tr>
<tr><td>Login Name: </td><td colspan=2><input name="kname" type="text" value="<?echo mysql_result(@$data2,0,16);?>" style=width:100% disabled></td></tr>
<tr><td>Login Passwd: </td><td colspan=2><input name="kpasswd" type="text" value="<?echo mysql_result(@$data2,0,17);?>" style=width:100% disabled></td></tr>

<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Odstranit Vybraný Turniket"></center></td></tr><?}}?>



<?}?>






<? if (StrPos (" " . $_SESSION["prava"], "T") or  StrPos (" " . $_SESSION["prava"], "t") ){?>

<?if (@$menu=="Tisk Turniketù"){?>
<script type="text/javascript">
window.open('TiskTurniketu.php')
</script>
<?}?>


<?if (@$menu=="Pøehled Existujících Turniketù"){?>
<tr bgcolor="#C0FFC0" align=center><td colspan=4><center><b> <?echo@$menu;?> </b></center></td></tr>
<tr bgcolor="#C0FFC0" align=center><td> Poøadí </td><td><center> Název </center></td><td><center> IP Adresa </center></td><td><center> Stav </center></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from turnikety order by nazev,id");@$cykl=0;
while (@$cykl<mysql_num_rows($data1)):

?><tr><td><?echo@$cykl+1;?></td>
<td><center><?echo mysql_result($data1,@$cykl,1);?></center></td>
<td><center><?echo mysql_result($data1,@$cykl,2);?></center></td>
<td><center><?echo mysql_result($data1,@$cykl,3);?></center></td>
</tr><?

@$cykl++;endwhile;}?>

<?}?>






</table></center>
</form>
