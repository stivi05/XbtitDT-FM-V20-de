<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Seed Bonus Control by DiemThuy - Nov 2010
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

if (!defined("IN_ACP"))
      die("non direct access!");


require_once ("include/functions.php");
require_once ("include/config.php");
dbconn();

$pre = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) FROM {$TABLE_PREFIX}sb ") or sqlerr();
$row = mysqli_fetch_row($pre);
$count = $row[0];

    $perpage=25;
    list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=sb_control&");
    
$admintpl->set("language",$language);
$admintpl->set("pager_top",$pagertop);

If($count==0)

{
    $sb[$i]["name"]=("<center><font color=red> no seedbonus </font></center>");
    $sb[$i]["item"]=("<center><font color=green> points  </font></center>");
    $sb[$i]["gb"]=("<center><font color=red> exchanged yet </center>");
    $sb[$i]["points"]=("<center><font color=green> so </font></center></center>");
    $sb[$i]["date"]=("<center><font color=red>nothing here ;)</font></center>");

    $i++;
}
else
{
$data = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}sb ORDER BY date DESC $limit") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
   $sb=array();
   $i=0;
while($info = mysqli_fetch_array( $data ))
{
 $name = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE id=".$info["id"]) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
 $naam = mysqli_fetch_array( $name );
  
    $sb[$i]["name"]=("<center><a href=\"index.php?page=userdetails&amp;id=".$info["id"]."\">".unesc(user_with_color($naam["username"]))."</a></center>");
    $sb[$i]["item"]=("<center>$info[what]</center>");
    $sb[$i]["gb"]=("<center>".makesize($info["gb"])."</center>");
    $sb[$i]["points"]=("<center>$info[points]</center>");
    $sb[$i]["date"]=("<center>$info[date]</center>");
    $i++;
}
}
 $admintpl->set("sb",$sb);
 $admintpl->set("BACK2", "<br /><br /><center><a href=\"javascript: history.go(-1);\"><tag:language.BACK /></a></center>");
?>