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
      
global $btit_settings;
if ($btit_settings["acp"]=="true")
{
require_once ("acp_pw.php");
}      

if (!$CURUSER || ($CURUSER["admin_access"]!="yes" && $CURUSER["edit_users"]!="yes"))
   {
       err_msg($language["ERROR"],$language["NOT_ADMIN_CP_ACCESS"]);
       stdfoot();
       exit;
}

// Additional admin check by miskotes
$aid = max(0, $_GET["user"]);
$arandom = max(0,$_GET["code"]);
if (!$aid || empty($aid) || $aid==0 || !$arandom || empty($arandom) || $arandom==0)
{
       err_msg($language["ERROR"],$language["NOT_ADMIN_CP_ACCESS"]);
       stdfoot();
       exit;
}
//if ($arandom!=$ranid["random"] || $aid!=$ranid["id"])
//{
$mqry=do_sqlquery("select u.id, ul.admin_access from {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}users_level ul on ul.id=u.id_level WHERE u.id=$aid AND random=$arandom AND (admin_access='yes' OR edit_users='yes') AND username=".sqlesc($CURUSER["username"]),true);

if (mysqli_num_rows($mqry)<1)
{
       err_msg($language["ERROR"],$language["NOT_ADMIN_CP_ACCESS"]);
       stdfoot();
       exit;
}
else
$mres=mysqli_fetch_assoc($mqry);
$moderate_user=($mres["admin_access"]=="no");
// EOF

define("IN_ACP",true);


if (isset($_GET["do"])) $do=$_GET["do"];
  else $do = "";
if (isset($_GET["action"]))
   $action=$_GET["action"];

$ADMIN_PATH=dirname(__FILE__);

include(load_language("lang_admin.php"));

if ($do!="users"  && $do!="masspm"  && $do!="pruneu"  && $do!="searchdiff" && $moderate_user)
  {
    err_msg($language["ERROR"],$language["NOT_ADMIN_CP_ACCESS"]);
    stdfoot();
    exit;
}

include("$ADMIN_PATH/admin.menu.php");

$menutpl=new bTemplate();
$menutpl->set("admin_menu",$admin_menu);
$tpl->set("main_left",set_block($language["ACP_MENU"],"center",$menutpl->fetch(load_template("admin.menu.tpl"))));

$admintpl=new bTemplate();

switch ($do)
    {

       case 'newuser':
       include("$ADMIN_PATH/admin.users.new.php");
       $tpl->set(main_content,set_block($language[ACP_ADD_USER],"center",$admintpl->fetch(load_template("admin.users.new.tpl"))));
       break;
       
	   case 'read_messages':
       include("$ADMIN_PATH/admin.read_messages.php");
       $tpl->set("main_content",set_block($language["SUPPORT"],"center",$admintpl->fetch(load_template("admin.read_messages.tpl"))));
       break;
       
       case 'duplicates_pas':
       include("$ADMIN_PATH/admin.duplicates_pas.php");
       $tpl->set("main_content",set_block($language["DUPLICATES_PAS"],"center",$admintpl->fetch(load_template("admin.duplicates_pas.tpl"))));
       break;
       
       case 'connect':
       include("$ADMIN_PATH/admin.connect.php");
      $tpl->set("main_content",set_block($language["ACP_CONNECT"],"center",$admintpl->fetch(load_template("admin.connect.tpl"))));
       break;
       
       case 'time_control':
       include("$ADMIN_PATH/admin.time_control.php");
       $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.time_control.tpl"))));
       break;
      
       case 'featured':
       include("$ADMIN_PATH/admin.featured.php");
       $tpl->set("main_content",set_block($language["FEATURED_SETTINGS"],"center",$admintpl->fetch(load_template("admin.featured.tpl"))));
       break;
       
# ==KhezIndex==
       case 'kocs':
       include $ADMIN_PATH.'/admin.kocs.php';
       $tpl->set('main_content',set_block($language['ACP_KOCS'],'center',$admintpl->fetch(load_template($kocsTabTemplate))));
       break;

       case 'ipb_new_member':
       include("$ADMIN_PATH/admin.ipb_new_member.php");
       break;
       
       case 'gold':
       include("$ADMIN_PATH/admin.gold.php");
       $tpl->set("main_content",set_block($language["ACP_GOLD"],"center",$admintpl->fetch(load_template("admin.gold.tpl"))));
       break;
          
//comments hack
      case 'comments':
      include("$ADMIN_PATH/admin.comments.php");
      $tpl->set("main_content",set_block($language["ACP_COMMENTS"],"center",$admintpl->fetch(load_template("admin.comments.tpl"))));
      break;
//comments hack

      case 'reputation':
      include("$ADMIN_PATH/admin.reputation.php");
      $tpl->set("main_content",set_block($language["REPUTATION"],"center",$admintpl->fetch(load_template("admin.reputation.tpl"))));
      break;
      
      case 'reputation_list':
      include("$ADMIN_PATH/admin.reputation_list.php");
      $tpl->set("main_content",set_block($language["REPUTATION_LIST"],"center",$admintpl->fetch(load_template("admin.reputation_list.tpl"))));
      break;
      
      case 'torrentsdump':
      include("$ADMIN_PATH/admin.torrentsdump.php");
      $tpl->set("main_content",set_block('Torrents dump',"center",$admintpl->fetch(load_template("admin.torrentsdump.tpl"))));
      break;
        
      case 'ratio-editor':
      include("$ADMIN_PATH/admin.ratio-editor.php");
      $tpl->set("main_content",set_block($language["ACP_RATIO_EDITOR"],"center",$admintpl->fetch(load_template("admin.ratio-editor.tpl"))));
      break;

      case 'autorank':
      include("$ADMIN_PATH/admin.autorank.php");
      $tpl->set("main_content",set_block($language["ACP_AUTORANK"],"center",$admintpl->fetch(load_template("admin.autorank.tpl"))));
      break;
      
      case 'ratio_fix':
      include("$ADMIN_PATH/admin.ratio_fix.php");
      break;

      case 'invitations':
      include("$ADMIN_PATH/admin.invitations.php");
      $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.invitations.tpl"))));
      break;
      
      case 'uploader_control':
      include("$ADMIN_PATH/admin.uploader_control.php");
      $tpl->set("main_content",set_block($language["UP_CONTROL"],"center",$admintpl->fetch(load_template("admin.uploader_control.tpl"))));
      break;

      case 'faq_group':
      include("$ADMIN_PATH/admin.faq.group.php");
      $tpl->set("main_content",set_block($language["ACP_FAQ_GROUP"],"center",$admintpl->fetch(load_template("admin.faq.group.tpl"))));
      break;
      
      case 'calc':
      include("$ADMIN_PATH/admin.kalkul.php");
      $tpl->set("main_content",set_block($language["CALCU"],"center",$admintpl->fetch(load_template("admin.kalkul.tpl"))));
      break;
      
      case 'teams':
      require(load_language("lang_teams.php"));
      include("$ADMIN_PATH/admin.team.php");
      $tpl->set("main_content",set_block($language["TEAM_HEAD_H"],"center",$admintpl->fetch(load_template("admin.team.tpl"))));
      break;

      case 'team_users':
      require(load_language("lang_teams.php"));
      include("$ADMIN_PATH/admin.teams.php");
      $tpl->set("main_content",set_block($language["TEAM_HEAD_U"],"center",$admintpl->fetch(load_template("admin.teams.tpl"))));
      break;
      
      case 'booted_users':
      include("$ADMIN_PATH/admin.booted_users.php");
      $tpl->set("main_content",set_block($language["BOOT_U"],"center",$admintpl->fetch(load_template("admin.booted_users.tpl"))));
      break;  
	  
	  case 'cloudflush':
      do_sqlquery("TRUNCATE `{$TABLE_PREFIX}searchcloud`");
      print("<html><body bgcolor=black text=white><center><br><br><br><br><br><br><br><br><h1>Cloud cleaned!</h1></body></html><br>");
      redirect("index.php");
      break; 
      
      case 'clean':
      include("$ADMIN_PATH/admin.cleanshout.php");
      $tpl->set("main_content",set_block($language["CLEAN_SHOUT"],"center",$admintpl->fetch(load_template("admin.cleanshout.tpl"))));
      break;
          
      case 'cleanconfirm':
      include("$ADMIN_PATH/admin.clean.confirm.php");
      $tpl->set("main_content",set_block($language["CLEAN_CONFIRM"],"center",$admintpl->fetch(load_template("admin.clean.confirm.tpl"))));
      break;
      
      case 'logview':
      include("$ADMIN_PATH/admin.sitelog.php");
      $tpl->set("main_content",set_block($language["SITE_LOG"],"center",$admintpl->fetch(load_template("admin.sitelog.tpl"))));
      break;
      
//sb editor
      case 'sb-editor':
      include("$ADMIN_PATH/admin.sb-editor.php");
      $tpl->set("main_content",set_block($language["ACP_SB_EDITOR"],"center",$admintpl->fetch(load_template("admin.sb-editor.tpl"))));
      break;
//sb eiditor 
      
      case 'warned_users':
      include("$ADMIN_PATH/admin.warned_users.php");
      $tpl->set("main_content",set_block("Warned users","center",$admintpl->fetch(load_template("admin.warned_users.tpl"))));
      break; 

      case 'faq_question':
      include("$ADMIN_PATH/admin.faq.question.php");
      $tpl->set("main_content",set_block($language["ACP_FAQ_QUESTION"],"center",$admintpl->fetch(load_template("admin.faq.question.tpl"))));
      break;

      case 'rules':
      include("$ADMIN_PATH/admin.rules.php");
      $tpl->set("main_content",set_block($language["ACP_RULES"],"center",$admintpl->fetch(load_template("admin.rules.tpl"))));
      break;
      
      case 'rules_cat':
      include("$ADMIN_PATH/admin.rules.categories.php");
      $tpl->set("main_content",set_block($language["ACP_RULES_GROUP"],"center",$admintpl->fetch(load_template("admin.rules.categories.tpl"))));
      break;
      
      case 'sticky':
      include("$ADMIN_PATH/admin.sticky.php");
      $tpl->set("main_content",set_block($language["STICKY_SETTINGS"],"center",$admintpl->fetch(load_template("admin.sticky.tpl"))));
      break;

      case 'offline':
      include("$ADMIN_PATH/admin.offline.php");
      $tpl->set("main_content",set_block($language["ACP_OFFLINE"],"center",$admintpl->fetch(load_template("admin.offline.tpl"))));
      break;
      
	  case 'language':
      include("$ADMIN_PATH/admin.languages.php");
      $tpl->set("main_content",set_block($language["LANGUAGE_SETTINGS"],"center",$admintpl->fetch(load_template("admin.languages.tpl"))));
      break;

      case 'searchdiff':
      include("$ADMIN_PATH/admin.search_diff.php");
      $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.search_diff.tpl"))));
      break;

      case 'banbutton':
      include("$ADMIN_PATH/admin.banbutton.php");
      $tpl->set("main_content",set_block($language["ACP_BB"],"center",$admintpl->fetch(load_template("admin.banbutton.tpl"))));
      break;

      case 'banbutton_user':
      include("$ADMIN_PATH/admin.banbutton_user.php");
      $tpl->set("main_content",set_block($language["ACP_BB_USER"],"center",$admintpl->fetch(load_template("admin.banbutton_user.tpl"))));
      break;
      
      case 'forum':
      include("$ADMIN_PATH/admin.forums.php");
      $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.forums.tpl"))));
      break;

      case 'masspm':
      include("$ADMIN_PATH/admin.masspm.php");
      $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.masspm.tpl"))));
      break;
      
      case 'lrb':
      include("$ADMIN_PATH/admin.lrb.php");
      $tpl->set("main_content",set_block($language["ACP_LRB"],"center",$admintpl->fetch(load_template("admin.lrb.tpl"))));
      break;
     
//sb control
      case 'sb_control':
      include("$ADMIN_PATH/admin.sb.php");
      $tpl->set("main_content",set_block($language["SB"],"center",$admintpl->fetch(load_template("admin.sb.tpl"))));
      break;
//sb control
     
      case 'where_heard':
      include("$ADMIN_PATH/admin.whereheard.php");
      $tpl->set("main_content",set_block($language["WHERE_HEARD"],"center",$admintpl->fetch(load_template("admin.whereheard.tpl"))));
      break;
     
      case 'pruneu':
      include("$ADMIN_PATH/admin.prune_users.php");
      $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.prune_users.tpl"))));
      break;
     
	case 'dbutil':
    include("$ADMIN_PATH/admin.dbutil.php");
    $tpl->set("main_content",set_block($language["DBUTILS_TABLES"]." ".$language["DBUTILS_STATUS"],"center",$admintpl->fetch(load_template("admin.dbutil.tpl"))));
    break;

    case 'logview':
    include("$ADMIN_PATH/admin.sitelog.php");
    $tpl->set("main_content",set_block($language["SITE_LOG"],"center",$admintpl->fetch(load_template("admin.sitelog.tpl"))));
    break;
	  
    case 'userstuff':
    include("$ADMIN_PATH/admin.stuff.php");
    $tpl->set("main_content",set_block($language["COOLYS_USERSTUFF"],"center",$admintpl->fetch(load_template("admin.stuff.tpl"))));
    break;
          
    case 'usersave':
    include("$ADMIN_PATH/admin.stuff.php");
    $tpl->set("main_content",set_block($language["COOLYS_USERSTUFF"],"center",$admintpl->fetch(load_template("admin.stuff.tpl"))));
    break;
    
    case 'mysql_stats':
    $content="";
    include("$ADMIN_PATH/admin.mysql_stats.php");
    $tpl->set("main_content",set_block($language["MYSQL_STATUS"],"center",$content));
    break;

    case 'prunet':
    include("$ADMIN_PATH/admin.prune_torrents.php");
    $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.prune_torrents.tpl"))));
    break;

    case 'groups':
    include("$ADMIN_PATH/admin.groups.php");
    $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.groups.tpl"))));
    break;
      
//login log hack
    case 'loglog':
    include("$ADMIN_PATH/admin.loglog.php");
    $tpl->set("main_content",set_block($language["ACP_LOGLOG"],"center",$admintpl->fetch(load_template("admin.loglog.tpl"))));
    break;
//login log hack
      
//hitrun
    case 'hitrun':
    include("$ADMIN_PATH/admin.hitrun.php");
    $tpl->set("main_content",set_block($language["ACP_HITRUN"],"center",$admintpl->fetch(load_template("admin.hitrun.tpl"))));
    break;
//end hitrun

//messagespy
    case 'ispy':
    include("$ADMIN_PATH/admin.ispy.php");
    $tpl->set("main_content",set_block($language["ACP_ISPY"],"center",$admintpl->fetch(load_template("admin.ispy.tpl"))));
    break;
//messagespy

    case 'freeleech_req':
    include("$ADMIN_PATH/admin.freeleech_req.php");
    $tpl->set("main_content",set_block($language["ACP_FREELEECH_REQ"],"center",$admintpl->fetch(load_template("admin.freeleech_req.tpl"))));
    break;
          
    case 'massemail':
    include("$ADMIN_PATH/admin.massemail.php");
    $tpl->set("main_content",set_block($language["ACP_MASSEMAIL"],"center",$admintpl->fetch(load_template("admin.massemail.tpl"))));
    break;
      
//flush
    case 'flush':
    include("$ADMIN_PATH/admin.flush.php");
    break;
//end flush

    case 'free':
    include("$ADMIN_PATH/admin.freecontrol.php");
    $tpl->set("main_content",set_block($language["ACP_FREECTRL"],"center",$admintpl->fetch(load_template("admin.freecontrol.tpl"))));
    break;
          
    case 'poller':
    include("$ADMIN_PATH/admin.polls.php");
    $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.polls.tpl"))));
    break;

    case 'badwords':
    include("$ADMIN_PATH/admin.censored.php");
    $tpl->set("main_content",set_block($language["ACP_CENSORED"],"center",$admintpl->fetch(load_template("admin.censored.tpl"))));
    break;

    case 'blocks':
    include("$ADMIN_PATH/admin.blocks.php");
    $tpl->set("main_content",set_block($language["BLOCKS_SETTINGS"],"center",$admintpl->fetch(load_template("admin.blocks.tpl"))));
    break;

    case 'featured':
    include("$ADMIN_PATH/admin.featured.php");
    $tpl->set("main_content",set_block($language["FEATURED_SETTINGS"],"center",$admintpl->fetch(load_template("admin.featured.tpl"))));
    break;

    case 'style':
    include("$ADMIN_PATH/admin.styles.php");
    $tpl->set("main_content",set_block($language["STYLE_SETTINGS"],"center",$admintpl->fetch(load_template("admin.styles.tpl"))));
    break;

    case 'category':
    include("$ADMIN_PATH/admin.categories.php");
    $tpl->set("main_content",set_block($language["CATEGORY_SETTINGS"],"center",$admintpl->fetch(load_template("admin.categories.tpl"))));
    break;

    case 'config':
    include("$ADMIN_PATH/admin.config.php");
    $tpl->set("main_content",set_block($language["TRACKER_SETTINGS"],"center",$admintpl->fetch(load_template("admin.config.tpl"))));
    break;

    case 'banip':
    include("$ADMIN_PATH/admin.banip.php");
    $tpl->set("main_content",set_block($language["ACP_BAN_IP"],"center",$admintpl->fetch(load_template("admin.banip.tpl"))));
    break;
      
    case 'module_config':
    include("$ADMIN_PATH/admin.module_config.php");
    $tpl->set("main_content",set_block($language["ACP_MODULES_CONFIG"],"center",$admintpl->fetch(load_template("admin.module_config.tpl"))));
    break;

    case 'hacks':
    include("$ADMIN_PATH/admin.hacks.php");
    $tpl->set("main_content",set_block($language["ACP_HACKS_CONFIG"],"center",$admintpl->fetch(load_template("admin.hacks.tpl"))));
    break;

    case 'users':
    include("$ADMIN_PATH/admin.users.tools.php");
    $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.users.tools.tpl"))));
    break;

    case 'block_cheapmail':
    include("$ADMIN_PATH/admin.pd-block_cheapmail.php");
    $tpl->set("main_content",set_block($language["BAN_CHEAPMAIL"],"center",$admintpl->fetch(load_template("admin.pd-block_cheapmail.tpl"))));
    break;

    case 'proxy':
    include("$ADMIN_PATH/admin.proxy.php");
    $tpl->set("main_content",set_block($language["ACP_PROXY"],"center",$admintpl->fetch(load_template("admin.proxy.tpl"))));
    break;

    case 'blacklist':
    include("$ADMIN_PATH/admin.blacklist.php");
    $tpl->set("main_content",set_block($language["ACP_BLACKLIST"],"center",$admintpl->fetch(load_template("admin.blacklist.tpl"))));
    break;
      
    case 'blackjack':
    include("$ADMIN_PATH/admin.blackjack.php");
    $tpl->set("main_content",set_block($language["BLACKJACK_ADMIN"],"center",$admintpl->fetch(load_template("admin.blackjack.tpl"))));
    break;

    case 'clients':
    include("$ADMIN_PATH/admin.clients.php");
    $tpl->set("main_content",set_block($language["ACP_CLIENTS"],"center",$admintpl->fetch(load_template("admin.clients.tpl"))));
    break;
	
	case 'banclient':
    include("$ADMIN_PATH/admin.ban_client.php");
    $tpl->set("main_content",set_block($language["BAN_CLIENT"],"center",$admintpl->fetch(load_template("admin.ban_client.tpl"))));
    break;
      
    case 'clearclientban':
    include("$ADMIN_PATH/admin.client_clearban.php");
    $tpl->set("main_content",set_block($language["REMOVE_CLIENTBAN"],"center",$admintpl->fetch(load_template("admin.client_clearban.tpl"))));
    break;    
	
	case 'lottery_settings':
    include("$ADMIN_PATH/admin.lottery.php");
    $tpl->set("main_content",set_block($language["LOTT_SETTINGS"],"center",$admintpl->fetch(load_template("admin.lottery.tpl"))));
    break;

    case 'view_selled_tickets':
    include("$ADMIN_PATH/admin.view_tickets.php");
    $tpl->set("main_content",set_block($language["ACP_SELLED_TICKETS"],"center",$admintpl->fetch(load_template("admin.view_tickets.tpl"))));
    break;    
	
	case 'birthday':
    include("$ADMIN_PATH/admin.birthday.php");
    $tpl->set("main_content",set_block($language["ACP_BIRTHDAY"],"center",$admintpl->fetch(load_template("admin.birthday.tpl"))));
    break;    
	
	case 'duplicates':
    include("$ADMIN_PATH/admin.duplicates.php");
    $tpl->set("main_content",set_block($language["DUPLICATES"],"center",$admintpl->fetch(load_template("admin.duplicates.tpl"))));
    break;
      
    case 'don_hist':
    include("$ADMIN_PATH/admin.don_hist.php");
    $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.don_hist.tpl"))));
    break;

    case 'don_edit':
    include("$ADMIN_PATH/admin.don_edit.php");
    $tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.don_edit.tpl"))));
    break;
      
    case 'donate':
    include("$ADMIN_PATH/admin.donate.php");
    $tpl->set("main_content",set_block($language["ACP_DONATE"],"center",$admintpl->fetch(load_template("admin.donate.tpl"))));
    break;
      
    case 'security_suite':
    include("$ADMIN_PATH/admin.security_suite.php");
    $tpl->set("main_content",set_block($language["ACP_SECSUI_SET"],"center",$admintpl->fetch(load_template("admin.security_suite.tpl"))));
    break;
	  
    case 'php_log':
    include("$ADMIN_PATH/admin.php_errors_log.php");
    $tpl->set("main_content",set_block($language["LOGS_PHP"],"center",$admintpl->fetch(load_template("admin.php_errors_log.tpl"))));
    break;

    case 'seedbonus':
    include("$ADMIN_PATH/admin.bonus.php");
    $tpl->set("main_content",set_block($language["ACP_SEEDBONUS"],"center",$admintpl->fetch(load_template("admin.bonus.tpl"))));
    break;
      
	case 'warn':
	include("$ADMIN_PATH/admin.warn.php");
	$tpl->set("main_content",set_block($block_title,"center",$admintpl->fetch(load_template("admin.warn.tpl"))));
	break;
	
	case 'smf_select':
    include("$ADMIN_PATH/admin.cats.forum.php");
    $tpl->set("main_content",set_block($language["ACP_CATFORUM_CONFIG"],"center",$admintpl->fetch(load_template("admin.cats.forum.tpl"))));
    break;
	  
	case 'sanity':
    require_once("$THIS_BASEPATH/include/sanity.php");

      $now = time();

      $res = do_sqlquery("SELECT last_time FROM {$TABLE_PREFIX}tasks WHERE task='sanity'");
      $row = mysqli_fetch_row($res);
      if (!$row)
          do_sqlquery("INSERT INTO {$TABLE_PREFIX}tasks (task, last_time) VALUES ('sanity',$now)");
      else
      {
        $ts = $row[0];
        do_sqlquery("UPDATE {$TABLE_PREFIX}tasks SET last_time=$now WHERE task='sanity' AND last_time = $ts");
      }
      do_sanity($ts);


    default:
      include("$ADMIN_PATH/admin.main.php");
      $tpl->set("main_content",set_block($language["WELCOME_ADMINCP"],"center",$admintpl->fetch(load_template("admin.main.tpl"))));
      break;

}
?>