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

require_once("include/functions.php");
dbconn();

if (!defined("IN_BTIT"))
      die("non direct access!");
      
      if ($CURUSER["id_level"]<$btit_settings["banbutton"])
{
	redirect("index.php?page=users"); // redirects to users.php if no staff
	exit();
}

$do = $_GET["do"];
$ban_id = $_GET["ban_id"];


$banbuttontpl= new bTemplate();
$banbuttontpl-> set("language",$language);
$banbuttontpl->set("form","<form method=post action=index.php?page=banbutton&do=add&ban_id=".$ban_id.">");

// Add member to banlist

if ($do=="add")
{
(isset($_GET["ban_id"]) && is_numeric($_GET["ban_id"])) ? $ban_id=$_GET["ban_id"]  : $ban_id=0;

    $qry = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE id = '$ban_id'");
	$res = mysqli_fetch_array($qry);

                 $user = $res["username"];
                 $comment =$_POST["comment"];
                 $info =  ($user. '-' .$comment);
                 $by = $CURUSER["uid"];

do_sqlquery("UPDATE {$TABLE_PREFIX}users SET ban ='yes' , ban_comment ='".mysqli_real_escape_string($DBDT,$info)."' , ban_added_by =".$by." , ban_added=UNIX_TIMESTAMP() WHERE id=".$ban_id );

signup_ip_ban(long2ip($res["lip"]),$info);

redirect("index.php?page=users");
}
?>