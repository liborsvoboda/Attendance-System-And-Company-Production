<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];

@$stav=@$_POST["stav"];if (@$stav=="A") {$filtr="where datumout='0000-00-00'";} if (@$stav=="N") {$filtr="where datumout<>'0000-00-00'";} if (@$stav=="") {$filtr="where datumout<>''";}

@$cislo=@$_POST["cislo"];
@$oscislo=@$_POST["oscislo"];
@$oscisloold=@$_POST["oscisloold"];
@$titul=@$_POST["titul"];
@$jmeno=@$_POST["jmeno"];
@$prijmeni=@$_POST["prijmeni"];
@$rodnecislo=@$_POST["rodnecislo"];
@$pohlavi=@$_POST["pohlavi"];
@$datumnar=@$_POST["datumnar"];
@$datumin=@$_POST["datumin"];$casti = explode(".", $datumin);$datumin = $casti[2]."-".$casti[1]."-".$casti[0];
@$datumout=@$_POST["datumout"];$casti = explode(".", $datumout);$datumout   = $casti[2]."-".$casti[1]."-".$casti[0];
@$datumins=@$_POST["datumins"];if (@$datumins=="Datum od") {@$datumins="";}$casti = explode(".", $datumins);$datumins   = $casti[2]."-".$casti[1]."-".$casti[0];
@$datumouts=@$_POST["datumouts"];if (@$datumouts=="Dosud") {@$datumouts="";}$casti = explode(".", $datumouts);$datumouts   = $casti[2]."-".$casti[1]."-".$casti[0];
@$ulice=@$_POST["ulice"];
@$mesto=@$_POST["mesto"];
@$psc=@$_POST["psc"];
@$telefon=@$_POST["telefon"];
@$email=@$_POST["email"];
@$kategorie=@$_POST["kategorie"];
if (@$_POST["pruchod"]=="on"){@$pruchod="ANO";} else {@$pruchod="NE";}
if (@$_POST["manager"]=="on"){@$manager="ANO";} else {@$manager="NE";}
@$stredisko=@$_POST["stredisko"];
if (@$_POST["vedouci"]=="on") {$vedouci="A";} else {@$vedouci="N";}
@$cip=@$_POST["cip"];
if (@$_POST["navrh"]=="on") {@$navrh="ANO";} else {@$navrh="NE";}
if (@$_POST["export"]=="on") {@$export="ANO";} else {@$export="NE";}
@$hodiny=@$_POST["hodiny"];@$minuty=@$_POST["minuty"];$pracdoba=@$hodiny.":".@$minuty;
@$vnavrh=@$_POST["vnavrh"];
@$smena=@$_POST["smena"];
if (@$_POST["obed"]=="on") {@$obed="ANO";} else {@$obed="NE";}

@$turn=@$_POST["turn"];@$turnikety=",";@$cykl=0;while (@$turn[@$cykl]<>""):@$turnikety.=@$turn[@$cykl].",";@$cykl++;endwhile;

@$firstload=@$_POST["firstload"];if (@$oscislo<>@$oscisloold and @$oscisloold<>"") {@$firstload="";@$load=1;while ($_POST["tlacitko".@$load]<>""):unset($_POST["tlacitko".@$load]);@$load++;endwhile;}
@$zaznam=1;


include ("./"."dbconnect.php");  // dotaz na stredisko
$acessline=mysql_result(mysql_query("select sprava_str from login where jmeno='$loginname'"),0,0);$acess=explode(",",$acessline);
@$cykl=0;$dotazline="and (";
while ($acess[$cykl]<>""):
$dotazline.="stredisko='".$acess[$cykl]."'";if ($acess[$cykl+1]<>"") {$dotazline.=" or ";} else {$dotazline.=" ) ";}
@$cykl++;endwhile;






if (@$oscislo<>"" and @$jmeno<>"" and @$prijmeni<>""  and @$datumin<>"" and @$tlacitko=="Uloûit NovÈho ZamÏstnance") {
include ("./"."dbconnect.php");$controlnumber=$cislo-1;$control= mysql_num_rows(mysql_query("select hodnota from ciselnarada where hodnota='$controlnumber' and stav='A'"));
if (@$control==true) {mysql_query ("update ciselnarada set hodnota='$cislo' where stav='A' ")or Die(MySQL_Error());}

@$load=1;while ($_POST["stredisko".@$load]<>""):
@$value1=$_POST["stredisko".@$load];
@$casti = explode(".", $_POST["datumins".@$load]);@$value2   = $casti[2]."-".$casti[1]."-".$casti[0];
@$casti = explode(".", $_POST["datumouts".@$load]);@$value3   = $casti[2]."-".$casti[1]."-".$casti[0];
mysql_query ("INSERT INTO zam_strediska (osobni_cislo,stredisko,datumod,datumdo,vlozil,datumvkladu) VALUES('$oscislo','$value1','$value2','$value3','$loginname','$dnes')") or Die(MySQL_Error());
@$load++;endwhile;

$casti = explode(".", $datumnar);$datumnar = $casti[2]."-".$casti[1]."-".$casti[0];
if (@$_POST["ukol"]=="on") {@$_POST["ukol"]="ANO";} else {@$_POST["ukol"]="NE";}
mysql_query ("INSERT INTO zamestnanci (osobni_cislo,titul,jmeno,prijmeni,rodnecislo,ulice,mesto,psc,telefon,mail,datumin,datumout,vlozil,datumvkladu,vedouci,kategorie,pracovni_doba,export,navrh,id_vnavrhu,smena,stredisko,turnikety,jen_pruchod,obed,manager,narozen,pohlavi,obcanstvi,pojistovna,czisco,ukol,obsazeni,kodms) VALUES('$oscislo','$titul','$jmeno','$prijmeni','$rodnecislo','$ulice','$mesto','$psc','$telefon','$email','$datumin','$datumout','$loginname','$dnes','$vedouci','$kategorie','$pracdoba','$export','$navrh','$vnavrh','$smena','$value1','".securesql($turnikety)."','".securesql($pruchod)."','".securesql($obed)."','".securesql($manager)."','".securesql($datumnar)."','".securesql($pohlavi)."','".securesql(@$_POST["obcanstvi"])."','".securesql(@$_POST["pojistovna"])."','".securesql(@$_POST["czisco"])."','".securesql(@$_POST["ukol"])."','".securesql(@$_POST["obsazeni"])."','".securesql(@$_POST["kodms"])."')") or Die(MySQL_Error());
mysql_query ("INSERT INTO cipy (osobni_cislo,cip,platnostod,vlozil,datumvkladu) VALUES('$oscislo','$cip','$datumin','$loginname','$dnes')") or Die(MySQL_Error());
mysql_query ("delete from zadost where cip = '$cip' ")or Die(MySQL_Error());?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>UloûenÌ NovÈho ZamÏstnance ProbÏhlo ⁄spÏönÏ</b></center></td></tr></table><?
@$tlacitko="";@$oscislo=""; @$jmeno="";@$prijmeni="";@$cip="";@$datumin="--";@$cislo="";@$titul="";@$rodnecislo="";@$datumout="--";@$ulice="";@$mesto="";@$psc="";@$telefon="";@$email="";@$kategorie="";@$stredisko="";@$vedouci="";$pracdoba="";@$firstload="";}






if (@$oscislo<>"" and @$jmeno<>"" and @$prijmeni<>"" and @$cip<>"" and @$datumin<>"" and @$tlacitko=="Uloûit OpravenÈho ZamÏstnance") {
include ("./"."dbconnect.php");$control= mysql_num_rows(mysql_query("select cip from cipy where cip='$cip' and osobni_cislo = '$oscislo' and platnostdo='0000-00-00'"));
$vnavrh=mysql_result(mysql_query("select id from ukony where id='$vnavrh'"),0,0);
$casti = explode(".", $datumnar);$datumnar = $casti[2]."-".$casti[1]."-".$casti[0];

if (@$_POST["ukol"]=="on") {@$_POST["ukol"]="ANO";} else {@$_POST["ukol"]="NE";}

if (@$control==true) {	mysql_query ("delete from zam_strediska where osobni_cislo = '$oscislo' ")or Die(MySQL_Error());
	@$load=1;while ($_POST["stredisko".@$load]<>""):
	@$value1=$_POST["stredisko".@$load];
	@$casti = explode(".", $_POST["datumins".@$load]);@$value2   = $casti[2]."-".$casti[1]."-".$casti[0];
	@$casti = explode(".", $_POST["datumouts".@$load]);@$value3   = $casti[2]."-".$casti[1]."-".$casti[0];
	mysql_query ("INSERT INTO zam_strediska (osobni_cislo,stredisko,datumod,datumdo,vlozil,datumvkladu) VALUES('$oscislo','$value1','$value2','$value3','$loginname','$dnes')") or Die(MySQL_Error());
	@$load++;endwhile;

	mysql_query ("update zamestnanci  set titul='$titul',jmeno='$jmeno',prijmeni='$prijmeni',rodnecislo='$rodnecislo',ulice='$ulice',mesto='$mesto',psc='$psc',telefon='$telefon',mail='$email',datumin='$datumin',datumout='$datumout', datumzmeny = '$dnes', zmenil ='$loginname', vedouci='$vedouci',kategorie='$kategorie',pracovni_doba='$pracdoba',export='$export',navrh='$navrh',id_vnavrhu='$vnavrh',smena='$smena',stredisko='$value1',turnikety='".securesql($turnikety)."',jen_pruchod='".securesql($pruchod)."',obed='".securesql($obed)."',manager='".securesql($manager)."',narozen='".securesql($datumnar)."',pohlavi='".securesql($pohlavi)."',obcanstvi='".securesql(@$_POST["obcanstvi"])."',pojistovna='".securesql(@$_POST["pojistovna"])."',czisco='".securesql(@$_POST["czisco"])."',ukol='".securesql(@$_POST["ukol"])."',obsazeni='".securesql(@$_POST["obsazeni"])."',kodms='".securesql(@$_POST["kodms"])."' where osobni_cislo = '$oscislo' ")or Die(MySQL_Error());
if (@$datumout<>"--") {if (mysql_num_rows(mysql_query("select id from zpracovana_dochazka where datum >'".securesql($datumout)."' and osobni_cislo='".securesql($oscislo)."'"))) {
?><script type="text/javascript">
alert("Pozor ZamÏstnanec: <?echo $oscislo;?> m· zadanou doch·zku p¯esahujÌcÌ vaöe datum ukonËenÌ: <?echo $datumout;?>");
</script><?}
	mysql_query ("update cipy set platnostdo='$datumout' where osobni_cislo = '$oscislo' and platnostdo='0000-00-00'") or Die(MySQL_Error());mysql_query ("update zam_strediska set datumdo='$datumout' where osobni_cislo = '$oscislo' and datumdo='0000-00-00'") or Die(MySQL_Error());}

} else {
	mysql_query ("delete from zam_strediska where osobni_cislo = '$oscislo' ")or Die(MySQL_Error());
	@$load=1;while ($_POST["stredisko".@$load]<>""):
	@$value1=$_POST["stredisko".@$load];
	@$casti = explode(".", $_POST["datumins".@$load]);@$value2   = $casti[2]."-".$casti[1]."-".$casti[0];
	@$casti = explode(".", $_POST["datumouts".@$load]);@$value3   = $casti[2]."-".$casti[1]."-".$casti[0];
    if ($_POST["datumouts".(@$load+1)]=="" and $_POST["datumouts".@$load]<>"") {mysql_query ("delete from zpracovana_dochazka  where osobni_cislo = '$oscislo' and datum>'$value3' ")or Die(MySQL_Error());}
	mysql_query ("INSERT INTO zam_strediska (osobni_cislo,stredisko,datumod,datumdo,vlozil,datumvkladu) VALUES('$oscislo','$value1','$value2','$value3','$loginname','$dnes')") or Die(MySQL_Error());
	@$load++;endwhile;
	mysql_query ("update zamestnanci  set titul='$titul',jmeno='$jmeno',prijmeni='$prijmeni',rodnecislo='$rodnecislo',ulice='$ulice',mesto='$mesto',psc='$psc',telefon='$telefon',mail='$email',datumin='$datumin',datumout='$datumout', datumzmeny = '$dnes', zmenil ='$loginname', vedouci='$vedouci',kategorie='$kategorie',pracovni_doba='$pracdoba',export='$export',navrh='$navrh',id_vnavrhu='$vnavrh',smena='$smena',stredisko='$value1',turnikety='".securesql($turnikety)."',jen_pruchod='".securesql($pruchod)."',obed='".securesql($obed)."',manager='".securesql($manager)."',narozen='".securesql($datumnar)."',pohlavi='".securesql($pohlavi)."',obcanstvi='".securesql(@$_POST["obcanstvi"])."',pojistovna='".securesql(@$_POST["pojistovna"])."',czisco='".securesql(@$_POST["czisco"])."',ukol='".securesql(@$_POST["ukol"])."',obsazeni='".securesql(@$_POST["obsazeni"])."',kodms='".securesql(@$_POST["kodms"])."' where osobni_cislo = '$oscislo' ")or Die(MySQL_Error());
	if (@$datumout<>"--") {		mysql_query ("update cipy set platnostdo='$datumout' where osobni_cislo = '$oscislo' and platnostdo='0000-00-00'") or Die(MySQL_Error());}
	if (@$datumout=="--") {mysql_query ("update cipy set platnostdo='$dnes' where osobni_cislo = '$oscislo' and platnostdo='0000-00-00'") or Die(MySQL_Error());}
	mysql_query ("INSERT INTO cipy (osobni_cislo,cip,platnostod,platnostdo,vlozil,datumvkladu) VALUES('$oscislo','$cip','$datumin','$datumout','$loginname','$dnes')") or Die(MySQL_Error());
    mysql_query ("delete from zadost where cip = '$cip' ")or Die(MySQL_Error());
}?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>UloûenÌ UpravenÈho ZamÏstnance ProbÏhlo ⁄spÏönÏ</b></center></td></tr></table><?
@$tlacitko="";@$firstload="";}






if (@$tlacitko=="Uloûit Kartu VybranÈho ZamÏstnance") {
include ("./"."dbconnect.php");mysql_query ("update zamestnanci  set id_vnavrhu='$vnavrh',navrh='$navrh' where osobni_cislo = '$oscislo' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>UloûenÌ Karty VybranÈho ZamÏstnance ProbÏhlo ⁄spÏönÏ</b></center></td></tr></table><?
@$menu="";@$oscislo="";@$tlacitko="";@$firstload="";}



if (@$oscislo<>"" and @$tlacitko=="Odstranit VybranÈho ZamÏstnance") {
include ("./"."dbconnect.php");mysql_query ("delete from zamestnanci where osobni_cislo = '$oscislo' ")or Die(MySQL_Error());
mysql_query ("delete from cipy where osobni_cislo = '$oscislo' ")or Die(MySQL_Error());
mysql_query ("delete from zam_strediska where osobni_cislo = '$oscislo' ")or Die(MySQL_Error());?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>OdstranÏnÌ VybranÈho ZamÏstnance ProbÏhlo ⁄spÏönÏ</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$oscislo="";@$firstload="";}


?>

<form action="hlavicka.php?akce=<?echo base64_encode('Zamestnanci');?>" method=post>
<input name="oscisloold" type="hidden" value="<?echo@$oscislo;?>">

<h2><p align="center">Spr·va ZamÏstnanc˘:
<? if (StrPos (" " . $_SESSION["prava"], "Z") or StrPos (" " . $_SESSION["prava"], "z")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "Z")){?>
   <?if (@$menu<>"ZaloûenÌ NovÈho ZamÏstnance"){?><option>ZaloûenÌ NovÈho ZamÏstnance</option><?}?>
   <?if (@$menu<>"⁄prava ExistujÌcÌho ZamÏstnance"){?><option>⁄prava ExistujÌcÌho ZamÏstnance</option><?}?>
   <?if (@$menu<>"OdstranÏnÌ ExistujÌcÌho ZamÏstnance"){?><option>OdstranÏnÌ ExistujÌcÌho ZamÏstnance</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "Z") or StrPos (" " . $_SESSION["prava"], "z")){?>
   <?if (@$menu<>"Karta ZamÏstnance"){?><option>Karta ZamÏstnance</option><?}?>
   <?if (@$menu<>"P¯ehled ExistujÌcÌch ZamÏstnanc˘"){?><option>P¯ehled ExistujÌcÌch ZamÏstnanc˘</option><?}?>
   <?if (@$menu<>"Tisk ZamÏstnanc˘"){?><option>Tisk ZamÏstnanc˘</option><?}}?>


   </select> </p></h2>

<? if (!StrPos (" " . $_SESSION["prava"], "Z") and (!StrPos (" " . $_SESSION["prava"], "z")) ){?>Nem·te P¯Ìstupov· Pr·va<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "Z")){?>


<?if (@$menu=="ZaloûenÌ NovÈho ZamÏstnance"){$datumin="--";$datumout="--";?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr><td>Titul/PohlavÌ/ObËanstvÌ:</td><td colspan=2><input type="text" name=titul value="<?if (@$titul<>"") {echo@$titul;}?>" width="30%" >
<select size="1" name="pohlavi"><option>Muû</option><option>éena</option></select> <input name="obcanstvi" type="text" value="" size=20></td></tr>
<?include ("./"."dbconnect.php");@$data1 = mysql_query("select * from ciselnarada where stav='A' order by nazev,id ASC") or Die(MySQL_Error());
if (mysql_num_rows($data1)) {$cislo=(mysql_result($data1,0,3))+1;@$high=0;while (@$high<(mysql_result($data1,0,4)- StrLen(mysql_result($data1,0,3)))):  $cislo="0".$cislo;@$high++;endwhile;$value= mysql_result($data1,0,2).$cislo;} else {$value="";}?>
<input name="cislo" type="hidden" value="<?echo@$cislo;?>">
<tr><td>OsobnÌ »Ìslo:</td><td colspan=2><input type="text" name=oscislo value="<?echo@$value;?>" size="50" style=background-color:#F9C8C8 <?if (@$value<>"") {?>readonly=yes<?}?>></td></tr>
<tr><td>é·dost »ipu:</td><td colspan=2><select name=cip style=width:100%>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from zadost where cip<>'null' order by datum,cas,id ") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
$casti= explode("-", mysql_result($data1,@$cykl,2));$datumzadosti = $casti[2].".".$casti[1].".".$casti[0]." : ".mysql_result($data1,@$cykl,3);
?><option value="<?echo(mysql_result($data1,@$cykl,1));?>"><?echo(mysql_result($data1,@$cykl,1))." / ".$datumzadosti;?></option><?
@$cykl++;endwhile;?></select></td></tr>

<tr><td>JmÈno:</td><td colspan=2><input type="text" name=jmeno value="" size="50" style=background-color:#F9C8C8></td></tr>
<tr><td>P¯ÌjmenÌ:</td><td colspan=2><input type="text" name=prijmeni value="" size="50" style=background-color:#F9C8C8></td></tr>
<tr><td>PracovnÌ Doba (h/m):</td><td><select size="1" name="hodiny" style=background-color:#F9C8C8>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="minuty" style=background-color:#F9C8C8><option>00</option><option>15</option><option>30</option><option>45</option></select>
</td><td align=right>Export: <input name="export" type="checkbox" checked></td></tr>
<tr><td>Generovat N·vrh Doch.:<br />V˝chozÌ N·vrh: </td><td><input name="navrh" type="checkbox" checked>
<br /><select name="vnavrh"><option></option>
<?include ("./"."dbconnect.php");@$data1 = mysql_query("select * from ukony where stav ='AktivnÌ' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($data1)):
?><option value="<?echo(mysql_result($data1,@$cykl,0));?>"><?echo @mysql_result($data1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select></td>
<td align=center>SmÏna<br />
<select size="1" name="smena">
  <option>RannÌ</option>
  <option>OdpolednÌ</option>
  <option>NoËnÌ</option>
</select></td></tr>

<tr><td>ObsazenÌ/KodMS:</td><td><input name="obsazeni" type="text" value="" style=width:60%><input name="kodms" type="text" value="" style=width:40%></td><td align=right>⁄kol:<input name="ukol" type="checkbox"></td></tr>

<tr><td>RodnÈ »Ìslo/Datum Nar.:</td><td><input type="text" name=rodnecislo value="" style=width:50%;background-color:white>
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumnar" value="<?if (@$datumnar<>"--") {echo@$datumnar;} else {echo@$dnescs;}?>" style="width:28%" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumnar,'span_pokusnar','cpokus');"style="width:20%" ><SPAN ID="span_pokusnar">

</td><td align=right>VedoucÌ: <input name="vedouci" type="checkbox" ></td></tr>
<tr><td>Pojiöùovna/CZ-ISCO:</td><td colspan=2><input name="pojistovna" type="text" value="" style=width:50%><input name="czisco" type="text" value="" style=width:50%></td></tr>

<tr><td>Datum N·stupu:</td><SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><td colspan=2><input type="text" name="datumin" value="<?if (@$datumin<>"--") {echo@$datumin;} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumin,'span_pokus','cpokus');"style="width:28%" ><SPAN ID="span_pokus"> </td></tr>

<tr><td>Datum UkonËenÌ:</td><SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><td colspan=2><input type="text" name="datumout" value="<?if (@$datumout<>"--") {echo@$datumout;}?>" style="width:70%" ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumout,'span_pokusa','cpokus');"style="width:28%" ><SPAN ID="span_pokusa"> </td></tr>

<tr><td>Kategorie:</td><td colspan=2><select name=kategorie style=width:100%>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from kategorie order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?
@$cykl++;endwhile;?></select></td></tr>

<tr><td>St¯edisko (od/do):</td><td colspan=2 align=left><select name="stredisko<?echo@$zaznam;?>" >
<?if ($_POST["stredisko".@$zaznam]<>"") {echo"<option>".$_POST["stredisko".@$zaznam]."</option>";}
include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?
@$cykl++;endwhile;?></select>

<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumins<?echo@$zaznam;?>" value="<?if ($_POST["datumins".@$zaznam]<>"") {echo $_POST["datumins".@$zaznam];} else {echo"Datum od";}?>" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumins<?echo@$zaznam;?>,'span_pokus<?echo@$zaznam;?>','cpokus');" ><SPAN ID="span_pokus<?echo@$zaznam;?>">

<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumouts<?echo@$zaznam;?>" value="<?if ($_POST["datumouts".@$zaznam]<>"") {echo $_POST["datumouts".@$zaznam];}?>" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumouts<?echo@$zaznam;?>,'span_pokus<?echo@$zaznam;?>','cpokus');" ><SPAN ID="span_pokus<?echo@$zaznam;?>"><br />
<?@$zaznam++;

while ($_POST["tlacitko".@$zaznam]==" + "):?>
<input type=hidden name="tlacitko<?echo@$zaznam;?>" value=" + ">
<select name="stredisko<?echo@$zaznam;?>" >
<?if ($_POST["stredisko".@$zaznam]<>"") {echo"<option>".$_POST["stredisko".@$zaznam]."</option>";}
include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?
@$cykl++;endwhile;?></select>
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumins<?echo@$zaznam;?>" value="<?if ($_POST["datumins".@$zaznam]<>"") {echo $_POST["datumins".@$zaznam];} else {echo"Datum od";}?>" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumins<?echo@$zaznam;?>,'span_pokus<?echo@$zaznam;?>','cpokus');" ><SPAN ID="span_pokus<?echo@$zaznam;?>">
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumouts<?echo@$zaznam;?>" value="<?if ($_POST["datumouts".@$zaznam]<>"") {echo $_POST["datumouts".@$zaznam];}?>" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumouts<?echo@$zaznam;?>,'span_pokus<?echo@$zaznam;?>','cpokus');" ><SPAN ID="span_pokus<?echo@$zaznam;?>"><br />

<?@$zaznam++;endwhile;?>
<input type="submit" name="tlacitko<?echo@$zaznam++;?>" value=" + " style=width:25px>
</td></tr>
<tr bgcolor=#8BE00C><td>PovolenÈ Turnikety:<br />(bez doch·zky: <input name=pruchod type="checkbox">)</td><td colspan=2>
<select size="3" name="turn[]"  multiple="multiple" style=width:100%>
<?@$data5=mysql_query("select * from turnikety order by nazev,id");
@$turn=0;while(@$turn<mysql_num_rows($data5)):
echo"<option value='".mysql_result($data5,@$turn,0)."'>".mysql_result($data5,@$turn,1)."</option>";
@$turn++;endwhile;?></select></td></tr>
<tr bgcolor=#8BE00C><td>DotovanÈ ObÏdy: <input name="obed" type="checkbox" checked></td><td colspan=2>Manager: <input name="manager" type="checkbox"></td></tr>

<tr><td colspan=3 align=center bgcolor=#BFBFFF><br /><b>BydliötÏ</b></td></tr>
<tr bgcolor=#D7D7FF><td>Ulice:</td><td colspan=2><input type="text" name=ulice value="" size="50"></td></tr>
<tr bgcolor=#D7D7FF><td>MÏsto:</td><td colspan=2><input type="text" name=mesto value="" size="50"></td></tr>
<tr bgcolor=#D7D7FF><td>PS»:</td><td colspan=2><input type="text" name=psc value="" size="50"></td></tr>
<tr bgcolor=#D7D7FF><td>Telefon:</td><td colspan=2><input type="text" name=telefon value="" size="50"></td></tr>
<tr bgcolor=#D7D7FF><td>E-Mail:</td><td colspan=2><input type="text" name=email value="" size="50"></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uloûit NovÈho ZamÏstnance"></center><BR></td></tr><?}?>





<?if (@$menu=="⁄prava ExistujÌcÌho ZamÏstnance"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$menu?></b></center></td></tr>
<tr><td>OsobnÌ »Ìslo:</td><td colspan=2><select name=oscislo size="1" onchange=submit(this) style=size:100%>
<?if (@$oscislo<>""){include ("./"."dbconnect.php");@$data1 = mysql_query("select * from zamestnanci where osobni_cislo='$oscislo'") or Die(MySQL_Error());
?><option value="<?echo(mysql_result($data1,0,1));?>"><?echo(mysql_result($data1,0,4)." ".mysql_result($data1,0,3)." ".mysql_result($data1,0,2)." / ".mysql_result($data1,0,1));?></option><?} else {?><option></option><?}
include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from zamestnanci order by prijmeni,jmeno,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,@$cykl,1)<>@$oscislo){?><option value="<?echo(mysql_result($data1,@$cykl,1));?>"><?echo(mysql_result($data1,@$cykl,4)." ".mysql_result($data1,@$cykl,3)." ".mysql_result($data1,@$cykl,2)." / ".mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;?></select></td></tr>
<?if (@$oscislo<>""){@$data1 = mysql_query("select * from zamestnanci where osobni_cislo='$oscislo'") or Die(MySQL_Error());?>





<tr><td>Pl.»ip / é·dost »ipu:</td><td colspan=2><select name=cip style=width:100%>
<option value="<?echo @mysql_result(mysql_query("select cip from cipy where osobni_cislo='$oscislo' and platnostdo='0000-00-00'"),0,0);?>"><?echo @mysql_result(mysql_query("select cip from cipy where osobni_cislo='$oscislo' and platnostdo='0000-00-00'"),0,0);?></option>
<?include ("./"."dbconnect.php");
@$data2 = mysql_query("select * from zadost where cip<>'null' order by datum,cas,id ") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data2);@$cykl=0;
while (@$cykl<@$pocet):
$casti= explode("-", mysql_result($data2,@$cykl,2));$datumzadosti = $casti[2].".".$casti[1].".".$casti[0]." : ".mysql_result($data2,@$cykl,3);
?><option value="<?echo(mysql_result($data2,@$cykl,1));?>"><?echo(mysql_result($data2,@$cykl,1))." / ".$datumzadosti;?></option><?
@$cykl++;endwhile;?></select></td></tr>

<tr><td>Titul/PohlavÌ/ObËanstvÌ:</td><td colspan=2><input type="text" name=titul value="<?echo(mysql_result($data1,0,2));?>" style=width:30% >
<select size="1" name="pohlavi"><?if (mysql_result($data1,0,30)=="Muû") {echo "<option>Muû</option><option>éena</option>";} else {echo "<option>éena</option><option>Muû</option>";}?></select> <input name="obcanstvi" type="text" value="<?echo mysql_result($data1,0,31);?>" size=20></td></tr>
<tr><td>JmÈno:</td><td colspan=2><input type="text" name=jmeno value="<?echo(mysql_result($data1,0,3));?>" size="50" style=background-color:#F9C8C8></td></tr>
<tr><td>P¯ÌjmenÌ:</td><td colspan=2><input type="text" name=prijmeni value="<?echo(mysql_result($data1,0,4));?>" size="50" style=background-color:#F9C8C8></td></tr>
<tr><td>PracovnÌ Doba (h/m):</td><td><select size="1" name="hodiny" style=background-color:#F9C8C8>
<?$casti= explode(":", mysql_result($data1,0,20));@$hodiny=$casti[0];@$minuty=$casti[1];?><option><?echo@$hodiny;?></option>
<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>
<option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
</select><select size="1" name="minuty" style=background-color:#F9C8C8><option><?echo@$minuty;?></option><option>00</option><option>15</option><option>30</option><option>45</option></select>
</td><td align=right>Export: <input name="export" type="checkbox" <?if (mysql_result($data1,0,21)=="ANO") {?>Checked<?}?> ></td></tr>
<tr><td>Generovat N·vrh Doch.:<br />V˝chozÌ N·vrh: </td><td><input name="navrh" type="checkbox" <?if (mysql_result($data1,0,22)=="ANO") {?>Checked<?}?> >
<br /><select name="vnavrh"><?if (mysql_result($data1,0,23)<>"") {$dotaz=mysql_result($data1,0,23);echo "<option value='".mysql_result($data1,0,23)."'>".@mysql_result(mysql_query("select nazev from ukony where id='$dotaz' "),0,0)."</option>";}?><option></option>
<?include ("./"."dbconnect.php");@$datas1 = mysql_query("select * from ukony where stav ='AktivnÌ' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):
?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select></td>
<td align=center>SmÏna<br /><select size="1" name="smena">
<option><?echo @mysql_result($data1,0,24);?></option>
<?if (@mysql_result($data1,0,24)<>"RannÌ") {?><option>RannÌ</option><?}
if (@mysql_result($data1,0,24)<>"OdpolednÌ") {?><option>OdpolednÌ</option><?}
if (@mysql_result($data1,0,24)<>"NoËnÌ") {?><option>NoËnÌ</option><?}?>
</select></td></tr>

<tr><td>ObsazenÌ/KodMS:</td><td><input name="obsazeni" type="text" value="<?echo(mysql_result($data1,0,35));?>" style=width:60%><input name="kodms" type="text" value="<?echo(mysql_result($data1,0,36));?>" style=width:40%></td><td align=right>⁄kol: <input name="ukol" type="checkbox" <?if (mysql_result($data1,0,34)=="ANO") {echo " checked ";}?> ></td></tr>

<tr><td>RodnÈ »Ìslo/Datum Nar.:</td><td><input type="text" name=rodnecislo value="<?echo(mysql_result($data1,0,5));?>" style="width:50%" style=background-color:white>
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumnar" value="<?if (mysql_result($data1,0,29)<>"--") {$casti = explode("-", mysql_result($data1,0,29));echo $casti[2].".".$casti[1].".".$casti[0];} else {echo@$dnescs;}?>" style="width:28%" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumnar,'span_pokusnar','cpokus');"style="width:20%" ><SPAN ID="span_pokusnar">

</td><td align=right>VedoucÌ: <input name="vedouci" type="checkbox" <?if (mysql_result($data1,0,19)=="A") {?>Checked<?}?> ></td></tr>
<tr><td>Pojiöùovna/CZ-ISCO:</td><td colspan=2><input name="pojistovna" type="text" value="<?echo mysql_result($data1,0,32);?>" style=width:50%><input name="czisco" type="text" value="<?echo mysql_result($data1,0,33);?>" style=width:50%></td></tr>

<tr><td>Datum N·stupu:</td><SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," ET"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t eÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><td colspan=2><input type="text" name="datumin" value="<?if (mysql_result($data1,0,11)<>"") {$casti = explode("-", mysql_result($data1,0,11));echo $casti[2].".".$casti[1].".".$casti[0];} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumin,'span_pokus','cpokus');"style="width:28%" ><SPAN ID="span_pokus"> </td></tr>

<tr><td>Datum UkonËenÌ:</td><SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," ET"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t eÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><td colspan=2><input type="text" name="datumout" value="<?if (mysql_result($data1,0,12)<>"0000-00-00") {$casti = explode("-", mysql_result($data1,0,12));echo $casti[2].".".$casti[1].".".$casti[0];}?>" style="width:70%" ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumout,'span_pokusa','cpokus');"style="width:28%" ><SPAN ID="span_pokusa"> </td></tr>

<tr><td>Kategorie:</td><td colspan=2><select name=kategorie style=width:100%>
<option><?echo mysql_result($data1,0,18);?></option><?include ("./"."dbconnect.php");
@$datas1 = mysql_query("select * from kategorie order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datas1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,0,18)<>mysql_result($datas1,@$cykl,1)) {?><option><?echo mysql_result($datas1,@$cykl,1);?></option><?}
@$cykl++;endwhile;?></select></td></tr>


<tr><td>St¯edisko (od/do):</td><td colspan=2 align=left>
<?if (@$firstload=="") {@$firstload=1;@$data3 = mysql_query("select * from zam_strediska where osobni_cislo='$oscislo' order by datumod,id ASC") or Die(MySQL_Error());}?>
<input type=hidden name="firstload" value="<?echo@$firstload;?>?>">
<?while ((@$zaznam-1)<mysql_num_rows($data3)):?>
<input type=hidden name="tlacitko<?echo@$zaznam;?>" value=" + ">
<select name="stredisko<?echo@$zaznam;?>" >
<?if (mysql_result($data3,(@$zaznam-1),2)<>"") {echo"<option>".mysql_result($data3,(@$zaznam-1),2)."</option>";}
include ("./"."dbconnect.php");
@$datar1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datar1);@$cykl=0;
while (@$cykl<@$pocet):
?><option><?echo(mysql_result($datar1,@$cykl,1));?></option><?
@$cykl++;endwhile;?></select>
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumins<?echo@$zaznam;?>" value="<?if (mysql_result($data3,(@$zaznam-1),3)<>"0000-00-00") {@$casti = explode("-", mysql_result($data3,(@$zaznam-1),3));echo $casti[2].".".$casti[1].".".$casti[0];} else {echo"Datum od";}?>" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumins<?echo@$zaznam;?>,'span_pokus<?echo@$zaznam;?>','cpokus');" ><SPAN ID="span_pokus<?echo@$zaznam;?>">
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumouts<?echo@$zaznam;?>" value="<?if (mysql_result($data3,(@$zaznam-1),4)<>"0000-00-00") {@$casti = explode("-", mysql_result($data3,(@$zaznam-1),4));echo $casti[2].".".$casti[1].".".$casti[0];}?>" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumouts<?echo@$zaznam;?>,'span_pokus<?echo@$zaznam;?>','cpokus');" ><SPAN ID="span_pokus<?echo@$zaznam;?>"><br />
<?@$zaznam++;endwhile;

while ($_POST["tlacitko".@$zaznam]==" + " and @$firstload==1):?>
<input type=hidden name="tlacitko<?echo@$zaznam;?>" value=" + ">
<select name="stredisko<?echo@$zaznam;?>" >
<?if ($_POST["stredisko".@$zaznam]<>"") {echo"<option>".$_POST["stredisko".@$zaznam]."</option>";}
include ("./"."dbconnect.php");
@$datar1 = mysql_query("select * from stredisko order by kod,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($datar1);@$cykl=0;
while (@$cykl<@$pocet):
?><option><?echo(mysql_result($datar1,@$cykl,1));?></option><?
@$cykl++;endwhile;?></select>
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumins<?echo@$zaznam;?>" value="<?if ($_POST["datumins".@$zaznam]<>"") {echo $_POST["datumins".@$zaznam];} else {echo"Datum od";}?>" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumins<?echo@$zaznam;?>,'span_pokus<?echo@$zaznam;?>','cpokus');" ><SPAN ID="span_pokus<?echo@$zaznam;?>">
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumouts<?echo@$zaznam;?>" value="<?if ($_POST["datumouts".@$zaznam]<>"") {echo $_POST["datumouts".@$zaznam];}?>" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumouts<?echo@$zaznam;?>,'span_pokus<?echo@$zaznam;?>','cpokus');" ><SPAN ID="span_pokus<?echo@$zaznam;?>"><br />

<?@$zaznam++;endwhile;?>

<input type="submit" name="tlacitko<?echo@$zaznam++;?>" value=" + " style=width:25px>
</td></tr>
<tr bgcolor=#8BE00C><td>PovolenÈ Turnikety:<br />(bez doch·zky: <input name=pruchod type="checkbox" <?if (mysql_result($data1,0,26)=="ANO") {echo"Checked";}?> >)</td><td colspan=2>
<select size="3" name="turn[]"  multiple="multiple" style=width:100%>
<?@$data5=mysql_query("select * from turnikety order by nazev,id");
@$turn=0;while(@$turn<mysql_num_rows($data5)):
echo"<option value='".mysql_result($data5,@$turn,0)."'";
if (StrPos (" " .mysql_result($data1,0,25), ",".mysql_result($data5,@$turn,0).",")) {echo" selected ";}echo ">".mysql_result($data5,@$turn,1)."</option>";
@$turn++;endwhile;?></select></td></tr>
<tr bgcolor=#8BE00C><td>DotovanÈ ObÏdy: <input name="obed" type="checkbox" <?if (mysql_result($data1,0,27)=="ANO"){echo"checked";}?> ></td><td colspan=2>Manager: <input name="manager" type="checkbox" <?if (mysql_result($data1,0,28)=="ANO"){echo"checked";}?>></td></tr>

<tr><td colspan=3 align=center bgcolor=#BFBFFF><br /><b>BydliötÏ</b></td></tr>
<tr bgcolor=#D7D7FF><td>Ulice:</td><td colspan=2><input type="text" name=ulice value="<?echo(mysql_result($data1,0,6));?>" size="50"></td></tr>
<tr bgcolor=#D7D7FF><td>MÏsto:</td><td colspan=2><input type="text" name=mesto value="<?echo(mysql_result($data1,0,7));?>" size="50"></td></tr>
<tr bgcolor=#D7D7FF><td>PS»:</td><td colspan=2><input type="text" name=psc value="<?echo(mysql_result($data1,0,8));?>" size="50"></td></tr>
<tr bgcolor=#D7D7FF><td>Telefon:</td><td colspan=2><input type="text" name=telefon value="<?echo(mysql_result($data1,0,9));?>" size="50"></td></tr>
<tr bgcolor=#D7D7FF><td>E-Mail:</td><td colspan=2><input type="text" name=email value="<?echo(mysql_result($data1,0,10));?>" size="50"></td></tr>


<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uloûit OpravenÈho ZamÏstnance"></center><BR></td></tr><?}}?>





<?if (@$menu=="OdstranÏnÌ ExistujÌcÌho ZamÏstnance"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$menu?></b></center></td></tr>
<tr><td>OsobnÌ »Ìslo:</td><td colspan=2><select name=oscislo size="1" onchange=submit(this) style=size:100%>
<?if (@$oscislo<>""){include ("./"."dbconnect.php");@$data1 = mysql_query("select * from zamestnanci where osobni_cislo='$oscislo'") or Die(MySQL_Error());
?><option value="<?echo(mysql_result($data1,0,1));?>"><?echo(mysql_result($data1,0,4)." ".mysql_result($data1,0,3)." ".mysql_result($data1,0,2)." / ".mysql_result($data1,0,1));?></option><?} else {?><option></option><?}
include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from zamestnanci where osobni_cislo not in (select osobni_cislo from dochazka) order by prijmeni,jmeno,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,@$cykl,1)<>@$oscislo){?><option value="<?echo(mysql_result($data1,@$cykl,1));?>"><?echo(mysql_result($data1,@$cykl,4)." ".mysql_result($data1,@$cykl,3)." ".@mysql_result($data1,@$cykl,2)." / ".mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;?></select></td></tr>
<?if (@$oscislo<>""){@$data1 = mysql_query("select * from zamestnanci where osobni_cislo='$oscislo'") or Die(MySQL_Error());?>

<tr><td>Platn˝ »ip:</td><td colspan=2><input type="text" name=cip value="<?echo @mysql_result(mysql_query("select cip from cipy where osobni_cislo='$oscislo' and platnostdo='0000-00-00'"),0,0);?>" style=width:100% readonly=yes></td></tr>
<tr><td>Titul/PohlavÌ/ObËanstvÌ:</td><td colspan=2><input type="text" name=titul value="<?echo(mysql_result($data1,0,2));?>" style=width:30% readonly=yes><select size="1" name="pohlavi" disabled><?if (mysql_result($data1,0,30)=="Muû") {echo "<option>Muû</option><option>éena</option>";} else {echo "<option>éena</option><option>Muû</option>";}?></select> <input name="obcanstvi" type="text" value="<?echo mysql_result($data1,0,31);?>" size=20 disabled></td></tr>
<tr><td>JmÈno:</td><td colspan=2><input type="text" name=jmeno value="<?echo(mysql_result($data1,0,3));?>" style=width:100% style=background-color:#F9C8C8 readonly=yes></td></tr>
<tr><td>P¯ÌjmenÌ:</td><td colspan=2><input type="text" name=prijmeni value="<?echo(mysql_result($data1,0,4));?>" style=width:100% style=background-color:#F9C8C8 readonly=yes></td></tr>
<?$casti= explode(":", mysql_result($data1,0,20));@$hodiny=$casti[0];@$minuty=$casti[1];?>
<tr><td>PracovnÌ Doba (h/m):</td><td><input name="hodiny" type="text" value="<?echo@ $hodiny.':'.@$minuty;?>" style=width:100% readonly=yes></td><td align=right>Export: <input name="export" type="checkbox" <?if (mysql_result($data1,0,21)=="ANO") {?>Checked<?}?> disabled></td></tr>
<tr><td>Generovat N·vrh Doch.:<br />V˝chozÌ N·vrh: </td><td><input name="navrh" type="checkbox" <?if (mysql_result($data1,0,22)=="ANO") {?>Checked<?}?> disabled>
<?if (mysql_result($data1,0,23)<>"") {$dotaz=mysql_result($data1,0,23);@$hodnota=@mysql_result(mysql_query("select nazev from ukony where id='$dotaz' "),0,0);} else {$hodnota="";}?>
<br /><input type="text" name="vnavrh" value="<?echo @$hodnota;?>" readonly=yes></td>
<td align=center>SmÏna<br /><input type=text style=width:100% name="smena" value="<?echo @mysql_result($data1,0,24);?>" readonly=yes></td></tr>

<tr><td>ObsazenÌ/KodMS:</td><td><input name="obsazeni" type="text" value="<?echo(mysql_result($data1,0,35));?>" style=width:60% disabled><input name="kodms" type="text" value="<?echo(mysql_result($data1,0,36));?>" style=width:40% disabled></td><td align=right>⁄kol: <input name="ukol" type="checkbox" <?if (mysql_result($data1,0,34)=="ANO") {echo " checked ";}?> disabled></td></tr>

<tr><td>RodnÈ »Ìslo/Datum Nar.:</td><td><input type="text" name=rodnecislo value="<?echo(mysql_result($data1,0,5));?>" style=width:50% style=background-color:white readonly=yes>
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumnar" value="<?if (mysql_result($data1,0,29)<>"--") {$casti = explode("-", mysql_result($data1,0,29));echo $casti[2].".".$casti[1].".".$casti[0];} else {echo@$dnescs;}?>" style="width:28%" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumnar,'span_pokusnar','cpokus');"style="width:20%" disabled><SPAN ID="span_pokusnar">

</td><td align=right>VedoucÌ: <input name="vedouci" type="checkbox" <?if (mysql_result($data1,0,19)=="A") {?>Checked<?}?> disabled></td></tr>
<tr><td>Pojiöùovna/CZ-ISCO:</td><td colspan=2><input name="pojistovna" type="text" value="<?echo mysql_result($data1,0,32);?>" style=width:50% readonly=yes><input name="czisco" type="text" value="<?echo mysql_result($data1,0,33);?>" style=width:50% readonly=yes></td></tr>

<tr><td>Datum N·stupu:</td><td colspan=2><input type="text" name="datumin" value="<?if (mysql_result($data1,0,11)<>"") {$casti = explode("-", mysql_result($data1,0,11));echo $casti[2].".".$casti[1].".".$casti[0];} else {echo@$dnescs;}?>" style="width:100%" readonly=yes  style=background-color:#F9C8C8></td></tr>
<tr><td>Datum UkonËenÌ:</td><td colspan=2><input type="text" name="datumout" value="<?if (mysql_result($data1,0,12)<>"0000-00-00") {$casti = explode("-", mysql_result($data1,0,12));echo $casti[2].".".$casti[1].".".$casti[0];}?>" style="width:100%" readonly=yes ></td></tr>
<tr><td>Kategorie:</td><td colspan=2><input type="text" value="<?echo(mysql_result($data1,0,18));?>" style=width:100% readonly=yes></td></tr>
<tr><td>St¯edisko (od/do):</td><td colspan=2 align=left>
<?@$data3 = mysql_query("select * from zam_strediska where osobni_cislo='$oscislo' order by datumod,id ASC") or Die(MySQL_Error());
while ((@$zaznam-1)<mysql_num_rows($data3)):?>
<input type=text name="stredisko<?echo@$zaznam;?>" value="<?echo mysql_result($data3,(@$zaznam-1),2);?>" readonly=yes>
<input type="text" name="datumins<?echo@$zaznam;?>" value="<?if (mysql_result($data3,(@$zaznam-1),3)<>"0000-00-00") {@$casti = explode("-", mysql_result($data3,(@$zaznam-1),3));echo $casti[2].".".$casti[1].".".$casti[0];} else {echo"Datum od";}?>" readonly=yes  style=background-color:#F9C8C8>
<input type="text" name="datumouts<?echo@$zaznam;?>" value="<?if (mysql_result($data3,(@$zaznam-1),4)<>"0000-00-00") {@$casti = explode("-", mysql_result($data3,(@$zaznam-1),4));echo $casti[2].".".$casti[1].".".$casti[0];}?>" readonly=yes  style=background-color:#F9C8C8><br />
<?@$zaznam++;endwhile;?>
</td></tr>
<tr bgcolor=#8BE00C><td>PovolenÈ Turnikety:<br />(bez doch·zky: <input name=pruchod type="checkbox" <?if (mysql_result($data1,0,26)=="ANO") {echo"Checked";}?> disabled>)</td><td colspan=2>
<select size="3" name="turn[]"  multiple="multiple" style=width:100%>
<?@$data5=mysql_query("select * from turnikety order by nazev,id");
@$turn=0;while(@$turn<mysql_num_rows($data5)):
echo"<option disabled=disabled value='".mysql_result($data5,@$turn,0)."'";
if (StrPos (" " .mysql_result($data1,0,25), ",".mysql_result($data5,@$turn,0).",")) {echo" style=background-color:#C0BDFB";}echo ">".mysql_result($data5,@$turn,1)."</option>";
@$turn++;endwhile;?></select></td></tr>
<tr bgcolor=#8BE00C><td>DotovanÈ ObÏdy: <input name="obed" type="checkbox" <?if (mysql_result($data1,0,27)=="ANO"){echo"checked";}?> disabled></td></td><td colspan=2>Manager: <input name="manager" type="checkbox" <?if (mysql_result($data1,0,28)=="ANO"){echo"checked";}?> disabled></td></tr>

<tr><td colspan=3 align=center bgcolor=#BFBFFF><br /><b>BydliötÏ</b></td></tr>
<tr bgcolor=#D7D7FF><td>Ulice:</td><td colspan=2><input type="text" name=ulice value="<?echo(mysql_result($data1,0,6));?>" style=width:100% readonly=yes></td></tr>
<tr bgcolor=#D7D7FF><td>MÏsto:</td><td colspan=2><input type="text" name=mesto value="<?echo(mysql_result($data1,0,7));?>" style=width:100% readonly=yes></td></tr>
<tr bgcolor=#D7D7FF><td>PS»:</td><td colspan=2><input type="text" name=psc value="<?echo(mysql_result($data1,0,8));?>" style=width:100% readonly=yes></td></tr>
<tr bgcolor=#D7D7FF><td>Telefon:</td><td colspan=2><input type="text" name=telefon value="<?echo(mysql_result($data1,0,9));?>" style=width:100% readonly=yes></td></tr>
<tr bgcolor=#D7D7FF><td>E-Mail:</td><td colspan=2><input type="text" name=email value="<?echo(mysql_result($data1,0,10));?>" style=width:100% readonly=yes></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Odstranit VybranÈho ZamÏstnance"></center><BR></td></tr><?}}?>

<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "Z") or  StrPos (" " . $_SESSION["prava"], "z") ){?>

<?if (@$menu=="Tisk ZamÏstnanc˘"){?>
<script type="text/javascript">
window.open('TiskZamestnancu.php?stav=<?echo base64_encode($stav);?>&stredisko=<?echo base64_encode($stredisko);?>')
</script>
<?}?>


<?if (@$menu=="Karta ZamÏstnance"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$menu?></b></center></td></tr>
<tr><td>OsobnÌ »Ìslo:</td><td colspan=2><select name=oscislo size="1" onchange=submit(this) style=size:100%>
<?if (@$oscislo<>""){include ("./"."dbconnect.php");@$data1 = mysql_query("select * from zamestnanci where osobni_cislo='$oscislo'") or Die(MySQL_Error());
?><option value="<?echo(mysql_result($data1,0,1));?>"><?echo(mysql_result($data1,0,4)." ".mysql_result($data1,0,3)." ".mysql_result($data1,0,2)." / ".mysql_result($data1,0,1));?></option><?} else {?><option></option><?}
include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from zamestnanci where osobni_cislo<>'' $dotazline order by prijmeni,jmeno,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,@$cykl,1)<>@$oscislo){?><option value="<?echo(mysql_result($data1,@$cykl,1));?>"><?echo(mysql_result($data1,@$cykl,4)." ".mysql_result($data1,@$cykl,3)." ".@mysql_result($data1,@$cykl,2)." / ".mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;?></select></td></tr>
<?if (@$oscislo<>""){@$data1 = mysql_query("select * from zamestnanci where osobni_cislo='$oscislo'") or Die(MySQL_Error());?>

<tr><td>Platn˝ »ip:</td><td colspan=2><input type="text" name=cip value="<?echo @mysql_result(mysql_query("select cip from cipy where osobni_cislo='$oscislo' and platnostdo='0000-00-00'"),0,0);?>" style=width:100% readonly=yes></td></tr>
<tr><td>Titul/PohlavÌ/ObËanstvÌ:</td><td colspan=2><input type="text" name=titul value="<?echo(mysql_result($data1,0,2));?>" style=width:30% readonly=yes><select size="1" name="pohlavi" disabled><?if (mysql_result($data1,0,30)=="Muû") {echo "<option>Muû</option><option>éena</option>";} else {echo "<option>éena</option><option>Muû</option>";}?></select> <input name="obcanstvi" type="text" value="<?echo mysql_result($data1,0,31);?>" size=20 disabled></td></tr>
<tr><td>JmÈno:</td><td colspan=2><input type="text" name=jmeno value="<?echo(mysql_result($data1,0,3));?>" style=width:100% style=background-color:#F9C8C8 readonly=yes></td></tr>
<tr><td>P¯ÌjmenÌ:</td><td colspan=2><input type="text" name=prijmeni value="<?echo(mysql_result($data1,0,4));?>" style=width:100% style=background-color:#F9C8C8 readonly=yes></td></tr>
<?$casti= explode(":", mysql_result($data1,0,20));@$hodiny=$casti[0];@$minuty=$casti[1];?>
<tr><td>PracovnÌ Doba (h/m):</td><td><input name="hodiny" type="text" value="<?echo@ $hodiny.':'.@$minuty;?>" style=width:100% readonly=yes></td><td align=right>Export: <input name="export" type="checkbox" <?if (mysql_result($data1,0,21)=="ANO") {?>Checked<?}?> disabled></td></tr>
<tr><td>Generovat N·vrh Doch.:<br />V˝chozÌ N·vrh: </td><td><input name="navrh" type="checkbox" <?if (mysql_result($data1,0,22)=="ANO") {?>Checked<?}?>>
<?if (mysql_result($data1,0,23)<>"") {$dotaz=mysql_result($data1,0,23);@$hodnota=@mysql_result(mysql_query("select nazev from ukony where id='$dotaz' "),0,0);} else {$hodnota="";}?>
<br /><select name="vnavrh"><?if (mysql_result($data1,0,23)<>"") {$dotaz=mysql_result($data1,0,23);echo "<option value='".mysql_result($data1,0,23)."'>".@mysql_result(mysql_query("select nazev from ukony where id='$dotaz' "),0,0)."</option>";}?><option></option>
<?include ("./"."dbconnect.php");@$datas1 = mysql_query("select * from ukony where stav ='AktivnÌ' order by nazev,id ") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($datas1)):
?><option value="<?echo(mysql_result($datas1,@$cykl,0));?>"><?echo @mysql_result($datas1,@$cykl,1);?></option><?
@$cykl++;endwhile;?></select></td>
<td align=center>SmÏna<br /><input type=text style=width:100% name="smena" value="<?echo @mysql_result($data1,0,24);?>" readonly=yes></td></tr>

<tr><td>ObsazenÌ/KodMS:</td><td><input name="obsazeni" type="text" value="<?echo(mysql_result($data1,0,35));?>" style=width:60% disabled><input name="kodms" type="text" value="<?echo(mysql_result($data1,0,36));?>" style=width:40% disabled></td><td align=right>⁄kol: <input name="ukol" type="checkbox" <?if (mysql_result($data1,0,34)=="ANO") {echo " checked ";}?> disabled></td></tr>

<tr><td>RodnÈ »Ìslo/Datum Nar.:</td><td><input type="text" name=rodnecislo value="<?echo(mysql_result($data1,0,5));?>" style=width:50% style=background-color:white readonly=yes>
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ⁄T"," ST"," »T"," P¡"," SO"," NE"];var cMOY=["Leden","⁄nor","B¯ezen","Duben","KvÏten","»erven","»ervenec","Srpen","Z·¯Ì","ÿÌjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musÌ b˝t ËÌslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="datumnar" value="<?if (mysql_result($data1,0,29)<>"--") {$casti = explode("-", mysql_result($data1,0,29));echo $casti[2].".".$casti[1].".".$casti[0];} else {echo@$dnescs;}?>" style="width:28%" readonly=yes  style=background-color:#F9C8C8><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumnar,'span_pokusnar','cpokus');"style="width:20%" disabled><SPAN ID="span_pokusnar">

</td><td align=right>VedoucÌ: <input name="vedouci" type="checkbox" <?if (mysql_result($data1,0,19)=="A") {?>Checked<?}?> disabled></td></tr>
<tr><td>Pojiöùovna/CZ-ISCO:</td><td colspan=2><input name="pojistovna" type="text" value="<?echo mysql_result($data1,0,32);?>" style=width:50% disabled><input name="czisco" type="text" value="<?echo mysql_result($data1,0,33);?>" style=width:50% disabled></td></tr>

<tr><td>Datum N·stupu:</td><td colspan=2><input type="text" name="datumin" value="<?if (mysql_result($data1,0,11)<>"") {$casti = explode("-", mysql_result($data1,0,11));echo $casti[2].".".$casti[1].".".$casti[0];} else {echo@$dnescs;}?>" style="width:100%" readonly=yes  style=background-color:#F9C8C8></td></tr>
<tr><td>Datum UkonËenÌ:</td><td colspan=2><input type="text" name="datumout" value="<?if (mysql_result($data1,0,12)<>"0000-00-00") {$casti = explode("-", mysql_result($data1,0,12));echo $casti[2].".".$casti[1].".".$casti[0];}?>" style="width:100%" readonly=yes ></td></tr>
<tr><td>Kategorie:</td><td colspan=2><input type="text" value="<?echo(mysql_result($data1,0,18));?>" style=width:100% readonly=yes></td></tr>
<tr><td>St¯edisko (od/do):</td><td colspan=2 align=left>
<?@$data3 = mysql_query("select * from zam_strediska where osobni_cislo='$oscislo' order by datumod,id ASC") or Die(MySQL_Error());
while ((@$zaznam-1)<mysql_num_rows($data3)):?>
<input type=text name="stredisko<?echo@$zaznam;?>" value="<?echo mysql_result($data3,(@$zaznam-1),2);?>" readonly=yes>
<input type="text" name="datumins<?echo@$zaznam;?>" value="<?if (mysql_result($data3,(@$zaznam-1),3)<>"0000-00-00") {@$casti = explode("-", mysql_result($data3,(@$zaznam-1),3));echo $casti[2].".".$casti[1].".".$casti[0];} else {echo"Datum od";}?>" readonly=yes  style=background-color:#F9C8C8>
<input type="text" name="datumouts<?echo@$zaznam;?>" value="<?if (mysql_result($data3,(@$zaznam-1),4)<>"0000-00-00") {@$casti = explode("-", mysql_result($data3,(@$zaznam-1),4));echo $casti[2].".".$casti[1].".".$casti[0];}?>" readonly=yes  style=background-color:#F9C8C8><br />
<?@$zaznam++;endwhile;?>
</td></tr>

<tr><td>SystÈmovÈ Informace:</td><td colspan=2>
<input type="button" value="STATUS" onclick="window.open('SysInf.php?oscislo=<?echo base64_encode(@$oscislo);?>&typ=<?echo base64_encode('read');?>','','toolbar=0, width=800, height=600, directories=0, location=0, status=1, menubar=0, resizable=0, scrollbars=0, titlebar=0')">
</td></tr>
<tr bgcolor=#8BE00C><td>PovolenÈ Turnikety:<br />(bez doch·zky: <input name=pruchod type="checkbox" <?if (mysql_result($data1,0,26)=="ANO") {echo"Checked";}?> disabled>)</td><td colspan=2>
<select size="3" name="turn[]"  multiple="multiple" style=width:100%>
<?@$data5=mysql_query("select * from turnikety order by nazev,id");
@$turn=0;while(@$turn<mysql_num_rows($data5)):
echo"<option disabled=disabled value='".mysql_result($data5,@$turn,0)."'";
if (StrPos (" " .mysql_result($data1,0,25), ",".mysql_result($data5,@$turn,0).",")) {echo" style=background-color:#C0BDFB";}echo ">".mysql_result($data5,@$turn,1)."</option>";
@$turn++;endwhile;?></select></td></tr>
<tr bgcolor=#8BE00C><td>DotovanÈ ObÏdy: <input name="obed" type="checkbox" <?if (mysql_result($data1,0,27)=="ANO"){echo"checked";}?> disabled></td><td colspan=2>Manager: <input name="manager" type="checkbox" <?if (mysql_result($data1,0,28)=="ANO"){echo"checked";}?> disabled ></td></tr>


<tr><td colspan=3 align=center bgcolor=#BFBFFF><br /><b>BydliötÏ</b></td></tr>
<tr bgcolor=#D7D7FF><td>Ulice:</td><td colspan=2><input type="text" name=ulice value="<?echo(mysql_result($data1,0,6));?>" style=width:100% readonly=yes></td></tr>
<tr bgcolor=#D7D7FF><td>MÏsto:</td><td colspan=2><input type="text" name=mesto value="<?echo(mysql_result($data1,0,7));?>" style=width:100% readonly=yes></td></tr>
<tr bgcolor=#D7D7FF><td>PS»:</td><td colspan=2><input type="text" name=psc value="<?echo(mysql_result($data1,0,8));?>" style=width:100% readonly=yes></td></tr>
<tr bgcolor=#D7D7FF><td>Telefon:</td><td colspan=2><input type="text" name=telefon value="<?echo(mysql_result($data1,0,9));?>" style=width:100% readonly=yes></td></tr>
<tr bgcolor=#D7D7FF><td>E-Mail:</td><td colspan=2><input type="text" name=email value="<?echo(mysql_result($data1,0,10));?>" style=width:100% readonly=yes></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uloûit Kartu VybranÈho ZamÏstnance"></center><BR></td></tr>
<?}}?>


<?if (@$menu=="P¯ehled ExistujÌcÌch ZamÏstnanc˘"){?>
<tr bgcolor="#C0FFC0" align=center>
<td colspan=3 align=left>Pouze AktivnÌ: <select size="1" name="stav" onchange=submit(this)><option ><?echo@$stav;?></option><?if (@$stav<>"") {?><option ></option><?}if (@$stav<>"A") {?><option >A</option><?}if (@$stav<>"N") {?><option >N</option><?}?></select></td>
<td colspan=16><center><b><big> <?echo@$menu;?></big> </b></center></td>
<td colspan=3 align=right>St¯edisko: <select name=stredisko size="1" onchange=submit(this) style=size:100%>
<?if (@$stredisko<>""){?><option value="<?echo $stredisko;?>"><?echo $stredisko;?></option><option></option><?} else {?><option></option><?}
include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from zamestnanci where id<>'' $dotazline group by stredisko order by stredisko,osobni_cislo,id ") or Die(MySQL_Error());
@$cykl=0;
while (@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,@$cykl,17)<>@$stredisko){?><option value="<?echo(mysql_result($data1,@$cykl,17));?>"><?echo mysql_result($data1,@$cykl,17);?></option><?}
@$cykl++;endwhile;?></select></td>
</tr>
<tr bgcolor="#C2CAFE" align=center><td> Po¯adÌ </td>
<td><center>OsobnÌ »Ìslo</center></td>
<td><center>Platn˝ »ip</center></td>
<td><center>Titul</center></td>
<td><center>JmÈno</center></td>
<td><center>P¯ÌjmenÌ</center></td>
<td><center>RodnÈ »Ìslo</center></td>
<td><center>Datum N·stupu</center></td>
<td><center>Datum UkonËenÌ</center></td>
<td><center>Ulice</center></td>
<td><center>MÏsto</center></td>
<td><center>PS»</center></td>
<td><center>Telefon</center></td>
<td><center>Email</center></td>
<td><center>Kategorie</center></td>
<td><center>Akt St¯edisko</center></td>
<td><center>VedoucÌ Pr.</center></td>
<td><center>PracovnÌ Doba</center></td>
<td><center>Export</center></td>
<td><center>SmÏna</center></td>
<td><b> Dot. ObÏdy </b></td>
<td><b> Z·znamy </b></td>
</tr>

<?
if (@$stredisko<>"") {@$dotazline.=" and stredisko='$stredisko'";}
include ("./"."dbconnect.php");
@$data1=mysql_query("select * from zamestnanci $filtr $dotazline order by osobni_cislo,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):

?><tr><td><?echo@$cykl+1;?></td><td><?echo @$oscislo= mysql_result($data1,@$cykl,1);?></td>
<td><?echo @mysql_result(mysql_query("select cip from cipy where osobni_cislo='$oscislo' and platnostdo='0000-00-00'"),0,0);?></td>
<td><?echo mysql_result($data1,@$cykl,2);?></td>
<td><?echo mysql_result($data1,@$cykl,3);?></td>
<td><?echo mysql_result($data1,@$cykl,4);?></td>
<td><?echo mysql_result($data1,@$cykl,5);?></td>
<td><?$casti = explode("-", mysql_result($data1,@$cykl,11));echo $casti[2].".".$casti[1].".".$casti[0];?></td>
<td><?if (mysql_result($data1,@$cykl,12)<>"0000-00-00") {$casti = explode("-", mysql_result($data1,@$cykl,12));echo $casti[2].".".$casti[1].".".$casti[0];}?></td>
<td><?echo mysql_result($data1,@$cykl,6);?></td>
<td><?echo mysql_result($data1,@$cykl,7);?></td>
<td><?echo mysql_result($data1,@$cykl,8);?></td>
<td><?echo mysql_result($data1,@$cykl,9);?></td>
<td><?echo mysql_result($data1,@$cykl,10);?></td>
<td><?echo mysql_result($data1,@$cykl,18);?></td>

<td><?echo mysql_result($data1,@$cykl,17);?></td>

<td><?if (mysql_result($data1,@$cykl,19)=="A"){echo "ANO";} else {echo"NE";};?></td>
<td><?echo mysql_result($data1,@$cykl,20);?></td>
<td><?echo mysql_result($data1,@$cykl,21);?></td>
<td><?echo mysql_result($data1,@$cykl,24);?></td>
<td><?echo mysql_result($data1,@$cykl,27);?></td>
<td align=center><?include ("./"."dbconnect.php");@$control= mysql_result($data1,@$cykl,0);
@$control1=mysql_query("select id from dochazka where osobni_cislo='$oscislo'");
@$control=mysql_num_rows($control1);
if (@$control<>"") {echo"ANO";} else {echo"NE";}?>
</td></tr><?

@$cykl++;endwhile;}?>

<?}?>






</table></center>
</form>
