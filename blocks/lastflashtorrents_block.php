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
if (!$CURUSER || $CURUSER["view_torrents"] == "no")
{
// do nothing
}
else
{
global $SITENAME,$btit_settings,$CURUSER,$XBTT_USE;

// new porn system
$dob=explode("-",$CURUSER["dob"]);
$age=userage($dob[0], $dob[1], $dob[2]);
if($CURUSER['showporn']=='no' or $age <= $btit_settings["porncat"]){
            $porn=do_sqlquery("SELECT id FROM {$TABLE_PREFIX}categories  WHERE porn='yes'",true);
            $iii=0;
            if ($porn)
                {
                while ($pornn=mysqli_fetch_assoc($porn))
                    {
                    $where .= " AND category != ".$pornn["id"];
                    $iii++;
                     }
				}
}
// new porn system end
    
if ($btit_settings["lastsw"]==false)
{
 
if ($XBTT_USE)
    $rowcat = do_sqlquery("SELECT u.id, (u.downloaded+IFNULL(x.downloaded,0)) as downloaded, ((u.uploaded+IFNULL(x.uploaded,0))/(u.downloaded+IFNULL(x.downloaded,0))) as uratio, cp.* FROM {$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  else
    $rowcat = do_sqlquery("SELECT u.id, u.downloaded, (u.uploaded/u.downloaded) as uratio, cp.* FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  if (mysqli_num_rows($rowcat)>0)
     while ($catdata=mysqli_fetch_array($rowcat))
             if($catdata["viewtorrlist"]!="yes" && (($catdata["downloaded"]>=$GLOBALS["download_ratio"] && ($catdata["ratio"]>$catdata["uratio"]))||($catdata["downloaded"]<$GLOBALS["download_ratio"])||($catdata["ratio"]=="0")))
                $exclude.=' AND f.category!='.$catdata[catid];
                
 if ($btit_settings["imdbbl"]==true )
$res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}files WHERE imdb !='' $where AND moder = 'ok' $exclude AND (".$CURUSER['team']." = team OR team = 0 OR ".$CURUSER['id_level']."> 7) ORDER BY data DESC LIMIT 20");
else
$res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}files WHERE image !='' $where AND moder = 'ok' $exclude AND (".$CURUSER['team']." = team OR team = 0 OR ".$CURUSER['id_level']."> 7) ORDER BY data DESC LIMIT 20");

if(@mysqli_num_rows($res)>0)
{
    echo "<div align='center'><table border='0' align='center' cellpadding='0' cellspacing='0' width='100%'><tr><td><div class=dmarquee onmouseover=doMStop() onmouseout=doDMarquee()><div><div>";
while($result=mysqli_fetch_array($res))
   {
 if ($btit_settings["imdbbl"]==true )
 { 
  require_once ("imdb/imdb.class.php");
  $movie = new imdb($result["imdb"]);
  $movie->photodir='./imdb/images/';
  $movie->photoroot='./imdb/images/';
if (($photo_url = $movie->photo_localurl() ) != FALSE)
 echo "<A HREF=\"index.php?page=torrent-details&id=".$result["info_hash"]."\" title=\"".$language["TORRENT_DETAILS"].": ".$result["filename"]."\"><img src=\"thumbnail.php?size=150&path=".$photo_url."\" height=\"150px\"></A>";
 }
 else
 {  
 if ($btit_settings["imgsw"]==false ) 
 echo "<A HREF=\"index.php?page=torrent-details&id=".$result["info_hash"]."\" title=\"".$language["TORRENT_DETAILS"].": ".$result["filename"]."\"><img src=\"thumbnail.php?size=150&path=".$result["image"]."\" height=\"150px\"></A>";
 else   
 echo "<A HREF=\"index.php?page=torrent-details&id=".$result["info_hash"]."\" title=\"".$language["TORRENT_DETAILS"].": ".$result["filename"]."\"><img src=\"thumbnail.php?size=150&path=torrentimg/".$result["image"]."\" height=\"150px\"></A>";
}
}
 echo "</div></div></div></td></tr></table></div>\n";
} 	
}    
else
{
    function textLimit($string, $length, $replacer = '...')
    {

        if (strlen(trim($string)) > $length)
            return (preg_match('/^(.*)\W.*$/', substr($string, 0, $length + 1), $matches) ?
                $matches[1] : substr($string, 0, $length)) . $replacer;
        return $string;
    }

    $checkgolden = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}gold LIMIT 0");

    if ($checkgolden)
        $isgold = " f.gold,";
    else
        $isgold = "";
        
if ($XBTT_USE)
    $rowcat = do_sqlquery("SELECT u.id, (u.downloaded+IFNULL(x.downloaded,0)) as downloaded, ((u.uploaded+IFNULL(x.uploaded,0))/(u.downloaded+IFNULL(x.downloaded,0))) as uratio, cp.* FROM {$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  else
    $rowcat = do_sqlquery("SELECT u.id, u.downloaded, (u.uploaded/u.downloaded) as uratio, cp.* FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  if (mysqli_num_rows($rowcat)>0)
     while ($catdata=mysqli_fetch_array($rowcat))
             if($catdata["viewtorrlist"]!="yes" && (($catdata["downloaded"]>=$GLOBALS["download_ratio"] && ($catdata["ratio"]>$catdata["uratio"]))||($catdata["downloaded"]<$GLOBALS["download_ratio"])||($catdata["ratio"]=="0")))
                $exclude.=' AND f.category!='.$catdata[catid];
        
if ($XBTT_USE)
   {
    $tseeds="f.seeds+ifnull(x.seeders,0) as seeds";
    $tleechs="f.leechers+ifnull(x.leechers,0) as leechers";
    $tcompletes="f.finished+ifnull(x.completed,0)";
    $ttables="{$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON x.info_hash=f.bin_hash";
   }
else
    {
    $tseeds="f.seeds as seeds";
    $tleechs="f.leechers as leechers";
    $tcompletes="f.finished";
    $ttables="{$TABLE_PREFIX}files f";
    } 
	
if ($btit_settings["imdbbl"]==true ) 
$scr= "f.imdb != ''";
else
$scr= "f.image != ''";

    $sql = "SELECT f.team,f.imdb,f.moder,f.info_hash as hash, $tseeds, $tleechs, f.dlbytes AS dwned, format($tcompletes,0) as finished, f.filename, f.url, f.info, UNIX_TIMESTAMP(f.data) AS added, f.image as fimage, c.image, c.name AS cname, f.category AS catid, f.size, f.external, f.uploader,f.anonymous,$isgold u.username FROM $ttables LEFT JOIN {$TABLE_PREFIX}categories as c ON c.id = f.category LEFT JOIN {$TABLE_PREFIX}users as u ON f.uploader=u.id WHERE leechers + seeds > 0 AND $scr $exclude AND f.moder = 'ok' $where ORDER BY data DESC LIMIT 20";

    $row = do_sqlquery($sql) or err_msg($language["ERROR"], $language["CANT_DO_QUERY"] .
        ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    if ($row)
    {
        $file = fopen("./lasttorrents.xml", "w");
        $result = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<images title=\"" . $SITENAME . "\">\r\n";

        while ($data = mysqli_fetch_array($row))
        {

            if (strlen($data["hash"]) > 0)
            {
                $data["filename"] = unesc($data["filename"]);

                $filename = $data["filename"];

                $pagelink = "index.php?page=torrent-details&amp;id=" . $data['hash'] . "";

                if ($data["external"] == "yes")
                    $golden = "ext";
                else
                {
                    if ($checkgolden)
                        $golden = $data["gold"];
                    else
                        $golden = "0";
                }

if ($data["anonymous"]==true)                
  $ano="anonymous";
  else
  $ano=$data["username"];
  
                
if ($btit_settings["imdbbl"]==true )
{
require_once ("imdb/imdb.class.php");
  $movie = new imdb($data["imdb"]);
  $movie->photodir='./imdb/images/';
  $movie->photoroot='./imdb/images/';
  if (($photo_url = $movie->photo_localurl() ) != FALSE)
  {
                     $result .= "<pic>\r\n<thumb>" . $photo_url . "</thumb>\r\n<link>" .
                    $pagelink . "</link>\r\n<category>" . $data["cname"] . "</category>\r\n<seeds>" .
                    $data["seeds"] . "</seeds>\r\n<leechers>" . $data["leechers"] . "</leechers>\r\n<finished>" .
                    $data["finished"] . "</finished>\r\n<golden>" . $golden . "</golden>\r\n<tooltip>" .
                    textLimit($data["filename"], 50) . "</tooltip>\r\n<uploader>" . $ano .
                    "</uploader> />\r\n</pic>\r\n";
                    }
	
}                
ELSE
{                
if ($btit_settings["imgsw"]==false ) 
{
                     $result .= "<pic>\r\n<thumb>" . $data["fimage"] . "</thumb>\r\n<link>" .
                    $pagelink . "</link>\r\n<category>" . $data["cname"] . "</category>\r\n<seeds>" .
                    $data["seeds"] . "</seeds>\r\n<leechers>" . $data["leechers"] . "</leechers>\r\n<finished>" .
                    $data["finished"] . "</finished>\r\n<golden>" . $golden . "</golden>\r\n<tooltip>" .
                    textLimit($data["filename"], 50) . "</tooltip>\r\n<uploader>" . $ano .
                    "</uploader> />\r\n</pic>\r\n";
                    }
                else
                {
                    $result .= "<pic>\r\n<thumb>torrentimg/" . $data["fimage"] . "</thumb>\r\n<link>" .
                    $pagelink . "</link>\r\n<category>" . $data["cname"] . "</category>\r\n<seeds>" .
                    $data["seeds"] . "</seeds>\r\n<leechers>" . $data["leechers"] . "</leechers>\r\n<finished>" .
                    $data["finished"] . "</finished>\r\n<golden>" . $golden . "</golden>\r\n<tooltip>" .
                    textLimit($data["filename"], 50) . "</tooltip>\r\n<uploader>" . $ano .
                    "</uploader> />\r\n</pic>\r\n";
                }
            }
        }
    }

        $result .= "</images>";
        fwrite($file, utf8_encode($result));
        fclose($file);
    }
   
?>
<div align="center">
	<object classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000
	codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,2,0
	width=600
	height=280>
	<param name=movie value="./lasttorrents.swf">
	<param name=quality value=high>
	<param name=SCALE value=showall>
	<param name=WMODE value=transparent>
	<embed src="./lasttorrents.swf"
	quality=high
	pluginspage=http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash type=application/x-shockwave-flash
	width=600
	height=280
	scale= showall
	wmode=transparent>
	</embed>
	</object>
</div>    
    <?php

}
}
?>