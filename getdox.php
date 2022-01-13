<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// DOX hack by DiemThuy - march 2009
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

if (!$CURUSER)
{
Header("Location: $BASEURL/");
die;
}

if(isset($_GET["filename"])) {

$filename = $_GET["filename"];

} else
die("File name missing\n");
if ( ! function_exists ( 'mime_content_type' ) )
{
   function mime_content_type ( $f )
   {
       return trim ( exec ('file -bi ' . escapeshellarg ( $f ) ) ) ;
   }
}

header("Content-Type: " . mime_content_type("./" . $DOXPATH . "/" . $filename));
header('Content-Disposition: attachment; filename="'.$filename.'"');

$filename = sqlesc($filename);
$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}dox WHERE filename=$filename") or sqlerr();
$arr = mysqli_fetch_assoc($res);

if (!$arr)
 die("Not found\n");
mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}dox SET hits=hits+1 WHERE id=$arr[id]") or sqlerr(__FILE, __LINE__);
$file = "$DOXPATH/$arr[filename]";
if (!is_file($file))
die("File not found\n");
$f = fopen($file, "rb");
if (!$f)
die("Cannot open file\n");
header("Content-Length: " . filesize($file));
do
{
$s = fread($f, 4096);
print($s);
} while (!feof($f));
closefile($f);
?>