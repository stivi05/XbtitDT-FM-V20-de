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
//lock
$id = $_GET["id"];

$fnn = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filename FROM {$TABLE_PREFIX}files WHERE info_hash = '" . $id . "'");
$fnnn = mysqli_fetch_array($fnn);
$fn=$fnnn["filename"];

if ($CURUSER["id_level"]<= 5)
{
$block_comment = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT block_comment FROM {$TABLE_PREFIX}users WHERE id = ".$CURUSER[uid]."");
$block_comment_dt = mysqli_fetch_array($block_comment);
if ($block_comment_dt["block_comment"] == "yes")
{

      stderr("Abuse Error","You are blocked from making comments because of abuse!! , If you think this is a mistake ? , contact site staff ");
      stdfoot();
      die;
}
$block = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT lock_comment , filename FROM {$TABLE_PREFIX}files WHERE info_hash = '" . $id . "'");
$block_comments = mysqli_fetch_array($block);

if ($block_comments["lock_comment"] == "yes")
{

      stderr("Comments are locked","Because of abuse the staff did lock comments on this torrent !!");
      stdfoot();
      die;
}
}
// end lock

// flood
global $btit_settings;
if($btit_settings["AFSW"]==true)
{
  $minutes = $btit_settings["AFT"]*60;
  $minutdt = $btit_settings["AFT"];
  $limit =  $btit_settings["AFP"];
  $resaf = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) FROM {$TABLE_PREFIX}comments WHERE user = '".$CURUSER[username]."' AND UNIX_TIMESTAMP(added) > (UNIX_TIMESTAMP()-$minutes)") or sqlerr(__FILE__,__LINE__);
  $rowaf = mysqli_fetch_row($resaf);

  if ($rowaf[0] > $limit)
  {
	stderr("You are flooding !", "More than $limit comments in the last $minutdt minutes.");
    stdfoot();
    die;
  }
}
// flood


if (!$CURUSER || $CURUSER["uid"]==1)
   stderr($language["ERROR"],$language["ONLY_REG_COMMENT"]);

$comment = ($_POST["comment"]);

$id = $_GET["id"];
if (isset($_GET["cid"]))
    $cid = intval($_GET["cid"]);
else
    $cid=0;

//Links block in comments by Yupy
if($btit_settings["cblock"]==true)
{
if (preg_match ("/href|https|url|http|www|\.ro|\.ru|\.hu|\.it|\.eu|\.nl
                    |\.bg|\.gr|\.us|\.co.uk|\.uk|\.es|\.tv|\.tr|\.com.ro|\.be|\.de|\.gr|
                    \.me|\.in|\.com|\.pirate|\.co|\.cc|\.net|\.info|\.org|\.ua|\.org/i", $_POST["comment"]))
//Give error 0_o
stderr($language["ERROR"],"You are not allowed to post links in the comments!");
}
//Links block in comments by Yupy... 

#######################################################
# view/edit/delete shout, comments

$res = do_sqlquery("SELECT id, text, user FROM {$TABLE_PREFIX}comments WHERE id=$cid");
$row = mysqli_fetch_array($res);

$username = $CURUSER["username"];

if (isset($_GET["action"]))
 {
  if (($CURUSER["delete_comments"]=="yes" || $CURUSER["username"]==$row["user"]) && $_GET["action"]=="delete")
    {
     do_sqlquery("DELETE FROM {$TABLE_PREFIX}comments WHERE id=$cid",true);
     redirect("index.php?page=torrent-details&id=$id#comments");
     exit;
    }
 }

$tpl_comment=new bTemplate();
//lock
if (isset($_GET["lock"]))
{
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}files SET lock_comment = 'yes' WHERE info_hash='$id'");
  redirect("index.php?page=torrent-details&id=" .$id );
  die();
}
if (isset($_GET["unlock"]))
{
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}files SET lock_comment = 'no' WHERE info_hash='$id'");
  redirect("index.php?page=torrent-details&id=" .$id );
  die();
}
//end lock


(isset($_GET["quoteid"]) && is_numeric($_GET["quoteid"])) ? $quoteid=intval($_GET["quoteid"]) : $quoteid=0;

if($quoteid!=0)
{
	$quoteres=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT UNIX_TIMESTAMP(`c`.`added`) `added`, `c`.`text`, `u`.`id`, `c`.`user` FROM `{$TABLE_PREFIX}comments` `c` LEFT JOIN `{$TABLE_PREFIX}users` `u` ON `c`.`user`=`u`.`username` WHERE `c`.`id`=$quoteid AND `c`.`info_hash`='".mysqli_real_escape_string($DBDT,$id)."'");
	if(@mysqli_num_rows($quoteres)==1)
	{
		$quoterow=mysqli_fetch_assoc($quoteres);
		$quote="[quote=On ".date("d F Y, H:i:s", $quoterow["added"])." [url=".$BASEURL."/index.php?page=userdetails&id=".$quoterow["id"]."]".$quoterow["user"]."[/url]]".stripslashes($quoterow["text"])."[/quote]\n\n";
	}
}

if (isset($_GET["edit"])) {
  if ($CURUSER["edit_comments"]=="yes" || $CURUSER["username"]==$row["user"]) {

    $username = $row["user"]; $cid = $row["id"];

    $tpl_comment->set("cid","&cid=".$cid);
    $tpl_comment->set("edit","&edit");

    if ($_POST["confirm"]==$language["FRM_PREVIEW"]) $comment = $comment; else $comment = $row["text"];
  }
} else {
    $tpl_comment->set("cid","");
    $tpl_comment->set("edit","");
  }
      
# End
#######################################################  

$tpl_comment->set("language",$language);
$tpl_comment->set("comment_id",$id);


#######################################################
# view/edit/delete shout, comments

$tpl_comment->set("comment_username",$username);
      
# End
#######################################################        

    
$tpl_comment->set("comment_comment",textbbcode("comment","comment",htmlspecialchars(unesc(((isset($quote))?$quote:$comment)))));


if (isset($_POST["info_hash"])) {
   if ($_POST["confirm"]==$language["FRM_CONFIRM"]) {
   $comment = addslashes($_POST["comment"]);
      

#######################################################
# view/edit/delete shout, comments

      $user=AddSlashes($username);
      
# End
#######################################################        

    
      if ($user=="") $user="Anonymous";
      
      $sql = "SELECT f.uploader, f.filename, f.info_hash, u.username, u.commentpm FROM {$TABLE_PREFIX}files f LEFT JOIN {$TABLE_PREFIX}users u ON f.uploader=u.id WHERE f.info_hash='".mysqli_real_escape_string($DBDT,StripSlashes($_POST["info_hash"]))."'";
    $qry = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
    $res = mysqli_fetch_array($qry) or sqlerr();
    if ($res['commentpm']=='true' AND $CURUSER['uid']!=$res['uploader']){
        $msg = "[url=$BASEURL/index.php?page=userdetails&id=".$CURUSER['uid']."]".$CURUSER['username']."[/url] has added a comment to your torrrent \'[url=$BASEURL/index.php?page=torrent-details&id=".$res['info_hash']."]".addslashes($res['filename'])."[/url]\'.\n\nThis is an automated system message.\nIf you wish to turn it off please edit your tracker profile.";
        $sub = "Torrent Comment Added";
        $insert="";
             if($FORUMLINK=="smf")
             {
                 do_sqlquery("INSERT INTO {$db_prefix}personal_messages (ID_MEMBER_FROM, fromName, msgtime, subject, body) VALUES (2, '".$CURUSER["username"]."', UNIX_TIMESTAMP(), '$sub', '$msg')");
                 $pm_id=((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
                 do_sqlquery("INSERT INTO {$db_prefix}pm_recipients (ID_PM, ID_MEMBER) VALUES ($pm_id, ".$res["uploader"].")");
                 do_sqlquery("UPDATE {$db_prefix}members SET instantMessages=instantMessages+1, unreadMessages=unreadMessages+1 WHERE ID_MEMBER='".$res["uploader"]."'");
             }
             else
                 do_sqlquery("INSERT INTO {$TABLE_PREFIX}messages (sender, receiver, added, subject, msg) VALUES (2, '".$res['uploader']."', UNIX_TIMESTAMP(), '$sub', '$msg')",true);
		   }
		   
	  if(empty($comment)){
     stderr($language["ERROR"],$language['ERR_COMMENT_EMPTY']);
     exit();
     }
	 else{

#######################################################
# view/edit/delete shout, comments

if (!isset($_GET["edit"])) {
      
# End
#######################################################        

    	 
   do_sqlquery("INSERT INTO {$TABLE_PREFIX}comments (added,text,ori_text,user,info_hash) VALUES (NOW(),\"$comment\",\"$comment\",\"$user\",\"" . mysqli_real_escape_string($DBDT,StripSlashes($_POST["info_hash"])) . "\")",true);

// begin - announce new comment in shoutbox
global $BASEURL,$btit_settings; 
if  ($btit_settings["sbvier"] == true)
{
      $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
      $rw=mysqli_fetch_assoc($al);
      $ct =  ($rw["count"]+1);  
      $userid= $CURUSER["username"];
        do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=orangered]There is a new comment by[/color] ".shout_user_color($userid)." [color=orangered]on the torrent[/color][color=yellow] $fn [/color][color=orangered]To view it [/color] [url=$BASEURL/index.php?page=torrent-details&id=$id".("#comments")."][b]Click here[/b][/url]',".$ct.")");
}
// end - announce new comment in shoutbox  
  
// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

$plus= $setrep["rep_undefined"];

if ($setrep["rep_is_online"]== 'false')
{
//do nothing
}
else
{
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET reputation = reputation + '$plus' WHERE username='$user'");
}
// DT reputation system end

  redirect("index.php?page=torrent-details&id=" . StripSlashes($_POST["info_hash"])."#comments");
  die();

#######################################################
# view/edit/delete shout, comments

} else {
  do_sqlquery("UPDATE {$TABLE_PREFIX}comments SET text='$comment', ori_text='$comment' WHERE id='" . $cid . "'",true);
  redirect("index.php?page=torrent-details&id=" . StripSlashes($_POST["info_hash"])."#comments");
  die();
  }
      
# End
#######################################################        

    
  }
}
# Comment preview by miskotes
#############################

if ($_POST["confirm"]==$language["FRM_PREVIEW"]) {

$tpl_comment->set("PREVIEW",TRUE,TRUE);
$tpl_comment->set("comment_preview",set_block($language["COMMENT_PREVIEW"],"center",format_comment($comment),false));

#####################
# Comment preview end
}
  else
    {
    redirect("index.php?page=torrent-details&id=" . StripSlashes($_POST["info_hash"])."#comments");
    die();
  }
}
else
    $tpl_comment->set("PREVIEW",FALSE,TRUE);

?>