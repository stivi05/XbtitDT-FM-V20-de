<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Ask for reseed by CobraCRK - converted to XBTIT-2 by DiemThuy - Dec 2008
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

if(strlen($_GET['q'])!=40)
{
    err_msg($language["ERROR"],$language['INVALID_INFO_HASH']);
    stdfoot();
    exit();
}

$hash=mysqli_real_escape_string($DBDT,$_GET['q']);

if($XBTT_USE)
    $res=do_sqlquery("SELECT `f`.`reseed`, `f`.`filename`, `x`.`fid` FROM `{$TABLE_PREFIX}files` `f` INNER JOIN `xbt_files` `x` ON `f`.`bin_hash`=`x`.`info_hash` WHERE `f`.`info_hash`='".$hash."'",true);
else
    $res=do_sqlquery("SELECT `reseed`, `filename` FROM `{$TABLE_PREFIX}files` WHERE `info_hash`='".$hash."'",true);

if(@mysqli_num_rows($res)==1)
{
    $row=mysqli_fetch_assoc($res);    

    if((time()-$row["reseed"])>432000)
    {
        $subj="Reseed Request";
        $msg="At some point in the past you downloaded\n\n[url=".$BASEURL."/index.php?page=torrent-details&id=".$hash."]".$row["filename"]."[/url]\n\nThis torrent no longer has any seeds and ".$CURUSER["username"]." would like to download it, if you still have those files on your computer please can you join the torrent as a seed.\n\nThank You\n\n[color=red][b]THIS IS AN AUTOMATED SYSTEM MESSAGE SO PLEASE DON'T REPLY[/b][/color]";

        if($XBTT_USE)
            $r=do_sqlquery("SELECT `uid` FROM `xbt_files_users` WHERE `active`=0 AND `completed`=1 AND `fid`='".$row["fid"]."' ORDER BY `uid` ASC",true);
        else
            $r=do_sqlquery("SELECT `uid` FROM `{$TABLE_PREFIX}history` WHERE `active`='no' AND `completed`='yes' AND `infohash`='".$hash."' ORDER BY `uid` ASC",true);

        while($row = mysqli_fetch_array($r))
            send_pm(0,$row["uid"],sqlesc($subj),sqlesc($msg));

   	    do_sqlquery("UPDATE `{$TABLE_PREFIX}files` SET `reseed`=UNIX_TIMESTAMP() WHERE `info_hash`='".$hash."'",true);

        information_msg("Reseed requested","A PM has been sent to all members who have completed this torrent.");
        stdfoot();
        exit();
    }
    else
    {
        err_msg("Reseed Error","Someone has already done a reseed request on this torrent within the last 5 days.");
        stdfoot();
        exit();
    }
}
else
{
    err_msg($language["ERROR"],$language['INVALID_INFO_HASH']);
    stdfoot();
    exit();
}

?>