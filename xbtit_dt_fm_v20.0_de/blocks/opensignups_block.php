<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    Advanced Auto Donation System by DiemThuy ( sept 2009 )
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

Global $SITENAME,$BASEURL,$INVITATIONSON,$MAX_USERS;

//max users
$nusers=get_result("SELECT count(*) as tu FROM {$TABLE_PREFIX}users WHERE id>1",true,$btit_settings['cache_duration']);
$numusers=$nusers[0]['tu'];

// get settings
$zap_pp = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM {$TABLE_PREFIX}paypal_settings WHERE id ='1'");
$settings = mysqli_fetch_array($zap_pp);

if ($settings["ppinvon"]=="true" )
{
$payme=$settings["ppinv"];

// If testing on Sandbox use:
if ($settings["test"]=="true")
{
$email= $settings["sandbox_email"];
$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
}
if ($settings["test"]=="false")
{
$email= $settings["paypal_email"];
$url = "https://www.paypal.com/cgi-bin/webscr";
}
 $currency=$settings["units"];

if ($settings["units"]=="true")
{
$sign = "&#8364;";
$sign_left = TRUE;
$currency ="EUR";
}
Else
{
$sign = "&#36;";
$sign_left = TRUE;
$currency ="USD";
}
        
$info=(($sign_left===TRUE)?$sign:"").number_format($payme,0,".",",").(($sign_right===TRUE)?" ".$sign:"");    

?>
<center><span style="font-family: Optima, Lucida, 'MgOpen Cosmetica', 'Lucida Sans Unicode', sans-serif; letter-spacing: 4px; color:#990000; font-weight: normal; font-size:2.3em; line-height:32px; text-decoration:none; text-transform: uppercase; padding:0px 40px 0px 40px; text-shadow:0px 1px 1px #FFCCFF;">site is closed at the moment <br /> but you can send us a <?php echo $info; ?> donation to get an invitation.<br /><br />insert your email address below<br /> where you would like to recieve the invitation.</span></center>
<center>
<form action="<?php echo $url; ?>" method="post">
<br />E-mail adress  :<input type="text" name="email" value="your email" size="50" /><br /><br />
<INPUT TYPE="hidden" name="cmd" value=" _donations">
<input type="hidden" name="business" value="<?php echo $email; ?>" >
<input type="hidden" name="currency_code" value="<?php echo $currency; ?>">
<input type="hidden" name="item_name" value="Signup donation for <?php echo $SITENAME; ?>">
<input type="hidden" name="item_number" value="4">
<input type="hidden" name="amount" value="<?php echo $payme; ?>">
<input type="hidden" name="return" value="<?php echo $BASEURL; ?>">
<input type="hidden" name="cancel_return" value="<?php echo $BASEURL; ?>">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input type="image" src="images/paypal-donate.jpeg" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<!--<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">-->
</form></center>
<?php
}else{
if ($numusers>=$MAX_USERS && !$INVITATIONSON && $MAX_USERS!=0)
{
//code max users
?>
<center><span style="font-family: Optima, Lucida, 'MgOpen Cosmetica', 'Lucida Sans Unicode', sans-serif; color:#990000; font-weight: normal; font-size:2.3em; line-height:32px; text-decoration:none; text-transform: uppercase; padding:0px 40px 0px 40px; text-shadow:0px 1px 1px #FFCCFF;">site is closed at the moment , max. numbers of users reached  , donations to recieve invites are disabled , please check back later <img src="images/denied_small.png" /></span></center>
<?php 
}
else if($INVITATIONSON)
{
?>
<center><span style="font-family: Optima, Lucida, 'MgOpen Cosmetica', 'Lucida Sans Unicode', sans-serif; color:#990000; font-weight: normal; font-size:2.3em; line-height:32px; text-decoration:none; text-transform: uppercase; padding:0px 40px 0px 40px; text-shadow:0px 1px 1px #FFCCFF;">site is closed at the moment , invite system is activated , donations to recieve invites are disabled , please check back later <img src="images/denied_small.png" /></span></center>
<?php 
}
else
{
 ?>
<center><span style="font-family: Optima, Lucida, 'MgOpen Cosmetica', 'Lucida Sans Unicode', sans-serif; color:#000066; font-weight: normal; font-size:2.3em; line-height:32px; text-decoration:none; text-transform: uppercase; padding:0px 40px 0px 40px; text-shadow:0px 1px 1px #66FFCC;">sign ups are open at the moment , so you are in luck <img src="images/smilies/hi.gif" /></span></center>
<?php
}
}
?>
<center><span style="font-family: Optima, Lucida, 'MgOpen Cosmetica', 'Lucida Sans Unicode', sans-serif; color:#000066; font-weight: normal; font-size:2.3em; line-height:32px; text-decoration:none; text-transform: uppercase; padding:0px 40px 0px 40px; text-shadow:0px 1px 1px #66FFCC;">Contact Us <a href="index.php?page=contact"><img src="images/mailb.png" /></a></span></center>