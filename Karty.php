<?
//  menu
@$tlacitko = @$_POST["tlacitko"];
@$menu = @$_POST["menu"];
if ((@$_POST["menuold"] == "Docházka Zamìstnance" or @$_POST["menuold"] == "Docházka Støediska") and @$_POST["menu"] <> @$_POST["menuold"]) {
    unset($_POST["obdobi"]);
}

@$zamestnanecold = @$_POST["zamestnanecold"];
@$zamestnanec = @$_POST["zamestnanec"];
@$stredisko = @$_POST["stredisko"];
@$strediskoold = @$_POST["strediskoold"];
@$obdobi = @$_POST["obdobi"];
@$yobdobi = @$obdobi . "-01";
@$yobdobi1 = @$obdobi . "-31";



// dotaz na stredisko
$acessline = mysql_result(mysql_query("select sprava_str from login where jmeno='$loginname'"), 0, 0);
$acess = explode(",", $acessline);
@$cykl = 0;
$dotazline = "where (osobni_cislo in (select osobni_cislo from zam_strediska where (";
while ($acess[$cykl] <> ""):
    $dotazline.="stredisko='" . $acess[$cykl] . "'";
    if ($acess[$cykl + 1] <> "") {
        $dotazline.=" or ";
    } else {
        $dotazline.=" ) ";
    }
    @$cykl++;
endwhile;
@$dotazline.=" and (datumdo='0000-00-00' or datumdo like '$obdobi%' or datumdo>='$yobdobi')))";

// kontrola existence zaznamu na obdobi nemuzu kdyz je nemocny nebyl by videt
/* if (@$zamestnanec<>"") {$control=mysql_num_rows(mysql_query("select id from dochazka where osobni_cislo='$zamestnanec' and obdobi='$obdobi'"));if ($control=="") {@$obdobi="";}}
  if (@$stredisko<>"") {$control=mysql_num_rows(mysql_query("select id from dochazka where stredisko='$stredisko' and obdobi='$obdobi'"));if ($control=="") {@$obdobi="";}}
 */

if (@$tlacitko == "Uzavøít Kartu") {
    mysql_query("update zpracovana_dochazka set potvrzeno = 'ANO',datumzmeny='$dnes',zmenil='$loginname' where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "'") or Die(MySQL_Error());
    ?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uzavøení Karty <? echo @$zamestnanec . " " . @$obdobi; ?> Probìhlo Úspìšnì</b></center></td></tr></table><?
    @$tlacitko = "";
}

if (@$tlacitko == "Otevøít Kartu") {
    mysql_query("update zpracovana_dochazka set potvrzeno = 'NE',datumzmeny='$dnes',zmenil='$loginname' where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "'") or Die(MySQL_Error());
    ?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Otevøení Karty <? echo @$zamestnanec . " " . @$obdobi; ?> Probìhlo Úspìšnì</b></center></td></tr></table><?
    @$tlacitko = "";
}

if (@$tlacitko == "Uzavøít Všechny Karty") {
    mysql_query("update zpracovana_dochazka set potvrzeno = 'ANO',datumzmeny='$dnes',zmenil='$loginname' where stredisko = '" . mysql_real_escape_string($stredisko) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "'") or Die(MySQL_Error());
    ?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Uzavøení Všech Karet støediska: <? echo @$zamestnanec . " " . @$obdobi; ?> Probìhlo Úspìšnì</b></center></td></tr></table><?
    @$tlacitko = "";
}

if (@$tlacitko == "Otevøít Všechny Karty") {
    mysql_query("update zpracovana_dochazka set potvrzeno = 'NE',datumzmeny='$dnes',zmenil='$loginname' where stredisko = '" . mysql_real_escape_string($stredisko) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "'") or Die(MySQL_Error());
    ?><table width=100%><tr><td width=100% bgcolor="#1CBDFB"><center><b>Otevøení Všech Karet Støediska: <? echo @$stredisko . " " . @$obdobi; ?> Probìhlo Úspìšnì</b></center></td></tr></table><?
    @$tlacitko = "";
}
?>


<style type="text/css">
    tr.menuon  {background-color:#F1BEED;}
    tr.menuoff {background-color:#EDB745;}
</style>


<form action="hlavicka.php?akce=<? echo base64_encode('Karty'); ?>" method=post>
    <input name="menuold" type="hidden" value="<? echo@$menu; ?>">

    <h2><p align="center">Správa Docházky Zamìstnancù:
            <? if (StrPos(" " . $_SESSION["prava"], "O") or StrPos(" " . $_SESSION["prava"], "o")) { ?>
                <select name=menu size="1" onchange=submit(this)>
                    <option><?
            if (@$menu <> "") {
                echo@$menu;
            }
                ?></option>  <? } ?>

                <? if (StrPos(" " . $_SESSION["prava"], "O")) { ?>
                    <? if (@$menu <> "Editace Docházky Zamìstnance") { ?><option>Editace Docházky Zamìstnance</option><? } ?>
                    <? if (@$menu <> "Editace Docházky Støediska") { ?><option>Editace Docházky Støediska</option><? } ?>

                <? } ?>


                <? if (StrPos(" " . $_SESSION["prava"], "O") or StrPos(" " . $_SESSION["prava"], "o")) { ?>
                    <? if (@$menu <> "Docházka Zamìstnance") { ?><option>Docházka Zamìstnance</option><? } ?>
                    <? if (@$menu <> "Docházka Støediska") { ?><option>Docházka Støediska</option><? } ?>
                <? } ?>

            </select> </p></h2><BR>

    <? if (!StrPos(" " . $_SESSION["prava"], "O") and (!StrPos(" " . $_SESSION["prava"], "o"))) { ?>Nemáte Pøístupová Práva<? } ?>

    <center><table  bgcolor="#EDB745" border=2>




            <? if (StrPos(" " . $_SESSION["prava"], "O")) { ?>



                <? if (@$menu == "Editace Docházky Zamìstnance") { ?>
                    <tr bgcolor="#B4ADFC" align=center><td colspan=4><center><b> <?
            echo@$menu;
            if (mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and potvrzeno<>'ANO' ")) == "" and @$zamestnanec <> "" and @$obdobi <> "" and mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' ")) <> "") {
                @$typ = "Read";
                        ?> <img src="picture/ready.png" border="0"><? } ?></b></center></td>

                    <td><select name=zamestnanec size="1" onchange=submit(this) style=size:100%>
                            <?
                            if (@$zamestnanec <> "") {
                                @$data1 = mysql_query("select * from zamestnanci where osobni_cislo='$zamestnanec'") or Die(MySQL_Error());
                                $jmeno = mysql_result($data1, 0, 4) . " " . mysql_result($data1, 0, 3);
                                @$datumdo = mysql_result($data1, 0, 12);
                                if ($datumdo == "0000-00-00") {
                                    $datumdo = $dnes;
                                }
                                ?><option value="<? echo(mysql_result($data1, 0, 1)); ?>"><? echo(mysql_result($data1, 0, 4) . " " . mysql_result($data1, 0, 3) . " / " . mysql_result($data1, 0, 1) . " | " . mysql_result($data1, 0, 17)); ?></option><? } else { ?><option></option><?
                }
                @$data1 = mysql_query("select * from zamestnanci $dotazline and jen_pruchod='NE' order by prijmeni,jmeno,osobni_cislo,id ASC") or Die(MySQL_Error());
                @$pocet = mysql_num_rows($data1);
                @$cykl = 0;
                while (@$cykl < @$pocet):
                    if (mysql_result($data1, @$cykl, 1) <> @$zamestnanec) {
                                    ?><option value="<? echo(mysql_result($data1, @$cykl, 1)); ?>"><? echo(mysql_result($data1, @$cykl, 4) . " " . mysql_result($data1, @$cykl, 3) . " / " . mysql_result($data1, @$cykl, 1)); ?></option><?
                }
                @$cykl++;
            endwhile;
                            ?></select></td>

                    <td colspan=2 align=right>Období:<select name=obdobi size="1" onchange=submit(this) style=size:100%>
                            <? if (@$obdobi <> "") { ?><option value="<? echo @$obdobi; ?>"><? $obdobi1 = explode("-", $obdobi);
                    echo $obdobi1[1] . "." . $obdobi1[0]; ?></option><? } else { ?><option></option><?
                    }
                    include ("./" . "dbconnect.php");
                    if (StrPos(" " . $_SESSION["prava"], "E")) {
                        @$data1 = mysql_query("select obdobi from dochazka where datum<='" . mysql_real_escape_string($datumdo) . "' group by obdobi order by obdobi DESC") or Die(MySQL_Error());
                    } else {
                        @$data1 = mysql_query("select obdobi from dochazka where obdobi not in (select obdobi from blokovani) and datum<='" . mysql_real_escape_string($datumdo) . "'  group by obdobi order by obdobi DESC") or Die(MySQL_Error());
                    }

                    @$pocet = mysql_num_rows($data1);
                    @$cykl = 0;
                    while (@$cykl < @$pocet):
                        if (mysql_result($data1, @$cykl, 0) <> @$obdobi) {
                                    ?><option value="<? echo @mysql_result($data1, @$cykl, 0); ?>"><? $obdobi2 = explode("-", mysql_result($data1, @$cykl, 0));
                        echo $obdobi2[1] . "." . $obdobi2[0]; ?></option><?
                    }
                    @$cykl++;
                endwhile;
                            ?></select><? if (@$zamestnanec <> "" and @$obdobi <> "") { ?><input type="button" value="STATUS" onclick="window.open('SysInf.php?oscislo=<? echo base64_encode(@$zamestnanec); ?>&typ=<? echo base64_encode('read'); ?>','','toolbar=0, width=800, height=600, directories=0, location=0, status=1, menubar=0, resizable=0, scrollbars=0, titlebar=0')"><input type="button" value="Tisk Karty" onclick="window.open('TiskKarty.php?zamestnanec=<? echo base64_encode(@$zamestnanec); ?>&obdobi=<? echo base64_encode(@$obdobi); ?>&jmeno=<? echo @$jmeno; ?>');"><input type="submit" value="Aktualizace"><? } ?></td></tr>
                    <? if (@$obdobi <> "" and @$zamestnanec <> "") { ?><tr><td colspan=7><? include ("./" . "infocard.php"); ?></td></tr><? } ?>
                    <tr bgcolor="#C0FFC0" align=center><td> Týden </td><td> Datum </td><td><center>Pøíchod</center></td><td><center>Odchod</center></td><td>Celkový Èas / Definováno / Zbývá Def.</td><td><b>Definováno</b></td><td><b>Poznámka</b></td></tr>

                    <?
                    if (@$zamestnanec <> "" and @$obdobi <> "") {
// cely mesic uzivatele v poli a cisla operaci
                        $prichod = mysql_result(mysql_query("select cislo from klavesnice where text='Pøíchod'"), 0, 0);
                        $odchod1 = mysql_query("select cislo,barva,text from klavesnice where text like 'Odchod%'");
                        @$cykl = 0;
                        while (@$cykl < mysql_num_rows($odchod1)):$odchod[@$cykl] = mysql_result($odchod1, $cykl, 0);
                            $barvy[@$cykl] = mysql_result($odchod1, $cykl, 1);
                            $plky[@$cykl] = mysql_result($odchod1, $cykl, 2);
                            @$cykl++;
                        endwhile;
                        @$vysledek = mysql_query("select * from dochazka where osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by cas,datum,id ") or Die(MySQL_Error());

                        $cykl = 1;
                        while (@$cykl < date("t", strtotime($obdobi1[0] . "-" . $obdobi1[1] . "-01")) + 1):


                            if (@$cykl < 10) {
                                $cyklus = "0" . $cykl;
                            } else {
                                @$cyklus = $cykl;
                            } $datum = $obdobi . "-" . $cyklus;
                            $in = "";
                            $out = "";
                            $wout = "";
                            $cdne = date("w", strtotime($datum));

                            $dsvatku = "-" . $obdobi1[1] . "-" . $cyklus;
                            $svatek = mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$datum' and typ='Jedineèný') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trvalý' and stav='Neaktivní')) "), 0, 0);
                            ?>
                            <tr <? if (@$cdne > 0 and @$cdne < 6 and $svatek == "") { ?>onmouseover="className='menuon';" onmouseout="className='menuoff';"<? } else {
                    if (@$svatek == "") { ?>bgcolor=#FDCC5B<? } else { ?>bgcolor=#F7FBA4<? }
                                                                } ?> style=cursor:pointer; <? if (@$typ <> "Read" or (StrPos(" " . $_SESSION["prava"], "E") and @$typ == "Read" and mysql_num_rows(mysql_query("select export from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and export='NE'")) <> "")) { ?>onclick="window.open('Edit.php?datum=<? echo base64_encode($datum); ?>&oscislo=<? echo base64_encode(@$zamestnanec); ?>','','toolbar=0, width=900, height=600, directories=0, location=0, status=1, menubar=0, resizable=1, scrollbars=0, titlebar=0')"<? } ?>>

                                <? $tyden = date("W", strtotime($datum));
                                if (@$cykl == 1 or $cdne == 1) { ?><td align=center valign=middle rowspan=<?
                    if (@$cykl == 1) {
                        if (@$cdne <> 0) {
                            echo (8 - @$cdne);
                        } else {
                            echo "1";
                        }
                    } else {
                        echo"7";
                    }
                                    ?> ><? echo@$tyden; ?></td><? } ?>

                                <td><? echo $cykl . "." . $obdobi1[1] . "." . $obdobi1[0]; ?></td>


                                <td valign=bottom align=center><?
                    $vypis = 0;
                    $narust = 0;
                    while ($vypis < mysql_num_rows($vysledek)):
                        if (mysql_result($vysledek, @$vypis, 4) == $prichod and mysql_result($vysledek, @$vypis, 2) == $datum) {
                            $in[$narust] = substr(mysql_result($vysledek, @$vypis, 3), 0, 5);
                            echo $in[$narust] . "<br />";
                            $narust++;
                        }
                        @$vypis++;
                    endwhile;
                                ?></td>


                                <td valign=bottom align=center><?
                    $vypis = 0;
                    $narust = 0;
                    while ($vypis < mysql_num_rows($vysledek)):
                        @$write = 0;
                        $odchody = "NO";
                        while ($odchod[@$write] <> ""): if (mysql_result($vysledek, @$vypis, 4) == $odchod[@$write]) {
                                $plk = $plky[@$write];
                                $barva = $barvy[@$write];
                                $odchody = "YES";
                            }@$write++;
                        endwhile;
                        if ($odchody == "YES" and mysql_result($vysledek, @$vypis, 2) == $datum) {
                            $out[$narust] = substr(mysql_result($vysledek, @$vypis, 3), 0, 5);
                            echo "<span style=background-color:" . $barva . " title='" . $plk . "'>" . $out[$narust] . "</span><br />";
                            @$narust++;
                        }
                        @$vypis++;
                    endwhile;
                                ?></td>



                                <td valign=bottom align=center><table width=100%><tr><?
                    $vypis = 0;
                    @$celkhod = "";
                    @$celkmin = "";
                    while ($in[$vypis] <> "" and $out[$vypis] <> ""):
                        @$castipr = explode(":", $in[$vypis]);
                        @$prhod = @$castipr[0];
                        @$prmin = @$castipr[1];
                        @$castiod = explode(":", $out[$vypis]);
                        @$odhod = @$castiod[0];
                        @$odmin = @$castiod[1];

                        if (@$odmin < @$prmin) {
                            @$vysmin = 60 - (@$prmin - @$odmin);
                            @$vyshod = @$odhod - @$prhod - 1;
                        }
                        if (@$odmin >= @$prmin) {
                            @$vysmin = @$odmin - @$prmin;
                            @$vyshod = @$odhod - @$prhod;
                        }
                        if (@$vysmin < 10) {
                            @$vysmin = "0" . @$vysmin;
                        }
                        @$celkhod = @$celkhod + @$vyshod;
                        @$celkmin = @$celkmin + @$vysmin;
                        @$vypis++;
                    endwhile;
                    while (@$celkmin >= 60):@$celkhod++;
                        @$celkmin = @$celkmin - 60;
                    endwhile;
                    echo " <td align=center width=33%";
                    if (@$celkhod <> "") {
                        echo" style=background-color:#F05139 >";
                    }if (@$celkhod <> "") {
                        echo @$celkhod . ":";
                    }if ((@$celkmin < 10 and @$celkmin <> "") or (@$celkhod <> "" and @$celkmin < 10)) {
                        echo"0";
                    }echo @$celkmin . " </td>";


                    @$vyshod = "";
                    @$vysmin = "";
                    @$celkhod = "";
                    @$celkmin = "";
                    $vypis = 0;
                    while ($in[$vypis] <> "" and $out[$vypis] <> ""):
                        @$castipr = explode(":", $in[$vypis]);
                        @$prhod = @$castipr[0];
                        @$prmin = @$castipr[1];
                        @$castiod = explode(":", $out[$vypis]);
                        @$odhod = @$castiod[0];
                        @$odmin = @$castiod[1];

                        if (@$odmin < @$prmin) {
                            @$vysmin = 60 - (@$prmin - @$odmin);
                            @$vyshod = @$odhod - @$prhod - 1;
                        }
                        if (@$odmin >= @$prmin) {
                            @$vysmin = @$odmin - @$prmin;
                            @$vyshod = @$odhod - @$prhod;
                        }
                        if (@$vysmin < 10) {
                            @$vysmin = "0" . @$vysmin;
                        }

                        @$celkhod = @$celkhod + @$vyshod;
                        @$celkmin = @$celkmin + @$vysmin;
                        @$vypis++;
                    endwhile;
                    while (@$celkmin >= 60):@$celkhod++;
                        @$celkmin = @$celkmin - 60;
                    endwhile;

// pøestávky
                    if (@$celkhod <> "") {
                        @$prestavek = floor(@$celkhod / (@mysql_result(mysql_query("select * from setting where nazev='Pøestávka' order by id"), 0, 2)));
                        if (@$prestavek / 2 == ceil(@$prestavek / 2)) {
                            @$celkhod = @$celkhod - (0.5 * @$prestavek);
                        } else {
                            $ppr = floor(@$prestavek / 2);
                            if (@$celkmin >= 30) {
                                @$celkmin = @$celkmin - 30;
                                @$celkhod = @$celkhod - (0.5 * @$ppr);
                            } else {
                                @$celkmin = @$celkmin + 30;
                                @$celkhod = @$celkhod - (0.5 * @$ppr) - 1;
                            }
                        }if (@$celkmin < 10) {
                            $celkmin = "0" . $celkmin;
                        }
                    }

//již definováno
                    @$nastaveno1 = mysql_query("select * from zpracovana_dochazka where osobni_cislo = '$zamestnanec' and datum='$datum' order by id");
                    $nhod = 0;
                    $nmin = 0;
                    $dhod = 0;
                    $dmin = 0;
                    @$cykla = 0;
                    $definovano = "";
                    while (@$cykla < @mysql_num_rows($nastaveno1)):
                        @$casti = explode(":", @mysql_result($nastaveno1, @$cykla, 2));
                        @$nhod = @$nhod + @$casti[0];
                        @$nmin = @$nmin + @$casti[1];
                        $dhod = @$dhod + @$casti[0];
                        @$dmin = @$dmin + @$casti[1];
                        if (@$definovano == "") {
                            $definovano = @mysql_result($nastaveno1, @$cykla, 15) . " " . @mysql_result($nastaveno1, @$cykla, 2);
                        } else {
                            $definovano = $definovano . "," . @mysql_result($nastaveno1, @$cykla, 15) . " " . @mysql_result($nastaveno1, @$cykla, 2);
                        }
                        @$cykla++;
                    endwhile;
                    if (@$nmin >= 60) {
                        $ppr = floor(@$nmin / 60);
                        @$nhod = @$nhod + $ppr;
                        @$nmin = @$nmin - (@$ppr * 60);
                    }
                    if (@$dmin >= 60) {
                        $ppr = floor(@$dmin / 60);
                        @$dhod = @$dhod + $ppr;
                        @$dmin = @$dmin - (@$ppr * 60);
                    }
                    @$zmin = @$celkmin - @$nmin;
                    if (@$zmin < 0) {
                        @$nhod = @$nhod + 1;
                        @$zmin = 60 + @$celkmin - @$nmin;
                    }
                    if (@$zmin < 10) {
                        @$zmin = "0" . @$zmin;
                    }@$zbyva = (@$celkhod - @$nhod) . ":" . @$zmin;
                    if (@$zbyva <> "0:00" and StrPos(" " . @$zbyva, "-") == false) {
                        @$zbyva = @$zbyva;
                    } else {
                        @$zbyva = "";
                    }
//  konec definováno


                    echo "<td align=center width=33%";
                    if (@$dhod <> "") {
                        echo" style=background-color:#6BF968 > ";
                    }if (@$dhod <> "") {
                        if (@$dmin < 10) {
                            @$dmin = "0" . @$dmin;
                        }echo @$dhod . ":" . @$dmin;
                    }
                    if (((@$dhod * 60) + @$dmin) >= @$pracdeninmin and $cdne <> 0 and @$cdne <> 6) {
                                    ?> <img src="picture/ready.png" border="0"><?
                        }
                        echo"</td><td align=center width=33%";
                        if (@$zbyva <> "") {
                            echo" style=background-color:#FEEE81 > ";
                        }echo @$zbyva . " </td>";
                                ?></tr></table></td>

                                <td><? echo@$definovano; ?></td><td><? echo mysql_result(mysql_query("select poznamka from poznamky where osobni_cislo='$zamestnanec' and datum='$datum'"), 0, 0); ?></td></tr>

                            <? $cykl++;
                        endwhile; ?></table><table  bgcolor="#EDB745" border=2><tr><td><input type="submit" value="Aktualizace"></td><td colspan=2></td>
                            <td align=center><?
            if (@$typ <> "Read" or (StrPos(" " . $_SESSION["prava"], "E") and @$typ == "Read" and mysql_num_rows(mysql_query("select export from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and export='NE'")) <> "")) {
                if (mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and potvrzeno<>'ANO' ")) == "" and @$zamestnanec <> "" and @$obdobi <> "" and mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "'")) <> "") {
                                ?><input type="submit" name=tlacitko value="Otevøít Kartu"><? }
                if (mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and potvrzeno<>'ANO' ")) <> "" and @$zamestnanec <> "" and @$obdobi <> "" and mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "'")) <> "") { ?><input type="submit" name=tlacitko value="Uzavøít Kartu"><? }
            } ?>
                            </td>
                            <td align=right colspan=2><input type="button" value="STATUS" onclick="window.open('SysInf.php?oscislo=<? echo base64_encode(@$zamestnanec); ?>&typ=<? echo base64_encode('read'); ?>','','toolbar=0, width=800, height=600, directories=0, location=0, status=1, menubar=0, resizable=0, scrollbars=0, titlebar=0')"></td></tr><? }
            } ?>











                <? if (@$menu == "Editace Docházky Støediska") { ?>
                    <tr bgcolor="#B4ADFC" align=center><td colspan=5><center><b> <? echo@$menu; ?> </b></center></td>

                    <td>Støedisko:<select name=stredisko size="1" onchange=submit(this) style=size:100%>
                            <? if (@$stredisko <> "") { ?><option value="<? echo $stredisko; ?>"><? echo $stredisko; ?></option><? } else { ?><option></option><?
                }
                @$data1 = mysql_query("select * from zamestnanci $dotazline group by stredisko order by stredisko,osobni_cislo,id") or Die(MySQL_Error());
                @$cykl = 0;
                while (@$cykl < mysql_num_rows($data1)):
                    if (mysql_result($data1, @$cykl, 17) <> @$stredisko) {
                                    ?><option value="<? echo(mysql_result($data1, @$cykl, 17)); ?>"><? echo mysql_result($data1, @$cykl, 17); ?></option><?
                }
                @$cykl++;
            endwhile;
                            ?></select></td>

                    <td align=right>Období:<select name=obdobi size="1" onchange=submit(this) style=size:100%>
                            <? if (@$obdobi <> "") { ?><option value="<? echo @$obdobi; ?>"><? echo obdobics($obdobi); ?></option><? } else { ?><option></option><?
                }
//@$data1 = mysql_query("select obdobi from dochazka where stredisko='$stredisko' group by obdobi order by obdobi DESC") or Die(MySQL_Error());
                @$data1 = mysql_result(mysql_query("select datumzacatku from stredisko where kod='$stredisko'"), 0, 0);
                @$cykl = 0;
                while (date("Y-m", strtotime($data1 . " + " . $cykl . " months")) < date("Y-m", strtotime($dnes . " + 1 months"))):
                    if (StrPos(" " . $_SESSION["prava"], "E") or (!StrPos(" " . $_SESSION["prava"], "E") and mysql_result(mysql_query("select obdobi from blokovani where obdobi='" . date("Y-m", strtotime($dnes . " - " . $cykl . " months")) . "'"), 0, 0) == "")) {
                        if (date("Y-m", strtotime($data1 . " + " . $cykl . " months")) <> @$obdobi) {
                                        ?><option value="<? echo date('Y-m', strtotime($dnes . ' - ' . $cykl . ' months')); ?>"><? echo obdobics(date("Y-m", strtotime($dnes . " - " . $cykl . " months"))); ?></option><?
                }
            }
            @$cykl++;
        endwhile;
                            ?></select>




                        <? if (@$stredisko <> "" and @$obdobi <> "") { ?> <input type="button" value="Tisk Karet" onclick="window.open('TiskKaret.php?stredisko=<? echo base64_encode(@$stredisko); ?>&obdobi=<? echo base64_encode(@$obdobi); ?>');">
                            <button onclick="zobrazit()" >Zobrazit / Skrýt</button><? } ?></td></tr>
                    </form>

                    <?
                    if (@$stredisko <> "" and @$obdobi <> "") {
// cely mesic uzivatele v poli a cisla operaci
                        $prichod = mysql_result(mysql_query("select cislo from klavesnice where text='Pøíchod'"), 0, 0);
                        $odchod1 = mysql_query("select cislo,barva,text from klavesnice where text like 'Odchod%'");
                        @$cykl = 0;
                        while (@$cykl < mysql_num_rows($odchod1)):$odchod[@$cykl] = mysql_result($odchod1, $cykl, 0);
                            $barvy[@$cykl] = mysql_result($odchod1, $cykl, 1);
                            $plky[@$cykl] = mysql_result($odchod1, $cykl, 2);
                            @$cykl++;
                        endwhile;

                        @$osoby = mysql_query("select osobni_cislo,prijmeni,jmeno,titul from zamestnanci where osobni_cislo in (select osobni_cislo from zam_strediska where stredisko='$stredisko' and datumod<='$yobdobi1' and (datumdo='0000-00-00' or datumdo like '$obdobi%' or datumdo>='$yobdobi')) and jen_pruchod='NE' group by osobni_cislo order by prijmeni,jmeno,id ") or Die(MySQL_Error());
                        ?>

                        <script type="text/javascript">
                            function showhide(id) {
                                var tr = document.getElementById(id);
                                if (tr==null) { return; }
                                var bExpand = tr.style.display == '';
                                tr.style.display = (bExpand ? 'none' : '');
                            }
                            function zobrazit(){
            <?
            $vsichni = 0;
            while (@$vsichni < mysql_num_rows(@$osoby)):
                echo"showhide('zaznam" . $vsichni . "');";
                @$vsichni++;
            endwhile;
            ?>
                }
                        </script>

                        <?
                        @$osoba = 0;
                        while (@$osoba < mysql_num_rows(@$osoby)):
                            $jmeno = mysql_result($osoby, @$osoba, 1) . " " . mysql_result($osoby, @$osoba, 2);
                            @$typ = "";
                            ?>
                            <tr bgcolor="#C0FFC0" align=center><td colspan=6><?
                $zamestnanec = mysql_result(@$osoby, @$osoba, 0);
                echo mysql_result(@$osoby, @$osoba, 0) . " / " . mysql_result(@$osoby, @$osoba, 3) . " " . mysql_result(@$osoby, @$osoba, 2) . " " . mysql_result(@$osoby, @$osoba, 1);
                if (mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and potvrzeno<>'ANO' ")) == "" and @$zamestnanec <> "" and @$obdobi <> "" and mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "'")) <> "") {
                    @$typ = "Read";
                                ?> <img src="picture/ready.png" border="0"><? } ?>
                                </td><td align=right><form action="hlavicka.php?akce=<? echo base64_encode('Karty'); ?>" method=post><input name="menu" type="hidden" value="<? echo@$menu; ?>"><input name="stredisko" type="hidden" value="<? echo@$stredisko; ?>"><input name="obdobi" type="hidden" value="<? echo@$obdobi; ?>"><input name="zamestnanec" type="hidden" value="<? echo@$zamestnanec; ?>">
                                        <?
                                        if (@$typ <> "Read" or (StrPos(" " . $_SESSION["prava"], "E") and @$typ == "Read" and mysql_num_rows(mysql_query("select export from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and export='NE'")) <> "")) {
                                            if (mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and potvrzeno<>'ANO' ")) == "" and @$zamestnanec <> "" and @$obdobi <> "" and mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "'")) <> "") {
                                                ?><input type="submit" name=tlacitko value="Otevøít Kartu"><? }
                    if (mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and potvrzeno<>'ANO' ")) <> "" and @$zamestnanec <> "" and @$obdobi <> "" and mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "'")) <> "") { ?><input type="submit" name=tlacitko value="Uzavøít Kartu"><? }
                } ?>

                                        <input type="button" value="STATUS" onclick="window.open('SysInf.php?oscislo=<? echo base64_encode(@$zamestnanec); ?>&typ=<? echo base64_encode('read'); ?>','','toolbar=0, width=800, height=600, directories=0, location=0, status=1, menubar=0, resizable=0, scrollbars=0, titlebar=0')"><input type="button" value="Tisk Karty" onclick="window.open('TiskKarty.php?zamestnanec=<? echo base64_encode(@$zamestnanec); ?>&obdobi=<? echo base64_encode(@$obdobi); ?>&jmeno=<? echo @$jmeno; ?>');"><input type="submit" value="Aktualizace"></td></tr>
                                        <? @$vysledek = mysql_query("select * from dochazka where osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by osobni_cislo,cas,datum,id") or Die(MySQL_Error());
                                        if (@$obdobi <> "" and @$zamestnanec <> "") { ?><tr><td colspan=7><? include ("./" . "infocard.php"); ?></td></tr><? } ?>

                                        <tbody id="zaznam<? echo$osoba; ?>">
                                            <tr bgcolor="#C0FFC0" align=center ><td>Týden</td><td> Datum </td><td><center>Pøíchod</center></td><td><center>Odchod</center></td><td>Celkový Èas / Definováno / Zbývá Def.</td><td><b>Definováno</b></td><td><b>Poznámka</b></td></tr>
                            <?
                            $cykl = 1;
                            while (@$cykl < date("t", strtotime($obdobi1[0] . "-" . $obdobi1[1] . "-01")) + 1):

                                if (@$cykl < 10) {
                                    $cyklus = "0" . $cykl;
                                } else {
                                    @$cyklus = $cykl;
                                } $datum = $obdobi . "-" . $cyklus;
                                $in = "";
                                $out = "";
                                $wout = "";
                                $cdne = date("w", strtotime($datum));
                                $dsvatku = "-" . $obdobi1[1] . "-" . $cyklus;
                                $svatek = mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$datum' and typ='Jedineèný') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trvalý' and stav='Neaktivní')) "), 0, 0);
                                ?>
                                <tr <? if (@$cdne > 0 and @$cdne < 6 and $svatek == "") { ?>onmouseover="className='menuon';" onmouseout="className='menuoff';"<? } else {
                        if (@$svatek == "") { ?>bgcolor=#FDCC5B<? } else { ?>bgcolor=#F7FBA4<? }
                                                                } ?> style=cursor:pointer <? if (@$typ <> "Read" or (StrPos(" " . $_SESSION["prava"], "E") and @$typ == "Read" and mysql_num_rows(mysql_query("select export from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and export='NE'")) <> "")) { ?>onclick="window.open('Edit.php?datum=<? echo base64_encode($datum); ?>&oscislo=<? echo base64_encode(@$zamestnanec); ?>','','toolbar=0, width=900, height=600, directories=0, location=0, status=1, menubar=0, resizable=1, scrollbars=0, titlebar=0')"<? } ?> >

                                    <? $tyden = date("W", strtotime($datum));
                                    if (@$cykl == 1 or $cdne == 1) { ?>
                                        <td align=center valign=middle rowspan="<?
                        if (@$cykl == 1) {
                            if (@$cdne <> 0) {
                                echo (8 - @$cdne);
                            } else {
                                echo "1";
                            }
                        } else {
                            if (((date("t", strtotime($obdobi1[0] . "-" . $obdobi1[1] . "-01")) + 1) - @$cykl) > 7) {
                                echo"7";
                            } else {
                                echo((date("t", strtotime($obdobi1[0] . "-" . $obdobi1[1] . "-01")) + 1) - @$cykl);
                            }
                        }
                                        ?>" ><? echo@$tyden; ?></td><? } ?>
                                    <td><? echo $cykl . "." . $obdobi1[1] . "." . $obdobi1[0]; ?></td>


                                    <td valign=bottom align=center><?
                    $vypis = 0;
                    $narust = 0;
                    while ($vypis < mysql_num_rows($vysledek)):
                        if (mysql_result($vysledek, @$vypis, 4) == $prichod and mysql_result($vysledek, @$vypis, 2) == $datum and mysql_result($vysledek, @$vypis, 6) == mysql_result(@$osoby, @$osoba, 0)) {
                            $in[$narust] = substr(mysql_result($vysledek, @$vypis, 3), 0, 5);
                            echo $in[$narust] . "<br />";
                            $narust++;
                        }
                        @$vypis++;
                    endwhile;
                                    ?></td>


                                    <td valign=bottom align=center><?
                    $vypis = 0;
                    $narust = 0;
                    while ($vypis < mysql_num_rows($vysledek)):
                        @$write = 0;
                        $odchody = "NO";
                        while ($odchod[@$write] <> ""): if (mysql_result($vysledek, @$vypis, 4) == $odchod[@$write]) {
                                $plk = $plky[@$write];
                                $barva = $barvy[@$write];
                                $odchody = "YES";
                            }@$write++;
                        endwhile;
                        if ($odchody == "YES" and mysql_result($vysledek, @$vypis, 2) == $datum and mysql_result($vysledek, @$vypis, 6) == mysql_result(@$osoby, @$osoba, 0)) {
                            $out[$narust] = substr(mysql_result($vysledek, @$vypis, 3), 0, 5);
                            echo "<span style=background-color:" . $barva . " title='" . $plk . "'>" . $out[$narust] . "</span><br />";
                            @$narust++;
                        }
                        @$vypis++;
                    endwhile;
                                    ?></td>



                                    <td valign=bottom align=center><table width=100%><tr><?
                    $vypis = 0;
                    @$celkhod = "";
                    @$celkmin = "";
                    while ($in[$vypis] <> "" and $out[$vypis] <> ""):
                        @$castipr = explode(":", $in[$vypis]);
                        @$prhod = @$castipr[0];
                        @$prmin = @$castipr[1];
                        @$castiod = explode(":", $out[$vypis]);
                        @$odhod = @$castiod[0];
                        @$odmin = @$castiod[1];

                        if (@$odmin < @$prmin) {
                            @$vysmin = 60 - (@$prmin - @$odmin);
                            @$vyshod = @$odhod - @$prhod - 1;
                        }
                        if (@$odmin >= @$prmin) {
                            @$vysmin = @$odmin - @$prmin;
                            @$vyshod = @$odhod - @$prhod;
                        }
                        if (@$vysmin < 10) {
                            @$vysmin = "0" . @$vysmin;
                        }
                        @$celkhod = @$celkhod + @$vyshod;
                        @$celkmin = @$celkmin + @$vysmin;
                        @$vypis++;
                    endwhile;
                    while (@$celkmin >= 60):@$celkhod++;
                        @$celkmin = @$celkmin - 60;
                    endwhile;
                    echo " <td align=center width=33%";
                    if (@$celkhod <> "") {
                        echo" style=background-color:#F05139 >";
                    }if (@$celkhod <> "") {
                        echo @$celkhod . ":";
                    }if ((@$celkmin < 10 and @$celkmin <> "") or (@$celkhod <> "" and @$celkmin < 10)) {
                        echo"0";
                    }echo @$celkmin . " </td>";


                    @$vyshod = "";
                    @$vysmin = "";
                    @$celkhod = "";
                    @$celkmin = "";
                    $vypis = 0;
                    while ($in[$vypis] <> "" and $out[$vypis] <> ""):
                        @$castipr = explode(":", $in[$vypis]);
                        @$prhod = @$castipr[0];
                        @$prmin = @$castipr[1];
                        @$castiod = explode(":", $out[$vypis]);
                        @$odhod = @$castiod[0];
                        @$odmin = @$castiod[1];

                        if (@$odmin < @$prmin) {
                            @$vysmin = 60 - (@$prmin - @$odmin);
                            @$vyshod = @$odhod - @$prhod - 1;
                        }
                        if (@$odmin >= @$prmin) {
                            @$vysmin = @$odmin - @$prmin;
                            @$vyshod = @$odhod - @$prhod;
                        }
                        if (@$vysmin < 10) {
                            @$vysmin = "0" . @$vysmin;
                        }

                        @$celkhod = @$celkhod + @$vyshod;
                        @$celkmin = @$celkmin + @$vysmin;
                        @$vypis++;
                    endwhile;
                    while (@$celkmin >= 60):@$celkhod++;
                        @$celkmin = @$celkmin - 60;
                    endwhile;

// pøestávky
                    if (@$celkhod <> "") {
                        @$prestavek = floor(@$celkhod / (@mysql_result(mysql_query("select * from setting where nazev='Pøestávka' order by id"), 0, 2)));
                        if (@$prestavek / 2 == ceil(@$prestavek / 2)) {
                            @$celkhod = @$celkhod - (0.5 * @$prestavek);
                        } else {
                            $ppr = floor(@$prestavek / 2);
                            if (@$celkmin >= 30) {
                                @$celkmin = @$celkmin - 30;
                                @$celkhod = @$celkhod - (0.5 * @$ppr);
                            } else {
                                @$celkmin = @$celkmin + 30;
                                @$celkhod = @$celkhod - (0.5 * @$ppr) - 1;
                            }
                        }if (@$celkmin < 10) {
                            $celkmin = "0" . $celkmin;
                        }
                    }

//již definováno
                    @$nastaveno1 = mysql_query("select * from zpracovana_dochazka where osobni_cislo = '$zamestnanec' and datum='$datum' order by id");
                    $nhod = 0;
                    $nmin = 0;
                    $dhod = 0;
                    $dmin = 0;
                    $definovano = "";
                    @$cykla = 0;
                    while (@$cykla < @mysql_num_rows($nastaveno1)):
                        @$casti = explode(":", @mysql_result($nastaveno1, @$cykla, 2));
                        @$nhod = @$nhod + @$casti[0];
                        @$nmin = @$nmin + @$casti[1];
                        $dhod = @$dhod + @$casti[0];
                        @$dmin = @$dmin + @$casti[1];
                        if (@$definovano == "") {
                            $definovano = @mysql_result($nastaveno1, @$cykla, 15) . " " . @mysql_result($nastaveno1, @$cykla, 2);
                        } else {
                            $definovano = $definovano . "," . @mysql_result($nastaveno1, @$cykla, 15) . " " . @mysql_result($nastaveno1, @$cykla, 2);
                        }
                        @$cykla++;
                    endwhile;
                    if (@$nmin >= 60) {
                        $ppr = floor(@$nmin / 60);
                        @$nhod = @$nhod + $ppr;
                        @$nmin = @$nmin - (@$ppr * 60);
                    }
                    if (@$dmin >= 60) {
                        $ppr = floor(@$dmin / 60);
                        @$dhod = @$dhod + $ppr;
                        @$dmin = @$dmin - (@$ppr * 60);
                    }
                    @$zmin = @$celkmin - @$nmin;
                    if (@$zmin < 0) {
                        @$nhod = @$nhod + 1;
                        @$zmin = 60 + @$celkmin - @$nmin;
                    }if (@$zmin < 10) {
                        @$zmin = "0" . @$zmin;
                    }@$zbyva = (@$celkhod - @$nhod) . ":" . @$zmin;
                    if (@$zbyva <> "0:00" and StrPos(" " . @$zbyva, "-") == false) {
                        @$zbyva = @$zbyva;
                    } else {
                        @$zbyva = "";
                    }
//  konec definováno


                    echo "<td align=center width=33%";
                    if (@$dhod <> "") {
                        echo" style=background-color:#6BF968 > ";
                    }if (@$dhod <> "") {
                        if (@$dmin < 10) {
                            @$dmin = "0" . @$dmin;
                        }echo @$dhod . ":" . @$dmin;
                    }
                    if (((@$dhod * 60) + @$dmin) >= @$pracdeninmin and $cdne <> 0 and @$cdne <> 6) {
                                        ?> <img src="picture/ready.png" border="0"><?
                        }
                        echo"</td><td align=center width=33%";
                        if (@$zbyva <> "") {
                            echo" style=background-color:#FEEE81 > ";
                        }echo @$zbyva . " </td>";
                                    ?></tr></table></td>

                                    <td><? echo@$definovano; ?></td><td><? echo mysql_result(mysql_query("select poznamka from poznamky where osobni_cislo='$zamestnanec' and datum='$datum'"), 0, 0); ?></td></tr>
                                <?
                                $cykl++;
                            endwhile;
                            ?></tbody><?
                @$osoba++;
            endwhile;
                        ?></table><table  bgcolor="#EDB745" border=2><tr><td align=right colspan=7><input type="submit" value="Aktualizace">
                                <?
                                if (@$typ <> "Read" or (StrPos(" " . $_SESSION["prava"], "E") and @$typ == "Read" and mysql_num_rows(mysql_query("select export from zpracovana_dochazka where stredisko='$stredisko' and obdobi='" . mysql_real_escape_string($obdobi) . "' and export='NE'")) <> "")) {
                                    ?><input type="submit" name=tlacitko value="Uzavøít Všechny Karty"><input type="submit" name=tlacitko value="Otevøít Všechny Karty"><? } ?>
                            </td></tr></form><? }
                } ?>









            <? } ?>






            <? if (StrPos(" " . $_SESSION["prava"], "O") or StrPos(" " . $_SESSION["prava"], "o")) { ?>




                <? if (@$menu == "Docházka Zamìstnance") { ?>
                    <tr bgcolor="#B4ADFC" align=center><td colspan=4><center><b> <? echo@$menu;
            if (mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and potvrzeno<>'ANO' ")) == "" and @$zamestnanec <> "" and @$obdobi <> "" and mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "'")) <> "") { ?> <img src="picture/ready.png" border="0"><? } ?> </b></center></td>

                    <td><select name=zamestnanec size="1" onchange=submit(this) style=size:100%>
                            <?
                            if (@$zamestnanec <> "") {
                                include ("./" . "dbconnect.php");
                                @$data1 = mysql_query("select * from zamestnanci where osobni_cislo='$zamestnanec'") or Die(MySQL_Error());
                                $jmeno = mysql_result($data1, 0, 4) . " " . mysql_result($data1, 0, 3);
                                ?><option value="<? echo(mysql_result($data1, 0, 1)); ?>"><? echo(mysql_result($data1, 0, 4) . " " . mysql_result($data1, 0, 3) . " / " . mysql_result($data1, 0, 1)) . " | " . mysql_result($data1, 0, 17); ?></option><? } else { ?><option></option><?
                }
                include ("./" . "dbconnect.php");
                @$data1 = mysql_query("select * from zamestnanci $dotazline and jen_pruchod='NE'  order by prijmeni,jmeno,osobni_cislo,id ASC") or Die(MySQL_Error());
                @$pocet = mysql_num_rows($data1);
                @$cykl = 0;
                while (@$cykl < @$pocet):
                    if (mysql_result($data1, @$cykl, 1) <> @$zamestnanec) {
                                    ?><option value="<? echo(mysql_result($data1, @$cykl, 1)); ?>"><? echo(mysql_result($data1, @$cykl, 4) . " " . mysql_result($data1, @$cykl, 3) . " / " . mysql_result($data1, @$cykl, 1)); ?></option><?
                }
                @$cykl++;
            endwhile;
                            ?></select></td>

                    <td colspan=2 align=right>Období:<select name=obdobi size="1" onchange=submit(this) style=size:100%>
                            <? if (@$obdobi <> "") { ?><option value="<? echo @$obdobi; ?>"><? $obdobi1 = explode("-", $obdobi);
                    echo $obdobi1[1] . "." . $obdobi1[0]; ?></option><? } else { ?><option></option><?
                    }
                    include ("./" . "dbconnect.php");
                    @$data1 = mysql_query("select obdobi from dochazka group by obdobi order by obdobi DESC") or Die(MySQL_Error());
                    @$pocet = mysql_num_rows($data1);
                    @$cykl = 0;
                    while (@$cykl < @$pocet):
                        if (mysql_result($data1, @$cykl, 0) <> @$obdobi) {
                                    ?><option value="<? echo @mysql_result($data1, @$cykl, 0); ?>"><? $obdobi2 = explode("-", mysql_result($data1, @$cykl, 0));
                        echo $obdobi2[1] . "." . $obdobi2[0]; ?></option><?
                    }
                    @$cykl++;
                endwhile;
                            ?></select><? if (@$zamestnanec <> "" and @$obdobi <> "") { ?><input type="button" value="Tisk Karty" onclick="window.open('TiskKarty.php?zamestnanec=<? echo base64_encode(@$zamestnanec); ?>&obdobi=<? echo base64_encode(@$obdobi); ?>&jmeno=<? echo @$jmeno; ?>');"><input type="button" value="STATUS" onclick="window.open('SysInf.php?oscislo=<? echo base64_encode(@$zamestnanec); ?>&typ=<? echo base64_encode('read'); ?>','','toolbar=0, width=800, height=600, directories=0, location=0, status=1, menubar=0, resizable=0, scrollbars=0, titlebar=0')"><? } ?></td></tr>

                    <? if (@$obdobi <> "" and @$zamestnanec <> "") { ?><tr><td colspan=7><? include ("./" . "infocard.php"); ?></td></tr><? } ?>

                    <tr bgcolor="#C0FFC0" align=center><td>Týden</td><td> Datum </td><td><center>Pøíchod</center></td><td><center>Odchod</center></td><td>Celkový Èas / Definováno / Zbývá Def.</td><td><b>Definováno</b></td><td><b>Poznámka</b></td></tr>

                    <?
                    if (@$zamestnanec <> "" and @$obdobi <> "") {
// cely mesic uzivatele v poli a cisla operaci
                        $prichod = mysql_result(mysql_query("select cislo from klavesnice where text='Pøíchod'"), 0, 0);
                        $odchod1 = mysql_query("select cislo,barva,text from klavesnice where text like 'Odchod%'");
                        @$cykl = 0;
                        while (@$cykl < mysql_num_rows($odchod1)):$odchod[@$cykl] = mysql_result($odchod1, $cykl, 0);
                            $barvy[@$cykl] = mysql_result($odchod1, $cykl, 1);
                            $plky[@$cykl] = mysql_result($odchod1, $cykl, 2);
                            @$cykl++;
                        endwhile;
                        @$vysledek = mysql_query("select * from dochazka where osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by cas,datum,id ") or Die(MySQL_Error());

                        $cykl = 1;
                        while (@$cykl < date("t", strtotime($obdobi1[0] . "-" . $obdobi1[1] . "-01")) + 1):

                            if (@$cykl < 10) {
                                $cyklus = "0" . $cykl;
                            } else {
                                @$cyklus = $cykl;
                            } $datum = $obdobi . "-" . $cyklus;
                            $in = "";
                            $out = "";
                            $wout = "";
                            $cdne = date("w", strtotime($datum));
                            $dsvatku = "-" . $obdobi1[1] . "-" . $cyklus;
                            $svatek = mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$datum' and typ='Jedineèný') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trvalý' and stav='Neaktivní')) "), 0, 0);
                            ?>

                            <tr <? if (@$cdne > 0 and @$cdne < 6 and $svatek == "") { ?>onmouseover="className='menuon';" onmouseout="className='menuoff';"<? } else {
                    if (@$svatek == "") { ?>bgcolor=#FDCC5B<? } else { ?>bgcolor=#F7FBA4<? }
                                                                } ?>>

                                <? $tyden = date("W", strtotime($datum));
                                if (@$cykl == 1 or $cdne == 1) { ?><td align=center valign=middle rowspan=<?
                    if (@$cykl == 1) {
                        if (@$cdne <> 0) {
                            echo (8 - @$cdne);
                        } else {
                            echo "1";
                        }
                    } else {
                        echo"7";
                    }
                                    ?> ><? echo@$tyden; ?></td><? } ?>
                                <td><? echo $cykl . "." . $obdobi1[1] . "." . $obdobi1[0]; ?></td>


                                <td valign=bottom align=center><?
                    $vypis = 0;
                    $narust = 0;
                    while ($vypis < mysql_num_rows($vysledek)):
                        if (mysql_result($vysledek, @$vypis, 4) == $prichod and mysql_result($vysledek, @$vypis, 2) == $datum) {
                            $in[$narust] = substr(mysql_result($vysledek, @$vypis, 3), 0, 5);
                            echo $in[$narust] . "<br />";
                            $narust++;
                        }
                        @$vypis++;
                    endwhile;
                                ?></td>


                                <td valign=bottom align=center><?
                    $vypis = 0;
                    $narust = 0;
                    while ($vypis < mysql_num_rows($vysledek)):
                        @$write = 0;
                        $odchody = "NO";
                        while ($odchod[@$write] <> ""): if (mysql_result($vysledek, @$vypis, 4) == $odchod[@$write]) {
                                $plk = $plky[@$write];
                                $barva = $barvy[@$write];
                                $odchody = "YES";
                            }@$write++;
                        endwhile;
                        if ($odchody == "YES" and mysql_result($vysledek, @$vypis, 2) == $datum) {
                            $out[$narust] = substr(mysql_result($vysledek, @$vypis, 3), 0, 5);
                            echo "<span style=background-color:" . $barva . " title='" . $plk . "'>" . $out[$narust] . "</span><br />";
                            @$narust++;
                        }
                        @$vypis++;
                    endwhile;
                                ?></td>



                                <td valign=bottom align=center><table width=100%><tr><?
                    $vypis = 0;
                    @$celkhod = "";
                    @$celkmin = "";
                    while ($in[$vypis] <> "" and $out[$vypis] <> ""):
                        @$castipr = explode(":", $in[$vypis]);
                        @$prhod = @$castipr[0];
                        @$prmin = @$castipr[1];
                        @$castiod = explode(":", $out[$vypis]);
                        @$odhod = @$castiod[0];
                        @$odmin = @$castiod[1];

                        if (@$odmin < @$prmin) {
                            @$vysmin = 60 - (@$prmin - @$odmin);
                            @$vyshod = @$odhod - @$prhod - 1;
                        }
                        if (@$odmin >= @$prmin) {
                            @$vysmin = @$odmin - @$prmin;
                            @$vyshod = @$odhod - @$prhod;
                        }
                        if (@$vysmin < 10) {
                            @$vysmin = "0" . @$vysmin;
                        }
                        @$celkhod = @$celkhod + @$vyshod;
                        @$celkmin = @$celkmin + @$vysmin;
                        @$vypis++;
                    endwhile;
                    while (@$celkmin >= 60):@$celkhod++;
                        @$celkmin = @$celkmin - 60;
                    endwhile;
                    echo " <td align=center width=33%";
                    if (@$celkhod <> "") {
                        echo" style=background-color:#F05139 >";
                    }if (@$celkhod <> "") {
                        echo @$celkhod . ":";
                    }if ((@$celkmin < 10 and @$celkmin <> "") or (@$celkhod <> "" and @$celkmin < 10)) {
                        echo"0";
                    }echo @$celkmin . " </td>";


                    @$vyshod = "";
                    @$vysmin = "";
                    @$celkhod = "";
                    @$celkmin = "";
                    $vypis = 0;
                    while ($in[$vypis] <> "" and $out[$vypis] <> ""):
                        @$castipr = explode(":", $in[$vypis]);
                        @$prhod = @$castipr[0];
                        @$prmin = @$castipr[1];
                        @$castiod = explode(":", $out[$vypis]);
                        @$odhod = @$castiod[0];
                        @$odmin = @$castiod[1];

                        if (@$odmin < @$prmin) {
                            @$vysmin = 60 - (@$prmin - @$odmin);
                            @$vyshod = @$odhod - @$prhod - 1;
                        }
                        if (@$odmin >= @$prmin) {
                            @$vysmin = @$odmin - @$prmin;
                            @$vyshod = @$odhod - @$prhod;
                        }
                        if (@$vysmin < 10) {
                            @$vysmin = "0" . @$vysmin;
                        }

                        @$celkhod = @$celkhod + @$vyshod;
                        @$celkmin = @$celkmin + @$vysmin;
                        @$vypis++;
                    endwhile;
                    while (@$celkmin >= 60):@$celkhod++;
                        @$celkmin = @$celkmin - 60;
                    endwhile;

// pøestávky
                    if (@$celkhod <> "") {
                        @$prestavek = floor(@$celkhod / (@mysql_result(mysql_query("select * from setting where nazev='Pøestávka' order by id"), 0, 2)));
                        if (@$prestavek / 2 == ceil(@$prestavek / 2)) {
                            @$celkhod = @$celkhod - (0.5 * @$prestavek);
                        } else {
                            $ppr = floor(@$prestavek / 2);
                            if (@$celkmin >= 30) {
                                @$celkmin = @$celkmin - 30;
                                @$celkhod = @$celkhod - (0.5 * @$ppr);
                            } else {
                                @$celkmin = @$celkmin + 30;
                                @$celkhod = @$celkhod - (0.5 * @$ppr) - 1;
                            }
                        }if (@$celkmin < 10) {
                            $celkmin = "0" . $celkmin;
                        }
                    }

//již definováno
                    @$nastaveno1 = mysql_query("select * from zpracovana_dochazka where osobni_cislo = '$zamestnanec' and datum='$datum' order by id");
                    $nhod = 0;
                    $nmin = 0;
                    $dhod = 0;
                    $dmin = 0;
                    $definovano = "";
                    @$cykla = 0;
                    while (@$cykla < @mysql_num_rows($nastaveno1)):
                        @$casti = explode(":", @mysql_result($nastaveno1, @$cykla, 2));
                        @$nhod = @$nhod + @$casti[0];
                        @$nmin = @$nmin + @$casti[1];
                        $dhod = @$dhod + @$casti[0];
                        @$dmin = @$dmin + @$casti[1];
                        if (@$definovano == "") {
                            $definovano = @mysql_result($nastaveno1, @$cykla, 15) . " " . @mysql_result($nastaveno1, @$cykla, 2);
                        } else {
                            $definovano = $definovano . "," . @mysql_result($nastaveno1, @$cykla, 15) . " " . @mysql_result($nastaveno1, @$cykla, 2);
                        }
                        @$cykla++;
                    endwhile;
                    if (@$nmin >= 60) {
                        $ppr = floor(@$nmin / 60);
                        @$nhod = @$nhod + $ppr;
                        @$nmin = @$nmin - (@$ppr * 60);
                    }
                    if (@$dmin >= 60) {
                        $ppr = floor(@$dmin / 60);
                        @$dhod = @$dhod + $ppr;
                        @$dmin = @$dmin - (@$ppr * 60);
                    }
                    @$zmin = @$celkmin - @$nmin;
                    if (@$zmin < 0) {
                        @$nhod = @$nhod + 1;
                        @$zmin = 60 + @$celkmin - @$nmin;
                    }if (@$zmin < 10) {
                        @$zmin = "0" . @$zmin;
                    }@$zbyva = (@$celkhod - @$nhod) . ":" . @$zmin;
                    if (@$zbyva <> "0:00" and StrPos(" " . @$zbyva, "-") == false) {
                        @$zbyva = @$zbyva;
                    } else {
                        @$zbyva = "";
                    }
//  konec definováno


                    echo "<td align=center width=33%";
                    if (@$dhod <> "") {
                        echo" style=background-color:#6BF968 > ";
                    }if (@$dhod <> "") {
                        if (@$dmin < 10) {
                            @$dmin = "0" . @$dmin;
                        }echo @$dhod . ":" . @$dmin;
                    }
                    if (((@$dhod * 60) + @$dmin) >= @$pracdeninmin and $cdne <> 0 and @$cdne <> 6) {
                                    ?> <img src="picture/ready.png" border="0"><?
                        }
                        echo"</td><td align=center width=33%";
                        if (@$zbyva <> "") {
                            echo" style=background-color:#FEEE81 > ";
                        }echo @$zbyva . " </td>";
                                ?></tr></table></td>

                                <td><? echo@$definovano; ?></td><td><? echo mysql_result(mysql_query("select poznamka from poznamky where osobni_cislo='$zamestnanec' and datum='$datum'"), 0, 0); ?></td></tr>
                            <? $cykl++;
                        endwhile; ?></table><table  bgcolor="#EDB745" border=2><tr><td align=left colspan=7><input type="button" value="STATUS" onclick="window.open('SysInf.php?oscislo=<? echo base64_encode(@$zamestnanec); ?>&typ=<? echo base64_encode('read'); ?>','','toolbar=0, width=800, height=600, directories=0, location=0, status=1, menubar=0, resizable=0, scrollbars=0, titlebar=0')"></td></tr><? }
        } ?>













                <? if (@$menu == "Docházka Støediska") { ?>
                    <tr bgcolor="#B4ADFC" align=center><td colspan=5><center><b> <? echo@$menu; ?> </b></center></td>

                    <td>Støedisko:<select name=stredisko size="1" onchange=submit(this) style=size:100%>
                            <? if (@$stredisko <> "") { ?><option value="<? echo $stredisko; ?>"><? echo $stredisko; ?></option><? } else { ?><option></option><?
                }
                @$data1 = mysql_query("select * from zamestnanci $dotazline group by stredisko order by stredisko,osobni_cislo,id") or Die(MySQL_Error());
                @$cykl = 0;
                while (@$cykl < mysql_num_rows($data1)):
                    if (mysql_result($data1, @$cykl, 17) <> @$stredisko) {
                                    ?><option value="<? echo(mysql_result($data1, @$cykl, 17)); ?>"><? echo mysql_result($data1, @$cykl, 17); ?></option><?
                }
                @$cykl++;
            endwhile;
                            ?></select></td>

                    <td align=right>Období:<select name=obdobi size="1" onchange=submit(this) style=size:100%>
                            <? if (@$obdobi <> "") { ?><option value="<? echo @$obdobi; ?>"><? echo obdobics($obdobi); ?></option><? } else { ?><option></option><?
                }
//@$data1 = mysql_query("select obdobi from dochazka where stredisko='$stredisko' group by obdobi order by obdobi DESC") or Die(MySQL_Error());
                @$data1 = mysql_result(mysql_query("select datumzacatku from stredisko where kod='$stredisko'"), 0, 0);
                @$cykl = 0;
                while (date("Y-m", strtotime($data1 . " + " . $cykl . " months")) < date("Y-m", strtotime($dnes . " + 1 months"))):
                    if (date("Y-m", strtotime($data1 . " + " . $cykl . " months")) <> @$obdobi) {
                                    ?><option value="<? echo date('Y-m', strtotime($dnes . ' - ' . $cykl . ' months')); ?>"><? echo obdobics(date("Y-m", strtotime($dnes . " - " . $cykl . " months"))); ?></option><?
                }
                @$cykl++;
            endwhile;
                            ?></select><? if (@$stredisko <> "" and @$obdobi <> "") { ?><input type="button" value="Tisk Karet" onclick="window.open('TiskKaret.php?stredisko=<? echo base64_encode(@$stredisko); ?>&obdobi=<? echo base64_encode(@$obdobi); ?>');"><button onclick="zobrazit()" >Zobrazit / Skrýt</button><? } ?></td></tr>


                    <?
                    if (@$stredisko <> "" and @$obdobi <> "") {
// cely mesic uzivatele v poli a cisla operaci
                        $prichod = mysql_result(mysql_query("select cislo from klavesnice where text='Pøíchod'"), 0, 0);
                        $odchod1 = mysql_query("select cislo,barva,text from klavesnice where text like 'Odchod%'");
                        @$cykl = 0;
                        while (@$cykl < mysql_num_rows($odchod1)):$odchod[@$cykl] = mysql_result($odchod1, $cykl, 0);
                            $barvy[@$cykl] = mysql_result($odchod1, $cykl, 1);
                            $plky[@$cykl] = mysql_result($odchod1, $cykl, 2);
                            @$cykl++;
                        endwhile;

                        @$osoby = mysql_query("select osobni_cislo,prijmeni,jmeno,titul from zamestnanci where osobni_cislo in (select osobni_cislo from zam_strediska where stredisko='$stredisko' and datumod<='$yobdobi1' and (datumdo='0000-00-00' or datumdo like '$obdobi%' or datumdo>='$yobdobi')) and jen_pruchod='NE' group by osobni_cislo order by prijmeni,jmeno,id ") or Die(MySQL_Error());
                        ?>
                        <script type="text/javascript">
                            function showhide(id) {
                                var tr = document.getElementById(id);
                                if (tr==null) { return; }
                                var bExpand = tr.style.display == '';
                                tr.style.display = (bExpand ? 'none' : '');
                            }
                            function zobrazit(){
            <?
            $vsichni = 0;
            while (@$vsichni < mysql_num_rows(@$osoby)):
                echo"showhide('zaznam" . $vsichni . "');";
                @$vsichni++;
            endwhile;
            ?>
                }
                        </script>
                        <? @$osoba = 0;
                        while (@$osoba < mysql_num_rows(@$osoby)): $jmeno = mysql_result($osoby, @$osoba, 1) . " " . mysql_result($osoby, @$osoba, 2); ?>
                            <tr bgcolor="#C0FFC0" align=center><td colspan=5><?
                $zamestnanec = mysql_result(@$osoby, @$osoba, 0);
                echo mysql_result(@$osoby, @$osoba, 0) . " / " . mysql_result(@$osoby, @$osoba, 3) . " " . mysql_result(@$osoby, @$osoba, 2) . " " . mysql_result(@$osoby, @$osoba, 1);
                if (mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "' and potvrzeno<>'ANO' ")) == "" and @$zamestnanec <> "" and @$obdobi <> "" and mysql_num_rows(mysql_query("select potvrzeno from zpracovana_dochazka where osobni_cislo = '" . mysql_real_escape_string($zamestnanec) . "' and obdobi='" . mysql_real_escape_string($obdobi) . "'")) <> "") {
                                ?> <img src="picture/ready.png" border="0"><? } ?></td><td align=right colspan=2><input type="button" value="STATUS" onclick="window.open('SysInf.php?oscislo=<? echo base64_encode(@$zamestnanec); ?>&typ=<? echo base64_encode('read'); ?>','','toolbar=0, width=800, height=600, directories=0, location=0, status=1, menubar=0, resizable=0, scrollbars=0, titlebar=0')"><input type="button" value="Tisk Karty" onclick="window.open('TiskKarty.php?zamestnanec=<? echo base64_encode(@$zamestnanec); ?>&obdobi=<? echo base64_encode(@$obdobi); ?>&jmeno=<? echo @$jmeno; ?>');"></td></tr>
                            <? @$vysledek = mysql_query("select * from dochazka where osobni_cislo='$zamestnanec' and obdobi='$obdobi' order by osobni_cislo,cas,datum,id") or Die(MySQL_Error());
                            if (@$obdobi <> "" and @$zamestnanec <> "") { ?><tr><td colspan=7><? include ("./" . "infocard.php"); ?></td></tr><? } ?>

                            <tbody id="zaznam<? echo$osoba; ?>">
                                <tr bgcolor="#C0FFC0" align=center><td>Týden</td><td> Datum </td><td><center>Pøíchod</center></td><td><center>Odchod</center></td><td>Celkový Èas / Definováno / Zbývá Def.</td><td><b>Definováno</b></td><td><b>Poznámka</b></td></tr>
                            <?
                            $cykl = 1;
                            while (@$cykl < date("t", strtotime($obdobi1[0] . "-" . $obdobi1[1] . "-01")) + 1):

                                if (@$cykl < 10) {
                                    $cyklus = "0" . $cykl;
                                } else {
                                    @$cyklus = $cykl;
                                } $datum = $obdobi . "-" . $cyklus;
                                $in = "";
                                $out = "";
                                $wout = "";
                                $cdne = date("w", strtotime($datum));
                                $dsvatku = "-" . $obdobi1[1] . "-" . $cyklus;
                                $svatek = mysql_result(mysql_query("select id from svatky where ((datum like '%$dsvatku' and typ='Trvalý' and stav='Aktivní') or (datum='$datum' and typ='Jedineèný') or (datum like '%$dsvatku' and datumdo<='$datum' and typ='Trvalý' and stav='Neaktivní')) "), 0, 0);
                                ?>
                                <tr <? if (@$cdne > 0 and @$cdne < 6 and $svatek == "") { ?>onmouseover="className='menuon';" onmouseout="className='menuoff';"<? } else {
                        if (@$svatek == "") { ?>bgcolor=#FDCC5B<? } else { ?>bgcolor=#F7FBA4<? }
                                                                } ?> >
                                                                                                <? $tyden = date("W", strtotime($datum));
                                                                                                if (@$cykl == 1 or $cdne == 1) { ?>
                                        <td align=center valign=middle rowspan=<?
                                                                            if (@$cykl == 1) {
                                                                                if (@$cdne <> 0) {
                                                                                    echo (8 - @$cdne);
                                                                                } else {
                                                                                    echo "1";
                                                                                }
                                                                            } else {
                                                                                if (((date("t", strtotime($obdobi1[0] . "-" . $obdobi1[1] . "-01")) + 1) - @$cykl) > 7) {
                                                                                    echo"7";
                                                                                } else {
                                                                                    echo((date("t", strtotime($obdobi1[0] . "-" . $obdobi1[1] . "-01")) + 1) - @$cykl);
                                                                                }
                                                                            }
                                                                                                    ?> ><? echo@$tyden; ?></td><? } ?>
                                    <td><? echo $cykl . "." . $obdobi1[1] . "." . $obdobi1[0]; ?></td>


                                    <td valign=bottom align=center><?
                    $vypis = 0;
                    $narust = 0;
                    while ($vypis < mysql_num_rows($vysledek)):
                        if (mysql_result($vysledek, @$vypis, 4) == $prichod and mysql_result($vysledek, @$vypis, 2) == $datum and mysql_result($vysledek, @$vypis, 6) == mysql_result(@$osoby, @$osoba, 0)) {
                            $in[$narust] = substr(mysql_result($vysledek, @$vypis, 3), 0, 5);
                            echo $in[$narust] . "<br />";
                            $narust++;
                        }
                        @$vypis++;
                    endwhile;
                                                                                                ?></td>


                                    <td valign=bottom align=center><?
                    $vypis = 0;
                    $narust = 0;
                    while ($vypis < mysql_num_rows($vysledek)):
                        @$write = 0;
                        $odchody = "NO";
                        while ($odchod[@$write] <> ""): if (mysql_result($vysledek, @$vypis, 4) == $odchod[@$write]) {
                                $plk = $plky[@$write];
                                $barva = $barvy[@$write];
                                $odchody = "YES";
                            }@$write++;
                        endwhile;
                        if ($odchody == "YES" and mysql_result($vysledek, @$vypis, 2) == $datum and mysql_result($vysledek, @$vypis, 6) == mysql_result(@$osoby, @$osoba, 0)) {
                            $out[$narust] = substr(mysql_result($vysledek, @$vypis, 3), 0, 5);
                            echo "<span style=background-color:" . $barva . " title='" . $plk . "'>" . $out[$narust] . "</span><br />";
                            @$narust++;
                        }
                        @$vypis++;
                    endwhile;
                                                                                                ?></td>



                                    <td valign=bottom align=center><table width=100%><tr><?
                    $vypis = 0;
                    @$celkhod = "";
                    @$celkmin = "";
                    while ($in[$vypis] <> "" and $out[$vypis] <> ""):
                        @$castipr = explode(":", $in[$vypis]);
                        @$prhod = @$castipr[0];
                        @$prmin = @$castipr[1];
                        @$castiod = explode(":", $out[$vypis]);
                        @$odhod = @$castiod[0];
                        @$odmin = @$castiod[1];

                        if (@$odmin < @$prmin) {
                            @$vysmin = 60 - (@$prmin - @$odmin);
                            @$vyshod = @$odhod - @$prhod - 1;
                        }
                        if (@$odmin >= @$prmin) {
                            @$vysmin = @$odmin - @$prmin;
                            @$vyshod = @$odhod - @$prhod;
                        }
                        if (@$vysmin < 10) {
                            @$vysmin = "0" . @$vysmin;
                        }
                        @$celkhod = @$celkhod + @$vyshod;
                        @$celkmin = @$celkmin + @$vysmin;
                        @$vypis++;
                    endwhile;
                    while (@$celkmin >= 60):@$celkhod++;
                        @$celkmin = @$celkmin - 60;
                    endwhile;
                    echo " <td align=center width=33%";
                    if (@$celkhod <> "") {
                        echo" style=background-color:#F05139 >";
                    }if (@$celkhod <> "") {
                        echo @$celkhod . ":";
                    }if ((@$celkmin < 10 and @$celkmin <> "") or (@$celkhod <> "" and @$celkmin < 10)) {
                        echo"0";
                    }echo @$celkmin . " </td>";


                    @$vyshod = "";
                    @$vysmin = "";
                    @$celkhod = "";
                    @$celkmin = "";
                    $vypis = 0;
                    while ($in[$vypis] <> "" and $out[$vypis] <> ""):
                        @$castipr = explode(":", $in[$vypis]);
                        @$prhod = @$castipr[0];
                        @$prmin = @$castipr[1];
                        @$castiod = explode(":", $out[$vypis]);
                        @$odhod = @$castiod[0];
                        @$odmin = @$castiod[1];

                        if (@$odmin < @$prmin) {
                            @$vysmin = 60 - (@$prmin - @$odmin);
                            @$vyshod = @$odhod - @$prhod - 1;
                        }
                        if (@$odmin >= @$prmin) {
                            @$vysmin = @$odmin - @$prmin;
                            @$vyshod = @$odhod - @$prhod;
                        }
                        if (@$vysmin < 10) {
                            @$vysmin = "0" . @$vysmin;
                        }

                        @$celkhod = @$celkhod + @$vyshod;
                        @$celkmin = @$celkmin + @$vysmin;
                        @$vypis++;
                    endwhile;
                    while (@$celkmin >= 60):@$celkhod++;
                        @$celkmin = @$celkmin - 60;
                    endwhile;

// pøestávky
                    if (@$celkhod <> "") {
                        @$prestavek = floor(@$celkhod / (@mysql_result(mysql_query("select * from setting where nazev='Pøestávka' order by id"), 0, 2)));
                        if (@$prestavek / 2 == ceil(@$prestavek / 2)) {
                            @$celkhod = @$celkhod - (0.5 * @$prestavek);
                        } else {
                            $ppr = floor(@$prestavek / 2);
                            if (@$celkmin >= 30) {
                                @$celkmin = @$celkmin - 30;
                                @$celkhod = @$celkhod - (0.5 * @$ppr);
                            } else {
                                @$celkmin = @$celkmin + 30;
                                @$celkhod = @$celkhod - (0.5 * @$ppr) - 1;
                            }
                        }if (@$celkmin < 10) {
                            $celkmin = "0" . $celkmin;
                        }
                    }

//již definováno
                    @$nastaveno1 = mysql_query("select * from zpracovana_dochazka where osobni_cislo = '$zamestnanec' and datum='$datum' order by id");
                    $nhod = 0;
                    $nmin = 0;
                    $dhod = 0;
                    $dmin = 0;
                    $definovano = "";
                    @$cykla = 0;
                    while (@$cykla < @mysql_num_rows($nastaveno1)):
                        @$casti = explode(":", @mysql_result($nastaveno1, @$cykla, 2));
                        @$nhod = @$nhod + @$casti[0];
                        @$nmin = @$nmin + @$casti[1];
                        $dhod = @$dhod + @$casti[0];
                        @$dmin = @$dmin + @$casti[1];
                        if (@$definovano == "") {
                            $definovano = @mysql_result($nastaveno1, @$cykla, 15) . " " . @mysql_result($nastaveno1, @$cykla, 2);
                        } else {
                            $definovano = $definovano . "," . @mysql_result($nastaveno1, @$cykla, 15) . " " . @mysql_result($nastaveno1, @$cykla, 2);
                        }
                        @$cykla++;
                    endwhile;
                    if (@$nmin >= 60) {
                        $ppr = floor(@$nmin / 60);
                        @$nhod = @$nhod + $ppr;
                        @$nmin = @$nmin - (@$ppr * 60);
                    }
                    if (@$dmin >= 60) {
                        $ppr = floor(@$dmin / 60);
                        @$dhod = @$dhod + $ppr;
                        @$dmin = @$dmin - (@$ppr * 60);
                    }
                    @$zmin = @$celkmin - @$nmin;
                    if (@$zmin < 0) {
                        @$nhod = @$nhod + 1;
                        @$zmin = 60 + @$celkmin - @$nmin;
                    }if (@$zmin < 10) {
                        @$zmin = "0" . @$zmin;
                    }@$zbyva = (@$celkhod - @$nhod) . ":" . @$zmin;
                    if (@$zbyva <> "0:00" and StrPos(" " . @$zbyva, "-") == false) {
                        @$zbyva = @$zbyva;
                    } else {
                        @$zbyva = "";
                    }
//  konec definováno


                    echo "<td align=center width=33%";
                    if (@$dhod <> "") {
                        echo" style=background-color:#6BF968 > ";
                    }if (@$dhod <> "") {
                        if (@$dmin < 10) {
                            @$dmin = "0" . @$dmin;
                        }echo @$dhod . ":" . @$dmin;
                    }
                    if (((@$dhod * 60) + @$dmin) >= @$pracdeninmin and $cdne <> 0 and @$cdne <> 6) {
                                                                                                    ?> <img src="picture/ready.png" border="0"><?
                        }
                        echo"</td><td align=center width=33%";
                        if (@$zbyva <> "") {
                            echo" style=background-color:#FEEE81 > ";
                        }echo @$zbyva . " </td>";
                                                                                                ?></tr></table></td>

                                    <td><? echo@$definovano; ?></td><td><? echo mysql_result(mysql_query("select poznamka from poznamky where osobni_cislo='$zamestnanec' and datum='$datum'"), 0, 0); ?></td></tr>
                                <?
                                $cykl++;
                            endwhile;
                            ?></tbody><?
                @$osoba++;
            endwhile;
        }
    }
                ?>














            <? } ?>


            <input name="zamestnanecold" type="hidden" value="<? echo@$zamestnanec; ?>">
            <input name="strediskoold" type="hidden" value="<? echo@$stredisko; ?>">
        </table></center>
</form><br /><br /><br />
