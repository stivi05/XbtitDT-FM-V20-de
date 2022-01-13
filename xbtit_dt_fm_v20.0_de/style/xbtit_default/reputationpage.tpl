<br><center><H1><font color = red >Reputation System Explanation</font></H1></center>
<center>Beside auto system control , all users can add or take away points in Userdetails , see picture <br><br><img style="border:6px double #545565;"  src='images/rep/plusmin.jpg'></center>

<br><br><center><b>How you get or lose reputation points</b></center>


  <table class=lista width="60%" align="center">
  <tr>
    <td class=header align=center width="40%"><center>How</center></td>
    <td class=header align=center width="20%"><center>Points</center></td>
   </tr>
      <tr>
   <td class=lista align=center width="40%">New Users Start With</center></td>
    <td class=lista align=center width="20%"><center><tag:new /></center></td>
  </tr>
   <tr>
   <td class=lista align=center width="40%">Make a Shout</td>
    <td class=lista align=center width="20%"><center><tag:shout /></center></td>
  </tr>
     <tr>
    <td class=lista align=center width="40%">Make a Torrent Comment</td>
    <td class=lista align=center width="20%"><center><tag:comment /></center></td>
  </tr>
    <tr>
   <td class=lista align=center width="40%">Make a Forum Post</td>
    <td class=lista align=center width="20%"><center><tag:post /></center></td>
  </tr>
    <tr>
   
    <td class=lista align=center width="40%">Thanks for a Torrent</td>
    <td class=lista align=center width="20%"><center><tag:thanks /></center></td>
  </tr>
<tr>
   <td class=lista align=center width="40%">Upload a Torrent</td>
    <td class=lista align=center width="20%"><center><tag:upload /></center></td>
  </tr>

      <tr>
   <td class=lista align=center width="40%">Donate</td>
    <td class=lista align=center width="20%"><center><tag:donate /></center></td>
  </tr>
    </tr>
    <tr>
   <td class=lista align=center width="40%">Low Ratio</td>
    <td class=lista align=center width="20%"><center>-<tag:hit /></center></td>
  </tr>
    <tr>
   <td class=lista align=center width="40%">Hit & Run</td>
    <td class=lista align=center width="20%"><center>-<tag:hitt /></center></td>
  </tr>
     <tr>
   <td class=lista align=center width="40%">Staff can give or take</td>
    <td class=lista align=center width="20%"><center><tag:admin /></center></td>
  </tr>
    <tr>
   <td class=lista align=center width="40%">Users can give or take </td>
    <td class=lista align=center width="20%"><center><tag:users /></center></td>
  </tr>
</table>
<br><center><b>reputation levels</b></center>

  <table class=lista width="60%" align="center">
    <tr>
    <td class=header align=center width="40%"><center>Reputation Level</center></td>
    <td class=header align=center width="20%"><center>Points</center></td>
   </tr>
   
      <tr>
   <td class=lista align=left width="40%"><img src='images/rep/reputation_balance.gif'>&nbsp;&nbsp;<tag:no_level /></td>
    <td class=lista align=left width="20%">0</td>
  </tr>
        <tr>
   <td class=lista align=left width="40%"><img src='images/rep/reputation_pos.gif'>&nbsp;&nbsp;<tag:good /></td>
    <td class=lista align=left width="20%">Between 1 and 100</td>
  </tr>
          <tr>
   <td class=lista align=left width="40%"><img src='images/rep/reputation_highpos.gif'>&nbsp;&nbsp;<tag:best /></td>
    <td class=lista align=left width="20%">101 or higher</td>
  </tr>
            <tr>
   <td class=lista align=left width="40%"><img src='images/rep/reputation_neg.gif'>&nbsp;&nbsp;<tag:bad /></td>
    <td class=lista align=left width="20%">Between -1 and - 100</td>
  </tr>
            <tr>
   <td class=lista align=left width="40%"><img src='images/rep/reputation_highneg.gif'>&nbsp;&nbsp;<tag:worse /></td>
    <td class=lista align=left width="20%">-101 and lower</td>
  </tr>
  </table>

<br><center><b><font color = steelblue >You&nbsp;-&nbsp;&nbsp;<tag:user />&nbsp;&nbsp;-&nbsp;&nbsp;collected&nbsp;&nbsp;<tag:points /><font color = steelblue >&nbsp;&nbsp;reputation points sofar</font><b></center><br>

<table class="header" width="60%" align="center"> <tr>
<center><td class="header"  width="30%" align="center"><b>Best Users</b></td></center>
<center><td class="header"  width="30%" align="center"><b>Worse Users</b></td></center>
</tr></table>
<table class="header" width="60%" align="center">
<tr>
<td class="header" width="15%"><b>Username</b></td>
    <td class="header" width="15%"><b>Points</b></td>
    <td class="header" width="15%"><b>Username</b></td>
    <td class="header" width="15%"><b>Points</b></td>
</tr>
  <loop:usershigh>
<tr>
    <td class="lista"><tag:usershigh[].username /></td>
    <td class="lista"><tag:usershigh[].reputation /></td>
    <td class="lista"><tag:usershigh[].usernamew /></td>
    <td class="lista"><tag:usershigh[].reputationw /></td>
</tr>
  </loop:usershigh>
</table>
