<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam / freeleech hack by Diemthuy Jan 2009
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
      
      global $XBTT_USE;
      
      $action = $_GET['action'];
      $returnto = "index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=free";

if($action == 'send')
{

	$expire_date = $_POST['expire_date'];
	$expire_time = $_POST['expire_time'];
	$DT1	= 	$expire_date." ".$expire_time.":00:00";
    $DT2	=	$_POST["free"]?"yes":"no";
    $DT3    =   $_POST["happy"]?"yes":"no";
    $categoria = intval(0+$_POST["category"]);
    
    

    
if ($categoria==0)
{
    $DT5="";
    $categoria="";
    }
    else
    $DT5="`category`='".$categoria."' AND";    


	do_sqlquery("UPDATE `{$TABLE_PREFIX}files` SET `free_expire_date`='".$DT1."',`free`='".$DT2."',`happy_hour`='".$DT3."' ,`catid`='".$categoria."' WHERE ".$DT5." `external`='no'  ", true);
    do_sqlquery("ALTER TABLE `{$TABLE_PREFIX}files` CHANGE `free` `free` ENUM( 'yes', 'no' ) NULL DEFAULT '".$DT2."'") or sqlerr();
    
     $DTxbtt    =   $_POST["free"]?"0":"100";
    // xbtt
    if ($XBTT_USE)
      {
      do_sqlquery("UPDATE xbt_files SET down_multi=$DTxbtt");
      do_sqlquery("ALTER TABLE xbt_files CHANGE `down_multi` `down_multi` INT NULL DEFAULT '$DTxbtt'",true);
    }

 header("Location: $BASEURL/$returnto");
}
else
{


	$query = do_sqlquery("SELECT * FROM `{$TABLE_PREFIX}files` WHERE `external`='no'", true);
	$row = mysqli_fetch_array($query);
	
$category = (!isset($_GET["category"])?0:explode(";",$_GET["category"]));

      if (is_array($category))
          $category = array_map("intval",$category);
      else
          $category = 0;

      $combo_categories=categories( $category[0] );
	

        $admintpl->set("language",$language);
       	$admintpl->set("expire_date", substr($row["free_expire_date"], 0 , -9));
	    $admintpl->set("expire_time", substr($row["free_expire_date"], -8, -6));
	    $admintpl->set("frm_action", "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=free&amp;action=send");
	    $admintpl->set("free_checked", ($row["free"]=="yes"?"checked=\"checked\"":""));
	    $admintpl->set("happy_checked", ($row["happy_hour"]=="yes"?"checked=\"checked\"":""));
	    
	    if($row["catid"]==0 or $row["catid"]=="")
	    $admintpl->set("cat", $combo_categories );
	    else
	    $admintpl->set("cat", categories($row["catid"]));

}
?>