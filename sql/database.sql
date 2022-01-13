--
-- DT FM V20.0 DE 10/02/2015
--

--- needed drop !!
--
DROP TABLE IF EXISTS `{$db_prefix}addedexpected`;
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}addedexpected`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}addedexpected` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `expectid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pollid` (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}addedexpectedmin`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}addedexpectedmin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `expectid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pollid` (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}addedrequests`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}addedrequests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `requestid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pollid` (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}ajax_ratings`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}ajax_ratings` (
  `id` varchar(40) NOT NULL,
  `total_votes` int(11) NOT NULL,
  `total_value` int(11) NOT NULL,
  `used_ips` longtext
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}announcement`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}announcement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `body` text NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `added` (`added`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}anti_hit_run`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}anti_hit_run` (
  `id_level` int(11) NOT NULL DEFAULT '0',
  `min_download_size` bigint(20) NOT NULL DEFAULT '0',
  `min_ratio` float NOT NULL DEFAULT '0',
  `min_seed_hours` int(11) NOT NULL DEFAULT '0',
  `tolerance_days_before_punishment` int(11) NOT NULL DEFAULT '0',
  `upload_punishment` int(11) NOT NULL DEFAULT '0',
  `reward` enum('no','yes') NOT NULL DEFAULT 'no',
  `warn` enum('no','yes') NOT NULL DEFAULT 'no',
  `boot` enum('no','yes') NOT NULL DEFAULT 'no',
  `warnboot` enum('no','yes') NOT NULL DEFAULT 'no',
  `days1` int(11) NOT NULL DEFAULT '2',
  `days2` int(11) NOT NULL DEFAULT '2',
  `days3` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id_level`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}anti_hit_run_tasks`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}anti_hit_run_tasks` (
  `task` varchar(20) NOT NULL DEFAULT '',
  `last_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`last_time`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}anti_hit_run_tasks`
--

INSERT INTO `{$db_prefix}anti_hit_run_tasks` (`task`, `last_time`) VALUES
('sanity', 1350479473);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}avps`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}avps` (
  `arg` varchar(32) NOT NULL,
  `value_s` varchar(32) NOT NULL,
  `value_i` varchar(32) NOT NULL,
  `value_u` varchar(32) NOT NULL
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}avps`
--

INSERT INTO `{$db_prefix}avps` (`arg`, `value_s`, `value_i`, `value_u`) VALUES
('happyhour', '2012-10-18 21:52', '1', '0');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}bannedclient`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}bannedclient` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `peer_id` varchar(16) NOT NULL,
  `peer_id_ascii` varchar(8) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `peer_id` (`peer_id`),
  KEY `peer_id_ascii` (`peer_id_ascii`),
  KEY `user_agent` (`user_agent`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}bannedip`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}bannedip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `added` int(11) NOT NULL DEFAULT '0',
  `addedby` int(10) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(255) NOT NULL DEFAULT '',
  `first` bigint(11) unsigned DEFAULT NULL,
  `last` bigint(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `first_last` (`first`,`last`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}blackjack`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}blackjack` (
  `gameid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `dealerhand` varchar(100) NOT NULL,
  `playerhand` varchar(100) NOT NULL,
  `remaining_cards` text NOT NULL,
  `playerbust` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`gameid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}blacklist`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}blacklist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tip` int(11) unsigned DEFAULT NULL,
  `added` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}blacklist`
--

INSERT INTO `{$db_prefix}blacklist` (`id`, `tip`, `added`) VALUES
(6, 976776306, 1257083025),
(7, 2498359063, 1257083037),
(8, 1023052757, 1257083050),
(9, 2000584742, 1257083066),
(10, 3567665164, 1257083077),
(11, 3204339155, 1257083094),
(12, 1034746206, 1257083103),
(13, 3395426162, 1257083111),
(14, 3421822211, 1257083120),
(15, 3689566569, 1257083127),
(16, 2078898596, 1257083134),
(17, 3395426164, 1257083143),
(18, 3547576622, 1257083153),
(19, 2061525333, 1257083167),
(20, 1052061298, 1257083178),
(21, 3194408496, 1257083187),
(22, 3708274050, 1257083198),
(23, 2928568377, 1257083208),
(24, 1034744940, 1257083218),
(25, 1034746208, 1257083223),
(26, 3366868419, 1257083229),
(27, 1426060820, 1257083236),
(28, 2001086565, 1257083244),
(29, 3567665162, 1257083249),
(30, 2498359064, 1257083255),
(31, 2928548041, 1257083262),
(32, 1007477713, 1257083598),
(33, 3359736065, 1257083608),
(34, 1994174415, 1257083618),
(35, 3359736066, 1257083625),
(36, 3658408901, 1257083634),
(37, 3657743810, 1257083641),
(38, 3645257889, 1257083651),
(39, 2001086566, 1257083658),
(40, 3585377159, 1257083666),
(41, 3179253574, 1257083673),
(42, 3366868417, 1257083682),
(43, 3547576618, 1257083687),
(44, 3138449970, 1257083693),
(45, 3547576620, 1257083698),
(46, 3395493147, 1257083704);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}blocks`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}blocks` (
  `blockid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL DEFAULT '',
  `position` char(1) NOT NULL DEFAULT '',
  `sortid` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `cache` enum('yes','no') NOT NULL,
  `minclassview` int(11) NOT NULL DEFAULT '0',
  `maxclassview` int(11) NOT NULL DEFAULT '8',
  PRIMARY KEY (`blockid`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}blocks`
--

INSERT INTO `{$db_prefix}blocks` (`blockid`, `content`, `position`, `sortid`, `status`, `title`, `cache`, `minclassview`, `maxclassview`) VALUES
(1, 'menu', 'r', 5, 0, 'BLOCK_MENU', 'no', 3, 8),
(2, 'clock', 'r', 15, 1, 'BLOCK_CLOCK', 'no', 3, 8),
(3, 'forum', 'l', 4, 1, 'BLOCK_FORUM', 'no', 3, 8),
(4, 'lastmember', 'l', 2, 1, 'BLOCK_LASTMEMBER', 'no', 3, 8),
(5, 'fluff', 't', 3, 1, '', 'no', 3, 8),
(6, 'trackerinfo', 'l', 7, 1, 'BLOCK_INFO', 'no', 3, 8),
(7, 'user', 'r', 4, 1, 'BLOCK_USER', 'no', 3, 8),
(8, 'online', 'b', 0, 1, 'BLOCK_ONLINE', 'no', 3, 8),
(11, 'lasttorrents', 'c', 4, 1, 'BLOCK_LASTTORRENTS', 'no', 3, 8),
(12, 'news', 'c', 1, 1, 'BLOCK_NEWS', 'no', 1, 8),
(13, 'mainmenu', 'e', 1, 1, 'BLOCK_MAINMENU', 'no', 1, 8),
(14, 'maintrackertoolbar', 't', 2, 1, 'BLOCK_MAINTRACKERTOOLBAR', 'no', 3, 8),
(15, 'mainusertoolbar', 't', 2, 1, 'BLOCK_MAINUSERTOOLBAR', 'no', 1, 8),
(16, 'serverload', 'c', 8, 0, 'BLOCK_SERVERLOAD', 'no', 8, 8),
(17, 'poller', 'l', 6, 1, 'BLOCK_POLL', 'no', 3, 8),
(19, 'paypal', 'r', 1, 1, 'BLOCK_PAYPAL', 'no', 3, 8),
(20, 'ajax_shoutbox', 'c', 2, 1, 'BLOCK_SHOUTBOX', 'no', 3, 8),
(21, 'dropdownmenu', 'd', 1, 1, 'BLOCK_DDMENU', 'no', 1, 8),
(22, 'request', 'c', 7, 1, 'BLOCK_REQUEST', 'no', 3, 8),
(40, 'event', 'r', 9, 1, 'BLOCK_EVENT', 'no', 3, 8),
(76, 'hit_run', 'l', 12, 1, 'BLOCK_HIT', 'no', 3, 8),
(124, 'topup', 'l', 1, 1, 'BLOCK_TOPU', 'no', 3, 8),
(125, 'lastflashtorrents', 'c', 0, 1, 'BLOCK_FEATURED', 'yes', 3, 8),
(126, 'admin', 'l', 0, 1, 'BLOCK_ADMIN', 'no', 6, 8),
(127, 'lrb', 'r', 6, 1, 'BLOCK_WARN', 'no', 3, 8),
(128, 'lottery', 'r', 10, 1, 'BLOCK_LOTTERY', 'yes', 2, 8),
(129, 'client', 'l', 8, 1, 'CLIENT', 'no', 3, 8),
(130, 'blackjack', 'r', 11, 1, 'BLACKJACK_STATS', 'yes', 3, 8),
(131, 'comments', 'l', 5, 1, 'LC', 'yes', 3, 8),
(132, 'arcade', 'l', 3, 1, 'ARCADE', 'no', 3, 8),
(133, 'featured', 'c', 0, 1, 'BLOCK_FEATUREDD', 'no', 3, 8),
(143, 'led', 'c', 10, 1, 'Ticker', 'no', 3, 8),
(144, 'opensignups', 'c', 0, 1, 'DIV_BLOCK', 'no', 1, 1),
(145, 'recommended', 'c', 8, 1, 'REC_BLOCK', 'no', 3, 8),
(146, 'categories', 'r', 14, 1, 'BLOCK_CAT', 'no', 3, 8),
(148, 'last', 'c', 1, 1, 'BLOCK_UPDO', 'no', 3, 8),
(150, 'search', 'c', 1, 1, 'BLOCK_SEARCH', 'no', 3, 8),
(151, 'mp3', 'r', 2, 0, 'MP', 'no', 3, 8);
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}bonus`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}bonus` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `points` decimal(4,1) NOT NULL DEFAULT '0.0',
  `traffic` bigint(20) unsigned NOT NULL DEFAULT '0',
  `gb` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}bonus`
--

INSERT INTO `{$db_prefix}bonus` (`id`, `name`, `points`, `traffic`, `gb`) VALUES
(3, '1', 30.0, 1073741824, 1),
(4, '2', 50.0, 2147483648, 2),
(5, '3', 100.0, 5368709120, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}bots`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}bots` (
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `visit` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM;

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `{$db_prefix}bugs`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}bugs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sender` int(10) NOT NULL DEFAULT '0',
  `added` int(12) NOT NULL DEFAULT '0',
  `priority` enum('low','high','veryhigh') NOT NULL DEFAULT 'low',
  `problem` text NOT NULL,
  `status` enum('fixed','ignored','na') NOT NULL DEFAULT 'na',
  `staff` int(10) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}bt_clients`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}bt_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `link` text NOT NULL,
  `sort` tinyint(10) NOT NULL DEFAULT '0',
  `image` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}bt_clients`
--

INSERT INTO `{$db_prefix}bt_clients` (`id`, `name`, `link`, `sort`, `image`) VALUES
(1, 'Firefox', 'http://www.mozilla.org/', 1, 'firefox.png'),
(2, 'µTorrent ', 'http://www.utorrent.com/', 2, 'utorrent.png'),
(3, 'Vuze', 'http://azureus.sourceforge.net/', 3, 'azureus.png');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}categories`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `sub` int(10) NOT NULL DEFAULT '0',
  `sort_index` int(10) unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL DEFAULT '',
  `forumid` int(10) DEFAULT NULL,
  `porn` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}categories`
--

INSERT INTO `{$db_prefix}categories` (`id`, `name`, `sub`, `sort_index`, `image`, `forumid`,`porn`) VALUES
(7, 'Apps Win', 0, 1010, 'appswindt.png', NULL,'no'),
(6, 'Books', 0, 110, 'booksdt.png', NULL,'no'),
(5, 'Anime', 0, 90, 'animedt.png', NULL,'no'),
(4, 'Other', 0, 1000, 'otherdt.png', NULL,'no'),
(3, 'Games', 0, 40, 'gamesdt.png', NULL,'no'),
(2, 'Music', 0, 20, 'musicdt.png', NULL,'no'),
(1, 'Movies', 0, 10, 'x264dt.png', NULL,'no'),
(8, 'Apps Linux', 0, 1020, 'appslinuxdt.png', NULL,'no'),
(9, 'Apps Mac', 0, 1030, 'appsmacdt.png', NULL,'no'),
(11, 'DVD-R', 1, 0, 'dvdrdt.png', NULL,'no'),
(12, 'Adult', 0, 6969, 'adultdt.png', NULL,'yes');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}categories_perm`
--

CREATE TABLE IF NOT EXISTS  `{$db_prefix}categories_perm` (
`catid` INT( 10 ) NOT NULL ,
`levelid` INT( 11 ) NOT NULL ,
`viewcat` ENUM( 'yes', 'no' ) NOT NULL DEFAULT 'yes' ,
`viewtorrlist` ENUM( 'yes', 'no' ) NOT NULL DEFAULT 'yes' ,
`viewtorrdet` ENUM( 'yes', 'no' ) NOT NULL DEFAULT 'yes' ,
`downtorr` ENUM( 'yes', 'no' ) NOT NULL DEFAULT 'yes' ,
`ratio` FLOAT NOT NULL
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}categories_perm`
--

INSERT INTO `{$db_prefix}categories_perm` (`catid`, `levelid`, `viewcat`, `viewtorrlist`, `viewtorrdet`, `downtorr`, `ratio`) VALUES
(1, 10, 'no', 'no', 'no', 'no', 0),
(1, 9, 'no', 'no', 'no', 'no', 0),
(1, 8, 'yes', 'yes', 'yes', 'yes', 0),
(1, 7, 'yes', 'yes', 'yes', 'yes', 0),
(1, 6, 'yes', 'yes', 'yes', 'yes', 0),
(1, 5, 'yes', 'yes', 'yes', 'yes', 0),
(1, 4, 'yes', 'yes', 'yes', 'yes', 0),
(1, 3, 'yes', 'yes', 'yes', 'yes', 0),
(1, 2, 'no', 'no', 'no', 'no', 0),
(1, 1, 'no', 'no', 'no', 'no', 0),

(2, 10, 'no', 'no', 'no', 'no', 0),
(2, 9, 'no', 'no', 'no', 'no', 0),
(2, 8, 'yes', 'yes', 'yes', 'yes', 0),
(2, 7, 'yes', 'yes', 'yes', 'yes', 0),
(2, 6, 'yes', 'yes', 'yes', 'yes', 0),
(2, 5, 'yes', 'yes', 'yes', 'yes', 0),
(2, 4, 'yes', 'yes', 'yes', 'yes', 0),
(2, 3, 'yes', 'yes', 'yes', 'yes', 0),
(2, 2, 'no', 'no', 'no', 'no', 0),
(2, 1, 'no', 'no', 'no', 'no', 0),

(3, 10, 'no', 'no', 'no', 'no', 0),
(3, 9, 'no', 'no', 'no', 'no', 0),
(3, 8, 'yes', 'yes', 'yes', 'yes', 0),
(3, 7, 'yes', 'yes', 'yes', 'yes', 0),
(3, 6, 'yes', 'yes', 'yes', 'yes', 0),
(3, 5, 'yes', 'yes', 'yes', 'yes', 0),
(3, 4, 'yes', 'yes', 'yes', 'yes', 0),
(3, 3, 'yes', 'yes', 'yes', 'yes', 0),
(3, 2, 'no', 'no', 'no', 'no', 0),
(3, 1, 'no', 'no', 'no', 'no', 0),

(4, 10, 'no', 'no', 'no', 'no', 0),
(4, 9, 'no', 'no', 'no', 'no', 0),
(4, 8, 'yes', 'yes', 'yes', 'yes', 0),
(4, 7, 'yes', 'yes', 'yes', 'yes', 0),
(4, 6, 'yes', 'yes', 'yes', 'yes', 0),
(4, 5, 'yes', 'yes', 'yes', 'yes', 0),
(4, 4, 'yes', 'yes', 'yes', 'yes', 0),
(4, 3, 'yes', 'yes', 'yes', 'yes', 0),
(4, 2, 'no', 'no', 'no', 'no', 0),
(4, 1, 'no', 'no', 'no', 'no', 0),

(5, 10, 'no', 'no', 'no', 'no', 0),
(5, 9, 'no', 'no', 'no', 'no', 0),
(5, 8, 'yes', 'yes', 'yes', 'yes', 0),
(5, 7, 'yes', 'yes', 'yes', 'yes', 0),
(5, 6, 'yes', 'yes', 'yes', 'yes', 0),
(5, 5, 'yes', 'yes', 'yes', 'yes', 0),
(5, 4, 'yes', 'yes', 'yes', 'yes', 0),
(5, 3, 'yes', 'yes', 'yes', 'yes', 0),
(5, 2, 'no', 'no', 'no', 'no', 0),
(5, 1, 'no', 'no', 'no', 'no', 0),

(6, 10, 'no', 'no', 'no', 'no', 0),
(6, 9, 'no', 'no', 'no', 'no', 0),
(6, 8, 'yes', 'yes', 'yes', 'yes', 0),
(6, 7, 'yes', 'yes', 'yes', 'yes', 0),
(6, 6, 'yes', 'yes', 'yes', 'yes', 0),
(6, 5, 'yes', 'yes', 'yes', 'yes', 0),
(6, 4, 'yes', 'yes', 'yes', 'yes', 0),
(6, 3, 'yes', 'yes', 'yes', 'yes', 0),
(6, 2, 'no', 'no', 'no', 'no', 0),
(6, 1, 'no', 'no', 'no', 'no', 0),

(7, 10, 'no', 'no', 'no', 'no', 0),
(7, 9, 'no', 'no', 'no', 'no', 0),
(7, 8, 'yes', 'yes', 'yes', 'yes', 0),
(7, 7, 'yes', 'yes', 'yes', 'yes', 0),
(7, 6, 'yes', 'yes', 'yes', 'yes', 0),
(7, 5, 'yes', 'yes', 'yes', 'yes', 0),
(7, 4, 'yes', 'yes', 'yes', 'yes', 0),
(7, 3, 'yes', 'yes', 'yes', 'yes', 0),
(7, 2, 'no', 'no', 'no', 'no', 0),
(7, 1, 'no', 'no', 'no', 'no', 0),

(8, 10, 'no', 'no', 'no', 'no', 0),
(8, 9, 'no', 'no', 'no', 'no', 0),
(8, 8, 'yes', 'yes', 'yes', 'yes', 0),
(8, 7, 'yes', 'yes', 'yes', 'yes', 0),
(8, 6, 'yes', 'yes', 'yes', 'yes', 0),
(8, 5, 'yes', 'yes', 'yes', 'yes', 0),
(8, 4, 'yes', 'yes', 'yes', 'yes', 0),
(8, 3, 'yes', 'yes', 'yes', 'yes', 0),
(8, 2, 'no', 'no', 'no', 'no', 0),
(8, 1, 'no', 'no', 'no', 'no', 0),

(9, 10, 'no', 'no', 'no', 'no', 0),
(9, 9, 'no', 'no', 'no', 'no', 0),
(9, 8, 'yes', 'yes', 'yes', 'yes', 0),
(9, 7, 'yes', 'yes', 'yes', 'yes', 0),
(9, 6, 'yes', 'yes', 'yes', 'yes', 0),
(9, 5, 'yes', 'yes', 'yes', 'yes', 0),
(9, 4, 'yes', 'yes', 'yes', 'yes', 0),
(9, 3, 'yes', 'yes', 'yes', 'yes', 0),
(9, 2, 'no', 'no', 'no', 'no', 0),
(9, 1, 'no', 'no', 'no', 'no', 0),

(11, 10, 'no', 'no', 'no', 'no', 0),
(11, 9, 'no', 'no', 'no', 'no', 0),
(11, 8, 'yes', 'yes', 'yes', 'yes', 0),
(11, 7, 'yes', 'yes', 'yes', 'yes', 0),
(11, 6, 'yes', 'yes', 'yes', 'yes', 0),
(11, 5, 'yes', 'yes', 'yes', 'yes', 0),
(11, 4, 'yes', 'yes', 'yes', 'yes', 0),
(11, 3, 'yes', 'yes', 'yes', 'yes', 0),
(11, 2, 'no', 'no', 'no', 'no', 0),
(11, 1, 'no', 'no', 'no', 'no', 0),

(12, 10, 'no', 'no', 'no', 'no', 0),
(12, 9, 'no', 'no', 'no', 'no', 0),
(12, 8, 'yes', 'yes', 'yes', 'yes', 0),
(12, 7, 'yes', 'yes', 'yes', 'yes', 0),
(12, 6, 'yes', 'yes', 'yes', 'yes', 0),
(12, 5, 'yes', 'yes', 'yes', 'yes', 0),
(12, 4, 'yes', 'yes', 'yes', 'yes', 0),
(12, 3, 'yes', 'yes', 'yes', 'yes', 0),
(12, 2, 'no', 'no', 'no', 'no', 0),
(12, 1, 'no', 'no', 'no', 'no', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}chat`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}chat` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(9) NOT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  `name` tinytext NOT NULL,
  `text` text NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `private` enum('yes','no') NOT NULL DEFAULT 'no',
  `toid` mediumint(9) NOT NULL,
  `fromid` mediumint(9) NOT NULL,
  `pchat` varchar(40) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}chatfun`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}chatfun` (
  `msgid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL DEFAULT '0',
  `message` text,
  `userid` int(8) unsigned NOT NULL DEFAULT '0',
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`msgid`),
  KEY `msgid` (`msgid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}cheapmail`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}cheapmail` (
  `domain` varchar(100) NOT NULL DEFAULT '',
  `added` int(10) NOT NULL DEFAULT '0',
  `added_by` varchar(40) NOT NULL DEFAULT 'Unknown',
  KEY `domain` (`domain`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}coins`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}coins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `info_hash` varchar(40) NOT NULL DEFAULT '',
  `torrentid` int(10) unsigned NOT NULL DEFAULT '0',
  `points` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}contact_system`
--

CREATE TABLE IF NOT EXISTS  `{$db_prefix}contact_system` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cat` varchar(255) DEFAULT NULL,
  `subcat` varchar(255) DEFAULT NULL,
  `message` text,
  `ipaddress` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `re` enum('yes','no') NOT NULL DEFAULT 'no',
  `message2` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}comments`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `ori_text` text NOT NULL,
  `user` varchar(20) NOT NULL DEFAULT '',
  `info_hash` varchar(40) NOT NULL DEFAULT '',
  `points` int(11) NOT NULL DEFAULT '0',
  `cid` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `info_hash` (`info_hash`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}countries`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `flagpic` varchar(50) DEFAULT NULL,
  `domain` char(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}countries`
--

INSERT INTO `{$db_prefix}countries` (`id`, `name`, `flagpic`, `domain`) VALUES
(1, 'Sweden', 'se.png', 'SE'),
(2, 'United States of America', 'us.png', 'US'),
(3, 'American Samoa', 'as.png', 'AS'),
(4, 'Finland', 'fi.png', 'FI'),
(5, 'Canada', 'ca.png', 'CA'),
(6, 'France', 'fr.png', 'FR'),
(7, 'Germany', 'de.png', 'DE'),
(8, 'China', 'cn.png', 'CN'),
(9, 'Italy', 'it.png', 'IT'),
(10, 'Denmark', 'dk.png', 'DK'),
(11, 'Norway', 'no.png', 'NO'),
(12, 'United Kingdom', 'gb.png', 'GB'),
(13, 'Ireland', 'ie.png', 'IE'),
(14, 'Poland', 'pl.png', 'PL'),
(15, 'Netherlands', 'nl.png', 'NL'),
(16, 'Belgium', 'be.png', 'BE'),
(17, 'Japan', 'jp.png', 'JP'),
(18, 'Brazil', 'br.png', 'BR'),
(19, 'Argentina', 'ar.png', 'AR'),
(20, 'Australia', 'au.png', 'AU'),
(21, 'New Zealand', 'nz.png', 'NZ'),
(22, 'United Arab Emirates', 'ae.png', 'AE'),
(23, 'Spain', 'es.png', 'ES'),
(24, 'Portugal', 'pt.png', 'PT'),
(25, 'Mexico', 'mx.png', 'MX'),
(26, 'Singapore', 'sg.png', 'SG'),
(27, 'Anguilla', 'ai.png', 'AI'),
(28, 'Armenia', 'am.png', 'AM'),
(29, 'South Africa', 'za.png', 'ZA'),
(30, 'South Korea', 'kr.png', 'KR'),
(31, 'Jamaica', 'jm.png', 'JM'),
(32, 'Luxembourg', 'lu.png', 'LU'),
(33, 'Hong Kong', 'hk.png', 'HK'),
(34, 'Belize', 'bz.png', 'BZ'),
(35, 'Algeria', 'dz.png', 'DZ'),
(36, 'Angola', 'ao.png', 'AO'),
(37, 'Austria', 'at.png', 'AT'),
(38, 'Aruba', 'aw.png', 'AW'),
(39, 'Samoa', 'ws.png', 'WS'),
(40, 'Malaysia', 'my.png', 'MY'),
(41, 'Dominican Republic', 'do.png', 'DO'),
(42, 'Greece', 'gr.png', 'GR'),
(43, 'Guatemala', 'gt.png', 'GT'),
(44, 'Israel', 'il.png', 'IL'),
(45, 'Pakistan', 'pk.png', 'PK'),
(46, 'Czech Republic', 'cz.png', 'CZ'),
(47, 'Serbia and Montenegro', 'cs.png', 'CS'),
(48, 'Seychelles', 'sc.png', 'SC'),
(49, 'Taiwan', 'tw.png', 'TW'),
(50, 'Puerto Rico', 'pr.png', 'PR'),
(51, 'Chile', 'cl.png', 'CL'),
(52, 'Cuba', 'cu.png', 'CU'),
(53, 'Congo', 'cg.png', 'CG'),
(54, 'Afghanistan', 'af.png', 'AF'),
(55, 'Turkey', 'tr.png', 'TR'),
(56, 'Uzbekistan', 'uz.png', 'UZ'),
(57, 'Switzerland', 'ch.png', 'CH'),
(58, 'Kiribati', 'ki.gif', 'KI'),
(59, 'Philippines', 'ph.png', 'PH'),
(60, 'Burkina Faso', 'bf.png', 'BF'),
(61, 'Nigeria', 'ng.png', 'NG'),
(62, 'Iceland', 'is.png', 'IS'),
(63, 'Nauru', 'nr.png', 'NR'),
(64, 'Slovenia', 'si.png', 'SI'),
(65, 'Albania', 'al.png', 'AL'),
(66, 'Turkmenistan', 'tm.png', 'TM'),
(67, 'Bosnia and Herzegovina', 'ba.png', 'BA'),
(68, 'Andorra', 'ad.png', 'AD'),
(69, 'Lithuania', 'lt.png', 'LT'),
(70, 'India', 'in.png', 'IN'),
(71, 'Netherlands Antilles', 'an.png', 'AN'),
(72, 'Ukraine', 'ua.png', 'UA'),
(73, 'Venezuela', 've.png', 'VE'),
(74, 'Hungary', 'hu.png', 'HU'),
(75, 'Romania', 'ro.png', 'RO'),
(76, 'Vanuatu', 'vu.png', 'VU'),
(77, 'Viet Nam', 'vn.png', 'VN'),
(78, 'Trinidad & Tobago', 'tt.png', 'TT'),
(79, 'Honduras', 'hn.png', 'HN'),
(80, 'Kyrgyzstan', 'kg.png', 'KG'),
(81, 'Ecuador', 'ec.png', 'EC'),
(82, 'Bahamas', 'bs.png', 'BS'),
(83, 'Peru', 'pe.png', 'PE'),
(84, 'Cambodia', 'kh.png', 'KH'),
(85, 'Barbados', 'bb.png', 'BB'),
(86, 'Bangladesh', 'bd.png', 'BD'),
(87, 'Laos', 'la.png', 'LA'),
(88, 'Uruguay', 'uy.png', 'UY'),
(89, 'Antigua Barbuda', 'ag.png', 'AG'),
(90, 'Paraguay', 'py.png', 'PY'),
(91, 'Antarctica', 'aq.png', 'AQ'),
(92, 'Russian Federation', 'ru.png', 'RU'),
(93, 'Thailand', 'th.png', 'TH'),
(94, 'Senegal', 'sn.png', 'SN'),
(95, 'Togo', 'tg.png', 'TG'),
(96, 'North Korea', 'kp.png', 'KP'),
(97, 'Croatia', 'hr.png', 'HR'),
(98, 'Estonia', 'ee.png', 'EE'),
(99, 'Colombia', 'co.png', 'CO'),
(100, 'unknown', 'unknown.gif', 'AA'),
(101, 'Organization', 'org.png', 'ORG'),
(102, 'Aland Islands', 'ax.png', 'AX'),
(103, 'Azerbaijan', 'az.png', 'AZ'),
(104, 'Bulgaria', 'bg.png', 'BG'),
(105, 'Bahrain', 'bh.png', 'BH'),
(106, 'Burundi', 'bi.png', 'BI'),
(107, 'Benin', 'bj.png', 'BJ'),
(108, 'Bermuda', 'bm.png', 'BM'),
(109, 'Brunei Darussalam', 'bn.png', 'BN'),
(110, 'Bolivia', 'bo.png', 'BO'),
(111, 'Bhutan', 'bt.png', 'BT'),
(112, 'Bouvet Island', 'bv.png', 'BV'),
(113, 'Botswana', 'bw.png', 'BW'),
(114, 'Belarus', 'by.png', 'BY'),
(115, 'Cocos (Keeling) Islands', 'cc.png', 'CC'),
(116, 'Congo, the Democratic Republic of the', 'cd.png', 'CD'),
(117, 'Central African Republic', 'cf.png', 'CF'),
(118, 'Ivory Coast', 'ci.png', 'CI'),
(119, 'Cook Islands', 'ck.png', 'CK'),
(120, 'Cameroon', 'cm.png', 'CM'),
(121, 'Costa Rica', 'cr.png', 'CR'),
(122, 'Cape Verde', 'cv.png', 'CV'),
(123, 'Christmas Island', 'cx.png', 'CX'),
(124, 'Cyprus', 'cy.png', 'CY'),
(125, 'Djibouti', 'dj.png', 'DJ'),
(126, 'Dominica', 'dm.png', 'DM'),
(127, 'Egypt', 'eg.png', 'EG'),
(128, 'Western Sahara', 'eh.png', 'EH'),
(129, 'Eritrea', 'er.png', 'ER'),
(130, 'Ethiopia', 'et.png', 'ET'),
(131, 'Fiji', 'fj.png', 'FJ'),
(132, 'Falkland Islands (Malvinas)', 'fk.png', 'FK'),
(133, 'Micronesia, Federated States of', 'fm.png', 'FM'),
(134, 'Faroe Islands', 'fo.png', 'FO'),
(135, 'Gabon', 'ga.png', 'GA'),
(136, 'Grenada', 'gd.png', 'GD'),
(137, 'Georgia', 'ge.png', 'GE'),
(138, 'French Guiana', 'gf.png', 'GF'),
(139, 'Guernsey', 'gg.png', 'GG'),
(140, 'Ghana', 'gh.png', 'GH'),
(141, 'Gibraltar', 'gi.png', 'GI'),
(142, 'Greenland', 'gl.png', 'GL'),
(143, 'Gambia', 'gm.png', 'GM'),
(144, 'Guinea', 'gn.png', 'GN'),
(145, 'Guadeloupe', 'gp.png', 'GP'),
(146, 'Equatorial Guinea', 'gq.png', 'GQ'),
(147, 'South Georgia and the South Sandwich Islands', 'gs.png', 'GS'),
(148, 'Guam', 'gu.png', 'GU'),
(149, 'Guinea-Bissau', 'gw.png', 'GW'),
(150, 'Guyana', 'gy.png', 'GY'),
(151, 'Heard Island and McDonald Islands', 'hm.png', 'HM'),
(152, 'Haiti', 'ht.png', 'HT'),
(153, 'Indonesia', 'id.png', 'ID'),
(154, 'Isle of Man', 'im.png', 'IM'),
(155, 'British Indian Ocean Territory', 'io.png', 'IO'),
(156, 'Jersey', 'je.png', 'JE'),
(157, 'Jordan', 'jo.png', 'JO'),
(158, 'Kenya', 'ke.png', 'KE'),
(159, 'Comoros', 'km.png', 'KM'),
(160, 'Saint Kitts and Nevis', 'kn.png', 'KN'),
(161, 'Kuwait', 'kw.png', 'KW'),
(162, 'Cayman Islands', 'ky.png', 'KY'),
(163, 'Kazahstan', 'kz.png', 'KZ'),
(164, 'Lebanon', 'lb.png', 'LB'),
(165, 'Saint Lucia', 'lc.png', 'LC'),
(166, 'Liechtenstein', 'li.png', 'LI'),
(167, 'Sri Lanka', 'lk.png', 'LK'),
(168, 'Liberia', 'lr.png', 'LR'),
(169, 'Lesotho', 'ls.png', 'LS'),
(170, 'Latvia', 'lv.png', 'LV'),
(171, 'Libyan Arab Jamahiriya', 'ly.png', 'LY'),
(172, 'Morocco', 'ma.png', 'MA'),
(173, 'Monaco', 'mc.png', 'MC'),
(174, 'Moldova, Republic of', 'md.png', 'MD'),
(175, 'Madagascar', 'mg.png', 'MG'),
(176, 'Marshall Islands', 'mh.png', 'MH'),
(177, 'Macedonia, the former Yugoslav Republic of', 'mk.png', 'MK'),
(178, 'Mali', 'ml.png', 'ML'),
(179, 'Myanmar', 'mm.png', 'MM'),
(180, 'Mongolia', 'mn.png', 'MN'),
(181, 'Macao', 'mo.png', 'MO'),
(182, 'Northern Mariana Islands', 'mp.png', 'MP'),
(183, 'Martinique', 'mq.png', 'MQ'),
(184, 'Mauritania', 'mr.png', 'MR'),
(185, 'Montserrat', 'ms.png', 'MS'),
(186, 'Malta', 'mt.png', 'MT'),
(187, 'Mauritius', 'mu.png', 'MU'),
(188, 'Maldives', 'mv.png', 'MV'),
(189, 'Malawi', 'mw.png', 'MW'),
(190, 'Mozambique', 'mz.png', 'MZ'),
(191, 'Namibia', 'na.png', 'NA'),
(192, 'New Caledonia', 'nc.png', 'NC'),
(193, 'Niger', 'ne.png', 'NE'),
(194, 'Norfolk Island', 'nf.png', 'NF'),
(195, 'Nicaragua', 'ni.png', 'NI'),
(196, 'Nepal', 'np.png', 'NP'),
(197, 'Niue', 'nu.png', 'NU'),
(198, 'Oman', 'om.png', 'OM'),
(199, 'Panama', 'pa.png', 'PA'),
(200, 'French Polynesia', 'pf.png', 'PF'),
(201, 'Papua New Guinea', 'pg.png', 'PG'),
(202, 'Saint Pierre and Miquelon', 'pm.png', 'PM'),
(203, 'Pitcairn', 'pn.png', 'PN'),
(204, 'Palestinian Territory, Occupied', 'ps.png', 'PS'),
(205, 'Palau', 'pw.png', 'PW'),
(206, 'Qatar', 'qa.png', 'QA'),
(207, 'Reunion', 're.png', 'RE'),
(208, 'Rwanda', 'rw.png', 'RW'),
(209, 'Saudi Arabia', 'sa.png', 'SA'),
(210, 'Solomon Islands', 'sb.png', 'SB'),
(211, 'Sudan', 'sd.png', 'SD'),
(212, 'Saint Helena', 'sh.png', 'SH'),
(213, 'Svalbard and Jan Mayen', 'sj.png', 'SJ'),
(214, 'Slovakia', 'sk.png', 'SK'),
(215, 'Sierra Leone', 'sl.png', 'SL'),
(216, 'San Marino', 'sm.png', 'SM'),
(217, 'Somalia', 'so.png', 'SO'),
(218, 'Suriname', 'sr.png', 'SR'),
(219, 'Sao Tome and Principe', 'st.png', 'ST'),
(220, 'El Salvador', 'sv.png', 'SV'),
(221, 'Syrian Arab Republic', 'sy.png', 'SY'),
(222, 'Swaziland', 'sz.png', 'SZ'),
(223, 'Turks and Caicos Islands', 'tc.png', 'TC'),
(224, 'Chad', 'td.png', 'TD'),
(225, 'French Southern Territories', 'tf.png', 'TF'),
(226, 'Tajikistan', 'tj.png', 'TJ'),
(227, 'Tokelau', 'tk.png', 'TK'),
(228, 'Timor-Leste', 'tl.png', 'TL'),
(229, 'Tunisia', 'tn.png', 'TN'),
(230, 'Tonga', 'to.png', 'TO'),
(231, 'Tuvalu', 'tv.png', 'TV'),
(232, 'Tanzania, United Republic of', 'tz.png', 'TZ'),
(233, 'Uganda', 'ug.png', 'UG'),
(234, 'United States Minor Outlying Islands', 'um.png', 'UM'),
(235, 'Holy See (Vatican City State)', 'va.png', 'VA'),
(236, 'Saint Vincent and the Grenadines', 'vc.png', 'VC'),
(237, 'Virgin Islands, British', 'vg.png', 'VG'),
(238, 'Wallis and Futuna', 'wf.png', 'WF'),
(239, 'Yemen', 'ye.png', 'YE'),
(240, 'Mayotte', 'yt.png', 'YT'),
(241, 'Zambia', 'zm.png', 'ZM'),
(242, 'Zimbabwe', 'zw.png', 'ZW'),
(243, 'Iraq', 'iq.png', 'IQ'),
(244, 'Iran, Islamic Republic of', 'ir.png', 'IR');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}donors`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}donors` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(20) NOT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `payers_email` varchar(255) NOT NULL DEFAULT '',
  `mc_gross` decimal(5,2) NOT NULL,
  `date` datetime DEFAULT '0000-00-00 00:00:00',
  `country` varchar(255) NOT NULL,
  `item` varchar(20) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}don_historie`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}don_historie` (
  `don_id` int(11) NOT NULL DEFAULT '0',
  `donate_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `don_ation` int(11) NOT NULL,
  `donate_date_1` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `don_ation_1` int(11) NOT NULL,
  `donate_date_2` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `don_ation_2` int(11) NOT NULL,
  `donate_date_3` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `don_ation_3` int(11) NOT NULL,
  `donate_date_4` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `don_ation_4` int(11) NOT NULL,
  `donate_date_5` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `don_ation_5` int(11) NOT NULL,
  `donate_date_6` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `don_ation_6` int(11) NOT NULL,
  `donate_date_7` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `don_ation_7` int(11) NOT NULL,
  `donate_date_8` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `don_ation_8` int(11) NOT NULL,
  `donate_date_9` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `don_ation_9` int(11) NOT NULL,
  `donate_date_10` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `don_ation_10` int(11) NOT NULL,
  PRIMARY KEY (`don_id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}downloads`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}downloads` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `info_hash` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  `updown` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`uid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}dox`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}dox` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `added` datetime default '0000-00-00 00:00:00',
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `size` int(10) unsigned NOT NULL default '0',
  `uppedby` int(10) unsigned NOT NULL default '0',
  `url` varchar(255) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}down_load`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}down_load` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}expected`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}expected` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `expect` varchar(225) DEFAULT NULL,
  `descr` text NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date` varchar(255) NOT NULL DEFAULT '',
  `cat` int(10) unsigned NOT NULL DEFAULT '0',
  `torrenturl` varchar(255) NOT NULL,
  `uploaded` enum('yes','no') NOT NULL DEFAULT 'no',
  `expect_offer` enum('yes','no') NOT NULL DEFAULT 'no',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `hitsmin` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}faq`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cat_id` int(11) NOT NULL,
  `active` enum('-1','0','1') NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}faq_group`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}faq_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` enum('-1','0','1') NOT NULL DEFAULT '1',
  `sort_index` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}featured`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}featured` (
  `fid` int(5) NOT NULL AUTO_INCREMENT,
  `torrent_id` varchar(40) NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------


--
-- Tabelstructuur voor tabel `{$db_prefix}files`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}files` (
  `info_hash` varchar(40) NOT NULL DEFAULT '',
  `filename` varchar(250) NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `info` varchar(250) NOT NULL DEFAULT '',
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `size` bigint(20) NOT NULL DEFAULT '0',
  `comment` text,
  `category` int(10) unsigned NOT NULL DEFAULT '6',
  `external` enum('yes','no') NOT NULL DEFAULT 'no',
  `announce_url` varchar(100) NOT NULL DEFAULT '',
  `uploader` int(10) NOT NULL DEFAULT '1',
  `lastupdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `anonymous` enum('true','false') NOT NULL DEFAULT 'false',
  `lastsuccess` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dlbytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  `seeds` int(10) unsigned NOT NULL DEFAULT '0',
  `leechers` int(10) unsigned NOT NULL DEFAULT '0',
  `finished` int(10) unsigned NOT NULL DEFAULT '0',
  `lastcycle` int(10) unsigned NOT NULL DEFAULT '0',
  `lastSpeedCycle` int(10) unsigned NOT NULL DEFAULT '0',
  `speed` bigint(20) unsigned NOT NULL DEFAULT '0',
  `bin_hash` blob NOT NULL,
  `sticky` enum('0','1') NOT NULL DEFAULT '0',
  `vip_torrent` enum('0','1') NOT NULL DEFAULT '0',
  `free_expire_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `free` enum('yes','no') DEFAULT 'no',
  `image` varchar(255) NOT NULL DEFAULT '',
  `screen1` varchar(255) NOT NULL DEFAULT '',
  `screen2` varchar(255) NOT NULL DEFAULT '',
  `screen3` varchar(255) NOT NULL DEFAULT '',
  `reseed` int(9) NOT NULL DEFAULT '0',
  `lock_comment` enum('yes','no') DEFAULT 'no',
  `gold` enum('0','1','2') NOT NULL DEFAULT '0',
  `happy` enum('yes','no') DEFAULT 'no',
  `happy_hour` enum('yes','no') DEFAULT 'no',
  `points` int(10) NOT NULL DEFAULT '0',
  `moder` enum('um','bad','ok') NOT NULL DEFAULT 'um',
  `staff_comment` varchar(250) DEFAULT NULL,
  `topicid` int(10) DEFAULT NULL,
  `announces` text NOT NULL,
  `imdb` varchar(10) NOT NULL DEFAULT '0',
  `multiplier` enum('1', '2', '3', '4', '5', '6', '7', '8', '9', '10' ) DEFAULT '1',
  `youtube_video` varchar(250) default NULL,
  `tag` text NOT NULL,
  `language` INT( 9 ) NOT NULL DEFAULT '0',
  `team` varchar(10) default '0',
  `dead_time` int(10) unsigned NOT NULL DEFAULT '0',
  `pretime` varchar(250) NOT NULL DEFAULT '',
  `catid` varchar(50) NOT NULL,
  PRIMARY KEY (`info_hash`),
  KEY `filename` (`filename`),
  KEY `category` (`category`),
  KEY `uploader` (`uploader`),
  KEY `bin_hash` (`bin_hash`(20))
) ENGINE=MyISAM;

--
-- Tabelstructuur voor tabel `{$db_prefix}files_thanks`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}files_thanks` (
  `infohash` char(40) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  KEY `infohash` (`infohash`)
) ENGINE=MyISAM;

--
-- Tabelstructuur voor tabel `{$db_prefix}flashscores`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}flashscores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `game` int(11) NOT NULL DEFAULT '0',
  `user` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}flashscores`
--

INSERT INTO `{$db_prefix}flashscores` (`ID`, `game`, `user`, `level`, `score`, `date`) VALUES
(13, 1, 2, 1, 10, '2010-02-18 12:14:36'),
(14, 2, 2, 1, 10, '2010-02-18 12:27:07'),
(15, 3, 2, 1, 10, '2010-02-18 12:27:44'),
(16, 4, 2, 1, 10, '2010-02-18 12:33:43'),
(17, 5, 2, 1, 10, '2010-02-18 12:14:36'),
(18, 6, 2, 1, 10, '2010-02-18 12:27:07'),
(19, 7, 2, 1, 10, '2010-02-18 12:33:43'),
(20, 8, 2, 1, 10, '2010-02-18 12:33:43'),
(21, 9, 2, 1, 10, '2010-02-18 12:33:43'),
(22, 10, 2, 1, 10, '2010-02-18 12:14:36'),
(23, 11, 2, 1, 10, '2010-02-18 12:27:07'),
(24, 12, 2, 1, 10, '2010-02-18 12:27:44'),
(25, 13, 2, 1, 10, '2010-02-18 12:33:43'),
(26, 14, 2, 1, 10, '2010-02-18 12:14:36'),
(27, 15, 2, 1, 10, '2010-02-18 12:27:07'),
(28, 16, 2, 1, 10, '2010-02-18 12:33:43'),
(29, 17, 2, 1, 10, '2010-02-18 12:33:43'),
(30, 18, 2, 1, 10, '2010-02-18 12:33:43'),
(31, 19, 2, 1, 10, '2010-02-18 12:14:36'),
(32, 20, 2, 1, 10, '2010-02-18 12:27:07'),
(33, 21, 2, 1, 10, '2010-02-18 12:33:43'),
(34, 22, 2, 1, 10, '2010-02-18 12:33:43'),
(35, 23, 2, 1, 10, '2010-02-18 12:33:43'),
(36, 24, 2, 1, 10, '2010-02-18 12:35:57');
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}forums`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}forums` (
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `description` varchar(200) DEFAULT NULL,
  `minclassread` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `minclasswrite` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `postcount` int(10) unsigned NOT NULL DEFAULT '0',
  `topiccount` int(10) unsigned NOT NULL DEFAULT '0',
  `minclasscreate` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `id_parent` int(10) NOT NULL DEFAULT '0',
  `category` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`),
  KEY `id_parent` (`id_parent`)
) ENGINE=MyISAM;

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `{$db_prefix}forum_pm`
--

 CREATE TABLE IF NOT EXISTS  `{$db_prefix}forum_pm` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `topicid` int(10) unsigned NOT NULL,
  `enabled` enum('yes','no') NOT NULL default 'yes',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}free_leech_req`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}free_leech_req` (
  `info_hash` varchar(40) NOT NULL,
  `count` int(10) NOT NULL DEFAULT '1',
  `approved` enum('yes','no','undecided') NOT NULL DEFAULT 'undecided',
  `requester_ids` text NOT NULL,
  UNIQUE KEY `info_hash` (`info_hash`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}friendlist`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}friendlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `friend_id` int(10) unsigned NOT NULL DEFAULT '0',
  `friend_name` varchar(250) NOT NULL DEFAULT '',
  `friend_date` varchar(20) NOT NULL,
  `confirmed` enum('yes','no') NOT NULL DEFAULT 'no',
  `rejected` enum('yes','no') NOT NULL DEFAULT 'no',
  `username` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}gallery`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}gallery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `owner` int(10) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}gold`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}gold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL DEFAULT '4',
  `gold_picture` varchar(255) NOT NULL DEFAULT 'gold.gif',
  `silver_picture` varchar(255) NOT NULL DEFAULT 'silver.gif',
  `active` enum('-1','0','1') NOT NULL DEFAULT '1',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `gold_description` text NOT NULL,
  `silver_description` text NOT NULL,
  `classic_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}gold`
--

INSERT INTO `{$db_prefix}gold` (`id`, `level`, `gold_picture`, `silver_picture`, `active`, `date`, `gold_description`, `silver_description`, `classic_description`) VALUES
(1, 3, 'gold.gif', 'silver.gif', '1', '0000-00-00', 'Gold torrent description', 'Silver torrent description', 'Classic torrent description');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}hacks`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}hacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `version` varchar(10) NOT NULL,
  `author` varchar(100) NOT NULL,
  `added` int(11) NOT NULL,
  `folder` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Tabelstructuur voor tabel `{$db_prefix}helpdesk`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}helpdesk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL DEFAULT '',
  `msg_problem` text,
  `added` int(11) NOT NULL DEFAULT '0',
  `solved_date` int(11) NOT NULL DEFAULT '0',
  `solved` enum('no','yes','ignored') NOT NULL DEFAULT 'no',
  `added_by` int(10) NOT NULL DEFAULT '0',
  `solved_by` int(10) NOT NULL DEFAULT '0',
  `msg_answer` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}history`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}history` (
  `uid` int(10) DEFAULT NULL,
  `infohash` varchar(40) NOT NULL DEFAULT '',
  `date` int(10) DEFAULT NULL,
  `uploaded` bigint(20) NOT NULL DEFAULT '0',
  `downloaded` bigint(20) NOT NULL DEFAULT '0',
  `active` enum('yes','no') NOT NULL DEFAULT 'no',
  `agent` varchar(30) NOT NULL DEFAULT '',
  `completed` enum('no','yes') NOT NULL DEFAULT 'no',
  `hit` enum('no','yes') NOT NULL DEFAULT 'no',
  `hitchecked` int(11) NOT NULL DEFAULT '0',
  `punishment_amount` int(11) NOT NULL DEFAULT '0',
  `seed` bigint(99) NOT NULL DEFAULT '0',
  UNIQUE KEY `uid` (`uid`,`infohash`)
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}ignore`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}ignore` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ignore_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ignore_name` varchar(250) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}invalid_logins`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}invalid_logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` bigint(11) DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(40) NOT NULL DEFAULT '',
  `failed` int(3) unsigned NOT NULL DEFAULT '0',
  `remaining` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}invitations`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}invitations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inviter` int(10) unsigned NOT NULL DEFAULT '0',
  `invitee` varchar(80) NOT NULL DEFAULT '',
  `hash` varchar(32) NOT NULL DEFAULT '',
  `time_invited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `confirmed` enum('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`),
  KEY `inviter` (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}iplog`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}iplog` (
  `ipid` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uid` varchar(5) NOT NULL DEFAULT '',
  `uipid` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`ipid`),
  UNIQUE KEY `date` (`date`)
) ENGINE=MyISAM;

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `{$db_prefix}khez_configs`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}khez_configs` (
				`key` varchar(30) NOT NULL,
				`value` varchar(200) NOT NULL,
				 UNIQUE KEY (`key`)
) ENGINE=MyISAM ;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}khez_configs`
--

INSERT INTO `{$db_prefix}khez_configs` VALUES
					('kocs_cfg_logs', 'true'),
					('kocs_cfg_keycheck', 'true'),
					('kocs_cfg_key', '08077a68b7bc66b899dabd2f90c84eeb'),
					('kocs_bak_last', '0'),
					('kocs_bak_by', '0'),
					('kocs_res_last', '0'),
					('kocs_res_by', '0'),
					('kocs_res_errors', '0');

-- --------------------------------------------------------


--
-- Tabelstructuur voor tabel `{$db_prefix}language`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}language` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `language` varchar(20) NOT NULL DEFAULT '',
  `language_url` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}language`
--

INSERT INTO `{$db_prefix}language` (`id`, `language`, `language_url`) VALUES
(1, 'English', 'language/english'),
(2, 'Romanian', 'language/romanian'),
(3, 'Polish', 'language/polish'),
(4, 'Srpsko-Hrvatski', 'language/serbocroatian'),
(5, 'Dutch', 'language/dutch'),
(6, 'Italiano', 'language/italian'),
(7, 'Russian', 'language/russian'),
(8, 'German', 'language/german'),
(9, 'Hungarian', 'language/hungarian'),
(10, 'French', 'language/french'),
(11, 'Finnish', 'language/finnish'),
(12, 'Vietnamese', 'language/vietnamese'),
(13, 'Greek', 'language/greek'),
(14, 'Bulgarian', 'language/bulgarian'),
(15, 'Spanish', 'language/spanish'),
(16, 'Portuguese-BR', 'language/portuguese-BR'),
(17, 'Portuguese-PT', 'language/portuguese-PT'),
(18, 'Swedish', 'language/swedish'),
(19, 'Arabic', 'language/arabic'),
(20, 'Danish', 'language/danish'),
(21, 'Chinese-Simplified', 'language/chinese'),
(22, 'Bengali', 'language/bangla');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}logs`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `added` int(10) DEFAULT NULL,
  `txt` text,
  `type` varchar(10) NOT NULL DEFAULT 'add',
  `user` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `added` (`added`)
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}lottery_config`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}lottery_config` (
  `id` int(11) NOT NULL DEFAULT '0',
  `lot_expire_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lot_number_winners` varchar(20) NOT NULL DEFAULT '',
  `lot_number_to_win` varchar(20) NOT NULL DEFAULT '',
  `lot_amount` varchar(20) NOT NULL DEFAULT '',
  `lot_status` enum('yes','no','closed') NOT NULL DEFAULT 'yes',
  `limit_buy` char(2) NOT NULL DEFAULT '',
  `sender_id` char(8) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}lottery_config`
--

INSERT INTO `{$db_prefix}lottery_config` (`id`, `lot_expire_date`, `lot_number_winners`, `lot_number_to_win`, `lot_amount`, `lot_status`, `limit_buy`, `sender_id`) VALUES
(0, '0000-00-00 00:00:00', '', '', '', '', '', '2'),
(1, '2012-01-01 20:00:00', '1', '10737418240', '1048576', 'closed', '1', '2');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}lottery_tickets`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}lottery_tickets` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}lottery_winners`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}lottery_winners` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `win_user` varchar(20) NOT NULL DEFAULT '',
  `windate` varchar(20) NOT NULL DEFAULT '',
  `price` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}low_ratio_ban`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}low_ratio_ban` (
  `wb_down` varchar(10) NOT NULL,
  `wb_rank` varchar(10) NOT NULL,
  `wb_warn` enum('true','false') NOT NULL,
  `wb_one` varchar(10) NOT NULL,
  `wb_days_one` varchar(10) NOT NULL,
  `wb_two` varchar(10) NOT NULL,
  `wb_days_two` varchar(10) NOT NULL,
  `wb_three` varchar(10) NOT NULL,
  `wb_days_fin` varchar(10) NOT NULL,
  `wb_fin` varchar(10) NOT NULL
) ENGINE=MyISAM;
--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}low_ratio_ban`
--

INSERT INTO `{$db_prefix}low_ratio_ban` (`wb_down`, `wb_rank`, `wb_warn`, `wb_one`, `wb_days_one`, `wb_two`, `wb_days_two`, `wb_three`, `wb_days_fin`, `wb_fin`) VALUES
('30', '3', 'false', '0.3', '7', '0.4', '7', '0.5', '7', '0.5');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}low_ratio_ban_settings`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}low_ratio_ban_settings` (
  `id` varchar(4) NOT NULL DEFAULT '1',
  `wb_sys` enum('true','false') NOT NULL DEFAULT 'false',
  `wb_text_one` varchar(255) NOT NULL,
  `wb_text_two` varchar(255) NOT NULL,
  `wb_text_fin` varchar(255) NOT NULL
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}low_ratio_ban_settings`
--

INSERT INTO `{$db_prefix}low_ratio_ban_settings` (`id`, `wb_sys`, `wb_text_one`, `wb_text_two`, `wb_text_fin`) VALUES
('1', 'false', 'Your ratio is to low , you get ( member 7 days / vip 10 days ) to improve your ratio to ( member 0.4 / vip 0.6 )', 'Your ratio is still to low , you get ( member 7 days / vip 10 days ) to improve your ratio to ( member 0.5 / vip 0.7 )', 'Your ratio is still to low , you get ( member 7 days / vip 15 days ) to improve your ratio to ( member 0.5 / vip 0.7 ) else you will get banned from this site !!');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}messages`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` int(10) unsigned NOT NULL DEFAULT '0',
  `receiver` int(10) unsigned NOT NULL DEFAULT '0',
  `added` int(10) DEFAULT NULL,
  `subject` varchar(50) NOT NULL DEFAULT '',
  `msg` text,
  `readed` enum('yes','no') NOT NULL DEFAULT 'no',
  `deletedBySender` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `receiver` (`receiver`),
  KEY `sender` (`sender`)
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}moderate_reasons`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}moderate_reasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `active` enum('-1','0','1') NOT NULL DEFAULT '1',
  `ordering` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}modules`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}modules` (
  `id` mediumint(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `activated` enum('yes','no') NOT NULL DEFAULT 'yes',
  `type` enum('staff','misc','torrent','style') NOT NULL DEFAULT 'misc',
  `changed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}modules`
--

INSERT INTO `{$db_prefix}modules` (`id`, `name`, `activated`, `type`, `changed`, `created`) VALUES
(1, 'getrss', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-13 14:28:19'),
(2, 'seedbonus', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-13 14:28:19'),
(3, 'helpdesk', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-13 14:28:19'),
(4, 'slots', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-13 14:28:19'),
(5, 'nat', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-13 14:28:19'),
(6, 'stafffun', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-13 14:28:19'),
(7, 'referral', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-13 14:28:19'),
(8, 'flashscores', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-13 14:28:19'),
(9, 'bugs', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-13 14:28:19'),
(10, 'hitnrun_cleaner', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-13 14:28:19'),
(11, 'irc', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(12, 'invite', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(13, 'team', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(14, 'speedtest', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(15, 'teams', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(16, 'IMDb', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(17, 'quiz', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(18, 'quiz_admin', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(19, 'calender', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(20, 'server', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(21, 'results', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(22, 'sb_to_upload_conversion', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05'),
(23, 'cache', 'yes', 'misc', '2014-08-13 14:28:19', '2014-08-17 08:19:05');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}mostonline`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}mostonline` (
  `amount` int(4) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL DEFAULT '2008-11-24 00:00:00'
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}mostonline`
--

INSERT INTO `{$db_prefix}mostonline` (`amount`, `date`) VALUES
(1, '2012-10-04 21:30:04');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}news`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news` blob NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` varchar(40) NOT NULL DEFAULT '',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}news`
--

INSERT INTO `{$db_prefix}news` (`id`, `news`, `user_id`, `date`, `title`) VALUES
(1, 0x57656c636f6d6520746f20584254495420445420464d205632300d0a537570706f727420666f72207468697320736f667477617265206174205b75726c3d687474703a2f2f7777772e7862746974646576656c6f70696e672e6e6c5d4469656d54687579277320584254495420446576656c6f70696e675b2f75726c5d0d0a0d0a, 2, '2014-08-04 14:15:44', 'Welcome to XBTIT DT FM V20');
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}notes`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}notes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}offer_comments`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}offer_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `ori_text` text NOT NULL,
  `user` varchar(20) NOT NULL DEFAULT '',
  `offer_id` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `offer_id` (`offer_id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}online`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}online` (
  `session_id` varchar(40) NOT NULL,
  `user_id` int(10) NOT NULL,
  `user_ip` varchar(15) NOT NULL,
  `location` varchar(20) NOT NULL,
  `lastaction` int(10) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `user_group` varchar(50) NOT NULL,
  `prefixcolor` varchar(200) NOT NULL,
  `suffixcolor` varchar(200) NOT NULL,
  `picture` varchar(50) NOT NULL DEFAULT '0',
  `donor` enum('yes','no') NOT NULL DEFAULT 'no',
  `warn` enum('yes','no') NOT NULL DEFAULT 'no',
  `immunity` enum('yes','no') NOT NULL DEFAULT 'no',
  `invisible` enum('yes','no') NOT NULL DEFAULT 'no',
  `booted` enum('yes','no') NOT NULL DEFAULT 'no',
  `dona` enum('yes','no') NOT NULL DEFAULT 'no',
  `donb` enum('yes','no') NOT NULL DEFAULT 'no',
  `birt` enum('yes','no') NOT NULL DEFAULT 'no',
  `mal` enum('yes','no') NOT NULL DEFAULT 'no',
  `fem` enum('yes','no') NOT NULL DEFAULT 'no',
  `bann` enum('yes','no') NOT NULL DEFAULT 'no',
  `war` enum('yes','no') NOT NULL DEFAULT 'no',
  `par` enum('yes','no') NOT NULL DEFAULT 'no',
  `bot` enum('yes','no') NOT NULL DEFAULT 'no',
  `trmu` enum('yes','no') NOT NULL DEFAULT 'no',
  `trmo` enum('yes','no') NOT NULL DEFAULT 'no',
  `vimu` enum('yes','no') NOT NULL DEFAULT 'no',
  `vimo` enum('yes','no') NOT NULL DEFAULT 'no',
  `friend` enum('yes','no') NOT NULL DEFAULT 'no',
  `junkie` enum('yes','no') NOT NULL DEFAULT 'no',
  `staff` enum('yes','no') NOT NULL DEFAULT 'no',
  `sysop` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`session_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}paypal_settings`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}paypal_settings` (
  `id` varchar(60) NOT NULL DEFAULT '',
  `test` enum('true','false') NOT NULL DEFAULT 'true',
  `paypal_email` varchar(60) NOT NULL DEFAULT '',
  `sandbox_email` varchar(60) NOT NULL DEFAULT '',
  `vip_days` varchar(60) NOT NULL DEFAULT '',
  `vip_daysb` varchar(60) NOT NULL DEFAULT '',
  `vip_daysc` varchar(60) NOT NULL DEFAULT '',
  `vip_rank` varchar(60) NOT NULL DEFAULT '',
  `needed` varchar(60) NOT NULL DEFAULT '',
  `due_date` varchar(60) NOT NULL DEFAULT '',
  `num_block` varchar(60) NOT NULL DEFAULT '',
  `received` varchar(60) NOT NULL DEFAULT '',
  `donation_block` enum('true','false') NOT NULL DEFAULT 'true',
  `scrol_tekst` varchar(255) NOT NULL DEFAULT '',
  `units` enum('true','false') NOT NULL DEFAULT 'true',
  `historie` enum('true','false') NOT NULL DEFAULT 'true',
  `don_star` enum('true','false') NOT NULL DEFAULT 'true',
  `gb` varchar(60) NOT NULL DEFAULT '',
  `gbb` varchar(60) NOT NULL DEFAULT '',
  `gbc` varchar(60) NOT NULL DEFAULT '',
  `togb` varchar(60) NOT NULL DEFAULT '',
  `togbb` varchar(60) NOT NULL DEFAULT '',
  `togbc` varchar(60) NOT NULL DEFAULT '',
  `today` varchar(60) NOT NULL DEFAULT '',
  `todayb` varchar(60) NOT NULL DEFAULT '',
  `todayc` varchar(60) NOT NULL DEFAULT '',
  `smf` varchar(60) NOT NULL DEFAULT '',
  `IPN` enum('true','false') NOT NULL DEFAULT 'true',
  `identity_token` varchar(255) NOT NULL DEFAULT '',
  `ppinvon` enum('true','false') NOT NULL DEFAULT 'true',
  `ppinv` varchar(60) NOT NULL
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}paypal_settings`
--

INSERT INTO `{$db_prefix}paypal_settings` (`id`, `test`, `paypal_email`, `sandbox_email`, `vip_days`, `vip_rank`, `needed`, `due_date`, `num_block`, `received`, `donation_block`, `scrol_tekst`, `units`, `historie`, `don_star`, `gb`, `smf`, `IPN`, `identity_token`, `ppinvon`, `ppinv`, `vip_daysb`, `vip_daysc`, `gbb`, `gbc`, `togb`, `togbb`, `today`, `todayb`, `todayc`, `togbc`) VALUES
('1', 'true', 'email', 'email', '1', '5', '1', '10/09/09', '1', '1', 'true', 'your custom text here', 'true', 'true', 'true', '5', '1', 'true', '', 'false', '5', '15', '20', '6', '8', '10', '20', '10', '20', '0', '0');
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}peers`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}peers` (
  `infohash` varchar(40) NOT NULL DEFAULT '',
  `peer_id` varchar(40) NOT NULL DEFAULT '',
  `bytes` bigint(20) NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT 'error.x',
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `status` enum('leecher','seeder') NOT NULL DEFAULT 'leecher',
  `lastupdate` int(10) unsigned NOT NULL DEFAULT '0',
  `sequence` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `natuser` enum('N','Y') NOT NULL DEFAULT 'N',
  `client` varchar(60) NOT NULL DEFAULT '',
  `dns` varchar(100) NOT NULL DEFAULT '',
  `uploaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `downloaded` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pid` varchar(32) DEFAULT NULL,
  `with_peerid` varchar(101) NOT NULL DEFAULT '',
  `without_peerid` varchar(40) NOT NULL DEFAULT '',
  `compact` varchar(6) NOT NULL DEFAULT '',
  `announce_interval` int(10) NOT NULL,
  `upload_difference` bigint(20) NOT NULL,
  `download_difference` bigint(20) NOT NULL,
  PRIMARY KEY (`infohash`,`peer_id`),
  UNIQUE KEY `sequence` (`sequence`),
  KEY `pid` (`pid`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}poller`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}poller` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `startDate` int(10) NOT NULL DEFAULT '0',
  `endDate` int(10) NOT NULL DEFAULT '0',
  `pollerTitle` varchar(255) DEFAULT NULL,
  `starterID` mediumint(8) NOT NULL DEFAULT '0',
  `active` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}poller`
--

INSERT INTO `{$db_prefix}poller` (`ID`, `startDate`, `endDate`, `pollerTitle`, `starterID`, `active`) VALUES
(1, 1344848795, 0, 'How would you rate this script?', 2, 'yes');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}poller_option`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}poller_option` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `pollerID` int(11) DEFAULT NULL,
  `optionText` varchar(255) DEFAULT NULL,
  `pollerOrder` int(11) DEFAULT NULL,
  `defaultChecked` char(1) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}poller_option`
--

INSERT INTO `{$db_prefix}poller_option` (`ID`, `pollerID`, `optionText`, `pollerOrder`, `defaultChecked`) VALUES
(1, 1, 'Excellent', 1, '1'),
(2, 1, 'Very good', 2, '0'),
(3, 1, 'Good', 3, '0'),
(4, 1, 'Fair', 3, '0'),
(5, 1, 'Poor', 4, '0');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}poller_vote`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}poller_vote` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `pollerID` int(11) NOT NULL DEFAULT '0',
  `optionID` int(11) DEFAULT NULL,
  `ipAddress` bigint(11) DEFAULT '0',
  `voteDate` int(10) NOT NULL DEFAULT '0',
  `memberID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM;



--
-- Tabelstructuur voor tabel `{$db_prefix}polls`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}polls` (
  `pid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `startdate` int(10) DEFAULT NULL,
  `choices` text,
  `starter_id` mediumint(8) NOT NULL DEFAULT '0',
  `votes` smallint(5) NOT NULL DEFAULT '0',
  `poll_question` varchar(255) DEFAULT NULL,
  `status` enum('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}poll_voters`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}poll_voters` (
  `vid` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) NOT NULL DEFAULT '',
  `votedate` int(10) NOT NULL DEFAULT '0',
  `pid` mediumint(8) NOT NULL DEFAULT '0',
  `memberid` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`vid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}posts`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topicid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `added` int(10) DEFAULT NULL,
  `body` text,
  `editedby` int(10) unsigned NOT NULL DEFAULT '0',
  `editedat` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `topicid` (`topicid`),
  KEY `userid` (`userid`),
  FULLTEXT KEY `body` (`body`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}profile_status`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}profile_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL DEFAULT '0',
  `last_status` varchar(140) NOT NULL,
  `last_update` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}quiz`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}quiz` (
  `qid` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `Question` text,
  `opt1` text,
  `opt2` text,
  `opt3` text,
  `opt4` text,
  `woptcode` varchar(5) default NULL,
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM;


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}ratings`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}ratings` (
  `infohash` char(40) NOT NULL DEFAULT '',
  `userid` int(10) unsigned NOT NULL DEFAULT '1',
  `rating` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `added` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `infohash` (`infohash`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}readposts`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}readposts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `topicid` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpostread` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `topicid` (`topicid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}recommended`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}recommended` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_hash` varchar(40) NOT NULL DEFAULT '',
  `user_name` varchar(40) NOT NULL DEFAULT 'anonymous',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}reports`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `addedby` int(10) unsigned NOT NULL DEFAULT '0',
  `votedfor` varchar(50) DEFAULT NULL,
  `type` enum('torrent','user') NOT NULL DEFAULT 'torrent',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `dealtby` int(10) unsigned NOT NULL DEFAULT '0',
  `dealtwith` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}reputation`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}reputation` (
  `reputationid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `whoadded` int(10) NOT NULL DEFAULT '0',
  `dateadd` int(10) NOT NULL DEFAULT '0',
  `userid` mediumint(8) NOT NULL DEFAULT '0',
  `updown` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`reputationid`),
  KEY `userid` (`userid`),
  KEY `whoadded` (`whoadded`),
  KEY `multi` (`userid`),
  KEY `dateadd` (`dateadd`)
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}reputation_settings`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}reputation_settings` (
  `id` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `rep_is_online` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `rep_adminpower` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rep_minpost` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rep_default` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rep_userrates` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rep_rdpower` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rep_pcpower` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rep_kppower` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rep_minrep` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rep_hit` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rep_maxperday` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rep_repeat` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rep_undefined` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `best_level` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Best Level',
  `good_level` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Good Level',
  `no_level` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No Level',
  `bad_level` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Bad Level',
  `worse_level` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Worse Level',
  `rep_upload` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `rep_en_sys` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `rep_pr_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '20',
  `rep_dm_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '20',
  `rep_pr` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1000',
  `rep_dm` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '-1000',
  `rep_pm_text` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'tekst',
  `rep_dm_text` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'tekst'
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}reputation_settings`
--

INSERT INTO `{$db_prefix}reputation_settings` (`id`, `rep_is_online`, `rep_adminpower`, `rep_minpost`, `rep_default`, `rep_userrates`, `rep_rdpower`, `rep_pcpower`, `rep_kppower`, `rep_minrep`, `rep_hit`, `rep_maxperday`, `rep_repeat`, `rep_undefined`, `best_level`, `good_level`, `no_level`, `bad_level`, `worse_level`, `rep_upload`, `rep_en_sys`, `rep_pr_id`, `rep_dm_id`, `rep_pr`, `rep_dm`, `rep_pm_text`, `rep_dm_text`) VALUES
('1', 'true', '10', '20', '0', '1', '1', '4', '2', '10', '15', '2', '', '3', 'Top Users Reputation', 'Good Users Reputation', 'No Reputation Yet', 'Bad Users Reputation', 'Worse Users Reputation', '10', 'false', '5', '3', '1000', '-1000', 'promote text', 'demote text');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}requests`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `request` varchar(225) DEFAULT NULL,
  `descr` text NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fulfilled` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `cat` int(10) unsigned NOT NULL DEFAULT '0',
  `filled` varchar(255) DEFAULT NULL,
  `filledby` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}rules`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `active` enum('-1','0','1') NOT NULL DEFAULT '1',
  `sort_index` int(11) NOT NULL DEFAULT '0',
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}rules_group`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}rules_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` enum('-1','0','1') NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL,
  `sort_index` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}sb`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}sb` (
  `id` int(5) NOT NULL,
  `what` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gb` varchar(20) NOT NULL,
  `points` int(20) NOT NULL,
  `date` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}searchcloud`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}searchcloud` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `searchedfor` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL,
  `howmuch` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

--
-- Tabelstructuur voor tabel `{$db_prefix}settings`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}settings` (
  `key` varchar(30) NOT NULL,
  `value` varchar(200) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}settings`
--

INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES
('name', 'xbtit dt fm v16.0 de'),
('url', 'http://127.0.0.1/dev'),
('announce', 'a:2:{i:0;s:30:"http://localhost/announce.php\r";i:1;s:30:"http://localhost:2710/announce";}'),
('email', 'admin@localhost'),
('torrentdir', 'torrents'),
('external', 'true'),
('gzip', 'true'),
('debug', 'true'),
('disable_dht', 'true'),
('livestat', 'true'),
('logactive', 'true'),
('loghistory', 'true'),
('p_announce', 'true'),
('p_scrape', 'false'),
('show_uploader', 'false'),
('usepopup', 'false'),
('default_language', '1'),
('default_charset', 'UTF-8'),
('default_style', '6'),
('max_users', '0'),
('max_torrents_per_page', '15'),
('sanity_update', '1800'),
('external_update', '1800'),
('max_announce', '1800'),
('min_announce', '300'),
('max_peers_per_announce', '50'),
('dynamic', 'false'),
('nat', 'false'),
('persist', 'false'),
('allow_override_ip', 'false'),
('countbyte', 'true'),
('peercaching', 'false'),
('maxpid_seeds', '3'),
('maxpid_leech', '1'),
('validation', 'user'),
('imagecode', 'true'),
('forum', ''),
('clocktype', 'true'),
('newslimit', '3'),
('forumlimit', '5'),
('last10limit', '5'),
('xbtt_url', 'http://localhost:2710'),
('cache_duration', '0'),
('cut_name', '0'),
('mail_type', 'php'),
('secsui_quarantine_dir', ''),
('secsui_quarantine_search_terms', '<?php,base64_decode,base64_encode,eval(,phpinfo,fopen,fread,fwrite,file_get_contents'),
('secsui_cookie_name', ''),
('secsui_quarantine_pm', '2'),
('secsui_pass_type', '1'),
('secsui_ss', ''),
('secsui_cookie_type', '1'),
('secsui_cookie_exp1', '1'),
('secsui_cookie_exp2', '3'),
('secsui_cookie_path', ''),
('secsui_cookie_domain', ''),
('secsui_cookie_items', '1-0,2-0,3-0,4-0,5-0,6-0,7-0,8-0[+]0'),
('secsui_pass_min_req', '4,0,0,0,0'),
('ipb_autoposter', '0'),
('php_log_name', 'xbtit-errors'),
('php_log_path', '/full/path/to/the/web/root/include/logs'),
('php_log_lines', '5'),
('xbtt_use', 'false'),
('ajax_poller', 'true'),
('forumblocktype', 'true'),
('bonus', '1'),
('price_vip', '750'),
('price_ct', '200'),
('price_name', '500'),
('req_prune', '30'),
('req_page', '10'),
('req_post', '1'),
('req_sb', '10'),
('req_mb', '10000'),
('req_rwon', 'true'),
('req_sbmb', 'true'),
('req_shout', 'true'),
('req_max', '100'),
('req_onoff', 'true'),
('req_number', '5'),
('req_maxon', 'true'),
('dh_unit', 'true'),
('dh_pm', 'false'),
('dh_text', 'your text here'),
('vip_set', '6'),
('vip_get', '4'),
('vip_get_one', '5'),
('vip_tekst', 'Vip Torrent Only !!'),
('vip_one', 'true'),
('UPD', '20'),
('UPB', '1'),
('UPS', '3'),
('UPG', '5'),
('UPC', 'true'),
('img_file_size', '500'),
('img_size_width', '300'),
('img_size_height', '200'),
('ghost', '900'),
('imageon', 'true'),
('uploaddir', 'torrentimg/'),
('file_limit', '1000'),
('screenon', 'true'),
('donate_upload', '1'),
('unit', 'Gb'),
('highspeed', '2500'),
('highswitch', 'false'),
('highonce', 'true'),
('timeout', '900'),
('birthday_lower_limit', '4'),
('birthday_upper_limit', '100'),
('birthday_bonus', '0.1'),
('invitation_only', 'false'),
('invitation_reqvalid', 'false'),
('invitation_expires', '7'),
('show_days', 'false'),
('child', '2'),
('grown', '5'),
('old', '10'),
('menu', 'false'),
('aann', 'false'),
('autopruneusers', 'false'),
('days_members', '30'),
('days_not_comfirm', '1'),
('email_on_prune', 'false'),
('days_to_email', '25'),
('regi', 'true'),
('regi_d', '2010-10-20'),
('regi_t', '20'),
('porncat', '18'),
('bj_blackjack_stake', '104857600'),
('bj_blackjack_prize', '1.5'),
('bj_normal_prize', '1.0'),
('dupip', 'false'),
('autolot', 'false'),
('offer', '5'),
('bandays', '2'),
('banbutton', '8'),
('ua_on', 'false'),
('oa_one_text', 'line 1'),
('oa_two_text', 'line 2'),
('oa_three_text', 'line 3'),
('oa_four_text', 'line 4'),
('hitnumber', '3'),
('scrol_tekst', 'your text here'),
('hide_language', 'visible'),
('hide_style', 'visible'),
('nscroll', 'true'),
('inv_login', 'true'),
('att_login', '5'),
('ticker_msg_1', 'testing testing'),
('ticker_msg_2', 'hello hello'),
('ticker_msg_3', 'change me now'),
('ticker_msg_4', 'blah! de blah!'),
('staff_comment', '6'),
('staff_comment_view', '6'),
('show_recommended', 'true'),
('recommended', '5'),
('hide_sblocks', 'visible'),
('autorank_fullcheck', '23'),
('adver_top', '--'),
('adver_bot', '--'),
('adver_top_on', 'false'),
('adver_bot_on', 'false'),
('smf_autotopic', 'false'),
('smf_tag', '[Post] '),
('img_don', 'don5.gif'),
('img_donm', 'don10.gif'),
('img_mal', 'user_male.png'),
('img_fem', 'user_female.png'),
('img_bir', 'birthdayboy-girl.png'),
('img_bot', 'bot.png'),
('img_par', 'banned.png'),
('img_ban', 'MemberParked.gif'),
('img_tru', 'TrustedMusicuploader.png'),
('img_trum', 'TrustedMovieUploader.png'),
('img_vip', 'VIPMusicuploader.png'),
('img_vipm', 'VIPMovieUploader.png'),
('img_war', 'Warned.png'),
('img_sta', 'admin.png'),
('img_sys', 'sysop.png'),
('img_fri', 'sitefriend.png'),
('img_jun', 'Genesisjunkie-1.png'),
('text_don', 'Donator'),
('text_donm', 'Site Safer'),
('text_mal', 'Male'),
('text_fem', 'Female'),
('text_bir', 'Birthday'),
('text_bot', 'Bot'),
('text_par', 'Banned'),
('text_ban', 'Parked'),
('text_tru', 'Trusted Musicuploader'),
('text_trum', 'Trusted MovieUploader'),
('text_vip', 'VIP Musicuploader'),
('text_vipm', 'VIP MovieUploader'),
('text_war', 'Warned'),
('text_sta', 'Staff'),
('text_sys', 'Sysop'),
('text_fri', 'Site Friend'),
('text_jun', 'Site Junkie'),
('style', 'false'),
('arc_aw', 'true'),
('arc_sb', '10'),
('arc_upl', '100'),
('snow', 'false'),
('halloween', 'false'),
('leafs', 'false'),
('flowers', 'false'),
('xmas', 'false'),
('valen', 'false'),
('don_chat', '50'),
('fix_chat', 'true'),
('ran_chat', 'name.jpg'),
('cl_on', 'false'),
('cl_te', 'text'),
('auto_feat', 'false'),
('ref_on', 'false'),
('ref_switch', 'false'),
('ref_gb', '4'),
('ref_sb', '500'),
('log_sw_dt', 'yupy'),
('magnet', 'true'),
('torday', 'true'),
('tornam', 'false'),
('price_inv', '75'),
('bling', 'true'),
('sbone', 'true'),
('sbtwo', 'true'),
('sbdrie', 'true'),
('sbvier', 'true'),
('fesbappi', '0'),
('fesecret', '0'),
('fbadmin', 'false'),
('fbon', 'false'),
('matrix', 'false'),
('irc_server', 'irc.lightirc.com'),
('irc_port', '6667'),
('irc_channel', 'test'),
('irc_lang', 'en'),
('irc_on', 'false'),
('disclaim', 'false'),
('uploff', 'false'),
('nfosw', 'true'),
('tag', 'true'),
('srss', 'true'),
('noteon', 'true'),
('up_all', 'true'),
('up_id', '8'),
('up_on', 'false'),
('pm_shit', 'true'),
('pm_tekst', 'We did add you to our Shit List because you did not follow our rules , you are under staff controll now , last change to improve your behaviour , else you will be banned for life !'),
('pms_tekst', 'We did remove you from the Shit List because your behaviour did improve , be carefull to not get your self on the Shit List again !'),
('demote', 'false'),
('slon', 'false'),
('shit_group', '10'),
('shit_group_back', '3'),
('shoutdt', 'true'),
('shoutdtav', 'true'),
('shoutdtz', 'true'),
('onav', 'true'),
('anonymous', 'false'),
('shoutline', '10'),
('shoutdel', 'true'),
('acp', 'false'),
('un1', 'admin'),
('un2', 'root'),
('pw1', 'admin'),
('pw2', 'root'),
('dm_id', '10'),
('en_sys', 'true'),
('imgsw', 'true'),
('uplang', 'true'),
('ytv', 'true'),
('imdbt', 'true'),
('imdbimg', 'false'),
('imdbmh', 'false'),
('imdbbl', 'false'),
('simtor', 'false'),
('simsw', 'true'),
('cloud', 'true'),
('event_sw', 'false'),
('event', 'test'),
('event_day', '1'),
('event_month', '10'),
('speedsw', 'true'),
('delsw', 'true'),
('googlesw', 'true'),
('google', 'analitic'),
('pmpop', 'false'),
('lastsw', 'false'),
('ssl', 'false'),
('customlang', 'custom'),
('customflag', 'vn'),
('customlanga', 'custom'),
('customflaga', 'ba'),
('customlangb', 'custom'),
('customflagb', 'be'),
('customlangc', 'custom'),
('customflagc', 'hk'),
('AFSW', 'false'),
('AFP', '3'),
('AFT', '10'),
('download_ratio', '2147483648'),
('error', 'false'),
('multie', '6'),
('uiswitch', 'true'),
('uion', 'false'),
('p1', 'false'),
('p2', 'false'),
('p3', 'true'),
('p4', 'true'),
('p5', 'false'),
('p6', 'false'),
('p7', 'false'),
('p8', 'false'),
('p9', 'false'),
('p10', 'false'),
('p11', 'false'),
('p12', 'false'),
('p13', 'false'),
('p14', 'false'),
('p15', 'false'),
('p16', 'true'),
('p17', 'true'),
('preen', '100'),
('prtwee', '110'),
('prdrie', '120'),
('prvier', '130'),
('prvijf', '140'),
('przes', '150'),
('przeven', '160'),
('pracht', '170'),
('prnegen', '180'),
('prtien', '190'),
('prelf', '200'),
('prtwaalf', '210'),
('prdertien', '220'),
('prveertien', '230'),
('prvijftien', '240'),
('przestien', '250'),
('przeventien', '260');

--
-- settings needed second part , else it don,t fill some databases anymore
--

INSERT INTO `{$db_prefix}settings` (`key`, `value`) VALUES
('sloton', 'false'),
('toup', 'false'),
('touppr', '1000'),
('logmin', 'true'),
('autotprune', 'false'),
('autotprundedays', '60'),
('aannn', 'true'),
('teams', 'true'),
('blackjack', 'true'),
('bugs', 'true'),
('helpdesk', 'true'),
('offerr', 'true'),
('subtitles', 'true'),
('colup', 'true'),
('coldown', 'true'),
('supportsw', 'true'),
('tordayy', 'true'),
('cblock', 'false'),
('thco', 'false'),
('pie', 'true'),
('ownip', 'false'),
('logisw', 'false'),
('apply_all', 'true'),
('apply_id', '8'),
('apply_on', 'false'),
('endtch', 'false'),
('orlydb', 'false'),
('imdbmenu', 'true'),
('enable_dox', 'false'),
('limit_dox', '204800'),
('dox_del', '30'),
('dox_text', 'custom text'),
('ul', '1'),
('dl', '1'),
('quizbon', '10'),
('quiz', 'false'),
('quizp', 'true'),
('caldt', 'false'),
('pmdt', 'true'),
('sbup', 'false'),
('server', 'false'),
('amenu', 'false'),
('bmenu', 'link 1'),
('cmenu', 'name 1'),
('dmenu', 'false'),
('emenu', 'link 2'),
('fmenu', 'name 2'),
('gmenu', 'false'),
('hmenu', 'link3'),
('imenu', 'name 3'),
('jmenu', 'false'),
('kmenu', 'link 4'),
('prepre', 'false'),
('lmenu', 'name 4'),
('gallery', 'true'),
('cache_version', '1'),
('gcsw', 'false'),
('owth', 'false'),
('gcsitk', 'change_me'),
('gcsekk', 'change_me');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}signup_ip_block`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}signup_ip_block` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `first_ip` double NOT NULL DEFAULT '0',
  `last_ip` double NOT NULL DEFAULT '0',
  `added` int(10) unsigned NOT NULL DEFAULT '0',
  `addedby` varchar(50) NOT NULL DEFAULT '',
  `comment` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}shitlist`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}shitlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `shit_id` int(10) unsigned NOT NULL DEFAULT '0',
  `shit_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}sticky`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}sticky` (
  `id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#bce1ac;',
  `level` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}sticky`
--

INSERT INTO `{$db_prefix}sticky` (`id`, `color`, `level`) VALUES
(1, '#bce1ac;', 6);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}style`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}style` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `style` varchar(20) NOT NULL DEFAULT '',
  `style_url` varchar(100) NOT NULL DEFAULT '',
  `style_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}style`
--

INSERT INTO `{$db_prefix}style` (`id`, `style`, `style_url`, `style_type`) VALUES
(1, 'xBtit Default', 'style/xbtit_default', 3),
(2, 'Mint', 'style/mintgreen', 3),
(3, 'Dark Lair', 'style/darklair', 3),
(4, 'Yellow Jacket', 'style/thehive', 3),
(5, 'Frosted', 'style/frosted', 3),
(6, 'XBTIT DT FM', 'style/FS-FM-DT', 1),
(7, 'BloodZone', 'style/BloodZone', 3),
(8, 'DT style', 'style/diemtheme', 1),
(9, 'Christmas', 'style/christmas', 1),
(10, 'NB007 DT FM', 'style/NB-007DTFM', 3),
(11, 'FS 23 DT FM', 'style/FS-23', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}subtitles`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}subtitles` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(99) NOT NULL DEFAULT '',
  `file` varchar(99) NOT NULL DEFAULT '',
  `imdb` varchar(200) NOT NULL DEFAULT '',
  `pic` varchar(200) NOT NULL DEFAULT '',
  `Framerate` varchar(99) NOT NULL DEFAULT '',
  `cds` int(9) NOT NULL DEFAULT '0',
  `uploader` int(9) NOT NULL DEFAULT '0',
  `downloaded` int(9) NOT NULL DEFAULT '0',
  `author` varchar(99) DEFAULT NULL,
  `hash` varchar(40) NOT NULL DEFAULT '',
  `flag` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}tasks`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}tasks` (
  `task` varchar(20) NOT NULL DEFAULT '',
  `last_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`task`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}tasks`
--

INSERT INTO `{$db_prefix}tasks` (`task`, `last_time`) VALUES
('sanity', 1350479473),
('update', 1350479144);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}teams`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}teams` (
  `id` int(10) NOT NULL auto_increment,
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `owner` int(10) NOT NULL default '0',
  `info` text,
  `name` varchar(255) default NULL,
  `image` varchar(255) default NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}teams`
--


INSERT INTO `{$db_prefix}teams` (`id`, `added`, `owner`, `info`, `name`, `image`) VALUES
(1, '0000-00-00 00:00:00', 0, '', 'none', '');
UPDATE `{$db_prefix}teams` SET `id` = '0' WHERE `id` =1;
ALTER TABLE `{$db_prefix}teams` AUTO_INCREMENT =1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}timestamps`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}timestamps` (
  `info_hash` char(40) NOT NULL DEFAULT '',
  `sequence` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  `delta` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sequence`),
  KEY `sorting` (`info_hash`)
) ENGINE=MyISAM;


--
-- Tabelstructuur voor tabel `{$db_prefix}timezone`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}timezone` (
  `difference` varchar(4) NOT NULL DEFAULT '0',
  `timezone` text NOT NULL,
  PRIMARY KEY (`difference`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}timezone`
--

INSERT INTO `{$db_prefix}timezone` (`difference`, `timezone`) VALUES
('-12', '(GMT - 12:00 hours) Enitwetok, Kwajalien'),
('-11', '(GMT - 11:00 hours) Midway Island, Samoa'),
('-10', '(GMT - 10:00 hours) Hawaii'),
('-9', '(GMT - 9:00 hours) Alaska'),
('-8', '(GMT - 8:00 hours) Pacific Time (US &amp; Canada)'),
('-7', '(GMT - 7:00 hours) Mountain Time (US &amp; Canada)'),
('-6', '(GMT - 6:00 hours) Central Time (US &amp; Canada), Mexico City'),
('-5', '(GMT - 5:00 hours) Eastern Time (US &amp; Canada), Bogota, Lima'),
('-4', '(GMT - 4:00 hours) Atlantic Time (Canada), Caracas, La Paz'),
('-3.5', '(GMT - 3:30 hours) Newfoundland'),
('-3', '(GMT - 3:00 hours) Brazil, Buenos Aires, Falkland Is.'),
('-2', '(GMT - 2:00 hours) Mid-Atlantic, Ascention Is., St Helena'),
('-1', '(GMT - 1:00 hours) Azores, Cape Verde Islands'),
('0', '(GMT) Casablanca, Dublin, London, Lisbon, Monrovia'),
('1', '(GMT + 1:00 hours) Amsterdam, Brussels, Copenhagen, Madrid, Paris'),
('2', '(GMT + 2:00 hours) Kaliningrad, South Africa'),
('3', '(GMT + 3:00 hours) Baghdad, Riyadh, Moscow, Nairobi'),
('3.5', '(GMT + 3:30 hours) Tehran'),
('4', '(GMT + 4:00 hours) Abu Dhabi, Baku, Muscat, Tbilisi'),
('4.5', '(GMT + 4:30 hours) Kabul'),
('5', '(GMT + 5:00 hours) Ekaterinburg, Karachi, Tashkent'),
('5.5', '(GMT + 5:30 hours) Bombay, Calcutta, Madras, New Delhi'),
('6', '(GMT + 6:00 hours) Almaty, Colomba, Dhaka'),
('7', '(GMT + 7:00 hours) Bangkok, Hanoi, Jakarta'),
('8', '(GMT + 8:00 hours) Hong Kong, Perth, Singapore, Taipei'),
('9', '(GMT + 9:00 hours) Osaka, Sapporo, Seoul, Tokyo, Yakutsk'),
('9.5', '(GMT + 9:30 hours) Adelaide, Darwin'),
('10', '(GMT + 10:00 hours) Melbourne, Papua New Guinea, Sydney'),
('11', '(GMT + 11:00 hours) Magadan, New Caledonia, Solomon Is.'),
('12', '(GMT + 12:00 hours) Auckland, Fiji, Marshall Island');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}topics`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}topics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(40) DEFAULT NULL,
  `locked` enum('yes','no') NOT NULL DEFAULT 'no',
  `forumid` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `sticky` enum('yes','no') NOT NULL DEFAULT 'no',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `subject` (`subject`),
  KEY `lastpost` (`lastpost`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}t_rank`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}t_rank` (
  `userid` int(11) NOT NULL,
  `old_rank` int(11) NOT NULL,
  `new_rank` int(11) NOT NULL,
  `byt` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `undone` enum('yes','no') NOT NULL DEFAULT 'no',
  `enddate` varchar(20) NOT NULL
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}userbars`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}userbars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `img` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}userbars`
--

INSERT INTO `{$db_prefix}userbars` (`id`, `description`, `img`) VALUES
(1, 'Red Bar', 'userbar_red.png'),
(2, 'Blue Bar', 'userbar_blue.png'),
(3, 'Yellow Bar', 'userbar_yellow.png'),
(4, 'Green Bar', 'userbar_green.png'),
(5, 'Black Bar', 'userbar_black.png');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}users`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `salt` varchar(20) NOT NULL DEFAULT '',
  `pass_type` enum('1','2','3','4','5','6','7') NOT NULL DEFAULT '1',
  `dupe_hash` varchar(20) NOT NULL DEFAULT '',
  `id_level` int(10) NOT NULL DEFAULT '1',
  `random` int(10) DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '',
  `language` tinyint(4) NOT NULL DEFAULT '1',
  `style` tinyint(4) NOT NULL DEFAULT '1',
  `joined` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastconnect` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lip` bigint(11) DEFAULT '0',
  `downloaded` bigint(20) DEFAULT '0',
  `uploaded` bigint(20) DEFAULT '0',
  `avatar` varchar(200) DEFAULT NULL,
  `avatar_upload` enum('yes','no') NOT NULL DEFAULT 'no',
  `avatar_upload_name` varchar(60) NOT NULL,
  `pid` varchar(32) NOT NULL DEFAULT '',
  `flag` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `topicsperpage` tinyint(3) unsigned NOT NULL DEFAULT '15',
  `postsperpage` tinyint(3) unsigned NOT NULL DEFAULT '15',
  `torrentsperpage` tinyint(3) unsigned NOT NULL DEFAULT '15',
  `profileview` int(9) NOT NULL DEFAULT '0',
  `cip` varchar(15) DEFAULT NULL,
  `time_offset` varchar(4) NOT NULL DEFAULT '0',
  `temp_email` varchar(50) NOT NULL DEFAULT '',
  `smf_fid` int(10) NOT NULL DEFAULT '0',
  `ipb_fid` int(10) NOT NULL DEFAULT '0',
  `seedbonus` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `tot_on` int(10) NOT NULL DEFAULT '0',
  `rank_switch` enum('yes','no') NOT NULL DEFAULT 'no',
  `old_rank` varchar(12) NOT NULL DEFAULT '3',
  `timed_rank` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `donor` enum('yes','no') NOT NULL DEFAULT 'no',
  `up_med` varchar(10) NOT NULL DEFAULT '0',
  `connectable` enum('yes','no','unknown') NOT NULL DEFAULT 'unknown',
  `custom_title` varchar(50) DEFAULT NULL,
  `sb` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `whereheard` varchar(255) NOT NULL,
  `rat_warn_level` varchar(10) NOT NULL DEFAULT '0',
  `rat_warn_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bandt` enum('yes','no') NOT NULL DEFAULT 'no',
  `warn` enum('yes','no') NOT NULL DEFAULT 'no',
  `warnreason` varchar(255) NOT NULL,
  `warnadded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `warns` bigint(20) DEFAULT '0',
  `warnaddedby` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `birthday_bonus` tinyint(1) NOT NULL DEFAULT '0',
  `immunity` enum('yes','no') NOT NULL DEFAULT 'no',
  `invitations` int(10) NOT NULL DEFAULT '0',
  `invited_by` int(10) NOT NULL DEFAULT '0',
  `invitedate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reputation` varchar(10) NOT NULL DEFAULT '0',
  `block_comment` enum('yes','no') DEFAULT 'no',
  `showporn` enum('yes','no') NOT NULL DEFAULT 'yes',
  `clientinfo` text NOT NULL,
  `modcomment` text NOT NULL,
  `supcomment` text NOT NULL,
  `blackjack_stats` text NOT NULL,
  `invisible` enum('yes','no') NOT NULL DEFAULT 'no',
  `browser` varchar(255) NOT NULL DEFAULT 'unknown',
  `userbar` int(11) NOT NULL DEFAULT '1',
  `usercounter` bigint(20) DEFAULT '0',
  `ban` enum('yes','no') NOT NULL DEFAULT 'no',
  `ban_added` varchar(50) NOT NULL,
  `ban_added_by` varchar(50) NOT NULL,
  `ban_comment` varchar(255) NOT NULL,
  `allowdownload` enum('yes','no') DEFAULT 'yes',
  `allowupload` enum('yes','no') DEFAULT 'yes',
  `proxy` enum('yes','no') DEFAULT 'no',
  `announce` enum('yes','no') NOT NULL DEFAULT 'no',
  `booted` enum('yes','no') NOT NULL DEFAULT 'no',
  `whybooted` varchar(255) NOT NULL,
  `addbooted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `whobooted` varchar(255) NOT NULL,
  `left_l` varchar(10) NOT NULL DEFAULT 'yes',
  `emailnot` enum('yes','no') NOT NULL DEFAULT 'no',
  `subscription` text,
  `dona` enum('yes','no') NOT NULL DEFAULT 'no',
  `donb` enum('yes','no') NOT NULL DEFAULT 'no',
  `birt` enum('yes','no') NOT NULL DEFAULT 'no',
  `mal` enum('yes','no') NOT NULL DEFAULT 'no',
  `fem` enum('yes','no') NOT NULL DEFAULT 'no',
  `bann` enum('yes','no') NOT NULL DEFAULT 'no',
  `war` enum('yes','no') NOT NULL DEFAULT 'no',
  `par` enum('yes','no') NOT NULL DEFAULT 'no',
  `bot` enum('yes','no') NOT NULL DEFAULT 'no',
  `trmu` enum('yes','no') NOT NULL DEFAULT 'no',
  `trmo` enum('yes','no') NOT NULL DEFAULT 'no',
  `vimu` enum('yes','no') NOT NULL DEFAULT 'no',
  `vimo` enum('yes','no') NOT NULL DEFAULT 'no',
  `friend` enum('yes','no') NOT NULL DEFAULT 'no',
  `junkie` enum('yes','no') NOT NULL DEFAULT 'no',
  `staff` enum('yes','no') NOT NULL DEFAULT 'no',
  `sysop` enum('yes','no') NOT NULL DEFAULT 'no',
  `parked` int(9) NOT NULL DEFAULT '0',
  `gotgift` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `trophy` varchar(10) NOT NULL DEFAULT '0',
  `referral` varchar(40) NOT NULL,
  `sbox` enum('yes','no') NOT NULL DEFAULT 'no',
  `gender` INT( 9 ) NOT NULL DEFAULT '2',
  `tor` varchar(10) NOT NULL DEFAULT 'last',
  `pchat` varchar(40) NOT NULL,
  `forumbanned` enum('yes','no') NOT NULL default 'no',
  `commentpm` enum('true','false') DEFAULT 'true' NOT NULL,
  `team` int(10) unsigned NOT NULL default '0',
  `on_topic` int(11) NOT NULL default '0',
  `on_forum` int(11) NOT NULL default '0',
  `helped` varchar(255) NOT NULL,
  `helplang` varchar(255) NOT NULL,
  `helpdesk` enum('yes','no') default 'no',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `id_level` (`id_level`),
  KEY `pid` (`pid`),
  KEY `cip` (`cip`),
  KEY `smf_fid` (`smf_fid`),
  KEY `ipb_fid` (`ipb_fid`),
  KEY `avatar_upload` (`avatar_upload`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}users`
--

INSERT INTO `{$db_prefix}users` (`id`, `username`, `password`, `salt`, `pass_type`, `dupe_hash`, `id_level`, `random`, `email`, `language`, `style`, `joined`, `lastconnect`, `lip`, `downloaded`, `uploaded`, `avatar`, `avatar_upload`, `avatar_upload_name`, `pid`, `flag`, `topicsperpage`, `postsperpage`, `torrentsperpage`, `profileview`, `cip`, `time_offset`, `temp_email`, `smf_fid`, `ipb_fid`, `seedbonus`, `tot_on`, `rank_switch`, `old_rank`, `timed_rank`, `donor`, `up_med`, `connectable`, `custom_title`, `sb`, `whereheard`, `rat_warn_level`, `rat_warn_time`, `bandt`, `warn`, `warnreason`, `warnadded`, `warns`, `warnaddedby`, `dob`, `birthday_bonus`, `immunity`, `invitations`, `invited_by`, `invitedate`, `reputation`, `block_comment`, `showporn`, `clientinfo`, `modcomment`, `supcomment`, `blackjack_stats`, `invisible`, `browser`, `userbar`, `usercounter`, `ban`, `ban_added`, `ban_added_by`, `ban_comment`, `allowdownload`, `allowupload`, `proxy`, `announce`, `booted`, `whybooted`, `addbooted`, `whobooted`, `left_l`, `emailnot`, `subscription`, `dona`, `donb`, `birt`, `mal`, `fem`, `bann`, `war`, `par`, `bot`, `trmu`, `trmo`, `vimu`, `vimo`, `friend`, `junkie`, `staff`, `sysop`, `parked`, `gotgift`, `trophy`, `referral`, `sbox`,`gender`,`tor`,`pchat`,`forumbanned`,`commentpm`,`team`,`on_topic`,`on_forum`,`helped`,`helplang`,`helpdesk`) VALUES
(1, 'Guest', '', '', '1', '', 1, 0, 'none', 1, 6, '2012-08-15 12:54:05', '2012-08-15 12:54:05', 0, 0, 0, NULL, 'no', '', '00000000000000000000000000000000', 0, 10, 10, 15, 0, '127.0.0.2', '0', '', 0, 0, 0.000000, 0, 'no', '3', '0000-00-00 00:00:00', 'no', '0', 'unknown', NULL, 0.000000, '', '0', '0000-00-00 00:00:00', 'no', 'no', '', '0000-00-00 00:00:00', 0, '', '0000-00-00', 0, 'no', 0, 0, '0000-00-00 00:00:00', '0', 'no', 'yes', '', '', '', '', 'no', 'Mozilla/5.0 (Windows NT 5.1; rv:15.0) Gecko/20100101 Firefox/15.0.1', 1, 0, 'no', '', '', '', 'yes', 'yes', 'no', 'yes', 'no', '', '0000-00-00 00:00:00', '', '', 'no', NULL, 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 0, 'no', '', 0, 'no', '2','last','','no','true',0,0,0,'','','no');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}users_level`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}users_level` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_level` int(11) NOT NULL DEFAULT '0',
  `level` varchar(50) NOT NULL DEFAULT '',
  `view_torrents` enum('yes','no') NOT NULL DEFAULT 'yes',
  `edit_torrents` enum('yes','no') NOT NULL DEFAULT 'no',
  `delete_torrents` enum('yes','no') NOT NULL DEFAULT 'no',
  `view_users` enum('yes','no') NOT NULL DEFAULT 'yes',
  `edit_users` enum('yes','no') NOT NULL DEFAULT 'no',
  `delete_users` enum('yes','no') NOT NULL DEFAULT 'no',
  `view_news` enum('yes','no') NOT NULL DEFAULT 'yes',
  `edit_news` enum('yes','no') NOT NULL DEFAULT 'no',
  `delete_news` enum('yes','no') NOT NULL DEFAULT 'no',
  `can_upload` enum('yes','no') NOT NULL DEFAULT 'no',
  `can_download` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_forum` enum('yes','no') NOT NULL DEFAULT 'yes',
  `edit_forum` enum('yes','no') NOT NULL DEFAULT 'yes',
  `delete_forum` enum('yes','no') NOT NULL DEFAULT 'no',
  `predef_level` enum('guest','validating','member','uploader','vip','moderator','admin','owner') NOT NULL DEFAULT 'guest',
  `can_be_deleted` enum('yes','no') NOT NULL DEFAULT 'yes',
  `admin_access` enum('yes','no') NOT NULL DEFAULT 'no',
  `prefixcolor` varchar(200) NOT NULL DEFAULT '',
  `suffixcolor` varchar(200) NOT NULL DEFAULT '',
  `WT` int(11) NOT NULL DEFAULT '0',
  `smf_group_mirror` int(11) NOT NULL DEFAULT '0',
  `ipb_group_mirror` int(11) NOT NULL DEFAULT '0',
  `picture` varchar(50) NOT NULL DEFAULT '0',
  `maxtorrents` int(3) NOT NULL DEFAULT '0',
  `delete_comments` enum('yes','no') NOT NULL DEFAULT 'no',
  `edit_comments` enum('yes','no') NOT NULL DEFAULT 'no',
  `view_comments` enum('yes','no') NOT NULL DEFAULT 'yes',
  `delete_shout` enum('yes','no') NOT NULL DEFAULT 'no',
  `edit_shout` enum('yes','no') NOT NULL DEFAULT 'no',
  `view_shout` enum('yes','no') NOT NULL DEFAULT 'yes',
  `auto_prune` enum('yes','no') NOT NULL DEFAULT 'no',
  `sfdownload` enum('yes','no') NOT NULL DEFAULT 'no',
  `trusted` enum('yes','no') NOT NULL DEFAULT 'no',
  `moderate_trusted` enum('yes','no') NOT NULL DEFAULT 'no',
  `autorank_state` enum('Enabled','Disabled') NOT NULL DEFAULT 'Disabled',
  `autorank_position` smallint(3) NOT NULL DEFAULT '0',
  `autorank_min_upload` bigint(20) NOT NULL DEFAULT '0',
  `autorank_minratio` decimal(5,2) NOT NULL DEFAULT '0.00',
  `autorank_smf_group_mirror` int(10) NOT NULL DEFAULT '0',
  `show_ad` enum('yes','no') NOT NULL DEFAULT 'no',
  `fstyle` enum('yes','no') NOT NULL DEFAULT 'no',
  `speers` enum('yes','no') NOT NULL DEFAULT 'yes',
  UNIQUE KEY `base` (`id`),
  KEY `id_level` (`id_level`),
  KEY `smf_group_mirror` (`smf_group_mirror`),
  KEY `ipb_group_mirror` (`ipb_group_mirror`)
) ENGINE=MyISAM;

--
-- Gegevens worden uitgevoerd voor tabel `{$db_prefix}users_level`
--

INSERT INTO `{$db_prefix}users_level` (`id`, `id_level`, `level`, `view_torrents`, `edit_torrents`, `delete_torrents`, `view_users`, `edit_users`, `delete_users`, `view_news`, `edit_news`, `delete_news`, `can_upload`, `can_download`, `view_forum`, `edit_forum`, `delete_forum`, `predef_level`, `can_be_deleted`, `admin_access`, `prefixcolor`, `suffixcolor`, `WT`, `smf_group_mirror`, `ipb_group_mirror`, `picture`, `maxtorrents`, `delete_comments`, `edit_comments`, `view_comments`, `delete_shout`, `edit_shout`, `view_shout`, `auto_prune`, `sfdownload`, `trusted`, `moderate_trusted`, `autorank_state`, `autorank_position`, `autorank_min_upload`, `autorank_minratio`, `autorank_smf_group_mirror`, `show_ad`, `fstyle`, `speers`) VALUES
(1, 1, 'guest', 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'guest', 'no', 'no', '', '', 0, 0, 0, '0', 0, 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'Disabled', 0, 0, 0.00, 0, 'yes', 'no', 'no'),
(2, 2, 'validating', 'yes', 'no', 'no', 'no', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'yes', 'no', 'no', 'validating', 'no', 'no', '', '', 0, 0, 0, 'userc.gif', 0, 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'Disabled', 0, 0, 0.00, 0, 'yes', 'no','no'),
(3, 3, 'Members', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'member', 'no', 'no', '<span style=''color:#8D38C9''>', '</span>', 0, 0, 0, 'leecher.gif', 10, 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'Disabled', 0, 0, 0.00, 0, 'yes', 'yes', 'yes'),
(4, 4, 'Uploader', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'uploader', 'no', 'no', '<span style=''color:#FF00FF''>', '</span>', 0, 0, 0, 'uploader.gif', 10, 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'Disabled', 0, 0, 0.00, 0, 'yes', 'no', 'yes'),
(5, 5, 'V.I.P.', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'vip', 'no', 'no', '<span style=''color:#FFE87C''>', '</span>', 0, 0, 0, 'vip.gif', 10, 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'Disabled', 0, 0, 0.00, 0, 'yes', 'yes', 'yes'),
(6, 6, 'Moderator', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'moderator', 'no', 'no', '<span style=''color: #428D67''>', '</span>', 0, 0, 0, 'mod1.gif', 10, 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'Disabled', 0, 0, 0.00, 0, 'no', 'no', 'yes'),
(7, 7, 'Administrator', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'admin', 'no', 'yes', '<span style=''color:#FF8000''>', '</span>', 0, 0, 0, 'admin1.gif', 10, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'Disabled', 0, 0, 0.00, 0, 'no', 'no', 'yes'),
(8, 8, 'Owner', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'owner', 'no', 'yes', '<span style=''color:#EE4000''>', '</span>', 0, 0, 0, 'staffleader.gif', 10, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'Disabled', 0, 0, 0.00, 0, 'yes', 'yes','yes'),
(9, 3, 'Parked', 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'member', 'yes', 'no', '<span style=''color:#663300''>', '</span>', 0, 0, 0, '0', 0, 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'Disabled', 0, 0, 0.00, 0, 'no', 'no', 'no'),
(10, 1, 'Shitlist', 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'guest', 'yes', 'no', '<span style=''color:#0022ff''>', '</span>', 0, 0, 0, 'banned.gif', 0, 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'Disabled', 0, 0, 0.00, 0, 'yes', 'no', 'no');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}videos`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}videos` (
`title` text,
`category` text,
`id` varchar( 11 ) default NULL ,
`number` int( 10 ) NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `number` )
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}warn_reasons`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}warn_reasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` enum('-1','0','1') NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `level` int(11) NOT NULL DEFAULT '12',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}wishlist`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}wishlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `torrent_id` varchar(40) NOT NULL DEFAULT '',
  `torrent_name` varchar(250) NOT NULL DEFAULT '',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM;

-- XBTT --------------------------------------------------------

create table if not exists xbt_announce_log
(
	id int not null auto_increment,
	ipa int unsigned not null,
	port int not null,
	event int not null,
	info_hash binary(20) not null,
	peer_id binary(20) not null,
	downloaded bigint unsigned not null,
	left0 bigint unsigned not null,
	uploaded bigint unsigned not null,
	uid int not null,
	mtime int not null,
	primary key (id)
) engine = myisam;

create table if not exists xbt_config
(
	name varchar(255) not null,
	value varchar(255) not null
) engine = myisam;

create table if not exists xbt_deny_from_clients
(
	peer_id char(20) not null
) engine = myisam;

create table if not exists xbt_deny_from_hosts
(
	begin int unsigned not null,
	end int unsigned not null
) engine = myisam;

create table if not exists xbt_files
(
	fid int not null auto_increment,
	info_hash binary(20) not null,
	down_multi int not null default 100,
	up_multi int not null default 100,
	leechers int not null default 0,
	seeders int not null default 0,
	completed int not null default 0,
	flags int not null default 0,
	mtime int not null,
	ctime int not null,
	primary key (fid),
	unique key (info_hash)
) engine = myisam;

create table if not exists xbt_files_users
(
	fid int not null,
	uid int not null,
	active tinyint not null,
	announced int not null,
	completed int not null,
	downloaded bigint unsigned not null,
	`left` bigint unsigned not null,
	uploaded bigint unsigned not null,
	down_rate int(11) NOT NULL ,
    up_rate int(11) NOT NULL,
    peer_id binary(8) NOT NULL,
	completed_time int not null,
	mtime int not null,
	unique key (fid, uid),
	key (uid)
) engine = myisam;

create table if not exists xbt_scrape_log
(
	id int not null auto_increment,
	ipa int unsigned not null,
	info_hash binary(20),
	uid int not null,
	mtime int not null,
	primary key (id)
) engine = myisam;

create table if not exists xbt_users
(
	uid int not null auto_increment,
	can_announce tinyint not null default 1,
	-- can_leech tinyint not null default 1,
	-- wait_time int not null default 0,
	-- peers_limit int not null default 0,
	-- torrents_limit int not null default 0,
	-- torrent_pass char(32) not null,
	torrent_pass_version int not null default 0,
	downloaded bigint unsigned not null default 0,
	uploaded bigint unsigned not null default 0,
	primary key (uid)
) engine = myisam;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `{$db_prefix}username`
--

CREATE TABLE IF NOT EXISTS `{$db_prefix}username` (
  `uid` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `org` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL
) ENGINE=MyISAM ;