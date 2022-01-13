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

$res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `blackjack_stats` FROM `{$TABLE_PREFIX}users` WHERE id=".$CURUSER["uid"]);
$row=mysqli_fetch_assoc($res);

if(!empty($row["blackjack_stats"]))
    $bjstats=unserialize($row["blackjack_stats"]);
else
{ 
    $bjstats["playcount"]=0;
    $bjstats["wincount"]=0;
    $bjstats["losscount"]=0;
    $bjstats["drawcount"]=0;
    $bjstats["bjcount"]=0;
    $bjstats["winloss"]=0;
}
if($bjstats["wincount"]==0)
    $bjstats["percent"]=0;
else
    $bjstats["percent"]=number_format(($bjstats["wincount"]/$bjstats["playcount"])*100,2);

print("<table width='100%' class='lista' cellspacing='0'>\n");
print("<tr>\n<td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$language["PLAYED"].":</td><td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$bjstats["playcount"]."<td></tr>");
print("<tr>\n<td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$language["WINS"].":</td><td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$bjstats["wincount"]."<td></tr>");
print("<tr>\n<td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$language["LOSSES"].":</td><td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$bjstats["losscount"]."<td></tr>");
print("<tr>\n<td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$language["DRAWS"].":</td><td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$bjstats["drawcount"]."<td></tr>");
print("<tr>\n<td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$language["WON_WITH_BLACKJACK"].":</td><td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$bjstats["bjcount"]."<td></tr>");
print("<tr>\n<td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$language["WIN_LOSS_TOTAL"].":</td><td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".(($bjstats["winloss"]>0)?"+ ":"").makesize($bjstats["winloss"])."<td></tr>");
print("<tr>\n<td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$language["WIN_PERCENTAGE"].":</td><td class='lista' style='border-bottom: solid 1px #9BAEBF;width:50%;'>".$bjstats["percent"]."%<td></tr>");
print("</table>");

?>