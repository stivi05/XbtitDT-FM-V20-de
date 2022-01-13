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

$CURRENTPATH = dirname(__FILE__);

global $btit_settings;
if ($btit_settings["error"]==false)
{
if(version_compare(PHP_VERSION, '5.3.0', '<=')) 
error_reporting(E_ALL&~E_NOTICE&~E_WARNING&~E_STRICT&~'E_DEPRECATED'); 
else 
error_reporting(E_ALL&~E_NOTICE&~E_WARNING&~E_STRICT&~E_DEPRECATED);
}

//create some logging :)
require_once($CURRENTPATH.'/conextra.php');
$signon= getConnection ();
$prefix=getPrefix ();
$logname=mysqli_fetch_row(mysqli_query($signon, "SELECT `value` FROM {$prefix}settings WHERE `key`='php_log_name' LIMIT 1"));
$logpath=mysqli_fetch_row(mysqli_query($signon, "SELECT `value` FROM {$prefix}settings WHERE `key`='php_log_path' LIMIT 1"));
$when=@date("d.m.y");
ini_set('log_errors','On'); // enable or disable php error logging (use 'On' or 'Off')
ini_set('error_log',''.$logpath[0].'/'.$logname[0].'_'.$when.'_.log'); // path to server-writable log file

#
// Emulate register_globals off
#
$php_version=explode(".",phpversion());
if($php_version[0]<=5 && $php_version[1]<=2)
{
    if (@ini_get('register_globals'))
    {
        $superglobals = array($_SERVER, $_ENV,$_FILES, $_COOKIE, $_POST, $_GET);
        if (isset($_SESSION))
            array_unshift($superglobals, $_SESSION);
        foreach ($superglobals as $superglobal)
            foreach ($superglobal as $global => $value)
                unset($GLOBALS[$global]);
        @ini_set('register_globals', false);
    }
}

// control if magic_quote_gpc = on
if(get_magic_quotes_gpc()){
  // function which remove unwanted slashes
  function remove_magic_quotes(&$array) {
    foreach($array as $key => $val)
      if(is_array($val))
        remove_magic_quotes($array[$key]);
      elseif (is_string($val))
        $array[$key] = str_replace(array('\\\\','\\\"',"\'"),array('\\','\"',"'"),$val);
  }

  remove_magic_quotes($_POST);
  remove_magic_quotes($_GET);
  remove_magic_quotes($_REQUEST);
  remove_magic_quotes($_SERVER);
  remove_magic_quotes($_FILES);
  remove_magic_quotes($_COOKIE);
}

@date_default_timezone_set(@date_default_timezone_get());

include $CURRENTPATH.'/xbtit_version.php';
require_once $CURRENTPATH.'/config.php';
require_once $CURRENTPATH.'/common.php';
require_once $CURRENTPATH.'/smilies.php';
# protection against sql injection, xss attack
require_once $CURRENTPATH.'/crk_protection.php';
# including various classes
require_once $CURRENTPATH.'/class.bbcode.php';
require_once $CURRENTPATH.'/class.captcha.php';
require_once $CURRENTPATH.'/class.ajaxpoll.php';

if (!isset($TRACKER_ANNOUNCEURLS)) {
  $TRACKER_ANNOUNCEURLS=array();
  $TRACKER_ANNOUNCEURLS[]=$BASEURL.'/announce.php';
}

//gets the match content
function pretime_get_match($regex,$content)
{
        preg_match($regex,$content,$matches);
        return $matches[1];
}

//gets the data from a URL
function pretime_get_data($url)
{
        $ch = curl_init();
        $timeout = 3;
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
}
function pretime_read($rel) {
         $rel = str_replace(" ", ".", $rel);
         $predburl = "http://predb.me/?search=".$rel;
         //get the page content
         $pretime_content = pretime_get_data($predburl);
         //parse pretime unix timestamp
         $pretime = @pretime_get_match('/<span class="p-time" data="(.*)" title="/isU',$pretime_content);
         $pretime = intval($pretime, 0);
         if ($pretime == ''){
                sleep(3);
               $predburl = "http://predb.me/?search=".$rel;
               //get the page content
               $pretime_content = pretime_get_data($predburl);
               //parse pretime unix timestamp
               $pretime = @pretime_get_match('/<span class="p-time" data="(.*)" title="/isU',$pretime_content);
               $pretime = intval($pretime, 0);
         }
		 return $pretime;
}

function happyHour() {
$nextDay = date("Y-m-d" , time()+86400 );
$nextHoura = mt_rand(0,2);
if ($nextHoura == 2)
$nextHourb = mt_rand(0,3);
else
$nextHourb = mt_rand(0,9);
$nextHour = $nextHoura.$nextHourb;
$nextMina = mt_rand(0,5);
$nextMinb = mt_rand(0,9);
$nextMin = $nextMina.$nextMinb;
$happyHour = $nextDay." ".$nextHour.":".$nextMin."";
return $happyHour;
}
function ishappyHour($n){
global $TABLE_PREFIX;

$happyHour = mysqli_result(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT UNIX_TIMESTAMP(value_s) FROM {$TABLE_PREFIX}avps WHERE arg='happyhour'"),0);
$happyDate = date("Y-m-d H:i" , $happyHour);
$curDate = date("Y-m-d H:i");
$nextDate= date("Y-m-d H:i", $happyHour + 3600);
if ($n == "check"){
if  ($happyDate < $curDate && $nextDate >= $curDate )
return true;
}
if ($n == "time"){
$timeLeft =(($happyHour + 3600)-time());
return NDF($timeLeft);
}}

if(!function_exists('mysqli_result'))
{
function mysqli_result($res, $row, $field=0) {
$res->data_seek($row);
$datarow = $res->fetch_array();
return $datarow[$field];
}
}

function print_disclaimer()
{

if (file_exists("include/disclaimer.php"))
    {
     include("include/disclaimer.php");
     }
  else
      $disclaimer="";

return $disclaimer;
	
}

function updateSticky($hash,$sticky)
{
    global $TABLE_PREFIX;
    $query = "UPDATE {$TABLE_PREFIX}files 
                   SET sticky='$sticky'
                   WHERE info_hash ='$hash'";
    do_sqlquery($query,true);
   
}

function getLevel($cur_level)
{
    global $TABLE_PREFIX;
    $query = "SELECT id, id_level FROM {$TABLE_PREFIX}users_level";
    $rez = do_sqlquery($query,true);
    
    while($row = mysqli_fetch_assoc($rez))
    {
        if($row['id'] == $cur_level)
        {
            return $row['id_level'];
        }
    }
    return 0;
}

function genrelistrules($append='',$table='rules')
     {

     global $TABLE_PREFIX;

    $ret = array();
    $res = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}$table WHERE active != '-1' ".$append." ORDER BY sort_index");

    while ($row = mysqli_fetch_assoc($res))
        $ret[] = $row;

    unset($row);
    ((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

    return $ret;
}

function shout_user_color($username)
{
  global $TABLE_PREFIX;

$col=get_result("SELECT u.id, ul.prefixcolor FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id WHERE u.username=".sqlesc($username)."",false,0);
$scan=array("<span style='color:","'>"," ");
$changes=array("","");
$col[0]['prefixcolor']=str_replace($scan,$changes,$col[0]['prefixcolor']);
return unesc("[color=".$col[0]['prefixcolor']."]".$username."[/color]");
}

function genrelistfaq($append='',$table='faq')
     {

     global $TABLE_PREFIX;

    $ret = array();
    $res = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}$table WHERE active != '-1' ".$append." ORDER BY id");

    while ($row = mysqli_fetch_assoc($res))
        $ret[] = $row;

    unset($row);
    ((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

    return $ret;
}

function getStatus($gold=0)
{
    if($gold == 0)
    {
        return 'Classic';
    }
    if($gold == 1)
    {
        return 'Silver';
    }if($gold == 2)
    {
        return 'Gold';
    }
    return 'none';
}

function createUsersLevelCombo($selected=0)
     {

     global $TABLE_PREFIX;

    $ret = array();
    $res = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}users_level ORDER BY id");

    while ($row = mysqli_fetch_assoc($res))
        $ret[] = $row;

    unset($row);
    ((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

    $gold_select_box = "
      <select name='level' >";
      foreach ($ret as $key=>$value)
      {
        $s='';
        if($value['id_level']==$selected)
        {
            $s='selected';
        }
        $gold_select_box .="<option value='".$value['id_level']."' ".$s.">".$value['level']."</option>";
        
      }
      $gold_select_box .='</select><div id="description"></div>';
      
      return $gold_select_box;
}

function base32_encode ($inString)
{
   $outString = "";
   $compBits = "";
   $BASE32_TABLE = array(
                         '00000' => 0x61,
                         '00001' => 0x62,
                         '00010' => 0x63,
                         '00011' => 0x64,
                         '00100' => 0x65,
                         '00101' => 0x66,
                         '00110' => 0x67,
                         '00111' => 0x68,
                         '01000' => 0x69,
                         '01001' => 0x6a,
                         '01010' => 0x6b,
                         '01011' => 0x6c,
                         '01100' => 0x6d,
                         '01101' => 0x6e,
                         '01110' => 0x6f,
                         '01111' => 0x70,
                         '10000' => 0x71,
                         '10001' => 0x72,
                         '10010' => 0x73,
                         '10011' => 0x74,
                         '10100' => 0x75,
                         '10101' => 0x76,
                         '10110' => 0x77,
                         '10111' => 0x78,
                         '11000' => 0x79,
                         '11001' => 0x7a,
                         '11010' => 0x32,
                         '11011' => 0x33,
                         '11100' => 0x34,
                         '11101' => 0x35,
                         '11110' => 0x36,
                         '11111' => 0x37,
                         );

   /* Turn the compressed string into a string that represents the bits as 0 and 1. */
   for ($i = 0; $i < strlen($inString); $i++) {
       $compBits .= str_pad(decbin(ord(substr($inString,$i,1))), 8, '0', STR_PAD_LEFT);
   }

   /* Pad the value with enough 0's to make it a multiple of 5 */
   if((strlen($compBits) % 5) != 0) {
       $compBits = str_pad($compBits, strlen($compBits)+(5-(strlen($compBits)%5)), '0', STR_PAD_RIGHT);
   }

   /* Create an array by chunking it every 5 chars */
   $fiveBitsArray = explode("\n",rtrim(chunk_split($compBits, 5, "\n")));

   /* Look-up each chunk and add it to $outstring */
   foreach($fiveBitsArray as $fiveBitsString) {
       $outString .= chr($BASE32_TABLE[$fiveBitsString]);
   }

   return $outString;
}

function createGoldCategories($selected='')
{
        global $TABLE_PREFIX;
      $gold_categories = array(
                0=>'Classic (0% free leach)',
                1=>'Silver (50% free leach)',
                2=>'Gold (100% free leach)'
      );
      $g_desc = '';
      $s_desc = '';
      $c_desc = '';
        $res=get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'",true);
            foreach ($res as $key=>$value)
            {
                $g_desc = $value["gold_description"];
                $s_desc = $value["silver_description"];
                $c_desc = $value["classic_description"];
            }
      $gold_select_box = "
      <select name='gold' onchange=\"function ajde(val,c_desc,s_desc,g_desc)
      {
            var div = document.getElementById('description');
            if(val==0)
            {
            div.innerHTML = 'Note: $c_desc';
            }
            if(val==1)
            {
            div.innerHTML = 'Note: $s_desc';
            }
            if(val==2)
            {
            div.innerHTML = 'Note: $g_desc';
            }
      }
      ajde(this.value)\">";
      foreach ($gold_categories as $key=>$value)
      {
        $s='';
        if($key==$selected)
        {
            $s='selected';
        }
        $gold_select_box .="<option value='".$key."' ".$s.">".$value."</option>";
        
      }
      $gold_select_box .='</select><div id="description"></div>';
      return $gold_select_box;
}
//end gold


  function updatemoder($prefix, $moder, $id)
  {
  	do_sqlquery("UPDATE {$prefix}files SET moder = '$moder' WHERE info_hash = '".$id."'");
  }
  
  function getmoderdetails($mod,$hash)
  {
  	global $CURUSER;
  	if ($CURUSER["edit_torrents"]=="yes" && $CURUSER['moderate_trusted']=='yes') {
						$link="<a title=\"".$mod."\" href=\"index.php?page=edit&info_hash=".$hash."\"><img alt=\"".$mod."\" src=\"images/mod/".$mod.".png\"></a>";
						}
						else {
						$link="<img alt=\"".$mod."\" src=\"images/mod/".$mod.".png\">";
						}
						$resend='';
					if($mod=='bad')
					{
						$resend = '<br/>(Edit your torret to resend torrent for validation)';
					}

					return $link.$resend;
  }
  function genrelistreasons()
     {

     global $TABLE_PREFIX;

    $ret = array();
    $res = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}warn_reasons ORDER BY id");

    while ($row = mysqli_fetch_assoc($res))
        $ret[] = $row;

    unset($row);
    ((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);

    return $ret;
}
  function updatemoderbyhash($moder,$torhash)
  {
  	global $TABLE_PREFIX;
  	do_sqlquery("UPDATE {$TABLE_PREFIX}files SET moder = '$moder' WHERE info_hash = '" . $torhash . "'",true);
  }
  function getmoderstatusbyhash($hash)
  {
  	global $TABLE_PREFIX;
  	$query ="SELECT moder FROM {$TABLE_PREFIX}files  WHERE info_hash ='" . $hash . "'";


  	$res = do_sqlquery($query,true);
  	$results = mysqli_fetch_assoc($res);

  	return $results['moder'];
  }
function load_css($css_name) {
  // control if input template name exist in current user's stylepath, else return default
  global $BASEURL, $STYLEPATH, $STYLEURL;

  if (@file_exists($STYLEPATH.'/'.$css_name))
    return $STYLEURL.'/'.$css_name;
  return $BASEURL.'/style/xbtit_default/'.$css_name;
}

function load_template($tpl_name) {
  // control if input template name exist in current user's stylepath, else return default
  global $THIS_BASEPATH, $STYLEPATH;

  if (@file_exists($STYLEPATH.'/'.$tpl_name))
    return $STYLEPATH.'/'.$tpl_name;
  return $THIS_BASEPATH.'/style/xbtit_default/'.$tpl_name;
}

function load_language($mod_language_name) {
  // control if input language exist in current user's language path, else return default
  global $THIS_BASEPATH, $USERLANG, $language;

  if (@file_exists($USERLANG.'/'.$mod_language_name)) {
    if ($USERLANG != $THIS_BASEPATH.'/language/english')
      include_once $THIS_BASEPATH.'/language/english/'.$mod_language_name;
    return $USERLANG.'/'.$mod_language_name;
  }
  return $THIS_BASEPATH.'/language/english/'.$mod_language_name;
}

function get_combo($select, $opts=array()) {
  $name=(isset($opts['name']))?' name="'.$opts['name'].'"':'';
  $complete=(isset($opts['complete']))?(bool)$opts['complete']:false;
  $default=(isset($opts['default']))?$opts['default']:NULL;
  $id=(isset($opts['id']))?$opts['id']:'id';
  $value=(isset($opts['value']))?$opts['value']:'value';
  $combo='';

  if ($complete)
    $combo.='<select'.$name.'>';

  foreach ($select as $option) {
    $combo.="\n".'<option ';
    if ( (!is_null($default)) && ($option[$id]==$default) )
      $combo.='selected="selected" ';
    $combo.='value="'.$option[$id].'">'.unesc($option[$value]).'</option>';
  }

  if ($complete)
    $combo.='</select>';

  return $combo;
}

function get_microtime() {
  return strtok(microtime(), ' ') + strtok('');
}

function cut_string($ori_string,$cut_after) {
  $rchars=array('_','.','-');
  $ori_string=str_replace($rchars,' ',$ori_string);
  if (strlen($ori_string)>$cut_after && $cut_after>0)
    return substr($ori_string,0,$cut_after).'...';
  return $ori_string;
}

function print_debug($level=3, $key=' - ') {
    global $time_start, $gzip, $num_queries, $cached_querys;
    $time_end=get_microtime();
    switch ($level) {
        case '4':
            if (function_exists('memory_get_usage')) {
                $memory='[ Memory: '.makesize(memory_get_usage());
                if (function_exists('memory_get_peak_usage'))
                    $memory.='|'.makesize(memory_get_peak_usage());
                $return[]=$memory.' ]';
            }
        case '3':
            $return[]='[ GZIP: '.$gzip.' ]';
        case '2':
            $return[]='[ Script Execution: '.number_format(($time_end-$time_start),4).' sec. ]';
        case '1':
            $return[]='[ Queries: '.$num_queries.'|'.$cached_querys.' ]';
            break;
        default:
            return '';
    }
    return implode($key, array_reverse($return));
}


// VIP torrent
function getLevelVT($cur_level)
{
    global $TABLE_PREFIX;
    $query = "SELECT id, id_level FROM {$TABLE_PREFIX}users_level";
    $rez = do_sqlquery($query,true);

    while($row = mysqli_fetch_assoc($rez))
    {
        if($row['id'] == $cur_level)
        {
            return $row['id_level'];
        }
    }
    return 0;
}
// VIP torrent end
function print_version() {
  global $tracker_version;

  return '[&nbsp;&nbsp;<u>xbtit '.$tracker_version.' By</u>: <a href="http://www.websitecustomizers.net/" target="_blank">DiemThuy</a>&nbsp;&nbsp;]&nbsp;&nbsp;[&nbsp;&nbsp;<u>XBTIT Original By</u>: <a href="http://www.btiteam.org/" target="_blank">Btiteam</a>&nbsp;&nbsp;]';
}

function print_designer() {
  global $STYLEPATH;

  if (file_exists($STYLEPATH.'/style_copyright.php')) {
     include($STYLEPATH.'/style_copyright.php');
     $design_copyright='[&nbsp;&nbsp;<u>Design By</u>: '.$design_copyright.'&nbsp;&nbsp;]&nbsp;';
  } else
     $design_copyright='';
  return $design_copyright;
}
function print_top()
{
  return '<a href=\'#\'><img src="images/totop.gif" /></a>';
}

// check online passed session and user's location
// this function will update the information into
// online table (session ID, ip, user id and location
function check_online($session_id, $location) {
  global $TABLE_PREFIX, $CURUSER , $btit_settings;
  
 session_name("xbtit");
 session_start();
 $overOneMinute=(((isset($_SESSION["ONLINE_EXPIRE"]) && time() > $_SESSION["ONLINE_EXPIRE"]) || !isset($_SESSION["ONLINE_EXPIRE"]))?true:false);
 $locationHasChanged=(((isset($_SESSION["ONLINE_LOCATION"]) && $_SESSION["ONLINE_LOCATION"]!=$location) || !isset($_SESSION["ONLINE_LOCATION"]))?true:false);

  $location=sqlesc($location);
  $ip=getip();
  $uid=max(1,(int)$CURUSER['uid']);
  $suffix=sqlesc($CURUSER['suffixcolor']);
  $prefix=sqlesc($CURUSER['prefixcolor']);
  $uname=sqlesc($CURUSER['username']);
  $ugroup=sqlesc($CURUSER['level']);
  $invisible=sqlesc($CURUSER['invisible']);
  $immunity=sqlesc($CURUSER['immunity']);
  $donor=sqlesc($CURUSER['donor']);
  $warn=sqlesc($CURUSER['warn']);
  $booted=sqlesc($CURUSER['booted']);
  $dona=sqlesc($CURUSER['dona']);
  $donb=sqlesc($CURUSER['donb']);
  $birt=sqlesc($CURUSER['birt']);
  $mal=sqlesc($CURUSER['mal']);
  $fem=sqlesc($CURUSER['fem']);
  $bann=sqlesc($CURUSER['bann']);
  $war=sqlesc($CURUSER['war']);
  $par=sqlesc($CURUSER['par']);
  $bot=sqlesc($CURUSER['bot']);
  $trmu=sqlesc($CURUSER['trmu']);
  $trmo=sqlesc($CURUSER['trmo']);
  $vimu=sqlesc($CURUSER['vimu']);
  $vimo=sqlesc($CURUSER['vimo']);
  $friend=sqlesc($CURUSER['friend']);
  $junkie=sqlesc($CURUSER['junkie']);
  $staff=sqlesc($CURUSER['staff']);
  $sysop=sqlesc($CURUSER['sysop']);
  
  if ($uid==1)
    $where="WHERE session_id='$session_id'";
  else
    $where="WHERE user_id='$uid' OR session_id='$session_id'";
    
if($locationHasChanged || $overOneMinute)
{
  @quickQuery("UPDATE {$TABLE_PREFIX}online SET session_id='$session_id' ,invisible=$invisible , user_name=$uname, user_group=$ugroup, prefixcolor=$prefix, suffixcolor=$suffix, location=$location, user_id=$uid, donor=$donor,warn=$warn,booted=$booted,immunity=$immunity, dona=$dona,donb=$donb,birt=$birt,mal=$mal,fem=$fem,bann=$bann,war=$war,par=$par,bot=$bot,trmu=$trmu,trmo=$trmo,vimu=$vimu,vimo=$vimo,friend=$friend,junkie=$junkie,staff=$staff,sysop=$sysop, lastaction=UNIX_TIMESTAMP() $where");
  // record don't already exist, then insert it
  if (mysqli_affected_rows($GLOBALS["___mysqli_ston"])==0) { 
    @quickQuery("UPDATE {$TABLE_PREFIX}users SET lastconnect=NOW() WHERE id=$uid AND id>1");
    @quickQuery("INSERT INTO {$TABLE_PREFIX}online SET session_id='$session_id' ,invisible=$invisible , user_name=$uname, user_group=$ugroup, prefixcolor=$prefix, suffixcolor=$suffix, user_id=$uid, user_ip='$ip', location=$location, donor=$donor, warn=$warn,booted=$booted, immunity=$immunity, dona=$dona,donb=$donb,birt=$birt,mal=$mal,fem=$fem,bann=$bann,war=$war,par=$par,bot=$bot,trmu=$trmu,trmo=$trmo,vimu=$vimu,vimo=$vimo,friend=$friend,junkie=$junkie,staff=$staff,sysop=$sysop, lastaction=UNIX_TIMESTAMP()");
  }
  
	  	     }
 	  	     if($overOneMinute)
	  	     {
  $show3 = $_SERVER["HTTP_USER_AGENT"];
  $dtime=$btit_settings["timeout"];
  $timeout=time()-$dtime; 
  @quickQuery("UPDATE {$TABLE_PREFIX}users SET browser='".AddSlashes($show3)."' WHERE id = $uid") or sqlerr(__FILE__, __LINE__);
  @quickQuery("UPDATE {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}online ol ON ol.user_id = u.id SET u.lastconnect=NOW(), u.tot_on = u.tot_on + (UNIX_TIMESTAMP()- ol.lastaction), u.cip=ol.user_ip, u.lip=INET_ATON(ol.user_ip) WHERE ol.lastaction<$timeout AND ol.user_id>1");
  @quickQuery("DELETE FROM {$TABLE_PREFIX}online WHERE lastaction<$timeout");
  
    
 //ip change check
      $cip=$CURUSER['cip'];
      If($ip!=$cip) {
      $resdg = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}iplog WHERE uid=$uid");
      $numrows = mysqli_num_rows($resdg);
      If($numrows==0)
      mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}iplog (ip, date, uid, uipid) VALUES ('".AddSlashes($ip)."', NOW(), '$uid' , 1 )");
      elseIf($numrows==1)
      mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}iplog (ip, date, uid, uipid) VALUES ('".AddSlashes($ip)."', NOW(), '$uid' , 2 )");
      elseIf($numrows==2)
      mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}iplog (ip, date, uid, uipid) VALUES ('".AddSlashes($ip)."', NOW(), '$uid' , 3 )");
      elseIf($numrows==3)
      mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}iplog (ip, date, uid, uipid) VALUES ('".AddSlashes($ip)."', NOW(), '$uid' , 4 )");
      elseIf($numrows==4)
      mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}iplog (ip, date, uid, uipid) VALUES ('".AddSlashes($ip)."', NOW(), '$uid' , 5 )");
      else{
      $res1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT date FROM {$TABLE_PREFIX}iplog WHERE uid=$uid ORDER BY date ASC LIMIT 1");
      $row1 = mysqli_fetch_array($res1);
      $date=$row1["date"];
      mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}iplog SET ip='".AddSlashes($ip)."' AND date=NOW() WHERE uid='$uid' AND date='$date'");
      }
}
$_SESSION["ONLINE_EXPIRE"]=(time()+60);
}
$_SESSION["ONLINE_LOCATION"]=trim($location, "'");
}
//Disallow special characters in username

function get_user_icons($arr, $big = false)
{
  if ($big)
    {
     $donorpic = "donor_big.gif";
     $style = "style=\"margin-left: 4pt\"";
  }
  else
    {
     $donorpic = "donor.gif";
     $style = "style=\"margin-left: 2pt\"";
  }

  $pics = $arr["donor"]=="yes" ? "<img src=\"images/$donorpic\" alt=\"Donor\" border=\"0\" $style />" : "";

  return $pics;
}

function booted($arr, $unboot = false)
{
  if ($unboot)
    {
     $bootpic = "booted.gif";
     $style = "style=\"margin-left: 4pt\"";
  }
  else
    {
     $bootpic = "booted.gif";
     $style = "style=\"margin-left: 2pt\"";
  }

  $pic = $arr["booted"]=="yes" ? "<img src=\"images/$bootpic\" alt=\"DISABLED USER !\" border=\"0\" $style />" : "";

  return $pic;
}

function immunity($arr)
{

$immpic = "shield.png";
$style = "style=\"margin-left: 4pt\""; 

$picss = $arr["immunity"]=="yes" ? "<img src=\"images/$immpic\" title=\"User Have Immunity !\" alt=\"User Have Immunity !\" border=\"0\" $style />" : "";
return $picss;
}

function warn($arr, $big = false)
{
  if ($big)
    {
     $warnpic = "warn_big.gif";
     $style = "style=\"margin-left: 4pt\"";
  }
  else
    {
     $warnpic = "warn.gif";
     $style = "style=\"margin-left: 2pt\"";
  }

  $pics = $arr["warn"]=="yes" ? "<img src=\"images/$warnpic\" alt=\"WARNED USER !\" border=\"0\" $style />" : "";

  return $pics;
}

function straipos($haystack,$array,$offset=0) {
  $occ = array();
  for ($i=0,$len=count($array);$i<$len;$i++) {
    $pos = strpos($haystack,$array[$i],$offset);
    if (is_bool($pos))
          continue;
    $occ[$pos] = $i;
  }
  if (empty($occ))
      return false;
  ksort($occ);
  reset($occ);
  list($key,$value) = each($occ);
  return array($key,$value);
}

// Even if you're missing PHP 4.3.0, the MHASH extension might be of use.
// Someone was kind enought to email this code snippit in.
if (function_exists('mhash')&&(!function_exists('sha1'))&&defined('MHASH_SHA1')) {
  function sha1($str) {
    return bin2hex(mhash(MHASH_SHA1,$str));
  }
}

// begin of function added from original
function unesc($x) {
  return stripslashes($x);
}

function mksecret($len = 20) {
  $ret = '';
  for ($i = 0; $i < $len; $i++)
    $ret .= chr(mt_rand(0, 255));
  return $ret;
}

function logincookie($row, $user, $expires = 0x7fffffff)
{
    global $btit_settings;

    $my_cookie_name=((isset($btit_settings["secsui_cookie_name"]) && !empty($btit_settings["secsui_cookie_name"]))?$btit_settings["secsui_cookie_name"]:"xbtitLoginCookie");
    $my_cookie_path=((isset($btit_settings["secsui_cookie_path"]) && !empty($btit_settings["secsui_cookie_path"]))?$btit_settings["secsui_cookie_path"]:"/");
    $my_cookie_domain=((isset($btit_settings["secsui_cookie_domain"]) && !empty($btit_settings["secsui_cookie_domain"]))?$btit_settings["secsui_cookie_domain"]:false);
    
    if($btit_settings["secsui_cookie_type"]==1)
    {
        setcookie('uid', $row["id"], $expires, '/');
        setcookie('pass', md5($row["random"].$row["password"].$row["random"]), $expires, '/');
    }
    elseif($btit_settings["secsui_cookie_type"]==2  || $btit_settings["secsui_cookie_type"]==3)
    {
        $cookie_items=explode(",", $btit_settings["secsui_cookie_items"]);
        $cookie_string="";

        foreach($cookie_items as $ci_value)
        {
            $ci_exp=explode("-",$ci_value);
            if($ci_exp[0]==8)
            {
                $ci_exp2=explode("[+]", $ci_exp[1]);
                if($ci_exp2[0]==1)
                {
                    $ip_parts=explode(".", getip());

                    if($ci_exp2[1]==1)
                        $cookie_string.=$ip_parts[0]."-";
                    if($ci_exp2[1]==2)
                        $cookie_string.=$ip_parts[1]."-";
                    if($ci_exp2[1]==3)
                        $cookie_string.=$ip_parts[2]."-";
                    if($ci_exp2[1]==4)
                        $cookie_string.=$ip_parts[3]."-";
                    if($ci_exp2[1]==5)
                        $cookie_string.=$ip_parts[0].".".$ip_parts[1]."-";
                    if($ci_exp2[1]==6)
                        $cookie_string.=$ip_parts[1].".".$ip_parts[2]."-";
                    if($ci_exp2[1]==7)
                        $cookie_string.=$ip_parts[2].".".$ip_parts[3]."-";
                    if($ci_exp2[1]==8)
                        $cookie_string.=$ip_parts[0].".".$ip_parts[2]."-";
                    if($ci_exp2[1]==9)
                        $cookie_string.=$ip_parts[0].".".$ip_parts[3]."-";
                    if($ci_exp2[1]==10)
                        $cookie_string.=$ip_parts[1].".".$ip_parts[3]."-";
                    if($ci_exp2[1]==11)
                        $cookie_string.=$ip_parts[0].".".$ip_parts[1].".".$ip_parts[2]."-";
                    if($ci_exp2[1]==12)
                        $cookie_string.=$ip_parts[1].".".$ip_parts[2].".".$ip_parts[3]."-";
                    if($ci_exp2[1]==13)
                        $cookie_string.=$ip_parts[0].".".$ip_parts[1].".".$ip_parts[2].".".$ip_parts[3]."-";

                    unset($ci_exp2);
                }
            }
            else
            {
                if($ci_exp[0]==1 && $ci_exp[1]==1)
                {
                    $cookie_string.=$row["id"]."-";
                }
                if($ci_exp[0]==2 && $ci_exp[1]==1)
                {
                    $cookie_string.=$row["password"]."-";
                }
                if($ci_exp[0]==3 && $ci_exp[1]==1)
                {
                    $cookie_string.=$row["random"]."-";
                }
                if($ci_exp[0]==4 && $ci_exp[1]==1)
                {
                    $cookie_string.=strtolower($user)."-";
                }
                if($ci_exp[0]==5 && $ci_exp[1]==1)
                {
                    $cookie_string.=$row["salt"]."-";
                }
                if($ci_exp[0]==6 && $ci_exp[1]==1)
                {
                    $cookie_string.=$_SERVER["HTTP_USER_AGENT"]."-";
                }
                if($ci_exp[0]==7 && $ci_exp[1]==1)
                {
                    $cookie_string.=$_SERVER["HTTP_ACCEPT_LANGUAGE"]."-";
                }
            }
            unset($ci_exp);
        }
        $final_cookie=serialize(array("id" => $row["id"], "hash" => sha1(trim($cookie_string, "-"))));

        if($btit_settings["secsui_cookie_type"]==2)
        {
            $my_mult=60;
            if($btit_settings["secsui_cookie_exp2"]==2)
                $my_mult=3600;
            elseif($btit_settings["secsui_cookie_exp2"]==3)
                $my_mult=86400;
            elseif($btit_settings["secsui_cookie_exp2"]==4)
                $my_mult=604800;
            elseif($btit_settings["secsui_cookie_exp2"]==5)
                $my_mult=2592000;
            elseif($btit_settings["secsui_cookie_exp2"]==6)
                $my_mult=31536000;

            $my_cookie_expire=(($btit_settings["secsui_cookie_exp1"]*$my_mult)+time());
        
            if($my_cookie_expire>2147483647)
                $my_cookie_expire=$expires;

            setcookie("$my_cookie_name", "$final_cookie", $my_cookie_expire, "$my_cookie_path", "$my_cookie_domain");
        }
        else
        {
            session_name("xbtit");
            session_start();
            $_SESSION["login_cookie"]=$final_cookie;
        }
    }
    else
        return;
}

function logoutcookie()
{
    global $btit_settings;

    $my_cookie_name=((isset($btit_settings["secsui_cookie_name"]) && !empty($btit_settings["secsui_cookie_name"]))?$btit_settings["secsui_cookie_name"]:"xbtitLoginCookie");
    $my_cookie_path=((isset($btit_settings["secsui_cookie_path"]) && !empty($btit_settings["secsui_cookie_path"]))?$btit_settings["secsui_cookie_path"]:"/");
    $my_cookie_domain=((isset($btit_settings["secsui_cookie_domain"]) && !empty($btit_settings["secsui_cookie_domain"]))?$btit_settings["secsui_cookie_domain"]:false);

    setcookie("uid", "", (time()-3600), "/");
    setcookie("pass", "", (time()-3600), "/");
    setcookie("$my_cookie_name", "", (time()-3600), "$my_cookie_path", "$my_cookie_domain");
    setcookie("$my_cookie_name", "", (time()-3600), "/");
    session_name("xbtit");
    session_start();
    $_SESSION=array();
    setcookie("xbtit", "", time()-3600, "/");
    session_destroy();
}

function hash_pad($hash) {
  return str_pad($hash, 20);
}

function userlogin()
{
    global $CURUSER, $TABLE_PREFIX, $err_msg_install, $btit_settings, $update_interval, $THIS_BASEPATH, $STYLEPATH, $STYLEURL, $STYLETYPE, $BASEURL, $USERLANG;

    unset($GLOBALS['CURUSER']);

    session_name("xbtit");
    session_start();

    $ip = getip(); //$_SERVER["REMOTE_ADDR"];
    $nip = ip2long($ip);
    $res = get_result("SELECT * FROM {$TABLE_PREFIX}bannedip WHERE INET_ATON('".$ip."') >= first AND INET_ATON('".$ip."') <= last LIMIT 1;",true,$btit_settings['cache_duration']);
    if (count($res) > 0)
    {
        header('HTTP/1.0 403 Forbidden');
        ?>
        <html><body><h1>403 Forbidden</h1>Unauthorized IP address.</body></html>
        <?php
        die();
    }

    if(isset($_SESSION["CURUSER"]) && isset($_SESSION["CURUSER_EXPIRE"]))
    {
        if($_SESSION["CURUSER_EXPIRE"]>time())
        {
            if(!isset($STYLEPATH) || empty($STYLEPATH))
                $STYLEPATH=((is_null($_SESSION["CURUSER"]["style_path"]))?$THIS_BASEPATH."/style/xbtit_default":$_SESSION["CURUSER"]["style_path"]);
            if(!isset($STYLEURL) || empty($STYLEURL))
                $STYLEURL=((is_null($_SESSION["CURUSER"]["style_url"]))?$BASEURL."/style/xbtit_default":$_SESSION["CURUSER"]["style_url"]);
            if(!isset($STYLETYPE) || empty($STYLETYPE))
                $STYLETYPE=((is_null($_SESSION["CURUSER"]["style_type"]))?3:(int)0+$_SESSION["CURUSER"]["style_type"]);
            if(!isset($USERLANG) || empty($USERLANG))
                $USERLANG=((is_null($_SESSION["CURUSER"]["language_path"]))?$THIS_BASEPATH."/language/english":$THIS_BASEPATH."/".$_SESSION["CURUSER"]["language_url"]);
            $GLOBALS["CURUSER"]=$_SESSION["CURUSER"];
            return;
        }
        else
        {
            unset($_SESSION["CURUSER"]);
            unset($_SESSION["CURUSER_EXPIRE"]);
        }
    }

    if ($btit_settings['xbtt_use'])
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

    // guest   
    if($btit_settings["secsui_cookie_type"]==1)
        $id = (isset($_COOKIE["uid"]) && is_numeric($_COOKIE["uid"]) && $_COOKIE["uid"]>1) ? $id=(int)0+$_COOKIE["uid"] : $id=1;
    elseif($btit_settings["secsui_cookie_type"]==2)
    {
        $user_cookie_name=((isset($btit_settings["secsui_cookie_name"]) && !empty($btit_settings["secsui_cookie_name"]))?$btit_settings["secsui_cookie_name"]:"xbtitLoginCookie");
        if(isset($_COOKIE[$user_cookie_name]))
        {
            $user_cookie=unserialize($_COOKIE[$user_cookie_name]);
            $id=((is_numeric($user_cookie["id"]) && $user_cookie["id"]>1)?(int)0+$user_cookie["id"]:$id=1);
        }
        else
            $id=1;
    }
    elseif($btit_settings["secsui_cookie_type"]==3)
    {
        if(isset($_SESSION["login_cookie"]))
        {
            $user_cookie=unserialize($_SESSION["login_cookie"]);
            $id=((is_numeric($user_cookie["id"]) && $user_cookie["id"]>1)?(int)0+$user_cookie["id"]:$id=1);
        }
        else
            $id=1;
    }
    else
        $id=1;
        
//proxy
$respr = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}blacklist WHERE tip =". $nip ) or sqlerr(__FILE__, __LINE__);

if (
mysqli_num_rows($respr) > 0 ||
$_SERVER["HTTP_X_FORWARDED_FOR"] ||
$_SERVER["HTTP_X_FORWARDED"] ||
$_SERVER["HTTP_FORWARDED_FOR"] ||
$_SERVER["HTTP_VIA"] ||
$_SERVER["HTTP_FORWARDED"] ||
$_SERVER["HTTP_FORWARDED_FOR_IP"] ||
$_SERVER["HTTP_PROXY_CONNECTION"] ||
$_SERVER["VIA"] ||
$_SERVER["X_FORWARDED_FOR"] ||
$_SERVER["FORWARDED_FOR"] ||
$_SERVER["FORWARDED"] ||
$_SERVER["X_FORWARDED"] ||
$_SERVER["CLIENT_IP"] ||
$_SERVER["FORWARDED_FOR_IP"] ||
$_SERVER["HTTP_CLIENT_IP"] ||
in_array($_SERVER['REMOTE_PORT'], array(8080,80,6588,8000,3128,553,554))
)
{
$proxy='yes';
}
else
{
$proxy='no';
}
quickQuery("UPDATE {$TABLE_PREFIX}users SET proxy='$proxy' WHERE id = $id") or sqlerr(__FILE__, __LINE__);
//proxy

    if($id>1)
    {
        $res = do_sqlquery("SELECT u.profileview, u.team,u.commentpm,u.pchat,u.tor,u.gender,u.gotgift,u.dona,u.donb,u.birt,u.mal,u.fem,u.bann,u.war,u.par,u.bot,u.trmu,u.trmo,u.vimu,u.vimo,u.friend,u.junkie,u.staff,u.sysop, u.emailnot,  u.left_l, u.pid, u.cip, u.booted,u.announce,u.userbar, u.invisible, u.showporn , u.immunity, u.dob,u.warn, u.donor,u.seedbonus, u.salt, u.pass_type, u.lip, u.cip, $udownloaded as downloaded, $uuploaded as uploaded, u.smf_fid, u.ipb_fid, u.topicsperpage, u.postsperpage,u.torrentsperpage, u.flag, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect, UNIX_TIMESTAMP(u.joined) AS joined, u.id as uid, u.username, u.password, u.random, u.email, u.language,u.style, u.time_offset, ul.*, `s`.`style_url`, `s`.`style_type`, `l`.`language_url` FROM $utables INNER JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN `{$TABLE_PREFIX}style` `s` ON `u`.`style`=`s`.`id` LEFT JOIN `{$TABLE_PREFIX}language` `l` ON `u`.`language`=`l`.`id` WHERE u.id = $id LIMIT 1;",true);
        $row = mysqli_fetch_assoc($res);

        if($btit_settings["secsui_cookie_type"]==1)
        {
            if(md5($row["random"].$row["password"].$row["random"])!=$_COOKIE["pass"])
                $id=1;
        }
        elseif($btit_settings["secsui_cookie_type"]==2  || $btit_settings["secsui_cookie_type"]==3)
        {
            $cookie_items=explode(",", $btit_settings["secsui_cookie_items"]);
            $cookie_string="";

            foreach($cookie_items as $ci_value)
            {
                $ci_exp=explode("-",$ci_value);
                if($ci_exp[0]==8)
                {
                    $ci_exp2=explode("[+]", $ci_exp[1]);
                    if($ci_exp2[0]==1)
                    {
                        $ip_parts=explode(".", getip());

                        if($ci_exp2[1]==1)
                            $cookie_string.=$ip_parts[0]."-";
                        if($ci_exp2[1]==2)
                            $cookie_string.=$ip_parts[1]."-";
                        if($ci_exp2[1]==3)
                            $cookie_string.=$ip_parts[2]."-";
                        if($ci_exp2[1]==4)
                            $cookie_string.=$ip_parts[3]."-";
                        if($ci_exp2[1]==5)
                            $cookie_string.=$ip_parts[0].".".$ip_parts[1]."-";
                        if($ci_exp2[1]==6)
                            $cookie_string.=$ip_parts[1].".".$ip_parts[2]."-";
                        if($ci_exp2[1]==7)
                            $cookie_string.=$ip_parts[2].".".$ip_parts[3]."-";
                        if($ci_exp2[1]==8)
                            $cookie_string.=$ip_parts[0].".".$ip_parts[2]."-";
                        if($ci_exp2[1]==9)
                            $cookie_string.=$ip_parts[0].".".$ip_parts[3]."-";
                        if($ci_exp2[1]==10)
                            $cookie_string.=$ip_parts[1].".".$ip_parts[3]."-";
                        if($ci_exp2[1]==11)
                            $cookie_string.=$ip_parts[0].".".$ip_parts[1].".".$ip_parts[2]."-";
                        if($ci_exp2[1]==12)
                            $cookie_string.=$ip_parts[1].".".$ip_parts[2].".".$ip_parts[3]."-";
                        if($ci_exp2[1]==13)
                            $cookie_string.=$ip_parts[0].".".$ip_parts[1].".".$ip_parts[2].".".$ip_parts[3]."-";

                        unset($ci_exp2);
                    }
                }
                else
                {
                    if($ci_exp[0]==1 && $ci_exp[1]==1)
                    {
                        $cookie_string.=$row["uid"]."-";
                    }
                    if($ci_exp[0]==2 && $ci_exp[1]==1)
                    {
                        $cookie_string.=$row["password"]."-";
                    }
                    if($ci_exp[0]==3 && $ci_exp[1]==1)
                    {
                        $cookie_string.=$row["random"]."-";
                    }
                    if($ci_exp[0]==4 && $ci_exp[1]==1)
                    {
                        $cookie_string.=strtolower($row["username"])."-";
                    }
                    if($ci_exp[0]==5 && $ci_exp[1]==1)
                    {
                        $cookie_string.=$row["salt"]."-";
                    }
                    if($ci_exp[0]==6 && $ci_exp[1]==1)
                    {
                        $cookie_string.=$_SERVER["HTTP_USER_AGENT"]."-";
                    }
                    if($ci_exp[0]==7 && $ci_exp[1]==1)
                    {
                        $cookie_string.=$_SERVER["HTTP_ACCEPT_LANGUAGE"]."-";
                    }
                }
                unset($ci_exp);
            }
            $final_cookie["hash"]=sha1(trim($cookie_string, "-"));

            if($final_cookie["hash"]!=$user_cookie["hash"])
                $id=1;
        }
    }
    if($id==1)
    {
        $res = do_sqlquery("SELECT  u.profileview, u.team,u.commentpm,u.pchat,u.tor,u.gender,u.gotgift,u.emailnot, u.dona,u.donb,u.birt,u.mal,u.fem,u.bann,u.war,u.par,u.bot,u.trmu,u.trmo,u.vimu,u.vimo,u.friend,u.junkie,u.staff,u.sysop,  u.left_l, u.pid, u.cip,u.booted,u.announce,u.userbar, u.invisible, u.showporn , u.immunity, u.dob, u.warn, u.donor,u.seedbonus, u.salt, u.pass_type, u.lip, u.cip, $udownloaded as downloaded, $uuploaded as uploaded, u.smf_fid, u.ipb_fid, u.topicsperpage, u.postsperpage,u.torrentsperpage, u.flag, u.avatar, UNIX_TIMESTAMP(u.lastconnect) AS lastconnect, UNIX_TIMESTAMP(u.joined) AS joined, u.id as uid, u.username, u.password, u.random, u.email, u.language,u.style, u.time_offset, ul.*, `s`.`style_url`, `s`.`style_type`, `l`.`language_url` FROM $utables INNER JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN `{$TABLE_PREFIX}style` `s` ON `u`.`style`=`s`.`id` LEFT JOIN `{$TABLE_PREFIX}language` `l` ON `u`.`language`=`l`.`id` WHERE u.id = 1 LIMIT 1;",true);
        $row = mysqli_fetch_assoc($res);
    }

     
// warn-ban system with acp by DT
$resdt=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT ban,bandt,booted,addbooted,whybooted FROM {$TABLE_PREFIX}users WHERE id=".$id);
$rowdt=mysqli_fetch_array($resdt);
if ($rowdt["bandt"] == "yes" or $rowdt["ban"] == "yes" or $rowdt["booted"] == "yes")
{
header('HTTP/1.0 403 Forbidden');
?>
<html><body><h1>403 Forbidden</h1>You are Banned from this site !</body></html>
<?php
if ($rowdt["booted"] == "yes")
echo "<br><br>The reason :" .$rowdt["whybooted"];
echo "<br><br><font color = red>But .... we give you one more change , you can come back , and login after : " .$rowdt["addbooted"]."</font>";

die();

}
else
{
}
// warn-ban system with acp by DT



// bots start 
$crawler = crawlerDetect($_SERVER['HTTP_USER_AGENT']);

if ($crawler )
{
@quickQuery("INSERT INTO {$TABLE_PREFIX}bots (name,visit) VALUES ('$crawler',NOW())") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
}
else
{
// usual visitor
}
// bots end 

// CHECK FOR INSTALLATION FOLDER WITHOUT INSTALL.ME
    if ($row['id_level']==8 && (file_exists('install.php') || file_exists('upgrade.php'))) // only owner level
        $err_msg_install='<div align="center" style="color:red; font-size:12pt; font-weight: bold;">SECURITY WARNING: Delete install.php & upgrade.php!</div>';

    elseif ($btit_settings["site_offline"] && $row["id_level"]==8)
         $err_msg_install=("<div align=\"center\" style=\"color:red; font-size:12pt; font-weight: bold;\">REMEMBER: ".$btit_settings["name"]." is currently offline.</div>");
    else
        $err_msg_install='';

    if(!isset($STYLEPATH) || empty($STYLEPATH))
        $STYLEPATH=$THIS_BASEPATH."/".((is_null($row["style_url"]))?"style/xbtit_default":$row["style_url"]);
    if(!isset($STYLEURL) || empty($STYLEURL))
        $STYLEURL=$BASEURL."/".((is_null($row["style_url"]))?"style/xbtit_default":$row["style_url"]);
    if(!isset($STYLETYPE) || empty($STYLETYPE))
        $STYLETYPE=((is_null($row["style_type"]))?3:(int)0+$row["style_type"]);
    if(!isset($USERLANG) || empty($USERLANG))
        $USERLANG=((is_null($row["language_url"]))?$THIS_BASEPATH."/language/english":$THIS_BASEPATH."/".$row["language_url"]);

    $_SESSION["CURUSER"]=$row;
    $_SESSION["CURUSER"]["style_url"]=$STYLEURL;
    $_SESSION["CURUSER"]["style_path"]=$STYLEPATH;
    $_SESSION["CURUSER"]["style_type"]=$STYLETYPE;
    $_SESSION["CURUSER"]["language_path"]=$USERLANG;
    $_SESSION["CURUSER_EXPIRE"] = (time()+$btit_settings["cache_duration"]);
    $GLOBALS["CURUSER"] = $_SESSION["CURUSER"];

    ((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
    unset($row);
}

function mysqli_result($res, $row, $field=0) {
    $res->data_seek($row);
    $datarow = $res->fetch_array();
    return $datarow[$field];
} 

 function cidr_decode($ip_addr_cidr)
{
    $ip_arr = explode('/', $ip_addr_cidr);

    $dotcount = substr_count($ip_arr[0], ".");
    $padding = str_repeat(".0", 3 - $dotcount);
    $ip_arr[0].=$padding;

    $bin = '';
    for($i=1;$i<=32;$i++)
	{
        $bin .= $ip_arr[1] >= $i ? '1' : '0';
    }
    $ip_arr[1] = bindec($bin);

    $ip = ip2long($ip_arr[0]);
    $nm = ip2long($ip_arr[1]);
    $nw = ($ip & $nm);
    $bc = $nw | (~$nm);

    return array(long2ip($nw), long2ip($bc));

}

function signup_ip_ban($user_ip, $comment)
{
    global $THIS_BASEPATH, $CURUSER, $TABLE_PREFIX ,$DBDT;

    $include=$THIS_BASEPATH."/whois/whois.main.php";

    if(@file_exists($include))
    {
        include_once($include);
        $whois = new Whois();
        $result = $whois->Lookup($user_ip);
        $iplist=explode("-", preg_replace("/\ /", "", ($result["regrinfo"]["network"]["inetnum"])));

        if (!$iplist[1])
        {
            // The IP address is listed in CIDR form eg 127.0/16 etc.
            $iplist=cidr_decode($result["regrinfo"]["network"]["inetnum"]);
        }

        $found=@mysqli_fetch_assoc(@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `id` FROM `{$TABLE_PREFIX}signup_ip_block` WHERE `first_ip`=INET_ATON('$iplist[0]') AND `last_ip`=INET_ATON('$iplist[1]')"));

        if(!$found)
        {
            // Create a new record
            $query= "INSERT INTO `{$TABLE_PREFIX}signup_ip_block` ";
            $query.="SET `first_ip`=INET_ATON('$iplist[0]'), ";
            $query.="`last_ip`=INET_ATON('$iplist[1]'), ";
            $query.="`added`=UNIX_TIMESTAMP(), ";
            $query.="`addedby`='".$CURUSER["username"]."', ";
            $query.="`comment`='".mysqli_real_escape_string($DBDT,$comment)."'";
            @mysqli_query($GLOBALS["___mysqli_ston"], $query);
        }
        else
        {
            // Update the timestamp on the pre-existing record to extend the ban.
            @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}signup_ip_block` SET `added`=UNIX_TIMESTAMP(), `addedby`='".$CURUSER["username"]."' WHERE `id`=".$found["id"]);
        }
    }
    else
    {
        // They don't have the required PHPWhois files so do nothing and exit the function
        return;
    }
}

function rank_expiration_dt($timestamp=0)
{return gmdate('Y-m-d H:i:s',$timestamp);}

function crawlerDetect($USER_AGENT)
{
$crawlers = array(array('Slurp/2.0 (slurp@inktomi.com; http://www.inktomi.com/slurp.html)', 'Slurp/2.0'),array('Mediapartners-Google', 'Google-MP'),array('Google-Sitemaps', 'Google-SM'),array('InfoSeek Robot 1.0', 'InfoSeek'),array('Googlebot/2.1', 'Google-BOT 2'),array('GoogleBot', 'Google-BOT'),array('msnbot', 'MSN-BOT'),array('Rambler', 'Rambler-BOT'),array('Yahoo', 'Yahoo-BOT'), array('AbachoBOT', 'Abacho-BOT'),array('accoona', 'Accoona'),array('AcoiRobot', 'Acoi-Robot'),array('ASPSeek', 'ASPSeek'), array('CrocCrawler', 'CrocCrawler'),array('Dumbot', 'Dumbot'),array('FAST-WebCrawler', 'F-WebCrawler'),array('GeonaBot', 'Geona-BOT'),array('Gigabot', 'Giga-BOT'),array('Lycos', 'Lycos spider'),array('MSRBOT', 'MSR-BOT'),array('Scooter', 'Altavista robot'),array('AltaVista', 'Altavista robot'),array('IDBot', 'ID-Search-BOT'),array('eStyle', 'eStyle-BOT'),array('Scrubby', 'Scrubby robot'));

foreach ($crawlers as $c)
{
if (stristr($USER_AGENT, $c[0]))
{
return($c[1]);
}
}
return false;
}

function ext_err_msg($heading='Error!',$string) {
  global $language;
  // get user's style
  $resheet=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}style where id=".$CURUSER["style"]." LIMIT 1");
    if (!$resheet)
    {
        $STYLEPATH="$THIS_BASEPATH/style/xbtit_default";
        $STYLEURL="$BASEURL/style/xbtit_default";
    }
    else
    {
        $resstyle=mysqli_fetch_array($resheet);
        $STYLEPATH="$THIS_BASEPATH/".$resstyle["style_url"];
        $STYLEURL="$BASEURL/".$resstyle["style_url"];
    }
  // just in case not found the language
  if (!$language['BACK'])
    $language['BACK']='Back';
    
$content=print("<html>\n");
 print("<head>\n");
 print("<title>".$heading."</title>\n");
 print("<link rel=\'stylesheet\' type=\'text/css\' href=\'".$STYLEURL."/main.css\'>\n");
 print("</head>\n");
 print("<body>\n");
 print("<br /><br /><br /><br /><br /><br /><br />\n");
 print("<table width=\'30%\' align=\'center\'>\n");
 print("<tr><td class=\'error\'><center>".$heading."</center></td></tr>\n");
 print("<td bgcolor=\'#ECEDF3\' align=\'center\' style=\'color:#000000\'><img src=\'".$STYLEURL."/images/error.gif\' alt=\'\' style=\'float:left; margin:5px\' />\n");
 print("<br />".$string."<br /></td>\n");
 print("</tr></table><br /><br />\n");
 print("<center><a href=\'index.php\'>".$language['BACK']."</a></center>\n");
 print("</body>\n");
 print("</html>\n");
 echo $content;
  }

function dbconn($do_clean=false) {
  global $dbhost, $dbuser, $dbpass, $database, $language;

  if ($GLOBALS['persist'])
    $conres=($GLOBALS["___mysqli_ston"] = mysqli_connect($dbhost,  $dbuser,  $dbpass));
  else
    $conres=($GLOBALS["___mysqli_ston"] = mysqli_connect($dbhost,  $dbuser,  $dbpass));

  if (!$conres) {
    switch (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false))) {
      case 1040:
      case 2002:
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
          die('<html><head><meta http-equiv=refresh content="20;'.$_SERVER['REQUEST_URI'].'"></head><body><table border="0" width="100%" height="100%"><tr><td><h3 align="center">'.$language['ERR_SERVER_LOAD'].'</h3></td></tr></table></body></html>');
        die($language['ERR_CANT_CONNECT']);
      default:
        die('['.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)).'] dbconn: mysql_connect: '.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }
  }

  if($GLOBALS["charset"]=="UTF-8")
      do_sqlquery("SET NAMES utf8");

  ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE $database")) or die($language['ERR_CANT_OPEN_DB'].' '.$database.' - '.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  userlogin();

  if ($do_clean)
    register_shutdown_function('cleandata');
}

function lastOfMonth() {
return date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
}

function cleandata() {
  global $CURRENTPATH, $TABLE_PREFIX, $btit_settings;

  global $clean_interval;

  if ($clean_interval==0)
    return;

  $now = time();
  $res = get_result("SELECT last_time as lt FROM {$TABLE_PREFIX}tasks WHERE task='sanity'",true,$btit_settings['cache_duration']);
  $row = $res[0];
  if (!$row) {
    do_sqlquery("INSERT INTO {$TABLE_PREFIX}tasks (task, last_time) VALUES ('sanity',$now)");
    return;
  }
  $ts = $row['lt'];
  if ($ts + $clean_interval > $now)
    return;
  do_sqlquery("UPDATE {$TABLE_PREFIX}tasks SET last_time=$now WHERE task='sanity' AND last_time = $ts");
  if (!mysqli_affected_rows($GLOBALS["___mysqli_ston"]))
    return;

  require_once $CURRENTPATH.'/sanity.php';
  do_sanity($ts);
}

function updatedata() {
  global $CURRENTPATH, $TABLE_PREFIX,$btit_settings;

  require_once $CURRENTPATH.'/getscrape.php';
  global $update_interval;

  if ($update_interval==0)
    return;

  $now = time();

  $res = get_result("SELECT last_time as lt FROM {$TABLE_PREFIX}tasks WHERE task='update'",true,$btit_settings['cache_duration']);
  $row = $res[0];
  if (!$row) {
    do_sqlquery("INSERT INTO {$TABLE_PREFIX}tasks (task, last_time) VALUES ('update',$now)");
    return;
  }
  $ts = $row['lt'];
  if ($ts + $update_interval > $now)
    return;

  do_sqlquery("UPDATE {$TABLE_PREFIX}tasks SET last_time=$now WHERE task='update' AND last_time = $ts");
  if (!mysqli_affected_rows($GLOBALS["___mysqli_ston"]))
    return;

  $res = get_result("SELECT announce_url FROM {$TABLE_PREFIX}files WHERE external='yes' ORDER BY lastupdate ASC LIMIT 1",true,$btit_settings['cache_duration']);
  if (!$res || count($res)==0)
    return;

  // get the url to scrape, take 5 torrent at a time (try to getting multiscrape)
  $row = $res[0];
  $resurl=get_result("SELECT info_hash FROM {$TABLE_PREFIX}files WHERE external='yes' AND announce_url='".$row['announce_url']."' ORDER BY lastupdate ASC LIMIT 5",true,$btit_settings['cache_duration']);
  if (!$resurl || count($resurl)==0)
    return

  $combinedinfohash=array();
  foreach ($resurl as $id=> $rhash)
    $combinedinfohash[]=$rhash['info_hash'];

  //scrape($row["announce_url"],$row["info_hash"]);
  scrape($row[0],implode("','",$combinedinfohash));
}

function pager($rpp, $count, $href, $opts = array()) {
  global $language;

  $pages=($rpp==0)?1:ceil($count / $rpp);

  if (!isset($opts['lastpagedefault']))
    $pagedefault = 1;
  else {
    $pagedefault = floor(($count - 1) / $rpp);
    if ($pagedefault < 1)
      $pagedefault = 1;
  }

  $pagename='pages';

  if (isset($opts['pagename'])) {
    $pagename=$opts['pagename'];
    if (isset($_GET[$opts['pagename']]))
      $page = max(1 ,intval($_GET[$opts['pagename']]));
    else
      $page = $pagedefault;
  } elseif (isset($_GET['pages'])) {
    $page = max(1,intval(0 + $_GET['pages']));
    if ($page < 0)
      $page = $pagedefault;
  } else
    $page = $pagedefault;

  $pager = '';

  if ($pages>1) {
    $pager.="\n".'<form name="change_page'.$pagename.'" method="post" action="index.php">'."\n".'<select class="drop_pager" name="pages" onchange="location=document.change_page'.$pagename.'.pages.options[document.change_page'.$pagename.'.pages.selectedIndex].value" size="1">';
    for ($i = 1; $i<=$pages;$i++) 
        $pager.="\n<option ".($i==$page?'selected="selected"':'')."value=\"$href$pagename=$i\">$i</option>";
    $pager.="\n</select>";
  }

  $mp = $pages;// - 1;
  $begin=($page > 3?($page<$pages-2?$page-2:$pages-2):1);
  $end=($pages>$begin+2?($begin+2<$pages?$begin+2:$pages):$pages);
  if ($page > 1) {
    $pager .= "\n&nbsp;<span class=\"pager\"><a href=\"{$href}$pagename=1\">&nbsp;&laquo;</a></span>";
    $pager .= "\n<span class=\"pager\"><a href=\"{$href}$pagename=".($page-1)."\">&lt;&nbsp;</a></span>";
  }

  if ($count) {
    for ($i = $begin; $i <= $end; $i++) {
      if ($i != $page)
        $pager .= "\n&nbsp;<span class=\"pager\"><a href=\"{$href}$pagename=$i\">$i</a></span>";
      else
        $pager .= "\n&nbsp;<span class=\"pagercurrent\"><b>$i</b></span>";
    }

    if ($page < $mp && $mp >= 1) {
      $pager .= "\n&nbsp;<span class=\"pager\"><a href=\"{$href}$pagename=".($page+1)."\">&nbsp;&gt;</a></span>";
      $pager .= "\n&nbsp;<span class=\"pager\"><a href=\"{$href}$pagename=$pages\">&nbsp;&raquo;</a></span>";
    }

    $pagertop = "$pager\n</form>";
    $pagerbottom = str_replace("change_page","change_page1",$pagertop)."\n";
  } else {
    $pagertop = "$pager\n</form>";
    $pagerbottom = str_replace("change_page","change_page1",$pagertop)."\n";
  }

  $start = ($page-1) * $rpp;
  if ($pages<2) {
    // only 1 page??? don't need pager ;)
    $pagertop='';
    $pagerbottom='';
  }

  return array($pagertop, $pagerbottom, "LIMIT $start,$rpp");
}

// give back categories recorset
function genrelist() {
  global $TABLE_PREFIX,$CACHE_DURATION;

  return get_result('SELECT * FROM '.$TABLE_PREFIX.'categories ORDER BY sort_index, id', true, $CACHE_DURATION);
}


// this returns all uploaders  into a select
function uploader($vall='') {
  global $TABLE_PREFIX,$CACHE_DURATION;
  $return="\n".'<select name="uploader"><option value="0">----</option>';
  $cc_q=get_result("SELECT DISTINCT uploader FROM {$TABLE_PREFIX}files",true,$CACHE_DURATION);

  foreach ($cc_q as $cv) {
    $resdt=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE id =".$cv["uploader"]);
    $rowdt=mysqli_fetch_array($resdt);
    $ccid=$cv['uploader'];
    $name=unesc($rowdt['username']);

      $return.= "\n<option".(($ccid==$vall)?' selected="selected"':'').' value="'.$ccid.'">'.$name.'</option>';
  }
return $return.'</select>';
}

// this returns all the categories with subs into a select
function categories($val='') {
  global $TABLE_PREFIX,$CACHE_DURATION,$CURUSER;

  $return="\n".'<select name="category"><option value="0">----</option>';
  
if ($XBTT_USE)
    $rowcat = do_sqlquery("SELECT u.id, (u.downloaded+IFNULL(x.downloaded,0)) as downloaded, ((u.uploaded+IFNULL(x.uploaded,0))/(u.downloaded+IFNULL(x.downloaded,0))) as uratio, cp.* FROM {$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  else
    $rowcat = do_sqlquery("SELECT u.id, u.downloaded, (u.uploaded/u.downloaded) as uratio, cp.* FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  if (mysqli_num_rows($rowcat)>0)
     while ($catdata=mysqli_fetch_array($rowcat))
             if($catdata["viewcat"]!="yes" && (($catdata["downloaded"]>=$GLOBALS["download_ratio"] && ($catdata["ratio"]>$catdata["uratio"]))||($catdata["downloaded"]<$GLOBALS["download_ratio"])||($catdata["ratio"]=="0")))
                $exclude.=' AND c.id!='.$catdata[catid];

  $c_q=get_result("SELECT c.id, c.name, sc.id as sid, sc.name as sname FROM {$TABLE_PREFIX}categories c LEFT JOIN {$TABLE_PREFIX}categories sc on c.id=sc.sub where c.sub='0' $exclude ORDER BY c.sort_index, sc.sort_index, c.id, sc.id",true,$CACHE_DURATION);
  $b_sub=0;
  foreach ($c_q as $c) {
    $cid=$c['id'];
    $name=unesc($c['name']);

    if ($b_sub!=$cid && $b_sub!=0)
      $return.="\n</optgroup>";

    // lets see if it has sub-categories.
    if (empty($c['sid'])) {
      $b_sub=0;
      $return.= "\n<option".(($cid==$val)?' selected="selected"':'').' value="'.$cid.'">'.$name.'</option>';
    } else {
      if ($b_sub!=$cid) {
        $return.="\n<optgroup label='$name'>";
        $b_sub=$cid;
      }
      $sub = $c['sid'];
      $return.= "\n<option".(($sub==$val)?' selected="selected"':'').' value="'.$sub.'">'.unesc($c['sname']).'</option>';
    }
  }

  return $return.'</select>';
}

// this returns all the subcategories
function sub_categories($val='') {
  global $TABLE_PREFIX;

  $return="\n<select name='sub_category'><option value='0'>---</option>";
  $c_q = get_result("SELECT id, name FROM {$TABLE_PREFIX}categories WHERE sub='0' ORDER BY sort_index, id",true,$CACHE_DURATION);
  foreach($c_q as $c) {
    $cid = $c['id'];
    $name = unesc($c['name']);
    $selected = ($cid == $val)?'selected="selected"':'';
    $return.= "\n<option $selected value='$cid'>$name</option>";
  }

  return $return."\n</select>";
}

// this returns the category of a sub-category
function sub_cat($sub) {
  global $TABLE_PREFIX,$CACHE_DURATION;

  $c_q = get_result('SELECT name FROM '.$TABLE_PREFIX.'categories WHERE id='.$sub.' LIMIT 1;',true,$CACHE_DURATION);
  return unesc($c_q[0]['name']);
}

function style_list() {
  global $TABLE_PREFIX, $CACHE_DURATION;

  return get_result('SELECT * FROM '.$TABLE_PREFIX.'style ORDER BY id;', true, $CACHE_DURATION);
}



function language_list() {
  global $TABLE_PREFIX, $CACHE_DURATION;

  return get_result('SELECT * FROM '.$TABLE_PREFIX.'language ORDER BY language;', true, $CACHE_DURATION);
}

function flag_list($with_unknown=false) {
  global $TABLE_PREFIX, $CACHE_DURATION;

  return get_result('SELECT * FROM '.$TABLE_PREFIX.'countries '.(!$with_unknown?'WHERE id<>100':'').' ORDER BY name;', true, $CACHE_DURATION);
}

function timezone_list() {
  global $TABLE_PREFIX, $CACHE_DURATION;

  return get_result('SELECT * FROM '.$TABLE_PREFIX.'timezone;', true, $CACHE_DURATION);
}

function rank_list() {
  global $TABLE_PREFIX, $CACHE_DURATION,$CURUSER;
  
  $prot=$CURUSER["id_level"];

  return get_result('SELECT * FROM '.$TABLE_PREFIX.'users_level WHERE id_level <= '.$prot.' ORDER BY id_level;', true, $CACHE_DURATION);
}

function team_list() {
  global $TABLE_PREFIX, $CACHE_DURATION;

  return get_result('SELECT * FROM '.$TABLE_PREFIX.'teams ORDER BY id;', true, $CACHE_DURATION);
}

# This will show your site name & your url, where you place your tags! 
# <tag:site_name /> and <tag:tracker_url /> . 
function print_sitename()
{
  global $SITENAME;

return $SITENAME;
}

function print_trackerurl()
{
  global $BASEURL;  

return $BASEURL;
}
# this will show the users name where you place the <tag:user_name />
function print_username()
{
   global $CURUSER;
  $username=($CURUSER['username']); 
  return $username;
}
# End
# Begin standard foot tags!

function stdfoot($normalpage=true, $update=true, $adminpage=false, $torrentspage=false, $forumpage=false)
{
    global $STYLEPATH, $tpl, $no_columns, $PRINT_DEBUG, $STYLETYPE;
    
    $tpl->set('to_top',print_top());
    $tpl->set('tracker_url',print_trackerurl());
    $tpl->set('site_name',print_sitename());
    $tpl->set('user_name',print_username());
    $tpl->set('main_footer',bottom_menu()."<br />\n");
    $tpl->set('xbtit_version',print_version());
    $tpl->set('style_copyright',print_designer());
    $tpl->set('xbtit_debug', (($PRINT_DEBUG)?print_debug():""));
    $tpl->set('news_text',print_disclaimer());
    
    if($STYLETYPE==2)
    {
        // It's a style modified for atmoner's original system

        // Improvement of template by atmoner
        if ($normalpage && !$no_columns)
        {
            $tpl->set("RIGHT_COL", true, true);
            $tpl->set("LEFT_COL", true, true);
            $tpl->set("NO_HEADER", true, true);
            $tpl->set("NO_FOOTER", true, true);
        }
        elseif ($adminpage)
        {
            $tpl->set("RIGHT_COL", false, true);
            $tpl->set("LEFT_COL", true, true);
            $tpl->set("NO_HEADER", true, true);
            $tpl->set("NO_FOOTER", true, true);
        }
        elseif ($torrentspage || $forumpage || $no_columns==1)
        {
            $tpl->set("RIGHT_COL", false, true);
            $tpl->set("LEFT_COL", false, true);
            $tpl->set("NO_HEADER", true, true);
            $tpl->set("NO_FOOTER", true, true);
        }
        else
        {
            $tpl->set("RIGHT_COL", false, true);
            $tpl->set("LEFT_COL", false, true);
            $tpl->set("NO_HEADER", false, true);
            $tpl->set("NO_FOOTER", false, true);
        }
        echo $tpl->fetch(load_template('main.tpl'));
    }
    elseif($STYLETYPE==3)
    {
        // It's a style modified for Petr1fied's enhanced version of atmoner's system.
        $tpl->set("TYPE1_EXCLUSIVE_1", false, true);
        $tpl->set("TYPE1_EXCLUSIVE_2", false, true);
        $tpl->set("TYPE1_EXCLUSIVE_3", false, true);
        $tpl->set("TYPE1_EXCLUSIVE_4", false, true);
        $tpl->set("TYPE1_EXCLUSIVE_5", false, true);

        $tpl->set("TYPE2_EXCLUSIVE_1", false, true);
        $tpl->set("TYPE2_EXCLUSIVE_2", false, true);
        $tpl->set("TYPE2_EXCLUSIVE_3", false, true);
        $tpl->set("TYPE2_EXCLUSIVE_4", false, true);
        $tpl->set("TYPE2_EXCLUSIVE_5", false, true);

        $tpl->set("TYPE3_EXCLUSIVE_1", false, true);
        $tpl->set("TYPE3_EXCLUSIVE_2", false, true);
        $tpl->set("TYPE3_EXCLUSIVE_3", false, true);
        $tpl->set("TYPE3_EXCLUSIVE_4", false, true);
        $tpl->set("TYPE3_EXCLUSIVE_5", false, true);

        $tpl->set("TYPE4_EXCLUSIVE_1", false, true);
        $tpl->set("TYPE4_EXCLUSIVE_2", false, true);
        $tpl->set("TYPE4_EXCLUSIVE_3", false, true);
        $tpl->set("TYPE4_EXCLUSIVE_4", false, true);
        $tpl->set("TYPE4_EXCLUSIVE_5", false, true);

        if ($normalpage && !$no_columns)
        {
            $tpl->set("HAS_LEFT_COL", true, true);
       	    $tpl->set("HAS_RIGHT_COL", true, true);
            $tpl->set("IS_DISPLAYED_1", true, true);
            $tpl->set("IS_DISPLAYED_2", true, true);
            $tpl->set("IS_DISPLAYED_3", true, true);
            $tpl->set("IS_DISPLAYED_4", true, true);
            $tpl->set("IS_DISPLAYED_5", true, true);
            $tpl->set("TYPE1_EXCLUSIVE_1", true, true);
            $tpl->set("TYPE1_EXCLUSIVE_2", true, true);
            $tpl->set("TYPE1_EXCLUSIVE_3", true, true);
            $tpl->set("TYPE1_EXCLUSIVE_4", true, true);
            $tpl->set("TYPE1_EXCLUSIVE_5", true, true);
        }
        elseif ($adminpage)
        {
            $tpl->set("HAS_LEFT_COL", true, true);
            $tpl->set("HAS_RIGHT_COL", false, true);
            $tpl->set("IS_DISPLAYED_1", true, true);
            $tpl->set("IS_DISPLAYED_2", true, true);
            $tpl->set("IS_DISPLAYED_3", true, true);
            $tpl->set("IS_DISPLAYED_4", true, true);
            $tpl->set("IS_DISPLAYED_5", true, true);
            $tpl->set("TYPE2_EXCLUSIVE_1", true, true);
            $tpl->set("TYPE2_EXCLUSIVE_2", true, true);
            $tpl->set("TYPE2_EXCLUSIVE_3", true, true);
            $tpl->set("TYPE2_EXCLUSIVE_4", true, true);
            $tpl->set("TYPE2_EXCLUSIVE_5", true, true);
        }
        elseif ($torrentspage || $forumpage || $no_columns==1)
        {
            $tpl->set("HAS_LEFT_COL", false, true);
           	$tpl->set("HAS_RIGHT_COL", false, true);
            $tpl->set("IS_DISPLAYED_1", true, true);
            $tpl->set("IS_DISPLAYED_2", true, true);
            $tpl->set("IS_DISPLAYED_3", true, true);
            $tpl->set("IS_DISPLAYED_4", true, true);
            $tpl->set("IS_DISPLAYED_5", true, true);
            $tpl->set("IS_DISPLAYED_5", true, true);
            $tpl->set("TYPE3_EXCLUSIVE_1", true, true);
            $tpl->set("TYPE3_EXCLUSIVE_2", true, true);
            $tpl->set("TYPE3_EXCLUSIVE_3", true, true);
            $tpl->set("TYPE3_EXCLUSIVE_4", true, true);
            $tpl->set("TYPE3_EXCLUSIVE_5", true, true);
        }
        else
        {
            $tpl->set("HAS_LEFT_COL", false, true);
       	    $tpl->set("HAS_RIGHT_COL", false, true);
            $tpl->set("IS_DISPLAYED_1", false, true);
            $tpl->set("IS_DISPLAYED_2", false, true);
            $tpl->set("IS_DISPLAYED_3", false, true);
            $tpl->set("IS_DISPLAYED_4", false, true);
            $tpl->set("IS_DISPLAYED_5", false, true);
            $tpl->set("IS_DISPLAYED_5", false, true);
            $tpl->set("TYPE4_EXCLUSIVE_1", true, true);
            $tpl->set("TYPE4_EXCLUSIVE_2", true, true);
            $tpl->set("TYPE4_EXCLUSIVE_3", true, true);
            $tpl->set("TYPE4_EXCLUSIVE_4", true, true);
            $tpl->set("TYPE4_EXCLUSIVE_5", true, true);
        }
        echo $tpl->fetch(load_template('main.tpl'));
    }
    else
    {
        // It's an original style type. Also default to this if there's an unknown value for the $STYLETYPE variable.
        if ($normalpage && !$no_columns)
            echo $tpl->fetch(load_template('main.tpl')); 
        elseif ($adminpage)
        {
            if(file_exists(load_template('main.left_column.tpl')))
                echo $tpl->fetch(load_template('main.left_column.tpl'));
            else
                echo $tpl->fetch(load_template('main.tpl'));
        }
        elseif ($torrentspage || $forumpage || $no_columns==1)
        {
            if(file_exists(load_template('main.no_columns.tpl')))
                echo $tpl->fetch(load_template('main.no_columns.tpl'));
            else
                echo $tpl->fetch(load_template('main.tpl'));
        }
        else
        {
            if(file_exists(load_template('main.no_header_1_column.tpl')))
                echo $tpl->fetch(load_template('main.no_header_1_column.tpl'));
            else
                echo $tpl->fetch(load_template('main.tpl'));
        } 
    }
    ob_end_flush();

    if ($update)
        register_shutdown_function('updatedata');
}

function linkcolor($num) {
  if (!$num)
    return '#FF0000';
  if ($num == 1)
    return '#FFFF00';
  return '#FFFF00';
}

function format_comment($text, $strip_html = true) {
  global $smilies, $privatesmilies, $BASEURL;

  if ($strip_html)
    $text = htmlspecialchars($text);
  $text = unesc($text);
  $f=@fopen('badwords.txt','r');
  if ($f && filesize ('badwords.txt')!=0) {
    $bw=fread($f,filesize('badwords.txt'));
    $badwords=explode("\n",$bw);
    for ($i=0,$total=count($badwords);$i<$total;++$i)
      $badwords[$i]=trim($badwords[$i]);
    $text=str_replace($badwords,'*censored*',$text);
  }
  @fclose($f);

  $text=bbcode($text);

  // [*]
  $text = preg_replace('/\[\*\]/', '<li>', $text);

  // Maintain spacing
  $text = str_replace('  ', ' &nbsp;', $text);

  $smilies=array_merge($smilies, $privatesmilies);
  reset($smilies);
  while (list($code, $url) = each($smilies))
    $text = str_replace($code, '<img border="0" src="'.$BASEURL.'/images/smilies/'.$url.'" alt="'.$url.'" />', $text);

  return $text;
}

function image_or_link($image,$pers_style='',$link='') {
  global $STYLEURL, $STYLEPATH;

  if ($image=='')
    return $link;
  if (!file_exists($image))
      return $link;
  // replace realpath with url
  return '<img src="'.str_replace($STYLEPATH,$STYLEURL,$image).'" border="0" '.$pers_style.' alt="'.$link.'"/>';
}


function get_combodt($select, $opts=array()) {
  $name=(isset($opts['name']))?' name="'.$opts['name'].'"':'';
  $complete=(isset($opts['complete']))?(bool)$opts['complete']:false;
  $default=(isset($opts['default']))?$opts['default']:NULL;
  $id=(isset($opts['id']))?$opts['id']:'id';
  $value=(isset($opts['value']))?$opts['value']:'value';
  $combo='';

  if ($complete)
    $combo.='<select'.$name.'>';

  foreach ($select as $option) {
    $combo.="\n".'<option ';
    if ( (!is_null($default)) && ($option[$id]==$default) )
      $combo.='selected="selected" ';
    $combo.='value="'.$option[$id].'">'.unesc($option[$value]).'</option>';
  }

  if ($complete)
    $combo.='</select>';

  return $combo;
}
        

function success_msg($heading='Success!',$string,$close=false) {
  global $language,$STYLEPATH, $tpl, $page, $STYLEURL;

  if(!isset($tpl) || empty($tpl))
      die($heading."<br />".$string);

  $suc_tpl=new bTemplate();
  $suc_tpl->set('success_title',$heading);
  $suc_tpl->set('success_message',$string);
  $suc_tpl->set('success_image',$STYLEURL.'/images/success.gif');
  $tpl->set('main_content',set_block($heading,'center',$suc_tpl->fetch(load_template('success.tpl'))));
}

function err_msg($heading='Error!',$string,$close=false) {
  global $language,$STYLEPATH, $tpl, $page,$STYLEURL;

  if(!isset($tpl) || empty($tpl))
      die($heading."<br />".$string);

  // just in case not found the language
  if (!$language['BACK'])
    $language['BACK']='Back';

  $err_tpl=new bTemplate();
  $err_tpl->set('error_title',$heading);
  $err_tpl->set('error_message',$string);
  $err_tpl->set('error_image',$STYLEURL.'/images/error.gif');
  $err_tpl->set('language',$language);
  if ($close)
    $err_tpl->set('error_footer','<a href="javascript: window.close();">'.$language['CLOSE'].'</a>');
  else
    $err_tpl->set('error_footer','<a href="javascript: history.go(-1);">'.$language['BACK'].'</a>');

  $tpl->set('main_content',set_block($heading,'center',$err_tpl->fetch(load_template('error.tpl'))));
}

function information_msg($heading='Error!',$string,$close=false) {
  global $language,$STYLEPATH, $tpl, $page,$STYLEURL;

  if(!isset($tpl) || empty($tpl))
      die($heading."<br />".$string);

  // just in case not found the language
  if (!$language['BACK'])
    $language['BACK']='Back';

  $err_tpl=new bTemplate();
  $err_tpl->set('information_title',$heading);
  $err_tpl->set('information_message',$string);
  $err_tpl->set('information_image',$STYLEURL.'/images/error.gif');
  $err_tpl->set('language',$language);

  if ($close)
    $err_tpl->set('information_footer','<a href="javascript: window.close();">'.$language['CLOSE'].'</a>');
  else
    $err_tpl->set('information_footer','<a href="javascript: history.go(-1);">'.$language['BACK'].'</a>');


  $tpl->set('main_content',set_block($heading,'center',$err_tpl->fetch(load_template('information.tpl'))));

  stdfoot(true,false);
  die();
}

function get_content($file) {
  global $STYLEPATH, $TABLE_PREFIX, $language;

  ob_start();
  include($file);
  $content=ob_get_contents();
  ob_end_clean();

  return $content;
}

function set_block($block_title,$alignement,$block_content,$width100=true) {
  global $STYLEPATH, $TABLE_PREFIX, $language;

  $blocktpl=new bTemplate();
  $blocktpl->set('block_width',($width100?'width="100%"':''));
  $blocktpl->set('block_title',$block_title);
  $blocktpl->set('block_align',$alignement);
  $blocktpl->set('block_content',$block_content);
  return $blocktpl->fetch(load_template('block.tpl'));
}

function get_block($block_title,$alignement,$block,$use_cache=true,$width100=true) {
  global $STYLEPATH, $TABLE_PREFIX, $language, $CACHE_DURATION, $CURUSER;

  $blocktpl=new bTemplate();
  $blocktpl->set('block_width',($width100?'width="100%"':''));
  $blocktpl->set('block_title',$block_title);
  $blocktpl->set('block_align',$alignement);

  $cache_file=realpath(dirname(__FILE__).'/..').'/cache/'.md5($block.$CURUSER['id_level']).'.txt';
  $use_cache=($use_cache)?$CACHE_DURATION>0:false;
    
  if ($use_cache) {
    // read cache
    if (file_exists($cache_file) && (time()-$CACHE_DURATION) < filemtime($cache_file)) {
      $blocktpl->set('block_content', file_get_contents($cache_file));
      return $blocktpl->fetch(load_template('block.tpl'));
        }
  }

  ob_start();
  include(realpath(dirname(__FILE__).'/..').'/blocks/'.$block.'_block.php');
  $block_content=ob_get_contents();
  ob_end_clean();

  if ($use_cache) {
    // write cache file
    $fp=fopen($cache_file,'w');
    fputs($fp,$block_content);
    fclose($fp);
  }

  $blocktpl->set('block_content',$block_content);
  return $blocktpl->fetch(load_template('block.tpl'));
}

function block_begin($title='-',$colspan=1,$calign='justify') {
}

function block_end($colspan=1) {
}

function warn_expiration($timestamp=0){return gmdate('Y-m-d H:i:s',$timestamp);}

function booted_expiration($timestamp=0){return gmdate('Y-m-d H:i:s',$timestamp);}




function makesize1($bytes) {
  if (abs($bytes) < 1000 * 1024)
    return number_format($bytes / 1024, 2) . "";
  if (abs($bytes) < 1000 * 1048576)
    return number_format($bytes / 1048576, 2) . "";
  if (abs($bytes) < 1000 * 1073741824)
    return number_format($bytes / 1073741824, 2) . "";
  return number_format($bytes / 1099511627776, 2) . "";
}


function makesize($bytes)
{
    if (abs($bytes) < 1048576)
        return number_format($bytes / 1024, 2).' KB'; // (Kilobytes)
    if (abs($bytes) < 1073741824)
        return number_format($bytes / 1048576, 2).' MB'; // (Megabytes)
    if (abs($bytes) < 1099511627776)
        return number_format($bytes / 1073741824, 2).' GB'; // (Gigabytes)
    if (abs($bytes) < 1125899906842624)
        return number_format($bytes / 1099511627776, 2).' TB'; // (Terabytes)
    if (abs($bytes) < 1152921504606846976)
        return number_format($bytes / 1125899906842624, 2).' PB'; // (Petabytes)
    if (abs($bytes) < 1180591620717411303424)
        return number_format($bytes / 1152921504606846976, 2).' EB'; // (Exabytes)
    if (abs($bytes) < 1208925819614629174706176)
        return number_format($bytes / 1180591620717411303424, 2).' ZB'; // (Zettabytes)
    else
        return number_format($bytes / 1208925819614629174706176, 2).' YB'; // (Yottabytes)
}

function redirect($redirecturl) {
    global $language;

  if (headers_sent()) {
?>
<script language="javascript">
  window.location.href='<?php echo $redirecturl; ?>';
</script>
<meta http-equiv="refresh" content="2;<?php echo $redirecturl; ?>">
<?php
        echo sprintf($language['REDIRECT2'], $redirecturl);
    } else
    header('Location: '.$redirecturl);
    die();
}

function textbbcode($form,$name,$content='') {
  $tpl_bbcode=new bTemplate();
  $tpl_bbcode->set('form_name',$form);
  $tpl_bbcode->set('object_name',$name);
  $tpl_bbcode->set('content',$content);
  $tbbcode='<table width="100%" cellpadding="1" cellspacing="1">';

  global $smilies, $STYLEPATH, $language;
  $count=0;
  reset($smilies);
  $tbbcode.='<tr>';
  while ((list($code, $url) = each($smilies)) && $count<16) {
    $tbbcode.="\n<td><a href=\"javascript: SmileIT('".str_replace("'","\'",$code)."',document.forms.$form.$name);\"><img border=\"0\" src=\"images/smilies/$url\" alt=\"$url\" /></a></td>";
    $count++;
  }
  $tbbcode.="\n</tr>\n</table>";
  $tpl_bbcode->set('smilies_table',$tbbcode);
  $tpl_bbcode->set('language',$language);
  return $tpl_bbcode->fetch(load_template('txtbbcode.tpl'));
}

 
// warn-ban system with acp by DT
if (!function_exists("warn_expiration"))
{

function warn_expiration($timestamp=0){return gmdate('Y-m-d H:i:s',$timestamp);}

}
// warn-ban system with acp by DT
// begin functions for the forum
function is_valid_id($id) {
  return is_numeric($id) && ($id > 0) && (floor($id) == $id);
}

function get_date_time($timestamp = 0) {
  if ($timestamp)
    return date('d/m/Y H:i:s', $timestamp-$offset);

  global $CURRENTPATH;
  include $CURRENTPATH.'/offset.php';
  return gmdate('d/m/Y H:i:s');
}

function stderr($heading, $text,$close=false) {
  err_msg($heading,$text,$close);
  stdfoot(true,false);
  die();
}

function encodehtml($s, $linebreaks = true) {
  $s = str_replace('<', '&lt;', str_replace('&', '&amp;', $s));
  if ($linebreaks)
    return nl2br($s);
  return $s;
}

function time_ago($timestamp)
{
    $timestamp = (int) $timestamp;
    $current_time = time();
    $diff = $current_time - $timestamp;
   
    //intervals in seconds
    $intervals      = array (
        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
    );
   
    //now we just find the difference
    if ($diff == 0)
    {
        return 'just now';
    }   

    if ($diff < 60)
    {
        return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
    }       

    if ($diff >= 60 && $diff < $intervals['hour'])
    {
        $diff = floor($diff/$intervals['minute']);
        return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
    }       

    if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
    {
        $diff = floor($diff/$intervals['hour']);
        return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
    }   

    if ($diff >= $intervals['day'] && $diff < $intervals['week'])
    {
        $diff = floor($diff/$intervals['day']);
        return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
    }   

    if ($diff >= $intervals['week'] && $diff < $intervals['month'])
    {
        $diff = floor($diff/$intervals['week']);
        return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
    }   

    if ($diff >= $intervals['month'] && $diff < $intervals['year'])
    {
        $diff = floor($diff/$intervals['month']);
        return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
    }   

    if ($diff >= $intervals['year'])
    {
        $diff = floor($diff/$intervals['year']);
        return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
    }
}

function get_elapsed_time($ts) {
  $mins = floor((time() - $ts) / 60);
  $hours = floor($mins / 60);
  $mins -= $hours * 60;
  $days = floor($hours / 24);
  $hours -= $days * 24;
  $weeks = floor($days / 7);
  $days -= $weeks * 7;
  if ($weeks > 0)
    return $weeks.' week'.(($weeks==1)?'':'s');
  if ($days > 0)
    return $days.' day'.(($days==1)?'':'s');
  if ($hours > 0)
    return $hours.' hour'.(($hours==1)?'':'s');
  if ($mins > 0)
    return $mins.' min'.(($mins==1)?'':'s');
  return '< 1 min';
}

function sql_timestamp_to_unix_timestamp($s) {
  return mktime(substr($s, 11, 2), substr($s, 14, 2), substr($s, 17, 2), substr($s, 5, 2), substr($s, 8, 2), substr($s, 0, 4));
}

function gmtime() {
  return strtotime(get_date_time());
}

function sqlerr($file='',$line='') {
    $file=(($file!=''&&$line!='')? '<p>in '.$file.', line '.$line.'</p>' : '');
?>
  <table border="0" bgcolor="" align=left cellspacing=0 cellpadding=10 style="background: blue">
    <tr>
          <td class=embedded><font color="#FFFFFF"><h1><?php echo ERR_SQL_ERR; ?></h1>
            <b><?php echo ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)).$file;?></b></font></td>
        </tr>
    </table>
<?php
  die();
}

function peercolor($num) {
  if (!$num)
    return '#FF0000';
  elseif ($num == 1)
    return '#BEC635';
  return '#008000';
}

// v.1.3
function write_log($text,$reason='add') {
  global $CURUSER, $LOG_ACTIVE, $TABLE_PREFIX;

  if ($LOG_ACTIVE)
    do_sqlquery('INSERT INTO '.$TABLE_PREFIX.'logs (added, txt,type,user) VALUES(UNIX_TIMESTAMP(), '.sqlesc($text).', '.sqlesc($reason).',"'.$CURUSER['username'].'")');
}

 

function NDF($seconds) {

  while ($seconds>31536000) {
    $years++;
    $seconds -= 31536000;
	}

  while ($seconds>2419200) {
    $months++;
    $seconds -= 2419200;
	}

  while ($seconds>604800) {
    $weeks++;
    $seconds -= 604800;
	}

  while ($seconds>86400) {
    $days++;
    $seconds -= 86400;
	}

  while ($seconds>3600) {
    $hours++;
    $seconds -= 3600;
	}

  while ($seconds>60) {
    $minutes++;
    $seconds -= 60;
	}

  $years=($years==0)?"":$years."Y ";
  $months=($months==0)?"":$months."M ";
  $weeks=($weeks==0)?"":$weeks."W ";
  $days=($days==0)?"":$days."D ";
  $hours=($hours==0)?"":$hours."h ";
  $minutes=($minutes==0)?"":$minutes."m ";
  $seconds=($seconds==0)?"":$seconds."s";
return $years.$months.$weeks.$days.$hours.$minutes.$seconds;
}

function DateFormat($seconds) {
  while ($seconds>31536000) {
    $years++;
    $seconds -= 31536000;
    }

  while ($seconds>2419200) {
    $months++;
    $seconds -= 2419200;
    }

  while ($seconds>604800) {
    $weeks++;
    $seconds -= 604800;
    }

  while ($seconds>86400) {
    $days++; 
    $seconds -= 86400;
    }

  while ($seconds>3600) {
    $hours++; 
    $seconds -= 3600;
    }

  while ($seconds>60) {
    $minutes++; 
    $seconds -= 60;
    }

  $years=($years==0)?'':($years.' '.(($years==1)?YEAR:YEARS).', ');
    $months=($months==0)?'':($months.' '.(($months==1)?MONTH:MONTHS).', ');
    $weeks=($weeks==0)?'':($weeks.' '.(($weeks==1)?WEEK:WEEKS).', ');
    $days=($days==0)?'':($days.' '.(($days==1)?DAY:DAYS).', ');
    $hours=($hours==0)?'':($hours.' '.(($hours==1)?HOUR:HOURS).', ');
    $minutes=($minutes==0)?'':($minutes.' '.(($minutes==1)?MINUTE:MINUTES).' '.WORD_AND.' ');
    $seconds=($seconds.' '.(($seconds==1)?SECOND:SECONDS));
    return $years.$months.$weeks.$days.$hours.$minutes.$seconds;
}


//staff comment
function getLevelSC($cur_level)
{
    global $TABLE_PREFIX;
    $query = "SELECT id, id_level FROM {$TABLE_PREFIX}users_level";
    $rez = do_sqlquery($query,true);

    while($row = mysqli_fetch_assoc($rez))
    {
        if($row['id'] == $cur_level)
        {
            return $row['id_level'];
        }
    }
    return 0;
}
// end staff comment
function smf_passgen($username, $pwd) {
  $passhash = sha1(strtolower($username) . $pwd);
  $salt=substr(md5(rand()), 0, 4);

  return array($passhash,$salt);
}

function set_smf_cookie($id, $passhash, $salt)
{
    global $THIS_BASEPATH;

    require $THIS_BASEPATH.'/smf/SSI.php';
    if(!function_exists(setLoginCookie))
        require $THIS_BASEPATH.'/smf/Sources/Subs-Auth.php';

    setLoginCookie(189216000, $id, sha1($passhash . $salt));
}

if ( !function_exists('htmlspecialchars_decode') ) {
  function htmlspecialchars_decode($text) {
    return strtr($text, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
  }
}

function check_upload($tmp_name="", $name="")
{
    global $btit_settings, $language, $CURUSER;

    /*
    Return values
    1 = $tmp_name empty
    2 = $name empty
    3 = $tmp_name doesn't exist
    4 = At least one of the banned triggers were matched
    5 = All good
    */

    if($tmp_name=="")
        return 1;
    if($name=="")
        return 2;

    if(file_exists($tmp_name))
    {
        $handle = fopen($tmp_name, "r");
        $haystack = " " . fread($handle, filesize($tmp_name));
        fclose($handle);

        $needles=((isset($btit_settings["secsui_quarantine_search_terms"]) && !empty($btit_settings["secsui_quarantine_search_terms"]))?explode(",", $btit_settings["secsui_quarantine_search_terms"]):array());

        $found="no";

        if(is_array($needles) && !empty($needles))
        {
            foreach ($needles as $needle)
            {
                if ($found=="no" && strpos($haystack, $needle))
                {
                    $found="yes";
                }
            }
        }
        if($found=="yes")
        {
            $quarantined_name="";
            if(is_dir($btit_settings["secsui_quarantine_dir"]))
            {
                if(is_writable($btit_settings["secsui_quarantine_dir"]))
                {
                    $quarantined_name=$btit_settings["secsui_quarantine_dir"]."/hack_attempt_".$CURUSER["uid"]."-".time()."-".$name;
                    move_uploaded_file($tmp_name, $quarantined_name);
                }
                else
                {
                    send_pm(0,$btit_settings["secsui_quarantine_pm"], sqlesc($language["QUAR_ERR"]),sqlesc($language["QUAR_DIR_PROBLEM_1"]." ".((!empty($btit_settings["secsui_quarantine_dir"]))?"([b]".$btit_settings["secsui_quarantine_dir"]."[/b]) ":"").$language["QUAR_DIR_PROBLEM_3"]));
                    @unlink($tmp_name);
                }
            }
            else
            {
                send_pm(0,$btit_settings["secsui_quarantine_pm"], sqlesc($language["QUAR_ERR"]),sqlesc($language["QUAR_DIR_PROBLEM_1"]." ".((!empty($btit_settings["secsui_quarantine_dir"]))?"([b]".$btit_settings["secsui_quarantine_dir"]."[/b]) ":"").$language["QUAR_DIR_PROBLEM_2"]));
                @unlink($tmp_name);
            }
            send_pm(0,$btit_settings["secsui_quarantine_pm"], sqlesc($language["QUAR_PM_SUBJ"]), sqlesc("[url=".$BASEURL."/index.php?page=userdetails&id=".$CURUSER["uid"]."]".$CURUSER["username"]."[/url] ".$language["QUAR_PM_MSG_1"].":"."\n\n[b]".((isset($quarantined_name) && !empty($quarantined_name))?$quarantined_name:"[color=red]".$language["QUAR_UNABLE"]."[/color]")."[/b]\n\n".$language["QUAR_PM_MSG_2"]." [b]".getip()."[/b]\n\n".":yikes:"));
            return 4;
        }
        else
            return 5;
    }
    else
        return 3;
}

function hash_generate($row, $pwd, $user)
{
    global $btit_settings;

    $salt=pass_the_salt(20);
    $passtype=array();
    // Type 1 - Used in btit / xbtit / Torrent Trader / phpMyBitTorrent
    $passtype[1]["hash"]=md5($pwd);
    $passtype[1]["rehash"]=md5($pwd);
    $passtype[1]["salt"]="";
    $passtype[1]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
    // Type 2 - Used in TBDev / U-232 / SZ Edition / Invision Power Board
    $passtype[2]["hash"]=md5(md5($row["salt"]).md5($pwd));
    $passtype[2]["rehash"]=md5(md5($salt).md5($pwd));
    $passtype[2]["salt"]=$salt;
    $passtype[2]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
    // Type 3 - Used in Free Torrent Source /  Yuna Scatari / TorrentStrike / TSSE
    $passtype[3]["hash"]=md5($row["salt"].$pwd.$row["salt"]);
    $passtype[3]["rehash"]=md5($salt.$pwd.$salt);
    $passtype[3]["salt"]=$salt;
    $passtype[3]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
    // Type 4 - Used in Gazelle
    $passtype[4]["hash"]=sha1(md5($row["salt"]).$pwd.sha1($row["salt"]).$btit_settings["secsui_ss"]);
    $passtype[4]["rehash"]=sha1(md5($salt).$pwd.sha1($salt).$btit_settings["secsui_ss"]);
    $passtype[4]["salt"]=$salt;
    $passtype[4]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
    // Type 5 - Used in Simple Machines Forum
    $passtype[5]["hash"]=sha1(strtolower($user).$pwd);
    $passtype[5]["rehash"]=sha1(strtolower($user).$pwd);
    $passtype[5]["salt"]="";
    $passtype[5]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
    // Type 6 - New xbtit hashing style
    $passtype[6]["hash"]=sha1(substr(md5($pwd),0,16)."-".md5($row["salt"])."-".substr(md5($pwd),16,16));
    $passtype[6]["rehash"]=sha1(substr(md5($pwd),0,16)."-".md5($salt)."-".substr(md5($pwd),16,16));
    $passtype[6]["salt"]=$salt;
    $passtype[6]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);

    return $passtype;
}

function pass_the_salt($len=5)
{
    $salt = '';
    srand( (double)microtime() * 1000000 );

    for ( $i = 0; $i < $len; $i++ )
    {
        $num   = rand(33, 126);

        if ( $num == '92' )
        {
            $num = 93;
        }

        $salt .= chr( $num );
    }
    return $salt;
}

function ipb_passgen($pwd)
{
    global $THIS_BASEPATH;

    if(!isset($THIS_BASEPATH) || empty($THIS_BASEPATH))
        $THIS_BASEPATH=str_replace(array("\\", "/include"), array("/", ""), dirname(__FILE__));
    if(!defined('IPS_ENFORCE_ACCESS'))
        define('IPS_ENFORCE_ACCESS', true);
    if(!defined('IPB_THIS_SCRIPT'))
        define( 'IPB_THIS_SCRIPT', 'public' );

    require_once( $THIS_BASEPATH.'/ipb/initdata.php' );
    require_once( IPS_ROOT_PATH . 'sources/base/ipsRegistry.php' );
    require_once( IPS_ROOT_PATH . 'sources/base/ipsController.php' );
    $registry = ipsRegistry::instance(); 
    $registry->init();

    $password=IPSText::parseCleanValue(urldecode(trim($pwd)));

    $salt=pass_the_salt(5);
    $passhash = md5( md5( $salt ) . md5( $password ) );
    return array($passhash, $salt);
}
function ipb_md5_passgen($pwd)
{
    $salt=pass_the_salt(5);
    $passhash = md5( md5( $salt ) .  $pwd );
    return array($passhash, $salt);
}

function set_ipb_cookie($ipb_fid=0)
{
    global $THIS_BASEPATH, $registry;

    if(!isset($THIS_BASEPATH) || empty($THIS_BASEPATH))
        $THIS_BASEPATH=str_replace(array("\\", "/include"), array("/", ""), dirname(__FILE__));
    if(!defined('IPS_ENFORCE_ACCESS'))
        define('IPS_ENFORCE_ACCESS', true);
    if(!defined('IPB_THIS_SCRIPT'))
        define( 'IPB_THIS_SCRIPT', 'public' );

    if(!isset($registry) || empty($registry))
    {
        require_once($THIS_BASEPATH.'/ipb/initdata.php');
        require_once(IPS_ROOT_PATH.'sources/base/ipsRegistry.php');
        require_once(IPS_ROOT_PATH.'sources/base/ipsController.php');
        $registry = ipsRegistry::instance(); 
        $registry->init();
    }

    if($ipb_fid>0)
    {
        require_once(IPS_ROOT_PATH.'sources/handlers/han_login.php');

        $ipb_login = new han_login($registry);
        $ipb_login->loginWithoutCheckingCredentials($ipb_fid);
    }
}

function kill_ipb_cookie()
{
    setcookie('session_id', "", -3600, '/');
    setcookie('member_id', "", -3600, '/');
    setcookie('pass_hash', "", -3600, '/');
}

function ipb_create($username, $email, $password, $id_level, $newuid)
{
    global $THIS_BASEPATH, $TABLE_PREFIX, $registry;

    if(!isset($THIS_BASEPATH) || empty($THIS_BASEPATH))
        $THIS_BASEPATH=str_replace(array("\\", "/include"), array("/", ""), dirname(__FILE__));
    if(!defined('IPS_ENFORCE_ACCESS'))
        define('IPS_ENFORCE_ACCESS', true);
    if(!defined('IPB_THIS_SCRIPT'))
        define( 'IPB_THIS_SCRIPT', 'public' );

    if(!isset($registry) || empty($registry))
    {
        require_once($THIS_BASEPATH.'/ipb/initdata.php');
        require_once(IPS_ROOT_PATH.'sources/base/ipsRegistry.php');
        require_once(IPS_ROOT_PATH.'sources/base/ipsController.php');
        $registry = ipsRegistry::instance(); 
        $registry->init();
    }
    $member_info = IPSMember::create(array("members"=>array("name" => "$username", "members_display_name" => "$username", "email" => "$email", "password" => "$password", "member_group_id" => "$id_level", "allow_admin_mails" => "1", "members_created_remote" => "1")));
    $ipb_fid=$member_info["member_id"];
    do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `ipb_fid`=".$ipb_fid." WHERE `id`=".$newuid);
}

function ipb_send_pm($ipb_sender=0, $ipb_recepient, $ipb_subject, $ipb_msg, $system=false)
{
    global $ipb_prefix, $THIS_BASEPATH, $btit_settings, $TABLE_PREFIX, $registry;

    if($ipb_sender==0)
    {
        $system=true;
        if(isset($btit_settings["ipb_autoposter"]) && $btit_settings["ipb_autoposter"]!=0)
            $ipb_sender=(int)(0+$btit_settings["ipb_autoposter"]);
        else
            return false;
        $get=get_result("SELECT `ipb_fid` `recipient` FROM `{$TABLE_PREFIX}users` WHERE `id`=".$ipb_recepient);
    }
    else
    {
        $get=get_result("SELECT (SELECT `ipb_fid` FROM `{$TABLE_PREFIX}users` WHERE `id`=".$ipb_sender.") `sender`, (SELECT `ipb_fid` FROM `{$TABLE_PREFIX}users` WHERE `id`=".$ipb_recepient.") `recipient`");
        $ipb_sender=(int)(0+$get[0]["sender"]);
    }
    $ipb_recepient=(int)(0+$get[0]["recipient"]);
    
    if($ipb_sender==0 || $ipb_recepient==0 || $ipb_sender==$ipb_recipient)
    {
        // Something is not right. fail
        return false;
    }

    if(!isset($THIS_BASEPATH) || empty($THIS_BASEPATH))
        $THIS_BASEPATH=str_replace(array("\\", "/include"), array("/", ""), dirname(__FILE__));
    if(!defined('IPS_ENFORCE_ACCESS'))
        define('IPS_ENFORCE_ACCESS', true);
    if(!defined('IPB_THIS_SCRIPT'))
        define( 'IPB_THIS_SCRIPT', 'public' );

    if(!isset($registry) || empty($registry))
    {
        require_once($THIS_BASEPATH.'/ipb/initdata.php');
        require_once(IPS_ROOT_PATH.'sources/base/ipsRegistry.php');
        require_once(IPS_ROOT_PATH.'sources/base/ipsController.php');
        $registry = ipsRegistry::instance(); 
        $registry->init();
    }
    require_once( IPSLib::getAppDir('members') . '/sources/classes/messaging/messengerFunctions.php' );
    $clean_subj=trim($ipb_subject,"'");
    $clean_post=trim($ipb_msg,"'");
    $classMessage = new messengerFunctions($registry);
    // Reciever, Sender, array of other users to invite (Display Name), Subject, Message, Is system message
    $classMessage->sendNewPersonalTopic($ipb_recepient, $ipb_sender, array(), $clean_subj, $clean_post, (($system===true)?array("isSystem" => true, "forcePm" => 1):array("forcePm" => 1)));

}

function ipb_make_post($forum_id, $forum_subj, $forum_post, $poster_id=0, $update_old_topic=true)
{
    global $ipb_prefix, $THIS_BASEPATH, $btit_settings, $registry,$DBDT;

    if($poster_id==0)
    {
        if(isset($btit_settings["ipb_autoposter"]) && $btit_settings["ipb_autoposter"]!=0)
            $poster_id=(int)(0+$btit_settings["ipb_autoposter"]);
        else
            return;
    }

    if(!isset($THIS_BASEPATH) || empty($THIS_BASEPATH))
        $THIS_BASEPATH=str_replace(array("\\", "/include"), array("/", ""), dirname(__FILE__));
    if(!defined('IPS_ENFORCE_ACCESS'))
        define('IPS_ENFORCE_ACCESS', true);
    if(!defined('IPB_THIS_SCRIPT'))
        define( 'IPB_THIS_SCRIPT', 'public' );

    if(!isset($registry) || empty($registry))
    {
        require_once($THIS_BASEPATH.'/ipb/initdata.php');
        require_once(IPS_ROOT_PATH.'sources/base/ipsRegistry.php');
        require_once(IPS_ROOT_PATH.'sources/base/ipsController.php');
        $registry = ipsRegistry::instance(); 
        $registry->init();
    }
    require_once( IPSLib::getAppDir('forums') . '/sources/classes/post/classPost.php' );
    $classPost = new classPost($registry);
    $old_topic=false;
    $clean_subj=trim($forum_subj,"'");
    $clean_post=trim($forum_post,"'");
    $forum = ipsRegistry::getClass('class_forums')->forum_by_id[$forum_id];
    $classPost->setForumID($forum_id);
    $classPost->setForumData($forum);
    $classPost->setAuthor($poster_id);
    $classPost->setPostContentPreFormatted($clean_post);
    $classPost->setPublished(TRUE);

    if($update_old_topic===false)
        $mycount=0;
    else
    {
        $res = get_result("SELECT `t`.* FROM `{$ipb_prefix}topics` `t` LEFT JOIN `{$ipb_prefix}posts` `p` ON `t`.`tid`=`p`.`topic_id` WHERE `t`.`forum_id`=".$forum_id." AND `t`.`title`='".mysqli_real_escape_string($DBDT,$clean_subj)."' AND `t`.`last_post`=`p`.`post_date` AND `t`.`last_poster_id`=`p`.`author_id`");
        $mycount=count($res);
    }
    if($mycount>0)
    {
        $topic=$res[0];
        $topicID = $topic["tid"];
        $classPost->setTopicID($topicID);
        $classPost->setTopicData($topic);
        $classPost->addReply();
    }
    else
    {
        $topic=get_result("SELECT MAX(`tid`)+1 `tid` FROM `{$ipb_prefix}topics`");
        $topicID = $topic[0]["tid"];
        $classPost->setTopicID($topicID);
        $classPost->setTopicTitle($clean_subj);
        $classPost->addTopic();
    }
    return $topicID;
}



function userage($year, $month, $day)
{
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($month_diff < 0)
        $year_diff--;
    elseif ($month_diff==0 && $day_diff < 0)
        $year_diff--;

    return $year_diff;
}

if (!function_exists("stripos")) {
  function stripos($str,$needle) {
   return strpos(strtolower($str),strtolower($needle));
  }
}
if (!function_exists("remover"))
{
    function remover($string, $sep1, $sep2)
    {
        $string = substr($string, 0, strpos($string,$sep2));
        $string = substr(strstr($string, $sep1), 1);

        return $string;
    }
}

if (!function_exists("strrrchr"))
{
    function strrrchr($haystack,$needle)
    {
        return substr($haystack,0,strpos($haystack,$needle)+strlen($needle));
    }
}


function do_updateranks()
{
    global $TABLE_PREFIX, $XBTT_USE, $FORUMLINK, $db_prefix, $btit_settings;

    if(date("G")==$btit_settings["autorank_fullcheck"])
    {
        $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `smf_fid` FROM `{$TABLE_PREFIX}users` WHERE `id`=1");
        $row=mysqli_fetch_assoc($res);
        if($row["smf_fid"]==0)
            $fullcheck="yes";
        else
            $fullcheck="no";
    }
    if(date("G")==($btit_settings["autorank_fullcheck"]+1))
    {
        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `smf_fid`=0 WHERE `id`=1");
    }

    // Query to grab the parameters for all autorank enabled levels
    $query ="SELECT `id`, `id_level`, `level` , `autorank_position`, ";
    $query.="`autorank_min_upload`, `autorank_minratio`, `autorank_smf_group_mirror` ";
    $query.="FROM `{$TABLE_PREFIX}users_level` ";
    $query.="WHERE `autorank_state` = 'Enabled' ";
    $query.="ORDER BY `autorank_position` ASC";

    $res=mysqli_query($GLOBALS["___mysqli_ston"], $query);

    if(@mysqli_num_rows($res)>0)
    {
        $i=0;
        while ($row=mysqli_fetch_assoc($res))
        {
            $level[$i]=$row;
            $i++;
        }
    }
    else
        return;

    $level2=$level;

    $grouplist="";
    foreach($level AS $k => $v)
    {
        $grouplist.=$v["id"].",";
        if($v["autorank_position"]==0)
        {
            $default_level=$v["id"];
            if($FORUMLINK=="smf")
            {
                $default_forum_level=$v["autorank_smf_group_mirror"];
            }
            unset($level2[$k]);
        }
    }
    $grouplist=trim($grouplist, ",");

    if ($XBTT_USE)
    {
        $udownloaded="`u`.`downloaded`+IFNULL(`x`.`downloaded`,0) `downloaded`";
        $uuploaded="`u`.`uploaded`+IFNULL(`x`.`uploaded`,0) `uploaded`";
        $utables="`{$TABLE_PREFIX}users` `u` LEFT JOIN `xbt_users` `x` ON `x`.`uid`=`u`.`id`";
        $activetorr1="LEFT JOIN `xbt_files_users` `xfu` ON `u`.`id`=`xfu`.`uid` ";
        $activetorr2="AND `xfu`.`mtime` IS NOT NULL ";
    }
    else
    {
        $udownloaded="`u`.`downloaded`";
        $uuploaded="`u`.`uploaded`";
        $utables="`{$TABLE_PREFIX}users` `u`";
        $activetorr1="LEFT JOIN `{$TABLE_PREFIX}peers` `p` ON `u`.`pid`=`p`.`pid` ";
        $activetorr2="AND `p`.`lastupdate` IS NOT NULL ";
    }

    if(date("G")==$btit_settings["autorank_fullcheck"]  && $fullcheck=="yes")
    {
        $query ="SELECT `u`.`id`, `u`.`id_level`, ".$uuploaded.", ";
        $query.=$udownloaded.", `u`.`smf_fid` ";
        $query.="FROM ".$utables." ";
        $query.="WHERE `u`.`id_level` IN(".$grouplist.") ";
        $query.="ORDER BY `u`.`id` ASC";

        @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `smf_fid`='-1' WHERE `id`=1");
    }
    else
    {
        $query ="SELECT `u`.`id`, `u`.`id_level`, ".$uuploaded.", ";
        $query.=$udownloaded.", `u`.`smf_fid` ";
        $query.="FROM ".$utables." ";
        $query.=$activetorr1." ";
        $query.="WHERE `u`.`id_level` IN(".$grouplist.") "; 
        $query.=$activetorr2." ";
        $query.="GROUP BY `u`.`id` ";
        $query.="ORDER BY `u`.`id` ASC";
    }

    $res=mysqli_query($GLOBALS["___mysqli_ston"], $query);

    $user=array();
    while($row=mysqli_fetch_assoc($res))
    {
        if($row["downloaded"]>0)
            $row["ratio"]=number_format($row["uploaded"]/$row["downloaded"],3,".","");
        else
            $row["ratio"]=99999.999;

        $user[$row["id"]]["curlev"]=$row["id_level"];
        $user[$row["id"]]["newlev"]=$default_level;
        if($FORUMLINK=="smf")
        {
            $user[$row["id"]]["newforumlev"]=$default_forum_level;
            $user[$row["id"]]["smf_fid"]=$row["smf_fid"];
        }
        
        $lock="no";        
        foreach($level2 as $k => $v)
        {
            if($v["autorank_position"]<0)
            {
                if($row["downloaded"]>$v["autorank_min_upload"]  && $row["ratio"]<$v["autorank_minratio"] && $lock=="no")
                {
                    if($FORUMLINK=="smf")
                    {
                        $user[$row["id"]]["newforumlev"]=$v["autorank_smf_group_mirror"];
                    }
                    $user[$row["id"]]["newlev"]=$v["id"];
                    $lock="yes";
                }
            }
            elseif($v["autorank_position"]>0)
            {
                if($row["ratio"]>=$v["autorank_minratio"] && $row["uploaded"]>=$v["autorank_min_upload"])
                {
                    $user[$row["id"]]["newlev"]=$v["id"];
                    if($FORUMLINK=="smf")
                    {
                        $user[$row["id"]]["newforumlev"]=$v["autorank_smf_group_mirror"];
                    }
                }
            }
        }
    }
    foreach($user as $k => $v)
    {
        if ($v["curlev"]!=$v["newlev"])
        {
            // Query to update their tracker level
            $query1 ="UPDATE `{$TABLE_PREFIX}users` ";
            $query1.="SET `id_level`=".$v["newlev"]." ";
            $query1.="WHERE `id`=".$k;

            @mysqli_query($GLOBALS["___mysqli_ston"], $query1);

            if($FORUMLINK=="smf")
            {
                // Query to update their forum level to match
                $query2 ="UPDATE `{$db_prefix}members` ";
                $query2.="SET `ID_GROUP`=".$v["newforumlev"]." ";
                $query2.="WHERE `ID_MEMBER`=".$v["smf_fid"];

                @mysqli_query($GLOBALS["___mysqli_ston"], $query2);
            }
        }
    }
}
//Get Board list by dodge 2008
function get_forum_list($fid, $i)
{
    global $CURUSER, $btit_settings, $TABLE_PREFIX, $db_prefix, $ipb_prefix;
    if(substr($btit_settings["forum"], 0, 3) == "smf")
    {
        $return = "\n<input type=\"hidden\" name=\"cid\" value=\"$i\" />\n";
        $return .= "\n<select name=\"forumid\" onchange=\"this.form.submit();\"><option value=0>---</option>\n";
        //first we get the categories
        $res = get_result("SELECT ".(($btit_settings["forum"] == "smf")?"`ID_CAT`":"`id_cat`").", `name` FROM `{$db_prefix}categories`", true, $btit_settings["cache_duration"]);
        foreach($res as $arr)
        {
            //now, we get the forums, not the "sub-forums"
            $res2 = get_result("SELECT ".(($btit_settings["forum"] == "smf")?"`ID_BOARD`":"`id_board`")." `idb`, `name` FROM `{$db_prefix}boards` WHERE `child".(($btit_settings["forum"] == "smf")?"L":"_l")."evel`=0 AND ".(($btit_settings["forum"] == "smf")?"`ID_CAT`=".$arr["ID_CAT"]:"`id_cat`=".$arr["id_cat"])." ORDER BY `board".(($btit_settings["forum"] == "smf")?"O":"_o")."rder`", true, $btit_settings["cache_duration"]);
            $return .= "&nbsp;&nbsp;<option value=".(($btit_settings["forum"] == "smf")?$arr["ID_CAT"]:$arr["id_cat"])." disabled>".$arr["name"]."</option>\n";
            foreach($res2 as $arr2)
            {
                $res3 = get_result("SELECT ".(($btit_settings["forum"] == "smf")?"`ID_BOARD`":"`id_board`")." `idb`, `name` FROM `{$db_prefix}boards` WHERE `child".(($btit_settings["forum"] == "smf")?"L":"_l")."evel`=1 AND ".(($btit_settings["forum"] == "smf")?"`ID_PARENT`":"`id_parent`")."=".$arr2["idb"]." ORDER BY `board".(($btit_settings["forum"] == "smf")?"O":"_o")."rder`", true, $btit_settings["cache_duration"]);
                $num_subs = count($res3);
                if($num_subs > 0)
                {
                    $return .= "\n<optgroup label=\"".$arr2["name"]."\">";
                    foreach($res3 as $arr3)
                    {
                        if($arr3["idb"] == $fid)
                            $selected = "selected";
                        else
                            $selected = "";
                        $return .= "\n<option value=".$arr3["idb"]." ".$selected.">".$arr3["name"]."</option>\n";
                    }
                    $return .= "</optgroup>";
                }
                else
                {
                    if($arr2["idb"] == $fid)
                        $selected = "selected";
                    else
                        $selected = "";
                    $return .= "\n<option value=".$arr2["idb"]." ".$selected.">".$arr2["name"]."</option>\n";
                }
            }
        }
        $return .= "\n</select>\n";
    }
    elseif($btit_settings["forum"] == "ipb")
    {
        $res = get_result("SELECT `id`, `name` FROM `{$ipb_prefix}forums` WHERE `parent_id`!='-1' ORDER BY `id` ASC", true, $btit_settings["cache_duration"]);
        $return = "\n<input type=\"hidden\" name=\"cid\" value=\"$i\" />\n";
        $return .= "\n<select name=\"forumid\" onchange=\"this.form.submit();\"><option value=0>---</option>\n";
        foreach($res as $arr)
        {
            $return .= "\n<option value=\"".$arr["id"].($fid == $arr["id"]?"\" selected=\"selected\">":"\">").htmlspecialchars(unesc($arr["name"]))."</option>\n";
        }
        $return .= "\n</select>\n</form>\n";
    }
    else
    {
        $res = get_result("SELECT id, name, minclassread, minclasscreate FROM {$TABLE_PREFIX}forums WHERE minclassread<=".intval($CURUSER["id_level"]), true, $btit_settings["cache_duration"]);
        $return = "\n<input type=\"hidden\" name=\"cid\" value=\"$i\" />\n";
        $return .= "\n<select name=\"forumid\" onchange=\"this.form.submit();\"><option value=0>---</option>\n";
        foreach($res as $arr)
        {
            $return .= "\n<option value=\"".$arr["id"].($fid == $arr["id"]?"\" selected=\"selected\">":"\">").htmlspecialchars(unesc($arr["name"]))."</option>\n";
        }
        $return .= "\n</select>\n</form>\n";
    }
    return $return;
}
//begin new_auto_topic by dodge 2008
function new_auto_topic($boardid, $curuid, $filename, $forum_comment, $hash)
{
    global $CURUSER, $btit_settings, $TABLE_PREFIX, $db_prefix, $ipb_prefix;
    $topic_tag = $btit_settings["smf_tag"];
    if($btit_settings["forum"] == "ipb")
    {
        $lasttopic = ipb_make_post($boardid, $filename, $forum_comment, $curuid, false);
        if(!$lasttopic)
        {
            $topic = get_result("SELECT MAX(`tid`) `tid` FROM `{$ipb_prefix}topics`", true);
            $lasttopic = $topic[0]["tid"];
        }
        do_sqlquery("UPDATE `{$TABLE_PREFIX}files` SET `topicid`='$lasttopic' WHERE `info_hash`='$hash'", true);
    }
    elseif(substr($btit_settings["forum"], 0, 3) == "smf")
    {
        if($btit_settings["forum"] == "smf")
            do_sqlquery("INSERT INTO {$db_prefix}topics (`ID_TOPIC`, `isSticky`, `ID_BOARD`, `ID_MEMBER_STARTED`, `ID_MEMBER_UPDATED`, `numViews`) VALUES (NULL, '0', '$boardid', $curuid, $curuid, '1')", true);
        else
            do_sqlquery("INSERT INTO {$db_prefix}topics (`id_topic`, `is_sticky`, `id_board`, `id_member_started`, `id_member_updated`, `num_views`) VALUES (NULL, '0', '$boardid', $curuid, $curuid, '1')", true);
        $lasttopic = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
        if($btit_settings["forum"] == "smf")
            do_sqlquery("INSERT INTO `{$db_prefix}messages` (`ID_MSG`, `ID_TOPIC`, `ID_BOARD`, `posterTime`, `ID_MEMBER`, `subject`, `posterName`, `posterEmail`, `posterIP`, `smileysEnabled`, `body`) VALUES (\"\", '$lasttopic', '$boardid', UNIX_TIMESTAMP(), $curuid, \"".$topic_tag."".$filename."\", '".$CURUSER["username"]."', '".$CURUSER["email"]."', '".$CURUSER["cip"]."', 1, '$forum_comment')", true);
        else
            do_sqlquery("INSERT INTO `{$db_prefix}messages` (`id_msg`, `id_topic`, `id_board`, `poster_time`, `id_member`, `subject`, `poster_name`, `poster_email`, `poster_ip`, `smileys_enabled`, `body`) VALUES (\"\", '$lasttopic', '$boardid', UNIX_TIMESTAMP(), $curuid, \"".$topic_tag."".$filename."\", '".$CURUSER["username"]."', '".$CURUSER["email"]."', '".$CURUSER["cip"]."', 1, '$forum_comment')", true);
        $lastmessage = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
        do_sqlquery("UPDATE `{$db_prefix}topics` SET ".(($btit_settings["forum"] == "smf")?"`ID_FIRST_MSG`":"`id_first_msg`")."=$lastmessage, ".(($btit_settings["forum"] == "smf")?"`ID_LAST_MSG`":"`id_last_msg`")."=$lastmessage WHERE ".(($btit_settings["forum"] == "smf")?"`ID_TOPIC`":"`id_topic`")."=$lasttopic", true);
        do_sqlquery("UPDATE `{$db_prefix}boards` SET ".(($btit_settings["forum"] == "smf")?"`ID_LAST_MSG`":"`id_last_msg`")."=$lastmessage, ".(($btit_settings["forum"] == "smf")?"`numTopics`=`numTopics`":"`num_topics`=`num_topics`")."+1, ".(($btit_settings["forum"] == "smf")?"`numPosts`=`numPosts`":"`num_posts`=`num_posts`")."+1 WHERE ".(($btit_settings["forum"] == "smf")?"`ID_BOARD`":"`id_board`")."=$boardid", true);
        do_sqlquery("UPDATE `{$db_prefix}members` SET `posts`=`posts`+1 WHERE ".(($btit_settings["forum"] == "smf")?"`ID_MEMBER`":"`id_member`")."=$curuid", true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}files` SET `topicid`='$lasttopic' WHERE `info_hash`='$hash'", true);
    }
    else
    {
        $add_topic_count = ", topiccount=topiccount+1";
        do_sqlquery("INSERT INTO {$TABLE_PREFIX}topics (userid, forumid, subject) VALUES($curuid, '$boardid', '".$topic_tag." ".$filename."')", true);
        $lasttopic = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res) or stderr($language["ERROR"], $language["ERR_NO_TOPIC_ID"]);
        do_sqlquery("INSERT INTO {$TABLE_PREFIX}posts (topicid, userid, added, body) VALUES($lasttopic, $curuid, UNIX_TIMESTAMP(), '$forum_comment')", true);
        $lastmessage = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res) or stderr($language["ERROR"], $language["ERR_POST_ID_NA"]);
        do_sqlquery("UPDATE {$TABLE_PREFIX}topics SET lastpost=(SELECT MAX(id) FROM {$TABLE_PREFIX}posts WHERE topicid=$lasttopic) WHERE id=$lasttopic", true);
        do_sqlquery("UPDATE {$TABLE_PREFIX}forums SET postcount=postcount+1 $add_topic_count WHERE id='$boardid'", true);
        do_sqlquery("UPDATE `{$TABLE_PREFIX}files` SET `topicid`='$lasttopic' WHERE `info_hash`='$hash'", true);
    }
}
//end new_forum_topic
// EOF
?>