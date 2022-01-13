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

if (!defined("IN_ACP"))
      die("non direct access!");

if ($moderate_user)
  {
    $admin_menu=array(
    0=>array(
            "title"=>$language["ACP_USERS_TOOLS"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=masspm&amp;action=write" ,
                    "description"=>$language["ACP_MASSPM"]),
                          1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=pruneu" ,
                    "description"=>$language["ACP_PRUNE_USERS"]),
                          2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=searchdiff" ,
                    "description"=>$language["ACP_SEARCH_DIFF"])
                    )
            ),
    );

}
else
  {
    $admin_menu=array(
    0=>array(
            "title"=>$language["ACP_TRACKER_SETTINGS"],
            "menu"=>array(
			        0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=config&amp;action=read" ,
                    "description"=>$language["ACP_TRACKER_SETTINGS"]),
                    
					1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=banip&amp;action=read" ,
                    "description"=>$language["ACP_BAN_IP"]),
                    
					12=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=banbutton&amp;action=read" ,
                    "description"=>$language["ACP_BB"]),
                    
					13=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=banbutton_user&amp;action=read" ,
                    "description"=>$language["ACP_BB_USER"]),
                    
					40=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=offline" ,
                    "description"=>$language["ACP_OFFLINE"]),

                    2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=language&amp;action=read" ,
                    "description"=>$language["ACP_LANGUAGES"]),
                    
                    14=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=teams" ,
                    "description"=>"Team Settings"),
                    
					15=> array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=team_users" ,
                    "description"=>"Team Users"),
                    
					3=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=free" ,
                    "description"=>$language["ACP_FREECTRL"]),
                    
                    4=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=style&amp;action=read" ,
                    "description"=>$language["ACP_STYLES"]),
                  	    
					90=>array(
	               "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=warn" ,
	                "description"=>$language["ACP_ADD_WARN"]),
                    
					37=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=birthday" ,
                    "description"=>$language["ACP_BIRTHDAY"]),
                    
					36=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=sb_control" ,
                    "description"=>$language["SB_CONTROL"]),
                    
					5=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=faq_group" ,
                    "description"=>$language["ACP_FAQ_GROUP"]),
                    
					6=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=faq_question" ,
                    "description"=>$language["ACP_FAQ_QUESTION"]),
                    
					7=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=seedbonus" ,
                    "description"=>$language["ACP_SEEDBONUS"]),
                    
					8=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=security_suite" ,
                    "description"=>$language["ACP_SECSUI_SET"]),
					
					9=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=php_log" ,
                    "description"=>$language["LOGS_PHP"])
                                 )),
    1=>array(
            "title"=>$language["ACP_FRONTEND"],
            "menu"=>array(
			        0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=category&amp;action=read" ,
                    "description"=>$language["ACP_CATEGORIES"]),
                          
					1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=poller&amp;action=read" ,
                    "description"=>$language["ACP_POLLS"]),
                          
					2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=badwords&amp;action=read" ,
                    "description"=>$language["ACP_CENSORED"]),
                          
					3=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=blocks&amp;action=read" ,
                    "description"=>$language["ACP_BLOCKS"]) ,
                         
					4=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=featured&amp;action=read" ,
                    "description"=>$language["ACP_FEATURED"]),
                    
					5=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=rules_cat" ,
                    "description"=>$language["ACP_RULES_GROUP"]),
                    
					6=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=rules" ,
                    "description"=>$language["ACP_RULES"])
                    
                    )
            ),
    2=>array(
            "title"=>$language["ACP_USERS_TOOLS"],
            "menu"=>array(
			        0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=groups&amp;action=read" ,
                    "description"=>$language["ACP_USER_GROUP"]),
                    
					54=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=proxy" ,
                    "description"=>$language["ACP_PROXY"]),
                    
					55=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=blacklist" ,
                    "description"=>$language["ACP_BLACKLIST"]),
                    
                    83=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=lrb" ,
                    "description"=>$language["ACP_LRB"]),
                    
                    96=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=where_heard" ,
                    "description"=>$language["WHERE_HEARD"]),
                    
                    1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=masspm&amp;action=write" ,
                    "description"=>$language["ACP_MASSPM"]),
                    
					45=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=loglog" ,
                    "description"=>$language["ACP_LOGLOG"]),
                    
                    58=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=connect" ,
                    "description"=>$language["ACP_CONNECT"]),
				    
					37=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=ispy" ,
                    "description"=>$language["ACP_ISPY"]),
                    
					16=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=comments" ,
                    "description"=>$language["ACP_COMMENTS"]),
                    
					21=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=massemail&amp;action=write" ,
                    "description"=>$language["ACP_MASSEMAIL"]),
                    
                    2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=pruneu" ,
                    "description"=>$language["ACP_PRUNE_USERS"]),
                          
					3=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=searchdiff" ,
                    "description"=>$language["ACP_SEARCH_DIFF"]),
		            
					43=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=newuser" ,
                    "description"=>$language["ACP_ADD_USER"]),
                    
					4=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=warned_users" ,
                    "description"=>"Warned users"),
                    
					17=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=userstuff" ,
                    "description"=>$language["ACP_MENU_COOLY"]),
                    
					94=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=uploader_control" ,
                    "description"=>$language["UP_CONTROL"]),
                    
					25=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=duplicates" ,
                    "description"=>$language["DUPLICATES"]),
                    
					26=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=duplicates_pas" ,
                    "description"=>$language["DUPLICATES_PAS"]),
					
					56=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=reputation" ,
                    "description"=>$language["REPUTATION"]),
                    
					57=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=reputation_list" ,
                    "description"=>$language["REPUTATION_LIST"]))
            ),

                3=>array(
                    "title"=>$language["ACP_TORRENTS_TOOLS"],
                    "menu"=>array(
					0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=prunet" ,
                    "description"=>$language["ACP_PRUNE_TORRENTS"]),
                     // hitrun
                    17=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=hitrun" ,
                    "description"=>$language["ACP_HITRUN"]),
                     // end hitrun
                    44=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=ratio-editor" ,
                    "description"=>$language["ACP_RATIO_EDITOR"]),
                    61=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=sb-editor" ,
                    "description"=>$language["ACP_SB_EDITOR"]),
                    63=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=ratio_fix" ,
                    "description"=>$language["RATIO_FIX"]),
                    // free leech req
                    42=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=freeleech_req" ,
                    "description"=>$language["ACP_FREELEECH_REQ"]),
                    19=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=calc" ,
                    "description"=>$language["ACP_MENU_CAT"]),
                    
					50=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=torrentsdump" ,
                    "description"=>'Torrent-dumper'),
                    
					2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=gold" ,
                    "description"=>$language["ACP_GOLD"]),
                    
					1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=sticky" ,
                    "description"=>$language["ACP_STICKY_TORRENTS"]))
            ),

    4=>array(
            "title"=>$language["ACP_FORUM"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=forum&amp;action=read" ,
                    "description"=>$language["ACP_FORUM"]),
						1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=smf_select" ,
                    "description"=>$language["ACP_CATFORUM_SELECT"])
                    )
            ),

    5=>array(
            "title"=>$language["ACP_OTHER_TOOLS"],
            "menu"=>array(
			        0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=dbutil" ,
                    "description"=>$language["ACP_DBUTILS"]),
                    
                    22=>array(
				   'url'=>'index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'&amp;do=kocs',
                    'description'=>$language['ACP_KOCS']),
                
                    9=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=don_hist" ,
                    "description"=>$language["ACP_DON_HIST"]) ,
                    
                    11=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=donate" ,
                    "description"=>$language["ACP_DONATE"]) ,
                    
                    19=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=read_messages" ,
                    "description"=>$language["ACP_MENU_SUPPORT"]),
                    
                    1=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=mysql_stats" ,
                    "description"=>$language["ACP_MYSQL_STATS"]),
                    
					2=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=logview" ,
                    "description"=>$language["ACP_SITE_LOG"]),
                    
					3=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=invitations" ,
                    "description"=>$language["ACP_INVITATIONS"]),
                    
					4=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=clients" ,
                    "description"=>$language["ACP_CLIENTS"]),
                    
					6=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=blackjack" ,
                    "description"=>$language["BLACKJACK_ADMIN"]),
                    
					7=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=cleanconfirm" ,
                    "description"=>$language["DEL_SHOUT"]),
                    
					5=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=lottery_settings" ,
                    "description"=>$language["ACP_LOTTERY"])
                    )
            ),
            
    6=>array(
            "title"=>$language["ACP_MODULES"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=module_config&amp;action=manage" ,
                    "description"=>$language["ACP_MODULES_CONFIG"])
                    )
            ),

    7=>array(
            "title"=>$language["ACP_HACKS"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=hacks&amp;action=read" ,
                    "description"=>$language["ACP_HACKS_CONFIG"])

                    )
            ),

    8=>array(
            "title"=>$language["ACP_OWNER"],
            "menu"=>array(0=>array(
                    "url"=>"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=time_control" ,
                    "description"=>$language["TIM"]),
                    1=>array(
                    "url"=>"acp_pw.php?logout=1" ,
                    "description"=>"Log Out ACP")
                    )
            ),



    );
}

$admin_menu[666]["title"]=$language["ACP_BOOTED"];
$admin_menu[666]["menu"][$i]["url"]="index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=booted_users";
$admin_menu[666]["menu"][$i]["description"]=$language["ACP_BOOTED1"];

// flush
$admin_menu[3]["menu"][35]["url"]="index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=flush";
$admin_menu[3]["menu"][35]["description"]=$language["ACP_FLUSH"];
// end flush


$admin_menu[(($moderate_user)?0:2)]["menu"][9999]["url"]="index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=block_cheapmail";
$admin_menu[(($moderate_user)?0:2)]["menu"][9999]["description"]=$language["BAN_CHEAPMAIL"];


$admin_menu[99]["title"]=$language["ACP_AUTORANK"];
$admin_menu[99]["menu"][0]["url"]="index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=autorank";
$admin_menu[99]["menu"][0]["description"]=$language["ACP_AUTORANK"];

?>