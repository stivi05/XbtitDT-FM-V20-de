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
dbconn(false);
global $TABLE_PREFIX;
if ($CURUSER["admin_access"] == "yes")
$edit = 1;
$res2 = mysqli_query($GLOBALS["___mysqli_ston"], "select count(*) from casino") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row2 = mysqli_fetch_array($res2);
$count = $row2[0];
$perpage = 50;
list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, "index.php?page=modules&module=casino&action=stats&amp;");
$res = mysqli_query($GLOBALS["___mysqli_ston"], "select {$TABLE_PREFIX}users.id as userid,{$TABLE_PREFIX}users.username, {$TABLE_PREFIX}users.downloaded, {$TABLE_PREFIX}users.uploaded, casino.win, casino.lost,casino.deposit from casino inner join {$TABLE_PREFIX}users on casino.userid = {$TABLE_PREFIX}users.id ORDER BY (casino.win - casino.lost) DESC $limit") or sqlerr();
//stdhead("Players");
if (mysqli_num_rows($res) == 0)
print("<p align=center><b>No players</b></p><br><a href=\"javascript:history.back();\">Go back</a>\n");
else
{
//begin_frame("List of Casino Players");
print("<p align=center><a href=index.php?page=modules&module=casino>Back</a></p>\n");
echo $pagertop;
print("<div align=center>");
print("<table border=1 cellspacing=0 cellpadding=5>\n");


if($edit==0)
print("<tr><td class=header>Name</td><td class=header align=center>Uploaded</td><td class=header align=center>Downloaded</td><td class=header align=center>Ratio</td><td class=header align=center>Deposit on P2P</td><td class=header align=center>Won</td><td class=header align=center>Lost</td><td class=header align=center>Trys</td><td class=header align=center>Total</td><td class=header align=center>Can Play</td>\n");
else
print("<tr><td class=header>Name</td><td class=header align=center>Uploaded</td><td class=header align=center>Downloaded</td><td class=header align=center>Ratio</td><td class=header align=center>Deposit on P2P</td><td class=header align=center>Won</td><td class=header align=center>Lost</td><td class=header align=center>Trys</td><td class=header align=center>Total</td><td class=header align=center>Can Play</td><td class=header align=center>edit user</td>\n");


while ($arr = mysqli_fetch_assoc($res))
{
$rez = mysqli_query($GLOBALS["___mysqli_ston"], "select * from casino where userid=$arr[userid]");
$arz = mysqli_fetch_array($rez);
if ($arr["downloaded"] > 0)
{
$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);
}
else
if ($arr["uploaded"] > 0)
$ratio = "Inf.";
else
$ratio = "---";
$uploaded =makesize($arr["uploaded"]);
$downloaded = makesize($arr["downloaded"]);
if ($CURUSER[uid] == $arr[userid])
$bg = "class=blocklist";
else
$bg = "class=main";

$all = $arz[win]-$arz[lost];
if($all < 0)
{
$all = $all * -1;
$minus = "-";
}
if($arz[enableplay]=="yes"){
$arz[enableplay]="<font color=green>Yes</font>";
}else{
$arz[enableplay]="<font color=red>No</font>";
}
if($edit==0)
print("<tr><td $bg align=center><a href=index.php?page=userdetails&id=$arr[userid]><center><b>$arr[username]</b></a></center></td><td align=center $bg><center>$uploaded</center></td><td align=center $bg><center>$downloaded</center></td><td  align=center $bg><center>$ratio</center></td><td align=center $bg><center>".makesize($arz[deposit])."</center></td><td  align=center $bg><center>".makesize($arz[win])."</center></td><td  align=center $bg><center>".makesize($arz[lost])."</center></td><td align=center $bg><center>$arz[trys]</center></td><td  align=center $bg><center> $minus".makesize($all)."</center></td><td  align=center $bg><center>$arz[enableplay]</center></td></tr>\n");
else
print("<tr><td $bg align=center><a href=index.php?page=userdetails&id=$arr[userid]><center><b>$arr[username]</b></a></center></td><td  align=center $bg><center>$uploaded</center></td><td  align=center $bg><center>$downloaded</center></td><td  align=center $bg><center>$ratio</center></td><td align=center $bg><center>".makesize($arz[deposit])."</center></td><td  align=center $bg><center>".makesize($arz[win])."</center></td><td  align=center $bg><center>".makesize($arz[lost])."</center></td><td  align=center $bg><center>$arz[trys]</center></td><td  align=center $bg><center> $minus".makesize($all)."</center></td><td  align=center $bg><center>$arz[enableplay]</center></td><td  align=center $bg><form name=edit-player method=post action=index.php?page=modules&module=casino&action=edit><input type=hidden name=userid value=$arr[userid]> <input class=btn type=submit value=edit ></form></td></tr>\n");
}
print("</table>\n");
print("</div>");
//end_frame();
print("<br/>");
}

?>