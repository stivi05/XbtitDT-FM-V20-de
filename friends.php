<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  XBtiteam
//
//    This file is part of xbtit DT FM.
//
// Social Network Hack by DiemThuy - Nov 2010
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

$friend_id = (int)$_GET["frid"];

$friendstpl= new bTemplate();
$friendstpl-> set("language",$language);

// username
$name=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE id=".$friend_id);
$nam=mysqli_fetch_array($name);
$friendstpl->set("un",$nam["username"]);
//end username	
	
    $qryf=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}friendlist WHERE rejected='no' AND confirmed='yes' AND (user_id = ".$friend_id." OR friend_id = ".$friend_id.")");
	$counf=mysqli_num_rows($qryf);
         $friend=array();
         $i=0;

	if ($counf==0)
	{
	   $friend[$i]["avatar"]=("<center><font color = red>there</font></center>");
       $friend[$i]["name"]=("<center><font color = red>are</font></center>");
       $friend[$i]["level"]=("<center><font color = red>no</font></center>");
       $friend[$i]["acces"]= ("<center><font color = red>friends</font></center>");
       $friend[$i]["status"]=("<center><font color = red>here</font></center>");
       $friend[$i]["mutual"]=("<center><font color = red>yet</font></center>");
       $i++;		
	}

while ($resf=mysqli_fetch_array($qryf))
	{
		 if ($resf["username"]==$CURUSER['username']){
		 $torf=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT o.lastaction, ul.prefixcolor, ul.suffixcolor, ul.level, u.username, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id WHERE u.id>1 AND u.id = ".$resf['friend_id']);
		 }else{
		$torf=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT o.lastaction, ul.prefixcolor, ul.suffixcolor, ul.level, u.username, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id WHERE u.id>1 AND u.id = ".$resf['user_id']);
			}

// mutual
$torr=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from {$TABLE_PREFIX}friendlist WHERE user_id = ".$CURUSER['uid']." OR friend_id =".$CURUSER['uid']."");
$retr=mysqli_fetch_assoc($torr);
if (($retr["friend_id"]==$resf["friend_id"]) OR ($retr["user_id"]==$resf["user_id"]))
   $friend[$i]["mutual"]='<font color = green><b>yes</b></font>';
else
   $friend[$i]["mutual"]='<font color = steelblue><b>no</b></font>';
   
// avatar
        $avatar = ($retf["avatar"] && $retf["avatar"] != "" ? htmlspecialchars($retf["avatar"]) : "");
        if ($avatar=="")
        $av=("<img src='$STYLEURL/images/default_avatar.gif' border='0' width=30 />");
           else
           $av=("<img width=30 src=$avatar>");
// end avatar           
           
// Online User
         (is_null($retf["lastaction"])?$lastseen=$retf["lastconnect"]:$lastseen=$retf["lastaction"]);
        ((time()-$lastseen>900)?$status="<img src='images/offline.gif' border='0' alt='".$language["OFFLINE"]."'>":$status="<img src='images/online.gif' border='0' alt='".$language["ONLINE"]."'>");
// end online users

       $friend[$i]["id"]=$resf["id"];
       $friend[$i]["avatar"]=("<center>$av</center>");
       $friend[$i]["name"]=("<a href=index.php?page=userdetails&id=".$resf["friend_id"].">".unesc($retf["prefixcolor"]).unesc($retf["username"]).unesc($retf["suffixcolor"])."</a>");
       $friend[$i]["level"]=$retf['level'];
       $friend[$i]["acces"]= $resf['friend_date'];
       $friend[$i]["status"]=("<center>$status</center>");
       $i++;
}
$friendstpl->set("friend",$friend);