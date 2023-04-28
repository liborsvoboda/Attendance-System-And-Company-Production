<!--//vypis obedu//-->
<html>
<head>
<title>Docházkový Systém</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

   <?php
    $u_agent = $_SERVER['HTTP_USER_AGENT'];$ub = '';
    if(preg_match('/MSIE/i',$u_agent)) {$ub = "ie";}
    elseif(preg_match('/Firefox/i',$u_agent)) {$ub = "firefox";}
    elseif(preg_match('/Safari/i',$u_agent)) {$ub = "safari";}
    elseif(preg_match('/Chrome/i',$u_agent)) {$ub = "chrome";}
    elseif(preg_match('/Flock/i',$u_agent)) {$ub = "flock";}
    elseif(preg_match('/Opera/i',$u_agent)) {$ub = "opera";}
?>

 <!--//zakaz oznaceni / vybrani textu//-->
<SCRIPT language="JavaScript">
// Internet Explorer:
if (document.all)
  document.onselectstart =
    function () { return false; };
// Netscape 4:
if (document.layers) {
  document.captureEvents(Event.MOUSEDOWN);
  document.onmousedown =
    function (evt) { return false; };
}
// Netscape 6:
document.onmousedown = function () { return false; };
</script>

<!--// 3 ochrany proti navratu zpet, zmacknuti F5 jako reload, a zakaz praveho tlacitka mysi//-->
<SCRIPT LANGUAGE="JavaScript">
javascript:window.history.forward(0);
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


</head>
<?
include ("./"."dbconnect.php");
include ("./"."knihovna.php");
@$dnes=date("Y-m-d");
$data150=mysql_query("select * from objednavky_obedu where (osobni_cislo='".securesql(@$_GET["usernumber"])."' or tr_osobni_cislo='".securesql(@$_GET["usernumber"])."') and datum='$dnes' order by skupina,id");
?><body style=margin:0; bgcolor=#E6AD6F ><table style="font-size: 28pt;color=#000000" border=1 width=100%><tr align=center bgcolor=#CDC9F5><td colspan=3>Dnešní Oběd</td></tr>
<?$write=0;while(@$write<mysql_num_rows($data150)):
$vedlejsi=explode("+:+",mysql_result(@$data150,@$write,12));
echo "<tr align=center bgcolor=#CEDCEA><td width=10%>".mysql_result(@$data150,@$write,3);if ($vedlejsi[0]){echo "<br />".$vedlejsi[0];}echo"</td><td width=65%>".mysql_result(@$data150,@$write,4);if (mysql_result(@$data150,@$write,11)){echo"<br />Jiná Příloha: ".mysql_result(@$data150,@$write,11);}if ($vedlejsi[1]){echo "<br />".$vedlejsi[1];}echo"</td>";

if (mysql_result(@$data150,@$write,8)){	if (mysql_result(@$data150,@$write,1)<>@$_GET["usernumber"]) {echo"<td width=25%>Předal:<br />".mysql_result(@$data150,@$write,1)." ".mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(mysql_result(@$data150,@$write,1))."' "),0,0)."</td>";}
	if (mysql_result(@$data150,@$write,1)==@$_GET["usernumber"]){echo"<td width=25%>Vyzvedne:<br />".mysql_result(@$data150,@$write,8)." ".mysql_result(mysql_query("select CONCAT(prijmeni,' ',jmeno,' ',titul) from zamestnanci where osobni_cislo='".securesql(mysql_result(@$data150,@$write,8))."' "),0,0)."</td>";}
} else {echo"<td width=25%></td>";}
echo"</tr>";
@$write++;endwhile;?></table>
<br /><center><button onClick="window.close()" style="width:300px;height:70px;font-size:30pt;color:red;cursor:pointer;">Zavřít Okno</button></center>

<script language="JavaScript">setTimeout('window.close()', 30000)</script>

</body>



