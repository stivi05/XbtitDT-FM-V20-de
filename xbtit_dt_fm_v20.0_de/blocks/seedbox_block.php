<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    -- Seedbox Stats Block v1.00( part of Auto Show Seedbox Hack ) by DiemThuy Dec 2009 --
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

global $CURUSER,$TABLE_PREFIX,$btit_settings;
if (!$CURUSER || $CURUSER["view_torrents"]=="no")
   {
    // do nothing
   }
else

$id=mysqli_query($GLOBALS["___mysqli_ston"], "select * FROM {$TABLE_PREFIX}peers WHERE ip =".$btit_settings["seedip"]);
$num=mysqli_num_rows($id);
$rowt=mysqli_fetch_array($id);

$od=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(upload_difference) as upload_difference FROM {$TABLE_PREFIX}peers WHERE ip =".$btit_settings["seedip"]." AND upload_difference !='0'");
while ($row=mysqli_fetch_array($od))
{

              if ($row['upload_difference'] > '0' && $rowt['announce_interval'] > '0')
              $transferrateUP=round(round($row['upload_difference']/$rowt['announce_interval'])/1000, 2)." KB/sec";
              else $transferrateUP="0 KB/sec";
}
?>
<table class="lista"  width="100%">
<tr><td align="center"><img src=images/seedbox.gif><td></tr></center>
<tr><td class="header" style="text-align:center;" align="center"><b>Seedbox Torrents</td></tr>
<tr><td class="lista" style="text-align:center;" align="center"><b><font color="red"><?php echo $num; ?></font></b></td></tr>
<tr><td class="header" style="text-align:center;" align="center"><b>Seedbox UP Speed</td></tr>
<tr><td style="text-align:center;" align="right"><b><font color="red"><?php echo $transferrateUP; ?></font></b></td></tr>
</tr></table>
<table align = "center" cellpadding="1" cellspacing="1" width="100%">
  <tr>

<style>

.thisclass{background-color:#41383C}

</style>
<script language="javascript">

function change(color){
var el=event.srcElement
if (el.tagName=="INPUT"&&el.type=="button")
event.srcElement.style.backgroundColor=color
}

function jumpto2(url){
window.location=url
}

</script>
<?php
if ($CURUSER["view_torrents"]=="yes")
{
?>
<form onMouseOver="change('#FFFF99')" onMouseOut="change('#0000A0')">
<td  class = "header" align="center"><input type="button" name="Button" class="thisclass" value="SB Torrents" onMouseOver="this.style.color='#3366CC'" onMouseOut="this.style.color='#993333'" onMouseDown="this.style.color='#3366CC'" style="color:#993333; font-family:Arial; font-weight:bold; font-size:;" onClick="jumpto2('index.php?page=seedbox')"></td>
</form>
<?php
}
?>
</tr></table>