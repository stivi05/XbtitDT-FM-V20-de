<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2013  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    Speedtest , added to DT FM 7/2013
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

/* Copyright (c) 2007, Akita Noek.  All rights reserved. */

$ajaxometer_width  = 1000;
$ajaxometer_height = 600;

$max_download_size = 67108864; /* 64MB. */


if (isset($_REQUEST['len']))  { 
  $len = intval($_REQUEST['len']);
  if ($len > $max_download_size) $len = $max_download_size;


  $blk_size = 8192;
  $blk = "";
  for ($i=0; $i < $blk_size/8; ++$i) {
    $blk .= chr(rand()) . chr(rand()) . chr(rand()) . chr(rand()) . chr(rand()) . chr(rand()) . chr(rand()) . chr(rand());
  }

  while ($len > $blk_size) {
    echo $blk;
    $len -= $blk_size;
  }

  die(substr($blk, 0, $len));
}
if (isset($_REQUEST['data'])) { die ("null"); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <title>AJAXOmeter Speed Test Utility</title>
  <script type="text/javascript" src="modules/speedtest/ajaxometer.js"></script>
</head>
<body>

<!-- Cut Here (don't forget to set $ajaxometer_width and $ajaxometer_height) -->

<script language="JavaScript" type="text/javascript" src="modules/speedtest/ajaxometer.js"></script>
<script language="JavaScript">
// Boolean variable to keep track of user's SVG support
var hasSVGSupport = false;

// Boolean to determine if we need to use VB Script method or not to find SVG support
var useVBMethod = false;

/* Internet Explorer returns 0 as the number of MIME types,
   so this code will not be executed by it. This is our indication
  to use VBScript to detect SVG support.  */ 
if (navigator.mimeTypes != null && navigator.mimeTypes.length > 0) {
	if (navigator.mimeTypes["image/svg-xml"] != null)
		hasSVGSupport = true;
} else {
  try {
    new ActiveXObject("Adobe.SVGCtl");
    hasSVGSupport = true;
  } catch (e) {
    hasSVGSupport = false;
  }
}

if (/Firefox\/[2-9]./.test(navigator.userAgent)) {
		hasSVGSupport = true;
}


if (hasSVGSupport) {
  if (/Microsoft Internet Explorer/.test(navigator.appName)) {
    document.write('<embed src="modules/speedtest/ajaxometer.svg" width="<?= $ajaxometer_width;?>" height="<?= $ajaxometer_height;?>" type="image/svg+xml" />');
  } else {
    document.write('<object type="image/svg+xml" data="modules/speedtest/ajaxometer.svg" width="<?= $ajaxometer_width; ?>" height="<?= $ajaxometer_height; ?>" />');
  }
} else {
  document.write('No SVG Capabilities detected! That sucks! This speed test is MUCH prettier ');
  document.write('if you have a browser capable of SVG! You can remedy this in any one of three ways: ');
  document.write('<ol>');
  document.write('<li>Download the Adobe SVG plugin from <a href="http://www.adobe.com/svg/viewer/install/main.html">here</a>.</li>');
  document.write('<li> Download the latest version of Mozilla Firefox from <a href="http://getfirefox.com/">here</a>. </li>');
  document.write('<li> Download the latest version of Opera from <a href="http://www.opera.com/">Opera</a>.</li> ');
  document.write('</ol>');
  document.write('<div id="AJAXOmeterPlainOutput">Starting Speed Test...<br></div>');

  new AJAXOmeter(null);
}

</script>
<noscript>
  Unfortunately, your browser either doesn't have support for JavaScript, or 
  its not enabled. This speed test requires both. If you do not feel
  comfortable enabling JavaScript in your current browser for security 
  reasons, try using a more secure browser such as
  Mozilla Firefox (<a href="http://www.getfirefox.com/">http://www.getfirefox.com/</a>) or
  Opera (<a href="http://www.opera.com/">http://www.opera.com/</a>).
</noscript>

<!-- End Paste -->

</body>
</html>