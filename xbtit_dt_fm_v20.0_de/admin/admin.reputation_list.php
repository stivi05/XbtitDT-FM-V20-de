<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    Reputation Spy by DiemThuy ( jan 2010 )
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

if (!defined("IN_BTIT"))
      die("non direct access!");

if (!defined("IN_ACP"))
      die("non direct access!");

require_once("include/functions.php");

dbconn();

$replist = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}reputation ORDER BY dateadd DESC") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $rlist=array();
    $i=0;

$admintpl->set("language",$language);

if (mysqli_num_rows($replist)==0)
{
    $rlist[$i]["member"]=("<center><font color=green>no</font></center>");
    $rlist[$i]["date"]=("<center><font color=red>reputation</font></center>");
    $rlist[$i]["points"]=("<center><font color=green>points</font></center>");
    $rlist[$i]["by"]=("<center><font color=red>yet</font></center>");
    $i++;
}
         else
             {
                 while ($arr=mysqli_fetch_assoc($replist))
                 {
               $r2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level,username FROM {$TABLE_PREFIX}users WHERE id=$arr[userid]") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
               $a2 = mysqli_fetch_assoc($r2);
               
               $r3= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level,username FROM {$TABLE_PREFIX}users WHERE id=$arr[whoadded]") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
               $a3 = mysqli_fetch_assoc($r3);
               
               $res4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor , suffixcolor  FROM {$TABLE_PREFIX}users_level WHERE id ='$a2[id_level]'");
               $arr4 = mysqli_fetch_assoc($res4);
               
               $res5 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor , suffixcolor  FROM {$TABLE_PREFIX}users_level WHERE id ='$a3[id_level]'");
               $arr5 = mysqli_fetch_assoc($res5);
               
               $name1 = $arr4[prefixcolor].$a2[username].$arr4[sufixcolor];
               $name2 = $arr5[prefixcolor].$a3[username].$arr5[sufixcolor];

               
        $rlist[$i]["member"]="<a href=index.php?page=userdetails&id=" . $arr[userid] . ">" . $name1. "</a>";
        $rlist[$i]["date"]= date('d/m/Y \a\\t H:i:s',$arr['dateadd']);
        $rlist[$i]["points"]=$arr['updown'];
        $rlist[$i]["by"]="<a href=index.php?page=userdetails&id=" . $arr[whoadded] . ">" . $name2. "</a>";
        $i++;

}}

$admintpl->set("rlist",$rlist);
?>