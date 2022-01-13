<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
// Low Ratio and Ban System hack by DiemThuy - Juni 2010
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

	          $r2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE rat_warn_level!=0 OR bandt='yes' ORDER BY rat_warn_time DESC LIMIT 10" ) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

while ($arr=mysqli_fetch_assoc($r2))
{

 $res4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor , suffixcolor , level  FROM {$TABLE_PREFIX}users_level WHERE id ='$arr[id_level]'");
 $arr4 = mysqli_fetch_assoc($res4); 
 $name = "<a href='index.php?page=userdetails&id=".$arr["id"]."'> ".$arr4[prefixcolor].$arr[username].$arr4[sufixcolor]."</a>";

$wt=$arr["rat_warn_level"];

echo "<table class=lista border=0 align=center width=130>";
if ($arr["bandt"]=='no')
{
echo "<tr><td width=15% class=lista ><font color=orange><b>warn x".$wt.":</b> ".$name."<img src=\"images/warnlr.png \" /></td></tr>";
}
else
{
echo "<tr><td width=15% class=lista ><font color=red><b>banned :<b></font> ".$name."<img src=\"images/banlr.png \" /></td></tr>";	
}

echo"</td></tr></table>";
}
?>