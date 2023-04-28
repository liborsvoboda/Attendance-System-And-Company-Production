<?
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];


//  save
$soubor="ExportU/Normohodiny".@$_REQUEST["obdobi"].".txt";
$soubor1="ExportU/OstatniCasy".@$_REQUEST["obdobi"].".txt";

if (@$_REQUEST["obdobi"]<>"" and @$_GET["save"]=="ok"){$menu="Pøehled Exportù Úkolové Práce";
$export1.="os. èíslo;pøíjmení a jméno;obsazení;\"støedisko\";plánovaný harmonogram forem;plánovaný harmonogram hodin;práce u stroje;poruchy a prostoje;pøevod na jinou práci na støedisku;pøevod na jiné støedisko;celkem evidovaný èas;% výkonu;SUM Normo hodin;Kod MS;\r\n";
$export2.="os. èíslo;pøíjmení a jméno;obsazení;støedisko;plánovaný harmonogram forem;plánovaný harmonogram hodin;práce u stroje;poruchy a prostoje;pøevod na jinou práci na støedisku;pøevod na jiné støedisko;\r\n";


$dotaz=strediska();
$data1=mysql_query("select * from zamestnanci where ukol='ANO' and ($dotaz) order by stredisko,osobni_cislo,prijmeni,jmeno,titul") or Die(MySQL_Error());


@$data2=mysql_query("select * from ukoly_hlavicka where datum like '".securesql(@$_REQUEST["obdobi"])."%' "); // data z DB
@$data3=mysql_query("select * from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' group by osobni_cislo order by osobni_cislo"); // data z DB
@$data4=mysql_query("select * from ukoly_export where obdobi='".securesql(@$_REQUEST["obdobi"])."' ");

$celkforem=mysql_result(mysql_query("select SUM(vyrobeno_forem) from ukoly_hlavicka where datum like '".securesql(@$_REQUEST["obdobi"])."%' "),0,0);
$goodform=mysql_result(mysql_query("select SUM(dobrych_forem) from ukoly_hlavicka where datum like '".securesql(@$_REQUEST["obdobi"])."%' "),0,0);
$hodprod=mysql_result(mysql_query("select SUM(doba_vyr) from ukoly_hlavicka where datum like '".securesql(@$_REQUEST["obdobi"])."%' "),0,0);
$stop=mysql_result(mysql_query("select SUM(poruchy) from ukoly_hlavicka where datum like '".securesql(@$_REQUEST["obdobi"])."%' "),0,0);
$hodwatt=round(($goodform/($hodprod+$stop)),2);
$daywatt=round(($hodwatt/mysql_result(@$data4,0,2)*100),2);




@$cykl=0;while (@$cykl<mysql_num_rows(@$data1)):

$export1.=mysql_result(@$data1,@$cykl,1).";";
$export1.=mysql_result(@$data1,@$cykl,4)." ".mysql_result(@$data1,@$cykl,3).";";
$export1.=mysql_result(@$data1,@$cykl,35).";";
$export1.="\"0".mysql_result(@$data1,@$cykl,17)."\";";
if (mysql_result(mysql_query("select SUM(value1) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export1.=mysql_result(mysql_query("select SUM(value1) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export1.=";";}
if (mysql_result(mysql_query("select SUM(value2) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export1.=mysql_result(mysql_query("select SUM(value2) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export1.=";";}
if (mysql_result(mysql_query("select SUM(value3) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export1.=mysql_result(mysql_query("select SUM(value3) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export1.=";";}
if (mysql_result(mysql_query("select SUM(value4) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export1.=mysql_result(mysql_query("select SUM(value4) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export1.=";";}
if (mysql_result(mysql_query("select SUM(value5) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export1.=mysql_result(mysql_query("select SUM(value5) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export1.=";";}
if (mysql_result(mysql_query("select SUM(value6) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export1.=mysql_result(mysql_query("select SUM(value6) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export1.=";";}
if (mysql_result(mysql_query("select SUM(value7) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export1.=mysql_result(mysql_query("select SUM(value7) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export1.=";";}
$export1.=$daywatt."%;";
$export1.=round((mysql_result(mysql_query("select SUM(value3) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)*$hodwatt/mysql_result(@$data4,0,2)),2).";";
$export1.=mysql_result(@$data1,@$cykl,36).";\r\n";

$export2.=mysql_result(@$data1,@$cykl,1).";";
$export2.=mysql_result(@$data1,@$cykl,4)." ".mysql_result(@$data1,@$cykl,3).";";
$export2.=mysql_result(@$data1,@$cykl,35).";";
$export2.="0".mysql_result(@$data1,@$cykl,17).";";
if (mysql_result(mysql_query("select SUM(value1) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export2.=mysql_result(mysql_query("select SUM(value1) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export2.=";";}
if (mysql_result(mysql_query("select SUM(value2) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export2.=mysql_result(mysql_query("select SUM(value2) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export2.=";";}
if (mysql_result(mysql_query("select SUM(value3) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export2.=mysql_result(mysql_query("select SUM(value3) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export2.=";";}
if (mysql_result(mysql_query("select SUM(value4) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export2.=mysql_result(mysql_query("select SUM(value4) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export2.=";";}
if (mysql_result(mysql_query("select SUM(value5) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export2.=mysql_result(mysql_query("select SUM(value5) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";";}else{$export2.=";";}
if (mysql_result(mysql_query("select SUM(value6) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0)<>0) {$export2.=mysql_result(mysql_query("select SUM(value6) from ukoly_data where datum like '".securesql(@$_REQUEST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."'"),0,0).";\r\n";}else{$export2.=";\r\n";}
@$cykl++;endwhile;
$f=fopen($soubor,"w");fwrite($f,"$export1");fclose($f);
$f=fopen($soubor1,"w");fwrite($f,"$export2");fclose($f);?>
<script>
alert("Export Úkolù za Obdobi: <?echo @$_GET["obdobi"];?> byl úspìšnì uložen");
</script>
<?}





if (@$menu=="Zadání/Úprava Úkolové Práce" and @$tlacitko==" Uzamknout pro Export "){mysql_query("insert into ukoly_export (obdobi,100procent,vlozil,datumvkladu)VALUES('".securesql(@$_POST["obdobi"])."','".securesql(@$_POST["100procent"])."','".securesql($loginname)."','".securesql($dnes)."')") or Die(MySQL_Error());
mysql_query("update ukoly_hlavicka set exportovano='ANO' where datum like '".securesql(@$_POST["obdobi"])."%' ") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Data Byla uzamèena pro Export</b></center></td></tr></table><?
}



if (@$menu=="Zadání/Úprava Úkolové Práce" and @$tlacitko==" Uložit "){  // ulozeni hlavickyif (mysql_num_rows(mysql_query("select id from ukoly_hlavicka where datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."'"))==false) {	mysql_query("insert into ukoly_hlavicka (datum,vyrobeno_forem,dobrych_forem,doba_vyr,poruchy,delka_smeny,vlozil,datumvkladu,exportovano )VALUES('".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."','".securesql(@$_POST["celkforem"])."','".securesql(@$_POST["goodform"])."','".securesql(@$_POST["hodprod"])."','".securesql(@$_POST["stop"])."','".securesql(@$_POST["hodsmena"])."','".securesql($loginname)."','".securesql($dnes)."','NE' )") or Die(MySQL_Error());}
	else {mysql_query("update ukoly_hlavicka set vyrobeno_forem='".securesql(@$_POST["celkforem"])."',dobrych_forem='".securesql(@$_POST["goodform"])."',doba_vyr='".securesql(@$_POST["hodprod"])."',poruchy='".securesql(@$_POST["stop"])."',delka_smeny='".securesql(@$_POST["hodsmena"])."',vlozil='".securesql($loginname)."',datumvkladu='".securesql($dnes)."' where  datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' ") or Die(MySQL_Error());}


$dotaz=strediska();  // ulozeni dat
$data1=mysql_query("select * from zamestnanci where ukol='ANO' and ($dotaz) order by stredisko,osobni_cislo,prijmeni,jmeno,titul") or Die(MySQL_Error());
	@$cykl=0;while (@$cykl<mysql_num_rows(@$data1)):
		$osobnic=@$_POST[$cykl."value0"];

if (mysql_num_rows(mysql_query("select id from ukoly_data where datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' and osobni_cislo='".securesql($osobnic)."'"))==false) {
	mysql_query("insert into ukoly_data (osobni_cislo,datum,value1,value2,value3,value4,value5,value6,value7,value8,value9,value10,vlozil,datumvkladu)VALUES('".securesql($osobnic)."','".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."','".securesql(@$_POST[$osobnic."value1"])."','".securesql(@$_POST[$osobnic."value2"])."','".securesql(@$_POST[$osobnic."value3"])."','".securesql(@$_POST[$osobnic."value4"])."','".securesql(@$_POST[$osobnic."value5"])."','".securesql(@$_POST[$osobnic."value6"])."','".securesql(@$_POST[$osobnic."value7"])."','".securesql(@$_POST[$osobnic."value8"])."','".securesql(@$_POST[$osobnic."value9"])."','".securesql(@$_POST[$osobnic."value10"])."','".securesql($loginname)."','".securesql($dnes)."')") or Die(MySQL_Error());}
	else {mysql_query("update ukoly_data set value1='".securesql(@$_POST[$osobnic."value1"])."',value2='".securesql(@$_POST[$osobnic."value2"])."',value3='".securesql(@$_POST[$osobnic."value3"])."',value4='".securesql(@$_POST[$osobnic."value4"])."',value5='".securesql(@$_POST[$osobnic."value5"])."',value6='".securesql(@$_POST[$osobnic."value6"])."',value7='".securesql(@$_POST[$osobnic."value7"])."',value8='".securesql(@$_POST[$osobnic."value8"])."',value9='".securesql(@$_POST[$osobnic."value9"])."',value10='".securesql(@$_POST[$osobnic."value10"])."',vlozil='".securesql($loginname)."',datumvkladu='".securesql($dnes)."' where datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' and osobni_cislo='".securesql($osobnic)."' ") or Die(MySQL_Error());}
@$cykl++;endwhile;
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Hlavièky a Záznamù probìhlo úspìšnì</b></center></td></tr></table><?}
// end save
?>

<form action="hlavicka.php?akce=<?echo base64_encode('Ukoly');?>" method=post>

<h2><p align="center">Výkazy Úkolové Práce:
<? if (StrPos (" " . $_SESSION["prava"], "B") or StrPos (" " . $_SESSION["prava"], "b")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "B")){?>
   <?if (@$menu<>"Zadání/Úprava Úkolové Práce"){?><option>Zadání/Úprava Úkolové Práce</option><?}?>
   <?if (@$menu<>"Export Úkolové Práce"){?><option>Export Úkolové Práce</option><?}}?>

<option disabled></option>
<? if (StrPos (" " . $_SESSION["prava"], "B") or StrPos (" " . $_SESSION["prava"], "b")){?>
   <?if (@$menu<>"Pøehled Úkolové Práce"){?><option>Pøehled Úkolové Práce</option><?}?>
   <?if (@$menu<>"Pøehled Exportù Úkolové Práce"){?><option>Pøehled Exportù Úkolové Práce</option><?}}?>

   </select> </p></h2>

<? if (!StrPos (" " . $_SESSION["prava"], "B") and (!StrPos (" " . $_SESSION["prava"], "b")) ){echo "<center>Nemáte Pøístupová Práva</center>";}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "B")){?>

<?if (@$menu=="Zadání/Úprava Úkolové Práce"){?>
<tr bgcolor="#C0FFC0"><td colspan=7><center><b><?echo@$menu;?></b></center></td>
<td align=right colspan=5 >Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$_POST["obdobi"]<>""){?><option value="<?echo @$_POST['obdobi'];?>"><?$obdobi1=explode("-",@$_POST["obdobi"]);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
@$data1 = mysql_query("select obdobi from zpracovana_dochazka group by obdobi order by obdobi DESC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$_POST["obdobi"]){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select></td>

<td align=right colspan=2>
Den: <?if (@$_POST["obdobi"]) {?>
<select size="1" name="den" onchange=submit(this)>
<?if (@$_POST["den"]){echo"<option>".@$_POST["den"]."</option><option></option>";} else {echo "<option></option>";}

$cykl=0;$existtb="<table width=100% border=2 frame=border rules=all><tr align=center>";
while( @$cykl< date("t", strtotime(@$_POST["obdobi"]."-01"))+1 ):
if (@$cykl<10) {$cyklus="0".$cykl;} else {@$cyklus=$cykl;} $datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));
if (@$cdne==0 or @$cdne==6) {$barva="style=background:#F4CC6F";$was="V";} else {@$barva="";$was="";}
if (@$cykl==0 and @$_POST["den"]<>"SUMA") {echo"<option>SUMA</option>";}
if (@$cykl>0 and @$_POST["den"]<>$cyklus) {echo "<option ".$barva.">".$cyklus."</option>";}
if (mysql_num_rows(mysql_query("select id from ukoly_data where datum='".securesql($datum)."'"))) {$existtb.="<td style=background:#57F273>".$was.$cyklus."</td>";$closedate="yes";} else {$existtb.="<td style=background:red>".$was.$cyklus."</td>";}
@$cykl++;endwhile;$existtb.="</tr></table>";?>

</select><?}?></td></tr>

<?if (@$_POST["obdobi"] and @$_POST["den"] and @$_POST["den"]<>"SUMA") {include "./dbconnectp.php";
$imported1=mysql_query("select cas,odformovano from provozhws where datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' ");

      @$goodpcs1 = mysql_query("select vykaz_prace.pocet,planvyroby.kod from vykaz_prace left outer join planvyroby ON vykaz_prace.id_objednavky = planvyroby.id where vykaz_prace.datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' order by vykaz_prace.id");
      @$cykl=0; @$goodform =0;while (@$cykl<mysql_num_rows($goodpcs1)):
      $goodform =$goodform +  (mysql_result($goodpcs1,@$cykl,0)* mysql_result(mysql_query("select pocet from postupy where kod='".mysql_result($goodpcs1,@$cykl,1)."' and material='Forma' order by id"),0,0));
      @$cykl++;endwhile;

mysql_close();include "./dbconnect.php";
@$data2=mysql_query("select * from ukoly_hlavicka where datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' "); // data z DB
@$data3=mysql_query("select * from ukoly_data where datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' "); // data z DB
?><script type="text/javascript">
function load(){if (document.getElementById('celkforem').value=='') {if ('<?echo "a".mysql_result(@$data2,0,2);?>'=='a') {document.getElementById('celkforem').value="<?echo mysql_result($imported1,0,1);?>";} else {document.getElementById('celkforem').value="<?echo mysql_result(@$data2,0,2);?>";}}
if (document.getElementById('hodsmena').value=='') {if ('<?echo "a".mysql_result(@$data2,0,6);?>'=='a') {document.getElementById('hodsmena').value="<?echo mysql_result($imported1,0,0);?>";} else {document.getElementById('hodsmena').value="<?echo mysql_result(@$data2,0,6);?>";}}
if (document.getElementById('goodform').value=='') {if ('<?echo "a".mysql_result(@$data2,0,3);?>'=='a') {document.getElementById('goodform').value="<?echo ceil($goodform);?>";} else {document.getElementById('goodform').value="<?echo mysql_result(@$data2,0,3);?>";}}


var promena=Math.ceil(document.getElementById('goodform').value)/document.getElementById('100procent').value;promena=document.getElementById('hodsmena').value-promena;

if (document.getElementById('stop').value=='') {if ('<?echo "a".mysql_result(@$data2,0,5);?>'=='a') {document.getElementById('stop').value=Math.round(promena*100)/100;} else {document.getElementById('stop').value="<?echo mysql_result(@$data2,0,5);?>";}}
if (document.getElementById('hodprod').value=='') {if ('<?echo "a".mysql_result(@$data2,0,4);?>'=='a') {document.getElementById('hodprod').value=document.getElementById('hodsmena').value-Math.round(promena*100)/100;} else {document.getElementById('hodprod').value="<?echo mysql_result(@$data2,0,4);?>";}}

document.getElementById('hodwatt').value=Math.round((document.getElementById('goodform').value/document.getElementById('hodsmena').value)*100000)/100000;
document.getElementById('daywatt').value=Math.round((document.getElementById('hodwatt').value/document.getElementById('100procent').value)*10000)/100 +'%';
document.getElementById('hodwatte').value=Math.round((document.getElementById('goodform').value/document.getElementById('hodprod').value)*100)/100;

if ('<?echo "a".mysql_result(@$data3,0,1);?>'!='a') {<?$dload=0;while(@$dload<mysql_num_rows(@$data3)):?>document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value1').value='<?echo mysql_result(@$data3,$dload,3);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value2').value='<?echo mysql_result(@$data3,$dload,4);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value3').value='<?echo mysql_result(@$data3,$dload,5);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value4').value='<?echo mysql_result(@$data3,$dload,6);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value5').value='<?echo mysql_result(@$data3,$dload,7);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value6').value='<?echo mysql_result(@$data3,$dload,8);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value7').value='<?echo mysql_result(@$data3,$dload,9);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value8').value='<?echo mysql_result(@$data3,$dload,10)."%";?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value9').value='<?echo mysql_result(@$data3,$dload,11);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value10').value='<?echo mysql_result(@$data3,$dload,12);?>';
<?@$dload++;endwhile;?>}

}
</script>

<tr>
<td>Vyrobeno forem:</td><td><input id=celkforem name="celkforem" type="text" value="" style=width:100%;text-align:center;background:#FAA3A9;></td>
<td>100% forem / hod.:</td><td><input id="100procent" name="100procent" type="text" value="50" style=width:100%;text-align:center;background:#FAA3A9;></td>
<td colspan=10 align=right><input type="button" name=tlacitko value="Naèíst / Spoèítat Hlavièku" onclick=load();></td>
</tr>

<tr>
<td>Dobrých Forem:</td><td><input id=goodform name="goodform" type="text" value="" style=width:100%;text-align:center;background:#FAA3A9;></td>
<td>Výkon za Hodinu:</td><td><input id="hodwatt" name="hodwatt" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
</tr>

<tr>
<td>Doba Výroby:</td><td><input id=hodprod name="hodprod" type="text" value="" style=width:100%;text-align:center;background:#FAA3A9;></td>
<td>plnìní za Smìnu:</td><td><input id=daywatt name="daywatt" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
</tr>

<tr>
<td>Poruchy:</td><td><input id=stop name="stop" type="text" value="" style=width:100%;text-align:center;background:#FAA3A9;></td>
<td>výkon za hodinu (efektivnì):</td><td><input id=hodwatte name="hodwatte" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
<td colspan=2></td>
<td colspan=4 bgcolor="#C0FFC0" align=center>souèet musí souhlasit s celk. evid. èasem</td>
<td colspan=2></td>
<td bgcolor="#C0FFC0" align=center>úkol.mzda</td>
</tr>

<tr>
<td>Období:</td><td><input type="text" value="<?echo $obdobi1[1].".".$obdobi1[0];?>" style=width:100%;text-align:center; disabled></td>
<td >délka smìny [hod]:</td><td><input id=hodsmena name="hodsmena" type="text" value="" style=width:100%;text-align:center;background:#FAA3A9; ></td>
<td colspan=2></td>
<td bgcolor="#C0FFC0" align=center></td>
<td bgcolor="#C0FFC0" align=center>za tarif</td>
<td bgcolor="#C0FFC0" align=center>za tarif</td>
<td bgcolor="#C0FFC0" align=center>za prùmìr</td>
<td bgcolor="#C0FFC0" align=center>z docházky</td>
<td></td>
<td bgcolor="#C0FFC0" align=center>Nh x tarif</td>

</tr>


<tr align=center bgcolor="#C0FFC0">
<td>Os.Èíslo</td>
<td>Pøíjmení a jméno</td>
<td>Obsazení</td>
<td>Støedisko</td>
<td>Pl.Harm.Forem</td>
<td>Pl.Harm.Hod.</td>
<td>Práce u Stroje</td>
<td>Poruchy a Prostoje</td>
<td>pøevod na jinou<br /> práci na støedisku</td>
<td>pøevod na jiné<br /> støedisko</td>
<td>celkem evidovaný<br /> èas</td>
<td>% výkonu</td>
<td>Suma Nhod.</td>
<td align=center>Poznámka</td>
</tr>

<script type="text/javascript">
function calculate(os){

if (document.getElementById(os+'value6').value=='') {document.getElementById(os+'value6').value=0}
if (document.getElementById(os+'value5').value=='') {document.getElementById(os+'value5').value=0}

if ((document.getElementById('hodprod').value / document.getElementById('hodsmena').value * document.getElementById(os+'value7').value + eval(document.getElementById(os+'value6').value) + eval(document.getElementById(os+'value5').value)) > document.getElementById(os+'value7').value ){
	document.getElementById(os+'value3').value=Math.round((document.getElementById(os+'value7').value - eval(document.getElementById(os+'value6').value) - eval(document.getElementById(os+'value5').value))*100)/100;
	var value3=document.getElementById(os+'value7').value - eval(document.getElementById(os+'value6').value) - eval(document.getElementById(os+'value5').value);
} else
 { 	document.getElementById(os+'value3').value=Math.round((document.getElementById('hodprod').value / document.getElementById('hodsmena').value * document.getElementById(os+'value7').value)*100)/100;
 	var value3=document.getElementById('hodprod').value / document.getElementById('hodsmena').value * document.getElementById(os+'value7').value;}

if (Math.round((document.getElementById(os+'value7').value-eval(document.getElementById(os+'value6').value)-eval(document.getElementById(os+'value5').value)-document.getElementById(os+'value3').value)*100)/100>0){
document.getElementById(os+'value4').value=Math.round((document.getElementById(os+'value7').value-eval(document.getElementById(os+'value6').value)-eval(document.getElementById(os+'value5').value)-document.getElementById(os+'value3').value)*100)/100;}
else {document.getElementById(os+'value4').value='';}

document.getElementById(os+'value8').value=document.getElementById('daywatt').value;
document.getElementById(os+'value9').value=Math.round((value3*(document.getElementById('hodwatt').value/document.getElementById('100procent').value))*100)/100;
}
</script>

<?
$dotaz=strediska();
$data1=mysql_query("select * from zamestnanci where ukol='ANO' and ($dotaz) order by stredisko,osobni_cislo,prijmeni,jmeno,titul") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows(@$data1)):



$hod=0;$min=0;$stepeni=1;$kody_val=explode(",", mysql_result(mysql_query("select hodnota from ukol_sumhodnoty where nazev='za tarif'"),0,0));
while ($kody_val[$stepeni]):
	$temp=mysql_query("select pracovni_doba from zpracovana_dochazka where osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."' and datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' and  id_ukonu in (select id from ukony where mzd1='".securesql($kody_val[$stepeni])."' or mzd2='".securesql($kody_val[$stepeni])."' or mzd3='".securesql($kody_val[$stepeni])."' or mzd4='".securesql($kody_val[$stepeni])."' or mzd5='".securesql($kody_val[$stepeni])."' or mzd6='".securesql($kody_val[$stepeni])."' or mzd7='".securesql($kody_val[$stepeni])."' or mzd8='".securesql($kody_val[$stepeni])."' or mzd9='".securesql($kody_val[$stepeni])."')   ");
		$cykl2=0;while(mysql_result($temp,$cykl2,0)):
			$loadworktime=explode(":",mysql_result($temp,$cykl2,0));
			$hod=$hod+$loadworktime[0];$min=$min+$loadworktime[1];
		@$cykl2++;endwhile;
@$stepeni++;endwhile;
if (@$min>=60) {$ppr=floor(@$min/60);@$hod=@$hod+$ppr;@$min=@$min-(@$ppr*60);}$min=$min/60;while (strlen($min)<2):$min="0".$min;endwhile;$value1[mysql_result(@$data1,@$cykl,1)]=$hod+$min;
if ($value1[mysql_result(@$data1,@$cykl,1)]=="0.00") {$value1[mysql_result(@$data1,@$cykl,1)]="";}

$hod=0;$min=0;$stepeni=1;$kody_val=explode(",", mysql_result(mysql_query("select hodnota from ukol_sumhodnoty where nazev='za prùmìr'"),0,0));
while ($kody_val[$stepeni]):
	$temp=mysql_query("select pracovni_doba from zpracovana_dochazka where osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."' and datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' and  id_ukonu in (select id from ukony where mzd1='".securesql($kody_val[$stepeni])."' or mzd2='".securesql($kody_val[$stepeni])."' or mzd3='".securesql($kody_val[$stepeni])."' or mzd4='".securesql($kody_val[$stepeni])."' or mzd5='".securesql($kody_val[$stepeni])."' or mzd6='".securesql($kody_val[$stepeni])."' or mzd7='".securesql($kody_val[$stepeni])."' or mzd8='".securesql($kody_val[$stepeni])."' or mzd9='".securesql($kody_val[$stepeni])."')   ");
		$cykl2=0;while(mysql_result($temp,$cykl2,0)):
			$loadworktime=explode(":",mysql_result($temp,$cykl2,0));
			$hod=$hod+$loadworktime[0];$min=$min+$loadworktime[1];
		@$cykl2++;endwhile;
@$stepeni++;endwhile;
if (@$min>=60) {$ppr=floor(@$min/60);@$hod=@$hod+$ppr;@$min=@$min-(@$ppr*60);}$min=$min/60;while (strlen($min)<2):$min="0".$min;endwhile;$value2[mysql_result(@$data1,@$cykl,1)]=$hod+$min;
if ($value2[mysql_result(@$data1,@$cykl,1)]=="0.00") {$value2[mysql_result(@$data1,@$cykl,1)]="";}

$hod=0;$min=0;$stepeni=1;$kody_val=explode(",", mysql_result(mysql_query("select hodnota from ukol_sumhodnoty where nazev='z docházky'"),0,0));
while ($kody_val[$stepeni]):
	$temp=mysql_query("select pracovni_doba from zpracovana_dochazka where osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."' and datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' and id_ukonu in (select id from ukony where mzd1='".securesql($kody_val[$stepeni])."' or mzd2='".securesql($kody_val[$stepeni])."' or mzd3='".securesql($kody_val[$stepeni])."' or mzd4='".securesql($kody_val[$stepeni])."' or mzd5='".securesql($kody_val[$stepeni])."' or mzd6='".securesql($kody_val[$stepeni])."' or mzd7='".securesql($kody_val[$stepeni])."' or mzd8='".securesql($kody_val[$stepeni])."' or mzd9='".securesql($kody_val[$stepeni])."')   ");
		$cykl2=0;while(mysql_result($temp,$cykl2,0)):
			$loadworktime=explode(":",mysql_result($temp,$cykl2,0));
			$hod=$hod+$loadworktime[0];$min=$min+$loadworktime[1];
		@$cykl2++;endwhile;
@$stepeni++;endwhile;
if (@$min>=60) {$ppr=floor(@$min/60);@$hod=@$hod+$ppr;@$min=@$min-(@$ppr*60);}$min=$min/60;while (strlen($min)<2):$min="0".$min;endwhile;$value3[mysql_result(@$data1,@$cykl,1)]=$hod+$min;
if ($value3[mysql_result(@$data1,@$cykl,1)]=="0.00") {$value3[mysql_result(@$data1,@$cykl,1)]="";}

if (!mysql_num_rows(mysql_query("select id from ukoly_data where osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."' and datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' "))){$stav="";} else {$stav="<img src=./picture/ready.png>";}


?><input type=hidden name=<?echo $cykl;?>value0 value="<?echo mysql_result(@$data1,@$cykl,1);?>"><?
echo "<tr><td align=center>".$stav.mysql_result(@$data1,@$cykl,1)."</td><td>".mysql_result(@$data1,@$cykl,4)." ".mysql_result(@$data1,@$cykl,3)." ".mysql_result(@$data1,@$cykl,2)."</td>";
echo "<td>".mysql_result(@$data1,@$cykl,35)."</td><td align=center>".mysql_result(@$data1,@$cykl,17)."</td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value1 name=".mysql_result(@$data1,@$cykl,1)."value1 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value2 name=".mysql_result(@$data1,@$cykl,1)."value2 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value3 name=".mysql_result(@$data1,@$cykl,1)."value3 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value4 name=".mysql_result(@$data1,@$cykl,1)."value4 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";

echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value5 name=".mysql_result(@$data1,@$cykl,1)."value5 type=text value='".$value1[mysql_result(@$data1,@$cykl,1)]."' style=width:100%;text-align:center; onkeyup=calculate(".mysql_result(@$data1,@$cykl,1).") onclick=calculate(".mysql_result(@$data1,@$cykl,1).") ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value6 name=".mysql_result(@$data1,@$cykl,1)."value6 type=text value='".$value2[mysql_result(@$data1,@$cykl,1)]."' style=width:100%;text-align:center; onkeyup=calculate(".mysql_result(@$data1,@$cykl,1).") onclick=calculate(".mysql_result(@$data1,@$cykl,1).") ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value7 name=".mysql_result(@$data1,@$cykl,1)."value7 type=text value='".$value3[mysql_result(@$data1,@$cykl,1)]."' style=width:100%;text-align:center; onkeyup=calculate(".mysql_result(@$data1,@$cykl,1).") onclick=calculate(".mysql_result(@$data1,@$cykl,1).") ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value8 name=".mysql_result(@$data1,@$cykl,1)."value8 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value9 name=".mysql_result(@$data1,@$cykl,1)."value9 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value10 name=".mysql_result(@$data1,@$cykl,1)."value10 type=text value='' style=width:200px ></td></tr>";

if (!mysql_num_rows(mysql_query("select id from ukoly_data where osobni_cislo='".securesql(mysql_result(@$data1,@$cykl,1))."' and datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' "))){echo"<script>load();calculate(".mysql_result(@$data1,@$cykl,1).");</script>";}

@$cykl++;endwhile;

if (@$tlacitko==" Uložit " or mysql_result(@$data3,0,0)) {@$tlacitko="";?><script>load();</script><?}
if (mysql_num_rows(mysql_query("select exportovano from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' and exportovano='ANO'"))==false) {?><tr><td colspan=14 align=right><input name=tlacitko type="submit" value=" Uložit "></td></tr><?}?>
<tr><td colspan=14><?echo $existtb;?></td></tr><?}









if (@$_POST["obdobi"] and @$_POST["den"]=="SUMA") {
@$data2=mysql_query("select * from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "); // data z DB
@$data3=mysql_query("select * from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' group by osobni_cislo order by osobni_cislo"); // data z DB
@$data4=mysql_query("select * from ukoly_export where obdobi='".securesql(@$_POST["obdobi"])."' ");

?>
<script type="text/javascript">
function loadsum(){document.getElementById('celkforem').value="<?echo mysql_result(mysql_query("select SUM(vyrobeno_forem) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";
document.getElementById('goodform').value="<?echo mysql_result(mysql_query("select SUM(dobrych_forem) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";
document.getElementById('hodprod').value="<?echo mysql_result(mysql_query("select SUM(doba_vyr) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";
document.getElementById('stop').value="<?echo mysql_result(mysql_query("select SUM(poruchy) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";

document.getElementById('hodwatt').value=Math.round((document.getElementById('goodform').value/(eval(document.getElementById('hodprod').value)+eval(document.getElementById('stop').value)))*100)/100;document.getElementById('daywatt').value=(Math.round((document.getElementById('hodwatt').value/document.getElementById('100procent').value)*10000)/100)+"%";
document.getElementById('hodwatte').value=Math.round((document.getElementById('goodform').value/document.getElementById('hodprod').value)*100)/100;

if ('<?echo "a".mysql_result(@$data3,0,1);?>'!='a') {
<?$dload=0;while(@$dload<mysql_num_rows(@$data3)):?>
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value1').value='<?echo mysql_result(mysql_query("select SUM(value1) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value2').value='<?echo mysql_result(mysql_query("select SUM(value2) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value3').value='<?echo mysql_result(mysql_query("select SUM(value3) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value4').value='<?echo mysql_result(mysql_query("select SUM(value4) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value5').value='<?echo mysql_result(mysql_query("select SUM(value5) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value6').value='<?echo mysql_result(mysql_query("select SUM(value6) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value7').value='<?echo mysql_result(mysql_query("select SUM(value7) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
if (document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value7').value!='') {document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value8').value=document.getElementById('daywatt').value;} else {document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value8').value='0%'}
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value9').value=Math.round((document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value3').value*document.getElementById('hodwatt').value/document.getElementById('100procent').value)*100)/100;
<?@$dload++;endwhile;?>}

}
</script>

<tr>
<td>Vyrobeno forem:</td><td><input id=celkforem name="celkforem" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
<td>100% forem / hod.:</td><td><input id="100procent" name="100procent" type="text" value="<?if (mysql_result(@$data4,0,2)){echo mysql_result(@$data4,0,2);} else {echo "50";}?>" style=width:100%;text-align:center;background:#FAA3A9;<?if (mysql_result(@$data4,0,2)) {echo "background:white readonly=yes";}?> ></td>
<td colspan=10 align=right><input type="button" name=tlacitko value="Naèíst / Pøepoèítat" onclick=loadsum()></td>
</tr>

<tr>
<td>Dobrých Forem:</td><td><input id=goodform name="goodform" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
<td>Výkon za Hodinu (Smìna 8h):</td><td><input id="hodwatt" name="hodwatt" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
</tr>

<tr>
<td>Doba Výroby:</td><td><input id=hodprod name="hodprod" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
<td>plnìní za Smìnu:</td><td><input id=daywatt name="daywatt" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
</tr>

<tr>
<td>Poruchy:</td><td><input id=stop name="stop" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
<td>výkon za hodinu (efektivnì):</td><td><input id=hodwatte name="hodwatte" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
<td colspan=2></td>
<td colspan=4 bgcolor="#C0FFC0" align=center>souèet musí souhlasit s celk. evid. èasem</td>
<td colspan=2></td>
<td bgcolor="#C0FFC0" align=center>úkol.mzda</td>
</tr>

<tr>
<td>Období:</td><td><input type="text" value="<?echo $obdobi1[1].".".$obdobi1[0];?>" style=width:100%;text-align:center; disabled></td>
<td ></td><td></td>
<td colspan=2></td>
<td bgcolor="#C0FFC0" align=center></td>
<td bgcolor="#C0FFC0" align=center>za tarif</td>
<td bgcolor="#C0FFC0" align=center>za tarif</td>
<td bgcolor="#C0FFC0" align=center>za prùmìr</td>
<td bgcolor="#C0FFC0" align=center>z docházky</td>
<td></td>
<td bgcolor="#C0FFC0" align=center>Nh x tarif</td>
</tr>


<tr align=center bgcolor="#C0FFC0">
<td>Os.Èíslo</td>
<td>Pøíjmení a jméno</td>
<td>Obsazení</td>
<td>Støedisko</td>
<td>Pl.Harm.Forem</td>
<td>Pl.Harm.Hod.</td>
<td>Práce u Stroje</td>
<td>Poruchy a Prostoje</td>
<td>pøevod na jinou<br /> práci na støedisku</td>
<td>pøevod na jiné<br /> støedisko</td>
<td>celkem evidovaný<br /> èas</td>
<td>% výkonu</td>
<td>Suma Nhod.</td>
<td align=center>Kód MS</td>
</tr>
<?
$dotaz=strediska();
$data1=mysql_query("select * from zamestnanci where ukol='ANO' and ($dotaz) order by stredisko,osobni_cislo,prijmeni,jmeno,titul") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows(@$data1)):

?><input type=hidden name=<?echo $cykl;?>value0 value="<?echo mysql_result(@$data1,@$cykl,1);?>"><?
echo "<tr><td align=center>".mysql_result(@$data1,@$cykl,1)."</td><td>".mysql_result(@$data1,@$cykl,4)." ".mysql_result(@$data1,@$cykl,3)." ".mysql_result(@$data1,@$cykl,2)."</td>";
echo "<td>".mysql_result(@$data1,@$cykl,35)."</td><td align=center>".mysql_result(@$data1,@$cykl,17)."</td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value1 name=".mysql_result(@$data1,@$cykl,1)."value1 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value2 name=".mysql_result(@$data1,@$cykl,1)."value2 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value3 name=".mysql_result(@$data1,@$cykl,1)."value3 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value4 name=".mysql_result(@$data1,@$cykl,1)."value4 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value5 name=".mysql_result(@$data1,@$cykl,1)."value5 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value6 name=".mysql_result(@$data1,@$cykl,1)."value6 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value7 name=".mysql_result(@$data1,@$cykl,1)."value7 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value8 name=".mysql_result(@$data1,@$cykl,1)."value8 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value9 name=".mysql_result(@$data1,@$cykl,1)."value9 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value10 name=".mysql_result(@$data1,@$cykl,1)."value10 type=text value='".mysql_result(@$data1,@$cykl,36)."' style=width:200px;text-align:center;background:#EBDA5F; readonly=yes ></td></tr>";


@$cykl++;endwhile;

if (mysql_result(@$data4,0,2)==false and $closedate=="yes") {?><tr><td colspan=14 align=right><input name=tlacitko type="submit" value=" Uzamknout pro Export "></td></tr><script>loadsum();</script><?}
else {?><script>loadsum();</script><?}?>
<tr><td colspan=14><?echo $existtb;?></td></tr>

<?}}?>





<?if (@$menu=="Export Úkolové Práce"){?>
<tr bgcolor="#C0FFC0"><td colspan=7><center><b><?echo@$menu;?></b></center></td>
<td align=right colspan=7 >Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$_POST["obdobi"]<>""){?><option value="<?echo @$_POST['obdobi'];?>"><?$obdobi1=explode("-",@$_POST["obdobi"]);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
@$data1 = mysql_query("select obdobi from ukoly_export order by obdobi DESC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$_POST["obdobi"]){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<?if (@$_POST["obdobi"]) {
@$data2=mysql_query("select * from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "); // data z DB
@$data3=mysql_query("select * from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' group by osobni_cislo order by osobni_cislo"); // data z DB
@$data4=mysql_query("select * from ukoly_export where obdobi='".securesql(@$_POST["obdobi"])."' ");

?>
<script type="text/javascript">
function loadsum(){
document.getElementById('celkforem').value="<?echo mysql_result(mysql_query("select SUM(vyrobeno_forem) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";
document.getElementById('goodform').value="<?echo mysql_result(mysql_query("select SUM(dobrych_forem) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";
document.getElementById('hodprod').value="<?echo mysql_result(mysql_query("select SUM(doba_vyr) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";
document.getElementById('stop').value="<?echo mysql_result(mysql_query("select SUM(poruchy) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";

document.getElementById('hodwatt').value=Math.round((document.getElementById('goodform').value/(eval(document.getElementById('hodprod').value)+eval(document.getElementById('stop').value)))*100)/100;
document.getElementById('daywatt').value=(Math.round((document.getElementById('hodwatt').value/document.getElementById('100procent').value)*10000)/100)+"%";
document.getElementById('hodwatte').value=Math.round((document.getElementById('goodform').value/document.getElementById('hodprod').value)*100)/100;

if ('<?echo "a".mysql_result(@$data3,0,1);?>'!='a') {
<?$dload=0;while(@$dload<mysql_num_rows(@$data3)):?>
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value1').value='<?echo mysql_result(mysql_query("select SUM(value1) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value2').value='<?echo mysql_result(mysql_query("select SUM(value2) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value3').value='<?echo mysql_result(mysql_query("select SUM(value3) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value4').value='<?echo mysql_result(mysql_query("select SUM(value4) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value5').value='<?echo mysql_result(mysql_query("select SUM(value5) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value6').value='<?echo mysql_result(mysql_query("select SUM(value6) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value7').value='<?echo mysql_result(mysql_query("select SUM(value7) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
if (document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value7').value!='') {document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value8').value=document.getElementById('daywatt').value;} else {document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value8').value='0%'}
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value9').value=Math.round((document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value3').value*document.getElementById('hodwatt').value/document.getElementById('100procent').value)*100)/100;
<?@$dload++;endwhile;?>}

}
</script>

<tr>
<td>Vyrobeno forem:</td><td><input id=celkforem name="celkforem" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
<td>100% forem / hod.:</td><td><input id="100procent" name="100procent" type="text" value="<?echo mysql_result(@$data4,0,2);?>" style=width:100%;text-align:center;background:white readonly=yes ></td>
<td colspan=10 align=right><input type="button" name=tlacitko value="Exportovat" onclick=exportsum()></td>
</tr>

<tr>
<td>Dobrých Forem:</td><td><input id=goodform name="goodform" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
<td>Výkon za Hodinu (Smìna 8h):</td><td><input id="hodwatt" name="hodwatt" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
</tr>

<tr>
<td>Doba Výroby:</td><td><input id=hodprod name="hodprod" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
<td>plnìní za Smìnu:</td><td><input id=daywatt name="daywatt" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
</tr>

<tr>
<td>Poruchy:</td><td><input id=stop name="stop" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
<td>výkon za hodinu (efektivnì):</td><td><input id=hodwatte name="hodwatte" type="text" value="" style=width:100%;text-align:center; readonly=yes></td>
<td colspan=2></td>
<td colspan=4 bgcolor="#C0FFC0" align=center>souèet musí souhlasit s celk. evid. èasem</td>
<td colspan=2></td>
<td bgcolor="#C0FFC0" align=center>úkol.mzda</td>
</tr>

<tr>
<td>Období:</td><td><input type="text" value="<?echo $obdobi1[1].".".$obdobi1[0];?>" style=width:100%;text-align:center; disabled></td>
<td ></td><td></td>
<td colspan=2></td>
<td bgcolor="#C0FFC0" align=center></td>
<td bgcolor="#C0FFC0" align=center>za tarif</td>
<td bgcolor="#C0FFC0" align=center>za tarif</td>
<td bgcolor="#C0FFC0" align=center>za prùmìr</td>
<td bgcolor="#C0FFC0" align=center>z docházky</td>
<td></td>
<td bgcolor="#C0FFC0" align=center>Nh x tarif</td>
</tr>


<tr align=center bgcolor="#C0FFC0">
<td>Os.Èíslo</td>
<td>Pøíjmení a jméno</td>
<td>Obsazení</td>
<td>Støedisko</td>
<td>Pl.Harm.Forem</td>
<td>Pl.Harm.Hod.</td>
<td>Práce u Stroje</td>
<td>Poruchy a Prostoje</td>
<td>pøevod na jinou<br /> práci na støedisku</td>
<td>pøevod na jiné<br /> støedisko</td>
<td>celkem evidovaný<br /> èas</td>
<td>% výkonu</td>
<td>Suma Nhod.</td>
<td align=center>Kód MS</td>
</tr>
<?
$dotaz=strediska();
$data1=mysql_query("select * from zamestnanci where ukol='ANO' and ($dotaz) order by stredisko,osobni_cislo,prijmeni,jmeno,titul") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows(@$data1)):

?><input type=hidden name=<?echo $cykl;?>value0 value="<?echo mysql_result(@$data1,@$cykl,1);?>"><?
echo "<tr><td align=center>".mysql_result(@$data1,@$cykl,1)."</td><td>".mysql_result(@$data1,@$cykl,4)." ".mysql_result(@$data1,@$cykl,3)." ".mysql_result(@$data1,@$cykl,2)."</td>";
echo "<td>".mysql_result(@$data1,@$cykl,35)."</td><td align=center>".mysql_result(@$data1,@$cykl,17)."</td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value1 name=".mysql_result(@$data1,@$cykl,1)."value1 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value2 name=".mysql_result(@$data1,@$cykl,1)."value2 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value3 name=".mysql_result(@$data1,@$cykl,1)."value3 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value4 name=".mysql_result(@$data1,@$cykl,1)."value4 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value5 name=".mysql_result(@$data1,@$cykl,1)."value5 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value6 name=".mysql_result(@$data1,@$cykl,1)."value6 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value7 name=".mysql_result(@$data1,@$cykl,1)."value7 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value8 name=".mysql_result(@$data1,@$cykl,1)."value8 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value9 name=".mysql_result(@$data1,@$cykl,1)."value9 type=text value='' style=width:100%;text-align:center;background:#EBDA5F; readonly=yes ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value10 name=".mysql_result(@$data1,@$cykl,1)."value10 type=text value='".mysql_result(@$data1,@$cykl,36)."' style=width:200px;text-align:center;background:#EBDA5F; readonly=yes ></td></tr>";


@$cykl++;endwhile;?>

<script>loadsum();</script>


<script type="text/javascript">
function exportsum(){<?IF(File_Exists($soubor))   {?>if (confirm('Chcete Pøepsat Exportovaný Soubor Úkolu za Období: <?echo @$_POST["obdobi"];?> ?')) {window.location.href('hlavicka.php?akce=<?echo base64_encode('Ukoly');?>&obdobi=<?echo @$_POST["obdobi"];?>&save=ok');}
else {alert("Uložení Exportu Úkolu Bylo Zrušeno");}<?}
else {?>
if (confirm('Chcete Export Úkolù za Období <?echo @$_POST["obdobi"];?> Skuteènì Uložit?')) {window.location.href('hlavicka.php?akce=<?echo base64_encode('Ukoly');?>&obdobi=<?echo @$_POST["obdobi"];?>&save=ok');}
else {alert("Uložení Exportu Úkolu Bylo Zrušeno");}
<?}?>
}
</script>


<?}}?>







<?} // konec write access


if (StrPos (" " . $_SESSION["prava"], "b") or StrPos (" " . $_SESSION["prava"], "B")){     // cteni



if (@$menu=="Pøehled Exportù Úkolové Práce"){?>
<tr bgcolor="#B4ADFC"><td colspan=3><center><b><?echo@$menu;?></b></center></td>
<td align=right>Rok: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$_REQUEST["obdobi"]<>""){?><option><?echo @$_REQUEST["obdobi"];?></option><?}?><option></option><?
@$data1 = mysql_query("select obdobi from ukoly_export order by obdobi DESC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$_REQUEST["obdobi"]){?><option><?echo mysql_result($data1,@$cykl,0);?></option><?}
@$cykl++;endwhile;?></select></td></tr>

<?$slozka = dir("ExportU");@$cykl=0;
while($soubory=$slozka->read()) {
if ($soubory<>"." and $soubory<>".." and StrPos (" " . $soubory, @$_REQUEST["obdobi"].".txt")) {
@$cykl++;
echo "<tr><td colspan=3> ".$cykl." </td><td align=right width=200> <a href=\"ExportU/$soubory\" target=_blank>".$soubory."</a> </td></tr>";}}
$slozka->close();
}




if (@$menu=="Pøehled Úkolové Práce"){?>
<tr bgcolor="#C0FFC0"><td colspan=7><center><b><?echo@$menu;?></b></center></td>
<td align=right colspan=5 >Období: <select name=obdobi size="1" onchange=submit(this) style=size:100%>
<?if (@$_POST["obdobi"]<>""){?><option value="<?echo @$_POST['obdobi'];?>"><?$obdobi1=explode("-",@$_POST["obdobi"]);echo $obdobi1[1].".".$obdobi1[0];?></option><?} else {?><option></option><?}
@$data1 = mysql_query("select obdobi from zpracovana_dochazka group by obdobi order by obdobi DESC") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,0)<>@$_POST["obdobi"]){?><option value="<?echo @mysql_result($data1,@$cykl,0);?>"><?$obdobi2=explode("-",mysql_result($data1,@$cykl,0));echo $obdobi2[1].".".$obdobi2[0];?></option><?}
@$cykl++;endwhile;?></select></td>

<td align=right colspan=2>
Den: <?if (@$_POST["obdobi"]) {?>
<select size="1" name="den" onchange=submit(this)>
<?if (@$_POST["den"]){echo"<option>".@$_POST["den"]."</option><option></option>";} else {echo "<option></option>";}

$cykl=0;$existtb="<table width=100% border=2 frame=border rules=all><tr align=center>";
while( @$cykl< date("t", strtotime(@$_POST["obdobi"]."-01"))+1 ):
if (@$cykl<10) {$cyklus="0".$cykl;} else {@$cyklus=$cykl;} $datum =@$_POST["obdobi"]."-".$cyklus;$cdne= date("w", strtotime($datum));
if (@$cdne==0 or @$cdne==6) {$barva="style=background:#F4CC6F";$was="V";} else {@$barva="";$was="";}
if (@$cykl==0 and @$_POST["den"]<>"SUMA") {echo"<option>SUMA</option>";}
if (@$cykl>0 and @$_POST["den"]<>$cyklus) {echo "<option ".$barva.">".$cyklus."</option>";}
if (mysql_num_rows(mysql_query("select id from ukoly_data where datum='".securesql($datum)."'"))) {$existtb.="<td style=background:#57F273>".$was.$cyklus."</td>";$closedate="yes";} else {$existtb.="<td style=background:red>".$was.$cyklus."</td>";}
@$cykl++;endwhile;$existtb.="</tr></table>";?>

</select><?}?></td></tr>

<?if (@$_POST["obdobi"] and @$_POST["den"] and @$_POST["den"]<>"SUMA") {
include "./dbconnectp.php";
$imported1=mysql_query("select cas,odformovano from provozhws where datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' ");

      @$goodpcs1 = mysql_query("select vykaz_prace.pocet,planvyroby.kod from vykaz_prace left outer join planvyroby ON vykaz_prace.id_objednavky = planvyroby.id where vykaz_prace.datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' order by vykaz_prace.id");
      @$cykl=0; @$goodform =0;while (@$cykl<mysql_num_rows($goodpcs1)):
      $goodform =$goodform +  (mysql_result($goodpcs1,@$cykl,0)* mysql_result(mysql_query("select pocet from postupy where kod='".mysql_result($goodpcs1,@$cykl,1)."' and material='Forma' order by id"),0,0));
      @$cykl++;endwhile;

mysql_close();include "./dbconnect.php";
@$data2=mysql_query("select * from ukoly_hlavicka where datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' "); // data z DB
@$data3=mysql_query("select * from ukoly_data where datum='".securesql(@$_POST["obdobi"]."-".@$_POST["den"])."' "); // data z DB
?>
<script type="text/javascript">
function load(){
if (document.getElementById('celkforem').value=='') {if ('<?echo "a".mysql_result(@$data2,0,2);?>'=='a') {document.getElementById('celkforem').value="<?echo mysql_result($imported1,0,1);?>";} else {document.getElementById('celkforem').value="<?echo mysql_result(@$data2,0,2);?>";}}
if (document.getElementById('hodsmena').value=='') {if ('<?echo "a".mysql_result(@$data2,0,6);?>'=='a') {document.getElementById('hodsmena').value="<?echo mysql_result($imported1,0,0);?>";} else {document.getElementById('hodsmena').value="<?echo mysql_result(@$data2,0,6);?>";}}
if (document.getElementById('goodform').value=='') {if ('<?echo "a".mysql_result(@$data2,0,3);?>'=='a') {document.getElementById('goodform').value="<?echo ceil($goodform);?>";} else {document.getElementById('goodform').value="<?echo mysql_result(@$data2,0,3);?>";}}


var promena=Math.ceil(document.getElementById('goodform').value)/document.getElementById('100procent').value;promena=document.getElementById('hodsmena').value-promena;

if (document.getElementById('stop').value=='') {if ('<?echo "a".mysql_result(@$data2,0,5);?>'=='a') {document.getElementById('stop').value=Math.round(promena*100)/100;} else {document.getElementById('stop').value="<?echo mysql_result(@$data2,0,5);?>";}}
if (document.getElementById('hodprod').value=='') {if ('<?echo "a".mysql_result(@$data2,0,4);?>'=='a') {document.getElementById('hodprod').value=document.getElementById('hodsmena').value-Math.round(promena*100)/100;} else {document.getElementById('hodprod').value="<?echo mysql_result(@$data2,0,4);?>";}}

document.getElementById('hodwatt').value=Math.round((document.getElementById('goodform').value/document.getElementById('hodsmena').value)*100000)/100000;
document.getElementById('daywatt').value=Math.round((document.getElementById('hodwatt').value/document.getElementById('100procent').value)*10000)/100 +'%';
document.getElementById('hodwatte').value=Math.round((document.getElementById('goodform').value/document.getElementById('hodprod').value)*100)/100;

if ('<?echo "a".mysql_result(@$data3,0,1);?>'!='a') {
<?$dload=0;while(@$dload<mysql_num_rows(@$data3)):?>
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value1').value='<?echo mysql_result(@$data3,$dload,3);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value2').value='<?echo mysql_result(@$data3,$dload,4);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value3').value='<?echo mysql_result(@$data3,$dload,5);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value4').value='<?echo mysql_result(@$data3,$dload,6);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value5').value='<?echo mysql_result(@$data3,$dload,7);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value6').value='<?echo mysql_result(@$data3,$dload,8);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value7').value='<?echo mysql_result(@$data3,$dload,9);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value8').value='<?echo mysql_result(@$data3,$dload,10)."%";?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value9').value='<?echo mysql_result(@$data3,$dload,11);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value10').value='<?echo mysql_result(@$data3,$dload,12);?>';
<?@$dload++;endwhile;?>}

}
</script>

<tr>
<td>Vyrobeno forem:</td><td><input id=celkforem name="celkforem" type="text" value="" style=width:100%;text-align:center; disabled></td>
<td>100% forem / hod.:</td><td><input id="100procent" name="100procent" type="text" value="50" style=width:100%;text-align:center; disabled></td>
<td colspan=10 align=right></td>
</tr>

<tr>
<td>Dobrých Forem:</td><td><input id=goodform name="goodform" type="text" value="" style=width:100%;text-align:center; disabled></td>
<td>Výkon za Hodinu:</td><td><input id="hodwatt" name="hodwatt" type="text" value="" style=width:100%;text-align:center; disabled></td>
</tr>

<tr>
<td>Doba Výroby:</td><td><input id=hodprod name="hodprod" type="text" value="" style=width:100%;text-align:center; disabled></td>
<td>plnìní za Smìnu:</td><td><input id=daywatt name="daywatt" type="text" value="" style=width:100%;text-align:center; disabled></td>
</tr>

<tr>
<td>Poruchy:</td><td><input id=stop name="stop" type="text" value="" style=width:100%;text-align:center; disabled></td>
<td>výkon za hodinu (efektivnì):</td><td><input id=hodwatte name="hodwatte" type="text" value="" style=width:100%;text-align:center; disabled></td>
<td colspan=2></td>
<td colspan=4 bgcolor="#C0FFC0" align=center>souèet musí souhlasit s celk. evid. èasem</td>
<td colspan=2></td>
<td bgcolor="#C0FFC0" align=center>úkol.mzda</td>
</tr>

<tr>
<td>Období:</td><td><input type="text" value="<?echo $obdobi1[1].".".$obdobi1[0];?>" style=width:100%;text-align:center; disabled></td>
<td >délka smìny [hod]:</td><td><input id=hodsmena name="hodsmena" type="text" value="" style=width:100%;text-align:center; disabled ></td>
<td colspan=2></td>
<td bgcolor="#C0FFC0" align=center></td>
<td bgcolor="#C0FFC0" align=center>za tarif</td>
<td bgcolor="#C0FFC0" align=center>za tarif</td>
<td bgcolor="#C0FFC0" align=center>za prùmìr</td>
<td bgcolor="#C0FFC0" align=center>z docházky</td>
<td></td>
<td bgcolor="#C0FFC0" align=center>Nh x tarif</td>

</tr>


<tr align=center bgcolor="#C0FFC0">
<td>Os.Èíslo</td>
<td>Pøíjmení a jméno</td>
<td>Obsazení</td>
<td>Støedisko</td>
<td>Pl.Harm.Forem</td>
<td>Pl.Harm.Hod.</td>
<td>Práce u Stroje</td>
<td>Poruchy a Prostoje</td>
<td>pøevod na jinou<br /> práci na støedisku</td>
<td>pøevod na jiné<br /> støedisko</td>
<td>celkem evidovaný<br /> èas</td>
<td>% výkonu</td>
<td>Suma Nhod.</td>
<td align=center>Poznámka</td>
</tr>

<script type="text/javascript">
function calculate(os){

if (document.getElementById(os+'value6').value=='') {document.getElementById(os+'value6').value=0}
if (document.getElementById(os+'value5').value=='') {document.getElementById(os+'value5').value=0}

if ((document.getElementById('hodprod').value / document.getElementById('hodsmena').value * document.getElementById(os+'value7').value + eval(document.getElementById(os+'value6').value) + eval(document.getElementById(os+'value5').value)) > document.getElementById(os+'value7').value ){
	document.getElementById(os+'value3').value=Math.round((document.getElementById(os+'value7').value - eval(document.getElementById(os+'value6').value) - eval(document.getElementById(os+'value5').value))*100)/100;
	var value3=document.getElementById(os+'value7').value - eval(document.getElementById(os+'value6').value) - eval(document.getElementById(os+'value5').value);
} else
 {
 	document.getElementById(os+'value3').value=Math.round((document.getElementById('hodprod').value / document.getElementById('hodsmena').value * document.getElementById(os+'value7').value)*100)/100;
 	var value3=document.getElementById('hodprod').value / document.getElementById('hodsmena').value * document.getElementById(os+'value7').value;}

if (Math.round((document.getElementById(os+'value7').value-eval(document.getElementById(os+'value6').value)-eval(document.getElementById(os+'value5').value)-document.getElementById(os+'value3').value)*100)/100>0){
document.getElementById(os+'value4').value=Math.round((document.getElementById(os+'value7').value-eval(document.getElementById(os+'value6').value)-eval(document.getElementById(os+'value5').value)-document.getElementById(os+'value3').value)*100)/100;}
else {document.getElementById(os+'value4').value='';}

document.getElementById(os+'value8').value=document.getElementById('daywatt').value;
document.getElementById(os+'value9').value=Math.round((value3*(document.getElementById('hodwatt').value/document.getElementById('100procent').value))*100)/100;
}
</script>

<?
$dotaz=strediska();
$data1=mysql_query("select * from zamestnanci where ukol='ANO' and ($dotaz) order by stredisko,osobni_cislo,prijmeni,jmeno,titul") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows(@$data1)):

?><input type=hidden name=<?echo $cykl;?>value0 value="<?echo mysql_result(@$data1,@$cykl,1);?>"><?
echo "<tr><td align=center>".mysql_result(@$data1,@$cykl,1)."</td><td>".mysql_result(@$data1,@$cykl,4)." ".mysql_result(@$data1,@$cykl,3)." ".mysql_result(@$data1,@$cykl,2)."</td>";
echo "<td>".mysql_result(@$data1,@$cykl,35)."</td><td align=center>".mysql_result(@$data1,@$cykl,17)."</td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value1 name=".mysql_result(@$data1,@$cykl,1)."value1 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value2 name=".mysql_result(@$data1,@$cykl,1)."value2 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value3 name=".mysql_result(@$data1,@$cykl,1)."value3 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value4 name=".mysql_result(@$data1,@$cykl,1)."value4 type=text value='' style=width:100%;text-align:center; disabled></td>";

echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value5 name=".mysql_result(@$data1,@$cykl,1)."value5 type=text value='' style=width:100%;text-align:center; disabled ></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value6 name=".mysql_result(@$data1,@$cykl,1)."value6 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value7 name=".mysql_result(@$data1,@$cykl,1)."value7 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value8 name=".mysql_result(@$data1,@$cykl,1)."value8 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value9 name=".mysql_result(@$data1,@$cykl,1)."value9 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value10 name=".mysql_result(@$data1,@$cykl,1)."value10 type=text value='' style=width:200px  disabled></td></tr>";


@$cykl++;endwhile;?>
<script>load();</script>
<tr><td colspan=14><?echo $existtb;?></td></tr>
<?}









if (@$_POST["obdobi"] and @$_POST["den"]=="SUMA") {

@$data2=mysql_query("select * from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "); // data z DB
@$data3=mysql_query("select * from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' group by osobni_cislo order by osobni_cislo"); // data z DB
@$data4=mysql_query("select * from ukoly_export where obdobi='".securesql(@$_POST["obdobi"])."' ");

?>
<script type="text/javascript">
function loadsum(){
document.getElementById('celkforem').value="<?echo mysql_result(mysql_query("select SUM(vyrobeno_forem) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";
document.getElementById('goodform').value="<?echo mysql_result(mysql_query("select SUM(dobrych_forem) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";
document.getElementById('hodprod').value="<?echo mysql_result(mysql_query("select SUM(doba_vyr) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";
document.getElementById('stop').value="<?echo mysql_result(mysql_query("select SUM(poruchy) from ukoly_hlavicka where datum like '".securesql(@$_POST["obdobi"])."%' "),0,0);?>";

document.getElementById('hodwatt').value=Math.round((document.getElementById('goodform').value/(eval(document.getElementById('hodprod').value)+eval(document.getElementById('stop').value)))*100)/100;
document.getElementById('daywatt').value=(Math.round((document.getElementById('hodwatt').value/document.getElementById('100procent').value)*10000)/100)+"%";
document.getElementById('hodwatte').value=Math.round((document.getElementById('goodform').value/document.getElementById('hodprod').value)*100)/100;

if ('<?echo "a".mysql_result(@$data3,0,1);?>'!='a') {
<?$dload=0;while(@$dload<mysql_num_rows(@$data3)):?>
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value1').value='<?echo mysql_result(mysql_query("select SUM(value1) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value2').value='<?echo mysql_result(mysql_query("select SUM(value2) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value3').value='<?echo mysql_result(mysql_query("select SUM(value3) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value4').value='<?echo mysql_result(mysql_query("select SUM(value4) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value5').value='<?echo mysql_result(mysql_query("select SUM(value5) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value6').value='<?echo mysql_result(mysql_query("select SUM(value6) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value7').value='<?echo mysql_result(mysql_query("select SUM(value7) from ukoly_data where datum like '".securesql(@$_POST["obdobi"])."%' and osobni_cislo='".securesql(mysql_result(@$data3,@$dload,1))."'"),0,0);?>';
if (document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value7').value!='') {document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value8').value=document.getElementById('daywatt').value;} else {document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value8').value='0%'}
document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value9').value=Math.round((document.getElementById('<?echo mysql_result(@$data3,@$dload,1);?>value3').value*document.getElementById('hodwatt').value/document.getElementById('100procent').value)*100)/100;
<?@$dload++;endwhile;?>}

}
</script>

<tr>
<td>Vyrobeno forem:</td><td><input id=celkforem name="celkforem" type="text" value="" style=width:100%;text-align:center;  disabled></td>
<td>100% forem / hod.:</td><td><input id="100procent" name="100procent" type="text" value="<?if (mysql_result(@$data4,0,2)){echo mysql_result(@$data4,0,2);} else {echo "50";}?>" style=width:100%;text-align:center;<?if (mysql_result(@$data4,0,2)) {echo " disabled";}?> ></td>
<td colspan=10 align=right></td>
</tr>

<tr>
<td>Dobrých Forem:</td><td><input id=goodform name="goodform" type="text" value="" style=width:100%;text-align:center; disabled></td>
<td>Výkon za Hodinu (Smìna 8h):</td><td><input id="hodwatt" name="hodwatt" type="text" value="" style=width:100%;text-align:center; disabled></td>
</tr>

<tr>
<td>Doba Výroby:</td><td><input id=hodprod name="hodprod" type="text" value="" style=width:100%;text-align:center; disabled></td>
<td>plnìní za Smìnu:</td><td><input id=daywatt name="daywatt" type="text" value="" style=width:100%;text-align:center; disabled></td>
</tr>

<tr>
<td>Poruchy:</td><td><input id=stop name="stop" type="text" value="" style=width:100%;text-align:center; disabled></td>
<td>výkon za hodinu (efektivnì):</td><td><input id=hodwatte name="hodwatte" type="text" value="" style=width:100%;text-align:center; disabled></td>
<td colspan=2></td>
<td colspan=4 bgcolor="#C0FFC0" align=center>souèet musí souhlasit s celk. evid. èasem</td>
<td colspan=2></td>
<td bgcolor="#C0FFC0" align=center>úkol.mzda</td>
</tr>

<tr>
<td>Období:</td><td><input type="text" value="<?echo $obdobi1[1].".".$obdobi1[0];?>" style=width:100%;text-align:center; disabled></td>
<td ></td><td></td>
<td colspan=2></td>
<td bgcolor="#C0FFC0" align=center></td>
<td bgcolor="#C0FFC0" align=center>za tarif</td>
<td bgcolor="#C0FFC0" align=center>za tarif</td>
<td bgcolor="#C0FFC0" align=center>za prùmìr</td>
<td bgcolor="#C0FFC0" align=center>z docházky</td>
<td></td>
<td bgcolor="#C0FFC0" align=center>Nh x tarif</td>
</tr>


<tr align=center bgcolor="#C0FFC0">
<td>Os.Èíslo</td>
<td>Pøíjmení a jméno</td>
<td>Obsazení</td>
<td>Støedisko</td>
<td>Pl.Harm.Forem</td>
<td>Pl.Harm.Hod.</td>
<td>Práce u Stroje</td>
<td>Poruchy a Prostoje</td>
<td>pøevod na jinou<br /> práci na støedisku</td>
<td>pøevod na jiné<br /> støedisko</td>
<td>celkem evidovaný<br /> èas</td>
<td>% výkonu</td>
<td>Suma Nhod.</td>
<td align=center>Kód MS</td>
</tr>
<?
$dotaz=strediska();
$data1=mysql_query("select * from zamestnanci where ukol='ANO' and ($dotaz) order by stredisko,osobni_cislo,prijmeni,jmeno,titul") or Die(MySQL_Error());
@$cykl=0;while (@$cykl<mysql_num_rows(@$data1)):

?><input type=hidden name=<?echo $cykl;?>value0 value="<?echo mysql_result(@$data1,@$cykl,1);?>"><?
echo "<tr><td align=center>".mysql_result(@$data1,@$cykl,1)."</td><td>".mysql_result(@$data1,@$cykl,4)." ".mysql_result(@$data1,@$cykl,3)." ".mysql_result(@$data1,@$cykl,2)."</td>";
echo "<td>".mysql_result(@$data1,@$cykl,35)."</td><td align=center>".mysql_result(@$data1,@$cykl,17)."</td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value1 name=".mysql_result(@$data1,@$cykl,1)."value1 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value2 name=".mysql_result(@$data1,@$cykl,1)."value2 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value3 name=".mysql_result(@$data1,@$cykl,1)."value3 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value4 name=".mysql_result(@$data1,@$cykl,1)."value4 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value5 name=".mysql_result(@$data1,@$cykl,1)."value5 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value6 name=".mysql_result(@$data1,@$cykl,1)."value6 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value7 name=".mysql_result(@$data1,@$cykl,1)."value7 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value8 name=".mysql_result(@$data1,@$cykl,1)."value8 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value9 name=".mysql_result(@$data1,@$cykl,1)."value9 type=text value='' style=width:100%;text-align:center; disabled></td>";
echo "<td><input id=".mysql_result(@$data1,@$cykl,1)."value10 name=".mysql_result(@$data1,@$cykl,1)."value10 type=text value='".mysql_result(@$data1,@$cykl,36)."' style=width:200px;text-align:center; disabled></td></tr>";


@$cykl++;endwhile;?>
<script>loadsum();</script>
<tr><td colspan=14><?echo $existtb;?></td></tr>

<?}}




}?>

</table></center>
</form>
