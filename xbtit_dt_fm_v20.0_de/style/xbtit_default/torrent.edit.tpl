<div align="center">
  <form id="postmodify" action="<tag:torrent.link />" method="post" name="edit" enctype="multipart/form-data">
    <table class="lista">
      <tr>
        <td align="right" class="header"><tag:language.FILE /></td>
        <td class="lista"><input type="text" name="name" value="<tag:torrent.filename />" size="60" /><if:nfo><br /><tag:torrent.nfo /></if:nfo></td>
      </tr>
      <if:tag>
      <tr>
        <td align="right" class="header">Tag</td>
        <td class="lista"><input type="text" name="tag" value="<tag:torrent.tag />" size="60" /></td>
      </tr>
     </if:tag>
    <tr>
      <td align="right" class="header" >IMDB</td>
      <td class="lista" align="left"><input type="text" name="imdb" value="<tag:torrent.imdb />" size="10" maxlength="200" />&nbsp; The numbers after tt in the url.</td>
    </tr>


      <if:LEVEL_SC>
      <tr>
      <td align="right" class="header">Staff Comment</td>
      <td class="lista" align="left"><textarea name="staff_comment" rows="3" cols="45"><tag:staff_comment /></textarea></td>
      </tr>
      </if:LEVEL_SC>
      	<script language="JavaScript" type="text/javascript">
		var icon_urls = {
		"ok": "images/mod/ok.png",
		"bad": "images/mod/bad.png",
		"um": "images/mod/um.png",
		};
		function showimage()
		{
		document.images.icons.src = icon_urls[document.forms.postmodify.icon.options[document.forms.postmodify.icon.selectedIndex].value];
		}
		</script>
	
	      <tr>
	        <td align="right" class="header"><tag:language.TORRENT_MODERATION /></td>
	        <td class="lista"><tag:torrent.moder /></td>
	      </tr>
      <tr>
        <td align="right" class="header"><tag:language.INFO_HASH /></td>
        <td class="lista"><tag:torrent.info_hash /></td>
      </tr>
      

      <if:imageon>
      <tr>
      <if:uplink>
      <td align="right" class="header" ><tag:language.IMAGE /> url (<tag:language.FACOLTATIVE />):<input type="hidden" name="userfileold" value="<tag:torrent.image />" /></td>
      <td class="lista" align="left"><input type="text" value="<tag:torrent.image />" name="userfile" size="50" /></td>
      </if:uplink>
      <if:uplo>
      <td align="right" class="header" ><tag:language.IMAGE /> (<tag:language.FACOLTATIVE />):<input type="hidden" name="userfileold" value="<tag:torrent.image />" /></td>
      <td class="lista" align="left"><input type="file" name="userfile" size="15" /></td>
      </if:uplo>
      </tr>
      </if:imageon>

<tr>
        <td align="right" class="header"><tag:language.DESCRIPTION /></td>
        <td class="lista"><tag:torrent.description /></td>
      </tr>

      <if:screenon>
      <tr>
      <td class="header" align="right"  ><tag:language.SCREEN /> (<tag:language.FACOLTATIVE />):<input type="hidden" name="userfileold1" value="<tag:torrent.screen1 />" /></td>
      <td class="lista">
      <table class="lista" border="0" cellspacing="0" cellpadding="0">
      <tr>
      <if:uplinkk>
      <td class="lista" align="left"><input type="text" value="<tag:torrent.screen1 />" name="screen1" size="50" /></td>
      </tr><tr>
      <td class="lista" align="left"><input type="text" value="<tag:torrent.screen2 />" name="screen2" size="50" /></td>
      </tr><tr>
      <td class="lista" align="left"><input type="text" value="<tag:torrent.screen3 />" name="screen3" size="50" /></td>
      </tr>
      </if:uplinkk>
      <if:uplok>
      <td class="lista" align="left"><input type="file" name="screen1" size="5" /></td>
      <td class="lista" align="left"><input type="file" name="screen2" size="5" /></td>
      <td class="lista" align="left"><input type="file" name="screen3" size="5" /></td>
      </if:uplok>
      </tr>
      

</table>
      </td>
      </tr>
      </if:screenon>
    <if:edit_gold_level>
      <tr>
        <td align="right" class="header"><tag:language.GOLD_TYPE /></td>
        <td class="lista"><tag:torrent.gold /></td>
      </tr>
    </if:edit_gold_level>
      
      <tr>
        <td align="right" class="header" ><tag:language.CATEGORY_FULL /></td>
        <td class="lista"><tag:torrent.cat_combo /></td>
      </tr>
      <tag:torrent.teams_combo />
<if:upla>
       <tr>
        <td align="right" class="header" ><tag:language.LANGUAGE /></td>
              <td class="lista" align="left"><select name="language">
										<option value="0" <tag:torrent.nolang />---</option>
										<option value="1" <tag:torrent.english />English</option>
										<option value="2" <tag:torrent.french />French</option>
										<option value="3" <tag:torrent.dutch />Dutch</option>
										<option value="4" <tag:torrent.german />German</option>
										<option value="5" <tag:torrent.spanish />Spanish</option>
										<option value="6" <tag:torrent.italian />Italian</option>
										<option value="7" <tag:torrent.customlang /><tag:customlang /></option>
										<option value="8" <tag:torrent.customlanga /><tag:customlanga /></option>
										<option value="9" <tag:torrent.customlangb /><tag:customlangb /></option>
										<option value="10" <tag:torrent.customlangc /><tag:customlangc /></option>
										</select></select></td>
      </tr>
</if:upla>      
    <tr><td class="header" align="right"  ><img src="images/youtube.gif"> (optional):</td><td class="lista" align="left"> Only add the YouTube number (example AE96cK4_qBE) !!</td></tr>
    <tr>
      <td class="header" align="right" ><img src="images/youtube.gif"> Link</td>
    <td class="lista" align="left"><input type="text" name="yt" value="<tag:torrent.youtube_video />" size="50" maxlength="200" /></td>
    </tr>
      <if:LEVEL_OK>
      <tr>
        <td align="right" class="header"><tag:language.STICKY /></td>
        <td class="lista"><tag:torrent.sticky /></td>
      </tr>
      </if:LEVEL_OK>

      
<if:LEVEL_VT>
      <tr>
        <td align="right" class="header">VIP Torrent Only</td>
        <td class="lista"><tag:torrent.vip_torrent /></td>
      </tr>
      </if:LEVEL_VT>
      <tr>
        <td align=right class="header"><tag:language.SIZE /></td>
        <td class="lista" ><tag:torrent.size /></td>
      </tr>
      <tr>
        <td align=right class="header"><tag:language.ADDED /></td>
        <td class="lista" ><tag:torrent.date /></td>
      </tr>
      <tr>
        <td align=right class="header"><tag:language.DOWNLOADED /></td>
        <td class="lista" ><tag:torrent.complete /></td>
      </tr>
      <tr>
        <td align=right class="header"><tag:language.PEERS /></td>
        <td class="lista" ><tag:torrent.peers /></td>
      </tr>
    
     <tag:multie1 />
     <tag:multie2 />
     <tag:multie3 />
     <tag:multie4 />
        </table>
    <input type="hidden" name="info_hash" value="<tag:torrent.info_hash />" /><input type="hidden" name="ex_moder" value="<tag:torrent.ex_moder />" />
    <table>
      <td align="right">
            <input type="submit" class="btn" value="<tag:language.FRM_CONFIRM />" name="action" />
      </td>
      <td align="left">
            <input type="submit" class="btn" value="<tag:language.FRM_CONFIRM_VALIDATE />" name="action" />
      </td><td align="left">
            <input type="submit" class="btn" value="<tag:language.FRM_CANCEL />" name="action" />
      </td>
    </table>
  </form>
</div>
<!-- ##############################################################
        # Nfo hack -->

    <script type="text/javascript">
      function ShowHide(id,id1) {
          obj = document.getElementsByTagName("div");
          if (obj[id].style.display == 'block'){
          obj[id].style.display = 'none';
          obj[id1].style.display = 'block';
          }
          else {
          obj[id].style.display = 'block';
          obj[id1].style.display = 'none';
          }
      }
      function windowunder(link) {
        window.opener.document.location=link;
        window.close();
      }
    </script>

<!-- # End
        ########################################################## -->