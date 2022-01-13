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

if (!defined("IN_ACP"))
      die("non direct access!");

$admintpl->set("add_new",false,true);
$admintpl->set("smf_in_use_1", ((substr($FORUMLINK,0,3)=="smf")?true:false), true);
$admintpl->set("smf_in_use_2", ((substr($FORUMLINK,0,3)=="smf")?true:false), true);
$admintpl->set("smf_in_use_3", ((substr($FORUMLINK,0,3)=="smf")?true:false), true);
$admintpl->set("ipb_in_use_1", (($FORUMLINK=="ipb")?true:false), true);
$admintpl->set("ipb_in_use_2", (($FORUMLINK=="ipb")?true:false), true);
$admintpl->set("ipb_in_use_3", (($FORUMLINK=="ipb")?true:false), true);

switch ($action)
    {
        
        case 'delete':
          $id=max(0,$_GET["id"]);
          // controle if this level can be cancelled
          $rcanc=do_sqlquery("SELECT can_be_deleted FROM {$TABLE_PREFIX}users_level WHERE id=$id");
          if (!$rcanc || mysqli_num_rows($rcanc)==0)
            {
             err_msg($language["ERROR"], $language["ERR_CANT_FIND_GROUP"]);
             stdfoot(false,false,true);
             die;
            }
          $rcancanc=mysqli_fetch_array($rcanc);
          if ($rcancanc["can_be_deleted"]=="yes")
             {
             do_sqlquery("DELETE FROM {$TABLE_PREFIX}users_level WHERE id=$id",true);
             do_sqlquery("DELETE FROM {$TABLE_PREFIX}categories_perm WHERE levelid=$id",true);
             success_msg($language["SUCCESS"],$language["GROUP_DELETED"]."<br />\n<a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=groups\">".$language["ACP_USER_GROUP"]."</a>");
             stdfoot(false,false,true);
             die;
             }
          else
             {
              err_msg($language["ERROR"],$language["CANT_DELETE_GROUP"]);
              stdfoot(false,false,true);
              die;
             }
          break;

        case 'edit':
          $block_title=$language["GROUP_EDIT_GROUP"];
          $gid=max(0,$_GET["id"]);
          $admintpl->set("list",false,true);
          $admintpl->set("frm_action","index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=groups&amp;action=save&amp;id=$gid");
          $admintpl->set("language",$language);
          $rgroup=get_result("SELECT * FROM {$TABLE_PREFIX}users_level WHERE id=$gid",true);
          $current_group=$rgroup[0];
          unset($rgroup);
          $current_group["prefixcolor"]=unesc($current_group["prefixcolor"]);
          $current_group["suffixcolor"]=unesc($current_group["suffixcolor"]);
          $current_group["level"]=unesc($current_group["level"]);
          $current_group["view_torrents"]=($current_group["view_torrents"]=="yes"?"checked=\"checked\"":"");
          $current_group["edit_torrents"]=($current_group["edit_torrents"]=="yes"?"checked=\"checked\"":"");
          $current_group["delete_torrents"]=($current_group["delete_torrents"]=="yes"?"checked=\"checked\"":"");
          $current_group["view_users"]=($current_group["view_users"]=="yes"?"checked=\"checked\"":"");
          $current_group["edit_users"]=($current_group["edit_users"]=="yes"?"checked=\"checked\"":"");
          $current_group["delete_users"]=($current_group["delete_users"]=="yes"?"checked=\"checked\"":"");
          $current_group["view_news"]=($current_group["view_news"]=="yes"?"checked=\"checked\"":"");
          $current_group["edit_news"]=($current_group["edit_news"]=="yes"?"checked=\"checked\"":"");
		  $current_group["trusted"]=($current_group["trusted"]=="yes"?"checked=\"checked\"":"");
		  $current_group["moderate_trusted"]=($current_group["moderate_trusted"]=="yes"?"checked=\"checked\"":"");
          $current_group["delete_news"]=($current_group["delete_news"]=="yes"?"checked=\"checked\"":"");
          $current_group["view_forum"]=($current_group["view_forum"]=="yes"?"checked=\"checked\"":"");
          $current_group["edit_forum"]=($current_group["edit_forum"]=="yes"?"checked=\"checked\"":"");
          $current_group["delete_forum"]=($current_group["delete_forum"]=="yes"?"checked=\"checked\"":"");
          $current_group["sfdownload"]=($current_group["sfdownload"]=="yes"?"checked=\"checked\"":"");
          $current_group["show_ad"]=($current_group["show_ad"]=="yes"?"checked=\"checked\"":"");
          $current_group["fstyle"]=($current_group["fstyle"]=="yes"?"checked=\"checked\"":"");
          $current_group["speers"]=($current_group["speers"]=="yes"?"checked=\"checked\"":"");
          #######################################################
          # view/edit/delete shout, comments
          
          $current_group["view_shout"]=($current_group["view_shout"]=="yes"?"checked=\"checked\"":"");
          $current_group["edit_shout"]=($current_group["edit_shout"]=="yes"?"checked=\"checked\"":"");
          $current_group["delete_shout"]=($current_group["delete_shout"]=="yes"?"checked=\"checked\"":"");

          $current_group["view_comments"]=($current_group["view_comments"]=="yes"?"checked=\"checked\"":"");
          $current_group["edit_comments"]=($current_group["edit_comments"]=="yes"?"checked=\"checked\"":"");
          $current_group["delete_comments"]=($current_group["delete_comments"]=="yes"?"checked=\"checked\"":"");
                  
          # End
          ####################################################### 
          $current_group["can_upload"]=($current_group["can_upload"]=="yes"?"checked=\"checked\"":"");
          $current_group["can_download"]=($current_group["can_download"]=="yes"?"checked=\"checked\"":"");
          $current_group["admin_access"]=($current_group["admin_access"]=="yes"?"checked=\"checked\"":"");
$artype ="\n<option ".(($current_group["autorank_state"]=="Enabled")?" selected=\"selected\" ":"")." value='Enabled'>Enabled</option>";
$artype.="\n<option ".(($current_group["autorank_state"]=="Disabled")?" selected=\"selected\" ":"")." value='Disabled'>Disabled</option>";

$current_group["autorank_state"]=$artype;
$current_group["forumlist"]="";
    
if($FORUMLINK=="smf")
{
    $current_group["forumlist"].=$language['AUTORANK_SMF_LIST'];
    $res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `ID_GROUP`, `groupName` FROM `{$db_prefix}membergroups` ORDER BY `ID_GROUP` ASC");
    if(@mysqli_num_rows($res)>0)
    {
        while($row=mysqli_fetch_assoc($res))
        {
            $current_group["forumlist"].=$row["groupName"] . " = " . $row["ID_GROUP"] . "<br />";
        }
    }
}

      $current_group["auto_prune"]=($current_group["auto_prune"]=="yes"?"checked=\"checked\"":"");
      
          if(substr($FORUMLINK,0,3)=="smf")
          {
              $current_group["forumlist"]=$language["SMF_LIST"];
              $res=get_result("SELECT ".(($FORUMLINK=="smf")?"`ID_GROUP` `idg`, `groupName` `gn`":"`id_group` `idg`, `group_name` `gn`")." FROM `{$db_prefix}membergroups` ORDER BY `idg` ASC", true, $btit_settings["cache_duration"]);
              if(count($res)>0)
              {
                  foreach($res as $row)
                  {
                      $current_group["forumlist"].=$row["gn"] . " = " . $row["idg"] . "<br />";
                  }
              }
              $current_group["smf_group_mirror"]=unesc($current_group["smf_group_mirror"]);
          }
          elseif($FORUMLINK=="ipb")
          {
              $current_group["forumlist"].=$language["IPB_LIST"];
              $res=do_sqlquery("SELECT * FROM `{$ipb_prefix}forum_perms` ORDER BY `perm_id` ASC",true);
              if(@mysqli_num_rows($res)>0)
              {
                  while($row=mysqli_fetch_assoc($res))
                  {
                      $current_group["forumlist"].=$row["perm_name"] . " = " . $row["perm_id"] . "<br />";
                  }
              }
              $current_group["ipb_group_mirror"]=unesc($current_group["ipb_group_mirror"]);
          }
          $admintpl->set("group",$current_group);
          break;

        case 'add':
          $admintpl->set("add_new",true,true);
          $block_title=$language["GROUP_ADD_NEW"];
          $admintpl->set("list",false,true);
          $admintpl->set("frm_action","index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=groups&amp;action=save&amp;mode=new");
          $admintpl->set("language",$language);
          $frm_dropdown="\n<select name=\"base_group\" size=\"1\">";
          $rlevel=do_sqlquery("SELECT DISTINCT id_level,predef_level FROM {$TABLE_PREFIX}users_level ORDER BY id_level",true);
          while($level=mysqli_fetch_array($rlevel))
                $frm_dropdown.="\n<option value=\"".$level["id_level"]."\">".$level["predef_level"]."</option>";
          $frm_dropdown.="\n</select>";
          $admintpl->set("groups_combo",$frm_dropdown);
          break;


        case 'save':
          if ($_POST["write"]==$language["FRM_CONFIRM"])
            {
              if (isset($_GET["mode"]) && $_GET["mode"]=="new")
                 {
                   $gid=max(0,$_POST["base_group"]);
                   $gname=sqlesc($_POST["gname"]);
                   $rfields=get_result("SELECT * FROM {$TABLE_PREFIX}users_level WHERE id=$gid",true);
                   // we have unique record, set the first and unique to our array
                   $rfields=$rfields[0];
                   unset($rfields["autorank_state"]);
                   unset($rfields["autorank_position"]);
                   unset($rfields["autorank_min_upload"]);
                   unset($rfields["autorank_minratio"]);
                   unset($rfields["autorank_smf_group_mirror"]);

                   foreach($rfields as $key=>$value)
                          if ($key!="id" && $key!="level" && $key!="can_be_deleted") $fields[]=$key;
                   do_sqlquery("INSERT INTO {$TABLE_PREFIX}users_level (can_be_deleted,level,".implode(",",$fields).") SELECT 'yes',$gname,".implode(",",$fields)." FROM {$TABLE_PREFIX}users_level WHERE id=$gid",true);
                    $lid=((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
                   $cres=do_sqlquery("SELECT id from {$TABLE_PREFIX}categories",true);
                   while ($crow = mysqli_fetch_row($cres))
                        do_sqlquery("INSERT INTO {$TABLE_PREFIX}categories_perm SET catid='$crow[0]',levelid=$lid,viewcat='no',viewtorrlist='no',viewtorrdet='no',downtorr='no'",true);
                   unset($crow);
                   ((mysqli_free_result($cres) || (is_object($cres) && (get_class($cres) == "mysqli_result"))) ? true : false);
                   unset($fields);
                   unset($rfields);
                 }
              else
                 {
                   $gid=max(0,$_GET["id"]);
                   $update=array();
                   $update[]="level=".sqlesc($_POST["gname"]);
                   $update[]="view_torrents=".sqlesc(isset($_POST["vtorrents"])?"yes":"no");
                   $update[]="edit_torrents=".sqlesc(isset($_POST["etorrents"])?"yes":"no");
                   $update[]="delete_torrents=".sqlesc(isset($_POST["dtorrents"])?"yes":"no");
                   $update[]="view_users=".sqlesc(isset($_POST["vusers"])?"yes":"no");
                   $update[]="edit_users=".sqlesc(isset($_POST["eusers"])?"yes":"no");
                   $update[]="delete_users=".sqlesc(isset($_POST["dusers"])?"yes":"no");
                   $update[]="view_news=".sqlesc(isset($_POST["vnews"])?"yes":"no");
                   $update[]="edit_news=".sqlesc(isset($_POST["enews"])?"yes":"no");
                   $update[]="delete_news=".sqlesc(isset($_POST["dnews"])?"yes":"no");
                   $update[]="view_forum=".sqlesc(isset($_POST["vforum"])?"yes":"no");
                   $update[]="edit_forum=".sqlesc(isset($_POST["eforum"])?"yes":"no");
                   $update[]="delete_forum=".sqlesc(isset($_POST["dforum"])?"yes":"no");
				   $update[]="trusted=".sqlesc(isset($_POST["trusted"])?"yes":"no");
	               $update[]="moderate_trusted=".sqlesc(isset($_POST["moderate_trusted"])?"yes":"no");
                   #######################################################
                   # view/edit/delete shout, comments
                    
                   $update[]="view_shout=".sqlesc(isset($_POST["vshout"])?"yes":"no");
                   $update[]="edit_shout=".sqlesc(isset($_POST["eshout"])?"yes":"no");
                   $update[]="delete_shout=".sqlesc(isset($_POST["dshout"])?"yes":"no");
                                               
                   $update[]="view_comments=".sqlesc(isset($_POST["vcomments"])?"yes":"no");
                   $update[]="edit_comments=".sqlesc(isset($_POST["ecomments"])?"yes":"no");
                   $update[]="delete_comments=".sqlesc(isset($_POST["dcomments"])?"yes":"no");
                                                 
                   # End
                   #######################################################   
                   $update[]="can_upload=".sqlesc(isset($_POST["upload"])?"yes":"no");
                   $update[]="can_download=".sqlesc(isset($_POST["down"])?"yes":"no");
                   $update[]="admin_access=".sqlesc(isset($_POST["admincp"])?"yes":"no");
                   $update[]="auto_prune=".sqlesc(isset($_POST["auto_prune"])?"yes":"no");
                   $update[]="sfdownload=".sqlesc(isset($_POST["sfdownload"])?"yes":"no");
                   $update[]="show_ad=".sqlesc(isset($_POST["show_ad"])?"yes":"no");
      
                   
                   $update[]="fstyle=".sqlesc(isset($_POST["fstyle"])?"yes":"no");
                   $update[]="speers=".sqlesc(isset($_POST["speers"])?"yes":"no");
                   $update[]="WT=".sqlesc($_POST["waiting"]);
				   #######################################################
                   # max torrents

                   $update[]="maxtorrents=".sqlesc($_POST["maxtorrents"]);

                   # End
                   #######################################################
                   $update[]="picture=".sqlesc($_POST["uimage"]);
      
                   $update[]="prefixcolor=".sqlesc($_POST["pcolor"]);
                   $update[]="suffixcolor=".sqlesc($_POST["scolor"]);
                   $update[]="autorank_state=".sqlesc($_POST["arstate"]);
                   $update[]="autorank_position=".((isset($_POST["arpos"]) && is_numeric($_POST["arpos"]))?$_POST["arpos"]:0);
                   $update[]="autorank_min_upload=".((isset($_POST["arminup"]) && is_numeric($_POST["arminup"]))?$_POST["arminup"]:0);
                   $update[]="autorank_minratio=".((isset($_POST["arminratio"]) && is_numeric($_POST["arminratio"]))?$_POST["arminratio"]:"0.00");
                   $update[]="autorank_smf_group_mirror=".((isset($_POST["arsmfmirr"]) && is_numeric($_POST["arsmfmirr"]))?$_POST["arsmfmirr"]:0);

                   if(substr($FORUMLINK,0,3)=="smf")
                       $update[]="smf_group_mirror=".((int)0+$_POST["smf_group_mirror"]);
                   elseif($FORUMLINK=="ipb")
                       $update[]="ipb_group_mirror=".((int)0+$_POST["ipb_group_mirror"]);
                   $strupdate=implode(",",$update);
                   do_sqlquery("UPDATE {$TABLE_PREFIX}users_level SET $strupdate WHERE id=$gid",true);
                   unset($update);
                   unset($strupdate);
                 }
                
            }

            // we don't break, so now we read ;)

        case '':
        case 'read':
        default:

          $block_title=$language["USER_GROUPS"];
          $admintpl->set("list",true,true);
          $admintpl->set("group_add_new","<a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=groups&amp;action=add\">".$language["INSERT_USER_GROUP"]."</a>");
          $admintpl->set("language",$language);
          $rlevel=do_sqlquery("SELECT * from {$TABLE_PREFIX}users_level ORDER BY id ASC",true);
          $groups=array();
          $i=0;
          while ($level=mysqli_fetch_array($rlevel))
            {
                $groups[$i]["user"]="<a href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=groups&amp;action=edit&amp;id=".$level["id"]."\">".unesc($level["prefixcolor"]).unesc($level["level"]).unesc($level["suffixcolor"])."</a>";
                $groups[$i]["torrent_aut"]=$level["view_torrents"]."/".$level["edit_torrents"]."/".$level["delete_torrents"];
                $groups[$i]["users_aut"]=$level["view_users"]."/".$level["edit_users"]."/".$level["delete_users"];
                $groups[$i]["news_aut"]=$level["view_news"]."/".$level["edit_news"]."/".$level["delete_news"];
                $groups[$i]["forum_aut"]=$level["view_forum"]."/".$level["edit_forum"]."/".$level["delete_forum"];
                #######################################################
                # view/edit/delete shout, comments
                
                $groups[$i]["shout_aut"]=$level["view_shout"]."/".$level["edit_shout"]."/".$level["delete_shout"];
                $groups[$i]["comments_aut"]=$level["view_comments"]."/".$level["edit_comments"]."/".$level["delete_comments"];
                  
                # End
                ####################################################### 
                $groups[$i]["can_upload"]=$level["can_upload"];
                $groups[$i]["can_download"]=$level["can_download"];
				$groups[$i]["trusted"]=$level["trusted"];
	            $groups[$i]["moderate_trusted"]=$level["moderate_trusted"];
                $groups[$i]["admin_access"]=$level["admin_access"];
                $groups[$i]["auto_prune"]=$level["auto_prune"];
                $groups[$i]["stat_count"]=$level["sfdownload"];
                $groups[$i]["show_ad"]=$level["show_ad"];
      
                
                $groups[$i]["fstyle"]=$level["fstyle"];
                $groups[$i]["speers"]=$level["speers"];
                $groups[$i]["WT"]=$level["WT"];
	            #######################################################
                # max torrents

                $groups[$i]["maxtorrents"]=$level["maxtorrents"];

                # end
                #######################################################
                $groups[$i]["picture"]=$level["picture"];
      
                if(substr($FORUMLINK,0,3)=="smf")
                    $groups[$i]["smf_group_mirror"]=$level["smf_group_mirror"];
                elseif($FORUMLINK=="ipb")
                    $groups[$i]["ipb_group_mirror"]=$level["ipb_group_mirror"];
                $groups[$i]["delete"]=($level["can_be_deleted"]=="no"?"No":"<a onclick=\"return confirm('".AddSlashes($language["DELETE_CONFIRM"])."')\" href=\"index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=groups&amp;action=delete&amp;id=".$level["id"]."\">".image_or_link("$STYLEPATH/images/delete.png","",$language["DELETE"])."</a>");
                $groups[$i]["arpos"]=(($level["autorank_state"]=="Disabled")?$language["NA"]:$level["autorank_position"]);
                $groups[$i]["arstate"]=$level["autorank_state"];
                $groups[$i]["arupdowntrig"]=(($level["autorank_state"]=="Disabled")?$language["NA"]:makesize($level["autorank_min_upload"]));
                $groups[$i]["arratiotrig"]=(($level["autorank_state"]=="Disabled")?$language["NA"]:$level["autorank_minratio"]);
                $groups[$i]["arsmfmirr"]=$level["autorank_smf_group_mirror"];

                $i++;
          }

          unset($level);
          ((mysqli_free_result($rlevel) || (is_object($rlevel) && (get_class($rlevel) == "mysqli_result"))) ? true : false);

          $admintpl->set("groups",$groups);

}

?>