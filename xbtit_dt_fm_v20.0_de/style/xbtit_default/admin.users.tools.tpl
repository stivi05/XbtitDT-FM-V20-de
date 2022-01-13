<script type="text/javascript">
function convert() {
// gb
  if (Math.round(document.users.downloaded.value)>1073741824)
     document.users.lbldown.value=Math.round(document.users.downloaded.value/1073741824*100)/100 + ' GB';
// mb
  else if (Math.round(document.users.downloaded.value)>1048576)
     document.users.lbldown.value=Math.round(document.users.downloaded.value/1048576*100)/100 + ' MB';
// kb
  else if (Math.round(document.users.downloaded.value)>1024)
     document.users.lbldown.value=Math.round(document.users.downloaded.value/1024*100)/100 + ' KB';
  else
     document.users.lbldown.value=Math.round(document.users.downloaded.value*100)/100 + ' B';


// gb
  if (Math.round(document.users.uploaded.value)>1073741824)
     document.users.lblup.value=Math.round(document.users.uploaded.value/1073741824*100)/100 + ' GB';
// mb
  else if (Math.round(document.users.uploaded.value)>1048576)
     document.users.lblup.value=Math.round(document.users.uploaded.value/1048576*100)/100 + ' MB';
// kb
  else if (Math.round(document.users.uploaded.value)>1024)
     document.users.lblup.value=Math.round(document.users.uploaded.value/1024*100)/100 + ' KB';
  else
     document.users.lblup.value=Math.round(document.users.uploaded.value*100)/100 + ' B';

  if (Math.round(document.users.downloaded.value)>0)
     document.users.lblratio.value=(Math.round(document.users.uploaded.value)/Math.round(document.users.downloaded.value)*100)/100;

}

</script>
<if:edit_user>
<form name="users" method="post" action="<tag:profile.frm_action />">
  <table width="100%" border="0" class="lista">
    <tr>
      <td align="left" class="header"><tag:language.USER_NAME />:</td>
      <td align="left" class="lista"><input type="text" size="40" name="username" maxlength="100" value="<tag:profile.username />"/><tag:imm />&nbsp;Donor&nbsp;<input type="checkbox" name="donor" <tag:profile.donor /> /></td>
      <td align="left" class="lista" rowspan="5"><div align="center"><tag:profile.avatar /></div></td>
    </tr>
	<tr>
      <td align="left" class="header"><label for="chpass"><tag:language.MNU_UCP_CHANGEPWD /></label></td>
      <td align="left" class="lista">
        <tag:language.SECSUI_ACC_PWD_1A /><br />
        <li><tag:language.SECSUI_ACC_PWD_2 /> <span style="color:blue;font-weight:bold;"><tag:pass_min_char /></span> <if:pass_char_plural><tag:language.SECSUI_ACC_PWD_3A /><else:pass_char_plural><tag:language.SECSUI_ACC_PWD_3 /></if:pass_char_plural></li>
        <if:pass_lct_set><li><tag:language.SECSUI_ACC_PWD_4 /> <span style="color:blue;font-weight:bold;"><tag:pass_min_lct /></span> <if:pass_lct_plural><tag:language.SECSUI_ACC_PWD_5A /><else:pass_lct_plural><tag:language.SECSUI_ACC_PWD_5 /></if:pass_lct_plural></li></if:pass_lct_set>
        <if:pass_uct_set><li><tag:language.SECSUI_ACC_PWD_4 /> <span style="color:blue;font-weight:bold;"><tag:pass_min_uct /></span> <if:pass_uct_plural><tag:language.SECSUI_ACC_PWD_6A /><else:pass_uct_plural><tag:language.SECSUI_ACC_PWD_6 /></if:pass_uct_plural></li></if:pass_uct_set>
        <if:pass_num_set><li><tag:language.SECSUI_ACC_PWD_4 /> <span style="color:blue;font-weight:bold;"><tag:pass_min_num /></span> <if:pass_num_plural><tag:language.SECSUI_ACC_PWD_7A /><else:pass_num_plural><tag:language.SECSUI_ACC_PWD_7 /></if:pass_num_plural></li></if:pass_num_set>
        <if:pass_sym_set><li><tag:language.SECSUI_ACC_PWD_4 /> <span style="color:blue;font-weight:bold;"><tag:pass_min_sym /></span> <if:pass_sym_plural><tag:language.SECSUI_ACC_PWD_8A /><else:pass_sym_plural><tag:language.SECSUI_ACC_PWD_8 /></if:pass_sym_plural></li></if:pass_sym_set>
        <input type="checkbox" name="chpass" id="chpass" /><input type="text" size="30" name="pass" maxlength="37" value="" />
      </td>
    </tr>
    <tr>
      <td align="left" class="header"><tag:language.USER_EMAIL /></td>
      <td align="left" class="lista"><input type="text" size="30" name="email" maxlength="30" value="<tag:profile.email />"/></td>
    </tr>
    <tr>
      <td align="left" class="header"><tag:language.AVATAR_URL /></td>
      <td align="left" class="lista"><input type="text" size="40" name="avatar" maxlength="100" value="<tag:profile.avatar_field />"/></td>
    </tr>
    <tr>
      <td align="left" class="header"><tag:language.USER_LEVEL />:</td>
      <td align="left" class="lista"><tag:rank_combo /></td>
    </tr>

        <tr>
          <td align="left" class="header"><tag:language.CUSTOM_TITLE />:</td>
          <td align="left" class="lista"><input type="text" size="40" name="custom_title" maxlength="50" value="<tag:profile.custom_title />"/></td>
        </tr>

<tr>
      <td align="left" class="header">Give Support</td>
      <td align="left" class="lista"><input type="checkbox" name="helpdesk" <tag:profile.helpdesk /> /></td>
    </tr> 
    <tr>
      <td align="left" class="header">Support For:</td>
      <td align="left" class="lista"><input type="text" size="40" name="helped" maxlength="50" value="<tag:profile.helped />"/></td>
    </tr>
        <tr>
      <td align="left" class="header">Support Language:</td>
      <td align="left" class="lista"><input type="text" size="40" name="helplang" maxlength="50" value="<tag:profile.helplang />"/></td>
    </tr> 
	  <tr>
      <td align="left" class="header">User Images Settings Start</td>
      </tr> 
    
     <tr>
      <td align="left" class="header"><tag:profile.donimg />&nbsp;&nbsp;<tag:profile.donat />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="dona" <tag:profile.donai /> /></td>
    </tr> 
    
         <tr>
      <td align="left" class="header"><tag:profile.donbimg />&nbsp;&nbsp;<tag:profile.donbt />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="donb" <tag:profile.donbi /> /></td>
    </tr> 
    
    <tr>
      <td align="left" class="header"><tag:profile.bdimg />&nbsp;&nbsp;<tag:profile.birtt />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="birt" <tag:profile.birti /> /></td>
    </tr> 
    
        <tr>
      <td align="left" class="header"><tag:profile.malimg />&nbsp;&nbsp;<tag:profile.malt />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="mal" <tag:profile.mali /> /></td>
    </tr> 
    
        <tr>
      <td align="left" class="header"><tag:profile.femimg />&nbsp;&nbsp;<tag:profile.femt />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="fem" <tag:profile.femi /> /></td>
    </tr> 
    
        
        <tr>
      <td align="left" class="header"><tag:profile.banimg />&nbsp;&nbsp;<tag:profile.bant />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="bann" <tag:profile.bani /> /></td>
    </tr> 
    
        <tr>
      <td align="left" class="header"><tag:profile.warimg />&nbsp;&nbsp;<tag:profile.wart />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="war" <tag:profile.wari /> /></td>
    </tr> 
    
    <tr>
      <td align="left" class="header"><tag:profile.parimg />&nbsp;&nbsp;<tag:profile.part />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="par" <tag:profile.pari /> /></td>
    </tr> 
    
        <tr>
      <td align="left" class="header"><tag:profile.botimg />&nbsp;&nbsp;<tag:profile.bott />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="bot" <tag:profile.boti /> /></td>
    </tr>
	
	<tr>
      <td align="left" class="header"><tag:profile.trmuimg />&nbsp;&nbsp;<tag:profile.trmut />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="trmu" <tag:profile.trmui /> /></td>
    </tr> 
    
        <tr>
      <td align="left" class="header"><tag:profile.trmoimg />&nbsp;&nbsp;<tag:profile.trmot />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="trmo" <tag:profile.trmoi /> /></td>
    </tr> 
    
    	<tr>
      <td align="left" class="header"><tag:profile.vimuimg />&nbsp;&nbsp;<tag:profile.vimut />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="vimu" <tag:profile.vimui /> /></td>
    </tr> 
    
        <tr>
      <td align="left" class="header"><tag:profile.vimoimg />&nbsp;&nbsp;<tag:profile.vimot />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="vimo" <tag:profile.vimoi /> /></td>
    </tr>
    
        	<tr>
      <td align="left" class="header"><tag:profile.friendimg />&nbsp;&nbsp;<tag:profile.friendt />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="friend" <tag:profile.friendi /> /></td>
    </tr> 
    
        <tr>
      <td align="left" class="header"><tag:profile.junkieimg />&nbsp;&nbsp;<tag:profile.junkiet />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="junkie" <tag:profile.junkiei /> /></td>
    </tr>
    
    <tr>
      <td align="left" class="header"><tag:profile.staffimg />&nbsp;&nbsp;<tag:profile.stafft />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="staff" <tag:profile.staffi /> /></td>
    </tr> 
    
        <tr>
      <td align="left" class="header"><tag:profile.sysopimg />&nbsp;&nbsp;<tag:profile.sysopt />:</td>
      <td align="left" class="lista" colspan="2"><input type="checkbox" name="sysop" <tag:profile.sysopi /> /></td>
    </tr>
	
	        <tr>
      <td align="left" class="header">User Images Settings End</td>
      </tr>  
	  <tr>
      <td align="left" class="header"><tag:language.USER_LANGUE />:</td>
      <td align="left" class="lista"><tag:language_combo /></td>
    </tr>
    <tr>
      <td align="left" class="header">Download:</td>
      <td align="left" class="lista"><input type="checkbox" name="allowdownload" <tag:profile.allowdownload /> /></td>
    </tr> 
    <tr>
      <td align="left" class="header">Upload:</td>
      <td align="left" class="lista"><input type="checkbox" name="allowupload" <tag:profile.allowupload /> /></td>

    </tr>
        <tr>
      <td align="left" class="header">Block Comment:</td>
      <td align="left" class="lista"><input type="checkbox" name="block_comment" <tag:profile.block_comment /> /></td>
    </tr>
    <tr>
      <td align="left" class="header"><tag:language.UPLOADED />/<tag:language.DOWNLOADED />:</td>
      <td align="left" class="lista" colspan="2">
        <input type="text" size="18" name="uploaded" onkeyup="convert()" maxlength="18" value="<tag:profile.uploaded />"/>
        &nbsp;&nbsp;/&nbsp;&nbsp;<input type="text" size="18" name="downloaded" maxlength="18" onkeyup="convert()" value="<tag:profile.downloaded />"/>
        &nbsp;&nbsp;(<input name="lblup" size="10" readonly="readonly" value="<tag:profile.up />" />&nbsp;&nbsp;/&nbsp;&nbsp;<input name="lbldown" size="10" readonly="readonly" value="<tag:profile.down />" />)
        &nbsp;&nbsp;<tag:language.RATIO />:<input name="lblratio" size="10" readonly="readonly" value="<tag:profile.ratio />" />
      </td>
    </tr>
    <tr>
      <td align="left" class="header"><tag:language.SEEDBONUS />:</td>
      <td align="left" class="lista" colspan="2"><input type="text" size="7" name="seedbonus" maxlength="6" value="<tag:profile.seedbonus />"/></td>
    </tr>
    <tr>
      <td align="left" class="header"><tag:language.USER_STYLE />:</td>
      <td align="left" class="lista" colspan="2"><tag:style_combo /></td>
    </tr>
    <tr>
			<td align="left" class="header">Team:</td>
			<td align="left" class="lista" colspan="2"><tag:team_combo /></td>
		</tr>
    <tr>
      <td align="left" class="header"><tag:language.PEER_COUNTRY />:</td>
      <td align="left" class="lista" colspan="2"><select name="flag"><option value="0">--</option><tag:flag_combo /></select></td>
    </tr>
    <tr>
      <td align="left" class="header"><tag:language.TIMEZONE />:</td>
      <td align="left" class="lista" colspan="2"><tag:tz_combo /></td>
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
			<td align="left" class="header">Forum banned</td>
			<td align="left" class="lista" colspan="2"><input type="checkbox" name="forumbanned" value="<tag:profile.forumbanned />"></td>
		</tr>
	  <tr>
			<td align="left" class="header">Shoutbox banned</td>
			<td align="left" class="lista" colspan="2"><input type="checkbox" name="sbox" <tag:profile.sbox /> /></td>
		</tr>
		
    <tr>
      <td align="left" class="header"><tag:language.TORRENTS_PER_PAGE />:</td>
      <td align="left" class="lista" colspan="2"><input type="text" size="3" name="torrentsperpage" maxlength="3" value="<tag:profile.torrentsperpage />"/></td>
      
    </tr>
    <tr>
      <td align="center" class="header" colspan="3">
        <input type="submit" class="btn" name="confirm" value="<tag:language.FRM_CONFIRM />" />
        &nbsp;&nbsp;<input type="submit" class="btn" name="confirm" value="<tag:language.FRM_CANCEL />" />
      </td>
    </tr>
  </table>
</form>
<else:edit_user>
<table class="lista" width="100%">
  <tr>
    <td class="header"><tag:language.USER_NAME /></td>
    <td class="lista"><tag:profile.username /></td>
  </tr>
  <tr>
    <td class="header"><tag:language.LAST_IP /></td>
    <td class="lista"><tag:profile.last_ip /></td>
  </tr>
  <tr>
    <td class="header"><tag:language.USER_LEVEL /></td>
    <td class="lista"><tag:profile.level /></td>
  </tr>
  <tr>
    <td class="header"><tag:language.USER_JOINED /></td>
    <td class="lista"><tag:profile.joined /></td>
  </tr>
  <tr>
    <td class="header"><tag:language.USER_LASTACCESS /></td>
    <td class="lista"><tag:profile.lastaccess /></td>
  </tr>
  <tr>
    <td class="header"><tag:language.DOWNLOADED /></td>
    <td class="lista"><tag:profile.downloaded /></td>
  </tr>
  <tr>
    <td class="header"><tag:language.UPLOADED /></td>
    <td class="lista"><tag:profile.uploaded /></td>
  </tr>
  <tr>
    <td align="center" class="header" colspan="3">
      <input type="submit" class="btn" name="confirm" onclick="<tag:profile.confirm_delete />" value="<tag:language.FRM_CONFIRM />" />
      &nbsp;&nbsp;<input type="submit" class="btn" onclick="<tag:profile.return />" name="confirm" value="<tag:language.FRM_CANCEL />" />
    </td>
  </tr>
</table>
</if:edit_user>