<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//   SPORT BETTING HACK , orginal TBDEV 2009 by Soft & Bigjoos 
//   XBTIT conversion by DiemThuy , April 2010
//
//    This file is part of xbtit DT fM.
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

$subject ="";

if ($CURUSER["admin_access"]=="no")
stderr("access denied !!");

//==Autopost By Retro
function auto_bet($subject = "Error - Subject Missing", $body = "Error - No Body")
{
    global $CURUSER, $BASEURL,$TABLE_PREFIX,$btit_settings;
    
    $forumid = $btit_settings["fid_bet"];
    $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}topics WHERE forumid=$forumid AND subject=$subject");

    if (mysqli_num_rows($res) == 1) {
        $arr = mysqli_fetch_array($res);
        $topicid = $arr['id'];
    } else {
        $subject = sqlesc("Betting results");
        mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}topics (userid, forumid, subject) VALUES(2, $forumid, $subject)") or sqlerr(__FILE__, __LINE__);
        $topicid = @((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
    }

    $added = "".time() . "";
    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}posts (topicid, userid, added, body) " . "VALUES($topicid,2, $added, $body)") or sqlerr(__FILE__, __LINE__);
    $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_row($res) or die("No post found");
    $postid = $arr[0];
    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}topics SET lastpost=$postid WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
}

$res1 = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}topics ORDER BY id DESC LIMIT 1"));
$res1 = (int) $res1['id']+1;
$forumlink = "[url]".$BASEURL."/index.php?page=forum&action=viewtopic&topicid=".$res1."[/url]";
//==End

$date = time();
$id = isset($_GET['id']) && is_valid_id($_GET['id']) ? $_GET['id'] : 0;
$a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betoptions WHERE id =".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
$b = mysqli_fetch_array($a);
$gameid = $b['gameid'];
if($gameid < 1){
header("location: $BASEURL/index.php?page=betfinish");
exit;
}
$res3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betgames WHERE id =".sqlesc($gameid)." AND fix = 0") or sqlerr(__FILE__, __LINE__);
$o = @mysqli_fetch_array($res3);
$c = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}bets WHERE optionid =".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
$totalstats = 0;

if(@mysqli_num_rows($res3) == 1)
{
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}betgames SET fix = 1 WHERE id =".sqlesc($gameid)."") or sqlerr(__FILE__, __LINE__);
}
else
{
//print stdhead('Betting');

$HTMLOUT .="<br><img src='images/betting.png' alt='Bet' title='Betting' width='400' height='125' />
<table class='main' width='200' cellspacing='0' cellpadding='5' border='0'><br>
<tr>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betadmin'>Add Bets</a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betgameinfo'>Bet info</a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betgamefinish'><font color='#999999'>End Bets</font></a></td>
</tr>
</table>
<br />";
}
while($d = mysqli_fetch_array($c))
{
$dividend = round(($d['bonus']*$b['odds'])*0.97,0);
if(mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}bettop WHERE userid =".sqlesc($d["userid"])."")) == 0){
mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}bettop(userid, bonus) VALUES(".sqlesc($d["userid"]).", ".sqlesc($dividend-$d["bonus"]).")") or sqlerr(__FILE__, __LINE__);
}
else{
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}bettop SET bonus = bonus + ".sqlesc($dividend -$d["bonus"])." WHERE userid =".sqlesc($d["userid"])."") or sqlerr(__FILE__, __LINE__);
}

$totalstats += $d['bonus'];
$dividend = round(($d['bonus']*$b['odds'])*0.97,0);
$subjectwin = "Bet win!";
$msg = "Bet profit +".$dividend." points";
$msg2 = <<<EOD
You have just accrued {$dividend} Bonus Points on Bet !
You played {$d['bonus']} points on [i]{$o['heading']}[/i] Option :[i]{$b['text']}[/i] which gave {$b['odds']} times the bet!

:yay:

To see the full results of the Bet follow the link :

{$forumlink}

EOD;

mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users set seedbonus = seedbonus + ".sqlesc($dividend)." WHERE id = ".sqlesc($d["userid"])."") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}betlog(userid,msg,date,bonus) VALUES(".sqlesc($d["userid"]).", ".sqlesc($msg).", '$date', ".sqlesc($dividend).")") or sqlerr(__FILE__, __LINE__);

send_pm (0,$d['userid'], sqlesc($subjectwin), sqlesc($msg2));

$totalstats += $dividend;
}

$s = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) from {$TABLE_PREFIX}bets where gameid =".sqlesc($gameid)."")) or sqlerr(__FILE__, __LINE__);
$body = "[b]".htmlspecialchars($o['heading'])."[/b] - [i]".htmlspecialchars($o['undertext'])."[/i]\n\n";
$body.= "Number of bets wagered on the game : [b] ".htmlspecialchars($s[0])." [/b]\n";
$body.= "Total Bonus points in the turnover of the game : [b] ".htmlspecialchars($totalstats)." points[/b]\n";
$body.= "Winning option : [b] ".htmlspecialchars($b['text'])." [/b]\n";
$body.= "The game was ended by : [b] ".htmlspecialchars($CURUSER['username'])." [/b]\n\n";
$body.= "[b]Options and odds :[/b]\n";

$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betgames WHERE id =".sqlesc($gameid)."") or sqlerr(__FILE__, __LINE__);
$a = mysqli_fetch_array($res);

if($a['sort']==0)
$sort = "odds ASC";
elseif($a['sort']==1)
$sort = "id ASC";
$res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from {$TABLE_PREFIX}betoptions where gameid =".sqlesc($a["id"])." ORDER BY $sort") or sqlerr(__FILE__, __LINE__);
while($b = mysqli_fetch_array($res2)){
$body.= " ".htmlspecialchars($b['text'])." X[b]".htmlspecialchars($b['odds'])."[/b]\n";
}

$m = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT users.username, users.id, bets.userid, bets.bonus FROM {$TABLE_PREFIX}bets bets INNER JOIN {$TABLE_PREFIX}users users on bets.userid = users.id WHERE optionid =".sqlesc($id)." and gameid =".sqlesc($gameid)." order by bonus DESC LIMIT 20") or sqlerr(__FILE__, __LINE__);
$body.= "\n[b]Top 20 Winners:[/b]\n";
$odds = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betoptions WHERE id =".sqlesc($id)."")) or sqlerr(__FILE__, __LINE__);
while($k = mysqli_fetch_array($m)){
$body .= "[b]+".round($k['bonus']*$odds['odds']*0.97,0)." Bonus points[/b] to [url=$BASEURL/index.php?page=userdetails&id=".$k['id']."]".htmlspecialchars($k['username'])."[/url] who invested ".htmlspecialchars($k['bonus'])." Points\n";
}

$m = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT users.username, users.id, bets.userid, bets.bonus FROM {$TABLE_PREFIX}bets bets INNER JOIN {$TABLE_PREFIX}users users on bets.userid = users.id WHERE optionid <> $id and gameid = $gameid order by bonus DESC LIMIT 20") or sqlerr(__FILE__, __LINE__);
$body.= "\n[b]Top 20 losers:[/b]\n";
while($k = mysqli_fetch_array($m)){
$body .= "[url=$BASEURL/index.php?page=userdetails&id=".$k['id']."]".htmlspecialchars($k['username'])."[/url] [b]-".htmlspecialchars($k['bonus'])." Points[/b]\n";
}

$body = sqlesc($body);

auto_bet(sqlesc($o['heading']), $body, $subject);

$c = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}bets WHERE optionid <> $id AND gameid =".sqlesc($gameid)."") or sqlerr(__FILE__, __LINE__);
while($a = mysqli_fetch_array($c))
{
if(mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}bettop WHERE userid =".sqlesc($a["userid"])."")) == 0){
mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}bettop(userid, bonus) VALUES(".sqlesc($a["userid"]).", -".sqlesc($a["bonus"]).")") or sqlerr(__FILE__, __LINE__);
}
else{
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}bettop SET bonus = bonus - ".sqlesc($a["bonus"])." WHERE userid =".sqlesc($a["userid"])."") or sqlerr(__FILE__, __LINE__);
}
$k = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from {$TABLE_PREFIX}betgames where id =".sqlesc($gameid)."")) or sqlerr(__FILE__, __LINE__);
$msg3 = <<<EOD
Unfortunately it turned out that your investment in [i]{$k['heading']}[/i] did not yield any dividends !
Good luck next time!

:no:

To see the full results of the Bet follow the link :

{$forumlink}
EOD;
$subjectloss = "Bet loss!";
send_pm (0,$a["userid"], sqlesc($subjectloss), sqlesc($msg3));
}

mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}betgames WHERE id =".sqlesc($gameid)."") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}betoptions WHERE gameid =".sqlesc($gameid)."") or sqlerr(__FILE__, __LINE__);
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}bets WHERE gameid =".sqlesc($gameid)."") or sqlerr(__FILE__, __LINE__);
header("location: $BASEURL/index.php?page=betfinish");

$betfintwotpl = new bTemplate();
$betfintwotpl->set("language", $language);
$betfintwotpl->set(betfintwo,$HTMLOUT);

?>