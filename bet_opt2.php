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

$HTMLOUT .="<br><img src='images/betting.png' alt='Bet' title='Betting' width='400' height='125' />
<h1>Admin</h1>
<table class='main' width='200' cellspacing='0' cellpadding='5' border='0'><br>
<tr>
<td align='center' class='navigation'><a href='index.php?page=betadmin'>Create Bet</a></td>
<td align='center' class='navigation'><a href='index.php?page=betgameinfo'>Bet info</a></td>
<td align='center' class='navigation'><a href='index.php?page=betgamefinish'>End Bet</a></td>
</tr>
</table>
<br />";

$id = isset($_GET['id']) && is_valid_id($_GET['id']) ? $_GET['id'] : 0;

$a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}betgames where id =".sqlesc($id)."") or sqlerr(__FILE__, __LINE__);
$b = mysqli_fetch_array($a);

$HTMLOUT .="<form method='post' action='index.php?page=bettakeedit'>
<table cellpadding='5'>
<tr>
<td><input name='id' type='hidden' value='".htmlspecialchars($id)."' />
Bet title : </td><td><input type='text' name='heading' size='50' value='".htmlspecialchars($b['1'])."' />
</td>
</tr>
<tr>
<td><i>Betting on :</i></td><td><input type='text' name='undertext' size='50' value='".htmlspecialchars($b['2'])."' /></td>
</tr>
<tr>
<td align='center' colspan='2'>Endtime 
     <select name='endtime'>
     <option value='0'>------</option>
     <option value='900'>15 mins</option>
     <option value='3600'>1 hour</option>
     <option value='7200'>2 hous</option>
     <option value='14400'>4 hours</option>
     <option value='86400'>1 day</option>
     <option value='604800'>1 week</option>
     </select>
     </td>
     </tr><tr>
<td>Ordering:</td> <td><input type='radio' name='sort' value='1' checked='checked' />
After ID<input type='radio' name='sort' value='0' /> 
After odds</td></tr>
</table><br />
<input type='submit' value='Save Changes' />
</form>
<br /><br />
Click <a href='index.php?page=betdelgame&id=".$b['0']."'><u>Here</u></a> to delete the game.
<br /><br />
Click <a href='index.php?page=betback&id=".$b['0']."'><u>Here</u></a> to delete the bet and pay back everyone's points.";

$betopttweetpl = new bTemplate();
$betopttweetpl->set("language", $language);
$betopttweetpl->set(betopttwee,$HTMLOUT);
?>