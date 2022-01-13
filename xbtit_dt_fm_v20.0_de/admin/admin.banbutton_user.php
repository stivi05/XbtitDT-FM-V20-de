<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Ban Button by DiemThuy  - oct 2009
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

if (!defined("IN_ACP"))
      die("non direct access!");

require_once("include/functions.php");
require_once("include/config.php");

dbconn();

if (isset($_GET["action"]))
$action = $_GET["action"];
else
$action = "";

if ($action == "unban")
{
        $id = $_GET["id"];
        do_sqlquery("UPDATE {$TABLE_PREFIX}users SET ban = 'no' WHERE id=".$id,true);
}

$getbanned = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE ban = 'yes' ORDER BY username ASC") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row= @mysqli_num_rows($getbanned);

    $log=array();
    $i=0;

$admintpl->set("language",$language);


if (mysqli_num_rows($getbanned)==0)
{
    $banbutton_user[$i]["username"]=("<center><b><font color=green>there</font></b></center>");
    $banbutton_user[$i]["added"]=("<center><b><font color=green>are</font></b></center>");
    $banbutton_user[$i]["by"]=("<center><b><font color=green>no</font></b></center>");
    $banbutton_user[$i]["comment"]=("<center><b><font color=green>banned</font></b></center>");
    $banbutton_user[$i]["range"]=("<center><b><font color=green>users</font></b></center>");
    $banbutton_user[$i]["remove"]=("<center><b><font color=green>yet</font></b></center>");
    $i++;
}
         else
             {
while ($arr=mysqli_fetch_assoc($getbanned))
{
$r3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level,prefixcolor,suffixcolor FROM {$TABLE_PREFIX}users_level WHERE id=$arr[id_level]") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$a3 = mysqli_fetch_assoc($r3);

$r4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level,username FROM {$TABLE_PREFIX}users WHERE id=$arr[ban_added_by]") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$a4 = mysqli_fetch_assoc($r4);

$r5 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level,prefixcolor,suffixcolor FROM {$TABLE_PREFIX}users_level WHERE id=$a4[id_level]") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$a5 = mysqli_fetch_assoc($r5);

$dom = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}signup_ip_block WHERE comment='$arr[ban_comment]'")or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));;
if (mysqli_num_rows($dom) >= 1)
{
$rang='<font color=green><b>yes</b></font>';
}
else
{
 $rang='<font color=green><b>not anymore</b></font>';
}
        $banbutton_user[$i]["username"]="<a href=index.php?page=userdetails&id=".$arr["id"].">".$a3["prefixcolor"].$arr['username'].$a3["suffixcolor"]."</a>";
        $banbutton_user[$i]["added"]=get_date_time($arr['ban_added']);
        $banbutton_user[$i]["by"]="<a href=index.php?page=userdetails&id=".$arr["ban_added_by"].">".$a5["prefixcolor"].$a4['username'].$a5["suffixcolor"]."</a>";
        $banbutton_user[$i]["comment"]=$arr['ban_comment'];
        $banbutton_user[$i]["range"]=$rang;
        $banbutton_user[$i]["remove"] = "<a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=banbutton_user&amp;action=unban&amp;id=".$arr["id"]."\" onclick=\"return confirm('". str_replace("'","\'",$language["DELETE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a>";
        $i++;
}
}
$admintpl->set("banbutton_user",$banbutton_user);
?>