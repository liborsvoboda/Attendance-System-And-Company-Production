<?session_start();
session_register("loginname");
session_register("prava");
if ($_SESSION["loginname"]<>"") {$loginname=$_SESSION["loginname"];
$prava=$_SESSION["prava"];}

@$oscislo=base64_decode(@$_GET["oscislo"]);if (@$oscislo=="") {@$oscislo=@$_POST["oscislo"];}
@$datum=base64_decode(@$_GET["datum"]);if (@$datum=="") {@$datum=@$_POST["datum"];}$casti = explode("-", $datum);$obdobi1 = explode("-", $datum);$datumcs   = $casti[2].".".$casti[1].".".$casti[0];$cdne= date("w", strtotime($datum));
$obdobi=$casti[0]."-".$casti[1];


$prewdate=date("Y-m-d",strtotime($datum." - 1 day"));$prewtdate=date("Y-m-d",strtotime($datum." - 1 weeks"));
$nextdate=date("Y-m-d",strtotime($datum." + 1 day"));$nexttdate=date("Y-m-d",strtotime($datum." + 1 weeks"));

include ("./"."dbconnect.php");
@$cykl=0;@$datak = mysql_query("select obdobi from blokovani") or Die(MySQL_Error());
while (@$cykl<mysql_num_rows($datak)):
if (StrPos (" " . $datum, mysql_result($datak,@$cykl,0)) and !StrPos (" " . $_SESSION["prava"], "E")) {?><SCRIPT LANGUAGE="JavaScript">window.close();</SCRIPT><?}
@$cykl++;endwhile;


if (@$cdne==0) {$den="NEDÌLE";}
if (@$cdne==1) {$den="PONDÌLÍ";}
if (@$cdne==2) {$den="ÚTERÝ";}
if (@$cdne==3) {$den="STØEDA";}
if (@$cdne==4) {$den="ÈTVRTEK";}
if (@$cdne==5) {$den="PÁTEK";}
if (@$cdne==6) {$den="SOBOTA";}


@$zprichod=@$_POST["zprichod"];
@$zodchod=@$_POST["zodchod"];
@$poznamka=@$_POST["poznamka"];
@$tlacitko=@$_POST["tlacitko"];
@$stlacitko=@$_POST["stlacitko"];
@$firstload=@$_POST["firstload"];

@$dnes=date("Y-m-d");
@$dnescs=date("d.m.Y");


@$karta1 = mysql_query("select * from zamestnanci where osobni_cislo='".mysql_real_escape_string($oscislo)."'") or Die(MySQL_Error());
$prichod= mysql_result(mysql_query("select cislo from klavesnice where text='Pøíchod'"),0,0);
//$prichod1=mysql_query("select cislo from klavesnice where text like 'Pøíchod%'");@$cykl=0;while (@$cykl<mysql_num_rows($prichod1)):$prichod[@$cykl]= mysql_result($prichod1,$cykl,0);@$cykl++;endwhile;
$odchod1=mysql_query("select cislo,barva,text,id_ukonu from klavesnice where text like 'Odchod%'");@$cykl=0;while (@$cykl<mysql_num_rows($odchod1)):$odchod[@$cykl]= mysql_result($odchod1,$cykl,0);$odchodid[@$cykl]= mysql_result($odchod1,$cykl,3);$barvy[@$cykl]= mysql_result($odchod1,$cykl,1);$plky[@$cykl]= mysql_result($odchod1,$cykl,2);@$cykl++;endwhile;
@$vysledek = mysql_query("select * from dochazka where osobni_cislo='".mysql_real_escape_string($oscislo)."' and (datum='".mysql_real_escape_string($datum)."' or datum='".mysql_real_escape_string($nextdate)."') order by cas,id ") or Die(MySQL_Error());



?>
<html>
<head>
<title><?$data1=mysql_query("select * from zamestnanci where osobni_cislo='".mysql_real_escape_string($oscislo)."'");echo "Editace dne: ".$den." ".$datumcs." ".$oscislo." / ".mysql_result($data1,0,2)." ".mysql_result($data1,0,3)." ".mysql_result($data1,0,4);?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">

<!--// 3 ochrany proti navratu zpet, zmacknuti F5 jako reload, a zakaz praveho tlacitka mysi//-->
<SCRIPT LANGUAGE="JavaScript">
javascript:window.history.forward(1);
</SCRIPT>

<script language="JavaScript">
if (document.all){
document.onkeydown = function (){    var key_f5 = 116; // 116 = F5
if (key_f5==event.keyCode){ event.keyCode = 27;return false;}}}
</script>

<script language ="javascript">
function Disable() {
if (event.button == 2)
{
alert("Akce je Zakázána!! / Verbotene Aktion!!")
}}
document.onmousedown=Disable;
</script>


 <!--// skrolovani zpet na misto stranky odkud byl vyvolan reload jeste musi byt nastaven v body  onload="doScroll()" onunload="window.name=document.body.scrollTop"//-->
<script type="text/JavaScript">
function doScroll(){
  if (window.name) window.scrollTo(0, window.name);
}
</script>
</head>

<style type="text/css">
tr.menuon  {background-color:#F1BEED;}
tr.menuoff {background-color:#EDB745;}
</style>

<body bgcolor="#DEDCDC" text="BLACK" border=2 onload="doScroll()" onunload="window.name=document.body.scrollTop" style=margin:0px ><center>

<script type="text/JavaScript">
window.status='<?$data1=mysql_query("select * from zamestnanci where osobni_cislo='".mysql_real_escape_string($oscislo)."'");echo "Editace dne: ".$den." ".$datumcs." ".$oscislo." / ".mysql_result($data1,0,2)." ".mysql_result($data1,0,3)." ".mysql_result($data1,0,4);?>';
window.resizeTo(900,600);
</script>

<form action="Edit.php" method=post>
<input name="oscislo" type="hidden" value="<?echo@$oscislo;?>">
<input name="datum" type="hidden" value="<?echo@$datum;?>">

<table width=100%><tr>
<td align=left>




<input type="button" value=" <-- " title="Pøedchozí Týden" onclick="window.location.assign('Edit.php?oscislo=<? echo base64_encode(@$oscislo);?>&datum=<?echo base64_encode($prewtdate);?>')" <?if (date("Y-m",strtotime($datum))<>date("Y-m",strtotime($prewtdate))) {echo " disabled ";}?> >
<input type="button" value=" <- " title="Pøedchozí Den" onclick="window.location.assign('Edit.php?oscislo=<? echo base64_encode(@$oscislo);?>&datum=<?echo base64_encode($prewdate);?>')" <?if (date("Y-m",strtotime($datum))<>date("Y-m",strtotime($prewdate))) {echo " disabled ";}?> >

</td>
<td align=center><button onClick="window.close()" >Zavøít Okno</button></td><td align=right>
<input type="button" value=" -> " title="Následující Den" onclick="window.location.assign('Edit.php?oscislo=<? echo base64_encode(@$oscislo);?>&datum=<?echo base64_encode($nextdate);?>')" align=right <?if (date("Y-m",strtotime($datum))<>date("Y-m",strtotime($nextdate))) {echo " disabled ";}?> >
<input type="button" value=" --> " title="Následující Týden" onclick="window.location.assign('Edit.php?oscislo=<? echo base64_encode(@$oscislo);?>&datum=<?echo base64_encode($nexttdate);?>')" align=right <?if (date("Y-m",strtotime($datum))<>date("Y-m",strtotime($nexttdate))) {echo " disabled ";}?> ></td>
</tr></table>




<?
//ukládání poznámky
if (@$tlacitko=="Uložit Poznámku" or (@$tlacitko=="Uložit" and $poznamka<>"")) {@$control=mysql_num_rows(mysql_query("select * from poznamky where osobni_cislo='".mysql_real_escape_string($oscislo)."' and datum='$datum'"));
if (@$control=="") {mysql_query ("INSERT INTO poznamky (osobni_cislo,datum,poznamka,datumvkladu,vlozil) VALUES('$oscislo','$datum', '$poznamka', '$dnes','$loginname')") or Die(MySQL_Error());}
else {mysql_query ("update poznamky set poznamka = '$poznamka',datumzmeny='$dnes',zmenil='$loginname' where osobni_cislo = '$oscislo' and datum='$datum' ")or Die(MySQL_Error());}
?><?
if (@$tlacitko=="Uložit Poznámku") {?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Poznámky Probìhlo Úspìšnì</b></center></td></tr></table><?@$tlacitko="";@$stlacitko="";@$firstload="";}
}


if (@$stlacitko=="Uložit tyto Záznamy pro zvolený datum" and @$tlacitko=="Uložit") {//smazání pøedchozích záznamù
mysql_query ("delete from zpracovana_dochazka where osobni_cislo = '$oscislo' and datum='$datum' ")or Die(MySQL_Error());
$cykl=1;while (@$_POST["id_ukonu".$cykl]<>"" or @$_POST["id_ukonu".($cykl+1)]<>"" or @$_POST["id_ukonu".($cykl+2)]<>"" or @$_POST["id_ukonu".($cykl+3)]<>"" or @$_POST["id_ukonu".($cykl+4)]<>""):
$value1=@$_POST["prhodin".$cykl].":".@$_POST["prminut".$cykl];
$value2=@$_POST["id_ukonu".$cykl];
$value3=mysql_result(mysql_query("select nazev from ukony where id='$value2'"),0,0);
if (@$_POST["stredisko".$cykl]<>"") {$value4=@$_POST["stredisko".$cykl];} else {@$value4=mysql_result (mysql_query("select stredisko from zam_strediska where osobni_cislo='".mysql_real_escape_string($oscislo)."' and (datumod<='$datum' and datumdo>='$datum') order by id desc limit 1"),0,0);if ($value4==""){$value4=mysql_result(@$karta1,0,17);}}
$value5=@$_POST["zpoznamka".$cykl];
$value6=mysql_result(mysql_query("select zkratka from ukony where id='$value2'"),0,0);
// uložení akt záznamù
if ($value1<>":") {mysql_query ("INSERT INTO zpracovana_dochazka (osobni_cislo,pracovni_doba,id_ukonu,nazev_ukonu,zkratka_ukonu,datum,obdobi,stredisko,poznamka,datumvkladu,vlozil) VALUES('$oscislo','$value1', '$value2', '$value3', '$value6', '$datum','$obdobi','$value4','$value5', '$dnes','$loginname')") or Die(MySQL_Error());}
@$_POST["tlacitko".$cykl]="";
@$cykl++;endwhile;@$firstload="";@$stlacitko="";@$tlacitko="";
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Záznamù Probìhlo Úspìšnì</b></center></td></tr></table><?
}



if (@$stlacitko=="Uložit tyto Záznamy od zaèátku mìsíce do zvoleného datumu (vèetnì)" and @$tlacitko=="Uložit") {
$cykle=1;while( @$cykle< $obdobi1[2]+1 ):if (@$cykle<10) {$ucykle="0".@$cykle;} else {$ucykle=@$cykle;}@$datum1=$obdobi1[0]."-".$obdobi1[1]."-".$ucykle;$cdne= date("w", strtotime($datum1));
if (@$cdne<>0 and @$cdne<>6) {mysql_query ("delete from zpracovana_dochazka where osobni_cislo = '$oscislo' and datum='$datum1' ")or Die(MySQL_Error());
$cykl=1;while (@$_POST["id_ukonu".$cykl]<>"" or @$_POST["id_ukonu".($cykl+1)]<>"" or @$_POST["id_ukonu".($cykl+2)]<>"" or @$_POST["id_ukonu".($cykl+3)]<>"" or @$_POST["id_ukonu".($cykl+4)]<>""):
$value1=@$_POST["prhodin".$cykl].":".@$_POST["prminut".$cykl];
$value2=@$_POST["id_ukonu".$cykl];
$value3=mysql_result(mysql_query("select nazev from ukony where id='$value2'"),0,0);
if (@$_POST["stredisko".$cykl]<>"") {$value4=@$_POST["stredisko".$cykl];} else {@$value4=mysql_result (mysql_query("select stredisko from zam_strediska where osobni_cislo='".mysql_real_escape_string($oscislo)."' and (datumod<='$datum' and datumdo>='$datum') order by id desc limit 1"),0,0);if ($value4==""){$value4=mysql_result(@$karta1,0,17);}}
$value5=@$_POST["zpoznamka".$cykl];
$value6=mysql_result(mysql_query("select zkratka from ukony where id='$value2'"),0,0);
// uložení akt záznamù
if ($value1<>":") {mysql_query ("INSERT INTO zpracovana_dochazka (osobni_cislo,pracovni_doba,id_ukonu,nazev_ukonu,zkratka_ukonu,datum,obdobi,stredisko,poznamka,datumvkladu,vlozil) VALUES('$oscislo','$value1', '$value2', '$value3', '$value6', '$datum1','$obdobi','$value4','$value5', '$dnes','$loginname')") or Die(MySQL_Error());}
@$_POST["tlacitko".$cykl]="";
@$cykl++;endwhile;}
@$cykle++;endwhile;
@$firstload="";@$stlacitko="";@$tlacitko="";
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Záznamù Probìhlo Úspìšnì</b></center></td></tr></table><?
}


if (@$stlacitko=="Uložit tyto Záznamy pro tento týden (v Akt. Mìsíci)" and @$tlacitko=="Uložit") {
$tyden= date("W", strtotime($datumcs));$cdne= date("w", strtotime($datumcs));if (@$cdne==0) {$cdne=7;}
$startday= date("d.m.Y", strtotime($datumcs." - ".(@$cdne)." days + 1 day"));$aktmonate=date("Y-m-", strtotime($datumcs));
$cykle=0;while( @$cykle< 7 ): $runday= date("Y-m-d", strtotime($startday." + ".$cykle." days"));$cdne= date("w", strtotime($runday));$casti = explode("-", $runday);$obdobi=$casti[0]."-".$casti[1];
if (@$cdne<>0 and @$cdne<>6 and StrPos (" " . $runday, $aktmonate)) {mysql_query ("delete from zpracovana_dochazka where osobni_cislo = '$oscislo' and datum='$runday' ")or Die(MySQL_Error());
$cykl=1;while (@$_POST["id_ukonu".$cykl]<>"" or @$_POST["id_ukonu".($cykl+1)]<>"" or @$_POST["id_ukonu".($cykl+2)]<>"" or @$_POST["id_ukonu".($cykl+3)]<>"" or @$_POST["id_ukonu".($cykl+4)]<>""):
$value1=@$_POST["prhodin".$cykl].":".@$_POST["prminut".$cykl];
$value2=@$_POST["id_ukonu".$cykl];
$value3=mysql_result(mysql_query("select nazev from ukony where id='$value2'"),0,0);
if (@$_POST["stredisko".$cykl]<>"") {$value4=@$_POST["stredisko".$cykl];} else {@$value4=mysql_result (mysql_query("select stredisko from zam_strediska where osobni_cislo='".mysql_real_escape_string($oscislo)."' and (datumod<='$datum' and datumdo>='$datum') order by id desc limit 1"),0,0);if ($value4==""){$value4=mysql_result(@$karta1,0,17);}}
$value5=@$_POST["zpoznamka".$cykl];
$value6=mysql_result(mysql_query("select zkratka from ukony where id='$value2'"),0,0);
// uložení akt záznamù
if ($value1<>":") {mysql_query ("INSERT INTO zpracovana_dochazka (osobni_cislo,pracovni_doba,id_ukonu,nazev_ukonu,zkratka_ukonu,datum,obdobi,stredisko,poznamka,datumvkladu,vlozil) VALUES('$oscislo','$value1', '$value2', '$value3', '$value6', '$runday','$obdobi','$value4','$value5', '$dnes','$loginname')") or Die(MySQL_Error());}
@$_POST["tlacitko".$cykl]="";
@$cykl++;endwhile;}
@$cykle++;endwhile;
@$firstload="";@$stlacitko="";@$tlacitko="";
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Záznamù Probìhlo Úspìšnì</b></center></td></tr></table><?
}



if (@$stlacitko=="Uložit tyto Záznamy pro tento týden (v Akt. Mìsíci) i s víkendem" and @$tlacitko=="Uložit") {
$tyden= date("W", strtotime($datumcs));$cdne= date("w", strtotime($datumcs));if (@$cdne==0) {$cdne=7;}
$startday= date("d.m.Y", strtotime($datumcs." - ".(@$cdne)." days + 1 day"));$aktmonate=date("Y-m-", strtotime($datumcs));
$cykle=0;while( @$cykle< 7 ): $runday= date("Y-m-d", strtotime($startday." + ".$cykle." days"));$cdne= date("w", strtotime($runday));$casti = explode("-", $runday);$obdobi=$casti[0]."-".$casti[1];
if (StrPos (" " . $runday, $aktmonate)){
mysql_query ("delete from zpracovana_dochazka where osobni_cislo = '$oscislo' and datum='$runday' ")or Die(MySQL_Error());
$cykl=1;while (@$_POST["id_ukonu".$cykl]<>"" or @$_POST["id_ukonu".($cykl+1)]<>"" or @$_POST["id_ukonu".($cykl+2)]<>"" or @$_POST["id_ukonu".($cykl+3)]<>"" or @$_POST["id_ukonu".($cykl+4)]<>""):
$value1=@$_POST["prhodin".$cykl].":".@$_POST["prminut".$cykl];
$value2=@$_POST["id_ukonu".$cykl];
$value3=mysql_result(mysql_query("select nazev from ukony where id='$value2'"),0,0);
if (@$_POST["stredisko".$cykl]<>"") {$value4=@$_POST["stredisko".$cykl];} else {@$value4=mysql_result (mysql_query("select stredisko from zam_strediska where osobni_cislo='".mysql_real_escape_string($oscislo)."' and (datumod<='$datum' and datumdo>='$datum') order by id desc limit 1"),0,0);if ($value4==""){$value4=mysql_result(@$karta1,0,17);}}
$value5=@$_POST["zpoznamka".$cykl];
$value6=mysql_result(mysql_query("select zkratka from ukony where id='$value2'"),0,0);
// uložení akt záznamù
if ($value1<>":") {mysql_query ("INSERT INTO zpracovana_dochazka (osobni_cislo,pracovni_doba,id_ukonu,nazev_ukonu,zkratka_ukonu,datum,obdobi,stredisko,poznamka,datumvkladu,vlozil) VALUES('$oscislo','$value1', '$value2', '$value3', '$value6', '$runday','$obdobi','$value4','$value5', '$dnes','$loginname')") or Die(MySQL_Error());}
@$_POST["tlacitko".$cykl]="";
@$cykl++;endwhile;}
@$cykle++;endwhile;
@$firstload="";@$stlacitko="";@$tlacitko="";
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Záznamù Probìhlo Úspìšnì</b></center></td></tr></table><?
}



if (@$stlacitko=="Uložit tyto Záznamy od zaèátku mìsíce do zvoleného datumu (vèetnì) i s víkendy" and @$tlacitko=="Uložit") {
$cykle=1;while( @$cykle< $obdobi1[2]+1 ):if (@$cykle<10) {$ucykle="0".@$cykle;} else {$ucykle=@$cykle;}@$datum1=$obdobi1[0]."-".$obdobi1[1]."-".$ucykle;$cdne= date("w", strtotime($datum1));
mysql_query ("delete from zpracovana_dochazka where osobni_cislo = '$oscislo' and datum='$datum1' ")or Die(MySQL_Error());
$cykl=1;while (@$_POST["id_ukonu".$cykl]<>"" or @$_POST["id_ukonu".($cykl+1)]<>"" or @$_POST["id_ukonu".($cykl+2)]<>"" or @$_POST["id_ukonu".($cykl+3)]<>"" or @$_POST["id_ukonu".($cykl+4)]<>""):
$value1=@$_POST["prhodin".$cykl].":".@$_POST["prminut".$cykl];
$value2=@$_POST["id_ukonu".$cykl];
$value3=mysql_result(mysql_query("select nazev from ukony where id='$value2'"),0,0);
if (@$_POST["stredisko".$cykl]<>"") {$value4=@$_POST["stredisko".$cykl];} else {@$value4=mysql_result (mysql_query("select stredisko from zam_strediska where osobni_cislo='".mysql_real_escape_string($oscislo)."' and (datumod<='$datum' and datumdo>='$datum') order by id desc limit 1"),0,0);if ($value4==""){$value4=mysql_result(@$karta1,0,17);}}
$value5=@$_POST["zpoznamka".$cykl];
$value6=mysql_result(mysql_query("select zkratka from ukony where id='$value2'"),0,0);
// uložení akt záznamù
if ($value1<>":") {mysql_query ("INSERT INTO zpracovana_dochazka (osobni_cislo,pracovni_doba,id_ukonu,nazev_ukonu,zkratka_ukonu,datum,obdobi,stredisko,poznamka,datumvkladu,vlozil) VALUES('$oscislo','$value1', '$value2', '$value3', '$value6', '$datum1','$obdobi','$value4','$value5', '$dnes','$loginname')") or Die(MySQL_Error());}
@$_POST["tlacitko".$cykl]="";
@$cykl++;endwhile;
@$cykle++;endwhile;
@$firstload="";@$stlacitko="";@$tlacitko="";
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Záznamù Probìhlo Úspìšnì</b></center></td></tr></table><?
}



if (@$stlacitko=="Uložit tyto Záznamy od zvoleného datumu (vèetnì) konce mìsíce" and @$tlacitko=="Uložit") {
$cykle=$obdobi1[2];while( @$cykle< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):if (@$cykle<10) {$ucykle="0".@$cykle;} else {$ucykle=@$cykle;}@$datum1=$obdobi1[0]."-".$obdobi1[1]."-".$ucykle;$cdne= date("w", strtotime($datum1));
if (@$cdne<>0 and @$cdne<>6) {mysql_query ("delete from zpracovana_dochazka where osobni_cislo = '$oscislo' and datum='$datum1' ")or Die(MySQL_Error());
$cykl=1;while (@$_POST["id_ukonu".$cykl]<>"" or @$_POST["id_ukonu".($cykl+1)]<>"" or @$_POST["id_ukonu".($cykl+2)]<>"" or @$_POST["id_ukonu".($cykl+3)]<>"" or @$_POST["id_ukonu".($cykl+4)]<>""):
$value1=@$_POST["prhodin".$cykl].":".@$_POST["prminut".$cykl];
$value2=@$_POST["id_ukonu".$cykl];
$value3=mysql_result(mysql_query("select nazev from ukony where id='$value2'"),0,0);
if (@$_POST["stredisko".$cykl]<>"") {$value4=@$_POST["stredisko".$cykl];} else {@$value4=mysql_result (mysql_query("select stredisko from zam_strediska where osobni_cislo='".mysql_real_escape_string($oscislo)."' and (datumod<='$datum' and datumdo>='$datum') order by id desc limit 1"),0,0);if ($value4==""){$value4=mysql_result(@$karta1,0,17);}}
$value5=@$_POST["zpoznamka".$cykl];
$value6=mysql_result(mysql_query("select zkratka from ukony where id='$value2'"),0,0);
// uložení akt záznamù
if ($value1<>":") {mysql_query ("INSERT INTO zpracovana_dochazka (osobni_cislo,pracovni_doba,id_ukonu,nazev_ukonu,zkratka_ukonu,datum,obdobi,stredisko,poznamka,datumvkladu,vlozil) VALUES('$oscislo','$value1', '$value2', '$value3', '$value6', '$datum1','$obdobi','$value4','$value5', '$dnes','$loginname')") or Die(MySQL_Error());}
@$_POST["tlacitko".$cykl]="";
@$cykl++;endwhile;}
@$cykle++;endwhile;
@$firstload="";@$stlacitko="";@$tlacitko="";
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Záznamù Probìhlo Úspìšnì</b></center></td></tr></table><?
}



if (@$stlacitko=="Uložit tyto Záznamy od zvoleného datumu (vèetnì) konce mìsíce i s víkendy" and @$tlacitko=="Uložit") {
$cykle=$obdobi1[2];while( @$cykle< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):if (@$cykle<10) {$ucykle="0".@$cykle;} else {$ucykle=@$cykle;}@$datum1=$obdobi1[0]."-".$obdobi1[1]."-".$ucykle;$cdne= date("w", strtotime($datum1));
mysql_query ("delete from zpracovana_dochazka where osobni_cislo = '$oscislo' and datum='$datum1' ")or Die(MySQL_Error());
$cykl=1;while (@$_POST["id_ukonu".$cykl]<>"" or @$_POST["id_ukonu".($cykl+1)]<>"" or @$_POST["id_ukonu".($cykl+2)]<>"" or @$_POST["id_ukonu".($cykl+3)]<>"" or @$_POST["id_ukonu".($cykl+4)]<>""):
$value1=@$_POST["prhodin".$cykl].":".@$_POST["prminut".$cykl];
$value2=@$_POST["id_ukonu".$cykl];
$value3=mysql_result(mysql_query("select nazev from ukony where id='$value2'"),0,0);
if (@$_POST["stredisko".$cykl]<>"") {$value4=@$_POST["stredisko".$cykl];} else {@$value4=mysql_result (mysql_query("select stredisko from zam_strediska where osobni_cislo='".mysql_real_escape_string($oscislo)."' and (datumod<='$datum' and datumdo>='$datum') order by id desc limit 1"),0,0);if ($value4==""){$value4=mysql_result(@$karta1,0,17);}}
$value5=@$_POST["zpoznamka".$cykl];
$value6=mysql_result(mysql_query("select zkratka from ukony where id='$value2'"),0,0);
// uložení akt záznamù
if ($value1<>":") {mysql_query ("INSERT INTO zpracovana_dochazka (osobni_cislo,pracovni_doba,id_ukonu,nazev_ukonu,zkratka_ukonu,datum,obdobi,stredisko,poznamka,datumvkladu,vlozil) VALUES('$oscislo','$value1', '$value2', '$value3', '$value6', '$datum1','$obdobi','$value4','$value5', '$dnes','$loginname')") or Die(MySQL_Error());}
@$_POST["tlacitko".$cykl]="";
@$cykl++;endwhile;
@$cykle++;endwhile;
@$firstload="";@$stlacitko="";@$tlacitko="";
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Záznamù Probìhlo Úspìšnì</b></center></td></tr></table><?
}



if (@$stlacitko=="Uložit tyto Záznamy na celý mìsíc" and @$tlacitko=="Uložit") {
$cykle=1;while( @$cykle< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):if (@$cykle<10) {$ucykle="0".@$cykle;} else {$ucykle=@$cykle;}@$datum1=$obdobi1[0]."-".$obdobi1[1]."-".$ucykle;$cdne= date("w", strtotime($datum1));
if (@$cdne<>0 and @$cdne<>6) {mysql_query ("delete from zpracovana_dochazka where osobni_cislo = '$oscislo' and datum='$datum1' ")or Die(MySQL_Error());
$cykl=1;while (@$_POST["id_ukonu".$cykl]<>"" or @$_POST["id_ukonu".($cykl+1)]<>"" or @$_POST["id_ukonu".($cykl+2)]<>"" or @$_POST["id_ukonu".($cykl+3)]<>"" or @$_POST["id_ukonu".($cykl+4)]<>""):
$value1=@$_POST["prhodin".$cykl].":".@$_POST["prminut".$cykl];
$value2=@$_POST["id_ukonu".$cykl];
$value3=mysql_result(mysql_query("select nazev from ukony where id='$value2'"),0,0);
if (@$_POST["stredisko".$cykl]<>"") {$value4=@$_POST["stredisko".$cykl];} else {@$value4=mysql_result (mysql_query("select stredisko from zam_strediska where osobni_cislo='".mysql_real_escape_string($oscislo)."' and (datumod<='$datum' and datumdo>='$datum') order by id desc limit 1"),0,0);if ($value4==""){$value4=mysql_result(@$karta1,0,17);}}
$value5=@$_POST["zpoznamka".$cykl];
$value6=mysql_result(mysql_query("select zkratka from ukony where id='$value2'"),0,0);
// uložení akt záznamù
if ($value1<>":") {mysql_query ("INSERT INTO zpracovana_dochazka (osobni_cislo,pracovni_doba,id_ukonu,nazev_ukonu,zkratka_ukonu,datum,obdobi,stredisko,poznamka,datumvkladu,vlozil) VALUES('$oscislo','$value1', '$value2', '$value3', '$value6', '$datum1','$obdobi','$value4','$value5', '$dnes','$loginname')") or Die(MySQL_Error());}
@$_POST["tlacitko".$cykl]="";
@$cykl++;endwhile;}
@$cykle++;endwhile;
@$firstload="";@$stlacitko="";@$tlacitko="";
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Záznamù Probìhlo Úspìšnì</b></center></td></tr></table><?
}



if (@$stlacitko=="Uložit tyto Záznamy na celý mìsíc i s víkendy" and @$tlacitko=="Uložit") {
$cykle=1;while( @$cykle< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):if (@$cykle<10) {$ucykle="0".@$cykle;} else {$ucykle=@$cykle;}@$datum1=$obdobi1[0]."-".$obdobi1[1]."-".$ucykle;$cdne= date("w", strtotime($datum1));
mysql_query ("delete from zpracovana_dochazka where osobni_cislo = '$oscislo' and datum='$datum1' ")or Die(MySQL_Error());
$cykl=1;while (@$_POST["id_ukonu".$cykl]<>"" or @$_POST["id_ukonu".($cykl+1)]<>"" or @$_POST["id_ukonu".($cykl+2)]<>"" or @$_POST["id_ukonu".($cykl+3)]<>"" or @$_POST["id_ukonu".($cykl+4)]<>""):
$value1=@$_POST["prhodin".$cykl].":".@$_POST["prminut".$cykl];
$value2=@$_POST["id_ukonu".$cykl];
$value3=mysql_result(mysql_query("select nazev from ukony where id='$value2'"),0,0);
if (@$_POST["stredisko".$cykl]<>"") {$value4=@$_POST["stredisko".$cykl];} else {@$value4=mysql_result (mysql_query("select stredisko from zam_strediska where osobni_cislo='".mysql_real_escape_string($oscislo)."' and (datumod<='$datum' and datumdo>='$datum') order by id desc limit 1"),0,0);if ($value4==""){$value4=mysql_result(@$karta1,0,17);}}
$value5=@$_POST["zpoznamka".$cykl];
$value6=mysql_result(mysql_query("select zkratka from ukony where id='$value2'"),0,0);
// uložení akt záznamù
if ($value1<>":") {mysql_query ("INSERT INTO zpracovana_dochazka (osobni_cislo,pracovni_doba,id_ukonu,nazev_ukonu,zkratka_ukonu,datum,obdobi,stredisko,poznamka,datumvkladu,vlozil) VALUES('$oscislo','$value1', '$value2', '$value3', '$value6', '$datum1','$obdobi','$value4','$value5', '$dnes','$loginname')") or Die(MySQL_Error());}
@$_POST["tlacitko".$cykl]="";
@$cykl++;endwhile;
@$cykle++;endwhile;
@$firstload="";@$stlacitko="";@$tlacitko="";
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Záznamù Probìhlo Úspìšnì</b></center></td></tr></table><?
}









// konec ukládání


?>












<table width=100% border=1 bgcolor="#EDB745" cellpadding="0" cellspacing="0" >
<tr bgcolor="#B4ADFC" align=center><td>Pøíchod</td><td>Odchod</td><td>Celkový Èas</td><td>Pracovní Èas / Zbývá Def.</td><td>Poznámka</td></tr>

<?
if (@$obdobi1[1]<10 and strlen(@$obdobi1[1])<2){$dsvatku="-0".$obdobi1[1]."-".$obdobi1[2];} else {$dsvatku="-".$obdobi1[1]."-".$obdobi1[2];}
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$datum' and typ='Jedineèný') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trvalý' and stav='Neaktivní')) "),0,0);?>

<tr <?if (@$cdne>0 and @$cdne<6 and $svatek=="") {?>onmouseover="className='menuon';" onmouseout="className='menuoff';"<?} else {if (@$svatek=="") {?>bgcolor=#FDCC5B<?} else {?>bgcolor=#F7FBA4<?}}?> style=cursor:pointer; valign=top>

<td valign=bottom align=center><?$vypis=0;$narust=0;while($vypis<mysql_num_rows($vysledek)):
if (mysql_result($vysledek,@$vypis,4)==$prichod and mysql_result($vysledek,@$vypis,2) ==$datum) {$in[$narust] =mysql_result($vysledek,@$vypis,3);echo $in[$narust]."<br />";$narust++;}
@$vypis++;endwhile;?><hr>Celkem</td>

<td valign=bottom align=center><?$vypis=0;$narust=0;while($vypis<mysql_num_rows($vysledek)):
@$write=0;$odchody="NO";while ($odchod[@$write]<>""): if (mysql_result($vysledek,@$vypis,4) == $odchod[@$write] and mysql_result($vysledek,@$vypis,2) ==$datum ) {$plk=$plky[@$write];$barva=$barvy[@$write];$odchody="YES";$odchodukon=$odchodid[@$write];}@$write++;endwhile;
if ( $odchody=="YES") {$out[$narust] =mysql_result($vysledek,@$vypis,3);echo "<span style=background-color:".$barva." title='".$plk."'>".$out[$narust]."</span><br />";@$narust++;}
@$vypis++;endwhile;?><hr><br /></td>


<td valign=bottom align=center><?
$vypis=0;while($in[$vypis]<>"" and $out[$vypis]<>""):
@$castipr = explode(":", $in[$vypis]);@$prhod=@$castipr[0];@$prmin=@$castipr[1];
@$castiod = explode(":", $out[$vypis]);@$odhod=@$castiod[0];@$odmin=@$castiod[1];

if (@$odmin<@$prmin){@$vysmin=60-(@$prmin-@$odmin);@$vyshod=@$odhod-@$prhod-1;}
if (@$odmin>=@$prmin){@$vysmin=@$odmin-@$prmin;@$vyshod=@$odhod-@$prhod;}
if (@$vysmin<10){@$vysmin="0".@$vysmin;}
echo @$vyshod.":".@$vysmin."<br />";
@$celkhod=@$celkhod+@$vyshod;@$celkmin=@$celkmin+@$vysmin;
@$vypis++;endwhile;?><hr><?while(@$celkmin>=60):@$celkhod++;@$celkmin=@$celkmin-60;endwhile;echo @$celkhod.":";if ((@$celkmin<10 and @$celkmin<>"") or (@$celkhod<>"" and @$celkmin<10)) {echo"0";}echo @$celkmin."<br />";?></td>


<td valign=bottom align=center><?@$vyshod="";@$vysmin="";@$celkhod="";@$celkmin="";
$vypis=0;while($in[$vypis]<>"" and $out[$vypis]<>""):
@$castipr = explode(":", $in[$vypis]);@$prhod=@$castipr[0];@$prmin=@$castipr[1];
@$castiod = explode(":", $out[$vypis]);@$odhod=@$castiod[0];@$odmin=@$castiod[1];

if (@$odmin<@$prmin){@$vysmin=60-(@$prmin-@$odmin);@$vyshod=@$odhod-@$prhod-1;}
if (@$odmin>=@$prmin){@$vysmin=@$odmin-@$prmin;@$vyshod=@$odhod-@$prhod;}
if (@$vysmin<10){@$vysmin="0".@$vysmin;}

@$celkhod=@$celkhod+@$vyshod;@$celkmin=@$celkmin+@$vysmin;
@$vypis++;endwhile;?><hr><?while(@$celkmin>=60):@$celkhod++;@$celkmin=@$celkmin-60;endwhile;

// pøestávky
if (@$celkhod<>""){
@$prestavek=floor(round ((((@$celkhod*60)+@$celkmin)/60),3)/(@mysql_result(mysql_query("select * from setting where nazev='Pøestávka' order by id"),0,2)));
if (@$prestavek/2==ceil(@$prestavek/2)) {@$celkhod=@$celkhod-(0.5*@$prestavek);}
else {$ppr=floor(@$prestavek/2);
if (@$celkmin>=30) {@$celkmin=@$celkmin-30;@$celkhod=@$celkhod-(0.5*@$ppr);}
else {@$celkmin=@$celkmin+30;@$celkhod=@$celkhod-(0.5*@$ppr)-1;}}}

//již definováno
$nastaveno1=mysql_query("select * from zpracovana_dochazka where osobni_cislo = '$oscislo' and datum='$datum' order by id");
$nhod=0;$nmin=0;@$cykl=0;while(@$cykl<mysql_num_rows($nastaveno1)):
@$casti = explode(":", @mysql_result($nastaveno1,@$cykl,2));
@$nhod=@$nhod+@$casti[0];@$nmin=@$nmin+@$casti[1];
@$cykl++;endwhile;
if (@$nmin>60) {$ppr=floor(@$nmin/60);@$nhod=@$nhod+$ppr;@$nmin=@$nmin-(@$ppr*60);}@$zmin=@$celkmin-@$nmin;if (@$zmin<0) {@$nhod=@$nhod+1;@$zmin=60+@$celkmin-@$nmin;}if (@$zmin<10) {@$zmin="0".@$zmin;}@$zbyva=(@$celkhod-@$nhod).":".@$zmin;if (@$zbyva<>"0:00" and StrPos (" " . @$zbyva, "-")==false) {@$zbyva=" / ".@$zbyva;} else {@$zbyva="";}
//  konec definováno
if (@$celkmin<10 and @$celkmin<>"") {@$celkmin="0".@$celkmin;}

echo @$celkhod.":".@$celkmin.@$zbyva."<br />";?></td>



<td><textarea name="poznamka" rows=6 style=width:100% wrap="on"><?if (@$poznamka<>"") {echo@$poznamka;} else {echo mysql_result(mysql_query("select poznamka from poznamky where osobni_cislo='".mysql_real_escape_string($oscislo)."' and datum='$datum'"),0,0);}?></textarea></td></tr>
<tr><td colspan=4></td><td  style="margin-right: 0; margin-bottom: 10" align=center ><br /><input type="submit" name=tlacitko value="Uložit Poznámku"></td></tr>
</table>   <br /><br />








<!--//Tabulka záznamù//-->

<?  // sekce návrhu docházky
$zaznamu=1;$contdef=mysql_query("select * from zpracovana_dochazka where osobni_cislo='".mysql_real_escape_string($oscislo)."' and datum='$datum' order by id");
?>



<input name="oscislo" type="hidden" value="<?echo@$oscislo;?>">
<input name="datum" type="hidden" value="<?echo@$datum;?>">
<input name="firstload" type="hidden" value="<?echo@$firstload;?>">

<table border=1 bgcolor="#EDB745" cellpadding="0" cellspacing="0" >
<tr bgcolor="#87F8BF" align=left><td>Støedisko: <b><?echo @mysql_result($karta1,0,17);?></b></td><td align=right>Smìna: <b><?echo @mysql_result($karta1,0,24);?></b></td><td align=center> Pr.d.: <b><?echo @mysql_result($karta1,0,20);?></b></td><td align=right>Kategorie: <b><?echo @mysql_result($karta1,0,18);?></b></td></tr>
<tr bgcolor="#B4ADFC" align=center><td colspan=4><b>Definice Pracovní Doby</b></td></tr>
<tr bgcolor="#B4ADFC" align=center><td>Úkon</td><td> Druh Záznamu </td><td> Celkový Èas </td><td> Poznámka </td></tr>






<?
  //tvorit navrh z prednastaveni kdyz neni stipnuto
if (mysql_result($karta1,0,22)=="ANO" and mysql_result($karta1,0,20)<>"" and mysql_result($karta1,0,23)<>"0" and @$celkhod=="" and @$celkmin=="" and mysql_num_rows(@$contdef)=="" and $odchodukon==0 and (mysql_result(mysql_query("select operace from dochazka where osobni_cislo='".mysql_real_escape_string($oscislo)."' and datum < '$datum' order by datum DESC,cas DESC limit 1"),0,0))<>"-" and (mysql_result(mysql_query("select operace from dochazka where osobni_cislo='".mysql_real_escape_string($oscislo)."' and datum < '$datum' order by datum DESC,cas DESC limit 1"),0,0))<>"6") {
if (@$_POST["tlacitko".$zaznamu]=="") {?>
<tr bgcolor=#99FBC5><td align=center><input type="submit" name=tlacitko<?echo@$zaznamu;?> value="-" style=width:100%></td>
<td><select name="id_ukonu<?echo@$zaznamu;?>" onchange=submit(this)><? if (@$_POST["id_ukonu".$zaznamu]<>"") {?><option <?if (@$_POST["id_ukonu".$zaznamu]==@mysql_result($karta1,0,23)) {?>style=background-color:#99FBC5<?}?> value="<?echo $id=@$_POST["id_ukonu".$zaznamu];?>"><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?} else {?><option value="<?echo $id=@mysql_result($karta1,0,23);?>" style=background-color:#99FBC5><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?}?>
<?@$datas1 = mysql_query("select * from ukony where stav ='Aktivní' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select>

<? //práce na jiném støedisku
if (StrPos (" " . @$nazevstr, "støedisku")) {?><select name="stredisko<?echo@$zaznamu;?>"><?if (@$_POST["stredisko".$zaznamu]) {?><option><?echo @$_POST["stredisko".$zaznamu];?></option><?}?>
<option><?echo mysql_result($data1,0,17);?></option><?include ("./"."dbconnect.php");
@$datas1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datas1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$_POST["stredisko".$zaznamu]<>mysql_result($datas1,@$cykl,1)) {?><option><?echo mysql_result($datas1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select><?}?>

</td>
<td align=center><?@$casti=explode(":", mysql_result($karta1,0,20));@$hodin=$casti[0];@$minut=$casti[1];?>
<select size="1" name="prhodin<?echo@$zaznamu;?>">
<? if (@$_POST["prhodin".$zaznamu]<>"") {?><option <?if (@$_POST["prhodin".$zaznamu]==@$hodin) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prhodin".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo@$hodin;?></option><?}?>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="prminut<?echo@$zaznamu;?>"><? if (@$_POST["prminut".$zaznamu]<>"") {?><option <?if (@$_POST["prminut".$zaznamu]==@$minut) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prminut".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo@$minut;?></option><?}?>
<option>00</option><option>15</option><option>30</option><option>45</option><option>52.5</option></select>
</td><td><input name="zpoznamka<?echo@$zaznamu;?>" type="text" value="<?echo @$_POST["zpoznamka".$zaznamu];?>" style=width:250px style=background-color:#99FBC5></td>
</tr><?@$zaznamu++;} else {?><input name=tlacitko<?echo@$zaznamu++;?> type="hidden" value="-"><?}
}





  //tvorit navrh v budoucnu z prednastaveni kdyz neni stipnuto a posledni byla dovolena
if (mysql_result($karta1,0,22)=="ANO" and mysql_result($karta1,0,20)<>"" and @$celkhod=="" and @$celkmin=="" and mysql_num_rows(@$contdef)=="" and $odchodukon=="" and (mysql_result(mysql_query("select operace from dochazka where osobni_cislo='".mysql_real_escape_string($oscislo)."' and datum < '$datum' order by datum DESC,cas DESC limit 1"),0,0))=="-") {
if (@$_POST["tlacitko".$zaznamu]=="") {?>
<tr bgcolor=#99FBC5><td align=center><input type="submit" name=tlacitko<?echo@$zaznamu;?> value="-" style=width:100%></td>
<td><select name="id_ukonu<?echo@$zaznamu;?>" onchange=submit(this)><? if (@$_POST["id_ukonu".$zaznamu]<>"") {?><option <?if (@$_POST["id_ukonu".$zaznamu]==1) {?>style=background-color:#99FBC5<?}?> value="<?echo $id=@$_POST["id_ukonu".$zaznamu];?>"><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?}?>
<option value="21" style=background-color:#99FBC5><?echo mysql_result(mysql_query("select nazev from ukony where id='21'"),0,0);?></option>
<?@$datas1 = mysql_query("select * from ukony where stav ='Aktivní' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select>

<? //práce na jiném støedisku
if (StrPos (" " . @$nazevstr, "støedisku")) {?><select name="stredisko<?echo@$zaznamu;?>"><?if (@$_POST["stredisko".$zaznamu]) {?><option><?echo @$_POST["stredisko".$zaznamu];?></option><?}?>
<option><?echo mysql_result($data1,0,17);?></option><?include ("./"."dbconnect.php");
@$datas1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datas1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$_POST["stredisko".$zaznamu]<>mysql_result($datas1,@$cykl,1)) {?><option><?echo mysql_result($datas1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select><?}?>

</td>
<td align=center><?@$casti=explode(":", mysql_result($karta1,0,20));@$hodin=$casti[0];@$minut=$casti[1];?>
<select size="1" name="prhodin<?echo@$zaznamu;?>">
<? if (@$_POST["prhodin".$zaznamu]<>"") {?><option <?if (@$_POST["prhodin".$zaznamu]==@$hodin) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prhodin".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo@$hodin;?></option><?}?>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="prminut<?echo@$zaznamu;?>"><? if (@$_POST["prminut".$zaznamu]<>"") {?><option <?if (@$_POST["prminut".$zaznamu]==@$minut) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prminut".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo@$minut;?></option><?}?>
<option>00</option><option>15</option><option>30</option><option>45</option><option>52.5</option></select>
</td><td><input name="zpoznamka<?echo@$zaznamu;?>" type="text" value="<?echo @$_POST["zpoznamka".$zaznamu];?>" style=width:250px style=background-color:#99FBC5></td>
</tr><?@$zaznamu++;} else {?><input name=tlacitko<?echo@$zaznamu++;?> type="hidden" value="-"><?}
}




  //tvorit navrh v budoucnu z prednastaveni kdzy neni stipnuto a posledni byl lekar
if (mysql_result($karta1,0,22)=="ANO" and mysql_result($karta1,0,20)<>"" and @$celkhod=="" and @$celkmin=="" and mysql_num_rows(@$contdef)=="" and $odchodukon==0 and (mysql_result(mysql_query("select operace from dochazka where osobni_cislo='".mysql_real_escape_string($oscislo)."' and datum < '$datum' order by datum DESC,cas DESC limit 1"),0,0))=="6") {
if (@$_POST["tlacitko".$zaznamu]=="") {?>
<tr bgcolor=#99FBC5><td align=center><input type="submit" name=tlacitko<?echo@$zaznamu;?> value="-" style=width:100%></td>
<td><select name="id_ukonu<?echo@$zaznamu;?>" onchange=submit(this)><? if (@$_POST["id_ukonu".$zaznamu]<>"") {?><option <?if (@$_POST["id_ukonu".$zaznamu]==1) {?>style=background-color:#99FBC5<?}?> value="<?echo $id=@$_POST["id_ukonu".$zaznamu];?>"><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?}?>
<option value="9" style=background-color:#99FBC5><?echo mysql_result(mysql_query("select nazev from ukony where id='9'"),0,0);?></option>
<?@$datas1 = mysql_query("select * from ukony where stav ='Aktivní' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select>

<? //práce na jiném støedisku
if (StrPos (" " . @$nazevstr, "støedisku")) {?><select name="stredisko<?echo@$zaznamu;?>"><?if (@$_POST["stredisko".$zaznamu]) {?><option><?echo @$_POST["stredisko".$zaznamu];?></option><?}?>
<option><?echo mysql_result($data1,0,17);?></option><?include ("./"."dbconnect.php");
@$datas1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datas1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$_POST["stredisko".$zaznamu]<>mysql_result($datas1,@$cykl,1)) {?><option><?echo mysql_result($datas1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select><?}?>

</td>
<td align=center><?@$casti=explode(":", mysql_result($karta1,0,20));@$hodin=$casti[0];@$minut=$casti[1];?>
<select size="1" name="prhodin<?echo@$zaznamu;?>">
<? if (@$_POST["prhodin".$zaznamu]<>"") {?><option <?if (@$_POST["prhodin".$zaznamu]==@$hodin) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prhodin".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo@$hodin;?></option><?}?>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="prminut<?echo@$zaznamu;?>"><? if (@$_POST["prminut".$zaznamu]<>"") {?><option <?if (@$_POST["prminut".$zaznamu]==@$minut) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prminut".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo@$minut;?></option><?}?>
<option>00</option><option>15</option><option>30</option><option>45</option><option>52.5</option></select>
</td><td><input name="zpoznamka<?echo@$zaznamu;?>" type="text" value="<?echo @$_POST["zpoznamka".$zaznamu];?>" style=width:250px style=background-color:#99FBC5></td>
</tr><?@$zaznamu++;} else {?><input name=tlacitko<?echo@$zaznamu++;?> type="hidden" value="-"><?}
}



 //tvorit aktualni navrh dochazky po jinem odstipnuti
if (mysql_result($karta1,0,22)=="ANO" and mysql_result($karta1,0,20)<>"" and (@$celkhod<>"" or @$celkmin<>"") and mysql_num_rows(@$contdef)=="" and $odchodukon<>0) {
if (@$_POST["tlacitko".$zaznamu]=="") {?>
<tr bgcolor=#99FBC5><td align=center><input type="submit" name=tlacitko<?echo@$zaznamu;?> value="-" style=width:100%></td>
<td><select name="id_ukonu<?echo@$zaznamu;?>" onchange=submit(this)><? if (@$_POST["id_ukonu".$zaznamu]<>"") {?><option <?if (@$_POST["id_ukonu".$zaznamu]==1) {?>style=background-color:#99FBC5<?}?> value="<?echo $id=@$_POST["id_ukonu".$zaznamu];?>"><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?}?>
<option value=1 style=background-color:#99FBC5>odpracované hodiny</option>
<?@$datas1 = mysql_query("select * from ukony where stav ='Aktivní' and id<>'1' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select>

<? //práce na jiném støedisku
if (StrPos (" " . @$nazevstr, "støedisku")) {?><select name="stredisko<?echo@$zaznamu;?>"><?if (@$_POST["stredisko".$zaznamu]) {?><option><?echo @$_POST["stredisko".$zaznamu];?></option><?}?>
<option><?echo mysql_result($data1,0,17);?></option><?include ("./"."dbconnect.php");
@$datas1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datas1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$_POST["stredisko".$zaznamu]<>mysql_result($datas1,@$cykl,1)) {?><option><?echo mysql_result($datas1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select><?}?>

</td>
<td align=center><?@$casti=explode(":", mysql_result($karta1,0,20));@$hod=$casti[0];@$min=$casti[1];

if (@$celkhod>@$hod or (@$celkhod==@$hod and @$celkmin>=@$min)) {@$hodin=$casti[0];@$minut=$casti[1];}    //  navrh odpracovaneho casu
else {
if (@$celkhod==@$hod) {
	if (@$celkmin>=15 and @$min==45)	{echo @$celkhod.":15";}if (@$celkmin<15 and @$min==45)	{@$hodin=@$celkhod-1;@$minut=45;}
	if (@$celkmin>=0 and (@$min==30 or @$min==15 or @$min=="00"))	{@$hodin=@$celkhod;@$minut="00";}}
if (@$celkhod<@$hod) {
	if (@$celkmin>=45 and (@$min==45 or @$min==15))	{@$hodin=@$celkhod;@$minut=45;}if (@$celkmin<45 and @$celkmin>=15 and (@$min==45 or @$min==15))	{@$hodin=@$celkhod;@$minut=15;}if (@$celkmin<15 and (@$min==45 or @$min==15))	{@$hodin=@$celkhod-1;@$minut=45;}
	if (@$celkmin>=30 and (@$min==30 or @$min=="00"))	{@$hodin=@$celkhod;@$minut=30;}if (@$celkmin<30 and (@$min==30 or @$min=="00"))	{@$hodin=@$celkhod;@$minut="00";}}
}?>
<select size="1" name="prhodin<?echo@$zaznamu;?>">
<? if (@$_POST["prhodin".$zaznamu]<>"") {?><option <?if (@$_POST["prhodin".$zaznamu]==@$hodin) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prhodin".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo@$hodin;?></option><?}?>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="prminut<?echo@$zaznamu;?>"><? if (@$_POST["prminut".$zaznamu]<>"") {?><option <?if (@$_POST["prminut".$zaznamu]==@$minut) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prminut".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo@$minut;?></option><?}?>
<option>00</option><option>15</option><option>30</option><option>45</option><option>52.5</option></select>
</td><td><input name="zpoznamka<?echo@$zaznamu;?>" type="text" value="<?echo @$_POST["zpoznamka".$zaznamu];?>" style=width:250px style=background-color:#99FBC5></td>
</tr><?@$zaznamu++;} else {?><input name=tlacitko<?echo@$zaznamu++;?> type="hidden" value="-"><?}?>

<?
if (@$_POST["tlacitko".$zaznamu]=="") {
if (@$hodin<@$hod or (@$hodin==@$hod and @$minut-@$min<0)) {                 //navrh jineho odchodu
?><tr bgcolor=#99FBC5><td align=center><input type="submit" name=tlacitko<?echo@$zaznamu;?> value="-" style=width:100%></td>
<td><select name="id_ukonu<?echo@$zaznamu;?>" onchange=submit(this)>
<?if (@$_POST["id_ukonu".$zaznamu]<>"") {?><option <?if (@$_POST["id_ukonu".$zaznamu]==$odchodukon) {?>style="background-color:#99FBC5"<?}?> value="<?echo $id=@$_POST["id_ukonu".$zaznamu];?>"><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?}?>
<option value=<?echo $odchodukon;?> style=background-color:#99FBC5 ><?echo mysql_result(mysql_query("select nazev from ukony where id='$odchodukon'"),0,0);?></option>
<?@$datas1 = mysql_query("select * from ukony where stav ='Aktivní' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select>

<? //práce na jiném støedisku
if (StrPos (" " . @$nazevstr, "støedisku")) {?><select name="stredisko<?echo@$zaznamu;?>"><?if (@$_POST["stredisko".$zaznamu]) {?><option><?echo @$_POST["stredisko".$zaznamu];?></option><?}?>
<option><?echo mysql_result($data1,0,17);?></option><?include ("./"."dbconnect.php");
@$datas1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datas1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$_POST["stredisko".$zaznamu]<>mysql_result($datas1,@$cykl,1)) {?><option><?echo mysql_result($datas1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select><?}?>

</td><?

$prhodin=@$hod-@$hodin;@$prminut=@$min-@$minut;
if (@$prminut<0) {@$prhodin=@$prhodin-1;@$prminut=60+@$prminut;}
if (@$prhodin<10) {@$prhodin="0".@$prhodin;}if (@$prminut<10) {@$prminut="00";}

?><td align=center><select size="1" name="prhodin<?echo@$zaznamu;?>">
<? if (@$_POST["prhodin".$zaznamu]<>"") {?><option <?if (@$_POST["prhodin".$zaznamu]==@$prhodin) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prhodin".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo @$prhodin;?></option><?}?>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="prminut<?echo@$zaznamu;?>">
<? if (@$_POST["prminut".$zaznamu]<>"") {?><option <?if (@$_POST["prminut".$zaznamu]==@$prminut) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prminut".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo @$prminut;?></option><?}?>
<option>00</option><option>15</option><option>30</option><option>45</option><option>52.5</option></select></td>
<td><input name="zpoznamka<?echo@$zaznamu;?>" type="text" value="<?echo @$_POST["zpoznamka".$zaznamu];?>" style=width:250px style=background-color:#99FBC5></td>
</tr><?@$zaznamu++;}



if (@$celkhod>@$hod or (@$celkhod==@$hod and @$celkmin-@$min>=30)) {                  //navrh nadpracovaneho casu / prescasu jeste tesne pred odchodem na dovolenou
?><tr bgcolor=#99FBC5><td align=center><input type="submit" name=tlacitko<?echo@$zaznamu;?> value="-" style=width:100%></td>
<td><select name="id_ukonu<?echo@$zaznamu;?>" onchange=submit(this)>
<?if (mysql_result($karta1,0,18)=="T") {if (@$_POST["id_ukonu".$zaznamu]<>"") {?><option <?if (@$_POST["id_ukonu".$zaznamu]==30) {?>style="background-color:#99FBC5"<?}?> value="<?echo $id=@$_POST["id_ukonu".$zaznamu];?>"><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?}?>
<option value=30 style=background-color:#99FBC5 >+ nadpracováno</option><?}
if (mysql_result($karta1,0,18)=="D") {if (@$_POST["id_ukonu".$zaznamu]<>"") {?><option <?if (@$_POST["id_ukonu".$zaznamu]==29) {?>style=background-color:#99FBC5<?}?> value="<?echo $id=@$_POST["id_ukonu".$zaznamu];?>"><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?}?>
<option value=29 style=background-color:#99FBC5 >+ pøesèas</option><?}
@$datas1 = mysql_query("select * from ukony where stav ='Aktivní' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select>

<? //práce na jiném støedisku
if (StrPos (" " . @$nazevstr, "støedisku")) {?><select name="stredisko<?echo@$zaznamu;?>"><?if (@$_POST["stredisko".$zaznamu]) {?><option><?echo @$_POST["stredisko".$zaznamu];?></option><?}?>
<option><?echo mysql_result($data1,0,17);?></option><?include ("./"."dbconnect.php");
@$datas1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datas1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$_POST["stredisko".$zaznamu]<>mysql_result($datas1,@$cykl,1)) {?><option><?echo mysql_result($datas1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select><?}?>

</td><?
if (@$celkhod>@$hodin and @$celkmin>=@$minut) {$prhodin=@$celkhod-@$hodin;	if (@$celkmin-@$minut>=30) {@$prminut=30;}	if (@$celkmin-@$minut<30) {@$prminut="00";}}
if (@$celkhod>@$hodin and @$celkmin<@$minut) {$prhodin=@$celkhod-@$hodin-1;@$prminut=60+@$celkmin-@$minut;if (@$prminut>30) {@$prminut=30;} else {@$prminut="00";}}
if (@$celkhod==@$hodin and @$celkmin-@$minut>=30) {$prhodin=@$celkhod-@$hodin;@$prminut=30;}
if (@$prhodin<10) {@$prhodin="0".@$prhodin;}
?><td align=center><select size="1" name="prhodin<?echo@$zaznamu;?>">
<? if (@$_POST["prhodin".$zaznamu]<>"") {?><option <?if (@$_POST["prhodin".$zaznamu]==@$prhodin) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prhodin".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo @$prhodin;?></option><?}?>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="prminut<?echo@$zaznamu;?>">
<? if (@$_POST["prminut".$zaznamu]<>"") {?><option <?if (@$_POST["prminut".$zaznamu]==@$prminut) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prminut".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo @$prminut;?></option><?}?>
<option>00</option><option>15</option><option>30</option><option>45</option><option>52.5</option></select></td>
<td><input name="zpoznamka<?echo@$zaznamu;?>" type="text" value="<?echo @$_POST["zpoznamka".$zaznamu];?>" style=width:250px style=background-color:#99FBC5></td>
</tr><?@$zaznamu++;}} else {?><input name=tlacitko<?echo@$zaznamu++;?> type="hidden" value="-"><?}

}










 //tvorit navrh dochazky po normalnim odstupnuti
if (mysql_result($karta1,0,22)=="ANO" and mysql_result($karta1,0,20)<>"" and (@$celkhod<>"" or @$celkmin<>"") and mysql_num_rows(@$contdef)=="" and $odchodukon==0) {  //tvorit navrh dochazky po normalnim odstupnutiif (@$_POST["tlacitko".$zaznamu]=="" and $cdne<>6 and @$cdne<>0) {?>
<tr bgcolor=#99FBC5><td align=center><input type="submit" name=tlacitko<?echo@$zaznamu;?> value="-" style=width:100%></td>
<td><select name="id_ukonu<?echo@$zaznamu;?>" onchange=submit(this)><? if (@$_POST["id_ukonu".$zaznamu]<>"") {?><option <?if (@$_POST["id_ukonu".$zaznamu]==1) {?>style=background-color:#99FBC5<?}?> value="<?echo $id=@$_POST["id_ukonu".$zaznamu];?>"><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?}?>
<option value=1 style=background-color:#99FBC5>odpracované hodiny</option>
<?@$datas1 = mysql_query("select * from ukony where stav ='Aktivní' and id<>'1' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select>

<? //práce na jiném støedisku
if (StrPos (" " . @$nazevstr, "støedisku")) {?><select name="stredisko<?echo@$zaznamu;?>"><?if (@$_POST["stredisko".$zaznamu]) {?><option><?echo @$_POST["stredisko".$zaznamu];?></option><?}?>
<option><?echo mysql_result($data1,0,17);?></option><?include ("./"."dbconnect.php");
@$datas1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datas1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$_POST["stredisko".$zaznamu]<>mysql_result($datas1,@$cykl,1)) {?><option><?echo mysql_result($datas1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select><?}?>

</td>
<td align=center><?@$casti=explode(":", mysql_result($karta1,0,20));@$hod=$casti[0];@$min=$casti[1];

if (@$celkhod>@$hod or (@$celkhod==@$hod and @$celkmin>=@$min)) {@$hodin=$casti[0];@$minut=$casti[1];}    //  navrh odpracovaneho casu
else {
if (@$celkhod==@$hod) {	if (@$celkmin>=15 and @$min==45)	{echo @$celkhod.":15";}if (@$celkmin<15 and @$min==45)	{@$hodin=@$celkhod-1;@$minut=45;}
	if (@$celkmin>=0 and (@$min==30 or @$min==15 or @$min=="00"))	{@$hodin=@$celkhod;@$minut="00";}}
if (@$celkhod<@$hod) {
	if (@$celkmin>=45 and (@$min==45 or @$min==15))	{@$hodin=@$celkhod;@$minut=45;}if (@$celkmin<45 and @$celkmin>=15 and (@$min==45 or @$min==15))	{@$hodin=@$celkhod;@$minut=15;}if (@$celkmin<15 and (@$min==45 or @$min==15))	{@$hodin=@$celkhod-1;@$minut=45;}
	if (@$celkmin>=30 and (@$min==30 or @$min=="00"))	{@$hodin=@$celkhod;@$minut=30;}if (@$celkmin<30 and (@$min==30 or @$min=="00"))	{@$hodin=@$celkhod;@$minut="00";}}
}?>
<select size="1" name="prhodin<?echo@$zaznamu;?>">
<? if (@$_POST["prhodin".$zaznamu]<>"") {?><option <?if (@$_POST["prhodin".$zaznamu]==@$hodin) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prhodin".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo@$hodin;?></option><?}?>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="prminut<?echo@$zaznamu;?>"><? if (@$_POST["prminut".$zaznamu]<>"") {?><option <?if (@$_POST["prminut".$zaznamu]==@$minut) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prminut".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo@$minut;?></option><?}?>
<option>00</option><option>15</option><option>30</option><option>45</option><option>52.5</option></select>
</td><td><input name="zpoznamka<?echo@$zaznamu;?>" type="text" value="<?echo @$_POST["zpoznamka".$zaznamu];?>" style=width:250px style=background-color:#99FBC5></td>
</tr><?@$zaznamu++;} else {?><input name=tlacitko<?echo@$zaznamu++;?> type="hidden" value="-"><?}?>

<?
if (@$_POST["tlacitko".$zaznamu]=="" and (@$celkhod>@$hod or (@$celkhod==@$hod and @$celkmin-@$min>=30))) {
if (@$celkhod>@$hod or (@$celkhod==@$hod and @$celkmin-@$min>=30)) {                  //navrh nadpracovaneho casu / prescasu?><tr bgcolor=#99FBC5><td align=center><input type="submit" name=tlacitko<?echo@$zaznamu;?> value="-" style=width:100%></td>
<td><select name="id_ukonu<?echo@$zaznamu;?>" onchange=submit(this)>
<?if (mysql_result($karta1,0,18)=="T") {if (@$_POST["id_ukonu".$zaznamu]<>"") {?><option <?if (@$_POST["id_ukonu".$zaznamu]==30) {?>style="background-color:#99FBC5"<?}?> value="<?echo $id=@$_POST["id_ukonu".$zaznamu];?>"><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?}?>
<option value=30 style=background-color:#99FBC5 >+ nadpracováno</option><?}
if (mysql_result($karta1,0,18)=="D") {if (@$_POST["id_ukonu".$zaznamu]<>"") {?><option <?if (@$_POST["id_ukonu".$zaznamu]==29) {?>style=background-color:#99FBC5<?}?> value="<?echo $id=@$_POST["id_ukonu".$zaznamu];?>"><?echo  @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?}?>
<option value=29 style=background-color:#99FBC5 >+ pøesèas</option><?}
@$datas1 = mysql_query("select * from ukony where stav ='Aktivní' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select>

<? //práce na jiném støedisku
if (StrPos (" " . @$nazevstr, "støedisku")) {?><select name="stredisko<?echo@$zaznamu;?>"><?if (@$_POST["stredisko".$zaznamu]) {?><option><?echo @$_POST["stredisko".$zaznamu];?></option><?}?>
<option><?echo mysql_result($data1,0,17);?></option><?include ("./"."dbconnect.php");
@$datas1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datas1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$_POST["stredisko".$zaznamu]<>mysql_result($datas1,@$cykl,1)) {?><option><?echo mysql_result($datas1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select><?}?>

</td><?
if (@$celkhod>@$hodin and @$celkmin>=@$minut) {$prhodin=@$celkhod-@$hodin;	if (@$celkmin-@$minut>=30) {@$prminut=30;}	if (@$celkmin-@$minut<30) {@$prminut="00";}}
if (@$celkhod>@$hodin and @$celkmin<@$minut) {$prhodin=@$celkhod-@$hodin-1;@$prminut=60+@$celkmin-@$minut;if (@$prminut>30) {@$prminut=30;} else {@$prminut="00";}}
if (@$celkhod==@$hodin and @$celkmin-@$minut>=30) {$prhodin=@$celkhod-@$hodin;@$prminut=30;}
if (@$prhodin<10) {@$prhodin="0".@$prhodin;}
?><td align=center><select size="1" name="prhodin<?echo@$zaznamu;?>">
<? if (@$_POST["prhodin".$zaznamu]<>"") {?><option <?if (@$_POST["prhodin".$zaznamu]==@$prhodin) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prhodin".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo @$prhodin;?></option><?}?>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="prminut<?echo@$zaznamu;?>">
<? if (@$_POST["prminut".$zaznamu]<>"") {?><option <?if (@$_POST["prminut".$zaznamu]==@$prminut) {?>style=background-color:#99FBC5<?}?> ><?echo @$_POST["prminut".$zaznamu];?></option><?} else {?><option style=background-color:#99FBC5><?echo @$prminut;?></option><?}?>
<option>00</option><option>15</option><option>30</option><option>45</option><option>52.5</option></select></td>
<td><input name="zpoznamka<?echo@$zaznamu;?>" type="text" value="<?echo @$_POST["zpoznamka".$zaznamu];?>" style=width:250px style=background-color:#99FBC5></td>
</tr><?@$zaznamu++;}} else {?><input name=tlacitko<?echo@$zaznamu++;?> type="hidden" value="-"><?}

}// konec návrhu normalni docházky







// vypis existujicich zaznamu
if ( @mysql_num_rows(@$contdef)<>"" and @$firstload==""){while ( @$zaznamu-1 < mysql_num_rows($contdef) ): @$nazevstr="";

?><input name=tlacitko<?echo@$zaznamu;?> type="hidden" value="+"><input name="firstload" type="hidden" value="A">
<tr><td align=center><input type="submit" name=tlacitko<?echo@$zaznamu;?> value="-" style=width:100%></td>
<td>
<select name="id_ukonu<?echo@$zaznamu;?>" onchange=submit(this)><option value="<?echo $id=mysql_result($contdef,@$zaznamu-1,3);?>"><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option>
<?@$datas1 = mysql_query("select * from ukony where stav ='Aktivní' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select>

<? //práce na jiném støedisku
if (StrPos (" " . @$nazevstr, "støedisku")) {?><select name="stredisko<?echo@$zaznamu;?>"><option><?echo mysql_result($contdef,@$zaznamu-1,7);?></option>
<option><?echo mysql_result($data1,0,17);?></option><?include ("./"."dbconnect.php");
@$datas1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datas1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$_POST["stredisko".$zaznamu]<>mysql_result($datas1,@$cykl,1)) {?><option><?echo mysql_result($datas1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select><?}?>
</td>

<?@$casti=explode(":", mysql_result($contdef,@$zaznamu-1,2));@$loadhod=$casti[0];@$loadmin=$casti[1];?>
<td align=center><select size="1" name="prhodin<?echo@$zaznamu;?>"><option><?echo @$loadhod;?></option>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="prminut<?echo@$zaznamu;?>"><option><?echo @$loadmin;?></option><option>00</option><option>15</option><option>30</option><option>45</option><option>52.5</option></select>
</td>

<td><input name="zpoznamka<?echo@$zaznamu;?>" type="text" value="<?echo mysql_result($contdef,@$zaznamu-1,10);?>" style=width:250px ></td></tr><?
@$zaznamu++;endwhile;
}// konec vypisu existujicich zaznamu








// další tlaèítka
while (@$_POST["tlacitko".$zaznamu]<>""):  @$nazevstr="";

if (@$_POST["tlacitko".$zaznamu]=="+") {?><input name=tlacitko<?echo@$zaznamu;?> type="hidden" value="+">
<tr><td align=center><input type="submit" name=tlacitko<?echo@$zaznamu;?> value="-" style=width:100%></td>
<td>
<select name="id_ukonu<?echo@$zaznamu;?>" onchange=submit(this)><?if (@$_POST["id_ukonu".$zaznamu]) {?><option value="<?echo $id=@$_POST["id_ukonu".$zaznamu];?>"><?echo @$nazevstr=mysql_result(mysql_query("select nazev from ukony where id='$id'"),0,0);?></option><?}?>
<?@$datas1 = mysql_query("select * from ukony where stav ='Aktivní' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select>

<? //práce na jiném støedisku
if (StrPos (" " . @$nazevstr, "støedisku")) {?><select name="stredisko<?echo@$zaznamu;?>"><?if (@$_POST["stredisko".$zaznamu]) {?><option><?echo @$_POST["stredisko".$zaznamu];?></option><?}?>
<option><?echo mysql_result($data1,0,17);?></option><?include ("./"."dbconnect.php");
@$datas1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datas1);@$cykl=0;
while (@$cykl<@$pocet):
if (@$_POST["stredisko".$zaznamu]<>mysql_result($datas1,@$cykl,1)) {?><option><?echo mysql_result($datas1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select><?}?>

</td>

<td align=center><select size="1" name="prhodin<?echo@$zaznamu;?>"><?if (@$_POST["prhodin".$zaznamu]) {?><option><?echo @$_POST["prhodin".$zaznamu];?></option><?}?>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="prminut<?echo@$zaznamu;?>"><?if (@$_POST["prminut".$zaznamu]) {?><option><?echo @$_POST["prminut".$zaznamu];?></option><?}?><option>00</option><option>15</option><option>30</option><option>45</option><option>52.5</option></select>
</td>

<td><input name="zpoznamka<?echo@$zaznamu;?>" type="text" value="<?echo @$_POST["zpoznamka".$zaznamu];?>" style=width:250px ></td></tr><?}
if (@$_POST["tlacitko".$zaznamu]=="-") {?><input name=tlacitko<?echo@$zaznamu;?> type="hidden" value="-"><?}?>
<?@$zaznamu++;endwhile;

// pøídavné tlaèítko
?>
<tr><td align=center><input type="submit" name=tlacitko<?echo@$zaznamu;?> value="+" style=width:100%></td><td colspan=3></td></tr>

<tr><td></td><td  style="margin-right: 0; margin-bottom: 10" colspan=3 align=center ><br />
<select size="1" name="stlacitko">
  <option >Uložit tyto Záznamy pro zvolený datum</option>
  <option >Uložit tyto Záznamy pro tento týden (v Akt. Mìsíci)</option>
  <option >Uložit tyto Záznamy pro tento týden (v Akt. Mìsíci) i s víkendem</option>
  <option >Uložit tyto Záznamy od zaèátku mìsíce do zvoleného datumu (vèetnì)</option>
  <option >Uložit tyto Záznamy od zaèátku mìsíce do zvoleného datumu (vèetnì) i s víkendy</option>
  <option >Uložit tyto Záznamy od zvoleného datumu (vèetnì) konce mìsíce</option>
  <option >Uložit tyto Záznamy od zvoleného datumu (vèetnì) konce mìsíce i s víkendy</option>
  <option >Uložit tyto Záznamy na celý mìsíc</option>
  <option >Uložit tyto Záznamy na celý mìsíc i s víkendy</option>
</select>
<input type="submit" name=tlacitko value="Uložit">


</td></tr>

</table>
</table>
</center>
</form></body>

</html>