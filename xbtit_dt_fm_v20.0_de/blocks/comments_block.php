<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM , by DiemThuy Jan 2009
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

        require_once ("include/functions.php");
        require_once ("include/config.php");
        require_once ("include/blocks.php");
        global $CURUSER;
        if (!$CURUSER || $CURUSER["view_torrents"]=="no")
{
        // hacking ?
}
        else
{
        block_begin("latest torrents comments");

        if(!isset($_COOKIE['lasttorrentcomment']))
{
        $data =  time();
        $expire = time() + 3600 * 24 * 7; // 7 jours
        setcookie('lasttorrentcomment', $data, $expire);
        $LastTorrentComment = 0;
}
        else
{
        $LastTorrentComment = abs(intval($_COOKIE['lasttorrentcomment']));
}

        $mq = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT comments.id, text, info_hash, added , user, users.id_level, users.id as uid FROM {$TABLE_PREFIX}comments comments LEFT JOIN {$TABLE_PREFIX}users users ON comments.user=users.username ORDER BY added DESC LIMIT 5");
        print("<table class=\"lista\" width=\"100%\" align=\"center\" cellpadding=\"4\" cellspacing=\"4\">");
        while ($rq=mysqli_fetch_assoc($mq))
{

        if ($LastTorrentComment <= strtotime($rq["added"]))
{
        $is_new = '<img alt="" src="./images/new.png" />';
}
        else
{
        $is_new='';
}
        print("<tr><td class=\"lista\">");
        if (empty($rq["text"]))
{
        print("No comments yet");
}
        else
{
        $chaine=stripslashes($rq["text"]);
        $max=60;
        if (strlen($chaine)>=$max)
{
        $chaine=substr($chaine,0,$max) . '[...]';
}
{
        $res2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT filename FROM {$TABLE_PREFIX}files WHERE info_hash='".$rq["info_hash"] ."'") or sqlerr();
        $arr2 = mysqli_fetch_assoc($res2);
        
        $res3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users_level WHERE id='".$rq["id_level"] ."'") or sqlerr();
        $arr3 = mysqli_fetch_assoc($res3);
        $post['username']=$arr3['prefixcolor'].$rq['user'].$arr3['suffixcolor'];
}
        print("<b><a href=index.php?page=torrent-details&amp;id=" . $rq["info_hash"]. ">" . $arr2["filename"] . "</a>&nbsp;".$is_new."<br>". format_comment(unesc($chaine))."</b><br>");
        print("<span style=\"font-style: italic;\">By <a href=index.php?page=userdetails&amp;id=".$rq["uid"].">".  $post['username'] . "</a>, on ".date("d/m/Y H:i:s", strtotime($rq["added"]))."</span></td>");
        print("<tr><b><td align=\"center\">" . $file["filename"]. "</td></b></tr>\n");
}
}
        print("</tr></table>");
        block_end();
}
?>