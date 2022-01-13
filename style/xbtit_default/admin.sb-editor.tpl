<if:updated>
<div align="center">
<br />
  <table border="1" width="650" cellspacing="0" cellpadding="0" style="border-color:#00C900" >
    <tr>
       <td class="success" valign="bottom" align="center">
       <tag:language.RATIO_SUCCES />
       </td>
    </tr>
    <tr>
      <td  align="center">
        <br />
        <tag:language.SB_UPDATE_SUCCES />
        <br />
        <br />        
      </td>
    </tr>
  </table>
</div>
<br />
<br />
<else:updated>
</if:updated>
<form method="post" action="<tag:frm_action />" name="ratio_change">
	<table cellspacing="0" cellpadding="5" class="lista" align="center">
		<tr>
			<td class="header" colspan="2"><tag:language.RATIO_HEADERR /></td>
		</tr>
		
		<tr>
		    <td class="header">Mass or Single: </td>
            <td class="lista">	<input type="radio" name="all" value="1">All users [ No username needed ]
								<input type="radio" name="all" value="2">One user [ Fill in username ]
		</tr>
		<tr>
			<td class="header"><tag:language.RATIO_USERNAME /></td>
			<td class="lista"><input type="text" name="username" size="40"></td>
		</tr>

		<tr>
			<td class="header"><tag:language.SB /></td>
			<td class="lista"><input type="text" name="sb" size="40"></td>
		</tr>

		<tr>
			<td class="header"><tag:language.RATIO_ACTION /></td>
			<td class="lista">	<input type="radio" name="what" value="1"><tag:language.RATIO_ADD />
								<input type="radio" name="what" value="2"><tag:language.RATIO_REMOVE />
								<input type="radio" name="what" value="3"><tag:language.RATIO_REPLACE />
			</td>
		</tr>
		<tr>
			<td class="lista" colspan="2"><center><input type="submit" value="<tag:language.FRM_CONFIRM />"></center></td>
		</tr>
	</table>
</form>