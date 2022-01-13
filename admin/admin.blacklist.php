<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    Proxy Blacklist by DiemThuy ( nov 2009 )
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


if (isset($_GET["action"]))
$action = $_GET["action"];
else
$action = "";

if ($action=="delete")
{
        if ($_GET['ip']=="")
        err_msg(ERROR,INVALID_ID);

        $id = max(0,$_GET['ip']);
        do_sqlquery("DELETE FROM {$TABLE_PREFIX}blacklist WHERE id=".$id,true);
}
if ($action=="add")
{
            $tip = $_POST["tip"];
            $stip = sprintf("%u", ip2long($tip));
            $added = sqlesc(time());
            do_sqlquery("INSERT INTO {$TABLE_PREFIX}blacklist (added, tip) VALUES($added,$stip)",true);
}

        $blacklist=array();
        $getbanned = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}blacklist ORDER BY added DESC",true);
        $rowsbanned = @mysqli_num_rows($getbanned);
        $admintpl->set("frm_action","index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=blacklist&amp;action=add");
        $i=0;
        if ($rowsbanned>0)
        {
           $admintpl->set("no_records",false,true);

           while ($arr=mysqli_fetch_assoc($getbanned))
              {
              $blacklist[$i]["tip"] = long2ip($arr["tip"]);
              $blacklist[$i]["date"] = get_date_time($arr['added']);
              $blacklist[$i]["remove"] = "<a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=blacklist&amp;action=delete&amp;ip=$arr[id]\" onclick=\"return confirm('". str_replace("'","\'",$language["DELETE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a>";
              $i++;
           }

        }
        else

        $admintpl->set("no_records",true,true);
        $admintpl->set("blacklist",$blacklist);
        $admintpl->set("language",$language);
        $admintpl->set("url","<a href=\"http://www.proxy4free.com\">Proxy4all</a>");

?>
