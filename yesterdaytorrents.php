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

dbconn();
$vcera  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$predevcirem  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));

$yesterdaytorrentstpl=new bTemplate();
$yesterdaytorrentstpl->set("language",$language);

  if ($XBTT_USE)
     $sql = "SELECT f.moder, f.data, f.anonymous, f.info_hash as hash, f.seeds+ifnull(x.seeders,0) as seeds , f.leechers + ifnull(x.leechers,0) as leechers, dlbytes AS dwned, format(f.finished+ifnull(x.completed,0),0) as finished, filename, url, info, UNIX_TIMESTAMP(data) AS added, c.image, c.name AS cname, category AS catid, size, external, uploader FROM {$TABLE_PREFIX}files as f LEFT JOIN xbt_files x ON f.bin_hash=x.info_hash LEFT JOIN {$TABLE_PREFIX}categories as c ON c.id = f.category WHERE UNIX_TIMESTAMP(data) < '$vcera' AND UNIX_TIMESTAMP(data) > '$predevcirem' and f.moder='ok' ORDER BY data DESC LIMIT 1000";
  else
     $sql = "SELECT moder, data, anonymous, info_hash as hash, seeds, leechers, dlbytes AS dwned, format(finished,0) as finished, filename, url, info, UNIX_TIMESTAMP(data) AS added, c.image, c.name AS cname, category AS catid, size, external, uploader FROM {$TABLE_PREFIX}files as f LEFT JOIN {$TABLE_PREFIX}categories as c ON c.id = f.category WHERE UNIX_TIMESTAMP(data) < '$vcera' AND UNIX_TIMESTAMP(data) > '$predevcirem' and f.moder='ok' ORDER BY data DESC LIMIT 1000";

     $row = do_sqlquery($sql) or err_msg($language["ERROR"],$language["CANT_DO_QUERY"].((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  $yesterdaytorrentstpl->set("rp100","<br>");
  $yesterdaytorrentstpl->set("rp101","<tr><td colspan=\"9\" align=\"center\" class=\"block\"><b>Yesterday,s Torrents</td></tr>");
  $yesterdaytorrentstpl->set("rp102","<tr>");
  $yesterdaytorrentstpl->set("rp103","<td align=\"center\" width=\"20\" class=\"header\">".$language["DOWN"]."</td>");
  $yesterdaytorrentstpl->set("rp104","<td align=\"center\" width=\"55%\" class=\"header\">".$language["TORRENT_FILE"]."</td>");
  $yesterdaytorrentstpl->set("rp105","<td align=\"center\" width=\"45\" class=\"header\">".$language["CATEGORY"]."</td>");
  $yesterdaytorrentstpl->set("rp106","<td align=\"center\" width=\"85\" class=\"header\">".$language["ADDED"]."</td>");
  $yesterdaytorrentstpl->set("rp107","<td align=\"center\" width=\"75\" class=\"header\">".$language["UPLOADER"]."</td>");
  $yesterdaytorrentstpl->set("rp108","<td align=\"center\" width=\"60\" class=\"header\">".$language["SIZE"]."</td>");
  $yesterdaytorrentstpl->set("rp109","<td align=\"center\" width=\"30\" class=\"header\">".$language["SHORT_S"]."</td>");
  $yesterdaytorrentstpl->set("rp110","<td align=\"center\" width=\"30\" class=\"header\">".$language["SHORT_L"]."</td>");
  $yesterdaytorrentstpl->set("rp111","<td align=\"center\" width=\"40\" class=\"header\">".$language["SHORT_C"]."</td>");
  $yesterdaytorrentstpl->set("rp112","</tr>");


  if ($row )
  {
      while ($data=mysqli_fetch_array($row))
      {
      $yesterdaytorrentstpl->set("rp113","<tr>");

          if ( strlen($data["hash"]) > 0 )
          {

       $data["filename"]=unesc($data["filename"]);
       $filename=cut_string($data["filename"],intval($btit_settings["cut_name"]));

      $tora2[$i]["rp114"]=("\n\t<td align=\"center\" class=\"lista\" width=\"20\" style=\"text-align: center;\"><a href=\"download.php?id=".$data["hash"]."&amp;f=" . rawurlencode($data["filename"]) . ".torrent\"><img src='images/torrent.gif' border='0' alt='".$language["DOWNLOAD_TORRENT"]."' title='".$language["DOWNLOAD_TORRENT"]."' /></a></td>");

       if ($GLOBALS["usepopup"])
          $tora2[$i]["rp115"]=("\n\t<td width=\"55%\" class=\"lista\" style=\"padding-left:10px;\"><a href=\"javascript:popdetails('index.php?page=torrent-details&amp;id=" . $data['hash'] . "');\" title=\"" . $language["VIEW_DETAILS"] . ": " . $data["filename"] . "\">" . $filename . "</a>".($data["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")."</td>");
       else
          $tora2[$i]["rp116"]=("\n\t<td width=\"55%\" class=\"lista\" style=\"padding-left:10px;\"><a href=\"index.php?page=torrent-details&amp;id=" . $data['hash'] . "\" title=\"" . $language["VIEW_DETAILS"]. ": " . $data["filename"] . "\">" . $filename . "</a>".($data["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")."</td>");
      $sum3++;

       $tora2[$i]["rp117"]=("\n\t<td align=\"center\" class=\"lista\" width=\"45\" style=\"text-align: center;\">" . image_or_link( ($data["image"] == "" ? "" : "$STYLEPATH/images/categories/" . $data["image"]), "", $data["cname"]) . "</td>");
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

          $tora2[$i]["rp118"]=("\n\t<td align=\"center\" width=\"20\" class=\"lista\" style=\"text-align: center;\">".$wait." h</td>");
        }
    //end waitingtime

            $tora2[$i]["rp119"]=("\n\t<td nowrap=\"nowrap\" class=\"lista\" align=\"center\" width=\"85\" style=\"text-align: center;\"><b><font color=red>Yesterday</font></b><br>".$data["data"]."</td>");
   
$juz=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE id='$data[uploader]' ");
$juzr = mysqli_fetch_array($juz);
$bar=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users_level WHERE id='$juzr[id_level]' ");
$barva = mysqli_fetch_array($bar);
$ter2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username FROM {$TABLE_PREFIX}users WHERE id = '$data[uploader]'");
$tart2 = mysqli_fetch_assoc($ter2);
   
   if ($data["anonymous"] == "true")
    $tora2[$i]["rp120"]=("\n\t<td align=\"center\" width=\"20\" class=\"lista\" style=\"text-align: center;\">".$language["ANONYMOUS"]."</td>");
   else
   if ($data["anonymous"] == "false")
    $tora2[$i]["rp121"]=("\n\t<td align=\"center\" width=\"20\" class=\"lista\" style=\"text-align: center;\"><a href=\"index.php?page=userdetails&amp;id=" . $data["uploader"] . "\">".$barva["prefixcolor"].$tart2[username].$barva["suffixcolor"]."</a></td>");
  
             $tora2[$i]["rp122"]=("\n\t<td nowrap=\"nowrap\" class=\"lista\" align=\"center\" width=\"60\" style=\"text-align: center;\">" . makesize($data["size"]) . "</td>");
             $sum=$sum+$data["size"];


           if ( $data["external"] == "no" )
            {
              if ($GLOBALS["usepopup"])
                {
                $tora2[$i]["rp123"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$data["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">" . $data["seeds"] . "</a></td>\n");
                $sum4=$sum4+$data["seeds"];
                $tora2[$i]["rp124"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$data["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">" .$data["leechers"] . "</a></td>\n");
                $sum5=$sum5+$data["leechers"];
                if ($data["finished"]>0)
                   $tora2[$i]["rp125"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"javascript:poppeer('index.php?page=torrent_history&amp;id=".$data["hash"]."');\" title=\"History - ".$data["filename"]."\">" . $data["finished"] . "</a></td>");
                else
                    $tora2[$i]["rp126"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><center>---</td>");
                $sum6=$sum6+$data["finished"];
                }
              else
                {
                $tora2[$i]["rp127"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"index.php?page=peers&amp;id=".$data["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">" . $data["seeds"] . "</a></td>\n");
                $sum4=$sum4+$data["seeds"];
                $tora2[$i]["rp128"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"index.php?page=peers&amp;id=".$data["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">" .$data["leechers"] . "</a></td>\n");
                $sum5=$sum5+$data["leechers"];
                if ($data["finished"]>0)
                   $tora2[$i]["rp129"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><a href=\"index.php?page=torrent_history&amp;id=".$data["hash"]."\" title=\"History - ".$data["filename"]."\">" . $data["finished"] . "</a></td>");
                else
                    $tora2[$i]["rp130"]=("\n\t<td align=\"center\" class=\"lista\"><center>---</td>");
                $sum6=$sum6+$data["finished"];
                }
            }
           else
             {
               // linkcolor
               $tora2[$i]["rp131"]=("\n\t<td align=\"center\" width=\"30\" class=\"lista\" style=\"text-align: center;\">" . $data["seeds"] . "</td>");
               $sum4=$sum4+$data["seeds"];
               $tora2[$i]["rp132"]=("\n\t<td align=\"center\" width=\"30\" class=\"lista\" style=\"text-align: center;\">" .$data["leechers"] . "</td>");
               $sum5=$sum5+$data["leechers"];
               if ($data["finished"]>0)
                  $tora2[$i]["rp133"]=("\n\t<td align=\"center\" width=\"40\" class=\"lista\" style=\"text-align: center;\">" . $data["finished"] . "</td>");
               else
                   $tora2[$i]["rp134"]=("\n\t<td align=\"center\" class=\"lista\" style=\"text-align: center;\"><center>---</td>");
               $sum6=$sum6+$data["finished"];
        }
           $tora2[$i]["rp135"]=("</tr>\n");
           $tora2[$i]["rp136"]=("</tr>\n");
           
           $i++;
           }
           $yesterdaytorrentstpl->set("tora2",$tora2);
      }

   $suma2["celkem200"]="<td class=\"lista\"align=\"center\"><center>".$sum3."</td>";
   if ($sum)
   $suma2["celkem300"]="<td class=\"lista\"align=\"center\"><center>".makesize($sum)."</td>";
   $suma2["celkem400"]="<td class=\"lista\"align=\"center\"><center><font color=limegreen>".$sum4."</font></td>";
   $suma2["celkem500"]="<td class=\"lista\"align=\"center\"><center><font color=red>".$sum5."</font></td>";
   $suma2["celkem600"]="<td class=\"lista\"align=\"center\"><center><font color=deeppink>".$sum6."</font></td></tr>";
   $yesterdaytorrentstpl->set("suma2",$suma2);
  }
  else
  {
    $yesterdaytorrentstpl->set("rp137","\n<tr><td class=\"lista\" colspan=\"9\" align=\"center\" style=\"text-align: center;\">" . $language["NO_TORRENTS"] . "</td></tr>");
  }

  block_end();

?>