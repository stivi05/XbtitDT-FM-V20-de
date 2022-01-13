<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Extended Featured Torrent Block Hack By DiemThuy sept 2012
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT fM.
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
//
////////////////////////////////////////////////////////////////////////////////////

global $BASEURL, $STYLEPATH, $dblist, $XBTT_USE,$btit_settings;

if ($XBTT_USE)
   {
    $tseeds="f.seeds+ifnull(x.seeders,0) as seeds";
    $tleechs="f.leechers+ifnull(x.leechers,0) as leechers";
    $tcompletes="f.finished+ifnull(x.completed,0) as finished";
    $ttables="{$TABLE_PREFIX}files f LEFT JOIN xbt_files x ON x.info_hash=f.bin_hash";
   }
else
    {
    $tseeds="f.seeds as seeds";
    $tleechs="f.leechers as leechers";
    $tcompletes="f.finished as finished";
    $ttables="{$TABLE_PREFIX}files f";
    }

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

if ($XBTT_USE)
    $rowcat = do_sqlquery("SELECT u.id, (u.downloaded+IFNULL(x.downloaded,0)) as downloaded, ((u.uploaded+IFNULL(x.uploaded,0))/(u.downloaded+IFNULL(x.downloaded,0))) as uratio, cp.* FROM {$TABLE_PREFIX}users u LEFT JOIN xbt_users x ON x.uid=u.id INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  else
    $rowcat = do_sqlquery("SELECT u.id, u.downloaded, (u.uploaded/u.downloaded) as uratio, cp.* FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}categories_perm cp ON u.id_level=cp.levelid WHERE u.id = ".$CURUSER["uid"].";",true);
  if (mysqli_num_rows($rowcat)>0)
     while ($catdata=mysqli_fetch_array($rowcat))
             if($catdata["viewtorrlist"]!="yes" && (($catdata["downloaded"]>=$GLOBALS["download_ratio"] && ($catdata["ratio"]>$catdata["uratio"]))||($catdata["downloaded"]<$GLOBALS["download_ratio"])||($catdata["ratio"]=="0")))
                $exclude.=' AND f.category!='.$catdata[catid];

    $sql = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}featured ORDER BY fid DESC limit 1");
    $result = mysqli_fetch_assoc($sql);

    $torrent = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT f.moder,f.imdb,f.image, f.info_hash, f.filename, f.url, UNIX_TIMESTAMP(f.data) as data, f.size, f.comment, f.uploader, c.name as cat_name, c.image as cat_image, c.id as cat_id, $tseeds, $tleechs, $tcompletes, f.speed, f.external, f.announce_url,UNIX_TIMESTAMP(f.lastupdate) as lastupdate,UNIX_TIMESTAMP(f.lastsuccess) as lastsuccess, f.anonymous, u.username FROM $ttables LEFT JOIN {$TABLE_PREFIX}categories c ON c.id=f.category LEFT JOIN {$TABLE_PREFIX}users u ON u.id=f.uploader WHERE f.info_hash ='$result[torrent_id]' AND (".$CURUSER['team']." = f.team OR f.team = 0 OR ".$CURUSER['id_level']."> 7) $exclude $where AND f.moder = 'ok'");

    $tor = mysqli_fetch_assoc($torrent);
    
// progress
       $id = $tor['info_hash'];
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
// progress end

// speed
if ($tor["speed"] <= 1)
$speed = 0; 
else
$speed = $tor["speed"]/1048576 ;
// speed end
           
?>
<center><table width=99% border=0 style="border:0px;padding:5px">
<tr>
<td colspan=3 >

	<h2><b><center><a href="index.php?page=torrent-details&id=<?php echo $tor[info_hash]; ?>">
    <font color =red><?php
    echo $tor[filename];
    ?></font></a></b></center>
</td></tr>
<tr >
<td >
		<!-- INCLUDE THE FOLLOWING JGAUGE REQUIREMENTS... -->
		<link rel="stylesheet" href="jscript/jgauge.css" type="text/css" /> <!-- CSS for jGauge styling. -->
		<!--[if IE]><script type="text/javascript" language="javascript" src="jscript/excanvas.min.js"></script><![endif]--> <!-- Extends canvas support to IE. (Possibly buggy, need to look into this.) -->
		<script language="javascript" type="text/javascript" src="jscript/jquery.js"></script> <!-- jQuery JavaScript library. -->
		<script language="javascript" type="text/javascript" src="jscript/jQueryRotate.min.js"></script> <!-- jQueryRotate plugin used for needle movement. -->
		<script language="javascript" type="text/javascript" src="jscript/jgauge-0.3.0.a3.js"></script> <!-- jGauge JavaScript. -->

<div id="jGaugeDemo1" class="jgauge"></div> 
<div id="jGaugeDemo2" class="jgauge"></div> 
<div class="break"></div>

<script type="text/javascript">

   var dtGauge1 = new jGauge(); // Create a new jGauge.
   dtGauge1.id = 'jGaugeDemo1'; // Link the new jGauge to the placeholder DIV.
   dtGauge1.label.suffix = 'MB/s';
   
   // This function is called by jQuery once the page has finished loading.
   $(document).ready(function(){
      dtGauge1.init(); // Put the jGauge on the page by initialising it.
      
       dtGauge1.setValue(<?php echo $speed ?>); 

   });
</script> 

<script type="text/javascript">
   var dtGauge2 = new jGauge(); // Create a new jGauge.
   dtGauge2.id = 'jGaugeDemo2'; // Link the new jGauge to the placeholder DIV.
   dtGauge2.label.suffix = '%';
   
   // This function is called by jQuery once the page has finished loading.
   $(document).ready(function(){
      dtGauge2.init(); // Put the jGauge on the page by initialising it.
      
       dtGauge2.setValue(<?php echo $prgsf ?>); 

   });
</script> 
			
</td><td align = right>
			<span class="chart">

<?php
// imdb image
if ($btit_settings["imdbbl"]==true )
{  
require_once ("imdb/imdb.class.php");
  $movie = new imdb($tor["imdb"]);
  $movie->photodir='./imdb/images/';
  $movie->photoroot='./imdb/images/';
  if (($photo_url = $movie->photo_localurl() ) != FALSE)
print "<img style='width:250px' src='$photo_url'   />";
// imdb image  
}
else
{
if  ($tor['image']=="")
print "<img style='width:400px' src='torrentimg/nocover.jpg'   />";
else
{  
$featimg = $tor['image'];
if ($btit_settings["imgsw"]==false ) 
print "<img style='width:400px' src='$featimg'   />";
else
print "<img style='width:400px' src='torrentimg/$featimg'   />";
}
}
?>
</span>        
</td></tr>
<tr>
<td colspan=3>	
	<div class="foot">
	<center><a href="index.php?page=torrent-details&id=<?php echo $tor[info_hash]; ?>" alt="Torrent Details"><img src='images/download2.png'</a></center>
</div>
</div></td></tr></table> 