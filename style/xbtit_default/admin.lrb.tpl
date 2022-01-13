<form name="lrba" action="<tag:frm_actiona />" method="post">
<table class="header" width="85%" align="center">

      <tr>
      <td class="header" align="center" colspan="4">Low Ratio Warning & Ban System - Overall Settings</td>
      </tr>
      <tr>
      <td class="header">Enable system</td>
      <td class="lista"><input type="checkbox" name="wb_sys" value="wb_sys" <tag:wb_button /> /></td>
     </tr>
    <tr>
      <td class="header" valign="top" colspan="1">First Warning PM</td>
      <td class="lista" colspan="3"><textarea name="wb_text_one" rows="3" cols="60"><tag:lrb.wb_text_one /></textarea></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Second Warning PM</td>
      <td class="lista" colspan="3"><textarea name="wb_text_two" rows="3" cols="60"><tag:lrb.wb_text_two /></textarea></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Final Warning PM</td>
      <td class="lista" colspan="3"><textarea name="wb_text_fin" rows="3" cols="60"><tag:lrb.wb_text_fin /></textarea></td>
      </tr>
      <tr>
    <td colspan="6" class="lista" style="text-align:center"><br><input type="submit" name="action" value="Confirm" /></td>
</tr>
</form>  

<form name="lrbb" action="<tag:frm_actionb />" method="post">      
      <tr>
      <td class="header" align="center" colspan="4">Low Ratio Warning & Ban System - User Group Settings</td>
      </tr>
      <tr>
      <td class="header">Rank ID</td>
      <td class="lista"><input type="text" name="wb_rank" size="4" /></td>
      <td class="header">Min Download To Trigger</td>
      <td class="lista"><input type="text" name="wb_down" size="4" />GB</td>
      </tr>
      <tr>
      <td class="header">First Warning Ratio</td>
      <td class="lista"><input type="text" name="wb_one"  size="4" /></td>
      <td class="header">Days For Next Warning</td>
      <td class="lista"><input type="text" name="wb_days_one"  size="4" /></td>
      </tr>
      <tr>
      <td class="header">Second Warning Ratio</td>
      <td class="lista"><input type="text" name="wb_two" size="4" /></td>
      <td class="header">Days For Next Warning</td>
      <td class="lista"><input type="text" name="wb_days_two"  size="4" /></td>
      </tr>
      <tr>
      <td class="header">Third Warning Ratio</td>
      <td class="lista"><input type="text" name="wb_three"  size="4" /></td>
      <td class="header">Days Between Last Warning And Ban</td>
      <td class="lista"><input type="text" name="wb_days_fin"  size="4" /></td>
      </tr>
      <tr>
      <td class="header">Final Ban Ratio</td>
      <td class="lista"><input type="text" name="wb_fin" size="4" /></td>
      <td class="header">Show Warn Symbol</td>
      <td class="lista"><input type="checkbox" name="wb_warn" /></td>
      </tr>

     
	<tr>
    <td colspan="6" class="lista" style="text-align:center"><br><input type="submit" name="action" value="Add New Group" /></td>
</tr>
	  </table></form>

<table class="header" width="85%" align="center"><center><b>Group Rules</b></center>

<tr>
    <td class="header" align="center">ID Level</td>
    <td class="header" align="center">Usergroup</td>
    <td class="header" align="center">Min Download</td>
    <td class="header" align="center">1e Warn Ratio</td>
    <td class="header" align="center">days to 2 warn</td>
    <td class="header" align="center">2e warn ratio</td>
    <td class="header" align="center">days to 3 warn</td>
    <td class="header" align="center">3e warn ratio</td>
    <td class="header" align="center">days to ban</td>
    <td class="header" align="center">ban ratio</td>
    <td class="header" align="center">Warn Symbol</td>
    <td class="header" align="center">Delete</td>
</tr>

<loop:hit>
<tr>
    <td class="lista"><tag:hit[].wb_rank /></td>
    <td class="lista"><tag:hit[].wb_group /></td>
    <td class="lista"><tag:hit[].min_download /></td>
    <td class="lista"><font color="red"><tag:hit[].ratio_one /></font></td>
    <td class="lista"><font color="blue"><tag:hit[].days_one /></font></td>
    <td class="lista"><font color="red"><tag:hit[].ratio_two /></font></td>
    <td class="lista"><font color="blue"><tag:hit[].days_two /></font></td>
    <td class="lista"><font color="red"><tag:hit[].ratio_three /></font></td>
    <td class="lista"><font color="blue"><tag:hit[].days_three /></font></td>
    <td class="lista"><font color="red"><tag:hit[].ratio_fin /></font></td>
    <td class="lista"><tag:hit[].warn /></td>
    <td class="lista"><tag:hit[].delete /></td>
</tr>
</loop:hit>

</table>
<table class="header" width="85%" align="center"><center><b>Warn & Ban Historie</b></center>
<tr>
    <td class="header" align="center">User</td>
    <td class="header" align="center">Usergroup</td>
    <td class="header" align="center">Warn times</td>
    <td class="header" align="center">Date</td>
    <td class="header" align="center">Warn Symbol</td>
    <td class="header" align="center">Banned</td>
    <td class="header" align="center">Unwarn</td>
    <td class="header" align="center">Unban</td>
</tr>

  <loop:list>
  <tr>
    <td class="lista"><tag:list[].username /></td>
    <td class="lista"><center><tag:list[].group /></center></td>
    <td class="lista"><font color="red"><center><tag:list[].warn /></font></center></td>
    <td class="lista"><center><tag:list[].date /></center></td>
    <td class="lista"><center><tag:list[].show /></center></td>
    <td class="lista"><center><tag:list[].ban /></center></td>
    <td class="lista"><center><tag:list[].unwarn /></center></td>
    <td class="lista"><center><tag:list[].unban /></center></td>
  </tr>
  </loop:list>
</table>