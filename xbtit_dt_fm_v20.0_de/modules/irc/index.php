<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//// Flash IRC by DiemThuy 13/12/2014
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
      

$nick=$CURUSER["username"];

$channel=$btit_settings['irc_channel'];
$port=$btit_settings['irc_port'];
$server=$btit_settings['irc_server'];
$lang=$btit_settings['irc_lang'];

function serviceAvailable($host,$port) {
  $socket = @fsockopen($ip, $port, $errno, $errstr, 1);
  if ($socket) {
    fclose($socket);
    return true;
  }
  else {
    return false;
  }
}

if(serviceAvailable($server,$port)){
  echo $server."<b><font color=red> Is Offline</font></b>";
}
else {
  echo $server."<b><font color=green>  Is Online</font></b>";
} 

?>
<br /><br />
<iframe src="<?php echo $BASEURL; ?>/lightIRC?host=<?php echo $server; ?>&autojoin=%23<?php echo $channel; ?>&language=<?php echo $lang; ?>&showNickSelection=false&styleURL=css%2Fblack.css&nick=<?php echo $nick; ?>&port=<?php echo $port; ?>" style="width:800px; height:400px;"></iframe>
<?php


// module end
$module_out=ob_get_contents();
ob_end_clean();
?>