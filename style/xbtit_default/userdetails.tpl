<table class="lista" width="100%">

  <tr>

     <td width="20%" class="header"><a href=index.php?page=usernamechange&id=<tag:id />><tag:language.USERNAME /></a></td>

    <td width="80%" class="lista"><tag:userdetail_username /><tag:onll /><tag:userdetail_send_pm /><tag:userdetail_edit /><tag:userdetail_delete /><tag:userdetail_banbutton /><tag:userdetail_shit /></td>

    <if:userdetail_has_avatar>

      <td class="lista" align="center" valign="middle" rowspan="4"><tag:userdetail_avatar /></td>

    <else:userdetail_has_avatar>

    </if:userdetail_has_avatar> 
	
	<tr>

    <td class="header"><tag:language.LIST_IGNORE /></td>

    <td class="lista" ><tag:ign /></td>

  </tr>      
        <tr>
      <td class="header">User Icons</td>
      <td class="lista"><tag:usericons /></td>
  </tr>
	  
<if:userdetail_reputation>
     <form method="post" action="index.php?page=plusmin&amp;id=<tag:id />">
     <input type="hidden" name="returnto" value="index.php?page=userdetails&amp;id=<tag:id />">
<tr>
      <td class="header">Reputation</td>
      <td class="lista"><tag:reputation />&nbsp;&nbsp;&nbsp;<tag:reputation_tekst />&nbsp;&nbsp;[<tag:reputation_tot />] &nbsp;&nbsp;
	  <input type="image" name="plus" SRC="images/rep/add.png" >
      <input type="image" name="min" SRC="images/rep/delete.png" ></td></form>
</tr>
   <else:userdetail_reputation>
   </if:userdetail_reputation>
     
    <tr>
      <td class="header">Warned Level</td>
      <td class="lista"><tag:w_level /></td>
</tr>
	    <tr>
      <td class="header">Want to be Friends</td>
      <td class="lista"><tag:friend />&nbsp;&nbsp;&nbsp; <font color = red>Friend List:</font>&nbsp;&nbsp; <tag:showfriend /></td>
      </tr>
      
      <tr>
      <td class="header"><tag:language.USER_AGE /></td>
      <td class="lista"><tag:age /></td>
  </tr>
	  <tr>
      <td class="header"><tag:language.GENDER /></td>
      <td class="lista"><tag:gender /></td>
    </tr>
  <tr>
      <td class="header">Zodiac</td>
      <td class="lista"><tag:zodiac /></td>
  </tr>
  
<tr>

    <td class="header">Used Style</td>

    <td class="lista" colspan="2"><tag:style /></td>

  </tr>
  
    <tr>

    <td class="header">Total Online Time</td>

    <td class="lista" colspan="2"><tag:userdetail_online /></td>

  </tr>
  

    <tr valign="top">
        <td class="header">Status</td>
		<td class="lista"><tag:userdetail_profile_status /><br/><small>added <tag:userdetail_status_time /></small></td>
	</tr>

<if:userdetail_edit_admin>

  <tr>

    <td class="header"><tag:language.EMAIL /></td>

    <td class="lista"><tag:userdetail_email /></td>

  </tr>
  

  <tr>

    <td class="header">Last Browser</td>

    <td class="lista"><tag:browser /></td>

  </tr>
  

  <tr>

    <td class="header"><tag:language.LAST_IP /></td>

    <td class="lista"><tag:userdetail_last_ip /></td>

  </tr>
  <tr>

<td class="header"><tag:language.WHOIS /></td>

    <td class="lista" style="overflow:auto; max-width: 650px; max-height: 24em; display:inline-block; display:block;"><tag:userdetail_whois /></td>

  </tr>
     <form method="post" action="index.php?page=timedrank&amp;id=<tag:id />">
     <input type="hidden" name="returnto" value="index.php?page=userdetails&amp;id=<tag:id />">
     <tr>
     <td class="header" colspan="3" text align="center"><b>Timed Rank Settings</b></td>
     </tr>

          <tr>
     <td class="header">New Rank</td>
     <td class="lista" colspan="3"><tag:rank_combo /></td>
     </tr>

               <tr>
     <td class="header">Old Rank</td>
     <td class="lista" colspan="3"><tag:old_rank /></td>
     </tr>


     <tr>
     <td class="header">Time to expire</td>
      <td class="lista" colspan="3"><select name="t_days">
      <option value="7">1 Week</option>
      <option value="35">5 Weeks</option>
      <option value="70">10 Weeks</option>
      <option value="140">20 Weeks</option>
      <option value="210">30 Weeks</option>
      <option value="280">40 Weeks</option>
      <option value="350">50 Weeks</option>
       <option value="31">One Month</option>
      <option value="182">Half Year</option>
      <option value="365">One Year</option>
      <option value="730">Two Years</option>
      </select>&nbsp;&nbsp;<input type="submit" class="btn" value="<tag:language.UPDATE />"></td>

      
        </form>
    
     <form method="post" action="index.php?page=don_hist&amp;id=<tag:id />">
     <input type="hidden" name="returnto" value="index.php?page=userdetails&amp;id=<tag:id />">
     <tr>
     <td class="header" colspan="3" text align="center"><b>Donation Historie</b></td>
     </tr>
     <tr>
     <td class="header">Donation Historie</td>
     <td class="lista"><tag:donations /></td>
     </tr>
     <tr>
     <td class="header">Donation Amount</td>
     <td class="lista"><input type="text" name="don_amount" size="4" /></td>
     <td class="lista" valign="middle"><center><input type="submit" class="btn" value="<tag:language.UPDATE />"></center></td></tr>
     <tr>
     <td class="header" colspan="3"></td>
     </tr>
     </form>
      

  <tr>

    <td class="header"><tag:language.USER_LEVEL /></td>

    <td class="lista" colspan="3"><tag:userdetail_level_admin /></td>

  </tr>

  <else:userdetail_edit_admin>

  <tr>

    <td class="header"><tag:language.USER_LEVEL /></td>

    <td class="lista"><tag:userdetail_level /></td>

  </tr>

  </if:userdetail_edit_admin>
         
 <if:dt_invited>        
  <tr>

    <td class="header"><tag:language.USER_INVITATIONS /></td>

    <td class="lista"><tag:userdetail_invs /></td>

  </tr>
  
    <tr>

    <td class="header">Users Invited</td>

    <td class="lista"><a href="index.php?page=modules&module=invite&amp;id=<tag:id />">Show</a></td>

  </tr>
  </if:dt_invited> 
  
  <if:was_invited>

  <tr>

    <td class="header"><tag:language.USER_INVITED_BY /></td>

    <td class="lista"><tag:userdetail_invby /></td>

  </tr>

  </if:was_invited>

    
  <tr>

    <td class="header"><tag:language.CUSTOM_TITLE /></td>

    <td class="lista" colspan="2"><tag:custom_title /></td>

  </tr>


    <tag:timed_rank_header /></td>

    <tag:timed_rank_title /></td>
      

  <tr>

    <td class="header"><tag:language.USER_JOINED /></td>

    <td class="lista" colspan="<tag:userdetail_colspan />"><tag:userdetail_joined /></td>

  </tr>

  <tr>

    <td class="header"><tag:language.USER_LASTACCESS /></td>

    <td class="lista" colspan="<tag:userdetail_colspan />"><tag:userdetail_lastaccess /></td>

  </tr>

  <tr>

    <td class="header"><tag:language.PEER_COUNTRY /></td>

    <td class="lista" colspan="2"><tag:userdetail_country /></td>

  </tr>
      <tr>

    <td class="header">Invisible for other users:</td>

    <td class="lista" colspan="2"><tag:userdetail_invisible /></td>

  </tr>
  

  <tr>

    <td class="header"><tag:language.USER_LOCAL_TIME /></td>

    <td class="lista" colspan="2"><tag:userdetail_local_time /></td>

  </tr>

  <tr>

    <td class="header"><tag:language.DOWNLOADED /></td>

    <td class="lista" colspan="2"><tag:userdetail_downloaded /></td>

  </tr>

  <tr>

    <td class="header"><tag:language.UPLOADED /></td>

    <td class="lista" colspan="2"><tag:userdetail_uploaded /></td>

  </tr>
	
	<tr>

    <td class="header"><b><tag:language.VISITS /></b></td>

    <td class="lista" colspan="2"><tag:userdetail_hits /></td>

  </tr>

  <tr>

    <td class="header"><tag:language.RATIO /></td>

    <td class="lista" colspan="2"><tag:userdetail_ratio /></td>

  </tr>

    <tr>

    <td class="header"><tag:language.POINTS /></td>

    <td class="lista" colspan="2"><tag:userdetail_bonus /></td>

  </tr>

  

  <if:userdetail_forum_internal>

  <tr>

    <td class="header"><b><tag:language.FORUM /></b>&nbsp;<b><tag:language.POSTS /></b></td>

    <td class="lista" colspan="2"><tag:userdetail_forum_posts /></td>

  </tr>

  <else:userdetail_forum_internal>

  </if:userdetail_forum_internal>

  <if:userdetail_clientinfo>
  <tr>
    <td class="header">Client/Port Info</td>
    <td class="lista" colspan="2"><tag:client_history_text /></td>
  </tr>
  
  <else:userdetail_clientinfo>
  </if:userdetail_clientinfo>

  
      <tr>
      

    <td class="header">Report</td>

    <td class="lista" colspan="2"><tag:rep /></td>

  </tr>
  
</table><!-- Begin Admin Control Panel -->
<if:comment_access>
<table width=100%>
  <tr>
    <td class="block" align=center colspan=3><b><tag:language.ADMIN_CONTROLS /></b></td>
  </tr>
  <!-- Begin User comment -->
  <form method="post" action="index.php?page=mod_comment&amp;id=<tag:id />">
  <input type="hidden" name="returnto" value="index.php?page=userdetails&amp;id=<tag:id />"> 
  <tr>
    <td class="header"><tag:language.USERCOMMENT /></td>
    <td class="lista"><textarea cols="50" rows="4" name="modcomment"><tag:modcomment /></textarea></td>
    <td class="lista" valign="middle"><center><input type="submit" class="btn" value="<tag:language.UPDATE />"></center></td>
  </tr>
  </form>
  <!-- end User comment -->

  <!-- support comment -->
  <form method="post" action="index.php?page=sup_comment&amp;id=<tag:id />">
  <input type="hidden" name="returnto" value="index.php?page=userdetails&amp;id=<tag:id />"> 
  <tr>
    <td class=header><tag:language.HELPED_FOR /></td>
    <td align=left class=lista><textarea cols="50" rows="4" name="supcomment"><tag:supcomment /></textarea></td>
    <td class="lista" valign="middle"><center><input type="submit" class="btn" value="<tag:language.UPDATE />"></center></td>
  </tr>
  </form>
</table>
<!-- end support comment -->

<else:comment_access>
</if:comment_access>
<!-- End Admin Control Panel -->
<if:booted_access>
<table class="lista" width="100%"> 
   <tr>
    <td class="block" align="center" colspan="2"><tag:language.BOOT_DATA /></td>
  </tr>
    <tr>
    <td class="header"><tag:language.BOOT_REASON /></td>
    <td class="lista"><tag:whybooted /></td>
  </tr>
      <tr>
    <td class="header"><tag:language.BOOT_EXPIRE /></td>
    <td class="lista"><tag:addbooted /></td>
  </tr>
      
  <tr>
    <td class="header"><tag:language.BOOT_ADDED /></td>
    <td class="lista"><tag:whobooted /></td>
  </tr>
</table>
<else:booted_access>
</if:booted_access>
<if:adminrebooted_access>
<if:rebooted_access>

<table class="lista" width="100%"> 
   <tr>
    <td class="block" align="center" colspan="2"><tag:language.BOOT_P /></td>
  </tr>
      <tr>
  <form method="post" action="index.php?page=rebooted&amp;id=<tag:id />">
  <input type="hidden" name="returnto" value="index.php?page=userdetails&amp;id=<tag:id />"> 
  <tr>
    <td class="lista" valign="middle"><center><input type="submit" class="btn" value="<tag:language.BOOT_RM />"></center></td>
  </tr>
  </form>
  </tr>
</table>
<else:rebooted_access>
</if:rebooted_access>
<else:adminrebooted_access>
</if:adminrebooted_access>
    <!-- Begin Admin Control Panel -->
    <if:booted0_access>
<if:nobooted_access>
<table width=100%>
  <tr>
    <td class="block" align=center colspan=3><tag:language.BOOT_SET /></td>
        <tr>
    
  </tr>
  </tr>
    <!-- Begin Booted -->
  <form method="post" action="index.php?page=booted&amp;id=<tag:id />">
  <input type="hidden" name="returnto" value="index.php?page=userdetails&amp;id=<tag:id />"> 
  <tr>
    <td class="header"><tag:language.BOOT_TIME /></td>
      <td class="lista" colspan=2><select name="days">
      <option value="1">1 Day</option>
      <option value="7">1 Week</option>
      <option value="14">2 Weeks</option>
      <option value="21">3 Weeks</option>
      <option value="28">4 Weeks</option>
      <option value="91">13 Weeks</option>
      <option value="182">26 Weeks</option>
      <option value="365">1 Year</option></select></td></tr>
      <tr>
      <td class="header"><tag:language.BOOT_MOT /></td>
    <td class="lista"><textarea cols="50" rows="1" name="whybooted"><tag:whybooted /></textarea></td>
    <td class="lista" valign="middle"><center><input type="submit" class="btn" value="<tag:language.UPDATE />"></center></td>
  </tr>
  </form>
  <!-- end Booted -->

<else:nobooted_access>
</if:nobooted_access>
<else:booted0_access>
</if:booted0_access>
<!-- End Admin Control Panel -->
<if:warn_access>
<table class="lista" width="100%"> 
   <tr>
    <td class="block" align="center" colspan="2"><b>Warning Data</b></td>
  </tr>
    <tr>
    <td class="header">Reason for the Warning</td>
    <td class="lista"><tag:warnreason /></td>
  </tr>
      <tr>
    <td class="header">Expire Time</td>
    <td class="lista"><tag:warnadded /></td>
  </tr>
      <tr>
    <td class="header">Warned Times:</td>
    <td class="lista"><tag:warns /></td>
  </tr>
  <tr>
    <td class="header">Warn added by:</td>
    <td class="lista"><tag:warnaddedby /></td>
  </tr>
</table>
<else:warn_access>
</if:warn_access>
<if:adminwarn_access>
<if:rewarn_access>

<table class="lista" width="100%"> 
   <tr>
    <td class="block" align="center" colspan="2"><b>Admin Menu</b></td>
  </tr>
      <tr>
  <form method="post" action="index.php?page=rewarn&amp;id=<tag:id />">
  <input type="hidden" name="returnto" value="index.php?page=userdetails&amp;id=<tag:id />"> 
  <tr>
    <td class="lista" valign="middle"><center><input type="submit" class="btn" value="Remove Warning"></center></td>
  </tr>
  </form>
  </tr>
</table>
<else:rewarn_access>
</if:rewarn_access>
<else:adminwarn_access>
</if:adminwarn_access>
    <!-- Begin Admin Control Panel -->
    <if:nowarn_access>
<if:warns_access>
<table width=100%>
  <tr>
    <td class="block" align=center colspan=3><b>Warning Settings</b></td>
        <tr>
    <td class="header">Warned Times:</td>
    <td class="lista"><tag:warns /></td>
  </tr>
  </tr>
    <!-- Begin warn -->
  <form method="post" action="index.php?page=warn&amp;id=<tag:id />">
  <input type="hidden" name="returnto" value="index.php?page=userdetails&amp;id=<tag:id />"> 
  <tr>
    <td class="header">Warn Time</td>
      <td class="lista"><select name="days">
      <option value="1">1 Day</option>
      <option value="7">1 Week</option>
      <option value="14">2 Weeks</option>
      <option value="21">3 Weeks</option>
      <option value="28">4 Weeks</option>
      <option value="91">13 Weeks</option>
      <option value="182">26 Weeks</option>
      <option value="365">1 Year</option></select></td></tr>
      <tr>
      <td class="header">Warn Motivation</td>
    <td class="lista"><textarea cols="50" rows="1" name="warnreason"><tag:warnreason /></textarea></td>
    <td class="lista" valign="middle"><center><input type="submit" class="btn" value="<tag:language.UPDATE />"></center></td>
  </tr>
  </form>
  <!-- end warn -->

<else:warns_access>
</if:warns_access>
<else:nowarn_access>
</if:nowarn_access>
<!-- End Admin Control Panel -->

<br />
<tag:pagertop />
<table width="100%" class="lista">

  <tr>

    <td class="block" align="center" colspan="7"><b><tag:language.UPLOADED /> <tag:language.TORRENTS /></b></td>

  </tr>

  <tr>

    <td align="center" class="header"><tag:language.TORRENT_STATUS /></td><td align="center" class="header"><tag:language.FILE /></td>

    <td align="center" class="header"><tag:language.ADDED /></td>

    <td align="center" class="header"><tag:language.SIZE /></td>

    <td align="center" class="header"><tag:language.SHORT_S /></td>

    <td align="center" class="header"><tag:language.SHORT_L /></td>

    <td align="center" class="header"><tag:language.SHORT_C /></td>

  </tr>

  <if:RESULTS>

  <loop:uptor>

  <tr>

    <td class="lista" align="center" style="text-align: left;"><tag:uptor[].moder /></td><td class="lista" align="center" style="padding-left:10px;"><tag:uptor[].filename /></td>

    <td class="lista" align="center" style="text-align: center;"><tag:uptor[].added /></td>

    <td class="lista" align="center" style="text-align: center;"><tag:uptor[].size /></td>

    <td class="<tag:uptor[].seedcolor />" align="center" style="text-align: center;"><tag:uptor[].seeds /></td>

    <td class="<tag:uptor[].leechcolor />" align="center" style="text-align: center;"><tag:uptor[].leechs /></td>

    <td class="lista" align="center" style="text-align: center;"><tag:uptor[].completed /></td>

  </tr>

  </loop:uptor>

  <else:RESULTS>

  <tr>

    <td class="lista" align="center" colspan="7"><tag:language.NO_TORR_UP_USER /></td>

  </tr>

  </if:RESULTS>

</table>

<br />
<tag:pagertopact />
<table width="100%" class="lista">

  <tr>

    <td class="block" align="center" colspan="9"><b><tag:language.ACTIVE_TORRENT /></b></td>

  </tr>

  <tr>

    <td align="center" class="header"><tag:language.FILE /></td>

    <td align="center" class="header"><tag:language.SIZE /></td>

    <td align="center" class="header"><tag:language.PEER_STATUS /></td>

    <td align="center" class="header"><tag:language.DOWNLOADED /></td>

    <td align="center" class="header"><tag:language.UPLOADED /></td>

    <td align="center" class="header"><tag:language.RATIO /></td>
    
    <td align="center" class="header">Up Rate</td>
     
    <td align="center" class="header">Dl Rate</td>
     
    <td align="center" class="header">Transfer/hour</td>

    <td align="center" class="header"><tag:language.SHORT_S /></td>

    <td align="center" class="header"><tag:language.SHORT_L /></td>

    <td align="center" class="header"><tag:language.SHORT_C /></td>

  </tr>

  <if:RESULTS_1>

  <loop:tortpl>

  <tr>

    <td align="center" class="lista" style="padding-left:10px;"><tag:tortpl[].filename /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:tortpl[].size /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:tortpl[].status /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:tortpl[].downloaded /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:tortpl[].uploaded /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:tortpl[].peerratio /></td>
    
    <tag:tortpl[].1 />
    
    <tag:tortpl[].3 />
    
    <tag:tortpl[].2 />

    <td align="center" class="<tag:tortpl[].seedscolor />" style="text-align: center;"><tag:tortpl[].seeds /></td>

    <td align="center" class="<tag:tortpl[].leechcolor />" style="text-align: center;"><tag:tortpl[].leechs /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:tortpl[].completed /></td>

  </tr>

  </loop:tortpl>

  <else:RESULTS_1>

  <tr>

    <td class="lista" align="center" colspan="9"><tag:language.NO_ACTIVE_TORR /></td>

  </tr>


  </if:RESULTS_1>

</table>

<br />
<tag:pagertophist />
<table width="100%" class="lista">

  <tr>

    <td class="block" align="center" colspan="10"><b><tag:language.HISTORY /></b></td>

  </tr>

  <tr>

    <td align="center" class="header"><tag:language.FILE /></td>

    <td align="center" class="header"><tag:language.SIZE /></td>

    <td align="center" class="header"><tag:language.PEER_CLIENT /></td>

    <td align="center" class="header"><tag:language.PEER_STATUS /></td>
    
    <td align="center" class="header"><tag:language.SEED_T /></td>

    <td align="center" class="header"><tag:language.DOWNLOADED /></td>

    <td align="center" class="header"><tag:language.UPLOADED /></td>

    <td align="center" class="header"><tag:language.RATIO /></td>

    <td align="center" class="header"><tag:language.SHORT_S /></td>

    <td align="center" class="header"><tag:language.SHORT_L /></td>

    <td align="center" class="header"><tag:language.SHORT_C /></td>

  </tr>

  <if:RESULTS_2>

  <loop:torhistory>

  <tr>

    <td align="center" class="lista" style="padding-left:10px;"><tag:torhistory[].filename /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:torhistory[].size /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:torhistory[].agent /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:torhistory[].status /></td>
    
    <td align="center" class="lista" style="text-align: center;"><tag:torhistory[].seed /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:torhistory[].downloaded /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:torhistory[].uploaded /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:torhistory[].ratio /></td>

    <td align="center" class="<tag:torhistory[].seedscolor />" style="text-align: center;"><tag:torhistory[].seeds /></td>

    <td align="center" class="<tag:torhistory[].leechcolor />" style="text-align: center;"><tag:torhistory[].leechs /></td>

    <td align="center" class="lista" style="text-align: center;"><tag:torhistory[].completed /></td>

  </tr>

  </loop:torhistory>
  <else:RESULTS_2>

  <tr>

    <td class="lista" align="center" colspan="11"><tag:language.NO_HISTORY /></td>

  </tr>

  </if:RESULTS_2>

</table>

<br />

<br />

<center><tag:userdetail_back /></center>

<br />