<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//   SPORT BETTING HACK , orginal TBDEV 2009 by Soft & Bigjoos 
//   XBTIT conversion by DiemThuy , April 2010
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

require_once("include/functions.php");
dbconn();

global $BASEURL,$CURUSER;



if ($CURUSER["admin_access"]=="no")
stderr("access denied !!");

if (empty($_POST['heading']) || empty($_POST['undertext']) || empty($_POST['minutes']) || empty($_POST['hours'])){
stderr('Silly Rabbit', 'Enter a Bet title or name or endtime ya nugget !');
}

$heading = htmlspecialchars($_POST['heading']);
$heading = str_replace("'","",$heading);
$undertext = htmlspecialchars($_POST['undertext']);
$undertext = str_replace("'","",$undertext);
$endminutes = (int) $_POST['minutes']*60;
$endhours =   (int) $_POST['hours']*3600;
$endtime =   ($endhours + $endminutes) + time();


$sort = (int) $_POST['sort'];
mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO {$TABLE_PREFIX}betgames(heading, undertext, endtime, sort, creator) VALUES(".sqlesc($heading).", ".sqlesc($undertext).", ".sqlesc($endtime).", ".sqlesc($sort).", '$CURUSER[username]')") or sqlerr(__FILE__, __LINE__);
header("location: $BASEURL/index.php?page=betadmin");
?>