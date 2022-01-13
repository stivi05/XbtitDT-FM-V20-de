<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Redistribution and use in source and binary forms, with or without modification,
// are permitted provided that the following conditions are met:
//
//   1. Redistributions of source code must retain the above copyright notice,
//      this list of conditions and the following disclaimer.
//   2. Redistributions in binary form must reproduce the above copyright notice,
//      this list of conditions and the following disclaimer in the documentation
//      and/or other materials provided with the distribution.
//   3. The name of the author may not be used to endorse or promote products
//      derived from this software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR IMPLIED
// WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
// MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
// IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
// SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
// TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
// PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
// LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
// NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
// EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
//
////////////////////////////////////////////////////////////////////////////////////
require"include/functions.php";
dbconn();

global $CURUSER, $TABLE_PREFIX;

if($CURUSER["can_upload"]!="yes")
die();

require("./".load_language("lang_main.php"));
 // get user's style
    $resheet=do_sqlquery("SELECT * FROM {$TABLE_PREFIX}style where id=".$CURUSER["style"]." LIMIT 1",TRUE,$btit_settings["cache_duration"]);
    if (!$resheet)
    {
        $STYLEPATH="$THIS_BASEPATH/style/xbtit_default";
        $STYLEURL="$BASEURL/style/xbtit_default";
    }
    else
    {
        $resstyle=mysqli_fetch_array($resheet);
        $STYLEPATH="$THIS_BASEPATH/".$resstyle["style_url"];
        $STYLEURL="$BASEURL/".$resstyle["style_url"];
    }
   
echo"<link rel=\"stylesheet\" href=\"$STYLEURL/main.css\" TYPE=\"text/css\">";

function nfostrip($nfo)
{
	$match = array("/[^a-zA-Z0-9-+.,&=������:\"���\/\@\(\)\s]/", "/((\x0D\x0A\s*){3,}|(\x0A\s*){3,}|(\x0D\s*){3,})/", "/\x0D\x0A|\x0A|\x0D/");
	$replace = array("", "<br />\n<br />\n", "<br />\n");
	$nfo = preg_replace($match, $replace, trim($nfo));

return $nfo;
}

if(empty($_FILES["nfofile"]["name"]) && (empty($_POST["nfo"])))
echo $language['rip_desc'];

// NFO STRIP FROM TEXTAREA:
if (isset($_POST["submit"]))
	echo "<div style=\"margin-left: 80px;\" align=\"left\">".nfostrip($_POST["nfo"])."</div>";

// NFO FILE UPLOAD:
elseif (isset($_POST["submitup"]) && isset($_FILES["nfofile"]) && !empty($_FILES["nfofile"]["name"])) {

	$nfofile = $_FILES['nfofile']['tmp_name'];
	echo "<center>".$language['rip_done']."<hr></center><div id=\"selection\" style=\"margin-left: 80px;\" align=\"left\" onclick=\"selectText()\">".nfostrip(file_get_contents($nfofile))."</div><script type=\"text/javascript\">
    function selectText() {
        if (document.selection) {
        var range = document.body.createTextRange();
            range.moveToElementText(document.getElementById('selection'));
        range.select();
        }
        else if (window.getSelection) {
        var range = document.createRange();
        range.selectNode(document.getElementById('selection'));
        window.getSelection().addRange(range);
        }
    }
    </script>
";
}
                if(empty($_FILES["nfofile"]["name"]) && (empty($_POST["nfo"]))){		
		?><center>
		<form enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
		<input type="file" name="nfofile" size="20" /><input type="submit" name="submitup" value="Upload!" />
		</form>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
<textarea style="font-size: 11px; width: 90%; height: 200px; margin: 15px; border: 1px solid black;" name="nfo"></textarea>
<br />
<input type="submit" name="submit" value="Rip!" style="width: 100px;" />
</form></center>
<?php
}
?>