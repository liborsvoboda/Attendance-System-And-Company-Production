<?
//  menu
@$menu=@$_POST["menu"];

if ((@$menu<>@$_POST["menuold"] and @$_POST["menuold"]) or @$_POST["idu"] or (@$menu=="Založit Nový Záznam" and @$_POST["value2"]<>@$_POST["valueold"] )) {$cykl=1;while($cykl<50): if (@$cykl<>2) {unset($_POST["value".$cykl]);}@$cykl++;endwhile;}


//save
if (@$_POST["tlacitko"]=="Uložit Záznam o Úrazu") {$idu=explode("/",@$_POST["idus"]);@$_POST["idu"]=@$_POST["idus"];@$_POST["submenu"]="ZoÚ";$control=mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."'");

if (!mysql_num_rows($control)) { // novy ZoU
@$cykl=1;while($cykl<60):$text.=securesql(@$_POST["value".$cykl]).":+:";if (@$cykl==3) {$companyid=securesql(@$_POST["value".$cykl]);}unset($_POST["value".$cykl]);@$cykl++;endwhile;
mysql_query("insert into kniha_urazu (osobni_cislo,text,datumvkladu,vlozil,poradi,prev_id,company_id)VALUES('".securesql(@$_POST["zamestnanec"])."','$text','$dnes','$loginname','2','".securesql(@$idu[0])."','".$companyid."')") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Nového Záznamu o Úrazu Probìhlo Úspìšnì</b></center></td></tr></table><?
} else { // upraveni ZoU@$cykl=1;while($cykl<60):$text.=securesql(@$_POST["value".$cykl]).":+:";unset($_POST["value".$cykl]);@$cykl++;endwhile;
mysql_query("update kniha_urazu set text='$text',datumzmeny='$dnes',zmenil='$loginname' where prev_id='".securesql(@$idu[0])."' ") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Upraveného Záznamu o Úrazu Probìhlo Úspìšnì</b></center></td></tr></table><?
}}


if (@$_POST["tlacitko"]=="Uložit Záznam Hlášení Zmìn") {$idu=explode("/",@$_POST["idus"]);@$_POST["idu"]=@$_POST["idus"];@$_POST["submenu"]="ZoÚ-HZ";
$control=mysql_query("select id from kniha_urazu where prev_id='".securesql(@$_POST["idushz"])."' ");

if (!mysql_num_rows($control)) { // novy ZoU-HZ
@$cykl=1;while($cykl<60):$text.=securesql(@$_POST["value".$cykl]).":+:";if (@$cykl==2) {$companyid=securesql(@$_POST["value".$cykl]);}unset($_POST["value".$cykl]);@$cykl++;endwhile;
mysql_query("insert into kniha_urazu (osobni_cislo,text,datumvkladu,vlozil,poradi,prev_id,company_id)VALUES('".securesql(@$_POST["zamestnanec"])."','$text','$dnes','$loginname','3','".securesql(@$_POST["idushz"])."','".$companyid."')") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Nového Záznamu Hlášení Zmìn Probìhlo Úspìšnì</b></center></td></tr></table><?
} else { // upraveni ZoU-HZ
@$cykl=1;while($cykl<60):$text.=securesql(@$_POST["value".$cykl]).":+:";unset($_POST["value".$cykl]);@$cykl++;endwhile;
mysql_query("update kniha_urazu set text='$text',datumzmeny='$dnes',zmenil='$loginname' where prev_id='".securesql(@$_POST["idushz"])."' ") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Upraveného Záznamu Hlášení Zmìn Probìhlo Úspìšnì</b></center></td></tr></table><?
}

}




if (@$_POST["tlacitko"]=="Uložit Nový Záznam") {@$cykl=1;while($cykl<50):$text.=securesql(@$_POST["value".$cykl]).":+:";if (@$cykl<>2) {unset($_POST["value".$cykl]);}@$cykl++;endwhile;
mysql_query("insert into kniha_urazu (osobni_cislo,text,datumvkladu,vlozil,poradi)VALUES('".securesql(@$_POST["value2"])."','$text','$dnes','$loginname','1')") or Die(MySQL_Error());
// prechod do upravy pro tisk
@$menu="Úprava/Pokr. Existujícího Záznamu";@$_POST["zamestnanec"]=securesql(@$_POST["value2"]);@$_POST["idu"]=mysql_insert_id()."/".datecs($dnes);
// konec nastaveni pro prechod
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Nového Záznamu Probìhlo Úspìšnì</b></center></td></tr></table><?
}


if (@$_POST["tlacitko"]=="Uložit Opravený Záznam") {$idu=explode("/",@$_POST["idus"]);@$_POST["idu"]=@$_POST["idus"];
@$cykl=1;while($cykl<50):$text.=securesql(@$_POST["value".$cykl]).":+:";unset($_POST["value".$cykl]);@$cykl++;endwhile;
mysql_query("update kniha_urazu set text='$text',datumzmeny='$dnes',zmenil='$loginname',poradi='1' where id='".securesql(@$idu[0])."' ") or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Opraveného Záznamu Probìhlo Úspìšnì</b></center></td></tr></table><?
}
// end save

?>

<form action="hlavicka.php?akce=<?echo base64_encode('KnihaUrazu');?>" method=post><input name="menuold" type="hidden" value="<?echo@$menu;?>">
<?if (@$_POST["value2"]  and @$menu=="Založit Nový Záznam") {?><input name="valueold" type="hidden" value="<?echo @$_POST["value2"];?>"><?}?>


<h2><p align="center">Kniha Úrazù:
<? if (StrPos (" " . $_SESSION["prava"], "X") or StrPos (" " . $_SESSION["prava"], "x")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "X")){?>
   <?if (@$menu<>"Založit Nový Záznam"){?><option>Založit Nový Záznam</option><?}?>
   <?if (@$menu<>"Úprava/Pokr. Existujícího Záznamu"){?><option>Úprava/Pokr. Existujícího Záznamu</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "X") or StrPos (" " . $_SESSION["prava"], "x")){?>
   <?if (@$menu<>"Pøehled Existujících Záznamù"){?><option>Pøehled Existujících Záznamù</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "X") and (!StrPos (" " . $_SESSION["prava"], "x")) ){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2 frame="border" rules=all>




<? if (StrPos (" " . $_SESSION["prava"], "X")){?>



<?if (@$menu=="Založit Nový Záznam"){$poradi=1;$values=mysql_query("select * from kniha_urazu order by id DESC limit 1");?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b>KNIHA ÚRAZÙ - EVIDOVANÝ ÚRAZ ZAMÌSTANCE è. <input name="value<?echo($poradi++);?>" type="text" value="<?echo (@mysql_result($values,0,0)+1);?>" style=text-align:right; size=10></b></center></td></tr>

<tr style=vertical-align:top><td colspan=2><center><b>Jméno a pøíjmení urázem postiženého zamìstnance:</b></center><select size="1" name="value<?echo($poradi);?>" style=width:100% onchange=submit(this)>
<?if (@$_POST["value".($poradi++)]) {echo"<option value='".@$_POST["value".($poradi-1)]."'>".mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".($poradi-1)])."'"),0,0)."</option>";} else {echo"<option></option>";}
$data1=mysql_query("select * from zamestnanci where (datumout<='$dnes' or datumout='0000-00-00') and jen_pruchod='NE' order by prijmeni,jmeno,osobni_cislo,id");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
echo "<option value='".mysql_result($data1,$cykl,1)."'>".mysql_result($data1,$cykl,4)." ".mysql_result($data1,$cykl,3)." ".mysql_result($data1,$cykl,2)."/".mysql_result($data1,$cykl,1)."</option>";
@$cykl++;endwhile;?></select></td>

<td align=center width=180px>Datum narození:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?echo datecs(mysql_result(mysql_query("select narozen from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."'"),0,0));?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus"></div></div></td>

<td>Adresa bydlištì:<br /><textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["value".($poradi-1)] and @$_POST["value".($poradi-1)]<>" "){echo @$_POST["value".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(ulice,'\n',psc,' ',mesto) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".($poradi-3)])."'"),0,0);}?></textarea></td>
</tr>

<tr style=vertical-align:top><td colspan=2>Druh Práce (CZ-ISCO):<textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["value".($poradi++)]) {echo @$_POST["value".($poradi++)];} else {echo mysql_result(mysql_query("select czisco from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?></textarea></td>
<td colspan=2>Délka trvání základního pracovnìprávního vztahu u zamìstavatele:<br /><br />

<?if (@$_POST["value2"]){$rozpadz=explode("-",mysql_result(mysql_query("select datumin from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."'"),0,0));
	$rozpadd=explode("-",$dnes);$roky=$rozpadd[0]-$rozpadz[0];$mesice=$rozpadd[1]-$rozpadz[1];if ($mesice<0) {$roky--;$mesice=12+$mesice;}
}?>
rokù: <input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["value".($poradi++)]) {echo @$_POST["value".($poradi-1)];}  else {echo @$roky;}?>" style=text-align:center>  mìsícù: <input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["value".($poradi++)]) {echo @$_POST["value".($poradi-1)];} else {echo @$mesice;}?>" style=text-align:center></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Datum úrazu:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus1"></div></div></td>

<td rowspan=2 align=center>Poèet hodin odpracovaných <br />bezprostøednì pøed vznikem úrazu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center></td>
<td rowspan=2 colspan=2>Èinnost, pøi níž k úrazu došlo:<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Hodina úrazu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=3>Místo kde k úrazu došlo:<br /><textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
<td align=center>Bylo místo úrazu pravidelným<br /> pracovištìm zamìstnance?:<br />
<select size="1" name="value<?echo($poradi++);?>">
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Druh zranìní:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
<td align=center rowspan=2>Ošetøen u lékaøe:<br /><select size="1" name="value<?echo($poradi++);?>">
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
<td rowspan=2 align=center>Celkový poèet<br /> zranìných osob:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Zranìná èást tìla:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
</tr>


<tr style=vertical-align:top>
<td colspan=3>Druh úrazu:<p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["value".($poradi)]=="1") {echo" checked ";}?> > Smrtelný<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["value".($poradi)]=="2") {echo" checked ";}?> > S pracovní neschopností delší než 3 kalendáøní dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["value".($poradi)]=="3") {echo" checked ";}?> > S hospitalizací pøesahující 5 dnù<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["value".($poradi)]=="4") {echo" checked ";}?> > S pracovní neschopností kratší než 3 kalendáøní dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["value".($poradi++)]=="5") {echo" checked ";}?> > Bez pracovní neschopnosti</p>
</td>

<td>Záznam o úrazu sepsán dne:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus2"></div></div></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Popis úrazového dìje:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Proè k úrazu došlo? (pøíèiny):<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
<td colspan=2>Co bylo zdrojem úrazu?<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Byla u úrazem postiženého zamìstnance zjištìna pøítomnost alkoholu (jiných návykových látek)? <select size="1" name="value<?echo($poradi++);?>"><?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option><option>Neprovádìla se</option>";} if (@$_POST["value".($poradi-1)]=="NE") {echo"<option>NE</option><option>ANO</option><option>Neprovádìla se</option>";} if (@$_POST["value".($poradi-1)]=="Neprovádìla se") {echo"<option>Neprovádìla se</option><option>ANO</option><option>NE</option>";}?></select></td>
</tr>


<tr style=vertical-align:top>
<td colspan=4>Jaké pøedpisy byly v souvislosti s poranìním porušeny a kým?<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Úrazem postižený zamìstnanec: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2 rowspan=3>Svìdci úrazu: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Zástupce odborové organizace<br />(zástupce zamìstnancù pro BOZP): </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Jméno a pracovní zaøazení toho,<br /> kdo údaje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, pracovní zaøazení, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Poznámka:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off"><?if (@$_POST["value".($poradi++)]) {echo @$_POST["value".($poradi-1)];} else {echo "Pojišovna: ".mysql_result(mysql_query("select pojistovna from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?></textarea></td>
</tr>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Uložit Nový Záznam"></center></td></tr><?}?>









<?if (@$menu=="Úprava/Pokr. Existujícího Záznamu" and !@$_POST["submenu"]){?>

<tr style=vertical-align:top bgcolor="#C0FFC0"><td align=center>Zamìstnanec: <select size="1" name="zamestnanec" onchange=submit(this)>
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
<tr bgcolor="#C0FFC0"><td align=center><input type="button" value="Tisk Záznamu" onclick="window.open('TiskUrazu.php?zamestnanec=<?echo base64_encode(@$_POST["zamestnanec"]);?>&id=<?echo base64_encode(@$idu[0]);?>');"> <input type="submit" name=submenu value="ZoÚ" <?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "))) {echo"style=background-color:#F3E80C";} else {echo"style=background-color:#20D028";}?> >
</td><td colspan=3><center><b>KNIHA ÚRAZÙ - EVIDOVANÝ ÚRAZ ZAMÌSTANCE è. <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".$poradi++];?>" style=text-align:right; size=10 readonly=yes></b></center></td>
</tr>

<tr style=vertical-align:top><td colspan=2><center><b>Jméno a pøíjmení urázem postiženého zamìstnance:</b></center>
<input type="text" value="<?echo mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".$poradi])."'"),0,0);?>" style=width:100%; readonly=yes>
<input name="value<?echo($poradi);?>" type="hidden" value="<?echo @$_POST["value".($poradi++)];?>">
</td>

<td align=center width=180px>Datum narození:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus"></div></div></td>

<td>Adresa bydlištì:<br /><textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["value".($poradi-1)]){echo @$_POST["value".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(ulice,'\n',psc,' ',mesto) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".($poradi-3)])."'"),0,0);}?></textarea></td>
</tr>

<tr style=vertical-align:top><td colspan=2>Druh Práce (CZ-ISCO):<textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
<td colspan=2>Délka trvání základního pracovnìprávního vztahu u zamìstavatele:<br /><br />
rokù: <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=text-align:center>  mìsícù: <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=text-align:center></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Datum úrazu:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus1"></div></div></td>

<td rowspan=2 align=center>Poèet hodin odpracovaných <br />bezprostøednì pøed vznikem úrazu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center></td>
<td rowspan=2 colspan=2>Èinnost, pøi níž k úrazu došlo:<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Hodina úrazu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=3>Místo kde k úrazu došlo:<br /><textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
<td align=center>Bylo místo úrazu pravidelným<br /> pracovištìm zamìstnance?:<br />
<select size="1" name="value<?echo($poradi++);?>">
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Druh zranìní:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
<td align=center rowspan=2>Ošetøen u lékaøe:<br /><select size="1" name="value<?echo($poradi++);?>">
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
<td rowspan=2 align=center>Celkový poèet<br /> zranìných osob:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Zranìná èást tìla:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
</tr>


<tr style=vertical-align:top>
<td colspan=3>Druh úrazu:<p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["value".($poradi)]=="1") {echo" checked ";}?> > Smrtelný<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["value".($poradi)]=="2") {echo" checked ";}?> > S pracovní neschopností delší než 3 kalendáøní dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["value".($poradi)]=="3") {echo" checked ";}?> > S hospitalizací pøesahující 5 dnù<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["value".($poradi)]=="4") {echo" checked ";}?> > S pracovní neschopností kratší než 3 kalendáøní dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["value".($poradi++)]=="5") {echo" checked ";}?> > Bez pracovní neschopnosti</p>
</td>

<td>Záznam o úrazu sepsán dne:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');"style="width:28%" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus2"></div></div></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Popis úrazového dìje:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Proè k úrazu došlo? (pøíèiny):<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
<td colspan=2>Co bylo zdrojem úrazu?<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Byla u úrazem postiženého zamìstnance zjištìna pøítomnost alkoholu (jiných návykových látek)? <select size="1" name="value<?echo($poradi++);?>"><?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option><option>Neprovádìla se</option>";} if (@$_POST["value".($poradi-1)]=="NE") {echo"<option>NE</option><option>ANO</option><option>Neprovádìla se</option>";} if (@$_POST["value".($poradi-1)]=="Neprovádìla se") {echo"<option>Neprovádìla se</option><option>ANO</option><option>NE</option>";}?></select></td>
</tr>


<tr style=vertical-align:top>
<td colspan=4>Jaké pøedpisy byly v souvislosti s poranìním porušeny a kým?<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Úrazem postižený zamìstnanec: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2 rowspan=3>Svìdci úrazu: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Zástupce odborové organizace<br />(zástupce zamìstnancù pro BOZP): </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Jméno a pracovní zaøazení toho,<br /> kdo údaje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; >
datum, jméno, pracovní zaøazení, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Poznámka:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off"><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Uložit Opravený Záznam"></center></td></tr><?}}?>









<?if (@$_POST["submenu"]=="ZoÚ-HZ" and @$menu=="Úprava/Pokr. Existujícího Záznamu"){?>

<tr style=vertical-align:top bgcolor="#C0FFC0"><td align=center colspan=2>Zamìstnanec:<br /><select size="1" name="zamestnanec" onchange=submit(this)>
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
<input type="button" value="Tisk ZoÚ-HZ" onclick="window.open('TiskZoUHZ.php?prev_id=<?echo sifra(mysql_result($data3,0,0));?>');" style=width:32%><?}?>
<input type="submit" name=submenu value="ZoÚ" style=background-color:#F3E80C;width:32%; >
<input type="submit" name=submenu value="ZoÚ-HZ" style=background-color:#EC0C06 style=width:32%></td></tr></table>
</td><td colspan=2><center><b>ZÁZNAM O ÚRAZU - HlÁŠENÍ ZMÌN</b></center></td></tr>
<tr><td colspan=2></td><td colspan=2 align=right><i>Evidenèní èíslo záznamu: </i><input name="value<?echo($poradi++);?>" type="text" value="" style=width:150px disabled></td></tr>
<tr><td colspan=2></td><td colspan=2 align=right><i>Evidenèní èíslo zamìstnavatele: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0)) {echo mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0);} else {echo "ZoU".date("Y").(substr(mysql_result(mysql_query("select company_id from kniha_urazu where company_id<>'' order by id desc limit 1"),0,0),7,15)+1);}?>" style=width:150px;text-align:center readonly=yes></td></tr>

<tr><td colspan=4 align=left><b><br />Údaje o zamìstnavateli, který záznam o úrazu odeslal:</b></td></tr>
<tr><td rowspan=2 colspan=2 align=center style=vertical-align:top><i>Název zamìstnavatele:</i><br /><input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select nazev from firma where id='1'"),0,0);}?>" style=width:100% readonly=yes></td>
<td colspan=2><i>IÈO: <input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value".($poradi-1)];}?>" style=width:88%;text-align:center readonly=yes></i></td></tr>
<tr><td colspan=2><i>Adresa: <input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(ulice,';',psc,' ',mesto) from firma where id='1'"),0,0);}?>" style=width:100% readonly=yes></i></td></tr>

<tr><td colspan=4 align=left><b><br />Údaje o úrazem postiženém zamìstnanci a o úrazu:</b></td></tr>

<tr><td align=left style=vertical-align:top><i>Jméno:</i></td><td><input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value13"];}?>" style=width:190px readonly=yes></td>
<td><i>Datum úrazu:</i></td><td>
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value26"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center;width:60%><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus"></div></div>
</td></tr>
<tr><td><i>Datum narození:</i></td><td>
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value16"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center;width:68%><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus1"></div></div>
</td>

<td><i>Místo, kde k úrazu došlo:</i></td><td><input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value7"];}?>" style=width:165px></td></tr>

<tr><td colspan=4 align=left><i><br />Hospitalizace úrazem postiženého zamìstnance pøesáhla 5 kalendáøních dnù: </i>
<select size="1" name="value<?echo($poradi);?>">
<?if (@$_POST["values".($poradi)]) {if (@$_POST["values".($poradi)]=="ANO") {echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}}
if (!@$_POST["values".($poradi++)]) {if (@$_POST["value1"]=="3") {Echo "<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}}?></select></td></tr>


<tr><td colspan=4 align=left><i><br />C 8 - Trvání doèasné pracovní neschopnosti následkem úrazu</i><br />
<table border=0 width=100%><tr><td width=30%>od: <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value23"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center;width:50%><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus2"></div></div>

</td><td width=30%>do: <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value24"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center;width:50%><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus3','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus3"></div></div>
</td>

<td width=40%>celkem kalendáøních dnù: <input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value25"];}?>" style=width:100px;text-align:center;></td></tr>
</table></td></tr>

<tr><td colspan=4 align=left><i><br />D 1 - Úrazem postižený zamìstnanec na následky poškození zdraví pøi zemøel dne: </i>
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value28"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center;width:12%><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus4','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:520px;top:-1px;"><SPAN ID="span_pokus4"></div></div>
</td></tr>

<tr><td colspan=4 align=left><i><br />Jiné Zmìny:</i>
<textarea name="value<?echo($poradi);?>" rows=10 style=width:100%  wrap="off"><?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];}?></textarea>
<br /></td></tr>

<tr style=vertical-align:top>
<td colspan=2>Úrazem postižený zamìstnanec: </td>
<td colspan=2 align=center><input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value40"];}?>" style=width:100%;text-align:center; >
datum, jméno, pracovní zaøazení, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Jméno a pracovní zaøazení toho,<br /> kdo údaje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi);?>" type="text" value="<?if (@$_POST["values".($poradi++)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value45"];}?>" style=width:100%;text-align:center; >
datum, jméno, pracovní zaøazení, podpis:</td>
</tr>
<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Uložit Záznam Hlášení Zmìn"></center></td></tr>

<?}}?>


















<?if (@$_POST["submenu"]=="ZoÚ" and @$menu=="Úprava/Pokr. Existujícího Záznamu"){?>

<tr style=vertical-align:top bgcolor="#C0FFC0"><td align=center>Zamìstnanec:<br /><select size="1" name="zamestnanec" onchange=submit(this)>
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
<tr bgcolor="#C0FFC0"><td align=center style=vertical-align:middle><table width=100%><tr><td><?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "))) {?><input type="button" value="Tisk ZoÚ" onclick="window.open('TiskZoU.php?prev_id=<?echo sifra(@$idu[0]);?>');" style=width:33%><?}?> <input type="submit" name=submenu value="ZoÚ" style=background-color:#EC0C06;width:33%; >
<?if (mysql_result(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0)) {?><input type="submit" name=submenu value="ZoÚ-HZ" <?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(mysql_result($data3,0,0))."' "))) {echo"style=background-color:#F3E80C";} else {echo"style=background-color:#20D028";}?> style=width:32%><?}?></td></tr></table>

</td><td colspan=2><center><b>ZÁZNAM O ÚRAZU</b></center></td></tr>
<tr><td><p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]==1) {echo "checked";} if (!@$_POST["values".($poradi)]) {if (@$_POST["value18"]=="1") {echo" checked ";}}?> > smrtelném<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]==3) {echo "checked";} if (!@$_POST["values".($poradi)]) {if (@$_POST["value18"]=="3") {echo" checked ";}}?> > s hospitalizací delší než 5 dnù<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]==5) {echo "checked";} if (!@$_POST["values".($poradi++)]) {if (@$_POST["value18"]<>"1" and @$_POST["value18"]<>"3") {echo" checked ";}}?> > ostatním</p>
</td><td colspan=2></td></tr>
<tr><td></td><td colspan=2 align=right><i>Evidenèní èíslo záznamu: </i><input name="value<?echo($poradi++);?>" type="text" value="" style=width:150px disabled></td></tr>
<tr><td></td><td colspan=2 align=right><i>Evidenèní èíslo zamìstnavatele: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0)) {echo mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0);} else {echo "ZoU".date("Y").(substr(mysql_result(mysql_query("select company_id from kniha_urazu where company_id<>'' order by id desc limit 1"),0,0),7,15)+1);}?>" style=width:150px;text-align:center readonly=yes></td></tr>

<tr><td colspan=3 align=center><b>A. Údaje o zamìstnavateli, u kterého je úrazem postižený zamìstnanec v základním pracovnìprávním vztahu</b></td></tr>
<tr><td style=vertical-align:top><i>1. IÈO:</i><input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select ico from firma where id='1' "),0,0);}?>" style=width:80%><br /><i>Název zamìstnavatele a jeho sídlo (adresa):</i><br />
<textarea name="value<?echo($poradi++);?>" rows=5 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select concat(nazev,'\n',ulice,'\n',psc,' ',mesto) from firma where id=1"),0,0);}?></textarea></td>
<td colspan=2 style=vertical-align:top><i>2. Pøedmìt podikání (CZ-NACE), v jehož rámci k úrazu došlo:</i><br />
<input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select cznace from firma where id='1' "),0,0);}?>" style=width:100%><hr></hr>
<i>3. Místo, kde k úrazu došlo:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value12"];}?></textarea><hr></hr>
<i>4. Bylo místo úrazu pravidelným pracovištìm<br />úrazem postiženého zamìstnance?</i> <select size="1" name="value<?echo($poradi++);?>">
<?
if (@$_POST["values".($poradi-1)]) {if (@$_POST["values".($poradi-1)]=="ANO") {echo "<option>".@$_POST["values".($poradi-1)]."</option><option>NE</option>";}
if (@$_POST["values".($poradi-1)]=="NE") {echo "<option>".@$_POST["values".($poradi-1)]."</option><option>ANO</option>";}
} else {if (@$_POST["value13"]=="ANO"){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}}?>
</select></td></tr>

<tr><td colspan=3 align=center><b>B. Údaje o zamìstnavateli, u kterého došlo (pokud se nejedná o zamìstnavatele uvedeného v èásti A záznamu):</b></td></tr>
<tr><td style=vertical-align:top><i>1. IÈO:</i><input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?>" style=width:80%><br /><i>Název zamìstnavatele a jeho sídlo (adresa):</i><br />
<textarea name="value<?echo($poradi++);?>" rows=5 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td>
<td colspan=2 style=vertical-align:top><i>2. Pøedmìt podikání (CZ-NACE), v jehož rámci k úrazu došlo:</i><br />
<input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?>" style=width:100%><hr></hr>
<i>3. Místo, kde k úrazu došlo:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td></tr>

<tr><td colspan=3 align=center><b>C. Údaje o úrazem postiženém zamìstnanci</b></td></tr>
<tr><td><i>1. Jméno: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" readonly=yes style=width:77%></td>
<input name="value<?echo($poradi++);?>" type="hidden" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value2"];}?>">
<td colspan=2 style=vertical-align:top><i>Pohlaví: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select pohlavi from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" readonly=yes style=width:10%></td></tr>

<tr><td><i>2. Datum narození: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select date_format(narozen,'%d.%m.%Y') from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" readonly=yes style=width:30%></td>
<td colspan=2><i>3. Státní obèanství: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select obcanstvi from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" style=width:30%></td></tr>

<tr><td><i>4. Druh Práce (CZ ISCO): </i><textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value5"];}?></textarea></td>
<td colspan=2><i>5. Èinnost, pøi které k úrazu došlo: </i><textarea name="value<?echo($poradi++);?>" rows=4 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value10"];}?></textarea>

<tr><td colspan=3><i>6. Délka trvání základního pracovnìprávního vztahu u zamìstnavatele: </i>
rokù: <input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value6"];}?>" readonly=yes style=width:5%;text-align:center;>
mìsícù: <input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value7"];}?>" readonly=yes style=width:5%;text-align:center;>
</td></tr>

<tr><td colspan=3><i>7. Úrazem postižený je: </i><p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> > zamìstnanec v pracovním pomìru<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?>> zamìstnanec zamìstnaný na základì dohod o pracích konaných mimo pracovní pomìr<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?>> osoba vykonávající èinnosti nebo poskytující služby mimo pracovnìprávní vztahy (§ 12 zákona è. 309/2006 Sb.)<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi++)]=="4") {echo" checked ";}?>> zamìstnanec agentury práce nebo doèasnì pøidìlený k výkonu práce za úèelem prohloubení kvalifikace u jiné
právnické<br /> nebo fyzické osoby [§ 38a zákona è. 95/2004 Sb., o podmínkách získávání a uznávání odborné zpùsobilosti a specializované zpùsobilosti<br /> k výkonu zdravotnického povolání lékaøe
a farmaceuta, ve znìní pozdìjších pøedpisù, § 91a zákona è. 96/2004 Sb., o podmínkách získávání<br /> a uznávání zpùsobilosti k výkonu nelékaøských zdravotnických povolání
a k výkonu èinností souvisejících s poskytováním zdravotní péèe<br /> a o zmìnì nìkterých souvisejících zákonù (zákon o nelékaøských zdravotnických povoláních), ve znìní pozdìjších pøedpisù].</p>
</td></tr>

<tr><td colspan=3><i>8. Trvání doèasné pracovní neschopnosti následkem úrazu: </i><br />
<table width=100% border=0><tr><td width=33.3%> od:
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus"></div></div>

</td><td width=33.3%> do:
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus1"></div></div>
</td><td width=33.3%>celkem kalendáøních dnù: <input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?>" size=10 style=text-align:center></td></tr></table>
</td></tr>

<tr><td colspan=3 align=center><b>D. Údaje o úrazu</b></td></tr>
<tr><td><table border=0 with=100%><tr><td width=5% rowspan=4 style=vertical-align:top><i>1.</i></td><td width=95%><i>Datum úrazu: </i>
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value8"];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:70px;top:-1px;"><SPAN ID="span_pokus2"></div></div></td></tr>

<tr><td><i>  Hodina úrazu: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value11"];}?>" size=10 style=text-align:center></td></tr>
<tr><td align=center><br /><i>Datum úmrtí úrazem postiženého zamìstnance:</i></i><br />
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus3','cpokus');" size="width:15" ><div style="position:relative;"><div style="position:absolute;left:-100px;top:-1px;"><SPAN ID="span_pokus3"></div></div></td></tr></table>
</td><td colspan=2 style=vertical-align:top><i>2. Poèet hodin odpracovaných bezprostøednì pøed vznikem úrazu: </i>
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value9"];}?>" size=5 style=text-align:center></td></tr>

<tr><td><i>3. Druh zranìní: </i><br />
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value14"];}?>" style=width:100%>
</td>
<td colspan=2><i>4. Zranìná èást tìla:</i>
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value17"];}?>" style=width:100%>
</td></tr>

<tr><td colspan=3>
<i>5. Poèet zranìných osob celkem: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value16"];}?>" size=10 style=text-align:center>
</td></tr>

<tr><td><i>6. Co bylo zdrojem úrazu? </i><p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> > dopravní prostøedek<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?> > stroje a zaøízení pøenosná nebo mobilní<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?> > materiál, bøemena, pøedmìty (pád, pøiražení,<br /> odlétnutí, náraz, zavalení)<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi)]=="4") {echo" checked ";}?> > pád na rovinì, z výšky, do hloubky, propadnutí<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]=="5") {echo" checked ";}?> > nástroj, pøístroj, náøadí</p>
</td><td colspan=2>
<p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="6" <?if (@$_POST["values".($poradi)]=="6") {echo" checked ";}?> > prùmyslové škodliviny, chemické látky, biologické èinitele<br />
<input name="value<?echo($poradi);?>" type="radio" value="7" <?if (@$_POST["values".($poradi)]=="7") {echo" checked ";}?> > horké látky a pøedmìty, oheò a výbušniny<br />
<input name="value<?echo($poradi);?>" type="radio" value="8" <?if (@$_POST["values".($poradi)]=="8") {echo" checked ";}?> > stroje a zaøízení stabilní<br />
<input name="value<?echo($poradi);?>" type="radio" value="9" <?if (@$_POST["values".($poradi)]=="9") {echo" checked ";}?> > lidé, zvíøata nebo pøírodní živly<br />
<input name="value<?echo($poradi);?>" type="radio" value="10" <?if (@$_POST["values".($poradi)]=="10") {echo" checked ";}?> > elektrická energie<br />
<input name="value<?echo($poradi);?>" type="radio" value="11" <?if (@$_POST["values".($poradi++)]=="11") {echo" checked ";}?> > jiný blíže nespecifikovaný zdroj</p>
</td></tr>

<tr><td><i>7. Proè k úrazu došlo? (pøíèiny) </i><p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> > pro poruchu nebo vadný stav nìkterého<br /> ze zdrojù úrazu<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?> > pro špatné nebo nedostateèné vyhodnocení rizika<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?> > pro závady na pracovišti</p>
</td><td colspan=2>
<p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi)]=="4") {echo" checked ";}?> > pro nedostateèné osobní zajištìní zamìstnance vèetnì osobních ochranných<br /> pracovních prostøedkù<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]=="5") {echo" checked ";}?> > pro porušení pøedpisù vztahujících se k práci nebo pokynù zamìstnavatele<br /> úrazem postiženého zamìstnance<br />
<input name="value<?echo($poradi);?>" type="radio" value="6" <?if (@$_POST["values".($poradi)]=="6") {echo" checked ";}?> > pro nepøedvídatelné riziko práce nebo selhání lidského èinitele<br />
<input name="value<?echo($poradi);?>" type="radio" value="7" <?if (@$_POST["values".($poradi++)]=="7") {echo" checked ";}?> > pro jiný blíže nespecifikovaný dùvod</p>
</td></tr>

<tr><td align=center><i>8. Byla u úrazem postiženého zamìstnance zjištìna<br /> pøítomnost alkoholu nebo jiných nývykových látek? </i><br />
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value23"];}?>" size=15 style=text-align:center>
</td><td colspan=2></td></tr>

<tr><td colspan=3><i>9. Popis úrazového dìje, rozvedení popisu místa, pøíèin a okolností, za nichž došlo k úrazu.(V pøípadì potøeby pøipojte další list).</i><br />
<textarea name="value<?echo($poradi++);?>" rows=10 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value20"];}?></textarea></td></tr>

<tr><td colspan=3><i>10. Uveïte, jaké pøedpisy byli v souvislosti s úrazem porušeny a kým, pokud bylo jejich porušení do doby odeslání záznamu zjištìno.(V pøípadì potøeby pøipojte další list)</i><br />
<textarea name="value<?echo($poradi++);?>" rows=6 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value24"];}?></textarea></td></tr>

<tr><td colspan=3><i>11. Opatøení pøijatá k zábranì opakování pracovního úrazu:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=6 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td></tr>

<tr><td colspan=3 align=center><b>E. Vyjádøení úrazem postiženého zamìstnance a svìdkù úrazu</b></td></tr>
<tr><td colspan=3 align=center><textarea name="value<?echo($poradi++);?>" rows=12 style=width:100% wrap="off"><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td></tr>

<tr style=vertical-align:top>
<td>Úrazem postižený zamìstnanec: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value25"];}?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td rowspan=3>Svìdci úrazu: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value26"];}?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value27"];}?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value28"];}?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td >Zástupce odborové organizace<br />(zástupce zamìstnancù pro BOZP): </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value29"];}?>" style=width:100%;text-align:center; >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td>Jméno a pracovní zaøazení toho,<br /> kdo údaje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value30"];}?>" style=width:100%;text-align:center; >
datum, jméno, pracovní zaøazení, podpis:</td>
</tr>

<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uložit Záznam o Úrazu"></center></td></tr><?}}?>
















<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "X") or  StrPos (" " . $_SESSION["prava"], "x") ){?>


<?if (@$menu=="Pøehled Existujících Záznamù" and !@$_POST["submenu"]){?>

<tr style=vertical-align:top bgcolor="#C0FFC0"><td align=center>Zamìstnanec: <select size="1" name="zamestnanec" onchange=submit(this)>
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
<tr bgcolor="#C0FFC0"><td align=center><input type="button" value="Tisk Záznamu" onclick="window.open('TiskUrazu.php?zamestnanec=<?echo base64_encode(@$_POST["zamestnanec"]);?>&id=<?echo base64_encode(@$idu[0]);?>');"><?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "))) {?><input type="submit" name=submenu value="ZoÚ" style=background-color:#F3E80C" ><?}?>
</td><td colspan=3><center><b>KNIHA ÚRAZÙ - EVIDOVANÝ ÚRAZ ZAMÌSTANCE è. <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".$poradi++];?>" style=text-align:right; size=10 readonly=yes></b></center></td></tr>

<tr style=vertical-align:top><td colspan=2><center><b>Jméno a pøíjmení urázem postiženého zamìstnance:</b></center>
<input type="text" value="<?echo mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".$poradi])."'"),0,0);?>" style=width:100%; readonly=yes>
<input name="value<?echo($poradi);?>" type="hidden" value="<?echo @$_POST["value".($poradi++)];?>" disabled>
</td>

<td align=center width=180px>Datum narození:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');"style="width:28%" disabled ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus"></div></div></td>

<td>Adresa bydlištì:<br /><textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off" disabled><?if (@$_POST["value".($poradi-1)]){echo @$_POST["value".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(ulice,'\n',psc,' ',mesto) from zamestnanci where osobni_cislo='".securesql(@$_POST["value".($poradi-3)])."'"),0,0);}?></textarea></td>
</tr>

<tr style=vertical-align:top><td colspan=2>Druh Práce (CZ-ISCO):<textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
<td colspan=2>Délka trvání základního pracovnìprávního vztahu u zamìstavatele:<br /><br />
rokù: <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=text-align:center disabled>  mìsícù: <input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=text-align:center disabled></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Datum úrazu:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');"style="width:28%" disabled ><div style="position:relative;"><div style="position:absolute;left:-88px;top:-1px;"><SPAN ID="span_pokus1"></div></div></td>

<td rowspan=2 align=center>Poèet hodin odpracovaných <br />bezprostøednì pøed vznikem úrazu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; disabled></td>
<td rowspan=2 colspan=2>Èinnost, pøi níž k úrazu došlo:<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td align=center width=180px>Hodina úrazu:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; disabled ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=3>Místo kde k úrazu došlo:<br /><textarea name="value<?echo($poradi);?>" rows=2 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
<td align=center>Bylo místo úrazu pravidelným<br /> pracovištìm zamìstnance?:<br />
<select size="1" name="value<?echo($poradi++);?>" disabled>
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Druh zranìní:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; disabled ></td>
<td align=center rowspan=2>Ošetøen u lékaøe:<br /><select size="1" name="value<?echo($poradi++);?>" disabled>
<?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}?>
</select></td>
<td rowspan=2 align=center>Celkový poèet<br /> zranìných osob:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center; disabled ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Zranìná èást tìla:<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; disabled ></td>
</tr>


<tr style=vertical-align:top>
<td colspan=3>Druh úrazu:<p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["value".($poradi)]=="1") {echo" checked ";}?> disabled > Smrtelný<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["value".($poradi)]=="2") {echo" checked ";}?> disabled > S pracovní neschopností delší než 3 kalendáøní dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["value".($poradi)]=="3") {echo" checked ";}?> disabled > S hospitalizací pøesahující 5 dnù<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["value".($poradi)]=="4") {echo" checked ";}?> disabled > S pracovní neschopností kratší než 3 kalendáøní dny<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["value".($poradi++)]=="5") {echo" checked ";}?> disabled > Bez pracovní neschopnosti</p>
</td>

<td>Záznam o úrazu sepsán dne:<br />
<SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["value".$poradi]) {echo datecs(@$_POST["value".$poradi]);} else {echo@$dnescs;}?>" style="width:70%" readonly=yes  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');"style="width:28%" disabled ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus2"></div></div></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Popis úrazového dìje:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Proè k úrazu došlo? (pøíèiny):<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; disabled ></td>
<td colspan=2>Co bylo zdrojem úrazu?<br /><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%; disabled ></td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Byla u úrazem postiženého zamìstnance zjištìna pøítomnost alkoholu (jiných návykových látek)? <select size="1" name="value<?echo($poradi++);?>" disabled><?if (@$_POST["value".($poradi-1)]=="ANO" or @$_POST["value".($poradi-1)]==""){echo"<option>ANO</option><option>NE</option><option>Neprovádìla se</option>";} if (@$_POST["value".($poradi-1)]=="NE") {echo"<option>NE</option><option>ANO</option><option>Neprovádìla se</option>";} if (@$_POST["value".($poradi-1)]=="Neprovádìla se") {echo"<option>Neprovádìla se</option><option>ANO</option><option>NE</option>";}?></select></td>
</tr>


<tr style=vertical-align:top>
<td colspan=4>Jaké pøedpisy byly v souvislosti s poranìním porušeny a kým?<br /><textarea name="value<?echo($poradi);?>" rows=4 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Úrazem postižený zamìstnanec: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2 rowspan=3>Svìdci úrazu: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jméno, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jméno, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Zástupce odborové organizace<br />(zástupce zamìstnancù pro BOZP): </td>
<td colspan=2 align=center ><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=2>Jméno a pracovní zaøazení toho,<br /> kdo údaje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi);?>" type="text" value="<?echo @$_POST["value".($poradi++)];?>" style=width:100%;text-align:center;  disabled>
datum, jméno, pracovní zaøazení, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td colspan=4>Poznámka:<br /><textarea name="value<?echo($poradi);?>" rows=5 style=width:100% wrap="off" disabled><?echo @$_POST["value".($poradi++)];?></textarea></td>
</tr>
<?}}?>






<?if (@$_POST["submenu"]=="ZoÚ" and @$menu=="Pøehled Existujících Záznamù"){?>

<tr style=vertical-align:top bgcolor="#C0FFC0"><td align=center>Zamìstnanec:<br /><select size="1" name="zamestnanec" onchange=submit(this)>
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
<tr bgcolor="#C0FFC0"><td align=center style=vertical-align:middle><table width=100%><tr><td><?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "))) {?><input type="button" value="Tisk ZoÚ" onclick="window.open('TiskZoU.php?prev_id=<?echo sifra(@$idu[0]);?>');" style=width:33%><?}?> <input type="submit" name=submenu value="ZoÚ" style=background-color:#EC0C06;width:33%; >
<?if (mysql_result(mysql_query("select id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0)) {?><input type="submit" name=submenu1 value="ZoÚ-HZ" <?if (mysql_num_rows(mysql_query("select id from kniha_urazu where prev_id='".securesql(mysql_result($data3,0,0))."' "))) {echo"style=background-color:#F3E80C";} else {echo"style=background-color:#20D028";}?> style=width:32%><?}?></td></tr></table>

</td><td colspan=2><center><b>ZÁZNAM O ÚRAZU</b></center></td></tr>
<tr><td><p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]==1) {echo "checked";} if (!@$_POST["values".($poradi)]) {if (@$_POST["value18"]=="1") {echo" checked ";}}?> disabled > smrtelném<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]==3) {echo "checked";} if (!@$_POST["values".($poradi)]) {if (@$_POST["value18"]=="3") {echo" checked ";}}?> disabled  > s hospitalizací delší než 5 dnù<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]==5) {echo "checked";} if (!@$_POST["values".($poradi++)]) {if (@$_POST["value18"]<>"1" and @$_POST["value18"]<>"3") {echo" checked ";}}?> disabled  > ostatním</p>
</td><td colspan=2></td></tr>
<tr><td></td><td colspan=2 align=right><i>Evidenèní èíslo záznamu: </i><input name="value<?echo($poradi++);?>" type="text" value="" style=width:150px disabled></td></tr>
<tr><td></td><td colspan=2 align=right><i>Evidenèní èíslo zamìstnavatele: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0)) {echo mysql_result(mysql_query("select company_id from kniha_urazu where prev_id='".securesql(@$idu[0])."' "),0,0);} else {echo "ZoU".date("Y").(substr(mysql_result(mysql_query("select company_id from kniha_urazu where company_id<>'' order by id desc limit 1"),0,0),7,15)+1);}?>" style=width:150px;text-align:center  disabled ></td></tr>

<tr><td colspan=3 align=center><b>A. Údaje o zamìstnavateli, u kterého je úrazem postižený zamìstnanec v základním pracovnìprávním vztahu</b></td></tr>
<tr><td style=vertical-align:top><i>1. IÈO:</i><input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select ico from firma where id='1' "),0,0);}?>" style=width:80% disabled ><br /><i>Název zamìstnavatele a jeho sídlo (adresa):</i><br />
<textarea name="value<?echo($poradi++);?>" rows=5 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select concat(nazev,'\n',ulice,'\n',psc,' ',mesto) from firma where id=1"),0,0);}?></textarea></td>
<td colspan=2 style=vertical-align:top><i>2. Pøedmìt podikání (CZ-NACE), v jehož rámci k úrazu došlo:</i><br />
<input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select cznace from firma where id='1' "),0,0);}?>" style=width:100% disabled ><hr></hr>
<i>3. Místo, kde k úrazu došlo:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value12"];}?></textarea><hr></hr>
<i>4. Bylo místo úrazu pravidelným pracovištìm<br />úrazem postiženého zamìstnance?</i> <select size="1" name="value<?echo($poradi++);?>" disabled >
<?
if (@$_POST["values".($poradi-1)]) {
if (@$_POST["values".($poradi-1)]=="ANO") {echo "<option>".@$_POST["values".($poradi-1)]."</option><option>NE</option>";}
if (@$_POST["values".($poradi-1)]=="NE") {echo "<option>".@$_POST["values".($poradi-1)]."</option><option>ANO</option>";}
} else {if (@$_POST["value13"]=="ANO"){echo"<option>ANO</option><option>NE</option>";} else {echo"<option>NE</option><option>ANO</option>";}}?>
</select></td></tr>

<tr><td colspan=3 align=center><b>B. Údaje o zamìstnavateli, u kterého došlo (pokud se nejedná o zamìstnavatele uvedeného v èásti A záznamu):</b></td></tr>
<tr><td style=vertical-align:top><i>1. IÈO:</i><input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select ico from firma where id='1' "),0,0);}?>" style=width:80% disabled ><br /><i>Název zamìstnavatele a jeho sídlo (adresa):</i><br />
<textarea name="value<?echo($poradi++);?>" rows=5 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select concat(nazev,'\n',ulice,'\n',psc,' ',mesto) from firma where id=1"),0,0);}?></textarea></td>
<td colspan=2 style=vertical-align:top><i>2. Pøedmìt podikání (CZ-NACE), v jehož rámci k úrazu došlo:</i><br />
<input type=text name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @mysql_result(mysql_query("select cznace from firma where id='1' "),0,0);}?>" style=width:100% disabled ><hr></hr>
<i>3. Místo, kde k úrazu došlo:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value12"];}?></textarea></td></tr>

<tr><td colspan=3 align=center><b>C. Údaje o úrazem postiženém zamìstnanci</b></td></tr>
<tr><td><i>1. Jméno: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul,'/',osobni_cislo) from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>"  disabled  style=width:77%></td>
<input name="value<?echo($poradi++);?>" type="hidden" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value2"];}?>">
<td colspan=2 style=vertical-align:top><i>Pohlaví: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select pohlavi from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>"  disabled style=width:10%></td></tr>

<tr><td><i>2. Datum narození: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select date_format(narozen,'%d.%m.%Y') from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" disabled style=width:30%></td>
<td colspan=2><i>3. Státní obèanství: </i><input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo mysql_result(mysql_query("select obcanstvi from zamestnanci where osobni_cislo='".securesql(@$_POST["value2"])."' "),0,0);}?>" style=width:30% disabled ></td></tr>

<tr><td><i>4. Druh Práce (CZ ISCO): </i><textarea name="value<?echo($poradi++);?>" rows=2 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value5"];}?></textarea></td>
<td colspan=2><i>5. Èinnost, pøi které k úrazu došlo: </i><textarea name="value<?echo($poradi++);?>" rows=4 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value10"];}?></textarea>

<tr><td colspan=3><i>6. Délka trvání základního pracovnìprávního vztahu u zamìstnavatele: </i>
rokù: <input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value6"];}?>" disabled style=width:5%;text-align:center;>
mìsícù: <input type="text" name="value<?echo($poradi++);?>" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value7"];}?>" disabled style=width:5%;text-align:center;>
</td></tr>

<tr><td colspan=3><i>7. Úrazem postižený je: </i><p style="margin-left: 30; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> disabled > zamìstnanec v pracovním pomìru<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?> disabled > zamìstnanec zamìstnaný na základì dohod o pracích konaných mimo pracovní pomìr<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?> disabled > osoba vykonávající èinnosti nebo poskytující služby mimo pracovnìprávní vztahy (§ 12 zákona è. 309/2006 Sb.)<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi++)]=="4") {echo" checked ";}?> disabled > zamìstnanec agentury práce nebo doèasnì pøidìlený k výkonu práce za úèelem prohloubení kvalifikace u jiné
právnické<br /> nebo fyzické osoby [§ 38a zákona è. 95/2004 Sb., o podmínkách získávání a uznávání odborné zpùsobilosti a specializované zpùsobilosti<br /> k výkonu zdravotnického povolání lékaøe
a farmaceuta, ve znìní pozdìjších pøedpisù, § 91a zákona è. 96/2004 Sb., o podmínkách získávání<br /> a uznávání zpùsobilosti k výkonu nelékaøských zdravotnických povolání
a k výkonu èinností souvisejících s poskytováním zdravotní péèe<br /> a o zmìnì nìkterých souvisejících zákonù (zákon o nelékaøských zdravotnických povoláních), ve znìní pozdìjších pøedpisù].</p>
</td></tr>

<tr><td colspan=3><i>8. Trvání doèasné pracovní neschopnosti následkem úrazu: </i><br />
<table width=100% border=0><tr><td width=33.3%> od:
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" disabled  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus','cpokus');" size="width:15" disabled  ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus"></div></div>

</td><td width=33.3%> do:
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" disabled style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus1','cpokus');" size="width:15" disabled ><div style="position:relative;"><div style="position:absolute;left:0px;top:-1px;"><SPAN ID="span_pokus1"></div></div>
</td><td width=33.3%>celkem kalendáøních dnù: <input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?>" size=10 style=text-align:center disabled ></td></tr></table>
</td></tr>

<tr><td colspan=3 align=center><b>D. Údaje o úrazu</b></td></tr>
<tr><td><table border=0 with=100%><tr><td width=5% rowspan=4 style=vertical-align:top><i>1.</i></td><td width=95%><i>Datum úrazu: </i>
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];} else {echo @$_POST["value8"];}?>" size="10" disabled  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus2','cpokus');" size="width:15" disabled ><div style="position:relative;"><div style="position:absolute;left:70px;top:-1px;"><SPAN ID="span_pokus2"></div></div></td></tr>

<tr><td><i>  Hodina úrazu: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value11"];}?>" size=10 style=text-align:center disabled ></td></tr>
<tr><td align=center><br /><i>Datum úmrtí úrazem postiženého zamìstnance:</i></i><br />
 <SCRIPT LANGUAGE="javascript">
 var cDOW=["PO "," ÚT"," ST"," ÈT"," PÁ"," SO"," NE"];var cMOY=["Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec","Srpen","Záøí","Øíjen","Listopad","Prosinec"];var imgPath="";
 function calendar(cTarget,cName,cId) {this.cId=cId;this.cTarget=cTarget;this.cName=cName;this.cDate=new Date();this.cYear=this.cDate.getFullYear();this.cMonth=this.cDate.getMonth();this.cDay=1;show_calendar(this);}
 function show_calendar(cId) {var cData="";cData+="<DIV CLASS=\"calendar\">\n";cData+=" <FIELDSET>\n";cData+="  <LEGEND>Datum&nbsp;</LEGEND>\n";cData+="  <DIV STYLE=\"position: relative;\">\n";cData+="   <SELECT NAME=\""+cId.cName+".cMonth\" onChange=\"setNMonth(this.options[selectedIndex].value,"+cId.cId+");\">"; for (var idx_month=0;idx_month<12;++idx_month) cData+="   <OPTION VALUE=\""+idx_month+"\">"+cMOY[idx_month]+"\n"; cData+="   </SELECT>\n";
  cData+="   <INPUT TYPE=\"text\" NAME=\""+cId.cName+".cYear\" STYLE=\"width: 34px;\" onChange=\"setNYear("+cId.cId+");\"'> <IMG SRC=\""+imgPath+'picture/'+"inc.png\" STYLE=\"position: absolute; top: 2px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"inc_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"inc.png';\" onClick=\"++window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\"> <IMG SRC=\""+imgPath+'picture/'+"dec.png\" STYLE=\"position: absolute; top: 11px;\" onMouseOver=\"this.src='"+imgPath+'picture/'+"dec_over.png';\" onMouseOut=\"this.src='"+imgPath+'picture/'+"dec.png';\" onClick=\"--window.document.getElementById('"+cId.cName+".cYear').value; setNYear("+cId.cId+");\">\n";
  cData+="  </DIV>\n"; cData+="  <DIV CLASS=\"calendar_table\">\n";cData+="  <DIV CLASS=\"calendar_row_cDOW\">";for (var idx_day=0;idx_day<7;++idx_day) cData+="<SPAN STYLE=\"width: 20px\">"+cDOW[idx_day]+"</SPAN>";cData+="  </DIV>\n";cData+="  <DIV ID=\""+cId.cName+".cData\">";cData+="  </DIV>\n";cData+=" </FIELDSET>\n";cData+="</DIV>\n";window.document.getElementById(cId.cName).innerHTML=cData;setCalendar(new Date(cId.cYear,cId.cMonth,1),cId)}
 function setCalendar(dt,cId) { cId.cYear=dt.getFullYear(); cId.cMonth=dt.getMonth(); cId.cDay=dt.getDate(); firstDay=dt.getDay();if ((firstDay-2)<-1) firstDay+=7;dayspermonth=getDaysPerMonth(cId); cData=""; for (var row=0;row<6;++row) {cData+="  <DIV>"; for (var col=1;col<8;++col) {nDay=row*7+col-firstDay+1; cData+="<A HREF=\"\" STYLE=\"width: 20px\" onClick=\"if (this.innerHTML!=='') ShowDate('"+nDay+"',"+cId.cId+"); return false;\">";
 if ((nDay>0)&&(nDay<dayspermonth+1)) cData+=nDay;cData+="   ";cData+="</A>";cData+="   ";} cData+="</DIV>\n";}window.document.getElementById(cId.cName+".cData").innerHTML=cData;window.document.getElementById(cId.cName+".cMonth").value=cId.cMonth;window.document.getElementById(cId.cName+".cYear").value=cId.cYear;}
 function getDaysPerMonth(cId){daysArray=new Array(31,28,31,30,31,30,31,31,30,31,30,31);days=daysArray[cId.cMonth];if (cId.cMonth==1){if((cId.cYear%4)==0) {if(((cId.cYear%100)==0) && (cId.cYear%400)!=0)days = 28; else  days = 29;}}return days;}function setNMonth(cMonth,cId){setCalendar(new Date(cId.cYear,cMonth,1),cId);}
 function setNYear(cId){cYear=parseInt(window.document.getElementById(cId.cName+".cYear").value);if (isNaN(cYear)){alert("Rok musí být èíslo");return;}setCalendar(new Date(cYear,cId.cMonth,1),cId);}
 function ShowDate(cDay,cId) {cId.cTarget.value=((cDay<10)?"0"+cDay:cDay)+"."+((cId.cMonth<9)?"0"+(cId.cMonth+1):(cId.cMonth+1))+"."+cId.cYear;window.document.getElementById(cId.cName).innerHTML="";}
</SCRIPT><STYLE TYPE="text/css"><!-- .calendar {width: 160px;background: #FBFAFC;color: #000000;font-family: "Arial CE",Arial;font-size: 12px;} .calendar a {text-decoration: none;background: #FFFFFF;color: #000000;} .calendar a:hover {Xbackground: #0054E3;Xcolor: #FFFFFF;} .calendar input {font-family: "Arial CE",Arial;font-size: 12px;} .calendar select {font-family: "Arial CE",Arial;font-size: 12px;} .calendar_table {background: #FFFFFF;color: #000000;border: 1px solid #ACA899;text-align: center;} .calendar_row_cDOW {background: #7A96DF;color: #FFFFFF;} .calendar_day_of_month {background: #0054E3;color: #FFFFFF;cursor: pointer;}--></STYLE>
</SPAN><input type="text" name="value<?echo($poradi);?>" value="<?if (@$_POST["values".($poradi)]) {echo @$_POST["values".($poradi)];}?>" size="10" disabled  style=background-color:#F9C8C8;text-align:center><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.value<?echo($poradi++);?>,'span_pokus3','cpokus');" size="width:15" disabled ><div style="position:relative;"><div style="position:absolute;left:-100px;top:-1px;"><SPAN ID="span_pokus3"></div></div></td></tr></table>
</td><td colspan=2 style=vertical-align:top><i>2. Poèet hodin odpracovaných bezprostøednì pøed vznikem úrazu: </i>
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value9"];}?>" size=5 style=text-align:center disabled ></td></tr>

<tr><td><i>3. Druh zranìní: </i><br />
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value14"];}?>" style=width:100% disabled >
</td>
<td colspan=2><i>4. Zranìná èást tìla:</i>
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value17"];}?>" style=width:100% disabled >
</td></tr>

<tr><td colspan=3>
<i>5. Poèet zranìných osob celkem: </i><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value16"];}?>" size=10 style=text-align:center disabled >
</td></tr>

<tr><td><i>6. Co bylo zdrojem úrazu? </i><p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> disabled > dopravní prostøedek<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?> disabled > stroje a zaøízení pøenosná nebo mobilní<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?> disabled > materiál, bøemena, pøedmìty (pád, pøiražení,<br /> odlétnutí, náraz, zavalení)<br />
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi)]=="4") {echo" checked ";}?> disabled > pád na rovinì, z výšky, do hloubky, propadnutí<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]=="5") {echo" checked ";}?> disabled > nástroj, pøístroj, náøadí</p>
</td><td colspan=2>
<p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="6" <?if (@$_POST["values".($poradi)]=="6") {echo" checked ";}?> disabled > prùmyslové škodliviny, chemické látky, biologické èinitele<br />
<input name="value<?echo($poradi);?>" type="radio" value="7" <?if (@$_POST["values".($poradi)]=="7") {echo" checked ";}?> disabled > horké látky a pøedmìty, oheò a výbušniny<br />
<input name="value<?echo($poradi);?>" type="radio" value="8" <?if (@$_POST["values".($poradi)]=="8") {echo" checked ";}?> disabled > stroje a zaøízení stabilní<br />
<input name="value<?echo($poradi);?>" type="radio" value="9" <?if (@$_POST["values".($poradi)]=="9") {echo" checked ";}?> disabled > lidé, zvíøata nebo pøírodní živly<br />
<input name="value<?echo($poradi);?>" type="radio" value="10" <?if (@$_POST["values".($poradi)]=="10") {echo" checked ";}?> disabled > elektrická energie<br />
<input name="value<?echo($poradi);?>" type="radio" value="11" <?if (@$_POST["values".($poradi++)]=="11") {echo" checked ";}?> disabled > jiný blíže nespecifikovaný zdroj</p>
</td></tr>

<tr><td><i>7. Proè k úrazu došlo? (pøíèiny) </i><p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="1" <?if (@$_POST["values".($poradi)]=="1") {echo" checked ";}?> disabled > pro poruchu nebo vadný stav nìkterého<br /> ze zdrojù úrazu<br />
<input name="value<?echo($poradi);?>" type="radio" value="2" <?if (@$_POST["values".($poradi)]=="2") {echo" checked ";}?> disabled > pro špatné nebo nedostateèné vyhodnocení rizika<br />
<input name="value<?echo($poradi);?>" type="radio" value="3" <?if (@$_POST["values".($poradi)]=="3") {echo" checked ";}?> disabled > pro závady na pracovišti</p>
</td><td colspan=2>
<p style="margin-left: 15; margin-top: 0; margin-bottom: 0"">
<input name="value<?echo($poradi);?>" type="radio" value="4" <?if (@$_POST["values".($poradi)]=="4") {echo" checked ";}?> disabled > pro nedostateèné osobní zajištìní zamìstnance vèetnì osobních ochranných<br /> pracovních prostøedkù<br />
<input name="value<?echo($poradi);?>" type="radio" value="5" <?if (@$_POST["values".($poradi)]=="5") {echo" checked ";}?> disabled > pro porušení pøedpisù vztahujících se k práci nebo pokynù zamìstnavatele<br /> úrazem postiženého zamìstnance<br />
<input name="value<?echo($poradi);?>" type="radio" value="6" <?if (@$_POST["values".($poradi)]=="6") {echo" checked ";}?> disabled > pro nepøedvídatelné riziko práce nebo selhání lidského èinitele<br />
<input name="value<?echo($poradi);?>" type="radio" value="7" <?if (@$_POST["values".($poradi++)]=="7") {echo" checked ";}?> disabled > pro jiný blíže nespecifikovaný dùvod</p>
</td></tr>

<tr><td align=center><i>8. Byla u úrazem postiženého zamìstnance zjištìna<br /> pøítomnost alkoholu nebo jiných nývykových látek? </i><br />
<input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value23"];}?>" size=15 style=text-align:center disabled >
</td><td colspan=2></td></tr>

<tr><td colspan=3><i>9. Popis úrazového dìje, rozvedení popisu místa, pøíèin a okolností, za nichž došlo k úrazu.(V pøípadì potøeby pøipojte další list).</i><br />
<textarea name="value<?echo($poradi++);?>" rows=10 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value20"];}?></textarea></td></tr>

<tr><td colspan=3><i>10. Uveïte, jaké pøedpisy byli v souvislosti s úrazem porušeny a kým, pokud bylo jejich porušení do doby odeslání záznamu zjištìno.(V pøípadì potøeby pøipojte další list)</i><br />
<textarea name="value<?echo($poradi++);?>" rows=6 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value24"];}?></textarea></td></tr>

<tr><td colspan=3><i>11. Opatøení pøijatá k zábranì opakování pracovního úrazu:</i><br />
<textarea name="value<?echo($poradi++);?>" rows=6 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td></tr>

<tr><td colspan=3 align=center><b>E. Vyjádøení úrazem postiženého zamìstnance a svìdkù úrazu</b></td></tr>
<tr><td colspan=3 align=center><textarea name="value<?echo($poradi++);?>" rows=12 style=width:100% wrap="off" disabled ><?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];}?></textarea></td></tr>

<tr style=vertical-align:top>
<td>Úrazem postižený zamìstnanec: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value25"];}?>" style=width:100%;text-align:center;  disabled >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td rowspan=3>Svìdci úrazu: </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value26"];}?>" style=width:100%;text-align:center; disabled >
datum, jméno, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value27"];}?>" style=width:100%;text-align:center; disabled >
datum, jméno, podpis:</td>
</tr>
<tr style=vertical-align:top>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value28"];}?>" style=width:100%;text-align:center; disabled >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td >Zástupce odborové organizace<br />(zástupce zamìstnancù pro BOZP): </td>
<td colspan=2 align=center ><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value29"];}?>" style=width:100%;text-align:center; disabled >
datum, jméno, podpis:</td>
</tr>

<tr style=vertical-align:top>
<td>Jméno a pracovní zaøazení toho,<br /> kdo údaje zaznamenal: </td>
<td colspan=2 align=center><input name="value<?echo($poradi++);?>" type="text" value="<?if (@$_POST["values".($poradi-1)]) {echo @$_POST["values".($poradi-1)];} else {echo @$_POST["value30"];}?>" style=width:100%;text-align:center; disabled >
datum, jméno, pracovní zaøazení, podpis:</td>
</tr>
<?}}?>


<?}?>






</table></center>
</form>
