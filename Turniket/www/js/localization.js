//var oXmlDoc = new ActiveXObject("Microsoft.XMLDOM");
//	oXmlDoc = new ActiveXObject("Microsoft.XMLDOM");
//	oXmlDoc.async = false;
//	var bRet = oXmlDoc.load(getLanguageFileName());
//	if (bRet == false)
//	{
//		oXmlDoc.load("lang\\en-US.xml");
//	}
var g_szOutputChar = "";
var g_szLangType = "en-US";
var g_supportLang = "en-US,zh-TW,zh-CN,ja-JP,es-ES,de-DE"; //da-DK,el-GR,en-US,es-ES,fr-FR,he-IL,hr-HR,it-IT,ja-JP,pl-PL,pt-BR,ru-RU,sk-SK,tr-TR,uk-UA,zh-TW zh-CN

//Qmik add start, Scott Chang, 2007/4/17
var oXmlDoc = null;
function loadLanguage()
{
    //alert("load!!");
    oXmlDoc = new ActiveXObject("Microsoft.XMLDOM");
	  oXmlDoc.async = false;
	  var bRet = oXmlDoc.load("lang\\language.xml");
	  if (bRet == false)
	  {
		    oXmlDoc.load("lang\\default.xml");
	  }
}
//Qmik add end, Scott Chang, 2007/4/17

//jack add start,2008/7/3
function makeRequest(url) {
	http_request = false;
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
			http_request = new XMLHttpRequest();
			if (http_request.overrideMimeType) {
  			http_request.overrideMimeType('text/xml');
  		}
	}              
  if (!http_request) {
      alert('Giving up :( Cannot create an XMLHTTP instance');
      return false;
  }
  http_request.open('GET', url, false);
  http_request.send(null); 
}
//jack add end,2008/7/3
//jack add start,2008/7/16
function style_display_on() { 
    var ie = (typeof window.ActiveXObject != 'undefined');
   if (ie) { // IE 
      return "block"; 
   } else { // Mozilla, Safari,... 
      return "table-row"; 
   } 
}
//jack add end ,2008/7/16

//	jack add start for FF & safari  
function hex2rgb(hex)
{
var r = (0xFF0000 & hex) >> 16; var r = (0xFF0000 & hex) >> 16;
var g = (0x00FF00 & hex) >> 8; var g = (0x00FF00 & hex) >> 8;
var b = (0x0000FF & hex); var b = (0x0000FF & hex);
return "rgb(" + r + "," + g + "," + b + ")"; return "rgb(" + r + "," + g + "," + b + ")";
}
//	jack add end for FF & safari 
//	jack add start for FF 
function show_blank_on(){	
      var ie = (typeof window.ActiveXObject != 'undefined');  
		  if(!ie){
	    document.getElementById('table1').style.display="none";
	    }
}
function show_blank_off(){
      var ie = (typeof window.ActiveXObject != 'undefined');  
		  if(!ie){
	    document.getElementById('table1').style.display="block";
	    }
}
//	jack add end for FF 
//	jack add start to know browser
function getOs() 
{ 
   var OsObject = ""; 
   if(navigator.userAgent.indexOf("MSIE")>0) { 
        return "IE"; 
   } 
   if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){ 
        return "Firefox"; 
   } 
   if(isSafari=navigator.userAgent.indexOf("Safari")>0) { 
        return "Safari"; 
   }   
} 
//jack add end
// PDL:
// This function is used to read the string of each localization 
// (according to the location of OS)
//
// get a XML parser
// use this XML parser to get the string 
function loadLangString(strtag,display)
{
    var ie = (typeof window.ActiveXObject != 'undefined');  //jack add,2008/7/3
//Qmik add start, Scott Chang, 2007/4/17
	if (ie){																								//jack add,2008/7/3
		if(oXmlDoc==null)
		{		
	  		loadLanguage();
  	    }
//  var oXmlDoc = new ActiveXObject("Microsoft.XMLDOM");
//	oXmlDoc.async = false;
//	var bRet = oXmlDoc.load(getLanguageFileName());
//	if (bRet == false)
//	{
//	   oXmlDoc.load("lang\\default.xml");
//	}
//Qmik add end, Scott Chang, 2007/4/17
  		g_szOutputChar = getData(oXmlDoc, "STRING/"+strtag);
  		if(g_szOutputChar=="")
  		{		
      		var tmpDoc = new ActiveXObject("Microsoft.XMLDOM");
	    		tmpDoc.async = false;
      		tmpDoc.load("lang\\default.xml");
      		g_szOutputChar = getData(tmpDoc, "STRING/"+strtag);
      		if(g_szOutputChar=="")
          	g_szOutputChar="Error";
  		}
  	}
  	else{                                                  //jack add start,2008/7/3
  		if(oXmlDoc==null){
  			makeRequest("lang/language.xml"+"?"+(new Date()).getTime());  //add "?"+(new Date()).getTime() for firefox & safari upload language pack
  			//if(oXmlDoc==null){
  				//makeRequest("lang/default.xml");
  			//}
  			//if (http_request.readyState == 4)
  				oXmlDoc = http_request.responseXML;
  		}
  		try{
    	g_szOutputChar=oXmlDoc.getElementsByTagName(strtag)[0].firstChild.nodeValue; //getElementsByTagName(strtag)[0].childNodes[0].nodeValue;
      }
      catch(e){		
      				try{
      				makeRequest("lang/default.xml");
      				oXmlDoc = http_request.responseXML;	
    					g_szOutputChar=oXmlDoc.getElementsByTagName(strtag)[0].firstChild.nodeValue; //getElementsByTagName(strtag)[0].childNodes[0].nodeValue;
      				}
      				catch(e){																	
      				g_szOutputChar="Error";			//jack add for strtag is not in XML's Tag 
      				}
      }
    	//if(g_szOutputChar=="")
       		//g_szOutputChar="Error";
  	}                                                       //jack add end,2008/7/3
	if(display==true)
	    document.write(g_szOutputChar);
	return g_szOutputChar;
}

// PDL:
// This function is used to get the date of a XML element
function getData(oDoc, szXmlPath)
{
	var szRetval = "";
	var NodeObj=oDoc.selectSingleNode(szXmlPath);
	if (NodeObj)
		szRetval = NodeObj.text;
	return szRetval;
}

// PDL:
// This function is used to get the localization string and 
// decide which file should be read
function getLanguageFileName()
{ //navigator.userLanguage     navigator.browserLanguage 
	//var szSysLang = navigator.systemLanguage;
	//if (szSysLang != "zh-tw")
	//szSysLang = "en";
	szSysLang = getLanguage();
	szLangFileName="lang\\" + szSysLang + ".xml";
	return szLangFileName;
}

function getSupportLang()
{ 
	return g_supportLang;
}

function setLanguage(langType)
{ 
	setCookies(g_szLangType,langType);
	g_szLangType=langType;
}
/*
function getLanguage()
{ 
	//return g_szLangType;
	lang=getCookies(g_szLangType);
	if(lang==null)
	{
	    setCookies(g_szLangType,"en-US");
	    return g_szLangType;
	}
	return lang;
}
*/
function getLanguage()
{ 
	lang=loadLangString("L_LanguagePack",false);
	return lang;
}
function setCookies(name,value)
{
  var Days = 30; //此 cookie ?被保存 30 天
  var exp  = new Date();    //new Date("December 31, 9998");
  exp.setTime(exp.getTime() + Days*24*60*60*1000);
  document.cookie = name + "="+ escape(value) +";expires="+ exp.toGMTString();
}
function getCookies(name)
{
  var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
  if(arr != null) return unescape(arr[2]); return null;
}
function delCookies(name)
{
  var exp = new Date();
  exp.setTime(exp.getTime() - 1);
  var cval=getCookie(name);
  if(cval!=null) document.cookie=name +"="+cval+";expires="+exp.toGMTString();
} 
function getLangUicode()
{
	lang=loadLangString("L_LanguagePack",false);
	switch(lang)
	{
    case "en-US":
        return "English";
    case "zh-TW":
        return "繁體中文";
    case "zh-CN":
        return "简体中文";
    case "de-DE":
        return "Deutsch";        
    case "ja-JP":
        return "日本語";  
    case "es-ES":
        return "español"; 
    case "da-DK":
        return "Dansk";         
    case "el-GR":
        return "Ellinika'";     
    case "ko-KR":
        return "한국어";  
    case "tr-TR":
        return "Türkçe"; 
		default:
		    return loadLangString("L_LocalLanguage",false);
	}
}
