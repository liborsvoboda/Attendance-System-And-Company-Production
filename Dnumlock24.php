<style type="text/css">
#clock { font-family: Arial, Helvetica, sans-serif; font-size: 10.8em; color: white; background-color: black; border: 0px solid purple; padding: 0px; }
</style>

<script type="text/javascript">
function init ( )
{  timeDisplay = document.createTextNode ( "" );
  document.getElementById("clock").appendChild ( timeDisplay );  }

function updateClock ( )
{
  var den = "<?if (date(D)=="Mon") {echo"PO";};if (date(D)=="Tue") {echo"ÚT";};if (date(D)=="Wed") {echo"ST";};if (date(D)=="Thu") {echo"ÈT";};if (date(D)=="Fri") {echo"PÁ";};if (date(D)=="Sat") {echo"SO";};if (date(D)=="Sun") {echo"NE";};?>";
  var day = <?echo date(d);?>;
  var month = <?echo date(m);?>;
  var year = <?echo date(Y);?>;
  var currentTime = new Date ( );
  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );
  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
  // Compose the string for display
  var currentTimeString = den + " " + day + "."+ month + "."+ year+ "  "+ currentHours + ":" + currentMinutes + ":" + currentSeconds;
  // Update the time display
  document.getElementById("clock").firstChild.nodeValue = currentTimeString;
}
</script>