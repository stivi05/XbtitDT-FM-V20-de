<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam 
//
//    This file is part of xbtit DT FM.
//
// [XBTIT DT FM V20.0 by DiemThuy]
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

function do_sanity($ts=0) {
 
// Lets try upping the max_execution_time and memory_limit if we can (Code from Pet/FM)
    if(@ini_get("max_execution_time") < 300)
        @ini_set("max_execution_time", 300);
    if(trim(@ini_get("memory_limit"), "M") < 128)
        @ini_set("memory_limit", "128M");

         global $clean_interval, $BASEURL, $btit_settings, $XBTT_USE,  $db_prefix, $autopruneusers, $email_on_prune, $days_members, $days_not_comfirm, $days_to_email, $PRIVATE_ANNOUNCE, $TORRENTSDIR, $CURRENTPATH,$LIVESTATS,$LOG_HISTORY, $TABLE_PREFIX , $DOXPATH,$DBDT;

$THIS_BASEPATH=dirname(__FILE__);

$days = 14;
$time = (time() - ($days*86400));
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}bugs WHERE status != 'na' AND added < {$time}") or sqlerr(__FILE__, __LINE__);

//delete bots after 48 hours         
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}bots WHERE visit < (NOW() - INTERVAL 2880 MINUTE)");         
//end bots

//delete last up/downloads after 48 hours         
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}downloads WHERE date < (NOW() - INTERVAL 2880 MINUTE)");         
//end last up/downloads

//show images in shoutbox
if ($btit_settings["endtch"] == TRUE)
{
    $shout = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
    $shoutrow = mysqli_fetch_assoc($shout);
    $fp=$btit_settings["fix_chat"];
if ($shoutrow["count"]>=$btit_settings["don_chat"])
{
if ($btit_settings["ran_chat"] == TRUE)
do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text) VALUES (0,".time().", 'System','[img]$BASEURL/images/shouts/shout.php[/img]')");
else
do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text) VALUES (0,".time().", 'System','[img]$BASEURL/images/shouts/".$fp."[/img]')");
}
}
//show images in shoutbox end

//happy hour
$happy_r = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT UNIX_TIMESTAMP(value_s) AS happy , value_i AS happys from {$TABLE_PREFIX}avps where arg='happyhour'") or sqlerr(__FILE__, __LINE__);
$happy_a = mysqli_fetch_array($happy_r);
$curDate = time();
 $happyTime = ($happy_a["happy"] + 3600);
 if ($happy_a["happys"] == 0)
 {
 $happyHour = happyHour();
 mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}avps set value_s=".sqlesc($happyHour).", value_i='1' WHERE arg='happyhour' LIMIT 1 ") or sqlerr(__FILE__, __LINE__);
 }
 elseif ($happy_a["happys"] == 1 && ($curDate > $happyTime))
 mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}avps set value_i='0' WHERE arg='happyhour' LIMIT 1 ");
 
     $switch = do_sqlquery("SELECT * FROM `{$TABLE_PREFIX}files` WHERE `external`='no'", true);
   	 $switch_happy = mysqli_fetch_array($switch);

if($switch_happy["happy_hour"]=="yes")
{
 if (ishappyHour("check") && $happyTime > "0:00")

 {
     do_sqlquery("ALTER TABLE `{$TABLE_PREFIX}files` CHANGE `happy` `happy` ENUM( 'yes', 'no' ) NULL DEFAULT 'yes'") or sqlerr();
	 do_sqlquery("UPDATE `{$TABLE_PREFIX}files` SET `happy`='yes' WHERE `external`='no'", true);
 }
 else
 {
     do_sqlquery("ALTER TABLE `{$TABLE_PREFIX}files` CHANGE `happy` `happy` ENUM( 'yes', 'no' ) NULL DEFAULT 'no'") or sqlerr();
	 do_sqlquery("UPDATE `{$TABLE_PREFIX}files` SET `happy`='no' WHERE `external`='no'", true);
 }
}
// happy hour 

// featured
if ($btit_settings["auto_feat"] == TRUE)
{
$feat = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT info_hash , leechers , image from {$TABLE_PREFIX}files where image!='' ORDER BY leechers DESC limit 1");
$resfeat=mysqli_fetch_array($feat);

do_sqlquery("INSERT INTO {$TABLE_PREFIX}featured (fid,torrent_id) VALUES ('','$resfeat[info_hash]')");
}
//featured        

//sb
if ($XBTT_USE) {
 $ressb = do_sqlquery("SELECT uid FROM xbt_files_users as u INNER JOIN xbt_files as x ON u.fid=x.fid WHERE u.left = '0' AND x.flags='0' AND u.active='1'");
   if (mysqli_num_rows($ressb) > 0)
   {
       while ($arrsb = mysqli_fetch_assoc($ressb))
       {
       $x=$arrsb["uid"];
       quickQuery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=`seedbonus`+'".number_format((((($ts>0)?(time()-$ts):$clean_interval)/3600)*$GLOBALS["bonus"]),6,".","")."' WHERE `id` = '$x'");

       }
   } }else
   {
 $ressb = do_sqlquery("SELECT pid FROM {$TABLE_PREFIX}peers WHERE status = 'seeder'");
   if (mysqli_num_rows($ressb) > 0)
   {
       while ($arrsb = mysqli_fetch_assoc($ressb))
       {
       $x=$arrsb['pid'];
       quickQuery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=`seedbonus`+'".number_format((((($ts>0)?(time()-$ts):$clean_interval)/3600)*$GLOBALS["bonus"]),6,".","")."' WHERE `pid`= '$x'");

    }
   } }
//sb
   
//warn
$query = do_sqlquery("SELECT * FROM `{$TABLE_PREFIX}users` WHERE warn='yes'");
   while ($conf = mysqli_fetch_assoc($query))
   {
	if (mysqli_num_rows($query) > 0)
	  {
$expire_dat = $conf['warnadded'];
$expire2 = strtotime ($expire_dat);
$nown = strtotime("now");
if ($nown >= $expire2 )
{
$subj = sqlesc("Your Warning time is expired !!");
$msg = sqlesc("You are not longer Warned , please be carefull to not make the same mistake again !!");
send_pm(0,$conf[id],$subj,$msg); 
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET warn='no' WHERE id='$conf[id]'") or sqlerr();
}
}
}
//warn 
   
//remove boot after expiration
require_once(load_language("lang_userdetails.php"));
$datetime = gmdate("Y-m-d H:i:s");
$bootedstats = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE addbooted < '$datetime' AND booted='yes'");
   while ($arr = mysqli_fetch_assoc($bootedstats))
   {
	if (mysqli_num_rows($bootedstats) > 0)
	  {
$sub = sqlesc($language["BOOT_SUB"]);
$mess = sqlesc($language["BOOT_MSG"]);
send_pm(0,$arr[id],$sub,$mess);
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET booted='no' WHERE id='$arr[id]'") or sqlerr();
}
}
//remove boot after expiration
   
// DT request hack start
  	$reqprune = $btit_settings["req_prune"];
	$request = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}requests WHERE filledby > '0' AND fulfilled < DATE_SUB(NOW(), INTERVAL $reqprune DAY)");
	$reqrow = mysqli_fetch_assoc($request);
	$reqid = $reqrow["id"];
	if (mysqli_num_rows($request) > 0)
	{
	mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}requests WHERE filledby > 0 AND id = $reqid");
	mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}addedrequests WHERE requestid = $reqid");
	}
// DT request hack end
    
    if ($autopruneusers){
    $timeout = $days_members*60*60*24;
    $timeout2 = $days_not_comfirm*60*60*24;
    if($GLOBALS["FORUMLINK"]=="smf"){
    do_sqlquery("DELETE u,smfm FROM {$TABLE_PREFIX}users u INNER JOIN {$db_prefix}members smfm ON smfm.ID_MEMBER=u.smf_fid INNER JOIN {$TABLE_PREFIX}users_level ul ON ul.id=u.id_level WHERE (u.id_level = '2' AND UNIX_TIMESTAMP(u.lastconnect)<(UNIX_TIMESTAMP()-$timeout2) AND ul.auto_prune='yes') OR (UNIX_TIMESTAMP(lastconnect)<(UNIX_TIMESTAMP()-$timeout) AND ul.auto_prune='yes')");
    }else{
    do_sqlquery("DELETE u FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}users_level ul ON ul.id=u.id_level WHERE (u.id_level = '2' AND UNIX_TIMESTAMP(u.lastconnect)<(UNIX_TIMESTAMP()-$timeout2) AND ul.auto_prune='yes') OR (UNIX_TIMESTAMP(lastconnect)<(UNIX_TIMESTAMP()-$timeout) AND ul.auto_prune='yes')");
    }
    if ($email_on_prune){
    $timeout = $days_to_email*60*60*24;
    $res=get_result("SELECT email, lastconnect FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}users_level ul ON ul.id=u.id_level WHERE UNIX_TIMESTAMP()>=(UNIX_TIMESTAMP(lastconnect)+$timeout-$clean_interval/2) AND UNIX_TIMESTAMP()<(UNIX_TIMESTAMP(lastconnect)+$timeout+$clean_interval/2) AND UNIX_TIMESTAMP(lastconnect)<(UNIX_TIMESTAMP()-$timeout) AND ul.auto_prune='yes'",true);
    foreach($res as $id=>$rusers)
        {send_mail($rusers["email"],$language["EMAIL_INACTIVE_SUBJ"],$language["EMAIL_INACTIVE_MSG"]."\n\n".$BASEURL."/index.php");}
    }}
    
// Autoprune torrents
if ($btit_settings["autotprune"] == TRUE)
{
        quickQuery("UPDATE `{$TABLE_PREFIX}files` `f` ".(($XBTT_USE)?"LEFT JOIN `xbt_files` `xf` ON `f`.`bin_hash`=`xf`.`info_hash`":"")." SET `f`.`dead_time`=UNIX_TIMESTAMP() WHERE ((".(($XBTT_USE)?"`xf`.`seeders`>0 OR `xf`.`leechers`>0":"`f`.`seeds`>0 OR `f`.`leechers`>0").") OR `f`.`dead_time`=0) AND `f`.`external`='no'");
        $res=get_result("SELECT `info_hash`, `bin_hash` FROM `{$TABLE_PREFIX}files` WHERE `dead_time`<=".(time()-($btit_settings["autotprundedays"]*86400))." AND `dead_time`!=0 AND `external`='no'");
        if(count($res)>0)
        {
            foreach($res as $row)
            {
               quickQuery("DELETE FROM `{$TABLE_PREFIX}files` WHERE `info_hash`='".mysqli_real_escape_string($DBDT,$row["info_hash"])."'");
               quickQuery("DELETE FROM `{$TABLE_PREFIX}timestamps` WHERE `info_hash`='".mysqli_real_escape_string($DBDT,$row["info_hash"])."'");
               quickQuery("DELETE FROM `{$TABLE_PREFIX}comments` WHERE `info_hash`='".mysqli_real_escape_string($DBDT,$row["info_hash"])."'");
               quickQuery("DELETE FROM `{$TABLE_PREFIX}ratings` WHERE `infohash`='".mysqli_real_escape_string($DBDT,$row["info_hash"])."'");
               quickQuery("DELETE FROM `{$TABLE_PREFIX}peers` WHERE `infohash`='".mysqli_real_escape_string($DBDT,$row["info_hash"])."'");
               quickQuery("DELETE FROM `{$TABLE_PREFIX}history` WHERE `infohash`='".mysqli_real_escape_string($DBDT,$row["info_hash"])."'");
               if ($XBTT_USE)
                  quickQuery("UPDATE `xbt_files` SET `flags`=1 WHERE `info_hash`='".mysqli_real_escape_string($DBDT,$row["bin_hash"])."'");
            }
        }
}
// Autoprune torrents  
    
// timed registration
  	$expire_datetr = $btit_settings["regi_d"];
	$expire_timetr = $btit_settings["regi_t"];
	$expire_datetrs = $expire_datetr." ".$expire_timetr.":00:00";
    $expiretr = strtotime ($expire_datetrs);
    $nowtr = strtotime("now");
    if ($nowtr >= $expiretr )
        {
do_sqlquery("UPDATE `{$TABLE_PREFIX}settings` SET `value`='true' WHERE `key`='regi'", true);
        }
// end timed registration

// Anti Hit and Run V2 based on CobraCRK's Anti Hit&Run Mod v1 Enhanced By IntelPentium4 & fatepower
// converted ( and improved ) to XBTIT 2 by DiemThuy Nov 2008
if (!$XBTT_USE) {
// Get current time
         $timenow=time();

// Get last time that dosanity() was run
         $timeres = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT last_time FROM {$TABLE_PREFIX}anti_hit_run_tasks WHERE task='sanity'");
         if (mysqli_num_rows($timeres) > 0){
             $timearr = mysqli_fetch_array($timeres);
             $lastrecordedtime = intval($timearr['last_time']);
         }
         else{
           $lastrecordedtime = $timenow-$clean_interval;
         }
// Update Active Seeders' Seeding Clock
         $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT pid, infohash FROM {$TABLE_PREFIX}peers WHERE status = 'seeder'");

         if (mysqli_num_rows($res) > 0)
         {
           while ($arr = mysqli_fetch_assoc($res))
           {
	      $x=$arr['pid'];
    	      $t=$arr['infohash'];
  	      $pl=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}users WHERE pid='".$x."'");

  	      	   if(mysqli_num_rows($pl)>0)$ccc=mysqli_result($pl,0,"id");
               else $ccc="Unknown" ;

	      mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}history SET seed = seed+".$timenow."-".$lastrecordedtime." WHERE uid = $ccc AND infohash='$t'");
	   }
         }
//Update table anti_hit_run_tasks with new time info.
            $hunden = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT last_time FROM {$TABLE_PREFIX}anti_hit_run_tasks WHERE task='sanity'");
            $manneplutt = mysqli_fetch_row($hunden);
            if (!$manneplutt)
                mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}anti_hit_run_tasks (task, last_time) VALUES ('sanity',$timenow)");
            else
            {
              $ts = $manneplutt[0];
              mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}anti_hit_run_tasks SET last_time=$timenow WHERE task='sanity' AND last_time = $ts");
            }
// Rank who has no anti-hit punishment rule should be excluded
         $levels = mysqli_query($GLOBALS["___mysqli_ston"], "select id from {$TABLE_PREFIX}users_level order by id");
         while($SingleLevel = mysqli_fetch_array($levels)){
            $hasAntiHitRecord = mysqli_query($GLOBALS["___mysqli_ston"], "select id_level from {$TABLE_PREFIX}anti_hit_run where id_level=".$SingleLevel["id"]);
            if (mysqli_num_rows($hasAntiHitRecord) == 0){
  	       @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}history`,`users` set hitchecked= 2 where history.uid=users.id and users.id_level=".$SingleLevel["id"]." and completed='yes' and hitchecked='0'");
            }
         }

         $hit_parameters = mysqli_query($GLOBALS["___mysqli_ston"], "select * from {$TABLE_PREFIX}anti_hit_run order by id_level");
         while($hit = mysqli_fetch_array($hit_parameters)){

// Punishment
            $r=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT uid,infohash FROM {$TABLE_PREFIX}history history inner join {$TABLE_PREFIX}users users on history.uid=users.id WHERE users.id_level=".$hit["id_level"]." AND active='no' AND completed='yes' AND hit='no' AND hitchecked= 0 AND date < ( UNIX_TIMESTAMP( ) - (86400 * ".$hit["tolerance_days_before_punishment"].")) AND history.downloaded>(1048576 * ".$hit["min_download_size"].") AND seed<( 3600 * ".$hit["min_seed_hours"].") AND (history.uploaded/history.downloaded)<".$hit["min_ratio"]);
            while($x = mysqli_fetch_array($r)){
	       @mysqli_query($GLOBALS["___mysqli_ston"], "Update {$TABLE_PREFIX}history SET hit='yes' WHERE uid=".$x[uid]." AND infohash='".$x[infohash]."' AND hitchecked=0");
               if(mysqli_affected_rows($GLOBALS["___mysqli_ston"])>0){
                  if ($hit["reward"]=='yes') {
                     $reward = "\n\n[color=red]If you want to get the lost amount back , you must seed for at least ".$hit["min_seed_hours"]." hour(s) or until the file\'s ratio becomes greater than ".$hit["min_ratio"]." then your total upload will incremented by ".$hit["upload_punishment"]." MB !! \n\n\ [/color][color=purple]This is a automatic system message , so DO NOT reply ![/color]";
                  }
                  else{
                     $reward = " ";
                  }
  	          @mysqli_query($GLOBALS["___mysqli_ston"], "Update {$TABLE_PREFIX}history SET hitchecked= 1 ,punishment_amount=".$hit["upload_punishment"]." WHERE uid=".$x[uid]." AND infohash='".$x[infohash]."' AND hitchecked=0");
  	          @mysqli_query($GLOBALS["___mysqli_ston"], "Update {$TABLE_PREFIX}users SET uploaded=(case when uploaded-(1048576 * ".$hit["upload_punishment"].")<0 then 0 else uploaded-(1048576 * ".$hit["upload_punishment"].") end) WHERE id=$x[uid]");

send_pm(0,$x[uid],sqlesc("Auto Hit an Run warning"),sqlesc("You did Hit and Run on the following torrent :\n\n [url]".$BASEURL."/index.php?page=details&id=$x[infohash][/url] !\n\n\We did take away ".$hit["upload_punishment"]." MB as punishment\n\nBe carefull to not make the mistake once more ! ".$reward.""));

// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

$plus= $setrep["rep_hit"];

if ($setrep["rep_is_online"]== FALSE)
{
//do nothing
}
else
{
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET reputation = reputation - '$plus' WHERE id='$x[uid]'");
}
// DT reputation system end

// warn at hit and run
if ($hit["warn"]=='yes') {
$id=(int)$x[uid];
$warnreason="Auto Hit & Run Warning";
$warnaddedby="System";
$added=warn_expiration(mktime(date('H')+2,date('i'),date('s'),date('m'),date('d')+addslashes($hit["days1"]),date('Y')));

quickQuery('UPDATE '.$TABLE_PREFIX.'users SET warn="yes",warns=warns+1,warnreason="'.$warnreason.'",warnaddedby="'.$warnaddedby.'",warnadded="'.$added.'" WHERE id='.$id);
}
// end warn at hit and run

// boot at hit and run
if ($hit["boot"]=='yes') {
$id=(int)$x[uid];
$whybooted="Auto Hit & Run Ban";
$whobooted="System";
$addbooted=booted_expiration(mktime(date('H')+2,date('i'),date('s'),date('m'),date('d')+addslashes($hit["days2"]),date('Y')));

quickQuery('UPDATE '.$TABLE_PREFIX.'users SET booted="yes", whybooted="'.$whybooted.'",whobooted="'.$whobooted.'",addbooted="'.$addbooted.'" WHERE id='.$id);
}
// end boot at hit and run

//Dox Hack Start
         $r = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, filename, added FROM {$TABLE_PREFIX}dox WHERE added < '" . date('Y-m-d', strtotime('-' . $btit_settings["dox_del"] . ' weeks')) . "'");
         while ($del = mysqli_fetch_array($r))
            {
              $MANNE="$BASEURL/$DOXPATH";
              @unlink("$MANNE/$del[filename]");
              quickQuery("DELETE FROM {$TABLE_PREFIX}dox WHERE id=$del[id]");
            }
//Dox Hack End

// boot after warn at hit and run
if ($hit["warnboot"]=='yes') {

                $diem = do_sqlquery("SELECT warns FROM {$TABLE_PREFIX}users WHERE id=$x[uid]");
                $thuy = mysqli_fetch_array($diem);

if ($thuy["warns"] >= $hit["days3"]) ;
{
$id=(int)$x[uid];
$whybooted="Auto Hit & Run Ban after beeing warned";
$whobooted="System";
$addbooted=booted_expiration(mktime(date('H')+2,date('i'),date('s'),date('m'),date('d')+addslashes($hit["days2"]),date('Y')));

quickQuery('UPDATE '.$TABLE_PREFIX.'users SET booted="yes", whybooted="'.$whybooted.'",whobooted="'.$whobooted.'",addbooted="'.$addbooted.'" WHERE id='.$id);
}
}
// end boot after warn at hit and run
}
            }

            ((mysqli_free_result($r) || (is_object($r) && (get_class($r) == "mysqli_result"))) ? true : false);


// Reward
            if ($hit["reward"]=='yes') {
               $rr=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT uid,infohash,punishment_amount FROM {$TABLE_PREFIX}history history inner join {$TABLE_PREFIX}users users on history.uid=users.id WHERE users.id_level=".$hit["id_level"]." AND hit='yes' AND completed='yes' AND hitchecked= 1 AND (seed>=( 3600 * ".$hit["min_seed_hours"].") or (history.uploaded/history.downloaded)>=".$hit["min_ratio"].")");
               while($xr = mysqli_fetch_array($rr)){
	          @mysqli_query($GLOBALS["___mysqli_ston"], "Update {$TABLE_PREFIX}history SET hitchecked= 3 WHERE uid=".$xr[uid]." AND infohash='".$xr[infohash]."' AND hitchecked=1");
                  if(mysqli_affected_rows($GLOBALS["___mysqli_ston"])>0){
      	             @mysqli_query($GLOBALS["___mysqli_ston"], "Update {$TABLE_PREFIX}users SET uploaded=uploaded+(1048576 * ".$xr["punishment_amount"].")  WHERE id=$xr[uid]");

 	             send_pm(0,$xr[uid],sqlesc("Thanks (Punishement Removed)"),sqlesc("Thank you very much for seeding back the following torrent:\n\n [url]".$BASEURL."/index.php?page=details&id=$xr[infohash][/url] !\n\n [color=green]The punishment is now removed and you total upload amount increased by ".$xr["punishment_amount"]." MB!  [/color]\n\n [color=purple]This is a automatic system message , so DO NOT reply ![/color]"));
 	             
// DT reputation system start
if ($setrep["rep_is_online"]== FALSE)
{
//do nothing
}
else
{
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET reputation = reputation + '$plus' WHERE id='$x[uid]'");
}
// DT reputation system end

// warn at hit and run
 	         if ($hit["warn"]=='yes') {
 	        quickQuery('UPDATE '.$TABLE_PREFIX.'users SET warn="no", warns=warns-1 WHERE id='.$xr[uid]);
 	          }
// end warn at hit and run

// boot at hit and run
 	         if ($hit["boot"]=='yes') {
 	        quickQuery('UPDATE '.$TABLE_PREFIX.'users SET booted="no" WHERE id='.$xr[uid]);
 	         }
// end boot at hit and run
                  }
               }
               ((mysqli_free_result($rr) || (is_object($rr) && (get_class($rr) == "mysqli_result"))) ? true : false);
            }
// Who are fine should not be punished
            @mysqli_query($GLOBALS["___mysqli_ston"], "Update {$TABLE_PREFIX}history,users SET hitchecked= 1 WHERE history.uid=users.id AND users.id_level = users.id_level=".$hit["id_level"]." AND completed='yes' AND date < ( UNIX_TIMESTAMP( ) - (86400 * ".$hit["tolerance_days_before_punishment"].")) AND hitchecked= 0");
         }

// Free DB Connections
         ((mysqli_free_result($levels) || (is_object($levels) && (get_class($levels) == "mysqli_result"))) ? true : false);
         ((mysqli_free_result($hasAntiHitRecord) || (is_object($hasAntiHitRecord) && (get_class($hasAntiHitRecord) == "mysqli_result"))) ? true : false);
         ((mysqli_free_result($hit_parameters) || (is_object($hit_parameters) && (get_class($hit_parameters) == "mysqli_result"))) ? true : false);

}
// End of Anti Hit and Run

//Invalid Login System Hack Start
mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}bannedip WHERE comment='max_number_of_invalid_logins_reached'");
//invalid Login System Hack Stop

//start freeleech
        $queryd = do_sqlquery("SELECT free_expire_date, free FROM `{$TABLE_PREFIX}files` WHERE `external`='no'", true);
        $configd = mysqli_fetch_array($queryd);
        $expire_dated = $configd['free_expire_date'];
        $expired = strtotime ($expire_dated);
        $nowd = strtotime("now");
        if ($nowd >= $expired && $configd['free']=='yes')
        {
            do_sqlquery("UPDATE `{$TABLE_PREFIX}files` SET `free`='no',free_expire_date='0000-00-00 00:00:00' WHERE `external`='no'", true);
            do_sqlquery("ALTER TABLE `{$TABLE_PREFIX}files` CHANGE `free` `free` ENUM( 'yes', 'no' ) NULL DEFAULT 'no'",true);
            // xbtt
            if ( $XBTT_USE)
              {
              do_sqlquery("UPDATE xbt_files SET down_multi=0, flags=2");
              do_sqlquery("ALTER TABLE xbt_files CHANGE `down_multi` `down_multi` INT NULL DEFAULT '0'",true);
            }
        }
// end freeleech     
        
$query = do_sqlquery("SELECT * FROM `{$TABLE_PREFIX}lottery_config` WHERE `id`=1", true);
$config = mysqli_fetch_array($query);
$expire_date = $config['lot_expire_date'];
$expire = strtotime ($expire_date);
$now = strtotime("now");
if ($now >= $expire )
{
	$number_winners = $config['lot_number_winners'];
	$number_to_win = $config['lot_number_to_win'];
	$minupload = $config['lot_amount'];
	$res = do_sqlquery("SELECT `id`, `user` FROM `{$TABLE_PREFIX}lottery_tickets` ORDER BY RAND(NOW()) LIMIT ".$number_winners."", true); //select number of winners
	$total = mysqli_num_rows(do_sqlquery("SELECT * FROM `{$TABLE_PREFIX}lottery_tickets`", true)); //select total selled tickets
	$pot = $total * $minupload; //selled tickets * ticket price
	$pot += $number_to_win; // ticket prize + minimum win
	$win = ($pot/$number_winners); // prize for each winner
	$subject = sqlesc("You have won a prize with the lottery"); //subject in pm
	$msg = sqlesc("Congratulations you have won a prize with our Lottery. Your prize has been added to your account. You won ".makesize($win).""); //next 3 rows are the msg for PM
	$sender = $config['sender_id']; // Sender id, in my case 0
	
//print the winners and send them PM en give them price
	while($row=mysqli_fetch_array($res)){
	
		$ras = do_sqlquery("SELECT `smf_fid`, `id`, `username` FROM `{$TABLE_PREFIX}users` WHERE `id`=".$row['user']."", true);
		$raw = mysqli_fetch_array($ras);
		$rec = sqlesc("$raw[id]");
		$lotid = $raw["id"];
		$lotname = $raw["username"];
		do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=uploaded+".$win." WHERE `id`=".$row['user']."", true);
		$smf = mysqli_fetch_assoc(do_sqlquery("SELECT smf_fid, username FROM `{$TABLE_PREFIX}users` WHERE `id`=".$row["user"]."", true));
		send_pm($sender,$rec,$subject,$msg);
// begin - announce winner in shoutbox
      do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text) VALUES (0,".time().", 'System','[color=red]Lottery winner : [/color][url=$BASEURL/index.php?page=userdetails&id=$lotid]".$lotname." did win ".makesize($win)."[/url]')");
// end - announce winner in shoutbox

		do_sqlquery("INSERT INTO `{$TABLE_PREFIX}lottery_winners` (`id`, `win_user`, `windate`, `price`) VALUES ('', '".$raw['username']."', '".$expire_date."', '".$win."')"); 
	}
	do_sqlquery("TRUNCATE TABLE `{$TABLE_PREFIX}lottery_tickets`", true);
	do_sqlquery("UPDATE `{$TABLE_PREFIX}lottery_config` SET `lot_status`='closed' WHERE `id`=1", true);
}

// lottery auto start
if ($btit_settings["autolot"]==TRUE)
{
$date_end  = lastOfMonth();
$klaar = $config["lot_status"];

if ( $klaar == 'closed' )
{         
	$expire_date = $date_end;
	$expire_time = 23;
	$val1	= 	$expire_date." ".$expire_time.":59:59";
	$val2	=	1;
	$val3	=	15*1024*1024*1024;	// Gb
	$val4	=	500*1024*1024;		// Mb
	$val5	=	'yes';
	$val6	=	1;
	$val7	=	2;
	do_sqlquery("UPDATE `{$TABLE_PREFIX}lottery_config` SET `lot_expire_date`='".$val1."', `lot_number_winners`='".$val2."', `lot_number_to_win`='".$val3."', `lot_amount`='".$val4."', `lot_status`='".$val5."', `limit_buy`='".$val6."', `sender_id`=".$val7." WHERE `id`=1", true);
}
// lottery end 
}

// SANITY FOR TORRENTS
         $results = do_sqlquery("SELECT info_hash, seeds, leechers, dlbytes, filename FROM {$TABLE_PREFIX}files WHERE external='no'");
         $i = 0;
         while ($row = mysqli_fetch_row($results))
         {
             list($hash, $seeders, $leechers, $bytes, $filename) = $row;

         $timeout=time()-(intval($GLOBALS["report_interval"]*2));

// for testing purpose -- begin
         $resupd=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}peers where lastupdate < ".$timeout ." AND infohash='$hash'");
         if (mysqli_num_rows($resupd)>0)
            {
            while ($resupdate = mysqli_fetch_array($resupd))
              {
                  $uploaded=max(0,$resupdate["uploaded"]);
                  $downloaded=max(0,$resupdate["downloaded"]);
                  $pid=$resupdate["pid"];
                  $ip=$resupdate["ip"];
// update user->peer stats only if not livestat
                  if (!$LIVESTATS)
                    {
                      if ($PRIVATE_ANNOUNCE)
                         quickQuery("UPDATE {$TABLE_PREFIX}users SET uploaded=uploaded+$uploaded, downloaded=downloaded+$downloaded WHERE pid='$pid' AND id>1 LIMIT 1");
                      else // ip
                          quickQuery("UPDATE {$TABLE_PREFIX}users SET uploaded=uploaded+$uploaded, downloaded=downloaded+$downloaded WHERE cip='$ip' AND id>1 LIMIT 1");
                     }

// update dead peer to non active in history table
                  if ($LOG_HISTORY)
                     {
                          $resuser=do_sqlquery("SELECT id FROM {$TABLE_PREFIX}users WHERE ".($PRIVATE_ANNOUNCE?"pid='$pid'":"cip='$ip'")." ORDER BY lastconnect DESC LIMIT 1");
                          $curu=@mysqli_fetch_row($resuser);
                          quickquery("UPDATE {$TABLE_PREFIX}history SET active='no' WHERE uid=$curu[0] AND infohash='$hash'");
                     }

            }
         }
// for testing purpose -- end

            quickQuery("DELETE FROM {$TABLE_PREFIX}peers where lastupdate < ".$timeout." AND infohash='$hash'");
            quickQuery("UPDATE {$TABLE_PREFIX}files SET lastcycle='".time()."' WHERE info_hash='$hash'");

             $results2 = do_sqlquery("SELECT status, COUNT(status) from {$TABLE_PREFIX}peers WHERE infohash='$hash' GROUP BY status");
             $counts = array();
             while ($row = mysqli_fetch_row($results2))
                 $counts[$row[0]] = 0+$row[1];

             quickQuery("UPDATE {$TABLE_PREFIX}files SET leechers=".(isset($counts["leecher"])?$counts["leecher"]:0).",seeds=".(isset($counts["seeder"])?$counts["seeder"]:0)." WHERE info_hash=\"$hash\"");
             if ($bytes < 0)
             {
                 quickQuery("UPDATE {$TABLE_PREFIX}files SET dlbytes=0 WHERE info_hash=\"$hash\"");
             }

         }
// END TORRENT'S SANITY        
          
//DT Uploader Medals
global $btit_settings;
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET `up_med`='0' ");
$time_B=(86400 * $btit_settings['UPD'] );
$time_E = strtotime(now);
$time_D =  ($time_E - $time_B);
$res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT uploader,count( * ) AS Count FROM {$TABLE_PREFIX}files WHERE UNIX_TIMESTAMP(data) > ".$time_D." GROUP by uploader");
while ($fetch_U=mysqli_fetch_array($res))
{
if  ($fetch_U['Count'] >= $btit_settings['UPB'] AND $fetch_U['Count'] < $btit_settings['UPS'])
{
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET `up_med`='1' WHERE `id`='$fetch_U[uploader]'");
}
if ($fetch_U['Count'] >= $btit_settings['UPS'] AND $fetch_U['Count'] < $btit_settings['UPG'])
{
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET `up_med`='2' WHERE `id`='$fetch_U[uploader]'");
}
if ($fetch_U['Count'] >= $btit_settings['UPG'])
{
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET `up_med`='3' WHERE `id`='$fetch_U[uploader]'");
}
}
//DT end Uploader Medals

// high speed report
if ($btit_settings["highswitch"]==TRUE)
{
    if($GLOBALS["XBTT_USE"])
        $resch = do_sqlquery("SELECT `uid` `id`, `up_rate` FROM `xbt_files_users` WHERE `up_rate` >= (".$btit_settings["highspeed"]."*1024) AND `active`=1");
    else
        $resch = do_sqlquery("SELECT `p`.`upload_difference`, `p`.`announce_interval`, `u`.`id` FROM `{$TABLE_PREFIX}peers` `p` LEFT JOIN `{$TABLE_PREFIX}users` `u` ON ".(($PRIVATE_ANNOUNCE)?"`p`.`pid`=`u`.`pid`":"`p`.`ip`=`u`.`cip`")." WHERE (`p`.`upload_difference`/`p`.`announce_interval`) >= (".$btit_settings["highspeed"]."*1024)");
    
    if(@mysqli_num_rows($resch)>0)
    {
        while($rowch = mysqli_fetch_assoc($resch))
        {
            if(!is_null($rowch["id"]))
            {
                if($GLOBALS["XBTT_USE"])
                    $transferrate="Upload speed ".round($rowch["up_rate"]/1024, 2)." KB/sec ?!";
                else
                    $transferrate="Upload speed ".round(round($rowch['upload_difference']/$rowch['announce_interval'])/1024, 2)." KB/sec ?!";
                $high = $rowch["id"];
                if ($btit_settings["highonce"]==TRUE)
                {
                    $once = do_sqlquery("SELECT `id` FROM `{$TABLE_PREFIX}reports` WHERE `addedby` = 0 AND `votedfor` = $high AND `type` = 'user' AND reason LIKE 'Upload speed%'");
                    if (@mysqli_num_rows($once)===FALSE)
                        do_sqlquery("INSERT INTO `{$TABLE_PREFIX}reports` (`addedby`,`votedfor`,`type`,`reason`) VALUES ('0','$high','user', '$transferrate')");
                }
                if ($btit_settings["highonce"]==FALSE)
                    do_sqlquery("INSERT INTO `{$TABLE_PREFIX}reports` (`addedby`,`votedfor`,`type`,`reason`) VALUES ('0','$high','user', '$transferrate')");
            }
        }
    }
}
// end high speed report

// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

if ($setrep["rep_is_online"]== FALSE OR $setrep["rep_en_sys"]== FALSE)
{
//do nothing
}
else
{
// demote
$rep_sub=sqlesc("You are Demoted!");
$rep_msg=sqlesc($setrep["rep_dm_text"]);
$rep_demotelist=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}users WHERE reputation < ".$setrep["rep_dm"]." AND id_level = ".$setrep["rep_pr_id"]);
while($rep_demote=mysqli_fetch_assoc($rep_demotelist))
{
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET id_level=".$setrep["rep_dm_id"]." WHERE id=".$rep_demote["id"]);
send_pm(0,$rep_demote[id],$rep_sub,$rep_msg);
}
// promote
$rep_subj=sqlesc("You are Promoted!");
$rep_mesg=sqlesc($setrep["rep_pm_text"]);
$rep_promotelist=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}users WHERE reputation > ".$setrep["rep_pr"]." AND id_level = ".$setrep["rep_dm_id"]);
while($rep_promote=mysqli_fetch_assoc($rep_promotelist))
{
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET id_level=".$setrep["rep_pr_id"]." WHERE id=".$rep_promote["id"]);
send_pm(0,$rep_promote[id],$rep_subj,$rep_mesg);
}
}
// DT reputation system start

// Client Log for XBT
         if($GLOBALS["XBTT_USE"])
         {
             $timeout=time()-(intval($GLOBALS["report_interval"]*2));
             quickQuery("DELETE FROM `xbt_announce_log` WHERE `mtime`<=$timeout");
          
             $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `u`.`id`, INET_NTOA(`al`.`ipa`) `ip`, `al`.`port`, LOWER(HEX(`al`.`peer_id`)) `peer_id`, `u`.`clientinfo` FROM `xbt_announce_log` `al` LEFT JOIN `{$TABLE_PREFIX}users` `u` ON `al`.`uid`=`u`.`id` WHERE `al`.`event`=2 GROUP BY `al`.`peer_id` ORDER BY `u`.`id` ASC");
             if(@mysqli_num_rows($res)>0)
             {
                 $old_clients=array();
                 $current_clients=array();
                 while($row=mysqli_fetch_assoc($res))
                 {
                     $client=getagent("",$row["peer_id"]);

                     if(!empty($row["clientinfo"]))
                     {
                         if (!array_key_exists($row["id"], $old_clients))
                         {
                             $old_clients[$row["id"]]=unserialize($row["clientinfo"]);
                         }
                         if (!array_key_exists($row["id"], $current_clients))
                         {
                             $current_clients[$row["id"]]=unserialize($row["clientinfo"]);
                         }
                     }
                     else
                     {
                         if (!array_key_exists($row["id"], $old_clients))
                         {
                             $old_clients[$row["id"]]=array();
                         }
                         if (!array_key_exists($row["id"], $current_clients))
                         {
                             $current_clients[$row["id"]]=array();
                         }
                     }
                     if(!in_array($client."[X]".$row["port"],$current_clients[$row["id"]]))
                     {
                         if (count($current_clients[$row["id"]])==20)
                         {
                             unset($current_clients[$row["id"]][0]);
                             unset($current_clients[$row["id"]][1]);
                             $newlist=array();
                             foreach($current_clients[$row["id"]] as $v)
                             {
                                 $newlist[]=$v;
                             }
                             $current_clients[$row["id"]]=$newlist;
                         }
                         $current_clients[$row["id"]][]=$client."[X]".$row["port"];
                         $current_clients[$row["id"]][]=time()."[X]".$row["ip"];
                     }
                 }
                 foreach($current_clients as $k => $v)
                 {
                     $s_old_clients=serialize($old_clients[$k]);
                     $s_current_clients=serialize($current_clients[$k]);
                     if($s_old_clients != $s_current_clients)
                     {
                         mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `clientinfo`='".mysqli_real_escape_string($DBDT,$s_current_clients)."' WHERE `id`=$k");
                     }
                 }
             }
         }
// Client Log for XBT


// banbutton
$timeout=($btit_settings["bandays"] * 86400);
@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM `{$TABLE_PREFIX}signup_ip_block` WHERE (UNIX_TIMESTAMP() - `added`) > $timeout");
// end banbutton

# global language, $clean_interval, $reload_cfg_interval;
      global $language, $clean_interval, $reload_cfg_interval;
      require dirname(__FILE__).'/khez.php';
			quickQuery('OPTIMIZE TABLE `'.$TABLE_PREFIX.'khez_configs`;');
# hacks can start here ==Khez==

// warn-ban system with acp by DT
global $XBTT_USE;

 $resset = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}low_ratio_ban_settings WHERE id ='1'");
 $art = mysqli_fetch_assoc($resset); 
 $resban = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}low_ratio_ban ");
 while($ban = mysqli_fetch_assoc($resban))
 { 

if ($art["wb_sys"]==TRUE)
{
if ($XBTT_USE)
   {
    $udownloaded="u.downloaded+IFNULL(x.downloaded,0)";
    $uuploaded="u.uploaded+IFNULL(x.uploaded,0)";
    $utables="{$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id";
   }
else
    {
    $udownloaded="u.downloaded";
    $uuploaded="u.uploaded";
    $utables="{$TABLE_PREFIX}users u";
    }

$min_dl=($ban["wb_down"]*1024*1024*1024);

// find bad users 1
$demotelist=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM $utables WHERE $udownloaded  > ".$min_dl." AND $uuploaded/$udownloaded <= ".$ban["wb_one"]." AND id_level=".$ban["wb_rank"]." AND rat_warn_level = 0 ");
while($demote=mysqli_fetch_assoc($demotelist)) 
{

// warn bad users 1  
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET rat_warn_level = 1 , rat_warn_time = NOW() WHERE id=".$demote["id"]);

// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

$plus= $setrep["rep_minrep"];

if ($setrep["rep_is_online"]== FALSE)
{
//do nothing
}
else
{
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET reputation = reputation - '$plus' WHERE id='$demote[id]'");
}
// DT reputation system end

// send pm bad users 1
$sub=sqlesc("Low Ratio Warning!");
$msg=sqlesc($art["wb_text_one"]);
send_pm(0,$demote[id],$sub,$msg);

// add warn symbol 1
if ($ban["wb_warn"]==TRUE)
{
$id=$demote["id"];

$warnreason="Low Ratio Warning";
$warnaddedby="System";
$added=warn_expiration(mktime(date('H')+2,date('i'),date('s'),date('m'),date('d')+addslashes($ban['wb_days_one']),date('Y')));

quickQuery('UPDATE '.$TABLE_PREFIX.'users SET warn="yes",warns=warns+1,warnreason="'.$warnreason.'",warnaddedby="'.$warnaddedby.'",warnadded="'.$added.'" WHERE id='.$id);
}
}
// time date stuff
$time_AA=(86400 * $ban['wb_days_one']);
$time_BB = strtotime(now);
$time_CC = ($time_BB - $time_AA);

// find bad users 2
$demotelistt=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id,rat_warn_time FROM $utables WHERE $udownloaded  > ".$min_dl." AND $uuploaded/$udownloaded <= ".$ban["wb_two"]." AND id_level=".$ban["wb_rank"]." AND rat_warn_level = 1 ");
while($demotee=mysqli_fetch_assoc($demotelistt)) 
{
$time_DD = strtotime($demotee["rat_warn_time"]);

if ( $time_DD <= $time_CC)
{
// warn bad users 2
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET rat_warn_level = 2 , rat_warn_time = NOW() WHERE id=".$demotee["id"]);

// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

$plus= $setrep["rep_minrep"];

if ($setrep["rep_is_online"]== FALSE)
{
//do nothing
}
else
{
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET reputation = reputation - '$plus' WHERE id='$demotee[id]'");
}
// DT reputation system end

// send pm bad users 2
$sub=sqlesc("Low Ratio Warning Two!");
$msg=sqlesc($art["wb_text_two"]);
send_pm(0,$demotee[id],$sub,$msg);

// add warn symbol 2
if ($ban["wb_warn"]==TRUE)
{
$warnreason="Low Ratio Warning";
$warnaddedby="System";
$added=warn_expiration(mktime(date('H')+2,date('i'),date('s'),date('m'),date('d')+addslashes($ban['wb_days_two']),date('Y')));

quickQuery('UPDATE '.$TABLE_PREFIX.'users SET warn="yes",warns=warns+1,warnreason="'.$warnreason.'",warnaddedby="'.$warnaddedby.'",warnadded="'.$added.'" WHERE id='.$id);
}
}
}
// unwarn user who did improve
$unwarnone=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id,rat_warn_time FROM $utables WHERE $udownloaded  > ".$min_dl." AND $uuploaded/$udownloaded > ".$ban["wb_one"]." AND id_level=".$ban["wb_rank"]." AND rat_warn_level = 1 ");
while($unwarna=mysqli_fetch_assoc($unwarnone)) 
{
$iid=$unwarna["id"];
quickQuery('UPDATE '.$TABLE_PREFIX.'users SET rat_warn_level=rat_warn_level-1 WHERE id='.$iid);	
}

// time date stuff
$time_EE=(86400 * $ban['wb_days_two']);
$time_FF = ($time_BB - $time_EE);

// find bad users 3
$demotelisttt=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id,rat_warn_time FROM $utables WHERE $udownloaded  > ".$min_dl." AND $uuploaded/$udownloaded <= ".$ban["wb_three"]." AND id_level=".$ban["wb_rank"]." AND rat_warn_level = 2 ");
while($demoteee=mysqli_fetch_assoc($demotelisttt)) 
{
$time_GG = strtotime($demoteee["rat_warn_time"]);

if ( $time_GG <= $time_FF)
{
// warn bad users 3
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET rat_warn_level = 3 , rat_warn_time = NOW() WHERE id=".$demoteee["id"]);

// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

$plus= $setrep["rep_minrep"];

if ($setrep["rep_is_online"]== FALSE)
{
//do nothing
}
else
{
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET reputation = reputation - '$plus' WHERE id='$demoteee[id]'");
}
// DT reputation system end

// send pm bad users 3
$sub=sqlesc("Final Low Ratio Warning!");
$msg=sqlesc($art["wb_text_fin"]);
send_pm(0,$demoteee[id],$sub,$msg);

// add warn symbol 3
if ($ban["wb_warn"]==TRUE)
{
$id=$demoteee["id"];

$warnreason="Low Ratio Warning";
$warnaddedby="System";
$added=warn_expiration(mktime(date('H')+2,date('i'),date('s'),date('m'),date('d')+addslashes($ban['wb_days_fin']),date('Y')));

quickQuery('UPDATE '.$TABLE_PREFIX.'users SET warn="yes",warns=warns+1,warnreason="'.$warnreason.'",warnaddedby="'.$warnaddedby.'",warnadded="'.$added.'" WHERE id='.$id);
}
}
}
// unwarn user who did improve 2
$unwarntwo=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id,rat_warn_time FROM $utables WHERE $udownloaded  > ".$min_dl." AND $uuploaded/$udownloaded > ".$ban["wb_two"]." AND id_level=".$ban["wb_rank"]." AND rat_warn_level = 2 ");
while($unwarnb=mysqli_fetch_assoc($unwarntwo)) 
{
$oid=$unwarnb["id"];
quickQuery('UPDATE '.$TABLE_PREFIX.'users SET rat_warn_level=rat_warn_level-2 WHERE id='.$oid);	
}
// time date stuff
$time_HH=(86400 * $ban['wb_days_fin']);
$time_II = ($time_BB - $time_HH);

// find bad users 4
$demotelistttt=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id,rat_warn_time FROM $utables WHERE $udownloaded  > ".$min_dl." AND $uuploaded/$udownloaded <= ".$ban["wb_fin"]." AND id_level=".$ban["wb_rank"]." AND rat_warn_level = 3 ");
while($demoteeee=mysqli_fetch_assoc($demotelistttt)) 
{
$time_JJ = strtotime($demoteeee["rat_warn_time"]);

if ( $time_JJ <= $time_II)
{
// ban bad users 4  

if ($btit_settings["en_sys"]==TRUE)
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET rat_warn_level = 4 ,rat_warn_time = NOW(), id_level=".$btit_settings["dm_id"]." WHERE id=".$demoteeee["id"]);
else
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET rat_warn_level = 4 ,rat_warn_time = NOW(), bandt='yes' WHERE id=".$demoteeee["id"]);

}
}
// unwarn user who did improve last
$unwarnthree=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id,rat_warn_time FROM $utables WHERE $udownloaded  > ".$min_dl." AND $uuploaded/$udownloaded > ".$ban["wb_three"]." AND id_level=".$ban["wb_rank"]." AND rat_warn_level = 3 ");
while($unwarnc=mysqli_fetch_assoc($unwarnthree)) 
{
$lid=$unwarnc["id"];
quickQuery('UPDATE '.$TABLE_PREFIX.'users SET rat_warn_level=rat_warn_level-3 WHERE id='.$lid);	
}
}
}
// warn-ban system with acp end

//  optimize peers table
         quickQuery("OPTIMIZE TABLE {$TABLE_PREFIX}peers");

// delete readposts when topic don't exist or deleted  *** should be done by delete, just in case
         quickQuery("DELETE readposts FROM {$TABLE_PREFIX}readposts LEFT JOIN topics ON readposts.topicid = topics.id WHERE topics.id IS NULL");
         
// delete readposts when users was deleted *** should be done by delete, just in case
         quickQuery("DELETE readposts FROM {$TABLE_PREFIX}readposts LEFT JOIN users ON readposts.userid = users.id WHERE users.id IS NULL");
         
// deleting orphan image in captcha folder (if image code is enabled)
 $CAPTCHA_FOLDER = realpath("$CURRENTPATH/../$CAPTCHA_FOLDER");
    if($dir = @opendir($CAPTCHA_FOLDER."/"))
    {
        while(false !== ($file = @readdir($dir)))
        {
            if($ext = substr(strrchr($file, "."), 1) == "png")
                unlink("$CAPTCHA_FOLDER/$file");
        }
        @closedir($dir);
    
    }
         
quickQuery("UPDATE `{$TABLE_PREFIX}users` SET `birthday_bonus`=0 WHERE DAYOFMONTH(`dob`)!=".date('j'));
         
 $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `u`.`id`, `u`.`dob`,`l`.`language_url` FROM `{$TABLE_PREFIX}users` `u` LEFT JOIN `language` `l` ON `u`.`language`=`l`.`id` WHERE DAYOFMONTH(`u`.`dob`)=".date('j')." AND MONTH(`u`.`dob`)=".date('n')." AND `u`.`dob`!=CURDATE() AND `u`.`birthday_bonus`=0 ORDER BY `l`.`language_url` ASC");
         if(@mysqli_num_rows($res)>0)
         {
             global $THIS_BASEPATH;
             $firstrun=1;
             $englang="language/english";
             $templang=$englang;
             require_once($THIS_BASEPATH."/".$englang."/lang_main.php");

             while($row=mysqli_fetch_assoc($res))
             {
                 if($row["language_url"]!=$templang)
                 {
                     if($firstrun!=1)
                     {
// Reset the language to English before loading the new language
                         require_once($THIS_BASEPATH."/".$englang."/lang_main.php");
                     }
// Load the new language etc.
                     require_once($THIS_BASEPATH."/".$row["language_url"]."/lang_main.php");
                     $templang=$row["language_url"];
                     $firstrun=0;
                 }
                 $dob=explode("-", $row["dob"]);
                 $age=userage($dob[0], $dob[1], $dob[2]);
                 $bonus=round($age*$btit_settings["birthday_bonus"]*1073741824);
                 $query1="UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=`uploaded`+$bonus, `birthday_bonus`=1 WHERE `id`=".$row["id"];
                 quickQuery($query1);
                 send_pm(0,$row["id"],addslashes($language["HB_SUBJECT"]),addslashes($language["HB_MESSAGE_1"] . makesize($bonus) . $language["HB_MESSAGE_2"] . $btit_settings["birthday_bonus"] . $language["HB_MESSAGE_3"]));
             }
         }

//timed rank
    $datetimedt = date("Y-m-d H:i:s");
    $rankstats = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE timed_rank < '$datetimedt' AND rank_switch='yes'");
      while ($arrdt = mysqli_fetch_assoc($rankstats))
    {
	  if (mysqli_num_rows($rankstats) > 0)
	  {
$res6 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT level FROM {$TABLE_PREFIX}users_level WHERE id ='$arrdt[old_rank]'");
$arr6 = mysqli_fetch_assoc($res6);
$oldrank = $arr6[level];

$subj = sqlesc("Your timed rank is expired !");
$msg = sqlesc("Your timed rank is expired !\n\n Your rank did changed back to ".$oldrank."\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]");

   send_pm(0,$arrdt["id"],$subj,$msg);
   mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET rank_switch='no', id_level = old_rank WHERE id='$arrdt[id]'") or sqlerr();
   }
 }
//timed rank end

//begin invitation system by dodge
global $INV_EXPIRES;
$deadtime = $INV_EXPIRES * 86400;
$user = do_sqlquery("SELECT inviter FROM {$TABLE_PREFIX}invitations WHERE time_invited < DATE_SUB(NOW(), INTERVAL $deadtime SECOND)");
@$arr = mysqli_fetch_assoc($user);
if (mysqli_num_rows($user) > 0)
{
    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET invitations=invitations+1 WHERE id = '" .
        $arr["inviter"] . "'");
    mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}invitations WHERE inviter = '" . $arr["inviter"] .
        "' AND time_invited < DATE_SUB(NOW(), INTERVAL $deadtime SECOND)");
}
//end invitation system
    
do_updateranks();

// auto ext update
        $num_torrents_to_update = 5;
        $torrents = get_result("SELECT `announces`, `info_hash` FROM `{$TABLE_PREFIX}files` WHERE `external`='yes' ORDER BY `lastupdate` DESC LIMIT ".$num_torrents_to_update);
        if(count($torrents)>0)
        {
            require_once ("getscrape.php");
            for($i = 0; $i < count($torrents); $i++)
            {
                $announces = @unserialize($torrents[$i]['announces'])?unserialize($torrents[$i]['announces']):array();
                if(count($announces)>0)
                {
                    $keys = array_keys($announces);
                    $random = mt_rand(0, count($keys) - 1);
                    $url = $keys[$random];
                    scrape($url, $torrents[$i]['info_hash']);
                }
            }
        }
// auto ext update		

// OK We're finished, let's reset max_execution_time and memory_limit back to the php.ini defaults
    @ini_restore("max_execution_time");
    @ini_restore("memory_limit");		
		}
?>