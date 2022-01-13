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

global $BASEURL,$CURUSER;

$HTMLOUT ="";

if ($CURUSER["admin_access"]=="no")
stderr("access denied !!");

$id = isset($_GET['id']) && is_valid_id($_GET['id']) ? $_GET['id'] : 0;

$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betgames where id = ".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
if(mysqli_num_rows($res) < 1)
stderr("Error", "No game with that ID. Contact the coder.");
$res = mysqli_fetch_array($res);
$message = $res["heading"];


$res1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}bets where gameid = ".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
if(mysqli_num_rows($res1) < 1)
stderr("Error", "No game with that ID. Contact the coder.");
$bets = mysqli_num_rows($res1);

$a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `{$TABLE_PREFIX}betlog` WHERE `msg` LIKE '%".$message."%'") or sqlerr(__FILE__, __LINE__);
if(mysqli_num_rows($a) < 1 || mysqli_num_rows($a) > 1000)
stderr(	"Error", "No bonus log with similar message. Contact the coder.");

$whoopsie = 0;

$log = mysqli_num_rows($a);

if(isset($_GET["shite"]))

$shite = 1;
else
$shite = 0;

$res3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}bets where gameid = ".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
$bets = mysqli_num_rows($res3);
if($log != $bets && $shite == 0)
{
stderr("Error", "Number of operations and bonus logs entered did not match. ".htmlspecialchars($log). " vs ".htmlspecialchars($bets)." Contact the coder...<br />Fuck it... <a href='index.php?page=betback&id=".$id."&amp;shite=1'><u>Do it anyway</u></a>");
}
else
{
$added = sqlesc(time());
while($res3 = mysqli_fetch_array($a))
	{
	$uid = (int) $res3['userid'];
	$s = strrpos($res3['msg'], "-");
	$points = substr($res3['msg'], $s);
	$s = strpos($points,"Points");
	$points = substr($points, 0, $s);	
	$HTMLOUT .="".$points." -> ";
	$HTMLOUT .="".$res3['msg']."<br />";	
	mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET seedbonus = seedbonus-".sqlesc($points)." WHERE id =".sqlesc($uid)." LIMIT 1") or sqlerr(__FILE__, __LINE__);
	$subject = sqlesc("Betting Rebate");
	$msg = sqlesc("You have got back the ".$points." Points you bet on ".$message." It was reset because of errors or unfinished/unplayed matches.");	
	send_pm (0,$uid, $msg, $subject);
	$msg2 = sqlesc("Bet-bonus at stake: ".$message." <b>".$points." Points</b>");
	mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}betlog(userid,msg,date,bonus) VALUES($uid, $msg2, $added, $points)") or sqlerr(__FILE__, __LINE__);
  $whoopsie -= $points;
	}
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}betgames WHERE id =".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}bets WHERE gameid = ".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}bets WHERE id = ".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}betoptions WHERE gameid = ".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}betlog WHERE msg LIKE '%".$message."%'") or sqlerr(__FILE__, __LINE__);
$betbacktpl = new bTemplate();
$betbacktpl->set("language", $language);
$betbacktpl->set(betback,$HTMLOUT);
}

?>