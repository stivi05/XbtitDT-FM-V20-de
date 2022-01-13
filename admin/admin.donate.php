<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    Advanced Auto Donation System by DiemThuy ( sept 2009 )
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
require_once("include/config.php");

dbconn();

$action = $_GET['action'];

// update donate settings in the database
if($action == 'update')
    {

        $DT1    =   $_POST["pp_unit"];
        $DT2    =   $_POST["pp_test"];
        $DT3    =   $_POST["pp_scrol"];
       	$DT5	=	$_POST['pp_email_sand'];
       	$DT6	=	$_POST['pp_email'];
        $DT7	=	$_POST['pp_day'];
        $DT77	=	$_POST['pp_dayb'];
        $DT777	=	$_POST['pp_dayc'];
       	$DT8	=	$_POST['pp_rank'];
        $DT9	=	$_POST['pp_needed'];
       	$DT10	=	$_POST['pp_received'];
       	$DT11	=	$_POST['pp_due_date'];
        $DT12	=	$_POST['pp_scrol_tekst'];
        $DT13	=	$_POST['pp_block'];
        $DT14	=	$_POST['pp_historie'];
        $DT15	=	$_POST['pp_don_star'];
        $DT16	=	$_POST['pp_gb'];
        $DT17	=	$_POST['pp_smf'];
        $DT18	=	$_POST['pp_IPN'];
        $DT19	=	$_POST['identity_token'];
        $DT20	=	$_POST['pp_inv'];
        $DT21	=	$_POST['pp_invon'];
        $DT22	=	$_POST['pp_gbb'];
        $DT23	=	$_POST['pp_gbc'];
        $DT24	=	$_POST['pp_togb'];
        $DT25	=	$_POST['pp_togbb'];
        $DT26	=	$_POST['pp_togbc'];
        $DT27	=	$_POST['pp_today'];
        $DT28	=	$_POST['pp_todayb'];
        $DT29	=	$_POST['pp_todayc'];

    do_sqlquery("UPDATE `{$TABLE_PREFIX}paypal_settings` SET `units`='".$DT1."',`test`='".$DT2."',`donation_block`='".$DT3."',`sandbox_email`='".$DT5."',`paypal_email`='".$DT6."',`vip_days`='".$DT7."',`vip_daysb`='".$DT77."',`vip_daysc`='".$DT777."',`vip_rank`='".$DT8."',`needed`='".$DT9."',`received`='".$DT10."', `due_date`='".$DT11."', `num_block`='".$DT13."' , `scrol_tekst`='".$DT12."' ,`historie`='".$DT14."',`don_star`='".$DT15."',`gb`='".$DT16."',`smf`='".$DT17."',`IPN`='".$DT18."',`identity_token`='".$DT19."',`ppinv`='".$DT20."',`ppinvon`='".$DT21."',`gbb`='".$DT22."',`gbc`='".$DT23."',`togb`='".$DT24."',`togbb`='".$DT25."',`togbc`='".$DT26."',`today`='".$DT27."',`todayb`='".$DT28."',`todayc`='".$DT29."' WHERE `id`='1' ") or sqlerr();
    redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=donate");
	exit();
}

//Here we will select the data from the table donors
$settings = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}paypal_settings WHERE id ='1'") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$pay=@mysqli_fetch_assoc($settings);



    $admintpl->set("language", $language);
    
    if ($pay["units"] =='true')
    {
    $pp_unityes="checked";
    }
    else if  ($pay["units"] =='false')
    {
    $pp_unitno="checked";
    }
        if ($pay["test"] =='true')
    {
    $pp_testyes="checked";
    }
    else if  ($pay["test"] =='false')
    {
    $pp_testno="checked";
    }
        if ($pay["donation_block"] =='true')
    {
    $pp_scrolyes="checked";
    }
    else if  ($pay["donation_block"] =='false')
    {
    $pp_scrolno="checked";
    }
    if ($pay["historie"] =='true')
    {
    $pp_historieyes="checked";
    }
    else if  ($pay["historie"] =='false')
    {
    $pp_historieno="checked";
    }
    if ($pay["don_star"] =='true')
    {
    $pp_don_staryes="checked";
    }
    else if  ($pay["don_star"] =='false')
    {
    $pp_don_starno="checked";
    }
    if ($pay["IPN"] =='true')
    {
    $pp_IPN_yes="checked";
    }
    else if  ($pay["IPN"] =='false')
    {
    $pp_IPN_no="checked";
    }
    if ($pay["ppinvon"] =='true')
    {
    $pp_INVON_yes="checked";
    }
    else if  ($pay["ppinvon"] =='false')
    {
    $pp_INVON_no="checked";
    }
    $admintpl->set("testtttt","<td class=lista>&nbsp;&nbsp;enable&nbsp;<input type=radio name=pp_don_star value=true ".$pp_don_staryes." />&nbsp;&nbsp;disable&nbsp;<input type=radio name=pp_don_star value=false ".$pp_don_starno." /></td> ");
    $admintpl->set("testtt","<td class=lista>&nbsp;&nbsp;enable&nbsp;<input type=radio name=pp_scrol value=true ".$pp_scrolyes." />&nbsp;&nbsp;disable&nbsp;<input type=radio name=pp_scrol value=false ".$pp_scrolno." /></td> ");
    $admintpl->set("testt","<td class=lista>&nbsp;&nbsp;&#8364;&nbsp;<input type=radio name=pp_unit value=true ".$pp_unityes." />&nbsp;&nbsp;&#36;&nbsp;<input type=radio name=pp_unit value=false ".$pp_unitno." /></td>");
    $admintpl->set("test","<td class=lista>&nbsp;&nbsp;sandbox&nbsp;<input type=radio name=pp_test value=true  ".$pp_testyes." />&nbsp;&nbsp;Paypal&nbsp;<input type=radio name=pp_test value=false ".$pp_testno." /></td>");
    $admintpl->set("Itest","<td class=lista>&nbsp;&nbsp;&nbsp;IPN&nbsp;<input type=radio name=pp_IPN value=true  ".$pp_IPN_yes." />&nbsp;&nbsp;PDT&nbsp;<input type=radio name=pp_IPN value=false ".$pp_IPN_no." /></td>");
        $admintpl->set("IAtest","<td class=lista>&nbsp;&nbsp;&nbsp;enabled&nbsp;<input type=radio name=pp_invon value=true  ".$pp_INVON_yes." />&nbsp;&nbsp;disabled&nbsp;<input type=radio name=pp_invon value=false ".$pp_INVON_no." /></td>");
    $admintpl->set("testttt","<td class=lista>&nbsp;&nbsp;enable&nbsp;<input type=radio name=pp_historie value=true  ".$pp_historieyes." />&nbsp;&nbsp;disable&nbsp;<input type=radio name=pp_historie value=false ".$pp_historieno." /></td>");
    $admintpl->set("pp_email_sand", $pay["sandbox_email"]);
    $admintpl->set("pp_email", $pay["paypal_email"]);
    $admintpl->set("pp_token", $pay["identity_token"]);
    $admintpl->set("pp_day", $pay["vip_days"]);
    $admintpl->set("pp_dayb", $pay["vip_daysb"]);
    $admintpl->set("pp_dayc", $pay["vip_daysc"]);
    $admintpl->set("pp_rank", $pay["vip_rank"]);
    $admintpl->set("pp_smf", $pay["smf"]);
    $admintpl->set("pp_gb", $pay["gb"]);
    $admintpl->set("pp_gbb", $pay["gbb"]);
    $admintpl->set("pp_gbc", $pay["gbc"]);
    $admintpl->set("pp_togb", $pay["togb"]);
    $admintpl->set("pp_togbb", $pay["togbb"]);
    $admintpl->set("pp_today", $pay["today"]);
    $admintpl->set("pp_todayb", $pay["todayb"]);
    $admintpl->set("pp_count", ($pay["today"]+1));
    $admintpl->set("pp_counta", ($pay["togb"]+1));
    $admintpl->set("pp_countb", ($pay["todayb"]+1));
    $admintpl->set("pp_countc", ($pay["togbb"]+1));
    $admintpl->set("pp_needed", $pay["needed"]);
    $admintpl->set("pp_received", $pay["received"]);
    $admintpl->set("pp_due_date", $pay["due_date"]);
    $admintpl->set("pp_block", $pay["num_block"]);
    $admintpl->set("pp_scrol_tekst", $pay["scrol_tekst"]);
    $admintpl->set("ppp_inv", $pay["ppinv"]);
    $admintpl->set("frm_action", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=donate&amp;action=update");

// donors list
$donor = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}donors ORDER BY date DESC") ;

    $don=array();
    $i=0;

if (mysqli_num_rows($donor )==0)
{
    $don[$i]["Username"]=("<center><font color=green>nothing</font></center>");
    $don[$i]["Anonymous"]=("<center><font color=green>here</font></center>");
    $don[$i]["Last_name"]=("<center><font color=green>yet</font></center>");
    $i++;
}
         else
             {
                 while ($arr=mysqli_fetch_assoc($donor ))
                 {
$admintpl->set("language",$language);

if ($arr["userid"]  == "0")
{}
else
{


               $r2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level,username,timed_rank,old_rank FROM {$TABLE_PREFIX}users WHERE id=$arr[userid] AND $arr[userid] > 0") ;
               $a2 = mysqli_fetch_assoc($r2);
               
               $r3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level,prefixcolor,suffixcolor FROM {$TABLE_PREFIX}users_level WHERE id=$a2[id_level]") ;
               $a3 = mysqli_fetch_assoc($r3);
               
               $r4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor,suffixcolor,level FROM {$TABLE_PREFIX}users_level WHERE id=$a2[old_rank]");
               $a4 = mysqli_fetch_assoc($r4);
               
 if ($arr['first_name']=="anonymous")
{
  $ano="<font color=red>yes</font>";
  $vip="<font color=red>no timed rank</font>";
  $rank="<font color=red>no old rank</font>";
  $upload="<font color=red>no upload</font>";
}
 if ($arr['item']==1 AND $a3["id_level"] <=6)
{
  $ano="<font color=green>no</font>";
  $vip="<font color=green>".$a2['timed_rank']."</font>";
  $rank= $a4["prefixcolor"].$a4['level'].$a4["suffixcolor"];
  $upload="<font color=red>no upload</font>";
}

 if ($arr['item']==1 AND $a3["id_level"] >=6)
{
  $ano="<font color=green>no</font>";
  $vip="<font color=purple>demote protection</font>";
  $rank="<font color=purple>demote protection</font>";
  $upload="<font color=red>no upload</font>";
}

 if ($arr['item']==2 )
{
  $ano="<font color=green>no</font>";
  $vip="<font color=red>no timed rank</font>";
  $rank="<font color=red>no old rank</font>";
  $upl=($pay["gb"]*$arr["mc_gross"]);
  $upload="<font color=green>".$upl." GB</font>";
}

$del=$arr["first_name"];

if ($a2['username']=="")
$name = "[deleted] ".$del;
else
$name = "<a href=index.php?page=userdetails&id=".$arr["userid"].">".$a3["prefixcolor"].$a2['username'].$a3["suffixcolor"]."</a>";


        $don[$i]["Username"]= $name;
        $don[$i]["Anonymous"]=$ano;
        $don[$i]["Last_name"]=$arr['last_name'];
        $don[$i]["Email"]=$arr['payers_email'];
        $don[$i]["Date"]=$arr['date'];
        $don[$i]["Amount"]=$arr['mc_gross'];
        $don[$i]["Upload"]=$upload;
        $don[$i]["Vip"]=$vip;
        $don[$i]["Rank"]=$rank;
        $i++;
}}

$admintpl->set("don",$don);
}
?>