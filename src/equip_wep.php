<?php
	//Define Undefined Variables
	$AvailEvFlag = $AvailSevFlag = $CEqOpt = false;
	$SellW_Options = '';
	//Start Program
	echo "裝備<hr>";
	
	include_once('includes/sfo.class.php');

	// Functions

	function printEvTable($EvTo, $EvFrom, $slot, $cash){
		// $EvTo: Listing Array, i.e. $NextEv[$BelongsTo]
		// $EvFrom: SFO Eq Array
		$i = 0;
		echo "<tr align=center><td colspan=10><b><font color='yellow'>{$EvFrom[name]} (".expToStatus($EvFrom['exp']).")</font> 改造的可能性: </b></td></tr>";
		foreach($EvTo as $EvEntry){
			$i += printEvWepInfRow($EvEntry, $slot, $EvFrom['exp'], $cash);
		}
		if (!$i){echo "<tr align=center><td colspan=10>沒有。</td></tr>";}
		return $i;
	}
	
	function printEvWepInfRow($Wep,$slot,$xp,$cash){
		echo "<tr align=center>";
		echo "<td width=\"195\">$Wep[name]</td>";
		echo "<td width=\"80\">". number_format($Wep[atk]) ."</td>";
		echo "<td width=\"30\">$Wep[hit]</td>";
		echo "<td width=\"30\">$Wep[rd]</td>";
		echo "<td width=\"40\">$Wep[enc]</td>";
		printf("<td width=\"80\">%s</td>", getRangeAttrb($Wep['range'],$Wep['attrb'],$Wep['equip']));
		printf("<td width=\"120\">%s</td>", ReturnSpecs($Wep['spec']));
		echo "<td width=\"85\">".expToStatus($Wep['ev_xp'])."</td>";
		echo "<td width=\"85\">".number_format($Wep['ev_cost'])."</td>";
		$BtnLabel = '確認改造';
		$DisableFlag = false;
		if($Wep['ev_xp'] > $xp || $Wep['ev_cost'] > $cash){
			$BtnLabel = '未可改造';
			$DisableFlag = true;
		}
		elseif(!canEquipAsWep($Wep,true) && $slot == 'wepa') $DisableFlag = true;
		echo "<td width=\"85\"><input type=button value='$BtnLabel' onClick=\"cfmev('$slot','$Wep[ev_id]');\"";
		if($DisableFlag) echo " disabled";
		echo "></td></tr>";
		return 1;
	}
	
	function printWepInfRow($Wep,$slot,$str='裝備此武器',$form='equipwepform'){
		echo "<tr align=center>";
		echo "<td width=\"195\">$Wep[name]</td>";
		echo "<td width=\"80\">". number_format($Wep[atk]) ."</td>";
		echo "<td width=\"30\">$Wep[hit]</td>";
		echo "<td width=\"30\">$Wep[rd]</td>";
		echo "<td width=\"40\">$Wep[enc]</td>";
		printf("<td width=\"80\">%s</td>", getRangeAttrb($Wep['range'],$Wep['attrb'],$Wep['equip']));
		printf("<td width=\"120\">%s</td>", ReturnSpecs($Wep['spec']));
		echo "<td width=\"85\">$Wep[price]</td>";
		echo "<td width=\"85\"><input type='submit' value='$str' onClick=\"$form.slot_sw.value='$slot';\"></td></tr>";
		return 1;
	}

	function printSellInfRow($Wep,$slot,$str){
		$SellPrice = floor(($Wep['price']*0.5 + $Wep['price']*0.1)/1000)*1000;
		echo "<tr align=center>";
		echo "<td width=\"195\">$Wep[name]</td>";
		echo "<td width=\"80\">". number_format($Wep[atk]) ."</td>";
		echo "<td width=\"30\">$Wep[hit]</td>";
		echo "<td width=\"30\">$Wep[rd]</td>";
		echo "<td width=\"40\">$Wep[enc]</td>";
		printf("<td width=\"80\">%s</td>", getRangeAttrb($Wep['range'],$Wep['attrb'],$Wep['equip']));
		printf("<td width=\"120\">%s</td>", ReturnSpecs($Wep['spec']));
		echo "<td width=\"85\">". number_format($SellPrice) ."</td></tr>";
		return "<option value='$slot'>{$Wep[name]}($str)\n</option>";
	}

	// Create Objects
	$Pl = new player_stats();
	$Pl->SetUser($Pl_Value['USERNAME']);
	$Pl->FetchPlayer(true);
	$Pl->ProcessAllWeapon();

	// Variables
	$EqListing = array('A' => $Pl->Eq['A']['id'], 'B' => $Pl->Eq['B']['id'], 'C' => $Pl->Eq['C']['id']);
	$slotConv = array('A' => 'wepa', 'B' => 'wepb', 'C' => 'wepc', 'D' => 'eqwep');

	//改造武器(Ev)
	echo "<br><table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"665\">";
	echo "<form action=equip.php?action=evolution method=post name=evwepform>";
	echo "<input type=hidden value='evolution' name=actionb>";
	echo "<input type=hidden value='validcode' name=actionc>";
	echo "<input type=hidden value='validcode2' name=evfrom>";
	echo "<input type=hidden value='validcode3' name=evto>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<tr align=center><td colspan=10><b>改造武器: </b></td></tr>";
	echo "<tr align=center>";
	echo "<td width=\"195\">武器名稱</td>";
	echo "<td width=\"80\">攻擊力</td>";
	echo "<td width=\"30\">命中</td>";
	echo "<td width=\"30\">回數</td>";
	echo "<td width=\"40\">EN消費</td>";
	echo "<td width=\"80\">距離/屬性</td>";
	echo "<td width=\"120\">特殊效果</td>";
	echo "<td width=\"85\">狀態值需求</td>";
	echo "<td width=\"85\">改造價格</td>";
	echo "<td width=\"85\">改造武器</td>";
	echo "</tr>";
	echo "<script language=\"Javascript\">";
	echo "function cfmev(slot,aevto){";
	echo "if (confirm('確定要改造此武器嗎？') == true){evwepform.evfrom.value=slot;evwepform.evto.value=aevto;evwepform.submit();}else{return false}";
	echo "}";
	echo "</script>";

	$sql = "SELECT `ev_id`, `from_id`, `to_id`, `ev_xp`, `ev_cost` ";
	$sql .= ", `name`, `complexity`, `range`, `attrb`, `atk`, `hit`, `rd`, `enc`, `equip`, `spec` ";
	$sql .= " FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep_ev` `ev`, `".$GLOBALS['DBPrefix']."phpeb_sys_wep` `wep` WHERE ";
	$sql .= " `to_id` = `id` AND ( `from_id` = '{$Pl->Eq[A][id]}' OR `from_id` = '{$Pl->Eq[B][id]}' OR `from_id` = '{$Pl->Eq[C][id]}' )";
	$sql .= " ORDER BY `from_id`, `ev_xp`, `ev_cost`";
	
	$query = mysql_query($sql);
	$NextEv = array('A' => array(), 'B' => array(), 'C' => array());
	
	$lastId = -1;
	$BelongsTo = 'A';
	while($EvInf = mysql_fetch_array($query)){
		if($lastId != $EvInf['from_id']){
			$BelongsTo = array_search($EvInf['from_id'],$EqListing);
			$lastId = $EvInf['from_id'];
		}
		$NextEv[$BelongsTo][] = $EvInf;
	}

	$AvailEvFlag = 0;
	foreach($NextEv as $k => $v){
		if($Pl->Eq[$k]['id'])
			$AvailEvFlag += printEvTable($v, $Pl->Eq[$k], $slotConv[$k], $Pl->Player['cash']);
	}

	echo "</form></table>";
	echo "<br><hr width=75%>";	

if ($Pl->Player['msuit'] != 0){
	if (($Pl->Eq['B']['id'])||($Pl->Eq['C']['id'])||($Pl->Eq['D']['id'])){
		//裝備武器
		echo "<br><table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"580\">";
		echo "<form action=equip.php?action=equipwep method=post name=equipwepform>";
		echo "<input type=hidden value='equip' name=actionb>";
		echo "<input type=hidden value='validcode' name=actionc>";
		echo "<input type=hidden value='validcode2' name=slot_sw>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "<tr align=center><td colspan=9><b>裝備武器: </b></td></tr>";
		echo "<tr align=center>";
		echo "<td width=\"195\">武器名稱</td>";
		echo "<td width=\"80\">攻擊力</td>";
		echo "<td width=\"30\">命中</td>";
		echo "<td width=\"30\">回數</td>";
		echo "<td width=\"40\">EN消費</td>";
		echo "<td width=\"80\">距離/屬性</td>";
		echo "<td width=\"120\">特殊效果</td>";
		echo "<td width=\"85\">裝備</td>";
		echo "</tr>";
	
		$AvailEqWFlag = 0;
		if ($Pl->Eq['B']['id']){
			if (canEquipAsWep($Pl->Eq['B'])){
				$AvailEqWFlag += printWepInfRow($Pl->Eq['B'],$slotConv['B']);
			}
		}
		if ($Pl->Eq['C']['id']){
			if (canEquipAsWep($Pl->Eq['C'])){
				$AvailEqWFlag += printWepInfRow($Pl->Eq['C'],$slotConv['C']);
			}
		}
		if ($Pl->Eq['D']['id']){
			if (canEquipAsWep($Pl->Eq['D']) && $Pl->Eq['A']['equip']){
				$AvailEqWFlag += printWepInfRow($Pl->Eq['D'],$slotConv['D'],'位置轉換');
			}
		}
		if (!$AvailEqWFlag){echo "<tr align=center><td colspan=8>暫時沒有任何以裝備的武器。</td></tr>";}
		echo "</form></table>";
		echo "<br><hr width=75%><br>";
	}
	
	
	//輔助裝備
	echo "<br><table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"580\">";
	echo "<form action=equip.php?action=equipwep method=post name=equipdefform>";
	echo "<input type=hidden value='equipdef' name=actionb>";
	echo "<input type=hidden value='validcode' name=actionc>";
	echo "<input type=hidden value='validcode2' name=slot_sw>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<tr align=center><td colspan=9><b>輔助裝備: </b></td></tr>";
	echo "<tr align=center>";
	echo "<td width=\"195\">武器名稱</td>";
	echo "<td width=\"80\">攻擊力</td>";
	echo "<td width=\"30\">命中</td>";
	echo "<td width=\"30\">回數</td>";
	echo "<td width=\"40\">EN消費</td>";
	echo "<td width=\"80\">距離/屬性</td>";
	echo "<td width=\"120\">特殊效果</td>";
	echo "<td width=\"85\">裝備</td>";
	echo "</tr>";

	$AvailEqEFlag = 0;
	if ($Pl->Eq['D']['id']){
		if (!$Pl->Eq['B']['id'] || !$Pl->Eq['C']['id']){
			$AvailEqEFlag += printWepInfRow($Pl->Eq['D'],$slotConv['D'],'卸下此裝備','equipdefform');
		}
	}
	if ($Pl->Eq['B']['id']){
		if (canEquipAsWep($Pl->Eq['B'],true) && $Pl->Eq['B']['equip']){
			$AvailEqEFlag += printWepInfRow($Pl->Eq['B'],$slotConv['B'],'裝備','equipdefform');
		}
	}
	if ($Pl->Eq['C']['id']){
		if (canEquipAsWep($Pl->Eq['C'],true) && $Pl->Eq['C']['equip']){
			$AvailEqEFlag += printWepInfRow($Pl->Eq['C'],$slotConv['C'],'裝備','equipdefform');
		}
	}
	if (!$AvailEqEFlag){echo "<tr align=center><td colspan=8>暫時沒有任何以成為輔助裝備的武器。</td></tr>";}
	echo "</form></table>";
	echo "<br><hr width=75%><br>";
	
	
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"600\">";
	echo "<form action=equip.php?action=buywep method=post name=buywepform>";
	echo "<input type=hidden value='process' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<tr align=center><td colspan=9><b>武器列表: </b></td></tr>";
	echo "<tr align=center>";
	echo "<td width=\"20\">No.</td>";
	echo "<td width=\"195\">武器名稱</td>";
	echo "<td width=\"80\">攻擊力</td>";
	echo "<td width=\"30\">命中</td>";
	echo "<td width=\"30\">回數</td>";
	echo "<td width=\"40\">EN消費</td>";
	echo "<td width=\"80\">距離/屬性</td>";
	echo "<td width=\"120\">特殊效果</td>";
	echo "<td width=\"85\">價錢</td>";
	echo "</tr>";
	if (!$Pl->Player['wepa']) $CEqOpt = "AND `equip` != '2'";
	$wepsqlsel = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `buy` = '1' AND `price` <= '{$Pl->Player[cash]}' $CEqOpt ORDER BY price, id");
	$reswep = mysql_query($wepsqlsel);
	$syswepbuyinfo = mysql_fetch_array($reswep);
	$syswepbuynumsrows = mysql_num_rows($reswep);
	if ($syswepbuynumsrows > 0){
		$countbw1=0;
		$wepbuyoptions='';
		do{
			$countbw1++;
			echo "<tr align=center>";
			echo "<td width=\"20\">$countbw1</td>";
			echo "<td width=\"195\">$syswepbuyinfo[name]</td>";
			echo "<td width=\"80\">". number_format($syswepbuyinfo['atk']) ."</td>";
			echo "<td width=\"30\">$syswepbuyinfo[hit]</td>";
			echo "<td width=\"30\">$syswepbuyinfo[rd]</td>";
			echo "<td width=\"40\">$syswepbuyinfo[enc]</td>";
			echo "<td width=\"80\">".getRangeAttrb($syswepbuyinfo['range'],$syswepbuyinfo['attrb'],$syswepbuyinfo['equip'])."</td>";
			$syswepbuyinfospecs = ReturnSpecs($syswepbuyinfo['spec']);
			echo "<td width=\"120\">$syswepbuyinfospecs</td>";
			echo "<td width=\"85\">". number_format($syswepbuyinfo['price']) ."</td>";
			echo "</tr>";
			if ($Pl->Eq['A']['id'] != 0 || !$syswepbuyinfo['equip'])
				$wepbuyoptions .= "<option value='$syswepbuyinfo[id]' id='$syswepbuyinfo[name]'>$syswepbuyinfo[name](No. $countbw1)</option>\n";
		}
		while ( $syswepbuyinfo = mysql_fetch_array($reswep) );

		echo "<tr align=center><td colspan=8><b>選購新武器: </b>";
		if ($Pl->Eq['A']['id'] && $Pl->Eq['B']['id'] && $Pl->Eq['C']['id']){
			$disBW = 'disabled';
			$disBW_mes = '<br>你沒有多出來的空間可以放置新武器。';
		}
		else {$disBW = 'enabled';$disBW_mes = '';}

		echo "<script language=\"Javascript\">";
		echo "function cfmbuy(){";
		echo "if (confirm('確定要購買嗎？') == true){buywepform.BuyWepDesired.disabled=false;buywepform.submit()}else{buywepform.BuyWepDesired.disabled=false;buywepform.cfmbuybutton.disabled=false;return false}";
		echo "}";
		echo "</script>";
		echo "<select name=BuyWepDesired $disBW>";
		echo $wepbuyoptions ;
		echo "</select>";
		echo "<input type=button value='購買' name=cfmbuybutton OnClick=\"buywepform.BuyWepDesired.disabled=true;this.disabled=true;cfmbuy()\" $disBW>$disBW_mes";
		echo "</td></tr>";
		echo "</form></table>";
	}
}else echo "沒有機體，不能購入新武器！";

if (($Pl->Eq['A']['id'])||($Pl->Eq['B']['id'])||($Pl->Eq['C']['id'])){
	echo "<br><hr width=75%><br>";
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"580\">";

	echo "<tr align=center><td colspan=8><b>你可出售的武器列表: </b></td></tr>";
	echo "<tr align=center>";
	echo "<td width=\"195\">武器名稱</td>";
	echo "<td width=\"80\">攻擊力</td>";
	echo "<td width=\"30\">命中</td>";
	echo "<td width=\"30\">回數</td>";
	echo "<td width=\"40\">EN消費</td>";
	echo "<td width=\"80\">距離/屬性</td>";
	echo "<td width=\"120\">特殊效果</td>";
	echo "<td width=\"85\">回收價錢</td>";
	echo "</tr>";

	$SellW_Options ='';
	if ($Pl->Eq['A']['id']){
		$SellW_Options .= printSellInfRow($Pl->Eq['A'],'WepA','使用中武器');
	}
	if ($Pl->Eq['B']['id']){
		$SellW_Options .= printSellInfRow($Pl->Eq['B'],'WepB','備用武器一');
	}
	if ($Pl->Eq['C']['id']){	
		$SellW_Options .= printSellInfRow($Pl->Eq['C'],'WepC','備用武器二');
	}

	echo "<form action=equip.php?action=sellwep method=post name=sellwepform>";
	echo "<input type=hidden value='process' name=actionb>";
	echo "<input type=hidden value='validcode' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<tr align=center><td colspan=7><b>售出武器: </b>";
	if ($SellW_Options){
		echo "<select name=SellWepDesired>";
		echo $SellW_Options;
		echo "</select>";
		echo "<script language=\"Javascript\">";
		echo "function cfmsell(){";
		echo "if (confirm('確定要售出嗎？') == true){sellwepform.SellWepDesired.disabled=false;sellwepform.submit()}else{sellwepform.SellWepDesired.disabled=false;sellwepform.cfmsellbutton.disabled=false;return false}";
		echo "}";
		echo "</script>";
		echo "<input type=button value='確定' OnClick=\"sellwepform.SellWepDesired.disabled=true;this.disabled=true;cfmsell()\" name=cfmsellbutton>";
	}else echo "沒有可以售出的武器。";
	echo "</td></tr></form></table><br>";
}
postFooter();
?>