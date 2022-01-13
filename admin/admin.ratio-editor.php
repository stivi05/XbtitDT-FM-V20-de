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

function get_id_by_name($name)
{

    global $TABLE_PREFIX;

    $id_query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE `username`='$name'") or sql_err(__FILE__, __LINE__);
    $id = mysqli_fetch_array($id_query) or sql_err(__FILE__, __LINE__);
    
    return $id["id"];
}

if($_GET["action"] == 'save')
{
    if(!empty($_POST["username"]) || !empty($_POST["bytes"]) || !empty($_POST["what"]) || !empty($_POST["uploaded"]) || !empty($_POST["downloaded"]))
    {
        $username = $_POST["username"];
        if($_POST["bytes"]=='1')
            {
            $uploaded = $_POST["uploaded"];
            $downloaded = $_POST["downloaded"];
            }
        elseif($_POST["bytes"]=='2')
            {
            $uploaded = $_POST["uploaded"]*1024;
            $downloaded = $_POST["downloaded"]*1024;
            }
        elseif($_POST["bytes"]=='3')
            {
            $uploaded = $_POST["uploaded"]*1024*1024;
            $downloaded = $_POST["downloaded"]*1024*1024;
            }
        elseif($_POST["bytes"]=='4')
            {
            $uploaded = $_POST["uploaded"]*1024*1024*1024;
            $downloaded = $_POST["downloaded"]*1024*1024*1024;
            }
        elseif($_POST["bytes"]=='5')
            {
            $uploaded = $_POST["uploaded"]*1024*1024*1024*1024;
            $downloaded = $_POST["downloaded"]*1024*1024*1024*1024;
            }
        
        if($_POST["what"] =='1')
            {
            $result = do_sqlquery("SELECT `uploaded`, `downloaded` FROM `{$TABLE_PREFIX}users` WHERE `id` = ".get_id_by_name($username)."", true) or sqlerr(__FILE__, __LINE__);
            $arr = mysqli_fetch_assoc($result);
            $uploaded = $arr["uploaded"]+$uploaded;
            $downloaded = $arr["downloaded"]+$downloaded;
            do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded` = $uploaded, `downloaded` = $downloaded WHERE `id` = ".get_id_by_name($username)."", true) or sqlerr(__FILE__, __LINE__);
            }
        elseif($_POST["what"] =='2')
            {
            $result = do_sqlquery("SELECT `uploaded`, `downloaded` FROM `{$TABLE_PREFIX}users` WHERE `id` = ".get_id_by_name($username)."", true) or sqlerr(__FILE__, __LINE__);
            $arr = mysqli_fetch_assoc($result);
            $uploaded = $arr["uploaded"]-$uploaded;
            $downloaded = $arr["downloaded"]-$downloaded;
            do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded` = $uploaded, `downloaded` = $downloaded WHERE `id` = ".get_id_by_name($username)."", true) or sqlerr(__FILE__, __LINE__);
            }
        elseif($_POST["what"] =='3')
            {
            do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded` = $uploaded, `downloaded` = $downloaded WHERE `id` = ".get_id_by_name($username)."", true) or sqlerr(__FILE__, __LINE__);
            }
        redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=ratio-editor&updated=yes");
    } else {
        stderr($language["ERROR"],$language["ALL_FIELDS_REQUIRED"]);
    }
}
else
{
    $admintpl->set("updated", $_GET["updated"]=="yes", true);
    $admintpl->set("language",$language);
    $admintpl->set("frm_action","index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=ratio-editor&amp;action=save");
}

?>