//ActiveX Object Defines
var AXOBJECT_ID = "AxVideoView";
var AXOBJECT_PATH = "AxViewer/";
var AXOBJECT_NAME = "AxVideoView.cab";
var AXOBJECT_VER = "1,2,4,60";
var CLASS_ID = "0C71BDAA-5B30-4E12-A317-D225FEB9A068";
var user = SendCGICMD("/cgi-bin/view/hello");
var TEMP_USER_NAME = GetQueryVariableEx2("admin", user);
var TEMP_PASSWORD = GetQueryVariableEx2("asarka", user);
// do NOT change these two lines
//var GET_USER_NAME = "";
//var GET_PASSWORD = "";
// do NOT change these two lines

//Video Stream Defines
var RTSP_SUPPORT = "1";
var PROTOCOL_TYPE = "1"; //(set as cookie on client PC) 1->TCP, 2->UDP, 3->HTTP 4->Multicast  ,default connect order  TCP->UDP->HTTP
var g_szProtocolType = "3";
var MPEG4_ACCESS_NAME = "video.mp4";
var MJPEG_ACCESS_NAME = "video.mjpg";
var MULTICAST_ACCESS_NAME = "multicast.mp4";
var RECORDER_SUPPORT = "1";
var VIDEO_FMT=1;
var PLUGIN_LANG=getLanguage();
var INITMODE = "Player";
var VIEW_SIZE = "Medium";
var Buffer_Enable = getBufferEn();
var _platform = navigator.platform;
var objectID="AxViewer"; //"AxViewer", "ObjJavaCam", "jpeg"
var _browser=navigator.appName;

var HOST_NAME="";
var HOST_PORT = "80";
var HOST_SSL_PORT = 0;
var HOST_PROTOCOL = "";

if(HOST_PROTOCOL=="https:")
{
  if(HOST_PORT==0 || HOST_PORT=="")
    HOST_SSL_PORT = 443;
  else
    HOST_SSL_PORT = HOST_PORT;
}

if(HOST_PORT==0 || HOST_PORT=="")
{
  HOST_PORT = 80; //default port
}

function Viewer()
{
	//vincent debug
  if(_platform.toLowerCase().indexOf("mac") >= 0)
  //if(1)
  {
    if(INITMODE == "MotionDetect")
    {return;/*AppletWidth=640;AppletHeight=360;vdoWidth=480;vdoHeight=360;*/}
    else if(INITMODE == "PrivateMask")
    {return;/*AppletWidth=480;AppletHeight=360;vdoWidth=480;vdoHeight=360;*/}
    else
    {
      if(VIEW_SIZE == "Large")
        {AppletWidth=640;AppletHeight=(480+58);vdoWidth=640;vdoHeight=480;}
      else if(VIEW_SIZE == "Medium")
        {AppletWidth=320;AppletHeight=(240+58);vdoWidth=320;vdoHeight=240;}
      else
        {AppletWidth=320;AppletHeight=315;}
    }
  	objectID = "ObjJavaCam";
    document.writeln('<applet  NAME="ObjJavaCam" CODE = "javacam.QTStreamingApplet.class" JAVA_CODEBASE = "./java/" WIDTH = '+AppletWidth+' HEIGHT = '+AppletHeight+' MAYSCRIPT></xmp>');
    document.writeln('    <PARAM NAME = CODE VALUE = "javacam.QTStreamingApplet.class" >');
    document.writeln('    <PARAM NAME = CODEBASE VALUE = "./java/" >');
    document.writeln('    <PARAM NAME = ARCHIVE VALUE = "qtcam.jar" >');
    document.writeln('    <param name="type" value="application/x-java-applet;version=1.5.0">');
    document.writeln('    <param name="scriptable" value="false">');
    document.write("    <PARAM name=\"Protocol\" VALUE=\"" + getProtocol() + "\">");
    document.write("	<PARAM name='InitMode' VALUE=\"" + INITMODE + "\">");
    document.write("    <PARAM name=\"CompressType\" VALUE=\"" + getVideoFmt() + "\">");
    document.write("    <PARAM name=\"Language\" VALUE=\"" + PLUGIN_LANG + "\">");
    document.write("    <PARAM name=\"RecorderEn\" VALUE=\"" + RECORDER_SUPPORT + "\">");
    document.write("    <PARAM name=\"UserName\" VALUE=\"" + TEMP_USER_NAME + "\">");
    document.write("    <PARAM name=\"Password\" VALUE=\"" + TEMP_PASSWORD + "\">");
    document.write("    <PARAM name=\"BufferEn\" VALUE=\"" + Buffer_Enable + "\">");
    document.write("    <PARAM name=\"vdoWidth\" VALUE=\"" + vdoWidth + "\">");
    document.write("    <PARAM name=\"vdoHeight\" VALUE=\"" + vdoHeight + "\">");
	    document.write("	<PARAM name='HostIP' VALUE='" + HOST_NAME + "'>");
    document.write("	<PARAM name='HttpPort' VALUE='" + HOST_PORT + "'>");
    document.write("	<PARAM name='SSLPort' VALUE='" + HOST_SSL_PORT + "'>");
    document.writeln('</applet>');
    document.close();
  }
  else if(_browser.toLowerCase().indexOf("microsoft internet explorer") >= 0)
  {
	objectID="AxViewer";
  	document.open();
  	document.write("<OBJECT NAME=\"" + AXOBJECT_ID + "\"");
  	document.write(" CLASSID=CLSID:" + CLASS_ID);
  	document.write(" CODEBASE=\"/" + (AXOBJECT_PATH + AXOBJECT_NAME) + "#version=" + AXOBJECT_VER + "\">");
      document.write("    <PARAM name=\"RtspEn\" VALUE=\"" + RTSP_SUPPORT + "\">");
      document.write("    <PARAM name=\"Protocol\" VALUE=\"" + PROTOCOL_TYPE + "\">");
      document.write("    <PARAM name=\"Mpeg4Name\" VALUE=\"" + MPEG4_ACCESS_NAME + "\">");
      document.write("    <PARAM name=\"MjpegName\" VALUE=\"" + MJPEG_ACCESS_NAME + "\">");
  	document.write("    <PARAM name=\"MulticastName\" VALUE=\"" + MULTICAST_ACCESS_NAME + "\">");
  	document.write("	<PARAM id='InitMode' name='InitMode' VALUE=\"" + INITMODE + "\">");
  	document.write("	<PARAM name='ViewSize'  VALUE=\"" + VIEW_SIZE + "\">");
      document.write("    <PARAM name=\"CompressType\" VALUE=\"" + VIDEO_FMT + "\">");
      document.write("    <PARAM name=\"Language\" VALUE=\"" + PLUGIN_LANG + "\">");
      document.write("    <PARAM name=\"RecorderEn\" VALUE=\"" + RECORDER_SUPPORT + "\">");
      document.write("    <PARAM id='UserName' name=\"UserName\" VALUE=\"" + TEMP_USER_NAME + "\">");
      document.write("    <PARAM id='Password' name=\"Password\" VALUE=\"" + TEMP_PASSWORD + "\">");
  	document.write("    <PARAM name=\"BufferEn\" VALUE=\"" + Buffer_Enable + "\">");
	    document.write("	<PARAM name='HostIP' VALUE='" + HOST_NAME + "'>");
    document.write("	<PARAM name='HttpPort' VALUE='" + HOST_PORT + "'>");
    document.write("	<PARAM name='SSLPort' VALUE='" + HOST_SSL_PORT + "'>");
  	document.write("</OBJECT>");
  	document.close();
  }
  else// if(_platform.toLowerCase().indexOf("iphone") >= 0)
  //else if(1)
  {
	if(INITMODE == "MotionDetect")
    {return;/*AppletWidth=640;AppletHeight=360;vdoWidth=480;vdoHeight=360;*/}
    else if(INITMODE == "PrivateMask")
    {return;/*AppletWidth=480;AppletHeight=360;vdoWidth=480;vdoHeight=360;*/}
    else
    {
    	document.open();
  		document.write("<img id=\"jpeg\" src=\"/jpg/image.jpg\" onclick=\"refreshImg();\" />");
  		document.close();
    	refreshImg();
	}
	objectID = "jpeg";
  }
}
function NormalViewer(width,height)
{
  if(_platform.toLowerCase().indexOf("mac") >= 0)
  {
    if(INITMODE == "MotionDetect")
    {AppletWidth=640;AppletHeight=360;vdoWidth=480;vdoHeight=360;}
    else if(INITMODE == "PrivateMask")
    {AppletWidth=480;AppletHeight=360;vdoWidth=480;vdoHeight=360;}
    else
    {
      if(VIEW_SIZE == "Large")
        {AppletWidth=640;AppletHeight=555;vdoWidth=640;vdoHeight=480;}
      else if(VIEW_SIZE == "Medium")
        {AppletWidth=320;AppletHeight=315;vdoWidth=320;vdoHeight=240;}
      else
        {AppletWidth=320;AppletHeight=315;}
    }
  	objectID = "ObjJavaCam";
    document.writeln('<applet  NAME="ObjJavaCam" CODE = "javacam.QTStreamingApplet1.class" JAVA_CODEBASE = "./java/" WIDTH = '+AppletWidth+' HEIGHT = '+AppletHeight+' MAYSCRIPT></xmp>');
    document.writeln('    <PARAM NAME = CODE VALUE = "javacam.QTStreamingApplet1.class" >');
    document.writeln('    <PARAM NAME = CODEBASE VALUE = "./java/" >');
    document.writeln('    <PARAM NAME = ARCHIVE VALUE = "qtcam.jar" >');
    document.writeln('    <param name="type" value="application/x-java-applet;version=1.5.0">');
    document.writeln('    <param name="scriptable" value="false">');
    document.write("    <PARAM name=\"Protocol\" VALUE=\"" + getProtocol() + "\">");
    document.write("	<PARAM name='InitMode' VALUE=\"" + INITMODE + "\">");
    document.write("    <PARAM name=\"CompressType\" VALUE=\"" + getVideoFmt() + "\">");
    document.write("    <PARAM name=\"Language\" VALUE=\"" + PLUGIN_LANG + "\">");
    document.write("    <PARAM name=\"RecorderEn\" VALUE=\"" + RECORDER_SUPPORT + "\">");
    document.write("    <PARAM name=\"UserName\" VALUE=\"" + TEMP_USER_NAME + "\">");
    document.write("    <PARAM name=\"Password\" VALUE=\"" + TEMP_PASSWORD + "\">");
    document.write("    <PARAM name=\"BufferEn\" VALUE=\"" + Buffer_Enable + "\">");
    document.write("    <PARAM name=\"vdoWidth\" VALUE=\"" + vdoWidth + "\">");
    document.write("    <PARAM name=\"vdoHeight\" VALUE=\"" + vdoHeight + "\">");
    document.write("	<PARAM name='HostIP' VALUE='" + HOST_NAME + "'>");
    document.write("	<PARAM name='HttpPort' VALUE='" + HOST_PORT + "'>");
    document.write("	<PARAM name='SSLPort' VALUE='" + HOST_SSL_PORT + "'>");
    document.writeln('</applet>');
    document.close();
  }

  else if(_browser.toLowerCase().indexOf("microsoft internet explorer") >= 0)
  {
	objectID="AxViewer";
	document.open();
    document.write("<OBJECT NAME=\"" + AXOBJECT_ID + "\" width=\"" + width + "\" height=\"" + height + "\"");
	document.write(" CLASSID=CLSID:" + CLASS_ID);
	document.write(" CODEBASE=\"/" + (AXOBJECT_PATH + AXOBJECT_NAME) + "#version=" + AXOBJECT_VER + "\">");
    document.write("    <PARAM name=\"RtspEn\" VALUE=\"" + RTSP_SUPPORT + "\">");
    document.write("    <PARAM name=\"Protocol\" VALUE=\"" + PROTOCOL_TYPE + "\">");
    document.write("    <PARAM name=\"Mpeg4Name\" VALUE=\"" + MPEG4_ACCESS_NAME + "\">");
    document.write("    <PARAM name=\"MjpegName\" VALUE=\"" + MJPEG_ACCESS_NAME + "\">");
	document.write("    <PARAM name=\"MulticastName\" VALUE=\"" + MULTICAST_ACCESS_NAME + "\">");
	document.write("	<PARAM name='InitMode' VALUE='Normal'>");
    document.write("    <PARAM name=\"CompressType\" VALUE=\"" + VIDEO_FMT + "\">");
    document.write("    <PARAM name=\"Language\" VALUE=\"" + PLUGIN_LANG + "\">");
    document.write("    <PARAM name=\"UserName\" VALUE=\"" + TEMP_USER_NAME + "\">");
    document.write("    <PARAM name=\"Password\" VALUE=\"" + TEMP_PASSWORD + "\">");
	document.write("    <PARAM name=\"BufferEn\" VALUE=\"" + Buffer_Enable + "\">");
	    document.write("	<PARAM name='HostIP' VALUE='" + HOST_NAME + "'>");
    document.write("	<PARAM name='HttpPort' VALUE='" + HOST_PORT + "'>");
    document.write("	<PARAM name='SSLPort' VALUE='" + HOST_SSL_PORT + "'>");
	document.write("</OBJECT>");
	document.write("<SCRIPT TYPE='text/javascript'>");
    document.write("if(AxVideoView.InitMode){");
    document.write("    AxVideoView.AVConnect(1);");
    document.write("    AxVideoView.VideoStart(1);");
    document.write("    AxVideoView.AudioStart(0);");
    document.write("    AxVideoView.TalkEnable(0);");
    document.write("}");
    document.write("</SCRIPT>");
	document.close();
}
else //if(_platform.toLowerCase().indexOf("iphone") >= 0)
  //else if(1)
  {
	objectID = "jpeg";
	if(INITMODE == "MotionDetect")
    {return;/*AppletWidth=640;AppletHeight=360;vdoWidth=480;vdoHeight=360;*/}
    else if(INITMODE == "PrivateMask")
    {return;/*AppletWidth=480;AppletHeight=360;vdoWidth=480;vdoHeight=360;*/}
    else
    {
    	document.open();
  		document.write("<img id=\"jpeg\" src=\"/jpg/image.jpg\" onclick=\"refreshImg();\" width=\"" + width + "\" height=\"" + height + "\" />");
  		document.close();
    	refreshImg();
	}
  }
}
function onAxobjUnload()
{
    if(objectID == "AxViewer")
    {
      if(AxVideoView.InitMode)
      {
        setProtocol(AxVideoView.GetProtocol());
        AxVideoView.AVConnect(0);
        AxVideoView.VideoStart(0);
        AxVideoView.AudioStart(0);
        AxVideoView.TalkEnable(0);
      }
    }
}
// This function refreshes jpeg images
var mydate = new Date();
var newimg = new Image();
function refreshImg() {
    var imgObj = document.getElementById('jpeg');
    var newURL;
    if (imgObj) {
        newURL = "/jpg/image.jpg?" + (new Date()).getTime();
        newimg.src = newURL;
        newimg.onload=refreshImg;
        newimg.onerror=refreshImg;
        imgObj.src = newURL;
    }
}