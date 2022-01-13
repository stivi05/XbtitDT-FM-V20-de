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
      
require(load_language("lang_staff.php"));

$stafftpl= new bTemplate();
$stafftpl-> set("language",$language);

if ($CURUSER["view_users"]=="no")
{
    err_msg($language["ERROR"],$language["NOT_AUTHORIZED"]." ".strtolower($language["STAFF"])."!");
    stdfoot();
    exit;
}
else
{  
    $query ="SELECT u.id, u.username, u.avatar, UNIX_TIMESTAMP(u.joined) joined, ";
    $query.="UNIX_TIMESTAMP(u.lastconnect) lastconnect, ul.level, ul.prefixcolor, ";
    $query.="ul.suffixcolor, c.name country, c.flagpic, o.lastaction ";
    $query.="FROM {$TABLE_PREFIX}users u ";
    $query.="LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level = ul.id ";
    $query.="LEFT JOIN {$TABLE_PREFIX}countries c ON u.flag = c.id ";
    $query.="LEFT JOIN {$TABLE_PREFIX}online o ON u.id = o.user_id ";
    $query.="WHERE ul.id_level >=6 ";
    $query.="AND ul.id_level <=8 ";
    $query.="ORDER BY ul.id_level DESC, u.id ASC";
    
    $res=do_sqlquery($query);
    
    $i=0;
    while($row=mysqli_fetch_assoc($res))
    {
        ((is_null($row["avatar"]) || $row["avatar"]=="")?$avatar="<img src='$STYLEURL/images/default_avatar.gif' height=80 width=80>":$avatar="<img src='".$row["avatar"]."' height=80 width=80>");
        (is_null($row["lastaction"])?$lastseen=$row["lastconnect"]:$lastseen=$row["lastaction"]);
        ((time()-$lastseen>900)?$status="<img src='images/ooffline.gif' border='0' alt='".$language["OFFLINE"]."'>":$status="<img src='images/oonline.gif' border='0' alt='".$language["ONLINE"]."'>");
        if(is_null($row["flagpic"]))
        {
            $row["flagpic"]="unknown.gif";
            $row["country"]=$language["UNKNOWN"];
        }
      
        $member[$i] ="<tr>";
        $member[$i].="<td class='lista' width='84'><center>$avatar</center></td>";
        $member[$i].="<td class='lista'><center><a href='index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=".$CURUSER["uid"]."&amp;what=new&amp;to=".$row["username"]."'><img src='$STYLEURL/images/pm.gif'alt='".$language["PM"]."' border='0'></a></center></td>";
        $member[$i].="<td class='lista'><center><a href='index.php?page=userdetails&amp;id=".$row["id"]."'>".stripslashes($row["prefixcolor"]) . $row["username"] . stripslashes($row["suffixcolor"])."</a></center></td>";
        $member[$i].="<td class='lista'><center>".ucfirst($row["level"])."</center></td>";
        $member[$i].="<td class='lista'><center><img src='images/flag/".$row["flagpic"]."' border='0' alt='".$row["country"]."'></center></td>";
        $member[$i].="<td class='lista'><center>".date("d/m/Y H:i:s",$row["joined"])."</center></td>";
        $member[$i].="<td class='lista'><center>$status</center></td>";
        $member[$i].="</tr>";
        $i++;
    }
}
$stafftpl-> set("user",$member);

if ($btit_settings["supportsw"]==true)
{
$stafftpl->set("sup", true, true); 
 
$ress=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT u.helpdesk, u.helped, u.helplang,u.id,u.username, ul.level, ul.prefixcolor, ul.suffixcolor FROM {$TABLE_PREFIX}users u  LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level = ul.id WHERE u.helpdesk='yes'") or sqlerr();
$resx=array();
$i=0;

    if ($ress)
        {
        while ($roww=mysqli_fetch_assoc($ress))
            {
          $resx[$i]["username"]=("<a href=index.php?page=userdetails&id=".$roww["id"].">".unesc($roww["prefixcolor"]).unesc($roww["username"]).unesc($roww["suffixcolor"])."</a>");

          $resx[$i]["pm"]="<a href=\"index.php?page=usercp&amp;do=pm&amp;action=edit&amp;uid=".$CURUSER["uid"]."&amp;what=new&amp;to=".urlencode(unesc($roww["username"]))."\">".image_or_link("$STYLEPATH/images/pm.png","",$language["PM"])."</a>";
          $resx[$i]["helplang"]=$roww["helplang"];
          $resx[$i]["helped"]=$roww["helped"];
          $i++;

         }

    }

    $stafftpl->set("help",$resx);

    unset($roww);
    ((mysqli_free_result($ress) || (is_object($ress) && (get_class($ress) == "mysqli_result"))) ? true : false);
    unset($resx);
}
else
$stafftpl->set("sup", false, true); 
?>