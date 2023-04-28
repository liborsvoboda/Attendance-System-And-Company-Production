<?

function securesql($a){
$a=mysql_real_escape_string($a);
return $a;
}

function datecs($a){if (StrPos (" " . $a, "-") and $a){$exploze = explode("-", $a);$a   = $exploze[2].".".$exploze[1].".".$exploze[0];}
return $a;
}

function datedb($a){
if (StrPos (" " . $a, ".") and $a){$exploze = explode(".", $a);$a   = $exploze[2]."-".$exploze[1]."-".$exploze[0];}
return $a;
}

function obdobics($a){
if (StrPos (" " . $a, "-") and $a){$exploze = explode("-", $a);$a   = $exploze[1].".".$exploze[0];}
return $a;
}

function obdobidb($a){
if (StrPos (" " . $a, ".") and $a){$exploze = explode(".", $a);$a   = $exploze[1]."-".$exploze[0];}
return $a;
}

function nactisoubor($a){
include ("./".$a);
}

function deleteobed($a){
mysql_query ("delete from objednavky_obedu where id = '".securesql($a)."' ")or Die(MySQL_Error());

}

function giveobed($a,$b){
mysql_query ("update objednavky_obedu set tr_osobni_cislo='".securesql($a)."' where id = '".securesql($b)."' ")or Die(MySQL_Error());

}

function removegiveobed($a){
mysql_query ("update objednavky_obedu set tr_osobni_cislo='' where id = '".securesql($a)."' ")or Die(MySQL_Error());

}

function launchobed($a){
mysql_query ("update objednavky_obedu set stav='Vydáno',cas='".StrFTime("%H:%M:%S", Time())."' where id = '".securesql($a)."' ")or Die(MySQL_Error());
}

function delaunchobed($a){
mysql_query ("update objednavky_obedu set stav='Èeká',cas='00:00:00' where id = '".securesql($a)."' ")or Die(MySQL_Error());
}

function priloha($a,$b){
mysql_query ("update objednavky_obedu set priloha='".securesql($a)."' where id = '".securesql($b)."' ")or Die(MySQL_Error());

}

function removepriloha($a){
mysql_query ("update objednavky_obedu set priloha='' where id = '".securesql($a)."' ")or Die(MySQL_Error());

}

function sifra($a){
$a=base64_encode($a);
return $a;
}

function desifra($a){
$a=base64_decode($a);
return $a;
}

function strediska($f){
$g=explode(",",mysql_result(mysql_query("select sprava_str from login where jmeno='".securesql($_SESSION["loginname"])."' "),0,0));
$f="";$d=0;while($g[$d]):
$f.="stredisko='".$g[$d]."'";if ($g[($d+1)]){$f.=" or ";}
$d++;endwhile;
return $f;
}

?>

