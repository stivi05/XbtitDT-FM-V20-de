<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html<tag:main_rtl /> xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><tag:main_title /></title>

  <meta http-equiv="content-type" content="text/html; charset=<tag:main_charset />" />
  <link rel="stylesheet" href="<tag:main_css />" type="text/css" />
  <tag:more_css />
	<tag:main_jscript />
	
<script type='text/javascript' src='jscript/jquery-latest.min.js'></script>
<script type='text/javascript' src='jscript/jquery.jqDock.min.js'></script>
<script type='text/javascript' src='jscript/jquery.jqDock.js'></script>

<script type="text/javascript">

animatedcollapse.addDiv('header', 'hide=0,fade=1,speed=1000,persist=1')
animatedcollapse.addDiv('bottom_menu', 'hide=0,fade=1,speed=1000,persist=1')

//persist(1) uses a cookie to remember the toggled block either opened or closed and will remain in that state across your pages
//grouped like in the example below causes if you click to open one the other block(s) close
//examples of other traits  'fade=1,speed=1000,group=blocks,persist=1,hide=1')

animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
	//$: Access to jQuery
	//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
	//state: "block" or "none", depending on state which is also (hide, 0 or 1) = (0)=("block" is opened) (1)=("none" is closed)
	//alert("1) DIV ID: " + divobj.id + "\n2) Current State: "+state)
}

animatedcollapse.init()

</script>

<!--[if lte IE 7]>
<style type="text/css">
#menu ul {display:inline;}
</style>
<![endif]-->
<!--[if gte IE 9]>
  <style type="text/css">
    .gradient {
       filter: none;
    }
  </style>
<![endif]-->

<body>


	<div id="main">
    <table width="100%" height="110" align="center" cellpadding="0" cellspacing="0" border="0">
      <tr>
      <td class="logo1"></td>
      </tr>
    </table>

   <if:HAS_AT>   
<br /> <center>  <tag:advertop /> </center>  
  </if:HAS_AT>  
   
  
    <br />
	<TABLE align="center" cellpadding="0" cellspacing="0" border="0">
      <TR>
      <TD valign="top">  
	  <div id="dropdown">
      <tag:main_dropdown />
      </div></TD>
      </TR>
    </TABLE>

<div id="slideIt"><if:guestt><tag:main_slideIt />
<div class="slide_spacer"></div></if:guestt>
	
    <div id="header">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
      <tr>
      <td valign="top" width="5" rowspan="2"></td>
      <td valign="top"><tag:main_header /></td>
      <td valign="top" width="5" rowspan="2"></td>
      </tr>
    </table>
    </div>
    <br />
  
    <div id="bodyarea" style="padding:0 0 0 0;">  
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
      <tr>
	  
      <td valign="top" width="5" rowspan="2"></td>
      <td id="lcol" valign="top" width="180"><tag:main_left /></td>
	  
      <td valign="top" width="5" rowspan="2"></td>
      <td id="mcol" valign="top"><tag:main_content /></td>
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
      <if:guesttt> <div id="slideIt2"><tag:main_slideIt2 /></if:guesttt>
      <td id="mcol" valign="top"><div id="bottom_menu"><tag:main_footer /><if:HAS_DIS><tag:news_text /></if:HAS_DIS></td>
      <td valign="top" width="5" rowspan="2"></td>
      </tr>
    </table>
		 
   
    <table width="100%" height="46" align="center" cellpadding="0" cellspacing="0" border="0" >
      <tr>
<td class="footback" align="left" valign="middle"><tag:xbtit_debug /></td><td class="footback" align="center" valign="middle"><tag:to_top /></td><td class="footback" align="right" valign="middle"><tag:style_copyright />&nbsp;<tag:xbtit_version /></td>
      </tr>
    </table>
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