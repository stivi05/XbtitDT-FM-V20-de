<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// BTI version created by Gando , converted to XBTIT-2 by DiemThuy - Nov 2008
// updated to be used with XBT and XML updated - march 2009
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

      if ($CURUSER["id_level"]==1)
{
		redirect("index.php?page=torrents"); // redirects to torrents.php if guest
	exit();
}

if ($XBTT_USE)
   {
    $tseeds="f.seeds+ifnull(x.seeders,0)";
    $tleechs="f.leechers+ifnull(x.leechers,0)";
    $tcompletes="f.finished+ifnull(x.completed,0)";
    $ttables="{$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON x.info_hash=f.bin_hash";
   }
else
    {
    $tseeds="f.seeds";
    $tleechs="f.leechers";
    $tcompletes="f.finished";
    $ttables="{$TABLE_PREFIX}files f";
    }
    
$bookmarktpl= new bTemplate();
$bookmarktpl-> set("language",$language);
require_once("include/functions.php");

dbconn();

$do = $_GET["do"];
$torrent_id = $_GET["torrent_id"];

// bookmark torrents

if ($do=="add"){
if (!isset($torrent_id)){
redirect("index.php?page=torrents"); // redirects to torrents.php if torrent_id not set
exit();
}

block_begin("Added to bookmark list");
$hmm=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}wishlist WHERE torrent_id = '$torrent_id' AND user_id = ".$CURUSER['uid']);
if (mysqli_num_rows($hmm)){
    err_msg("Error!","Torrent Already Exists!");
    print_version();

    die;
}
$sql = "SELECT * FROM {$TABLE_PREFIX}files WHERE info_hash = '$torrent_id'";
$qry = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
$res = mysqli_fetch_array($qry);
$chk = mysqli_num_rows($qry);
if (!$chk){
redirect("index.php?page=torrents"); // redirects to torrents.php if torrent_id not in database
exit();
}
mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}wishlist (user_id, torrent_id, torrent_name, added) VALUES ('".$CURUSER["uid"]."', '".$_GET["torrent_id"]."', '".$res["filename"]."', NOW())");
    redirect("index.php?page=bookmark");
	exit();
}

// Delete torrent from bookmark list
elseif ($do=="del")
{

	{
        $msg = $_GET["id"];
		@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}wishlist WHERE id=\"$msg\"");
	}
	redirect("index.php?page=bookmark");
	exit();
}

// Main bookmark page

else{

$qry=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}wishlist WHERE user_id = ".$CURUSER['uid']);
$coun=mysqli_num_rows($qry);

if (!$coun)

   $wish=array();
   $i=0;
while ($res=mysqli_fetch_array($qry)) {
  $tor=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT f.info_hash, f.filename, f.size, $tseeds as seeds, $tleechs as leechers, $tcompletes as finished, f.speed, f.external, c.image, c.id as catid, c.name as cname FROM $ttables LEFT JOIN {$TABLE_PREFIX}categories c ON f.category=c.id WHERE f.info_hash = '".$res['torrent_id']."'");
  $ret=mysqli_fetch_array($tor);
  $num=mysqli_num_rows($tor);
if (!$num){ // torrent doesnt exist in database

$category="n/a";
$filename=$res['torrent_name'];
$download="n/a";
$size="n/a";
$seeds="n/a";
$leechers="n/a";
$completes="n/a";
$speed="n/a";
}
else{ // torrent exists in database

$category="<a href=index.php?page=torrents&category=".$ret['catid'].">".image_or_link(($ret['image']==""?"":"style/xbtit_default/images/categories/" . $ret["image"]),"",$ret["cname"])."</td>";
$filename="<a href=index.php?page=details&id=".$ret['info_hash']."&returnto=bookmark.php>".$ret['filename']."</a>";
$download="<a href=download.php?id=".$ret["info_hash"]."&f=" . rawurlencode(html_entity_decode($ret["filename"])) . ".torrent>".image_or_link("images/download.gif","","torrent")."</a>";
$size=makesize($ret['size']);
$seeds="<a href=index.php?page=peers&id=".$ret["info_hash"]."&returnto=index.php?page=bookmark\" title=\"".PEERS_DETAILS."\"><font color=green>" .$ret["seeds"] . "</font></a></td>";
$leechers="<a href=index.php?page=peers&id=".$ret["info_hash"]."&returnto=index.php?page=bookmark\" title=\"".PEERS_DETAILS."\"><font color=red>" .$ret["leechers"] . "</font></a></td>";
$completes="<a href=index.php?page=torrent_history&id=".$ret['info_hash']."><font color=purple>".$ret['finished']."</font></a>";
if ($ret["speed"] < 0 || $ret["external"]=="yes")
$speed = "n/a";
else if ($ret["speed"] > 2097152)
$speed = round($data["speed"]/1048576,2) . " MB/sec";
else
$speed = round($ret["speed"] / 1024, 2) . " KB/sec";

  // progress
  if ($data["external"]=="yes")
     $prgsf=$language["NA"];
  else {
       $id = $ret["info_hash"];

       $subres = do_sqlquery("SELECT sum(IFNULL(bytes,0)) as to_go, count(*) as numpeers FROM {$TABLE_PREFIX}peers where infohash='$id'" ) or ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
       $subres2 = do_sqlquery("SELECT size FROM {$TABLE_PREFIX}files WHERE info_hash ='$id'") or ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
       $torrent = mysqli_fetch_array($subres2);
       $subrow = mysqli_fetch_array($subres);
       $tmp=0+$subrow["numpeers"];
       if ($tmp>0) {
          $tsize=(0+$torrent["size"])*$tmp;
          $tbyte=0+$subrow["to_go"];
          $prgs=(($tsize-$tbyte)/$tsize) * 100; //100 * (1-($tbyte/$tsize));
          $prgsf=floor($prgs);
          }
       else
           $prgsf=0;
       $prgsf.="%";


  if ($prgsf <= 100)
     $prgpic="images/progbar-green.gif";
  if ($prgsf == 0)
    $bckgpic="images/progbar-black.gif";
  else
    $bckgpic="images/progbar-red.gif";

	 $progressbar="<table border=0 width=44 cellspacing=0 cellpadding=0><tr><td align=right border=0 width=2><img src=\"images/bar_left.gif\">";
	 $progressbar.="<td align=left border=0 background=\"$bckgpic\" width=40><img height=9 width=".(number_format($prgsf,0)/2.5)." src=\"$prgpic\"></td><td align=right border=0 width=2><img src=\"images/bar_right.gif\"></td></tr></table>";

}


}
       $wish[$i]["id"]=$res["id"];
       $wish[$i]["category"]=("<center>$category</center>");
       $wish[$i]["file"]=("<center>$filename</center>");
       $wish[$i]["down"]=("<center>$download</center>");
       $wish[$i]["size"]=("<center>$size</center>");
       $wish[$i]["seed"]=("<center>$seeds</center>");
       $wish[$i]["leech"]=("<center>$leechers</center>");
       $wish[$i]["completed"]=("<center>$completes</center>");
       $wish[$i]["speed"]=("<center>$speed</center>");
       $wish[$i]["added"]=("<center>$res[added]</center>");
       $wish[$i]["average"]="<center>".$prgsf."<br />".$progressbar."</center>";
       $wish[$i]["delete"]=("<center><a href=\"index.php?page=bookmark&do=del&amp;id=".$wish[$i]["id"]."\" onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a></center>");
       $i++;
}
}
	$bookmarktpl->set("wish",$wish);
?>