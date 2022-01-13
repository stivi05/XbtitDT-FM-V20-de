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

if (!defined("IN_ACP"))
      die("non direct access!");

$admintpl->set("language", $language);
$admintpl->set("bj_blackjack_stake", $btit_settings["bj_blackjack_stake"]/1048576);
$admintpl->set("bj_blackjack_prize", $btit_settings["bj_blackjack_prize"]);
$admintpl->set("bj_normal_prize", $btit_settings["bj_normal_prize"]);
$admintpl->set("random", $CURUSER["random"]);
$admintpl->set("uid", $CURUSER["uid"]);
$admintpl->set("firstview", (($_POST["action"]=="Update")?FALSE:TRUE), TRUE);

if($_POST["action"]=="Update")
{
    (isset($_POST["stake"]) && !empty($_POST["stake"])?$stake=intval($_POST["stake"]*1048576):$stake=0);
    (isset($_POST["bprize"]) && !empty($_POST["bprize"])?$bprize=number_format($_POST["bprize"],1):$bprize=0);
    (isset($_POST["nprize"]) && !empty($_POST["nprize"])?$nprize=number_format($_POST["nprize"],1):$nprize=0);
                
    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`=$stake WHERE `key`='bj_blackjack_stake'");
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"])==0)
       do_sqlquery("INSERT INTO `{$TABLE_PREFIX}settings` SET `value`=$stake, `key`='bj_blackjack_stake'");

    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`=$bprize WHERE `key`='bj_blackjack_prize'");
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"])==0)
       do_sqlquery("INSERT INTO `{$TABLE_PREFIX}settings` SET `value`=$bprize, `key`='bj_blackjack_prize'");

    do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='$nprize' WHERE `key`='bj_normal_prize'");
    if (mysqli_affected_rows($GLOBALS["___mysqli_ston"])==0)
       do_sqlquery("INSERT INTO `{$TABLE_PREFIX}settings` SET `value`='$nprize', `key`='bj_normal_prize'");
}

?>