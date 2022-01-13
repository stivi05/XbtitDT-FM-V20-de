<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    User Images Hack by DiemThuy June 2010 - sponsored by Verifire / store added by Diemthuy Dec 2013
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

global $CURUSER , $btit_settings;


if (!defined("IN_BTIT"))
      die("non direct access!");

if (!$CURUSER || $CURUSER["view_users"]=="no")
   {
       err_msg($language["ERROR"],$language["NOT_AUTHORIZED"]." ".$language["MEMBERS"]."!");
       stdfoot();
       exit;
   }
else
    {

$user_imgtpl = new bTemplate();
$user_imgtpl->set("language",$language);

if ($btit_settings["uiswitch"]==TRUE)
{
$user_imgtpl->set("t1","<br><br>The shop option is enabled , you can buy images with your seedbonus points , you have <tag:sbu /> SB points ");
$user_imgtpl->set("t2","<td class=header align=center width=20%><center>Price (SB)</center></td>");
$user_imgtpl->set("t3","<td class=header align=center width=20%><center>Buy</center></td>");
}

$id=$CURUSER["uid"];
$name=$CURUSER["prefixcolor"].$CURUSER["username"].$CURUSER["suffixcolor"];

$user_imgtpl->set("sbu",number_format($CURUSER['seedbonus'],2));
$user_imgtpl->set("user",$name);

$resuser=do_sqlquery("SELECT u.dona,u.donb,u.birt,u.mal,u.fem,u.bann,u.war,u.par,u.bot,u.trmu,u.trmo,u.vimu,u.vimo,u.friend,u.junkie,u.staff ,u.sysop FROM {$TABLE_PREFIX}users u WHERE u.id=".$CURUSER["uid"]);
$row_user= mysqli_fetch_array($resuser);

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

if ($row_user["dona"] == 'yes')
$udo= "&nbsp;<img src='images/user_images/" . $do . "' alt='" . $btit_settings["text_don"] . "' title='" . $btit_settings["text_don"] . "' />";

if ($row_user["donb"] == 'yes')
$udob= "&nbsp;<img src='images/user_images/" . $don . "' alt='" . $btit_settings["text_donm"] . "' title='" . $btit_settings["text_donm"] . "' />";

if ($row_user["birt"] == 'yes')
$ubir= "&nbsp;<img src='images/user_images/" . $bi . "' alt='" . $btit_settings["text_bir"] . "' title='" . $btit_settings["text_bir"] . "' />";

if ($row_user["mal"] == 'yes')
$umal= "&nbsp;<img src='images/user_images/" . $ma . "' alt='" . $btit_settings["text_mal"] . "' title='" . $btit_settings["text_mal"] . "' />";

if ($row_user["bann"] == 'yes')
$uban= "&nbsp;<img src='images/user_images/" . $ba . "' alt='" . $btit_settings["text_ban"] . "' title='" . $btit_settings["text_ban"] . "' />";

if ($row_user["war"] == 'yes')
$uwar= "&nbsp;<img src='images/user_images/" . $wa . "' alt='" . $btit_settings["text_war"] . "' title='" . $btit_settings["text_war"] . "' />";

if ($row_user["fem"] == 'yes')
$ufem= "&nbsp;<img src='images/user_images/" . $fe . "' alt='" . $btit_settings["text_fem"] . "' title='" . $btit_settings["text_fem"] . "' />";

if ($row_user["par"] == 'yes')
$upar= "&nbsp;<img src='images/user_images/" . $pa . "' alt='" . $btit_settings["text_par"] . "' title='" . $btit_settings["text_par"] . "' />";

if ($row_user["bot"] == 'yes')
$ubot= "&nbsp;<img src='images/user_images/" . $bo . "' alt='" . $btit_settings["text_bot"] . "' title='" . $btit_settings["text_bot"] . "' />";

if ($row_user["trmu"] == 'yes')
$utrmu= "&nbsp;<img src='images/user_images/" . $tu . "' alt='" . $btit_settings["text_tru"] . "' title='" . $btit_settings["text_tru"] . "' />";

if ($row_user["trmo"] == 'yes')
$utrmo= "&nbsp;<img src='images/user_images/" . $tut . "' alt='" . $btit_settings["text_trum"] . "' title='" . $btit_settings["text_trum"] . "' />";

if ($row_user["vimu"] == 'yes')
$uvimu= "&nbsp;<img src='images/user_images/" . $vi . "' alt='" . $btit_settings["text_vip"] . "' title='" . $btit_settings["text_vip"] . "' />";

if ($row_user["vimo"] == 'yes')
$uvimo= "&nbsp;<img src='images/user_images/" . $vip . "' alt='" . $btit_settings["text_vipm"] . "' title='" . $btit_settings["text_vipm"] . "' />";

if ($row_user["friend"] == 'yes')
$ufrie= "&nbsp;<img src='images/user_images/" . $fr . "' alt='" . $btit_settings["text_fri"] . "' title='" . $btit_settings["text_fri"] . "' />";

if ($row_user["junkie"] == 'yes')
$ujunk= "&nbsp;<img src='images/user_images/" . $ju . "' alt='" . $btit_settings["text_jun"] . "' title='" . $btit_settings["text_jun"] . "' />";

if ($row_user["staff"] == 'yes')
$ustaf= "&nbsp;<img src='images/user_images/" . $st . "' alt='" . $btit_settings["text_sta"] . "' title='" . $btit_settings["text_sta"] . "' />";

if ($row_user["sysop"] == 'yes')
$usys= "&nbsp;<img src='images/user_images/" . $sy . "' alt='" . $btit_settings["text_sys"] . "' title='" . $btit_settings["text_sys"] . "' />";

if ($udo == ''AND $udob== ''AND $ubir== ''AND $umal== ''AND $ufem== ''AND $uban== ''AND $uwar== ''AND $upar== ''AND $ubot== ''AND $utrmu== ''AND $utrmo== ''AND $uvimu== ''AND $uvimo== ''AND $ufrie== ''AND $ujunk== ''AND $ustaf== ''AND $usys == '')
$user_imgtpl-> set("userimages","<font color = darkred><b>You have no user images yet</b></font>");
else
$user_imgtpl-> set("userimages",$udo.$udob.$ubir.$umal.$ufem.$uban.$uwar.$upar.$ubot.$utrmu.$utrmo.$uvimu.$uvimo.$ufrie.$ujunk.$ustaf.$usys);
 
$user_imgtpl->set("don1","<img src='images/user_images/" . $do . "' alt='" . $btit_settings["text_don"] . "' title='" . $btit_settings["text_don"] . "' />");
$user_imgtpl->set("don2",$btit_settings["text_don"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p1"]==TRUE)
{
$user_imgtpl->set("p1","<td class=lista align=center width=20%><center>".$btit_settings["preen"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["preen"])
$user_imgtpl->set("p2","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["preen"]."&img=1><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p2","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p1"]==FALSE)
{
$user_imgtpl->set("p1","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p2","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("don3","<img src='images/user_images/" . $don . "' alt='" . $btit_settings["text_donm"] . "' title='" . $btit_settings["text_donm"] . "' />");
$user_imgtpl->set("don4",$btit_settings["text_donm"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p2"]==TRUE)
{
$user_imgtpl->set("p3","<td class=lista align=center width=20%><center>".$btit_settings["prtwee"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["prtwee"])
$user_imgtpl->set("p4","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["prtwee"]."&img=2><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p4","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p2"]==FALSE)
{
$user_imgtpl->set("p3","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p4","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("bir1","<img src='images/user_images/" . $bi . "' alt='" . $btit_settings["text_bir"] . "' title='" . $btit_settings["text_bir"] . "' />");
$user_imgtpl->set("bir2",$btit_settings["text_bir"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p3"]==TRUE)
{
$user_imgtpl->set("p5","<td class=lista align=center width=20%><center>".$btit_settings["prdrie"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["prdrie"])
$user_imgtpl->set("p6","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["prdrie"]."&img=3><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p6","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p3"]==FALSE)
{
$user_imgtpl->set("p5","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p6","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("mal1","<img src='images/user_images/" . $ma . "' alt='" . $btit_settings["text_mal"] . "' title='" . $btit_settings["text_mal"] . "' />");
$user_imgtpl->set("mal2",$btit_settings["text_mal"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p4"]==TRUE)
{
$user_imgtpl->set("p7","<td class=lista align=center width=20%><center>".$btit_settings["prvier"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["prvier"])
$user_imgtpl->set("p8","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["prvier"]."&img=4><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p8","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p4"]==FALSE)
{
$user_imgtpl->set("p7","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p8","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("fem1","<img src='images/user_images/" . $fe . "' alt='" . $btit_settings["text_fem"] . "' title='" . $btit_settings["text_fem"] . "' />");
$user_imgtpl->set("fem2",$btit_settings["text_fem"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p5"]==TRUE)
{
$user_imgtpl->set("p9","<td class=lista align=center width=20%><center>".$btit_settings["prvijf"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["prvijf"])
$user_imgtpl->set("p10","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["prvijf"]."&img=5><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p10","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p5"]==FALSE)
{
$user_imgtpl->set("p9","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p10","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("ban1","<img src='images/user_images/" . $ba . "' alt='" . $btit_settings["text_ban"] . "' title='" . $btit_settings["text_ban"] . "' />");
$user_imgtpl->set("ban2",$btit_settings["text_ban"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p6"]==TRUE)
{
$user_imgtpl->set("p11","<td class=lista align=center width=20%><center>".$btit_settings["przes"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["przes"])
$user_imgtpl->set("p12","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["przes"]."&img=6><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p12","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p6"]==FALSE)
{
$user_imgtpl->set("p11","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p12","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("tru1","<img src='images/user_images/" . $tu . "' alt='" . $btit_settings["text_tru"] . "' title='" . $btit_settings["text_tru"] . "' />");
$user_imgtpl->set("tru2",$btit_settings["text_tru"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p7"]==TRUE)
{
$user_imgtpl->set("p13","<td class=lista align=center width=20%><center>".$btit_settings["przeven"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["przeven"])
$user_imgtpl->set("p14","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["przeven"]."&img=7><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p14","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p7"]==FALSE)
{
$user_imgtpl->set("p13","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p14","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("tru3","<img src='images/user_images/" . $tut . "' alt='" . $btit_settings["text_trum"] . "' title='" . $btit_settings["text_trum"] . "' />");
$user_imgtpl->set("tru4",$btit_settings["text_trum"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p8"]==TRUE)
{
$user_imgtpl->set("p15","<td class=lista align=center width=20%><center>".$btit_settings["pracht"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["pracht"])
$user_imgtpl->set("p16","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["pracht"]."&img=8><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p16","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p8"]==FALSE)
{
$user_imgtpl->set("p15","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p16","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("vip1","<img src='images/user_images/" . $vi . "' alt='" . $btit_settings["text_vip"] . "' title='" . $btit_settings["text_vip"] . "' />");
$user_imgtpl->set("vip2",$btit_settings["text_vip"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p9"]==TRUE)
{
$user_imgtpl->set("p17","<td class=lista align=center width=20%><center>".$btit_settings["prnegen"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["prnegen"])
$user_imgtpl->set("p18","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["prnegen"]."&img=9><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p18","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p9"]==FALSE)
{
$user_imgtpl->set("p17","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p18","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("vip3","<img src='images/user_images/" . $vip . "' alt='" . $btit_settings["text_vipm"] . "' title='" . $btit_settings["text_vipm"] . "' />");
$user_imgtpl->set("vip4",$btit_settings["text_vipm"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p10"]==TRUE)
{
$user_imgtpl->set("p19","<td class=lista align=center width=20%><center>".$btit_settings["prtien"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["prtien"])
$user_imgtpl->set("p20","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["prtien"]."&img=10><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p20","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p10"]==FALSE)
{
$user_imgtpl->set("p19","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p20","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("par1","<img src='images/user_images/" . $pa . "' alt='" . $btit_settings["text_par"] . "' title='" . $btit_settings["text_par"] . "' />");
$user_imgtpl->set("par2",$btit_settings["text_par"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p11"]==TRUE)
{
$user_imgtpl->set("p21","<td class=lista align=center width=20%><center>".$btit_settings["prelf"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["prelf"])
$user_imgtpl->set("p22","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["prelf"]."&img=11><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p22","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p11"]==FALSE)
{
$user_imgtpl->set("p21","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p22","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("war1","<img src='images/user_images/" . $wa . "' alt='" . $btit_settings["text_war"] . "' title='" . $btit_settings["text_war"] . "' />");
$user_imgtpl->set("war2",$btit_settings["text_war"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p12"]==TRUE)
{
$user_imgtpl->set("p23","<td class=lista align=center width=20%><center>".$btit_settings["prtwaalf"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["prtwaalf"])
$user_imgtpl->set("p24","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["prtwaalf"]."&img=12><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p24","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p12"]==FALSE)
{
$user_imgtpl->set("p23","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p24","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("bot1","<img src='images/user_images/" . $bo . "' alt='" . $btit_settings["text_bot"] . "' title='" . $btit_settings["text_bot"] . "' />");
$user_imgtpl->set("bot2",$btit_settings["text_bot"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p13"]==TRUE)
{
$user_imgtpl->set("p25","<td class=lista align=center width=20%><center>".$btit_settings["prdertien"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["prdertien"])
$user_imgtpl->set("p26","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["prdertien"]."&img=13><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p26","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p13"]==FALSE)
{
$user_imgtpl->set("p25","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p26","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("fri1","<img src='images/user_images/" . $fr . "' alt='" . $btit_settings["text_fri"] . "' title='" . $btit_settings["text_fri"] . "' />");
$user_imgtpl->set("fri2",$btit_settings["text_fri"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p14"]==TRUE)
{
$user_imgtpl->set("p27","<td class=lista align=center width=20%><center>".$btit_settings["prveertien"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["prveertien"])
$user_imgtpl->set("p28","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["prveertien"]."&img=14><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p28","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p14"]==FALSE)
{
$user_imgtpl->set("p27","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p28","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("jun1","<img src='images/user_images/" . $ju . "' alt='" . $btit_settings["text_jun"] . "' title='" . $btit_settings["text_jun"] . "' />");
$user_imgtpl->set("jun2",$btit_settings["text_jun"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p15"]==TRUE)
{
$user_imgtpl->set("p29","<td class=lista align=center width=20%><center>".$btit_settings["prvijftien"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["prvijftien"])
$user_imgtpl->set("p30","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["prvijftien"]."&img=15><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p30","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p15"]==FALSE)
{
$user_imgtpl->set("p29","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p30","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("sta1","<img src='images/user_images/" . $st . "' alt='" . $btit_settings["text_sta"] . "' title='" . $btit_settings["text_sta"] . "' />");
$user_imgtpl->set("sta2",$btit_settings["text_sta"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p16"]==TRUE)
{
$user_imgtpl->set("p31","<td class=lista align=center width=20%><center>".$btit_settings["przestien"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["przestien"])
$user_imgtpl->set("p32","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["przestien"]."&img=16><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p32","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p16"]==FALSE)
{
$user_imgtpl->set("p31","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p32","<td class=header align=center width=20%><center>Disabled</center></td>");
}

$user_imgtpl->set("sys1","<img src='images/user_images/" . $sy . "' alt='" . $btit_settings["text_sys"] . "' title='" . $btit_settings["text_sys"] . "' />");
$user_imgtpl->set("sys2",$btit_settings["text_sys"]);

if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p17"]==TRUE)
{
$user_imgtpl->set("p33","<td class=lista align=center width=20%><center>".$btit_settings["przeventien"]."</center></td>");
if($CURUSER['seedbonus']>=$btit_settings["przeventien"])
$user_imgtpl->set("p34","<td class=header align=center width=20%><center><form method=post action=index.php?page=ui_exchange&pr=".$btit_settings["przeventien"]."&img=17><input type=image src=images/buy.png  alt=buy  /></form></center></td>");
else
$user_imgtpl->set("p34","<td class=header align=center width=20%><center>To Less SB</center></td>");
}
if ($btit_settings["uiswitch"]==TRUE AND $btit_settings["p17"]==FALSE)
{
$user_imgtpl->set("p33","<td class=lista align=center width=20%><center>--</center></td>");
$user_imgtpl->set("p34","<td class=header align=center width=20%><center>Disabled</center></td>");
}
}
?>