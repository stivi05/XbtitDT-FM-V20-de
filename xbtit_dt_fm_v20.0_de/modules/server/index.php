<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
////  server stats by DiemThuy 11/09/2014
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
    
?>

<div id="container">
   
        <div class="submenu" id="menu">Server Montior</div> 
        
		<div id="content">
        
        
        <div id="content_top"></div>
        <div id="content_main">  
        <div id="invisiblebox">
          <p><em><strong>  
          What tests would you like to run?</strong></em></p>
          <p><em>(Less tests will decrease script load time)</em></p>
          <FORM NAME ="form1" METHOD ="POST" ACTION ="index.php?page=modules&module=results">
            <p>&nbsp;</p>
            <p>Server IP Address
              <Input type = 'Checkbox' Name ='ch1' value ="selected" checked ="checked"
> 
            </p>
            <P>
              Server Uptime
  <Input type = 'Checkbox' Name ='ch2' value="selected" checked ="checked"
>
<P>
Average Load
<Input type = 'Checkbox' Name ='ch3' value="selected" checked ="checked"
>
<P>
Server CPU Info
<Input type = 'Checkbox' Name ='ch4' value="selected" checked ="checked"
>
<P>
Server Disk Usage
<Input type = 'Checkbox' Name ='ch5' value="selected" checked ="checked"
>
<P>
Memory Usage
<Input type = 'Checkbox' Name ='ch6' value="selected" checked ="checked"
>
<P>
Your Ping to this Server
<Input type = 'Checkbox' Name ='ch7' value="selected" checked ="checked"
>
<P>
Server Download Speed Test
<Input type = 'Checkbox' Name ='ch8' value="selected" checked ="checked"
>
<P>
<P>
<INPUT TYPE = "Submit" Name = "Submit1" VALUE = "Run the tests">
</FORM>
</div>
        </div>
        
        <div id="content_bottom"></div>
           
            <div id="footer">

                <?php 
                echo "Page generated in ". number_format(microtime(true) - $_SERVER['REQUEST_TIME']) ." seconds"; 
				?> 
          </div>
  </div>
</div>
<?php



// module end
$module_out=ob_get_contents();
ob_end_clean();
?>