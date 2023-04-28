<?php
$action =@$_GET["action"];

if (@$action=="reload") {session_unset($_SESSION['PHP_AUTH_USER']);}

function authenticate_user(){
header('WWW-Authenticate: Basic realm="Pøihlášení do Aplikace: Docházkový Systém"');
header('HTTP/1.0 401 Unauthorized');}

if (!isset($_SERVER['PHP_AUTH_USER'])){
authenticate_user();
} else {
mysql_connect ("127.0.0.1","root","") or die ("Nelze se pøipojit k databázovému serveru");
mysql_select_db ("dochazkovy_system") or die ("Nelze se pøipojit k databázi");

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
mysql_connect ("127.0.0.1","root","") or die ("Nelze se pøipojit k databázovému serveru");
mysql_select_db ("dochazkovy_system") or die ("Nelze se pøipojit k databázi");
mysql_query ("update login  set lastlogin = '$dnes' where jmeno = '$loginname' ")or Die(MySQL_Error());

?><body background ="../picture/pozadi.jpg"><META HTTP-EQUIV="Refresh" CONTENT="0;URL=hlavicka.php"></body>
<?}?>

