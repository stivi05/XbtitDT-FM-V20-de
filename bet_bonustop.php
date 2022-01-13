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

$order = isset($_GET['a']) && is_valid_id($_GET['a']) ? $_GET['a'] : 0;

if($order == 1)

$order = 'asc';
else
$order = 'desc';


$HTMLOUT .="<br><img src='images/betting.png' alt='Bet' title='Betting' width='400' height='125' />
<table class='main' width='50%' cellspacing='0' cellpadding='5' border='0'><br>
<tr>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=bet'>Games</a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betcoupon'>Wagers</a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betbonustop'><font color='#999999'>Top list</font></a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betinfo'>Bet Info</a></td>
</tr>
</table>
<br />";

$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}bettop WHERE userid = ".sqlesc($CURUSER['uid'])."") or sqlerr(__FILE__, __LINE__);

while($arr = mysqli_fetch_assoc($res))
{
$HTMLOUT .="<table border='1' cellspacing='0' cellpadding='5'>\n";
$HTMLOUT .="<tr><td class='colhead' align='left'>Username</td><td class='colhead' align='left'>Points +/-</td></tr>\n";
$HTMLOUT .="<tr><td><a href='$BASEURL/index.php?page=userdetails&id=$CURUSER[uid]'>".htmlspecialchars($CURUSER["username"])."</a></td><td align='right'><b>".htmlspecialchars($arr["bonus"])." Points</b></td></tr></table>\n";
}

  $number = 0;
  $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT users.username, bettop.userid, bettop.bonus FROM {$TABLE_PREFIX}bettop bettop INNER JOIN {$TABLE_PREFIX}users users ON bettop.userid = users.id order by bettop.bonus $order limit 50") or sqlerr(__FILE__, __LINE__);
  $HTMLOUT.="<h1>Top list</h1>\n";

if($order == "desc")
$HTMLOUT .= "<h2><font color='#999999'>Winner</font> - <a href='$BASEURL/index.php?page=betbonustop&a=1'>Loser</a></h2>";
else
$HTMLOUT .= "<h2><a href='$BASEURL/index.php?page=betbonustop&a=2'>Winner</a> - <font color='#999999'>Loser</font></h2>";

    $HTMLOUT .="<table border='1' cellspacing='0' cellpadding='5'>\n";
    $HTMLOUT .="<tr><td class='colhead' align='left'>Position</td><td class='colhead' align='left'>Username</td><td class='colhead' align='left'>Points +/-</td></tr>\n";
    while ($arr = mysqli_fetch_assoc($res))
    {
    $number++;
    $HTMLOUT .="<tr><td>#".htmlspecialchars($number)."</td><td><a href='$BASEURL/index.php?page=userdetails&id=$arr[userid]'>".htmlspecialchars($arr["username"])."</a></td><td align='right'><b>".htmlspecialchars($arr["bonus"])." Points</b></td></tr>\n";
    }
    $HTMLOUT .="</table>";

$betbonustpl = new bTemplate();
$betbonustpl->set("language", $language);
$betbonustpl->set(betbonus,$HTMLOUT);

?>