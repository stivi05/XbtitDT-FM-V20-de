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

		
$id2 = (int)$_POST["id"];
$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}expected WHERE id=$id2");
$row = mysqli_fetch_array($res);

if ($CURUSER["uid"] == $row["userid"] || $CURUSER["can_upload"] == "yes")
{
	$expecttitle = mysqli_real_escape_string($DBDT,$_POST["expecttitle"]);
	$descr = $_POST["description"];
	$date = mysqli_real_escape_string($DBDT,$_POST["date"]);
	$cat = mysqli_real_escape_string($DBDT,$_POST["category"]);
	$id = (int)$_POST["id"];
	$uploaded = mysqli_real_escape_string($DBDT,$_POST["uploaded"]?"yes":"no");
	$torrenturl = mysqli_real_escape_string($DBDT,$_POST["torrenturl"]);
	$type = mysqli_real_escape_string($DBDT,$_POST["type"]);

	
	if ($expecttitle=="" || $cat==0 || $descr=="" )
	{

     stderr($language["ERROR"],$language["ERR_MISSING_DATA"]);
     stdfoot();
 	 die();
	}
	
	$expect = sqlesc($expecttitle);
	$descr = sqlesc($descr);
	$date = sqlesc($date);
	$cat = sqlesc($cat);
	$upl = sqlesc($uploaded);
	$torurl = sqlesc($torrenturl);
	$tpe = sqlesc($type);
	
	
	mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}expected SET expect_offer=$tpe, cat=$cat, expect=$expect, descr=$descr, date=$date, uploaded=$upl, torrenturl=$torurl WHERE id=$id");

//pm
if($type=='yes' AND $uploaded=='yes')
{
$ms=sqlesc("Some time ago, you voted for the torrent: ".$expecttitle."\n\n
We like to lett you know it is uploaded and you can get it here :\n\n
[url]".$torrenturl."[/url]\n\n
[color=red][b]THIS IS AN AUTOMATIC SYSTEM MESSAGE PLEASE DON,T REPLY[/b][/color]");	

$res = mysqli_query($GLOBALS["___mysqli_ston"], "select userid from {$TABLE_PREFIX}addedexpected where expectid = ".$id) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
while($row = mysqli_fetch_array($res))
{
$kk=$row["userid"];
send_pm(0,$kk,sqlesc('Voted offer is uploaded'),$ms);
}
}
//pm end	
	
	header("Refresh: 0; url=index.php?page=viewexpected");
}
else
{

     stderr($language["ERROR"],$language["ERR_NOT_AUTH"]);
     stdfoot();
 	 die();
}

?>