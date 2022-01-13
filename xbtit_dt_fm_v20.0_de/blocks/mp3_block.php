<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT fM.
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

?>
<!-- Location of javascript. -->
<script language="javascript" type="text/javascript" src="jscript/swfobject.js" ></script>

<!-- Div that contains player. -->
<div id="player">
<h1>No flash player!</h1>
<p>It looks like you don't have flash player installed. <a href="http://www.macromedia.com/go/getflashplayer" >Click here</a> to go to Macromedia download page.</p>
</div>
<center>
<!-- Script that embeds player. -->
<script language="javascript" type="text/javascript">
var so = new SWFObject("flashmp3player.swf", "player", "170", "200", "9"); // Location of swf file. You can change player width and height here (using pixels or percents).
so.addParam("quality", "high");
so.addVariable("content_path","mp3"); // Location of a folder with mp3 files (relative to php script).
so.addVariable("color_path","default.xml"); // Location of xml file with color settings.
so.addVariable("script_path","flashmp3player.php"); // Location of php script.
so.write("player");
</script></center>