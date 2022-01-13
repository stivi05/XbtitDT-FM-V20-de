<table class="header" width="100%" align="center"><br>

<tr>
  <td class="lista"><b><center>The users in this list are banned by the Ban Button , it will last till you unban the user , also this users are banned from the Announce</center><b><td>
</tr>

  
</table><br><br><table class="header" width="100%" align="center">
  
  <tr>
    <td class="header"><center><b>Username</center></b></td>
    <td class="header"><center><b>Ban Added</center></b></td>
    <td class="header"><center><b>Added By</center></b></td>
    <td class="header"><center><b>Comment</center></b></td>
    <td class="header"><center><b>IP Range Banned</center></b></td>
    <td class="header"><center><b>Del</center></b></td>
  </tr>

  <loop:banbutton_user>
  <tr>
    <td class="lista"><center><tag:banbutton_user[].username /></center></td>
    <td class="lista"><center><tag:banbutton_user[].added /></center></td>
    <td class="lista"><center><tag:banbutton_user[].by /></center></td>
    <td class="lista"><center><tag:banbutton_user[].comment /></center></td>
    <td class="lista"><center><tag:banbutton_user[].range /></center></td>
    <td class="lista"><center><tag:banbutton_user[].remove /></center></td>
  </tr>
  </loop:banbutton_user>

</table>