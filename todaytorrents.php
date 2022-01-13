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

global $BASEURL, $STYLEPATH, $dblist, $XBTT_USE,$btit_settings;

if (!$CURUSER || $CURUSER["view_torrents"]=="no")
   {
       err_msg($language["ERROR"],$language["NOT_AUTHORIZED"]." ".$language["TORRENTS"]."!");
       stdfoot();
       exit;
   }
else
    {

dbconn();
$midnight = date("Y-m-d 00:00:00");
$todaytorrentstpl=new bTemplate();
$todaytorrentstpl->set("language",$language);
$action = $_GET["action"];


  if ($XBTT_USE)
     $sql = "SELECT f.moder,f.data, f.anonymous, f.info_hash as hash, f.seeds+ifnull(x.seeders,0) as seeds , f.leechers + ifnull(x.leechers,0) as leechers, dlbytes AS dwned, format(f.finished+ifnull(x.completed,0),0) as finished, filename, url, info, UNIX_TIMESTAMP(data) AS added, c.image, c.name AS cname, category AS catid, size, external, uploader FROM {$TABLE_PREFIX}files as f LEFT JOIN xbt_files x ON f.bin_hash=x.info_hash LEFT JOIN {$TABLE_PREFIX}categories as c ON c.id = f.category WHERE data >='$midnight' and f.moder='ok' ORDER BY data DESC LIMIT 1000";
  else
     $sql = "SELECT moder ,data, anonymous, info_hash as hash, seeds, leechers, dlbytes AS dwned, format(finished,0) as finished, filename, url, info, UNIX_TIMESTAMP(data) AS added, c.image, c.name AS cname, category AS catid, size, external, uploader FROM {$TABLE_PREFIX}files as f LEFT JOIN {$TABLE_PREFIX}categories as c ON c.id = f.category WHERE data >='$midnight' and moder='ok' ORDER BY data DESC LIMIT 1000";

     $row = do_sqlquery($sql) or err_msg($language["ERROR"],$language["CANT_DO_QUERY"].((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  $todaytorrentstpl->set("rp0.9","<br>");
  $todaytorrentstpl->set("rp0.10","<tr><td colspan=\"9\" align=\"center\" class=\"block\"><b>Today,s Torrents</td></tr>");
  $todaytorrentstpl->set("rp0","<tr>");
  $todaytorrentstpl->set("rp1","<td align=\"center\" width=\"20\" class=\"header\">".$language["DOWN"]."</td>");
  $todaytorrentstpl->set("rp2","<td align=\"center\" width=\"55%\" class=\"header\">".$language["TORRENT_FILE"]."</td>");
  $todaytorrentstpl->set("rp3","<td align=\"center\" width=\"45\" class=\"header\">".$language["CATEGORY"]."</td>");
  $todaytorrentstpl->set("rp3.1","<td align=\"center\" width=\"85\" class=\"header\">".$language["ADDED"]."</td>");
  $todaytorrentstpl->set("rp4","<td align=\"center\" width=\"75\" class=\"header\">".$language["UPLOADER"]."</td>");
  $todaytorrentstpl->set("rp5","<td align=\"center\" width=\"60\" class=\"header\">".$language["SIZE"]."</td>");
  $todaytorrentstpl->set("rp6","<td align=\"center\" width=\"30\" class=\"header\">".$language["SHORT_S"]."</td>");
  $todaytorrentstpl->set("rp7","<td align=\"center\" width=\"30\" class=\"header\">".$language["SHORT_L"]."</td>");
  $todaytorrentstpl->set("rp8","<td align=\"center\" width=\"40\" class=\"header\">".$language["SHORT_C"]."</td>");
  $todaytorrentstpl->set("rp9","</tr>");


  if ($row )
  {
      while ($data=mysqli_fetch_array($row))
      {
      $todaytorrentstpl->set("rp10","<tr>");

          if ( strlen($data["hash"]) > 0 )
          {

       $data["filename"]=unesc($data["filename"]);
       $filename=cut_string($data["filename"],intval($btit_settings["cut_name"]));
       $new=" <img src=images/new1.gif>";

      $tora[$i]["rp12"]=("\n\t<td align=\"center\" class=\"lista\" width=\"20\" style=\"text-align: center;\"><a href=\"download.php?id=".$data["hash"]."&amp;f=" . rawurlencode($data["filename"]) . ".torrent\"><img src='images/torrent.gif' border='0' alt='".$language["DOWNLOAD_TORRENT"]."' title='".$language["DOWNLOAD_TORRENT"]."' /></a></td>");

       if ($GLOBALS["usepopup"])
          $tora[$i]["rp14"]=("\n\t<td width=\"55%\" class=\"lista\" style=\"padding-left:10px;\"><a href=\"javascript:popdetails('index.php?page=torrent-details&amp;id=" . $data['hash'] . "');\" title=\"" . $language["VIEW_DETAILS"] . ": " . $data["filename"] . "\">" . $filename . $new . "</a>".($data["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")."</td>");
       else
          $tora[$i]["rp15"]=("\n\t<td width=\"55%\" class=\"lista\" style=\"padding-left:10px;\"><a href=\"index.php?page=torrent-details&amp;id=" . $data['hash'] . "\" title=\"" . $language["VIEW_DETAILS"]. ": " . $data["filename"] . "\">" . $filename . $new . "</a>".($data["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")."</td>");
      $sum3++;

       $tora[$i]["rp16"]=("\n\t<td align=\"center\" class=\"lista\" width=\"45\" style=\"text-align: center;\">" . image_or_link( ($data["image"] == "" ? "" : "$STYLEPATH/images/categories/" . $data["image"]), "", $data["cname"]) . "</td>");
    //waitingtime
    // only if current user is limited by WT
    if (max(0,$CURUSER["WT"])>0)
        {
          $wait=0;
          $resuser=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER["uid"]);
          $rowuser=mysqli_fetch_array($resuser);
          if (max(0,$rowuser['downloaded'])>0) $ratio=number_format($rowuser['uploaded']/$rowuser['downloaded'],2);
          else $ratio=0.0;
          $res2 =do_sqlquery("SELECT * FROM {$TABLE_PREFIX}files WHERE info_hash='".$data["hash"]."'");
          $added=mysqli_fetch_array($res2);
          $vz = sql_timestamp_to_unix_timestamp($added["data"]);
          $timer = floor((time() - $vz) / 3600);
          if($ratio<1.0 && $rowuser['id']!=$added["uploader"]){
              $wait=$CURUSER["WT"];
          }
          $wait -=$timer;
          if ($wait<=0)$wait=0;

          $tora[$i]["rp17"]=("\n\t<td align=\"center\" width=\"20\" class=\"lista\" style=\"text-align: center;\">".$wait." h</td>");
        }
    //end waitingtime

            $tora[$i]["rp18"]=("\n\t<td nowrap=\"nowrap\" class=\"lista\" align=\"center\" width=\"85\" style=\"text-align: center;\"><b><font color=darkgreen>Today</font></b><br>".$data["data"]."</td>");
   
$juz=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE id='$data[uploader]' ");
$juzr = mysqli_fetch_array($juz);
$bar=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users_level WHERE id='$juzr[id_level]' ");
$barva = mysqli_fetch_array($bar);
$ter2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE id = '$data[uploader]'");
$tart2 = mysqli_fetch_assoc($ter2);
   
   if ($data["anonymous"] == "true")
    $tora[$i]["rp18.1"]=("\n\t<td align=\"center\" width=\"20\" class=\"lista\" style=\"text-align: center;\">".$language["ANONYMOUS"]."</td>");
   else
   if ($data["anonymous"] == "false")
    $tora[$i]["rp18.2"]=("\n\t<td align=\"center\" width=\"20\" class=\"lista\" style=\"text-align: center;\"><a href=\"index.php?page=userdetails&amp;id=" . $data["uploader"] . "\">".$barva["prefixcolor"].$tart2[username].$barva["suffixcolor"]."</a></td>");
  
             $tora[$i]["rp19"]=("\n\t<td nowrap=\"nowrap\" class=\"lista\" align=\"center\" width=\"60\" style=\"text-align: center;\">" . makesize($data["size"]) . "</td>");
             $sum=$sum+$data["size"];


           if ( $data["external"] == "no" )
            {
              if ($GLOBALS["usepopup"])
                {
                $tora[$i]["rp20"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$data["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">" . $data["seeds"] . "</a></td>\n");
                $sum4=$sum4+$data["seeds"];
                $tora[$i]["rp21"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$data["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">" .$data["leechers"] . "</a></td>\n");
                $sum5=$sum5+$data["leechers"];
                if ($data["finished"]>0)
                   $tora[$i]["rp22"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"javascript:poppeer('index.php?page=torrent_history&amp;id=".$data["hash"]."');\" title=\"History - ".$data["filename"]."\">" . $data["finished"] . "</a></td>");
                else
                    $tora[$i]["rp23"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><center>---</td>");
                $sum6=$sum6+$data["finished"];
                }
              else
                {
                $tora[$i]["rp24"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"index.php?page=peers&amp;id=".$data["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">" . $data["seeds"] . "</a></td>\n");
                $sum4=$sum4+$data["seeds"];
                $tora[$i]["rp25"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"index.php?page=peers&amp;id=".$data["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">" .$data["leechers"] . "</a></td>\n");
                $sum5=$sum5+$data["leechers"];
                if ($data["finished"]>0)
                   $tora[$i]["rp26"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"index.php?page=torrent_history&amp;id=".$data["hash"]."\" title=\"History - ".$data["filename"]."\">" . $data["finished"] . "</a></td>");
                else
                    $tora[$i]["rp27"]=("\n\t<td align=\"center\" class=\"lista\"><center>---</td>");
                $sum6=$sum6+$data["finished"];
                }
            }
           else
             {
               // linkcolor
               $tora[$i]["rp28"]=("\n\t<td align=\"center\" width=\"30\" class=\"lista\" style=\"text-align: center;\">" . $data["seeds"] . "</td>");
               $sum4=$sum4+$data["seeds"];
               $tora[$i]["rp29"]=("\n\t<td align=\"center\" width=\"30\" class=\"lista\" style=\"text-align: center;\">" .$data["leechers"] . "</td>");
               $sum5=$sum5+$data["leechers"];
               if ($data["finished"]>0)
                  $tora[$i]["rp30"]=("\n\t<td align=\"center\" width=\"40\" class=\"lista\" style=\"text-align: center;\">" . $data["finished"] . "</td>");
               else
                   $tora[$i]["rp31"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><center>---</td>");
              $sum6=$sum6+$data["finished"];
        }
           $tora[$i]["rp32"]=("</tr>\n");
           $tora[$i]["rp32"]=("</tr>\n");
           
           $i++;
           }
           $todaytorrentstpl->set("tora",$tora);
      }
//   $suma2["celkem100"]="<tr><td colspan=\"8\" align=\"center\" class=\"block\"><b>Stats</td>";
   $suma["celkem2"]="<td class=\"lista\"align=\"center\"><center>".$sum3."</td>";
   if ($sum)
   $suma["celkem3"]="<td class=\"lista\"align=\"center\"><center>".makesize($sum)."</td>";
   $suma["celkem4"]="<td class=\"lista\"align=\"center\"><center><font color=limegreen>".$sum4."</font></td>";
   $suma["celkem5"]="<td class=\"lista\"align=\"center\"><center><font color=red>".$sum5."</font></td>";
   $suma["celkem6"]="<td class=\"lista\"align=\"center\"><center><font color=deeppink>".$sum6."</font></td></tr>";
   $todaytorrentstpl->set("suma",$suma);
  }
  else
  {
    $todaytorrentstpl->set("rp33","\n<tr><td class=\"lista\" colspan=\"9\" align=\"center\" style=\"text-align: center;\">" . $language["NO_TORRENTS"] . "</td></tr>");
  }

}

?>