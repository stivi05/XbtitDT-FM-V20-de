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

$friendtpl= new bTemplate();
$friendtpl-> set("language",$language);

$do = $_GET["do"];
$friend_id = (int)$_GET["friend_id"];

// Add member to friendlist

if ($do=="add")
{
// first some fool protection
	if (!isset($friend_id))
	{
		redirect("index.php?page=users"); 
		exit();
	}

    $hmm=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}friendlist WHERE friend_id = '$friend_id' AND user_id = ".$CURUSER['uid']);
	if (mysqli_num_rows($hmm))
	{
		stderr('Error','This member is allready a friend of you'); 
        stdfoot();
 	    die();
	}

	if ($friend_id==$CURUSER['uid'])
	{
		stderr('Error','You can not be friends with yourself , right ?');
        stdfoot();
 	    die();
	}
	$qry = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE id = '$friend_id'");
	$res = mysqli_fetch_array($qry);
	$chk = mysqli_num_rows($qry);
	if (!$chk)
	{
		redirect("index.php?page=users"); 
		exit();
	}
// here we add the un-fooled info in the db	
	mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}friendlist (user_id, friend_id, friend_name, friend_date, username) VALUES ('".$CURUSER["uid"]."', '".$friend_id."', '".$res["username"]."',NOW(),'".$CURUSER["username"]."' )");
//pm 
$subj=sqlesc("Friendship Request!");
$mesg=sqlesc("".$CURUSER["username"]." wants to be friends with you  \n\n Go to your friend list to accept or reject this request \n\n [color=red]AUTOMATIC SYSTEM MESSAGE - SO DON,T REPLY !![/color]");	
send_pm(0,$friend_id,$subj,$mesg);
//pm
redirect("index.php?page=friendlist");
exit();
}

// Remove pending friend
elseif ($do=="rem")
{
{
$msg = (int)$_GET["id"];
//pm 
$pme=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}friendlist WHERE id=".$msg);
$pmoe=mysqli_fetch_array($pme);
$subj=sqlesc("Friendship Request Deleted!");
$mesg=sqlesc("".$pmoe["username"]." have deleted his friendship request \n\n So probably ".$pmoe["username"]." don,t want to be friends after all \n\n For that reason you wil not see ".$pmoe["username"]." in your request list anymore  \n\n [color=red]AUTOMATIC SYSTEM MESSAGE - SO DON,T REPLY !![/color]");	
send_pm(0,$pmoe["friend_id"],$subj,$mesg);
//pm
	@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}friendlist WHERE id=\"$msg\"");
	}
	redirect("index.php?page=friendlist");
	exit();
}

// Add friend
elseif ($do=="fadd")
{
{
        $msg = (int)$_GET["id"];
		@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}friendlist SET rejected='no' , confirmed ='yes' , friend_date = NOW() WHERE id=\"$msg\"");
	}
//pm 
$pm=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}friendlist WHERE id=".$msg);
$pmok=mysqli_fetch_array($pm);
$subj=sqlesc("Friendship Accepted!");
$mesg=sqlesc("".$pmok["friend_name"]." have accepted your friendship  \n\n You can see in your friendlist the status is changed \n\n [color=red]AUTOMATIC SYSTEM MESSAGE - SO DON,T REPLY !![/color]");	
send_pm(0,$pmok["user_id"],$subj,$mesg);
//pm

	redirect("index.php?page=friendlist");
	exit();
}

// Add Back
elseif ($do=="badd")
{

$msg = (int)$_GET["id"];

//pm 
$pm=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}friendlist WHERE id=".$msg);
$pmok=mysqli_fetch_array($pm);

$subj=sqlesc("Friendship Request!");
if ($pmok["user_id"]==$CURUSER["uid"])
{
$mesg=sqlesc("".$pmok["username"]." wants to be friends with you after all \n\n Go to your friend list to accept or reject this request \n\n [color=red]AUTOMATIC SYSTEM MESSAGE - SO DON,T REPLY !![/color]");
$var = $pmok["friend_id"];
$one = $pmok["username"];
$two = $pmok["friend_name"];
$three = $pmok["user_id"];
$four = $pmok["friend_id"];
}
if ($pmok["friend_id"]==$CURUSER["uid"])
{
$mesg=sqlesc("".$pmok["friend_name"]." wants to be friends with you after all \n\n Go to your friend list to accept or reject this request \n\n [color=red]AUTOMATIC SYSTEM MESSAGE - SO DON,T REPLY !![/color]");
$var = $pmok["user_id"];
$one = $pmok["username"];
$two = $pmok["friend_name"];
$three = $pmok["user_id"];
$four = $pmok["friend_id"];
}
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}friendlist SET friend_name ='".$one."' ,username ='".$two."' ,friend_id ='".$three."' , user_id ='".$four."', rejected='no' , confirmed ='no' , friend_date = NOW() WHERE id=\"$msg\"");	
send_pm(0,$var,$subj,$mesg);
//pm
		
    
	redirect("index.php?page=friendlist");
	exit();
}

// Unfriend
elseif ($do=="del")
{

$msg = (int)$_GET["id"];

//pm 
$pmm=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}friendlist WHERE id=".$msg);
$lmok=mysqli_fetch_array($pmm);

$subj=sqlesc("Friendship Rejected!");
if ($lmok["user_id"]==$CURUSER["uid"])
{
$mesg=sqlesc("".$lmok["username"]." have rejected your friendship  \n\n You can see in your friendlist the status is changed \n\n [color=red]AUTOMATIC SYSTEM MESSAGE - SO DON,T REPLY !![/color]");
$var=$lmok["friend_id"];
}
if ($lmok["friend_id"]==$CURUSER["uid"])
{
$mesg=sqlesc("".$lmok["friend_name"]." have rejected your friendship  \n\n You can see in your friendlist the status is changed \n\n [color=red]AUTOMATIC SYSTEM MESSAGE - SO DON,T REPLY !![/color]");
$var=$lmok["user_id"];
}
 send_pm(0,$var,$subj,$mesg);
 //pm
 @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}friendlist SET rejected ='yes' , friend_date = NOW() WHERE id=\"$msg\"");	

	redirect("index.php?page=friendlist");
	exit();
}

// Main friendlist page

else
{
// pending 
 
 	$qrr=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}friendlist WHERE rejected='no' AND confirmed='no' AND user_id = ".$CURUSER['uid']);
	$counhk=mysqli_num_rows($qrr);
	$pending=array();
    $iiii=0;

if ($counhk ==0)
	{
       $pending[$iiii]["avatar"]=("<center><font color = red>you</font></center>");
       $pending[$iiii]["name"]=("<center><font color = steelblue>have</font></center>");
       $pending[$iiii]["level"]=("<center><font color = red>no</font></center>");
       $pending[$iiii]["acces"]= ("<center><font color = steelblue>pending</font></center>");
       $pending[$iiii]["status"]=("<center><font color = red>friend</font></center>");
       $pending[$iiii]["pm"]=("<center><font color = steelblue>...</font></center>");
       $pending[$iiii]["delete"]=("<center><font color = red>yet</font></center>");
       $iiii++;	
		
	}

while ($resrr=mysqli_fetch_array($qrr))
	
	{
		$torrr=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT o.lastaction, ul.prefixcolor, ul.suffixcolor, ul.level, u.username, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id WHERE u.id>1 AND u.id = ".$resrr['friend_id']);
$retrr=mysqli_fetch_array($torrr);
        
// avatar  
        $avatar = ($retrr["avatar"] && $retrr["avatar"] != "" ? htmlspecialchars($retrr["avatar"]) : "");
        if ($avatar=="")
        $av=("<img src='$STYLEURL/images/default_avatar.gif' border='0' width=30 />");
           else
           $av=("<img width=30 src=$avatar>");
// end avatar           
           
// Online User
         (is_null($retrr["lastaction"])?$lastseen=$retrr["lastconnect"]:$lastseen=$retrr["lastaction"]);
        ((time()-$lastseen>900)?$status="<img src='images/offline.gif' border='0' alt='".$language["OFFLINE"]."'>":$status="<img src='images/online.gif' border='0' alt='".$language["ONLINE"]."'>");
// end online users

       $pending[$iiii]["id"]=$resrr["id"];
       $pending[$iiii]["avatar"]=("<center>$av</center>");
       $pending[$iiii]["name"]=("<a href=index.php?page=userdetails&id=".$resrr["friend_id"].">".unesc($retrr["prefixcolor"]).unesc($retrr["username"]).unesc($retrr["suffixcolor"])."</a>");
       $pending[$iiii]["level"]=$retrr['level'];
       $pending[$iiii]["acces"]= $resrr['friend_date'];
       $pending[$iiii]["status"]=("<center>$status</center>");
       $pending[$iiii]["pm"] = "<a href=\"index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=$CURUSER[uid]&amp;what=new&amp;to=".urlencode(unesc($retrr["username"]))."\">".image_or_link("images/pm.gif","",$language["USERS_PM"])."</a>";
       $pending[$iiii]["delete"]=("<a href=\"index.php?page=friendlist&do=rem&amp;id=".$pending[$iiii]["id"]."\" onclick=\"return confirm('".AddSlashes($language["REJECT"])."')\">".image_or_link("images/user_remove.png","",$language["DELETE"])."</a>");
       $iiii++;
}
$friendtpl->set("pending",$pending);
	
//  friend requests

	$qry=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}friendlist WHERE rejected='no' AND confirmed='no' AND friend_id = ".$CURUSER['uid']);
	$coun=mysqli_num_rows($qry);
	$friend=array();
    $i=0;

if ($coun ==0)
	{
       $friend[$i]["avatar"]=("<center><font color = red>no</font></center>");
       $friend[$i]["name"]=("<center><font color = steelblue>users</font></center>");
       $friend[$i]["level"]=("<center><font color = red>want</font></center>");
       $friend[$i]["acces"]= ("<center><font color = steelblue>to</font></center>");
       $friend[$i]["status"]=("<center><font color = red>be</font></center>");
       $friend[$i]["pm"]=("<center><font color = steelblue>friends</font></center>");
       $friend[$i]["add"]=("<center><font color = red>...</font></center>");
       $friend[$i]["delete"]=("<center><font color = steelblue>yet</font></center>");
       $i++;	
	}

while ($res=mysqli_fetch_array($qry))
	
	{
		$tor=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT o.lastaction, ul.prefixcolor, ul.suffixcolor, ul.level, u.username, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id WHERE u.id>1 AND u.id = ".$res['user_id']);
$ret=mysqli_fetch_array($tor);
        
// avatar  
        $avatar = ($ret["avatar"] && $ret["avatar"] != "" ? htmlspecialchars($ret["avatar"]) : "");
        if ($avatar=="")
        $av=("<img src='$STYLEURL/images/default_avatar.gif' border='0' width=30 />");
           else
           $av=("<img width=30 src=$avatar>");
// end avatar           
           
// Online User
         (is_null($ret["lastaction"])?$lastseen=$ret["lastconnect"]:$lastseen=$ret["lastaction"]);
        ((time()-$lastseen>900)?$status="<img src='images/offline.gif' border='0' alt='".$language["OFFLINE"]."'>":$status="<img src='images/online.gif' border='0' alt='".$language["ONLINE"]."'>");
// end online users

       $friend[$i]["id"]=$res["id"];
       $friend[$i]["avatar"]=("<center>$av</center>");
       $friend[$i]["name"]=("<a href=index.php?page=userdetails&id=".$res["user_id"].">".unesc($ret["prefixcolor"]).unesc($ret["username"]).unesc($ret["suffixcolor"])."</a>");
       $friend[$i]["level"]=$ret['level'];
       $friend[$i]["acces"]= $res['friend_date'];
       $friend[$i]["status"]=("<center>$status</center>");
       $friend[$i]["pm"] = "<a href=\"index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=$CURUSER[uid]&amp;what=new&amp;to=".urlencode(unesc($ret["username"]))."\">".image_or_link("images/pm.gif","",$language["USERS_PM"])."</a>";
       $friend[$i]["add"]=("<a href=\"index.php?page=friendlist&do=fadd&amp;id=".$friend[$i]["id"]."\" onclick=\"return confirm('".AddSlashes($language["REFRIEND"])."')\">".image_or_link("images/user_accept.png","",$language["DELETE"])."</a>");
       $friend[$i]["delete"]=("<a href=\"index.php?page=friendlist&do=del&amp;id=".$friend[$i]["id"]."\" onclick=\"return confirm('".AddSlashes($language["REJECT"])."')\">".image_or_link("images/user_remove.png","",$language["DELETE"])."</a>");
       $i++;
}
$friendtpl->set("friend",$friend);
	
// confirmed friends

$qdt=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}friendlist WHERE rejected='no' AND confirmed='yes' AND (user_id = ".$CURUSER['uid']." OR friend_id = ".$CURUSER['uid'].")");
$counhkkk=mysqli_num_rows($qdt);
	$friends=array();
    $ii=0;

if ($counhkkk ==0)
{
	   $friends[$ii]["avatar"]=("<center><font color = red>you</font></center>");
       $friends[$ii]["name"]=("<center><font color = steelblue>have</font></center>");
       $friends[$ii]["level"]=("<center><font color = red>no</font></center>");
       $friends[$ii]["acces"]= ("<center><font color = steelblue>confirmed</font></center>");
       $friends[$ii]["status"]=("<center><font color = red>friends</font></center>");
       $friends[$ii]["pm"]=("<center><font color = steelblue>...</font></center>");
       $friends[$ii]["delete"]=("<center><font color = red>yet</font></center>");
       $ii++;	
}

while ($rdt=mysqli_fetch_array($qdt))
	{

if ($rdt["friend_id"]==$CURUSER["uid"])
{
		$torf=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT o.lastaction, ul.prefixcolor, ul.suffixcolor, ul.level, u.username, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id WHERE u.id>1 AND u.id = ".$rdt['user_id']);
$iid=$rdt['user_id'];		
}
else
{
		$torf=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT o.lastaction, ul.prefixcolor, ul.suffixcolor, ul.level, u.username, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id WHERE u.id>1 AND u.id = ".$rdt['friend_id']);
$iid=$rdt['friend_id'];			
}
		
$retf=mysqli_fetch_array($torf);

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

       $friends[$ii]["id"]=$rdt["id"];
       $friends[$ii]["avatar"]=("<center>$av</center>");
       $friends[$ii]["name"]=("<a href=index.php?page=userdetails&id=".$iid.">".unesc($retf["prefixcolor"]).unesc($retf["username"]).unesc($retf["suffixcolor"])."</a>");
       $friends[$ii]["level"]=$retf['level'];
       $friends[$ii]["acces"]= $rdt['friend_date'];
       $friends[$ii]["status"]=("<center>$status</center>");
       $friends[$ii]["pm"] = "<a href=\"index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=$CURUSER[uid]&amp;what=new&amp;to=".urlencode(unesc($retf["username"]))."\">".image_or_link("images/pm.gif","",$language["USERS_PM"])."</a>";
       $friends[$ii]["delete"]=("<a href=\"index.php?page=friendlist&do=del&amp;id=".$friends[$ii]["id"]."\" onclick=\"return confirm('".AddSlashes($language["UNFRIEND"])."')\">".image_or_link("images/user_remove.png","",$language["DELETE"])."</a>");
       $ii++;

}
$friendtpl->set("friends",$friends);
	
// rejected & unfriend friends	
$qdtt=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}friendlist WHERE rejected='yes' AND (user_id = ".$CURUSER['uid']." OR friend_id = ".$CURUSER['uid'].")");;
	$counhkk=mysqli_num_rows($qdtt);
    
	$unfriends=array();
    $iii=0;
    

if ($counhkk ==0)

{
       $unfriends[$iii]["avatar"]=("<center><font color = red>no</font></center>");
       $unfriends[$iii]["name"]=("<center><font color = steelblue>rejected</font></center>");
       $unfriends[$iii]["level"]=("<center><font color = red>or</font></center>");
       $unfriends[$iii]["acces"]= ("<center><font color = steelblue>unfriend</font></center>");
       $unfriends[$iii]["status"]=("<center><font color = red>users</font></center>");
       $unfriends[$iii]["pm"]=("<center><font color = steelblue>...</font></center>");
       $unfriends[$iii]["delete"]=("<center><font color = red>yet</font></center>");
       $iii++;	
}

while ($rdtt=mysqli_fetch_array($qdtt))
	{

if ($rdtt["friend_id"]==$CURUSER["uid"])
{	 
		$torl=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT o.lastaction, ul.prefixcolor, ul.suffixcolor, ul.level, u.username, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id WHERE u.id>1 AND u.id = ".$rdtt['user_id']);
$iidd=$rdtt['user_id'];			
}
else
{
		$torl=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT o.lastaction, ul.prefixcolor, ul.suffixcolor, ul.level, u.username, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id WHERE u.id>1 AND u.id = ".$rdtt['friend_id']);
$iidd=$rdtt['friend_id'];				
		}	
        $retl=mysqli_fetch_array($torl);

// avatar
        $avatar = ($retl["avatar"] && $retl["avatar"] != "" ? htmlspecialchars($retl["avatar"]) : "");
        if ($avatar=="")
        $av=("<img src='$STYLEURL/images/default_avatar.gif' border='0' width=30 />");
           else
           $av=("<img width=30 src=$avatar>");
// end avatar           
           
// Online User
         (is_null($retl["lastaction"])?$lastseen=$retl["lastconnect"]:$lastseen=$retl["lastaction"]);
        ((time()-$lastseen>900)?$status="<img src='images/offline.gif' border='0' alt='".$language["OFFLINE"]."'>":$status="<img src='images/online.gif' border='0' alt='".$language["ONLINE"]."'>");
// end online users

       $unfriends[$iii]["id"]=$rdtt["id"];
       $unfriends[$iii]["avatar"]=("<center>$av</center>");
       $unfriends[$iii]["name"]=("<a href=index.php?page=userdetails&id=".$iidd.">".unesc($retl["prefixcolor"]).unesc($retl["username"]).unesc($retl["suffixcolor"])."</a>");
       $unfriends[$iii]["level"]=$retl['level'];
       $unfriends[$iii]["acces"]= $rdtt['friend_date'];
       $unfriends[$iii]["status"]=("<center>$status</center>");
       $unfriends[$iii]["pm"] = "<a href=\"index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=$CURUSER[uid]&amp;what=new&amp;to=".urlencode(unesc($retl["username"]))."\">".image_or_link("images/pm.gif","",$language["USERS_PM"])."</a>";
       $unfriends[$iii]["delete"]=("<a href=\"index.php?page=friendlist&do=badd&amp;id=".$unfriends[$iii]["id"]."\" onclick=\"return confirm('".AddSlashes($language["REFRIEND"])."')\">".image_or_link("images/user_accept.png","",$language["DELETE"])."</a>");
       $iii++;
}
}
$friendtpl->set("unfriends",$unfriends);
// mmm , way to big php page , hope no errors 
?>