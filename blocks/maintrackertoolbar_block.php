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

global $CURUSER, $XBTT_USE,$TABLE_PREFIX,$btit_settings,$language;
?>
<table class="tool" cellpadding="2" cellspacing="0" width="100%"><tr>
<?php

// freeleech hack
include("include/offset.php");
    $query = do_sqlquery("SELECT *, UNIX_TIMESTAMP(`free_expire_date`) AS `timestamp` FROM `{$TABLE_PREFIX}files` WHERE `external`='no'", true);
	$row = mysqli_fetch_array($query);

if($CURUSER["sfdownload"]=="no")
{
if($row["free"]=="no" AND $row["happy_hour"] =="no" )
{
      $freec="steelblue";
      $till='';
      $col='Free Leech';
      $post=' Not Today';
      $img='';
}
else if ($row["happy"]=="no" AND $row["happy_hour"] =="yes" )
{
   $happy1= do_sqlquery("SELECT UNIX_TIMESTAMP(`value_s`) AS `timestampp` FROM `{$TABLE_PREFIX}avps` WHERE `arg`='happyhour'");
   $happy2 = mysqli_fetch_array($happy1);

      $freec="steelblue";
      $till='';
      $col='';
      $post='Next Happy Hour Starts '.date("l jS F Y \a\\t g:i a",$happy2["timestampp"]-$offset);
      $img='';
}
else if($row["happy"]=="yes")
{
      $freec="red";
      $till='';
      $col='';
      $post='It Is Happy Hour ';
      $img ='<img src="images/proost.png" alt="free leech"/>';
}
else if($row["free"]=="yes")
{
     $freec="red";
     $till=' To ';
     $col='Free Leech';
     $pic="<img src=\"images/free.png \" />";
     $post=date("l jS F Y \a\\t g:i a",$row["timestamp"]-$offset);
     $img='';
}

 else
     {
      $col='Free Leech';
	  $freec="steelblue";
      $till='';
      $post=' Not Today';
      }
}
else
{
            $freec="red";
            $till='';
            $col='';
            $post='VIP Free Leech Is Enabled';
            $img ='';	
}    
// end freeleech hack

// DT Uploader Medals
$resuser=do_sqlquery("SELECT  trophy, reputation , up_med FROM {$TABLE_PREFIX}users WHERE id =".$CURUSER['uid']);
$rowuser= mysqli_fetch_array($resuser);

if ($rowuser["up_med"] == 0)
$upr="";

if ($rowuser["up_med"] == 1)
$upr= "<img src='images/goblet/medaille_bronze.gif' alt='Bronze Medal' title='Bronze Medal' />";

if ($rowuser["up_med"] == 2)
$upr= "<img src='images/goblet/medaille_argent.gif' alt='Silver Medal' title='Silver Medal' />";

if ($rowuser["up_med"] >= 3)
$upr= "<img src='images/goblet/medaille_or.gif' alt='Gold Medal' title='Gold Medal' />";
// DT Uploader Medals

// DT arcade
if ($rowuser["trophy"] == 0)
$rra="";

if ($rowuser["trophy"] == 1)
$rra= "<img src='images/crown.gif' alt='Arcade King' title='Arcade King' />";

// DT arcade

// user image
    $do=$btit_settings["img_don"];
    $don=$btit_settings["img_donm"];
    $ma=$btit_settings["img_mal"];
    $fe=$btit_settings["img_fem"];
    $ba=$btit_settings["img_ban"];
    $tu=$btit_settings["img_tru"];
    $vi=$btit_settings["img_vip"];
    $wa=$btit_settings["img_war"];
    $st=$btit_settings["img_sta"];
    $bi=$btit_settings["img_bir"];
    $pa=$btit_settings["img_par"];
    $sy=$btit_settings["img_sys"];
    $vip=$btit_settings["img_vipm"];
    $tut=$btit_settings["img_trum"];  
    $fr=$btit_settings["img_fri"];
    $ju=$btit_settings["img_jun"]; 
    $bo=$btit_settings["img_bot"];
    
$udo="";
$udob="";
$ubir="";
$umal="";
$ufem="";
$uban="";
$uwar="";
$upar="";
$ubot="";
$utrmu="";
$utrmo="";
$uvimu="";
$uvimo="";
$ufrie="";
$ujunk="";
$ustaf="";
$usys="";

if ($CURUSER["dona"] == 'yes')
$udo= "&nbsp;<img src='images/user_images/" . $do . "' alt='" . $btit_settings["text_don"] . "' title='" . $btit_settings["text_don"] . "' />";

if ($CURUSER["donb"] == 'yes')
$udob= "&nbsp;<img src='images/user_images/" . $don . "' alt='" . $btit_settings["text_donm"] . "' title='" . $btit_settings["text_donm"] . "' />";

if ($CURUSER["birt"] == 'yes')
$ubir= "&nbsp;<img src='images/user_images/" . $bi . "' alt='" . $btit_settings["text_bir"] . "' title='" . $btit_settings["text_bir"] . "' />";

if ($CURUSER["mal"] == 'yes')
$umal= "&nbsp;<img src='images/user_images/" . $ma . "' alt='" . $btit_settings["text_mal"] . "' title='" . $btit_settings["text_mal"] . "' />";

if ($CURUSER["bann"] == 'yes')
$uban= "&nbsp;<img src='images/user_images/" . $ba . "' alt='" . $btit_settings["text_ban"] . "' title='" . $btit_settings["text_ban"] . "' />";

if ($CURUSER["war"] == 'yes')
$uwar= "&nbsp;<img src='images/user_images/" . $wa . "' alt='" . $btit_settings["text_war"] . "' title='" . $btit_settings["text_war"] . "' />";

if ($CURUSER["fem"] == 'yes')
$ufem= "&nbsp;<img src='images/user_images/" . $fe . "' alt='" . $btit_settings["text_fem"] . "' title='" . $btit_settings["text_fem"] . "' />";

if ($CURUSER["par"] == 'yes')
$upar= "&nbsp;<img src='images/user_images/" . $pa . "' alt='" . $btit_settings["text_par"] . "' title='" . $btit_settings["text_par"] . "' />";

if ($CURUSER["bot"] == 'yes')
$ubot= "&nbsp;<img src='images/user_images/" . $bo . "' alt='" . $btit_settings["text_bot"] . "' title='" . $btit_settings["text_bot"] . "' />";

if ($CURUSER["trmu"] == 'yes')
$utrmu= "&nbsp;<img src='images/user_images/" . $tu . "' alt='" . $btit_settings["text_tru"] . "' title='" . $btit_settings["text_tru"] . "' />";

if ($CURUSER["trmo"] == 'yes')
$utrmo= "&nbsp;<img src='images/user_images/" . $tut . "' alt='" . $btit_settings["text_trum"] . "' title='" . $btit_settings["text_trum"] . "' />";

if ($CURUSER["vimu"] == 'yes')
$uvimu= "&nbsp;<img src='images/user_images/" . $vi . "' alt='" . $btit_settings["text_vip"] . "' title='" . $btit_settings["text_vip"] . "' />";

if ($CURUSER["vimo"] == 'yes')
$uvimo= "&nbsp;<img src='images/user_images/" . $vip . "' alt='" . $btit_settings["text_vipm"] . "' title='" . $btit_settings["text_vipm"] . "' />";

if ($CURUSER["friend"] == 'yes')
$ufrie= "&nbsp;<img src='images/user_images/" . $fr . "' alt='" . $btit_settings["text_fri"] . "' title='" . $btit_settings["text_fri"] . "' />";

if ($CURUSER["junkie"] == 'yes')
$ujunk= "&nbsp;<img src='images/user_images/" . $ju . "' alt='" . $btit_settings["text_jun"] . "' title='" . $btit_settings["text_jun"] . "' />";

if ($CURUSER["staff"] == 'yes')
$ustaf= "&nbsp;<img src='images/user_images/" . $st . "' alt='" . $btit_settings["text_sta"] . "' title='" . $btit_settings["text_sta"] . "' />";

if ($CURUSER["sysop"] == 'yes')
$usys= "&nbsp;<img src='images/user_images/" . $sy . "' alt='" . $btit_settings["text_sys"] . "' title='" . $btit_settings["text_sys"] . "' />";
// user image

// gift
$xmasdayst= mktime(0,0,0,12,1,2015);
$xmasdayend= mktime(0,0,0,1,5,2016);
   $today = mktime(date("G"), date("i"), date("s"), date("m"),date("d"),date("Y"));
if ($CURUSER["gotgift"] == 'no' && $today >= $xmasdayst  && $today <= $xmasdayend) {
?> 
<td class='lista' style='text-align:center;;' align='center'><a href='index.php?page=gift&open=1'><img src='images/gift.png' alt='Xmas Gift' title='Xmas Gift' /></a></td>
<?php
}
// gift

// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

if ($setrep["rep_is_online"]== 'false')
{
//do nothing
}
else
{
if ($rowuser["reputation"] == 0)
{

$rep="<a href=index.php?page=reputationpage  > &nbsp; &nbsp; Reputation &nbsp;<img src='images/rep/reputation_balance.gif' border='0' alt='".$setrep["no_level"]."' title='".$setrep["no_level"]."' /></a>";
}
if ($rowuser["reputation"] >= 1 )
{
$rep="<a href=index.php?page=reputationpage  > &nbsp; &nbsp; Reputation &nbsp;<img src='images/rep/reputation_pos.gif' border='0' alt='".$setrep["good_level"]."' title='".$setrep["good_level"]."' /></a>";
}
if ($rowuser["reputation"] <= -1)
{
$rep="<a href=index.php?page=reputationpage  > &nbsp; &nbsp; Reputation &nbsp;<img src='images/rep/reputation_neg.gif'border='0' alt='".$setrep["bad_level"]."' title='".$setrep["bad_level"]."' /></a>";
}
if ($rowuser["reputation"] >= 101 )
{
$rep="<a href=index.php?page=reputationpage  > &nbsp; &nbsp; Reputation &nbsp;<img src='images/rep/reputation_highpos.gif' border='0' alt='".$setrep["best_level"]."' title='".$setrep["best_level"]."' /></a>";
}
if ($rowuser["reputation"] <= -101)
{
$rep="<a href=index.php?page=reputationpage  > &nbsp; &nbsp; Reputation &nbsp;<img src='images/rep/reputation_highneg.gif'border='0' alt='".$setrep["worse_level"]."' title='".$setrep["worse_level"]."' /></a>";
}
}
// DT end reputation system

    print("<td class=\"blocklist\" align=\"center\" style=\"text-align:left;\">".$language["WELCOME_BACK"]."<a href='index.php?page=userdetails&id=".$CURUSER["uid"]."'> " . user_with_color($CURUSER["username"],$CURUSER["prefixcolor"],$CURUSER["suffixcolor"]) . get_user_icons($CURUSER) . warn($CURUSER). $rra .$upr.$udo.$udob.$ubir.$umal.$ufem.$uban.$uwar.$upar.$ubot.$utrmu.$utrmo.$uvimu.$uvimo.$ufrie.$ujunk.$ustaf.$usys." </a> \n");
    
    if ($CURUSER["announce"]=="yes")
   print("<td class=\"blocklist\" align=\"left\" style=\"text-align:left;\"><a href=\"index.php?page=announcement&amp;uid=".$CURUSER["uid"]."\"><img src=\"images/ann.png\"></a></td>\n");
    
        print("<td class=\"blocklist\" align=\"left\" style=\"text-align:left;\">".$rep." \n");

    print("<td class=\"blocklist\" align=\"left\" style=\"text-align:left;\">".$col."<font color='$freec'>$till".ucfirst($post)."</font> $pic</td>\n");
        print("<td class=\"blocklist\" align=\"left\" style=\"text-align:center;\"><a class=\"mainmenu\" href=\"logout.php\"><img src=\"images/logout.png \" /></a></td>\n");
    
?></tr>
</table>
<?php
if (!$CURUSER || $CURUSER["view_torrents"]=="no")
   {
    // do nothing
   }
else
    {
   if ($XBTT_USE)
      $res=get_result("select count(*) as tot, sum(f.seeds)+sum(ifnull(x.seeders,0)) as seeds, sum(f.leechers)+sum(ifnull(x.leechers,0)) as leechs  FROM {$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON f.bin_hash=x.info_hash",true,$btit_settings['cache_duration']);
   else
       $res=get_result("select count(*) as tot, sum(seeds) as seeds, sum(leechers) as leechs  FROM {$TABLE_PREFIX}files",true,$btit_settings['cache_duration']);
   if ($res)
      {
      $row=$res[0];
      $torrents=$row["tot"];
      $seeds=0+$row["seeds"];
      $leechers=0+$row["leechs"];
      }
   else {
      $seeds=0;
      $leechers=0;
      $torrents=0;
      }

   $res=get_result("select count(*) as tot FROM {$TABLE_PREFIX}users where id>1",true,$btit_settings['cache_duration']);
   if ($res)
      {
      $row=$res[0];
      $users=$row["tot"];
      }
   else
       $users=0;

   if ($leechers>0)
      $percent=number_format(($seeds/$leechers)*100,0);
   else
       $percent=number_format($seeds*100,0);

   $peers=$seeds+$leechers;

   if ($XBTT_USE)
      $res=get_result("select sum(u.downloaded+x.downloaded) as dled, sum(u.uploaded+x.uploaded) as upld FROM {$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id",true,$btit_settings['cache_duration']);
   else
      $res=get_result("select sum(downloaded) as dled, sum(uploaded) as upld FROM {$TABLE_PREFIX}users",true,$btit_settings['cache_duration']);
   $row=$res[0];
   $dled=0+$row["dled"];
   $upld=0+$row["upld"];
   $traffic=makesize($dled+$upld);
   
?>
<table class="tool" cellpadding="2" cellspacing="0" width="100%">
<tr><br>
<td  style="text-align:center;" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td  style="text-align:center;" align="center"><font color = steelblue><?php echo $language["BLOCK_INFO"]; ?>:</font></td>
<td class="lista" style="text-align:center;" align="center"><?php echo $language["MEMBERS"]; ?>:</td><td style="text-align:center;" align="right"><?php echo $users; ?></td>
<td class="lista" style="text-align:center;" align="center"><?php echo $language["TORRENTS"]; ?>:</td><td style="text-align:center;" align="right"><?php echo $torrents; ?></td>
<td class="lista" style="text-align:center;" align="center"><?php echo $language["SEEDERS"]; ?>:</td><td style="text-align:center;" align="right"><?php echo $seeds; ?></td>
<td class="lista" style="text-align:center;" align="center"><?php echo $language["LEECHERS"]; ?>:</td><td style="text-align:center;" align="right"><?php echo $leechers; ?></td>
<td class="lista" style="text-align:center;" align="center"><?php echo $language["PEERS"]; ?>:</td><td style="text-align:center;" align="right"><?php echo $peers; ?></td>
<td class="lista" style="text-align:center;" align="center"><?php echo $language["SEEDERS"]."/".$language["LEECHERS"]; ?>:</td><td style="text-align:center;" align="right"><?php echo $percent."%"; ?></td>
<td class="lista" style="text-align:center;" align="center"><?php echo $language["TRAFFIC"]; ?>:</td><td style="text-align:center;" align="right"><?php echo $traffic; ?></td>
<?php
    if ($CURUSER["admin_access"]=="yes")
    {
$bugs = mysqli_fetch_row(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) FROM {$TABLE_PREFIX}bugs WHERE status = 'na'")); 

if  ($bugs[0]=="0")
$htmlout .='';
else{
$htmlout .= "<td class=lista style=text-align:center; align=center><table border='0' cellspacing='0' cellpadding='2' bgcolor='#FF0000'>                                 
<tr><td style='padding: 2px; background: #FF0000'>\n                                 
<b><a href='index.php?page=modules&amp;module=bugs&action=bugs'><font color='#FFFFFF'>". ($bugs[0]) ." Bug" . ($bugs[0] > 1 ? "s" : "")."!</font></a></b>                                 
</td></tr></table><br/>\n"; 
}
print $htmlout; 
?></td>
<?php
}
if($btit_settings["srss"]==true)
{
?>
<td  align="right" style="text-align:center;"><a href=index.php?page=modules&amp;module=getrss  ><img src=images/rss.png ></a></td>
<?php
}
?>
</tr></table>
<?php
} // end if user can view
?>