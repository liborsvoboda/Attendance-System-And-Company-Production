<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];

@$hodnota=@$_POST["hodnota"];
@$operator=@$_POST["operator"];

@$stav=@$_POST["stav"];






if (@$hodnota<>"" and @$tlacitko=="Uložit Nové Upozornìní") {
include ("./"."dbconnect.php");
if (@$operator<>"") {$hodnota=$hodnota.@$operator;@$set="SMS";} else {@$set="E-MAIL";}
mysql_query ("INSERT INTO security (adresa,nastaveni,datumvkladu,vlozil) VALUES('$hodnota','$set', '$dnes','$loginname')") or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Nového Upozornìní typu: <?echo $set;?> Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";@$set="";$hodnota="";}



if (@$hodnota<>"" and @$tlacitko=="Odstranit Vybrané Upozornìní") {
include ("./"."dbconnect.php");
mysql_query ("delete from security where adresa = '$hodnota' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Odstranìní Vybraného Upozornìní Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";@$hodnota="";}


?>

<form action="hlavicka.php?akce=<?echo base64_encode('Security');?>" method=post>

<h2><p align="center">Nastavení Zabezpeèení:
<? if (StrPos (" " . $_SESSION["prava"], "M") or StrPos (" " . $_SESSION["prava"], "m")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "M")){?>
   <?if (@$menu<>"Založení Upozornìní na Neplatný Èip"){?><option>Založení Upozornìní na Neplatný Èip</option><?}?>
   <?if (@$menu<>"Odstranìní Existujícího Upozornìní na Neplatný Èip"){?><option>Odstranìní Existujícího Upozornìní na Neplatný Èip</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "M") or StrPos (" " . $_SESSION["prava"], "m")){?>
   <?if (@$menu<>"Pøehled Existujících Upozornìní na Neplatný Èip"){?><option>Pøehled Existujících Upozornìní na Neplatný Èip</option><?}?>
<?}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "M") and (!StrPos (" " . $_SESSION["prava"], "m")) ){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "M")){?>


<?if (@$menu=="Založení Upozornìní na Neplatný Èip"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Upozornìní slouží k zaslání mailu/SMS pøi pokusu zadat záznam neaktivním èipem" border="0"> </b></center></td></tr>
<tr><td>E-mail / Mob.Èíslo <img src="picture/help.png" width="16" height="16" title="V pøípadì zadání upozornìní na email nechte druhé pole prázdné, v pøípadì zadání upozornìní SMS zprávou vyberte operátora Vašeho Mob. èísla" border="0">:</td>
<td colspan=2><input type="text" name=hodnota value="" size="26"> <select name=operator size=1><option></option>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from sms_server order by operator,id ASC") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<@mysql_num_rows($data1)):
?><option value="<?echo(mysql_result($data1,@$cykl,2));?>"><?echo mysql_result($data1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uložit Nové Upozornìní"></center><BR></td></tr><?}?>





<?if (@$menu=="Odstranìní Existujícího Upozornìní na Neplatný Èip"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Upozornìní slouží k zaslání mailu/SMS pøi pokusu zadat záznam neaktivním èipem" border="0"> </b></center></td></tr>
<tr><td>E-mail / Mob.Èíslo:</td>
<td colspan=2><select name=hodnota size=1><option></option>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from security order by nastaveni,adresa,id") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<@mysql_num_rows($data1)):
?><option value="<?echo(mysql_result($data1,@$cykl,1));?>"><?echo mysql_result($data1,@$cykl,1)." / ".mysql_result($data1,@$cykl,2);?></option><?
@$cykl++;endwhile;?></select></td></tr>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Odstranit Vybrané Upozornìní"></center><BR></td></tr><?}?>

<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "M") or  StrPos (" " . $_SESSION["prava"], "m") ){?>

<?if (@$menu=="Tisk Støedisek"){?>
<script type="text/javascript">
window.open('TiskStredisek.php')
</script>
<?}?>


<?if (@$menu=="Pøehled Existujících Upozornìní na Neplatný Èip"){?>
<tr bgcolor="#C0FFC0" align=center><td colspan=3><center><b> <?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Upozornìní slouží k zaslání mailu/SMS pøi pokusu zadat záznam neaktivním èipem" border="0"></b></center></td></tr>
<tr bgcolor="#C0FFC0" align=center><td> Poøadí </td><td><center> Typ </center></td><td><center> Adresa </center></td></tr>

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
