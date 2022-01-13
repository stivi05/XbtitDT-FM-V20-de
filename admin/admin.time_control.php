<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Xbtiteam
//
//    This file is part of xbtit DT FM.
//
// Timed Rank Staff Control by DiemThuy - Nov 2010
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
      

$action = $_GET['action'];


// Undo
if($action =="undo")
{

	{
	    $ms = (int)$_GET["or"];
        $msg = (int)$_GET["id"];
		@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET rank_switch='no' , id_level = \"$ms\" WHERE id=\"$msg\"");
		@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}t_rank SET undone = 'yes' WHERE userid=\"$msg\"");
		
	}
	redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=time_control");
	exit();
}
//Here we will select the data from the database
$res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT u.id_level, u.username, r.userid, r.old_rank, r.new_rank, r.byt , r.date, r.enddate, r.undone FROM {$TABLE_PREFIX}t_rank r INNER JOIN {$TABLE_PREFIX}users u ON r.userid=u.id ORDER by r.date desc ") or sqlerr();

    $hit=array();
    $i=0;

while($row1=mysqli_fetch_array($res))
{
$ress=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users_level WHERE id_level= ".$row1[id_level]) or sqlerr();
$row2=mysqli_fetch_array($ress);

$resi=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username,id_level FROM {$TABLE_PREFIX}users WHERE id= ".$row1[byt]) or sqlerr();
$row6=mysqli_fetch_array($resi);

$rest=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users_level WHERE id_level= ".$row6[id_level]) or sqlerr();
$row3=mysqli_fetch_array($rest);

$resu=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users_level WHERE id = ".$row1[old_rank]) or sqlerr();
$row4=mysqli_fetch_array($resu);

$resw=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users_level WHERE id = ".$row1[new_rank]) or sqlerr();
$row5=mysqli_fetch_array($resw);

    $hit[$i]["user"]=("<center><a href=\"index.php?page=userdetails&id=".$row1[userid]."\">".$row2[prefixcolor].$row1[username].$row2[suffixcolor]."</a></center>");
    $hit[$i]["by"]=("<center><a href=\"index.php?page=userdetails&id=".$row1[byt]."\">".$row3[prefixcolor].$row6[username].$row3[suffixcolor]."</a></center>");
    $hit[$i]["old"]=("<center>".$row4[prefixcolor].$row4[level].$row4[suffixcolor]."</center>");
    $hit[$i]["new"]=("<center>".$row5[prefixcolor].$row5[level].$row5[suffixcolor]."</center>");
    $hit[$i]["date"]=("<center>".$row1[date]."</center>");
    $hit[$i]["exp"]=("<center>".$row1[enddate]."</center>");
if ($row1["undone"]==no)
    $hit[$i]["undo"]="<center><a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=time_control&amp;action=undo&amp;id=".$row1[userid]."&amp;or=".$row1[old_rank]."\" onclick=\"return confirm('".AddSlashes($language["MO"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["MA"])."</center></a>";
    else
    $hit[$i]["undo"]=("<center><font color='red'>undone</font></center>");
    
    $i++;

}
$admintpl->set("T_EXP",$language["T_EXP"]);
$admintpl->set("sc",$language["TC"]);
$admintpl->set("user",$language["AUSER"]);
$admintpl->set("oldr",$language["OL"]);
$admintpl->set("newr",$language["NE"]);
$admintpl->set("aby",$language["BY"]);
$admintpl->set("when",$language["DA"]);
$admintpl->set("undo",$language["MA"]);
$admintpl->set("hit",$hit);
?>