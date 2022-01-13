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


if ($CURUSER["view_users"]=="no")
   {    // start 'view_users'
       err_msg($language["ERROR"],$language["NOT_AUTHORIZED"]." ".$language["MEMBERS"]."!");
       stdfoot();
       exit;
}
else
    {
         global $CURUSER, $STYLEPATH, $CURRENTPATH, $TABLE_PREFIX, $XBTT_USE;

         if ($XBTT_USE)
            {
             $udownloaded="u.downloaded+IFNULL(x.downloaded,0)";
             $uuploaded="u.uploaded+IFNULL(x.uploaded,0)";
             $utables="{$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id";
            }
         else
             {
             $udownloaded="u.downloaded";
             $uuploaded="u.uploaded";
             $utables="{$TABLE_PREFIX}users u";
             }

     if (!isset($_GET["searchtext"])) $_GET["searchtext"] = "";
     if (!isset($_GET["level"])) $_GET["level"] = "";

         $search=htmlspecialchars($_GET["searchtext"]);
         $addparams="";
         if ($search!="")
            {
            $where=" AND u.username LIKE '%".htmlspecialchars(mysqli_real_escape_string($DBDT,$_GET["searchtext"]))."%'";
            $addparams="searchtext=$search";
            }
         else
             $where="";

         $level=intval(0+$_GET["level"]);
         if ($level>0)
            {
            $where.=" AND u.id_level=$level";
            if ($addparams!="")
               $addparams.="&amp;level=$level";
            else
                $addparams="level=$level";
            }

          if($CURUSER["edit_users"]=="yes")
          {
              (isset($_GET["client"])) ? $client=mysqli_real_escape_string($DBDT,urldecode($_GET["client"])) : $client="";
              (isset($_GET["port"]) && is_numeric($_GET["port"])) ? $port=$_GET["port"] : $port="";

              if($client!="" && $port=="")
              {
                $where.=" AND u.clientinfo LIKE'%".$client."[X]%' ";
                if ($addparams!="")
                   $addparams.="&amp;client=".urlencode(stripslashes($client));
                else
                    $addparams.="client=".urlencode(stripslashes($client));
              }
              elseif($client!="" && $port!="")
              {
                $where.=" AND u.clientinfo LIKE'%".$client."[X]".$port."%' ";
                if ($addparams!="")
                   $addparams.="&amp;client=".urlencode(stripslashes($client))."&amp;port=$port";
                else
                    $addparams.="client=".urlencode(stripslashes($client))."&amp;port=$port";
              }
              elseif($client=="" && $port!="")
              {
                $where.=" AND u.clientinfo LIKE'%[X]".$port."\"%' ";
                if ($addparams!="")
                   $addparams.="&amp;port=$port";
                else
                    $addparams.="port=$port";
              }
          }



          $order_param=3;
          // getting order
          if (isset($_GET["order"]))
             {
             $order_param=(int)$_GET["order"];
             switch ($order_param)
               {
               case 1:
                    $order="username";
                    break;

               case 2:
                    $order="level";
                    break;

               case 3:
                    $order="joined";
                    break;

               case 4:
                    $order="lastconnect";
                    break;

               case 5:
                    $order="flag";
                    break;
                         
               case 6:
                    $order="ratio";
                    break;

               default:
                   $order="joined";

             }
          }
          else
              $order="joined";

          $by_param=1;
          if (isset($_GET["by"]))
           {
              $by_param=(int)$_GET["by"];
              $by=($by_param==1?"ASC":"DESC");
          }
          else
              $by="ASC";

         if ($addparams!="")
            $addparams.="&amp;";

          # Search by ip, email, pid # 1
          #
                 
          if (!$CURUSER || $CURUSER["admin_access"]=="yes") {
          
          $searchip=htmlspecialchars($_GET["sip"]);
          if ($searchip!="") $where.=" AND u.cip LIKE '%$searchip%'";
          
          $searchmail=htmlspecialchars($_GET["smail"]);           
          if ($searchmail!="") $where.=" AND u.email LIKE '%$searchmail%'";
          
          $getpid=htmlspecialchars($_GET["pid"]);;
          if ($getpid!="") $where.=" AND u.pid LIKE '%$getpid%'";
          }
          
          #
          ############################ #
    

         $scriptname = htmlspecialchars($_SERVER["PHP_SELF"]."?page=users");

         $res=get_result("select COUNT(*) as tu FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id WHERE u.id>1 $where",true,$btit_settings['cache_duration']);
         $count = $res[0]['tu'];
         list($pagertop, $pagerbottom, $limit) = pager(20, $count,  $scriptname."&amp;" . $addparams.(strlen($addparam)>0?"&amp;":"")."order=$order_param&amp;by=$by_param&amp;");

        if ($by=="ASC")
            $mark="&nbsp;&uarr;";
        else
            $mark="&nbsp;&darr;";

// load language file
require(load_language("lang_users.php"));

$userstpl = new bTemplate();
$userstpl->set("language", $language);
$userstpl->set("users_search", $search);

if ($btit_settings["slon"]==true && $CURUSER["delete_users"]=="yes" )
$userstpl->set("shli", "Shitlist");
else
$userstpl->set("shli", "");

          # Search by ip, email, pid # 2 # last
          #'        

          $userstpl->set("smail", $searchmail);
          $userstpl->set("sip", $searchip);
          $userstpl->set("pid", $getpid);

          #
          ################################# End
    
$userstpl->set("users_search_level", $level==0 ? " selected=\"selected\" " : "");
$userstpl->set("view_client_search", (($CURUSER["edit_users"]=="yes") ? TRUE : FALSE ), TRUE);
if($CURUSER["edit_users"]=="yes")
{
    $userstpl->set("client", $client);
    $userstpl->set("port", $port);
}


$res=get_result("SELECT id,level FROM {$TABLE_PREFIX}users_level WHERE id_level>1 ORDER BY id_level",true,$btit_settings['cache_duration']);
$select="";
foreach($res as $id=>$row)
  {    
   
// start while



  $select.="<option value='".$row["id"]."'";
  if ($level==$row["id"])
  $select.="selected=\"selected\"";
  $select.=">".$row["level"]."</option>\n";
  }    // end while
  
$userstpl->set("users_search_select", $select);
$userstpl->set("users_pagertop", $pagertop);
$userstpl->set("users_sort_username", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=1&amp;by=".($order=="username" && $by=="ASC"?"2":"1")."\">".$language["USER_NAME"]."</a>".($order=="username"?$mark:""));
$userstpl->set("users_sort_userlevel", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=2&amp;by=".($order=="level" && $by=="ASC"?"2":"1")."\">".$language["USER_LEVEL"]."</a>".($order=="level"?$mark:""));
$userstpl->set("users_sort_joined", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=3&amp;by=".($order=="joined" && $by=="ASC"?"2":"1")."\">".$language["USER_JOINED"]."</a>".($order=="joined"?$mark:""));
$userstpl->set("users_sort_lastaccess", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=4&amp;by=".($order=="lastconnect" && $by=="ASC"?"2":"1")."\">".$language["USER_LASTACCESS"]."</a>".($order=="lastconnect"?$mark:""));
$userstpl->set("users_sort_country", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=5&amp;by=".($order=="flag" && $by=="ASC"?"2":"1")."\">".$language["USER_COUNTRY"]."</a>".($order=="flag"?$mark:""));
$userstpl->set("users_sort_ratio", "<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=6&amp;by=".($order=="ratio" && $by=="ASC"?"2":"1")."\">".$language["RATIO"]."</a>".($order=="ratio"?$mark:""));

if ($CURUSER["uid"]>1)
  $userstpl->set("users_pm", $language["USERS_PM"]);
if ($CURUSER["edit_users"]=="yes")
  $userstpl->set("users_edit", $language["EDIT"]);
if ($CURUSER["delete_users"]=="yes")
  $userstpl->set("users_delete", $language["DELETE"]);
if ($CURUSER["delete_users"]=="yes")
  $userstpl->set("users_ban", $language["DTBAN"]);
      
          
$query="select u.trophy, ul.id_level,  dona,donb,birt,mal,fem,bann,war,par,bot,trmu,trmo,vimu,vimo,friend,junkie,staff,sysop, u.ban, u.booted, u.profileview, u.reputation, u.immunity,  u.up_med, prefixcolor, suffixcolor, u.id, $udownloaded as downloaded, $uuploaded as uploaded, IF($udownloaded>0,$uuploaded/$udownloaded,0) as ratio, username, level, UNIX_TIMESTAMP(joined) AS joined,UNIX_TIMESTAMP(lastconnect) AS lastconnect, flag, flagpic, c.name as name, u.warn, u.warns, u.donor, u.smf_fid FROM $utables INNER JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN {$TABLE_PREFIX}countries c ON u.flag=c.id WHERE u.id>1 $where ORDER BY $order $by $limit";

$rusers=get_result($query,true,$btit_settings['cache_duration']);
$userstpl->set("no_users", ($count==0), TRUE);

include ("$CURRENTPATH/offset.php");

$users=array();
$i=0;

foreach ($rusers as $id=>$row_user)
  {     
// start while  
	  
	  
// user image
  global $btit_settings;
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

if ($row_user["dona"] == 'yes')
{
$udo= "&nbsp;<img src='images/user_images/" . $do . "' alt='" . $btit_settings["text_don"] . "' title='" . $btit_settings["text_don"] . "' />";
}
if ($row_user["donb"] == 'yes')
{
$udob= "&nbsp;<img src='images/user_images/" . $don . "' alt='" . $btit_settings["text_donm"] . "' title='" . $btit_settings["text_donm"] . "' />";
}
if ($row_user["birt"] == 'yes')
{
$ubir= "&nbsp;<img src='images/user_images/" . $bi . "' alt='" . $btit_settings["text_bir"] . "' title='" . $btit_settings["text_bir"] . "' />";
}
if ($row_user["mal"] == 'yes')
{
$umal= "&nbsp;<img src='images/user_images/" . $ma . "' alt='" . $btit_settings["text_mal"] . "' title='" . $btit_settings["text_mal"] . "' />";
}
if ($row_user["bann"] == 'yes')
{
$uban= "&nbsp;<img src='images/user_images/" . $ba . "' alt='" . $btit_settings["text_ban"] . "' title='" . $btit_settings["text_ban"] . "' />";
}
if ($row_user["war"] == 'yes')
{
$uwar= "&nbsp;<img src='images/user_images/" . $wa . "' alt='" . $btit_settings["text_war"] . "' title='" . $btit_settings["text_war"] . "' />";
}
if ($row_user["fem"] == 'yes')
{
$ufem= "&nbsp;<img src='images/user_images/" . $fe . "' alt='" . $btit_settings["text_fem"] . "' title='" . $btit_settings["text_fem"] . "' />";
}
if ($row_user["par"] == 'yes')
{
$upar= "&nbsp;<img src='images/user_images/" . $pa . "' alt='" . $btit_settings["text_par"] . "' title='" . $btit_settings["text_par"] . "' />";
}
if ($row_user["bot"] == 'yes')
{
$ubot= "&nbsp;<img src='images/user_images/" . $bo . "' alt='" . $btit_settings["text_bot"] . "' title='" . $btit_settings["text_bot"] . "' />";
}
if ($row_user["trmu"] == 'yes')
{
$utrmu= "&nbsp;<img src='images/user_images/" . $tu . "' alt='" . $btit_settings["text_tru"] . "' title='" . $btit_settings["text_tru"] . "' />";
}
if ($row_user["trmo"] == 'yes')
{
$utrmo= "&nbsp;<img src='images/user_images/" . $tut . "' alt='" . $btit_settings["text_trum"] . "' title='" . $btit_settings["text_trum"] . "' />";
}
if ($row_user["vimu"] == 'yes')
{
$uvimu= "&nbsp;<img src='images/user_images/" . $vi . "' alt='" . $btit_settings["text_vip"] . "' title='" . $btit_settings["text_vip"] . "' />";
}
if ($row_user["vimo"] == 'yes')
{
$uvimo= "&nbsp;<img src='images/user_images/" . $vip . "' alt='" . $btit_settings["text_vipm"] . "' title='" . $btit_settings["text_vipm"] . "' />";
}
if ($row_user["friend"] == 'yes')
{
$ufrie= "&nbsp;<img src='images/user_images/" . $fr . "' alt='" . $btit_settings["text_fri"] . "' title='" . $btit_settings["text_fri"] . "' />";
}
if ($row_user["junkie"] == 'yes')
{
$ujunk= "&nbsp;<img src='images/user_images/" . $ju . "' alt='" . $btit_settings["text_jun"] . "' title='" . $btit_settings["text_jun"] . "' />";
}
if ($row_user["staff"] == 'yes')
{
$ustaf= "&nbsp;<img src='images/user_images/" . $st . "' alt='" . $btit_settings["text_sta"] . "' title='" . $btit_settings["text_sta"] . "' />";
}
if ($row_user["sysop"] == 'yes')
{
$usys= "&nbsp;<img src='images/user_images/" . $sy . "' alt='" . $btit_settings["text_sys"] . "' title='" . $btit_settings["text_sys"] . "' />";
}
// user image


if ($row_user["ban"] == 'yes')
{
$banp = "<img src='images/ban.gif'>";
}
else
{
$banp ="";
}

//private profile MrFix
if ($row_user["profileview"] == 0 || $CURUSER["uid"] == $row_user["id"]) {
$joined = $row_user["joined"]==0 ? $language["NOT_AVAILABLE"] : date("d/m/Y H:i:s",$row_user["joined"]-$offset);
$lastconnect = $row_user["lastconnect"]==0 ? $language["NOT_AVAILABLE"] : date("d/m/Y H:i:s",$row_user["lastconnect"]-$offset);
$flag = $row_user["flag"] == 0 ? "<img src='images/flag/unknown.gif' alt='".$language["UNKNOWN"]."' title='".$language["UNKNOWN"]."' />" : "<img src='images/flag/" . $row_user['flagpic'] . "' alt='" . $row_user['name'] . "' title='" . $row_user['name'] . "' />";
}
else {
$joined = "<img src=\"images/private2.png\" title=\"private\">";
$lastconnect = "<img src=\"images/private2.png\" title=\"private\">";
$flag = "<img src=\"images/private2.png\" title=\"private\">";
}

//private profile MrFix end

$hmm=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}ignore WHERE ignore_id = ".$row_user['id']." AND user_id = ".$CURUSER['uid']);
if (mysqli_num_rows($hmm)){
if ($row_user["id_level"]<6)
$users[$i]["ignore"] ="<font color=red>Ignored</font>";
} 
else
if ($row_user["id_level"]<6)
  $users[$i]["ignore"] ="<a href=index.php?page=usercp&uid=".$CURUSER["uid"]."&do=ignore&action=add&ignore_id=".$row_user["id"]."><font color=orange>Ignore</font></a>";

  
 $onoff = @mysqli_fetch_array(@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT u.lastconnect, o.lastaction FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id WHERE u.id=".$row_user["id"]));

(is_null($onoff["lastaction"])?$lastseen=$onoff["lastconnect"]:$lastseen=$onoff["lastaction"]);
((time()-$lastseen>900)?$status="<img src='images/f1offline.gif' border='0' title='Offline' alt='".$language["OFFLINE"]."'>":$status="<img src='images/f1online.gif' border='0' title='Online' alt='".$language["ONLINE"]."'>");
  $users[$i]["status"]=("<center>".$status."</center>");   
  
// DT Uploader Medals
if ($row_user["up_med"] == 0)
{
$upr="";
}
if ($row_user["up_med"] == 1)
{
$upr= "<img src='images/goblet/medaille_bronze.gif' alt='Bronze Medal' title='Bronze Medal' />";
}
if ($row_user["up_med"] == 2)
{
$upr= "<img src='images/goblet/medaille_argent.gif' alt='Silver Medal' title='Silver Medal' />";
}
if ($row_user["up_med"] >= 3)
{
$upr= "<img src='images/goblet/medaille_or.gif' alt='Gold Medal' title='Gold Medal' />";
}
// DT Uploader Medals

if ($row_user["warns"] == 0)
{
$wl = "<img src='images/warned/warn_0.png'>";
}
if ($row_user["warns"] == 1 OR $row_user["warns"] == 2 )
{
$wl = "<img src='images/warned/warn_1.png'>";
}
if ($row_user["warns"] == 3 OR $row_user["warns"] == 4)
{
$wl = "<img src='images/warned/warn_2.png'>";
}
if ($row_user["warns"] == 5 OR $row_user["warns"] == 6)
{
$wl = "<img src='images/warned/warn_3.png'>";
}
if ($row_user["warns"] >= 7)
{
$wl = "<img src='images/warned/warn_max.png'>";
}
$users[$i]["warns"] = $wl;

// DT immunity
if ($row_user["immunity"] == 'yes')
{
$imm= "<img src='images/shield.png' alt='User Have Immunity !' title='User Have Immunity !' />";
}
else
{
$imm= "";
}
// DT immunity

// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

$userstpl-> set("user_reputation", (($setrep["rep_is_online"]=="true") ? TRUE : FALSE), TRUE);

if ($setrep["rep_is_online"]== 'false')
{
//do nothing
}
else
{
if ($row_user["reputation"] == 0)
{
$reput= "<img src='images/rep/reputation_balance.gif' alt='" . $setrep["no_level"] . "' title='" . $setrep["no_level"] . "' />";
}
if ($row_user["reputation"] >= 1 )
{
$reput= "<img src='images/rep/reputation_pos.gif' alt='" . $setrep["good_level"] . "' title='" . $setrep["good_level"] . "' />";
}
if ($row_user["reputation"] <= -1)
{
$reput= "<img src='images/rep/reputation_neg.gif' alt='" . $setrep["bad_level"] . "' title='" . $setrep["bad_level"] . "' />";
}
if ($row_user["reputation"] >= 101 )
{
$reput= "<img src='images/rep/reputation_highpos.gif' alt='" . $setrep["best_level"] . "' title='" . $setrep["best_level"] . "' />";
}
if ($row_user["reputation"] <= -101)
{
$reput= "<img src='images/rep/reputation_highneg.gif' alt='" . $setrep["worse_level"] . "' title='" . $setrep["worse_level"] . "' />";
}
$users[$i]["reput"] = $reput;
}
// DT end reputation system

//private profile MrFix
if ($row_user["profileview"] == 0) {
$private="<img src=\"images/greengo.gif\" title=\"public\">";
}
if ($row_user["profileview"] == 1) {
$private="<img src=\"images/private2.png\" title=\"private\">";
} 
$users[$i]["private"] = $private;
//private profile MrFix


// DT arcade
if ($row_user["trophy"] == 0)
{
$rra="";
}
if ($row_user["trophy"] == 1)
{
$rra= "<img src='images/crown.gif' alt='Arcade King' title='Arcade King' />";
}
// DT arcade
$users[$i]["username"] = "<a href=\"index.php?page=userdetails&amp;id=".$row_user["id"]."\">".unesc($row_user["prefixcolor"]).unesc($row_user["username"]).$udo.$udob.$ubir.$umal.$ufem.$uban.$uwar.$upar.$ubot.$utrmu.$utrmo.$uvimu.$uvimo.$ufrie.$ujunk.$ustaf.$usys.$banp.$imm.get_user_icons($row_user).warn($row_user).booted($row_user).$upr.$rra.unesc($row_user["suffixcolor"])."</a>";
  $users[$i]["userlevel"] = $row_user["level"];
  $users[$i]["joined"] = $joined;
  $users[$i]["lastconnect"] = $lastconnect;
  $users[$i]["flag"] = $flag;
                       
//user ratio
if ($row_user["profileview"] == 0 || $CURUSER["uid"] == $row_user["id"]) {
if (intval($row_user["downloaded"])>0)
  $ratio=number_format($row_user["uploaded"]/$row_user["downloaded"],2);
else
  $ratio='&#8734;';
} else {
$ratio="<img src=\"images/private2.png\" title=\"private\">";
}

$users[$i]["ratio"] = $ratio;
                       
if ($CURUSER["uid"]>1 && $CURUSER["uid"]!=$row_user["id"])
  $users[$i]["pm"] = "<a href=\"index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=$CURUSER[uid]&amp;what=new&amp;to=".urlencode(unesc($row_user["username"]))."\">".image_or_link("$STYLEPATH/images/pm.png","",$language["USERS_PM"])."</a>";

	  if ($CURUSER["id_level"]=="8" OR $row_user["immunity"]=="no") 
{
 if ($CURUSER["edit_users"]=="yes" && $CURUSER["uid"]!=$row_user["id"])
  $users[$i]["edit"] = "<a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=users&amp;action=edit&amp;uid=".$row_user["id"]."\">".image_or_link("$STYLEPATH/images/edit.png","",$language["EDIT"])."</a>";
if ($CURUSER["delete_users"]=="yes" && $CURUSER["uid"]!=$row_user["id"])
$users[$i]["delete"] = "<a onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\" href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=users&amp;action=delete&amp;uid=".$row_user["id"]."&amp;smf_fid=".$row_user["smf_fid"]."&amp;returnto=".urlencode("index.php?page=users")."\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a>";
if ($CURUSER["delete_users"]=="yes" && $CURUSER["uid"]!=$row_user["id"])
  $users[$i]["ban"] = "<a href=index.php?page=banbutton&ban_id=".$row_user["id"]."><font color=green>".image_or_link("$STYLEPATH/images/trash.png","",$language["DTBAN"])."</a>";
//shitlist
if ($CURUSER["delete_users"]=="yes" && $CURUSER["uid"]!=$row_user["id"] && $btit_settings["slon"]==true)
  $users[$i]["shit"] = "<a href=index.php?page=shitlist&do=add&shit_id=".$row_user["id"]."><font color=green>".image_or_link("images/shit.gif","",$language["SHIT"])."</a>";
//shitlist  
      

    
}
 $i++;
  }   // end while

$userstpl->set("users", $users);

}     // end 'view_users'

?>