<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];
@$menuold=@$_POST["menuold"];

@$kod=@$_POST["kod"];
@$stav=@$_POST["stav"];
@$nazev=@$_POST["nazev"];
@$cas=@$_POST["cas"];
@$nazevnew=@$_POST["nazevnew"];
@$barva=@$_POST["barva"];
@$prestavka=@$_POST["prestavka"];
@$id_ukonu=@$_POST["id_ukonu"];
@$poradi=@$_POST["poradi"];
@$firstload=@$_POST["firstload"]; if (@$menu<>@$menuold and @$menuold<>"") {@$firstload="";@$load=1;while ($_POST["stav".@$load]<>""):unset($_POST["stav".@$load]);@$load++;endwhile;}

@$zaznam=1;

if (@$menu=="InfoPanel" and @$tlacitko=="Ulo�it Str�nku"){		mysql_query("update setting set hodnota='".securesql(@$_POST["infocas"])."' where nazev='Info�as' ") or Die(MySQL_Error());
if (mysql_num_rows(mysql_query("select id from infopanel where strana='".securesql(@$_POST["stranka"])."'"))) {	mysql_query("update infopanel set obsah='".securesql(stripslashes($_POST['FCKeditor1']))."',cas='".securesql(@$_POST["sitecas"])."',vlozil='".securesql($loginname)."',datumvkladu='".securesql($dnes)."' where strana='".securesql(@$_POST["stranka"])."' ") or Die(MySQL_Error());}	else
	{mysql_query("insert into infopanel (strana,obsah,vlozil,datumvkladu,cas)VALUES('".securesql(@$_POST["stranka"])."','".securesql(stripslashes($_POST['FCKeditor1']))."','".securesql($loginname)."','".securesql($dnes)."','".securesql(@$_POST["sitecas"])."')") or Die(MySQL_Error());}
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Str�nky <?echo @$_POST["stranka"];?> prob�hlo �sp�n�.</b></center></td></tr></table><?
}

if (@$menu=="InfoPanel" and @$tlacitko=="Del"){
mysql_query("delete from infopanel where strana='".securesql(@$_POST["stranka"])."'") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Odstran�n� Str�nky <?echo @$_POST["stranka"];?> prob�hlo �sp�n�.</b></center></td></tr></table><?
}


if (@$tlacitko=="Ulo�it �kolov� Vstupn� Hodnoty") {
include ("./"."dbconnect.php");mysql_query ("truncate table ukol_sumhodnoty")or Die(MySQL_Error());
@$prvni=1;while ($_POST["stav".@$prvni]==" + " or $_POST["stav".(@$prvni+1)]==" + " or $_POST["stav".(@$prvni+2)]==" + " or $_POST["stav".(@$prvni+3)]==" + "):
@$value1="";if ($_POST["stav".@$prvni]==" + ") {@$value1=$_POST["nazev".@$prvni];}

$hodnota="";$value2=",";@$druhy=1;while ($_POST["slozka!".@$prvni."!".@$druhy]==" + " or $_POST["slozka!".@$prvni."!".(@$druhy+1)]==" + " or $_POST["slozka!".@$prvni."!".(@$druhy+2)]==" + " or $_POST["slozka!".@$prvni."!".(@$druhy+3)]==" + "):
if ($_POST["slozka!".@$prvni."!".@$druhy]==" + ") {$value2.=$_POST["slozkah!".@$prvni."!".@$druhy].",";}
@$druhy++;endwhile;
if (@$value1<>"" and @$value2<>",") {mysql_query ("INSERT INTO ukol_sumhodnoty (nazev,hodnota,datumvkladu,vlozil) VALUES('".securesql($value1)."','".securesql($value2)."', '".securesql($dnes)."','".securesql($loginname)."')") or Die(MySQL_Error());}
@$prvni++;endwhile;
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� �kolov�ch Vstupn�ch Hodnot Prob�hlo �sp�n�.</b></center></td></tr></table><?
@$firstload="";@$tlacitko="";}


if (@$tlacitko=="Ulo�it Sum�rn� Hodnoty") {include ("./"."dbconnect.php");mysql_query ("truncate table sumhodnoty")or Die(MySQL_Error());
@$prvni=1;while ($_POST["stav".@$prvni]==" + " or $_POST["stav".(@$prvni+1)]==" + " or $_POST["stav".(@$prvni+2)]==" + " or $_POST["stav".(@$prvni+3)]==" + "):
@$value1="";if ($_POST["stav".@$prvni]==" + ") {@$value1=$_POST["nazev".@$prvni];}

$hodnota="";$value2=",";@$druhy=1;while ($_POST["slozka!".@$prvni."!".@$druhy]==" + " or $_POST["slozka!".@$prvni."!".(@$druhy+1)]==" + " or $_POST["slozka!".@$prvni."!".(@$druhy+2)]==" + " or $_POST["slozka!".@$prvni."!".(@$druhy+3)]==" + "):
if ($_POST["slozka!".@$prvni."!".@$druhy]==" + ") {$value2.=$_POST["slozkah!".@$prvni."!".@$druhy].",";}
@$druhy++;endwhile;
if (@$value1<>"" and @$value2<>",") {mysql_query ("INSERT INTO sumhodnoty (nazev,hodnota,datumvkladu,vlozil) VALUES('$value1','$value2', '$dnes','$loginname')") or Die(MySQL_Error());}
@$prvni++;endwhile;
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Sum�rn�ch Hodnot Prob�hlo �sp�n�.</b></center></td></tr></table><?@$firstload="";@$tlacitko="";}




if (@$tlacitko=="Ulo�it Sv�tky") {
include ("./"."dbconnect.php");mysql_query ("truncate table svatky")or Die(MySQL_Error());
$cykl=1;while (@$_POST["nazev".$cykl]<>"" or @$_POST["nazev".($cykl+1)]<>"" or @$_POST["nazev".($cykl+2)]<>"" or @$_POST["nazev".($cykl+3)]<>"" or @$_POST["nazev".($cykl+4)]<>""):
@$value1=@$_POST["nazev".$cykl];
@$casti = explode(".", @$_POST["datum".$cykl]);@$value2   = $casti[2]."-".$casti[1]."-".$casti[0];
@$value3=@$_POST["typ".$cykl];
@$casti = explode(".", @$_POST["datumdo".$cykl]);@$value4   = $casti[2]."-".$casti[1]."-".$casti[0];
@$value5=@$_POST["svatek".$cykl];
mysql_query ("INSERT INTO svatky (nazev,datum,typ,datumvkladu,vlozil,datumdo,stav) VALUES('$value1','$value2', '$value3', '$dnes','$loginname','$value4','$value5')") or Die(MySQL_Error());
@$cykl++;endwhile;?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Sv�tk� Prob�hlo �sp�n�</b></center></td></tr></table><?
@$tlacitko="";$firstload="";}


if (@$tlacitko=="Ulo�it Mzdov� Slo�ky") {
include ("./"."dbconnect.php");
$cykl=1;while (@$_POST["sysnum".$cykl]<>"" or @$_POST["sysnum".($cykl+1)]<>"" or @$_POST["sysnum".($cykl+2)]<>"" or @$_POST["sysnum".($cykl+3)]<>"" or @$_POST["sysnum".($cykl+4)]<>""):
@$value1=@$_POST["sysnum".$cykl];
@$value2=@$_POST["sysname".$cykl];
@$value3=@$_POST["reduction".$cykl];
@$value4=@$_POST["sysid".$cykl];
if (@$_POST["export".$cykl]=="on") {@$value5="ANO";} else {@$value5="NE";}
if (@$_POST["sloucit".$cykl]=="on") {@$value8="ANO";} else {@$value8="NE";}
if (@$_POST["rozlstr".$cykl]=="on") {@$value9="ANO";} else {@$value9="NE";}
@$value6=@$_POST["sestava".$cykl];
@$value7=@$_POST["vypocet".$cykl];

if (@$value4=="") {mysql_query ("INSERT INTO external_system (sysnumber,sysname,reduction,datumvkladu,vlozil,export,sestava,vypocet,sloucit,rozl_strediska) VALUES('$value1','$value2', '$value3', '$dnes','$loginname','$value5','$value6', '$value7','$value8','$value9')") or Die(MySQL_Error());}
else {mysql_query ("update external_system set sysnumber = '$value1',sysname='$value2',reduction='$value3',export='$value5',sestava='$value6',vypocet='$value7',sloucit='$value8',rozl_strediska='$value9',datumvkladu = '$dnes', vlozil ='$loginname' where id = '$value4' ")or Die(MySQL_Error());}
@$cykl++;endwhile;?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Mzdov�ch Slo�ek Prob�hlo �sp�n�</b></center></td></tr></table><?
@$tlacitko="";$firstload="";}




if (@$nazev<>"" and @$tlacitko=="Ulo�it Novou Funk�n� Kl�vesu") {
include ("./"."dbconnect.php");
mysql_query ("update klavesnice set text = '$nazev',stav='Aktivn�',barva='$barva',id_ukonu='$id_ukonu', datumvkladu = '$dnes', vlozil ='$loginname',poradi='".securesql($poradi)."' where cislo = '$kod' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Nov�ho Nastaven� Funk�n� Kl�vesy <?echo@$kod;?> Prob�hlo �sp�n�</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$kod="";}

if (@$menu=="Nastaven� Zobrazen� �asu" and @$cas<>""){include ("./"."dbconnect.php");
mysql_query ("update setting set hodnota = '$cas', datumvkladu = '$dnes', vlozil ='$loginname' where nazev = '�as' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Nov�ho Nastaven� �asu <?echo@$kod;?> Prob�hlo �sp�n�</b></center></td></tr></table><?
@$cas="";}

if (@$menu=="Nastaven� P�est�vky" and @$tlacitko=="Ulo�it Nastaven� P�est�vky"){
include ("./"."dbconnect.php");
mysql_query ("update setting set hodnota = '$prestavka', datumvkladu = '$dnes', vlozil ='$loginname' where nazev = 'P�est�vka' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Nastaven� �P�est�vky Prob�hlo �sp�n�</b></center></td></tr></table><?
@$cas="";}

if (@$menu=="Nastaven� Po�tu Ob�d� v T�dnu" and @$tlacitko=="Ulo�it Nastaven� Ob�d�"){
include ("./"."dbconnect.php");$obedy=$_POST["obedy"].",".$_POST["obedy1"]."/".$_POST["obedy2"]."/".$_POST["obedy3"]."/".$_POST["obedy4"]."/".$_POST["obedy5"]."/".$_POST["obedy6"]."/".$_POST["obedy7"]."/".$_POST["obedy8"]."/".$_POST["obedy9"]."/".$_POST["obedy10"];
mysql_query ("update setting set hodnota = '".mysql_real_escape_string($obedy)."', datumvkladu = '$dnes', vlozil ='$loginname' where nazev = 'Ob�dy' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Nastaven� Po�tu Ob�d� Prob�hlo �sp�n�</b></center></td></tr></table><?
@$obedy="";}

if (@$nazevnew<>"" and @$tlacitko=="Ulo�it Opravenou Funk�n� Kl�vesu") {
include ("./"."dbconnect.php");
mysql_query ("update klavesnice set text = '$nazevnew', stav='$stav',barva='$barva',id_ukonu='$id_ukonu', datumzmeny = '$dnes', zmenil ='$loginname',poradi='".securesql($poradi)."' where cislo = '$kod' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Upraven� Funk�n� Kl�vesy <?echo@$kod;?> Prob�hlo �sp�n�</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$kod="";}


if (@$menu=="Nastaven� Sn�mac�ho Za��zen�" and @$tlacitko=="Ulo�it"){include ("./"."dbconnect.php");
mysql_query ("update setting set hodnota = '".mysql_real_escape_string($_POST["snimac"])."', datumvkladu = '$dnes', vlozil ='$loginname' where nazev = 'Sn�ma�' ")or Die(MySQL_Error());
mysql_query ("update setting set hodnota = '".mysql_real_escape_string($_POST["msnimac"])."', datumvkladu = '$dnes', vlozil ='$loginname' where nazev = 'MSn�ma�' ")or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Nastaven� Sn�mac�ho Za��zen� prob�hlo v po��dku</b></center></td></tr></table><?
@$menu="";@$tlacitko="";}


if (@$kod<>"" and @$tlacitko=="Odstranit Vybranou Funk�n� Kl�vesu") {
include ("./"."dbconnect.php");
mysql_query ("update klavesnice set text = '', stav='Neaktivn�', barva='', id_ukonu='', datumzmeny = '$dnes', zmenil ='$loginname' where cislo = '$kod' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Odstran�n� Vybran� Funk�n� Kl�vesy Prob�hlo �sp�n�</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$kod="";}


?>

<form action="hlavicka.php?akce=<?echo base64_encode('NastaveniKlaves');?>" method=post><input name="menuold" type="hidden" value="<?echo@$menu;?>">

<h2><p align="center">Syst�mov� Nastaven�:
<? if (StrPos (" " . $_SESSION["prava"], "L") or StrPos (" " . $_SESSION["prava"], "l") or StrPos (" " . $_SESSION["prava"], "H")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "L")){?>
   <?if (@$menu<>"Nastaven� Extern�ho Syst�mu"){?><option>Nastaven� Extern�ho Syst�mu</option><?}?>
   <?if (@$menu<>"Nastaven� P�est�vky"){?><option>Nastaven� P�est�vky</option><?}?>
   <?if (@$menu<>"Nastaven� Sn�mac�ho Za��zen�"){?><option>Nastaven� Sn�mac�ho Za��zen�</option><?}?>
   <?if (@$menu<>"Nastaven� Sum�rn�ch Hodnot"){?><option>Nastaven� Sum�rn�ch Hodnot</option><?}?>
   <?if (@$menu<>"Nastaven� �kolov�ch Vstupn�ch Hodnot"){?><option>Nastaven� �kolov�ch Vstupn�ch Hodnot</option><?}?>
   <?if (@$menu<>"Nastaven� Sv�tk�"){?><option>Nastaven� Sv�tk�</option><?}?>
   <?if (@$menu<>"Nastaven� Zobrazen� �asu"){?><option>Nastaven� Zobrazen� �asu</option><?}?>
   <?if (@$menu<>"Scanovac� Okna"){?><option>Scanovac� Okna</option><?}?>
   <?if (@$menu<>"InfoPanel"){?><option>InfoPanel</option><?}?>
   <option disabled></option>
   <?if (@$menu<>"Aktivace Nov� Funk�n� Kl�vesy"){?><option>Aktivace Nov� Funk�n� Kl�vesy</option><?}?>
   <?if (@$menu<>"Upraven� Funk�n� Kl�vesy"){?><option>Upraven� Funk�n� Kl�vesy</option><?}?>
   <?if (@$menu<>"Odebr�n� Funk�n� Kl�vesy"){?><option>Odebr�n� Funk�n� Kl�vesy</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "L") or StrPos (" " . $_SESSION["prava"], "l")){?>
   <?if (@$menu<>"P�ehled Nastaven� Funk�n�ch Kl�ves"){?><option>P�ehled Nastaven� Funk�n�ch Kl�ves</option><?}?>
   <?if (@$menu<>"Tisk Nastaven� Funk�n�ch Kl�ves"){?><option>Tisk Nastaven� Funk�n�ch Kl�ves</option><?}}?>

<? if (StrPos (" " . $_SESSION["prava"], "L") or StrPos (" " . $_SESSION["prava"], "H")){?>
   <?if (@$menu<>"Nastaven� Po�tu Ob�d� v T�dnu"){?><option>Nastaven� Po�tu Ob�d� v T�dnu</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "L") and (!StrPos (" " . $_SESSION["prava"], "l")) and (!StrPos (" " . $_SESSION["prava"], "H")) ){?>Nem�te P��stupov� Pr�va<?}?>

<center><table  bgcolor="#EDB745" border=2>


<? if (StrPos (" " . $_SESSION["prava"], "H")){
if (@$menu=="Nastaven� Po�tu Ob�d� v T�dnu"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Po�et dn� v t�dnu / po�et meny na den, Polo�ka s nulovou cenou se objedn�v� automaticky" border="0"></b></center></td></tr>
<tr><td colspan=2>Nastaven� Ob�d�:</td><td colspan=2>
<?include ("./"."dbconnect.php");@$data1=mysql_query("select * from setting where nazev='Ob�dy' order by id");$obedy1=explode("/",@mysql_result($data1,0,2));$obedy=explode(",",$obedy1[0]);
?><select name="obedy" >
<?echo"<option>".$obedy[0]."</option>";
@$cykl=1;while(@$cykl<8):
if (@$cykl<>$obedy[0]){echo"<option>".@$cykl."</option>";}
@$cykl++;endwhile;
?></select> dn� v t�dnu</td></tr>
<tr><td colspan=2>Po�et Denn�ch Menu:</td><td colspan=2><input name="obedy1" type="text" value="<?echo$obedy[1];?>" size=1 ></td></tr>
<tr><td colspan=2>Ob�dy ve Sv�tek:</td><td colspan=2><select size="1" name="obedy3"><?if ($obedy1[2]<>"") {echo"<option>".$obedy1[2]."</option>";}if ($obedy1[2]=="ANO") {echo"<option >NE</option>";} else {echo"<option >ANO</option>";}?></select></td></tr>
<tr><td colspan=2>Objedn�vky o V�kendu:</td><td colspan=2><select size="1" name="obedy6"><?if ($obedy1[5]<>"") {echo"<option>".$obedy1[5]."</option>";}if ($obedy1[5]=="ANO") {echo"<option >NE</option>";} else {echo"<option >ANO</option>";}?></select></td></tr>
<tr><td colspan=2>Objedn�vky ve Sv�tek:</td><td colspan=2><select size="1" name="obedy7"><?if ($obedy1[6]<>"") {echo"<option>".$obedy1[6]."</option>";}if ($obedy1[6]=="ANO") {echo"<option >NE</option>";} else {echo"<option >ANO</option>";}?></select></td></tr>
<tr><td colspan=2>Ozna�en� Ob�d�:</td><td colspan=2><input name="obedy2" type="text" value="<?echo$obedy1[1];?>" size=34 ></td></tr>
<tr><td colspan=2>Ceny Ob�d�:</td><td colspan=2><input name="obedy4" type="text" value="<?echo$obedy1[3];?>" size=34 ></td></tr>
<tr><td colspan=2>�as Objedn�n� <img src="picture/help.png" width="16" height="16" title="ud�v�no v hodin�ch v aktu�ln�m dni p�: (format: 8:30,) = do 8:30 hodin akt dne; -16:00, do 8 hodin p�ede�l�ho dne" border="0">:</td><td colspan=2><input name="obedy5" type="text" value="<?echo$obedy1[4];?>" size=34 ></td></tr>
<tr><td colspan=2>Typ Ob�d�<img src="picture/help.png" width="16" height="16" title="H- hlavn� j�dlo,HP- hlavn� s mo�nost� p��lohy,HPL- hlavn� s mo�nost� p��lohy s limitem doobjedn�n�,V-vedlej�� (lze objednat k hlavn�mu j�dlu)" border="0">:</td><td colspan=2><input name="obedy8" type="text" value="<?echo$obedy1[7];?>" size=34 ></td></tr>
<tr><td colspan=2>P��lohy<img src="picture/help.png" width="16" height="16" title="1 m�sto=�as kdy lze p��lohu objednat(format: 8:00, nebo -10:30,), seznam p��loh" border="0">:</td><td colspan=2><input name="obedy9" type="text" value="<?echo$obedy1[8];?>" size=34 ></td></tr>
<tr><td colspan=2>Limit Doob�dn�n�<img src="picture/help.png" width="16" height="16" title="Limituj�c� po�et,kter� lze doobjednat pro skupinu HPL v aktu�ln�m dni" border="0">:</td><td colspan=2><input name="obedy10" type="text" value="<?echo$obedy1[9];?>" size=34 ></td></tr>
<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Ulo�it Nastaven� Ob�d�"></center><BR></td></tr><?}


}?>

<? if (StrPos (" " . $_SESSION["prava"], "L")){?>




<?if (@$menu=="Nastaven� �kolov�ch Vstupn�ch Hodnot"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="toto nastaven� definuje, kter� hodnoty se maj� se��st a doplnit k jednotliv�m lidem do �kolov� tabulky" border="0"></b></center></td></tr>
<tr bgcolor="#B4ADFC" align=center><td>Akce</td><td>N�zev</td><td>Slo�ky</td><td>Mzdov� Slo�ka</td></tr>
<?include ("./"."dbconnect.php");

if (@$firstload==1) {
while ($_POST["stav".@$zaznam]<>""):
if ($_POST["stav".@$zaznam]==" + ") {?>
<tr><td><input type=hidden name="stav<?echo@$zaznam;?>" value=" + "><input type="submit" name="stav<?echo@$zaznam;?>" value=" - " style=width:25px></td>
<td><input name="nazev<?echo@$zaznam;?>" type="text" value="<?echo $_POST["nazev".@$zaznam];?>"></td>

<?$contdef=mysql_query("select * from external_system order by id");
@$pocet=1;while ($_POST["slozka!".@$zaznam."!".@$pocet]<>""):
if (@$pocet>1 and $_POST["slozka!".@$zaznam."!".@$pocet]==" + ") {echo"<tr><td colspan=2></td>";}
if ($_POST["slozka!".@$zaznam."!".@$pocet]==" + ") {?><td><input type=hidden name="slozka!<?echo@$zaznam;?>!<?echo@$pocet;?>" value=" + "><input type="submit" name="slozka!<?echo@$zaznam;?>!<?echo@$pocet;?>" value=" - " style=width:25px></td>
<td><select size="1" name="slozkah!<?echo@$zaznam;?>!<?echo@$pocet;?>"><?if ($_POST["slozkah!".@$zaznam."!".@$pocet]<>"") {@$id=$_POST["slozkah!".@$zaznam."!".@$pocet];echo"<option value=".@$id.">".@$id." / ".mysql_result(mysql_query("select sysname from external_system where sysnumber='$id'"),0,0)."</option>";}@$cykl=0;while (@$cykl<mysql_num_rows($contdef)):?><option value="<?echo mysql_result($contdef,@$cykl,1);?>"><?echo mysql_result($contdef,@$cykl,1)." / ".mysql_result($contdef,@$cykl,2);?></option><?$cykl++;endwhile;?></select></td>
</tr><?} else {?><input type=hidden name="slozka<?echo@$pocet;?>" value=" - "><?}
if ($_POST["slozkah!".@$zaznam."!".@$pocet+1]==" + ") {echo "<tr><td colspan=2></td>";}
@$pocet++;endwhile;
if ($_POST["slozka!".@$zaznam."!1"]<>"") {echo "<tr><td colspan=2></td>";}?><td colspan=2><input type=submit name="slozka!<?echo@$zaznam;?>!<?echo@$pocet++;?>" value=" + " style=width:25px></td></tr>
<?} else {?><input type=hidden name="stav<?echo@$zaznam;?>" value=" - "><?}
@$zaznam++;endwhile;}

if (@$firstload=="") {@$firstload=1;$data1=mysql_query("select * from ukol_sumhodnoty order by id");$contdef=mysql_query("select * from external_system order by id");
while (@$zaznam<mysql_num_rows($data1)+1):?>
<tr><td><input type=hidden name="stav<?echo@$zaznam;?>" value=" + "><input type="submit" name="stav<?echo@$zaznam;?>" value=" - " style=width:25px></td>
<td><input name="nazev<?echo@$zaznam;?>" type="text" value="<?echo mysql_result($data1,@$zaznam-1,1);?>"></td>

<?@$casti = explode(",", mysql_result($data1,@$zaznam-1,2));
@$pocet=1;while (@$casti[@$pocet]<>""): if (@$pocet>1) {echo"<tr><td colspan=2></td>";}?>
<td><input type=hidden name="slozka!<?echo@$zaznam;?>!<?echo@$pocet;?>" value=" + "><input type="submit" name="slozka!<?echo@$zaznam;?>!<?echo@$pocet;?>" value=" - " style=width:25px></td>
<td><select size="1" name="slozkah!<?echo@$zaznam;?>!<?echo@$pocet;?>"><?@$id=@$casti[@$pocet];echo"<option value=".@$id.">".@$id." / ".mysql_result(mysql_query("select sysname from external_system where sysnumber='$id'"),0,0)."</option>";
@$cykl=0;while (@$cykl<mysql_num_rows($contdef)):?><option value="<?echo mysql_result($contdef,@$cykl,1);?>"><?echo mysql_result($contdef,@$cykl,1)." / ".mysql_result($contdef,@$cykl,2);?></option><?$cykl++;endwhile;?></select></td>
</tr><?if (@$casti[@$pocet+1]<>"") {echo "<tr><td colspan=2></td>";}
@$pocet++;endwhile;
if (@$pocet>1) {echo "<tr><td colspan=2></td>";}?><td colspan=2><input type=submit name="slozka!<?echo@$zaznam;?>!<?echo@$pocet++;?>" value=" + " style=width:25px></td></tr>
<?@$zaznam++;endwhile;}?>

<input name="firstload" type="hidden" value="<?echo@$firstload;?>">
<tr><td colspan=4><input type="submit" name="stav<?echo@$zaznam++;?>" value=" + " style=width:25px></td></tr>
<tr><td colspan=4 align=center><br /><input type="submit" name="tlacitko" value="Ulo�it �kolov� Vstupn� Hodnoty"></td></tr>
<?}?>




<?if (@$menu=="Scanovac� Okna"){?>

<tr><td colspan=2 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr><td>Vyber Vstupn� Okno:</td><td><select size="1" name="okno" onchange=submit(this) >
<option></option>
<option>Doch�zkov� Okno</option>
<option>Manu�ln� Ovl. Turniket�</option>
<option>Okno pro Turnikety</option>
<option>Okno pro V�dejnu Ob�d�</option>
</select></td></tr>

<?if (@$_POST["okno"]=="Doch�zkov� Okno") {?>
<script type="text/javascript">
window.open('<?echo $loadhardware;?>.php','','toolbar=0,fullscreen=yes , directories=0, location=0, status=0, menubar=0, resizable=0, scrollbars=0, titlebar=0');
</script><?}?>

<?if (@$_POST["okno"]=="Manu�ln� Ovl. Turniket�") {?>
<script type="text/javascript">
window.open('Turniket/www/manual.php','','toolbar=0,fullscreen=yes , directories=0, location=0, status=0, menubar=0, resizable=0, scrollbars=0, titlebar=0');
</script><?}?>

<?if (@$_POST["okno"]=="Okno pro Turnikety") {?>
<script type="text/javascript">
window.open('Turniket/www/index.php','','toolbar=0,fullscreen=yes , directories=0, location=0, status=0, menubar=0, resizable=0, scrollbars=0, titlebar=0');
</script><?}?>

<?if (@$_POST["okno"]=="Okno pro V�dejnu Ob�d�") {?>
<script type="text/javascript">
window.open('OScan.php','','toolbar=0,fullscreen=yes , directories=0, location=0, status=0, menubar=0, resizable=0, scrollbars=0, titlebar=0');
</script><?}?>

<?}?>







<?if (@$menu=="Nastaven� Extern�ho Syst�mu"){?>

<style type="text/css">
tr.menuon  {background-color:#F1BEED;}
tr.menuoff {background-color:#EDB745;}
</style>

<tr><td colspan=9 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr bgcolor="#B4ADFC"><td align=center><center>��slo Mz.Slo�ky</center></td><td align=center>N�zev Mz.Slo�ky</td><td align=center>K�d Importu</td><td align=center>Exportovat</td><td align=center>Sestava</td><td align=center>V�po�et</td>
<td align=center>Slu�ovat CD / Rozli�ovat st�ediska</td></tr>
<?
if (@$firstload=="") {include ("./"."dbconnect.php");$contdef=mysql_query("select * from external_system order by id");
while (@$zaznam-1<mysql_num_rows($contdef)):
?><input name="firstload" type="hidden" value="1"><input type=hidden name="stav<?echo@$zaznam;?>" value=" + " style=width:25px>
<tr style=cursor:pointer onmouseover="className='menuon';" onmouseout="className='menuoff';"><input name="sysid<?echo@$zaznam;?>" type="hidden" value="<?echo @mysql_result($contdef,@$zaznam-1,0);?>" style=width:150>
<td><input name="sysnum<?echo@$zaznam;?>" type="text" value="<?echo @mysql_result($contdef,@$zaznam-1,1);?>" style=width:150></td>
<td><input name="sysname<?echo@$zaznam;?>" type="text" value="<?echo @mysql_result($contdef,@$zaznam-1,2);?>" style=width:150></td>
<td><input name="reduction<?echo@$zaznam;?>" type="text" value="<?echo @mysql_result($contdef,@$zaznam-1,3);?>" style=width:150></td>
<td align=middle><input name="export<?echo@$zaznam;?>" type="checkbox" <?if (@mysql_result($contdef,@$zaznam-1,6)=="ANO"){echo"Checked";}?> ></td>
<td><input name="sestava<?echo@$zaznam;?>" type="text" value="<?echo @mysql_result($contdef,@$zaznam-1,7);?>" style=width:100></td>
<td><select size="1" name="vypocet<?echo@$zaznam;?>"><?if (@mysql_result($contdef,@$zaznam-1,8)=="MANUAL") {echo"<option>MANUAL</option><option>SYSTEM DOV 1</option><option>SYSTEM DOV 2</option><option>SYSTEM SV</option><option>SYSTEM SO/NE</option>";}if (@mysql_result($contdef,@$zaznam-1,8)=="SYSTEM SV") {echo"<option>SYSTEM SV</option><option>SYSTEM SO/NE</option><option>SYSTEM DOV 1</option><option>SYSTEM DOV 2</option><option>MANUAL</option>";}if (@mysql_result($contdef,@$zaznam-1,8)=="SYSTEM SO/NE") {echo"<option>SYSTEM SO/NE</option><option>SYSTEM SV</option><option>SYSTEM DOV 1</option><option>SYSTEM DOV 2</option><option>MANUAL</option>";}if (@mysql_result($contdef,@$zaznam-1,8)=="SYSTEM DOV 1") {echo"<option>SYSTEM DOV 1</option><option>SYSTEM DOV 2</option><option>SYSTEM SO/NE</option><option>SYSTEM SV</option><option>MANUAL</option>";}if (@mysql_result($contdef,@$zaznam-1,8)=="SYSTEM DOV 2") {echo"<option>SYSTEM DOV 2</option><option>SYSTEM DOV 1</option><option>SYSTEM SO/NE</option><option>SYSTEM SV</option><option>MANUAL</option>";}?></select></td>
<td align=middle><input name="sloucit<?echo@$zaznam;?>" type="checkbox" <?if (@mysql_result($contdef,@$zaznam-1,9)=="ANO"){echo"Checked";}?> > /
 <input name="rozlstr<?echo@$zaznam;?>" type="checkbox" <?if (@mysql_result($contdef,@$zaznam-1,10)=="ANO"){echo"Checked";}?> >
</td>

</tr><?
@$zaznam++;endwhile;}

while ($_POST["stav".@$zaznam]<>"" or $_POST["stav".@$zaznam+1]<>"" or $_POST["stav".@$zaznam+2]<>"" or $_POST["stav".@$zaznam+3]<>"" or $_POST["stav".@$zaznam+4]<>""):

if ($_POST["stav".@$zaznam]==" + "){?>
<tr style=cursor:pointer onmouseover="className='menuon';" onmouseout="className='menuoff';"><input name="firstload" type="hidden" value="<?echo@$firstload;?>"><input type=hidden name="stav<?echo@$zaznam;?>" value=" + " style=width:25px>
<input name="sysid<?echo@$zaznam;?>" type="hidden" value="<?if ($_POST['sysid'.@$zaznam]<>'') {echo $_POST['sysid'.@$zaznam];}?>" style=width:150>
<td><input name="sysnum<?echo@$zaznam;?>" type="text" value="<?if ($_POST['sysnum'.@$zaznam]<>'') {echo $_POST['sysnum'.@$zaznam];}?>" style=width:150></td>
<td><input name="sysname<?echo@$zaznam;?>" type="text" value="<?if ($_POST['sysname'.@$zaznam]<>'') {echo $_POST['sysname'.@$zaznam];}?>" style=width:150></td>
<td><input name="reduction<?echo@$zaznam;?>" type="text" value="<?if ($_POST['reduction'.@$zaznam]<>'') {echo $_POST['reduction'.@$zaznam];}?>" style=width:150></td>
<td align=middle><input name="export<?echo@$zaznam;?>" type="checkbox" <?if ($_POST['export'.@$zaznam]=='on') {echo"Checked";}?> ></td>
<td><input name="sestava<?echo@$zaznam;?>" type="text" value="<?if ($_POST['sestava'.@$zaznam]<>'') {echo $_POST['sestava'.@$zaznam];}?>" style=width:100></td>
<td><select size="1" name="vypocet<?echo@$zaznam;?>"><?if ($_POST['vypocet'.@$zaznam]=="MANUAL" or $_POST['vypocet'.@$zaznam]=="") {echo"<option>MANUAL</option><option>SYSTEM DOV 1</option><option>SYSTEM DOV 2</option><option>SYSTEM SV</option><option>SYSTEM SO/NE</option>";}if ($_POST['vypocet'.@$zaznam]=="SYSTEM SV") {echo"<option>SYSTEM SV</option><option>SYSTEM SO/NE</option><option>SYSTEM DOV 1</option><option>SYSTEM DOV 2</option><option>MANUAL</option>";}if ($_POST['vypocet'.@$zaznam]=="SYSTEM SO/NE") {echo"<option>SYSTEM SO/NE</option><option>SYSTEM SV</option><option>SYSTEM DOV 1</option><option>SYSTEM DOV 2</option><option>MANUAL</option>";}if ($_POST['vypocet'.@$zaznam]=="SYSTEM DOV 1") {echo"<option>SYSTEM DOV 1</option><option>SYSTEM DOV 2</option><option>SYSTEM SO/NE</option><option>SYSTEM SV</option><option>MANUAL</option>";}if ($_POST['vypocet'.@$zaznam]=="SYSTEM DOV 2") {echo"<option>SYSTEM DOV 2</option><option>SYSTEM DOV 1</option><option>SYSTEM SO/NE</option><option>SYSTEM SV</option><option>MANUAL</option>";}?></select></td>
<td align=middle><input name="sloucit<?echo@$zaznam;?>" type="checkbox" <?if ($_POST['sloucit'.@$zaznam]=='on') {echo"Checked";}?> > /
 <input name="rozlstr<?echo@$zaznam;?>" type="checkbox" <?if ($_POST['rozlstr'.@$zaznam]=='on') {echo"Checked";}?> ></td>
</tr>
<?}
@$zaznam++;endwhile;?>
<tr><td colspan=8><input type="submit" name="stav<?echo@$zaznam++;?>" value=" + " style=width:25px></td></tr>
<tr><td colspan=8 align=center><br /><input type="submit" name="tlacitko" value="Ulo�it Mzdov� Slo�ky"></td></tr>
<?}?>


<?if (@$menu=="Aktivace Nov� Funk�n� Kl�vesy"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Mus� b�t Zad�ny:P��chod,Odchod,��dost o Aktivaci; v�echny hodnoty za��naj�c� slovem 'Odchod' se berou jako odchod, ale v DB se daj� rozli�it" border="0"></b></center></td></tr>
<tr><td>��slo Kl�vesy:</td><td colspan=2><select size="1" name="kod">
<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from klavesnice where stav='Neaktivn�' order by cislo");
@$cykl=0;
while(@$cykl<mysql_num_rows($data1)):
?><option><?echo mysql_result($data1,@$cykl,2);?></option><?
@$cykl++;Endwhile;?>
</select></td></tr>
<tr><td>N�zev Funkce:</td><td colspan=2><textarea name="nazev" rows=5 cols=20 wrap="on"></textarea></td></tr>
<tr><td>Po�ad� (v Dot.M�du) <img src="picture/help.png" width="16" height="16" title="Mus� b�t zad�no pouze v Dotykov�m m�du (hodnoty 1 a v��e), jinak nechat pr�zdn� nebo nulu" border="0">:</td><td colspan=2><input name="poradi" type="text" value="" style=width:100%></td></tr>
<tr><td>Barva v P�ehledu:<img src="picture/help.png" width="16" height="16" title="Barva sta�� zvolit pouze u stejn�ch nastaven� nap� v�ce odchod� form�t #FFFFFF"></td><td colspan=2><input name="barva" type="text" value="" style=width:100%></td></tr>
<tr><td valign=top>Nab�zen� Akce:<img src="picture/help.png" width="16" height="16" title="Nab�zen� Akce navr�en� syst�mem po men��m odpr. �asu ne� je stanoven� pracovn� doba"></td><td colspan=2>
<select name="id_ukonu" style=width:100% ><option></option>
<?include ("./"."dbconnect.php");@$datas1 = mysql_query("select * from ukony where stav ='Aktivn�' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):
?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Ulo�it Novou Funk�n� Kl�vesu"></center><BR></td></tr><?}?>



<?if (@$menu=="Nastaven� Sv�tk�"){?>
<tr><td colspan=8 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr bgcolor="#B4ADFC"><td align=center><center><b>Nastaven� Sv�tku</b></center></td><td align=center><center><b>N�zev Sv�tku</b></center></td><td colspan=2 align=center>Datum Od</td><td colspan=2 align=center>Datum Do</td><td align=center>Typ Sv�tku</td><td align=center>Stav</td></tr>
<?
if (@$firstload=="") {include ("./"."dbconnect.php");$contdef=mysql_query("select * from svatky order by datum,id");
while (@$zaznam-1<mysql_num_rows($contdef)):?><input name="firstload" type="hidden" value="1">
<tr><td><input type=hidden name="stav<?echo@$zaznam;?>" value=" + " style=width:25px><input type="submit" name="stav<?echo@$zaznam;?>" value=" - " style=width:25px></td>
<td><input name="nazev<?echo@$zaznam;?>" type="text" value="<?echo @mysql_result($contdef,@$zaznam-1,2);?>" style=width:150></td>
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," ET"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok mus� b�t ��slo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><td colspan=2 align=center width=150><input type="text" name="datum<?echo@$zaznam;?>" value="<?@$casti = explode('-', @mysql_result($contdef,@$zaznam-1,1));echo $casti[2].'.'.$casti[1].'.'.$casti[0];?>" style="width:60%" ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datum<?echo@$zaznam;?>,'span_pokus1','cpokus');"style="width:38%" ><SPAN ID="span_pokus1"></td>

<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," ET"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok mus� b�t ��slo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><td colspan=2 align=center width=150><input type="text" name="datumdo<?echo@$zaznam;?>" value="<?if (@mysql_result($contdef,@$zaznam-1,8)<>'0000-00-00') {@$casti = explode('-', @mysql_result($contdef,@$zaznam-1,8));echo $casti[2].'.'.$casti[1].'.'.$casti[0];}?>" style="width:60%" ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumdo<?echo@$zaznam;?>,'span_pokus2','cpokus');"style="width:38%" ><SPAN ID="span_pokus2"></td>
<td align=center><select size="1" name="typ<?echo@$zaznam;?>"><option><?echo @mysql_result($contdef,@$zaznam-1,3);?></option>
<option>Trval�</option><option>Jedine�n�</option></select></td>
<td align=center><select size="1" name="svatek<?echo@$zaznam;?>">
<?if (@mysql_result($contdef,@$zaznam-1,9)=="Aktivn�")  {?><option>Aktivn�</option><option>Neaktivn�</option><?} else {?><option>Neaktivn�</option><option>Aktivn�</option><?}?>
</select></td></tr><?
@$zaznam++;endwhile;}

while ($_POST["stav".@$zaznam]<>"" or $_POST["stav".@$zaznam+1]<>"" or $_POST["stav".@$zaznam+2]<>"" or $_POST["stav".@$zaznam+3]<>"" or $_POST["stav".@$zaznam+4]<>""):

if ($_POST["stav".@$zaznam]==" + "){?>
<tr><td>
<input name="firstload" type="hidden" value="<?echo@$firstload;?>">
<input type=hidden name="stav<?echo@$zaznam;?>" value=" + " style=width:25px><input type="submit" name="stav<?echo@$zaznam;?>" value=" - " style=width:25px></td>
<td><input name="nazev<?echo@$zaznam;?>" type="text" value="<?if ($_POST['nazev'.@$zaznam]<>'') {echo $_POST['nazev'.@$zaznam];}?>" style=width:150></td>
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," ET"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok mus� b�t ��slo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><td colspan=2 align=center width=150><input type="text" name="datum<?echo@$zaznam;?>" value="<?if ($_POST['datum'.@$zaznam]<>'') {echo $_POST['datum'.@$zaznam];}?>" style="width:60%" ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datum<?echo@$zaznam;?>,'span_pokus1','cpokus');"style="width:38%" ><SPAN ID="span_pokus1"></td>

<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," ET"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok mus� b�t ��slo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><td colspan=2 align=center width=150><input type="text" name="datumdo<?echo@$zaznam;?>" value="<?if ($_POST['datumdo'.@$zaznam]<>'') {echo $_POST['datumdo'.@$zaznam];}?>" style="width:60%" ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumdo<?echo@$zaznam;?>,'span_pokus2','cpokus');"style="width:38%" ><SPAN ID="span_pokus2"></td>

<td align=center><select size="1" name="typ<?echo@$zaznam;?>"><?if ($_POST["typ".@$zaznam]){?><option><?echo $_POST["typ".@$zaznam];?></option><?}?>
<option>Trval�</option><option>Jedine�n�</option></select></td>
<td align=center><select size="1" name="svatek<?echo@$zaznam;?>">
<?if ($_POST["svatek".@$zaznam]=="Aktivn�")  {?><option>Aktivn�</option><option>Neaktivn�</option><?} else {?><option>Neaktivn�</option><option>Aktivn�</option><?}?>
</select></td></tr>
<?} else
 {?><input type=hidden name="stav<?echo@$zaznam;?>" value=" - " style=width:25px><?}

 @$zaznam++;endwhile;?>
<tr><td colspan=8><input type="submit" name="stav<?echo@$zaznam++;?>" value=" + " style=width:25px></td></tr>
<tr><td colspan=8 align=center><br /><input type="submit" name="tlacitko" value="Ulo�it Sv�tky"></td></tr>
<?}?>



<?if (@$menu=="Nastaven� Sn�mac�ho Za��zen�"){include ("./"."dbconnect.php");$data=mysql_result(mysql_query("select hodnota from setting where nazev='Sn�ma�' "),0,0);$data1=mysql_result(mysql_query("select hodnota from setting where nazev='MSn�ma�' "),0,0);?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Slou�� k nasaven� opera�n�ho syst�mu, ke kter�mu je sn�ma� p�ipojen" border="0"></b></center></td></tr>
<tr><td colspan=2>Opera�n� Syst�m:</td><td colspan=2><select style=width:220px size="1" name="snimac">
<?
if (@$data=="Linux") {echo"<option>Linux</option><option>Windows</option>";}
if (@$data=="Windows") {echo"<option>Windows</option><option>Linux</option>";}
?></select></td></tr>
<tr><td colspan=2>Sn�mac� Za��zen�:</td><td colspan=2><select style=width:220px size="1" name="msnimac">
<?
if (@$data1=="Dot. Obr. (+Ob�dy&Info)") {echo"<option>Dot. Obr. (+Ob�dy&Info)</option><option>Dotykov� Obrazovka (+Ob�dy)</option><option>Numlock</option>";}
if (@$data1=="Dotykov� Obrazovka (+Ob�dy)") {echo"<option>Dotykov� Obrazovka (+Ob�dy)</option><option>Dot. Obr. (+Ob�dy&Info)</option><option>Numlock</option>";}
if (@$data1=="Numlock") {echo"<option>Numlock</option><option>Dotykov� Obrazovka (+Ob�dy)</option><option>Dot. Obr. (+Ob�dy&Info)</option>";}
?></select></td></tr>

<tr><td colspan=4><input name=tlacitko type="submit" value="Ulo�it"></td></tr>
<?}?>




<?if (@$menu=="Nastaven� Sum�rn�ch Hodnot"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Sum�� slou�� pro vytvo�en� nov� kolonky ve zrychlen�m p�ehledu a s��t� pouze 1 volby v Druz�ch z�znam�" border="0"></b></center></td></tr>
<tr bgcolor="#B4ADFC" align=center><td>Akce</td><td>N�zev</td><td>Slo�ky</td><td>Mzdov� Slo�ka</td></tr>
<?include ("./"."dbconnect.php");

if (@$firstload==1) {
while ($_POST["stav".@$zaznam]<>""):
if ($_POST["stav".@$zaznam]==" + ") {?>
<tr><td><input type=hidden name="stav<?echo@$zaznam;?>" value=" + "><input type="submit" name="stav<?echo@$zaznam;?>" value=" - " style=width:25px></td>
<td><input name="nazev<?echo@$zaznam;?>" type="text" value="<?echo $_POST["nazev".@$zaznam];?>"></td>

<?$contdef=mysql_query("select * from external_system order by id");
@$pocet=1;while ($_POST["slozka!".@$zaznam."!".@$pocet]<>""):
if (@$pocet>1 and $_POST["slozka!".@$zaznam."!".@$pocet]==" + ") {echo"<tr><td colspan=2></td>";}
if ($_POST["slozka!".@$zaznam."!".@$pocet]==" + ") {?><td><input type=hidden name="slozka!<?echo@$zaznam;?>!<?echo@$pocet;?>" value=" + "><input type="submit" name="slozka!<?echo@$zaznam;?>!<?echo@$pocet;?>" value=" - " style=width:25px></td>
<td><select size="1" name="slozkah!<?echo@$zaznam;?>!<?echo@$pocet;?>"><?if ($_POST["slozkah!".@$zaznam."!".@$pocet]<>"") {@$id=$_POST["slozkah!".@$zaznam."!".@$pocet];echo"<option value=".@$id.">".@$id." / ".mysql_result(mysql_query("select sysname from external_system where sysnumber='$id'"),0,0)."</option>";}@$cykl=0;while (@$cykl<mysql_num_rows($contdef)):?><option value="<?echo mysql_result($contdef,@$cykl,1);?>"><?echo mysql_result($contdef,@$cykl,1)." / ".mysql_result($contdef,@$cykl,2);?></option><?$cykl++;endwhile;?></select></td>
</tr><?} else {?><input type=hidden name="slozka<?echo@$pocet;?>" value=" - "><?}
if ($_POST["slozkah!".@$zaznam."!".@$pocet+1]==" + ") {echo "<tr><td colspan=2></td>";}
@$pocet++;endwhile;
if ($_POST["slozka!".@$zaznam."!1"]<>"") {echo "<tr><td colspan=2></td>";}?><td colspan=2><input type=submit name="slozka!<?echo@$zaznam;?>!<?echo@$pocet++;?>" value=" + " style=width:25px></td></tr>
<?} else {?><input type=hidden name="stav<?echo@$zaznam;?>" value=" - "><?}
@$zaznam++;endwhile;}

if (@$firstload=="") {@$firstload=1;$data1=mysql_query("select * from sumhodnoty order by id");$contdef=mysql_query("select * from external_system order by id");
while (@$zaznam<mysql_num_rows($data1)+1):?>
<tr><td><input type=hidden name="stav<?echo@$zaznam;?>" value=" + "><input type="submit" name="stav<?echo@$zaznam;?>" value=" - " style=width:25px></td>
<td><input name="nazev<?echo@$zaznam;?>" type="text" value="<?echo mysql_result($data1,@$zaznam-1,1);?>"></td>

<?@$casti = explode(",", mysql_result($data1,@$zaznam-1,2));
@$pocet=1;while (@$casti[@$pocet]<>""): if (@$pocet>1) {echo"<tr><td colspan=2></td>";}?>
<td><input type=hidden name="slozka!<?echo@$zaznam;?>!<?echo@$pocet;?>" value=" + "><input type="submit" name="slozka!<?echo@$zaznam;?>!<?echo@$pocet;?>" value=" - " style=width:25px></td>
<td><select size="1" name="slozkah!<?echo@$zaznam;?>!<?echo@$pocet;?>"><?@$id=@$casti[@$pocet];echo"<option value=".@$id.">".@$id." / ".mysql_result(mysql_query("select sysname from external_system where sysnumber='$id'"),0,0)."</option>";
@$cykl=0;while (@$cykl<mysql_num_rows($contdef)):?><option value="<?echo mysql_result($contdef,@$cykl,1);?>"><?echo mysql_result($contdef,@$cykl,1)." / ".mysql_result($contdef,@$cykl,2);?></option><?$cykl++;endwhile;?></select></td>
</tr><?if (@$casti[@$pocet+1]<>"") {echo "<tr><td colspan=2></td>";}
@$pocet++;endwhile;
if (@$pocet>1) {echo "<tr><td colspan=2></td>";}?><td colspan=2><input type=submit name="slozka!<?echo@$zaznam;?>!<?echo@$pocet++;?>" value=" + " style=width:25px></td></tr>
<?@$zaznam++;endwhile;}?>

<input name="firstload" type="hidden" value="<?echo@$firstload;?>">
<tr><td colspan=4><input type="submit" name="stav<?echo@$zaznam++;?>" value=" + " style=width:25px></td></tr>
<tr><td colspan=4 align=center><br /><input type="submit" name="tlacitko" value="Ulo�it Sum�rn� Hodnoty"></td></tr>
<?}?>



<?if (@$menu=="InfoPanel"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="12 AM/PM nebo 24 hodin" border="0"></b></center></td></tr>
<tr><td colspan=2>zobrazen� Infopanelu za �as ne�innosti (v sec.):</td><td colspan=2><input name="infocas" type="text" value="<?echo mysql_result(mysql_query("select hodnota from setting where nazev='Info�as'"),0,0);?>" style=width:100%></td></tr>
<tr><td colspan=2>Str�nka:</td><td width=80px><select size="1" name="stranka" onchange=submit(this) style=width:100%>
<?if (@$_POST["stranka"]) {echo"<option>".@$_POST["stranka"]."</option>";} else {echo"<option></option>";}
$data1=mysql_query("select * from infopanel order by strana");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (@$_POST["stranka"]<>mysql_result(@$data1,@$cykl,1)){echo"<option>".mysql_result(@$data1,@$cykl,1)."</option>";}
@$cykl++;endwhile;?></select></td>
<td width=55px><input type=submit name=stranka value="<?echo $cykl+1;?>" alt="N.Str.">
<?if (@$_POST["stranka"]) { if (mysql_num_rows(mysql_query("select id from infopanel where strana='".securesql(@$_POST["stranka"])."'"))){?><input name=tlacitko type="submit" value="Del"><?}?></td></tr>
<tr><td colspan=2>�as zobrazen� str�nky (v sec.):</td><td colspan=2><input name="sitecas" type="text" value="<?echo mysql_result(mysql_query("select cas from infopanel where strana='".securesql(@$_POST["stranka"])."'"),0,0) ;?>" style=width:100%></td></tr>
<tr><td colspan=4 style=background:#BAD5FC;text-align:center;><b>Obsah</b></td></tr>
<?include("./fckeditor/fckeditor.php");?>
<tr><td colspan=4 width=800px style=height:100%;align:left align=left>
<?$oFCKeditor = new FCKeditor('FCKeditor1') ;
  $oFCKeditor->BasePath = './fckeditor/' ;
  $oFCKeditor->Value =mysql_result(mysql_query("select obsah from infopanel where strana='".securesql(@$_POST["stranka"])."'"),0,0) ;
  $oFCKeditor->Create() ;?>
<br><input type="submit" name=tlacitko value="Ulo�it Str�nku" align=right></td></tr><?}?>


<?}?>




<?if (@$menu=="Nastaven� Zobrazen� �asu"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="12 AM/PM nebo 24 hodin" border="0"></b></center></td></tr>
<tr><td>Nastaven� Zobrazen� �asu:</td><td colspan=2><select size="1" name="cas" onchange=submit(this)>
<?include ("./"."dbconnect.php");@$data1=mysql_query("select * from setting where nazev='�as' order by id");
if (mysql_result($data1,0,2)==12) {?><option>12</option><option>24</option><?} else {?><option>24</option><option>12</option><?}?></select></td></tr><?}?>


<?if (@$menu=="Nastaven� P�est�vky"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="definuje 1 �asovou jedotku v�etn� p�est�vky (pracovn� �as + 1 p�est�vka)" border="0"></b></center></td></tr>
<tr><td>Nastaven� P�est�vky:</td><td colspan=2>
<?include ("./"."dbconnect.php");@$data1=mysql_query("select * from setting where nazev='P�est�vka' order by id");
?><input name="prestavka" type="text" value="<?echo @mysql_result($data1,0,2);?>" style=width:100px > (hod.)</td></tr>
<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Ulo�it Nastaven� P�est�vky"></center><BR></td></tr><?}?>


<?if (@$menu=="Upraven� Funk�n� Kl�vesy"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu?> <img src="picture/help.png" width="16" height="16" title="Mus� b�t Zad�ny:P��chod,Odchod,��dost o Aktivaci; v�echny hodnoty za��naj�c� slovem 'Odchod' se berou jako odchod, ale v DB se daj� rozli�it" border="0"></b></center></td></tr>
<tr><td colspan=2>��slo Kl�vesy:</td><td colspan=2><select size="1" name="kod" onchange=submit(this)>
<?
if (@$kod<>"") {?><option><?echo@$kod;?></option><?} else {?><option></option><?}
include ("./"."dbconnect.php");@$data1=mysql_query("select * from klavesnice where stav='Aktivn�' order by cislo");@$cykl=0;
while(@$cykl<mysql_num_rows($data1)):
if (@$kod<>mysql_result($data1,@$cykl,2)) {?><option><?echo mysql_result($data1,@$cykl,2);?></option><?}
@$cykl++;Endwhile;?>
</select></td></tr>
<?if (@$kod<>""){@$data1 = mysql_query("select * from klavesnice where cislo='$kod' ") or Die(MySQL_Error());?>
<tr><td colspan=2>N�zev Funkce:</td><td colspan=2><textarea name="nazevnew" rows=5 cols=20 wrap="on"><?echo (mysql_result($data1,0,3));?></textarea></td></tr>
<tr><td colspan=2>Po�ad� (v Dot.M�du) <img src="picture/help.png" width="16" height="16" title="Mus� b�t zad�no pouze v Dotykov�m m�du (hodnoty 1 a v��e), jinak nechat pr�zdn� nebo nulu" border="0">:</td><td colspan=2><input name="poradi" type="text" value="<?echo @mysql_result($data1,0,12);?>" style=width:100%></td></tr>
<tr><td colspan=2>Barva v P�ehledu:<img src="picture/help.png" width="16" height="16" title="Barva sta�� zvolit pouze u stejn�ch nastaven� nap� v�ce odchod� form�t #FFFFFF"></td><td colspan=2 bgcolor="<?echo @mysql_result($data1,@$cykl,9);?>"><input name="barva" type="text" value="<?if (mysql_result($data1,0,9)<>'#' and mysql_result($data1,0,9)<>'') {echo mysql_result($data1,0,9);}?>" style=width:100%></td></tr>
<tr><td colspan=2>Stav:</td><td colspan=2><select size="1" name="stav">
<?if (mysql_result($data1,0,4)=="Aktivn�"){?><option>Aktivn�</option><option>Neaktivn�</option><?} else {?><option>Neaktivn�</option><option>Aktivn�</option><?}?></select></td></tr>

<tr><td colspan=2 valign=top>Nab�zen� Akce:<img src="picture/help.png" width="16" height="16" title="Nab�zen� Akce navr�en� syst�mem po men��m odpr. �asu ne� je stanoven� pracovn� doba"></td><td colspan=2>
<select name="id_ukonu" style=width:100% >
<option value="<?echo @$id=(@mysql_result($data1,0,10));?>"><?echo @mysql_result(mysql_query("select nazev from ukony where id='$id' "),0,0);?></option>
<option></option>
<?include ("./"."dbconnect.php");@$datas1 = mysql_query("select * from ukony where stav ='Aktivn�' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):
?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select></td></tr>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Ulo�it Opravenou Funk�n� Kl�vesu"></center><BR></td></tr><?}}?>





<?if (@$menu=="Odebr�n� Funk�n� Kl�vesy"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu?> <img src="picture/help.png" width="16" height="16" title="Mus� b�t Zad�ny:P��chod,Odchod,��dost o Aktivaci; v�echny hodnoty za��naj�c� slovem 'Odchod' se berou jako odchod, ale v DB se daj� rozli�it" border="0"></b></center></td></tr>
<tr><td colspan=2>��slo Kl�vesy:</td><td colspan=2><select size="1" name="kod" onchange=submit(this)>
<?
if (@$kod<>"") {?><option><?echo@$kod;?></option><?} else {?><option></option><?}
include ("./"."dbconnect.php");@$data1=mysql_query("select * from klavesnice where stav='Aktivn�' order by cislo");@$cykl=0;
while(@$cykl<mysql_num_rows($data1)):
if (@$kod<>mysql_result($data1,@$cykl,2)) {?><option><?echo mysql_result($data1,@$cykl,2);?></option><?}
@$cykl++;Endwhile;?></select></td></tr>

<?if (@$kod<>""){@$data1 = mysql_query("select * from klavesnice where cislo='$kod' ") or Die(MySQL_Error());?>
<tr><td colspan=2>N�zev Funkce:</td><td colspan=2>
<textarea name="nazevnew" rows=5 cols=25 wrap="on" readonly=yes><?echo (mysql_result($data1,0,3));?></textarea></td></tr>
<tr><td colspan=2>Po�ad� (v Dot.M�du) <img src="picture/help.png" width="16" height="16" title="Mus� b�t zad�no pouze v Dotykov�m m�du (hodnoty 1 a v��e), jinak nechat pr�zdn� nebo nulu" border="0">:</td><td colspan=2><input name="poradi" type="text" value="<?echo @mysql_result($data1,0,12);?>" style=width:100% readonly=yes></td></tr>
<tr><td colspan=2>Barva v P�ehledu:<img src="picture/help.png" width="16" height="16" title="Barva sta�� zvolit pouze u stejn�ch nastaven� nap� v�ce odchod� form�t #FFFFFF"></td><td colspan=2 bgcolor="<?echo @mysql_result($data1,@$cykl,9);?>"><?echo @mysql_result($data1,0,9);?></td></tr>
<tr><td colspan=2>Stav:</td><td colspan=2><?echo mysql_result($data1,0,4);?></td></tr>
<tr><td colspan=2 valign=top>Nab�zen� Akce:<img src="picture/help.png" width="16" height="16" title="Nab�zen� Akce navr�en� syst�mem po men��m odpr. �asu ne� je stanoven� pracovn� doba"></td><td colspan=2>
<?@$id=(@mysql_result($data1,0,10));echo @mysql_result(mysql_query("select nazev from ukony where id='$id' "),0,0);?></td></tr>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Odstranit Vybranou Funk�n� Kl�vesu"></center><BR></td></tr><?}}?>

<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "L") or  StrPos (" " . $_SESSION["prava"], "l") ){?>

<?if (@$menu=="Tisk Nastaven� Funk�n�ch Kl�ves"){?>
<script type="text/javascript">
window.open('TiskKlaves.php')
</script>
<?}?>


<?if (@$menu=="P�ehled Nastaven� Funk�n�ch Kl�ves"){?>
<tr bgcolor="#C0FFC0" align=center><td colspan=9><center><b> <?echo@$menu;?> <img src="picture/help.png" width="16" height="16" title="Mus� b�t Zad�ny:P��chod,Odchod,��dost o Aktivaci; v�echny hodnoty za��naj�c� slovem 'Odchod' se berou jako odchod, ale v DB se daj� rozli�it" border="0"> </b></center></td></tr>
<tr bgcolor="#C0FFC0" align=center><td> Po�ad� </td><td><center>ASCII Hodnota</center></td><td><center>��slo Kl�vesy</center></td>
<td><center>N�zev Funkce</center></td><td><center>Stav Kl�vesy</center></td><td><center>Barva Pozad�</center></td><td><center>Nab�zen� Akce</center></td><td><b> Po�ad� (v Dot.M�du) <img src="picture/help.png" width="16" height="16" title="Mus� b�t zad�no pouze v Dotykov�m m�du (hodnoty 1 a v��e), jinak nechat pr�zdn� nebo nulu" border="0"> </b></td><td><b> Pou�ito </b></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from klavesnice order by cislo,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):

?><tr><td><?echo@$cykl+1;?></td><td><?echo mysql_result($data1,@$cykl,1);?></td><td><?echo $control=mysql_result($data1,@$cykl,2);?></td>
<td><?echo mysql_result($data1,@$cykl,3);?></td><td><?echo mysql_result($data1,@$cykl,4);?></td>
<td bgcolor="<?echo @mysql_result($data1,@$cykl,9);?>"><?echo @mysql_result($data1,@$cykl,9);?></td>
<td><?@$id=(@mysql_result($data1,@$cykl,10));echo @mysql_result(mysql_query("select nazev from ukony where id='$id' "),0,0);?></td>
<td><?echo @mysql_result($data1,@$cykl,12);?></td>
<td align=center>
<?include ("./"."dbconnect.php");
@$control1=mysql_query("select * from dochazka where operace='$control'");@$control=mysql_num_rows($control1);
if (@$control<>"") {echo"ANO";} else {echo"NE";}?>
</td></tr><?

@$cykl++;endwhile;}?>

<?}?>






</table></center>
</form>
