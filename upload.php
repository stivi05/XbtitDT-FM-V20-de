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

$scriptname = htmlspecialchars($_SERVER["PHP_SELF"]."?page=upload");
$addparam = "";

global $btit_settings , $SITEEMAIL , $BASEURL;

require(load_language("lang_upload.php"));

require_once ("include/BDecode.php");
require_once ("include/BEncode.php");
// Configuration//
function_exists("sha1") or die("<font color=\"red\">".$language["NOT_SHA"]."</font></body></html>");

if (!$CURUSER || $CURUSER["can_upload"]=="no")
   {
    err_msg($language["SORRY"],$language["ERROR"].$language["NOT_AUTHORIZED_UPLOAD"]);
    stdfoot();
    exit();
   }

$allowupload_stats = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT allowupload FROM {$TABLE_PREFIX}users WHERE id = ".$CURUSER[uid]."");
$allowupload_stat = mysqli_fetch_array($allowupload_stats);
if ($allowupload_stat[allowupload] == "no")
{
    err_msg($language["SORRY"],$language["ERROR"]);
    stdfoot();
    exit();
}
if (isset($_FILES["torrent"]))
   {
   if ($_FILES["torrent"]["error"] != 4)
   {
##############################################################
      # Nfo hack -->
if ($btit_settings["nfosw"]==true )
{  
      $HTTP_POST_FILES["nfo"]["tmp_name"]=str_replace("\\", "/", $HTTP_POST_FILES["nfo"]["tmp_name"]);
      $_FILES["nfo"]["tmp_name"]=str_replace("\\", "/", $_FILES["nfo"]["tmp_name"]);

      $nfo=$_FILES["nfo"]["tmp_name"];

      $nfocheck = basename($_FILES['nfo']['name']);


      $ext = strrchr($nfocheck,'.');
      $limitedext = array(".nfo");

      if ($nfocheck) {
        if (!in_array(strtolower($ext),$limitedext)) $error["nfo"] = stderr("Error!","Not an nfo file!");
        if($_FILES['nfo']['size'] < "128") $error["nfo"] = stderr("Error!","Not a valid nfo or too small!");
      }
 } 
      # End
########################################################## -->
      $fd = fopen($_FILES["torrent"]["tmp_name"], "rb") or stderr($language["ERROR"],$language["FILE_UPLOAD_ERROR_1"]);
      is_uploaded_file($_FILES["torrent"]["tmp_name"]) or stderr($language["ERROR"],$language["FILE_UPLOAD_ERROR_2"]);

      if((isset($_FILES["torrent"]["tmp_name"]) && !empty($_FILES["torrent"]["tmp_name"])) && (isset($_FILES["torrent"]["name"]) && !empty($_FILES["torrent"]["name"])))
      {
          $check_torr=check_upload($_FILES["torrent"]["tmp_name"], $_FILES["torrent"]["name"]);         

          switch($check_torr)
          {
              case 1:
              case 2:
                $check_torr_err=$language["ERR_MISSING_DATA"];
                if(file_exists($_FILES["torrent"]["tmp_name"]))
                    @unlink($_FILES["torrent"]["tmp_name"]);
                break;
                        
              case 3:
                $check_torr_err=$language["QUAR_TMP_FILE_MISS"];
                break;

              case 4:
                $check_torr_err=$language["QUAR_OUTPUT"];
                break;

              case 5:
              default:
                $check_torr_err="";
                break;
          }
          if($check_torr_err!="")
              stderr($language["ERROR"], $check_torr_err);
      }
      $length=filesize($_FILES["torrent"]["tmp_name"]);
      if ($length)
        $alltorrent = fread($fd, $length);
      else {
        err_msg($language["ERROR"],$language["FILE_UPLOAD_ERROR_3"]);
        stdfoot();
        exit();

       }
      $array = BDecode($alltorrent);
      if (!isset($array))
         {
          err_msg($language["ERROR"],$language["ERR_PARSER"]);
          stdfoot();
          exit();
         }
if($btit_settings["aann"]=="true")   
{   
	$array["announce"]=$TRACKER_ANNOUNCEURLS[0];
	unset($array["announce-list"]);
	$hash=sha1(BEncode($array["announce"]));
	$hash=sha1(BEncode($array["announce-list"]));
	}
      if (!$array)
         {
          err_msg($language["ERROR"],$language["ERR_PARSER"]);
          stdfoot();
          exit();
         }
    if (in_array($array["announce"],$TRACKER_ANNOUNCEURLS) && $DHT_PRIVATE)
      {
      $array["info"]["private"]=1;
      $hash=sha1(BEncode($array["info"]));
      }
    else
      {
      $hash = sha1(BEncode($array["info"]));
      }
      fclose($fd);
      }

if (isset($_POST["filename"]))
   $filename = mysqli_real_escape_string($DBDT,htmlspecialchars($_POST["filename"]));
else
    $filename = mysqli_real_escape_string($DBDT,htmlspecialchars($_FILES["torrent"]["name"]));
//tag
	if (isset($_POST["tag"]) and $btit_settings["tag"]==true )
   $tag = mysqli_real_escape_string($DBDT,htmlspecialchars($_POST["tag"]));
else
    $tag = "";
//tag
if (isset($_POST["imdb"]))
    $imdb = mysqli_real_escape_string($DBDT,htmlspecialchars($_POST["imdb"]));
else $imdb = 0;   

if (isset($_POST["moder"]))
	$moder=$_POST["moder"];
// YT
if (isset($_POST["youtube_video"]))
   $youtube_video = AddSlashes($_POST["youtube_video"]);
else
    $youtube_video = "";	
// YT
if (isset($hash) && $hash) $url = $TORRENTSDIR . "/" . $hash . ".btf";
else $url = 0;
// staff_comment start
if (isset($_POST["staff_comment"]))
   $staff_comment = mysqli_real_escape_string($DBDT,htmlspecialchars($_POST["staff_comment"]));
else
    $staff_comment = "";
// staff_comment end
    
//mod gold
$gold = mysqli_real_escape_string($DBDT,0);
//setting gold post var
if (isset($_POST["gold"]) && $_POST["gold"] != '')
{
   $gold = mysqli_real_escape_string($DBDT,$_POST["gold"]);
}
//end gold mod

// vip torrent start
	if (isset($_POST["vip_torrent"]) && $_POST["vip_torrent"] == 'on')
	   $vip_torrent =  mysqli_real_escape_string($DBDT,1);
	else {
       $vip_torrent = mysqli_real_escape_string($DBDT,0);
	  }
// vip torrent end
    
//Mod by losmi - sticky mod
    
    if (isset($_POST["sticky"]) && $_POST["sticky"] == 'on')
       $sticky =  mysqli_real_escape_string($DBDT,1);
    else { 
           $sticky = mysqli_real_escape_string($DBDT,0);
      }
//End mod by losmi - sticky mod


//Upload Multiplier
if (isset($_POST["multiplier"]))
   $multiplier = AddSlashes($_POST["multiplier"]);
else
    $multiplier = "1";

//Upload Multiplier

    if (isset($_POST["info"]) && $_POST["info"]!="")
   $comment = mysqli_real_escape_string($DBDT,$_POST["info"]);
else { // description is now required (same as for edit.php)
//    $comment = "";
        err_msg($language["ERROR"],$language["EMPTY_DESCRIPTION"]);
        stdfoot();
        exit();
  }
if ($btit_settings["uplang"]==true) 
$torlang=$_POST["language"]; 
else 
$torlang="";

// filename not writen by user, we get info directly from torrent.
if (strlen($filename) == 0 && isset($array["info"]["name"]))
    $filename = mysqli_real_escape_string($DBDT,htmlspecialchars($array["info"]["name"]));

// description not writen by user, we get info directly from torrent.
if (isset($array["comment"]))
   $info = mysqli_real_escape_string($DBDT,htmlspecialchars($array["comment"]));
else
    $info = "";


if (isset($array["info"]) && $array["info"]) $upfile=$array["info"];
    else $upfile = 0;

if (isset($upfile["length"]))
{
  $size = (float)($upfile["length"]);
}
else if (isset($upfile["files"]))
     {
// multifiles torrent
         $size=0;
         foreach ($upfile["files"] as $file)
                 {
                 $size+=(float)($file["length"]);
                 }
     }
else
    $size = "0";

if (!isset($array["announce"]))
     {
     err_msg($language["ERROR"], $language["EMPTY_ANNOUNCE"]);
     stdfoot();
     exit();
}
     
      $categoria = intval(0+$_POST["category"]);
      $team = intval(0+$_POST["team"]);
      $anonyme=sqlesc($_POST["anonymous"]);
      $curuid=intval($CURUSER["uid"]);

// category check
      $rc=do_sqlquery("SELECT id FROM {$TABLE_PREFIX}categories WHERE id=$categoria",true);
      if (mysqli_num_rows($rc)==0)
         {
             err_msg($language["ERROR"],$language["WRITE_CATEGORY"]);
             stdfoot();
             exit();
      }
      @((mysqli_free_result($rc) || (is_object($rc) && (get_class($rc) == "mysqli_result"))) ? true : false);
      
// team check
      $rt=do_sqlquery("SELECT id FROM {$TABLE_PREFIX}teams WHERE id=$team",true);
      if (mysqli_num_rows($rt)==0)
         {
             err_msg($language["ERROR"],"Team id wrong!");
             stdfoot();
             exit();
      }
      @((mysqli_free_result($rt) || (is_object($rt) && (get_class($rt) == "mysqli_result"))) ? true : false);

      $announce=trim($array["announce"]);

      if ($categoria==0)
         {
             err_msg($language["ERROR"],$language["WRITE_CATEGORY"]);
             stdfoot();
             exit();
         }

      if ((strlen($hash) != 40) || !verifyHash($hash))
      {
          err_msg($language["ERROR"],$language["ERR_HASH"]);
          stdfoot();
          exit();
      }
// if ($announce!=$BASEURL."/announce.php" && $EXTERNAL_TORRENTS==false)
      if (!in_array($announce,$TRACKER_ANNOUNCEURLS) && $EXTERNAL_TORRENTS==false)
         {
           err_msg($language["ERROR"],$language["ERR_EXTERNAL_NOT_ALLOWED"]);
           unlink($_FILES["torrent"]["tmp_name"]);
           stdfoot();
           exit();
         }
       

if ($btit_settings["imgsw"]==false ) 
{
// image url 
if (isset($_POST["userfile"]))
   $file_name = AddSlashes($_POST["userfile"]);
else
    $file_name = "";
	
if (isset($_POST["screen1"]))
   $file_name_s1 = AddSlashes($_POST["screen1"]);
else
    $file_name_s1 = "";	
	
if (isset($_POST["screen2"]))
   $file_name_s2 = AddSlashes($_POST["screen2"]);
else
    $file_name_s2 = "";	
	
if (isset($_POST["screen3"]))
   $file_name_s3 = AddSlashes($_POST["screen3"]);
else
    $file_name_s3 = "";	
// image url  
}
else
{ 
              
        $userfile = $_FILES["userfile"];

        if((isset($userfile["tmp_name"]) && !empty($userfile["tmp_name"])) && (isset($userfile["name"]) && !empty($userfile["name"])))
        {
            $check_userfile=check_upload($userfile["tmp_name"], $userfile["name"]);

            switch($check_userfile)
            {
                case 1:              
                case 2:
                  $check_userfile_err=$language["ERR_MISSING_DATA"];
                  if(file_exists($userfile["tmp_name"]))
                      @unlink($userfile["tmp_name"]);
                break;

                case 3:
                  $check_userfile_err=$language["QUAR_TMP_FILE_MISS"];
                break;

                case 4:
                  $check_userfile_err=$language["QUAR_OUTPUT"];
                break;

                case 5:
                default:
                  $check_userfile_err="";
                break;
            }
            if($check_userfile_err!="")
                stderr($language["ERROR"], $check_userfile_err);
        }

        $screen1 = $_FILES["screen1"];

        if((isset($screen1["tmp_name"]) && !empty($screen1["tmp_name"])) && (isset($screen1["name"]) && !empty($screen1["name"])))
        {
            $check_screen1=check_upload($screen1["tmp_name"], $screen1["name"]);

            switch($check_screen1)
            {
                case 1:              
                case 2:
                  $check_screen1_err=$language["ERR_MISSING_DATA"];
                  if(file_exists($screen1["tmp_name"]))
                      @unlink($screen1["tmp_name"]);
                break;

                case 3:
                  $check_screen1_err=$language["QUAR_TMP_FILE_MISS"];
                break;

                case 4:
                  $check_screen1_err=$language["QUAR_OUTPUT"];
                break;

                case 5:
                default:
                  $check_screen1_err="";
                break;
            }
            if($check_screen1_err!="")
                stderr($language["ERROR"], $check_screen1_err);
        }

        $screen2 = $_FILES["screen2"];

        if((isset($screen2["tmp_name"]) && !empty($screen2["tmp_name"])) && (isset($screen2["name"]) && !empty($screen2["name"])))
        {
            $check_screen2=check_upload($screen2["tmp_name"], $screen2["name"]);

            switch($check_screen2)
            {
                case 1:              
                case 2:
                  $check_screen2_err=$language["ERR_MISSING_DATA"];
                  if(file_exists($screen2["tmp_name"]))
                      @unlink($screen2["tmp_name"]);
                break;

                case 3:
                  $check_screen2_err=$language["QUAR_TMP_FILE_MISS"];
                break;

                case 4:
                  $check_screen2_err=$language["QUAR_OUTPUT"];
                break;

                case 5:
                default:
                  $check_screen2_err="";
                break;
            }
            if($check_screen2_err!="")
                stderr($language["ERROR"], $check_screen2_err);
        }

        $screen3 = $_FILES["screen3"];

        if((isset($screen3["tmp_name"]) && !empty($screen3["tmp_name"])) && (isset($screen3["name"]) && !empty($screen3["name"])))
        {
            $check_screen3=check_upload($screen3["tmp_name"], $screen3["name"]);

            switch($check_screen3)
            {
                case 1:              
                case 2:
                  $check_screen3_err=$language["ERR_MISSING_DATA"];
                  if(file_exists($screen3["tmp_name"]))
                      @unlink($screen3["tmp_name"]);
                break;

                case 3:
                  $check_screen3_err=$language["QUAR_TMP_FILE_MISS"];
                break;

                case 4:
                  $check_screen3_err=$language["QUAR_OUTPUT"];
                break;

                case 5:
                default:
                  $check_screen3_err="";
                break;
            }
            if($check_screen3_err!="")
                stderr($language["ERROR"], $check_screen3_err);
        }
        $image_types = Array ("image/bmp",
                                "image/jpeg",
                                "image/pjpeg",
                                "image/gif",
                                "image/x-png",
								"image/png");
        switch($_FILES["userfile"]["type"]) {
            case 'image/bmp':
            $file_name = $hash.".bmp";
            break;
            case 'image/jpeg':
            $file_name = $hash.".jpg";
            break;
            case 'image/pjpeg':
            $file_name = $hash.".jpeg";
            break;
            case 'image/gif':
            $file_name = $hash.".gif";
            break;
            case 'image/x-png':
            $file_name = $hash.".png";
            break;
            case 'image/png':
            $file_name = $hash.".png";
            break;
        }
        switch($_FILES["screen1"]["type"]) {
            case 'image/bmp':
            $file_name_s1 = "s1".$hash.".bmp";
            break;
            case 'image/jpeg':
            $file_name_s1 = "s1".$hash.".jpg";
            break;
            case 'image/pjpeg':
            $file_name_s1 = "s1".$hash.".jpeg";
            break;
            case 'image/gif':
            $file_name_s1 = "s1".$hash.".gif";
            break;
            case 'image/x-png':
            $file_name_s1 = "s1".$hash.".png";
            break;
            case 'image/png':
            $file_name_s1 = "s1".$hash.".png";
            break;
        }
        switch($_FILES["screen2"]["type"]) {
            case 'image/bmp':
            $file_name_s2 = "s2".$hash.".bmp";
            break;
            case 'image/jpeg':
            $file_name_s2 = "s2".$hash.".jpg";
            break;
            case 'image/pjpeg':
            $file_name_s2 = "s2".$hash.".jpeg";
            break;
            case 'image/gif':
            $file_name_s2 = "s2".$hash.".gif";
            break;
            case 'image/x-png':
            $file_name_s2 = "s2".$hash.".png";
            break;
            case 'image/png':
            $file_name_s2 = "s2".$hash.".png";
            break;
        }
        switch($_FILES["screen3"]["type"]) {
            case 'image/bmp':
            $file_name_s3 = "s3".$hash.".bmp";
            break;
            case 'image/jpeg':
            $file_name_s3 = "s3".$hash.".jpg";
            break;
            case 'image/pjpeg':
            $file_name_s3 = "s3".$hash.".jpeg";
            break;
            case 'image/gif':
            $file_name_s3 = "s3".$hash.".gif";
            break;
            case 'image/x-png':
            $file_name_s3 = "s3".$hash.".png";
            break;
            case 'image/png':
            $file_name_s3 = "s3".$hash.".png";
            break;
        }
        $uploadfile = $GLOBALS["uploaddir"] . $file_name;
        $uploadfile1 = $GLOBALS["uploaddir"] . $file_name_s1;
        $uploadfile2 = $GLOBALS["uploaddir"] . $file_name_s2;
        $uploadfile3 = $GLOBALS["uploaddir"] . $file_name_s3;
        $file_size = $_FILES["userfile"]["size"];
        $file_size1 = $_FILES["screen1"]["size"];
        $file_size2 = $_FILES["screen2"]["size"];
        $file_size3 = $_FILES["screen3"]["size"];
        $file_type = $_FILES["userfile"]["type"];
        $file_type1 = $_FILES["screen1"]["type"];
        $file_type2 = $_FILES["screen2"]["type"];
        $file_type3 = $_FILES["screen3"]["type"];
        $file_size = makesize1($file_size);
        $file_size1 = makesize1($file_size1);
        $file_size2 = makesize1($file_size2);
        $file_size3 = makesize1($file_size3);
        if (isset($_FILES["userfile"]))
        {
            if ($_FILES["userfile"]["name"] =='')
            {
// do nothing...
            }
            else
            {
                if ($file_size > $GLOBALS["file_limit"])
                {
                    err_msg($language["ERROR"],$language["FILE_UPLOAD_TO_BIG"].": ".$file_limit.". ".$language["IMAGE_WAS"].": ".$file_size);
                    stdfoot();
                    exit();
                }
                if (in_array (strtolower ($file_type), $image_types, TRUE))
                {
                    if (@move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
                    {
                    }
                    else
                    {
                        err_msg($language["ERROR"],$language["MOVE_IMAGE_TO"]." ".$GLOBALS["uploaddir"].". ".$language["CHECK_FOLDERS_PERM"]);
                        stdfoot();
                        exit();
                    }
                }
                else
                {
                    err_msg ($language["ERROR"],$language["ILEGAL_UPLOAD"]);
                    stdfoot();
                    exit;
                }
            }
        }
        if (isset($_FILES["screen1"]))
        {
            if ($_FILES["screen1"]["name"] =='')
            {
// do nothing...
            }
            else
            {
                if ($file_size1 > $GLOBALS["file_limit"])
                {
                    err_msg($language["ERROR"],$language["FILE_UPLOAD_TO_BIG"].": ".$file_limit.". ".$language["IMAGE_WAS"].": ".$file_size1);
                    stdfoot();
                    exit();
                }
                if (in_array (strtolower ($file_type1), $image_types, TRUE))
                {
                    if (@move_uploaded_file($_FILES['screen1']['tmp_name'], $uploadfile1))
                    {
                    }
                    else
                    {
                        err_msg($language["ERROR"],$language["MOVE_IMAGE_TO"]." ".$GLOBALS["uploaddir"].". ".$language["CHECK_FOLDERS_PERM"]);
                        stdfoot();
                        exit();
                    }
                }
                else
                {
                    err_msg ($language["ERROR"],$language["ILEGAL_UPLOAD"]);
                    stdfoot();
                    exit;
                }
            }
        }
        if (isset($_FILES["screen2"]))
        {
            if ($_FILES["screen2"]["name"] =='')
            {
// do nothing...
            }
            else
            {
                if ($file_size2 > $GLOBALS["file_limit"])
                {
                    err_msg($language["ERROR"],$language["FILE_UPLOAD_TO_BIG"].": ".$file_limit.". ".$language["IMAGE_WAS"].": ".$file_size2);
                    stdfoot();
                    exit();
                }
                if (in_array (strtolower ($file_type2), $image_types, TRUE))
                {
                    if (@move_uploaded_file($_FILES['screen2']['tmp_name'], $uploadfile2))
                    {
                    }
                    else
                    {
                        err_msg($language["ERROR"],$language["MOVE_IMAGE_TO"]." ".$GLOBALS["uploaddir"].". ".$language["CHECK_FOLDERS_PERM"]);
                        stdfoot();
                        exit();
                    }
                }
                else
                {
                    err_msg ($language["ERROR"],$language["ILEGAL_UPLOAD"]);
                    stdfoot();
                    exit;
                }
            }
        }
        if (isset($_FILES["screen3"]))
        {
            if ($_FILES["screen3"]["name"] =='')
            {
// do nothing...
            }
            else
            {
                if ($file_size3 > $GLOBALS["file_limit"])
                {
                    err_msg($language["ERROR"],$language["FILE_UPLOAD_TO_BIG"].": ".$file_limit.". ".$language["IMAGE_WAS"].": ".$file_size3);
                    stdfoot();
                    exit();
                }
                if (in_array (strtolower ($file_type3), $image_types, TRUE))
                {
                    if (@move_uploaded_file($_FILES['screen3']['tmp_name'], $uploadfile3))
                    {
                    }
                    else
                    {
                        err_msg($language["ERROR"],$language["MOVE_IMAGE_TO"]." ".$GLOBALS["uploaddir"].". ".$language["CHECK_FOLDERS_PERM"]);
                        stdfoot();
                        exit();
                    }
                }
                else
                {
                    err_msg ($language["ERROR"],$language["ILEGAL_UPLOAD"]);
                    stdfoot();
                    exit;
                }
            }
        }
     }   
// if ($announce!=$BASEURL."/announce.php")

    $announces=array();
		for ($i=0;$i<count($array["announce-list"]);$i++) {
		$current=$array["announce-list"][$i];
		if (is_array($current)) $announces[$current[0]]=array("seeds"=>0, "leeches"=>0, "downloaded"=>0);
		else $announces[$current]=array("seeds"=>0, "leeches"=>0, "downloaded"=>0);
		}
		$announces[$announce]=array("seeds"=>0, "leeches"=>0, "downloaded"=>0);
        
      if (in_array($announce,$TRACKER_ANNOUNCEURLS)){
         $internal=true;
// inserting into xbtt table
         if ($XBTT_USE)
              do_sqlquery("INSERT INTO xbt_files SET info_hash=0x$hash, ctime=UNIX_TIMESTAMP() ON DUPLICATE KEY UPDATE flags=0",true);
         $query = "INSERT INTO {$TABLE_PREFIX}files ( team,language,tag,announces,multiplier,youtube_video,staff_comment, info_hash, filename, url, info, category, data, size, comment, uploader,anonymous, bin_hash) VALUES ( \"$team\", \"$torlang\",\"$tag\", \"".mysqli_real_escape_string($DBDT,serialize($announces))."\",\"$multiplier\" ,\"$youtube_video\",\"$staff_comment\", \"$hash\", \"$filename\", \"$url\", \"$info\",0 + $categoria,NOW(), \"$size\", \"$comment\",$curuid,$anonyme,0x$hash)";
      }else
          {
// maybe we find our announce in announce list??
             $internal=false;
             if (isset($array["announce-list"]) && is_array($array["announce-list"]))
                {
                for ($i=0;$i<count($array["announce-list"]);$i++)
                    {
                    if (in_array($array["announce-list"][$i][0],$TRACKER_ANNOUNCEURLS))
                      {
                       $internal = true;
                       continue;
                      }
                    }
                }
              if ($internal)
                {
// ok, we found our announce, so it's internal and we will set our announce as main
                   $array["announce"]=$TRACKER_ANNOUNCEURLS[0];
                   $query = "INSERT INTO {$TABLE_PREFIX}files ( team,language,tag,announces,multiplier,youtube_video,staff_comment, info_hash, filename, url, info, category, data, size, comment, uploader,anonymous, bin_hash) VALUES (\"$team\",\"$torlang\", \"$tag\", \"".mysqli_real_escape_string($DBDT,serialize($announces))."\",\"$multiplier\" ,\"$youtube_video\",\"$staff_comment\", \"$hash\", \"$filename\", \"$url\", \"$info\",0 + $categoria,NOW(), \"$size\", \"$comment\",$curuid,$anonyme,0x$hash)";
                   if ($XBTT_USE)
                        do_sqlquery("INSERT INTO xbt_files SET info_hash=0x$hash, ctime=UNIX_TIMESTAMP() ON DUPLICATE KEY UPDATE flags=0",true);
                }
              else
                  $query = "INSERT INTO {$TABLE_PREFIX}files ( team,language,tag,announces,multiplier,youtube_video,staff_comment, info_hash, filename, url, info, category, data, size, comment,external,announce_url, uploader,anonymous, bin_hash) VALUES (\"$team\",\"$torlang\",\"$tag\",  \"".mysqli_real_escape_string($DBDT,serialize($announces))."\",\"$multiplier\",\"$youtube_video\",\"$staff_comment\", \"$hash\", \"$filename\", \"$url\", \"$info\",0 + $categoria,NOW(), \"$size\", \"$comment\",\"yes\",\"$announce\",$curuid,$anonyme,0x$hash)";
        }
//echo $query;
      $status = do_sqlquery($query); //makeTorrent($hash, true);
	               updatemoder($TABLE_PREFIX,$moder,$hash);
/*
Mod by losmi -sticky torrent
*/
if($sticky!=0)
            {
            updateSticky($hash,$sticky);
            }
/*
Mod by losmi -sticky torrent
*/
      
// vip torrent
if($vip_torrent!=0)
            {
    $query = "UPDATE {$TABLE_PREFIX}files
                   SET vip_torrent='$vip_torrent'
                   WHERE info_hash ='$hash'";
    do_sqlquery($query,true);
            }
//vip torrent
if ($status)
         {
//begin Auto-Topic by dodge - 2009
        $fid_res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT forumid FROM {$TABLE_PREFIX}categories WHERE id='$categoria'");
        @$fid = mysqli_fetch_assoc($fid_res);
        $f = $fid["forumid"];
		if($f > 0)
			new_auto_topic($f, $CURUSER["smf_fid"], $filename, $comment, $hash);
//end SMF Auto-Topic
		$mf=@move_uploaded_file($_FILES["torrent"]["tmp_name"] , $TORRENTSDIR . "/" . $hash . ".btf");
##############################################################
        # Nfo hack -->
if ($btit_settings["nfosw"]==true )
   {        
        if ($nfocheck) {
          if(empty($error)) {         
            $result = @move_uploaded_file($nfo, "nfo/rep/" . $hash . ".nfo");
               if(empty($result)) $error["result"] = stderr("Error!","Error moving nfo file!");
          }
        }
        
        if(is_array($error)) { while(list($key, $val) = each($error)) echo $val; }
   } 
        # End
########################################################## -->		
		
         if (!$mf)
           {
// failed to move file
             do_sqlquery("DELETE FROM {$TABLE_PREFIX}files WHERE info_hash=\"$hash\"",true);
             if ($XBTT_USE)
                  do_sqlquery("UPDATE xbt_files SET flags=1 WHERE info_hash=0x$hash",true);
             stderr($language["ERROR"],$language["ERR_MOVING_TORR"]);
         }
// try to chmod new moved file, on some server chmod without this could result 600, seems to be php bug
         

         do_sqlquery("UPDATE {$TABLE_PREFIX}files set image='$file_name', screen1='$file_name_s1', screen2='$file_name_s2', screen3='$file_name_s3' WHERE info_hash=\"$hash\"");

@chmod($TORRENTSDIR . "/" . $hash . ".btf",0766);

do_sqlquery("UPDATE {$TABLE_PREFIX}files SET imdb=\"$imdb\",  url=\"$url\" WHERE info_hash=\"$hash\"");
         
if  ($btit_settings["prepre"] == true ) 
{
$pretime = pretime_read($filename);
do_sqlquery("UPDATE {$TABLE_PREFIX}files SET pretime=\"$pretime\" WHERE info_hash=\"$hash\"");
}


// gold/silver torrent
      do_sqlquery("UPDATE {$TABLE_PREFIX}files SET gold='$gold' WHERE info_hash=\"$hash\"");
      $xgold=($gold==0?100:($gold==2?0:50));
      if ($XBTT_USE)
         do_sqlquery("UPDATE xbt_files SET down_multi=$xgold, flags=2 WHERE info_hash='".mysqli_real_escape_string($DBDT,hex2bin($hash))."'");

//  if ($announce!=$BASEURL."/announce.php")
        if (!in_array($announce,$TRACKER_ANNOUNCEURLS))
            {
                require_once("./include/getscrape.php");
                scrape($announce,$hash);
                $status=2;
                write_log("Uploaded new torrent $filename - EXT ($hash)","add");
            }
         else
             {
              if ($DHT_PRIVATE)
                   {
                   $alltorrent=bencode($array);
                   $fd = fopen($TORRENTSDIR . "/" . $hash . ".btf", "rb+");
                   fwrite($fd,$alltorrent);
                   fclose($fd);
                   }
// with pid system active or private flag (dht disabled), tell the user to download the new torrent
                write_log("Uploaded new torrent $filename ($hash)","add");
               
            $status=1;
         }
// send email to subscriptors
         $subscriptors=get_result("SELECT email, subscription FROM {$TABLE_PREFIX}users WHERE subscription IS NOT NULL",true);
         if (count($subscriptors)>0)
          {
           $bcc=array();
           $ne=0;
           include(load_language("lang_usercp.php"));
           for ($i=0;$i<count($subscriptors);$i++)
            {
                if (in_array($categoria, explode(",",$subscriptors[$i]["subscription"])))
                  {
                   $bcc[]=$subscriptors[$i]["email"];
                   $ne++;
                   if ($ne>49)
                      send_mail($SITEEMAIL,$language["SUB_SUBJECT"],sprintf($language["SUB_EMAIL"],$filename, "$BASEURL/index.php?page=torrent-details&id=$hash","$BASEURL/download.php?id=$hash&f=" . urlencode($filename) . ".torrent"),false,array(),$bcc);
                }
            }

            send_mail($SITEEMAIL,$language["SUB_SUBJECT"],sprintf($language["SUB_EMAIL"],$filename, "$BASEURL/index.php?page=torrent-details&id=$hash","$BASEURL/download.php?id=$hash&f=" . urlencode($filename) . ".torrent"),false,array(),$bcc);
         }

if  ($btit_settings["sbone"] == true AND $CURUSER['trusted']=='yes') 
{ 
      $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
      $rw=mysqli_fetch_assoc($al);
      $ct =  ($rw["count"]+1);       
      do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text, count) VALUES (0,".time().", 'System','[color=red]NEW TORRENT[/color]: [url=$BASEURL/index.php?page=torrent-details&id=$hash]".$filename."[/url]',".$ct.")");
}

//last up/down DT
do_sqlquery("INSERT into {$TABLE_PREFIX}downloads (uid, info_hash, date, updown) VALUES ('$curuid','$hash', NOW() , 'up')",true);
//last up/down DT end

//auto owner thanks
if  ($btit_settings["owth"] == true)
do_sqlquery("INSERT into {$TABLE_PREFIX}files_thanks (infohash, userid) VALUES ('$hash',2)",true);
//auto owner thanks
      
// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

$plus= $setrep["rep_upload"];

if ($setrep["rep_is_online"]== 'false')
{
//do nothing
}
else
{
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET reputation = reputation + '$plus' WHERE id='$curuid'");
}
// DT reputation system end
        }
      else
          {
              err_msg($language["ERROR"],$language["ERR_ALREADY_EXIST"]);
              unlink($_FILES["torrent"]["tmp_name"]);
              stdfoot();
              die();
          }

} else {
$status=0;
}

$uploadtpl=new bTemplate();

// staff_comment start
    $current_level = getLevelSC($CURUSER['id_level']);
    $level_sc = false;

if ($CURUSER["uid"]>1 && $current_level>=$btit_settings["staff_comment"] && $CURUSER['can_upload']=='yes')
   {
    $uploadtpl->set("LEVEL_SC",true,FALSE);
   }
else
   {
    $uploadtpl->set("LEVEL_SC",false,TRUE);
   }
// staff_comment end
   
// tag
if ($btit_settings["tag"]==true ) 
    $uploadtpl->set("tagg",true,FALSE);
else
   $uploadtpl->set("tagg",false,TRUE);
//tag
   
// language
$uploadtpl->set("customlang",$btit_settings["customlang"]);
$uploadtpl->set("customlanga",$btit_settings["customlanga"]);
$uploadtpl->set("customlangb",$btit_settings["customlangb"]);
$uploadtpl->set("customlangc",$btit_settings["customlangc"]);

if ($btit_settings["uplang"]==true ) 
    $uploadtpl->set("upla",true,FALSE);
else
   $uploadtpl->set("upla",false,TRUE);
// language 

// auto torrent name
	if ($btit_settings["tornam"]==true)
   {
    $uploadtpl->set("tora",true,FALSE);
    $uploadtpl->set("torb",false,TRUE);
    $uploadtpl->set("toraa",true,FALSE);
    $uploadtpl->set("torbb",false,TRUE);
   }
else
   {
    $uploadtpl->set("torb",true,FALSE);
    $uploadtpl->set("tora",false,TRUE);
    $uploadtpl->set("torbb",true,FALSE);
    $uploadtpl->set("toraa",false,TRUE);
   }
// auto torrent name

// upload mistake protection
if ($btit_settings["uploff"]==true AND $btit_settings["menu"]==false)
   {
    $uploadtpl->set("uploffing",true,FALSE);
   }
else
   {
    $uploadtpl->set("uploffing",false,TRUE);
   }
// upload mistake protection    

//nfo
if ($btit_settings["nfosw"]==true )
   {
    $uploadtpl->set("nfoa",true,FALSE);
    $uploadtpl->set("nfob",false,TRUE);
   }
else
   {
    $uploadtpl->set("nfob",true,FALSE);
    $uploadtpl->set("nfoa",false,TRUE);
    $uploadtpl->set("ripper","<a href=\"javascript:PopRip();\">".$language['rip_link']."</a>");
   }      
//nfo
        
// VIP torrent
    $current_level = getLevelVT($CURUSER['id_level']);
    $level_vt = false;

if ($CURUSER["uid"]>1 && $current_level>=$btit_settings["vip_set"] && $CURUSER['can_upload']=='yes')
   {
    $uploadtpl->set("LEVEL_VT",true,FALSE);
   }
else
   {
    $uploadtpl->set("LEVEL_VT",false,TRUE);
   }
//VIP torrent end
    
// Mod by losmi -sticky torrent
    $query = "SELECT * FROM {$TABLE_PREFIX}sticky";
    $rez = do_sqlquery($query,true);
    $rez = mysqli_fetch_assoc($rez);
    $rez_level = $rez['level'];
    $current_level = getLevel($CURUSER['id_level']);
    $level_ok = false;
    
if ($CURUSER["uid"]>1 && $current_level>=$rez_level && $CURUSER['can_upload']=='yes')
   {
    $uploadtpl->set("LEVEL_OK",true,FALSE);
   }
else
   {
    $uploadtpl->set("LEVEL_OK",false,TRUE);
   }
   unset($rez);
//Mod by losmi -sticky torrent

$uploadtpl->set("language",$language);
$uploadtpl->set("upload_script","index.php");

switch ($status) {
case 0:
      foreach ($TRACKER_ANNOUNCEURLS as $taurl)
            $announcs=$announcs."$taurl<br />";
            
      $category = (!isset($_GET["category"])?0:explode(";",$_GET["category"]));
// sanitize categories id
      if (is_array($category))
          $category = array_map("intval",$category);
      else
          $category = 0;

      $combo_categories=categories( $category[0] );

// TEAM DROPDOWN
$teamsdropdown = "<select name=\"team\"><option value=0></option>\n";
$teams = team_list();
foreach ($teams as $teams) {
if (($CURUSER['id_level']>7) OR ($teams["id"] == $CURUSER['team']))
{
$teamsdropdown .= "<option value=\"" . $teams["id"] . "\"";
if ($teams["id"] == $results["team"])
$teamsdropdown .= " selected=\"selected\"";
$teamsdropdown .= ">" . htmlspecialchars($teams["name"]) . "</option>\n";
}
}
$teamsdropdown .= "</select>\n";
if (($CURUSER['id_level']>7) OR ($teams["id"] == $CURUSER['team']))
{
//END team

$combo_teams="<tr>
        <td class=\"header\" >Team:</td>
        <td class=\"lista\">".$teamsdropdown."</td>
      </tr>";
}else{
$$combo_teams="";
}
       $gold_level='';
       $res=get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'",true);
            foreach ($res as $key=>$value)
            {
                $gold_level = $value["level"];
                
            } 
            
            if($gold_level>$CURUSER['id_level'])
            {
                 $uploadtpl->set("upload_gold_level",false,true);
            }
            else 
            {
                 $uploadtpl->set("upload_gold_level",true,true);
            }
      $gold_select_box = createGoldCategories();
      $uploadtpl->set("upload_gold_combo",$gold_select_box);
      
// Upload Multiplier

           if ($CURUSER["id_level"] > $btit_settings["multie"])
   {
$row=mysqli_fetch_row(mysqli_query($GLOBALS["___mysqli_ston"], "SHOW COLUMNS FROM {$TABLE_PREFIX}files LIKE 'multiplier'"));
$options=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$row[1]));

   $uploadtpl->set("multie1","<tr>\n\t<td align=left class=\"header\">Upload Multiplier</td>");
   $uploadtpl->set("multie2","\n\t<td align=\"left\" class=\"lista\" colspan=2><select name=multiplier>");
foreach($options as $multiplier)
  {
         $option .= "<option value=\"" . $multiplier. "\"";
       if ($multiplier==$results["multiplier"])
           $option.="selected=selected ";
         $option .= ">" . unesc($multiplier) . "</option>\n";

   $uploadtpl->set("multie3",$option);

  }
    $uploadtpl->set("multie4","</select></td>\n</tr>");
    }
// Upload Multiplier
      $bbc= textbbcode("upload","info");
      $uploadtpl->set("upload.announces",$announcs);
      $uploadtpl->set("upload_categories_combo",$combo_categories);
      $uploadtpl->set("upload_teams_combo",$combo_teams);
      $uploadtpl->set("textbbcode",  $bbc);
      $uploadtpl->set("youtube_video",$youtube_video);
      
	      if ($CURUSER['trusted']=='yes')
	      {
	      $moder="ok";
	      }
	      else{
	      $moder="um";
	      }
	      
	      $uploadtpl->set("moder", $moder);
// moder

      $uploadtpl->set("imageon",$GLOBALS["imageon"] == "true", TRUE);
      $uploadtpl->set("screenon",$GLOBALS["screenon"] == "true", TRUE);
      
if ($btit_settings["imgsw"]==true ) 
{
$uploadtpl->set("uplink",false,TRUE);
$uploadtpl->set("uplinkk",false,TRUE);
$uploadtpl->set("uplo",true,FALSE);
$uploadtpl->set("uplok",true,FALSE);
}
else
{
$uploadtpl->set("uplink",true,FALSE);
$uploadtpl->set("uplinkk",true,FALSE);
$uploadtpl->set("uplo",false,TRUE);	
$uploadtpl->set("uplok",false,TRUE);	
} 


      $tplfile="upload";
    break;
case 1:
    if ($PRIVATE_ANNOUNCE || $DHT_PRIVATE) {       
        $uploadtpl->set("MSG_DOWNLOAD_PID",$language["MSG_DOWNLOAD_PID"]);
        $tplfile="upload_finish";
        $uploadtpl->set("DOWNLOAD","<br /><a href=\"download.php?id=$hash&f=".urlencode($filename).".torrent\">".$language["DOWNLOAD"]."</a><br /><br />");
    }
    $tplfile="upload_finish";
    break;
case 2: 
    $tplfile="upload_finish";
    break;
}

?>