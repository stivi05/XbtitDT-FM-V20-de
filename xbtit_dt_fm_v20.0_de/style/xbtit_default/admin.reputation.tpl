<div>
				<table width="100%" border="0" cellpadding="5" cellspacing="0">


					<tr><td>This section allows you to configure the User Reputation system.</td>
								 </tr>
								 </table>
</div>
<br />
<div style="border: 1px solid rgb(131, 148, 178); padding: 5px;">

	<form action="<tag:frm_action />" name="repoptions" method="post">

				<div>Reputation On/Off</div>
					<div style="padding: 5px; background-color: rgb(238, 242, 247);">
							<div style="border: 1px solid rgb(131, 148, 178);">

							<table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Enable User Reputation system?</b><div style="color: gray;">Set this option to enable if you want to enable the User Reputation system.</div></td>

							 <td width="55%"><div style="width: auto;" align="left">&nbsp;&nbsp;Enable &nbsp;<input type=radio name=rep_is_online value=true <tag:onlineyes />/>&nbsp;&nbsp;Disable&nbsp;<input type=radio name=rep_is_online value=false <tag:onlineno />/></div></td>
							 </tr>
				  </table>
				  </div></div>

				  <div>Points Settings</div>
				 <div style="padding: 5px; background-color: rgb(238, 242, 247);">
						<div>
							<table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Start Points</b><div style="color: gray;">How many points a new user will start with ( best = 0 - no reputation yet)</div></td>
							 <td width="55%"><div style="width: auto;" align="left"><input name="rep_default" value="<tag:rep_default />" size="30" type="text"></div></td>
							 </tr>
				  </table>

							<table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Points per Comment</b><div style="color: gray;">How many points a user gets for adding a comment in torrent details</div></td>
							 <td width="55%"><div style="width: auto;" align="left"><input name="rep_undefined" value="<tag:rep_undefined />" size="30" type="text"></div></td>
							 </tr>
				  </table>

					<table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Points per Thank You</b><div style="color: gray;">How many points a user gets for adding a Thank You in torrent details</div></td>
							 <td width="55%"><div style="width: auto;" align="left"><input name="rep_userrates" value="<tag:rep_userrates />" size="30" type="text"></div></td>
							 </tr>

				  </table>
				  <table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Points per Forum Post</b><div style="color: gray;">How many points a user gets for adding a post in the INT forum</div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="rep_pcpower" value="<tag:rep_pcpower />" size="30" type="text"></div></td>
							 </tr>
				  </table>
	  		 <table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Points per Shout</b><div style="color: gray;">How many points a user gets for a shout in shoutbox</div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="rep_kppower" value="<tag:rep_kppower />" size="30" type="text"></div></td>
							 </tr>
				  </table>
	  		 <table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Points per Upload</b><div style="color: gray;">How many points a user gets for uploading a torrent</div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="rep_upload" value="<tag:rep_upload />" size="30" type="text"></div></td>
							 </tr>
				  </table>
				  	  		 <table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Points for donate</b><div style="color: gray;">How many points a user gets for donating to the site</div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="rep_minpost" value="<tag:rep_minpost />" size="30" type="text"></div></td>
							 </tr>
  	  		 <table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Lose points for low ratio</b><div style="color: gray;">How many points a user lose for low ratio <font color= red>without the - </font></div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="rep_minrep" value="<tag:rep_minrep />" size="30" type="text"></div></td>
							 </tr>
							 							 <tr>
							 <td width="30%"><b>Lose points for Hit & Run</b><div style="color: gray;">How many points a user lose for Hit & Run <font color= red>without the - </font></div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="rep_hit" value="<tag:rep_hit />" size="30" type="text"></div></td>
							 </tr>
				  </table>
				  </div></div>

				  <div>Reputation Powers</div>
				 <div style="padding: 5px; background-color: rgb(238, 242, 247);">
							<div style="border: 1px solid rgb(131, 148, 178);">

							<table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Staff Reputation Power</b><div style="color: gray;">How many reputation points does a staff member give or take away with each click?</div></td>
							 <td class="tablerow2" width="55%"><div style="width: auto;" align="left"><input name="rep_adminpower" value="<tag:rep_adminpower />" size="30" type="text"></div></td>

							 </tr>
				  </table>

				  <table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>User Reputation Power</b><div style="color: gray;">How many reputation points does a user give or take away with each click?</div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="rep_rdpower" value="<tag:rep_rdpower />" size="30" type="text">

</div></td>
							 </tr>

				  </table>




				  </div></div>

				  <div>User Reputation Settings</div>
				  <div style="padding: 5px; background-color: rgb(238, 242, 247);">
						<div>



				  <table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Flood Control</b><div style="color: gray;">How many hours a user have to wait for add reputation clicks again? Staff members are exempt from this limit.</div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="rep_maxperday" value="<tag:rep_maxperday />" size="30" type="text"></div></td>
							 </tr>
				  </table>


				  </div></div>
				  				  <div>User Reputation Manager</div>
				 <div style="padding: 5px; background-color: rgb(238, 242, 247);">
							<div style="border: 1px solid rgb(131, 148, 178);">

							<table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Best Reputation</b><div style="color: gray;">Name for best reputation ( equal or higher than 101 points )</div></td>
							 <td class="tablerow2" width="55%"><div style="width: auto;" align="left"><input name="best_level" value="<tag:best_level />" size="30" type="text"></div></td>

							 </tr>
				  </table>

				  <table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Good Reputation</b><div style="color: gray;">Name for good reputation ( between 1 and 100 points )</div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="good_level" value="<tag:good_level />" size="30" type="text">

</div></td>
							 </tr>

				  </table>

				  <table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>No Reputation</b><div style="color: gray;">Name for users who don,t have a reputation yet ( 0 reputation points )</div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="no_level" value="<tag:no_level />" size="30" type="text"></div></td>
							 </tr>
				  </table>
				  				  <table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Bad Reputation</b><div style="color: gray;">Name for users who have a bad reputation( between -1 to - 100 points )</div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="bad_level" value="<tag:bad_level />" size="30" type="text"></div></td>
							 </tr>
				  </table>
				  
				  <table width="100%" border="0" cellpadding="5" cellspacing="0">
							 <tr>
							 <td width="30%"><b>Worse Reputation</b><div style="color: gray;">Name for users who have a worse reputation ( equal or lower than -101 points )</div></td>

							 <td width="55%"><div style="width: auto;" align="left"><input name="worse_level" value="<tag:worse_level />" size="30" type="text"></div></td>
							 </tr>
				  </table>


				  </div></div>
				  
				  <div>Promote & Demote System</div>
				  
				  					<div style="padding: 5px; background-color: rgb(238, 242, 247);">
							<div style="border: 1px solid rgb(131, 148, 178);">

							<table width="100%" border="0" cellpadding="5" cellspacing="0">

				  

      <tr>
     <td width="30%"><b>Enable Promote & Demote System</b><div style="color: gray;">Set this option to enable if you want to enable the Promote & Demote System</div></td>
      <td class="lista">&nbsp;&nbsp;Enable&nbsp;<input type="radio" name="rep_en_sys" value="true"<tag:rep_en_sysyes /> />&nbsp;&nbsp;Disable&nbsp;<input type="radio" name="rep_en_sys" value="false"<tag:rep_en_sysno /> /></td>

      </tr>
        				  </table>
				  </div></div>
      
      
       			  <div style="padding: 5px; background-color: rgb(238, 242, 247);">
						<div>
                         <table width="100%" border="0" cellpadding="5" cellspacing="0">
      <tr>
      <td class="lista"><b>Promote ID </b></td>
      <td class="lista"><input type="text" name="rep_pr_id" value="<tag:rep_pr_id />" size="4" /></td>
      <td class="lista"><b>Demote ID </b></td>
      <td class="lista"><input type="text" name="rep_dm_id" value="<tag:rep_dm_id />" size="4" /></td>
      </tr>
      <tr>
      <td class="lista"><b>Promote Reputation</b></td>
      <td class="lista"><input type="text" name="rep_pr" value="<tag:rep_pr />" size="4" /></td>
      <td class="lista"><b>Demote Reputation</b></td>
      <td class="lista"><input type="text" name="rep_dm" value="<tag:rep_dm />" size="4" /></td>
      </tr>
      <tr>
      <td class="lista" valign="top" colspan="1"><b>Promote PM Text</b></td>
      <td class="lista" colspan="3"><textarea name="rep_pm_text" rows="3" cols="60"><tag:rep_pm_text /></textarea></td>
      </tr>
      <tr>
      <td class="lista valign="top" colspan="1"><b>Demote PM Text</b></td>
      <td class="lista" colspan="3"><textarea name="rep_dm_text" rows="3" cols="60"><tag:rep_dm_text /></textarea></td>
      </tr>
      
      				  </table>


				  </div></div>


<center><input type="submit" name="submit" value="Submit" class="btn" tabindex="2" accesskey="s" /></center>
</form>
</div>
