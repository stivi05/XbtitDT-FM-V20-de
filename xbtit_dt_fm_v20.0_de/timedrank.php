<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  XBtiteam
//
//    This file is part of xbtit DT FM.
//
// Timed promote / demote system by DiemThuy June 2009
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

if($CURUSER['edit_torrents']=='no'&&$CURUSER['edit_users']=='no')die('Unauthorised access!');

$id=(int)$_GET['id'];

// protection
$rt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level FROM {$TABLE_PREFIX}users WHERE id ='$id'");
$at = mysqli_fetch_assoc($rt);

$idd=$at['id_level'];

$rtt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level FROM {$TABLE_PREFIX}users_level WHERE id ='$idd'");
$att = mysqli_fetch_assoc($rtt);

if ($CURUSER['uid']== $id)
{
	  stderr("Nice Try","You can not promote/demote yourself !!");
      stdfoot();
      die;	
}

if ($CURUSER['id_level']<= $att['id_level'])

{
	  stderr("Forget It","you can not demote/promote a member with the same or a higher rank than you !!");
      stdfoot();
      die;	
}
// protection

$dt3    =   (int)$_POST['level'];
$dt2    =   'yes';
$dt1=rank_expiration(mktime(date('H')+2,date('i'),date('s'),date('m'),date('d')+addslashes($_POST['t_days']),date('Y')));
$returnto=$_POST['returnto'];

// staff control
do_sqlquery("INSERT INTO {$TABLE_PREFIX}t_rank (userid, old_rank, new_rank, date, byt , enddate) VALUES ($id,$idd,$dt3, NOW(), $CURUSER[uid], '$dt1' )",true);
// staff control

$res4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT level FROM {$TABLE_PREFIX}users_level WHERE id ='$dt3'");
$arr4 = mysqli_fetch_assoc($res4);
$newrank = $arr4[level];

$res5 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT old_rank FROM {$TABLE_PREFIX}users WHERE id ='$id'");
$arr5 = mysqli_fetch_assoc($res5);

$res6 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT level FROM {$TABLE_PREFIX}users_level WHERE id ='$arr5[old_rank]'");
$arr6 = mysqli_fetch_assoc($res6);
$oldrank = $arr6[level];

function rank_expiration($timestamp=0){return gmdate('Y-m-d H:i:s',$timestamp);}

$subj=sqlesc("Your rank is changed !");
$msg=sqlesc("Your rank is changed to ".$newrank."\n\n this is a timed rank and it will expire ".$dt1."\n\n after that you will get your old rank ".$oldrank." back\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]");

do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `old_rank` = '".$idd."',`timed_rank`='".$dt1."', `rank_switch`='".$dt2."', `id_level`='".$dt3."' WHERE `id`=".$id);

send_pm(0,$id,$subj,$msg);

header('Location: '.$returnto);
die();
?>