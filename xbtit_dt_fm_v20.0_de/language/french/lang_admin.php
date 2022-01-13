<?php
$language['ACP_BAN_IP']='Bannir IP';
$language["ACP_ADD_WARN"]="Moderation Torrent: raisons";
$language["WARN_TITLE"]="Titre de la raison";
$language["WARN_TEXT"]="Explications de la raison";
$language["WARN_ADD_REASON"]="Ajouter une raison";
$language["TRUSTED"]="Trusted";
$language["TRUSTED_MODERATION"]="Passe outre la modération (Upload de nouveaux torrents)";
$language["TORRENT_STATUS"]="Status du torrent";
$language["TORRENT_MODERATION"]="Modération";
$language["MODERATE_TORRENT"] = "Modérer";
$language["MODERATE_STATUS_OK"] = "Ok";
$language["MODERATE_STATUS_BAD"] = "Mauvais";
$language["MODERATE_STATUS_UN"] = "Non-modérer";
$language["FRM_CONFIRM_VALIDATE"] = "Confirmer revalidation";
$language["MODERATE_PANEL"] = "Panneau de Modération des Torrents";
$language["ACP_RATIO_EDITOR"] = "Editeur de Ratio";
$language["RATIO_USERNAME"] = "Utilisateur";
$language["RATIO_UPLOADED"] = "Uploadé";
$language["RATIO_DOWNLOADED"] = "Téléchargé";
$language["RATIO_INPUT_MEASURE"] = "Unité:";
$language["RATIO_BYTES"] = "Octets";
$language["RATIO_K_BYTES"] = "Ko";
$language["RATIO_M_BYTES"] = "Mo";
$language["RATIO_G_BYTES"] = "Go";
$language["RATIO_T_BYTES"] = "To";
$language["RATIO_ACTION"] = "Action:";
$language["RATIO_ADD"] = "Ajouter";
$language["RATIO_REMOVE"] = "Supprimer";
$language["RATIO_REPLACE"] = "Remplacer";
$language["RATIO_HEADER"] = "Mettre à jour le ratio de";
$language["RATIO_SUCCES"] = "Succès";
$language["RATIO_UPDATE_SUCCES"] = "Vous venez de mettre à jour le ratio de cet utilisateur";
$language['ACP_FORUM']='Configurer le forum';
$language['ACP_USER_GROUP']='Configurer les classes';
$language['ACP_STYLES']='Configurer les styles';
$language['ACP_LANGUAGES']='Configurer les langues';
$language['ACP_CATEGORIES']='Configurer les catégories';
$language['ACP_TRACKER_SETTINGS']='Configurer le tracker';
$language['ACP_OPTIMIZE_DB']='Optimier la BDD';
$language['ACP_CENSORED']='Configurer la censure';
$language['ACP_DBUTILS']='Utilitaires de BDD';
$language['ACP_HACKS']='Hacks';
$language['ACP_HACKS_CONFIG']='Configurer les hacks';
$language['ACP_MODULES']='Modules';
$language['ACP_MODULES_CONFIG']='Configurer les modules';
$language['ACP_MASSPM']='MP de masse';
$language['ACP_PRUNE_TORRENTS']='Torrents Morts';
$language['ACP_PRUNE_USERS']='Utilisateurs Inactifs';
$language['ACP_SITE_LOG']='Voir les Logs du Site';
$language['ACP_SEARCH_DIFF']='Rechercher une Diff.';
$language['ACP_BLOCKS']='Configurer les blocs';
$language['ACP_POLLS']='Configurer les sondages';
$language['ACP_MENU']='Menu Admin';
$language['ACP_FRONTEND']='Configurer le contenu';
$language['ACP_USERS_TOOLS']='Configurer les utilisateurs';
$language['ACP_TORRENTS_TOOLS']='Configurer les torrents';
$language['ACP_OTHER_TOOLS']='Outils Divers';
$language['ACP_MYSQL_STATS']='Statistiques MySQL';
$language['XBTT_BACKEND']='Option XBTT';
$language['XBTT_USE']='Utiliser <a href="http://xbtt.sourceforge.net/tracker/" target="_blank">XBTT</a> en tâche de fond ?';
$language['XBTT_URL']='URL de XBTT ex. http://localhost:2710';
$language['GENERAL_SETTINGS']='Configuration Générale';
$language['TRACKER_NAME']='Nom du site';
$language['TRACKER_BASEURL']='URL du site (sans le dernier /)';
$language['TRACKER_ANNOUNCE']='Announce URLS du Tracker (un lien par ligne)'.($XBTT_USE?'<br />'."\n".'<span style="color:#FF0000; font-weight: bold;">Vérifiez deux fois vos URLS, vous avez activé XBTT en tâche de fond...</span>':'');
$language['TRACKER_EMAIL']='Courriel du Tracker';
$language['TORRENT_FOLDER']='Dossier des torrents';
$language['ALLOW_EXTERNAL']='Autoriser les Torrents Externe';
$language['ALLOW_GZIP']='activer GZIP';
$language['ALLOW_DEBUG']='Afficher le Debug dans le bas des pages';
$language['ALLOW_DHT']='Désactiver les DHT (drapeau priver dans torrent)<br />'."\n".'Sera effectif sur les nouveaux torrents';
$language['ALLOW_LIVESTATS']='Activer les Stats en Live (ressource serveur élevée!)';
$language['ALLOW_SITELOG']='Activer les logs du site basique (logs pour torrents/utilisateurs)';
$language['ALLOW_HISTORY']='Activer historique basique (torrents/utilisateurs)';
$language['ALLOW_PRIVATE_ANNOUNCE']='Announce Privée';
$language['ALLOW_PRIVATE_SCRAPE']='Scrape Privé';
$language['SHOW_UPLOADER']='Montrer pseudo de l\'uploadeur';
$language['USE_POPUP']='Utiliser un Popup pour les détails Torrents/Clients';
$language['DEFAULT_LANGUAGE']='Langue par défaut';
$language['DEFAULT_CHARSET']='Encodage par défaut<br />'."\n".'(si votre langue ne s\'affiche pas correctement essayez UTF-8)';
$language['DEFAULT_STYLE']='Style par défaut';
$language['MAX_USERS']='Max. Utilisateurs (0 = pas de limite)';
$language['MAX_TORRENTS_PER_PAGE']='Torrents par page';
$language['SPECIFIC_SETTINGS']='Configuration Spécifique du Tracker';
$language['SETTING_INTERVAL_SANITY']='Intervalle Sanitaire (secondes, 0 = désactiver)<br />Si activé, 1800 (30 minutes), est une bonne valeur';
$language['SETTING_INTERVAL_EXTERNAL']='Intervalle de mise aà jour Externe (secondes, 0 = désactiver)<br />Dépend de combien de torrents externe';
$language['SETTING_INTERVAL_MAX_REANNOUNCE']='Intervalle max. de reannounce (secondes)';
$language['SETTING_INTERVAL_MIN_REANNOUNCE']='Intervalle min. de reannounce (secondes)';
$language['SETTING_MAX_PEERS']='Nombre max. de partages par requêtes (chiffre)';
$language['SETTING_DYNAMIC']='Autoriser les Torrents Dynamique (non recommandé)';
$language['SETTING_NAT_CHECK']='Vérification NAT';
$language['SETTING_PERSISTENT_DB']='Connexion Persistente (BDD, non recommandé)';
$language['SETTING_OVERRIDE_IP']='Permettre aux utilisateurs de passer outre la détection d\'IP';
$language['SETTING_CALCULATE_SPEED']='Calculer la vitesse de connexion en bytes';
$language['SETTING_PEER_CACHING']='Mettre les tables en caches (devrait diminuer la charge)';
$language['SETTING_SEEDS_PID']='Nombre max. de seeds avec le même PID';
$language['SETTING_LEECHERS_PID']='Nombre max. de leechers avec le même PID';
$language['SETTING_VALIDATION']='Mode de Validation';
$language['SETTING_CAPTCHA']='Inscription Sécurisée (Utilise ImageCode, GD+Freetype libraries obligatoire)';
$language['SETTING_FORUM']='Lien du forum, il peut être:<br /><li><font color="#FF0000">interne</font> ou vide (aucune valeur) pour le forum interne</li><li><font color="#FF0000">smf</font> pour intégré <a target="_new" href="http://www.simplemachines.org">Simple Machines Forum</a> (1.x.x)</li><li><font color="#FF0000">smf2</font> pour intégré <a target="_new" href="http://www.simplemachines.org">Simple Machines Forum</a> (2.x)</li><li><font color="#FF0000">ipb</font> pour intégré <a target="_new" href="http://www.invisionpower.com">Invision Power Board</a> (3.x.x)</li><li>Votre propre logiciel pour le forum (Spécifiez le lien)</li>';
$language['BLOCKS_SETTING']='Configurer les pages Index/Blocs';
$language['SETTING_CLOCK']='Type d\'horloge';
$language['SETTING_FORUMBLOCK']='Affichage dans le Bloc Forum';
$language['SETTING_NUM_NEWS']='Limite pour les dernières nouvelles (chiffre)';
$language['SETTING_NUM_POSTS']='Limite pour le Bloc Forum (chiffre)';
$language['SETTING_NUM_LASTTORRENTS']='Limite d\'affichage des derniers torrents (chiffre)';
$language['SETTING_NUM_TOPTORRENTS']='Limite d\'affichage des torrents les plus populaires (chiffre)';
$language['CLOCK_ANALOG']='Analogique';
$language['CLOCK_DIGITAL']='Digitale';
$language['FORUMBLOCK_POSTS']='Derniers messages';
$language['FORUMBLOCK_TOPICS']='Derniers sujets actifs';
$language['CONFIG_SAVED']='La configuration à été sauvegardée!';
$language['CACHE_SITE']='Intervalle de mise en cache (secondes, 0 = désactiver)';
$language['ALL_FIELDS_REQUIRED']='Tous les champs sont obligatoires !';
$language['SETTING_CUT_LONG_NAME']='Couper le nom du torrent après x caractères (0 = désactiver)';
$language['MAILER_SETTINGS']='Mailer';
$language['SETTING_MAIL_TYPE']='Type Mail';
$language['SETTING_SMTP_SERVER']='Serveur SMTP';
$language['SETTING_SMTP_PORT']='Port SMTP';
$language['SETTING_SMTP_USERNAME']='Utilisateur SMTP';
$language['SETTING_SMTP_PASSWORD']='Mot de passe SMTP';
$language['SETTING_SMTP_PASSWORD_REPEAT']='Mot de passe SMTP (confirm.)';
$language['XBTT_TABLES_ERROR']='Vous devez importé les tables de XBTT (regardez les insctructions de XBTT) dans votre BDD avant d\'activé XBTT en tâche de fond!';
$language['XBTT_URL_ERROR']='URL de XBTT obligatoire!';
// BAN FORM
$language['BAN_NOTE']='Dans cette section du panneau d\'admin, vous pouvez voir les IPs bannis ainsi que bannir de nouvelle adresse IP pour les empêcher d\'accedé au tracker.<br />'."\n".'Vous devez inséré un rang d\'adresse (1ère IP) jusqu\'à (dernière IP).';
$language['BAN_NOIP']='Il n\'y a pas d\'IPs bannis';
$language['BAN_FIRSTIP']='Première IP';
$language['BAN_LASTIP']='Dernière IP';
$language['BAN_COMMENTS']='Commentaires';
$language['BAN_REMOVE']='Supprimer';
$language['BAN_BY']='Par';
$language['BAN_ADDED']='Date';
$language['BAN_INSERT']='Inserré un nouveau rang d\'IP';
$language['BAN_IP_ERROR']='L\'dresse IP est mauvaise.';
$language['BAN_NO_IP_WRITE']='Vous n\'avez pas écrit d\'adresse IP. Désoler!';
$language['BAN_DELETED']='Le rang d\'IP a été supprimé de la base de données.<br />'."\n".'<br />'."\n".'<a href="index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'&amp;do=banip&amp;action=read">Retour</a>';
// LANGUAGES
$language['LANGUAGE_SETTINGS']='Configurer les langues';
$language['LANGUAGE']='Langue';
$language['LANGUAGE_ADD']='Ajouter une nouvelle langue';
$language['LANGUAGE_SAVED']='Félicitations, la langue a bien été modifiée';
// STYLES
$language['STYLE_SETTINGS']='Configurer les styles';
$language['STYLE_EDIT']='Editer le Style';
$language['STYLE_ADD']='Ajouter un nouveau Style';
$language['STYLE_NAME']='Nom du Style';
$language['STYLE_URL']='URL du Style';
$language['STYLE_FOLDER']='Dossier du Style ';
$language['STYLE_NOTE']='Dans cette section vous pouvez manager vos Styles, mais vous devez uploadé vos fichiés par FTP ou SFTP.';
// CATEGORIES
$language['CATEGORY_SETTINGS']='Configuration des catégories';
$language['CATEGORY_IMAGE']='Image';
$language['CATEGORY_ADD']='Ajouter une nouvelle catégorie';
$language['CATEGORY_SORT_INDEX']='Ordre (ID)';
$language['CATEGORY_FULL']='Catégorie';
$language['CATEGORY_EDIT']='Editer la Catégorie';
$language['CATEGORY_SUB']='Sous-Catégorie';
$language['CATEGORY_NAME']='Catégorie';
// CENSORED
$language['CENSORED_NOTE']='Ecrire <b>un mot par ligne</b> pour le censuré (sera changé en *censuré*)';
$language['CENSORED_EDIT']='Editer les mots censurés';
// BLOCKS
$language['BLOCKS_SETTINGS']='Configuration des blocs';
$language['ENABLED']='Activé';
$language['ORDER']='Ordre';
$language['BLOCK_NAME']='Nom du bloc';
$language['BLOCK_POSITION']='Position';
$language['BLOCK_TITLE']='Titre de langue (sera utilisé pour affiché le titre traduit)';
$language['BLOCK_USE_CACHE']='Mettre en cache ce bloc?';
$language['ERR_BLOCK_NAME']='Vous devez selectionné quelque chose dans la liste déroulante !';
$language['BLOCK_ADD_NEW']='Ajouter un nouveau bloc';
// POLLS (more in lang_polls.php)
$language['POLLS_SETTINGS']='Configuration du sondage';
$language['POLLID']='ID du sondage';
$language['INSERT_NEW_POLL']='Ajouter un nouveau Sondage';
$language['CANT_FIND_POLL']='Ne peut trouver le sondage';
$language['ADD_NEW_POLL']='Ajouter un sondage';
// GROUPS
$language['USER_GROUPS']='Configurer les classes (cliquez sur le nom de la classe pour l\'éditée)';
$language['VIEW_EDIT_DEL']='Voir/Editer/Supr';
$language['CANT_DELETE_GROUP']='Cette classe ne peut pas être suprimée !';
$language['GROUP_NAME']='Nom de la classe';
$language['GROUP_VIEW_NEWS']='Voir les Nouvelles';
$language['GROUP_VIEW_FORUM']='Voir le Forum';
$language['GROUP_EDIT_FORUM']='Editer dans le Forum';
$language['GROUP_BASE_LEVEL']='Choisir la classe de base';
$language['GROUP_ERR_BASE_SEL']='Erreur sur la selection de la classe de base !';
$language['GROUP_DELETE_NEWS']='Supprimer les nouvelles';
$language['GROUP_PCOLOR']='Préfix (couleur, comme: ';
$language['GROUP_SCOLOR']='Suffix (couleur, comme: ';
$language['GROUP_VIEW_TORR']='Voir les Torrents';
$language['GROUP_EDIT_TORR']='Editer les Torrents';
$language['GROUP_VIEW_USERS']='Voir les Utilisateurs';
$language['GROUP_DELETE_TORR']='Supprimer les Torrents';
$language['GROUP_EDIT_USERS']='Editer les Utilisateurs';
$language['GROUP_DOWNLOAD']='Peut Télécharger';
$language['GROUP_DELETE_USERS']='Supprimer Utilisateurs';
$language['GROUP_DELETE_FORUM']='Supprimer sur le Forum';
$language['GROUP_GO_CP']='Peut acceder à l\'Admin CP';
$language['GROUP_EDIT_NEWS']='Editer les Nouvelles';
$language['GROUP_ADD_NEW']='Ajouter une nouvelle classe';
$language['GROUP_UPLOAD']='Peut Uploader';
$language['GROUP_WT']='Temps d\'attente si ratio <1';
$language['GROUP_EDIT_GROUP']='Editer la classe';
$language['GROUP_VIEW']='Voir';
$language['GROUP_EDIT']='Editer';
$language['GROUP_DELETE']='Supprimer';
$language['INSERT_USER_GROUP']='Ajouter une nouvelle classe';
$language['ERR_CANT_FIND_GROUP']='Ne peut pas trouver cette classe !';
$language['GROUP_DELETED']='Cette classe a été suprimée !';
// MASS PM
$language['USERS_FOUND']='utilisateurs trouvés';
$language['USERS_PMED']='utilisateurs MP';
$language['WHO_PM']='A qui va être envoyé le MP ?';
$language['MASS_SENT']='MP de masse envoyé!!!';
$language['MASS_PM']='MP de Masse';
$language['MASS_PM_ERROR']='Se serait bien d\'écrire quelque chose avant de l\'envoyé !!!!';
$language['RATIO_ONLY']='ce ratio seulement';
$language['RATIO_GREAT']='plus haut que ce ratio';
$language['RATIO_LOW']='plus bas que ce ratio';
$language['RATIO_FROM']='De';
$language['RATIO_TO']='A';
$language['MASSPM_INFO']='Info';
// PRUNE USERS
$language['PRUNE_USERS_PRUNED']='Utilisateurs inactifs';
$language['PRUNE_USERS']='Prune utilisateurs';
$language['PRUNE_USERS_INFO']='Indiquez le nombre de jours a atteindre pour consideré un utilisateur comme inactif (non connecté pendant x jours OU s\'est inscrit il y a x jourset est toujours en validation)';
// SEARCH DIFF
$language['SEARCH_DIFF']='Rechercher une Diff.';
$language['SEARCH_DIFF_MESSAGE']='Message';
$language['DIFFERENCE']='Différence';
$language['SEARCH_DIFF_CHANGE_GROUP']='Changer la classe';
// PRUNE TORRENTS
$language['PRUNE_TORRENTS_PRUNED']='Torrents Morts';
$language['PRUNE_TORRENTS']='Prune torrents';
$language['PRUNE_TORRENTS_INFO']='Indiquez le nombre de jours a atteindre pour consideré les torrents comme "morts"';
$language['LEECHERS']='leecher(s)';
$language['SEEDS']='seeder(s)';
// DBUTILS
$language['DBUTILS_TABLENAME']='Nom de la Table';
$language['DBUTILS_RECORDS']='Entrées';
$language['DBUTILS_DATALENGTH']='Taille des données';
$language['DBUTILS_OVERHEAD']='Surcharge';
$language['DBUTILS_REPAIR']='Réparée';
$language['DBUTILS_OPTIMIZE']='Optimisée';
$language['DBUTILS_ANALYSE']='Analysée';
$language['DBUTILS_CHECK']='Vérifiée';
$language['DBUTILS_DELETE']='Supprimé';
$language['DBUTILS_OPERATION']='Opération';
$language['DBUTILS_INFO']='Info';
$language['DBUTILS_STATUS']='Status';
$language['DBUTILS_TABLES']='Tables';
// MYSQL STATUS
$language['MYSQL_STATUS']='Status MySQL';
// SITE LOG
$language['SITE_LOG']='Logs du site';
// FORUMS
$language['FORUM_MIN_CREATE']='Classe min. créer';
$language['FORUM_MIN_WRITE']='Classe min. écrire';
$language['FORUM_MIN_READ']='Classe min. lire';
$language['FORUM_SETTINGS']='Configuration du forum';
$language['FORUM_EDIT']='Editer le Forum';
$language['FORUM_ADD_NEW']='Ajouter un nouveau Forum';
$language['FORUM_PARENT']='Forum Parent';
$language['FORUM_SORRY_PARENT']='(Désoler, jene peut pas avoir de forum parent, car j\'en suis moi même un)';
$language['FORUM_PRUNE_1']='Il y a des sujets et/ou des messages dans ce forum!<br />Vous allez perdre toute ces données...<br />';
$language['FORUM_PRUNE_2']='Si vous êtes sur de vouloir supprimé ce forum';
$language['FORUM_PRUNE_3']='sinon revenez en arrière.';
$language['FORUM_ERR_CANNOT_DELETE_PARENT']='Vous ne pouvez pas supprimé un forum, qui contient des sous-forums. Vous devez les déplacez ailleur avant de poursuivre';
// MODULES
$language['ADD_NEW_MODULE']='Ajouter un nouveau Module';
$language['TYPE']='Type';
$language['DATE_CHANGED']='Dernier changement';
$language['DATE_CREATED']='Date de création';
$language['ACTIVE_MODULES']='Modules Actifs: ';
$language['NOT_ACTIVE_MODULES']='Modules Inactifs: ';
$language['TOTAL_MODULES']='Total des Modules: ';
$language['DEACTIVATE']='Désactivé';
$language['ACTIVATE']='Activé';
$language['STAFF']='Staff';
$language['MISC']='Autres';
$language['TORRENT']='Torrent';
$language['STYLE']='Style';
$language['ID_MODULE']='ID';
// HACKS
$language['HACK_TITLE']='Titre';
$language['HACK_VERSION']='Version';
$language['HACK_AUTHOR']='Auteur';
$language['HACK_ADDED']='Ajouté le';
$language['HACK_NONE']='Il n\'y a pas de hacks installé';
$language['HACK_ADD_NEW']='Ajouter un nouveau hack';
$language['HACK_SELECT']='Selectionnez';
$language['HACK_STATUS']='Status';
$language['HACK_INSTALL']='Installer';
$language['HACK_UNINSTALL']='Désinstaller';
$language['HACK_INSTALLED_OK']='Hack installé avec succès !<br />'."\n".'Pour voir tous les hacks installés, retounez à <a href="index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'&amp;do=hacks&amp;action=read">l\'adminCP (Hacks)</a>';
$language['HACK_BAD_ID']='Erreur en essayant de récupéré les infos avec l\'ID.';
$language['HACK_UNINSTALLED_OK']='Hack désinstallé avec succès !<br />'."\n".'Pour voir tous les hacks installés, retounez à <a href="index.php?page=admin&amp;user='.$CURUSER['uid'].'&amp;code='.$CURUSER['random'].'&amp;do=hacks&amp;action=read">l\'adminCP (Hacks)</a>';
$language['HACK_OPERATION']='Opération';
$language['HACK_SOLUTION']='Solution';
// added rev 520
$language['HACK_WHY_FTP']='Certain des fichiers que l\'installateur a besoin de modifier sont ininscriptible. <br />'."\n".'Veuillez mettre les CHMODS appropriés sur vos dossiés dans le FTP. <br />'."\n".'Vos informations FTP peuvent êtres temporairement mise en cache par l\'installateur.';
$language['HACK_FTP_SERVER']='Serveur FTP';
$language['HACK_FTP_PORT']='Port FTP';
$language['HACK_FTP_USERNAME']='Utilisateur FTP';
$language['HACK_FTP_PASSWORD']='Mot de passe FTP';
$language['HACK_FTP_BASEDIR']='Chemin local de XBTIT (chemin de root quand vous vous connectez par FTP)';
// USERS TOOLS
$language['USER_NOT_DELETE']='Vous ne pouvez pas supprimé un invité ou vous-même!';
$language['USER_NOT_EDIT']='Vous ne pouvez pas édité les invités ou vous-même!';
$language['USER_NOT_DELETE_HIGHER']='Vous ne pouvez pas supprimé quelqu\'un plus grader que vous.';
$language['USER_NOT_EDIT_HIGHER']='Vous ne pouvez pas édité quelqu\'un plus grader que vous.';
$language['USER_NO_CHANGE']='Aucun changement de fait.';

$language["BLACKJACK_ADMIN"]="Administration du Blackjack";
$language["BLACKJACK_STAKE"]="Coût par partie (Mo)";
$language["BLACKJACK_PRIZE"]="Battre le dealer avec Blackjack paye";
$language["NORMAL_PRIZE"]="Battre le dealer normalement paye";
$language["BLACKJACK_UPDATED"]="Configuration du Blackjack mis à jour, la configuration peut mettre quelque minutes à être prise en compte .<br /><br /><a href='javascript: history.go(-1);'>Retourner à la page précedante</a>";
$language["BLACKJACK_INFO"]="<br />Le Blackjack typique paye 1:1 en battant le dealer ou 3:2 (1.5:1) en battant le dealer avec Blackjack<br />mais vous pouvez définir le prix vous même. Voici les prix de la configuration actuelle:<br /><br /><li>Pour une mise de ".makesize($btit_settings["bj_blackjack_stake"])." - Battre le dealer avec Blackjack paye ".makesize(($btit_settings["bj_blackjack_stake"]*$btit_settings["bj_blackjack_prize"])+$btit_settings["bj_blackjack_stake"])."</li><li>Pour une mise de ".makesize($btit_settings["bj_blackjack_stake"])." - Battre le dealer paye ".makesize(($btit_settings["bj_blackjack_stake"]*$btit_settings["bj_normal_prize"])+$btit_settings["bj_blackjack_stake"])."</li>";


//Manual Hack Install
$language['MHI_VIEW_INSRUCT'] = 'Voir les instructions manuelles d\'installation ?';
$language['MHI_MAN_INSRUCT_FOR'] = 'Instructions manuelles d\'installation pour';
$language['MHI_RUN_QUERY'] = 'Exécuté la requête SQL ci dessous via phpMyAdmin';
$language['MHI_IN'] = 'Dans';
$language['MHI_ALSO_IN'] = 'Aussi dans';
$language['MHI_FIND_THIS'] = 'trouver ceci';
$language['MHI_ADD_THIS'] = 'Ajouter ceci';
$language['MHI_IT'] = 'il';
$language['MHI_REPLACE'] = 'Remplacer par';
$language['MHI_COPY'] = 'Copier';
$language['MHI_AS'] = 'comme';

$language["ACP_SECSUI_SET"]="Configurer la Suite de Sécuritée";
$language["SECSUI_QUAR_SETTING"]="Configuration de la quarantaine pour les fichiés uploadés";
$language["SECSUI_QUAR_TERMS_1"]="Tèrmes a rechercher (un par ligne)";
$language["SECSUI_QUAR_TERMS_2"]="Mettre ces mots en quarantaine:";
$language["SECSUI_QUAR_TERMS_3"]="NOTE: Il n'est pas utile de mettre <b><&#63;</b> ou <b>&#63;></b> comme il sont présent dans tous les fichiers, vous devez cependant mettre la valeur <b>short_open_tag</b> sur <b>Off</b> dans php.ini, cela va empecher votre site d'éxécuté du code qui commence par <b><&#63;</b> et va forcer les potentiels hackers d'utiliser le tag plus long (<b><&#63;php</b>) à la place.<br /><br />La valeur actuelle est:<br />";
$language["SECSUI_QUAR_DIR_1"]="Chemin de la Quarantaine";
$language["SECSUI_QUAR_DIR_2"]="Ce dossier doit idéalement être impossible d'accès via internet et doit être a au moins un echelon en dessous du dossier de votre tracker par exemple:";
$language["SECSUI_QUAR_DIR_3"]="Soyez sur d'avoir correctement appliqué les CHMOD sur ce dossier pour qu'il soit inscriptible.";
$language["SECSUI_QUAR_PM"]="ID de l'utilisateur à MP quand un fichier est placer en quarantaine";
$language["SECSUI_QUAR_INV_USR"]="Utilisateur Invalide";
$language["SECSUI_PASS_SETTINGS"]="Configuration du mot de passe";
$language["SECSUI_PASS_TYPE"]="Méthode de Hashage du mot de passe";
$language["SECSUI_PASS_INFO"]="Ici vous pouvez selectionné l'algorithme de hashage des mot de passe. Par défaut XBTIT:";
$language["SECSUI_NO_MEMBER"]="Aucun utilisateur avec cet ID";
$language["SECSUI_GAZ_TITLE"]="Gazelle Site Salt";
$language["SECSUI_GAZ_DESC"]="Vous devez entré une valeur, une foit fait vous ne devez plus la changé sinon tout le monde devra récupéré sont mot de passe.";
$language["SECSUI_COOKIE_SETTINGS"]="Configuration des cookies";
$language["SECSUI_COOKIE_PRIMARY"]="Configuration du coookie principal";
$language["SECSUI_COOKIE_TYPE"]="Type de Cookie";
$language["SECSUI_COOKIE_EXPIRE"]="Le cookie expire dans";
$language["SECSUI_COOKIE_T1"]="Classic xbtit";
$language["SECSUI_COOKIE_T2"]="Nouveau xbtit (Regulier)";
$language["SECSUI_COOKIE_T3"]="Nouveau xbtit (Session)";
$language["SECSUI_COOKIE_NAME"]="Nom du cookie";
$language["SECSUI_COOKIE_ITEMS"]="Items du cookie";
$language["SECSUI_COOKIE_PATH"]="Chemin du cookie";
$language["SECSUI_COOKIE_DOMAIN"]="Domaine du cookie";
$language["SECSUI_COOKIE_MIN"]="Minute";
$language["SECSUI_COOKIE_MINS"]="Minutes";
$language["SECSUI_COOKIE_HOUR"]="Heure";
$language["SECSUI_COOKIE_HOURS"]="Heures";
$language["SECSUI_COOKIE_DAY"]="Jour";
$language["SECSUI_COOKIE_DAYS"]="Jours";
$language["SECSUI_COOKIE_WEEK"]="Semaine";
$language["SECSUI_COOKIE_WEEKS"]="Semaines";
$language["SECSUI_COOKIE_MONTH"]="Mois";
$language["SECSUI_COOKIE_MONTHS"]="Mois";
$language["SECSUI_COOKIE_YEAR"]="Année";
$language["SECSUI_COOKIE_YEARS"]="Années";
$language["SECSUI_COOKIE_TOO_FAR"]="Je suis désoler, sa va dépassé la date d'expiration limite de Mar, 19 Jan 2038 03:14:07 GMT, veuillez ajusté correctement les données !";
$language["SECSUI_COOKIE_PSALT"]="Cryptage du mot de passe";
$language["SECSUI_COOKIE_UAGENT"]="Agent Utilisateur";
$language["SECSUI_COOKIE_ALANG"]="Langue acceptée";
$language["SECSUI_COOKIE_IP"]="Adresse IP";
$language["SECSUI_COOKIE_DEF"]="NOTE: Tous les types de cookies incluent par défaut:<br /><br /><li>Tracker ID</li><li>Hash du mot de passe</li><li>Un nombre aléatoire</li>";
$language["SECSUI_COOKIE_PD"]="NOTE: Si vous n'êtes pas sur pour remplir \"Chemin du cookie\" ou \"Domaine du cookie\", laissez les blancs, par défaut.";
$language["SECSUI_COOKIE_IP_TYPE_1"] = "1er octet seulement (Y.N.N.N)";
$language["SECSUI_COOKIE_IP_TYPE_2"] = "2ème octet seulement (N.Y.N.N)";
$language["SECSUI_COOKIE_IP_TYPE_3"] = "3ème octet seulement (N.N.Y.N)";
$language["SECSUI_COOKIE_IP_TYPE_4"] = "4ème octet seulement (N.N.N.Y)";
$language["SECSUI_COOKIE_IP_TYPE_5"] = "1er & 2ème octets (Y.Y.N.N)";
$language["SECSUI_COOKIE_IP_TYPE_6"] = "2ème & 3ème octets (N.Y.Y.N)";
$language["SECSUI_COOKIE_IP_TYPE_7"] = "3ème & 4ème octets (N.N.Y.Y)";
$language["SECSUI_COOKIE_IP_TYPE_8"] = "1er & 3ème octets (Y.N.Y.N)";
$language["SECSUI_COOKIE_IP_TYPE_9"] = "1er & 4ème octets (Y.N.N.Y)";
$language["SECSUI_COOKIE_IP_TYPE_10"] = "2ème & 4ème octets (N.Y.N.Y)";
$language["SECSUI_COOKIE_IP_TYPE_11"] = "1er, 2ème & 3ème octets (Y.Y.Y.N)";
$language["SECSUI_COOKIE_IP_TYPE_12"] = "2ème, 3ème & 4ème octets (N.Y.Y.Y)";
$language["SECSUI_COOKIE_IP_TYPE_13"] = "Adresse IP Entière (Y.Y.Y.Y)";
$language["SECSUI_PASSHASH_TYPE_1"] = "Classic xbtit";
$language["SECSUI_PASSHASH_TYPE_2"] = "TBDev";
$language["SECSUI_PASSHASH_TYPE_3"] = "TorrentStrike";
$language["SECSUI_PASSHASH_TYPE_4"] = "Gazelle";
$language["SECSUI_PASSHASH_TYPE_5"] = "Simple Machines Forum";
$language["SECSUI_PASSHASH_TYPE_6"] = "New xbtit";
$language["SECSUI_PASS_MUST"] = "Le mot de passe doit";
$language["SECSUI_PASS_BE_AT_LEAST"] = "Etre long de";
$language["SECSUI_PASS_HAVE_AT_LEAST"] = "Contenir au moins";
$language["SECSUI_PASS_CHAR_IN_LEN"] = "caractères";
$language["SECSUI_PASS_CHAR_IN_LEN_A"] = "caractères";
$language["SECSUI_PASS_LC_LET"] = "lettre minuscule";
$language["SECSUI_PASS_LC_LET_A"] = "lettres minuscules";
$language["SECSUI_PASS_UC_LET"] = "lettre majuscule";
$language["SECSUI_PASS_UC_LET_A"] = "lettres majuscules";
$language["SECSUI_PASS_NUM"] = "chiffre";
$language["SECSUI_PASS_NUM_A"] = "chiffres";
$language["SECSUI_PASS_SYM"] = "symbole";
$language["SECSUI_PASS_SYM_A"] = "symboles";
$language["SECSUI_PASS_ERR_1"] = "Vous ne pouvez pas avoir une valeur plus élevée pour les majuscules + minuscules + chiffres + symboles";
$language["SECSUI_PASS_ERR_2"] = "que vous avez pour le nombre de caractères minimum nécessaire pour le mot de passe";

$language["SMF_MIRROR"] = "Mirroir SMF";
$language["GROUP_SMF_MIRROR"] = "Faites miroiter les classes sur le forum SMF pour les changements de classes etc.";
$language["SMF_LIST"] = "<b><u>Classes présentes dans la BDD pour SMF</u></b><br />";

$language["IPB_AUTO_ID"] = "ID IPB pour Autopost";
$language["IPB_MIRROR"] = "Mirroir IPB";
$language["GROUP_IPB_MIRROR"] = "Faites miroiter les classes sur le forum IPB pour les changements de classes etc.";
$language["IPB_LIST"] = "<b><u>Classes présentes dans la BDD pour IPB</u></b><br />";

$language["STYLE_TYPE"]="Type de Style"; 
$language["CLA_STYLE"]="xbtit classic style system"; 
$language["ATM_STYLE"]="atmoner style system"; 
$language["PET_STYLE"]="Petr1fied style system";



$language["ACP_STICKY_TORRENTS"]="Configuration des Post-it";
$language["STICKY_SETTINGS"]="Configuration Post-It";
$language["COLOR"]="Couleur";
$language["LEVEL_STICKY"]="Qui peut ajouté des Post-It ? (défaut: Uploadeur)";



$language["ACP_SEEDBONUS"]="Configuration du SeedBonus";
$language["BONUS"]="Points par torrent et par heure";
$language["PRICE_VIP"]="Prix du rang VIP";
$language["PRICE_CT"]="Pri du titre personalisé";
$language["PRICE_NAME"]="Prix du changement de pseudonyme";
$language["PRICE_GB"]="Prix des Go";
$language["POINTS"]="Points";
$language["SEEDBONUS_UPDATED"]="Configuration du SeedBonus mise à jour";


$language['ACP_DONATE']='Configuration des Don & VIPs';

$language['ACP_DON_HIST']='Historique des dons';
$language['ACP_FREECTRL']='Configuration du FreeLeech';
$language["AVATAR_UPLOAD"] = "Upload d'avatar";
$language["MAX_FILE_SIZE"] = "Taille max. du fichier ! (en ko)";
$language["MAX_IMAGE_SIZE"] = "Taille max. de l'image !";
$language["IMAGE_WIDTH"] = "Largeur";
$language["IMAGE_HEIGHT"] = "Hauteur";
$language['ACP_FLUSH']='Supprimer les torrents fantomes';
$language['GROUP_MAX_TORRENTS']='Torrents Actifs max. ';


$language["IMAGE_SETTING"]="Configuration des Images";
$language["ALLOW_IMAGE_UPLOAD"]="Autoriser l'upload d'image";
$language["ALLOW_SCREEN_UPLOAD"]="Autoriser l'upload de screens";
$language["IMAGE_UPLOAD_DIR"]="Dossier des images";
$language["FILE_SIZELIMIT"]="Taille limite de l'image";

// NEW USER DONATE UPLOAD
$language["SETTINGS_UPLOAD"]="Dons d'items pour les nouveaux membres.";
$language["VALUE_UPLOAD"]="Entrez une valeur et choissisez une unitée.";
$language["KB"]="Ko";
$language["MB"]="Mo";
$language["GB"]="Go";
$language["TB"]="To";

$language["ACP_COMMENTS"]="Espionneur de commentaires";

//RULES
$language["ACP_RULES_GROUP"]="Groupe de Règles";
$language["ACP_RULES"]="Règles";
//FAQ
$language["ACP_FAQ_GROUP"]="Groupes de FAQ";
$language["ACP_FAQ"]="FAQ";
$language["ACP_FAQ_QUESTION"]="Questions de FAQ";
      

$language["ACP_FEATURED"]="Torrent Recommandés";


$language["WHERE_HEARD"] = 'Entendue parler de nous';

$language['SB_CONTROL']= 'Contrôles du SeedBonus';
$language["ACP_MENU_COOLY"]="Message d'Accueil";
$language["COOLYS_USERSTUFF"]="Message d'Accueil";
$language["UP_CONTROL"]="Contrôles des Uploadeurs";
      
$language["RHUS_HIGH_UL_SUP"] = "Signalement vitesse d'upload élevé";
$language["RHUS_EN_SYS"] = "Fonction";
$language["RHUS_DIS"] = "désactivé";
$language["RHUS_REP_FROM"] = "Vitesse minimale";
$language["RHUS_REP_TU"] = "Méthode de signalement";
$language["RHUS_ONLY_ONCE"] = "une seule fois";
$language["RHUS_NO_LIM"] = "à chaque fois";

$language['ACP_LRB']='Avertissement & Ban pour mauvais ratio';
$language["ACP_MASSEMAIL"]="Courriel de Masse";
$language["DUPLICATES"]="IP en Double";
$language["ERROR"]="Erreur";
$language["ERR_USERS_NOT_FOUND"]="Aucun utilisateur trouvé !";
$language["ACP_OFFLINE"]="Site Hors-Ligne";
$language["OFFLINE_SETTING"]="Le Site est Hors-Ligne ?";
$language["OFFLINE_MESSAGE"]="Message à affiché aux utilisateurs (max 200 caractères, seul la classe admin peut acceder au site en mode Hors-ligne)";
      

$language["ACP_BIRTHDAY"]="Configurer le Hack Anniversaire";
$language["BIRTHDAY_LOWER_LIMIT"]="Age Minimum";
$language["BIRTHDAY_UPPER_LIMIT"]="Age Maximum";
$language["BIRTHDAY_BONUS"]="Bonus anniversaire par année (Go)";
$language["BIRTHDAY_UPDATED"]="Merci, votre configuration du Hack Anniversaire à été mise à jour";

$language["ACP_LOTTERY"]="Loterie";
$language["LOTT_SETTINGS"]="Configurer la Loterie";
$language["EXPIRE_DATE"]="Date de fin";
$language["EXPIRE_TIME"]="Heure de fin";
$language["EXPIRE_DATE_VIEW"]="(AAAA-MM-JJ)";
$language["EXPIRE_TIME_VIEW"]="en heures complète";
$language["IS_SET"]="est la date et l'heure actuelle)";
$language["NUM_WINNERS"]="Nombre de gagnants";
$language["TICKET_COST"]="Somme à payé (par ticket)";
$language["MIN_WIN"]="Pot de départ";
$language["LOTTERY_STATUS"]="Loterie activée";
$language["VIEW_SELLED"]="Voir les tickets vendus";
$language["ACP_SELLED_TICKETS"]="Tickets Vendus";
$language["NO_TICKET_SOLD"]="Aucun ticket vendu";
$language["TICKETS"]="tickets";
$language["PURCHASE"]="Acheter";
$language["SOLD_TICKETS"]="Tickets Vendus";
$language["LOTTERY"]="Loterie";
$language["MAX_BUY"]="Nombre max. de ticket par membres";
$language["LOTT_ID"] = "ID";
$language["LOTT_USERNAME"] = "Pseudonyme";
$language["LOTT_NUMBER_OF_TICKETS"] = "Nombre de tickets";
$language["BACK_TO_LOTTERY"]="Retour à la Loterie";
$language["LOTT_SENDER_ID"]="ID envoyeur du MP";

//INVITATION SYSTEM
$language['ACP_INVITATION_SYSTEM']='System d\'Invitations';
$language['ACTIVE_INVITATIONS']='Activer le system d\'Invitations:';
$language['PRIVATE_TRACKER']='Tracker Privé';
$language['PRIVATE_TRACKER_INFO']='Pour une sécurité renforcée, en mettant l\'option "Privé",<br />Le nombre max. de membres a été mis automatiquement sur "1".';
$language['ACP_INVITATIONS']='Invitations';
$language['VALID_INV_MODE']='Confirmation par l\'inviteur obligatoire';
$language['INVITE_TIMEOUT']='Temps de validitée pour les invitations<br />( en jours )';
$language['INVITED_BY']='Inviter par';
$language['SENT_TO']='Envoyé à';
$language['DATE_SENT']='Date d\'envoi';
$language['INV_WELCOME']='Bienvenue sur le Panneau du System d\'Invitation.<br />Activé cette option rend la possesion d\'un code obligatoire<br />pour s\'inscrire sur le site.';
$language['HASH']='Hash';
$language['VALID_INV_MODE']='Confirmation obligatoire';
$language['VALID_INV_EXPL']='<i>Les Inviteurs doivent confirmés les comptes de leurs Invités</i>';
$language['INVITE_TIMEOUT']='Temps de validitée pour les invitations<br />( en jours )';
$language['GIVE_INVITES_TO']='Donner des Invitations';
$language['NUM_INVITES']='Nombre d\'Invitations';
$language['INVITES_SETTINGS']='Configuration';
$language['INVITES_LIST']='Liste des Invitation';
$language['SENDINV_CONFIRM']='Etes-vous sur de vouloir envoyé cette invitation?';
$language['ERR_SENDINVS']='Veuillez indiqué le nom d\'utilisateur ou l\'ID.';
$language['SENDINV_EXPL']='Si le nom d\'utilisateur n\'est pas indiqué, la classe sera choisi à la place.';
$language['RECYCLE_DATE']='Période de Recyclage';
$language['RECYCLE_EXPL']='<i>Période en <u>jours</u> après les invitations sont recyclées</i>';
        
$language["REPUTATION"]="Configurer la Réputation";
$language["REPUTATION_LIST"]="Espionner la Réputation";
      

$language["AUTO_PRUNE_USERS"]="Configurer Membres Inactifs Auto.";
$language["ALLOW_AUTO_PRUNE"]="Autoriser la supression automatique";
$language["ALLOW_EMAIL_ON_PRUNE"]="Autoriser le courriel avant la suppression automatique";
$language["DAYS_MEMBERS"]="Jours Inactifs avant supression";
$language["DAYS_NOT_CONFIRM"]="Jours pour les comptes non confirmés";
$language["DAYS_TO_EMAIL"]="Jour Inactifs pour l'envoi du courriel";
$language["AUTO_PRUNE"]="Suppression Auto.";



$language['BAN_CLIENT']='Bannir Client Bittorrent';
$language['REMOVE_CLIENTBAN']='Supprimer le ban du client bittorent';
$language['CLIENT_REMOVED']='Ce client a été enlevé de la liste des clients bannis.<br /><br />';
$language['RETURN']='Retour';
$language['UNBAN_MAIN']='En visitant page vous indiquez vouloir le ban du client suivant:';
$language['CONFIRM_ACTION']='Ete vous sur de vouloir faire ceci ? (c\'est la dernière confirmation).';
$language['CLIENT_ALREADY_BANNED']='Ce client est déjà bannis !';
$language['ALL_VERSIONS']='Toutes les versions';
$language['CLIENT_ADDED']='Ce client a été ajouté à la liste des clients bannis<br /><br />';
$language['NEED_A_REASON']='Vous devez indiqué une raison!';
$language['BAN_MAIN']='En visitant cette page vous indiquez vouloir le ban du client suivant:';
$language['BAN_ALL_VERSIONS']='Bannir toutes les versions ?';
$language['REASON']='Raison';


//GOLD
$language["ACP_GOLD"]="Configurer les torrents en Or";


$language['ACP_CLIENTS']='Configuration Recommandée';
$language["ACP_FREELEECH_REQ"]="Demandes de FreeLeech";
$language["SEEDBONUS"]="SeedBonus";
      
//Add New Users in AdminCP
$language["ACP_ADD_USER"]='Ajouter un utilisateur';
$language["NEW_USER_EMAIL"]='Envoyer un courriel avec le mot de passe';
$language["NEW_USER_EMAIL_TEXT"]='
Bonjour %s,

Vous vennez d\'être ajouté sur %s,
Utilisateur: %s
Mot de passe: %s

Nous espèrons que vous passerez du bon temps avec nous
Le Staff';

$language["VFL"] = "FreeLeech";
$language["ACP_ISPY"]="Espionneur de Message";

if ($CURUSER["id_level"]=='8')
{
$language['ACP_OWNER'] = 'Pour le proprio seulement';
$language['TIM']= 'Contrôles des classes programmés';
}
$language['MO']= 'Etes-vous sur de vouloir remettre l\'ancienne classe de ce membre?';
$language['MA']= 'Annuler';
$language['AUSER']= 'Utilisateur';
$language['OL']= 'Ancienne classe';
$language['NE']= 'Nouvelle classe';
$language['BY']= 'Action Par';
$language['DA']= 'Quand';
$language['T_EXP']= 'Expire';
$language['SC']= 'Contrôle du staff';
$language['ST']= 'Contrôle du staff des Classes programmés';
$language["ACP_BB"]="Bouton Ban - Rang d\'IP";
$language["ACP_BB_USER"]="Bouton Ban - Utilisateur";
$language["ACP_BOOTU"]="Ban temporaire";
$language["ACP_BOOTED"]="Ban Temporaire";
$language["ACP_BOOTED1"]="Liste Ban Temp.";
$language["ACP_BOOTEDUN"]="Utilisateur";
$language["ACP_BOOTEEXP"]="Expire";
$language["ACP_BOOTEREA"]="Raison Ban Temp.";
$language["ACP_BOOTEADDB"]="Ban temporaire ajouté par";      
$language["ACP_PROXY"]="Utilisateurs de Proxy";
$language["ACP_BLACKLIST"]="Liste Noire";
$language["ACP_HITRUN"]="Configuration du Hit & Run";
$language["BAN_CHEAPMAIL"]="Ban. fournisseur de courriel";
$language["ERR_WILDCARD_1"]="Le joker ";
$language["ERR_WILDCARD_2"]=" est déjà sur la liste des fournisseur de courriel bannis il n'y a donc pas besoin de l'ajouté ";
$language["ERR_WILDCARD_3"]=" à la liste.";
$language["CHEAP_CONFIRM_1"]="Etes-vous sur de vouloir supprimé ";
$language["CHEAP_CONFIRM_2"]="C'est la dernière confirmation";
$language["CHEAP_DELETED_1"]=" a été supprimé";
$language["CHEAP_DELETED_2"]="Cliquez ici";
$language["CHEAP_DELETED_3"]=" pour revenir en arrière";
$language["ERR_CHEAP_SUBMIT"]="Vous devez entré une valeur !!";
$language["CHEAP_ADDED"]=" a été ajouté à la liste des fournisseur de courriel bannis";
$language["ERR_CHEAP_DUPE"]=" est déjà dans la liste des fournisseur de courriel bannis";
$language["CHEAP_CURRENT"]="Fournisseur de courriel actuellement bannis";
$language["ADDED_BY"]="Ajouté par";
$language["CHEAP_COUNT_1"]="Il y a ";
$language["CHEAP_COUNT_2"]=" fournisseurs de courriel bannis";
$language["CHEAP_ADD"]="Ajouter un fournisseur à la liste:";
//Hide Language & Style Menu
$language['ACP_HIDDEN']='Caché';
$language['ACP_VISIBLE']='Visible';
$language['ACP_HIDE_LANGUAGE']='Caché/Montré le Menu Langue';
$language['ACP_HIDE_STYLE']='Caché/Montré le Menu Style';
$language['ACP_HIDE_STYLE_LANGUAGE']='Caché les Menus Style & Langue';
$language["ACP_LOGLOG"]="Tentative de connexion échoué";
$language["LOGLOG_IP"]="IP";
$language["LOGLOG_FAIL"]="Echoué";
$language["LOGLOG_REM"]="Restant";
$language["LOGLOG_UNIK"]="Utilisateur si connus";
$language["LOGLOG_NOTH"]="Rien";
$language["LOGLOG_HERE"]="Ici";
$language["LOGLOG_YET"]="Encore";
$language['tmsg1']="Ticker Message 1";
$language['tmsg2']="Ticker Message 2";
$language['tmsg3']="Ticker Message 3";
$language['tmsg4']="Ticker Message 4";
$language["ACP_AUTORANK"] = "Administration Classe Auto.";
$language["AUTORANK_INVALID"] = "Entrée invalide, entrez un nombre entre 1 et 23";
$language["AUTORANK_MAIN_1"] = "Pour épargné des surcharges seul les utilisateurs qui sont connecté aux torrents seront scanner pour les changement de classe automatique. La base entière des membres sera scané une fois toute les 24 heures et vous devez indiqué l'heure du scan ci-dessous.<br /><br /><b>Notez que:</b> Mettez une heure ou il n'y a pas beaucoup de monde, mais assez pour que tout ce passe bien quand même.<br /><br />Valeurs autorisés 0-23 (0 = minuit)";
$language["AUTORANK_MAIN_2"] = "Heure du Scan Complet";
$language["AUTORANK_MAIN_3"] = "Vous pouvez ajuster toute les autres valeurs";
$language["AUTORANK_MAIN_4"] = "ici";
$language["SUBMIT"] = "Valider";
// FORUM AUTO-TOPIC
$language['ACP_CATFORUM_CONFIG']='Configuration Sujet-Auto sur le forum';
$language['ACP_CATFORUM_SELECT']='Sujet-Auto sur le forum';
$language['AUTOTOPIC_MESS1']='<br />Ici vous pouvez activé les Sujets-Auto sur le forum à chaque upload de nouveau torrent.<br>Vous devez choisir Interne ou SMF Forum dans la configuration du tracker si vous souhaitez utilisé cette fonction.';
$language['AUTOTOPIC_MESS2']='<br>Selectionné quel forum va avec quel catégorie.<br>Les modifications s\'appliquent immédiatement. Vous pouvez choisir un forum par catégorie torrent.<br>Seul les torrents uploadé après l\'activation seront concernés.<br />';
$language['AUTOTOPIC_ACTIVE']='Activé Sujet-Auto SMF';
$language['AUTOTOPIC_PREFIX']='Préfixe du sujet<br />Choissisez un préfixe à mettre avant le nom du sujet ex. \"[Post] \".';
$language["DEL_SHOUT"]="Nettoyer la ShoutBox";
$language["CLEAN_SHOUT"]="ShoutBox Nettoyée";
$language["CLEAN_CONFIRM"]="Nettoyer la ShoutBox";	  
$language['GROUP_STYLE']='Saison';
$language["IRC_SETTINGS"]="Configuration IRC";
$language["SETTING_IRC_SERVER"]="Serveur IRC (sans irc://)";
$language["SETTING_IRC_PORT"]="Port IRC";
$language["SETTING_IRC_CHANNEL"]="Champs IRC (sans #)";

$language["DUPLICATES_PAS"]="Double Mot de passe";
$language["ERROR_PAS"]="Erreur";
$language["ERR_USERS_NOT_FOUND_PAS"]="Aucun utilisateur trouver !";
?>