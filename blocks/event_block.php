<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//  Event Block with ACP by DiemThuy aug 2009
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

global $btit_settings ;

if (!$CURUSER || $CURUSER["view_torrents"]=="no")
   {
       // do nothing
   }
else
   {

if ($btit_settings["event_sw"]==true)
{
$today = time();

$month = $btit_settings["event_month"];
$day = $btit_settings["event_day"];
$event = mktime(0,0,0,$month,$day,date("Y"));

$apart = $event - $today;

if ($apart >= -86400)
{
  $myevent = $event;
}

else
{
  $myevent = mktime(0,0,0,$month,$day,date("Y")+1);
}

$countdown = round(($myevent - $today)/86400);

  print("<table class=\"lista\" width=\"100%\" align=\"center\" cellpadding=\"4\" cellspacing=\"4\">");

if ($countdown > 1)
{
  print ("<tr><td align=\"center\"><font color = \"red\"><b>$countdown </font>days </b></td></tr>\n");
  print ("<tr><td align=\"center\"><b>until <font color =\"green\">$btit_settings[event]</font></b></td></tr>\n");
}

elseif (($myevent-$today) <= 0 && ($myevent-$today) >= -86400)
{
 print ("<tr><b><td align=\"center\"><font color = \"blue\">$btit_settings[event] <font color = \"red\">Today!</font></b></td></tr>");
}

else
{
  print ("<tr><td align=\"center\"><font color = \"red\"><b>$countdown </font>days </b></td></tr>");
  print ("<tr><td align=\"center\"><b>until <font color =\"green\">$btit_settings[event]</font></b></tr></td>");
}
  print("</table>");
}
else
print("<center>No Events ATM</center>");
}
?>