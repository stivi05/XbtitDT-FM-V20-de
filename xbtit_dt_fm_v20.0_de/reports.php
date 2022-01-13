<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Report torrent/user hack by DiemThuy - march 2008
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

$home = "index.php?page=reports";

$res = do_sqlquery("SELECT count(r.id) FROM {$TABLE_PREFIX}reports r") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row = mysqli_fetch_array($res);
$count = $row[0];
$perpage = 25;
list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $home . "&type=" . $_GET["type"] . "&" );

$reportstpl = new bTemplate();
$reportstpl->set("language", $language);
$reportstpl->set("pager_top", $pagertop);
$reportstpl->set("pager_bottom", $pagerbottom);
if ($CURUSER['id_level'] == 8)
{
    $reportstpl->set("cols", 7);
    $reportstpl->set("MOD", TRUE, TRUE);
    $reportstpl->set("MOD_DEL", TRUE, TRUE);
}
else
{
    $reportstpl->set("cols", 6);
    $reportstpl->set("MOD", FALSE, TRUE);
    $reportstpl->set("MOD_DEL", FALSE, TRUE);
}
$report = array();
$i = 0;

$res = do_sqlquery("SELECT 
                        r.id AS reportid, `r`.`type`, `r`.`reason`, `r`.`addedby` `addedby_id`, `ul1`.`prefixcolor` `addedby_prefixcolor`,
                        `u1`.`username` `addedby_username` , `ul1`.`prefixcolor` `addedby_suffixcolor`, `r`.`votedfor` `reporting`,
                        `ul2`.`prefixcolor` `reported_prefixcolor` , `u2`.`username` `reported_username` , `ul2`.`suffixcolor` `reported_suffixcolor` ,
                        `f`.`filename` `reported_filename` , `r`.`dealtby` `dealt_id` , `ul3`.`prefixcolor` `dealt_prefixcolor` ,
                        `u3`.`username` `dealt_username` , `ul3`.`suffixcolor` `dealt_suffixcolor`
                        FROM `{$TABLE_PREFIX}reports` `r`
                        LEFT JOIN `{$TABLE_PREFIX}users` `u1` ON `r`.`addedby` = `u1`.`id`
                        LEFT JOIN `{$TABLE_PREFIX}users_level` `ul1` ON `u1`.`id_level` = `ul1`.`id`
                        LEFT JOIN `{$TABLE_PREFIX}users` `u2` ON `r`.`votedfor` = `u2`.`id`
                        LEFT JOIN `{$TABLE_PREFIX}users_level` `ul2` ON `u2`.`id_level` = `ul2`.`id`
                        LEFT JOIN `{$TABLE_PREFIX}files` `f` ON `r`.`votedfor` = `f`.`info_hash`
                        LEFT JOIN `{$TABLE_PREFIX}users` `u3` ON `r`.`dealtby` = `u3`.`id` 
                        LEFT JOIN `{$TABLE_PREFIX}users_level` `ul3` ON `u3`.`id_level` = `ul3`.`id`
                        ORDER BY r.id desc $limit", TRUE, 60);

while($row=mysqli_fetch_assoc($res))
{
    if($row["dealt_id"]>0)
    {
        $modname="<a href=index.php?page=userdetails&amp;id=".$row["dealt_id"].">".stripslashes($row["dealt_prefixcolor"]).$row["dealt_username"].stripslashes($row["dealt_suffixcolor"])."</a>";
        $dealtwith="<span style='color:green'>".$language["YES"]." -</span> ".$modname;
    }
    else
    {
        $modname="";
        $dealtwith = "<span style='color:red'>".$language["NO"]."</span>";
    }
    $squealer="<a href=index.php?page=userdetails&amp;id=".$row["addedby_id"].">".stripslashes($row["addedby_prefixcolor"]).$row["addedby_username"].stripslashes($row["addedby_suffixcolor"])."</a>";
    $torrentname = $row["reported_filename"];
    if ($torrentname == "")
        $torrentname = "<span style='color:red'><b>".$language["DELETED"]."</b></span>";

    $report[$i]["squealer"] = $squealer;
    $report[$i]["dealtwith"] = $dealtwith;
    if($row["type"]=="torrent")
    {
        $report[$i]["reporting"] = "<a href=index.php?page=torrent-details&amp;id=".$row["reporting"]."><b>".$torrentname."</b></a>";
        $report[$i]["type"] = $language["TORRENT"];
    }
    else
    {
        $report[$i]["reporting"] = "<a href=index.php?page=userdetails&amp;id=".$row["reporting"]."><b>".$row["reported_prefixcolor"].$row["reported_username"].$row["reported_suffixcolor"]."</b></a>";
        $report[$i]["type"] = $language["USER"];
    }
    $report[$i]["reason"] = $row["reason"];
    $report[$i]["reportid"] = $row["reportid"];
    $i++;
}

$reportstpl->set("report", $report);

?>