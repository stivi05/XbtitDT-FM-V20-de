<script type="text/javascript">
function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
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
}
</script>
	<table width="90%" align="center">
  <tr>
    <td>
      <table width="100%" class="lista" cellspacing=1>  
     <loop:tora>
    <tag:tora[].rp0 /> 
               <tr>
          <tag:tora[].rp1 />
          <tag:tora[].rp2 />
          <tag:tora[].rp3 />
          <tag:tora[].rp4 />
          <tag:tora[].rp5 />
          <tag:tora[].rp6 />
          <tag:tora[].rp7 />
          <tag:tora[].rp8 />
          <tag:tora[].rp9 />
          <tag:tora[].rp10 />
          </tr>
          <tr>
          <tag:tora[].rp11 />
          <tag:tora[].rp12 />
          <tag:tora[].rp13 />
          <tag:tora[].rp14 />
          <tag:tora[].rp15 />
          <tag:tora[].rp16 />
          <tag:tora[].rp17 />
          <tag:tora[].rp18 />
          <tag:tora[].rp19 />
          <tag:tora[].rp20 />
               </tr>
          </loop:tora>
      </table>
    </td>
  </tr>
</table><br>
  
<div align="center">

<form action="<tag:torrent_script />" method="get" name="torrent_search">
  <input type="hidden" name="page" value="torrents" />
  <table border="0" class="lista" align="center">
    <tr>
      <td class="block"><tag:language.TORRENT_SEARCH /></td>
      <td class="block"><tag:language.CATEGORY_FULL /></td>
<td class="block">Uploader</td>

<td class="block"><tag:language.TORRENT_OPTIONS /></td>
           
      <td class="block"><tag:language.TORRENT_STATUS /></td>

      
           <td class="block"><tag:language.FREE_TORRRENT /></td>

                <td class="block">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="text" name="search" size="25" maxlength="50" value="<tag:torrent_search />" /></td>
      <td>
        <tag:torrent_categories_combo />
      </td>
 <td>
        <tag:torrent_uploader_combo />
      </td>

      <td>
        <select name="options" size="1">
        <option value="0" <tag:torrent_selected_file />><tag:language.FIL /></option>
        <option value="1" <tag:torrent_selected_filedes />><tag:language.FILDES /></option>
        <option value="2" <tag:torrent_selected_des />><tag:language.DES /></option>
        </select>
      </td>
           
      <td>
        <select name="active" size="1">
        <option value="0" <tag:torrent_selected_all />><tag:language.ALL /></option>
        <option value="1" <tag:torrent_selected_active />><tag:language.ACTIVE_ONLY /></option>
        <option value="2" <tag:torrent_selected_dead />><tag:language.DEAD_ONLY /></option>
        </select>
      </td>
           <td>
        <select name="gold" size="1">
        <option value="0" <tag:torrent_selected_nog />><tag:language.GOLD_NONE /></option>
        <option value="1" <tag:torrent_selected_takg />><tag:language.FREE_ONLY /></option>
        <option value="2" <tag:torrent_selected_stak />><tag:language.SIL_ONLY /></option>
        <option value="3" <tag:torrent_selected_stak />><tag:language.GOL_ONLY /></option>
        <option value="4" <tag:torrent_selected_stak />><tag:language.GOLD_SILWE /></option>

        </select>
      </td>


      <td><input type="submit" class="btn" value="<tag:language.SEARCH />" /></td>
     </tr>
  </table>
</form>
</div>

<table width="100%">
  <tr>
    <td colspan="2" align="center"> <tag:torrent_pagertop /></td>
  </tr><form name=deltorrent action=index.php?page=torrents&do=del method=post>
  <tr>
    <td>
      <table width="100%" class="lista">  
	  <tr><td class="header" colspan="17"><tag:search_msg /></td></tr>    
        <tr>
          <td align="center" width="45" class="header"><tag:torrent_header_category /></td>
          <td align="center" class="header"><tag:torrent_header_filename /></td>
          <if:WT>
          <td align="center" width="20" class="header"><tag:torrent_header_waiting /></td>
          <else:WT>
          </if:WT>
          <td align="center" width="20" class="header"><tag:torrent_header_download /></td>
          <tag:torrent_header_magnet />
          <td align="center" width="20" class="header">BM</td>
          <td align="center" width="40" class="header"><tag:torrent_header_added /></td>
          <td align="center" width="30" class="header">Age</td>
          <td align="center" width="30" class="header"><tag:torrent_header_seeds /></td>
          <td align="center" width="30" class="header"><tag:torrent_header_leechers /></td>
          <td align="center" width="30" class="header"><tag:torrent_header_complete /></td>
          <if:uploader>
          <else:uploader>
          <td align="center" width="30" class="header"><tag:torrent_header_uploader /></td>
           </if:uploader>
          <td align="center" width="30" class="header"><tag:torrent_header_size /></td>
          <if:XBTT>
          <else:XBTT>
          <td align="center" width="45" class="header"><tag:torrent_header_speed /></td>
          </if:XBTT>
          <if:uplo>
          <td align="center" width="20" class="header">Lang</td>
          </if:uplo>
          <td align="center" width="45" class="header"><tag:torrent_header_average /></td><tag:torrent_header_rec /></td><tag:torrent_header_top /><tag:torrent_header_allow />
        </tr>      
        <loop:torrents>
        <tr>
	<tr>
		<tag:torrents[].dt />
    </tr> 
	<tr>
		<tag:torrents[].dttt />
    </tr>  
          <td align="center" width="45" class="lista" style="text-align: center;<tag:torrents[].color />"><tag:torrents[].category /></td>
          <td class="lista" valign="middle" onMouseOver="this.className='post'" onMouseOut="this.className='lista'" style="padding-left:10px;overflow:auto;<tag:torrents[].color />"><tag:torrents[].filename /></td>
          
          <script>
var g_nExpando=0;
function putItemInState(n,bState)
{
   var oItem,oGif;
      oItem=document.getElementById("descr"+n);
   oGif=document.getElementById("expandoGif"+n);
   
   if (bState=='toggle')
     bState=(oItem.style.display=='block');

   if(bState)
   {
       bState=(oItem.style.display='none');
       bState=(oGif.src='images/plus.gif');
   }
   else
   {
       bState=(oItem.style.display='block');
       bState=(oGif.src='images/minus.gif');
   }
}

function expand(nItem)
{
    putItemInState(nItem,'toggle');
}

function expandAll()
{
    if (!g_nExpando)
    {
        document.all.chkFlag.checked=false;
        return;
    }
    var bState=!document.all.chkFlag.checked;
    for(var i=0; i<g_nExpando; i++)
        putItemInState(i,bState);
}
</script>

          <if:WT1>
          <td align="center" width="20" class="lista" style="text-align: center;<tag:torrents[].color />"><tag:torrents[].waiting /></td>
          <else:WT1>
          </if:WT1>
          <td align="center" width="20" class="lista" style="text-align: center;<tag:torrents[].color />"><tag:torrents[].download /></td>
          <tag:torrents[].magnet />
          <td align="center" width="20" class="lista" style="text-align: center;<tag:torrents[].color />"><tag:torrents[].bookmark /></td>
          <td align="center" width="40" class="lista" style="white-space:wrap; text-align:center;<tag:torrents[].color />"><tag:torrents[].added /></td>
<td align="center" width="30" class="lista" style="text-align:center;<tag:torrents[].color />"><tag:torrents[].age /></td>
      
          <td align="center" width="30" class="<tag:torrents[].classe_seeds />" style="text-align: center;<tag:torrents[].seedcolor />"><tag:torrents[].seeds /></td>
          <td align="center" width="30" class="<tag:torrents[].classe_leechers />" style="text-align: center;<tag:torrents[].leechcolor />"><tag:torrents[].leechers /></td>
          <td align="center" width="30" class="lista" style="text-align: center;<tag:torrents[].color />"><tag:torrents[].complete /></td>
          <if:uploader1>
          <else:uploader1>
          <td align="center" width="30" class="lista" style="text-align: center;<tag:torrents[].color />"><tag:torrents[].uploader /></td>
          </if:uploader1>
          <td align="center" width="45" class="lista" style="text-align: center;<tag:torrents[].color />"><tag:torrents[].size /></td>
         <if:XBTT1>
          <else:XBTT1>
          <td align="center" width="45" class="lista" style="text-align: center;<tag:torrents[].color />"><tag:torrents[].speed /></td>
          </if:XBTT1>
          <if:uploo>
          <td align="center" width="20" class="lista" style="text-align: center;<tag:torrents[].color />"><tag:torrents[].language /></td>
          </if:uploo>
          <td align="center" width="45" class="lista" style="text-align: center;<tag:torrents[].color />"><tag:torrents[].average /></td><tag:torrents[].recommended /><tag:torrents[].top /><tag:torrents[].allow />
        </tr>
        <tr>
		<tag:torrents[].dtt />
    </tr> 
        </loop:torrents>
      </table>
    </td></tr><tr><tag:delit />
  </tr>
  <tr>
    <td colspan="2" align="center"> <tag:torrent_pagerbottom /></td>
  </tr>
</table></form>