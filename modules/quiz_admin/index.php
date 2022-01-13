<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
////  xbtit quiz by DiemThuy 01/08/2014
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

ob_start();

if (!defined("IN_BTIT"))
      die("non direct access!");

if (!$CURUSER || $CURUSER["id_level"] < 6) // 6 is default id_level for moderators
{
  err_msg("Sorry...", "You are not authorized to view this.");
  stdfoot();
  die;
}

if($_POST["do"]=="quiz")
{
$question=$_POST["question"];

$opt1=$_POST["opt1"];
$opt2=$_POST["opt2"];
$opt3=$_POST["opt3"];
$opt4=$_POST["opt4"];
$woptcode=$_POST["woptcode"];
$temp=1;
$query="select * from {$TABLE_PREFIX}quiz ";
$result=mysqli_query($GLOBALS["___mysqli_ston"], $query);
while ($row = mysqli_fetch_array($result)) {
$temp=$temp+1;
}
$query="insert into {$TABLE_PREFIX}quiz values($temp,'$question','$opt1','$opt2','$opt3','$opt4','$woptcode')";
$result=mysqli_query($GLOBALS["___mysqli_ston"], $query);
echo "successfully Saved";
}
?>
<form method="post" action="index.php?page=modules&amp;module=quiz_admin">
<table>
<tr><td colspan="2" id="heading">Online Quiz Test Question Entry Module</td>
</tr>
<tr>
<td>Enter Question here </td>
<td><input type="text" name="question" id="gunjan-textbox"/></td>
</tr>
<tr>
<td>Enter First option</td>
<td><input type="text" name="opt1" id="gunjan-textbox" /></td>
</tr>
<tr>
<td>Enter Second option</td>
<td><input type="text" name="opt2" id="gunjan-textbox" /></td>
</tr>
<tr>
<td>Enter Third option</td>
<td><input type="text" name="opt3" id="gunjan-textbox" /></td>
</tr>
<tr>
<td>Enter Fourth option</td>
<td><input type="text" name="opt4" id="gunjan-textbox" /></td>
</tr>
<tr>
<td>Select Right Option code</td>
<td><select name="woptcode" id="gunjan-textbox">
<option value="a">A</option>
<option value="b">B</option>
<option value="c">C</option>
<option value="d">D</option>
</select>
</td>

</tr>
<tr>
<td colspan="2">
<input type="hidden" name="do" value="quiz" /><input type="submit" value="SAVE QUESTION" />
</td>
</tr>
</table>
</form>

<?php
$module_out=ob_get_contents();
ob_end_clean();
?>