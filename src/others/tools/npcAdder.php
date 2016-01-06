<?php

// Tact Adder: 
// For v0.50 Version

// Activate Program
// Turn this on (set to true) or delete this file when not using!!
// 不使用時, 記得設定為「True」 或 刪除這個檔案!!
$UseAuth = false;
$Script_Name = 'npcAdder.php';
include('../../cfu.php');
postHead('','../../phpeb_session_dir');
mt_srand ((double) microtime()*1000000);

$mode = ( isset($_POST['action']) ) ? $_POST['action'] : '';

//
// Login and authentications
//

if($UseAuth){

	exit;

}
//
// Start Program
//


?>

</head>
<body>

<?php

if($mode == 'process'){
	
	$sql = "SELECT COUNT(*) FROM ".$GLOBALS['DBPrefix']."phpeb_user_general_info WHERE regkey = 'npc'; ";
	$query = mysql_query($sql);
	
	list($count) = mysql_fetch_row($query);
	
	$tLevel = intval($tLevel);
	$amount = intval($amount);
	
	if($tLevel < 1) $tLevel = 1;
	elseif($tLevel > 150) $tLevel = 150;
	if($amount < 1) $amount = 1;
	elseif($amount > 20) $amount = 20;
	
	$sql = "SELECT `id` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE needlv < $tLevel AND needlv > $tLevel - 30 AND `id` != '0';";
	$query = mysql_query($sql);
	
	$countMS = 0;
	$MsList = array();
	while(list($tempId) = mysql_fetch_row($query)){
		$MsList[] = $tempId;
		$countMS++;
	}
	
	$TypeList = array('nat', 'ext', 'enh', 'nat', 'ext', 'enh', 'enh', 'psy', 'nt', 'co');

	function randCoord($Lv){
		$CoordinatesSt = '';
		if($Lv < 50) $pos = mt_rand(0,2);
		elseif($Lv < 100) $pos = mt_rand(3,5);
		else $pos = mt_rand(6,8);
		switch($pos){
			case 0: $CoordinatesSt='A1';break;
			case 1: $CoordinatesSt='A2';break;
			case 2: $CoordinatesSt='A3';break;
			case 3: $CoordinatesSt='B1';break;
			case 4: $CoordinatesSt='B2';break;
			case 5: $CoordinatesSt='B3';break;
			case 6: $CoordinatesSt='C1';break;
			case 7: $CoordinatesSt='C2';break;
			case 8: $CoordinatesSt='C3';break;
			default : $CoordinatesSt='A1';break;
		}
		switch(mt_rand(0,3)){
			case 0: $CoordinatesSt .= 'N';break;
			case 1: $CoordinatesSt .= 'E';break;
			case 2: $CoordinatesSt .= 'S';break;
			default: $CoordinatesSt .= 'W';break;
		}
		return $CoordinatesSt;
	}
	
	$tTier = floor($tLevel / 15);
	if($tTier > 6) $tTier = 6;
	
	if($tTier > 0)
		$sql = "SELECT `id`,`spec`,`equip` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `tier` = $tTier AND `id` != '0'; ";
	else
		$sql = "SELECT `id`,`spec`,`equip` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `buy` = 1 AND `equip` = '0'; ";
	$query = mysql_query($sql);
	$Wep = array();

	$i = 0;
	while( $liWep = mysql_fetch_array($query) ){
		if(!canEquipAsWep($liWep)) continue;
		$Wep[$i] = $liWep['id'];
		$i++;
		unset($id);
	}
	unset($id);

	function getHpModifier($Lv){
		if($Lv < 50) return 300;
		elseif($Lv < 100) return 400;
		else return 500;
	}

	function tacticsChoose($Lv){
		if($Lv < 50) return '';
		elseif($Lv < 100) return "StrikeB\nSnipeA\nQuickA\nDefCounterA\nDoubleStrike";
		else return "TripleStrike\nRaidStrike\nMindStrike\nSenseStrike\nCounterStrike\nFirstStrike";
	}

	$sqlStack = array();

	for($i = 0; $i < $amount; $i++){
		
		$usrName = 'NPC-' . ($count + $i);
		$GenItm = array();// color, ms, type, coord
		$GameItm = array();// gamename0, attacking1, defending2, reacting3, targeting4, level5, hp6, hpmax7, en8, enmax9, sp10, spmax11, wepa12, rank13, tactics14
		
		$GenItm[0] = $MainColors[mt_rand(0,(count($MainColors) - 1))];
		$GenItm[1] = $MsList[mt_rand(0, ($countMS - 1))];
		$GenItm[2] = $TypeList[mt_rand(0, 9)];
		$GenItm[3] = randCoord($tLevel);
		
		$GameItm[0] = $usrName;
		$statList = array('attacking', 'defending', 'reacting', 'targeting');
		shuffle($statList);
		$Stat = array('attacking' => 0, 'defending' => 0, 'reacting' => 0, 'targeting' => 0);

		$Ability = array();
		$Ability[0] = array($tLevel - 5, $tLevel + 10);
		$Ability[1] = array( floor($tLevel * 0.75) - 5, floor($tLevel * 0.75) + 10);
		$Ability[2] = array( floor($tLevel * 0.45) - 5, floor($tLevel * 0.45) + 10);
		$Ability[3] = array( floor($tLevel * 0.20) - 5, floor($tLevel * 0.20) + 10);

		for($j = 0; $j < 4; $j++){
			$Stat[$statList[$j]] = mt_rand($Ability[$j][0], $Ability[$j][1]);
		}

		$GameItm[1] = $Stat['attacking'];
		$GameItm[2] = $Stat['defending'];
		$GameItm[3] = $Stat['reacting'];
		$GameItm[4] = $Stat['targeting'];
		$GameItm[5] = $tLevel;
		$GameItm[6] = $tLevel * getHpModifier($tLevel);
		$GameItm[7] = $GameItm[6];
		$GameItm[8] = $tLevel * getHpModifier($tLevel) * 0.1;
		$GameItm[9] = $GameItm[8];
		$GameItm[10] = ceil($tLevel * 1.5);
		$GameItm[11] = $GameItm[10];
		$GameItm[12] = $Wep[mt_rand(0,(count($Wep)-1))].'<!>'.mt_rand(10000,25000);
		$GameItm[13] = $tLevel * 1000;
		$GameItm[14] = tacticsChoose($tLevel);

		//Enter General Info
		$GenStr = "INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_general_info (username, password, regkey, cash, color, avatar, msuit, typech, growth, time1, time2, btltime, coordinates)";
		//Enter Game Info
		$GameStr = "INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_game_info (username, gamename, attacking, defending, reacting, targeting, level, hp, hpmax, en, enmax, sp, spmax, wepa, rank, tactics)";
		//Enter Settings
		$SettingsStr = "INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_settings (username) ";
		//Enter Log
		$LogStr = "INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_log (username, log1, time1) ";
		//Enter Bank
		$BankStr = "INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank` (username) ";

		$genFormat = "$GenStr VALUES('$usrName',md5('$password'),'npc','0','%s','nil','%s','%s','0','0' ,'0' ,0 ,'%s');";
		$gameFormat = "$GameStr VALUES('$usrName','%s','%s','%s','%s','%s' ,'%s','%s','%s','%s','%s' ,'%s','%s','%s','%s','%s');";
		$SettingsFormat = "$SettingsStr VALUES('$usrName');";
		$LogFormat = "$LogStr VALUES('$usrName','',UNIX_TIMESTAMP());";
		$BankFormat = "$BankStr VALUES('$usrName');";

		$sqlStack[] = vsprintf($genFormat,$GenItm);
		$sqlStack[] = vsprintf($gameFormat,$GameItm);
		$sqlStack[] = $SettingsFormat;
		$sqlStack[] = $LogFormat;
		$sqlStack[] = $BankFormat;

	}
	
	echo "<textarea style='width:100%; height: 400px; font-size: 10pt; font-family: Arial;'>";
	foreach($sqlStack as $sql){
		echo $sql."\n";
		mysql_query($sql) or die(mysql_error()."\n");
	}
	echo "</textarea>";


}

echo "<form action=$Script_Name method=post name=main>";
echo "<input type=hidden value='process' name=action>";;
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

?>


等級: <input type=text name='tLevel'><br>
密碼: <input type=text name='password'><br>
數量: <input type=text name='amount'><br>
<input type=submit value='Submit'>







</form>

<?php


postFooter();
echo "</body>";

?>