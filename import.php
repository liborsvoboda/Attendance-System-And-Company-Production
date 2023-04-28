<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];
@$obdobi=@$_POST["obdobi"];

include ("./"."dbconnect.php");

//ukladani
if (@$tlacitko=="Naimportovat Vybraný Soubor"){$name = $_FILES["soubor"]["name"];
@$docasny = @$_FILES['soubor']['tmp_name']; // Umístìní doèasného souboru
@$mime = @$_FILES['soubor']['type']; // MIME typ
// Naèteme obsah doèasného souboru
@$soubor = implode('', file("$docasny"));
@$cenikimp= mysql_escape_string($soubor);

$radky = explode('\r\n', $cenikimp);
@$cykl=1;while (@$radky[@$cykl]<>""):

$casti = explode(";", $radky[@$cykl]);

@$value1 = $casti[0];
@$value2 =$casti[1];
@$value3 = $casti[2];
@$value4 = $casti[3];
@$value5 = $casti[4];
@$value6 = $casti[5];
@$value7 = $casti[6];

@$control=mysql_num_rows(mysql_query("select id from import_system where osobni_cislo='$value1' and obdobi='$value2' order by id"));
if (@$control==""){
mysql_query ("INSERT INTO import_system (osobni_cislo,obdobi,stara_dovolena,celkova_dovolena,rocni_prescas,konecny_stav,vlozil,datumvkladu,plan_harmonogram) VALUES('$value1','$value2','$value3','$value4','$value5','$value6','system', '$dnes','$value7')") or Die(MySQL_Error());}
else {mysql_query ("update import_system  set stara_dovolena = '$value3',celkova_dovolena = '$value4',rocni_prescas = '$value5',konecny_stav = '$value6',datumvkladu='$dnes',vlozil='$loginname',plan_harmonogram='$value7' where osobni_cislo='$value1' and obdobi='$value2' ")or Die(MySQL_Error());}

@$cykl++;
endwhile;
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Import Souboru <font color="#E60F2F"><?echo @$name;?></font> Probìhl Úspìšnì</b></center></td></tr></table></table><?@$tlacitko="";@$menu="";}

// konec ukladani
?>


<form action="hlavicka.php?akce=<?echo base64_encode('import');?>" method=post enctype="multipart/form-data">

<h2><p align="center">Správa Importù :
<? if (StrPos (" " . $_SESSION["prava"], "I") or StrPos (" " . $_SESSION["prava"], "i")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "I")){?>
   <?if (@$menu<>"Importovat Èasové Konto"){?><option>Importovat Èasové Konto</option><?}?>

<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "I") or StrPos (" " . $_SESSION["prava"], "i")){?>
   <?if (@$menu<>"Pøehled Importù"){?><option>Pøehled Importù</option><?}?>
   <?if (@$menu<>"Tisk Importù"){?><option>Tisk Importù</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "I") and (!StrPos (" " . $_SESSION["prava"], "i")) ){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "I")){     // zapis

if (@$menu=="Importovat Èasové Konto"){?>
<tr><td colspan=8 bgcolor="#C0FFC0"><center><b><?echo@$menu?></b></center></td></tr>
<tr><td colspan=4>CSV Soubor k Importu:</td><td colspan=8><input type="file" name=soubor value="" size="40">
<tr><td colspan=8><center><BR><input type="submit" name=tlacitko value="Naimportovat Vybraný Soubor"></center><BR></td></tr>
<tr bgcolor=#C4C0FE><td colspan=8 align=center>Formát Souboru (7 Sloupcù)</td></tr>
<tr bgcolor=#C4C0FE><td colspan=2>Osobní Èíslo</td><td>Období</td><td>Èerpat z MR</td><td>Zùstatek v BR</td><td>Odpracovnáno</td><td>Koneèný Stav</td><td>Plánovaný Harmonogram</td></tr>

<?}

 // konec zapisu}



if (StrPos (" " . $_SESSION["prava"], "i") or StrPos (" " . $_SESSION["prava"], "I")){     // cteni

if (@$menu=="Tisk Importù"){?>
<script type="text/javascript">
window.open('TiskImportu.php?obdobi=<?echo base64_encode($obdobi);?>')
</script>
<?}

if (@$menu=="Pøehled Importù"){?>

<tr bgcolor="#C0FFC0"><td colspan=6><center><b><?echo@$menu?></b></center></td><td align=right>Období:</td><td>
<select size="1" name="obdobi" onchange=submit(this) style=width:100%>
<?if (@$obdobi<>"") {echo"<option>".@$obdobi."</option>";} else {echo"<option></option>";}
$data1= mysql_query("select obdobi from import_system group by obdobi order by obdobi,id");
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi) {echo"<option>".mysql_result($data1,@$cykl,0)."</option>";}
@$cykl++;endwhile;?>
</select>

</td></tr>
<tr bgcolor=#C4C0FE><td>Poøadí</td><td>Osobní Èíslo</td><td>Období</td><td>Èerpat z MR</td><td>Zùstatek v BR</td><td>Odpracovnáno</td><td>Koneèný Stav</td><td>Plánovaný Harmonogram</td></tr>

<style type="text/css">
tr.menuon  {background-color:#F1BEED;}
tr.menuoff {background-color:#EDB745;}
</style>

<? if (@$obdobi<>"") {$data1= mysql_query("select * from import_system where obdobi='$obdobi' order by obdobi,osobni_cislo,id");
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
?>
<tr onmouseover="className='menuon';" onmouseout="className='menuoff';" style=cursor:pointer; >
<td><?echo @$cykl+1;?></td>
<td><?echo @mysql_result($data1,@$cykl,1);?></td>
<td><?echo @mysql_result($data1,@$cykl,2);?></td>
<td align=right><?echo @mysql_result($data1,@$cykl,3);?> Dní</td>
<td align=right><?echo @mysql_result($data1,@$cykl,4);?> Dní</td>
<td align=right><?echo @mysql_result($data1,@$cykl,5);?> Hod.</td>
<td align=right><?echo @mysql_result($data1,@$cykl,6);?> Hod.</td>
<td align=right><?echo @mysql_result($data1,@$cykl,9);?> Hod.</td>
</tr>
<?

@$cykl++;endwhile;}

}

}
?>






</table></center>
</form>
