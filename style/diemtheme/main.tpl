<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html<tag:main_rtl /> xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><tag:main_title /></title>
  
  <if:HAS_GA>  
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("<tag:main_google />");
pageTracker._trackPageview();
} catch(err) {}</script>
</if:HAS_GA> 

  <meta http-equiv="content-type" content="text/html; charset=<tag:main_charset />" />
  <link rel="stylesheet" href="<tag:main_css />" type="text/css" />
  <tag:more_css />
	<tag:main_jscript />
<script type='text/javascript' src='jscript/jquery-latest.min.js'></script>
<script type='text/javascript' src='jscript/jquery.jqDock.min.js'></script>
<script type='text/javascript' src='jscript/jquery.jqDock.js'></script>
    	<if:HAS_MT>  	
<script type="text/javascript" src="jscript/pm.js"></script>
<script>
var ss=jQuery.noConflict();
ss(document).ready(function() {

//Get the screen height and width
var maskHeight = ss(document).height();
var maskWidth = ss(window).width();
//Set heigth and width to mask to fill up the whole screen
ss('#mask').css({'width':maskWidth,'height':maskHeight});
//transition effect
setTimeout(function() {
ss('#mask').fadeIn(1000);
ss('#mask').fadeTo("slow",0.8);
}, 80000);
//if mask is clicked
ss('#mask').click(function () {
ss(this).hide();
});
});
</script>
<style>#mask{background-image: url("images/ma.gif");position:absolute;left:0;top:0;z-index:9000;background-color:#000;display:none;}</style>
</if:HAS_MT>  	
<link
rel="alternate"
type="application/rss+xml"
title="RSS"
href="rss.php" />

<link rel="shortcut icon" href="favicon.ico" >
<link rel="icon" href="animated_favicon.gif" type="image/gif" >
<!--[if lte IE 7]>
<style type="text/css">
#menu ul {display:inline;}
</style>
<![endif]-->

<script type="text/javascript" src="/jscript/overlib.js"></script>
</head>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<body onLoad="Defaults()">
<if:HAS_MTT>  
<div id="mask"></div>
</if:HAS_MTT> 
 <tag:season />  
<table  width="1002" height="5"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1002" height="5" align="center"><img src="style/diemtheme/images/topbar.png"></td>
	</tr>
    </table>
  <div id="logo">
   <!-- <table width="1000" align="center" background="style/diemtheme/images/logonew.png" cellpadding="0" cellspacing="0" border="0">
      <tr>
               <td valign='top'> <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="1000" height="213">
  <param name="movie" value="style/diemtheme/images/logo1.swf" />
  <param name="quality" value="high" />
  <param name="allowScriptAccess" value="always" />
  <param name="wmode" value="transparent">
     <embed src="style/diemtheme/images/logo1.swf"
      quality="high"
      type="application/x-shockwave-flash"
      WMODE="transparent"
      width="1000"
      height="213"
      pluginspage="http://www.macromedia.com/go/getflashplayer"
      allowScriptAccess="always" />
</object> </td>
      </tr>
    </table>--></div>
	</TABLE><div id="main">
	<TABLE align="center" width="100%" height="3" cellpadding="0" cellspacing="0" border="0">
      <TR>
        <TD valign="top" background="style/xbtit_default/images/spacer.gif"></TD>
       </TR>
    </TABLE>
    
       <if:HAS_AT>   
<br /> <center>  <tag:advertop /> </center>  
  </if:HAS_AT> <br />
  
	<TABLE align="center" width="960" cellpadding="0" cellspacing="0" border="0">
     <TR>
			<td valign="top" width="8" height="27"><img src="style/diemtheme/images/menu-l.png"></td>
        <td valign="top"><tag:main_dropdown /></td>
      <td valign="top" width="8" height="27"><img src="style/diemtheme/images/menu-r.png"></td>
       </TR>
    </TABLE>
	<TABLE align="center" width="100%" height="10" cellpadding="0" cellspacing="0" border="0">
      <TR>
        <TD valign="top" background="style/xbtit_default/images/spacer.gif"></TD>
       </TR>
    </TABLE>
	<TABLE align="center" width="982" cellpadding="0" cellspacing="0" border="0">
      <TR>
        <TD valign="top">

    <div id="header">
      <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td valign="top" width="5" rowspan="2"></td>
          <td valign="top"><tag:main_header /></td>
          <td valign="top" width="5" rowspan="2"></td>
        </tr>
      </table>
    </div>
  </div>
  <script type="text/javascript">
    var collapse2=new animatedcollapse("header", 800, false, "block")
  </script>
 <div id="bodyarea" style="padding:0 0 0 0;">
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td valign="top" width="5" rowspan="2"></td>
                <if:HAS_LEFT_COL>
        <if:HAS_LEFT>
        <td id="lcol" valign="top" width="160"><tag:main_left /></td>
        <td valign="top" width="5" rowspan="2"></td>
        </if:HAS_LEFT_COL>
        </if:HAS_LEFT>
        <td id="mcol" valign="top"><tag:main_content /></td>
        <if:HAS_RIGHT_COL>
        <if:HAS_RIGHT>
        <td valign="top" width="5" rowspan="2"></td>
        <td id="rcol" valign="top" width="160"><tag:main_right /></td>
        </if:HAS_RIGHT_COL>
        </if:HAS_RIGHT>
        <td valign="top" width="5" rowspan="2"></td>
      </tr>
    </table>
    <br /> 

      
	 <if:HAS_AB>  
     <center> <tag:adverbottom /> </center> <br /> 
     </if:HAS_AB>    
            
    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td valign="top" width="5" rowspan="2"></td>
        <td id="mcol" valign="top"><tag:main_footer /><if:HAS_DIS><tag:news_text /></if:HAS_DIS></td>
        <td valign="top" width="5" rowspan="2"></td>
      </tr>
    </table>
		<br />
  </div>
	</TD>
      </TR>
    </TABLE>
  <TABLE align="center" width="99%" height="10"  cellpadding="0" cellspacing="0" border="0">
      <TR>
	  <td valign="top" width="8" height="27"><img src="style/diemtheme/images/menu-l.png" ></td>
        <td class="footback" align="left" valign="middle"><tag:xbtit_debug /></td><td class="footback" align="center" valign="middle"><tag:to_top /></td><td class="footback" align="right" valign="middle"><tag:style_copyright />&nbsp;<tag:xbtit_version /></td>
		 <td valign="top" width="8" height="27"><img src="style/diemtheme/images/menu-r.png" ></td>
       </TR>
    </TABLE>		
</div>	
<table  width="1002" height="5"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="6" height="5" align="center"><img src="style/diemtheme/images/body-bl.png"></td>
	    <td class="body-bm"><img src="style/diemtheme/images/body-bm.png"></td>
	  <td width="6" height="5" align="center"><img src="style/diemtheme/images/body-br.png"></td>  
	</tr>
</table>

<if:anon>     
<script src="<tag:protected />/jscript/anon.js" type="text/javascript"></script>
<script type="text/javascript"><!--
protected_links = "<tag:protected />";
auto_anonymize();
//--></script>
 </if:anon> 
 
</body>
</html>