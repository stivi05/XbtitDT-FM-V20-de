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

function windowunder(link)
{
  window.opener.document.location=link;
  window.close();
}


function disable_button(state)
{
 document.getElementById('ty').disabled=(state=='1'?true:false);
}

at=new sack();

function ShowUpdate()
{
  var mytext=at.response + '';
  var myout=mytext.split('|');
  document.getElementById('thanks_div').style.display='block';
  document.getElementById('loading').style.display='none';
  document.getElementById('thanks_div').innerHTML = myout[0]; //at.response;
  disable_button(myout[1]);
}

function thank_you(ia)
{
  disable_button('1');
  at.resetData();
  at.onLoading=show_wait;
  at.requestFile='thanks.php';
  at.setVar('infohash',"'"+ia+"'");
  at.setVar('thanks',1);
  at.onCompletion = ShowUpdate;
  at.runAJAX();
}

function ShowThank(ia)
{
  at.resetData();
  at.onLoading=show_wait;
  at.requestFile='thanks.php';
  at.setVar('infohash',"'"+ia+"'");
  at.onCompletion = ShowUpdate;
  at.runAJAX();
}

function show_wait()
{
  document.getElementById('thanks_div').style.display='none';
  document.getElementById('loading').style.display='block';
}

</script>


<script type="text/javascript" src="jscript/lightbox.js"></script>
<link rel="stylesheet" href="jscript/lightbox.css" type="text/css" media="screen" />


    <div align="center">
      <table width="100%" class="lista" border="0" cellspacing="5" cellpadding="5">

<if:pie>	  
<tr>
<td align="right" class="header">Stats<br><font color = red>Seeds<br><font color = green>Leechers<br><font color = yellow>Finished</td>
<td class="lista"  align="center">
<script src="jscript/Chart.js"></script>
<canvas id="canvas" height="100" width="100"></canvas>
<script>

		var pieData = [
				{
					value: <tag:dtseed />,
					color: "red"
				},
				{
					value : <tag:dtleech />,
					color : "green"
				}
				,
				{
					value : <tag:dtfin />,
					color : "yellow"
				}
			
			];

	var myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData);
	
</script>
</td></tr>
</if:pie>	      
      
        <tr>
          <td align="right" class="header"><tag:language.FILE />
          <if:MOD>
          <tag:mod_task />
          </if:MOD>
          </td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.filename /></td>
<if:tag>
<tr>
<td align="right" class="header">Tag</td>
<td class="lista" align="center"><tag:torrent.tag /></td>
</tr>
</if:tag>
          <if:or>
          <tr>
          <td align="right" class="header">Pre Time Orlydb</td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.pre /></td>
        </tr>
         </if:or>
         <if:ornuk>
        <tr>
          <td align="right" class="header">Nuked Orlydb</td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.nuk /></td>
        </tr>
        </if:ornuk>  

<if:PRE>        
<tr>
<td align="right" class="header">Pre Time PreDB</td>
<td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.pree /></td>
</tr>
</if:PRE> 
        
<if:uplo>
 <tr>
          <td align="right" class="header"><tag:language.LANGUAGE /></td>
          <td class="lista" align="center"><tag:language /></td>
        </tr>
</if:uplo>        
          	<tr>
	          <td align="right" class="header">Extras</td>
	          <td class="lista" align="center"><tag:torrent.icon /></td>
	        </tr>
        </tr>
<if:MODER>
	        <tr>
	          <td align="right" class="header"><tag:language.TORRENT_MODERATION /></td>
	          <td class="lista" align="center"><tag:torrent.moderation /></td>
	        </tr>
</if:MODER>
        <tr>
          <td align="right" class="header"><tag:language.TORRENT /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><a href="download.php?id=<tag:torrent.info_hash />&amp;f=<tag:torrent.filename />.torrent"><img src='images/download2.png'></a></td>
        </tr>
        <if:MAGNET>
        <tr>
          <td align="right" class="header">Magnet Link</td>
          <td class="lista" align="center"><tag:torrent.magnet /></td>
        </tr>
        </if:MAGNET>
        <if:FORUM_LNK>
        <tr>
          <td align="right" class="header"><tag:language.FORUM /></td>
          <td class="lista" align="center"><tag:torrent.topicid /></td>
        </tr>
        </if:FORUM_LNK>
        <tr>
          <td align="right" class="header"><tag:language.INFO_HASH /></td>
		  
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.info_hash /></td>
        </tr>
		<tag:teamview />
		<tr>
          <td align="right" class="header"><tag:language.ADDTHIS_SHARE2 /></td>
		  <td class="lista" align="center" style="text-align:left;" valign="top"><tag:show_addthis /></td>
        </tr>
      <tr>
          <td align="right" class="header" valign="top"><tag:language.THANKS_USERS /></td>
          <td class="lista" align="center">
              <form action="thanks.php" method="post" onsubmit="return false">
              <div id="thanks_div" name="thanks_div" style="display:block;"></div>
              <div id="loading" name="loading" style="display:none;"><img src="images/ajax-loader.gif" alt="" title="ajax-loader" /></div>
              <input type="image" src='images/saythankyou.png' id="ty" disabled="disabled" value="<tag:language.THANKS_YOU />" onclick="thank_you('<tag:torrent.info_hash />')" /><br>
              <font color = "silver"><b><FONT SIZE=2>Do not forget to thank the uploader...total thanks till now : <font color="red"><b><tag:tcount /></b></font></font></b></td></tr>
			  </form>
              <script type="text/javascript">ShowThank('<tag:torrent.info_hash />');</script>
          </td>
        </tr>
       <tr>
         <td align="right" class="header"><tag:language.SEND_POINTS /></td>
         <td class="lista" align="center" style="text-align:left;" valign="top"><tag:coin /></td>
        </tr>


        <if:IMAGEIS>
        <tr>
          <td align="right" class="header" valign="top"><tag:language.IMAGE /></td>
          <td class="lista" align="center"><a href="<tag:uploaddir /><tag:torrent.image />" data-title="<tag:torrent.filename />" data-lightbox="image-1"><img src="<tag:uploaddir /><tag:torrent.image />" width=<tag:width />></a></td>
        </tr>
        </if:IMAGEIS>
        
        <if:IMAGEIMDB>
        <tr>
          <td align="right" class="header" valign="top"><tag:language.IMAGE /></td>
          <td class="lista" align="center"><a href="<tag:imdbpic />" data-title="<tag:torrent.filename />" data-lightbox="image-1"><img src="<tag:imdbpic />" width=<tag:width />></a></td>
        </tr>
        </if:IMAGEIMDB>


        <tr>
          <td align="right" class="header" valign="top"><tag:language.DESCRIPTION /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><if:nfo><tag:torrent.nfo /></if:nfo><tag:torrent.description /></td>
        </tr>

      <if:imdb>
        <tr><tag:frameit />
          <td align="right" class="header" valign="top">IMDB</td>
          <td class="lista" align="center"><tag:searchit /></td>
        </tr>
      </if:imdb>
        
      <tag:extra />


       <if:LEVEL_SC>
      <tr>
          <td align="right" class="header" >Staff Comment</td>
          <td class="lista" align="center"><tag:torrent.staff_comment /></td>
        </tr>
         </if:LEVEL_SC>
    
        
<if:IMAGESC>
      <tr>
      <td align="right" class="header" valign="top"><tag:language.SCREEN /></td>
      <td class="lista">
      <table class="lista" border="0" cellspacing="0" cellpadding="0">
        <if:SCREENIS1>
          <td class="lista" align="center"><a href="<tag:uploaddir /><tag:torrent.screen1 />" data-title="<tag:torrent.filename /> Screen 1" data-lightbox="image-2"><img src="thumbnail.php?size=150&path=<tag:uploaddir /><tag:torrent.screen1 />"></a></td>
        </if:SCREENIS1>
        <if:SCREENIS2>
          <td class="lista" align="center"><a href="<tag:uploaddir /><tag:torrent.screen2 />" data-title="<tag:torrent.filename /> Screen 2" data-lightbox="image-3"><img src="thumbnail.php?size=150&path=<tag:uploaddir /><tag:torrent.screen2 />"></a></td>
        </if:SCREENIS2>
        <if:SCREENIS3>
          <td class="lista" align="center"><a href="<tag:uploaddir /><tag:torrent.screen3 />" data-title="<tag:torrent.filename /> Screen 3" data-lightbox="image-4"><img src="thumbnail.php?size=150&path=<tag:uploaddir /><tag:torrent.screen3 />"></a></td>
        </if:SCREENIS3>
      </table>
      </td>
      </tr>
</if:IMAGESC>    

<tr>
          <td align="right" class="header"><tag:language.CATEGORY_FULL /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.cat_name /></td>
        </tr>
        <if:YOUTUBE>
<tr>
          <td align="right" class="header"><tag:language.YT /><img src="images/youtube.gif"></td>
          <td class="lista" align="center"><iframe width="560" height="315" src="https://www.youtube.com/embed/<tag:torrent.youtube_video />" frameborder="0" allowfullscreen></iframe></td>
        </tr>
</if:YOUTUBE>
        <tr>
          <td align="right" class="header"><tag:language.RATING /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.rating /></td>
        </tr>
        <tr>
          <td align="right" class="header"><tag:language.SIZE /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.size /></td>
        </tr>
        

        <if:HAVE_SUBTITLE>
        <tr>
          <td align="right" class="header"><tag:language.SUB_T_H /></td>
          <td class="lista" align="center">
              <table>
                <loop:subs>
                <tr>
                  <td align="center"><tag:subs[].flag /></td>
                  <td align="center"><tag:subs[].name /></td>
                </tr>
                </loop:subs>
              </table>
          </td>
        </tr>
        </if:HAVE_SUBTITLE>

<if:DISPLAY_FILES>
        <tr>
        <td align="right" class="header" valign="top"><a name="expand" href="#expand" onclick="javascript:ShowHide('files','msgfile');"><tag:language.SHOW_HIDE /></a></td>
        <td align="left" class="lista">
        <div style="display:none" id="files">
          <table class="lista">
            <tr>
              <td align="center" class="header"><tag:language.FILE /></td>
              <td align="center" class="header"><tag:language.SIZE /></td>
            </tr>
            <loop:files>
            <tr>
              <td align="center" class="lista" style="text-align:left;" valign="top"><tag:files[].filename /></td>
              <td align="center" class="lista" style="text-align:left;" valign="top"><tag:files[].size /></td>
            </tr>
            </loop:files>
          </table>
        </div>
        <div style="display:block" id="msgfile" align="left"><tag:torrent.numfiles /></div>
        </td>
        </tr>
        </if:DISPLAY_FILES>
        <tr>
          <td align="right" class="header"><tag:language.ADDED /></td>
          <td class="lista" style="text-align:left;" valign="top"><tag:torrent.date /></td>
        </tr>
        <if:SHOW_UPLOADER>
        <tr>
          <td align="right" class="header"><tag:language.UPLOADER /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.uploader /></td>
        </tr>
        </if:SHOW_UPLOADER>
        <if:NOT_XBTT>
        <tr>
          <td align="right" class="header"><tag:language.SPEED /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.speed /></td>
        </tr>
        </if:NOT_XBTT>
        <tr>
          <td align="right" class="header"><tag:language.DOWNLOADED /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.downloaded /></td>
        </tr>

        <tr>
          <td align="right" class="header"><tag:language.PEERS /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.seeds />, <tag:torrent.leechers /> = <tag:torrent.peers /></td><tr>
          <td align="right" class="header">Last 10 Snatchers</td>
          <td align="right" class="lista">
          <loop:snatchers>
          <tag:snatchers[].snatch />
          </loop:snatchers> </td>
</tr>
        </tr>
        <tr>
          <td align="right" class="header">Bookmark</td>
          <td class="lista" align="center"><tag:wish /></td>
        </tr>
        
        <tr>
          <td align="right" class="header"><tag:language.details_similar_torrents /></td>
          <td class="lista" align="center"><center><tag:similar /></center></td>
        </tr>
      
             <tr>
              <td align="right" class="header">Report</td>
              <td align="center" class="lista"><tag:rep /></td>
            </tr>
            
            <tr>
              <td align="right" class="header">Reseed Request</td>
              <td align="center" class="lista"><tag:reseed /></td>
            </tr>
           
         <tr>
          <tag:free1 />
          <tag:free2 />
         </tr>
           <if:EXTERNAL>
        <tr>
          <td valign="middle" align="right" class="header"><tag:torrent.update_url /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.announce_url /></td>
        </tr>
        <tr>
          <td valign="middle" align="right" class="header"><tag:language.LAST_UPDATE /></td>
          <td class="lista" align="center" style="text-align:left;" valign="top"><tag:torrent.lastupdate /> (<tag:torrent.lastsuccess />)</td>
        </tr>
        </if:EXTERNAL>
      </table>
<table class="header" width="100%" align="center">
<tr>
<td class="header"><center>All Uploads From This Uploader</center></td>
</tr><td class="lista">
<div class=dmarquee onmouseover=doMStop() onmouseout=doDMarquee()><div><div>
<loop:upl>
<font size = 2><b><tag:upl[].filename /></b>
</loop:upl>
</div>
</dmarquee>
</td></tr>
</table>

<!-- #######################################################
     # view/edit/delete shout, comments -->
     
      <if:VIEW_COMMENTS>
      
            <script type="text/javascript">
                <!--
                function SetAllCheckBoxes(FormName, FieldName, CheckValue) {
                  if(!document.forms[FormName])
                  return;
                  var objCheckBoxes = document.forms[FormName].elements[FieldName];
                  if(!objCheckBoxes)
                  return;
                  var countCheckBoxes = objCheckBoxes.length;
                  if(!countCheckBoxes)
                  objCheckBoxes.checked = CheckValue;
                  else
                  // set the check value for all check boxes
                  for(var i = 0; i < countCheckBoxes; i++)
                  objCheckBoxes[i].checked = CheckValue;
                  document.forms[FormName].elements['all_down'].checked = CheckValue;
                }
                -->
            </script>
            
<form name="deleteallcomments" method="post" action="index.php?page=torrent-details&id=<tag:torrent.info_hash />">

<!-- # End
     ####################################################### --> 

    <a name="comments" />
      <br />
      <br />
      <table width="100%" class="lista">
        <if:INSERT_COMMENT>
        <tr>
          <td align="center" colspan="3">
             <a href="index.php?page=comment&amp;id=<tag:torrent.info_hash />&amp;usern=<tag:current_username />"><img src='images/comment2.png'></a>
          </td>
        </tr>
        </if:INSERT_COMMENT>

<td align="center" colspan="3"><tag:lock /></td>


        <if:NO_COMMENTS>
        <tr>
          <td colspan="3" class="lista" align="center"><tag:language.NO_COMMENTS /></td>
        </tr>
        <else:NO_COMMENTS>
<loop:comments>
        <tr>
        <td align="left" class="header" colspan="2">
        <table width="100%">
        <td align="right">Vote for this comment <tag:comments[].voteu />&nbsp;<tag:comments[].voted />&nbsp;[<tag:comments[].vote_tot /> votes]&nbsp;&nbsp;&nbsp;<tag:comments[].quote /><tag:comments[].edit.delete /></td>
        </table>
        </td>
        </tr>
        <tr>
        <td class="header" align="left" valign="top">
        <table width="140">
        <tr>
          <td>
          <tag:comments[].user />
          <br />
        <if:comments_reputation>
        Reputation: <tag:comments[].reputation />
        <br />
        <else:comments_reputation>
        </if:comments_reputation>
     
          <tag:comments[].date />
          <br />
          <tag:comments[].elapsed />
          <br />
          <tag:comments[].avatar />
          <br />
          <tag:comments[].ratio />
          <br />
          <tag:comments[].uploaded />
          <br />
          <tag:comments[].downloaded />
          </td>
        </tr>
        </table>
        </td>
        <td class="lista" width="100%" valign="top" style="padding:10px">
        <tag:comments[].comment /></td>
        </tr>
        </loop:comments>
        </if:NO_COMMENTS>
      </table>

<!-- #######################################################
     # view/edit/delete shout, comments -->

      <if:MASSDEL_COMMENTS>
                            <br /><div align="right" style="margin-right:8px;">
                            <input type="submit" class="btn" value="<tag:language.FRM_DELETE />" onclick="return confirm('If you are really sure you want to delete selected comments click OK, othervise Cancel!')" />
                            <input type="checkbox" class="btn" name="all_down" onclick="SetAllCheckBoxes('deleteallcomments','delcomment[]',this.checked)" />
                            </div>
      </if:MASSDEL_COMMENTS>
      
</form>      
    
      </if:VIEW_COMMENTS>
      
<!-- # End
     ####################################################### --> 

    
    </div>
    <br />
    <br />
    <div align="center">
      <tag:torrent_footer />
    </div>