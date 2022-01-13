<br />
<form name="hitrun" action="<tag:frm_action />" method="post">


  <table class="header" width="85%" align="center">

        
          <tr>


   	<td class="header" colspan="5" width="70%"align="left"><b>Id level is the id of the group you want to apply this rules to </b></td>
    <td class="lista" colspan="2"><input type="text" size="4" name="id_level" maxlength="5" /></td>
  </tr>
  

  
  <tr>

    <td class="header" colspan="5" width="70%"align="left"><b>Min download size is the minimum download inorder to apply the punishment in MB</b></td>
    <td class="lista" colspan="2"><input type="text" size="4" name="min_download_size" maxlength="5" /></td>
  </tr>
  


  <tr>
			<td class="header" colspan="5" width="70%"align="left"><b>Min ratio is the minimum ratio of the torrent inorder to avoid the punishment</b></td>
    <td class="lista" colspan="2"><input type="text" size="4" name="min_ratio" maxlength="5" /></td>
  </tr>
  

        
  <tr>
    			<td class="header" colspan="5" width="70%"align="left"><b>Min seed hours is the minimum seeding hours in order to avoid the punishment</b></td>
    <td class="lista" colspan="2"><input type="text" size="4" name="min_seed_hours" maxlength="5" /></td>
  </tr>
  

  
  <tr>
			<td class="header" colspan="5" width="70%"align="left"><b>Tolerance days is the maximum tolerance in days for completed torrents before applying the punishment</b></td>
    <td class="lista" colspan="2"><input type="text" size="4" name="tolerance_days" maxlength="5" /></td>
  </tr>
  

  
    <tr>
   			<td class="header" colspan="5" width="70%"align="left"><b>Upload punishment is the amount of decrement in MB from the total upload amount if punishment applied</b></td>
    <td class="lista" colspan="2"><input type="text" size="4" name="upload_punishment" maxlength="5" /></td>
  </tr>
  

  

    <tr>
 			<td class="header" colspan="5" width="70%"align="left"><b>Reward system , if enabled hit and runners will not longer punishd if they seed back</b></td>
    <td class="lista"><input type="checkbox" name="reward" /></td>
    </tr>
    <tr>
    
     			<td class="header" colspan="5" width="70%"align="left"><b>Make use off the warning hack to make hit and runners visable for others</b></td>
    <td class="lista"><input type="checkbox" name="warn" />  for <input type="text" size="2" name="days1" maxlength="2" /> days</td>
    </tr>
    
        <tr>

     			<td class="header" colspan="5" width="70%"align="left"><b>How many days the hit and runners will be banned</b></td>
    <td class="lista"><input type="checkbox" name="boot" />  for <input type="text" size="2" name="days2" maxlength="2" /> days</td>
    </tr>
    
            <tr>

     			<td class="header" colspan="5" width="70%"align="left"><b>if enabled user get banned </b></td>
    <td class="lista"><input type="checkbox" name="warnboot" /> after <input type="text" size="2" name="warn3" maxlength="2" /> warnings</td>
    </tr>

    <tr>
  <td colspan="6" class="lista" style="text-align:center"><br><input type="submit" name="action" value="Add New Group" /></td>
  </tr>
  </table>
   </form>
    <table class="header" width="85%" align="center">

<tr>
<td class="header" align="center">ID Level</td>
<td class="header" align="center">Usergroup</td>
<td class="header" align="center">Min Download</td>
<td class="header" align="center">Min Ratio</td>
<td class="header" align="center">Min Seed Time</td>
<td class="header" align="center">Tolerance Days</td>
<td class="header" align="center">Upload Punishment</td>
<td class="header" align="center">Reward</td>
<td class="header" align="center">Warn Symbol</td>
<td class="header" align="center">For Days</td>
<td class="header" align="center">Warn is Ban</td>
<td class="header" align="center">Warn Times</td>
<td class="header" align="center">Ban Users</td>
<td class="header" align="center">For Days</td>
<td class="header" align="center">Delete</td>
</tr>

<loop:hit>
<tr>
    <td class="lista"><tag:hit[].id_level2 /></td>
    <td class="lista"><tag:hit[].user_level2 /></td>
    <td class="lista"><tag:hit[].min_download_size2 /></td>
    <td class="lista"><tag:hit[].min_ratio2 /></td>
    <td class="lista"><tag:hit[].min_seed_hours2 /></td>
    <td class="lista"><tag:hit[].tolerance_days2 /></td>
    <td class="lista"><tag:hit[].upload_punishment2 /></td>
    <td class="lista"><tag:hit[].reward2 /></td>
    <td class="lista"><tag:hit[].warn /></td>
    <td class="lista"><tag:hit[].days1 /></td>
    <td class="lista"><tag:hit[].warnboot /></td>
    <td class="lista"><tag:hit[].days3 /></td>
    <td class="lista"><tag:hit[].boot /></td>
    <td class="lista"><tag:hit[].days2 /></td>
    <td class="lista"><tag:hit[].delete /></td>
</tr>
</loop:hit>


          <tag:hr1 />
          <tag:hr2 />
          <tag:hr3 />
          <tag:hr4 />
          <tag:hr5 />
          <tag:hr6 />
          <tag:hr7 />
          <tag:hr8 />
          <tag:hr9 />
          <tag:hr10 />
          <tag:hr11 />
          <tag:hr12 />
          <tag:hr13 />
          <tag:hr134 />
          <tag:hr14 />
          
<loop:hits>

    <tag:hits[].hr16 />
    <tag:hits[].hr17 />
    <tag:hits[].hr18 />
    <tag:hits[].hr19 />
    <tag:hits[].hr20 />
    <tag:hits[].hr21 />
    <tag:hits[].hr22 />
    <tag:hits[].hr23 />
    <tag:hits[].hr24 />
    <tag:hits[].hr25 />
    <tag:hits[].hr26 />

</loop:hits>

          <tag:hr27 />
          <tag:hr28 />

  </table>