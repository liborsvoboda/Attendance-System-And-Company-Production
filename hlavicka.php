<?
include ("./"."dbconnect.php");
include ("./"."knihovna.php");

session_set_cookie_params(86400);
session_start();
session_register("loginname");
session_register("prava");
if ($_SESSION["loginname"]<>"") {$loginname=$_SESSION["loginname"];
$prava=$_SESSION["prava"];}

@$dnes=date("Y-m-d");
@$dnest=date("Y-m-d")." ".StrFTime("%H:%M:%S", Time());
@$dnescs=date("d.m.Y");

$akce=@$_POST["akce"];
if (@$akce==""){$akce=@$_GET["akce"];}

$razeni=@$_POST["razeni"];
if (@$razeni==""){$razeni=@$_GET["razeni"];}
// echo@$akce;
?>
<html>
<head>
<title>Docházkový Systém</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">

<!--// 3 ochrany proti navratu zpet, zmacknuti F5 jako reload, a zakaz praveho tlacitka mysi//-->
<SCRIPT LANGUAGE="JavaScript">
javascript:window.history.forward(0);
</SCRIPT>

<script language="JavaScript">
if (document.all){
document.onkeydown = function (){    var key_f5 = 116; // 116 = F5
if (key_f5==event.keyCode){ event.keyCode = 27;return false;}}}
</script>

<?if (base64_decode($akce)<>"export" and base64_decode($akce)<>"Ukoly"){?>
<script language ="javascript">
function Disable() {
if (event.button == 2)
{
alert("Akce je Zakázána!! / Verbotene Aktion!!")
}}
document.onmousedown=Disable;
</script><?}?>


 <!--// skrolovani zpet na misto stranky odkud byl vyvolan reload jeste musi byt nastaven v body  onload="doScroll()" onunload="window.name=document.body.scrollTop"//-->
<script type="text/JavaScript">
function doScroll(){
  if (window.name) window.scrollTo(0, window.name);
}
</script>


<STYLE type="text/css">
<!--
#loading {	width:240px;
	background-color: #FFFFFF;
	position: absolute;
	left: 50%;
	top: 50%;
	margin-left: -120px;
	text-align: center;
	border: 3px #A4A4A4 solid;
}
-->
</STYLE>

<SCRIPT style="text/javascript">
document.write('<DIV id="loading"><BR>Počkejte Prosím...<br /><img src="picture/loading.gif" border="0"></DIV>');
window.onload=function(){
	document.getElementById("loading").style.display="none";doScroll();
}
</SCRIPT>

</head>

<body  bgcolor="#DEDCDC" text="BLACK" border=2 onunload="window.name=document.body.scrollTop" style=margin:0>




<?
if (@$loginname<>""){
include ("./"."menu.php");      //menu

if (@$akce<>""){
include ("./".base64_decode(@$akce).".php");}

}?>
<br /><br />
</body>
</html>


