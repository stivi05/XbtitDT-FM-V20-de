<if:ACTIVE>
<form action="<tag:URL_FORM_DUMP />" method="post"> 
      <table class="header" width="100%" align="center">    
      <tr>
      <td class="header" colspan="4"><img src="images/torrentsdumper/<tag:ICON />"> <b>Dump rss feed of <tag:TRACKERNAME /></b></td>
      </tr>
      <tr>
      <td class="header" colspan="1">Categorie to dump</td> 
      <td class="lista" colspan="3">
		 <tag:torrent_categories />
	  </td>
      </tr> 
      <tr>
      <td class="header" colspan="1">User uploader</td> 
      <td class="lista" colspan="3">
		  <input type="text" name="uploaderid" size="10" />
	  </td>
      </tr> 
      <tr>
      <td class="header" colspan="1">Dump all torrent of this page</td> 
      <td class="lista" colspan="3">
		  <input type="hidden" name="dump" />
		  <input type="hidden" name="<tag:FORM_NAME />" value="<tag:FORM_VALUE />" />
		  <input type="submit" type="submit" value="DUMP" />
	  </td>
      </tr> 
      </table>
</form>

      <table class="header" width="100%" align="center">   
      <tr>
      <td class="header" align="center" colspan="4"><b>Dump Rss Feed</b></td>
      </tr>
		<td class="lista" colspan="3">
		<tag:getFeed />
		</td>
      </table>
<else:ACTIVE>

      <table class="header" width="100%" align="center">  


      <form action="<tag:frm_action_fenopy />" method="post">
      <tr>
      <td class="header" colspan="4"><img src="images/torrentsdumper/faviconFenopy.ico"> <b>Dump rss feed of Fenopy.eu</b></td>
      </tr>
      <tr>
      <td class="header" colspan="1">Check keyword</td>
      <td class="lista" colspan="3">
		  	<input type="text" name="fenopy" />
		<input type="submit" name="action" value="View Torrents"  />
	  </td>
      </tr>  
     </form> 

      <form action="<tag:frm_action_mnova />" method="post">
      <tr>
      <td class="header" colspan="4"><img src="images/torrentsdumper/faviconMnova.ico"> <b>Dump rss feed of mnova.eu</b></td>
      </tr>
      <tr>
      <td class="header" colspan="1">Check keyword</td>
      <td class="lista" colspan="3">
		  	<input type="text" name="mnova" />
		<input type="submit" name="action" value="View Torrents"  />
	  </td>
      </tr>  
     </form> 

      <form action="<tag:frm_action_bitsnoop />" method="post">  
      <tr>
      <td class="header" colspan="4"><img src="images/torrentsdumper/faviconBitsnoop.ico"> <b>Dump rss feed of Bitsnoop.com</b></td>
      </tr>
      <tr>
      <td class="header" colspan="1">New Torrents (Last Hour)</td> 
      <td class="lista" colspan="3">
	  	<SELECT name="bitsnoop" height="200%">
	  		<OPTION VALUE="http://bitsnoop.com/api/latest_tz.php?t=all">All torrents</OPTION>
		  	<OPTION VALUE="http://bitsnoop.com/api/latest_tz.php?t=verified">Verified torrents</OPTION>
		</SELECT>
		<input type="submit" name="action" value="View Torrents" />
	  </td>
      </tr> 
      </form>  

      <form action="<tag:frm_action_extratorrent />" method="post">
      <tr>
      <td class="header" colspan="4"><img src="images/torrentsdumper/faviconExtra.ico"> <b>Dump rss feed of extratorrent.com</b></td>
      </tr>
      <tr>
      <td class="header" colspan="1">Select categorie</td> 
      <td class="lista" colspan="3">
	  	<SELECT name="extratorrent">
	  		<OPTION VALUE="http://extratorrent.com/rss.xml?cid=4&type=last">Movies torrents</OPTION>
		  	<OPTION VALUE="http://extratorrent.com/rss.xml?cid=8&type=last">TV torrents</OPTION>
		  	<OPTION VALUE="http://extratorrent.com/rss.xml?cid=5&type=last">Music torrents</OPTION>
		  	<OPTION VALUE="http://extratorrent.com/rss.xml?cid=7&type=last">Software torrents</OPTION>
		  	<OPTION VALUE="http://extratorrent.com/rss.xml?cid=3&type=last">Games torrents</OPTION>
		  	<OPTION VALUE="http://extratorrent.com/rss.xml?cid=1&type=last">Anime torrents</OPTION>
		  	<OPTION VALUE="http://extratorrent.com/rss.xml?cid=2&type=last">Books torrents</OPTION>
		  	<OPTION VALUE="http://extratorrent.com/rss.xml?cid=6&type=last">Pictures torrents</OPTION>
		  	<OPTION VALUE="http://extratorrent.com/rss.xml?cid=416&type=last">Mobile torrents</OPTION>
			<OPTION VALUE="http://extratorrent.com/rss.xml?cid=553&type=last">Porn DVD</OPTION>
			<OPTION VALUE="http://extratorrent.com/rss.xml?cid=552&type=last">Porn Video</OPTION>
		</SELECT>
		<input type="submit" name="action" value="View Torrents" />
	  </td>
      </tr>  
      </form> 
 
      <form action="<tag:frm_action_kat />" method="post">
      <tr>
      <td class="header" colspan="4"><img src="images/torrentsdumper/faviconKat.ico">  <b>Dump rss feed of kat.ph</b></td>
      </tr>
      <tr>
      <td class="header" colspan="1">Select categorie</td>
      <td class="lista" colspan="3">
		  	<SELECT name="kat">
		  		<OPTION VALUE="http://kat.ph/movies/?rss=2">Movies torrents</OPTION>
			  	<OPTION VALUE="http://kat.ph/tv/?rss=2">TV torrents</OPTION>
			  	<OPTION VALUE="http://kat.ph/music/?rss=2">Music torrents</OPTION>
			  	<OPTION VALUE="http://kat.ph/applications/?rss=2">Applications torrents</OPTION>
			  	<OPTION VALUE="http://kat.ph/games/?rss=2">Games torrents</OPTION>
			  	<OPTION VALUE="http://kat.ph/anime/?rss=2">Anime torrents</OPTION>
			  	<OPTION VALUE="http://kat.ph/books/?rss=2">Books torrents</OPTION>
		 
			</SELECT>
		<input type="submit" name="action" value="View Torrents" />
	  </td>
      </tr>  
     </form> 




      <form action="<tag:frm_action_btchat />" method="post">
      <tr>
      <td class="header" colspan="4"><img src="images/torrentsdumper/faviconBtchat.ico"> <b>Dump rss feed of bt-chat.com</b></td>
      </tr>
      <tr>
      <td class="header" colspan="1">Select categorie</td>
      <td class="lista" colspan="3">
		  	<SELECT name="btchat" >
		  		<OPTION VALUE="http://rss.bt-chat.com/?cat=4">Movies torrents</OPTION>
			  	<OPTION VALUE="http://rss.bt-chat.com/?cat=9">TV torrents</OPTION>
			  	<OPTION VALUE="http://rss.bt-chat.com/?cat=5">Music torrents</OPTION>
			  	<OPTION VALUE="http://rss.bt-chat.com/?cat=8">Applications torrents</OPTION>
			  	<OPTION VALUE="http://rss.bt-chat.com/?cat=3">Games torrents</OPTION>
			  	<OPTION VALUE="http://rss.bt-chat.com/?cat=2">Books torrents</OPTION>
			  	<OPTION VALUE="http://rss.bt-chat.com/?cat=7">Pictures torrents</OPTION>
		 
			</SELECT>
		<input type="submit" name="action" value="View Torrents"  />
	  </td>
      </tr>  
     </form> 

      <form action="<tag:frm_action_limetorrents />" method="post">
      <tr>
      <td class="header" colspan="4"><img src="images/torrentsdumper/faviconLime.ico"> <b>Dump rss feed of Limetorrents.com</b></td>
      </tr>
      <tr>
      <td class="header" colspan="1">Select categorie</td> 
      <td class="lista" colspan="3">
	  	<SELECT name="limetorrents">
	  		<OPTION VALUE="http://www.limetorrents.com/rss/16/">Movies torrents</OPTION>
		  	<OPTION VALUE="http://www.limetorrents.com/rss/20/">TV torrents</OPTION>
		  	<OPTION VALUE="http://www.limetorrents.com/rss/17/">Music torrents</OPTION>
		  	<OPTION VALUE="http://www.limetorrents.com/rss/2/">Software torrents</OPTION>
		  	<OPTION VALUE="http://www.limetorrents.com/rss/8/">Other torrents</OPTION>
		</SELECT>
		<input type="submit" name="action" value="View Torrents" />
	  </td>
      </tr>  
      </form>  

      <form action="<tag:frm_action_thepiratebay />" method="post">
      <tr>
      <td class="header" colspan="4"><img src="images/torrentsdumper/faviconPb.ico"> <b>Dump rss feed of thepiratebay.is</b></td>
      </tr>
      <tr>
      <td class="header" colspan="1">Select categorie</td> 
      <td class="lista" colspan="3">
	  	<SELECT name="thepiratebay">
	  		<OPTION VALUE="http://rss.thepiratebay.se/200">Movies torrents</OPTION>
		  	<OPTION VALUE="http://rss.thepiratebay.se/205">TV torrents</OPTION>
		  	<OPTION VALUE="http://rss.thepiratebay.se/100">Music torrents</OPTION>
		  	<OPTION VALUE="http://rss.thepiratebay.se/300">Software torrents</OPTION>
		  	<OPTION VALUE="http://rss.thepiratebay.se/400">Games torrents</OPTION>
		  	<OPTION VALUE="http://rss.thepiratebay.se/601">Books torrents</OPTION>
		  	<OPTION VALUE="http://rss.thepiratebay.se/603">Pictures torrents</OPTION>
			<OPTION VALUE="http://rss.thepiratebay.se/500">Porn DVD</OPTION>
		</SELECT>
		<input type="submit" name="action" value="View Torrents" />
	  </td>
      </tr>  
      </form>  


  
     </table>
</if:ACTIVE>    