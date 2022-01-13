<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Report torrent/user hack by DiemThuy - march 2009
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
      
require_once("include/functions.php");

$takeuser = $_POST["user"];
$taketorrent = $_POST["torrent"];
$takereason = mysqli_real_escape_string($DBDT,$_POST["reason"]);
$user = $_GET["user"];
$torrent = $_GET["torrent"];
$reporter = $CURUSER['uid'];

if ((isset($takeuser)) && (isset($takereason)))
{
$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}reports WHERE addedby = '$reporter' AND votedfor = '$takeuser' AND type = 'user'");// or sqlerr();
if (mysqli_num_rows($res) == 0)
{
mysqli_query($GLOBALS["___mysqli_ston"], "INSERT into {$TABLE_PREFIX}reports (addedby,votedfor,type,reason) VALUES ('$reporter','$takeuser','user', '$takereason')");// or sqlerr();
$res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE id = '$takeuser'");
$arr2 = mysqli_fetch_assoc($res2);
$name = $arr2[username];

        information_msg("Successfully Reported","<a href=index.php?page=userdetails&id=$takeuser&returnto=index.php?page=reports>$name</a><p></p><br>A member of staff will look into the problem as soon as possible");
        stdfoot();
        exit();

}
else
{
$res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE id = '$takeuser'");
$arr2 = mysqli_fetch_assoc($res2);
$name = $arr2[username];

        stderr("error","You have already reported <a href=index.php?page=userdetails&id=$takeuser&returnto=index.php?page=reports>$name</a>");
        stdfoot();
        exit();

}
}
if ((isset($taketorrent)) && (isset($takereason)))
{
$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}reports WHERE addedby = '$reporter' AND votedfor = '$taketorrent' AND type = 'torrent'");
if (mysqli_num_rows($res) == 0){
mysqli_query($GLOBALS["___mysqli_ston"], "INSERT into {$TABLE_PREFIX}reports (addedby,votedfor,type,reason) VALUES ('$reporter','$taketorrent','torrent', '$takereason')");
$res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filename FROM {$TABLE_PREFIX}files WHERE info_hash = '$taketorrent'");
$arr2 = mysqli_fetch_assoc($res2);
$name = $arr2[filename];

        information_msg("Successfully Reported","<a href=index.php?page=torrent-details&id=$taketorrent&returnto=reports.php>$name</a><p></p>A member of staff will look into the problem as soon as possible");
        stdfoot();
        exit();

}
else
{
$res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filename FROM {$TABLE_PREFIX}files WHERE info_hash = '$taketorrent'");
$arr2 = mysqli_fetch_assoc($res2);
$name = $arr2[filename];

        stderr("error","You have already reported <br><a href=index.php?page=torrent-details&id=$taketorrent&returnto=index.php?page=reports>$name</a>");
        stdfoot();
        exit();

}
}
if (isset($user))
{
$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, username, id_level FROM {$TABLE_PREFIX}users WHERE id='$user'");// or sqlerr();
if (mysqli_num_rows($res) == 0)
{

        stderr("report error","Invalid UserID");
        stdfoot();
        exit();

}
$arr = mysqli_fetch_assoc($res);
$zap = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level FROM {$TABLE_PREFIX}users_level WHERE id = $arr[id_level]");
$wyn = mysqli_fetch_array($zap);
if ($wyn["id_level"] > 5)
{

        stderr("report error","Staff can't be reported");
        stdfoot();
        exit();

}
	elseif ($reporter==$user)
	{
        stderr("report error","you can't report yourself");
        stdfoot();
        exit();
	}
else
{

        information_msg("Report User","Are you sure you would like to report user <br><br><a href=index.php?page=userdetails&id=$arr[id]><b>$arr[username]</b></a>?<br><br>Please note, this is <b>not</b> to be used to report Hit & Run , this is done by the tracker itself<br><br><b>Reason</b><form method=post action=index.php?page=report><input type=hidden name=user value=$user><input type=text size=100 name=reason><p></p><input type=submit class=btn value=Confirm></form>");
        stdfoot();
        exit();

}
}
if (isset($torrent))
{
$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filename FROM {$TABLE_PREFIX}files WHERE info_hash='$torrent'");
if (mysqli_num_rows($res) == 0)
{

        stderr("report error","Invalid TorrentID $torrent");
        stdfoot();
        exit();

}
$arr = mysqli_fetch_array($res);

        information_msg("Torrent Report","Are you sure you would like to report torrent <br><br><a href=index.php?page=details&id=$torrent><b>$arr[filename]</b></a>?<br><br><b>Reason</b><form method=post action=index.php?page=report><input type=hidden name=torrent value=$torrent><input type=text size=100 name=reason><p></p><input type=submit class=btn value=Confirm></form>");
        stdfoot();
        exit();
}

?>