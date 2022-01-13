<tag:pager_top />
<form method="post" action="index.php?page=takedelreport">
	<table width="95%" class="lista" align="center">
		<tr>
			<td align="center" class="header"><tag:language.REP_BY /></td>
			<td align="center" class="header"><tag:language.REP_REPORTING /></td>
			<td align="center" class="header"><tag:language.REP_TYPE /></td>
			<td align="center" class="header"><tag:language.REP_REASON /></td>
			<td align="center" class="header"><tag:language.REP_DEALT_WITH /></td>
			<td align="center" class="header"><tag:language.REP_MARK /></td>
			<if:MOD>
				<td align="center" class="header"><tag:language.DELETE /></td>
			</if:MOD>
		</tr>
		<loop:report>
			<tr>
				<td align="center" class="lista"><center><tag:report[].squealer /></center></td>
				<td align="center" class="lista"><center><tag:report[].reporting /></td></center>
				<td align="center" class="lista"><center><tag:report[].type /></center></td>
				<td align="center" class="lista"><center><tag:report[].reason /></center></td>
				<td align="center" class="lista"><b><center><tag:report[].dealtwith /></b></center></td>
				<td align="center" class="lista"><center><input type="checkbox" name="markreport[]" value="<tag:report[].reportid />" /></center></td>
				<if:MOD_DEL>
					<td align="center" class="lista"><center><input type="checkbox" name="delreport[]" value="<tag:report[].reportid />" /></center></td>
				</if:MOD_DEL>
			</tr>
		</loop:report>
		<tr><td align="center" class="lista" colspan="<tag:cols />"><center><input type="submit" value="confirm" /></center></td></tr>
	</table>
</form>
<tag:pager_bottom />
