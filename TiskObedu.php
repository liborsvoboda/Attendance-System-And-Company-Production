<?php

@$dnes=date("Y-m-d");
@$select=base64_decode(@$_GET["select"]);if (@$select=="") {@$select=@$_POST["select"];}

include ("./"."dbconnect.php");

if (@$select=="") {$numberlaunch1= explode ("/", mysql_result(mysql_query("select hodnota from setting where nazev='Ob�dy'"),0,0));$numberlaunch=explode(",", $numberlaunch1[0]);$numberlaunch2=explode(",", $numberlaunch1[1]);$numberlaunch[0]=$numberlaunch[0]-1;$numberlaunch3=explode(",", $numberlaunch1[3]);
$cdne= date("w", strtotime($dnes));if (@$cdne>0) {$nextwoche=(1-$cdne)." day ";if (!StrPos (" " . $nextwoche, "-")) {$nextwoche="+".$nextwoche;}$lastwoche=(1-$cdne+$numberlaunch[0])." day ";} else {$nextwoche="+1 day ";$lastwoche=(1+$numberlaunch[0])." day ";}
?><body  bgcolor="#DEDCDC" text="BLACK" >
<form action="TiskObedu.php" method=post ><center>
<br /><br /><br />Tisknout Ob�dy na T�den: <select size="1" name="select" onchange=submit(this)>
<?if ($_POST["tyden"]<>"") {@$cykl=-1;}else {@$cykl=0;echo"<option></option>";}while(@$cykl<13):
if ($_POST["tyden"]<>"" and @$cykl==-1) {$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".$_POST["select"]." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".$_POST["select"]." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".$_POST["select"]." weeks"));echo"<option value=".$_POST["select"].">".$startwoche." - ".$endwoche." / ".$tyden."T</option>";}
if (@$cykl>=0) {$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".@$cykl." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".@$cykl." weeks"));$tyden= date("W", strtotime( $dnes.$nextwoche." + ".@$cykl." weeks"));
if ($_POST["tyden"]<>@$cykl or $_POST["select"]=="") {echo"<option value='".$cykl."' >".$startwoche." - ".$endwoche." / ".$tyden."T </option>";}}
if (@$startingwoche=="") {@$startingwoche=$startwoche;}@$cykl++;endwhile;?></select></center></body><?}










if (@$select<>""){

$numberlaunch1= explode ("/", mysql_result(mysql_query("select hodnota from setting where nazev='Ob�dy'"),0,0));$numberlaunch=explode(",", $numberlaunch1[0]);$numberlaunch2=explode(",", $numberlaunch1[1]);$numberlaunch[0]=$numberlaunch[0]-1;$numberlaunch3=explode(",", $numberlaunch1[3]);
$cdne= date("w", strtotime($dnes));if (@$cdne>0) {$nextwoche=(1-$cdne)." day ";if (!StrPos (" " . $nextwoche, "-")) {$nextwoche="+".$nextwoche;}$lastwoche=(1-$cdne+$numberlaunch[0])." day ";} else {$nextwoche="+1 day ";$lastwoche=(1+$numberlaunch[0])." day ";}
$startwoche= date("d.m.Y", strtotime( $dnes.$nextwoche." + ".$select." weeks"));$endwoche= date("d.m.Y", strtotime( $dnes." + ".$lastwoche."+".$select." weeks"));
$tyden= date("W", strtotime( $dnes.$nextwoche." + ".$select." weeks"));
@$startingwoche=$startwoche;


/*tvorba n�hledu po��zen�ho z�znamu pomoci n�stroje FPDF*/
define('FPDF_FONTPATH',"fPDF/fnt/");
require("fPDF/fpdf.php");

//$pdf = new FPDF('L','mm','A4');
$pdf = new FPDF('P','mm','A4');

$pdf->Open();
$pdf->AddFont('tahoma','',"tahoma.php");
$pdf->AddFont('tahomabd','',"tahomabd.php");
$pdf->SetMargins(10,5);
$pdf->AddPage();
//$pdf->Image("img/stempl.jpg",149,5,40);
$pdf->SetFont('tahomabd','',10);

$pdf->Write(12,"Tisk Ob�d� na t�den: ".$startwoche." - ".$endwoche." / ".$tyden."T                                                   Tisk Dne: ".date("d.n.Y"));

//$pdf->Ln();
//$pdf->SetLineWidth(0.4);
$pdf->SetFillColor(220,220,220);
//$pdf->Cell(191,0.4,"",'T');
$pdf->Ln();





@$cykl=0;while(@$cykl<($numberlaunch[0]+1) and $select<>""):
$dsvatku= date("-m-d", strtotime( $startingwoche." + ".@$cykl." day"));$dsvatku1= date("Y-m-d", strtotime( $startingwoche." + ".@$cykl." day"));
$svatek= mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trval�' and stav='Aktivn�') or (datum='$dsvatku1' and typ='Jedine�n�') or (datum like '%$dsvatku' and datumdo>='$dsvatku1' and typ='Trval�' and stav='Neaktivn�')) "),0,0);

if ($svatek<>"") {$barva="1";} else {$barva="0";}
if(@$cykl==0) {$name="Pond�l�";}if(@$cykl==1) {$name="�ter�";}if(@$cykl==2) {$name="St�eda";}if(@$cykl==3) {$name="�tvrtek";}if(@$cykl==4) {$name="P�tek";}if(@$cykl==5) {$name="Sobota";}if(@$cykl==6) {$name="Ned�le";}


$datum=date("Y-m-d", strtotime($startingwoche." + ".$cykl." day"));



@$cykl1=0;while(@$cykl1<($numberlaunch[1])):
if (($numberlaunch1[2]=="ANO" and $barva=="1") or $barva=="0") {$pdf->SetFont('tahoma','',10);
if (@$cykl1==0) {$pdf->Cell(25,6,$name,'',0,1,$barva);} else {$pdf->Cell(25,6,"",'');}
$data1=mysql_query("select skupina,obed from seznam_obedu where datum='".mysql_real_escape_string($datum)."' and skupina='".mysql_real_escape_string($numberlaunch2[@$cykl1])."' ");

$pdf->SetFont('tahomabd','',10);$pdf->Cell(15,6,mysql_result($data1,0,0)." - ",'',0,0,$barva);
$pdf->SetFont('tahoma','',10);$pdf->Cell(151,6,mysql_result($data1,0,1),'',0,1,$barva);
$pdf->Ln();}

else {if (@$cykl1==0) {$pdf->Cell(25,6,$name,'',0,1,$barva);} else {$pdf->Cell(25,6,"",'');}$pdf->SetFont('tahoma','',10);$pdf->Cell(166,6,Sv�tek,'',0,1,$barva);
$pdf->Ln();
}

@$cykl1++;endwhile;$pdf->Ln(4);$pdf->Ln(4);

@$cykl++;endwhile;








$pdf->Output();

}



