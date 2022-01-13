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

$link = urldecode($_GET["returnto"]);

if ($link=="")
   $link="index.php?page=torrents";


if ((isset($_POST["comment"])) && (isset($_POST["name"]))){

   if ($_POST["action"]==$language["FRM_CONFIRM"] || $_POST["action"]==$language["FRM_CONFIRM_VALIDATE"]) {

   if ($_POST["name"]=='')
        stderr("Error!","You must specify torrent name.");
   
if ($btit_settings["nfosw"]==true )
   { 
      $HTTP_POST_FILES["nfo"]["tmp_name"]=str_replace("\\", "/", $HTTP_POST_FILES["nfo"]["tmp_name"]);
      $_FILES["nfo"]["tmp_name"]=str_replace("\\", "/", $_FILES["nfo"]["tmp_name"]);

      if (strpos($_FILES["nfo"]["tmp_name"],"/"))
         $nfo=$_FILES["nfo"]["tmp_name"];
      else
         $nfo=$HTTP_POST_FILES["nfo"]["tmp_name"];
         $nfo=realpath($nfo);

      $nfocheck = basename($_FILES['nfo']['name']);
      $nfohashed = AddSlashes($_POST["info_hash"]);
     
      if ($nfocheck) {
        $ext = strrchr($nfocheck,'.');
        $limitedext = array(".nfo");
        
        if (!in_array(strtolower($ext),$limitedext)) $error["nfo"] = stderr("Error!","Not an nfo file!");
        if($_FILES['nfo']['size'] < "128") $error["nfo"] = stderr("Error!","Not a valid nfo or too small!");

          if(empty($error)) {         
            $result = @move_uploaded_file($nfo, "nfo/rep/" . $nfohashed . ".nfo");
               if(empty($result)) $error["result"] = stderr("Error!","Error moving nfo file!");
          }
      } 
      else {
         $delnfo = isset($_POST["nfo"])?"checked":"unchecked";  
          if ($delnfo != "checked"?"checked=\"checked\"":"")
            @unlink("nfo/rep/" . $nfohashed . ".nfo");
      }
      
      if(is_array($error)) { while(list($key, $val) = each($error)) echo $val; }
}

      
   if ($_POST["comment"]=='')
     stderr("Error!","You must specify description.");
   
// staff_comment start
if (isset($_POST["staff_comment"]))
$staff_comment = mysqli_real_escape_string($DBDT,htmlspecialchars($_POST["staff_comment"]));
else
    $staff_comment = "";
// staff_comment end
   
//gold mod
    $golden = 0;
   if($_POST["gold"]!='' && isset($_POST["gold"]))
   $golden = mysqli_real_escape_string($DBDT,$_POST["gold"]);      
//gold mod   
   
// start VIP torrent
   $vip_torrent = 0;
   if($_POST["vip_torrent"] == 'on')
   $vip_torrent = 1;
// end VIP torrent

/*Mod by losmi -sticky start*/
   $sticky = 0;
   if($_POST["sticky"] == 'on')
   $sticky = 1;
/*Mod by losmi -sticky end*/

if ($btit_settings["imgsw"]==false ) 
{    
//image url
$img=AddSlashes($_POST["userfile"]);   
$imga=AddSlashes($_POST["screen1"]);  
$imgb=AddSlashes($_POST["screen2"]);  
$imgc=AddSlashes($_POST["screen3"]);  
//image url  
}

//Upload Multiplier
    $mult = $_POST["multiplier"];
//Upload Multiplier
   $fyt=AddSlashes($_POST["yt"]);
   $fname=htmlspecialchars(AddSlashes(unesc($_POST["name"])));
   $torhash=AddSlashes($_POST["info_hash"]);
   $team=AddSlashes($_POST["team"]);
   $imdb=AddSlashes($_POST["imdb"]);
   write_log("Modified torrent $fname ($torhash)","modify"); 
   
   if($_POST["action"]==$language["FRM_CONFIRM"])
   {
	   if($CURUSER['moderate_trusted']=='yes' || $CURUSER['trusted'] == 'yes')
	   $moder = $_POST['moder'];
	   else 
	   $moder = 'um';
   }
   else 
   $moder = 'um';
	   
if($golden!='' && isset($golden))
{
do_sqlquery("UPDATE {$TABLE_PREFIX}files SET gold='$golden' WHERE info_hash='" . $torhash . "'",true);

$xgold=($golden==0?100:($golden==2?0:50));
if ($XBTT_USE)
do_sqlquery("UPDATE xbt_files SET down_multi=$xgold, flags=2 WHERE info_hash='".mysqli_real_escape_string($DBDT,hex2bin($torhash))."'"); 
}             
      
updatemoderbyhash($moder,$torhash);

if($moder=='ok' && $CURUSER['trusted'] == 'no')
  {
  	$get_user="SELECT f.moder as moder, f.filename, f.info_hash, f.uploader as upname, u.username as uploader, c.image, c.name as cname, f.category as catid FROM {$TABLE_PREFIX}files f LEFT JOIN {$TABLE_PREFIX}users u ON u.id = f.uploader LEFT JOIN {$TABLE_PREFIX}categories c ON c.id = f.category WHERE info_hash='".$torhash."'";
  	$row = do_sqlquery($get_user,true);

if (mysqli_num_rows($row)==1) {
	   $username ='';
		while ($data=mysqli_fetch_array($row)) {
			$username = $data['upname'];
			$file = $data['filename'];
			$uploader = $data['uploader'];
		}
		$msg = '[b]'.$uploader.' your torrent '.$file.' is approved![/b]
		Do not reply, this is an automatic message.';
	  	send_pm($CURUSER["uid"],$username,sqlesc($file),sqlesc($msg));
	  }
	if  ($btit_settings["sbone"] == true || $CURUSER['trusted'] == 'no')
      { 
      $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
      $rw=mysqli_fetch_assoc($al);
      $ct =  ($rw["count"]+1);       
      do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text, count) VALUES (0,".time().", 'System','[color=red]NEW TORRENT[/color]: [url=$BASEURL/index.php?page=torrent-details&id=$torhash]".$file."[/url]',".$ct.")");
      }
  }
 if ($_POST["ex_moder"]!=$moder && $moder=="bad" && $CURUSER["moderate_trusted"]=="yes") {
redirect("index.php?page=moder&hash=".$torhash."");
}

$youtube_video = $_FILES["youtube_video"];
 
if ($btit_settings["imgsw"]==false ) 
{    
//image url
$userfile = $_FILES["userfile"];
$screen1 = $_FILES["screen1"];
$screen2 = $_FILES["screen2"];
$screen3 = $_FILES["screen3"];
do_sqlquery("UPDATE {$TABLE_PREFIX}files SET image='$img',screen1='$imga',screen2='$imgb',screen3='$imgc' WHERE info_hash='" . $torhash . "'",true);
//image url  
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
            $file_name = $torhash.".bmp";
            break;
            case 'image/jpeg':
            $file_name = $torhash.".jpg";
            break;
            case 'image/pjpeg':
            $file_name = $torhash.".jpeg";
            break;
            case 'image/gif':
            $file_name = $torhash.".gif";
            break;
            case 'image/x-png':
            $file_name = $torhash.".png";
            break;
            case 'image/png':
            $file_name = $torhash.".png";
            break;
        }
        switch($_FILES["screen1"]["type"]) {
            case 'image/bmp':
            $file_name_s1 = "s1".$torhash.".bmp";
            break;
            case 'image/jpeg':
            $file_name_s1 = "s1".$torhash.".jpg";
            break;
            case 'image/pjpeg':
            $file_name_s1 = "s1".$torhash.".jpeg";
            break;
            case 'image/gif':
            $file_name_s1 = "s1".$torhash.".gif";
            break;
            case 'image/x-png':
            $file_name_s1 = "s1".$torhash.".png";
            break;
            case 'image/png':
            $file_name_s1 = "s1".$torhash.".png";
            break;           
        }
        switch($_FILES["screen2"]["type"]) {
            case 'image/bmp':
            $file_name_s2 = "s2".$torhash.".bmp";
            break;
            case 'image/jpeg':
            $file_name_s2 = "s2".$torhash.".jpg";
            break;
            case 'image/pjpeg':
            $file_name_s2 = "s2".$torhash.".jpeg";
            break;
            case 'image/gif':
            $file_name_s2 = "s2".$torhash.".gif";
            break;
            case 'image/x-png':
            $file_name_s2 = "s2".$torhash.".png";
            break;
            case 'image/png':
            $file_name_s2 = "s2".$torhash.".png";
            break;            
        }
        switch($_FILES["screen3"]["type"]) {
            case 'image/bmp':
            $file_name_s3 = "s3".$torhash.".bmp";
            break;
            case 'image/jpeg':
            $file_name_s3 = "s3".$torhash.".jpg";
            break;
            case 'image/pjpeg':
            $file_name_s3 = "s3".$torhash.".jpeg";
            break;
            case 'image/gif':
            $file_name_s3 = "s3".$torhash.".gif";
            break;
            case 'image/x-png':
            $file_name_s3 = "s3".$torhash.".png";
            break;
            case 'image/png':
            $file_name_s3 = "s3".$torhash.".png";
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
                elseif (in_array (strtolower ($file_type), $image_types, TRUE))
                {
                    if (@move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
                    {
                        do_sqlquery("UPDATE {$TABLE_PREFIX}files SET image='".$file_name."' WHERE info_hash='" . $torhash . "'",true);
                        $image_drop = "" . $_POST["userfileold"]. "";

                        if (!empty($image_drop))
                            @unlink("".$GLOBALS["uploaddir"]."$image_drop");
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
                elseif (in_array (strtolower ($file_type1), $image_types, TRUE))
                {
                    if (@move_uploaded_file($_FILES['screen1']['tmp_name'], $uploadfile1))
                    {
                        do_sqlquery("UPDATE {$TABLE_PREFIX}files SET screen1='".$file_name_s1."' WHERE info_hash='" . $torhash . "'",true);
                        $image_drop = "" . $_POST["userfileold1"]. "";

                        if (!empty($image_drop))
                            @unlink("".$GLOBALS["uploaddir"]."$image_drop");
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
                elseif (in_array (strtolower ($file_type2), $image_types, TRUE))
                {
                    if (@move_uploaded_file($_FILES['screen2']['tmp_name'], $uploadfile2))
                    {
                        do_sqlquery("UPDATE {$TABLE_PREFIX}files SET screen2='".$file_name_s2."' WHERE info_hash='" . $torhash . "'",true);
                        $image_drop = "" . $_POST["userfileold2"]. "";

                        if (!empty($image_drop))
                            @unlink("".$GLOBALS["uploaddir"]."$image_drop");
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
                        do_sqlquery("UPDATE {$TABLE_PREFIX}files SET screen3='".$file_name_s3."' WHERE info_hash='" . $torhash . "'",true);
                        $image_drop = "" . $_POST["userfileold3"]. "";

                        if (!empty($image_drop))
                            @unlink("".$GLOBALS["uploaddir"]."$image_drop");
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

   do_sqlquery("UPDATE {$TABLE_PREFIX}files SET tag='".AddSlashes($_POST["tag"])."',team='".$team."',staff_comment = '" . $staff_comment . "',imdb='$imdb', youtube_video='$fyt',multiplier='$mult', filename='$fname',language= " . intval($_POST["language"]) . ", comment='" . AddSlashes($_POST["comment"]) . "', category=" . intval($_POST["category"]) . ", sticky = '" . $sticky . "', vip_torrent = '" . $vip_torrent . "'  WHERE info_hash='" . $torhash . "'",true);
   redirect($link);
   exit();
   }

   else {
        redirect($link);
        exit();
   }
}

// view torrent's details
if (isset($_GET["info_hash"])) {

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

    $query ="SELECT f.multiplier,f.team,f.language,f.tag,f.youtube_video, f.imdb, f.staff_comment,  f.gold, f.image, f.screen1, f.screen2, f.screen3, f.vip_torrent,  f.info_hash, f.filename,f.sticky, f.url, UNIX_TIMESTAMP(f.data) as data, f.size, f.comment, f.category as cat_name, $tseeds, $tleechs, $tcompletes, f.speed, f.uploader FROM $ttables WHERE f.info_hash ='" . AddSlashes($_GET["info_hash"]) . "'";
  $res = do_sqlquery($query,true);
  $results = mysqli_fetch_assoc($res);

  if (!$results || mysqli_num_rows($res)==0)
     err_msg($language["ERROR"],$language["TORRENT_EDIT_ERROR"]);

  else {

    if (!$CURUSER || $CURUSER["uid"]<2 || ($CURUSER["edit_torrents"]=="no" && $CURUSER["uid"]!=$results["uploader"]))
    stderr($language["ERROR"],$language["CANT_EDIT_TORR"]);
       
    $moder_status = getmoderstatusbyhash(AddSlashes($_GET["info_hash"]));
	
	$torrenttpl=new bTemplate();
    $torrenttpl->set("language",$language);

//  $row=$res[0];
 
$torrenttpl->set("imageon",$GLOBALS["imageon"] == "true", TRUE);
$torrenttpl->set("screenon",$GLOBALS["screenon"] == "true", TRUE);

if ($btit_settings["imgsw"]==true ) 
{
$torrenttpl->set("uplink",false,TRUE);
$torrenttpl->set("uplinkk",false,TRUE);
$torrenttpl->set("uplo",true,FALSE);
$torrenttpl->set("uplok",true,FALSE);
}
else
{
$torrenttpl->set("uplink",true,FALSE);
$torrenttpl->set("uplinkk",true,FALSE);
$torrenttpl->set("uplo",false,TRUE);	
$torrenttpl->set("uplok",false,TRUE);	
}

// Upload Multiplier
if ($CURUSER["id_level"] > $btit_settings["multie"])
   {
$row=mysqli_fetch_row(mysqli_query($GLOBALS["___mysqli_ston"], "SHOW COLUMNS FROM {$TABLE_PREFIX}files LIKE 'multiplier'"));
$options=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$row[1]));

    $torrenttpl->set("multie1","<tr>\n\t<td align=right class=\"header\">Upload Multiplier</td>");
   $torrenttpl->set("multie2","\n\t<td align=\"left\" class=\"lista\" colspan=2><select name=multiplier>");
foreach($options as $multiplier)
  {
       $option .= "<option value=\"" . $multiplier. "\"";
       if ($multiplier==$results["multiplier"])
           $option.="selected=selected ";
         $option .= ">" . unesc($multiplier) . "</option>\n";

   $torrenttpl->set("multie3",$option);

  }
    $torrenttpl->set("multie4","</select></td>\n</tr>");
    }
// Upload Multiplier
 $torrent=array();

$torrenttpl->set("customlang",$btit_settings["customlang"]); 
$customlang=$btit_settings["customlang"];
$torrenttpl->set("customlanga",$btit_settings["customlanga"]); 
$customlang=$btit_settings["customlanga"];
$torrenttpl->set("customlangb",$btit_settings["customlangb"]); 
$customlang=$btit_settings["customlangb"];
$torrenttpl->set("customlangc",$btit_settings["customlangc"]); 
$customlang=$btit_settings["customlangc"];
 
 if ($results["language"] == '0') {
	$torrent["nolang"]=" selected=\"selected\">";
	} else if ($results["language"] == '1') {
	$torrent["english"]=" selected=\"selected\">";
	} else if ($results["language"] == '2') {
	$torrent["french"]=" selected=\"selected\">";
	} else if ($results["language"] == '3') {
	$torrent["dutch"]=" selected=\"selected\">";
	} else if ($results["language"] == '4') {
	$torrent["german"]=" selected=\"selected\">";
	} else if ($results["language"] == '5') {
	$torrent["spanish"]=" selected=\"selected\">";
	} else if ($results["language"] == '6') {
	$torrent["italian"]=" selected=\"selected\">";
	} else if ($results["language"] == '7') {
	$torrent["$customlang"]=" selected=\"selected\">";
	} else if ($results["language"] == '8') {
	$torrent["$customlanga"]=" selected=\"selected\">";
	} else if ($results["language"] == '9') {
	$torrent["$customlangb"]=" selected=\"selected\">";
	} else if ($results["language"] == '10') {
	$torrent["$customlangc"]=" selected=\"selected\">";
	}

if ($btit_settings["uplang"]==true) 
$torrenttpl->set("upla",true,FALSE);
else
 $torrenttpl->set("upla",false,TRUE);
 
// Start staff_comment
    $current_level = getLevelSC($CURUSER['id_level']);
    $level_sc = false;

if ($CURUSER["uid"]>1 && $current_level>=$btit_settings["staff_comment"] && $CURUSER['can_upload']=='yes')
$torrenttpl->set("LEVEL_SC",true,FALSE);
else
$torrenttpl->set("LEVEL_SC",false,TRUE);
   

$torrenttpl->set("staff_comment",$results["staff_comment"]);
//End staff_comment
            
/*Start gold mod by losmi*/
    $gold_level='';
    $resg=get_result("SELECT * FROM {$TABLE_PREFIX}gold  WHERE id='1'",true);
    foreach ($resg as $key=>$value)
        $gold_level = $value["level"];

    unset($resg);

    if($gold_level>$CURUSER['id_level'])
         $torrenttpl->set("edit_gold_level",false,true);
    else
         $torrenttpl->set("edit_gold_level",true,true);

    $torrent["gold"]=createGoldCategories($results["gold"]);
/*End gold mod by losmi*/

//VIP torrent
    $current_level = getLevelVT($CURUSER['id_level']);
    $level_vt = false;

if ($CURUSER["uid"]>1 && $current_level>=$btit_settings["vip_set"] && $CURUSER['can_upload']=='yes')
   $torrenttpl->set("LEVEL_VT",true,FALSE);
else
   $torrenttpl->set("LEVEL_VT",false,TRUE);
   
if($results["vip_torrent"] == 1)
    $torrent["vip_torrent"] = "<input type='checkbox' name='vip_torrent' checked>" ;
else
    $torrent["vip_torrent"] = "<input type='checkbox' name='vip_torrent'>" ;
//End VIP torrent

//nfo
if ($btit_settings["nfosw"]==true )
$torrenttpl->set("nfo",true,FALSE);
else
$torrenttpl->set("nfo",false,TRUE);
//nfo
            
/*Start sticky by losmi*/
              $query = "SELECT * FROM {$TABLE_PREFIX}sticky";
              $rez = do_sqlquery($query,true);
              $rez = mysqli_fetch_assoc($rez);
              $rez_level = $rez['level'];
              $current_level = getLevel($CURUSER['id_level']);
              $level_ok = false;
              
              if ($CURUSER["uid"]>1 && $current_level>=$rez_level)
                 $torrenttpl->set("LEVEL_OK",true,FALSE);
                 else
                 $torrenttpl->set("LEVEL_OK",false,TRUE);
                 
             unset($rez);

            if($results["sticky"] == 1)
            $torrent["sticky"] = "<input type='checkbox' name='sticky' checked>" ;
            else 
            $torrent["sticky"] = "<input type='checkbox' name='sticky'>" ;
/*End sticky by losmi*/
            
    $torrent["link"]="index.php?page=edit&info_hash=".$results["info_hash"]."&returnto=".urlencode($link);
    $torrent["filename"]=$results["filename"];

//tag
if ($btit_settings["tag"]==true ) 
{
$torrenttpl->set("tag",true,FALSE);
$torrent["tag"]=$results["tag"];  
}
else
$torrenttpl->set("tag",false,TRUE);   
//tag
  
if ($btit_settings["nfosw"]==true )
   {     
$filenfo = "nfo/rep/" . $results["info_hash"] . ".nfo";

if (file_exists($filenfo)) {

  $torrent["nfo"] = "
   <div>
    <sup>&nbsp;<b>Uncheck</b> to remove or upload a new nfo<br />
    <a href='#nfo' onclick=\"javascript:ShowHide('uploadmenfo','');\"><input type='checkbox' name='nfo' checked></a>" . $results["filename"] . ".nfo</div>

               <div style='display:none' id='uploadmenfo'>

               <input type='file' name='nfo'>
</div>";
 
}
else {
  $torrent["nfo"] = "
     <tr>
      <td class='header' align='right'>NFO</td>
      <td class='lista' align='left'><sup>Optionaly choose to browse for nfo file</sup><br /><input type='file' name='nfo' /></td>
    </tr>
    ";

}
}


    $torrent["info_hash"]=$results["info_hash"];
	$torrent["imdb"]=$results["imdb"];
    $torrent["description"]=textbbcode("edit","comment",unesc($results["comment"]));
    $torrent["size"]=makesize($results["size"]);
    $torrent["youtube_video"]=$results["youtube_video"];
if ($btit_settings["imgsw"]==false ) 
{       
    $torrent["image"]=$results["image"];
    $torrent["screen1"]=$results["screen1"];
    $torrent["screen2"]=$results["screen2"];
    $torrent["screen3"]=$results["screen3"];
}
    include(dirname(__FILE__)."/include/offset.php");

    $torrent["date"]=date("d/m/Y",$results["data"]-$offset);
    $torrent["complete"]=$results["finished"]." ".$language["X_TIMES"];
    $torrent["peers"]=$language["SEEDERS"] .": " .$results["seeds"].",".$language["LEECHERS"] .": ". $results["leechers"]."=". ($results["leechers"]+$results["seeds"]). " ". $language["PEERS"];
    $torrent["cat_combo"]= categories($results["cat_name"]);
    
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
$torrent["teams_combo"]="<tr>
        <td align=right class=\"header\" >Team:</td>
        <td class=\"lista\">".$teamsdropdown."</td>
      </tr>";
}else{
$torrent["teams_combo"]="";
}
	
	if ($CURUSER['edit_torrents']=="yes" && $CURUSER['moderate_trusted']=='yes')
	{
		switch ($moder_status)
		{
		case 'ok':
		$checked1="SELECTED";
		break;
		case 'bad':
		$checked2="SELECTED";
		break;
		case 'um':
		$checked3="SELECTED";
		break;
		}
	
	$torrent["moder"]="<select name=\"moder\" id=\"icon\" onchange=\"showimage()\">
											<option $checked1 value=\"ok\">".$language["MODERATE_STATUS_OK"]."</option>
											<option $checked2 value=\"bad\">".$language["MODERATE_STATUS_BAD"]."</option>
											<option $checked3 value=\"um\">".$language["MODERATE_STATUS_UN"]."</option>
										</select> ";
	}
	
	$torrent["moder"].="<img name=\"icons\" src=\"images/mod/$moder_status.png\" alt=\"$moder_status\" title=\"$moder_status\">";
	$torrent["ex_moder"]=$moder_status;
	 
	$torrenttpl->set("torrent",$torrent);

    unset($results);
    ((mysqli_free_result($res) || (is_object($res) && (get_class($res) == "mysqli_result"))) ? true : false);
}
}
?>