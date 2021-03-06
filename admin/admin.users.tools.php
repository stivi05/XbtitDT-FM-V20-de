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

if (!defined('IN_ACP'))
    die('non direct access!');

include(load_language('lang_usercp.php'));
# get uid
$uid=isset($_GET['uid'])?(int)$_GET['uid']:0;
# test uid
if ($uid==$CURUSER['uid'] || $uid==1) {
    if ($action=='delete') # cannot delete guest/myself
        stderr($language['ERROR'],$language['USER_NOT_DELETE']);
    # cannot edit guest/myself
    stderr($language['ERROR'],$language['USER_NOT_EDIT']);
}

# get uid info
if ($XBTT_USE)
    $curu=get_result('SELECT u.helpdesk, u.helped, u.helplang, u.team,u.forumbanned,u.sbox,u.dona,u.donb,u.birt,u.mal,u.fem,u.bann,u.war,u.par,u.bot,u.trmu,u.trmo,u.vimu,u.vimo,u.friend,u.junkie,u.staff,u.sysop, u.allowdownload,u.allowupload,u.seedbonus, u.block_comment,  u.immunity,  u.donor, u.username, u.cip, ul.level, ul.id_level as base_level, u.email, u.avatar, u.joined, u.lastconnect, u.id_level, u.language, u.style, u.flag, u.time_offset, u.topicsperpage, u.postsperpage, u.torrentsperpage, (u.downloaded+x.downloaded) as downloaded, (u.uploaded+x.uploaded) as uploaded, u.smf_fid, u.ipb_fid FROM '.$TABLE_PREFIX.'users u INNER JOIN '.$TABLE_PREFIX.'users_level ul ON ul.id=u.id_level LEFT JOIN xbt_users x ON x.uid=u.id WHERE u.id='.$uid.' LIMIT 1',true);
else
    $curu=get_result('SELECT u.helpdesk, u.helped, u.helplang, u.team,u.forumbanned,u.sbox,u.dona,u.donb,u.birt,u.mal,u.fem,u.bann,u.war,u.par,u.bot,u.trmu,u.trmo,u.vimu,u.vimo,u.friend,u.junkie,u.staff,u.sysop, u.allowdownload,u.allowupload, u.seedbonus, u.block_comment,  u.immunity,  u.donor, u.username, u.cip, ul.level, ul.id_level as base_level, u.email, u.avatar, u.joined, u.lastconnect, u.id_level, u.language, u.style, u.flag, u.time_offset, u.topicsperpage, u.postsperpage, u.torrentsperpage, u.downloaded, u.uploaded, u.smf_fid, u.ipb_fid FROM '.$TABLE_PREFIX.'users u INNER JOIN '.$TABLE_PREFIX.'users_level ul ON ul.id=u.id_level WHERE u.id='.$uid.' LIMIT 1',true);

# test for bad id
if (!isset($curu[0]))
    stderr($language['ERROR'],$language['BAD_ID']);
# save memory address sums
$curu=$curu[0];
# test levels
if ($CURUSER['id_level'] < $curu['base_level']){
    if ($action=='delete') # cannot delete guest/myself
        stderr($language['ERROR'],$language['USER_NOT_DELETE_HIGHER']);
    # cannot edit guest/myself
    stderr($language['ERROR'],$language['USER_NOT_EDIT_HIGHER']);
}
$note='';
# find smf_id
$smf_fid=false;
$ipb_fid=false;
if (substr($FORUMLINK,0,3)=='smf')
{
    if (!isset($curu['smf_fid']) || $curu['smf_fid']==0)
    {
        # go full mysql search on it's ass
        $smf_user=get_result("SELECT ".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")." FROM `{$db_prefix}members` WHERE `member".(($FORUMLINK=="smf")?"N":"_n")."ame`=".sqlesc($curu['username'])." LIMIT 1");
        if (isset($smf_user[0]))
        {
            $smf_fid=$smf_user[0]['ID_MEMBER'];
            quickQuery('UPDATE `'.$TABLE_PREFIX.'users` SET `smf_fid`='.$smf_fid.' WHERE `id`='.$uid.' LIMIT 1;');
        }
        else
        {
            $smf_fid=false;
            $note=' User not found in SMF.';
        }
    }
    else
        $smf_fid=$curu['smf_fid'];
}
elseif ($FORUMLINK=='ipb') 
{
    if (!isset($curu['ipb_fid']) || $curu['ipb_fid']==0)
    {
        # go full mysql search on it's ass
        $ipb_user=get_result('SELECT `member_id` FROM `'.$ipb_prefix.'members` WHERE `name`='.sqlesc($curu['username']).' LIMIT 1;');
        if (isset($ipb_user[0]))
        {
            $ipb_fid=$ipb_user[0]['member_id'];
            quickQuery('UPDATE `'.$TABLE_PREFIX.'users` SET `ipb_fid`='.$ipb_fid.' WHERE `id`='.$uid.' LIMIT 1;');
        }
        else
        {
            $ipb_fid=false;
            $note=' User not found in IPB.';
        }
    }
    else
        $ipb_fid=$curu['ipb_fid'];
}

# init vars
if (isset($_GET['returnto'])) {
    $ret_decode=urldecode($_GET['returnto']);
    $ret_url=htmlspecialchars($_GET['returnto']);
} else {
    $ret_decode='index.php';
    $ret_url='index.php';
}
$edit=true;
$profile=array();
$newname='';

switch ($action) {
    case 'delete':
        if (isset($_GET['sure']) && $_GET['sure']==1) {
            quickQuery('DELETE FROM '.$TABLE_PREFIX.'users WHERE id='.$uid.' LIMIT 1;',true);
            if (substr($FORUMLINK,0,3)=='smf')
                quickQuery("DELETE FROM `{$db_prefix}members` WHERE ".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")."=".$smf_fid." LIMIT 1");
            elseif ($FORUMLINK=='ipb')
                quickQuery("DELETE FROM `{$ipb_prefix}members` WHERE `member_id`=".$ipb_fid." LIMIT 1");
            if ($XBTT_USE)
                quickQuery('DELETE FROM xbt_users WHERE uid='.$uid.' LIMIT 1;');

            write_log('Deleted '.unesc($curu['level']).' '.$profile['username'],'modified');
            redirect($ret_decode);
        } else {
            $edit=false;
            $block_title=$language['ACCOUNT_EDIT'];
            $profile['username']=unesc($curu['username']);
            $profile['last_ip']=unesc($curu['cip']);
            $profile['level']=unesc($curu['level']);
            $profile['joined']=unesc($curu['joined']);
            $profile['lastaccess']=unesc($curu['lastconnect']);
            $profile['downloaded']=makesize($curu['downloaded']);
            $profile['uploaded']=makesize($curu['uploaded']);
            $profile['team']=unesc($curu['team']);
            $profile['return']='document.location.href=\''.$ret_decode.'\'';
            $profile['confirm_delete']='document.location.href=\'index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'&amp;do=users&amp;action=delete&amp;uid='.$uid.'&amp;sure=1&amp;returnto='.$ret_url.'\'';
        }
        break;

    case 'edit':
        # init vars

        $pass_min_req=explode(",", $btit_settings["secsui_pass_min_req"]);
        $admintpl->set("pass_min_char",$pass_min_req[0]);
        $admintpl->set("pass_min_lct",$pass_min_req[1]);
        $admintpl->set("pass_min_uct",$pass_min_req[2]);
        $admintpl->set("pass_min_num",$pass_min_req[3]);
        $admintpl->set("pass_min_sym",$pass_min_req[4]);
        $admintpl->set("pass_char_plural", (($pass_min_req[0]==1)?false:true),true);
        $admintpl->set("pass_lct_plural", (($pass_min_req[1]==1)?false:true),true);
        $admintpl->set("pass_uct_plural", (($pass_min_req[2]==1)?false:true),true);
        $admintpl->set("pass_num_plural", (($pass_min_req[3]==1)?false:true),true);
        $admintpl->set("pass_sym_plural", (($pass_min_req[4]==1)?false:true),true);
        $admintpl->set("pass_lct_set", (($pass_min_req[1]>0)?true:false),true);
        $admintpl->set("pass_uct_set", (($pass_min_req[2]>0)?true:false),true);
        $admintpl->set("pass_num_set", (($pass_min_req[3]>0)?true:false),true);
        $admintpl->set("pass_sym_set", (($pass_min_req[4]>0)?true:false),true);

        $profile['username']=unesc($curu['username']);
        $profile['email']=unesc($curu['email']);

          $profile["allowdownload"]=($curu["allowdownload"]=="yes"?"checked=\"checked\"":"");
          $profile["allowupload"]=($curu["allowupload"]=="yes"?"checked=\"checked\"":"");


    $profile["block_comment"]=unesc($curu['block_comment']=="yes"?"checked=\"checked\"":"");
	  $profile["sbox"]=unesc($curu['sbox']=="yes"?"checked=\"checked\"":"");
	  
   
        
    //user images
    global $btit_settings;
    $do=$btit_settings["img_don"];
    $don=$btit_settings["img_donm"];
    $ma=$btit_settings["img_mal"];
    $fe=$btit_settings["img_fem"];
    $ba=$btit_settings["img_ban"];
    $tu=$btit_settings["img_tru"];
    $vi=$btit_settings["img_vip"];
    $wa=$btit_settings["img_war"];
    $st=$btit_settings["img_sta"];
    $bi=$btit_settings["img_bir"];
    $pa=$btit_settings["img_par"];
    $sy=$btit_settings["img_sys"];
    $vip=$btit_settings["img_vipm"];
    $tut=$btit_settings["img_trum"];  
    $fr=$btit_settings["img_fri"];
    $ju=$btit_settings["img_jun"]; 
    $bo=$btit_settings["img_bot"];
	 
    $profile["donimg"]="<img src='images/user_images/" . $do . "' alt='" . $btit_settings["text_don"] . "' title='" . $btit_settings["text_don"] . "' />";
    $profile["donat"]=unesc($btit_settings["text_don"]);
    $profile["donai"]=unesc($curu['dona']=="yes"?"checked=\"checked\"":"");
    
    $profile["donbimg"]="<img src='images/user_images/" . $don . "' alt='" . $btit_settings["text_donm"] . "' title='" . $btit_settings["text_donm"] . "' />";
    $profile["donbt"]=unesc($btit_settings["text_donm"]);
    $profile["donbi"]=unesc($curu['donb']=="yes"?"checked=\"checked\"":"");
    
    $profile["bdimg"]="<img src='images/user_images/" . $bi . "' alt='" . $btit_settings["text_bir"] . "' title='" . $btit_settings["text_bir"] . "' />";
	$profile["birtt"]=unesc($btit_settings["text_bir"]);
    $profile["birti"]=unesc($curu['birt']=="yes"?"checked=\"checked\"":"");
    
    $profile["malimg"]="<img src='images/user_images/" . $ma . "' alt='" . $btit_settings["text_mal"] . "' title='" . $btit_settings["text_mal"] . "' />";
	$profile["malt"]=unesc($btit_settings["text_mal"]);
    $profile["mali"]=unesc($curu['mal']=="yes"?"checked=\"checked\"":"");
    
    $profile["femimg"]="<img src='images/user_images/" . $fe . "' alt='" . $btit_settings["text_fem"] . "' title='" . $btit_settings["text_fem"] . "' />";
	$profile["femt"]=unesc($btit_settings["text_fem"]);
    $profile["femi"]=unesc($curu['fem']=="yes"?"checked=\"checked\"":"");
    
    $profile["banimg"]="<img src='images/user_images/" . $ba . "' alt='" . $btit_settings["text_ban"] . "' title='" . $btit_settings["text_ban"] . "' />";
    $profile["bant"]=unesc($btit_settings["text_ban"]);
    $profile["bani"]=unesc($curu['bann']=="yes"?"checked=\"checked\"":"");
    
    $profile["warimg"]="<img src='images/user_images/" . $wa . "' alt='" . $btit_settings["text_war"] . "' title='" . $btit_settings["text_war"] . "' />";
    $profile["wart"]=unesc($btit_settings["text_war"]);
    $profile["wari"]=unesc($curu['war']=="yes"?"checked=\"checked\"":"");
    
    $profile["parimg"]="<img src='images/user_images/" . $pa . "' alt='" . $btit_settings["text_par"] . "' title='" . $btit_settings["text_par"] . "' />";
    $profile["part"]=unesc($btit_settings["text_par"]);
    $profile["pari"]=unesc($curu['par']=="yes"?"checked=\"checked\"":"");
    
    $profile["botimg"]="<img src='images/user_images/" . $bo . "' alt='" . $btit_settings["text_bot"] . "' title='" . $btit_settings["text_bot"] . "' />";
    $profile["bott"]=unesc($btit_settings["text_bot"]);
    $profile["boti"]=unesc($curu['bot']=="yes"?"checked=\"checked\"":"");
    
    $profile["trmuimg"]="<img src='images/user_images/" . $tu . "' alt='" . $btit_settings["text_tru"] . "' title='" . $btit_settings["text_tru"] . "' />";
    $profile["trmut"]=unesc($btit_settings["text_tru"]);
    $profile["trmui"]=unesc($curu['trmu']=="yes"?"checked=\"checked\"":"");
    
    $profile["trmoimg"]="<img src='images/user_images/" . $tut . "' alt='" . $btit_settings["text_trum"] . "' title='" . $btit_settings["text_trum"] . "' />";
    $profile["trmot"]=unesc($btit_settings["text_trum"]);
    $profile["trmoi"]=unesc($curu['trmo']=="yes"?"checked=\"checked\"":"");
    
    $profile["vimuimg"]="<img src='images/user_images/" . $vi . "' alt='" . $btit_settings["text_fri"] . "' title='" . $btit_settings["text_fri"] . "' />";
    $profile["vimut"]=unesc($btit_settings["text_vip"]);
    $profile["vimui"]=unesc($curu['vimu']=="yes"?"checked=\"checked\"":"");
    
    $profile["vimoimg"]="<img src='images/user_images/" . $vip . "' alt='" . $btit_settings["text_vipm"] . "' title='" . $btit_settings["text_vipm"] . "' />";
    $profile["vimot"]=unesc($btit_settings["text_vipm"]);
    $profile["vimoi"]=unesc($curu['vimo']=="yes"?"checked=\"checked\"":"");
    
    $profile["friendimg"]="<img src='images/user_images/" . $fr . "' alt='" . $btit_settings["text_fri"] . "' title='" . $btit_settings["text_fri"] . "' />";
    $profile["friendt"]=unesc($btit_settings["text_fri"]);
    $profile["friendi"]=unesc($curu['friend']=="yes"?"checked=\"checked\"":"");
    
    $profile["junkieimg"]="<img src='images/user_images/" . $ju . "' alt='" . $btit_settings["text_jun"] . "' title='" . $btit_settings["text_jun"] . "' />";
    $profile["junkiet"]=unesc($btit_settings["text_jun"]);
    $profile["junkiei"]=unesc($curu['junkie']=="yes"?"checked=\"checked\"":"");
    
    $profile["staffimg"]="<img src='images/user_images/" . $st . "' alt='" . $btit_settings["text_sta"] . "' title='" . $btit_settings["text_sta"] . "' />";
    $profile["stafft"]=unesc($btit_settings["text_sta"]);
    $profile["staffi"]=unesc($curu['staff']=="yes"?"checked=\"checked\"":"");
    
    $profile["sysopimg"]="<img src='images/user_images/" . $sy . "' alt='" . $btit_settings["text_sys"] . "' title='" . $btit_settings["text_sys"] . "' />";
    $profile["sysopt"]=unesc($btit_settings["text_sys"]);
    $profile["sysopi"]=unesc($curu['sysop']=="yes"?"checked=\"checked\"":"");
    // user images
$profile['uploaded']=$curu['uploaded'];
        $profile['downloaded']=$curu['downloaded'];
        $profile['down']=makesize($curu['downloaded']);
        $profile['up']=makesize($curu['uploaded']);
        $profile['ratio']=($curu['downloaded']>0?$curu['uploaded']/$curu['downloaded']:'');
        $profile["forumbanned"]=($curu["forumbanned"]=="yes"?"checked=\"checked\"":"");
        # init options
        $opts['name']='level';
        $opts['complete']=true;
        $opts['id']='id';
        $opts['value']='level';
        $opts['default']=$curu['id_level'];
        $profile['seedbonus']=unesc($curu['seedbonus']);

        $profile['custom_title']=unesc($curu['custom_title']);
        $profile["helpdesk"]=unesc($curu['helpdesk']=="yes"?"checked=\"checked\"":"");
        $profile["helped"]=unesc($curu['helped']);
        $profile["helplang"]=unesc($curu['helplang']);

# rank list

        $profile["donor"]=($curu["donor"]=="yes"?"checked=\"checked\"":"");
        
	    $profile["immunity"]=($curu["immunity"]=="yes"?"checked=\"checked\"":"");
	    $ranks=rank_list();
        $admintpl->set('rank_combo',get_combo($ranks, $opts));
        # init options
        $opts['name']='name';
        $opts['id']='id';
        $opts['value']='name';
        if($curu['team']=="0"){
        $opts['default']=$curu['team'][0];
        }else{
        $opts['default']=$curu['team'];
        }
        # team list
        $teams=team_list();
        $admintpl->set('team_combo',get_combo($teams, $opts));
        # lang list
        $opts['name']='language';
        $opts['value']='language';
        $opts['default']=$curu['language'];
        $langs=language_list();
        $admintpl->set('language_combo',get_combo($langs, $opts));
        # style list
        $opts['name']='style';
        $opts['value']='style';
        $opts['default']=$curu['style'];
        $styles=style_list();
        $admintpl->set('style_combo',get_combo($styles, $opts));
        # timezone list
        $opts['name']='timezone';
        $opts['id']='difference';
        $opts['value']='timezone';
        $opts['default']=$curu['time_offset'];
        $tzones=timezone_list();
        $admintpl->set('tz_combo',get_combo($tzones, $opts));
        # flag list
        $opts['complete']=false;
        $opts['value']='name';
        $opts['id']='id';
        $opts['default']=$curu['flag'];
        $flags=flag_list();
        $admintpl->set('flag_combo',get_combo($flags, $opts));
        # posts/topics per page
        if ($FORUMLINK=='' || $FORUMLINK=='internal') {
            $admintpl->set('INTERNAL_FORUM',true,true);
            $profile['topicsperpage']=$curu['topicsperpage'];
            $profile['postsperpage']=$curu['postsperpage'];
        } else {
            $admintpl->set('INTERNAL_FORUM',false,true);
            $profile['topicsperpage']='';
            $profile['postsperpage']='';
        }
        # torrents per page
        $profile['torrentsperpage']=$curu['torrentsperpage'];
        # avatar
        $profile['avatar']=($curu['avatar']!='')?$curu['avatar']:$STYLEURL.'/images/default_avatar.gif';
        $profile['avatar_field']=unesc($curu['avatar']);
        $profile['avatar']='<img onload="resize_avatar(this);" src="'.htmlspecialchars($profile['avatar']).'" alt="" />';
        # form stuff
        $profile['frm_action']='index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'&amp;do=users&amp;action=save&amp;uid='.$uid;
        $profile['frm_cancel']='index.php?page=usercp&amp;uid='.$uid;
        # title
        $block_title=$language['ACCOUNT_EDIT'];
        break;
    
    case 'save':
        if ($_POST['confirm']==$language['FRM_CONFIRM']) {

            if($FORUMLINK=="ipb")
            {
                if(!defined('IPS_ENFORCE_ACCESS'))
                    define('IPS_ENFORCE_ACCESS', true);
                if(!defined('IPB_THIS_SCRIPT'))
                    define('IPB_THIS_SCRIPT', 'public');

                require_once($THIS_BASEPATH. '/ipb/initdata.php' );
                require_once( IPS_ROOT_PATH . 'sources/base/ipsRegistry.php' );
                require_once( IPS_ROOT_PATH . 'sources/base/ipsController.php' );
                $registry = ipsRegistry::instance(); 
                $registry->init();
            }

            $idlangue=(int)$_POST['language'];
            $idstyle=(int)$_POST['style'];
            $idflag=(int)$_POST['flag'];
            $level=(int)$_POST['level'];
            $name=(int)$_POST['name'];
            $time=(int)$_POST['timezone']; # this is wrong, half hour based time zones won't work
            $topicsperpage=(isset($_POST['topicsperpage']))?(int)$_POST['topicsperpage']:$curu['topicsperpage'];
            $postsperpage=(isset($_POST['postsperpage']))?(int)$_POST['postsperpage']:$curu['postsperpage'];
            $torrentsperpage=(int)$_POST['torrentsperpage'];
            $set[]="forumbanned='".(isset($_POST["forumbanned"])?"yes":"no")."'";
            $uploaded=(float)$_POST['uploaded'];
            $downloaded=(float)$_POST['downloaded'];
            $email=AddSlashes($_POST['email']);
            $avatar=unesc($_POST['avatar']);
            $username=unesc($_POST['username']);
            $helped=unesc($_POST['helped']);
            $helplang=unesc($_POST['helplang']);
            $pass=$_POST['pass'];
            $chpass=(isset($_POST['chpass']) && $pass!='');
            (isset($_POST["seedbonus"]) && !empty($_POST["seedbonus"]) && is_numeric($_POST["seedbonus"]) && $_POST["seedbonus"]>=0)  ? $seedbonus=(float)0+$_POST["seedbonus"] : $seedbonus=$curu["seedbonus"];
            # new level of the user

            $custom_title=unesc($_POST["custom_title"]);


            $rlev=do_sqlquery("SELECT `id_level` `base_level`, `level` `name`".((substr($FORUMLINK,0,3)=='smf')?", `smf_group_mirror`":(($FORUMLINK=='ipb')?", `ipb_group_mirror`":""))." FROM {$TABLE_PREFIX}users_level WHERE id=".$level." LIMIT 1");
            $reslev=mysqli_fetch_assoc($rlev);
            if ( ($CURUSER['id_level'] < $reslev['base_level']))
                $level=0;
            # check avatar image extension if someone have better idea ;)
            if ($avatar && $avatar!='' && !in_array(substr($avatar,strlen($avatar)-4),array('.gif','.jpg','.bmp','.png')))
                stderr($language['ERROR'], $language['ERR_AVATAR_EXT']);
            if ($idlangue>0 && $idlangue != $curu['language'])
                $set[]='language='.$idlangue;
            if ($idstyle>0 && $idstyle != $curu['style'])
                $set[]='style='.$idstyle;
            if ($name != $curu['team'])
                $set[]='team='.$name;
            if ($idflag>0 && $idflag != $curu['flag'])
                $set[]='flag='.$idflag;
            if ($level>0 && $level != $curu['id_level']) {
                if (substr($FORUMLINK,0,3)=='smf') {
                    # find the coresponding level in smf
                    if($reslev["smf_group_mirror"]==0)
                        $smf_group=get_result("SELECT ".(($FORUMLINK=="smf")?"`ID_GROUP`":"`id_group`")." FROM `{$db_prefix}membergroups` WHERE `group".(($FORUMLINK=="smf")?"N":"_n")."ame`='".$reslev["name"]."' LIMIT 1", true, $CACHE_DURATION);
                    # if there is one update it
                    if (isset($smf_group[0]) || $reslev["smf_group_mirror"]>0)
                    {
                        if($reslev["smf_group_mirror"]>0)
                        {
                            if($FORUMLINK=="smf")
                                $smf_group[0]['ID_GROUP']=$reslev["smf_group_mirror"];
                            else
                                $smf_group[0]['id_group']=$reslev["smf_group_mirror"];
                        }
                        $smfset[]=(($FORUMLINK=="smf")?'ID_GROUP='.$smf_group[0]['ID_GROUP']:'id_group='.$smf_group[0]['id_group']);
                    }
                    else $note.=' Group not found in SMF.';
                }
                elseif($FORUMLINK=="ipb")
                {
                    # find the coresponding level in ipb
                    if($reslev["ipb_group_mirror"]==0)
                    $ipb_group=get_result("SELECT `perm_id` FROM `{$ipb_prefix}forum_perms` WHERE `perm_name`='".$reslev["name"]."' LIMIT 1;", true, $CACHE_DURATION);
                    # if there is one update it
                    if (isset($ipb_group[0]) || $reslev["ipb_group_mirror"]>0)
                    {
                        if($reslev["ipb_group_mirror"]>0)
                            $ipb_group[0]["perm_id"]=$reslev["ipb_group_mirror"];
                        $ipblevel=$ipb_group[0]["perm_id"];
                        IPSMember::save($ipb_fid, array("members" => array("member_group_id" => "$ipblevel")));
                    }
                    else $note.=' Group not found in IPB.';
                }
                $set[]='id_level='.$level;
            }
            if ($time != $curu['time_offset'])
                $set[]='time_offset='.$time;
            if ($seedbonus != $curu['seedbonus'])
	            $set[]='seedbonus='.sqlesc(htmlspecialchars($seedbonus));
            if ($custom_title != $curu['custom_title'])
                $set[]='custom_title='.sqlesc(htmlspecialchars($custom_title));
            if ($email != $curu['email'])
            {
                $set[]='email='.sqlesc($email);

                if(substr($FORUMLINK,0,3)=="smf")
                {
                    $smfset[]="email".(($FORUMLINK=="smf")?"A":"_a")."ddress=".sqlesc($email);
                }
                elseif($FORUMLINK=="ipb")
                {
                    IPSMember::save($ipb_fid, array("members" => array("email" => "$email")));
                }
            }
            if ($avatar != $curu['avatar'])
                $set[]='avatar='.sqlesc(htmlspecialchars($avatar));
            if ($username != $curu['username']) {
                $new_username=$username;
                $sql_name=sqlesc($curu['username']);
                $username=sqlesc($username);
                $dupe=get_result("SELECT `id` FROM `{$TABLE_PREFIX}users` WHERE `username`=".$username." LIMIT 1", true, $CACHE_DURATION);
                if (!isset($dupe[0])) {
                    $set[]='username='.$username;
                    $newname=' ( now: '.$username;
                    if (substr($FORUMLINK,0,3)=='smf')
                    {
                        $dupe=get_result("SELECT ".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")." FROM `{$db_prefix}members` WHERE `member".(($FORUMLINK=="smf")?"N":"_n")."ame`=".$username." LIMIT 1", true, $CACHE_DURATION);
                        if (!isset($dupe[0])) {
                            $smfset[]='member'.(($FORUMLINK=="smf")?"N":"_n").'ame='.$username;
                        } else
                            $newname.=', dupe name in smf memberName';
                        $dupe=get_result("SELECT ".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")." FROM {$db_prefix}members WHERE `real".(($FORUMLINK=="smf")?"N":"_n")."ame`=".$username." LIMIT 1", true, $CACHE_DURATION);
                        if (!isset($dupe[0])) {
                            $smfset[]='real'.(($FORUMLINK=="smf")?"N":"_n").'ame='.$username;
                        } else
                            $newname.=', dupe name in smf realName';
                    }
                    elseif($FORUMLINK=='ipb')
                    {
                        $new_username=trim($username,"'");
                        $new_l_username=strtolower($new_username);
                        $new_seoname=IPSText::makeSeoTitle($new_username);
                        IPSMember::save($ipb_fid, array("members" => array("name" => "$new_username", "members_display_name" => "$new_username", "members_l_display_name" => "$new_l_username", "members_l_username" => "$new_l_username", "members_seo_name" => "$new_seoname")));
                    }
                    $newname.=' )';
                } else $note.=' Dupe name in XBTIT.';
            }
            if ($topicsperpage != $curu['topicsperpage']) 
                $set[]='topicsperpage='.$topicsperpage;
            if ($postsperpage != $curu['postsperpage'])
                $set[]='postsperpage='.$postsperpage;
            if ($torrentsperpage != $curu['torrentsperpage'])
                $set[]='torrentsperpage='.$torrentsperpage;
            if ($XBTT_USE){
                if ($downloaded != $curu['downloaded']) {
                    $xbtset[]='downloaded='.$downloaded;
                    $set[]='downloaded=0';
                }
                if ($uploaded != $curu['uploaded']) {
                    $xbtset[]='uploaded='.$uploaded;
                    $set[]='uploaded=0';
                }
            } else {
                if ($uploaded != $curu['uploaded'])
                    $set[]='uploaded='.$uploaded;
                if ($downloaded != $curu['downloaded'])
                    $set[]='downloaded='.$downloaded;
            }
            $set[]="donor='".(isset($_POST["donor"])?"yes":"no")."'";
         $set[]="allowdownload='".(isset($_POST["allowdownload"])?"yes":"no")."'";
         $set[]="allowupload='".(isset($_POST["allowupload"])?"yes":"no")."'";
            
	  $set[]="immunity='".(isset($_POST["immunity"])?"yes":"no")."'";
	  if ($chpass) {
                $pass_min_req=explode(",", $btit_settings["secsui_pass_min_req"]);
                
                if(strlen($pass)<$pass_min_req[0])
                    stderr($language["ERROR"],$language["ERR_PASS_LENGTH_1"]." <span style=\"color:blue;font-weight:bold;\">".$pass_min_req[0]."</span> ".$language["ERR_PASS_LENGTH_2"]);

                $lct_count=0;
                $uct_count=0;
                $num_count=0;
                $sym_count=0;
                $pass_end=(int)(strlen($pass)-1);
                $pass_position=0;
                $pattern1='#[a-z]#';
                $pattern2='#[A-Z]#';
                $pattern3='#[0-9]#';
                $pattern4='/[?!"?$%^&*()`{}\[\]:@~;\'#<>?,.\/\\-=_+\|]/';

                for($pass_position=0;$pass_position<=$pass_end;$pass_position++)
                {
                    if(preg_match($pattern1,substr($pass,$pass_position,1),$matches))
                      $lct_count++;
                    elseif(preg_match($pattern2,substr($pass,$pass_position,1),$matches))
                      $uct_count++;
                    elseif(preg_match($pattern3,substr($pass,$pass_position,1),$matches))
                      $num_count++;
                    elseif(preg_match($pattern4,substr($pass,$pass_position,1),$matches))
                      $sym_count++;
                }
                $newpassword=pass_the_salt(30);
                if($lct_count<$pass_min_req[1] || $uct_count<$pass_min_req[2] || $num_count<$pass_min_req[3] || $sym_count<$pass_min_req[4])
                    stderr($language["ERROR"],$language["ERR_PASS_TOO_WEAK_1A"].":<br /><br />".(($pass_min_req[1]>0)?"<li><span style='color:blue;font-weight:bold;'>".$pass_min_req[1]."</span> ".(($pass_min_req[1]==1)?$language["ERR_PASS_TOO_WEAK_2"]:$language["ERR_PASS_TOO_WEAK_2A"])."</li>":"").(($pass_min_req[2]>0)?"<li><span style='color:blue;font-weight:bold;'>".$pass_min_req[2]."</span> ".(($pass_min_req[2]==1)?$language["ERR_PASS_TOO_WEAK_3"]:$language["ERR_PASS_TOO_WEAK_3A"])."</li>":"").(($pass_min_req[3]>0)?"<li><span style='color:blue;font-weight:bold;'>".$pass_min_req[3]."</span> ".(($pass_min_req[3]==1)?$language["ERR_PASS_TOO_WEAK_4"]:$language["ERR_PASS_TOO_WEAK_4A"])."</li>":"").(($pass_min_req[4]>0)?"<li><span style='color:blue;font-weight:bold;'>".$pass_min_req[4]."</span> ".(($pass_min_req[4]==1)?$language["ERR_PASS_TOO_WEAK_5"]:$language["ERR_PASS_TOO_WEAK_5A"])."</li>":"")."<br />".$language["ERR_PASS_TOO_WEAK_6"].":<br /><br /><span style='color:blue;font-weight:bold;'>".$newpassword."</span><br />");

                $un=((!empty($new_username) && $new_username!=$curu["username"])?$new_username:$curu["username"]);
                $multipass=hash_generate(array("salt" => ""), $pass, $un);
                $j=$btit_settings["secsui_pass_type"];
                $set[]="`password`=".sqlesc($multipass[$j]["rehash"]);
                $set[]="`salt`=".sqlesc($multipass[$j]["salt"]);
                $set[]="`pass_type`=".sqlesc($j);
                $set[]="`dupe_hash`=".sqlesc($multipass[$j]["dupehash"]);
                $passhash=smf_passgen($un, $pass);
                $smfset[]='`passwd`='.sqlesc($passhash[0]);
                $smfset[]='`password'.(($FORUMLINK=="smf")?"S":"_s").'alt`='.sqlesc($passhash[1]);
                if($FORUMLINK=="ipb")
                {
                    $ipbhash=ipb_passgen($pass);
                    IPSMember::save($ipb_fid, array("members" => array("member_login_key" => "", "member_login_key_expire" => "0", "members_pass_hash" => "$ipbhash[0]", "members_pass_salt" => "$ipbhash[1]")));
                }
            }

            
         $set[]="block_comment='".(isset($_POST["block_comment"])?"yes":"no")."'";
	  $set[]="sbox='".(isset($_POST["sbox"])?"yes":"no")."'";
	  
    
                     //user images
          $set[]="dona='".(isset($_POST["dona"])?"yes":"no")."'";
          $set[]="donb='".(isset($_POST["donb"])?"yes":"no")."'";
          $set[]="birt='".(isset($_POST["birt"])?"yes":"no")."'";
          $set[]="mal='".(isset($_POST["mal"])?"yes":"no")."'";
          $set[]="fem='".(isset($_POST["fem"])?"yes":"no")."'";
          $set[]="war='".(isset($_POST["war"])?"yes":"no")."'";
          $set[]="bann='".(isset($_POST["bann"])?"yes":"no")."'";
          $set[]="par='".(isset($_POST["par"])?"yes":"no")."'";
          $set[]="bot='".(isset($_POST["bot"])?"yes":"no")."'";
          $set[]="trmu='".(isset($_POST["trmu"])?"yes":"no")."'";
          $set[]="trmo='".(isset($_POST["trmo"])?"yes":"no")."'";
          $set[]="vimu='".(isset($_POST["vimu"])?"yes":"no")."'";
          $set[]="vimo='".(isset($_POST["vimo"])?"yes":"no")."'";
          $set[]="friend='".(isset($_POST["friend"])?"yes":"no")."'";
          $set[]="junkie='".(isset($_POST["junkie"])?"yes":"no")."'";
          $set[]="staff='".(isset($_POST["staff"])?"yes":"no")."'";
          $set[]="sysop='".(isset($_POST["sysop"])?"yes":"no")."'";
          //user images
          
          $set[]="helpdesk='".(isset($_POST["helpdesk"])?"yes":"no")."'";
                if ($helped != $curu['helped'])
				$set[]='helped='.sqlesc(htmlspecialchars($helped));
				if ($helplang != $curu['helplang'])
				$set[]='helplang='.sqlesc(htmlspecialchars($helplang));
				
             $updateset=(isset($set))?implode(',',$set):'';
            $updatesetxbt=(isset($xbtset))?implode(',',$xbtset):'';
            $updatesetsmf=(isset($smfset))?implode(',',$smfset):'';
            if ($updateset!='') {
                if ($XBTT_USE && $updatesetxbt!='')
                    quickQuery('UPDATE xbt_users SET '.$updatesetxbt.' WHERE uid='.$uid.' LIMIT 1;');
                if ((substr($FORUMLINK,0,3)=='smf') && ($updatesetsmf!='') && (!is_bool($smf_fid)))
                    quickQuery("UPDATE `{$db_prefix}members` SET ".$updatesetsmf." WHERE ".(($FORUMLINK=="smf")?"`ID_MEMBER`":"`id_member`")."=".$smf_fid." LIMIT 1");
                quickQuery('UPDATE '.$TABLE_PREFIX.'users SET '.$updateset.' WHERE id='.$uid.' LIMIT 1;');

                success_msg($language['SUCCESS'], $language['INF_CHANGED'].$note.'<br /><a href="index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'">'.$language['MNU_ADMINCP'].'</a>');
                write_log('Modified user <a href="'.$btit_settings['url'].'/index.php?page=userdetails&amp;id='.$uid.'">'.$curu['username'].'</a> '.$newname.' ( '.count($set).' changes on uid '.$uid.' )','modified');
                stdfoot(true,false);
                die();
            } else stderr($language['ERROR'],$language['USER_NO_CHANGE']);
        }
        redirect('index.php?page=admin&user='.$CURUSER['uid'].'&code='.$CURUSER['random']);
        break;
}

# set template info
if ($CURUSER['id_level']=='8')
{
$admintpl->set('imm','&nbsp;Immunity&nbsp;<input type="checkbox" name="immunity" <tag:profile.immunity /> />');
}
	  
$admintpl->set('profile',$profile);
$admintpl->set('language',$language);
$admintpl->set('edit_user',$edit,true);
?>