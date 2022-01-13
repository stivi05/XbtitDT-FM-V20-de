<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT fM.
//
//    Proxy Detector by DiemThuy ( nov 2009 )
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
require_once("include/config.php");

dbconn();


$action = $_GET["action"];

if($action =="change")
{

	{
        $ms = $_GET["id"];
        $user = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT allowdownload FROM {$TABLE_PREFIX}users WHERE id =".$ms);
        $ar=mysqli_fetch_assoc($user);

        if ($ar["allowdownload"]=='yes')
        {
        @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET allowdownload = 'no' WHERE id =".$ms);
        $subj=sqlesc("Proxy Detected !");
        $msg=sqlesc("Please explain why you use a proxy , for the time beeing you have no download rights");
        send_pm(2,$ms,$subj,$msg);
		}
        else
        {
        @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET allowdownload = 'yes' WHERE id =".$ms);
        $subj=sqlesc("Proxy Agreed !");
        $msg=sqlesc("We accept the reason you use a proxy , you can download again");
        send_pm(2,$ms,$subj,$msg);
        }
    }
	redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=proxy");
	exit();
}


$proxy = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE proxy = 'yes'") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row= @mysqli_num_rows($proxy);

    $log=array();
    $i=0;

$admintpl->set("language",$language);

         if (mysqli_num_rows($proxy)==0)
{
    $log[$i]["username"]=("<center><font color=green>nobody</font></center>");
    $log[$i]["email"]=("<center><font color=red>nobody</font></center>");
    $log[$i]["last"]=("<center><font color=green>nobody</font></center>");
    $log[$i]["allow"]=("<center><font color=red>nobody</font></center>");
    $log[$i]["change"]=("<center><font color=green>nobody</font></center>");

    $i++;
}
         else
             {
                 while ($arr=mysqli_fetch_assoc($proxy))
                 {
               $r3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level,prefixcolor,suffixcolor FROM {$TABLE_PREFIX}users_level WHERE id=$arr[id_level]") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
               $a3 = mysqli_fetch_assoc($r3);

        $log[$i]["username"]="<a href=index.php?page=userdetails&id=".$arr["id"].">".$a3["prefixcolor"].$arr['username'].$a3["suffixcolor"]."</a>";
        $log[$i]["email"]=$arr['email'];
        $log[$i]["last"]=$arr['lastconnect'];
        $log[$i]["allow"]=$arr['allowdownload'];
        $log[$i]["change"]="<center><a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=proxy&amp;action=change&amp;id=".$arr["id"]."\" onclick=\"return confirm('".AddSlashes($language["CHANGE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/change.gif","",$language["CHANGED"])."</center></a>";
        $i++;

}
}
$admintpl->set("proxy",$log);
?>