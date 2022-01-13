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
ob_start();
global $CURUSER;
if($CURUSER["delete_users"]!="yes")
die("wrong link!");

$act=isset($_GET["action"])?htmlspecialchars($_GET["action"]):$act='';


$returnto = "index.php?page=modules&module=cache";

if($act == 'send')
{
	$settings["cache_version"]=isset($_POST["cache_version"])?intval(0+$_POST["cache_version"]):$settings["cache_version"]=1;
	$settings["cache_duration"]=isset($_POST["cache_duration"])?intval(0+$_POST["cache_duration"]):$settings["cache_version"]=0;
	
    
	foreach($settings as $key=>$value)
          {
              if (is_bool($value))
               $value==true ? $value='true' : $value='false';

            $values[]="(".sqlesc($key).",".sqlesc($value).")";
        }
		$Match = "cache_";
        do_sqlquery("DELETE FROM {$TABLE_PREFIX}settings WHERE `key` LIKE '%".$Match."%'",true);
        do_sqlquery("INSERT INTO {$TABLE_PREFIX}settings (`key`,`value`) VALUES ".implode(",",$values).";",true);
        header("Location: $BASEURL/$returnto");		
}
else
{
    $Match = "cache_";
	$btit_settings=get_fresh_config("SELECT `key`,`value` FROM {$TABLE_PREFIX}settings where `key` LIKE '%".$Match."%'");
	if (class_exists('Memcache')) {  
    $memcache = new Memcache;  
    $isMemcacheAvailable = @$memcache->connect('localhost');  
} 
if ($isMemcacheAvailable) 
        $memcache = new Memcache;//test we can connect!

if(class_exists('Memcache') && function_exists('memcache_connect') && extension_loaded('memcache') && $memcache->connect('localhost', 11211)){
$use_mem='<span style="color:green">Memcached is enabled and running on your server! <img src="images/smilies/thumbsup.gif"></span>';
$disabled='';
}else{
$use_mem='<span style="color:red">Memcached is not enabled or running! <img src="images/smilies/sad.gif"></span>';
$disabled='disabled';
}


echo'<div align="center" style="align:center;">'.$use_mem.'</div>
<form method="post" action="index.php?page=modules&amp;module=cache&amp;action=send">
<table width="50%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td class="block" colspan="2" style="text-align:center">Cache Settings</td></tr>
<tr>
<td class=header>'.$language["CACHE_SITE"].'</td><td class="lista"><input type="text" name="cache_duration" value="'.$btit_settings["cache_duration"].'" size="10" /></td></tr>
<tr>
<td class=header>Cache Type(1:file 2:Memcached):</td><td class="lista"><input type="text" name="cache_version" value="'.$btit_settings["cache_version"].'" size="10" '.$disabled.'/></td></tr>
<tr>
<td colspan="2" class="header" style="text-align:center;"><input type="submit" value="'.$language["SUBMIT"].'"></td>
</tr></table></form>';
	
}
$module_out=ob_get_contents();
ob_end_clean();
?>