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


if (!defined("IN_BTIT"))
      die("non direct access!");

if (!defined("IN_ACP"))
      die("non direct access!");

$admintpl->set("language",$language);
include("include/userstuff.php");

$stuff['SUB']=$GLOBALS["welcome_sub"];
$stuff['MSG']=textbbcode('stuffsave','msg',$GLOBALS['welcome_msg']);
$admintpl->set('stuff',$stuff);

$admintpl->set("frm_action","index.php?page=admin&amp;user=".$CURUSER["uid"]."&amp;code=".$CURUSER["random"]."&amp;do=usersave");

 if ($do=="usersave")
            {
            
                 @chmod("include/userstuff.php",0777);
                 // if I get an error chmod, I'll try to put change into the file
                 $fd = fopen("include/userstuff.php", "w") or die(Cant_Write_Userstuff.php);
				 $foutput ="<?php \n\n";
				 $foutput.= "\$GLOBALS[\"welcome_sub\"] = \"". $_POST["welcome_sub"]."\";\n";
				 $foutput.= "\$GLOBALS[\"welcome_msg\"] = \"". $_POST["msg"]."\";\n";
  		 		 $foutput.= "\n?>";
                 fwrite($fd,$foutput) or die(CANT_SAVE_CONFIG);
                 fclose($fd);
                 @chmod("include/userstuff.php",0744);
                 

                 $saved="<center>CONFIG SAVED</center>";
                 $admintpl->set('saved',$saved);
                 redirect("index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=userstuff");
              }               

?>