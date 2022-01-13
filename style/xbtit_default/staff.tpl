<p>
  <table align='center' width='98%'>
    <tr>
      <td class='lista'><tag:language.STAFF_HEADER /></td>
    </tr>
  </table>
</p>
<p>
  <table align='center' width='98%'>
    <tr>
      <td class='header' align='center'><tag:language.AVATAR /></td>
      <td class='header' align='center'><tag:language.PM /></td>
      <td class='header' align='center'><tag:language.NICKNAME /></td>
      <td class='header' align='center'><tag:language.RANK /></td>
      <td class='header' align='center'><tag:language.COUNTRY /></td>
      <td class='header' align='center'><tag:language.USER_JOINED /></td>
      <td class='header' align='center'><tag:language.ONLINE_STATUS /></td>
    </tr>
    <loop:user>
      <tag:user[] />
    </loop:user>
 </table>
 <if:sup>
 <table class="header" width="90%" align="center">
  <tr>
  <center><td class='header' colspan ='7' align='center'> Our Support Team</td></center><br />
  <tr />
  <tr>
    <td class="header" align='center'><center>Username</center></td>
    <td class="header" align='center' ><center>Pm</center></td>
    <td class="header" align='center'><center>Support Language</center></td>
    <td class="header" width="60%">Give Support For:</td>
  </tr>
  <loop:help>
  <tr>
    <td class="lista" align='center'><center><tag:help[].username /></center></td>
    <td class="lista" align='center'><center><tag:help[].pm /></center></td>
    <td class="lista" align='center'><center><tag:help[].helplang /></center></td>
    <td class="lista"><tag:help[].helped /></td>
  </tr>
  </loop:help>
</table>
 </if:sup>
</p>