<?php
###############################
#                             #
# Name: Select UserBar        #
# Type: Users/Hack            #
# Version: 1.0                #
# Designed for: Xbtit 2.1     #
# Developer: DesMan           #
# WWW: www.aldsys.net         #
# E-mail: desman@aldsys.net   #
# XBTIT DT FM 2015                            #
###############################

/**********
 * Config *
 **********/
$pos_ratio['x'] = 37;
$pos_ratio['y'] = 6;

$pos_upload['x'] = 104;
$pos_upload['y'] = 6;

$pos_download['x'] = 198;
$pos_download['y'] = 6;

$userbar_path = "./images/userbar/";
$file_img = $userbar_path . "digits.png";
$file_ini = $userbar_path . "digits.ini";

/********
 * Main *
 ********/
$userid = intval($_GET['id']);
$uploaded = $downloaded = $ratio = 0;
$userbar = 'userbar_red.png';

if ($userid > 0)
{
  require_once("include/config.php");
  require_once("include/settings.php");
  global $dbhost, $dbuser, $dbpass, $database, $TABLE_PREFIX, $XBTT_USE;
  
  $db = @($GLOBALS["___mysqli_ston"] = mysqli_connect($dbhost,  $dbuser,  $dbpass)) or die("Cannot connect to database!"); 
  ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE $database")) or die("Cannot select database!");

  if ($XBTT_USE)
  {
    $udownloaded="`u`.`downloaded`+IFNULL(`x`.`downloaded`,0) `downloaded`";
    $uuploaded="`u`.`uploaded`+IFNULL(`x`.`uploaded`,0) `uploaded`";
    $utables="`{$TABLE_PREFIX}users` `u` LEFT JOIN `xbt_users` `x` ON `x`.`uid`=`u`.`id`";
  }
  else
  {
    $udownloaded="`u`.`downloaded`";
    $uuploaded="`u`.`uploaded`";
    $utables="`{$TABLE_PREFIX}users` `u`";
  }
	$res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT $uuploaded, $udownloaded, `ub`.`img` FROM $utables LEFT JOIN `{$TABLE_PREFIX}userbars` `ub` ON `ub`.`id`=`u`.`userbar`  WHERE `u`.`id` = '".$userid."'");
	$row = mysqli_fetch_array($res);
	$uploaded = $row['uploaded'];
	$downloaded = $row['downloaded'];
	if($row["downloaded"]>0)
        $ratio = number_format($row["uploaded"]/$row["downloaded"],2);
    else
        $ratio=0.00;
	$userbar = $row['img'];
}

$digits_ini = @parse_ini_file($file_ini) or die("Cannot load Digits Configuration file!");
$digits_img = @imagecreatefrompng($file_img) or die("Cannot Initialize new GD image stream!");
$img = @imagecreatefrompng($userbar_path.$userbar) or die ("Cannot Initialize new GD image stream!");

Generate($ratio,$pos_ratio,false);
Generate($uploaded,$pos_upload,true);
Generate($downloaded,$pos_download,true);

header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
exit;

/************
 * Function *
 ************/

function Generate($value, $position, $units)
{
	global $img,$digits_ini,$digits_img;

	$size = array('b','kb','mb','gb','tb','pb','eb','zb','yb');
	$numbers = number_format($value,2);
	$siz = 'b';
	if ($units)
	{
		for($x=1;$x<9;$x++)
			if ($value>=pow(1024,$x)) { $numbers = number_format($value / pow(1024,$x), 2); $siz = $size[$x]; }
	}


	for ($i=0; $i<strlen($numbers); $i++)
	{
		$d_x=$digits_ini[($numbers[$i]=="."?"dot":$numbers[$i])."_x"];
		$d_w=$digits_ini[($numbers[$i]=="."?"dot":$numbers[$i])."_w"];
		imagecopy($img, $digits_img, $position['x'], $position['y'], $d_x, 0, $d_w, imagesy($digits_img));
		$position['x']+=($d_w - 1);
	}
	if ($units)
	{
		$position['x']+=3;
		$d_x=$digits_ini[$siz."_x"];
		$d_w=$digits_ini[$siz."_w"];
		imagecopy($img, $digits_img, $position['x'], $position['y'], $d_x, 0, $d_w, imagesy($digits_img));
	}
}
?>