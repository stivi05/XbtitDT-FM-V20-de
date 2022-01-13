<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Top Uploader / Medals Block by DiemThuy Feb 2010
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
if (!$CURUSER || $CURUSER["view_torrents"]=="no")
   {
       // do nothing
   }
else
   {
global $TABLE_PREFIX,$btit_settings;

?>
<table cellpadding="4" cellspacing="1" width="100%" border="2" >

<TABLE width=100% border=0 cellspacing=1 cellpadding=1 class=forumline>
<TR>
<TD class=row1>Med</TD>
<TD class=row2>Nickname</TD>
<TD class=row3>Tor</TD>
</TR>
<?php

$time_B=(86400 * $btit_settings['UPD'] );
$time_E = strtotime(now);
$time_D =  ($time_E - $time_B);
$res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT uploader,count( * ) AS Count FROM {$TABLE_PREFIX}files WHERE UNIX_TIMESTAMP(data) > ".$time_D."  GROUP by uploader ORDER by Count DESC");
$num = mysqli_num_rows($res);

for ($i = 0; $i < $num; ++$i)
{
$fetch_U=mysqli_fetch_array($res);

$reput=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}users WHERE id =".$fetch_U['uploader']);
$setrep=mysqli_fetch_array($reput);

$reputt=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}users_level WHERE id =".$setrep['id_level']);
$setrept=mysqli_fetch_array($reputt);

if ($btit_settings['UPC']==false)
$T= $setrep['id_level']!='4';
else
$T ='';

if  ($fetch_U['Count'] < $btit_settings['UPB'] OR $T)
{}
else
{
if  ($fetch_U['Count'] >= $btit_settings['UPB'] AND $fetch_U['Count'] < $btit_settings['UPS'])
{
$upr= "<img src='images/goblet/medaille_bronze.gif' alt='Bronze Medal' title='Bronze Medal' />";
}
if ($fetch_U['Count'] >= $btit_settings['UPS'] AND $fetch_U['Count'] < $btit_settings['UPG'])
{
$upr= "<img src='images/goblet/medaille_argent.gif' alt='Silver Medal' title='Silver Medal' />";
}
ELSE if ($fetch_U['Count'] >= $btit_settings['UPG'])
{
$upr= "<img src='images/goblet/medaille_or.gif' alt='Gold Medal' title='Gold Medal' />";
}
else
{}

$namee=stripslashes($setrept[prefixcolor]) . $setrep[username] . stripslashes($setrept[suffixcolor]);
	
echo"<TR align=left><TD>$upr</TD><TD><a href=index.php?page=userdetails&id=" . $fetch_U["uploader"] . ">".$namee."</a></TD><TD>".$fetch_U["Count"]."</TD></TR>";
}
}

print("</td></tr></table>");
print ("<br><center>Upload count last ".$btit_settings['UPD']." days</center>");

}
?>