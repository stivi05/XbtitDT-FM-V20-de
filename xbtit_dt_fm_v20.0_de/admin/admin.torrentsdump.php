<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    Torrent-dumper 1.1 by Atmoner ( 2013 )
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

$action = $_GET['action'];

if (!empty($action)) {
	// Set cat
	$category = 0;
	$combo_categories=categories($category[0]);
	$admintpl->set("torrent_categories",$combo_categories);

	// Check Rss from extratorrent
	if($action == 'extratorrent') {  
		require_once "include/torrentsdumper/class.extratorrent.php"; 
		$auto = new XbtitExtratorrent;
		if ($auto->getFeedextratorrent($_POST['extratorrent']) === false)
			$check = 'No new torrents on this RSS feed! check back later';
		else
			$check = $auto->getFeedextratorrent($_POST['extratorrent']);
		
		$admintpl->set("getFeed",$check);	
		$admintpl->set("ACTIVE",TRUE,TRUE);
		$admintpl->set("URL_FORM_DUMP", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=extratorrent");
		$admintpl->set("FORM_NAME","extratorrent");
		$admintpl->set("FORM_VALUE",$_POST['extratorrent']);
		$admintpl->set("ICON",'faviconExtra.ico');
		$admintpl->set("TRACKERNAME",'Extratorrent.com');
	}
	// Check Rss from kat
	if($action == 'kat') {  
		require_once "include/torrentsdumper/class.kat.php"; 
		$auto = new XbtitKat;
		if ($auto->getFeedkat($_POST['kat']) === false)
			$check = 'No new torrents on this RSS feed! check back later';
		else
			$check = $auto->getFeedkat($_POST['kat']);
		
		$admintpl->set("getFeed",$check);	
		$admintpl->set("ACTIVE",TRUE,TRUE);
		$admintpl->set("URL_FORM_DUMP", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=kat");
		$admintpl->set("FORM_NAME","kat");
		$admintpl->set("FORM_VALUE",$_POST['kat']);
		$admintpl->set("ICON",'faviconKat.ico');		
		$admintpl->set("TRACKERNAME",'Kat.ph');
	}
	// Check Rss from btchat
	if($action == 'btchat') {  
		require_once "include/torrentsdumper/class.btchat.php"; 
		$auto = new XbtitBtchat;
		if ($auto->getFeedbtchat($_POST['btchat']) === false)
			$check = 'No new torrents on this RSS feed! check back later';
		else
			$check = $auto->getFeedbtchat($_POST['btchat']);
		
		$admintpl->set("getFeed",$check);
		$admintpl->set("ACTIVE",TRUE,TRUE);
		$admintpl->set("URL_FORM_DUMP", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=btchat");
		$admintpl->set("FORM_NAME","btchat");
		$admintpl->set("FORM_VALUE",$_POST['btchat']);
		$admintpl->set("ICON",'faviconBtchat.ico');
		$admintpl->set("TRACKERNAME",'Bt-chat.com');
	}
	// Check Rss from bitsnoop
	if($action == 'bitsnoop') {  
		require_once "include/torrentsdumper/class.bitsnoop.php"; 
		$auto = new XbtitBitsnoop;
		if ($auto->getFeedbitsnoop($_POST['bitsnoop']) === false)
			$check = 'No new torrents on this RSS feed! check back later';
		else
			$check = $auto->getFeedbitsnoop($_POST['bitsnoop']);
		
		$admintpl->set("getFeed",$check);		
		$admintpl->set("ACTIVE",TRUE,TRUE);
		$admintpl->set("URL_FORM_DUMP", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=bitsnoop");
		$admintpl->set("FORM_NAME","bitsnoop");
		$admintpl->set("FORM_VALUE",$_POST['bitsnoop']);
		$admintpl->set("ICON",'faviconBitsnoop.ico');
		$admintpl->set("TRACKERNAME",'Bitsnoop.com');
	}
	// Check Rss from fenopy
	if($action == 'fenopy') {  
		require_once "include/torrentsdumper/class.fenopy.php"; 
		$auto = new XbtitFenopy;
		if ($auto->getFeedfenopy($_POST['fenopy']) === false)
			$check = 'No new torrents on this RSS feed! check back later';
		else
			$check = $auto->getFeedfenopy($_POST['fenopy']);
		
		$admintpl->set("getFeed",$check);		
		$admintpl->set("ACTIVE",TRUE,TRUE);
		$admintpl->set("URL_FORM_DUMP", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=fenopy");
		$admintpl->set("FORM_NAME","fenopy");
		$admintpl->set("FORM_VALUE",$_POST['fenopy']);
		$admintpl->set("ICON",'faviconFenopy.ico');
		$admintpl->set("TRACKERNAME",'Fenopy.eu');
	}
	// Check Rss from limetorrents
	if($action == 'limetorrents') {  
		require_once "include/torrentsdumper/class.limetorrents.php"; 
		$auto = new XbtitLimetorrents;
		if ($auto->getFeedlimetorrents($_POST['limetorrents']) === false)
			$check = 'No new torrents on this RSS feed! check back later';
		else
			$check = $auto->getFeedlimetorrents($_POST['limetorrents']);
		
		$admintpl->set("getFeed",$check);	
		$admintpl->set("ACTIVE",TRUE,TRUE);
		$admintpl->set("URL_FORM_DUMP", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=limetorrents");
		$admintpl->set("FORM_NAME","limetorrents");
		$admintpl->set("FORM_VALUE",$_POST['limetorrents']);
		$admintpl->set("ICON",'faviconLime.ico');
		$admintpl->set("TRACKERNAME",'limetorrents.com');
	}	
	// Check Rss from thepiratebay
	if($action == 'thepiratebay') {  
		require_once "include/torrentsdumper/class.thepiratebay.php"; 
		$auto = new XbtitThepiratebay;
		if ($auto->getFeedthepiratebay($_POST['thepiratebay']) === false)
			$check = 'No new torrents on this RSS feed! check back later';
		else
			$check = $auto->getFeedthepiratebay($_POST['thepiratebay']);
		
		$admintpl->set("getFeed",$check);	
		$admintpl->set("ACTIVE",TRUE,TRUE);
		$admintpl->set("URL_FORM_DUMP", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=thepiratebay");
		$admintpl->set("FORM_NAME","thepiratebay");
		$admintpl->set("FORM_VALUE",$_POST['thepiratebay']);
		$admintpl->set("ICON",'faviconPb.ico');
		$admintpl->set("TRACKERNAME",'Thepiratebay.com');		
	}	
	// Check Rss from mnova
	if($action == 'mnova') {  
		require_once "include/torrentsdumper/class.mnova.php"; 
		$auto = new XbtitMnova;
		if ($auto->getFeedmnova($_POST['mnova']) === false)
			$check = 'No new torrents on this RSS feed! check back later';
		else
			$check = $auto->getFeedmnova($_POST['mnova']);
		
		$admintpl->set("getFeed",$check);	
		$admintpl->set("ACTIVE",TRUE,TRUE);
		$admintpl->set("URL_FORM_DUMP", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=mnova");
		$admintpl->set("FORM_NAME","mnova");
		$admintpl->set("FORM_VALUE",$_POST['mnova']);
		$admintpl->set("ICON",'faviconMnova.ico');
		$admintpl->set("TRACKERNAME",'Mnova.eu');		
	}						
} else {

// Page back 
$admintpl->set("frm_action_bitsnoop", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=bitsnoop");
$admintpl->set("frm_action_pb", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=pb"); 
$admintpl->set("frm_action_extratorrent", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=extratorrent");
$admintpl->set("frm_action_kat", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=kat");
$admintpl->set("frm_action_btchat", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=btchat");
$admintpl->set("frm_action_fenopy", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=fenopy");
$admintpl->set("frm_action_limetorrents", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=limetorrents");
$admintpl->set("frm_action_thepiratebay", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=thepiratebay");
$admintpl->set("frm_action_mnova", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump&amp;action=mnova");
 
$admintpl->set("ACTIVE",FALSE,TRUE);
}
?>