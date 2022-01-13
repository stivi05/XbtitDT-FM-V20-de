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
ob_start();
global $CURUSER, $TABLE_PREFIX, $btit_settings ,$DBDT;
if (!$CURUSER || $CURUSER["view_users"]=="yes"){

if(isset($_POST['wishsend']) && $_POST['wishsend'] == "wishsend"){
if(!empty($_POST['wishtitle']) AND !empty($_POST['wishcomment']) AND !empty($_POST['wishgenre']) ){

$wishname = $CURUSER["username"];
$wishtitle = ($_POST['wishtitle']);
$wishcomment = ($_POST['wishcomment']);
$wishgenre = ($_POST['wishgenre']);

mysqli_query($GLOBALS["___mysqli_ston"],"INSERT INTO {$TABLE_PREFIX}radio_wish (name, title, comment, genre, date)
            VALUES ('".mysqli_real_escape_string($DBDT,$wishname)."',
                    '".mysqli_real_escape_string($DBDT,$wishtitle)."',
                    '".mysqli_real_escape_string($DBDT,$wishcomment)."',
                    '".mysqli_real_escape_string($DBDT,$wishgenre)."',
                    '".time()."')");
            
//chat
$al =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}chat ORDER BY id DESC LIMIT 1");
$rw=mysqli_fetch_assoc($al);
$ct =  ($rw["count"]+1);  
      
mysqli_query($GLOBALS["___mysqli_ston"],"INSERT INTO {$TABLE_PREFIX}chat (uid, time, name, text, count) VALUES (0,".time().",'System','[color=green]New radio request:[/color] ".$wishtitle." - ".$wishcomment."  - ".$wishgenre." by ". $wishname ."',".$ct.")");
//chat            

$message = "<font color=silver>Your request has been submited to the DJ's.</font>";
}
else
{
          err_msg($language["ERROR"],"Don't leave any fields empty !");
          stdfoot();
          exit();	
}
}
echo "<table width=100% border=0><center><tr>";
echo $message ;
echo "<form action=\"index.php?page=modules&module=Radio_request\" method=\"post\"></td>";
echo "<td class=\"header\" width=15%>Artist :</td>\n";
echo "<td class=\"header\" width=15%><input style=\"margin : 0 auto;\" type=\"text\" name=\"wishtitle\" /></td>\n";
echo "<td class=\"header\" width=15%>Title :</td>\n";
echo "<td class=\"header\" width=15%><input style=\"margin : 0 auto;\" type=\"text\" name=\"wishcomment\" /></td>\n";
echo "<td class=\"header\" width=15%>Genre :</td>\n";
echo "<td class=\"header\" width=15%><input style=\"margin : 0 auto;\" type=\"text\" name=\"wishgenre\" /></td>\n";
echo "<td class=\"header\" width=15%><input type=\"hidden\" name=\"wishsend\"  value=\"wishsend\">\n";
echo "<input style=\"margin : 0 auto;\" type=\"submit\" name=\"submit\" value=\"Post\"/></td>\n";
echo "</from></center></tr></table>";

    
if(isset($_GET['delete'])) 
    {
        if(!is_numeric($_GET['delete'])) die();
        $id = mysqli_real_escape_string($DBDT,$_GET['delete']);
        mysqli_query($GLOBALS["___mysqli_ston"],"DELETE FROM {$TABLE_PREFIX}radio_wish WHERE id='".$id."'");
    }

        $wishsql =mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM {$TABLE_PREFIX}radio_wish ORDER BY date DESC");
        
        echo "<table border=\"0\">\n";
        echo "<tr><td class=\"header\" colspan=5>Radio Requests:</td></tr>\n";
        echo "    <tr ><br />\n";
        echo "     <th class=\"header\" width=20%>User:</th><th class=\"header\" width=20%>Artist:</th><th class=\"header\" width=20%>Title:</th><th class=\"header\" width=20%>Genre:</th><th class=\"header\" width=20%>Date and Time</th>\n";

if ($CURUSER["admin_access"]=="yes")
           echo "<th class=\"header\" width=10%>Action</th>\n";
  
echo "</tr>\n";
        while($wishes = mysqli_fetch_assoc($wishsql))
        {
            $wishname = user_with_color($wishes['name']);
            echo "<tr>\n";
            echo "<td class=\"lista\">".$wishname."</td><td class=\"lista\">".$wishes['title']."</td><td class=\"lista\">".nl2br($wishes['comment'])."</td></td><td class=\"lista\">".nl2br($wishes['genre'])."</td><td class=\"lista\">".date('d-m-Y H:i:s',$wishes['date'])."</td>\n";
			
if ($CURUSER["admin_access"]=="yes")
        echo "<td class=\"lista\"><a href=\"index.php?page=modules&module=Radio_request&delete=".$wishes['ID']."\">Remove</a></td>\n";
            
        echo "</tr>\n";
        }
        echo "</table>\n";


} else {
echo'<center><br><br>Access Denied<center>';
}
$module_out=ob_get_contents();
ob_end_clean();
?>