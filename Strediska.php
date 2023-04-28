<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];

@$kod=@$_POST["kod"];
@$plnykod=@$_POST["plnykod"];
@$stav=@$_POST["stav"];
@$nazev=@$_POST["nazev"];
@$nazevnew=@$_POST["nazevnew"];






if (@$nazev<>"" and @$tlacitko=="Uložit Nové Støedisko") {
mysql_query ("INSERT INTO stredisko (kod,plnykod,nazev,stav,datumvkladu,vlozil,datumukonceni,datumzacatku) VALUES('$kod','$plnykod','$nazev','ANO', '$dnes','$loginname','".securesql(datedb(@$_POST["datumdo"]))."','".securesql(datedb(@$_POST["datumod"]))."')") or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Nového Støediska Probìhlo Úspìšnì</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$kod="";}



if (@$nazevnew<>"" and @$tlacitko=="Uložit Opravené Støedisko") {
mysql_query ("update stredisko  set nazev = '$nazevnew',plnykod = '$plnykod',stav='$stav', datumzmeny = '$dnes', zmenil ='$loginname',datumukonceni='".securesql(datedb(@$_POST["datumdo"]))."',datumzacatku='".securesql(datedb(@$_POST["datumod"]))."' where kod = '$nazev' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Upraveného Støediska Probìhlo Úspìšnì</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$kod="";}


if (@$nazev<>"" and @$tlacitko=="Odstranit Vybrané Støedisko") {
mysql_query ("delete from stredisko where kod = '$nazev' ")or Die(MySQL_Error());
?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Odstranìní Vybraného Støediska Probìhlo Úspìšnì</b></center></td></tr></table><?
@$menu="";@$tlacitko="";@$kod="";}


?>
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



<form action="hlavicka.php?akce=<?echo base64_encode('Strediska');?>" method=post>

<h2><p align="center">Správa Støedisek:
<? if (StrPos (" " . $_SESSION["prava"], "U") or StrPos (" " . $_SESSION["prava"], "u")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "U")){?>
   <?if (@$menu<>"Založení Nového Støediska"){?><option>Založení Nového Støediska</option><?}?>
   <?if (@$menu<>"Úprava Existujícího Støediska"){?><option>Úprava Existujícího Støediska</option><?}?>
   <?if (@$menu<>"Odstranìní Existujícího Støediska"){?><option>Odstranìní Existujícího Støediska</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "U") or StrPos (" " . $_SESSION["prava"], "u")){?>
   <?if (@$menu<>"Pøehled Existujících Støedisek"){?><option>Pøehled Existujících Støedisek</option><?}?>
   <?if (@$menu<>"Tisk Støedisek"){?><option>Tisk Støedisek</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "U") and (!StrPos (" " . $_SESSION["prava"], "u")) ){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "U")){?>


<?if (@$menu=="Založení Nového Støediska"){?>
<tr><td colspan=3 bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td></tr>
<tr><td>Kód Støediska:</td><td colspan=2><input type="text" name=kod value="" size="26"></td></tr>
<tr><td>Popis:</td><td colspan=2><textarea name="nazev" rows=5 cols=20 wrap="on"></textarea></td></tr>
<tr><td>Celý Kód Støediska:</td><td colspan=2><input type="text" name=plnykod value="" size="26"></td></tr>
<tr><td>Datum Aktivace:</td><td colspan=2>
<input type="text" name="datumod" value="" style="width:68%;background-color:#F9C8C8;text-align:center;" readonly=yes ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumod,'span_datumod','cpokus');"style="width:32%"><div style="position:relative;"><div style="position:absolute;left:10px;top:-1px;"><SPAN ID="span_datumod"></SPAN></div></div></td></tr>
<tr><td>Datum Ukonèení:</td><td colspan=2>
<input type="text" name="datumdo" value="" style="width:68%;background-color:#F9C8C8;text-align:center;" readonly=yes ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumdo,'span_datumdo','cpokus');"style="width:32%"><div style="position:relative;"><div style="position:absolute;left:10px;top:-1px;"><SPAN ID="span_datumdo"></SPAN></div></div></td></tr>
<tr><td colspan=3><center><BR><input type="submit" name=tlacitko value="Uložit Nové Støedisko"></center><BR></td></tr><?}?>





<?if (@$menu=="Úprava Existujícího Støediska"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu?></b></center></td></tr>
<tr><td colspan=2>Kód Støediska:</td><td colspan=2><select name=nazev size="1" style=width:100% onchange=submit(this)>
<option><?if (@$nazev<>""){echo@$nazev;}?></option>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select * from stredisko order by kod,nazev,id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,@$cykl,1)<>@$nazev){?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;?></select></td></tr>
<?if (@$nazev<>""){@$data1 = mysql_query("select * from stredisko where kod='$nazev' ") or Die(MySQL_Error());?>
<tr><td colspan=2>Popis:</td><td colspan=2><textarea name="nazevnew" rows=5 cols=20 wrap="on"><?echo (mysql_result($data1,0,2));?></textarea></td></tr>
<tr><td colspan=2>Stav Aktivní:</td><td colspan=2>
<select size="1" name="stav" width=100%>
<option><? echo mysql_result($data1,0,7);?></option>
<? if (mysql_result($data1,0,7)=="ANO") {?><option>NE</option><?} else {?><option>ANO</option><?}?>
</select>
</td></tr>
<tr><td colspan=2>Celý Kód Støediska:</td><td colspan=2><input type="text" name=plnykod value="<?echo(mysql_result($data1,0,9));?>" size="26"></td></tr>
<tr><td colspan=2>Datum Aktivace:</td><td colspan=2>
<input type="text" name="datumod" value="<?echo datecs(mysql_result($data1,0,10));?>" style="width:68%;background-color:#F9C8C8;text-align:center;" readonly=yes ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumod,'span_datumod','cpokus');"style="width:32%"><div style="position:relative;"><div style="position:absolute;left:10px;top:-1px;"><SPAN ID="span_datumod"></SPAN></div></div></td></tr>
<tr><td colspan=2>Datum Ukonèení:</td><td colspan=2>
<input type="text" name="datumdo" value="<?echo datecs(mysql_result($data1,0,8));?>" style="width:68%;background-color:#F9C8C8;text-align:center;" readonly=yes ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumdo,'span_datumdo','cpokus');"style="width:32%"><div style="position:relative;"><div style="position:absolute;left:10px;top:-1px;"><SPAN ID="span_datumdo"></SPAN></div></div></td></tr>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Uložit Opravené Støedisko"></center><BR></td></tr><?}}?>





<?if (@$menu=="Odstranìní Existujícího Støediska"){?>
<tr><td colspan=4 bgcolor="#C0FFC0"><center><b><?echo@$menu?></b></center></td></tr>
<tr><td colspan=2>Kód Støediska:</td><td colspan=2><select name=nazev size="1" style=width:100% onchange=submit(this)>
<option><?if (@$nazev<>""){echo@$nazev;}?></option>
<?include ("./"."dbconnect.php");
@$data1 = mysql_query("select stredisko.* from stredisko where stredisko.kod not in (select zamestnanci.stredisko from zamestnanci) order by stredisko.kod,stredisko.nazev,stredisko.id ASC") or Die(MySQL_Error());
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):
if (mysql_result($data1,@$cykl,1)<>@$nazev){?><option><?echo(mysql_result($data1,@$cykl,1));?></option><?}
@$cykl++;endwhile;?></select></td></tr>
<?if (@$nazev<>""){@$data1 = mysql_query("select * from stredisko where kod='$nazev' ") or Die(MySQL_Error());?>
<tr><td colspan=2>Popis:</td><td colspan=2>
<textarea name="nazevnew" rows=5 cols=25 wrap="on" readonly=yes><?echo (mysql_result($data1,0,2));?></textarea></td></tr>
<tr><td colspan=2>Celý Kód Støediska:</td><td colspan=2><input type="text" name=plnykod value="<?echo(mysql_result($data1,0,9));?>" size="26" readonly=yes></td></tr>
<tr><td colspan=2>Datum Aktivace:</td><td colspan=2>
<input type="text" name="datumod" value="<?echo datecs(mysql_result($data1,0,10));?>" style="width:68%;background-color:#F9C8C8;text-align:center;" readonly=yes ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumod,'span_datumod','cpokus');"style="width:32%" disabled><div style="position:relative;"><div style="position:absolute;left:10px;top:-1px;"><SPAN ID="span_datumod"></SPAN></div></div></td></tr>
<tr><td colspan=2>Datum Ukonèení:</td><td colspan=2>
<input type="text" name="datumdo" value="<?echo datecs(mysql_result($data1,0,8));?>" style="width:68%;background-color:#F9C8C8;text-align:center;" readonly=yes ><INPUT TYPE="button" VALUE="Datum" onClick="cpokus=new calendar(form.datumdo,'span_datumdo','cpokus');"style="width:32%" disabled><div style="position:relative;"><div style="position:absolute;left:10px;top:-1px;"><SPAN ID="span_datumdo"></SPAN></div></div></td></tr>

<tr><td colspan=4><center><BR><input type="submit" name=tlacitko value="Odstranit Vybrané Støedisko"></center><BR></td></tr><?}}?>

<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "U") or  StrPos (" " . $_SESSION["prava"], "u") ){?>

<?if (@$menu=="Tisk Støedisek"){?>
<script type="text/javascript">
window.open('TiskStredisek.php')
</script>
<?}?>


<?if (@$menu=="Pøehled Existujících Støedisek"){?>
<tr bgcolor="#C0FFC0" align=center><td colspan=6><center><b> <?echo@$menu;?> </b></center></td></tr>
<tr bgcolor="#C0FFC0" align=center><td> Poøadí </td><td><center>Kód Støediska</center></td><td><center>Celý Kód Støediska</center></td><td><center>Popis</center></td><td>Aktivní</td><td><b> Použito </b></td></tr>

<?include ("./"."dbconnect.php");
@$data1=mysql_query("select * from stredisko order by kod,nazev,id");
@$pocet=mysql_num_rows($data1);@$cykl=0;
while (@$cykl<@$pocet):

?><tr><td><?echo@$cykl+1;?></td><td><?echo mysql_result($data1,@$cykl,1);?></td><td><?echo mysql_result($data1,@$cykl,9);?></td><td><?echo mysql_result($data1,@$cykl,2);?></td><td><?echo mysql_result($data1,@$cykl,7);?></td><td align=center>
<?include ("./"."dbconnect.php");@$control= mysql_result($data1,@$cykl,1);
@$control1=mysql_query("select id from zamestnanci where stredisko='$control'");
@$control=mysql_num_rows($control1);
if (@$control<>"") {echo"ANO";} else {echo"NE";}?>
</td></tr><?

@$cykl++;endwhile;}?>

<?}?>






</table></center>
</form>
