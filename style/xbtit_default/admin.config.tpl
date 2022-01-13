<script type="text/javascript" src="jscript/btit_functions.js"></script>
<form action="<tag:frm_action />" name="config" method="post" onsubmit="return test_smtp_password()">

  <table class="lista" width="100%" align="center">
    <if:config_saved>
    <tr>
      <td class="lista" align="center" colspan="4" style="color:red"><tag:language.CONFIG_SAVED /></td>
    </tr>
    </if:config_saved>
    <tr>
      <td class="header" align="center" colspan="4"><tag:language.XBTT_BACKEND /></td>
    </tr>
    <if:xbtt_error>
    <tr>
      <td class="lista" align="center" colspan="4" style="color:red; font-weight:bold;"><tag:language.XBTT_TABLES_ERROR /></td>
    </tr>
    </if:xbtt_error>
    <tr>
      <td class="header"><tag:language.XBTT_USE /></td>
      <td class="lista"><input type="checkbox" name="xbtt_use" value="xbtt_use" <tag:config.xbtt_use /> /></td>
      <td class="header"><tag:language.XBTT_URL /></td>
      <td class="lista"><input type="text" name="xbtt_url" value="<tag:config.xbtt_url />" size="30" /></td>
    </tr>
    <tr>
      <td class="header" align="center" colspan="4"><tag:language.GENERAL_SETTINGS /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.TRACKER_NAME /></td>
      <td class="lista"><input type="text" name="trackername" value="<tag:config.name />" size="60" /></td>
       <td class="header">Use SSL (needs SSL enabled on your server)</td>
      <td class="lista">&nbsp;&nbsp;Yes&nbsp;<input type="radio" name="ssl" value="true"<tag:config.sslyes /> />&nbsp;&nbsp;No&nbsp;<input type="radio" name="ssl" value="false"<tag:config.sslno /> /></td>
    </tr>
    <tr>
      <td class="header" colspan="1"><tag:language.TRACKER_BASEURL /></td>
      <td class="lista" colspan="3"><input type="text" name="trackerurl" value="<tag:config.url />" size="60" /></td>
    </tr>
    <tr>
      <td class="header" valign="top" colspan="1"><tag:language.TRACKER_ANNOUNCE /></td>
      <td class="lista" colspan="3"><textarea name="tracker_announceurl" rows="5" cols="60"><tag:config.announce /></textarea></td>
    </tr>
    <tr>
		<td height="10" valign="top"><!-- common spacer --></td>
		</tr>
		<tr>
      <td class="header"><tag:language.TRACKER_EMAIL /></td>
      <td class="lista"><input type="text" name="trackeremail" value="<tag:config.email />" size="20" /></td>
      <td class="header"><tag:language.TORRENT_FOLDER /></td>
      <td class="lista"><input type="text" name="torrentdir" value="<tag:config.torrentdir />" size="20" /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.ALLOW_EXTERNAL /></td>
      <td class="lista"><input type="checkbox" name="exttorrents" value="exttorrents" <tag:config.external /> /></td>
      <td class="header"><tag:language.ALLOW_GZIP /></td>
      <td class="lista"><input type="checkbox" name="gzip_enabled" value="gzip_enabled"  <tag:config.gzip /> /></td>
    </tr>
    <tr>
      <td class="header">Auto Announce , if Ext torrents are allowed use don,t change announce!!</td>
      <td class="lista">Change announce url,s to yours <input type="radio" name="aann" value="true"<tag:config.aannyes /> />Don,t change announce url,s to yours<input type="radio" name="aann" value="false"<tag:config.aannno /> /></td>
      <td class="header">Allow Magnet Links</td>
        <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="magnet" value="true"<tag:config.magnetyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="magnet" value="false"<tag:config.magnetno /> /></td>
      </tr>
    <tr>
      <td class="header"><tag:language.ALLOW_DEBUG /></td>
      <td class="lista"><input type="checkbox" name="show_debug" value="show_debug" <tag:config.debug /> /></td>
      <td class="header"><tag:language.ALLOW_DHT /></td>
      <td class="lista"><input type="checkbox" name="dht" value="dht" <tag:config.disable_dht /> /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.ALLOW_LIVESTATS /></td>
      <td class="lista"><input type="checkbox" name="livestat" value="livestat" <tag:config.livestat /> /></td>
      <td class="header"><tag:language.ALLOW_SITELOG /></td>
      <td class="lista"><input type="checkbox" name="logactive" value="logactive" <tag:config.logactive /> /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.ALLOW_HISTORY /></td>
      <td class="lista"><input type="checkbox" name="loghistory" value="loghistory" <tag:config.loghistory /> /></td>
      <td class="header"><tag:language.ALLOW_PRIVATE_ANNOUNCE /></td>
      <td class="lista"><input type="checkbox" name="p_announce" value="p_announce" <tag:config.p_announce /> /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.ALLOW_PRIVATE_SCRAPE /></td>
      <td class="lista"><input type="checkbox" name="p_scrape" value="p_scrape" <tag:config.p_scrape /> /></td>
      <td class="header"><tag:language.SHOW_UPLOADER /></td>
      <td class="lista"><input type="checkbox" name="show_uploader" value="show_uploader" <tag:config.show_uploader /> /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.USE_POPUP /></td>
      <td class="lista"><input type="checkbox" name="usepopup" value="usepopup" <tag:config.usepopup /> /></td>
      <td class="header"><tag:language.DEFAULT_LANGUAGE /></td>
      <td class="lista"><tag:config.language_combo /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.DEFAULT_CHARSET /></td>
      <td class="lista"><tag:config.charset_combo /></td>
      <td class="header"><tag:language.DEFAULT_STYLE /></td>
      <td class="lista"><tag:config.style_combo /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.MAX_USERS /></td>
      <td class="lista"><input type="text" name="maxusers" value="<tag:config.max_users />" size="10" /></td>
      <td class="header"><tag:language.MAX_TORRENTS_PER_PAGE /></td>
      <td class="lista"><input type="text" name="ntorrents" value="<tag:config.max_torrents_per_page />" size="10" /></td>
    </tr>
    <tr>
      <td class="header" align="center" colspan="4"><tag:language.MAILER_SETTINGS /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_MAIL_TYPE /></td>
      <td class="lista"><select id="mail_type" name="mail_type" size="1"><tag:config.mail_type_combo /></select></td>
      <td class="header"><tag:language.SETTING_SMTP_SERVER /></td>
      <td class="lista"><input type="text" id="smtp_server" name="smtp_server" value="<tag:config.smtp_server />" size="20" /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_SMTP_PORT /></td>
      <td class="lista"><input type="text" name="smtp_port" value="<tag:config.smtp_port />" size="10" /></td>
      <td class="header"><tag:language.SETTING_SMTP_USERNAME /></td>
      <td class="lista"><input type="text" id="smtp_username" name="smtp_username" value="<tag:config.smtp_username />" size="20" /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_SMTP_PASSWORD /></td>
      <td class="lista"><input type="password" id="smtp_password" name="smtp_password" value="<tag:config.smtp_password />" size="20" /></td>
      <td class="header"><tag:language.SETTING_SMTP_PASSWORD_REPEAT /></td>
      <td class="lista"><input type="password" id="smtp_pwd_repeat" name="smtp_pwd_repeat" value="<tag:config.smtp_password />" size="20" /></td>
    </tr>
    <tr>
      <td class="header" align="center" colspan="4"><tag:language.SPECIFIC_SETTINGS /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_INTERVAL_SANITY /></td>
      <td class="lista"><input type="text" name="sinterval" value="<tag:config.sanity_update />" size="10" /></td>
      <td class="header"><tag:language.SETTING_INTERVAL_EXTERNAL /></td>
      <td class="lista"><input type="text" name="uinterval" value="<tag:config.external_update />" size="10" /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_INTERVAL_MAX_REANNOUNCE /></td>
      <td class="lista"><input type="text" name="rinterval" value="<tag:config.max_announce />" size="10" /></td>
      <td class="header"><tag:language.SETTING_INTERVAL_MIN_REANNOUNCE /></td>
      <td class="lista"><input type="text" name="mininterval" value="<tag:config.min_announce />" size="10" /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_MAX_PEERS /></td>
      <td class="lista"><input type="text" name="maxpeers" value="<tag:config.max_peers_per_announce />" size="10" /></td>
      <td class="header"><tag:language.CACHE_SITE /></td>
      <td class="lista"><input type="text" name="cache_duration" value="<tag:config.cache_duration />" size="10" /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_NAT_CHECK /></td>
      <td class="lista"><input type="checkbox" name="nat" value="nat"  <tag:config.nat />/></td>
      <td class="header"><tag:language.SETTING_PERSISTENT_DB /></td>
      <td class="lista"><input type="checkbox" name="persist" value="persist"  <tag:config.persist />/></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_OVERRIDE_IP /></td>
      <td class="lista"><input type="checkbox" name="override" value="override"  <tag:config.allow_override_ip />/></td>
      <td class="header"><tag:language.SETTING_CALCULATE_SPEED /></td>
      <td class="lista"><input type="checkbox" name="countbyte" value="countbyte"  <tag:config.countbyte />/></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_VALIDATION /></td>
      <td class="lista"><tag:config.validation_combo /></td>
      <td class="header"><tag:language.SETTING_CAPTCHA /></td>
      <td class="lista"><input type="checkbox" name="imagecode" value="imagecode"  <tag:config.imagecode />/></td>
    </tr>
    
    <tr>
      <td class="header" align="center" colspan="4">New Google (no)Captcha System - get keys from https://www.google.com/recaptcha </td>
      </tr>
      <tr>
        <td class="header">Enable System</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="gcsw" value="true"<tag:config.gcswyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="gcsw" value="false"<tag:config.gcswno /> /></td>
      </tr>
      <tr>
      <td class="header">Site Key</td>
      <td class="lista"><input type="text" name="gcsitk" value="<tag:config.gcsitk />" size="45" /></td>
      <td class="header">Secret Key</td>
      <td class="lista"><input type="text" name="gcsekk" value="<tag:config.gcsekk />" size="45" /></td>
      </tr>
    
    <tr>
      <td class="header"><tag:language.SETTING_SEEDS_PID /></td>
      <td class="lista"><input type="text" name="maxseeds" value="<tag:config.maxpid_seeds />" size="10" /></td>
      <td class="header"><tag:language.SETTING_LEECHERS_PID /></td>
      <td class="lista"><input type="text" name="maxleech" value="<tag:config.maxpid_leech />" size="10" /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_CUT_LONG_NAME /></td>
      <td class="lista"><input type="text" name="cut_name" value="<tag:config.cut_name />" size="10" /></td>
      <td class="header"><tag:language.DOWNLOAD_RATIO /></td>
      <td class="lista"><input type="text" name="download_ratio" value="<tag:config.download_ratio />" size="10" /></td>
    </tr>
    <tr>
      <td class="header">Forum Type</td>
      <td class="lista" ><tag:language.SETTING_FORUM /></td>
      <td class="lista" colspan="3"><input type="text" name="f_link" value="<tag:config.forum />" size="40" />
      <if:ipb_in_use>      
      <br /><br /><table align="left"><tr><td class="header" align="center"><tag:language.IPB_AUTO_ID /></td></tr><tr><td class="lista" style="text-align:center;"><input type="text" name="ipb_autoposter" value="<tag:config.ipb_autoposter />" size="5" /></td></tr></table>
      </if:ipb_in_use>

            <tr>
               <td class="header" align="center" colspan="4"><b><tag:language.SETTINGS_UPLOAD /></b></td>
            </tr>
            <tr>
               <td class="header"><tag:language.VALUE_UPLOAD /></td>
               <td class="lista" colspan="3">
                  <input type="text" name="donate_upload" value="<tag:config.donate_upload />" size="5" maxlength="5" /><tag:config.unit_combo />
               </td>
            </tr>

         
    <tr>
      <td class="header" align="center" colspan="4"><tag:language.BLOCKS_SETTING /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_CLOCK /></td>
      <td class="lista">&nbsp;<tag:language.CLOCK_ANALOG />&nbsp;<input type="radio" name="clocktype" value="true"<tag:config.clockanalog /> />&nbsp;<tag:language.CLOCK_DIGITAL />&nbsp;<input type="radio" name="clocktype" value="false"<tag:config.clockdigital /> /></td>
      <td class="header"><tag:language.SETTING_FORUMBLOCK /></td>
      <td class="lista">&nbsp;<tag:language.FORUMBLOCK_POSTS />&nbsp;<input type="radio" name="forumblocktype" value="true"<tag:config.forumblockposts /> />&nbsp;<tag:language.FORUMBLOCK_TOPICS />&nbsp;<input type="radio" name="forumblocktype" value="false"<tag:config.forumblocktopics /> /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_NUM_NEWS /></td>
      <td class="lista"><input type="text" name="newslimit" value="<tag:config.newslimit />" size="3" maxlength="3" /></td>
      <td class="header"><tag:language.SETTING_NUM_POSTS /></td>
      <td class="lista"><input type="text" name="forumlimit" value="<tag:config.forumlimit />" size="3" maxlength="3" /></td>
    </tr>
    <tr>
      <td class="header">Limit Torrent Block</td>
      <td class="lista"><input type="text" name="last10limit" value="<tag:config.last10limit />" size="3" maxlength="3" /></td>

    </tr>        
<tr>
      <td class="header" align="center" colspan="4">Recommended setting</td>
    </tr>
      <tr>
      <td class="header">Turn on recommended</td>
      <td class="lista"><input type="checkbox" name="show_recommended" value="show_recommended" <tag:config.show_recommended /> /></td>
      <td class="header">Max displayed recommended</td>
      <td class="lista"><input type="text" name="recommended" value="<tag:config.recommended />" size="3" maxlength="3" /></td>
    </tr>
          <tr>
      <td class="header" align="center" colspan="4">Hide Style & Language & Side Blocks Selector</td>
    </tr	

  <tr>
    <td class="header"><tag:language.ACP_HIDE_STYLE /></td>
    <td class="lista">
      <select name="hide_style" style="background-color:<tag:style_color />color:#000000;"  onchange="this.style.backgroundColor=this.options[this.selectedIndex].style.backgroundColor" />
        <option value="visible" style="background-color:#00FF00;color:#000000;"<if:style_visible> selected="selected"</if:style_visible>><tag:language.ACP_VISIBLE /></option>
	    <option value="hidden" style="background-color:#FF0000;color:#000000;"<if:style_hidden> selected="selected"</if:style_hidden>><tag:language.ACP_HIDDEN /></option>
	  </select>
	</td>
    <td class="header"><tag:language.ACP_HIDE_LANGUAGE /></td>
    <td class="lista">
      <select name="hide_language" style="background-color:<tag:language_color />color:#000000;"  onchange="this.style.backgroundColor=this.options[this.selectedIndex].style.backgroundColor" />
        <option value="visible"  style="background-color:#00FF00;color:#000000;"<if:language_visible> selected="selected"</if:language_visible>><tag:language.ACP_VISIBLE /></option>
	    <option value="hidden" style="background-color:#FF0000;color:#000000;"<if:language_hidden> selected="selected"</if:language_hidden>><tag:language.ACP_HIDDEN /></option>	    
	  </select>
    </td>
</tr><tr>
    <td class="header">Hide/Unhide Side Blocks Menu</td>
    <td class="lista">
      <select name="hide_sblocks" style="background-color:<tag:sblocks_color />color:#000000;"  onchange="this.style.backgroundColor=this.options[this.selectedIndex].style.backgroundColor" />
        <option value="visible"  style="background-color:#00FF00;color:#000000;"<if:sblocks_visible> selected="selected"</if:sblocks_visible>><tag:language.ACP_VISIBLE /></option>
	    <option value="hidden" style="background-color:#FF0000;color:#000000;"<if:sblocks_hidden> selected="selected"</if:sblocks_hidden>><tag:language.ACP_HIDDEN /></option>	    
	  </select>
    </td>
  </tr>
    <tr>
      <td class="header" align="center" colspan="4"><tag:language.AUTO_PRUNE_USERS /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.ALLOW_AUTO_PRUNE /></td>
      <td class="lista">&nbsp;&nbsp;Yes&nbsp;<input type="radio" name="autopruneusers" value="true"<tag:config.autopruneusersyes /> />&nbsp;&nbsp;No&nbsp;<input type="radio" name="autopruneusers" value="false"<tag:config.autopruneusersno /> /></td>
      <td class="header"><tag:language.ALLOW_EMAIL_ON_PRUNE /></td>
      <td class="lista">&nbsp;&nbsp;Yes&nbsp;<input type="radio" name="email_on_prune" value="true"<tag:config.email_on_pruneyes /> />&nbsp;&nbsp;No&nbsp;<input type="radio" name="email_on_prune" value="false"<tag:config.email_on_pruneno /> /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.DAYS_MEMBERS /></td>
      <td class="lista"><input type="text" name="days_members" value="<tag:config.days_members />" size="40" /></td>
      <td class="header"><tag:language.DAYS_NOT_CONFIRM /></td>
      <td class="lista"><input type="text" name="days_not_comfirm" value="<tag:config.days_not_comfirm />" size="40" /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.DAYS_TO_EMAIL /></td>
      <td class="lista"><input type="text" name="days_to_email" value="<tag:config.days_to_email />" size="40" /></td>
    </tr>
    

    <tr>
      <td class="header" align="center" colspan="4"><tag:language.IMAGE_SETTING /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.ALLOW_IMAGE_UPLOAD /></td>
      <td class="lista">&nbsp;&nbsp;Yes&nbsp;<input type="radio" name="imageon" value="true"<tag:config.imageonyes /> />&nbsp;&nbsp;No&nbsp;<input type="radio" name="imageon" value="false"<tag:config.imageonno /> /></td>
      <td class="header"><tag:language.ALLOW_SCREEN_UPLOAD /></td>
      <td class="lista">&nbsp;&nbsp;Yes&nbsp;<input type="radio" name="screenon" value="true"<tag:config.screenonyes /> />&nbsp;&nbsp;No&nbsp;<input type="radio" name="screenon" value="false"<tag:config.screenonno /> /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.IMAGE_UPLOAD_DIR /></td>
      <td class="lista"><input type="text" name="uploaddir" value="<tag:config.uploaddir />" size="40" /></td>
      <td class="header"><tag:language.FILE_SIZELIMIT /></td>
      <td class="lista"><input type="text" name="file_limit" value="<tag:config.file_limit />" size="40" /></td>
    </tr>
    <tr>
    <td class="header">Upload or Link</td>
      <td class="lista">&nbsp;&nbsp;Upload&nbsp;<input type="radio" name="imgsw" value="true"<tag:config.imgswyes /> />&nbsp;&nbsp;Link&nbsp;<input type="radio" name="imgsw" value="false"<tag:config.imgswno /> /></td>
      </tr>
    <tr>
      <td class="header" align="center" colspan="4"><tag:language.AVATAR_UPLOAD /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.MAX_FILE_SIZE /></td>
      <td class="lista"><input type="text" id="img_file_size" name="img_file_size" value="<tag:config.img_file_size />" size="8" /></td>
	  <td class="header"><tag:language.MAX_IMAGE_SIZE /></td>
      <td class="lista"><tag:language.IMAGE_WIDTH /> <input type="text" id="img_size_width" name="img_size_width" value="<tag:config.img_size_width />" size="4" /> <tag:language.IMAGE_HEIGHT /> <input type="text" id="img_size_height" name="img_size_height" value="<tag:config.img_size_height />" size="4" /></td>
	</tr>
    
      <tr>
      <td class="header" align="center" colspan="4">Request Settings</td>
      </tr>
      <tr>
      <td class="header">Request hack online</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="req_onoff" value="true"<tag:config.req_onoffyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="req_onoff" value="false"<tag:config.req_onoffno /> /></td>
      <td class="header">Requests in block</td>
      <td class="lista"><input type="text" name="req_number" value="<tag:config.req_number />" size="4" /></td>
      </tr>
      <tr>
      <td class="header">Days for prune filled requests</td>
      <td class="lista"><input type="text" name="req_prune" value="<tag:config.req_prune />" size="4" /></td>
      <td class="header">Requests per page</td>
      <td class="lista"><input type="text" name="req_page" value="<tag:config.req_page />" size="4" /></td>
      </tr>
      <tr>
      <td class="header">min ID level to post requests</td>
      <td class="lista"><input type="text" name="req_post" value="<tag:config.req_post />" size="4" /></td>
      <td class="header">Announce request in shoutbox</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="req_shout" value="true"<tag:config.req_shoutyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="req_shout" value="false"<tag:config.req_shoutno /> /></td>
      </tr>
      <tr>
      <td class="header">Max requests use</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="req_maxon" value="true"<tag:config.req_maxonyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="req_maxon" value="false"<tag:config.req_maxonno /> /></td>
      <td class="header">Max number of requests</td>
      <td class="lista"><input type="text" name="req_max" value="<tag:config.req_max />" size="4" /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Request Reward ( for furfill a request ) Settings</td>
      </tr>
      <tr>
   	  <td class="header">Request reward sytem</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="req_rwon" value="true"<tag:config.req_rwonyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="req_rwon" value="false"<tag:config.req_rwonno /> /></td>
      <td class="header">Reward in upload or seedbonus</td>
      <td class="lista">&nbsp;&nbsp;bytes&nbsp;<input type="radio" name="req_sbmb" value="true"<tag:config.req_sbmbyes /> />&nbsp;&nbsp;seedbonus&nbsp;<input type="radio" name="req_sbmb" value="false"<tag:config.req_sbmbno /> /></td>
      </tr>
      <tr>
      <td class="header">Amount in bytes</td>
      <td class="lista"><input type="text" name="req_mb" value="<tag:config.req_mb />" size="6" /></td>
      <td class="header">Seedbonus points</td>
      <td class="lista"><input type="text" name="req_sb" value="<tag:config.req_sb />" size="4" /></td>
      </tr>
     
      <tr>
      <td class="header" align="center" colspan="4">Donation Historie Settings</td>
      </tr>
      <tr>
      <td class="header">Units</td>
      <td class="lista">&nbsp;&nbsp;Euro&nbsp;<input type="radio" name="dh_unit" value="true"<tag:config.dh_unityes /> />&nbsp;&nbsp;Dollar&nbsp;<input type="radio" name="dh_unit" value="false"<tag:config.dh_unitno /> /></td>
      <td class="header">Use Auto PM</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="dh_pm" value="true"<tag:config.dh_pmyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="dh_pm" value="false"<tag:config.dh_pmno /> /></td></tr>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Thank PM Text</td>
      <td class="lista" colspan="3"><textarea name="dh_text" rows="3" cols="60"><tag:config.dh_text /></textarea></td>
      </tr>
     
 <tr>
      <td class="header" align="center" colspan="4">VIP Torrent Settings</td>
      </tr>
      <tr>
      <td class="header">Min Level To Set</td>
      <td class="lista"><input type="text" name="vip_set" value="<tag:config.vip_set />" size="4" /></td>
      <td class="header" colspan="1">Level Settings</td>
      <td class="lista">&nbsp;&nbsp;One Level&nbsp;<input type="radio" name="vip_one" value="true"<tag:config.vip_oneyes /> />&nbsp;&nbsp;From Level&nbsp;<input type="radio" name="vip_one" value="false"<tag:config.vip_oneno /> /></td>
      </tr>
      <tr>
      <td class="header">If One Level</td>
      <td class="lista"><input type="text" name="vip_get_one" value="<tag:config.vip_get_one />" size="4" /></td>
      <td class="header">If From Level</td>
      <td class="lista"><input type="text" name="vip_get" value="<tag:config.vip_get />" size="4" /></td>
      </tr>
      <tr>
   	  <td class="header">None Vip Text</td>
      <td class="lista"><input type="text" name="vip_tekst" value="<tag:config.vip_tekst />" size="60" /></td>
      </tr>
     
      <tr>
      <td class="header" align="center" colspan="4">Uploader Medailles</td>
      </tr>
      <tr>
      <td class="header">how many days look back between now and ..days</td>
      <td class="lista"><input type="text" name="UPD" value="<tag:config.UPD />" size="5" /></td>
      <td class="header">Number Of Uploads - Bronze (>=)</td>
      <td class="lista"><input type="text" name="UPB" value="<tag:config.UPB />" size="5" /></td>
      </tr>
      <tr>
      <td class="header">Number Of Uploads - Silver (>=)</td>
      <td class="lista"><input type="text" name="UPS" value="<tag:config.UPS />" size="5" /></td>
      <td class="header">Number Of Uploads - Gold (>=)</td>
      <td class="lista"><input type="text" name="UPG" value="<tag:config.UPG />" size="5" /></td>
      </tr>
      <tr>
      <td class="header">Show All or only Uploaders</td>
      <td class="lista">&nbsp;&nbsp;All Ranks&nbsp;<input type="radio" name="UPC" value="true"<tag:config.UPCyes /> />&nbsp;&nbsp;Uploaders Only&nbsp;<input type="radio" name="UPC" value="false"<tag:config.UPCno /> /></td>
      </tr>
     
    <tr>
      <td class="header" align="center" colspan="4">Flush Ghosts Peers Settings</td>
      </tr>
     <tr>
      <td class="header">Clean up after Announce update + [?] Seconds</td>
      <td class="lista"><input type="text" name="ghost" value="<tag:config.ghost />" size="4" /></td>
      </tr>
     
      <tr>
      <td class="header" align="center" colspan="4"><tag:language.RHUS_HIGH_UL_SUP /></td>
      </tr>
      <tr>
      <td class="header"><tag:language.RHUS_EN_SYS /></td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="highswitch" value="true"<tag:config.highswitchyes /> />&nbsp;&nbsp;<tag:language.RHUS_DIS />&nbsp;<input type="radio" name="highswitch" value="false"<tag:config.highswitchno /> /></td>
      <td class="header"><tag:language.RHUS_REP_FROM /></td>
      <td class="lista"><input type="text" name="highspeed" value="<tag:config.highspeed />" size="20" /></td>
      </tr>
      <tr>
      <td class="header"><tag:language.RHUS_REP_TU /></td>
      <td class="lista">&nbsp;&nbsp;<tag:language.RHUS_ONLY_ONCE />&nbsp;<input type="radio" name="highonce" value="true"<tag:config.highonceyes /> />&nbsp;&nbsp;<tag:language.RHUS_NO_LIM />&nbsp;<input type="radio" name="highonce" value="false"<tag:config.highonceno /> /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Online Block Settings</td>
      </tr>
      <tr>
      <td class="header">Timeout</td>
      <td class="lista"><input type="text" name="timeout" value="<tag:config.timeout />" size="4" /></td>
      <td class="header">Avatars in Online</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="onav" value="true"<tag:config.onavyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="onav" value="false"<tag:config.onavno /> /></td></tr>
    </tr>
     <tr>
      <td class="header" align="center" colspan="4">Torrent Age Settings</td>
      </tr>
      <tr>
      <td class="header">Pictures or Days</td>
      <td class="lista">&nbsp;&nbsp;show days&nbsp;<input type="radio" name="show_days" value="true"<tag:config.show_daysyes /> />&nbsp;&nbsp;show pictures&nbsp;<input type="radio" name="show_days" value="false"<tag:config.show_daysno /> /></td></tr>
      </tr>
      <tr>
      <td class="header">Child is from</td>
      <td class="lista"><input type="text" name="child" value="<tag:config.child />" size="20" /></td>
      </tr>
      <tr>
      <td class="header">Grown is from</td>
      <td class="lista"><input type="text" name="grown" value="<tag:config.grown />" size="20" /></td>
      <td class="header">Old is from</td>
      <td class="lista"><input type="text" name="old" value="<tag:config.old />" size="20" /></td>
      </tr>
        <tr>
      <td class="header" align="center" colspan="4">Menu / Login Swich</td>
      </tr>
      <tr>
      <td class="header">Menu Type</td>
      <td class="lista">&nbsp;&nbsp;DT Menu&nbsp;<input type="radio" name="menu" value="true"<tag:config.menuyes /> />&nbsp;&nbsp;Regular Menu&nbsp;<input type="radio" name="menu" value="false"<tag:config.menuno /> /></td>
      <td class="header">Login Type</td>
      <td class="lista"><tag:config.login_combo /></td>
      </tr>
    <tr>
      
      <td class="header" align="center" colspan="4">Yupi Login Page Background Images</td>
      </tr>
      <tr>
      <td class="header">Background</td>
     <td class="lista">&nbsp;&nbsp;Rotate Images&nbsp;<input type="radio" name="logisw" value="true"<tag:config.logiswyes /> />&nbsp;&nbsp;One Image&nbsp;<input type="radio" name="logisw" value="false"<tag:config.logiswno /> /></td>
     </tr>
     <tr>
      <td class="header" align="center" colspan="4">Scrolling News</td>
      </tr>
      <tr>
      <td class="header">scroll or not </td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="nscroll" value="true"<tag:config.nscrollyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="nscroll" value="false"<tag:config.nscrollno /> /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Registration Settings</td>
      </tr>
      <tr>
      <td class="header">Close Site</td>
      <td class="lista">&nbsp;&nbsp;open&nbsp;<input type="radio" name="regi" value="true"<tag:config.regiyes /> />&nbsp;&nbsp;close&nbsp;<input type="radio" name="regi" value="false"<tag:config.regino /> /></td>
      </tr>
      <tr>
      <td class="header">Open Date</td>
      <td class="lista"><input type="text" name="regi_d" value="<tag:config.regi_d />" size="10" /><font color ="red">&nbsp;[0000-00-00][Y/M/D] must be in this format</font></td>
      <td class="header">Open Time</td>
      <td class="lista"><input type="text" name="regi_t" value="<tag:config.regi_t />" size="4" /><font color ="red">&nbsp;[00] must be in whole hours</font></td>
      </tr>
     <tr>
      <td class="header" align="center" colspan="4">Check for Duplicate IP Addresses during User Registration</td>
    </tr>
    <tr>
    <td class="header">dupipcheck yes/no</td>
     <td class="lista">&nbsp;&nbsp;Yes&nbsp;<input type="radio" name="dupip" value="true"<tag:config.dupipyes /> />&nbsp;&nbsp;No&nbsp;<input type="radio" name="dupip" value="false"<tag:config.dupipno /> /></td>
     </tr>
    <tr>
      <td class="header" align="center" colspan="4">Porn Settings</td>
      </tr>
     <tr>
      <td class="header">Min age to see porn</td>
      <td class="lista"><input type="text" name="porncat" value="<tag:config.porncat />" size="4" /></td>
      </tr>
        <tr>
      <td class="header" align="center" colspan="4">Auto Lottery Settings</td>
    </tr>
    <tr>
    <td class="header">Auto Start Lottery</td>
     <td class="lista">&nbsp;&nbsp;Yes&nbsp;<input type="radio" name="autolot" value="true"<tag:config.autolotyes /> />&nbsp;&nbsp;No&nbsp;<input type="radio" name="autolot" value="false"<tag:config.autolotno /> /></td>
     </tr>
     
     <tr>
      <td class="header" align="center" colspan="4">Offer Settings</td>
      </tr>
      <tr>
      <td class="header">Aproved after</td>
      <td class="lista"><input type="text" name="offer" value="<tag:config.offer />" size="5" /> totall pro votes</td>
    </tr>
     
      <tr>
      <td class="header" align="center" colspan="4">Ban Button Settings</td>
      </tr>
      <tr>
      <td class="header">Min Ban Level</td>
      <td class="lista"><input type="text" name="banbutton" value="<tag:config.banbutton />" size="10" /></td>
      <td class="header">Ban Days</td>
      <td class="lista"><input type="text" name="bandays" value="<tag:config.bandays />" size="10" /></td>
      </tr>
      
      <tr>
      <td class="header" align="center" colspan="4">Signup Agree Settings</td>
      </tr>
      <tr>
      <td class="header">Enable</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="ua_on" value="true"<tag:config.ua_onyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="ua_on" value="false"<tag:config.ua_onno /> /></td></tr>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Text Box One</td>
      <td class="lista" colspan="3"><textarea name="oa_one_text" rows="3" cols="60"><tag:config.oa_one_text /></textarea></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Text Box Two</td>
      <td class="lista" colspan="3"><textarea name="oa_two_text" rows="3" cols="60"><tag:config.oa_two_text /></textarea></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Text Box Three</td>
      <td class="lista" colspan="3"><textarea name="oa_three_text" rows="3" cols="60"><tag:config.oa_three_text /></textarea></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Textt Box Four</td>
      <td class="lista" colspan="3"><textarea name="oa_four_text" rows="3" cols="60"><tag:config.oa_four_text /></textarea></td>
      </tr>
     
                  <tr>
      <td class="header" align="center" colspan="4">Hit & Run Block Settings</td>
      </tr>
    <tr>
      <td class="header" valign="top" colspan="1">Scrolling Text</td>
      <td class="lista" colspan="3"><textarea name="scrol_tekst" rows="5" cols="60"><tag:config.scrol_tekst /></textarea></td>
    </tr>
    <tr>
      <td class="header">Number of Hit & Runners to show</td>
      <td class="lista"><input type="text" name="hitnumber" value="<tag:config.hitnumber />" size="4" /></td>
      </tr>
     <tr>
      <td class="header" align="center" colspan="4">Invalid Login System Check</td>
    </tr>
    <tr>
      <td class="header">Allowed login attempts</td>
      <td class="lista"><input type="text" name="att_login" value="<tag:config.att_login />" size="4" /></td>
          <td class="header">Enable invalid login check</td>
     <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="inv_login" value="true"<tag:config.inv_loginyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="inv_login" value="false"<tag:config.inv_loginno /> /></td>
     </tr>
          <tr>
      <td class="header" align="center" colspan="4">LED Ticker Settings</td>
    </tr>
<tr>
      <td class="header" valign="top" colspan="2"><tag:language.tmsg1 /></td><td class="header" valign="top" colspan="2"><tag:language.tmsg2 /></td></tr><tr>
      <td class="lista" colspan="2"><textarea name="ticker_msg_1" rows="1" cols="30"><tag:config.ticker_msg_1 /></textarea></td> <td class="lista" colspan="2"><textarea name="ticker_msg_2" rows="1" cols="30"><tag:config.ticker_msg_2 /></textarea></td></tr><tr>
	  
	  <td class="header" valign="top" colspan="2"><tag:language.tmsg3 /></td><td class="header" valign="top" colspan="2"><tag:language.tmsg4 /></td></tr><tr>
      <td class="lista" colspan="2"><textarea name="ticker_msg_3" rows="1" cols="30"><tag:config.ticker_msg_3 /></textarea></td><td class="lista" colspan="2"><textarea name="ticker_msg_4" rows="1" cols="30"><tag:config.ticker_msg_4 /></textarea></td>
    </tr>
          <tr>
      <td class="header" align="center" colspan="4">Advertise Settings</td>
    </tr>
    <tr>
      <td class="header" valign="top" colspan="1">Advertise Top</td>
      <td class="lista" colspan="2"><textarea name="adver_top" rows="5" cols="50"><tag:config.adver_top /></textarea></td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="adver_top_on" value="true"<tag:config.adver_top_onyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="adver_top_on" value="false"<tag:config.adver_top_onno /> /></td>
     </tr>
    </tr>
        <tr>
      <td class="header" valign="top" colspan="1">Advertise Bottom</td>
      <td class="lista" colspan="2"><textarea name="adver_bot" rows="5" cols="50"><tag:config.adver_bot /></textarea></td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="adver_bot_on" value="true"<tag:config.adver_bot_onyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="adver_bot_on" value="false"<tag:config.adver_bot_onno /> /></td>
    </tr>
    
      <tr>
      <td class="header" align="center" colspan="4">Staff Comment Settings</td>
      </tr>
      <tr>
      <td class="header">Min ID to set</td>
      <td class="lista"><input type="text" name="staff_comment" value="<tag:config.staff_comment />" size="4" /></td>
      <td class="header">Min ID to view</td>
      <td class="lista"><input type="text" name="staff_comment_view" value="<tag:config.staff_comment_view />" size="4" /></td>
      </tr>
     
      <tr>
      <td class="header" align="center" colspan="4">User Images Settings</td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Buy Items</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="uiswitch" value="true"<tag:config.uiswitchyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="uiswitch" value="false"<tag:config.uiswitchno /> /></td>
      <td class="header" valign="top" colspan="1">img in Online</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="uion" value="true"<tag:config.uionyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="uion" value="false"<tag:config.uionno /> /></td>
      </tr>
      <tr>
      <td class="header">Image 1</td>
      <td class="lista"><input type="text" name="img_don" value="<tag:config.img_don />" size="30" /></td>
      <td class="header">Image 1 Title</td>
      <td class="lista"><input type="text" name="text_don" value="<tag:config.text_don />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p1" value="true"<tag:config.p1yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p1" value="false"<tag:config.p1no /> /></td>
      <td class="header">Image 1 Price</td>
      <td class="lista"><input type="text" name="preen" value="<tag:config.preen />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 2</td>
      <td class="lista"><input type="text" name="img_donm" value="<tag:config.img_donm />" size="30" /></td>
      <td class="header">Image 2 Title</td>
      <td class="lista"><input type="text" name="text_donm" value="<tag:config.text_donm />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p2" value="true"<tag:config.p2yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p2" value="false"<tag:config.p2no /> /></td>
      <td class="header">Image 2 Price</td>
      <td class="lista"><input type="text" name="prtwee" value="<tag:config.prtwee />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 3</td>
      <td class="lista"><input type="text" name="img_mal" value="<tag:config.img_mal />" size="30" /></td>
      <td class="header">Image 3 Title</td>
      <td class="lista"><input type="text" name="text_mal" value="<tag:config.text_mal />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p3" value="true"<tag:config.p3yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p3" value="false"<tag:config.p3no /> /></td>
      <td class="header">Image 3 Price</td>
      <td class="lista"><input type="text" name="prdrie" value="<tag:config.prdrie />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 4</td>
      <td class="lista"><input type="text" name="img_fem" value="<tag:config.img_fem />" size="30" /></td>
      <td class="header">Image 4 Title</td>
      <td class="lista"><input type="text" name="text_fem" value="<tag:config.text_fem />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p4" value="true"<tag:config.p4yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p4" value="false"<tag:config.p4no /> /></td>
      <td class="header">Image 4 Price</td>
      <td class="lista"><input type="text" name="prvier" value="<tag:config.prvier />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 5</td>
      <td class="lista"><input type="text" name="img_bir" value="<tag:config.img_bir />" size="30" /></td>
      <td class="header">Image 5 Title</td>
      <td class="lista"><input type="text" name="text_bir" value="<tag:config.text_bir />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p5" value="true"<tag:config.p5yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p5" value="false"<tag:config.p5no /> /></td>
      <td class="header">Image 5 Price</td>
      <td class="lista"><input type="text" name="prvijf" value="<tag:config.prvijf />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 6</td>
      <td class="lista"><input type="text" name="img_bot" value="<tag:config.img_bot />" size="30" /></td>
      <td class="header">Image 6 Title</td>
      <td class="lista"><input type="text" name="text_bot" value="<tag:config.text_bot />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p6" value="true"<tag:config.p6yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p6" value="false"<tag:config.p6no /> /></td>
      <td class="header">Image 6 Price</td>
      <td class="lista"><input type="text" name="przes" value="<tag:config.przes />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 7</td>
      <td class="lista"><input type="text" name="img_ban" value="<tag:config.img_ban />" size="30" /></td>
      <td class="header">Image 7 Title</td>
      <td class="lista"><input type="text" name="text_ban" value="<tag:config.text_ban />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p7" value="true"<tag:config.p7yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p7" value="false"<tag:config.p7no /> /></td>
      <td class="header">Image 7 Price</td>
      <td class="lista"><input type="text" name="przeven" value="<tag:config.przeven />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 8</td>
      <td class="lista"><input type="text" name="img_par" value="<tag:config.img_par />" size="30" /></td>
      <td class="header">Image 8 Title</td>
      <td class="lista"><input type="text" name="text_par" value="<tag:config.text_par />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p8" value="true"<tag:config.p8yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p8" value="false"<tag:config.p8no /> /></td>
      <td class="header">Image 8 Price</td>
      <td class="lista"><input type="text" name="pracht" value="<tag:config.pracht />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 9</td>
      <td class="lista"><input type="text" name="img_war" value="<tag:config.img_war />" size="30" /></td>
      <td class="header">Image 9 Title</td>
      <td class="lista"><input type="text" name="text_war" value="<tag:config.text_war />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p9" value="true"<tag:config.p9yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p9" value="false"<tag:config.p9no /> /></td>
      <td class="header">Image 9 Price</td>
      <td class="lista"><input type="text" name="prnegen" value="<tag:config.prnegen />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 10</td>
      <td class="lista"><input type="text" name="img_tru" value="<tag:config.img_tru />" size="30" /></td>
      <td class="header">Image 10 Title</td>
      <td class="lista"><input type="text" name="text_tru" value="<tag:config.text_tru />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p10" value="true"<tag:config.p10yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p10" value="false"<tag:config.p10no /> /></td>
      <td class="header">Image 10 Price</td>
      <td class="lista"><input type="text" name="prtien" value="<tag:config.prtien />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 11</td>
      <td class="lista"><input type="text" name="img_trum" value="<tag:config.img_trum />" size="30" /></td>
      <td class="header">Image 11 Title</td>
      <td class="lista"><input type="text" name="text_trum" value="<tag:config.text_trum />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p11" value="true"<tag:config.p11yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p11" value="false"<tag:config.p11no /> /></td>
      <td class="header">Image 11 Price</td>
      <td class="lista"><input type="text" name="prelf" value="<tag:config.prelf />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 12</td>
      <td class="lista"><input type="text" name="img_vip" value="<tag:config.img_vip />" size="30" /></td>
      <td class="header">Image 12 Title</td>
      <td class="lista"><input type="text" name="text_vip" value="<tag:config.text_vip />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p12" value="true"<tag:config.p12yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p12" value="false"<tag:config.p12no /> /></td>
      <td class="header">Image 12 Price</td>
      <td class="lista"><input type="text" name="prtwaalf" value="<tag:config.prtwaalf />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 13</td>
      <td class="lista"><input type="text" name="img_vipm" value="<tag:config.img_vipm />" size="30" /></td>
      <td class="header">Image 13 Title</td>
      <td class="lista"><input type="text" name="text_vipm" value="<tag:config.text_vipm />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p13" value="true"<tag:config.p13yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p13" value="false"<tag:config.p13no /> /></td>
      <td class="header">Image 13 Price</td>
      <td class="lista"><input type="text" name="prdertien" value="<tag:config.prdertien />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 14</td>
      <td class="lista"><input type="text" name="img_sta" value="<tag:config.img_sta />" size="30" /></td>
      <td class="header">Image 14 Title</td>
      <td class="lista"><input type="text" name="text_sta" value="<tag:config.text_sta />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p14" value="true"<tag:config.p14yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p14" value="false"<tag:config.p14no /> /></td>
      <td class="header">Image 14 Price</td>
      <td class="lista"><input type="text" name="prveertien" value="<tag:config.prveertien />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 15</td>
      <td class="lista"><input type="text" name="img_sys" value="<tag:config.img_sys />" size="30" /></td>
      <td class="header">Image 15 Title</td>
      <td class="lista"><input type="text" name="text_sys" value="<tag:config.text_sys />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p15" value="true"<tag:config.p15yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p15" value="false"<tag:config.p15no /> /></td>
      <td class="header">Image 15 Price</td>
      <td class="lista"><input type="text" name="prvijftien" value="<tag:config.prvijftien />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 16</td>
      <td class="lista"><input type="text" name="img_fri" value="<tag:config.img_fri />" size="30" /></td>
      <td class="header">Image 16 Title</td>
      <td class="lista"><input type="text" name="text_fri" value="<tag:config.text_fri />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p16" value="true"<tag:config.p16yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p16" value="false"<tag:config.p16no /> /></td>
      <td class="header">Image 16 Price</td>
      <td class="lista"><input type="text" name="przestien" value="<tag:config.przestien />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Image 17</td>
      <td class="lista"><input type="text" name="img_jun" value="<tag:config.img_jun />" size="30" /></td>
      <td class="header">Image 17 Title</td>
      <td class="lista"><input type="text" name="text_jun" value="<tag:config.text_jun />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Enable This Item</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="p17" value="true"<tag:config.p17yes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="p17" value="false"<tag:config.p17no /> /></td>
      <td class="header">Image 17 Price</td>
      <td class="lista"><input type="text" name="przeventien" value="<tag:config.przeventien />" size="30" /></td>
      </tr>
     
      <tr>
      <td class="header" align="center" colspan="4">Seasons Fun Settings</td>
    </tr>
      <tr>
      <td class="header">Winter</td>
     <td class="lista">&nbsp;&nbsp;Snow on&nbsp;<input type="radio" name="snow" value="true"<tag:config.snowyes /> />&nbsp;&nbsp;Snow off&nbsp;<input type="radio" name="snow" value="false"<tag:config.snowno /> /></td>
      <td class="header">Autumn</td>
     <td class="lista">&nbsp;&nbsp;Halloween on&nbsp;<input type="radio" name="halloween" value="true"<tag:config.halloweenyes /> />&nbsp;&nbsp;Halloween off&nbsp;<input type="radio" name="halloween" value="false"<tag:config.halloweenno /> /></td>
     </tr>
           <tr>
      <td class="header">Autumn</td>
     <td class="lista">&nbsp;&nbsp;Leafs on&nbsp;<input type="radio" name="leafs" value="true"<tag:config.leafsyes /> />&nbsp;&nbsp;Leafs off&nbsp;<input type="radio" name="leafs" value="false"<tag:config.leafsno /> /></td>
      <td class="header">Spring</td>
     <td class="lista">&nbsp;&nbsp;Flowers on&nbsp;<input type="radio" name="flowers" value="true"<tag:config.flowersyes /> />&nbsp;&nbsp;Flowers off&nbsp;<input type="radio" name="flowers" value="false"<tag:config.flowersno /> /></td>
     </tr>
     
    <tr>
      <td class="header">Winter</td>
     <td class="lista">&nbsp;&nbsp;Xmas on&nbsp;<input type="radio" name="xmas" value="true"<tag:config.xmasyes /> />&nbsp;&nbsp;Xmas off&nbsp;<input type="radio" name="xmas" value="false"<tag:config.xmasno /> /></td>
      <td class="header">Winter</td>
     <td class="lista">&nbsp;&nbsp;Valentine on&nbsp;<input type="radio" name="valen" value="true"<tag:config.valenyes /> />&nbsp;&nbsp;Valentine off&nbsp;<input type="radio" name="valen" value="false"<tag:config.valenno /> /></td>
     </tr>
     <tr>
      <td class="header" align="center" colspan="4">Client Comment</td>
    </tr>
    <tr>
    <td class="header">Enable Client Comment</td>
     <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="cl_on" value="true"<tag:config.cl_onyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="cl_on" value="false"<tag:config.cl_onno /> /></td>
      <td class="header">text</td>
      <td class="lista"><input type="text" name="cl_te" value="<tag:config.cl_te />" size="35" /></td>
     </tr>	 
	 <tr>
      <td class="header" align="center" colspan="4">Arcade Settings</td>
      </tr>
      <tr>

      <td class="header">High Score Award</td>
      <td class="lista">&nbsp;&nbsp;Upload&nbsp;<input type="radio" name="arc_aw" value="true"<tag:config.arc_awyes /> />&nbsp;&nbsp;Seedbonus&nbsp;<input type="radio" name="arc_aw" value="false"<tag:config.arc_awno /> /></td>

      </tr>
      <tr>
      <td class="header">Upload in MB</td>
      <td class="lista"><input type="text" name="arc_upl" value="<tag:config.arc_upl />" size="7" /></td>
      <td class="header">Seedbonus Points</td>
      <td class="lista"><input type="text" name="arc_sb" value="<tag:config.arc_sb />" size="7" /></td>
      </tr>

      <tr>
      <td class="header" align="center" colspan="4">Auto Featured Torrent</td>
      </tr>
      <tr>
      <td class="header">Auto or Via ACP </td>
      <td class="lista">&nbsp;&nbsp;Auto&nbsp;<input type="radio" name="auto_feat" value="true"<tag:config.auto_featyes /> />&nbsp;&nbsp;ACP&nbsp;<input type="radio" name="auto_feat" value="false"<tag:config.auto_featno /> /></td>
      </tr>
      	<tr>
      <td class="header" align="center" colspan="4">Referral System Settings</td>
    </tr>
    <tr>
    <td class="header">Enable Referral System</td>
     <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="ref_on" value="true"<tag:config.ref_onyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="ref_on" value="false"<tag:config.ref_onno /> /></td>
     <td class="header">Referral Bonus</td>
      <td class="lista">&nbsp;&nbsp;GB&nbsp;<input type="radio" name="ref_switch" value="true"<tag:config.ref_switchyes /> />&nbsp;&nbsp;SB&nbsp;<input type="radio" name="ref_switch" value="false"<tag:config.ref_switchno /> /></td>

     </tr>
    <tr>
      <td class="header">Bonus in GB</td>
      <td class="lista"><input type="text" name="ref_gb" value="<tag:config.ref_gb />" size="7" /></td>
      <td class="header">Bonus in SB</td>
      <td class="lista"><input type="text" name="ref_sb" value="<tag:config.ref_sb />" size="7" /></td>
      </tr>
    <tr>
      <td class="header" align="center" colspan="4">Upload Multiplier Settings</td>
      </tr>
      <tr>
      <td class="header">Min ID level to set</td>
      <td class="lista"><input type="text" name="multie" value="<tag:config.multie />" size="4" /></td>
      </tr>
    <tr>
      <td class="header" align="center" colspan="4">Torrents Split By Day Settings</td>
      </tr>
      <tr>
      <td class="header">Torrents Split By Day</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="torday" value="true"<tag:config.tordayyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="torday" value="false"<tag:config.tordayno /> /></td>
      </tr>
        <tr>
      <td class="header" align="center" colspan="4">Auto Torrent Name Settings</td>
      </tr>
      <tr>
      <td class="header">Auto Torrent Name</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="tornam" value="true"<tag:config.tornamyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="tornam" value="false"<tag:config.tornamno /> /></td>
      </tr>


        <tr>
      <td class="header" align="center" colspan="4">Facebook Login System</td>
      </tr>
      <tr>
       <td class="header">Enable System</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="fbon" value="true"<tag:config.fbonyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="fbon" value="false"<tag:config.fbonno /> /></td>
       <td class="header" >Allow Staff to use FB Login</td>
              <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="fbadmin" value="true"<tag:config.fbadminyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="fbadmin" value="false"<tag:config.fbadminno /> /></td>
       </tr>
    <tr>
      <td class="header" valign="top" colspan="1">ID facebook</td>
      <td class="lista" colspan="3"><input type="text" size="40" name="fesbappi" maxlength="150" value="<tag:config.fesbappi />"/></td>
    </tr>
    <tr>
      <td class="header" valign="top" colspan="1">App Secret facebook</td>
      <td class="lista" colspan="3"><input type="text" size="40" name="fesecret" maxlength="150" value="<tag:config.fesecret />"/></td>
    </tr>
    <tr>
      <td class="header" align="center" colspan="4">Matrix Screensaver</td>
      </tr>
      <tr>
      <td class="header">Matrix Screensaver</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="matrix" value="true"<tag:config.matrixyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="matrix" value="false"<tag:config.matrixno /> /></td>
      </tr>
        <tr>
      <td class="header" align="center" colspan="4"><tag:language.IRC_SETTINGS /></td>
    </tr>
    <tr>
      <td class="header"><tag:language.SETTING_IRC_SERVER /></td>
      <td class="lista"><input type="text" id="irc_server" name="irc_server" value="<tag:config.irc_server />" size="30" /></td>
	  <td class="header"><tag:language.SETTING_IRC_PORT /></td>
      <td class="lista"><input type="text" name="irc_port" value="<tag:config.irc_port />" size="10" /></td>
	</tr>
	<tr>
      <td class="header"><tag:language.SETTING_IRC_CHANNEL /></td>
      <td class="lista"><input type="text" id="irc_channel" name="irc_channel" value="<tag:config.irc_channel />" size="20" /></td>
      <td class="header" >Enable IRC Hack</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="irc_on" value="true"<tag:config.irc_onyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="irc_on" value="false"<tag:config.irc_onno /> /></td>
    </tr>
    <tr>
      <td class="header" align="center" colspan="6">IRC Language: en / nl / fr / ar / bd / bg / br /cz / da /dr / el / es / et / fi / hu / hr / id / it/ jp / lv / pl / pt / ro / ru / sk / sl / sq / sv / th / tr / uk</td>
    </tr>
    <tr>
    <td class="header">IRC Language</td>
      <td class="lista"><input type="text" id="irc_lang" name="irc_lang" value="<tag:config.irc_lang />" size="20" /></td>
      </tr>
    <tr>
      <td class="header" align="center" colspan="4">Disclaimer</td>
      </tr>
      <tr>
      <td class="header">Disclaimer</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="disclaim" value="true"<tag:config.disclaimyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="disclaim" value="false"<tag:config.disclaimno /> /></td>
      </tr>
        <tr>
      <td class="header" align="center" colspan="4">Don,t loose input after mistake in upload form</td>
      </tr>
      <tr>
      <td class="header">Error Protection</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="uploff" value="true"<tag:config.uploffyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="uploff" value="false"<tag:config.uploffno /> /></td>
      </tr>
        <tr>
      <td class="header" align="center" colspan="4">NFO Uploader or NFO Ripper</td>
      </tr>
      <tr>
      <td class="header">NFO</td>
       <td class="lista">&nbsp;&nbsp;Uploader&nbsp;<input type="radio" name="nfosw" value="true"<tag:config.nfoswyes /> />&nbsp;&nbsp;Ripper&nbsp;<input type="radio" name="nfosw" value="false"<tag:config.nfoswno /> /></td>
      </tr>
        <tr>
      <td class="header" align="center" colspan="4">Torrent Tag</td>
      </tr>
      <tr>
      <td class="header">Torrent Tag</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="tag" value="true"<tag:config.tagyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="tag" value="false"<tag:config.tagno /> /></td>
      </tr>
        <tr>
      <td class="header" align="center" colspan="4">RSS Link</td>
      </tr>
      <tr>
      <td class="header">Show RSS</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="srss" value="true"<tag:config.srssyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="srss" value="false"<tag:config.srssno /> /></td>
      </tr>
    <tr>
      <td class="header" align="center" colspan="4">Upload Request PM Settings</td>
      </tr>
      <tr>
        <td class="header">Enable System</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="up_on" value="true"<tag:config.up_onyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="up_on" value="false"<tag:config.up_onno /> /></td>
      </tr>
      <tr>
      <td class="header">Staff Level ID to send PM</td>
      <td class="lista"><input type="text" name="up_id" value="<tag:config.up_id />" size="4" /></td>
      <td class="header">Send to all staff</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="up_all" value="true"<tag:config.up_allyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="up_all" value="false"<tag:config.up_allno /> /></td>
      </tr>
        <tr>
      <td class="header" align="center" colspan="4">Personal Notepad</td>
      </tr>
      <tr>
      <td class="header">Personal Notepad</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="noteon" value="true"<tag:config.noteonyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="noteon" value="false"<tag:config.noteonno /> /></td>
      </tr>
    <tr>
      <td class="header" align="center" colspan="4">Shit List Settings</td>
      </tr>
      <tr>
      <td class="header">Enable System</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="slon" value="true"<tag:config.slonyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="slon" value="false"<tag:config.slonno /> /></td>
      <td class="header">Send Auto PM</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="pm_shit" value="true"<tag:config.pm_shityes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="pm_shit" value="false"<tag:config.pm_shitno /> /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Add to Shit List Text</td>
      <td class="lista" colspan="3"><textarea name="pm_tekst" rows="5" cols="60"><tag:config.pm_tekst /></textarea></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Remove from Shit List Text</td>
      <td class="lista" colspan="3"><textarea name="pms_tekst" rows="5" cols="60"><tag:config.pms_tekst /></textarea></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Use Demote System</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="demote" value="true"<tag:config.demoteyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="demote" value="false"<tag:config.demoteno /> /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">To Shit Group ID</td>
      <td class="lista"><input type="text" name="shit_group" value="<tag:config.shit_group />" size="4" /></td>
      <td class="header" valign="top" colspan="1">Promote Back To Group ID</td>
       <td class="lista"><input type="text" name="shit_group_back" value="<tag:config.shit_group_back />" size="4" /></td>
      </tr>
      <tr>
      <tr>
      <td class="header" align="center" colspan="4"><font color = red >START Shoutbox Related Settings</font></td>
      </tr>
      <td class="header" align="center" colspan="4">Shoutbox Layout</td>
      </tr>
      <tr>
      <td class="header">DT Layout with Avatar</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="shoutdt" value="true"<tag:config.shoutdtyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="shoutdt" value="false"<tag:config.shoutdtno /> /></td>
       <td class="header">DT Layout without Avatar</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="shoutdtav" value="true"<tag:config.shoutdtavyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="shoutdtav" value="false"<tag:config.shoutdtavno /> /></td>
      </tr>
      <tr>
    <td class="header">DT Layout Font Size</td>
       <td class="lista">&nbsp;&nbsp;Big&nbsp;<input type="radio" name="shoutdtz" value="true"<tag:config.shoutdtzyes /> />&nbsp;&nbsp;Small&nbsp;<input type="radio" name="shoutdtz" value="false"<tag:config.shoutdtzno /> /></td>
    <td class="header" valign="top" colspan="1">Lines in Shoutbox</td>
       <td class="lista"><input type="text" name="shoutline" value="<tag:config.shoutline />" size="4" /></td>
       </tr>
       <tr>
      <td class="header">Edit&Delete Button</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="shoutdel" value="true"<tag:config.shoutdelyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="shoutdel" value="false"<tag:config.shoutdelno /> /></td>
             <td class="header">Shoutbox Sound</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="bling" value="true"<tag:config.blingyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="bling" value="false"<tag:config.blingno /> /></td>
     </tr>
     <tr>
      <td class="header" align="center" colspan="4">Images In Shoutbox Settings</td>
      </tr>
            <tr>
      <td class="header">Enable System</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="endtch" value="true"<tag:config.endtchyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="endtch" value="false"<tag:config.endtchno /> /></td>
      <td class="header">Fixxed Image Name</td>
      <td class="lista"><input type="text" name="fix_chat" value="<tag:config.fix_chat />" size="30" /></td>
      </tr
      <tr>
      <td class="header">After X Shouts</td>
      <td class="lista"><input type="text" name="don_chat" value="<tag:config.don_chat />" size="5" /></td>
      <td class="header">Random or Fixxed</td>
      <td class="lista">&nbsp;&nbsp;Random&nbsp;<input type="radio" name="ran_chat" value="true"<tag:config.ran_chatyes /> />&nbsp;&nbsp;Fixxed&nbsp;<input type="radio" name="ran_chat" value="false"<tag:config.ran_chatno /> /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Shoutbox Announce</td>
      </tr>
      <tr>
      <td class="header">New Torrent in SB</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="sbone" value="true"<tag:config.sboneyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="sbone" value="false"<tag:config.sboneno /> /></td>
        <td class="header">New User in SB</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="sbtwo" value="true"<tag:config.sbtwoyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="sbtwo" value="false"<tag:config.sbtwono /> /></td>
      </tr>
        <tr>
      <td class="header">New Forum Post in SB</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="sbdrie" value="true"<tag:config.sbdrieyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="sbdrie" value="false"<tag:config.sbdrieno /> /></td>
        <td class="header">New Torrent Comment in SB</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="sbvier" value="true"<tag:config.sbvieryes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="sbvier" value="false"<tag:config.sbvierno /> /></td>
      </tr>
            <tr>
      <td class="header" align="center" colspan="4"><font color = red >END Shoutbox Related Settings</font></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Anonymous Links</td>
      </tr>
      <tr>
      <td class="header">Anonymous Links</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="anonymous" value="true"<tag:config.anonymousyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="anonymous" value="false"<tag:config.anonymousno /> /></td>
      </tr>
        <tr>
      <td class="header" align="center" colspan="4">Staff Panel Login</td>
      </tr>
      <tr>
   	  <td class="header">Enable</td>
      <td class="lista">&nbsp;&nbsp;Enable Login&nbsp;<input type="radio" name="acp" value="true"<tag:config.acpyes /> />&nbsp;&nbsp;Disable Login&nbsp;<input type="radio" name="acp" value="false"<tag:config.acpno /> /></td>
   	  </tr>
      <tr>
      <td class="header">Username 1</td>
      <td class="lista"><input type="text" name="un1" value="<tag:config.un1 />" size="4" /></td>
	  <td class="header">Password 1</td>
      <td class="lista"><input type="text" name="pw1" value="<tag:config.pw1 />" size="4" /></td>
      </tr>
      <tr>
      <td class="header">Username 2</td>
      <td class="lista"><input type="text" name="un2" value="<tag:config.un2 />" size="4" /></td>
	  <td class="header">Password 2</td>
      <td class="lista"><input type="text" name="pw2" value="<tag:config.pw2 />" size="4" /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Extra Low Ratio Ban Settings</td>
      </tr>
      <tr>
   	  <td class="header">Final Action</td>
      <td class="lista">&nbsp;&nbsp;Ban&nbsp;<input type="radio" name="en_sys" value="true"<tag:config.en_sysyes /> />&nbsp;&nbsp;Demote&nbsp;<input type="radio" name="en_sys" value="false"<tag:config.en_sysno /> /></td>
      <td class="header">Demote User Group ID</td>
      <td class="lista"><input type="text" name="dm_id" value="<tag:config.dm_id />" size="4" /></td>
   	  </tr>
   	  <tr>
      <td class="header" align="center" colspan="4">Enable Language Selection</td>
      </tr>
      <tr>
   	  <td class="header">Enable</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="uplang" value="true"<tag:config.uplangyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="uplang" value="false"<tag:config.uplangno /> /></td>
     </tr>
       <tr>
        <td class="header" valign="top" colspan="1">Add Custom Language</td>
       <td class="lista"><input type="text" name="customlang" value="<tag:config.customlang />" size="12" /></td>
        <td class="header" valign="top" colspan="1">Code Custom Flag</td>
       <td class="lista"><input type="text" name="customflag" value="<tag:config.customflag />" size="2" /></td>
       </tr>
        <tr>
        <td class="header" valign="top" colspan="1">Add Custom Language</td>
       <td class="lista"><input type="text" name="customlanga" value="<tag:config.customlanga />" size="12" /></td>
        <td class="header" valign="top" colspan="1">Code Custom Flag</td>
       <td class="lista"><input type="text" name="customflaga" value="<tag:config.customflaga />" size="2" /></td>
       </tr>
        <tr>
        <td class="header" valign="top" colspan="1">Add Custom Language</td>
       <td class="lista"><input type="text" name="customlangb" value="<tag:config.customlangb />" size="12" /></td>
        <td class="header" valign="top" colspan="1">Code Custom Flag</td>
       <td class="lista"><input type="text" name="customflagb" value="<tag:config.customflagb />" size="2" /></td>
       </tr>
        <tr>
        <td class="header" valign="top" colspan="1">Add Custom Language</td>
       <td class="lista"><input type="text" name="customlangc" value="<tag:config.customlangc />" size="12" /></td>
        <td class="header" valign="top" colspan="1">Code Custom Flag</td>
       <td class="lista"><input type="text" name="customflagc" value="<tag:config.customflagc />" size="2" /></td>
       </tr>
   	    <tr>
      <td class="header" align="center" colspan="4">Enable YouTube Video Page</td>
      </tr>
      <tr>
   	  <td class="header">Enable</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="ytv" value="true"<tag:config.ytvyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="ytv" value="false"<tag:config.ytvno /> /></td>
   	  </tr>
   	    <tr>
      <td class="header" align="center" colspan="4">Extra IMDB Settings Torrent List</td>
      </tr>
      <tr>
   	  <td class="header">Show IMDB Rating/Link</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="imdbt" value="true"<tag:config.imdbtyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="imdbt" value="false"<tag:config.imdbtno /> /></td>
      <td class="header">Use IMDB Img In TD</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="imdbimg" value="true"<tag:config.imdbimgyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="imdbimg" value="false"<tag:config.imdbimgno /> /></td>
        </tr>
   	    <tr>
   	    <td class="header">IMDB Img In Blocks</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="imdbbl" value="true"<tag:config.imdbblyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="imdbbl" value="false"<tag:config.imdbblno /> /></td>
      <td class="header">IMDB img mousehover</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="imdbmh" value="true"<tag:config.imdbmhyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="imdbmh" value="false"<tag:config.imdbmhno /> /></td>
   	  </tr>
   	 <tr>
      <td class="header" align="center" colspan="4">Simular In Torent List</td>
      </tr>
      <tr>
   	  <td class="header">Enable System</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="simtor" value="true"<tag:config.simtoryes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="simtor" value="false"<tag:config.simtorno /> /></td>
      <td class="header">IMDB Or Filename</td>
      <td class="lista">&nbsp;&nbsp;IMDB&nbsp;<input type="radio" name="simsw" value="true"<tag:config.simswyes /> />&nbsp;&nbsp;Filename&nbsp;<input type="radio" name="simsw" value="false"<tag:config.simswno /> /></td>
        </tr>
        <tr>
      <td class="header" align="center" colspan="4">Enable Torrent Search Cloud</td>
      </tr>
      <tr>
   	  <td class="header">Enable</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="cloud" value="true"<tag:config.cloudyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="cloud" value="false"<tag:config.cloudno /> /></td>
   	  </tr>
   	 <tr>
      <td class="header" align="center" colspan="4">Event Counter Settings</td>
      </tr>
      <tr>
      <td class="header">Enable</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="event_sw" value="true"<tag:config.event_swyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="event_sw" value="false"<tag:config.event_swno /> /></td>
      <td class="header">Event Name</td>
      <td class="lista"><input type="text" name="event" value="<tag:config.event />" size="20" /></td>
      </tr>
      <tr>
      <td class="header">Event Day</td>
      <td class="lista"><input type="text" name="event_day" value="<tag:config.event_day />" size="20" /></td>
      <td class="header">Event Month</td>
      <td class="lista"><input type="text" name="event_month" value="<tag:config.event_month />" size="20" /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Speed Hack</td>
      </tr>
      <tr>
      <td class="header">Enable</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="speedsw" value="true"<tag:config.speedswyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="speedsw" value="false"<tag:config.speedswno /> /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">User Can Delete Own Account</td>
      </tr>
      <tr>
      <td class="header">Enable</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="delsw" value="true"<tag:config.delswyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="delsw" value="false"<tag:config.delswno /> /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Setting Google analitic</td>
      </tr>
      <tr>
      <td class="header">Enable</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="googlesw" value="true"<tag:config.googleswyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="googlesw" value="false"<tag:config.googleswno /> /></td>
      <td class="header" valign="top" colspan="1">Code Google analitic:<br /> Id of site (UA-XXXXX-YY)</td>
      <td class="lista"><input type="text" name="google" value="<tag:config.google />" size="20" /></td>
      </tr>
        <tr>
      <td class="header" align="center" colspan="4">Last Torrent Block Flash or Scroller </td>
      </tr>
      <tr>
      <td class="header">Flash/Scroller</td>
      <td class="lista">&nbsp;&nbsp;Flash&nbsp;<input type="radio" name="lastsw" value="true"<tag:config.lastswyes /> />&nbsp;&nbsp;Scroller&nbsp;<input type="radio" name="lastsw" value="false"<tag:config.lastswno /> /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Popup by PM</td>
      </tr>
      <tr>
      <td class="header">Enable</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="pmpop" value="true"<tag:config.pmpopyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="pmpop" value="false"<tag:config.pmpopno /> /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Anti Flood in Comments</td>
      </tr>
      <tr>
      <td class="header">Enable System</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="AFSW" value="true"<tag:config.AFSWyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="AFSW" value="false"<tag:config.AFSWno /> /></td>
      </tr>
      <tr>
      <td class="header">Time In Minutes</td>
      <td class="lista"><input type="text" name="AFT" value="<tag:config.AFT />" size="5" /></td>
      <td class="header">Number Of Comments</td>
      <td class="lista"><input type="text" name="AFP" value="<tag:config.AFP />" size="5" /></td>
      </tr>
       <tr>
      <td class="header" align="center" colspan="4">None Fatal PHP Errors</td>
      </tr>
      <tr>     
      <td class="header">Show PHP Errors</td>
      <td class="lista">&nbsp;&nbsp;Show&nbsp;<input type="radio" name="error" value="true"<tag:config.erroryes /> />&nbsp;&nbsp;Do not Show&nbsp;<input type="radio" name="error" value="false"<tag:config.errorno /> /></td>
      </tr>
       <tr>
      <td class="header" align="center" colspan="4">Slot Machine</td>
      </tr>
      <tr>     
      <td class="header">Use Hack</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="sloton" value="true"<tag:config.slotonyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="sloton" value="false"<tag:config.slotonno /> /></td>
      </tr>
       <tr>
      <td class="header" align="center" colspan="4">Torrents To Top</td>
      </tr>
      <tr>     
      <td class="header">Use Option</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="toup" value="true"<tag:config.toupyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="toup" value="false"<tag:config.toupno /> /></td>
      <td class="header">Price in SB</td>
      <td class="lista"><input type="text" name="touppr" value="<tag:config.touppr />" size="5" /></td>
      </tr>
     </tr>
     <tr>  
      <td class="header" align="center" colspan="4">Auto Prune Dead Torrents</td>
      </tr>
      <tr>     
      <td class="header">Use Option</td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="autotprune" value="true"<tag:config.autotpruneyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="autotprune" value="false"<tag:config.autotpruneno /> /></td>
      <td class="header">Days to Prune</td>
      <td class="lista"><input type="text" name="autotprundedays" value="<tag:config.autotprundedays />" size="5" /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Reseed Button</td>
      </tr>
      <tr>     
      <td class="header">Button Rules</td>
      <td class="lista">&nbsp;&nbsp;<font color=red>Seed=0 <font color=purple>Fin>2 <font color = green>Leech>0 <font color = steelblue>dead>1day&nbsp;<input type="radio" name="logmin" value="true"<tag:config.logminyes /> />&nbsp;&nbsp;<font color=red>Seed=0 <font color=purple>Fin>0</font>&nbsp;<input type="radio" name="logmin" value="false"<tag:config.logminno /> /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Menu Links</td>
      </tr>
      <tr>
      <td class="header">Today,s Torrents</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="tordayy" value="true"<tag:config.tordayyyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="tordayy" value="false"<tag:config.tordayyno /> /></td>
        <td class="header">Subtitles</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="subtitles" value="true"<tag:config.subtitlesyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="subtitles" value="false"<tag:config.subtitlesno /> /></td>
      </tr>
        <tr>
      <td class="header">Expected / to Offer</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="offerr" value="true"<tag:config.offerryes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="offerr" value="false"<tag:config.offerrno /> /></td>
        <td class="header">Helpdesk</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="helpdesk" value="true"<tag:config.helpdeskyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="helpdesk" value="false"<tag:config.helpdeskno /> /></td>
      </tr>
        <tr>
      <td class="header">Report a Bug</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="bugs" value="true"<tag:config.bugsyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="bugs" value="false"<tag:config.bugsno /> /></td>
        <td class="header">Blackjack</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="blackjack" value="true"<tag:config.blackjackyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="blackjack" value="false"<tag:config.blackjackno /> /></td>
      </tr>
      <tr>
      <td class="header">Teams</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="teams" value="true"<tag:config.teamsyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="teams" value="false"<tag:config.teamsno /> /></td>
        <td class="header">Announcement</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="aannn" value="true"<tag:config.aannnyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="aannn" value="false"<tag:config.aannnno /> /></td>
      </tr>
        <tr>
      <td class="header">IMDb Search</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="imdbmenu" value="true"<tag:config.imdbmenuyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="imdbmenu" value="false"<tag:config.imdbmenuno /> /></td>
        <td class="header">Gallery</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="gallery" value="true"<tag:config.galleryyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="gallery" value="false"<tag:config.galleryno /> /></td>
     </tr>
     <tr>
      <td class="header" align="center" colspan="4">Collapse Settings</td>
      </tr>
      <tr>
      <td class="header">Header Collapse</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="colup" value="true"<tag:config.colupyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="colup" value="false"<tag:config.colupno /> /></td>
        <td class="header">Footer Collapse</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="coldown" value="true"<tag:config.coldownyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="coldown" value="false"<tag:config.coldownno /> /></td>
      </tr>
          <tr>
      <td class="header" align="center" colspan="4">Support Section in Staff Page Settings</td>
      </tr>
      <tr>
      <td class="header">Add Support</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="supportsw" value="true"<tag:config.supportswyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="supportsw" value="false"<tag:config.supportswno /> /></td>
       </tr>
        <tr>
      <td class="header" align="center" colspan="4">Pie Chart in Torrent Details Settings</td>
      </tr>
        <tr>
      <td class="header">Use Pie Chart in Torrent Details</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="pie" value="true"<tag:config.pieyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="pie" value="false"<tag:config.pieno /> /></td>
       </tr>
        <tr>
      <td class="header" align="center" colspan="4">Block Links in Comments Settings</td>
      </tr>
        <tr>
      <td class="header">Block Links in Comments</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="cblock" value="true"<tag:config.cblockyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="cblock" value="false"<tag:config.cblockno /> /></td>
       </tr>
        <tr>
      <td class="header" align="center" colspan="4">Force to Thank/Comment before Download Settings</td>
      </tr>
        <tr>
      <td class="header">Force to Thank/Comments</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="thco" value="true"<tag:config.thcoyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="thco" value="false"<tag:config.thcono /> /></td>
        <td class="header">Owner Auto Thanks</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="owth" value="true"<tag:config.owthyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="owth" value="false"<tag:config.owthno /> /></td>
       </tr>
       <tr>
      <td class="header" align="center" colspan="4">Show Users IP Settings</td>
      </tr>
       <tr>
      <td class="header">Show Users IP in Userblock</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="ownip" value="true"<tag:config.ownipyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="ownip" value="false"<tag:config.ownipno /> /></td>
       </tr>
       
      <tr>
      <td class="header" align="center" colspan="4">Apply for Membership Settings</td>
      </tr>
      <tr>
      <td class="header">Enable System</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="apply_on" value="true"<tag:config.apply_onyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="apply_on" value="false"<tag:config.apply_onno /> /></td>
      </tr>
      <tr>
      <td class="header">Staff Level ID to send PM</td>
      <td class="lista"><input type="text" name="apply_id" value="<tag:config.apply_id />" size="4" /></td>
      <td class="header">Send to all staff</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="apply_all" value="true"<tag:config.apply_allyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="apply_all" value="false"<tag:config.apply_allno /> /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">ORLYDB Pretime Settings</td>
      </tr>
       <tr>
      <td class="header">Enable Pretime</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="orlydb" value="true"<tag:config.orlydbyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="orlydb" value="false"<tag:config.orlydbno /> /></td>
       </tr>
        <tr>
      <td class="header" align="center" colspan="4">PreDB Pretime Settings</td>
      </tr>
       <tr>
      <td class="header">Enable Pretime</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="prepre" value="true"<tag:config.prepreyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="prepre" value="false"<tag:config.prepreno /> /></td>
       </tr>
      <tr>
      <td class="header" align="center" colspan="4"><tag:language.DOX_SETTINGS /></td>
      </tr>
      <td class="header">Enable DOX</td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="enable_dox" value="true"<tag:config.enable_doxyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="enable_dox" value="false"<tag:config.enable_doxno /> /></td>
   	  </tr>
      <tr>
      <td class="header"><tag:language.MAX_FILE /></td>
      <td class="lista"><input type="text" name="limit_dox" value="<tag:config.limit_dox />" size="4" /></td>
	  <td class="header"><tag:language.DAYS_PRUNE /></td>
      <td class="lista"><input type="text" name="dox_del" value="<tag:config.dox_del />" size="4" /></td>
      </tr>
      <tr>
      <td class="header"><tag:language.MIN_DL /></td>
      <td class="lista"><input type="text" name="dl" value="<tag:config.dl />" size="4" /></td>
	  <td class="header"><tag:language.MIN_UL /></td>
      <td class="lista"><input type="text" name="ul" value="<tag:config.ul />" size="4" /></td>
      </tr>
      <tr>
   	  <td class="header"><tag:language.TEXT /></td>
      <td class="lista"><input type="text" name="dox_text" value="<tag:config.dox_text />" size="50" /></td>
   	  <td class="header"><tag:language.UPLOAD /></td>
      <td class="lista">&nbsp;&nbsp;enable&nbsp;<input type="radio" name="dox" value="true"<tag:config.doxyes /> />&nbsp;&nbsp;disabled&nbsp;<input type="radio" name="dox" value="false"<tag:config.doxno /> /></td>
   	  </tr>
   	  <tr>
      <td class="header" align="center" colspan="4">XBTIT Quiz Settings</td>
      </tr>
       <tr>
      <td class="header">Enable Quiz</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="quiz" value="true"<tag:config.quizyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="quiz" value="false"<tag:config.quizno /> /></td>
      <td class="header">Enable Bonus</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="quizp" value="true"<tag:config.quizpyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="quizp" value="false"<tag:config.quizpno /> /></td>
       </tr>
      <tr>
      <td class="header">Price in SB</td>
      <td class="lista"><input type="text" name="quizbon" value="<tag:config.quizbon />" size="4" /></td>
       </tr>
      <tr>
      <td class="header" align="center" colspan="4">Birthday Calender Settings</td>
      </tr>
       <tr>
      <td class="header">Enable Calender</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="caldt" value="true"<tag:config.caldtyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="caldt" value="false"<tag:config.caldtno /> /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">Server Stats setting</td>
      </tr>
       <tr>
      <td class="header">Enable Server Stats</td>
       <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="server" value="true"<tag:config.serveryes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="server" value="false"<tag:config.serverno /> /></td>
      </tr>
      <tr>
      <td class="header" align="center" colspan="4">PM Must Be Readed Before Allow Delete or Not</td>
      </tr>
      <tr>
      <td class="header">PM Delete</td>
      <td class="lista">&nbsp;&nbsp;Read&nbsp;<input type="radio" name="dtpm" value="true"<tag:config.dtpmyes /> />&nbsp;&nbsp;Unread&nbsp;<input type="radio" name="dtpm" value="false"<tag:config.dtpmno /> /></td>
     </tr>
      <tr>
      <td class="header" align="center" colspan="4">Seedbonus to Upload converter</td>
      </tr>
      <tr>
      <td class="header">SB to Upload</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="sbup" value="true"<tag:config.sbupyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="sbup" value="false"<tag:config.sbupno /> /></td>
     </tr>
     <tr>
      <td class="header" align="center" colspan="4">Custom Links in Drop Down Menu</td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Torrent Link 1</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="amenu" value="true"<tag:config.amenuyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="amenu" value="false"<tag:config.amenuno /> /></td>
      </tr>
      <tr>
      <td class="header">Link 1</td>
      <td class="lista"><input type="text" name="bmenu" value="<tag:config.bmenu />" size="30" /></td>
      <td class="header">Name 1</td>
      <td class="lista"><input type="text" name="cmenu" value="<tag:config.cmenu />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">Torrent Link 2</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="dmenu" value="true"<tag:config.dmenuyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="dmenu" value="false"<tag:config.dmenuno /> /></td>
      </tr>
      <tr>
      <td class="header">Link 2</td>
      <td class="lista"><input type="text" name="emenu" value="<tag:config.emenu />" size="30" /></td>
      <td class="header">Name 2</td>
      <td class="lista"><input type="text" name="fmenu" value="<tag:config.fmenu />" size="30" /></td>
      </tr>
      
      <tr>
      <td class="header" valign="top" colspan="1">User Link 1</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="gmenu" value="true"<tag:config.gmenuyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="gmenu" value="false"<tag:config.gmenuno /> /></td>
      </tr>
      <tr>
      <td class="header">Link 1</td>
      <td class="lista"><input type="text" name="hmenu" value="<tag:config.hmenu />" size="30" /></td>
      <td class="header">Name 1</td>
      <td class="lista"><input type="text" name="imenu" value="<tag:config.imenu />" size="30" /></td>
      </tr>
      <tr>
      <td class="header" valign="top" colspan="1">User Link 2</td>
      <td class="lista">&nbsp;&nbsp;Enabled&nbsp;<input type="radio" name="jmenu" value="true"<tag:config.jmenuyes /> />&nbsp;&nbsp;Disabled&nbsp;<input type="radio" name="jmenu" value="false"<tag:config.jmenuno /> /></td>
      </tr>
      <tr>
      <td class="header">Link 2</td>
      <td class="lista"><input type="text" name="kmenu" value="<tag:config.kmenu />" size="30" /></td>
      <td class="header">Name 2</td>
      <td class="lista"><input type="text" name="lmenu" value="<tag:config.lmenu />" size="30" /></td>
      </tr>
      
      <tr>
       <td align="center" class="header" colspan="2"><input type="submit" name="write" class="btn" value="<tag:language.FRM_CONFIRM />" /></td>
      <td align="center" class="header" colspan="2"><input type="submit" name="cancel" class="btn" value="<tag:language.FRM_CANCEL />" /></td>
    </tr>
  </table>
</form>