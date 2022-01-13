<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015 Btiteam
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
<table align='center' class='main' width='200' cellspacing='0' cellpadding='5' border='0'><br>
<tr>
<td align='center' class='navigation'><a href='index.php?page=bet'>Current Bets</a></td>
<td align='center' class='navigation'><a href='index.php?page=betgameinfo'>Bet Info</a></td>
<td align='center' class='navigation'><a href='index.php?page=betfinish'>End Bets</a></td>
</tr></table><br />";


$HTMLOUT .="<form method='post' action='index.php?page=bettakenew'>
<table align='center' cellpadding='5'>
<tr><td>Bet title :</td><td><input type='text' name='heading' size='50' /></td></tr>
<tr><td><i>Betting on :</i></td><td><input type='text' name='undertext' size='50' value='Enter your wager here' /></td></tr>
<tr><td>End time :</td><td> hours to go : <input type='text' name='hours' size='2'  /> minutes to go : <input type='text' name='minutes' size='2'  /></td></tr>


<tr>
<td>Ordering:</td><td>
<input type='radio' name='sort' value='1' checked='checked' />
After ID<input type='radio' name='sort' value='0' />
After the odds</td></tr>
<tr><td colspan='2' align='center'>
<input  type='submit' value='Submit' />
</td></tr></table></form>";

$HTMLOUT .="<br /><br />
<table align='center' cellpadding='5'>
<tr>
<td><b>Creator</b></td>
<td><b>Endtime</b></td>
<td><b>Bet title</b></td>
<td><b>Betting on</b></td>
<td><b>Set Active</b></td>
<td><b>Add options</b></td>
<td><b>Edit</b></td>
</tr>";
 
$a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT *, endtime as end FROM {$TABLE_PREFIX}betgames order by endtime ASC") or sqlerr(__FILE__, __LINE__);
while($b = mysqli_fetch_array($a))
{
$HTMLOUT .="<tr><td align='left'>".htmlspecialchars($b['6'])."</td>";
if (time() > $b["end"])
$HTMLOUT .="<td align='center'><i>".htmlspecialchars(date('l dS \o\f F Y h:i:s A',$b['3']))."</i></td>";
else
$HTMLOUT .="<td align='center'>".htmlspecialchars(date('l dS \o\f F Y h:i:s A',$b['3']))."</td>";
$HTMLOUT .="<td align='center'>".htmlspecialchars($b['1'])."</td>";
$HTMLOUT .="<td align='center'><i>".htmlspecialchars($b['undertext'])."</i></td>";
if (time() > $b["end"])
$HTMLOUT.="<td align='center'>0</td>";
else
$HTMLOUT .="<td align='center'><a href='index.php?page=betactive&id=".$b['0']."'><u>".htmlspecialchars($b['active'])."</u></a></td>";
$HTMLOUT .="<td align='center'><a href='index.php?page=betoption&id=".$b['0']."'>Add Options</a></td>";
$HTMLOUT .="<td align='center'><a href='index.php?page=betopttwee&id=".$b['0']."'>Edit</a></td></tr>";

}
$HTMLOUT .="</table><br /><br />\n";


$betadmintpl = new bTemplate();
$betadmintpl->set("language", $language);
$betadmintpl->set(betadmin,$HTMLOUT);
?>