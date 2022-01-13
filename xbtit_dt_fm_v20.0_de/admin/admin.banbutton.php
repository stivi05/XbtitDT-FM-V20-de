<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Ban Button by Petr1fied and DiemThuy  - oct 2009
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

if (isset($_GET["action"]))
$action = $_GET["action"];
else
$action = "";

if ($action == "delete")
{
        $id = $_GET["id"];
        do_sqlquery("DELETE FROM {$TABLE_PREFIX}signup_ip_block WHERE id=".$id,true);
}

$getbanned = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}signup_ip_block ORDER BY added ASC") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row= @mysqli_num_rows($getbanned);

    $log=array();
    $i=0;

$admintpl->set("language",$language);
$admintpl->set("bandays",$btit_settings["bandays"]);

         if (mysqli_num_rows($getbanned)==0)
{
    $banbutton[$i]["FIP"]=("<center><b><font color=green>there</font></b></center>");
    $banbutton[$i]["LIP"]=("<center><b><font color=green>are</font></b></center>");
    $banbutton[$i]["added"]=("<center><b><font color=green>no</font></b></center>");
    $banbutton[$i]["to"]=("<center><b><font color=green>banned</font></b></center>");
    $banbutton[$i]["by"]=("<center><b><font color=green>IP,s</font></b></center>");
    $banbutton[$i]["com"]=("<center><b><font color=green>yet</font></b></center>");
    $banbutton[$i]["remove"]=("<center><b><font color=green>here</font></b></center>");
    $i++;
}
         else
             {
                 while ($arr=mysqli_fetch_assoc($getbanned))
                 {

               $ip_f = long2ip($arr["first_ip"]);
               $ip_l = long2ip($arr["last_ip"]);
               $days = ($btit_settings["bandays"] * 86400);
               $to= ($arr['added'] + $days);

        $banbutton[$i]["id"]=$arr["id"];
        $banbutton[$i]["FIP"]=$ip_f;
        $banbutton[$i]["LIP"]=$ip_l;
        $banbutton[$i]["added"]=get_date_time($arr['added']);
        $banbutton[$i]["to"]=get_date_time($to);
        $banbutton[$i]["by"]=$arr['addedby'];
        $banbutton[$i]["com"]=$arr['comment'];
        $banbutton[$i]["remove"] = "<a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=banbutton&amp;action=delete&amp;id=".$arr["id"]."\" onclick=\"return confirm('". str_replace("'","\'",$language["DELETE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a>";
        $i++;
}
}
$admintpl->set("banbutton",$banbutton);
?>