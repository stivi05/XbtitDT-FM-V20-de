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
require_once ("include/functions.php");
require_once ("include/config.php");
dbconn();
global $CURUSER, $FORUMLINK, $db_prefix, $INVITATIONSON ;
  if ($CURUSER["uid"] > 1)
    {
$id=$_GET['id'];
if($id=="vip"){
$uid=$CURUSER["uid"];
$r=do_sqlquery("SELECT seedbonus FROM {$TABLE_PREFIX}users WHERE id=$uid");
$u=mysqli_result($r,0,"seedbonus");
if($u<$GLOBALS["price_vip"] OR $CURUSER["id_level"]>=5) {
header("Location: index.php?page=modules&module=seedbonus");
}else {
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET id_level=5, seedbonus=seedbonus-".$GLOBALS["price_vip"]." WHERE id=$uid");
// sb control
@mysqli_query($GLOBALS["___mysqli_ston"], "INSERT into {$TABLE_PREFIX}sb (id,what,gb,points,date) VALUES ('$uid','Vip','0', '".$GLOBALS["price_vip"]."',NOW())");
// sb control
if ($FORUMLINK=="smf")
    {do_sqlquery("UPDATE {db_prefix}members SET ID_GROUP=15 WHERE ID_MEMBER=".$CURUSER["smf_fid"]);}
header("Location: index.php?page=modules&module=seedbonus");
}
die(" ");
}

if($id=="inv"){
$uid=$CURUSER["uid"];
$r=do_sqlquery("SELECT seedbonus FROM {$TABLE_PREFIX}users WHERE id=$uid");
$u=mysqli_result($r,0,"seedbonus");
if($u<$GLOBALS["price_inv"] AND $INVITATIONSON) {
header("Location: index.php?page=modules&module=seedbonus");
}else {
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET invitations=invitations+1, seedbonus=seedbonus-".$GLOBALS["price_inv"]." WHERE id=$uid"); 
// sb control
@mysqli_query($GLOBALS["___mysqli_ston"], "INSERT into {$TABLE_PREFIX}sb (id,what,gb,points,date) VALUES ('$uid','Invitation','0', '".$GLOBALS["price_inv"]."',NOW())");
// sb control
header("Location: index.php?page=modules&module=seedbonus");
}
die(" ");
}
 
if(is_null($id)||!is_numeric($id)||$CURUSER["view_torrents"]=="no"){
header("Location: index.php");
}
$r=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}bonus WHERE id='$id'");
$p=mysqli_result($r,0,"points");
$t=mysqli_result($r,0,"traffic");
$uid=$CURUSER["uid"];
$r=do_sqlquery("SELECT seedbonus FROM {$TABLE_PREFIX}users WHERE id=$uid");
$u=mysqli_result($r,0,"seedbonus");
if($u<$p) {
header("Location: index.php?page=modules&module=seedbonus");
}else {
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET uploaded=uploaded+$t,seedbonus=seedbonus-$p WHERE id=$uid");
// sb control

mysqli_query($GLOBALS["___mysqli_ston"], "INSERT into {$TABLE_PREFIX}sb (id,what,gb,points,date) VALUES ('$uid','Upload','$t', '$p',NOW())");
// sb control
header("Location: index.php?page=modules&module=seedbonus");
}}
else header("Location: index.php");
?>