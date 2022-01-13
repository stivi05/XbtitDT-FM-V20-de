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


if (!defined("IN_BTIT"))
      die("non direct access!");


// load language file
require(load_language("lang_userdetails.php"));

$id=intval(0+$_GET["id"]);
if (!isset($_GET["returnto"])) $_GET["returnto"] = "";
$link=rawurlencode($_GET["returnto"]);

if ($CURUSER["view_users"]!="yes")
   {
       err_msg($language["ERROR"],$language["NOT_AUTHORIZED"]." ".$language["MEMBERS"]);
       stdfoot();
       die();
   }

if ($id==1)
   { // trying to view guest details?
       err_msg($language["ERROR"],$language["GUEST_DETAILS"]);
       stdfoot();
       die();
   }

if ($XBTT_USE)
   {
    $tseeds="f.seeds+ifnull(x.seeders,0)";
    $tleechs="f.leechers+ifnull(x.leechers,0)";
    $tcompletes="f.finished+ifnull(x.completed,0)";
    $ttables="{$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON x.info_hash=f.bin_hash";
    $udownloaded="u.downloaded+IFNULL(x.downloaded,0)";
    $uuploaded="u.uploaded+IFNULL(x.uploaded,0)";
    $utables="{$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id";
   }
else
    {
    $tseeds="f.seeds";
    $tleechs="f.leechers";
    $tcompletes="f.finished";
    $ttables="{$TABLE_PREFIX}files f";
    $udownloaded="u.downloaded";
    $uuploaded="u.uploaded";
    $utables="{$TABLE_PREFIX}users u";
    }


if ($id>1) {
   $res=get_result("SELECT u.style,u.team,u.gender,ul.prefixcolor,ul.suffixcolor,u.dona,u.donb,u.birt,u.mal,u.fem,u.bann,u.war,u.par,u.bot,u.trmu,u.trmo,u.vimu,u.vimo,u.friend,u.junkie,u.staff ,u.sysop,  u.tot_on, u.booted, u.whybooted, u.whobooted, u.addbooted, u.ban,  u.usercounter, u.browser, u.invisible, u.modcomment, u.supcomment, u.clientinfo, u.profileview, u.reputation, u.invited_by, u.invitations, u.immunity,  u.dob, u.custom_title, u.warn, u.warnreason,u.warns, u.warnadded, u.warnaddedby, u.donor,u.id_level,u.old_rank, u.timed_rank, u.rank_switch,  u.seedbonus, u.avatar,u.email,u.cip,u.username,$udownloaded as downloaded,$uuploaded as uploaded,UNIX_TIMESTAMP(u.joined) as joined,UNIX_TIMESTAMP(u.lastconnect) as lastconnect,ul.level, u.flag, c.name, c.flagpic, u.pid, u.time_offset, u.smf_fid, u.ipb_fid FROM $utables INNER JOIN {$TABLE_PREFIX}users_level ul ON ul.id=u.id_level LEFT JOIN {$TABLE_PREFIX}countries c ON u.flag=c.id WHERE u.id=$id",true,$btit_settings['cache_duration']);
   $num=count($res);
   if ($num==0)
      {
       err_msg($language["ERROR"],$language["BAD_ID"]);
       stdfoot();
       die();
       }
   else {
        $row=$res[0];
      }
}
else
      {
       err_msg($language["ERROR"],$language["BAD_ID"]);
       stdfoot();
       die();
       }

if ($row["profileview"] ==1 && $CURUSER["id_level"] <=6 && $CURUSER["uid"] != $id) {
       redirect("index.php?page=private&id=$id");
       }

include("include/offset.php");

//Profile Status by Yupy Start
    $status_sql = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}profile_status WHERE userid = ".sqlesc($id));
    if (mysqli_num_rows($status_sql)) 
	    $profile_status = mysqli_fetch_assoc($status_sql);
    else 
        $profile_status = array('last_status' => 'Not yet added a status', 'last_update' => time());
//Profile Status by Yupy End

if ($row["ban"] == 'yes')
{
$banp = "<img src='images/ban.gif'>";
}
else
{
$banp ="";
}
// user's ratio
if (intval($row["downloaded"])>0)
 {
   $sr = $row["uploaded"]/$row["downloaded"];
   if ($sr >= 4)
     $s = "images/smilies/thumbsup.gif";
   else if ($sr >= 2)
     $s = "images/smilies/grin.gif";
   else if ($sr >= 1)
     $s = "images/smilies/smile1.gif";
   else if ($sr >= 0.5)
     $s = "images/smilies/noexpression.gif";
   else if ($sr >= 0.25)
     $s = "images/smilies/sad.gif";
   else
     $s = "images/smilies/thumbsdown.gif";
  $ratio=number_format($sr,2)."&nbsp;&nbsp;<img src=\"$s\" alt=\"\" />";
 }
else
   $ratio='&#8734;';

$utorrents = intval($CURUSER["torrentsperpage"]);

$userdetailtpl= new bTemplate(); 

// userstyle DT
$sg = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}style WHERE id = ".$row["style"]);
$srg=mysqli_fetch_array($sg);

$userdetailtpl->set("style",$srg["style"]);
// userstyle DT

// online start
 $onoff = mysqli_fetch_array(@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT u.lastconnect, o.lastaction FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id WHERE u.id=".$id));

(is_null($onoff["lastaction"])?$lastseen=$onoff["lastconnect"]:$lastseen=$onoff["lastaction"]);
((time()-$lastseen>900)?$status="<img src='images/f1offline.gif' border='0' title='Offline' alt='".$language["OFFLINE"]."'>":$status="<img src='images/f1online.gif' border='0' title='Online' alt='".$language["ONLINE"]."'>");
$userdetailtpl-> set("onll",$status); 
// online end

$hmm=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}ignore WHERE ignore_id = ".$id." AND user_id = ".$CURUSER['uid']);
if (mysqli_num_rows($hmm)){
if ($row["id_level"]<6)
$userdetailtpl-> set("ign","<font color=orange>This user is already ignored</font>");  
} 
else
if ($row["id_level"]<6)
$userdetailtpl-> set("ign","<a href=index.php?page=usercp&uid=".$CURUSER["uid"]."&do=ignore&action=add&ignore_id=".$id."><font color=orange>Set this user to Ignored</font></a>");       
if ($row["id_level"]>5)
$userdetailtpl-> set("ign","<font color=orange>Staff can not Ignored</font>");      

  global $btit_settings , $INVITATIONSON;
// user image

    $do=$btit_settings["img_don"];
    $don=$btit_settings["img_donm"];
    $ma=$btit_settings["img_mal"];
    $fe=$btit_settings["img_fem"];
    $ba=$btit_settings["img_ban"];
    $tu=$btit_settings["img_tru"];
    $vi=$btit_settings["img_vip"];
    $wa=$btit_settings["img_war"];
    $st=$btit_settings["img_sta"];
    $bi=$btit_settings["img_bir"];
    $pa=$btit_settings["img_par"];
    $sy=$btit_settings["img_sys"];
    $vip=$btit_settings["img_vipm"];
    $tut=$btit_settings["img_trum"];  
    $fr=$btit_settings["img_fri"];
    $ju=$btit_settings["img_jun"]; 
    $bo=$btit_settings["img_bot"];
    

$udo="";
$udob="";
$ubir="";
$umal="";
$ufem="";
$uban="";
$uwar="";
$upar="";
$ubot="";
$utrmu="";
$utrmo="";
$uvimu="";
$uvimo="";
$ufrie="";
$ujunk="";
$ustaf="";
$usys="";

if ($row["dona"] == 'yes')
$udo= "&nbsp;<img src='images/user_images/" . $do . "' alt='" . $btit_settings["text_don"] . "' title='" . $btit_settings["text_don"] . "' />";

if ($row["donb"] == 'yes')
$udob= "&nbsp;<img src='images/user_images/" . $don . "' alt='" . $btit_settings["text_donm"] . "' title='" . $btit_settings["text_donm"] . "' />";

if ($row["birt"] == 'yes')
$ubir= "&nbsp;<img src='images/user_images/" . $bi . "' alt='" . $btit_settings["text_bir"] . "' title='" . $btit_settings["text_bir"] . "' />";

if ($row["mal"] == 'yes')
$umal= "&nbsp;<img src='images/user_images/" . $ma . "' alt='" . $btit_settings["text_mal"] . "' title='" . $btit_settings["text_mal"] . "' />";

if ($row["bann"] == 'yes')
$uban= "&nbsp;<img src='images/user_images/" . $ba . "' alt='" . $btit_settings["text_ban"] . "' title='" . $btit_settings["text_ban"] . "' />";

if ($row["war"] == 'yes')
$uwar= "&nbsp;<img src='images/user_images/" . $wa . "' alt='" . $btit_settings["text_war"] . "' title='" . $btit_settings["text_war"] . "' />";

if ($row["fem"] == 'yes')
$ufem= "&nbsp;<img src='images/user_images/" . $fe . "' alt='" . $btit_settings["text_fem"] . "' title='" . $btit_settings["text_fem"] . "' />";

if ($row["par"] == 'yes')
$upar= "&nbsp;<img src='images/user_images/" . $pa . "' alt='" . $btit_settings["text_par"] . "' title='" . $btit_settings["text_par"] . "' />";

if ($row["bot"] == 'yes')
$ubot= "&nbsp;<img src='images/user_images/" . $bo . "' alt='" . $btit_settings["text_bot"] . "' title='" . $btit_settings["text_bot"] . "' />";

if ($row["trmu"] == 'yes')
$utrmu= "&nbsp;<img src='images/user_images/" . $tu . "' alt='" . $btit_settings["text_tru"] . "' title='" . $btit_settings["text_tru"] . "' />";

if ($row["trmo"] == 'yes')
$utrmo= "&nbsp;<img src='images/user_images/" . $tut . "' alt='" . $btit_settings["text_trum"] . "' title='" . $btit_settings["text_trum"] . "' />";

if ($row["vimu"] == 'yes')
$uvimu= "&nbsp;<img src='images/user_images/" . $vi . "' alt='" . $btit_settings["text_vip"] . "' title='" . $btit_settings["text_vip"] . "' />";

if ($row["vimo"] == 'yes')
$uvimo= "&nbsp;<img src='images/user_images/" . $vip . "' alt='" . $btit_settings["text_vipm"] . "' title='" . $btit_settings["text_vipm"] . "' />";

if ($row["friend"] == 'yes')
$ufrie= "&nbsp;<img src='images/user_images/" . $fr . "' alt='" . $btit_settings["text_fri"] . "' title='" . $btit_settings["text_fri"] . "' />";

if ($row["junkie"] == 'yes')
$ujunk= "&nbsp;<img src='images/user_images/" . $ju . "' alt='" . $btit_settings["text_jun"] . "' title='" . $btit_settings["text_jun"] . "' />";

if ($row["staff"] == 'yes')
$ustaf= "&nbsp;<img src='images/user_images/" . $st . "' alt='" . $btit_settings["text_sta"] . "' title='" . $btit_settings["text_sta"] . "' />";

if ($row["sysop"] == 'yes')
$usys= "&nbsp;<img src='images/user_images/" . $sy . "' alt='" . $btit_settings["text_sys"] . "' title='" . $btit_settings["text_sys"] . "' />";

if ($udo == ''AND $udob== ''AND $ubir== ''AND $umal== ''AND $ufem== ''AND $uban== ''AND $uwar== ''AND $upar== ''AND $ubot== ''AND $utrmu== ''AND $utrmo== ''AND $uvimu== ''AND $uvimo== ''AND $ufrie== ''AND $ujunk== ''AND $ustaf== ''AND $usys == '')
$userdetailtpl-> set("usericons","You have no user images yet");
else
$userdetailtpl-> set("usericons",$udo.$udob.$ubir.$umal.$ufem.$uban.$uwar.$upar.$ubot.$utrmu.$utrmo.$uvimu.$uvimo.$ufrie.$ujunk.$ustaf.$usys);

// user image

if($row["gender"]==2) {
$userdetailtpl->set("gender", ($row["gender"]==2 ? $language["UNKNOW"] :unesc($row['name']))."&nbsp;&nbsp;<img src=\"images/gender/unknow.png\" alt=\"\" />");
}else{
	  if($row["gender"]==0) {
$userdetailtpl -> set("gender", ($row["gender"]==0 ? $language["MALE"] :unesc($row['name']))."&nbsp;&nbsp;<img src=\"images/gender/male.png\" alt=\"\" />");
}else{
$userdetailtpl -> set("gender", ($row["gender"]==1 ? $language["FEMALE"] :unesc($row['name']))."&nbsp;&nbsp;<img src=\"images/gender/female.png\" alt=\"\" />");
}
}

//Profile Status by Yupy...
$userdetailtpl -> set("userdetail_profile_status", format_comment($profile_status["last_status"]));
$userdetailtpl -> set("userdetail_status_time", time_ago($profile_status["last_update"]));
//Profile Status by Yupy Ends...

//zodiac
$sign=getsign($row["dob"]);

if ($sign=='')
$userdetailtpl-> set("zodiac","N/A");
ELSE
$userdetailtpl-> set("zodiac",$sign);

// this is the getsign function itself
function getsign($date){
     list($year,$month,$day)=explode("-",$date);
     if(($month==1 && $day>20)||($month==2 && $day<20)){
          return " <img src=images/zodiac/aquarius.jpg>";
     }else if(($month==2 && $day>18 )||($month==3 && $day<21)){
          return "<img src=images/zodiac/pisces.jpg>";
     }else if(($month==3 && $day>20)||($month==4 && $day<21)){
          return "<img src=images/zodiac/aries.jpg>";
     }else if(($month==4 && $day>20)||($month==5 && $day<22)){
          return "<img src=images/zodiac/taurus.jpg>";
     }else if(($month==5 && $day>21)||($month==6 && $day<22)){
          return "<img src=images/zodiac/gemini.jpg>";
     }else if(($month==6 && $day>21)||($month==7 && $day<24)){
          return "<img src=images/zodiac/cancer.jpg>";
     }else if(($month==7 && $day>23)||($month==8 && $day<24)){
          return "<img src=images/zodiac/leo.jpg>";
     }else if(($month==8 && $day>23)||($month==9 && $day<24)){
          return "<img src=images/zodiac/virgo.jpg>";
     }else if(($month==9 && $day>23)||($month==10 && $day<24)){
          return "<img src=images/zodiac/libra.jpg>";
     }else if(($month==10 && $day>23)||($month==11 && $day<23)){
          return "<img src=images/zodiac/scorpio.jpg>";
     }else if(($month==11 && $day>22)||($month==12 && $day<23)){
          return "<img src=images/zodiac/sagittarius.jpg>";
     }else if(($month==12 && $day>22)||($month==1 && $day<21)){
          return "<img src=images/zodiac/capricorn.jpg>";
     }
}
//zodiac

// online
$ontime=NDF($row["tot_on"]); 
$userdetailtpl->set("userdetail_online",$ontime);
// online

// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);
$userdetailtpl-> set("id", $id);
$userdetailtpl-> set("userdetail_reputation", (($setrep["rep_is_online"]=="true") ? TRUE : FALSE), TRUE);

if ($setrep["rep_is_online"]== 'false')
{
//do nothing
}
else
{

$userdetailtpl->set("reputation_plus" ,"<img src='images/rep/add.png'>");
$userdetailtpl->set("reputation_min" ,"<img src='images/rep/delete.png'>");
$userdetailtpl->set("reputation_tot" ,$row["reputation"]);

if ($row["reputation"] == 0)
{
$userdetailtpl->set("reputation" , "<img src='images/rep/reputation_balance.gif'>");
$userdetailtpl->set("reputation_tekst" , $setrep["no_level"] );
}
if ($row["reputation"] >= 1 )
{
$userdetailtpl->set("reputation" ,"<img src='images/rep/reputation_pos.gif'>");
$userdetailtpl->set("reputation_tekst" , $setrep["good_level"] );
}
if ($row["reputation"] <= -1 )
{
$userdetailtpl->set("reputation" ,"<img src='images/rep/reputation_neg.gif'>");
$userdetailtpl->set("reputation_tekst" , $setrep["bad_level"] );
}
if ($row["reputation"] >= 101 )
{
$userdetailtpl->set("reputation" ,"<img src='images/rep/reputation_highpos.gif'>");
$userdetailtpl->set("reputation_tekst" , $setrep["best_level"] );
}
if ($row["reputation"] <= -101 )
{
$userdetailtpl->set("reputation" ,"<img src='images/rep/reputation_highneg.gif'>");
$userdetailtpl->set("reputation_tekst" , $setrep["worse_level"] );
}
}
// DT end reputation system
if($row["dob"]!="0000-00-00")
{
    $dob=explode("-",$row["dob"]);
    $age=userage($dob[0], $dob[1], $dob[2]);
}
else
    $age=$language["NA"];
    
$userdetailtpl-> set("age",$age);
$userdetailtpl-> set("rep","<a href=index.php?page=report&user=".$id."><img src='images/repusr.gif'></a>");

if ($row["warns"] == 0)
$userdetailtpl->set("w_level" , "<img src='images/warned/warn_0.png'>");

if ($row["warns"] == 1 OR $row["warns"] == 2 )
$userdetailtpl->set("w_level" , "<img src='images/warned/warn_1.png'>");

if ($row["warns"] == 3 OR $row["warns"] == 4)
$userdetailtpl->set("w_level" , "<img src='images/warned/warn_2.png'>");

if ($row["warns"] == 5 OR $row["warns"] == 6)
$userdetailtpl->set("w_level" , "<img src='images/warned/warn_3.png'>");


$userdetailtpl-> set("friend","<a href=index.php?page=friendlist&do=add&friend_id=".$id."><img src=images/friendship.gif alt=add /> </a>");
$userdetailtpl-> set("showfriend","<a href=index.php?page=friends&frid=".$id."><img src=images/myspace.gif alt=friendlist /> </a>");
	  
//  timed Rank by DT start
$res4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT level, prefixcolor, suffixcolor FROM {$TABLE_PREFIX}users_level WHERE id ='$row[old_rank]'");
$arr4 = mysqli_fetch_assoc($res4);
$oldrank = $arr4[prefixcolor].$arr4[level].$arr4[sufixcolor];
$userdetailtpl-> set("old_rank",$oldrank);


		$opts['name']='level';
		$opts['complete']=true;
		$opts['id']='id';
		$opts['value']='level';
		$opts['default']=$row['id_level'];
$ranks=rank_list();
$userdetailtpl->set('rank_combo',get_combodt($ranks, $opts));

//  timed Rank by DT end
   
$userdetailtpl-> set("language",$language);
$userdetailtpl-> set("userdetail_username", unesc($row["prefixcolor"]).unesc($row["username"]).$banp. immunity($row). get_user_icons($row). warn($row).booted($row,true).unesc($row["suffixcolor"]));
if ($CURUSER["uid"]>1 && $id!=$CURUSER["uid"])
    $userdetailtpl -> set("userdetail_send_pm", "&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=".$CURUSER["uid"]."&amp;what=new&amp;to=".urlencode(unesc($row["username"]))."\">".image_or_link("$STYLEPATH/images/pm.png","",$language["PM"])."</a>");

	  if ($CURUSER["id_level"]=="8" OR $row["immunity"]=="no") 
{
 if ($CURUSER["edit_users"]=="yes" && $id!=$CURUSER["uid"])
    $userdetailtpl -> set("userdetail_edit","&nbsp;&nbsp;&nbsp<a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=users&amp;action=edit&amp;uid=$id&amp;returnto=index.php?page=userdetails&amp;id=$id\">".image_or_link("$STYLEPATH/images/edit.png","",$language["EDIT"])."</a>");
if ($CURUSER["delete_users"]=="yes" && $id!=$CURUSER["uid"])
    $userdetailtpl -> set("userdetail_delete", "&nbsp;&nbsp;&nbsp<a onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\" href=index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=users&amp;action=delete&amp;uid=$id&amp;smf_fid=".$row["smf_fid"]."&amp;returnto=".urlencode("index.php?page=users").">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a>");
    if ($CURUSER["delete_users"]=="yes" && $id!=$CURUSER["uid"])
    $userdetailtpl -> set("userdetail_banbutton", "&nbsp;&nbsp;&nbsp<a href=index.php?page=banbutton&ban_id=".$id."><font color=green>".image_or_link("$STYLEPATH/images/trash.png","",$language["DTBAN"])."</a>");
 if ($CURUSER["delete_users"]=="yes" && $id!=$CURUSER["uid"]&& $btit_settings["slon"]==true)
$userdetailtpl -> set("userdetail_shit", "&nbsp;&nbsp;&nbsp<a href=index.php?page=shitlist&do=add&shit_id=".$id."><font color=green>".image_or_link("images/shit.gif","",$language["SHIT"])."</a>");   
      
}
 
$userdetailtpl -> set("userdetail_has_avatar", $row["avatar"] && $row["avatar"]!="", TRUE);$userdetailtpl -> set("userdetail_hits", (!empty($row["usercounter"])?$row["usercounter"]:"No Visits"));

$userdetailtpl -> set("userdetail_avatar","<img border=\"0\" onload=\"resize_avatar(this);\" src=\"".htmlspecialchars($row["avatar"])."\" alt=\"\" />");

$userdetailtpl -> set("userdetail_edit_admin", $CURUSER["edit_users"]=="yes" || $CURUSER["admin_access"]=="yes", TRUE);
if ($CURUSER["edit_users"]=="yes" || $CURUSER["admin_access"]=="yes")
{
$userdetailtpl -> set("userdetail_email", "<a href=\"mailto:".$row["email"]."\">".$row["email"]."</a>");$userdetailtpl-> set("browser", ($row["browser"]));
//donation historie DT
$don = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}don_historie WHERE don_id ='$id'");
$dh = mysqli_fetch_assoc($don);
if ($btit_settings["dh_unit"] == true)
{
$unit = "&#8364;";
}
if ($btit_settings["dh_unit"] == false)
{
$unit = "&#36;";
}
$aa =("<font color=steelblue>Amount : </font>".($dh["don_ation"])."&nbsp;".$unit."&nbsp;&nbsp; <font color=steelblue>date : </font>".substr($dh['donate_date'], 8, -9)."-".substr($dh['donate_date'], 5, -12)."-".substr($dh['donate_date'], 0,4));
$bb =("<br><font color=steelblue>Amount : </font>".($dh["don_ation_1"])."&nbsp;".$unit."&nbsp;&nbsp; <font color=steelblue>date : </font>".substr($dh['donate_date_1'], 8, -9)."-".substr($dh['donate_date_1'], 5, -12)."-".substr($dh['donate_date_1'], 0,4));
$cc =("<br><font color=steelblue>Amount : </font>".($dh["don_ation_2"])."&nbsp;".$unit."&nbsp;&nbsp; <font color=steelblue>date : </font>".substr($dh['donate_date_2'], 8, -9)."-".substr($dh['donate_date_2'], 5, -12)."-".substr($dh['donate_date_2'], 0,4));
$dd =("<br><font color=steelblue>Amount : </font>".($dh["don_ation_3"])."&nbsp;".$unit."&nbsp;&nbsp; <font color=steelblue>date : </font>".substr($dh['donate_date_3'], 8, -9)."-".substr($dh['donate_date_3'], 5, -12)."-".substr($dh['donate_date_3'], 0,4));
$ee =("<br><font color=steelblue>Amount : </font>".($dh["don_ation_4"])."&nbsp;".$unit."&nbsp;&nbsp; <font color=steelblue>date : </font>".substr($dh['donate_date_4'], 8, -9)."-".substr($dh['donate_date_4'], 5, -12)."-".substr($dh['donate_date_4'], 0,4));
$ff =("<br><font color=steelblue>Amount : </font>".($dh["don_ation_5"])."&nbsp;".$unit."&nbsp;&nbsp; <font color=steelblue>date : </font>".substr($dh['donate_date_5'], 8, -9)."-".substr($dh['donate_date_5'], 5, -12)."-".substr($dh['donate_date_5'], 0,4));
$gg =("<br><font color=steelblue>Amount : </font>".($dh["don_ation_6"])."&nbsp;".$unit."&nbsp;&nbsp; <font color=steelblue>date : </font>".substr($dh['donate_date_6'], 8, -9)."-".substr($dh['donate_date_6'], 5, -12)."-".substr($dh['donate_date_6'], 0,4));
$hh =("<br><font color=steelblue>Amount : </font>".($dh["don_ation_7"])."&nbsp;".$unit."&nbsp;&nbsp; <font color=steelblue>date : </font>".substr($dh['donate_date_7'], 8, -9)."-".substr($dh['donate_date_7'], 5, -12)."-".substr($dh['donate_date_7'], 0,4));
$ii =("<br><font color=steelblue>Amount : </font>".($dh["don_ation_8"])."&nbsp;".$unit."&nbsp;&nbsp; <font color=steelblue>date : </font>".substr($dh['donate_date_8'], 8, -9)."-".substr($dh['donate_date_8'], 5, -12)."-".substr($dh['donate_date_8'], 0,4));
$jj =("<br><font color=steelblue>Amount : </font>".($dh["don_ation_9"])."&nbsp;".$unit."&nbsp;&nbsp; <font color=steelblue>date : </font>".substr($dh['donate_date_9'], 8, -9)."-".substr($dh['donate_date_9'], 5, -12)."-".substr($dh['donate_date_9'], 0,4));
$kk =("<br><font color=steelblue>Amount : </font>".($dh["don_ation_10"])."&nbsp;".$unit."&nbsp;&nbsp; <font color=steelblue>date : </font>".substr($dh['donate_date_10'], 8, -9)."-".substr($dh['donate_date_10'], 5, -12)."-".substr($dh['donate_date_10'], 0,4));

    if(empty($dh["don_ation"]))
    {
        $userdetailtpl-> set("donations", "No donations history available yet");
    }

     else  if(empty($dh["don_ation_1"]))
    {

        $userdetailtpl-> set("donations", $aa);
    }
    else    if(empty($dh["don_ation_2"]))
    {
        $don = ($aa.$bb);
        $userdetailtpl-> set("donations", $don);
   }
    else    if(empty($dh["don_ation_3"]))
    {
        $don = ($aa.$bb.$cc);
        $userdetailtpl-> set("donations", $don);
    }
    else    if(empty($dh["don_ation_4"]))
    {
        $don = ($aa.$bb.$cc.$dd);
        $userdetailtpl-> set("donations", $don);
    }
    else    if(empty($dh["don_ation_5"]))
    {
        $don = ($aa.$bb.$cc.$dd.$ee);
        $userdetailtpl-> set("donations", $don);
    }
    else    if(empty($dh["don_ation_6"]))
    {
        $don = ($aa.$bb.$cc.$dd.$ee.$ff);
        $userdetailtpl-> set("donations", $don);
    }
    else    if(empty($dh["don_ation_7"]))
    {
        $don = ($aa.$bb.$cc.$dd.$ee.$ff.$gg);
        $userdetailtpl-> set("donations", $don);
    }
    else    if(empty($dh["don_ation_8"]))
    {
        $don = ($aa.$bb.$cc.$dd.$ee.$ff.$gg.$hh);
        $userdetailtpl-> set("donations", $don);
    }
    else    if(empty($dh["don_ation_9"]))
    {
        $don = ($aa.$bb.$cc.$dd.$ee.$ff.$gg.$hh.$ii);
        $userdetailtpl-> set("donations", $don);
    }
        else    if(empty($dh["don_ation_10"]))
    {
        $don = ($aa.$bb.$cc.$dd.$ee.$ff.$gg.$hh.$ii.$jj);
        $userdetailtpl-> set("donations", $don);
    }
//donation historie DT end
                    
$userdetailtpl -> set("userdetail_last_ip", ($row["cip"])."&nbsp;&nbsp;&nbsp;<a href=index.php?page=iplog&id=$id><img src=images/icon_ip.gif border=0></a>");

// Start - Whois check by Petr1fied
include_once("whois/whois.main.php");

$whois = new Whois();
$result = $whois->Lookup($row["cip"]);
$output="<pre>";
$i=0;
while ($i<count($result["rawdata"]))
{
    $i++;
    $output.=$result["rawdata"][$i]."<br />";
}
$output.="</pre>";

$userdetailtpl -> set("userdetail_whois", ($output));

// End - Whois check by Petr1fied
$userdetailtpl -> set("userdetail_level_admin", ($row["level"]));
$userdetailtpl -> set("userdetail_colspan", "2");
}
else
{
$userdetailtpl-> set("userdetail_level", ($row["level"]));
$userdetailtpl-> set("userdetail_colspan", "0");
}
//begin invitation system by dodge
$userdetailtpl->set("userdetail_invs", ($row["invitations"]));
if ($row["invited_by"] > 0)
{
    $res2 = do_sqlquery("SELECT id, username FROM {$TABLE_PREFIX}users WHERE id='" . $row["invited_by"] . "'", true);
    if ($res2)
    {
        $userdetailtpl->set("was_invited", true, true);
        $invite = mysqli_fetch_row($res2);
        $userdetailtpl->set("userdetail_invby", "<a href=index.php?page=userdetails&amp;id=" . $invite[0] . ">" . $invite[1] . "</a>");
    }
}
else
    $userdetailtpl->set("was_invited", false, true);
    
//dt
if($INVITATIONSON) 
$userdetailtpl->set("dt_invited", true, true);
else
$userdetailtpl->set("dt_invited", false, true);     
//end invitation system
    
$userdetailtpl -> set("userdetail_joined", ($row["joined"]==0 ? "N/A" : get_date_time($row["joined"])));$userdetailtpl -> set("custom_title", (!$row["custom_title"] ? "" : unesc($row["custom_title"])));

$userdetailtpl -> set("timed_rank_header", ($row["rank_switch"]=="no" ? "" : "<tr><td class=header>Timed Rank Expire"));
$userdetailtpl -> set("timed_rank_title", ($row["rank_switch"]=="no" ? "" : "<td class=lista colspan=2 ><font color = red><b>".unesc($row["timed_rank"]."</b></font></tr>")));
                    $userdetailtpl -> set("userdetail_lastaccess", ($row["lastconnect"]==0 ? "N/A" : get_date_time($row["lastconnect"])));
$userdetailtpl -> set("userdetail_country", ($row["flag"]==0 ? "":unesc($row['name']))."&nbsp;&nbsp;<img src=\"images/flag/".(!$row["flagpic"] || $row["flagpic"]==""?"unknown.gif":$row["flagpic"])."\" alt=\"".($row["flag"]==0 ? "unknown":unesc($row['name']))."\" />");
      $userdetailtpl-> set("userdetail_invisible", ($row["invisible"]));
      
$userdetailtpl -> set("userdetail_local_time", (date("d/m/Y H:i:s",time()-$offset)."&nbsp;(GMT".($row["time_offset"]>0?" +".$row["time_offset"]:($row["time_offset"]==0?"":" ".$row["time_offset"])).")"));

// ul-dl per day
$days = round((time() - strtotime($row['joined']))/86400);
$dlday = " (".($days > 1 ? makesize($row['downloaded']/$days) : makesize($row['downloaded']))." per day)";
$ulday = " (".($days > 1 ? makesize($row['uploaded']/$days) : makesize($row['uploaded']))." per day)";
$userdetailtpl -> set("userdetail_downloaded", (makesize($row["downloaded"])).$dlday);
$userdetailtpl -> set("userdetail_uploaded", (makesize($row["uploaded"])).$ulday);
// end ul-dl per day

$userdetailtpl -> set("userdetail_ratio", ($ratio));
     
// sb control
if ($CURUSER["edit_users"]=="yes")
$userdetailtpl -> set("userdetail_bonus", (number_format($row["seedbonus"],2))."&nbsp;&nbsp;&nbsp;<a href=index.php?page=sb&id=$id><img src=images/sb.png border=0></a>");
else
$userdetailtpl -> set("userdetail_bonus", (number_format($row["seedbonus"],2)));
// sb control

    
$userdetailtpl-> set("userdetail_forum_internal", ( $GLOBALS["FORUMLINK"] == '' || $GLOBALS["FORUMLINK"] == 'internal' || substr($GLOBALS["FORUMLINK"],0,3) == 'smf' || $GLOBALS["FORUMLINK"] == 'ipb'), TRUE);

// Only show if forum is internal
if ( $GLOBALS["FORUMLINK"] == '' || $GLOBALS["FORUMLINK"] == 'internal' )
{
   $sql = get_result("SELECT count(*) as tp FROM {$TABLE_PREFIX}posts p INNER JOIN {$TABLE_PREFIX}users u ON p.userid = u.id WHERE u.id = " . $id,true,$btit_settings['cache_duration']);
   $posts = $sql[0]['tp'];
   unset($sql);
   $memberdays = max(1, round( ( time() - $row['joined'] ) / 86400 ));
   $posts_per_day = number_format(round($posts / $memberdays,2),2);
   $userdetailtpl-> set("userdetail_forum_posts", $posts . " &nbsp; [" . sprintf($language["POSTS_PER_DAY"], $posts_per_day) . "]");
}
elseif (substr($GLOBALS["FORUMLINK"],0,3)=="smf")
{
   $forum=get_result("SELECT `date".(($GLOBALS["FORUMLINK"]=="smf")?"R":"_r")."egistered`, `posts` FROM `{$db_prefix}members` WHERE ".(($GLOBALS["FORUMLINK"]=="smf")?"`ID_MEMBER`":"`id_member`")."=".$row["smf_fid"],true,$btit_settings['cache_duration']);
   $forum=$forum[0];
   $memberdays = max(1, round( ( time() - (($GLOBALS["FORUMLINK"]=="smf")?$forum["dateRegistered"]:$forum["date_registered"]) ) / 86400 ));
   $posts_per_day = number_format(round($forum["posts"] / $memberdays,2),2);
   $userdetailtpl-> set("userdetail_forum_posts", $forum["posts"] . " &nbsp; [" . sprintf($language["POSTS_PER_DAY"], $posts_per_day) . "]");
   unset($forum);
}$userdetailtpl-> set("comment_access", (($CURUSER["edit_users"]=="yes" || $CURUSER["admin_access"]=="yes")?TRUE:FALSE), TRUE);
$userdetailtpl-> set("modcomment", $row["modcomment"]);
$userdetailtpl-> set("supcomment", $row["supcomment"]);
$userdetailtpl-> set("id", $id);

$userdetailtpl-> set("userdetail_clientinfo", (($CURUSER["edit_users"]=="yes") ? TRUE : FALSE), TRUE);

if($CURUSER["edit_users"]=="yes")
{
    if(empty($row["clientinfo"]))
    {
        $userdetailtpl-> set("client_history_text", "No client history available yet");
    }
    else
    {
        $client_history_text="";
        $clientinfo=unserialize($row["clientinfo"]);
        foreach($clientinfo as $k => $v)
        {
            if($k==0)
            {
                $info=explode("[X]",$v);
                $client_history_text.="<a href='index.php?page=users&client=".urlencode($info[0])."'>".$info[0] . "</a> ".$language["PEER_PORT"].": <a href='index.php?page=users&port=$info[1]'>".$info[1]."</a> (<a href='index.php?page=users&client=".urlencode($info[0])."&port=$info[1]'>Pair</a>)";
            }
            if($k!=0 && ($k==2 || $k==4 || $k==6  || $k==8 || $k==10 || $k==12 || $k==14  || $k==16  || $k==18))
            {
                $client_history_text.="<br />";
                $info=explode("[X]",$v);
                $client_history_text.="<a href='index.php?page=users&client=".urlencode($info[0])."'>".$info[0] . "</a> ".$language["PEER_PORT"].": <a href='index.php?page=users&port=$info[1]'>".$info[1]."</a> (<a href='index.php?page=users&client=".urlencode($info[0])."&port=$info[1]'>Pair</a>)";
            }
            if($k==1 || $k==3 || $k==5 || $k==7  || $k==9 || $k==11 || $k==13 || $k==15 || $k==17  || $k==19)
            {
                $info1=explode("[X]",$v);
                $client_history_text.=" - recorded on " . get_date_time($info1[0]) . " from $info1[1]";
            }
        }
        $userdetailtpl-> set("client_history_text", $client_history_text);
    }
}

elseif ($GLOBALS["FORUMLINK"]=="ipb")
{
   $forum=get_result("SELECT `joined`, `posts` FROM `{$ipb_prefix}members` WHERE `member_id`=".$row["ipb_fid"],true,$btit_settings['cache_duration']);
   $forum=$forum[0];
   $memberdays = max(1, round( ( time() - $forum["joined"] ) / 86400 ));
   $posts_per_day = number_format(round($forum["posts"] / $memberdays,2),2);
   $userdetailtpl-> set("userdetail_forum_posts", $forum["posts"] . " &nbsp; [" . sprintf($language["POSTS_PER_DAY"], $posts_per_day) . "]");
   unset($forum);
}

$userdetailtpl-> set("warn_access", (($row["warn"]=="yes")?TRUE:FALSE), TRUE);
$userdetailtpl-> set("warnreason", (!$row["warnreason"] ? "" : unesc($row["warnreason"])));   
$userdetailtpl-> set("warnadded", (!$row["warnadded"] ? "" : unesc($row["warnadded"])));
$userdetailtpl-> set("warnaddedby", (!$row["warnaddedby"] ? "" : unesc($row["warnaddedby"])));
$userdetailtpl-> set("warns", (!$row["warns"] ? "" : unesc($row["warns"])));   
$userdetailtpl-> set("rewarn_access", (($row["warn"]=="yes")?TRUE:FALSE), TRUE);
$userdetailtpl-> set("adminwarn_access", (($CURUSER["edit_torrents"]=="yes" || $CURUSER["edit_users"]=="yes")?TRUE:FALSE), TRUE);
$userdetailtpl-> set("nowarn_access", (($CURUSER["edit_torrents"]=="yes" || $CURUSER["edit_users"]=="yes")?TRUE:FALSE), TRUE);
$userdetailtpl-> set("warns_access", (($row["warn"]=="no")?TRUE:FALSE), TRUE);
$userdetailtpl-> set("warn", ($row["warn"]="yes"?"checked=\"checked\"":""));
$userdetailtpl-> set("warnreason", $row["warnreason"]);
$userdetailtpl-> set("id", $id);

$userdetailtpl-> set("booted_access", (($row["booted"]=="yes")?TRUE:FALSE), TRUE);
$userdetailtpl-> set("whybooted", (!$row["whybooted"] ? "" : unesc($row["whybooted"])));   
$userdetailtpl-> set("addbooted", (!$row["addbooted"] ? "" : unesc($row["addbooted"])));
$userdetailtpl-> set("whobooted", (!$row["whobooted"] ? "" : unesc($row["whobooted"])));
$userdetailtpl-> set("rebooted_access", (($row["booted"]=="yes")?TRUE:FALSE), TRUE);
$userdetailtpl-> set("adminrebooted_access", (($CURUSER["edit_torrents"]=="yes" || $CURUSER["edit_users"]=="yes")?TRUE:FALSE), TRUE);
$userdetailtpl-> set("nobooted_access", (($CURUSER["edit_torrents"]=="yes" || $CURUSER["edit_users"]=="yes")?TRUE:FALSE), TRUE);
$userdetailtpl-> set("booted0_access", (($row["booted"]=="no")?TRUE:FALSE), TRUE);
$userdetailtpl-> set("booted", ($row["booted"]="yes"?"checked=\"checked\"":""));
$userdetailtpl-> set("whybooted", $row["whybooted"]);


$resuploaded = get_result("SELECT count(*) as tf FROM {$TABLE_PREFIX}files f WHERE uploader=$id AND f.anonymous = \"false\" ORDER BY data DESC",true,$btit_settings['cache_duration']);
$numtorrent=$resuploaded[0]['tf'];
unset($resuploaded);
$userdetailtpl->set("pagertop","");
if ($numtorrent>0)
   {
   list($pagertop, $pagerbottom, $limit) = pager(($utorrents==0?15:$utorrents), $numtorrent, $_SERVER["PHP_SELF"]."?page=userdetails&amp;id=$id&amp;pagename=uploaded&amp;",array("pagename" => "uploaded"));
   $userdetailtpl->set("pagertop",$pagertop);
   $resuploaded = get_result("SELECT f.team, f.info_hash, f.filename, UNIX_TIMESTAMP(f.data) as added, f.size, $tseeds as seeds, $tleechs as leechers, $tcompletes as finished FROM $ttables WHERE uploader=$id AND anonymous = \"false\" AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) ORDER BY data DESC $limit",true,$btit_settings['cache_duration']);
}


if ($resuploaded && $numtorrent>0)
   {
   $userdetailtpl->set("RESULTS",true,true);
   $uptortpl=array();
   $i=0;
   foreach ($resuploaded as $ud_id=>$rest)
         {
           $rest["filename"]=unesc($rest["filename"]);
           $filename=cut_string($rest["filename"],intval($btit_settings["cut_name"]));
           if ($GLOBALS["usepopup"])
           {
               $uptortpl[$i]["moder"]= getmoderdetails(getmoderstatusbyhash($rest['info_hash']),$rest['info_hash']);
			   $uptortpl[$i]["filename"]="<a href=\"javascript:popdetails('index.php?page=torrent-details&amp;id=".$rest{"info_hash"}."')\" title=\"".$language["VIEW_DETAILS"].": ".$rest["filename"]."\">".$filename."</a>";
               $uptortpl[$i]["added"]=date("d/m/Y",$rest["added"]-$offset);
               $uptortpl[$i]["size"]=makesize($rest["size"]);
               $uptortpl[$i]["seedcolor"]=linkcolor($rest["seeds"]);
               $uptortpl[$i]["seeds"]="<a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$rest{"info_hash"}."')\">$rest[seeds]</a>";
               $uptortpl[$i]["leechcolor"]=linkcolor($rest["leechers"]);
               $uptortpl[$i]["leechs"]="<a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$rest{"info_hash"}."')\">$rest[leechers]</a>";
               if ($rest["finished"]>0)
                 $uptortpl[$i]["completed"]="<a href=\"javascript:poppeer('index.php?page=torrent_history&amp;id=".$rest["info_hash"]."')\">" . $rest["finished"] . "</a>";
               else
                 $uptortpl[$i]["completed"]="---";
               $i++;
           }
           else
           {
               $uptortpl[$i]["filename"]="<a href=\"index.php?page=torrent-details&amp;id=".$rest{"info_hash"}."\" title=\"".$language["VIEW_DETAILS"].": ".$rest["filename"]."\">".$filename."</a>";
			   $uptortpl[$i]["moder"]= getmoderdetails(getmoderstatusbyhash($rest['info_hash']),$rest['info_hash']);
               $uptortpl[$i]["added"]=date("d/m/Y",$rest["added"]-$offset);
               $uptortpl[$i]["size"]=makesize($rest["size"]);
               $uptortpl[$i]["seedcolor"]=linkcolor($rest["seeds"]);
               $uptortpl[$i]["seeds"]="<a href=\"index.php?page=peers&amp;id=".$rest{"info_hash"}."\">$rest[seeds]</a>";
               $uptortpl[$i]["leechcolor"]=linkcolor($rest["leechers"]);
               $uptortpl[$i]["leechs"]="<a href=\"index.php?page=peers&amp;id=".$rest{"info_hash"}."\">$rest[leechers]</a>";
              if ($rest["finished"]>0)
                $uptortpl[$i]["completed"]="<a href=\"index.php?page=torrent_history&amp;id=".$rest["info_hash"]."\">" . $rest["finished"] . "</a>";
              else
                $uptortpl[$i]["completed"]="---";
              $i++;
           }
         }
          $userdetailtpl->set("uptor",$uptortpl);

   }
else
   $userdetailtpl->set("RESULTS",false,true);
   

if ($XBTT_USE)
   $anq=get_result("SELECT count(*) as tp FROM xbt_files_users xfu WHERE active=1 AND uid=$id",true,$btit_settings['cache_duration']);
else
{
  if ($PRIVATE_ANNOUNCE)
      $anq=get_result("SELECT count(*) as tp FROM {$TABLE_PREFIX}peers p INNER JOIN {$TABLE_PREFIX}files f ON f.info_hash = p.infohash WHERE p.pid='".$row["pid"]."'",true,$btit_settings['cache_duration']);
  else
      $anq=get_result("SELECT count(*) as tp FROM {$TABLE_PREFIX}peers p INNER JOIN {$TABLE_PREFIX}files f ON f.info_hash = p.infohash WHERE p.ip='".($row["cip"])."'",true,$btit_settings['cache_duration']);
  }


$userdetailtpl->set("pagertopact","");

// active torrents
if ($anq[0]['tp']>0)
   {
   $userdetailtpl->set("RESULTS_1",true,true);
   $tortpl=array();
   $i=0;

    list($pagertop, $pagerbottom, $limit) = pager(($utorrents==0?15:$utorrents), $anq[0]['tp'], "index.php?page=userdetails&amp;id=$id&amp;pagename=active&amp;",array("pagename" => "active"));
    $userdetailtpl->set("pagertopact",$pagertop);
    if ($XBTT_USE)
            $anq=get_result("SELECT '127.0.0.1' as ip, f.info_hash as infohash, f.filename, f.size, IF(p.left=0,'seeder','leecher') as status, p.downloaded, p.uploaded, $tseeds as seeds, $tleechs as leechers, $tcompletes as finished
                        FROM xbt_files_users p INNER JOIN xbt_files x ON p.fid=x.fid INNER JOIN {$TABLE_PREFIX}files f ON f.bin_hash = x.info_hash
                        WHERE p.uid=$id AND p.active=1 AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) ORDER BY status DESC $limit",true,$btit_settings['cache_duration']);
    else
      {
        if ($PRIVATE_ANNOUNCE)
            $anq=get_result("SELECT p.ip, p.infohash, f.filename, f.size, p.status, p.downloaded, p.uploaded, f.seeds, f.leechers, f.finished
                        FROM {$TABLE_PREFIX}peers p INNER JOIN {$TABLE_PREFIX}files f ON f.info_hash = p.infohash
                        WHERE p.pid='".$row["pid"]."' AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) ORDER BY p.status DESC $limit",true,$btit_settings['cache_duration']);
        else
            $anq=get_result("SELECT p.ip, p.infohash, f.filename, f.size, p.status, p.downloaded, p.uploaded, f.seeds, f.leechers, f.finished
                        FROM {$TABLE_PREFIX}peers p INNER JOIN {$TABLE_PREFIX}files f ON f.info_hash = p.infohash
                        WHERE p.ip='".($row["cip"])."' AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) ORDER BY p.status DESC $limit",true,$btit_settings['cache_duration']);
     }
//    print("<div align=\"center\">$pagertop</div>");

    foreach ($anq as $ud_id=>$torlist)
        {
         if ($torlist['ip'] !="")
           {
             $torlist['filename']=unesc($torlist['filename']);
             $filename=cut_string($torlist['filename'],intval($btit_settings["cut_name"]));
             
               if ($torlist->upload_difference>0) {
               if (($torlist->upload_difference/$torlist->announce_interval)*3600>=471859200)
                  $transferrate="<font color=red>".round(round((($torlist->upload_difference/$torlist->announce_interval)*3600))/471859200, 2)." Mbit/s</font>";
               else
                 $transferrate=round(round((($torlist->upload_difference/$torlist->announce_interval)*3600))/471859200*1000, 2)." Kbit/s";

            } else $transferrate="0 Kbit/s";


               $one=("\n<td align=center class=lista><center>$transferrate</center></td>");
               
                                        if ($torlist->download_difference>0) {
               if (($torlist->download_difference/$torlist->announce_interval)*3600>=471859200)
                  $transferrated="<font color=red>".round(round((($torlist->download_difference/$torlist->announce_interval)*3600))/471859200, 2)." Mbit/s</font>";
               else
                 $transferrated=round(round((($torlist->download_difference/$torlist->announce_interval)*3600))/471859200*1000, 2)." Kbit/s";

            } else $transferrated="0 Kbit/s";
            
             $three=("\n<td align=center class=lista><center>$transferrated</center></td>");
            
            
               if ($torlist->upload_difference>0) {
                  if (($torlist->upload_difference/$torlist->announce_interval)*3600>=471859200)
                     $two=("\n<td align=center class=lista><font color=red><center>".makesize(($torlist->upload_difference/$torlist->announce_interval)*3600)."</center></font></td>");
                  else
                     $two=("\n<td align=center class=lista><center>".makesize(($torlist->upload_difference/$torlist->announce_interval)*3600)."</center></td>");
               } else $two =("\n<td align=center class=lista><center>".makesize(0)."</center></td>");

             if ($GLOBALS["usepopup"])
             {
                 $tortpl[$i]["filename"]="<a href=\"javascript:popdetails('index.php?page=torrent-details&amp;id=".$torlist['infohash']."')\" title=\"".$language["VIEW_DETAILS"].": ".$torlist['filename']."\">".$filename."</a>";
                 $tortpl[$i]["moder"]= getmoderdetails(getmoderstatusbyhash($torlist->infohash),$torlist->infohash);
                 $tortpl[$i]["size"]=makesize($torlist['size']);
                 $tortpl[$i]["status"]=unesc($torlist['status']);
                 $tortpl[$i]["1"]=$one;
                 $tortpl[$i]["2"]=$two;
                 $tortpl[$i]["3"]=$three;
                 $tortpl[$i]["downloaded"]=makesize($torlist['downloaded']);
                 $tortpl[$i]["uploaded"]=makesize($torlist['uploaded']);
                 if ($torlist['downloaded']>0)
                      $peerratio=number_format($torlist['uploaded']/$torlist['downloaded'],2);
                 else
                      $peerratio='&#8734;';
                 $tortpl[$i]["peerratio"]=unesc($peerratio);
                 $tortpl[$i]["seedscolor"]=linkcolor($torlist['seeds']);
                 $tortpl[$i]["seeds"]="<a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$torlist['infohash']."')\">".$torlist['seeds']."</a>";
                 $tortpl[$i]["leechcolor"]=linkcolor($torlist['leechers']);
                 $tortpl[$i]["leechs"]="<a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$torlist['infohash']."')\">".$torlist['leechers']."</a>";
                 $tortpl[$i]["completed"]="<a href=\"javascript:poppeer('index.php?page=torrent_history.php&amp;id=".$torlist['infohash']."')\">".$torlist['finished']."</a>";
                 $i++;
                 $userdetailtpl->set("tortpl",$tortpl);
             }
             else
             {
                 $tortpl[$i]["filename"]="<a href=\"index.php?page=torrent-details&amp;id=".$torlist['infohash']."\" title=\"".$language["VIEW_DETAILS"].": ".$torlist['filename']."\">".$filename."</a>";
			 	 $tortpl[$i]["moder"]= getmoderdetails(getmoderstatusbyhash($torlist->infohash),$torlist->infohash);
	             $tortpl[$i]["size"]=makesize($torlist['size']);
                 $tortpl[$i]["status"]=unesc($torlist['status']);
                 $tortpl[$i]["1"]=$one;
                 $tortpl[$i]["2"]=$two;
                 $tortpl[$i]["3"]=$three;
                 $tortpl[$i]["downloaded"]=makesize($torlist['downloaded']);
                 $tortpl[$i]["uploaded"]=makesize($torlist['uploaded']);
                 if ($torlist['downloaded']>0)
                      $peerratio=number_format($torlist['uploaded']/$torlist['downloaded'],2);
                 else
                      $peerratio='&#8734;';
                 $tortpl[$i]["peerratio"]=unesc($peerratio);
                 $tortpl[$i]["seedscolor"]=linkcolor($torlist['seeds']);
                 $tortpl[$i]["seeds"]="<a href=\"index.php?page=peers&amp;id=".$torlist['infohash']."\">".$torlist['seeds']."</a>";
                 $tortpl[$i]["leechcolor"]=linkcolor($torlist['leechers']);
                 $tortpl[$i]["leechs"]="<a href=\"index.php?page=peers&amp;id=".$torlist['infohash']."\">".$torlist['leechers']."</a>";
                 $tortpl[$i]["completed"]="<a href=\"index.php?page=torrent_history&amp;id=".$torlist['infohash']."\">".$torlist['finished']."</a>";
                 $i++;
                 $userdetailtpl->set("tortpl",$tortpl);
            }
         }
        }
   } else $userdetailtpl->set("RESULTS_1",false,true);

unset($anq);

if ($XBTT_USE)
   $anq=get_result("SELECT count(h.fid) as th FROM xbt_files_users h INNER JOIN xbt_files f ON h.fid=f.fid INNER JOIN {$TABLE_PREFIX}files xf ON xf.info_hash=bin_hash WHERE h.uid=$id AND h.completed=1 AND (".$CURUSER['team']." = xf.team OR xf.team = 0 OR ".$CURUSER['id_level']."> 7)",true,$btit_settings['cache_duration']);
else
    $anq=get_result("SELECT count(h.infohash) as th FROM {$TABLE_PREFIX}history h INNER JOIN {$TABLE_PREFIX}files f ON h.infohash=f.info_hash WHERE h.uid=$id AND h.date IS NOT NULL AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7)",true,$btit_settings['cache_duration']);

$userdetailtpl->set("pagertophist","");

if ($anq[0]['th']>0)
   {
    $userdetailtpl->set("RESULTS_2",true,true);
    $torhistory=array();
    $i=0;
    list($pagertop, $pagerbottom, $limit) = pager(($utorrents==0?15:$utorrents), $anq[0]['th'], "index.php?page=userdetails&amp;id=$id&amp;pagename=history&amp;",array("pagename" => "history"));
    $userdetailtpl->set("pagertophist",$pagertop);
    if ($XBTT_USE)
       $anq=get_result("SELECT f.filename, f.size, f.info_hash, IF(h.active=1,'yes','no'), 'unknown' as agent, h.downloaded, h.uploaded, $tseeds as seeds, $tleechs as leechers, $tcompletes as finished
       FROM $ttables INNER JOIN xbt_files_users h ON h.fid=x.fid WHERE h.uid=$id AND h.completed=1 ORDER BY h.mtime DESC $limit",true,$btit_settings['cache_duration']);
    else
      $anq=get_result("SELECT h.seed,f.filename, f.size, f.info_hash, h.active, h.agent, h.downloaded, h.uploaded, $tseeds as seeds, $tleechs as leechers, $tcompletes as finished
      FROM $ttables INNER JOIN {$TABLE_PREFIX}history h ON h.infohash=f.info_hash WHERE h.uid=$id AND h.date IS NOT NULL ORDER BY date DESC $limit",true,$btit_settings['cache_duration']);
//    print("<div align=\"center\">$pagertop</div>");
    foreach ($anq as $ud_id=>$torlist)
        {
            $torlist['filename']=unesc($torlist['filename']);
            $filename=cut_string($torlist['filename'],intval($btit_settings["cut_name"]));

            if ($GLOBALS["usepopup"])
            {
                $torhistory[$i]["filename"]="<a href=\"javascript:popdetails('index.php?page=torrent-details&amp;id=".$torlist['info_hash']."')\" title=\"".$language["VIEW_DETAILS"].": ".$torlist['filename']."\">".$filename."</a>";
				getmoderdetails(getmoderstatusbyhash($torlist->infohash),$torlist->infohash);
	            $torhistory[$i]["size"]=makesize($torlist['size']);
                $torhistory[$i]["agent"]=htmlspecialchars($torlist['agent']);
                $torhistory[$i]["status"]=($torlist['active']=='yes'?$language["ACTIVATED"]:'Stopped');
                $torhistory[$i]["seed"]=NDF($torlist['seed']);
                $torhistory[$i]["downloaded"]=makesize($torlist['downloaded']);
                $torhistory[$i]["uploaded"]=makesize($torlist['uploaded']);
                if ($torlist['downloaded']>0)
                     $peerratio=number_format($torlist['uploaded']/$torlist['downloaded'],2);
                else
                     $peerratio='&#8734;';
                $torhistory[$i]["ratio"]=unesc($peerratio);
                $torhistory[$i]["seedscolor"]=linkcolor($torlist['seeds']);
                $torhistory[$i]["seeds"]="<a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$torlist['info_hash']."')\">".$torlist['seeds']."</a>";
                $torhistory[$i]["leechcolor"]=linkcolor($torlist['leechers']);
                $torhistory[$i]["leechs"]="<a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$torlist['info_hash']."')\">".$torlist['leechers']."</a>";
                $torhistory[$i]["completed"]="<a href=\"javascript:poppeer('index.php?page=torrent_history&amp;id=".$torlist['info_hash']."\">".$torlist['finished']."</a>";
                $i++;
                $userdetailtpl->set("torhistory",$torhistory);
            }
            else
            {
                $torhistory[$i]["filename"]="<a href=\"index.php?page=torrent-details&amp;id=".$torlist['info_hash']."\" title=\"".$language["VIEW_DETAILS"].": ".$torlist['filename']."\">".$filename."</a>";
				getmoderdetails(getmoderstatusbyhash($torlist->infohash),$torlist->infohash);
	            $torhistory[$i]["size"]=makesize($torlist['size']);
                $torhistory[$i]["agent"]=htmlspecialchars($torlist['agent']);
                $torhistory[$i]["status"]=($torlist['active']=='yes'?$language["ACTIVATED"]:'Stopped');
                 $torhistory[$i]["seed"]=NDF($torlist['seed']);
                $torhistory[$i]["downloaded"]=makesize($torlist['downloaded']);
                $torhistory[$i]["uploaded"]=makesize($torlist['uploaded']);
                if ($torlist['downloaded']>0)
                     $peerratio=number_format($torlist['uploaded']/$torlist['downloaded'],2);
                else
                     $peerratio='&#8734;';
                $torhistory[$i]["ratio"]=unesc($peerratio);
                $torhistory[$i]["seedscolor"]=linkcolor($torlist['seeds']);
                $torhistory[$i]["seeds"]="<a href=\"index.php?page=peers&amp;id=".$torlist['info_hash']."\">".$torlist['seeds']."</a>";
                $torhistory[$i]["leechcolor"]=linkcolor($torlist['leechers']);
                $torhistory[$i]["leechs"]="<a href=\"index.php?page=peers&amp;id=".$torlist['info_hash']."\">".$torlist['leechers']."</a>";
                $torhistory[$i]["completed"]="<a href=\"index.php?page=torrent_history&amp;id=".$torlist['info_hash']."\">".$torlist['finished']."</a>";
                $i++;
                $userdetailtpl->set("torhistory",$torhistory);
            }
        }
   } else $userdetailtpl->set("RESULTS_2",false,true);

unset($anq);
$userdetailtpl-> set("userdetail_back", "<a  href=\"javascript: history.go(-1);\">".$language["BACK"]."</a>");

$counted = $HTTP_COOKIE_VARS[$id];
// if this is first visitor then
if($counted==""){
// we create the cookie for visitor
setcookie($id,"YES",time()+60*60*60);
// add counter to database
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET usercounter=usercounter+1 WHERE id=$id");
}
?>