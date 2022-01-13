<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of XBTIT DT FM.
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

global $CURUSER, $user, $USERLANG, $FORUMLINK, $db_prefix,$btit_settings, $ipb_prefix,$baseurl,$STYLEURL ;

require_once(load_language("lang_account.php"));


         if (!$CURUSER || $CURUSER["id"]==1)
            {
            // guest-anonymous, login require
            ?>
            <form action="index.php?page=login" name="login" method="post">
            <table class="lista" border="0" align="center" width="100%">
            <tr><td style="text-align:center;" align="center" class="poller"><?php echo $language["USER_NAME"]?>:</td></tr><tr><td class="poller" style="text-align:center;" align="center"><input type="text" size="9" name="uid" value="<?php $user ?>" maxlength="40" /> </a></td></tr>
            <tr><td style="text-align:center;" align="center" class="poller"><?php echo $language["USER_PWD"]?>:</td></tr><tr><td class="poller" style="text-align:center;" align="center"><input type="password" size="9" name="pwd" maxlength="40" /></td></tr>
            <tr><td colspan="2" class="poller" style="text-align:center;" align="center"><input type="submit" value="<?php echo $language["FRM_LOGIN"]?>" /></td></tr>
            <tr><td class="lista" style="text-align:center;" align="center"><a class="user" href="index.php?page=signup"><?php echo $language["ACCOUNT_CREATE"]?></a></td></tr><tr><td class="lista" style="text-align:center;" align="center"><a class="user" href="index.php?page=recover"><?php echo $language["RECOVER_PWD"]?></td></tr>
            </table>
            </form>
            <?php
            }
         else
             {
// user information

// DT Uploader Medals
    $res=do_sqlquery("SELECT `up_med`  , `warns` , `reputation`, `trophy` FROM `{$TABLE_PREFIX}users` WHERE `id`=".$CURUSER["uid"]);
    $row=mysqli_fetch_assoc($res);

if ($row["up_med"] == 0)
{}
if ($row["up_med"] == 1)
$upl="<img src='images/goblet/medaille_bronze.gif' alt='Bronze Medal' title='Bronze Medal' />";

if ($row["up_med"] == 2)
$upl="<img src='images/goblet/medaille_argent.gif' alt='Silver Medal' title='Silver Medal' />";

if ($row["up_med"] >= 3)
$upl="<img src='images/goblet/medaille_or.gif' alt='Gold Medal' title='Gold Medal' />";
// DT Uploader Medals

// DT arcade
if ($row["trophy"] == 0)
$rra="";

if ($row["trophy"] == 1)
$rra= "<img src='images/crown.gif' alt='Arcade King' title='Arcade King' />";
// DT arcade
             $style=style_list();
             $langue=language_list();
             print("\n<form name=\"jump\" method=\"post\" action=\"index.php\">\n<table class=\"poller\" width=\"100%\" cellspacing=\"0\">\n<tr><td align=\"center\">".$language["USER_NAME"].":<a href='index.php?page=userdetails&id=".$CURUSER["uid"]."'>  " .user_with_color(unesc($CURUSER["username"] . immunity($CURUSER) . get_user_icons($CURUSER)),$CURUSER["prefixcolor"],$CURUSER["suffixcolor"]).$rra.$upl.warn($CURUSER)."</a></td></tr>\n");
             print("<tr><td align=\"center\">".$language["USER_LEVEL"].": ".$CURUSER["level"]."</td></tr>\n");

// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

if ($setrep["rep_is_online"]== 'false')
{
//do nothing
}
else
{
if ($row["reputation"] == 0)
$rep="<img src='images/rep/reputation_balance.gif' alt='" . $setrep["no_level"] . "' title='" . $setrep["no_level"] . "' />";

if ($row["reputation"] >= 1 )
$rep="<img src='images/rep/reputation_pos.gif' alt='" . $setrep["good_level"] . "' title='" . $setrep["good_level"] . "' />";

if ($row["reputation"] <= -1)
$rep="<img src='images/rep/reputation_neg.gif' alt='" . $setrep["bad_level"] . "' title='" . $setrep["bad_level"] . "' />";

if ($row["reputation"] >= 101 )
$rep="<img src='images/rep/reputation_highpos.gif' alt='" . $setrep["best_level"] . "' title='" . $setrep["best_level"] . "' />";

if ($row["reputation"] <= -101)
$rep="<img src='images/rep/reputation_highneg.gif' alt='" . $setrep["worse_level"] . "' title='" . $setrep["worse_level"] . "' />";

print("<tr><td align=\"center\">Reputation: ".$rep."</td></tr>\n");
}
// DT end reputation system

if ($CURUSER["avatar"] && $CURUSER["avatar"]!="")
print("\n<tr><td align=center class=poller><center><img  width=145 height=145 border=0 src=".unesc($CURUSER["avatar"])." /></center></td></tr>\n");
else
print("\n<tr><td align=center class=poller><center><img width=145 height=145 border=0 src=\"$STYLEURL/images/default_avatar.gif\"></center></td></tr>\n");
			 
?>
</table><br>
<table class="lista" width="100%">			 
<?php			 
if ($row["warns"] == 0)
$wl = "<img src='images/warned/warn_0.png'>";

if ($row["warns"] == 1 OR $row["warns"] == 2 )
$wl = "<img src='images/warned/warn_1.png'>";

if ($row["warns"] == 3 OR $row["warns"] == 4)
$wl = "<img src='images/warned/warn_2.png'>";

if ($row["warns"] == 5 OR $row["warns"] == 6)
$wl = "<img src='images/warned/warn_3.png'>";

print("<tr><td><center>".$wl."</td></tr>");
?>
</table><table class="lista" width="100%">

<?php             
$style=style_list();
$langue=language_list();

print("<tr><td><center><img src=\"images/speed_up.png\"><font size=\"1\" color=\"green\"> ".makesize($CURUSER['uploaded']));
print("<img src=\"images/speed_down.png\"><font size=\"1\" color=\"red\"> ".makesize($CURUSER['downloaded']));
print("</td></tr>");

print("<tr><td><center><img src=\"images/arany.png\"><font size=\"1\" color=\"yellow\"> ".($CURUSER['downloaded']>0?number_format($CURUSER['uploaded']/$CURUSER['downloaded'],2):"---")."</font>");
print("<a href=index.php?page=modules&module=seedbonus><img src=\"images/bonus.png\"> ".($CURUSER['seedbonus']>0?number_format($CURUSER['seedbonus'],2):"---")."</a></center>\n");
print("</td></tr>");
 
?>
</table> 

<table class="lista" border="0" align="center" width="100%">
<?php
			  
             print("<tr><td align=\"center\">");
             include("include/offset.php");
             print($language["USER_LASTACCESS"].":<br />".date("d/m/Y H:i:s",$CURUSER["lastconnect"]-$offset));
             print("</select>");
             print("</td>\n</tr>\n");

if($btit_settings["hide_style"]=="visible")
{ 
             print("<tr><td align=\"center\">");             
             print($language["USER_STYLE"].":<br />\n<select name=\"style\" size=\"1\" onchange=\"location=document.jump.style.options[document.jump.style.selectedIndex].value\">");
             foreach($style as $a)
                            {
                            print("<option ");
                            if ($a["id"]==$CURUSER["style"])
                               print("selected=\"selected\"");
                            print(" value=\"account_change.php?style=".$a["id"]."&amp;returnto=".urlencode($_SERVER['REQUEST_URI'])."\">".$a["style"]."</option>");
                            }
             print("</select>");
             print("</td></tr>");
}             
if($btit_settings["hide_language"]=="visible")
{             
             print("<tr><td align=\"center\">");
             print($language["USER_LANGUE"].":<br />\n<select name=\"langue\" size=\"1\" onchange=\"location=document.jump.langue.options[document.jump.langue.selectedIndex].value\">");
             foreach($langue as $a)
                            {
                            print("<option ");
                            if ($a["id"]==$CURUSER["language"])
                               print("selected=\"selected\"");
                            print(" value=\"account_change.php?langue=".$a["id"]."&amp;returnto=".urlencode($_SERVER['REQUEST_URI'])."\">".$a["language"]."</option>");
                            }
             print("</select>");
             print("</td></tr>");
}
             print("\n<tr><td align=\"center\"><a class=\"user\" href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."\"><img src=\"images/user.png\" /></a>\n");
             if ($CURUSER["admin_access"]=="yes")
                print("<a class=\"user\" href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."\"><img src=\"images/staff.png\" /></a>\n");
                
             if(substr($FORUMLINK,0,3)=="smf")
                 $resmail=get_result("SELECT `unread".(($FORUMLINK=="smf")?"M":"_m")."essages` `ur` FROM `{$db_prefix}members` WHERE ".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")."=".$CURUSER["smf_fid"],true,$btit_settings['cache_duration']);
             elseif($FORUMLINK=="ipb")
                 $resmail=get_result("SELECT `msg_count_new` `ur` FROM `{$ipb_prefix}members` WHERE `member_id`=".$CURUSER["ipb_fid"],true,$btit_settings['cache_duration']);
             else
                 $resmail=get_result("SELECT COUNT(*) as ur FROM {$TABLE_PREFIX}messages WHERE readed='no' AND receiver=$CURUSER[uid]",true,$btit_settings['cache_duration']);
             if ($resmail && count($resmail)>0)
                {
                 $mail=$resmail[0];
                 if ($mail['ur']>0)
                    print("<a class=\"user\" href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."&amp;do=pm&amp;action=list\"><img src=\"images/mailbox.png\" /></a> (<font color=\"#FF0000\"><b>".$mail['ur']."</b></font>)");
                 else
                     print("<a class=\"user\" href=\"index.php?page=usercp&amp;uid=".$CURUSER["uid"]."&amp;do=pm&amp;action=list\"><img src=\"images/mailbox.png\" /></a>");
                }
             else
                 print("<img src=\"images/mailbox.png\" />");
if($btit_settings["speedsw"]==true)
                 print("\n<tr><td align=\"center\"><a class=\"user\" href=\"index.php?page=modules&module=speedtest\"><img src=\"images/speed.png\" /></a></tr></td>\n");
if($btit_settings["ownip"]==true)
{                 
$IP = $_SERVER['REMOTE_ADDR']; // Get IP
print("\n<tr><td align=\"center\" class=\"header\">IP: $IP</tr></td>");
}                 

             print("</td></tr></table>\n</form>");
}
?>