<form method="post" name="rename" action="<tag:ren.frm_action />">
  <table class="lista" width="100%" align="center">
    <tr>
      <td class="header" align="right" width="35%"><tag:language.CURR_NICK />:</td><td class="lista"><tag:ren.username /></td>
    </tr>
    <tr>
      <td class="header" align="right" width="35%"><tag:language.NEW_NICK />:</td><td class="lista"><input type="text" name="nick1" value="" maxlength="40" size="32"></td>
    </tr>
    <tr>
      <td class="header" align="right" width="35%"><tag:language.REPEAT_NICK />:</td><td class="lista"><input type="text" name="nick2"  value="" maxlength="40" size="32"></td>
    </tr>
    <tr>
      <td class="header" align="right" width="35%"><tag:language.IMAGE_CODE />:</td><td class="lista" align="left"><input type="text" name="private_key" value="" maxlength="6" size="7"><tag:ren.imagecode /></td>
    </tr>

    <tr>
      <td align="center" class="header" colspan="2">
    <table align="center" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><input type="submit" class="btn" name="confirm" value="<tag:language.FRM_CONFIRM />"/></td>
        <td align="center"><input type="button" class="btn" name="confirm" onclick="javascript:window.open('<tag:ren.frm_cancel />','_self');" value="<tag:language.FRM_CANCEL />"/></td>
      </tr>
    </table>
      </td>
    </tr>
  </table>
</form>
