<table class="header" width="100%" align="center">
 <tr>
    <td class="header"><center><b>Username</b></center></td>
    <td class="header"><center><b>Joined</b></center></td>
    <td class="header"><center><b>Last online</b></center></td>
    <td class="header"><center><b>PM</b></center></td>
 </tr>
  <loop:connect>
  <tr>
    <td class="lista"><tag:connect[].Username /></td>
    <td class="lista"><center><tag:connect[].IP /></center></td>
    <td class="lista"><center><tag:connect[].Failed /></center></td>
    <td class="lista"><center><tag:connect[].pm /></center></td>
  </tr>
  </loop:connect>
</table>