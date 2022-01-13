<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// DOX hack converted by DiemThuy - march 2009
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
      
if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
   $file = $_FILES['file'];
  // $maxfile = ($btit_settings["limit_dox"]*1024);
   $types= Array ("srt/plain", "application/zip", "image/jpeg", "image/gif", "image/pjpeg", "image/png");
   if ((!$file) || ($file["size"] == 0) || ($file["name"] == "") || ($file["size"]>$btit_settings["limit_dox"]))
     {
       stderr("Error", "Nothing received! The selected file may have been too large. MAX " . makesize($btit_settings["limit_dox"]));
       stdfoot();
       die;
     }
   if (file_exists("$DOXPATH/$file[name]"))
   {
    stderr("Error", "A file with the name <b>$file[name]</b> already exists!");
    stdfoot();
    die;
   }
   $title = trim($_POST["title"]);
   if ($title == "")
   {
     $title = substr($file["name"], 0, strrpos($file["name"], "."));
     if (!$title)
       $title = $file["name"];
   }
   $r = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM {$TABLE_PREFIX}dox WHERE title=" . sqlesc($title)) or sqlesc();
   if (mysqli_num_rows($r) > 0)
     {
       stderr("Error", "A file with the title <b>" . htmlspecialchars($title) . "</b> already exists!");
       stdfoot();
       die;
     }
   $url = $_POST["url"];
if ($url != "")
   {
     if (substr($url, 0, 7) != "http://" && substr($url, 0, 6) != "ftp://")
     {
      stderr("Error", "The URL <b>" . htmlspecialchars($url) . "</b> does not seem to be valid.");
      stdfoot();
      die;
     }
   }
if((isset($file["tmp_name"]) && !empty($file["tmp_name"])) && (isset($file["name"]) && !empty($file["name"])))
{
    $check_dox=check_upload($file["tmp_name"], $file["name"]);         
    switch($check_dox)
    {
        case 1:
        case 2:
          $check_dox_err=$language["ERR_MISSING_DATA"];
          if(file_exists($file["tmp_name"]))
          @unlink($file["tmp_name"]);
          break;
                        
        case 3:
          $check_dox_err=$language["QUAR_TMP_FILE_MISS"];
          break;
        case 4:
          $check_dox_err=$language["QUAR_OUTPUT"];
          break;
        case 5:
          default:
          $check_dox_err="";
          break;
    }
    if($check_dox_err!="")
        stderr($language["ERROR"], $check_dox_err);
}
if (!move_uploaded_file($file["tmp_name"], "$DOXPATH/$file[name]"))
 {
   stderr("Error", "Failed to move uploaded file. You should contact an administrator about this error.");
   stdfoot();
   die;
 }
   setcookie("doxurl", $url, 0x7fffffff);
   $title = sqlesc($title);
   $filename = sqlesc($file["name"]);
   $added = sqlesc(get_date_time());
   $uppedby = $CURUSER["uid"];
   $size = $file["size"];
   $url = sqlesc($url);
   if (($size < $btit_settings["limit_dox"]) && ($size != 0))
   mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}dox (title, filename, added, uppedby, size, url) VALUES($title, $filename, NOW(), $uppedby, $size, $url)") or sqlerr();
   header("Location: $BASEURL/index.php?page=dox");
die;
 }
//End POST
 if ($CURUSER["id_level"] > 1)
 {
   $delete = $_GET["delete"];
   if (is_valid_id($delete))
   {
    $r = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filename,uppedby FROM {$TABLE_PREFIX}dox WHERE id=$delete") or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($r) == 1)
    {
         $a = mysqli_fetch_assoc($r);
      if ($CURUSER["admin_access"] == "yes" || $a["uppedby"] == $CURUSER["uid"])
      {
        mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}dox WHERE id=$delete") or sqlerr(__FILE__, __LINE__);
        if (!unlink("$DOXPATH/$a[filename]"))
        {
             stderr("Warning", "Unable to unlink file: <b>$a[filename]</b>. You should contact an administrator about this error.");
             stdfoot();
             die;
        }
             header("Location: $BASEURL/index.php?page=dox");
      }
    }
   }
 }
 
 if ($CURUSER["id_level"] < $btit_settings["dl"])
	  {
       stderr("ERROR","sorry , your rank is not allowed to use this feature");
       stdfoot();
       exit;
       }
     if (!isset($_GET["searchtext"])) $_GET["searchtext"] = "";
     if (!isset($_GET["level"])) $_GET["level"] = "";
         $search=$_GET["searchtext"];
         $addparams="";
         if ($search!="")
            {
            $where="WHERE title LIKE '%".mysqli_real_escape_string($DBDT,$_GET["searchtext"])."%'";
            $addparams="searchtext=$search";
            }
         else
             $where="";
 $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) FROM {$TABLE_PREFIX}dox $where ORDER BY added DESC") or sqlerr();
         $scriptname=htmlspecialchars("index.php?page=dox");
         $row = mysqli_fetch_row($res);
         $count = $row[0];
         if ($addparams <> "")
            list($pagertop, $pagerbottom, $limit) = pager($DoxLimitPerPage, $count,  "index.php?page=dox&" . $addparams . "&");
         else
            list($pagertop, $pagerbottom, $limit) = pager($DoxLimitPerPage, $count,  "index.php?page=dox&");
            
$doxtpl=new bTemplate();
$doxtpl->set("language",$language);
$doxtpl->set("dox1","<div align=center>");
$doxtpl->set("dox2","<form action=index.php  name=find method=get><input type=hidden name=page value=dox />");
$doxtpl->set("dox3","<table border=0 class=lista>");
$doxtpl->set("dox4","<tr>");
$doxtpl->set("dox5","<td class=block>Find file with title</td>");
$doxtpl->set("dox6","<td class=block>&nbsp;</td>");
$doxtpl->set("dox7","</tr>");
$doxtpl->set("dox8","<tr>");
$doxtpl->set("dox9","<td><input type=text name=searchtext size=30 maxlength=50 value=$search ></td>");
$doxtpl->set("dox10","<td><input type=submit value=SEARCH /></td>");
$doxtpl->set("dox11","</tr>");
$doxtpl->set("dox12","</table>");
$doxtpl->set("dox13","</form>");
$doxtpl->set("dox14","</div>");
$doxtpl->set("dox15","<center>$pagertop</center>");
 $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}dox $where ORDER BY added DESC $limit") or sqlerr();
       $doxloop=array();
       $i=0;
$doxtpl->set("dox16","<p align=center>".$btit_settings["doxtekst"]."</p>\n");
 if (mysqli_num_rows($res) == 0)
$doxtpl->set("dox17","<p align=center>Sorry, nothing here pal :(</p>");
 else
 {
$doxtpl->set("dox18","<p><table align=center border=1 cellspacing=0 cellpadding=5>\n");
$doxtpl->set("dox19","<tr><td class=colhead align=left><center>Title</td><td class=colhead><center>Date</td><td class=colhead><center>Time</td>");
$doxtpl->set("dox20","<td class=colhead><center>Size</td><td class=colhead><center>Hits</td><td class=colhead><center>Upped by</td></tr>\n");
   $mod = $CURUSER["admin_access"] == "yes";
   while ($arr = mysqli_fetch_assoc($res))
   {
    $r = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username , id_level FROM {$TABLE_PREFIX}users WHERE id=$arr[uppedby]") or sqlerr();
    $a = mysqli_fetch_assoc($r);
    $res4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor , suffixcolor  FROM {$TABLE_PREFIX}users_level WHERE id =$a[id_level]");
    $arr4 = mysqli_fetch_assoc($res4);
   $title = "<td align=left><a href=index.php?page=getdox&filename=".rawurlencode($arr[filename])."><b>" . htmlspecialchars($arr["title"]) . "</b></a>" .
      ($mod || $arr["uppedby"] == $CURUSER["uid"] ? " <font size=1 class=small><a href=index.php?page=dox&delete=$arr[id]>[Delete]</a></font>" : "") ."</td>\n";
    $added = "<td>" . substr($arr["added"], 0, 10) . "</td><td>" . substr($arr["added"], 10) . "</td>\n";
    $size = "<td>" . makesize($arr['size']) . "</td>\n";
    $hits = "<td><center>" . number_format($arr['hits']) . "</td>\n";
    $uppedby = "<td><a href=index.php?page=userdetails&id=$arr[uppedby]><b>$arr4[prefixcolor] $a[username] $arr4[sufixcolor]</b></a></td>\n";
    $arr[filename] = rawurlencode("$arr[filename]");
$doxloop[$i]["dox21"]=("<tr>$title$added$size$hits$uppedby</tr>\n");
             $i++;
             $doxtpl->set("doxloop",$doxloop);
   }
$doxtpl->set("dox22","</table></p>\n");
 }
$doxtpl->set("dox23","</br>");
// $doxtpl->set("dox23","<center>$pagerbottom</center></br>");
 if ($CURUSER["id_level"] > $btit_settings["ul"])
 {
  $url = $_COOKIE["doxurl"];
   $maxfilesize = makesize($btit_settings["limit_dox"]);
  if ($btit_settings["dox"]==true)
  {
$doxtpl->set("dox24","<form enctype=multipart/form-data method=post action=index.php?page=dox>\n");
$doxtpl->set("dox25","<table align=center class=main border=1 cellspacing=0 cellpadding=5>\n");
$doxtpl->set("dox26","<tr><td class=rowhead><center>File </td><td align=left><input type=file name=file size=60><br>(Maximum file size: $maxfilesize.)</td></tr>\n");
$doxtpl->set("dox27","<tr><td class=rowhead><center>Title </td><td align=left><input type=text name=title size=60><br>(Optional, taken from file name if not specified.)</td></tr>\n");
$doxtpl->set("dox28","<tr><td colspan=2 align=center><input type=submit value='Upload file' class=btn></td></tr>\n");
$doxtpl->set("dox29","</table>\n");
$doxtpl->set("dox30","</form>\n");
}
}
?>