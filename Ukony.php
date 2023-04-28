<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];

@$name=@$_POST["name"];@$nameold=@$_POST["nameold"];
@$stav=@$_POST["stav"];
@$popis=@$_POST["popis"];
@$zkratka=@$_POST["zkratka"];
@$firstload=@$_POST["firstload"]; if (@$name<>@$nameold and @$nameold<>"")  {@$firstload="";}
@$report=@$_POST["report"];if (@$report=="on") {$report="ANO";} else {@$report="NE";}
@$sestava=@$_POST["sestava"];
@$prach=@$_POST["prach"];
@$zaznam=1;




if (@$name<>"" and @$tlacitko=="Uložit Nový Druh Záznamu") {$cykl=1;$cykle=1;while (@$_POST["sysnum".$cykl]<>"" or @$_POST["sysnum".($cykl+1)]<>"" or @$_POST["sysnum".($cykl+2)]<>"" or @$_POST["sysnum".($cykl+3)]<>"" or @$_POST["sysnum".($cykl+4)]<>""):
if (@$_POST["sysnum".$cykl]<>"") {@$value[$cykle]=@$_POST["sysnum".$cykl];@$cykle++;}@$cykl++;endwhile;include ("./"."dbconnect.php");
mysql_query ("INSERT INTO ukony (nazev,stav,popis,zkratka,datumvkladu,vlozil,mzd1,mzd2,mzd3,mzd4,mzd5,mzd6,mzd7,mzd8,mzd9,souhrn,sestava,prace) VALUES('$name','Aktivní','$popis','$zkratka', '$dnes','$loginname','$value[1]','$value[2]','$value[3]','$value[4]','$value[5]','$value[6]','$value[7]','$value[8]','$value[9]','$report','$sestava','$prach')") or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Nového Druhu Záznamu Probìhlo Úspìšnì</b></center></td></tr></table><?
@$menu="";@$tlacitko="";$firstload="";}



if (@$name<>"" and @$tlacitko=="Uložit Opravený Druh Záznamu") {
$cykl=1;$cykle=1;while (@$_POST["sysnum".$cykl]<>"" or @$_POST["sysnum".($cykl+1)]<>"" or @$_POST["sysnum".($cykl+2)]<>"" or @$_POST["sysnum".($cykl+3)]<>"" or @$_POST["sysnum".($cykl+4)]<>""):
if (@$_POST["sysnum".$cykl]<>"") {@$value[$cykle]=@$_POST["sysnum".$cykl];@$cykle++;}@$cykl++;endwhile;include ("./"."dbconnect.php");
mysql_query ("update ukony  set stav='$stav',popis='$popis',zkratka='$zkratka', datumzmeny = '$dnes', zmenil ='$loginname',mzd1='$value[1]',mzd2='$value[2]',mzd3='$value[3]',mzd4='$value[4]',mzd5='$value[5]',mzd6='$value[6]',mzd7='$value[7]',mzd8='$value[8]',mzd9='$value[9]',souhrn='$report',sestava='$sestava',prace='$prach' where nazev = '$name' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Upraveného Druhu Záznamu Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";@$kod="";$firstload="";}


if (@$name<>"" and @$tlacitko=="Odstranit Vybraný Druh Záznamu") {
include ("./"."dbconnect.php");
mysql_query ("delete from ukony where nazev = '$name' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Odstranìní Vybraného Druhu Záznamu Probìhlo Úspìšnì</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$kod="";}


?>

<form action="hlavicka.php?akce=<?echo base64_encode('Ukony');?>" method=post><input name="nameold" type="hidden" value="<?echo@$name;?>">

<BR><BR><h2><p align="center">Správa Druhù Záznamù:
<? if (StrPos (" " . $_SESSION["prava"], "V") or StrPos (" " . $_SESSION["prava"], "v")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "V")){?>
   <?if (@$menu<>"Založení Nového Druhu Záznamu"){?><option>Založení Nového Druhu Záznamu</option><?}?>
   <?if (@$menu<>"Úprava Existujícího Druhu Záznamu"){?><option>Úprava Existujícího Druhu Záznamu</option><?}?>
   <?if (@$menu<>"Odstranìní Existujícího Druhu Záznamu"){?><option>Odstranìní Existujícího Druhu Záznamu</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "V") or StrPos (" " . $_SESSION["prava"], "v")){?>
   <?if (@$menu<>"Pøehled Existujících Druhù Záznamù"){?><option>Pøehled Existujících Druhù Záznamù</option><?}?>
   <?if (@$menu<>"Tisk Druhù Záznamù"){?><option>Tisk Druhù Záznamù</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "V") and (!StrPos (" " . $_SESSION["prava"], "v")) ){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "V")){?>


<?if (@$menu=="Založení Nového Druhu Záznamu"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b> <img src="picture/help.png" width="16" height="16" title="Slova støedisku,nadracováno,noci,pøesèas mají spec. význam a proto musí zùstat v tomto formátu" border="0"></center></td></tr>
<tr><td colspan=2>Název Záznamu:</td><td colspan=2><input type="text" name=name value="<?echo@$name;?>" style=width:250px></td></tr>
<tr><td colspan=2>Zkratka:</td><td colspan=2><input type="text" name=zkratka value="<?echo@$zkratka;?>" style=width:250px></td></tr>
<tr><td colspan=2>Popis:</td><td colspan=2><textarea name="popis" rows=5 style=width:100% wrap="on"><?echo@$popis;?></textarea></td></tr>
<tr><td colspan=2>Report Prac.H.:</td><td colspan=2><select size="1" name="prach"><option>NE</option><option>ANO</option></select></td></tr>
<tr><td colspan=2 align=left>Sk. Souètu: <input name="sestava" type="text" size=8 MAXLENGTH=10></td><td colspan=2 align=right>V Sourhn Report: <input name="report" type="checkbox"></td></tr>

<tr><td colspan=4 bgcolor="#C0FFC0"><center><br />Pøidìlené Mzdové Složky (Zákl.Sl. musí být na 1 místì)</center></td></tr>
<?include ("./"."dbconnect.php");
while ($_POST["stav".@$zaznam]<>"" or $_POST["stav".@$zaznam+1]<>"" or $_POST["stav".@$zaznam+2]<>"" or $_POST["stav".@$zaznam+3]<>"" or $_POST["stav".@$zaznam+4]<>""):
	if ($_POST["stav".@$zaznam]==" + "){?><tr><td colspan=2><input type=hidden name="stav<?echo@$zaznam;?>" value=" + " style=width:25px><input type=submit name="stav<?echo@$zaznam;?>" value=" - " style=width:25px></td><td><select name="sysnum<?echo@$zaznam;?>" style=width:100%><?
	if ($_POST["sysnum".@$zaznam]<>"") {$match=$_POST["sysnum".@$zaznam];?><option value="<?echo $match;?>"><?echo $_POST["sysnum".@$zaznam]." ".@mysql_result(mysql_query("select sysname from external_system where sysnumber='$match'"),0,0);?></option><?}
	$loaded=mysql_query("select * from external_system order by id");$load=0;while (@$load<mysql_num_rows($loaded)):?>
	<option value="<?echo @mysql_result($loaded,$load,1);?>"><?echo @mysql_result($loaded,$load,1)." ".@mysql_result($loaded,$load,2);?></option>
	<?@$load++;endwhile;?></select></td></tr><?} else {?><input type=hidden name="stav<?echo@$zaznam;?>" value=" - " style=width:25px><?}?>
<?@$zaznam++;endwhile;?>
<?if (@$zaznam<10) {?><tr><td colspan=4><input type="submit" name="stav<?echo@$zaznam++;?>" value=" + " style=width:25px></td></tr><?}?>
<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Uložit Nový Druh Záznamu"></center><BR></td></tr><?}?>





<?if (@$menu=="Úprava Existujícího Druhu Záznamu"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu?></b> <img src="picture/help.png" width="16" height="16" title="Slova støedisku,nadracováno,noci,pøesèas mají spec. význam a proto musí zùstat v tomto formátu" border="0"></center></td></tr>
<tr><td colspan=2>Název Záznamu:</td><td colspan=2><select name=name size="1" onchange=submit(this)>
<option><?if (@$name<>""){echo@$name;}?></option>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from ukony order by nazev,id ") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,@$cykl,1)<>@$name){?><option><?echo mysql_result($data1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select></td></tr>
<?if (@$name<>""){@$data1 = mysql_query("select * from ukony where nazev='$name' ") or Die(MySQL_Error());?>
<tr><td colspan=2>Zkratka:</td><td colspan=2><input type="text" name=zkratka value="<?echo @mysql_result($data1,0,10);?>" style=width:100%></td></tr>
<tr><td colspan=2>Popis:</td><td colspan=2><textarea name="popis" rows=5 style=width:100% wrap="on"><?echo @mysql_result($data1,0,5);?></textarea></td></tr>
<tr><td colspan=3>Stav Aktivní:</td><td>
<select size="1" name="stav" width=100%>
<option><? echo mysql_result($data1,0,4);?></option>
<? if (mysql_result($data1,0,4)=="Aktivní") {?><option>Neaktivní</option><?} else {?><option>Aktivní</option><?}?>
</select>
V Sourhn Report: <input name="report" type="checkbox" <?if (mysql_result($data1,0,20)=="ANO") {echo"checked";}?> > / Sk. Souètu: <input name="sestava" value="<?echo @mysql_result($data1,0,21);?>" type="text" size=8 MAXLENGTH=10> </td>
</tr>
<tr><td colspan=2>Report Prac.H.:</td><td colspan=2><select size="1" name="prach">
<?if (mysql_result($data1,0,22)=="ANO") {echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td></tr>

<tr><td colspan=4 bgcolor="#C0FFC0"><center><br />Pøidìlené Mzdové Složky (Zákl.Sl. musí být na 1 místì)</center></td></tr>
<?include ("./"."dbconnect.php");
if (@$firstload==""){?><input name="firstload" type="hidden" value="1"><?
@$mez=11;while (@mysql_result($data1,0,@$mez)<>""):
	if (@mysql_result($data1,0,@$mez)<>""){?><tr><td colspan=2><input type=hidden name="stav<?echo@$zaznam;?>" value=" + " style=width:25px><input type=submit name="stav<?echo@$zaznam;?>" value=" - " style=width:25px></td><td colspan=2><select name="sysnum<?echo@$zaznam;?>" style=width:100%><?
    $match=@mysql_result($data1,0,@$mez);?><option value="<?echo $match;?>"><?echo $match." ".@mysql_result(mysql_query("select sysname from external_system where sysnumber='$match'"),0,0);?></option><?
	$loaded=mysql_query("select * from external_system order by id");$load=0;while (@$load<mysql_num_rows($loaded)):
	if ($match<>@mysql_result($loaded,$load,1))	{?><option value="<?echo @mysql_result($loaded,$load,1);?>"><?echo @mysql_result($loaded,$load,1)." ".@mysql_result($loaded,$load,2);?></option><?}?>
	<?@$load++;endwhile;?></select></td></tr><?} else {?><input type=hidden name="stav<?echo@$zaznam;?>" value=" - " style=width:25px><?}
@$zaznam++;@$mez++;endwhile;}

if (@$firstload==1){?><input name="firstload" type="hidden" value="<?echo@$firstload;?>"><?
while ($_POST["stav".@$zaznam]<>"" or $_POST["stav".@$zaznam+1]<>"" or $_POST["stav".@$zaznam+2]<>"" or $_POST["stav".@$zaznam+3]<>"" or $_POST["stav".@$zaznam+4]<>""):
	if ($_POST["stav".@$zaznam]==" + "){?><tr><td colspan=2><input type=hidden name="stav<?echo@$zaznam;?>" value=" + " style=width:25px><input type=submit name="stav<?echo@$zaznam;?>" value=" - " style=width:25px></td><td><select name="sysnum<?echo@$zaznam;?>" style=width:100%><?
	if ($_POST["sysnum".@$zaznam]<>"") {$match=$_POST["sysnum".@$zaznam];?><option value="<?echo $match;?>"><?echo $_POST["sysnum".@$zaznam]." ".@mysql_result(mysql_query("select sysname from external_system where sysnumber='$match'"),0,0);?></option><?}
	$loaded=mysql_query("select * from external_system order by id");$load=0;while (@$load<mysql_num_rows($loaded)):?>
	<option value="<?echo @mysql_result($loaded,$load,1);?>"><?echo @mysql_result($loaded,$load,1)." ".@mysql_result($loaded,$load,2);?></option>
	<?@$load++;endwhile;?></select></td></tr><?} else {?><input type=hidden name="stav<?echo@$zaznam;?>" value=" - " style=width:25px><?}?>
<?@$zaznam++;endwhile;}?>
<?if (@$zaznam<10) {?><tr><td colspan=4><input type="submit" name="stav<?echo@$zaznam++;?>" value=" + " style=width:25px></td></tr><?}?>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Uložit Opravený Druh Záznamu"></center><BR></td></tr><?}}?>





<?if (@$menu=="Odstranìní Existujícího Druhu Záznamu"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu?></b> <img src="picture/help.png" width="16" height="16" title="Slova støedisku,nadracováno,noci,pøesèas mají spec. význam a proto musí zùstat v tomto formátu" border="0"></center></td></tr>
<tr><td colspan=2>Název Záznamu:</td><td colspan=2><select name=name size="1" style=width:100% onchange=submit(this)>
<option><?if (@$name<>""){echo@$name;}?></option>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select ukony.* from ukony where ukony.id not in (select zpracovana_dochazka.id_ukonu from zpracovana_dochazka group by id_ukonu) order by ukony.nazev,ukony.id") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,@$cykl,1)<>@$name){?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;?></select></td></tr>
<?if (@$name<>""){@$data1 = mysql_query("select * from ukony where nazev='$name' ") or Die(MySQL_Error());?>
<tr><td colspan=2>Zkratka:</td><td colspan=2><input type="text" name=zkratka value="<?echo @mysql_result($data1,0,10);?>" style=width:100% readonly=yes></td></tr>
<tr><td colspan=2>Popis:</td><td colspan=2>
<textarea name="popis" rows=5  style=width:100% wrap="on" readonly=yes><?echo @mysql_result($data1,0,5);?></textarea></td></tr>
<tr><td colspan=2>Stav Aktivní:</td><td colspan=2>
<select size="1" name="stav" width=100%>
<option><? echo mysql_result($data1,0,4);?></option>
<? if (mysql_result($data1,0,4)=="Aktivní") {?><option>Neaktivní</option><?} else {?><option>Aktivní</option><?}?>
</select>
V Sourhn Report: <input name="report" type="checkbox" <?if (mysql_result($data1,0,20)=="ANO") {echo"checked";}?> disabled > / Sk. Souètu: <input name="sestava" type="text" value="<?echo @mysql_result($data1,0,21);?>" size=8 MAXLENGTH=10 readonly=yes></td>
</tr>
<tr><td colspan=2>Report Prac.H.:</td><td colspan=2><select size="1" name="prach" disabled=disabled>
<?if (mysql_result($data1,0,22)=="ANO") {echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td></tr>

<tr><td colspan=4 bgcolor="#C0FFC0"><center><br />Pøidìlené Mzdové Složky (Zákl.Sl. musí být na 1 místì)</center></td></tr>
<?include ("./"."dbconnect.php");@$mez=11;while (@mysql_result($data1,0,@$mez)<>""):
if (@mysql_result($data1,0,@$mez)<>""){$match=@mysql_result($data1,0,@$mez);$match=$match.' '.@mysql_result(mysql_query("select sysname from external_system where sysnumber='$match'"),0,0);?><tr><td colspan=4><input type=hidden name="stav<?echo@$zaznam;?>" value=" + " style=width:25px><input type=text name="sysnum<?echo@$zaznam;?>" value="<?echo $match;?>" style=width:100% readonly=yes><?}?>
<?@$zaznam++;@$mez++;endwhile;?>


<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Odstranit Vybraný Druh Záznamu"></center><BR></td></tr><?}}?>

<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "V") or  StrPos (" " . $_SESSION["prava"], "v") ){?>

<?if (@$menu=="Tisk Druhù Záznamù"){?>
<script type="text/javascript">
window.open('TiskUkonu.php')
</script>
<?}?>


<?if (@$menu=="Pøehled Existujících Druhù Záznamù"){?>
<tr bgcolor="#C0FFC0" align=center><td colspan=9><center><b> <?echo@$menu;?> </b> <img src="picture/help.png" width="16" height="16" title="Slova støedisku,nadracováno,noci,pøesèas mají spec. význam a proto musí zùstat v tomto formátu" border="0"></center></td></tr>
<tr bgcolor="#C0FFC0" align=center><td> Poøadí </td><td><center>Název Záznamu</center></td><td><center>Zkratka</center></td><td><center>Popis</center></td><td>Stav</td><td><b>Pøiøaz.Mzd.Složky</b></td><td><b> Použito </b></td><td><b> V souhrn.Rep. </b></td><td><b> V Prac.Rep. </b></td></tr>

<style type="text/css">
tr.menuon  {background-color:#F1BEED;}
tr.menuoff {background-color:#EDB745;}
</style>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from ukony order by nazev,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):

@$matched="";@$matchede="";@$mez=11;while (@mysql_result($data1,@$cykl,@$mez)<>""):
if (@mysql_result($data1,@$cykl,@$mez)<>""){$match=@mysql_result($data1,@$cykl,@$mez);$match=$match.' '.@mysql_result(mysql_query("select sysname from external_system where sysnumber='$match'"),0,0);
$matchede=$matchede.$match."<br />";
$matched=$matched.$match."
";}@$mez++;endwhile;
?><tr title="<?echo@$matched;?>" style=cursor:pointer onmouseover="className='menuon';" onmouseout="className='menuoff';"><td><?echo@$cykl+1;?></td>
<td><?echo mysql_result($data1,@$cykl,1);?></td>
<td><?echo mysql_result($data1,@$cykl,10);?></td>
<td><?echo mysql_result($data1,@$cykl,5);?></td>
<td><?echo mysql_result($data1,@$cykl,4);?></td>
<td><?echo @$matchede;?></td>

<td align=center>
<?include ("./"."dbconnect.php");@$control= mysql_result($data1,@$cykl,0);
@$control1=mysql_query("select id from zpracovana_dochazka where id_ukonu='$control'");
@$control=mysql_num_rows($control1);
if (@$control<>"") {echo"ANO";} else {echo"NE";}?>
</td>
<td><?echo mysql_result($data1,@$cykl,20);?></td>
<td><?echo mysql_result($data1,@$cykl,22);?></td>
</tr><?

@$cykl++;endwhile;}?>

<?}?>






</table></center>
</form>
