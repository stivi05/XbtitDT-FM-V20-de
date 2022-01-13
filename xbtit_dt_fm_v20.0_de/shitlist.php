<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// ShitList by DiemThuy - May 2009
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
      
      if ($CURUSER["id_level"]<6)
{
	redirect("index.php?page=users"); // redirects to users.php if no staff
	exit();
}
         global $CURUSER, $STYLEPATH, $CURRENTPATH, $TABLE_PREFIX, $XBTT_USE, $btit_settings;

         if ($XBTT_USE)
            {
             $udownloaded="u.downloaded+IFNULL(x.downloaded,0)";
             $uuploaded="u.uploaded+IFNULL(x.uploaded,0)";
             $utables="{$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id";
            }
         else
             {
             $udownloaded="u.downloaded";
             $uuploaded="u.uploaded";
             $utables="{$TABLE_PREFIX}users u";
             }
             
$shittpl= new bTemplate();
$shittpl-> set("language",$language);
require_once("include/functions.php");

dbconn();

$do = $_GET["do"];
$shit_id = $_GET["shit_id"];

// Add member to shitlist

if ($do=="add")
{
	if (!isset($shit_id))
	{
		redirect("index.php?page=users"); // redirects to users.php if shit_id not set
		exit();
	}

    $hmm=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}shitlist WHERE shit_id = '$shit_id' ");
	if (mysqli_num_rows($hmm))
	{
		stderr("Error","This member is allready added to the Shitlist!");
        stdfoot();
		die();
	}
	$qry = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE id = '$shit_id'");
	$res = mysqli_fetch_array($qry);
	$chk = mysqli_num_rows($qry);
	if (!$chk)
	{
		redirect("index.php?page=users"); // redirects to users.php if shit_id not in database
		exit();
	}
	mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}shitlist (user_id, shit_id, shit_name) VALUES ('".$CURUSER["uid"]."', '".$shit_id."', '".$res["username"]."')");

// pm system

if ($btit_settings["pm_shit"]==true)
{
	send_pm(0,$shit_id,sqlesc('You Are Shit Listed !'), sqlesc($btit_settings["pm_tekst"]."\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}

// demote / promote system

if ($btit_settings["demote"]==true)
{
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET id_level=".$btit_settings["shit_group"]." WHERE id=".$shit_id);
}

	information_msg("Shitlisted","This member is added to the Shitlist!");
    redirect("index.php?page=shitlist");
	exit();
}

// Delete shitlisted member

elseif ($do=="del")
{
{

        $msg = $_GET["id"];
        $qrys=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}shitlist WHERE id=\"$msg\"");
    	$couns=mysqli_fetch_array($qrys);
if ($btit_settings["pm_shit"]==true)
{
	send_pm(0,$couns["shit_id"],sqlesc('You Are No Longer Shit Listed !'), sqlesc($btit_settings["pms_tekst"]."\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}
// demote / promote system

if ($btit_settings["demote"]==true)
{
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET id_level=".$btit_settings["shit_group_back"]." WHERE id=".$couns["shit_id"]);
}
		@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}shitlist WHERE id=\"$msg\"");
}
	redirect("index.php?page=shitlist");
	exit();
}
// Main shitlist page

else
{

	$qry=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}shitlist");
	$coun=mysqli_num_rows($qry);

	if ($coun)

         $shit=array();
         $i=0;
	while ($res=mysqli_fetch_array($qry))
	{
		$tor=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT u.id,u.cip,u.warn,u.warns,$udownloaded as downloaded , $uuploaded as uploaded, IF($udownloaded>0,$uuploaded/$udownloaded,0) as ratio, ul.prefixcolor, ul.suffixcolor, ul.level, u.username, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect,UNIX_TIMESTAMP(u.joined) AS joined FROM $utables LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id WHERE u.id>1 AND u.id = ".$res['shit_id']);
        $ret=mysqli_fetch_array($tor);
		$tort=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT u.id,ul.prefixcolor, ul.suffixcolor, ul.level, u.username FROM $utables LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id WHERE u.id>1 AND u.id = ".$res['user_id']);
        $rett=mysqli_fetch_array($tort);
           
//user ratio

if (intval($ret["downloaded"])>0)
  $ratio=number_format($ret["uploaded"]/$ret["downloaded"],2);
else
  $ratio='&#8734;';
  
$diff=$ret["uploaded"]-$ret["downloaded"];
  
       $shit[$i]["id"]=$res["id"];
       $shit[$i]["name"]=("<a href=index.php?page=userdetails&id=".$res["shit_id"].">".unesc($ret["prefixcolor"]).unesc($ret["username"]).unesc($ret["suffixcolor"])."</a>");
       $shit[$i]["by"]=("<a href=index.php?page=userdetails&id=".$res["user_id"].">".unesc($rett["prefixcolor"]).unesc($rett["username"]).unesc($rett["suffixcolor"])."</a>");
       $shit[$i]["level"]=$ret['level'];
       $shit[$i]["join"]= date("d/m/y h:i:s",$ret['joined']);
       $shit[$i]["acces"]= date("d/m/y h:i:s",$ret['lastconnect']);
       $shit[$i]["ip"]= ($ret['cip']."&nbsp;&nbsp;&nbsp;<a href=index.php?page=iplog&id=".$ret["id"]."><img src=images/icon_ip.gif border=0></a>");
       $shit[$i]["download"]=(makesize($ret["downloaded"]));
       $shit[$i]["upload"]=(makesize($ret["uploaded"]));
       $shit[$i]["diff"]=(makesize($diff));
       $shit[$i]["ratio"]=$ratio;
       $shit[$i]["warned"]=$ret["warn"];
       $shit[$i]["warns"]=$ret["warns"];
       $shit[$i]["delete"]=("<center><a href=\"index.php?page=shitlist&do=del&amp;id=".$shit[$i]["id"]."\" onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a></center>");
       $i++;
}
}
	$shittpl->set("shit",$shit);

?>