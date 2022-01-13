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
    
$HTMLOUT ="";
$HTMLOUT .="<br><img src='images/betting.png' alt='Bet' title='Betting' width='400' height='125' />
<h1>Admin</h1>
<table class='main' width='200' cellspacing='0' cellpadding='5' border='0'><br>
<tr>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betadmin'>Create Bets</a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betgameinfo'><font color='#999999'>Bet info</font></a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betfinish'>End Bets</a></td>
</tr>
</table>
<br />";

$a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betgames order by id ASC") or sqlerr(__FILE__, __LINE__);
while($b = mysqli_fetch_array($a)){
$HTMLOUT .="<table cellpadding='2'>
<tr>
<td class='colhead'>
<a href='$BASEURL/index.php?page=betgameinfo&showgames=".$b['id']."'>".htmlspecialchars($b['heading'])."</a></td></tr></table><br />";
}

if(isset($_GET['showgames'])){
$gameid = $_GET['showgames'];
$total = 0;
$totalbonus = 0;
$a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}bets WHERE gameid =".sqlesc($gameid)." ORDER BY date DESC") or sqlerr(__FILE__, __LINE__);
$HTMLOUT .="<table cellpadding='2'>
<tr>
<td class='colhead'>Date</td>
<td class='colhead'>User</td>
<td class='colhead'>Option</td>
<td class='colhead'>Bonus</td></tr>";

while($b = mysqli_fetch_array($a))
{
$user = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE id =".$b['userid']) or sqlerr(__FILE__, __LINE__);
$username = mysqli_fetch_array($user);
 
$HTMLOUT .="<tr><td>".date('l dS \o\f F Y h:i:s A',$b['date'])."</td>";
$HTMLOUT .="<td><a href='$BASEURL/index.php?page=userdetails&id=".$b['userid']."'>".htmlspecialchars($username['username'])."</a></td>";
$HTMLOUT .="<td>".htmlspecialchars($b['optionid'])."</td>";
$HTMLOUT .="<td>".htmlspecialchars($b['bonus'])."</td></tr>";
$total++;
$totalbonus += $b['bonus'];
}
$HTMLOUT .="</table>";
}
$betgameinfotpl = new bTemplate();
$betgameinfotpl->set("language", $language);
$betgameinfotpl->set(betgameinfo,$HTMLOUT);

?>