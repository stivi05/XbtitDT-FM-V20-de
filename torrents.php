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

global $btit_settings, $XBTT_USE;
$tora=array();
$i=0;
$torrenttpl=new bTemplate();
$torrenttpl->set("language",$language);

if (isset($_GET["info_hash"])) $hash = $_GET["info_hash"];
   else $hash = "";
if (isset ($_GET["action"]))
   $action = $_GET["action"];
else $action="";
$username = $CURUSER["username"];

// to top
$pr=$btit_settings["touppr"];
$u=$CURUSER["seedbonus"];

$toperdetop = $_POST["top"];
if (isset($toperdetop) AND $btit_settings["toup"] ==true AND $CURUSER["edit_users"]=="no" AND $u>$pr )
{        
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET seedbonus=seedbonus-$pr WHERE id=".$CURUSER["uid"]);
do_sqlquery("UPDATE {$TABLE_PREFIX}files SET data=now() WHERE info_hash='" . $hash . "'",true);	
}

if (($hash != "") && ($action == "up"))
{
if ($CURUSER["edit_users"]=="yes")
do_sqlquery("UPDATE {$TABLE_PREFIX}files SET data=now() WHERE info_hash='" . $hash . "'",true);
else
{
if ($u>$pr )
{
information_msg("Are you sure","Are you sure you want to echange $pr SB points to get this torrent back to top ? <form method=post action=index.php?page=torrents><input type=hidden name=top ><p></p><input type=submit class=btn value=Confirm></form>");
stdfoot();
exit(); 
}
else
{
stderr("error","You have to less SB to set this torrent back to top , you need $pr SB points for that");
stdfoot();
exit();
}
}
}
// to top end

if (($hash != "") && ($action == "add") && ($CURUSER["edit_users"] == "yes"))
   {
     $affected = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}recommended WHERE info_hash=\"$hash\"");
     if (mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}recommended")) > 9)
        {
         stderr("Too many torrents added!","Remove some before add more!");
          stdfoot();
          exit();
        }
     elseif (mysqli_num_rows($affected) == 0)
        {
          mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}recommended (info_hash, user_name) VALUES (\"$hash\", \"$username\")") or die("Error in MySQL");
         stderr("Successfully added","Successfully added");
          stdfoot();
          exit();
        }
     else
       {
          stderr("Already added","Already added");
          stdfoot();
          exit();
       }
   }


if (($hash != "") && ($action == "remove") && ($CURUSER["edit_users"] == "yes"))
   {
     mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}recommended WHERE info_hash=\"$hash\"");
     stderr("Successfully removed","Successfully removed");
     stdfoot();
     exit();
   }
   
if ($XBTT_USE)
   {
    $ttseeds="f.seeds+ifnull(x.seeders,0)";
    $ttleechs="f.leechers+ifnull(x.leechers,0)";
    $ttcompletes="f.finished+ifnull(x.completed,0)";
    $tttables="{$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON x.info_hash=f.bin_hash";
   }
else
    {
    $ttseeds="f.seeds";
    $ttleechs="f.leechers";
    $ttcompletes="f.finished";
    $tttables="{$TABLE_PREFIX}files f";
    }

$limit=$btit_settings["recommended"];
  $query = "SELECT f.imdb, f.multiplier, f.size, r.info_hash, r.user_name, f.gold, $ttseeds as seeds , f.vip_torrent, f.free, f.happy, $ttleechs as leechers, f.info_hash as hash, f.filename, f.url, f.info, f.anonymous, f.speed, UNIX_TIMESTAMP( f.data ) as added, c.image, c.name as cname, f.category as catid, f.external, f.uploader as upname, u.username as uploader FROM {$TABLE_PREFIX}recommended r LEFT JOIN $tttables ON r.info_hash = f.info_hash LEFT JOIN {$TABLE_PREFIX}categories c ON c.id = f.category LEFT JOIN {$TABLE_PREFIX}users u ON u.id = f.uploader ORDER BY 'r.id' DESC LIMIT $limit";
  $res = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));


if ($btit_settings["show_recommended"] == true)
   {
$tora[$i]["rp0"]=("<br><tr><td class=\"block\" colspan=\"10\" align=\"center\"><b>Our Team Recommend</td></tr>");
$tora[$i]["rp1"]=("<td class=\"header\" align=\"center\" width=\"45\">Cat.</td>");
$tora[$i]["rp2"]=("<td align=\"center\" class=\"header\" >Filename</td>");
$tora[$i]["rp3"]=("<td align=\"center\" class=\"header\" width=\"20\">DL</td>");
$tora[$i]["rp4"]=("<td align=\"center\" class=\"header\" width=\"85\">Added</td>");
$tora[$i]["rp5"]=("<td align=\"center\" class=\"header\" width=\"70\">Size</td>");
$tora[$i]["rp6"]=("<td align=\"center\" class=\"header\" width=\"100\">Uploader</td>");
$tora[$i]["rp7"]=("<td align=\"center\" class=\"header\" width=\"30\">S</td>");
$tora[$i]["rp8"]=("<td align=\"center\" class=\"header\" width=\"30\">L</td>");
$tora[$i]["rp9"]=("<td align=\"center\" class=\"header\" width=\"100\">Recommended by</td>");
if ($CURUSER["edit_users"] == "yes")
{
$tora[$i]["rp10"]=("<td align=\"center\" class=\"header\" width=\"40\">Remove</td>");
}

while($results = mysqli_fetch_array($res))
{
//Begin
if(isset($CURUSER["lastconnect"])){
 $filetime =  date("YmdHis",$data["added"]);
 $lastseen = date("YmdHis",$CURUSER["lastconnect"]);

if ($lastseen <= $filetime) 
  $is_new = "(<span style=\"color:red\">new</span>)";
else  
$is_new='';
}

// groupcolor
$resql_user=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level FROM {$TABLE_PREFIX}users WHERE username='".$results["user_name"]."'")or sqlerr();
$rowql_user=mysqli_fetch_array($resql_user);
$resq_user=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor, suffixcolor FROM {$TABLE_PREFIX}users_level WHERE id='".$rowql_user["id_level"]."'")or sqlerr();
$rowq_user=mysqli_fetch_array($resq_user);
//vip_torrent start
      
if($results["vip_torrent"]==1) 
$vt = "<img src=images/vip.gif alt='vip only torrent'>";
else 
$vt='';
//vip_torrent end
 
if($results['multiplier']>1) 
    $mult = "<img alt=\"".$results['multiplier']."x Upload Multiplier\" src=\"images/".$results['multiplier']."x.gif\" />";
   else 
   $mult=""; 
 
 //free leech hack
    $qq='';
    if($results['free'] == yes OR $results['happy'] == yes)
    $qq = '<img src="images/freeleech.gif" alt="free leech"/>';
// end free leech

// imdb rating
if ($btit_settings["imdbt"]==true ) 
{
            require_once ("imdb/imdb.class.php");
            $movie = new imdb($results["imdb"]);
            $ratv_file = dirname(__file__).'/cache/'.$results["imdb"].'_torrents_IMDB_rating.txt';
            if(file_exists($ratv_file))
            $ratv = unserialize(file_get_contents($ratv_file));
            else
            {
                $ratv = $movie->rating();
                if($results["imdb"] != 0)
                write_file($ratv_file, serialize($ratv));
            }

$ilink=$results["imdb"];            
          
if  ($ratv==0)
$rtre="";
else
$rtre="<A HREF=http://www.imdb.com/title/tt".$ilink."><img src='images/imdb.png' 'alt=imdb' /> ".$ratv."</A>"; 
}
else
$rtre="";         
//imdb rating

// start grabbed
$dllo="";

$res_loadd =do_sqlquery("SELECT * FROM {$TABLE_PREFIX}down_load WHERE pid='".$CURUSER["pid"]."'")or sqlerr();
if ($res_loadd)
{

         $ia=0;
         while ($row_loadd=mysqli_fetch_array($res_loadd))
	{


if ($row_loadd["hash"]==$results["hash"])
{
$dllo="<img src='images/downloaded.gif' alt='Allready Grabbed !!' title='Allready Grabbed !!' />";
 $ia++;
}
}
}
// end grabbed

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
    if($results['gold'] == 1)
    $gq=  '<img src="gold/'.$silver_picture.'" alt="silver"/>';
    
    if($results['gold'] == 2)
    $gq=  '<img src="gold/'.$gold_picture.'" alt="gold"/>';
    
// peers color by DT
    $sco = '#04B404;';		
    $lco = '#04B404;';	
    
	if ($results["seeds"]==0)
    $sco = '#FF0000;';
	if ($results["leechers"]==0)
    $lco = '#FF0000;';
	if ($results["seeds"]== 1 OR $data["seeds"]== 2)
    $sco = '#A9F5D0;';	
	if ($results["leechers"]== 1 OR $data["leechers"] == 2)
    $lco = '#A9F5D0;';	
	if ($$results["seeds"]==3 OR $data["seeds"]==4)
    $sco = '#00FF80;';		
	if ($results["leechers"]== 3 OR $data["leechers"] == 4)
    $lco= '#00FF80;';	
	// end peers color by DT

//End
      $tora[$i]["rp11"]=("<td align=\"center\" class=\"lista\"><center><a href=\"index.php?page=torrents&amp;category=$results[catid]\">".image_or_link(($results["image"]==""?"":"$STYLEPATH/images/categories/" . $results["image"]),"",$results["cname"])."</td>");
         
   if ($GLOBALS["usepopup"])
         $tora[$i]["rp12"]=("<td align=\"left\" class=\"lista\"><A HREF=\"javascript:popdetails('index.php?page=torrent-details&amp;id=".$results["hash"]."');\">".$results["filename"]."</a>".($results["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)").$gq.$qq.$vt.$mult.$dllo.$rtre."</td>");
   else
         $tora[$i]["rp12"]=("<td align=\"left\" class=\"lista\"><A HREF=\"index.php?page=torrent-details&amp;id=".$results["hash"]."\">".$results["filename"]."</a>".($results["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)").$gq.$qq.$vt.$mult.$dllo.$rtre."</td>");

       $tora[$i]["rp13"]=("<td align=\"center\" class=\"lista\"><center><a href=\"download.php?id=".$results["hash"]."&amp;f=" . rawurlencode($results["filename"]) . ".torrent\">".image_or_link("images/torrent.png","","torrent")."</a></td>");
      $tora[$i]["rp14"]=("<td align=\"center\" class=\"lista\"><center>" . date("d/m/Y",$results["added"]) . "</td>"); // data
      $tora[$i]["rp15"]=("<td align=\"center\" class=\"lista\"><center>" . makesize($results["size"]) . "</td>");
   if ($results["anonymous"] == "true")
         $tora[$i]["rp16"]=("<td align=\"center\" class=\"lista\"><center>Anonymous</td>");
         else
         $tora[$i]["rp16"]=("<td align=\"center\" class=\"lista\"><center>" .$results["uploader"] . "</td>");
         
if ($results["external"]=="no")
      {
       if ($GLOBALS["usepopup"])
         {
         $tora[$i]["rp17"]=("<td align=\"center\" style=\"text-align: center;background:$lco\"><a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$results["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">" . $results["seeds"] . "</a></td>");
         $tora[$i]["rp18"]=("<td align=\"center\" style=\"text-align: center;background:$sco\"><a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$results["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">" .$results["leechers"] . "</a></td>");
         }
       else
         {
         $tora[$i]["rp17"]=("<td align=\"center\"  style=\"text-align: center;background:$sco\"><a href=\"index.php?page=peers&amp;id=".$results["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">" . $results["seeds"] . "</a></td>");
         $tora[$i]["rp18"]=("<td align=\"center\" style=\"text-align: center;background:$lco\"><a href=\"index.php?page=peers&amp;id=".$results["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">" .$results["leechers"] . "</a></td>");
         }
      }
   else
       {
       $tora[$i]["rp17"]=("<td align=\"center\" style=\"text-align: center;background:$sco\">".$results["seeds"] . "</a></td>");
       $tora[$i]["rp18"]=("<td align=\"center\" style=\"text-align: center;background:$lco\">".$results["leechers"] . "</a></td>");
   }

      $tora[$i]["rp19"]=("<td align=\"center\" class=\"lista\"><center>" . StripSlashes($rowq_user['prefixcolor'].$results["user_name"].$$rowq_user['suffixcolor']) . "</td>");

   if ($CURUSER["edit_users"] == "yes")
      $tora[$i]["rp20"]=("<td align=\"center\" class=\"lista\"><center><a href=index.php?page=torrents&action=remove&info_hash=".$results["info_hash"].">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</A></td>");
      $i++;
   }
   }

$scriptname = htmlspecialchars($_SERVER["PHP_SELF"]."?page=torrents");
$addparam = "";

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

if(!$CURUSER || $CURUSER["view_torrents"]!="yes")
{
    err_msg($language["ERROR"],$language["NOT_AUTHORIZED"]." ".$language["MNU_TORRENT"]."!<br />\n".$language["SORRY"]."...");
    stdfoot();
    exit();
}

if(isset($_GET["search"]))
$trova = htmlspecialchars(str_replace ("+"," ",$_GET["search"]));
else 
$trova = "";

//cloud
if ($btit_settings["cloud"]==true )
{
$searchcloud = sqlesc($trova);
    $r = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}searchcloud WHERE searchedfor = $searchcloud"));
    if (!$r)
	 mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}searchcloud (searchedfor, howmuch) VALUES ($searchcloud, 1)");	
     else
        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}searchcloud SET howmuch = howmuch + 1 WHERE searchedfor = $searchcloud");
}
//cloud

	  $owntor=0;
$do = $_GET["do"];

if ($do=="del"){
foreach($_POST["msg"] as $selected=>$msg){
$filename=@mysqli_fetch_array(@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filename FROM {$TABLE_PREFIX}files WHERE info_hash=\"$msg\""));
write_log("Deleted torrent ".unesc($filename["filename"])." ($msg)","delete");
@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}files WHERE info_hash=\"$msg\"");
@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}timestamps WHERE info_hash=\"$msg\"");
@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}comments WHERE info_hash=\"$msg\"");
@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}ratings WHERE infohash=\"$msg\"");
@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}peers WHERE infohash=\"$msg\"");
@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}history WHERE infohash=\"$msg\"");
IF ($XBTT_USE)
          mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE xbt_files SET flags=1 WHERE info_hash=UNHEX('$msg')") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

      unlink($TORRENTSDIR."/$msg.btf");
}
}

$category = (!isset($_GET["category"])?0:explode(";",$_GET["category"]));
// sanitize categories id
if (is_array($category))
    $category = array_map("intval",$category);
else
    $category = 0;

$combo_categories=categories( $category[0] );
//uploader
$uploader = (!isset($_GET["uploader"])?0:explode(";",$_GET["uploader"]));
if (is_array($uploader))
    $uploader = array_map("intval",$uploader);
else
    $uploader = 0;

$combo_uploader=uploader( $uploader[0] );
                    
(isset($_GET["active"]) && is_numeric($_GET["active"]) && $_GET["active"]>=0 && $_GET["active"]<=2) ? $active=intval($_GET["active"]) : $active=1;

// start advanced search hack DT
if(isset($_GET["options"]))
    {
        $options=intval($_GET["options"]);
    } else {
        $options=0;
    }
// end advanced search hack DT

if($active==0)
{
    $where = " WHERE 1=1";
    $addparam.="active=0";
} // active only
elseif($active==1){
    $where = " WHERE $tleechs+$tseeds > 0";
    $addparam.="active=1";
} // dead only
elseif($active==2){
    $where = " WHERE $tleechs+$tseeds = 0";
    $addparam.="active=2";
}

// gold  search
if(isset($_GET["gold"]))
{
    $gold=intval($_GET["gold"]);
} else {
    $gold=0;
}
//end gold search

//all
if($gold==0)
{
    $where .= "";
     $addparam.="&amp;gold=0";
}
//none gold/silver
if($gold==1)
{
    $where .= " AND `gold` = '0'";
     $addparam.="&amp;gold=1";
}
//gold
elseif($gold==2)
{
    $where .= " AND `gold` = '1'";
    $addparam.="&amp;gold=2";
}
//silver
elseif($gold==3)
{
   $where .= " AND `gold` = '2'";
    $addparam.="&amp;gold=3";
}
elseif($gold==4)
{
   $where .= " AND `gold` = '2' or `gold` = '1'";
    $addparam.="&amp;gold=4";
}
//end gold search

if ($category[0]>0) {
   $where .= " AND category IN (".implode(",",$category).")"; // . $_GET["category"];
   $addparam.="&amp;category=".implode(";",$category); // . $_GET["category"];
}

if ($uploader[0]>0) {
   $where .= " AND uploader IN (".implode(",",$uploader).")"; // . $_GET["category"];
   $addparam.="&amp;uploader=".implode(";",$uploader); // . $_GET["category"];
}
// Search
if (isset($_GET["search"])) {
   $testocercato = trim($_GET["search"]);
   $testocercato = explode(" ",$testocercato);
   if ($_GET["search"]!="")
      $search = "search=" . implode("+",$testocercato);
    for ($k=0; $k < count($testocercato); $k++) {

// start advanced search hack DT
// tag
if ($btit_settings["tag"]==true )
{
    if ($options==0)   {
        $query_select .= " (filename LIKE '%" . mysqli_real_escape_string($DBDT,$testocercato[$k]) . "%'";
		$query_select .= " OR tag LIKE '%" . mysqli_real_escape_string($DBDT,$testocercato[$k]) . "%')";   }

    if ($options==1)   {
       $query_select .= " (filename LIKE '%" . mysqli_real_escape_string($DBDT,$testocercato[$k]) . "%'";
       $query_select .= " OR comment LIKE '%" . mysqli_real_escape_string($DBDT,$testocercato[$k]) . "%'";
	   $query_select .= " OR tag LIKE '%" . mysqli_real_escape_string($DBDT,$testocercato[$k]) . "%')";  }

    if ($options==2)  {
       $query_select .= " (comment LIKE '%" . mysqli_real_escape_string($DBDT,$testocercato[$k]) . "%'";
	   $query_select .= " OR tag LIKE '%" . mysqli_real_escape_string($DBDT,$testocercato[$k]) . "%')";    }
}
else
{
    if ($options==0)   {
        $query_select .= " filename LIKE '%" . mysqli_real_escape_string($DBDT,$testocercato[$k]) . "%'";   }

    if ($options==1)   {
       $query_select .= " (filename LIKE '%" . mysqli_real_escape_string($DBDT,$testocercato[$k]) . "%'";
       $query_select .= " OR comment LIKE '%" . mysqli_real_escape_string($DBDT,$testocercato[$k]) . "%')";  }

    if ($options==2)  {
       $query_select .= " comment LIKE '%" . mysqli_real_escape_string($DBDT,$testocercato[$k]) . "%'";    }
}
   
// end advanced search hack DT
   
if ($k<count($testocercato)-1)
           $query_select .= " AND ";
    }
    $where .= " AND " . $query_select;
}
// new porm system
$dob=explode("-",$CURUSER["dob"]);
$age=userage($dob[0], $dob[1], $dob[2]);
if($CURUSER['showporn']=='no' or $age <= $btit_settings["porncat"]){
            $porn=do_sqlquery("SELECT id FROM {$TABLE_PREFIX}categories  WHERE porn='yes'",true);
         //   $pornar=array();
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
// end search

// torrents count...

$res = get_result("SELECT COUNT(*) as torrents FROM $ttables $where AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7)",true,$btit_settings['cache_duration']);

$count = $res[0]["torrents"];
if (!isset($search)) $search = "";

if ($count>0) {
   if ($addparam != "") {
      if ($search != "")
         $addparam .= "&amp;" . $search . "&amp;";
}
   else {
      if ($search != "")
         $addparam .=  $search . "&amp;";
      else
          $addparam .= ""; //$scriptname . "?";
      }

    $torrentperpage=intval($CURUSER["torrentsperpage"]);
    if ($torrentperpage==0)
        $torrentperpage=($ntorrents==0?15:$ntorrents);

    // getting order
    $order_param=3;
    if (isset($_GET["order"]))
       {
         $order_param=(int)$_GET["order"];
         switch ($order_param)
           {
           case 1:
                $order="cname";
                break;
           case 2:
                $order="filename";
                break;
           case 3:
                $order="data";
                break;
           case 4:
                $order="size";
                break;
           case 5:
                $order="seeds";
                break;
           case 6:
                $order="leechers";
                break;
           case 7:
                $order="finished";
                break;
           case 8:
                $order="dwned";
                break;
           case 9:
                $order="speed";
                break;
           default:
               $order="data";
               }
			   }
    else
        $order="data";

    $qry_order=str_replace(array("leechers","seeds","finished"),array($tleechs,$tseeds, $tcompletes),$order);

    $by_param=2;
    if (isset($_GET["by"]))
      {
        $by_param=(int)$_GET["by"];
        $by=($by_param==1?"ASC":"DESC");
    }
    else
        $by="DESC";

list($pagertop, $pagerbottom, $limit) = pager($torrentperpage, $count,  $scriptname."&amp;" . $addparam.(strlen($addparam)>0?"&amp;":"")."options=$options&amp;order=$order_param&amp;by=$by_param&amp;");
    
if ($XBTT_USE)
    $rowcat = do_sqlquery("SELECT u.id, (u.downloaded+IFNULL(x.downloaded,0)) as downloaded, ((u.uploaded+IFNULL(x.uploaded,0))/(u.downloaded+IFNULL(x.downloaded,0))) as uratio, cp.* FROM {$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  else
    $rowcat = do_sqlquery("SELECT u.id, u.downloaded, (u.uploaded/u.downloaded) as uratio, cp.* FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  if (mysqli_num_rows($rowcat)>0)
     while ($catdata=mysqli_fetch_array($rowcat))
             if($catdata["viewtorrlist"]!="yes" && (($catdata["downloaded"]>=$GLOBALS["download_ratio"] && ($catdata["ratio"]>$catdata["uratio"]))||($catdata["downloaded"]<$GLOBALS["download_ratio"])||($catdata["ratio"]=="0")))
                $where.=' AND f.category!='.$catdata[catid];

    // Do the query with the uploader nickname
    if ($SHOW_UPLOADER)
        $query = "SELECT u.team AS userteam, teams.id AS teamsid, teams.name AS teamname, teams.image AS teamimage, f.team,f.imdb,f.announce_url as aurl, f.language, f.tag,f.multiplier, (SELECT hash FROM {$TABLE_PREFIX}subtitles WHERE hash=f.info_hash LIMIT 1) as shash, f.happy,f.gold, f.image as img ,f.free as free, f.vip_torrent as vip_torrent,  f.sticky as sticky, f.info_hash as hash, $tseeds as seeds, $tleechs as leechers, $tcompletes as finished,  f.dlbytes as dwned , IFNULL(f.filename,'') AS filename, f.url, f.info, f.anonymous, f.speed, UNIX_TIMESTAMP( f.data ) as added, c.image, c.name as cname, f.category as catid, f.size, f.external, f.uploader as upname, u.username as uploader, prefixcolor, suffixcolor FROM $ttables LEFT JOIN {$TABLE_PREFIX}categories c ON c.id = f.category LEFT JOIN {$TABLE_PREFIX}users u ON u.id = f.uploader LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id LEFT JOIN {$TABLE_PREFIX}teams teams ON f.team = teams.id $where AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) GROUP BY f.sticky,$qry_order $by ORDER BY f.sticky $by $limit";

    // Do the query without the uploader nickname
    else
        $query = "SELECT teams.id AS teamsid, teams.name AS teamname, teams.image AS teamimage, f.team,f.imdb,f.announce_url as aurl, f.language, f.tag,f.multiplier,  (SELECT hash FROM {$TABLE_PREFIX}subtitles WHERE hash=f.info_hash LIMIT 1) as shash,f.happy,f.gold, f.image as img ,f.free as free, f.vip_torrent as vip_torrent,  f.sticky as sticky,f.info_hash as hash, $tseeds as seeds, $tleechs as leechers, $tcompletes as finished,  f.dlbytes as dwned , IFNULL(f.filename,'') AS filename, f.url, f.info, f.speed, UNIX_TIMESTAMP( f.data ) as added, c.image, c.name as cname, f.category as catid, f.size, f.external, f.uploader FROM $ttables LEFT JOIN {$TABLE_PREFIX}categories c ON c.id = f.category LEFT JOIN {$TABLE_PREFIX}teams teams ON f.team = teams.id $where AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) GROUP BY f.sticky,$qry_order $by ORDER BY f.sticky $by $limit";
    // End the queries
       $results = get_result($query,true,$btit_settings['cache_duration']);
}

if ($by=="ASC")
    $mark="&nbsp;&uarr;";
else
$mark="&nbsp;&darr;";

// load language file
require(load_language("lang_torrents.php"));


$torrenttpl=new bTemplate();
$torrenttpl->set("language",$language);
$torrenttpl->set("torrent_script","index.php");
$torrenttpl->set("torrent_search",$trova);
if ($trova !="")
$torrenttpl->set("search_msg","Your search for '<span style=\"color:orange\">".$trova."</span>' retrieved <span style=\"color:red\">".$count."</span> matches!");

$torrenttpl->set("torrent_categories_combo",$combo_categories);
$torrenttpl->set("torrent_uploader_combo",$combo_uploader);
                    
$torrenttpl->set("torrent_selected_all",($active==0?"selected=\"selected\"":""));
$torrenttpl->set("torrent_selected_active",($active==1?"selected=\"selected\"":""));
$torrenttpl->set("torrent_selected_dead",($active==2?"selected=\"selected\"":""));

$torrenttpl->set("torrent_selected_file",($options==0?"selected=\"selected\"":""));
$torrenttpl->set("torrent_selected_filedes",($options==1?"selected=\"selected\"":""));
$torrenttpl->set("torrent_selected_des",($options==2?"selected=\"selected\"":""));

// gold  search
$torrenttpl->set("torrent_selected_nog",($gold==0?"selected=\"selected\"":""));
$torrenttpl->set("torrent_selected_takg",($gold==1?"selected=\"selected\"":""));
$torrenttpl->set("torrent_selected_stak",($gold==2?"selected=\"selected\"":""));
$torrenttpl->set("torrent_selected_stak",($gold==3?"selected=\"selected\"":""));
$torrenttpl->set("torrent_selected_stak",($gold==4?"selected=\"selected\"":""));
//end gold search

$torrenttpl->set("torrent_pagertop",$pagertop);
$torrenttpl->set("torrent_header_category","<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=1&amp;by=".($order=="cname" && $by=="ASC"?"2":"1")."\">".$language["CATEGORY"]."</a>".($order=="cname"?$mark:""));
$torrenttpl->set("torrent_header_filename","<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=2&amp;by=".($order=="filename" && $by=="ASC"?"2":"1")."\">".$language["FILE"]."</a>".($order=="filename"?$mark:""));
$torrenttpl->set("torrent_header_comments",$language["COMMENT"]);
$torrenttpl->set("torrent_header_rating",$language["RATING"]);
$torrenttpl->set("WT",intval($CURUSER["WT"])>0,TRUE);
$torrenttpl->set("torrent_header_waiting",$language["WT"]);
$torrenttpl->set("torrent_header_download",$language["DOWN"]);
$torrenttpl->set("torrent_header_added","<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=3&amp;by=".($order=="data" && $by=="ASC"?"2":"1")."\">".$language["ADDED"]."</a>".($order=="data"?$mark:""));
$torrenttpl->set("torrent_header_size","<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=4&amp;by=".($order=="size" && $by=="DESC"?"1":"2")."\">".$language["SIZE"]."</a>".($order=="size"?$mark:""));
$torrenttpl->set("uploader",$SHOW_UPLOADER,TRUE);
$torrenttpl->set("torrent_header_uploader",$language["UPLOADER"]);
$torrenttpl->set("torrent_header_seeds","<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=5&amp;by=".($order=="seeds" && $by=="DESC"?"1":"2")."\">".$language["SHORT_S"]."</a>".($order=="seeds"?$mark:""));
$torrenttpl->set("torrent_header_leechers","<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=6&amp;by=".($order=="leechers" && $by=="DESC"?"1":"2")."\">".$language["SHORT_L"]."</a>".($order=="leechers"?$mark:""));
$torrenttpl->set("torrent_header_complete","<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=7&amp;by=".($order=="finished" && $by=="ASC"?"2":"1")."\">".$language["SHORT_C"]."</a>".($order=="finished"?$mark:""));
$torrenttpl->set("torrent_header_downloaded","<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=8&amp;by=".($order=="dwned" && $by=="ASC"?"2":"1")."\">".$language["DOWNLOADED"]."</a>".($order=="dwned"?$mark:""));
$torrenttpl->set("torrent_header_speed","<a href=\"$scriptname&amp;$addparam".(strlen($addparam)>0?"&amp;":"")."order=9&amp;by=".($order=="speed" && $by=="ASC"?"2":"1")."\">".$language["SPEED"]."</a>".($order=="speed"?$mark:""));
$torrenttpl->set("torrent_header_average",$language["AVERAGE"]);
$torrenttpl->set("torrent_header_language",$language["LANGUAGE"]);

if ($btit_settings["magnet"] == true)
$torrenttpl->set("torrent_header_magnet","<td align=center width=30 class=header>Mag</td>");

if ($btit_settings["show_recommended"] == true && $CURUSER["edit_users"]=="yes")
$torrenttpl->set("torrent_header_rec","<td align=\"center\" width=\"45\" class=\"header\">Recommend</td>");

if ($CURUSER["edit_users"]=="yes" OR $btit_settings["toup"]== true){
$torrenttpl->set("torrent_header_top","<td align=\"center\" width=\"45\" class=\"header\">Up</td>");
}

if ($CURUSER["edit_torrents"]=="yes"){
$allow="<TD align='center' class='header' style=\"text-align: center;\"><input type=checkbox name=all onclick=SetAllCheckBoxes('deltorrent','msg[]',this.checked)></TD>";
}
else{
$allow="<TD align='center' class='header' style=\"text-align: center;\"></TD>";
}
$torrenttpl->set("torrent_header_allow","$allow");

if($SHOW_UPLOADER)
{
$torrenttpl->set("uploader",false,TRUE);
$torrenttpl->set("uploader1",false,TRUE);
}
else
{
$torrenttpl->set("uploader",TRUE,TRUE);
$torrenttpl->set("uploader1",TRUE,TRUE);
}

$torrenttpl->set("XBTT",$XBTT_USE,TRUE);
$torrenttpl->set("torrent_pagerbottom",$pagerbottom);


if ($btit_settings["uplang"]==true ) 
{
    $torrenttpl->set("uplo",true,FALSE);
    $torrenttpl->set("uploo",true,FALSE);
}
else
{
    $torrenttpl->set("uplo",false,TRUE);
    $torrenttpl->set("uploo",false,TRUE);
}

$torrents=array();
$i=0;

if ($count>0) {
  foreach ($results as $tid=>$data) {
	   if(getmoderstatusbyhash($data["hash"])=='ok')
	   {

   $torrenttpl->set("WT1",intval($CURUSER["WT"])>0,TRUE);
   
//Mod by losmi - sticky mod
$sticky_color=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}sticky ORDER BY id",true);
    if(mysqli_num_rows($sticky_color)>0)
    {
    $st=mysqli_fetch_assoc($sticky_color);
    $s_c = $st['color'];
    }
    else
    {
    /*Default value some green #bce1ac;*/
    $s_c ='#bce1ac;';
    }
    $torrents[$i]["color"] ='';
    $dttd ='';
        if($data['sticky']==1)
        {
            $torrents[$i]["color"] = 'background:'.$s_c;
            $dttd = $s_c;
        }
//Mod by losmi - sticky mod
   
    $torrenttpl->set("XBTT1",$XBTT_USE,TRUE);
   
   $fteam=$data["team"];
   if($data["teamsid"]!=0){
   $team="<a href='index.php?page=modules&amp;module=team&team=".$data["teamsid"]."'><img src=\"".$data["teamimage"]."\" border=\"0\" title=\"".$data["teamname"]."\"></a>";
   }else
   $team="";
   
   $fsub=$data["shash"];
   if(isset($fsub)){
    $sub="<a href=\"index.php?page=subtitles&id=$fsub\"><img src=\"images/subs.png\" border=\"0\" title=\"subs\" alt=\"subs\"></a>";
   }else
   $sub="";
   

   $data["filename"]=unesc($data["filename"]);
   $filename=cut_string($data["filename"],intval($btit_settings["cut_name"]));
   if($data['multiplier']>1) {
   $mult = "<img alt=\"".$data['multiplier']."x Upload Multiplier\" src=\"images/".$data['multiplier']."x.gif\" />";
   } else
   $mult="";
   
//vip_torrent start
if($data["vip_torrent"]==1) 
$vt = "<img src=images/vip.gif alt='vip only torrent'>";
else 
$vt='';
//vip_torrent end

// torrents after last visit
if(isset($CURUSER["lastconnect"])){
 $filetime =  date("YmdHis",$data["added"]);
 $lastseen = date("YmdHis",$CURUSER["lastconnect"]);
if ($lastseen <= $filetime) {
  $is_new = "<img src=images/new.png>";
}
else   
$is_new='';

}
// torrents after last visit

// imdb rating
if ($btit_settings["imdbt"]==true ) 
{
            require_once ("imdb/imdb.class.php");
            $movie = new imdb($data["imdb"]);
            $ratv_file = dirname(__file__).'/cache/'.$data["imdb"].'_torrents_IMDB_rating.txt';
            if(file_exists($ratv_file))
            {
                $ratv = unserialize(file_get_contents($ratv_file));
            }
            else
            {
                $ratv = $movie->rating();
                if($data["imdb"] != 0)
                write_file($ratv_file, serialize($ratv));
            }

$ilink=$data["imdb"];            
          
if  ($ratv==0)
$rt="";
else
$rt="<A HREF=http://www.imdb.com/title/tt".$ilink."><img src='images/imdb.png' 'alt=imdb' /> ".$ratv."</A>"; 
}
else
$rt="";         
//imdb rating

// start grabbed
$dl="";

$res_load =do_sqlquery("SELECT * FROM {$TABLE_PREFIX}down_load WHERE pid='".$CURUSER["pid"]."'")or sqlerr();
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

//free leech hack

    $fl='';

    if($data['free'] == yes OR $data['happy'] == yes)
    {
    $fl = '<img src="images/freeleech.gif" alt="free leech"/>';
    }
// end free leech
          
//gold mod
    $silver_picture='';
    $gold_picture ='';
     $res=get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'",true);
            foreach ($res as $key=>$value)
            {
                $silver_picture = $value["silver_picture"];
                $gold_picture = $value["gold_picture"];
            }
       
    $go='';
    if($data['gold'] == 1)
    $go = '<img src="gold/'.$silver_picture.'" alt="silver"/>';
    
    if($data['gold'] == 2)
    $go = '<img src="gold/'.$gold_picture.'" alt="gold"/>';
//gold mod

$torrents[$i]["category"]="<a href=\"index.php?page=torrents&amp;category=$data[catid]\">".image_or_link(($data["image"]==""?"":"$STYLEPATH/images/categories/" . $data["image"]),"",$data["cname"])."</a>";

// image link 
if ($btit_settings["imgsw"]==false ) 
$tdt="";
else
$tdt="torrentimg/";
// image link 

// imdb mousehover image
if ($btit_settings["imdbmh"]==true )
{ 
$tdt="";
  $movie->photodir='./imdb/images/';
  $movie->photoroot='./imdb/images/';
  if (($photo_url = $movie->photo_localurl() ) != FALSE)
$balon= $photo_url;

}
else
{
// Start baloon hack DT
$hover=($data["img"]);
if ($hover=="")
 $balon=("nocover.jpg");
 else
 $balon =($data["img"]);
// End baloon hack DT   
}
// imdb mousehover image

//refresh peers
if ($CURUSER["id_level"] > 3 and $data["external"]=="yes" )
$ref="<a href=\"index.php?page=torrents&amp;act=update&amp;id=".$data["hash"]."&amp;surl=".urlencode($data["aurl"])."\" title=\"refresh peer\">".image_or_link("images/Refresh.png","","torrent")."</a>";
else
$ref="";
//refresh peers

// Grouped Torrents V2 by DT start 
if ($btit_settings["simtor"]==true )
{
if(($btit_settings["simsw"]==TRUE AND $data["imdb"]!=="" ) OR $btit_settings["simsw"]==FALSE ) 
{
if ($XBTT_USE)
{
$lll="f.leechers+ifnull(x.leechers,0) as leechers";
$sss="f.seeds+ifnull(x.seeders,0) as seeds";
$tttables="{$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON x.info_hash=f.bin_hash";
$ccc="f.finished+ifnull(x.completed,0) as completed";
}
else
{
$lll="f.leechers as leechers";
$sss="f.seeds as seeds";
$tttables="{$TABLE_PREFIX}files f";
$ccc="f.finished as completed";
}

        $searchname = substr($data['filename'], 0, 4);
        $query10 = str_replace(" ",".",sqlesc("%".$searchname."%"));

        $not=sqlesc($data['hash']);
        $imdt=sqlesc($data['imdb']);
        
if($btit_settings["simsw"]==FALSE) 
{ 
$ryti="f.filename LIKE {$query10} AND";
$whatever ="Filename: ".$data['filename'];
}
else
{
$imdt=$data['imdb']; 
$ryti="f.imdb = $imdt AND"; 
$whatever ="IMDB Number: tt".$imdt;
}    
       
          $r = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT c.image, c.name AS cname, f.category as catid,f.category , f.info_hash, f.filename, f.size, UNIX_TIMESTAMP( f.data ) as added , $sss , $lll , $ccc , f.category FROM $tttables LEFT JOIN {$TABLE_PREFIX}categories c ON c.id = f.category WHERE $ryti f.info_hash!=$not ORDER BY f.data DESC LIMIT 5") or sqlerr();
           if (mysqli_num_rows($r) > 0)
           {
            $torrentsss .="<tr><td align='left' class='header' colspan='17'><b>Have Similar Release(s) taken from $whatever</b></td></tr>\n";
		     while ($a = mysqli_fetch_assoc($r))
             {
// peers color by DT
    $sedt  = 'background:#04B404';		
    $ledt = 'background:#04B404';	
    if ($a["seeds"]==0)
    $sedt  = 'background:#FF0000';
	if ($a["leechers"]==0)
    $ledt  = 'background:#FF0000';
	if ($a["seeds"]== 1 OR $a["seeds"]== 2)
	$sedt  = 'background:#A9F5D0';	
	if ($a["leechers"]== 1 OR $a["leechers"] == 2)
    $ledt  = 'background:#A9F5D0';	
	if ($a["seeds"]==3 OR $a["seeds"]==4)
    $sedt  = 'background:#00FF80';		
	if ($a["leechers"]== 3 OR $a["leechers"] == 4)
    $ledt  = 'background:#00FF80';	
// end Peers Colors by DT

 $dldt="<a href=\"download.php?id=".$a["info_hash"]."&amp;f=" . urlencode($a["filename"]) . ".torrent\">".image_or_link("images/torrent.png","","torrent")."</a>\n";
       
    $catdt="<a href=\"index.php?page=torrents&amp;category=$a[catid]\">".image_or_link(($a["image"]==""?"":"$STYLEPATH/images/categories/" . $a["image"]),"",$a["cname"])."</a>";
	               
           $name = $a["filename"];
            
           $torrentss .= "<tr><td class=lista align=center>".$catdt."</td><td class=lista ><a href='index.php?page=torrent-details&id=" . $a["info_hash"] . "'><b>&nbsp;&nbsp;&nbsp;" . htmlspecialchars($name) . "</b></a></td><td class=lista align=center>".$dldt."</td><td class=lista align=center></td><td class=lista align=center></td><td class=lista align=center>" . date("d/m/Y",$a["added"]-$offset). "</td><td class=lista align=center></td><td class=lista style='text-align: center; $sedt'>".$a[seeds]."</td><td class=lista style='text-align: center; $ledt'>".$a[leechers]."</td><td class=lista align=center>".$a[completed]."</td><td class=lista align=center>". makesize($a[size]) ."</td><td class=lista align=center></td><td class=lista align=center></td><td class=lista align=center></td><td class=lista align=center></td><td class=lista align=center></td><td class=lista align=center></td></tr>\n";
           }
         $torrents[$i]["dtt"]=$torrentss;
         $torrents[$i]["dttt"]=$torrentsss;    
           }
       
unset($torrentss); 
unset($torrentsss); 
}
else
{
$torrents[$i]["dttt"]=""; 
$torrents[$i]["dtt"]="";
}
}
// Grouped Torrents end

if ($btit_settings["tag"]==true and ($data["tag"]))
{  

   if ($GLOBALS["usepopup"])
       $torrents[$i]["filename"]="<img src=\"images/plus.gif\" id=\"expandoGif".$data["hash"]."\" onclick=\"expand('".$data["hash"]."')\"> <a href=\"javascript:popdetails('index.php?page=torrent-details&amp;id=".$data["hash"]."');\" title=\"".$language["VIEW_DETAILS"].": ".($data["filename"]!=""?$filename:$data["hash"])."\" onmouseover=\" return overlib('<center>".$filename."</center><center><img src=" .$tdt. $balon . "  width=200 border=0></center><center>Category: ".$data["cname"]." Size: " . makesize($data["size"]) . "</center><center>Added:" . get_elapsed_time($data["added"]) . " ago</center><center><font color = green>Seeders: " . $data["seeds"] . "<font color = red> Leechers: " .$data["leechers"] . "<font color = purple> Done: " . $data["finished"] . "</font></center>', CENTER);\" onmouseout=\"return nd();\">".$data["filename"]."</a>&nbsp;$team&nbsp;<br/>".($data["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")." ".$ref."  ".$fl." ".$go." ".$dl." ".$mult."  ".$vt." ".$rt." ".$is_new." <div id=\"descr".$data["hash"]."\" style=\"margin-left: 12px; display: none;\">".$data["tag"];
   else
       $torrents[$i]["filename"]="<img src=\"images/plus.gif\" id=\"expandoGif".$data["hash"]."\" onclick=\"expand('".$data["hash"]."')\"> <a href=\"index.php?page=torrent-details&amp;id=".$data["hash"]."\" title=\"".$language["VIEW_DETAILS"].": ".$data["filename"]."\" onmouseover=\" return overlib('<center>".$filename."</center><center><img src=" .$tdt. $balon . "  width=200 border=0></center><center>Category: ".$data["cname"]." Size: " . makesize($data["size"]) . "</center><center>Added:" . get_elapsed_time($data["added"]) . " ago</center><center><font color = green>Seeders: " . $data["seeds"] . "<font color = red> Leechers: " .$data["leechers"] . "<font color = purple> Done: " . $data["finished"] . "</font></center>', CENTER);\" onmouseout=\"return nd();\">".($data["filename"]!=""?$filename:$data["hash"])."</a>&nbsp;$team&nbsp;<br/>".($data["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")." ".$ref." ".$fl." ".$go."  ".$dl." ".$mult."   ".$vt." ".$rt." ".$is_new." <div id=\"descr".$data["hash"]."\" style=\"margin-left: 12px; display: none;\">".$data["tag"];
}
else
{       

   if ($GLOBALS["usepopup"])
       $torrents[$i]["filename"]="<a href=\"javascript:popdetails('index.php?page=torrent-details&amp;id=".$data["hash"]."');\" title=\"".$language["VIEW_DETAILS"].": ".($data["filename"]!=""?$filename:$data["hash"])."\" onmouseover=\" return overlib('<center>".$filename."</center><center><img src=" .$tdt. $balon . "  width=200 border=0></center><center>Category: ".$data["cname"]." Size: " . makesize($data["size"]) . "</center><center>Added:" . get_elapsed_time($data["added"]) . " ago</center><center><font color = green>Seeders: " . $data["seeds"] . "<font color = red> Leechers: " .$data["leechers"] . "<font color = purple> Done: " . $data["finished"] . "</font></center>', CENTER);\" onmouseout=\"return nd();\">".$data["filename"]."</a>&nbsp;$team&nbsp;<br/>".($data["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")."  ".$ref." ".$dl." ".$fl."".$rt." ".$go." ".$mult."  ".$vt." ".$is_new;
   else
       $torrents[$i]["filename"]="<a href=\"index.php?page=torrent-details&amp;id=".$data["hash"]."\" title=\"".$language["VIEW_DETAILS"].": ".$data["filename"]."\" onmouseover=\" return overlib('<center>".$filename."</center><center><img src=" .$tdt. $balon . "  width=200 border=0></center><center>Category: ".$data["cname"]." Size: " . makesize($data["size"]) . "</center><center>Added:" . get_elapsed_time($data["added"]) . " ago</center><center><font color = green>Seeders: " . $data["seeds"] . "<font color = red> Leechers: " .$data["leechers"] . "<font color = purple> Done: " . $data["finished"] . "</font></center>', CENTER);\" onmouseout=\"return nd();\">".($data["filename"]!=""?$filename:$data["hash"])."</a>&nbsp;$team&nbsp;<br/>".($data["external"]=="no"?"":" (<span style=\"color:red\">EXT</span>)")." ".$ref." ".$fl." ".$go."   ".$dl." ".$mult." ".$rt."  ".$vt." ".$is_new;
}
   
// peers color by DT
    $torrents[$i]["seedcolor"] = 'background:#04B404';		

    $torrents[$i]["leechcolor"] = 'background:#04B404';	
    
	if ($data["seeds"]==0)
    $torrents[$i]["seedcolor"] = 'background:#FF0000';
	if ($data["leechers"]==0)
    $torrents[$i]["leechcolor"] = 'background:#FF0000';
	if ($data["seeds"]== 1 OR $data["seeds"]== 2)
	$torrents[$i]["seedcolor"] = 'background:#A9F5D0';	
	if ($data["leechers"]== 1 OR $data["leechers"] == 2)
    $torrents[$i]["leechcolor"] = 'background:#A9F5D0';	
	if ($data["seeds"]==3 OR $data["seeds"]==4)
    $torrents[$i]["seedcolor"] = 'background:#00FF80';		
	if ($data["leechers"]== 3 OR $data["leechers"] == 4)
    $torrents[$i]["leechcolor"] = 'background:#00FF80';	
// end peers color by DT

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

if ($data["language"] == "0") {
$torrents[$i]["language"]="<img src=\"images/flag/unknown.gif\" alt=\"Unknown\" title=\"Unknown\">";
} else if ($data["language"] == "1") {
$torrents[$i]["language"]="<img src=\"images/flag/gb.png\" alt=\"English\" title=\"English\">";
} else if ($data["language"] == "2") {
$torrents[$i]["language"]="<img src=\"images/flag/fr.png\" alt=\"French\" title=\"French\">";
} else if ($data["language"] == "3") {
$torrents[$i]["language"]="<img src=\"images/flag/nl.png\" alt=\"Dutch\" title=\"Dutch\">";
} else if ($data["language"] == "4") {
$torrents[$i]["language"]="<img src=\"images/flag/de.png\" alt=\"German\" title=\"German\">";
} else if ($data["language"] == "5") {
$torrents[$i]["language"]="<img src=\"images/flag/es.png\" alt=\"Spanish\" title=\"Spanish\">";
} else if ($data["language"] == "6") {
$torrents[$i]["language"]="<img src=\"images/flag/it.png\" alt=\"Italian\" title=\"Italian\">";
} else if ($data["language"] == "7") {
$torrents[$i]["language"]="<img src=\"images/flag/$customflag.png\" alt=\"$customlang\" title=\"$customlang\">";
} else if ($data["language"] == "8") {
$torrents[$i]["language"]="<img src=\"images/flag/$customflaga.png\" alt=\"$customlanga\" title=\"$customlanga\">";
} else if ($data["language"] == "9") {
$torrents[$i]["language"]="<img src=\"images/flag/$customflagb.png\" alt=\"$customlangb\" title=\"$customlangb\">";
} else if ($data["language"] == "10") {
$torrents[$i]["language"]="<img src=\"images/flag/$customflagc.png\" alt=\"$customlangc\" title=\"$customlangc\">";
}
}
// language 

$torrents[$i]["comments"]="---";

$torrents[$i]["rating"]=$language["NA"];

if (intval($CURUSER["WT"])>0)
      {
      $wait=0;
      if (intval($CURUSER['downloaded'])>0) $ratio=number_format($CURUSER['uploaded']/$CURUSER['downloaded'],2);
      else $ratio=0.0;
      $vz = $data["added"];
      $timer = floor((time() - $vz) / 3600);
      if($ratio<1.0 && $CURUSER['uid']!=$data["uploader"]){
          $wait=$CURUSER["WT"];
      }
      $wait -=$timer;

      if ($wait<=0)$wait=0;
     if (strlen($data["hash"]) > 0)
          $torrents[$i]["waiting"]=($wait>0?$wait." h":"---");
//end waitingtime
   }
   else $torrents[$i]["waiting"]="";
$ba2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}recommended WHERE info_hash ='$data[hash]'");
$ba = mysqli_fetch_array($ba2);

if ($data["hash"]==$ba["info_hash"]){
if ($btit_settings["show_recommended"] == true && $CURUSER["edit_users"]=="yes")
$torrents[$i]["recommended"]="<td align=\"center\" width=\"45\" class=\"lista\" style=\"text-align: center;background:$dttd\"><img src='images/alreadyis.png' width=100 height=30></td>";  
}
else
if ($btit_settings["show_recommended"] == true && $CURUSER["edit_users"]=="yes")
$torrents[$i]["recommended"]="<td align=\"center\" width=\"45\" class=\"lista\" style=\"text-align: center;background:$dttd\"><a href=index.php?page=torrents&action=add&info_hash=".$data["hash"].">".image_or_link("images/recomend.png"," width=100 height=30","Recommend")."</a></td>";

if ($CURUSER["edit_users"]=="yes" OR $btit_settings["toup"]== true)
$torrents[$i]["top"]="<td align=\"center\" width=\"45\" class=\"lista\" style=\"text-align: center;background:$dttd\"><a href=index.php?page=torrents&action=up&info_hash=".$data["hash"].">".image_or_link("images/go_top.png","Up")."</a></td>";

   $torrents[$i]["download"]="<a href=\"download.php?id=".$data["hash"]."&amp;f=" . urlencode($data["filename"]) . ".torrent\">".image_or_link("images/torrent.png","","torrent")."</a>\n";
   
   $torrents[$i]["bookmark"]="<a href=index.php?page=bookmark&do=add&torrent_id=".$data["hash"]."><img src=\"images/bookmark.png\" /></a>\n";
   include("include/offset.php");
   $torrents[$i]["added"]=date("d/m/Y",$data["added"]-$offset); // data

// start torrent age
$time_A = strtotime(date("d-m-Y",$data["added"]-$offset));
$time_B=strtotime(now);
$numdays=intval(($time_B-$time_A)/86400);
if ($btit_settings["show_days"] == false )
{
if ($numdays <= $btit_settings["child"])
$DT = '<center><img src=images/baby.gif alt="'.$numdays.' days"></center>';

else if ($numdays > $btit_settings["child"] && $numdays <= $btit_settings["grown"])
$DT = '<center><img src=images/child.gif alt="'.$numdays.' days"></center>';

else if ($numdays > $btit_settings["grown"] && $numdays <= $btit_settings["old"])
$DT = '<center><img src=images/grown.gif alt="'.$numdays.' days"></center>';

else if ($numdays > $btit_settings["old"])
$DT = '<center><img src=images/old.gif alt="'.$numdays.' days"></center>';

}
if ($btit_settings["show_days"] == true )
$DT = $numdays." days" ;

$torrents[$i]["age"]=$DT;
// end torrent age
            
   $torrents[$i]["size"]=makesize($data["size"]);
   
if ($CURUSER["uid"]>1 && ($CURUSER["uid"]==$data["upname"] || $CURUSER["edit_torrents"]=="yes" || $CURUSER["delete_torrents"]=="yes"))
   {
  $allow1="<td class=lista align=center style=\"text-align: center;background:$dttd\"><input type=checkbox name=msg[] value=".$data["hash"]."></td></tr>";
  $owntor++;
  }
  else{
  $allow1="<td class=lista align=center style=\"text-align: center;\"></td>";
}

//Uploaders nick details
   if ($data["anonymous"] == "true")
    $torrents[$i]["uploader"]=$language["ANONYMOUS"];
   elseif ($data["anonymous"] == "false")
    $torrents[$i]["uploader"]="<a href=\"index.php?page=userdetails&amp;id=" . $data["upname"] . "\">".StripSlashes($data['prefixcolor'].$data["uploader"].$data['suffixcolor'])."</a>";
//Uploaders nick details

   if ($data["external"]=="no")
      {
       if ($GLOBALS["usepopup"])
         {
         $torrents[$i]["classe_seeds"]=linkcolor($data["seeds"]);
         $torrents[$i]["seeds"]="<a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$data["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">" . $data["seeds"] . "</a>";
         $torrents[$i]["classe_leechers"]=linkcolor($data["leechers"]);
         $torrents[$i]["leechers"]="<a href=\"javascript:poppeer('index.php?page=peers&amp;id=".$data["hash"]."');\" title=\"".$language["PEERS_DETAILS"]."\">" .$data["leechers"] . "</a>";
         if ($data["finished"]>0)
            $torrents[$i]["complete"]="<a href=\"javascript:poppeer('index.php?page=torrent_history&amp;id=".$data["hash"]."');\" title=\"History - ".$data["filename"]."\">" . $data["finished"] . "</a>";
         else
             $torrents[$i]["complete"]="---";
         }
       else
         {
         $torrents[$i]["classe_seeds"]=linkcolor($data["seeds"]);
         $torrents[$i]["seeds"]="<a href=\"index.php?page=peers&amp;id=".$data["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">" . $data["seeds"] . "</a>";
         $torrents[$i]["classe_leechers"]=linkcolor($data["leechers"]);
         $torrents[$i]["leechers"]="<a href=\"index.php?page=peers&amp;id=".$data["hash"]."\" title=\"".$language["PEERS_DETAILS"]."\">" .$data["leechers"] . "</a>";
         if ($data["finished"]>0)
            $torrents[$i]["complete"]="<a href=\"index.php?page=torrent_history&amp;id=".$data["hash"]."\" title=\"History - ".$data["filename"]."\">" . $data["finished"] . "</a>";
         else
             $torrents[$i]["complete"]="---";
         }
      }
   else
       {
// linkcolor
       $torrents[$i]["classe_seeds"]=linkcolor($data["seeds"]);
       $torrents[$i]["seeds"]=$data["seeds"];
       $torrents[$i]["classe_leechers"]=linkcolor($data["leechers"]);
       $torrents[$i]["leechers"]=$data["leechers"];
       if ($data["finished"]>0)
          $torrents[$i]["complete"]=$data["finished"];
       else
           $torrents[$i]["complete"]="---";
   }
   if ($data["dwned"]>0)
      $torrents[$i]["downloaded"]=makesize($data["dwned"]);
   else
       $torrents[$i]["downloaded"]=$language["NA"];

   if (!$XBTT_USE)
     {
       if ($data["speed"] < 0 || $data["external"]=="yes") {
          $speed = $language["NA"];
       }
           else if ($data["speed"] > 2097152) {
                $speed = round($data["speed"]/1048576,2) . " MB/sec";
       }
           else {
                   $speed = round($data["speed"] / 1024, 2) . " KB/sec";
       }
   }
   
$torrents[$i]["filename"].="&nbsp;$sub&nbsp";
$torrents[$i]["speed"]=$speed;

// Split torrents by hasu
 if ($btit_settings["torday"] == true )
 {
  $day_added = $data['added'];
        $day_show = date($day_added);
        $thisdate = date('M d Y', $day_show);
/** If date already exist, disable $cleandate varible **/

 if (isset($prevdate) && $thisdate == $prevdate) {
        $cleandate = '';

/** If date does not exist, make some varibles **/
}else{
$day_added = " Torrents Added on ".date("Y M D,d",$data["added"]); // You can change this to something else
$cleandate = "<tr><td align='center' class='header' colspan='17'><b>$day_added</b></td></tr>\n"; // This also...
$torrents[$i]["dt"]=$cleandate;
}
/** Prevent that "torrents added..." wont appear again with the same date **/
$prevdate = $thisdate;

$man = array('Jan' => 'January',
        'Feb' => 'February',
        'Mar' => 'March',
        'Apr' => 'April',
        'May' => 'May',
        'Jun' => 'June',
        'Jul' => 'July',
        'Aug' => 'August',
        'Sep' => 'September',
        'Oct' => 'October',
        'Nov' => 'November',
        'Dec' => 'December'
        );

foreach($man as $eng => $ger){
        $cleandate = str_replace($eng, $ger,$cleandate);
}
$dag = array(
        'Mon' => 'Monday',
        'Tues' => 'Tuesday',
        'Wednes' => 'Wednesday',
        'Thurs' => 'Thursday',
        'Fri' => 'Friday',
        'Satur' => 'Saturday',
        'Sun' => 'Sunday'
);

foreach($dag as $eng => $ger){
        $cleandate = str_replace($eng.'day', $ger.'',$cleandate);
		
}
}

// Split torrents by hasu

if ($btit_settings["magnet"] == true) 
$torrents[$i]["magnet"]=" <td align=\"center\" width=\"20\" class=\"lista\" style=\"text-align: center; background:$dttd\"><a href=magnet:?xt=urn:btih:".strtoupper(base32_encode(pack('H*' ,$data["hash"]))). ">".image_or_link("images/magnet.png","","Magnet Link")."</a></td>";
  
// progress
  if ($data["external"]=="yes")
     $prgsf=$language["NA"];
  else {
       $id = $data['hash'];
       if ($XBTT_USE)
          $subres = get_result("SELECT sum(IFNULL(xfu.left,0)) as to_go, count(xfu.uid) as numpeers FROM xbt_files_users xfu INNER JOIN xbt_files xf ON xf.fid=xfu.fid WHERE xf.info_hash=UNHEX('$id') AND xfu.active=1",true,$btit_settings['cache_duration']);
       else
           $subres = get_result("SELECT sum(IFNULL(bytes,0)) as to_go, count(*) as numpeers FROM {$TABLE_PREFIX}peers where infohash='$id'",true,$btit_settings['cache_duration']);
       $subres2 = get_result("SELECT size FROM {$TABLE_PREFIX}files WHERE info_hash ='$id'",true,$btit_settings['cache_duration']);
       $torrent = $subres2[0];
       $subrow = $subres[0];
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
  $torrents[$i]["average"]="".$prgsf."<br />".$progressbar."";
	  $torrents[$i]["allow"]=$allow1;
	  
	  if ($CURUSER["uid"]>1 && ($CURUSER["uid"]==$data["upname"] || $CURUSER["edit_torrents"]=="yes" || $CURUSER["delete_torrents"]=="yes"))
   {
  $allow1="<td class=lista align=center style=\"text-align: center;\"><input type=checkbox name=msg[] value=".$data["hash"]."></td></tr>";
  $owntor++;
  }
  else{
  $allow1="<td class=lista align=center style=\"text-align: center;\"></td>";
}

		$i++;
	}
  }
} // if count

// assign array to loop tag
if ($owntor>0){
$delit="<td align=right colspan=15><input onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\" class=\"btn\" type=submit name=action value=Delete></td>";
}
$torrenttpl->set("delit",$delit);
$torrenttpl->set("torrents",$torrents);
$torrenttpl->set("tora",$tora);
?>