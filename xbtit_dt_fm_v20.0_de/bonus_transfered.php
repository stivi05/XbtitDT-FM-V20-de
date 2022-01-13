<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// created By virus - Converted to english by reBirth - Converted for xbtit by cooly/Petr1fied
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

if ($_SERVER["REQUEST_METHOD"] != "POST")
    stderr("Error", "Method");

$resuser=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER["uid"]);
$rowuser=mysqli_fetch_array($resuser);

(isset($_POST["username"]) && !empty($_POST["username"])) ? $username = mysqli_real_escape_string($DBDT,$_POST["username"]) : $username = "";
(isset($_POST["bonuszpont"]) && !empty($_POST["bonuszpont"]) && is_numeric($_POST["bonuszpont"])) ? $bonuszpont = $_POST["bonuszpont"] : $bonuszpont = 0;

if(!$CURUSER || $CURUSER["uid"]==1)
{
    stderr ("Error","please login!");
    stdfoot();
    exit();
}
if($username=="")
{
    stderr ("Error","You didn't enter a name!");
    stdfoot();
    exit();
}
if ($bonuszpont <=0)
{
    stderr ("Error","Not a positive value");
    stdfoot();
    exit();
}
if($bonuszpont > $rowuser["seedbonus"])
{
    stderr ("Error","You can't transfer more points than you have!");
    stdfoot();
    exit();
}
if($CURUSER["username"]==$username)
{
    stderr ("Error","You can't transfer points to yourself!");
    stdfoot();
    exit();
}

$mb = 1024*1024;
$gb = 1024*1024*1024;
$tb = 1024*1024*1024*1024;

if ($_POST["unit"] == 'mb')
    $bonuszpont = $bonuszpont*$mb;
elseif ($_POST["unit"] == 'gb')
    $bonuszpont = $bonuszpont*$gb;
elseif ($_POST["unit"] == 'tb')
    $bonuszpont = $bonuszpont*$tb;

$query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id,seedbonus FROM {$TABLE_PREFIX}users WHERE username = '$username'") or sqlerr(__FILE__, __LINE__);
$res = mysqli_fetch_assoc($query);
$kapo = $res["id"];
$kuldo = $rowuser["id"];

if (!$kapo)
    stderr ("Error","Woops, can't find anyone with That name.");

mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET seedbonus = seedbonus + $bonuszpont WHERE id = '$kapo'") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET seedbonus = seedbonus - $bonuszpont WHERE id = '$kuldo'") or sqlerr(__FILE__, __LINE__);

if ($_POST["anonym"] != 'anonym') {

//pm subject here
$targy = sqlesc("Bonus points received");

//pm message text here
$msg = sqlesc("User " . $CURUSER['username']. " left something for you: $bonuszpont bonus point.");

send_pm(0,$kapo,$targy,$msg);
}
else {

$targy = sqlesc("Bonus points received");
$msg = sqlesc("An anonymous user left this for you: $bonuszpont bonus point.");
send_pm(0,$kapo,$targy,$msg);
}

success_msg("Job Done","Bonus points Successfully sent to $username");
stdfoot();
exit();

?>