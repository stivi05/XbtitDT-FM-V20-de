<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM. ( feb 02/14)
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
global $CURUSER, $FORUMLINK, $language , $btit_settings;

if($btit_settings["menu"]=="true")   
{   
?>
<div id='dock'>
<div id='dock_container'>
<div id='dock-item' class='jqDockAuto' data-jqdock-align='top' data-jqdock-labels='true'>
<?php
 
if($CURUSER["id_level"]>=1)
   {   
   print("<a href=\"index.php\"><img src=\"images/menu/home.png\" title='".$language["MNU_INDEX"]."' alt=\'\' /></a>\n"); 
}
if ($CURUSER["view_torrents"]=="yes")
   {     
   print("<a href=\"index.php?page=torrents\"><img src=\"images/menu/download.png\" title='".$language["MNU_TORRENT"]."' alt=\'\' /></a>\n");
	 
if($btit_settings["tordayy"]=="true")
   print("<a href=\"index.php?page=todaytorrents\"><img src=\"images/menu/today.png\" title='".$language['TORRENT_TODAY']."' alt=\'\' /></a>\n");
	 
if($btit_settings["subtitles"]=="true")
{
   require (load_language("lang_subs.php"));	  
   print("<a href=\"index.php?page=subtitles\"><img src=\"images/menu/subt.png\" title='".$language["SUB_BLOCK"]."' alt=\'\' /></a>\n");   
}

if($CURUSER["id_level"]==1 AND $btit_settings["apply_on"]==true)
{ 
print("<a href=\"index.php?page=apply\"><img src=\"images/menu/apply.png\" title='Apply for Membership' alt=\'\' /></a>\n"); 
}
   
}
if ($CURUSER["can_upload"]=="yes")
   { 
if($btit_settings["up_on"]==true AND $CURUSER["id_level"]==3) 
   { 
   print("<a href=\"index.php?page=uploadrequest\"><img src=\"images/menu/upreq.png\" title='".$language["ULR"]."' alt=\'\' /></a>\n"); 
   }
else  
{       
   print("<a href=\"index.php?page=upload\"><img src=\"images/menu/upload.png\" title='".$language["MNU_UPLOAD"]."' alt=\'\' /></a>\n");   
   }
}
if ($CURUSER["view_torrents"]=="yes")
   { 
if ($btit_settings["req_onoff"]=="true")/* <-- works */
   print("<a href=\"index.php?page=viewrequests\"><img src=\"images/menu/request.png\" title='".$language["VR"]."' alt=\'\' /></a>\n");
	 
if($btit_settings["offerr"]=="true")
   print("<a href=\"index.php?page=viewexpected\"><img src=\"images/menu/offer.png\" title='".$language["XPCTD_2_OFFER"]."' alt=\'\' /></a>\n");
	 
   print("<a href=\"index.php?page=limit\"><img src=\"images/menu/stats.png\" title='".$language["MNU_STATS"]."' alt=\'\' /></a>\n"); 
   
if($btit_settings["imdbmenu"]=="true")
    print("<a href=\"index.php?page=modules&module=IMDb\"><img src=\"images/menu/imdbmenu.png\" title='".$language["IMDBS"]."' alt=\'\' /></a>\n"); 
    }
 
if($CURUSER["id_level"]>=1)
   {  
   print("<a href=\"index.php?page=faq\"><img src=\"images/menu/faq.png\" title='".$language["MNU_FAQ"]."' alt=\'\' /></a>\n"); 
   print("<a href=\"index.php?page=rules\"><img src=\"images/menu/rules.png\" title='".$language["RULES"]."' alt=\'\' /></a>\n");
	 }
if ($CURUSER["view_users"]=="yes")
   {
	 print("<a href=\"index.php?page=users\"><img src=\"images/menu/members.png\" title='".$language["MNU_MEMBERS"]."' alt=\'\' /></a>\n");
	 }
if($CURUSER["id_level"]>=3)
{	 
   print("<a href=\"index.php?page=staff\"><img src=\"images/menu/staff.png\" title='".$language["STAFF"]."' alt=\'\' /></a>\n");
   print("<a href=\"index.php?page=don_historie\"><img src=\"images/menu/donor.png\" title='".$language["DONATIONS"]."' alt=\'\' /></a>\n");

if($btit_settings["helpdesk"]=="true")
    print("<a href=\"index.php?page=modules&amp;module=helpdesk\"><img src=\"images/menu/help.png\" title='".$language["HELPDESK"]."' alt=\'\' /></a>\n");

if($btit_settings["bugs"]=="true")
    print("<a href=\"index.php?page=modules&amp;module=bugs\"><img src=\"images/menu/bugs.png\" title='".$language["MNU_BUGS"]."' alt=\'\' /></a>\n");
 
if($btit_settings["blackjack"]=="true")
   print("<a href=\"index.php?page=blackjack\"><img src=\"images/menu/cards.png\" title='".$language["BLACKJACK"]."' alt=\'\' /></a>\n");

if($btit_settings["teams"]=="true")
   print("<a href=\"index.php?page=modules&amp;module=teams\"><img src=\"images/menu/team.png\" title='".$language["TEAMS"]."' alt=\'\' /></a>\n"); 

if($btit_settings["sloton"]=="true")   
   print("<a href=\"index.php?page=slots\"><img src=\"images/menu/slot.png\" title='".$language["SLOTS"]."' alt=\'\' /></a>\n"); 
     
if($btit_settings["ytv"]=="true")
   print("<a href=\"index.php?page=video_page\"><img src=\"images/menu/yt.png\" title='".$language["VIDEOPAGE"]."' alt=\'\' /></a>\n"); 
   
if($btit_settings["irc_on"]=="true")
   print("<a href=\"index.php?page=modules&amp;module=irc\"><img src=\"images/menu/irc.png\" title='".$language["MNU_IRC"]."' alt=\'\' /></a>\n"); 
   
if($btit_settings["enable_dox"]=="true")
   print("<a href=\"index.php?page=dox\"><img src=\"images/menu/dox.png\" title='".$language["DOX"]."' alt=\'\' /></a>\n");    
   
if($btit_settings["caldt"]=="true")
   print("<a href=\"index.php?page=modules&amp;module=calender\"><img src=\"images/menu/cal.png\" title='Calender' alt=\'\' /></a>\n");          
      
//hack add one 
 
       
}
/*  
if ($CURUSER["view_news"]=="yes") 
     { 
  
   print("<a href=\"index.php?page=viewnews\"><img src=\"images/menu/news.png\" title='".$language["MNU_NEWS"]."' alt=\'\' /></a>\n"); 

    }*/
if ($CURUSER["view_forum"]=="yes")
   {
   if ($FORUMLINK=="" || $FORUMLINK=="internal" || substr($FORUMLINK,0,3)=="smf" || $FORUMLINK=="ipb")
   {
   print("<a href=\"index.php?page=forum\"><img src=\"images/menu/forum.png\" title='".$language["MNU_FORUM"]."' alt=\'\' /></a>\n"); 
   }
else
{
   print("<a href='".$GLOBALS["FORUMLINK"]."'><img src=\"images/menu/forum.png\" title='".$language["MNU_FORUM"]."' alt=\'\' /></a>\n"); 
   }
	
if ($CURUSER["id_level"]>=6)
   {  
   print("<a href=\"index.php?page=reports\"><img src=\"images/menu/report.png\" title='".$language["REPORTS"]."' alt=\'\' /></a>\n");
	 
if ($btit_settings["aannn"]=="true")
   print("<a href=\"index.php?page=announcement\"><img src=\"images/menu/ann.png\" title='".$language["ANN"]."' alt=\'\' /></a>\n"); 

  }	
}
?>
</div>
</div>
</div>
<?php
}
else
{    
 print("<div id='menu'>\n<ul class='level1'>");
         
if ($CURUSER["view_torrents"]=="yes")    
{    
    print("<li class='level1-li'><a class='level1-a drop' href='#'>".$language['TORRENT_MENU']."</a>\n");
    print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
    print("<ul class='level2'>\n");

    print("<li><a class='fly' href='#'>".$language["MNU_TORRENT"]."</a>\n");
    print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
    print("<ul class='level3'>\n");
                
if ($CURUSER["can_upload"]=="yes")                
{
    print("<li><a class='fly' href='#'>".$language['UPLOAD_LINK']."</a>\n");
    print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
    print("<ul class='level4'>\n");
if($btit_settings["up_on"]==true AND $CURUSER["id_level"]==3) 
    print("<li><a href='index.php?page=uploadrequest'>".$language["ULR"]."</a></li>\n");
else  
{
    print("<li><a href='index.php?page=upload'>".$language["MNU_UPLOAD"]."</a></li>\n");
}
    print("</ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>");
}
    print("<li><a href='index.php?page=torrents&search=&category=0&active=0'>".$language["ALL"]."</a></li>\n");
    print("<li><a href='index.php?page=torrents&search=&category=0&active=1'>".$language["ACTIVE_ONLY"]."</a></li>\n");
    print("<li><a href='index.php?page=torrents&search=&category=0&active=2'>".$language["DEAD_ONLY"]."</a></li>\n");
if($CURUSER["id_level"]>=3)
		{
       print("<li><a href=\"index.php?page=subtitles\">".$language["SUB_BLOCK"]."</a></li>\n");
    }
    print("</ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>");
if($CURUSER["id_level"]>=3)
  {
    print("<li><a href='index.php?page=limit'>".$language["MNU_STATS"]."</a></li>\n");
if($btit_settings["imdbmenu"]=="true")
	print("<li><a href='index.php?page=modules&module=IMDb'>".$language["IMDBS"]."</a></li>\n");
if($btit_settings["tordayy"]=="true")	
    print("<li><a href='index.php?page=todaytorrents'>".$language['TORRENT_TODAY']."</a></li>\n");
if ($btit_settings["req_onoff"]=="true")
    print("<li><a href='index.php?page=viewrequests'>".$language['VR']."</a></li>\n");
if($btit_settings["offerr"]=="true")
    print("<li><a href='index.php?page=viewexpected'>".$language['XPCTD_2_OFFER']."</a></li>\n");
if ($btit_settings["amenu"]=="true")
    print("<li><a href='".$btit_settings["bmenu"]."'>".$btit_settings["cmenu"]."</a></li>\n");
if ($btit_settings["dmenu"]=="true")
    print("<li><a href='".$btit_settings["emenu"]."'>".$btit_settings["fmenu"]."</a></li>\n");
   } 
}

if($CURUSER["view_torrents"]=="yes" || $CURUSER["can_upload"]=="yes")
{
    print("</ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>");
}

print("<li class='level1-li'><a href='index.php'>".$language["MNU_INDEX"]."</a></li>\n");

if ($CURUSER["uid"]==1 || !$CURUSER)
{
    print("<li class='level1-li'><a href='index.php?page=login'>".$language["LOGIN"]."</a></li>\n");
}
else
{
    print("<li class='level1-li'><a href='logout.php'>".$language["LOGOUT"]."</a></li>\n");
}

if($CURUSER["id_level"]==1 AND $btit_settings["apply_on"]==true)
{ 
print("<li class='level1-li'><a href='index.php?page=apply'>Apply for Membership</a></li>\n");
}

if($CURUSER["id_level"]>=3)
{ 
print("<li class='level1-li'><a href='index.php?page=don_historie'>".$language["DONATIONS"]."</a></li>\n");
}


if($CURUSER["id_level"]>=1)
{
    print("<li class='level1-li left'><a class='level1-a drop' href='#'>".$language['USER_MENU']."</a>\n");
    print("<!--[if lte IE 6]><table><tr><td><![endif]-->\n");
    print("<ul class='level2'>\n");
# User links panel
 
        print ("<li><a class='fly' href='#'>".$language['USER_LINKS']."</a>\n");
        print ("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
        print ("<ul class='level3'>\n");
if($CURUSER["id_level"]>=1)
 {
	      print("<li><a href='index.php?page=faq'>".$language["MNU_FAQ"]."</a></li>\n");	
	      print("<li><a href='index.php?page=rules'>".$language["RULES"]."</a></li>\n");
	}
if($CURUSER["view_users"]=="yes")
    {		     
        print("<li><a href='index.php?page=users'>".$language["MNU_MEMBERS"]."</a><b></b></li>\n");
		}
if($CURUSER["id_level"]>=3)
    {
		print("<li><a href='index.php?page=staff'>".$language['STAFF']."</a><b></b></li>\n");
				
if($btit_settings["helpdesk"]=="true")
		print("<li><a href='index.php?page=modules&amp;module=helpdesk'>".$language["HELPDESK"]."</a></li>\n");
				
if($btit_settings["bugs"]=="true")
		print("<li><a href='index.php?page=modules&amp;module=bugs'>".$language["MNU_BUGS"]."</a></li>\n");
				
		print("<li><a href='index.php?page=user_img'>".$language['UIMG']."</a><b></b></li>\n");
		
if($btit_settings["blackjack"]=="true")		
        print("<li><a href='index.php?page=blackjack'>".$language['BLACKJACK']."</a><b></b></li>\n");
        
if($btit_settings["teams"]=="true")
        print("<li><a href='index.php?page=modules&amp;module=teams'>".$language["TEAMS"]."</a><b></b></li>\n");
        
if($btit_settings["sloton"]=="true")
        print("<li><a href='index.php?page=slots'>".$language['SLOTS']."</a></li>\n");
		
if($btit_settings["ytv"]=="true")
        print("<li><a href='index.php?page=video_page'>".$language["VIDEOPAGE"]."</a></li>\n");
        
if($btit_settings["irc_on"]=="true")
        print("<li><a href='index.php?page=modules&amp;module=irc'>".$language["MNU_IRC"]."</a></li>\n");
        
if($btit_settings["gallery"]=="true")
        print("<li><a href=\"javascript:gallery('gallery.php');\">".$language['gallery']."</a></li>\n");     

if($btit_settings["enable_dox"]=="true")        
        print("<li><a href=\"index.php?page=dox\">".$language["DOX"]."</a></li>\n");
        
if($btit_settings["quiz"]=="true")        
        print("<li><a href=\"index.php?page=modules&amp;module=quiz\">Quiz</a></li>\n");  
		
if($btit_settings["caldt"]=="true")	
        print("<li><a href=\"index.php?page=modules&amp;module=calender\">Calender</a></li>\n"); 	 
		
if($btit_settings["sbup"]=="true")	
        print("<li><a href=\"index.php?page=modules&amp;module=sb_to_upload_conversion\">SB to Upload</a></li>\n"); 
		
if ($btit_settings["gmenu"]=="true")
        print("<li><a href='".$btit_settings["hmenu"]."'>".$btit_settings["imenu"]."</a></li>\n");
    
if ($btit_settings["jmenu"]=="true")
        print("<li><a href='".$btit_settings["kmenu"]."'>".$btit_settings["lmenu"]."</a></li>\n");		     
        
//hack add two        
        
   	    print ("</ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>");
		}
   
# User control panel menu
if($CURUSER["id_level"]>=3)
    {
			  require_once (load_language("lang_usercp.php"));
    print("<li><a class='fly' href='#'>".$language["USER_CP"]."</a>\n");
    print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
    print("<ul class='level3'>\n");
    print("<li><a href='index.php?page=usercp&amp;uid=".$CURUSER["uid"]."'>".$language['MNU_UCP_HOME']."</a></li>\n");
		
    print("<li><a class='fly' href='#'>".$language["MNU_UCP_PM"]."</a>\n");
		print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
    print("<ul class='level4'>");
    print("<li><a href='index.php?page=usercp&uid=".$CURUSER["uid"]."&do=pm&action=list&what=inbox'>".$language['MNU_UCP_IN']."</a></li>\n");
    print("<li><a href='index.php?page=usercp&uid=".$CURUSER["uid"]."&do=pm&action=list&what=outbox'>".$language['MNU_UCP_OUT']."</a></li>\n");
    print("<li><a href='index.php?page=usercp&uid=".$CURUSER["uid"]."&do=pm&action=edit&uid=".$CURUSER["uid"]."&what=new'>".$language['MNU_UCP_NEWPM']."</a></li></ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");

    print("<li><a class='fly' href='#'>".$language["MNU_UCP_INFO"]."</a>\n");
	  print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
    print("<ul class='level4'>\n");
    print("<li><a href='index.php?page=usercp&do=user&action=change&uid=".$CURUSER["uid"]."'>".$language['MNU_UCP_INFO']."</a></li>\n");
    print("<li><a href='index.php?page=usercp&do=pwd&action=change&uid=".$CURUSER["uid"]."'>".$language['MNU_UCP_CHANGEPWD']."</a></li>\n");
    print("<li><a href='index.php?page=usercp&do=pid_c&action=change&uid=".$CURUSER["uid"]."'>".$language['CHANGE_PID']."</a></li>\n");
	  print ("</ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>");
		}
    print ("</ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>");

		if ($CURUSER["view_forum"]=="yes")
    {
        if ($GLOBALS["FORUMLINK"]=="" || $GLOBALS["FORUMLINK"]=="internal" || substr($GLOBALS["FORUMLINK"],0,3)=="smf" || $GLOBALS["FORUMLINK"]=="ipb")
            print("<li><a href='index.php?page=forum'>".$language["MNU_FORUM"]."</a></li>\n");
        else
            print("<li><a href='".$GLOBALS["FORUMLINK"]."'>".$language["MNU_FORUM"]."</a></li>\n");
    }

    if ($CURUSER["view_news"]=="yes")
    {
        print("<li><a href='index.php?page=viewnews'>".$language['MNU_NEWS']."</a></li>\n");
        
	print ("</ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>");
}   

# Admin Menu
if($CURUSER["id_level"]>=6)
{
            print ("<li class='level1-li left'><a class='level1-a drop' href='#'>".$language['ADMIN_MENU']."</a>\n");
            print ("<!--[if lte IE 6]><table><tr><td><![endif]-->\n");
            print ("<ul class='level2'>\n");

            print ("<li><a class='fly' href='#'>".$language["MNU_ADMINCP"]."</a>\n");
            print ("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
            print ("<ul class='level3'>\n");
		
		if($CURUSER["admin_access"]=="yes")
    {
            require_once (load_language("lang_admin.php"));
							
            print("<li><a class='fly' href='#'>".$language['TRACKER_SETTINGS']."</a>\n");
            print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
            print("<ul class='level4'>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=config&action=read'>".$language['TRACKER_SETTINGS']."</a></li>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=banip&action=read'>".$language['ACP_BAN_IP']."</a></li>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=language&action=read'>".$language['ACP_LANGUAGES']."</a></li>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=style&action=read'>".$language['ACP_STYLES']."</a></li>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=security_suite'>".$language["ACP_SECSUI_SET"]."</a></li></ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
        
            print("<li><a class='fly' href='#'>".$language['ACP_FRONTEND']."</a>\n");
				    print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
            print("<ul class='level4'>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=category&action=read'>".$language['ACP_CATEGORIES']."</a></li>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=poller&action=read'>".$language['ACP_POLLS']."</a></li>");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=badwords&action=read'>".$language["ACP_CENSORED"]."</a></li>");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=blocks&action=read'>".$language['ACP_BLOCKS']."</a></li></ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
        
        print("<li><a class='fly' href='#'>".$language['ACP_USERS_TOOLS']."</a>\n");
				print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
        print("<ul class='level4'>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=groups&action=read'>".$language['ACP_USER_GROUP']."</a></li>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=masspm&action=write'>".$language['ACP_MASSPM']."</a></li>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=loglog'>".$language["ACP_LOGLOG"]."</a></li>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=pruneu'>".$language['ACP_PRUNE_USERS']."</a></li>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=searchdiff'>".$language['ACP_SEARCH_DIFF']."</a></li>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=newuser'>".$language['ACP_ADD_USER']."</a></li></ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
        
        print("<li><a class='fly' href='#'>".$language['ACP_TORRENTS_TOOLS']."</a>\n");
				print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
        print("<ul class='level4'>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=prunet'>".$language['ACP_PRUNE_TORRENTS']."</a></li></ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
        
        print("<li><a class='fly' href='#'>".$language['ACP_FORUM']."</a>\n");
				print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
        print("<ul class='level4'>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=forum&action=read'>".$language['ACP_FORUM']."</a></li></ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
       
        print("<li><a class='fly' href='#'>".$language['ACP_OTHER_TOOLS']."</a>");
        print("<ul class='level4'>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=dbutil'>".$language['ACP_DBUTILS']."</a></li>");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=mysql_stats'>".$language['ACP_MYSQL_STATS']."</a></li>");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=logview'>".$language['ACP_SITE_LOG']."</a></li></ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
        
        print("<li><a class='fly' href='#'>".$language['ACP_MODULES']."</a>\n");
				print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
        print("<ul class='level4'>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=module_config&action=manage'>".$language['ACP_MODULES_CONFIG']."</a></li></ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
        
        print("<li><a class='fly' href='#'>".$language['ACP_HACKS']."</a>\n");
				print("<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->\n");
        print("<ul class='level4'>\n");
print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&do=hacks&action=read'>".$language['ACP_HACKS_CONFIG']."</a></li></ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
        print("</ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
    }
		
            print("<li><a href='index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."'>".$language["ADMIN_MAIN"]."</a></li>");
            print("<li><a href='index.php?page=reports'>".$language['REPORTS']."</a></li>\n");	
            
			if ($btit_settings["aannn"]=="true")
            print("<li><a href='index.php?page=announcement'>".$language["ANN"]."</a></li>\n");
            
            print("<li><a href=\"index.php?page=modules&amp;module=cache\">Cache Settings</a></li>\n");
            
			if($btit_settings["quiz"]=="true")        
            print("<li><a href=\"index.php?page=modules&amp;module=quiz_admin\">Quiz Admin</a></li>\n"); 
            
            if($btit_settings["server"]=="true")        
            print("<li><a href=\"index.php?page=modules&amp;module=server\">Server Stats</a></li>\n"); 
        
		print ("</ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
}

    print ("</ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
    print ("</ul><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>\n");
}

print("</div>");
}
?>