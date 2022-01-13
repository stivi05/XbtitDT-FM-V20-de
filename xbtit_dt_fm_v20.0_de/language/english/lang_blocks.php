<?php
$language['BLOCK_USER']='User Info';
$language['BLOCK_INFO']='Tracker Info';
$language['BLOCK_MAINMENU']=''; # this is the Main Menu no name needed, some dipshit took this out ... not nice!!
# We leave this name (drop down menu) blank so it doesnt use the block head showing its name, it looks unsightly and non professional imho!! TreetopClimber 
$language['BLOCK_DDMENU']='';
$language['BLOCK_MENU']='Main Menu'; # block menu needs the name
$language['BLOCK_CALENDAR']='Calendar'; 
$language['BLOCK_CLOCK']='Clock';
$language['BLOCK_FORUM']='Forum';
$language['BLOCK_LASTMEMBER']='Latest Member';
$language['BLOCK_ONLINE']='Online';
$language['BLOCK_ONTODAY']='On Today';
$language['BLOCK_SHOUTBOX']='Shout Box';
$language['BLOCK_NEWS']='Last News';
$language['BLOCK_SERVERLOAD']='Server Load';
$language['BLOCK_POLL']='Poll';
global $CURUSER;
if($CURUSER['tor']=='last' or $CURUSER['tor']=='')
$language['BLOCK_LASTTORRENTS']='Last Upload';

if($CURUSER['tor']=='top')
$language['BLOCK_LASTTORRENTS']='Top Torrents';

if($CURUSER['tor']=='seed')
$language['BLOCK_LASTTORRENTS']='Seed Wanted Torrents';

$language['BLOCK_PAYPAL']='Support US';
$language['BLOCK_MAINTRACKERTOOLBAR']='Main Tracker Toolbar';
$language['BLOCK_MAINUSERTOOLBAR']='Main User Toolbar';
$language['WELCOME_LASTUSER']=' Welcome to our Tracker ';
$language['BLOCK_MINCLASSVIEW']='Minimum rank that can view';
$language['BLOCK_MAXCLASSVIEW']='Maximum rank that can view';
$language["LC"]="Latest Comments";

$language["BLACKJACK_STATS"]="Your Blackjack Stats";

$language['BLOCK_REQUEST'] = 'Most Voted Requests';
$language["BLOCK_TOPU"]="Top Uploaders";
$language["BLOCK_FEATURED"]="Last Torrents";
$language["BLOCK_ADMIN"]="Admin Checks";
$language["BLOCK_WARN"]="Low Ratio Warnings";
$language['Ticker']='Info and News';

$language["BLOCK_BIRTHDAY"]="Today's Birthdays";
$language["BLOCK_NO_BIRTHDAY"]="No members are celebrating a birthday today";

$language["BLOCK_LOTTERY"]="Lottery";
$language["CLIENT"]="Recommended";
$language["BLOCK_HIT"]="HIT & RUN Warning";
$language['REC_BLOCK']='Recommended By Staff';
$language['gallery']='Gallery';
$language['SUB_BLOCK']='Subtitles';
$language['DIV_BLOCK']='Singup Info';
$language["BLOCK_FEATUREDD"]="Torrent of the Day";
$language['ARCADE']='Arcade';
$language["BLOCK_EVENT"]="Event Counter";
$language['BLOCK_UPDO']='Last up/downloads';
$language["BLOCK_CAT"]="Categories";
$language['BLOCK_SB']='Seedbox';
$language['MP']='MP3 Player';

$language['BLOCK_SEARCH']='Search';
?>