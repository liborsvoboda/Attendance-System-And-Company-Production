<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>LiveView</title>
</head>
<body>
<object classid="clsid:336C9D79-263A-4d75-AA7C-60DAF945AE67" id="CamV" width="100%" height="700" border=3>
    <PARAM NAME="MediaURL" VALUE="rtsp://<?echo $kip;?>:554/mpeg4/media.amp?resolution=xvga">
    <PARAM NAME="HttpPort" VALUE="80">
    <PARAM NAME="RTSPStream" VALUE="HTTP">
    <PARAM NAME="MediaUsername" VALUE="<?echo $kname;?>">
    <PARAM NAME="MediaPassword" VALUE="<?echo $kpasswd;?>">
    <PARAM NAME="StretchToFit" VALUE="1">
    <PARAM NAME="AutoStart" VALUE="1">
    <PARAM NAME="EnableReconnect" VALUE="1">
    <PARAM NAME="UIMode" VALUE="1">
 </object>

</html>
