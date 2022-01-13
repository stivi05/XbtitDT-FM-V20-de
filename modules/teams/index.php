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
ob_start();
  if ($CURUSER["uid"] > 1)
    {
  if (!isset($CURUSER)) global $CURUSER;
  
echo "<table class=lista width=474 align=center><tr>";
echo "<br><center><b><font color = red ><font size=3>Teams</font></b></center><br></tr></table>";

?>
  <table class=lista width="474" align="center">
  <tr>
    <td class=header align=center width="319"><center>Team</center></td>
    <td class=header align=center width="100"><center>Owner</center></td>
   </tr>
   
<?php

            $sql="SELECT  `u`.`username`, `ul`.`prefixcolor`, `ul`.`suffixcolor`, `u`.`team` `userteam`, `t`.`id` `teamsid`, `t`.`name` `teamname`, `t`.`owner`
FROM `{$TABLE_PREFIX}teams` `t`
LEFT JOIN `{$TABLE_PREFIX}users` `u` ON `u`.`id` = `t`.`owner` 
LEFT JOIN `{$TABLE_PREFIX}users_level` `ul` ON `u`.`id_level`=`ul`.`id`
WHERE `t`.`id`!='0' ORDER BY teamname ASC";

$ripp = do_sqlquery($sql,true);

    if ($ripp)
  {
      while ($rip=mysqli_fetch_array($ripp))

      {
                    
?>

  <tr>
    <td class=header align=left width="100"><a href=index.php?page=modules&module=team&team=<?php echo $rip["teamsid"]; ?>><?php echo $rip["teamname"]; ?></a></td>
    <td class=header align=left width="319"><a href=index.php?page=userdetails&amp;id=<?php echo $rip["owner"]; ?>><?php echo stripslashes($rip["prefixcolor"].$rip["username"].$rip["suffixcolor"]); ?></a></td>
    
   </tr>
   
<?php


                }
            }
       
print("</table><br>"); 
print("<a href='javascript: history.go(-1);'>back</a>");               

}

else
    print("<div align=\"center\">\n
           <br />".$language["ERR_PERM_DENIED"]."</div>");
           
$module_out=ob_get_contents();
ob_end_clean();
?>