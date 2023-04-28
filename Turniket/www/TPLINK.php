
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<title>IP CAMERA</title>
<SCRIPT language="JavaScript" src="js/localization.js"></SCRIPT>
<SCRIPT language="JavaScript" src="js/commfunc.js"></SCRIPT>
<SCRIPT language="JavaScript" src="js/axobjdef.js"></SCRIPT>
<script type="text/JavaScript">
<!--

var TEMP_USER_NAME = "<?echo $kname;?>";
var TEMP_PASSWORD = "<?echo $kpasswd;?>";
var HOST_NAME="<?echo $kip;?>";
var VIDEO_FMT=1;
var PLUGIN_LANG=getLanguage();
var INITMODE = "Player";
var VIEW_SIZE = getViewSize();
var PROTOCOL_TYPE=getProtocol();
switch(getVideoFmt())
{
	case 'mpeg4':
        VIDEO_FMT = 1;
        break;
  	case 'mjpeg':
        VIDEO_FMT = 0;
        break;
    default:
        VIDEO_FMT = 1;
        break;
}
//var PROTOCOL_TYPE=getProtocol();
//-->
</script>
</head>
<body leftmargin="0" topmargin="0" onUnload="onAxobjUnload()">
  <div style="margin:0,auto;margin-top:90;">
    <center>
      <script>Viewer()</script>
    </center>
  </div>
</body>

</html>