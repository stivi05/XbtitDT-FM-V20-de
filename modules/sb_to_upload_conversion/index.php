<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT DC.
//
//    upload convert by DiemThuy ( aug 2014 )
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
      
if ($CURUSER['id_level']<2)
stderr("Disabled", "Sorry , this system is until further notice disabled");      
      
$action = (isset($_GET["action"]) ? $_GET["action"] : (isset($_POST["action"]) ? $_POST["action"] : ''));

$id=$CURUSER['uid'];
$sbb=$CURUSER['seedbonus'];
$sb=number_format($CURUSER['seedbonus'],0);
$mb=($CURUSER['uploaded']/1024/1024);
$max=($sbb*1024*1024);


if ($action == 'change') 
{
$upl = $_POST['upload'];
$update=($upl);
$pay = ($upl*1024*1024);
$payy= $pay;

if (empty($upl))
stderr("Error", "We need some input !!");

if (!is_numeric($upl)) 
stderr("Error", "Input only in numbers !!");

if ($upl<0)
stderr("Error", "Seems you want to convert a negative value , you want to cheat ?? ");

if ($upl>5000)
stderr("Error", "only 5000 Seedbonus points a time max !! ");

if ($sbb<$upl)
stderr("Error", "Seems you want to convert more upload than you own !! ");
else 
{
mysqli_query($GLOBALS["___mysqli_ston"],"UPDATE {$TABLE_PREFIX}users SET seedbonus = seedbonus - $update WHERE id=$id") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
mysqli_query($GLOBALS["___mysqli_ston"],"UPDATE {$TABLE_PREFIX}users SET uploaded = uploaded + $payy WHERE id=$id") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
                                $sub=sqlesc("Seedbonus to Upload conversion confirmation");
                                $msg=sqlesc("You did exchange ".$update." Seedbonus points to ".makesize($payy)."  \n\n Use them wise");
                                send_pm(0,$id,$sub,$msg);
}
}

echo "<br><center><H1>Seedbonus to Upload conversion page</H1></center>";
echo "<br><center><H1>Rate 1 Seedbonus Point = 1 MB</H1></center>";
?>
  <table class=lista width="650" align="center">
   <tr>
    <td class=header align=center width="200"><center>Your Seedbonus</center></td>
    <td class=header align=center width="200"><center>Your Upload Amount in MB</center></td>
    <td class=header align=center width="200"><center>Max Upload to get</center></td>
   </tr>
   
    <tr>
    <td class=lista align=center width="200"><font color = "yellow"><?php echo $sb ?></td>
    <td class=lista align=center width="200"><font color = "green"><?php echo $mb ?> MB</td>
    <td class=lista align=center width="200"><font color = "yellow"><?php echo makesize($max) ?></font></td>
   </tr>
   
     <form method="post" action="index.php?page=modules&module=sb_to_upload_conversion&action=change">
     <tr>
     <td class="header" align=center >Seedbonus points to change </td>
     <td class="lista" align=center><input type="text" name="upload" size="10" /></td>
     <td class="lista" valign="middle"><center><input type="submit" class="btn" value="Change"></center></td></tr>
     <tr>
     <td class="header" colspan="3"></td>
     </tr>
     
     </form>
    
 </table>
  <table class=lista width="650" align="center"> 
  <tr><td><center><img src="images/conv.png" alt="change"/></td> </tr>  
  </table>
<?php



// module end
$module_out=ob_get_contents();
ob_end_clean();
?>