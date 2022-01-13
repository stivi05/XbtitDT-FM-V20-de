<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit ( XBTIT DT FM V20 DE )
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


if (file_exists("install.unlock") && file_exists("install.php"))
   {
   if (dirname($_SERVER["PHP_SELF"])=="/" || dirname($_SERVER["PHP_SELF"])=="\\")
      header("Location: http://".$_SERVER["HTTP_HOST"]."/install.php");
   else
      header("Location: http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/install.php");
   exit;
}

define("IN_BTIT",true);


$THIS_BASEPATH=dirname(__FILE__);

include("$THIS_BASEPATH/btemplate/bTemplate.php");

require("$THIS_BASEPATH/include/functions.php");

session_name("xbtit");
session_start();
dbconn(true);

global $btit_settings,$BASEURL;

if($_SERVER['HTTPS']=”on” AND $btit_settings['ssl']== true)
{
$BASEURL=str_replace("http","https",$BASEURL);
}

// If they've updated to SMF 2.0 and their tracker settings still thinks they're using SMF 1.x.x force an update
if($FORUMLINK=="smf")
{
    $check_ver=get_result("SELECT `value` FROM `{$db_prefix}settings` WHERE `variable`='smfVersion'", true, 60);
    if(((int)substr($check_ver[0]["value"],0,1))==2)
        do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='smf2' WHERE `key`='forum'",true);
    foreach (glob($THIS_BASEPATH."/cache/*.txt") as $filename)
        unlink($filename);
}

$sp = $_SERVER['SERVER_PORT']; $ss = $_SERVER['HTTPS']; if ( $sp =='443' || $ss == 'on' || $ss == '1') $p = 's';
$domain = 'http'.$p.'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$domain = str_replace('/index.php', '', $domain);

if ($BASEURL != $domain) {
 $currentFile = $_SERVER['REQUEST_URI']; preg_match("/[^\/]+$/",$currentFile,$matches);
 $filename = "/" . $matches[0];
 header ("Location: " . $BASEURL . $filename . "");          
}

$time_start = get_microtime();

clearstatcache();

$style_css=load_css("main.css");

$idlang=intval($_GET["language"]);

$pageID=(isset($_GET["page"])?$_GET["page"]:"");

$no_columns=(isset($_GET["nocolumns"]) && intval($_GET["nocolumns"])==1?true:false);

//which module by cooly
if($pageID=="modules")
{
$MID=(isset($_GET["module"])?htmlentities($_GET["module"]):$MID="");
check_online(session_id(), ($MID==""?"index":$MID));
}else{
check_online(session_id(), ($pageID==""?"index":$pageID));
}

require(load_language("lang_main.php"));

////////////////////////////ARCADE/////////////////////
$arcswitch =mysqli_query($GLOBALS["___mysqli_ston"],"SELECT status FROM {$TABLE_PREFIX}blocks WHERE content = 'arcade'");
$arcon=mysqli_fetch_array($arcswitch);
if ($arcon["status"]=='1')
{

$user = $CURUSER['uid'];

$arcuser =mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}users WHERE id = ".$user);
$arcus=mysqli_fetch_array($arcuser);

$arcadeuser = $arcus["username"];

$upbon=($btit_settings["arc_upl"]*1024*1024);
$seedbon=$btit_settings["arc_sb"];
if ($btit_settings["arc_aw"] == true)
{
$arte=$btit_settings["arc_upl"].' MB upload';
}
else
{
$arte=$btit_settings["arc_sb"].' seedbonus points';
}

if($_GET["act"]=="Arcade")
    {
     
// flood protection
$arflood =mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores ORDER BY date DESC LIMIT 1");
$arcflow=mysqli_fetch_array($arflood);
$time_A=strtotime(now);
$time_B = strtotime($arcflow["date"]);
if (($time_A-$time_B)<10)
{
redirect("index.php?page=arcadex");
}
else
{ 
 
if($_POST['gname'] == "yeti1")
  {
$game = 1;
$level = 1;
$score = $_POST['gscore'];
$ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='1' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Yeti Penguin\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Yeti Penguin is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/yeti11.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
if($_POST['gname'] == "yetitoursm")
{
 $game = 2;
 $level = 1;
 $score = $_POST['gscore'];
$ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='2' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Yeti Pentathlon\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Yeti Pentathlon is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/yetitoursm1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
if($_POST['gname'] == "yeti7")
{
 $game = 3;
 $level = 1;
 $score = $_POST['gscore'];
$ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='3' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Yeti Snowboard\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Yeti Snowboard is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/yeti71.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
  if($_POST['gname'] == "yeti6")
  {
 $game = 4;
 $level = 1;
 $score = $_POST['gscore'];
$ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='4' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Yeti BigWave\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Yeti BigWave is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/yeti61.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
  if($_POST['gname'] == "yeti5pro")
  {
 $game = 5;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='5' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Yeti Safari\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Yeti Safari is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/yeti5pro1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
  if($_POST['gname'] == "pacman")
  {
 $game = 6;
 $level = 1;
 $score = $_POST['gscore'];
  $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='6' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Pacman\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
 if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Pacman is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/pacman1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
  if($_POST['gname'] == "yeti4")
  {
 $game = 7;
 $level = 1;
 $score = $_POST['gscore'];
$ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='7' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Yeti Overload\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Yeti Overload is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/yeti41.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
  }
  if($_POST['gname'] == "summergames04")
  {
 $game = 8;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='8' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Summergames\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Summergames is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/summergames041.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
  }
  if($_POST['gname'] == "yeti_stagedive")
  {
 $game = 9;
 $level = 1;
 $score = $_POST['gscore'];
$ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='9' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Yeti StageDive\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Yeti StageDive is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/yeti_stagedive1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
  }
  if($_POST['gname'] == "BubbleShooterSte")
  {
 $game = 10;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='10' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Bubble Shooter\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Bubble Shooter is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/BubbleShooterSte1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
  }
    if($_POST['gname'] == "SuperFlashMarioBrosSte")
  {
 $game = 11;
 $level = 1;
 $score = $_POST['gscore'];
$ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='11' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Super Mario Bros\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Super Mario Bros is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/SuperFlashMarioBrosSte1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
  }
      if($_POST['gname'] == "blackknight")
  {
 $game = 12;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='12' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Black Knight\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Black Knight is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/blackknight1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
  }
        if($_POST['gname'] == "matrix_dock_defense_Ste")
  {
 $game = 13;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='13' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Matrix Dock Defense\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Matrix Dock Defense is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);
    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/matrix_dock_defense_Ste1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
  }
        if($_POST['gname'] == "fishermansam")
  {
 $game = 14;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='14' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Fisherman Sam\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Fisherman Sam is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);
    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/fishermansam1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
  }
if($_POST['gname'] == "alloyarena")
  {
 $game = 15;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='15' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Alloy Arena\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Alloy Arena is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/alloyarena1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
if($_POST['gname'] == "BabycalThrowSte")
  {
 $game = 16;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='16' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Babycal Throw\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
  if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Babycal Throw is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/BabycalThrowSte1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
if($_POST['gname'] == "junglekidSte")
  {
 $game = 17;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='17' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Jungle Kid\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
 if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Jungle Kid is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/junglekidSte1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
if($_POST['gname'] == "supersplashBH")
  {
 $game = 18;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='18' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Super Splash\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Super Splash is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/supersplashBH1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}

if($_POST['gname'] == "autobahn")
  {
 $game = 19;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='19' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Auto Bahn\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Auto Bahn is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/autobahn1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}

if($_POST['gname'] == "chainreactionGS")
  {
 $game = 20;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = MySQL_QUERY("SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='20' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Chain Reaction\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Chain Reaction is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/chainreactionGS1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
if($_POST['gname'] == "yeti9v32JS")
  {
 $game = 21;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='21' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Yeti Final Spit\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Yeti Final Spit is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/y10.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
if($_POST['gname'] == "DestroyAllHumansSte")
  {
 $game = 22;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='22' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Destroy All Humans\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Destroy All Humans is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/DestroyAllHumansSte1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
if($_POST['gname'] == "sonicblox")
  {
 $game = 23;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='23' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Sonic Blox\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Sonic Blox is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/sonicblox1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
if($_POST['gname'] == "trappedinawell")
  {
 $game = 24;
 $level = 1;
 $score = $_POST['gscore'];
 $ardresult = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game ='24' ORDER BY score DESC LIMIT 1");
$arcad = mysqli_fetch_array($ardresult);
$loser=$arcad["user"];
if ($score > $arcad["score"])
{
if ($btit_settings["arc_aw"] == true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+'".$upbon."' WHERE `id`=".$user."", true);
}
else
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$user."", true);
}
send_pm(0,$user,sqlesc('You Beat The Highscore!'), sqlesc("You did beat the highscore for Trapped In A Well\n\n Congratulations , you did recieve a ".$arte." bonus !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
if ($user!=$loser)
{
send_pm(0,$loser,sqlesc('Your Highscore Is Broken!'), sqlesc("Your highscore for Trapped In A Well is broken\n\n Time to visit the arcade and get it back ;)\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='0' WHERE `id`=".$loser."", true);
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `trophy`='1' WHERE `id`=".$user."", true);

    $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $rw=mysqli_fetch_assoc($al);
    $ct =  ($rw["count"]+1);
         do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=red]NEW HIGHSCORE FOR[/color]: [img]$BASEURL/flash/trappedinawell1.gif[/img] Score: ".$score." By ".$arcadeuser." Award: ".$arte."',".$ct.")");
}
}
mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO `{$TABLE_PREFIX}flashscores` ( `ID` , `game` , `user` , `level` , `score` ,`date` ) VALUES ( '', '".$game."', '".$user."', '".$level."', '".$score."',NOW());") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
redirect("index.php?page=arcadex");
}
}
}
///////////////////////END ARCADE//////////////////////

$tpl=new bTemplate();
$tpl->set("main_title",$btit_settings["name"]." .::. "."Index");

// is language right to left?
if (!empty($language["rtl"]))
   $tpl->set("main_rtl"," dir=\"".$language["rtl"]."\"");
else
   $tpl->set("main_rtl","");
if (!empty($language["charset"]))
  {
   $GLOBALS["charset"]=$language["charset"];
   $btit_settings["default_charset"]=$language["charset"];
}
$tpl->set("main_charset",$GLOBALS["charset"]);
$tpl->set("main_css","$style_css");


require_once("$THIS_BASEPATH/include/blocks.php");

// no collapse for guests
if ($CURUSER["id"]==1 OR $btit_settings["colup"]==false)
$tpl->set("guestt",false,TRUE);
else
$tpl->set("guestt",TRUE,false);

if ($CURUSER["id"]==1 OR $btit_settings["coldown"]==false)
$tpl->set("guesttt",false,TRUE);
else
$tpl->set("guesttt",TRUE,false);

$logo.="<div></div>";
$dropdown=dropdown_menu();
$extra=extra_menu();
/* for the header collapse */
$slideIt="<span style=\"float:left; padding-left:20px; margin: 0px;\"><a href=\"#\" rel=\"toggle[header]\" data-closedimage=\"$STYLEURL/images/open.png\" data-openimage=\"$STYLEURL/images/close.png\"><img src=\"$STYLEURL/images/close.png\" border=\"0\" alt=\"click\" /></a></span>";

$header.="<div>".main_menu()."</div>"; 
/* for the footer block collapse */
$slideIt2="<span style=\"float:left; padding-left:20px; margin: 0px;\"><a href=\"#\" rel=\"toggle[bottom_menu]\" data-closedimage=\"$STYLEURL/images/open.png\" data-openimage=\"$STYLEURL/images/close.png\"><img src=\"$STYLEURL/images/close.png\" border=\"0\" alt=\"click\" /></a></span>";
/*---*/

$left_col=side_menu();
$right_col=right_menu();

if (($left_col=="" && $right_col=="") || $btit_settings["site_offline"])
   $no_columns=1;

include 'include/jscss.php';

// dt blocks hide
if ($CURUSER["left_l"]=="nol" OR $CURUSER["left_l"]=="no")
$tpl->set("HAS_LEFT",false,TRUE);

if ($CURUSER["left_l"]=="nor" OR $CURUSER["left_l"]=="no")
$tpl->set("HAS_RIGHT",false,TRUE);
// dt blocks hide end

//season
if($CURUSER["fstyle"]=="yes")
{
if ($btit_settings["halloween"]==true)
$tpl->set("season",'<SCRIPT SRC="jscript/hall.js" language="JavaScript1.2"></SCRIPT>');
if ($btit_settings["snow"]==true)
$tpl->set("season",'<SCRIPT SRC="jscript/snow.js" language="JavaScript1.2"></SCRIPT>');
if ($btit_settings["leafs"]==true)
$tpl->set("season",'<SCRIPT SRC="jscript/leaf.js" language="JavaScript1.2"></SCRIPT>');
if ($btit_settings["flowers"]==true)
$tpl->set("season",'<SCRIPT SRC="jscript/flow.js" language="JavaScript1.2"></SCRIPT>');
if ($btit_settings["xmas"]==true)
$tpl->set("season",'<SCRIPT SRC="jscript/ball.js" language="JavaScript1.2"></SCRIPT>');
if ($btit_settings["valen"]==true)
$tpl->set("season",'<SCRIPT SRC="jscript/vall.js" language="JavaScript1.2"></SCRIPT>');
}
//season

// dt adver hide
if($CURUSER["show_ad"]=="yes")
{
if ($btit_settings["adver_top_on"]==false)
$tpl->set("HAS_AT",false,TRUE);
else
$tpl->set("advertop",$btit_settings["adver_top"]);

if ($btit_settings["adver_bot_on"]==false)
$tpl->set("HAS_AB",false,TRUE);
else
$tpl->set("adverbottom",$btit_settings["adver_bot"]);
}
// dt adver hide end

//matrix
if ($btit_settings["matrix"]==false)
{
$tpl->set("HAS_MT",false,TRUE);
$tpl->set("HAS_MTT",false,TRUE);
}
//matrix

//Disclaimer
if ($btit_settings["disclaim"]==false)
$tpl->set("HAS_DIS",false,TRUE);
//Disclaimer

$tpl->set("main_jscript",$morescript);
if (!$no_columns && $pageID!='admin' && $pageID!='forum' && $pageID!='torrents' && $pageID!='viewexpected' && $pageID!='usercp' && $pageID!='users') {
  $tpl->set("main_left",$left_col);
  $tpl->set("main_right",$right_col);
}

//Google analitic
if ($btit_settings["googlesw"]==false)
$tpl->set("HAS_GA",false,TRUE); 
else
$tpl->set("main_google",$btit_settings["google"]);
//Google analitic

$tpl->set("main_logo",$logo);
$tpl->set("main_dropdown",$dropdown);
$tpl->set("main_extra",$extra);
$tpl->set("main_slideIt",$slideIt); /* for the header collapse */
$tpl->set("main_slideIt2",$slideIt2); /* for the footer collapse */
$tpl->set("main_header",$header.$err_msg_install);
$tpl->set("more_css",$morecss);

//start private shout
if($CURUSER["uid"]>1){
$doit=get_result("SELECT `pchat` FROM `{$TABLE_PREFIX}users` where `id`=".$CURUSER["uid"],true);
$getit=$doit[0]["pchat"];
if($getit<=0){
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET `pchat`='".rand(1000,100000)."' where id=".$CURUSER["uid"]."",true);
}
}
//end private shout

if($btit_settings["anonymous"]==true)  
{
$tpl->set("anon",true,false);
$tpl->set("protected",$BASEURL);
}


if ($btit_settings["site_offline"] && $CURUSER["id"]>1 && $CURUSER["admin_access"]!="yes")
  stderr($language["SORRY"],$btit_settings["offline_msg"]);
elseif ($btit_settings["site_offline"] && $CURUSER["id"]==1)
  $pageID="login";

// assign main content
switch ($pageID) {

        case 'modules':
        $module_name=htmlspecialchars($_GET["module"]);
        $modules=get_result("SELECT * FROM {$TABLE_PREFIX}modules WHERE name=".sqlesc($module_name)." LIMIT 1",true,$btit_settings["cache_duration"]);
        if (count($modules)<1) // MODULE NOT SET
           stderr($language["ERROR"],$language["MODULE_NOT_PRESENT"]);

        if ($modules[0]["activated"]=="no") // MODULE SET BUT NOT ACTIVED
           stderr($language["ERROR"],$language["MODULE_UNACTIVE"]);

        $module_out="";
        if (!file_exists("$THIS_BASEPATH/modules/$module_name/index.php")) // MODULE SET, ACTIVED, BUT WRONG FOLDER??
           stderr($language["ERROR"],$language["MODULE_LOAD_ERROR"]."<br />\n$THIS_BASEPATH/modules/$module_name/index.php");

        // ALL OK, LET GO :)
        require("$THIS_BASEPATH/modules/$module_name/index.php");
        $tpl->set("main_content",set_block(ucfirst($module_name),"center",$module_out));
        $tpl->set("main_title","Index->Modules->".ucfirst($module_name));
        break;

        case 'admin':
        require("$THIS_BASEPATH/admin/admin.index.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Admin");
        // the main_content for current template is setting within admin/index.php
        break;
        
        case 'usernamechange':
        require("$THIS_BASEPATH/unlog.php");
        $tpl->set("main_content",set_block($language["UNLOG"],"center",$unlogtpl->fetch(load_template("unlog.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->UsernameChange");
        break;
        
        case 'warn':
        require("$THIS_BASEPATH/warn.php");
        break;

        case 'rewarn':
        require("$THIS_BASEPATH/rewarn.php");
        break; 
                
        case 'forum':
        require("$THIS_BASEPATH/forum/forum.index.php");
        $tpl->set("main_title","Index->Forum");
        break;

//DT Comment Vote start
        case 'votes':
        require("$THIS_BASEPATH/votes.php");
        break;
// Comment Vote end

        case 'donate':
        require("$THIS_BASEPATH/pp.php");
        $tpl->set("main_content",set_block($language["DONATE"],"center",$pptpl->fetch(load_template("pp.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Donate");
        break;
        
        case 'success':
        redirect("paypalsynch.php?tx=$_GET[tx]&st=$_GET[st]&amt=$_GET[amt]&cc=$_GET[cc]&cm=$_GET[cm]&item_number=$_GET[item_number]");
        break;

        case 'complete':
        require("$THIS_BASEPATH/paypalsynchcp.php");
        $tpl->set("main_content",set_block("Thanks for keeping us alive!","center",$synchtpl->fetch(load_template("ppsynch.tpl"))));
        $tpl->set("main_title","Index->Success");
        break;
        
        case 'facebooklogin':
        require("$THIS_BASEPATH/facebook_login.php");
        break; 
        
        case 'don_hist':
        require("$THIS_BASEPATH/don_hist.php");
        break;

        case 'don_historie':
        require("$THIS_BASEPATH/don_historie.php");
        $tpl->set("main_content",set_block($language["DON_HISTORIE"],"center",$don_historietpl->fetch(load_template("don_historie.tpl"))));
        $tpl->set("main_title","Index->Torrents");
        break;
        
//booted
        case 'booted':
        require("$THIS_BASEPATH/booted.php");
        break;

        case 'rebooted':
        require("$THIS_BASEPATH/rebooted.php");
        break;
//end booted  
        
        case 'notepad':
        require("$THIS_BASEPATH/notepad.php");
        $tpl->set("main_content",set_block($CURUSER["username"].$language["NOTEPAD"].$language["NOTEPAD1"].$arrnotes.$language["NOTEPAD3"].$language["NOTEPAD2"],"center",$notepadtpl->fetch(load_template("notepad.tpl"))));
        $tpl->set("main_title","Index->Notepad");
        break;
				
// agree
        case 'agree':
        require("$THIS_BASEPATH/agree.php");
        $tpl->set("main_content",set_block($language["AGREE"],"center",$agreetpl->fetch(load_template("agree.tpl"))));
        $tpl->set("main_title","Index->Torrents");
        break;
// agree end

// contact
        case 'contact':
        require("$THIS_BASEPATH/contact.php");
        $tpl->set("main_content",set_block($language["MNU_support"],"center",$contacttpl->fetch(load_template("contact.tpl"))));
        $tpl->set("main_title","Index->Contact");
        break;
// contact end
    
	    case 'torrents':
        require("$THIS_BASEPATH/torrents.php");
        $tpl->set("main_content",set_block($language["MNU_TORRENT"],"center",$torrenttpl->fetch(load_template("torrent.list.tpl"))));
        $tpl->set("main_title","Index->Torrents");
        break;
                
// shouthistory
    case 'allshout':
        ob_start();
        require("$THIS_BASEPATH/ajaxchat/getHistoryChatData.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Shout History");
        $out=ob_get_contents();
        ob_end_clean();
        $tpl->set("main_content",set_block($language["SHOUTBOX"]." ".$language["HISTORY"],"left",$out));
        break;
		
		case 'bonustransfer':
        require("$THIS_BASEPATH/bonus_transfer.php");
        $tpl->set("main_content",set_block($language["DONATEBONUS"],"center",$bonustpl->fetch(load_template("bonus.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->BonusTransfer");
        break;
        
		case 'bonusdone':
        require("$THIS_BASEPATH/bonus_transfered.php");
        $tpl->set("main_content",set_block($language["DONATEBONUS"],"center",$bonustaketpl->fetch(load_template("bonustake.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Bonus Process");
        break;  

        case 'comment':
        require("$THIS_BASEPATH/comment.php");
        $tpl->set("main_content",set_block($language["COMMENTS"],"center",$tpl_comment->fetch(load_template("comment.tpl")),false));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Comment");
        break;

//uploadrequest
        case 'uploadrequest':
        require("$THIS_BASEPATH/uploadrequest.php");
        $tpl->set("main_content",set_block($language["ULR"],"center",$uploadrequesttpl->fetch(load_template("uploadrequest.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["ULR"]."");
        break;

        case 'uploadrequest2':
        require("$THIS_BASEPATH/uploadrequest2.php");
        break;
//end uploadrequest

//dox start
        case 'dox':
        require("$THIS_BASEPATH/dox.php");
        $tpl->set("main_content",set_block($language["DOX"],"center",$doxtpl->fetch(load_template("dox.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["DOX"]."");
        break;
        
        case 'getdox':
        require("$THIS_BASEPATH/getdox.php");
        break;
//dox end

// private history
        case 'allPshout':
        ob_start();
        require("$THIS_BASEPATH/ajaxchat/getHistoryPChatData.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Shout History");
        $out=ob_get_contents();
        ob_end_clean();
        $tpl->set("main_content",set_block($language["SHOUTBOX"]." ".$language["HISTORY"],"left",$out));
        break;
// private shout
        case 'Pshout':
        ob_start();
        require("$THIS_BASEPATH/shoutp.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language['SHOUTBOXP']."");
        $out=ob_get_contents();
        ob_end_clean();
        $tpl->set("main_content",set_block($language['SHOUTBOXP'],"left",$out));
        break;

//shitlist
        case 'shitlist':
        require("$THIS_BASEPATH/shitlist.php");
        $tpl->set("main_content",set_block($language["SHITLIST"],"center",$shittpl->fetch(load_template("shitlist.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["SHITLIST"]."");
        break;
//end shitlist   

//user image store
        case 'ui_exchange':
        require("$THIS_BASEPATH/ui_exchange.php");
        break;
//user image store

//Watched topic internal forum
        case 'chk':
        require("$THIS_BASEPATH/chk.php");
        break;
//Watched topic internal forum

        case 'comment-edit':
        require("$THIS_BASEPATH/commedit.php");
        $tpl->set("main_content",set_block($language["COMMENTS"],"center",$tpl_comment->fetch(load_template("comment.edit.tpl")),false));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Comment Edit");
        break;

        case 'delete':
        require("$THIS_BASEPATH/delete.php");
        $tpl->set("main_content",set_block($language["DELETE_TORRENT"],"center",$torrenttpl->fetch(load_template("torrent.delete.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Delete");
        break;

//grabbed
        case 'grabbed':
        require("$THIS_BASEPATH/grabbed.php");
        $tpl->set("main_content",set_block($language["GRABBED"],"center",$grabbedtpl->fetch(load_template("grabbed.tpl"))));
        $tpl->set("main_title","Index->grabbed torrents");
        break;
//end grabbed
        
        case 'flush':
        require("$THIS_BASEPATH/flush.php");
        break;

        case 'edit':
        require("$THIS_BASEPATH/edit.php");
        $tpl->set("main_content",set_block($language["EDIT_TORRENT"],"center",$torrenttpl->fetch(load_template("torrent.edit.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Edit");
        break;
        
        case 'video_page':
        require("$THIS_BASEPATH/video_page.php");
        $tpl->set("main_content",set_block($language["VIDEOPAGE"],"center",$video_pagetpl->fetch(load_template("video_page.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->video_page");
        break;

        case 'extra-stats':
        require("$THIS_BASEPATH/extra-stats.php");
        $tpl->set("main_content",set_block($language["MNU_STATS"],"center",$out));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Statistics");
        break;
//nieuw start 
       
        case 'votesexpectedviewmin':
        require("$THIS_BASEPATH/votesexpectedviewmin.php");
        $tpl->set("main_content",set_block($language["EXPECTED_VV"],"center",$votesexpectedviewtpl->fetch(load_template("votesexpectedviewmin.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Expected");
        break;
        
        case 'addexpectedmin':
        require("$THIS_BASEPATH/addexpectedmin.php");
        break;
        
// nieuw end 

// gift
        case 'gift':
        require("$THIS_BASEPATH/gift.php");
        break;
// gift

        case 'slots':
        require("$THIS_BASEPATH/slotsgo.php");
        $tpl->set("main_content",set_block("Slots","center",$slotstpl->fetch(load_template("slots.tpl"))));
        $tpl->set("main_title"," .::. "."Index->xbtit->Slots");
        break;
        
		case 'slotsgo':
        require("$THIS_BASEPATH/slots.php");
        $tpl->set("main_content",set_block("Slots","center",$slotstpl->fetch(load_template("slots.tpl"))));
        $tpl->set("main_title"," .::. "."Index->xbtit->Slots");
        break;
        
// offer start

        case 'viewexpected':
        require("$THIS_BASEPATH/viewexpected.php");
        $tpl->set("main_content",set_block($language["viewexpected"],"center",$viewexpectedtpl->fetch(load_template("viewexpected.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Expected");
        break;
        
        case 'expected':
        require("$THIS_BASEPATH/expected.php");
        $tpl->set("main_content",set_block($language["EXPECTED_V"],"center",$expectedtpl->fetch(load_template("expected.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Expected");
        break;
        
        case 'expectdetails':
        require("$THIS_BASEPATH/expectdetails.php");
        $tpl->set("main_content",set_block($language["EXPECTED_D"],"center",$expectdetailstpl->fetch(load_template("expectdetails.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Expected");
        break;
        
        case 'expectedit':
        require("$THIS_BASEPATH/expectedit.php");
        $tpl->set("main_content",set_block($language["EXPECTED_E"],"center",$expectedittpl->fetch(load_template("expectedit.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Expected");
        break;
        
        case 'votesexpectedview':
        require("$THIS_BASEPATH/votesexpectedview.php");
        $tpl->set("main_content",set_block($language["EXPECTED_VV"],"center",$votesexpectedviewtpl->fetch(load_template("votesexpectedview.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Expected");
        break;
        
        case 'takeexpect':
        require("$THIS_BASEPATH/takeexpect.php");
        break;
        
        case 'addexpected':
        require("$THIS_BASEPATH/addexpected.php");
        break;
        
        case 'takeexpectedit':
        require("$THIS_BASEPATH/takeexpectedit.php");
        break;

        case 'takedelexpect':
        require("$THIS_BASEPATH/takedelexpect.php");
        break;
        
        case 'offer_comment':
        require("$THIS_BASEPATH/offer_comment.php");
        $tpl->set("main_content",set_block($language["COMMENTS"],"center",$tpl_offer_comment->fetch(load_template("offer_comment.tpl")),false));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Expected->Comment");
        break;

// offer end

        case 'massmoderate':
        require("$THIS_BASEPATH/massmoderate.php");
        break;

//apply
        case 'apply':
        require("$THIS_BASEPATH/apply.php");
        $tpl->set("main_content",set_block("Apply for membership","center",$applytpl->fetch(load_template("apply.tpl"))));
        $tpl->set("main_title","Index->Apply for membership");
        break;
        
        case 'applysend':
        require("$THIS_BASEPATH/applysend.php");
        break;
//apply
        
// DT reputaton systen start
        case 'reputationpage':
        require("$THIS_BASEPATH/reputationpage.php");
        $tpl->set("main_content",set_block($language["REPUTATION"],"center",$reputationpagetpl->fetch(load_template("reputationpage.tpl"))));
        $tpl->set("main_title","Index->Reputation");
        break;

        case 'plusmin':
        require("$THIS_BASEPATH/plusmin.php");
        break;
// DT reputaton systen end
            
	
	    case 'todaytorrents':
        require("$THIS_BASEPATH/todaytorrents.php");
        $tpl->set("main_content",set_block($language["MNU_TORRENT"],"center",$todaytorrentstpl->fetch(load_template("todaytorrents.tpl"))));
        $tpl->set("main_title","Index->Torrents");
        break;
        
        case 'yesterdaytorrents':
        require("$THIS_BASEPATH/yesterdaytorrents.php");
        $tpl->set("main_content",set_block($language["MNU_TORRENT"],"center",$yesterdaytorrentstpl->fetch(load_template("yesterdaytorrents.tpl"))));
        $tpl->set("main_title","Index->Torrents");
        break; 
        
        case 'timedrank':
        require("$THIS_BASEPATH/timedrank.php");
        break;
        
        case 'subtitles':
        require("$THIS_BASEPATH/subtitles.php");
        $tpl->set("main_content",set_block($language['SUB_T_H'],"center",$substpl->fetch(load_template("subs.tpl"))));
        $tpl->set("main_title","Index->Subtitles");
        break; 
        
        case 'subsearch':
        require("$THIS_BASEPATH/subtitles_search.php");
        $tpl->set("main_content",set_block($language['SUB_T_S'],"center",$subsearchtpl->fetch(load_template("subsearch.tpl"))));
        $tpl->set("main_title","Index->Subtitles Search");
        break; 
        
        case 'subadd':
        require("$THIS_BASEPATH/subtitle_add.php");
        $tpl->set("main_content",set_block($language['SUB_ADD_H'],"center",$subsaddtpl->fetch(load_template("subadd.tpl"))));
        $tpl->set("main_title","Index->Add Subtitle");
        break;
        
        case 'subedit':
        require("$THIS_BASEPATH/subs_edit.php");
        $tpl->set("main_content",set_block($language['SUB_T_E'],"center",$subsedittpl->fetch(load_template("subsedit.tpl"))));
        $tpl->set("main_title","Index->Edit Subtitle");
        break;              

        case 'limit':
        require("$THIS_BASEPATH/limit.php");
        $tpl->set("main_content",set_block($language["MNU_STATS"],"center",$limittpl->fetch(load_template("limit.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Statistics");
        break;
        
        case 'coins':
        require("$THIS_BASEPATH/coins.php");
        $tpl->set("main_title","Index->Send Points");
        break;  

        
// DT request hack start

        case 'addrequest':
        require("$THIS_BASEPATH/addrequest.php");
        break;

        case 'reqedit':
        require("$THIS_BASEPATH/reqedit.php");
        $tpl->set("main_content",set_block($language["RE"],"center",$reqedittpl->fetch(load_template("reqedit.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->reqedit");
        break;

        case 'reqreset':
        require("$THIS_BASEPATH/reqreset.php");
        break;

        case 'takedelreq':
        require("$THIS_BASEPATH/takedelreq.php");
        break;

        case 'takerequest':
        require("$THIS_BASEPATH/takerequest.php");
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->takerequest");
        break;

        case 'votesview':
        require("$THIS_BASEPATH/votesview.php");
        $tpl->set("main_content",set_block($language["VV"],"center",$votesviewtpl->fetch(load_template("votesview.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->votesview");
        break;

        case 'reqdetails':
        require("$THIS_BASEPATH/reqdetails.php");
        $tpl->set("main_content",set_block($language["RD"],"center",$reqdetailstpl->fetch(load_template("reqdetails.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->reqdetails");
        break;

        case 'reqfilled':
        require("$THIS_BASEPATH/reqfilled.php");
        $tpl->set("main_content",set_block($language["RF"],"center",$reqfilledtpl->fetch(load_template("reqfilled.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->reqfilled");
        break;

        case 'requests':
        require("$THIS_BASEPATH/requests.php");
        $tpl->set("main_content",set_block($language["R"],"center",$requeststpl->fetch(load_template("requests.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->requests");
        break;

        case 'takereqedit':
        require("$THIS_BASEPATH/takereqedit.php");
        break;

        case 'viewrequests':
        require("$THIS_BASEPATH/viewrequests.php");
        $tpl->set("main_content",set_block($language["VR"],"center",$viewrequeststpl->fetch(load_template("viewrequests.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->viewrequests");
        break;

// DT request hack end
        

        case 'history':
        case 'torrent_history':
        require("$THIS_BASEPATH/torrent_history.php");
        $tpl->set("main_content",set_block($language["MNU_TORRENT"],"center",$historytpl->fetch(load_template("torrent_history.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->History");
        break;

        case 'login':
        require("$THIS_BASEPATH/login.php");
        $tpl->set("main_content",set_block($language["LOGIN"],"center",$logintpl->fetch(load_template("login.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Login");
        break;

        case 'moresmiles':
        require("$THIS_BASEPATH/moresmiles.php");
        $tpl->set("main_content",set_block($language["MORE_SMILES"],"center",$moresmiles_tpl->fetch(load_template("moresmiles.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." "."More Smilies");
        break;

        case 'news':
        require("$THIS_BASEPATH/news.php");
        $tpl->set("main_content",set_block($language["MANAGE_NEWS"],"center",$newstpl->fetch(load_template("news.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->News");
        break;

        case 'blackjack':
        require("$THIS_BASEPATH/blackjack.php");
        require(load_language("lang_blackjack.php"));
        $tpl->set("main_content",set_block($language["BLACKJACK"],"center",$blackjacktpl->fetch(load_template("blackjack.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["BLACKJACK"]);
        break;

        case 'peers':
        require("$THIS_BASEPATH/peers.php");
        $tpl->set("main_content",set_block($language["MNU_TORRENT"],"center",$peerstpl->fetch(load_template("peers.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Peers");
        break;

        case 'recover':
        require("$THIS_BASEPATH/recover.php");
        $tpl->set("main_content",set_block($language["RECOVER_PWD"],"center",$recovertpl->fetch(load_template("recover.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Recover");
        break;

        case 'account':
        case 'signup':
        case 'invite':
        require("$THIS_BASEPATH/account.php");
        $tpl->set("more_css","<link rel=\"stylesheet\" type=\"text/css\" href=\"$BASEURL/jscript/passwdcheck.css\" />");
        $tpl->set("main_content",set_block($language["ACCOUNT_CREATE"],"center",$tpl_account->fetch(load_template("account.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Signup");
        break;

        case 'torrent-details':
        case 'details':
        require("$THIS_BASEPATH/details.php");
        $tpl->set("main_content",set_block($language["TORRENT_DETAIL"],"center",$torrenttpl->fetch(load_template("torrent.details.tpl")),($GLOBALS["usepopup"]?false:true)));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Details");
        break;

        case 'users':
        require("$THIS_BASEPATH/users.php");
        $tpl->set("main_content",set_block($language["MEMBERS_LIST"],"center",$userstpl->fetch(load_template("users.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Users");
        break; 
	  
// user images       
        case 'user_img':
        require("$THIS_BASEPATH/user_img.php");
        $tpl->set("main_content",set_block($language["UIMG"],"center",$user_imgtpl->fetch(load_template("user_img.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->User->Images");
        break;
// user images 
  
//sb control
        case 'sb':
        require("$THIS_BASEPATH/sb.php");
        $tpl->set("main_content",set_block($language["SB"],"center",$sbtpl->fetch(load_template("sb.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Seed Bonus Control");
        break;
//sb control

        case 'usercp':
        require("$THIS_BASEPATH/user/usercp.index.php");
        // the main_content for current template is setting within users/index.php
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->My Panel");
        break;

        case 'upload':
        require("$THIS_BASEPATH/upload.php");
        $tpl->set("main_content",set_block($language["MNU_UPLOAD"],"center",$uploadtpl->fetch(load_template("$tplfile.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Upload");
        break;

        case 'userdetails':
        require("$THIS_BASEPATH/userdetails.php");
        $tpl->set("main_content",set_block($language["USER_DETAILS"],"center",$userdetailtpl->fetch(load_template("userdetails.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Users->Details");
        break;

// Arcade hack
        case 'arcadex':
        require("$THIS_BASEPATH/arcadex.php");
        $tpl->set("main_content",set_block($language["ARCADE"],"center",$arcadetpl->fetch(load_template("arcadex.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->arcade");
        break;

        case 'flash':
        require("$THIS_BASEPATH/flash.php");
        $tpl->set("main_content",set_block($language["FLASH"],"center",$flashtpl->fetch(load_template("flash.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->arcade");
        break;
// end Arcade hack

//ip log
        case 'iplog':
        require("$THIS_BASEPATH/iplog.php");
        $tpl->set("main_content",set_block($language["IPLOG"],"center",$iplogtpl->fetch(load_template("iplog.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["IPLOG"]."");
        break;
//end ip log

        case 'announcement':
        require("$THIS_BASEPATH/announcement.php");
        $tpl->set("main_content",set_block($language["ANN"],"center",$annountpl->fetch(load_template("announcement.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["ANN"]."");
        break;
        
//ban button
        case 'banbutton':
        require("$THIS_BASEPATH/banbutton.php");
        $tpl->set("main_content",set_block($language["DTBAN"],"center",$banbuttontpl->fetch(load_template("banbutton.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["DTBAN"]."");
        break;
//end ban button

// AFG hack

        case 'freereq':
        require("$THIS_BASEPATH/freereq.php");
        $tpl->set("main_content",set_block($language["FREEREQ"],"center",$torrenttpl->fetch(load_template("freereq.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->freereq");
        break;
       
// reseed hack
        case 'reseed':
        require("$THIS_BASEPATH/reseed.php");
        $tpl->set("main_content",set_block($language["RESEED"],"center",$torrenttpl->fetch(load_template("reseed.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->reseed");
        break;
// end reseed hack

//start report hack DT
        case 'report':
        require("$THIS_BASEPATH/report.php");
        $tpl->set("main_content",set_block($language["REP"],"center",$reporttpl->fetch(load_template("report.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["REP"]."");
        break;

        case 'reports':
        require("$THIS_BASEPATH/reports.php");
        $tpl->set("main_content",set_block($language["REPS"],"center",$reportstpl->fetch(load_template("reports.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["REPS"]."");
        break;

        case 'takedelreport':
        require("$THIS_BASEPATH/takedelreport.php");
        break;
//end report hack
        
//Bookmark
        case 'bookmark':
        require("$THIS_BASEPATH/bookmark.php");
        $tpl->set("main_content",set_block($language["BOOKMARK"],"center",$bookmarktpl->fetch(load_template("bookmark.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["BOOKMARK"]."");
        break;
//end Bookmark

// Social Network DT
        case 'friendlist':
        require("$THIS_BASEPATH/friendlist.php");
        $tpl->set("main_content",set_block($language["FRIENDLIST"],"center",$friendtpl->fetch(load_template("friendlist.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["FRIENDLIST"]."");
        break;
        
        case 'friends':
        require("$THIS_BASEPATH/friends.php");
        $tpl->set("main_content",set_block($language["FRIENDS"],"center",$friendstpl->fetch(load_template("friends.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Friends");
        break;
//End Social Network DT
	  
        case 'viewnews':
        require("$THIS_BASEPATH/viewnews.php");
        $tpl->set("main_content",set_block($language["LAST_NEWS"],"center",$viewnewstpl->fetch(load_template("viewnews.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->News");
        break;    case 'mod_comment':
        require("$THIS_BASEPATH/mod_comment.php");
        break;

        case 'sup_comment':
        require("$THIS_BASEPATH/sup_comment.php");
        break;
        
    	case 'private':
        require("$THIS_BASEPATH/private.php");
        $tpl->set("main_content",set_block($language["PRIVATE"],"center",$privatetpl->fetch(load_template("private.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Private");
        break;    
		
	    case 'lottery_tickets':
        require("$THIS_BASEPATH/lottery.tickets.php");
        $tpl->set("main_content",set_block($language["LOTTERY"],"center",$ticketstpl->fetch(load_template("lottery.tickets.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["LOTTERY"]."");
        break;

        case 'lottery_winners':
        require("$THIS_BASEPATH/lottery.winners.php");
        $tpl->set("main_content",set_block($language["LOTTERY"],"center",$ticketstpl->fetch(load_template("lottery.winners.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["LOTTERY"]."");
        break;

        case 'lottery_purchase':
        require("$THIS_BASEPATH/lottery.purchase.php");
        $tpl->set("main_content",set_block($language["LOTTERY"],"center",$ticketstpl->fetch(load_template("lottery.purchase.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->".$language["LOTTERY"]."");
        break;    
		
	    case 'staff':
        require("$THIS_BASEPATH/staff.php");
        $tpl->set("main_content",set_block($SITENAME . " " . $language["STAFF"],"center",$stafftpl->fetch(load_template("staff.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Staff");
        break;

/*Mod by losmi - rules mod*/
        case 'rules':
        require("$THIS_BASEPATH/rules.php");
        $tpl->set("main_content",set_block($language["RULES"],"center",$rulestpl->fetch(load_template("rules.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Rules");
        break;
/*End mod by losmi rules - mod*/
    
/*Mod by losmi - faq mod*/
        case 'faq':
        require("$THIS_BASEPATH/faq.php");
        $tpl->set("main_content",set_block($language["MNU_FAQ"],"center",$faqtpl->fetch(load_template("faq.tpl"))));
        $tpl->set("main_title",$btit_settings["name"]." .::. "."Index->F.A.Q.");
        break;
/*End mod by losmi faq - mod*/    

        case 'moder':
		require("$THIS_BASEPATH/moder.php");
		$tpl->set("main_content",set_block($language["MODERATE_TORRENT"],"center",$torrenttpl->fetch(load_template("admin.moder.tpl"))));
		$tpl->set("main_title",$btit_settings["name"]." .::. "."Index->Torrent->Moderate");
		break;
		
		case 'index':
        case '':
        default:
        $tpl->set("main_content",center_menu());
        break;
}

// controll if client can handle gzip
if ($GZIP_ENABLED)
    {
     if (stristr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip") && extension_loaded('zlib') && ini_get("zlib.output_compression") == 0)
         {
         if (ini_get('output_handler')!='ob_gzhandler')
             {
             ob_start("ob_gzhandler");
             $gzip='enabled';
             }
         else
             {
             ob_start();
             $gzip='enabled';
             }
     }
     else
         {
         ob_start();
         $gzip='disabled';
         }
}
else
    $gzip='disabled';

// fetch page with right template
switch ($pageID) {

    // for admin page we will display page with header and only left column (for menu)
    case 'admin':
    case 'usercp':
        stdfoot(false,false,true);
        break;
            
        // for torrents and forums pages we will display page with header and no columns (for full view)
        case 'torrents':
        case 'users':
        case 'forum':
        case 'viewexpected':
        //full screen chat
        case 'modules':
        //end full screen chat
        stdfoot(false,true,false,true,true);
        break;      

    // if popup enabled then we display the page without header and no columns, else full page
    case 'comment':
    case 'torrent-details':
    case 'torrent_history':
    case 'peers':
        stdfoot(($GLOBALS["usepopup"]?false:true));
        break;

    // we display the page without header and no columns
    case 'allshout':
    //start private shout
    case 'allPshout':
    case 'Pshout':
    //end private shout
    case 'moresmiles':
        stdfoot(false);
        break;

    // full page
    default:
        stdfoot();
        break;
}

?>