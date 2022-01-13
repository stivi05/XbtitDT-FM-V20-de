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

global $CURUSER,$BASEURL, $STYLEPATH, $dblist, $XBTT_USE,$btit_settings;
if (!$CURUSER || $CURUSER["view_torrents"]=="no")
   {
    // do nothing
   }
else
    {
// all torrent block
print("<form name=\"jump2\" action=\"index.php\" method=\"post\">\n");
$tblock[0]["id"]="last";
$tblock[0]["tblock"]="Last Torrents";
$tblock[1]["id"]="top";
$tblock[1]["tblock"]="Top Torrents";
$tblock[2]["id"]="seed";
$tblock[2]["tblock"]="Seed Wanted";
// all torrent block end  

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

$stickyorder="f.sticky DESC, ";
print"<table align = center  width=100%><td style=\"text-align:center;\"><a href=index.php?page=grabbed><center><img src=\"images/grabbed.png\" /></a></td>";

// all torrent block
print("\n<td style=\"text-align:center;\"><select name=\"tblock\" size=\"1\" onchange=\"location=document.jump2.tblock.options[document.jump2.tblock.selectedIndex].value\">");
foreach($tblock as $a)
               {
               print("<option ");
               if ($a["id"]==$CURUSER["tor"])
                  print("selected=\"selected\"");
              print(" value=\"account_change.php?tblock=".$a["id"]."&amp;returnto=".urlencode($_SERVER['REQUEST_URI'])."\">".$a["tblock"]."</option>");
               }
print("</select></td></center></table></form>");
// all torrent block end  
  ?>

<table cellpadding="4" cellspacing="1" width="100%">
  <?php
  
if ($XBTT_USE)
    $rowcat = do_sqlquery("SELECT u.id, (u.downloaded+IFNULL(x.downloaded,0)) as downloaded, ((u.uploaded+IFNULL(x.uploaded,0))/(u.downloaded+IFNULL(x.downloaded,0))) as uratio, cp.* FROM {$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
else
    $rowcat = do_sqlquery("SELECT u.id, u.downloaded, (u.uploaded/u.downloaded) as uratio, cp.* FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  if (mysqli_num_rows($rowcat)>0)
     while ($catdata=mysqli_fetch_array($rowcat))
             if($catdata["viewtorrlist"]!="yes" && (($catdata["downloaded"]>=$GLOBALS["download_ratio"] && ($catdata["ratio"]>$catdata["uratio"]))||($catdata["downloaded"]<$GLOBALS["download_ratio"])||($catdata["ratio"]=="0")))
                $exclude.=' AND f.category!='.$catdata[catid];
  
// all torrent block
if($CURUSER['tor']=='last' or $CURUSER['tor']=='')
{
   if ($XBTT_USE)
     $sql = "SELECT f.team,f.imdb,f.multiplier, f.happy as happy, f.gold as gold,  f.image as img ,f.sticky ,f.vip_torrent,f.free as free, f.info_hash as hash, f.seeds+ifnull(x.seeders,0) as seeds , f.leechers + ifnull(x.leechers,0) as leechers, dlbytes AS dwned, format(f.finished+ifnull(x.completed,0),0) as finished, filename, url, info, UNIX_TIMESTAMP(data) AS added, c.image, c.name AS cname, category AS catid, size, external, uploader FROM {$TABLE_PREFIX}files as f LEFT JOIN xbt_files x ON f.bin_hash=x.info_hash LEFT JOIN {$TABLE_PREFIX}categories as c ON c.id = f.category WHERE f.leechers + ifnull(x.leechers,0) + f.seeds+ifnull(x.seeders,0) > 0 $exclude AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) $where  ORDER BY $stickyorder data DESC LIMIT " . $GLOBALS["block_last10limit"];
    else
     $sql = "SELECT f.team,f.imdb,f.multiplier, f.happy as happy ,f.gold as gold,  f.image as img ,f.sticky ,vip_torrent,f.free as free, info_hash as hash, seeds, leechers, dlbytes AS dwned, format(finished,0) as finished, filename, url, info, UNIX_TIMESTAMP(data) AS added, c.image, c.name AS cname, category AS catid, size, external, uploader FROM {$TABLE_PREFIX}files as f LEFT JOIN {$TABLE_PREFIX}categories as c ON c.id = f.category WHERE leechers + seeds > 0 $exclude AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) $where  ORDER BY $stickyorder data DESC LIMIT " . $GLOBALS["block_last10limit"];
}     
if($CURUSER['tor']=='top')
{
  if ($XBTT_USE)
     $sql = "SELECT f.team,f.imdb,f.multiplier,f.happy as happy, f.gold as gold,f.image as img ,f.sticky ,f.vip_torrent,f.free as free,f.info_hash as hash, f.seeds+ifnull(x.seeders,0) as seeds , f.leechers + ifnull(x.leechers,0) as leechers, dlbytes AS dwned, format(f.finished+ifnull(x.completed,0),0) as finished, filename, url, info, UNIX_TIMESTAMP(data) AS added, c.image, c.name AS cname, category AS catid, size, external, uploader FROM {$TABLE_PREFIX}files as f LEFT JOIN xbt_files x ON f.bin_hash=x.info_hash LEFT JOIN {$TABLE_PREFIX}categories as c ON c.id = f.category WHERE f.leechers + ifnull(x.leechers,0) + f.seeds+ifnull(x.seeders,0) > 0 $exclude AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) $where   ORDER BY $stickyorder CAST(finished AS UNSIGNED)+ifnull(x.completed,0) DESC LIMIT " .  $GLOBALS["block_last10limit"];
  else
     $sql = "SELECT f.team,f.imdb,f.multiplier,f.happy as happy, f.gold as gold,f.image as img ,f.sticky ,vip_torrent,f.free as free,info_hash as hash, seeds, leechers, dlbytes AS dwned, format(finished,0) as finished, filename, url, info, UNIX_TIMESTAMP(data) AS added, c.image, c.name AS cname, category AS catid, size, external, uploader FROM {$TABLE_PREFIX}files as f LEFT JOIN {$TABLE_PREFIX}categories as c ON c.id = f.category WHERE leechers + seeds > 0 $exclude AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) $where  ORDER BY $stickyorder CAST(finished AS UNSIGNED) DESC LIMIT " .  $GLOBALS["block_last10limit"];
}
if($CURUSER['tor']=='seed')
{ 
   if ($XBTT_USE)
     $sql = "SELECT f.team,f.imdb,f.multiplier,f.happy as happy, f.gold as gold, f.image as img ,f.sticky ,f.vip_torrent,f.free as free,f.info_hash as hash, f.seeds+ifnull(x.seeders,0) as seeds , f.leechers + ifnull(x.leechers,0) as leechers, dlbytes AS dwned, format(f.finished+ifnull(x.completed,0),0) as finished, filename, url, info, UNIX_TIMESTAMP(data) AS added, c.image, c.name AS cname, category AS catid, size, external, uploader FROM {$TABLE_PREFIX}files as f LEFT JOIN xbt_files x ON f.bin_hash=x.info_hash LEFT JOIN {$TABLE_PREFIX}categories as c ON c.id = f.category WHERE f.leechers + ifnull(x.leechers,0) > 0 $exclude AND f.seeds+ifnull(x.seeders,0)= 0 AND f.external='no' AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) $where  ORDER BY $stickyorder f.leechers + ifnull(x.leechers,0) DESC LIMIT " . $GLOBALS["block_last10limit"];
  else
     $sql = "SELECT f.team,f.imdb,f.multiplier,f.happy as happy, f.gold as gold, f.image as img ,f.sticky ,vip_torrent,f.free as free,info_hash as hash, seeds, leechers, dlbytes AS dwned, finished, filename, url, info, UNIX_TIMESTAMP(data) AS added, c.image, c.name AS cname, category AS catid, size, external, uploader FROM {$TABLE_PREFIX}files as f LEFT JOIN {$TABLE_PREFIX}categories as c ON c.id = f.category WHERE leechers >0 AND seeds = 0 AND external='no' $exclude AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) $where  ORDER BY $stickyorder leechers DESC LIMIT " . $GLOBALS["block_last10limit"];
}    
// all torrent block end   
     $row = get_result($sql,true,$btit_settings['cache_duration']);
  ?>
  <tr>
      <td align="center" width="20" class="header">&nbsp;<?php echo $language["DOWN"]; ?>&nbsp;</td>
      <td align="center" width="20" class="header">&nbsp;<?php echo $language["ADDB"]; ?>&nbsp;</td>
    <td align="center" width="55%" class="header">&nbsp;<?php echo $language["TORRENT_FILE"]; ?>&nbsp;</td>
    
    <td align="center" width="45" class="header">&nbsp;<?php echo $language["CATEGORY"]; ?>&nbsp;</td>
<?php
if (max(0,$CURUSER["WT"])>0)
    print("<td align=\"center\" width=\"20\" class=\"header\">&nbsp".$language["WT"]."&nbsp;</td>");
?>
    <td align="center" width="85" class="header">&nbsp;<?php echo $language["ADDED"]; ?>&nbsp;</td>
    <td align="center" width="60" class="header">&nbsp;<?php echo $language["SIZE"]; ?>&nbsp;</td>
    <td align="center" width="30" class="header">&nbsp;<?php echo $language["SHORT_S"]; ?>&nbsp;</td>
    <td align="center" width="30" class="header">&nbsp;<?php echo $language["SHORT_L"]; ?>&nbsp;</td>
    <td align="center" width="40" class="header">&nbsp;<?php echo $language["SHORT_C"]; ?>&nbsp;</td>
  </tr>
  <?php

  if ($row)
  {
      foreach ($row as $id=>$data)
      {
      if(getmoderstatusbyhash($data['hash'])=='ok')
	      	{echo "<tr>";
          if ( strlen($data["hash"]) > 0 )
          {
      echo "\n\t<td align=\"center\" class=\"lista\" width=\"20\" style=\"text-align: center;\">";
      echo "<a class=\"lasttor\" href=\"download.php?id=".$data["hash"]."&amp;f=" . rawurlencode($data["filename"]) . ".torrent\"><img src='images/torrent.png' border='0' alt='".$language["DOWNLOAD_TORRENT"]."' title='".$language["DOWNLOAD_TORRENT"]."' /></a>";
      echo "</td>";
      echo "\n\t<td align=\"center\" class=\"lista\" width=\"20\" style=\"text-align: center;\"><a href=index.php?page=bookmark&do=add&torrent_id=".$data["hash"]."><img src=\"images/bookmark.png\" /></a></TD>";

       $data["filename"]=unesc($data["filename"]);
       $filename=cut_string($data["filename"],intval($btit_settings["cut_name"]));
// team       
       $fteam=$data["team"];
       if(isset($fteam) && !empty($fteam))
       {
       $teamshit="SELECT name, image, id FROM {$TABLE_PREFIX}teams where id=".$fteam;
       $rim=do_sqlquery($teamshit) or err_msg($language["ERROR"],$language["CANT_DO_QUERY"].((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
       $datat=mysqli_fetch_array($rim);
       $team="<a href='index.php?page=modules&amp;module=team&team=".$datat["id"]."'><img src=\"".$datat["image"]."\" border=\"0\" title=\"".$datat["name"]."\"></a>";
   }
   else
   $team="";
// team   
 
//multiplier      
	  if($data['multiplier']>1) {
    $mult = "<img alt=\"".$data['multiplier']."x Upload Multiplier\" src=\"images/".$data['multiplier']."x.gif\" />";
   } else 
   $mult=""; 
//multiplier  
   
//gold mod
     $silver_picture='';
     $gold_picture ='';
     $res=get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'",true);
            foreach ($res as $key=>$value)
            {
                $silver_picture = $value["silver_picture"];
                $gold_picture = $value["gold_picture"];
            }
        $gold ='';
        if($data['gold'] == 1)
        $gold = '<img src="gold/'.$silver_picture.'" alt="silver"/>';
        
        if($data['gold'] == 2)
        $gold = '<img src="gold/'.$gold_picture.'" alt="gold"/>';
//end gold mod
        
//free leech hack
    $free='';
    if($data['free'] == yes OR $data['happy']== yes)
    $free = '<img src="images/freeleech.gif" alt="free leech"/>';
// end free leech

//vip_torrent start
      if($data["vip_torrent"]==1) {
$vt = "<img src=images/vip.gif alt='vip only torrent'>";
}
else   
$vt='';
//vip_torrent end
          
$sticky = ($data[sticky]=="1" ? "<img src='images/sticky.gif' bored='0' alt='sticky'>" : "");

// start grabbed
$dl="";
$res_user=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT pid FROM {$TABLE_PREFIX}users WHERE id='".$CURUSER["uid"]."'")or sqlerr();
$row_user=mysqli_fetch_array($res_user);

$res_load =do_sqlquery("SELECT * FROM {$TABLE_PREFIX}down_load WHERE pid='".$row_user["pid"]."'")or sqlerr();
if ($res_load)
{

         $ia=0;
         while ($row_load=mysqli_fetch_array($res_load))
	{

if ($row_load["hash"]==$data["hash"])
{
$dl="<img src='images/downloaded.gif' alt='Allready Grabbed !!' title='Allready Grabbed !!' />";
 $ia++;
}
}
}
// end grabbed

// torrents after last visit
if(isset($CURUSER["lastconnect"])){
 $filetime =  date("YmdHis",$data["added"]);
 $lastseen = date("YmdHis",$CURUSER["lastconnect"]);
if ($lastseen <= $filetime) {
  $is_new = "<img src=images/new.png>";
}
else { $is_new='';
}
}
// torrents after last visit

// imdb mousehover image
if ($btit_settings["imdbmh"]==true and $data["imdb"]!= "" )
{ 
require_once ("imdb/imdb.class.php");
  $tdt="";
  $movie = new imdb($data["imdb"]);
  $movie->photodir='./imdb/images/';
  $movie->photoroot='./imdb/images/';
  
if (($photo_url = $movie->photo_localurl() ) != FALSE)
  $balon= $photo_url;
} 
else
{
if ($btit_settings["imgsw"]==false ) 
$tdt="";
else
$tdt="torrentimg/";

// Start baloon hack DT
$hover=($data["img"]);
if ($hover=="")
 $balon=("nocover.jpg");
 else
 $balon =($data["img"]);
// End baloon hack DT
}
// imdb mousehover image

if ($GLOBALS["usepopup"])
          echo "\n\t<td width=\"55%\" class=\"lista\" style=\"padding-left:10px;\"><a class=\"lasttor\" href=\"javascript:popdetails('index.php?page=torrent-details&amp;id=" . $data['hash'] . "');\" title=\"" . $language["VIEW_DETAILS"] . ": " . $data["filename"] . "\"onmouseover=\" return overlib('<center>".$filename."</center><center><img src=" .$tdt. $balon . "  width=200 border=0></center><center>Category: ".$data["cname"]." Size: " . makesize($data["size"]) . "</center><center>Added:" . get_elapsed_time($data["added"]) . " ago</center><center><font color = green>Seeders: " . $data["seeds"] . "<font color = red> Leechers: " .$data["leechers"] . "<font color = purple> Done: " . $data["finished"] . "</font></center>', CENTER);\" onmouseout=\"return nd();\">".$filename.$mult.$gold.$free.$vt.$sticky.$dl.$is_new.$team. "</a>".($data["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")."</td>";
       else
          echo "\n\t<td width=\"55%\" class=\"lista\" style=\"padding-left:10px;\"><a class=\"lasttor\" href=\"index.php?page=torrent-details&amp;id=" . $data['hash'] . "\" title=\"" . $language["VIEW_DETAILS"]. ": " . $data["filename"] . "\"onmouseover=\" return overlib('<center>".$filename."</center><center><img src=" .$tdt. $balon . "  width=200 border=0></center><center>Category: ".$data["cname"]." Size: " . makesize($data["size"]) . "</center><center>Added:" . get_elapsed_time($data["added"]) . " ago</center><center><font color = green>Seeders: " . $data["seeds"] . "<font color = red> Leechers: " .$data["leechers"] . "<font color = purple> Done: " . $data["finished"] . "</font></center> ', CENTER);\" onmouseout=\"return nd();\">".$filename.$mult.$gold.$free.$vt.$sticky.$dl.$is_new.$team. "</a>".($data["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")."</td>";
       echo "\n\t<td align=\"center\" class=\"lista\" width=\"45\" style=\"text-align: center;\"><a class=\"lasttor\" href=\"index.php?page=torrents&amp;category=$data[catid]\">" . image_or_link( ($data["image"] == "" ? "" : "$STYLEPATH/images/categories/" . $data["image"]), "", $data["cname"]) . "</a></td>";

//waitingtime

// only if current user is limited by WT
    if (max(0,$CURUSER["WT"])>0)
        {
          $wait=0;

          if (max(0,$CURUSER['downloaded'])>0) $ratio=number_format($CURUSER['uploaded']/$CURUSER['downloaded'],2);
          else $ratio=0.0;

          $vz = $data['added']; 
          $timer = floor((time() - $vz) / 3600);
          if($ratio<1.0 && $CURUSER['uid']!=$data["uploader"]){
              $wait=$CURUSER["WT"];
          }
          $wait -=$timer;
          if ($wait<=0)$wait=0;

          echo "\n\t<td align=\"center\" width=\"20\" class=\"lista\" style=\"text-align: center;\">".$wait." h</td>";
        }
//end waitingtime

// peers color by DT
    $pcl = 'background:#117700';		
    $pcs = 'background:#117700';	
    if ($data["seeds"]==0)
    $pcs = 'background:#FF0000';
	if ($data["leechers"]==0)
    $pcl = 'background:#FF0000';
	if ($data["seeds"]== 1 OR $data["seeds"]== 2)
    $pcs = 'background:#A9F5D0';	
	if ($data["leechers"]== 1 OR $data["leechers"] == 2)
    $pcl = 'background:#A9F5D0';	
	if ($data["seeds"]==3 OR $data["seeds"]==4)
    $pcs = 'background:#00FF80';		
	if ($data["leechers"]== 3 OR $data["leechers"] == 4)
    $pcl = 'background:#00FF80';	
// end peers color by DT

             echo "\n\t<td nowrap=\"nowrap\" class=\"lista\" align=\"center\" width=\"85\" style=\"text-align: center;\">" . get_elapsed_time($data["added"]) . " ago</td>";
             echo "\n\t<td nowrap=\"nowrap\" class=\"lista\" align=\"center\" width=\"60\" style=\"text-align: center;\">" . makesize($data["size"]) . "</td>";

           if ( $data["external"] == "no" )
            {
              if ($GLOBALS["usepopup"])
                {
                echo "\n\t<td align=\"center\" class=\"lista".linkcolor($data["seeds"])."\" style=\"text-align: center; ".$pcs."\"><a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$data["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">" . $data["seeds"] . "</a></td>\n";
                echo "\n\t<td align=\"center\" class=\"lista".linkcolor($data["leechers"])."\" style=\"text-align: center;".$pcl."\"><a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$data["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">" .$data["leechers"] . "</a></td>\n";
                if ($data["finished"]>0)
                   echo "\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a class=\"lasttor\" href=\"javascript:poppeer('index.php?page=torrent_history&amp;id=".$data["hash"]."');\" title=\"History - ".$data["filename"]."\">" . $data["finished"] . "</a></td>";
                else
                    echo "\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\">---</td>";

                }
              else
                {
                echo "\n\t<td align=\"center\" class=\"lista".linkcolor($data["seeds"])."\" style=\"text-align: center;".$pcs."\"><a href=\"index.php?page=peers&amp;id=".$data["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">" . $data["seeds"] . "</a></td>\n";
                echo "\n\t<td align=\"center\" class=\"lista".linkcolor($data["leechers"])."\" style=\"text-align: center;".$pcl."\"><a href=\"index.php?page=peers&amp;id=".$data["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">" .$data["leechers"] . "</a></td>\n";
                if ($data["finished"]>0)
                   echo "\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a class=\"lasttor\" href=\"index.php?page=torrent_history&amp;id=".$data["hash"]."\" title=\"History - ".$data["filename"]."\">" . $data["finished"] . "</a></td>";
                else
                    echo "\n\t<td align=\"center\" class=\"lista\">---</td>";

                }
            }
           else
             {
               // linkcolor
               echo "\n\t<td align=\"center\" width=\"30\" class=\"".linkcolor($data["seeds"])."\" style=\"text-align: center;".$pcs."\">" . $data["seeds"] . "</td>";
               echo "\n\t<td align=\"center\" width=\"30\" class=\"".linkcolor($data["leechers"])."\" style=\"text-align: center;".$pcl."\">" .$data["leechers"] . "</td>";
               if ($data["finished"]>0)
                  echo "\n\t<td align=\"center\" width=\"40\" class=\"lista\" style=\"text-align: center;\">" . $data["finished"] . "</td>";
               else
                   echo "\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\">---</td>";

        }
           echo "</tr>\n";
           }
	
	}
//end of getmoderstatusbyhash($data['hash'])=='ok'
	}
  }
  else
  {
    echo "\n<tr><td class=\"lista\" colspan=\"9\" align=\"center\" style=\"text-align: center;\">" . $language["NO_TORRENTS"] . "</td></tr>";
  }

  print("\n</table>");

} // end if user can view
?>