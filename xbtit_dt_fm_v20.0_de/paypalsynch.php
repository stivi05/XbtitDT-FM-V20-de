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
error_reporting(E_ALL);
 ini_set("display_errors", 1); 
require"include/functions.php";
dbconn(); 

global $CURUSER, $TABLE_PREFIX, $btit_settings;

// get settings
$zap_pp = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}paypal_settings WHERE id ='1'");
$settings = mysqli_fetch_array($zap_pp);

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-synch';

$tx_token = $_GET['tx'];
$auth_token = $settings["identity_token"];
$req .= "&tx=$tx_token&at=$auth_token";

// post back to PayPal system to validate

$header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Connection: close\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

$fp = fsockopen ('ssl://www'.($settings['test']=='true'?'.sandbox':'').'.paypal.com', 443, $errno, $errstr, 30);
if (!$fp)
  {
    $fp = fsockopen ('www'.($settings['test']=='true'?'.sandbox':'').'.paypal.com', 80, $errno, $errstr, 30);
  }

if (!$fp) {
die("error");
} else {
fputs ($fp, $header . $req);
// read the body data
$res = '';
$headerdone = false;
while (!feof($fp)) {
$line = fgets ($fp, 1024);
if (strcmp($line, "\r\n") == 0) {
// read the header
$headerdone = true;
}
else if ($headerdone)
{
// header has been read. now read the contents
$res .= $line;
}
}

// parse the data
$lines = explode("\n", $res);
$keyarray = array();
if (strcmp ($lines[0], "SUCCESS") == 0) {
for ($i=1; $i<count($lines);$i++){
list($key,$val) = explode("=", $lines[$i]);
$keyarray[urldecode($key)] = urldecode($val);
}
// check the payment_status is Completed
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct
// process payment

$item_name = $keyarray['item_name'];
$payment_amount = 0 + $keyarray['mc_gross'];
$item_number = $keyarray['item_number'];
$payment_currency = $keyarray['mc_currency'];
$anonymous=$keyarray['custom'];
$payer_email = $keyarray['payer_email'];
$first_name = $keyarray['first_name'];
$last_name = $keyarray['last_name'];
$country = $keyarray['address_country'];
$payment_type = $keyarray['payment_type'];
$addamt=round($amount);
$score=(0 + $addamt);

// find username
$zap_usr = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT timed_rank,username,id_level FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER["uid"]);
$wyn_usr = mysqli_fetch_array($zap_usr);

if ($item_number == 1 OR $item_number == 2 )
{$first_name_site = $wyn_usr["username"]; }

else
{$first_name_site="anonymous"; }

        if ($payment_amount <= $settings["today"])
            $vipdays = floor($payment_amount * $settings["vip_days"]);
        else if ($payment_amount > $settings["today"] AND $payment_amount <= $settings["todayb"])
            $vipdays = floor($payment_amount * $settings["vip_daysb"]);
        else
            $vipdays = floor($payment_amount * $settings["vip_daysc"]);

        if ($payment_amount <= $settings["togb"])
        {
            $bonus =(1073741824*$settings["gb"]);
            $pm_bonus =( $payment_amount * $settings["gb"] );
        }
        else if ($payment_amount > $settings["togb"] AND $payment_amount <= $settings["togbb"])
        {
            $bonus =(1073741824*$settings["gbb"]);
            $pm_bonus =( $payment_amount * $settings["gbb"] );
        }
        else
        {
            $bonus =(1073741824*$settings["gbc"]);
            $pm_bonus =( $payment_amount * $settings["gbc"] );
        }
        
$cid=$CURUSER["uid"];
// write to database
$query = "INSERT INTO {$TABLE_PREFIX}donors (id, userid, first_name, last_name, payers_email, mc_gross, date, country, item)VALUES ('', '$cid', '$first_name_site', '$last_name', '$payer_email', '$payment_amount', NOW() ,'$country' , '$item_number')";

$ppt=  ($settings["received"]+ $payment_amount);
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}paypal_settings SET received='$ppt' WHERE id='1'");

// upload bonus
if ($item_number == 2 )
{
 $bonus_user = ($payment_amount * $bonus );
// send pm here
$mesg=" Dear ".$wyn_usr["username"]." ,\n\n Our System have received a ".$payment_currency.$payment_amount." donation on our paypal account today \n\n The transaction reflects your userid \n\n You did recieve a upload bonus of ".$pm_bonus." GB \n\n Thank you for your help to keep ".$SITENAME." alive\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]";
send_pm(0,$CURUSER[uid],sqlesc('Your Donation Transaction Confirmation'),sqlesc($mesg));
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET uploaded = uploaded +".$bonus_user." WHERE `id` = '".$CURUSER["uid"]."' ");
}
//timed ranks start
if ($item_number == 0 OR $item_number == 1 )
{
// staff demote protection
$staff = $wyn_usr["id_level"];
$zap_usr_st = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level FROM {$TABLE_PREFIX}users_level WHERE id =$staff");
$wyn_usr_st = mysqli_fetch_array($zap_usr_st);

if  ($wyn_usr_st["id_level"] <=6 AND $item_number == 1)
{
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET  `old_rank` = `id_level` WHERE `id`=".$CURUSER["uid"]);

$dt2 = "yes";
$dt3 = $settings["vip_rank"];
$dt4 = $vipdays;
// check for vip days
$dtv= strtotime($wyn_usr["timed_rank"]);
$now = strtotime("now");
if ($dtv>$now)
{
$diff1 = $dtv-$now;
$diff2 = $diff1/ 86400;
$dt4 = $diff2+$vipdays;
}
// check for vip days
$dt1=rank_expiration_dt(mktime(date('H')+2,date('i'),date('s'),date('m'),date('d')+addslashes($dt4),date('Y')));

mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET  `timed_rank`='".$dt1."',`rank_switch`='".$dt2."', `id_level`='".$dt3."' WHERE `id`=".$CURUSER["uid"]);

//smf rank
global $FORUMLINK ;
if($FORUMLINK=="smf")
{
$smf=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT smf_fid FROM {$TABLE_PREFIX}users WHERE id =".$CURUSER["uid"]);
$smf_user = mysqli_fetch_array($smf);
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE smf_members SET ID_GROUP = ".$settings["smf"]." WHERE ID_MEMBER=".$smf["smf_fid"]);
}

// send pm here
$mesg=" Dear ".$wyn_usr["username"]." ,\n\n Our System have received a ".$payment_currency.$payment_amount." donation on our paypal account today \n\n The transaction reflects your userid \n\n You are now promoted to VIP for ".$vipdays." days \n\n Thank you for your help to keep ".$SITENAME." alive\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]";
send_pm(0,$CURUSER[uid],sqlesc('Your Donation Transaction Confirmation'),sqlesc($mesg));
}
else
{
$mesg=" Dear ".$wyn_usr["username"]." ,\n\n Our System have received a ".$payment_currency.$payment_amount." donation on our paypal account today \n\n The transaction reflects your userid \n\n Because you are a staff member or a anonymous donator we will not promote or demote you to VIP \n\n Thank you for your help to keep ".$SITENAME." alive\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]";
send_pm(0,$CURUSER[uid],sqlesc('Your Donation Transaction Confirmation'),sqlesc($mesg));
}
}
//timed ranks end

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Could not execute query : $query." . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

// donation star bridge
if ($settings["don_star"]=="true")
{
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET donor = 'yes' WHERE id =".$CURUSER["uid"]);
}
// donation historie bridge
if ($settings["historie"]=="true")
{

$donation = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}don_historie WHERE don_id =".$CURUSER["uid"]);
$dh = mysqli_fetch_assoc($donation);

if(empty($dh["don_ation"]))
{
do_sqlquery('insert '.$TABLE_PREFIX.'don_historie SET donate_date=NOW(),don_ation="'.$payment_amount.'" ,don_id='.$CURUSER["uid"]);
}
else if(empty($dh["don_ation_1"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_1="'.$payment_amount.'",donate_date_1=NOW() WHERE don_id='.$CURUSER["uid"]);
}
 else if(empty($dh["don_ation_2"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_2="'.$payment_amount.'",donate_date_2=NOW() WHERE don_id='.$CURUSER["uid"]);
}
else if(empty($dh["don_ation_3"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_3="'.$payment_amount.'",donate_date_3=NOW() WHERE don_id='.$CURUSER["uid"]);
}
else if(empty($dh["don_ation_4"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_4="'.$payment_amount.'",donate_date_4=NOW() WHERE don_id='.$CURUSER["uid"]);
}
else if(empty($dh["don_ation_5"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_5="'.$payment_amount.'",donate_date_5=NOW() WHERE don_id='.$CURUSER["uid"]);
}
else if(empty($dh["don_ation_6"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_6="'.$payment_amount.'",donate_date_6=NOW() WHERE don_id='.$CURUSER["uid"]);
}
else if(empty($dh["don_ation_7"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_7="'.$payment_amount.'",donate_date_7=NOW() WHERE don_id='.$CURUSER["uid"]);
}
else if(empty($dh["don_ation_8"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_8="'.$payment_amount.'",donate_date_8=NOW() WHERE don_id='.$CURUSER["uid"]);
}
else if(empty($dh["don_ation_9"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_9="'.$payment_amount.'",donate_date_9=NOW() WHERE don_id='.$CURUSER["uid"]);
}
 else if(empty($dh["don_ation_10"]))
{
do_sqlquery('update '.$TABLE_PREFIX.'don_historie SET don_ation_10="'.$payment_amount.'",donate_date_10=NOW() WHERE don_id='.$CURUSER["uid"]);
}
}
// don historie end



redirect("index.php?page=complete&fname=$first_name&lname=$last_name&item=$item_name&amt=$payment_amount&curr=$payment_currency");
}
else if (strcmp ($lines[0], "FAIL") == 0) {
 @fclose ($fp);
        $msg = 'Non verified paypal access: Username: <a href=' . $BASEURL . '/index.php?page=userdetails&id=' . $CURUSER['uid'] . '>' . $CURUSER['username'] . '</a> - UserID: ' . $CURUSER['uid'] . ' - UserIP : ' . getip ();
        write_log ($msg,"delete");
if (!$language['ERROR'])
    $language['ERROR']='Error';    
ext_err_msg(sprintf($language["ERROR"]),$msg);
}

}
@fclose ($fp);

?>