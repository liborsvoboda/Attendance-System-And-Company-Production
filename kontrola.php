<?
//nacteni svatku a vikendu
$obdobi1=explode("-",$obdobi);@$mesic="-".$obdobi1[1]."-";$obdobidate=$obdobi."31";
$sdny1=mysql_query("select datum from svatky where ((datum like '%$mesic%' and typ='Trvalý' and stav='Aktivní') or (datum like '$obdobi%' and typ='Jedineèný' and stav='Aktivní') or (datum like '%$mesic%' and datumdo<='$obdobidate' and typ='Trvalý' and stav='Neaktivní')) order by datum");
@$load=0;$svandweek="";$pracsv=0;while(@$load<mysql_num_rows($sdny1)): @$casti=explode ("-", mysql_result($sdny1,$load,0));
$svandweek.=" and datum<>'".$obdobi."-".@$casti[2]."' ";$cdatum =$obdobi."-".@$casti[2];$cisdne= date("w", strtotime($cdatum));
if (@$cisdne>=1 and @$cisdne<=5) {$pracsv++;}@$load++;endwhile;
$load=1;while( @$load< date("t", strtotime($obdobi1[0]."-".$obdobi1[1]."-01"))+1 ):
if (@$load<10) {$cyklus="0".$load;} else {@$cyklus=$load;}$cdatum =$obdobi."-".$cyklus;$cisdne= date("w", strtotime($cdatum));
if (@$cisdne==0 or @$cisdne==6) {$svandweek.=" and datum<>'".$cdatum."' ";}
@$load++;endwhile;
//kone nacteni svatku a vikendu

@$sum1= mysql_query("select nazev,hodnota from sumhodnoty where nazev='Kontrola (0)' order by id ") or Die(MySQL_Error());
@$tocna=0;while (@$tocna<mysql_num_rows($sum1)):
@$sumarizace[$tocna]=mysql_result($sum1,$tocna,0);@$rozbor = explode(",", @mysql_result($sum1,$tocna,1));$dotazsum=" where ( ";
@$menza=1;while (@$rozbor[@$menza]<>""):
$dotazsum.=" mzd1='".@$rozbor[@$menza]." '";
if (@$rozbor[(@$menza+1)]<>"") {$dotazsum.=" or ";} else {$dotazsum.=" ) ";}
@$menza++;endwhile;
// osetreni prescasu pro kontrolni sestavu
if (@$tocna<>0) {@$sum2 = mysql_query("select id,nazev from ukony $dotazsum group by id order by id") or Die(MySQL_Error());}
if (@$tocna==0) {@$sum2 = mysql_query("select id,nazev from ukony $dotazsum and mzd2<>'003' and mzd3<>'003' group by id order by id") or Die(MySQL_Error());}
$dotazodprac=" where ( ";
@$menza=0;while (@$menza<mysql_num_rows($sum2)):
// osetreni nepocitani vikendu a svatku v sestave kontroly
if (@$tocna<>0) {$dotazodprac.=" id_ukonu='".mysql_result($sum2,$menza,0)."' ";}
if (@$tocna==0) {
	if (mysql_result($sum2,$menza,1)=="nemoc" or mysql_result($sum2,$menza,1)=="pracovní úraz" or mysql_result($sum2,$menza,1)=="OÈR") {$dotazodprac.=" (id_ukonu='".mysql_result($sum2,$menza,0)."' ".$svandweek." ) ";}
	else {$dotazodprac.=" id_ukonu='".mysql_result($sum2,$menza,0)."' ";}
}
if (mysql_result($sum2,$menza+1,0)<>"") {$dotazodprac.=" or ";} else {$dotazodprac.=" ) ";}
@$menza++;endwhile;
@$sum3 = mysql_query("select pracovni_doba from zpracovana_dochazka $dotazodprac and osobni_cislo='".mysql_real_escape_string(mysql_result($zamestnanci,@$cykl,1))."' and obdobi='".mysql_real_escape_string($obdobi)."' order by id") or Die(MySQL_Error());
@$menza=0;@$odprachod="";@$odpracmin="";while (@$menza<mysql_num_rows($sum3)):
@$odprac = explode(":", @mysql_result($sum3,@$menza,0));
$odprachod=$odprachod+@$odprac[0];$odpracmin=$odpracmin+@$odprac[1];
@$menza++;endwhile;
if (@$odpracmin>=60) {$ppr=floor(@$odpracmin/60);@$odprachod=@$odprachod+$ppr;@$odpracmin=@$odpracmin-(@$ppr*60);}
if (@$odpracmin<10) { if (@$odpracmin<>0) {@$odpracmin="0".@$odpracmin;} else {@$odpracmin="00";}}
@$sumarizace1[$tocna]=((@$odprachod*60)+@$odpracmin)/60;
@$tocna++;endwhile;

$prsvatky=((@$pracsv*@$pracdeninmin)/60);?>