<?
// práva   W/R
//Zz - Zamìstnanci
//Ss  - Správa Uživatelu
//Ff  - Firemní údaje
//Kk - Kategorie
//Uu  - Støediska
//Aa  - Auto èíselná Øada
//Ll  - Nastavení Kláves
//Oo  - karty zamìstnancù
//Mm  - zabezpeèení
//Vv  - nastavení Druhu Záznamù
//Ii   - Import z ext systemu
//Ee   - Export z ext systemu
//Hh   - Stravování
//r   - Reporty
//Tt   - Turnikety
//Cc   - Obedy
//Xx     - Kniha Urazu
//Bb     - Úkolové Výkazy


//  uživatelé
@$uzivatel=@$_POST["uzivatel"];
@$tlacitko=@$_POST["tlacitko"];
@$ajmeno=@$_POST["ajmeno"];
@$jmeno=@$_POST["jmeno"];
@$cjmeno=@$_POST["cjmeno"];
@$cprijmeni=@$_POST["cprijmeni"];
@$ctitul=@$_POST["ctitul"];
@$heslo=@$_POST["heslo"];

@$pravo="";
if (@$_POST["zzaznam"]=="on") {@$pravo=@$pravo."Z";}
if (@$_POST["czaznam"]=="on") {@$pravo=@$pravo."z";}
if (@$_POST["zfirma"]=="on") {@$pravo=@$pravo."F";}
if (@$_POST["cfirma"]=="on") {@$pravo=@$pravo."f";}
if (@$_POST["zuzivatel"]=="on") {@$pravo=@$pravo."S";}
if (@$_POST["cuzivatel"]=="on") {@$pravo=@$pravo."s";}
if (@$_POST["zkod"]=="on") {@$pravo=@$pravo."K";}
if (@$_POST["ckod"]=="on") {@$pravo=@$pravo."k";}
if (@$_POST["zskod"]=="on") {@$pravo=@$pravo."U";}
if (@$_POST["cskod"]=="on") {@$pravo=@$pravo."u";}
if (@$_POST["zpacient"]=="on") {@$pravo=@$pravo."A";}
if (@$_POST["cpacient"]=="on") {@$pravo=@$pravo."a";}
if (@$_POST["zpojistovna"]=="on") {@$pravo=@$pravo."L";}
if (@$_POST["cpojistovna"]=="on") {@$pravo=@$pravo."l";}
if (@$_POST["zoperace"]=="on") {@$pravo=@$pravo."O";}
if (@$_POST["coperace"]=="on") {@$pravo=@$pravo."o";}
if (@$_POST["zmaterial"]=="on") {@$pravo=@$pravo."M";}
if (@$_POST["cmaterial"]=="on") {@$pravo=@$pravo."m";}
if (@$_POST["zprace"]=="on") {@$pravo=@$pravo."V";}
if (@$_POST["cprace"]=="on") {@$pravo=@$pravo."v";}
if (@$_POST["wimport"]=="on") {@$pravo=@$pravo."I";}
if (@$_POST["rimport"]=="on") {@$pravo=@$pravo."i";}
if (@$_POST["wexport"]=="on") {@$pravo=@$pravo."E";}
if (@$_POST["rexport"]=="on") {@$pravo=@$pravo."e";}
if (@$_POST["wstravovani"]=="on") {@$pravo=@$pravo."H";}
if (@$_POST["rstravovani"]=="on") {@$pravo=@$pravo."h";}
if (@$_POST["reporty"]=="on") {@$pravo=@$pravo."r";}
if (@$_POST["wturnikety"]=="on") {@$pravo=@$pravo."T";}
if (@$_POST["rturnikety"]=="on") {@$pravo=@$pravo."t";}
if (@$_POST["wfobedy"]=="on") {@$pravo=@$pravo."C";}
if (@$_POST["rfobedy"]=="on") {@$pravo=@$pravo."c";}
if (@$_POST["wurazy"]=="on") {@$pravo=@$pravo."X";}
if (@$_POST["rurazy"]=="on") {@$pravo=@$pravo."x";}
if (@$_POST["wukol"]=="on") {@$pravo=@$pravo."B";}
if (@$_POST["rukol"]=="on") {@$pravo=@$pravo."b";}

// spravovana strediska
include ("./"."dbconnect.php");
@$data1=mysql_query("select * from stredisko where stav='ANO' order by kod");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$_POST["stredisko".mysql_result($data1,@$cykl,1)]=="on") {@$sprstr.=mysql_result($data1,@$cykl,1).",";}
@$cykl++;endwhile;


if (@$ajmeno<>"" and @$heslo<>"" and @$tlacitko=="Uložit Aktivovaného Vedoucího") {   // uložení Nového Uživatele
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
mysql_query ("INSERT INTO login (titul,cjmeno,cprijmeni,jmeno,heslo,prava,sprava_str,datumvkladu,vlozil) VALUES('$ctitul','$cjmeno','$cprijmeni','$ajmeno', MD5('$heslo'), '$pravo','$sprstr', '$dnes','$loginname')") or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Aktivovaného Vedoucího Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";@$heslo="";$jmeno="";$ajmeno="";}


if (@$jmeno<>"" and @$heslo<>"" and @$tlacitko=="Uložit Nového Uživatele") {   // uložení Nového Uživatele
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
mysql_query ("INSERT INTO login (titul,cjmeno,cprijmeni,jmeno,heslo,prava,sprava_str,datumvkladu,vlozil) VALUES('$ctitul','$cjmeno','$cprijmeni','$jmeno', MD5('$heslo'), '$pravo', '$sprstr', '$dnes','$loginname')") or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Nového Uživatele Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";@$heslo="";}



if (@$jmeno<>"" and @$heslo<>"" and @$tlacitko=="Uložit Opraveného Uživatele") {   // uložení opraveného Uživatele
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
if (@$heslo=="Beze Zmìn"){mysql_query ("update login  set titul = '$ctitul', cjmeno='$cjmeno', cprijmeni='$cprijmeni', prava = '$pravo', sprava_str='$sprstr', datumvkladu = '$dnes', vlozil ='$loginname' where jmeno = '$jmeno' ")or Die(MySQL_Error());}
else
{mysql_query ("update login  set heslo = MD5('$heslo'), prava = '$pravo',sprava_str='$sprstr', datumvkladu = '$dnes', vlozil ='$loginname' where jmeno = '$jmeno' ")or Die(MySQL_Error());}
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Upraveného Uživatele Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";@$heslo="";}



if (@$jmeno<>"" and @$tlacitko=="Odstranit Uživatele") {   // uložení opraveného Uživatele
@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
mysql_query ("delete from login where jmeno = '$jmeno' ")or Die(MySQL_Error());?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uživatel Byl Úspìšnì Odstranìn</b></center></td></tr></table><?
@$tlacitko="";@$jmeno="";}




?>


<form action="hlavicka.php?akce=<?echo base64_encode('SpravaUzivatelu');?>" method=post>



<h2><p align="center">Správa Uživatelù:

<? if (StrPos (" " . $_SESSION["prava"], "S") or StrPos (" " . $_SESSION["prava"], "s")){?>
   <select name=uzivatel size="1" onchange=submit(this)>
   <option><?if (@$uzivatel<>""){echo@$uzivatel;}?></option><?}?>


<? if (StrPos (" " . $_SESSION["prava"], "S")){?>
   <?if (@$uzivatel<>"Aktivace Pøístupu Vedoucího Pracovníka"){?><option>Aktivace Pøístupu Vedoucího Pracovníka</option><?}?>
   <?if (@$uzivatel<>"Založení Nového Uživatele"){?><option>Založení Nového Uživatele</option><?}?>
   <?if (@$uzivatel<>"Úprava Existujícího Uživatele"){?><option>Úprava Existujícího Uživatele</option><?}?>
   <?if (@$uzivatel<>"Odstranìní Existujícího Uživatele"){?><option>Odstranìní Existujícího Uživatele</option><?}}?>
<? if (StrPos (" " . $_SESSION["prava"], "s") or StrPos (" " . $_SESSION["prava"], "S")){?>
   <?if (@$uzivatel<>"Pøehled Aktivních Uživatelù"){?><option>Pøehled Aktivních Uživatelù</option><?}}?>

   </select>


</p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "s") and (!StrPos (" " . $_SESSION["prava"], "S")) ){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "S")){?>



<?if (@$uzivatel=="Aktivace Pøístupu Vedoucího Pracovníka"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$uzivatel;?></b></center></td></tr>

<tr><td>Pøihlašovací Jméno:</td><td colspan=2><select name=ajmeno size="1" style=width:100%+2 onchange=submit(this)>
<?if (@$ajmeno<>""){?><option value="<?echo @$ajmeno;?>"><?include ("./"."dbconnect.php");@$datas1 = mysql_query("select * from zamestnanci where osobni_cislo='$ajmeno' ") or Die(MySQL_Error()); echo @$ajmeno." / ".(mysql_result($datas1,0,4))." ".(mysql_result($datas1,0,3));?></option><?} else {?><option></option><?}?>
<?include ("./"."dbconnect.php");
@$jmeno1=mysql_query("select zamestnanci.* from zamestnanci where zamestnanci.vedouci='A' and datumout='0000-00-00' and zamestnanci.osobni_cislo not in (select login.jmeno from login) order by zamestnanci.prijmeni,zamestnanci.jmeno,zamestnanci.id");
@$pocet=mysql_num_rows($jmeno1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($jmeno1,@$cykl,1)<>@$ajmeno){?><option value="<?echo(mysql_result($jmeno1,@$cykl,1));?>"><?echo(mysql_result($jmeno1,@$cykl,1))." / ".(mysql_result($jmeno1,@$cykl,4))." ".(mysql_result($jmeno1,@$cykl,3));?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<tr><td>Pøihlašovací Heslo:</td><td colspan=2><input type="text" name=heslo value="" size="23"></td></tr>

<tr><td>Titul:</td><td colspan=2><input type="text" name=ctitul value="<?if (@$ajmeno<>"") {echo mysql_result($datas1,0,2);}?>" size="23"></td></tr>
<tr><td>Jméno:</td><td colspan=2><input type="text" name=cjmeno value="<?if (@$ajmeno<>"") {echo mysql_result($datas1,0,3);}?>" size="23"></td></tr>
<tr><td>Pøíjmení:</td><td colspan=2><input type="text" name=cprijmeni value="<?if (@$ajmeno<>"") {echo mysql_result($datas1,0,4);}?>" size="23"></td></tr>

<tr><td colspan=3><BR></td></tr>

<tr bgcolor="#C0FFFF"><td><center>Nastavení Práv</center></td><td><center>Zápis</center></td><td><center>Ètení</center></td></tr>

<tr><td>Èíselník Auto.Èíselná Øada</td><td><center><input name=zpacient type="checkbox" ></center></td>
<td><center><input name=cpacient type="checkbox" ></center></td></tr>

<tr><td>Èíselník Kategorií</td><td><center><input name=zkod type="checkbox" ></center></td>
<td><center><input name=ckod type="checkbox" ></center></td></tr>

<tr><td>Èíselník Støedisek</td><td><center><input name=zskod type="checkbox"  ></center></td>
<td><center><input name=cskod type="checkbox" ></center></td></tr>

<tr><td>Èíselník Zamìstnancù</td><td><center><input name=zzaznam type="checkbox" ></center></td>
<td><center><input name=czaznam type="checkbox" ></center></td></tr>

<tr><td>Docházka Zamìstnancù</td><td><center><input name=zoperace type="checkbox" ></center></td>
<td><center><input name=coperace type="checkbox" ></center></td></tr>

<tr><td>Import z Ext.Systému</td><td><center><input name=wimport type="checkbox" ></center></td>
<td><center><input name=rimport type="checkbox" ></center></td></tr>

<tr><td>Export pro Ext.Systém + Opravy</td><td><center><input name=wexport type="checkbox" ></center></td>
<td><center><input name=rexport type="checkbox" ></center></td></tr>

<tr><td>Reporty</td><td></td><td><center><input name=reporty type="checkbox" ></center></td></tr>

<tr><td>Stravování</td><td><center><input name=wstravovani type="checkbox" ></center></td>
<td><center><input name=rstravovani type="checkbox" ></center></td></tr>

<tr><td>Exporty/Reporty Obìdù</td><td><center><input name=wfobedy type="checkbox" ></center></td>
<td><center><input name=rfobedy type="checkbox" ></center></td></tr>

<tr><td>Kniha Úrazù</td><td><center><input name=wurazy type="checkbox" ></center></td>
<td><center><input name=rurazy type="checkbox" ></center></td></tr>

<tr><td>Systémová Nastavení</td><td><center><input name=zpojistovna type="checkbox" ></center></td>
<td><center><input name=cpojistovna type="checkbox" ></center></td></tr>

<tr><td>Nastavení Zabezpeèení</td><td><center><input name=zmaterial type="checkbox" ></center></td>
<td><center><input name=cmaterial type="checkbox" ></center></td></tr>

<tr><td>Nastavení Druhu Záznamù</td><td><center><input name=zprace type="checkbox" ></center></td>
<td><center><input name=cprace type="checkbox" ></center></td></tr>

<tr><td>Nastavení Turniketù</td><td><center><input name=wturnikety type="checkbox" ></center></td>
<td><center><input name=rturnikety type="checkbox" ></center></td></tr>

<tr><td>Správa Uživatelù</td><td><center><input name=zuzivatel type="checkbox" ></center></td>
<td><center><input name=cuzivatel type="checkbox" ></center></td></tr>

<tr><td>Úkolové výkazy</td><td><center><input name=wukol type="checkbox" ></center></td>
<td><center><input name=rukol type="checkbox" ></center></td></tr>

<tr><td>Firemní Údaje</td><td><center><input name=zfirma type="checkbox" ></center></td>
<td><center><input name=cfirma type="checkbox" ></center></td></tr>

<tr bgcolor="#C0FFFF"><td colspan=3><center>Spravuje Støediska</center></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from stredisko where stav='ANO' order by kod");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
?><tr><td colspan=2><?echo mysql_result($data1,@$cykl,1)." ".mysql_result($data1,@$cykl,2);?></td><td><center><input name="stredisko<?echo mysql_result($data1,@$cykl,1);?>" type="checkbox" ></center></td></tr><?

@$cykl++;endwhile;?>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uložit Aktivovaného Vedoucího"></center><BR></td></tr><?}?>









<?if (@$uzivatel=="Založení Nového Uživatele" or @$uzivatel==""){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?if (@$uzivatel<>""){echo@$uzivatel;} else {echo"Založení Nového Uživatele";}?></b></center></td></tr>
<tr><td>Pøihlašovací Jméno:</td><td colspan=2><input type="text" name=jmeno value="" size="20"></td></tr>
<tr><td>Pøihlašovací Heslo:</td><td colspan=2><input type="text" name=heslo value="" size="20"></td></tr>
<tr><td>Titul:</td><td colspan=2><input type="text" name=ctitul value="" size="20"></td></tr>
<tr><td>Jméno:</td><td colspan=2><input type="text" name=cjmeno value="" size="20"></td></tr>
<tr><td>Pøíjmení:</td><td colspan=2><input type="text" name=cprijmeni value="" size="20"></td></tr>

<tr><td colspan=3><BR></td></tr>

<tr bgcolor="#C0FFFF"><td><center>Nastavení Práv</center></td><td><center>Zápis</center></td><td><center>Ètení</center></td></tr>

<tr><td>Èíselník Auto.Èíselná Øada</td><td><center><input name=zpacient type="checkbox"></center></td><td><center><input name=cpacient type="checkbox"></center></td></tr>
<tr><td>Èíselník Kategorií</td><td><center><input name=zkod type="checkbox"></center></td><td><center><input name=ckod type="checkbox"></center></td></tr>
<tr><td>Èíselník Støedisek</td><td><center><input name=zskod type="checkbox"></center></td><td><center><input name=cskod type="checkbox"></center></td></tr>
<tr><td>Èíselník Zamìstnancù</td><td><center><input name=zzaznam type="checkbox"></center></td><td><center><input name=czaznam type="checkbox"></center></td></tr>
<tr><td>Docházka Zamìstnancù</td><td><center><input name=zoperace type="checkbox"></center></td><td><center><input name=coperace type="checkbox"></center></td></tr>
<tr><td>Import z Ext.Systému</td><td><center><input name=wimport type="checkbox"></center></td><td><center><input name=rimport type="checkbox"></center></td></tr>
<tr><td>Export pro Ext.Systém + Opravy</td><td><center><input name=wexport type="checkbox"></center></td><td><center><input name=rexport type="checkbox"></center></td></tr>
<tr><td>Reporty</td><td></td><td><center><input name=reporty type="checkbox"></center></td></tr>
<tr><td>Stravování</td><td><center><input name=wstravovani type="checkbox"></center></td><td><center><input name=rstravovani type="checkbox"></center></td></tr>
<tr><td>Exporty/Reporty Obìdù</td><td><center><input name=wfobedy type="checkbox"></center></td><td><center><input name=rfobedy type="checkbox"></center></td></tr>
<tr><td>Kniha Úrazù</td><td><center><input name=wurazy type="checkbox"></center></td><td><center><input name=rurazy type="checkbox"></center></td></tr>
<tr><td>Systémová Nastavení</td><td><center><input name=zpojistovna type="checkbox"></center></td><td><center><input name=cpojistovna type="checkbox"></center></td></tr>
<tr><td>Nastavení Zabezpeèení</td><td><center><input name=zmaterial type="checkbox"></center></td><td><center><input name=cmaterial type="checkbox"></center></td></tr>
<tr><td>Nastavení Druhù Záznamù</td><td><center><input name=zprace type="checkbox"></center></td><td><center><input name=cprace type="checkbox"></center></td></tr>
<tr><td>Nastavení Turniketù</td><td><center><input name=wturnikety type="checkbox"></center></td><td><center><input name=rturnikety type="checkbox"></center></td></tr>


<tr><td>Správa Uživatelù</td><td><center><input name=zuzivatel type="checkbox"></center></td><td><center><input name=cuzivatel type="checkbox"></center></td></tr>
<tr><td>Úkolové Výkazy</td><td><center><input name=wukol type="checkbox"></center></td><td><center><input name=rukol type="checkbox"></center></td></tr>
<tr><td>Firemní Údaje</td><td><center><input name=zfirma type="checkbox"></center></td><td><center><input name=cfirma type="checkbox"></center></td></tr>

<tr bgcolor="#C0FFFF"><td colspan=3><center>Spravuje Støediska</center></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from stredisko where stav='ANO' order by kod");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
?><tr><td colspan=2><?echo mysql_result($data1,@$cykl,1)." ".mysql_result($data1,@$cykl,2);?></td><td><center><input name="stredisko<?echo mysql_result($data1,@$cykl,1);?>" type="checkbox" ></center></td></tr><?

@$cykl++;endwhile;?>


<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uložit Nového Uživatele"></center><BR></td></tr><?}?>












<?if (@$uzivatel=="Úprava Existujícího Uživatele"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$uzivatel;?></b></center></td></tr>

<tr><td>Pøihlašovací Jméno:</td><td colspan=2><select name=jmeno size="1" style=width:100% onchange=submit(this)>
<option><?if (@$jmeno<>""){echo@$jmeno;}?></option>
<?include ("./"."dbconnect.php");
@$jmeno1=mysql_query("select jmeno from login where jmeno<>'$jmeno' order by jmeno");
@$pocet=mysql_num_rows($jmeno1);@$cykl=0;
while (@$cykl<@$pocet):
?><option><?echo(mysql_result($jmeno1,@$cykl,0));?></option><?
@$cykl++;endwhile;?></select></td></tr>

<tr><td>Pøihlašovací Heslo:</td><td colspan=2><input type="text" name=heslo value="<?if (@$jmeno<>""){echo"Beze Zmìn";}?>" size="20"></td></tr>
<?
include ("./"."dbconnect.php");
@$cjmeno1=mysql_query("select cjmeno from login where jmeno='$jmeno' order by id");
@$cprijmeni1=mysql_query("select cprijmeni from login where jmeno='$jmeno' order by id");
@$ctitul1=mysql_query("select titul from login where jmeno='$jmeno' order by id");
@$cjmeno=mysql_result(@$cjmeno1,0,0);
@$cprijmeni=mysql_result(@$cprijmeni1,0,0);
@$ctitul=mysql_result(@$ctitul1,0,0);

?>
<tr><td>Titul:</td><td colspan=2><input type="text" name=ctitul value="<?echo@$ctitul;?>" size="20"></td></tr>
<tr><td>Jméno:</td><td colspan=2><input type="text" name=cjmeno value="<?echo@$cjmeno;?>" size="20"></td></tr>
<tr><td>Pøíjmení:</td><td colspan=2><input type="text" name=cprijmeni value="<?echo@$cprijmeni;?>" size="20"></td></tr>

<tr><td colspan=3><BR></td></tr>

<tr bgcolor="#C0FFFF"><td><center>Nastavení Práv</center></td><td><center>Zápis</center></td><td><center>Ètení</center></td></tr>

<?include ("./"."dbconnect.php");@$pravo1=mysql_query("select * from login where jmeno='$jmeno' order by jmeno");@$pravo=mysql_result($pravo1,0,6);?>

<tr><td>Èíselník Auto.Èíselná Øada</td><td><center><input name=zpacient type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "A")){echo"checked";}?>></center></td>
<td><center><input name=cpacient type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "a")){echo"checked";}?>></center></td></tr>

<tr><td>Èíselník Kategorií</td><td><center><input name=zkod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "K")){?>checked<?}?> ></center></td>
<td><center><input name=ckod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "k")){echo"checked";}?>></center></td></tr>

<tr><td>Èíselník Støedisek</td><td><center><input name=zskod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "U")){?>checked<?}?> ></center></td>
<td><center><input name=cskod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "u")){echo"checked";}?>></center></td></tr>

<tr><td>Èíselník Zamìstnancù</td><td><center><input name=zzaznam type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "Z")){echo"checked";}?>></center></td>
<td><center><input name=czaznam type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "z")){echo"checked";}?>></center></td></tr>

<tr><td>Import z Ext.Systému</td><td><center><input name=wimport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "I")){echo"checked";}?>></center></td>
<td><center><input name=rimport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "i")){echo"checked";}?>></center></td></tr>

<tr><td>Export pro Ext.Systém + Opravy</td><td><center><input name=wexport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "E")){echo"checked";}?>></center></td>
<td><center><input name=rexport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "e")){echo"checked";}?>></center></td></tr>

<tr><td>Docházka Zamìstnancù</td><td><center><input name=zoperace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "O")){echo"checked";}?>></center></td>
<td><center><input name=coperace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "o")){echo"checked";}?>></center></td></tr>

<tr><td>Reporty</td><td><center></center></td>
<td><center><input name=reporty type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "r")){echo"checked";}?>></center></td></tr>

<tr><td>Stravování</td><td><center><input name=wstravovani type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "H")){echo"checked";}?>></center></td>
<td><center><input name=rstravovani type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "h")){echo"checked";}?>></center></td></tr>

<tr><td>Exporty/Reporty Obìdù</td><td><center><input name=wfobedy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "C")){echo"checked";}?>></center></td>
<td><center><input name=rfobedy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "c")){echo"checked";}?>></center></td></tr>

<tr><td>Kniha Úrazù</td><td><center><input name=wurazy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "X")){echo"checked";}?>></center></td>
<td><center><input name=rurazy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "x")){echo"checked";}?>></center></td></tr>

<tr><td>Systémová Nastavení</td><td><center><input name=zpojistovna type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "L")){echo"checked";}?>></center></td>
<td><center><input name=cpojistovna type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "l")){echo"checked";}?>></center></td></tr>

<tr><td>Nastavení Zabezpeèení</td><td><center><input name=zmaterial type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "M")){echo"checked";}?>></center></td>
<td><center><input name=cmaterial type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "m")){echo"checked";}?>></center></td></tr>

<tr><td>Nastavení Druhù Záznamù</td><td><center><input name=zprace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "V")){echo"checked";}?>></center></td>
<td><center><input name=cprace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "v")){echo"checked";}?>></center></td></tr>

<tr><td>Nastavení Turniketù</td><td><center><input name=wturnikety type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "T")){echo"checked";}?>></center></td>
<td><center><input name=rturnikety type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "t")){echo"checked";}?>></center></td></tr>



<tr><td>Správa Uživatelù</td><td><center><input name=zuzivatel type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "S")){echo"checked";}?>></center></td>
<td><center><input name=cuzivatel type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "s")){echo"checked";}?>></center></td></tr>

<tr><td>Úkolové výkazy</td><td><center><input name=wukol type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "B")){echo"checked";}?>></center></td>
<td><center><input name=rukol type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "b")){echo"checked";}?>></center></td></tr>

<tr><td>Firemní Údaje</td><td><center><input name=zfirma type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "F")){echo"checked";}?>></center></td>
<td><center><input name=cfirma type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "f")){echo"checked";}?>></center></td></tr>

<tr bgcolor="#C0FFFF"><td colspan=3><center>Spravuje Støediska</center></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from stredisko where stav='ANO' order by kod");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
?><tr><td colspan=2><?echo mysql_result($data1,@$cykl,1)." ".mysql_result($data1,@$cykl,2);?></td>
<td><center><input name="stredisko<?echo mysql_result($data1,@$cykl,1);?>" type="checkbox"
<?if (strstr(mysql_result(@$pravo1,0,10),mysql_result($data1,@$cykl,1).",")==true) {echo"hi";?> checked <?}?>
></center></td></tr>

<?@$cykl++;endwhile;?>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uložit Opraveného Uživatele"></center><BR></td></tr><?}?>











<?if (@$uzivatel=="Odstranìní Existujícího Uživatele"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$uzivatel;?></b></center></td></tr>

<tr><td>Pøihlašovací Jméno:</td><td colspan=2><select name=jmeno size="1" style=width:100% onchange=submit(this)>
<option><?if (@$jmeno<>""){echo@$jmeno;}?></option>
<?include ("./"."dbconnect.php");
@$jmeno1=mysql_query("select jmeno from login where jmeno<>'$jmeno' order by jmeno");
@$pocet=mysql_num_rows($jmeno1);@$cykl=0;
while (@$cykl<@$pocet):
?><option><?echo(mysql_result($jmeno1,@$cykl,0));?></option><?
@$cykl++;endwhile;?></select></td></tr>

<tr><td>Pøihlašovací Heslo:</td><td colspan=2><?if (@$jmeno<>""){echo"Beze Zmìn";}?></td></tr>
<?
include ("./"."dbconnect.php");
@$cjmeno1=mysql_query("select cjmeno from login where jmeno='$jmeno' order by id");
@$cprijmeni1=mysql_query("select cprijmeni from login where jmeno='$jmeno' order by id");
@$ctitul1=mysql_query("select titul from login where jmeno='$jmeno' order by id");
@$cjmeno=mysql_result(@$cjmeno1,0,0);
@$cprijmeni=mysql_result(@$cprijmeni1,0,0);
@$ctitul=mysql_result(@$ctitul1,0,0);

?>
<tr><td>Titul:</td><td colspan=2><input type="text" name=ctitul value="<?echo@$ctitul;?>" size="20" readonly=yes></td></tr>
<tr><td>Jméno:</td><td colspan=2><input type="text" name=cjmeno value="<?echo@$cjmeno;?>" size="20" readonly=yes></td></tr>
<tr><td>Pøíjmení:</td><td colspan=2><input type="text" name=cprijmeni value="<?echo@$cprijmeni;?>" size="20" readonly=yes></td></tr>

<tr><td colspan=3><BR></td></tr>

<tr bgcolor="#C0FFFF"><td><center>Nastavení Práv</center></td><td><center>Zápis</center></td><td><center>Ètení</center></td></tr>

<?include ("./"."dbconnect.php");@$pravo1=mysql_query("select * from login where jmeno='$jmeno' order by jmeno");@$pravo=mysql_result($pravo1,0,6);?>

<tr><td>Èíselník Auto.Èíselná Øada</td><td><center><input name=zpacient type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "A")){echo"checked";}?> disabled></center></td>
<td><center><input name=cpacient type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "a")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Èíselník Kategorií</td><td><center><input name=zkod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "K")){?>checked<?}?> disabled ></center></td>
<td><center><input name=ckod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "k")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Èíselník Støedisek</td><td><center><input name=zskod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "U")){?>checked<?}?> disabled ></center></td>
<td><center><input name=cskod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "u")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Èíselník Zamìstnancù</td><td><center><input name=zzaznam type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "Z")){echo"checked";}?> disabled></center></td>
<td><center><input name=czaznam type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "z")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Docházka Zamìstnancù</td><td><center><input name=zoperace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "O")){echo"checked";}?> disabled></center></td>
<td><center><input name=coperace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "o")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Import z Ext.Systému</td><td><center><input name=wimport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "I")){echo"checked";}?> disabled></center></td>
<td><center><input name=rimport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "i")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Export pro Ext.Systém + Opravy</td><td><center><input name=wexport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "E")){echo"checked";}?> disabled></center></td>
<td><center><input name=rexport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "e")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Reporty</td><td><center></center></td>
<td><center><input name=reporty type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "r")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Stravování</td><td><center><input name=wstravovani type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "H")){echo"checked";}?> disabled></center></td>
<td><center><input name=rstravovani type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "h")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Exporty/Reporty Obìdù</td><td><center><input name=wfobedy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "C")){echo"checked";}?> disabled></center></td>
<td><center><input name=rfobedy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "c")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Kniha Úrazù</td><td><center><input name=wurazy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "X")){echo"checked";}?> disabled></center></td>
<td><center><input name=rurazy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "x")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Systémová Nastavení</td><td><center><input name=zpojistovna type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "L")){echo"checked";}?> disabled></center></td>
<td><center><input name=cpojistovna type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "l")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Nastavení Zabezpeèení</td><td><center><input name=zmaterial type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "M")){echo"checked";}?> disabled></center></td>
<td><center><input name=cmaterial type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "m")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Nastavení Druhù Záznamù</td><td><center><input name=zprace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "V")){echo"checked";}?> disabled></center></td>
<td><center><input name=cprace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "v")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Nastavení Turniketù</td><td><center><input name=wturnikety type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "T")){echo"checked";}?> disabled></center></td>
<td><center><input name=rturnikety type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "t")){echo"checked";}?> disabled></center></td></tr>


<tr><td>Správa Uživatelù</td><td><center><input name=zuzivatel type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "S")){echo"checked";}?> disabled></center></td>
<td><center><input name=cuzivatel type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "s")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Úkolové Výkazy</td><td><center><input name=wukol type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "B")){echo"checked";}?> disabled></center></td>
<td><center><input name=rukol type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "b")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Firemní Údaje</td><td><center><input name=zfirma type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "F")){echo"checked";}?> disabled></center></td>
<td><center><input name=cfirma type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "f")){echo"checked";}?> disabled></center></td></tr>

<tr bgcolor="#C0FFFF"><td colspan=3><center>Spravuje Støediska</center></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from stredisko where stav='ANO' order by kod");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
?><tr><td colspan=2><?echo mysql_result($data1,@$cykl,1)." ".mysql_result($data1,@$cykl,2);?></td>
<td><center><input name="stredisko<?echo mysql_result($data1,@$cykl,1);?>" type="checkbox"
<?if (strstr(mysql_result(@$pravo1,0,10),mysql_result($data1,@$cykl,1).",")==true) {echo"hi";?> checked <?}?> disabled></center></td></tr>

<?@$cykl++;endwhile;?>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Odstranit Uživatele"></center><BR></td></tr><?}?>

<?}?>





<? if (StrPos (" " . $_SESSION["prava"], "s") or (StrPos (" " . $_SESSION["prava"], "S")) ){        // pøehled aktivních uživatelù?>

<?if (@$uzivatel=="Pøehled Aktivních Uživatelù"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b>Pøehled Aktivních Uživatelù</b></center></td></tr>

<tr><td>Pøihlašovací Jméno:</td><td colspan=2><select name=jmeno size="1" style=width:100% onchange=submit(this)>
<option><?if (@$jmeno<>""){echo@$jmeno;}?></option>
<?include ("./"."dbconnect.php");
@$jmeno1=mysql_query("select jmeno from login where jmeno<>'$jmeno' order by jmeno");
@$pocet=mysql_num_rows($jmeno1);@$cykl=0;
while (@$cykl<@$pocet):
?><option><?echo(mysql_result($jmeno1,@$cykl,0));?></option><?
@$cykl++;endwhile;?></select></td></tr>

<tr><td>Pøihlašovací Heslo:</td><td colspan=2><?echo"Beze Zmìn";?></td></tr>
<?
include ("./"."dbconnect.php");
@$cjmeno1=mysql_query("select cjmeno from login where jmeno='$jmeno' order by id");
@$cprijmeni1=mysql_query("select cprijmeni from login where jmeno='$jmeno' order by id");
@$ctitul1=mysql_query("select titul from login where jmeno='$jmeno' order by id");
@$cjmeno=mysql_result(@$cjmeno1,0,0);
@$cprijmeni=mysql_result(@$cprijmeni1,0,0);
@$ctitul=mysql_result(@$ctitul1,0,0);

?>
<tr><td>Titul:</td><td colspan=2><input type="text" name=ctitul value="<?echo@$ctitul;?>" size="20" readonly=yes></td></tr>
<tr><td>Jméno:</td><td colspan=2><input type="text" name=cjmeno value="<?echo@$cjmeno;?>" size="20" readonly=yes></td></tr>
<tr><td>Pøíjmení:</td><td colspan=2><input type="text" name=cprijmeni value="<?echo@$cprijmeni;?>" size="20" readonly=yes></td></tr>

<tr><td colspan=3><BR></td></tr>

<tr bgcolor="#C0FFFF"><td><center>Nastavení Práv</center></td><td><center>Zápis</center></td><td><center>Ètení</center></td></tr>

<?include ("./"."dbconnect.php");@$pravo1=mysql_query("select * from login where jmeno='$jmeno' order by jmeno");@$pravo=mysql_result($pravo1,0,6);?>

<tr><td>Èíselník Auto.Èíselná Øada</td><td><center><input name=zpacient type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "A")){echo"checked";}?> disabled></center></td>
<td><center><input name=cpacient type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "a")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Èíselník Kategorií</td><td><center><input name=zkod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "K")){?>checked<?}?>  disabled></center></td>
<td><center><input name=ckod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "k")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Èíselník Støedisek</td><td><center><input name=zskod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "U")){?>checked<?}?>  disabled></center></td>
<td><center><input name=cskod type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "u")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Èíselník Zamìstnancù</td><td><center><input name=zzaznam type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "Z")){echo"checked";}?> disabled></center></td>
<td><center><input name=czaznam type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "z")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Docházka Zamìstnancù</td><td><center><input name=zoperace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "O")){echo"checked";}?> disabled></center></td>
<td><center><input name=coperace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "o")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Import z Ext.Systému</td><td><center><input name=wimport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "I")){echo"checked";}?> disabled></center></td>
<td><center><input name=rimport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "i")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Export pro Ext.Systém + Opravy</td><td><center><input name=wexport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "E")){echo"checked";}?> disabled></center></td>
<td><center><input name=rexport type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "e")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Reporty</td><td><center></center></td>
<td><center><input name=reporty type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "r")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Stravování</td><td><center><input name=wstravovani type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "H")){echo"checked";}?> disabled></center></td>
<td><center><input name=rstravovani type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "h")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Exporty/Reporty Obìdù</td><td><center><input name=wfobedy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "C")){echo"checked";}?> disabled></center></td>
<td><center><input name=rfobedy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "c")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Kniha Úrazù</td><td><center><input name=wurazy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "X")){echo"checked";}?> disabled></center></td>
<td><center><input name=rurazy type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "x")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Systémová Nastavení</td><td><center><input name=zpojistovna type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "L")){echo"checked";}?> disabled></center></td>
<td><center><input name=cpojistovna type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "l")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Nastavení Zabezpeèení</td><td><center><input name=zmaterial type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "M")){echo"checked";}?> disabled></center></td>
<td><center><input name=cmaterial type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "m")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Nastavení Druhù Záznamù</td><td><center><input name=zprace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "V")){echo"checked";}?> disabled></center></td>
<td><center><input name=cprace type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "v")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Nastavení Turniketù</td><td><center><input name=wturnikety type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "T")){echo"checked";}?> disabled></center></td>
<td><center><input name=rturnikety type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "t")){echo"checked";}?> disabled></center></td></tr>


<tr><td>Správa Uživatelù</td><td><center><input name=zuzivatel type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "S")){echo"checked";}?> disabled></center></td>
<td><center><input name=cuzivatel type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "s")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Úkolové Výkazy</td><td><center><input name=wukol type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "B")){echo"checked";}?> disabled></center></td>
<td><center><input name=rukol type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "b")){echo"checked";}?> disabled></center></td></tr>

<tr><td>Firemní Údaje</td><td><center><input name=zfirma type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "F")){echo"checked";}?> disabled></center></td>
<td><center><input name=cfirma type="checkbox" <?if (@$jmeno<>"" and StrPos (" " . @$pravo, "f")){echo"checked";}?> disabled></center></td></tr>

<tr bgcolor="#C0FFFF"><td colspan=3><center>Spravuje Støediska</center></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from stredisko where stav='ANO' order by kod");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
?><tr><td colspan=2><?echo mysql_result($data1,@$cykl,1)." ".mysql_result($data1,@$cykl,2);?></td>
<td><center><input name="stredisko<?echo mysql_result($data1,@$cykl,1);?>" type="checkbox"
<?if (strstr(mysql_result(@$pravo1,0,10),mysql_result($data1,@$cykl,1).",")==true) {?> checked <?}?> disabled></center></td></tr>

<?@$cykl++;endwhile;?>

<?}}?>




</table></center>
</form>
