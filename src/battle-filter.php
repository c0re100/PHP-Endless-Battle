<?php
//Battle Opponent Selection Filter - Main Unit
//For php-eb v1.0 UE
//Copyright(c) v2Alliance 2008

printTHR();
echo "<div align=center style=\"font-size: 11pt; color: $Area_Org[color];\">$WarMessage$Area_Org[name]的領地: ". $Area["Sys"]["map_id"] ."區域";
echo "<br><a href=\"Javascript:showfort();\" id=fbtn style=\"text-decoration: none\">要塞狀態</a></div>";
echo "<script language=\"JavaScript\">";
echo "function showfort(){document.getElementById('fortstat').style.visibility='visible';document.getElementById('fortstat').style.position='relative';document.getElementById('fbtn').href=\"Javascript:hidefort();\"}";
echo "function hidefort(){document.getElementById('fortstat').style.visibility='hidden';document.getElementById('fortstat').style.position='absolute';document.getElementById('fbtn').href=\"Javascript:showfort();\"}";
echo "</script>";
echo "<div align=center style=\"font-size: 10pt; color: $Area_Org[color];visibility: hidden;position: absolute\" id=fortstat>HP: ". $Area['User']['hp']. "/" .$Area['User']['hpmax'];
echo "<br>軍力: ".$Area["User"]["tickets"]." 守備能力: $Area_Pi Att: $Area_At Def: $Area_De Tar: $Area_Ta$FortDestoryedMsg";
echo "</div>".sprintTHR();

if($Pl->Player['battle_def_filter'])	$btlFilter = 'd';
else 					$btlFilter = 'c';

//Part 1: Set SQL Commands - Start
	include('includes/btl-filter/btl-fp1-'.$btlFilter.'.php');
//Part 1: Set SQL Commands - End


$numofoppos=mysql_num_rows($Query);
if (!$numofoppos && (!$AttackFort || $btlFilter == 'c')){echo"<center>暫時沒有任何對手。";postFooter();Exit;}

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\">";
	echo "<form action=battle.php?action=attack_target method=post name=battle_sel_form>";
	echo "<input type=hidden value='process' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

//Part 2: Display Column Headings - Start
	include('includes/btl-filter/btl-fp2-'.$btlFilter.'.php');
//Part 2: Display Column Headings - End

	echo "<script language=\"Javascript\">";
	echo "function cfmAtkOnline(){";
	echo "if (confirm('攻擊在線的玩家可能會有損您的名聲，真的要這樣做？')==true){return true}";
	echo "else {return false}";
	echo "}function checkAtk(){";
	echo "if(document.getElementById('need_sp').innerHTML > parseInt(parent.document.getElementById('current_sp').innerHTML)) {alert('SP還未足夠！');document.battle_sel_form.battle_submit.style.visibility='visible';return false;}";
	echo "return true;";
	echo "}function changeSpc(){";
	echo "var TactChose;";
	echo "var tspc;";
	echo "TactChose = 'Tact_'+battle_sel_form.Pl_GTctcs.value;";
	echo "tspc = parseInt(eval('document.battle_sel_form.'+TactChose+'.value;'));";
	
	$isExamTypeCh = ($Pl->Player['typech'] == 'nat' || $Pl->Player['typech'] == 'ext' || $Pl->Player['typech'] == 'enh');
	$isSEEDTypeCh = ($Pl->Player['typech'] == 'co' || $Pl->Player['typech'] == 'ext' || $Pl->Player['typech'] == 'nat');
	if(strpos($Pl->Player['spec'],'EXAMSystem') !== false && $isExamTypeCh)
	echo "if(document.battle_sel_form.EXAMStat.checked == true) tspc += 20;";
	if(strpos($Pl->Player['spec'],'SeedMode') !== false && $isSEEDTypeCh)
	echo "if(document.battle_sel_form.SEEDStat.checked == true) tspc += 20;";
	echo "document.getElementById('need_sp').innerHTML = tspc;";
	echo "}</script>";
	$cOpponent=$cDefenders=0;
	$LastOrg_ID = false;
	$OnConfirm = '';

	unset($Op_Org);

//Part 3: Display Column Contents - Start
	include('includes/btl-filter/btl-fp3-'.$btlFilter.'.php');
//Part 3: Display Column Contents - End

	$Op_Rank = '';

for ($counter=1;$counter<=$numofoppos;$counter++){
	$LastOrg_ID = ( isset ($Op_Info['organization']) ) ? $Op_Info['organization'] : false;
	unset($Op_RightsTitle);
	$isEnemyFlag = 0;
	$Op_Info=mysql_fetch_array($Query);

	$opr = array(
	"name" => $Op_Info['name'],
	"hp" => $Op_Info['hp'],
	"hpmax" => $Op_Info['hpmax'],
	"hprec" => $Op_Info['hprec'],
	"en" => $Op_Info['en'],
	"enmax" => $Op_Info['enmax'],
	"enrec" => $Op_Info['enrec'],
	"sp" => $Op_Info['sp'],
	"spmax" => $Op_Info['spmax'],
	"status" => $Op_Info['status'],
	"time1" => $Op_Info['time1'],
	"hypermode" => $Op_Info['hypermode'],
	"eqwep" => $Op_Info['eqwep'],
	"p_equip" => $Op_Info['p_equip']);

	$opr_ms = array(
	"enrec" => $Op_Info['enrec'],
	"hprec" => $Op_Info['hprec']);

	$Op_Repaired = RepairPlayer($opr,0,0,1,$opr_ms,1);
	$Op_Info['hp'] = $Op_Repaired['hp'];
	$Op_Info['status'] = $Op_Repaired['status'];

	if ($Op_Info['status'])	unset($Op_Info);
	else{
		if ($Op_Info['organization'] != $LastOrg_ID || $LastOrg_ID === false || empty($Op_Org))
		$Op_Org = ReturnOrg($Op_Info['organization']);
		$Op_RightsTitle = '';

		$Op_Rank = ' '.rankConvert($Op_Info['rank']);

		if ($Op_Info['rights'] == '1')
			$Op_RightsTitle = "<font style=\"color: yellow;font-weight: Bold;\">&nbsp;".$RightsClass['Major']."</font>";
		elseif ($Op_Info['rights'])
			$Op_RightsTitle = "<font style=\"color: yellow;font-weight: Bold;\">&nbsp;".$RightsClass['Leader']."</font>";

		$cOpponent++;

		echo "<tr align=center style=\"color: $Op_Info[color]\">";
		echo "<td width=\"20\">$cOpponent</td>";
		echo "<td width=\"250\">";
		echo $Op_Info['gamename'];
		echo " <font style=\"color: $Op_Org[color]\">($Op_Org[name])$Op_RightsTitle$Op_Rank";
		echo "</font></td>";

		$OnlineStat = '';

		if (in_array($Op_Org['id'],$enemyOrgs)){
			$isEnemyFlag = 1;
			if(in_array($Op_Info['name'],$Defenders) && $Op_Info['coordinates'] == $Pl->Player['coordinates']){
				$cDefenders++;
				$OnlineStat .= "<br><font color='yellow'><b>[敵※守衛]</b></font>";
			}else	$OnlineStat .= "<br><font color='red'><b>[敵軍]</b></font>";
		}

		if ($CFU_Time-$Op_Info['time2'] < $Offline_Time){
			$OnlineStat = "<b style=\"color: red\">參戰中</b>".$OnlineStat;
			if (!$isEnemyFlag && $Op_Info['fame'] >= 0 && $Pl->Player['fame'] >= $NotoriousIgnore && $Pl->Player['atkonline_alert'])
			$OnConfirm = ";return cfmAtkOnline();";
			else $OnConfirm = '';
		}
		else {$OnlineStat = '<font style="color: #11CFFF">休息中</font>'.$OnlineStat;$OnConfirm = '';}

		DisplayColumns($Op_Info,$OnlineStat,$Pl->Player);

		echo "<td width=\"30\">";
		echo "<input type=radio name=Op_Name value=\"$Op_Info[name]\" onClick=\"location.replace('#StartBattle')$OnConfirm\"></td>";
		echo "</tr>";
	}
}
	$DisAtkButton='';
	if (!$Area_Org['id']) $cDefenders = 0;
	if ($cOpponent == 0){
		echo "<tr align=center><td colspan=".($ColumnNum)." align=center>全部玩家也修理中或暫時沒有任何對手！</td></tr>";
		$DisAtkButton=' disabled';
	}
	if ($cDefenders == 0 && $AttackFort == 'True' && $Area["User"]["hp"] > 0 && $Pl->Player['battle_def_filter']){
		echo "<tr align=center><td colspan=6 align=center style=\"font-size: 12pt;font-weight: Bold;\">敵軍要塞</td>";
		echo "<td width=\"30\"><input type=radio name=Op_Name value=\"<AttackFort>\" onClick=\"location.replace('#StartBattle')\"></td></tr>";
		$DisAtkButton='';
	}
	echo "<tr align=right>";
	echo "<td colspan=".($ColumnNum-1).">";
	if(strpos($Pl->Player['spec'],'EXAMSystem') !== false){
		echo "開啟EXAM System<input onClick='changeSpc();' type=checkbox name=EXAMStat";
		if($Pl->Player['hypermode'] >= 4 && $Pl->Player['hypermode'] <= 6) echo " checked";
		echo ">";
	}
	$isSEEDTypeCh = ($Pl->Player['typech'] == 'co' || $Pl->Player['typech'] == 'ext' || $Pl->Player['typech'] == 'nat');
	if(strpos($Pl->Player['spec'],'SeedMode') !== false && $isSEEDTypeCh){
		echo "進入SEED Mode<input onClick='changeSpc();' type=checkbox name=SEEDStat";
		if($Pl->Player['hypermode'] == 1 || $Pl->Player['hypermode'] == 5) echo " checked";
		echo ">";
	}
	if($Pl->Player['hypermode'] == 2 && $Pl->Player['typech'] == 'nt' && $Pl->Eq['D']['exp'] >= 2500){
	echo "預感 <input type=checkbox name=NTPresage";
	if(strpos($Pl->Player['spec'],'NTPresage') !== false) echo " checked";
	echo ">";
	}
	$baseSpCost = 0;
	if (($Pl->Player['hypermode'] == 1 || $Pl->Player['hypermode'] == 5)) $baseSpCost += 20; //SEED Mode SP額外消耗
	if ($Pl->Player['hypermode'] >= 4 && $Pl->Player['hypermode'] <= 6) $baseSpCost += 20; //EXAM System SP額外消耗
	echo "以<select name=\"Pl_GTctcs\" onchange='changeSpc();'>";
	echo "<option value='0'>通常攻擊";
	$TactSpc_Format = '<input type=hidden name=Tact_%s value=%u>';
	$TactSpc = sprintf($TactSpc_Format,'0',0);
	if ($Pl->Player['tactics']){
		$Pl_TactList = explode("\n",$Pl->Player['tactics']);
		sort($Pl_TactList);
		foreach($Pl_TactList as $Tactics){
			$Tactics =trim($Tactics);
			$TactInf = GetTactics($Tactics,'`spc`, `name`');
			if (!$Tactics) unset($Tactics);
			else{
				echo "<option value='$Tactics'";
				if ($Tactics == $Pl->Player['last_tact']) {echo " selected";$baseSpCost+=$TactInf['spc'];}
				echo ">$TactInf[name]";
				$TactSpc .= sprintf($TactSpc_Format,$Tactics,$TactInf['spc']);
			}
		}
	}
	echo "</select>";
	echo $TactSpc;
	echo "(SP消耗: <span id=need_sp>$baseSpCost</span>)<a name=StartBattle>攻擊目標:</a>&nbsp;";
	echo "<input type=submit $BStyleB style=\"$BStyleA\" name=battle_submit value='確定' OnClick=\"this.style.visibility='hidden';return checkAtk();\"";
	echo $DisAtkButton;
	echo ">&nbsp;&nbsp;&nbsp;";
	echo "</td><td>&nbsp;</td>";
	echo "</tr></form></table><br><br>";


?>