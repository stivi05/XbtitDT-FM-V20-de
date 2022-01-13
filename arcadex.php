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
      
require_once ("include/functions.php");
dbconn(false);

global $CURUSER,$btit_settings;

$arcadetpl = new bTemplate();
$arcadetpl->set("language",$language);

if ($btit_settings["arc_aw"] == true)
{
$arte=$btit_settings["arc_upl"].' MB upload';
}
else
{
$arte=$btit_settings["arc_sb"].' seedbonus points';
}
$arcadetpl->set("flashscores77",$arte);

for($gameID=1;$gameID<25;$gameID++)
{
$result = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores GROUP BY user;");
while($populate = mysqli_fetch_array($result))
{
if(!isset($totalscore[$populate["user"]]))
{
$totalscore[$populate["user"]]=0;
}
}
$result = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game = ".$gameID." ORDER BY score DESC;");
while($scores = mysqli_fetch_array($result))
{
$ranking = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT COUNT(*) FROM {$TABLE_PREFIX}flashscores WHERE game = ".$gameID." AND score > ".$scores["score"].";") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
if($rankrow = mysqli_fetch_row($ranking))
{
$rank = $rankrow[0]+1;
}
else
{
$rank = 1;
}
if($rank<6)
{
$totalscore[$scores["user"]]+=(10-(($rank-1)*2));
}
}
}
$maxplayed = 0;
$userplayed = 0;
$result = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores GROUP BY user;");
while($flashuser = mysqli_fetch_array($result))
{
$totalresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT COUNT(*) FROM {$TABLE_PREFIX}flashscores WHERE user = '".$flashuser["user"]."';");
if($totaluser = mysqli_fetch_row($totalresult))
{
if($totaluser[0]>$maxplayed)
{
$userplayed = $flashuser["user"];
$maxplayed = $totaluser[0];
}
}
}
$result = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}users WHERE id = ".$userplayed.";");
if($user = mysqli_fetch_array($result))
{
$r3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor,suffixcolor FROM {$TABLE_PREFIX}users_level WHERE id=".$user["id_level"]);
$a3 = mysqli_fetch_array($r3);
$username = ($a3["prefixcolor"].$user["username"].$a3["suffixcolor"]);

}
else
{
$username = "Unknown?!";
}
$yourtotalresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT COUNT(*) FROM {$TABLE_PREFIX}flashscores WHERE user = '".$CURUSER["uid"]."';");
if($yourtotal = mysqli_fetch_row($yourtotalresult))
{
$yourtotalgames = $yourtotal[0];
}
else
{
$yourtotalgames = 0;
}
$maxscore=0;
$maxscoreuser=0;
$result = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores GROUP BY user;");
while($check = mysqli_fetch_array($result))
{
if($totalscore[$check["user"]]>$maxscore)
{
$maxscore=$totalscore[$check["user"]];
$maxscoreuser=$check["user"];
}
}
$result = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}users WHERE id = ".$maxscoreuser.";");
if($user = mysqli_fetch_array($result))
{
$r4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor,suffixcolor FROM {$TABLE_PREFIX}users_level WHERE id=".$user["id_level"]);
$a4 = mysqli_fetch_array($r4);
$usernamescore = ($a4["prefixcolor"].$user["username"].$a4["suffixcolor"]);
}
else
{
$usernamescore = "Unknown?!";
}
$yourscore=$totalscore[$CURUSER["uid"]];

$arcadetpl->set("flashscores40",$yourtotalgames);
$arcadetpl->set("flashscores41",$yourscore);
$arcadetpl->set("flashscores42",$username);
$arcadetpl->set("flashscores43",$usernamescore);
$arcadetpl->set("flashscores44",$maxscore);
$arcadetpl->set("flashscores45",$maxplayed);
?>