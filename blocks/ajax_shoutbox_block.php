<?php
 
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Redistribution and use in source and binary forms, with or without modification,
// are permitted provided that the following conditions are met:
//
//   1. Redistributions of source code must retain the above copyright notice,
//      this list of conditions and the following disclaimer.
//   2. Redistributions in binary form must reproduce the above copyright notice,
//      this list of conditions and the following disclaimer in the documentation
//      and/or other materials provided with the distribution.
//   3. The name of the author may not be used to endorse or promote products
//      derived from this software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR IMPLIED
// WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
// MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
// IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
// SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
// TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
// PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
// LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
// NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
// EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
//
////////////////////////////////////////////////////////////////////////////////////

  #################################################################
  #
  #         Ajax MySQL shoutbox for btit
  #         Version 1.0
  #         Author: miskotes
  #         Created: 11/07/2007
  #         Contact: miskotes [at] yahoo.co.uk
  #         Website: http://www.yu-corner.com
  #         Credits: linuxuser.at, plasticshore.com
  #
  #################################################################


$getsbox = @mysqli_fetch_array(@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER["uid"]));

    $sbox = ("$getsbox[sbox]");
if($sbox=="no"){

block_begin(SHOUTBOX);
global $btit_settings ;
  
if ($CURUSER["view_shout"]=="yes") {
  
  require_once("include/smilies.php");
  require_once("shoutfun.php");
  
  if (!isset($CURUSER)) global $CURUSER,$btit_settings,$tpl;
  
$switch=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT status FROM {$TABLE_PREFIX}blocks WHERE content = 'featured'");
$arco=mysqli_fetch_array($switch);
if ($arco["status"]=='0' AND $btit_settings["shoutdel"] == true )
{
?>
<script language="javascript" type="text/javascript" src="jscript/jquery.js"></script>
<?php 
} 

if($btit_settings["bling"]==true)
print "<script src='ajaxchat/scripts.js' language='JavaScript' type='text/javascript'></script>";
else
print "<script src='ajaxchat/scriptsdt.js' language='JavaScript' type='text/javascript'></script>";
print "<script type='text/javascript' src='jscript/wall.js'></script>";

  function smile() {

    print "<div align='center'><table cellpadding='1' cellspacing='1'><tr>";

    global $smilies, $count;
    reset($smilies);

    while ((list($code, $url) = each($smilies)) && $count<16) {
          print("\n<td><a href=\"javascript: SmileIT('".str_replace("'","\'",$code)."')\">
                <img border=\"0\" src=\"images/smilies/$url\" alt=\"$code\" /></a></td>");
               
          $count++;
    }
  
    print "<td>&nbsp<a href=\"javascript:show_hide('sextra');\"><img order=\"0\" src=\"images/down.gif\" title=\"more\"></a></td></tr></table></div>";
  }
function sextra() {

  global $smilies;
  reset($smilies);
  
    # getting smilies
    while (list($code, $url) = each($smilies)) { 
        print("\n<a href=\"javascript: SmileIT('".str_replace("'","\'",$code)."')\">
               <img border=\"0\" src=\"images/smilies/$url\" alt=\"$code\" /></a>");
 
        $count++;
    }
  
 }
?>

<center>

 <div id="chat">
 
  <div id="chatoutput">

      <ul id="outputList">

        <li>
          <span class="name">XBTIT DT FM SHOUT:</span><h2 style='padding-left:20px;'><?php echo $language["WELCOME"] ?></h2>
          
            <center><div class="loader"></div></center>

          </li>

      </ul>

  </div>
    
</div>
<?php

if($btit_settings["bling"]==true)
{
?>   
<div id="wrapper"> </div>
<?php
}
?>
 <div id="shoutheader">
     
    <form id="chatForm" name="chatForm" onsubmit="return false;" action="">
    
      <input type="hidden" name="name" id="name" value="<?php echo $CURUSER["username"] ?>" />
      <input type="hidden" name="uid" id="uid" value="<?php echo $CURUSER["uid"] ?>" />
      <input type="text" size="45" maxlength="500" name="chatbarText" id="chatbarText" onblur="checkStatus('');" onfocus="checkStatus('active');" /> 
      <input onclick="sendComment();" type="submit" id="submit" name="submit" value="<?php echo $language["FRM_CONFIRM"]; ?>" />
      &nbsp;
      <a href="javascript: PopMoreSmiles('chatForm','chatbarText');">
      <img src="images/smile.gif" border="0" class="form" title="<?php echo $language['MORE_SMILES']; ?>" align="top" alt="" /></a>
  
      <a href="javascript: Pophistory()">
      <img src="images/quote.gif" border="0" class="form" title="<?php echo $language['HISTORY']; ?>/Moderate" align="top" alt="" /></a>

      <br />
      <?php shoutfun('chatForm','chatbarText'); ?><br>
      <?php smile(); ?><div style="display: none;" id="sextra"><br><?php sextra(); ?></div>
      
    </form>

 </div>
<script language="JavaScript">

function show_hide(sextra)
{
  if(document.getElementById(sextra))
  {
    if(document.getElementById(sextra).style.display == 'none')
    {
      document.getElementById(sextra).style.display = 'inline';
    }
    else
    {
      document.getElementById(sextra).style.display = 'none';
    }
  }
}

</script>
</center>

<?php

} else print "<div align=\"center\">".$language["NOT_AUTHORIZED"]." ".$language["SHOUTBOX"]."</div>";

block_end();}else{
print("<br><center><img src=images/denied.gif><br>Sorry you are banned from shout!<br>You will need to speak to a member of staff");
}

?>