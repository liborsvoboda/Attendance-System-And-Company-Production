<?

function securesql($a){
$a=mysql_real_escape_string($a);
return $a;
}


function nactisoubor($a){
include ("./".$a);
}


function sifra($a){
$a=base64_encode($a);
return $a;
}

function desifra($a){
$a=base64_decode($a);
return $a;
}



?>