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
?>
<div id="heading"><?php echo $SITENAME; ?> Online Quiz , Welcome <?php echo $CURUSER["username"]; ?></div>
<br />
<form name="quiz" method="post" action="index.php?page=modules&amp;module=quiz">
<?php

if($_POST["do"]=="finish")
{
$rans=$_POST["rans"];
$tq=$_POST["tq"];
$seedbon=$btit_settings["quizbon"];
if ($tq==$rans AND $btit_settings["quizp"]==true)
{
do_sqlquery("UPDATE `{$TABLE_PREFIX}users` SET `seedbonus`=seedbonus+'".$seedbon."' WHERE `id`=".$CURUSER["uid"]."", true);
send_pm(0,$user,sqlesc('You have a 100% score for the Quiz!'), sqlesc("You have a 100% score for our Quiz!\n\n Congratulations , you did recieve ".$seedbon." seedbonus points !!\n\n [color=red]This is a automatic system message , so DO NOT reply ![/color]"));
}

$end=$_POST["end"];
$startposition=$_POST["startposition"];
echo "<table cellpadding='5px' align='center' style='border:1px solid silver' width='80%'
bgcolor='green'>";
echo "<tr><td>Total Question Attempt</td><td>",$tq,"</td><tr>";
echo "<tr><td>Correct Answer</td><td>",$rans,"</td></tr>";
echo "<tr><td>Wrong Answer</td><td>",$tq-$rans,"</td></tr>";
echo "<tr><td>Correct Answer Percentage</td><td>",$rans/$tq*100,"%</td></tr>";
echo "<tr><td>Wrong Answer Percenntage</td><td>",($tq-$rans)/$tq*100,"%</td></tr>";
echo "</table><br><br>";
$query="select * from {$TABLE_PREFIX}quiz where qid<='$end' and qid>='$startposition'";
echo "<table cellpadding='5px' align='center' style='border:1px
solid silver'>";
echo "<tr><th colspan='4' id='heading'>Online Quiz Test
Question</td></tr>";
$result=mysqli_query($GLOBALS["___mysqli_ston"], $query);
while ($row = mysqli_fetch_array($result)) {
echo "<tr><td>",$row[0],"</td><td colspan='2'>",$row[1],"</td></tr><tr><td></td>";
echo "<td colspan='2'>A. ",$row[2],"</td>";
echo "<td colspan='2'>B. ",$row[3],"</td></tr>";
echo "<tr><td></td><td colspan='2'>C. ",$row[4],"</td>";
echo "<td colspan='1'>D. ",$row[5],"</td></tr>";
echo "<tr><td colspan='4' align='right'
style='color:orange'>Correct option is ",strtoupper($row[6]),"</td></tr>";
echo "<tr><td colspan='4' align='right'
style='color:orange'><hr></td></tr>";
}
echo "</table>";
echo "<p align='right'><a href='#' onclick='window.print()'>Print</a></p>";
echo "<div style='visibility:hidden;display:none'>";
}

?>
<table cellpadding="5px" width="100%" style="border:1px solid silver">
<?php
$start=$_POST["start"];
$s=$_POST["startposition"];
if($start==NULL)
{
$start=$_GET["start"];
$s=$_GET["start"];
}
$useropt=$_POST["useropt"];
$qid=$_POST["qid"];
$rans=$_POST["rans"];
$name=$_POST["name"];
$totalquestion=$_POST["totalquestion"];
if($start==NULL)
$query="select * from {$TABLE_PREFIX}quiz where qid='1'";
else
{
$query="select * from {$TABLE_PREFIX}quiz where qid='$start'";
}
$result=mysqli_query($GLOBALS["___mysqli_ston"], $query);
if (!mysqli_num_rows($result)) 
echo "<tr><td>No [more] questions to answer , select [finish online test]</tr></td>";
else
while ($row = mysqli_fetch_array($result)) {
echo "<tr><td>",$row[0],"</td><td colspan='2'>",$row[1],"</td></tr><tr><td></td><td
colspan='2'><input type='radio' name='useropt' value='a' /> ",$row[2],"</td><td colspan='2'><input type='radio'
name='useropt' value='b' /> ",$row[3],"</td></tr><tr><td></td><td colspan='2'><input type='radio'
name='useropt' value='c' /> ",$row[4],"</td><td colspan='2'><input type='radio' name='useropt' value='d' />
",$row[5],"</td></tr>";
echo "<tr ><td colspan='5' align='right'><input
type='hidden' name='name' value='",$name,"'><input type='hidden' name='start' value='",$row[0]+1,"'><input
type='hidden' name='qid' value='",$row[0],"'><input type='hidden' name='startposition' value='",$s,"'><input
type='submit' value='Next Question'><input type='hidden' name='totalquestion' value='",$totalquestion+1,"'>";
echo "</td></tr>";
}
echo "<tr><td colspan='4'>";
$query="select woptcode from {$TABLE_PREFIX}quiz where qid='$qid'";
$result=mysqli_query($GLOBALS["___mysqli_ston"], $query);
while ($row = mysqli_fetch_array($result)) {
if(strcmp($row[0],$useropt)==0)
{
echo "<input type='hidden' name='rans' value='",$rans+1,"'>";
$rans=$rans+1;
}
else
echo "<input type='hidden' name='rans' value='",$rans,"'>";
}
echo "</td></tr>";
?>

</table>
<center>
<br />
<br />
</form>
<form method="post" action="index.php?page=modules&amp;module=quiz">
<input type="hidden" name="do" value="finish" />
<input type="hidden" name="rans" value="<?php echo $rans;?>" />
<input type="hidden" name="name" value="<?php echo $name;?>" />
<input type="hidden" name="tq" value="<?php echo $totalquestion;?>" />
<input type="hidden" name="end" value="<?php echo $start-1;?>" />
<input type="hidden" name="startposition" value="<?php echo $s;?>" />
<input type="submit" value="Finish Online Test" />
</form>
<?php
$module_out=ob_get_contents();
ob_end_clean();
?>