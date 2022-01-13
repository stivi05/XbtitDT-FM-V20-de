<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    Reputation system by DiemThuy ( Jan 2010 )
//    Rep Images by Friendly
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

global $CURUSER ;

if (!defined("IN_BTIT"))
      die("non direct access!");
      
require_once $THIS_BASEPATH.'/include/functions.php';

dbconn();

$id=(int)$_GET['id'];
$returnto=$_POST['returnto'];
// can not give points to yourself
if ($CURUSER["uid"]==$id)
{
stderr("Nice Try","You can not give reputation points to yourself !!");
stdfoot();
exit;
}
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

// staff or user
if ($CURUSER['edit_torrents']=='yes'&&$CURUSER['edit_users']=='yes')
{
$plus= $setrep["rep_adminpower"];
}
else
{
$plus= $setrep["rep_rdpower"];

// users can not give 2 x points
$repeat = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT userid FROM {$TABLE_PREFIX}reputation WHERE userid ='$id' AND whoadded=".$CURUSER["uid"]);
		if( mysqli_num_rows( $repeat) > 0 )
{
stderr("Hold On","You did allready give reputation points to this user !!");
stdfoot();
exit;
}

// users have a daily limit
$flood = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT dateadd FROM {$TABLE_PREFIX}reputation WHERE whoadded =".$CURUSER['uid']." ORDER BY dateadd DESC LIMIT 1");
$check = mysqli_fetch_assoc( $flood );

$DT = ($setrep["rep_maxperday"]* 3600);
$TDT = ($check['dateadd']+ $DT);
$ST=strtotime(now);

if($TDT > $ST )
{
stderr("Flood Control","You have to wait ".$setrep["rep_maxperday"]." hours before you can change users reputation again");
stdfoot();
exit;
}
}

if ($_POST['plus_x'])
{
$updown="+$plus";
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET reputation = reputation + '$plus' WHERE id='$id'");
}
else if ($_POST['min_x'])
{
$updown="-$plus";
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET reputation = reputation - '$plus' WHERE id='$id'");
}
@mysqli_query($GLOBALS["___mysqli_ston"],  "INSERT INTO {$TABLE_PREFIX}reputation (whoadded,dateadd,userid,updown) VALUES (".$CURUSER["uid"].",".strtotime(now).",".$id.",".$updown.")");
header('Location: '.$returnto);
die();
?>