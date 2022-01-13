<?php
$language['DELETE_READED']='Supprimer';
$language['USER_LANGUE']='Langue';
$language['USER_STYLE']='Style';
$language['CURRENTLY_PEER']='Vous seeder ou leecher actuellement quelques torrents.';
$language['STOP_PEER']='Vous devez stopper votre client.';
$language['USER_PWD_AGAIN']='Répéter le mot de passe';
$language['EMAIL_FAILED']='L\'envoi du courriel a échoué!';
$language['NO_SUBJECT']='Aucun sujet';
$language['MUST_ENTER_PASSWORD']='<br /><font color="#FF0000"><strong>Vous devez indiqué votre mot de passe pour sauvegarder la configuration ci-dessus.</strong></font>';
$language['ERR_PASS_WRONG']='Mot de passe vide ou incorrecte, impossible de mettre à jour le profile.';
$language['MSG_DEL_ALL_PM']='Si vous selectionnez des MPs qui n\'ont pas été lu, ils ne seront pas supprimés';
$language['ERR_PM_GUEST']='Désoler vous ne pouvez pas envoyé de MP aux invités ou a vous même !';
$language["MNU_UCP_AVATAR"] = "Uploader un Avatar";
$language["AVATAR_SUCCESS"] = "L'avatar a été uploadé avec succès !";
$language["AVATAR_FAILURE1"] = "Echec. La taille de l'image est trop grande! Les mesures sont";
$language["AVATAR_FAILURE2"] = "Echec. La taille de l'image est trop grosse! La limite est de";
$language["AVATAR_FAILURE3"] = "Echec. Une raison inconnue s'est produite!";
$language["AV_FEW_HEAD"] = "Règles d'upload d'avatar";
$language["AV_FILE_SIZE"] = "Poids limite du fichier: ";
$language["AV_IMAGE_SIZE"] = "Taille maximum de l'image: ";
$language["AV_FORBIDDEN"] = "Merci de ne pas uploadé une image offenscente pour les autres";
$language["AV_NO_HEADER"] = "Vous avez déjà uploadé un Avatar. Vous ne pouvez plus en uploadé de nouveau.";
$language["AV_NO_1"] = "Vous avez uploadé recemment";
$language["AV_NO_2"] = "Supprimer ce fichier";
$language["AV_NO_3"] = "Lien vers le fichier";
//INVITATION SYSTEM
$language['ACCOUNT_CONFIRMED']='Compte confirmer';
$language['CONFIRMED']='Confirmé';
$language['DATE_SENT']='Date d\'envoi';
$language['ERR_EMAIL_ALREADY_EXISTS']='Cette adresse courriel éxiste déjà dans notre base de données.';
$language['ERR_INVITATIONS_OFF']='Désoler, le system d\'invitation est désactiver.';
$language['ERR_MISSING_DATA']='Information manquante!<br />Veuillez remplir tous les champs.';
$language['INSERT_EMAIL']='Vous n\'avez pas entré d\'adresse courriel!';
$language['INSERT_MESSAGE']='Il n\'y a pas de texte!';
$language['INVIT_CONFIRM']='Invitation Confirmée';
$language['INVIT_MSG']='Hello,<br /><br />Vous avez été invité à rejoindre '.$SITENAME.' par';
$language['INVIT_MSG1']='<br />Si vous voulez accepté cette invitation, vous devez suivre ce lien:<br /><br />';
$language['INVIT_MSG2']='<br /><br />Vous devez accepté l\'invitation dans les 24 heures, sinon le lien sera inactif.<br />Nous, '.$SITENAME.' espèrons que vous allez accepter l\'invitation et rejoindre notre comunautée!<br /><br />Message personnel de';
$language['INVIT_MSG3']='<br /><br />----------------<br />Si vous ne connaissez pas la personne qui vous a invité, veuillez transféré ce courriel à '.$SITEEMAIL;
$language['INVIT_MSGCONFIRM']='Bonjour,<br />Votre compte a été confirmé. Vous pouvez maintenant visité<br /><br />'.$BASEURL.'/login.php<br /><br />pour vous connectez. Merci de lire la FAQ\'s et les Règles avant de partager un fichier.<br /><br />Amusez vous bien sur '.$SITENAME.'!<br /><br /><br />----------------<br />Si vous ne vous êtes pas inscrit sur '.$SITENAME.', merci de transféré ce courriel à '.$SITEEMAIL;
$language['INVITATIONS']='Invitations';
$language['INVITE_SOMEONE_TO']='Envoyer une Invitation';
$language['MEMBERS_INVITED_BY']='Utilisateurs invités par vous';
$language['MESSAGE']='Message';
$language['MNU_UCP_INVITATIONS']='Invitations';
$language["MNU_UCP_TOOLS"]='Outils';
$language['NO_INV']='Il ne vous reste plus d\'invitation.';
$language['NO_INVITATIONS_OUT']='Pas d\'invitation envoyé.';
$language['NO_NEED_CONFIRM_YET']='Pas d\'invitation a confirmer.';
$language['PENDING']='En attente';
$language['REMAINING']='Restant';
$language['SENT_INVITATIONS']='Invitations envoyés';
$language['STATUS']='Status';
$language['WELCOME_UCP_INVITE']='Bienvenue sur votre Panneau d\'Invitation.<br />Ici vous pouvez envoyé des invitations, pour que vos amis s\'inscrivent sur '.$SITENAME.'.<br />';
        

$language["PROFILEVIEW"] = "Montrer/Cacher le Profile";

$language["MNU_UCP_RENAME"]="Changer de pseudo";
$language["CURR_NICK"]="Pseudonyme actuel";
$language["NEW_NICK"]="Nouveau pseudonyme";
$language["REPEAT_NICK"]="Répéter le nouveau pseudonyme";
$language["ERR_NICK_NO_MATCH"]="Les pseudonymes ne correspondent pas";
$language["ERR_SAME_NICK"]="Votre pseudonyme est déjà utilisé";
$language["ERR_NICK_TOO_SMALL"]="Votre nouveau pseudonyme doit être long de 3 caractères minimum";
$language["ERR_NICK_NOT_ALLOWED"]="Ce pseudonyme est interdit d'utilisation";
$language["NICK_CHANGE_SUCCESS"]="Vous avez changer avec succès votre pseudonyme en ";
$language["CHANGED_THEIR_NICK"]="Ont changés leurs pseudonymes en ";
$language["CHANGE_NICKNAME"]="Changer de pseudo";
// UserBars
$language['USERBAR'] = 'UserBar';
$language['NEWUSERBAR'] = 'Changer UserBar';

$language["SUBSCRIBE"]="Souscriptions";
$language["SUB_OK"]="Vous avez souscrit avec succès aux <a href=\"index.php?page=usercp&amp;do=subscribe&amp;action=change&amp;uid=".$CURUSER["uid"]."\">catégories sélectionnés</a>";
$language["SUB_SUBJECT"]="Souscriptions Torrents sur $SITENAME";
$language["SUB_EMAIL"]="Bonjour,\nUn nouveau torrent \"%s\" a été uploadé dans une catégorie que vous avez souscrite\n\nDétails: %s\nTélécharger: %s\n\nBon téléchargement\n$SITENAME";
$language["APARKED"]="Compte Parker";
$language["GENDER"]="Genre";
$language["MALE"]="Homme";
$language["FEMALE"]="Femme";
$language["UNKNOW"]="Inconnu";
?>