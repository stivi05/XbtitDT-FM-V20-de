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

if (!defined("IN_BTIT"))
    die("non direct access!");

if (!defined("IN_ACP"))
    die("non direct access!");


global $STYLEURL;

require(load_language("lang_teams.php"));

if (!$CURUSER || $CURUSER["edit_users"]!="yes"){
	error_msg("Error","Sorry you do not have the rights to access this page!");
}


foreach($_POST as $key=>$value) $$key=$value;
foreach($_GET as $key=>$value) $$key=$value;

$sure = $_GET['sure'];
$del = $_GET['del'];
$team = htmlspecialchars($_GET['team']);
$edited = (int)$_GET['edited'];
$id = (int)$_GET['id'];
$team_name = $_GET['team_name'];
$team_info = $_GET['team_info'];
$team_image = $_GET['team_image'];
$team_description = $_GET['team_description'];
$teamownername = $_GET['team_owner'];
$editid = $_GET['editid'];
$editmembers = $_GET['editmembers'];
$name = $_GET['name'];
$image = $_GET['image'];
$owner = $_GET['owner'];
$info = $_GET['info'];
$add = $_GET['add'];


//Delete Team
if($sure == "yes") {
	
	$query = "UPDATE {$TABLE_PREFIX}users SET team=0 WHERE team=" .sqlesc($del) . "";
	$sql = mysqli_query($GLOBALS["___mysqli_ston"], $query);

	$query = "DELETE FROM {$TABLE_PREFIX}teams WHERE id=" .sqlesc($del) . " LIMIT 1";
	$sql = mysqli_query($GLOBALS["___mysqli_ston"], $query);
        write_log("has deleted team id:$del","delete");
	success_msg("Success","Team Successfully Deleted!&nbsp;[<a href='index.php?page=admin&user=$CURUSER[uid]&code=$CURUSER[random]&do=teams'>Back</a>]");
	stdfoot();
	exit();
}

if($del > 0) {
	stderr("Confirm","<b>Are you sure you wish to delete the team? ($team) ( <b><a href='index.php?page=admin&user=$CURUSER[uid]&code=$CURUSER[random]&do=teams&del=$del&team=$team&sure=yes'>Yes!</a></b> / <b><a href='index.php?page=admin&user=$CURUSER[uid]&code=$CURUSER[random]&do=teams'>No!</a></b> )");
	stdfoot();
	exit();
	
}
//$admintpl->set("sure",$sure);
//Edit Team
if($edited == 1) {
	$aa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}users WHERE username='$teamownername'");
	$ar = mysqli_fetch_assoc($aa);
	$team_owner = $ar["id"];
	$query = "UPDATE {$TABLE_PREFIX}teams SET	name = '$team_name', info = '$team_info', owner = '$team_owner', image = '$team_image' WHERE id=".sqlesc($id);
	$sql = mysqli_query($GLOBALS["___mysqli_ston"], $query);

	mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET team = '$id' WHERE id= '$team_owner'");

	if($sql) {
		success_msg("Success","Updated Team!<br><a href=\"index.php?page=admin&user=$CURUSER[uid]&code=$CURUSER[random]&do=teams\">Back</a>");
		write_log("has edited team ($team_name)","edit");
		stdfoot();
                exit();
	}
}
$edity=textbbcode("smolf3d1","team_info",$info);
if($editid > 0) {
	$editt="<form name='smolf3d1' method='get' action='index.php'>
	<CENTER><table cellspacing=0 cellpadding=5 width=50%>
	<div align='center'><input type='hidden' name='edited' value='1'></div>
	<br>
         <input type='hidden' name='page' value='admin'>
         <input type='hidden' name='user' value='$CURUSER[uid]'>
         <input type='hidden' name='code' value='$CURUSER[random]'>
         <input type='hidden' name='do' value='teams'>
         <input type='hidden' name='id' value='$editid'><table class=main cellspacing=0 cellpadding=5 width=50%><tr>
         <td class=header colspan=2 align=center>".$language['TEAM_EDIT']."</td></tr>
	<tr><td class=header>".$language['TEAM_NAME']."</td><td align='right' class=lista><input type='text' size=50 name='team_name' value='$name'></td></tr>
	<tr><td class=header>".$language['TEAM_LOGO']."</td><td align='right' class=lista><input type='text' size=50 name='team_image' value='$image'></td></tr>
	<tr><td class=header>".$language['TEAM_OWNER']."</td><td align='right' class=lista><input type='text' size=50 name='team_owner' value='$owner'>".$language['TEAM_ONE']."</td></tr>
	<tr><td valign=top class=header>".$language['TEAM_DESC']."</td><td align='right' class=lista>$edity</td></tr>
	<tr><td class=header colspan=2><div align='center'><input type='Submit' value=Update></div></td></tr>
	</table></CENTER></form><br><br><hr><br><br>";

	
}
$admintpl->set("edit",$editt);



//Add Team
if($add == 'true') {
        
        $ping=do_sqlquery("select * from {$TABLE_PREFIX}teams order by name");
        while($pong=mysqli_fetch_array($ping)){
        
        if($pong["name"]==$team_name){
        stderr("Error","Team already exists!");
        exit();
}
        }
$pname=do_sqlquery("select * from {$TABLE_PREFIX}teams t left join {$TABLE_PREFIX}users u on u.id=t.owner order by u.username");
        while($pnames=mysqli_fetch_array($pname)){
          if($pnames["username"]==$team_owner){
        stderr("Error","Owner already exists!");
        exit();
}
        }
// check image extension if someone has a better idea ;)
           if ($team_image && $team_image!="" && !in_array(substr($team_image,strlen($team_image)-4),array(".gif",".jpg",".bmp",".png",".ico")))
              {
                stderr($language["ERROR"],"Not an Image.");
                stdfoot();
                exit;
              }
	$aa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}users WHERE username='$teamownername'");
	$ar = mysqli_fetch_assoc($aa);
	$team_owner = $ar["id"];
	$query = "INSERT INTO {$TABLE_PREFIX}teams SET	name = '$team_name', owner = '$team_owner' ,info = '$team_description', image = '$team_image'";
	$sql = mysqli_query($GLOBALS["___mysqli_ston"], $query);

	$tid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

	mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET team = '$tid' WHERE id= '$team_owner'");

	if($sql) {
		write_log("has created new team ($team_name)","edit");
		$success = TRUE;
	}else{
		$success = FALSE;
}	
}
$teamtpl=new bTemplate();

$desc=textbbcode("smolf3d","team_description");

$addt="<br>
".$language['TEAM_HEADER']."
<form name='smolf3d' method='get' action='index.php'>
<CENTER><table cellspacing=0 cellpadding=5 width=50%>
<input type='hidden' name='page' value='admin'>
<input type='hidden' name='user' value='$CURUSER[uid]'>
<input type='hidden' name='code' value='$CURUSER[random]'>
<input type='hidden' name='do' value='teams'>
<tr><td class=header colspan=2 align=center>".$language['TEAM_ADD']."</td></tr><tr>
<tr><td class=header>".$language['TEAM_NAME']."</td><td align='left' class=lista><input type='text' size=50 name='team_name'></td></tr>
<tr><td class=header>".$language['TEAM_OWNER']."</td><td align='left' class=lista><input type='text' size=50 name='team_owner'>".$language['TEAM_ONE']."</td></tr>
<tr><td class=header>".$language['TEAM_DESC']."</td><td class=lista align=center valign=top><center>$desc</center></td></tr>

<tr><td class=header>".$language['TEAM_LOGO']."</td><td align='left' class=lista><input type='text' size=50 name='team_image'><input type='hidden' name='add' value='true'></td></tr>
<tr><td class=header colspan=2><div align='center'><input class=btn value='Add Team' type='Submit'></div></td></tr>
</table></CENTER>";
$admintpl->set("add_team",$addt);
if($success == TRUE) {
	$successadd="<br><h2>Team successfully added!</h2>";
}
$admintpl->set("success",$successadd);
$close="<br>
</form>";

$admintpl->set("close",$close);

//ELSE Display Teams
$current="
<table class=main cellspacing=0 cellpadding=3 width=50%><tr><td class=header align=center colspan=6>".$language['TEAM_CURR']."</td></tr><tr>
<td class=header style=\"text-align:center\">".$language['TEAM_ID_H']."</td><td class=header style=\"text-align:center\">".$language['TEAM_LOGO_H']."</td><td class=header style=\"text-align:center\">".$language['TEAM_NAME_H']."</td><td class=header style=\"text-align:center\">".$language['TEAM_OWNER_H']."</td><td class=header style=\"text-align:center\">".$language['TEAM_DESC_H']."</td><td class=header style=\"text-align:center\">".$language['TEAM_EDIT_H']."</td>";
$admintpl->set("current",$current);


 $teamsres=do_sqlquery("SELECT COUNT(*) from {$TABLE_PREFIX}teams where id>0 ORDER BY id ASC $limit");
    $teamnum=mysqli_fetch_row($teamsres);
    $num2=$teamnum[0];
    $perpage=(max(0,$CURUSER["torrentsperpage"])>0?$CURUSER["torrentsperpage"]:10);
    list($pagertop, $pagerbottom, $limit) = pager($perpage, $num2, "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=teams&amp;");
    
    
    $admintpl->set("pagertop",$pagertop);
    $admintpl->set("pagerbottom",$pagerbottom);


$teamres=do_sqlquery("SELECT id, name, image, owner, info from {$TABLE_PREFIX}teams where id>0 ORDER BY id ASC $limit");

    $teams=array();
    $i=0;

while ($row = mysqli_fetch_array($teamres)) {
	
        $teams[$i][id] = (int)$row['id'];
	$teams[$i][name] = htmlspecialchars($row['name']);
	$teams[$i][image] = htmlspecialchars($row['image']);
	$teams[$i][owner] = (int)$row['owner'];
	$teams[$i][info] = format_comment($row['info']);
        $owner = (int)$row['owner'];
	$OWNERNAME1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username, ul.prefixcolor, ul.suffixcolor FROM {$TABLE_PREFIX}users u left join {$TABLE_PREFIX}users_level ul on u.id_level=ul.id WHERE u.id=$owner");
        $OWNERNAME2 = mysqli_fetch_array($OWNERNAME1);
	$teams[$i][OWNERNAME] = stripslashes($OWNERNAME2[prefixcolor]) .$OWNERNAME2['username'].stripslashes($OWNERNAME2[suffixcolor]);
        $OWNERNAME = $OWNERNAME2['username'];
        $id = (int)$row['id'];
	$name = htmlspecialchars($row['name']);
	$image = htmlspecialchars($row['image']);
	
	$info = htmlspecialchars($row['info']);
        $teams[$i][delb]="<a href='index.php?page=admin&user=$CURUSER[uid]&code=$CURUSER[random]&do=teams&del=$id&team=$name'><img src=$STYLEURL/images/delete.png border=0></a>";
$teams[$i][edbj]="<a href='index.php?page=admin&user=$CURUSER[uid]&code=$CURUSER[random]&do=teams&editid=$id&name=$name&image=$image&info=$info&owner=$OWNERNAME'><img src=$STYLEURL/images/edit.png border=0></a>";


$i++;

}
$admintpl->set("teams",$teams);
$end="</table><br>";
$admintpl->set("end",$end);

?>