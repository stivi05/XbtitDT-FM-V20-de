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


if (!$CURUSER || $CURUSER["admin_access"]!="yes")
   {
       err_msg(ERROR,NOT_ADMIN_CP_ACCESS);
       stdfoot();
       exit;
}
else
{
    $bootedres=do_sqlquery("SELECT id, username, addbooted, whybooted, whobooted FROM {$TABLE_PREFIX}users WHERE booted='yes' ORDER BY booted='yes' DESC $limit");
    $bootednum=mysqli_fetch_row($bootedres);
    $num2=$bootednum[0];
    $perpage=(max(0,$CURUSER["postsperpage"])>0?$CURUSER["postsperpage"]:20);
    list($pagertop, $pagerbottom, $limit) = pager($perpage, $num2, "index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=booted_users&amp;");
    
    $admintpl->set("language",$language);
    $admintpl->set("pager_top",$pagertop);
    $admintpl->set("pager_bottom",$pagerbottom);

    $booted1res=do_sqlquery("SELECT id, username, addbooted, whybooted, whobooted FROM {$TABLE_PREFIX}users WHERE booted='yes' ORDER BY booted='yes' DESC $limit");
    $booted=array();
    $i=0;

    include("$THIS_BASEPATH/include/offset.php");

    if ($booted1res)
        {
        while ($warnview=mysqli_fetch_assoc($booted1res))
            {
          $boot[$i]["username"]=$warnview["username"];
          $boot[$i]["addbooted"]=$warnview["addbooted"];
          $boot[$i]["whybooted"]=$warnview["whybooted"];
          $boot[$i]["whobooted"]=$warnview["whobooted"];
          $i++;
         }

    }

    $admintpl->set("boots",$boot);

    unset($warnview);
    ((mysqli_free_result($booted1res) || (is_object($booted1res) && (get_class($booted1res) == "mysqli_result"))) ? true : false);
    unset($booted);

}
?>