<if:saved><tag:saved /></if:saved>
<form action="<tag:frm_action />" name="stuffsave" method="post">
<table class="lista" width="50%" align="center">
<tr> 

      <td class="header" align="center" colspan="4"><center>Send a welcome message and information to users who have just registered.</center></td>
    </tr>
<tr>
      <td class="header">Subject</td><td class="lista" colspan="3"><input type="text" name="welcome_sub" value="<tag:stuff.SUB />" size="40" /></td></tr>
<tr>
      <td class="header">Message</td>
      <td class="lista" colspan="3"><tag:stuff.MSG /></td>
    </tr><tr>
<td class="header" align=center></td>
<td class="header" align=center><center>
<input type="submit" name="usersave" class="btn" value="<tag:language.FRM_CONFIRM />" /></center></td>
</tr>
</table>
</form>
