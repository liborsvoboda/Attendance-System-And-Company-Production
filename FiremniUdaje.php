<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];

@$nazev=@$_POST["nazev"];
@$ulice=@$_POST["ulice"];
@$mesto=@$_POST["mesto"];
@$psc=@$_POST["psc"];
@$osoba=@$_POST["osoba"];
@$telefon=@$_POST["telefon"];
@$fax=@$_POST["fax"];
@$mail=@$_POST["mail"];
@$ucet=@$_POST["ucet"];
@$ico=@$_POST["ico"];
@$dic=@$_POST["dic"];
@$cznace=@$_POST["cznace"];
@$soubor=@$_POST["soubor"];
@$logo=@$_POST["logo"];
@$odbornost=@$_POST["odbornost"];
@$cregistrace=@$_POST["cregistrace"];
@$kodb=@$_POST["kodb"];
@$ucetb=@$_POST["ucetb"];
@$odkaz=@$_POST["odkaz"];





if (@$tlacitko=="Uložit Firemní Údaje") {   // uložení firmy

@$docasny = @$_FILES['logo']['tmp_name']; // Umístìní doèasného souboru
@$mime = @$_FILES['logo']['type']; // MIME typ
include ("./"."dbconnect.php");
// Naèteme obsah doèasného souboru
@$logo = implode('', file("$docasny"));


@$dnes=date("Y-n-d");
include ("./"."dbconnect.php");
if (@$mime<>"") {mysql_query ("update firma  set nazev = '$nazev', ulice = '$ulice', mesto = '$mesto', psc ='$psc', osoba='$osoba', telefon='$telefon', fax='$fax', mail='$mail', ucet='$ucet', ico='$ico', dic='$dic', cznace='$cznace',kodb='$kodb',ucetb='$ucetb', odbornost='$odbornost',cregistrace='$cregistrace', soubor='$mime', logo='".mysql_escape_string($logo)."',odkaz='$odkaz' where id = '1' ")or Die(MySQL_Error());}
else {mysql_query ("update firma  set nazev = '$nazev', ulice = '$ulice', mesto = '$mesto', psc ='$psc', osoba='$osoba', telefon='$telefon', fax='$fax', mail='$mail', ucet='$ucet', ico='$ico', dic='$dic', cznace='$cznace',kodb='$kodb',ucetb='$ucetb', odbornost='$odbornost',cregistrace='$cregistrace',odkaz='$odkaz' where id = '1' ")or Die(MySQL_Error());}

?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Firemních Údajù Probìhlo Úspìšnì</b></center></td></tr></table>
<?@$tlacitko="";}?>




<form action="hlavicka.php?akce=<?echo base64_encode('FiremniUdaje');?>" method=post enctype="multipart/form-data">

<h2><p align="center">Nastavení Firemních Údajù:
<? if (StrPos (" " . $_SESSION["prava"], "f") or StrPos (" " . $_SESSION["prava"], "F")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "F")){?>
   <?if (@$menu<>"Nastavit Firemní Údaje"){?><option>Nastavit Firemní Údaje</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "F") or StrPos (" " . $_SESSION["prava"], "f")){?>
   <?if (@$menu<>"Zobrazení Firemních Údajù"){?><option>Zobrazení Firemních Údajù</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "F") and (!StrPos (" " . $_SESSION["prava"], "f")) ){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2 style=width:60%>




<? if (StrPos (" " . $_SESSION["prava"], "F")){?>


<?if (@$menu=="Nastavit Firemní Údaje"){

include ("./"."dbconnect.php");
@$nazev1=mysql_query("select nazev from firma where id='1' ");
@$ulice1=mysql_query("select ulice from firma where id='1' ");
@$mesto1=mysql_query("select mesto from firma where id='1' ");
@$psc1=mysql_query("select psc from firma where id='1' ");
@$osoba1=mysql_query("select osoba from firma where id='1' ");
@$telefon1=mysql_query("select telefon from firma where id='1' ");
@$fax1=mysql_query("select fax from firma where id='1' ");
@$mail1=mysql_query("select mail from firma where id='1' ");
@$ucet1=mysql_query("select ucet from firma where id='1' ");
@$ico1=mysql_query("select ico from firma where id='1' ");
@$dic1=mysql_query("select dic from firma where id='1' ");
@$cznace1=mysql_query("select cznace from firma where id='1' ");
@$kodb1=mysql_query("select kodb from firma where id='1' ");
@$ucetb1=mysql_query("select ucetb from firma where id='1' ");
@$odbornost1=mysql_query("select odbornost from firma where id='1' ");
@$cregistrace1=mysql_query("select cregistrace from firma where id='1' ");
@$odkaz1=mysql_query("select odkaz from firma where id='1' ");

@$nazev=mysql_result(@$nazev1,0,0);
@$ulice=mysql_result(@$ulice1,0,0);
@$mesto=mysql_result(@$mesto1,0,0);
@$psc=mysql_result(@$psc1,0,0);
@$osoba=mysql_result(@$osoba1,0,0);
@$telefon=mysql_result(@$telefon1,0,0);
@$fax=mysql_result(@$fax1,0,0);
@$mail=mysql_result(@$mail1,0,0);
@$ucet=mysql_result(@$ucet1,0,0);
@$ico=mysql_result(@$ico1,0,0);
@$dic=mysql_result(@$dic1,0,0);
@$cznace=mysql_result(@$cznace1,0,0);
@$kodb=mysql_result(@$kodb1,0,0);
@$ucetb=mysql_result(@$ucetb1,0,0);
@$odbornost=mysql_result(@$odbornost1,0,0);
@$cregistrace=mysql_result(@$cregistrace1,0,0);
@$odkaz=mysql_result(@$odkaz1,0,0);
?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?if (@$menu<>""){echo@$menu;} else {echo"Nastavit Firemní Údaje";}?></b></center></td></tr>
<tr><td>Název firmy:</td><td colspan=2><input type="text" name=nazev value="<?echo@$nazev;?>" size="100" style=width:100%></td></tr>
<tr><td>Ulice:</td><td colspan=2><input type="text" name=ulice value="<?echo@$ulice;?>" size="100" style=width:100%></td></tr>
<tr><td>PSÈ a Mìsto:</td><td><input type="text" name=psc value="<?echo@$psc;?>" size="6" style=width:100%></td><td><input type="text" name=mesto value="<?echo@$mesto;?>" size="100" style=width:100%></td></tr>
<tr><td>Kontaktní Osoba:</td><td colspan=2><input type="text" name=osoba value="<?echo@$osoba;?>" size="100" style=width:100%></td></tr>
<tr><td>Telefon:</td><td colspan=2><input type="text" name=telefon value="<?echo@$telefon;?>" size="100" style=width:100%></td></tr>
<tr><td>Fax:</td><td colspan=2><input type="text" name=fax value="<?echo@$fax;?>" size="100" style=width:100%></td></tr>
<tr><td>E-Mail:</td><td colspan=2><input type="text" name=mail value="<?echo@$mail;?>" size="100" style=width:100%></td></tr>
<tr><td>Bankovní Èíslo Úètu:</td><td colspan=2><input type="text" name=ucet value="<?echo@$ucet;?>" size="100" style=width:100%></td></tr>
<tr><td>IÈO:</td><td colspan=2><input type="text" name=ico value="<?echo@$ico;?>" size="100" style=width:100%></td></tr>
<tr><td>DIÈ:</td><td colspan=2><input type="text" name=dic value="<?echo@$dic;?>" size="100" style=width:100%></td></tr>
<tr><td>Pøedmìt Podnikání (CZ-NACE):</td><td colspan=2><input type="text" name=cznace value="<?echo@$cznace;?>" size="100" style=width:100%></td></tr>
<tr><td>Bankovní Spojení:</td><td>Kód Banky<input type="text" name=kodb value="<?echo@$kodb;?>" size="100" style=width:100%></td><td>Èíslo Úètu<input type="text" name=ucetb value="<?echo@$ucetb;?>" size="100" style=width:100%></td></tr>
<tr><td>Èíslo Registrace:</td><td colspan=2><input type="text" name=cregistrace value="<?echo@$cregistrace;?>" size="100" style=width:100%></td></tr>
<tr><td>Odbornost:</td><td colspan=2><input type="text" name=odbornost value="<?echo@$odbornost;?>" size="100" style=width:100%></td></tr>

<tr><td valign=top>Logo:</td><td colspan=2><center><img src=logo.php><BR><input type="file" name=logo value="" size="40" style=width:100%><br />
Odkaz Loga:<br /><input name="odkaz" type="text" value="<?if (@$odkaz<>""){echo@$odkaz;} else {?>http://www.kliknetezde.cz<?}?>" style=width:100%></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uložit Firemní Údaje"></center><BR></td></tr><?}?>






<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "F") or  StrPos (" " . $_SESSION["prava"], "f") ){?>



<?if (@$menu=="Zobrazení Firemních Údajù"){
include ("./"."dbconnect.php");
@$nazev1=mysql_query("select nazev from firma where id='1' ");
@$ulice1=mysql_query("select ulice from firma where id='1' ");
@$mesto1=mysql_query("select mesto from firma where id='1' ");
@$psc1=mysql_query("select psc from firma where id='1' ");
@$osoba1=mysql_query("select osoba from firma where id='1' ");
@$telefon1=mysql_query("select telefon from firma where id='1' ");
@$fax1=mysql_query("select fax from firma where id='1' ");
@$mail1=mysql_query("select mail from firma where id='1' ");
@$ucet1=mysql_query("select ucet from firma where id='1' ");
@$ico1=mysql_query("select ico from firma where id='1' ");
@$dic1=mysql_query("select dic from firma where id='1' ");
@$cznace1=mysql_query("select cznace from firma where id='1' ");
@$kodb1=mysql_query("select kodb from firma where id='1' ");
@$ucetb1=mysql_query("select ucetb from firma where id='1' ");
@$odbornost1=mysql_query("select odbornost from firma where id='1' ");
@$cregistrace1=mysql_query("select cregistrace from firma where id='1' ");
@$odkaz1=mysql_query("select odkaz from firma where id='1' ");

@$nazev=mysql_result(@$nazev1,0,0);
@$ulice=mysql_result(@$ulice1,0,0);
@$mesto=mysql_result(@$mesto1,0,0);
@$psc=mysql_result(@$psc1,0,0);
@$osoba=mysql_result(@$osoba1,0,0);
@$telefon=mysql_result(@$telefon1,0,0);
@$fax=mysql_result(@$fax1,0,0);
@$mail=mysql_result(@$mail1,0,0);
@$ucet=mysql_result(@$ucet1,0,0);
@$ico=mysql_result(@$ico1,0,0);
@$dic=mysql_result(@$dic1,0,0);
@$cznace=mysql_result(@$cznace1,0,0);
@$kodb=mysql_result(@$kodb1,0,0);
@$ucetb=mysql_result(@$ucetb1,0,0);
@$odbornost=mysql_result(@$odbornost1,0,0);
@$cregistrace=mysql_result(@$cregistrace1,0,0);
@$odkaz=mysql_result(@$odkaz1,0,0);

?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu?></b></center></td></tr>
<tr><td>Název firmy:</td><td colspan=2><?echo@$nazev;?></td></tr>
<tr><td>Ulice:</td><td colspan=2><?echo@$ulice;?></td></tr>
<tr><td>PSÈ a Mìsto:</td><td><?echo@$psc;?></td><td><?echo@$mesto;?></td></tr>
<tr><td>Kontaktní Osoba:</td><td colspan=2><?echo@$osoba;?></td></tr>
<tr><td>Telefon:</td><td colspan=2><?echo@$telefon;?></td></tr>
<tr><td>Fax:</td><td colspan=2><?echo@$fax;?></td></tr>
<tr><td>E-Mail:</td><td colspan=2><?echo@$mail;?></td></tr>
<tr><td>Bankovní Èíslo Úètu:</td><td colspan=2><?echo@$ucet;?></td></tr>
<tr><td>IÈO:</td><td colspan=2><?echo@$ico;?></td></tr>
<tr><td>DIÈ:</td><td colspan=2><?echo@$dic;?></td></tr>
<tr><td>Pøedmìt Podnikání (CZ-NACE):</td><td colspan=2><?echo@$cznace;?></td></tr>
<tr><td>Bankovní Spojení:</td><td colspan=2><?echo@$ucetb."/".@$kodb;?></td></tr>
<tr><td>Èíslo Registrace:</td><td colspan=2><?echo@$cregistrace;?></td></tr>
<tr><td>Odbornost:</td><td colspan=2><?echo@$odbornost;?></td></tr>
<tr><td valign=top>Logo:</td><td colspan=2><center><img src=logo.php><br />
Odkaz Loga: <?if (@$odkaz<>""){echo"<a href=".@$odkaz." target=_blank>".@$odkaz."</a>";} else {?><a href=http://www.kliknetezde.cz target=_blank>http://www.kliknetezde.cz</a><?}?></td></tr>

<?}}?>







</table></center>
</form>

