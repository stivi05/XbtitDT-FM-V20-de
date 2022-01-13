<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam ( Bhorer_Alo dec 2013 )
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

if (!defined("IN_BTIT"))
      die("non direct access!");

if (!defined("IN_ACP"))
      die("non direct access!");
      
$ratiofix = $_POST["ratio"];

if (isset($ratiofix))
{        
	
	if ($XBTT_USE)
	{
		$uid = "uid";
		$table = "xbt_users";
	}
	else
	{
		$uid = "id";
		$table = "{$TABLE_PREFIX}users";
	}
	
	$query = "SELECT $uid, uploaded, downloaded, uploaded / downloaded AS ratio FROM $table WHERE uploaded / downloaded <1 ";
	$ratio_defects = get_result( $query, true );
	
	$count_r = count($ratio_defects);
	if ($count_r < 1)
	{
stderr("Good,","No user with a ratio under 1 detected ");
stdfoot();
exit;
}
	else
	{

		
		foreach ( $ratio_defects as $morons )
		{
			do_sqlquery( "UPDATE ".$table." SET uploaded = ".$morons['downloaded']." WHERE ".$uid."= ".$morons[$uid]."",true);
			echo "fixing ratio of user ID ". $morons[$uid] ."<br>";
		}
stderr("Done,","Total ". $count_r ." users with ratio less than 1 detected and fixed");
stdfoot();
exit;
	}
	}      
      
information_msg("Are you sure","Are you sure you want to set all users ratio under 1 to 1 ? <form method=post action=index.php?page=admin&user=".$CURUSER["uid"]."&code=".$CURUSER["random"]."&do=ratio_fix><input type=hidden name=ratio ><p></p><input type=submit class=btn value=Confirm></form>");
stdfoot();
exit(); 

?>