<?php
//Battle Filter - Part 1: Set SQL Commands - Customized

	//Fields to be Displayed
	unset($Df,$a,$d,$S,$ColumnNum);
	$FieldDisplay = '';
	$Df = array('at<!>attacking','de<!>defending','re<!>reacting','ta<!>targeting','lv<!>level','hp<!>hp','bty<!>bounty','ms<!>msuit, ms_custom, msname','tch<!>typech, type.name as t_name');
	foreach($Df as $a){
		$d = explode('<!>',$a);
		$S = 'fdis_'.$d[0];
		if ($Pl->Player[$S]) $FieldDisplay .= ', '.$d[1];
		//if ($Pl->Player['fdis_tch']) $FieldDisplay .= ', `hypermode`, `type`.`name` as `t_name`';
	}

	//Filter Fields
	unset($F,$a,$d,$Si,$Sa);
	$CustomFilter = '';
	$F = array('at.attacking','de.defending','re.reacting','ta.targeting','lv.level','hp.hpmax','fame.fame','bty.bounty');
	foreach($F as $a){
		$d = explode('.',$a);
		$Si = 'filter_'.$d[0].'_min';
		$Sa = 'filter_'.$d[0].'_max';
		if ($Pl->Player[$Si]) $CustomFilter .= ' AND `'.$d[1].'` >= '.$Pl->Player[$Si];
		if ($Pl->Player[$Sa]) $CustomFilter .= ' AND `'.$d[1].'` <= '.$Pl->Player[$Sa];
	}
	if ($Pl->Player['filter_con'] == 1) $CustomFilter .= ' AND `time2` > '.($CFU_Time-$Offline_Time);
	elseif ($Pl->Player['filter_con'] == 2) $CustomFilter .= ' AND `time2` <= '.($CFU_Time-$Offline_Time);
	//Order filter_sort_asc
	unset($OAD);
	$OAD = ($Pl->Player['filter_sort_asc'])?'ASC':'DESC';
	switch($Pl->Player['filter_sort']){
	case 1: $CustomOrder = '`attacking` '.$OAD;break;
	case 2: $CustomOrder = '`defending` '.$OAD;break;
	case 3: $CustomOrder = '`reacting` '.$OAD;break;
	case 4: $CustomOrder = '`targeting` '.$OAD;break;
	case 5: $CustomOrder = '`level` '.$OAD;break;
	case 6: $CustomOrder = '`hp` '.$OAD;break;
	case 7: $CustomOrder = '`fame` '.$OAD;break;
	case 8: $CustomOrder = '`time2` '.$OAD;break;
	default: $CustomOrder = '`organization` '.$OAD.', `rank` ASC';break;
	}

	$SQL = "
	SELECT `gen`.`username` AS `name`, `color`, `time1`, `time2`, `coordinates`, `organization` , `fame`, `rights`, `rank`, `gamename`, `hypermode`,";
	$SQL .= " `eqwep`, `p_equip`, `hprec`, `enrec`, `hpmax`, `enmax`, `hp`, `en`, `sp`, `spmax`, `status`".$FieldDisplay.
	" FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `gen`, `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `game`";

	$SQL .= " ,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` `ms`";
	if($Pl->Player['fdis_tch'])	$SQL .= " ,`".$GLOBALS['DBPrefix']."phpeb_sys_chtype` `type`";

	$SQL .= " WHERE `gen`.`username`=`game`.`username`";

	$SQL .= " AND `ms`.`id` = `msuit`";
	if($Pl->Player['fdis_tch'])	$SQL .= " AND `type`.`id` = `typech` AND `type`.`typelv` = FLOOR( `level` / 10 ) + 1 ";

	$SQL .= " AND `gen`.`username` != '$Pl_Value[USERNAME]' AND `wepa` NOT REGEXP '^0<!>' AND `msuit` != '0' AND `coordinates` REGEXP '(".substr($Pl->Player['coordinates'],0,2).")' ";
	$SQL .= ($Pl->Player['organization'] != 0) ?  "AND (`organization` != '".$Pl->Player['organization']."') " : '';
	$SQL .= $CustomFilter." ORDER BY ".$CustomOrder;

	$Query = mysql_query ($SQL) or die ('<hr>MySQL 資料庫存取錯誤, 請聯絡GM, 錯誤代號 BTL-CF-000<br>');

?>