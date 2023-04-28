<?
//  menu
@$tlacitko=@$_POST["tlacitko"];
@$menu=@$_POST["menu"];if (@$menu=="") {@$menu=base64_decode(@$_GET["menu"]);}
@$smazani=base64_decode(@$_GET["smazani"]);





//   ukládání

if (@$tlacitko=="Importovat Soubor") {

//datumy do pole
$numberlaunch1= explode ("/", mysql_result(mysql_query("select hodnota from setting where nazev='Obìdy'"),0,0));$numberlaunch=explode(",", $numberlaunch1[0]);$numberlaunch[0]=$numberlaunch[0]-1;$numberlaunch2=explode(",", $numberlaunch1[1]);$numberlaunch3=explode(",", $numberlaunch1[3]);
$cdne= date("w", strtotime($dnes));if (@$cdne>0) {$nextwoche=(1-$cdne)." day ";if (!StrPos (" " . $nextwoche, "-")) {$nextwoche="+".$nextwoche;}$lastwoche=(1-$cdne+$numberlaunch[0])." day ";} else {$nextwoche="+1 day ";$lastwoche=(1+$numberlaunch[0])." day ";}
$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".$_POST["tyden"]." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".$_POST["tyden"]." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".$_POST["tyden"]." weeks"));
//konec datumu do pole

$name = $_FILES["soubor"]["name"];@$docasny = @$_FILES['soubor']['tmp_name'];@$mime = @$_FILES['soubor']['type'];
@$soubor = implode('', file("$docasny"));@$obedy=$soubor;
$radky = explode("\r\n", $obedy);$den=0;


@$cykl=0;while (@$radky[@$cykl]<>""):
$casti = explode(";", $radky[@$cykl]);@$value1 = $casti[0];@$value2 =$casti[1];


if (@$value1<>"") {@$oldvalue1=$value1;   // polevka ulozeni
@$saveday= date("Y-m-d", strtotime( $startwoche." + ".$den." day"));$den++;
$loadcena=mysql_result(mysql_query("select hodnota from setting where nazev='Obìdy'"),0,0);$l1cena=explode("/",@$loadcena);$l2cena=explode(",",$l1cena[3]);$cena=$l2cena[0];
$control=mysql_num_rows(mysql_query("select id from seznam_obedu where datum='".securesql($saveday)."' and skupina='Polévka' order by id"));

	if (@$control==""){	mysql_query ("INSERT INTO seznam_obedu (datum,skupina,obed,cena,vlozil,datumvkladu)VALUES('".securesql($saveday)."','Polévka','".securesql($value2)."','".securesql($cena)."','".securesql($loginname)."','".securesql($dnes)."')") or Die(MySQL_Error());}
	else {mysql_query ("update seznam_obedu  set datum = '".securesql($saveday)."',obed = '".securesql($value2)."',cena='".securesql($cena)."',zmenil='".securesql($loginname)."',datumzmeny='".securesql($dnes)."' where  datum = '".securesql($saveday)."' and skupina='Polévka' ")or Die(MySQL_Error());}

}
if (@$value1<>"" or @$value2<>"") {   // vynecha prazdne radky

if (@$value1=="" and @$oldvalue1<>"" and @$value2<>""){   // obedy hlavni chod$rozklad[0]=str_replace(" ","",str_replace("-","",substr(@$value2,0,4)));$rozklad[1]=substr(@$value2,4,500);

$loadcena=mysql_result(mysql_query("select hodnota from setting where nazev='Obìdy'"),0,0);
$l1cena=explode("/",@$loadcena); $l2cena=explode(",",$l1cena[1]);
$hledat=0;while ($l2cena[$hledat]<>""): if ($l2cena[$hledat]==$rozklad[0]) {$poradi=$hledat;}@$hledat++;endwhile;$l2cena=explode(",",$l1cena[3]);$cena=$l2cena[$poradi];
$control=mysql_num_rows(mysql_query("select id from seznam_obedu where datum='".securesql($saveday)."' and skupina='".securesql($rozklad[0])."' order by id"));

	if (@$control==""){
	mysql_query ("INSERT INTO seznam_obedu (datum,skupina,obed,cena,vlozil,datumvkladu)VALUES('".securesql($saveday)."','".securesql($rozklad[0])."','".securesql($rozklad[1])."','".securesql($cena)."','".securesql($loginname)."','".securesql($dnes)."')") or Die(MySQL_Error());}
	else {mysql_query ("update seznam_obedu  set datum = '".securesql($saveday)."',obed = '".securesql($rozklad[1])."',cena='".securesql($cena)."',zmenil='".securesql($loginname)."',datumzmeny='".securesql($dnes)."' where  datum = '".securesql($saveday)."' and skupina='".securesql($rozklad[0])."' ")or Die(MySQL_Error());}
}
}
@$cykl++;
endwhile;
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Importování Obìdù na období: <?echo $startwoche." - ".$endwoche." / ".@$tyden;?>T Probìhlo Úspìšnì</b></center></td></tr></table><?
}








if (@$menu=="Zadání/Oprava Meny" and @$tlacitko=="Uložit Obìdy na Vybraný Týden") {
$numberlaunch1= explode ("/", mysql_result(mysql_query("select hodnota from setting where nazev='Obìdy'"),0,0));$numberlaunch=explode(",", $numberlaunch1[0]);$numberlaunch[0]=$numberlaunch[0]-1;$numberlaunch2=explode(",", $numberlaunch1[1]);$numberlaunch3=explode(",", $numberlaunch1[3]);
$cdne= date("w", strtotime($dnes));if (@$cdne>0) {$nextwoche=(1-$cdne)." day ";if (!StrPos (" " . $nextwoche, "-")) {$nextwoche="+".$nextwoche;}$lastwoche=(1-$cdne+$numberlaunch[0])." day ";} else {$nextwoche="+1 day ";$lastwoche=(1+$numberlaunch[0])." day ";}
$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche. " + ".$_POST["tyden"]." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".$_POST["tyden"]." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".$_POST["tyden"]." weeks"));
@$cykl=0;while(@$cykl<($numberlaunch[0]+1)):$datum=date("Y-m-d", strtotime( $startwoche." + ".$cykl." day"));

@$cykl1=0;while(@$cykl1<$numberlaunch[1]):

// nastaveni ulozeni prilohy
@$cykl2=0;@$priloha=",";$rpriloha=@$_POST["priloha".$cykl];while ($rpriloha[$cykl2]<>""):@$priloha.=$rpriloha[$cykl2].",";@$cykl2++;endwhile;
if (@$_POST["spriloha".($cykl)."/".$cykl1]<>"on") {$priloha=",";} //osetreni prilohy k obedu

if (mysql_result(mysql_query("select id from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0)=="")	{	mysql_query ("INSERT INTO seznam_obedu (datum,skupina,obed,cena,datumvkladu,vlozil,priloha) VALUES('".securesql($datum)."','".securesql($numberlaunch2[@$cykl1])."','".securesql(@$_POST["obed".$cykl."/".$cykl1])."','".securesql(@$_POST["cena".$cykl."/".$cykl1])."','".securesql($dnes)."','".securesql($loginname)."','".securesql($priloha)."' )") or Die(MySQL_Error());}
else {	mysql_query ("update seznam_obedu set obed = '".securesql(@$_POST["obed".$cykl."/".$cykl1])."',cena = '".securesql(@$_POST["cena".$cykl."/".$cykl1])."', datumzmeny = '".securesql($dnes)."', zmenil ='".securesql($loginname)."',priloha='".securesql($priloha)."' where datum = '".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' ")or Die(MySQL_Error());}

@$cykl1++;endwhile;@$cykl++;endwhile;?>
<table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uložení Obìdù na období: <?echo $startwoche." - ".$endwoche." / ".@$tyden;?>T Probìhlo Úspìšnì</b></center></td></tr></table><?
@$tlacitko="";}





if (@$menu=="Odstranìní Existujícího Meny" and strlen(base64_decode(@$_GET["smazani"]))<=2 and strlen(base64_decode(@$_GET["smazani"]))<>"") {$numberlaunch1= explode ("/", mysql_result(mysql_query("select hodnota from setting where nazev='Obìdy'"),0,0));$numberlaunch=explode(",", $numberlaunch1[0]);$numberlaunch[0]=$numberlaunch[0]-1;
$cdne= date("w", strtotime($dnes));if (@$cdne>0) {$nextwoche=(1-$cdne)." day ";if (!StrPos (" " . $nextwoche, "-")) {$nextwoche="+".$nextwoche;}$lastwoche=(1-$cdne+$numberlaunch[0])." day ";} else {$nextwoche="+1 day ";$lastwoche=(1+$numberlaunch[0])." day ";}
$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".base64_decode(@$_GET["smazani"])." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".base64_decode(@$_GET["smazani"])." weeks"));$startwochedb= date("Y-m-d", strtotime( $dnes.$nextwoche." + ".base64_decode(@$_GET["smazani"])." weeks"));$endwochedb= date("Y-m-d", strtotime( $dnes." + ".$lastwoche."+".base64_decode(@$_GET["smazani"])." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".base64_decode(@$_GET["smazani"])." weeks"));
mysql_query ("delete from seznam_obedu where datum >= '".securesql($startwochedb)."' and datum <='".securesql($endwochedb)."' ")or Die(MySQL_Error());?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Odstranìní Obìdù na období: <?echo $startwoche." - ".$endwoche." / ".@$tyden;?>T Probìhlo Úspìšnì</b></center></td></tr></table>
<?$_POST["tyden"]=base64_decode(@$_GET["smazani"]);}



if (@$menu=="Odstranìní Existujícího Meny" and strlen(base64_decode(@$_GET["smazani"]))==10 and strlen(base64_decode(@$_GET["smazani"]))<>"") {
mysql_query ("delete from seznam_obedu where datum = '".securesql(base64_decode(@$_GET["smazani"]))."' ")or Die(MySQL_Error());
?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Odstranìní Obìdù na datum: <?$rozklad=explode("-",base64_decode(@$_GET["smazani"]));echo $rozklad[2].".".$rozklad[1].".".$rozklad[0];?> Probìhlo Úspìšnì</b></center></td></tr></table>
<?$_POST["tyden"]=base64_decode(@$_GET["tyden"]);}?>







<form action="hlavicka.php?akce=<?echo base64_encode('Stravovani');?>" method=post enctype="multipart/form-data">

<h2><p align="center">Správa Stravování:
<? if (StrPos (" " . $_SESSION["prava"], "H") or StrPos (" " . $_SESSION["prava"], "h")){?>
<select name=menu size="1" onchange=submit(this)>
   <option><?if (@$menu<>""){echo@$menu;}?></option>  <?}?>

<? if (StrPos (" " . $_SESSION["prava"], "H")){?>
   <?if (@$menu<>"Zadání/Oprava Meny"){?><option>Zadání/Oprava Meny</option><?}?>
   <?if (@$menu<>"Odstranìní Existujícího Meny"){?><option>Odstranìní Existujícího Meny</option><?}?>
   <?if (@$menu<>"Import Meny"){?><option>Import Meny</option><?}}?>


<? if (StrPos (" " . $_SESSION["prava"], "H") or StrPos (" " . $_SESSION["prava"], "h")){?>
   <?if (@$menu<>"Pøehled Existujících Obìdù"){?><option>Pøehled Existujících Obìdù</option><?}?>
   <?if (@$menu<>"Tisk Obìdù"){?><option>Tisk Obìdù</option><?}}?>

   </select> </p></h2><BR>

<? if (!StrPos (" " . $_SESSION["prava"], "H") and (!StrPos (" " . $_SESSION["prava"], "h")) ){?>Nemáte Pøístupová Práva<?}?>

<center><table  bgcolor="#EDB745" border=2>




<? if (StrPos (" " . $_SESSION["prava"], "H")){?>


<?if (@$menu=="Zadání/Oprava Meny"){
$numberlaunch1= explode ("/", mysql_result(mysql_query("select hodnota from setting where nazev='Obìdy'"),0,0));$numberlaunch=explode(",", $numberlaunch1[0]);$numberlaunch2=explode(",", $numberlaunch1[1]);$numberlaunch[0]=$numberlaunch[0]-1;$numberlaunch3=explode(",", $numberlaunch1[3]);$numberlaunch7=explode(",", $numberlaunch1[7]);$numberlaunch8=explode(",", $numberlaunch1[8]);?>
<tr><td bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td>
<?$cdne= date("w", strtotime($dnes));if (@$cdne>0) {$nextwoche=(1-$cdne)." day ";if (!StrPos (" " . $nextwoche, "-")) {$nextwoche="+".$nextwoche;}$lastwoche=(1-$cdne+$numberlaunch[0])." day ";} else {$nextwoche="+1 day ";$lastwoche=(1+$numberlaunch[0])." day ";}
?><td bgcolor="#C0FFC0" colspan=<?echo ($numberlaunch[1]+1);?> align=right>Týden: <select size="1" name="tyden" onchange=submit(this)>


<?if ($_POST["tyden"]<>"") {@$cykl=-1;}else {@$cykl=0;echo"<option></option>";}while(@$cykl<13):
if ($_POST["tyden"]<>"" and @$cykl==-1) {$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".$_POST["tyden"]." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".$_POST["tyden"]." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".$_POST["tyden"]." weeks"));echo"<option value=".$_POST["tyden"].">".$startwoche." - ".$endwoche." / ".$tyden."T</option>";}
if (@$cykl>=0) {$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".@$cykl." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".@$cykl." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".@$cykl." weeks"));
if ($_POST["tyden"]<>@$cykl or $_POST["tyden"]=="") {echo"<option value='".$cykl."' >".$startwoche." - ".$endwoche." / ".$tyden."T </option>";}}
if (@$startingwoche=="") {@$startingwoche=$startwoche;}@$cykl++;endwhile;?></select></td></tr>

<tr><td><b>Týden</b></td><?$nobed=explode(",", $numberlaunch1[1]);@$cykl1=0;while(@$cykl1<($numberlaunch[1])):echo"<td align=center><b>".$nobed[$cykl1]."</b></td>";@$cykl1++;endwhile;echo"<td align=center><b>Pøíloha</b></td></tr>";
@$cykl=0;while(@$cykl<($numberlaunch[0]+1)and @$_POST["tyden"]<>""):
$dsvatku= date("-m-d", strtotime( $startingwoche." + ".@$cykl." day"));$dsvatku1= date("Y-m-d", strtotime( $startingwoche." + ".@$cykl." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedineèný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
if ($svatek<>"") {$barva="#F7FBA4";} else {$barva="#EDB745";}
if(@$cykl==0) {$name="Pondìlí";}if(@$cykl==1) {$name="Úterý";}if(@$cykl==2) {$name="Støeda";}if(@$cykl==3) {$name="Ètvrtek";}if(@$cykl==4) {$name="Pátek";}if(@$cykl==5) {$name="Sobota";}if(@$cykl==6) {$name="Nedìle";}
echo"<tr bgcolor=".$barva."><td>".$name."</td>";$datum=date("Y-m-d", strtotime($startingwoche." + ".$cykl." day"));
@$cykl1=0;while(@$cykl1<($numberlaunch[1]+1)):

if (@$cykl1<$numberlaunch[1]){
echo"<td align=left>";if (($numberlaunch1[2]=="ANO" and $barva=="#F7FBA4") or $barva=="#EDB745") {echo"<textarea name=obed".$cykl."/".$cykl1." rows=4 cols=20 wrap=on>";
echo mysql_result(mysql_query("select obed from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0);
echo"</textarea><br /><input name=cena".$cykl."/".$cykl1." type=text style=width:47% value=";if (mysql_result(mysql_query("select obed from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0)<>""){echo $kolik=mysql_result(mysql_query("select cena from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0);} else {echo $kolik=$numberlaunch3[$cykl1];}echo"> Kè";if ($kolik<>0) {echo"<input name=spriloha".$cykl."/".$cykl1." type=checkbox";

$wpriloha=mysql_result(mysql_query("select priloha from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0);
if (@$wpriloha<>"," and @$wpriloha<>""){echo" checked ";}

echo" >: Pøíloha";}} else {echo"Svátek";}"</td>";
}
if (@$cykl1==$numberlaunch[1]){echo"<td><select size=5  name=priloha".$cykl."[]  multiple=multiple >";
$cykl2=1;while($numberlaunch8[@$cykl2]):
echo "<option ";
if (StrPos (" " .mysql_result(mysql_query("select priloha from seznam_obedu where datum='".securesql($datum)."' and priloha<>',' limit 1 "),0,0), ",".$numberlaunch8[@$cykl2].",")) {echo" selected ";}
echo" >".$numberlaunch8[@$cykl2]."</option>";
@$cykl2++;endwhile;
echo"</select></td>";
}

@$cykl1++;endwhile;echo"</tr>";
@$cykl++;endwhile;?>

<tr><td colspan=<?echo $numberlaunch[1]+2;?>><center><BR><input type="submit" name=tlacitko value="Uložit Obìdy na Vybraný Týden"></center></td></tr><?}?>





<?if (@$menu=="Odstranìní Existujícího Meny"){
$numberlaunch1= explode ("/", mysql_result(mysql_query("select hodnota from setting where nazev='Obìdy'"),0,0));$numberlaunch=explode(",", $numberlaunch1[0]);$numberlaunch2=explode(",", $numberlaunch1[1]);$numberlaunch[0]=$numberlaunch[0]-1;$numberlaunch3=explode(",", $numberlaunch1[3]);$numberlaunch7=explode(",", $numberlaunch1[7]);$numberlaunch8=explode(",", $numberlaunch1[8]);?>
<tr><td bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td>
<?$cdne= date("w", strtotime($dnes));if (@$cdne>0) {$nextwoche=(1-$cdne)." day ";if (!StrPos (" " . $nextwoche, "-")) {$nextwoche="+".$nextwoche;}$lastwoche=(1-$cdne+$numberlaunch[0])." day ";} else {$nextwoche="+1 day ";$lastwoche=(1+$numberlaunch[0])." day ";}
?><td bgcolor="#C0FFC0" colspan=<?echo ($numberlaunch[1]+1);?> align=right>Týden: <select size="1" name="tyden" onchange=submit(this)>


<?if ($_POST["tyden"]<>"") {@$cykl=-1;}else {@$cykl=0;echo"<option></option>";}while(@$cykl<13):
if ($_POST["tyden"]<>"" and @$cykl==-1) {$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".$_POST["tyden"]." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".$_POST["tyden"]." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".$_POST["tyden"]." weeks"));echo"<option value=".$_POST["tyden"].">";echo $tkodstraneni=$startwoche." - ".$endwoche." / ".$tyden."T";echo"</option>";}
if (@$cykl>=0) {$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".@$cykl." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".@$cykl." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".@$cykl." weeks"));
if ($_POST["tyden"]<>@$cykl or $_POST["tyden"]=="") {echo"<option value='".$cykl."' >".$startwoche." - ".$endwoche." / ".$tyden."T </option>";}}
if (@$startingwoche=="") {@$startingwoche=$startwoche;}@$cykl++;endwhile;?></select></td></tr>

<tr><td><?if (@$_POST["tyden"]<>"") {?><img src="picture/delete.png" width="20" height="20" alt="Odstranit Celý Týden" border="0" style="cursor: pointer;" onClick="if(confirm('Chcete skuteènì Celý Týden: <?echo $tkodstraneni;?> Odstranit?')) window.location.href('hlavicka.php?akce=<?echo base64_encode("Stravovani");?>&menu=<?echo base64_encode(@$menu);?>&smazani=<?echo base64_encode($_POST["tyden"]);?>');"><?}?> <b>TýDen</b></td><?$nobed=explode(",", $numberlaunch1[1]);@$cykl1=0;while(@$cykl1<($numberlaunch[1])):echo"<td align=center><b>".$nobed[$cykl1]."</b></td>";@$cykl1++;endwhile;echo"<td align=center><b>Pøíloha</b></td></tr>";
@$cykl=0;while(@$cykl<($numberlaunch[0]+1) and @$_POST["tyden"]<>""):
$dsvatku= date("-m-d", strtotime( $startingwoche." + ".@$cykl." day"));$dsvatku1= date("Y-m-d", strtotime( $startingwoche." + ".@$cykl." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedineèný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
if ($svatek<>"") {$barva="#F7FBA4";} else {$barva="#EDB745";}
if(@$cykl==0) {$name="Pondìlí";}if(@$cykl==1) {$name="Úterý";}if(@$cykl==2) {$name="Støeda";}if(@$cykl==3) {$name="Ètvrtek";}if(@$cykl==4) {$name="Pátek";}if(@$cykl==5) {$name="Sobota";}if(@$cykl==6) {$name="Nedìle";}
$datum=date("Y-m-d", strtotime($startingwoche." + ".$cykl." day"));
echo"<tr bgcolor=".$barva."><td>";
if (@$_POST["tyden"]<>"" and mysql_result(mysql_query("select id from seznam_obedu where datum='".securesql($datum)."' "),0,0)<>"") {?><img src="picture/delete.png" width="20" height="20" alt="Odstranit <?echo@$name;?>?" border="0" style="cursor: pointer;" onClick="if(confirm('Chcete skuteènì <?echo@$name?> Odstranit?')) window.location.href('hlavicka.php?akce=<?echo base64_encode("Stravovani");?>&menu=<?echo base64_encode(@$menu);?>&smazani=<?echo base64_encode($datum);?>&tyden=<?echo base64_encode($_POST["tyden"]);?>');"><?}
echo " ".$name."</td>";
@$cykl1=0;while(@$cykl1<($numberlaunch[1]+1)):

if (@$cykl1<$numberlaunch[1]){
echo"<td align=left>";if (($numberlaunch1[2]=="ANO" and $barva=="#F7FBA4") or $barva=="#EDB745") {echo"<textarea name=obed".$cykl."/".$cykl1." rows=4 cols=20 wrap=on readonly=yes>";
echo mysql_result(mysql_query("select obed from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0);
echo"</textarea><br /><input readonly=yes name=cena".$cykl."/".$cykl1." type=text style=width:47% value=";if (mysql_result(mysql_query("select obed from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0)<>""){echo  $kolik=mysql_result(mysql_query("select cena from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0);} else {echo  $kolik=$numberlaunch3[$cykl1];}echo"> Kè";if ($kolik<>0) {echo"<input disabled=disabled name=spriloha".$cykl."/".$cykl1." type=checkbox";

$wpriloha=mysql_result(mysql_query("select priloha from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0);
if (@$wpriloha<>"," and @$wpriloha<>""){echo" checked ";}

echo" >: Pøíloha";}} else {echo"Svátek";}"</td>";
}

if (@$cykl1==$numberlaunch[1]){
echo"<td><select size=5  name=priloha".$cykl."[]  multiple=multiple>";
$cykl2=1;while($numberlaunch8[@$cykl2]):
echo "<option disabled=disabled ";
if (StrPos (" " .mysql_result(mysql_query("select priloha from seznam_obedu where datum='".securesql($datum)."' and priloha<>',' limit 1"),0,0), ",".$numberlaunch8[@$cykl2].",")) {echo" style=background-color:#C0BDFB ";}
echo" >".$numberlaunch8[@$cykl2]."</option>";
@$cykl2++;endwhile;
echo"</select></td>";
}
@$cykl1++;endwhile;echo"</tr>";
@$cykl++;endwhile;?>
<?}?>





<?if (@$menu=="Import Meny"){
$numberlaunch1= explode ("/", mysql_result(mysql_query("select hodnota from setting where nazev='Obìdy'"),0,0));$numberlaunch=explode(",", $numberlaunch1[0]);$numberlaunch2=explode(",", $numberlaunch1[1]);$numberlaunch[0]=$numberlaunch[0]-1;$numberlaunch3=explode(",", $numberlaunch1[3]);?>
<tr><td bgcolor="#C0FFC0"><center><b><?echo@$menu;?><img src="picture/help.png" width="16" height="16" title="Na frantíkových stránkách zkopírujete pondìlí až pátek do excelu, odstraníte prázdné øádky a uložíte jako soubor csv oddìlený støedníkem, tento pak zde naimportujete"></b></center></td>
<?$cdne= date("w", strtotime($dnes));if (@$cdne>0) {$nextwoche=(1-$cdne)." day ";if (!StrPos (" " . $nextwoche, "-")) {$nextwoche="+".$nextwoche;}$lastwoche=(1-$cdne+$numberlaunch[0])." day ";} else {$nextwoche="+1 day ";$lastwoche=(1+$numberlaunch[0])." day ";}
?><td bgcolor="#C0FFC0" align=right>Týden: <select size="1" name="tyden" onchange=submit(this)>


<?if ($_POST["tyden"]<>"") {@$cykl=-1;}else {@$cykl=0;echo"<option></option>";}while(@$cykl<13):
if ($_POST["tyden"]<>"" and @$cykl==-1) {$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".$_POST["tyden"]." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".$_POST["tyden"]." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".$_POST["tyden"]." weeks"));echo"<option value=".$_POST["tyden"].">";echo $tkodstraneni=$startwoche." - ".$endwoche." / ".$tyden."T";echo"</option>";}
if (@$cykl>=0) {$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".@$cykl." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".@$cykl." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".@$cykl." weeks"));
if ($_POST["tyden"]<>@$cykl or $_POST["tyden"]=="") {echo"<option value='".$cykl."' >".$startwoche." - ".$endwoche." / ".$tyden."T </option>";}}
if (@$startingwoche=="") {@$startingwoche=$startwoche;}@$cykl++;endwhile;?></select></td></tr>
<?if ($_POST["tyden"]<>"") {echo"<tr><td colspan=2 align=center><input type=file name=soubor style=width:100%></td></tr><tr><td colspan=2 align=center><input name=tlacitko type='submit' value='Importovat Soubor'></td></tr>";}


}?>




<?}?>


<? if (StrPos (" " . $_SESSION["prava"], "H") or  StrPos (" " . $_SESSION["prava"], "h") ){?>

<?if (@$menu=="Tisk Obìdù"){?>
<script type="text/javascript">
window.open('TiskObedu.php?select=<?echo base64_encode($_POST["tyden"]);?>')
</script>
<?}?>




<?if (@$menu=="Pøehled Existujících Obìdù"){
$numberlaunch1= explode ("/", mysql_result(mysql_query("select hodnota from setting where nazev='Obìdy'"),0,0));$numberlaunch=explode(",", $numberlaunch1[0]);$numberlaunch2=explode(",", $numberlaunch1[1]);$numberlaunch[0]=$numberlaunch[0]-1;$numberlaunch3=explode(",", $numberlaunch1[3]);$numberlaunch7=explode(",", $numberlaunch1[7]);$numberlaunch8=explode(",", $numberlaunch1[8]);?>
<tr><td bgcolor="#C0FFC0"><center><b><?echo@$menu;?></b></center></td>
<?$cdne= date("w", strtotime($dnes));if (@$cdne>0) {$nextwoche=(1-$cdne)." day ";if (!StrPos (" " . $nextwoche, "-")) {$nextwoche="+".$nextwoche;}$lastwoche=(1-$cdne+$numberlaunch[0])." day ";} else {$nextwoche="+1 day ";$lastwoche=(1+$numberlaunch[0])." day ";}
?><td bgcolor="#C0FFC0" colspan=<?echo ($numberlaunch[1]+1);?> align=right>Týden: <select size="1" name="tyden" onchange=submit(this)>


<?if ($_POST["tyden"]<>"") {@$cykl=-1;}else {@$cykl=0;echo"<option></option>";}while(@$cykl<13):
if ($_POST["tyden"]<>"" and @$cykl==-1) {$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".$_POST["tyden"]." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".$_POST["tyden"]." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".$_POST["tyden"]." weeks"));echo"<option value=".$_POST["tyden"].">";echo $tkodstraneni=$startwoche." - ".$endwoche." / ".$tyden."T";echo"</option>";}
if (@$cykl>=0) {$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".@$cykl." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".@$cykl." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".@$cykl." weeks"));
if ($_POST["tyden"]<>@$cykl or $_POST["tyden"]=="") {echo"<option value='".$cykl."' >".$startwoche." - ".$endwoche." / ".$tyden."T </option>";}}
if (@$startingwoche=="") {@$startingwoche=$startwoche;}@$cykl++;endwhile;?></select></td></tr>

<tr><td><b>TýDen</b></td><?$nobed=explode(",", $numberlaunch1[1]);@$cykl1=0;while(@$cykl1<($numberlaunch[1])):echo"<td align=center><b>".$nobed[$cykl1]."</b></td>";@$cykl1++;endwhile;echo"<td align=center><b>Pøíloha</b></td></tr>";
@$cykl=0;while(@$cykl<($numberlaunch[0]+1) and @$_POST["tyden"]<>""):
$dsvatku= date("-m-d", strtotime( $startingwoche." + ".@$cykl." day"));$dsvatku1= date("Y-m-d", strtotime( $startingwoche." + ".@$cykl." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$dsvatku1' and typ='Jedineèný') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trvalý' and stav='Neaktivní')) "),0,0);
if ($svatek<>"") {$barva="#F7FBA4";} else {$barva="#EDB745";}
if(@$cykl==0) {$name="Pondìlí";}if(@$cykl==1) {$name="Úterý";}if(@$cykl==2) {$name="Støeda";}if(@$cykl==3) {$name="Ètvrtek";}if(@$cykl==4) {$name="Pátek";}if(@$cykl==5) {$name="Sobota";}if(@$cykl==6) {$name="Nedìle";}
$datum=date("Y-m-d", strtotime($startingwoche." + ".$cykl." day"));
echo"<tr bgcolor=".$barva."><td>";
echo " ".$name."</td>";
@$cykl1=0;while(@$cykl1<($numberlaunch[1]+1)):

if (@$cykl1<$numberlaunch[1]){echo"<td align=left>";if (($numberlaunch1[2]=="ANO" and $barva=="#F7FBA4") or $barva=="#EDB745") {echo"<textarea name=obed".$cykl."/".$cykl1." rows=4 cols=20 wrap=on readonly=yes>";
echo mysql_result(mysql_query("select obed from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0);
echo"</textarea><br /><input readonly=yes name=cena".$cykl."/".$cykl1." type=text style=width:47% value=";if (mysql_result(mysql_query("select obed from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0)<>""){echo $kolik=mysql_result(mysql_query("select cena from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0);} else {echo $kolik=$numberlaunch3[$cykl1];}echo"> Kè";if ($kolik<>0) {echo"<input disabled=disabled name=spriloha".$cykl."/".$cykl1." type=checkbox";

$wpriloha=mysql_result(mysql_query("select priloha from seznam_obedu where datum='".securesql($datum)."' and skupina='".securesql($numberlaunch2[@$cykl1])."' "),0,0);
if (@$wpriloha<>"," and @$wpriloha<>""){echo" checked ";}

echo" >: Pøíloha";}} else {echo"Svátek";}"</td>";
}
if (@$cykl1==$numberlaunch[1]){
echo"<td><select size=5  name=priloha".$cykl."[]  multiple=multiple>";
$cykl2=1;while($numberlaunch8[@$cykl2]):
echo "<option disabled=disabled ";
if (StrPos (" " .mysql_result(mysql_query("select priloha from seznam_obedu where datum='".securesql($datum)."' and priloha<>',' limit 1"),0,0), ",".$numberlaunch8[@$cykl2].",")) {echo" style=background-color:#C0BDFB ";}
echo" >".$numberlaunch8[@$cykl2]."</option>";
@$cykl2++;endwhile;
echo"</select></td>";
}
@$cykl1++;endwhile;echo"</tr>";
@$cykl++;endwhile;}?>

<?}?>






</table></center>
</form>
