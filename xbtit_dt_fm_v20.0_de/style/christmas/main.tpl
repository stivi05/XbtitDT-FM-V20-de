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
<!--[if lte IE 7]>
<style type="text/css">
#menu ul {display:inline;}
</style>
<![endif]-->



<body>
<if:HAS_MTT>  
<div id="mask"></div>
</if:HAS_MTT> 

 <tag:season />  

<div id="header-bg">  <div id="logo-bg">
<table width="100%" height="150"  cellpadding="0" cellspacing="0" border="0">
<tr>

<td class="logo1"></td>

</tr>
</table> 
</div></div>
    <if:HAS_AT>   
<br /> <center>  <tag:advertop /> </center> <br> 
  </if:HAS_AT>    
  
 <div id="menu-bg">    
  <table align="center" height="39" cellpadding="0" cellspacing="0" border="0">
      <tr><td align="left" valign="middle"><img src="style/christmas/images/menu-l.png" width="40" height="35" /></td>
        <td valign="middle" align="center" ><tag:main_dropdown /></td>
	<td align="left" valign="middle"><img src="style/christmas/images/menu-r.png" width="40" height="25" /></td>
      
   
       </tr>
    </table>
	</div>
	<div id="menu-bg-bg">
	</div>
	
	
	
	
	
<div id="body-bg">	
<div id="main"> 	
	<table width='100%' align='center' cellpadding='0' cellspacing='0' border='0'>
        <tr>
          <td valign='top' width='5' rowspan='2'></td>
          <td valign="top" ><tag:main_adarea /></td>
          <td valign='top' width='5' rowspan='2'></td>
        </tr>
      </table>
  
    <div id="header">
      <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td valign="top" width="5" rowspan="2"></td>
          <td valign="top"><tag:main_header /></td>
          <td valign="top" width="5" rowspan="2"></td>
        </tr>
      </table>
    </div>
  
  
  <div id="bodyarea" style="padding:1ex 0 0 0;">  
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td valign="top" width="5" rowspan="2"></td>
        <if:HAS_LEFT>
        <td id="lcol" valign="top" width="180"><tag:main_left /></td>
        <td valign="top" width="5" rowspan="2"></td>
        </if:HAS_LEFT>
        <td id="mcol" valign="top"><tag:main_content /></td>
         <if:HAS_RIGHT>
        <td valign="top" width="5" rowspan="2"></td>
        <td id="rcol" valign="top" width="180"><tag:main_right /></td>
        </if:HAS_RIGHT>
        <td valign="top" width="5" rowspan="2"></td>
      </tr>
    </table><br />
    
    	 <if:HAS_AB>  
     <center> <tag:adverbottom /> </center> <br /> 
     </if:HAS_AB>  
         
    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td valign="top" width="10" rowspan="2"></td>
        <td id="fcol" valign="top"><tag:main_footer /><if:HAS_DIS><tag:news_text /></if:HAS_DIS></td>
        <td valign="top" width="10" rowspan="2"></td>
      </tr>
    </table>
		 </tr>
    </table>
   </div></div>
   <div id="foot-bg">  
<table width="100%" height="85" align="center" cellpadding="0" cellspacing="0" border="0" >
<tr>
<td align="left" valign="top"><img src="style/christmas/images/foot-l.png" width="68" height="67" /></td>
<td align="center" valign="middle"><tag:style_copyright />&nbsp;<tag:xbtit_version /><br />
         <tag:xbtit_debug /></td>
<td align="right" valign="bottom"><img src="style/christmas/images/foot-r.png" width="68" height="67" /></td>
</tr>
</table></div>



 </div>  


   <if:anon>     
<script src="<tag:protected />/jscript/anon.js" type="text/javascript"></script>
<script type="text/javascript"><!--
protected_links = "<tag:protected />";
auto_anonymize();
//--></script>
 </if:anon> 


</body>
</html>