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
require(load_language("lang_blackjack.php"));

$blackjacktpl = new bTemplate();
$blackjacktpl->set("language", $language);
$blackjacktpl->set("self","index.php?page=blackjack");
$blackjacktpl->set("START",FALSE,TRUE);
$blackjacktpl->set("HIT_DISABLE",FALSE,TRUE);
$blackjacktpl->set("STAND_DISABLE",FALSE,TRUE);
$blackjacktpl->set("WINNER",FALSE,TRUE);
$blackjacktpl->set("GAMEOVER",FALSE,TRUE);
$blackjacktpl->set("INSUFFICIENT_CREDIT",FALSE,TRUE);


if ($_POST["DEAL"])
{
    $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `gameid` FROM `{$TABLE_PREFIX}blackjack` WHERE `userid`=".$CURUSER["uid"]);
    if(@mysqli_num_rows($res)>0)
    {
        $row=mysqli_fetch_assoc($res);
        err_msg($language["ERROR"], $language["ACTIVE_GAME_1"]."<a href='index.php?page=blackjack&amp;resume=".$row["gameid"]."'>".$language["CLICK_HERE"]."</a>".$language["ACTIVE_GAME_2"]);
        block_end();
        stdfoot();
        exit();
    }
    
    $bet=$btit_settings["bj_blackjack_stake"];

    if($XBTT_USE)
        @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `xbt_users` SET `uploaded`=`uploaded`-$bet WHERE `uid`=".$CURUSER["uid"]);
    else
        @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=`uploaded`-$bet WHERE `id`=".$CURUSER["uid"]);

    $cards=get_shuffled_cards();

    $shuffled_cards=explode(",",$cards);

    $playerhand=$shuffled_cards[0].",".$shuffled_cards[2];
    $hand=get_blackjack_score(array($shuffled_cards[0],$shuffled_cards[2]));
    $player["score"]=$hand[0];
    $player["img"]=$hand[1];
    if($player["score"]==21)
        $blackjacktpl->set("HIT_DISABLE",TRUE,TRUE);

    $dealerhand=$shuffled_cards[1].",".$shuffled_cards[3];
    $dealer["img"]="<img src='images/cards/$shuffled_cards[1].png'><img src='images/cards/back.png'>";
    $dealer["score"]="?";

    unset($shuffled_cards[0],$shuffled_cards[1],$shuffled_cards[2],$shuffled_cards[3]);
    $cards=implode(",",$shuffled_cards);

    $query="INSERT INTO `{$TABLE_PREFIX}blackjack` (userid, dealerhand, playerhand, remaining_cards) VALUES (".$CURUSER["uid"].", '$dealerhand', '$playerhand', '$cards')";
    @mysqli_query($GLOBALS["___mysqli_ston"], $query);
    $gameid=((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

    $blackjacktpl->set("dealer",$dealer);
    $blackjacktpl->set("player",$player);
    $blackjacktpl->set("gameid",$gameid);
}
elseif($_POST["hit"])
{
    $gameid=intval($_POST["gameid"]);

    $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `{$TABLE_PREFIX}blackjack` WHERE gameid=$gameid") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row=mysqli_fetch_assoc($res);
  
    $dealerhand=explode(",", $row["dealerhand"]);
    $playerhand=explode(",", $row["playerhand"]);
    $currscore=get_blackjack_score($playerhand);
    $cards=explode(",", $row["remaining_cards"]);

    if($row["playerbust"]=="no" && $currscore[0]<22)
    {
        $playerhand[]=$cards[0];
        $dealer["score"]="?";
        $dealer["img"]="<img src='images/cards/$dealerhand[0].png'><img src='images/cards/back.png'>";
    }
    else
    {
        $hand=get_blackjack_score($dealerhand);
        $dealer["score"]=$hand[0];
        $dealer["img"]=$hand[1];
    }

    $hand=get_blackjack_score($playerhand);
    $player["score"]=$hand[0];
    $player["img"]=$hand[1];

    if($player["score"]>=21)
    $blackjacktpl->set("HIT_DISABLE",TRUE,TRUE);
    $blackjacktpl->set("dealer",$dealer);
    $blackjacktpl->set("player",$player);
    $blackjacktpl->set("gameid",$gameid);
    unset($cards[0]);
    $query="UPDATE `{$TABLE_PREFIX}blackjack` SET `playerhand`='".implode(",",$playerhand)."', `remaining_cards`='".implode(",", $cards)."'".(($player["score"]>21)?", playerbust='yes'":"")." WHERE `gameid`=$gameid";
    @mysqli_query($GLOBALS["___mysqli_ston"], $query);
    
}
elseif($_POST["stand"])
{
    $blackjacktpl->set("HIT_DISABLE",TRUE,TRUE);
    $blackjacktpl->set("STAND_DISABLE",TRUE,TRUE);
    $blackjacktpl->set("GAMEOVER",TRUE,TRUE);

    $gameid=intval($_POST["gameid"]);

    $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `b`.*, `u`.`blackjack_stats`  FROM `{$TABLE_PREFIX}blackjack` `b` LEFT JOIN `{$TABLE_PREFIX}users` `u` ON `b`.`userid`=`u`.`id`  WHERE `b`.`gameid`=".$gameid) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
 
    if(@mysqli_num_rows($res)==0)
    {
        err_msg($language["ERROR"], "This game no longer exists!");
        block_end();
        stdfoot();
        exit();
    }
 
    $row=mysqli_fetch_assoc($res);

    if(!empty($row["blackjack_stats"]))
        $bjstats=unserialize($row["blackjack_stats"]);
    else
	{ 
	    $bjstats["playcount"]=0;
	    $bjstats["wincount"]=0;
	    $bjstats["losscount"]=0;
	    $bjstats["drawcount"]=0;
	    $bjstats["bjcount"]=0;
	    $bjstats["winloss"]=0;
    }
    $dealerhand=explode(",", $row["dealerhand"]);
    $playerhand=explode(",", $row["playerhand"]);
    $cards=explode(",", $row["remaining_cards"]);

    $dhand=get_blackjack_score($dealerhand);
    $dealer["score"]=$dhand[0];
    $dealer["img"]=$dhand[1];
    
    $phand=get_blackjack_score($playerhand);
    $player["score"]=$phand[0];
    $player["img"]=$phand[1];

    $blackjacktpl->set("dealer",$dealer);
    $blackjacktpl->set("player",$player);
    $blackjacktpl->set("gameid",$gameid);
    if($row["playerbust"]=="no" && !(count($playerhand)==2 && $player["score"]==21))
    {    
        $i=0;
        while($dealer["score"]<17)
        {
            $dealerhand[]=$cards[$i];
            $dhand=get_blackjack_score($dealerhand);
            $dealer["score"]=$dhand[0];
            $dealer["img"]=$dhand[1];
            @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}blackjack` SET `dealerhand`='".implode(",",$dealerhand)."', `remaining_cards`='".implode(",", $cards)."' WHERE `gameid`=$gameid");
            unset($cards[$i]);
            $i++;
        }
        $blackjacktpl->set("dealer",$dealer);
    }
    $blackjacktpl->set("WINNER",TRUE,TRUE);
    if($dealer["score"]>21 || ($player["score"]<=21 && $player["score"]>$dealer["score"]))
    {
        $winnings=$btit_settings["bj_blackjack_stake"]*((count($playerhand)==2 && $player["score"]==21)?$btit_settings["bj_blackjack_prize"]:$btit_settings["bj_normal_prize"])+$btit_settings["bj_blackjack_stake"];
        $blackjacktpl->set("winneris",$language["YOU_WIN"]);
        
	    $bjstats["playcount"]+=1;
	    $bjstats["wincount"]+=1;
        if(count($playerhand)==2 && $player["score"]==21)
	        $bjstats["bjcount"]+=1;
	    $bjstats["winloss"]+=($winnings-$btit_settings["bj_blackjack_stake"]);
		$bjstats=serialize($bjstats);        

        if($XBTT_USE)
        {
            @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `xbt_users` SET `uploaded`=`uploaded`+".$winnings." WHERE `uid`=".$CURUSER["uid"]);
            @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `blackjack_stats`='$bjstats' WHERE `id`=".$CURUSER["uid"]);
        }
        else
            @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=`uploaded`+".$winnings.", `blackjack_stats`='$bjstats' WHERE `id`=".$CURUSER["uid"]);

        @mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM `{$TABLE_PREFIX}blackjack` WHERE `gameid`=$gameid");
    }
    elseif($player["score"]>21 || $player["score"]<$dealer["score"])
    {
        $blackjacktpl->set("winneris",$language["YOU_LOSE"]);

	    $bjstats["playcount"]+=1;
	    $bjstats["losscount"]+=1;
	    $bjstats["winloss"]-=$btit_settings["bj_blackjack_stake"];
	    $bjstats=serialize($bjstats);
        @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `blackjack_stats`='$bjstats' WHERE `id`=".$CURUSER["uid"]);
        @mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM `{$TABLE_PREFIX}blackjack` WHERE `gameid`=$gameid");
    }
    elseif(($player["score"]<=21 && $player["score"]==$dealer["score"]) && !(count($dealerhand)==2 && $dealer["score"]==21))
    {
        $blackjacktpl->set("winneris",$language["PUSH"]);
        $returnstake=$btit_settings["bj_blackjack_stake"];

	    $bjstats["playcount"]+=1;
	    $bjstats["drawcount"]+=1;
        $bjstats=serialize($bjstats);


        if($XBTT_USE)
        {
            @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `xbt_users` SET `uploaded`=`uploaded`+".$returnstake." WHERE `uid`=".$CURUSER["uid"]);
            @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `blackjack_stats`='$bjstats' WHERE `id`=".$CURUSER["uid"]);
        }
        else
            @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=`uploaded`+".$returnstake.", `blackjack_stats`='$bjstats' WHERE `id`=".$CURUSER["uid"]);

        @mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM `{$TABLE_PREFIX}blackjack` WHERE `gameid`=$gameid");
    }
    // Player has a score of 21 with more than 2 cards and the dealer has Blackjack (exception to the push rule)
	elseif(($player["score"]=21 && count($playerhand)>2) && (count($dealerhand)==2 && $dealer["score"]==21))
	{
        $blackjacktpl->set("winneris",$language["YOU_LOSE"]);
	    $bjstats["playcount"]+=1;
	    $bjstats["losscount"]+=1;
	    $bjstats["winloss"]-=$btit_settings["bj_blackjack_stake"];
	    $bjstats=serialize($bjstats);
        @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `blackjack_stats`='$bjstats' WHERE `id`=".$CURUSER["uid"]);
        @mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM `{$TABLE_PREFIX}blackjack` WHERE `gameid`=$gameid");

	}
    // Blackjack faceoff, both players have Blackjack so it's a Push
    elseif(($player["score"]=21 && count($playerhand)==2) && (count($dealerhand)==2 && $dealer["score"]==21))
	{
        $blackjacktpl->set("winneris",$language["PUSH"]);
        $returnstake=$btit_settings["bj_blackjack_stake"];

	    $bjstats["playcount"]+=1;
	    $bjstats["drawcount"]+=1;
        $bjstats=serialize($bjstats);

        if($XBTT_USE)
        {
            @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `xbt_users` SET `uploaded`=`uploaded`+".$returnstake." WHERE `uid`=".$CURUSER["uid"]);
            @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `blackjack_stats`='$bjstats' WHERE `id`=".$CURUSER["uid"]);
        }
        else
            @mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `{$TABLE_PREFIX}users` SET `uploaded`=`uploaded`+".$returnstake.", `blackjack_stats`='$bjstats' WHERE `id`=".$CURUSER["uid"]);

        @mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM `{$TABLE_PREFIX}blackjack` WHERE `gameid`=$gameid");

	}
	
	  
}
elseif($_GET["resume"])
{
    $gameid=intval($_GET["resume"]);
    $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM `{$TABLE_PREFIX}blackjack` WHERE `gameid`=$gameid");
    if(@mysqli_num_rows($res)>0)
        $row=mysqli_fetch_assoc($res);
    else
    {
        err_msg($language["ERROR"], "Game not found");
        block_end();
        stdfoot();
        exit();
    }
    
    $dealerhand=explode(",", $row["dealerhand"]);
    $playerhand=explode(",", $row["playerhand"]);

    if($row["playerbust"]!="yes")
    {
        $dealer["score"]="?";
        $dealer["img"]="<img src='images/cards/$dealerhand[0].png'><img src='images/cards/back.png'>";
    }
    else
    {
        $hand=get_blackjack_score($dealerhand);
        $dealer["score"]=$hand[0];
        $dealer["img"]=$hand[1];
    }

    $hand=get_blackjack_score($playerhand);
    $player["score"]=$hand[0];
    $player["img"]=$hand[1];

    
    if($player["score"]>=21)
        $blackjacktpl->set("HIT_DISABLE",TRUE,TRUE);
    $blackjacktpl->set("dealer",$dealer);
    $blackjacktpl->set("player",$player);
    $blackjacktpl->set("gameid",$gameid);
}
else
{

    if($XBTT_USE)
    {
        $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `uploaded` FROM `xbt_users` WHERE `uid`=".$CURUSER["uid"]);
    }
    else
        $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `uploaded` FROM `{$TABLE_PREFIX}users` WHERE `id`=".$CURUSER["uid"]);

    $row=mysqli_fetch_assoc($res);
    $blackjacktpl->set("START",TRUE,TRUE);
    $blackjacktpl->set("bjimg","<img src='images/cards/blackjack.gif'>");
    $blackjacktpl->set("continue_disabled",(($row["uploaded"]<$btit_settings["bj_blackjack_stake"])?TRUE:FALSE),TRUE);
    if($row["uploaded"]<$btit_settings["bj_blackjack_stake"])
	    $blackjacktpl->set("INSUFFICIENT_CREDIT",TRUE,TRUE);
}

function get_blackjack_score($hand)
{
    $score=0;
    $img="";
    $acecount=0;
    foreach($hand as $v)
    {
        if(substr($v,0,1)=="a")
            $acecount++;
        $score+=str_replace("a", 0, str_replace(array("t","j","q","k"),"10",$v));
        $img.="<img src='images/cards/$v.png'>";
    }
    
    if($acecount>0)
    {
        if($acecount==4)
        {
            if($score<=7)
                $score+=14;
            else
                $score+=4;
        }
        elseif($acecount==3)
        {
            if($score<=8)
                $score+=13;
            else
                $score+=3;
        }
        elseif($acecount==2)
        {
            if($score<=9)
                $score+=12;
            else
                $score+=2;
        }
        elseif($acecount==1)
        {
            if($score<=10)
                $score+=11;
            else
                $score+=1;
        }
    }
    return array($score, $img);
}

function get_shuffled_cards()
{
    $cards=array("2c","3c","4c","5c","6c","7c","8c","9c","tc","jc","qc","kc","ac","2d","3d","4d","5d","6d","7d","8d","9d","td","jd","qd","kd","ad","2h","3h","4h","5h","6h","7h","8h","9h","th","jh","qh","kh","ah","2s","3s","4s","5s","6s","7s","8s","9s","ts","js","qs","ks","as");

    // Shuffle the deck
    shuffle($cards);

    foreach($cards as $v)
    {
        $shuffled_cards.=$v.",";
    }

    return trim($shuffled_cards, ",");
}

?>