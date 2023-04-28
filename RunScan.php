<?include ("./"."dbconnect.php");
if (mysql_result(mysql_query("select hodnota from setting where nazev='MSnímaè' "),0,0)=="Numlock") {$load="Scan";}
if (mysql_result(mysql_query("select hodnota from setting where nazev='MSnímaè' "),0,0)=="Dotyková Obrazovka (+Obìdy)") {$load="DScan";}
if (mysql_result(mysql_query("select hodnota from setting where nazev='MSnímaè' "),0,0)=="Dot. Obr. (+Obìdy&Info)") {$load="DIScan";}
?>
<script type="text/javascript">
window.open('<?echo $load;?>.php','','toolbar=0,fullscreen=yes , directories=0, location=0, status=0, menubar=0, resizable=0, scrollbars=0, titlebar=0');
</script>

<script type="text/javascript">
function closeWindow() {
     //var browserName = navigator.appName;
     //var browserVer = parseInt(navigator.appVersion);
     var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;
     if (ie7)
           {
           //This method is required to close a window without any prompt for IE7
           window.open('','_parent','');
           window.close();
           }     else   {
           //This method is required to close a window without any prompt for IE6
           this.focus();
           self.opener = this;
           self.close();
           }
}

</script>



<BODY onload='closeWindow()'>

