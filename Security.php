<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];

@$hodnota=@$_POST["hodnota"];
@$operator=@$_POST["operator"];

@$stav=@$_POST["stav"];






if (@$hodnota<>"" and @$tlacitko=="Ulo�it Nov� Upozorn�n�") {
include ("./"."dbconnect.php");
if (@$operator<>"") {$hodnota=$hodnota.@$operator;@$set="SMS";} else {@$set="E-MAIL";}
mysql_query ("INSERT INTO security (adresa,nastaveni,datumvkladu,vlozil) VALUES('$hodnota','$set', '$dnes','$loginname')") or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Nov�ho Upozorn�n� typu: <?echo $set;?> Prob�hlo �sp�n�</b></center></td></tr></table><?
@$tlacitko="";@$set="";$hodnota="";}



if (@$hodnota<>"" and @$tlacitko=="Odstranit Vybran� Upozorn�n�") {
include ("./"."dbconnect.php");
mysql_query ("delete from security where adresa = '$hodnota' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Odstran�n� Vybran�ho Upozorn�n� Prob�hlo �sp�n�</b></center></td></tr></table><?
@$tlacitko="";@$hodnota="";}


?>

<form action="hlavicka.php?akce=<?echo base64_encode('Security');?>" method=post>

<h2><p align="center">Nastaven� Zabezpe�en�:
<? if (StrPos (" " . $_SESSION["prava"], "M") or StrPos (" " . $_SESSION["prava"], "m")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "M")){?>
   <?if (@$menu<>"Zalo�en� Upozorn�n� na Neplatn� �ip"){?><option>Zalo�en� Upozorn�n� na Neplatn� �ip</option><?}?>
   <?if (@$menu<>"Odstran�n� Existuj�c�ho Upozorn�n� na Neplatn� �ip"){?><option>Odstran�n� Existuj�c�ho Upozorn�n� na Neplatn� �ip</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "M") or StrPos (" " . $_SESSION["prava"], "m")){?>
   <?if (@$menu<>"P�ehled Existuj�c�ch Upozorn�n� na Neplatn� �ip"){?><option>P�ehled Existuj�c�ch Upozorn�n� na Neplatn� �ip</option><?}?>
<?}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "M") and (!StrPos (" " . $_SESSION["prava"], "m")) ){?>Nem�te P��stupov� Pr�va<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "M")){?>


<?if (@$menu=="Zalo�en� Upozorn�n� na Neplatn� �ip"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Upozorn�n� slou�� k zasl�n� mailu/SMS p�i pokusu zadat z�znam neaktivn�m �ipem" border="0"> </b></center></td></tr>
<tr><td>E-mail / Mob.��slo <img src="picture/help.png" width="16" height="16" title="V p��pad� zad�n� upozorn�n� na email nechte druh� pole pr�zdn�, v p��pad� zad�n� upozorn�n� SMS zpr�vou vyberte oper�tora Va�eho Mob. ��sla" border="0">:</td>
<td colspan=2><input type="text" name=hodnota value="" size="26"> <select name=operator size=1><option></option>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from sms_server order by operator,id ASC") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<@mysql_num_rows($data1)):
?><option value="<?echo(mysql_result($data1,@$cykl,2));?>"><?echo mysql_result($data1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Ulo�it Nov� Upozorn�n�"></center><BR></td></tr><?}?>





<?if (@$menu=="Odstran�n� Existuj�c�ho Upozorn�n� na Neplatn� �ip"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Upozorn�n� slou�� k zasl�n� mailu/SMS p�i pokusu zadat z�znam neaktivn�m �ipem" border="0"> </b></center></td></tr>
<tr><td>E-mail / Mob.��slo:</td>
<td colspan=2><select name=hodnota size=1><option></option>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from security order by nastaveni,adresa,id") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<@mysql_num_rows($data1)):
?><option value="<?echo(mysql_result($data1,@$cykl,1));?>"><?echo mysql_result($data1,@$cykl,1)." / ".mysql_result($data1,@$cykl,2);?></option><?
@$cykl++;endwhile;?></select></td></tr>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Odstranit Vybran� Upozorn�n�"></center><BR></td></tr><?}?>

<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "M") or  StrPos (" " . $_SESSION["prava"], "m") ){?>

<?if (@$menu=="Tisk St�edisek"){?>
<script type="text/javascript">
window.open('TiskStredisek.php')
</script>
<?}?>


<?if (@$menu=="P�ehled Existuj�c�ch Upozorn�n� na Neplatn� �ip"){?>
<tr bgcolor="#C0FFC0" align=center><td colspan=3><center><b> <?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Upozorn�n� slou�� k zasl�n� mailu/SMS p�i pokusu zadat z�znam neaktivn�m �ipem" border="0"></b></center></td></tr>
<tr bgcolor="#C0FFC0" align=center><td> Po�ad� </td><td><center> Typ </center></td><td><center> Adresa </center></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from security order by nastaveni,adresa,id");@$cykl=0;
while (@$cykl<mysql_num_rows($data1)):

?><tr><td><?echo@$cykl+1;?></td>
<td><center><?echo mysql_result($data1,@$cykl,2);?></center></td>
<td><center><?echo mysql_result($data1,@$cykl,1);?></center></td>
</tr><?

@$cykl++;endwhile;}?>

<?}?>






</table></center>
</form>
