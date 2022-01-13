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

error_reporting(0);

if (!defined("IN_BTIT"))
    die("non direct access!");
	 
global $btit_settings, $BASEURL;
	  
$listennowtpl=new bTemplate();

require(load_language("lang_userdetails.php"));
include("./radiostats/shoutcast.class.php");
	  
$listen = new ShoutCast();
$listen->host = $btit_settings["radio_ip"];
$listen->port = $btit_settings["radio_port"];
$listen->passwd = $btit_settings["radio_pass"];
	  
if ($listen->openstats())
{
    // We got the XML, gogogo!..
    if ($listen->GetStreamStatus())
    {
        require(load_language("lang_shoutcast.php"));

        $hostname=$listen->GetListeners();

        $j=0;
        $list=array();

        if (is_array($hostname))
        {
            for ($i=0;$i<sizeof($hostname);$i++)
            {
                $ip=$hostname[$i]["hostname"];
                $client=$hostname[$i]["useragent"];
                $damn=do_sqlquery ("select id,username FROM {$TABLE_PREFIX}users WHERE cip='".$ip."' ORDER BY lastconnect ASC LIMIT 1",true);

                
                if(@mysqli_num_rows($damn)>0)
                {
                    $gimme=mysqli_fetch_array($damn);
					
                }
                else
                {
                    $gimme["id"]=1;
                    $gimme["username"]="Guest";
                }
				if(substr($client, 0, 8)=="NSPlayer"){
			$client="<img src='".$BASEURL."/radiostats/images/mp.png' width='32' height='32' border='0' alt='Windows.Media.Player' title='Windows.Media.Player'>";
			}
			if(substr($client, 0, 9)=="QuickTime"){
			$client="<img src='".$BASEURL."/radiostats/images/qt.png' width='32' height='32' border='0' alt='QuickTime' title='QuickTime'>";
			}
			if(substr($client, 0, 7)=="RMA/1.0"){
			$client="<img src='".$BASEURL."/radiostats/images/rp.png' width='32' height='32' border='0' alt='RealPlayer' title='RealPlayer'>";
			}
			if(substr($client, 0, 10)=="WinampMPEG"){
			$client="<img src='".$BASEURL."/radiostats/images/winamp.png' width='32' height='32' border='0' alt='Winamp' title='Winamp'>";
			}
			if(substr($client, 0, 3)=="VLC"){
			$client="<img src='".$BASEURL."/radiostats/images/vlc.png' width='32' height='32' border='0' alt='VLC.Media.Player' title='VLC.Media.Player'>";
			}
			
			
			$colors = @mysqli_fetch_array(@mysqli_query($GLOBALS["___mysqli_ston"], "SELECT prefixcolor,suffixcolor FROM {$TABLE_PREFIX}users u INNER JOIN {$TABLE_PREFIX}users_level ul ON u.id_level=ul.id WHERE u.username=".sqlesc($gimme[username])));
			
			
                $hanger=true;
                $list[$j]["id"]=mysqli_real_escape_string($DBDT,(int)$gimme[id]);
				$list[$j]["username"]=unesc($colors[prefixcolor]).$gimme[username].unesc($colors[suffixcolor]);			
                $list[$j]["client"]=unesc($client);
                $j++;
            }            
        }else{
		$hanger=false;
		$nothing=stderr($language[ERROR],$language["NOPLAYER"]);
		$listennowtpl->set("nothing",$nothing);
		
		}
    }
	else{
	    $hanger=false;
		$ohdamn=stderr($language[ERROR],$language["NOSHOUTCAST"]);
		$listennowtpl->set("ohdamn",$ohdamn);
		
		}   
} else{
	    $hanger=false;
		$ohbeep=stderr($language[ERROR],"<center>".$language["NOSHOUTCASTCONN"]."<br/>".$listen->geterror()."</center>");
		$listennowtpl->set("ohbeep",$ohbeep);
		
		}   
$listennowtpl-> set("hanger", (($hanger)?TRUE:FALSE), TRUE);
$listennowtpl->set("list",$list);
$listennowtpl->set("language",$language);			
?>