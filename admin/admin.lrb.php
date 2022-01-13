<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Xbtiteam
//
//    This file is part of xbtit DT fM.
//
// Low Ratio and Ban System hack by DiemThuy - Juni 2010
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

// Delete low ratio ban rules
if($action =="delete")
{

	{
        $msg = $_GET["id"];
		@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}low_ratio_ban WHERE wb_rank=\"$msg\"");
	}
	redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=lrb");
	exit();
}

// insert low ratio/ban overall settings in the database
if($action == 'senda')
    {
        $DT0	=	$_POST["wb_sys"]?"true":"false";
        $DT11	=	$_POST['wb_text_one'];
        $DT12	=	$_POST['wb_text_two'];
        $DT13	=	$_POST['wb_text_fin'];

do_sqlquery("update `{$TABLE_PREFIX}low_ratio_ban_settings` SET `wb_sys`='".$DT0."', `wb_text_one`='".$DT11."', `wb_text_two`='".$DT12."' , `wb_text_fin`='".$DT13."' WHERE `id` =1") or sqlerr();
    
	redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=lrb");
	exit();
    }
    
// read low ratio/ban overall settings from the database
$rest=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}low_ratio_ban_settings ") or sqlerr();

$row3=mysqli_fetch_array($rest);
$admintpl->set("wb_button",$row3["wb_sys"]=="true"?"checked=\"checked\"":"");
$admintpl->set("lrb.wb_text_one",$row3['wb_text_one']);
$admintpl->set("lrb.wb_text_two",$row3['wb_text_two']);
$admintpl->set("lrb.wb_text_fin",$row3['wb_text_fin']);    

// insert low ratio/ban group rules in the database
if($action == 'sendb')
    {

        $DT1	=	$_POST["wb_down"];
        $DT2	=	$_POST["wb_rank"];
       	$DT3	=	$_POST['wb_warn']?"true":"false";
       	$DT4	=	$_POST['wb_one'];
        $DT5	=	$_POST['wb_days_one'];
       	$DT6	=	$_POST['wb_two'];
        $DT7	=	$_POST['wb_days_two'];
       	$DT8	=	$_POST['wb_three'];
       	$DT9	=	$_POST['wb_days_fin'];
        $DT10	=	$_POST['wb_fin'];

        $check=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}low_ratio_ban WHERE wb_rank='".$DT2."'") or sqlerr();
        $checkres=mysqli_num_rows($check);

if ($checkres>0) {


    stderr ("Error","You can,t add 2 rules for one group!");
    stdfoot();
    exit();
                 }

else {
       	
    do_sqlquery("insert `{$TABLE_PREFIX}low_ratio_ban` SET `wb_down`='".$DT1."',`wb_rank`='".$DT2."',`wb_warn`='".$DT3."',`wb_one`='".$DT4."',`wb_days_one`='".$DT5."',`wb_two`='".$DT6."',`wb_days_two`='".$DT7."',`wb_three`='".$DT8."', `wb_days_fin`='".$DT9."', `wb_fin`='".$DT10."' ") or sqlerr();
    
    redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=lrb");
	exit();
     }

}
//Here we will select the data from the table low ratio ban
    $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT  ul.id, ul.level,ul.prefixcolor,ul.suffixcolor, ar.wb_down, ar.wb_rank, ar.wb_warn, ar.wb_one, ar.wb_days_one, ar.wb_two, ar.wb_days_two, ar.wb_three, ar.wb_days_fin, ar.wb_fin FROM {$TABLE_PREFIX}low_ratio_ban ar INNER JOIN {$TABLE_PREFIX}users_level ul ON ar.wb_rank=ul.id ORDER BY ar.wb_rank ASC") or sqlerr();

    $hit=array();
    $i=0;

while($row1=mysqli_fetch_array($res))
{
 
   if ($row1['wb_warn']=='false')
 {$war='<font color = green><b>No</b></font>';}
 else
 {$war='<font color = red><b>Yes</b></font>';}

    $hit[$i]["wb_rank"]=("<center>$row1[wb_rank]</center>");
    $hit[$i]["wb_group"]=("<center><a href=\"index.php?page=users&level=".$row1[wb_rank]."\">".$row1[prefixcolor].$row1[level].$row1[suffixcolor]."</a></center>");
    $hit[$i]["min_download"]=("<center>$row1[wb_down] GB</center>");
    $hit[$i]["ratio_one"]=("<center>$row1[wb_one] </center>");
    $hit[$i]["days_one"]=("<center>$row1[wb_days_one]</center>");
    $hit[$i]["ratio_two"]=("<center>$row1[wb_two]</center>");
    $hit[$i]["days_two"]=("<center>$row1[wb_days_two]</center>");
    $hit[$i]["ratio_three"]=("<center>$row1[wb_three]</center>");
    $hit[$i]["days_three"]=("<center>$row1[wb_days_fin]</center>");
    $hit[$i]["ratio_fin"]=("<center>$row1[wb_fin]</center>");
    $hit[$i]["warn"]=("<center>$war</center>");
;
    $hit[$i]["delete"]="<center><a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=lrb&amp;action=delete&amp;id=".$row1[wb_rank]."\" onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</center></a>";
    $i++;

}
 
    $admintpl->set("frm_actiona", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=lrb&amp;action=senda");
    $admintpl->set("frm_actionb", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=lrb&amp;action=sendb");
    
    
	$admintpl->set("hit",$hit);
	
// Unwarn
if($action =="unwarn")
{

	{
        $uuw = $_GET["id"];
		@mysqli_query($GLOBALS["___mysqli_ston"], "update {$TABLE_PREFIX}users SET rat_warn_level ='0' WHERE id=\"$uuw\"");
	}
	redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=lrb");
	exit();
}

// Unban
if($action =="unban")
{

	{
        $uub = $_GET["id"];
		@mysqli_query($GLOBALS["___mysqli_ston"], "update {$TABLE_PREFIX}users SET bandt ='no' WHERE id=\"$uub\"");
	}
	redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=lrb");
	exit();
}	
	
// Warned & banned user list	
	
	          $r2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE rat_warn_level!=0 OR bandt='yes'" ) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
               $list=array();
               $ii=0;
               
if ($r2)
{
while ($arr=mysqli_fetch_assoc($r2))
{
 $res4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor , suffixcolor , level  FROM {$TABLE_PREFIX}users_level WHERE id ='$arr[id_level]'");
 $arr4 = mysqli_fetch_assoc($res4); 
 $name = $arr4[prefixcolor].$arr[username].$arr4[sufixcolor];
 
 if ($arr['bandt']=='no')
 {$ban='<font color = green><b>No</b></font>';}
 else
 {$ban='<font color = red><b>Yes</b></font>';}
 
  if ($arr['warn']=='no')
 {$wa='<font color = green><b>No</b></font>';}
 else
 {$wa='<font color = red><b>Yes</b></font>';}

 $list[$ii]["username"]="<a href=index.php?page=userdetails&id=" . $arr["id"] . ">" . $name . "</a>";
 $list[$ii]["group"]=$arr4['level'];
 $list[$ii]["warn"]=$arr['rat_warn_level'];
 $list[$ii]["date"]=$arr['rat_warn_time'];
 $list[$ii]["show"]=$wa;
 $list[$ii]["ban"]=$ban;
      $list[$ii]["unwarn"]="<center><a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=lrb&amp;action=unwarn&amp;id=".$arr[id]."\" onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\">".image_or_link("images/aranydt.png","",$language["DELETE"])."</center></a>";
     $list[$ii]["unban"]="<center><a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=lrb&amp;action=unban&amp;id=".$arr[id]."\" onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\">".image_or_link("images/aranydt.png","",$language["DELETE"])."</center></a>";
 $ii++;	
 }
}
	$admintpl->set("list",$list);
?>