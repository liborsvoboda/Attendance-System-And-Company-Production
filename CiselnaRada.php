<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];

@$nazev=@$_POST["nazev"];
@$predpona=@$_POST["predpona"];
@$hodnota=@$_POST["hodnota"];@$pocet=StrLen(@$hodnota);
@$stav=@$_POST["stav"];

@$popis=@$_POST["popis"];






if (@$nazev<>"" and $hodnota<>"" and @$tlacitko=="Ulo�it Novou ��selnou �adu") {
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
// kontrola naru�en� Obdob� jin� ��seln� �ady
@$control1 = mysql_query("select * from ciselnarada where stav='A' order by nazev,id ASC") or Die(MySQL_Error());
@$control=mysql_num_rows($control1);
// konec Kontroly
if (@$control=="") {
mysql_query ("INSERT INTO ciselnarada (nazev,predpona,origvalue,hodnota,stav,pocetmist,popis,datumvkladu,vlozil) VALUES('$nazev','$predpona','$hodnota','$hodnota','$stav','$pocet','$popis','$dnes','$loginname')") or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Nov� ��seln� �ady Prob�hlo �sp�n�</b></center></td></tr></table><?}

else {?><table width=100%><tr><td width=100% bgcolor="#F5938D"><center><b>��seln� �ada nebyla Ulo�ena z d�vodu existence jin� Aktivn� ��seln� �ady</b></center></td></tr></table><?}
@$menu="";@$tlacitko="";@$nazev="";}



if (@$nazev<>"" and @$tlacitko=="Ulo�it Opravenou ��selnou �adu") {
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
// kontrola naru�en� Obdob� jin� ��seln� �ady
@$control1 = mysql_query("select * from ciselnarada where stav='A' order by nazev,id ASC") or Die(MySQL_Error());
@$control=mysql_num_rows($control1);
// konec Kontroly
if (@$control=="" or (mysql_result($control1,0,1)<>$nazev and $stav<>"A") or (mysql_result($control1,0,1)==$nazev)) {
mysql_query ("update ciselnarada  set predpona = '$predpona',hodnota = '$hodnota',stav = '$stav',pocetmist = '$pocet',popis = '$popis',datumzmeny = '$dnes', zmenil ='$loginname' where nazev = '$nazev' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Upraven� ��seln� �ady Prob�hlo �sp�n�</b></center></td></tr></table><?}
else {?><table width=100%><tr><td width=100% bgcolor="#F5938D"><center><b>�prava ��seln� �ady nebyla Ulo�ena z d�vodu existence jin� Aktivn� ��seln� �ady</b></center></td></tr></table><?}
@$menu="";@$tlacitko="";@$nazev="";}


if (@$nazev<>"" and @$tlacitko=="Odstranit Vybranou ��selnou �adu") {
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
mysql_query ("delete from ciselnarada where nazev = '$nazev' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Odstran�n� Vybran� ��seln� �ady Prob�hlo �sp�n�</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$nazev="";}


?>

<form action="hlavicka.php?akce=<?echo base64_encode('CiselnaRada');?>" method=post>

<h2><p align="center">Spr�va ��seln� �ady Zam�stnanc�:
<? if (StrPos (" " . $_SESSION["prava"], "A") or StrPos (" " . $_SESSION["prava"], "a")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "A")){?>
   <?if (@$menu<>"Zalo�en� Nov� ��seln� �ady"){?><option>Zalo�en� Nov� ��seln� �ady</option><?}?>
   <?if (@$menu<>"�prava ��seln� �ady"){?><option>�prava ��seln� �ady</option><?}?>
   <?if (@$menu<>"Odstran�n� ��seln� �ady"){?><option>Odstran�n� ��seln� �ady</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "A") or StrPos (" " . $_SESSION["prava"], "a")){?>
   <?if (@$menu<>"P�ehled ��seln�ch �ad"){?><option>P�ehled ��seln�ch �ad</option><?}?>
   <?if (@$menu<>"Tisk ��seln�ch �ad"){?><option>Tisk ��seln�ch �ad</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "A") and (!StrPos (" " . $_SESSION["prava"], "a")) ){?>Nem�te P��stupov� Pr�va<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "A")){?>

<?if (@$menu=="Zalo�en� Nov� ��seln� �ady"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr><td>N�zev ��seln� �ady:</td><td colspan=3><input type="text" name=nazev value="" style="width:100%" style=background-color:#F9C8C8></td></tr>
<tr><td>P�edpona ��seln� �ady / Po��te�n� Hodnota:</td><td colspan=3><input type="text" name=predpona value="CR" size="10" style=background-color:#F9C8C8 style=text-align:right> <input type="text" name=hodnota value="00000001" size="26" style=background-color:#F9C8C8></td></tr>
<tr><td>Stav:</td><td colspan=3><select name="stav" style=width:100%>
  <option value="A">Aktivn�</option>
  <option value="P">Pozastaveno</option>
  <option value="N">Neaktivn�</option>
</select></td></tr>
<tr><td>Popis:</td><td colspan=2><textarea name="popis" rows=5 cols=31 wrap="on"></textarea></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Ulo�it Novou ��selnou �adu"></center><BR></td></tr><?}?>








<?if (@$menu=="�prava ��seln� �ady"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr><td>N�zev ��seln� �ady:</td><td colspan=3><select name=nazev onchange=submit(this)>
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

<tr><td>P�edpona ��seln� �ady / Aktu�ln� Hodnota:</td><td colspan=3><input type="text" name=predpona value="<?echo mysql_result($data1,0,2);?>" size="10" style=background-color:#F9C8C8 style=text-align:right <?if (mysql_result($data1,0,3)<>mysql_result($data1,0,7)) {?>readonly=yes<?}?>> <input type="text" name=hodnota value="<?echo @$cislo;?>" size="26" style=background-color:#F9C8C8 <?if (mysql_result($data1,0,3)<>mysql_result($data1,0,7)) {?>readonly=yes<?}?>></td></tr>
<tr><td>Stav:</td><td colspan=3><select name="stav" style=width:100%>
<?if (mysql_result($data1,0,5)=="A") {?><option value="<?echo mysql_result($data1,0,5);?>">Aktivn�</option><?}?>
<?if (mysql_result($data1,0,5)=="P") {?><option value="<?echo mysql_result($data1,0,5);?>">Pozastaveno</option><?}?>
<?if (mysql_result($data1,0,5)=="N") {?><option value="<?echo mysql_result($data1,0,5);?>">Neaktivn�</option><?}?>
<?if (mysql_result($data1,0,5)<>"A") {?><option value="A">Aktivn�</option><?}?>
<?if (mysql_result($data1,0,5)<>"P") {?><option value="P">Pozastaveno</option><?}?>
<?if (mysql_result($data1,0,5)<>"N") {?><option value="N">Neaktivn�</option><?}?>
</select></td></tr>


<tr><td>Popis:</td><td colspan=2><textarea name="popis" rows=5 cols=31 wrap="on"><?echo mysql_result($data1,0,6);?></textarea></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Ulo�it Opravenou ��selnou �adu"></center><BR></td></tr><?}}?>









<?if (@$menu=="Odstran�n� ��seln� �ady"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr><td>N�zev ��seln� �ady:</td><td colspan=3><select name=nazev onchange=submit(this)>
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
<tr><td>P�edpona ��seln� �ady / Aktu�ln� Hodnota:</td><td colspan=3><input type="text" name=predpona value="<?echo mysql_result($data1,0,2);?>" size="10" style=background-color:#F9C8C8 style=text-align:right readonly=yes> <input type="text" name=hodnota value="<?echo @$cislo;?>" size="26" style=background-color:#F9C8C8 readonly=yes></td></tr>
<tr><td>Stav:</td><td colspan=3><?if (mysql_result($data1,0,5)=="A") {?>Aktivn�<?}if (mysql_result($data1,0,5)=="P") {?>Pozastaveno<?}if (mysql_result($data1,0,5)=="N") {?>Neaktivn�<?}?></td></tr>


<tr><td>Popis:</td><td colspan=2><textarea name="popis" rows=5 cols=31 wrap="on" readonly=yes><?echo mysql_result($data1,0,6);?></textarea></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Odstranit Vybranou ��selnou �adu"></center><BR></td></tr><?}}?>

<?}?>




<? if (StrPos (" " . $_SESSION["prava"], "A") or  StrPos (" " . $_SESSION["prava"], "a") ){?>

<?if (@$menu=="Tisk ��seln�ch �ad"){?>
<script type="text/javascript">
window.open('TiskCiselnychRad.php')
</script>
<?}?>


<?if (@$menu=="P�ehled ��seln�ch �ad"){?>
<tr bgcolor="#C0FFC0" align=center><td colspan=8><center><b> <?echo@$menu;?> </b></center></td></tr>
<tr bgcolor="#C0FFC0" align=center><td> Po�ad� </td><td><center>N�zev</center></td><td><center>Akt. Hodnota ��seln� �ady</center></td>
<td><center>Stav</center></td>
<td><center>Popis</center></td>
<td><b> Pou�ito </b></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from ciselnarada order by nazev,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):

?><tr><td><?echo@$cykl+1;?></td>
<td><?echo mysql_result($data1,@$cykl,1);?></td>
<td><?if (mysql_num_rows($data1)) {$cislo=mysql_result($data1,0,3);@$high=0;while (@$high<(mysql_result($data1,0,4)- StrLen(mysql_result($data1,0,3)))):  $cislo="0".$cislo;@$high++;endwhile;} else {$cislo="";}echo mysql_result($data1,@$cykl,2).@$cislo;?></td>
<td><?if (mysql_result($data1,$cykl,5)=="A") {?>Aktivn�<?}if (mysql_result($data1,$cykl,5)=="P") {?>Pozastaveno<?}if (mysql_result($data1,$cykl,5)=="N") {?>Neaktivn�<?}?></td>
<td><?echo mysql_result($data1,@$cykl,6);?></td>


<td align=center>

<?if (mysql_result($data1,@$cykl,3)<>mysql_result($data1,@$cykl,7)) {echo"ANO";} else {echo"NE";}?>
</td></tr><?

@$cykl++;endwhile;}?>

<?}?>






</table></center>
</form>
