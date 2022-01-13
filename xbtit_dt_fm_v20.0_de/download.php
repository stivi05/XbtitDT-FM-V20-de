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

$THIS_BASEPATH=dirname(__FILE__);

require_once("$THIS_BASEPATH/include/functions.php");
require_once ("$THIS_BASEPATH/include/BDecode.php");
require_once ("$THIS_BASEPATH/include/BEncode.php");

dbconn();

$rsspid = $_GET["rsspid"];
if (!empty($rsspid))
{
$rssdl=="yes";

if ($rsspid) {
        $user = mysqli_fetch_row(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) FROM {$TABLE_PREFIX}users WHERE pid = '$rsspid'"));
        if ($user[0] != 1)
            exit();
    } else
       {
   header(ERR_500);
   die;
}
}
else
$rssdl=="no";

if (!$CURUSER || $CURUSER["can_download"]=="no" && rssdl=="no" )
   {
       require(load_language("lang_main.php"));
       die($language["NOT_AUTH_DOWNLOAD"]);
   }

$allowdownload_stats = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT allowdownload FROM {$TABLE_PREFIX}users WHERE id = ".$CURUSER[uid]."");
$allowdownload_stat = mysqli_fetch_array($allowdownload_stats);
if ($allowdownload_stat[allowdownload] == "no")
{
       require(load_language("lang_main.php"));
       die($language["NOT_AUTH_DOWNLOAD"]);
}
if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression','Off');

$infohash=mysqli_real_escape_string($DBDT,$_GET["id"]);
$filepath=$TORRENTSDIR."/".$infohash . ".btf";

if (!is_file($filepath) || !is_readable($filepath))
   {

       require(load_language("lang_main.php"));
       die($language["CANT_FIND_TORRENT"]);
    }

$f=urldecode($_GET["f"]);
//vip start
global $btit_settings;

$resvp = do_sqlquery("SELECT vip_torrent FROM {$TABLE_PREFIX}files WHERE info_hash='$infohash'");
$rowvp=mysqli_fetch_assoc($resvp);

if ($btit_settings["vip_one"]==false)
{
if (($rowvp["vip_torrent"]==1) AND ($CURUSER["id_level"] < $btit_settings["vip_get"] ))
{
    stderr("Sorry","<br><br><br><center><body bgcolor=black text=white alink=orange vlink=red link=orangered><img src=images/denied.gif><br>".$btit_settings["vip_tekst"]."<br><br><a href=index.php?page=torrent-details&id=$_GET[id]>Go Back</a></body>");
    stdfoot(($GLOBALS["usepopup"]?false:true));
    die();
}
}
if ($btit_settings["vip_one"]==true)
{
if (($rowvp["vip_torrent"]==1) AND ($CURUSER["id_level"] != $btit_settings["vip_get_one"] ))
{
     stderr("Sorry","<br><br><br><center><body bgcolor=black text=white alink=orange vlink=red link=orangered><img src=images/denied.gif><br>".$btit_settings["vip_tekst"]."<br><br><a href=index.php?page=torrent-details&id=$_GET[id]>Go Back</a></body>");
    stdfoot(($GLOBALS["usepopup"]?false:true));
    die();
}
}
//vip end

//last up/down DT
$userid= $CURUSER["uid"];
do_sqlquery("INSERT into {$TABLE_PREFIX}downloads (uid, info_hash, date, updown) VALUES ('$userid','$infohash', NOW() , 'down')",true);
//last up/down DT end

//dt grabbed
    $res_user=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT pid FROM {$TABLE_PREFIX}users WHERE id='".$CURUSER["uid"]."'")or sqlerr();
    $row_user=mysqli_fetch_array($res_user);
    $pid=$row_user["pid"];
    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}down_load (pid, hash, time) VALUES( '$pid', '$infohash', NOW() )") or sqlerr();
//dt grabbed

// comment & thank
if ($btit_settings["thco"]==true)
{
$thismember=$CURUSER["username"];
$res = do_sqlquery("SELECT uploader FROM {$TABLE_PREFIX}files WHERE info_hash='$infohash'");
if(mysqli_num_rows($res)==1)
    $row=mysqli_fetch_assoc($res);
    
$comments = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}comments WHERE info_hash = '$infohash' AND user = '$thismember'");
$merci = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}files_thanks WHERE infohash = '$infohash' AND userid = '$userid'");

if (mysqli_num_rows($merci)== 0 AND mysqli_num_rows($comments)== 0 AND $row["uploader"]!==$userid) 
{
    stderr("Sorry","<br><br><br><center><body bgcolor=black text=white alink=orange vlink=red link=orangered><img src=images/denied.gif><br>You have to hit the Thanks button or leave a comment<br> before you can get access to the download link....<br>Just a reminder to say thank you to the uploader.<br><br><a href=index.php?page=torrent-details&id=$_GET[id]>Go Back</a></body>");
    stdfoot(($GLOBALS["usepopup"]?false:true));
    die();
}
}
// comment & thank

// pid code begin
if (empty($rsspid))
{
$row =get_result("SELECT pid FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER['uid'],true,$btit_settings['cache_duration']);
$pid=$row[0]["pid"];
}
else
$pid=$rsspid;
if (!$pid)
   {
   $pid=md5(uniqid(rand(),true));
   do_sqlquery("UPDATE {$TABLE_PREFIX}users SET pid='".$pid."' WHERE id='".$CURUSER['uid']."'");
   if ($XBTT_USE)
      do_sqlquery("UPDATE xbt_users SET torrent_pass='".$pid."' WHERE uid='".$CURUSER['uid']."'");
}

$result=get_result("SELECT *,team FROM {$TABLE_PREFIX}files WHERE info_hash='".$infohash."'",true,$btit_settings['cache_duration']);
$row = $result[0];

if (($CURUSER['team'] != $row['team']) AND ($CURUSER['id_level'] < 7) AND ($row['team'] != 0))
redirect("index.php?page=torrents");

if ($XBTT_USE)
$rescat = get_result("SELECT u.id, (u.downloaded+IFNULL(x.downloaded,0)) as downloaded, ((u.uploaded+IFNULL(x.uploaded,0))/(u.downloaded+IFNULL(x.downloaded,0))) as uratio, cp.* FROM {$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid AND ".$row["category"]."=cp.catid WHERE u.id = ".$CURUSER["uid"]." LIMIT 1;",true);
else
$rescat = get_result("SELECT u.id, u.downloaded, (u.uploaded/u.downloaded) as uratio, cp.* FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid AND ".$row["category"]."=cp.catid WHERE u.id = ".$CURUSER["uid"]." LIMIT 1;",true);
$rowcat=$rescat[0];
if($rowcat["downtorr"]!="yes" && (($rowcat["downloaded"]>=$GLOBALS["download_ratio"] && ($rowcat["ratio"]>$rowcat["uratio"]))||($rowcat["downloaded"]<$GLOBALS["download_ratio"])||($rowcat["ratio"]=="0")))
{
    require(load_language("lang_main.php"));
    die($language["NOT_ACCESS_TO_DOWNLOADS"]);
}

if ($row["external"]=="yes" || !$PRIVATE_ANNOUNCE)
   {
    $fd = fopen($filepath, "rb");
    $alltorrent = fread($fd, filesize($filepath));
    fclose($fd);
    header("Content-Type: application/x-bittorrent");
    $f = str_replace('%20',' ',$f);
    $f = str_replace('%26','&',$f);
    $f = str_replace('%27','',$f);
    $f = str_replace('%28','(',$f);
    $f = str_replace('%29',')',$f);
    $f = str_replace('%5B','[',$f);
    $f = str_replace('%5D',']',$f);
    $f = str_replace('%7B','{',$f);
    $f = str_replace('%7D','}',$f);
    $f = str_replace('%7C','|',$f);
    $f = str_replace('%40','@',$f);
    header('Content-Disposition: attachment; filename="'.$f.'"');
    print($alltorrent);
   }
else
    {
    $fd = fopen($filepath, "rb");
    $alltorrent = fread($fd, filesize($filepath));
    $array = BDecode($alltorrent);
    fclose($fd);

// client comment    
global $btit_settings;
if ($btit_settings["cl_on"] == 'true')
{
$array["comment"]=$btit_settings["cl_te"];
}
// client comment  
    if ($XBTT_USE)
       $array["announce"] = $XBTT_URL."/$pid/announce";
    else
       $array["announce"] = $BASEURL."/announce.php?pid=$pid";

    if (isset($array["announce-list"]) && is_array($array["announce-list"]))
       {
       for ($i=0;$i<count($array["announce-list"]);$i++)
           {
           for ($j=0;$j<count($array["announce-list"][$i]);$j++)
               {
               if (in_array($array["announce-list"][$i][$j],$TRACKER_ANNOUNCEURLS))
                  {
                  if (strpos($array["announce-list"][$i][$j],"announce.php")===false)
                     $array["announce-list"][$i][$j] = trim(str_replace("/announce", "/$pid/announce", $array["announce-list"][$i][$j]));
                  else
                     $array["announce-list"][$i][$j] = trim(str_replace("/announce.php", "/announce.php?pid=$pid", $array["announce-list"][$i][$j]));
                }
             }
         }
     }


    $alltorrent=BEncode($array);

    header("Content-Type: application/x-bittorrent");
    $f = str_replace('%20',' ',$f);
    $f = str_replace('%26','&',$f);
    $f = str_replace('%27','',$f);
    $f = str_replace('%28','(',$f);
    $f = str_replace('%29',')',$f);
    $f = str_replace('%5B','[',$f);
    $f = str_replace('%5D',']',$f);
    $f = str_replace('%7B','{',$f);
    $f = str_replace('%7D','}',$f);
    $f = str_replace('%7C','|',$f);
    $f = str_replace('%40','@',$f);
    header('Content-Disposition: attachment; filename="'.$f.'"');
    print($alltorrent);
    }
?>