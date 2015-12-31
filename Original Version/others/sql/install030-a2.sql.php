<?
//----------------------------------//
//--- Database Installation Unit ---//
//----------------------------------//
//--- v2Alliance Official Version---//
//-----------   v0.30   ------------//
//----------------------------------//
//----- Official Database ver6 -----//
//----------------------------------//
include_once('cfu.php');

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_chat` (
  `c_id` mediumint(8) unsigned NOT NULL auto_increment,
  `c_user` varchar(16) NOT NULL default '',
  `c_time` int(10) NOT NULL default '0',
  `c_msg` text NOT NULL,
  `c_type` tinyint(1) NOT NULL default '0',
  `c_tar` varchar(16) NOT NULL default '',
  PRIMARY KEY  (`c_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_game_history` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `time` int(10) unsigned NOT NULL default '0',
  `history` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_regkeys` (
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
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` (
  `id` varchar(4) NOT NULL default '',
  `name` varchar(12) NOT NULL default '',
  `typelv` tinyint(2) NOT NULL default '0',
  `atf` tinyint(2) NOT NULL default '0',
  `def` tinyint(2) NOT NULL default '0',
  `ref` tinyint(2) NOT NULL default '0',
  `taf` tinyint(2) NOT NULL default '0'
) TYPE=MyISAM;");

mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nat1', '一般', 1, 0, 0, 0, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nat2', '一般', 2, 1, 1, 1, 1);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nat3', '一般', 3, 2, 2, 2, 2);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nat4', '一般', 4, 3, 3, 3, 3);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nat5', '一般', 5, 3, 4, 3, 3);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nat6', '一般', 6, 4, 4, 3, 3);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nat7', '一般', 7, 4, 5, 3, 3);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nat8', '一般', 8, 4, 5, 3, 3);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nat9', '一般', 9, 4, 5, 3, 3);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('natx', '一般', 10, 4, 5, 3, 3);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('enh1', '強化人間Lv1', 1, 0, 0, 0, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('enh2', '強化人間Lv2', 2, 1, 0, 0, 1);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('enh3', '強化人間Lv3', 3, 1, 1, 1, 1);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('enh4', '強化人間Lv4', 4, 1, 2, 1, 2);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('enh5', '強化人間Lv5', 5, 2, 3, 1, 4);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('enh6', '強化人間Lv6', 6, 3, 3, 2, 6);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('enh7', '強化人間Lv7', 7, 4, 3, 3, 7);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('enh8', '強化人間Lv8', 8, 5, 4, 3, 8);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('enh9', '強化人間Lv9', 9, 5, 4, 5, 8);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('enhx', '強化人間LvX', 10, 6, 4, 5, 8);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('ext1', 'Extended Lv1', 1, 0, 0, 0, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('ext2', 'Extended Lv2', 2, 2, 0, 0, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('ext3', 'Extended Lv3', 3, 3, 0, 1, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('ext4', 'Extended Lv4', 4, 5, 0, 1, 1);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('ext5', 'Extended Lv5', 5, 7, 1, 2, 2);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('ext6', 'Extended Lv6', 6, 9, 1, 6, 3);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('ext7', 'Extended Lv7', 7, 10, 1, 7, 4);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('ext8', 'Extended Lv8', 8, 10, 1, 8, 6);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('ext9', 'Extended Lv9', 9, 10, 1, 8, 6);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('extx', 'Extended LvX', 10, 10, 1, 8, 6);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('psy1', '念動力 Lv1', 1, 0, 0, 0, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('psy2', '念動力 Lv2', 2, 0, 1, 1, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('psy3', '念動力 Lv3', 3, 1, 1, 1, 1);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('psy4', '念動力 Lv4', 4, 1, 2, 2, 1);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('psy5', '念動力 Lv5', 5, 2, 4, 2, 2);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('psy6', '念動力 Lv6', 6, 5, 8, 3, 2);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('psy7', '念動力 Lv7', 7, 7, 10, 3, 2);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('psy8', '念動力 Lv8', 8, 9, 11, 4, 3);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('psy9', '念動力 Lv9', 9, 10, 12, 4, 6);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('psyx', '念動力 LvX', 10, 10, 13, 4, 8);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nt1', 'New Type Lv1', 1, 0, 0, 0, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nt2', 'New Type Lv2', 2, 0, 0, 0, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nt3', 'New Type Lv3', 3, 0, 0, 0, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nt4', 'New Type Lv4', 4, 0, 0, 0, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nt5', 'New Type Lv5', 5, 1, 1, 1, 1);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nt6', 'New Type Lv6', 6, 2, 2, 2, 2);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nt7', 'New Type Lv7', 7, 3, 3, 3, 3);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nt8', 'New Type Lv8', 8, 7, 3, 7, 7);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nt9', 'New Type Lv9', 9, 10, 3, 11, 11);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('nt10', 'New Type LvX', 10, 12, 3, 13, 12);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('co1', 'CO Lv1', 1, 0, 0, 0, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('co2', 'CO Lv2', 2, 0, 0, 0, 0);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('co3', 'CO Lv3', 3, 0, 0, 0, 1);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('co4', 'CO Lv4', 4, 0, 0, 1, 1);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('co5', 'CO Lv5', 5, 1, 1, 2, 2);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('co6', 'CO Lv6', 6, 2, 2, 4, 4);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('co7', 'CO Lv7', 7, 4, 4, 6, 6);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('co8', 'CO Lv8', 8, 7, 7, 10, 8);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('co9', 'CO Lv9', 9, 10, 10, 13, 8);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` VALUES ('co10', 'CO LvX', 10, 13, 10, 14, 8);");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_sys_map` (
  `map_id` varchar(4) NOT NULL default '',
  `type` tinyint(1) NOT NULL default '0',
  `occprice` int(10) NOT NULL default '0',
  `hpmax` int(8) NOT NULL default '100000',
  `at` tinyint(3) NOT NULL default '10',
  `de` tinyint(3) NOT NULL default '10',
  `ta` tinyint(3) NOT NULL default '10',
  `wepa` varchar(32) NOT NULL default 'FortWepA',
  `movement` text NOT NULL,
  PRIMARY KEY  (`map_id`)
) TYPE=MyISAM;");

mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_map` VALUES ('A1', 0, 500000, 100000, 10, 10, 10, 'FortWepA', 'A2\r\nB1');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_map` VALUES ('A2', 0, 500000, 100000, 10, 10, 10, 'FortWepA', 'A1\r\nA3\r\nB2');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_map` VALUES ('A3', 0, 500000, 100000, 10, 10, 10, 'FortWepA', 'A2\r\nB3');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_map` VALUES ('B1', 3, 2500000, 200000, 25, 20, 20, 'FortWepB', 'A1\r\nB2\r\nC1');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_map` VALUES ('B2', 0, 10000000, 500000, 50, 50, 50, 'FortWepC', 'A2\r\nB1\r\nB3\r\nC2');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_map` VALUES ('B3', 3, 2500000, 200000, 25, 20, 20, 'FortWepB', 'A3\r\nB2\r\nC3');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_map` VALUES ('C1', 5, 7500000, 400000, 45, 40, 40, 'FortWepC', 'C2\r\nB1');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_map` VALUES ('C2', 3, 2500000, 200000, 25, 20, 20, 'FortWepB', 'C1\r\nC3\r\nB2');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_map` VALUES ('C3', 4, 7500000, 350000, 40, 30, 30, 'FortWepD', 'C2\r\nB3');");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_sys_ms` (
  `id` varchar(12) NOT NULL default '',
  `msname` varchar(24) NOT NULL default '',
  `price` int(10) NOT NULL default '0',
  `atf` tinyint(3) NOT NULL default '0',
  `def` tinyint(3) NOT NULL default '0',
  `ref` tinyint(3) NOT NULL default '0',
  `taf` tinyint(3) NOT NULL default '0',
  `hpfix` mediumint(6) NOT NULL default '0',
  `enfix` mediumint(6) NOT NULL default '0',
  `hprec` decimal(5,3) NOT NULL default '0.000',
  `enrec` decimal(5,3) NOT NULL default '0.000',
  `spec` varchar(20) NOT NULL default '',
  `needlv` tinyint(3) NOT NULL default '0',
  `image` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;");

mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('0', 'No Unit', 0, 0, 0, 0, 0, 0, 0, 0.000, 0.000, '', 0, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('1', 'G - Cannon', 575000, 6, 4, 4, 5, 2750, 125, 21.000, 1.785, '', 8, '1/gcannon.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('2', 'Gottrlatan', 7450000, 16, 12, 15, 17, 4200, 225, 36.500, 4.240, '', 65, '1/gotoratan.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('3', 'K&auml;mpfer', 1975000, 9, 5, 7, 9, 3750, 150, 29.500, 2.750, '', 20, '1/kenpufa.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('4', 'Gundam Alex', 1950000, 7, 8, 8, 8, 4000, 175, 31.500, 2.916, '', 16, '2/alex.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('5', 'EZ-8', 1600000, 8, 7, 6, 6, 3500, 160, 27.500, 2.807, '', 16, '2/ez8.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('6', 'Gundam', 1675000, 7, 7, 7, 7, 3800, 150, 30.000, 2.530, '', 16, '2/gundam.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('7', 'Apsalus III', 3150000, 13, 11, 1, 6, 5500, 250, 39.500, 0.023, '', 25, '2/apusarasu.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('8', 'Elmeth', 2250000, 10, 6, 8, 10, 5000, 200, 37.500, 3.270, '', 20, '2/erumesu.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('9', 'Aegis Gundam', 4650000, 13, 8, 15, 9, 5500, 275, 45.000, 4.365, 'SeedMode,', 35, '3/ageis.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('10', 'Strike Gundam', 4150000, 9, 7, 16, 14, 5000, 250, 40.000, 4.000, 'SeedMode,', 30, '3/ailestrike.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('13', 'Astray Gundam Blue Frame', 3625000, 10, 8, 13, 11, 5000, 225, 40.500, 3.600, 'SeedMode,', 25, '3/blueframe.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('14', 'Astray Gundam Red Frame', 3675000, 13, 8, 11, 10, 5000, 250, 40.500, 3.950, 'SeedMode,', 25, '3/redframe.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('11', 'Sword Strike', 4050000, 13, 6, 11, 13, 5500, 250, 44.000, 4.000, 'SeedMode,', 30, '3/swordstrike.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('12', 'Strike Rouge', 3900000, 8, 6, 14, 12, 5500, 250, 45.000, 4.000, 'SeedMode,', 30, '3/strikerouge.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('15', 'Crossbone X1', 5250000, 14, 10, 15, 15, 5500, 275, 42.000, 4.500, '', 45, '3/crossbonex1.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('16', 'Crossbone X2', 5475000, 15, 10, 14, 14, 5750, 275, 44.000, 4.600, '', 45, '3/crossbonex2.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('17', 'Gundam F91', 4575000, 15, 6, 20, 14, 4500, 250, 34.000, 4.237, '', 35, '3/f91.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('18', 'Z Gundam', 4925000, 14, 8, 17, 13, 4750, 250, 37.000, 4.545, '', 40, '3/z.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('19', '&#8704; Gundam', 5555000, 14, 12, 15, 12, 5500, 275, 0.008, 0.016, '', 50, '4/turna.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('20', 'Turn X', 5725000, 16, 13, 13, 13, 5500, 275, 0.008, 0.016, '', 50, '4/turnx.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('21', 'Gundam Epyon', 6375000, 16, 7, 16, 12, 5500, 275, 45.000, 5.000, '', 60, '4/epion.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('22', 'The - O', 5525000, 14, 18, 7, 15, 6000, 275, 45.000, 4.583, '', 50, '4/jio.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('23', 'Gundam ZZ', 5675000, 16, 12, 12, 13, 5500, 295, 45.000, 4.300, '', 50, '4/zz.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('24', 'Qubeley', 5250000, 16, 7, 16, 17, 5000, 275, 37.500, 4.750, '', 45, '4/kyuberei.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('25', 'Neue Ziel', 16000000, 21, 20, 18, 20, 6750, 400, 54.000, 7.000, '', 75, '5/noie.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('26', 'GP03D', 17000000, 23, 25, 15, 17, 7000, 425, 57.000, 7.000, '', 80, '5/GP03D.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('27', 'Gundam DX', 5800000, 19, 9, 11, 13, 5500, 325, 45.000, 5.000, '', 60, '5/dx.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('28', 'Vasago Gundam', 8100000, 17, 9, 17, 6, 5300, 300, 42.500, 5.400, '', 65, '5/vasago.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('29', 'V2-Assualt Buster Gundam', 8400000, 17, 12, 18, 15, 5500, 325, 45.000, 5.500, '', 70, '5/v2assult.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('30', 'Master Gundam', 7325000, 20, 5, 17, 25, 5000, 250, 39.500, 4.100, '', 65, '5/master.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('31', 'Freedom Gundam', 13000000, 18, 12, 20, 22, 6000, 350, 50.000, 0.018, 'SeedMode,', 75, '6/freedom.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('32', 'Justice Gundam', 11100000, 17, 13, 17, 18, 6000, 350, 50.000, 0.018, 'SeedMode,', 70, '6/justice.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('33', 'Wing Gundam Zero-Custom', 8600000, 18, 14, 20, 12, 6000, 325, 48.000, 5.250, '', 70, '6/wing0custom.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('34', 'G Gundam', 6600000, 24, 5, 14, 20, 5000, 250, 39.500, 4.100, '', 60, '6/god.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('35', 'Hi - ν Gundam', 15100000, 20, 12, 20, 30, 6250, 300, 52.500, 5.000, '', 75, '7/hiv.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('36', 'Nightingale', 15000000, 22, 10, 27, 23, 6000, 325, 52.500, 5.000, '', 75, '7/naitingeru.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('37', 'Freedom Gundam METEOR', 29500000, 25, 17, 25, 27, 7500, 500, 60.000, 0.020, 'SeedMode,', 85, '7/freedom_meteor.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('38', 'Providence Gundam', 19250000, 30, 10, 10, 30, 6500, 400, 56.000, 0.019, 'SeedMode,', 80, '7/providensu.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('39', 'Magella Attack', 200000, 2, 1, 0, 2, 1400, 75, 10.779, 1.062, '', 1, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('40', 'Type-61 Tank', 200000, 2, 1, 1, 1, 1450, 70, 11.100, 1.000, '', 1, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('41', 'Ball', 200000, 2, 0, 1, 2, 1400, 75, 10.725, 1.071, '', 1, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('42', 'Leo', 450000, 2, 2, 2, 4, 2500, 90, 20.000, 1.300, '', 5, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('43', 'GM', 500000, 2, 3, 3, 2, 2650, 100, 21.000, 1.500, '', 5, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('44', 'Zaku II-FZ', 550000, 5, 3, 3, 4, 2750, 120, 21.000, 1.800, '', 5, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('45', 'NT Test GM', 850000, 6, 5, 6, 9, 3000, 135, 23.300, 1.820, '', 12, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('46', 'Gelgoog JG', 1500000, 8, 4, 5, 12, 3700, 160, 28.500, 2.600, '', 12, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('47', 'Gouf', 1750000, 9, 4, 7, 8, 3750, 175, 30.000, 2.916, '', 16, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('48', 'D Gundam First', 2050000, 12, 5, 10, 7, 3800, 170, 30.000, 2.800, '', 20, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('49', 'Efeet Custom', 2475000, 12, 6, 12, 10, 3750, 200, 30.000, 3.100, 'EXAMSystem,', 20, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('50', 'Blue Destiny-03', 4800000, 13, 10, 15, 13, 4500, 225, 37.189, 3.688, 'EXAMSystem', 40, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('51', 'S Gundam', 4000000, 12, 8, 11, 14, 4250, 250, 36.000, 3.975, '', 30, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('52', 'Zeku Zwei', 4350000, 10, 10, 13, 14, 5000, 250, 41.000, 3.900, '', 35, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('53', 'Gerbera Tetra', 4400000, 12, 11, 14, 14, 4250, 180, 36.600, 2.800, '', 35, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('54', 'Hyaku-Shiki', 4675000, 12, 8, 13, 14, 4750, 225, 40.598, 3.750, '', 40, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('55', 'Neo Gundam', 5000000, 16, 10, 14, 13, 5000, 275, 39.000, 4.500, '', 40, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('56', 'Doven Wolf', 5075000, 14, 10, 12, 13, 6000, 250, 47.500, 4.000, '', 40, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('57', 'Tallgeese III', 6750000, 17, 13, 17, 17, 4750, 275, 37.500, 4.500, '', 65, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('58', 'Big Zam', 8450000, 17, 20, 7, 11, 7000, 300, 59.000, 4.858, '', 70, 'other/bigzam.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('59', 'Devil Gundam', 32666666, 30, 22, 10, 25, 8000, 450, 0.009, 0.020, '', 85, 'other/devil.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('61', 'GM Cannon II', 1050000, 7, 8, 6, 7, 3300, 155, 26.720, 2.460, '', 12, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('60', 'Masarai', 560000, 4, 4, 4, 4, 3000, 100, 24.000, 1.538, '', 8, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('62', 'GunTank', 625000, 6, 6, 2, 4, 3500, 150, 26.900, 2.459, '', 8, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('63', 'Asshimar', 685000, 8, 4, 7, 4, 3100, 125, 25.000, 2.016, '', 12, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('64', 'FA Alex', 2150000, 6, 10, 7, 8, 4500, 175, 35.156, 2.822, '', 20, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('65', 'Gundam Mk-II', 2750000, 12, 7, 10, 13, 4200, 235, 33.600, 3.507, '', 25, 'none.gif');");


mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` (
  `tact_id` varchar(12) NOT NULL default '0',
  `wep_id` varchar(16) NOT NULL default '0',
  `grade` tinyint(2) NOT NULL default '1',
  `directions` text NOT NULL,
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
  PRIMARY KEY  (`tact_id`)
) TYPE=MyISAM;");

mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('0', '901', 10, 'G-bit衛星微波能量炮<br>走了一天路，肚子餓極了，你一聽到公會有免費晚懂N直衝，可是被地上的書絆倒了......<br>原來是一本殘舊的日記，內容支離破碎：<br>想不到十數支巨炮產的力量有這麼大！居然轟毀了一要塞，我無論如何，不擇手段都要獲得G-bit衛星微波能量炮的資料......<br>那傢伙可真愚蠢，現在G-bit衛星微波能量炮的資料已到手，他已經沒有任何利用價值了......鑄造方法果然比我想的更複雜：<br>「一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;衛星微波能量炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;雙衛星微波能量炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buster&nbsp;Beam&nbsp;Rifle<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;長距離光束加農炮<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型光束加農炮<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型米加粒子炮<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>十號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>十一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>十二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>不過，應該可以鑄造成左?.....」日記到此完畢<br>', '974', '993', '962', '616', '619', '608', '718', '718', '718', '715', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('1', '902', 10, '天上天下念動爆碎劍<br>你擁有念動力嗎？如果沒有，你是不能使用以下武器的！<br>天上天下念動爆碎劍，是天上天下無敵劍的後續武器，實力更在其之上，它同樣是一把需要駕駛員極度集中及精神的念動力製造的一把劍<br>而且有念動爆碎的力量，威力驚人<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;天上天下無敵劍<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;天上天下念動破碎劍<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;天上天下念動破碎劍<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T-Link&nbsp;Sensor<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T-Link&nbsp;Sensor<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超大型光束劍<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超大型光束劍<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>十號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>十一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>', '983', '314', '314', '932', '932', '309', '309', '718', '718', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('2', '903', 10, '縮退炮<br>在你面前的是一把無與倫比的武器<br>它擁有超高的攻擊力和射程，運作原理和黑洞炮相似，可以將對手封入閉鎖空間，之後引起目標自身的重力坍塌，進而破壞其自身結構<br>它就是──縮退砲。你是想得到它吧？呵呵，拿著！這就是製造縮退炮的材料列表：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;衛星微波能量炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;引力子步槍BST<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;引力子步槍BST<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高性能照準系統<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;衝角炮<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;米加音波炮<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束炮<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束炮<br>九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>十號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>十一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>十二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>', '974', '952', '952', '965', '610', '618', '613', '613', '718', '718', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('3', '904', 10, '光之翼<br>你聽聞一位公會成員在說故事，於是你走過去：<br>「就是上星期發生的事！你知道我看到了甚麼？是一隻會發光的小鳥」<br>看眾人都驚訝不已，他又說下去，<br>「其實啊，它並不是甚麼發光大烏，它是一部正在使用光之翼的MS，而飛行的方向正是三部渣古！<br>就在這雷霆萬鈞的一刻，三部渣古被切成了六件，繼而爆炸！」<br>那公會成員的眼?彷彿看得出有光，然後嘆了一口氣，閉上發光的雙眼，認真的說：<br>「所以，今天小弟希望與大家分享光之翼的鑄造方法，只需現金......」<br>可惜，他再打開雙眼的時候，人們都散了，你卻反應緩慢的預備離開<br>那公會成員以發光的雙眼望著你抓住雙手，道：<br>「兄弟，你走運了！你有購買光之翼鑄造方法的機會了！」<br>你又不好意思推掉他一番好意，只好拿出錢，購買光之翼的鑄造方法<br>他還你一個感激的眼神，遞送上一張紙，寫著光之翼的鑄造方法：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;背部光束切裂器<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超大型光束劍<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超大型光束劍<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HiMAT&nbsp;System<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>', '310', '309', '309', '998', '718', '718', '718', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('4', '905', 10, '黑洞炮<br>我醉心於研究最強的攻擊武器，發現黑洞炮堪稱最強<br>黑洞炮的基本原理是發射出一個極強的能量團，命中目標之後開始重力坍塌並產生一個黑洞將目標吸入其中，<br>被吸進黑洞的只有一個後果，就是死亡。<br>製造黑洞不是一件簡單的工作，一不小心可能會被黑洞吸入，誤傷自己。這是我經過長期研究後，黑洞炮可能的製作方法︰<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;米加音波炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型光束加農炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型米加粒子炮<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;280mm軌道加農炮<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超重力軌道槍<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>', '618', '619', '608', '410', '409', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('5', '906', 10, 'Solar&nbsp;panel<br>在公會的僻靜角落，一個口叼香煙的男人，倚牆而立，應該是公會成員之一，於是你走了過去，拿出一箱鈔票，<br>並以密碼溝通：「Bbm&nbsp;zpt&nbsp;udmk&nbsp;nd&nbsp;tnndugjmh&nbsp;zcnvs&nbsp;ugbs?」<br>公會成員先是嚇了一跳，然後施施拿下煙蒂：「nl，據可靠情報，某神秘組織的工程師聯同科學家，<br>合力研製了一種會自動回復EN的物料－Solar&nbsp;panel<br>經過我們的仔細的調查，已獲得有關資料：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>十號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>十一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>十二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>十三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;-&nbsp;cap」<br>', '711', '712', '715', '718', '718', '715', '712', '711', '711', '712', '715', '718', '999', NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('6', '907', 10, 'NANO&nbsp;Skin<br>在公會的僻靜角落，一個口叼香煙的男人，倚牆而立，應該是公會成員之一，於是你走了過去，拿出一箱鈔票，<br>並以密碼溝通：「Bbm&nbsp;zpt&nbsp;udmk&nbsp;nd&nbsp;tnndugjmh&nbsp;zcnvs&nbsp;ugbs?」<br>公會成員先是嚇了一跳，然後施施拿下煙蒂：「nl，據可靠情報，某神秘組織的工程師聯同科學家，<br>合力研製了一種會自動回復HP的物料－NANO&nbsp;Skin<br>經過我們的仔細的調查，已獲得有關資料：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>十號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>十一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>十二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶&nbsp;&nbsp;&nbsp;&nbsp;<br>十三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超硬鋼裝甲<br>十四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超合金Z裝甲」<br>', '711', '712', '715', '718', '718', '715', '712', '711', '711', '712', '715', '718', '957', '989', NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('7', '908', 10, 'Z．O．Armor<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Z．O．Armor，它是一種合金裝甲，並較超合金Z裝甲有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超合金Z裝甲<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超合金Z裝甲<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高達尼姆合金裝甲<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高達尼姆合金裝甲<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月鈦合金裝甲<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月鈦合金裝甲<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月鈦合金裝甲」<br>', '989', '989', '956', '956', '831', '831', '831', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('8', '909', 10, '超合金newZ裝甲<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－超合金newZ裝甲，它是一種合金裝甲，並較超合金Z裝甲有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超合金Z裝甲<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超合金Z裝甲<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超硬鋼裝甲<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超硬鋼裝甲<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月鈦合金裝甲<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月鈦合金裝甲&nbsp;&nbsp;&nbsp;&nbsp;<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月鈦合金裝甲」<br>「多謝惠顧！」<br>', '989', '989', '957', '957', '831', '831', '831', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('9', '991', 9, 'V.S.B.R.<br>你在公會看到了一個售賣高級武器鑄造方法的人，於是你走過跟他交流一下心得<br>「你知道有關V.S.B.R.的事嗎？」<br>「當然知道，V.S.B.R.即Variable&nbsp;Speed&nbsp;Beam&nbsp;Rifle，即無段速光束步槍......」<br>「那麼是怎樣鑄造的？」<br>他伸出手，像是要什麼的模樣，聰明的你當然知道，雖然是交流心得，沒有錢是不行的<br>你拿出一疊鈔票，他當然告訴你鑄造方法：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mega．Beam&nbsp;Rifle<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;長距離光束加農炮<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束炮<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>', '405', '405', '411', '616', '613', '718', '718', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('10', '992', 9, 'Twin&nbsp;Buster&nbsp;Rifle<br>我以前曾在一間機動戰士工廠做過工程人員，記得我好像參與過製造一把擁有兩支槍管而破壞力巨大的步槍，<br>我記得製造這把槍需要把材料這樣放：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buster&nbsp;Beam&nbsp;Rifle<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buster&nbsp;Rifle<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buster&nbsp;Rifle<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2連裝軌道槍<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型光束加農炮<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型光束加農炮<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金', '962', '412', '412', '407', '619', '619', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('11', '993', 9, '雙衛星微波能量炮<br>走了一天路，肚子餓極了，你一聽到公會有免費晚懂N直衝，可是被地上的書絆倒了......<br>原來是一本殘舊的日記，內容支離破碎：<br>「雙衛星微波能量炮與G-bit衛星微波能量炮的資源已到手：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;衛星微波能量炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;衛星微波能量炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;長距離光束加農炮<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束加農炮<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束炮<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;單裝炮<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>十號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>至於G-bit衛星微波能量炮則較為複雜......」<br>日記下一頁的內容似乎是故意被撕去的，日記到此完畢<br>', '974', '974', '616', '614', '613', '609', '718', '715', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('12', '994', 9, '反應彈<br>你在公會看到了一個據稱是飛彈怪人的成員，於是你便向他追問有關反應彈的問題：<br>「與紅外線追蹤飛彈相反，反應彈是一種追求攻擊界限的飛彈，所以無法應用紅外線追蹤技術，<br>而由於它的攻擊力高，所以它十分珍貴，彈數亦較少<br>既然你提出高價，我是不會讓你失望而回的：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;核子火箭炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;核子火箭炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NEO火箭炮<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NEO火箭炮<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能飛彈發射器<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能飛彈發射器<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金」<br>', '522', '522', '517', '517', '502', '502', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('13', '995', 9, '斬艦刀．一文字斬<br>你從公會成員聽說，斬艦刀藏有十分強大的力量，且可以使出奧義－斬艦刀．一文字斬<br>但要發揮斬艦刀的潛能，光靠駕駛員的力量及技術是不足的，斬艦刀必須先經過強化，才有發揮力量及抵禦龐大出力的可能<br>而強化武器，必須以適當的材料再次鑄造(?)：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;斬艦刀<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青龍刀<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超合金Z裝甲<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>', '129', '127', '989', '718', '715', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('14', '996', 9, '浮游炮<br>晚上的夜空總是會看到星星的,&nbsp;今天亦一樣,&nbsp;而且還看到了「格外特別的星」<br>你不禁嘆息:「又一部機犧牲在Bit的手上......」<br>一個熟悉的影子在月光下投在你的臉上,心想:&nbsp;怎麼又是他呢?<br>「那是(?),&nbsp;而非Bit,&nbsp;它們的外貌是不同的.而力量更在前者之上」<br>又一張字條飛到臉上：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bit<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Newtype系統對應有線式光束炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高性能照準系統<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束炮<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>他沒留下一句話,&nbsp;只是......<br>', '971', '620', '405', '405', '965', '613', '712', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('15', '997', 9, '飛翔炮<br>晚上的夜空總是會看到星星的,&nbsp;今天亦一樣,&nbsp;而且還看到了「格外特別的星」<br>你不禁嘆息:「又一部機犧牲在Bit的手上......」<br>一個熟悉的影子在月光下投在你的臉上,心想:&nbsp;怎麼又是他呢?<br>「那是(?),&nbsp;而非Bit,&nbsp;它們的外貌是不同的.而力量更在前者之上」<br>又一張字條飛到臉上：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bit<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Newtype系統對應有線式光束炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高性能照準系統<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束炮<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>他沒留下一句話,&nbsp;只是......<br>', '971', '620', '405', '405', '965', '613', '715', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('16', '998', 9, 'HiMAT&nbsp;System<br>支付巨款後，公會人員帶你到一名工程師那裡：<br>「你想知道那樣可令70噸重、18米高的機動戰士、達到&nbsp;Mach&nbsp;4&nbsp;的速度之裝置嗎？」<br>他對你說：「不用變型、也不用安裝大型的噴射器，卻能在大氣圈內達到如此驚人的速度，<br>正正就那把『劍』所用的一個系統&nbsp;－&nbsp;High&nbsp;Mobility&nbsp;Aerial&nbsp;Tactics&nbsp;System&nbsp;!」<br>之後，他便遞了一份文件給你，內裡記述著&nbsp;HiMAT&nbsp;System&nbsp;的製作方法：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高性能雷達<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hyper&nbsp;Thruster<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hyper&nbsp;Thruster<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;極速噴射加速系統<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;極速噴射加速系統<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>十號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>', '977', '976', '976', '911', '911', '715', '715', '718', '718', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('17', '999', 9, 'E&nbsp;-&nbsp;cap<br>在公會的僻靜角落，一個口叼香煙的男人，倚牆而立，應該是公會成員之一，於是你走了過去，拿出一箱鈔票，<br>並以密碼溝通：「Bbm&nbsp;zpt&nbsp;udmk&nbsp;nd&nbsp;tnndugjmh&nbsp;zcnvs&nbsp;ugbs?」<br>公會成員先是嚇了一跳，然後施施拿下煙蒂：「nl，據可靠情報，某神秘組織的工程師聯同科學家，<br>合力研製了一種會自動回復EN的物料－E&nbsp;-&nbsp;cap<br>經過我們的仔細的調查，已獲得有關資料：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>十號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金」<br>', '711', '712', '715', '718', '718', '715', '712', '711', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('18', '981', 8, '你從公會成員聽說，皇牌駕駛員是可以發揮天空劍的內在潛能的，並使其能力上升了超過50%，而名字好像叫\"天空劍．V字斬\".<br>但要發揮天空劍的潛能，光靠駕駛員的力量是不行的，武器必須先經過強化，才有發揮力量的可能<br>要強化武器，必須以適當的材料再次鑄造天空劍：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;天空劍<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;電磁劍<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;電磁加農炮<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型電磁斧<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型電磁斧<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>', '963', '106', '943', '116', '116', '718', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('19', '982', 8, '超電磁龍卷<br>你在公會看到了一個售賣高級武器鑄造方法的人，於是你走過跟他交流一下心得<br>「你知道有關超電磁龍卷的事嗎？」<br>「當然知道，超電磁龍卷是一種利用電磁力產生龍卷作攻擊的武器......」<br>「那麼是怎樣鑄造的？」<br>他伸出手，像是要什麼的模樣，聰明的你當然知道，雖然是交流心得，沒有錢是不行的<br>你拿出一疊鈔票，他當然告訴你鑄造方法：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;電磁加農炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;電磁炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;雙回轉式電磁斧<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>', '943', '933', '118', '718', '715', '715', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('20', '983', 8, '天上天下無敵劍<br>你擁有念動力嗎？如果沒有，你是不能使用以下武器的！<br>天上天下無敵劍，故名思義，它是無敵的，是一把需要駕駛員極度集中的武器，並且以念動力製造一把劍，威力驚人<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;天上天下念動破碎劍<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;天上天下念動破碎劍<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T-Link&nbsp;Sensor<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T-Link&nbsp;Sensor<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>', '314', '314', '932', '932', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('21', '984', 8, '雙格林機關炮<br>格林機關炮是一種力量不低的武器<br>試想想，若果格林機關炮一擊便把一部ｍｓ擊至重傷，那麼兩把格林機關炮不就一擊摧毀一部ｍｓ？<br>而且持著格林機關炮攻擊有一種興奮感覺，使駕駛員更能發揮其長<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;格林機關炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;格林機關炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;雙光束旋轉機炮<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;對裝甲散彈炮<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>', '968', '968', '430', '422', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('22', '985', 8, '零式斬艦刀<br>你在公會的佈告欄上找到了零式斬艦刀這名字，然而，你卻只知道斬艦刀，於是你找了個公會成員問問：<br>「這是斬艦刀強化後的武器，原來是專用武器，但後來機密被盜取，現在則被廣泛使用<br>零式斬艦刀勝在攻擊力高，其劍氣一下子擊破ｍｓ，鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;斬艦刀<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;斬艦刀<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高出力周波刀<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超合金Z裝甲<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金」<br>', '129', '129', '108', '989', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('23', '987', 8, '三次元雷達<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－三次元雷達，它是一種輔助瞄準裝置，並較高性能雷達有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高性能雷達<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵」<br>「多謝惠顧！」<br>', '977', '718', '718', '715', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('24', '988', 8, 'G．Territory<br>你偶然目睹了一場戰鬥:<br>A狠狠的以光束劍砍在B身上,&nbsp;忽然,&nbsp;一層不明顯的防護層出現了,&nbsp;把A的攻擊擋下了,&nbsp;然後b便一擊大破A.<br>機師得意洋洋的下了機,你乘機問問(?)的鑄造方法,&nbsp;他得意忘形的說了兩個I-Field&nbsp;Barrier,鋼鐵,黃金,水晶,黃金,鋼鐵,水晶<br>接著便走了。但是,&nbsp;你不知道放在熔爐的次序呢!不過,&nbsp;可以肯定的是,&nbsp;原料是不會放在前面的。<br>', '966', '718', '718', '718', '715', '715', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('25', '989', 8, '超合金Z裝甲<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－超合金Z裝甲，它是一種合金裝甲，並較高達尼姆合金裝甲有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高達尼姆合金裝甲<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高達尼姆合金裝甲<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超硬鋼裝甲<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超硬鋼裝甲<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金」<br>「多謝惠顧！」<br>', '956', '956', '957', '957', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('26', '971', 7, 'Bit<br>晚上,&nbsp;你悠閒的臥視滿天星宿的天際,&nbsp;卻發現數顆格外特別的星。<br>「那是Bit呢!那可是一種強勁的精神控制型武器。」說著,他留下一張字條:<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Newtype系統對應有線式光束炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束炮<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Psyco-Frame<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>和一句話:「有緣會相遇的......」<br>', '620', '613', '613', '405', '975', '718', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('27', '972', 7, 'Divider<br>你正想走進公會打聽有關不同武器的鑄造方法，卻被一個哭鬧的人撞倒，你正想站起來討回公道<br>那人已在問有關衛星微波能量炮的事：<br>「我的衛星微波能量炮在戰鬥中破裂了，你可以替修理一下嗎？」<br>「怎麼樣？」那人看來十分焦急<br>「唔......情況不太樂觀，應該不能用了，不過你可以以Divider代替衛星微波能量炮，能力不差多少」<br>「那麼是怎樣鑄造的？」<br>「除原本已毀的武器，只需再順序加上全出力擴散米加粒子炮，長距離光束加農炮，長距離光束加農炮，水晶，水晶，黃金便可鑄造Divider了」<br>「謝謝！」<br>', '974', '607', '616', '616', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('28', '973', 7, '計都羅侯劍*暗劍殺<br>你從公會成員聽說，皇牌駕駛員是可以發揮(?)的內在潛能的，並使其能力上升了超過50%，而名字好像叫\"(?)\".<br>但要發揮(?)的潛能，光靠駕駛員的力量是不行的，武器必須先經過強化，才有發揮力量的可能<br>要強化武器，必須以適當的材料再次鑄造計都羅侯劍：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;計都羅侯劍<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;計都瞬獄劍<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;計都瞬獄劍<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;神速．四象無形劍<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;音速噴射系統<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>', '955', '324', '324', '321', '931', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('29', '974', 7, '衛星微波能量炮<br>走了一天路，肚子餓極了，你一聽到公會有免費晚懂N直衝，可是被地上的書絆倒了......<br>原來是一本殘舊的日記，內容支離破碎：<br>「夜，又來了<br>我，仍忘不了那深刻的一夜......<br>那是一個雲霧彌漫晚上，我閒逛著，可是天色突變，雲層漸散，一道光從月亮射到大地，緊接著的是一陣震天巨響，<br>我沿著巨響與光的方向走，只見那裡一片荒蕪，寸草不生，似是被一富毀滅性的武器掠過......」<br>「經過數年的明查暗訪，終於找到了一點頭緒，原來那是G-bit衛星微波能量炮,可是我只有衛星微波能量炮鑄造方法：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型光束加農炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;米加音波炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;長距離光束加農炮<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;單裝炮<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金」<br>「......千辛萬苦找到的G-bit衛星微波能量炮與雙衛星微波能量炮資料被盜取了，應該是公會成員的所為，我已熬不到看見明天的晨曦了......」<br>日記到此完畢<br>', '619', '618', '616', '609', '718', '715', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('30', '975', 7, 'Pscyo-Frame<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Pscyo-Frame，它是一種瞄準系統，並較Dual&nbsp;Sensor有效率，怎麼樣？」<br>你點頭示意，把錢交給他：<br>「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T-Link&nbsp;Sensor<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T-Link&nbsp;Sensor<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金」<br>「多謝惠顧！」<br>', '932', '932', '718', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('31', '976', 7, 'Hyper&nbsp;Thruster<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Hyper&nbsp;Thruster，它是一種輔助加速裝置，並較Thruster有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thruster<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thruster<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶&nbsp;&nbsp;&nbsp;&nbsp;」<br>「多謝惠顧！」<br>', '941', '941', '718', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('32', '977', 7, '高性能雷達<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－高性能雷達，它是一種輔助瞄準裝置，並較高性能照準系統有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高性能照準系統<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金」<br>「多謝惠顧！」<br>', '965', '718', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('33', '978', 7, '念動力Field<br>你擁有念動力嗎？如果沒有，你是不能使用以下武器的！<br>一般Field如I-Field，只要有足夠能源便能夠啟動防禦的，但念動力Field則還需要駕駛員的精神力<br>只有念動力人種才可以開動，不過要另外鑄造念動力Field，才可以啟動：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T-Link&nbsp;Sensor<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T-Link&nbsp;Sensor<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;field<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵&nbsp;&nbsp;&nbsp;&nbsp;<br>', '932', '932', '967', '718', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('34', '979', 7, 'Fin&nbsp;Funnel&nbsp;Barrier<br>「Fin&nbsp;Funnel&nbsp;Barrier？與Fin&nbsp;Funnel有關的嗎」你好奇的問<br>「你真聰明！Fin&nbsp;Funnel&nbsp;Barrier就是Fin&nbsp;Funnel產生的I-Field」他開始有點不耐煩，仍強顏歡笑<br>「那麼與I-Field&nbsp;Barrier有何區別？」你繼續的問<br>「Fin&nbsp;Funnel&nbsp;Barrier當然較厲害！其防禦力更在E&nbsp;field之上」<br>「那麼E&nbsp;field又是甚麼？」你越問越興奮<br>「你到底買還是不買？」<br>你看見他一瞼想宰了你的樣子，你只好乖乖付錢，慢慢離開......<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;field<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Beam&nbsp;Coating<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金&nbsp;&nbsp;&nbsp;&nbsp;<br>「多謝?」回頭一看，他又回復原來的樣子了<br>', '967', '922', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('35', '961', 6, '擴散粒子彈<br>你正想走進公會打聽有關不同武器的鑄造方法，卻被一個哭鬧的人撞倒，你正想站起來討回公道<br>那人已在問有關衛星微波能量炮的事：<br>「我的全出力擴散米加粒子炮在戰鬥中破裂了，你可以替修理一下嗎？」<br>「怎麼樣？」那人看來十分焦急<br>「唔......情況不太樂觀，應該不能用了，不過你可以以擴散粒子彈代替全出力擴散米加粒子炮，能力不差多少」<br>「那麼是怎樣鑄造的？」<br>「除原本已毀的武器，只需順序加上擴散米加粒子炮，米加音波炮，水晶，黃金，鋼鐵便可鑄造擴散粒子彈了」<br>「謝謝！」<br>', '607', '605', '618', '718', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('36', '962', 6, 'Buster&nbsp;Beam&nbsp;Rifle<br>我是個機械維修員，我以前曾替&nbsp;Wing&nbsp;Gundam&nbsp;Zero&nbsp;維修，記得那機體有帶著一支巨型的步槍<br>看過它的結構後，我與另外多名工程師，分析出這把步槍需要以下材料製造：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buster&nbsp;Rifle<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buster&nbsp;Rifle<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mega．Beam&nbsp;Rifle<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶&nbsp;&nbsp;&nbsp;&nbsp;<br>', '412', '412', '411', '405', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('37', '963', 6, '天空劍<br>傳說，有一把劍名為\"天空劍\"，其力量無比可砍山劈石.<br>某日，你在地上發現了一閃閃發光的物體，滿以為是水晶.&nbsp;<br>可是，走近一看，原來是一面鏡，下面是一本書，不......是兩本才對.滿心好奇的你，決定打開看看.<br>深紅雷刃書-天空劍的鑄造方法<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高出力光束配刀<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;妖刀村正<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高周波刀<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青龍刀<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵&nbsp;&nbsp;&nbsp;&nbsp;<br><br>碧青凶刃書-天空劍的鑄造方法<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型電磁斧<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;妖刀村正<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高周波刀<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;電磁劍<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>原來是天空劍的鑄造方法，但是，那一個才對呢？<br>「深紅雷刃書......碧青凶刃書......?」接著,&nbsp;你明白了.<br>', '116', '109', '107', '106', '718', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('38', '964', 6, '光速移動系統<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：「我推薦你這個－光速移動系統，它是一種加速系統，並較音速噴射系統有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;音速噴射系統<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵」<br>「多謝惠顧！」<br>', '931', '718', '715', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('39', '965', 6, '高性能照準系統<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－高性能照準系統，它是一種輔助瞄準裝置，並較照準系統有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;照準系統<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;照準系統<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金」<br>「多謝惠顧！」<br>', '942', '942', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('40', '966', 6, 'I-Field&nbsp;Barrier<br>你偶然目睹了一場戰鬥:<br>A狠狠的以光束劍砍在B身上,&nbsp;忽然,&nbsp;一層不明顯的防護層出現了,&nbsp;把A的攻擊擋下了,&nbsp;然後b便一擊大破A.<br>機師得意洋洋的下了機,你乘機問問(?)的鑄造方法,&nbsp;他得意忘形的說了AB&nbsp;Field，水晶，水晶，黃金，<br>接著便走了。但是,&nbsp;你不知道放在熔爐的次序呢!不過,&nbsp;可以肯定的是,&nbsp;原料是不會放在前面的。<br>', '944', '718', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('41', '967', 6, 'E&nbsp;field<br>你偶然目睹了一場戰鬥:<br>A狠狠的以光束劍砍在B身上,&nbsp;忽然,&nbsp;一層不明顯的防護層出現了,&nbsp;把A的攻擊擋下了,&nbsp;然後b便一擊大破A.<br>機師得意洋洋的下了機,你乘機問問(?)的鑄造方法,&nbsp;他得意忘形的說了AB&nbsp;Field，水晶，黃金，鋼鐵，鋼鐵，青銅，<br>接著便走了。但是,&nbsp;你不知道放在熔爐的次序呢!不過,&nbsp;可以肯定的是,&nbsp;原料是不會放在前面的。<br>', '944', '718', '715', '712', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('42', '968', 6, '格林機關炮<br>格林機關炮是一種重彈藥的武器，千萬別低估了它的力量！雖然一顆子彈的攻擊力低，但十顆子彈的破壞力是不堪設想的<br>而且持著格林機關炮攻擊有一種興奮感覺，使駕駛員更能發揮其長<br>鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束旋轉機炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;霰彈炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;重突擊機統<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>', '429', '419', '418', '718', '715', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('43', '986', 8, 'Transitive&nbsp;FEAR<br>我在某國家當研究人員時，得知有一種名為&nbsp;FEAR&nbsp;的系統，就是那個&nbsp;Far-range&nbsp;Exploration&nbsp;and&nbsp;Alteration&nbsp;Re-locator。這個系統能計算出一個超擴的範圍內一切的障礙物，然後，更能夠以&nbsp;FEAR&nbsp;系統中的推進器優化器，把機體推進至所能達到的極速，並且能躲過所有障礙物&nbsp;－&nbsp;包括敵軍機體與光束！<br>以下就是&nbsp;Transitive&nbsp;FEAR&nbsp;的製作方法。<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光速移動系統<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;極速噴射加速系統<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;極速噴射加速系統<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;噴射加速系統<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金', '964', '911', '911', '801', '718', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('44', '951', 5, '菊一文字<br>你在公會看到了一個售賣高級武器鑄造方法的人，於是你走過跟他交流一下心得<br>「你知道有關菊一文字的事嗎？」<br>「當然知道，菊一文字如妖刀川正，是傳說中的一把古刀......」<br>「那麼是怎樣鑄造的？」<br>他伸出手，像是要什麼的模樣，聰明的你當然知道，雖然是交流心得，沒有錢是不行的<br>你拿出一疊鈔票，他當然告訴你鑄造方法：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;妖刀村正<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高出力周波刀<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;對裝甲刀<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青龍刀<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>', '109', '108', '128', '127', '715', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('45', '952', 5, '引力子步槍BST<br>你在公會看到了一個售賣高級武器鑄造方法的人，於是你走過跟他交流一下心得<br>「你知道有關引力子步槍BST的事嗎？」<br>「當然知道，引力子步槍BST是利用引力子，把能力壓縮，作出攻擊......」<br>「那麼是怎樣鑄造的？」<br>他伸出手，像是要什麼的模樣，聰明的你當然知道，雖然是交流心得，沒有錢是不行的<br>你拿出一疊鈔票，他當然告訴你鑄造方法：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;280mm軌道加農炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;破壞軌道槍<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mega．Beam&nbsp;Rifle<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>', '410', '408', '411', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('46', '953', 5, '紅外線追蹤飛彈<br>你在公會看到了一個據稱是飛彈怪人的成員，於是你便向他追問有關紅外線追蹤飛彈的問題<br>「飛彈是一種命中力低，攻擊力一般，卻有大量彈藥的武器<br>為彌補命中力低的缺點，我個人研製了一種以紅外線追蹤的強力飛彈<br>鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高性能照準系統<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;全方位火箭發射器<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;散彈火箭炮<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵」<br>', '965', '512', '519', '718', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('47', '954', 5, '激光盾<br>「激光盾？我怎麼從沒聽過這事的？」<br>「這是一種寓攻擊於防禦的武器，可以在防禦敵人攻擊的同時作出突擊，出其不意」<br>「這麼厲害？一口價！」<br>「成交！<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型護盾<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;強力護盾<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;擴散米加粒子炮<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月鈦合金裝甲<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵」<br>', '828', '826', '605', '831', '712', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('48', '955', 5, '計都羅侯劍<br>有一個公會成員在一旁自成一角，喃喃自語，你走過去聽他說：<br>「我闖蕩江湖數十年，最難忘的還是那一次......那天，我正趕緊運送貨物，偶遇兩機大戰，忽然天昏地暗，雷電交加，<br>一把劍突然出現在烏雲間，其中一機立刻握緊，並向另一機直砍，引起了巨大沙塵，連我的商隊亦被波及了」<br>他更說了計都羅侯劍的鑄造方法：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;計都瞬獄劍<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;龍王破山劍．逆鯪斷<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;四象無形劍<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>可是，你眨眼間，那男的就不見了<br>', '324', '323', '320', '715', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('49', '956', 5, '高達尼姆合金裝甲<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－高達尼姆合金裝甲，它是一種合金裝甲，並較月鈦合金裝甲有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月鈦合金裝甲<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月鈦合金裝甲<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;強力護盾<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵」<br>「多謝惠顧！」<br>', '831', '831', '826', '718', '718', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('50', '957', 5, '超硬鋼裝甲<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－超硬鋼裝甲，它是一種合金裝甲，並較月鈦合金裝甲有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月鈦合金裝甲<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月鈦合金裝甲<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型護盾<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵」<br>「多謝惠顧！」<br>', '831', '831', '828', '718', '718', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('51', '958', 5, '念動力L式加農炮<br>你擁有念動力嗎？如果沒有，你是不能使用以下武器的！<br>一般的加農炮均需要大量能源，但念動力L式加農炮是例外，它只需要小量能源，卻達到了一般加農炮的攻擊水平<br>可惜只有念動力人種方可開動，而且會耗用精神力<br>鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T-Link&nbsp;Sensor<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T-Link&nbsp;Sensor<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;長距離光束加農炮<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束加農炮<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵&nbsp;&nbsp;&nbsp;&nbsp;<br>', '932', '932', '616', '614', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('52', '941', 4, 'Thruster　<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Thruster，它是一種輔助加速裝置，並較Mega&nbsp;Booster有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mega&nbsp;Booster<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mega&nbsp;Booster<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金」<br>「多謝惠顧！」<br>', '921', '921', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('53', '942', 4, '照準系統<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－照準系統，它是一種輔助瞄準裝置，並較瞄準器有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;瞄準器<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;瞄準器<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dual&nbsp;Sensor<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵」<br>「多謝惠顧！」<br>', '816', '816', '811', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('54', '943', 4, '電磁加農炮<br>你從公會成員聽說到有關電磁加農炮的事：<br>「電磁加農炮，故名思義，是兩把電磁炮與光束加農炮的結合，不過，這是不足夠的，因為還需要一塊最珍貴的晶石，才可完成鑄造過程」<br>', '933', '933', '614', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('55', '944', 4, 'AB&nbsp;Field<br>你偶然目睹了一場戰鬥:<br>A狠狠的以光束劍砍在B身上,&nbsp;忽然,&nbsp;一層不明顯的防護層出現了,&nbsp;把A的攻擊擋下了,&nbsp;然後b便一擊大破A.<br>機師得意洋洋的下了機,你乘機問問(?)的鑄造方法,&nbsp;他得意忘形的說了Beam&nbsp;Coating，黃金，強力護盾，G．Wall，黃金，<br>接著便走了。但是,&nbsp;你不知道放在熔爐的次序呢!不過,&nbsp;可以肯定的是,&nbsp;原料是不會放在前面的。<br>', '922', '821', '826', '715', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('56', '945', 4, 'Shield&nbsp;Buster&nbsp;Rifle<br>在你修行的路途上，看見了一部MS，且裝備了Buster&nbsp;Rifle。然而，老練的你只是看了看便打算離開。<br>「站住!」回頭一看，是一位少年，「這可不是普通的Buster&nbsp;Rifle，這是Shield&nbsp;Buster&nbsp;Rifle。」<br>此時,&nbsp;Buster&nbsp;Rifle的槍身展開,&nbsp;成了防護盾!&nbsp;<br>看到你熱衷的眼神,&nbsp;於是,&nbsp;他便給了你Shield&nbsp;Buster&nbsp;Rifle的鑄造方法:<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;強力護盾<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;大型護盾<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buster&nbsp;Rifle<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br>', '826', '828', '412', '718', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('57', '931', 3, '音速噴射系統<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：「我推薦你這個－音速噴射系統，它是一種加速系統，並較極速噴射加速系統有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;極速噴射加速系統<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;噴射加速系統<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵」<br>「多謝惠顧！」<br>', '911', '801', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('58', '932', 3, 'T-Link&nbsp;Sensor<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－T-Link&nbsp;Sensor，它是一種瞄準系統，並較Pscyo-Frame有效率，怎麼樣？」<br>你點頭示意，把錢交給他：<br>「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Multi-Sensor<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵」<br>「多謝惠顧！」<br>', '912', '715', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('59', '933', 3, '電磁炮<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「電磁炮是一種常見的武器，怛又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;回轉式電磁斧<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;電磁劍<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;軌道槍<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>', '117', '106', '406', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('60', '608', 3, '大型米加粒子炮<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「大型米加粒子炮是一種常見的武器，怛又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;米加粒子炮<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;米加粒子炮<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>', '601', '601', '715', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('61', '319', 3, '四象劍<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「四象劍是一種常見的武器，怛又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;熱能光束劍<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>', '303', '715', '712', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('62', '921', 2, 'Mega&nbsp;Booster<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Mega&nbsp;Booster，它是一種輔助加速裝置，並較Booster有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Booster<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Booster<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵」<br>「多謝惠顧！」<br>', '806', '806', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('63', '922', 2, 'Beam&nbsp;Coating<br>你偶然目睹了一場戰鬥:<br>A狠狠的以光束劍砍在B身上,&nbsp;忽然,&nbsp;一層不明顯的防護層出現了,&nbsp;把A的攻擊擋下了,&nbsp;然後b便一擊大破A.<br>機師得意洋洋的下了機,你乘機問問(?)的鑄造方法,&nbsp;他得意忘形的說了鋼鐵，G．Wall，鋼鐵，G．Wall，<br>接著便走了。但是,&nbsp;你不知道放在熔爐的次序呢!不過,&nbsp;可以肯定的是,&nbsp;原料是不會放在前面的。<br>', '821', '821', '712', '712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('64', '504', 2, '榴炮發射器<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「榴炮發射器是一種常見的武器，怛又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能飛彈發射器<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能飛彈發射器<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>', '502', '502', '715', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('65', '518', 2, '高出力火箭炮<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「高出力火箭炮是一種常見的武器，怛又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;原子能飛彈發射器<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>', '503', '715', '715', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('66', '911', 1, '極速噴射加速系統<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：「我推薦你這個－極速噴射加速系統，它是一種加速系統，並較噴射加速系統有效率，怎麼樣？」<br>你點頭示意，把錢交給他：「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;噴射加速系統<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;噴射加速系統<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅」<br>「多謝惠顧！」<br>', '801', '801', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('67', '912', 1, 'Multi-Sensor<br>公會成員：「能在市面上購買的輔助裝備，實在是不足的，不過在這?，我們能為你提供更多的輔助裝備鑄造方法」<br>說著，他掃視了你手上的鈔票，想了想，說：<br>「我推薦你這個－Multi-Sensor，它是一種瞄準系統，並較T-Link&nbsp;Sensor有效率，怎麼樣？」<br>你點頭示意，把錢交給他：<br>「鑄造方法如下：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dual&nbsp;Sensor<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dual&nbsp;Sensor<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅」<br>「多謝惠顧！」<br>', '811', '811', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('68', '107', 1, '高周波刀<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「高周波刀是一種常見的武器，怛又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高出力光束配刀<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;光束小刀<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>', '104', '102', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('69', '213', 1, '熱帶低氣壓重拳<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「熱帶低氣壓重拳是一種常見的武器，怛又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鐵拳<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鐵拳<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅&nbsp;&nbsp;&nbsp;&nbsp;<br>', '202', '202', '711', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('70', '510', 1, '5連裝飛彈發射器<br>第一次來到公會，心情難免有點緊張，結果忘記了來到公會的原因<br>幸好，有一位熱心的成員前來協助，你把一切告訴他，他說：<br>「5連裝飛彈發射器是一種常見的武器，怛又可否知道它的鑄造方法？若不知道，可參考以下內容」<br>然後，他遞給你一本書：<br>一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能飛彈發射器<br>二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能飛彈發射器<br>三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鋼鐵<br>四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;青銅&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>', '502', '502', '712', '711', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('71', '96001', '6', 'EXAM System<br> 這一天你又來到了工程師公會，發現了一大堆學者正認真地打量著一部殘缺不堪的MS。<br> 為滿足你的好奇心，你走上前去，試圖從聽學者們的話中打聽這部MS的來歷。<br> <br> 「這部以藍色為主要色系的機體是.....﹖」<br> 「你這新來的﹗這就是那不分敵我都胡亂攻擊的\"惡魔\"啊﹗」<br> 「嗯...那時他展現的非凡破壞力...簡直叫我心寒.....」<br> 「不只是破壞力，就是回避力，命中率都較一般MS要高呢﹗」<br> 「那為什麼會落得如此下場?」<br> 「因為那個系統強行把出力提高,使機體都負擔不了......」<br> 「聽說連駕駛者...都被弄得神志不清呢...」<br> 「難道...這就是傳說中裝備了EXAM System的\"Blue Destiny\"﹗﹖」<br> 「讓我把系統給電腦掃一下......」<br> <br> 「Multi-Sensor、Dual Sensor、Multi-Sensor、Dual Sensor、Multi-Sensor、Dual Sensor、水晶、黃金、水晶、黃金」<br> <br> 正當你幻想著自己的機體裝備EXAM System後力量是何其強大的同時，<br> 你突然感到自己後領被一道何其強大的力量拉扯，就這樣被一個警衛提出公會門外﹕<br> <br> 「你在這裏幹啥﹖難道你是敵國派來的間諜﹖」<br> <br> 為保自己的清白，你連忙向他解釋﹕<br> <br> 「嗯......是這樣的......」<br>', '912', '811', '912', '811', '912', '811', '718', '715', '718', '715', NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL );");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('72', '90002', '10', '你目睹了一場爭執﹕<br> <br> 「像你這 Coordinator 有什麼厲害，還不及我們這些Newtype﹗」一個男人以食指指向一個戴著面具的男人。<br> 「你只是人造的產物而已﹗」又一個男人指著那個戴著面具的男人。<br> 「我們Newtype能使用浮游炮，你呢﹖」再一個男人指向那個戴著面具的男人。<br> 「啪﹗」在千夫所指下，那戴著面具的男人終於沉不著氣，一掌打在桌上﹕<br> 「你們這些沒見識的人，有沒有聽過Super DRAGOON? 就是我們Coordinator專用的武器，能力更在浮游炮之上！」<br> 「那麼Super DRAGOON又是怎樣鑄造的﹖」你心裏好奇地問。<br> 那戴著面具的男人回過頭來，瞥了你一眼，遞了一張字條﹕<br> <br> 面具男的保證鑄造法----Super DRAGOON<br> <br> 一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;飛翔炮<br> 二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Newtype系統對應有線式光束炮<br> 三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bit<br> 四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bit<br> 五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br> 六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br> 七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br> 八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br> 九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br> 十號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br> 十一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br> 十二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br> 十三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br> <br> 雖然你很奇怪為什麼那戴著面具的男人知道你在想什麼，<br> 但不管怎樣，你幸運地獲得了鑄造Super DRAGOON的方法。<br>', '997', '620', '971', '971', '405', '405', '405', '405', '718', '718', '715', '715', '715', NULL , NULL , NULL , NULL , NULL , NULL , NULL );");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('73', '969', '6', '新高達尼姆合金<br> 這一天你又來到了工程師公會，看到一名工程師，埋頭苦幹，拿著鋼筆寫字。<br> 他一面寫，一面就哼唱著小調。<br> 突然，他回頭一望，便對你笑說：「這歌詞你一定會很喜歡！」<br> 然後，他便迅速取去你手上那箱鈔票，逃去無蹤了。<br> _______________________________________________________<br> 您想變強嗎?<br> 作曲、編曲﹕我　　　　　填詞﹕冷月無聲<br> 小修﹕　　　栩月　　　　製作﹕風之翎<br> <br> 經歷了長久的努力和付出後<br> 得到了心目中的神兵利器<br> 又把它用得滾爪爛熟之際....<br> <br> 卻發現，發現了您敵人所擁有的<br> 並不比您的弱，甚至更勝於您<br> 更對您咄咄相逼,使您無力招架<br> <br> 您有感到自己的力量不足嗎?<br> 您有感到自己所付出的已諸東流嗎?<br> 您有想過令自己的武器與機體<br> 按照自己的思想作出強化與進步嗎??<br> <br> Repeat *<br> 既然您付了錢,當然不會讓您感到灰心<br> 請您緊記以下之物的制作配方<br> 一三七青銅 四五鋼鐵<br> 二六十黃金 八九水晶<br> 它!能令你變強!!<br> <br> 它!能令你更進一步地變強!!<br> _______________________________________________________<br> 「有種被騙的感覺。。」你心想著。<br>', '711', '715', '711', '712', '712', '715', '711', '718', '718', '715', NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL );");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` (
  `id` varchar(14) binary NOT NULL default '0',
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
) TYPE=MyISAM;");

mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('0', '通常攻擊', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('StrikeA', '突擊', 0, 5, 2, 10, -2, -2, -1, 0, 0, 100000, 6, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('DefCounterA', '防禦反擊', 0, 0, 2, -5, 10, -5, 0, 5, 0, 120000, 11, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('QuickA', '迅速', 0, 10, 2, 0, -5, 10, -2, 0, 5, 120000, 11, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('SnipeA', '狙擊', 0, 10, 5, 2, -3, -5, 10, 5, 0, 500000, 27, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('StrikeB', '捨身', 100, 10, 5, 20, -5, 0, 0, 5, 5, 500000, 27, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('DoubleStrike', '二連擊', 0, 0, 20, 0, 0, -5, -10, 10, 0, 1000000, 35, 'DoubleStrike');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('TripleStrike', '三連擊', 0, 0, 40, 0, 0, -5, -10, 10, 0, 3000000, 65, 'TripleStrike');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('AllWepStirke', '全彈發射', 100, 50, 25, 0, 0, 0, -20, 25, 0, 2500000, 56, 'AllWepStirke');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('RaidStrike', '奇襲', 0, 5, 35, 5, 5, 25, 10, 0, 0, 4000000, 70, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('MindStrike', '心眼', 0, 0, 40, 10, -5, 5, 25, 5, 0, 4000000, 70, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('SenseStrike', '靈感', 0, 25, 60, 25, 0, 10, 10, 10, 10, 10000000, 80, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('CounterStrike', '伺機反擊', 0, 0, 45, 0, 0, 0, 0, 20, 0, 12000000, 85, 'CounterStrike');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('FirstStrike', '先制攻擊', 0, 30, 45, 0, 0, 5, -5, 0, 0, 12000000, 85, 'FirstStrike');");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` (
  `id` varchar(16) NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `grade` tinyint(3) NOT NULL default '0',
  `kind` varchar(3) NOT NULL default 'N',
  `familyid` varchar(5) NOT NULL default '0',
  `nextev` text NOT NULL,
  `specev` text NOT NULL,
  `atk` mediumint(6) unsigned NOT NULL default '0',
  `hit` tinyint(3) unsigned NOT NULL default '0',
  `rd` tinyint(3) unsigned NOT NULL default '0',
  `enc` smallint(5) unsigned NOT NULL default '0',
  `price` int(10) unsigned NOT NULL default '0',
  `equip` tinyint(1) NOT NULL default '0',
  `spec` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;");

mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('0', '無武器', 0, 'N', '0', '', '', 0, 0, 0, 0, 0, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('101', '小刀', 1, 'BDI', '101', '102,124', '', 780, 95, 2, 15, 40000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('102', '光束小刀', 2, 'BDI', '101', '103', '', 780, 95, 2, 30, 48000, 0, 'MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('103', '光束配刀', 3, 'BI', '101', '104', '', 850, 98, 2, 45, 57000, 0, 'MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('104', '高出力光束配刀', 4, 'I', '101', '105', '107', 1000, 98, 2, 60, 65000, 0, 'MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('105', '電磁力光束配刀', 5, 'I', '101', '115', '106', 1200, 99, 2, 90, 74000, 0, 'MeltB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('106', '電磁劍', 6, 'I', '101', '', '', 2700, 100, 1, 115, 80000, 0, 'MeltB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('107', '高周波刀', 6, 'N', '101', '108', '', 1200, 100, 2, 90, 84000, 0, 'DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('108', '高出力周波刀', 7, 'N', '101', '109', '110', 630, 105, 4, 100, 95000, 0, 'DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('109', '妖刀村正', 8, 'N', '101', '', '', 1525, 100, 2, 115, 100000, 0, 'DamA,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('110', '對艦刀《SCHWERT-GEWEHER》', 5, 'N', '101', '', '', 835, 100, 4, 130, 100000, 0, 'DamB,MeltB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('115', '電磁斧', 5, 'I', '101', '116,117', '', 2500, 100, 1, 85, 63000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('116', '大型電磁斧', 6, 'I', '101', '', '', 2950, 95, 1, 105, 72000, 0, 'DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('117', '回轉式電磁斧', 6, 'N', '101', '', '118', 1300, 95, 2, 95, 71000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('118', '雙回轉式電磁斧', 7, 'N', '101', '', '', 730, 95, 4, 100, 86000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('124', '金屬小刀', 2, 'I', '101', '125', '', 800, 100, 2, 25, 46000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('125', '重裝金屬小刀', 3, 'DI', '101', '', '126', 870, 100, 2, 40, 57000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('126', '重斬刀', 4, 'N', '101', '128', '127', 680, 100, 3, 65, 69000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('127', '青龍刀', 4, 'N', '101', '', '128', 780, 100, 4, 135, 85000, 0, 'DamA,DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('128', '對裝甲刀', 5, 'N', '101', '', '129', 1520, 100, 2, 130, 100000, 0, 'DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('129', '斬艦刀', 6, 'N', '101', '', '', 1780, 100, 2, 150, 100000, 0, 'DamA,DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('201', '格鬥', 1, 'BDI', '201', '202', '', 540, 100, 3, 15, 45000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('202', '鐵拳', 2, 'DI', '201', '203,212', '', 570, 100, 3, 25, 50000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('203', '剛腕粉碎擊', 3, 'I', '201', '204', '219', 610, 103, 3, 35, 55000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('204', '波動龍神擊', 4, 'I', '201', '205', '', 650, 105, 3, 50, 63000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('205', '旋風三連擊', 5, 'I', '201', '206', '', 710, 105, 3, 70, 72000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('206', '爆碎重落下', 6, 'I', '201', '', '207', 770, 105, 3, 95, 81000, 0, 'DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('207', '疾風雙連擊', 7, 'N', '201', '', '208', 750, 105, 4, 125, 90000, 0, 'DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('208', '醉舞．再現江湖', 8, 'N', '201', '', '', 680, 105, 5, 160, 100000, 0, 'MobA,AtkA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('212', '燃之重拳', 3, 'I', '201', '213', '216', 775, 100, 3, 60, 75000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('213', '熱帶低氣壓重拳', 4, 'I', '201', '', '214', 620, 100, 4, 95, 83000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('214', '豪熱機關槍重拳', 5, 'N', '201', '', '215', 490, 100, 6, 110, 90000, 0, 'AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('215', '十二王方牌大車輪', 7, 'N', '201', '', '', 265, 100, 12, 125, 100000, 0, 'AntiPDef,AtkA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('216', 'T-Link Knuckle', 2, 'N', '201', '', '', 1500, 110, 2, 120, 70000, 0, 'PsyRequired,DamB,AntiPDef,CostSP<3>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('219', '機械爪', 3, 'DI', '201', '220', '', 1100, 100, 2, 90, 56000, 0, 'Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('220', '重裝機械爪', 4, 'N', '201', '221', '223', 1275, 105, 2, 110, 64000, 0, 'Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('221', '神龍伸縮爪', 5, 'N', '201', '', '222', 850, 105, 3, 145, 73000, 0, 'Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('222', '真．流星蝴蝶劍', 6, 'N', '201', '', '', 400, 105, 8, 175, 95000, 0, 'DamB,Cease,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('223', '溶斷破碎機械手', 4, 'N', '201', '', '', 1675, 110, 2, 170, 90000, 0, 'DamA,Cease,MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('301', '光束劍', 1, 'BDI', '301', '302', '', 830, 100, 2, 20, 60000, 0, 'MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('302', '試作型光束劍', 2, 'DI', '301', '303', '', 900, 100, 2, 30, 63000, 0, 'MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('303', '熱能光束劍', 2, 'DI', '301', '304', '', 950, 100, 2, 38, 67000, 0, 'MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('304', '腕式光劍', 3, 'I', '301', '305,318', '', 1050, 100, 2, 48, 71000, 0, 'MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('305', '米加光束劍', 4, 'N', '301', '', '306,310,312', 1180, 100, 2, 59, 78000, 0, 'MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('306', '大型光束劍', 6, 'N', '301', '307', '309', 1330, 100, 2, 80, 86000, 0, 'MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('307', 'Hi-光束劍', 7, 'N', '301', '308', '', 1400, 100, 2, 110, 89000, 0, 'MeltB,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('308', 'Hyper光束劍', 8, 'N', '301', '', '', 1580, 100, 2, 140, 94500, 0, 'MeltB,DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('309', '超大型光束劍', 7, 'N', '301', '', '', 1560, 100, 2, 130, 93000, 0, 'MeltA,Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('310', '背部光束切裂器', 3, 'I', '301', '', '', 2880, 100, 1, 90, 71000, 0, 'MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('312', '誘導式光束劍', 7, 'N', '301', '', '313,314', 2800, 95, 1, 135, 90000, 0, 'MeltB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('313', '有線式光束劍', 8, 'N', '301', '', '', 3100, 95, 1, 155, 99000, 0, 'Cease,MeltB,NTRequired,CostSP<5>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('314', '天上天下念動破碎劍', 8, 'N', '301', '', '', 3200, 95, 1, 175, 110000, 0, 'MeltB,DamB,AntiPDef,PsyRequired,CostSP<7>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('318', '斬鐵劍', 5, 'I', '301', '319', '', 1240, 100, 2, 105, 83000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('319', '四象劍', 6, 'N', '301', '320', '322', 1340, 100, 2, 110, 87000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('320', '四象無形劍', 7, 'N', '301', '324', '321', 1450, 100, 2, 140, 91000, 0, 'Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('321', '神速．四象無形劍', 8, 'N', '301', '', '', 1600, 100, 2, 180, 95000, 0, 'Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('322', '龍王破山劍', 9, 'N', '301', '', '323', 1100, 99, 3, 200, 110000, 0, 'AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('323', '龍王破山劍．逆鯪斷', 10, 'N', '301', '', '', 1250, 99, 3, 230, 125000, 0, 'DamA,DamB,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('324', '計都瞬獄劍', 7, 'I', '301', '', '', 1050, 100, 3, 140, 115000, 0, 'DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('401', '105mm機槍', 1, 'BDI', '401', '402', '', 550, 95, 3, 30, 60000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('402', '110mm速射炮', 2, 'DI', '401', '403,417', '', 630, 95, 3, 45, 65000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('403', '光束步槍', 3, 'DI', '401', '405', '404', 730, 95, 3, 60, 71000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('404', '雙光束步槍', 4, 'N', '401', '', '', 640, 85, 4, 125, 77000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('405', '高能光束步槍', 5, 'I', '401', '411', '406', 810, 95, 3, 90, 81000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('406', '軌道槍', 6, 'N', '401', '407,408', '410', 933, 98, 3, 120, 85000, 0, 'DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('407', '2連裝軌道槍', 7, 'N', '401', '', '', 505, 90, 6, 140, 89000, 0, 'DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('408', '破壞軌道槍', 7, 'N', '401', '', '409', 1000, 90, 3, 130, 88000, 0, 'AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('409', '超重力軌道槍', 8, 'N', '401', '', '', 1220, 98, 3, 180, 93500, 0, 'AntiPDef,DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('410', '280mm軌道加農炮', 8, 'N', '401', '', '', 821, 88, 4, 160, 90000, 0, 'AntiPDef,MeltA,DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('411', 'Mega．Beam Rifle', 6, 'N', '401', '', '412', 910, 96, 3, 90, 75000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('412', 'Buster Rifle', 7, 'N', '401', '', '', 630, 98, 5, 170, 95000, 0, 'DamA,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('417', '120mm機炮', 3, 'BDI', '401', '', '418', 610, 90, 3, 55, 65000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('418', '重突擊機統', 4, 'I', '401', '419,426', '', 650, 90, 3, 70, 71000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('419', '霰彈炮', 5, 'N', '401', '420', '422', 230, 90, 10, 90, 76000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('420', '光束霰彈炮', 6, 'N', '401', '421', '', 205, 90, 15, 115, 85000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('421', '高能光束霰彈炮', 7, 'I', '401', '', '', 215, 95, 15, 145, 94000, 0, 'DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('422', '對裝甲散彈炮', 6, 'N', '401', '', '', 270, 90, 10, 125, 90000, 0, 'AntiPDef,DamA,DamB,MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('426', '高能機炮', 5, 'I', '401', '427', '', 695, 95, 3, 80, 74000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('427', '大型機炮', 6, 'N', '401', '428', '431', 575, 95, 4, 105, 82000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('428', '超重型機炮', 7, 'N', '401', '429', '', 435, 95, 6, 135, 91000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('429', '光束旋轉機炮', 8, 'N', '401', '', '430', 525, 99, 6, 160, 100000, 0, 'Cease,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('430', '雙光束旋轉機炮', 10, 'N', '401', '', '', 295, 99, 12, 190, 115000, 0, 'DamA,Cease,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('431', '180mm 加農炮', 7, 'N', '401', '', '', 1350, 97, 2, 155, 93000, 0, 'DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('501', '飛彈發射器', 1, 'BDI', '501', '502,509', '', 900, 85, 2, 35, 80000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('502', '高能飛彈發射器', 2, 'I', '501', '503', '', 1100, 85, 2, 55, 85000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('503', '原子能飛彈發射器', 4, 'N', '501', '', '504,516', 1300, 88, 2, 75, 90500, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('504', '榴炮發射器', 6, 'N', '501', '', '505', 1550, 88, 2, 95, 95000, 0, 'AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('505', '核彈發射器', 8, 'N', '501', '', '', 4000, 88, 1, 120, 99999, 0, 'DamA,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('509', '連裝飛彈發射器', 2, 'DI', '501', '510', '', 800, 87, 3, 64, 87000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('510', '5連裝飛彈發射器', 3, 'I', '501', '511', '', 550, 86, 5, 83, 94000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('511', '10連裝飛彈發射器', 4, 'N', '501', '512', '513', 300, 85, 10, 95, 98500, 0, 'Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('512', '全方位火箭發射器', 6, 'N', '501', '', '', 185, 85, 20, 110, 105000, 0, 'Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('513', '小型自己誘導飛彈', 6, 'N', '501', '', '', 235, 100, 12, 150, 400000, 0, 'Tarb,AntiMobS');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('516', '240mm火箭炮', 3, 'I', '501', '518,519,520', '517', 2450, 80, 1, 70, 90000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('517', 'NEO火箭炮', 3, 'I', '501', '', '', 2700, 88, 1, 88, 94500, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('518', '高出力火箭炮', 4, 'N', '501', '', '', 2950, 88, 1, 95, 96500, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('519', '散彈火箭炮', 7, 'N', '501', '', '', 845, 96, 4, 100, 120000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('520', '大型火箭炮', 6, 'N', '501', '521,522', '', 3250, 88, 1, 120, 99000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('521', '原子火箭炮', 7, 'N', '501', '', '', 3300, 93, 1, 135, 110000, 0, 'DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('522', '核子火箭炮', 8, 'N', '501', '', '', 3550, 93, 1, 155, 131000, 0, 'DamA,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('601', '米加粒子炮', 1, 'BDI', '601', '602', '613', 440, 78, 5, 70, 90000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('602', '偏向米加粒子炮', 2, 'I', '601', '603', '608,609', 400, 78, 6, 80, 93000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('603', '連裝米加粒子炮', 3, 'I', '601', '604', '', 350, 78, 8, 90, 97000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('604', '散彈米加粒子炮', 4, 'I', '601', '605', '', 380, 78, 8, 110, 120000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('605', '擴散米加粒子炮', 5, 'N', '601', '606', '', 275, 78, 12, 125, 126000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('606', '全方位擴散米加粒子炮', 6, 'N', '601', '', '607', 188, 75, 16, 140, 132000, 0, 'Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('607', '全出力擴散米加粒子炮', 7, 'N', '601', '', '', 160, 70, 20, 185, 137000, 0, 'Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('608', '大型米加粒子炮', 3, 'I', '601', '', '', 588, 75, 5, 160, 97000, 0, 'DamA,DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('609', '單裝炮', 3, 'I', '601', '610', '', 680, 75, 4, 140, 97000, 0, 'DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('610', '衝角炮', 3, 'I', '601', '', '611', 600, 75, 5, 175, 97000, 0, 'DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('611', '二連裝衝角炮', 3, 'I', '601', '', '', 350, 75, 10, 200, 97000, 0, 'DamA,DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('613', '光束炮', 3, 'I', '601', '614', '616', 540, 75, 5, 90, 115000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('614', '光束加農炮', 4, 'I', '601', '615', '620', 575, 75, 5, 110, 119000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('615', '米加加農炮', 4, 'N', '601', '', '', 680, 78, 5, 170, 122000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('616', '長距離光束加農炮', 5, 'N', '601', '', '617', 540, 80, 6, 155, 124000, 0, '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('617', '米加光束加農炮', 6, 'N', '601', '619', '618', 570, 80, 6, 175, 130000, 0, 'MeltB,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('618', '米加音波炮', 7, 'N', '601', '', '', 555, 95, 6, 220, 140000, 0, 'MeltA,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('619', '大型光束加農炮', 8, 'N', '601', '', '', 430, 78, 8, 195, 129000, 0, 'DamA,DamB, AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('620', 'Newtype系統對應有線式光束炮', 7, 'N', '601', '', '', 835, 75, 4, 175, 120000, 0, 'DamA,NTCustom,CostSP<6>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('701', '青銅劍', 1, 'BI', '701', '702', '711', 1000, 95, 1, 25, 100000, 0, 'DoubleMon');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('702', '鋼鐵劍', 2, 'I', '701', '703', '712', 1100, 95, 1, 35, 110000, 0, 'DoubleMon');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('703', '晶石劍', 3, 'I', '701', '704', '', 1200, 96, 1, 45, 120000, 0, 'DoubleMon');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('704', '白銀劍', 4, 'I', '701', '705', '', 1300, 96, 1, 65, 130000, 0, 'DoubleMon');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('705', '黃金劍', 5, 'N', '701', '706', '715', 1400, 97, 1, 75, 140000, 0, 'DoubleMon');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('706', '白金劍', 6, 'N', '701', '707', '', 1500, 97, 1, 90, 150000, 0, 'DoubleMon');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('707', '鑽石劍', 7, 'N', '701', '', '708', 1600, 100, 1, 110, 160000, 0, 'DoubleMon');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('708', '水晶劍', 8, 'N', '701', '', '718', 1800, 100, 1, 140, 170000, 0, 'DoubleMon');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('711', '青銅', 0, 'N', '0', '', '', 0, 0, 0, 0, 120000, 0, 'RawMaterials');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('712', '鋼鐵', 0, 'N', '0', '', '', 0, 0, 0, 0, 135000, 0, 'RawMaterials');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('715', '黃金', 0, 'N', '0', '', '', 0, 0, 0, 0, 180000, 0, 'RawMaterials');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('718', '水晶', 0, 'N', '0', '', '', 0, 0, 0, 0, 225000, 0, 'RawMaterials');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('801', '噴射加速系統', 0, 'BI', '0', '', '', 0, 0, 0, 60, 600000, 2, 'Moba');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('806', 'Booster', 0, 'BI', '0', '', '', 0, 0, 0, 80, 600000, 2, 'MobA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('811', 'Dual Sensor', 0, 'BI', '0', '', '', 0, 0, 0, 30, 600000, 2, 'Tara');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('816', '瞄準器', 0, 'BI', '0', '', '', 0, 0, 0, 35, 600000, 2, 'TarA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('821', 'G．Wall', 0, 'BI', '0', '', '', 0, 0, 0, 70, 600000, 2, 'Defa,AntiDam');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('826', '強力護盾', 0, 'BI', '0', '', '', 0, 0, 0, 50, 600000, 2, 'DefA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('827', '光束護盾', 0, 'BI', '0', '', '', 0, 0, 0, 50, 600000, 2, 'Defa');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('828', '大型護盾', 0, 'BI', '0', '', '', 0, 0, 0, 40, 500000, 2, 'AntiDam');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('831', '月鈦合金裝甲', 0, 'BI', '0', '', '', 0, 0, 0, 150, 1000000, 2, 'DefB,ExtHP<600>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('90002', 'Super DRAGOON', 13, 'N', '0', '', '', 320, 125, 16, 800, 36500000, 0, 'COCustom,AntiPDef,MeltA,');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('901', 'G-bit衛星微波能量炮', 12, 'N', '0', '', '', 1150, 90, 6, 800, 380000, 0, 'NTCustom,DamA,DamB,MeltA,AntiPDef,CostSP<50>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('902', '天上天下念動爆碎劍', 12, 'N', '0', '', '', 2800, 115, 2, 650, 370000, 0, 'AntiPDef,PsyRequired,DamA,MeltB,CostSP<30>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('903', '縮退炮', 11, 'N', '0', '', '', 1070, 95, 5, 490, 360000, 0, 'DamA,DamB,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('904', '光之翼', 10, 'N', '0', '', '', 5100, 105, 1, 480, 370000, 0, 'MeltB,Mobb,AntiTarS');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('905', '黑洞炮', 11, 'N', '0', '', '', 1700, 90, 3, 490, 360000, 0, 'Cease，DamA,DamB,AntiMobS');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('906', 'Solar panel', 0, 'N', '0', '', '', 0, 0, 0, 0, 2000000, 2, 'ENPcRecB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('907', 'NANO Skin', 0, 'N', '0', '', '', 0, 0, 0, 0, 2000000, 2, 'HPPcRecA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('908', 'Z．O．Armor', 0, 'N', '0', '', '', 0, 0, 0, 300, 1600000, 2, 'DefE,AntiDam,ExtHP<3000>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('909', '超合金newZ裝甲', 0, 'N', '0', '', '', 0, 0, 0, 350, 1600000, 2, 'DefE,PerfDef,ExtHP<2000>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('911', '極速噴射加速系統', 0, 'I', '0', '', '', 0, 0, 0, 100, 500000, 2, 'Mobb');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('912', 'Multi-Sensor', 0, 'I', '0', '', '', 0, 0, 0, 70, 500000, 2, 'Tarb');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('921', 'Mega Booster', 0, 'I', '0', '', '', 0, 0, 0, 120, 650000, 2, 'MobB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('922', 'Beam Coating', 0, 'I', '0', '', '', 0, 0, 0, 110, 1000000, 2, 'Defb');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('931', '音速噴射系統', 0, 'I', '0', '', '', 0, 0, 0, 150, 750000, 2, 'Mobc');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('932', 'T-Link Sensor', 0, 'I', '0', '', '', 0, 0, 0, 150, 800000, 2, 'Tarc,AntiMobS');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('933', '電磁炮', 3, 'I', '0', '', '', 1250, 98, 3, 190, 100000, 0, 'DamA,DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('941', 'Thruster', 0, 'I', '0', '', '', 0, 0, 0, 180, 900000, 2, 'MobC');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('942', '照準系統', 0, 'I', '0', '', '', 0, 0, 0, 80, 900000, 2, 'TarB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('943', '電磁加農炮', 4, 'I', '0', '', '', 1365, 98, 3, 240, 120000, 0, 'DamA,DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('944', 'AB Field', 0, 'I', '0', '', '', 0, 0, 0, 160, 1050000, 2, 'Defc');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('945', 'Shield Buster Rifle', 6, 'I', '0', '', '', 620, 98, 5, 115, 120000, 1, 'DamA,AntiPDef,DefC');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('951', '菊一文字', 5, 'I', '0', '', '', 1890, 99, 2, 275, 130000, 0, 'DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('952', '引力子步槍BST', 5, 'I', '0', '', '', 1310, 95, 3, 300, 140000, 0, 'DamA,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('953', '紅外線追蹤飛彈', 7, 'I', '0', '', '', 400, 120, 8, 255, 200000, 0, 'Tarc,AntiMobS,Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('954', '激光盾', 6, 'I', '0', '', '', 340, 90, 10, 200, 130000, 1, 'MeltA,DamA,DefA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('955', '計都羅侯劍', 6, 'I', '0', '', '', 3590, 100, 1, 275, 175000, 0, 'AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('956', '高達尼姆合金裝甲', 0, 'I', '0', '', '', 0, 0, 0, 200, 1020000, 2, 'DefC,ExtHP<900>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('957', '超硬鋼裝甲', 0, 'I', '0', '', '', 0, 0, 0, 200, 1020000, 2, 'DefC,ExtHP<800>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('958', '念動力L式加農炮', 0, 'I', '0', '', '', 640, 95, 6, 215, 270000, 0, 'PsyRequired,DamA,AntiPDef,TarB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('96001', 'EXAM System', 0, 'N', '0', '', '', 0, 0, 0, 30, 1100000, 2, 'EXAMSystem, MobA, TarA, AtkA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('961', '擴散粒子彈', 9, 'I', '0', '', '', 260, 93, 15, 330, 160000, 0, 'AntiPDef,AtkA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('962', 'Buster Beam Rifle', 8, 'N', '0', '', '', 1030, 95, 4, 320, 1270000, 1, 'AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('963', '天空劍', 7, 'N', '0', '', '', 3850, 100, 1, 310, 155000, 0, 'DamA,DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('964', '光速移動系統', 0, 'I', '0', '', '', 0, 0, 0, 210, 1100000, 2, 'Mobd');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('965', '高性能照準系統', 0, 'I', '0', '', '', 0, 0, 0, 140, 1100000, 2, 'TarC,Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('966', 'I-Field Barrier', 0, 'I', '0', '', '', 0, 0, 0, 220, 1250000, 2, 'Defd,AntiDam');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('967', 'E field', 0, 'I', '0', '', '', 0, 0, 0, 220, 1250000, 2, 'Defd,PerfDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('968', '格林機關炮', 8, 'I', '0', '', '', 380, 95, 10, 310, 155000, 0, 'DamB,AtkA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('969', '新高達尼姆合金', 0, 'N', '0', '', '', 0, 0, 0, 0, 250000, 0, 'RawMaterials');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('971', 'Bit', 8, 'I', '0', '', '', 345, 110, 12, 280, 50000, 0, 'NTRequired,Cease,CostSP<8>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('972', 'Divider', 8, 'I', '0', '', '', 322, 100, 13, 340, 650000, 0, 'AntiPDef,DamA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('973', '計都羅侯劍*暗劍殺', 9, 'I', '0', '', '', 4450, 105, 1, 355, 2300000, 0, 'AntiPDef,MobA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('974', '衛星微波能量炮', 9, 'I', '0', '', '', 2400, 90, 2, 450, 1650000, 0, 'NTCustom,AntiPDef,CostSP<15>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('975', 'Psyco-Frame', 0, 'I', '0', '', '', 0, 0, 0, 220, 1000000, 2, 'Tard,AntiMobS');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('976', 'Hyper Thruster', 0, 'I', '0', '', '', 0, 0, 0, 240, 1000000, 2, 'MobD');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('977', '高性能雷達', 0, 'I', '0', '', '', 0, 0, 0, 185, 1000000, 2, 'TarC,AntiMobS');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('978', '念動力Field', 0, 'I', '0', '', '', 0, 0, 0, 250, 1350000, 2, 'PsyRequired,PerfDef,DefX');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('979', 'FF Barrier', 0, 'I', '0', '', '', 0, 0, 0, 240, 1300000, 2, 'Defd,AntiDam');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('981', '天空劍．V字斬', 9, 'I', '0', '', '', 2270, 100, 2, 385, 700000, 0, 'DamA,DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('982', '超電磁龍卷', 9, 'I', '0', '', '', 430, 96, 10, 380, 700000, 0, 'AntiMobS,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('983', '天上天下無敵劍', 9, 'I', '0', '', '', 2300, 100, 2, 395, 710000, 0, 'PsyRequired,MeltA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('984', '雙格林機關炮', 10, 'I', '0', '', '', 215, 95, 20, 355, 690000, 0, 'DamA,DamB,AtkA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('985', '零式斬艦刀', 10, 'I', '0', '', '', 4600, 92, 1, 390, 690000, 0, 'AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('986', 'Transitive FEAR', 0, 'I', '0', '', '', 0, 0, 0, 320, 1300000, 2, 'Mobd,AntiTarS');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('987', '三次元雷達', 0, 'I', '0', '', '', 0, 0, 0, 250, 1100000, 2, 'TarD,AntiMobS');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('988', 'G．Territory', 0, 'I', '0', '', '', 0, 0, 0, 280, 1500000, 2, 'Defe,PerfDef,AntiDam');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('989', '超合金Z裝甲', 0, 'I', '0', '', '', 0, 0, 0, 250, 1250000, 2, 'DefD,ExtHP<1500>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('991', 'V.S.B.R.', 9, 'N', '0', '', '', 1055, 105, 4, 400, 280000, 0, 'DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('992', 'Twin Buster Rifle', 10, 'N', '0', '', '', 790, 95, 6, 435, 280000, 0, 'DamA,DamB,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('993', '雙衛星微波能量炮', 11, 'N', '0', '', '', 1320, 92, 4, 530, 300000, 0, 'NTCustom,AntiPDef,DamB,CostSP<25>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('994', '反應彈', 11, 'N', '0', '', '99001', 2275, 92, 2, 430, 250000, 0, 'DamA,DamB');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('99001', '對艦用大型反應彈', 11, 'N', '0', '', '', 1330, 86, 4, 650, 1000000, 0, 'DamA,DamB,AntiPDef');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('995', '斬艦刀．一文字斬', 11, 'N', '0', '', '', 4990, 105, 1, 450, 250000, 0, 'AntiPDef,DamA,DamB,Cease');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('996', '浮游炮', 10, 'N', '0', '', '', 385, 120, 12, 350, 165000, 0, 'NTCustom,Cease,CostSP<12>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('997', '飛翔炮', 10, 'N', '0', '', '', 405, 130, 12, 360, 168000, 0, 'NTCustom,Cease,CostSP<15>');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('998', 'HiMAT System', 0, 'N', '0', '', '', 0, 0, 0, 295, 1300000, 2, 'Mobe,AntiTarS');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('999', 'E - cap', 0, 'N', '0', '', '', 0, 0, 0, 0, 1700000, 2, 'ENPcRecA');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('FortWepA', '對空自動火神炮炮塔系統', 0, 'I', '0', '', '', 1000, 85, 40, 0, 500000, 0, 'Cease, DamA, FortressOnly, CannotEquip');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('FortWepB', '防守用連裝對艦飛彈炮台', 0, 'I', '0', '', '', 1000, 110, 20, 0, 5500000, 0, 'TarD, AntiMobS, Cease, FortressOnly, CannotEquip');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('FortWepC', '陽電子破壞炮', 0, 'I', '0', '', '', 1760, 75, 20, 0, 15000000, 0, 'MeltA, AntiMobS, Cease, FortressOnly, CannotEquip');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('FortWepD', '殖民星雷射炮', 0, 'I', '0', '', '', 50000, 100, 1, 0, 155000000, 0, 'MeltB, AntiMobS, Cease, AntiPDef, TarC, FortressOnly, CannotEquip');");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_bank` (
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
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` (
  `username` varchar(16) binary NOT NULL default '',
  `gamename` varchar(32) binary NOT NULL default '',
  `hp` mediumint(6) unsigned NOT NULL default '0',
  `hpmax` mediumint(6) unsigned NOT NULL default '0',
  `en` mediumint(6) unsigned NOT NULL default '0',
  `enmax` mediumint(6) unsigned NOT NULL default '0',
  `sp` float(8,5) unsigned NOT NULL default '0',
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
  `victory` mediumint(6) unsigned NOT NULL default '0',
  `v_points` mediumint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`username`),
  UNIQUE KEY `gamename` (`gamename`)
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` (
  `username` varchar(16) binary NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `regkey` varchar(16) binary NOT NULL default '',
  `cash` int(10) unsigned NOT NULL default '0',
  `bounty` int(10) unsigned NOT NULL default '0',
  `color` tinytext,
  `avatar` varchar(16) default NULL,
  `msuit` varchar(16) default NULL,
  `typech` varchar(4) NOT NULL default 'nat1',
  `hypermode` tinyint(1) NOT NULL default '0',
  `growth` smallint(4) default NULL,
  `coordinates` varchar(4) NOT NULL default 'A1',
  `fame` smallint(4) NOT NULL default '0',
  `request` text NOT NULL,
  `time1` int(10) default NULL,
  `time2` int(10) default NULL,
  `btltime` int(10) default NULL,
  `acc_status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`username`)
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_log` (
  `username` varchar(16) binary NOT NULL default '',
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
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_map` (
  `map_id` varchar(4) NOT NULL default '',
  `occupied` int(10) NOT NULL default '0',
  `aname` varchar(32) NOT NULL default '',
  `development` smallint(5) NOT NULL default '0',
  `hp` int(8) unsigned NOT NULL default '0',
  `hpmax` int(8) unsigned NOT NULL default '0',
  `at` tinyint(3) unsigned NOT NULL default '0',
  `de` tinyint(3) unsigned NOT NULL default '0',
  `ta` tinyint(3) unsigned NOT NULL default '0',
  `wepa` varchar(32) NOT NULL default '',
  `spec` mediumtext NOT NULL,
  PRIMARY KEY  (`map_id`)
) ENGINE=MyISAM DEFAULT CHARSET=big5;");

mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_map` VALUES ('A1', 0, '', 0, 100000, 100000, 10, 10, 10, 'FortWepA', '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_map` VALUES ('A2', 0, '', 0, 100000, 100000, 10, 10, 10, 'FortWepA', '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_map` VALUES ('A3', 0, '', 0, 100000, 100000, 10, 10, 10, 'FortWepA', '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_map` VALUES ('B1', 0, '', 0, 200000, 200000, 25, 20, 20, 'FortWepB', '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_map` VALUES ('B2', 0, '', 0, 500000, 500000, 50, 50, 50, 'FortWepC', '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_map` VALUES ('B3', 0, '', 0, 200000, 200000, 25, 20, 20, 'FortWepB', '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_map` VALUES ('C1', 0, '', 0, 400000, 400000, 45, 40, 40, 'FortWepC', '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_map` VALUES ('C2', 0, '', 0, 200000, 200000, 25, 20, 20, 'FortWepD', '');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_map` VALUES ('C3', 0, '', 0, 350000, 350000, 40, 30, 30, 'FortWepD', '');");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_organization` (
  `id` int(10) NOT NULL default '0',
  `name` varchar(32) NOT NULL default '',
  `color` varchar(7) NOT NULL default '',
  `funds` int(10) unsigned NOT NULL default '0',
  `license` tinyint(1) NOT NULL default '0',
  `request_list` text NOT NULL,
  `groupa` varchar(32) NOT NULL default '',
  `groupb` varchar(32) NOT NULL default '',
  `groupc` varchar(32) NOT NULL default '',
  `operation` varchar(32) NOT NULL default '',
  `optmissioni` varchar(32) NOT NULL default '',
  `opttime` int(10) unsigned NOT NULL default '0',
  `optstart` int(10) unsigned NOT NULL default '0',
  `optmissiona` varchar(32) NOT NULL default '',
  `optmissionb` varchar(32) NOT NULL default '',
  `optmissionc` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM;");

mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_organization` VALUES (0, '中立組織', '#AAAAAA', 0, 0, '', '', '', '', '', '', 0, 0, '', '', '');");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_settings` (
  `username` varchar(16) binary NOT NULL default '',
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
  `filter_at_min` tinyint(3) NOT NULL default '0',
  `filter_at_max` tinyint(3) NOT NULL default '0',
  `filter_de_min` tinyint(3) NOT NULL default '0',
  `filter_de_max` tinyint(3) NOT NULL default '0',
  `filter_re_min` tinyint(3) NOT NULL default '0',
  `filter_re_max` tinyint(3) NOT NULL default '0',
  `filter_ta_min` tinyint(3) NOT NULL default '0',
  `filter_ta_max` tinyint(3) NOT NULL default '0',
  `filter_lv_min` tinyint(3) NOT NULL default '0',
  `filter_lv_max` tinyint(3) NOT NULL default '0',
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
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` (
  `username` varchar(16) NOT NULL default '',
  `time` int(10) NOT NULL default '0',
  `directions` text NOT NULL,
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
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` (
  `username` varchar(16) NOT NULL default '',
  `warehouse` text NOT NULL,
  `timelast` int(10) NOT NULL default '0',
  PRIMARY KEY  (`username`)
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_market` (
  `id` INT(15) UNSIGNED NOT NULL AUTO_INCREMENT, 
  `owner` varchar(16) NOT NULL default '',
  `price` int(10) unsigned NOT NULL default '0',
  `wepid` varchar(255) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `atk` mediumint(6) UNSIGNED DEFAULT '0' NOT NULL,
  `hit` tinyint(3) UNSIGNED DEFAULT '0' NOT NULL,
  `rd` tinyint(3) UNSIGNED DEFAULT '0' NOT NULL,
  `enc` smallint(5) unsigned NOT NULL default '0',
  `spec` text NOT NULL,
  `time` INT( 10 ) UNSIGNED DEFAULT '0' NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_marketb` (
  `id` INT(15) UNSIGNED NOT NULL AUTO_INCREMENT, 
  `owner` varchar(16) NOT NULL default '',
  `price` int(10) unsigned NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `state` tinyint(3) UNSIGNED DEFAULT '0' NOT NULL,
  `time` INT( 10 ) UNSIGNED DEFAULT '0' NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_bank_log` (
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
) ENGINE=MyISAM DEFAULT CHARSET=big5 AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_hangar` (
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
) ENGINE=MyISAM DEFAULT CHARSET=big5 AUTO_INCREMENT=1 ;");

?>
如無任何錯誤出現
<br>
資料表建立完成! 
<br>
請刪除此檔案
