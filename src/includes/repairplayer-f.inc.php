<?php
//-------------------------//-------------------------//-------------------------//
//----------------------   RepairPlayer Function Include   ----------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//

//Requires Collaborate Use with sfo.class.php (php-eb UE Game Statistics Fetcher Object)

//Start Repair Player Function
function RepairPlayer($Player,$EqD=false,$EqE=false,$FetchEq=false,$MS=false,$Update=false){

$Eq = array('D' => $EqD, 'E' => $EqE);

$Player['msuit'] = (isset($Player['msuit'])) ? $Player['msuit'] : false;

$Var = array("hp" => $Player['hp'],"en" => $Player['en'],"sp" => $Player['sp'],"status" => $Player['status'],"time1" => $Player['time1'],"msuit" => $Player['msuit']);

$Use_Time = time();

if (!$Player['status'] && $Player['hp'] >= $Player['hpmax'] && $Player['sp'] >= $Player['spmax'] && $Player['en'] >= $Player['enmax']){
	$Var['time1'] = $Use_Time;
	return $Var;
}
else {
	$Time_Difference=$Use_Time-$Var['time1'];
	if(!$MS){
		$SQL = ("SELECT `hprec`,`enrec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE id='". $Var['msuit'] ."'");
		$Query = mysql_query($SQL);
		$MS = mysql_fetch_array($Query);
	}
	
	$Var['hp'] += $Time_Difference * ($GLOBALS['HP_BASE_RECOVERY']*$Player['hpmax']);
	
	if ($MS['hprec'] >= 1){$Var['hp'] += $Time_Difference*$MS['hprec'];}//Constant HP Recovery
	if ($MS['hprec'] < 1 && $MS['hprec'] >= 0.0001){$Var['hp'] += $Time_Difference*($MS['hprec']*$Player['hpmax']);}//Percentage HP Recovery

	if ($MS['enrec'] >= 1){$Var['en'] += $Time_Difference*$MS['enrec'];}//Constant EN Recovery
	if ($MS['enrec'] < 1 && $MS['enrec'] >= 0.0001){$Var['en'] += $Time_Difference*($MS['enrec']*$Player['enmax']);}//Percentage EN Recovery


	$HP_Flag = $ENA_Flag = $ENB_Flag = 0;

	if($FetchEq){
		$Eq_D = explode('<!>',$Player['eqwep']);
		$Eq_E = explode('<!>',$Player['p_equip']);
		$SQL = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id = '". $Eq_D[0] ."' || id = '". $Eq_E[0] ."' Limit 2;");
		$Query = mysql_query($SQL) or die ('<hr>MySQL 資料庫存取錯誤, 請聯絡GM, 錯誤代號 RPF-000<br>');
		$Eq['D'] = mysql_fetch_array($Query);
		if(mysql_num_rows($Query) == 2) $Eq['E'] = mysql_fetch_array($Query);
		else $Eq['E'] = $Eq['D'];
	}

	foreach($Eq as $v){
		if ($v['spec']){
			if (strpos($v['spec'],'HPPcRecA') !== false)	$HP_Flag++;
			if (strpos($v['spec'],'ENPcRecB') !== false)	$ENB_Flag++;
			elseif (strpos($v['spec'],'ENPcRecA') !== false)	$ENA_Flag++;
		}
	}

	$Var['hp'] += $Time_Difference*(0.005*$Player['hpmax'])*$HP_Flag;
	$Var['en'] += $Time_Difference*(0.0075*$Player['enmax'])*$ENA_Flag;
	$Var['en'] += $Time_Difference*(0.015*$Player['enmax'])*$ENB_Flag;

	$SP_RecSpd = $Time_Difference * (0.004*$Player['spmax']);
	if ($Player['hypermode'] == 2 || $Player['hypermode'] == 6) $SP_RecSpd *= 2;
	$Var['sp'] += $SP_RecSpd;
	
	if ($Var['hp'] >= $Player['hpmax']){$Var['status'] = 0;$Var['hp'] = $Player['hpmax'];}
	if ($Var['en'] > $Player['enmax']) $Var['en'] = $Player['enmax'];
	if ($Var['sp'] > $Player['spmax']) $Var['sp'] = $Player['spmax'];

	$Var['time1'] = $Use_Time;
	
	if($Update && $Time_Difference >= 3){
		if($Var["hp"] != $Player['hp'] || $Var["en"] != $Player['en'] || $Var["sp"] != $Player['sp'] || $Var["status"] != $Player['status']){
			$SQL = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hp` = '".$Var['hp']."', `en` = '".$Var['en']."' ,`sp` = '".$Var['sp']."', `status` = '".$Var['status']."' WHERE `username` = '".$Player['name']."' LIMIT 1;");
			mysql_query($SQL) or die ('<hr>MySQL 資料庫更新錯誤, 請聯絡GM, 錯誤代號 RPF-001<br>');
			$SQL = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `time1` = '".$Use_Time."' WHERE `username` = '".$Player['name']."' LIMIT 1;");
			mysql_query($SQL) or die ('<hr>MySQL 資料庫更新錯誤, 請聯絡GM, 錯誤代號 RPF-002<br>');
		}
	}

	Return $Var;
}//End Repairing Clause

}//End Repair Player Function
?>