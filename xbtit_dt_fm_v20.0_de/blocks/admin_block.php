<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit dt fm.
//
// Redistribution and use in source and binary forms, with or without modification,
// are permitted provided that the following conditions are met:
//
// Admin block by DiemThuy 08/2012 made for XBTIT FM DT [www.websitecustomizers.net]
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

global $CURUSER,$btit_settings;
if (!$CURUSER || $CURUSER["id_level"]<6)
   {
    // do nothing
   }
else
    {
print("<TABLE width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">");       
// tm     
if ($CURUSER['moderate_trusted']=='yes')
{
    $res=get_result("SELECT COUNT(*) `count` FROM `{$TABLE_PREFIX}files` WHERE `moder`='um'", true, $btit_settings["cache_duration"]);
    $row = $res[0];
    $um_t = (int)$row["count"];

if ($um_t>0)
	print("<tr><td class=\"header\" align=\"center\"><a href=\"index.php?page=moder\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/tmm.png\"></span>&nbsp;Torrent Mod</a><span style=\"float:right; padding-right:5px;\"><font color=\"red\"> [ $um_t ]</font></span></td></tr>\n");  
	else
	print("<tr><td class=\"header\" align=\"center\"><a href=\"index.php?page=moder\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/tmm.png\"></span>&nbsp;Torrent Mod</a><span style=\"float:right; padding-right:5px;\"><font color=\"green\">[ - ]</font></span></td></tr>\n"); 
}	   
// reports     
$resrep=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) FROM {$TABLE_PREFIX}reports WHERE dealtwith=0");
if ($resrep && mysqli_num_rows($resrep)>0)
   {
    $rep=mysqli_fetch_row($resrep);
  
    
    if ($rep[0]>0){

print("<tr><td class=\"header\" align=\"center\"><a href=\"index.php?page=reports&amp;uid=".$CURUSER["uid"]."\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/report.png\"></span>&nbsp;Reports</a><span style=\"float:right; padding-right:5px;\"><font color=\"red\"><b>[ $rep[0] ]</font></span></td></tr>\n");
    }else
print("<tr><td class=\"header\" align=\"center\"><a href=\"index.php?page=reports&amp;uid=".$CURUSER["uid"]."\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/report.png\"></span>&nbsp;Reports</a><span style=\"float:right; padding-right:5px;\"><font color=\"green\">[ - ]</font></span></td></tr>\n");
   }
else
print("<tr><td class=\"header\" align=\"center\"><a href=\"index.php?page=reports&amp;uid=".$CURUSER["uid"]."\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/report.png\"></span>&nbsp;Reports</a><span style=\"float:right; padding-right:5px;\"><font color=\"green\">[ - ]</font></span></td></tr>\n");

// helpdesk
$countt=get_result("SELECT * FROM {$TABLE_PREFIX}helpdesk WHERE solved='no'");
$count=count($countt);

if ($count==0)
print("<tr><td class=\"header\" align=\"center\"><a href=\"index.php?page=modules&amp;module=helpdesk\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/help.png\"></span>&nbsp;Helpdesk</a><span style=\"float:right; padding-right:5px;\"><font color=\"green\">[ - ]<font></span></td></tr>\n");
else
print("<tr><td class=\"header\" align=\"center\"><a href=\"index.php?page=modules&amp;module=helpdesk\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/help.png\"></span>&nbsp;Helpdesk</a><span style=\"float:right; padding-right:5px;\"><font color=\"red\">[ $count ]<font></span></td></tr>\n");

print("<tr><td class=\"header\" align=\"center\"><a href=\"index.php?page=modules&amp;module=hitnrun_cleaner\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/run.png\"></span>&nbsp;<font color= red><span style=\"float:right; padding-right:5px;\">Clean Hit & Run </span><font></a></td></tr>\n");
if ($btit_settings["cloud"]==TRUE)
print("<tr><td class=\"header\" align=\"center\"><a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=cloudflush\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/flush.png\"></span><font color=\"red\"><span style=\"float:right; padding-right:5px;\">Cloud Flush<font></span></a></td><tr>\n");

$resch=get_result("SELECT * FROM `{$TABLE_PREFIX}chatfun` WHERE `time` > ".$CURUSER["lastconnect"] ,true );
$cound=count($resch);

if ($cound==0)
print("<tr><td class=\"header\" align=\"center\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/staf.png \" /></span><a href=\"index.php?page=modules&amp;module=stafffun\">&nbsp;Staff Shout</a><span style=\"float:right; padding-right:5px;\"><font color=\"green\">[ - ]<font></span></td></tr>\n");
else
print("<tr><td class=\"header\" align=\"center\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/staf.png \" /></span><a href=\"index.php?page=modules&amp;module=stafffun\">&nbsp;Staff Shout</a><span style=\"float:right; padding-right:5px;\"><font color=\"red\">[ $cound ]<font></span></td></tr>\n");

//contact
$rescc=get_result("SELECT * FROM {$TABLE_PREFIX}contact_system WHERE re='no'");
$counc=count($rescc);

if ($counc==0)
print("<tr><td class=\"header\" align=\"center\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/mail.png \" /></span><a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=read_messages\">&nbsp;Contact</a><span style=\"float:right; padding-right:5px;\"><font color=\"green\">[ - ]<font></span></td></tr>\n");
else
print("<tr><td class=\"header\" align=\"center\"><span style=\"float:left; padding-left:3px;\"><img src=\"images/mail.png \" /></span><a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=read_messages\">&nbsp;Contact</a><span style=\"float:right; padding-right:5px;\"><font color=\"red\">[ $counc ]<font></span></td></tr>\n");

if ($CURUSER["id_level"]==8)
print("<tr><td class=\"block-head-title\" align=\"center\"><a href=\"index.php?page=massmoderate\">Mass Moderate</a></td></tr>\n");           


print("<tr><td class=\"block-head-title\" align=\"center\">Staff Chat</td></tr>\n");           
print("<tr><br/><td class=\"lista\" align=\"center\"><center><a href=\"index.php?page=modules&amp;module=stafffun\"><br /><img src=\"images/chat.png\"></center></a></td><tr>\n");
print("</TABLE>"); 
} 
//end
?>