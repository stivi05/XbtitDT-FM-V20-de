<?php
$here=str_replace("\\", "/", dirname(__FILE__));
require_once($here."/include/settings.php");
define("IN_MYBB",true);//allow init to load
require_once $here."/mybb/inc/init.php";
require_once $here."/mybb/inc/functions.php";
require_once $here."/mybb/inc/functions_user.php";
require_once $here."/mybb/inc/functions_rebuild.php";
require_once($here."/language/english/lang_mybb_import.php");
mysql_select_db($database, mysql_connect($dbhost,$dbuser,$dbpass));
(isset($_COOKIE["uid"])?$id=intval($_COOKIE["uid"]):$id=1);
(isset($_COOKIE["pass"])?$pass=$_COOKIE["pass"]:$pass="");

$res=mysql_query("SELECT u.random, u.password, ul.admin_access FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id WHERE u.id=$id");
$row=mysql_fetch_assoc($res);
if(md5($row["random"] . $row["password"] . $row["random"])!=$pass || $row["admin_access"]=="no")
    die($l[38]);

$lock=mysql_fetch_assoc(mysql_query("SELECT random FROM {$TABLE_PREFIX}users WHERE id=1"));
if($lock["random"]==12399)
    die($l[26] . $l[27] . $l[35]);
	
(isset($_GET["act"]) ? $act=$_GET["act"] : $act="");
(isset($_GET["confirm"]) ? $confirm=$_GET["confirm"] : $confirm="");
if($act=="")
die();
if($act=="member_import" && $confirm=="yes")
   {
   $query="SELECT u.id, u.username, u.id_level, u.password, u.email, UNIX_TIMESTAMP(u.joined) joined, u.cip, ul.id as real_level FROM {$TABLE_PREFIX}users u LEFT JOIN {$TABLE_PREFIX}users_level ul on u.id_level=ul.id WHERE u.id >1 GROUP BY u.id ORDER BY u.id ASC";
    $list=mysql_query($query);
    $count=mysql_num_rows($list);
    
    if($count>0)
    {@mysql_query("TRUNCATE TABLE {$mybb_prefix}users");
        while ($account=mysql_fetch_assoc($list))
        {
            
            $username=$account["username"];
            $email=$account["email"];
            $salt = random_str(8);
	    $pass=salt_password($account["password"],$salt);
	    $key=generate_loginkey();
            $joined=time();
	    $id_level=mybb_level_check($account["real_level"]);
            

            mysql_query("INSERT INTO {$mybb_prefix}users (`username`, `password`, `salt`,`loginkey`,`usergroup`,`email`, `regdate`,`regip`,`lastip`,`hideemail`,`receivepms`) VALUES ('$username', '$pass', '$salt','$key',$id_level, '$email',$joined,'$ip_address','$ip_address',1,1)") or die(mysql_error());
            $fid=mysql_insert_id();
			mysql_query("UPDATE {$TABLE_PREFIX}users SET mybb_fid=$fid where id=".$account["id"]);
			mysql_query("UPDATE `{$mybb_prefix}settings` SET `value`=1 where `sid`=61");
			mysql_query("UPDATE `{$mybb_prefix}usergroups` SET `namestyle`='<span style=\"color: orangered;\"><strong>{username}</strong></span>' where `gid`=4");
			mysql_query("UPDATE `{$mybb_prefix}usergroups` SET `namestyle`='<span style=\"color: green;\"><strong>{username}</strong></span>' where `gid`=6");
			rebuild_stats();//rebuild users stats in forum
			$counter=$count;
			header("location:".$_SERVER["PHP_SELF"]."?act=completed&counter=$counter");
        }
		}
}
elseif($act=="completed")
{   $counter=(int)$_GET["counter"];
    // Lock import file from future use and change to ipb mode
    @mysql_query("UPDATE `{$TABLE_PREFIX}settings` SET `value` ='mybb' WHERE `key`='forum'");
    @mysql_query("UPDATE `{$TABLE_PREFIX}users` SET `random`=12399 WHERE `id`=1");
    echo $l[32] . $l[48] . " <b>". $counter . "</b> " . $l[44] . $l[49];
}
function mybb_level_check($level)
{
global $TABLE_PREFIX;
$id_level=mysql_fetch_assoc(mysql_query("SELECT id from ".$TABLE_PREFIX."users_level where id=".$level));
foreach($id_level as $level)
{
switch($level)
{
case'6':
$level=6;
break;
case'7':
case'8':
$level=4;
break;
case'':
default;
$level=2;
}
}
return $level;
}
?>