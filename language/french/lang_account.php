<?php
$language['ACCOUNT_CREATED']='Compte créé';
$language['USER_NAME']='Utilisateur';
$language['USER_PWD_AGAIN']='Confirmez le mot de passe';
$language['USER_PWD']='Mot de passe';
$language['USER_STYLE']='Style';
$language['USER_LANGUE']='Language';
$language['IMAGE_CODE']='Code Image';
$language['INSERT_USERNAME']='Vous devez saisir un nom d\'utilisateur !';
$language['INSERT_PASSWORD']='Vous devez saisir un mot de passe !';
$language['DIF_PASSWORDS']='Les mots de passe ne correspondent pas !';
$language['ERR_NO_EMAIL']='Vous devez saisir un courriel valide !';
$language['USER_EMAIL_AGAIN']='Confirmez le courriel';
$language['ERR_NO_EMAIL_AGAIN']='Confirmez le courriel';
$language['DIF_EMAIL']='Les courriels ne correspondent pas !';
$language['SECURITY_CODE']='Répondez à la question';
# Password strength
$language['WEEK']='Faible';
$language['MEDIUM']='Moyen';
$language['SAFE']='Sécurisé';
$language['STRONG']='Fort';
$language["ERR_GENERIC"]='Erreur Générique: '.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));

$language['HEARD_ABOUT_US'] = '<font color = red>[optional] </font>Ou avez-vous entendu parler de nous ?';
//INVITATION SYSTEM
$language['INVIT_MSGINFO']='Vous avez demandé l\'ouverture d\'un compte sur '.$SITENAME.' et vous avez\nspécifié cette adresse (';
$language['INVIT_MSGINFO1']=') dans notre formulaire d\'inscription.<br /><br />Votre compte est en attente de confirmation par la personne qui vous a inviter.'.
                            '<br />Temps que votre compte n\'est pas confirmé, vous ne pouvez pas vous connecté au site.<br /><br />Information du compte:\nUtilisateur:';
$language['INVIT_MSGINFO2']='Mot de passe:';
$language['INVIT_MSGINFO3']='Si vous ne confirmer pas votre compte dans les 24 heures, il sera supprimé.'.
                            '<br />----------------<br />Si vous ne vous êtes pas inscrit sur '.$SITENAME.', merci de transférer ce courriel à '.$SITEEMAIL;
$language['INVIT_MSG_AUTOCONFIRM3']='----------------<br />Vous pouvez maintenant vous rendre sur<br /><br />'.$BASEURL.'/login.php'.
                                    '<br /><br />utilisez vos informations pour vous connecté.<br /><br />'.
                                    'A bientôt sur '.$SITENAME.'!<br /><br /><br />----------------<br />'.
                                    'Si vous ne vous êtes pas inscrit sur '.$SITENAME.', merci de transférer ce courriel à '.$SITEEMAIL;
$language['REG_CONFIRM']='Confirmation du Compte';
$language['INVITATION_ONLY']='Désolé, les inscriptions sont désactivés.<br>Vous devez possedé une invitation pour vous inscrire.';
$language['WELCOME_INVITE']='Bienvenue! Vous avez accepté une invitation de la part d\'un de nos membres.<br />Vous pouvez vous incrire.';
$language['INVITE_EMAIL_SENT1']='Un courriel de confirmation a été envoyé à l\'adresse spécifiée';
$language['INVITE_EMAIL_SENT2']='<br />Vous devez attendre que la personne qui vous a invité confirme votre compte.';
$language['INVITE_EMAIL_SENT3']='Un courriel de confirmation a été envoyé à l\'adresse spécifiée';
$language['INVITE_EMAIL_SENT4']='<br />Vous pouvez maintenant vous <a href="index.php?page=login">connecter</a>. A bientôt sur '.$SITENAME.'!';
$language['INVALID_INVITATION']='Your invitation code is invalid.';
$language['ERR_INVITATION']='<br />Demandez une autre invitation à la personne qui vous a inviter.';
$language["GENDER"]="Sexe";
$language["MALE"]="Homme";
$language["FEMALE"]="Femme";
$language["UNKNOW"]="Inconnu";        
$language["DOMAIN_BANNED"]="Ce fournisseur de messagerie est bannis. Veuillez utilisé un autre fournisseur.";
$language['PASSWORD_GENERATE']='Mot de pass généré';
$language['PASSWORD_GENERATE_INFO']='(Pour plus de sécurité, utilisez le mot de passe généré, n&rsquo;oubliez pas de le sauvegarder quelque part !)';
?>