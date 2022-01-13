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

$admintpl->set("config_saved",false,true);
$admintpl->set("xbtt_error",false,true);

switch ($action)
    {
    case 'write':
      if ($_POST["write"]==$language["FRM_CONFIRM"])
        {

        $bj_stake=$btit_settings["bj_blackjack_stake"];
        $bj_bprize=$btit_settings["bj_blackjack_prize"];
        $bj_nprize=$btit_settings["bj_normal_prize"];



//$btit_settings=array();
        $btit_settings["name"]=$_POST["trackername"];
        $btit_settings["url"]=$_POST["trackerurl"];

        $btit_settings["announce"]=serialize(explode("\n",$_POST["tracker_announceurl"]));
        $btit_settings["email"]=$_POST["trackeremail"];
        $btit_settings["torrentdir"]=$_POST["torrentdir"];
        $btit_settings["external"]=isset($_POST["exttorrents"])?"true":"false";
	    $btit_settings["show_recommended"]=isset($_POST["show_recommended"])?"true":"false";
        $btit_settings["recommended"]=$_POST["recommended"];
  	  
        $btit_settings["gzip"]=isset($_POST["gzip_enabled"])?"true":"false";
        $btit_settings["debug"]=isset($_POST["show_debug"])?"true":"false";
        $btit_settings["disable_dht"]=isset($_POST["dht"])?"true":"false";
        $btit_settings["livestat"]=isset($_POST["livestat"])?"true":"false";
        $btit_settings["logactive"]=isset($_POST["logactive"])?"true":"false";
        $btit_settings["loghistory"]=isset($_POST["loghistory"])?"true":"false";
        $btit_settings["p_announce"]=isset($_POST["p_announce"])?"true":"false";
        $btit_settings["p_scrape"]=isset($_POST["p_scrape"])?"true":"false";
        $btit_settings["show_uploader"]=isset($_POST["show_uploader"])?"true":"false";
        $btit_settings["usepopup"]=isset($_POST["usepopup"])?"true":"false";
        $btit_settings["default_language"]=$_POST["default_langue"];
        $btit_settings["default_style"]=$_POST["default_style"];
        $btit_settings["default_charset"]=$_POST["default_charset"];
        $btit_settings["max_users"]=$_POST["maxusers"];
        if($btit_settings["max_torrents_per_page"]!=$_POST["ntorrents"])
        {
            $old_setting=$btit_settings["max_torrents_per_page"];
            $alter=true;
        }
        $btit_settings["max_torrents_per_page"]=$_POST["ntorrents"];
        $btit_settings["sanity_update"]=$_POST["sinterval"];
        $btit_settings["external_update"]=$_POST["uinterval"];
        $btit_settings["max_announce"]=$_POST["rinterval"];
        $btit_settings["min_announce"]=$_POST["mininterval"];
        $btit_settings["max_peers_per_announce"]=$_POST["maxpeers"];
        $btit_settings["dynamic"]=isset($_POST["dynamic"])?"true":"false";
        $btit_settings["nat"]=isset($_POST["nat"])?"true":"false";
        $btit_settings["persist"]=isset($_POST["persist"])?"true":"false";
        $btit_settings["allow_override_ip"]=isset($_POST["override"])?"true":"false";
        $btit_settings["countbyte"]=isset($_POST["countbyte"])?"true":"false";
        $btit_settings["peercaching"]=isset($_POST["peercaching"])?"true":"false";
        $btit_settings["maxpid_seeds"]=$_POST["maxseeds"];
        $btit_settings["maxpid_leech"]=$_POST["maxleech"];
        $btit_settings["validation"]=$_POST["validation"];
        $btit_settings["imagecode"]=isset($_POST["imagecode"])?"true":"false";
        $btit_settings["forum"]=$_POST["f_link"];
//arcade
        $btit_settings["arc_aw"]=$_POST["arc_aw"];
        $btit_settings["arc_sb"]=$_POST["arc_sb"];
        $btit_settings["arc_upl"]=$_POST["arc_upl"];
//arcade end

//google captcha
        $btit_settings["gcsw"]=$_POST["gcsw"];
        $btit_settings["gcsitk"]=$_POST["gcsitk"];
        $btit_settings["gcsekk"]=$_POST["gcsekk"];
//google captcha

//extra menu links
        $btit_settings["amenu"]=$_POST["amenu"];
        $btit_settings["bmenu"]=$_POST["bmenu"];
        $btit_settings["cmenu"]=$_POST["cmenu"];
        
        $btit_settings["dmenu"]=$_POST["dmenu"];
        $btit_settings["emenu"]=$_POST["emenu"];
        $btit_settings["fmenu"]=$_POST["fmenu"];
        
        $btit_settings["gmenu"]=$_POST["gmenu"];
        $btit_settings["hmenu"]=$_POST["hmenu"];
        $btit_settings["imenu"]=$_POST["imenu"];
        
        $btit_settings["jmenu"]=$_POST["jmenu"];
        $btit_settings["kmenu"]=$_POST["kmenu"];
        $btit_settings["lmenu"]=$_POST["lmenu"];
//extra menu links

// dox start
        $btit_settings["limit_dox"]=$_POST["limit_dox"];
        $btit_settings["dox_del"]=$_POST["dox_del"];
        $btit_settings["dox"]=$_POST["dox"];
        $btit_settings["ul"]=$_POST["ul"];
        $btit_settings["dl"]=$_POST["dl"];
        $btit_settings["dox_text"]=$_POST["dox_text"];
        $btit_settings["enable_dox"]=$_POST["enable_dox"];
//dox end

// dt login switch
        $btit_settings["log_sw_dt"]=$_POST["log_sw_dt"];
// dt login switch end

// ssl
        $btit_settings["ssl"]=$_POST["ssl"];
// ssl

// thank / comment
        $btit_settings["thco"]=$_POST["thco"];
        $btit_settings["owth"]=$_POST["owth"];
// thank / comment

// pie
        $btit_settings["pie"]=$_POST["pie"];
// pie

// support
        $btit_settings["supportsw"]=$_POST["supportsw"];
// support

// gallery
        $btit_settings["gallery"]=$_POST["gallery"];
// gallery

// dt cloud
        $btit_settings["cloud"]=$_POST["cloud"];
// dt cloud end

// block links in comments
        $btit_settings["cblock"]=$_POST["cblock"];
// block links in comments

// inactivity
        $btit_settings["logmin"]=$_POST["logmin"];
// inactivity

// sb to up
        $btit_settings["sbup"]=$_POST["sbup"];
// sb to up

// own ip
        $btit_settings["ownip"]=$_POST["ownip"];
// own ip

//v14 - v16 extra links
$btit_settings["tordayy"]=$_POST["tordayy"];
$btit_settings["subtitles"]=$_POST["subtitles"];
$btit_settings["offerr"]=$_POST["offerr"];
$btit_settings["helpdesk"]=$_POST["helpdesk"];
$btit_settings["bugs"]=$_POST["bugs"];
$btit_settings["blackjack"]=$_POST["blackjack"];
$btit_settings["teams"]=$_POST["teams"];
$btit_settings["aannn"]=$_POST["aannn"];
$btit_settings["imdbmenu"]=$_POST["imdbmenu"];
//v14 - v16 extra links

//collapse
        $btit_settings["colup"]=$_POST["colup"];
        $btit_settings["coldown"]=$_POST["coldown"];
//collapse

//low ratio ban
        $btit_settings["en_sys"]=$_POST["en_sys"];
        $btit_settings["dm_id"]=$_POST["dm_id"];
//low ratio ban   

//quiz
        $btit_settings["quiz"]=$_POST["quiz"];
        $btit_settings["quizp"]=$_POST["quizp"];
        $btit_settings["quizbon"]=$_POST["quizbon"];
//quiz  

//calender
        $btit_settings["caldt"]=$_POST["caldt"];
//calender         

//shitlist
        $btit_settings["slon"]=$_POST["slon"];
        $btit_settings["pm_shit"]=$_POST["pm_shit"];
        $btit_settings["pm_tekst"]=$_POST["pm_tekst"];
        $btit_settings["pms_tekst"]=$_POST["pms_tekst"];
        $btit_settings["demote"]=$_POST["demote"];
        $btit_settings["shit_group"]=$_POST["shit_group"];
        $btit_settings["shit_group_back"]=$_POST["shit_group_back"];
//shitlist end

// tag
        $btit_settings["tag"]=$_POST["tag"];
// tag

// torrent up
        $btit_settings["toup"]=$_POST["toup"];
        $btit_settings["touppr"]=$_POST["touppr"];
// torrent up

// torrent prune
        $btit_settings["autotprune"]=$_POST["autotprune"];
        $btit_settings["autotprundedays"]=$_POST["autotprundedays"];
// torrent prune

// slot machine   
        $btit_settings["sloton"]=$_POST["sloton"];     
// slot machine         

// last T scroller
        $btit_settings["lastsw"]=$_POST["lastsw"];
// last T scroller

// login image
        $btit_settings["logisw"]=$_POST["logisw"];
// login image

// del own account
        $btit_settings["delsw"]=$_POST["delsw"];
// del own account

// imdb extra
        $btit_settings["imdbt"]=$_POST["imdbt"];
        $btit_settings["imdbimg"]=$_POST["imdbimg"];
        $btit_settings["imdbbl"]=$_POST["imdbbl"];
        $btit_settings["imdbmh"]=$_POST["imdbmh"];
// imdb extra

// error
$btit_settings["error"]=$_POST["error"];
// error

// flood in comments
        $btit_settings["AFSW"]=$_POST["AFSW"];
        $btit_settings["AFP"]=$_POST["AFP"];
        $btit_settings["AFT"]=$_POST["AFT"];
// flood in comments        

// sb announce
        $btit_settings["sbone"]=$_POST["sbone"];
        $btit_settings["sbtwo"]=$_POST["sbtwo"];
        $btit_settings["sbdrie"]=$_POST["sbdrie"];
        $btit_settings["sbvier"]=$_POST["sbvier"];
// sb announce

// upload request
         $btit_settings["up_all"]=$_POST["up_all"];
         $btit_settings["up_id"]=$_POST["up_id"];
         $btit_settings["up_on"]=$_POST["up_on"];
// upload request        
        
// apply membership		
		 $btit_settings["apply_all"]=$_POST["apply_all"];
         $btit_settings["apply_id"]=$_POST["apply_id"];
         $btit_settings["apply_on"]=$_POST["apply_on"];
// apply membership	        
         
// acp
        $btit_settings["un1"]=$_POST["un1"];
        $btit_settings["un2"]=$_POST["un2"];
        $btit_settings["pw1"]=$_POST["pw1"];
        $btit_settings["pw2"]=$_POST["pw2"];
        $btit_settings["acp"]=$_POST["acp"];
// acp  

//v18
        $btit_settings["server"]=$_POST["server"];
        $btit_settings["pmdt"]=$_POST["pmdt"];
        $btit_settings["prepre"]=$_POST["prepre"];
//v18

        $btit_settings["speedsw"]=$_POST["speedsw"];       
         
// user images
        $btit_settings["uiswitch"]=$_POST["uiswitch"];
        $btit_settings["uion"]=$_POST["uion"];
        
        $btit_settings["p1"]=$_POST["p1"];
        $btit_settings["p2"]=$_POST["p2"];
        $btit_settings["p3"]=$_POST["p3"];
        $btit_settings["p4"]=$_POST["p4"];
        $btit_settings["p5"]=$_POST["p5"];
        $btit_settings["p6"]=$_POST["p6"];
        $btit_settings["p7"]=$_POST["p7"];
        $btit_settings["p8"]=$_POST["p8"];
        $btit_settings["p9"]=$_POST["p9"];
        $btit_settings["p10"]=$_POST["p10"];
        $btit_settings["p11"]=$_POST["p11"];
        $btit_settings["p12"]=$_POST["p12"];
        $btit_settings["p13"]=$_POST["p13"];
        $btit_settings["p14"]=$_POST["p14"];
        $btit_settings["p15"]=$_POST["p15"];
        $btit_settings["p16"]=$_POST["p16"];
        $btit_settings["p17"]=$_POST["p17"];
        
        $btit_settings["img_don"]=$_POST["img_don"];
        $btit_settings["text_don"]=$_POST["text_don"];
        $btit_settings["preen"]=$_POST["preen"];

        $btit_settings["img_donm"]=$_POST["img_donm"];
        $btit_settings["text_donm"]=$_POST["text_donm"];
        $btit_settings["prtwee"]=$_POST["prtwee"];

        $btit_settings["img_mal"]=$_POST["img_mal"];
        $btit_settings["text_mal"]=$_POST["text_mal"];
        $btit_settings["prdrie"]=$_POST["prdrie"];

        $btit_settings["img_fem"]=$_POST["img_fem"];
        $btit_settings["text_fem"]=$_POST["text_fem"];
        $btit_settings["prvier"]=$_POST["prvier"];

        $btit_settings["img_bir"]=$_POST["img_bir"];
        $btit_settings["text_bir"]=$_POST["text_bir"];
        $btit_settings["prvijf"]=$_POST["prvijf"];

        $btit_settings["img_bot"]=$_POST["img_bot"];
        $btit_settings["text_bot"]=$_POST["text_bot"];
        $btit_settings["przes"]=$_POST["przes"];

        $btit_settings["img_par"]=$_POST["img_par"];
        $btit_settings["text_par"]=$_POST["text_par"];
        $btit_settings["przeven"]=$_POST["przeven"];

        $btit_settings["img_ban"]=$_POST["img_ban"];
        $btit_settings["text_ban"]=$_POST["text_ban"];
        $btit_settings["pracht"]=$_POST["pracht"];

        $btit_settings["img_tru"]=$_POST["img_tru"];
        $btit_settings["text_tru"]=$_POST["text_tru"];
        $btit_settings["prnegen"]=$_POST["prnegen"];

        $btit_settings["img_trum"]=$_POST["img_trum"];
        $btit_settings["text_trum"]=$_POST["text_trum"];
        $btit_settings["prtien"]=$_POST["prtien"];

        $btit_settings["img_vip"]=$_POST["img_vip"];
        $btit_settings["text_vip"]=$_POST["text_vip"];
        $btit_settings["prelf"]=$_POST["prelf"];

        $btit_settings["img_vipm"]=$_POST["img_vipm"];
        $btit_settings["text_vipm"]=$_POST["text_vipm"];
        $btit_settings["prtwaalf"]=$_POST["prtwaalf"];

        $btit_settings["img_war"]=$_POST["img_war"];
        $btit_settings["text_war"]=$_POST["text_war"];
        $btit_settings["prdertien"]=$_POST["prdertien"];

        $btit_settings["img_sta"]=$_POST["img_sta"];
        $btit_settings["text_sta"]=$_POST["text_sta"];
        $btit_settings["prveertien"]=$_POST["prveertien"];

        $btit_settings["img_sys"]=$_POST["img_sys"];
        $btit_settings["text_sys"]=$_POST["text_sys"];
        $btit_settings["prvijftien"]=$_POST["prvijftien"];

        $btit_settings["img_fri"]=$_POST["img_fri"];
        $btit_settings["text_fri"]=$_POST["text_fri"];
        $btit_settings["przestien"]=$_POST["przestien"];

        $btit_settings["img_jun"]=$_POST["img_jun"];
        $btit_settings["text_jun"]=$_POST["text_jun"];
        $btit_settings["przeventien"]=$_POST["przeventien"];
// user images

        $btit_settings["pmpop"]=$_POST["pmpop"];

//irc
        $btit_settings["irc_server"]=$_POST["irc_server"];
        $btit_settings["irc_port"]=$_POST["irc_port"];
        $btit_settings["irc_channel"]=$_POST["irc_channel"];
        $btit_settings["irc_on"]=$_POST["irc_on"];
        $btit_settings["irc_lang"]=$_POST["irc_lang"];
//irc

        $btit_settings["staff_comment"]=$_POST["staff_comment"];
        $btit_settings["staff_comment_view"]=$_POST["staff_comment_view"];

// agree
        $btit_settings["ua_on"]=$_POST["ua_on"];
        $btit_settings["oa_one_text"]=$_POST["oa_one_text"];
        $btit_settings["oa_two_text"]=$_POST["oa_two_text"];
        $btit_settings["oa_three_text"]=$_POST["oa_three_text"];
        $btit_settings["oa_four_text"]=$_POST["oa_four_text"];
// agree end

        $btit_settings["imgsw"]=$_POST["imgsw"];
        
        $btit_settings["endtch"]=$_POST["endtch"];
        
        $btit_settings["orlydb"]=$_POST["orlydb"];
        
//event
        $btit_settings["event_sw"]=$_POST["event_sw"];
        $btit_settings["event"]=$_POST["event"];
        $btit_settings["event_day"]=$_POST["event_day"];
        $btit_settings["event_month"]=$_POST["event_month"];
//event end        

//referral
        $btit_settings["ref_on"]=$_POST["ref_on"];
        $btit_settings["ref_switch"]=$_POST["ref_switch"];
        $btit_settings["ref_gb"]=$_POST["ref_gb"];
        $btit_settings["ref_sb"]=$_POST["ref_sb"];
//referral end

// client comment
        $btit_settings["cl_on"]=$_POST["cl_on"];
        $btit_settings["cl_te"]=$_POST["cl_te"];
// client comment
                    
//banbutton
        $btit_settings["banbutton"]=$_POST["banbutton"];
        $btit_settings["bandays"]=$_POST["bandays"];
//banbutton end

        $btit_settings["nscroll"]=$_POST["nscroll"];
        $btit_settings["download_ratio"]=$_POST["download_ratio"];
        
// DT offer                    
        $btit_settings["offer"]=$_POST["offer"];
// DT offer

// DT shout bling                   
        $btit_settings["bling"]=$_POST["bling"];
// DT shout bling  

        $btit_settings["multie"]=$_POST["multie"];
        
// Upload lang 
        $btit_settings["customflag"]=$_POST["customflag"];
        $btit_settings["customlang"]=$_POST["customlang"];
        $btit_settings["customflaga"]=$_POST["customflaga"];
        $btit_settings["customlanga"]=$_POST["customlanga"];
        $btit_settings["customflagb"]=$_POST["customflagb"];
        $btit_settings["customlangb"]=$_POST["customlangb"];
        $btit_settings["customflagc"]=$_POST["customflagc"];
        $btit_settings["customlangc"]=$_POST["customlangc"];
        $btit_settings["uplang"]=$_POST["uplang"];
// Upload lang         
        
		$btit_settings["anonymous"]=$_POST["anonymous"];
        
        $btit_settings["ytv"]=$_POST["ytv"];
 
//registration hack
        $btit_settings["regi"]=$_POST["regi"];
        $btit_settings["regi_d"]=$_POST["regi_d"];
        $btit_settings["regi_t"]=$_POST["regi_t"];
//registration hack end


//torrent age hack
        $btit_settings["show_days"]=$_POST["show_days"];
        $btit_settings["child"]=$_POST["child"];
        $btit_settings["grown"]=$_POST["grown"];
        $btit_settings["old"]=$_POST["old"];
//torrent age hack end

        $btit_settings["timeout"]=$_POST["timeout"];
        $btit_settings["aann"]=$_POST["aann"];
        $btit_settings["autolot"]=$_POST["autolot"];
        $btit_settings["noteon"]=$_POST["noteon"];
        
//Google analitic
        $btit_settings["google"]=$_POST["google"]; 
		$btit_settings["googlesw"]=$_POST["googlesw"];         
//Google analitic        
                    
//high UL speed report
        $btit_settings["highspeed"]=$_POST["highspeed"];
        $btit_settings["highswitch"]=$_POST["highswitch"];
        $btit_settings["highonce"]=$_POST["highonce"];
//high UL speed report end

//simular in torrentlist
        $btit_settings["simtor"]=$_POST["simtor"];
        $btit_settings["simsw"]=$_POST["simsw"];
//simular in torrentlist

// DT magnet                    
        $btit_settings["magnet"]=$_POST["magnet"];
// DT magnet

// tor by day                    
        $btit_settings["torday"]=$_POST["torday"];
// tor by day

// DT uploader medailles
        $btit_settings["UPD"]=$_POST["UPD"];
        $btit_settings["UPG"]=$_POST["UPG"];
        $btit_settings["UPS"]=$_POST["UPS"];
        $btit_settings["UPB"]=$_POST["UPB"];
        $btit_settings["UPC"]=$_POST["UPC"];
// DT uploader medailles

        $btit_settings["dupip"]=$_POST["dupip"];
        
        $btit_settings["onav"]=$_POST["onav"];

        $btit_settings["uploff"]=$_POST["uploff"];

        $btit_settings["disclaim"]=$_POST["disclaim"];

        $btit_settings["nfosw"]=$_POST["nfosw"];
//rss        
        $btit_settings["srss"]=$_POST["srss"];
//rss
        
//dt shout        
        $btit_settings["shoutdt"]=$_POST["shoutdt"];
        $btit_settings["shoutdtav"]=$_POST["shoutdtav"];
        $btit_settings["shoutdtz"]=$_POST["shoutdtz"];
        $btit_settings["shoutline"]=$_POST["shoutline"];
        $btit_settings["shoutdel"]=$_POST["shoutdel"];
//dt shout
        
//Facebook login system
        $btit_settings["fesbappi"]=$_POST["fesbappi"];	
        $btit_settings["fesecret"]=$_POST["fesecret"];
        $btit_settings["fbadmin"]=$_POST["fbadmin"];
        $btit_settings["fbon"]=$_POST["fbon"];	
//Facebook login system end
                    
// vip torrent
        $btit_settings["vip_set"]=$_POST["vip_set"];
        $btit_settings["vip_get"]=$_POST["vip_get"];
        $btit_settings["vip_get_one"]=$_POST["vip_get_one"];
        $btit_settings["vip_tekst"]=$_POST["vip_tekst"];
        $btit_settings["vip_one"]=$_POST["vip_one"];
// vip torrent end

// auto torrent name                    
         $btit_settings["tornam"]=$_POST["tornam"];
// auto torrent name  

//donation historie hack
        $btit_settings["dh_unit"]=$_POST["dh_unit"];
        $btit_settings["dh_pm"]=$_POST["dh_pm"];
        $btit_settings["dh_text"]=$_POST["dh_text"];
//donation historie hack end

//adver hack
        $btit_settings["adver_top"]=$_POST["adver_top"];
        $btit_settings["adver_bot"]=$_POST["adver_bot"];
        $btit_settings["adver_top_on"]=$_POST["adver_top_on"];
        $btit_settings["adver_bot_on"]=$_POST["adver_bot_on"];
//adver hack end

        $btit_settings["menu"]=$_POST["menu"];

        $btit_settings["matrix"]=$_POST["matrix"];
                    
// request hack part 1
        $btit_settings["req_prune"]=$_POST["req_prune"];
        $btit_settings["req_page"]=$_POST["req_page"];
        $btit_settings["req_post"]=$_POST["req_post"];
        $btit_settings["req_shout"]=$_POST["req_shout"];
        $btit_settings["req_max"]=$_POST["req_max"];
        $btit_settings["req_maxon"]=$_POST["req_maxon"];
        $btit_settings["req_onoff"]=$_POST["req_onoff"];
        $btit_settings["req_number"]=$_POST["req_number"];
// request hack (reward)
        $btit_settings["req_sb"]=$_POST["req_sb"];
        $btit_settings["req_mb"]=$_POST["req_mb"];
        $btit_settings["req_rwon"]=$_POST["req_rwon"];
        $btit_settings["req_sbmb"]=$_POST["req_sbmb"];
//request hack part 1 + reward end

        $btit_settings["ipb_autoposter"]=((isset($_POST["ipb_autoposter"]) && !empty($_POST["ipb_autoposter"]))?(int)0+$_POST["ipb_autoposter"]:0);
        $btit_settings["clocktype"]=$_POST["clocktype"];
//hit & run
        $btit_settings["hitnumber"]=$_POST["hitnumber"];
        $btit_settings["scrol_tekst"]=$_POST["scrol_tekst"];
//hit & run end

//porn hack
        $btit_settings["porncat"]=$_POST["porncat"];
//porn hack end

//flush hack
        $btit_settings["ghost"]=$_POST["ghost"];
//flush hack end

// donate button in chat
        $btit_settings["don_chat"]=$_POST["don_chat"];
        $btit_settings["ran_chat"]=$_POST["ran_chat"];
        $btit_settings["fix_chat"]=$_POST["fix_chat"];
// donate button in chat end   

        $btit_settings["auto_feat"]=$_POST["auto_feat"];

// season
        $btit_settings["snow"]=$_POST["snow"];
        $btit_settings["halloween"]=$_POST["halloween"];
        $btit_settings["leafs"]=$_POST["leafs"];
        $btit_settings["flowers"]=$_POST["flowers"];
        $btit_settings["xmas"]=$_POST["xmas"];
        $btit_settings["valen"]=$_POST["valen"];
// season        

        $btit_settings["forumblocktype"]=$_POST["forumblocktype"];
        $btit_settings["newslimit"]=$_POST["newslimit"];
       
        $btit_settings["inv_login"]=$_POST["inv_login"];
        $btit_settings["att_login"]=$_POST["att_login"];
        $btit_settings["forumlimit"]=$_POST["forumlimit"];
        $btit_settings["last10limit"]=$_POST["last10limit"];


        $btit_settings["hide_language"]=$_POST["hide_language"];
        $btit_settings["hide_style"]=$_POST["hide_style"];
        $btit_settings["hide_sblocks"]=$_POST["hide_sblocks"];


        $btit_settings["autopruneusers"]=$_POST["autopruneusers"];
        $btit_settings["days_members"]=$_POST["days_members"];
        $btit_settings["days_not_comfirm"]=$_POST["days_not_comfirm"];
        $btit_settings["email_on_prune"]=$_POST["email_on_prune"];
        $btit_settings["days_to_email"]=$_POST["days_to_email"];


        $btit_settings["donate_upload"]=$_POST["donate_upload"];
        $btit_settings["unit"]=$_POST["unit"];
         

        $btit_settings["imageon"]=$_POST["imageon"];
        $btit_settings["screenon"]=$_POST["screenon"];
        $btit_settings["uploaddir"]=$_POST["uploaddir"];
        $btit_settings["file_limit"]=$_POST["file_limit"];


        $btit_settings["img_file_size"]=$_POST["img_file_size"];
        $btit_settings["img_size_width"]=$_POST["img_size_width"];
        $btit_settings["img_size_height"]=$_POST["img_size_height"];



        $btit_settings["bj_blackjack_stake"]=$bj_stake;
        $btit_settings["bj_blackjack_prize"]=$bj_bprize;
        $btit_settings["bj_normal_prize"]=$bj_nprize;

        if (isset($_POST["xbtt_use"]))
          {
// check base xbtt url
          if ($_POST["xbtt_url"]!="")
            {
// check if XBTT tables are present in current db
            $res=do_sqlquery("SHOW TABLES LIKE 'xbt%'");
            $xbt_tables=array('xbt_config','xbt_files','xbt_files_users','xbt_users');
            $xbt_in_db=array();
            if ($res)
               {
               while ($result=mysqli_fetch_row($res))
                     {
                         $xbt_in_db[]=$result[0];
                     }
             }
            $ad=array_diff($xbt_tables,$xbt_in_db);
// some xbtt tables missed!
            if (count($ad)!=0)
              {
               $btit_settings["xbtt_use"]="false";
               $admintpl->set("xbtt_error",true,true);
            }
            else
              {
              $btit_settings["xbtt_use"]="true";
              $admintpl->set("xbtt_error",false,true);
// save some settings into xbt_config table
              $xbt_cfg="('anonymous_announce','anonymous_scrape','announce_interval','auto_register')";
              do_sqlquery("DELETE FROM xbt_config WHERE name IN $xbt_cfg",true);
              do_sqlquery("INSERT INTO xbt_config (name,value) VALUES ".
               "('anonymous_announce','".($btit_settings["p_announce"]=="false"?1:0)."'),".
               "('anonymous_scrape','".($btit_settings["p_scrape"]=="false"?1:0)."'),".
               "('announce_interval','".$btit_settings["max_announce"]."'),".
               "('auto_register','0');",true);
// insert non exist torrent into xbt_files
              do_sqlquery("INSERT INTO xbt_files (info_hash, mtime, ctime) SELECT UNHEX(info_hash), unix_timestamp(), unix_timestamp() FROM {$TABLE_PREFIX}files WHERE UNHEX(info_hash) NOT IN (SELECT info_hash FROM xbt_files) AND external='no'",true);
// control missed field (latest xbt don't have torrent_pass field)
              $mf=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM $database.xbt_users");
             
              $tp_present=false;
              $tpv_present=false;
              for ($i=0;$i<mysqli_num_fields($mf);$i++)
                {
                  $fn=mysqli_fetch_field_direct($mf,$i)->name;
                  if ($fn=="torrent_pass")
                         $tp_present=true;
                  if ($fn=="torrent_pass_version")
                        $tpv_present=true;
              }
              if (!$tp_present)
                 do_sqlquery("ALTER TABLE xbt_users ADD torrent_pass CHAR(32) NOT NULL, ADD torrent_pass_secret bigint unsigned not null;",true);
              if ($tpv_present)
                 do_sqlquery("ALTER TABLE `xbt_users` CHANGE `torrent_pass_version` `torrent_pass_version` INT(11) NOT NULL DEFAULT '0'",true);

// insert missed users in xbt_users
              do_sqlquery("INSERT INTO xbt_users (uid, torrent_pass) SELECT id,pid FROM {$TABLE_PREFIX}users WHERE id NOT IN (SELECT uid FROM xbt_users)",true);
            }
          }
          else
          {
              $language["XBTT_TABLES_ERROR"]=$language["XBTT_URL_ERROR"];
              $btit_settings["xbtt_use"]="false";
              $admintpl->set("xbtt_error",true,true);
          }
        }
        else
        {
            $btit_settings["xbtt_use"]="false";
        }
        $btit_settings["xbtt_url"]=$_POST["xbtt_url"];
        $btit_settings["cache_duration"]=$_POST["cache_duration"];
        $btit_settings["cut_name"]=intval($_POST["cut_name"]);
	    $btit_settings["ticker_msg_1"]=$_POST["ticker_msg_1"];
        $btit_settings["ticker_msg_2"]=$_POST["ticker_msg_2"];
	    $btit_settings["ticker_msg_3"]=$_POST["ticker_msg_3"];
        $btit_settings["ticker_msg_4"]=$_POST["ticker_msg_4"];

        $btit_settings["mail_type"]=$_POST["mail_type"];
        if ($btit_settings["mail_type"]=="smtp")
          {
          $btit_settings["smtp_server"]=$_POST["smtp_server"];
          $btit_settings["smtp_port"]=$_POST["smtp_port"];
          $btit_settings["smtp_username"]=$_POST["smtp_username"];
          $btit_settings["smtp_password"]=$_POST["smtp_password"];
        }

        foreach($btit_settings as $key=>$value)
          {
              if (is_bool($value))
               $value==true ? $value='true' : $value='false';

            $values[]="(".sqlesc($key).",".sqlesc($value).")";
        }

//die(implode(",",$values));
        mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}settings") or stderr($language["ERROR"],((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}settings (`key`,`value`) VALUES ".implode(",",$values).";") or stderr($language["ERROR"],((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
// update guest values for language, style, torrentsxpage etc...
        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET language=".sqlesc($btit_settings["default_language"]).",
                            style=".sqlesc($btit_settings["default_style"]).",
                            torrentsperpage=".sqlesc($btit_settings["max_torrents_per_page"])." WHERE id=1") or stderr($language["ERROR"],((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

        if($alter===true)
        {
            mysqli_query($GLOBALS["___mysqli_ston"], "ALTER TABLE `{$TABLE_PREFIX}users` CHANGE `torrentsperpage` `torrentsperpage` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT ".sqlesc($btit_settings["max_torrents_per_page"]));
            mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `torrentsperpage`=".sqlesc($btit_settings["max_torrents_per_page"])." WHERE `torrentsperpage`=".sqlesc($old_setting));
        }

        unset($values);
        

        $admintpl->set("config_saved",true,true);
        }
// we don't break, so we will display the new config...

    case 'read':
    case '':
    default:
        $admintpl->set("language",$language);

        $btit_settings=get_fresh_config("SELECT `key`,`value` FROM {$TABLE_PREFIX}settings");

// some $btit_settings are stored in database, some other not like in template
// we will convert and set to correct value in the array.
        if (is_array(unserialize($btit_settings["announce"])))
        $btit_settings["announce"]=implode("\n",unserialize($btit_settings["announce"]));
        $btit_settings["external"]=($btit_settings["external"]=="true"?"checked=\"checked\"":"");
        $btit_settings["gzip"]=($btit_settings["gzip"]=="true"?"checked=\"checked\"":"");
        $btit_settings["debug"]=($btit_settings["debug"]=="true"?"checked=\"checked\"":"");
        $btit_settings["disable_dht"]=($btit_settings["disable_dht"]=="true"?"checked=\"checked\"":"");
        $btit_settings["livestat"]=($btit_settings["livestat"]=="true"?"checked=\"checked\"":"");
        $btit_settings["logactive"]=($btit_settings["logactive"]=="true"?"checked=\"checked\"":"");
        $btit_settings["loghistory"]=($btit_settings["loghistory"]=="true"?"checked=\"checked\"":"");
        $btit_settings["p_announce"]=($btit_settings["p_announce"]=="true"?"checked=\"checked\"":"");
        $btit_settings["show_recommended"]=($btit_settings["show_recommended"]=="true"?"checked=\"checked\"":"");

        $btit_settings["p_scrape"]=($btit_settings["p_scrape"]=="true"?"checked=\"checked\"":"");
        $btit_settings["show_uploader"]=($btit_settings["show_uploader"]=="true"?"checked=\"checked\"":"");
        $btit_settings["usepopup"]=($btit_settings["usepopup"]=="true"?"checked=\"checked\"":"");
        $btit_settings["dynamic"]=($btit_settings["dynamic"]=="true"?"checked=\"checked\"":"");
        $btit_settings["nat"]=($btit_settings["nat"]=="true"?"checked=\"checked\"":"");
        $btit_settings["persist"]=($btit_settings["persist"]=="true"?"checked=\"checked\"":"");
        $btit_settings["allow_override_ip"]=($btit_settings["allow_override_ip"]=="true"?"checked=\"checked\"":"");
        $btit_settings["countbyte"]=($btit_settings["countbyte"]=="true"?"checked=\"checked\"":"");
        $btit_settings["peercaching"]=($btit_settings["peercaching"]=="true"?"checked=\"checked\"":"");
        $btit_settings["imagecode"]=($btit_settings["imagecode"]=="true"?"checked=\"checked\"":"");
        $btit_settings["clockanalog"]=($btit_settings["clocktype"]?"checked=\"checked\"":"");
        $btit_settings["clockdigital"]=(!$btit_settings["clocktype"]?"checked=\"checked\"":"");
        $btit_settings["forumblockposts"]=($btit_settings["forumblocktype"]?"checked=\"checked\"":"");
        $btit_settings["forumblocktopics"]=(!$btit_settings["forumblocktype"]?"checked=\"checked\"":"");
        $btit_settings["xbtt_use"]=($btit_settings["xbtt_use"]=="true"?"checked=\"checked\"":"");

       
		$btit_settings["inv_loginyes"]=($btit_settings["inv_login"]?"checked=\"checked\"":"");
        $btit_settings["inv_loginno"]=(!$btit_settings["inv_login"]?"checked=\"checked\"":"");
        $btit_settings["autopruneusersyes"]=($btit_settings["autopruneusers"]?"checked=\"checked\"":"");
        $btit_settings["autopruneusersno"]=(!$btit_settings["autopruneusers"]?"checked=\"checked\"":"");
        $btit_settings["email_on_pruneyes"]=($btit_settings["email_on_prune"]?"checked=\"checked\"":"");
        $btit_settings["email_on_pruneno"]=(!$btit_settings["email_on_prune"]?"checked=\"checked\"":"");
        

        $btit_settings["imageonyes"]=($btit_settings["imageon"]?"checked=\"checked\"":"");
        $btit_settings["imageonno"]=(!$btit_settings["imageon"]?"checked=\"checked\"":"");
        $btit_settings["screenonyes"]=($btit_settings["screenon"]?"checked=\"checked\"":"");
        $btit_settings["screenonno"]=(!$btit_settings["screenon"]?"checked=\"checked\"":"");
        $btit_settings["uploffyes"]=($btit_settings["uploff"]?"checked=\"checked\"":"");
        $btit_settings["uploffno"]=(!$btit_settings["uploff"]?"checked=\"checked\"":"");
        $btit_settings["disclaimyes"]=($btit_settings["disclaim"]?"checked=\"checked\"":"");
        $btit_settings["disclaimno"]=(!$btit_settings["disclaim"]?"checked=\"checked\"":"");
        
// seasons
        $btit_settings["snowyes"]=($btit_settings["snow"]?"checked=\"checked\"":"");
        $btit_settings["snowno"]=(!$btit_settings["snow"]?"checked=\"checked\"":"");
        $btit_settings["halloweenyes"]=($btit_settings["halloween"]?"checked=\"checked\"":"");
        $btit_settings["halloweenno"]=(!$btit_settings["halloween"]?"checked=\"checked\"":"");   
		$btit_settings["leafsyes"]=($btit_settings["leafs"]?"checked=\"checked\"":"");
        $btit_settings["leafsno"]=(!$btit_settings["leafs"]?"checked=\"checked\"":"");
        $btit_settings["flowersyes"]=($btit_settings["flowers"]?"checked=\"checked\"":"");
        $btit_settings["flowersno"]=(!$btit_settings["flowers"]?"checked=\"checked\"":"");  
		$btit_settings["xmasyes"]=($btit_settings["xmas"]?"checked=\"checked\"":"");
        $btit_settings["xmasno"]=(!$btit_settings["xmas"]?"checked=\"checked\"":"");   
		$btit_settings["valenyes"]=($btit_settings["valen"]?"checked=\"checked\"":"");
        $btit_settings["valenno"]=(!$btit_settings["valen"]?"checked=\"checked\"":"");  
// seasons
           
//auto featured
        $btit_settings["auto_featyes"]=($btit_settings["auto_feat"]?"checked=\"checked\"":"");
        $btit_settings["auto_featno"]=(!$btit_settings["auto_feat"]?"checked=\"checked\"":"");
//auto featured

// gallery
        $btit_settings["galleryyes"]=($btit_settings["gallery"]?"checked=\"checked\"":"");
        $btit_settings["galleryno"]=(!$btit_settings["gallery"]?"checked=\"checked\"":"");
// gallery

// support
        $btit_settings["supportswyes"]=($btit_settings["supportsw"]?"checked=\"checked\"":"");
        $btit_settings["supportswno"]=(!$btit_settings["supportsw"]?"checked=\"checked\"":"");
// support

//extra menu links
        $btit_settings["amenuyes"]=($btit_settings["amenu"]?"checked=\"checked\"":"");
        $btit_settings["amenuno"]=(!$btit_settings["amenu"]?"checked=\"checked\"":"");
        $btit_settings["dmenuyes"]=($btit_settings["dmenu"]?"checked=\"checked\"":"");
        $btit_settings["dmenuno"]=(!$btit_settings["dmenu"]?"checked=\"checked\"":"");
        $btit_settings["gmenuyes"]=($btit_settings["gmenu"]?"checked=\"checked\"":"");
        $btit_settings["gmenuno"]=(!$btit_settings["gmenu"]?"checked=\"checked\"":"");
        $btit_settings["jmenuyes"]=($btit_settings["jmenu"]?"checked=\"checked\"":"");
        $btit_settings["jmenuno"]=(!$btit_settings["jmenu"]?"checked=\"checked\"":"");
//extra menu links

// sb to up
        $btit_settings["sbupyes"]=($btit_settings["sbup"]?"checked=\"checked\"":"");
        $btit_settings["sbupno"]=(!$btit_settings["sbup"]?"checked=\"checked\"":"");
 // sb to up

// thank / comment
        $btit_settings["thcoyes"]=($btit_settings["thco"]?"checked=\"checked\"":"");
        $btit_settings["thcono"]=(!$btit_settings["thco"]?"checked=\"checked\"":"");
        $btit_settings["owthyes"]=($btit_settings["owth"]?"checked=\"checked\"":"");
        $btit_settings["owthno"]=(!$btit_settings["owth"]?"checked=\"checked\"":"");
// thank / comment

//quiz
        $btit_settings["quizyes"]=($btit_settings["quiz"]?"checked=\"checked\"":"");
        $btit_settings["quizno"]=(!$btit_settings["quiz"]?"checked=\"checked\"":"");
        $btit_settings["quizpyes"]=($btit_settings["quizp"]?"checked=\"checked\"":"");
        $btit_settings["quizpno"]=(!$btit_settings["quizp"]?"checked=\"checked\"":"");
//quiz  

//calender
        $btit_settings["caldtyes"]=($btit_settings["caldt"]?"checked=\"checked\"":"");
        $btit_settings["caldtno"]=(!$btit_settings["caldt"]?"checked=\"checked\"":"");
//calender  

//pm popup
        $btit_settings["pmpopyes"]=($btit_settings["pmpop"]?"checked=\"checked\"":"");
        $btit_settings["pmpopno"]=(!$btit_settings["pmpop"]?"checked=\"checked\"":"");
//pm popup

//pie
        $btit_settings["pieyes"]=($btit_settings["pie"]?"checked=\"checked\"":"");
        $btit_settings["pieno"]=(!$btit_settings["pie"]?"checked=\"checked\"":"");
//pie

// last T scroller
        $btit_settings["lastswyes"]=($btit_settings["lastsw"]?"checked=\"checked\"":"");
        $btit_settings["lastswno"]=(!$btit_settings["lastsw"]?"checked=\"checked\"":"");
// last T scroller

//speed switch
        $btit_settings["speedswyes"]=($btit_settings["speedsw"]?"checked=\"checked\"":"");
        $btit_settings["speedswno"]=(!$btit_settings["speedsw"]?"checked=\"checked\"":"");
//speed switch

// error
        $btit_settings["erroryes"]=($btit_settings["error"]?"checked=\"checked\"":"");
        $btit_settings["errorno"]=(!$btit_settings["error"]?"checked=\"checked\"":"");
// error  

//google captcha
        $btit_settings["gcswyes"]=($btit_settings["gcsw"]?"checked=\"checked\"":"");
        $btit_settings["gcswno"]=(!$btit_settings["gcsw"]?"checked=\"checked\"":"");
//google captcha

// login image
        $btit_settings["logiswyes"]=($btit_settings["logisw"]?"checked=\"checked\"":"");
        $btit_settings["logiswno"]=(!$btit_settings["logisw"]?"checked=\"checked\"":"");
// login image

// imdb extra
        $btit_settings["imdbtyes"]=($btit_settings["imdbt"]?"checked=\"checked\"":"");
        $btit_settings["imdbtno"]=(!$btit_settings["imdbt"]?"checked=\"checked\"":"");
        $btit_settings["imdbimgyes"]=($btit_settings["imdbimg"]?"checked=\"checked\"":"");
        $btit_settings["imdbimgno"]=(!$btit_settings["imdbimg"]?"checked=\"checked\"":"");
        $btit_settings["imdbblyes"]=($btit_settings["imdbbl"]?"checked=\"checked\"":"");
        $btit_settings["imdbblno"]=(!$btit_settings["imdbbl"]?"checked=\"checked\"":"");
        $btit_settings["imdbmhyes"]=($btit_settings["imdbmh"]?"checked=\"checked\"":"");
        $btit_settings["imdbmhno"]=(!$btit_settings["imdbmh"]?"checked=\"checked\"":"");
// imdb extra

// user images
        $btit_settings["uiswitchyes"]=($btit_settings["uiswitch"]?"checked=\"checked\"":"");
        $btit_settings["uiswitchno"]=(!$btit_settings["uiswitch"]?"checked=\"checked\"":"");
        $btit_settings["uionyes"]=($btit_settings["uion"]?"checked=\"checked\"":"");
        $btit_settings["uionno"]=(!$btit_settings["uion"]?"checked=\"checked\"":"");
        $btit_settings["p1yes"]=($btit_settings["p1"]?"checked=\"checked\"":"");
        $btit_settings["p1no"]=(!$btit_settings["p1"]?"checked=\"checked\"":"");
        $btit_settings["p2yes"]=($btit_settings["p2"]?"checked=\"checked\"":"");
        $btit_settings["p2no"]=(!$btit_settings["p2"]?"checked=\"checked\"":"");
        $btit_settings["p3yes"]=($btit_settings["p3"]?"checked=\"checked\"":"");
        $btit_settings["p3no"]=(!$btit_settings["p3"]?"checked=\"checked\"":"");
        $btit_settings["p4yes"]=($btit_settings["p4"]?"checked=\"checked\"":"");
        $btit_settings["p4no"]=(!$btit_settings["p4"]?"checked=\"checked\"":"");
        $btit_settings["p5yes"]=($btit_settings["p5"]?"checked=\"checked\"":"");
        $btit_settings["p5no"]=(!$btit_settings["p5"]?"checked=\"checked\"":"");
        $btit_settings["p6yes"]=($btit_settings["p6"]?"checked=\"checked\"":"");
        $btit_settings["p6no"]=(!$btit_settings["p6"]?"checked=\"checked\"":"");
        $btit_settings["p7yes"]=($btit_settings["p7"]?"checked=\"checked\"":"");
        $btit_settings["p7no"]=(!$btit_settings["p7"]?"checked=\"checked\"":"");
        $btit_settings["p8yes"]=($btit_settings["p8"]?"checked=\"checked\"":"");
        $btit_settings["p8no"]=(!$btit_settings["p8"]?"checked=\"checked\"":"");
        $btit_settings["p9yes"]=($btit_settings["p9"]?"checked=\"checked\"":"");
        $btit_settings["p9no"]=(!$btit_settings["p9"]?"checked=\"checked\"":"");
        $btit_settings["p10yes"]=($btit_settings["p10"]?"checked=\"checked\"":"");
        $btit_settings["p10no"]=(!$btit_settings["p10"]?"checked=\"checked\"":"");
        $btit_settings["p11yes"]=($btit_settings["p11"]?"checked=\"checked\"":"");
        $btit_settings["p11no"]=(!$btit_settings["p11"]?"checked=\"checked\"":"");
        $btit_settings["p12yes"]=($btit_settings["p12"]?"checked=\"checked\"":"");
        $btit_settings["p12no"]=(!$btit_settings["p12"]?"checked=\"checked\"":"");
        $btit_settings["p13yes"]=($btit_settings["p13"]?"checked=\"checked\"":"");
        $btit_settings["p13no"]=(!$btit_settings["p13"]?"checked=\"checked\"":"");
        $btit_settings["p14yes"]=($btit_settings["p14"]?"checked=\"checked\"":"");
        $btit_settings["p14no"]=(!$btit_settings["p14"]?"checked=\"checked\"":"");
        $btit_settings["p15yes"]=($btit_settings["p15"]?"checked=\"checked\"":"");
        $btit_settings["p15no"]=(!$btit_settings["p15"]?"checked=\"checked\"":"");
        $btit_settings["p16yes"]=($btit_settings["p16"]?"checked=\"checked\"":"");
        $btit_settings["p16no"]=(!$btit_settings["p16"]?"checked=\"checked\"":"");
        $btit_settings["p17yes"]=($btit_settings["p17"]?"checked=\"checked\"":"");
        $btit_settings["p17no"]=(!$btit_settings["p17"]?"checked=\"checked\"":"");
// user images

//simular in torrentlist
        $btit_settings["simtoryes"]=($btit_settings["simtor"]?"checked=\"checked\"":"");
        $btit_settings["simtorno"]=(!$btit_settings["simtor"]?"checked=\"checked\"":"");
        $btit_settings["simswyes"]=($btit_settings["simsw"]?"checked=\"checked\"":"");
        $btit_settings["simswno"]=(!$btit_settings["simsw"]?"checked=\"checked\"":"");
//simular in torrentlist

//slot - torrent up
        $btit_settings["slotonyes"]=($btit_settings["sloton"]?"checked=\"checked\"":"");
        $btit_settings["slotonno"]=(!$btit_settings["sloton"]?"checked=\"checked\"":"");
        $btit_settings["toupyes"]=($btit_settings["toup"]?"checked=\"checked\"":"");
        $btit_settings["toupno"]=(!$btit_settings["toup"]?"checked=\"checked\"":"");
//slot - torrent up

//v18
        $btit_settings["serveryes"]=($btit_settings["server"]?"checked=\"checked\"":"");
        $btit_settings["serverno"]=(!$btit_settings["server"]?"checked=\"checked\"":"");
        $btit_settings["dtpmyes"]=($btit_settings["dtpm"]?"checked=\"checked\"":"");
        $btit_settings["dtpmno"]=(!$btit_settings["dtpm"]?"checked=\"checked\"":"");
        $btit_settings["prepreyes"]=($btit_settings["prepreon"]?"checked=\"checked\"":"");
        $btit_settings["prepreno"]=(!$btit_settings["prepreon"]?"checked=\"checked\"":"");
//v18

//collapse
        $btit_settings["colupyes"]=($btit_settings["colup"]?"checked=\"checked\"":"");
        $btit_settings["colupno"]=(!$btit_settings["colup"]?"checked=\"checked\"":"");
        $btit_settings["coldownyes"]=($btit_settings["coldown"]?"checked=\"checked\"":"");
        $btit_settings["coldownno"]=(!$btit_settings["coldown"]?"checked=\"checked\"":"");
//collapse

// block links in comments
        $btit_settings["cblockyes"]=($btit_settings["cblock"]?"checked=\"checked\"":"");
        $btit_settings["cblockno"]=(!$btit_settings["cblock"]?"checked=\"checked\"":"");
// block links in comments

//note
        $btit_settings["noteonyes"]=($btit_settings["noteon"]?"checked=\"checked\"":"");
        $btit_settings["noteonno"]=(!$btit_settings["noteon"]?"checked=\"checked\"":"");
//note

// apply membership	
        $btit_settings["apply_allyes"]=($btit_settings["apply_all"]?"checked=\"checked\"":"");
        $btit_settings["apply_allno"]=(!$btit_settings["apply_all"]?"checked=\"checked\"":"");
		$btit_settings["apply_onyes"]=($btit_settings["apply_on"]?"checked=\"checked\"":"");
        $btit_settings["apply_onno"]=(!$btit_settings["apply_on"]?"checked=\"checked\"":"");	
// apply membership	  

// flood in comments
        $btit_settings["AFSWyes"]=($btit_settings["AFSW"]?"checked=\"checked\"":"");
        $btit_settings["AFSWno"]=(!$btit_settings["AFSW"]?"checked=\"checked\"":"");
// flood in comments

// own ip
        $btit_settings["ownipyes"]=($btit_settings["ownip"]?"checked=\"checked\"":"");
        $btit_settings["ownipno"]=(!$btit_settings["ownip"]?"checked=\"checked\"":"");
// own ip

        $btit_settings["endtchyes"]=($btit_settings["endtch"]?"checked=\"checked\"":"");
        $btit_settings["endtchno"]=(!$btit_settings["endtch"]?"checked=\"checked\"":"");
		$btit_settings["orlydbyes"]=($btit_settings["orlydb"]?"checked=\"checked\"":"");
        $btit_settings["orlydbno"]=(!$btit_settings["orlydb"]?"checked=\"checked\"":"");

//v14 - v16 extra links
        $btit_settings["tordayyyes"]=($btit_settings["tordayy"]?"checked=\"checked\"":"");
        $btit_settings["tordayyno"]=(!$btit_settings["tordayy"]?"checked=\"checked\"":"");
        $btit_settings["subtitlesyes"]=($btit_settings["subtitles"]?"checked=\"checked\"":"");
        $btit_settings["subtitlesno"]=(!$btit_settings["subtitles"]?"checked=\"checked\"":"");
        
        $btit_settings["offerryes"]=($btit_settings["offerr"]?"checked=\"checked\"":"");
        $btit_settings["offerrno"]=(!$btit_settings["offerr"]?"checked=\"checked\"":"");
        $btit_settings["helpdeskyes"]=($btit_settings["helpdesk"]?"checked=\"checked\"":"");
        $btit_settings["helpdeskno"]=(!$btit_settings["helpdesk"]?"checked=\"checked\"":"");
        
        $btit_settings["bugsyes"]=($btit_settings["bugs"]?"checked=\"checked\"":"");
        $btit_settings["bugsno"]=(!$btit_settings["bugs"]?"checked=\"checked\"":"");
        $btit_settings["blackjackyes"]=($btit_settings["blackjack"]?"checked=\"checked\"":"");
        $btit_settings["blackjackno"]=(!$btit_settings["blackjack"]?"checked=\"checked\"":"");
        
        $btit_settings["teamsyes"]=($btit_settings["teams"]?"checked=\"checked\"":"");
        $btit_settings["teamsno"]=(!$btit_settings["teams"]?"checked=\"checked\"":"");
        $btit_settings["aannnyes"]=($btit_settings["aannn"]?"checked=\"checked\"":"");
        $btit_settings["aannnno"]=(!$btit_settings["aannn"]?"checked=\"checked\"":"");
        
        $btit_settings["imdbmenuyes"]=($btit_settings["imdbmenu"]?"checked=\"checked\"":"");
        $btit_settings["imdbmenuno"]=(!$btit_settings["imdbmenu"]?"checked=\"checked\"":"");
//v14 - v16 extra links

//Google analitic
        $btit_settings["googleswyes"]=($btit_settings["googlesw"]?"checked=\"checked\"":"");
        $btit_settings["googleswno"]=(!$btit_settings["googlesw"]?"checked=\"checked\"":"");       
//Google analitic        
                    
//cloud
        $btit_settings["cloudyes"]=($btit_settings["cloud"]?"checked=\"checked\"":"");
        $btit_settings["cloudno"]=(!$btit_settings["cloud"]?"checked=\"checked\"":"");
//cloud

        $btit_settings["imgswyes"]=($btit_settings["imgsw"]?"checked=\"checked\"":"");
        $btit_settings["imgswno"]=(!$btit_settings["imgsw"]?"checked=\"checked\"":"");

//acp
        $btit_settings["acpyes"]=($btit_settings["acp"]?"checked=\"checked\"":"");
        $btit_settings["acpno"]=(!$btit_settings["acp"]?"checked=\"checked\"":"");
//acp

//dox
        $btit_settings["doxyes"]=($btit_settings["dox"]?"checked=\"checked\"":"");
        $btit_settings["doxno"]=(!$btit_settings["dox"]?"checked=\"checked\"":"");
        $btit_settings["enable_doxyes"]=($btit_settings["enable_dox"]?"checked=\"checked\"":"");
        $btit_settings["enable_doxno"]=(!$btit_settings["enable_dox"]?"checked=\"checked\"":"");
//dox

//low ratio ban
            $btit_settings["en_sysyes"]=($btit_settings["en_sys"]?"checked=\"checked\"":"");
            $btit_settings["en_sysno"]=(!$btit_settings["en_sys"]?"checked=\"checked\"":"");
//low ratio ban

//tag
        $btit_settings["tagyes"]=($btit_settings["tag"]?"checked=\"checked\"":"");
        $btit_settings["tagno"]=(!$btit_settings["tag"]?"checked=\"checked\"":"");
//tag

//sb bling
        $btit_settings["blingyes"]=($btit_settings["bling"]?"checked=\"checked\"":"");
        $btit_settings["blingno"]=(!$btit_settings["bling"]?"checked=\"checked\"":"");
//sb bling

// inactivity
        $btit_settings["logminyes"]=($btit_settings["logmin"]?"checked=\"checked\"":"");
        $btit_settings["logminno"]=(!$btit_settings["logmin"]?"checked=\"checked\"":"");
// inactivity

// ssl
        $btit_settings["sslyes"]=($btit_settings["ssl"]?"checked=\"checked\"":"");
        $btit_settings["sslno"]=(!$btit_settings["ssl"]?"checked=\"checked\"":"");
// ssl

//uplang
        $btit_settings["uplangyes"]=($btit_settings["uplang"]?"checked=\"checked\"":"");
        $btit_settings["uplangno"]=(!$btit_settings["uplang"]?"checked=\"checked\"":"");
//uplang

//event
        $btit_settings["event_swyes"]=($btit_settings["event_sw"]?"checked=\"checked\"":"");
        $btit_settings["event_swno"]=(!$btit_settings["event_sw"]?"checked=\"checked\"":"");
//event

// del own account
        $btit_settings["delswyes"]=($btit_settings["delsw"]?"checked=\"checked\"":"");
        $btit_settings["delswno"]=(!$btit_settings["delsw"]?"checked=\"checked\"":"");
// del own account

//nfo
        $btit_settings["nfoswyes"]=($btit_settings["nfosw"]?"checked=\"checked\"":"");
        $btit_settings["nfoswno"]=(!$btit_settings["nfosw"]?"checked=\"checked\"":"");
//nfo

        $btit_settings["up_allyes"]=($btit_settings["up_all"]?"checked=\"checked\"":"");
        $btit_settings["up_allno"]=(!$btit_settings["up_all"]?"checked=\"checked\"":"");
        $btit_settings["up_onyes"]=($btit_settings["up_on"]?"checked=\"checked\"":"");
        $btit_settings["up_onno"]=(!$btit_settings["up_on"]?"checked=\"checked\"":"");

//rss
        $btit_settings["srssyes"]=($btit_settings["srss"]?"checked=\"checked\"":"");
        $btit_settings["srssno"]=(!$btit_settings["srss"]?"checked=\"checked\"":"");
//rss

//youtube video
        $btit_settings["ytvyes"]=($btit_settings["ytv"]?"checked=\"checked\"":"");
        $btit_settings["ytvno"]=(!$btit_settings["ytv"]?"checked=\"checked\"":"");
//youtube video

//online
        $btit_settings["onavyes"]=($btit_settings["onav"]?"checked=\"checked\"":"");
        $btit_settings["onavno"]=(!$btit_settings["onav"]?"checked=\"checked\"":"");
//online

//shitlist
        $btit_settings["slonyes"]=($btit_settings["slon"]?"checked=\"checked\"":"");
        $btit_settings["slonno"]=(!$btit_settings["slon"]?"checked=\"checked\"":"");
        $btit_settings["pm_shityes"]=($btit_settings["pm_shit"]?"checked=\"checked\"":"");
        $btit_settings["pm_shitno"]=(!$btit_settings["pm_shit"]?"checked=\"checked\"":"");
        $btit_settings["demoteyes"]=($btit_settings["demote"]?"checked=\"checked\"":"");
        $btit_settings["demoteno"]=(!$btit_settings["demote"]?"checked=\"checked\"":"");
//shitlist end

//Facebook login system
        $btit_settings["fbadminyes"]=($btit_settings["fbadmin"]?"checked=\"checked\"":"");
        $btit_settings["fbadminno"]=(!$btit_settings["fbadmin"]?"checked=\"checked\"":"");
        $btit_settings["fbonyes"]=($btit_settings["fbon"]?"checked=\"checked\"":"");
        $btit_settings["fbonno"]=(!$btit_settings["fbon"]?"checked=\"checked\"":"");
//Facebook login system end

// torrent prune
        $btit_settings["autotpruneyes"]=($btit_settings["autotprune"]?"checked=\"checked\"":"");
        $btit_settings["autotpruneno"]=(!$btit_settings["autotprune"]?"checked=\"checked\"":"");
        $btit_settings["autotprundedaysyes"]=($btit_settings["autotprundedays"]?"checked=\"checked\"":"");
        $btit_settings["autotprundedaysno"]=(!$btit_settings["autotprundedays"]?"checked=\"checked\"":"");
// torrent prune

// donate button in chat
        $btit_settings["ran_chatyes"]=($btit_settings["ran_chat"]?"checked=\"checked\"":"");
        $btit_settings["ran_chatno"]=(!$btit_settings["ran_chat"]?"checked=\"checked\"":"");
// donate button in chat end

// magnet
		$btit_settings["magnetyes"]=($btit_settings["magnet"]?"checked=\"checked\"":"");
        $btit_settings["magnetno"]=(!$btit_settings["magnet"]?"checked=\"checked\"":"");  
// magnet

// tor by day
		$btit_settings["tordayyes"]=($btit_settings["torday"]?"checked=\"checked\"":"");
        $btit_settings["tordayno"]=(!$btit_settings["torday"]?"checked=\"checked\"":"");  
// tor by day

// irc
		$btit_settings["irc_onyes"]=($btit_settings["irc_on"]?"checked=\"checked\"":"");
        $btit_settings["irc_onno"]=(!$btit_settings["irc_on"]?"checked=\"checked\"":"");  
// irc

// client comment
		$btit_settings["cl_onyes"]=($btit_settings["cl_on"]?"checked=\"checked\"":"");
        $btit_settings["cl_onno"]=(!$btit_settings["cl_on"]?"checked=\"checked\"":"");  
// client comment

// dt shout
		$btit_settings["shoutdtyes"]=($btit_settings["shoutdt"]?"checked=\"checked\"":"");
        $btit_settings["shoutdtno"]=(!$btit_settings["shoutdt"]?"checked=\"checked\"":"");  
        $btit_settings["shoutdtavyes"]=($btit_settings["shoutdtav"]?"checked=\"checked\"":"");
        $btit_settings["shoutdtavno"]=(!$btit_settings["shoutdtav"]?"checked=\"checked\"":"");  
        $btit_settings["shoutdtzyes"]=($btit_settings["shoutdtz"]?"checked=\"checked\"":"");
        $btit_settings["shoutdtzno"]=(!$btit_settings["shoutdtz"]?"checked=\"checked\"":"");  
        $btit_settings["shoutdelyes"]=($btit_settings["shoutdel"]?"checked=\"checked\"":"");
        $btit_settings["shoutdelno"]=(!$btit_settings["shoutdel"]?"checked=\"checked\"":""); 
// dt shout

// auto torrent name                    
		$btit_settings["tornamyes"]=($btit_settings["tornam"]?"checked=\"checked\"":"");
        $btit_settings["tornamno"]=(!$btit_settings["tornam"]?"checked=\"checked\"":"");  
// auto torrent name  
        
//menu switch
        $btit_settings["menuyes"]=($btit_settings["menu"]?"checked=\"checked\"":"");
        $btit_settings["menuno"]=(!$btit_settings["menu"]?"checked=\"checked\"":"");
//menu switch end

//anonymous
        $btit_settings["anonymousyes"]=($btit_settings["anonymous"]?"checked=\"checked\"":"");
        $btit_settings["anonymousno"]=(!$btit_settings["anonymous"]?"checked=\"checked\"":"");
//anonymous end

//matrix
        $btit_settings["matrixyes"]=($btit_settings["matrix"]?"checked=\"checked\"":"");
        $btit_settings["matrixno"]=(!$btit_settings["matrix"]?"checked=\"checked\"":"");
//matrix end
            
//adver hack
        $btit_settings["adver_top_onyes"]=($btit_settings["adver_top_on"]?"checked=\"checked\"":"");
        $btit_settings["adver_top_onno"]=(!$btit_settings["adver_top_on"]?"checked=\"checked\"":"");
        $btit_settings["adver_bot_onyes"]=($btit_settings["adver_bot_on"]?"checked=\"checked\"":"");
        $btit_settings["adver_bot_onno"]=(!$btit_settings["adver_bot_on"]?"checked=\"checked\"":"");
//adver hack end

//sb announce
        $btit_settings["sboneyes"]=($btit_settings["sbone"]?"checked=\"checked\"":"");
        $btit_settings["sboneno"]=(!$btit_settings["sbone"]?"checked=\"checked\"":"");
        $btit_settings["sbtwoyes"]=($btit_settings["sbtwo"]?"checked=\"checked\"":"");
        $btit_settings["sbtwono"]=(!$btit_settings["sbtwo"]?"checked=\"checked\"":"");
        $btit_settings["sbdrieyes"]=($btit_settings["sbdrie"]?"checked=\"checked\"":"");
        $btit_settings["sbdrieno"]=(!$btit_settings["sbdrie"]?"checked=\"checked\"":"");
        $btit_settings["sbvieryes"]=($btit_settings["sbvier"]?"checked=\"checked\"":"");
        $btit_settings["sbvierno"]=(!$btit_settings["sbvier"]?"checked=\"checked\"":"");
//sb announce
            
        $btit_settings["nscrollyes"]=($btit_settings["nscroll"]?"checked=\"checked\"":"");
        $btit_settings["nscrollno"]=(!$btit_settings["nscroll"]?"checked=\"checked\"":"");
            
        $btit_settings["autolotyes"]=($btit_settings["autolot"]?"checked=\"checked\"":"");
        $btit_settings["autolotno"]=(!$btit_settings["autolot"]?"checked=\"checked\"":"");

//auto announce
        $btit_settings["aannyes"]=($btit_settings["aann"]?"checked=\"checked\"":"");
        $btit_settings["aannno"]=(!$btit_settings["aann"]?"checked=\"checked\"":"");
//auto announce end
            
        $btit_settings["dupipyes"]=($btit_settings["dupip"]?"checked=\"checked\"":"");
        $btit_settings["dupipno"]=(!$btit_settings["dupip"]?"checked=\"checked\"":"");
            
//referral
        $btit_settings["ref_onyes"]=($btit_settings["ref_on"]?"checked=\"checked\"":"");
        $btit_settings["ref_onno"]=(!$btit_settings["ref_on"]?"checked=\"checked\"":"");
        $btit_settings["ref_switchyes"]=($btit_settings["ref_switch"]?"checked=\"checked\"":"");
        $btit_settings["ref_switchno"]=(!$btit_settings["ref_switch"]?"checked=\"checked\"":"");
//referral end
        
// request hack part 2

        $btit_settings["req_rwonyes"]=($btit_settings["req_rwon"]?"checked=\"checked\"":"");
        $btit_settings["req_rwonno"]=(!$btit_settings["req_rwon"]?"checked=\"checked\"":"");
        $btit_settings["req_sbmbyes"]=($btit_settings["req_sbmb"]?"checked=\"checked\"":"");
        $btit_settings["req_sbmbno"]=(!$btit_settings["req_sbmb"]?"checked=\"checked\"":"");
        $btit_settings["req_shoutyes"]=($btit_settings["req_shout"]?"checked=\"checked\"":"");
        $btit_settings["req_shoutno"]=(!$btit_settings["req_shout"]?"checked=\"checked\"":"");
        $btit_settings["req_onoffyes"]=($btit_settings["req_onoff"]?"checked=\"checked\"":"");
        $btit_settings["req_onoffno"]=(!$btit_settings["req_onoff"]?"checked=\"checked\"":"");
        $btit_settings["req_maxonyes"]=($btit_settings["req_maxon"]?"checked=\"checked\"":"");
        $btit_settings["req_maxonno"]=(!$btit_settings["req_maxon"]?"checked=\"checked\"":"");
// request hack part 2 end

//donation historie
        $btit_settings["dh_unityes"]=($btit_settings["dh_unit"]?"checked=\"checked\"":"");
        $btit_settings["dh_unitno"]=(!$btit_settings["dh_unit"]?"checked=\"checked\"":"");
        $btit_settings["dh_pmyes"]=($btit_settings["dh_pm"]?"checked=\"checked\"":"");
        $btit_settings["dh_pmno"]=(!$btit_settings["dh_pm"]?"checked=\"checked\"":"");
//donation historie end
                    
// vip torrent
        $btit_settings["vip_oneyes"]=($btit_settings["vip_one"]?"checked=\"checked\"":"");
        $btit_settings["vip_oneno"]=(!$btit_settings["vip_one"]?"checked=\"checked\"":"");
// vip torrent end

// DT uploader medailles
        $btit_settings["UPCyes"]=($btit_settings["UPC"]?"checked=\"checked\"":"");
        $btit_settings["UPCno"]=(!$btit_settings["UPC"]?"checked=\"checked\"":"");
// DT uploader medailles
                    
// high UL speed report
        $btit_settings["highswitchyes"]=($btit_settings["highswitch"]?"checked=\"checked\"":"");
        $btit_settings["highswitchno"]=(!$btit_settings["highswitch"]?"checked=\"checked\"":"");
        $btit_settings["highonceyes"]=($btit_settings["highonce"]?"checked=\"checked\"":"");
        $btit_settings["highonceno"]=(!$btit_settings["highonce"]?"checked=\"checked\"":"");
// high UL speed report end

//torrent age hack
        $btit_settings["show_daysyes"]=($btit_settings["show_days"]?"checked=\"checked\"":"");
        $btit_settings["show_daysno"]=(!$btit_settings["show_days"]?"checked=\"checked\"":"");
//torrent age hack

//registration hack
        $btit_settings["regiyes"]=($btit_settings["regi"]?"checked=\"checked\"":"");
        $btit_settings["regino"]=(!$btit_settings["regi"]?"checked=\"checked\"":"");
//registration hack end

// Agree
        $btit_settings["ua_onyes"]=($btit_settings["ua_on"]?"checked=\"checked\"":"");
        $btit_settings["ua_onno"]=(!$btit_settings["ua_on"]?"checked=\"checked\"":"");
// Agree end
                    
//arcade hack
        $btit_settings["arc_awyes"]=($btit_settings["arc_aw"]?"checked=\"checked\"":"");
        $btit_settings["arc_awno"]=(!$btit_settings["arc_aw"]?"checked=\"checked\"":"");
//arcade hack end

// language dropdown
        $lres=language_list();
        $btit_settings["language_combo"]=("\n<select name=\"default_langue\" size=\"1\">");
        foreach($lres as $langue)
          {
            $btit_settings["language_combo"].="\n<option ";
            if ($langue["id"]==$btit_settings["default_language"])
               $btit_settings["language_combo"].="selected=\"selected\" ";
            $btit_settings["language_combo"].="value=\"".$langue["id"]."\">".$langue["language"]."</option>";
            $btit_settings["language_combo"].=($option);
          }
        $btit_settings["language_combo"].=("\n</select>\n");
        unset($lres);
// charset
        $btit_settings["charset_combo"]="\n<select name=\"default_charset\" size=\"1\">";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-1"?" selected=\"selected\"":"").">ISO-8859-1</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-2"?" selected=\"selected\"":"").">ISO-8859-2</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-3"?" selected=\"selected\"":"").">ISO-8859-3</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-4"?" selected=\"selected\"":"").">ISO-8859-4</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-5"?" selected=\"selected\"":"").">ISO-8859-5</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-6"?" selected=\"selected\"":"").">ISO-8859-6</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-6-e"?" selected=\"selected\"":"").">ISO-8859-6-e</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-6-i"?" selected=\"selected\"":"").">ISO-8859-6-i</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-7"?" selected=\"selected\"":"").">ISO-8859-7</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-8"?" selected=\"selected\"":"").">ISO-8859-8</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-8-e"?" selected=\"selected\"":"").">ISO-8859-8-e</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-8-i"?" selected=\"selected\"":"").">ISO-8859-8-i</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-9"?" selected=\"selected\"":"").">ISO-8859-9</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-10"?" selected=\"selected\"":"").">ISO-8859-10</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-13"?" selected=\"selected\"":"").">ISO-8859-13</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-14"?" selected=\"selected\"":"").">ISO-8859-14</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-8859-15"?" selected=\"selected\"":"").">ISO-8859-15</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="UTF-8"?" selected=\"selected\"":"").">UTF-8</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="ISO-2022-JP"?" selected=\"selected\"":"").">ISO-2022-JP</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="EUC-JP"?" selected=\"selected\"":"").">EUC-JP</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="Shift_JIS"?" selected=\"selected\"":"").">Shift_JIS</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="GB2312"?" selected=\"selected\"":"").">GB2312</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="Big5"?" selected=\"selected\"":"").">Big5</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="EUC-KR"?" selected=\"selected\"":"").">EUC-KR</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="windows-1250"?" selected=\"selected\"":"").">windows-1250</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="windows-1251"?" selected=\"selected\"":"").">windows-1251</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="windows-1252"?" selected=\"selected\"":"").">windows-1252</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="windows-1253"?" selected=\"selected\"":"").">windows-1253</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="windows-1254"?" selected=\"selected\"":"").">windows-1254</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="windows-1255"?" selected=\"selected\"":"").">windows-1255</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="windows-1256"?" selected=\"selected\"":"").">windows-1256</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="windows-1257"?" selected=\"selected\"":"").">windows-1257</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="windows-1258"?" selected=\"selected\"":"").">windows-1258</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="KOI8-R"?" selected=\"selected\"":"").">KOI8-R</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="KOI8-U"?" selected=\"selected\"":"").">KOI8-U</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="cp866"?" selected=\"selected\"":"").">cp866</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="cp874"?" selected=\"selected\"":"").">cp874</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="TIS-620"?" selected=\"selected\"":"").">TIS-620</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="VISCII"?" selected=\"selected\"":"").">VISCII</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="VPS"?" selected=\"selected\"":"").">VPS</option>";
        $btit_settings["charset_combo"].="\n<option".($btit_settings["default_charset"]=="TCVN-5712"?" selected=\"selected\"":"").">TCVN-5712</option>";
        $btit_settings["charset_combo"].="\n</select>";
// style dropdown
        $sres=style_list();
        $btit_settings["style_combo"]="\n<select name=\"default_style\" size=\"1\">";
        foreach($sres as $style)
          {
            $btit_settings["style_combo"].="\n<option ";
            if ($style["id"]==$btit_settings["default_style"])
               $btit_settings["style_combo"].="selected=\"selected\" ";
            $btit_settings["style_combo"].="value=\"".$style["id"]."\">".$style["style"]."</option>";
          }
        $btit_settings["style_combo"].="\n</select>\n";
        unset($sres);
// validation dropdown
        $btit_settings["validation_combo"]="
                    <select name=\"validation\" size=\"1\">
                    <option value=\"none\"".($btit_settings["validation"]=="none"?" selected=\"selected\"":"").">".$language["NONE"]."</option>
                    <option value=\"user\"".($btit_settings["validation"]=="user"?" selected=\"selected\"":"").">".$language["USER"]."</option>
                    <option value=\"admin\"".($btit_settings["validation"]=="admin"?" selected=\"selected\"":"").">Admin</option>
                    </select>";

// dt login switch
        $btit_settings["login_combo"]="
                    <select name=\"log_sw_dt\" size=\"1\">
                    <option value=\"regular\"".($btit_settings["log_sw_dt"]=="regular"?" selected=\"selected\"":"").">Regular Login</option>
                    <option value=\"diem\"".($btit_settings["log_sw_dt"]=="diem"?" selected=\"selected\"":"").">DT Login</option>
                    <option value=\"yupy\"".($btit_settings["log_sw_dt"]=="yupy"?" selected=\"selected\"":"").">Yupy Login</option>
                    </select>";
// dt login switch end

// unit dropdown
        $btit_settings["unit_combo"]="
            <select name=\"unit\" size=\"1\"
            <option value=\"Kb\"".($btit_settings["unit"]=="Kb"?" selected=\"selected\"":"").">".$language["KB"]."</option>
            <option value=\"Mb\"".($btit_settings["unit"]=="Mb"?" selected=\"selected\"":"").">".$language["MB"]."</option>
            <option value=\"Gb\"".($btit_settings["unit"]=="Gb"?" selected=\"selected\"":"").">".$language["GB"]."</option>
            <option value=\"Tb\"".($btit_settings["unit"]=="Tb"?" selected=\"selected\"":"").">".$language["TB"]."</option>
            </select>";

// cut torrent's name
        $btit_settings["cut_name"]=intval($btit_settings["cut_name"]);
// mailer
        $btit_settings["mail_type_combo"]="\n<option value=\"php\"".($btit_settings["mail_type"]=="php"?"selected=\"selected\"":"").">PHP (default)</option>";
        $btit_settings["mail_type_combo"].="\n<option value=\"smtp\"".($btit_settings["mail_type"]=="smtp"?"selected=\"selected\"":"").">SMTP</option>";

        $btit_settings["smtp_server"]=isset($btit_settings["smtp_server"])?$btit_settings["smtp_server"]:"";
        $btit_settings["smtp_port"]=isset($btit_settings["smtp_port"])?$btit_settings["smtp_port"]:"25";
        $btit_settings["smtp_username"]=isset($btit_settings["smtp_username"])?$btit_settings["smtp_username"]:"";
        $btit_settings["smtp_password"]=isset($btit_settings["smtp_password"])?$btit_settings["smtp_password"]:"";
        $btit_settings["irc_server"]=isset($btit_settings["irc_server"])?$btit_settings["irc_server"]:"";
        $btit_settings["irc_port"]=isset($btit_settings["irc_port"])?$btit_settings["irc_port"]:"6667";
        $btit_settings["irc_channel"]=isset($btit_settings["irc_channel"])?$btit_settings["irc_channel"]:"";

        $admintpl->set("config",$btit_settings);
        $admintpl->set("frm_action","index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=config&amp;action=write");
        $admintpl->set("style_visible", (($btit_settings["hide_style"]=="visible")?true:false),true);
        $admintpl->set("style_hidden", (($btit_settings["hide_style"]=="hidden")?true:false),true);
        $admintpl->set("style_color", (($btit_settings["hide_style"]=="visible")?"#00FF00;":"#FF0000;"));
        $admintpl->set("language_visible", (($btit_settings["hide_language"]=="visible")?true:false),true);
        $admintpl->set("language_hidden", (($btit_settings["hide_language"]=="hidden")?true:false),true);
        $admintpl->set("language_color", (($btit_settings["hide_language"]=="visible")?"#00FF00;":"#FF0000;"));
        $admintpl->set("sblocks_visible", (($btit_settings["hide_sblocks"]=="visible")?true:false),true);
        $admintpl->set("sblocks_hidden", (($btit_settings["hide_sblocks"]=="hidden")?true:false),true);
        $admintpl->set("sblocks_color", (($btit_settings["hide_sblocks"]=="visible")?"#00FF00;":"#FF0000;"));
        $admintpl->set("ipb_in_use", (($btit_settings["forum"]=="ipb")?true:false), true);
        break;
}
?>