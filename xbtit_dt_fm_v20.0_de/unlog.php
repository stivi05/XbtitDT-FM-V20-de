<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    Username change log by DiemThuy oct 2013
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
      
      
$id = AddSlashes($_GET["id"]);
if (!isset($id) || !$id)
    die("Error ID");

if ($CURUSER['id_level'] < 6)
{     
if ($CURUSER['uid']!== $id)
{
	  stderr("Error","You are not allowed to see the name change history from this user!!");
      stdfoot();
      die;	
}
}
$unlogtpl= new bTemplate();
$unlogtpl-> set("language",$language);    

$pre = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) FROM {$TABLE_PREFIX}username WHERE uid='$id'") or sqlerr();
$row = mysqli_fetch_row($pre);
$count = $row[0];

If($count==0)

{
    $un[$i]["uid"]=("<center><font color=green>This User</font></center>");
    $un[$i]["date"]=("<center><font color=red>did not change</font></center>");
    $un[$i]["org"]=("<center><font color=green>his / her</font></center>");
    $un[$i]["username"]=("<center><font color=red>username yet</font></center>");
    $i++;
}
else
{
$data = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}username WHERE uid='$id' ORDER BY date DESC") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
   $un=array();
   $i=0;
while($info = mysqli_fetch_array( $data ))
{
    $un[$i]["uid"]=("<center>$info[uid]</center>");
    $un[$i]["date"]=("<center>$info[date]</center>");
    $un[$i]["org"]=("<center>$info[org]</center>");
    $un[$i]["username"]=("<center>$info[username]</center>");
    $i++;
}
}
 $unlogtpl->set("un",$un);
 $unlogtpl->set("BACK2", "<br /><br /><center><a href=\"javascript: history.go(-1);\"><tag:language.BACK /></a></center>");
?>