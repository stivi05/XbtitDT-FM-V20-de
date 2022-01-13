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

global $btit_settings;
if (!defined("IN_BTIT"))
      die("non direct access!");

require_once(load_language("lang_account.php"));

if (!isset($_POST["language"])) $_POST["language"] = max(1,$btit_settings["default_language"]);
$idlang=intval($_POST["language"]);


if (isset($_GET["uid"])) $id=intval($_GET["uid"]);
 else $id="";
if (isset($_GET["returnto"])) $link=urldecode($_GET["returnto"]);
 else $link="";
if (isset($_GET["act"])) $act=$_GET["act"];
 else $act="signup";
if (isset($_GET["language"])) $idlangue=intval($_GET["language"]);
 else $idlangue=max(1,$btit_settings["default_language"]);
if (isset($_GET["style"])) $idstyle=intval($_GET["style"]);
 else $idstyle=max(1,$btit_settings["default_style"]);
if (isset($_GET["flag"])) $idflag=intval($_GET["flag"]);
 else $idflag="";

if (isset($_POST["uid"]) && isset($_POST["act"]))
  {
if (isset($_POST["uid"])) $id=intval($_POST["uid"]);
 else $id="";
if (isset($_POST["returnto"])) $link=urldecode($_POST["returnto"]);
 else $link="";
if (isset($_POST["act"])) $act=$_POST["act"];
 else $act="";
  }

// DT referral system
if  ($btit_settings["ref_on"] == true)
{
if (isset ($_GET["rid"]))
   $rid = $_GET["rid"];
else $rid="";
}
// DT referral system

//start Invitation System by dodge
if(!$_POST["conferma"] && $INVITATIONSON)
{
    if ($act == "invite")
    {

        $code = mysqli_real_escape_string($DBDT,$_GET["invitationnumber"]);
        $res = do_sqlquery("SELECT inviter, confirmed FROM {$TABLE_PREFIX}invitations WHERE hash = '" .
            $code . "'", true);
        @$inv = mysqli_fetch_assoc($res);
        $inviter = $inv["inviter"];
        $confirmed = $inv["confirmed"];
        if (!$inv || $confirmed == "true")
            stderr($language["ERROR"], $code . "<br>" . $language["INVALID_INVITATION"] .
                "<br>" . $language["ERR_INVITATION"]);
    }
    else
        stderr($language["ERROR"], $language["INVITATION_ONLY"]);
}   
//end Invitation System

// already logged?
if ($act=="signup" && isset($CURUSER["uid"]) && $CURUSER["uid"]!=1) {
        $url="index.php";
        redirect($url);
}


$nusers=get_result("SELECT count(*) as tu FROM {$TABLE_PREFIX}users WHERE id>1",true,$btit_settings['cache_duration']);
$numusers=$nusers[0]['tu'];

if ($act=="signup" && $MAX_USERS!=0 && $numusers>=$MAX_USERS && !$INVITATIONSON)
   {
   stderr($language["ERROR"],$language["REACHED_MAX_USERS"]);
}
global $btit_settings;
if ($act=="signup" && $btit_settings["regi"]==false)
   {
   stderr('Sorry','<b>Registration is closed on this moment !!<br> Registration will be open again from :<br><br><font color =red> -- date '.$btit_settings["regi_d"].' time '.$btit_settings["regi_t"].' hour --</font></b>');
}


if ($act=="confirm") {

      global $FORUMLINK, $db_prefix, $THIS_BASEPATH, $btit_settings;

      $random=intval($_GET["confirm"]);
      $random2=rand(10000, 60000);
      $res=do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `id_level`=3".((substr($FORUMLINK,0,3)=="smf" || $FORUMLINK=="ipb") ? ", `random`=$random2" : "")." WHERE `id_level`=2 AND `random`=$random",true);
      if (!$res)
         die("ERROR: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . "\n");
      else {
          if(substr($FORUMLINK,0,3)=="smf")
          {
              $get=get_result("SELECT `u`.`smf_fid`, `ul`.`smf_group_mirror` FROM `{$TABLE_PREFIX}users` `u` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul` ON `u`.`id_level`=`ul`.`id` WHERE `u`.`id_level`=3 AND `u`.`random`=$random2",true,$btit_settings['cache_duration']);
              do_sqlquery("UPDATE `{$db_prefix}members` SET ".(($FORUMLINK=="smf")?"`ID_GROUP`":"`id_group`")."=".(($get[0]["smf_group_mirror"]>0)?$get[0]["smf_group_mirror"]:13)." WHERE ".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")."=".$get[0]["smf_fid"],true);
          }
          elseif($FORUMLINK=="ipb")
          {
                    if(!defined('IPS_ENFORCE_ACCESS'))
                        define('IPS_ENFORCE_ACCESS', true);
                    if(!defined('IPB_THIS_SCRIPT'))
                        define('IPB_THIS_SCRIPT', 'public');

                    if(!isset($THIS_BASEPATH) || empty($THIS_BASEPATH))
                        $THIS_BASEPATH=dirname(__FILE__);
                    require_once($THIS_BASEPATH. '/ipb/initdata.php' );
                    require_once( IPS_ROOT_PATH . 'sources/base/ipsRegistry.php' );
                    require_once( IPS_ROOT_PATH . 'sources/base/ipsController.php' );
                    $registry = ipsRegistry::instance(); 
                    $registry->init();

              $get=get_result("SELECT `u`.`ipb_fid`, `ul`.`ipb_group_mirror` FROM `{$TABLE_PREFIX}users` `u` LEFT JOIN `{$TABLE_PREFIX}users_level` `ul` ON `u`.`id_level`=`ul`.`id` WHERE `u`.`id_level`=3 AND `u`.`random`=$random2",true,$btit_settings['cache_duration']);
              $forum_level=(($get[0]["ipb_group_mirror"]>0)?$get[0]["ipb_group_mirror"]:3);
              IPSMember::save($get[0]["ipb_fid"], array("members" => array("member_group_id" => "$forum_level")));  
          }
          success_msg($language["ACCOUNT_CREATED"],$language["ACCOUNT_CONGRATULATIONS"]);
          stdfoot();
          exit;
          }
}

if ($_POST["conferma"]) {
    if ($act=="signup" || $act == "invite") {
       $ret=aggiungiutente();
       $pass_min_req=explode(",", $btit_settings["secsui_pass_min_req"]);
       if ($ret==0)
          {
            if ($INVITATIONSON == "true")
            {
                if ($VALID_INV == "true")
                {
                    success_msg($language["ACCOUNT_CREATED"], $language["INVITE_EMAIL_SENT1"] . " (" .
                        htmlspecialchars($email) . "). " . $language["INVITE_EMAIL_SENT2"]);
                    stdfoot();
                    exit();
                }
                else
                {
                    success_msg($language["ACCOUNT_CREATED"], $language["INVITE_EMAIL_SENT3"] . " (" .
                        htmlspecialchars($email) . "). " . $language["INVITE_EMAIL_SENT4"]);
                    stdfoot();
                    exit();
                }
            }
            else
        
          if ($VALIDATION=="user")
             {
               success_msg($language["ACCOUNT_CREATED"],$language["EMAIL_SENT"]);
               stdfoot();
               exit();
             }
          else if ($VALIDATION=="none")
               {
               success_msg($language["ACCOUNT_CREATED"],$language["ACCOUNT_CONGRATULATIONS"]);
               stdfoot();
               exit();
               }
          else
              {
               success_msg($language["ACCOUNT_CREATED"],$language["WAIT_ADMIN_VALID"]);
               stdfoot();
               exit();
              }
          }
       elseif ($ret==-1)
         stderr($language["ERROR"],$language["ERR_MISSING_DATA"]);
       elseif ($ret==-2)
         stderr($language["ERROR"],$language["ERR_EMAIL_ALREADY_EXISTS"]);
       elseif ($ret==-3)
         stderr($language["ERROR"],$language["ERR_NO_EMAIL"]);
       elseif ($ret==-4)
        stderr($language["ERROR"],$language["ERR_USER_ALREADY_EXISTS"]);
       elseif ($ret==-7)
          stderr($language["ERROR"],$language["ERR_NO_SPACE"]." <span style=\"color:red;font-weight:bold;\">".preg_replace('/\ /', '_', mysqli_real_escape_string($DBDT,$_POST["user"]))."</span><br /> ");
       elseif ($ret==-8)
         stderr($language["ERROR"],$language["ERR_SPECIAL_CHAR"]);
       elseif ($ret==-9)
         stderr($language["ERROR"],$language["ERR_PASS_LENGTH_1"]." <span style=\"color:blue;font-weight:bold;\">".$pass_min_req[0]."</span> ".$language["ERR_PASS_LENGTH_2"]);
       elseif ($ret==-999)
         stderr($language["ERROR"],$language["DOMAIN_BANNED"]);
elseif ($ret==-99)
         stderr($language["ERROR"],$language["ERR_REG_IP_BANNED"]);
      
       elseif ($ret==-998) 
       { 
           $newpassword=pass_the_salt(30); 
	       stderr($language["ERROR"],$language["ERR_PASS_TOO_WEAK_1"].":<br /><br />".(($pass_min_req[1]>0)?"<li><span style='color:blue;font-weight:bold;'>".$pass_min_req[1]."</span> ".(($pass_min_req[1]==1)?$language["ERR_PASS_TOO_WEAK_2"]:$language["ERR_PASS_TOO_WEAK_2A"])."</li>":"").(($pass_min_req[2]>0)?"<li><span style='color:blue;font-weight:bold;'>".$pass_min_req[2]."</span> ".(($pass_min_req[2]==1)?$language["ERR_PASS_TOO_WEAK_3"]:$language["ERR_PASS_TOO_WEAK_3A"])."</li>":"").(($pass_min_req[3]>0)?"<li><span style='color:blue;font-weight:bold;'>".$pass_min_req[3]."</span> ".(($pass_min_req[3]==1)?$language["ERR_PASS_TOO_WEAK_4"]:$language["ERR_PASS_TOO_WEAK_4A"])."</li>":"").(($pass_min_req[4]>0)?"<li><span style='color:blue;font-weight:bold;'>".$pass_min_req[4]."</span> ".(($pass_min_req[4]==1)?$language["ERR_PASS_TOO_WEAK_5"]:$language["ERR_PASS_TOO_WEAK_5A"])."</li>":"")."<br />".$language["ERR_PASS_TOO_WEAK_6"].":<br /><br /><span style='color:blue;font-weight:bold;'>".$newpassword."</span><br />"); 
       } 
       else
        stderr($language["ERROR"],$language["ERR_USER_ALREADY_EXISTS"]);
       }
}
else {
    $tpl_account=new bTemplate();
    tabella($act);
}

function tabella($action,$dati=array()) {

   global $DBDT,$SITENAME, $INVITATIONSON, $code, $rid, $inviter, $idflag,$link, $idlangue, $idstyle, $CURUSER,$USE_IMAGECODE, $TABLE_PREFIX, $language, $tpl_account,$THIS_BASEPATH, $btit_settings;
   
    $password_length = 12;
    $generate_password = crypt(uniqid(mt_rand(),1));
    $generate_password = strip_tags(stripslashes($generate_password));
    $generate_password = str_replace(".","",$generate_password);
    $generate_password = strrev(str_replace("/","",$generate_password));
    $generate_password = substr($generate_password,0,$password_length);

   $pass_min_req=explode(",", $btit_settings["secsui_pass_min_req"]); 
   $tpl_account->set("pass_min_char",$pass_min_req[0]); 
   $tpl_account->set("pass_min_lct",$pass_min_req[1]); 
   $tpl_account->set("pass_min_uct",$pass_min_req[2]); 
   $tpl_account->set("pass_min_num",$pass_min_req[3]); 
   $tpl_account->set("pass_min_sym",$pass_min_req[4]); 
   $tpl_account->set("pass_char_plural", (($pass_min_req[0]==1)?false:true),true); 
   $tpl_account->set("pass_lct_plural", (($pass_min_req[1]==1)?false:true),true); 
   $tpl_account->set("pass_uct_plural", (($pass_min_req[2]==1)?false:true),true); 
   $tpl_account->set("pass_num_plural", (($pass_min_req[3]==1)?false:true),true); 
   $tpl_account->set("pass_sym_plural", (($pass_min_req[4]==1)?false:true),true); 
   $tpl_account->set("pass_lct_set", (($pass_min_req[1]>0)?true:false),true); 
   $tpl_account->set("pass_uct_set", (($pass_min_req[2]>0)?true:false),true); 
   $tpl_account->set("pass_num_set", (($pass_min_req[3]>0)?true:false),true); 
   $tpl_account->set("pass_sym_set", (($pass_min_req[4]>0)?true:false),true); 

   if ($action=="signup" || $action == "invite")
     {
          $tpl_account->set("BY_INVITATION", false, true);
          $dati["username"]="";
          $dati["email"]="";
          $dati["language"]=$idlangue;
          $dati["style"]=$idstyle;
     }

$uid=$CURUSER["uid"]; 
	 		 $r=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from {$TABLE_PREFIX}users WHERE id = $uid"); 
		 $x=mysqli_result($r,0,"gender"); 
		
		 
   		  $gender= "<input name=\"gen\" type=\"radio\" value=\"0\" checked=\"checked\" />
			  ".$language["MALE"]."  </label>
			  <input name=\"gen\" type=\"radio\" value=\"1\" />
			".$language["FEMALE"]." ";
			
			$tpl_account->set("account_gender",$gender);
   // avoid error with js
   $language["DIF_PASSWORDS"]=AddSlashes($language["DIF_PASSWORDS"]);
   $language["INSERT_PASSWORD"]=AddSlashes($language["INSERT_PASSWORD"]);
   $language["USER_PWD_AGAIN"]=AddSlashes($language["USER_PWD_AGAIN"]);
   $language["INSERT_USERNAME"]=AddSlashes($language["INSERT_USERNAME"]);
   $language["ERR_NO_EMAIL"]=AddSlashes($language["ERR_NO_EMAIL"]);
   $language["ERR_NO_EMAIL_AGAIN"]=AddSlashes($language["ERR_NO_EMAIL_AGAIN"]);
   $language["DIF_EMAIL"]=AddSlashes($language["DIF_EMAIL"]);
   $language["PASSWORD_GENERATE"]=AddSlashes($language["PASSWORD_GENERATE"]); 
   $language["PASSWORD_GENERATE_INFO"]=AddSlashes($language["PASSWORD_GENERATE_INFO"]);

   $tpl_account->set("language",$language);
   $tpl_account->set("account_action",$action);
   $tpl_account->set("account_form_actionlink",htmlspecialchars("index.php?page=signup&act=$action&returnto=$link"));
   $tpl_account->set("account_uid",$dati["id"]);
   $tpl_account->set("account_returnto",urlencode($link));
   if($btit_settings["hide_language-visible"]!="visible")
       $tpl_account->set("account_IDlanguage",$idlang);
   if($btit_settings["hide_style_visible"]!="visible")
       $tpl_account->set("account_IDstyle",$idstyle);
   $tpl_account->set("account_IDcountry",$idflag);
   $tpl_account->set("account_username",$dati["username"]);
   $tpl_account->set("password_generate",$generate_password);
   $tpl_account->set("dati",$dati);
   $tpl_account->set("DEL",$action=="delete",true);
   $tpl_account->set("DISPLAY_FULL", $action == "signup" || $action == "invite",true);
   $tpl_account->set("hide_language_visible_1", (($btit_settings["hide_language"]=="hidden")?false:true), true);
   $tpl_account->set("hide_language_visible_2", (($btit_settings["hide_language"]=="hidden")?false:true), true);
   $tpl_account->set("hide_style_visible_1", (($btit_settings["hide_style"]=="hidden")?false:true), true);
   $tpl_account->set("hide_style_visible_2", (($btit_settings["hide_style"]=="hidden")?false:true), true);

// DT referral
   $tpl_account->set("refer", (($btit_settings["ref_on"]==false )?false:true), true);
if  ($btit_settings["ref_on"] == true)
{

    if (!$rid=="")
    {
    $tpl_account->set("refa", $rid);
    $rdt = do_sqlquery("SELECT username FROM {$TABLE_PREFIX}users WHERE id = '" .
    $rid. "'", true);
    @$idt = mysqli_fetch_assoc($rdt);
    $tpl_account->set("refb", $idt["username"]);
    }
else
    $tpl_account->set("refb", "Nobody");
}
// DT referral end
   
    //begin invitation system by dodge
    if ($INVITATIONSON)
    {
        $tpl_account->set("BY_INVITATION", true, true);
        $tpl_account->set("account_IDcode", $code);
        $tpl_account->set("account_IDinviter", $inviter);
    }
    //end invitation system
    if ($action=="del")
      $tpl_account->set("account_from_delete_confirm","<input type=\"submit\" name=\"elimina\" value=\"".$language["FRM_DELETE"]."\" />&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"elimina\" value=\"".$language["FRM_CANCEL"]."\" />");
   else
      $tpl_account->set("account_from_delete_confirm","<input type=\"submit\" name=\"conferma\" value=\"".$language["FRM_CONFIRM"]."\" />&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"reset\" name=\"annulla\" value=\"".$language["FRM_CANCEL"]."\" />");
   
   if($btit_settings["hide_language_visible"]!="visible")
   {  
       $lres=language_list();

       $option="\n<select name=\"language\" size=\"1\">";
       foreach($lres as $langue)
       {
           $option.="\n<option ";
           if ($langue["id"]==$dati["language"])
               $option.="selected=\"selected\"  ";
           $option.="value=\"".$langue["id"]."\">".$langue["language"]."</option>";
       }
       $option.="\n</select>";
       $tpl_account->set("account_combo_language",$option);
   }
   if($btit_settings["hide_style_visible"]!="visible")
   {
       $sres=style_list();
       $option="\n<select name=\"style\" size=\"1\">";
       foreach($sres as $style)
       {
           $option.="\n<option ";
           if ($style["id"]==$dati["style"])
               $option.="selected=\"selected\"  ";
           $option.="value=\"".$style["id"]."\">".$style["style"]."</option>";
       }
       $option.="\n</select>";
       $tpl_account->set("account_combo_style",$option);
   }

   $fres=flag_list();
   $option="\n<select name=\"flag\" size=\"1\">\n<option value='0'>---</option>";

   $thisip = $_SERVER["REMOTE_ADDR"];
   $remotedns = gethostbyaddr($thisip);

   if ($remotedns != $thisip)
       {
       $remotedns = strtoupper($remotedns);
       preg_match('/^(.+)\.([A-Z]{2,3})$/', $remotedns, $tldm);
       if (isset($tldm[2]))
              $remotedns = mysqli_real_escape_string($DBDT,$tldm[2]);
     }

   foreach($fres as $flag)
    {
        $option.="\n<option ";
            if ($flag["id"]==$dati["flag"] || ($flag["domain"]==$remotedns && $action=="signup"))
              $option.="selected=\"selected\"  ";
            $option.="value=\"".$flag["id"]."\">".$flag["name"]."</option>";
    }
   $option.="\n</select>";

   $tpl_account->set("account_combo_country",$option);

   $zone=date('Z',time());
   $daylight=date('I',time())*3600;
   $os=$zone-$daylight;
   if($os!=0){ $timeoff=$os/3600; } else { $timeoff=0; }

   if(!$CURUSER || $CURUSER["uid"]==1)
      $dati["time_offset"]=$timeoff;

   $tres=timezone_list();
   $option="<select name=\"timezone\">";
   foreach($tres as $timezone)
     {
       $option.="\n<option ";
       if ($timezone["difference"]==$dati["time_offset"])
          $option.="selected=\"selected\" ";
       $option.="value=\"".$timezone["difference"]."\">".unesc($timezone["timezone"])."</option>";
     }
   $option.="\n</select>";

   $tpl_account->set("account_combo_timezone",$option);

// -----------------------------
// Captcha hack
// -----------------------------
// if set to use secure code: try to display imagecode
if($btit_settings["gcsw"]==false)
{
$tpl_account->set("GCAPTCHA",false,true);
$tpl_account->set("XCAPTCHA",true,true);

if ($USE_IMAGECODE && $action!="mod")
  {
   if (extension_loaded('gd'))
     {
       $arr = gd_info();
       if ($arr['FreeType Support']==1)
        {
         $p=new ocr_captcha();

         $tpl_account->set("CAPTCHA",true,true);

         $tpl_account->set("account_captcha",$p->display_captcha(true));

         $private=$p->generate_private();
      }
     else
       {
         include("$THIS_BASEPATH/include/security_code.php");
         $scode_index = rand(0, count($security_code) - 1);
         $scode="<input type=\"hidden\" name=\"security_index\" value=\"$scode_index\" />\n";
         $scode.=$security_code[$scode_index]["question"];
         $tpl_account->set("scode_question",$scode);
         $tpl_account->set("CAPTCHA",false,true);
       }
     }
     else
       {
         include("$THIS_BASEPATH/include/security_code.php");
         $scode_index = rand(0, count($security_code) - 1);
         $scode="<input type=\"hidden\" name=\"security_index\" value=\"$scode_index\" />\n";
         $scode.=$security_code[$scode_index]["question"];
         $tpl_account->set("scode_question",$scode);
         $tpl_account->set("CAPTCHA",false,true);
       }
   }
elseif ($action!="mod")
   {
       include("$THIS_BASEPATH/include/security_code.php");
       $scode_index = rand(0, count($security_code) - 1);
       $scode="<input type=\"hidden\" name=\"security_index\" value=\"$scode_index\" />\n";
       $scode.=$security_code[$scode_index]["question"];
       $tpl_account->set("scode_question",$scode);
       // we will request simple operation to user
       $tpl_account->set("CAPTCHA",false,true);
  }
}
else
{
$tpl_account->set("GCAPTCHA",true,true);
$tpl_account->set("XCAPTCHA",false,true);
$tpl_account->set("sike",$btit_settings["gcsitk"]);
}
// -----------------------------
// Captcha hack
// -----------------------------
}

function aggiungiutente() {

global $DBDT,$INVITATIONSON, $VALID_INV, $SITENAME,$SITEEMAIL,$BASEURL,$VALIDATION,$USERLANG,$USE_IMAGECODE, $TABLE_PREFIX, $XBTT_USE, $language,$THIS_BASEPATH, $FORUMLINK, $db_prefix, $btit_settings;

$dobdate=$_POST["datepicker"];
$parts = explode('-', $dobdate);

$dobday=$parts[0];
$dobmonth=$parts[1];
$dobyear=$parts[2];

$utente=mysqli_real_escape_string($DBDT,$_POST["user"]);
$pwd=mysqli_real_escape_string($DBDT,$_POST["pwd"]);
$pwd1=mysqli_real_escape_string($DBDT,$_POST["pwd1"]);
$email=mysqli_real_escape_string($DBDT,$_POST["email"]);
if (isset($_POST["language"]))
    $idlangue=intval($_POST["language"]);
else
    $idlangue=max(1,$btit_settings["default_language"]);

if (isset($_POST["style"]))
    $idstyle=intval($_POST["style"]);
else
    $idstyle=max(1,$btit_settings["default_style"]);
$idflag=intval($_POST["flag"]);
$timezone=intval($_POST["timezone"]);
$heard=mysqli_real_escape_string($DBDT,$_POST["heardaboutus"]);
// Dt Referral
if  ($btit_settings["ref_on"] == true)
$rid=intval($_POST["refa"]);
// Dt Referral
if (strtoupper($utente) == strtoupper("Guest")) {
        err_msg($language["ERROR"],$language["ERR_GUEST_EXISTS"]);
        stdfoot();
        exit;
        }

if ($pwd != $pwd1) {
    err_msg($language["ERROR"],$language["DIF_PASSWORDS"]);
    stdfoot();
    exit;
    }

if ($VALIDATION=="none")
   $idlevel=3;
else
   $idlevel=2;
    //begin invitation system by dodge
    if ($INVITATIONSON == "true")
    {
        if ($VALID_INV == "true")
            $idlevel = 2;
        else
            $idlevel = 3;
    }
    //end invitation system
    # Create Random number
$floor = 100000;
$ceiling = 999999;
srand((double)microtime()*1000000);
$random = rand($floor, $ceiling);

if ($utente=="" || $pwd=="" || $email=="") {
   return -1;
   exit;
}

$res=do_sqlquery("SELECT email FROM {$TABLE_PREFIX}users WHERE email='$email'",true);
if (mysqli_num_rows($res)>0)
   {
   return -2;
   exit;
}

// valid email check - by vibes
$regex='/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/i';
if(!preg_match($regex,$email))
   {
   return -3;
   exit;
}
// valid email check end

//Function changed by fatepower so now the variable checks the right data.
//Added the image also. Cheers boys
// check if IP is already in use
if ($btit_settings["dupip"]=="true")
{
$ip=getip();
$i = (@mysqli_fetch_row(@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT count(*) FROM {$TABLE_PREFIX}users WHERE cip='$ip'"))) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
if ($i[0] != 0)
{
err_msg(ERROR,"[".$ip."]<br /><img src=\"images/shared_ip.gif\" border=\"0\" alt=\"\" />");
block_end();
stdfoot();
exit;
}

}

// duplicate username
$res=do_sqlquery("SELECT username FROM {$TABLE_PREFIX}users WHERE username='$utente'",true);
if (mysqli_num_rows($res)>0)
   {
   return -4;
   exit;
}
// duplicate username

if (strpos(mysqli_real_escape_string($DBDT,$utente), " ")==true)
   {
   return -7;
   exit;
}

if($btit_settings["gcsw"]==false)
{
if ($USE_IMAGECODE)
{
  if (extension_loaded('gd'))
    {
     $arr = gd_info();
     if ($arr['FreeType Support']==1)
      {
        $public=$_POST['public_key'];
        $private=$_POST['private_key'];

          $p=new ocr_captcha();

          if ($p->check_captcha($public,$private) != true)
              {
              err_msg($language["ERROR"],$language["ERR_IMAGE_CODE"]);
              stdfoot();
              exit;
          }
       }
       else
         {
           include("$THIS_BASEPATH/include/security_code.php");
           $scode_index=intval($_POST["security_index"]);
           if ($security_code[$scode_index]["answer"]!=$_POST["scode_answer"])
              {
              err_msg($language["ERROR"],$language["ERR_IMAGE_CODE"]);
              stdfoot();
              exit;
            }
         }
    }
     else
       {
         include("$THIS_BASEPATH/include/security_code.php");
         $scode_index=intval($_POST["security_index"]);
         if ($security_code[$scode_index]["answer"]!=$_POST["scode_answer"])
            {
            err_msg($language["ERROR"],$language["ERR_IMAGE_CODE"]);
            stdfoot();
            exit;
          }
       }
}
else
  {
    include("$THIS_BASEPATH/include/security_code.php");
    $scode_index=intval($_POST["security_index"]);
    if ($security_code[$scode_index]["answer"]!=$_POST["scode_answer"])
       {
       err_msg($language["ERROR"],$language["ERR_IMAGE_CODE"]);
       stdfoot();
       exit;
     }
  }
}
else
{
require_once "include/recaptchalib.php";
// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = "en";
// The response from reCAPTCHA
$resp = null;
// The error code from reCAPTCHA, if any
$error = null;
$reCaptcha = new ReCaptcha($btit_settings["gcsekk"]);
if ($_POST["g-recaptcha-response"]) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
} else {
       err_msg($language["ERROR"],"Recaptcha Not submitted");
       stdfoot();
       exit;
}
if ($resp != null && $resp->success) {} 
else {
       err_msg($language["ERROR"],"Google reports , you are a Robot !");
       stdfoot();
       exit;
}
}


$bannedchar=array("\\", "/", ":", "*", "?", "\"", "@", "$", "'", "`", ",", ";", ".", "<", ">", "!", "£", "%", "^", "&", "(", ")", "+", "=", "#", "~");
if (straipos(mysqli_real_escape_string($DBDT,$utente), $bannedchar)==true)
   {
   return -8;
   exit;
}

$pass_to_test=$_POST["pwd"];
$pass_min_req=explode(",", $btit_settings["secsui_pass_min_req"]);

if(strlen($pass_to_test)<$pass_min_req[0])
{
    return -9;
    exit;
}

$exploded=explode("@", $email);
$exploded2=explode(".", $exploded[1]);
$cheapmail=mysqli_real_escape_string($DBDT,$exploded[1]);
$cheapmail2=mysqli_real_escape_string($DBDT,"@".$exploded2[0].".");
$mailischeap=do_sqlquery("SELECT `domain` FROM `{$TABLE_PREFIX}cheapmail` WHERE `domain`='".$cheapmail."' OR `domain`='".$cheapmail2."'",true);

if (@mysqli_num_rows($mailischeap)>0)
    return -999;

$userip=getip();
$signupipblock=@mysqli_fetch_assoc(@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `id` FROM `{$TABLE_PREFIX}signup_ip_block` WHERE `first_ip` <=INET_ATON('$userip') AND `last_ip` >=INET_ATON('$userip')"));

if($signupipblock)
{
    return -99;
    exit();
}
      

$lct_count=0;
$uct_count=0;
$num_count=0;
$sym_count=0;
$pass_end=(int)(strlen($pass_to_test)-1);
$pass_position=0;
$pattern1='#[a-z]#';
$pattern2='#[A-Z]#';
$pattern3='#[0-9]#';
$pattern4='/[¬!"£$%^&*()`{}\[\]:@~;\'#<>?,.\/\\-=_+\|]/';

for($pass_position=0;$pass_position<=$pass_end;$pass_position++)
{
    if(preg_match($pattern1,substr($pass_to_test,$pass_position,1),$matches))
      $lct_count++;
    elseif(preg_match($pattern2,substr($pass_to_test,$pass_position,1),$matches))
      $uct_count++;
    elseif(preg_match($pattern3,substr($pass_to_test,$pass_position,1),$matches))
      $num_count++;
    elseif(preg_match($pattern4,substr($pass_to_test,$pass_position,1),$matches))
      $sym_count++;
}
if($lct_count<$pass_min_req[1] || $uct_count<$pass_min_req[2] || $num_count<$pass_min_req[3] || $sym_count<$pass_min_req[4])
{
    return -998;
    exit;
}

$multipass=hash_generate(array("salt" => ""), $_POST["pwd"], $_POST["user"]);
$i=$btit_settings["secsui_pass_type"];



            $sql = "SELECT value FROM {$TABLE_PREFIX}settings WHERE `key` = \"donate_upload\"";
            $req = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
            $result = mysqli_fetch_array($req);
            $credit = $result['value'];
            $sql = "SELECT value FROM {$TABLE_PREFIX}settings WHERE `key` = \"unit\"";
            $req = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
            $result = mysqli_fetch_array($req);
            $unit = $result['value'];
            ((mysqli_free_result($req) || (is_object($req) && (get_class($req) == "mysqli_result"))) ? true : false);
            $kb = 1024;
            $mb = 1024*1024;
            $gb = 1024*1024*1024;
            $tb = 1024*1024*1024*1024;
            if ($unit == 'Kb') $uploaded = $credit*$kb;
            elseif ($unit == 'Mb') $uploaded = $credit*$mb;
            elseif ($unit == 'Gb') $uploaded = $credit*$gb;
            elseif ($unit == 'Tb') $uploaded = $credit*$tb;
            
$realdate=checkdate($dobmonth,$dobday,$dobyear);

if($realdate)
{
    $dob=$dobyear."-".$dobmonth."-".$dobday;

    $age=userage($dobyear, $dobmonth, $dobday);
    $dobtime=mktime(0,0,0,$dobmonth,$dobday,$dobyear);

    if($dobtime>time())
    {
        err_msg($language["ERROR"], $language["ERR_BORN_IN_FUTURE"]);
        stdfoot();
        exit();                
    }
    elseif($age<$btit_settings["birthday_lower_limit"])
    {
        err_msg($language["ERROR"], $language["ERR_DOB_1"] . $age . $language["ERR_DOB_2"]);
        stdfoot();
        exit();
    }
    elseif($age>$btit_settings["birthday_upper_limit"])
    {
        err_msg($language["ERROR"], $language["ERR_DOB_1"] . $age . $language["ERR_DOB_2"]);
        stdfoot();
        exit();
    }
}
else
{
    err_msg($language["ERROR"], $language["INVALID_DOB_1"].$dobday."/".$dobmonth."/".$dobyear.$language["INVALID_DOB_2"]);
    stdfoot();
    exit();
}
$mtpp=$btit_settings["max_torrents_per_page"];
$pid=md5(uniqid(rand(),true));
$gen=intval($_POST['gen']);
do_sqlquery("INSERT INTO `{$TABLE_PREFIX}users` (`username`, `password`, `dob` ,`salt`, `pass_type`, `dupe_hash`, `random`, `id_level`, `email`, `style`, `language`, `flag`, `joined`, `lastconnect`, `pid`, `time_offset`, `whereheard`,`gender` , `torrentsperpage`) VALUES ('".$utente."', '".mysqli_real_escape_string($DBDT,$multipass[$i]["rehash"])."', '".$dob."' , '".mysqli_real_escape_string($DBDT,$multipass[$i]["salt"])."', '".$i."', '".mysqli_real_escape_string($DBDT,$multipass[$i]["dupehash"])."', ".$random.", ".$idlevel.", '".$email."', ".$idstyle.", ".$idlangue.", ".$idflag.", NOW(), NOW(),'".$pid."', '".$timezone."','".$heard."','".$gen."','".$mtpp."')",true);

$newuid=((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
// DT reputation system start
$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}reputation_settings WHERE id =1");
$setrep=mysqli_fetch_array($reput);

$plus= $setrep["rep_default"];

if ($setrep["rep_is_online"]== 'false')
{
//do nothing
}
else
{
@mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}users SET reputation = reputation + '$plus' WHERE id='$newuid'");
}
// DT reputation system end
        
//begin invitation system by dodge
if ($INVITATIONSON == "true")
{
    $inviter = 0 + $_POST["inviter"];
    $code = unesc($_POST["code"]);
    $res = do_sqlquery("SELECT username FROM {$TABLE_PREFIX}users WHERE id = $inviter", true);
    $arr = mysqli_fetch_assoc($res);
    $invusername = $arr["username"];
    do_sqlquery("UPDATE {$TABLE_PREFIX}users SET invited_by='" . $inviter .
        "' WHERE id='" . $newuid . "'", true);
    do_sqlquery("UPDATE {$TABLE_PREFIX}invitations SET confirmed='true' WHERE hash='$code'", true);
    $msg = sqlesc($language["WELCOME MESSAGE"]);
}
//end invitation system
    
//DT referral system start 
if  ($btit_settings["ref_on"] == true)
{
$rup = ($btit_settings["ref_gb"]*1024*1024*1024);
$rap = $btit_settings["ref_sb"];

do_sqlquery("UPDATE {$TABLE_PREFIX}users SET referral=$rid where id=$newuid",true);
if  ($btit_settings["ref_switch"] == true)
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET uploaded=uploaded + '$rup' where id='$rid'");
else
do_sqlquery("UPDATE {$TABLE_PREFIX}users SET seedbonus=seedbonus + '$rap' where id='$rid'");
}
//DT referral system end

do_sqlquery("UPDATE {$TABLE_PREFIX}users SET uploaded=$uploaded WHERE id=$newuid",true);

// begin - announce new confirmed user in shoutbox
if  ($btit_settings["sbtwo"] == true)
{
      $al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
      $rw=mysqli_fetch_assoc($al);
      $ct =  ($rw["count"]+1);
      do_sqlquery("INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text,count) VALUES (0,".time().", 'System','[color=green]Welcome New User :[/color][url=$BASEURL/index.php?page=userdetails&id=$newuid]".$utente."[/url]',".$ct.")");
}
// end - announce new confirmed user in shoutbox

// Continue to create smf members if they disable smf mode
$test=do_sqlquery("SHOW TABLES LIKE '{$db_prefix}members'",true);

if (substr($FORUMLINK,0,3)=="smf" || mysqli_num_rows($test))
{
    $smfpass=smf_passgen($utente, $pwd);
    $fetch=get_result("SELECT `smf_group_mirror` FROM `{$TABLE_PREFIX}users_level` WHERE `id`=".$idlevel, true, $btit_settings["cache_duration"]);
    $flevel=(($fetch[0]["smf_group_mirror"]>0)?$fetch[0]["smf_group_mirror"]:$idlevel+10);

    if($FORUMLINK=="smf")
        do_sqlquery("INSERT INTO `{$db_prefix}members` (`memberName`, `dateRegistered`, `ID_GROUP`, `realName`, `passwd`, `emailAddress`, `memberIP`, `memberIP2`, `is_activated`, `passwordSalt`) VALUES ('$utente', UNIX_TIMESTAMP(), $flevel, '$utente', '$smfpass[0]', '$email', '".getip()."', '".getip()."', 1, '$smfpass[1]')",true);
    else
        do_sqlquery("INSERT INTO `{$db_prefix}members` (`member_name`, `date_registered`, `id_group`, `real_name`, `passwd`, `email_address`, `member_ip`, `member_ip2`, `is_activated`, `password_salt`) VALUES ('$utente', UNIX_TIMESTAMP(), $flevel, '$utente', '$smfpass[0]', '$email', '".getip()."', '".getip()."', 1, '$smfpass[1]')",true);

    $fid=((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
    do_sqlquery("UPDATE `{$db_prefix}settings` SET `value` = $fid WHERE `variable` = 'latestMember'",true);
    do_sqlquery("UPDATE `{$db_prefix}settings` SET `value` = '$utente' WHERE `variable` = 'latestRealName'",true);
    do_sqlquery("UPDATE `{$db_prefix}settings` SET `value` = UNIX_TIMESTAMP() WHERE `variable` = 'memberlist_updated'",true);
    do_sqlquery("UPDATE `{$db_prefix}settings` SET `value` = `value` + 1 WHERE `variable` = 'totalMembers'",true);
    do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `smf_fid`=$fid WHERE `id`=$newuid",true);
}

// Continue to create ipb members if they disable ipb mode
$test=do_sqlquery("SHOW TABLES LIKE '{$ipb_prefix}members'");

if ($FORUMLINK=="ipb" || mysqli_num_rows($test))
{
    ipb_create($utente, $email, $pwd, $idlevel, $newuid);
}

// xbt
if ($XBTT_USE)
   {
   $resin=do_sqlquery("INSERT INTO xbt_users (uid, torrent_pass) VALUES ($newuid,'$pid')",true);
   }

include("include/userstuff.php");
$sub=sqlesc("$GLOBALS[welcome_sub]");
$mess=sqlesc("$GLOBALS[welcome_msg]");
send_pm(0,$newuid,$sub,$mess);


    if ($INVITATIONSON == "true")
    {
        send_pm('2', $newuid, '" . $language["WELCOME"] . "', $msg);
        if ($VALID_INV == "true")
        {
            send_mail($email, "$SITENAME " . $language["REG_CONFIRM"] . "", $language["INVIT_MSGINFO"] .
                "$email" . $language["INVIT_MSGINFO1"] . " $utente\n" . $language["INVIT_MSGINFO2"] .
                " $pwd\n\n" . $language["INVIT_MSGINFO3"], "From: $SITENAME <$SITEEMAIL>");
        }
        else
            send_mail($email, "$SITENAME " . $language["REG_CONFIRM"] . "", $language["INVIT_MSGINFO"] .
                "$email" . $language["INVIT_MSGINFO1"] . " $utente\n" . $language["INVIT_MSGINFO2"] .
                " $pwd\n\n\n" . $language["INVIT_MSG_AUTOCONFIRM3"], "From: $SITENAME <$SITEEMAIL>");

        write_log("Signup new user $utente ($email)", "add");
    }
    else
    if ($VALIDATION=="user")
   {
   ini_set("sendmail_from","");
   if (((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false))==0)
     {
      send_mail($email,$language["ACCOUNT_CONFIRM"],$language["ACCOUNT_MSG"]."\n\n".$BASEURL."/index.php?page=account&act=confirm&confirm=$random&language=$idlangue");
      write_log("Signup new user $utente ($email)","add");



      }
   else
       die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
   }

return ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false));
}

?>