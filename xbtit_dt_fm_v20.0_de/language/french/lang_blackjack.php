<?php

$language["BLACKJACK"] = "Blackjack";
$language["BJ_WELCOME_1"] = "<p><font color='#FFFFFF'>Le but est de possèder une main le plus proche de 21 sans la dépassé. Vous joué contre le Dealer, vous devez donc avoir une meilleure main que lui pour gagner.</font>";
$language["BJ_WELCOME_2"] = "<font color='yellow'><b> Chaque partie coûte ".makesize($btit_settings["bj_blackjack_stake"])." de crédit d'upload.</p></b></font><font size=2 color='#FFFFFF'><li><b>Le Blackjack paye ".makesize(($btit_settings["bj_blackjack_stake"]*$btit_settings["bj_blackjack_prize"])+$btit_settings["bj_blackjack_stake"])."</li><li>Battre le dealer paye ".makesize(($btit_settings["bj_blackjack_stake"]*$btit_settings["bj_normal_prize"])+$btit_settings["bj_blackjack_stake"])."</li><li>Un nul vous redonne votre mise.</li><li>Perdre ne vous redonne rien.</li></font>";
$language["CONTINUE"] = "Jouer";
$language["DEALER_HAND"] = "<font color='#FFFFFF' face='Arial'><b>Main du Dealer (";
$language["YOUR_HAND"] = "<font color='#FFFFFF' face='Arial'><b>Votre main (";
$language["HIT"] = "Nouvelle carte";
$language["STAND"] = "Conserver la main";
$language["ACTIVE_GAME_1"] = "Vous avez déjà une partie en cours, ";
$language["ACTIVE_GAME_2"] = " pour la terminée.";
$language["YOU_WIN"] = "<font color='lime' size='2'><b>Vous avez gagner!</b></font>";
$language["YOU_LOSE"] = "<font color='red' size='2'><b>Vous avez perdue!</b></font>";
$language["PUSH"] = "<font color='orange'><b>Push!</b></font>";
$language["INSUFFICIENT_UPLOAD_CREDIT"] = "<font color='#FF0000' size='2'><b>Vous n'avez pas assez de crédit d'upload pour pouvoir jouer!</b></font>";
$language["PLAY_AGAIN"] = "<font color='yellow' face='Arial' size='2'>Rejouer</font>";

?>