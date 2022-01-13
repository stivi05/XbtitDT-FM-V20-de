<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
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
////////////////////////////////////////////
////    Bónusz pont utalás By virus ///////
//////////////////////////////////////////
////////////////////////////////////////////
//// Converted to english by reBirth //////
//////////////////////////////////////////
////////////////////////////////////////////
//// Converted for xbtit by cooly /////////
//////////////////////////////////////////
  

if (!defined("IN_BTIT"))
      die("non direct access!");  

if ($CURUSER["view_users"]!="yes")
   {
       err_msg($language["ERROR"],$language["NOT_AUTHORIZED"]." ".$language["MEMBERS"]);
       stdfoot();
       die();
   }

block_begin("Bonus Transfer");

 
$Btrans[]="

<form name=transfer method=post action=index.php?page=bonusdone>
<table width=100% align=center>
<tr>
<td class=header width=80% colspan=5><b>You can transfer your seed bonus points to another member here</b>
</td>
<tr>
<td class=header width=30% align=right>Which user you want to make happy
<td class=lista><input type=text name=username size=30></td>
</tr>
<tr>
<td class=header width=30% align=right>How much points you like to give
<td class=lista><input type=text name=bonuszpont size=6 value=1></td>
</tr>
<tr>
<td class=header width=30% align=right>Use anonymous for sender ID
<td class=lista><input type=checkbox name=anonym value=anonym></td></tr>
<tr><td colspan=2><input name=submit type=submit value=Transfer></td>
</tr>
</table>
</form>";


$bonustpl= new bTemplate(); 
$bonustpl->set("Btrans",$Btrans);

block_end();

?>