<?php
// *****************************************************************
//
// Filename: usercp.rename.php
// Parent:   usercp.php
// Requires: Parent PHP script
// Author:   Petr1fied
// Date:     2007-03-07
// Updated:  2007-12-26
// Version:  1.1
//
// Usage:
// - Allows members to change their nickname as long as the new
//   nickname passes strict validation.
//
// *****************************************************************
//
// ################### HISTORY ###################
//
// 1.0 2007-03-07 - Petr1fied: Initial development.
// 1.1 2007-12-26 - Converted for XBTIT v2.0.0
//
// *****************************************************************
// XBTIT DT FM 2014
// File Start --->

 switch($action)
{
    case 'post':
    
  
    (isset($_POST["nick1"])) ? $nick1=$_POST["nick1"] : $nick1="";
    (isset($_POST["nick2"])) ? $nick2=$_POST["nick2"] : $nick2="";

    if($nick1=="" || $nick2=="") $case=1;

    // -----------------------------
    // Captcha hack
    // -----------------------------

    if ($USE_IMAGECODE && !$case)
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
                    $case=2;
                }
            }
        }
    }
    if($nick1!=$nick2 && !$case) $case=3;
    elseif ($CURUSER["username"]==$nick1 && !$case) $case=4;
    elseif (preg_replace('@[^0-9A-Za-z_\- ]@','',$nick1)!=$nick1 && !$case) $case=5;
    elseif (strpos($nick1, " ")==true && !$case) $case=6;
    elseif (strlen($nick1)<3 && !$case) $case=7;
    elseif ((strtolower($nick1)=="owner" || strtolower($nick1)=="administrator" || strtolower($nick1)=="admin" || strtolower($nick1)=="moderator" || strtolower($nick1)=="guest") && !$case) $case=8;
    $res=do_sqlquery("SELECT id FROM {$TABLE_PREFIX}users WHERE username='$nick1'");
    if (mysqli_num_rows($res)>0 && !$case) $case=9;

    if($case)
    {
        if ($case==1) $msg=$language["ERR_MISSING_DATA"];
        elseif ($case==2) $msg=$language["ERR_IMAGE_CODE"];
        elseif ($case==3) $msg=$language["ERR_NICK_NO_MATCH"];
        elseif ($case==4) $msg=$language["ERR_SAME_NICK"]." <strong>$nick1</strong>";
        elseif ($case==5) $msg=$language["ERR_SPECIAL_CHAR"];
        elseif ($case==6) $msg=$language["ERR_NO_SPACE"].preg_replace('/\ /', '_', $nick1);
        elseif ($case==7) $msg=$language["ERR_NICK_TOO_SMALL"];
        elseif ($case==8) $msg=$language["ERR_NICK_NOT_ALLOWED"];
        elseif ($case==9) $msg=$language["ERR_USER_ALREADY_EXISTS"];
        err_msg($language["ERROR"],$msg);
        stdfoot();
        exit();
    }
    do_sqlquery("UPDATE {$TABLE_PREFIX}users SET username='$nick1' WHERE id=".$CURUSER["uid"]);
    if($GLOBALS["FORUMLINK"]=="smf")
    {
        do_sqlquery("UPDATE {$db_prefix}members SET memberName='$nick1', realName='$nick1' WHERE ID_MEMBER=".$CURUSER["smf_fid"]);
        do_sqlquery("UPDATE {$db_prefix}messages SET posterName='$nick1' WHERE ID_MEMBER=".$CURUSER["smf_fid"]);
    }
    write_log($language["CHANGED_THEIR_NICK"] . $nick1,"modify");
    success_msg($language["SUCCESS"],$language["NICK_CHANGE_SUCCESS"].$nick1);
    stdfoot();
    exit();
    break; 
 
    case '':
    case 'change':
    default:
    $rentpl=array();
    $rentpl["username"]=$CURUSER["username"];
    
    // -----------------------------
    // Captcha hack
    // -----------------------------
    if ($USE_IMAGECODE)
    {
        if (extension_loaded('gd'))
        {
            $arr = gd_info();
            if ($arr['FreeType Support']==1)
            {
                $p=new ocr_captcha();

                $rentpl["imagecode"]=$p->display_captcha(true);
                $private=$p->generate_private();
            }
        }
    }
    $rentpl["frm_action"]="index.php?page=usercp&amp;do=rename&amp;action=post&amp;uid=".$uid."";
    $rentpl["frm_cancel"]="index.php?page=usercp&amp;uid=".$uid."";
    $usercptpl->set("ren",$rentpl);
    break;  
}

// <--- File End

?>