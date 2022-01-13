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
   if(!empty($_POST["all"]) AND (!empty($_POST["username"]) OR $_POST["all"] =='1') AND !empty($_POST["what"]) AND !empty($_POST["sb"]) )
    {
        $username = $_POST["username"];
        $sb= $_POST["sb"];
        
        if($_POST["what"] =='1' AND $_POST["all"] =='2')
            {
            $result = do_sqlquery("SELECT `seedbonus` FROM `{$TABLE_PREFIX}users` WHERE `id` = ".get_id_by_name($username)."", true) or sqlerr(__FILE__, __LINE__);
            $arr = mysqli_fetch_assoc($result);
            $sbb = $arr["seedbonus"]+$sb;
            
            do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus` = $sbb WHERE `id` = ".get_id_by_name($username)."", true) or sqlerr(__FILE__, __LINE__);
            }
//all        
        elseif($_POST["what"] =='1' AND $_POST["all"] =='1')
            {
            $result = do_sqlquery("SELECT `id` , `seedbonus`  FROM `{$TABLE_PREFIX}users` WHERE `id_level` >2 ", true) or sqlerr(__FILE__, __LINE__);

          
            while ($arrdt=mysqli_fetch_assoc($result))
            {
            $sbb = $arrdt["seedbonus"]+$sb;
            do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus` = $sbb WHERE `id` = ".$arrdt["id"] , true) or sqlerr(__FILE__, __LINE__);
            }
            }
//all          
        elseif($_POST["what"] =='2' AND $_POST["all"] =='2')
            {
            $result = do_sqlquery("SELECT `seedbonus`  FROM `{$TABLE_PREFIX}users` WHERE `id` = ".get_id_by_name($username)."", true) or sqlerr(__FILE__, __LINE__);
            $arr = mysqli_fetch_assoc($result);
            $sbb = $arr["seedbonus"]-$sb;
            
            do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus` = $sbb WHERE `id` = ".get_id_by_name($username)."", true) or sqlerr(__FILE__, __LINE__);
            }
//all        
        elseif($_POST["what"] =='2' AND $_POST["all"] =='1')
            {
            $result = do_sqlquery("SELECT `id` , `seedbonus`  FROM `{$TABLE_PREFIX}users` WHERE `id_level` >2 ", true) or sqlerr(__FILE__, __LINE__);

          
            while ($arrdt=mysqli_fetch_assoc($result))
            {
            $sbb = $arrdt["seedbonus"]-$sb;
            do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus` = $sbb WHERE `id` = ".$arrdt["id"] , true) or sqlerr(__FILE__, __LINE__);
            }
            }
//all          
        elseif($_POST["what"] =='3' AND $_POST["all"] =='2')
            {
            do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus` = $sb WHERE `id` = ".get_id_by_name($username)."", true) or sqlerr(__FILE__, __LINE__);
            }
//all        
        elseif($_POST["what"] =='3' AND $_POST["all"] =='1')
            {
            $result = do_sqlquery("SELECT `id` , `seedbonus`  FROM `{$TABLE_PREFIX}users` WHERE `id_level` >2 ", true) or sqlerr(__FILE__, __LINE__);

          
            while ($arrdt=mysqli_fetch_assoc($result))
            {
            do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus` = $sb WHERE `id` = ".$arrdt["id"] , true) or sqlerr(__FILE__, __LINE__);
            }
            }
//all           
        redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=sb-editor&updated=yes");
    } else {
        stderr($language["ERROR"],$language["ALL_FIELDS_REQUIRED"]);
    }
}
else
{
    $admintpl->set("updated", $_GET["updated"]=="yes", true);
    $admintpl->set("language",$language);
    $admintpl->set("frm_action","index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=sb-editor&amp;action=save");
}

?>