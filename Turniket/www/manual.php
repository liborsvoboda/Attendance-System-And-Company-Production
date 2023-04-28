<?php
$action =@$_GET["action"];

include ("./knihovna.php");
include ("./dbconnect.php");

if (@$action=="reload") {session_unset($_SESSION['PHP_AUTH_USER']);}

function authenticate_user(){
header('WWW-Authenticate: Basic realm="Pøihlášení do Aplikace: Turniket Manuál"');
header('HTTP/1.0 401 Unauthorized');}

if (!isset($_SERVER['PHP_AUTH_USER'])){
authenticate_user();
} else {

// výbìrový dotaz

$query=("SELECT jmeno FROM login WHERE jmeno='$_SERVER[PHP_AUTH_USER]'
AND heslo=MD5('$_SERVER[PHP_AUTH_PW]')");
$prava1=("SELECT prava FROM login WHERE jmeno='$_SERVER[PHP_AUTH_USER]' AND heslo=MD5('$_SERVER[PHP_AUTH_PW]')");



$results=mysql_query($query);
 @$test=mysql_num_rows($results);
if ($test == 0 ) {

authenticate_user();
}
}
if (@$test == 0 or @$test =="" ) {
?><BR><BR><?
echo"Vaše pøihlášení se nezdaøilo prosím kontaktujte Správce Sítì";}

if (@$test <> 0 ) {


$loginname= $_SERVER['PHP_AUTH_USER'];
$results1=mysql_query($prava1);
@$prava=mysql_result($results1,0,0);
session_start();
session_register("loginname");
session_register("prava");
$_SESSION['loginname']=$loginname;
$_SESSION['prava']=$prava;


@$dnes=date("Y-n-d");
mysql_query ("update login  set lastlogin = '$dnes' where jmeno = '$loginname' ")or Die(MySQL_Error());

?>
<html>
<head>
<title>Turniket</title>
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
</head>

<?
$dnes=date("Y-m-d");
$cas=StrFTime("%H:%M:%S", Time());
$aktcas=StrFTime("%H:%M", Time());
$dnescs=date("d.m.Y");
$turniket=@$_POST["turniket"];if ($turniket=="") {$turniket=desifra(@$_GET["turniket"]);}

if (desifra(@$_GET["door"])=="Otevøít") { echo"hi";
include "./php_serial.class.php";
$serial = new phpSerial;
$serial->deviceSet("COM1");
$serial->deviceOpen();
$serial->sendMessage("00000000");
$serial->deviceClose();
$serial->confBaudRate(600);

unset($_POST["door"]);
}?>



<body bgcolor="#E6AD6F" style=margin:0;><form action="manual.php" method="post">
<center><table width=100% style=margin:0 cellpadding="0" cellspacing="0" border=1px height=100%>
<tr bgcolor=#E6AD6F style=margin:0><td colspan=2 align=center><span style=font-size:50pt><b>Ovládání Turniketu</b></span>
<br /><select size="1" name="turniket" onchange=submit(this) style=font-size:20pt >
<?if ($turniket) {echo "<option value='".$turniket."'>".mysql_result(mysql_query("select nazev from turnikety where ip_adresa='".securesql($turniket)."' "),0,0)."</option>";} else {echo"<option></option>";}
$data1=mysql_query("select * from turnikety order by nazev,id");
@$cykl=0;while(@$cykl<mysql_num_rows(@$data1)):
if ($turniket<>mysql_result($data1,$cykl,2)) {echo "<option value='".mysql_result($data1,$cykl,2)."'>".mysql_result($data1,$cykl,1)."</option>";}
@$cykl++;endwhile;?></select>

</td></tr></form>

<tr height=100%><td width=80% align=center vertical-align=middle>
<?
if ($turniket) {$data1=mysql_query("select ip_kamery,jmeno,heslo,typ from turnikety where ip_adresa='".securesql($turniket)."' ");$kip=mysql_result($data1,0,0);
$kname=mysql_result($data1,0,1);
$kpasswd=mysql_result($data1,0,2);
include "./".mysql_result($data1,0,3).".php";}?>
</td>

<td width=20% align=center vertical-align=middle>

<?if ($turniket) {?>
<input type="button" value="Otevøít Turniket" onclick="window.location.assign('http://<?echo $turniket;?>/manual.php?door=<?echo sifra("Otevøít");?>&turniket=<?echo sifra($turniket);?>')"   style=height:60px;font-size:30pt;vertical-align:middle style="cursor: pointer;">
<?}?>

</td></tr>



</table></center>
</body>

<?}?>












