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

if (!defined("IN_BTIT"))
      die("non direct access!");
      
if (!$CURUSER || $CURUSER["id_level"] < 6) // 6 is default id_level for moderators
{
  err_msg("Sorry...", "You are not authorized to view this.");
  stdfoot();
  die;
}

?>

<?php 
include 'serverfunctions.php'; 
?>

<div id="container">


        
		<div id="content">
        
        
        <div id="content_top"></div>
        <div id="content_main"> 
   
          <table width="600" border="1">
            <tr>
              <th colspan="2" scope="col">This Server's Statistics :</th>
            </tr>
            <tr>
              <td><img src='modules/results/icons/network-icon.png' alt='Load' />Server IP Address :</td>
              <td><?php
			  if(isset($_POST['ch1']) &&
   $_POST['ch1'] == 'selected')
{
    echo get_ip();
}
else
{
    echo "Not selected";
}

?></td>
            </tr>
            <tr>
              <td><img src='modules/results/icons/up-alt-icon.png' alt='Uptime' />Server Uptime :</td>
              <td><?php
			  if(isset($_POST['ch2']) &&
   $_POST['ch2'] == 'selected')
{
echo get_uptime();
}
else
{
    echo "Not selected";
}

?></td>
            </tr>
            <tr>
              <td><img src='modules/results/icons/loaded-truck.png' alt='Load' />Average Load :</td>
              <td><?php
			  if(isset($_POST['ch3']) &&
   $_POST['ch3'] == 'selected')
{
echo get_load();
}
else
{
    echo "Not selected";
}

?></td>
            </tr>
            <tr>
              <td><img src="modules/results/icons/intel-2-icon.png" alt="CPU" />Server CPU Info :</td>
              <td><?php 
			  if(isset($_POST['ch4']) &&
   $_POST['ch4'] == 'selected')
{
echo get_cpuinfo();
}
else
{
    echo "Not selected";
}
?></td>
            </tr>
            <tr>
              <td><img src="modules/results/icons/Ekisho-Deep-Ocean-HD-1-icon.png" alt="HDD"/>Server Disk Usage :</td>
              <td><?php 
			  if(isset($_POST['ch5']) &&
   $_POST['ch5'] == 'selected')
{
echo get_hdd();
}
else
{
    echo "Not selected";
}
?></td>
            </tr>
            <tr>
              <td><img src="modules/results/icons/monitor-icon.png" alt="HDD" />Memory Usage :</td>
              <td><?php
			  if(isset($_POST['ch6']) &&
   $_POST['ch6'] == 'selected')
{
echo get_memory();
echo '%';
}
else
{
    echo "Not selected";
}
?></td>
            </tr>
            <tr>
              <td><img src="modules/results/icons/Globe-icon.png" alt="Ping"/>Your ping to this server :</td>
              <td><?php 
			  if(isset($_POST['ch7']) &&
   $_POST['ch7'] == 'selected')
{
echo get_ping();
}
else
{
    echo "Not selected";
}
?></td>
            </tr>
            <tr>
              <td><img src="modules/results/icons/down-alt-icon.png" alt="Ping"/>Server Download Speed Test :</td>
              <td><?php
			  if(isset($_POST['ch8']) &&
   $_POST['ch8'] == 'selected')
{
    echo get_speedtest(); 
}
else
{
    echo "Not selected";
}
?></td>
            </tr>
            <tr>
              <td colspan="2"><input name="Refresh" type=button id="Refresh" onclick="history.go()" value="Refresh" /></td>
            </tr>
          </table>
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