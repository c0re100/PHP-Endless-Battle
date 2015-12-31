-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u2
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2015 年 12 月 31 日 05:31
-- 伺服器版本: 5.5.46
-- PHP 版本: 5.4.45-0+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `ebs2`
--

-- --------------------------------------------------------

--
-- 表的結構 `phpeb_ip_sec`
--

CREATE TABLE IF NOT EXISTS `phpeb_ip_sec` (
  `ipaddr` varchar(60) NOT NULL,
  `username` varchar(30) NOT NULL,
  `checktime` varchar(20) NOT NULL,
  KEY `ipaddr` (`ipaddr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_bbstoebkeys`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_bbstoebkeys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `bbsname` varchar(20) NOT NULL DEFAULT '',
  `username` varchar(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Uid` (`uid`),
  UNIQUE KEY `bbsname` (`bbsname`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_chat`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_chat` (
  `c_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `c_user` varchar(16) NOT NULL DEFAULT '',
  `c_time` int(10) NOT NULL DEFAULT '0',
  `c_msg` text NOT NULL,
  `c_type` tinyint(1) NOT NULL DEFAULT '0',
  `c_tar` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2516 ;

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_game_history`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_game_history` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `history` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_regkeys`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_regkeys` (
  `regkey` varchar(10) NOT NULL DEFAULT '',
  `username` varchar(16) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `ip` text NOT NULL,
  `id` varchar(10) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`regkey`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_sys_changemoney`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_sys_changemoney` (
  `ebmoney` int(8) NOT NULL DEFAULT '0',
  `dzmoney` int(8) NOT NULL DEFAULT '0',
  `bbsmoneycode` char(30) NOT NULL DEFAULT '',
  `available` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ebmoney`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_sys_changemoney`
--

INSERT INTO `vsqa_phpeb_sys_changemoney` (`ebmoney`, `dzmoney`, `bbsmoneycode`, `available`) VALUES
(50, 100, 'extcredits2', 0);

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_sys_chtype`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_sys_chtype` (
  `id` varchar(4) NOT NULL DEFAULT '',
  `name` varchar(12) NOT NULL DEFAULT '',
  `typelv` tinyint(2) NOT NULL DEFAULT '0',
  `atf` tinyint(2) NOT NULL DEFAULT '0',
  `def` tinyint(2) NOT NULL DEFAULT '0',
  `ref` tinyint(2) NOT NULL DEFAULT '0',
  `taf` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_sys_chtype`
--

INSERT INTO `vsqa_phpeb_sys_chtype` (`id`, `name`, `typelv`, `atf`, `def`, `ref`, `taf`) VALUES
('nat1', '一般', 1, 0, 0, 0, 0),
('nat2', '一般', 2, 1, 1, 1, 1),
('nat3', '一般', 3, 2, 2, 2, 2),
('nat4', '一般', 4, 3, 3, 3, 3),
('nat5', '一般', 5, 3, 4, 3, 3),
('nat6', '一般', 6, 4, 4, 3, 3),
('nat7', '一般', 7, 4, 5, 3, 3),
('nat8', '一般', 8, 4, 5, 3, 3),
('nat9', '一般', 9, 4, 5, 3, 3),
('natx', '一般', 10, 4, 5, 3, 3),
('enh1', '強化人間Lv1', 1, 0, 0, 0, 0),
('enh2', '強化人間Lv2', 2, 1, 0, 0, 1),
('enh3', '強化人間Lv3', 3, 1, 1, 1, 1),
('enh4', '強化人間Lv4', 4, 1, 2, 1, 2),
('enh5', '強化人間Lv5', 5, 2, 3, 1, 4),
('enh6', '強化人間Lv6', 6, 3, 3, 2, 6),
('enh7', '強化人間Lv7', 7, 4, 3, 3, 7),
('enh8', '強化人間Lv8', 8, 5, 4, 3, 8),
('enh9', '強化人間Lv9', 9, 5, 4, 5, 8),
('enhx', '強化人間LvX', 10, 6, 4, 5, 8),
('ext1', 'Extended Lv1', 1, 0, 0, 0, 0),
('ext2', 'Extended Lv2', 2, 2, 0, 0, 0),
('ext3', 'Extended Lv3', 3, 3, 0, 1, 0),
('ext4', 'Extended Lv4', 4, 5, 0, 1, 1),
('ext5', 'Extended Lv5', 5, 7, 1, 2, 2),
('ext6', 'Extended Lv6', 6, 9, 1, 6, 3),
('ext7', 'Extended Lv7', 7, 10, 1, 7, 4),
('ext8', 'Extended Lv8', 8, 10, 1, 8, 6),
('ext9', 'Extended Lv9', 9, 10, 1, 8, 6),
('extx', 'Extended LvX', 10, 10, 1, 8, 6),
('psy1', '念動力 Lv1', 1, 0, 0, 0, 0),
('psy2', '念動力 Lv2', 2, 0, 1, 1, 0),
('psy3', '念動力 Lv3', 3, 1, 1, 1, 1),
('psy4', '念動力 Lv4', 4, 1, 2, 2, 1),
('psy5', '念動力 Lv5', 5, 2, 4, 2, 2),
('psy6', '念動力 Lv6', 6, 5, 8, 3, 2),
('psy7', '念動力 Lv7', 7, 7, 10, 3, 2),
('psy8', '念動力 Lv8', 8, 9, 11, 4, 3),
('psy9', '念動力 Lv9', 9, 10, 12, 4, 6),
('psyx', '念動力 LvX', 10, 10, 13, 4, 8),
('nt1', 'New Type Lv1', 1, 0, 0, 0, 0),
('nt2', 'New Type Lv2', 2, 0, 0, 0, 0),
('nt3', 'New Type Lv3', 3, 0, 0, 0, 0),
('nt4', 'New Type Lv4', 4, 0, 0, 0, 0),
('nt5', 'New Type Lv5', 5, 1, 1, 1, 1),
('nt6', 'New Type Lv6', 6, 2, 2, 2, 2),
('nt7', 'New Type Lv7', 7, 3, 3, 3, 3),
('nt8', 'New Type Lv8', 8, 7, 3, 7, 7),
('nt9', 'New Type Lv9', 9, 10, 3, 11, 11),
('nt10', 'New Type LvX', 10, 12, 3, 13, 12),
('co1', 'CO Lv1', 1, 0, 0, 0, 0),
('co2', 'CO Lv2', 2, 0, 0, 0, 0),
('co3', 'CO Lv3', 3, 0, 0, 0, 1),
('co4', 'CO Lv4', 4, 0, 0, 1, 1),
('co5', 'CO Lv5', 5, 1, 1, 2, 2),
('co6', 'CO Lv6', 6, 2, 2, 4, 4),
('co7', 'CO Lv7', 7, 4, 4, 6, 6),
('co8', 'CO Lv8', 8, 7, 7, 10, 8),
('co9', 'CO Lv9', 9, 10, 10, 13, 8),
('co10', 'CO LvX', 10, 13, 10, 14, 8),
('nat1', '一般', 1, 0, 0, 0, 0),
('nat2', '一般', 2, 1, 1, 1, 1),
('nat3', '一般', 3, 2, 2, 2, 2),
('nat4', '一般', 4, 3, 3, 3, 3),
('nat5', '一般', 5, 3, 4, 3, 3),
('nat6', '一般', 6, 4, 4, 3, 3),
('nat7', '一般', 7, 4, 5, 3, 3),
('nat8', '一般', 8, 4, 5, 3, 3),
('nat9', '一般', 9, 4, 5, 3, 3),
('natx', '一般', 10, 4, 5, 3, 3),
('enh1', '強化人間Lv1', 1, 0, 0, 0, 0),
('enh2', '強化人間Lv2', 2, 1, 0, 0, 1),
('enh3', '強化人間Lv3', 3, 1, 1, 1, 1),
('enh4', '強化人間Lv4', 4, 1, 2, 1, 2),
('enh5', '強化人間Lv5', 5, 2, 3, 1, 4),
('enh6', '強化人間Lv6', 6, 3, 3, 2, 6),
('enh7', '強化人間Lv7', 7, 4, 3, 3, 7),
('enh8', '強化人間Lv8', 8, 5, 4, 3, 8),
('enh9', '強化人間Lv9', 9, 5, 4, 5, 8),
('enhx', '強化人間LvX', 10, 6, 4, 5, 8),
('ext1', 'Extended Lv1', 1, 0, 0, 0, 0),
('ext2', 'Extended Lv2', 2, 2, 0, 0, 0),
('ext3', 'Extended Lv3', 3, 3, 0, 1, 0),
('ext4', 'Extended Lv4', 4, 5, 0, 1, 1),
('ext5', 'Extended Lv5', 5, 7, 1, 2, 2),
('ext6', 'Extended Lv6', 6, 9, 1, 6, 3),
('ext7', 'Extended Lv7', 7, 10, 1, 7, 4),
('ext8', 'Extended Lv8', 8, 10, 1, 8, 6),
('ext9', 'Extended Lv9', 9, 10, 1, 8, 6),
('extx', 'Extended LvX', 10, 10, 1, 8, 6),
('psy1', '念動力 Lv1', 1, 0, 0, 0, 0),
('psy2', '念動力 Lv2', 2, 0, 1, 1, 0),
('psy3', '念動力 Lv3', 3, 1, 1, 1, 1),
('psy4', '念動力 Lv4', 4, 1, 2, 2, 1),
('psy5', '念動力 Lv5', 5, 2, 4, 2, 2),
('psy6', '念動力 Lv6', 6, 5, 8, 3, 2),
('psy7', '念動力 Lv7', 7, 7, 10, 3, 2),
('psy8', '念動力 Lv8', 8, 9, 11, 4, 3),
('psy9', '念動力 Lv9', 9, 10, 12, 4, 6),
('psyx', '念動力 LvX', 10, 10, 13, 4, 8),
('nt1', 'New Type Lv1', 1, 0, 0, 0, 0),
('nt2', 'New Type Lv2', 2, 0, 0, 0, 0),
('nt3', 'New Type Lv3', 3, 0, 0, 0, 0),
('nt4', 'New Type Lv4', 4, 0, 0, 0, 0),
('nt5', 'New Type Lv5', 5, 1, 1, 1, 1),
('nt6', 'New Type Lv6', 6, 2, 2, 2, 2),
('nt7', 'New Type Lv7', 7, 3, 3, 3, 3),
('nt8', 'New Type Lv8', 8, 7, 3, 7, 7),
('nt9', 'New Type Lv9', 9, 10, 3, 11, 11),
('nt10', 'New Type LvX', 10, 12, 3, 13, 12),
('co1', 'CO Lv1', 1, 0, 0, 0, 0),
('co2', 'CO Lv2', 2, 0, 0, 0, 0),
('co3', 'CO Lv3', 3, 0, 0, 0, 1),
('co4', 'CO Lv4', 4, 0, 0, 1, 1),
('co5', 'CO Lv5', 5, 1, 1, 2, 2),
('co6', 'CO Lv6', 6, 2, 2, 4, 4),
('co7', 'CO Lv7', 7, 4, 4, 6, 6),
('co8', 'CO Lv8', 8, 7, 7, 10, 8),
('co9', 'CO Lv9', 9, 10, 10, 13, 8),
('co10', 'CO LvX', 10, 13, 10, 14, 8);

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_sys_map`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_sys_map` (
  `map_id` varchar(4) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `occprice` int(10) NOT NULL DEFAULT '0',
  `hpmax` int(8) NOT NULL DEFAULT '100000',
  `at` tinyint(3) NOT NULL DEFAULT '10',
  `de` tinyint(3) NOT NULL DEFAULT '10',
  `ta` tinyint(3) NOT NULL DEFAULT '10',
  `wepa` varchar(32) NOT NULL DEFAULT 'FortWepA',
  `movement` text NOT NULL,
  PRIMARY KEY (`map_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_sys_map`
--

INSERT INTO `vsqa_phpeb_sys_map` (`map_id`, `type`, `occprice`, `hpmax`, `at`, `de`, `ta`, `wepa`, `movement`) VALUES
('A1', 20, 500000, 1500000, 70, 70, 127, 'FortWepA', 'C2 E2'),
('A2', 23, 5000000, 1500000, 70, 70, 127, 'FortWepA', 'B2 A3'),
('A3', 26, 2000000, 1500000, 70, 70, 127, 'FortWepA', 'A2 B3'),
('B1', 21, 2500000, 1500000, 70, 70, 127, 'FortWepB', 'A1'),
('B2', 24, 10000000, 1500000, 70, 70, 127, 'FortWepB', 'C2 A2 C1'),
('B3', 27, 2500000, 1500000, 70, 70, 127, 'FortWepB', 'A3 C3'),
('C1', 22, 7500000, 1500000, 70, 70, 127, 'FortWepC', 'B1 B2'),
('C2', 25, 2500000, 1500000, 70, 70, 127, 'FortWepC', 'B2 A1'),
('C3', 28, 7500000, 1500000, 70, 70, 127, 'FortWepC', 'E2 B3'),
('D1', 0, 7500000, 1500000, 70, 70, 127, 'FortWepD', 'D2 D4'),
('D2', 9, 1000000, 1500000, 70, 70, 127, 'FortWepD', 'D1 D3 D6'),
('D3', 10, 7500000, 1500000, 70, 70, 127, 'FortWepD', 'D2 D6'),
('D4', 7, 5000000, 1500000, 70, 70, 127, 'FortWepD', 'D1 D5 E1'),
('D5', 6, 2500000, 1500000, 70, 70, 127, 'FortWepD', 'D2 D4 D7'),
('D6', 8, 5000000, 1500000, 70, 70, 127, 'FortWepD', 'D2 D3 D9'),
('D7', 1, 1500000, 1500000, 70, 70, 127, 'FortWepD', 'D5 D8'),
('D8', 11, 1000000, 1500000, 70, 70, 127, 'FortWepD', 'D9 E1'),
('D9', 12, 10000000, 1500000, 70, 70, 127, 'FortWepD', 'D6 D10 D11 D12 D13'),
('D10', 13, 500000, 1500000, 70, 70, 127, 'FortWepD', 'E1 E2'),
('D11', 14, 500000, 1500000, 70, 70, 127, 'FortWepD', 'E1 E2'),
('D12', 15, 500000, 1500000, 70, 70, 127, 'FortWepD', 'E1 E2'),
('D13', 16, 500000, 1500000, 70, 70, 127, 'FortWepD', 'E1 E2'),
('E2', 3, 2147483647, 1500000, 70, 70, 127, 'FortWepD', 'D4 D8 E1 D10 D11 D12 D13'),
('E1', 2, 2147483647, 1500000, 70, 70, 127, 'FortWepD', 'A1 C3 D10 D11 D12 D13');

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_sys_ms`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_sys_ms` (
  `id` varchar(12) NOT NULL DEFAULT '',
  `msname` varchar(24) NOT NULL DEFAULT '',
  `price` int(10) NOT NULL DEFAULT '0',
  `atf` tinyint(3) NOT NULL DEFAULT '0',
  `def` tinyint(3) NOT NULL DEFAULT '0',
  `ref` tinyint(3) NOT NULL DEFAULT '0',
  `taf` tinyint(3) NOT NULL DEFAULT '0',
  `hpfix` mediumint(6) NOT NULL DEFAULT '0',
  `enfix` mediumint(6) NOT NULL DEFAULT '0',
  `hprec` decimal(8,3) NOT NULL DEFAULT '0.000',
  `enrec` decimal(8,3) NOT NULL DEFAULT '0.000',
  `spec` varchar(20) NOT NULL DEFAULT '',
  `needlv` smallint(4) NOT NULL DEFAULT '0',
  `image` varchar(32) NOT NULL DEFAULT '',
  `ShopType` tinyint(3) NOT NULL DEFAULT '0',
  `noshow` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_sys_ms`
--

INSERT INTO `vsqa_phpeb_sys_ms` (`id`, `msname`, `price`, `atf`, `def`, `ref`, `taf`, `hpfix`, `enfix`, `hprec`, `enrec`, `spec`, `needlv`, `image`, `ShopType`, `noshow`) VALUES
('0', 'No Unit', 0, 0, 0, 0, 0, 0, 0, 0.000, 0.000, '', 0, 'none.gif', 0, 0),
('1', 'RX-75', 200000, 2, 1, 0, 2, 2600, 75, 10.779, 1.062, '', 1, 'ms01/RX-75.gif', 0, 0),
('2', 'RX-77-2', 450000, 2, 2, 2, 4, 2500, 90, 20.000, 1.300, '', 5, 'ms01/RX-77-2.gif', 0, 0),
('3', 'RGM-79', 500000, 2, 3, 3, 2, 2650, 100, 21.000, 1.500, '', 5, 'ms01/RGM-79.gif', 0, 0),
('4', 'RX-78-2', 500000, 3, 2, 3, 2, 2650, 100, 21.000, 1.600, '', 5, 'ms01/RX-78-2.gif', 0, 0),
('5', 'RX-78NT1', 550000, 5, 3, 3, 4, 2750, 120, 21.000, 1.800, '', 8, 'ms01/RX-78NT1.gif', 0, 0),
('6', 'FA-78-1', 550000, 6, 3, 3, 3, 2750, 130, 22.000, 1.300, '', 8, 'ms01/FA-78-1.gif', 0, 0),
('7', 'RX-78-3', 550000, 6, 3, 3, 3, 2700, 125, 20.000, 1.500, '', 8, 'ms01/RX-78-3.gif', 0, 0),
('8', 'RGM-79N', 550000, 4, 3, 3, 4, 2700, 120, 22.779, 1.700, '', 7, 'ms01/RGM-79N.gif', 0, 0),
('9', 'RGC-83', 500000, 5, 3, 2, 5, 2750, 120, 22.000, 1.800, '', 7, 'ms01/RGC-83.gif', 0, 0),
('10', 'RX-78 GP01FB', 950000, 8, 5, 15, 12, 5000, 180, 27.000, 5.000, '', 20, 'ms01/RX-78 GP01FB.gif', 0, 0),
('11', 'RX-178', 700000, 7, 4, 6, 6, 3000, 150, 23.779, 2.300, '', 15, 'ms01/RX-178.gif', 0, 0),
('12', 'RX-79[G]Ez-8', 1000000, 7, 6, 14, 14, 6000, 200, 30.000, 7.000, '', 22, 'ms01/RX-79[G]Ez-8.gif', 0, 0),
('13', 'XXXG-01SR2', 800000, 8, 10, 6, 4, 3600, 140, 23.000, 2.500, '', 18, 'ms01/XXXG-01SR2.gif', 0, 0),
('14', 'XXXG-01H2', 800000, 10, 8, 4, 5, 3500, 150, 23.000, 2.700, '', 18, 'ms01/XXXG-01H2.gif', 0, 0),
('15', 'RX-78 GP02A', 1500000, 18, 10, 15, 15, 10000, 300, 50.000, 10.000, '', 40, 'ms01/RX-78 GP02A.gif', 0, 0),
('16', 'RX-78 GP03D', 5400000, 17, 13, 13, 15, 12000, 450, 38.000, 13.000, '', 50, 'ms01/RX-78 GP03D.gif', 0, 0),
('17', 'MSA-099', 900000, 8, 5, 10, 10, 3300, 160, 26.000, 3.779, '', 25, 'ms01/MSA-099.gif', 0, 0),
('18', 'RX-178+FXA-05D', 970000, 10, 9, 8, 11, 4000, 150, 24.000, 2.700, '', 25, 'ms01/RX-178+FXA-05D.gif', 0, 0),
('19', 'XXXG-01S2', 1000000, 12, 11, 6, 6, 3800, 170, 25.000, 3.300, '', 28, 'ms01/XXXG-01S2.gif', 0, 0),
('20', 'MSN-100', 1400000, 13, 7, 14, 14, 4200, 220, 27.000, 5.000, '', 38, 'ms01/MSN-100.gif', 0, 0),
('21', 'MSA-005', 1200000, 10, 14, 11, 12, 4600, 200, 30.000, 4.000, '', 38, 'ms01/MSA-005.gif', 0, 0),
('22', 'RGZ-91', 1600000, 13, 9, 10, 13, 4500, 240, 27.000, 4.000, '', 38, 'ms01/RGZ-91.gif', 0, 0),
('23', 'XM-X1(F-97)', 2000000, 16, 14, 13, 13, 4700, 250, 28.000, 4.779, '', 38, 'ms01/XM-X1(F-97).gif', 0, 0),
('24', 'XXG-01D2', 1800000, 14, 15, 9, 9, 5000, 530, 25.000, 3.800, '', 38, 'ms01/XXXG-01D2.gif', 0, 0),
('25', '真GETTA－1', 5350000, 15, 12, 13, 14, 6000, 275, 37.500, 4.750, '', 45, 'ms01/GETTA－1.gif', 0, 0),
('26', '暴走EVA－01', 5250000, 16, 12, 11, 14, 6000, 275, 37.500, 4.750, '', 45, 'ms01/EVA－01.gif', 0, 0),
('27', '暴風高達', 5825000, 18, 13, 12, 15, 6200, 275, 45.000, 4.583, 'SeedMode', 50, 'seed/BUSTER.gif', 0, 0),
('28', '突擊高達', 6525000, 19, 13, 13, 16, 6500, 500, 45.000, 4.583, 'SeedMode', 55, 'seed/STRIKE.gif', 0, 0),
('29', '正義高達', 8100000, 20, 16, 15, 18, 7000, 300, 42.500, 5.400, 'SeedMode', 65, 'seed/JUSTICE.gif', 0, 0),
('30', 'MS-05', 200000, 2, 0, 1, 2, 1400, 75, 10.725, 1.071, '', 1, 'ms01/MS-05.gif', 0, 0),
('9527', 'npc03', 1700000, 5, 5, 5, 5, 4800, 530, 99999.999, 10000.000, '', 1000, 'npc/npc03.gif', 2, 1),
('9528', 'npc01', 1700000, 13, 15, 10, 9, 5000, 530, 25.000, 3.800, '', 1000, 'npc/npc01.gif', 2, 1),
('9529', 'npc02', 1700000, 14, 14, 10, 9, 5500, 530, 25.000, 3.800, '', 1000, 'npc/npc02.gif', 2, 1),
('9530', 'npc04', 1700000, 14, 14, 10, 9, 5400, 540, 25.000, 3.800, '', 1000, 'npc/npc04.gif', 2, 1),
('9531', 'npc05', 1700000, 14, 14, 10, 9, 4800, 520, 25.000, 3.800, '', 1000, 'npc/npc05.gif', 2, 1),
('9532', 'npc06', 1700000, 14, 14, 10, 9, 5000, 520, 25.000, 3.800, '', 1000, 'npc/npc06.gif', 2, 1),
('9533', 'npc07', 1700000, 14, 14, 10, 9, 5200, 530, 25.000, 3.800, '', 1000, 'npc/npc07.gif', 2, 1),
('9534', 'npc08', 1700000, 14, 14, 10, 9, 5300, 530, 25.000, 3.800, '', 1000, 'npc/npc08.gif', 2, 1),
('9535', 'npc08', 1700000, 14, 14, 10, 9, 5300, 530, 25.000, 3.800, '', 1000, 'npc/npc08.gif', 2, 1),
('9536', 'npc08', 1700000, 14, 14, 10, 9, 5300, 530, 25.000, 3.800, '', 1000, 'npc/npc08.gif', 2, 1),
('9537', 'npc08', 1700000, 14, 14, 10, 9, 5300, 530, 25.000, 3.800, '', 1000, 'npc/npc08.gif', 2, 1),
('9538', 'npc08', 1700000, 14, 14, 10, 9, 5300, 530, 25.000, 3.800, '', 1000, 'npc/npc08.gif', 2, 1),
('9539', 'npc08', 1700000, 14, 14, 10, 9, 5300, 530, 25.000, 3.800, '', 1000, 'npc/npc08.gif', 2, 1),
('9540', 'npc08', 1700000, 14, 14, 10, 9, 5300, 530, 25.000, 3.800, '', 1000, 'npc/npc08.gif', 2, 1),
('9541', 'npc08', 1700000, 14, 14, 10, 9, 5300, 530, 25.000, 3.800, '', 1000, 'npc/npc08.gif', 2, 1),
('9542', 'npc08', 1700000, 14, 14, 10, 9, 5300, 530, 25.000, 3.800, '', 1000, 'npc/npc08.gif', 2, 1),
('9546', 'npc08', 1700000, 0, 14, 10, 9, 5300, 530, 25.000, 3.800, '', 1000, 'npc/npc08.gif', 2, 1),
('874', '無雙', 99999999, 0, 0, 0, 0, 1, 1, 0.000, 0.000, '', 1000, 'special/ghost.gif', 2, 1),
('31', '自由高達', 10000000, 25, 20, 20, 25, 10000, 500, 60.000, 10.000, 'SeedMode', 100, 'seed/FREEDOM.gif', 0, 0),
('32', '天意高達', 14000000, 25, 23, 20, 25, 12000, 700, 80.000, 20.000, '', 140, 'seed/PROVIDENCE.gif', 0, 0),
('33', '無限正義高達', 19000000, 27, 25, 24, 27, 15000, 800, 100.000, 30.000, 'SeedMode', 190, 'seed/IJUSTICE.gif', 0, 0),
('34', '命運高達', 25000000, 30, 27, 28, 29, 18000, 1100, 120.000, 40.000, 'SeedMode', 250, 'seed/DESTINY.gif', 0, 0),
('35', '突擊自由高達', 32000000, 33, 34, 32, 31, 20000, 1300, 200.000, 50.000, 'SeedMode', 320, 'seed/SFREEDOM.gif', 0, 0),
('36', 'EVA Type F', 6, 35, 35, 35, 60, 30000, 2000, 400.000, 80.000, 'EVASystem', 500, 'eva/typef.gif', 1, 0),
('37', 'EVA 零號機', 6, 35, 35, 60, 35, 30000, 2000, 400.000, 80.000, 'EVASystem', 500, 'eva/no0.gif', 1, 0),
('38', 'EVA 二號機', 6, 60, 35, 35, 35, 30000, 2000, 400.000, 80.000, 'EVASystem', 500, 'eva/no2.gif', 1, 0),
('39', 'EVA 三號機', 6, 35, 60, 35, 35, 30000, 2000, 400.000, 80.000, 'EVASystem', 500, 'eva/no3.gif', 1, 0),
('40', '勇者王', 70000000, 42, 40, 38, 38, 28000, 1900, 380.000, 75.000, '', 380, 'new/Gaogaigar.gif', 0, 0),
('41', '零式高達', 90000000, 43, 38, 50, 41, 30000, 2400, 450.000, 90.000, '', 440, 'new/wingew.gif', 0, 0),
('42', 'Gundam 00', 130000000, 50, 45, 40, 55, 35000, 2700, 500.000, 120.000, 'EXAMSystem', 500, 'new/00.gif', 0, 0),
('43', '突擊自由高達(流星號)', 3, 45, 42, 38, 50, 34000, 2200, 500.000, 85.000, 'SeedMode', 350, 'seed/SFREEDOMM.gif', 1, 0),
('44', '無限正義高達(流星號)', 3, 45, 42, 50, 38, 32000, 2400, 400.000, 100.000, 'SeedMode', 350, 'seed/IJUSTICEM.gif', 1, 0),
('45', 'Turn A', 250000000, 60, 45, 50, 50, 40000, 3000, 600.000, 140.000, '', 600, 'new/TurnA.gif', 0, 0);

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_sys_tactfactory`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_sys_tactfactory` (
  `tact_id` varchar(12) NOT NULL DEFAULT '0',
  `wep_id` varchar(16) NOT NULL DEFAULT '0',
  `grade` tinyint(2) NOT NULL DEFAULT '1',
  `directions` text NOT NULL,
  `m1` varchar(16) NOT NULL DEFAULT '',
  `m2` varchar(16) NOT NULL DEFAULT '',
  `m3` varchar(16) DEFAULT NULL,
  `m4` varchar(16) DEFAULT NULL,
  `m5` varchar(16) DEFAULT NULL,
  `m6` varchar(16) DEFAULT NULL,
  `m7` varchar(16) DEFAULT NULL,
  `m8` varchar(16) DEFAULT NULL,
  `m9` varchar(16) DEFAULT NULL,
  `m10` varchar(16) DEFAULT NULL,
  `m11` varchar(16) DEFAULT NULL,
  `m12` varchar(16) DEFAULT NULL,
  `m13` varchar(16) DEFAULT NULL,
  `m14` varchar(16) DEFAULT NULL,
  `m15` varchar(16) DEFAULT NULL,
  `m16` varchar(16) DEFAULT NULL,
  `m17` varchar(16) DEFAULT NULL,
  `m18` varchar(16) DEFAULT NULL,
  `m19` varchar(16) DEFAULT NULL,
  `m20` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`tact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_sys_tactfactory`
--

INSERT INTO `vsqa_phpeb_sys_tactfactory` (`tact_id`, `wep_id`, `grade`, `directions`, `m1`, `m2`, `m3`, `m4`, `m5`, `m6`, `m7`, `m8`, `m9`, `m10`, `m11`, `m12`, `m13`, `m14`, `m15`, `m16`, `m17`, `m18`, `m19`, `m20`) VALUES
('0', '901', 10, 'G-bit衛星微波能量炮<br>走了一天路，肚子餓極了，你一聽到公會有免費晚懂N直衝，可是被地上的書絆倒了......<br>原來是一本殘舊的日記，內容支離破碎：<br>想不到十數支巨炮產的力量有這麼大！居然轟毀了一要塞，我無論如何，不擇手段都要獲得G-bit衛星微波能量炮的資料......<br>那?伙可真愚蠢，現在G-bit衛星微波能量炮的資料已到手，他已經沒有任何利用價值了......鑄造方法果然比我想的更妖雜：<br>「一號爐        衛星微波能量炮<br>二號爐          雙衛星微波能量炮<br>三號爐          Buster Beam Rifle<br>四號爐          長距離光束加農炮<br>五號爐          大型光束加農炮<br>六號爐          大型米加粒子炮<br>七號爐          水晶<br>八號爐          水晶<br>九號爐          水晶<br>十號爐          黃金<br>十一號爐        黃金<br>十二號爐        黃金<br>不過，應該可以鑄造成左?.....」日記到此完畢<br>', '974', '993', '962', '616', '619', '608', '718', '718', '718', '715', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1', '902', 10, '天上天下念動爆碎劍<br>你擁有念動力嗎？如果沒有，你是不能使用以下武器的！<br>天上天下念動爆碎劍，是天上天下無敵劍的後續武器，實力更在其之上，它同樣是一把需要駕駛員極度集中及精神的念動力氧造的一把劍<br>而且有念動爆碎的力量，威力驚人<br>一號爐          天上天下無敵劍<br>二號爐          天上天下念動破碎劍<br>三號爐          天上天下念動破碎劍<br>四號爐          T-Link Sensor<br>五號爐          T-Link Sensor<br>六號爐          超大型光束劍<br>七號爐          超大型光束劍<br>八號爐          水晶<br>九號爐          水晶<br>十號爐          黃金<br>十一號爐        黃金<br>', '983', '314', '314', '932', '932', '309', '309', '718', '718', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2', '903', 10, '縮退炮<br>在你面前的是一把無與倫比的武器<br>它擁有超高的攻擊力和射程，運作原理和黑洞炮相似，可以將對手封入閉鎖空間，之後引起目標自身的重力坍塌，進而破壞其自身結構<br>它就是──縮退寵。你是想得到它吧？呵呵，拿著！這就是氧造縮退炮的材料列表：<br>一號爐          衛星微波能量炮<br>二號爐          引力子步槍BST<br>三號爐          引力子步槍BST<br>四號爐          高性能照準系統<br>五號爐          沖角炮<br>六號爐          米加音波炮<br>七號爐          光束炮<br>八號爐          光束炮<br>九號爐          水晶<br>十號爐          水晶<br>十一號爐        黃金<br>十二號爐        鋼鐵<br>', '974', '952', '952', '965', '610', '618', '613', '613', '718', '718', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('3', '904', 10, '光之翼<br>你聽聞一位公會成員在說故事，於是你走過去：<br>「就是上星期發生的事！你知道我看到了甚麼？是一脞會發光的小鳥」<br>看眾人都驚訝不已，他又說下去，<br>「其實啊，它並不是甚麼發光大烏，它是一部正在使用光之翼的MS，而飛行的方向正是三部渣古！<br>就在這雷霆萬鈞的一刻，三部渣古被切成了六件，繼而爆炸！」<br>那公會成員的眼?彷?看得出有光，然後歎了一口氣，閉上發光的雙眼，認真的說：<br>「所以，今天小弟希望與大家分享光之翼的鑄造方法，只需現金......」<br>可惜，他再打開雙眼的時候，人們都散了，你卻反應緩慢的預備離開<br>那公會成員以發光的雙眼望著你抓住雙手，道：<br>「兄弟，你走運了！你有購買光之翼鑄造方法的機會了！」<br>你又不好意思推掉他一番好意，只好拿出錢，購買光之翼的鑄造方法<br>他還你一個感激的眼神，遞送上一張紙，寫著光之翼的鑄造方法：<br>一號爐          背部光束切裂器<br>二號爐          超大型光束劍<br>三號爐          超大型光束劍<br>四號爐          HiMAT System<br>五號爐          水晶<br>六號爐          水晶<br>七號爐          水晶<br>八號爐          黃金<br>九號爐          黃金<br>', '310', '309', '309', '998', '718', '718', '718', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('4', '905', 10, '黑洞炮<br>我醉心於研究最強的攻擊武器，發現黑洞炮堪稱最強<br>黑洞炮的基本原理是發射出一個極強的能量團，命中目標之後開始重力坍塌並產生一個黑洞將目標吸入其中，<br>被吸進黑洞的只有一個後果，就是死亡。<br>氧造黑洞不是一件簡單的工作，一不小心可能會被黑洞吸入，誤傷自己。這是我經過長期研究後，黑洞炮可能的氧作方法┬<br>一號爐          米加音波炮<br>二號爐          大型光束加農炮<br>三號爐          大型米加粒子炮<br>四號爐          280mm軌道加農炮<br>五號爐          超重力軌道槍<br>六號爐          水晶<br>七號爐          水晶<br>八號爐          黃金<br>', '618', '619', '608', '410', '409', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('5', '906', 10, 'Solar panel<br>在公會的僻靜角落，一個口叼香煙的男人，倚?而立，應該是公會成員之一，於是你走了過去，拿出一箱鈔票，<br>並以密碼溝通：「Bbm zpt udmk nd tnndugjmh zcnvs ugbs?」<br>公會成員先是嚇了一跳，然後施施拿下煙蒂：「nl，據可靠情報，某神秘組織的工程師聯同科學家，<br>合力研氧了一種會自動回復EN的物料－Solar panel<br>經過我們的仔細的調查，已獲得有關資料：<br>一號爐          青銅<br>二號爐          鋼鐵<br>三號爐          黃金<br>四號爐          水晶<br>五號爐          水晶<br>六號爐          黃金<br>七號爐          鋼鐵<br>八號爐          青銅<br>九號爐          青銅<br>十號爐          鋼鐵<br>十一號爐        黃金<br>十二號爐        水晶<br>十三號爐        E - cap」<br>', '711', '712', '715', '718', '718', '715', '712', '711', '711', '712', '715', '718', '999', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('6', '907', 10, 'NANO Skin<br>在公會的僻靜角落，一個口叼香煙的男人，倚?而立，應該是公會成員之一，於是你走了過去，拿出一箱鈔票，<br>並以密碼溝通：「Bbm zpt udmk nd tnndugjmh zcnvs ugbs?」<br>公會成員先是嚇了一跳，然後施施拿下煙蒂：「nl，據可靠情報，某神秘組織的工程師聯同科學家，<br>合力研氧了一種會自動回復HP的物料－NANO Skin<br>經過我們的仔細的調查，已獲得有關資料：<br>一號爐          青銅<br>二號爐          鋼鐵<br>三號爐          黃金<br>四號爐          水晶<br>五號爐          水晶<br>六號爐          黃金<br>七號爐          鋼鐵<br>八號爐          青銅<br>九號爐          青銅<br>十號爐          鋼鐵<br>十一號爐        黃金<br>十二號爐        水晶    <br>十三號爐        超硬鋼裝甲<br>十四號爐        超合金Z裝甲」<br>', '711', '712', '715', '718', '718', '715', '712', '711', '711', '712', '715', '718', '957', '989', NULL, NULL, NULL, NULL, NULL, NULL),
('7', '908', 10, 'Z．O．Armor<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Z．O．Armor，它是一種合金裝甲，並較超合金Z裝甲有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          超合金Z裝甲<br>二號爐          超合金Z裝甲<br>三號爐          高達尼姆合金裝甲<br>四號爐          高達尼姆合金裝甲<br>五號爐          月鈦合金裝甲<br>六號爐          月鈦合金裝甲<br>七號爐          月鈦合金裝甲」<br>', '989', '989', '956', '956', '831', '831', '831', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('8', '909', 10, '超合金newZ裝甲<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－超合金newZ裝甲，它是一種合金裝甲，並較超合金Z裝甲有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          超合金Z裝甲<br>二號爐          超合金Z裝甲<br>三號爐          超硬鋼裝甲<br>四號爐          超硬鋼裝甲<br>五號爐          月鈦合金裝甲<br>六號爐          月鈦合金裝甲    <br>七號爐          月鈦合金裝甲」<br>「多謝惠顧！」<br>', '989', '989', '957', '957', '831', '831', '831', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('9', '991', 9, 'V.S.B.R.<br>你在公會看到了一個售賣高級武器鑄造方法的人，於是你走過跟他交流一下心得<br>「你知道有關V.S.B.R.的事嗎？」<br>「當然知道，V.S.B.R.即Variable Speed Beam Rifle，即無段速光束步槍......」<br>「那麼是怎樣鑄造的？」<br>他伸出手，像是要什麼的模樣，聰明的你當然知道，雖然是交流心得，沒有錢是不行的<br>你拿出一疊鈔票，他當然告訴你鑄造方法：<br>一號爐          高能光束步槍<br>二號爐          高能光束步槍<br>三號爐          Mega．Beam Rifle<br>四號爐          長距離光束加農炮<br>五號爐          光束炮<br>六號爐          水晶<br>七號爐          水晶<br>八號爐          黃金<br>九號爐          黃金<br>', '405', '405', '411', '616', '613', '718', '718', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('10', '992', 9, 'Twin Buster Rifle<br>我以前曾在一間機動戰士工廠做過工程人員，記得我好像參與過氧造一把擁有兩支槍管而破壞力巨大的步槍，<br>我記得氧造這把槍需要把材料這樣放：<br>一號爐          Buster Beam Rifle<br>二號爐          Buster Rifle<br>三號爐          Buster Rifle<br>四號爐          2連裝軌道槍<br>五號爐          大型光束加農炮<br>六號爐          大型光束加農炮<br>七號爐          水晶<br>八號爐          黃金', '962', '412', '412', '407', '619', '619', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('11', '993', 9, '雙衛星微波能量炮<br>走了一天路，肚子餓極了，你一聽到公會有免費晚懂N直衝，可是被地上的書絆倒了......<br>原來是一本殘舊的日記，內容支離破碎：<br>「雙衛星微波能量炮與G-bit衛星微波能量炮的資源已到手：<br>一號爐          衛星微波能量炮<br>二號爐          衛星微波能量炮<br>三號爐          長距離光束加農炮<br>四號爐          光束加農炮<br>五號爐          光束炮<br>六號爐          單裝炮<br>七號爐          水晶<br>八號爐          黃金<br>九號爐          黃金<br>十號爐          黃金<br>至於G-bit衛星微波能量炮則較為妖雜......」<br>日記下一頁的內容似乎是故意被撕去的，日記到此完畢<br>', '974', '974', '616', '614', '613', '609', '718', '715', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('12', '994', 9, '反應彈<br>你在公會看到了一個據稱是飛彈怪人的成員，於是你便向他追問有關反應彈的問題：<br>「與紅外線追蹤飛彈相反，反應彈是一種追求攻擊界限的飛彈，所以無法應用紅外線追蹤技術，<br>而由於它的攻擊力高，所以它十分珍貴，彈數亦較少<br>既然你提出高價，我是不會讓你失望而回的：<br>一號爐          核子火箭炮<br>二號爐          核子火箭炮<br>三號爐          NEO火箭炮<br>四號爐          NEO火箭炮<br>五號爐          高能飛彈發射器<br>六號爐          高能飛彈發射器<br>七號爐          水晶<br>八號爐          水晶<br>九號爐          黃金」<br>', '522', '522', '517', '517', '502', '502', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('13', '995', 9, '斬艦刀．一文字斬<br>你從公會成員聽說，斬艦刀藏有十分強大的力量，且可以使出奧義－斬艦刀．一文字斬<br>但要發揮斬艦刀的潛能，光靠駕駛員的力量及技術是不足的，斬艦刀必須先經過強化，才有發揮力量及抵禦龐大出力的可能<br>而強化武器，必須以適當的材料再次鑄造(?)：<br>一號爐          斬艦刀<br>二號爐          青龍刀<br>三號爐          超合金Z裝甲<br>四號爐          水晶<br>五號爐          黃金<br>六號爐          鋼鐵<br>七號爐          鋼鐵<br>', '129', '127', '989', '718', '715', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('14', '996', 9, '浮游炮<br>晚上的夜空總是會看到星星的, 今天亦一樣, 而且還看到了「格外特別的星」<br>你不禁歎息:「又一部機犧牲在Bit的手上......」<br>一個熟悉的影子在月光下投在你的臉上,心想: 怎麼又是他呢?<br>「那是(?), 而非Bit, 它們的外貌是不同的.而力量更在前者之上」<br>又一張字條飛到臉上：<br>一號爐          Bit<br>二號爐          Newtype系統對應有線式光束炮<br>三號爐          高能光束步槍<br>四號爐          高能光束步槍<br>五號爐          高性能照準系統<br>六號爐          光束炮<br>七號爐          鋼鐵<br>八號爐          水晶<br>他沒留下一句話, 只是......<br>', '971', '620', '405', '405', '965', '613', '712', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('15', '997', 9, '飛翔炮<br>晚上的夜空總是會看到星星的, 今天亦一樣, 而且還看到了「格外特別的星」<br>你不禁歎息:「又一部機犧牲在Bit的手上......」<br>一個熟悉的影子在月光下投在你的臉上,心想: 怎麼又是他呢?<br>「那是(?), 而非Bit, 它們的外貌是不同的.而力量更在前者之上」<br>又一張字條飛到臉上：<br>一號爐          Bit<br>二號爐          Newtype系統對應有線式光束炮<br>三號爐          高能光束步槍<br>四號爐          高能光束步槍<br>五號爐          高性能照準系統<br>六號爐          光束炮<br>七號爐          黃金<br>八號爐          水晶<br>他沒留下一句話, 只是......<br>', '971', '620', '405', '405', '965', '613', '715', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('16', '998', 9, 'HiMAT System<br>支付巨款後，公會人員帶你到一名工程師那彥：<br>「你想知道那樣可令70噸重、18米高的機動戰士、達到 Mach 4 的速度之裝置嗎？」<br>他對你說：「不用變型、也不用安裝大型的噴射器，卻能在大氣圈內達到如此驚人的速度，<br>正正就那把『劍』所用的一個系統 － High Mobility Aerial Tactics System !」<br>之後，他便遞了一份文件給你，內彥記述著 HiMAT System 的氧作方法：<br>一號爐          高性能雷達<br>二號爐          Hyper Thruster<br>三號爐          Hyper Thruster<br>四號爐          極速噴射加速系統<br>五號爐          極速噴射加速系統<br>六號爐          黃金<br>七號爐          黃金<br>八號爐          水晶<br>九號爐          水晶<br>十號爐          水晶<br>', '977', '976', '976', '911', '911', '715', '715', '718', '718', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('17', '999', 9, 'E - cap<br>在公會的僻靜角落，一個口叼香煙的男人，倚?而立，應該是公會成員之一，於是你走了過去，拿出一箱鈔票，<br>並以密碼溝通：「Bbm zpt udmk nd tnndugjmh zcnvs ugbs?」<br>公會成員先是嚇了一跳，然後施施拿下煙蒂：「nl，據可靠情報，某神秘組織的工程師聯同科學家，<br>合力研氧了一種會自動回復EN的物料－E - cap<br>經過我們的仔細的調查，已獲得有關資料：<br>一號爐          青銅<br>二號爐          鋼鐵<br>三號爐          黃金<br>四號爐          水晶<br>五號爐          水晶<br>六號爐          黃金<br>七號爐          鋼鐵<br>八號爐          青銅<br>九號爐          水晶<br>十號爐          黃金」<br>', '711', '712', '715', '718', '718', '715', '712', '711', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('18', '981', 8, '你從公會成員聽說，皇牌駕駛員是可以發揮天空劍的內在潛能的，並使其能力上升了超過50%，而名字好像叫"天空劍．V字斬".<br>但要發揮天空劍的潛能，光靠駕駛員的力量是不行的，武器必須先經過強化，才有發揮力量的可能<br>要強化武器，必須以適當的材料再次鑄造天空劍：<br>一號爐          天空劍<br>二號爐          電磁劍<br>三號爐          電磁加農炮<br>四號爐          大型電磁斧<br>五號爐          大型電磁斧<br>六號爐          水晶<br>七號爐          黃金<br>八號爐          鋼鐵<br>', '963', '106', '943', '116', '116', '718', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('19', '982', 8, '超電磁龍卷<br>你在公會看到了一個售賣高級武器鑄造方法的人，於是你走過跟他交流一下心得<br>「你知道有關超電磁龍卷的事嗎？」<br>「當然知道，超電磁龍卷是一種利用電磁力產生龍卷作攻擊的武器......」<br>「那麼是怎樣鑄造的？」<br>他伸出手，像是要什麼的模樣，聰明的你當然知道，雖然是交流心得，沒有錢是不行的<br>你拿出一疊鈔票，他當然告訴你鑄造方法：<br>一號爐          電磁加農炮<br>二號爐          電磁炮<br>三號爐          雙回轉式電磁斧<br>四號爐          水晶<br>五號爐          黃金<br>六號爐          黃金<br>七號爐          鋼鐵<br>八號爐          青銅<br>', '943', '933', '118', '718', '715', '715', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('20', '983', 8, '天上天下無敵劍<br>你擁有念動力嗎？如果沒有，你是不能使用以下武器的！<br>天上天下無敵劍，故名思義，它是無敵的，是一把需要駕駛員極度集中的武器，並且以念動力氧造一把劍，威力驚人<br>一號爐          天上天下念動破碎劍<br>二號爐          天上天下念動破碎劍<br>三號爐          T-Link Sensor<br>四號爐          T-Link Sensor<br>五號爐          水晶<br>六號爐          黃金<br>', '314', '314', '932', '932', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('21', '984', 8, '雙格林機關炮<br>格林機關炮是一種力量不低的武器<br>試想想，若果格林機關炮一擊便把一部ｍｓ擊至重傷，那麼兩把格林機關炮不就一擊摧毀一部ｍｓ？<br>而且持著格林機關炮攻擊有一種興奮感覺，使駕駛員更能發揮其長<br>一號爐          格林機關炮<br>二號爐          格林機關炮<br>三號爐          雙光束旋轉機炮<br>四號爐          對裝甲散彈炮<br>五號爐          水晶<br>六號爐          黃金            <br>', '968', '968', '430', '422', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('22', '985', 8, '零式斬艦刀<br>你在公會的?告欄上找到了零式斬艦刀這名字，然而，你卻只知道斬艦刀，於是你找了個公會成員問問：<br>「這是斬艦刀強化後的武器，原來是專用武器，但後來機密被盜取，現在則被廣泛使用<br>零式斬艦刀勝在攻擊力高，其劍氣一下子擊破ｍｓ，鑄造方法如下：<br>一號爐          斬艦刀<br>二號爐          斬艦刀<br>三號爐          高出力周波刀<br>四號爐          超合金Z裝甲<br>五號爐          水晶<br>六號爐          黃金」<br>', '129', '129', '108', '989', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('23', '987', 8, '三次元雷達<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－三次元雷達，它是一種輔助瞄準裝置，並較高性能雷達有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          高性能雷達<br>二號爐          水晶<br>三號爐          水晶<br>四號爐          黃金<br>五號爐          黃金<br>六號爐          鋼鐵」<br>「多謝惠顧！」<br>', '977', '718', '718', '715', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('24', '988', 8, 'G．Territory<br>你偶然目睹了一場戰鬥:<br>A狠狠的以光束劍砍在B身上, 忽然, 一層不明顯的防護層出現了, 把A的攻擊擋下了, 然後b便一擊大破A.<br>機師得意洋洋的下了機,你乘機問問(?)的鑄造方法, 他得意忘形的說了I-Field Barrier,鋼鐵,黃金,水晶,黃金,鋼鐵,水晶<br>接著便走了。但是, 你不知道放在熔爐的次序呢!不過, 可以肯定的是, 原料是不會放在前面的。<br>', '966', '718', '718', '718', '715', '715', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('25', '989', 8, '超合金Z裝甲<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－超合金Z裝甲，它是一種合金裝甲，並較高達尼姆合金裝甲有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          高達尼姆合金裝甲<br>二號爐          高達尼姆合金裝甲<br>三號爐          超硬鋼裝甲<br>四號爐          超硬鋼裝甲<br>五號爐          水晶<br>六號爐          水晶<br>七號爐          黃金」<br>「多謝惠顧！」<br>', '956', '956', '957', '957', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('26', '971', 7, 'Bit<br>晚上, 你悠殞的臥視滿天星宿的天際, 卻發現數顆格外特別的星。<br>「那是Bit呢!那可是一種強勁的精神控制型武器。」說著,他留下一張字條:<br>一號爐          Newtype系統對應有線式光束炮<br>二號爐          光束炮<br>三號爐          光束炮<br>四號爐          高能光束步槍<br>五號爐          Psyco-Frame<br>六號爐          水晶<br>七號爐          水晶<br>和一句話:「有緣會相遇的......」<br>', '620', '613', '613', '405', '975', '718', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('27', '972', 7, 'Divider<br>你正想走進公會打聽有關不同武器的鑄造方法，卻被一個哭鬧的人撞倒，你正想站起來討回公道<br>那人已在問有關衛星微波能量炮的事：<br>「我的衛星微波能量炮在戰鬥中破裂了，你可以替修理一下嗎？」<br>「怎麼樣？」那人看來十分焦急<br>「唔......情況不太樂觀，應該不能用了，不過你可以以Divider代替衛星微波能量炮，能力不差多少」<br>「那麼是怎樣鑄造的？」<br>「除原本已毀的武器，只需再順序加上全出力擴散米加粒子炮，長距離光束加農炮，長距離光束加農炮，水晶，水晶，黃金便可鑄造Divider了」<br>「謝謝！」<br>', '974', '607', '616', '616', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('28', '973', 7, '計都羅侯劍*暗劍殺<br>你從公會成員聽說，皇牌駕駛員是可以發揮(?)的內在潛能的，並使其能力上升了超過50%，而名字好像叫"(?)".<br>但要發揮(?)的潛能，光靠駕駛員的力量是不行的，武器必須先經過強化，才有發揮力量的可能<br>要強化武器，必須以適當的材料再次鑄造計都羅侯劍：<br>一號爐          計都羅侯劍<br>二號爐          計都瞬獄劍<br>三號爐          計都瞬獄劍<br>四號爐          神速．四象無形劍<br>五號爐          音速噴射系統<br>六號爐          水晶<br>', '955', '324', '324', '321', '931', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('29', '974', 7, '衛星微波能量炮<br>走了一天路，肚子餓極了，你一聽到公會有免費晚懂N直衝，可是被地上的書絆倒了......<br>原來是一本殘舊的日記，內容支離破碎：<br>「夜，又來了<br>我，仍忘不了那深刻的一夜......<br>那是一個雲霧瀰漫晚上，我殞逛著，可是天色突變，雲層漸散，一道光從月亮射到大地，緊接著的是一陣震天巨響，<br>我沿著巨響與光的方向走，只見那彥一片荒蕪，寸草不生，似是被一富毀滅性的武器掠過......」<br>「經過數年的明查暗訪，終於找到了一點頭緒，原來那是G-bit衛星微波能量炮,可是我只有衛星微波能量炮鑄造方法：<br>一號爐          大型光束加農炮<br>二號爐          米加音波炮<br>三號爐          長距離光束加農炮<br>四號爐          單裝炮<br>五號爐          水晶<br>六號爐          黃金<br>七號爐          黃金<br>八號爐          黃金」<br>「......千辛萬苦找到的G-bit衛星微波能量炮與雙衛星微波能量炮資料被盜取了，應該是公會成員的所為，我已熬不到看見明天的晨曦了......」<br>日記到此完畢<br>', '619', '618', '616', '609', '718', '715', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('30', '975', 7, 'Pscyo-Frame<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Pscyo-Frame，它是一種瞄準系統，並較Dual Sensor有效率，怎麼樣？」<br>你點頭示意，把錢交給他：<br>「鑄造方法如下：<br>一號爐          T-Link Sensor<br>二號爐          T-Link Sensor<br>三號爐          水晶<br>四號爐          黃金<br>五號爐          黃金」<br>「多謝惠顧！」<br>', '932', '932', '718', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('31', '976', 7, 'Hyper Thruster<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Hyper Thruster，它是一種輔助加速裝置，並較Thruster有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          Thruster<br>二號爐          Thruster<br>三號爐          水晶<br>四號爐          水晶    」<br>「多謝惠顧！」<br>', '941', '941', '718', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('32', '977', 7, '高性能雷達<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－高性能雷達，它是一種輔助瞄準裝置，並較高性能照準系統有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          高性能照準系統<br>二號爐          水晶<br>三號爐          黃金<br>四號爐          黃金」<br>「多謝惠顧！」<br>', '965', '718', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('33', '978', 7, '念動力Field<br>你擁有念動力嗎？如果沒有，你是不能使用以下武器的！<br>一般Field如I-Field，只要有足夠能源便能夠啟動防禦的，但念動力Field則還需要駕駛員的精神力<br>只有念動力人種才可以開動，不過要另外鑄造念動力Field，才可以啟動：<br>一號爐          T-Link Sensor<br>二號爐          T-Link Sensor<br>三號爐          E field<br>四號爐          水晶<br>五號爐          黃金<br>六號爐          鋼鐵    <br>', '932', '932', '967', '718', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('34', '979', 7, 'Fin Funnel Barrier<br>「Fin Funnel Barrier？與Fin Funnel有關的嗎」你好奇的問<br>「你真聰明！Fin Funnel Barrier就是Fin Funnel產生的I-Field」他開始有點不耐煩，仍強顏歡笑<br>「那麼與I-Field Barrier有何區別？」你繼續的問<br>「Fin Funnel Barrier當然較厲害！其防禦力更在E field之上」<br>「那麼E field又是甚麼？」你越問越興奮<br>「你到底買還是不買？」<br>你看見他一瞼想宰了你的樣子，你只好乖乖付錢，慢慢離開......<br>一號爐          E field<br>二號爐          Beam Coating<br>三號爐          水晶<br>四號爐          水晶<br>五號爐          黃金    <br>「多謝?」回頭一看，他又回復原來的樣子了<br>', '967', '922', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('35', '961', 6, '擴散粒子彈<br>你正想走進公會打聽有關不同武器的鑄造方法，卻被一個哭鬧的人撞倒，你正想站起來討回公道<br>那人已在問有關衛星微波能量炮的事：<br>「我的全出力擴散米加粒子炮在戰鬥中破裂了，你可以替修理一下嗎？」<br>「怎麼樣？」那人看來十分焦急<br>「唔......情況不太樂觀，應該不能用了，不過你可以以擴散粒子彈代替全出力擴散米加粒子炮，能力不差多少」<br>「那麼是怎樣鑄造的？」<br>「除原本已毀的武器，只需順序加上擴散米加粒子炮，米加音波炮，水晶，黃金，鋼鐵便可鑄造擴散粒子彈了」<br>「謝謝！」<br>', '607', '605', '618', '718', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('36', '962', 6, 'Buster Beam Rifle<br>我是個機械維修員，我以前曾替 Wing Gundam Zero 維修，記得那機體有帶著一支巨型的步槍<br>看過它的結構後，我與另外多名工程師，分析出這把步槍需要以下材料氧造：<br>一號爐          Buster Rifle<br>二號爐          Buster Rifle<br>三號爐          Mega．Beam Rifle<br>四號爐          高能光束步槍<br>五號爐          水晶    <br>', '412', '412', '411', '405', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('37', '963', 6, '天空劍<br>傳說，有一把劍名為"天空劍"，其力量無比可砍山劈石.<br>某日，你在地上發現了一閃閃發光的物體，滿以為是水晶. <br>可是，走近一看，原來是一面鏡，下面是一本書，不......是兩本才對.滿心好奇的你，決定打開看看.<br>深紅雷刃書-天空劍的鑄造方法<br>一號爐          高出力光束配刀<br>二號爐          妖刀村正<br>三號爐          高周波刀<br>四號爐          青龍刀<br>五號爐          水晶<br>六號爐          鋼鐵    <br><br>碧青凶刃書-天空劍的鑄造方法<br>一號爐          大型電磁斧<br>二號爐          妖刀村正<br>三號爐          高周波刀<br>四號爐          電磁劍<br>五號爐          水晶<br>六號爐          鋼鐵            <br>原來是天空劍的鑄造方法，但是，那一個才對呢？<br>「深紅雷刃書......碧青凶刃書......?」接著, 你明白了.<br>', '116', '109', '107', '106', '718', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('38', '964', 6, '光速移動系統<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：「我推薦你這個－光速移動系統，它是一種加速系統，並較音速噴射系統有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          音速噴射系統<br>二號爐          水晶<br>三號爐          黃金<br>四號爐          黃金<br>五號爐          鋼鐵」<br>「多謝惠顧！」<br>', '931', '718', '715', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('39', '965', 6, '高性能照準系統<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－高性能照準系統，它是一種輔助瞄準裝置，並較照準系統有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          照準系統<br>二號爐          照準系統<br>三號爐          水晶<br>四號爐          黃金」<br>「多謝惠顧！」<br>', '942', '942', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('40', '966', 6, 'I-Field Barrier<br>你偶然目睹了一場戰鬥:<br>A狠狠的以光束劍砍在B身上, 忽然, 一層不明顯的防護層出現了, 把A的攻擊擋下了, 然後b便一擊大破A.<br>機師得意洋洋的下了機,你乘機問問(?)的鑄造方法, 他得意忘形的說了AB Field，水晶，水晶，黃金，<br>接著便走了。但是, 你不知道放在熔爐的次序呢!不過, 可以肯定的是, 原料是不會放在前面的。<br>', '944', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('41', '967', 6, 'E field<br>你偶然目睹了一場戰鬥:<br>A狠狠的以光束劍砍在B身上, 忽然, 一層不明顯的防護層出現了, 把A的攻擊擋下了, 然後b便一擊大破A.<br>機師得意洋洋的下了機,你乘機問問(?)的鑄造方法, 他得意忘形的說了AB Field，水晶，黃金，鋼鐵，鋼鐵，青銅，<br>接著便走了。但是, 你不知道放在熔爐的次序呢!不過, 可以肯定的是, 原料是不會放在前面的。<br>', '944', '718', '715', '712', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('42', '968', 6, '格林機關炮<br>格林機關炮是一種重彈藥的武器，千萬別低估了它的力量！雖然一顆子彈的攻擊力低，但十顆子彈的破壞力是不堪設想的<br>而且持著格林機關炮攻擊有一種興奮感覺，使駕駛員更能發揮其長<br>鑄造方法如下：<br>一號爐          光束旋轉機炮<br>二號爐          霰彈炮<br>三號爐          重突擊機統<br>四號爐          水晶<br>五號爐          黃金<br>六號爐          鋼鐵<br>七號爐          鋼鐵<br>', '429', '419', '418', '718', '715', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('43', '986', 8, 'Transitive FEAR<br>我在某國家當研究人員時，得知有一種名為 FEAR 的系統，就是那個 Far-range Exploration and Alteration Re-locator。這個系統能計算出一個超擴的範圍內一切的障礙物，然後，更能夠以 FEAR 系統中的推進器優化器，把機體推進至所能達到的極速，並且能躲過所有障礙物 － 包括敵軍機體與光束！<br>以下就是 Transitive FEAR 的氧作方法。<br>一號爐          光速移動系統<br>二號爐          極速噴射加速系統<br>三號爐          極速噴射加速系統<br>四號爐          噴射加速系統<br>五號爐          水晶<br>六號爐          黃金', '964', '911', '911', '801', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('44', '951', 5, '菊一文字<br>你在公會看到了一個售賣高級武器鑄造方法的人，於是你走過跟他交流一下心得<br>「你知道有關菊一文字的事嗎？」<br>「當然知道，菊一文字如妖刀川正，是傳說中的一把古刀......」<br>「那麼是怎樣鑄造的？」<br>他伸出手，像是要什麼的模樣，聰明的你當然知道，雖然是交流心得，沒有錢是不行的<br>你拿出一疊鈔票，他當然告訴你鑄造方法：<br>一號爐          妖刀村正<br>二號爐          高出力周波刀<br>三號爐          對裝甲刀<br>四號爐          青龍刀<br>五號爐          黃金<br>六號爐          鋼鐵<br>七號爐          鋼鐵<br>', '109', '108', '128', '127', '715', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('45', '952', 5, '引力子步槍BST<br>你在公會看到了一個售賣高級武器鑄造方法的人，於是你走過跟他交流一下心得<br>「你知道有關引力子步槍BST的事嗎？」<br>「當然知道，引力子步槍BST是利用引力子，把能力壓縮，作出攻擊......」<br>「那麼是怎樣鑄造的？」<br>他伸出手，像是要什麼的模樣，聰明的你當然知道，雖然是交流心得，沒有錢是不行的<br>你拿出一疊鈔票，他當然告訴你鑄造方法：<br>一號爐          280mm軌道加農炮<br>二號爐          破壞軌道槍<br>三號爐          Mega．Beam Rifle<br>四號爐          黃金<br>五號爐          黃金<br>', '410', '408', '411', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('46', '953', 5, '紅外線追蹤飛彈<br>你在公會看到了一個據稱是飛彈怪人的成員，於是你便向他追問有關紅外線追蹤飛彈的問題<br>「飛彈是一種命中力低，攻擊力一般，卻有大量彈藥的武器<br>為彌補命中力低的缺點，我個人研氧了一種以紅外線追蹤的強力飛彈<br>鑄造方法如下：<br>一號爐          高性能照準系統<br>二號爐          全方位火箭發射器<br>三號爐          散彈火箭炮<br>四號爐          水晶<br>五號爐          黃金<br>六號爐          鋼鐵」<br>', '965', '512', '519', '718', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('47', '954', 5, '激光盾<br>「激光盾？我怎麼從沒聽過這事的？」<br>「這是一種寓攻擊於防禦的武器，可以在防禦敵人攻擊的同時作出突擊，出其不意」<br>「這麼厲害？一口價！」<br>「成交！<br>一號爐          大型護盾<br>二號爐          強力護盾<br>三號爐          擴散米加粒子炮<br>四號爐          月鈦合金裝甲<br>五號爐          鋼鐵<br>六號爐          鋼鐵<br>七號爐          鋼鐵」<br>', '828', '826', '605', '831', '712', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('48', '955', 5, '計都羅侯劍<br>有一個公會成員在一旁自成一角，喃喃自語，你走過去聽他說：<br>「我闖蕩江湖數十年，最難忘的還是那一次......那天，我正趕緊運送貨物，偶遇兩機大戰，忽然天昏地暗，雷電交加，<br>一把劍突然出現在烏雲間，其中一機立刻握緊，並向另一機直砍，引起了巨大沙塵，連我的商隊亦被波及了」<br>他更說了計都羅侯劍的鑄造方法：<br>一號爐          計都瞬獄劍<br>二號爐          龍王破山劍．逆鯪斷<br>三號爐          四象無形劍<br>四號爐          黃金<br>五號爐          黃金<br>六號爐          鋼鐵<br>可是，你眨眼間，那男的就不見了<br>', '324', '323', '320', '715', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('49', '956', 5, '高達尼姆合金裝甲<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－高達尼姆合金裝甲，它是一種合金裝甲，並較月鈦合金裝甲有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          月鈦合金裝甲<br>二號爐          月鈦合金裝甲<br>三號爐          強力護盾<br>四號爐          水晶<br>五號爐          水晶<br>六號爐          鋼鐵」<br>「多謝惠顧！」<br>', '831', '831', '826', '718', '718', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('50', '957', 5, '超硬鋼裝甲<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－超硬鋼裝甲，它是一種合金裝甲，並較月鈦合金裝甲有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          月鈦合金裝甲<br>二號爐          月鈦合金裝甲<br>三號爐          大型護盾<br>四號爐          水晶<br>五號爐          水晶<br>六號爐          鋼鐵」<br>「多謝惠顧！」<br>', '831', '831', '828', '718', '718', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('51', '958', 5, '念動力L式加農炮<br>你擁有念動力嗎？如果沒有，你是不能使用以下武器的！<br>一般的加農炮均需要大量能源，但念動力L式加農炮是例外，它只需要小量能源，卻達到了一般加農炮的攻擊水平<br>可惜只有念動力人種方可開動，而且會耗用精神力<br>鑄造方法如下：<br>一號爐          T-Link Sensor<br>二號爐          T-Link Sensor<br>三號爐          長距離光束加農炮<br>四號爐          光束加農炮<br>五號爐          黃金<br>六號爐          鋼鐵    <br>', '932', '932', '616', '614', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('52', '941', 4, 'Thruster　<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Thruster，它是一種輔助加速裝置，並較Mega Booster有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          Mega Booster<br>二號爐          Mega Booster<br>三號爐          黃金<br>四號爐          黃金」<br>「多謝惠顧！」<br>', '921', '921', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('53', '942', 4, '照準系統<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－照準系統，它是一種輔助瞄準裝置，並較瞄準器有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          瞄準器<br>二號爐          瞄準器<br>三號爐          Dual Sensor<br>四號爐          黃金<br>五號爐          鋼鐵」<br>「多謝惠顧！」<br>', '816', '816', '811', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('54', '943', 4, '電磁加農炮<br>你從公會成員聽說到有關電磁加農炮的事：<br>「電磁加農炮，故名思義，是兩把電磁炮與光束加農炮的結合，不過，這是不足夠的，因為還需要一塊最珍貴的晶石，才可完成鑄造過程」<br>', '933', '933', '614', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('55', '944', 4, 'AB Field<br>你偶然目睹了一場戰鬥:<br>A狠狠的以光束劍砍在B身上, 忽然, 一層不明顯的防護層出現了, 把A的攻擊擋下了, 然後b便一擊大破A.<br>機師得意洋洋的下了機,你乘機問問(?)的鑄造方法, 他得意忘形的說了Beam Coating，黃金，強力護盾，G．Wall，黃金，<br>接著便走了。但是, 你不知道放在熔爐的次序呢!不過, 可以肯定的是, 原料是不會放在前面的。<br>', '922', '821', '826', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('56', '945', 4, 'Shield Buster Rifle<br>在你修行的路途上，看見了一部MS，且裝備了Buster Rifle。然而，老練的你只是看了看便打算離開。<br>「站住!」回頭一看，是一位少年，「這可不是普通的Buster Rifle，這是Shield Buster Rifle。」<br>此時, Buster Rifle的槍身展開, 成了防護盾! <br>看到你熱衷的眼神, 於是, 他便給了你Shield Buster Rifle的鑄造方法:<br>一號爐          強力護盾<br>二號爐          大型護盾<br>三號爐          Buster Rifle<br>四號爐          水晶<br>', '826', '828', '412', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('57', '931', 3, '音速噴射系統<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：「我推薦你這個－音速噴射系統，它是一種加速系統，並較極速噴射加速系統有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          極速噴射加速系統<br>二號爐          噴射加速系統<br>三號爐          黃金<br>四號爐          鋼鐵」<br>「多謝惠顧！」<br>', '911', '801', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('58', '932', 3, 'T-Link Sensor<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－T-Link Sensor，它是一種瞄準系統，並較Pscyo-Frame有效率，怎麼樣？」<br>你點頭示意，把錢交給他：<br>「鑄造方法如下：<br>一號爐          Multi-Sensor<br>二號爐          黃金<br>三號爐          鋼鐵」<br>「多謝惠顧！」<br>', '912', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('59', '933', 3, '電磁炮<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「電磁炮是一種常見的武器，但又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐          回轉式電磁斧<br>二號爐          電磁劍<br>三號爐          軌道槍<br>四號爐          鋼鐵<br>五號爐          鋼鐵<br>', '117', '106', '406', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('60', '608', 3, '大型米加粒子炮<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「大型米加粒子炮是一種常見的武器，但又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐          米加粒子炮<br>二號爐          米加粒子炮<br>三號爐          黃金<br>四號爐          青銅<br>', '601', '601', '715', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `vsqa_phpeb_sys_tactfactory` (`tact_id`, `wep_id`, `grade`, `directions`, `m1`, `m2`, `m3`, `m4`, `m5`, `m6`, `m7`, `m8`, `m9`, `m10`, `m11`, `m12`, `m13`, `m14`, `m15`, `m16`, `m17`, `m18`, `m19`, `m20`) VALUES
('61', '319', 3, '四象劍<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「四象劍是一種常見的武器，但又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐          熱能光束劍<br>二號爐          黃金<br>三號爐          鋼鐵<br>四號爐          鋼鐵<br>五號爐          青銅<br>', '303', '715', '712', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('62', '921', 2, 'Mega Booster<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Mega Booster，它是一種輔助加速裝置，並較Booster有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          Booster<br>二號爐          Booster<br>三號爐          鋼鐵<br>四號爐          鋼鐵」<br>「多謝惠顧！」<br>', '806', '806', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('63', '922', 2, 'Beam Coating<br>你偶然目睹了一場戰鬥:<br>A狠狠的以光束劍砍在B身上, 忽然, 一層不明顯的防護層出現了, 把A的攻擊擋下了, 然後b便一擊大破A.<br>機師得意洋洋的下了機,你乘機問問(?)的鑄造方法, 他得意忘形的說了鋼鐵，G．Wall，鋼鐵，G．Wall，<br>接著便走了。但是, 你不知道放在熔爐的次序呢!不過, 可以肯定的是, 原料是不會放在前面的。<br>', '821', '821', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('64', '504', 2, '榴炮發射器<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「榴炮發射器是一種常見的武器，但又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐          高能飛彈發射器<br>二號爐          高能飛彈發射器<br>三號爐          黃金<br>', '502', '502', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('65', '518', 2, '高出力火箭炮<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「高出力火箭炮是一種常見的武器，但又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐          原子能飛彈發射器<br>二號爐          黃金<br>三號爐          黃金<br>四號爐          青銅<br>', '503', '715', '715', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('66', '911', 1, '極速噴射加速系統<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：「我推薦你這個－極速噴射加速系統，它是一種加速系統，並較噴射加速系統有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐          噴射加速系統<br>二號爐          噴射加速系統<br>三號爐          鋼鐵<br>四號爐          青銅」<br>「多謝惠顧！」<br>', '801', '801', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('67', '912', 1, 'Multi-Sensor<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Multi-Sensor，它是一種瞄準系統，並較T-Link Sensor有效率，怎麼樣？」<br>你點頭示意，把錢交給他：<br>「鑄造方法如下：<br>一號爐          Dual Sensor<br>二號爐          Dual Sensor<br>三號爐          鋼鐵<br>四號爐          青銅」<br>「多謝惠顧！」<br>', '811', '811', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('68', '107', 1, '高周波刀<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「高周波刀是一種常見的武器，但又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐          高出力光束配刀<br>二號爐          光束小刀<br>三號爐          鋼鐵<br>四號爐          青銅            <br>', '104', '102', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('69', '213', 1, '熱帶低氣壓重拳<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「熱帶低氣壓重拳是一種常見的武器，但又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐          鐵拳<br>二號爐          鐵拳<br>三號爐          青銅<br>四號爐          青銅    <br>', '202', '202', '711', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('70', '510', 1, '5連裝飛彈發射器<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「5連裝飛彈發射器是一種常見的武器，但又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐          高能飛彈發射器<br>二號爐          高能飛彈發射器<br>三號爐          鋼鐵<br>四號爐          青銅            <br>', '502', '502', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('71', '96001', 6, 'EXAM System<br> 這一天你又來到了工程師公會，發現了一大堆學者正認真地打量著一部殘缺不堪的MS。<br> 為滿足你的好奇心，你走上前去，試圖從聽學者們的話中打聽這部MS的來歷。<br> <br> 「這部以藍色為主要色系的機體是.....?」<br> 「你這新來的?這就是那不分敵我都胡亂攻擊的"惡魔"啊?」<br> 「嗯...那時他展現的非凡破壞力...簡直叫我心寒.....」<br> 「不只是破壞力，就是迴避力，命中率都較一般MS要高呢?」<br> 「那為什麼會落得如此下場?」<br> 「因為那個系統強行把出力提高,使機體都負擔不了......」<br> 「聽說連駕駛者...都被弄得神志不清呢...」<br> 「難道...這就是傳說中裝備了EXAM System的"Blue Destiny"??」<br> 「讓我把系統給電腦掃一下......」<br> <br> 「Multi-Sensor、Dual Sensor、Multi-Sensor、Dual Sensor、Multi-Sensor、Dual Sensor、水晶、黃金、水晶、黃金」<br> <br> 正當你幻想著自己的機體裝備EXAM System後力量是何其強大的同時，<br> 你突然感到自己後領被一道何其強大的力量拉扯，就這樣被一個警衛提出公會門外?<br> <br> 「你在這裡幹啥?難道你是敵國派來的間諜?」<br> <br> 為保自己的清白，你連忙向他解釋?<br> <br> 「嗯......是這樣的......」<br>', '912', '811', '912', '811', '912', '811', '718', '715', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('72', '90002', 10, '你目睹了一場爭執?<br> <br> 「像你這 Coordinator 有什麼厲害，還不及我們這些Newtype?」一個男人以食指指向一個戴著面具的男人。<br> 「你只是人造的產物而已?」又一個男人指著那個戴著面具的男人。<br> 「我們Newtype能使用浮游炮，你呢?」再一個男人指向那個戴著面具的男人。<br> 「啪?」在千夫所指下，那戴著面具的男人終於沉不著氣，一掌打在桌上?<br> 「你們這些沒見識的人，有沒有聽過Super DRAGOON? 就是我們Coordinator專用的武器，能力更在浮游炮之上！」<br> 「那麼Super DRAGOON又是怎樣鑄造的?」你心裡好奇地問。<br> 那戴著面具的男人回過頭來，瞥了你一眼，遞了一張字條?<br> <br> 面具男的保證鑄造法----Super DRAGOON<br> <br> 一號爐          飛翔炮<br> 二號爐          Newtype系統對應有線式光束炮<br> 三號爐          Bit<br> 四號爐          Bit<br> 五號爐          高能光束步槍<br> 六號爐          高能光束步槍<br> 七號爐          高能光束步槍<br> 八號爐          高能光束步槍<br> 九號爐          水晶<br> 十號爐          水晶<br> 十一號爐        黃金<br> 十二號爐        黃金<br> 十三號爐        黃金<br> <br> 雖然你很奇怪為什麼那戴著面具的男人知道你在想什麼，<br> 但不管怎樣，你幸運地獲得了鑄造Super DRAGOON的方法。<br>', '997', '620', '971', '971', '405', '405', '405', '405', '718', '718', '715', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('73', '969', 6, '新高達尼姆合金<br> 這一天你又來到了工程師公會，看到一名工程師，埋頭苦幹，拿著鋼筆寫字。<br> 他一面寫，一面就哼唱著小調。<br> 突然，他回頭一望，便對你笑說：「這歌詞你一定會很喜歡！」<br> 然後，他便迅速取去你手上那箱鈔票，逃去無蹤了。<br> _______________________________________________________<br> 您想變強嗎?<br> 作曲、編曲?我　　　　　填詞?冷月無聲<br> 小修?　　　栩月　　　　氧作?風之翎<br> <br> 經歷了長久的努力和付出後<br> 得到了心目中的神兵利器<br> 又把它用得滾爪爛熟之際....<br> <br> 卻發現，發現了您敵人所擁有的<br> 並不比您的弱，甚至更勝於您<br> 更對您咄咄相逼,使您無力招架<br> <br> 您有感到自己的力量不足嗎?<br> 您有感到自己所付出的已諸東流嗎?<br> 您有想過令自己的武器與機體<br> 按照自己的思想作出強化與進步嗎??<br> <br> Repeat *<br> 既然您付了錢,當然不會讓您感到灰心<br> 請您緊記以下之物的製作配方<br> 一三七青銅 四五鋼鐵<br> 二六十黃金 八九水晶<br> 它!能令你變強!!<br> <br> 它!能令你更進一步地變強!!<br> _______________________________________________________<br> 「有種被騙的感覺。。」你心想著。<br>', '711', '715', '711', '712', '712', '715', '711', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('100', '1005', 11, 'MAGI System<br>超級電磁線圈引擎<br>A.T.力場<br>高振動粒子槍<br>高振動粒子炮<br>Jet Alone', '1002', '1003', '1007', '1006', '1004', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('101', '1004', 11, 'Jet Alone<br>超級電磁線圈引擎<br>高振動粒子炮<br>A.T.力場<br>高振動粒子槍', '1002', '1006', '1003', '1007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('102', '1010', 11, '人類補完計劃書<br>高振動粒子刀<br>高振動粒子炮<br>高振動粒子槍<br>A.T.力場', '1000', '1006', '1007', '1003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('104', '1008', 11, '尼布甲尼撒鑰匙<br>超級電磁線圈引擎<br>高振動粒子炮<br>A.T.力場<br>高振動粒子刀<br>高振動粒子槍', '1002', '1006', '1003', '1000', '1007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('105', '1009', 10, '404 Not Found<br>全部主武器順序擺放即可', '101', '102', '103', '201', '301', '401', '417', '501', '601', '701', '1000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('106', '1003', 11, 'A.T.力場<br>超級電磁線圈引擎<br>高振動粒子刀<br>超級電磁線圈引擎<br>高振動粒子炮<br>超級電磁線圈引擎<br>高振動粒子槍<br>祝你成功！', '1002', '1000', '1002', '1006', '1002', '1007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('107', '1001', 11, '朗基努斯之槍<br>高振動粒子刀<br>超級電磁線圈引擎<br>A.T.力場<br>Jet Alone<br>MAGI System<br>高振動粒子炮<br>高振動粒子槍<br>尼布甲尼撒鑰匙<br>404 Not Found<br>人類補完計劃書<br>青銅<br>鋼鐵<br>黃金<br>水晶', '1000', '1002', '1003', '1004', '1005', '1006', '1007', '1008', '1009', '1010', '711', '712', '715', '718', NULL, NULL, NULL, NULL, NULL, NULL),
('108', '1011', 7, '零作用護盾用於防禦朗基努斯之槍<br>將朗基努斯之槍的傷害減半<br>由3個A.T.力場、光束護盾及Jet Alone組成。合成次序：............看來合成紙條被上一手撕破了........!@#@!$@%$RW%R!##!', '1003', '1003', '1003', '1004', '827', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('110', '1030', 10, 'Goldion Hammer是勇者王專用武器<br>GGG 指令<br>G-STONE<br>G-Tools<br>GoldyMag<br>Hell and Heaven<br>中和粒子炮<br>晶石C0RE<br>白銀C0RE<br>白金C0RE<br>鑽石C0RE', '1031', '1032', '1033', '1034', '1035', '1036', '1022', '1023', '1025', '1026', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('111', '1032', 7, 'G-STONE<br>青銅C0RE<br>鋼鐵C0RE<br>白金C0RE<br>水晶C0RE<br>GGG 指令', '1020', '1021', '1025', '1027', '1031', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('112', '1033', 7, 'G-Tools的合成方法是<br>G-STONE<br>G-STONE<br>G-STONE<br>GGG 指令<br>GGG 指令<br>當你閱讀到最後發現....<br>製作人表示：忘記了合成位置........G-STONE還是GGG指令優先..........!@#$%$^@#$!@#', '1031', '1031', '1032', '1032', '1032', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('113', '1034', 7, 'GoldyMag<br>G-STONE<br>G-STONE<br>G-Tools<br>GGG指令<br>GGG指令', '1032', '1032', '1033', '1031', '1031', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('114', '1035', 7, 'Hell and Heaven<br>水晶C0RE<br>GGG 指令<br>GGG 指令<br>波動龍神擊<br>波動龍神擊', '1027', '1031', '1031', '204', '204', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('115', '1036', 7, '中和粒子炮<br>全出力擴散米加粒子炮<br>全出力擴散米加粒子炮<br>全出力擴散米加粒子炮<br>飛彈發射器<br>飛彈發射器<br>G-STONE', '607', '607', '607', '501', '501', '1032', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_sys_tactics`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_sys_tactics` (
  `id` varchar(14) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `name` varchar(10) NOT NULL DEFAULT '',
  `hpc` mediumint(6) NOT NULL DEFAULT '0',
  `enc` mediumint(6) NOT NULL DEFAULT '0',
  `spc` tinyint(3) NOT NULL DEFAULT '0',
  `atf` tinyint(3) NOT NULL DEFAULT '0',
  `def` tinyint(3) NOT NULL DEFAULT '0',
  `ref` tinyint(3) NOT NULL DEFAULT '0',
  `taf` tinyint(3) NOT NULL DEFAULT '0',
  `hitf` tinyint(3) NOT NULL DEFAULT '0',
  `missf` tinyint(3) NOT NULL DEFAULT '0',
  `price` int(8) NOT NULL DEFAULT '0',
  `needlv` tinyint(3) NOT NULL DEFAULT '0',
  `spec` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_sys_tactics`
--

INSERT INTO `vsqa_phpeb_sys_tactics` (`id`, `name`, `hpc`, `enc`, `spc`, `atf`, `def`, `ref`, `taf`, `hitf`, `missf`, `price`, `needlv`, `spec`) VALUES
('0', '通常攻擊', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ''),
('StrikeA', '突擊', 0, 5, 2, 10, -2, -2, -1, 0, 0, 100000, 6, ''),
('DefCounterA', '防禦反擊', 0, 0, 2, -5, 10, -5, 0, 5, 0, 120000, 11, ''),
('QuickA', '迅速', 0, 10, 2, 0, -5, 10, -2, 0, 5, 120000, 11, ''),
('SnipeA', '狙擊', 0, 10, 5, 2, -3, -5, 10, 5, 0, 500000, 27, ''),
('StrikeB', '捨身', 100, 10, 5, 20, -5, 0, 0, 5, 5, 500000, 27, ''),
('DoubleStrike', '二連擊', 0, 0, 20, 0, 0, -5, -10, 10, 0, 1000000, 35, 'DoubleStrike'),
('TripleStrike', '三連擊', 0, 0, 40, 0, 0, -5, -10, 10, 0, 3000000, 65, 'TripleStrike'),
('AllWepStirke', '全彈發射', 100, 50, 25, 0, 0, 0, -20, 25, 0, 2500000, 56, 'AllWepStirke'),
('RaidStrike', '奇襲', 0, 5, 35, 5, 5, 25, 10, 0, 0, 4000000, 70, ''),
('MindStrike', '心眼', 0, 0, 40, 10, -5, 5, 25, 5, 0, 4000000, 70, ''),
('SenseStrike', '靈感', 0, 25, 60, 25, 0, 10, 10, 10, 10, 10000000, 80, ''),
('CounterStrike', '伺機反擊', 0, 0, 45, 0, 0, 0, 0, 20, 0, 12000000, 85, 'CounterStrike'),
('FirstStrike', '先制攻擊', 0, 30, 45, 0, 0, 5, -5, 0, 0, 12000000, 85, 'FirstStrike');

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_sys_wep`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_sys_wep` (
  `id` varchar(16) NOT NULL DEFAULT '0',
  `name` varchar(40) NOT NULL DEFAULT '',
  `grade` tinyint(3) NOT NULL DEFAULT '0',
  `kind` varchar(3) NOT NULL DEFAULT 'N',
  `familyid` varchar(5) NOT NULL DEFAULT '0',
  `nextev` text NOT NULL,
  `specev` text NOT NULL,
  `atk` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `def` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `ref` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `taf` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `hit` mediumint(3) unsigned NOT NULL DEFAULT '0',
  `rd` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `enc` smallint(5) unsigned NOT NULL DEFAULT '0',
  `price` int(10) unsigned NOT NULL DEFAULT '0',
  `equip` tinyint(1) NOT NULL DEFAULT '0',
  `spec` text NOT NULL,
  `noshow` tinyint(1) NOT NULL DEFAULT '0',
  `weptype` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_sys_wep`
--

INSERT INTO `vsqa_phpeb_sys_wep` (`id`, `name`, `grade`, `kind`, `familyid`, `nextev`, `specev`, `atk`, `def`, `ref`, `taf`, `hit`, `rd`, `enc`, `price`, `equip`, `spec`, `noshow`, `weptype`) VALUES
('0', '無武器', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0),
('101', '小刀', 1, 'BDI', '101', '102,124', '', 780, 0, 0, 0, 95, 2, 15, 40000, 0, '', 0, 0),
('102', '光束小刀', 2, 'BDI', '101', '103', '', 780, 0, 0, 0, 95, 2, 30, 48000, 0, 'MeltA', 0, 0),
('103', '光束配刀', 3, 'BI', '101', '104', '', 850, 0, 0, 0, 98, 2, 45, 57000, 0, 'MeltA', 0, 0),
('104', '高出力光束配刀', 4, 'I', '101', '105', '107', 1000, 0, 0, 0, 98, 2, 60, 65000, 0, 'MeltA', 0, 0),
('105', '電磁力光束配刀', 5, 'I', '101', '115', '106', 1200, 0, 0, 0, 99, 2, 90, 74000, 0, 'MeltB', 0, 0),
('106', '電磁劍', 6, 'I', '101', '', '', 2700, 0, 0, 0, 100, 1, 115, 80000, 0, 'MeltB', 0, 0),
('107', '高周波刀', 6, 'N', '101', '108', '', 1200, 0, 0, 0, 100, 2, 90, 84000, 0, 'DamA', 0, 0),
('108', '高出力周波刀', 7, 'N', '101', '109', '110', 630, 0, 0, 0, 105, 4, 100, 95000, 0, 'DamA', 0, 0),
('109', '妖刀村正', 8, 'N', '101', '', '', 1525, 0, 0, 0, 100, 2, 115, 100000, 0, 'DamA,AntiPDef', 0, 0),
('110', '對艦刀《SCHWERT-GEWEHER》', 5, 'N', '101', '', '', 835, 0, 0, 0, 100, 4, 130, 100000, 0, 'DamB,MeltB', 0, 0),
('115', '電磁斧', 5, 'I', '101', '116,117', '', 2500, 0, 0, 0, 100, 1, 85, 63000, 0, '', 0, 0),
('116', '大型電磁斧', 6, 'I', '101', '', '', 2950, 0, 0, 0, 95, 1, 105, 72000, 0, 'DamA', 0, 0),
('117', '回轉式電磁斧', 6, 'N', '101', '', '118', 1300, 0, 0, 0, 95, 2, 95, 71000, 0, '', 0, 0),
('118', '雙回轉式電磁斧', 7, 'N', '101', '', '', 730, 0, 0, 0, 95, 4, 100, 86000, 0, '', 0, 0),
('124', '金屬小刀', 2, 'I', '101', '125', '', 800, 0, 0, 0, 100, 2, 25, 46000, 0, '', 0, 0),
('125', '重裝金屬小刀', 3, 'DI', '101', '', '126', 870, 0, 0, 0, 100, 2, 40, 57000, 0, '', 0, 0),
('126', '重斬刀', 4, 'N', '101', '128', '127', 680, 0, 0, 0, 100, 3, 65, 69000, 0, '', 0, 0),
('127', '青龍刀', 4, 'N', '101', '', '128', 780, 0, 0, 0, 100, 4, 135, 85000, 0, 'DamA,DamB', 0, 0),
('128', '對裝甲刀', 5, 'N', '101', '', '129', 1520, 0, 0, 0, 100, 2, 130, 100000, 0, 'DamB', 0, 0),
('129', '斬艦刀', 6, 'N', '101', '', '', 1780, 0, 0, 0, 100, 2, 150, 100000, 0, 'DamA,DamB', 0, 0),
('201', '格鬥', 1, 'BDI', '201', '202', '', 540, 0, 0, 0, 100, 3, 15, 45000, 0, '', 0, 0),
('202', '鐵拳', 2, 'DI', '201', '203,212', '', 570, 0, 0, 0, 100, 3, 25, 50000, 0, '', 0, 0),
('203', '剛腕粉碎擊', 3, 'I', '201', '204', '219', 610, 0, 0, 0, 103, 3, 35, 55000, 0, '', 0, 0),
('204', '波動龍神擊', 4, 'I', '201', '205', '', 650, 0, 0, 0, 105, 3, 50, 63000, 0, '', 0, 0),
('205', '旋風三連擊', 5, 'I', '201', '206', '', 710, 0, 0, 0, 105, 3, 70, 72000, 0, '', 0, 0),
('206', '爆碎重落下', 6, 'I', '201', '', '207', 770, 0, 0, 0, 105, 3, 95, 81000, 0, 'DamA', 0, 0),
('207', '疾風雙連擊', 7, 'N', '201', '', '208', 750, 0, 0, 0, 105, 4, 125, 90000, 0, 'DamA', 0, 0),
('208', '醉舞．再現江湖', 8, 'N', '201', '', '', 680, 0, 0, 0, 105, 5, 160, 100000, 0, 'MobA,AtkA', 0, 0),
('212', '燃之重拳', 3, 'I', '201', '213', '216', 775, 0, 0, 0, 100, 3, 60, 75000, 0, '', 0, 0),
('213', '熱帶低氣壓重拳', 4, 'I', '201', '', '214', 620, 0, 0, 0, 100, 4, 95, 83000, 0, '', 0, 0),
('214', '豪熱機關鎗重拳', 5, 'N', '201', '', '215', 490, 0, 0, 0, 100, 6, 110, 90000, 0, 'AntiPDef', 0, 0),
('215', '十二王方牌大車輪', 7, 'N', '201', '', '', 265, 0, 0, 0, 100, 12, 125, 100000, 0, 'AntiPDef,AtkA', 0, 0),
('216', 'T-Link Knuckle', 2, 'N', '201', '', '', 1500, 0, 0, 0, 110, 2, 120, 70000, 0, 'PsyRequired,DamB,AntiPDef,CostSP<3>', 0, 0),
('219', '機械爪', 3, 'DI', '201', '220', '', 1100, 0, 0, 0, 100, 2, 90, 56000, 0, 'Cease', 0, 0),
('220', '重裝機械爪', 4, 'N', '201', '221', '223', 1275, 0, 0, 0, 105, 2, 110, 64000, 0, 'Cease', 0, 0),
('221', '神龍伸縮爪', 5, 'N', '201', '', '222', 850, 0, 0, 0, 105, 3, 145, 73000, 0, 'Cease', 0, 0),
('222', '真．流星蝴蝶劍', 6, 'N', '201', '', '', 400, 0, 0, 0, 105, 8, 175, 95000, 0, 'DamB,Cease,AntiPDef', 0, 0),
('223', '溶斷破碎機械手', 4, 'N', '201', '', '', 1675, 0, 0, 0, 110, 2, 170, 90000, 0, 'DamA,Cease,MeltA', 0, 0),
('301', '光束劍', 1, 'BDI', '301', '302', '', 830, 0, 0, 0, 100, 2, 20, 60000, 0, 'MeltA', 0, 0),
('302', '試作型光束劍', 2, 'DI', '301', '303', '', 900, 0, 0, 0, 100, 2, 30, 63000, 0, 'MeltA', 0, 0),
('303', '熱能光束劍', 2, 'DI', '301', '304', '', 950, 0, 0, 0, 100, 2, 38, 67000, 0, 'MeltA', 0, 0),
('304', '腕式光劍', 3, 'I', '301', '305,318', '', 1050, 0, 0, 0, 100, 2, 48, 71000, 0, 'MeltA', 0, 0),
('305', '米加光束劍', 4, 'N', '301', '', '306,310,312', 1180, 0, 0, 0, 100, 2, 59, 78000, 0, 'MeltA', 0, 0),
('306', '大型光束劍', 6, 'N', '301', '307', '309', 1330, 0, 0, 0, 100, 2, 80, 86000, 0, 'MeltA', 0, 0),
('307', 'Hi-光束劍', 7, 'N', '301', '308', '', 1400, 0, 0, 0, 100, 2, 110, 89000, 0, 'MeltB,AntiPDef', 0, 0),
('308', 'Hyper光束劍', 8, 'N', '301', '', '', 1580, 0, 0, 0, 100, 2, 140, 94500, 0, 'MeltA,DamB', 0, 0),
('309', '超大型光束劍', 7, 'N', '301', '', '', 1560, 0, 0, 0, 100, 2, 130, 93000, 0, 'MeltA,Cease', 0, 0),
('310', '背部光束切裂器', 3, 'I', '301', '', '', 2880, 0, 0, 0, 100, 1, 90, 71000, 0, 'MeltA', 0, 0),
('312', '誘導式光束劍', 7, 'N', '301', '', '313,314', 2800, 0, 0, 0, 95, 1, 135, 90000, 0, 'MeltB', 0, 0),
('313', '有線式光束劍', 8, 'N', '301', '', '', 3100, 0, 0, 0, 95, 1, 155, 99000, 0, 'Cease,MeltB,NTRequired,CostSP<5>', 0, 0),
('314', '天上天下念動破碎劍', 8, 'N', '301', '', '', 3200, 0, 0, 0, 95, 1, 175, 110000, 0, 'MeltB,DamB,AntiPDef,PsyRequired,CostSP<7>', 0, 0),
('318', '斬鐵劍', 5, 'I', '301', '319', '', 1240, 0, 0, 0, 100, 2, 105, 83000, 0, '', 0, 0),
('319', '四象劍', 6, 'N', '301', '320', '322', 1340, 0, 0, 0, 100, 2, 110, 87000, 0, '', 0, 0),
('320', '四象無形劍', 7, 'N', '301', '324', '321', 1450, 0, 0, 0, 100, 2, 140, 91000, 0, 'Cease', 0, 0),
('321', '神速．四象無形劍', 8, 'N', '301', '', '', 1600, 0, 0, 0, 100, 2, 180, 95000, 0, 'Cease', 0, 0),
('322', '龍王破山劍', 9, 'N', '301', '', '323', 1100, 0, 0, 0, 99, 3, 200, 110000, 0, 'AntiPDef', 0, 0),
('323', '龍王破山劍．逆鯪斷', 10, 'N', '301', '', '', 1250, 0, 0, 0, 99, 3, 230, 125000, 0, 'DamA,DamB,AntiPDef', 0, 0),
('324', '計都瞬獄劍', 7, 'I', '301', '', '', 1050, 0, 0, 0, 100, 3, 140, 115000, 0, 'DamA', 0, 0),
('401', '105mm機槍', 1, 'BDI', '401', '402', '', 550, 0, 0, 0, 95, 3, 30, 60000, 0, '', 0, 0),
('402', '110mm速射炮', 2, 'DI', '401', '403,417', '', 630, 0, 0, 0, 95, 3, 45, 65000, 0, '', 0, 0),
('403', '光束步槍', 3, 'DI', '401', '405', '404', 730, 0, 0, 0, 95, 3, 60, 71000, 0, '', 0, 0),
('404', '雙光束步槍', 4, 'N', '401', '', '', 640, 0, 0, 0, 85, 4, 125, 77000, 0, '', 0, 0),
('405', '高能光束步槍', 5, 'I', '401', '411', '406', 810, 0, 0, 0, 95, 3, 90, 81000, 0, '', 0, 0),
('406', '軌道槍', 6, 'N', '401', '407,408', '410', 933, 0, 0, 0, 98, 3, 120, 85000, 0, 'DamA', 0, 0),
('407', '2連裝軌道槍', 7, 'N', '401', '', '', 505, 0, 0, 0, 90, 6, 140, 89000, 0, 'DamA', 0, 0),
('408', '破壞軌道槍', 7, 'N', '401', '', '409', 1000, 0, 0, 0, 90, 3, 130, 88000, 0, 'AntiPDef', 0, 0),
('409', '超重力軌道槍', 8, 'N', '401', '', '', 1220, 0, 0, 0, 98, 3, 180, 93500, 0, 'AntiPDef,DamB', 0, 0),
('410', '280mm軌道加農炮', 8, 'N', '401', '', '', 821, 0, 0, 0, 88, 4, 160, 90000, 0, 'AntiPDef,MeltA,DamA', 0, 0),
('411', 'Mega．Beam Rifle', 6, 'N', '401', '', '412', 910, 0, 0, 0, 96, 3, 90, 75000, 0, '', 0, 0),
('412', 'Buster Rifle', 7, 'N', '401', '', '', 630, 0, 0, 0, 98, 5, 170, 95000, 0, 'DamA,AntiPDef', 0, 0),
('417', '120mm機炮', 3, 'BDI', '401', '', '418', 610, 0, 0, 0, 90, 3, 55, 65000, 0, '', 0, 0),
('418', '重突擊機統', 4, 'I', '401', '419,426', '', 650, 0, 0, 0, 90, 3, 70, 71000, 0, '', 0, 0),
('419', '霰彈炮', 5, 'N', '401', '420', '422', 230, 0, 0, 0, 90, 10, 90, 76000, 0, '', 0, 0),
('420', '光束霰彈炮', 6, 'N', '401', '421', '', 205, 0, 0, 0, 90, 15, 115, 85000, 0, '', 0, 0),
('421', '高能光束霰彈炮', 7, 'I', '401', '', '', 215, 0, 0, 0, 95, 15, 145, 94000, 0, 'DamB', 0, 0),
('422', '對裝甲散彈炮', 6, 'N', '401', '', '', 270, 0, 0, 0, 90, 10, 125, 90000, 0, 'AntiPDef,DamA,DamB,MeltA', 0, 0),
('426', '高能機炮', 5, 'I', '401', '427', '', 695, 0, 0, 0, 95, 3, 80, 74000, 0, '', 0, 0),
('427', '大型機炮', 6, 'N', '401', '428', '431', 575, 0, 0, 0, 95, 4, 105, 82000, 0, '', 0, 0),
('428', '超重型機炮', 7, 'N', '401', '429', '', 435, 0, 0, 0, 95, 6, 135, 91000, 0, '', 0, 0),
('429', '光束旋轉機炮', 8, 'N', '401', '', '430', 525, 0, 0, 0, 99, 6, 160, 100000, 0, 'Cease,AntiPDef', 0, 0),
('430', '雙光束旋轉機炮', 10, 'N', '401', '', '', 295, 0, 0, 0, 99, 12, 190, 115000, 0, 'DamA,Cease,AntiPDef', 0, 0),
('431', '180mm 加農炮', 7, 'N', '401', '', '', 1350, 0, 0, 0, 97, 2, 155, 93000, 0, 'DamB', 0, 0),
('501', '飛彈發射器', 1, 'BDI', '501', '502,509', '', 900, 0, 0, 0, 85, 2, 35, 80000, 0, '', 0, 0),
('502', '高能飛彈發射器', 2, 'I', '501', '503', '', 1100, 0, 0, 0, 85, 2, 55, 85000, 0, '', 0, 0),
('503', '原子能飛彈發射器', 4, 'N', '501', '', '504,516', 1300, 0, 0, 0, 88, 2, 75, 90500, 0, '', 0, 0),
('504', '榴炮發射器', 6, 'N', '501', '', '505', 1550, 0, 0, 0, 88, 2, 95, 95000, 0, 'AntiPDef', 0, 0),
('505', '核彈發射器', 8, 'N', '501', '', '', 4000, 0, 0, 0, 88, 1, 120, 99999, 0, 'DamA,AntiPDef', 0, 0),
('509', '連裝飛彈發射器', 2, 'DI', '501', '510', '', 800, 0, 0, 0, 87, 3, 64, 87000, 0, '', 0, 0),
('510', '5連裝飛彈發射器', 3, 'I', '501', '511', '', 550, 0, 0, 0, 86, 5, 83, 94000, 0, '', 0, 0),
('511', '10連裝飛彈發射器', 4, 'N', '501', '512', '513', 300, 0, 0, 0, 85, 10, 95, 98500, 0, 'Cease', 0, 0),
('512', '全方位火箭發射器', 6, 'N', '501', '', '', 185, 0, 0, 0, 85, 20, 110, 105000, 0, 'Cease', 0, 0),
('513', '小型自己誘導飛彈', 6, 'N', '501', '', '', 235, 0, 0, 0, 100, 12, 150, 400000, 0, 'Tarb,AntiMobS', 0, 0),
('516', '240mm火箭炮', 3, 'I', '501', '518,519,520', '517', 2450, 0, 0, 0, 80, 1, 70, 90000, 0, '', 0, 0),
('517', 'NEO火箭炮', 3, 'I', '501', '', '', 2700, 0, 0, 0, 88, 1, 88, 94500, 0, '', 0, 0),
('518', '高出力火箭炮', 4, 'N', '501', '', '', 2950, 0, 0, 0, 88, 1, 95, 96500, 0, '', 0, 0),
('519', '散彈火箭炮', 7, 'N', '501', '', '', 845, 0, 0, 0, 96, 4, 100, 120000, 0, '', 0, 0),
('520', '大型火箭炮', 6, 'N', '501', '521,522', '', 3250, 0, 0, 0, 88, 1, 120, 99000, 0, '', 0, 0),
('521', '原子火箭炮', 7, 'N', '501', '', '', 3300, 0, 0, 0, 93, 1, 135, 110000, 0, 'DamB', 0, 0),
('522', '核子火箭炮', 8, 'N', '501', '', '', 3550, 0, 0, 0, 93, 1, 155, 131000, 0, 'DamA,AntiPDef', 0, 0),
('601', '米加粒子炮', 1, 'BDI', '601', '602', '613', 440, 0, 0, 0, 78, 5, 70, 90000, 0, '', 0, 0),
('602', '偏向米加粒子炮', 2, 'I', '601', '603', '608,609', 400, 0, 0, 0, 78, 6, 80, 93000, 0, '', 0, 0),
('603', '連裝米加粒子炮', 3, 'I', '601', '604', '', 350, 0, 0, 0, 78, 8, 90, 97000, 0, '', 0, 0),
('604', '散彈米加粒子炮', 4, 'I', '601', '605', '', 380, 0, 0, 0, 78, 8, 110, 120000, 0, '', 0, 0),
('605', '擴散米加粒子炮', 5, 'N', '601', '606', '', 275, 0, 0, 0, 78, 12, 125, 126000, 0, '', 0, 0),
('606', '全方位擴散米加粒子炮', 6, 'N', '601', '', '607', 188, 0, 0, 0, 75, 16, 140, 132000, 0, 'Cease', 0, 0),
('607', '全出力擴散米加粒子炮', 7, 'N', '601', '', '', 160, 0, 0, 0, 70, 20, 185, 137000, 0, 'Cease', 0, 0),
('608', '大型米加粒子炮', 3, 'I', '601', '', '', 588, 0, 0, 0, 75, 5, 160, 97000, 0, 'DamA,DamB', 0, 0),
('609', '單裝炮', 3, 'I', '601', '610', '', 680, 0, 0, 0, 75, 4, 140, 97000, 0, 'DamA', 0, 0),
('610', '沖角炮', 3, 'I', '601', '', '611', 600, 0, 0, 0, 75, 5, 175, 97000, 0, 'DamA', 0, 0),
('611', '二連裝沖角炮', 3, 'I', '601', '', '', 350, 0, 0, 0, 75, 10, 200, 97000, 0, 'DamA,DamB', 0, 0),
('613', '光束炮', 3, 'I', '601', '614', '616', 540, 0, 0, 0, 75, 5, 90, 115000, 0, '', 0, 0),
('614', '光束加農炮', 4, 'I', '601', '615', '620', 575, 0, 0, 0, 75, 5, 110, 119000, 0, '', 0, 0),
('615', '米加加農炮', 4, 'N', '601', '', '', 680, 0, 0, 0, 78, 5, 170, 122000, 0, '', 0, 0),
('616', '長距離光束加農炮', 5, 'N', '601', '', '617', 540, 0, 0, 0, 80, 6, 155, 124000, 0, '', 0, 0),
('617', '米加光束加農炮', 6, 'N', '601', '619', '618', 570, 0, 0, 0, 80, 6, 175, 130000, 0, 'MeltB,AntiPDef', 0, 0),
('618', '米加音波炮', 7, 'N', '601', '', '', 555, 0, 0, 0, 95, 6, 220, 140000, 0, 'MeltA,AntiPDef', 0, 0),
('619', '大型光束加農炮', 8, 'N', '601', '', '', 430, 0, 0, 0, 78, 8, 195, 129000, 0, 'DamA,DamB, AntiPDef', 0, 0),
('620', 'Newtype系統對應有線式光束炮', 7, 'N', '601', '', '', 835, 0, 0, 0, 75, 4, 175, 120000, 0, 'DamA,NTCustom,CostSP<6>', 0, 0),
('701', '青銅劍', 1, 'BI', '701', '702', '711,1020', 1000, 0, 0, 0, 95, 1, 25, 100000, 0, 'DoubleMon', 0, 0),
('702', '鋼鐵劍', 2, 'I', '701', '703', '712,1021', 1100, 0, 0, 0, 95, 1, 35, 110000, 0, 'DoubleMon', 0, 0),
('703', '晶石劍', 3, 'I', '701', '704', '1022', 1200, 0, 0, 0, 96, 1, 45, 120000, 0, 'DoubleMon', 0, 0),
('704', '白銀劍', 4, 'I', '701', '705', '1023', 1300, 0, 0, 0, 96, 1, 65, 130000, 0, 'DoubleMon', 0, 0),
('705', '黃金劍', 5, 'N', '701', '706', '715,1024', 1400, 0, 0, 0, 97, 1, 75, 140000, 0, 'DoubleMon', 0, 0),
('706', '白金劍', 6, 'N', '701', '707', '1025', 1500, 0, 0, 0, 97, 1, 90, 150000, 0, 'DoubleMon', 0, 0),
('707', '鑽石劍', 7, 'N', '701', '708', '1026', 1600, 0, 0, 0, 100, 1, 110, 160000, 0, 'DoubleMon', 0, 0),
('708', '水晶劍', 8, 'N', '701', '', '718,1027', 1800, 0, 0, 0, 100, 1, 140, 170000, 0, 'DoubleMon', 0, 0),
('711', '青銅', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 0, 120000, 0, 'RawMaterials', 0, 0),
('712', '鋼鐵', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 0, 135000, 0, 'RawMaterials', 0, 0),
('715', '黃金', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 0, 180000, 0, 'RawMaterials', 0, 0),
('718', '水晶', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 0, 225000, 0, 'RawMaterials', 0, 0),
('801', '噴射加速系統', 0, 'BI', '0', '', '', 0, 0, 0, 0, 0, 0, 60, 600000, 2, 'Moba', 0, 0),
('806', 'Booster', 0, 'BI', '0', '', '', 0, 0, 0, 0, 0, 0, 80, 600000, 2, 'MobA', 0, 0),
('811', 'Dual Sensor', 0, 'BI', '0', '', '', 0, 0, 0, 0, 0, 0, 30, 600000, 2, 'Tara', 0, 0),
('816', '瞄準器', 0, 'BI', '0', '', '', 0, 0, 0, 0, 0, 0, 35, 600000, 2, 'TarA', 0, 0),
('821', 'G．Wall', 0, 'BI', '0', '', '', 0, 0, 0, 0, 0, 0, 70, 600000, 2, 'Defa,AntiDam', 0, 0),
('826', '強力護盾', 0, 'BI', '0', '', '', 0, 0, 0, 0, 0, 0, 50, 600000, 2, 'DefA', 0, 0),
('827', '光束護盾', 0, 'BI', '0', '', '', 0, 0, 0, 0, 0, 0, 50, 600000, 2, 'Defa', 0, 0),
('828', '大型護盾', 0, 'BI', '0', '', '', 0, 0, 0, 0, 0, 0, 40, 500000, 2, 'AntiDam', 0, 0),
('831', '月鈦合金裝甲', 0, 'BI', '0', '', '', 0, 0, 0, 0, 0, 0, 150, 1000000, 2, 'DefB,ExtHP<600>', 0, 0),
('90002', 'Super DRAGOON', 13, 'N', '0', '', '', 320, 0, 0, 0, 125, 16, 800, 36500000, 0, 'COCustom,AntiPDef,MeltA,', 0, 0),
('901', 'G-bit衛星微波能量炮', 12, 'N', '0', '', '', 1150, 0, 0, 0, 120, 6, 800, 380000, 0, 'NTCustom,DamA,DamB,MeltA,AntiPDef,CostSP<50>', 0, 0),
('902', '天上天下念動爆碎劍', 12, 'N', '0', '', '', 2800, 0, 0, 0, 120, 2, 650, 370000, 0, 'AntiPDef,PsyRequired,DamA,MeltB,CostSP<30>', 0, 0),
('903', '縮退炮', 11, 'N', '0', '', '', 1070, 0, 0, 0, 120, 5, 490, 360000, 0, 'DamA,DamB,AntiPDef', 0, 0),
('904', '光之翼', 10, 'N', '0', '', '', 5100, 0, 0, 0, 120, 2, 480, 370000, 0, 'MeltB,Mobb,AntiTarS,AntiPDef', 0, 0),
('905', '黑洞炮', 11, 'N', '0', '', '', 1700, 0, 0, 0, 120, 3, 490, 360000, 0, 'Cease，DamA,DamB,AntiMobS', 0, 0),
('906', 'Solar panel', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 0, 2000000, 2, 'ENPcRecB', 0, 0),
('907', 'NANO Skin', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 0, 2000000, 2, 'HPPcRecA', 0, 0),
('908', 'Z．O．Armor', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 300, 1600000, 2, 'DefE,AntiDam,ExtHP<3000>', 0, 0),
('909', '超合金newZ裝甲', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 350, 1600000, 2, 'DefE,PerfDef,ExtHP<2000>', 0, 0),
('911', '極速噴射加速系統', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 100, 500000, 2, 'Mobb', 0, 0),
('912', 'Multi-Sensor', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 70, 500000, 2, 'Tarb', 0, 0),
('921', 'Mega Booster', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 120, 650000, 2, 'MobB', 0, 0),
('922', 'Beam Coating', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 110, 1000000, 2, 'Defb', 0, 0),
('931', '音速噴射系統', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 150, 750000, 2, 'Mobc', 0, 0),
('932', 'T-Link Sensor', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 150, 800000, 2, 'Tarc,AntiMobS', 0, 0),
('933', '電磁炮', 3, 'I', '0', '', '', 1250, 0, 0, 0, 98, 3, 190, 100000, 0, 'DamA,DamB', 0, 0),
('941', 'Thruster', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 180, 900000, 2, 'MobC', 0, 0),
('942', '照準系統', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 80, 900000, 2, 'TarB', 0, 0),
('943', '電磁加農炮', 4, 'I', '0', '', '', 1365, 0, 0, 0, 98, 3, 240, 120000, 0, 'DamA,DamB', 0, 0),
('944', 'AB Field', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 160, 1050000, 2, 'Defc', 0, 0),
('945', 'Shield Buster Rifle', 6, 'I', '0', '', '', 620, 0, 0, 0, 98, 5, 115, 120000, 1, 'DamA,AntiPDef,DefC', 0, 0),
('951', '菊一文字', 5, 'I', '0', '', '', 1890, 0, 0, 0, 99, 2, 275, 130000, 0, 'DamB', 0, 0),
('952', '引力子步槍BST', 5, 'I', '0', '', '', 1310, 0, 0, 0, 95, 3, 300, 140000, 0, 'DamA,AntiPDef', 0, 0),
('953', '紅外線追蹤飛彈', 7, 'I', '0', '', '', 400, 0, 0, 0, 120, 8, 255, 200000, 0, 'Tarc,AntiMobS,Cease', 0, 0),
('954', '激光盾', 6, 'I', '0', '', '', 340, 0, 0, 0, 90, 10, 200, 130000, 1, 'MeltA,DamA,DefA', 0, 0),
('955', '計都羅侯劍', 6, 'I', '0', '', '', 3590, 0, 0, 0, 100, 1, 275, 175000, 0, 'AntiPDef', 0, 0),
('956', '高達尼姆合金裝甲', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 200, 1020000, 2, 'DefC,ExtHP<900>', 0, 0),
('957', '超硬鋼裝甲', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 200, 1020000, 2, 'DefC,ExtHP<800>', 0, 0),
('958', '念動力L式加農炮', 0, 'I', '0', '', '', 640, 0, 0, 0, 95, 6, 215, 270000, 0, 'PsyRequired,DamA,AntiPDef,TarB', 0, 0),
('96001', 'EXAM System', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 30, 1100000, 2, 'EXAMSystem, MobA, TarA, AtkA', 0, 0),
('961', '擴散粒子彈', 9, 'I', '0', '', '', 260, 0, 0, 0, 93, 15, 330, 160000, 0, 'AntiPDef,AtkA', 0, 0),
('962', 'Buster Beam Rifle', 8, 'N', '0', '', '', 1030, 0, 0, 0, 95, 4, 320, 1270000, 1, 'AntiPDef', 0, 0),
('963', '天空劍', 7, 'N', '0', '', '', 3850, 0, 0, 0, 100, 1, 310, 155000, 0, 'DamA,DamB', 0, 0),
('964', '光速移動系統', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 210, 1100000, 2, 'Mobd', 0, 0),
('965', '高性能照準系統', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 140, 1100000, 2, 'TarC,Cease', 0, 0),
('966', 'I-Field Barrier', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 220, 1250000, 2, 'Defd,AntiDam', 0, 0),
('967', 'E field', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 220, 1250000, 2, 'Defd,PerfDef', 0, 0),
('968', '格林機關炮', 8, 'I', '0', '', '', 380, 0, 0, 0, 95, 10, 310, 155000, 0, 'DamB,AtkA', 0, 0),
('969', '新高達尼姆合金', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 0, 250000, 0, 'RawMaterials', 0, 0),
('971', 'Bit', 8, 'I', '0', '', '', 345, 0, 0, 0, 120, 12, 280, 50000, 0, 'NTRequired,Cease,CostSP<8>', 0, 0),
('972', 'Divider', 8, 'I', '0', '', '', 322, 0, 0, 0, 120, 13, 340, 650000, 0, 'AntiPDef,DamA', 0, 0),
('973', '計都羅侯劍*暗劍殺', 9, 'I', '0', '', '', 4450, 0, 0, 0, 120, 2, 355, 2300000, 0, 'AntiPDef,MobA', 0, 0),
('974', '衛星微波能量炮', 9, 'I', '0', '', '', 2400, 0, 0, 0, 120, 2, 450, 1650000, 0, 'NTCustom,AntiPDef,CostSP<15>', 0, 0),
('975', 'Psyco-Frame', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 220, 1000000, 2, 'Tard,AntiMobS', 0, 0),
('976', 'Hyper Thruster', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 240, 1000000, 2, 'MobD', 0, 0),
('977', '高性能雷達', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 185, 1000000, 2, 'TarC,AntiMobS', 0, 0),
('978', '念動力Field', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 250, 1350000, 2, 'PsyRequired,PerfDef,DefX', 0, 0),
('979', 'FF Barrier', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 240, 1300000, 2, 'Defd,AntiDam', 0, 0),
('981', '天空劍．V字斬', 9, 'I', '0', '', '', 2270, 0, 0, 0, 120, 2, 385, 700000, 0, 'DamA,DamB', 0, 0),
('982', '超電磁龍卷', 9, 'I', '0', '', '', 430, 0, 0, 0, 120, 10, 380, 700000, 0, 'AntiMobS,AntiPDef', 0, 0),
('983', '天上天下無敵劍', 9, 'I', '0', '', '', 2300, 0, 0, 0, 120, 2, 395, 710000, 0, 'PsyRequired,MeltA', 0, 0),
('984', '雙格林機關炮', 10, 'I', '0', '', '', 215, 0, 0, 0, 120, 20, 355, 690000, 0, 'DamA,DamB,AtkA', 0, 0),
('985', '零式斬艦刀', 10, 'I', '0', '', '', 4600, 0, 0, 0, 120, 2, 390, 690000, 0, 'AntiPDef', 0, 0),
('986', 'Transitive FEAR', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 320, 1300000, 2, 'Mobd,AntiTarS', 0, 0),
('987', '三次元雷達', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 250, 1100000, 2, 'TarD,AntiMobS', 0, 0),
('988', 'G．Territory', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 280, 1500000, 2, 'Defe,PerfDef,AntiDam', 0, 0),
('989', '超合金Z裝甲', 0, 'I', '0', '', '', 0, 0, 0, 0, 0, 0, 250, 1250000, 2, 'DefD,ExtHP<1500>', 0, 0),
('991', 'V.S.B.R.', 9, 'N', '0', '', '', 1055, 0, 0, 0, 120, 4, 400, 280000, 0, 'DamB', 0, 0),
('992', 'Twin Buster Rifle', 10, 'N', '0', '', '', 790, 0, 0, 0, 120, 6, 435, 280000, 0, 'DamA,DamB,AntiPDef', 0, 0),
('993', '雙衛星微波能量炮', 11, 'N', '0', '', '', 1320, 0, 0, 0, 120, 4, 530, 300000, 0, 'NTCustom,AntiPDef,DamB,CostSP<25>', 0, 0),
('994', '反應彈', 11, 'N', '0', '', '99001', 2275, 0, 0, 0, 120, 2, 430, 250000, 0, 'DamA,DamB', 0, 0),
('99001', '對艦用大型反應彈', 11, 'N', '0', '', '', 1330, 0, 0, 0, 120, 4, 650, 1000000, 0, 'DamA,DamB,AntiPDef', 0, 0),
('995', '斬艦刀．一文字斬', 11, 'N', '0', '', '', 4990, 0, 0, 0, 120, 2, 450, 250000, 0, 'AntiPDef,DamA,DamB,Cease', 0, 0),
('996', '浮游炮', 10, 'N', '0', '', '', 385, 0, 0, 0, 120, 12, 350, 165000, 0, 'NTCustom,Cease,AntiPDef,CostSP<12>', 0, 0),
('997', '飛翔炮', 10, 'N', '0', '', '', 405, 0, 0, 0, 130, 12, 360, 168000, 0, 'NTCustom,Cease,AntiPDef,CostSP<15>', 0, 0),
('998', 'HiMAT System', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 295, 1300000, 2, 'Mobe,AntiTarS', 0, 0),
('999', 'E - cap', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, 0, 1700000, 2, 'ENPcRecA', 0, 0),
('FortWepA', '對空自動火神炮炮塔系統', 0, 'I', '0', '', '', 1000, 0, 0, 0, 120, 40, 0, 500000, 0, 'Cease, DamA, FortressOnly, CannotEquip', 0, 0),
('FortWepB', '防守用連裝對艦飛彈炮台', 0, 'I', '0', '', '', 1000, 0, 0, 0, 120, 20, 0, 5500000, 0, 'TarD, AntiMobS, Cease, FortressOnly, CannotEquip', 0, 0),
('FortWepC', '陽電子破壞炮', 0, 'I', '0', '', '', 1760, 0, 0, 0, 75, 20, 0, 15000000, 0, 'MeltA, AntiMobS, Cease, FortressOnly, CannotEquip', 0, 0),
('FortWepD', '殖民星雷射炮', 0, 'I', '0', '', '', 50000, 0, 0, 0, 120, 1, 0, 155000000, 0, 'MeltB, AntiMobS, Cease, AntiPDef, TarC, FortressOnly, CannotEquip', 0, 0),
('GMwepA', 'GM專用', 127, 'I', '0', '', '', 65535, 0, 0, 0, 255, 255, 0, 1, 0, 'DamA,DamB,MobA,MobB,MobC,MobD,Moba,Mobb,Mobc,Mobd,Mobe,TarA,TarB,TarC,TarD,Tara,Tarb,Tarc,Tard,Tare,DefA,DefB,DefC,DefD,DefE,Defa,Defb,Defc,Defd,Defe,PerfDef,AntiDam,DoubleExp,DoubleMon,DefX,AtkA,MeltA,MeltB,Cease,AntiPDef,AntiTars', 1, 0),
('1000', '高振動粒子刀', 1, 'BDI', '1000', '1006,1007', '', 700, 0, 0, 0, 99, 2, 170, 2345678, 0, 'DamA', 0, 0),
('1001', '朗基努斯之槍', 11, 'N', '1000', '', '', 7500, 0, 10, 25, 123, 2, 500, 1, 0, 'DamA,DamB,Cease,AntiPDef,EVAonly', 1, 2),
('1002', '超級電磁線圈引擎', 2, 'BDI', '1002', '', '', 0, 0, 0, 0, 0, 0, 100, 10000000, 1, 'AntiMobS', 0, 0),
('1003', 'A.T.力場', 4, 'N', '1003', '', '', 0, 0, 0, 0, 0, 0, 100, 1, 2, '', 1, 0),
('1005', 'MAGI System', 1, 'N', '1005', '', '', 0, 0, 0, 0, 0, 0, 200, 1, 2, '', 1, 0),
('1004', 'Jet Alone', 4, 'N', '1004', '', '', 2500, 0, 0, 0, 100, 2, 250, 1, 0, 'AntiPDef,MobA', 1, 0),
('1006', '高振動粒子炮', 1, 'N', '1000', '', '', 1200, 0, 0, 0, 100, 2, 200, 2345678, 0, 'DamA', 1, 0),
('1007', '高振動粒子槍', 1, 'N', '1000', '', '', 800, 0, 0, 0, 100, 3, 200, 2345678, 0, 'DamA', 1, 0),
('1008', '尼布甲尼撒鑰匙', 11, 'N', '1008', '', '', 0, 0, 0, 0, 0, 0, 0, 1, 2, '', 1, 0),
('1009', '404 Not Found', 11, 'N', '1009', '', '', 0, 0, 0, 0, 0, 0, 0, 1, 2, '', 1, 0),
('1010', '人類補完計劃書', 11, 'N', '1010', '', '', 0, 0, 0, 0, 0, 0, 0, 1, 2, '', 1, 0),
('1011', '零作用護盾', 7, 'N', '1011', '', '', 0, 0, 0, 0, 0, 0, 250, 0, 2, 'GAtkDef', 1, 0),
('1020', '青銅C0RE', 1, 'N', '701', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 'RawMaterials', 0, 0),
('1021', '鋼鐵C0RE', 1, 'N', '701', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 'RawMaterials', 0, 0),
('1022', '晶石C0RE', 0, 'N', '701', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 'RawMaterials', 0, 0),
('1023', '白銀C0RE', 0, 'N', '701', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 'RawMaterials', 0, 0),
('1024', '黃金C0RE', 0, 'N', '701', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 'RawMaterials', 0, 0),
('1025', '白金C0RE', 1, 'N', '701', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 'RawMaterials', 0, 0),
('1026', '鑽石C0RE', 1, 'N', '701', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 'RawMaterials', 0, 0),
('1027', '水晶C0RE', 1, 'N', '701', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 'RawMaterials', 0, 0),
('1030', 'Goldion Hammer', 10, 'N', '1030', '', '', 7000, 0, 0, 0, 130, 2, 500, 0, 0, 'AntiPDef,MeltB,DamB,Gaoonly', 1, 0),
('1031', 'GGG 指令', 4, 'BDI', '1031', '', '', 0, 0, 0, 0, 0, 0, 0, 10000000, 2, 'RawFinal', 0, 0),
('1032', 'G-STONE', 5, 'N', '1032', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, 'RawFinal', 1, 0),
('1033', 'G-Tools', 1, 'N', '1033', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, 'RawFinal', 1, 0),
('1034', 'GoldyMag', 1, 'N', '1034', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, 'RawFinal', 1, 0),
('1035', 'Hell and Heaven', 6, 'N', '1035', '', '', 1800, 0, 0, 0, 100, 2, 250, 0, 0, 'Cease, MeltB, Gaoonly', 1, 0),
('1036', '中和粒子炮', 7, 'N', '1036', '', '', 350, 0, 0, 0, 75, 10, 300, 0, 0, 'Tare', 1, 0);

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_bank`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_bank` (
  `username` varchar(16) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `savings` bigint(10) unsigned NOT NULL DEFAULT '0',
  `sh_ina` varchar(255) NOT NULL DEFAULT '',
  `sh_inb` varchar(255) NOT NULL DEFAULT '',
  `sh_inc` varchar(255) NOT NULL DEFAULT '',
  `sh_outa` varchar(255) NOT NULL DEFAULT '',
  `sh_outb` varchar(255) NOT NULL DEFAULT '',
  `sh_outc` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_user_bank`
--

INSERT INTO `vsqa_phpeb_user_bank` (`username`, `status`, `savings`, `sh_ina`, `sh_inb`, `sh_inc`, `sh_outa`, `sh_outb`, `sh_outc`) VALUES
('NPC5648', 0, 0, '', '', '', '', '', ''),
('NPC5649', 0, 0, '', '', '', '', '', ''),
('NPC5650', 0, 0, '', '', '', '', '', ''),
('NPC5657', 0, 0, '', '', '', '', '', ''),
('NPC5658', 0, 0, '', '', '', '', '', ''),
('NPC5659', 0, 0, '', '', '', '', '', ''),
('NPC5660', 0, 0, '', '', '', '', '', ''),
('NPC5661', 0, 0, '', '', '', '', '', ''),
('NPC5662', 0, 0, '', '', '', '', '', ''),
('NPC5663', 0, 0, '', '', '', '', '', ''),
('NPC5664', 0, 0, '', '', '', '', '', ''),
('NPC5665', 0, 0, '', '', '', '', '', ''),
('NPC5666', 0, 0, '', '', '', '', '', ''),
('NPC6666', 0, 0, '', '', '', '', '', ''),
('NPC4444', 0, 0, '', '', '', '', '', ''),
('NPC4443', 0, 0, '', '', '', '', '', ''),
('NPC4442', 0, 0, '', '', '', '', '', ''),
('NPC4441', 0, 0, '', '', '', '', '', ''),
('NPC4440', 0, 0, '', '', '', '', '', ''),
('NPC4445', 0, 0, '', '', '', '', '', ''),
('NPC4446', 0, 0, '', '', '', '', '', ''),
('NPC4447', 0, 0, '', '', '', '', '', ''),
('NPC4448', 0, 0, '', '', '', '', '', ''),
('NPC4449', 0, 0, '', '', '', '', '', ''),
('NPC1116', 0, 0, '', '', '', '', '', ''),
('NPC1117', 0, 0, '', '', '', '', '', ''),
('NPC1118', 0, 0, '', '', '', '', '', ''),
('NPC1119', 0, 0, '', '', '', '', '', ''),
('NPC2000', 0, 0, '', '', '', '', '', ''),
('NPC2001', 0, 0, '', '', '', '', '', ''),
('NPC2002', 0, 0, '', '', '', '', '', ''),
('NPC2003', 0, 0, '', '', '', '', '', ''),
('NPC2004', 0, 0, '', '', '', '', '', ''),
('NPC2005', 0, 0, '', '', '', '', '', ''),
('NPC2006', 0, 0, '', '', '', '', '', ''),
('NPC2007', 0, 0, '', '', '', '', '', ''),
('NPC2008', 0, 0, '', '', '', '', '', ''),
('NPC2009', 0, 0, '', '', '', '', '', ''),
('NPC0000', 0, 0, '', '', '', '', '', ''),
('NPC0001', 0, 0, '', '', '', '', '', ''),
('NPC0002', 0, 0, '', '', '', '', '', ''),
('NPC0003', 0, 0, '', '', '', '', '', ''),
('NPC0004', 0, 0, '', '', '', '', '', ''),
('NPC0005', 0, 0, '', '', '', '', '', ''),
('NPC0006', 0, 0, '', '', '', '', '', ''),
('NPC0007', 0, 0, '', '', '', '', '', ''),
('NPC0008', 0, 0, '', '', '', '', '', ''),
('NPC0009', 0, 0, '', '', '', '', '', ''),
('NPC0010', 0, 0, '', '', '', '', '', ''),
('NPC0011', 0, 0, '', '', '', '', '', ''),
('NPC0012', 0, 0, '', '', '', '', '', ''),
('NPC0013', 0, 0, '', '', '', '', '', ''),
('NPC0014', 0, 0, '', '', '', '', '', ''),
('NPC0015', 0, 0, '', '', '', '', '', ''),
('NPC0016', 0, 0, '', '', '', '', '', ''),
('NPC0017', 0, 0, '', '', '', '', '', ''),
('NPC0018', 0, 0, '', '', '', '', '', ''),
('NPC0019', 0, 0, '', '', '', '', '', ''),
('NPC0020', 0, 0, '', '', '', '', '', ''),
('NPC0021', 0, 0, '', '', '', '', '', ''),
('NPC0022', 0, 0, '', '', '', '', '', ''),
('NPC0023', 0, 0, '', '', '', '', '', ''),
('NPC0024', 0, 0, '', '', '', '', '', ''),
('NPC0025', 0, 0, '', '', '', '', '', ''),
('NPC0026', 0, 0, '', '', '', '', '', ''),
('NPC0027', 0, 0, '', '', '', '', '', ''),
('NPC0028', 0, 0, '', '', '', '', '', ''),
('NPC0029', 0, 0, '', '', '', '', '', ''),
('NPC0030', 0, 0, '', '', '', '', '', ''),
('NPC0031', 0, 0, '', '', '', '', '', ''),
('NPC0032', 0, 0, '', '', '', '', '', ''),
('NPC0033', 0, 0, '', '', '', '', '', ''),
('NPC0034', 0, 0, '', '', '', '', '', ''),
('NPC0035', 0, 0, '', '', '', '', '', ''),
('NPC0036', 0, 0, '', '', '', '', '', ''),
('NPC0037', 0, 0, '', '', '', '', '', ''),
('NPC0038', 0, 0, '', '', '', '', '', ''),
('NPC0039', 0, 0, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_bank_log`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_bank_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) NOT NULL DEFAULT '0',
  `user` varchar(16) NOT NULL DEFAULT '',
  `g_name` varchar(32) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `cash` int(10) unsigned NOT NULL DEFAULT '0',
  `bankamt` int(10) unsigned NOT NULL DEFAULT '0',
  `t_cash` int(10) unsigned NOT NULL DEFAULT '0',
  `t_bankamt` int(10) unsigned NOT NULL DEFAULT '0',
  `target` varchar(16) NOT NULL DEFAULT '',
  `tg_name` varchar(32) NOT NULL DEFAULT '',
  `safehouse` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1150 ;

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_game_info`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_game_info` (
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `gamename` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `hp` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `hpmax` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `en` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `enmax` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `sp` float(9,5) unsigned NOT NULL DEFAULT '0.00000',
  `spmax` smallint(3) unsigned NOT NULL DEFAULT '1',
  `attacking` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `defending` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `reacting` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `targeting` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `ms_custom` varchar(255) NOT NULL DEFAULT '',
  `level` smallint(4) unsigned NOT NULL DEFAULT '1',
  `expr` int(10) unsigned NOT NULL DEFAULT '0',
  `wepa` varchar(255) NOT NULL DEFAULT '0<!>0',
  `wepb` varchar(255) NOT NULL DEFAULT '0<!>0',
  `wepc` varchar(255) NOT NULL DEFAULT '0<!>0',
  `eqwep` varchar(255) NOT NULL DEFAULT '0<!>0',
  `p_equip` varchar(255) NOT NULL DEFAULT '0<!>0',
  `spec` mediumtext NOT NULL,
  `rank` mediumint(6) NOT NULL DEFAULT '0',
  `rights` char(1) NOT NULL DEFAULT '0',
  `organization` int(10) NOT NULL DEFAULT '0',
  `org_group` char(1) NOT NULL DEFAULT '0',
  `tactics` mediumtext NOT NULL,
  `last_tact` varchar(16) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `victory` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `v_points` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `lastatk` varchar(20) NOT NULL,
  `atktime` varchar(20) NOT NULL,
  `isnpc` tinyint(1) NOT NULL DEFAULT '0',
  `lastorg` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`),
  UNIQUE KEY `gamename` (`gamename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_user_game_info`
--

INSERT INTO `vsqa_phpeb_user_game_info` (`username`, `gamename`, `hp`, `hpmax`, `en`, `enmax`, `sp`, `spmax`, `attacking`, `defending`, `reacting`, `targeting`, `ms_custom`, `level`, `expr`, `wepa`, `wepb`, `wepc`, `eqwep`, `p_equip`, `spec`, `rank`, `rights`, `organization`, `org_group`, `tactics`, `last_tact`, `status`, `victory`, `v_points`, `lastatk`, `atktime`, `isnpc`, `lastorg`) VALUES
('NPC1117', 'NPC1117', 100000, 100000, 1000, 1000, 55.00000, 55, 7, 5, 7, 3, '', 750, 15965, '203<!>50', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC1116', 'NPC1116', 100000, 100000, 1000, 1000, 51.00000, 51, 7, 4, 7, 3, '', 650, 6059, '203<!>178', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9530', 'NPC9530', 100000, 100000, 1000, 1000, 440.00000, 440, 0, 0, 0, 0, '', 353, 1808391, '203<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9531', 'NPC9531', 100000, 100000, 1000, 1000, 362.00000, 362, 0, 2, 1, 4, '', 450, 13979609, '203<!>175', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9532', 'NPC9532', 0, 100000, 989, 1000, 249.00000, 249, 4, 4, 4, 2, '', 551, 12640478, '203<!>68', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 1, 0, 0, '', '', 1, '0'),
('NPC9533', 'NPC9533', 100000, 100000, 1000, 1000, 201.00000, 201, 3, 5, 5, 5, '', 651, 25116413, '203<!>97', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9534', 'NPC9534', 100000, 100000, 1000, 1000, 216.00000, 216, 0, 0, 0, 0, '', 750, 17842853, '203<!>1769', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9535', 'NPC9535', 100000, 100000, 1000, 1000, 198.00000, 198, 3, 5, 1, 3, '', 850, 19079057, '203<!>406', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9536', 'NPC9536', 100000, 100000, 1000, 1000, 209.00000, 209, 4, 0, 4, 3, '', 951, 75583803, '203<!>132', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9537', 'NPC9537', 100000, 100000, 1000, 1000, 195.00000, 195, 4, 0, 3, 1, '', 1000, 0, '203<!>7334', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9538', 'NPC9538', 100000, 100000, 1000, 1000, 257.00000, 257, 4, 4, 4, 2, '', 1000, 163266, '203<!>67', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9539', 'NPC9539', 100000, 100000, 1000, 1000, 195.00000, 195, 5, 4, 5, 4, '', 1000, 59903, '203<!>111', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9540', 'NPC9540', 100000, 100000, 1000, 1000, 187.00000, 187, 4, 5, 5, 5, '', 1000, 37395, '203<!>145', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9541', 'NPC9541', 100000, 100000, 1000, 1000, 201.00000, 201, 4, 4, 4, 4, '', 1000, 69565, '203<!>114', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9542', 'NPC9542', 100000, 100000, 1000, 1000, 184.00000, 184, 4, 3, 5, 2, '', 1000, 20463, '203<!>183', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC9543', 'NPC9543', 100000, 100000, 1000, 1000, 174.00000, 174, 4, 4, 4, 5, '', 1000, 14080, '203<!>108', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC1118', 'NPC1118', 100000, 100000, 1000, 1000, 61.00000, 61, 1, 3, 7, 5, '', 850, 86450, '203<!>52', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC1110', 'NPC1110', 100000, 100000, 1000, 1000, 188.00000, 188, 5, 5, 5, 5, '', 76, 10129, '203<!>23245', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC1111', 'NPC1111', 100000, 100000, 1000, 1000, 238.00000, 238, 5, 5, 4, 4, '', 163, 385922, '203<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC1114', 'NPC1114', 100000, 100000, 1000, 1000, 184.00000, 184, 4, 5, 4, 3, '', 450, 3537341, '203<!>1494', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC1112', 'NPC1112', 100000, 100000, 1000, 1000, 169.00000, 169, 2, 4, 4, 3, '', 266, 637881, '203<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC1113', 'NPC1113', 100000, 100000, 1000, 1000, 198.00000, 198, 5, 5, 5, 4, '', 361, 234854, '203<!>1631', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC1115', 'NPC1115', 100000, 100000, 1000, 1000, 185.00000, 185, 5, 5, 5, 5, '', 550, 13402, '203<!>257', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC2009', 'NPC2009', 100000, 100000, 1000, 1000, 167.00000, 167, 7, 0, 0, 4, '', 950, 473793, '201<!>2992', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5649', 'NPC5649', 100000, 100000, 1000, 1000, 177.00000, 177, 4, 5, 5, 4, '', 168, 41766, '203<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5659', 'NPC5659', 100000, 100000, 1000, 1000, 254.00000, 254, 5, 4, 3, 5, '', 551, 13635462, '203<!>1055', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5660', 'NPC5660', 100000, 100000, 1000, 1000, 154.00000, 154, 5, 5, 5, 5, '', 652, 31206316, '203<!>56', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5661', 'NPC5661', 100000, 100000, 1000, 1000, 151.00000, 151, 5, 5, 5, 5, '', 752, 32396325, '203<!>107', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5663', 'NPC5663', 100000, 100000, 1000, 1000, 326.00000, 326, 3, 1, 1, 3, '', 950, 7091739, '203<!>653', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5664', 'NPC5664', 100000, 100000, 1000, 1000, 170.00000, 170, 4, 5, 5, 5, '', 62, 17210, '203<!>704', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5665', 'NPC5665', 100000, 100000, 1000, 1000, 173.00000, 173, 4, 5, 5, 4, '', 155, 206900, '203<!>10279', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5650', 'NPC5650', 100000, 100000, 1000, 1000, 185.00000, 185, 1, 3, 4, 3, '', 271, 914670, '203<!>7356', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5662', 'NPC5662', 100000, 100000, 1000, 1000, 166.00000, 166, 4, 5, 5, 5, '', 850, 40800973, '203<!>55', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5666', 'NPC5666', 100000, 100000, 1000, 1000, 154.00000, 154, 4, 5, 5, 3, '', 253, 2177077, '203<!>460', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5658', 'NPC5658', 100000, 100000, 1000, 1000, 166.00000, 166, 4, 3, 5, 3, '', 451, 9956750, '203<!>3096', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5657', 'NPC5657', 100000, 100000, 1000, 1000, 168.00000, 168, 5, 4, 5, 5, '', 355, 2587709, '203<!>2206', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC5648', 'NPC5648', 100000, 100000, 1000, 1000, 218.00000, 218, 2, 5, 4, 5, '', 85, 97754, '203<!>8473', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC2003', 'NPC2003', 100000, 100000, 1000, 1000, 51.00000, 51, 8, 9, 0, 1, '', 354, 3567598, '201<!>61', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC1119', 'NPC1119', 100000, 100000, 1000, 1000, 107.00000, 107, 6, 6, 5, 3, '', 950, 16672559, '203<!>239', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC2007', 'NPC2007', 100000, 100000, 1000, 1000, 7.00000, 7, 0, 0, 0, 0, '', 751, 14613393, '201<!>6', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC4445', 'NPC4445', 100000, 100000, 1000, 1000, 159.00000, 159, 0, 0, 0, 0, '', 551, 9172439, '203<!>1890', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC4444', 'NPC4444', 100000, 100000, 1000, 1000, 63.00000, 63, 0, 0, 0, 0, '', 452, 9392241, '203<!>67', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC4447', 'NPC4447', 100000, 100000, 1000, 1000, 78.00000, 78, 2, 0, 1, 0, '', 750, 13059751, '203<!>3072', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC4446', 'NPC4446', 100000, 100000, 1000, 1000, 65.00000, 65, 7, 5, 3, 1, '', 650, 5515479, '203<!>6374', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC2004', 'NPC2004', 100000, 100000, 1000, 1000, 13.00000, 13, 0, 7, 0, 6, '', 454, 1419829, '201<!>272', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC4443', 'NPC4443', 100000, 100000, 1000, 1000, 206.00000, 206, 0, 0, 0, 0, '', 351, 6697292, '203<!>18792', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC4449', 'NPC4449', 100000, 100000, 1000, 1000, 53.00000, 53, 5, 5, 5, 3, '', 950, 1590768, '203<!>311', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC4442', 'NPC4442', 100000, 100000, 1000, 1000, 360.00000, 360, 0, 0, 0, 0, '', 257, 2464932, '203<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC4440', 'NPC4440', 100000, 100000, 1000, 1000, 70.00000, 70, 0, 5, 3, 4, '', 61, 36577, '203<!>5479', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC4441', 'NPC4441', 0, 100000, 934, 1000, 222.00000, 222, 0, 0, 0, 0, '', 164, 405136, '203<!>12123', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 1, 0, 0, '', '', 1, '0'),
('NPC4448', 'NPC4448', 100000, 100000, 1000, 1000, 79.00000, 79, 1, 2, 1, 1, '', 852, 36453970, '203<!>65', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC2001', 'NPC2001', 100000, 100000, 1000, 1000, 84.00000, 84, 4, 5, 4, 7, '', 173, 803755, '201<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC2000', 'NPC2000', 100000, 100000, 1000, 1000, 129.00000, 129, 5, 3, 7, 4, '', 95, 46224, '201<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC2002', 'NPC2002', 100000, 100000, 1000, 1000, 46.00000, 46, 1, 7, 9, 1, '', 268, 75805, '201<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC2005', 'NPC2005', 100000, 100000, 1000, 1000, 56.00000, 56, 1, 7, 7, 2, '', 555, 3412801, '201<!>586', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC2006', 'NPC2006', 100000, 100000, 1000, 1000, 39.00000, 39, 1, 0, 0, 1, '', 652, 12110506, '201<!>420', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC2008', 'NPC2008', 100000, 100000, 1000, 1000, 10.00000, 10, 3, 5, 5, 1, '', 852, 69989566, '201<!>840', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0001', 'NPC0001', 100000, 100000, 1000, 1000, 198.00000, 198, 7, 4, 6, 4, '', 171, 842354, '401<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0003', 'NPC0003', 100000, 100000, 1000, 1000, 168.00000, 168, 4, 7, 4, 7, '', 351, 5934084, '401<!>6285', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0000', 'NPC0000', 100000, 100000, 1000, 1000, 227.00000, 227, 2, 4, 5, 4, '', 89, 97871, '401<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0002', 'NPC0002', 100000, 100000, 1000, 1000, 186.00000, 186, 0, 2, 0, 3, '', 264, 3473899, '401<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0008', 'NPC0008', 100000, 100000, 1000, 1000, 167.00000, 167, 6, 6, 3, 7, '', 850, 218367, '401<!>1000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0018', 'NPC0018', 100000, 100000, 1000, 1000, 167.00000, 167, 3, 6, 6, 7, '', 850, 1064242, '401<!>1000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0004', 'NPC0004', 100000, 100000, 1000, 1000, 167.00000, 167, 7, 4, 4, 7, '', 450, 462885, '401<!>1000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0005', 'NPC0005', 100000, 100000, 1000, 1000, 169.00000, 169, 4, 6, 4, 6, '', 550, 877485, '401<!>1037', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0006', 'NPC0006', 100000, 100000, 1000, 1000, 168.00000, 168, 7, 7, 4, 4, '', 650, 2459007, '401<!>1023', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0007', 'NPC0007', 100000, 100000, 1000, 1000, 167.00000, 167, 4, 8, 3, 7, '', 750, 488872, '401<!>1000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0009', 'NPC0009', 100000, 100000, 1000, 1000, 167.00000, 167, 9, 3, 3, 7, '', 950, 7963132, '401<!>4237', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0010', 'NPC0010', 100000, 100000, 1000, 1000, 232.00000, 232, 4, 0, 0, 1, '', 73, 73802, '401<!>15435', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0011', 'NPC0011', 100000, 100000, 1000, 1000, 202.00000, 202, 4, 5, 4, 6, '', 172, 709138, '401<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0012', 'NPC0012', 0, 100000, 990, 1000, 191.00000, 191, 6, 3, 4, 1, '', 268, 270521, '401<!>21079', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 1, 0, 0, '', '', 1, '0'),
('NPC0013', 'NPC0013', 100000, 100000, 1000, 1000, 185.00000, 185, 3, 8, 8, 3, '', 362, 8083251, '401<!>3144', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0014', 'NPC0014', 100000, 100000, 1000, 1000, 173.00000, 173, 7, 3, 1, 8, '', 455, 7379200, '401<!>3514', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0015', 'NPC0015', 100000, 100000, 1000, 1000, 171.00000, 171, 2, 7, 3, 8, '', 553, 19727553, '401<!>1000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0016', 'NPC0016', 100000, 100000, 1000, 1000, 167.00000, 167, 0, 5, 7, 4, '', 650, 17945738, '401<!>1000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0017', 'NPC0017', 100000, 100000, 1000, 1000, 167.00000, 167, 0, 1, 4, 5, '', 750, 37803, '401<!>1000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0019', 'NPC0019', 100000, 100000, 1000, 1000, 167.00000, 167, 0, 5, 3, 3, '', 950, 2118386, '401<!>9766', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0020', 'NPC0020', 100000, 100000, 1000, 1000, 212.00000, 212, 4, 4, 7, 7, '', 80, 20835, '401<!>22503', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0031', 'NPC0031', 100000, 100000, 1000, 1000, 195.00000, 195, 3, 7, 1, 4, '', 168, 150104, '401<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0027', 'NPC0027', 100000, 100000, 1000, 1000, 172.00000, 172, 9, 2, 9, 2, '', 750, 1282787, '401<!>1076', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0021', 'NPC0021', 100000, 100000, 1000, 1000, 217.00000, 217, 6, 2, 6, 2, '', 185, 1143893, '401<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0023', 'NPC0023', 100000, 100000, 1000, 1000, 174.00000, 174, 9, 4, 4, 4, '', 357, 3030690, '401<!>1120', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0022', 'NPC0022', 100000, 100000, 1000, 1000, 187.00000, 187, 4, 4, 9, 3, '', 265, 2992298, '401<!>9395', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0028', 'NPC0028', 100000, 100000, 1000, 1000, 175.00000, 175, 4, 10, 6, 2, '', 850, 34060246, '401<!>1000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0024', 'NPC0024', 100000, 100000, 1000, 1000, 168.00000, 168, 0, 0, 0, 0, '', 450, 4001733, '401<!>1237', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0025', 'NPC0025', 100000, 100000, 1000, 1000, 173.00000, 173, 3, 2, 2, 6, '', 550, 372225, '401<!>1000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0026', 'NPC0026', 100000, 100000, 1000, 1000, 172.00000, 172, 6, 8, 2, 2, '', 650, 15682647, '401<!>1000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0029', 'NPC0029', 100000, 100000, 1000, 1000, 174.00000, 174, 0, 2, 0, 4, '', 950, 30679125, '401<!>7591', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0030', 'NPC0030', 100000, 100000, 1000, 1000, 221.00000, 221, 7, 10, 1, 4, '', 86, 122409, '401<!>25000', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0036', 'NPC0036', 100000, 100000, 1000, 1000, 170.00000, 170, 4, 4, 7, 6, '', 652, 29843334, '401<!>1062', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0032', 'NPC0032', 0, 100000, 970, 1000, 178.00000, 178, 2, 9, 2, 3, '', 254, 996456, '401<!>2187<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 1, 0, 0, '', '', 1, '0'),
('NPC0033', 'NPC0033', 100000, 100000, 1000, 1000, 170.00000, 170, 6, 5, 4, 6, '', 351, 1877740, '401<!>3978<!>0', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0034', 'NPC0034', 100000, 100000, 1000, 1000, 185.00000, 185, 6, 5, 4, 6, '', 450, 2225969, '401<!>4707', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0035', 'NPC0035', 100000, 100000, 1000, 1000, 186.00000, 186, 3, 1, 0, 4, '', 550, 15617069, '401<!>2080', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0038', 'NPC0038', 100000, 100000, 1000, 1000, 169.00000, 169, 5, 7, 3, 5, '', 850, 2979687, '401<!>1775', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0037', 'NPC0037', 100000, 100000, 1000, 1000, 169.00000, 169, 4, 5, 5, 2, '', 750, 34544122, '401<!>1024', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0'),
('NPC0039', 'NPC0039', 100000, 100000, 1000, 1000, 172.00000, 172, 5, 4, 5, 2, '', 950, 8992563, '401<!>4069', '0<!>0', '0<!>0', '0<!>0', '0<!>0', '', 0, '0', 0, '0', '', '', 0, 0, 0, '', '', 1, '0');

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_general_info`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_general_info` (
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `regkey` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `cash` bigint(10) unsigned NOT NULL DEFAULT '0',
  `bounty` int(10) unsigned NOT NULL DEFAULT '0',
  `color` tinytext,
  `avatar` varchar(16) DEFAULT NULL,
  `msuit` varchar(16) DEFAULT NULL,
  `typech` varchar(4) NOT NULL DEFAULT 'nat1',
  `hypermode` tinyint(1) NOT NULL DEFAULT '0',
  `growth` mediumint(7) DEFAULT NULL,
  `coordinates` varchar(4) NOT NULL DEFAULT 'A1',
  `fame` smallint(4) NOT NULL DEFAULT '0',
  `request` text NOT NULL,
  `time1` int(10) DEFAULT NULL,
  `time2` int(10) DEFAULT NULL,
  `btltime` int(10) DEFAULT NULL,
  `acc_status` tinyint(1) NOT NULL DEFAULT '0',
  `lastip` varchar(60) NOT NULL,
  `Gold` int(10) NOT NULL DEFAULT '0',
  `bcount` smallint(3) NOT NULL DEFAULT '0',
  `evamode` tinyint(1) NOT NULL DEFAULT '0',
  `lastlogin` int(10) NOT NULL DEFAULT '0',
  `modtype` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_user_general_info`
--

INSERT INTO `vsqa_phpeb_user_general_info` (`username`, `password`, `regkey`, `cash`, `bounty`, `color`, `avatar`, `msuit`, `typech`, `hypermode`, `growth`, `coordinates`, `fame`, `request`, `time1`, `time2`, `btltime`, `acc_status`, `lastip`, `Gold`, `bcount`, `evamode`, `lastlogin`, `modtype`) VALUES
('NPC1116', '0', '0', 360000, 0, '#00E196', 'nil', '9527', 'psy1', 0, 544, 'D10', 0, '', 1448888408, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9530', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 6774, 'C3', 0, '', 1451335269, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9531', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 4250, 'D10', 0, '', 1451241912, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9532', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 1767, 'D10', 0, '', 1451251859, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9533', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 1121, 'D10', 0, '', 1450016393, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9534', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 1226, 'D10', 0, '', 1450083858, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9535', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 954, 'D10', 0, '', 1450074610, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9536', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 1257, 'D10', 0, '', 1450086874, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9537', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 905, 'D10', 0, '', 1450724617, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9538', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 1843, 'D10', 0, '', 1448972021, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9539', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 901, 'D10', 0, '', 1448901228, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9540', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 837, 'D10', 0, '', 1448965689, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9541', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 1009, 'D10', 0, '', 1448977752, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9542', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 776, 'D10', 0, '', 1448530816, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC9543', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 708, 'D10', 0, '', 1448762634, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC1117', '0', '0', 360000, 0, '#00E196', 'nil', '9527', 'psy1', 0, 640, 'D10', 0, '', 1450017364, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC1118', '0', '0', 360000, 0, '#00A56E', 'nil', '9527', 'psy1', 0, 660, 'D10', 0, '', 1450077600, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC1119', '0', '0', 360000, 0, '#FF0095', 'nil', '9527', 'psy1', 0, 1368, 'D10', 0, '', 1450240685, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC2009', '0', '0', 240000, 0, '#FF3CFF', 'nil', '9527', 'co1', 0, 3730, 'D10', 0, '', 1450448883, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC2000', '0', '0', 480000, 0, '#8200C3', 'nil', '9527', 'enh1', 0, 1918, 'B3', 0, '', 1451467127, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC2001', '0', '0', 240000, 0, '#8200C3', 'nil', '9527', 'co1', 0, 1711, 'B3', 0, '', 1451470506, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC2002', '0', '0', 480000, 0, '#8200C3', 'nil', '9527', 'enh1', 0, 1390, 'B3', 0, '', 1451468883, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC2003', '0', '0', 600000, 0, '#FF3CFF', 'nil', '9527', 'nat1', 0, 1086, 'B3', 0, '', 1451351906, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC2004', '0', '0', 600000, 0, '#FF3CFF', 'nil', '9527', 'nat1', 0, 559, 'D10', 0, '', 1450151414, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC2005', '0', '0', 360000, 0, '#FF3CFF', 'nil', '9527', 'psy1', 0, 1475, 'D10', 0, '', 1450431126, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC2006', '0', '0', 480000, 0, '#FF3CFF', 'nil', '9527', 'ext1', 0, 919, 'D10', 0, '', 1450226482, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC2007', '0', '0', 240000, 0, '#FF3CFF', 'nil', '9527', 'co1', 0, 268, 'D10', 0, '', 1450448903, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC2008', '0', '0', 240000, 0, '#FF3CFF', 'nil', '9527', 'co1', 0, 509, 'D10', 0, '', 1450448838, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC1111', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 1927, 'B2', 0, '', 1451510422, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC1112', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 1338, 'B2', 0, '', 1451481810, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC1113', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 1644, 'B2', 0, '', 1451391622, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC1114', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 850, 'D10', 0, '', 1450061753, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC1115', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 852, 'D10', 0, '', 1451250679, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC1110', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 857, 'B2', 0, '', 1451510394, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC4444', '0', '0', 360000, 0, '#FFCE3C', 'nil', '9527', 'psy1', 0, 1646, 'D10', 0, '', 1451243892, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC4442', '0', '0', 480000, 0, '#FFCE3C', 'nil', '9527', 'ext1', 0, 13693, 'C1', 0, '', 1451449871, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC4441', '0', '0', 480000, 0, '#EBB000', 'nil', '9527', 'ext1', 0, 6805, 'C1', 0, '', 1451471186, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC4443', '0', '0', 360000, 1, '#FFCE3C', 'nil', '9527', 'psy1', 0, 6523, 'C1', 0, '', 1451436591, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC4440', '0', '0', 240000, 0, '#0092C3', 'nil', '9527', 'co1', 0, 1530, 'C1', 0, '', 1451385553, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC4446', '0', '0', 480000, 0, '#C3C300', 'nil', '9527', 'enh1', 0, 1624, 'D10', 0, '', 1449631834, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC4445', '0', '0', 240000, 0, '#0092C3', 'nil', '9527', 'co1', 0, 4736, 'D10', 0, '', 1450724617, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC4447', '0', '0', 600000, 0, '#C3C300', 'nil', '9527', 'nat1', 0, 1961, 'D10', 0, '', 1450064069, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC4448', '0', '0', 480000, 0, '#AA00FF', 'nil', '9527', 'enh1', 0, 2264, 'D10', 0, '', 1450082928, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC4449', '0', '0', 240000, 0, '#AA00FF', 'nil', '9527', 'nt1', 0, 1340, 'D10', 0, '', 1450018965, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5665', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 804, 'C3', 0, '', 1451411888, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5664', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 633, 'C3', 0, '', 1451032867, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5663', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 3564, 'D10', 0, '', 1450152559, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5661', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 711, 'D10', 0, '', 1449634878, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5662', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 603, 'D10', 0, '', 1449668103, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5660', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 718, 'D10', 0, '', 1450407606, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5659', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 2050, 'D10', 0, '', 1450442486, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5658', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 678, 'D10', 0, '', 1449836363, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5657', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 916, 'C2', 0, '', 1451373882, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5650', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 1631, 'C2', 0, '', 1451403428, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5666', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 595, 'C3', 0, '', 1451470568, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5649', '0', '', 0, 0, '#A50000', 'nil', '9527', 'nat1', 0, 1102, 'C2', 0, '', 1451402457, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC5648', '0', '', 0, 1, '#A50000', 'nil', '9527', 'nat1', 0, 1199, 'C2', 0, '', 1451510275, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0000', '0', '0', 600000, 0, '#FFBF00', 'nil', '9527', 'nat1', 0, 1019, 'A1', 0, '', 1451510131, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0025', '0', '0', 480000, 0, '#FFCE3C', 'nil', '9527', 'enh1', 0, 318, 'D10', 0, '', 1449326005, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0001', '0', '0', 480000, 0, '#FFBF00', 'nil', '9527', 'enh1', 0, 727, 'A1', 0, '', 1451510131, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0002', '0', '0', 480000, 0, '#FFDD78', 'nil', '9527', 'enh1', 0, 755, 'A1', 0, '', 1451314457, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0003', '0', '0', 240000, 0, '#0000E1', 'nil', '9527', 'co1', 0, 73, 'A1', 0, '', 1451304048, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0004', '0', '0', 240000, 0, '#C30072', 'nil', '9527', 'co1', 0, 0, 'D10', 0, '', 1451250766, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0005', '0', '0', 240000, 0, '#FFCE3C', 'nil', '9527', 'co1', 0, 126, 'D10', 0, '', 1449331428, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0024', '0', '0', 480000, 0, '#0000E1', 'nil', '9527', 'enh1', 0, 63, 'D10', 0, '', 1450724618, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0006', '0', '0', 240000, 0, '#E10083', 'nil', '9527', 'co1', 0, 63, 'D10', 0, '', 1449170627, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0032', '0', '0', 480000, 0, '#00E100', 'nil', '9527', 'ext1', 0, 655, 'B1', 0, '', 1451492629, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0007', '0', '0', 360000, 0, '#E10083', 'nil', '9527', 'psy1', 0, 0, 'D10', 0, '', 1448894144, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0008', '0', '0', 480000, 0, '#E10083', 'nil', '9527', 'enh1', 0, 0, 'D10', 0, '', 1448894120, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0009', '0', '0', 240000, 0, '#E10083', 'nil', '9527', 'nt1', 0, 0, 'D10', 0, '', 1449234865, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0010', '0', '0', 360000, 0, '#BE3CFF', 'nil', '9527', 'psy1', 0, 1765, 'A2', 0, '', 1451325304, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0023', '0', '0', 480000, 0, '#0000E1', 'nil', '9527', 'ext1', 0, 513, 'A3', 0, '', 1451510065, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0011', '0', '0', 360000, 0, '#00E100', 'nil', '9527', 'psy1', 0, 953, 'A2', 0, '', 1451470946, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0012', '0', '0', 360000, 0, '#00E100', 'nil', '9527', 'psy1', 0, 1041, 'A2', 0, '', 1451510414, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0013', '0', '0', 360000, 0, '#00E100', 'nil', '9527', 'psy1', 0, 948, 'A2', 0, '', 1451485138, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0014', '0', '0', 480000, 0, '#FF3CFF', 'nil', '9527', 'ext1', 0, 528, 'D10', 0, '', 1449978776, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0015', '0', '0', 600000, 0, '#0000E1', 'nil', '9527', 'nat1', 0, 402, 'D10', 0, '', 1450152806, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0022', '0', '0', 480000, 0, '#0000E1', 'nil', '9527', 'ext1', 0, 810, 'A3', 0, '', 1451436199, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0016', '0', '0', 600000, 0, '#0000E1', 'nil', '9527', 'nat1', 0, 0, 'D10', 0, '', 1450065895, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0031', '0', '0', 480000, 0, '#00A9E1', 'nil', '9527', 'ext1', 0, 933, 'B1', 0, '', 1451401980, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0017', '0', '0', 240000, 0, '#0000E1', 'nil', '9527', 'nt1', 0, 0, 'D10', 0, '', 1449733790, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0018', '0', '0', 480000, 0, '#0000E1', 'nil', '9527', 'enh1', 0, 0, 'D10', 0, '', 1448778882, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0019', '0', '0', 360000, 0, '#0000E1', 'nil', '9527', 'psy1', 0, 0, 'D10', 0, '', 1449236483, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0020', '0', '0', 240000, 0, '#0000E1', 'nil', '9527', 'co1', 0, 465, 'A3', 0, '', 1451374226, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0021', '0', '0', 240000, 0, '#0000E1', 'nil', '9527', 'co1', 0, 1260, 'A3', 0, '', 1451467468, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0026', '0', '0', 240000, 0, '#FFCE3C', 'nil', '9527', 'nt1', 0, 315, 'D10', 0, '', 1449656634, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0027', '0', '0', 600000, 0, '#FFCE3C', 'nil', '9527', 'nat1', 0, 315, 'D10', 0, '', 1449647470, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0028', '0', '0', 600000, 0, '#FFCE3C', 'nil', '9527', 'nat1', 0, 507, 'D10', 0, '', 1450075530, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0029', '0', '0', 480000, 0, '#00E100', 'nil', '9527', 'ext1', 0, 443, 'D10', 0, '', 1450102722, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0030', '0', '0', 480000, 0, '#00A9E1', 'nil', '9527', 'ext1', 0, 769, 'B1', 0, '', 1451387014, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0033', '0', '0', 480000, 0, '#00BFFF', 'nil', '9527', 'enh1', 0, 199, 'B1', 0, '', 1451455963, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0034', '0', '0', 360000, 0, '#EBEB00', 'nil', '9527', 'psy1', 0, 830, 'D10', 0, '', 1450070183, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0035', '0', '0', 240000, 0, '#00E100', 'nil', '9527', 'nt1', 0, 895, 'D10', 0, '', 1449464323, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0036', '0', '0', 240000, 0, '#E100E1', 'nil', '9527', 'nt1', 0, 329, 'D10', 0, '', 1449563503, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0037', '0', '0', 480000, 0, '#E100E1', 'nil', '9527', 'enh1', 0, 126, 'D10', 0, '', 1449714470, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0038', '0', '0', 480000, 0, '#E100E1', 'nil', '9527', 'enh1', 0, 126, 'D10', 0, '', 1449236345, 0, 0, 0, '', 0, 0, 0, 0, 1),
('NPC0039', '0', '0', 480000, 0, '#E100E1', 'nil', '9527', 'enh1', 0, 315, 'D10', 0, '', 1450200149, 0, 0, 0, '', 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_hangar`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_hangar` (
  `h_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `h_user` varchar(16) NOT NULL DEFAULT '',
  `h_msuit` varchar(16) NOT NULL DEFAULT '',
  `h_hp` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `h_hpmax` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `h_en` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `h_enmax` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `h_ms_custom` varchar(255) NOT NULL DEFAULT '',
  `h_wepa` varchar(255) NOT NULL DEFAULT '',
  `h_wepb` varchar(255) NOT NULL DEFAULT '',
  `h_wepc` varchar(255) NOT NULL DEFAULT '',
  `h_eqwep` varchar(255) NOT NULL DEFAULT '',
  `h_p_equip` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`h_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_log`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_log` (
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `log1` text NOT NULL,
  `log2` text NOT NULL,
  `log3` text NOT NULL,
  `log4` text NOT NULL,
  `log5` text NOT NULL,
  `time1` int(10) NOT NULL DEFAULT '0',
  `time2` int(10) NOT NULL DEFAULT '0',
  `time3` int(10) NOT NULL DEFAULT '0',
  `time4` int(10) NOT NULL DEFAULT '0',
  `time5` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_user_log`
--

INSERT INTO `vsqa_phpeb_user_log` (`username`, `log1`, `log2`, `log3`, `log4`, `log5`, `time1`, `time2`, `time3`, `time4`, `time5`) VALUES
('NPC5648', '美堂 蠻與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451188482, 0, 0, 0, 0),
('NPC5649', '卡沙丁與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451267745, 0, 0, 0, 0),
('NPC5650', '卡沙丁與你交戰！你被對手的無限正義高達擊敗。', '', '', '', '', 1451403424, 0, 0, 0, 0),
('NPC5657', 'ChocoMilk與你交戰！你被對手的突擊自由高達(流星號)擊敗。', '', '', '', '', 1451362771, 0, 0, 0, 0),
('NPC5658', 'astray與你交戰！你被對手的勇者王擊敗。', '', '', '', '', 1449835940, 0, 0, 0, 0),
('NPC5659', '深水埗CO哥與你交戰！你被對手的Gundam 00擊敗。', '', '', '', '', 1450442480, 0, 0, 0, 0),
('NPC5660', 'BoredAsFuck與你交戰！你被對手的EVA Type F擊敗。', '', '', '', '', 1449451978, 0, 0, 0, 0),
('NPC5661', 'BoredAsFuck與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1449632660, 0, 0, 0, 0),
('NPC5662', 'BoredAsFuck與你交戰！你被對手的EVA Type F擊敗。', '', '', '', '', 1449644726, 0, 0, 0, 0),
('NPC5663', 'BoredAsFuck與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1450149665, 0, 0, 0, 0),
('NPC5664', '美堂 蠻與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1450770964, 0, 0, 0, 0),
('NPC5665', '卡沙丁與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451267984, 0, 0, 0, 0),
('NPC5666', 'BlueSaider與你交戰！你被對手的自由高達擊敗。', '', '', '', '', 1451421191, 0, 0, 0, 0),
('NPC6666', '淫那琵琶小喇叭與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1448101164, 0, 0, 0, 0),
('NPC2005', '合味麥粒與你交戰！你被對手的Gundam 00擊敗。', '', '', '', '', 1450052880, 0, 0, 0, 0),
('NPC4446', '美堂 蠻與你交戰！你被對手的勇者王擊敗。', '', '', '', '', 1449631820, 0, 0, 0, 0),
('NPC4447', 'ChocoMilk與你交戰！你被對手的EVA 二號機擊敗。', '', '', '', '', 1450064057, 0, 0, 0, 0),
('NPC1116', '合味麥粒與你交戰！你被對手的正義高達擊敗。', '', '', '', '', 1448616336, 0, 0, 0, 0),
('NPC4449', '美堂 蠻與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1450018950, 0, 0, 0, 0),
('NPC4444', 'Husky與你交戰！你被對手的突擊自由高達(流星號)擊敗。', '', '', '', '', 1451243887, 0, 0, 0, 0),
('NPC4440', '魔笛與你交戰！你被對手的命運高達擊敗。', '', '', '', '', 1451256108, 0, 0, 0, 0),
('NPC4445', 'ChocoMilk與你交戰！你被對手的EVA 二號機擊敗。', '', '', '', '', 1450019223, 0, 0, 0, 0),
('NPC4448', 'nicklyc與你交戰！你被對手的Gundam 00擊敗。', '', '', '', '', 1450071330, 0, 0, 0, 0),
('NPC4443', '最後使者與你交戰！你被對手的突擊自由高達擊敗。', '', '', '', '', 1451436573, 0, 0, 0, 0),
('NPC4442', '卡沙丁與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451366154, 0, 0, 0, 0),
('NPC4441', '卡沙丁與你交戰！你被對手的天意高達擊敗。', '', '', '', '', 1451338995, 0, 0, 0, 0),
('NPC1117', 'buy1get2與你交戰！你被對手的EVA Type F擊敗。', '', '', '', '', 1450017323, 0, 0, 0, 0),
('NPC2004', 'TAT與你交戰！你被對手的突擊自由高達擊敗。', '', '', '', '', 1450130636, 0, 0, 0, 0),
('NPC1118', 'BoredAsFuck與你交戰！你被對手的EVA 二號機擊敗。', '', '', '', '', 1450067616, 0, 0, 0, 0),
('NPC1119', 'BoredAsFuck與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1450236125, 0, 0, 0, 0),
('NPC2008', 'C0RE與你交戰！你被對手的EVA Type F擊敗。', '', '', '', '', 1450448823, 0, 0, 0, 0),
('NPC2002', 'BlueSaider與你交戰！你被對手的自由高達擊敗。', '', '', '', '', 1451421472, 0, 0, 0, 0),
('NPC2000', '下面好好食與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451376934, 0, 0, 0, 0),
('NPC2001', '下面好好食與你交戰！你被對手的自由高達擊敗。', '', '', '', '', 1451392239, 0, 0, 0, 0),
('NPC2003', '國撚與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451350502, 0, 0, 0, 0),
('NPC2007', 'C0RE與你交戰！你被對手的EVA Type F擊敗。', '', '', '', '', 1450448890, 0, 0, 0, 0),
('NPC2009', 'C0RE與你交戰！你被對手的EVA Type F擊敗。', '', '', '', '', 1450448857, 0, 0, 0, 0),
('NPC2006', '路人D與你交戰！你被對手的Gundam 00擊敗。', '', '', '', '', 1450226149, 0, 0, 0, 0),
('NPC0004', 'Husky與你交戰！你被對手的突擊自由高達(流星號)擊敗。', '', '', '', '', 1451250744, 0, 0, 0, 0),
('NPC0007', 'buy1get2與你交戰！你被對手的無限正義高達擊敗。', '', '', '', '', 1448701631, 0, 0, 0, 0),
('NPC0003', 'ChocoMilk與你交戰！你被對手的突擊自由高達擊敗。', '', '', '', '', 1451207122, 0, 0, 0, 0),
('NPC0008', 'buy1get2與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1448700242, 0, 0, 0, 0),
('NPC0000', '下面好好食與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451373853, 0, 0, 0, 0),
('NPC0032', 'Husky與你交戰！你被對手的突擊自由高達(流星號)擊敗。', '', '', '', '', 1451325539, 0, 0, 0, 0),
('NPC0006', 'GodLike與你交戰！你被對手的EVA 零號機擊敗。', '', '', '', '', 1448864445, 0, 0, 0, 0),
('NPC0021', '香蕉船與你交戰！你被對手的RX-78 GP02A擊敗。', '', '', '', '', 1451324431, 0, 0, 0, 0),
('NPC0005', '深水埗CO哥與你交戰！你被對手的零式高達擊敗。', '', '', '', '', 1449327050, 0, 0, 0, 0),
('NPC0001', '卡沙丁與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451267645, 0, 0, 0, 0),
('NPC0002', 'ChocoMilk與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451204321, 0, 0, 0, 0),
('NPC0009', 'ChocoMilk與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1449234782, 0, 0, 0, 0),
('NPC0010', '香蕉船與你交戰！你被對手的RX-78 GP02A擊敗。', '', '', '', '', 1451325122, 0, 0, 0, 0),
('NPC0015', '路人D與你交戰！你被對手的Gundam 00擊敗。', '', '', '', '', 1450023741, 0, 0, 0, 0),
('NPC0011', '香蕉船與你交戰！你被對手的RX-78 GP02A擊敗。', '', '', '', '', 1451325096, 0, 0, 0, 0),
('NPC0012', '嗚啊與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451367337, 0, 0, 0, 0),
('NPC0013', 'KY_Poon與你交戰！你被對手的無限正義高達(流星號)擊敗。', '', '', '', '', 1451483333, 0, 0, 0, 0),
('NPC0014', 'LYS與你交戰！你被對手的勇者王擊敗。', '', '', '', '', 1449978772, 0, 0, 0, 0),
('NPC0017', 'C0RE與你交戰！你被對手的EVA Type F擊敗。', '', '', '', '', 1449732408, 0, 0, 0, 0),
('NPC0016', '路人D與你交戰！你被對手的Gundam 00擊敗。', '', '', '', '', 1450055826, 0, 0, 0, 0),
('NPC0018', 'NPC008與你交戰！你被對手的命運高達擊敗。', '', '', '', '', 1448778878, 0, 0, 0, 0),
('NPC0019', 'C0RE與你交戰！你被對手的EVA Type F擊敗。', '', '', '', '', 1449236460, 0, 0, 0, 0),
('NPC0020', '下面好好食與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451374169, 0, 0, 0, 0),
('NPC0025', '深水埗CO哥與你交戰！你被對手的零式高達擊敗。', '', '', '', '', 1449325904, 0, 0, 0, 0),
('NPC0022', 'BlueSaider與你交戰！你被對手的自由高達擊敗。', '', '', '', '', 1451421490, 0, 0, 0, 0),
('NPC0026', 'BoredAsFuck與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1449654525, 0, 0, 0, 0),
('NPC0023', '路人D與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451500448, 0, 0, 0, 0),
('NPC0024', 'TAT與你交戰！你被對手的突擊自由高達擊敗。', '', '', '', '', 1450468062, 0, 0, 0, 0),
('NPC0027', 'nicklyc與你交戰！你被對手的EVA 三號機擊敗。', '', '', '', '', 1449647458, 0, 0, 0, 0),
('NPC0028', 'nicklyc與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1450075518, 0, 0, 0, 0),
('NPC0029', 'BoredAsFuck與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1450079900, 0, 0, 0, 0),
('NPC0030', '下面好好食與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451373766, 0, 0, 0, 0),
('NPC0031', '卡沙丁與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1451272880, 0, 0, 0, 0),
('NPC0033', '國撚與你交戰！你被對手的突擊自由高達擊敗。', '', '', '', '', 1451455955, 0, 0, 0, 0),
('NPC0034', 'Curry與你交戰！你被對手的勇者王擊敗。', '', '', '', '', 1449566213, 0, 0, 0, 0),
('NPC0035', '美堂 蠻與你交戰！你被對手的勇者王擊敗。', '', '', '', '', 1449464318, 0, 0, 0, 0),
('NPC0036', '美堂 蠻與你交戰！你被對手的勇者王擊敗。', '', '', '', '', 1449563500, 0, 0, 0, 0),
('NPC0037', 'nicklyc與你交戰！你被對手的EVA 二號機擊敗。', '', '', '', '', 1449670761, 0, 0, 0, 0),
('NPC0038', 'ChocoMilk與你交戰！對手與你的戰鬥沒有分出勝負。', '', '', '', '', 1449236334, 0, 0, 0, 0),
('NPC0039', '美堂 蠻與你交戰！你被對手的EVA 零號機擊敗。', '', '', '', '', 1450015816, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_map`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_map` (
  `map_id` varchar(4) NOT NULL DEFAULT '',
  `occupied` int(10) NOT NULL DEFAULT '0',
  `aname` varchar(32) NOT NULL DEFAULT '',
  `development` smallint(5) NOT NULL DEFAULT '0',
  `hp` int(8) unsigned NOT NULL DEFAULT '0',
  `hpmax` int(8) unsigned NOT NULL DEFAULT '0',
  `at` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `de` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ta` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `wepa` varchar(32) NOT NULL DEFAULT '',
  `spec` mediumtext NOT NULL,
  `nonatk` tinyint(1) NOT NULL DEFAULT '0',
  `protect` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`map_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_user_map`
--

INSERT INTO `vsqa_phpeb_user_map` (`map_id`, `occupied`, `aname`, `development`, `hp`, `hpmax`, `at`, `de`, `ta`, `wepa`, `spec`, `nonatk`, `protect`) VALUES
('A1', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepA', '', 0, 0),
('A2', 0, '', 0, 5000000, 5000000, 70, 70, 127, 'FortWepA', '', 0, 0),
('A3', 0, '', 0, 5000000, 5000000, 70, 70, 127, 'FortWepA', '', 0, 0),
('B1', 0, '', 0, 5000000, 5000000, 70, 70, 127, 'FortWepA', '', 0, 0),
('B2', 0, '', 0, 5000000, 5000000, 70, 70, 127, 'FortWepA', '', 0, 0),
('B3', 0, '', 0, 1920000, 1920000, 70, 70, 127, 'FortWepA', '', 0, 0),
('C1', 0, '', 0, 1089803, 1500000, 70, 70, 127, 'FortWepA', '', 0, 0),
('C2', 0, '', 0, 4620000, 4620000, 70, 70, 127, 'FortWepA', '', 0, 0),
('C3', 0, '', 0, 1860000, 1860000, 70, 70, 127, 'FortWepA', '', 0, 0),
('D1', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D2', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D3', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D4', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D5', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D6', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D7', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D8', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D9', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D10', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D11', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D12', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('D13', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('E2', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0),
('E1', 0, '', 0, 1500000, 1500000, 70, 70, 127, 'FortWepD', '', 1, 0);

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_market`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_market` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `owner` varchar(16) NOT NULL DEFAULT '',
  `price` int(10) unsigned NOT NULL DEFAULT '0',
  `wepid` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(40) NOT NULL DEFAULT '',
  `atk` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `hit` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rd` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `enc` smallint(5) unsigned NOT NULL DEFAULT '0',
  `spec` text NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `noshow` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=596 ;

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_marketb`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_marketb` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `owner` varchar(16) NOT NULL DEFAULT '',
  `price` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(40) NOT NULL DEFAULT '',
  `state` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_organization`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_organization` (
  `id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL DEFAULT '',
  `color` varchar(7) NOT NULL DEFAULT '',
  `funds` bigint(10) unsigned NOT NULL DEFAULT '0',
  `license` tinyint(1) NOT NULL DEFAULT '0',
  `request_list` text NOT NULL,
  `groupa` varchar(32) NOT NULL DEFAULT '',
  `groupb` varchar(32) NOT NULL DEFAULT '',
  `groupc` varchar(32) NOT NULL DEFAULT '',
  `operation` varchar(32) NOT NULL DEFAULT '',
  `optmissioni` varchar(32) NOT NULL DEFAULT '',
  `opttime` int(10) unsigned NOT NULL DEFAULT '0',
  `optstart` int(10) unsigned NOT NULL DEFAULT '0',
  `optmissiona` varchar(32) NOT NULL DEFAULT '',
  `optmissionb` varchar(32) NOT NULL DEFAULT '',
  `optmissionc` varchar(32) NOT NULL DEFAULT '',
  `lastopt` varchar(20) NOT NULL DEFAULT '0',
  `cnum` smallint(2) NOT NULL DEFAULT '1',
  `pose` varchar(90) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_user_organization`
--

INSERT INTO `vsqa_phpeb_user_organization` (`id`, `name`, `color`, `funds`, `license`, `request_list`, `groupa`, `groupb`, `groupc`, `operation`, `optmissioni`, `opttime`, `optstart`, `optmissiona`, `optmissionb`, `optmissionc`, `lastopt`, `cnum`, `pose`) VALUES
(0, '中立組織', '#AAAAAA', 0, 3, '', '', '', '', '', '', 0, 0, '', '', '', '0', 97, '');

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_settings`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_settings` (
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `gen_img_dir` varchar(128) NOT NULL DEFAULT '',
  `unit_img_dir` varchar(128) NOT NULL DEFAULT '',
  `base_img_dir` varchar(128) NOT NULL DEFAULT '',
  `show_log_num` tinyint(1) NOT NULL DEFAULT '0',
  `atkonline_alert` tinyint(1) NOT NULL DEFAULT '1',
  `battle_def_filter` tinyint(1) NOT NULL DEFAULT '1',
  `fdis_at` tinyint(1) NOT NULL DEFAULT '0',
  `fdis_de` tinyint(1) NOT NULL DEFAULT '0',
  `fdis_re` tinyint(1) NOT NULL DEFAULT '0',
  `fdis_ta` tinyint(1) NOT NULL DEFAULT '0',
  `fdis_lv` tinyint(1) NOT NULL DEFAULT '0',
  `fdis_hp` tinyint(1) NOT NULL DEFAULT '0',
  `fdis_fame` tinyint(1) NOT NULL DEFAULT '0',
  `fdis_bty` tinyint(1) NOT NULL DEFAULT '0',
  `fdis_ms` tinyint(1) NOT NULL DEFAULT '0',
  `fdis_tch` tinyint(1) NOT NULL DEFAULT '0',
  `fdis_con` tinyint(1) NOT NULL DEFAULT '0',
  `filter_at_min` tinyint(3) NOT NULL DEFAULT '0',
  `filter_at_max` tinyint(3) NOT NULL DEFAULT '0',
  `filter_de_min` tinyint(3) NOT NULL DEFAULT '0',
  `filter_de_max` tinyint(3) NOT NULL DEFAULT '0',
  `filter_re_min` tinyint(3) NOT NULL DEFAULT '0',
  `filter_re_max` tinyint(3) NOT NULL DEFAULT '0',
  `filter_ta_min` tinyint(3) NOT NULL DEFAULT '0',
  `filter_ta_max` tinyint(3) NOT NULL DEFAULT '0',
  `filter_lv_min` smallint(4) NOT NULL DEFAULT '0',
  `filter_lv_max` smallint(4) NOT NULL DEFAULT '0',
  `filter_hp_min` int(7) NOT NULL DEFAULT '0',
  `filter_hp_max` int(7) NOT NULL DEFAULT '0',
  `filter_fame_min` smallint(4) NOT NULL DEFAULT '0',
  `filter_fame_max` smallint(4) NOT NULL DEFAULT '0',
  `filter_bty_min` int(10) NOT NULL DEFAULT '0',
  `filter_bty_max` int(10) NOT NULL DEFAULT '0',
  `filter_con` tinyint(1) NOT NULL DEFAULT '0',
  `filter_sort` tinyint(1) NOT NULL DEFAULT '0',
  `filter_sort_asc` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `vsqa_phpeb_user_settings`
--

INSERT INTO `vsqa_phpeb_user_settings` (`username`, `gen_img_dir`, `unit_img_dir`, `base_img_dir`, `show_log_num`, `atkonline_alert`, `battle_def_filter`, `fdis_at`, `fdis_de`, `fdis_re`, `fdis_ta`, `fdis_lv`, `fdis_hp`, `fdis_fame`, `fdis_bty`, `fdis_ms`, `fdis_tch`, `fdis_con`, `filter_at_min`, `filter_at_max`, `filter_de_min`, `filter_de_max`, `filter_re_min`, `filter_re_max`, `filter_ta_min`, `filter_ta_max`, `filter_lv_min`, `filter_lv_max`, `filter_hp_min`, `filter_hp_max`, `filter_fame_min`, `filter_fame_max`, `filter_bty_min`, `filter_bty_max`, `filter_con`, `filter_sort`, `filter_sort_asc`) VALUES
('NPC5648', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5649', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5650', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5657', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5658', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5659', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5660', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5661', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5662', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5663', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5664', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5665', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC5666', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC4444', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC4443', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC4442', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC4441', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC4440', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC4445', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC4446', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC4447', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC4448', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC4449', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC1116', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC1117', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC1118', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC1119', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC2000', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC2001', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC2002', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC2003', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC2004', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC2005', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC2006', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC2007', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC2008', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC2009', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0000', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0001', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0002', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0003', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0004', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0005', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0006', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0007', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0008', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0009', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0010', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0011', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0012', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0013', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0014', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0015', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0016', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0017', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0018', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0019', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0020', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0021', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0022', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0023', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0024', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0025', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0026', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0027', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0028', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0029', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0030', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0031', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0032', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0033', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0034', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0035', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0036', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0037', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0038', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('NPC0039', '', '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_tactfactory`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_tactfactory` (
  `username` varchar(16) NOT NULL DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  `directions` text NOT NULL,
  `m1` varchar(16) NOT NULL DEFAULT '',
  `m2` varchar(16) NOT NULL DEFAULT '',
  `m3` varchar(16) DEFAULT NULL,
  `m4` varchar(16) DEFAULT NULL,
  `m5` varchar(16) DEFAULT NULL,
  `m6` varchar(16) DEFAULT NULL,
  `m7` varchar(16) DEFAULT NULL,
  `m8` varchar(16) DEFAULT NULL,
  `m9` varchar(16) DEFAULT NULL,
  `m10` varchar(16) DEFAULT NULL,
  `m11` varchar(16) DEFAULT NULL,
  `m12` varchar(16) DEFAULT NULL,
  `m13` varchar(16) DEFAULT NULL,
  `m14` varchar(16) DEFAULT NULL,
  `m15` varchar(16) DEFAULT NULL,
  `m16` varchar(16) DEFAULT NULL,
  `m17` varchar(16) DEFAULT NULL,
  `m18` varchar(16) DEFAULT NULL,
  `m19` varchar(16) DEFAULT NULL,
  `m20` varchar(16) DEFAULT NULL,
  `c_wep` varchar(8) NOT NULL DEFAULT '',
  `c_point` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `vsqa_phpeb_user_warehouse`
--

CREATE TABLE IF NOT EXISTS `vsqa_phpeb_user_warehouse` (
  `username` varchar(16) NOT NULL DEFAULT '',
  `warehouse` text NOT NULL,
  `timelast` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
