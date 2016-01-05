<?php
//-------------------------//-------------------------//-------------------------//
//--------------------------   Banking System Include   -------------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//

// Functions for bank.php, Banking System
// Created: 2010/01/12 4:18am
// Last Modified: 2010/01/12

//
// Mining System Plugin Functions - Need to include mining.config.php before use
//

// Plugin Mining System Function - Print Raw Material requirement list
function printRawReq($Str,$Msg){
	global $product_id_list;

	$Raw = getRaw($Str);

	if($Raw[0] == 0) return;

	echo $Msg;
	echo "<div style='width: 100%'><table align=left>";

	$i = 0;
	foreach($product_id_list As $p_id => $p_name){
		if($Raw[$p_id] == 0) continue;
		if($i == 0) echo '<tr>';
		echo "<td align=right width=60>$p_name:&nbsp;</td><td width=40>$Raw[$p_id] 個</td>";
		if($i == 1){
			echo '</tr>';
			$i = 0;
		}
		else $i++;
	}
	echo "</table></div>";

}

// Plugin Mining System Function - Print Product Textbox Table
function printProductTable($elmName){
	global $product_id_list;

	echo "<table align=center>";
	echo "<tr align=center style='font-weight: Bold'><td>原料</td><td>數量</td><td>原料</td><td>數量</td></tr>";

	$i = 0;
	foreach($product_id_list As $p_id => $p_name){
		if($i == 0) echo '<tr>';
		echo "<td align=right>$p_name</td><td><input type=text name=".$elmName.'['.$p_id.'] maxlength=3 size=4 value=0 onclick="this.value=\'\'" onchange="this.value=parseInt(this.value)"></td>';
		if($i == 1){
			echo '</tr>';
			$i = 0;
		}
		else $i++;
	}
	echo "</table>";

}

//
// Refactored Functions
//

function getInbox($sh,$sh_slot){

	$SafeIN = explode('<#>',$sh);
	$SafeIN_Wep = explode('<!>',$SafeIN[2]);

	$sql = ("SELECT `gamename`,`name`,`atk`,`hit`,`rd`,`enc`,`w`.`spec`,`equip` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `g`,`".$GLOBALS['DBPrefix']."phpeb_sys_wep` `w` WHERE `username`='". $SafeIN[0] ."' AND `id` = '". $SafeIN_Wep[0] ."'");
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
	$SafeIN_Dealer = mysql_fetch_array($query);
		if ($SafeIN_Wep[2]){
			if ($SafeIN_Wep[2]==1) $SafeIN_Dealer['name'] = $SafeIN_Wep[3].$SafeIN_Dealer['name']."<sub>&copy;</sub>";
			else $SafeIN_Dealer['name'] = $SafeIN_Dealer['name'].$SafeIN_Wep[3]."<sub>&copy;</sub>";
			$SafeIN_Dealer['atk'] += $SafeIN_Wep[4];
			$SafeIN_Dealer['hit'] += $SafeIN_Wep[5];
			$SafeIN_Dealer['rd'] += $SafeIN_Wep[6];
			$SafeIN_Dealer['enc'] = $SafeIN_Wep[7];
		}
	if ($SafeIN_Wep[1] > 0) $SafeIN_Wep['displayXp'] = '+'.($SafeIN_Wep[1]/100).'%';
	elseif ($SafeIN_Wep[1] < 0) $SafeIN_Wep['displayXp'] = ($SafeIN_Wep[1]/100).'%';
	else $SafeIN_Wep['displayXp'] = '±0%';
	echo "賣家: $SafeIN_Dealer[gamename]<br>出價: ".number_format($SafeIN[1]);
	
	printRawReq($SafeIN[5],'<br>原料 - 您需支付:<br>');
	printRawReq($SafeIN[4],'<br>原料 - 賣家支付:<br>');
	
	if($SafeIN_Wep[0]){
		echo "<br>裝備: $SafeIN_Dealer[name]<br>狀態值: $SafeIN_Wep[displayXp]<br>能力: <br>";
		echo "　攻擊力: $SafeIN_Dealer[atk]　　　回數: $SafeIN_Dealer[rd]<br>　命中: $SafeIN_Dealer[hit]　　　EN消費: $SafeIN_Dealer[enc]<br>";
		$D_Specs = ReturnSpecs($SafeIN_Dealer['spec']);
		echo "特殊效果:";
		if ($SafeIN_Dealer['equip']) echo "可以裝備<br>";
		if ($SafeIN_Dealer['spec']) echo $D_Specs;
		elseif(!$SafeIN_Dealer['spec'] && !$SafeIN_Dealer['equip']) echo "沒有任何特殊效果<br>";
	}
	else{
		echo "<br>此交易沒有涉及武裝交易。<br>";
	}

	echo "<input type=submit $disableOnFull onClick=\"return ConfirmDeal('$sh_slot')\" value=確認交易>";
	echo "<input type=submit onClick=\"return RejectDeal('$sh_slot')\" value=拒絕交易>";

}
function getOutbox($sh,$sh_slot,$user){

	$SafeOUT = explode('<#>',$sh);
	$SafeOUT_Wep = explode('<!>',$SafeOUT[2]);

	$sql = "SELECT `gamename`,`name`,`atk`,`hit`,`rd`,`enc`,`w`.`spec` AS `spec`, `equip`, `$SafeOUT[3]` AS `inbox` ";
	$sql .= " FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `g`, `".$GLOBALS['DBPrefix']."phpeb_sys_wep` `w`, `".$GLOBALS['DBPrefix']."phpeb_user_bank` `b` ";
	$sql .= " WHERE `g`.`username`='". $SafeOUT[0] ."' AND `id` = '". $SafeOUT_Wep[0] ."' AND `b`.`username` = `g`.`username`; ";
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
	$SafeOUT_Dealer = mysql_fetch_array($query);
		if (isset($SafeOUT_Wep[2])){
			if ($SafeOUT_Wep[2]==1) $SafeOUT_Dealer['name'] = $SafeOUT_Wep[3].$SafeOUT_Dealer['name']."<sub>&copy;</sub>";
			else $SafeOUT_Dealer['name'] = $SafeOUT_Dealer['name'].$SafeOUT_Wep[3]."<sub>&copy;</sub>";
			$SafeOUT_Dealer['atk'] += $SafeOUT_Wep[4];
			$SafeOUT_Dealer['hit'] += $SafeOUT_Wep[5];
			$SafeOUT_Dealer['rd'] += $SafeOUT_Wep[6];
			$SafeOUT_Dealer['enc'] = $SafeOUT_Wep[7];
		}
	if ($SafeOUT_Wep[1] > 0) $SafeOUT_Wep['displayXp'] = '+'.($SafeOUT_Wep[1]/100).'%';
	elseif ($SafeOUT_Wep[1] < 0) $SafeOUT_Wep['displayXp'] = ($SafeOUT_Wep[1]/100).'%';
	else $SafeOUT_Wep['displayXp'] = '±0%';
	echo "目標買家: $SafeOUT_Dealer[gamename]<br>售價: ".number_format($SafeOUT[1]);

	printRawReq($SafeOUT[4],'<br>原料 - 您將支付:<br>');
	printRawReq($SafeOUT[5],'<br>原料 - 對方支付:<br>');

	if($SafeOUT_Wep[0]){
		echo "<br>裝備: $SafeOUT_Dealer[name]<br>狀態值: $SafeOUT_Wep[displayXp]<br>能力: <br>";
		echo "　攻擊力: $SafeOUT_Dealer[atk]　　　回數: $SafeOUT_Dealer[rd]<br>　命中: $SafeOUT_Dealer[hit]　　　EN消費: $SafeOUT_Dealer[enc]<br>";
		$D_Specs = ReturnSpecs($SafeOUT_Dealer['spec']);
		echo "特殊效果:";
		if ($SafeOUT_Dealer['equip']) echo "可以裝備<br>";
		if ($SafeOUT_Dealer['spec']) echo $D_Specs;
		else echo "沒有任何特殊效果<br>";
	}
	else{
		echo "<br>此交易沒有涉及武裝交易。<br>";
	}

	echo "<input type=submit $disableOnFull onClick=\"return CancelDeal('$sh_slot')\" value=中止交易>";
	$RejectedFlag = false;
	if(!$SafeOUT_Dealer['inbox']) $RejectedFlag = true;
	else{
		$DealerIN = explode('<#>',$SafeOUT_Dealer['inbox']);
		if($DealerIN[0] != $user) $RejectedFlag = true;
		else{
			for($i = 1; $i < count($DealerIN); $i++){
				if($i == 3) continue;
				if($DealerIN[$i] != $SafeOUT[$i]){
					$RejectedFlag = true;
					break;
				}
			}
		}
	}
	if($RejectedFlag) echo "&nbsp;&nbsp;(對方己拒絕了交易)";

}

//Get Safehouse item (Weapon/Equipment) name, inc. customed name
function getSHWepName($Wep){
	$sql = "SELECT `name` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `id` = '$Wep[0]' LIMIT 1;";
	$query = mysql_query($sql);
	$WepS = mysql_fetch_array($query);
	if (isset($Wep[2])){
		if ($Wep[2]==1) $WepS['name'] = $Wep[3].$WepS['name']."<sub>&copy;</sub>";
		else $WepS['name'] = $WepS['name'].$Wep[3]."<sub>&copy;</sub>";
	}
	return $WepS['name'];
}

?>