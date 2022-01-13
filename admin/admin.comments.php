<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    bti hack by nhltorrents xbtit-2 version by DiemThuy ( dec 2008 )
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

// delete comments

if ($action == "delete")
{
$mes_id = $_GET["id"];
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}comments WHERE id=$mes_id") or sqlerr(__FILE__, __LINE__);
}

// show comments

$subres = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT comments.id, text, info_hash, UNIX_TIMESTAMP(added) as data, user, users.id as uid FROM {$TABLE_PREFIX}comments comments LEFT JOIN {$TABLE_PREFIX}users users ON comments.user=users.username ORDER BY added DESC LIMIT 100");

    $comment=array();
    $i=0;
if (!$subres || mysqli_num_rows($subres)==0)


     {
//  no need , who have no comments ;)
}
else {

     while ($subrow = mysqli_fetch_array($subres))
     

     {
     $res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filename FROM {$TABLE_PREFIX}files WHERE info_hash='".$subrow["info_hash"] ."'") or sqlerr();
     $arr2 = mysqli_fetch_assoc($res2);

        
     $comment[$i]["id"]=$subrow["id"];
     $comment[$i]["by"]=("<a href=index.php?page=userdetails&amp;id=".$subrow["uid"].">" . $subrow["user"] . "</a>");
     $comment[$i]["comment"]=format_comment(unesc($subrow["text"]));
     $comment[$i]["date"]=date("d/m/Y H:i:s",$subrow["data"]-$offset);
     $comment[$i]["torrent"]=("<a href=index.php?page=torrent-details&amp;id=" . $subrow["info_hash"]. ">" . $arr2["filename"] . "</a>");
     
     $comment[$i]["edit"]=("<a href=\"index.php?page=comment&amp;id=".$subrow["info_hash"]."&amp;cid=" . $subrow["id"] . "&amp;dt=dt&amp;edit\">".image_or_link("$STYLEPATH/images/edit.png","",$language["EDIT"])."</a>");
     
     $comment[$i]["delete"]=("<a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=comments&amp;action=delete&amp;id=".$comment[$i]["id"]."\" onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a>");
     $i++;
}
}
$admintpl->set("comment",$comment);

 unset($arr2);
 ((mysqli_free_result($subres) || (is_object($subres) && (get_class($subres) == "mysqli_result"))) ? true : false);
 unset($comment);

?>