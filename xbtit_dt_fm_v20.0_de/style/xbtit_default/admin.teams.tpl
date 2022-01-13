<table class="header" width="100%" align="center">
  <tr>
    <td class="lista" colspan="4"><tag:pager_top /></td>
  </tr>
  <tr>
    <td class="header"><b>Username</b></td>
    <td class="header"><b>Team</b></td>
    <td class="header"><b>Team Logo</b></td>
  </tr>
  <loop:teams>
  <tr>
    <td class="lista"><a href="index.php?page=userdetails&id=<tag:teams[].id />"><tag:teams[].username /></a></td>
    <td class="lista"><tag:teams[].teamname /></td>
    <td class="lista"><img border=0 src=<tag:teams[].teamimage />></td>
    
  </tr>
  </loop:teams>
  <tr>
    <td class="lista" colspan="4"><tag:pager_bottom /></td>
  </tr>
</table>
