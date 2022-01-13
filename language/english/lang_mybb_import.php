<?php

// mybb_import.php language file uses mybb style langs
global $TABLE_PREFIX, $mybb_prefix;

$l[0]='Yes';
$l[1]='No';
$l[2]='<center><u><strong><font size="4" face="Arial">Stage 1: Initial Requirements</font></strong></u></center><br />';
$l[3]='<center><strong><font size="2" face="Arial">MyBB files present in the "MyBB" folder?<font color="';
$l[4]='">&nbsp;&nbsp;&nbsp; ';
$l[5]='</font></center></strong>';
$l[6]='<br /><center>Please <a target="_new" href="http://mybb.com/">download MyBB</a> and upload the contents of the "upload" folder in the archive to the "mybb" folder.<br />If you don&rsquo;t have an "mybb" folder please create one in your tracker root and upload<br />the contents of  the "mybb" folder to it.<br /><br />Once uploaded p'; // p at end is a lowercase p for use with $l[8]
$l[7]='<br /><center>P'; // P at end is an uppercase p for use with $l[8]
$l[8]='lease install MyBB by <a target="_new" href="mybb/install/index.php">clicking here</a>*<br /><br /><strong>* Please use the same database login details as those used for your tracker,<br />you can use any database prefix you want (excluding the prefix used by the<br />tracker where applicable)<br /><br />';
$l[9]='<font color="#0000FF" size="3">You may refresh this page once you have completed the required task!</font></strong></center>';
$l[10]='<center><strong>MyBB installed?<font color="';
$l[24]='<center><u><strong><font size="4" face="Arial">Stage 3: Importing the tracker members</font></strong></u></center><br />';
$l[25]='<center>Now the database has been setup correctly it&rsquo;s time to start importing the tracker members,<br />This can take some time if you have a large memberbase so please be patient and allow<br />the script to do it&rsquo;s work!<br /><br /><strong>please <a  id="goload" href="'.$_SERVER['PHP_SELF'].'?act=member_import&amp;confirm=yes">click here</a> to proceed</center>';
$l[26]='<center><u><strong><font size="4" face="Arial">Sorry</font></strong></u></center><br />';
$l[27]='<center>Sorry, this is meant to be a use once and discard script and since you&rsquo;ve already used it this file has been locked!</center>';
$l[32]='<center><u><strong><font size="4" face="Arial">Import Complete</font></strong></u></center><br />';
$l[35]='';
$l[36]='<center>Unable to write to:<br /><br /><b>';
$l[37]='</b><br /><br />Please ensure this file is writable then run this script again.</center>';
$l[38]='<center><br /><font color="red" size="4"><b>Access Denied</b></font></center>';
$l[44]="accounts.<br /><br /></center>";
$l[48]="<center>Successfully imported and bridged";
$l[49]="<center><b><span style=\"color:#0000FF;\">Your integrated MyBB Forum should now be ready to use!<br><a href='logout.php'>Go to your forum</a></span></b></center>";
?>