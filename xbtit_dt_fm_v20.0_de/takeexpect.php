<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Expected & To Offer Torrents by DiemThuy oct 2010 based on Jboy,s BTI version
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

require_once ("include/functions.php");
require_once ("include/config.php");
dbconn();

if (!$CURUSER || $CURUSER["can_upload"]=="no")
{
     stderr($language["ERROR"],$language["ERR_NOT_AUTH"]);
     stdfoot();
 	 die();
}
else
{
$expecttitle = mysqli_real_escape_string($DBDT,$_POST["expecttitle"]);
$descr = mysqli_real_escape_string($DBDT,$_POST["description"]);
$date = mysqli_real_escape_string($DBDT,$_POST["date"]);
$cat = 0+mysqli_real_escape_string($DBDT,$_POST["category"]);
$type = mysqli_real_escape_string($DBDT,$_POST["type"]);

if($type=="yes")
    $text = "To Offer";
else
	$text = "Expected";

if (!$expecttitle)
  {
     stderr($language["ERROR"],$language["NO_NAME"]);
     stdfoot();
 	 die();
}

$cat = 0+$_POST["category"];
      if ($cat==0)
  {
     stderr($language["ERROR"],$language["WRITE_CATEGORY"]);
     stdfoot();
 	 die();
}

$descr = $_POST["description"];
if (!$descr)
  {
     stderr($language["ERROR"],$language["NO_DESCR"]);
     stdfoot();
 	 die();
}

$expect = sqlesc($expecttitle);
$descr = sqlesc($descr);
$date = sqlesc($date);
$cat = sqlesc($cat);
$type = sqlesc($type);
mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}expected (expect_offer,hits,userid, cat, expect, descr, added, date) VALUES($type,1,$CURUSER[uid], $cat, $expect, $descr, NOW(), $date)") or sqlerr(__FILE__,__LINE__);

global $BASEURL;
$url=("[url=$BASEURL/index.php?page=viewexpected]".$expecttitle."[/url]");
      $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
      $rw=mysqli_fetch_assoc($al);
      $ct =  ($rw["count"]+1);     
do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text, count) VALUES (0,".time().",'system',\"[color=purple]New ".$text." Torrent :[/color] $url  [color=purple]Added By:[/color] ".$CURUSER["username"]."\",".$ct.")");

write_log("$expect " . $language["EXP_ADD_SUCCES"] . "");

header("Refresh: 0; url=index.php?page=viewexpected");
}

?>