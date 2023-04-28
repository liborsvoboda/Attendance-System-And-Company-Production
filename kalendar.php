<?@$aktmesic=date ("-m-");$aktobdobi=date ("Y-m-");$aktobdobidate=date ("Y-m-")."31";
include ("./"."dbconnect.php");$sdny1=mysql_query("select datum from svatky where ((datum like '%$aktmesic%' and typ='Trvalý' and stav='Aktivní') or (datum like '$aktobdobi%' and typ='Jedineèný' and stav='Aktivní') or (datum like '%$aktmesic%' and datumdo<='$aktobdobidate' and typ='Trvalý' and stav='Neaktivní')) order by datum");
@$load=0;$sden="/";while(@$load<mysql_num_rows($sdny1)): @$casti=explode ("-", mysql_result($sdny1,$load,0));$sden=$sden.(int)@$casti[2]."/";@$load++;endwhile;?>
<HTML>
<HEAD>
<SCRIPT LANGUAGE="JavaScript">

function montharray(m0, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11)
{
  this[0] = m0;
  this[1] = m1;
  this[2] = m2;
  this[3] = m3;
  this[4] = m4;
  this[5] = m5;
  this[6] = m6;
  this[7] = m7;
  this[8] = m8;
  this[9] = m9;
  this[10] = m10;
  this[11] = m11;
}

function MakeArray(n) {this.length = n; return this;}
 var svatky = "<?echo $sden;?>";
 var Days = new MakeArray(7);
 var Months = new MakeArray(12);
 Days[1]="Nedìle";Days[2]="Pondìlí"; Days[3]="Úterý";   Days[4]="Støeda";
 Days[5]="Ètvrtek"; Days[6]="Pátek"; Days[7]="Sobota";
 Months[1]="ledna"; Months[2]="února"; Months[3]="bøezna";   Months[4]="dubna";
 Months[5]="kvìtna"; Months[6]="èervna"; Months[7]="èervence";   Months[8]="Srpen";
 Months[9]="záøí"; Months[10]="øíjna"; Months[11]="listopadu";
 Months[12]="prosince";

 function getNiceDate(theDate) {
 return Days[theDate.getDay()+1] + " " + theDate.getDate() + ". " +
 Months[theDate.getMonth()+1] + " " +theDate.getYear() ; }

function calendar()
{
  today = new Date();
  var thisDay;
  var monthNames = "JanFebMarAprMajJunJulAugSepOktNovDec";
  var monthNames2 = " 1 2 3 4 5 6 7 8 9101112";
  var monthDays = new montharray(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
  year = today.getYear() + 1900;
  thisDay = today.getDate();
  if (((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0))
     monthDays[1] = 29;
  nDays = monthDays[today.getMonth()];
  firstDay = today;
  firstDay.setDate(1);
  var lastMod = new Date();
  startDay = firstDay.getDay();
  if (startDay==0) {startDay=7;}
  document.write("<TABLE BORDER=\"2\" CELLPADDING=\"2\" bgcolor=\"#FFFFFF\" width=100% style=cursor:pointer>");
  document.write("<TR bgcolor=#CBD73E><TH COLSPAN=7>");
  document.write(getNiceDate(lastMod));
  document.write("<TR bgcolor=#CBD73E><TH>Po<TH>Út<TH>St<TH>Èt<TH>Pá<TH>So<TH>Ne");
  document.write("<TR bgcolor=#FFFFFF>");
  column = -1;
  for (i=1; i<startDay; i++)
  {
     document.write("<TD>");
     document.write("<CENTER>");
     document.write(" ");
     column++;
  }
  for (i=1; i<=nDays; i++)
  {
     if (svatky.search("/"+i+"/") != "-1")
        {document.write("<TD BGCOLOR=\"#F3FA05\" Title=Svátek >");}
        else {document.write("<TD>");}
     if (column == 5)
        document.write("<FONT COLOR=\"#FF0000\" title=Víkend>");
     if (column == 4)
        document.write("<FONT COLOR=\"#0000FF\" title=Víkend>");
     if (i == thisDay)
        document.write("<FONT COLOR=\"#1CE339\" title=Dnes><b>");
     if (i == thisDay)
        document.write("<FONT COLOR=\"#1CE339\"><b>");
    document.write("<CENTER>");
     document.write(i);
     document.write("</CENTER>");
     if (i == thisDay)
        document.write("</b>");
     if (column == 6||column == -1||i == thisDay)
        document.write("</FONT>")
     column++;
     if (column == 6)
     {
        document.write("<TR bgcolor=#FFFFFF>");
        column = -1;
     }
  }
  document.write("</TABLE>");
}
</SCRIPT>
</HEAD>
<BODY>

<CENTER>
<SCRIPT LANGUAGE="JavaScript">
<!--
calendar();
// -->
</SCRIPT>
</CENTER>
</BODY>
</HTML>

