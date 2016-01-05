<?php
//-------------------------//-------------------------//-------------------------//
//-----------------------   Secondary Function Include   ------------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//

function GetTactics($TactId='0',$Selection = '*'){
	$sql = ("SELECT $Selection FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` WHERE id='". $TactId ."'");
	$query_r = mysql_query($sql) or die('無法取得戰術資訊！');
	if(mysql_num_rows($query_r) < 1) return false;
	return mysql_fetch_array($query_r);
}

function WriteHistory($Con){
	global $iChatInstalled, $iChatConfig, $CFU_Time;
	include($iChatConfig);
	$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_game_history` (`time`, `history`) VALUES (UNIX_TIMESTAMP(), '$Con');");
	mysql_query($sql);
	if($iChatInstalled){
		$sql = 'INSERT INTO `'.$DBPrefix.$iChatTable.'` '
			. '(ic_user, ic_time, ic_message, ic_type, ic_target)'
			. sprintf('VALUES (\'%s\', %d, \'%s\', %d, \'%s\')','歷史事件',$CFU_Time,'',5,0);
		mysql_query($sql);
	}
}

function GetUsrLog($username){
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_log` WHERE username='". $username ."'");
	$query = mysql_query($sql) or die ('無法取得紀錄資訊, 原因:' . mysql_error() . '<br>');
	$Results = mysql_fetch_array($query);
	return $Results;
}

function GetChType($Chtypeinput, $Level){
	$TypeRank = floor($Level/10) + 1;
	if($TypeRank > 16) $TypeRank = 16;
	elseif($TypeRank < 1) $TypeRank = 1;

	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` WHERE `id` = '". $Chtypeinput ."' AND `typelv` = $TypeRank;");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	$Assigned = mysql_fetch_array($query);
	return $Assigned;
}

function ReturnOrg($Org){
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE id='". $Org ."'");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	return mysql_fetch_array($query);
}

function canEquipAsWep($Eq, $allowAsEq = false){
	if($Eq['equip'] == 2 && !$allowAsEq) return false;
	elseif(strpos($Eq['spec'],'Blueprint') !== false) return false;
	elseif(strpos($Eq['spec'],'CannotEquip') !== false) return false;
	elseif(strpos($Eq['spec'],'FortressOnly') !== false) return false;
	elseif(strpos($Eq['spec'],'RawMaterials') !== false) return false;
	else return true;
}

function printTHR($width = '80%'){
	echo sprintTHR();
}
function sprintTHR($width = '80%'){
	return "<div style=\"width: 100%; height: 1em; text-align: center;\" valign=center><img src=\"{$GLOBALS[Base_Image_Dir]}/hRule.gif\" style=\"width: $width\"></div>";
}

//Start Get Map Functions
	function ReturnMType($Type){
		switch($Type){
			case 0: $ReturnType = '地面';break;
			case 1: $ReturnType = '水中';break;
			case 2: $ReturnType = '空中';break;
			case 3: $ReturnType = '宇宙';break;
			case 4: $ReturnType = '殖民星';break;
			case 5: $ReturnType = '月面';break;
		}return $ReturnType;
	}
	function ReturnMBg($Type){
		switch($Type){
			case 0: $ReturnType = '/background/earth/';break;
			case 1: $ReturnType = '/background/underwater/';break;
			case 2: $ReturnType = '/background/skies/';break;
			case 3: $ReturnType = '/background/universe/';break;
			case 4: $ReturnType = '/background/colony/';break;
			case 5: $ReturnType = '/background/moon/';break;
		}return $ReturnType;
	}
	function ReturnMap($MapID){

		$sqls = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_map` WHERE map_id='". $MapID ."'");
		$querys = mysql_query($sqls) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
		$Sys = mysql_fetch_array($querys);

		$sqlu = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE map_id='". $MapID ."'");
		$queryu = mysql_query($sqlu) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
		$User = mysql_fetch_array($queryu);

		return Array("Sys" => $Sys, "User" => $User);
	}
//End Get Map Functions

//Start Status Point Calculation
function CalcStatPt($Prefix,$Lv_N){
	$Stat_Gain=3;
	for($Lv=1;$Lv<=$Lv_N;$Lv++){
		if ($Lv%5 == 0)$Stat_Gain++;
		}
	$AssignmentStat_Gain ="$Prefix".'_Stat_Gain';
	global $$AssignmentStat_Gain;
	$$AssignmentStat_Gain=$Stat_Gain;
	}//EndGain
function CalcStatReq($Prefix,$Stat_N){//Req
	$Stat_Req=2;
	for($Stat=1;$Stat<=$Stat_N;$Stat++){
		if (($Stat-1)%10 == 0 && $Stat>1)$Stat_Req++;
		}
	$AssignmentStat_Req ="$Prefix".'_Stat_Req';
	global $$AssignmentStat_Req;
	$$AssignmentStat_Req=$Stat_Req;

}//End Stat Point Function

//Start Calc Exp Functions
function CalcExp ($NowLv=1,$AssignVar='UserNextLvExp',$ShowFlag=false){
	if (!$ShowFlag){
		$Lv=$NowLv + 1;
		global $$AssignVar;
		$$AssignVar = floor((4*pow($Lv,3) - 5.34*pow($Lv,2) - 41.5*$Lv) + 161);
	}
	
	else{
		echo "<table border=0>";
		$sum = 0;
		echo "<tr align=center><td width=100>Level</td><td width=100>Exp</td><td width=100>Total</td></tr>";
		for($i = 1; $i < 150; $i++){
			$Lv = $i + 1;
			$exp = floor((4*pow($Lv,3) - 5.34*pow($Lv,2) - 41.5*$Lv) + 161);
			$sum += $exp;
			printf("<tr align=center><td>%d -> %d</td><td>%s</td><td>%s</td></tr>",$i,$Lv,number_format($exp),number_format($sum));
		}
		echo "</table>";
	}
}

?>