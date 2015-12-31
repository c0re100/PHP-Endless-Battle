<?php

//Display of Fields
unset($Df,$a,$d,$S,$ColumnNum);
$FieldDisplay = '';
$ColumnNum = 2;
$Df = array('at.attacking','de.defending','re.reacting','ta.targeting','lv.level','hp.hp','bty.bounty','ms.msuit','tch.typech');
foreach($Df as $a){
	$d = explode('.',$a);
	$S = 'fdis_'.$d[0];
	if ($Pl_Settings[$S]) $FieldDisplay .= ', `'.$d[1].'`';
	$ColumnNum++;
}
if ($Pl_Settings['fdis_hp']) $FieldDisplay .= ', `hpmax`';

//Filter Fields
unset($F,$a,$d,$Si,$Sa);
$CustomFilter = '';
$F = array('at.attacking','de.defending','re.reacting','ta.targeting','lv.level','hp.hpmax','fame.fame','bty.bounty');
foreach($F as $a){
	$d = explode('.',$a);
	$Si = 'filter_'.$d[0].'_min';
	$Sa = 'filter_'.$d[0].'_max';
	if ($Pl_Settings[$Si]) $CustomFilter .= ' AND `'.$d[1].'` >= '.$Pl_Settings[$Si];
	if ($Pl_Settings[$Sa]) $CustomFilter .= ' AND `'.$d[1].'` <= '.$Pl_Settings[$Sa];
}
if ($Pl_Settings['filter_con'] == 1) $CustomFilter .= ' AND `time2` > '.($CFU_Time-$Offline_Time);
elseif ($Pl_Settings['filter_con'] == 2) $CustomFilter .= ' AND `time2` <= '.($CFU_Time-$Offline_Time);
//Order filter_sort_asc
unset($OAD);
$OAD = ($Pl_Settings['filter_sort_asc'])?'ASC':'DESC';
switch($Pl_Settings['filter_sort']){
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


$sql_gen = ("SELECT `gen`.`username`, `password`, `color`, `time2`, `coordinates`, `organization` , `fame`".$FieldDisplay.
"FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `gen`, `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `game` 
WHERE `gen`.`username`=`game`.`username` AND `gen`.`username` != '$Pl_Value[USERNAME]' 
AND `msuit` != '0' AND `coordinates` = '$Pl_Gen[coordinates]' ".
$CustomFilter." ORDER BY ".
$CustomOrder);


unset($torder);
$sql_gen_results = mysql_query ($sql_gen) or die ('出錯1, 原因:' . mysql_error() . '<br>');
$numofoppos=mysql_num_rows($sql_gen_results);
if (!$numofoppos){echo"<center>暫時沒有任何對手。";postFooter();Exit;}

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\">";
	echo "<form action=battle.php?action=attack_target method=post name=battle_sel_form>";
	echo "<input type=hidden value='process' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<tr align=center><td colspan=$ColumnNum><b>對手列表: </b></td></tr>";
	echo "<tr align=center>";
	echo "<td width=\"20\">No.</td>";
	echo "<td width=\"250\">對手名稱</td>";
	if ($Pl_Settings['fdis_lv'])
	echo "<td width=\"30\">等級</td>";
	if ($Pl_Settings['fdis_at'])
	echo "<td width=\"30\">攻擊</td>";
	if ($Pl_Settings['fdis_de'])
	echo "<td width=\"30\">防禦</td>";
	if ($Pl_Settings['fdis_re'])
	echo "<td width=\"30\">反應</td>";
	if ($Pl_Settings['fdis_ta'])
	echo "<td width=\"30\">命中</td>";
	if ($Pl_Settings['fdis_tch'])
	echo "<td width=\"80\">類型</td>";
	if ($Pl_Settings['fdis_ms'])
	echo "<td width=\"200\">機體</td>";
	if ($Pl_Settings['fdis_hp'])
	echo "<td width=\"100\">HP</td>";
	if ($Pl_Settings['fdis_fame'])
	echo "<td width=\"40\">名聲</td>";
	if ($Pl_Settings['fdis_bty'])
	echo "<td width=\"55\">懸賞金</td>";
	if ($Pl_Settings['fdis_con'])
	echo "<td width=\"50\">狀態</td>";
	echo "<td width=\"30\">戰鬥</td>";
	echo "</tr>";
	echo "<script language=\"Javascript\">";
	echo "function cfmAtkOnline(){";
	echo "if (confirm('攻擊在線的玩家可能會有損您的名聲，真的要這樣做？')==true){return true}";
	echo "else {return false}";
	echo "}</script>";
	$mini_c=0;
	$war_c=0;
for ($counter=1;$counter<=$numofoppos;$counter++){
	unset($Op_Rank,$Op_Org,$Op_RightsTitle,$OrgWarOppos);
	$Op_Gen=mysql_fetch_array($sql_gen_results);
	$sql_game = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE username = '$Op_Gen[username]'");
	$sql_game_results = mysql_query ($sql_game) or die ('出錯2, 原因:' . mysql_error() . '<br>');
	$Op_Game = mysql_fetch_array($sql_game_results);
	$Op_Repaired = AutoRepair("$Op_Gen[username]");
	$Op_Game['hp'] = $Op_Repaired['hp'];
	$Op_Game['en'] = $Op_Repaired['en'];
	$Op_Game['sp'] = $Op_Repaired['sp'];
	$Op_Game['status'] = $Op_Repaired['status'];
	$Op_WepA = explode('<!>',$Op_Game['wepa']);
	
	$CeaseAtkTar = '';
	if ($Op_Game['organization'] == $Pl_Game['organization'] && $Pl_Game['organization'] != '0')
	$CeaseAtkTar = '1';
	if ($Op_WepA[0] && !$Op_Game['status'] && !$CeaseAtkTar){
	GetWeaponDetails("$Op_WepA[0]",'Op_SyWepA');
	if (isset($Op_Gen['msuit'])) GetMsDetails($Op_Gen['msuit'],'Op_Ms');
	$Op_Org = ReturnOrg($Op_Game['organization']);
	if ($Op_Game['organization'])
	$Op_Rank = ' '.rankConvert($Op_Game['rank']);
	if ($Op_Game['organization'] && $Op_Game['rights'] == '1'){$Op_RightsTitle = "<font style=\"color: yellow;font-weight: Bold;\">&nbsp;".$RightsClass['Major']."</font>";}
	elseif ($Op_Game['rights']){$Op_RightsTitle = "<font style=\"color: yellow;font-weight: Bold;\">&nbsp;".$RightsClass['Leader']."</font>";}
	$mini_c++;
	echo "<tr align=center style=\"color: $Op_Gen[color]\">";
	echo "<td width=\"20\">$mini_c</td>";
	echo "<td width=\"250\">";
	echo "$Op_Game[gamename]";
	echo " <font style=\"color: $Op_Org[color]\">($Op_Org[name])$Op_RightsTitle$Op_Rank";
	if ($Area_Org['id'] == $Op_Org['id'] && $AttackFort && $Op_Org['id']){echo "<font color='red'> [敵]</font>";$OrgWarOppos = '1';$war_c++;}
	elseif (ereg_replace('(Atk=\()|\)','',$Op_Org['optmissioni']) == $Pl_Gen['coordinates'] && $CFU_Time < $Op_Org['opttime'] && $Pl_Game['organization'] != '0' && $Area_Org['id'] == $Pl_Game['organization']){
	echo "<font color='red'> [敵]</font>";$OrgWarOppos = '1';}
	elseif ($Op_Org['optmissioni'] == $Pl_Org['optmissioni'] && $CFU_Time < $Op_Org['opttime'] && $CFU_Time < $Pl_Org['opttime'] && ereg_replace('(Atk=\()|\)','',$Op_Org['optmissioni']) == $Pl_Gen['coordinates']){
	echo "<font color='red'> [敵]</font>";$OrgWarOppos = '1';}
	echo "</font></td>";
	if ($Pl_Settings['fdis_lv'])
	echo "<td width=\"30\">$Op_Game[level]</td>";
	if ($Pl_Settings['fdis_at'])
	echo "<td width=\"30\">".dualConvert($Op_Game['attacking'])."</td>";
	if ($Pl_Settings['fdis_de'])
	echo "<td width=\"30\">".dualConvert($Op_Game['defending'])."</td>";
	if ($Pl_Settings['fdis_re'])
	echo "<td width=\"30\">".dualConvert($Op_Game['reacting'])."</td>";
	if ($Pl_Settings['fdis_ta'])
	echo "<td width=\"30\">".dualConvert($Op_Game['targeting'])."</td>";
	if ($Pl_Settings['fdis_tch']){
	$Op_Type=GetChType($Op_Gen['typech']);
	echo "<td width=\"80\">$Op_Type[name]";
	if ($Op_Gen['hypermode'] == 1 || $Op_Gen['hypermode'] == 5)
	echo "<br><font style=\"color: FFFF00;font-weight: bold\">SEED Mode</font>";
	if ($Op_Gen['hypermode'] >= 4 && $Op_Gen['hypermode'] <= 6)
	echo "<br><font style=\"color: FF0000;font-weight: bold\">EXAM Activated</font>";
	echo "</td>";}
	if ($Pl_Settings['fdis_ms']){
		if ($Op_Game['ms_custom']) $Op_CFix = explode('<!>',$Op_Game['ms_custom']);
		else $Op_CFix = array(0,0,0,0,0);
		if ($Op_CFix[0]) $Op_Ms['msname'] = $Op_CFix[0]."<sub>&copy;</sub>";
		echo "<td width=\"200\">$Op_Ms[msname]</td>";
	}
	if ($CFU_Time-$Op_Gen['time2'] < $Offline_Time){
		$OnlineStat = "<b style=\"color: red\">參戰中</b>";
		if (!$OrgWarOppos && $Op_Gen['fame'] >= 0 && $Pl_Gen['fame'] >= $NotoriousIgnore && $Pl_Settings['atkonline_alert'])
		$OnConfirm = ";return cfmAtkOnline()";
		else unset($OnConfirm);
	}
	else {$OnlineStat = '<font style="color: #11CFFF">休息中</font>';unset($OnConfirm);}
	if ($Pl_Settings['fdis_hp'])
	echo "<td width=\"100\">$Op_Game[hp]/$Op_Game[hpmax]</td>";
	if ($Pl_Settings['fdis_fame']){
	$DisOPFameC = ($Op_Gen['fame'] < 0)?'Red':'Yellow';
	echo "<td width=\"40\" style=\"color: $DisOPFameC\">".abs($Op_Gen['fame'])."</td>";}
	if ($Pl_Settings['fdis_bty'])
	echo "<td width=\"60\" style=\"color: white\">$Op_Gen[bounty]</td>";
	if ($Pl_Settings['fdis_con'])
	echo "<td width=\"60\">$OnlineStat</td>";
	echo "<td width=\"30\">";
	echo "<input type=radio name=Op_Name value=\"$Op_Gen[username]\" onClick=\"location.replace('#StartBattle')$OnConfirm\"></td>";
	echo "</tr>";
			}
	}
	if (!$Area_Org['id'])$war_c = 0;
	if ($mini_c == 0){echo "<tr align=center><td colspan=".($ColumnNum-1)." align=center>全部玩家也修理中！</td></tr>";$DisAtkButton=' disabled';}
	echo "<tr align=right>";
	echo "<td colspan=".($ColumnNum-2).">";
	if(ereg('(EXAMSystem)+',$Pl_Game['spec'])){
	echo "開啟EXAM System<input type=checkbox name=EXAMStat";
	if($Pl_Gen['hypermode'] >= 4 && $Pl_Gen['hypermode'] <= 6) echo " checked";
	echo ">";
	}
	if($ControlSEED && ereg('(SeedMode)+',$Pl_Game['spec']) && ereg('(co|ext|nat)+',$Pl_Gen['typech'])){
	echo "進入SEED Mode<input type=checkbox name=SEEDStat";
	if($Pl_Gen['hypermode'] == 1 || $Pl_Gen['hypermode'] == 5) echo " checked";
	echo ">";
	}
	echo "以<select name=\"Pl_GTctcs\">";
	echo "<option value='0'>通常攻擊";
	if ($Pl_Game['tactics']){
	$Pl_TactList = explode("\n",$Pl_Game['tactics']);
	sort($Pl_TactList);
	foreach($Pl_TactList as $Tactics){
	$Tactics = trim($Tactics);
	$TactInf = GetTactics("$Tactics");
	if ($Pl_Gen['hypermode']==1 && $ControlSEED) $TactInf['spc'] = ceil($TactInf['spc'] * 1.25) + 5; //SEED Mode SP額外消耗
	if ($Pl_Gen['hypermode'] >= 4 && $Pl_Gen['hypermode'] <= 6) $TactInf['spc'] = ceil($TactInf['spc'] * 1.20) + 3; //EXAM System SP額外消耗
	if (!$Tactics) unset($Tactics);
		else{
		if ($Pl_Game['sp'] - $TactInf['spc'] < 0) unset($Tactics);
		elseif ($Pl_Game['en'] < ($Pl_SyWepA['enc']+$Pl_SyWepD['enc']+$Pl_SyWepE['enc']+$TactInf['enc'])) unset($Tactics);
		else {	echo "<option value='$Tactics'";
			if ($Tactics == $Pl_Game['last_tact']) echo " selected";
			echo ">$TactInf[name] (SP消耗: $TactInf[spc])";
			}
		}
	}	
	}
	echo "</select>";
	echo "<a name=StartBattle>攻擊目標:</a>&nbsp;";
	echo "<input type=submit $BStyleB style=\"$BStyleA\" name=battle_submit value='確定' OnClick=\"this.style.visibility='hidden';\"";
	echo $DisAtkButton;
	echo ">&nbsp;&nbsp;&nbsp;";
	echo "";
	echo "</td>";
	echo "</tr></form></table><br><br>";


?>