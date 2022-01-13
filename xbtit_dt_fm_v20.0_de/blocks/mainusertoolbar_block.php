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

global $CURUSER, $INVITATIONSON, $FORUMLINK, $db_prefix, $btit_settings, $language, $ipb_prefix;

?>
<script type="text/javascript">
function newpm() {
<!--
var answer = confirm("You got unread mail ! , go to your inbox to read it before you proceed , else this popup will keep pestering you ;)")
if (answer)
window.location='index.php?page=usercp&uid=<?php echo $CURUSER["uid"]; ?>&do=pm&action=list'
// -->
}
</script>
<?php

  if (isset($CURUSER) && $CURUSER && $CURUSER["uid"]>1)
  {
  print("<form name=\"jump1\" action=\"index.php\" method=\"post\">\n");
?>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<?php
$style=style_list();
$langue=language_list();
$block[0]["id"]="yes";
$block[0]["block"]="side blocks";
$block[1]["id"]="nol";
$block[1]["block"]="no left";
$block[2]["id"]="nor";
$block[2]["block"]="no right";
$block[3]["id"]="no";
$block[3]["block"]="no blocks";

// group image
$rsr= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT picture FROM {$TABLE_PREFIX}users_level WHERE id_level=".$CURUSER['id']);
$rosr= mysqli_fetch_array($rsr);

if ($rosr["picture"]=='')
$xx='';
else
$xx='<img src="images/ul/'.$rosr["picture"].'">';
// group image

//nat - max torrents
$resuser=do_sqlquery("SELECT connectable , id_level, pid FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER["uid"]);
$con= mysqli_fetch_array($resuser);

if($con["connectable"]=="yes")
    $conn="<img src=\"images/good.png\">";
elseif($con["connectable"]=="no")
    $conn="<img src=\"images/nat.png\">";
else
    $conn="<img src=\"images/unknow.png\">";
//nat

print("<td style=\"text-align:center;\" align=\"center\">".$xx."</td>\n");
print("<td class=\"green\" align=\"center\"> <img src=\"images/speed_up.png\"> ".makesize($CURUSER['uploaded']));
print("</td><td class=\"red\" align=\"center\"> <img src=\"images/speed_down.png\">  ".makesize($CURUSER['downloaded']));
print("</td><td class=\"yellow\" align=\"center\"> <img src=\"images/arany.png\"> ".($CURUSER['downloaded']>0?number_format($CURUSER['uploaded']/$CURUSER['downloaded'],2):"---")."</td>\n");
      print("<td class=\"green\" align=\"center\"><a href=index.php?page=modules&module=seedbonus><img src=\"images/bonus.png\"> ".($CURUSER['seedbonus']>0?number_format($CURUSER['seedbonus'],2):"---")."</a></td>\n");

//slots hack
$set=do_sqlquery("SELECT maxtorrents FROM {$TABLE_PREFIX}users_level WHERE id =".$con["id_level"]);
$seti=mysqli_fetch_array($set);

$slots=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) FROM {$TABLE_PREFIX}peers WHERE pid ='".$con["pid"]."'");

if ($slots && mysqli_num_rows($slots)>0)
   {
    $seta=mysqli_fetch_row($slots);
    if ($seta[0]>0){
print("<td align=\"center\"><a href=index.php?page=modules&module=slots><font color=\"steelblue\"><img src=\"images/slots.png\"><font color=\"red\">&nbsp;$seta[0]&nbsp;<font color=\"steelblue\"> /<font color=green>".($seti['maxtorrents'])."<font color=\"steelblue\"></font></a></td>\n");
    }else
print("<td align=\"center\"><a href=index.php?page=modules&module=slots><font color=\"steelblue\"><img src=\"images/slots.png\"><font color=\"red\">&nbsp;0&nbsp;<font color=\"steelblue\">/<font color=green>".($seti['maxtorrents'])."<font color=\"steelblue\"></font></a></td>\n");
   }
else
print("<td align=\"center\"><a href=index.php?page=modules&module=slots><font color=\"steelblue\"><img src=\"images/slots.png\"><font color=\"red\">&nbsp;0&nbsp;<font color=\"steelblue\">/<font color=green>".($seti['maxtorrents'])."<font color=\"steelblue\"></font></a></td>\n");
// end slots hack     
if($btit_settings["nat"]==true)
print("<td style=\"text-align:center;\" align=\"center\"><a class=\"mainuser\" href=\"index.php?page=modules&module=nat\">".$conn."</a></td>\n");      

print("<td style=\"text-align:center;\" align=\"center\"><a class=\"mainuser\" href=\"index.php?page=flush\"><img src=\"images/ghost.png\" /></a></td>\n");    
print("<td style=\"text-align:center;\" align=\"center\"><a class=\"mainuser\" href=\"index.php?page=friendlist\"><img src=\"images/friend.png\" /></a></td>\n"); 

if ($CURUSER["admin_access"]=="yes" AND $btit_settings["slon"]==true) 
print("<td style=\"text-align:center;\" align=\"center\"><a class=\"mainuser\" href=\"index.php?page=shitlist\"><img src=\"images/shit.png\" /></a></td>\n"); 
    
if ($CURUSER["admin_access"]=="yes")
print("\n<td align=\"center\" style=\"text-align:center;\"><a class=\"mainuser\" href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."\"><img src=\"images/staff.png\" /></a></td>\n");

print("<td style=\"text-align:center;\" align=\"center\"><a class=\"mainuser\" href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."\"><img src=\"images/user.png\" /></a></td>\n");
if($btit_settings["noteon"]==true)
print("<td style=\"text-align:center;\" align=\"center\"><a href=\"index.php?page=notepad\"><img src=\"images/note.png\" /></a></td>\n");


if($INVITATIONSON)
{
    require(load_language("lang_usercp.php"));
    $resinvs=do_sqlquery("SELECT invitations FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER["uid"]);
    $arrinvs=mysqli_fetch_row($resinvs);
    $invs=$arrinvs[0];
    print("<td style=\"text-align:center;\" align=\"center\"><a href=\"index.php?page=usercp&do=invite&action=read&uid=".$CURUSER["uid"]."\"><img src=\"images/Invitation.png\" />".($invs>0?"(".$invs.")":"")."</a></td>\n");
}

if(substr($FORUMLINK, 0, 3)=="smf")
    $resmail=get_result("SELECT `unread".(($FORUMLINK=="smf")?"M":"_m")."essages` `ur` FROM `{$db_prefix}members` WHERE ".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")."=".$CURUSER["smf_fid"],true,$btit_settings['cache_duration']);
elseif($FORUMLINK=="ipb")
    $resmail=get_result("SELECT `msg_count_new` `ur` FROM `{$ipb_prefix}members` WHERE `member_id`=".$CURUSER["ipb_fid"],true,$btit_settings['cache_duration']);
else
    $resmail=get_result("SELECT COUNT(*) `ur` FROM `{$TABLE_PREFIX}messages` WHERE `readed`='no' AND `receiver`=".$CURUSER["uid"],true,$btit_settings['cache_duration']);
if ($resmail && count($resmail)>0)
   {
    $mail=$resmail[0];
    if ($mail['ur']>0)
    {
if($btit_settings["pmpop"]==true)     
if ($_GET['do'] <> "pm") print( "<script language=\"javascript\">newpm();</script>");

       print("<td style=\"text-align:center;\" align=\"center\"><a class=\"mainuser\" href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."&amp;do=pm&amp;action=list\"><img src=\"images/mailbox.png\" /></a> (<font color=\"#FF0000\"><b>".$mail['ur']."</b></font>)</td>\n");
       }
    else
        print("<td style=\"text-align:center;\" align=\"center\"><a class=\"mainuser\" href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."&amp;do=pm&amp;action=list\"><img src=\"images/mailbox.png\" /></a></td>\n");
   }
else
    print("<td style=\"text-align:center;\" align=\"center\"><a class=\"mainuser\" href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."&amp;do=pm&amp;action=list\"><img src=\"images/mailbox.png\" /></a></td>\n");

if($btit_settings["hide_style"]=="visible")
{
print("\n<td style=\"text-align:center;\"><select name=\"style\" size=\"1\" onchange=\"location=document.jump1.style.options[document.jump1.style.selectedIndex].value\">");
foreach($style as $a)
               {
               print("<option ");
               if ($a["id"]==$CURUSER["style"])
                  print("selected=\"selected\"");
               print(" value=\"account_change.php?style=".$a["id"]."&amp;returnto=".urlencode($_SERVER['REQUEST_URI'])."\">".$a["style"]."</option>");
               }
print("</select></td>");
}

if($btit_settings["hide_language"]=="visible")
{
print("\n<td style=\"text-align:center;\"><select name=\"langue\" size=\"1\" onchange=\"location=document.jump1.langue.options[document.jump1.langue.selectedIndex].value\">");
foreach($langue as $a)
               {
               print("<option ");
               if ($a["id"]==$CURUSER["language"])
                  print("selected=\"selected\"");
               print(" value=\"account_change.php?langue=".$a["id"]."&amp;returnto=".urlencode($_SERVER['REQUEST_URI'])."\">".$a["language"]."</option>");
               }
print("</select></td>");
}
if($btit_settings["hide_sblocks"]=="visible")
{
print("\n<td style=\"text-align:center;\"><select name=\"block\" size=\"1\" onchange=\"location=document.jump1.block.options[document.jump1.block.selectedIndex].value\">");
foreach($block as $a)
               {
               print("<option ");
               if ($a["id"]==$CURUSER["left_l"])
                  print("selected=\"selected\"");
              print(" value=\"account_change.php?block=".$a["id"]."&amp;returnto=".urlencode($_SERVER['REQUEST_URI'])."\">".$a["block"]."</option>");
               }
print("</select></td>");
}
print("<td style=\"text-align:right; padding-right:24px;\" align=\"center\"><a href=\"index.php?page=bookmark&amp;uid=".$CURUSER["uid"]."\"><img src=\"images/bookmark.png\" /></a></td>\n");
if  ($btit_settings["ref_on"] == true)
print("<td style=\"text-align:right; padding-right:24px;\" align=\"center\"><a class=\"mainuser\" href=\"index.php?page=modules&module=referral \"><img src=\"images/referral.png\" /></a></td>\n"); 

?>
</tr>
</table>
</form>
<?php
}
else
{
    session_name("xbtit");
    session_start();
    $_SESSION=array();
    setcookie("xbtit", "", time()-3600, "/");
    session_destroy();

    if (!isset($user)) $user = '';
if($btit_settings["log_sw_dt"]=='diem')
    {
    ?>
    <form action="index.php?page=login" name="login" method="post">
   <center>  <div id="diemthuy" >  
    <table class="lista" border="0" width="100%" cellpadding="4" cellspacing="1" align="right">

      <tr>
      <br />
      
      <tr>
      <td align="right" class="lista">&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/SignOpen24Hours.gif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td align="right" class="lista"><font color="yellow"><b><?php echo $language["USER_NAME"]?>:</b></td>
      <td class="lista" style="padding-left:5px;"><input type="text" size="15" name="uid" id="want_username" value="<?php $user ?>" maxlength="40" style="font-size:10px;" /></td>
      <td align="right" class="lista"><font color="yellow"><b><?php echo $language["USER_PWD"]?>:</b></td>
      <td class="lista" style="padding-left:5px;"><input type="password" size="15" name="pwd" id="want_password" maxlength="40" style="font-size:10px;" /></td>
      <td class="lista" align="center" style="padding-left:10px;"><input type="submit" value="<?php echo $language["FRM_LOGIN"]?>" style="font-size:10px;" /></td></tr>
      <?php
    if($btit_settings["fbon"]==true)
    {
    ?>	  
	  <td align="right" class="lista"><br />&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript: void(0);" onclick="window.location ='index.php?page=facebooklogin' "><img src="images/fbconnect.png" border="0"></a></td>
      <?php
      }
    ?>
      
      </tr> </table> <br /><br /><br /><br /><br /><br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /><br />
       <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /><table class="lista" border="0" width="38%" cellpadding="4" cellspacing="1" align="right" >
       <tr>
       <?php
       if ($btit_settings["ua_on"]== true)
{ ?>
    <td class="lista" align="right"><a class="lista"  href="index.php?page=agree"><img src="images/signup.png" /></a><a class="lista"  href="index.php?page=recover">&nbsp;&nbsp;&nbsp;<img src="images/recover.png" /></a></td>
    <?php
    }
    else
    {
    ?>
      <td class="lista" align="right"><a class="lista"  href="index.php?page=account"><img src="images/signup.png" /></a><a class="lista"  href="index.php?page=recover">&nbsp;&nbsp;&nbsp;<img src="images/recover.png" /></a></td>
	<?php
	}    
    ?> </tr>
    </table> </div> </center>
    </form>
    <?php
    }
if($btit_settings["log_sw_dt"]=='regular')
{
    ?>
    <form action="index.php?page=login" name="login" method="post">
    <table class="lista" border="0" width="100%" cellpadding="4" cellspacing="1">
    <tr>
    <td class="lista" align="left">
      <table border="0" cellpadding="0" cellspacing="0">
      <tr>
      <td class="lista" style="text-align:left; padding-left:27px;"><?php echo $language["USER_NAME"]?>:&nbsp;</td>
      <td class="lista"><input type="text" size="15" name="uid" value="<?php $user ?>" maxlength="40" style="font-size:10px" />&nbsp;&nbsp;</td>
      <td class="lista" style="text-align:left; padding-left:17px;"><?php echo $language["USER_PWD"]?>:&nbsp;</td>
      <td class="lista"><input type="password" size="15" name="pwd" maxlength="40" style="font-size:10px" />&nbsp;</td>
      <td class="lista" align="center"><input type="submit" value="<?php echo $language["FRM_LOGIN"]?>" style="font-size:10px" /></td>
      </tr>
      </table>
       <?php
    if($btit_settings["fbon"]==true)
    {
    ?>	     
      <td><a href="javascript: void(0);" onclick="window.location ='index.php?page=facebooklogin' "><img src="images/fbconnect.png" border=0></a></td>
      <?php
      }
    ?>
    </td>
<?php
if ($btit_settings["ua_on"]== true)
print("<td style=\"text-align:center;\" align=\"center\"><a href=\"index.php?page=agree \">".$language["ACCOUNT_CREATE"]."</a></td>\n");
else
print("<td style=\"text-align:center;\" align=\"center\"><a href=\"index.php?page=account \">".$language["ACCOUNT_CREATE"]."</a></td>\n");
     
?>
    <td class="lista" align="center"><a class="mainuser"  href="index.php?page=recover"><?php echo $language["RECOVER_PWD"]?></a></td>
    </tr>
    </table>
    </form>
    <?php	
}
if($btit_settings["log_sw_dt"]=='yupy')
{
// jquery login
if($btit_settings["logisw"]==false)
{
?>
<link rel="stylesheet" href="css_login.css" type="text/css" />
<?php
}
else
{
?>
<link rel="stylesheet" href="css_login_dt.css" type="text/css" />
<?php
}
?>

<script type="text/javascript">

animatedcollapse.addDiv('yupylogin','fade=1,height=auto')
animatedcollapse.addDiv('yupyrecover','fade=1,height=auto')
animatedcollapse.addDiv('yupysignup','fade=1,height=auto')


animatedcollapse.ontoggle=function($, divobj, state){ }

animatedcollapse.init()

</script>
<div align="center" style="margin-top:1%;">&nbsp;&nbsp;

<img class="login" style="cursor:pointer" src="images/pic/blank.gif" onclick="javascript:animatedcollapse.toggle('yupylogin'); javascript:animatedcollapse.hide('yupyrecover'); javascript:animatedcollapse.hide('yupysignup');javascript:animatedcollapse.hide('yupykontakt')" alt="login" />&nbsp;

<img class="recover" style="cursor:pointer" src="images/pic/blank.gif" onclick="javascript:animatedcollapse.toggle('yupyrecover'); javascript:animatedcollapse.hide('yupylogin');javascript:animatedcollapse.hide('yupysignup');javascript:animatedcollapse.hide('yupykontakt')" alt="recover" />&nbsp;

<?php
if ($btit_settings["ua_on"]== true)
{
?>
<a href="index.php?page=agree" class="normal" target="_parent"><img class="signup" style="cursor:pointer" src="images/pic/blank.gif" alt="signup" /></a>&nbsp;
<?php
}
else
{
?> 
<a href="index.php?page=signup" class="normal" target="_parent"><img class="signup" style="cursor:pointer" src="images/pic/blank.gif" alt="signup" /></a>&nbsp;
<?php
}
?>
<div id="yupylogin" style="display:none">
<form action="index.php?page=login" name="login" method="post">

<table class="lista" border="0" cellpadding="10">
<tr><td class="tboxhead"></td></tr>
<tr><td align="center" class="tboxmidd"><pre><font size="3">User Name</font>:&nbsp;<input type="text" size="40" name="uid" value="<?php $user ?>" maxlength="40" /></pre></td></tr>
<tr><td align="center" class="tboxmidd"><pre><font size="3">Password</font>:&nbsp;<input type="password" size="40" name="pwd" maxlength="40" /></pre></td></tr>
<tr><td colspan="2" class="tboxmidd" align="center"><input type="submit" value="Login" /></td></tr>
<tr><td colspan="2" class="tboxmidd" align="center"><font size=2>You Need Cookies Enabled</font></td></tr>
<tr><td class="tboxfoot"></td></tr>
</table>
</form>
</div>
<br>
<?php
global $USE_IMAGECODE;
if ($USE_IMAGECODE)
{
if (extension_loaded('gd'))
{
$arr = gd_info();
if ($arr['FreeType Support']==1)
{
$p=new ocr_captcha();
$reksec=($p->display_captcha(true));
$private=$p->generate_private();
}
else
{
include("include/security_code.php");
$scode_index = rand(0, count($security_code) - 1);
$scode="<input type=hidden name=security_index value=$scode_index />n";
$scode.=$security_code[$scode_index]["question"];
$reksec=$scode;
}
}
else
{
include("include/security_code.php");
$scode_index = rand(0, count($security_code) - 1);
$scode="<input type=hidden name=security_index value=$scode_index />n";
$scode.=$security_code[$scode_index]["question"];
$reksec=$scode;
}
}
else
{
include("include/security_code.php");
$scode_index = rand(0, count($security_code) - 1);
$scode="<input type=hidden name=security_index value=$scode_index />n";
$scode.=$security_code[$scode_index]["question"];
$reksec=$scode;
}

?>
<div id="yupyrecover" style="display:none">
<div align="center">
<form action="index.php?page=recover&amp;act=takerecover" name="recover" method="post">
<table class="lista" border="0" cellpadding="15">
<tr><td class="tboxhead"></td></tr>
<tr><td align="center" class="tboxmidd"><pre><font size="3">Email:</font><input type=text size=40 name=email></pre></td></tr>
<tr>
<td colspan="2" align="center" class="tboxmidd"><pre><pre><font size="3">Security code: <?php echo $reksec ;?> </font><input type="text" id="captcha" name="<?php echo ($USE_IMAGECODE?"private_key":"scode_answer");?>" maxlength="6" size="6" value="" /></pre></td>
</tr>

<tr><td colspan="2" class="tboxmidd" align="center"><input type="submit" value="Send" /></td></tr>
<tr><td class="tboxfoot"></td></tr>
</table>
</form>
</div>
<br />
</div>
</center>
<?php
// jquery login	
}
}
?>