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
require_once ("include/functions.php");
require_once ("include/config.php");

dbconn();

if (!defined("IN_BTIT"))
      die("non direct access!");

if (!defined("IN_ACP"))
      die("non direct access!");


if (isset($_GET["action"]))
$action = $_GET["action"];
else
$action = "";

     $subject = $_POST["subject"];
     $subject = stripslashes($subject);
     $content_1 = $HTTP_POST_VARS["content_1"];
     $content_1 = htmlentities($content_1, ENT_QUOTES);
     $content_1 = stripslashes($content_1);
     $content_1 = "<font face=\"arial\"> ". $content_1 ." </font>";

// get all email addresses from db from id 1

     $SQL = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT email FROM {$TABLE_PREFIX}users WHERE id>1");

     while($row = mysqli_fetch_array($SQL))
         {

//collect emails in array

         $EmailAddress2[] = $row["email"];
         }
// start send email to all

if ($action == "send_mail")
{
 $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT email FROM {$TABLE_PREFIX}users WHERE id>1") or sqlerr();
 $subject2 = $subject;
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From:".$CURUSER['email']."\r\n";
$mailbody = $_POST["content_1"];
 $to = "";
 $nmax = 1000; // Max recipients per message
 $nthis = 0;
 $ntotal = 0;
 $total = mysqli_num_rows($res);
 while ($arr = mysqli_fetch_row($res)) {
   if ($nthis == 0)
     $to = $arr[0];
   else
     $to .= "," . $arr[0];
   ++$nthis;
   ++$ntotal;
   if ($nthis == $nmax || $ntotal == $total) {
     if (!mail("Multiple recipients <$SITEEMAIL>", "$subject", $mailbody,
      "From: $SITEEMAIL\r\nBcc: $to", "-f$SITEEMAIL"))
     $nthis = 0;
   }
}
// lett us know if all went fine ( of course it did ;) )
        information_msg("Message Sent","Sent From: $SITEEMAIL. Message: $mailbody");
        stdfoot();
        exit();
}
$admintpl->set("subject","subject");
$admintpl->set("message","content_1");
$admintpl->set("frm_action", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=massemail&amp;action=send_mail");
?>