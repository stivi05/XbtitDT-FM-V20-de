<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//  Partners page by DiemThuy - Jan 2010
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

require_once("include/functions.php");
dbconn();
global $CURUSER, $TABLE_PREFIX, $BASEURL;

$partnerstpl=new bTemplate();
$partnerstpl->set("language",$language);

/* valid actions */
$action = (isset($_GET["action"]) ? $_GET["action"] : (isset($_POST["action"]) ? $_POST["action"] : ''));
$allowed_actions = array('addpartner', 'editpartner', 'deletepartner','main');
$action = (($action && in_array($action,$allowed_actions,true)) ? $action : '') or header("Location: index.php?page=partners&action=main");

/*action == main */

if($action == "main"){

  $partnerstpl->set("pa1","<h2>Site Partners</h2>");
  $query = do_sqlquery("SELECT partner.id, partner.title, partner.banner, partner.link, users.username FROM {$TABLE_PREFIX}partner partner LEFT JOIN {$TABLE_PREFIX}users users ON partner.addedby=users.id") or sqlerr(__FILE__, __LINE__);
      $partners=array();
      $i=0;
  $partnerstpl->set("pa2","<table class=\"main\" cellspacing=\"0\" cellpadding=\"5\" width=\"95%\">

          <tr><center>
            <td class=\"colhead\">Banner</td>
            <td class=\"colhead\">Name</td>
            <td class=\"colhead\">Link</td>
            <td class=\"colhead\" align=\"center\">Added By</td>
          </center></tr>");

  if(mysqli_num_rows($query) == 0){
  $partnerstpl->set("pa3","<tr><td colspan=\"5\">No partners so far...</td></tr>");

}else{

  while($result = mysqli_fetch_array($query)){
    $partners[$i]["pa30"]=("<tr>
              <td><center><img src=".htmlspecialchars($result["banner"]) ." width=200/></center></td>
              <td><center><b>".htmlspecialchars($result["title"])."</b></center></td>
              <td><center><a href=".$result["link"]." target = _blank><img src=".$BASEURL."/images/visit.gif /></a></center></td>
              <td><center>".htmlspecialchars($result["username"])."</center></td>");

    if($CURUSER["edit_torrents"]=="yes")
    {
          $partners[$i]["pa31"]=("<td colspan=\"5\" align=\"right\"><a href=?page=partners&action=editpartner&id=".$result["id"]."><img src=".$BASEURL."/images/edit.gif /></a><a href=\"javascript:confirm_delete('".$result["id"]."');\"><img src=".$BASEURL."/images/delete.gif /></a></td>");


    }
     $partners[$i]["pa32"]=("</tr>");
     $i++ ;
    $partnerstpl->set("partners",$partners);
    }}
    
  if($CURUSER["edit_torrents"]=="yes")
  {
    $partnerstpl->set("pa6","<tr><td colspan=\"5\">
          <form method=\"post\" action=".$BASEURL."/index.php?page=partners&action=addpartner>
          <table class=\"main\" cellspacing=\"0\" cellpadding=\"5\" width=\"100%\">
            <tr><td class=\"colhead\" colspan=\"2\">Add A New Partner</td></tr>
            <tr><td valign=\"top\">Title:</td><td><input type=\"text\" name=\"title\" size=\"30\"></td></tr>
            <tr><td valign=\"top\">Banner URL:</td><td><input type=\"text\" name=\"banner\" size=\"60\"><br/><font class=\"small\">Some sites disables hotlinking for images, so it is recommended to host it to a third party site.</font></td></tr>
            <tr><td valign=\"top\">Link:</td><td><input type=\"text\" name=\"link\" size=\"60\"></td></tr>
            <tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"Update\"></td></tr>
          </td></tr></table>
          </form>");
}
$partnerstpl->set("pa11","</table>");
}

/*action == editpartner */
if($action == "editpartner" && $CURUSER["edit_torrents"]=="yes"){

  $id = (int)$_GET["id"];
  $query = do_sqlquery("SELECT partner.title, partner.banner, partner.link FROM {$TABLE_PREFIX}partner partner WHERE partner.id = {$id}") or sqlerr(__FILE__, __LINE__);
  $arr = mysqli_fetch_array($query);

  if(mysqli_num_rows($query) == 0)
  stderr("Error", "No partner with that id");

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $title = sqlesc($_POST["title"]);
  $banner = sqlesc($_POST["banner"]);
  $link = sqlesc($_POST["link"]);
  do_sqlquery("UPDATE {$TABLE_PREFIX}partner SET title=$title, banner=$banner, link=$link WHERE id=$id") or sqlerr(__FILE__, __LINE__);;
  header("Location: index.php?page=partners&action=main");
	}
   $partnerstpl->set("pa7","<h1>Edit Partner " .htmlspecialchars($arr["title"]). "</h1>");
   $partnerstpl->set("pa8","<form method=\"post\" action=".$BASEURL."/index.php?page=partners&action=editpartner&id=".$id .">");
   $partnerstpl->set("pa9","<table class=\"main\" cellspacing=\"0\" cellpadding=\"5\" width=\"750\">
            <tr><td valign=\"top\">Title:</td><td><input type=\"text\" name=\"title\" size=\"30\" value=".htmlspecialchars($arr["title"])."></td></tr>
            <tr><td valign=\"top\">Banner URL:</td><td><input type=\"text\" name=\"banner\" size=\"60\" value=".htmlspecialchars($arr["banner"])."><br/><font class=\"small\">Some sites disables hotlinking for images, so it is recommended to host it to a third party site.</font></td></tr>
            <tr><td valign=\"top\">Current Banner:</td><td><img src=".htmlspecialchars($arr["banner"]) ." width=480/></td></tr>
            <tr><td valign=\"top\">Link:</td><td><input type=\"text\" name=\"link\" size=\"40\" value=".htmlspecialchars($arr["link"])."></td></tr>
            <tr><td align=\"center\" colspan=\"2\"><input type=\"submit\" value=\"Update\"><INPUT TYPE=\"button\" VALUE=\"Back\" onclick=\"history.go(-1);return true;\"></td></tr>
          </table>");
   $partnerstpl->set("pa10","</form>");
}
if ($action == "addpartner" && $CURUSER["edit_torrents"]=="yes"){
    $userid = (int)$CURUSER["uid"];

    $title = $_POST["title"];
    $banner = $_POST["banner"];
    $link = $_POST["link"];

    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}partner (title, banner, link, addedby) VALUES(".sqlesc($title).", ".sqlesc($banner).", ".sqlesc($link).", ".sqlesC($userid).")") or sqlerr(__FILE__, __LINE__);
    header("Location: index.php?page=partners");
}

//action == deltepartner
if ($action == "deletepartner" && $CURUSER["edit_torrents"]=="yes") {

  $id = 0+$_GET["id"];

	if (!$id) { header("Location: index.php?page=partners"); die();}

	$result = do_sqlquery("SELECT * FROM {$TABLE_PREFIX}partner where id = '$id'");
	if ($row = mysqli_fetch_array($result)) {
		do {
			do_sqlquery("DELETE FROM {$TABLE_PREFIX}partner where id = '$id'") or sqlerr(__FILE__, __LINE__);
		} while($row = mysqli_fetch_array($result));
	}
	header("Location: index.php?page=partners");
	die();
}
?>