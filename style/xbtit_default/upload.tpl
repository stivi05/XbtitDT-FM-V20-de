<if:uploffing>
<script type="text/javascript" src="jscript/jquery.jnotify.min.js" ></script>
<link rel="stylesheet" type="text/css" href="jscript/jquery.jnotify.min.css" media="screen" charset="utf-8" />
<script type="text/javascript" src="jscript/jstorage.js"></script>
<script type="text/javascript" src="jscript/sisyphus.min.js"></script>
    <script type="text/javascript">
    var $x = jQuery.noConflict();
    $x(function(){
      $x('#form1').sisyphus({
      autoRelease: false,
        timeout: 15,
        onSave: function() {
          $x.jnotify('Data are saved to Local Storage', 500);
          
          setTimeout(function(){
            $x("select, input, button").show();
          }, 200);
        },
        onRestore: function() {
          $x.jnotify('Data are restored from Local Storage', 500);
          
          setTimeout(function(){
            $x("select, input, button").show();
          }, 200);
        }
      });
      }); 
    </script>
</if:uploffing>   
<script type="text/javascript">

function checkExtension()
{

// for mac/linux, else assume windows
    if (navigator.appVersion.indexOf('Mac') != -1 || navigator.appVersion.indexOf('Linux') != -1)
        var fileSplit = '/';
    else
        var fileSplit = '\\';

    var fileType      = '.torrent';
    var fileName      = document.getElementById('torrent').value; // current value
    var extension     = fileName.substr(fileName.lastIndexOf('.'), fileName.length);

    if (extension!=fileType)
      {
       alert('<tag:language.ERR_PARSER />');
       return false;
    }

    return true;
}

function CheckForm()
{
// file extension
  if (checkExtension()==false)
     return false;

  var cat=document.getElementsByName('category')[0];
// categories
  if (cat.value=='0')
    {
    alert('<tag:language.WRITE_CATEGORY />');
    cat.focus();
    return false;
    }

  var desc=document.getElementsByName('info')[0];

// description
  if (desc.value.length==0)
    {
    alert('<tag:language.EMPTY_DESCRIPTION />');
    desc.focus();
    return false;
    }


// all filled...
  return true;
}

</script>
<center><tag:language.INSERT_DATA /><br /><br /><tag:language.ANNOUNCE_URL /><br /><b><tag:upload.announces /></b><br /></center>
<form id="form1" name="upload" method="post" onsubmit="return CheckForm();" action="index.php?page=upload" enctype="multipart/form-data">
<input type="hidden" name="user_id" size="50" value="" />
  <table class="lista" border="0" width="96%" cellspacing="1" cellpadding="2">
  <if:torb>
    <tr>
      <td class="header"><tag:language.TORRENT_FILE /></td>
      <td class="lista" align="left"><input type="file" id="torrent" name="torrent" /></td>
    </tr>
    </if:torb>
    <if:tora>
    
    <tr>
    <td class="header"><tag:language.TORRENT_FILE /></td>
      <td class="lista" align="left"><input type="file" id="torrent" name="torrent" onchange='CopyName()' /></td>
    </tr>
    </if:tora>

    <tr>
      <td class="header" >IMDB</td>
      <td class="lista" align="left">&nbsp;(optional)&nbsp;<b>tt<b><input type="text" name="imdb" size="10" maxlength="200" />&nbsp; The numbers after tt in the url.</td>
    </tr>


<if:nfob>
 <tr>
      <td class="header"><tag:language.rip /></td>
      <td class="lista" align="left"><tag:ripper /></td>
    </tr>     
</if:nfob>
<if:nfoa>
    <tr>
      <td class="header">NFO</td>
      <td class="lista" align="left"><sup>Optionaly choose to browse for nfo file</sup><br /><input type="file" name="nfo" /></td>
    </tr>
</if:nfoa>
        <tr>
      <td class="header" ><tag:language.CATEGORY_FULL /></td>
      <td class="lista" align="left"><tag:upload_categories_combo /></td>
    </tr>
    <tag:upload_teams_combo />
<if:upla>    
    <tr>
      <td class="header" >Language</td>
      <td class="lista" align="left"><select name="language">
										<option value="0">---</option>
										<option value="1">English</option>
										<option value="2">French</option>
										<option value="3">Dutch</option>
										<option value="4">German</option>
										<option value="5">Spanish</option>
										<option value="6">Italian</option>
										<option value="7"><tag:customlang /></option>
										<option value="8"><tag:customlanga /></option>
										<option value="9"><tag:customlangb /></option>
										<option value="10"><tag:customlangc /></option>
										
										
										</select></td>
    </tr>
</if:upla>     
    <tr><td class="header" ><img src="images/youtube.gif"> (optional):</td><td class="lista" align="left"> Only add the YouTube number (example AE96cK4_qBE) !!</td></tr>
    <tr>
      <td class="header" ><img src="images/youtube.gif"> Link</td>
    <td class="lista" align="left"><input type="text" name="youtube_video" size="50" maxlength="200" /></td>
    </tr>
    <if:upload_gold_level>
    <tr>
      <td class="header" ><tag:language.GOLD_TYPE /></td>
      <td class="lista" align="left"><tag:upload_gold_combo /></td>
    </tr>
     </if:upload_gold_level>
    
    

   <if:LEVEL_OK>
   <tr>
      <td class="header" ><tag:language.STICKY_TORRENT /></td>
      <td class="lista" align="left">
      <input type="checkbox" name="sticky"> - <tag:language.STICKY_TORRENT_EXPLAIN />
      </td>
   </tr>
   </if:LEVEL_OK>


     <tag:multie1 />
     <tag:multie2 />
     <tag:multie3 />
     <tag:multie4 />
     <if:torbb>
        <tr>
      <td class="header" ><tag:language.FILE_NAME /></td>
      <td class="lista" align="left"><input type="text" name="filename" size="50" maxlength="200" /></td><input type="hidden" name="moder" value="<tag:moder />" />
    </tr>
    </if:torbb>
    <if:toraa>
        <tr>
      <td class="header" ><tag:language.FILE_NAME /></td>
      <td class="lista" align="left">Name taken from Torrent<input type="hidden" id="filename" name="filename" size="50" maxlength="200" /></td><input type="hidden" name="moder" value="<tag:moder />" />
    </tr>
    </if:toraa>
    <if:tagg>
    <tr>
      <td class="header" >Tag</td>
      <td class="lista" align="left"><input type="text" name="tag" size="50" maxlength="200" /></td>
    </tr>
    </if:tagg>
      <if:LEVEL_SC>
      <tr>
      <td class="header">Staff Comment</td>
      <td class="lista" align="left"><textarea name="staff_comment" rows="3" cols="45"></textarea></td>
      </tr>
      </if:LEVEL_SC>
    

<if:imageon>
  <if:uplink>
      <tr>
      <td class="header" ><tag:language.IMAGE /> url (<tag:language.FACOLTATIVE />):</td>
      <td class="lista" align="left"><input type="text" name="userfile" size="50" /></td>
    </tr>
  </if:uplink>
  <if:uplo>
    <tr>
      <td class="header" ><tag:language.IMAGE /> (<tag:language.FACOLTATIVE />):</td>
      <td class="lista" align="left"><input type="file" name="userfile" size="15" /></td>
    </tr>
    </if:uplo>
</if:imageon>


     <if:LEVEL_VT>
        <tr>
      <td class="header">VIP only Torrent</td>
           <td class="lista" align="left">
      <input type="checkbox" name="vip_torrent">

      </td>
    </tr>
     </if:LEVEL_VT>
    
    <tr>
      <td class="header" valign="top"><tag:language.DESCRIPTION /></td>
      <td class="lista" ><tag:textbbcode /></td>
    </tr>

<if:screenon>
    <tr>
      <td class="header"><tag:language.SCREEN /> (<tag:language.FACOLTATIVE />):</td>
      <td class="lista">
      <table class="lista" border="0" cellspacing="0" cellpadding="0">
      <tr>
    <if:uplinkk>
    <tr>
      <td class="lista" align="left"><input type="text" name="screen1" size="50" /></td>
      </tr><tr>
      <td class="lista" align="left"><input type="text" name="screen2" size="50" /></td>
      </tr><tr>
      <td class="lista" align="left"><input type="text" name="screen3" size="50" /></td>
      </tr>
    </if:uplinkk>
    <if:uplok>
      <td class="lista" align="left"><input type="file" name="screen1" size="5" /></td>
      <td class="lista" align="left"><input type="file" name="screen2" size="5" /></td>
      <td class="lista" align="left"><input type="file" name="screen3" size="5" /></td>
    </if:uplok>
      </tr>
      </table>
      </td>
    </tr>
</if:screenon>


    <tr>
      <td class="header"><tag:language.TORRENT_ANONYMOUS /></td>
      <td class="lista">&nbsp;&nbsp;<tag:language.NO /><input type="radio" name="anonymous" value="false" checked="checked" />&nbsp;&nbsp;<tag:language.YES /><input type="radio" name="anonymous" value="true" /></td>
    </tr>
    <tr>
      <td class="header" align="right"><input type="submit" class="btn" value="<tag:language.FRM_SEND />" /></td>
      <td class="header" align="left"><input type="reset" class="btn" value="<tag:language.FRM_RESET />" /></td>
    </tr>
  </table>
</form>