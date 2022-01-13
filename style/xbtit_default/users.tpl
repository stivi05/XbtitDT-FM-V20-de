<div align="center">
  <form action="index.php" name="ricerca" method="get">
  <input type="hidden" name="page" value="users" />
    <table border="0" class="lista">
      <tr>
        <td class="block"><tag:language.FIND_USER /></td>
        <td class="block"><tag:language.USER_LEVEL /></td>
        <td class="block">&nbsp;</td>
      </tr>
      <tr>
        <td><input type="text" name="searchtext" size="30" maxlength="50" value="<tag:users_search />" /></td>
        <td><select name="level">
            <option value="0" <tag:users_search_level />><tag:language.ALL /></option>
            <tag:users_search_select />
            </select>
        </td>
        <td><input type="submit" class="btn" value="<tag:language.SEARCH />" /></td>
      </tr>
</table><br />

<if:view_client_search>
<a href="javascript:animatedcollapse.toggle('slideadvanced')">[Extra Staff Search]</a>

<script type="text/javascript">
animatedcollapse.addDiv('slideadvanced', 'fade=1,speed=1000,persist=1,hide=0')
animatedcollapse.ontoggle=function($, divobj, state){ }
animatedcollapse.init()
</script>

<div id="slideadvanced">
<table border="0" class="lista">

      <tr>
        <td class="block"><tag:language.EMAIL /></td>
        <td class="block"><tag:language.LAST_IP /></td>
        <td class="block"><tag:language.PID /></td>
      </tr>

      <tr>
        <td><input type="text" name="smail" size="18" maxlength="50" value="<tag:smail />" /></td>
        <td><input type="text" name="sip" size="18" maxlength="50" value="<tag:sip />" /></td>
        <td><input type="text" name="pid" size="18" maxlength="48" value="<tag:pid />" /></td>
      </tr>
      
            
      <tr>
        <td colspan="2" class="block">Client</td>
        <td class="block">Port</td>
      </tr>
      <tr>
        <td colspan=2><input type="text" name="client" size="48" maxlength="100" value="<tag:client />" /></td>
        <td><input type="text" name="port" size="5" maxlength="5" value="<tag:port />" /></td>
      </tr>


    </table><br />
</div>
<else:view_client_search>
</if:view_client_search>
</form>
  <tag:users_pagertop />
    <table class="lista" width="95%">
      <tr>
        <td class="header" align="center"><tag:users_sort_username /></td>
        <td class="header" align="center"><tag:users_sort_userlevel /></td>
       <if:user_reputation>
        <td class="header" align="center">Rep</td>
        <else:user_reputation>
        </if:user_reputation>
     
        <td class="header" align="center">Warn Level</td>
        <td class="header" align="center"><tag:users_sort_joined /></td>
        <td class="header" align="center"><tag:users_sort_lastaccess /></td>
        <td class="header" align="center"><tag:users_sort_country /></td>
        <td class="header" align="center"><tag:users_sort_ratio /></td>
	    <td class='header' align='center'><tag:language.STATUS /></td>
	    <td class="header" align="center"><tag:users_pm /></td>
	    <td class="header" align="center"><tag:language.LIST_IGNORE /></td>
	    <td class="header" align="center"><tag:shli /></td>
        <td class="header" align="center"><tag:users_edit /></td>
        <td class="header" align="center"><tag:users_delete /></td>
        <td class="header" align="center"><tag:users_ban /></td>
      
        <td class="header" align="center">Profile</td>
      </tr>
      <if:no_users>
        <tr>
          <td class="lista" colspan="9"><tag:language.NO_USERS_FOUND /></td>
        </tr>
      <else:no_users>
        <loop:users>
          <tr>
            <td class="lista" align="center" style="padding-left:10px;"><tag:users[].username /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].userlevel /></td>
            <if:user_reputation>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].reput /></td>
            <else:user_reputation>
            </if:user_reputation>
     
            <td class="lista" align="center" style="text-align: center;"><tag:users[].warns /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].joined /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].lastconnect /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].flag /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].ratio /></td>
	        <td class="lista" align="center" style="text-align: center;"><tag:users[].status /></td>
	        <td class="lista" align="center" style="text-align: center;"><tag:users[].pm /></td>
	        <td class="lista" align="center" style="text-align: center;"><tag:users[].ignore /></td>
	        <td class="lista" align="center" style="text-align: center;"><tag:users[].shit /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].edit /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].delete /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].ban /></td>
            <td class="lista" align="center" style="text-align: center;"><tag:users[].private /></td>
          </tr>
        </loop:users>
      </if:no_users>
    </table>
</div>
<br />