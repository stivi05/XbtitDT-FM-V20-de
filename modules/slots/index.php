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

echo "<br><center><H1>Slots are the max number of active torrents per group</H1></center>";
echo "<br><center><b><font color = red >SLOTS LIST</font></b></center>";
?>
  <table class=lista width="474" align="center">
  <tr>
    <td class=header align=center width="319"><center>Group Name</center></td>
    <td class=header align=center width="100"><center>Max Slots</center></td>
   </tr>
   
<?php

  $sql="SELECT * FROM {$TABLE_PREFIX}users_level ORDER BY id_level ASC";
  $row = do_sqlquery($sql,true);

    if ($row)
  {
      while ($data=mysqli_fetch_array($row))

      {
        $users=$data["prefixcolor"] .$data["level"]. $data["sufixcolor"];
    ?>

           <tr>
          <td class=lista align=center><b><center><?php echo $users ?></center></b></td>
          <td class=lista><b><center><?php echo $data['maxtorrents'] ?></b></center></td>
            </tr>
<?php

}
?>
</table>
<?php
echo "<br><center><b><font color = red >YOUR SLOTS</font></b></center>";
?>
  <table class=lista width="474" align="center">
  <tr>
    <td class=header align=center width="319"><center>Your Group</center></td>
    <td class=header align=center width="100"><center>Your Slots</center></td>
   </tr>
<?php
  global $CURUSER;
  $uid=$CURUSER['uid'];
  $sq=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_level FROM {$TABLE_PREFIX}users WHERE id=$uid" );
  $dat=mysqli_fetch_assoc($sq);
  $so=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users_level WHERE id=$dat[id_level]" );
  $da=mysqli_fetch_assoc($so);
  $user=$da["prefixcolor"] .$da["level"]. $da["sufixcolor"];
  
    ?>
           <tr>
          <td class=lista align=center><b><center><?php echo $user ?></center></b></td>
          <td class=lista><b><center><?php echo $da['maxtorrents'] ?></b></center></td>
          </tr>
</table> </br>

<?php
}
}
else
    print("<div align=\"center\">\n
           <br />".$language["ERR_PERM_DENIED"]."</div>");
           
$module_out=ob_get_contents();
ob_end_clean();
?>