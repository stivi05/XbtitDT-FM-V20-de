<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT/DC FM.
//
// Apply for membership by DiemThuy - 06/2014
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
      
$applytpl=new bTemplate();
$applytpl->set("language",$language);

$applytpl->set("uploadrequest1","<form id=form1 name=form1 method=post action=index.php?page=applysend>");
$applytpl->set("uploadrequest2","<table width=700 border=0 align=center cellpadding=0 cellspacing=0>");
$applytpl->set("uploadrequest3","<tr>");
$applytpl->set("uploadrequest4","<td width=698><div align=center><strong><span class=style1>A T T E N T I O N !</span><br />");
$applytpl->set("uploadrequest5","If you want to be a member , fill in this form please (* needed fields)</strong></td>");
$applytpl->set("uploadrequest6","</tr>");
$applytpl->set("uploadrequest7","</table>");
$applytpl->set("uploadrequest8","<table width=600 border=1 align=center cellpadding=3 cellspacing=0>");

$applytpl->set("uploadrequest41","<tr>");
$applytpl->set("uploadrequest42","<td><span class=style8>* What country are you from ?</span></td>");
$applytpl->set("uploadrequest43","<td><strong>");
$applytpl->set("uploadrequest44","<label>");
$applytpl->set("uploadrequest45","<textarea name=intentioneaza cols=40 rows=1 id=intentioneaza></textarea>");
$applytpl->set("uploadrequest46","</label>");
$applytpl->set("uploadrequest47","</strong></td>");
$applytpl->set("uploadrequest48","</tr>");
$applytpl->set("uploadrequest49","<tr>");
$applytpl->set("uploadrequest50","<td><span class=style8>* Your Email adress ?</span></td>");
$applytpl->set("uploadrequest51","<td><strong>");
$applytpl->set("uploadrequest52","<textarea name=sursa cols=40 rows=1 id=sursa></textarea>");
$applytpl->set("uploadrequest53","</strong></td>");
$applytpl->set("uploadrequest54","</tr>");

$applytpl->set("uploadrequest49b","<tr>");
$applytpl->set("uploadrequest50b","<td><span class=style8>* Your desired username ?</span></td>");
$applytpl->set("uploadrequest51b","<td><strong>");
$applytpl->set("uploadrequest52b","<textarea name=sursas cols=40 rows=1 id=sursas></textarea>");
$applytpl->set("uploadrequest53b","</strong></td>");
$applytpl->set("uploadrequest54b","</tr>");

$applytpl->set("uploadrequest55","<tr>");
$applytpl->set("uploadrequest56","<td><span class=style8>* How did you hear about our site ?</span></td>");
$applytpl->set("uploadrequest57","<td><strong>");
$applytpl->set("uploadrequest58","<textarea name=altsite cols=40 rows=4 id=altsite></textarea>");
$applytpl->set("uploadrequest59","</strong></td>");
$applytpl->set("uploadrequest60","</tr>");

$applytpl->set("uploadrequest61","<tr>");
$applytpl->set("uploadrequest62","<td colspan = 2>If referred by a current member please include their username!<br>
This will not guarantee acces but may help.<br>
Simply stating a friend with an account will add NOTHING to your application!</td>");


$applytpl->set("uploadrequest63","</tr>");

$applytpl->set("uploadrequest98","<tr>");
$applytpl->set("uploadrequest99","<td><span class=style8>* Why do you want to join our site ?</span></td>");
$applytpl->set("uploadrequest100","<td><strong>");
$applytpl->set("uploadrequest101","<textarea name=motiv cols=40 rows=4 id=motiv></textarea>");
$applytpl->set("uploadrequest102","</strong></td>");
$applytpl->set("uploadrequest103","</tr>");
$applytpl->set("uploadrequest104","<tr>");
$applytpl->set("uploadrequest105","<td><span class=style8>* What do you have to offer our site ?</span></td>");
$applytpl->set("uploadrequest106","<td><strong>");
$applytpl->set("uploadrequest107","<textarea name=stisite cols=40 rows=4 id=stisite></textarea>");
$applytpl->set("uploadrequest108","</strong></td>");
$applytpl->set("uploadrequest109","</tr>");
$applytpl->set("uploadrequest110","<tr>");
$applytpl->set("uploadrequest111","<td><span class=style8>* Have you read our rules and do you agree ?</span></td>");
$applytpl->set("uploadrequest112","<td><strong>");
$applytpl->set("uploadrequest113","<select name=regulament id=regulament>");
$applytpl->set("uploadrequest114","<option value=Yes selected=selected>Yes</option>");
$applytpl->set("uploadrequest115","<option value=No>No</option>");
$applytpl->set("uploadrequest116","</select>");
$applytpl->set("uploadrequest117","</strong></td>");
$applytpl->set("uploadrequest118","</tr>");
$applytpl->set("uploadrequest119","<tr>");
$applytpl->set("uploadrequest120","<td><span class=style8>* Do you have a seedbox ?</span></td>");
$applytpl->set("uploadrequest121","<td><strong>");
$applytpl->set("uploadrequest122","<select name=oday id=oday>");
$applytpl->set("uploadrequest123","<option value=Yes selected=selected>Yes</option>");
$applytpl->set("uploadrequest124","<option value=No>No</option>");
$applytpl->set("uploadrequest125","</select>");
$applytpl->set("uploadrequest126","</strong></td>");
$applytpl->set("uploadrequest127","</tr>");

$applytpl->set("uploadrequest127b","<tr>");
$applytpl->set("uploadrequest128b","<td><span class=style8>Profile link 1</span></td>");
$applytpl->set("uploadrequest129b","<td><strong>");
$applytpl->set("uploadrequest130b","<textarea name=sursaa cols=40 rows=1 id=sursaa></textarea>");
$applytpl->set("uploadrequest131b","</strong></td>");
$applytpl->set("uploadrequest132b","</tr>");

$applytpl->set("uploadrequest127c","<tr>");
$applytpl->set("uploadrequest128c","<td><span class=style8>Profile link 2</span></td>");
$applytpl->set("uploadrequest129c","<td><strong>");
$applytpl->set("uploadrequest130c","<textarea name=sursad cols=40 rows=1 id=sursad></textarea>");
$applytpl->set("uploadrequest131c","</strong></td>");
$applytpl->set("uploadrequest132c","</tr>");

$applytpl->set("uploadrequest127d","<tr>");
$applytpl->set("uploadrequest128d","<td><span class=style8>Profile link 3</span></td>");
$applytpl->set("uploadrequest129d","<td><strong>");
$applytpl->set("uploadrequest130d","<textarea name=sursaf cols=40 rows=1 id=sursaf></textarea>");
$applytpl->set("uploadrequest131d","</strong></td>");
$applytpl->set("uploadrequest132d","</tr>");

$applytpl->set("uploadrequest128e","<tr><td colspan = 2>Provide up to 3 profile lnks ( no screenshots ) of your most used trackers</td>");
$applytpl->set("uploadrequest129e","</tr>");

$applytpl->set("uploadrequest219","<tr>");
$applytpl->set("uploadrequest220","<td><span class=style8>* How long do you seed your files average ?</span></td>");
$applytpl->set("uploadrequest221","<td><strong>");
$applytpl->set("uploadrequest222","<select name=seet id=seet>");
$applytpl->set("uploadrequest223","<option value=50>50%</option>");
$applytpl->set("uploadrequest223a","<option value=75>75%</option>");
$applytpl->set("uploadrequest224","<option value=100 selected=selected>100%</option>");
$applytpl->set("uploadrequest223b","<option value=150>150%</option>");
$applytpl->set("uploadrequest223c","<option value=200>200%</option>");
$applytpl->set("uploadrequest225","</select>");
$applytpl->set("uploadrequest226","</strong></td>");
$applytpl->set("uploadrequest227","</tr>");

//captcha
global $USE_IMAGECODE,$THIS_BASEPATH;

if ($USE_IMAGECODE && $action!="mod")
  {
   if (extension_loaded('gd'))
     {
       $arr = gd_info();
       if ($arr['FreeType Support']==1)
        {
         $p=new ocr_captcha();

         $applytpl->set("CAPTCHA",true,true);

         $applytpl->set("upload_captcha",$p->display_captcha(true));

         $private=$p->generate_private();
      }
     else
       {
         include("$THIS_BASEPATH/include/security_code.php");
         $scode_index = rand(0, count($security_code) - 1);
         $scode="<input type=\"hidden\" name=\"security_index\" value=\"$scode_index\" />\n";
         $scode.=$security_code[$scode_index]["question"];
         $applytpl->set("scode_question",$scode);
         $applytpl->set("CAPTCHA",false,true);
       }
     }
     else
       {
         include("$THIS_BASEPATH/include/security_code.php");
         $scode_index = rand(0, count($security_code) - 1);
         $scode="<input type=\"hidden\" name=\"security_index\" value=\"$scode_index\" />\n";
         $scode.=$security_code[$scode_index]["question"];
         $applytpl->set("scode_question",$scode);
         $applytpl->set("CAPTCHA",false,true);
       }
   }
elseif ($action!="mod")
   {
       include("$THIS_BASEPATH/include/security_code.php");
       $scode_index = rand(0, count($security_code) - 1);
       $scode="<input type=\"hidden\" name=\"security_index\" value=\"$scode_index\" />\n";
       $scode.=$security_code[$scode_index]["question"];
       $applytpl->set("scode_question",$scode);
       // we will request simple operation to user
       $applytpl->set("CAPTCHA",false,true);
  }
//captcha

$applytpl->set("uploadrequest200e","<tr><td colspan = 2>By clicking 'Apply' you understand that this information will determine your worthiness to join the site.<br>
Submission of an application does not guarantee you acces.<br>
You will receive an email upon approvel or denial of your application.<br>
The process can take up to a week </td>");
$applytpl->set("uploadrequest201e","</tr>");

$applytpl->set("uploadrequest128","</table>");
$applytpl->set("uploadrequest129","<p>");
$applytpl->set("uploadrequest130","<label>");
$applytpl->set("uploadrequest131","<div align=center>");
$applytpl->set("uploadrequest132","<input name=Submit type=submit id=Submit value=Submit />");
$applytpl->set("uploadrequest133","</div>");
$applytpl->set("uploadrequest134","</label>");
$applytpl->set("uploadrequest135","</p>");
$applytpl->set("uploadrequest136","</form>");
?>