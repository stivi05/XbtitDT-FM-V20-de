<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
//    Donation Historie by DiemThuy ( Juni 2009 ) .. V16>updated to work up to 2017
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

if (!defined("IN_BTIT"))
      die("non direct access!");

$don_historietpl= new bTemplate();
$don_historietpl->set("language",$language);

$r2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT d.* , ul.prefixcolor, ul.suffixcolor , username , u.id FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}don_historie d  ON u.id = d.don_id LEFT JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id ORDER BY username");
$donation=array();
$i=0;

     if ($r2)
        {
        while ($arr=mysqli_fetch_assoc($r2))
            {
if ($btit_settings["dh_unit"] == true)
{
$unit = '&nbsp;&#8364;';
}
if ($btit_settings["dh_unit"] == false)
{
$unit = '&nbsp;&#36;';
}
        $namee=stripslashes($arr[prefixcolor]) . $arr[username] . stripslashes($arr[suffixcolor]);
        $yearnr = substr($arr['donate_date'], 0,4);
        if ($yearnr=='2010')
        $year =  "<br><font color = orange>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2011')
        $year =  "<br><font color = steelblue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2013')
        $year =  "<br><font color = purple>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2014')
        $year =  "<br><font color = green>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2015')
        $year =  "<br><font color = blue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2016')
        $year =  "<br><font color = red>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2017')
        $year =  "<br><font color = pink>".substr($arr['donate_date'], 0,4)."</font>";
        
        $don = "<font color = green>".substr($arr['donate_date'], 8, -9)."-".substr($arr['donate_date'], 5, -12).$year;
        if  ($arr['donate_date_1']=='0000-00-00 00:00:00')
        $don1= '-';
        else
         {
        $yearnr = substr($arr['donate_date_1'], 0,4);
        if ($yearnr=='2011')
        $year =  "<br><font color = orange>".substr($arr['donate_date_1'], 0,4)."</font>";
        
        if ($yearnr=='2012')
        $year =  "<br><font color = steelblue>".substr($arr['donate_date_1'], 0,4)."</font>";
        
        if ($yearnr=='2013')
        $year =  "<br><font color = purple>".substr($arr['donate_date_1'], 0,4)."</font>";
        
        if ($yearnr=='2014')
        $year =  "<br><font color = green>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2015')
        $year =  "<br><font color = blue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2016')
        $year =  "<br><font color = red>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2017')
        $year =  "<br><font color = pink>".substr($arr['donate_date'], 0,4)."</font>";
        

        $don1 = "<font color = green>".substr($arr['donate_date_1'], 8, -9)."-".substr($arr['donate_date_1'], 5, -12).$year;
        }
        if  ($arr['donate_date_2']=='0000-00-00 00:00:00')
        $don2= '-';
        else
        {
        $yearnr = substr($arr['donate_date_2'], 0,4);
        if ($yearnr=='2011')
        $year =  "<br><font color = orange>".substr($arr['donate_date_2'], 0,4)."</font>";
        
        if ($yearnr=='2012')
        $year =  "<br><font color = steelblue>".substr($arr['donate_date_2'], 0,4)."</font>";
        
        if ($yearnr=='2013')
        $year =  "<br><font color = purple>".substr($arr['donate_date_2'], 0,4)."</font>";
        
        if ($yearnr=='2014')
        $year =  "<br><font color = green>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2015')
        $year =  "<br><font color = blue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2016')
        $year =  "<br><font color = red>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2017')
        $year =  "<br><font color = pink>".substr($arr['donate_date'], 0,4)."</font>";
        
        $don2 = "<font color = green>".substr($arr['donate_date_2'], 8, -9)."-".substr($arr['donate_date_2'], 5, -12).$year;
        }
        if  ($arr['donate_date_3']=='0000-00-00 00:00:00')
        $don3= '-';
        else
        {
        $yearnr = substr($arr['donate_date_3'], 0,4);
        if ($yearnr=='2011')
        $year =  "<br><font color = orange>".substr($arr['donate_date_3'], 0,4)."</font>";
        
        if ($yearnr=='2012')
        $year =  "<br><font color = steelblue>".substr($arr['donate_date_3'], 0,4)."</font>";
        
        if ($yearnr=='2013')
        $year =  "<br><font color = purple>".substr($arr['donate_date_3'], 0,4)."</font>";
        
        if ($yearnr=='2014')
        $year =  "<br><font color = green>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2015')
        $year =  "<br><font color = blue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2016')
        $year =  "<br><font color = red>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2017')
        $year =  "<br><font color = pink>".substr($arr['donate_date'], 0,4)."</font>";
        
        $don3 = "<font color = green>".substr($arr['donate_date_3'], 8, -9)."-".substr($arr['donate_date_3'], 5, -12).$year;
        }
        if  ($arr['donate_date_4']=='0000-00-00 00:00:00')
        $don4= '-';
        else
        {
        $yearnr = substr($arr['donate_date_4'], 0,4);
        if ($yearnr=='2011')
        $year =  "<br><font color = orange>".substr($arr['donate_date_4'], 0,4)."</font>";
        
        if ($yearnr=='2012')
        $year =  "<br><font color = steelblue>".substr($arr['donate_date_4'], 0,4)."</font>";
        
        if ($yearnr=='2013')
        $year =  "<br><font color = purple>".substr($arr['donate_date_4'], 0,4)."</font>";
        
        if ($yearnr=='2014')
        $year =  "<br><font color = green>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2015')
        $year =  "<br><font color = blue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2016')
        $year =  "<br><font color = red>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2017')
        $year =  "<br><font color = pink>".substr($arr['donate_date'], 0,4)."</font>";
        
        $don4 = "<font color = green>".substr($arr['donate_date_4'], 8, -9)."-".substr($arr['donate_date_4'], 5, -12).$year;
        }
        if  ($arr['donate_date_5']=='0000-00-00 00:00:00')
        $don5= '-';
        else
        {
        $yearnr = substr($arr['donate_date_5'], 0,4);
        if ($yearnr=='2011')
        $year =  "<br><font color = orange>".substr($arr['donate_date_5'], 0,4)."</font>";
        
        if ($yearnr=='2012')
        $year =  "<br><font color = steelblue>".substr($arr['donate_date_5'], 0,4)."</font>";
        
        if ($yearnr=='2013')
        $year =  "<br><font color = purple>".substr($arr['donate_date_5'], 0,4)."</font>";
        
        if ($yearnr=='2014')
        $year =  "<br><font color = green>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2015')
        $year =  "<br><font color = blue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2016')
        $year =  "<br><font color = red>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2017')
        $year =  "<br><font color = pink>".substr($arr['donate_date'], 0,4)."</font>";
        
        $don5 = "<font color = green>".substr($arr['donate_date_5'], 8, -9)."-".substr($arr['donate_date_5'], 5, -12).$year;
        }
        if  ($arr['donate_date_6']=='0000-00-00 00:00:00')
        $don6= '-';
        else
        {
        $yearnr = substr($arr['donate_date_6'], 0,4);
        if ($yearnr=='2011')
        $year =  "<br><font color = orange>".substr($arr['donate_date_6'], 0,4)."</font>";
        
        if ($yearnr=='2012')
        $year =  "<br><font color = steelblue>".substr($arr['donate_date_6'], 0,4)."</font>";
        
        if ($yearnr=='2013')
        $year =  "<br><font color = purple>".substr($arr['donate_date_6'], 0,4)."</font>";
        
        if ($yearnr=='2014')
        $year =  "<br><font color = green>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2015')
        $year =  "<br><font color = blue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2016')
        $year =  "<br><font color = red>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2017')
        $year =  "<br><font color = pink>".substr($arr['donate_date'], 0,4)."</font>";
        
        $don6 = "<font color = green>".substr($arr['donate_date_6'], 8, -9)."-".substr($arr['donate_date_6'], 5, -12).$year;
        }
        if  ($arr['donate_date_7']=='0000-00-00 00:00:00')
        $don7= '-';
        else
        {
        $yearnr = substr($arr['donate_date_7'], 0,4);
        if ($yearnr=='2011')
        $year =  "<br><font color = orange>".substr($arr['donate_date_7'], 0,4)."</font>";
        
        if ($yearnr=='2012')
        $year =  "<br><font color = steelblue>".substr($arr['donate_date_7'], 0,4)."</font>";
        
        if ($yearnr=='2013')
        $year =  "<br><font color = purple>".substr($arr['donate_date_7'], 0,4)."</font>";
        
        if ($yearnr=='2014')
        $year =  "<br><font color = green>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2015')
        $year =  "<br><font color = blue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2016')
        $year =  "<br><font color = red>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2017')
        $year =  "<br><font color = pink>".substr($arr['donate_date'], 0,4)."</font>";
        
        $don7 = "<font color = green>".substr($arr['donate_date_7'], 8, -9)."-".substr($arr['donate_date_7'], 5, -12).$year;
        }
        if  ($arr['donate_date_8']=='0000-00-00 00:00:00')
        $don8= '-';
        else
        {
        $yearnr = substr($arr['donate_date_8'], 0,4);
        if ($yearnr=='2011')
        $year =  "<br><font color = orange>".substr($arr['donate_date_8'], 0,4)."</font>";
        
        if ($yearnr=='2012')
        $year =  "<br><font color = steelblue>".substr($arr['donate_date_8'], 0,4)."</font>";
        
        if ($yearnr=='2013')
        $year =  "<br><font color = purple>".substr($arr['donate_date_8'], 0,4)."</font>";
        
        if ($yearnr=='2014')
        $year =  "<br><font color = green>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2015')
        $year =  "<br><font color = blue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2016')
        $year =  "<br><font color = red>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2017')
        $year =  "<br><font color = pink>".substr($arr['donate_date'], 0,4)."</font>";
        
        $don8 = "<font color = green>".substr($arr['donate_date_8'], 8, -9)."-".substr($arr['donate_date_8'], 5, -12).$year;
        }
        if  ($arr['donate_date_9']=='0000-00-00 00:00:00')
        $don9= '-';
        else
        {
        $yearnr = substr($arr['donate_date_9'], 0,4);
        if ($yearnr=='2011')
        $year =  "<br><font color = orange>".substr($arr['donate_date_9'], 0,4)."</font>";
        
        if ($yearnr=='2012')
        $year =  "<br><font color = steelblue>".substr($arr['donate_date_9'], 0,4)."</font>";
        
        if ($yearnr=='2013')
        $year =  "<br><font color = purple>".substr($arr['donate_date_9'], 0,4)."</font>";
        
        if ($yearnr=='2014')
        $year =  "<br><font color = green>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2015')
        $year =  "<br><font color = blue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2016')
        $year =  "<br><font color = red>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2017')
        $year =  "<br><font color = pink>".substr($arr['donate_date'], 0,4)."</font>";
        
        $don9 = "<font color = green>".substr($arr['donate_date_9'], 8, -9)."-".substr($arr['donate_date_9'], 5, -12).$year;
        }
        if  ($arr['donate_date_10']=='0000-00-00 00:00:00')
        $don10= '-';
        else
        {
        $yearnr = substr($arr['donate_date_1'], 0,4);
        if ($yearnr=='2011')
        $year =  "<br><font color = orange>".substr($arr['donate_date_10'], 0,4)."</font>";
        
        if ($yearnr=='2012')
        $year =  "<br><font color = steelblue>".substr($arr['donate_date_10'], 0,4)."</font>";
        
        if ($yearnr=='2013')
        $year =  "<br><font color = purple>".substr($arr['donate_date_10'], 0,4)."</font>";
        
        if ($yearnr=='2014')
        $year =  "<br><font color = green>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2015')
        $year =  "<br><font color = blue>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2016')
        $year =  "<br><font color = red>".substr($arr['donate_date'], 0,4)."</font>";
        
        if ($yearnr=='2017')
        $year =  "<br><font color = pink>".substr($arr['donate_date'], 0,4)."</font>";
        
        $don10 = "<font color = green>".substr($arr['donate_date_10'], 8, -9)."-".substr($arr['donate_date_10'], 5, -12).$year;
        }
        $donation[$i]["Username"]="<a href=index.php?page=userdetails&id=" . $arr["id"] . ">".$namee."</a>";
        $donation[$i]["a"]=$don;
        $donation[$i]["b"]=$don1;
        $donation[$i]["c"]=$don2;
        $donation[$i]["d"]=$don3;
        $donation[$i]["e"]=$don4;
        $donation[$i]["f"]=$don5;
        $donation[$i]["g"]=$don6;
        $donation[$i]["h"]=$don7;
        $donation[$i]["i"]=$don8;
        $donation[$i]["j"]=$don9;

        $i++;
}
$don_historietpl->set("donation",$donation);
}

?>