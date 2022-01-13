<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file ( HIT and RUN block by DiemThuy - april 2009 ) is part of xbtit DT FM.
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

global $btit_settings ,$XBTT_USE;

if (!$XBTT_USE) {

require_once ("include/functions.php");
require_once ("include/config.php");
dbconn();
$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT pid, infohash FROM {$TABLE_PREFIX}peers");

   if (mysqli_num_rows($res) > 0)
   {
       while ($arr = mysqli_fetch_assoc($res))
       {
	   $x=$arr['pid'];
	   $t=$arr['infohash'];
	   $pl=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}users WHERE pid='$x'");
    	   if(mysqli_num_rows($pl)>0)$ccc=mysqli_result($pl,0,"id");
               else $ccc="Unknown" ;
	  	}
   }
$r=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}history WHERE hit='yes' ORDER BY date DESC LIMIT $btit_settings[hitnumber]");
while($x = mysqli_fetch_array($r)){
$t=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username , id_level FROM {$TABLE_PREFIX}users WHERE id=$x[uid]");
$t2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}history WHERE uid=$x[uid] and hit='yes' AND infohash='$x[infohash]'");
$t3=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filename FROM {$TABLE_PREFIX}files WHERE info_hash='$x[infohash]'");
$tb=mysqli_fetch_array($t);

$res4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor , suffixcolor  FROM {$TABLE_PREFIX}users_level WHERE id ='$tb[id_level]'");
$arr4 = mysqli_fetch_assoc($res4);
$name = $arr4[prefixcolor].$tb[username].$arr4[sufixcolor];

if(!$tb) {
$xc="Deleted User";
} else {
$xa=mysqli_result($t,0,"username");
$xc="<a href=index.php?page=userdetails&id=$x[uid]>$name</a>";
}
$tor=mysqli_result($t2,0,"infohash");
$tor2=mysqli_result($t3,0,"filename");
$up=mysqli_result($t2,0,"uploaded");
$up2=number_format(round($up / 1048576,2),2);
$down=mysqli_result($t2,0,"downloaded");
$down2=number_format(round($down / 1048576,2),2);
$seed=mysqli_result($t2,0,"seed");
$seed2=number_format(round($seed / 3600,1),1);
$ratio= number_format(round($up / $down,2),2);
$active=mysqli_result($t2,0,"active");
$datum=mysqli_result($t2,0,"date");

echo "<table class=lista border=0 align=center width=130>";
echo "<tr><td width=15% class=lista ><center><font color = red>User : $xc<img src='images/warn.gif'></center></font></td></tr>";
echo "<tr><td width=15% class=header><center>Did HIT & RUN on</td></tr>";
echo "<tr><td class=lista ><center><a href=index.php?page=details&id=$tor>".str_replace(".", " ", $tor2)."</a></td></tr>";

include("include/offset.php");
echo "<tr><td class=lista ><center>date : ".date("d/m/Y",$datum-$offset)."</td></tr>";
echo "<tr><td class=lista ><center>-----------------------</td></tr></table>";
}
echo "<table class=lista border=0 align=center width=140>";
echo "<tr><td class=lista ><center>";
echo "<div class=dmarquee onmouseover=doMStop() onmouseout=doDMarquee()><div><div><font color = red size = 2>".$btit_settings["scrol_tekst"]."</font></div></div></div>";
echo "</center</td></tr></table>";
}
else
print "Warning !! the Hit & Run system can not be used with XBTT backend , so if you use XBTT disable this block in block settings";

?>