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
global $btit_settings;

$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT searchedfor FROM {$TABLE_PREFIX}searchcloud ");
if (mysqli_num_rows($res) == 0 OR $btit_settings["cloud"]==FALSE)
{}
else
{
function tag_info() {
global $TABLE_PREFIX;
$result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT searchedfor, howmuch FROM {$TABLE_PREFIX}searchcloud ORDER BY howmuch DESC LIMIT 20");

while($row = mysqli_fetch_assoc($result)) {
// suck into array
$arr[$row['searchedfor']] = $row['howmuch'];
}
//sort array by key
ksort($arr);

return $arr;
}

function cloud() {
//min / max font sizes
$small = 10;
$big = 20;
//get tag info from worker function
$tags = tag_info();
//amounts
$minimum_count = min(array_values($tags));
$maximum_count = max(array_values($tags));
$spread = $maximum_count - $minimum_count;

if($spread == 0) {$spread = 1;}

$cloud_html = '';

$cloud_tags = array();

foreach ($tags as $tag => $count) {

$size = $small + ($count - $minimum_count) * ($big - $small) / $spread;
//set up colour array for font colours.
$colour_array = array('yellow','brown', 'green', 'blue', 'pink', 'red','orange', '#0099FF');
//spew out some html malarky!
$cloud_tags[] = '<a style="color:'.$colour_array[mt_rand(0, 5)].'; font-size: '. floor($size) . 'px'
. '" class="tag_cloud" href="index.php?page=torrents&amp;search=' . urlencode($tag) . '&amp;catagory=0'
. '" title="\'' . htmlentities($tag) . '\' returned a count of ' . $count . '">'
. htmlentities(stripslashes($tag)) . '</a>';
}

$cloud_html = join("\n", $cloud_tags) . "\n";

return $cloud_html;
}


?>
<style type="text/css">
.tag_cloud
{padding: 3px; text-decoration: none;
font-family: verdana; }
.tag_cloud:link { color: #0099FF; text-decoration:none;}
.tag_cloud:visited { color: #00CCFF; }
.tag_cloud:hover { color: #0000FF; background: #00CCFF; }
.tag_cloud:active { color: #0000FF; background: #FFFFFF; }
</style>


<div id="wrapper" style="width:99%;border:0;">
<?php
//print out the tag cloud

print "<center><b>";
print cloud();
print "</b></center>";
}
?>