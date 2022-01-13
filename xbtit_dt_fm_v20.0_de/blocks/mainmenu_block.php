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
   
global $CURUSER, $FORUMLINK, $language,$btit_settings;

?>
<table cellpadding="1" cellspacing="1" width="100%" border="0" align="center">
  <tr>
<?php

if($CURUSER["id_level"]>=1)
   {   
   print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php\">".$language["MNU_INDEX"]."</a></td>\n"); 
   print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=faq\">".$language["MNU_FAQ"]."</a></td>\n");
   print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=rules\">".$language["RULES"]."</a></td>\n");
}
if ($CURUSER["view_news"]=="yes")
   print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=viewnews\">".$language["MNU_NEWS"]."</a></td>\n");
   
if ($CURUSER["view_users"]=="yes")
print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=users\">".$language["MNU_MEMBERS"]."</a></td>\n");

if($CURUSER["id_level"]>=3)
{
print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=staff\">".$language["STAFF"]."</a></td>\n");
if($btit_settings["ytv"]=="true")
print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=video_page\">".$language["VIDEOPAGE"]."</a></td>\n");
}
	
if ($CURUSER["view_forum"]=="yes")
   {
   if ($FORUMLINK=="" || $FORUMLINK=="internal" || substr($FORUMLINK,0,3)=="smf" || $FORUMLINK=="ipb")
      print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=forum\">".$language["MNU_FORUM"]."</a></td>\n");
   else
       print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"".$FORUMLINK."\">".$language["MNU_FORUM"]."</a></td>\n");
    }
?>
</tr><tr>
<?php
if($CURUSER["id_level"]>=3)
print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=modules&amp;module=helpdesk\">".$language["HELPDESK"]."</a></td>\n");

if ($CURUSER["view_torrents"]=="yes")
print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=torrents\">".$language["MNU_TORRENT"]."</a></td>\n");
		
if($CURUSER["id_level"]>=3)
{
    print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=todaytorrents\">".$language['TORRENT_TODAY']."</a></td>\n");
    print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=viewrequests\">".$language["VR"]."</a></td>\n");
    print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=viewexpected\">".$language["XPCTD_2_OFFER"]."</a></td>\n");
    print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=limit\">".$language["MNU_STATS"]."</a></td>\n");

}
if ($CURUSER["can_upload"]=="yes")
{ 
if($btit_settings["up_on"]==true AND $CURUSER["id_level"]==3) 
print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=uploadrequest\">".$language["ULR"]."</a></td>\n");
else  
print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=upload\">".$language["MNU_UPLOAD"]."</a></td>\n");
}
if($CURUSER["id_level"]>=3)
print("<td class=\"header\" align=\"center\"><a class=\"mainmenu\" href=\"index.php?page=don_historie\">".$language["DONATIONS"]."</a></td>\n");

?>
  </tr>
   </table>