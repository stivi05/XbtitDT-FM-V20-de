<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    Converted from TorrentTrader code to BTI code by teesee64
//    Converted from BTI code to XBTIT-2 code by DiemThuy ( nov 2008 )
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
dbconn(true);

if (isset($_GET["action"]))
$action = $_GET["action"];
else
$action = "";

// delete messages

if ($action == "delete")
{
$mes_id = $_GET["id"];
if($FORUMLINK=="smf")
{
$recsmf = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT ID_MEMBER from {$db_prefix}pm_recipients WHERE ID_PM=$mes_id") or sqlerr(__FILE__, __LINE__);
$give = mysqli_fetch_array($recsmf);
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$db_prefix}personal_messages WHERE ID_PM=$mes_id") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$db_prefix}pm_recipients WHERE ID_PM=$mes_id") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$db_prefix}members SET instantMessages=instantMessages-1,unreadMessages=unreadMessages-1 WHERE ID_MEMBER=".$give["ID_MEMBER"]);
}
else
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}messages WHERE id=$mes_id") or sqlerr(__FILE__, __LINE__);

}

if($FORUMLINK=="smf")
$res2=do_sqlquery("SELECT COUNT(*) FROM {$db_prefix}personal_messages pm LEFT JOIN {$db_prefix}pm_recipients pmr ON pm.ID_PM=pmr.ID_PM $where");
else
$res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) FROM {$TABLE_PREFIX}messages $where");

$row = mysqli_fetch_array($res2);

$count = $row[0];
$perpage = 8;

    list($pagertop, $pagerbottom, $limit) = pager($perpage, $count,  "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=ispy&amp;");

$admintpl->set("language",$language);
$admintpl->set("pager_top",$pagertop);
$admintpl->set("pager_bottom",$pagerbottom);

if($FORUMLINK=="smf")
$res=do_sqlquery("SELECT pm.ID_PM id, pm.ID_MEMBER_FROM sender, pmr.ID_MEMBER receiver, pm.msgtime added, pm.subject, pm.body msg, IF(pmr.is_read=1,'yes','no') readed, pm.fromName sendername FROM {$db_prefix}personal_messages pm LEFT JOIN {$db_prefix}pm_recipients pmr ON pm.ID_PM=pmr.ID_PM WHERE pmr.deleted!=1 ORDER BY added DESC $limit");
else
$res=do_sqlquery("select m.*, IF(m.sender=0,'System',u.username) as sendername FROM {$TABLE_PREFIX}messages m LEFT JOIN {$TABLE_PREFIX}users u on u.id=m.sender ORDER BY added DESC $limit");


$spy=array();
$i=0;

include("$THIS_BASEPATH/include/offset.php");

if ($res)
{
while ($arr = mysqli_fetch_assoc($res))
 {
if($FORUMLINK=="smf")
$res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE smf_fid=" . $arr["receiver"]) or sqlerr();
else
$res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE id=" . $arr["receiver"]) or sqlerr();

$arr2 = mysqli_fetch_assoc($res2);

if($FORUMLINK=="smf")
$res3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE smf_fid=" . $arr["sender"]) or sqlerr();
else
$res3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE id=" . $arr["sender"]) or sqlerr();

$arr3 = mysqli_fetch_assoc($res3);

$spy[$i]["id"]=$arr["id"];
if ($arr['sender']=="0") 
$spy[$i]["sender"]=("<a href=index.php?page=userdetails&amp;id=0><b>System</b></a>");
elseif ($FORUMLINK=="smf") 
$spy[$i]["sender"]=("<a href=index.php?page=forum&action=profile;u=" . $arr["sender"] . "><b>" . $arr3["username"] . "</b></a>");
else 
$spy[$i]["sender"]=("<a href=index.php?page=userdetails&amp;id=" . $arr["sender"] . "><b>" . $arr3["username"] . "</b></a>");

if ($FORUMLINK=="smf") 
$spy[$i]["receiver"]=("<a href=index.php?page=forum&action=profile;u=" . $arr["receiver"] . "><b>" . $arr2["username"] . "</b></a>");
else
$spy[$i]["receiver"]=("<a href=index.php?page=userdetails&amp;id=" . $arr["receiver"] . "><b>" . $arr2["username"] . "</b></a>");

$spy[$i]["msg"]=format_comment(unesc($arr["msg"]));
$spy[$i]["added"]=date("d/m/Y H:i:s",$arr["added"]-$offset);
$spy[$i]["readed"]=$arr["readed"];
$spy[$i]["delete"]=("<a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=ispy&amp;action=delete&amp;id=".$spy[$i]["id"]."\" onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a>");
$i++;
 }
}
$admintpl->set("spy",$spy);

unset($arr);
((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
unset($spy);

?>