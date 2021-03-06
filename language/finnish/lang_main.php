<?php
global $users, $torrents, $seeds, $leechers, $percent;
// $language["rtl"]="rtl"; // if your language is  right to left then uncomment this line
// $language["charset"]="ISO-8859-1"; // uncomment this line with specific language charset if different than tracker's one
$language["ACCOUNT_CONFIRM"]="K&auml;ytt&auml;j&auml;tilin vahvistaminen osoitteessa $SITENAME .";
$language["ACCOUNT_CONGRATULATIONS"]="Onneksi olkoon, k&auml;ytt&auml;j&auml;tilisi on nyt hyv&auml;ksytty!<br />Nyt voit <a href=index.php?page=login>login</a> Kirjautua sis&auml;&auml;n.";
$language["ACCOUNT_CREATE"]="Luo k&auml;ytt&auml;j&auml;tili";
$language["ACCOUNT_DELETE"]="Poista k&auml;ytt&auml;j&auml;tili";
$language["ACCOUNT_DETAILS"]="K&auml;ytt&auml;j&auml;tilin tiedot";
$language["ACCOUNT_EDIT"]="Muokkaa k&auml;ytt&auml;j&auml;tili&auml;";
$language["ACCOUNT_MGMT"]="K&auml;ytt&auml;j&auml;tilin hallinta";
$language["ACCOUNT_MSG"]="Hei,\n\nT&auml;m&auml; viesti l&auml;hettiin siksi, ett&auml; joku (luultavasti sin&auml;) teki tunnukset t&auml;ll&auml; s&auml;hk&ouml;postiosoitteella.\nJos et ole tekij&auml; niin unohda t&auml;m&auml; maili. Muuten, vahvista k&auml;ytt&auml;j&auml;tilisi \n\nTerverisin Yll&auml;pito.";
$language["ACTION"]="Toiminto";
$language["ACTIVATED"]="Aktiivinen";
$language["ACTIVE"]="Arvo";
$language["ACTIVE_ONLY"]="Vain aktiivinen";
$language["ADD"]="Lis&auml;&auml;";
$language["ADDED"]="Lis&auml;tty";
$language["ADMIN_CPANEL"]="Staff paneeli";
$language["ADMINCP_NOTES"]="T&auml;&auml;ll&auml; voit hallita trakkerin asetuksia...";
$language["ALL"]="Kaikki";
$language["ALL_SHOUT"]="Kaikki huudot";
$language["ANNOUNCE_URL"]="Trakkerin announce linkki:";
$language["ANONYMOUS"]="Tuntematon";
$language["ANSWER"]="Vastaus";
$language["AUTHOR"]="Tekij&auml;";
$language["AVATAR_URL"]="Avatarin osoite: ";
$language["AVERAGE"]="Keskinkertainen";
$language["BACK"]="Takaisin";
$language["BAD_ID"]="V&auml;&auml;r&auml; ID!";
$language["BCK_USERCP"]="Takaisin k&auml;ytt&auml;j&auml;paneeliin";
$language["BLOCK"]="Blokki";
$language["BODY"]="Runko";
$language["BOTTOM"]="Pohja";
$language["BY"]="Tehnyt";
$language["CANT_DELETE_ADMIN"]="Ei ole mahdollista poistaa toista adminia!";
$language["CANT_DELETE_NEWS"]="Sinulla ei ole oikeuksia poistaa uutisia!";
$language["CANT_DELETE_TORRENT"]="Sinulla ei ole oikeuksia poistaa t&auml;t&auml; torrenttia!...";
$language["CANT_DELETE_USER"]="Sinulla ei ole oikeuksia poistaa k&auml;ytt&auml;ji&auml;!";
$language["CANT_DO_QUERY"]="Ei voitu tehd&auml; SQL-kysely&auml; - ";
$language["CANT_EDIT_TORR"]="Sinulla ei ole oikeuksia muokata t&auml;t&auml; torrenttia!";
$language["CANT_FIND_TORRENT"]="Torrent-tiedostoa ei l&ouml;ydy!";
$language["CANT_READ_LANGUAGE"]="Kielitiedostoa ei voitu lukea!";
$language["CANT_SAVE_CONFIG"]="Ei voitu tallentaa asetuksia config.php";
$language["CANT_SAVE_LANGUAGE"]="Ei voitu tallentaa kielitiedostoa";
$language["CANT_WRITE_CONFIG"]="VAROITUS: Ei voitu kirjoittaa config.php!";
$language["CATCHUP"]="Merkitse kaikki luetuiksi";
$language["CATEGORY"]="Kat.";
$language["CATEGORY_FULL"]="Kategoria";
$language["CENTER"]="Keskell&auml;";
$language["CHANGE_PID"]="Vaihda PID";
$language["CHARACTERS"]="Merkit";
$language["CHOOSE"]="Valitse";
$language["CHOOSE_ONE"]="Valitse yksi";
$language["CLICK_HERE"]="Paina t&auml;st&auml;";
$language["CLOSE"]="Sulje";
$language["COMMENT"]="Kom.";
$language["COMMENT_1"]="Kommentti";
$language["COMMENT_PREVIEW"]="Kommentin esikatselu";
$language["COMMENTS"]="Kommentit";
$language["CONFIG_SAVED"]="Onneksi olkoon, Uudet asetukset tallennettiin";
$language["COUNTRY"]="Maa";
$language["CURRENT_DETAILS"]="T&auml;m&auml;nhetkiset tiedot";
$language["DATABASE_ERROR"]="Tietokantavirhe.";
$language["DATE"]="P&auml;iv&auml;m&auml;&auml;r&auml;";
$language["DB_ERROR_REQUEST"]="TIETOKANTAVIRHE. Ei voitu suorittaa pyydetty&auml; toimintoa.";
$language["DB_SETTINGS"]="Tietokanta-asetukset";
$language["DEAD_ONLY"]="Vain kuolleet";
$language["DELETE"]="Poista";
$language["DELETE_ALL_READED"]="Poista kaikki luetut";
$language["DELETE_CONFIRM"]="Oletko varma ett&auml; haluat poistaa/h&auml;vitt&auml;&auml; t&auml;m&auml;n?";
$language["DELETE_TORRENT"]="Poista Torrentti";
$language["DELFAILED"]="Poisto ep&auml;onnistui";
$language["DESCRIPTION"]="Kuvaus";
$language["DONT_NEED_CHANGE"]="Sinun ei tarvitse muuttaa n&auml;it&auml; asetuksia!";
$language["DOWN"]="Lat";
$language["DOWNLOAD"]="Lataa";
$language["DOWNLOAD_TORRENT"]="Lataa Torrentti";
$language["DOWNLOADED"]="Ladattu";
$language["EDIT"]="Muokkaa";
$language["EDIT_LANGUAGE"]="Muokkaa kielt&auml;";
$language["EDIT_POST"]="Muokkaa postausta";
$language["EDIT_TORRENT"]="Muokkaa torrentti";
$language["EMAIL"]="S&auml;hk&ouml;posti";
$language["EMAIL_SENT"]="S&auml;hk&ouml;posti l&auml;hetettiin annettuun osoitteeseen<br />Paina postin sis&auml;lt&auml;m&auml;&auml; linkki&auml; vahvistaaksesi tilisi.";
$language["EMAIL_VERIFY"]="email account update at $SITENAME";
$language["EMAIL_VERIFY_BLOCK"]="Vahvistusviesti l&auml;hetetty";
$language["EMAIL_VERIFY_MSG"]="Hello,\n\nT&auml;m&auml; maili l&auml;hettettiin koska olet pyyt&auml;nyt ett&auml; uusi s&auml;hk&ouml;postiosoite tallennetaan tietoihisi. Klikkaa allaolevaa linkki&auml; vahvistaaksesi muutoksen.\n\nYst&auml;v&auml;llisin terveisin Yll&auml;pito.";
$language["EMAIL_VERIFY_SENT1"]="<br /><center>Vahvistus maili on l&auml;hetetty :<br /><br /><strong><font color=\"red\">";
$language["EMAIL_VERIFY_SENT2"]="</font></strong><br /><br />Sinun pit&auml;&auml; painaa linkki&auml; joka on vahvistusviestiss&auml;<br />vahvistaaksesi uuden s&auml;hk&ouml;postiosoittesi. Mailin pit&auml;is tulla 10minuutin sis&auml;ll&auml;<br />(Yleens&auml; v&auml;litt&ouml;m&auml;sti). Osa s&auml;hk&ouml;postipalveluiden tarjoajista voi merkit&auml; viestin roskapostiksi,<br />joten muista katsoa my&ouml;s roskapostikansio!.<br /><br />";
$language["ERR_500"]="HTTP/1.0 500 Luvaton k&auml;ynti";
$language["ERR_AVATAR_EXT"]="Vain gif,jpg,bmp Tai png Sallittu";
$language["ERR_BAD_LAST_POST"]="viimeinen v&auml;&auml;r&auml; postaus";
$language["ERR_BAD_NEWS_ID"]="V&auml;&auml;r&auml; uutisten ID!";
$language["ERR_BODY_EMPTY"]="Runko ei voi olla tyhj&auml;!";
$language["ERR_CANT_CONNECT"]="Ei voitu yhdist&auml;&auml; paikalliseen MySQL-palvelimeen";
$language["ERR_CANT_OPEN_DB"]="Ei voitu avata tietokantaa";
$language["ERR_DB_ERR"]="Tietokantavirhe. Ota yhteys administratoriin asiasta .";
$language["ERR_DELETE_POST"]="Poista postaus. VARMISTUS: Olet poistamassa t&auml;t&auml; postausta. Click";
$language["ERR_DELETE_TOPIC"]="Poista Topikki. VARMISTUS: Olet poistamassa Topikkia. Click";
$language["ERR_EMAIL_ALREADY_EXISTS"]="T&auml;m&auml; s&auml;hk&ouml;postiosoite l&ouml;ytyy jo tietokannasta!";
$language["ERR_EMAIL_NOT_FOUND_1"]="T&auml;t&auml; s&auml;hk&ouml;postiosoitetta";
$language["ERR_EMAIL_NOT_FOUND_2"]="Ei l&ouml;ytynyt tietokannasta.";
$language["ERR_ENTER_NEW_TITLE"]="Sinun t&auml;ytyy antaa uusi otsikko!";
$language["ERR_FORUM_NOT_FOUND"]="Foorumia ei l&ouml;ytynyt";
$language["ERR_FORUM_UNKW_ACT"]="Foorumi Virhe: Tuntematon toiminto";
$language["ERR_GUEST_EXISTS"]="'Guest' On rajoitettu k&auml;ytt&auml;j&auml;. Et voi luoda tili&auml; k&auml;ytt&auml;j&auml;nimelle 'Guest'";
$language["ERR_IMAGE_CODE"]="Kuvakoodi v&auml;&auml;rin";
$language["ERR_INS_TITLE_NEWS"]="Sinun pit&auml;&auml; sy&ouml;tt&auml;&auml; sek&auml; otsikko ett&auml; uutiset";
$language["ERR_INV_NUM_FIELD"]="Invalid numerical field(s) from client";
$language["ERR_INVALID_CLIENT_EVENT"]="Tuntematon tapahtuma= asiakasohjelmalta.";
$language["ERR_INVALID_INFO_BT_CLIENT"]="Torrent-asiakasohjelmasi l&auml;hett&auml;&auml; virheellist&auml; tietoa.";
$language["ERR_INVALID_IP_NUMB"]="Virheellinen IP-osoite. Pit&auml;&auml; olla normaali pistein eroteltu numerosarja (hostit ei sallittu)";
$language["ERR_LEVEL"]="Anteeksi, Sinun arvosi ";
$language["ERR_LEVEL_CANT_POST"]="Sinulla ei ole oikeuksia kirjoittaa t&auml;lle foorumille.";
$language["ERR_LEVEL_CANT_VIEW"]="Sinulle ei ole oikeuksia lukea t&auml;t&auml; Postausta.";
$language["ERR_MISSING_DATA"]="Puuttuu tietoa!";
$language["ERR_MUST_BE_LOGGED_SHOUT"]="Sinun pit&auml;&auml; olla kirjautuneena sivulle jutellaksesi shoutboxissa...";
$language["ERR_NO_BODY"]="Ei runkoteksti&auml;";
$language["ERR_NO_NEWS_ID"]="Uutisten ID:t&auml; ei l&ouml;ytynyt!";
$language["ERR_NO_POST_WITH_ID"]="Ei postauksia t&auml;ll&auml; IDll&auml; ";
$language["ERR_NO_SPACE"]="K&auml;ytt&auml;j&auml;tunnus ei voi sis&auml;lt&auml;&auml; v&auml;lily&ouml;ntej&auml;.<br /><br />";
$language["ERR_NO_TOPIC_ID"]="Topikin ID:t&auml; ei palautettu";
$language["ERR_NO_TOPIC_POST_ID"]="Ei topikki mik&auml; liittyisi postaus IDhen";
$language["ERR_NOT_AUTH"]="Sinulla ei ole valtuuksia!";
$language["ERR_NOT_FOUND"]="Ei l&ouml;ytynyt...";
$language["ERR_NOT_PERMITED"]="EI SALLITTU";
$language["ERR_PASS_LENGTH"]="<font color=\"black\">Salasanan pit&auml;&auml; sis&auml;lt&auml;&auml; v&auml;hint&auml;&auml;n 4 merkki&auml;.</font>";
$language["ERR_PASSWORD_INCORRECT"]="Salasana V&Auml;&Auml;RIN";
$language["ERR_PERM_DENIED"]="Pyynt&ouml; ev&auml;tty";
$language["ERR_PID_NOT_FOUND"]="Lataa torrent uudelleen palvelimelta. T?m? .torrent ei sis&auml;lt&auml;nyt vaadittua PID-tunnusta";
$language["ERR_RETR_DATA"]="Virhe ker&auml;tt&auml;ess&auml; tietoa!";
$language["ERR_SEND_EMAIL"]="S&auml;hk&ouml;postia ei pystytty l&auml;hett&auml;m&auml;&auml;n. Ota yhteys administratoriin koskien t&auml;t&auml; virhett&auml;.";
$language["ERR_SERVER_LOAD"]="Palvelimen rasitus on korkea t&auml;ll&auml; hetkell&auml;. Yritet&auml;&auml;n uudelleen, Odota hetki...";
$language["ERR_SPECIAL_CHAR"]="<font color=\"black\">K&auml;ytt&auml;j&auml;nimesi ei voi sis&auml;lt&auml;&auml; erikoismerkkej&auml; kuten:<br /><br /><font color=\"red\"><strong>* ? < > @ $ & % etc.</strong></font></font><br />";
$language["ERR_SQL_ERR"]="SQL-Virhe";
$language["ERR_SUBJECT"]="Sinun pit&auml;&auml; antaa aihe.";
$language["ERR_TOPIC_ID_NA"]="Ei topikkia t&auml;ll&auml; ID:ll&auml;";
$language["ERR_TOPIC_LOCKED"]="Lukittu topic";
$language["ERR_TORRENT_IN_BROWSER"]="T&auml;m&auml; tiedosto on vain torrent-asiakasohjelmaa varten.";
$language["ERR_UPDATE_USER"]="K&auml;ytt&auml;j&auml;tietoja ei voitu p&auml;ivitt&auml;&auml;. Ota yhteys yll&auml;pitoon.";
$language["ERR_USER_ALREADY_EXISTS"]="T&auml;m&auml; tunnus on jo k&auml;yt&ouml;ss&auml;!";
$language["ERR_USER_NOT_FOUND"]="K&auml;ytt&auml;j&auml;&auml; ei l&ouml;ytynyt";
$language["ERR_USER_NOT_USER"]="Sinulla ei ole oikeuksia toisen k&auml;ytt&auml;j&auml;n paneeliin!";
$language["ERR_USERNAME_INCORRECT"]="K&auml;ytt&auml;j&auml;nimi v&auml;&auml;rin";
$language["ERROR"]="Virhe";
$language["ERROR_ID"]="Virheen ID";
$language["FACOLTATIVE"]="Vaihtoehtoinen";
$language["FILE"]="Tiedosto";
$language["FILE_CONTENTS"]="Tiedostojen sis&auml;lt&ouml;";
$language["FILE_NAME"]="Tiedostonimi";
$language["FIND_USER"]="Etsi k&auml;ytt&auml;j&auml;";
$language["FINISHED"]="Valmis";
$language["FORUM"]="Foorumi";
$language["FORUM_ERROR"]="Foorumi virhe";
$language["FORUM_INFO"]="Foorumin tiedot";
$language["FORUM_MIN_CREATE"]="Alin k&auml;ytt&auml;j&auml;luokka joka voi luoda";
$language["FORUM_MIN_READ"]="Alin k&auml;ytt&auml;j&auml;luokka joka voi lukea";
$language["FORUM_SEARCH"]="Foorumi haku";
$language["FORUM_N_TOPICS"]="N. Topikit";
$language["FORUM_N_POSTS"]="N. Postaukset";
$language["FRM_DELETE"]="Poista";
$language["FRM_LOGIN"]="Kirjaudu";
$language["FRM_PREVIEW"]="Esikatselu";
$language["FRM_REFRESH"]="P&auml;ivit&auml;";
$language["FRM_RESET"]="Resetoi";
$language["FRM_SEND"]="L&auml;het&auml;";
$language["FRM_CONFIRM"]="Vahvista";
$language["FRM_CANCEL"]="Peruuta";
$language["FRM_CLEAN"]="Tyhjenn&auml;";
$language["GLOBAL_SERVER_LOAD"]="Palvelimen kokonaiskuormitus (KAIKKI mik&auml; py&ouml;rii serverill&auml;)";
$language["GO"]="Mene";
$language["GROUP"]="Ryhm&auml;";
$language["GUEST"]="Vieras";
$language["GUESTS"]="Vieraat";
$language["HERE"]="T&auml;nne";
$language["HISTORY"]="Historia";
$language["HOME"]="Koti";
$language["IF_YOU_ARE_SURE"]="Jos olet varma.";
$language["IM_SURE"]="Olen varma";
$language["IN"]="in";
$language["INF_CHANGED"]="Tiedot p&auml;ivitetty!";
$language["INFINITE"]="Lop.";
$language["INFO_HASH"]="Info Hash";
$language["INS_NEW_PWD"]="Sy&ouml;t&auml; UUSI salasana!";
$language["INS_OLD_PWD"]="Sy&ouml;t&auml; VANHA salasana!";
$language["INSERT_DATA"]="Anna kaikki tarvittava tieto l&auml;hett&auml;mist&auml; varten.";
$language["INSERT_NEW_FORUM"]="Lis&auml;&auml; uusi foorumi";
$language["INVALID_ID"]="Virheellinen ID. Sori!";
$language["INVALID_INFO_HASH"]="Invalid info hash value.";
$language["INVALID_PID"]="HUONO PID";
$language["INVALID_TORRENT"]="Trakkerin virhe: Ep&auml;kelpo  torrentti";
$language["KEYWORDS"]="Avainsanat";
$language["LAST_EXTERNAL"]="Viimeisimm&auml;n ulkoisen torrentin p&auml;ivitys tehty ";
$language["LAST_NEWS"]="Viimeisimm&auml;t uutiset";
$language["LAST_POST_BY"]="Viimeisen postauksen tehnyt";
$language["LAST_SANITY"]="Viimeisin Sanity Tarkastus on tehty ";
$language["LAST_TORRENTS"]="Uusimmat torrentit";
$language["LAST_UPDATE"]="Viimeisin p&auml;ivitys";
$language["LASTPOST"]="Viimeisin postaus";
$language["LEECHERS"]="Lataajat";
$language["LEFT"]="Vasen";
$language["LOGIN"]="Kirjaudu sis&auml;&auml;n";
$language["LOGOUT"]="Kirjaudu ulos";
$language["MAILBOX"]="Viestilaatikko";
$language["MANAGE_NEWS"]="Hallitse uutisia";
$language["MEMBER"]="K&auml;ytt&auml;j&auml;";
$language["MEMBERS"]="K&auml;ytt&auml;j&auml;t";
$language["MEMBERS_LIST"]="K&auml;ytt&auml;j&auml;luettelo";
$language["MINIMUM_100_DOWN"]="(V&auml;hint&auml;&auml;n 100 MB ladattu)";
$language["MINIMUM_5_LEECH"]="V&auml;hint&auml;&auml;n 5 Lataajaa, Kuolleita torrentteja ei laskettu";
$language["MINIMUM_5_SEED"]="V&auml;hint&auml;&auml;n 5 l&auml;hett&auml;j&auml;&auml;";
$language["MKTOR_INVALID_HASH"]="makeTorrent: Received an invalid hash";
$language["MNU_ADMINCP"]="Staff Paneeli";
$language["MNU_FORUM"]="Foorumi";
$language["MNU_INDEX"]="Etusivu";
$language["MNU_MEMBERS"]="J&auml;senet";
$language["MNU_NEWS"]="Uutiset";
$language["MNU_STATS"]="Extra tiedot";
$language["MNU_TORRENT"]="Torrentit";
$language["MNU_UCP_CHANGEPWD"]="Vaihda salasana";
$language["MNU_UCP_HOME"]="Omat tiedot";
$language["MNU_UCP_IN"]="Saapuneet viestit";
$language["MNU_UCP_INFO"]="Muokkaa profiilia";
$language["MNU_UCP_NEWPM"]="Uusi Viesti";
$language["MNU_UCP_OUT"]="L&auml;hetetyt viestit";
$language["MNU_UCP_PM"]="Saapuneet viestit";
$language["MNU_UPLOAD"]="Julkaise";
$language["MORE_SMILES"]="Lis&auml;&auml; hymi&ouml;it&auml;";
$language["MORE_THAN"]="Enemm&auml;n kuin ";
$language["MORE_THAN_2"]="L&ouml;ytyi useita, N&auml;yt&auml; ensin";
$language["NA"]="N/A";
$language["NAME"]="Nimi";
$language["NEED_COOKIES"]="HUOMIO: Ev&auml;steiden pit&auml;&auml; olla sallittu selaimesta jotta voit kirjautua.";
$language["NEW_COMMENT"]="Lis&auml;&auml; kommenttisi...";
$language["NEW_COMMENT_T"]="Uusi kommentti";
$language["NEWS"]="Uutiset";
$language["NEWS_DESCRIPTION"]="Uutiset:";
$language["NEWS_INSERT"]="Lis&auml;&auml; uutiset";
$language["NEWS_PANEL"]="Uutisten paneeli";
$language["NEWS_TITLE"]="Aihe:";
$language["NEXT"]="Seuraava";
$language["NO"]="Ei";
$language["NO_BANNED_IPS"]="Ei ole bannattuja IP osoitteita";
$language["NO_COMMENTS"]="Ei kommentteja...";
$language["NO_FORUMS"]="Foorumeita ei l&ouml;ytynyt!";
$language["NO_MAIL"]="Ei uusia s&auml;hk&ouml;posteja.";
$language["NO_MESSAGES"]="Viestej&auml; ei l&ouml;ytynyt...";
$language["NO_NEWS"]="Ei uutisia";
$language["NO_PEERS"]="Ei yhteyksi&auml;";
$language["NO_RECORDS"]="Sori, lista on tyhj&auml;...";
$language["NO_TOPIC"]="Topikkeja ei l&ouml;ytynyt";
$language["NO_TORR_UP_USER"]="T&auml;m&auml; k&auml;ytt&auml;j&auml; ei ole julkaissut yht&auml;&auml;n torrenttia";
$language["NO_TORRENTS"]="T&auml;&auml;ll&auml; ei ole torrentteja...";
$language["NO_USERS_FOUND"]="Yht&auml;&auml;n k&auml;ytt&auml;j&auml;&auml; ei l&ouml;ytynyt!";
$language["NOBODY_ONLINE"]="Ket&auml;&auml;n ei ole kirjautuneena";
$language["NONE"]="None";
$language["NOT_ADMIN_CP_ACCESS"]="Sinulla ei ole oikeuksia Staff paneeliin!";
$language["NOT_ALLOW_DOWN"]="Ei ole sallittua ladata kohteesta";
$language["NOT_AUTH_DOWNLOAD"]="Sinulla ei ole t&auml;ll&auml; hetkell&auml; latausoikeuksia. Sori...";
$language["NOT_AUTH_VIEW_NEWS"]="Sinulla ei ole oikeuksia n&auml;hd&auml; uutisia!";
$language["NOT_AUTHORIZED"]="Sinulla ei ole oikeuksia n&auml;hd&auml;";
$language["NOT_AUTHORIZED_UPLOAD"]="Sinulla ei ole oikeuksia julkaista!";
$language["NOT_AVAILABLE"]="N/A";
$language["NOT_MAIL_IN_URL"]="Virheellinen s&auml;hk&ouml;postiosoite.";
$language["NOT_POSS_RESET_PID"]="Ei ole mahdollista vaihtaa PID-tunnusta itse! <br />Ota yhteys yll&auml;pitoon...";
$language["NOW_LOGIN"]="Nyt sinut ohjataan kirjautumiseen";
$language["NUMBER_SHORT"]="#";
$language["OLD_PWD"]="Vanha salasana";
$language["ONLY_REG_COMMENT"]="VAin rekister&ouml;idyt k&auml;ytt&auml;j&auml;t voivat kommentoida!";
$language["OPT_DB_RES"]="Optimizing database result";
$language["OPTION"]="Vaihtoehto";
$language["PASS_RESET_CONF"]="Salasanan resetoimisen varmistus";
$language["PEER_CLIENT"]="Clientti";
$language["PEER_COUNTRY"]="Maa";
$language["PEER_ID"]="Yhteys ID";
$language["PEER_LIST"]="Yhteyksien lista";
$language["PEER_PORT"]="Portti";
$language["PEER_PROGRESS"]="Edistyminen";
$language["PEER_STATUS"]="Tila";
$language["PEERS"]="Yhteydet";
$language["PEERS_DETAILS"]="Paina t&auml;st&auml; katsoaksesi yhteyksien lis&auml;tiedot";
$language["PICTURE"]="Kuva";
$language["PID"]="PID";
$language["PLEASE_WAIT"]="Odota hetki...";
$language["PM"]="Yksityisviesti";
$language["POSITION"]="Paikka";
$language["POST_REPLY"]="Postauksen vastaus";
$language["POSTED_BY"]="Postauksen tehnyt";
$language["POSTED_DATE"]="POstattu";
$language["POSTS"]="Postaukset";
$language["POSTS_PER_DAY"]="%s Postauksia p&auml;iv&auml;ss&auml;";
$language["POSTS_PER_PAGE"]="Postauksia per sivu";
$language["PREVIOUS"]="Edellinen.";
$language["PRIVATE_MSG"]="Yksityisviesti";
$language["PWD_CHANGED"]="Salasana vaihdettu!";
$language["QUESTION"]="Kysymys";
$language["QUICK_JUMP"]="Hypp&auml;&auml;";
$language["QUOTE"]="Lainaa";
$language["RANK"]="Arvo";
$language["RATIO"]="Ratio";
$language["REACHED_MAX_USERS"]="Maksimi k&auml;ytt&auml;j&auml;m&auml;&auml;r&auml; saavutettu";
$language["READED"]="Lue";
$language["RECEIVER"]="Vastaanottaja";
$language["RECOVER_DESC"]="T&auml;yt&auml; alapuolella oleva kaavake, jotta salasanasi ja k&auml;ytt&auml;j&auml;tietosi muutetaan ja mailataan takaisin sinulle.<br />(Sinun t&auml;ytyy vastata vahvistusmailiin.)";
$language["RECOVER_PWD"]="Palauta salasana";
$language["RECOVER_TITLE"]="Palauta kadonnut salasana tai k&auml;ytt&auml;j&auml;nimi";
$language["REDIRECT"]="Jos ei selaimesi tue javascripti&auml; , Paina";
$language["REDOWNLOAD_TORR_FROM"]="Uudelleen lataa torrentti osoitteesta";
$language["REGISTERED"]="Kirjautuneena";
$language["REGISTERED_EMAIL"]="Rekister&ouml;ity s&auml;hk&ouml;posti";
$language["REMOVE"]="Poista";
$language["REPLIES"]="Vastaukset";
$language["REPLY"]="Vastaa";
$language["RESULT"]="Tulokset";
$language["RETRY"]="Yrit&auml; uudelleen";
$language["RETURN_TORRENTS"]="Takaisin torrent-listaan";
$language["REVERIFY_CONGRATS1"]="<center><br />Onneks olkoon, Nyt s&auml;hk&ouml;postiosoitteesi on vahvistettu ja vaihdettu<br /><br /><strong>From: <font color=\"red\">";
$language["REVERIFY_CONGRATS2"]="</strong></font><br /><strong>To: <font color=\"red\">";
$language["REVERIFY_CONGRATS3"]="</strong></font><br /><br />";
$language["REVERIFY_FAILURE"]="<center><br /><strong><font color=\"red\"><u>Sori mutta t&auml;m&auml; URL on ep&auml;kelpo</u></strong></font><br /><br />Uusi satunnainen numerosarja luodaan joka kerta kun yrit&auml;t vaihtaa s&auml;hk&ouml;postiosoitteen joten<br />Jos n&auml;et t&auml;m&auml;n viestin niin yritit vaihtaa s&auml;hk&ouml;postisi todenn&auml;k&ouml;isesti<br />Enemm&auml;n kuin kerran ja k&auml;yt&auml;t vanhaa URLia.<br /><br /><strong>Odota siihen saakka ett&auml; olet ihan varma ettet ole saanut uutta<br />Vahvistusmailia ennen kuin yrit&auml;t uudelleen.</strong><br /><br />";
$language["REVERIFY_MSG"]="Jos yrit&auml;t vaihtaa s&auml;hk&ouml;postiosoitteen, uuteen osoitteeseen l&auml;hetet&auml;&auml;n vahvistusviesti.<br /><br /><font color=\"red\"><strong>Uusi s&auml;hk&ouml;postiosoite ei p&auml;ivity ennen kuin olet vahvistanut sen vahvistusviestist&auml;.</strong></font>";
$language["RIGHT"]="Oikea";
$language["SEARCH"]="Etsi";
$language["SEEDERS"]="Jakajat";
$language["SEEN"]="N&auml;hty";
$language["SELECT"]="Valitse...";
$language["SENDER"]="L&auml;hett&auml;j&auml;";
$language["SENT_ERROR"]="L&auml;hetys virhe";
$language["SHORT_C"]="Val"; //Shortname for Completed
$language["SHORT_L"]="Lat"; //Shortname for Leechers
$language["SHORT_S"]="L&auml;h"; //Shortname for Seeders
$language["SHOUTBOX"]="Huutolaatikko";
$language["SIZE"]="Koko";
$language["SORRY"]="Sori";
$language["SORTID"]="J&auml;rjest&auml; ID";
$language["SPEED"]="Nopeus";
$language["STICKY"]="Sticky";
$language["SUB_CATEGORY"]="Alakategoria";
$language["SUBJECT"]="Aihe";
$language["SUBJECT_MAX_CHAR"]="Aihe on rajattu ";
$language["SUC_POST_SUC_EDIT"]="Postausta muokattu onnistuneesti.";
$language["SUC_SEND_EMAIL"]="Vahvistusmaili l&auml;hetty";
$language["SUC_SEND_EMAIL_2"]="Odota hetki jotta vahvistusviesti saapuu.";
$language["SUCCESS"]="Onnistui";
$language["SUMADD_BUG"]="Tracker bug calling summaryAdd";
$language["TABLE_NAME"]="Table Name";
$language["TIMEZONE"]="Aikavy&ouml;hyke";
$language["TITLE"]="Otsikko";
$language["TOP"]="Parhaat";
$language["TOP_10_ACTIVE"]="10 Aktiivisinta Torrenttia";
$language["TOP_10_BEST_SEED"]="10 Torrentin parasta jakajaa";
$language["TOP_10_BSPEED"]="10 Torrenttia paras nopeus";
$language["TOP_10_DOWNLOAD"]="10 parasta lataajaa";
$language["TOP_10_SHARE"]="10 Parasta jakajaa";
$language["TOP_10_UPLOAD"]="10 Parasta julkaisijaa";
$language["TOP_10_WORST"]="10 Huonointa jakajaa";
$language["TOP_10_WORST_SEED"]="10 Torrentin huonointa jakajaa";
$language["TOP_10_WSPEED"]="10 Torrentin huonointa nopeutta";
$language["TOP_TORRENTS"]="Suosituimmat torrentit";
$language["TOPIC"]="Topikki";
$language["TOPICS"]="Topikit";
$language["TOPICS_PER_PAGE"]="Topikkia per sivu";
$language["TORR_PEER_DETAILS"]="Torrentin yhteyksien tiedot";
$language["TORRENT"]="Torrentti";
$language["TORRENT_ANONYMOUS"]="L&auml;het&auml; tuntemattomana";
$language["TORRENT_CHECK"]="Salli trakkerin hakea ja k&auml;ytt&auml;&auml; tietoja torrentista.";
$language["TORRENT_DETAIL"]="Torrentin tiedot";
$language["TORRENT_FILE"]="Torrent-tiedosto";
$language["TORRENT_SEARCH"]="Etsi Torrentteja";
$language["TORRENT_STATUS"]="Tila";
$language["TORRENT_UPDATE"]="P&auml;ivitet&auml;&auml;n, Odota hetki...";
$language["TORRENTS"]="torrentit";
$language["TORRENTS_PER_PAGE"]="Torrenttia per sivu";
$language["TRACK_DB_ERR"]="Trakkerin/Tietokannan virhe. Tiedot ovat virhelogissa.";
$language["TRACKER_INFO"]="$users users, tracking $torrents torrents ($seeds seeds e $leechers leechers, $percent%)";
$language["TRACKER_LOAD"]="Trakkerin kuorma";
$language["TRACKER_SETTINGS"]="Trakkerin asetukset";
$language["TRACKER_STATS"]="Trakkerin tilastot";
$language["TRACKING"]="Seuraus/tracking";
$language["TRAFFIC"]="Liikenne";
$language["UCP_NOTE_1"]="T&auml;&auml;ll&auml; voit hallita saapuneita viestej&auml;, l&auml;hett&auml;&auml; viestej&auml; muille,";
$language["UCP_NOTE_2"]="sek&auml; muokata henkil&ouml;kohtaisia asetuksiasi.";
$language["UNAUTH_IP"]="Ei hyv&auml;ksytty IP-osoite.";
$language["UNKNOWN"]="Tuntematon";
$language["UPDATE"]="P&auml;ivit&auml;";
$language["UPFAILED"]="L&auml;hett&auml;minen ep&auml;onnistui";
$language["UPLOAD_IMAGE"]="L&auml;het&auml; kuva";
$language["UPLOAD_LANGUAGE_FILE"]="Lis&auml;&auml; kielitiedosto";
$language["UPLOADED"]="Julkaissut";
$language["UPLOADER"]="Julkaisija";
$language["UPLOADS"]="Julkaisut";
$language["URL"]="Linkki";
$language["USER_CP"]="Minun paneeli";
$language["USER_CP_1"]="K&auml;ytt&auml;j&auml;n hallintapaneeli";
$language["USER_DETAILS"]="K&auml;ytt&auml;j&auml; tiedot";
$language["USER_EMAIL"]="Hyv&auml;ksytty s&auml;hk&ouml;posti";
$language["USER_ID"]="K&auml;ytt&auml;j&auml;  ID";
$language["USER_JOINED"]="Liittynyt";
$language["USER_LASTACCESS"]="Viimeksi n&auml;hty";
$language["USER_LEVEL"]="Arvo";
$language["USER_LOCAL_TIME"]="K&auml;ytt&auml;j&auml;n paikallinen aika";
$language["USER_NAME"]="K&auml;ytt&auml;j&auml;nimi";
$language["USER_PASS_RECOVER"]="salasanan/k&auml;ytt&auml;j&auml;nimen palautus";
$language["USER_PWD"]="Salasana";
$language["USERS_SEARCH"]="K&auml;ytt&auml;j&auml;haku";
$language["VIEW_DETAILS"]="N&auml;hd&auml; tiedot";
$language["VIEW_TOPIC"]="N&auml;yt&auml; toppikki";
$language["VIEW_UNREAD"]="Katso lukemattomat";
$language["VIEWS"]="Katsottu";
$language["VISITOR"]="Vieraita";
$language["VISITORS"]="Vieraat";
$language["WAIT_ADMIN_VALID"]="Sinun pit&auml;&auml; odottaa yll&auml;pidon hyv&auml;ksynt&auml;&auml;...";
$language["WARNING"]="VAROITUS!";
$language["WELCOME"]="Tervetuloa";
$language["WELCOME_ADMINCP"]="Tervetuloa Staff paneeliin";
$language["WELCOME_BACK"]="Tervetuloa takaisin";
$language["WELCOME_UCP"]="Tervetuloa minun paneeliin ";
$language["WORD_AND"]="ja";
$language["WORD_NEW"]="Uusi";
$language["WROTE"]="Kirjoitti";
$language["WT"]="WT";
$language["X_TIMES"]="Kertaa";
$language["YES"]="Kyll&auml;";
$language["LAST_IP"]="Viimeisin IP";
$language["FIRST_UNREAD"]="Hypp&auml;&auml; ensimm&auml;iseen lukemattomaan postaukseen";
$language["MODULE_UNACTIVE"]="Vaadittu Moduuli ei ole aktiivinen!";
$language["MODULE_NOT_PRESENT"]="Vaadittua Moduulia ei ole olemassa!";
$language["MODULE_LOAD_ERROR"]="Vaadittu Moduuli on v&auml;&auml;r&auml;!";
?>