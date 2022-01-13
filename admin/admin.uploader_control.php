<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    Uploader Control by DiemThuy ( Jan 2010 )
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

require_once("include/functions.php");

// uploaders

$result=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT ul.prefixcolor,ul.suffixcolor ,f.uploader,u.id, u.lastconnect,u.id_level,u.username,count( f.info_hash ) AS Count, max( DATA ) AS LastTorrent FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}files f  ON u.id = f.uploader LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id GROUP BY username ORDER BY Count DESC");

$UC=array();
$i=0;

    if ($result)
    {
    while ($dat=mysqli_fetch_array($result))
    {
     
if ($dat['id_level']==4)
{
$time_A = strtotime($dat["LastTorrent"]);
$time_B=strtotime(now);
$numdays=(($time_B-$time_A)/86400);
$UC[$i]["username"]=("<a href=index.php?page=userdetails&id=".$dat["uploader"].">".$dat["prefixcolor"].$dat['username'].$dat["suffixcolor"]."</a>");
$UC[$i]["last"]=$dat['lastconnect'];
$UC[$i]["act"]=$dat['Count'];
$UC[$i]["upl"]=$dat['LastTorrent'];
$UC[$i]["days"]=round($numdays);
$UC[$i]["pm"] = "<a href=\"index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=$CURUSER[uid]&amp;what=new&amp;to=".urlencode(unesc($dat["username"]))."\">".image_or_link("$STYLEPATH/images/pm.png","",$language["USERS_PM"])."</a>";
$i++;
}
}
}
$admintpl->set("UC",$UC);

// none uploaders

$resultt=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT ul.prefixcolor,ul.suffixcolor ,f.uploader,u.id, u.lastconnect,u.id_level,u.username,count( f.info_hash ) AS Count, max( DATA ) AS LastTorrent FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}files f  ON u.id = f.uploader LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id GROUP BY username ORDER BY Count DESC");

$UCO=array();
$ii=0;

    if ($resultt)
    {
    while ($datt=mysqli_fetch_array($resultt))
    {

if ($datt['id_level']!=4)
{
$time_C = strtotime($datt["LastTorrent"]);
$time_D=strtotime(now);
$numdayss=(($time_D-$time_C)/86400);
$UCO[$ii]["username"]=("<a href=index.php?page=userdetails&id=".$datt["uploader"].">".$datt["prefixcolor"].$datt['username'].$datt["suffixcolor"]."</a>");
$UCO[$ii]["last"]=$datt['lastconnect'];
$UCO[$ii]["act"]=$datt['Count'];
$UCO[$ii]["upl"]=$datt['LastTorrent'];
$UCO[$ii]["days"]=round($numdayss);
$UCO[$ii]["pm"] = "<a href=\"index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=$CURUSER[uid]&amp;what=new&amp;to=".urlencode(unesc($datt["username"]))."\">".image_or_link("$STYLEPATH/images/pm.png","",$language["USERS_PM"])."</a>";
$ii++;
}
}
}
$admintpl->set("UCO",$UCO);
?>