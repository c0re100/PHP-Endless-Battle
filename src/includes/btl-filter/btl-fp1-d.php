<?php
//Battle Filter - Part 1: Set SQL Commands - Default

	switch(mt_rand(1,2)){
		case 1: $torder = 'ASC';break;
		case 2: $torder = 'DESC';break;
	}

	$ColumnNum = 7;

	$SQL = "
	SELECT `gen`.`username` AS `name`, `color`, `msuit`, `time1`, `time2`, `coordinates`, `organization` , `hypermode`, `fame`,
	rights, rank, gamename, level, ms_custom, msname, `hpmax`, `enmax`, `hp`, `en`, `hprec`, `enrec`, `sp`, `spmax`, `status`, `eqwep`, `p_equip`,
	`type`.`name` as `t_name`
	FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `gen`, `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `game` , `".$GLOBALS['DBPrefix']."phpeb_sys_ms` `ms`, `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` `type`
	WHERE `gen`.`username`=`game`.`username` AND `ms`.`id` = `msuit` AND `type`.`id` = `typech` AND `type`.`typelv` = FLOOR( `level` / 10 ) + 1
	AND `gen`.`username` != '$Pl_Value[USERNAME]'
	AND `wepa` NOT REGEXP '^0<!>' AND `msuit` != '0' AND `coordinates` REGEXP '(".substr($Pl->Player['coordinates'],0,2).")' ";

	$SQL .= ($Pl->Player['organization'] != 0) ?  "AND (`organization` != '".$Pl->Player['organization']."') " : '';
	$SQL .= "ORDER BY `organization` DESC, `time2`  $torder,`rank` ASC";

	unset($torder);

	$Query = mysql_query ($SQL) or die ('<hr>MySQL 資料庫存取錯誤, 請聯絡GM, 錯誤代號 BTL-DF-000<br>');
?>