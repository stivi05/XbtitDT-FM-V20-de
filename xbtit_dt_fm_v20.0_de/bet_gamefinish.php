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


if ($CURUSER["admin_access"]=="no")
stderr("access denied !!");

$HTMLOUT ="";

$HTMLOUT .="<br><img src='images/betting.png' alt='Bet' title='Betting' width='400' height='125' />
<h1>Admin</h1>
<table class='main' width='200' cellspacing='0' cellpadding='5' border='0'><br>
<tr>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betadmin'>Add Bets</a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betgameinfo'>Bet info</a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betgamefinish'><font color='#999999'>End Bets</font></a></td>
</tr>
</table>
<br />";

$HTMLOUT .="<h1>! Warning !<br /> Click on the winning option, to pay out the winner !<br />! Warning !</h1>";

$end = time();
$active = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betgames where active = 0 AND endtime <".sqlesc($end)."") or sqlerr(__FILE__, __LINE__);
while($active1 = mysqli_fetch_assoc($active))
{
$HTMLOUT .="<br /><br />Games: <b><u>".htmlspecialchars($active1['heading'])."</u></b>";

$a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betoptions where gameid =".sqlesc($active1["id"])." ORDER BY id ASC") or sqlerr(__FILE__, __LINE__);
while($b = mysqli_fetch_assoc($a))
{
$HTMLOUT .="<br /><a href='$BASEURL/index.php?page=betfinishtwo&id=".$b['id']."'>".htmlspecialchars($b['text'])."</a> (".htmlspecialchars($b['odds']).")";
}
}
$betfinishtpl = new bTemplate();
$betfinishtpl->set("language", $language);
$betfinishtpl->set(betfin,$HTMLOUT);
?>