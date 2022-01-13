<?php
$here=str_replace("\\", "/", dirname(__FILE__));
echo "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html>
  <head>
  <title>MyBB Import</title>
  <meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />
  <link rel=\"stylesheet\" href=\"".$here."/style/xbtit_default/main.css\" type=\"text/css\" />
  </head>
  <body>
";
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

$mybb_conf=$here."/mybb/inc/config.php";

if(file_exists($mybb_conf))
    $conf_exists=true;
else
    $conf_exists=false;
	
($conf_exists===false ? $files_present=$l[1] : $files_present=$l[0]);

if($conf_exists==true)
{
    $filename=$here."/mybb/inc/config.php";
    $fd=fopen($filename,"r");
    $data=fread($fd,filesize($filename));
    $start=strpos($data, "\$config['database']['table_prefix']");
    $end=strpos(substr($data,$start),";")+1;
	$data=substr($data,$start,$end);
	$data=str_replace('$config[\'database\'][\'table_prefix\']','$mybb_prefix',$data);
	fclose($fd);
	
    
    $filename=dirname(__FILE__)."/include/settings.php";
    if (file_exists($filename))
    {
        if (is_writable($filename))
        {
            $filesize=filesize($filename);
            $fd = fopen($filename, "w");
            $contents ="<?php\n\n";
            $contents.="\$dbhost = \"$dbhost\";\n";
            $contents.="\$dbuser = \"$dbuser\";\n";
            $contents.="\$dbpass = \"$dbpass\";\n";
            $contents.="\$database = \"$database\";\n";
            $contents.= "\$TABLE_PREFIX = \"$TABLE_PREFIX\";\n";
            $contents.= $data."\n";
            $contents.= "\n?>";
            fwrite($fd,$contents);
            fclose($fd);
        }
        else
            die($l[36] . $filename . $l[37]);
    } 
}

(isset($_GET["act"]) ? $act=$_GET["act"] : $act="");
(isset($_GET["confirm"]) ? $confirm=$_GET["confirm"] : $confirm="");


if($act=="")
{
        echo $l[2];
        echo $l[3] . (($files_present==$l[0]) ? "#00FF00" : "#FF0000") . $l[4] . $files_present .  $l[5];
        if($files_present==$l[1])
            die($l[6] . $l[8] . $l[9] . $l[35]);
			$count=0;
    $tablelist=mysql_query("SHOW TABLES LIKE '".$mybb_prefix."%'"); 
    $count=mysql_num_rows($tablelist);
    (($count<70) ? $mybb_installed=$l[1] : $mybb_installed=$l[0]);
    
    echo $l[10] . (($mybb_installed==$l[0]) ? "#00FF00" : "#FF0000") . $l[4] . $mybb_installed .  $l[5];
    if($mybb_installed==$l[1])
        die($l[7] . $l[8] . $l[9] . $l[35]);
		
		die($l[24] . $l[25] . $l[35]);
		}
   elseif($act=="member_import" && $confirm=="yes")
   {//reduce some load to the import page.
   echo"<center><font size='5'><b><u>Member Import</u></b></font><br>Click start to import all users.<br><br><div id='output' align='center'><div><button class='btn' id=\"goload\">Start</button>
   <script type=\"text/javascript\" src=\"jscript/mybb.init.js\"></script>

    <script type=\"text/javascript\">
	    
        $('#goload').click(function(){
		$('#output').empty().html('<center><img src=\"images/ajax-loader.gif\"></center>');
        $('#output').load('init.mybb_import.php?act=member_import&confirm=yes').show();
        });
    </script>";
}
?>