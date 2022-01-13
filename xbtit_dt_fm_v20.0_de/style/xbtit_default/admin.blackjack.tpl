<p>
<if:firstview>
<table width=33%>
  <tr>
    <form method="post" action="index.php?page=admin&amp;user=<tag:uid />&amp;code=<tag:random />&amp;do=blackjack">
    <td class="header"><tag:language.BLACKJACK_STAKE />:</td>
    <td class="lista"><center><input type="text" size="6" name="stake" maxlength="4" value="<tag:bj_blackjack_stake />"/></center></td>
  </tr>
  <tr>
    <td class="header"><tag:language.BLACKJACK_PRIZE />:</td>
    <td class="lista"><center><input type="text" size="2" name="bprize" maxlength="5" value="<tag:bj_blackjack_prize />"/> <font size='2'>to 1</font></center></td>
  </tr>
  <tr>
    <td class="header"><tag:language.NORMAL_PRIZE />:</td>
    <td class="lista"><center><input type="text" size="2" name="nprize" maxlength="5" value="<tag:bj_normal_prize />"/> <font size='2'>to 1</font></center></td>
  </tr>
  <tr>
    <td class="header" colspan="2" align="center"><input type="submit" value="<tag:language.UPDATE />" name="action"></td>
  </tr>
</table>
<tag:language.BLACKJACK_INFO />
<else:firstview>
<tag:language.BLACKJACK_UPDATED />
</if:firstview>
</p><br />