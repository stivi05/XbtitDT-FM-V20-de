<?php
$language['BLOCK_USER']='Vos Informations';
$language['BLOCK_INFO']='Statistiques';
$language['BLOCK_MENU']='Navigation';
/* We leave this name (drop down menu) blank so it doesnt use the block head showing its name, it looks unsightly and non professional imho!! TreetopClimber */
$language['BLOCK_DDMENU']='';
$language['BLOCK_CALENDAR']='Calendrier'; 
$language['BLOCK_CLOCK']='Horloge';
$language['BLOCK_FORUM']='Forum';
$language['BLOCK_LASTMEMBER']='Dernier membres';
$language['BLOCK_ONLINE']='En Ligne';
$language['BLOCK_ONTODAY']='Ce jour';
$language['BLOCK_SHOUTBOX']='ShoutBox';
$language['BLOCK_NEWS']='Derniere Nouvelles';
$language['BLOCK_SERVERLOAD']='Charges du Serveur';
$language['BLOCK_POLL']='Sondage';
global $CURUSER;
if($CURUSER['tor']=='last' or $CURUSER['tor']=='')
$language['BLOCK_LASTTORRENTS']='Dernier Uploads';

if($CURUSER['tor']=='top')
$language['BLOCK_LASTTORRENTS']='Top Torrents';

if($CURUSER['tor']=='seed')
$language['BLOCK_LASTTORRENTS']='Torrents Sans Seed';

$language['BLOCK_PAYPAL']='Aidez nous';
$language['BLOCK_MAINTRACKERTOOLBAR']='Barre d\'outils du tracker';
$language['BLOCK_MAINUSERTOOLBAR']='Barre d\'outils de l\'utilisateur';
$language['WELCOME_LASTUSER']=' Bienvenue sur notre Tracker ';
$language['BLOCK_MINCLASSVIEW']='Classe mini. pour voir';
$language['BLOCK_MAXCLASSVIEW']='Classe maxi. pour voir';
$language["LC"]="Dernier Commentaires";

$language["BLACKJACK_STATS"]="Statistiques BlackJack";

$language['BLOCK_REQUEST'] = 'Requêtes les plus votés';
$language["BLOCK_TOPU"]="Top Uploadeurs";
$language["BLOCK_FEATURED"]="Dernier Torrents";
$language["BLOCK_ADMIN"]="Vérification Admin";
$language["BLOCK_WARN"]="Avertissement mauvais ratio";
$language['Ticker']='Info et Nouvelles';

$language["BLOCK_BIRTHDAY"]="Anniversaire";
$language["BLOCK_NO_BIRTHDAY"]="Personne ne fête sont anniversaire aujourd'hui";

$language["BLOCK_LOTTERY"]="Loterie";
$language["CLIENT"]="Recommandé";
$language["BLOCK_HIT"]="Avertissement Hit & Run";
$language['REC_BLOCK']='Recommandé par le Staff';

$language['SUB_BLOCK']='Sous-titres';
$language['DIV_BLOCK']='Faites un don pour obtenir une Invitation';
$language["BLOCK_FEATUREDD"]="Torrent du jour";
$language['ARCADE']='Arcade';
$language["BLOCK_EVENT"]="Evennement";
$language['BLOCK_UPDO']='Dernier uploads/téléchargements';
$language["BLOCK_CAT"]="Catégories";
$language['BLOCK_SB']='SeedBox';

$language['BET']='Paris';

$language['BLOCK_SB']='SeedBox';
    
$language["BLOCK_RAD"]="".$SITENAME." Radio";
      
$language['BLOCK_LINKS']='Nos Partenaires';
?>