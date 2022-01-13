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
global $TABLE_PREFIX,$btit_settings;
 $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}flashscores ORDER BY id DESC");
 $scores = mysqli_fetch_assoc($result);
  
 $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) AS count FROM {$TABLE_PREFIX}flashscores") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $data = mysqli_fetch_assoc($query);
  
  $ct=$data["count"];
  
  $count ='<center><b><font color = steelblue>Total Games Played:<font color = red> '.$ct.'</b></font></center>';
  
  $res = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}flashscores WHERE game = ".$scores["game"]." ORDER BY score DESC");
  $scor = mysqli_fetch_assoc($res);
 
  $resultt = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id WHERE u.id=".$scores["user"]);
  $scorest = mysqli_fetch_assoc($resultt);
  
  $resulttt = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id  WHERE u.id=".$scor["user"]);
  $scorestt = mysqli_fetch_assoc($resulttt);
  
  $username = ($scorest["prefixcolor"].$scorest["username"].$scorest["suffixcolor"]);
  $usernam = ($scorestt["prefixcolor"].$scorestt["username"].$scorestt["suffixcolor"]);
  
 if ($scores["game"]==1)
 {$game='<a href=index.php?page=flash&gameURI=yeti1.swf&gamename=yeti1&gameid=1><img src="flash/yeti11.gif"></img></a>';}
  if ($scores["game"]==2)
 {$game='<a href=index.php?page=flash&gameURI=yetitoursm.swf&gamename=yetitoursm&gameid=2><img src="flash/yetitoursm1.gif"></img></a>';}
  if ($scores["game"]==3)
 {$game='<a href=index.php?page=flash&gameURI=yeti7.swf&gamename=yeti7_stagedive&gameid=3><img src="flash/yeti71.gif"></img></a>';}
  if ($scores["game"]==4)
 {$game='<a href=index.php?page=flash&gameURI=yeti6.swf&gamename=BigWave&gameid=4><img src="flash/yeti61.gif"></img></a>';}
  if ($scores["game"]==5)
 {$game='<a href=index.php?page=flash&gameURI=yeti5pro.swf&gamename=yeti5pro&gameid=5><img src="flash/yeti5pro1.gif"></img></a>';}
  if ($scores["game"]==6)
 {$game='<a href=index.php?page=flash&gameURI=pacman.swf&gamename=Pac-Man&gameid=6><img src="flash/pacman.gif"></a>';}
  if ($scores["game"]==7)
 {$game='<a href=index.php?page=flash&gameURI=yeti4.swf&gamename=yeti4&gameid=7><img src="flash/yeti41.gif"></img></a>';}
  if ($scores["game"]==8)
 {$game='<a href=index.php?page=flash&gameURI=summergames04.swf&gamename=summergames04&gameid=8><img src="flash/summergames041.gif"></img></a>';}
  if ($scores["game"]==9)
 {$game='<a href=index.php?page=flash&gameURI=yeti_stagedive.swf&gamename=yeti_stagedive&gameid=9><img src="flash/yeti_stagedive1.gif"></img></a>';}
  if ($scores["game"]==10)
 {$game='<a href=index.php?page=flash&gameURI=BubbleShooterSte.swf&gamename=BubbleShooterSte&gameid=10><img src="flash/BubbleShooterSte1.gif"></a>';}
   if ($scores["game"]==11)
 {$game='<a href=index.php?page=flash&gameURI=SuperFlashMarioBrosSte.swf&gamename=SuperFlashMarioBrosSte&gameid=11><img src="flash/SuperFlashMarioBrosSte1.gif"></img></a>';}
  if ($scores["game"]==12)
 {$game='<a href=index.php?page=flash&gameURI=blackknight.swf&gamename=blackknight&gameid=12><img src="flash/blackknight1.gif"></img></a>';}
   if ($scores["game"]==13)
 {$game='<a href=index.php?page=flash&gameURI=matrix_dock_defense_Ste.swf&gamename=matrix_dock_defense_Ste&gameid=13><img src="flash/matrix_dock_defense_Ste1.gif"></a>';}
   if ($scores["game"]==14)
 {$game='<a href=index.php?page=flash&gameURI=fishermansam.swf&gamename=fishermansam&gameid=14><img src="flash/fishermansam1.gif"></img></a>';}
  if ($scores["game"]==15)
 {$game='<a href=index.php?page=flash&gameURI=alloyarena.swf&gamename=alloyarena&gameid=15><img src="flash/alloyarena1.gif"></img></a>';}
    if ($scores["game"]==16)
 {$game='<a href=index.php?page=flash&gameURI=BabycalThrowSte.swf&gamename=BabycalThrowSte&gameid=16><img src="flash/BabycalThrowSte1.gif"></a>';}
   if ($scores["game"]==17)
 {$game='<a href=index.php?page=flash&gameURI=junglekidSte.swf&gamename=junglekidSte&gameid=17><img src="flash/junglekidSte1.gif"></img></a>';}
  if ($scores["game"]==18)
 {$game='<a href=index.php?page=flash&gameURI=supersplashBH.swf&gamename=supersplashBH&gameid=18><img src="flash/supersplashBH1.gif"></img></a>';}
 
    if ($scores["game"]==19)
 {$game='<a href=index.php?page=flash&gameURI=autobahn.swf&gamename=matrix_autobahn&gameid=19><img src="flash/autobahn1.gif"></a>';}
   if ($scores["game"]==20)
 {$game='<a href=index.php?page=flash&gameURI=chainreactionGS.swf&gamename=chainreactionGS&gameid=20><img src="flash/chainreactionGS1.gif"></img></a>';}
  if ($scores["game"]==21)
 {$game='<a href=index.php?page=flash&gameURI=yeti9v32JS.swf&gamename=yeti9v32JS&gameid=21><img src="flash/y10.gif"></img></a>';}
    if ($scores["game"]==22)
 {$game='<a href=index.php?page=flash&gameURI=DestroyAllHumansSte.swf&gamename=DestroyAllHumansSte&gameid=22><img src="flash/DestroyAllHumansSte1.gif"></a>';}
   if ($scores["game"]==23)
 {$game='<a href=index.php?page=flash&gameURI=sonicblox.swf&gamename=sonicblox&gameid=23><img src="flash/sonicblox1.gif"></img></a>';}
  if ($scores["game"]==24)
 {$game='<a href=index.php?page=flash&gameURI=trappedinawell.swf&gamename=trappedinawell&gameid=24><img src="flash/trappedinawell1.gif"></img></a>';}

 
$print ='<br/><b><font color = steelblue><center>Last played: <br/><center>'.$game.'<br/>Score:<font color = red> '.$scores["score"].'</font><br/><font color = steelblue>By: <a href="index.php?page=userdetails&id='.$scores["user"].'">'.$username.'</a><br/>Top Score:<font color = red> '.$scor["score"].'</font><br/>By: <a href="index.php?page=userdetails&id='.$scor["user"].'">'.$usernam.'</a><img src="images/trophy_goud.png"></img></b></font>';

?>
<table width="100%"><center>
<?php

print $print  ;

?>

<tr><td align="center"><a href="index.php?page=arcadex"><img src=images/arcade.png><td></a><td></tr></center>
<tr><td align="center"><a href="index.php?page=modules&module=flashscores"><br><img src=images/scores.gif><td></a><td></tr></center>

</form>
</table><table class="lista"  width="100%"><center><br/>
<?php
print $count;
?>
</table>