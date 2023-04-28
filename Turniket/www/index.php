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
$cdne=date("w"); if ($cdne==0){$cdne=7;}$cdne="den".$cdne;
$dnes=date("Y-m-d");
$cas=StrFTime("%H:%M:%S", Time());
$aktcas=StrFTime("%H:%M", Time());
$dnescs=date("d.m.Y");
$cip=@$_GET["cip"];
if (@$cip=="null") {@$cip="";}

include ("./knihovna.php");
include ("./dbconnect.php");

?>
<body bgcolor="#E6AD6F" style=margin:0;>
<center><table width=100% style=margin:0 cellpadding="0" cellspacing="0" border=0px>
<tr bgcolor=#E6AD6F style=margin:0><td colspan=2 align=center><span style=font-size:50pt><b>Ovládání Turniketu</b></span></td></tr>
<tr><td colspan=2 align=center><div id="clock" style=width:100%;font-size:70pt>&nbsp;</div></td></tr>
<?
// nacteni cisla turniketu
@$localserver=$_SERVER["SERVER_NAME"];
@$cisloturniketu=mysql_result(mysql_query("select id from turnikety where ip_adresa='".securesql($localserver)."' and stav='Aktivní' "),0,0);
@$casturniketu=mysql_result(mysql_query("select $cdne from turnikety where ip_adresa='".securesql($localserver)."' and stav='Aktivní' "),0,0);
@$rozpad=explode("-",$casturniketu);@$od=$rozpad[0];@$do=$rozpad[1];

if (@$cisloturniketu) { // konec nacteni cisla turniketu podninka je ze musi byt platny



if (@$cip) {   // vyhodnoceni cipu@$osobnicislo=mysql_result(mysql_query("select osobni_cislo from cipy where cip='".securesql($cip)."' and platnostod<='".date("Y-m-d")."' and (platnostdo='0000-00-00' or platnostdo>='".date("Y-m-d")."') "),0,0);

if (@$osobnicislo<>"") {
@$kontrolapovoleni=mysql_result(mysql_query("select turnikety from zamestnanci where osobni_cislo='".securesql($osobnicislo)."' "),0,0);
if (@StrPos (" " . $kontrolapovoleni, ",".$cisloturniketu.",") and @$aktcas>=@$od and @$aktcas<=@$do) {  // vyhodnoceni prava k aktivnimu turniketu
mysql_query ("INSERT INTO pruchody (id_turniketu,cip,osobni_cislo,datumacas,vlozil,datumvkladu) VALUES('".securesql($cisloturniketu)."','".securesql($cip)."','".securesql($osobnicislo)."','".date("Y-m-d")." ".StrFTime("%H:%M:%S", Time())."','".securesql($localserver)."','$dnes')") or Die(MySQL_Error());

include "./php_serial.class.php";
$serial = new phpSerial;
$serial->deviceSet("COM1");
$serial->deviceOpen();
$serial->sendMessage("00000000");
$serial->deviceClose();
$serial->confBaudRate(600);}

else {  // pristup zamitnut poslat varovny email
  require "class.phpmailer.php";
  $mail = new PHPMailer();
  $mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
  $mail->Host = "192.168.200.1";  // zadáme adresu SMTP serveru
  $mail->SMTPAuth = false;               // nastavíme true v případě, že server vyžaduje SMTP autentizaci
  $mail->Username = "admin";   // uživatelské jméno pro SMTP autentizaci
  $mail->Password = "";            // heslo pro SMTP autentizaci
  $mail->From = "admin@heunisch-brno.cz";   // adresa odesílatele skriptu
  $mail->FromName = "Docházkový Systém"; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)

@$data1 = mysql_query("select * from security order by id ASC") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($data1)):
$mail->AddAddress (mysql_result(@$data1,@$cykl,1),"");
@$cykl++;endwhile;

  $mail->Subject = "Pokus o Nepovolený Průchod Zaměstnancem";    // nastavíme předmět e-mailu
  $mail->Body = "Pokus o Průchod na turniketu: ".mysql_result(mysql_query("select nazev from turnikety where ip_adresa='".securesql($localserver)."' and stav='Aktivní' "),0,0)." v: ".@$dnescs." ".@$cas."\r\n Vlastník Čipu: ".$osobnicislo;  // nastavíme tělo e-mailu
  $mail->WordWrap = 100;   // je vhodné taky nastavit zalomení (po 50 znacích)
  $mail->CharSet = "windows-1250";   // nastavíme kódování, ve kterém odesíláme e-mail

  if(!$mail->Send()) {  // odešleme e-mail
     echo 'Došlo k chybě při odeslání e-mailu.';
     echo 'Chybová hláška: ' . $mail->ErrorInfo;
  }
// konec varovneho mailu

}

} else {   // neplatny cip poslat varovny email
  @$vlastnik=mysql_result(mysql_query("select osobni_cislo from cipy where cip='".securesql($cip)."' order by id DESC"),0,0);
  if (@$vlastnik) {@$jmoldman=mysql_result(mysql_query("select CONCAT(titul,' ',prijmeni,' ',jmeno) from zamestnanci where osobni_cislo='".securesql($vlastnik)."' "),0,0);}
  require "class.phpmailer.php";
  $mail = new PHPMailer();
  $mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
  $mail->Host = "192.168.200.1";  // zadáme adresu SMTP serveru
  $mail->SMTPAuth = false;               // nastavíme true v případě, že server vyžaduje SMTP autentizaci
  $mail->Username = "admin";   // uživatelské jméno pro SMTP autentizaci
  $mail->Password = "";            // heslo pro SMTP autentizaci
  $mail->From = "admin@heunisch-brno.cz";   // adresa odesílatele skriptu
  $mail->FromName = "Docházkový Systém"; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)

@$data1 = mysql_query("select * from security order by id ASC") or Die(MySQL_Error());@$cykl=0;
while (@$cykl<mysql_num_rows($data1)):
$mail->AddAddress (mysql_result(@$data1,@$cykl,1),"");
@$cykl++;endwhile;

  $mail->Subject = "Pokus o Průchod Turniketu cizím či neplatným čipem";    // nastavíme předmět e-mailu
  $mail->Body = "Pokus o Průchod na turniketu: ".mysql_result(mysql_query("select nazev from turnikety where ip_adresa='".securesql($localserver)."' and stav='Aktivní' "),0,0)." v: ".@$dnescs." ".@$cas."\r\n Bývalý Vlastník Čipu: ".@$vlastnik." ".@$jmoldman;  // nastavíme tělo e-mailu
  $mail->WordWrap = 100;   // je vhodné taky nastavit zalomení (po 50 znacích)
  $mail->CharSet = "windows-1250";   // nastavíme kódování, ve kterém odesíláme e-mail

  if(!$mail->Send()) {  // odešleme e-mail
     echo 'Došlo k chybě při odeslání e-mailu.';
     echo 'Chybová hláška: ' . $mail->ErrorInfo;
  }
// konec varovneho mailu}

// priprava na dalsi cteni
$cip="";
}}


mysql_close();
if ($cip=="") {    //  cteni cipu?>
<SCRIPT language="JavaScript">
var oscislo;
oscislo=window.prompt('Čip:','');
window.location.href="index.php?cip="+oscislo;
</script>

<?}?>















</table></center>
</body>