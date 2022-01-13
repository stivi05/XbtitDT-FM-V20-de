</script>

 	<link href="jscript/date/css/ui-darkness/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
	<script src="jscript/date/js/jquery-1.10.2.js"></script>
	<script src="jscript/date/js/jquery-ui-1.10.4.custom.min.js"></script>

<script>
$(function() {
$("#datepicker").datepicker({  minDate: 0, maxDate: "+12M " , dateFormat: "yy-mm-dd" }).val()
});
</script>


<br />
<form name="free" action="<tag:frm_action />" method="post">
  <table class="header" width="100%" align="center">
  		<tr>
			<td class="header" colspan="5" width="100%"align="center"><b>Free Leech , if enabled , all torrents ( also new uploads ) will be free Leech , no download will be recorded , only upload</b></td>
        </tr>
        

   <tr>
			<td class="header" width="20%" >Date to expire </td>
            <td class="lista"><input type="text" id ="datepicker" name="expire_date" value="<tag:expire_date />"></td>
   </tr>
		
   <tr>
			<td class="header" width="20%" >Time to expire</td>
			<td class="lista"><input type="text" name="expire_time" value="<tag:expire_time />"><small> [00] must be in whole hours</small></td>
  </tr>
  
      <tr>
			<td class="header" colspan="5" width="100%"align="center"><b>If you want only 1 category Free Leech , select a category below , else leave it ----!</b></td>
    </tr>
  
    <tr>
    <td class="header" width="20%">Category Free Leech</td>
    <td class="lista"><tag:cat /></td>
  </tr>

  <tr>
    <td class="header" width="20%">Enable Free Leech</td>
    <td class="lista"><input type="checkbox" name="free" <tag:free_checked />/></td>
  </tr>
  
<tr>
			<td class="header" colspan="5" width="100%"align="center"><b>Happy Hour , if enabled , Free Leech will be random set for 1 hour a day </b></td>
        </tr>
  
      <tr>
    <td class="header" width="20%">Enable Happy Hour</td>
    <td class="lista"><input type="checkbox" name="happy" <tag:happy_checked />/></td>
  </tr>



  <tr>
    <td colspan="2" class="lista" style="text-align:center;"><input type="submit" class="btn" name="confirm" value="<tag:language.FRM_CONFIRM />" /></td>
  </tr>
</table>
</form>