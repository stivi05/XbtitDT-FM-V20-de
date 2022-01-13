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
require_once("include/functions.php");

dbconn();

global $XBTT_USE;

if ($XBTT_USE)
   {
    $ttseeds="f.seeds+ifnull(x.seeders,0)";
    $ttleechs="f.leechers+ifnull(x.leechers,0)";

    $tttables="{$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON x.info_hash=f.bin_hash";
   }
else
    {
    $ttseeds="f.seeds";
    $ttleechs="f.leechers";

    $tttables="{$TABLE_PREFIX}files f";
    }


  $query = "SELECT recommended.*, $ttseeds as seeds, f.gold,f.free,f.happy,f.vip_torrent, f.multiplier, $ttleechs as leechers, f.info_hash as hash, f.filename, f.anonymous, UNIX_TIMESTAMP( f.data ) as added, categories.image, categories.name as cname, f.category as catid, f.size, f.external, f.uploader, users.username as uploader , ul.prefixcolor, ul.suffixcolor FROM {$TABLE_PREFIX}recommended recommended LEFT JOIN $tttables ON recommended.info_hash = f.info_hash LEFT JOIN {$TABLE_PREFIX}categories categories ON categories.id = f.category LEFT JOIN {$TABLE_PREFIX}users users ON users.id = f.uploader LEFT JOIN {$TABLE_PREFIX}users_level ul ON users.id_level=ul.id ORDER by 'recommended.id' DESC";
  $res = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(CANT_DO_QUERY.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

?>


<table width=100%>
<TR>
<td align="center" width="40" class="header">Dl</td>
<td align="center" width="210" class="header">Torrent File</td>
<td align="center"  class="header">Cat.</td>
<td align="center" width="40" class="header">Added</td>
<td align="center" width="40" class="header">Uploader</td>
<td align="center" width="20" class="header">S</td>
<td align="center" width="20" class="header">L</td>
<td align="center" width="60" class="header">Rec. By</td>

</TR>
<?php
  while($results = mysqli_fetch_array($res))
   {
    // peers color by DT
    $pcl = 'background:#04B404';		

    $pcs = 'background:#04B404';	
    
	if ($results["seeds"]==0)
    {
	$pcs = 'background:#FF0000';
	}
    if ($results["leechers"]==0)
    {
    $pcl = 'background:#FF0000';
	}
    if ($results["seeds"]== 1 OR $results["seeds"]== 2)
    {
    $pcs = 'background:#A9F5D0';	
	}
    if ($results["leechers"]== 1 OR $results["leechers"] == 2)
    {
    $pcl = 'background:#A9F5D0';	
	}
	if ($results["seeds"]==3 OR $results["seeds"]==4)
    {
    $pcs = 'background:#00FF80';		
	}
     if ($results["leechers"]== 3 OR $results["leechers"] == 4)
    {
    $pcl = 'background:#00FF80';	
	}
// end peers color by DT

 //vip_torrent start
if($results["vip_torrent"]==1) {
$vt = "<img src=images/vip.gif alt='vip only torrent'>";
}
else {   $vt='';
}
 //vip_torrent end

//gold mod
     $silver_picture='';
     $gold_picture ='';
     $ress=get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'",true);
            foreach ($ress as $key=>$value)
            {
                $silver_picture = $value["silver_picture"];
                $gold_picture = $value["gold_picture"];
            }
        $gold ='';
        if($results['gold'] == 1)
        {
        $gold = '<img src="gold/'.$silver_picture.'" alt="silver"/>';
        }
        if($results['gold'] == 2)
        {
        $gold = '<img src="gold/'.$gold_picture.'" alt="gold"/>';
        }
//end gold mod

//free leech hack
    $free='';
    if($results['free'] == yes OR $results['happy']== yes)
    {
    $free = '<img src="images/freeleech.gif" alt="free leech"/>';
    }
// end free leech

      if($results['multiplier']>1) {
    $mult = "<img alt=\"".$results['multiplier']."x Upload Multiplier\" src=\"images/".$results['multiplier']."x.gif\" />";
   } else { $mult=""; }
    
      echo "<TR>";
      echo "<td align=\"center\" class=\"lista\"><center><a href=\"download.php?id=".$results["hash"]."&amp;f=" . rawurlencode($results["filename"]) . ".torrent\">".image_or_link("images/torrent.png","","torrent")."</a></td>";
         if ($GLOBALS["usepopup"])
         echo "<td align=\"center\" class=\"lista\"><center><A HREF=\"javascript:popdetails('index.php?page=torrent-details&amp;id=".$results["hash"]."');\">".$results["filename"].$mult.$gold.$free.$vt."</a>".($results["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")."</td>";
   else
         echo "<td align=\"center\" class=\"lista\"><center><A HREF=\"index.php?page=torrent-details&amp;id=".$results["hash"]."\">".$results["filename"].$mult.$gold.$free.$vt."</a>".($results["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")."</td>";
      echo "<td align=\"center\" class=\"lista\"><center><a href=\"index.php?page=torrents&amp;category=$results[catid]\">".image_or_link(($results["image"]==""?"":"$STYLEPATH/images/categories/" . $results["image"]),"",$results["cname"])."</td>";

      
      echo "<td align=\"center\" class=\"lista\"><center>" . date("d/m/Y",$results["added"]) . "</td>"; // data

   if ($results["anonymous"] == "true")
         echo "<td align=\"center\" class=\"lista\">" . ANONYMOUS . "</td>";
   else
         echo "<td align=\"center\" class=\"lista\"><center>" .$results["prefixcolor"].$results["uploader"] .$results["suffixcolor"]. "</td>";
       if ($GLOBALS["usepopup"])
         {
           echo "\t<td align=\"center\" class=\"".linkcolor($results["seeds"])."\"><a href=\"javascript:poppeer('index.php?page=peers.php?id=".$results["hash"]."');\" title=\"".PEERS_DETAILS."\">" . $results["seeds"] . "</a></td>\n";
           echo "\t<td align=\"center\" class=\"".linkcolor($results["leechers"])."\"><a href=\"javascript:poppeer('index.php?page=peers.php?id=".$results["hash"]."');\" title=\"".PEERS_DETAILS."\">" .$results["leechers"] . "</a></td>\n";
         }
       else
         {
           echo "\t<td align=\"center\" class=\"".linkcolor($results["seeds"])."\"style=\"text-align: center; ".$pcs."\"><a href=\"index.php?page=peers.php?id=".$results["hash"]."\" title=\"".PEERS_DETAILS."\">" . $results["seeds"] . "</a></td>\n";
           echo "\t<td align=\"center\" class=\"".linkcolor($results["leechers"])."\"style=\"text-align: center; ".$pcl."\"><a href=\"index.php?page=peers.php?id=".$results["hash"]."\" title=\"".PEERS_DETAILS."\">" .$results["leechers"] . "</a></td>\n";
         }
      echo "<td align=\"center\" class=\"lista\"><center>" . $results["user_name"] ."</td>";

echo"</TR>";
   }
   echo "</table>";

   print("<br />");
   print("<br />");
?>