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

if (!defined("IN_BTIT"))
      die("non direct access!");

$id = AddSlashes((isset($_GET["id"])?$_GET["id"]:false));

if (!isset($id) || !$id)
    stderr($language["ERROR"],$language["ERROR_ID"].": $id",$GLOBALS["usepopup"]);
    
require_once(load_language("lang_torrents.php"));

if (isset($_GET["act"]) && $_GET["act"]=="update")
   {
        require_once(dirname(__FILE__)."/include/getscrape.php");

		$torrent=get_result('SELECT announces FROM '.$TABLE_PREFIX.'files WHERE info_hash="'.mysqli_real_escape_string($DBDT,$_GET["id"]).'"');
		$urls=@unserialize($torrent[0]["announces"])?unserialize($torrent[0]["announces"]):array();
		$keys=array_keys($urls);
	    $random=mt_rand(0, count($urls)-1);
		$url=$keys[$random];
				
		scrape($url, $id);

       redirect("index.php?page=torrent-details&id=$id");
       exit();
   }
   
if (isset($_POST[delcomment])) {
      if ($CURUSER["delete_comments"]=="yes")
              do_sqlquery("DELETE FROM {$TABLE_PREFIX}comments WHERE id IN (" . implode(", ", $_POST[delcomment]) . ")");
}

if ($XBTT_USE)
   {
    $tdt= "f.seeds+ifnull(x.seeders,0)";
    $tseeds="f.seeds+ifnull(x.seeders,0) as seeds";
    $tleechs="f.leechers+ifnull(x.leechers,0) as leechers";
    $tcompletes="f.finished+ifnull(x.completed,0) as finished";
    $ttables="{$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON x.info_hash=f.bin_hash";
   }
else
    {
    $tdt= "f.seeds";
    $tseeds="f.seeds as seeds";
    $tleechs="f.leechers as leechers";
    $tcompletes="f.finished as finished";
    $ttables="{$TABLE_PREFIX}files f";
    }

if(!$CURUSER || $CURUSER["view_torrents"]!="yes")
{
    err_msg($language["ERROR"],$language["NOT_AUTHORIZED"]." ".$language["MNU_TORRENT"]."!<br />\n".$language["SORRY"]."...");
    stdfoot();
    exit();
}
$res = get_result("SELECT c.porn,f.category, u.team AS userteam, teams.id AS teamsid, teams.name AS teamname, teams.image AS teamimage, f.team, f.language as language,f.tag, f.multiplier,f.gold,f.free,f.vip_torrent,f.happy, f.youtube_video,f.imdb, f.staff_comment, f.announces, UNIX_TIMESTAMP(f.reseed) as reseed, f.screen1, f.screen2, f.screen3, f.image, u.warn, u.donor, f.info_hash, f.filename, f.url, UNIX_TIMESTAMP(f.data) as data, f.size, f.comment, f.uploader, c.name as cat_name, $tseeds, $tleechs, $tcompletes, f.speed, f.external, f.announce_url,UNIX_TIMESTAMP(f.lastupdate) as lastupdate,UNIX_TIMESTAMP(f.lastsuccess) as lastsuccess, f.anonymous, u.username ,f.gold, flr.count, flr.approved, f.topicid, flr.requester_ids FROM $ttables LEFT JOIN {$TABLE_PREFIX}free_leech_req flr ON f.info_hash=flr.info_hash LEFT JOIN {$TABLE_PREFIX}categories c ON c.id=f.category LEFT JOIN {$TABLE_PREFIX}users u ON u.id=f.uploader LEFT JOIN {$TABLE_PREFIX}teams teams ON f.team = teams.id WHERE f.info_hash ='" . $id . "'",true, $btit_settings['cache_duration']);

$res_m = getmoderstatusbyhash($id);if (count($res)<1)
   stderr($language["ERROR"],"Bad ID!",$GLOBALS["usepopup"]);
$row=$res[0];

$spacer = "&nbsp;&nbsp;";

if ($XBTT_USE)
$rescat = get_result("SELECT u.id, (u.downloaded+IFNULL(x.downloaded,0)) as downloaded, ((u.uploaded+IFNULL(x.uploaded,0))/(u.downloaded+IFNULL(x.downloaded,0))) as uratio, cp.* FROM {$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid AND ".$row["category"]."=cp.catid WHERE u.id = ".$CURUSER["uid"]." LIMIT 1;",true);
else
$rescat = get_result("SELECT u.id, u.downloaded, (u.uploaded/u.downloaded) as uratio, cp.* FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid AND ".$row["category"]."=cp.catid WHERE u.id = ".$CURUSER["uid"]." LIMIT 1;",true);
$rowcat=$rescat[0];
if($rowcat["viewtorrdet"]!="yes" && (($rowcat["downloaded"]>=$GLOBALS["download_ratio"] && ($rowcat["ratio"]>$rowcat["uratio"]))||($rowcat["downloaded"]<$GLOBALS["download_ratio"])||($rowcat["ratio"]=="0")))
{
    err_msg($language["ERROR"],$language["NOT_ACCESS_TORR_DETAILS"]."<br />\n".$language["SORRY"]."...");
    stdfoot();
    exit();
}

$torrenttpl=new bTemplate();

// new porn system
$dob=explode("-",$CURUSER["dob"]);
$age=userage($dob[0], $dob[1], $dob[2]);
if ($row["porn"]=="yes" AND $CURUSER['showporn']=='no' OR $age <= $btit_settings["porncat"] )
{
    err_msg($language["ERROR"],"This torrent is marked as porn , or your age is under ".$btit_settings["porncat"]." , or you did select view no porn in your profile ");
    stdfoot();
    exit();	
}

// staff_comment start
    $current_level = getLevelSC($CURUSER['id_level']);
    $level_sc = false;

if ($CURUSER["uid"]>1 && $current_level>=$btit_settings["staff_comment_view"])
$torrenttpl->set("LEVEL_SC",true,FALSE);
else
$torrenttpl->set("LEVEL_SC",false,TRUE);
   
$torrenttpl->set("torrent.staff_comment",$row["staff_comment"]);
// staff_comment end

// Snatchers hack by DT dec 2008
$sres = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}history WHERE infohash = '$id' AND date IS NOT NULL ORDER BY date DESC LIMIT 10 ");
$srow=mysqli_num_rows($sres);

	if ($srow)

       $snatchers=array();
       $plus=0;

    while ($srow = mysqli_fetch_array($sres))

{
$res =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor, suffixcolor, users.id, username, level FROM {$TABLE_PREFIX}users users INNER JOIN {$TABLE_PREFIX}users_level users_level ON users.id_level=users_level.id WHERE users.id='".$srow["uid"]."'") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$result=mysqli_fetch_array($res);
$snatchers[$plus]["snatch"]="<a href=index.php?page=userdetails&id=$result[id]>".unesc($result["prefixcolor"]).unesc($result["username"]).unesc($result["suffixcolor"])."</a>&nbsp;";
$plus++;
}
$torrenttpl->set("snatchers",$snatchers);
// Snatchers hack end

//vip_torrent start
if($row["vip_torrent"]==1) 
$vt = "<img src=images/vip.gif alt='vip only torrent'>";
else 
$vt='';
//vip_torrent end
 
//free leech hack
$ql='';
if($row['free'] == yes OR $row['happy'] == yes)
$ql = '<img src="images/freeleech.gif" alt="free leech"/>';
// end free leech

if($row['multiplier']>1) 
$mult = "<img alt=\"".$row['multiplier']."x Upload Multiplier\" src=\"images/".$row['multiplier']."x.gif\" />";
else 
$mult=""; 

//gold mod
    $silver_picture='';
    $gold_picture ='';
     $resh=get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'",true);
            foreach ($resh as $key=>$value)
            {
                $silver_picture = $value["silver_picture"];
                $gold_picture = $value["gold_picture"];
            }
       
    $gq='';
    if($row['gold'] == 1)
    $gq=  '<img src="gold/'.$silver_picture.'" alt="silver"/>';
    
    if($row['gold'] == 2)
    $gq=  '<img src="gold/'.$gold_picture.'" alt="gold"/>';
    
$torrenttpl->set("torrent.icon",$vt.$gq.$mult.$ql);

//start Gold request hack
if(!is_null($row["requester_ids"]))
{
    $requesters=unserialize($row["requester_ids"]);
    $list="";
    foreach($requesters as $v)
    {
        $list.=$v.",";
    }
    $list=trim($list, ",");
}
else
{
    $list="";
    $requesters=array();
}
 $torrenttpl->set("free1","<td align='right' class='header'>Ask for Gold</td>");
if($list!="")
{
    $res5=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT u.id, u.username, ul.prefixcolor, ul.suffixcolor FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level = ul.id WHERE u.id IN ($list) ORDER BY u.id ASC");

while($requsers = mysqli_fetch_assoc($res5))
{
    $userlist.=(($GLOBALS[usepopup])?"<a href=\"javascript:windowunder('index.php?page=userdetails&id=".$requsers["id"]."');\">":"<a href='index.php?page=userdetails&id=".$requsers["id"]."'>") . stripslashes($requsers["prefixcolor"]) . $requsers["username"] . stripslashes($requsers["suffixcolor"]) . "</a>, ";
}
(($userlist!="")?$userlist=trim($userlist, ", ") . ".":$userlist="");
  }
if($row["gold"]==0 && ($row["approved"]=="undecided" || is_null($row["approved"])))
$torrenttpl->set("free2","<td class='lista' align='center'>$userlist<br />(".((!is_null($row["count"]))?$row["count"]:0)." request".(($row["count"]==1)?"":"s")." so far)".((!in_array($CURUSER["uid"], $requesters))?"<br /><a href='index.php?page=freereq&id=$id'>Request for this torrent to be set to Gold</a>":"<br /><strong>You have already made a request.</strong>")."</td>");
elseif($row["gold"]==1 && ($row["approved"]=="undecided" || is_null($row["approved"])))
$torrenttpl->set("free2","<td class='lista' align='center'>$userlist<br />(".((!is_null($row["count"]))?$row["count"]:0)." request".(($row["count"]==1)?"":"s")." so far)".((!in_array($CURUSER["uid"], $requesters))?"<br /><a href='index.php?page=freereq&id=$id'>Request for this torrent to change from Silver to Gold</a>":"<br /><strong>You have already made a request.</strong>")."</td>");
elseif($row["gold"]==0 && $row["approved"]=="no")
$torrenttpl->set("free2","<td class='lista' align='center'>Sorry, already declined by Admin</td>");
elseif($row["gold"]==1 && $row["approved"]=="no")
$torrenttpl->set("free2","<td class='lista' align='center'>Sorry, already declined by Admin</td>");
elseif($row["gold"]==2)
$torrenttpl->set("free2","<td class='lista' align='center'>This torrent is already set to Gold</td>");
//end

// show all uploads per user
$dt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filename,info_hash FROM {$TABLE_PREFIX}files WHERE uploader =".$row["uploader"]." ORDER BY data DESC");

    $upl=array();
    $i=0;

if (!$dt || mysqli_num_rows($dt)==0)
{
//
}
else
{
while ($dts = mysqli_fetch_array($dt))
{
     $upl[$i]["filename"]="<a href=index.php?page=torrent-details&id=".$dts["info_hash"].">".$dts["filename"]."</a>&nbsp;<font color = red><b>--</b></font>";
     $i++;
}
}
$torrenttpl->set("upl",$upl);
// show all uploads per user end

// pie
if ($btit_settings["pie"]==TRUE )
{
$dttot = ($row["seeds"]+$row["leechers"]+$row["finished"]);
if ($row["seeds"]==0)
$dtseed=0;
else
$dtseed = $dttot / $row["seeds"];
if ($row["leechers"]==0)
$dtleech=0;
else
$dtleech = $dttot / $row["leechers"];
if ($row["finished"]==0)
$dtfin=0;
else
$dtfin = $dttot / $row["finished"];
$torrenttpl->set("dtseed",$dtseed);
$torrenttpl->set("dtleech",$dtleech);
$torrenttpl->set("dtfin",$dtfin);
$torrenttpl->set("pie", true, true);
}
else
$torrenttpl->set("pie", false, true);
// pie

//Ask For Reeseed Hack
if ($btit_settings["logmin"]==TRUE )
{ 
$pa=time()-$row["data"];
$px=floatval(time()-$row["reseed"]);

if($row["seeds"]==0 && $row["finished"]>2 && $row["leechers"]>0 && $pa>86400 && $px>432000)
{

$reseed=("<a href='index.php?page=reseed&amp;q=".$row["info_hash"]."'><img src='images/reseed.gif'></a>");
$torrenttpl->set("reseed",$reseed);
}
else
$torrenttpl->set("reseed","<font color = red>if there is no button here, you can not ask for a reseed</font>");
}

if ($btit_settings["logmin"]==FALSE )
{
if($row["seeds"]==0 && $row["finished"]>0 && $px>432000)
{

$reseed=("<a href='index.php?page=reseed&amp;q=".$row["info_hash"]."'><img src='images/reseed.gif'></a>");
$torrenttpl->set("reseed",$reseed);
}
else
$torrenttpl->set("reseed","<font color = red>if there is no button here, you can not ask for a reseed</font>");	
}
//Ask For Reeseed Hack end
$torrenttpl->set("rep","<a href=index.php?page=report&torrent=".$row["info_hash"]."><img src='images/reptor.gif'></a></td>");

// Similar Torrents by DT start
        $searchname = substr($row['filename'], 0, 8);
        $query1 = str_replace(" ",".",sqlesc("%".$searchname."%"));
        
           $r = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT f.info_hash, f.filename, f.size, UNIX_TIMESTAMP( f.data ) as added , $tseeds  , $tleechs , f.category FROM $ttables WHERE f.filename LIKE {$query1} AND $tdt > '0' AND f.info_hash <> '$id' ORDER BY $tdt DESC LIMIT 10") or sqlerr();
           if (mysqli_num_rows($r) > 0)
           {
           $torrents = "<table width='100%' class='main' border='1' cellspacing='0' cellpadding='1'>\n" .
           "<tr><td class='colhead'>{$language['details_name']}</td><td class='colhead' align='center'>{$language['details_date']}</td><td class='colhead' align='center'>{$language['details_size']}</td><td class='colhead' align='center'>{$language['details_seeders']}</td><td class='colhead' align='center'>{$language['details_leechers']}</td></tr>\n";
           while ($a = mysqli_fetch_assoc($r))
           {
// Peers Colors by DT
    $sc = '#04B404';		

    $lc = '#04B404';	
    
	if ($a["seeds"]==0)
    $sc  = '#FF0000';
    if ($a["leechers"]==0)
    $lc = '#FF0000';
    if ($a["seeds"]== 1 OR $a["seeds"]== 2)
    $sc  = '#A9F5D0';	
    if ($a["leechers"]== 1 OR $a["leechers"] == 2)
    $lc = '#A9F5D0';	
    if ($a["seeds"]==3 OR $a["seeds"]==4)
    $sc  = '#00FF80';		
    if ($a["leechers"]== 3 OR $a["leechers"] == 4)
    $lc = '#00FF80';	

// end Peers Colors by DT            
           $name = $a["filename"];
           $torrents .= "<td><a href='index.php?page=torrent-details&id=" . $a["info_hash"] . "&hit=1'><b>" . htmlspecialchars($name) . "</b></a></td><td style='padding: 1px' align='center'>" . date("d/m/Y",$a["added"]-$offset). "</td><td style='padding: 1px' align='center'>". makesize($a[size]) ."</td><td style='padding: 1px' align='center'><font color=".$sc.">".$a[seeds]."</font></td><td style='padding: 1px' align='center'><font color=".$lc.">".$a[leechers]."</font></td></tr>\n";
           }
           $torrents .= "</table>";
           $torrenttpl->set("similar",$torrents);
           }
// Similar Torrents 

$torrenttpl->set("language",$language);


if ($btit_settings["imdbimg"]==false )
{
if (!empty($row["image"]))
{
$image1 = "".$row["image"]."";

if ($btit_settings["imgsw"]==false ) 
{
$image_new = $image1;
$uploaddir = '';
}
else
{
$image_new = "torrentimg/$image1"; //url of picture
$uploaddir = $GLOBALS["uploaddir"];
}
//$image_new = str_replace(' ','%20',$image_new); //take url and replace spaces
$max_width= "490"; //maximum width allowed for pictures
$resize_width= "490"; //same as max width
$size = getimagesize("$image_new"); //get the actual size of the picture
$width= $size[0]; // get width of picture
$height= $size[1]; // get height of picture
if ($width>$max_width){
$new_width=$resize_width; // Resize Image If over max width
}else {
$new_width=$width; // Keep original size from array because smaller than max
}
$torrenttpl->set("width",$new_width);
}
      $torrenttpl->set("IMAGEIS",!empty($row["image"]),TRUE);
      $torrenttpl->set("IMAGESC",!empty($row["screen1"]) OR !empty($row["screen2"])OR !empty($row["screen3"]) ,TRUE);
      $torrenttpl->set("SCREENIS1",!empty($row["screen1"]),TRUE);
      $torrenttpl->set("SCREENIS2",!empty($row["screen2"]),TRUE);
      $torrenttpl->set("SCREENIS3",!empty($row["screen3"]),TRUE);
      $torrenttpl->set("uploaddir",$uploaddir);
}      

// imdb image
if ($btit_settings["imdbimg"]==true )
{  
$torrenttpl->set("IMAGEIS",false,TRUE);
$torrenttpl->set("IMAGEIMDB",true,FALSE); 
require_once ("imdb/imdb.class.php");
  $movie = new imdb($row["imdb"]);
  $movie->photodir='./imdb/images/';
  $movie->photoroot='./imdb/images/';
  if (($photo_url = $movie->photo_localurl() ) != FALSE)
$balon= $photo_url;
$torrenttpl->set("imdbpic",$balon);
}
else
$torrenttpl->set("IMAGEIMDB",false,TRUE); 
// imdb image 

//PRETIME
if  ($btit_settings["prepre"] == true ) 
{
$torrenttpl->set("PRE",true,FALSE); 
$preres=get_result("SELECT data, pretime FROM {$TABLE_PREFIX}files  WHERE info_hash ='" . $id . "'",true);
            foreach ($preres as $key=>$value)
            {
                $uptime = $value["data"];
                $pretime = $value["pretime"];
            }
$uptime = str_replace("/", "-", $uptime);
$pretime = date('Y-m-d H:i:s', $pretime);
$nopre = explode("-", $pretime);
function dateDifference($date_1 , $date_2 , $differenceFormat = '%y-%m-%d-%h-%i-%s' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);

}

$prediff = dateDifference($uptime, $pretime);
$prediff = explode("-", $prediff);
    $prediffy = $prediff[0]; //Jahre
    $prediffm = $prediff[1]; //Monate
    $prediffd = $prediff[2]; //Tage
    $prediffh = $prediff[3]; //Stunden
    $prediffmm = $prediff[4]; // Minuten
    $prediffs = $prediff[5]; // Seekunden

if ($prediffy > '0') {
    $prediff = '&nbsp;'.$pretime.'&nbsp;&nbsp;/&nbsp;&nbsp;Upload was '.$prediffy.' Year(s) '.$prediffm.' Mont(s)) '.$prediffd.' Day(s) '.$prediffh.' Hour(s) '.$prediffmm.' Minute(s) and '.$prediffs.' Second(s) after Pre';
}

if($prediffy == '0' && $prediffm > '0'){
    $prediff = '&nbsp;'.$pretime.'&nbsp;&nbsp;/&nbsp;&nbsp;Upload was '.$prediffm.' Mont(s) '.$prediffd.' Day(s) '.$prediffh.' Hour(s) '.$prediffmm.' Minute(s) and '.$prediffs.' Second(s) after Pre';
}

if($prediffy == '0' && $prediffm == '0' && $prediffd > '0'){
    $prediff = '&nbsp;'.$pretime.'&nbsp;&nbsp;/&nbsp;&nbsp;Upload was '.$prediffd.' Day(s) '.$prediffh.' Hour(s) '.$prediffmm.' Minute(s) and '.$prediffs.' Second(s) after Pre';
}

if($prediffy == '0' && $prediffm == '0' && $prediffd == '0' && $prediffh > '0'){
    $prediff = '&nbsp;'.$pretime.'&nbsp;&nbsp;/&nbsp;&nbsp;Upload was '.$prediffh.' Hour(s) '.$prediffmm.' Minute(s) and '.$prediffs.' Second(s) after Pre';
}

if($prediffy == '0' && $prediffm == '0' && $prediffd == '0' && $prediffh == '0' && $prediffmm > '0') {
    $prediff = '&nbsp;'.$pretime.'&nbsp;&nbsp;/&nbsp;&nbsp;Upload was '.$prediffmm.' Minute(s) and '.$prediffs.' Second(s) after Pre';
}

if($prediffy == '0' && $prediffm == '0' && $prediffd == '0' && $prediffh == '0' && $prediffmm == '0' && $prediffs > '0') {
    $prediff = '&nbsp;'.$pretime.'&nbsp;&nbsp;/&nbsp;&nbsp;Upload was '.$prediffs.' Second(s) after Pre';
}

if($nopre[0] == '1970') {
    $prediff = 'No PreTime found';
}

$torrenttpl->set("torrent.pree","&nbsp;".$prediff);
}
else
$torrenttpl->set("PRE",false,TRUE);
// pretime     
      
if ($CURUSER["uid"]>1 && ($CURUSER["uid"]==$row["uploader"] || $CURUSER["edit_torrents"]=="yes" || $CURUSER["delete_torrents"]=="yes"))
   {
    $torrenttpl->set("MOD",TRUE,TRUE);
    $torrent_mod="<br />&nbsp;&nbsp;";
    $torrenttpl->set("SHOW_UPLOADER",true,true);
   }
else
   {
    $torrenttpl->set("SHOW_UPLOADER",$SHOW_UPLOADER,true);
    $torrenttpl->set("MOD",false,TRUE);
   }

// edit and delete picture/link
if ($CURUSER["uid"]>1 && ($CURUSER["uid"]==$row["uploader"] || $CURUSER["edit_torrents"]=="yes")) {
      if ($GLOBALS["usepopup"])
        $torrent_mod.="<a href=\"javascript: windowunder('index.php?page=edit&amp;info_hash=".$row["info_hash"]."&amp;returnto=".urlencode("index.php?page=torrent-details&id=$row[info_hash]")."')\">".image_or_link("$STYLEPATH/images/edit.png","",$language["EDIT"])."</a>&nbsp;&nbsp;";
      else
        $torrent_mod.="<a href=\"index.php?page=edit&amp;info_hash=".$row["info_hash"]."&amp;returnto=".urlencode("index.php?page=torrent-details&id=$row[info_hash]")."\">".image_or_link("$STYLEPATH/images/edit.png","",$language["EDIT"])."</a>&nbsp;&nbsp;";

}

if ($row["team"]){
$viewteam=" <tr>
          <td align=\"right\" class=\"header\">Team</td>
          <td class=\"lista\" align=\"center\"><a href='index.php?page=modules&amp;module=team&team=".$row["teamsid"]."'><img src=\"".$row["teamimage"]."\" border=\"0\" title=\"".$row["teamname"]."\">&nbsp;".$row["teamname"]."</a></td>
        </tr>";
}else{
$viewteam="";
}
$torrenttpl->set("teamview",$viewteam);

if ($CURUSER["uid"]>1 && ($CURUSER["uid"]==$row["uploader"] || $CURUSER["delete_torrents"]=="yes")) {
      if ($GLOBALS["usepopup"])
        $torrent_mod.="<a href=\"javascript: windowunder('index.php?page=delete&amp;info_hash=".$row["info_hash"]."&amp;returnto=".urlencode("index.php?page=torrents")."')\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a>&nbsp;&nbsp;";
      else
        $torrent_mod.="<a href=\"index.php?page=delete&amp;info_hash=".$row["info_hash"]."&amp;returnto=".urlencode("index.php?page=torrents")."\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a>";
}


$torrenttpl->set("mod_task",$torrent_mod);

if ($btit_settings["nfosw"]==true )
   {  
$filenfo = "nfo/rep/" . $row["info_hash"] . ".nfo";

if (file_exists($filenfo)) {
$row["nfo"] .= "<div align=right><a href=\"#nfo\" onclick=\"javascript:ShowHide('slidenfo','');\">Show | Hide NFO</a></div>
               <div align='center' style='display:none' id='slidenfo'>
               
               <img src='nfo/nfogen.php?nfo=rep/" . $row["info_hash"] . ".nfo&colour=1'></div>
               
               </div>";
}
$torrenttpl->set("nfo",true,FALSE);
}
else
$torrenttpl->set("nfo",false,TRUE);

$torrenttpl->set("show_addthis","	<!-- Code genarated from http://www.addthis.com/ -->
	<!-- AddThis Button BEGIN -->
<div class='addthis_toolbox addthis_default_style'>
<a class='addthis_button_facebook'></a>
<a class='addthis_button_myspace'></a>
<a class='addthis_button_googlebuzz'></a>
<a class='addthis_button_twitter'></a>
<a class='addthis_button_live'></a>
<a class='addthis_button_google_plusone'></a>
<a class='addthis_button_compact'></a>
<a class='addthis_counter addthis_bubble_style'></a>
</div>
<script type='text/javascript' src='http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e57b1bb3fd7f0ca'></script>
<!-- AddThis Button END -->");

// pretime orlydb
if ($btit_settings["orlydb"]==true )
{
$torrenttpl->set("or",TRUE,TRUE); 
require_once "orlydb.php";
$pretime = orlyread($row["filename"]);

if(isset($pretime['time'])) 
{
$dtgh= date('d-m-Y h:i:s', strtotime($pretime['time'])); 
$dttime=get_elapsed_time(strtotime($pretime['time']));  
$e_type = str_replace(' ', '+', $row["filename"]);
$torrenttpl->set("torrent.pre",$dtgh. " <font color=steelblue>[ ".$dttime." ago ]</font> in section ".$pretime['section']." - ".$pretime['inforight']." <A HREF=http://orlydb.com/?q=".$e_type." target=_blank>[ Visit Orlydb ]</A>");
}
else
$torrenttpl->set("torrent.pre","Filename not found in Orlydb");

if(isset($pretime['nukeright'])) 
{
$torrenttpl->set("ornuk",TRUE,TRUE);
$torrenttpl->set("torrent.nuk","<font color=red>".$pretime['nukeright']."</font>");
}
else
$torrenttpl->set("ornuk",false,TRUE);
}
else
{
$torrenttpl->set("ornuk",false,TRUE);
$torrenttpl->set("or",false,TRUE);	
}
//pretime orlydb end

if (!empty($row["comment"]))
   $row["description"]=format_comment($row["comment"]);

if (isset($row["cat_name"]))
    $row["cat_name"]=unesc($row["cat_name"]);
else
    $row["cat_name"]=unesc($language["NONE"]);


if($btit_settings["magnet"] == true)
{
    $row["magnet"]="<a href=magnet:?xt=urn:btih:".strtoupper(base32_encode(pack('H*' ,$row["info_hash"]))). ">".image_or_link("images/magnet.png","","Magnet")."</a>";
    $torrenttpl->set("MAGNET", true, true);
	}
else
	$torrenttpl->set("MAGNET", false, true);    


require('ajaxstarrater/_drawrating.php'); # ajax rating

  if ($row["username"]!=$CURUSER["username"] && $CURUSER["uid"]>1) {
      $row["rating"] =  rating_bar("" . $_GET["id"]. "", 5);
  } else {
      $row["rating"] = rating_bar("" . $_GET["id"]. "", 5, 'static');
  }
  $row["rating"];

$row["size"]=makesize($row["size"]);
// files in torrent - by Lupin 20/10/05

if($btit_settings["smf_autotopic"] == "true")
	$torrenttpl->set("FORUM_LNK", true, true);
else
	$torrenttpl->set("FORUM_LNK", false, true);
	
$row["topicid"] = "<a href=" .$BASEURL.
    "/index.php?page=forum&amp;action=viewtopic&amp;topicid=" . $row["topicid"] .
    ">" .$BASEURL. "/index.php?page=forum&amp;action=viewtopic&amp;topicid=" .
    $row["topicid"] . "</a>";
  require_once(dirname(__FILE__)."/include/BDecode.php");
if (file_exists($row["url"]))
  {
    $torrenttpl->set("DISPLAY_FILES",TRUE,TRUE);
    $ffile=fopen($row["url"],"rb");
    $content=fread($ffile,filesize($row["url"]));
    fclose($ffile);
    $content=BDecode($content);
    $numfiles=0;
    if (isset($content["info"]) && $content["info"])
      {
        $thefile=$content["info"];
        if (isset($thefile["length"]))
          {
          $dfiles[$numfiles]["filename"]=htmlspecialchars($thefile["name"]);
          $dfiles[$numfiles]["size"]=makesize($thefile["length"]);
          $numfiles++;
          }
        elseif (isset($thefile["files"]))
         {
           foreach($thefile["files"] as $singlefile)
             {
               $dfiles[$numfiles]["filename"]=htmlspecialchars(implode("/",$singlefile["path"]));
               $dfiles[$numfiles]["size"]=makesize($singlefile["length"]);
               $numfiles++;
             }
         }
       else
         {
            // can't be but...
         }
     }
     $row["numfiles"]=$numfiles.($numfiles==1?" file":" files");
     unset($content);
  }
else
    $torrenttpl->set("DISPLAY_FILES",false,TRUE);

$torrenttpl->set("files",$dfiles);

// end files in torrents
include(dirname(__FILE__)."/include/offset.php");
$row["date"]=date("d/m/Y",$row["data"]-$offset);

if ($row["anonymous"]=="true")
{
   if ($CURUSER["edit_torrents"]=="yes")
       $uploader="<a href=\"index.php?page=userdetails&amp;id=".$row['uploader']."\">".$language["TORRENT_ANONYMOUS"]."</a>";
   else
      $uploader=$language["TORRENT_ANONYMOUS"];
   }
else
    $uploader="<a href=\"index.php?page=userdetails&amp;id=".$row['uploader']."\">".user_with_color($row["username"]).get_user_icons($row) .warn($row) ."</a>";

$row["uploader"]=$uploader;

if ($row["speed"] < 0) {
  $speed = "N/D";
}
else if ($row["speed"] > 2097152) {
  $speed = round($row["speed"]/1048576,2) . " MB/sec";
}
else {
  $speed = round($row["speed"] / 1024, 2) . " KB/sec";
}

$torrenttpl->set("NOT_XBTT",!$XBBT_USE,TRUE);
//tag
if ($btit_settings["tag"]==TRUE)
{
	$torrenttpl->set("tag", true, true);
	$torrenttpl->set("tag",$row["tag"]);
	}
else
	$torrenttpl->set("tag", false, true);
//tag

$row["speed"]=$speed;

// moder
	if ($CURUSER['moderate_trusted']=='yes')
	$moderation=TRUE;
	$torrenttpl->set("MODER",$moderation,TRUE);
	
	$moder=$res_m;
	$row["moderation"].="<a title=\"".$moder."\" href=\"index.php?page=edit&info_hash=".$row["info_hash"]."\"><img alt=\"".$moder."\" src=\"images/mod/".$moder.".png\"></a>";
// moder

// Peers Colors by DT
    $sc = '#04B404';		
    $lc = '#04B404';
    $sp = '#04B404';	
    if ($row["seeds"]==0)
    $sc  = '#FF0000';
	if ($row["leechers"]==0)
    $lc = '#FF0000';
	if ($row["seeds"]== 1 OR $row["seeds"]== 2)
    $sc  = '#A9F5D0';	
    if ($row["leechers"]== 1 OR $row["leechers"] == 2)
    $lc = '#A9F5D0';	
    if ($row["seeds"]==3 OR $row["seeds"]==4)
    $sc  = '#00FF80';		
	if ($row["leechers"]== 3 OR $row["leechers"] == 4)
    $lc = '#00FF80';	
	if ($row["leechers"]+$row["seeds"]==0)
	$sp  = '#FF0000';
	if ($row["leechers"]+$row["seeds"]== 1 OR $row["leechers"]+$row["seeds"]== 2)
    $sp  = '#A9F5D0';	
	if ($row["leechers"]+$row["seeds"]== 3 OR $row["leechers"]+$row["seeds"]== 4)
    $sp  = '#00FF80';	
// end Peers Colors by DT   

if (($XBTT_USE && !$PRIVATE_ANNOUNCE) || $row["external"]=="yes") 
   {
$row["downloaded"]=$row["finished"]." " . $language["X_TIMES"];
  $row["peers"]="<font color=".$sp.">".($row["leechers"]+$row["seeds"])."</font> ".$language["PEERS"];
$row["seeds"]=$language["SEEDERS"].": <font color=".$sc.">".$row["seeds"]."</font>";
$row["leechers"]=$language["LEECHERS"].": <font color=".$lc.">" . $row["leechers"]."</font>";
   }
else
   {
$row["downloaded"]="<a href=\"index.php?page=torrent_history&amp;id=".$row["info_hash"]."\">" . $row["finished"] . "</a> " . $language["X_TIMES"];
$row["peers"]="<a href=\"index.php?page=peers&amp;id=".$row["info_hash"]."\"><font color=".$sp.">" . ($row["leechers"]+$row["seeds"]) . "</font></a> ".$language["PEERS"];
$row["seeds"]=$language["SEEDERS"].": <a href=\"index.php?page=peers&amp;id=".$row["info_hash"]."\"><font color=".$sc.">" . $row["seeds"] . "</font></a>";
$row["leechers"]=$language["LEECHERS"].": <a href=\"index.php?page=peers&amp;id=".$row["info_hash"]."\"><font color=".$lc.">" . $row["leechers"] ."</font></a>";
   }
if ($row["external"]=="yes")
   {
          $row["update_url"]="<a href=\"index.php?page=torrent-details&amp;act=update&amp;id=".$row["info_hash"]."\">".$language["UPDATE"]."</a>";
     $row["announce_url"]="<b>".$language["EXTERNAL"]."</b>";
	 $announces=@unserialize($row['announces'])?unserialize($row['announces']):array();
	 $i=0;
	 foreach ($announces AS $announce=>$details) {
	 if ($i==0) {
	 $row['announce_url'].='<table><tbody>';
	 $row['announce_url'].='<tr><th>Announce URL</th><th>Seeders</th><th>Leechers</th><th>Downloaded</th></tr>';
	 }
	 
	 $row['announce_url'].='<tr><td>'.$announce.'</td><td>'.intval($details['seeds']).'</td><td>'.intval($details['leeches']).'</td><td>'.intval($details['downloaded']).'</td></tr>';

	if ($i+1==count($announces)) $row['announce_url'].='</tbody></table>';
	 
	 $i++;
	 }
	 
     $row["lastupdate"]=get_date_time($row["lastupdate"]);
     $row["lastsuccess"]=get_date_time($row["lastsuccess"]);
   }
else
   $torrenttpl->set("EXTERNAL",false,TRUE);

if ($CURUSER["view_comments"]=="yes") {
$torrenttpl->set("VIEW_COMMENTS",TRUE,TRUE);
      
//th dt
$countt=get_result("SELECT * FROM {$TABLE_PREFIX}files_thanks WHERE infohash='".$row["info_hash"]."'");
$count=count($countt);
$torrenttpl->set("tcount",$count);
//th dt    

//comments
if($XBTT_USE)
        {
            $query2_select.="`u`.`downloaded`+IFNULL(`x`.`downloaded`,0) `downloaded`, `u`.`uploaded`+IFNULL(`x`.`uploaded`,0) `uploaded`,";
            $query2_join.="LEFT JOIN `xbt_users` `x` ON `x`.`uid`=`u`.`id` ";
        }
        else
            $query2_select.="`u`.`downloaded`, `u`.`uploaded`, ";
           
$subres = get_result("SELECT ".$query2_select." c.points, u.immunity , u.reputation, u.avatar, u.id_level, u.custom_title, u.id_level, u.warn, u.donor, c.id, text, UNIX_TIMESTAMP(added) as data, user, u.id as uid FROM {$TABLE_PREFIX}comments c LEFT JOIN {$TABLE_PREFIX}users u ON c.user=u.username ".$query2_join." WHERE info_hash = '" . $id . "' ORDER BY added DESC",true,$btit_settings['cache_duration']);

// lock
if ($CURUSER["id_level"]>= 6)
{
$lock = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT lock_comment FROM {$TABLE_PREFIX}files WHERE info_hash = '" . $id . "'");
$lock_comment = mysqli_fetch_array($lock);
if ($lock_comment["lock_comment"] == "no")
$torrenttpl->set("lock","<a href=\"index.php?page=comment&amp;id=$id&amp;lock\">".image_or_link("$STYLEPATH/images/unlock.gif","",$language["LOCK"])."</a>");

if ($lock_comment["lock_comment"] == "yes")
$torrenttpl->set("lock","<a href=\"index.php?page=comment&amp;id=$id&amp;unlock\">".image_or_link("$STYLEPATH/images/lock.gif","",$language["UNLOCK"])."</a>");

}
//lock end

if (!$subres || count($subres)==0) {
     if($CURUSER["uid"]>1)
       $torrenttpl->set("INSERT_COMMENT",TRUE,TRUE);
     else
       $torrenttpl->set("INSERT_COMMENT",false,TRUE);

    $torrenttpl->set("NO_COMMENTS",true,TRUE);
}
else {

     $torrenttpl->set("NO_COMMENTS",false,TRUE);

     if($CURUSER["uid"]>1)
       $torrenttpl->set("INSERT_COMMENT",TRUE,TRUE);
     else
       $torrenttpl->set("INSERT_COMMENT",false,TRUE);
     $comments=array();
     $count=0;
     foreach ($subres as $subrow) {
      
if ($subrow["immunity"]=="yes") 
 $spp="<img src='images/shield.png'>";
 else
 $spp="";

if ($subrow["warn"]=="yes") 
 $war="<img src='images/warn.gif'>";
 else
 $war="";
       
       $level = do_sqlquery("SELECT level FROM {$TABLE_PREFIX}users_level WHERE id_level='$subrow[id_level]'");
       $lvl = mysqli_fetch_assoc($level);
       if (!$subrow[uid])
        $title = "orphaned";
       elseif (!"$subrow[custom_title]")
        $title = "".$lvl['level']."";
       else
        $title = unesc($subrow["custom_title"]);$comments[$count]["user"]="<a href=\"index.php?page=userdetails&amp;id=".$subrow["uid"]."\">" . user_with_color(unesc($subrow["user"])).get_user_icons($subrow).$spp.$war;
       $comments[$count]["user"].="</a><br>Rank: ".$title;
	   
// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

$torrenttpl-> set("comments_reputation", (($setrep["rep_is_online"]=="true") ? TRUE : FALSE), TRUE);

if ($setrep["rep_is_online"]== 'false')
{
//do nothing
}
else
{
if ($subrow["reputation"] == 0)
$reput= "<img src='images/rep/reputation_balance.gif' alt='" . $setrep["no_level"] . "' title='" . $setrep["no_level"] . "' />";
if ($subrow["reputation"] >= 1  )
$reput= "<img src='images/rep/reputation_pos.gif' alt='" . $setrep["good_level"] . "' title='" . $setrep["good_level"] . "' />";
if ($subrow["reputation"] <= -1)
$reput= "<img src='images/rep/reputation_neg.gif' alt='" . $setrep["bad_level"] . "' title='" . $setrep["bad_level"] . "' />";
if ($subrow["reputation"] >= 101 )
$reput= "<img src='images/rep/reputation_highpos.gif' alt='" . $setrep["best_level"] . "' title='" . $setrep["best_level"] . "' />";
if ($subrow["reputation"] <= -101)
$reput= "<img src='images/rep/reputation_highneg.gif' alt='" . $setrep["worse_level"] . "' title='" . $setrep["worse_level"] . "' />";

$comments[$count]["reputation"] = $reput;
}
// DT end reputation system

// DT Comment Vote Start
$comments[$count]["cid"]=$subrow["id"];

if ($subrow["points"] == 0)
{
$vote_plus=  "images/thumbs-up.gif";
$vote_min= "images/thumbs-down.gif";
}
if ($subrow["points"] >= 1 )
{
$vote_plus=  "images/thumbs-up-hover.gif";
$vote_min= "images/thumbs-down.gif";
}
if ($subrow["points"] <= -1 )
{
$vote_plus= "images/thumbs-up.gif";
$vote_min=  "images/thumbs-down-hover.gif";
}

$comments[$count]["voteu"]="<a href=index.php?page=votes&id=".$subrow["id"]."&hash=".$id."&count=up><img border=0 src=".$vote_plus."></a>";
$comments[$count]["voted"]="<a href=index.php?page=votes&id=".$subrow["id"]."&hash=".$id."&count=down><img border=0 src=".$vote_min."></a>";
$comments[$count]["vote_tot"] = $subrow["points"];
// DT End Comment Vote end

$comments[$count]["date"]=date("d/m/Y H.i.s",$subrow["data"]-$offset);

       $comments[$count]["quote"]="<a href='index.php?page=comment&id=$id&usern=".$CURUSER["username"]."&quoteid=".$subrow["id"]."'>".image_or_link("$STYLEPATH/images/f_quote.png", "", $language["QUOTE"])."</a>";


	   $comments[$count]["elapsed"]="(".get_elapsed_time($subrow["data"]) . " ago)";
       $comments[$count]["avatar"]="<img onload=\"resize_avatar(this);\" src=\"".($subrow["avatar"] && $subrow["avatar"] != "" ? htmlspecialchars($subrow["avatar"]): "$STYLEURL/images/default_avatar.gif" )."\" alt=\"\" />";
       $comments[$count]["ratio"]="<img src=\"images/arany.png\">&nbsp;".(intval($subrow['downloaded']) > 0?number_format($subrow['uploaded'] / $subrow['downloaded'], 2):"---");
       $comments[$count]["uploaded"]="<img src=\"images/speed_up.png\">&nbsp;".(makesize($subrow["uploaded"]));
       $comments[$count]["downloaded"]="<img src=\"images/speed_down.png\">&nbsp;".(makesize($subrow["downloaded"]));
       
    
       if ($CURUSER["edit_comments"]=="yes" || $subrow["user"]==$CURUSER["username"])
         $comments[$count]["edit.delete"].="
          <a href=\"index.php?page=comment&amp;id=$id&amp;cid=" . $subrow["id"] . "&amp;edit\">".image_or_link("$STYLEPATH/images/f_edit.png","",$language["EDIT"])."</a>";
       
       if ($CURUSER["delete_comments"]=="yes" || $subrow["user"]==$CURUSER["username"])
         $comments[$count]["edit.delete"].="
          <a onclick=\"return confirm('". str_replace("'","\'",$language["DELETE_CONFIRM"])."')\" href=\"index.php?page=comment&amp;id=$id&amp;cid=" . $subrow["id"] . "&amp;action=delete\">".image_or_link("$STYLEPATH/images/f_delete.png","",$language["DELETE"])."</a>         
          ";
          
       if ($CURUSER["delete_comments"]=="yes")
         $comments[$count]["edit.delete"].="
         <input type=\"checkbox\" name=\"delcomment[]\" value=\"" . $subrow["id"] . "\" />";                             
   
       $comments[$count]["comment"]=format_comment($subrow["text"]);
       $count++;
        }
     unset($subrow);
     unset($subres);
}

$torrenttpl->set("current_username",$CURUSER["username"]);


if ($CURUSER["delete_comments"]=="yes")    
     $torrenttpl->set("MASSDEL_COMMENTS",TRUE,TRUE);
      else 
	  $torrenttpl->set("MASSDEL_COMMENTS",FALSE,TRUE);

} else $torrenttpl->set("VIEW_COMMENTS",FALSE,TRUE);
      
    
if ($GLOBALS["usepopup"])
    $torrenttpl->set("torrent_footer","<a href=\"javascript: window.close();\">".$language["CLOSE"]."</a>");
else
    $torrenttpl->set("torrent_footer","<a href=\"javascript: history.go(-1);\">".$language["BACK"]."</a>");
	  
if ($row["imdb"]==0){
$searchit="No IMDB ID been added..";
$extra="";
}
else{
$frameit="<script type=\"text/javascript\" language=\"JavaScript\">

     function autoIframe(frameId){
     var newheight
              try{
                newheight = document.getElementById(frameId).contentWindow.document.body.scrollHeight;
                document.getElementById(frameId).height = newheight + 30;
              }
                catch(err){
                window.status = err.message;
              }
     }


     function autoResize(id){

     var newheight;

     if (!window.opera && !document.mimeType && document.all && document.getElementById){

     newheight=document.getElementById(id).contentWindow.document.body.offsetHeight;

     }else if(document.getElementById){

     newheight=document.getElementById(id).contentWindow.document.body.scrollHeight;

     }

     document.getElementById(id).height= (newheight + 30) + \"px\";

     }

     </script>
     <noscript>".
     err_msg($language["ERROR"], "Resizable window will not work without Javascript.<br />Please enable Javascript or view the Info in a new window <a target='_new' href='$BASEURL/imbd.php'>Here</a>")
     ."</noscript>";
$searchit= "<iframe id=\"online_ifrm\" onload=\"autoIframe('online_ifrm')\" src=\"getimdb.php?mid=$row[imdb]\" scrolling=\"no\" frameborder=\"no\" frameborder=\"false\" width=100%></iframe>";

$extra="<tr>
          <td align=\"right\" class=\"header\" valign=\"top\">IMDB Extra</td>
          <td class=\"lista\" align=\"center\"><center><a href=\"javascript: void(0)\" 
   onclick=\"window.open('$BASEURL/imdb/imdb.php?mid=<tag:torrent.imdb />','windowname1','width=600, height=400,scrollbars=yes'); 
return false;\">More.Info</a>
&nbsp;&nbsp;<a href=\"javascript: void(0)\" 
   onclick=\"window.open('$BASEURL/imdb/search.php','windowname1','width=600,height=400,scrollbars=yes'); 
return false;\">Search</a></center></td>
        </tr>";
}

$torrenttpl->set("extra",$extra);
$torrenttpl->set("searchit",$searchit);
$torrenttpl->set("frameit",$frameit);

// subtitles begin
$sres=do_sqlquery("SELECT IFNULL(flagpic,'unknown.gif') as flag, s.name, c.name as flagname, s.id FROM {$TABLE_PREFIX}subtitles s LEFT JOIN {$TABLE_PREFIX}countries c ON s.flag=c.id WHERE hash='$id'",true);
if (mysqli_num_rows($sres)>0)
   {
   $torrenttpl->set("HAVE_SUBTITLE",true,true);
   $sub=array();
   $i=0;
   while ($srow = mysqli_fetch_assoc($sres))
         {
         $sub[$i]['name']="<a href=\"subtitle_download.php?id=".$srow['id']."\">".$srow['name']."</a>";
         $sub[$i]['flag']='<img src="images/flag/'.$srow['flag'].'" title="'.$srow['flagname'].'" alt="'.$srow['flagname'].'"/>';
         $i++;
   }
   $torrenttpl->set('subs',$sub);
   unset($sub);
}
else
   $torrenttpl->set("HAVE_SUBTITLE",false,true);

((mysqli_free_result($sres) || (is_object($sres) && (get_class($sres) == "mysqli_result"))) ? true : false);
// subtitles end

// language
if ($btit_settings["uplang"]==true ) 
{
$customlang=$btit_settings["customlang"];
$customflag=$btit_settings["customflag"]; 
$customlanga=$btit_settings["customlanga"];
$customflaga=$btit_settings["customflaga"]; 
$customlangb=$btit_settings["customlangb"];
$customflagb=$btit_settings["customflagb"]; 
$customlangc=$btit_settings["customlangc"];
$customflagc=$btit_settings["customflagc"]; 

if ($row["language"] == "0") {
$torrenttpl->set("language","<img src=\"images/flag/unknown.gif\" alt=\"Unknown\" title=\"Unknown\">");
} else if ($row["language"] == "1") {
$torrenttpl->set("language","<img src=\"images/flag/gb.png\" alt=\"English\" title=\"English\">");
} else if ($row["language"] == "2") {
$torrenttpl->set("language","<img src=\"images/flag/fr.png\" alt=\"French\" title=\"French\">");
} else if ($row["language"] == "3") {
$torrenttpl->set("language","<img src=\"images/flag/nl.png\" alt=\"Dutch\" title=\"Dutch\">");
} else if ($row["language"] == "4") {
$torrenttpl->set("language","<img src=\"images/flag/de.png\" alt=\"German\" title=\"German\">");
} else if ($row["language"] == "5") {
$torrenttpl->set("language","<img src=\"images/flag/es.png\" alt=\"Spanish\" title=\"Spanish\">");
} else if ($row["language"] == "6") {
$torrenttpl->set("language","<img src=\"images/flag/it.png\" alt=\"Italian\" title=\"Italian\">");
} else if ($row["language"] == "7") {
$torrenttpl->set("language","<img src=\"images/flag/$customflag.png\" alt=\"$customlang\" title=\"$customlang\">");
} else if ($row["language"] == "8") {
$torrenttpl->set("language","<img src=\"images/flag/$customflaga.png\" alt=\"$customlanga\" title=\"$customlanga\">");
} else if ($row["language"] == "9") {
$torrenttpl->set("language","<img src=\"images/flag/$customflagb.png\" alt=\"$customlangb\" title=\"$customlangb\">");
} else if ($row["language"] == "10") {
$torrenttpl->set("language","<img src=\"images/flag/$customflagc.png\" alt=\"$customlangc\" title=\"$customlangc\">");
}
}
if ($btit_settings["uplang"]==true )
    $torrenttpl->set("uplo",true,FALSE);
else
   $torrenttpl->set("uplo",false,TRUE);
// language 
$torrenttpl->set("torrent",$row);
$torrenttpl->set("comments",$comments);
$torrenttpl->set("files",$dfiles);

$torrenttpl-> set("wish","<a href=index.php?page=bookmark&do=add&torrent_id=".$id."><font color=green><img src='images/bookmark2.png'></font></a>");

//Hack made by hasu
$tellen = 0;
$tell = 0;

    $blasd = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(points) FROM {$TABLE_PREFIX}coins WHERE info_hash=".sqlesc($id));
    while($sdsa = mysqli_fetch_array($blasd)){
    $tellen = $sdsa['SUM(points)']or $tellen = 0;
    $lasd = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT points FROM {$TABLE_PREFIX}coins WHERE info_hash=".sqlesc($id)." AND userid=" .sqlesc($CURUSER["uid"]));
    $dsa = mysqli_fetch_assoc($lasd); 
    $tell = $dsa['points']or $tell = 0;
    }
   
 $torrenttpl->set("coin", "In Total <b><font color=red>" . $tellen . "</b></font> Points given to this torrent of which <b><font color=red>" . $tell . "</b></font> from you.<br /><br />By clicking on the coins you can give points to the uploader of this torrent.<br /><br />
    <a href='index.php?page=coins&id=$id&amp;points=10&amp;ix=$CURUSER[uid]'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <img src='images/10coin.png' alt='10 Points' title='10 Points' border='0' /></a>
    &nbsp;<a href='index.php?page=coins&id=$id&amp;points=20&amp;ix=$CURUSER[uid]'>
    <img src='images/20coin.png' alt='20 Points' title='20 Points' border='0' /></a>
    &nbsp;<a href='index.php?page=coins&id=$id&amp;points=50&amp;ix=$CURUSER[uid]'>
    <img src='images/50coin.png' alt='50 Points' title='50 Points' border='0' /></a>
    &nbsp;<a href='index.php?page=coins&id=$id&amp;points=100&amp;ix=$CURUSER[uid]'>
    <img src='images/100coin.png' alt='100 Points' title='100 Points' border='0' /></a>
    &nbsp;<a href='index.php?page=coins&id=$id&amp;points=200&amp;ix=$CURUSER[uid]'>
    <img src='images/200coin.png' alt='200 Points' title='200 Points' border='0' /></a>
    &nbsp;<a href='index.php?page=coins&id=$id&amp;points=500&amp;ix=$CURUSER[uid]'>
    <img src='images/500coin.png' alt='500 Points' title='500 Points' border='0' /></a>
    &nbsp;<a href='index.php?page=coins&id=$id&amp;points=1000&amp;ix=$CURUSER[uid]'>
    <img src='images/1000coin.png' alt='1000 Points' title='1000 Points' border='0' /></a>", 1);
    
//Hack made by hasu

$torrenttpl->set("YOUTUBE",($row["youtube_video"]!=""?true:false),true);
?>