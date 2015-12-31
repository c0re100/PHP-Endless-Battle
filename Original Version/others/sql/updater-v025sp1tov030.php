<?php
//----------------------------------//
//----- Database Updating Unit -----//
//----------------------------------//
//----------- Old Version ----------//
//----------------------------------//
//--- v2Alliance Official Version---//
//--------  v0.25Final SP1  --------//
//----------------------------------//
//--------- Target Version ---------//
//----------------------------------//
//--- v2Alliance Official Version---//
//-----------   v0.30   ------------//
//----------------------------------//
//----- Official Database ver6 -----//
//----------------------------------//
//-- Copyright(c) v2Alliance 2007 --//
//------- All Rights Reserved ------//
//----------------------------------//
include_once('cfu.php');
$s_name = basename($_SERVER["PHP_SELF"]);
if (isset($_POST['action']) || isset($_GET['action']))
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
else $mode = false;

if (!$mode){
	echo "<form action=".$s_name."?action=install method=post name=mainform>";
	echo "<table width=100% height=100% border=0 align=center>";
		echo "<tr><td width=100% height=100% align=center valign=center>";
			echo "<table width=50% border=1 style=\"border-collapse: collapse;font-size: 12; font-family: Arial\" bordercolor=\"#000000\">";
				echo "<tr><td>";
					echo "php-eb v0.25Final SP1 至 v0.30 資料庫更新工具";
				echo "</td></tr>";
				echo "<tr><td>";
					echo "本更新工具是給予 v0.25Final SP1 (官方版本) 更新的工具<Br>";
					echo "如果閣下之 php-eb 版本並非 v0.25Final SP1 (非SP1也不可), 請勿使用此工具！<br>";
					echo "系統所偵測到閣下 php-eb 版本資訊如下:<br>";
					if (!$cSpec) $cSpec = '<b><font color=red>沒有</font></b>';
					elseif ($cSpec == '0.25 Final') $cSpec = "<b><font color=blue>$cSpec</font></b>";
					elseif ($cSpec == '0.30') $cSpec = "<font color=green>$cSpec</font>";
					echo "　版本名稱: $cSpec<br>";
					if (!$vBdNum) $vBdNum = '沒有';
					echo "　版本修定: $vBdNum<br>";
					echo "注意: 如果你已更新 cfu.php, 上述所顯示的版本資訊會不準確(會顯示新版本的名稱)<hr width=100% align=center>";
					echo "更新前請先<b>備份資料庫</b>!!<br>";
					echo "如果你已經安裝了商場系統(<a href=\"http://forum.dai-ngai.net/viewthread.php?tid=1515&extra=page%3D1\">請參閱這裡</a>), ";
					echo "請挑選這項: <input type=checkbox name=mrkt_instd value=true>";
				echo "</td></tr><tr><td align=center>";
					echo "<input type=submit value='開始更新'>";
				echo "</td></tr>";
			echo "</table>";	
		echo "</td></tr>";
	echo "</table></form>";	
}
else{
echo "Datatable 前綴為: ".$GLOBALS['DBPrefix'];
echo "<br>更新程序進行中...<br>";

if (empty($mrkt_instd)){
mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_market` (
  `id` INT(15) UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner` VARCHAR(16) NOT NULL,
  `price` INT(10) UNSIGNED NOT NULL,
  `wepid` VARCHAR(255) NOT NULL,
  `name` varchar(40) NOT NULL,
  `atk` mediumint(6) UNSIGNED DEFAULT '0' NOT NULL,
  `hit` tinyint(3) UNSIGNED DEFAULT '0' NOT NULL,
  `rd` tinyint(3) UNSIGNED DEFAULT '0' NOT NULL,
  `enc` smallint(5) UNSIGNED DEFAULT '0' NOT NULL,
  `spec` text NOT NULL,
  `time` INT( 10 ) UNSIGNED DEFAULT '0' NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_marketb` (
  `id` INT(15) UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner` VARCHAR(16) NOT NULL,
  `price` INT(10) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `state` tinyint(3) UNSIGNED DEFAULT '0' NOT NULL,
  `time` INT( 10 ) UNSIGNED DEFAULT '0' NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;");

echo "已完成建立 商場 相關資料表！ (".$GLOBALS['DBPrefix']."phpeb_user_marketb, ".$GLOBALS['DBPrefix']."phpeb_user_market)<br>";
}
else echo "略過建立 商場 相關資料表。<br>";

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_bank_log` (
`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`time` INT( 10 ) NOT NULL ,
`user` VARCHAR( 16 ) NOT NULL ,
`g_name` VARCHAR( 32 ) NOT NULL ,
`type` TINYINT( 1 ) NOT NULL ,
`amount` INT( 10 ) UNSIGNED NOT NULL ,
`cash` INT( 10 ) UNSIGNED NOT NULL ,
`bankamt` INT( 10 ) UNSIGNED NOT NULL ,
`t_cash` INT( 10 ) UNSIGNED NOT NULL ,
`t_bankamt` INT( 10 ) UNSIGNED NOT NULL ,
`target` VARCHAR( 16 ) NOT NULL ,
`tg_name` VARCHAR( 32 ) NOT NULL ,
`safehouse` VARCHAR( 255 ) NOT NULL
) TYPE = MYISAM ;");

echo "已完成建立 銀行紀錄 資料表！ (".$GLOBALS['DBPrefix']."phpeb_user_bank_log)<br>";

mysql_query("CREATE TABLE `".$GLOBALS['DBPrefix']."phpeb_user_hangar` (
`h_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`h_user` VARCHAR( 16 ) NOT NULL ,
`h_msuit` VARCHAR( 16 ) NOT NULL ,
`h_hp` MEDIUMINT( 6 ) UNSIGNED NOT NULL ,
`h_hpmax` MEDIUMINT( 6 ) UNSIGNED NOT NULL ,
`h_en` MEDIUMINT( 6 ) UNSIGNED NOT NULL ,
`h_enmax` MEDIUMINT( 6 ) UNSIGNED NOT NULL ,
`h_ms_custom` VARCHAR( 255 ) NOT NULL ,
`h_wepa` VARCHAR( 255 ) NOT NULL ,
`h_wepb` VARCHAR( 255 ) NOT NULL ,
`h_wepc` VARCHAR( 255 ) NOT NULL ,
`h_eqwep` VARCHAR( 255 ) NOT NULL ,
`h_p_equip` VARCHAR( 255 ) NOT NULL
) TYPE = MYISAM ;");

echo "已完成建立 格納庫 資料表！ (".$GLOBALS['DBPrefix']."phpeb_user_hangar)<br>";

//--- game_info ---
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` CHANGE `sp` `sp` float( 8,5 ) UNSIGNED NOT NULL DEFAULT '0.00000';");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` CHANGE `spec` `spec` mediumtext NOT NULL;");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` CHANGE `tactics` `tactics` mediumtext NOT NULL;");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` CHANGE `victory` `victory` MEDIUMINT( 6 ) UNSIGNED NOT NULL;");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` ADD `ms_custom` VARCHAR( 255 ) NOT NULL DEFAULT '' AFTER `targeting` ;");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` ADD `p_equip` VARCHAR( 255 ) NOT NULL DEFAULT '0<!>0' AFTER `eqwep` ;");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` ADD `v_points` MEDIUMINT( 6 ) UNSIGNED NOT NULL AFTER `victory` ;");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `v_points` = `victory`;");
echo "已完成更新 玩家遊戲資訊 資料表！ (".$GLOBALS['DBPrefix']."phpeb_user_game_info)<br>";
echo "　- 更新資料包括: SP 浮點值, Special Abilities和Tactics 紀錄方式, 加入ms_custom,p_equip,v_points欄位, 更新v_points<br>";

//--- Weapons ---
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `name` = 'T-Link Knuckle' WHERE `id` = '216';");
echo "更改 武器 Id:216 名稱為「T-Link Knuckle」完成<br>";
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `atk` = '1000', `hit` = '95', `enc` = '25', `price` = '100000' WHERE `id` = '701';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `atk` = '1100', `hit` = '95', `enc` = '35', `price` = '110000' WHERE `id` = '702';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `atk` = '1200', `hit` = '96', `enc` = '45', `price` = '120000' WHERE `id` = '703';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `atk` = '1300', `hit` = '96', `enc` = '65', `price` = '130000' WHERE `id` = '704';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `atk` = '1400', `hit` = '97', `enc` = '75', `price` = '140000' WHERE `id` = '705';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `atk` = '1500', `hit` = '97', `enc` = '90', `price` = '150000' WHERE `id` = '706';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `atk` = '1600', `hit` = '100', `enc` = '110', `price` = '160000' WHERE `id` = '707';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `atk` = '1800', `hit` = '100', `enc` = '140', `price` = '170000' WHERE `id` = '708';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `price` = '120000' WHERE `id` = '711';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `price` = '135000' WHERE `id` = '712';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `price` = '180000' WHERE `id` = '715';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `price` = '225000' WHERE `id` = '718';");
echo "更改 武器 Id: 7系列 能力及設定完成<br>";

mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `enc` = '0', `price` = '500000', `spec` = 'AntiDam' WHERE `id` = '828';");
echo "更改 武器 Id: 828 能力設定完成<br>";
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `spec` = 'NTCustom,DamA,DamB,MeltA,AntiPDef,CostSP<50>' WHERE `id` = '901';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `hit` = '110' WHERE `id` = '971';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `atk` = '1055', `hit` = '105' WHERE `id` = '991';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `hit` = '86' WHERE `id` = '99001';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `hit` = '120', `spec` = 'NTCustom,Cease,CostSP<12>' WHERE `id` = '996';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `hit` = '130', `spec` = 'NTCustom,Cease,CostSP<15>' WHERE `id` = '997';");
echo "更改 武器 Id: 部份9系列 能力設定完成<br>";
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `price` = '500000' WHERE `id` = 'FortWepA';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `price` = '5500000' WHERE `id` = 'FortWepB';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `price` = '15000000' WHERE `id` = 'FortWepC';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `price` = '155000000' WHERE `id` = 'FortWepD';");
echo "更改 要賽武器價錢, 完成<br>";
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('90002', 'Super DRAGOON', 13, 'N', '0', '', '', 320, 125, 16, 800, 36500000, 0, 'COCustom,AntiPDef,MeltA,');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('969', '新高達尼姆合金', 0, 'N', '0', '', '', 0, 0, 0, 0, 250000, 0, 'RawMaterials');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` VALUES ('96001', 'EXAM System', 0, 'N', '0', '', '', 0, 0, 0, 30, 1100000, 2, 'EXAMSystem, MobA, TarA, AtkA');");
echo "加入 ID: 90002, 969, 96001 新武器完成<br>";
echo "資料表 玩家武器資訊 (".$GLOBALS['DBPrefix']."phpeb_sys_wep) 更改完成！<br>";

//--- tactfactory - system ---
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('71', '96001', '6', 'EXAM System<br> 這一天你又來到了工程師公會，發現了一大堆學者正認真地打量著一部殘缺不堪的MS。<br> 為滿足你的好奇心，你走上前去，試圖從聽學者們的話中打聽這部MS的來歷。<br> <br> 「這部以藍色為主要色系的機體是.....﹖」<br> 「你這新來的﹗這就是那不分敵我都胡亂攻擊的\"惡魔\"啊﹗」<br> 「嗯...那時他展現的非凡破壞力...簡直叫我心寒.....」<br> 「不只是破壞力，就是回避力，命中率都較一般MS要高呢﹗」<br> 「那為什麼會落得如此下場?」<br> 「因為那個系統強行把出力提高,使機體都負擔不了......」<br> 「聽說連駕駛者...都被弄得神志不清呢...」<br> 「難道...這就是傳說中裝備了EXAM System的\"Blue Destiny\"﹗﹖」<br> 「讓我把系統給電腦掃一下......」<br> <br> 「Multi-Sensor、Dual Sensor、Multi-Sensor、Dual Sensor、Multi-Sensor、Dual Sensor、水晶、黃金、水晶、黃金」<br> <br> 正當你幻想著自己的機體裝備EXAM System後力量是何其強大的同時，<br> 你突然感到自己後領被一道何其強大的力量拉扯，就這樣被一個警衛提出公會門外﹕<br> <br> 「你在這裏幹啥﹖難道你是敵國派來的間諜﹖」<br> <br> 為保自己的清白，你連忙向他解釋﹕<br> <br> 「嗯......是這樣的......」<br>', '912', '811', '912', '811', '912', '811', '718', '715', '718', '715', NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL );");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('72', '90002', '10', '你目睹了一場爭執﹕<br> <br> 「像你這 Coordinator 有什麼厲害，還不及我們這些Newtype﹗」一個男人以食指指向一個戴著面具的男人。<br> 「你只是人造的產物而已﹗」又一個男人指著那個戴著面具的男人。<br> 「我們Newtype能使用浮游炮，你呢﹖」再一個男人指向那個戴著面具的男人。<br> 「啪﹗」在千夫所指下，那戴著面具的男人終於沉不著氣，一掌打在桌上﹕<br> 「你們這些沒見識的人，有沒有聽過Super DRAGOON? 就是我們Coordinator專用的武器，能力更在浮游炮之上！」<br> 「那麼Super DRAGOON又是怎樣鑄造的﹖」你心裏好奇地問。<br> 那戴著面具的男人回過頭來，瞥了你一眼，遞了一張字條﹕<br> <br> 面具男的保證鑄造法----Super DRAGOON<br> <br> 一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;飛翔炮<br> 二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Newtype系統對應有線式光束炮<br> 三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bit<br> 四號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bit<br> 五號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br> 六號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br> 七號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br> 八號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高能光束步槍<br> 九號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br> 十號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水晶<br> 十一號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br> 十二號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br> 十三號爐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;黃金<br> <br> 雖然你很奇怪為什麼那戴著面具的男人知道你在想什麼，<br> 但不管怎樣，你幸運地獲得了鑄造Super DRAGOON的方法。<br>', '997', '620', '971', '971', '405', '405', '405', '405', '718', '718', '715', '715', '715', NULL , NULL , NULL , NULL , NULL , NULL , NULL );");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` VALUES ('73', '969', '6', '新高達尼姆合金<br> 這一天你又來到了工程師公會，看到一名工程師，埋頭苦幹，拿著鋼筆寫字。<br> 他一面寫，一面就哼唱著小調。<br> 突然，他回頭一望，便對你笑說：「這歌詞你一定會很喜歡！」<br> 然後，他便迅速取去你手上那箱鈔票，逃去無蹤了。<br> _______________________________________________________<br> 您想變強嗎?<br> 作曲、編曲﹕我　　　　　填詞﹕冷月無聲<br> 小修﹕　　　栩月　　　　製作﹕風之翎<br> <br> 經歷了長久的努力和付出後<br> 得到了心目中的神兵利器<br> 又把它用得滾爪爛熟之際....<br> <br> 卻發現，發現了您敵人所擁有的<br> 並不比您的弱，甚至更勝於您<br> 更對您咄咄相逼,使您無力招架<br> <br> 您有感到自己的力量不足嗎?<br> 您有感到自己所付出的已諸東流嗎?<br> 您有想過令自己的武器與機體<br> 按照自己的思想作出強化與進步嗎??<br> <br> Repeat *<br> 既然您付了錢,當然不會讓您感到灰心<br> 請您緊記以下之物的制作配方<br> 一三七青銅 四五鋼鐵<br> 二六十黃金 八九水晶<br> 它!能令你變強!!<br> <br> 它!能令你更進一步地變強!!<br> _______________________________________________________<br> 「有種被騙的感覺。。」你心想著。<br>', '711', '715', '711', '712', '712', '715', '711', '718', '718', '715', NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL );");
echo "加入合成方法 ID: 71至73 完成<br>";

//--- tactfactory - user ---
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` CHANGE `directions` `directions` text NOT NULL;");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` CHANGE `c_point` `c_point` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0';");
echo "更改 玩家兵器製造工場 資料表 (".$GLOBALS['DBPrefix']."phpeb_user_tactfactory) 完成！ 內容包括: directions,c_point Datatype<br>";

//--- user map ---
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_map` CHANGE `hp` `hp` INT( 8 ) UNSIGNED NOT NULL DEFAULT '0';");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_map` CHANGE `hpmax` `hpmax` INT( 8 ) UNSIGNED NOT NULL DEFAULT '0';");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_map` CHANGE `at` `at` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0';");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_map` CHANGE `de` `de` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0';");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_map` CHANGE `ta` `ta` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0';");
mysql_query("ALTER TABLE `".$GLOBALS['DBPrefix']."phpeb_user_map` CHANGE `spec` `spec` mediumtext NOT NULL;");
echo "更改 玩家地區資料 資料表 (".$GLOBALS['DBPrefix']."phpeb_user_map) 完成！ 內容包括: hp,hpmax,at,de,ta,spec 之 Datatype<br>";

//--- MS ---
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_ms` SET `needlv` = 20 WHERE `id` = '3';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_ms` SET `needlv` = 16 WHERE `id` = '5';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_ms` SET `needlv` = 5 WHERE `id` = '44';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_ms` SET `spec` = 'EXAMSystem,' WHERE `id` = '49';");
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_ms` SET `price` = 4800000, `def` = 10, `ref` = 15, `taf` = 13, `hpfix` = 4500, `hprec` = 37.189, `spec` = 'EXAMSystem,', `needlv` = 40 WHERE `id` = '50';");
echo "更新 機體ID: 3,5,44,49,50 設定值, 完成！<br>";
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('61', 'GM Cannon II', 1050000, 7, 8, 6, 7, 3300, 155, 26.720, 2.460, '', 12, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('60', 'Masarai', 560000, 4, 4, 4, 4, 3000, 100, 24.000, 1.538, '', 8, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('62', 'GunTank', 625000, 6, 6, 2, 4, 3500, 150, 26.900, 2.459, '', 8, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('63', 'Asshimar', 685000, 8, 4, 7, 4, 3100, 125, 25.000, 2.016, '', 12, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('64', 'FA Alex', 2150000, 6, 10, 7, 8, 4500, 175, 35.156, 2.822, '', 20, 'none.gif');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` VALUES ('65', 'Gundam Mk-II', 2750000, 12, 7, 10, 13, 4200, 235, 33.600, 3.507, '', 25, 'none.gif');");
echo "加入新機體 ID: 61至65, 完成<br>";
echo "更改 系統機體資料表 (".$GLOBALS['DBPrefix']."phpeb_sys_ms) 完成！<br>";

//--- Tactics ---
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('CounterStrike', '伺機反擊', 0, 0, 45, 0, 0, 0, 0, 20, 0, 12000000, 85, 'CounterStrike');");
mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` VALUES ('FirstStrike', '先制攻擊', 0, 30, 45, 0, 0, 5, -5, 0, 0, 12000000, 85, 'FirstStrike');");
echo "加入新戰術 ID: CounterStrike與FirstStrike, 完成<br>";
echo "更改 系統戰術資料表 (".$GLOBALS['DBPrefix']."phpeb_sys_tactics) 完成！<br>";
echo "<hr>所有頂目更新完成！<br>請自行<b>刪除這個檔案</b>！以免發生無法預計的錯誤！";
}

?>