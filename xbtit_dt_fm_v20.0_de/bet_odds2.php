<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//   SPORT BETTING HACK , orginal TBDEV 2009 by Soft & Bigjoos 
//   XBTIT conversion by DiemThuy , April 2010
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

global $BASEURL,$CURUSER,$btit_settings;

if ($btit_settings["min_bet"]=="false")
{
stderr("Sorry", "You have no acces to betting.");
}

$id = isset($_POST['id']) && is_valid_id($_POST['id']) ? $_POST['id'] : 0;
$bonus = (int) $_POST['bonus'];

$resdt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from {$TABLE_PREFIX}users where id =".$CURUSER["uid"]."") or sqlerr(__FILE__, __LINE__);
$dts = mysqli_fetch_assoc($resdt);

if($dts['seedbonus'] < $bonus){
stderr("Sorry", "You do not have enough bonus points !");
exit;
}

if($dts['seedbonus'] < $bonus || $bonus < 1){
stderr("Sorry", "You can not bet minus !");
exit;
}

if($bonus > $btit_settings['max_bon_bet'] ){
stderr("Sorry", "you can bet max ".$btit_settings['max_bon_bet']." bonus points !");
exit;
}

$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betoptions WHERE id =".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
$a = mysqli_fetch_assoc($res);
$gameid = (int) $a['gameid'];

if($gameid== 0){
header("location: $BASEURL/index.php?page=bet");
exit;
}


$res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from {$TABLE_PREFIX}betgames where id =".sqlesc($gameid)."") or sqlerr(__FILE__, __LINE__);
$s = mysqli_fetch_assoc($res2);

if($s['active'] == 0){
header("location: $BASEURL/index.php?page=bet");
exit;
}

$k = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}bets WHERE optionid = ".sqlesc($a["id"])." AND userid =".sqlesc($CURUSER["uid"])."") or sqlerr(__FILE__, __LINE__);
if(mysqli_num_rows($k) > 0)
{
stderr(	"Sorry", "You've already invested in this game!");
}


$tid = time();

mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}bets(gameid,bonus,optionid,userid,date) VALUES(".sqlesc($gameid).", ".sqlesc($bonus).", ".sqlesc($id).", ".sqlesc($CURUSER["uid"]).", '$tid')") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET seedbonus = seedbonus -".sqlesc($bonus)." WHERE id =".sqlesc($CURUSER["uid"])."") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}betlog(userid,date,msg,bonus) VALUES($CURUSER[uid], '$tid', 'Bet. ".$s['heading']." -> ".$a['text']."-".$bonus." Points.',-$bonus)") or sqlerr(__FILE__, __LINE__);

$e = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betoptions WHERE gameid =".sqlesc($gameid)."") or sqlerr(__FILE__, __LINE__);
while($f = mysqli_fetch_assoc($e))
{

$optionid = $f['id'];
$total = 0;
$optiontotal = 0;

$b = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}bets WHERE gameid = ".sqlesc($gameid)."") or sqlerr(__FILE__, __LINE__);
while($c = mysqli_fetch_assoc($b))
{
$total += $c['bonus'];
if($c['optionid'] == $optionid)
$optiontotal += $c['bonus'];
}
if($optiontotal == 0)
$odds = 0.00;
else
$odds = number_format($total/$optiontotal, 2, '.', '');
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}betoptions SET odds = ".sqlesc($odds)." WHERE id = ".sqlesc($optionid)."") or sqlerr(__FILE__, __LINE__);
}

header("location: $BASEURL/index.php?page=betcoupon");
?>