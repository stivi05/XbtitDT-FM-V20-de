</script>

 	<link href="jscript/date/css/ui-darkness/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
	<script src="jscript/date/js/jquery-1.10.2.js"></script>
	<script src="jscript/date/js/jquery-ui-1.10.4.custom.min.js"></script>

<script>
$(function() {
$("#datepicker").datepicker({  minDate: 0, maxDate: "+12M " , dateFormat: "dd/mm/yy" }).val()
});
</script>

<form name="donate" action="<tag:frm_action />" method="post">
<table class="header" width="100%" align="center">


       <tr>
      <td class="header" align="center" colspan="4"><center><b>You need a Paypal Premier account and IPN or PDT enabled in your Paypal Profile to lett this work !!</b></center></td>
      </tr>
      <tr>
      <td class="header">Test or Real</td>
      <tag:test />
      <td class="header">Units</td>
      <tag:testt />
      </tr>
      <tr>
      <td class="header">IPN or Payment Data Transfer</td>
      <tag:Itest />
      <td class="header">Identity Token:</td>
      <td class="lista"><input type="text" name="identity_token" value="<tag:pp_token />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Vip Rank ID XBTIT</td>
      <td class="lista"><input type="text" name="pp_rank" value="<tag:pp_rank />" size="10" /></td>
      <td class="header">Vip Rank ID SMF</td>
      <td class="lista"><input type="text" name="pp_smf" value="<tag:pp_smf />" size="10" /></td>
      </tr>
      <tr>
      <td class="header">Sandbox Email</td>
      <td class="lista"><input type="text" name="pp_email_sand" value="<tag:pp_email_sand />" size="30" /></td>
      <td class="header">Paypal Email</td>
      <td class="lista"><input type="text" name="pp_email" value="<tag:pp_email />" size="30" /></td>
      </tr>
      <tr>
      <td class="header">Vip between</td>
      <td class="lista">1 and <input type="text" name="pp_today" value="<tag:pp_today />" size="3" />&nbsp; units is&nbsp;<input type="text" name="pp_day" value="<tag:pp_day />" size="3" />&nbsp;vip days per unit</td>
      <td class="header">GB between</td>
      <td class="lista">1 and <input type="text" name="pp_togb" value="<tag:pp_togb />" size="3" />&nbsp; units is&nbsp;<input type="text" name="pp_gb" value="<tag:pp_gb />" size="3" />&nbsp;GB per unit</td>
      </tr>
      <tr>
      <td class="header">Vip between</td>
      <td class="lista"><tag:pp_count /> and <input type="text" name="pp_todayb" value="<tag:pp_todayb />" size="3" />&nbsp; units is&nbsp;<input type="text" name="pp_dayb" value="<tag:pp_dayb />" size="3" />&nbsp;vip days per unit</td>
      <td class="header">GB between</td>
      <td class="lista"><tag:pp_counta /> and <input type="text" name="pp_togbb" value="<tag:pp_togbb />" size="3" />&nbsp; units is&nbsp;<input type="text" name="pp_gbb" value="<tag:pp_gbb />" size="3" />&nbsp;GB per unit</td>
      </tr>
      <tr>
      <td class="header">Vip between</td>
      <td class="lista"><tag:pp_countb /> and up is&nbsp;<input type="text" name="pp_dayc" value="<tag:pp_dayc />" size="3" />&nbsp;vip days per unit</td>
      <td class="header">GB between</td>
      <td class="lista"><tag:pp_countc /> and up is&nbsp;<input type="text" name="pp_gbc" value="<tag:pp_gbc />" size="3" />&nbsp;GB per unit</td>
      </tr>
      <tr>
      <td class="header">Needed<br><font color=red>(Numeric) No points</font></td>
      <td class="lista"><input type="text" name="pp_needed" value="<tag:pp_needed />" size="10" /></td>
      <td class="header">Received<br><font color=red>(Numeric) No points</font></td>
      <td class="lista"><input type="text" name="pp_received" value="<tag:pp_received />" size="10" /></td>
      </tr>
      <tr>
      <td class="header">Due Date</td>
      <td class="lista" width=100%><input type="text" id = "datepicker" name="pp_due_date" value="<tag:pp_due_date />" size="10" /></td>
      <td class="header">Number Donators in Block</td>
      <td class="lista"><input type="text" name="pp_block" value="<tag:pp_block />" size="10" /></td>
      </tr>
      <tr>
      <td class="header">Scrolling Block Tekst</td>
      <td class="lista" ><textarea name="pp_scrol_tekst" rows="3" cols="60"><tag:pp_scrol_tekst /></textarea></td>
      <td class="header">Enable Scroll Line</td>
      <tag:testtt />
      </tr>
      <tr>
      <td class="header">Donation Historie Bridge</td>
      <tag:testttt />
      <td class="header">Donor Star Bridge</td>
      <tag:testtttt />
      </tr>
            <tr>
      <td class="header">Donate for Invite</td>
      <tag:IAtest />
      <td class="header">Amount:</td>
      <td class="lista"><input type="text" name="pp_inv" value="<tag:ppp_inv />" size="10" /></td>
      </tr>
      <tr>
     <td colspan="6" class="lista" style="text-align:center"><br><input type="submit" name="action" value="Update Settings" /></td>
     </tr></table></form>
      
<table class="header" width="100%" align="center">
<tr>

    <td class="header"><center><b>Username</b></center></td>
    <td class="header"><center><b>Anonymous</b></center></td>
    <td class="header"><center><b>Last Name</b></center></td>
    <td class="header"><center><b>E-mail</b></center></td>
    <td class="header"><center><b>Donate Date</b></center></td>
    <td class="header"><center><b>Amount</b></center></td>
    <td class="header"><center><b>Upload</b></center></td>
    <td class="header"><center><b>VIP</b></center></td>
    <td class="header"><center><b>Old Rank</b></center></td>

  </tr>
  <loop:don>
  <tr>
    <td class="lista"><center><tag:don[].Username /></center></td>
    <td class="lista"><center><tag:don[].Anonymous /></center></td>
    <td class="lista"><center><tag:don[].Last_name /></center></td>
    <td class="lista"><center><tag:don[].Email /></center></td>
    <td class="lista"><center><tag:don[].Date /></center></td>
    <td class="lista"><center><tag:don[].Amount /></center></td>
    <td class="lista"><center><tag:don[].Upload /></center></td>
    <td class="lista"><center><tag:don[].Vip /></center></td>
    <td class="lista"><center><tag:don[].Rank /></center></td>


  </tr>
  </loop:don>

</table>


