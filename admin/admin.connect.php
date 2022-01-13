<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    None conectable users List by DiemThuy ( NOV 2009 )
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

$admintpl->set("language",$language);

if (isset($_GET["action"]))
$action = $_GET["action"];
else
$action = "";

if ($action == "pm")
{
        $id = $_GET["id"];
        $mesg="After a system check , we found out you are [color=red]NOT connectable ( NAT )[/color]\n\n that is nor good for our community and it is not good for yourself , speeds will be low ! \n\n for more info read this [url]http://www.portforward.com[/url] and fix this problem ! \n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]";
        send_pm(0,$id,sqlesc('Warning , you are NOT connectable !!'),sqlesc($mesg));
}


               $r2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE connectable='no'") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
               $connect=array();
               $i=0;
if ($r2)
{
while ($arr=mysqli_fetch_assoc($r2))
{
$res4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor , suffixcolor  FROM {$TABLE_PREFIX}users_level WHERE id ='$arr[id_level]'");
$arr4 = mysqli_fetch_assoc($res4);
$name = $arr4[prefixcolor].$arr[username].$arr4[sufixcolor];
        $connect[$i]["Username"]="<a href=index.php?page=userdetails&id=" . $arr["id"] . ">" . $name . "</a>";
        $connect[$i]["IP"]=$arr['joined'];
        $connect[$i]["Failed"]=$arr['lastconnect'];

        $connect[$i]["pm"]=("<a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=connect&amp;action=pm&amp;id=".$arr["id"]."\" onclick=\"return confirm('Are you shure you want to pm this user ?')\">".image_or_link("$STYLEPATH/images/pm.png","",$language["USERS_PM"])."</a>");
        $i++;

}
}
$admintpl->set("connect",$connect);

?>