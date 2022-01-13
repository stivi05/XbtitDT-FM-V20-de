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


if ($CURUSER["admin_access"]=="no")
stderr("access denied !!");

$id = isset($_GET['id']) && is_valid_id($_GET['id']) ? $_GET['id'] : 0;

$HTMLOUT .="<br><img src='images/betting.png' alt='Bet' title='Betting' width='400' height='125' />
<h1>Admin</h1>
<table class='main' width='200' cellspacing='0' cellpadding='5' border='0'><br>
<tr>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betadmin'>Create Bets</a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betgameinfo'>Bet info</a></td>
<td align='center' class='navigation'><a href='$BASEURL/index.php?page=betgamefinish'>End Bets</a></td>
</tr>
</table>
<br />";

$HTMLOUT .="<h2>Add options to your wager !</h2><table cellpadding='5'>";

$a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betgames WHERE id =".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
while($b = mysqli_fetch_array($a))
{

$HTMLOUT .="<tr><td>".htmlspecialchars($b['1'])."</td>";
$HTMLOUT .="<td><i>".htmlspecialchars($b['undertext'])."</i></td>";
$HTMLOUT .="</tr>";

}
$HTMLOUT .="</table><br />";
  $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, gameid, text FROM {$TABLE_PREFIX}betoptions WHERE gameid =".sqlesc($id)." ORDER BY id asc") or sqlerr(__FILE__, __LINE__);
    $HTMLOUT .="<table border='1' cellspacing='0' cellpadding='5'>\n";
    $HTMLOUT .="<tr>
    <td colspan='2' class='colhead' align='left'>Options</td></tr>\n";
    while ($arr = mysqli_fetch_array($res))
    {
     $HTMLOUT .="<tr><td>".htmlspecialchars($arr['text'])."</td><td><a href='$BASEURL/index.php?page=betdelopt&id=$arr[id]&amp;b=$id'>Delete</a></td></tr>\n";
    }
    $HTMLOUT .="</table><br /><br/>";


$HTMLOUT .="<form action='$BASEURL/index.php?page=betaddoption' method='post'>
Option text: <input type='text' size='10' name='opt' />
<input type='hidden' name='id' value='".htmlspecialchars($id)."' />
<input type='submit' value='Add to game' />
</form>
<br /><br />
<form action='$BASEURL/index.php?page=betaddonetwo' method='post'>
<input type='hidden' name='id' value='".htmlspecialchars($id)."' />
<input type='submit' value='Add 1, X, 2' />
</form>";

$betopttpl = new bTemplate();
$betopttpl->set("language", $language);
$betopttpl->set(betopt,$HTMLOUT);
?>