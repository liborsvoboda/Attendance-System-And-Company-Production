<?
//  menu
@$menu=@$_POST["menu"];

if ((@$menu<>@$_POST["menuold"] and @$_POST["menuold"]) or @$_POST["idu"] or (@$menu=="Zalo�it Nov� Z�znam" and @$_POST["value2"]<>@$_POST["valueold"] )) {$cykl=1;while($cykl<50): if (@$cykl<>2) {unset($_POST["value".$cykl]);}@$cykl++;endwhile;}


//save
if (@$_POST["tlacitko"]=="Ulo�it Z�znam o �razu") {$idu=explode("/",@$_POST["idus"]);@$_POST["idu"]=@$_POST["idus"];@$_POST["submenu"]="Zo�";$control=mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."'");

if (!mysql_num_rows($control)) { // novy ZoU
@$cykl=1;while($cykl<60):$text.=securesql(@$_POST["value".$cykl]).":+:";if (@$cykl==3) {$companyid=securesql(@$_POST["value".$cykl]);}unset($_POST["value".$cykl]);@$cykl++;endwhile;
mysql_query("insert into kniha_urazu (osobni_cislo,text,datumvkladu,vlozil,poradi,prev_id,company_id)VALUES('".securesql(@$_POST["zamestnanec"])."','$text','$dnes','$loginname','2','".securesql(@$idu[0])."','".$companyid."')") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Nov�ho Z�znamu o �razu Prob�hlo �sp�n�</b></center></td></tr></table><?
} else { // upraveni ZoU@$cykl=1;while($cykl<60):$text.=securesql(@$_POST["value".$cykl]).":+:";unset($_POST["value".$cykl]);@$cykl++;endwhile;
mysql_query("update kniha_urazu set text='$text',datumzmeny='$dnes',zmenil='$loginname' where prev_id='".securesql(@$idu[0])."' ") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Upraven�ho Z�znamu o �razu Prob�hlo �sp�n�</b></center></td></tr></table><?
}}


if (@$_POST["tlacitko"]=="Ulo�it Z�znam Hl�en� Zm�n") {$idu=explode("/",@$_POST["idus"]);@$_POST["idu"]=@$_POST["idus"];@$_POST["submenu"]="Zo�-HZ";
$control=mysql_query("select id from kniha_urazu where prev_id='".securesql(@$_POST["idushz"])."' ");

if (!mysql_num_rows($control)) { // novy ZoU-HZ
@$cykl=1;while($cykl<60):$text.=securesql(@$_POST["value".$cykl]).":+:";if (@$cykl==2) {$companyid=securesql(@$_POST["value".$cykl]);}unset($_POST["value".$cykl]);@$cykl++;endwhile;
mysql_query("insert into kniha_urazu (osobni_cislo,text,datumvkladu,vlozil,poradi,prev_id,company_id)VALUES('".securesql(@$_POST["zamestnanec"])."','$text','$dnes','$loginname','3','".securesql(@$_POST["idushz"])."','".$companyid."')") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Nov�ho Z�znamu Hl�en� Zm�n Prob�hlo �sp�n�</b></center></td></tr></table><?
} else { // upraveni ZoU-HZ
@$cykl=1;while($cykl<60):$text.=securesql(@$_POST["value".$cykl]).":+:";unset($_POST["value".$cykl]);@$cykl++;endwhile;
mysql_query("update kniha_urazu set text='$text',datumzmeny='$dnes',zmenil='$loginname' where prev_id='".securesql(@$_POST["idushz"])."' ") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Upraven�ho Z�znamu Hl�en� Zm�n Prob�hlo �sp�n�</b></center></td></tr></table><?
}

}




if (@$_POST["tlacitko"]=="Ulo�it Nov� Z�znam") {@$cykl=1;while($cykl<50):$text.=securesql(@$_POST["value".$cykl]).":+:";if (@$cykl<>2) {unset($_POST["value".$cykl]);}@$cykl++;endwhile;
mysql_query("insert into kniha_urazu (osobni_cislo,text,datumvkladu,vlozil,poradi)VALUES('".securesql(@$_POST["value2"])."','$text','$dnes','$loginname','1')") or Die(MySQL_Error());
// prechod do upravy pro tisk
@$menu="�prava/Pokr. Existuj�c�ho Z�znamu";@$_POST["zamestnanec"]=securesql(@$_POST["value2"]);@$_POST["idu"]=mysql_insert_id()."/".datecs($dnes);
// konec nastaveni pro prechod
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Nov�ho Z�znamu Prob�hlo �sp�n�</b></center></td></tr></table><?
}


if (@$_POST["tlacitko"]=="Ulo�it Opraven� Z�znam") {$idu=explode("/",@$_POST["idus"]);@$_POST["idu"]=@$_POST["idus"];
@$cykl=1;while($cykl<50):$text.=securesql(@$_POST["value".$cykl]).":+:";unset($_POST["value".$cykl]);@$cykl++;endwhile;
mysql_query("update kniha_urazu set text='$text',datumzmeny='$dnes',zmenil='$loginname',poradi='1' where id='".securesql(@$idu[0])."' ") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Ulo�en� Opraven�ho Z�znamu Prob�hlo �sp�n�</b></center></td></tr></table><?
}
// end save

?>

<form action="hlavicka.php?akce=<?echo base64_encode('KnihaUrazu');?>" method=post><input name="menuold" type="hidden" value="<?echo@$menu;?>">
<?if (@$_POST["value2"]  and @$menu=="Zalo�it Nov� Z�znam") {?><input name="valueold" type="hidden" value="<?echo @$_POST["value2"];?>"><?}?>


<h2><p align="center">Kniha �raz�:
<? if (StrPos (" " . $_SESSION["prava"], "X") or StrPos (" " . $_SESSION["prava"], "x")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "X")){?>
   <?if (@$menu<>"Zalo�it Nov� Z�znam"){?><option>Zalo�it Nov� Z�znam</option><?}?>
   <?if (@$menu<>"�prava/Pokr. Existuj�c�ho Z�znamu"){?><option>�prava/Pokr. Existuj�c�ho Z�znamu</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "X") or StrPos (" " . $_SESSION["prava"], "x")){?>
   <?if (@$menu<>"P�ehled Existuj�c�ch Z�znam�"){?><option>P�ehled Existuj�c�ch Z�znam�</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "X") and (!StrPos (" " . $_SESSION["prava"], "x")) ){?>Nem�te P��stupov� Pr�va<?}?>

<center><table  bgcolor="#EDB745" border=2 frame="border" rules=all>




<? if (StrPos (" " . $_SESSION["prava"], "X")){?>



<?if (@$menu=="Zalo�it Nov� Z�znam"){$poradi=1;$values=mysql_query("select * from kniha_urazu order by id DESC limit 1");?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b>KNIHA �RAZ� - EVIDOVAN� �RAZ ZAM�STANCE �. <input name="value<?echo($poradi++);?>" type="text" value="<?echo (@mysql_result($values,0,0)+1);?>" style=text-align:right; size=10></b></center></td></tr>

<tr style=vertical-align:top><td colspan=2><center><b>Jm�no a p��jmen� ur�zem posti�en�ho zam�stnance:</b></center><select size="1" name="value<?echo($poradi);?>" style=width:100% onchange=submit(this)>
<?if (@$_POST["value".($poradi++)]) {echo"<option value='".@$_POST["value".($poradi-1)]."'>".mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".($poradi-1)])."'"),0,0)."</option>";} else {echo"<option></option>";}
$data1=mysql_query("select * from zamestnanci where (datumout<='$dnes' or datumout='0000-00-00') and jen_pruchod='NE' order by prijmeni,jmeno,osobni_cislo,id");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
echo "<option value='".mysql_result($data1,$cykl,1)."'>".mysql_result($data1,$cykl,4)." ".mysql_result($data1,$cykl,3)." ".mysql_result($data1,$cykl,2)."/".mysql_result($data1,$cykl,1)."</option>";
@$cykl++;endwhile;?></select></td>

<td align=center width=180px>Datum narozen�:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?echo datecs(mysql_result(mysql_query("select narozen from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."'"),0,0));?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus"></div></div></td>

<td>Adresa bydli�t�:<br /><textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["value".($poradi-1)] and @$_POST["value".($poradi-1)]<>" "){echo @$_POST["value".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(ulice,'\n',psc,' ',mesto) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".($poradi-3)])."'"),0,0);}?></textarea></td>
</tr>

<tr style=vertical-align:top><td colspan=2>Druh Pr�ce (CZ-ISCO):<textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["value".($poradi++)]) {echo @$_POST["value".($poradi++)];} else {echo mysql_result(mysql_query("select czisco from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?></textarea></td>
<td colspan=2>D�lka trv�n� z�kladn�ho pracovn�pr�vn�ho vztahu u zam�stavatele:<br /><br />

<?if (@$_POST["value2"]){$rozpadz=explode("-",mysql_result(mysql_query("select datumin from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."'"),0,0));
	$rozpadd=explode("-",$dnes);$roky=$rozpadd[0]-$rozpadz[0];$mesice=$rozpadd[1]-$rozpadz[1];if ($mesice<0) {$roky--;$mesice=12+$mesice;}
}?>
rok�: <input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["value".($poradi++)]) {echo @$_POST["value".($poradi-1)];}  else {echo @$roky;}?>" style=text-align:center>  m�s�c�: <input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["value".($poradi++)]) {echo @$_POST["value".($poradi-1)];} else {echo @$mesice;}?>" style=text-align:center></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Datum �razu:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus1"></div></div></td>

<td rowspan=2 align=center>Po�et hodin odpracovan�ch <br />bezprost�edn� p�ed vznikem �razu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center></td>
<td rowspan=2 colspan=2>�innost, p�i n� k �razu do�lo:<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Hodina �razu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=3>M�sto kde k �razu do�lo:<br /><textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
<td align=center>Bylo m�sto �razu pravideln�m<br /> pracovi�t�m zam�stnance?:<br />
<select size="1" name="value<?echo($poradi++);?>">
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Druh zran�n�:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
<td align=center rowspan=2>O�et�en u l�ka�e:<br /><select size="1" name="value<?echo($poradi++);?>">
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
<td rowspan=2 align=center>Celkov� po�et<br /> zran�n�ch osob:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Zran�n� ��st t�la:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
</tr>


<tr style=vertical-align:top>
<td colspan=3>Druh �razu:<p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["value".($poradi)]=="1") {echo" checked ";}?> > Smrteln�<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["value".($poradi)]=="2") {echo" checked ";}?> > S pracovn� neschopnost� del�� ne� 3 kalend��n� dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["value".($poradi)]=="3") {echo" checked ";}?> > S hospitalizac� p�esahuj�c� 5 dn�<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["value".($poradi)]=="4") {echo" checked ";}?> > S pracovn� neschopnost� krat�� ne� 3 kalend��n� dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["value".($poradi++)]=="5") {echo" checked ";}?> > Bez pracovn� neschopnosti</p>
</td>

<td>Z�znam o �razu seps�n dne:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus2"></div></div></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Popis �razov�ho d�je:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Pro� k �razu do�lo? (p���iny):<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
<td colspan=2>Co bylo zdrojem �razu?<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Byla u �razem posti�en�ho zam�stnance zji�t�na p��tomnost alkoholu (jin�ch n�vykov�ch l�tek)? <select size="1" name="value<?echo($poradi++);?>"><?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option><option>Neprov�d�la se</option>";} if (@$_POST["value".($poradi-1)]=="NE") {echo"<option>NE</option><option>ANO</option><option>Neprov�d�la se</option>";} if (@$_POST["value".($poradi-1)]=="Neprov�d�la se") {echo"<option>Neprov�d�la se</option><option>ANO</option><option>NE</option>";}?></select></td>
</tr>


<tr style=vertical-align:top>
<td colspan=4>Jak� p�edpisy byly v souvislosti s poran�n�m poru�eny a k�m?<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>�razem posti�en� zam�stnanec: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2 rowspan=3>Sv�dci �razu: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Z�stupce odborov� organizace<br />(z�stupce zam�stnanc� pro BOZP): </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Jm�no a pracovn� za�azen� toho,<br /> kdo �daje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, pracovn� za�azen�, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Pozn�mka:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off"><?if (@$_POST["value".($poradi++)]) {echo @$_POST["value".($poradi-1)];} else {echo "Poji��ovna: ".mysql_result(mysql_query("select pojistovna from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?></textarea></td>
</tr>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Ulo�it Nov� Z�znam"></center></td></tr><?}?>









<?if (@$menu=="�prava/Pokr. Existuj�c�ho Z�znamu" and !@$_POST["submenu"]){?>

<tr style=vertical-align:top bgcolor="#C0FFC0"><td align=center>Zam�stnanec: <select size="1" name="zamestnanec" onchange=submit(this)>
<?if (@$_POST["zamestnanec"]) {echo"<option value='".@$_POST["zamestnanec"]."'>".mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["zamestnanec"])."'"),0,0)."</option>";} else {echo"<option></option>";}
$data1=mysql_query("select * from zamestnanci where (datumout<='$dnes' or datumout='0000-00-00') and osobni_cislo in (select osobni_cislo from kniha_urazu) order by prijmeni,jmeno,osobni_cislo,id");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (@$_POST["zamestnanec"]<>mysql_result($data1,$cykl,1)) {echo "<option value='".mysql_result($data1,$cykl,1)."'>".mysql_result($data1,$cykl,4)." ".mysql_result($data1,$cykl,3)." ".mysql_result($data1,$cykl,2)."/".mysql_result($data1,$cykl,1)."</option>";}
@$cykl++;endwhile;?></select></td>

<td colspan=3>
<?if (@$_POST["zamestnanec"]){$data2=mysql_query("select * from kniha_urazu where osobni_cislo='".securesql(@$_POST["zamestnanec"])."' and poradi='1' order by datumvkladu,id");
@$cykl=0;while(@$cykl<mysql_num_rows(@$data2)):
echo"<input type=submit name=idu value='".mysql_result(@$data2,$cykl,0)."/".datecs(mysql_result(@$data2,$cykl,3))."'";if (@$_POST["idu"]==(mysql_result(@$data2,$cykl,0)."/".datecs(mysql_result(@$data2,$cykl,3)))) {echo" style=background-color:#EC0C06";}echo" > ";
@$cykl++;endwhile;}?>
</td></tr>

<?if (@$_POST["idu"]) {$idu=explode("/",@$_POST["idu"]);$data3=mysql_query("select * from kniha_urazu where id='".securesql(@$idu[0])."' ");
$data=explode(":+:",mysql_result($data3,0,2));
@$cykl=0;while(@$cykl<50):
@$_POST["value".($cykl+1)]=$data[@$cykl];
$cykl++;endwhile;$poradi=1;

?><input name="idus" type="hidden" value="<?echo @$_POST["idu"];?>">
<tr bgcolor="#C0FFC0"><td align=center><input type="button" value="Tisk Z�znamu" onclick="window.open('TiskUrazu.php?zamestnanec=<?echo base64_encode(@$_POST["zamestnanec"]);?>&id=<?echo base64_encode(@$idu[0]);?>');"> <input type="submit" name=submenu value="Zo�" <?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "))) {echo"style=background-color:#F3E80C";} else {echo"style=background-color:#20D028";}?> >
</td><td colspan=3><center><b>KNIHA �RAZ� - EVIDOVAN� �RAZ ZAM�STANCE �. <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".$poradi++];?>" style=text-align:right; size=10 readonly=yes></b></center></td>
</tr>

<tr style=vertical-align:top><td colspan=2><center><b>Jm�no a p��jmen� ur�zem posti�en�ho zam�stnance:</b></center>
<input type="text" value="<?echo mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".$poradi])."'"),0,0);?>" style=width:100%; readonly=yes>
<input name="value<?echo($poradi);?>" type="hidden" value="<?echo @$_POST["value".($poradi++)];?>">
</td>

<td align=center width=180px>Datum narozen�:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus"></div></div></td>

<td>Adresa bydli�t�:<br /><textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["value".($poradi-1)]){echo @$_POST["value".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(ulice,'\n',psc,' ',mesto) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".($poradi-3)])."'"),0,0);}?></textarea></td>
</tr>

<tr style=vertical-align:top><td colspan=2>Druh Pr�ce (CZ-ISCO):<textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
<td colspan=2>D�lka trv�n� z�kladn�ho pracovn�pr�vn�ho vztahu u zam�stavatele:<br /><br />
rok�: <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=text-align:center>  m�s�c�: <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=text-align:center></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Datum �razu:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus1"></div></div></td>

<td rowspan=2 align=center>Po�et hodin odpracovan�ch <br />bezprost�edn� p�ed vznikem �razu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center></td>
<td rowspan=2 colspan=2>�innost, p�i n� k �razu do�lo:<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Hodina �razu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=3>M�sto kde k �razu do�lo:<br /><textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
<td align=center>Bylo m�sto �razu pravideln�m<br /> pracovi�t�m zam�stnance?:<br />
<select size="1" name="value<?echo($poradi++);?>">
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Druh zran�n�:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
<td align=center rowspan=2>O�et�en u l�ka�e:<br /><select size="1" name="value<?echo($poradi++);?>">
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
<td rowspan=2 align=center>Celkov� po�et<br /> zran�n�ch osob:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Zran�n� ��st t�la:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
</tr>


<tr style=vertical-align:top>
<td colspan=3>Druh �razu:<p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["value".($poradi)]=="1") {echo" checked ";}?> > Smrteln�<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["value".($poradi)]=="2") {echo" checked ";}?> > S pracovn� neschopnost� del�� ne� 3 kalend��n� dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["value".($poradi)]=="3") {echo" checked ";}?> > S hospitalizac� p�esahuj�c� 5 dn�<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["value".($poradi)]=="4") {echo" checked ";}?> > S pracovn� neschopnost� krat�� ne� 3 kalend��n� dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["value".($poradi++)]=="5") {echo" checked ";}?> > Bez pracovn� neschopnosti</p>
</td>

<td>Z�znam o �razu seps�n dne:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus2"></div></div></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Popis �razov�ho d�je:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Pro� k �razu do�lo? (p���iny):<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
<td colspan=2>Co bylo zdrojem �razu?<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Byla u �razem posti�en�ho zam�stnance zji�t�na p��tomnost alkoholu (jin�ch n�vykov�ch l�tek)? <select size="1" name="value<?echo($poradi++);?>"><?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option><option>Neprov�d�la se</option>";} if (@$_POST["value".($poradi-1)]=="NE") {echo"<option>NE</option><option>ANO</option><option>Neprov�d�la se</option>";} if (@$_POST["value".($poradi-1)]=="Neprov�d�la se") {echo"<option>Neprov�d�la se</option><option>ANO</option><option>NE</option>";}?></select></td>
</tr>


<tr style=vertical-align:top>
<td colspan=4>Jak� p�edpisy byly v souvislosti s poran�n�m poru�eny a k�m?<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>�razem posti�en� zam�stnanec: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2 rowspan=3>Sv�dci �razu: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Z�stupce odborov� organizace<br />(z�stupce zam�stnanc� pro BOZP): </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Jm�no a pracovn� za�azen� toho,<br /> kdo �daje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jm�no, pracovn� za�azen�, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Pozn�mka:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Ulo�it Opraven� Z�znam"></center></td></tr><?}}?>









<?if (@$_POST["submenu"]=="Zo�-HZ" and @$menu=="�prava/Pokr. Existuj�c�ho Z�znamu"){?>

<tr style=vertical-align:top bgcolor="#C0FFC0"><td align=center colspan=2>Zam�stnanec:<br /><select size="1" name="zamestnanec" onchange=submit(this)>
<?if (@$_POST["zamestnanec"]) {echo"<option value='".@$_POST["zamestnanec"]."'>".mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["zamestnanec"])."'"),0,0)."</option>";} else {echo"<option></option>";}
$data1=mysql_query("select * from zamestnanci where (datumout<='$dnes' or datumout='0000-00-00') and osobni_cislo in (select osobni_cislo from kniha_urazu) order by prijmeni,jmeno,osobni_cislo,id");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (@$_POST["zamestnanec"]<>mysql_result($data1,$cykl,1)) {echo "<option value='".mysql_result($data1,$cykl,1)."'>".mysql_result($data1,$cykl,4)." ".mysql_result($data1,$cykl,3)." ".mysql_result($data1,$cykl,2)."/".mysql_result($data1,$cykl,1)."</option>";}
@$cykl++;endwhile;?></select></td>

<td colspan=2>
<?if (@$_POST["zamestnanec"]){$data2=mysql_query("select * from kniha_urazu where osobni_cislo='".securesql(@$_POST["zamestnanec"])."' and poradi='1' order by datumvkladu,id");
@$cykl=0;while(@$cykl<mysql_num_rows(@$data2)):
echo"<input type=submit name=idu value='".mysql_result(@$data2,$cykl,0)."/".datecs(mysql_result(@$data2,$cykl,3))."'";if (@$_POST["idus"]==(mysql_result(@$data2,$cykl,0)."/".datecs(mysql_result(@$data2,$cykl,3)))) {echo" style=background-color:#EC0C06";}echo" > ";
@$cykl++;endwhile;}?>
</td></tr>

<?if (@$_POST["idus"]) {$idu=explode("/",@$_POST["idus"]);
$data3=mysql_query("select * from kniha_urazu where prev_id='".securesql(@$idu[0])."' ");
$data=explode(":+:",mysql_result($data3,0,2));
@$cykl=0;while(@$cykl<50):
@$_POST["value".($cykl+1)]=$data[@$cykl];
$cykl++;endwhile;

?><input name="idushz" type="hidden" value="<?echo mysql_result($data3,0,0);?>"><?

if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(mysql_result($data3,0,0))."' "))) {
$data4=mysql_query("select * from kniha_urazu where prev_id='".securesql(mysql_result($data3,0,0))."' ");
$data=explode(":+:",mysql_result($data4,0,2));
@$cykl=0;while(@$cykl<50):
@$_POST["values".($cykl+1)]=$data[@$cykl];
$cykl++;endwhile;}

$poradi=1;

?><input name="idus" type="hidden" value="<?echo @$_POST["idus"];?>">
<tr bgcolor="#C0FFC0"><td align=center style=vertical-align:middle colspan=2>
<table width=100%><tr><td><?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(mysql_result($data3,0,0))."' "))) {?>
<input type="button" value="Tisk Zo�-HZ" onclick="window.open('TiskZoUHZ.php?prev_id=<?echo sifra(mysql_result($data3,0,0));?>');" style=width:32%><?}?>
<input type="submit" name=submenu value="Zo�" style=background-color:#F3E80C;width:32%; >
<input type="submit" name=submenu value="Zo�-HZ" style=background-color:#EC0C06 style=width:32%></td></tr></table>
</td><td colspan=2><center><b>Z�ZNAM O �RAZU - Hl��EN� ZM�N</b></center></td></tr>
<tr><td colspan=2></td><td colspan=2 align=right><i>Eviden�n� ��slo z�znamu: </i><input name="value<?echo($poradi++);?>" type="text" value="" style=width:150px disabled></td></tr>
<tr><td colspan=2></td><td colspan=2 align=right><i>Eviden�n� ��slo zam�stnavatele: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0)) {echo mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0);} else {echo "ZoU".date("Y").(substr(mysql_result(mysql_query("select company_id from kniha_urazu where company_id<>'' order by id desc limit 1"),0,0),7,15)+1);}?>" style=width:150px;text-align:center readonly=yes></td></tr>

<tr><td colspan=4 align=left><b><br />�daje o zam�stnavateli, kter� z�znam o �razu odeslal:</b></td></tr>
<tr><td rowspan=2 colspan=2 align=center style=vertical-align:top><i>N�zev zam�stnavatele:</i><br /><input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select nazev from firma where id='1'"),0,0);}?>" style=width:100% readonly=yes></td>
<td colspan=2><i>I�O: <input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value".($poradi-1)];}?>" style=width:88%;text-align:center readonly=yes></i></td></tr>
<tr><td colspan=2><i>Adresa: <input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(ulice,';',psc,' ',mesto) from firma where id='1'"),0,0);}?>" style=width:100% readonly=yes></i></td></tr>

<tr><td colspan=4 align=left><b><br />�daje o �razem posti�en�m zam�stnanci a o �razu:</b></td></tr>

<tr><td align=left style=vertical-align:top><i>Jm�no:</i></td><td><input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value13"];}?>" style=width:190px readonly=yes></td>
<td><i>Datum �razu:</i></td><td>
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value26"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center;width:60%><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus"></div></div>
</td></tr>
<tr><td><i>Datum narozen�:</i></td><td>
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value16"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center;width:68%><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus1"></div></div>
</td>

<td><i>M�sto, kde k �razu do�lo:</i></td><td><input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value7"];}?>" style=width:165px></td></tr>

<tr><td colspan=4 align=left><i><br />Hospitalizace �razem posti�en�ho zam�stnance p�es�hla 5 kalend��n�ch dn�: </i>
<select size="1" name="value<?echo($poradi);?>">
<?if (@$_POST["values".($poradi)]) {if (@$_POST["values".($poradi)]=="ANO") {echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}}
if (!@$_POST["values".($poradi++)]) {if (@$_POST["value1"]=="3") {Echo "<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}}?></select></td></tr>


<tr><td colspan=4 align=left><i><br />C 8 - Trv�n� do�asn� pracovn� neschopnosti n�sledkem �razu</i><br />
<table border=0 width=100%><tr><td width=30%>od: <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value23"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center;width:50%><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus2"></div></div>

</td><td width=30%>do: <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value24"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center;width:50%><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus3','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus3"></div></div>
</td>

<td width=40%>celkem kalend��n�ch dn�: <input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value25"];}?>" style=width:100px;text-align:center;></td></tr>
</table></td></tr>

<tr><td colspan=4 align=left><i><br />D 1 - �razem posti�en� zam�stnanec na n�sledky po�kozen� zdrav� p�i zem�el dne: </i>
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value28"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center;width:12%><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus4','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:520px;top:-1px;"><SPAN ID="span_pokus4"></div></div>
</td></tr>

<tr><td colspan=4 align=left><i><br />Jin� Zm�ny:</i>
<textarea name="value<?echo($poradi);?>" rows=10 style=width:100%  wrap="off"><?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];}?></textarea>
<br /></td></tr>

<tr style=vertical-align:top>
<td colspan=2>�razem posti�en� zam�stnanec: </td>
<td colspan=2 align=center><input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value40"];}?>" style=width:100%;text-align:center; >
datum, jm�no, pracovn� za�azen�, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Jm�no a pracovn� za�azen� toho,<br /> kdo �daje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value45"];}?>" style=width:100%;text-align:center; >
datum, jm�no, pracovn� za�azen�, podpis:</td>
</tr>
<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Ulo�it Z�znam Hl�en� Zm�n"></center></td></tr>

<?}}?>


















<?if (@$_POST["submenu"]=="Zo�" and @$menu=="�prava/Pokr. Existuj�c�ho Z�znamu"){?>

<tr style=vertical-align:top bgcolor="#C0FFC0"><td align=center>Zam�stnanec:<br /><select size="1" name="zamestnanec" onchange=submit(this)>
<?if (@$_POST["zamestnanec"]) {echo"<option value='".@$_POST["zamestnanec"]."'>".mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["zamestnanec"])."'"),0,0)."</option>";} else {echo"<option></option>";}
$data1=mysql_query("select * from zamestnanci where (datumout<='$dnes' or datumout='0000-00-00') and osobni_cislo in (select osobni_cislo from kniha_urazu) order by prijmeni,jmeno,osobni_cislo,id");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (@$_POST["zamestnanec"]<>mysql_result($data1,$cykl,1)) {echo "<option value='".mysql_result($data1,$cykl,1)."'>".mysql_result($data1,$cykl,4)." ".mysql_result($data1,$cykl,3)." ".mysql_result($data1,$cykl,2)."/".mysql_result($data1,$cykl,1)."</option>";}
@$cykl++;endwhile;?></select></td>

<td colspan=2>
<?if (@$_POST["zamestnanec"]){$data2=mysql_query("select * from kniha_urazu where osobni_cislo='".securesql(@$_POST["zamestnanec"])."' and poradi='1' order by datumvkladu,id");
@$cykl=0;while(@$cykl<mysql_num_rows(@$data2)):
echo"<input type=submit name=idu value='".mysql_result(@$data2,$cykl,0)."/".datecs(mysql_result(@$data2,$cykl,3))."'";if (@$_POST["idus"]==(mysql_result(@$data2,$cykl,0)."/".datecs(mysql_result(@$data2,$cykl,3)))) {echo" style=background-color:#EC0C06";}echo" > ";
@$cykl++;endwhile;}?>
</td></tr>

<?if (@$_POST["idus"]) {$idu=explode("/",@$_POST["idus"]);
$data3=mysql_query("select * from kniha_urazu where id='".securesql(@$idu[0])."' ");
$data=explode(":+:",mysql_result($data3,0,2));
@$cykl=0;while(@$cykl<50):
@$_POST["value".($cykl+1)]=$data[@$cykl];
$cykl++;endwhile;

if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "))) {
$data3=mysql_query("select * from kniha_urazu where prev_id='".securesql(@$idu[0])."' ");
$data=explode(":+:",mysql_result($data3,0,2));
@$cykl=0;while(@$cykl<50):
@$_POST["values".($cykl+1)]=$data[@$cykl];
$cykl++;endwhile;}

$poradi=1;

?><input name="idus" type="hidden" value="<?echo @$_POST["idus"];?>">
<tr bgcolor="#C0FFC0"><td align=center style=vertical-align:middle><table width=100%><tr><td><?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "))) {?><input type="button" value="Tisk Zo�" onclick="window.open('TiskZoU.php?prev_id=<?echo sifra(@$idu[0]);?>');" style=width:33%><?}?> <input type="submit" name=submenu value="Zo�" style=background-color:#EC0C06;width:33%; >
<?if (mysql_result(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0)) {?><input type="submit" name=submenu value="Zo�-HZ" <?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(mysql_result($data3,0,0))."' "))) {echo"style=background-color:#F3E80C";} else {echo"style=background-color:#20D028";}?> style=width:32%><?}?></td></tr></table>

</td><td colspan=2><center><b>Z�ZNAM O �RAZU</b></center></td></tr>
<tr><td><p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]==1) {echo "checked";} if (!@$_POST["values".($poradi)]) {if (@$_POST["value18"]=="1") {echo" checked ";}}?> > smrteln�m<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]==3) {echo "checked";} if (!@$_POST["values".($poradi)]) {if (@$_POST["value18"]=="3") {echo" checked ";}}?> > s hospitalizac� del�� ne� 5 dn�<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]==5) {echo "checked";} if (!@$_POST["values".($poradi++)]) {if (@$_POST["value18"]<>"1" and @$_POST["value18"]<>"3") {echo" checked ";}}?> > ostatn�m</p>
</td><td colspan=2></td></tr>
<tr><td></td><td colspan=2 align=right><i>Eviden�n� ��slo z�znamu: </i><input name="value<?echo($poradi++);?>" type="text" value="" style=width:150px disabled></td></tr>
<tr><td></td><td colspan=2 align=right><i>Eviden�n� ��slo zam�stnavatele: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0)) {echo mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0);} else {echo "ZoU".date("Y").(substr(mysql_result(mysql_query("select company_id from kniha_urazu where company_id<>'' order by id desc limit 1"),0,0),7,15)+1);}?>" style=width:150px;text-align:center readonly=yes></td></tr>

<tr><td colspan=3 align=center><b>A. �daje o zam�stnavateli, u kter�ho je �razem posti�en� zam�stnanec v z�kladn�m pracovn�pr�vn�m vztahu</b></td></tr>
<tr><td style=vertical-align:top><i>1. I�O:</i><input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select ico from firma where id='1' "),0,0);}?>" style=width:80%><br /><i>N�zev zam�stnavatele a jeho s�dlo (adresa):</i><br />
<textarea name="value<?echo($poradi++);?>" rows=5 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select concat(nazev,'\n',ulice,'\n',psc,' ',mesto) from firma where id=1"),0,0);}?></textarea></td>
<td colspan=2 style=vertical-align:top><i>2. P�edm�t podik�n� (CZ-NACE), v jeho� r�mci k �razu do�lo:</i><br />
<input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select cznace from firma where id='1' "),0,0);}?>" style=width:100%><hr></hr>
<i>3. M�sto, kde k �razu do�lo:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value12"];}?></textarea><hr></hr>
<i>4. Bylo m�sto �razu pravideln�m pracovi�t�m<br />�razem posti�en�ho zam�stnance?</i> <select size="1" name="value<?echo($poradi++);?>">
<?
if (@$_POST["values".($poradi-1)]) {if (@$_POST["values".($poradi-1)]=="ANO") {echo "<option>".@$_POST["values".($poradi-1)]."</option><option>NE</option>";}
if (@$_POST["values".($poradi-1)]=="NE") {echo "<option>".@$_POST["values".($poradi-1)]."</option><option>ANO</option>";}
} else {if (@$_POST["value13"]=="ANO"){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}}?>
</select></td></tr>

<tr><td colspan=3 align=center><b>B. �daje o zam�stnavateli, u kter�ho do�lo (pokud se nejedn� o zam�stnavatele uveden�ho v ��sti A z�znamu):</b></td></tr>
<tr><td style=vertical-align:top><i>1. I�O:</i><input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?>" style=width:80%><br /><i>N�zev zam�stnavatele a jeho s�dlo (adresa):</i><br />
<textarea name="value<?echo($poradi++);?>" rows=5 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td>
<td colspan=2 style=vertical-align:top><i>2. P�edm�t podik�n� (CZ-NACE), v jeho� r�mci k �razu do�lo:</i><br />
<input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?>" style=width:100%><hr></hr>
<i>3. M�sto, kde k �razu do�lo:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td></tr>

<tr><td colspan=3 align=center><b>C. �daje o �razem posti�en�m zam�stnanci</b></td></tr>
<tr><td><i>1. Jm�no: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" readonly=yes style=width:77%></td>
<input name="value<?echo($poradi++);?>" type="hidden" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value2"];}?>">
<td colspan=2 style=vertical-align:top><i>Pohlav�: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select pohlavi from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" readonly=yes style=width:10%></td></tr>

<tr><td><i>2. Datum narozen�: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select date_format(narozen,'%d.%m.%Y') from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" readonly=yes style=width:30%></td>
<td colspan=2><i>3. St�tn� ob�anstv�: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select obcanstvi from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" style=width:30%></td></tr>

<tr><td><i>4. Druh Pr�ce (CZ ISCO): </i><textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value5"];}?></textarea></td>
<td colspan=2><i>5. �innost, p�i kter� k �razu do�lo: </i><textarea name="value<?echo($poradi++);?>" rows=4 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value10"];}?></textarea>

<tr><td colspan=3><i>6. D�lka trv�n� z�kladn�ho pracovn�pr�vn�ho vztahu u zam�stnavatele: </i>
rok�: <input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value6"];}?>" readonly=yes style=width:5%;text-align:center;>
m�s�c�: <input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value7"];}?>" readonly=yes style=width:5%;text-align:center;>
</td></tr>

<tr><td colspan=3><i>7. �razem posti�en� je: </i><p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> > zam�stnanec v pracovn�m pom�ru<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?>> zam�stnanec zam�stnan� na z�klad� dohod o prac�ch konan�ch mimo pracovn� pom�r<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?>> osoba vykon�vaj�c� �innosti nebo poskytuj�c� slu�by mimo pracovn�pr�vn� vztahy (� 12 z�kona �. 309/2006 Sb.)<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi++)]=="4") {echo" checked ";}?>> zam�stnanec agentury pr�ce nebo do�asn� p�id�len� k v�konu pr�ce za ��elem prohlouben� kvalifikace u jin�
pr�vnick�<br /> nebo fyzick� osoby [� 38a z�kona �. 95/2004 Sb., o podm�nk�ch z�sk�v�n� a uzn�v�n� odborn� zp�sobilosti a specializovan� zp�sobilosti<br /> k v�konu zdravotnick�ho povol�n� l�ka�e
a farmaceuta, ve zn�n� pozd�j��ch p�edpis�, � 91a z�kona �. 96/2004 Sb., o podm�nk�ch z�sk�v�n�<br /> a uzn�v�n� zp�sobilosti k v�konu nel�ka�sk�ch zdravotnick�ch povol�n�
a k v�konu �innost� souvisej�c�ch s poskytov�n�m zdravotn� p��e<br /> a o zm�n� n�kter�ch souvisej�c�ch z�kon� (z�kon o nel�ka�sk�ch zdravotnick�ch povol�n�ch), ve zn�n� pozd�j��ch p�edpis�].</p>
</td></tr>

<tr><td colspan=3><i>8. Trv�n� do�asn� pracovn� neschopnosti n�sledkem �razu: </i><br />
<table width=100% border=0><tr><td width=33.3%> od:
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus"></div></div>

</td><td width=33.3%> do:
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus1"></div></div>
</td><td width=33.3%>celkem kalend��n�ch dn�: <input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?>" size=10 style=text-align:center></td></tr></table>
</td></tr>

<tr><td colspan=3 align=center><b>D. �daje o �razu</b></td></tr>
<tr><td><table border=0 with=100%><tr><td width=5% rowspan=4 style=vertical-align:top><i>1.</i></td><td width=95%><i>Datum �razu: </i>
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value8"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:70px;top:-1px;"><SPAN ID="span_pokus2"></div></div></td></tr>

<tr><td><i>  Hodina �razu: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value11"];}?>" size=10 style=text-align:center></td></tr>
<tr><td align=center><br /><i>Datum �mrt� �razem posti�en�ho zam�stnance:</i></i><br />
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus3','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:-100px;top:-1px;"><SPAN ID="span_pokus3"></div></div></td></tr></table>
</td><td colspan=2 style=vertical-align:top><i>2. Po�et hodin odpracovan�ch bezprost�edn� p�ed vznikem �razu: </i>
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value9"];}?>" size=5 style=text-align:center></td></tr>

<tr><td><i>3. Druh zran�n�: </i><br />
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value14"];}?>" style=width:100%>
</td>
<td colspan=2><i>4. Zran�n� ��st t�la:</i>
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value17"];}?>" style=width:100%>
</td></tr>

<tr><td colspan=3>
<i>5. Po�et zran�n�ch osob celkem: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value16"];}?>" size=10 style=text-align:center>
</td></tr>

<tr><td><i>6. Co bylo zdrojem �razu? </i><p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> > dopravn� prost�edek<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?> > stroje a za��zen� p�enosn� nebo mobiln�<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?> > materi�l, b�emena, p�edm�ty (p�d, p�ira�en�,<br /> odl�tnut�, n�raz, zavalen�)<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi)]=="4") {echo" checked ";}?> > p�d na rovin�, z v��ky, do hloubky, propadnut�<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]=="5") {echo" checked ";}?> > n�stroj, p��stroj, n��ad�</p>
</td><td colspan=2>
<p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="6" <?if (@$_POST["values".($poradi)]=="6") {echo" checked ";}?> > pr�myslov� �kodliviny, chemick� l�tky, biologick� �initele<br />
<input name="value<?echo($poradi);?>" type="radio" value="7" <?if (@$_POST["values".($poradi)]=="7") {echo" checked ";}?> > hork� l�tky a p�edm�ty, ohe� a v�bu�niny<br />
<input name="value<?echo($poradi);?>" type="radio" value="8" <?if (@$_POST["values".($poradi)]=="8") {echo" checked ";}?> > stroje a za��zen� stabiln�<br />
<input name="value<?echo($poradi);?>" type="radio" value="9" <?if (@$_POST["values".($poradi)]=="9") {echo" checked ";}?> > lid�, zv��ata nebo p��rodn� �ivly<br />
<input name="value<?echo($poradi);?>" type="radio" value="10" <?if (@$_POST["values".($poradi)]=="10") {echo" checked ";}?> > elektrick� energie<br />
<input name="value<?echo($poradi);?>" type="radio" value="11" <?if (@$_POST["values".($poradi++)]=="11") {echo" checked ";}?> > jin� bl�e nespecifikovan� zdroj</p>
</td></tr>

<tr><td><i>7. Pro� k �razu do�lo? (p���iny) </i><p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> > pro poruchu nebo vadn� stav n�kter�ho<br /> ze zdroj� �razu<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?> > pro �patn� nebo nedostate�n� vyhodnocen� rizika<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?> > pro z�vady na pracovi�ti</p>
</td><td colspan=2>
<p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi)]=="4") {echo" checked ";}?> > pro nedostate�n� osobn� zaji�t�n� zam�stnance v�etn� osobn�ch ochrann�ch<br /> pracovn�ch prost�edk�<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]=="5") {echo" checked ";}?> > pro poru�en� p�edpis� vztahuj�c�ch se k pr�ci nebo pokyn� zam�stnavatele<br /> �razem posti�en�ho zam�stnance<br />
<input name="value<?echo($poradi);?>" type="radio" value="6" <?if (@$_POST["values".($poradi)]=="6") {echo" checked ";}?> > pro nep�edv�dateln� riziko pr�ce nebo selh�n� lidsk�ho �initele<br />
<input name="value<?echo($poradi);?>" type="radio" value="7" <?if (@$_POST["values".($poradi++)]=="7") {echo" checked ";}?> > pro jin� bl�e nespecifikovan� d�vod</p>
</td></tr>

<tr><td align=center><i>8. Byla u �razem posti�en�ho zam�stnance zji�t�na<br /> p��tomnost alkoholu nebo jin�ch n�vykov�ch l�tek? </i><br />
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value23"];}?>" size=15 style=text-align:center>
</td><td colspan=2></td></tr>

<tr><td colspan=3><i>9. Popis �razov�ho d�je, rozveden� popisu m�sta, p���in a okolnost�, za nich� do�lo k �razu.(V p��pad� pot�eby p�ipojte dal�� list).</i><br />
<textarea name="value<?echo($poradi++);?>" rows=10 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value20"];}?></textarea></td></tr>

<tr><td colspan=3><i>10. Uve�te, jak� p�edpisy byli v souvislosti s �razem poru�eny a k�m, pokud bylo jejich poru�en� do doby odesl�n� z�znamu zji�t�no.(V p��pad� pot�eby p�ipojte dal�� list)</i><br />
<textarea name="value<?echo($poradi++);?>" rows=6 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value24"];}?></textarea></td></tr>

<tr><td colspan=3><i>11. Opat�en� p�ijat� k z�bran� opakov�n� pracovn�ho �razu:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=6 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td></tr>

<tr><td colspan=3 align=center><b>E. Vyj�d�en� �razem posti�en�ho zam�stnance a sv�dk� �razu</b></td></tr>
<tr><td colspan=3 align=center><textarea name="value<?echo($poradi++);?>" rows=12 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td></tr>

<tr style=vertical-align:top>
<td>�razem posti�en� zam�stnanec: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value25"];}?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td rowspan=3>Sv�dci �razu: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value26"];}?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value27"];}?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value28"];}?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td >Z�stupce odborov� organizace<br />(z�stupce zam�stnanc� pro BOZP): </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value29"];}?>" style=width:100%;text-align:center; >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td>Jm�no a pracovn� za�azen� toho,<br /> kdo �daje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value30"];}?>" style=width:100%;text-align:center; >
datum, jm�no, pracovn� za�azen�, podpis:</td>
</tr>

<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Ulo�it Z�znam o �razu"></center></td></tr><?}}?>
















<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "X") or  StrPos (" " . $_SESSION["prava"], "x") ){?>


<?if (@$menu=="P�ehled Existuj�c�ch Z�znam�" and !@$_POST["submenu"]){?>

<tr style=vertical-align:top bgcolor="#C0FFC0"><td align=center>Zam�stnanec: <select size="1" name="zamestnanec" onchange=submit(this)>
<?if (@$_POST["zamestnanec"]) {echo"<option value='".@$_POST["zamestnanec"]."'>".mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["zamestnanec"])."'"),0,0)."</option>";} else {echo"<option></option>";}
$data1=mysql_query("select * from zamestnanci where (datumout<='$dnes' or datumout='0000-00-00') and osobni_cislo in (select osobni_cislo from kniha_urazu) order by prijmeni,jmeno,osobni_cislo,id");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (@$_POST["zamestnanec"]<>mysql_result($data1,$cykl,1)) {echo "<option value='".mysql_result($data1,$cykl,1)."'>".mysql_result($data1,$cykl,4)." ".mysql_result($data1,$cykl,3)." ".mysql_result($data1,$cykl,2)."/".mysql_result($data1,$cykl,1)."</option>";}
@$cykl++;endwhile;?></select></td>

<td colspan=3>
<?if (@$_POST["zamestnanec"]){$data2=mysql_query("select * from kniha_urazu where osobni_cislo='".securesql(@$_POST["zamestnanec"])."' and poradi='1' order by datumvkladu,id");
@$cykl=0;while(@$cykl<mysql_num_rows(@$data2)):
echo"<input type=submit name=idu value='".mysql_result(@$data2,$cykl,0)."/".datecs(mysql_result(@$data2,$cykl,3))."'";if (@$_POST["idu"]==(mysql_result(@$data2,$cykl,0)."/".datecs(mysql_result(@$data2,$cykl,3)))) {echo" style=background-color:#EC0C06";}echo" > ";
@$cykl++;endwhile;}?>
</td></tr>

<?if (@$_POST["idu"]) {$idu=explode("/",@$_POST["idu"]);$data3=mysql_query("select * from kniha_urazu where id='".securesql(@$idu[0])."' ");
$data=explode(":+:",mysql_result($data3,0,2));
@$cykl=0;while(@$cykl<50):
@$_POST["value".($cykl+1)]=$data[@$cykl];
$cykl++;endwhile;$poradi=1;

?><input name="idus" type="hidden" value="<?echo @$_POST["idu"];?>">
<tr bgcolor="#C0FFC0"><td align=center><input type="button" value="Tisk Z�znamu" onclick="window.open('TiskUrazu.php?zamestnanec=<?echo base64_encode(@$_POST["zamestnanec"]);?>&id=<?echo base64_encode(@$idu[0]);?>');"><?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "))) {?><input type="submit" name=submenu value="Zo�" style=background-color:#F3E80C" ><?}?>
</td><td colspan=3><center><b>KNIHA �RAZ� - EVIDOVAN� �RAZ ZAM�STANCE �. <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".$poradi++];?>" style=text-align:right; size=10 readonly=yes></b></center></td></tr>

<tr style=vertical-align:top><td colspan=2><center><b>Jm�no a p��jmen� ur�zem posti�en�ho zam�stnance:</b></center>
<input type="text" value="<?echo mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".$poradi])."'"),0,0);?>" style=width:100%; readonly=yes>
<input name="value<?echo($poradi);?>" type="hidden" value="<?echo @$_POST["value".($poradi++)];?>" disabled>
</td>

<td align=center width=180px>Datum narozen�:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');"style="width:28%" disabled ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus"></div></div></td>

<td>Adresa bydli�t�:<br /><textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off" disabled><?if (@$_POST["value".($poradi-1)]){echo @$_POST["value".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(ulice,'\n',psc,' ',mesto) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".($poradi-3)])."'"),0,0);}?></textarea></td>
</tr>

<tr style=vertical-align:top><td colspan=2>Druh Pr�ce (CZ-ISCO):<textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
<td colspan=2>D�lka trv�n� z�kladn�ho pracovn�pr�vn�ho vztahu u zam�stavatele:<br /><br />
rok�: <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=text-align:center disabled>  m�s�c�: <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=text-align:center disabled></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Datum �razu:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');"style="width:28%" disabled ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus1"></div></div></td>

<td rowspan=2 align=center>Po�et hodin odpracovan�ch <br />bezprost�edn� p�ed vznikem �razu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; disabled></td>
<td rowspan=2 colspan=2>�innost, p�i n� k �razu do�lo:<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Hodina �razu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; disabled ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=3>M�sto kde k �razu do�lo:<br /><textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
<td align=center>Bylo m�sto �razu pravideln�m<br /> pracovi�t�m zam�stnance?:<br />
<select size="1" name="value<?echo($poradi++);?>" disabled>
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Druh zran�n�:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; disabled ></td>
<td align=center rowspan=2>O�et�en u l�ka�e:<br /><select size="1" name="value<?echo($poradi++);?>" disabled>
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
<td rowspan=2 align=center>Celkov� po�et<br /> zran�n�ch osob:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; disabled ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Zran�n� ��st t�la:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; disabled ></td>
</tr>


<tr style=vertical-align:top>
<td colspan=3>Druh �razu:<p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["value".($poradi)]=="1") {echo" checked ";}?> disabled > Smrteln�<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["value".($poradi)]=="2") {echo" checked ";}?> disabled > S pracovn� neschopnost� del�� ne� 3 kalend��n� dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["value".($poradi)]=="3") {echo" checked ";}?> disabled > S hospitalizac� p�esahuj�c� 5 dn�<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["value".($poradi)]=="4") {echo" checked ";}?> disabled > S pracovn� neschopnost� krat�� ne� 3 kalend��n� dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["value".($poradi++)]=="5") {echo" checked ";}?> disabled > Bez pracovn� neschopnosti</p>
</td>

<td>Z�znam o �razu seps�n dne:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');"style="width:28%" disabled ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus2"></div></div></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Popis �razov�ho d�je:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Pro� k �razu do�lo? (p���iny):<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; disabled ></td>
<td colspan=2>Co bylo zdrojem �razu?<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; disabled ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Byla u �razem posti�en�ho zam�stnance zji�t�na p��tomnost alkoholu (jin�ch n�vykov�ch l�tek)? <select size="1" name="value<?echo($poradi++);?>" disabled><?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option><option>Neprov�d�la se</option>";} if (@$_POST["value".($poradi-1)]=="NE") {echo"<option>NE</option><option>ANO</option><option>Neprov�d�la se</option>";} if (@$_POST["value".($poradi-1)]=="Neprov�d�la se") {echo"<option>Neprov�d�la se</option><option>ANO</option><option>NE</option>";}?></select></td>
</tr>


<tr style=vertical-align:top>
<td colspan=4>Jak� p�edpisy byly v souvislosti s poran�n�m poru�eny a k�m?<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>�razem posti�en� zam�stnanec: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2 rowspan=3>Sv�dci �razu: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jm�no, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jm�no, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Z�stupce odborov� organizace<br />(z�stupce zam�stnanc� pro BOZP): </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Jm�no a pracovn� za�azen� toho,<br /> kdo �daje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jm�no, pracovn� za�azen�, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Pozn�mka:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>
<?}}?>






<?if (@$_POST["submenu"]=="Zo�" and @$menu=="P�ehled Existuj�c�ch Z�znam�"){?>

<tr style=vertical-align:top bgcolor="#C0FFC0"><td align=center>Zam�stnanec:<br /><select size="1" name="zamestnanec" onchange=submit(this)>
<?if (@$_POST["zamestnanec"]) {echo"<option value='".@$_POST["zamestnanec"]."'>".mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["zamestnanec"])."'"),0,0)."</option>";} else {echo"<option></option>";}
$data1=mysql_query("select * from zamestnanci where (datumout<='$dnes' or datumout='0000-00-00') and osobni_cislo in (select osobni_cislo from kniha_urazu) order by prijmeni,jmeno,osobni_cislo,id");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (@$_POST["zamestnanec"]<>mysql_result($data1,$cykl,1)) {echo "<option value='".mysql_result($data1,$cykl,1)."'>".mysql_result($data1,$cykl,4)." ".mysql_result($data1,$cykl,3)." ".mysql_result($data1,$cykl,2)."/".mysql_result($data1,$cykl,1)."</option>";}
@$cykl++;endwhile;?></select></td>

<td colspan=2>
<?if (@$_POST["zamestnanec"]){$data2=mysql_query("select * from kniha_urazu where osobni_cislo='".securesql(@$_POST["zamestnanec"])."' and poradi='1' order by datumvkladu,id");
@$cykl=0;while(@$cykl<mysql_num_rows(@$data2)):
echo"<input type=submit name=idu value='".mysql_result(@$data2,$cykl,0)."/".datecs(mysql_result(@$data2,$cykl,3))."'";if (@$_POST["idus"]==(mysql_result(@$data2,$cykl,0)."/".datecs(mysql_result(@$data2,$cykl,3)))) {echo" style=background-color:#EC0C06";}echo" > ";
@$cykl++;endwhile;}?>
</td></tr>

<?if (@$_POST["idus"]) {$idu=explode("/",@$_POST["idus"]);
$data3=mysql_query("select * from kniha_urazu where id='".securesql(@$idu[0])."' ");
$data=explode(":+:",mysql_result($data3,0,2));
@$cykl=0;while(@$cykl<50):
@$_POST["value".($cykl+1)]=$data[@$cykl];
$cykl++;endwhile;

if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "))) {
$data3=mysql_query("select * from kniha_urazu where prev_id='".securesql(@$idu[0])."' ");
$data=explode(":+:",mysql_result($data3,0,2));
@$cykl=0;while(@$cykl<50):
@$_POST["values".($cykl+1)]=$data[@$cykl];
$cykl++;endwhile;}

$poradi=1;

?><input name="idus" type="hidden" value="<?echo @$_POST["idus"];?>">
<tr bgcolor="#C0FFC0"><td align=center style=vertical-align:middle><table width=100%><tr><td><?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "))) {?><input type="button" value="Tisk Zo�" onclick="window.open('TiskZoU.php?prev_id=<?echo sifra(@$idu[0]);?>');" style=width:33%><?}?> <input type="submit" name=submenu value="Zo�" style=background-color:#EC0C06;width:33%; >
<?if (mysql_result(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0)) {?><input type="submit" name=submenu1 value="Zo�-HZ" <?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(mysql_result($data3,0,0))."' "))) {echo"style=background-color:#F3E80C";} else {echo"style=background-color:#20D028";}?> style=width:32%><?}?></td></tr></table>

</td><td colspan=2><center><b>Z�ZNAM O �RAZU</b></center></td></tr>
<tr><td><p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]==1) {echo "checked";} if (!@$_POST["values".($poradi)]) {if (@$_POST["value18"]=="1") {echo" checked ";}}?> disabled > smrteln�m<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]==3) {echo "checked";} if (!@$_POST["values".($poradi)]) {if (@$_POST["value18"]=="3") {echo" checked ";}}?> disabled  > s hospitalizac� del�� ne� 5 dn�<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]==5) {echo "checked";} if (!@$_POST["values".($poradi++)]) {if (@$_POST["value18"]<>"1" and @$_POST["value18"]<>"3") {echo" checked ";}}?> disabled  > ostatn�m</p>
</td><td colspan=2></td></tr>
<tr><td></td><td colspan=2 align=right><i>Eviden�n� ��slo z�znamu: </i><input name="value<?echo($poradi++);?>" type="text" value="" style=width:150px disabled></td></tr>
<tr><td></td><td colspan=2 align=right><i>Eviden�n� ��slo zam�stnavatele: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0)) {echo mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0);} else {echo "ZoU".date("Y").(substr(mysql_result(mysql_query("select company_id from kniha_urazu where company_id<>'' order by id desc limit 1"),0,0),7,15)+1);}?>" style=width:150px;text-align:center  disabled ></td></tr>

<tr><td colspan=3 align=center><b>A. �daje o zam�stnavateli, u kter�ho je �razem posti�en� zam�stnanec v z�kladn�m pracovn�pr�vn�m vztahu</b></td></tr>
<tr><td style=vertical-align:top><i>1. I�O:</i><input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select ico from firma where id='1' "),0,0);}?>" style=width:80% disabled ><br /><i>N�zev zam�stnavatele a jeho s�dlo (adresa):</i><br />
<textarea name="value<?echo($poradi++);?>" rows=5 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select concat(nazev,'\n',ulice,'\n',psc,' ',mesto) from firma where id=1"),0,0);}?></textarea></td>
<td colspan=2 style=vertical-align:top><i>2. P�edm�t podik�n� (CZ-NACE), v jeho� r�mci k �razu do�lo:</i><br />
<input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select cznace from firma where id='1' "),0,0);}?>" style=width:100% disabled ><hr></hr>
<i>3. M�sto, kde k �razu do�lo:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value12"];}?></textarea><hr></hr>
<i>4. Bylo m�sto �razu pravideln�m pracovi�t�m<br />�razem posti�en�ho zam�stnance?</i> <select size="1" name="value<?echo($poradi++);?>" disabled >
<?
if (@$_POST["values".($poradi-1)]) {
if (@$_POST["values".($poradi-1)]=="ANO") {echo "<option>".@$_POST["values".($poradi-1)]."</option><option>NE</option>";}
if (@$_POST["values".($poradi-1)]=="NE") {echo "<option>".@$_POST["values".($poradi-1)]."</option><option>ANO</option>";}
} else {if (@$_POST["value13"]=="ANO"){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}}?>
</select></td></tr>

<tr><td colspan=3 align=center><b>B. �daje o zam�stnavateli, u kter�ho do�lo (pokud se nejedn� o zam�stnavatele uveden�ho v ��sti A z�znamu):</b></td></tr>
<tr><td style=vertical-align:top><i>1. I�O:</i><input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select ico from firma where id='1' "),0,0);}?>" style=width:80% disabled ><br /><i>N�zev zam�stnavatele a jeho s�dlo (adresa):</i><br />
<textarea name="value<?echo($poradi++);?>" rows=5 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select concat(nazev,'\n',ulice,'\n',psc,' ',mesto) from firma where id=1"),0,0);}?></textarea></td>
<td colspan=2 style=vertical-align:top><i>2. P�edm�t podik�n� (CZ-NACE), v jeho� r�mci k �razu do�lo:</i><br />
<input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select cznace from firma where id='1' "),0,0);}?>" style=width:100% disabled ><hr></hr>
<i>3. M�sto, kde k �razu do�lo:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value12"];}?></textarea></td></tr>

<tr><td colspan=3 align=center><b>C. �daje o �razem posti�en�m zam�stnanci</b></td></tr>
<tr><td><i>1. Jm�no: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>"  disabled  style=width:77%></td>
<input name="value<?echo($poradi++);?>" type="hidden" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value2"];}?>">
<td colspan=2 style=vertical-align:top><i>Pohlav�: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select pohlavi from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>"  disabled style=width:10%></td></tr>

<tr><td><i>2. Datum narozen�: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select date_format(narozen,'%d.%m.%Y') from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" disabled style=width:30%></td>
<td colspan=2><i>3. St�tn� ob�anstv�: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select obcanstvi from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" style=width:30% disabled ></td></tr>

<tr><td><i>4. Druh Pr�ce (CZ ISCO): </i><textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value5"];}?></textarea></td>
<td colspan=2><i>5. �innost, p�i kter� k �razu do�lo: </i><textarea name="value<?echo($poradi++);?>" rows=4 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value10"];}?></textarea>

<tr><td colspan=3><i>6. D�lka trv�n� z�kladn�ho pracovn�pr�vn�ho vztahu u zam�stnavatele: </i>
rok�: <input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value6"];}?>" disabled style=width:5%;text-align:center;>
m�s�c�: <input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value7"];}?>" disabled style=width:5%;text-align:center;>
</td></tr>

<tr><td colspan=3><i>7. �razem posti�en� je: </i><p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> disabled > zam�stnanec v pracovn�m pom�ru<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?> disabled > zam�stnanec zam�stnan� na z�klad� dohod o prac�ch konan�ch mimo pracovn� pom�r<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?> disabled > osoba vykon�vaj�c� �innosti nebo poskytuj�c� slu�by mimo pracovn�pr�vn� vztahy (� 12 z�kona �. 309/2006 Sb.)<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi++)]=="4") {echo" checked ";}?> disabled > zam�stnanec agentury pr�ce nebo do�asn� p�id�len� k v�konu pr�ce za ��elem prohlouben� kvalifikace u jin�
pr�vnick�<br /> nebo fyzick� osoby [� 38a z�kona �. 95/2004 Sb., o podm�nk�ch z�sk�v�n� a uzn�v�n� odborn� zp�sobilosti a specializovan� zp�sobilosti<br /> k v�konu zdravotnick�ho povol�n� l�ka�e
a farmaceuta, ve zn�n� pozd�j��ch p�edpis�, � 91a z�kona �. 96/2004 Sb., o podm�nk�ch z�sk�v�n�<br /> a uzn�v�n� zp�sobilosti k v�konu nel�ka�sk�ch zdravotnick�ch povol�n�
a k v�konu �innost� souvisej�c�ch s poskytov�n�m zdravotn� p��e<br /> a o zm�n� n�kter�ch souvisej�c�ch z�kon� (z�kon o nel�ka�sk�ch zdravotnick�ch povol�n�ch), ve zn�n� pozd�j��ch p�edpis�].</p>
</td></tr>

<tr><td colspan=3><i>8. Trv�n� do�asn� pracovn� neschopnosti n�sledkem �razu: </i><br />
<table width=100% border=0><tr><td width=33.3%> od:
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" disabled  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');" size="width:15" disabled  ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus"></div></div>

</td><td width=33.3%> do:
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" disabled style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');" size="width:15" disabled ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus1"></div></div>
</td><td width=33.3%>celkem kalend��n�ch dn�: <input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?>" size=10 style=text-align:center disabled ></td></tr></table>
</td></tr>

<tr><td colspan=3 align=center><b>D. �daje o �razu</b></td></tr>
<tr><td><table border=0 with=100%><tr><td width=5% rowspan=4 style=vertical-align:top><i>1.</i></td><td width=95%><i>Datum �razu: </i>
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value8"];}?>" size="10" disabled  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');" size="width:15" disabled ><div style="position:relative;"><div style="position:absolute;left:70px;top:-1px;"><SPAN ID="span_pokus2"></div></div></td></tr>

<tr><td><i>  Hodina �razu: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value11"];}?>" size=10 style=text-align:center disabled ></td></tr>
<tr><td align=center><br /><i>Datum �mrt� �razem posti�en�ho zam�stnance:</i></i><br />
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," �T"," ST"," �T"," P�"," SO"," NE"];var cMOY=["Leden","�nor","B�ezen","Duben","Kv�ten","�erven","�ervenec","Srpen","Z���","��jen","Listopad","Prosinec"];var imgPath="";
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
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" disabled  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus3','cpokus');" size="width:15" disabled ><div style="position:relative;"><div style="position:absolute;left:-100px;top:-1px;"><SPAN ID="span_pokus3"></div></div></td></tr></table>
</td><td colspan=2 style=vertical-align:top><i>2. Po�et hodin odpracovan�ch bezprost�edn� p�ed vznikem �razu: </i>
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value9"];}?>" size=5 style=text-align:center disabled ></td></tr>

<tr><td><i>3. Druh zran�n�: </i><br />
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value14"];}?>" style=width:100% disabled >
</td>
<td colspan=2><i>4. Zran�n� ��st t�la:</i>
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value17"];}?>" style=width:100% disabled >
</td></tr>

<tr><td colspan=3>
<i>5. Po�et zran�n�ch osob celkem: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value16"];}?>" size=10 style=text-align:center disabled >
</td></tr>

<tr><td><i>6. Co bylo zdrojem �razu? </i><p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> disabled > dopravn� prost�edek<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?> disabled > stroje a za��zen� p�enosn� nebo mobiln�<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?> disabled > materi�l, b�emena, p�edm�ty (p�d, p�ira�en�,<br /> odl�tnut�, n�raz, zavalen�)<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi)]=="4") {echo" checked ";}?> disabled > p�d na rovin�, z v��ky, do hloubky, propadnut�<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]=="5") {echo" checked ";}?> disabled > n�stroj, p��stroj, n��ad�</p>
</td><td colspan=2>
<p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="6" <?if (@$_POST["values".($poradi)]=="6") {echo" checked ";}?> disabled > pr�myslov� �kodliviny, chemick� l�tky, biologick� �initele<br />
<input name="value<?echo($poradi);?>" type="radio" value="7" <?if (@$_POST["values".($poradi)]=="7") {echo" checked ";}?> disabled > hork� l�tky a p�edm�ty, ohe� a v�bu�niny<br />
<input name="value<?echo($poradi);?>" type="radio" value="8" <?if (@$_POST["values".($poradi)]=="8") {echo" checked ";}?> disabled > stroje a za��zen� stabiln�<br />
<input name="value<?echo($poradi);?>" type="radio" value="9" <?if (@$_POST["values".($poradi)]=="9") {echo" checked ";}?> disabled > lid�, zv��ata nebo p��rodn� �ivly<br />
<input name="value<?echo($poradi);?>" type="radio" value="10" <?if (@$_POST["values".($poradi)]=="10") {echo" checked ";}?> disabled > elektrick� energie<br />
<input name="value<?echo($poradi);?>" type="radio" value="11" <?if (@$_POST["values".($poradi++)]=="11") {echo" checked ";}?> disabled > jin� bl�e nespecifikovan� zdroj</p>
</td></tr>

<tr><td><i>7. Pro� k �razu do�lo? (p���iny) </i><p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> disabled > pro poruchu nebo vadn� stav n�kter�ho<br /> ze zdroj� �razu<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?> disabled > pro �patn� nebo nedostate�n� vyhodnocen� rizika<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?> disabled > pro z�vady na pracovi�ti</p>
</td><td colspan=2>
<p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi)]=="4") {echo" checked ";}?> disabled > pro nedostate�n� osobn� zaji�t�n� zam�stnance v�etn� osobn�ch ochrann�ch<br /> pracovn�ch prost�edk�<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]=="5") {echo" checked ";}?> disabled > pro poru�en� p�edpis� vztahuj�c�ch se k pr�ci nebo pokyn� zam�stnavatele<br /> �razem posti�en�ho zam�stnance<br />
<input name="value<?echo($poradi);?>" type="radio" value="6" <?if (@$_POST["values".($poradi)]=="6") {echo" checked ";}?> disabled > pro nep�edv�dateln� riziko pr�ce nebo selh�n� lidsk�ho �initele<br />
<input name="value<?echo($poradi);?>" type="radio" value="7" <?if (@$_POST["values".($poradi++)]=="7") {echo" checked ";}?> disabled > pro jin� bl�e nespecifikovan� d�vod</p>
</td></tr>

<tr><td align=center><i>8. Byla u �razem posti�en�ho zam�stnance zji�t�na<br /> p��tomnost alkoholu nebo jin�ch n�vykov�ch l�tek? </i><br />
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value23"];}?>" size=15 style=text-align:center disabled >
</td><td colspan=2></td></tr>

<tr><td colspan=3><i>9. Popis �razov�ho d�je, rozveden� popisu m�sta, p���in a okolnost�, za nich� do�lo k �razu.(V p��pad� pot�eby p�ipojte dal�� list).</i><br />
<textarea name="value<?echo($poradi++);?>" rows=10 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value20"];}?></textarea></td></tr>

<tr><td colspan=3><i>10. Uve�te, jak� p�edpisy byli v souvislosti s �razem poru�eny a k�m, pokud bylo jejich poru�en� do doby odesl�n� z�znamu zji�t�no.(V p��pad� pot�eby p�ipojte dal�� list)</i><br />
<textarea name="value<?echo($poradi++);?>" rows=6 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value24"];}?></textarea></td></tr>

<tr><td colspan=3><i>11. Opat�en� p�ijat� k z�bran� opakov�n� pracovn�ho �razu:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=6 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td></tr>

<tr><td colspan=3 align=center><b>E. Vyj�d�en� �razem posti�en�ho zam�stnance a sv�dk� �razu</b></td></tr>
<tr><td colspan=3 align=center><textarea name="value<?echo($poradi++);?>" rows=12 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td></tr>

<tr style=vertical-align:top>
<td>�razem posti�en� zam�stnanec: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value25"];}?>" style=width:100%;text-align:center;  disabled >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td rowspan=3>Sv�dci �razu: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value26"];}?>" style=width:100%;text-align:center; disabled >
datum, jm�no, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value27"];}?>" style=width:100%;text-align:center; disabled >
datum, jm�no, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value28"];}?>" style=width:100%;text-align:center; disabled >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td >Z�stupce odborov� organizace<br />(z�stupce zam�stnanc� pro BOZP): </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value29"];}?>" style=width:100%;text-align:center; disabled >
datum, jm�no, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td>Jm�no a pracovn� za�azen� toho,<br /> kdo �daje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value30"];}?>" style=width:100%;text-align:center; disabled >
datum, jm�no, pracovn� za�azen�, podpis:</td>
</tr>
<?}}?>


<?}?>






</table></center>
</form>
