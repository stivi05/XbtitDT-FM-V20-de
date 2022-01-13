<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    DiemThuy's Custom Alternate Online Block
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

if (!$CURUSER || $CURUSER["view_torrents"]=="no")
   {
       // do nothing
   }
else
   {
$res=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}online WHERE user_group !='guest'");
if(@mysqli_num_rows($res)>0)
{
$total_online = mysqli_num_rows($res); 
echo "<div align='center'><table border='0' align='center' cellpadding='0' cellspacing='0' width='100%'><tr><td>";


     $g_online=get_result("SELECT * FROM {$TABLE_PREFIX}users_level ul ORDER BY id_level DESC",true);
     $totalg_online=count($g_online);
     $group1=array();
     
          foreach($g_online as $id=>$usersg_online)
        {
                if ($usersg_online["id"]>1)
                $group1[]=unesc($usersg_online["prefixcolor"]).unesc($usersg_online["level"]). unesc($usersg_online["suffixcolor"]);
        }
echo "<table border='0' align = 'center'><tr>";
echo "<td  style=font-size:10px; colspan='2' ><center><b>".implode(" | ",$group1)."<b></td></tr></table>";

while($result=mysqli_fetch_array($res))
{
   global $STYLEURL,$btit_settings;

$rest=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE id=".$result["user_id"]);
$row=mysqli_fetch_array($rest);


if ($row["donor"]=="yes") 
 $star="<img src='images/donor.gif'>";
 else
 $star="";

if ($row["immunity"]=="yes") 
 $spp="<img src='images/shield.png'>";
 else
 $spp="";

if ($row["warn"]=="yes") 
 $war="<img src='images/warn.gif'>";
 else
 $war="";
 
if($btit_settings["onav"]==true)
{
$default="<img src='$STYLEURL/images/default_avatar.gif' height=50 width=50>";
((is_null($row["avatar"]) || $row["avatar"]=="")?$avatar=$default:$avatar="<img src='".$row["avatar"]."' height=50 width=50>");

if ($row["invisible"]=="yes")
{ 
$avatar="<img src=images/invisible.png height=50 width=50>";
}
}
if ($row["invisible"]=="yes" AND $CURUSER["admin_access"]=="no")
{ 
if($btit_settings["onav"]==true)
$dtinv="<tr><td  style=font-size:10px;><center><b>Invisible !!</b></a></center></tr></td>";
else
$dtinv=" <b>Invisible !!</b> "; 
}
else
{
if($btit_settings["onav"]==true)
$dtinv="<tr><td  style=font-size:10px;><center><a href='index.php?page=userdetails&id=".$result["user_id"]."'><b>".stripslashes($result[prefixcolor]) . $result[user_name].stripslashes($result[suffixcolor])."</b></a></center></tr></td>";
else
$dtinv=" <a href='index.php?page=userdetails&id=".$result["user_id"]."'><b>".stripslashes($result[prefixcolor]) . $result[user_name].stripslashes($result[suffixcolor])."</b></a> ";
}

// user image
if($btit_settings["uion"]==true)
{
    $do=$btit_settings["img_don"];
    $don=$btit_settings["img_donm"];
    $ma=$btit_settings["img_mal"];
    $fe=$btit_settings["img_fem"];
    $ba=$btit_settings["img_ban"];
    $tu=$btit_settings["img_tru"];
    $vi=$btit_settings["img_vip"];
    $wa=$btit_settings["img_war"];
    $st=$btit_settings["img_sta"];
    $bi=$btit_settings["img_bir"];
    $pa=$btit_settings["img_par"];
    $sy=$btit_settings["img_sys"];
    $vip=$btit_settings["img_vipm"];
    $tut=$btit_settings["img_trum"];  
    $fr=$btit_settings["img_fri"];
    $ju=$btit_settings["img_jun"]; 
    $bo=$btit_settings["img_bot"];
    

$udo="";
$udob="";
$ubir="";
$umal="";
$ufem="";
$uban="";
$uwar="";
$upar="";
$ubot="";
$utrmu="";
$utrmo="";
$uvimu="";
$uvimo="";
$ufrie="";
$ujunk="";
$ustaf="";
$usys="";

if ($row["dona"] == 'yes')
$udo= "&nbsp;<img src='images/user_images/" . $do . "' alt='" . $btit_settings["text_don"] . "' title='" . $btit_settings["text_don"] . "' />";

if ($row["donb"] == 'yes')
$udob= "&nbsp;<img src='images/user_images/" . $don . "' alt='" . $btit_settings["text_donm"] . "' title='" . $btit_settings["text_donm"] . "' />";

if ($row["birt"] == 'yes')
$ubir= "&nbsp;<img src='images/user_images/" . $bi . "' alt='" . $btit_settings["text_bir"] . "' title='" . $btit_settings["text_bir"] . "' />";

if ($row["mal"] == 'yes')
$umal= "&nbsp;<img src='images/user_images/" . $ma . "' alt='" . $btit_settings["text_mal"] . "' title='" . $btit_settings["text_mal"] . "' />";

if ($row["bann"] == 'yes')
$uban= "&nbsp;<img src='images/user_images/" . $ba . "' alt='" . $btit_settings["text_ban"] . "' title='" . $btit_settings["text_ban"] . "' />";

if ($row["war"] == 'yes')
$uwar= "&nbsp;<img src='images/user_images/" . $wa . "' alt='" . $btit_settings["text_war"] . "' title='" . $btit_settings["text_war"] . "' />";

if ($row["fem"] == 'yes')
$ufem= "&nbsp;<img src='images/user_images/" . $fe . "' alt='" . $btit_settings["text_fem"] . "' title='" . $btit_settings["text_fem"] . "' />";

if ($row["par"] == 'yes')
$upar= "&nbsp;<img src='images/user_images/" . $pa . "' alt='" . $btit_settings["text_par"] . "' title='" . $btit_settings["text_par"] . "' />";

if ($row["bot"] == 'yes')
$ubot= "&nbsp;<img src='images/user_images/" . $bo . "' alt='" . $btit_settings["text_bot"] . "' title='" . $btit_settings["text_bot"] . "' />";

if ($row["trmu"] == 'yes')
$utrmu= "&nbsp;<img src='images/user_images/" . $tu . "' alt='" . $btit_settings["text_tru"] . "' title='" . $btit_settings["text_tru"] . "' />";

if ($row["trmo"] == 'yes')
$utrmo= "&nbsp;<img src='images/user_images/" . $tut . "' alt='" . $btit_settings["text_trum"] . "' title='" . $btit_settings["text_trum"] . "' />";

if ($row["vimu"] == 'yes')
$uvimu= "&nbsp;<img src='images/user_images/" . $vi . "' alt='" . $btit_settings["text_vip"] . "' title='" . $btit_settings["text_vip"] . "' />";

if ($row["vimo"] == 'yes')
$uvimo= "&nbsp;<img src='images/user_images/" . $vip . "' alt='" . $btit_settings["text_vipm"] . "' title='" . $btit_settings["text_vipm"] . "' />";

if ($row["friend"] == 'yes')
$ufrie= "&nbsp;<img src='images/user_images/" . $fr . "' alt='" . $btit_settings["text_fri"] . "' title='" . $btit_settings["text_fri"] . "' />";

if ($row["junkie"] == 'yes')
$ujunk= "&nbsp;<img src='images/user_images/" . $ju . "' alt='" . $btit_settings["text_jun"] . "' title='" . $btit_settings["text_jun"] . "' />";

if ($row["staff"] == 'yes')
$ustaf= "&nbsp;<img src='images/user_images/" . $st . "' alt='" . $btit_settings["text_sta"] . "' title='" . $btit_settings["text_sta"] . "' />";

if ($row["sysop"] == 'yes')
$usys= "&nbsp;<img src='images/user_images/" . $sy . "' alt='" . $btit_settings["text_sys"] . "' title='" . $btit_settings["text_sys"] . "' />";

$imgdt=$udo.$udob.$ubir.$umal.$ufem.$uban.$uwar.$upar.$ubot.$utrmu.$utrmo.$uvimu.$uvimo.$ufrie.$ujunk.$ustaf.$usys;
}
else
$imgdt="";
// user image

//bots
$r2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}bots ORDER BY visit DESC LIMIT 1") or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$b2=mysqli_fetch_array($r2);

if (empty($b2["name"]))
{
$bot = "no bot did visit";
$postdt="the last 48 hours";
}
 else
 {
$bot = $b2["name"];
$postdt=date("l jS F Y \a\\t g:i a",strtotime($b2["visit"]));
}
//bots

if($btit_settings["onav"]==true)
{ 
   echo "<table border='0' align='left' cellpadding='2' cellspacing='2' width='8%'><tr><td>";
   echo $dtinv;
   echo "<tr><td><center>".$avatar."</center></td></tr>";
   echo"<tr><td ><center>&nbsp;".$star. $war. $spp.$imgdt."&nbsp;</center></td></tr>";
   echo "</td></tr></table>";
}   
else
echo $dtinv.$star.$war.$spp.$staf.$imgdt;  
}

$sql = "SELECT * FROM {$TABLE_PREFIX}mostonline";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
$details = mysqli_fetch_array($result);

if ($total_online > $details['amount'])
{
    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}mostonline SET amount = $total_online");
    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE {$TABLE_PREFIX}mostonline SET date = now()");
}

$date=date("D, d M Y ", strtotime($details['date']));

$restt=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}users WHERE id=".$CURUSER["uid"]);
$roww=mysqli_fetch_array($restt);

$ontime=NDF($roww["tot_on"]); 

$midnight = date("Y-m-d 00:00:00");

$sql = "SELECT {$TABLE_PREFIX}users_level.prefixcolor AS prefixcolor, {$TABLE_PREFIX}users_level.suffixcolor AS suffixcolor, {$TABLE_PREFIX}users_level.id_level AS levelorder, {$TABLE_PREFIX}users.id AS id,{$TABLE_PREFIX}users.donor AS donor,{$TABLE_PREFIX}users.immunity AS immunity ,{$TABLE_PREFIX}users.warn AS warn , {$TABLE_PREFIX}users.username AS username, {$TABLE_PREFIX}users.invisible AS invisible FROM {$TABLE_PREFIX}users INNER JOIN {$TABLE_PREFIX}users_level ON {$TABLE_PREFIX}users.id_level={$TABLE_PREFIX}users_level.id WHERE lastconnect >='$midnight' ORDER BY levelorder, prefixcolor,username DESC";

$qry=mysqli_query($GLOBALS["___mysqli_ston"], $sql);
$counter = 0;

   echo"<tr><td><table border='0' align='center' cellpadding='0' cellspacing='0' width='100%'>";
   echo"<tr><td align=\"left\">&nbsp;<img src=\"images/whos_online.gif\"><b>&nbsp;  (total users online now: <font color ='red'>".$total_online."</font>)</b></td><td align=\"center\"><img src=\"images/clock.gif\"><b>&nbsp; (your total online time: <font color ='green'>".$ontime."</font>)</b></td><td align=\"right\"><img src=\"images/whos_online.gif\"><b> &nbsp; (most:  <font color ='red'>".$details['amount']."</font> on ".$date.")&nbsp;</b></td></tr></table>";
echo"<br><tr><td><center><hr><b> Total Users Online Today </b></center></tr></td><tr><td><center>" ;  
   while ($res=mysqli_fetch_array($qry))
{
 if (!empty($res["immunity"]))
{
 if ($res["immunity"]=="no") {
 $sp="";
}
 else{
 $sp="<img src='images/shield.png'>";
}
}
if (!empty($res["donor"]))
{
 if ($res["donor"]=="no") {
 $st="";
}
 else{
 $st="<img src='images/donor.gif'>";
}
}
if (!empty($res["warn"]))
{
 if ($res["warn"]=="no") {
 $sa="";
}
 else{
 $sa="<img src='images/warn.gif'>";
}
}
if ($res["invisible"]=="yes")
$staf="<img src='images/invisiblekl.png'>";
else
$staf="";

if ($res["invisible"]=="yes" AND $CURUSER["admin_access"]=="no") {
$DTtwvi=" <b>Invisible!".$st.$sa.$sp."</b> ";
}
else{
$DTtwvi=" <b><a href=\"index.php?page=userdetails&id=$res[id]\">".unesc($res["prefixcolor"]).unesc($res["username"]).unesc($res["suffixcolor"]).$st.$sa.$sp.$staf."</a></b> ";
}

echo $DTtwvi;
$counter++;

}
echo"</center></tr></td>";
echo"<tr><td><table border='0' align='center' cellpadding='0' cellspacing='0' width='100%'><br><br>";
echo"<tr><td align=\"left\">&nbsp;<img src=\"images/whos_online.gif\"><b>&nbsp;  (total users online today: <font color ='red'>".$counter."</font>)</td><td align=\"right\">&nbsp;contact us <a href=index.php?page=contact><img src=\"images/mail.png\"></a></td><td align=\"right\"><b>Last bot visit: <font color=red>&nbsp;".$bot." </font>- ".$postdt."</b></tr></td></table>";
   echo"</td></tr>";
   echo "</td></tr></table>";
   echo "</div>"; 
}
}
?>