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

$HTMLOUT .="<br><img src='images/betting.png' alt='Bet' title='Betting' width='400' height='125' />
<table class='main' width='40%' cellspacing='0' cellpadding='5' border='0'><br>
<tr>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=bet'><font color='#999999'>Current Bets</font></a></td>";
if ($CURUSER["admin_access"]=="yes")
{
$HTMLOUT .= "<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betadmin'>Bet Admin</a></td>";
}
$HTMLOUT .="<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betcoupon'>Wagers</a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betbonustop'>Top list</a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betinfo'>Info</a></td>
</tr></table><br />";

$tid = time();

mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}betgames set active = 0 WHERE endtime < $tid") or sqlerr(__FILE__, __LINE__);

$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betgames WHERE active = 1 ORDER BY endtime ASC") or sqlerr(__FILE__, __LINE__);
if(mysqli_num_rows($res) == 0)
{
$HTMLOUT .= "<i>Unfortunately, there is no active bets right now. Come back later! :)</i>";
}


while($a = mysqli_fetch_assoc($res))
{
if($a['sort']==0)
$sort = "odds ASC";
elseif($a['sort']==1)
$sort = "id ASC";

$res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from {$TABLE_PREFIX}betoptions where gameid =".sqlesc($a["id"])." ORDER BY $sort") or sqlerr(__FILE__, __LINE__);
$HTMLOUT .= "<table width='40%' cellpadding='5'>
<tr>
<td colspan='3' class='colhead'>".htmlspecialchars($a["heading"])."<br /><i>".htmlspecialchars($a["undertext"])."</i>";
$HTMLOUT .= "</td></tr>";

while($b = mysqli_fetch_assoc($res2))
{
$odds = $b['odds'];

switch(strlen($odds))
{
case 1:
$odds = $odds.".00";
break;
case 3:
$odds = $odds."0";
break;
}

$HTMLOUT .="<tr><td class='header' width='40%'>".htmlspecialchars($b['text'])."</td><td class='lista'><a href='$BASEURL/index.php?page=betodds&id=".$b['id']."'>".htmlspecialchars($odds)."</a></td></tr>";
}
$HTMLOUT .="<tr><td class='lista' colspan='2' width='40%'><font size='1'><center>This game closes to new odds: <b>". date('l dS \o\f F Y h:i:s A',$a['endtime'])."</b><br>Time left: <b>".round(($a['endtime'] - time())/60 )." minutes</center></b></font></td></tr>";
$HTMLOUT .="</table>";
}
$bettpl = new bTemplate();
$bettpl->set("language", $language);
$bettpl->set(bet,$HTMLOUT);
?>