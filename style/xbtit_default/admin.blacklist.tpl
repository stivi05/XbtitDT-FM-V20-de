<form action="<tag:frm_action />" name="add" method="post">
<table class="lista" width="100%" align="center">
<tr>
      <td class="header" colspan="4" align="center"><b>Add the Proxy IP,s to Blacklist here & look for Proxy IP,s here - klick - <tag:url /><b></td>
</tr>
<tr>
      <td class="header">Proxy IP</td>
      <td class="lista"><input type="text" name="tip" size="15" /></td>
</tr>
<tr>
      <td align="center" class="header" colspan="4">
      <input type="submit" name="write" class="btn" value="<tag:language.FRM_CONFIRM />" />&nbsp;&nbsp;&nbsp;
      <input type="submit" name="write" class="btn" value="<tag:language.FRM_CANCEL />" />
      </td>
    </tr>
  </table>
  <br />
  <table class="lista" width="100%" align="center">
    <tr>
      <td class="header"><center>Date Added</center></td>
      <td class="header"><center>IP</center></td>
      <td class="header"><center>Remove</center></td>
    </tr>
    <if:no_records>
    <tr>
      <td colspan="6" align="center">No Blacklisted IP,s Yet</td>
    </tr>
    <else:no_records>
    <loop:blacklist>
    <tr>
      <td class="lista"><center><tag:blacklist[].date /></center></td>
      <td class="lista"><center><tag:blacklist[].tip /></center></td>
      <td class="lista"><center><tag:blacklist[].remove /></center></td>
    </tr>
    </loop:blacklist>
    </if:no_records>
  </table>
  <br />
  <br />
</form>
