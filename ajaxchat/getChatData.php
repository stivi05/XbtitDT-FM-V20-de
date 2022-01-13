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

  /*################################################################
  #
  #         Ajax MySQL shoutbox for btit
  #         Version  1.0
  #         Author : miskotes
  #         Created: 11/07/2007
  #         Contact: miskotes [at] yahoo.co.uk
  #         Website: YU-Corner.com
  #         Credits: linuxuser.at, plasticshore.com
  #
  ################################################################*/
  if ( !function_exists('get_cached_config') ) {
  require_once("format_shout.php");}
  
  require_once("../include/functions.php");
  
# Headers are sent to prevent browsers from caching.. IE is still resistent sometimes
header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header( "Cache-Control: no-cache, must-revalidate" ); 
header( "Pragma: no-cache" );
header("Content-Type: text/html; charset=UTF-8");

define("DELETE_CONFIRM", "If you are really sure you want to delete this click OK, othervise Cancel!");


# if no id of the last known message id is set to 0
if (!$lastID) { $lastID = 0; }

# call to retrieve all messages with an id greater than $lastID
getData($lastID);

# function that do retrieve all messages with an id greater than $lastID
function getData($lastID) {

  require_once("conn.php"); # getting connection data
  
  include("../include/settings.php");   # getting table prefix
  
  include("../include/offset.php");

global $CURUSER,$btit_settings;

if ($CURUSER["view_users"]!="yes") {
die("Sorry, Shoutbox is not available...");
}

    $shoutline=$btit_settings["shoutline"];
    $sql =  "SELECT * FROM {$TABLE_PREFIX}chat WHERE id > ".$lastID." AND `private`='no' OR (".$CURUSER['uid']." = `toid` OR ".$CURUSER['uid']."= `fromid` AND `private`='yes') ORDER BY id DESC LIMIT $shoutline";
    $conn = getDBConnection(); # establishes the connection to the database
    $results = mysqli_query( $conn, $sql);
    
    # getting the data array
    while ($row = mysqli_fetch_array($results)) {
    

	# getting the data array
        $id   = $row[id];
        $uid  = $row[uid];
        $rd=mysqli_fetch_row(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT donor,warn,immunity,avatar FROM {$TABLE_PREFIX}users WHERE id=$uid"));
$row["donor"]=$rd[0];
$row["warn"]=$rd[1];
$row["immunity"]=$rd[2];
$row["avatar"]=$rd[3];
unset($rd);  
         if ($row["warn"]=="no" or $uid==0) {
 $st="";
}
 else{
 $st="<img src='images/warn.gif'>";
}
         if ($row["immunity"]=="no" or $uid==0) {
 $set="";
}
 else{
 $set="<img src='images/shield.png'>";
}
	
        $time = $row[time];
        $name="<a href='index.php?page=userdetails&id=".$uid."'> ".user_with_color($row["name"]) .$st. $set. get_user_icons($row)."</a>";
        $text = $row[text];
        $shout_reply = "<a href='javascript:window.top.SmileIT(\"[b][color=crimson]@ ".htmlspecialchars($row['name'])."...&nbsp;&nbsp;[/color][/b]\")'><img src='images/rep.gif' title='Reply' alt='Reply' /></a>";

            $name=$name."&nbsp;<a href=\"javascript:PopPshout('".$CURUSER["uid"]."','".$uid."','".$CURUSER["pchat"]."');\"><img src='images/pchat.png'></a>";
		    if($row["private"]=="yes")
            {
                $name = "<b><span style='color:orangered;'><img src='images/privatec.png'></span></b>&nbsp;".$name."&nbsp;".($uid!=$CURUSER["uid"]?"<a href=\"javascript:PopPshout('".$CURUSER["uid"]."','".$uid."','".$CURUSER["pchat"]."');\"><b>[reply]</b></a>":"")."";
            }

$getsbox = @mysqli_fetch_array(@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE id=".$uid));
    $sbox = ("$getsbox[sbox]");
if($sbox=="no" || $uid=="0"){//make sure system can still post
        # if no name is present somehow, $name and $text are set to the strings under
        # we assume all must be ok, othervise no post will be made by javascript check
        # if ($name == '') { $name = 'Anonymous'; $text = 'No message'; }
        
//online status                
$ol = @mysqli_fetch_array(@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT u.lastconnect, o.lastaction FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id WHERE u.id=".$uid));


(is_null($ol["lastaction"])?$lastseen=$ol["lastconnect"]:$lastseen=$ol["lastaction"]);
((time()-$lastseen>900)?$status="<img src='images/button_offline.gif' border='0' title='Offline' alt='".$language["OFFLINE"]."'>":$status="<img src='images/button_online.gif' border='0' title='Online' alt='".$language["ONLINE"]."'>");

@((mysqli_free_result($ol) || (is_object($ol) && (get_class($ol) == "mysqli_result"))) ? true : false);
// end online status

if($btit_settings["shoutdel"] == true AND $CURUSER["edit_users"]=="yes"){
$editt="<a href='javascript:editup($id,$CURUSER[uid]);' style='font-size: 8px'><img src='images/edit.png' title='edit' alt='edit' border='0'></a>&nbsp;<a class=\"stdelete\" href=\"#\" id=\"".$id."\" title=\"Delete\"><img src='images/delete.png' border='0' title='del' alt='del'></a>&nbsp;";
}else{
$editt="";
}

if ($btit_settings["shoutdt"] == true)
{
// avatar
if ($btit_settings["shoutdtav"] == true)
{
if ($row["avatar"] && $row["avatar"]!="")
$av="<img  width=40 height=40 border=0 src=".unesc($row["avatar"])." />";
else
{
$av="<img width=40 height=40 border=0 src=\"images/default_avatar.gif\">";

if ($uid=='0')
$av="<img width=40 height=40 border=0 src=\"images/system.png\">";
}
}
else
$av="";
// avatar 

if ($btit_settings["shoutdtz"] == true)
$f='2';
else
$f='1';

# we put together our dt chat 
      $chatout = "
                 <li><span>".$av."&nbsp;".$editt.$status." <font color = green size=".$f.">".date("d/m/Y H:i:s", $time - $offset)." </font> | <font size=".$f."><b><a href=index.php?page=userdetails&id=".$uid.">".$name."</a>: ".format_shout($text).$shout_reply."</b></font></span></li>";
}
else
{      
# we put together our chat using some css     
      $chatout = "
                 <li><span class='name'>".$editt.date("d/m/Y H:i:s", $time - $offset)."&nbsp;".$status." | <a href=index.php?page=userdetails&id=".$uid.">".$name."</a>:</span></li>
                            <div class='lista' style='text-align:right;
                                      margin-top:-13px;
                                    margin-bottom:0px;
                                   /* color: #006699;*/
                          '>
                          # $id</div>
 
                 <!-- # chat output -->
                 <div class='chatoutput'>".format_shout($text).$shout_reply."</div>
                 ";
}
         echo $chatout; # echo as known handles arrays very fast...

    }
}
}//end if shoutbox
?>