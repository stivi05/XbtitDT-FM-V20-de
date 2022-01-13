<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Grabbed Hack by DiemThuy - Feb 2010
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
      
global $CURUSER ;
      
      if ($CURUSER["id_level"]==1)
{
	redirect("users.php"); // redirects to users.php if guest
	exit();
}
$grabbedtpl= new bTemplate();
$grabbedtpl-> set("language",$language);
require_once("include/functions.php");

dbconn();


$res_user=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT pid FROM {$TABLE_PREFIX}users WHERE id='".$CURUSER["uid"]."'")or sqlerr();
$row_user=mysqli_fetch_array($res_user);

$res_load =do_sqlquery("SELECT * FROM {$TABLE_PREFIX}down_load WHERE pid='".$row_user["pid"]."'")or sqlerr();


if ($res_load)
{
         $grabbed=array();
         $i=0;
         while ($row_load=mysqli_fetch_array($res_load))
	{
$res_files=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}files WHERE info_hash='".$row_load["hash"]."'")or sqlerr();
$row_files=mysqli_fetch_array($res_files);

$res_peers=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}peers WHERE infohash='".$row_files["info_hash"]."'")or sqlerr();
$row_peers=mysqli_fetch_array($res_peers);

if ($row_load["pid"]==$row_peers["pid"])
{
$act='<b><font color=green>still active</font></b>';
}
else
{
$act='<b><font color=red>not active</font></b>';
}
       $grabbed[$i]["filename"]="<A HREF=\"index.php?page=torrent-details&amp;id=".$row_files["info_hash"]."\">".$row_files["filename"]."</A>";
       $grabbed[$i]["date"]=$row_load["time"];
       $grabbed[$i]["active"]=$act;
       $i++;
}
}
$grabbedtpl->set("grabbed",$grabbed);
?>