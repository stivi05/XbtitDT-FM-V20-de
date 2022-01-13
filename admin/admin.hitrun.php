<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Hit and Run - FM hack by DiemThuy - april 2009
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

         $action = $_GET['action'];

// Delete hit&run rules
if($action =="delete")
{

	{
        $msg = $_GET["id"];
		@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}anti_hit_run WHERE id_level=\"$msg\"");
	}
	redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=hitrun");
	exit();
}
// insert hit & run rules in the database
if($action == 'send')
    {
        $DT0	=	$_POST["warn"]?"yes":"no";
        $DT01	=	$_POST["boot"]?"yes":"no";
        $DT1	=	$_POST["reward"]?"yes":"no";
       	$DT2	=	$_POST['min_download_size'];
       	$DT23	=	$_POST['days1'];
        $DT3	=	$_POST['min_ratio'];
       	$DT34	=	$_POST['days2'];
        $DT4	=	$_POST['min_seed_hours'];
       	$DT5	=	$_POST['tolerance_days'];
       	$DT6	=	$_POST['upload_punishment'];
        $DT7	=	$_POST['id_level'];
        $DT8	=	$_POST['warnboot'];
        $DT88	=	$_POST['days3'];
        
        $check=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}anti_hit_run WHERE id_level='".$DT7."'") or sqlerr();
        $checkres=mysqli_num_rows($check);

if ($checkres>0) {


    stderr ("Error","You can,t add 2 rules for one group!");
    stdfoot();
    exit();
                 }

else {
       	
    do_sqlquery("insert `{$TABLE_PREFIX}anti_hit_run` SET `warnboot`='".$DT8."',`days3`='".$DT88."',`days2`='".$DT34."',`days1`='".$DT23."',`boot`='".$DT01."',`warn`='".$DT0."',`reward`='".$DT1."', `min_download_size`='".$DT2."', `min_ratio`='".$DT3."' , `min_seed_hours`='".$DT4."', `tolerance_days_before_punishment`='".$DT5."' , `upload_punishment`='".$DT6."' , `id_level`='".$DT7."' ") or sqlerr();
    redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=hitrun");
	exit();
     }

}

{
//Here we will select the data from the table hit and run
    $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT ar.id_level, ul.id, ul.level,ul.prefixcolor,ul.suffixcolor, ar.min_download_size, ar.min_ratio, ar.min_seed_hours, ar.tolerance_days_before_punishment, ar.upload_punishment, ar.reward, ar.warn, ar.boot, ar.days1, ar.days2 , ar.days3 , ar.warnboot FROM {$TABLE_PREFIX}anti_hit_run ar INNER JOIN {$TABLE_PREFIX}users_level ul ON ar.id_level=ul.id ORDER BY ar.id_level ASC") or sqlerr();
    $hit=array();
    $i=0;

{
while($row1=mysqli_fetch_array($res))
{

    $hit[$i]["id_level2"]=("<center>$row1[id_level]</center>");
    $hit[$i]["user_level2"]=("<center><a href=\"index.php?page=users&level=".$row1[id_level]."\">".$row1[prefixcolor].$row1[level].$row1[suffixcolor]."</a></center>");
    $hit[$i]["min_download_size2"]=("<center>$row1[min_download_size]</center>");
    $hit[$i]["min_ratio2"]=("<center>$row1[min_ratio]</center>");
    $hit[$i]["min_seed_hours2"]=("<center>$row1[min_seed_hours]</center>");
    $hit[$i]["tolerance_days2"]=("<center>$row1[tolerance_days_before_punishment]</center>");
    $hit[$i]["upload_punishment2"]=("<center>$row1[upload_punishment]</center>");
    $hit[$i]["reward2"]=("<center>$row1[reward]</center>");
    $hit[$i]["warn"]=("<center>$row1[warn]</center>");
    $hit[$i]["days1"]=("<center>$row1[days1]</center>");
    $hit[$i]["warnboot"]=("<center>$row1[warnboot]</center>");
    $hit[$i]["days3"]=("<center>$row1[days3]</center>");
    $hit[$i]["boot"]=("<center>$row1[boot]</center>");
    $hit[$i]["days2"]=("<center>$row1[days2]</center>");
    $hit[$i]["delete"]="<center><a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=hitrun&amp;action=delete&amp;id=".$row1[id_level]."\" onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</center></a>";
    $i++;

}
}
}


    $admintpl->set("language", $language);
    $admintpl->set("frm_action", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=hitrun&amp;action=send");
	$admintpl->set("hit",$hit);
	
	    // getting order
    if (isset($_GET["order"]))
         $order=htmlspecialchars(mysqli_real_escape_string($DBDT,$_GET["order"]));
    else
        $order="date";

    if (isset($_GET["by"]))
        $by=htmlspecialchars(mysqli_real_escape_string($DBDT,$_GET["by"]));
    else
        $by="DESC";
    if (isset($_GET["pages"]))
        $pages=htmlspecialchars(mysqli_real_escape_string($DBDT,$_GET["pages"]));
    else
        $pages="1";

$hittestres=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) FROM {$TABLE_PREFIX}history WHERE hit='yes' ORDER BY $order $by");

    $hitnum=mysqli_fetch_row($hittestres);
    $num=$hitnum[0];
    $perpage=(max(0,$CURUSER["postsperpage"])>0?$CURUSER["postsperpage"]:30);

    list($pagertop, $pagerbottom, $limit) = pager($perpage, $num, "index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=hitrun&amp;order=$order&amp;by=$by&amp;");

$admintpl->set("hr1","<TR><br>");
$admintpl->set("hr2","<table align=center width=85%>");
$admintpl->set("hr3","<br><div align=center>$pagertop</div>");
$admintpl->set("hr6","<td width=15% class=header align=center>Username</td>");
$admintpl->set("hr7","<td class=header  align=center><a href=\"index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=hitrun&amp;order=infohash&amp;by=".($order=="infohash" && $by=="DESC"?"ASC":"DESC")."&amp;pages=".$pages."\">Torrent</a></td>");
$admintpl->set("hr8","<td class=header  align=center><a href=\"index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=hitrun&amp;order=uploaded&amp;by=".($order=="uploaded" && $by=="DESC"?"ASC":"DESC")."&amp;pages=".$pages."\">Upload</a></td>");
$admintpl->set("hr9","<td class=header  align=center><a href=\"index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=hitrun&amp;order=downloaded&amp;by=".($order=="downloaded" && $by=="DESC"?"ASC":"DESC")."&amp;pages=".$pages."\">Download</a></td>");
$admintpl->set("hr10","<td class=header  align=center><a href=\"index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=hitrun&amp;order=active&amp;by=".($order=="active" && $by=="DESC"?"ASC":"DESC")."&amp;pages=".$pages."\">Active</a></td>");
$admintpl->set("hr11","<td class=header  align=center>Ratio</td>");
$admintpl->set("hr12","<td class=header  align=center><a href=\"index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=hitrun&amp;order=seed&amp;by=".($order=="seed" && $by=="DESC"?"ASC":"DESC")."&amp;pages=".$pages."\">Seedtime</a></td>");
$admintpl->set("hr13","<td class=header  align=center><a href=\"index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=hitrun&amp;order=date&amp;by=".($order=="date" && $by=="DESC"?"ASC":"DESC")."&amp;pages=".$pages."\">Date</a></td>");
$admintpl->set("hr134","<td class=header align=center>Ban User</td>");
$admintpl->set("hr14","</TR>");
$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT pid, infohash FROM {$TABLE_PREFIX}peers");

   if (mysqli_num_rows($res) > 0)
   {
       while ($arr = mysqli_fetch_assoc($res))
       {
	   $x=$arr['pid'];
	   $t=$arr['infohash'];
	   $pl=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}users WHERE pid='$x'");

  	      	   if(mysqli_num_rows($pl)>0)$ccc=mysqli_result($pl,0,"id");
               else $ccc="Unknown" ;
	  	}
   }
$r=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}history WHERE hit='yes' ORDER BY $order $by $limit");
      $hits=array();
      $ii=0;
while($x = mysqli_fetch_array($r)){
$t=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username , id_level FROM {$TABLE_PREFIX}users WHERE id=$x[uid]");



$t2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}history WHERE uid=$x[uid] and hit='yes' AND infohash='$x[infohash]'");
$t3=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filename FROM {$TABLE_PREFIX}files WHERE info_hash='$x[infohash]'");

$tb=mysqli_fetch_array($t);

$res4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor , suffixcolor  FROM {$TABLE_PREFIX}users_level WHERE id ='$tb[id_level]'");
$arr4 = mysqli_fetch_assoc($res4);
$name = $arr4[prefixcolor].$tb[username].$arr4[sufixcolor];

if(!$tb) {
$xc="Deleted User";
} else {
$xa=mysqli_result($t,0,"username");
$xc="<a href=index.php?page=userdetails&id=$x[uid]>$name</a>";
}
$tor=mysqli_result($t2,0,"infohash");
$tor2=mysqli_result($t3,0,"filename");
$up=mysqli_result($t2,0,"uploaded");
$up2=number_format(round($up / 1048576,2),2);
$down=mysqli_result($t2,0,"downloaded");
$down2=number_format(round($down / 1048576,2),2);
$seed=mysqli_result($t2,0,"seed");
$seed2=number_format(round($seed / 3600,1),1);
$ratio= number_format(round($up / $down,2),2);
$active=mysqli_result($t2,0,"active");
$datum=mysqli_result($t2,0,"date");

$hits[$ii]["hr16"]=("<tr>");
$hits[$ii]["hr17"]=("<td width=15% class=lista align=left>$xc</td>");
$hits[$ii]["hr18"]=("<td class=lista align=left><a href=index.php?page=details&id=$tor>$tor2</a></td>");
$hits[$ii]["hr19"]=("<td class=lista align=center><center>$up2 MB</center></td>");
$hits[$ii]["hr20"]=("<td class=lista align=center><center>$down2 MB</center></td>");
$hits[$ii]["hr21"]=("<td class=lista align=center><center>$active</center></td>");
$hits[$ii]["hr22"]=("<td class=lista align=center><center>$ratio</center></td>");
$hits[$ii]["hr23"]=("<td class=lista align=center><center>$seed2 h</center></td>");
include("include/offset.php");
$hits[$ii]["hr24"]=("<td class=lista align=center><center>".date("d/m/Y",$datum-$offset)."</center></td>");
$hits[$ii]["hr25"]=("<td class=lista align=center><center><a onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\" href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=users&amp;action=delete&amp;uid=".$x[uid]."&amp;smf_fid=".$x[uid]."&amp;returnto=".urlencode("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=hitrun")."\">".image_or_link("$STYLEPATH/images/booted.gif","",$language["DELETE"])."</a>");
$hits[$ii]["hr26"]=("</tr>");
$ii++;
{

$admintpl->set("hits",$hits);
}
}


$admintpl->set("hr27","<br></table");
$admintpl->set("hr28","<br><div align=center>$pagerbottom</div><br>");

?>