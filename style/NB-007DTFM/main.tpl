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
<link rel="alternate stylesheet" type="text/css" media="screen" title="Gray" href="style/NB-007DTFM/main.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="Blue" href="style/NB-007DTFM/blue.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="Turquoise" href="style/NB-007DTFM/turquoise.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="Green" href="style/NB-007DTFM/green.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="Red" href="style/NB-007DTFM/red.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="Pink" href="style/NB-007DTFM/pink.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="Orange" href="style/NB-007DTFM/orange.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="Yellow" href="style/NB-007DTFM/yellow.css" />
<script src="style/NB-007DTFM/scripts/styleswitch.js" type="text/javascript"></script>
<tag:more_css />
<tag:main_jscript />
<script type='text/javascript' src='jscript/jquery-latest.min.js'></script>
<script type='text/javascript' src='jscript/jquery.jqDock.min.js'></script>
<script type='text/javascript' src='jscript/jquery.jqDock.js'></script>

<script type="text/javascript">

animatedcollapse.addDiv('header', 'fade=1,speed=1000,persist=1,hide=0')
animatedcollapse.addDiv('bottom_menu', 'fade=1,speed=1000,persist=1,hide=0')

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

<if:IS_DISPLAYED_1>
<!--[if lte IE 7]>
<style type="text/css">
#menu ul {display:inline;}
</style>
<![endif]-->
</if:IS_DISPLAYED_1>
</head>
<body>

<if:HAS_MTT>  
<div id="mask"></div>
</if:HAS_MTT> 
<tag:season />  

<if:IS_DISPLAYED_2>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="body-l" width="65"></td>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%" height="26" id="topbar" style="padding:2px 0px 2px 0px;"><tag:main_slideIt />
        
        <div id="color-picker"><select class="csellect" name="switchcontrol" size="1" onChange="chooseStyle(this.options[this.selectedIndex].value, 60)">
<option class="csellect" value="none" selected="selected">Color</option>
<option class="cgray" value="Gray">Gray</option>
<option class="cblue" value="Blue">Blue</option>
<option class="cturquoise" value="Turquoise">Turquoise</option>
<option class="cgreen" value="Green">Green</option>
<option class="cred" value="Red">Red</option>
<option class="cpink" value="Pink">Pink</option>
<option class="corange" value="Orange">Orange</option>
<option class="cyellow" value="Yellow">Yellow</option>
</select></div></td>
      </tr>
    </table>
    <div id="container">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="10" height="28" id="navbar-l"></td>
          <td height="28" id="navbar-m"><table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="28"><div id="topnav"><ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=users">Members</a></li>
            <li><a href="index.php?page=viewnews">News</a></li>
            <li><a href="index.php?page=extra-stats">Stats</a></li>
            <li><a href="index.php?page=torrents">Torrents</a></li>
            <li><a href="index.php?page=upload">Upload</a></li>
            <li><a href="index.php?page=forum">Forum</a></li>
        </ul></div></td>
              <td id="nav-r" width="38" height="28"></td>
            </tr>
          </table></td>
          <td width="32" height="28" id="navbar-r"></td>
        </tr>
      </table>


<table width="100%" border="0" cellspacing="0" cellpadding="0">

</table><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="7" height="26" id="subhead-l"></td>
    <td height="26" id="subhead-m"></td>
    <td width="7" height="26" id="subhead-r"></td>
  </tr>
</table>
<if:HAS_AT>   
<br /> <center>  <tag:advertop /> </center>  
</if:HAS_AT>  
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="3" height="6" id="main-tl"></td>
    <td height="6" id="main-tm"></td>
    <td width="3" height="6" id="main-tr"></td>
  </tr>
</table>

<table align="center" width="100%" cellpadding="5" cellspacing="5" border="0" background="style/NB-007DTFM/images/main-m.png">
  <tr><td valign="top"><div id='dropdown'><tag:main_dropdown /><div></</td>
      </tr>
    </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="3" id="main-ml"></td>
    <td id="main-mm"><div id="main"><div>
      <if:guestt>  <div id="slideIt"></if:guestt>
        <div id="header">
        <table width="100%" cellpadding="0" cellspacing="6" border="0">
        <tr>
        <td valign="top"><tag:main_header /></td>
        </tr>
        </table>
        </div>
        </div>
    <div id="bodyarea">  
         <table border="0" align="center" cellpadding="0" cellspacing="6" width="100%">
         <tr>
         <if:HAS_LEFT_COL>
        <if:HAS_LEFT>
         <td class="scol" valign="top" width="185"><tag:main_left /></td>
        </if:HAS_LEFT_COL>
        </if:HAS_LEFT>
         <td id="ccol" valign="top"><tag:main_content /></td>
        <if:HAS_RIGHT_COL>
        <if:HAS_RIGHT>
         <td class="scol" valign="top" width="185"><tag:main_right /></td>
        </if:HAS_RIGHT_COL>
        </if:HAS_RIGHT>
         </tr>
         </table>

    </div>
        </div></div></td>
    <td width="3" id="main-mr"></td>
  </tr>
</table>




<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="3" id="main-ml"></td>
		<if:guesttt> <div id="slideIt2"><tag:main_slideIt2 /></if:guesttt>
        <td id="mcol" valign="top"><div id='bottom_menu'><tag:main_footer /><if:HAS_DIS><tag:news_text /><if:HAS_AB><center> <tag:adverbottom /> </center> <br /></if:HAS_AB></if:HAS_DIS></div></td>
</div>
    <td width="3" id="main-mr"></td>
  </tr>
</table>
    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="3" height="5" id="main-bl"></td>
    <td height="5" id="main-bm"></td>
    <td width="3" height="5" id="main-br"></td>
  </tr>
</table>
    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="7" height="56" id="footer-l"></td>
    <td height="56" align="center" valign="middle" id="footer-m"><div id="footer" valign="bottom" align="center"><tag:style_copyright /><tag:xbtit_debug /></div></td>
    <td width="7" height="56" id="footer-r"></td>
  </tr>
</table>
</div></td>
    <td id="body-r" width="67"></td>
  </tr>
</table>

<else:IS_DISPLAYED_2>
<div id="bodyarea" style="padding: 1ex 0ex 0ex 0ex;">  
<table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td valign="top" width="5" rowspan="2"></td>
      <td valign="top"><tag:main_content /></td>
    <td valign="top" width="5" rowspan="2"></td>
   </tr>
 </table>
</div>
</if:IS_DISPLAYED_2>

 <if:anon>     
<script src="<tag:protected />/jscript/anon.js" type="text/javascript"></script>
<script type="text/javascript"><!--
protected_links = "<tag:protected />";
auto_anonymize();
//--></script>
 </if:anon> 
</body>
</html>
