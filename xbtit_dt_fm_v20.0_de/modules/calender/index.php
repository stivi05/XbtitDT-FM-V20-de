<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam 
//
//    This file is part of xbtit DT FM 
//
//    Birthday calender by DiemThuy 1/8/2014
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

$year= date("Y");

?>
<html>
<head><link rel="stylesheet" href="modules/calender/SimpleCalendar.css" /></head>
<body>
<center>
<?php
require_once('SimpleCalendar.php');
$calendar = new donatj\SimpleCalendar();
echo date('M Y'); 
echo "<br><br>";
$calendar->setStartOfWeek('Sunday');
$res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username, dob  FROM {$TABLE_PREFIX}users where MONTH(dob)=".date('n'));
while($row=mysqli_fetch_assoc($res))
{
$parts = explode('-', $row["dob"]);

$dobday=$parts[1];
$dobmonth=$parts[2];

$name=$row["username"];

$calendar->addDailyHtml( "Birthday: <br>".$name."","".$year."-".$dobday."-".$dobmonth."" );
}
$calendar->show(true);
?>
</center>
<?php
$module_out=ob_get_contents();
ob_end_clean();
?>