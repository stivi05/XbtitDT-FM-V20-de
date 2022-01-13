<?php
$language["BLOCK_USER"]="User Info";
$language["BLOCK_INFO"]="Tracker Info";
$language["BLOCK_MENU"]="Menu główne";
$language["BLOCK_CLOCK"]="Zegar";
$language["BLOCK_FORUM"]="Forum";
$language["BLOCK_LASTMEMBER"]="Ostatni użytkownik";
$language["BLOCK_ONLINE"]="Online";
$language["BLOCK_ONTODAY"]="On Today";
$language["BLOCK_SHOUTBOX"]="Shout Box";
global $CURUSER;
if($CURUSER['tor']=='top')
$language["BLOCK_TOPTORRENTS"]="Najpopularniejsze torrenty";

if($CURUSER['tor']=='last' or $CURUSER['tor']=='')
$language["BLOCK_LASTTORRENTS"]="Ostatnio dodane";

$language["BLOCK_NEWS"]="Najnowsze Newsy";
$language["BLOCK_SERVERLOAD"]="Ładowanie serwera";
$language["BLOCK_POLL"]="Ankieta";
if($CURUSER['tor']=='seed')
$language["BLOCK_SEEDWANTED"]="Torrenty potrzebujące seeda";

$language["BLOCK_PAYPAL"]="Dotacje";
$language["BLOCK_MAINTRACKERTOOLBAR"]="Główny pasek trackera";
$language["BLOCK_MAINUSERTOOLBAR"]="Główny pasek usera";
$language["WELCOME_LASTUSER"]=" Witamy na naszym trackerze ";
$language["BLOCK_MINCLASSVIEW"]="Minimalna ranga do przeglądania";
$language["BLOCK_MAXCLASSVIEW"]="Maksymalna ranga do przeglądania";
?>