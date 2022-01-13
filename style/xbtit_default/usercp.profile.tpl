<script>
function updateuserbar(id)
{
	switch (id.value)
	{
<tag:js_userbar />
	}
	document.getElementById('userbar').src=img;
}
</script>

 	<link href="jscript/date/css/ui-darkness/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
	<script src="jscript/date/js/jquery-1.10.2.js"></script>
	<script src="jscript/date/js/jquery-ui-1.10.4.custom.min.js"></script>

<script>
$(function() {
$("#datepicker").datepicker({  changeMonth: true,
changeYear: true, yearRange: "1940:2016" , dateFormat: "dd-mm-yy" }).val()
});
</script>

<form name="utente" method="post" action="<tag:profile.frm_action />">
  <table width="100%" border="0" class="lista">
    <tr>
      <td align="left" class="header"><tag:language.USER_NAME />:</td>
      <td align="left" class="lista"><tag:profile.username /><tag:profile.deluser /></td>
  <if:AVATAR>
      <td class="lista" align="center" valign="top" rowspan="3"><tag:profile.avatar /></td>
  </if:AVATAR>
    </tr>    <tr>
      <td align="left" class="header"><tag:language.DOB />:</td>
  <if:DOBEDIT> 
  <td align="left" class="lista"><input type="text" id="datepicker" name="datepicker"></td>
  <else:DOBEDIT>
     <td align="left" class="lista"><input type="text" size="8" name="datepicker"  value="<tag:profile.dobday />-<tag:profile.dobmonth />-<tag:profile.dobyear />" readonly />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<tag:language.DOB_FORMAT /></td>
  </if:DOBEDIT> 
   </tr>
   <tr>
      <td align="left" class="header"><tag:language.GENDER /></td>
      <td align="left" class="lista" colspan="2"><tag:profile.gender /></td>
    </tr>
    <tr>
        <td align="left" class="header">Profile Status</td>
		<td align="left" class="lista"><fieldset><legend><strong>Status update</strong></legend>
        <div id="current_holder">
       <small style="font-weight:bold;">Share your status</small>
       <textarea name="status" id="status" cols="50" rows="4"></textarea>
       <div style="width:380px;">
       <div style="clear:both;"></div></div>
       </fieldset></td>
	</tr>
    <tr>
      <td align="left" class="header"><tag:language.AVATAR_URL /></td>
      <td align="left" class="lista"><input type="text" size="40" name="avatar" maxlength="100" value="<tag:profile.avatar_field />"/></td>
    </tr>
    <tr>
      <td align="left" class="header"><tag:language.USER_EMAIL />:</td>
      <td align="left" class="lista"><input type="text" size="30" name="email" maxlength="50" value="<tag:profile.email />"/></td>
    </tr>
  <if:USER_VALIDATION>
    <tr>
      <td align="left" class="header"></td>
      <td align="left" class="lista" colspan="2"><tag:language.REVERIFY_MSG /></td>
    </tr>
  </if:USER_VALIDATION>
    <tr>
      <td align="left" class="header"><tag:language.PROFILEVIEW />:</td>
      <td align="left" class="lista"><tag:language.PR_SHOW />: <input name="profileview" id="profileview" type="radio" value="0"<if:show_profile> checked="checked"</if:show_profile>/>
<tag:language.PR_HIDE />: <input name="profileview" id="profileview" type="radio" value="1"<if:hide_profile> checked="checked"</if:hide_profile>/></td>
    </tr>
    
           <tr>
          <td align=left class="header"><tag:language.APARKED />: </td>
          <td align="left" class="lista" colspan="2"><tag:profile.parked /></td>
     </tr>

  
    <if:hide_language_visible>
    <tr>
      <td align="left" class="header"><tag:language.USER_LANGUE />:</td>
      <td align="left" class="lista" colspan="2"><select name="language"><tag:lang.language_combo /></select></td>
    </tr>
    </if:hide_language_visible>
    <if:hide_style_visible>
    <tr>
      <td align="left" class="header"><tag:language.USER_STYLE />:</td>
      <td align="left" class="lista" colspan="2"><select name="style"><tag:style.style_combo /></select></td>
    </tr>
    </if:hide_style_visible>
    
   
    <tr>
      <td align="left" class="header"><tag:language.PEER_COUNTRY />:</td>
      <td align="left" class="lista" colspan="2"><select name="flag"><option value="0">--</option><tag:flag.flag_combo /></select></td>
    </tr>
<tr>
    <td align="left" class="header">Email Notification PM:</td>
    <td class="lista"><input type="checkbox" name="emailnot" <tag:emailnot_checked />/></td>
  </tr>
  

  
      <tr>
    <td align="left" class="header">Hide online statues:</td>
    <td class="lista"><input type="checkbox" name="invisible" <tag:invisible_checked />/></td>
  </tr>
  
      <tr>
    <td align="left" class="header">Show Porn ?</td>
    <td class="lista"><input type="checkbox" name="showporn" <tag:showporn_checked />/></td>
  </tr>
  
    <tr>
      <td align="left" class="header"><tag:language.TIMEZONE />:</td>
      <td align="left" class="lista" colspan="2"><select name="timezone"><tag:tz.tz_combo /></select></td>
    </tr>
      <tr>
      <td align="left" class="header"><tag:language.NEWUSERBAR />:</td>
      <td align="left" class="lista" colspan="2"><tag:profile.newuserbar /></td>
    </tr>
<if:INTERNAL_FORUM>
    <tr>
      <td align="left" class="header"><tag:language.TOPICS_PER_PAGE />:</td>
      <td align="left" class="lista" colspan="2"><input type="text" size="3" name="topicsperpage" maxlength="3" value="<tag:profile.topicsperpage />"/></td>
    </tr>
    <tr>
      <td align="left" class="header"><tag:language.POSTS_PER_PAGE />:</td>
      <td align="left" class="lista" colspan="2"><input type="text" size="3" name="postsperpage" maxlength="3" value="<tag:profile.postsperpage />"/></td>
    </tr>
</if:INTERNAL_FORUM>
    <tr>
      <td align="left" class="header"><tag:language.TORRENTS_PER_PAGE />:</td>
      <td align="left" class="lista" colspan="2"><input type="text" size="3" name="torrentsperpage" maxlength="3" value="<tag:profile.torrentsperpage />"/></td>
    </tr>
    <tr>
      <td align="left" class="header"><tag:language.COMMENTPM />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="commentpm" value="commentpm" <tag:profile.commentpm /> /></td>
    </tr>
    <!-- Password confirmation required to update user record -->
    <tr>
        <td align="left" class="header"><tag:language.USER_PWD />: </td>
        <td align="left" class="lista" colspan="2"><input type="password" size="40" name="passconf" value=""/><tag:language.MUST_ENTER_PASSWORD /></td>
    </tr>
    <!-- Password confirmation required to update user record -->
    <tr>
      <td align="center" class="header" colspan="3">
    <table align="center" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><input type="submit" class="btn" name="confirm" value="<tag:language.FRM_CONFIRM />" /></td>
        <td align="center"><input type="button" class="btn" name="confirm" onclick="javascript:window.open('<tag:profile.frm_cancel />','_self');" value="<tag:language.FRM_CANCEL />" /></td>
      </tr>
    </table>
      </td>
    </tr>
  </table>
</form>