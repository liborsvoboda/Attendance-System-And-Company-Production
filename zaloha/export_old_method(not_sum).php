<?
//  menu

@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];
@$menuold=@$_POST["menuold"];
@$save=@$_GET["save"];
if (base64_decode(@$_GET["obdobi"])<>"") {@$obdobi=base64_decode(@$_GET["obdobi"]);} else {@$obdobi=@$_POST["obdobi"];}
@$selekt=@$_POST["selekt"];

if (@$menu<>@$menuold and @$menuold<>"") {@$obdobi="";}

$soubor="Export/Helios-Dochazka$obdobi.txt";
$soubor1="Export/Helios-Premie$obdobi.csv";


include ("./"."dbconnect.php");


// ukladani

if (@$tlacitko=="Uzavøít Mìsíc pro Export"){
mysql_query ("update zpracovana_dochazka set export = 'ANO',datumzmeny='$dnes',zmenil='$loginname' where obdobi='".mysql_real_escape_string($obdobi)."'")or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uzavøení Záznamù Mìsíce <?echo @$obdobi;?> Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";}

if (@$tlacitko=="Otevøít Mìsíc k Opravì"){
mysql_query ("update zpracovana_dochazka set export = 'NE',datumzmeny='$dnes',zmenil='$loginname' where obdobi='".mysql_real_escape_string($obdobi)."'")or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Otevøení Záznamù Mìsíce <?echo @$obdobi;?> Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";}













if (@$save==ok) {//nacteni svatku
$obdobi1=explode("-",$obdobi);@$mesic="-".$obdobi1[1]."-";$obdobidate=$obdobi."31";
$sdny1=mysql_query("select datum from svatky where ((datum like '%$mesic%' and typ='Trvalý' and stav='Aktivní') or (datum like '$obdobi%' and typ='Jedineèný' and stav='Aktivní') or (datum like '%$mesic%' and datumdo<='$obdobidate' and typ='Trvalý' and stav='Neaktivní')) order by datum");
@$load=0;$sden="/";while(@$load<mysql_num_rows($sdny1)): @$casti=explode ("-", mysql_result($sdny1,$load,0));$sden=$sden.(int)@$casti[2]."/";@$load++;endwhile;
//kone nacteni svatku

//nacteni slozek sestavy 2
$slozky2a=mysql_query("select reduction from external_system where sestava='2' order by id");
@$load=0;$slozky2="";while(@$load<mysql_num_rows($slozky2a)): $slozky2.=mysql_result($slozky2a,$load,0)."/";@$load++;endwhile;
//kone nacteni slozek sestavy 2


$sestava1="STRED;OSC1;MZSL;OD;DO;HODINY;OD1;DO1;\r\n";
$sestava2="OSC1;SL_MZDY;STRED;HOD;KC;\r\n";

@$zamestnanci = mysql_query("select * from zamestnanci where export='ANO' and jen_pruchod='NE' and datumin<='$obdobi-31' and (datumout>='$obdobi-31' or datumout='0000-00-00' or datumout like '$obdobi%') order by stredisko,osobni_cislo,prijmeni,jmeno,id ASC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($zamestnanci)):

//nacist informace k pracovniku prac dobu,dovolenou...  mozna co kdyz se v prubehu mesice zmeni

//nacteni stare dovolene
@$praccas=explode (":",mysql_result($zamestnanci,@$cykl,20));@$praccas100=round ((((@$praccas[0]*60)+@$praccas[1])/60),3);
$staradovolena=mysql_result(mysql_query("select stara_dovolena from import_system where obdobi='".mysql_real_escape_string($obdobi)."' and osobni_cislo='".mysql_result($zamestnanci,@$cykl,1)."' "),0,0)*@$praccas100;
//konec nacteni stare dovolene

$dny=1;while( @$dny< date("t", strtotime($obdobi."-01"))+1 ):
if (@$dny<10){@$selectdatum=$obdobi."-0".$dny;} else {@$selectdatum=$obdobi."-".$dny;}$cdne= date("w", strtotime($selectdatum));$report=explode("-",$selectdatum);$reportdate=$report[2]."/".$report[1]."/".$report[0];

@$data1 = mysql_query("select * from zpracovana_dochazka where osobni_cislo='".mysql_result($zamestnanci,@$cykl,1)."'and datum='$selectdatum' order by id_ukonu,stredisko,id") or Die(MySQL_Error());

//zpracovani zaznamù dne
$dzaznamy=0;while (@$dzaznamy<mysql_num_rows($data1)):

@$fullstr=mysql_result(mysql_query("select plnykod from stredisko where kod='".mysql_result($data1,@$dzaznamy,7)."'"),0,0);

$ukony1=mysql_query("select * from ukony where id='".mysql_result($data1,@$dzaznamy,3)."' ");
@$pukonu=0;while (mysql_result($ukony1,0,(@$pukonu+11))<>""):

$extsys1=mysql_query("select * from external_system where sysnumber='".mysql_result($ukony1,0,(@$pukonu+11))."' ");

//sestava 1
if (mysql_result($extsys1,0,7)==1 and mysql_result($extsys1,0,6)=="ANO") {$rozdel=explode (":",mysql_result($data1,@$dzaznamy,2));$celkemmin=round((((@$rozdel[0]*60)+@$rozdel[1])/60),3);

// systemove vyjimky
if (StrPos (" " . mysql_result($extsys1,0,8), "SYSTEM SV") and StrPos (" " . $sden, "/".$dny."/")) {$zapsat=mysql_result(mysql_query("select reduction from external_system where vypocet='SYSTEM SV'"),0,0);$sestava1.="\"".$fullstr."\";\"".mysql_result($zamestnanci,@$cykl,1)."\";\"".$zapsat."\";".$dny.";".$dny.";".$celkemmin.";$reportdate;$reportdate;\r\n";}
if (StrPos (" " . mysql_result($extsys1,0,8), "SYSTEM SO/NE") and ($cdne==0 or $cdne==6)) {$zapsat=mysql_result(mysql_query("select reduction from external_system where vypocet='SYSTEM SO/NE'"),0,0);$sestava1.="\"".$fullstr."\";\"".mysql_result($zamestnanci,@$cykl,1)."\";\"".$zapsat."\";".$dny.";".$dny.";".$celkemmin.";$reportdate;$reportdate;\r\n";}

if (StrPos (" " . mysql_result($extsys1,0,8), "SYSTEM DOV")) {$zapsano=0;	if ($staradovolena>=$celkemmin and $zapsano==0) {$zapsat=mysql_result(mysql_query("select reduction from external_system where vypocet='SYSTEM DOV 1'"),0,0);$sestava1.="\"".$fullstr."\";\"".mysql_result($zamestnanci,@$cykl,1)."\";\"".$zapsat."\";".$dny.";".$dny.";".$celkemmin.";$reportdate;$reportdate;\r\n";$staradovolena=$staradovolena-$celkemmin;$zapsano=1;}
	if ($staradovolena==0 and $zapsano==0) {$sestava1.="\"".$fullstr."\";\"".mysql_result($zamestnanci,@$cykl,1)."\";\"".mysql_result($extsys1,0,3)."\";".$dny.";".$dny.";".$celkemmin.";$reportdate;$reportdate;\r\n";$zapsano=1;}
	if ($staradovolena>0 and $staradovolena<$celkemmin and $zapsano==0) {$zapsat=mysql_result(mysql_query("select reduction from external_system where vypocet='SYSTEM DOV 1'"),0,0);	$sestava1.="\"".$fullstr."\";\"".mysql_result($zamestnanci,@$cykl,1)."\";\"".$zapsat."\";".$dny.";".$dny.";".$staradovolena.";$reportdate;$reportdate;\r\n";$celkemmin=$celkemmin-$staradovolena;@$staradovolena=0;	$sestava1.="\"".$fullstr."\";\"".mysql_result($zamestnanci,@$cykl,1)."\";\"".mysql_result($extsys1,0,3)."\";".$dny.";".$dny.";".$celkemmin.";$reportdate;$reportdate;\r\n";$zapsano=1;}
}

if (StrPos (" " . mysql_result($extsys1,0,8), "MANUAL")) {$sestava1.=$fullstr.";".mysql_result($zamestnanci,@$cykl,1).";".mysql_result($extsys1,0,3).";".$dny.";".$dny.";".$celkemmin.";$reportdate;$reportdate;\r\n";}

} //konec sestavy 1


//sestava 2
if (mysql_result($extsys1,0,7)==2 and mysql_result($extsys1,0,6)=="ANO") {$rozdel=explode (":",mysql_result($data1,@$dzaznamy,2));$celkemmin=(@$rozdel[0]*60)+@$rozdel[1];$zaznam[mysql_result($extsys1,0,3)]=$zaznam[mysql_result($extsys1,0,3)]+$celkemmin;}
// konec sestavy 2

@$pukonu++;endwhile;

@$dzaznamy++;endwhile;
//konec zpracovani zaznamu dne


//cyklus za kazdy den vybraneho pracovnika
@$dny++;endwhile;




// vytvoreni zaznamu sestavy2
$rozdel=explode ("/",$slozky2);
if ($zaznam[$rozdel[0]]>$zaznam[$rozdel[1]]) {$sestava2.=mysql_result($zamestnanci,@$cykl,1).";".$rozdel[0].";".mysql_result($zamestnanci,@$cykl,17).";".round((($zaznam[$rozdel[0]]-$zaznam[$rozdel[1]])/60),2).";0;\r\n";$zaznam[$rozdel[0]]="";$zaznam[$rozdel[1]]="";}
if ($zaznam[$rozdel[0]]<$zaznam[$rozdel[1]]) {$sestava2.=mysql_result($zamestnanci,@$cykl,1).";".$rozdel[1].";".mysql_result($zamestnanci,@$cykl,17).";".round((($zaznam[$rozdel[1]]-$zaznam[$rozdel[0]])/60),2).";0;\r\n";$zaznam[$rozdel[0]]="";$zaznam[$rozdel[1]]="";}
//konec vytvoreni zaznamu sestavy2




// uklozit zaznam pracovnika premie

// konec cyklu pracovnika
@$cykl++;endwhile;


$f=fopen($soubor,"w");fwrite($f,"$sestava1");fclose($f);
$f=fopen($soubor1,"w");fwrite($f,"$sestava2");fclose($f);?>
<script type="text/javascript">
alert("Uložení Exportù za Období <?echo@$obdobi;?> Probìhlo Úspìšnì");
</script>
<?@$obdobi=="";}


// konec ukladani














?>

<style type="text/css">
tr.menuon  {background-color:#F1BEED;}
tr.menuoff {background-color:#EDB745;}
</style>

<form action="hlavicka.php?akce=<?echo base64_encode('export');?>" method=post enctype="multipart/form-data">
<input name="menuold" type="hidden" value="<?echo@$menu;?>">

<h2><p align="center">Správa Exportù :
<? if (StrPos (" " . $_SESSION["prava"], "E") or StrPos (" " . $_SESSION["prava"], "e")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "E")){?>
   <?if (@$menu<>"Blokovat Období (Pro Opravu)"){?><option>Blokovat Období (Pro Opravu)</option><?}?>
   <?if (@$menu<>"Kontrola Dat pro Export"){?><option>Kontrola Dat pro Export</option><?}?>
   <?if (@$menu<>"Exportovat Docházku"){?><option>Exportovat Docházku</option><?}?>

<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "E") or StrPos (" " . $_SESSION["prava"], "e")){?>
   <?if (@$menu<>"Pøehled Existujících Exportù"){?><option>Pøehled Existujících Exportù</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "E") and (!StrPos (" " . $_SESSION["prava"], "e")) ){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "E")){     // zapis

if (@$menu=="Kontrola Dat pro Export"){@$cykle=1;?>
<tr bgcolor="#B4ADFC"><td colspan=7><center><b><?echo@$menu;?></b></center></td>
<td align=right>Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$obdobi<>""){?><option value="<?echo @$obdobi;?>"><?$obdobi1=explode("-",$obdobi);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
include ("./"."dbconnect.php");@$celek="Je";@$export="Je";
@$data1 = mysql_query("select obdobi from zpracovana_dochazka where export='NE' group by obdobi order by obdobi ASC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select></td></tr>
<tr bgcolor="#C0FFC0" align=center><td> Poøadí </td><td> Støedisko </td><td> Osobní Èíslo </td><td> Pøíjmení Jméno </td><td>Stav (N<input name="selekt" type="checkbox" onclick=submit(this) <?if (@$selekt=="on") {echo"checked";}?> >)</td><td>Poèet Záznamù</td><td>Plán.Harm. (+ Sv.)</td><td>Kontrola Def.</td></tr>
<? if (@$obdobi<>""){
@$zamestnanci = mysql_query("select * from zamestnanci where export='ANO' and jen_pruchod='NE' and datumin<='$obdobi-31' and (datumout>='$obdobi-31' or datumout='0000-00-00' or datumout like '$obdobi%') order by stredisko,prijmeni ASC,jmeno ASC,id ASC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($zamestnanci)):
@$data1 = mysql_query("select potvrzeno,export from zpracovana_dochazka where obdobi='$obdobi' and osobni_cislo='".mysql_result($zamestnanci,@$cykl,1)."' order by id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cyklus=0;$stav="V Poøádku";$barva="#6CE866";while (@$cyklus<mysql_num_rows($data1)):
if (mysql_result($data1,@$cyklus,1)=="NE")  {$export="Neni";$stav="Pøipraveno k uzavøení pro Export";} else {$stav="Uzavøeno pro Export";}
if (mysql_result($data1,@$cyklus,0)=="NE")  {$celek="Neni";$stav="Není Uzavøen";$barva="#EC6265";}
@$cyklus++;endwhile;
if (@$pocet=="") {$celek="Neni";$stav="Chybí Definováno";$barva="#EC6265";}

// kontrola harmonogramu
@$planharm=mysql_result(mysql_query("select plan_harmonogram from import_system where obdobi='".mysql_real_escape_string($obdobi)."' and osobni_cislo='".mysql_real_escape_string(mysql_result($zamestnanci,@$cykl,1))."' order by obdobi ASC"),0,0);
@$pracdoba = explode(":", @mysql_result($zamestnanci,@$cykl,20));@$pracdeninmin=(@$pracdoba[0]*60)+@$pracdoba[1];

include("./"."kontrola.php");@$kontrola=@$sumarizace1[0];
if (@$planharm-(@$kontrola+@$prsvatky)<>0 and @$planharm-@$kontrola>0 ) {@$barva="#EC6265";$stav="Data Nesouhlasí s Harmonogramem";}
if (@$kontrola-(@$planharm-@$prsvatky)<>0 and @$kontrola-@$planharm>0) {@$barva="#F3E26D";$stav="Dat je Více než Harmonogram";}
if (@$planharm=="") {@$barva="#EC6265";$stav="Uživatel nemá Naimportovaný Harmonogram";}
//konec kontroly harmonogramu

//stredisko k poslednimu v mesici
$casstredisko=mysql_result(mysql_query("select stredisko from zam_strediska where osobni_cislo='".securesql(mysql_result($zamestnanci,@$cykl,1))."' and datumod <='".securesql($obdobi)."-31' and (datumdo='0000-00-00' or datumdo >= '".securesql($obdobi)."-28') "),0,0);

if (@$selekt=="" or (@$selekt=="on" and (@$barva=="#EC6265" or @$barva=="#F3E26D"))) {echo "<tr bgcolor=".$barva."><td>".@$cykle++."</td><td>".$casstredisko."</td><td>".mysql_result($zamestnanci,@$cykl,1)."</td><td>".mysql_result($zamestnanci,@$cykl,2)." ".mysql_result($zamestnanci,@$cykl,4)." ".mysql_result($zamestnanci,@$cykl,3)."</td>";
echo "<td>".$stav."</td><td align=right>".@$pocet."</td><td align=right>".(mysql_result(mysql_query("select plan_harmonogram from import_system where obdobi='".mysql_real_escape_string($obdobi)."' and osobni_cislo='".mysql_real_escape_string(mysql_result($zamestnanci,@$cykl,1))."' order by obdobi ASC"),0,0)-@$prsvatky)." + ".@$prsvatky." hod.</td>
<td align=right>".@$kontrola." hod.</td></tr>";}

@$cykl++;endwhile;
if (@$celek=="Je" and @$export=="Neni") {echo"<tr><td colspan=8 align=center><input name=tlacitko type=submit value='Uzavøít Mìsíc pro Export'></td></tr>";}
if (@$celek=="Je" and @$export=="Je") {echo"<tr><td colspan=8 align=center><input name=tlacitko type=submit value='Otevøít Mìsíc k Opravì'></td></tr>";}
}?>
<?}










if (@$menu=="Exportovat Docházku"){?>
<tr bgcolor="#B4ADFC"><td colspan=4><center><b><?echo@$menu;?></b></center></td>
<td align=right>Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$obdobi<>""){?><option value="<?echo @$obdobi;?>"><?$obdobi1=explode("-",$obdobi);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
include ("./"."dbconnect.php");@$celek="Je";@$export="Je";
@$data1 = mysql_query("select obdobi from zpracovana_dochazka where potvrzeno='ANO' and export='ANO' group by obdobi order by obdobi ASC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<?if (@$obdobi<>"") {
IF(File_Exists($soubor))   {?>
<script type="text/javascript">
if (confirm('Chcete Pøepsat Exportované Soubory za Období: <?echo $obdobi;?> ?')) {window.location.href('hlavicka.php?akce=<?echo base64_encode('export');?>&obdobi=<?echo base64_encode($obdobi);?>&save=ok');}
else {alert("Uložení Exportù Bylo Zrušeno");}</script>
<?} else {?><script type="text/javascript">
if (confirm('Chcete Exporty za Období <?echo@$obdobi;?> Skuteènì Uložit?')) {window.location.href('hlavicka.php?akce=<?echo base64_encode('export');?>&obdobi=<?echo base64_encode($obdobi);?>&save=ok');}
else {alert("Uložení Exportù Bylo Zrušeno");}
</script><?}?>

<?}

}




if (@$menu=="Blokovat Období (Pro Opravu)"){if (@$tlacitko=="Od/Blokovat") {if (mysql_num_rows(mysql_query("select obdobi from blokovani where obdobi='".mysql_real_escape_string($_POST["obdobi"])."' "))<>"") {mysql_query ("delete from blokovani where obdobi = '".mysql_real_escape_string($_POST["obdobi"])."' ")or Die(MySQL_Error());}
else {mysql_query ("INSERT INTO blokovani (obdobi,vlozil,datumvkladu) VALUES('".mysql_real_escape_string($_POST["obdobi"])."','$loginname','$dnes')") or Die(MySQL_Error());}
@$tlacitko="";}
	?>
<tr bgcolor="#B4ADFC"><td colspan=4><center><b><?echo@$menu;?></b></center></td></tr>
<td colspan=2 align=right>Vyber Období k Blokaci:</td><td><select size="1" name="obdobi">

<?if (@$obdobi<>"") {if (mysql_num_rows(mysql_query("select obdobi from blokovani where obdobi='".mysql_real_escape_string($obdobi)."' "))<>"") {@$barva="#FF3E4D";} else {@$barva="#C1F7C5";}
echo"<option style=background-color:".$barva.">".@$obdobi."</option>";}
@$data1 = mysql_query("select obdobi from zpracovana_dochazka where obdobi<>'".mysql_real_escape_string($obdobi)."' group by obdobi order by obdobi ASC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_num_rows(mysql_query("select obdobi from blokovani where obdobi='".mysql_real_escape_string(mysql_result($data1,@$cykl,0))."' "))<>"") {@$barva="#FF3E4D";} else {@$barva="#C1F7C5";}
echo"<option style=background-color:".$barva.">".mysql_result($data1,@$cykl,0)."</option>";
@$cykl++;endwhile;?></select> <input type="submit" name=tlacitko value="Od/Blokovat">
<?}






























 // konec zapisu}



if (StrPos (" " . $_SESSION["prava"], "e") or StrPos (" " . $_SESSION["prava"], "E")){     // cteni



if (@$menu=="Pøehled Existujících Exportù"){?>
<tr bgcolor="#B4ADFC"><td colspan=3><center><b><?echo@$menu;?></b></center></td>
<td align=right>Rok: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$obdobi<>""){?><option value="<?echo @$obdobi;?>"><?$obdobi1=explode("-",$obdobi);echo $obdobi1[0];?></option><?}?><option></option><?
include ("./"."dbconnect.php");@$celek="Je";@$export="Je";
@$data1 = mysql_query("select obdobi from zpracovana_dochazka where potvrzeno='ANO' and export='ANO' group by obdobi order by obdobi ASC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$obdobi and substr(mysql_result($data1,@$cykl,0),0,4)<>substr(mysql_result($data1,@$cykl-1,0),0,4)){?><option value="<?echo substr(mysql_result($data1,@$cykl,0),0,4);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<?$slozka = dir("Export");@$cykl=0;
while($soubory=$slozka->read()) {if (@$obdobi=="") {@$obdobi=".";}if ($soubory<>"." and $soubory<>".." and StrPos (" " . $soubory, $obdobi)) {
@$cykl++;
echo "<tr><td colspan=3> ".$cykl." </td><td align=right width=200> <a href=\"Export/$soubory\" target=_blank>".$soubory."</a> </td></tr>";}}
$slozka->close();
}



}
?>






</table></center>
</form>
