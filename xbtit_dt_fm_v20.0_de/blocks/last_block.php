<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit dt fm.
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
echo "<center>";
$query="SELECT * FROM {$TABLE_PREFIX}downloads ORDER BY `id` DESC";
$result=mysqli_query($GLOBALS["___mysqli_ston"], $query);

echo "<table border=\"1\" cellspacing=\"1\" cellpadding=\"1\"><center><b>";
echo "<tr><td><b><center>Ago</td><td><b><center>U/D</td><td><b><center>User</td><td><b><center>Torrent File</b></center></td></tr>";
$num = mysqli_num_rows($result);
if ($num > 0 ) {
$i=0;
$num2=10;

if ($num<10) $num2=$num;
while ($i < $num2) {
$uid = mysqli_result($result,$i,"uid");
$res2=do_sqlquery("SELECT username,id_level from {$TABLE_PREFIX}users WHERE id=$uid");
$result2=mysqli_fetch_array($res2);
$reputt=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}users_level WHERE id_level =".$result2['id_level']);
$setrept=mysqli_fetch_array($reputt);

$name=stripslashes($setrept[prefixcolor]) . $result2[username] . stripslashes($setrept[suffixcolor]);

$date = mysqli_result ($result,$i,"date");

$hash_info = mysqli_result($result,$i,"info_hash");

$res3=do_sqlquery("SELECT filename,external from {$TABLE_PREFIX}files WHERE info_hash='".$hash_info."'");

$result3=mysqli_fetch_array($res3);
$fname=$result3["filename"];
if ($result3["external"]=='yes') $fname="$fname <font color =red>(EXT)</font>";

$damn=sql_timestamp_to_unix_timestamp($date);
$pretty1=get_elapsed_time($damn);

$pos=strpos($pretty1,",");
$pretty=substr($pretty1,0,$pos);
$pretty=$pretty1;
$weeks="week";
$rep="w";
if (strpos($pretty,"week") == true)
$prettynew=str_replace($weeks,$rep,$pretty);

if (strpos($pretty,"day") == true)
$prettynew=str_replace("day","d",$pretty);

if (strpos($pretty,"hour") == true)
$prettynew=str_replace("hour","h",$pretty);

if (strpos($pretty,"min") == true)
$prettynew=str_replace("min","m",$pretty);


if (!$CURUSER || $CURUSER["id_level"]<="2") $name="anonymous";
$updown = mysqli_result($result,$i,"updown");

if ($updown=='up')
$upd="<img src=\"images/speed_up.png\">";
else
$upd="<img src=\"images/speed_down.png\">";

if(getmoderstatusbyhash($hash_info)=='ok')
{
echo "<tr><td>$prettynew</td><td>$upd</td>";
echo "<td><b><font face=\"Verdana\" size=\"1px\" color=\"#254117\"><a href=\"index.php?page=userdetails&id=$uid\">".$name."</font></td>";

echo "<td align=left><b><font face=\"Verdana\" size=\"1px\" color=\"#254117\"><a href=\"index.php?page=torrent-details&id=$hash_info\">".$fname."</a></font></td></tr>";
}

++$i; } } else {
echo "<br>No up/downloads the last 48 hours<br><br>"; }

echo "</b></center></td></tr></table>";
echo "<font size=0>Ago Legend: d=day, w=week, m=min, h=hour";
echo "<center><table border=\"0\" cellspacing=\"0\" cellpadding=\"1\">";
echo "</table>";
?>