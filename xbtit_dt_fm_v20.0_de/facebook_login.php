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
require 'include/facebook.php';

global $TABLE_PREFIX, $BASEURL, $language, $btit_settings;

$app_id = APP_ID;
$app_secret = APP_SECRET;
$my_url = $BASEURL."/index.php?page=facebooklogin";
$url="index.php";
$error = $_REQUEST["error"];
if(!empty($error))
{
    redirect($url);
    die();
}

$code = $_REQUEST["code"];

if(empty($code))
{
    $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
                   . $app_id . "&redirect_uri=" . urlencode($my_url)."&scope=email";

    echo("<script> top.location.href='" . $dialog_url . "'</script>");
    die();
}

$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
              . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret="
              . $app_secret . "&code=" . $code;

$access_token = file_get_contents($token_url);

$graph_url = "https://graph.facebook.com/me?" . $access_token;

$user = json_decode(file_get_contents($graph_url));
if ($user->email != "")
{
    dbconn();
     
$email=mysqli_real_escape_string($DBDT,$user->email);
     
    $regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
              ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
              ."\.([a-z]{2,}){1}$/i";
                
    if(!preg_match($regex,$email))
    {
        stderr($language["SORRY"],"E-mail is not valid");
        exit;
    }
    if($btit_settings["fbadmin"])
    {
        $res2 = do_sqlquery("SELECT `ul`.`admin_access` FROM `{$TABLE_PREFIX}users` `u` INNER JOIN `{$TABLE_PREFIX}users_level` `ul` ON `u`.`id_level`=`ul`.`id` WHERE `u`.`email` ='".$email."'", true);
    
        $row2 = mysqli_fetch_assoc($res2);
        if ($row2["admin_access"]=="yes") 
        {
            stderr($language["SORRY"],"I'm sorry Staff are not allowed to log in this way");
            exit;
        }
    }
    $res = do_sqlquery("SELECT `u`.`salt`, `u`.`pass_type`, `u`.`username`, `u`.`id`, `u`.`random`, `u`.`password`".((substr($FORUMLINK,0,3)=="smf") ? ", `u`.`smf_fid`, `s`.`passwd`":(($FORUMLINK=="ipb")?", `u`.`ipb_fid`, `i`.`members_pass_hash`, `i`.`members_pass_salt`, `i`.`name`, `i`.`member_group_id`":""))." FROM `{$TABLE_PREFIX}users` `u` ".((substr($FORUMLINK,0,3)=="smf") ? "LEFT JOIN `{$db_prefix}members` `s` ON `u`.`smf_fid`=`s`.".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")."":(($FORUMLINK=="ipb")?"LEFT JOIN `{$ipb_prefix}members` `i` ON `u`.`ipb_fid`=`i`.`member_id`":""))." WHERE `u`.`email` ='".$email."'",true);
    $row = mysqli_fetch_assoc($res);
     
    if(!$row)
    {
		stderr($language["SORRY"],"You can not log in, your e-mail used with Facebook does not correspond with the e-mail you used here");
        exit;
	}
    else
    {
        logoutcookie();
        logincookie($row, $row["username"]);
        if(substr($FORUMLINK,0,3)=="smf" && $email==$row["emailAddress"])
            set_smf_cookie($row["smf_fid"], $row["passwd"], $row["passwordSalt"]);
        elseif($FORUMLINK=="ipb")
            set_ipb_cookie($row["ipb_fid"], $row["name"], $row["member_group_id"]);
        redirect($url);
        die();
    }
}
?>