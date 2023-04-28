<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];

@$nazev=@$_POST["nazev"];
@$predpona=@$_POST["predpona"];
@$hodnota=@$_POST["hodnota"];@$pocet=StrLen(@$hodnota);
@$stav=@$_POST["stav"];

@$popis=@$_POST["popis"];






if (@$nazev<>"" and $hodnota<>"" and @$tlacitko=="Uložit Novou Èíselnou Øadu") {
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
// kontrola narušení Období jiné èíselné øady
@$control1 = mysql_query("select * from ciselnarada where stav='A' order by nazev,id ASC") or Die(MySQL_Error());
@$control=mysql_num_rows($control1);
// konec Kontroly
if (@$control=="") {
mysql_query ("INSERT INTO ciselnarada (nazev,predpona,origvalue,hodnota,stav,pocetmist,popis,datumvkladu,vlozil) VALUES('$nazev','$predpona','$hodnota','$hodnota','$stav','$pocet','$popis','$dnes','$loginname')") or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Nové Èíselné Øady Probìhlo Úspìšnì</b></center></td></tr></table><?}

else {?><table width=100%><tr><td width=100% bgcolor="#F5938D"><center><b>Èíselná Øada nebyla Uložena z dùvodu existence jiné Aktivní Èíselné Øady</b></center></td></tr></table><?}
@$menu="";@$tlacitko="";@$nazev="";}



if (@$nazev<>"" and @$tlacitko=="Uložit Opravenou Èíselnou Øadu") {
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
// kontrola narušení Období jiné èíselné øady
@$control1 = mysql_query("select * from ciselnarada where stav='A' order by nazev,id ASC") or Die(MySQL_Error());
@$control=mysql_num_rows($control1);
// konec Kontroly
if (@$control=="" or (mysql_result($control1,0,1)<>$nazev and $stav<>"A") or (mysql_result($control1,0,1)==$nazev)) {
mysql_query ("update ciselnarada  set predpona = '$predpona',hodnota = '$hodnota',stav = '$stav',pocetmist = '$pocet',popis = '$popis',datumzmeny = '$dnes', zmenil ='$loginname' where nazev = '$nazev' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Upravené Èíselné Øady Probìhlo Úspìšnì</b></center></td></tr></table><?}
else {?><table width=100%><tr><td width=100% bgcolor="#F5938D"><center><b>Úprava Èíselné Øady nebyla Uložena z dùvodu existence jiné Aktivní Èíselné Øady</b></center></td></tr></table><?}
@$menu="";@$tlacitko="";@$nazev="";}


if (@$nazev<>"" and @$tlacitko=="Odstranit Vybranou Èíselnou Øadu") {
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
mysql_query ("delete from ciselnarada where nazev = '$nazev' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Odstranìní Vybrané Èíselné Øady Probìhlo Úspìšnì</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$nazev="";}


?>

<form action="hlavicka.php?akce=<?echo base64_encode('CiselnaRada');?>" method=post>

<h2><p align="center">Správa Èíselné Øady Zamìstnancù:
<? if (StrPos (" " . $_SESSION["prava"], "A") or StrPos (" " . $_SESSION["prava"], "a")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "A")){?>
   <?if (@$menu<>"Založení Nové Èíselné Øady"){?><option>Založení Nové Èíselné Øady</option><?}?>
   <?if (@$menu<>"Úprava Èíselné Øady"){?><option>Úprava Èíselné Øady</option><?}?>
   <?if (@$menu<>"Odstranìní Èíselné Øady"){?><option>Odstranìní Èíselné Øady</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "A") or StrPos (" " . $_SESSION["prava"], "a")){?>
   <?if (@$menu<>"Pøehled Èíselných Øad"){?><option>Pøehled Èíselných Øad</option><?}?>
   <?if (@$menu<>"Tisk Èíselných Øad"){?><option>Tisk Èíselných Øad</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "A") and (!StrPos (" " . $_SESSION["prava"], "a")) ){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "A")){?>

<?if (@$menu=="Založení Nové Èíselné Øady"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr><td>Název Èíselné Øady:</td><td colspan=3><input type="text" name=nazev value="" style="width:100%" style=background-color:#F9C8C8></td></tr>
<tr><td>Pøedpona Èíselné Øady / Poèáteèní Hodnota:</td><td colspan=3><input type="text" name=predpona value="CR" size="10" style=background-color:#F9C8C8 style=text-align:right> <input type="text" name=hodnota value="00000001" size="26" style=background-color:#F9C8C8></td></tr>
<tr><td>Stav:</td><td colspan=3><select name="stav" style=width:100%>
  <option value="A">Aktivní</option>
  <option value="P">Pozastaveno</option>
  <option value="N">Neaktivní</option>
</select></td></tr>
<tr><td>Popis:</td><td colspan=2><textarea name="popis" rows=5 cols=31 wrap="on"></textarea></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uložit Novou Èíselnou Øadu"></center><BR></td></tr><?}?>








<?if (@$menu=="Úprava Èíselné Øady"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr><td>Název Èíselné Øady:</td><td colspan=3><select name=nazev onchange=submit(this)>
<?
if (@$nazev<>""){?><option><?echo@$nazev;?></option><?}else {?><option></option><?}
include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from ciselnarada order by nazev ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,@$cykl,1)<>@$nazev){?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<?if (@$nazev<>"") {@$data1 = mysql_query("select * from ciselnarada where nazev='$nazev' order by nazev ASC") or Die(MySQL_Error());?>
<?if (mysql_num_rows($data1)) {$cislo=mysql_result($data1,0,3);
@$high=0;while (@$high<(mysql_result($data1,0,4)- StrLen(mysql_result($data1,0,3)))):
$cislo="0".$cislo;@$high++;endwhile;} else {$cislo="";}?>

<tr><td>Pøedpona Èíselné Øady / Aktuální Hodnota:</td><td colspan=3><input type="text" name=predpona value="<?echo mysql_result($data1,0,2);?>" size="10" style=background-color:#F9C8C8 style=text-align:right <?if (mysql_result($data1,0,3)<>mysql_result($data1,0,7)) {?>readonly=yes<?}?>> <input type="text" name=hodnota value="<?echo @$cislo;?>" size="26" style=background-color:#F9C8C8 <?if (mysql_result($data1,0,3)<>mysql_result($data1,0,7)) {?>readonly=yes<?}?>></td></tr>
<tr><td>Stav:</td><td colspan=3><select name="stav" style=width:100%>
<?if (mysql_result($data1,0,5)=="A") {?><option value="<?echo mysql_result($data1,0,5);?>">Aktivní</option><?}?>
<?if (mysql_result($data1,0,5)=="P") {?><option value="<?echo mysql_result($data1,0,5);?>">Pozastaveno</option><?}?>
<?if (mysql_result($data1,0,5)=="N") {?><option value="<?echo mysql_result($data1,0,5);?>">Neaktivní</option><?}?>
<?if (mysql_result($data1,0,5)<>"A") {?><option value="A">Aktivní</option><?}?>
<?if (mysql_result($data1,0,5)<>"P") {?><option value="P">Pozastaveno</option><?}?>
<?if (mysql_result($data1,0,5)<>"N") {?><option value="N">Neaktivní</option><?}?>
</select></td></tr>


<tr><td>Popis:</td><td colspan=2><textarea name="popis" rows=5 cols=31 wrap="on"><?echo mysql_result($data1,0,6);?></textarea></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uložit Opravenou Èíselnou Øadu"></center><BR></td></tr><?}}?>









<?if (@$menu=="Odstranìní Èíselné Øady"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr><td>Název Èíselné Øady:</td><td colspan=3><select name=nazev onchange=submit(this)>
<?echo@$control = mysql_result(mysql_query("select * from ciselnarada where nazev='$nazev' and origvalue=hodnota"),0,1);
if (@$nazev<>"" and @$nazev==@$control){?><option><?echo@$nazev;?></option><?} else {?><option></option><?$nazev="";}
include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from ciselnarada where origvalue=hodnota order by nazev ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,@$cykl,1)<>@$nazev){?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<?if (@$nazev<>"") {@$data1 = mysql_query("select * from ciselnarada where nazev='$nazev' order by nazev ASC") or Die(MySQL_Error());?>
<?if (mysql_num_rows($data1)) {$cislo=mysql_result($data1,0,3);
@$high=0;while (@$high<(mysql_result($data1,0,4)- StrLen(mysql_result($data1,0,3)))):
$cislo="0".$cislo;@$high++;endwhile;} else {$cislo="";}?>
<tr><td>Pøedpona Èíselné Øady / Aktuální Hodnota:</td><td colspan=3><input type="text" name=predpona value="<?echo mysql_result($data1,0,2);?>" size="10" style=background-color:#F9C8C8 style=text-align:right readonly=yes> <input type="text" name=hodnota value="<?echo @$cislo;?>" size="26" style=background-color:#F9C8C8 readonly=yes></td></tr>
<tr><td>Stav:</td><td colspan=3><?if (mysql_result($data1,0,5)=="A") {?>Aktivní<?}if (mysql_result($data1,0,5)=="P") {?>Pozastaveno<?}if (mysql_result($data1,0,5)=="N") {?>Neaktivní<?}?></td></tr>


<tr><td>Popis:</td><td colspan=2><textarea name="popis" rows=5 cols=31 wrap="on" readonly=yes><?echo mysql_result($data1,0,6);?></textarea></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Odstranit Vybranou Èíselnou Øadu"></center><BR></td></tr><?}}?>

<?}?>




<? if (StrPos (" " . $_SESSION["prava"], "A") or  StrPos (" " . $_SESSION["prava"], "a") ){?>

<?if (@$menu=="Tisk Èíselných Øad"){?>
<script type="text/javascript">
window.open('TiskCiselnychRad.php')
</script>
<?}?>


<?if (@$menu=="Pøehled Èíselných Øad"){?>
<tr bgcolor="#C0FFC0" align=center><td colspan=8><center><b> <?echo@$menu;?> </b></center></td></tr>
<tr bgcolor="#C0FFC0" align=center><td> Poøadí </td><td><center>Název</center></td><td><center>Akt. Hodnota Èíselné Øady</center></td>
<td><center>Stav</center></td>
<td><center>Popis</center></td>
<td><b> Použito </b></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from ciselnarada order by nazev,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):

?><tr><td><?echo@$cykl+1;?></td>
<td><?echo mysql_result($data1,@$cykl,1);?></td>
<td><?if (mysql_num_rows($data1)) {$cislo=mysql_result($data1,0,3);@$high=0;while (@$high<(mysql_result($data1,0,4)- StrLen(mysql_result($data1,0,3)))):  $cislo="0".$cislo;@$high++;endwhile;} else {$cislo="";}echo mysql_result($data1,@$cykl,2).@$cislo;?></td>
<td><?if (mysql_result($data1,$cykl,5)=="A") {?>Aktivní<?}if (mysql_result($data1,$cykl,5)=="P") {?>Pozastaveno<?}if (mysql_result($data1,$cykl,5)=="N") {?>Neaktivní<?}?></td>
<td><?echo mysql_result($data1,@$cykl,6);?></td>


<td align=center>

<?if (mysql_result($data1,@$cykl,3)<>mysql_result($data1,@$cykl,7)) {echo"ANO";} else {echo"NE";}?>
</td></tr><?

@$cykl++;endwhile;}?>

<?}?>






</table></center>
</form>
