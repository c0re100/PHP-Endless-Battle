SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_behaviour_check`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_behaviour_check` (
  `username` varchar(16) NOT NULL,
  `last_vflag` tinyint(4) NOT NULL,
  `last_btime` int(11) NOT NULL,
  `last_rtime` int(11) NOT NULL,
  `blitz_count` smallint(5) unsigned NOT NULL,
  `rblitz_count` smallint(5) unsigned NOT NULL,
  `last_login` int(11) NOT NULL,
  `time_track` int(11) NOT NULL,
  `time_state` tinyint(4) NOT NULL,
  `insomnia_count` smallint(5) unsigned NOT NULL,
  `addict_count` smallint(5) unsigned NOT NULL,
  `online_record` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 資料表格式： `v2a_phpeb_chat`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_chat` (
  `c_id` mediumint(8) unsigned NOT NULL auto_increment,
  `c_user` varchar(16) NOT NULL default '',
  `c_time` int(10) NOT NULL default '0',
  `c_msg` text NOT NULL,
  `c_type` tinyint(1) NOT NULL default '0',
  `c_tar` varchar(16) NOT NULL default '',
  PRIMARY KEY  (`c_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=big5 AUTO_INCREMENT=1 ;

--
-- 資料表格式： `v2a_phpeb_game_history`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_game_history` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `time` int(10) unsigned NOT NULL default '0',
  `history` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=big5 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `v2a_phpeb_ichat` (
  `ic_id` int(10) unsigned NOT NULL auto_increment,
  `ic_user` varchar(16) NOT NULL,
  `ic_time` int(10) NOT NULL,
  `ic_message` varchar(60) NOT NULL,
  `ic_type` tinyint(1) NOT NULL,
  `ic_target` varchar(16) NOT NULL,
  PRIMARY KEY  (`ic_id`)
) ENGINE=MEMORY  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_mining_mitem`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_mining_mitem` (
  `mining_area` varchar(4) NOT NULL,
  `mining_pid` tinyint(3) unsigned NOT NULL,
  `rate` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mining_area`,`mining_pid`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_mining_mitem`
--

INSERT INTO `v2a_phpeb_mining_mitem` (`mining_area`, `mining_pid`, `rate`) VALUES
('A1N', 2, 7000),
('A1N', 1, 5000),
('A1N', 3, 3750),
('A1N', 4, 2100),
('A1E', 1, 5000),
('A1E', 2, 7000),
('A1E', 3, 3750),
('A1E', 4, 2250),
('A1S', 1, 5000),
('A1S', 2, 6500),
('A1S', 3, 3750),
('A1S', 4, 2500),
('A1W', 1, 5000),
('A1W', 2, 6500),
('A1W', 3, 3750),
('A1W', 4, 2500),
('A2N', 1, 2500),
('A2N', 2, 7500),
('A2N', 3, 3750),
('A2N', 4, 2500),
('A2E', 1, 0),
('A2E', 2, 8500),
('A2E', 3, 3750),
('A2E', 4, 2500),
('A2S', 1, 2500),
('A2S', 2, 7500),
('A2S', 3, 4125),
('A2S', 4, 2500),
('A2W', 1, 2500),
('A2W', 2, 7500),
('A2W', 3, 3750),
('A2W', 4, 2500),
('A3N', 1, 5000),
('A3N', 2, 7000),
('A3N', 3, 3750),
('A3N', 4, 2250),
('A3E', 1, 5000),
('A3E', 2, 7000),
('A3E', 3, 3750),
('A3E', 4, 2250),
('A3S', 1, 2500),
('A3S', 2, 7500),
('A3S', 3, 3750),
('A3S', 4, 2500),
('A3W', 1, 2500),
('A3W', 2, 7500),
('A3W', 3, 3750),
('A3W', 4, 2500),
('B1N', 1, 10000),
('B1N', 2, 0),
('B1N', 3, 5207),
('B1N', 4, 2534),
('B1E', 1, 9736),
('B1E', 2, 0),
('B1E', 3, 5182),
('B1E', 4, 2536),
('B1S', 1, 8376),
('B1S', 2, 0),
('B1S', 3, 4745),
('B1S', 4, 2502),
('B1W', 1, 8684),
('B1W', 2, 0),
('B1W', 3, 5296),
('B1W', 4, 2656),
('B2N', 1, 10000),
('B2N', 2, 0),
('B2N', 3, 5000),
('B2N', 4, 2250),
('B2E', 1, 10000),
('B2E', 2, 0),
('B2E', 3, 5816),
('B2E', 4, 2593),
('B2S', 1, 8908),
('B2S', 2, 0),
('B2S', 3, 5778),
('B2S', 4, 2076),
('B2W', 1, 10000),
('B2W', 2, 0),
('B2W', 3, 5000),
('B2W', 4, 1875),
('B3N', 1, 9000),
('B3N', 2, 0),
('B3N', 3, 4500),
('B3N', 4, 1875),
('B3E', 1, 9000),
('B3E', 2, 5000),
('B3E', 3, 4500),
('B3E', 4, 1875),
('B3S', 1, 9000),
('B3S', 2, 0),
('B3S', 3, 4500),
('B3S', 4, 1875),
('B3W', 1, 9000),
('B3W', 2, 0),
('B3W', 3, 4500),
('B3W', 4, 1875),
('C1N', 1, 7500),
('C1N', 2, 0),
('C1N', 3, 2500),
('C1N', 4, 1250),
('C1E', 1, 7500),
('C1E', 2, 0),
('C1E', 3, 2500),
('C1E', 4, 1250),
('C1S', 1, 8250),
('C1S', 2, 0),
('C1S', 3, 3175),
('C1S', 4, 1562),
('C1W', 1, 10000),
('C1W', 2, 0),
('C1W', 3, 5000),
('C1W', 4, 2500),
('C2N', 1, 8900),
('C2N', 2, 0),
('C2N', 3, 4894),
('C2N', 4, 1869),
('C2E', 1, 9000),
('C2E', 2, 0),
('C2E', 3, 4500),
('C2E', 4, 2250),
('C2S', 1, 8784),
('C2S', 2, 0),
('C2S', 3, 5126),
('C2S', 4, 2512),
('C2W', 1, 10000),
('C2W', 2, 0),
('C2W', 3, 4188),
('C2W', 4, 1985),
('C3N', 1, 10000),
('C3N', 2, 0),
('C3N', 3, 5576),
('C3N', 4, 1907),
('C3E', 1, 8804),
('C3E', 2, 0),
('C3E', 3, 4328),
('C3E', 4, 2470),
('C3S', 1, 9500),
('C3S', 2, 0),
('C3S', 3, 4750),
('C3S', 4, 2000),
('C3W', 1, 9000),
('C3W', 2, 0),
('C3W', 3, 4500),
('C3W', 4, 1875),
('A1N', 6, 200),
('A1N', 5, 0),
('A1N', 7, 115),
('A1N', 8, 45),
('A1E', 5, 0),
('A1E', 6, 200),
('A1E', 7, 110),
('A1E', 8, 45),
('A1S', 5, 0),
('A1S', 6, 200),
('A1S', 7, 100),
('A1S', 8, 45),
('A1W', 5, 0),
('A1W', 6, 200),
('A1W', 7, 115),
('A1W', 8, 45),
('A2N', 5, 0),
('A2N', 6, 225),
('A2N', 7, 115),
('A2N', 8, 37),
('A2E', 5, 0),
('A2E', 6, 200),
('A2E', 7, 130),
('A2E', 8, 25),
('A2S', 5, 0),
('A2S', 6, 200),
('A2S', 7, 115),
('A2S', 8, 37),
('A2W', 5, 0),
('A2W', 6, 200),
('A2W', 7, 115),
('A2W', 8, 37),
('A3N', 5, 0),
('A3N', 6, 225),
('A3N', 7, 115),
('A3N', 8, 45),
('A3E', 5, 0),
('A3E', 6, 200),
('A3E', 7, 100),
('A3E', 8, 45),
('A3S', 5, 0),
('A3S', 6, 200),
('A3S', 7, 115),
('A3S', 8, 45),
('A3W', 5, 0),
('A3W', 6, 250),
('A3W', 7, 115),
('A3W', 8, 45),
('B1N', 5, 1059),
('B1N', 6, 281),
('B1N', 7, 54),
('B1N', 8, 42),
('B1E', 5, 1079),
('B1E', 6, 315),
('B1E', 7, 63),
('B1E', 8, 31),
('B1S', 5, 951),
('B1S', 6, 349),
('B1S', 7, 66),
('B1S', 8, 39),
('B1W', 5, 1010),
('B1W', 6, 354),
('B1W', 7, 60),
('B1W', 8, 35),
('B2N', 5, 900),
('B2N', 6, 300),
('B2N', 7, 65),
('B2N', 8, 37),
('B2E', 5, 786),
('B2E', 6, 332),
('B2E', 7, 78),
('B2E', 8, 37),
('B2S', 5, 811),
('B2S', 6, 324),
('B2S', 7, 72),
('B2S', 8, 39),
('B2W', 5, 750),
('B2W', 6, 400),
('B2W', 7, 130),
('B2W', 8, 25),
('B3N', 5, 900),
('B3N', 6, 400),
('B3N', 7, 130),
('B3N', 8, 25),
('B3E', 5, 750),
('B3E', 6, 400),
('B3E', 7, 130),
('B3E', 8, 25),
('B3S', 5, 750),
('B3S', 6, 440),
('B3S', 7, 130),
('B3S', 8, 25),
('B3W', 5, 750),
('B3W', 6, 400),
('B3W', 7, 145),
('B3W', 8, 25),
('C1N', 5, 1200),
('C1N', 6, 360),
('C1N', 7, 97),
('C1N', 8, 50),
('C1E', 5, 1000),
('C1E', 6, 360),
('C1E', 7, 97),
('C1E', 8, 56),
('C1S', 5, 1100),
('C1S', 6, 380),
('C1S', 7, 106),
('C1S', 8, 53),
('C1W', 5, 1000),
('C1W', 6, 400),
('C1W', 7, 130),
('C1W', 8, 50),
('C2N', 5, 1017),
('C2N', 6, 268),
('C2N', 7, 64),
('C2N', 8, 36),
('C2E', 5, 750),
('C2E', 6, 400),
('C2E', 7, 130),
('C2E', 8, 25),
('C2S', 5, 1074),
('C2S', 6, 283),
('C2S', 7, 70),
('C2S', 8, 44),
('C2W', 5, 941),
('C2W', 6, 281),
('C2W', 7, 61),
('C2W', 8, 44),
('C3N', 5, 980),
('C3N', 6, 315),
('C3N', 7, 65),
('C3N', 8, 42),
('C3E', 5, 762),
('C3E', 6, 353),
('C3E', 7, 62),
('C3E', 8, 43),
('C3S', 5, 825),
('C3S', 6, 400),
('C3S', 7, 130),
('C3S', 8, 31),
('C3W', 5, 750),
('C3W', 6, 400),
('C3W', 7, 130),
('C3W', 8, 37);

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_mining_schedule`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_mining_schedule` (
  `mining_user` varchar(16) NOT NULL,
  `mining_bills` int(10) NOT NULL default '0',
  `mining_start` int(10) NOT NULL,
  PRIMARY KEY  (`mining_user`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 資料表格式： `v2a_phpeb_mining_sitem`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_mining_sitem` (
  `mining_user` varchar(16) NOT NULL,
  `order` tinyint(3) unsigned NOT NULL,
  `area` varchar(4) NOT NULL,
  `item` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  (`mining_user`,`order`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 資料表格式： `v2a_phpeb_mining_storage`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_mining_storage` (
  `m_store_user` varchar(16) NOT NULL,
  `item` tinyint(3) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`m_store_user`,`item`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 資料表格式： `v2a_phpeb_regkeys`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_regkeys` (
  `regkey` varchar(10) NOT NULL default '',
  `username` varchar(16) NOT NULL default '',
  `status` tinyint(1) NOT NULL default '0',
  `ip` text NOT NULL,
  `id` varchar(10) NOT NULL default '0',
  `email` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`regkey`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_regkeys`
--

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_sys_chtype`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_sys_chtype` (
  `id` varchar(3) NOT NULL,
  `typelv` tinyint(2) NOT NULL,
  `name` varchar(12) NOT NULL default '',
  `atf` tinyint(2) NOT NULL default '0',
  `def` tinyint(2) NOT NULL default '0',
  `ref` tinyint(2) NOT NULL default '0',
  `taf` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`id`,`typelv`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_sys_chtype`
--

INSERT INTO `v2a_phpeb_sys_chtype` (`id`, `typelv`, `name`, `atf`, `def`, `ref`, `taf`) VALUES
('nat', 1, '一般', 0, 0, 0, 0),
('nat', 2, '一般', 2, 0, 0, 2),
('nat', 3, '一般', 4, 0, 0, 4),
('nat', 4, '一般', 4, 3, 1, 4),
('nat', 5, '一般', 5, 4, 2, 5),
('nat', 6, '一般', 6, 5, 4, 5),
('nat', 7, '一般', 6, 7, 6, 7),
('nat', 8, '一般', 7, 7, 7, 8),
('nat', 9, '一般', 9, 9, 10, 9),
('nat', 10, '一般', 11, 11, 12, 11),
('enh', 1, '強化人間Lv1', 0, 0, 0, 0),
('enh', 2, '強化人間Lv2', 0, 3, 0, 1),
('enh', 3, '強化人間Lv3', 1, 5, 0, 2),
('enh', 4, '強化人間Lv4', 2, 7, 0, 3),
('enh', 5, '強化人間Lv5', 2, 9, 1, 5),
('enh', 6, '強化人間Lv6', 3, 11, 1, 7),
('enh', 7, '強化人間Lv7', 4, 13, 3, 9),
('enh', 8, '強化人間Lv8', 6, 13, 5, 12),
('enh', 9, '強化人間Lv9', 7, 13, 6, 13),
('enh', 10, '強化人間LvX', 8, 16, 7, 14),
('ext', 1, 'Extended Lv1', 0, 0, 0, 0),
('ext', 2, 'Extended Lv2', 3, 0, 0, 1),
('ext', 3, 'Extended Lv3', 5, 1, 0, 2),
('ext', 4, 'Extended Lv4', 7, 2, 0, 3),
('ext', 5, 'Extended Lv5', 9, 2, 1, 5),
('ext', 6, 'Extended Lv6', 11, 2, 1, 7),
('ext', 7, 'Extended Lv7', 13, 2, 3, 9),
('ext', 8, 'Extended Lv8', 13, 3, 5, 12),
('ext', 9, 'Extended Lv9', 15, 3, 6, 13),
('ext', 10, 'Extended LvX', 18, 3, 9, 15),
('psy', 1, '念動力 Lv1', 0, 0, 0, 0),
('psy', 2, '念動力 Lv2', 1, 5, 1, 1),
('psy', 3, '念動力 Lv3', 1, 7, 1, 1),
('psy', 4, '念動力 Lv4', 2, 9, 2, 2),
('psy', 5, '念動力 Lv5', 3, 10, 3, 3),
('psy', 6, '念動力 Lv6', 4, 10, 5, 4),
('psy', 7, '念動力 Lv7', 6, 10, 8, 4),
('psy', 8, '念動力 Lv8', 8, 10, 11, 5),
('psy', 9, '念動力 Lv9', 9, 11, 12, 6),
('psy', 10, '念動力 LvX', 10, 12, 16, 7),
('nt', 1, 'New Type Lv1', 0, 0, 0, 0),
('nt', 2, 'New Type Lv2', 0, 2, 1, 1),
('nt', 3, 'New Type Lv3', 2, 2, 3, 1),
('nt', 4, 'New Type Lv4', 4, 2, 3, 3),
('nt', 5, 'New Type Lv5', 6, 2, 4, 4),
('nt', 6, 'New Type Lv6', 8, 2, 5, 5),
('nt', 7, 'New Type Lv7', 9, 2, 7, 6),
('nt', 8, 'New Type Lv8', 10, 2, 9, 7),
('nt', 9, 'New Type Lv9', 10, 2, 14, 10),
('nt', 10, 'New Type LvX', 10, 2, 18, 15),
('co', 1, 'CO Lv1', 0, 0, 0, 0),
('co', 2, 'CO Lv2', 2, 2, 2, 0),
('co', 3, 'CO Lv3', 2, 2, 2, 2),
('co', 4, 'CO Lv4', 4, 2, 4, 2),
('co', 5, 'CO Lv5', 6, 3, 6, 3),
('co', 6, 'CO Lv6', 8, 4, 8, 3),
('co', 7, 'CO Lv7', 9, 5, 10, 3),
('co', 8, 'CO Lv8', 10, 6, 12, 3),
('co', 9, 'CO Lv9', 12, 8, 14, 3),
('co', 10, 'CO LvX', 15, 10, 16, 4),
('nat', 12, '傳奇', 12, 11, 12, 11),
('nat', 11, '一般', 11, 11, 12, 11),
('nat', 13, '傳奇', 12, 12, 12, 12),
('nat', 14, '傳奇', 13, 12, 13, 13),
('nat', 15, '傳奇', 14, 13, 14, 14),
('nat', 16, '傳奇', 15, 15, 15, 15),
('nt', 11, 'New Type LvX', 10, 2, 18, 15),
('nt', 12, 'New Type - α', 10, 2, 19, 15),
('nt', 13, 'New Type - β', 11, 2, 20, 15),
('nt', 14, 'New Type - γ', 12, 2, 21, 16),
('nt', 15, 'New Type - Ω', 13, 3, 22, 17),
('nt', 16, 'New Type ∞', 14, 3, 24, 19),
('psy', 11, '念動力 LvX', 10, 12, 16, 7),
('psy', 12, '念動力 - α', 10, 12, 17, 7),
('psy', 13, '念動力 - β', 11, 12, 18, 7),
('psy', 14, '念動力 - γ', 12, 13, 19, 7),
('psy', 15, '念動力 - Ω', 13, 14, 20, 8),
('psy', 16, '念動力 ∞', 14, 16, 21, 9),
('co', 11, 'CO LvX', 15, 10, 16, 4),
('co', 12, 'CO - α', 16, 10, 16, 4),
('co', 13, 'CO - β', 17, 10, 17, 4),
('co', 14, 'CO - γ', 18, 11, 18, 4),
('co', 15, 'CO - Ω', 19, 12, 19, 5),
('co', 16, 'CO ∞', 20, 13, 21, 6),
('enh', 11, '強化人間LvX', 8, 16, 7, 14),
('enh', 12, '強化人間 - α', 9, 16, 7, 14),
('enh', 13, '強化人間 - β', 10, 16, 8, 14),
('enh', 14, '強化人間 - γ', 11, 16, 9, 15),
('enh', 15, '強化人間 - Ω', 12, 17, 9, 17),
('enh', 16, '強化人間 ∞', 12, 20, 9, 19),
('ext', 11, 'Extended LvX', 18, 3, 9, 15),
('ext', 12, 'Extended - α', 19, 3, 9, 15),
('ext', 13, 'Extended - β', 20, 3, 9, 16),
('ext', 14, 'Extended - γ', 21, 3, 10, 17),
('ext', 15, 'Extended - Ω', 23, 3, 11, 18),
('ext', 16, 'Extended ∞', 25, 3, 12, 20);

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_sys_map`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_sys_map` (
  `map_id` varchar(4) NOT NULL default '',
  `type` tinyint(1) NOT NULL default '0',
  `occprice` int(10) NOT NULL default '0',
  `hpmax` int(8) NOT NULL default '100000',
  `at` tinyint(3) NOT NULL default '10',
  `de` tinyint(3) NOT NULL default '10',
  `ta` tinyint(3) NOT NULL default '10',
  `max_at` tinyint(3) NOT NULL default '0',
  `max_de` tinyint(3) NOT NULL default '0',
  `max_ta` tinyint(3) NOT NULL default '0',
  `wepa` varchar(32) NOT NULL default 'FortWepA',
  `movement` mediumtext NOT NULL,
  `area` varchar(4) NOT NULL,
  PRIMARY KEY  (`map_id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_sys_map`
--

INSERT INTO `v2a_phpeb_sys_map` (`map_id`, `type`, `occprice`, `hpmax`, `at`, `de`, `ta`, `max_at`, `max_de`, `max_ta`, `wepa`, `movement`, `area`) VALUES
('A1N', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A2\nB1', 'A1'),
('A1E', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A2\nB1', 'A1'),
('A1S', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A2\nB1', 'A1'),
('A1W', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A2\nB1', 'A1'),
('A2N', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A1\nA3\nB2', 'A2'),
('A2E', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A1\nA3\nB2', 'A2'),
('A2S', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A1\nA3\nB2', 'A2'),
('A2W', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A1\nA3\nB2', 'A2'),
('A3N', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A2\nB3', 'A3'),
('A3E', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A2\nB3', 'A3'),
('A3S', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A2\nB3', 'A3'),
('A3W', 0, 5000000, 100000, 35, 48, 35, 65, 103, 65, 'FortWepE', 'A2\nB3', 'A3'),
('B1N', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'A1\nB2\nC1', 'B1'),
('B1E', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'A1\nB2\nC1', 'B1'),
('B1S', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'A1\nB2\nC1', 'B1'),
('B1W', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'A1\nB2\nC1', 'B1'),
('B2N', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'A2\nB1\nB3\nC2', 'B2'),
('B2E', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'A2\nB1\nB3\nC2', 'B2'),
('B2S', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'A2\nB1\nB3\nC2', 'B2'),
('B2W', 4, 7500000, 150000, 65, 40, 30, 105, 95, 65, 'FortWepC', 'A2\nB1\nB3\nC2', 'B2'),
('B3N', 4, 7500000, 150000, 65, 40, 30, 105, 95, 65, 'FortWepC', 'A3\nB2\nC3', 'B3'),
('B3E', 4, 7500000, 150000, 65, 40, 30, 105, 95, 65, 'FortWepC', 'A3\nB2\nC3', 'B3'),
('B3S', 4, 7500000, 150000, 65, 40, 30, 105, 95, 65, 'FortWepC', 'A3\nB2\nC3', 'B3'),
('B3W', 4, 7500000, 150000, 65, 40, 30, 105, 95, 65, 'FortWepC', 'A3\nB2\nC3', 'B3'),
('C1N', 5, 10000000, 65000, 65, 52, 60, 105, 103, 100, 'FortWepM', 'C2\nB1', 'C1'),
('C1E', 5, 10000000, 65000, 65, 52, 60, 105, 103, 100, 'FortWepM', 'C2\nB1', 'C1'),
('C1S', 5, 10000000, 65000, 65, 52, 60, 105, 103, 100, 'FortWepM', 'C2\nB1', 'C1'),
('C1W', 5, 10000000, 65000, 65, 52, 60, 105, 103, 100, 'FortWepM', 'C2\nB1', 'C1'),
('C2N', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'C1\nC3\nB2', 'C2'),
('C2E', 4, 7500000, 150000, 65, 40, 30, 105, 95, 65, 'FortWepC', 'C1\nC3\nB2', 'C2'),
('C2S', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'C1\nC3\nB2', 'C2'),
('C2W', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'C1\nC3\nB2', 'C2'),
('C3N', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'C2\nB3', 'C3'),
('C3E', 3, 5000000, 125000, 30, 44, 60, 65, 99, 100, 'FortWepS', 'C2\nB3', 'C3'),
('C3S', 4, 7500000, 150000, 65, 40, 30, 105, 95, 65, 'FortWepC', 'C2\nB3', 'C3'),
('C3W', 4, 7500000, 150000, 65, 40, 30, 105, 95, 65, 'FortWepC', 'C2\nB3', 'C3');

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_sys_ms`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_sys_ms` (
  `id` varchar(12) NOT NULL default '',
  `msname` varchar(24) NOT NULL default '',
  `price` int(10) NOT NULL default '0',
  `btype` tinyint(1) NOT NULL,
  `atf` tinyint(3) NOT NULL default '0',
  `def` tinyint(3) NOT NULL default '0',
  `ref` tinyint(3) NOT NULL default '0',
  `taf` tinyint(3) NOT NULL default '0',
  `hpfix` mediumint(6) NOT NULL default '0',
  `enfix` mediumint(6) NOT NULL default '0',
  `hprec` decimal(6,3) NOT NULL default '0.000',
  `enrec` decimal(5,3) NOT NULL default '0.000',
  `spec` varchar(40) NOT NULL,
  `needlv` tinyint(3) unsigned NOT NULL default '0',
  `image` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_sys_ms`
--

INSERT INTO `v2a_phpeb_sys_ms` (`id`, `msname`, `price`, `btype`, `atf`, `def`, `ref`, `taf`, `hpfix`, `enfix`, `hprec`, `enrec`, `spec`, `needlv`, `image`) VALUES
('0', 'No Unit', 0, 0, 0, 0, 0, 0, 0, 0, 0.000, 0.000, '', 0, 'New/none.gif'),
('101', 'G - Cannon', 550000, 0, 9, 6, 6, 8, 2750, 125, 21.000, 1.785, '', 10, '1/gcannon.gif'),
('951', 'Gottrlatan', 7450000, 0, 25, 19, 24, 27, 4200, 225, 16.000, 4.240, '', 95, '1/gotoratan.gif'),
('301', 'K&auml;mpfer', 1975000, 0, 14, 8, 11, 14, 3750, 150, 29.500, 2.750, '', 30, '1/kenpufa.gif'),
('201', 'Gundam Alex', 1950000, 0, 11, 12, 12, 12, 4000, 175, 31.500, 2.916, '', 20, 'New/Alex.png'),
('202', 'EZ-8', 1600000, 0, 12, 11, 9, 9, 3500, 160, 27.500, 2.807, '', 20, '2/ez8.gif'),
('203', 'Gundam', 1675000, 0, 11, 11, 11, 11, 3800, 150, 30.000, 2.530, '', 20, '2/gundam.gif'),
('351', 'Apsalus III', 3150000, 0, 20, 17, 1, 9, 7500, 250, 17.250, 0.023, '', 35, '2/apusarasu.gif'),
('302', 'Elmeth', 2250000, 0, 16, 9, 12, 16, 5000, 200, 37.500, 3.270, '', 30, '2/erumesu.gif'),
('501', 'Aegis Gundam', 4650000, 0, 20, 0, 24, 17, 5500, 275, 37.000, 4.365, 'SeedMode,PvPhyD,CostEN<0.05>', 50, 'New/Aegis.png'),
('451', 'Strike Gundam', 4150000, 0, 14, 0, 25, 22, 5000, 250, 26.000, 4.000, 'SeedMode,PvPhyD,CostEN<0.05>', 45, 'New/Strike.png'),
('452', 'Sword Strike', 4050000, 0, 20, 0, 17, 20, 5500, 250, 29.000, 4.000, 'SeedMode,PvPhyD,CostEN<0.05>', 45, '3/swordstrike.gif'),
('453', 'Strike Rouge', 3900000, 0, 12, 0, 22, 19, 5500, 250, 29.000, 4.000, 'SeedMode,PvPhyD,CostEN<0.05>', 45, '3/strikerouge.gif'),
('352', 'Astray Gundam Blue Frame', 3625000, 0, 16, 0, 20, 17, 5000, 225, 33.500, 3.600, 'SeedMode,PvPhyD,CostEN<0.035>', 35, '3/blueframe.gif'),
('353', 'Astray Gundam Red Frame', 3675000, 0, 20, 0, 17, 16, 5000, 250, 33.500, 3.950, 'SeedMode,PvPhyD,CostEN<0.035>', 35, '3/redframe.gif'),
('651', 'Crossbone X1', 5250000, 0, 22, 16, 24, 24, 5500, 275, 24.000, 4.500, '', 65, '3/crossbonex1.gif'),
('652', 'Crossbone X2', 5475000, 0, 24, 16, 22, 22, 5750, 275, 30.000, 4.600, '', 65, '3/crossbonex2.gif'),
('502', 'Gundam F91', 4575000, 0, 20, 4, 32, 22, 4000, 250, 10.000, 2.737, '', 50, '3/f91.gif'),
('9902', 'Z Gundam', 6925000, 1, 22, 12, 27, 20, 5000, 275, 17.000, 8.000, '', 60, '3/z.gif'),
('751', '&#8704; Gundam', 5555000, 0, 22, 19, 24, 19, 5000, 275, 50.000, 0.016, '', 75, '4/turna.gif'),
('752', 'Turn X', 5725000, 0, 25, 20, 20, 20, 5000, 275, 50.000, 0.016, '', 75, '4/turnx.gif'),
('901', 'Gundam Epyon', 6375000, 0, 25, 11, 25, 19, 5500, 275, 19.000, 5.000, '', 90, '4/epion.gif'),
('753', 'The - O', 5525000, 0, 22, 28, 11, 24, 6000, 275, 25.000, 4.583, '', 75, '4/jio.gif'),
('754', 'Gundam ZZ', 5675000, 0, 25, 19, 19, 20, 5500, 295, 21.000, 4.300, '', 75, '4/zz.gif'),
('653', 'Qubeley', 5250000, 0, 25, 11, 25, 27, 5000, 275, 27.000, 4.750, '', 65, '4/kyuberei.gif'),
('1151', 'Neue Ziel', 200000000, 1, 33, 32, 28, 32, 7500, 475, 70.000, 22.300, '', 115, '5/noie.gif'),
('1201', 'GP03D', 200000000, 1, 37, 40, 24, 27, 7750, 475, 45.000, 21.200, '', 120, '5/GP03D.gif'),
('902', 'Gundam DX', 5800000, 0, 30, 14, 17, 20, 5500, 325, 19.000, 5.000, '', 90, '5/dx.gif'),
('952', 'Vasago Gundam', 6950000, 0, 27, 14, 27, 19, 5300, 300, 21.500, 5.400, '', 95, '5/vasago.gif'),
('1051', 'V2-Assualt Buster Gundam', 80000000, 1, 27, 19, 28, 24, 5750, 300, 29.000, 15.000, '', 105, '5/v2assult.gif'),
('953', 'Master Gundam', 8325000, 0, 32, 8, 27, 40, 5000, 250, 21.500, 4.100, '', 95, '5/master.gif'),
('1101', 'Freedom Gundam', 125000000, 1, 28, 19, 32, 35, 5750, 325, 0.000, 0.018, 'SeedMode,', 110, '6/freedom.gif'),
('1052', 'Justice Gundam', 100000000, 1, 27, 20, 27, 28, 6000, 325, 0.000, 0.018, 'SeedMode,', 105, '6/justice.gif'),
('1053', 'Wing Gundam Zero-Custom', 80000000, 1, 28, 22, 32, 19, 5500, 325, 23.800, 15.000, '', 105, '6/wing0custom.gif'),
('903', 'G Gundam', 6600000, 0, 38, 8, 22, 32, 5000, 250, 18.000, 4.100, '', 90, '6/god.gif'),
('1102', 'ν Gundam', 155000000, 1, 29, 17, 30, 43, 5750, 350, 22.000, 16.500, '', 110, 'Nu/nu_s.png'),
('1253', 'Nightingale', 225000000, 1, 36, 20, 48, 39, 6500, 400, 33.000, 18.000, '', 125, '7/naitingeru.gif'),
('1251', 'Freedom Gundam METEOR', 225000000, 1, 40, 27, 40, 43, 7500, 500, 0.000, 0.020, 'SeedMode,', 125, '7/freedom_meteor.gif'),
('1202', 'Providence Gundam', 177777777, 1, 48, 16, 16, 48, 6000, 375, 0.000, 0.019, 'SeedMode,', 120, '7/providensu.gif'),
('1', 'Magella Attack', 200000, 0, 3, 1, 0, 3, 1400, 75, 25.600, 1.062, '', 0, 'New/MagellaAttack.png'),
('2', 'Type-61 Tank', 200000, 0, 3, 1, 1, 1, 1550, 75, 27.600, 1.000, '', 0, 'New/Type61.png'),
('3', 'Ball', 200000, 0, 3, 0, 1, 3, 1400, 75, 25.600, 1.071, '', 0, 'New/Ball.png'),
('51', 'Leo', 300000, 0, 3, 3, 3, 6, 2500, 90, 20.000, 1.300, '', 5, 'New/Leo.png'),
('52', 'GM', 350000, 0, 3, 4, 4, 3, 2650, 100, 21.000, 1.500, '', 5, 'New/GM.png'),
('53', 'Zaku II', 450000, 0, 6, 4, 4, 6, 2750, 120, 21.000, 1.800, '', 5, 'New/ZakuII.png'),
('151', 'GM Sniper', 850000, 0, 9, 8, 9, 14, 3000, 135, 23.300, 1.820, '', 15, 'New/GMSniper.png'),
('152', 'Gelgoog JG', 1500000, 0, 12, 6, 8, 19, 3000, 150, 25.500, 2.600, '', 15, 'New/GelgoogJG.png'),
('204', 'Gouf', 1750000, 0, 14, 6, 11, 12, 3750, 175, 30.000, 2.916, '', 20, 'New/Gouf.png'),
('303', 'Rick Dias', 2050000, 0, 19, 8, 16, 11, 3800, 170, 30.000, 2.800, '', 30, 'New/RickDias.png'),
('304', 'Efeet Custom', 2475000, 0, 19, 5, 15, 12, 3750, 200, 30.000, 3.100, 'EXAMSystem,', 30, 'New/EfeetCustom.png'),
('602', 'Blue Destiny-03', 4800000, 0, 20, 16, 24, 20, 4500, 225, 22.650, 3.688, 'EXAMSystem', 60, 'New/BD3.png'),
('454', 'S Gundam', 4000000, 0, 19, 12, 17, 22, 4250, 250, 27.000, 3.975, '', 45, 'New/Sentinel.png'),
('503', 'Gundam F90', 4350000, 0, 16, 16, 20, 22, 5000, 250, 37.000, 3.900, '', 50, 'New/F90.png'),
('504', 'Gerbera Tetra', 4400000, 0, 19, 17, 22, 22, 4250, 180, 27.000, 2.800, '', 50, 'New/GerberaTetra.png'),
('603', 'Hyaku-Shiki', 4675000, 0, 19, 12, 20, 25, 4750, 225, 25.000, 3.750, '', 60, 'other/hyaku-shiki.gif'),
('604', 'Neo Gundam', 5000000, 0, 25, 16, 22, 20, 5000, 275, 22.650, 4.500, '', 60, 'New/Neo.png'),
('605', 'Doven Wolf', 5075000, 0, 22, 16, 20, 20, 6000, 250, 24.000, 4.000, '', 60, 'New/DovenWolf.png'),
('954', 'Tallgeese III', 7750000, 0, 27, 20, 27, 27, 4750, 275, 19.000, 4.500, '', 95, 'other/tallgeese_iii.gif'),
('1054', 'Big Zam', 150000000, 1, 27, 34, 11, 17, 8500, 450, 110.000, 23.800, '', 105, 'other/bigzam.gif'),
('1351', 'Devil Gundam', 266666666, 1, 48, 35, 16, 40, 10000, 550, 0.010, 0.010, '', 135, 'other/devil.jpg'),
('102', 'Hellion', 575000, 0, 8, 6, 7, 8, 2850, 110, 24.000, 1.538, '', 10, 'New/Hellion.png'),
('153', 'GM Cannon II', 1050000, 0, 11, 12, 9, 11, 3300, 155, 26.720, 2.460, '', 15, 'New/GMCannonII.png'),
('103', 'GunTank', 600000, 0, 9, 9, 3, 6, 3200, 150, 26.900, 2.459, '', 10, 'New/GunTank.png'),
('154', 'Union Flag', 685000, 0, 12, 6, 11, 6, 3100, 125, 25.000, 2.016, '', 15, 'New/Flag.png'),
('305', 'Gundam Alex CA', 2150000, 0, 9, 18, 11, 12, 4500, 175, 35.156, 2.822, '', 30, 'New/AlexCA.png'),
('354', 'Gundam Mk-II', 2750000, 0, 19, 11, 16, 20, 4200, 235, 30.600, 3.507, '', 35, 'other/gundam_mkii.gif'),
('1001', 'Gundam Exia', 15000000, 1, 35, 20, 40, 30, 7000, 50, 50.000, 1.001, 'TransAM<En><1002>', 110, 'gundam_exia.png'),
('1002', 'Gundam Exia<br>Trans-AM', 0, 1, 105, 60, 120, 90, 7000, 50, 50.000, 0.500, 'TransAM<Ex><1003>', 120, 'gundam_exia_transam.png'),
('1003', 'Gundam Exia', 0, 1, 18, 10, 20, 15, 7000, 0, 50.000, 1.001, 'TransAM<No><1001>', 110, 'gundam_exia.png'),
('1004', '00 Gundam', 29500000, 1, 40, 28, 42, 40, 7500, 75, 60.000, 1.001, 'TransAM<En><1005>', 125, '00_gundam.gif'),
('1005', '00 Gundam<br>Trans-AM', 0, 1, 120, 84, 126, 120, 7500, 75, 60.000, 0.500, 'TransAM<Ex><1006>', 135, '00_gundam_transam.gif'),
('1006', '00 Gundam', 0, 1, 20, 14, 26, 20, 7500, 75, 60.000, 1.001, 'TransAM<No><1004>', 125, '00_gundam.gif'),
('1252', 'Hi -ν Gundam', 225000000, 1, 33, 24, 38, 50, 6250, 400, 32.000, 18.000, '', 125, '7/hiv.gif'),
('1103', 'Sazabi', 155000000, 1, 32, 14, 40, 33, 5750, 350, 22.000, 16.500, '', 110, 'Sazabi/sazabi_s.png'),
('601', 'Z Gundam', 4925000, 0, 22, 12, 27, 20, 4750, 250, 21.000, 4.545, '', 60, '3/z.gif'),
('9901', 'Gundam F91', 6575000, 1, 20, 4, 32, 22, 4250, 275, 11.000, 8.000, '', 50, '3/f91.gif'),
('9903', 'Gundam DX', 8800000, 1, 30, 14, 17, 20, 5750, 350, 17.000, 8.000, '', 90, '5/dx.gif'),
('9904', 'V2-Assualt Buster Gundam', 130000000, 1, 27, 19, 28, 24, 6000, 325, 29.000, 15.000, '', 105, '5/v2assult.gif'),
('9906', 'Wing Gundam Zero-Custom', 130000000, 1, 28, 22, 32, 19, 5750, 350, 23.800, 15.000, '', 105, '6/wing0custom.gif'),
('9907', 'Big Zam', 250000000, 1, 27, 34, 11, 17, 9000, 475, 110.000, 23.800, '', 105, 'other/bigzam.gif'),
('9905', 'Justice Gundam', 150000000, 1, 27, 20, 27, 28, 6250, 350, 0.000, 0.018, 'SeedMode,', 105, '6/justice.gif'),
('9908', 'Freedom Gundam', 175000000, 1, 28, 19, 32, 35, 6000, 350, 0.000, 0.018, 'SeedMode,', 110, '6/freedom.gif'),
('9909', 'ν Gundam', 205000000, 1, 29, 17, 30, 43, 6000, 375, 22.000, 16.500, '', 110, 'Nu/nu_s.png'),
('9910', 'Sazabi', 205000000, 1, 32, 14, 40, 33, 6000, 375, 22.000, 16.500, '', 110, 'Sazabi/sazabi_s.png'),
('9911', 'Neue Ziel', 300000000, 1, 33, 32, 28, 32, 8000, 500, 70.000, 22.300, '', 115, '5/noie.gif'),
('9912', 'GP03D', 300000000, 1, 37, 40, 24, 27, 8250, 500, 45.000, 21.200, '', 120, '5/GP03D.gif'),
('9913', 'Providence Gundam', 277777777, 1, 48, 16, 16, 48, 6250, 400, 0.000, 0.019, 'SeedMode,', 120, '7/providensu.gif'),
('9914', 'Freedom Gundam METEOR', 325000000, 1, 40, 27, 40, 43, 7750, 525, 0.000, 0.020, 'SeedMode,', 125, '7/freedom_meteor.gif'),
('9915', 'Hi -ν Gundam', 325000000, 1, 33, 24, 38, 50, 6500, 425, 32.000, 18.000, '', 125, '7/hiv.gif'),
('9916', 'Nightingale', 325000000, 1, 36, 20, 48, 39, 6750, 425, 33.000, 18.000, '', 125, '7/naitingeru.gif');

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_sys_ms_setinf`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_sys_ms_setinf` (
  `s_id` int(10) unsigned NOT NULL,
  `s_msuit` varchar(16) NOT NULL default '',
  `s_hpmax` mediumint(6) unsigned NOT NULL default '0',
  `s_enmax` mediumint(6) unsigned NOT NULL default '0',
  `s_ms_custom` varchar(255) NOT NULL default '',
  `s_wepa` varchar(255) NOT NULL default '',
  `s_wepb` varchar(255) NOT NULL default '',
  `s_wepc` varchar(255) NOT NULL default '',
  `s_eqwep` varchar(255) NOT NULL default '',
  `s_p_equip` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_sys_ms_setinf`
--

INSERT INTO `v2a_phpeb_sys_ms_setinf` (`s_id`, `s_msuit`, `s_hpmax`, `s_enmax`, `s_ms_custom`, `s_wepa`, `s_wepb`, `s_wepc`, `s_eqwep`, `s_p_equip`) VALUES
(0, '1351', 10000, 550, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '90001<!>25000'),
(1, '1101', 5750, 325, '', '405<!>500', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(2, '1001', 7000, 50, '', '90005<!>0', '0<!>0', '0<!>0', '97001<!>10000', '90004<!>25000'),
(3, '1004', 7500, 75, '', '90006<!>0', '90007<!>0', '0<!>0', '97001<!>10000', '90004<!>25000'),
(4, '1051', 5750, 300, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(5, '1052', 6000, 325, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(6, '1053', 5500, 325, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(7, '1054', 8500, 450, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(8, '1102', 5750, 350, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(9, '1103', 5750, 350, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(10, '1151', 7500, 475, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(11, '1201', 7750, 475, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(12, '1202', 6000, 375, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(13, '1251', 7500, 500, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(14, '1252', 6250, 400, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(15, '1253', 6500, 400, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(16, '9901', 4750, 275, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(17, '9902', 5000, 275, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(18, '9903', 5750, 350, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(19, '9904', 6000, 325, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(20, '9905', 6250, 350, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(21, '9906', 5750, 350, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(22, '9907', 9000, 475, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(23, '9908', 6000, 350, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(24, '9909', 6000, 375, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(25, '9910', 6000, 375, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(26, '9911', 8000, 500, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(27, '9912', 8250, 500, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(28, '9913', 6500, 400, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(29, '9914', 7750, 525, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(30, '9915', 6500, 425, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0'),
(31, '9916', 6750, 425, '', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0');

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_sys_ms_setpreq`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_sys_ms_setpreq` (
  `sp_id` int(10) unsigned NOT NULL,
  `inf_id` int(10) unsigned NOT NULL,
  `area_req` tinyint(3) unsigned NOT NULL,
  `local_ticket` smallint(5) unsigned NOT NULL,
  `global_ticket` mediumint(8) unsigned NOT NULL,
  `ticket_cost` smallint(5) unsigned NOT NULL,
  `cost` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`sp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_sys_ms_setpreq`
--

INSERT INTO `v2a_phpeb_sys_ms_setpreq` (`sp_id`, `inf_id`, `area_req`, `local_ticket`, `global_ticket`, `ticket_cost`, `cost`) VALUES
(0, 0, 3, 15666, 66666, 6666, 266666666),
(1, 1, 1, 7500, 10000, 0, 125000000),
(2, 2, 5, 17500, 150000, 15000, 350000000),
(3, 3, 15, 50000, 525000, 47500, 700000000),
(4, 4, 1, 5000, 7500, 0, 80000000),
(5, 5, 1, 5000, 7500, 0, 100000000),
(6, 6, 1, 5000, 7500, 0, 80000000),
(7, 7, 1, 5000, 7500, 5000, 150000000),
(8, 8, 1, 7500, 10000, 0, 155000000),
(9, 9, 1, 7500, 10000, 0, 155000000),
(10, 10, 1, 10000, 15000, 5000, 200000000),
(11, 11, 1, 12500, 25000, 5000, 200000000),
(12, 12, 1, 12777, 27777, 0, 177777777),
(13, 13, 1, 12500, 35000, 5000, 225000000),
(14, 14, 1, 12500, 35000, 0, 225000000),
(15, 15, 1, 12500, 35000, 0, 225000000),
(16, 16, 1, 2000, 5000, 250, 6575000),
(17, 17, 1, 2000, 5000, 250, 6925000),
(18, 18, 1, 2000, 5000, 500, 8800000),
(19, 19, 3, 20000, 100000, 2500, 130000000),
(20, 20, 3, 20000, 100000, 2500, 150000000),
(21, 21, 3, 20000, 100000, 2500, 130000000),
(22, 22, 3, 20000, 100000, 7500, 250000000),
(23, 23, 3, 25000, 100000, 2500, 175000000),
(24, 24, 3, 25000, 100000, 2500, 205000000),
(26, 26, 3, 30000, 100000, 7500, 300000000),
(25, 25, 3, 25000, 100000, 2500, 205000000),
(27, 27, 3, 30000, 100000, 7500, 300000000),
(28, 28, 3, 30000, 100000, 2500, 277777777),
(29, 29, 3, 35000, 100000, 7500, 325000000),
(30, 30, 3, 35000, 100000, 2500, 325000000),
(31, 31, 3, 35000, 100000, 2500, 325000000);

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_sys_tactfactory`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_sys_tactfactory` (
  `tact_id` varchar(12) NOT NULL default '0',
  `wep_id` varchar(16) NOT NULL default '0',
  `blueprint` varchar(16) NOT NULL,
  `grade` tinyint(2) NOT NULL default '1',
  `directions` text NOT NULL,
  `m1` varchar(16) NOT NULL default '',
  `m2` varchar(16) default NULL,
  `m3` varchar(16) default NULL,
  `m4` varchar(16) default NULL,
  `m5` varchar(16) default NULL,
  `m6` varchar(16) default NULL,
  `m7` varchar(16) default NULL,
  `m8` varchar(16) default NULL,
  `m9` varchar(16) default NULL,
  `m10` varchar(16) default NULL,
  `m11` varchar(16) default NULL,
  `m12` varchar(16) default NULL,
  `m13` varchar(16) default NULL,
  `m14` varchar(16) default NULL,
  `m15` varchar(16) default NULL,
  `m16` varchar(16) default NULL,
  `m17` varchar(16) default NULL,
  `m18` varchar(16) default NULL,
  `m19` varchar(16) default NULL,
  `m20` varchar(16) default NULL,
  `raw_materials` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`tact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_sys_tactfactory`
--

INSERT INTO `v2a_phpeb_sys_tactfactory` (`tact_id`, `wep_id`, `blueprint`, `grade`, `directions`, `m1`, `m2`, `m3`, `m4`, `m5`, `m6`, `m7`, `m8`, `m9`, `m10`, `m11`, `m12`, `m13`, `m14`, `m15`, `m16`, `m17`, `m18`, `m19`, `m20`, `raw_materials`) VALUES
('10005', '10005', '901000', 1, '剛拜訪完武器製造工場的你，發現到工場旁出現了一條長長的人龍。\r\n<br />\r\n<br />「都什麼世代了，還有這種舊時代的行為？」你心中想道。\r\n<br />\r\n<br />在好奇心的驅使下，你前往一探究竟。\r\n<br />\r\n<br />「歡迎來到工程師公會，那邊正在舉行大特賣，各種各樣的武器藍圖均在便宜出售呢！」\r\n<br />\r\n<br />「工程師公會？」\r\n<br />\r\n<br />「沒錯。這兒是任職於各大兵器製造工場的工程師們組成的公會。他們常常來這兒舉行聚會，\r\n<br />互相交流心得。運氣好的話你還可以在這兒找到一些強力裝備的製造情報啊。」\r\n<br />\r\n<br />「哦？既然是聚會的地方，那為什麼會舉行特賣會，讓這兒變得人山人海？」\r\n<br />\r\n<br />「你的問題還真是一針見血啊。你也知道，前一陣子金融黑洞才剛消失，現在全太陽系的經濟都陷入低潮。\r\n<br />為了研究資金，很多工程師也顧不得什麼職業操守，把高度機密的兵器製造藍圖偷拿出來賣，慢慢就變成了\r\n<br />這個特賣會了。」\r\n<br />\r\n<br />「原來如此...」\r\n<br />\r\n<br />「對了，我這邊剛好賣剩 <font style=\\"color: yellow;\\">青龍刀</font> 的製造藍圖，我們又這麼有緣，就算你便宜點吧。你不會說不要吧？」\r\n<br />\r\n<br />「但這是賣剩的啊...」\r\n<br />\r\n<br />看到了對方苦澀的眼神，你也不好意思拒絕了，就乖乖的拿出錢包來付款。\r\n<br />\r\n<br />「謝謝惠顧！來，隨藍圖也附贈一張有我親筆簽名的卡片，這可是有錢也買不到的啊！」\r\n<br />\r\n<br />「謝謝...」\r\n<br />\r\n<br />你不太情願地接下卡片，順道低頭看了它一眼。\r\n<br />\r\n<br />「什麼？v2Alliance首席工程師?」\r\n<br />\r\n<br />當你抬頭再次尋找這位工程師時，對方早已悄悄的離去了...', '901000', '10004', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1,3;'),
('10018', '10018', '901001', 1, '剛拜訪完武器製造工場的你，發現到工場旁出現了一條長長的人龍。\r\n<br />\r\n<br />「都什麼世代了，還有這種舊時代的行為？」你心中想道。\r\n<br />\r\n<br />在好奇心的驅使下，你前往一探究竟。\r\n<br />\r\n<br />「歡迎來到工程師公會，那邊正在舉行大特賣，各種各樣的武器藍圖均在便宜出售呢！」\r\n<br />\r\n<br />「工程師公會？」\r\n<br />\r\n<br />「沒錯。這兒是任職於各大兵器製造工場的工程師們組成的公會。他們常常來這兒舉行聚會，互相交流心得。運氣好的話你還\r\n<br />可以在這兒找到一些強力裝備的製造情報啊。」\r\n<br />\r\n<br />「哦？既然是聚會的地方，那為什麼會舉行特賣會，讓這兒變得人山人海？」\r\n<br />\r\n<br />「你的問題還真是一針見血啊。你也知道，前一陣子金融黑洞才剛消失，現在全太陽系的經濟都陷入低潮。為了研究資金，很\r\n<br />多工程師也顧不得什麼職業操守，把高度機密的兵器製造藍圖偷拿出來賣，慢慢就變成了這個特賣會了。」\r\n<br />\r\n<br />「原來如此...」\r\n<br />\r\n<br />「對了，我這邊剛好賣剩 <font style=\\"color: yellow;\\">熱能斧</font> 的製造藍圖，我們又這麼有緣，就算你便宜點吧。你不會說不要吧？」\r\n<br />\r\n<br />「但這是賣剩的啊...」\r\n<br />\r\n<br />看到了對方苦澀的眼神，你也不好意思拒絕了，就乖乖的拿出錢包來付款。\r\n<br />\r\n<br />「謝謝惠顧！來，隨藍圖也附贈一張有我親筆簽名的卡片，這可是有錢也買不到的啊！」\r\n<br />\r\n<br />「謝謝...」\r\n<br />\r\n<br />你不太情願地接下卡片，順道低頭看了它一眼。\r\n<br />\r\n<br />「什麼？v2Alliance首席工程師?」\r\n<br />\r\n<br />當你抬頭再次尋找這位工程師時，對方早已悄悄的離去了...', '901001', '10004', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1,4;'),
('10039', '10039', '901002', 1, '剛拜訪完武器製造工場的你，發現到工場旁出現了一條長長的人龍。\r\n<br />\r\n<br />「都什麼世代了，還有這種舊時代的行為？」你心中想道。\r\n<br />\r\n<br />在好奇心的驅使下，你前往一探究竟。\r\n<br />\r\n<br />「歡迎來到工程師公會，那邊正在舉行大特賣，各種各樣的武器藍圖均在便宜出售呢！」\r\n<br />\r\n<br />「工程師公會？」\r\n<br />\r\n<br />「沒錯。這兒是任職於各大兵器製造工場的工程師們組成的公會。他們常常來這兒舉行聚會，互相交流心得。運氣好的話你還\r\n<br />可以在這兒找到一些強力裝備的製造情報啊。」\r\n<br />\r\n<br />「哦？既然是聚會的地方，那為什麼會舉行特賣會，讓這兒變得人山人海？」\r\n<br />\r\n<br />「你的問題還真是一針見血啊。你也知道，前一陣子金融黑洞才剛消失，現在全太陽系的經濟都陷入低潮。為了研究資金，很\r\n<br />多工程師也顧不得什麼職業操守，把高度機密的兵器製造藍圖偷拿出來賣，慢慢就變成了這個特賣會了。」\r\n<br />\r\n<br />「原來如此...」\r\n<br />\r\n<br />「對了，我這邊剛好賣剩 <font style="color: yellow;">高出力光束薙刀</font> 的製造藍圖，我們又這麼有緣，就算你便宜點吧。你不會說不要吧？」\r\n<br />\r\n<br />「但這是賣剩的啊...」\r\n<br />\r\n<br />看到了對方苦澀的眼神，你也不好意思拒絕了，就乖乖的拿出錢包來付款。\r\n<br />\r\n<br />「謝謝惠顧！來，隨藍圖也附贈一張有我親筆簽名的卡片，這可是有錢也買不到的啊！」\r\n<br />\r\n<br />「謝謝...」\r\n<br />\r\n<br />你不太情願地接下卡片，順道低頭看了它一眼。\r\n<br />\r\n<br />「什麼？v2Alliance首席工程師?」\r\n<br />\r\n<br />當你抬頭再次尋找這位工程師時，對方早已悄悄的離去了...', '901002', '10038', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1,1;2,1;'),
('10045', '10045', '901003', 1, '剛拜訪完武器製造工場的你，發現到工場旁出現了一條長長的人龍。\r\n<br />\r\n<br />「都什麼世代了，還有這種舊時代的行為？」你心中想道。\r\n<br />\r\n<br />在好奇心的驅使下，你前往一探究竟。\r\n<br />\r\n<br />「歡迎來到工程師公會，那邊正在舉行大特賣，各種各樣的武器藍圖均在便宜出售呢！」\r\n<br />\r\n<br />「工程師公會？」\r\n<br />\r\n<br />「沒錯。這兒是任職於各大兵器製造工場的工程師們組成的公會。他們常常來這兒舉行聚會，互相交流心得。運氣好的話你還\r\n<br />可以在這兒找到一些強力裝備的製造情報啊。」\r\n<br />\r\n<br />「哦？既然是聚會的地方，那為什麼會舉行特賣會，讓這兒變得人山人海？」\r\n<br />\r\n<br />「你的問題還真是一針見血啊。你也知道，前一陣子金融黑洞才剛消失，現在全太陽系的經濟都陷入低潮。為了研究資金，很\r\n<br />多工程師也顧不得什麼職業操守，把高度機密的兵器製造藍圖偷拿出來賣，慢慢就變成了這個特賣會了。」\r\n<br />\r\n<br />「原來如此...」\r\n<br />\r\n<br />「對了，我這邊剛好賣剩 <font style=\\"color: yellow;\\">光束劍</font> 的製造藍圖，我們又這麼有緣，就算你便宜點吧。你不會說不要吧？」\r\n<br />\r\n<br />「但這是賣剩的啊...」\r\n<br />\r\n<br />看到了對方苦澀的眼神，你也不好意思拒絕了，就乖乖的拿出錢包來付款。\r\n<br />\r\n<br />「謝謝惠顧！來，隨藍圖也附贈一張有我親筆簽名的卡片，這可是有錢也買不到的啊！」\r\n<br />\r\n<br />「謝謝...」\r\n<br />\r\n<br />你不太情願地接下卡片，順道低頭看了它一眼。\r\n<br />\r\n<br />「什麼？v2Alliance首席工程師?」\r\n<br />\r\n<br />當你抬頭再次尋找這位工程師時，對方早已悄悄的離去了...', '901003', '10037', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1,2;2,1;'),
('30012', '30012', '901004', 1, '剛拜訪完武器製造工場的你，發現到工場旁出現了一條長長的人龍。\r\n<br />\r\n<br />「都什麼世代了，還有這種舊時代的行為？」你心中想道。\r\n<br />\r\n<br />在好奇心的驅使下，你前往一探究竟。\r\n<br />\r\n<br />「歡迎來到工程師公會，那邊正在舉行大特賣，各種各樣的武器藍圖均在便宜出售呢！」\r\n<br />\r\n<br />「工程師公會？」\r\n<br />\r\n<br />「沒錯。這兒是任職於各大兵器製造工場的工程師們組成的公會。他們常常來這兒舉行聚會，互相交流心得。運氣好的話你還\r\n<br />可以在這兒找到一些強力裝備的製造情報啊。」\r\n<br />\r\n<br />「哦？既然是聚會的地方，那為什麼會舉行特賣會，讓這兒變得人山人海？」\r\n<br />\r\n<br />「你的問題還真是一針見血啊。你也知道，前一陣子金融黑洞才剛消失，現在全太陽系的經濟都陷入低潮。為了研究資金，很\r\n<br />多工程師也顧不得什麼職業操守，把高度機密的兵器製造藍圖偷拿出來賣，慢慢就變成了這個特賣會了。」\r\n<br />\r\n<br />「原來如此...」\r\n<br />\r\n<br />「對了，我這邊剛好賣剩 <font style=\\"color: yellow;\\">激光火神炮</font> 的製造藍圖，我們又這麼有緣，就算你便宜點吧。你不會說不要吧？」\r\n<br />\r\n<br />「但這是賣剩的啊...」\r\n<br />\r\n<br />看到了對方苦澀的眼神，你也不好意思拒絕了，就乖乖的拿出錢包來付款。\r\n<br />\r\n<br />「謝謝惠顧！來，隨藍圖也附贈一張有我親筆簽名的卡片，這可是有錢也買不到的啊！」\r\n<br />\r\n<br />「謝謝...」\r\n<br />\r\n<br />你不太情願地接下卡片，順道低頭看了它一眼。\r\n<br />\r\n<br />「什麼？v2Alliance首席工程師?」\r\n<br />\r\n<br />當你抬頭再次尋找這位工程師時，對方早已悄悄的離去了...', '901004', '30003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1,1;2,1;'),
('30020', '30020', '901005', 1, '剛拜訪完武器製造工場的你，發現到工場旁出現了一條長長的人龍。\r\n<br />\r\n<br />「都什麼世代了，還有這種舊時代的行為？」你心中想道。\r\n<br />\r\n<br />在好奇心的驅使下，你前往一探究竟。\r\n<br />\r\n<br />「歡迎來到工程師公會，那邊正在舉行大特賣，各種各樣的武器藍圖均在便宜出售呢！」\r\n<br />\r\n<br />「工程師公會？」\r\n<br />\r\n<br />「沒錯。這兒是任職於各大兵器製造工場的工程師們組成的公會。他們常常來這兒舉行聚會，互相交流心得。運氣好的話你還\r\n<br />可以在這兒找到一些強力裝備的製造情報啊。」\r\n<br />\r\n<br />「哦？既然是聚會的地方，那為什麼會舉行特賣會，讓這兒變得人山人海？」\r\n<br />\r\n<br />「你的問題還真是一針見血啊。你也知道，前一陣子金融黑洞才剛消失，現在全太陽系的經濟都陷入低潮。為了研究資金，很\r\n<br />多工程師也顧不得什麼職業操守，把高度機密的兵器製造藍圖偷拿出來賣，慢慢就變成了這個特賣會了。」\r\n<br />\r\n<br />「原來如此...」\r\n<br />\r\n<br />「對了，我這邊剛好賣剩 <font style=\\"color: yellow;\\">突擊用機關炮</font> 的製造藍圖，我們又這麼有緣，就算你便宜點吧。你不會說不要吧？」\r\n<br />\r\n<br />「但這是賣剩的啊...」\r\n<br />\r\n<br />看到了對方苦澀的眼神，你也不好意思拒絕了，就乖乖的拿出錢包來付款。\r\n<br />\r\n<br />「謝謝惠顧！來，隨藍圖也附贈一張有我親筆簽名的卡片，這可是有錢也買不到的啊！」\r\n<br />\r\n<br />「謝謝...」\r\n<br />\r\n<br />你不太情願地接下卡片，順道低頭看了它一眼。\r\n<br />\r\n<br />「什麼？v2Alliance首席工程師?」\r\n<br />\r\n<br />當你抬頭再次尋找這位工程師時，對方早已悄悄的離去了...', '901005', '30019', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1,4;'),
('30004', '30004', '901006', 2, '剛拜訪完武器製造工場的你，發現到工場旁出現了一條長長的人龍。\r\n<br />\r\n<br />「都什麼世代了，還有這種舊時代的行為？」你心中想道。\r\n<br />\r\n<br />在好奇心的驅使下，你前往一探究竟。\r\n<br />\r\n<br />「歡迎來到工程師公會，那邊正在舉行大特賣，各種各樣的武器藍圖均在便宜出售呢！」\r\n<br />\r\n<br />「工程師公會？」\r\n<br />\r\n<br />「沒錯。這兒是任職於各大兵器製造工場的工程師們組成的公會。他們常常來這兒舉行聚會，互相交流心得。運氣好的話你還\r\n<br />可以在這兒找到一些強力裝備的製造情報啊。」\r\n<br />\r\n<br />「哦？既然是聚會的地方，那為什麼會舉行特賣會，讓這兒變得人山人海？」\r\n<br />\r\n<br />「你的問題還真是一針見血啊。你也知道，前一陣子金融黑洞才剛消失，現在全太陽系的經濟都陷入低潮。為了研究資金，很\r\n<br />多工程師也顧不得什麼職業操守，把高度機密的兵器製造藍圖偷拿出來賣，慢慢就變成了這個特賣會了。」\r\n<br />\r\n<br />「原來如此...」\r\n<br />\r\n<br />「對了，我這邊剛好賣剩 <font style=\\"color: yellow;\\">自動火神炮炮塔系統「LGELSTELLUNG」</font> 的製造藍圖，我們又這麼有緣，就算你便宜點吧。你不會說不要吧？」\r\n<br />\r\n<br />「但這是賣剩的啊...」\r\n<br />\r\n<br />看到了對方苦澀的眼神，你也不好意思拒絕了，就乖乖的拿出錢包來付款。\r\n<br />\r\n<br />「謝謝惠顧！來，隨藍圖也附贈一張有我親筆簽名的卡片，這可是有錢也買不到的啊！」\r\n<br />\r\n<br />「謝謝...」\r\n<br />\r\n<br />你不太情願地接下卡片，順道低頭看了它一眼。\r\n<br />\r\n<br />「什麼？v2Alliance首席工程師?」\r\n<br />\r\n<br />當你抬頭再次尋找這位工程師時，對方早已悄悄的離去了...', '901006', '30003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1,2;2,4;'),
('30036', '30036', '901007', 2, '剛拜訪完武器製造工場的你，發現到工場旁出現了一條長長的人龍。\r\n<br />\r\n<br />「都什麼世代了，還有這種舊時代的行為？」你心中想道。\r\n<br />\r\n<br />在好奇心的驅使下，你前往一探究竟。\r\n<br />\r\n<br />「歡迎來到工程師公會，那邊正在舉行大特賣，各種各樣的武器藍圖均在便宜出售呢！」\r\n<br />\r\n<br />「工程師公會？」\r\n<br />\r\n<br />「沒錯。這兒是任職於各大兵器製造工場的工程師們組成的公會。他們常常來這兒舉行聚會，互相交流心得。運氣好的話你還\r\n<br />可以在這兒找到一些強力裝備的製造情報啊。」\r\n<br />\r\n<br />「哦？既然是聚會的地方，那為什麼會舉行特賣會，讓這兒變得人山人海？」\r\n<br />\r\n<br />「你的問題還真是一針見血啊。你也知道，前一陣子金融黑洞才剛消失，現在全太陽系的經濟都陷入低潮。為了研究資金，很\r\n<br />多工程師也顧不得什麼職業操守，把高度機密的兵器製造藍圖偷拿出來賣，慢慢就變成了這個特賣會了。」\r\n<br />\r\n<br />「原來如此...」\r\n<br />\r\n<br />「對了，我這邊剛好賣剩 <font style=\\"color: yellow;\\">內藏式機關炮</font> 的製造藍圖，我們又這麼有緣，就算你便宜點吧。你不會說不要吧？」\r\n<br />\r\n<br />「但這是賣剩的啊...」\r\n<br />\r\n<br />看到了對方苦澀的眼神，你也不好意思拒絕了，就乖乖的拿出錢包來付款。\r\n<br />\r\n<br />「謝謝惠顧！來，隨藍圖也附贈一張有我親筆簽名的卡片，這可是有錢也買不到的啊！」\r\n<br />\r\n<br />「謝謝...」\r\n<br />\r\n<br />你不太情願地接下卡片，順道低頭看了它一眼。\r\n<br />\r\n<br />「什麼？v2Alliance首席工程師?」\r\n<br />\r\n<br />當你抬頭再次尋找這位工程師時，對方早已悄悄的離去了...', '901007', '30001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1,3;2,3;'),
('80101', '80101', '901008', 6, '這一天你又來到了工程師公會，發現了一大堆學者正認真地打量著一部殘缺不堪的MS。\r\n<br />為滿足你的好奇心，你走上前去，試圖從聽學者們的話中打聽這部MS的來歷。\r\n<br />\r\n<br />「這部以藍色為主要色系的機體是.....﹖」\r\n<br />「你這新來的﹗這就是那不分敵我都胡亂攻擊的\\"惡魔\\"啊﹗」\r\n<br />「嗯...那時他展現的非凡破壞力...簡直叫我心寒.....」\r\n<br />「不只是破壞力，就是回避力，命中率都較一般MS要高呢﹗」\r\n<br />「那為什麼會落得如此下場?」\r\n<br />「因為那個系統強行把出力提高,使機體都負擔不了......」\r\n<br />「聽說連駕駛者...都被弄得神志不清呢...」\r\n<br />「難道...這就是傳說中裝備了 <font style=\\"color: yellow\\">EXAM System</font> 的\\"Blue Destiny\\"﹗﹖」\r\n<br />「讓我把這系統給電腦掃描一下......」\r\n<br />\r\n<br />正當你幻想著自己的機體裝備EXAM System後力量是何其強大的同時，\r\n<br />你突然感到一張藍圖被塞到你手上，原來學者們都忙於研究，\r\n<br />把你當成了處理一般雜務的工作人員，著你把藍圖送到檔案室儲存。\r\n<br />\r\n<br />你當然不會放過這個機會，拿著藍圖偽裝成要送到檔案室，並打算偷偷溜走\r\n<br />但實行到一半時，你突然感到自己後領被一道何其強大的力量拉扯，就這樣被一個警衛提出公會門外﹕\r\n<br />\r\n<br />「你在這裏幹啥﹖難道你是敵國派來的間諜﹖」\r\n<br />\r\n<br />為保自己的清白，你連忙向他解釋﹕\r\n<br />\r\n<br />「嗯......是這樣的......」', '901008', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1,5;2,4;3,3;4,2;5,1;');

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_sys_tactics`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_sys_tactics` (
  `id` varchar(14) character set big5 collate big5_bin NOT NULL default '0',
  `name` varchar(10) NOT NULL default '',
  `hpc` mediumint(6) NOT NULL default '0',
  `enc` mediumint(6) NOT NULL default '0',
  `spc` tinyint(3) NOT NULL default '0',
  `atf` tinyint(3) NOT NULL default '0',
  `def` tinyint(3) NOT NULL default '0',
  `ref` tinyint(3) NOT NULL default '0',
  `taf` tinyint(3) NOT NULL default '0',
  `hitf` tinyint(3) NOT NULL default '0',
  `missf` tinyint(3) NOT NULL default '0',
  `price` int(8) NOT NULL default '0',
  `needlv` tinyint(3) NOT NULL default '0',
  `spec` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_sys_tactics`
--

INSERT INTO `v2a_phpeb_sys_tactics` (`id`, `name`, `hpc`, `enc`, `spc`, `atf`, `def`, `ref`, `taf`, `hitf`, `missf`, `price`, `needlv`, `spec`) VALUES
('0', '通常攻擊', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ''),
('StrikeA', '突擊', 0, 5, 2, 10, -2, -2, -1, 0, 0, 100000, 6, ''),
('DefCounterA', '防禦反擊', 0, 0, 2, -5, 10, -5, 0, 5, 0, 120000, 11, ''),
('QuickA', '迅速', 0, 10, 2, 0, -5, 10, -2, 0, 5, 120000, 11, ''),
('SnipeA', '狙擊', 0, 10, 5, 2, -3, -5, 10, 5, 0, 500000, 27, ''),
('StrikeB', '捨身', 100, 10, 5, 20, -5, 0, 0, 5, 5, 500000, 27, ''),
('DoubleStrike', '二連擊', 0, 0, 20, 0, 0, -5, -10, 10, 0, 1000000, 35, 'DoubleStrike'),
('TripleStrike', '三連擊', 0, 0, 40, 0, 0, -5, -10, 10, 0, 3000000, 65, 'TripleStrike'),
('AllWepStirke', '全彈發射', 100, 50, 25, 0, 0, 0, -20, 5, 0, 2500000, 56, 'AllWepStirke'),
('RaidStrike', '奇襲', 0, 5, 35, 5, 5, 20, 10, 0, 7, 4000000, 70, ''),
('MindStrike', '心眼', 0, 0, 40, 10, -5, 5, 25, 7, 0, 4000000, 70, ''),
('SenseStrike', '靈感', 0, 25, 60, 25, 0, 10, 10, 10, 10, 10000000, 80, ''),
('CounterStrike', '伺機反擊', 0, 0, 45, 0, 0, 0, 0, 5, 0, 12000000, 85, 'CounterStrike'),
('FirstStrike', '先制攻擊', 0, 30, 45, 0, 0, 5, -5, 0, 0, 12000000, 85, 'FirstStrike'),
('PrecisionStk', '精確攻擊', 0, 0, 45, -10, 0, 0, 10, 2, 0, 12000000, 85, 'PrecisionStrike');

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_sys_wep`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_sys_wep` (
  `id` varchar(16) NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `complexity` tinyint(2) NOT NULL default '0',
  `tier` tinyint(2) NOT NULL default '0',
  `range` tinyint(1) NOT NULL default '0',
  `attrb` tinyint(1) NOT NULL default '0',
  `buy` tinyint(1) NOT NULL default '0',
  `atk` mediumint(6) unsigned NOT NULL default '0',
  `hit` tinyint(3) unsigned NOT NULL default '0',
  `rd` tinyint(3) unsigned NOT NULL default '0',
  `enc` smallint(5) unsigned NOT NULL default '0',
  `price` int(10) unsigned NOT NULL default '0',
  `equip` tinyint(1) NOT NULL default '0',
  `spec` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_sys_wep`
--

INSERT INTO `v2a_phpeb_sys_wep` (`id`, `name`, `complexity`, `tier`, `range`, `attrb`, `buy`, `atk`, `hit`, `rd`, `enc`, `price`, `equip`, `spec`) VALUES
('0', '無武器', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ''),
('10001', '戰鬥小刀', 0, 1, 1, 1, 1, 425, 100, 2, 15, 40000, 0, ''),
('10002', '合金戰鬥小刀', 1, 1, 1, 1, 0, 250, 100, 4, 18, 40000, 0, ''),
('10003', '重裝合金刀', 2, 2, 1, 1, 0, 300, 100, 4, 21, 80000, 0, ''),
('10004', '重斬刀', 4, 3, 1, 1, 0, 400, 100, 4, 27, 120000, 0, ''),
('10005', '青龍刀', 6, 4, 1, 1, 0, 800, 100, 4, 64, 160000, 0, ''),
('10006', '計都羅喉劍', 9, 5, 1, 3, 0, 1250, 100, 4, 100, 200000, 0, ''),
('10007', '計都羅喉劍•暗劍殺', 11, 6, 1, 3, 0, 2125, 110, 4, 187, 240000, 0, ''),
('10012', '計都瞬獄劍', 11, 6, 1, 3, 0, 2000, 105, 4, 168, 240000, 0, 'PsyRequired'),
('10013', '天上天下無敵劍 ', 12, 7, 1, 3, 0, 2875, 105, 4, 250, 280000, 0, 'MeltA, DamA, DamB, PsyRequired'),
('10018', '熱能斧', 6, 4, 1, 1, 0, 625, 100, 4, 50, 160000, 0, 'MeltA'),
('10019', '大型熱能斧', 8, 5, 1, 1, 0, 1125, 100, 4, 90, 200000, 0, 'MeltA'),
('10020', '熱能朔月彎刀', 10, 6, 1, 1, 0, 2125, 105, 4, 180, 240000, 0, 'MeltA'),
('10031', '光束鐮刀', 10, 6, 1, 0, 0, 1650, 105, 4, 140, 240000, 0, 'MeltA'),
('10032', '大型光束鐮刀', 11, 6, 1, 0, 0, 2000, 105, 4, 170, 240000, 0, 'MeltA'),
('10037', '光束小刀', 1, 2, 1, 0, 0, 275, 100, 4, 20, 80000, 0, 'MeltA'),
('10038', '光束薙刀', 3, 3, 1, 0, 0, 725, 100, 2, 26, 120000, 0, 'MeltA'),
('10039', '高出力光束薙刀', 5, 4, 1, 0, 0, 1400, 100, 2, 50, 160000, 0, 'MeltA'),
('10040', '對裝甲刀', 6, 4, 1, 0, 0, 1750, 100, 2, 65, 160000, 0, 'MeltA'),
('10041', '光束回力刀', 8, 5, 2, 0, 0, 933, 85, 6, 95, 200000, 0, 'MeltA'),
('10042', '激光對艦刀《SCHWERT-GEWEHER》', 10, 6, 1, 0, 0, 4100, 95, 2, 164, 240000, 0, 'MeltA'),
('10043', '激光對艦刀《SCHWERT-GEWEHER》改', 11, 6, 1, 0, 0, 4100, 95, 2, 164, 240000, 0, 'MeltB'),
('10045', '光束劍', 7, 4, 1, 0, 0, 1500, 100, 2, 50, 160000, 0, 'MeltA'),
('10046', '八手光束劍', 9, 5, 1, 0, 0, 2300, 105, 2, 80, 200000, 0, 'MeltA'),
('10047', '大型光束劍', 9, 6, 1, 0, 0, 3000, 95, 2, 90, 240000, 0, 'MeltA'),
('10048', 'T-Link Crusher Sword', 9, 6, 1, 3, 0, 3490, 90, 2, 122, 240000, 0, 'MeltB, PsyRequired'),
('10049', '天上天下念動破碎劍', 5, 6, 2, 3, 0, 8300, 85, 1, 164, 240000, 0, 'MeltB, DamA, PsyRequired'),
('10054', '試作型光束劍', 9, 6, 1, 3, 0, 3700, 102, 2, 130, 240000, 0, 'MeltA, NTCustom'),
('10055', '有線誘導式光束劍', 11, 6, 2, 3, 0, 3750, 110, 2, 140, 240000, 0, 'MeltA, NTCustom'),
('10060', '高出力光束劍「Lacerta」', 9, 6, 1, 0, 0, 3400, 95, 2, 110, 240000, 0, 'MeltA'),
('10061', 'DX專用大型光束劍', 10, 6, 1, 0, 0, 3850, 95, 2, 148, 240000, 0, 'MeltA'),
('10062', '超高出力光束劍「Super Lacerta」', 11, 6, 1, 0, 0, 4400, 93, 2, 182, 240000, 0, 'MeltA'),
('10067', '背部光束切裂器', 10, 6, 1, 0, 0, 6500, 95, 1, 85, 240000, 0, 'MeltA'),
('30001', '機關炮', 0, 1, 0, 1, 1, 250, 100, 4, 20, 40000, 0, ''),
('30002', '近接防禦用機關炮', 4, 3, 1, 1, 0, 180, 105, 10, 33, 120000, 0, ''),
('30003', '火神炮', 5, 3, 1, 1, 0, 210, 110, 10, 42, 120000, 0, ''),
('30004', '自動火神砲砲塔系統 「LGELSTELLUNG」', 8, 5, 1, 1, 0, 380, 120, 10, 90, 200000, 1, 'ShootDown'),
('30005', '重力誘導機關炮', 9, 5, 0, 1, 0, 440, 100, 12, 105, 200000, 0, 'ShootDown'),
('30006', '雙重重力誘導機炮', 9, 6, 0, 1, 0, 300, 100, 24, 110, 240000, 0, 'ShootDown'),
('30012', '激光火神炮', 5, 4, 1, 3, 0, 575, 95, 8, 80, 160000, 0, 'ShootDown'),
('30013', '光子火神炮', 8, 6, 1, 3, 0, 837, 95, 8, 100, 240000, 0, 'ShootDown'),
('30019', '速射式機關炮', 3, 3, 0, 1, 0, 266, 95, 6, 32, 120000, 0, 'ShootDown'),
('30020', '突擊用機關炮', 6, 4, 0, 1, 0, 400, 100, 8, 64, 160000, 0, ''),
('30021', '重型機關炮', 8, 5, 0, 1, 0, 625, 95, 8, 80, 200000, 0, 'ShootDown'),
('30022', '格林機關炮', 9, 5, 0, 1, 0, 440, 85, 16, 100, 200000, 0, 'ShootDown'),
('30023', '雙格林機關炮', 9, 6, 0, 1, 0, 275, 85, 32, 145, 240000, 0, 'ShootDown'),
('30029', '格林光束機關炮', 9, 6, 0, 0, 0, 475, 95, 16, 135, 240000, 0, 'ShootDown'),
('30030', '雙格林光束機炮', 10, 6, 0, 0, 0, 281, 95, 32, 170, 240000, 0, 'ShootDown'),
('30036', '內藏式機關炮', 7, 5, 0, 1, 0, 1000, 110, 4, 85, 200000, 0, ''),
('30037', '對裝甲速射機炮', 8, 5, 0, 1, 0, 1000, 110, 4, 80, 200000, 0, 'DamB'),
('30038', '3連裝超高速穿甲彈', 9, 6, 0, 1, 0, 2200, 110, 3, 145, 240000, 0, 'DamA, DamB'),
('30044', '火箭炮發射器', 5, 4, 0, 1, 0, 5000, 65, 1, 68, 160000, 0, ''),
('30045', '高性能火箭炮發射器', 7, 5, 0, 1, 0, 6000, 70, 1, 85, 200000, 0, ''),
('30046', '低反動力火箭炮發射器', 8, 5, 0, 1, 0, 6500, 77, 1, 100, 200000, 0, ''),
('30047', '無反動力火箭炮發射器', 8, 6, 0, 1, 0, 7500, 80, 1, 120, 240000, 0, ''),
('30048', '完美火箭炮發射器', 9, 6, 0, 1, 0, 10000, 80, 1, 160, 240000, 0, ''),
('30054', '裝甲穿透火箭炮發射器', 8, 5, 0, 1, 0, 7500, 70, 1, 120, 200000, 0, 'DamA, DamB'),
('30055', '高速穿甲火箭炮發射器', 9, 6, 0, 1, 0, 9000, 73, 1, 130, 240000, 0, 'DamA, DamB'),
('FortWepE', '對空自動火神炮炮塔系統', 0, 0, 2, 1, 0, 2000, 80, 50, 0, 0, 0, 'AntiDam, DamA, ShootDown, FortressOnly, CannotEquip'),
('FortWepS', '密集式連裝對艦飛彈發射器群', 0, 0, 2, 2, 0, 1500, 105, 50, 0, 0, 0, 'AntiDam, Cease, ShootDown, DenseShot, FortressOnly, CannotEquip'),
('FortWepM', 'G-Bit D.O.M.E. 月面防衛系統', 0, 0, 2, 3, 0, 6000, 95, 25, 0, 0, 0, 'AntiDam, DamA, DamB, ShootDown, AntiPDef, FortressOnly, CannotEquip'),
('FortWepC', '殖民星雷射炮', 0, 0, 2, 0, 0, 200000, 75, 1, 0, 0, 0, 'AntiDam, DamA, DamB, ShootDown, AntiPDef, FortressOnly, CannotEquip'),
('901000', '青龍刀設計藍圖', 0, 0, 0, 0, 0, 0, 0, 0, 0, 16000, 0, 'Blueprint'),
('901001', '熱能斧設計藍圖', 0, 0, 0, 0, 0, 0, 0, 0, 0, 16000, 0, 'Blueprint'),
('901002', '高出力光束薙刀設計藍圖', 0, 0, 0, 0, 0, 0, 0, 0, 0, 14000, 0, 'Blueprint'),
('901003', '光束劍設計藍圖', 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 'Blueprint'),
('901004', '激光火神炮設計藍圖', 0, 0, 0, 0, 0, 0, 0, 0, 0, 14000, 0, 'Blueprint'),
('901005', '突擊用機關炮設計藍圖', 0, 0, 0, 0, 0, 0, 0, 0, 0, 16000, 0, 'Blueprint'),
('901006', '自動火神砲砲塔系統 「LGELSTELLUNG」設計藍圖', 0, 0, 0, 0, 0, 0, 0, 0, 0, 28000, 0, 'Blueprint'),
('901007', '內藏式機關炮設計藍圖', 0, 0, 0, 0, 0, 0, 0, 0, 0, 23000, 0, 'Blueprint'),
('800690', '新高達尼姆合金', 0, 0, 0, 0, 0, 0, 0, 0, 0, 250000, 0, 'RawMaterials, CannotEquip'),
('80001', 'Booster', 1, 0, 0, 0, 1, 0, 0, 0, 10, 40000, 2, 'MobA'),
('80011', '瞄準器', 2, 0, 0, 0, 1, 0, 0, 0, 14, 60000, 2, 'TarA'),
('80002', 'Mega Booster', 5, 0, 0, 0, 0, 0, 0, 0, 37, 200000, 2, 'MobB'),
('80003', 'Thruster', 9, 0, 0, 0, 0, 0, 0, 0, 105, 400000, 2, 'MobC'),
('80004', 'Hyper Thruster', 13, 0, 0, 0, 0, 0, 0, 0, 205, 1600000, 2, 'MobD'),
('80012', '照準系統', 6, 0, 0, 0, 0, 0, 0, 0, 48, 200000, 2, 'TarB'),
('80013', '高性能雷達', 10, 0, 0, 0, 0, 0, 0, 0, 124, 400000, 2, 'TarC'),
('80014', '三次元雷達', 14, 0, 0, 0, 0, 0, 0, 0, 232, 1600000, 2, 'TarD'),
('80041', '超硬鋼裝甲', 2, 0, 0, 0, 1, 0, 0, 0, 20, 60000, 2, 'DefA,ExtHP<250>'),
('80042', '月鈦合金裝甲', 5, 0, 0, 0, 0, 0, 0, 0, 40, 100000, 2, 'DefB,ExtHP<1000>'),
('80043', '超合金Z裝甲', 9, 0, 0, 0, 0, 0, 0, 0, 80, 400000, 2, 'DefC,ExtHP<2000>'),
('80044', '超合金New Z裝甲', 14, 0, 0, 0, 0, 0, 0, 0, 160, 1600000, 2, 'DefD,ExtHP<4000>'),
('80045', '超合金New Z．α裝甲', 20, 0, 0, 0, 0, 0, 0, 0, 320, 3200000, 2, 'DefE,ExtHP<10000>'),
('80061', '強力護盾', 2, 0, 0, 0, 1, 0, 0, 0, 10, 60000, 2, 'PvPhyA'),
('80062', '爆炸反應裝甲', 5, 0, 0, 0, 0, 0, 0, 0, 20, 200000, 2, 'PvPhyB'),
('80063', '高達尼姆合金裝甲', 11, 0, 0, 0, 0, 0, 0, 0, 60, 400000, 2, 'PvPhyC'),
('80064', 'P.S.裝甲', 16, 0, 0, 0, 0, 0, 0, 0, 135, 1600000, 2, 'PvPhyD'),
('80065', 'V.P.S.裝甲', 20, 0, 0, 0, 0, 0, 0, 0, 270, 3200000, 2, 'PvPhyE'),
('80071', 'Anti-Beam Coating', 2, 0, 0, 0, 1, 0, 0, 0, 10, 60000, 2, 'PvBeamA'),
('80072', 'Laminated Armor', 5, 0, 0, 0, 0, 0, 0, 0, 20, 200000, 2, 'PvBeamB'),
('80073', '能量偏向裝甲', 11, 0, 0, 0, 0, 0, 0, 0, 60, 400000, 2, 'PvBeamC'),
('80074', '對光束防禦系統「八咫鏡」', 16, 0, 0, 0, 0, 0, 0, 0, 135, 1600000, 2, 'PvBeamD'),
('80075', 'I-Field Generator', 20, 0, 0, 0, 0, 0, 0, 0, 270, 3200000, 2, 'PvBeamE'),
('80021', '噴射加速系統', 3, 0, 0, 0, 0, 0, 0, 0, 17, 100000, 2, 'Moba'),
('80022', '極速噴射加速系統', 7, 0, 0, 0, 0, 0, 0, 0, 0, 200000, 2, 'Mobb'),
('80023', '音速噴射加速系統', 11, 0, 0, 0, 0, 0, 0, 0, 0, 400000, 2, 'Mobc'),
('80024', 'Transitive FEAR', 15, 0, 0, 0, 0, 0, 0, 0, 0, 1600000, 2, 'Mobd'),
('80025', 'HiMAT System', 19, 0, 0, 0, 0, 0, 0, 0, 0, 3200000, 2, 'Mobe'),
('80081', 'λ Driver', 2, 0, 0, 0, 1, 0, 0, 0, 10, 60000, 2, 'PvUniA'),
('80082', 'Gravity Wall', 5, 0, 0, 0, 0, 0, 0, 0, 20, 200000, 2, 'PvUniB'),
('80083', 'Chakra Field', 11, 0, 0, 0, 0, 0, 0, 0, 45, 400000, 2, 'PvUniC,CostSP<4>'),
('80084', '歪曲力場', 16, 0, 0, 0, 0, 0, 0, 0, 135, 1600000, 2, 'PvUniD'),
('80085', '次元連結系統', 20, 0, 0, 0, 0, 0, 0, 0, 270, 3200000, 2, 'PvUniE'),
('80051', '光束護盾', 4, 0, 0, 0, 0, 0, 0, 0, 25, 100000, 2, 'Defa'),
('80052', 'Energy Field', 7, 0, 0, 0, 0, 0, 0, 0, 50, 200000, 2, 'Defb'),
('80053', 'Distortion Field', 11, 0, 0, 0, 0, 0, 0, 0, 100, 400000, 2, 'Defc'),
('80054', '陽電子偏向盾', 15, 0, 0, 0, 0, 0, 0, 0, 150, 1600000, 2, 'Defd'),
('80055', 'G．Territory', 20, 0, 0, 0, 0, 0, 0, 0, 225, 3200000, 2, 'Defe'),
('80101', 'EXAM System', 12, 0, 0, 0, 0, 0, 0, 0, 30, 1000000, 2, 'EXAMSystem,TarA,MobA,AtkA'),
('901008', 'EXAM System設計藍圖', 0, 0, 0, 0, 0, 0, 0, 0, 0, 113000, 0, 'Blueprint'),
('80031', 'Dual Sensor', 4, 0, 0, 0, 0, 0, 0, 0, 20, 100000, 2, 'Tara'),
('80032', 'Multi-Sensor', 8, 0, 0, 0, 0, 0, 0, 0, 0, 200000, 2, 'Tarb'),
('80033', 'Bio-Sensor', 12, 0, 0, 0, 0, 0, 0, 0, 0, 400000, 2, 'Tarc'),
('80034', 'T-Link Sensor', 16, 0, 0, 0, 0, 0, 0, 0, 0, 1600000, 2, 'Tard'),
('80035', 'Psyco-Frame', 20, 0, 0, 0, 0, 0, 0, 0, 0, 3200000, 2, 'Tare'),
('90001', 'DG細胞', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, '');

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_sys_wep_ev`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_sys_wep_ev` (
  `ev_id` int(11) NOT NULL auto_increment,
  `from_id` varchar(16) NOT NULL,
  `to_id` varchar(16) NOT NULL,
  `ev_xp` int(11) NOT NULL,
  `ev_cost` int(11) NOT NULL,
  PRIMARY KEY  (`ev_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=big5 AUTO_INCREMENT=1 ;

--
-- 列出以下資料庫的數據： `v2a_phpeb_sys_wep_ev`
--

INSERT INTO `v2a_phpeb_sys_wep_ev` (`ev_id`, `from_id`, `to_id`, `ev_xp`, `ev_cost`) VALUES
(1, '10001', '10002', 500, 0),
(2, '10002', '10003', 1000, 10000),
(3, '10003', '10004', 1000, 20000),
(4, '10005', '10006', 2000, 40000),
(5, '10006', '10007', 2000, 80000),
(6, '10006', '10012', 2000, 80000),
(7, '10018', '10019', 2000, 40000),
(8, '10019', '10020', 2000, 80000),
(9, '10019', '10031', 1000, 60000),
(10, '10031', '10032', 1000, 0),
(11, '10001', '10037', 1000, 10000),
(12, '10037', '10038', 1000, 20000),
(13, '10039', '10040', 1000, 0),
(14, '10040', '10041', 2000, 40000),
(15, '10040', '10042', 4000, 120000),
(16, '10042', '10043', 1000, 0),
(17, '10045', '10046', 2000, 40000),
(18, '10046', '10047', 2000, 80000),
(19, '10047', '10048', 1000, 0),
(20, '10048', '10049', 1000, 0),
(21, '10047', '10054', 1000, 0),
(22, '10054', '10055', 1000, 0),
(23, '10047', '10060', 750, 0),
(24, '10060', '10061', 750, 0),
(25, '10061', '10062', 1000, 0),
(26, '10045', '10067', 4000, 120000),
(27, '30001', '30002', 2000, 30000),
(28, '30002', '30003', 500, 0),
(29, '30004', '30005', 1000, 0),
(30, '30005', '30006', 2000, 80000),
(31, '30012', '30013', 4000, 120000),
(32, '30001', '30019', 2000, 30000),
(33, '30020', '30021', 2000, 40000),
(34, '30021', '30022', 1000, 0),
(35, '30022', '30023', 2000, 80000),
(36, '30022', '30029', 2000, 80000),
(37, '30029', '30030', 1000, 0),
(38, '30036', '30037', 1000, 0),
(39, '30037', '30038', 2000, 80000),
(40, '30037', '30044', 1000, 0),
(41, '30044', '30045', 2000, 40000),
(42, '30045', '30046', 1000, 0),
(43, '30046', '30047', 2000, 80000),
(44, '30047', '30048', 1000, 0),
(45, '30045', '30054', 1000, 0),
(46, '30054', '30055', 2000, 80000),
(47, '30055', '30048', 1000, 0);

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_user_bank`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_bank` (
  `username` varchar(16) NOT NULL default '',
  `status` tinyint(1) NOT NULL default '0',
  `savings` int(10) unsigned NOT NULL default '0',
  `sh_ina` varchar(255) NOT NULL default '',
  `sh_inb` varchar(255) NOT NULL default '',
  `sh_inc` varchar(255) NOT NULL default '',
  `sh_outa` varchar(255) NOT NULL default '',
  `sh_outb` varchar(255) NOT NULL default '',
  `sh_outc` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 資料表格式： `v2a_phpeb_user_bank_log`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_bank_log` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `time` int(10) NOT NULL default '0',
  `user` varchar(16) NOT NULL default '',
  `g_name` varchar(32) NOT NULL default '',
  `type` tinyint(1) NOT NULL default '0',
  `amount` int(10) unsigned NOT NULL default '0',
  `cash` int(10) unsigned NOT NULL default '0',
  `bankamt` int(10) unsigned NOT NULL default '0',
  `t_cash` int(10) unsigned NOT NULL default '0',
  `t_bankamt` int(10) unsigned NOT NULL default '0',
  `target` varchar(16) NOT NULL default '',
  `tg_name` varchar(32) NOT NULL default '',
  `safehouse` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=big5 AUTO_INCREMENT=1 ; 

--
-- 資料表格式： `v2a_phpeb_user_game_info`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_game_info` (
  `username` varchar(16) character set big5 collate big5_bin NOT NULL default '',
  `gamename` varchar(32) character set big5 collate big5_bin NOT NULL default '',
  `hp` mediumint(6) unsigned NOT NULL default '0',
  `hpmax` mediumint(6) unsigned NOT NULL default '0',
  `en` mediumint(6) unsigned NOT NULL default '0',
  `enmax` mediumint(6) unsigned NOT NULL default '0',
  `sp` float(8,5) unsigned NOT NULL default '0.00000',
  `spmax` smallint(3) unsigned NOT NULL default '1',
  `attacking` tinyint(3) unsigned NOT NULL default '1',
  `defending` tinyint(3) unsigned NOT NULL default '1',
  `reacting` tinyint(3) unsigned NOT NULL default '1',
  `targeting` tinyint(3) unsigned NOT NULL default '1',
  `ms_custom` varchar(255) NOT NULL default '',
  `level` tinyint(3) unsigned NOT NULL default '1',
  `expr` int(10) unsigned NOT NULL default '0',
  `wepa` varchar(255) NOT NULL default '0<!>0',
  `wepb` varchar(255) NOT NULL default '0<!>0',
  `wepc` varchar(255) NOT NULL default '0<!>0',
  `eqwep` varchar(255) NOT NULL default '0<!>0',
  `p_equip` varchar(255) NOT NULL default '0<!>0',
  `spec` mediumtext NOT NULL,
  `rank` mediumint(6) NOT NULL default '0',
  `rights` char(1) NOT NULL default '0',
  `organization` int(10) NOT NULL default '0',
  `org_group` char(1) NOT NULL default '0',
  `tactics` mediumtext NOT NULL,
  `last_tact` varchar(16) NOT NULL default '',
  `status` tinyint(1) NOT NULL default '0',
  `victory` mediumint(6) NOT NULL default '0',
  `v_points` mediumint(6) unsigned NOT NULL,
  PRIMARY KEY  (`username`),
  UNIQUE KEY `gamename` (`gamename`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 資料表格式： `v2a_phpeb_user_general_info`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_general_info` (
  `username` varchar(16) character set big5 collate big5_bin NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `regkey` varchar(16) character set big5 collate big5_bin NOT NULL default '',
  `cash` int(10) unsigned NOT NULL default '0',
  `bounty` int(10) unsigned NOT NULL default '0',
  `color` tinytext,
  `avatar` varchar(16) default NULL,
  `msuit` varchar(16) default NULL,
  `typech` varchar(4) NOT NULL default 'nat1',
  `hypermode` tinyint(1) NOT NULL default '0',
  `growth` smallint(4) NOT NULL,
  `coordinates` varchar(4) NOT NULL default 'A1',
  `fame` smallint(4) NOT NULL default '0',
  `request` text NOT NULL,
  `time1` int(10) NOT NULL,
  `time2` int(10) NOT NULL,
  `btltime` int(10) NOT NULL,
  `acc_status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 資料表格式： `v2a_phpeb_user_hangar`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_hangar` (
  `h_id` int(10) unsigned NOT NULL auto_increment,
  `h_user` varchar(16) NOT NULL default '',
  `h_msuit` varchar(16) NOT NULL default '',
  `h_hp` mediumint(6) unsigned NOT NULL default '0',
  `h_hpmax` mediumint(6) unsigned NOT NULL default '0',
  `h_en` mediumint(6) unsigned NOT NULL default '0',
  `h_enmax` mediumint(6) unsigned NOT NULL default '0',
  `h_ms_custom` varchar(255) NOT NULL default '',
  `h_wepa` varchar(255) NOT NULL default '',
  `h_wepb` varchar(255) NOT NULL default '',
  `h_wepc` varchar(255) NOT NULL default '',
  `h_eqwep` varchar(255) NOT NULL default '',
  `h_p_equip` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`h_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=big5 AUTO_INCREMENT=1 ;

--
-- 資料表格式： `v2a_phpeb_user_log`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_log` (
  `username` varchar(16) character set big5 collate big5_bin NOT NULL default '',
  `log1` text NOT NULL,
  `log2` text NOT NULL,
  `log3` text NOT NULL,
  `log4` text NOT NULL,
  `log5` text NOT NULL,
  `time1` int(10) NOT NULL default '0',
  `time2` int(10) NOT NULL default '0',
  `time3` int(10) NOT NULL default '0',
  `time4` int(10) NOT NULL default '0',
  `time5` int(10) NOT NULL default '0',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 資料表格式： `v2a_phpeb_user_map`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_map` (
  `map_id` varchar(4) NOT NULL default '',
  `occupied` int(10) NOT NULL default '0',
  `aname` varchar(32) NOT NULL default '',
  `development` int(10) NOT NULL default '0',
  `hp` int(8) unsigned NOT NULL default '0',
  `hpmax` int(8) unsigned NOT NULL default '0',
  `at` tinyint(3) unsigned NOT NULL default '0',
  `de` tinyint(3) unsigned NOT NULL default '0',
  `ta` tinyint(3) unsigned NOT NULL default '0',
  `wepa` varchar(32) NOT NULL default '',
  `spec` mediumtext NOT NULL,
  `defenders` varchar(67) NOT NULL,
  `tickets` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`map_id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_user_map`
--

INSERT INTO `v2a_phpeb_user_map` (`map_id`, `occupied`, `aname`, `development`, `hp`, `hpmax`, `at`, `de`, `ta`, `wepa`, `spec`, `defenders`, `tickets`) VALUES
('A1N', 0, 'A1區域 - 北部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('A1E', 0, 'A1區域 - 東部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('A1S', 0, 'A1區域 - 南部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('A1W', 0, 'A1區域 - 西部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('A2N', 0, 'A2區域 - 北部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('A2E', 0, 'A2區域 - 東部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('A2S', 0, 'A2區域 - 南部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('A2W', 0, 'A2區域 - 西部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('A3N', 0, 'A3區域 - 北部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('A3E', 0, 'A3區域 - 東部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('A3S', 0, 'A3區域 - 南部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('A3W', 0, 'A3區域 - 西部', 0, 100000, 100000, 35, 48, 35, 'FortWepE', '', '', 0),
('B1N', 0, 'B1區域 - 北部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('B1E', 0, 'B1區域 - 東部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('B1S', 0, 'B1區域 - 南部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('B1W', 0, 'B1區域 - 西部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('B2N', 0, 'B2區域 - 北部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('B2E', 0, 'B2區域 - 東部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('B2S', 0, 'B2區域 - 南部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('B2W', 0, 'B2區域 - 西部', 0, 150000, 150000, 65, 40, 30, 'FortWepC', '', '', 0),
('B3N', 0, 'B3區域 - 北部', 0, 150000, 150000, 65, 40, 30, 'FortWepC', '', '', 0),
('B3E', 0, 'B3區域 - 東部', 0, 150000, 150000, 65, 40, 30, 'FortWepC', '', '', 0),
('B3S', 0, 'B3區域 - 南部', 0, 150000, 150000, 65, 40, 30, 'FortWepC', '', '', 0),
('B3W', 0, 'B3區域 - 西部', 0, 150000, 150000, 65, 40, 30, 'FortWepC', '', '', 0),
('C1N', 0, 'C1區域 - 北部', 0, 65000, 65000, 65, 52, 60, 'FortWepM', '', '', 0),
('C1E', 0, 'C1區域 - 東部', 0, 65000, 65000, 65, 52, 60, 'FortWepM', '', '', 0),
('C1S', 0, 'C1區域 - 南部', 0, 65000, 65000, 65, 52, 60, 'FortWepM', '', '', 0),
('C1W', 0, 'C1區域 - 西部', 0, 65000, 65000, 65, 52, 60, 'FortWepM', '', '', 0),
('C2N', 0, 'C2區域 - 北部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('C2E', 0, 'C2區域 - 東部', 0, 150000, 150000, 65, 40, 30, 'FortWepC', '', '', 0),
('C2S', 0, 'C2區域 - 南部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('C2W', 0, 'C2區域 - 西部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('C3N', 0, 'C3區域 - 北部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('C3E', 0, 'C3區域 - 東部', 0, 125000, 125000, 30, 44, 60, 'FortWepS', '', '', 0),
('C3S', 0, 'C3區域 - 南部', 0, 150000, 150000, 65, 40, 30, 'FortWepC', '', '', 0),
('C3W', 0, 'C3區域 - 西部', 0, 150000, 150000, 65, 40, 30, 'FortWepC', '', '', 0);

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_user_market`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_market` (
  `id` int(15) unsigned NOT NULL auto_increment,
  `owner` varchar(16) NOT NULL default '',
  `price` int(10) unsigned NOT NULL default '0',
  `wepid` varchar(255) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `atk` mediumint(6) unsigned NOT NULL default '0',
  `hit` tinyint(3) unsigned NOT NULL default '0',
  `rd` tinyint(3) unsigned NOT NULL default '0',
  `enc` smallint(5) unsigned NOT NULL default '0',
  `spec` text NOT NULL,
  `time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5 AUTO_INCREMENT=1 ;

--
-- 列出以下資料庫的數據： `v2a_phpeb_user_market`
--


-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_user_marketb`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_marketb` (
  `id` int(15) unsigned NOT NULL auto_increment,
  `owner` varchar(16) NOT NULL default '',
  `price` int(10) unsigned NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `state` tinyint(3) unsigned NOT NULL default '0',
  `time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5 AUTO_INCREMENT=1 ;

--
-- 列出以下資料庫的數據： `v2a_phpeb_user_marketb`
--


-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_user_organization`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_organization` (
  `id` int(10) NOT NULL default '0',
  `name` varchar(32) NOT NULL default '',
  `color` varchar(7) NOT NULL default '',
  `funds` int(10) unsigned NOT NULL default '0',
  `license` tinyint(1) NOT NULL default '0',
  `request_list` mediumtext NOT NULL,
  `groupa` varchar(32) NOT NULL default '',
  `groupb` varchar(32) NOT NULL default '',
  `groupc` varchar(32) NOT NULL default '',
  `operation` varchar(32) NOT NULL default '',
  `optmissioni` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 列出以下資料庫的數據： `v2a_phpeb_user_organization`
--

INSERT INTO `v2a_phpeb_user_organization` (`id`, `name`, `color`, `funds`, `license`, `request_list`, `groupa`, `groupb`, `groupc`, `operation`, `optmissioni`) VALUES
(0, '中立組織', '#AAAAAA', 0, 0, '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_user_settings`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_settings` (
  `username` varchar(16) character set big5 collate big5_bin NOT NULL default '',
  `gen_img_dir` varchar(128) NOT NULL default '',
  `unit_img_dir` varchar(128) NOT NULL default '',
  `base_img_dir` varchar(128) NOT NULL default '',
  `show_log_num` tinyint(1) NOT NULL default '0',
  `atkonline_alert` tinyint(1) NOT NULL default '1',
  `battle_def_filter` tinyint(1) NOT NULL default '1',
  `fdis_at` tinyint(1) NOT NULL default '0',
  `fdis_de` tinyint(1) NOT NULL default '0',
  `fdis_re` tinyint(1) NOT NULL default '0',
  `fdis_ta` tinyint(1) NOT NULL default '0',
  `fdis_lv` tinyint(1) NOT NULL default '0',
  `fdis_hp` tinyint(1) NOT NULL default '0',
  `fdis_fame` tinyint(1) NOT NULL default '0',
  `fdis_bty` tinyint(1) NOT NULL default '0',
  `fdis_ms` tinyint(1) NOT NULL default '0',
  `fdis_tch` tinyint(1) NOT NULL default '0',
  `fdis_con` tinyint(1) NOT NULL default '0',
  `filter_at_min` tinyint(3) unsigned NOT NULL default '0',
  `filter_at_max` tinyint(3) unsigned NOT NULL default '0',
  `filter_de_min` tinyint(3) unsigned NOT NULL default '0',
  `filter_de_max` tinyint(3) unsigned NOT NULL default '0',
  `filter_re_min` tinyint(3) unsigned NOT NULL default '0',
  `filter_re_max` tinyint(3) unsigned NOT NULL default '0',
  `filter_ta_min` tinyint(3) unsigned NOT NULL default '0',
  `filter_ta_max` tinyint(3) unsigned NOT NULL default '0',
  `filter_lv_min` tinyint(3) unsigned NOT NULL default '0',
  `filter_lv_max` tinyint(3) unsigned NOT NULL default '0',
  `filter_hp_min` int(7) NOT NULL default '0',
  `filter_hp_max` int(7) NOT NULL default '0',
  `filter_fame_min` smallint(4) NOT NULL default '0',
  `filter_fame_max` smallint(4) NOT NULL default '0',
  `filter_bty_min` int(10) NOT NULL default '0',
  `filter_bty_max` int(10) NOT NULL default '0',
  `filter_con` tinyint(1) NOT NULL default '0',
  `filter_sort` tinyint(1) NOT NULL default '0',
  `filter_sort_asc` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

-- --------------------------------------------------------

--
-- 資料表格式： `v2a_phpeb_user_tactfactory`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_tactfactory` (
  `username` varchar(16) NOT NULL default '',
  `time` int(10) NOT NULL default '0',
  `m1` varchar(16) NOT NULL default '',
  `m2` varchar(16) NOT NULL default '',
  `m3` varchar(16) default NULL,
  `m4` varchar(16) default NULL,
  `m5` varchar(16) default NULL,
  `m6` varchar(16) default NULL,
  `m7` varchar(16) default NULL,
  `m8` varchar(16) default NULL,
  `m9` varchar(16) default NULL,
  `m10` varchar(16) default NULL,
  `m11` varchar(16) default NULL,
  `m12` varchar(16) default NULL,
  `m13` varchar(16) default NULL,
  `m14` varchar(16) default NULL,
  `m15` varchar(16) default NULL,
  `m16` varchar(16) default NULL,
  `m17` varchar(16) default NULL,
  `m18` varchar(16) default NULL,
  `m19` varchar(16) default NULL,
  `m20` varchar(16) default NULL,
  `c_wep` varchar(8) NOT NULL default '',
  `c_point` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 資料表格式： `v2a_phpeb_user_war`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_war` (
  `war_id` int(10) unsigned NOT NULL,
  `t_start` int(10) unsigned NOT NULL,
  `t_end` int(10) NOT NULL,
  `a_org` int(10) NOT NULL,
  `b_org` int(10) NOT NULL,
  `ticket_a` mediumint(5) NOT NULL,
  `ticket_b` mediumint(5) NOT NULL,
  `mission` varchar(32) NOT NULL,
  `victory` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`war_id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

--
-- 資料表格式： `v2a_phpeb_user_warehouse`
--

CREATE TABLE IF NOT EXISTS `v2a_phpeb_user_warehouse` (
  `username` varchar(16) NOT NULL default '',
  `warehouse` text NOT NULL,
  `timelast` int(10) NOT NULL default '0',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
