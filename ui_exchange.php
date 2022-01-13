<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// dec 2013 - user image store addon
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
      
if ($CURUSER["uid"] > 1)
{
$pr=(int)$_GET['pr'];
$img=(int)$_GET['img'];
$uid=$CURUSER["uid"];

$resuser=do_sqlquery("SELECT u.dona,u.donb,u.birt,u.mal,u.fem,u.bann,u.war,u.par,u.bot,u.trmu,u.trmo,u.vimu,u.vimo,u.friend,u.junkie,u.staff ,u.sysop FROM {$TABLE_PREFIX}users u WHERE u.id=".$uid);
$row_user= mysqli_fetch_array($resuser);

if(is_null($pr)||!is_numeric($pr)|| is_null($img)||!is_numeric($img) || $CURUSER["view_torrents"]=="no"){
header("Location: index.php");
}

if ($img == '1' AND $row_user["dona"]=="no")
$ui="dona='yes'";
else if ($img == '1' AND $row_user["dona"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '2' AND $row_user["donb"]=="no")
$ui="donb='yes'";
else if ($img == '2' AND $row_user["donb"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '3' AND $row_user["mal"]=="no")
$ui="mal='yes'";
else if ($img == '3' AND $row_user["mal"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '4' AND $row_user["fem"]=="no")
$ui="fem='yes'";
else if ($img == '4' AND $row_user["fem"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '5' AND $row_user["birt"]=="no")
$ui="birt='yes'";
else if ($img == '5' AND $row_user["birt"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '6' AND $row_user["bot"]=="no")
$ui="bot='yes'";
else if ($img == '6' AND $row_user["bot"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '7' AND $row_user["par"]=="no")
$ui="par='yes'";
else if ($img == '7' AND $row_user["par"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '8' AND $row_user["bann"]=="no")
$ui="bann='yes'";
else if ($img == '8' AND $row_user["bann"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '9' AND $row_user["war"]=="no")
$ui="war='yes'";
else if ($img == '9' AND $row_user["war"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '10' AND $row_user["trmu"]=="no")
$ui="trmu='yes'";
else if ($img == '10' AND $row_user["trmu"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '11' AND $row_user["trmo"]=="no")
$ui="trmo='yes'";
else if ($img == '11' AND $row_user["trmo"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '12' AND $row_user["vimu"]=="no")
$ui="vimu='yes'";
else if ($img == '12' AND $row_user["vimu"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '13' AND $row_user["vimo"]=="no")
$ui="vimo='yes'";
else if ($img == '13' AND $row_user["vimo"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '14' AND $row_user["staff"]=="no")
$ui="staff='yes'";
else if ($img == '14' AND $row_user["staff"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '15' AND $row_user["sysop"]=="no")
$ui="sysop='yes'";
else if ($img == '15' AND $row_user["sysop"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '16' AND $row_user["friend"]=="no")
$ui="friend='yes'";
else if ($img == '16' AND $row_user["friend"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

if ($img == '17' AND $row_user["junkie"]=="no")
$ui="junkie='yes'";
else if ($img == '17' AND $row_user["junkie"]=="yes")
{
stderr("error","You already have this user image ....");
stdfoot();
exit();
}

$u=$CURUSER["seedbonus"];
if($u<$pr) {
header("Location: index.php?page=user_img");
}else {
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET $ui , seedbonus=seedbonus-$pr WHERE id=".$uid);

header("Location: index.php?page=user_img");
}}
else header("Location: index.php");
?>