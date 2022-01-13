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
      
require_once("include/functions.php");
dbconn();

global   $CURUSER, $XBTT_USE;

$xmasday= mktime(0,0,0,12,25,date("Y"));
$today = mktime(date("G"), date("i"), date("s"), date("m"), date("d"), date("Y"));
$gifts = array("upload", "bonus");
$randgift = array_rand($gifts);
$gift = $gifts[$randgift];
$userid = 0 + $CURUSER["uid"];
if (!is_valid_id($userid))
    stderr("Error", "Invalid ID");
$open = 0 + $_GET["open"];
if ($open != 1) {
    stderr("Error", "Invalid url");
}
if (isset($open) && $open == 1) {
    if ($today >= $xmasday) {
        if ($CURUSER["gotgift"] == 'no') {
                if ($gift == "upload") {
                if($XBTT_USE)
                    do_sqlquery("UPDATE `xbt_users` `xu` LEFT JOIN `{$TABLE_PREFIX}users` `u` ON `xu`.`uid`=`u`.`id` SET `xu`.`uploaded`=`xu`.`uploaded`+1024*1024*1024*10, `u`.`gotgift`='yes' WHERE `xu`.`uid`=".sqlesc($userid),true);
                else
                    do_sqlquery("UPDATE {$TABLE_PREFIX}users SET uploaded=uploaded+1024*1024*1024*10, gotgift='yes' WHERE id=".sqlesc($userid),true);
                header('Refresh: 8; url=index.php');
                stderr("Congratulations!", "<img src=\"images/gift.png\" style=\"float: left; padding-right:10px;\" alt=\"Xmas Gift\" title=\"Xmas Gift\" /> <h2> You just got  10 GB upload !</h2>
Thanks for your support and sharing through year ".date('Y')." ! <br /> Merry Christmas and a happy New Year from {$SITENAME}  Crew ! Redirecting in 8..7..6..5..4..3..2..1");
            }
            if ($gift == "bonus") {
                mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET seedbonus = seedbonus + 1000 , gotgift='yes' WHERE id=".sqlesc($userid)."") or sqlerr(__FILE__, __LINE__);
                header('Refresh: 8; url=index.php');
                stderr("Congratulations!", "<img src=\"images/gift.png\" style=\"float: left; padding-right:10px;\" alt=\"Xmas Gift\" title=\"Xmas Gift\" /> <h2> You just got 1000 seed bonus points !</h2>
Thanks for your support and sharing through year ".date('Y')." ! <br /> Merry Christmas and a happy New Year from {$SITENAME}  Crew ! Redirecting in 8..7..6..5..4..3..2..1");
            }

        } else {
            stderr("Sorry...", "You already got your gift !");
        }
    } else {
        stderr("Doh...", "Be patient!  You can't open your present until Christmas day ! <b>" . date("j", ($xmasday - $today)) . "</b> day(s) to go. <br /> Today:<b>" . date('l dS \of F Y h:i:s A', $today) . "</b><br />Christmas day:<b>" . date('l dS \of F Y h:i:s A', $xmasday)."</b>");
    }
    }
?>