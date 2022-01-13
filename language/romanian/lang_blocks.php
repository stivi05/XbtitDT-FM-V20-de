<?php
$language['BLOCK_USER']='Info Utilizator';
$language['BLOCK_INFO']='Info Tracker';
$language['BLOCK_MENU']='Meniu Principal';
$language['BLOCK_CLOCK']='Ceas';
$language['BLOCK_FORUM']='Forum';
$language['BLOCK_LASTMEMBER']='Ultimul Membru';
$language['BLOCK_ONLINE']='Online';
$language['BLOCK_SHOUTBOX']='Shout Box';
global $CURUSER;
if($CURUSER['tor']=='top')
$language['BLOCK_TOPTORRENTS']='Top Torrente';

if($CURUSER['tor']=='last' or $CURUSER['tor']=='')
$language['BLOCK_LASTTORRENTS']='Ultimul Upload';

$language['BLOCK_NEWS']='Ştiri Recente';
$language['BLOCK_SERVERLOAD']='Server Load';
$language['BLOCK_POLL']='Chestionar';
if($CURUSER['tor']=='seed')
$language['BLOCK_SEEDWANTED']='Torrente in Căutare de Seeder(i)';

$language['BLOCK_PAYPAL']='Sprijiniţi-ne';
$language['BLOCK_MAINTRACKERTOOLBAR']='Main Tracker Toolbar';
$language['BLOCK_MAINUSERTOOLBAR']='Main User Toolbar';
$language['WELCOME_LASTUSER']=' Bun venit pe Tracker-ul nostru ';
?>