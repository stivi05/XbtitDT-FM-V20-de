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

$HTMLOUT ="";

$HTMLOUT .="<br><img src='images/betting.png' alt='Bet' title='Betting' width='400' height='125' />
<table class='main' width='200' cellspacing='0' cellpadding='5' border='0'><br>
<tr>
<td align='center' class='navigation'><a href='index.php?page=bet'>Bets</a></td>
<td align='center' class='navigation'><a href='index.php?page=betcoupon'>Wagers</a></td>
<td align='center' class='navigation'><a href='index.php?page=betbonustop'>Top list</a></td>
<td align='center' class='navigation'><a href='index.php?page=betinfo'><font color='#999999'>Bet Info</font></a></td>
</tr>
</table>
<br />
<table class='main' width='500' border='0' cellspacing='0' cellpadding='0'><tr><td class='embedded'>
<table width='100%' border='1' cellspacing='0' cellpadding='10'>
<tr><td class='text'>
<b>Bet information!</b><br />
<br />
Bet is an odds / betting system that is similar to other real betting sites on the web.
If you are not at home with the betting systems it will still be easy to understand.

With Bet you use your seed bonus points only.

When you bet points on a result, you'll get the points you bet times the odds of your choice. Your efforts are binding and can not be undone.
The odds are variable.
The odds and the amount of payment for profits can be increased or reduced by adding your wager.
It is the result after full time that counts, so what you waiting on start betting !!.

Banks keep 3% of paying profits, only to control the inflation of bonus points. 

<br />
</td></tr></table>
</td></tr></table>";

$betinfotpl = new bTemplate();
$betinfotpl->set("language", $language);
$betinfotpl->set(betinfo,$HTMLOUT);
?>