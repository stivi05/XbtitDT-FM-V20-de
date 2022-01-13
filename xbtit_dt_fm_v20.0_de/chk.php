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
      
$uid=mysqli_real_escape_string($DBDT,$_GET["uid"]);
$id=mysqli_real_escape_string($DBDT,$_GET["topicid"]);

$qry =mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}forum_pm WHERE topicid='$id' AND user_id='$uid'");

if (mysqli_num_rows($qry) != 1)
{
  if(isset($_POST["check"]) && $_POST["check"]=="on")
  {
   mysqli_query($GLOBALS["___mysqli_ston"],"INSERT INTO {$TABLE_PREFIX}forum_pm (user_id, topicid, enabled ) VALUES ($uid, $id, 'yes')");
   header("location:index.php?page=forum&action=viewtopic&topicid=$id"); 
  }
}
 else
 mysqli_query($GLOBALS["___mysqli_ston"],"DELETE FROM {$TABLE_PREFIX}forum_pm  WHERE topicid='$id' AND user_id='$uid'");
  
header("location:index.php?page=forum&action=viewtopic&topicid=$id"); 
?>