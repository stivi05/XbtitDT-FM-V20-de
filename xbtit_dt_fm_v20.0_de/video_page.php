<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    YouTube Page by DiemThuy ( Dec 2009 - X-Mas gift)
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

require_once ("include/functions.php");
dbconn();

function category($action, $sez="")
{
$cat = array (array("Autos & Vehicles", "Autos & Vehicles"),
              array("Comedy", "Comedy"),
              array("Entertainment", "Entertainment"),
              array("Film & Animation", "Film & Animation"),
              array("Howto & Style", "Howto & Style"),
              array("Music", "Music"),
              array("News & Politics", "News & Politics"),
              array("People & Blogs", "People & Blogs"),
              array("Pets & Animals", "Pets & Animals"),
              array("Sports", "Sports"),
              array("Travel & Events", "Travel & Events"));

if ($action=="translate")
{
for ($i=0; $i<count($cat); $i++)
{
$sez = str_replace($cat[$i][0], $cat[$i][1], $sez);
}
}
elseif ($action=="count")
{
$sez=count($cat);
}
elseif ($action=="cat_eng")
{
$sez=$cat[$sez][0];
}
elseif ($action=="cat_not_eng")
{
$sez=$cat[$sez][1];
}
return $sez;
}

function youtube($string)
{
return "<object width=\"425\" height=\"355\"><param name=\"movie\" value=\"https://www.youtube.com/v/$string&rel=1\"></param><param name=\"wmode\" value=\"transparent\"></param><embed src=\"https://www.youtube.com/v/$string&rel=1\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" width=\"425\" height=\"355\"></embed></object>";
}
$action = $_GET['action'];
if($action =="delete")
{
$VID = $_GET["vid"];
@mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM {$TABLE_PREFIX}videos WHERE id=\"$VID\"");
}
if ($action=="new")
{
$src.="<table class=lista border=0 align=center><br><center><a href=\"index.php?page=video_page\"><font color=steelblue><b>".$language['VID_BACK']."</b></a></font></a></center>";
$src.= '<br><form method="post" action="index.php?page=video_page&action=new">
<tr><td class="header" align="center">'.$language['VID_URL'].'</td><td class="lista"><input type="text" name="video"/></tr>
<tr><td class="header" align="center">'.$language['VID_FILE'].'</td><td class="lista"><input type="text" name="name"/></td></tr>
<tr><td class="header" align="center">'.$language['VID_CAT'].'</td><td class="lista"><select name="cat">
<option selected >'.$language['VID_CATES'].'</option>
<option value="Autos & Vehicles">'.$language['VID_CATA'].'</option>
<option value="Comedy">'.$language['VID_CATB'].'</option>
<option value="Entertainment">'.$language['VID_CATC'].'</option>
<option value="Film & Animation">'.$language['VID_CATD'].'</option>
<option value="Howto & Style">'.$language['VID_CATE'].'</option>
<option value="Music"><tag:sign />'.$language['VID_CATF'].'</option>
<option value="News & Politics">'.$language['VID_CATG'].'</option>
<option value="People & Blogs">'.$language['VID_CATH'].'</option>
<option value="Pets & Animals">'.$language['VID_CATI'].'</option>
<option value="Sports">'.$language['VID_CATJ'].'</option>
<option value="Travel & Events">'.$language['VID_CATK'].'</option>
</select></td></tr></table>
<table class=lista border=0 align=center>
<tr><td class="lista"><center><input type="submit" value="'.$language['VID_ADD'].'"/></center></td></tr>
</form></table>';
if(!empty($_POST['video']))
{
if (preg_match("#.*v[=|/]([a-zA-Z0-9_\-]{11})#i",$_POST['video'],$id))
{
$query=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}videos WHERE id = '$id[1]'");
if (mysqli_num_rows($query)==1)
{
while ($elementi= mysqli_fetch_object($query))
{
$src.="<br><center>".$elementi->title." (".category(translate, $elementi->category).")</center><br><center>".youtube($elementi->id)."<center><br>";
}
}
else
{
$check=@get_headers("https://www.youtube.com/watch?v=$id[1]");
if (preg_match("|200|", $check[0]))
{
$src.="<center>$title[1] (".category(translate, $category[1]).")</center><br>";
$src.="<center>".youtube($id[1])."</center><br>";

$db_title=$_POST['name'];
$db_id=addslashes(stripslashes("$id[1]"));
$db_category=$_POST['cat'];

mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}videos (title, id, category) VALUES ('$db_title', '$db_id', '$db_category')");
}
else
{
$src.="<center>".$language["VID_NONE"]."</center><br>";
}
}
}
else
{
$src.="<center>".$language["VID_FAKE"]."</center><br>";
}
}
else
{
$src.="<center>".$language["VID_PAGE"]."</center><br>";
}
}
elseif (!empty($_GET["id"]))
{
if (!$CURUSER || $CURUSER["id_level"] >= 6) // 6 is default id_level for moderators
{
$src.= "<center><a href=\"index.php?page=video_page&action=delete&vid=".$_GET["id"]."\"><font color=red><b>".$language["DELETE"]."</b></font></a></center><br>";
}
$src.= "<center><a href=\"index.php?page=video_page\"><font color=steelblue><b>".$language['VID_BACK']."</b></a></font></center><br>";

$check=@get_headers("https://www.youtube.com/watch?v=".$_GET["id"]."");
if (preg_match("|200|", $check[0]))
{
$query3=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}videos WHERE id = '$_GET[id]'");
if (mysqli_num_rows($query3)==1)
{
while ($elementi= mysqli_fetch_object($query3))
{
$src.="<center>".$elementi->title." (".$elementi->category.")<br><br>".youtube($_GET["id"])."</center><br>";
}
}
else
{
$src.="<center>".youtube($_GET["id"])."</center><br>";
}
}
else
{
$src.="<center>".$language['BAD_ID']."</center><br>";
}
}
else
{
$src.= "<br><center><a href=\"index.php?page=video_page&action=new\"><font color=steelblue><b>".$language['VID_NEW']."</b></a></font></center><br>";

for ($i=0; $i<category(count); $i++)
{
$c=0;
$src.= "<center><span style=\"font-size:20pt;line-height:100%\">".category(cat_not_eng, $i)."</span></center><br>";
$query2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}videos where category='".category(cat_eng, $i)."' ORDER BY `number` DESC");


$src.="<center><table border=\"1\"><tr>";
if ($query2)
while ($elementi= mysqli_fetch_object($query2))
{
$c++;
$z=$c-1;
if ($z%6==0)
{
$src.= "</tr>";
}
$imgarray = array("1","2","3","default");
$img=$imgarray[rand(0,count($imgarray)-1)];
$src.= "<td><center>".substr($elementi->title, 0, 22)."...</center><br><center><a href=\"index.php?page=video_page&id=".$elementi->id."\"><img title=\"$elementi->title (".category(cat_not_eng, $i).")\" alt=\"$elementi->title (".category(cat_not_eng, $i).")\" border=\"0\" src=\"https://img.youtube.com/vi/".$elementi->id."/".$img.".jpg\"></a><center><br></td>";


}
if ($z%6==0)
{
$src.= "<tr>";
}
$src.="</tr></table></center>";
if (!$c)
{
$src.="<center><font color = red>".$language['VID_EMPTY']."</font></center>";
}
$src.="<hr>";
}
}
$video_pagetpl=new bTemplate();
$video_pagetpl->set("language",$language);
$video_pagetpl->set("src",$src);
?>