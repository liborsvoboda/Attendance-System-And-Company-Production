<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];

@$kod=@$_POST["kod"];
@$nazev=@$_POST["nazev"];
@$nazevnew=@$_POST["nazevnew"];






if (@$nazev<>"" and @$tlacitko=="Ulo�it Novou Kategorii") {
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
mysql_query ("INSERT INTO kategorie (kod,nazev,datumvkladu,vlozil) VALUES('$kod','$nazev', '$dnes','$loginname')") or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Nov� Kategorie Prob�hlo �sp�n�</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$kod="";}



if (@$nazevnew<>"" and @$tlacitko=="Ulo�it Opravenou Kategorii") {
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
mysql_query ("update kategorie  set nazev = '$nazevnew', datumzmeny = '$dnes', zmenil ='$loginname' where kod = '$nazev' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Upraven� Kategorie Prob�hlo �sp�n�</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$kod="";}


if (@$nazev<>"" and @$tlacitko=="Odstranit Vybranou Kategorii") {
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
mysql_query ("delete from kategorie where kod = '$nazev' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Odstran�n� Vybran� Kategorie Prob�hlo �sp�n�</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$kod="";}


?>

<form action="hlavicka.php?akce=<?echo base64_encode('Kategorie');?>" method=post>

<h2><p align="center">Spr�va Kategori�:
<? if (StrPos (" " . $_SESSION["prava"], "K") or StrPos (" " . $_SESSION["prava"], "k")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "K")){?>
   <?if (@$menu<>"Zalo�en� Nov� Kategorie"){?><option>Zalo�en� Nov� Kategorie</option><?}?>
   <?if (@$menu<>"�prava Existuj�c� Kategorie"){?><option>�prava Existuj�c� Kategorie</option><?}?>
   <?if (@$menu<>"Odstran�n� Existuj�c� Kategorie"){?><option>Odstran�n� Existuj�c� Kategorie</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "K") or StrPos (" " . $_SESSION["prava"], "k")){?>
   <?if (@$menu<>"P�ehled Existuj�c�ch Kategori�"){?><option>P�ehled Existuj�c�ch Kategori�</option><?}?>
   <?if (@$menu<>"Tisk Kategori�"){?><option>Tisk Kategori�</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "K") and (!StrPos (" " . $_SESSION["prava"], "k")) ){?>Nem�te P��stupov� Pr�va<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "K")){?>


<?if (@$menu=="Zalo�en� Nov� Kategorie"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr><td>K�d Kategorie:</td><td colspan=2><input type="text" name=kod value="" size="26"></td></tr>
<tr><td>Popis:</td><td colspan=2><textarea name="nazev" rows=5 cols=20 wrap="on"></textarea></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Ulo�it Novou Kategorii"></center><BR></td></tr><?}?>





<?if (@$menu=="�prava Existuj�c� Kategorie"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu?></b></center></td></tr>
<tr><td colspan=2>K�d Kategorie:</td><td colspan=2><select name=nazev size="1" style=width:100% onchange=submit(this)>
<option><?if (@$nazev<>""){echo@$nazev;}?></option>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select kategorie.* from kategorie where kategorie.kod not in (select zamestnanci.kategorie from zamestnanci) order by kategorie.kod,kategorie.nazev,kategorie.id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,@$cykl,1)<>@$nazev){?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;?></select></td></tr>
<?if (@$nazev<>""){@$data1 = mysql_query("select * from kategorie where kod='$nazev' ") or Die(MySQL_Error());?>
<tr><td colspan=2>Popis:</td><td colspan=2><textarea name="nazevnew" rows=5 cols=20 wrap="on"><?echo (mysql_result($data1,0,2));?></textarea></td></tr>
<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Ulo�it Opravenou Kategorii"></center><BR></td></tr><?}}?>





<?if (@$menu=="Odstran�n� Existuj�c� Kategorie"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu?></b></center></td></tr>
<tr><td colspan=2>K�d kategorie:</td><td colspan=2><select name=nazev size="1" style=width:100% onchange=submit(this)>
<option><?if (@$nazev<>""){echo@$nazev;}?></option>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select kategorie.* from kategorie where kategorie.kod not in (select zamestnanci.kategorie from zamestnanci) order by kategorie.kod,kategorie.nazev,kategorie.id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,@$cykl,1)<>@$nazev){?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;?></select></td></tr>
<?if (@$nazev<>""){@$data1 = mysql_query("select * from kategorie where kod='$nazev' ") or Die(MySQL_Error());?>
<tr><td colspan=2>Popis:</td><td colspan=2>
<textarea name="nazevnew" rows=5 cols=25 wrap="on" readonly=yes><?echo (mysql_result($data1,0,2));?></textarea></td></tr>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Odstranit Vybranou Kategorii"></center><BR></td></tr><?}}?>

<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "K") or  StrPos (" " . $_SESSION["prava"], "k") ){?>

<?if (@$menu=="Tisk Kategori�"){?>
<script type="text/javascript">
window.open('TiskKategorii.php')
</script>
<?}?>


<?if (@$menu=="P�ehled Existuj�c�ch Kategori�"){?>
<tr bgcolor="#C0FFC0" align=center><td colspan=4><center><b> <?echo@$menu;?> </b></center></td></tr>
<tr bgcolor="#C0FFC0" align=center><td> Po�ad� </td><td><center>K�d Kategorie</center></td><td><center>Popis</center></td><td><b> Pou�ito </b></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from kategorie order by kod,nazev,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):

?><tr><td><?echo@$cykl+1;?></td><td><?echo mysql_result($data1,@$cykl,1);?></td><td><?echo mysql_result($data1,@$cykl,2);?></td><td align=center>
<?include ("./"."dbconnect.php");@$control= mysql_result($data1,@$cykl,1);
@$control1=mysql_query("select id from zamestnanci where kategorie='$control'");
@$control=mysql_num_rows($control1);
if (@$control<>"") {echo"ANO";} else {echo"NE";}?>
</td></tr><?

@$cykl++;endwhile;}?>

<?}?>






</table></center>
</form>
