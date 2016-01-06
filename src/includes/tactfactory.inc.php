<?php
//-------------------------//-------------------------//-------------------------//
//-----------------------   Tactfactory System Include   ------------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//

// Functions for tactfactory.php, Main Tactfactory System
// Created: 2010/01/12 14:18
// Last Modified: 2010/01/12

//
// Refactored Functions
//

function getWeaponName($id, $getSpec = false){
	$sql = "SELECT `name` ".(($getSpec) ? ', `spec`' : '')." FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `id` = '$id' Limit 1;";
	$query = mysql_query($sql);
	$SysWep = mysql_fetch_array($query);
	if(!$getSpec) return $SysWep['name'];
	else return $SysWep;
}

function printPutOption($UsrWep,$Pos){
	$PosName = ( $Pos == 'b' ) ? '一' : '二';
	$WpInf = getWeaponName($UsrWep[0],true);

	echo "<tr><td width=350><b>備用裝備$PosName:</b><font style=\"font-size: 10pt\"><br>".$WpInf['name'];
	if ($UsrWep[1]) echo "<br>(狀態值: ".($UsrWep[1]/100)."%)";
	echo "</font></td><td width=50 align=center>";
	$UsrWep[2] = (isset($UsrWep[2])) ? $UsrWep[2] : 0;
	if ($UsrWep[0] && !$UsrWep[2] && $UsrWep[1] >= $GLOBALS['RepairEqCondMax'])
		echo "<input type=button name='put$Pos' value='置放' onClick=\"actionb.value='put';actionc.value='wep$Pos';mainform.submit()\">";
	if (strpos($WpInf['spec'],'Blueprint') !== false){
		echo "<input type=button name='view$Pos' value='檢視' onClick=\"actionb.value='view';actionc.value='wep$Pos';mainform.submit()\">";		
	}
	else echo "&nbsp;";
	echo "</td></tr>";

}

function printBinDetails($binNumber){
	global $TactFactory;
	$bin = 'm'.$binNumber;
	if ($TactFactory[$bin]){
		echo "<td width=260>".getWeaponName($TactFactory[$bin])."</td>";
		echo "<td width=50><input type=button name='reclaim$binNumber' value='回收' onClick=\"actionb.value='reclaim';actionc.value='$bin';mainform.submit()\"></td>";
	}
	else echo "<td width=300 colspan=2 align=center style=\"font-size: 8pt\">此格沒有置放任何原料</td>";
}

function printBPTable($Bin, $pIdList){
	//$Bin: 1 Based Array, 21 should be Raw Materials
	$format =  "<tr><td style='width: 5%%;'>%d:</td><td style='width: 45%%; text-align: center;'>%s</td><td style='width: 5%%;'>%d:</td><td style='width: 45%%; text-align: center;'>%s</td></tr>";
	$formatb =  "<tr><td style='width: 45%%; text-align: center;' colspan=2>%s</td><td style='width: 45%%; text-align: center;' colspan=2>%s</td></tr>";
	echo "<table style='width: 75%; text-align: center;' align=center>";
	echo "<tr><td colspan=4 style='font-weight: Bold;'>藍圖:</td></tr>";
	for($i = 1; $i <= 10; $i++){
		$a = ($Bin[$i]) ? getWeaponName($Bin[$i]) : '沒有';
		$b = ($Bin[$i + 10]) ? getWeaponName($Bin[$i + 10]) : '沒有';
		printf($format, $i, $a, ($i + 10), $b);
	}
	echo "<tr><td colspan=4 style='font-weight: Bold;'>原料: </td></tr>";
	$raws = getRaw($Bin[21]);
	for($i = 1; $i <= 4; $i++){
		$a = $pIdList[$i]. ": " . $raws[$i];
		$b = $pIdList[$i + 4]. ": " . $raws[$i + 4];
		printf($formatb, $a, $b);
	}
	echo "</table>";
}

?>