<?php
if ($mode == 'attack_target'){
	//Include Functions
	include('battle_function.php');

//
// Pre-phase
//

	$AtkFortFlag = 0;
	$Op_Name = (isset($Op_Name)) ? $Op_Name : '';
	$isAtkFortName = ( $Op_Name == '<AttackFort>' );
	if (!$Op_Name){echo "請先挑選對手！";exit;}
	elseif ($Op_Name == $Pl_Value['USERNAME']){echo "不能攻擊自己！";exit;}
	elseif (!$isAtkFortName){
		$Op = new oBattle;
		$Op->SetUser($Op_Name);
		$Op->FetchPlayer(true);
	}
	else{
		if ($AttackFort != 'True' || $Area["User"]["hp"] <= 0){
			echo "不能攻擊要塞";
			postFooter();
			exit;
		}
		//Search for Defenders
			if(count($Defenders) > 0){
				$d_sql_where = '(';
				$i = 0;
				foreach($Defenders as $u) {
					$d_sql_where = $d_sql_where . (($i == 0) ? '' : ' OR') . " `ge`.`username` = '$u' ";
					$i++;
				}
				$d_sql_where .= " ) AND `ga`.`username` = `ge`.`username`";
			}
			else $d_sql_where = ' 0 ';
			$sql = ("SELECT COUNT(*) AS `num` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `ga`,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` `ge` WHERE !`status` AND `coordinates` = '{$Pl->Player[coordinates]}' AND ".$d_sql_where);
			$query = mysql_query($sql) or die(mysql_error().'<br>'.$sql.'<hr>');
			
			$d = mysql_fetch_array($query);
			if($d['num'] > 0){
				echo "請先攻擊守衛！";
				postFooter();
				exit;
			}

		// Create Fort Information - Start
		$Op = new oBattle;
		$AtkFortFlag = 1;
		$Op->Player = Array(
			"username" => '<AttackFort>', "name" => '<AttackFort>', "bounty" => 0, "color" => "$Area_Org[color]", "msuit" => '<AttackFort>',
			"typech" => "nat", "hypermode" => 0, "coordinates" => $Pl->Player['coordinates'], "fame" => "0", "time2" => "0",
			"gamename" => '防禦要塞',
			"hp" => $Area["User"]["hp"], "hpmax" => $Area["User"]["hpmax"],
			"en" => "100000", "enmax" => "100000",
			"attacking" => $Area_Pi, "defending" => $Area_Pi,
			"reacting" => 1, "targeting" => $Area_Pi,
			"level" => $Area_Pi, "ms_custom" => "", "expr" => "0",
			"wepa" => $Area["User"]["wepa"]."<!>25000",
			"wepb" => "0<!>0",
			"wepc" => "0<!>0",
			"eqwep" => "0<!>0",
			"p_equip" => "0<!>0",
			"spec" => "", "show_log_num" => 0,
			"rank" => "100000", "rights" => "1",
			"organization" => "$Area_Org[id]", "status" => "0",
			"tactics" => "DefCounterA\nTripleStrike\nMindStrike\nFirstStrike\nSenseStrike");
		// Create Fort Information - Done
	}

	if ($Op->Player['status']){echo "對手修理中．．";postFooter();exit;}
	if (substr($Op->Player['coordinates'],0,2) != substr($Pl->Player['coordinates'],0,2)){echo "看不見對手．．<br>對方位置: ".$Op->Player['coordinates']." 自己位置: ".$Pl->Player['coordinates'];postFooter();exit;}

	$Op_Org = ($Area['User']['occupied'] != $Op->Player['organization']) ? ReturnOrg($Op->Player['organization']) : $Area_Org;
	$Op_LocalOrgFlag = 0;
	if ($Area['User']['occupied'] == $Op->Player['organization']) $Op_LocalOrgFlag = 1;

//Organization War - Identify Enemies
	$isEnemyFlag = 0;
	$Pl->MyStanceState = 0;
	$Op->MyStanceState = 0;
	if(in_array($Op_Org['id'],$enemyOrgs) || $isAtkFortName){
		// Opponent is Defending Organization & Player is Attacking Organization
		if($WarFlag == $Op_Org['id'] || $isAtkFortName){
			$isEnemyFlag = 2;
			if($isAtkFortName){
				$Pl->MyStanceState = 2; // Active Fort Assault
				$Op->MyStanceState = 6; // Passive Defender
			}
			else{
				$Pl->MyStanceState = 1; // Active Attacker
				$Op->MyStanceState = 5; // Passive Defender
			}
		}
		// Opponent is Attacking Organization & Player is Defending Organization
		elseif($WarFlag == '<defend>'){
			$isEnemyFlag = 3;
			$Pl->MyStanceState = 3; // Active Defender
			$Op->MyStanceState = 4; // Passive Attacker
		}
		// Opponent is Mutual Aggresion Enemy
		else {
			$isEnemyFlag = 1;
			$Pl->MyStanceState = 1; // Active Attacker
			$Op->MyStanceState = 4; // Passive Attacker
		}
	}

// Hypermode Stats
	$SEEDStat = (isset($SEEDStat)) ? $SEEDStat : false;
	$EXAMStat = (isset($EXAMStat)) ? $EXAMStat : false;
	$NTPresage = (isset($NTPresage)) ? $NTPresage : false;

// Analyze Use of Tactics
	$Pl->Tactics = GetTactics($Pl_GTctcs);
	$Pl->checkTactics($Pl_GTctcs);

	$Op->Tactics = selectOpponentTactic($Op->Player['tactics']);

	$Pl->initSpCost();
	$Op->initSpCost();
	$Pl->iniFixes();
	$Op->iniFixes();

	// Analyze Hypermode State
	$Pl->analyzeHypermodeState();
	// Grant DefX to Enhanced Hypermode
	$Pl->analyzeEnhHM();

// Process MS
	$Pl->ProcessMS();
	if ($AtkFortFlag != 1) $Op->ProcessMS();
	else{
		$Op->MS = Array(
		'id' => 'Fortress', 'msname' => $Pl->Player['coordinates'].'區域要塞',
		'atf' => $Area_At, 'def' => $Area_De, 'ref' => 0, 'taf' => $Area_Ta,
		'hpfix' => 0, 'enfix' => 0, 'needlv' => 200000, 'price' => 0,
		'spec' => 'AntiDam', 'image' => 'fortress.gif');
	}

// Repair Opponent
	if(!$isAtkFortName){
		$Op_Repaired = RepairPlayer($Op->Player,$Op->Eq['D'],$Op->Eq['E']);
		$Op->Player['hp'] = $Op_Repaired['hp'];
		$Op->Player['en'] = $Op_Repaired['en'];
		$Op->Player['sp'] = $Op_Repaired['sp'];
		$Op->Player['status'] = $Op_Repaired['status'];
	}

// Process Opponent Weapon Data
	$Op->ProcessAllWeapon();

// Apply Condition Bonus & Penalty
	$Pl->apply_condition_bonus();
	$Op->apply_condition_bonus();

// Calculate Extra SP Cost - Player
	$Pl->calc_extra_sp_cost();
	$Op->calc_extra_sp_cost(0.5);

// Calculate Required EN, Including tactics' special effect
	$Pl->calc_required_en();
	$Op->calc_required_en();

// Check if allowed to start battle
// Checks id of main weapon, if EN and SP is adequate
	$Pl->checkStart();

//
// End of Pre-phase I, Start Pre-phase II
//

// Set Spec Sub-System: Check Requirements
	$Pl->checkSetSpec();
	$Op->checkSetSpec();
	if($Pl->SetSpecID || $Op->SetSpecID){
		// Include Interface
		include_once('includes/spc/spc.superclass.php');
		// Include Implementation Classes
		if($Pl->SetSpecID){
			include_once('includes/spc/spc.'.$Pl->SetSpecID.'.class.php');
			$str = '$Pl->SetSpec = new sSpc_'.$Pl->SetSpecID.'($Pl);';
			eval($str);
			$Pl->SetSpec->checkSetActivation();
			$Pl->SetSpec->prephase();
		}
		if($Op->SetSpecID){
			include_once('includes/spc/spc.'.$Op->SetSpecID.'.class.php');
			$str = '$Op->SetSpec = new sSpc_'.$Op->SetSpecID.'($Op);';
			eval($str);
			$Op->SetSpec->checkSetActivation();
			$Op->SetSpec->prephase();
		}
	}

// Apply Weapon/Equipment Type Custom Limitations
	$Pl->applyTypeCustoms();
	$Op->applyTypeCustoms();

// Trans-AM System & GN-Customs
	$UpdateMSFlag = array('Pl' => false, 'Op' => false);
	$Pl->processGundam00specs($UpdateMSFlag['Pl']);
	$Op->processGundam00specs($UpdateMSFlag['Op']);
	// Apply JS Update
	$Pl_MS_JSUpdate = '';
	if($UpdateMSFlag['Pl'] && $Game_Scrn_Type == 0){
		if ($Pl->Player['ms_custom']) $temp = explode('<!>',$Pl->Player['ms_custom']);
		else $temp = array(0,0,0,0,0);
		$Pl_MS_JSUpdate  = "parent.document.getElementById('ms_at').innerHTML = ".($Pl->MS['atf']-$temp[1]).";";
		$Pl_MS_JSUpdate .= "parent.document.getElementById('ms_at').style.color = '".colorConvert(($Pl->MS['atf']-$temp[1]),50)."';";
		$Pl_MS_JSUpdate .= "parent.document.getElementById('ms_de').innerHTML = ".($Pl->MS['def']-$temp[2]).";";
		$Pl_MS_JSUpdate .= "parent.document.getElementById('ms_de').style.color = '".colorConvert(($Pl->MS['def']-$temp[2]),50)."';";
		$Pl_MS_JSUpdate .= "parent.document.getElementById('ms_re').innerHTML = ".($Pl->MS['ref']-$temp[3]).";";
		$Pl_MS_JSUpdate .= "parent.document.getElementById('ms_re').style.color = '".colorConvert(($Pl->MS['ref']-$temp[3]),50)."';";
		$Pl_MS_JSUpdate .= "parent.document.getElementById('ms_ta').innerHTML = ".($Pl->MS['taf']-$temp[4]).";";
		$Pl_MS_JSUpdate .= "parent.document.getElementById('ms_ta').style.color = '".colorConvert(($Pl->MS['taf']-$temp[4]),50)."';";
		$Pl_MS_JSUpdate .= "parent.document.ms_img.src = '".$Unit_Image_Dir.'/'.$Pl->MS['image']."';";
	}
//End Trans-AM System

//Start Battle
	echo "<table width=100% border='0' style=\"border-collapse: collapse\" align=center style=\"font-size: 12pt;font-family: Comic Sans MS;\" cellspacing=0 cellpadding=0>";
	echo "<tr height=50 valign=bottom align=center>";
	echo "<td bgcolor=".$Pl->Player['color']." width=50%><font face=\"Comic Sans MS\" style=\"font-size: 24pt;\"><b style=\"color: ".invertColor($Pl->Player['color'])."\">".$Pl->Player['gamename']."</b></font></td>";
	echo "<td bgcolor=".$Op->Player['color']." width=50%><font face=\"Comic Sans MS\" style=\"font-size: 24pt;\"><b style=\"color: ".invertColor($Op->Player['color'])."\">".$Op->Player['gamename']."</b></font></td>";
	echo "</tr>";
	echo "<tr valign=center align=center>";
	echo "<td><br><br><img src=".$Unit_Image_Dir.'/'.$Pl->MS['image'].'><br></td>';
	echo "<td><br><br><img src=".$Unit_Image_Dir.'/'.$Op->MS['image'].'><br></td>';
	echo "</tr>";
	echo "<tr valign=center align=center>";
	echo '<td><br>'.$Pl->MS['msname'].'<br></td>';
	echo '<td><br>'.$Op->MS['msname'].'<br></td>';
	echo "</tr>";

//
// Spec-pooling Phase / Meta-phase
//

	//Generate Special Ability Pool
		$Pl->generateSpecialAbilityPool();
		$Op->generateSpecialAbilityPool();
	//Set Spec Meta-phase
		if($Pl->SetSpecID) $Pl->SetSpec->metaphase();
		if($Op->SetSpecID) $Op->SetSpec->metaphase();
	//SEED Mode
		$Pl->analyseSeedMode($SEEDStat);
		$Op_NewSeed = $Op->analyseSeedMode(true, false, 2);
	//EXAM System
		actDeacEXAM($Pl,$EXAMStat);
		$Pl->applyEXAM();
		$Op->applyEXAM();
	//NT Presage Ability Activation & Deactivation
		actDeacPresage($Pl,$NTPresage);
	//SEED Mode & EXAM System SP Requirement
		if (($Pl->Player['hypermode'] == 1 || $Pl->Player['hypermode'] == 5) && $SEEDStat)	$Pl->SP_Cost += 20;
		if ($Pl->Player['hypermode'] >= 4 && $Pl->Player['hypermode'] <= 6 && $EXAMStat)	$Pl->SP_Cost += 20;
	//Modify Opponent EN Requirement
		$Op->RequireEN = ceil( $Op->RequireEN / 3 );
	//Assign Variables
		$Spec_Event_Tag = '';
		$OpNoENFlag = $Result_Tag = $UpD_Pl_level = $UpD_Op_level = false;
		$Pl_Base_Stat['attacking'] = $Pl->Player['attacking'];
		$Pl_Base_Stat['defending'] = $Pl->Player['defending'];
		$Pl_Base_Stat['reacting'] = $Pl->Player['reacting'];
		$Pl_Base_Stat['targeting'] = $Pl->Player['targeting'];
	//Process Special Fixing Effects
		$Pl->applySpecFixEffects($Spec_Event_Tag);
		$Op->applySpecFixEffects($Spec_Event_Tag,false);
	//Specs - Requirements
		$Pl->deterSpecRequirements();
		$Op->deterSpecRequirements();
	//Apply Bonus Ability Points
		$Pl->applyBonus();
		$Op->applyBonus();
	//Special Abilities and Special Effects For MS
		$Pl->applyEffectsForMS($Op);
	//Spec - Counter Strike
		$CS_Flag['Pl'] = tryCounterStrike($Pl->Specs,$Op->Specs,$Pl->Player['level'],$Op->Player['level'],$Spec_Event_Tag);
		$CS_Flag['Op'] = tryCounterStrike($Op->Specs,$Pl->Specs,$Op->Player['level'],$Pl->Player['level'],$Spec_Event_Tag,false);
	//NT Presage Effect
		$NTP_Flag['Pl'] = tryPresage($Pl->Player['spec'],$Pl->Eq['D']['exp']);
		$NTP_Flag['Op'] = tryPresage($Op->Player['spec'],$Op->Eq['D']['exp']);

//
// Battle Phase
//

	//Set Spec Battle-phase
		if($Pl->SetSpecID) $Pl->SetSpec->battlephase();
		if($Op->SetSpecID) $Op->SetSpec->battlephase();

	//Calculate Hit Times and Damage Values
		unset($Calc,$Dealt,$Strike);
		if(!$CS_Flag['Op']){
			$Calc['Pl'] = ReturnHitDam($Pl->Eq['A']['atk'],$Pl->Eq['A']['rd'],$Pl->Eq['A']['hit'],$Pl->MS['atf'],$Op->MS['def'],$Op->MS['ref'],$Pl->MS['taf'],$Pl->Player['attacking'],$Op->Player['defending'],$Op->Player['reacting'],$Pl->Player['targeting'],$Pl->Specs,$Op->Specs,$Pl->Eq['A']['range'],$Op->Eq['A']['range'],$Pl->Eq['A']['attrb'],$Op->Eq['A']['attrb']);
			$Dealt['Pl'] = $Calc['Pl'][0];
			$Strike['Pl'] = $Calc['Pl'][1];
		}
		else {
			$Dealt['Pl'][0] = $Strike['Pl'][0] = 0;
		}
		if((($Op->Player['en'] - $Op->RequireEN) > 0) && !$CS_Flag['Pl']){
			$Calc['Op'] = ReturnHitDam($Op->Eq['A']['atk'],$Op->Eq['A']['rd'],$Op->Eq['A']['hit'],$Op->MS['atf'],$Pl->MS['def'],$Pl->MS['ref'],$Op->MS['taf'],$Op->Player['attacking'],$Pl->Player['defending'],$Pl->Player['reacting'],$Op->Player['targeting'],$Op->Specs,$Pl->Specs,$Op->Eq['A']['range'],$Pl->Eq['A']['range'],$Op->Eq['A']['attrb'],$Pl->Eq['A']['attrb']);
			$Dealt['Op'] = $Calc['Op'][0];
			$Strike['Op'] = $Calc['Op'][1];
		}
		else {
			$OpNoENFlag=1;
			$Dealt['Op'][0] = $Strike['Op'][0] = 0;
		}
		//Total Damages
		$Damage['Pl'] = array_sum($Dealt['Pl']);
		$Damage['Op'] = array_sum($Dealt['Op']);
		$Strikes['Pl'] = array_sum($Strike['Pl']);
		$Strikes['Op'] = array_sum($Strike['Op']);
	//Spec - First Strike
	//	$FirstStrikeFlag['Pl'] = analyzeFirstStrike($Pl->Specs, $Pl->Eq['A']['range'], $Op->Eq['A']['range']);
	//	$FirstStrikeFlag['Op'] = analyzeFirstStrike($Op->Specs, $Op->Eq['A']['range'], $Pl->Eq['A']['range']);
		$FirstStrikeFlag['Pl'] = analyzeFirstStrike($Pl->Specs, $Pl->Eq, $Op->Eq);
		$FirstStrikeFlag['Op'] = analyzeFirstStrike($Op->Specs, $Op->Eq, $Pl->Eq);

		if(tryFirstStrike($Pl, $Op, $Damage['Pl'], $FirstStrikeFlag['Pl'], $FirstStrikeFlag['Op'])){
			unset($Dealt['Op'],$Strike['Op']);
			$Dealt['Op'][0] = $Strike['Op'][0] = $Damage['Op'] = 0;
			$Spec_Event_Tag .="<br>你的先制攻擊把對方即時擊破！";
		}
		if(tryFirstStrike($Op, $Pl, $Damage['Op'], $FirstStrikeFlag['Op'], $FirstStrikeFlag['Pl'])){
			unset($Dealt['Pl'],$Strike['Pl']);
			$Dealt['Pl'][0] = $Strike['Pl'][0] = $Damage['Pl'] = 0;
			$Spec_Event_Tag .="<br>對方的先制攻擊把你即時擊破！";
		}

//
// Post-Battle Phase
//

	//Calculate Left HP and EN
		$Damage['Pl'] += $Op->Tactics['hpc'];
		$Damage['Op'] += $Pl->Tactics['hpc'];
		$Exp_By_Damage['Pl'] = $Exp_By_Damage['Op'] = 0;

		for($i=0;$i<=1;$i++){
			$j = ( $i == 0 ) ? 'Pl' : 'Op';
			$k = ( $i == 0 ) ? 'Op' : 'Pl';
			if($$j->Player['hp'] > $$j->Player['hpmax']) $$j->Player['hp'] = $$j->Player['hpmax'];
			if($$j->Player['en'] > $$j->Player['enmax']) $$j->Player['en'] = $$j->Player['enmax'];
			$Exp_By_Damage[$j] = ($Damage[$j] > $$k->Player['hp']) ? $$k->Player['hp'] : $Damage[$j];
			if($$k->Player['hpmax'] > 0)
				$Exp_By_Damage[$j] /= $$k->Player['hpmax'];
			else	$Exp_By_Damage[$j] = 0;
			$Resulting_HP[$j] = $$j->Player['hp'] - $Damage[$k];
			$Resulting_EN[$j] = $$j->Player['en'] - $$j->RequireEN;
			if ($Resulting_HP[$j] < 0 && !$NTP_Flag[$j]) $Resulting_HP[$j] = 0;
			elseif($Resulting_HP[$j] < 0 && $NTP_Flag[$j]) {$Resulting_HP[$j] = $$j->Player['hp'];$NTP_Flag[$j]++;$$j->Eq['D']['exp'] -= 2500;}
			if ($Resulting_EN[$j] < 0) $Resulting_EN[$j] = 0;
		}

		$Resulting_SP['Pl'] = floatval($Pl->Player['sp'] - intval($Pl->SP_Cost));
		if($Resulting_SP['Pl'] < 0) $Resulting_SP['Pl'] = 0;
		if($Op->SP_Cost){
			$Resulting_SP['Op'] = floatval($Op->Player['sp'] - $Op->SP_Cost);
			if($Resulting_SP['Op'] < 0) $Resulting_SP['Op'] = 0;
		}
	//NT Presage Message
		if($NTP_Flag['Pl'] == 2) $Spec_Event_Tag .="<br>預料到對方致命攻擊！只有輔助裝備被損壞！";
		if($NTP_Flag['Op'] == 2) $Spec_Event_Tag .="<br>對方預料到你的致命攻擊！只能損壞輔助裝備！";
	//Analyze Results
		//VictoryFlag: 0=no results, 1=victory, 2=lost, 3=both lost
		unset($HistoryWrite);
		$fortDestroyed=$VictoryFlag=0;
		if ($Resulting_HP['Pl'] > 0 && $Resulting_HP['Op'] <= 0){
			$Op->Player['status'] = '1';
			$Resulting_HP['Op'] = 0;
			if ($isAtkFortName){
				$Pl->Player['fame']+=20;
				if (mt_rand(0,100) >= 75) $Pl->Player['growth'] += 1;
				$fortDestroyed = 1;
				$HistoryWrite = "<font color=$Pl_Org[color]>$Pl_Org[name]</font>的<font color=".$Pl->Player['color'].">".$Pl->Player['gamename']."</font>，成功\攻陷由<font color=$Area_Org[color]>$Area_Org[name]統治下的".$Pl->Player['coordinates']."區域</font>！";
				WriteHistory($HistoryWrite);
			}
			if ($Op->Player['fame'] < 0){
				if (rand(0,100) > 80) $Pl->Player['fame']++;
				if (rand(0,100) > 90) $Op->Player['fame']++;
			}
			$VictoryFlag = 1;
		}
		elseif ($Resulting_HP['Pl'] <= 0){
			$Pl->Player['status'] = '1';
			$VictoryFlag = 2;
			$Resulting_HP['Pl'] = 0;
			if ($Resulting_HP['Op'] <= 0){
				$Op->Player['status'] = '1';
				$VictoryFlag = 3;
				$Resulting_HP['Op'] = 0;
				if ($isAtkFortName){
					$Pl->Player['fame']+=5;
					if(mt_rand(0,100) >= 90)$Pl->Player['growth'] += 1;
					$fortDestroyed = 1;
					$HistoryWrite = "<font color=$Pl_Org[color]>$Pl_Org[name]</font>的<font color=".$Pl->Player['color'].'>'.$Pl->Player['gamename']."</font>，成功\攻陷由<font color=$Area_Org[color]>$Area_Org[name]統治下的".$Pl->Player['coordinates']."區域</font>！";
					WriteHistory($HistoryWrite);
				}
			}
			else if (rand(0,100) > 80 && $Pl->Player['fame'] > 0) $Pl->Player['fame']--;
		}
		//Organization War - Calculate Lost Tickets
			$ticketLoss = array('Pl' => 0, 'Op' => 0);
			if($isEnemyFlag > 0){
				foreach($ticketLoss as $i => $v){
					// Ticket Loss Amount Formulae
					$ticketLoss[$i] = $$i->MS['needlv']*4 + pow(log($$i->MS['price']),2)*0.5 + pow($$i->Eq['A']['complexity'],2)*2 + $$i->Player['level'] + $$i->Player['hpmax']*0.002 + $$i->Player['enmax'] * 0.04;
					// Defenders Lose Less - at half rate
					if(in_array($$i->Player['name'],$Defenders)) $ticketLoss[$i] *= 0.5;
					// Survival - Very Low Tick Loss
					if($VictoryFlag == 0) $ticketLoss[$i] *= 0.05;
					elseif(($VictoryFlag == 1 && $i == 'Pl') || ($VictoryFlag == 2 && $i == 'Op')) $ticketLoss[$i] = 0;
					// Finalize, decrease loss by factor
					$ticketLoss[$i] = ceil($ticketLoss[$i]/15);
				}
			}
		//Fame and Notorous Modifier
			$AtkOnline = 0;
			if ($CFU_Time - $Op->Player['time2'] < $Offline_Time){
				$AtkOnline = 1;
				if($isEnemyFlag) $AtkOnline = 2;
			}
			// No Ticket Calculation For Attacking Offline People
			// Defenders Lose Tickets regardless
			if ($ticketLoss['Op'] && !$AtkOnline && !in_array($Op->Player['name'],$Defenders)) $ticketLoss['Op'] = 0;
			if ($isAtkFortName){
				if (!$fortDestroyed) $ticketLoss['Op'] = 0;  //No Ticket Calculation For Attacking Offline People & Fort
				else  $ticketLoss['Op'] = $ticketMax;                //Destroy Fort
			}
			if ($Op->Player['fame'] < 0){
				if (mt_rand(0, 99) > 95) $Pl->Player['fame']++;
				if (mt_rand(0, 99) > 80) $Op->Player['fame']++;
				if ($AtkOnline == 1){
					if (mt_rand(0, 99) > 5) $Pl->Player['fame']++;
					if (mt_rand(0, 99) > 20) $Op->Player['fame']++;
				}
			}
			if ($Op->Player['fame'] >= 0 && $AtkOnline == 1){
				$Pl->Player['fame']--;
				$Pl->Player['bounty']+=100;
				if ($Pl->Player['fame'] < 0)
				$Pl->Player['bounty']+=25*abs($Pl->Player['fame']);
				if ($Pl->Player['fame'] < -10)
				$Pl->Player['bounty']+=900;
				if ($Pl->Player['fame'] < -50)
				$Pl->Player['bounty']+=9000;
				if ($Pl->Player['fame'] < -100)
				$Pl->Player['bounty']+=floor(10*abs($Pl->Player['fame']-1));
			}
			//Modify by Level
			if ($AtkOnline == 1 && $Op->Player['fame'] >= 0){
				if ($Pl->Player['level']-$Op->Player['level'] > 25)$Pl->Player['fame']--;
				if ($Pl->Player['level']-$Op->Player['level'] > 35)$Pl->Player['fame']-=4;
			}
		//Calculate Strike Percentage
			$StrikePercentage['Pl'] = ($Strikes['Pl'] / $Pl->Eq['A']['rd']) * 100;
			$StrikePercentage['Op'] = ($Strikes['Op'] / $Op->Eq['A']['rd']) * 100;
		//Special Event Status
			$DamA_S_Flag = array('Pl' => 0, 'Op' => 0);		// DamA Analysis Flags, 武器特效 - 機體損壞
			$Pl->msDamageSpec($Spec_Event_Tag, $Resulting_EN['Op'], $DamA_S_Flag['Pl'], $StrikePercentage['Pl']);
			$Op->msDamageSpec($Spec_Event_Tag, $Resulting_EN['Pl'], $DamA_S_Flag['Op'], $StrikePercentage['Op'], false);

		//Special Event Status
			//武器特效 - 戰鬥不能
			if(!getAntiDamFlag($Pl)){
				if(tryDamB($Pl, $Op, $VictoryFlag, 0, 2)) $Spec_Event_Tag .="<br>對手的機體被損壞，戰鬥不能！";
			}
			if(!getAntiDamFlag($Op)){
				if(tryDamB($Op, $Pl, $VictoryFlag, 0, 1)) $Spec_Event_Tag .="<br>你的機體被對手損壞，戰鬥不能，需要修理！";
			}

//
// Reward Phase
//

		//Gain Experience & Primary Weapon Condition Level
			$Pl_Gain_Wep_Exp = $Op_Gain_Wep_Exp = $Pl_Gain_Exp = $Op_Gain_Exp = 0;
			$Pl_Gain_Exp = (pow($Op->Player['level'],2)) + ($Pl->Player['rank']*0.01) + ($Op->Player['rank']*0.02);
			$Op_Gain_Exp = (pow($Pl->Player['level'],2))*0.1 + ($Pl->Player['rank']*0.002);
			$Pl_Gain_Exp *= $Exp_By_Damage['Pl'];
			$Op_Gain_Exp *= $Exp_By_Damage['Op'];
			$Pl_Gain_Wep_Exp = 5;
			$Op_Gain_Wep_Exp = 1;
			switch($VictoryFlag){
				case 1: $Op_Gain_Exp *= 0.7;$Op_Gain_Wep_Exp *= 0.7;break;
				case 3: $Pl_Gain_Exp *= 0.8;$Pl_Gain_Wep_Exp *= 0.8;$Op_Gain_Exp *= 0.8;$Op_Gain_Wep_Exp *= 0.8;break;
				case 2: $Pl_Gain_Exp *= 0.7;$Pl_Gain_Wep_Exp *= 0.7;break;
			}
		//Equipment Condition Level Changes (Exp)
			$Eq_Impact['Pl'] = $Eq_Impact['Op'] = $Eq_Damaging_Flag['Pl'] = $Eq_Damaging_Flag['Op'] = 0;
			if (($Resulting_HP['Op'] < $Op->Player['hpmax']/2 && $StrikePercentage['Pl'] >= (70 - $DamA_S_Flag['Pl']))) $Eq_Damaging_Flag['Pl'] = 1;
			if (strpos($Pl->Specs,'PrecisionStrike') !== false) $Eq_Damaging_Flag['Pl'] ++;
			if (($Resulting_HP['Pl'] < $Pl->Player['hpmax']/2 && $StrikePercentage['Op'] >= (70 - $DamA_S_Flag['Op']))) $Eq_Damaging_Flag['Op'] = 1;
			if (strpos($Op->Specs,'PrecisionStrike') !== false) $Eq_Damaging_Flag['Op'] ++;
			if($AtkOnline){
				if($Eq_Damaging_Flag['Pl']) {
					$Eq_Impact['Op'] = 5 * $Eq_Damage_Co * $Eq_Damage_On_Co;
					if($VictoryFlag == 1 || $VictoryFlag == 3) $Eq_Impact['Op'] += $Eq_Damage_Ex;
					//Precision Attack Special Effects
					if($Eq_Damaging_Flag['Pl'] == 2) $Eq_Impact['Op'] *= 5;
					if($isEnemyFlag) $Eq_Impact['Op'] *= 2;
				}
				if($Eq_Damaging_Flag['Op']) {
					$Eq_Impact['Pl'] = 5 * $Eq_Damage_Co * $Eq_Damage_On_Co;
					if($VictoryFlag == 2 || $VictoryFlag == 3) $Eq_Impact['Pl'] += $Eq_Damage_Ex;
					//Precision Attack Special Effects
					if($Eq_Damaging_Flag['Op'] == 2) $Eq_Impact['Pl'] *= 5;
					if($isEnemyFlag) $Eq_Impact['Pl'] *= 2;
				}
			}else{
				if($Eq_Damaging_Flag['Pl']) $Eq_Impact['Op'] = 5 * $Eq_Damage_Co;
				if($Eq_Damaging_Flag['Op']) $Eq_Impact['Pl'] = 5 * $Eq_Damage_Co;
			}
			if($Pl->Player['level'] > $Op->Player['level'] + $Eq_Damage_ReduceLvGap) $Eq_Impact['Op'] = floor($Eq_Impact['Op']/2);

			//Condition Effects on Specific Equipment
				$Eq_Ava_EqPos = array('A','D','E');	//Possible Equipment Class to be damaged
				$Eq_Cond_Bonus = $Eq_Equipment_Struck = array('Pl' => 0, 'Op' => 0);
				for($i=0;$i<=1;$i++){
					$j = ($i) ? 'Op' : 'Pl';
					$k = (!$i) ? 'Op' : 'Pl';
					//Condition Damage
						$l = mt_rand(0,2);
						$Eq_Equipment_Struck[$j] = $Eq_Ava_EqPos[$l];
						if($$j->Eq[$Eq_Equipment_Struck[$j]]['id'] == 0) $Eq_Equipment_Struck[$j] = 'A';
					//Condition Bonus on Equipment & Permanent Equipment
					if(!$Eq_Damaging_Flag[$k]){
						$Eq_Cond_Bonus[$j] += $Eq_Cond_Bonus_Basic;
						if($VictoryFlag == 1 && !$i){
							$Eq_Cond_Bonus[$j] *= $Eq_Cond_Bonus_ExCo;
							if($AtkOnline) $Eq_Cond_Bonus[$j] *= $Eq_Cond_Bonus_ExCo;
						}
						elseif($VictoryFlag == 2 && $i){
							$Eq_Cond_Bonus[$j] += $Eq_Cond_Bonus_Basic*$Eq_Cond_Bonus_ExCo;
						}
					}
				}

			//Extra Gain for Primary Weapon
				$PlBWGain= mt_rand(Floor($StrikePercentage['Pl']/30),Floor($StrikePercentage['Pl']/10));
				$OpBWGain= mt_rand(Floor($StrikePercentage['Op']/60),Floor($StrikePercentage['Op']/20));
				$Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp + $PlBWGain;
				$Op_Gain_Wep_Exp = $Op_Gain_Wep_Exp + $OpBWGain;
			//Level Gap Experience Fix
				if ($Pl->Player['level']-$Op->Player['level'] > 35){
					$Pl_Gain_Exp /= 2;
					if ($Pl->Player['level']-$Op->Player['level'] > 50)
						$Pl_Gain_Exp /= 2;
					$Pl_Gain_Wep_Exp /= 2;
				}

				//Equipment Condition
				if ($Eq_Cond_Bonus['Pl'] > 0){
					$Eq_Cond_Bonus['Pl'] = floor($Eq_Cond_Bonus['Pl'] * ($Op->Player['level']/$Pl->Player['level']));
				}
				if ($Eq_Cond_Bonus['Op'] > 0){
					$Eq_Cond_Bonus['Op'] = floor($Eq_Cond_Bonus['Op'] * ($Pl->Player['level']/$Op->Player['level']));
				}

		//Gain Rankings
			$Rank_Gain = 0;
			if ($VictoryFlag == 1) {
				$Rank_Gain += Ceil($Op->Player['rank']/4000)+8;
				if ($isEnemyFlag)    $Rank_Gain *= 10;
				if ($isAtkFortName)  $Rank_Gain += 4000;
			}
			elseif ($VictoryFlag == 0)                   $Rank_Gain += Ceil($Op->Player['rank']/8000);
			elseif ($VictoryFlag == 2 && !$isEnemyFlag)  $Rank_Gain -= 40;
			elseif ($VictoryFlag == 3)                   $Rank_Gain += 1;
			// Penalize rank gainings for neutral
			$Pl->Player['rank'] += ($Pl->Player['organization'] == 0) ? floor($Rank_Gain/2) : ceil($Rank_Gain);
			// Adjustment to Limits
			if ($Pl->Player['rank'] > 100000)   $Pl->Player['rank'] = 100000;
			elseif ($Pl->Player['rank'] < 0)    $Pl->Player['rank'] = 0;

	//Finalize Experience Gain
		//Spec
			if(strpos($Pl->Specs,'DoubleExp') !== false){$Pl_Gain_Exp*=2; $Pl_Gain_Wep_Exp*=2;}
		//Fame and Notoriety Modifier
			if($Pl->Player['fame'] < 0){
				$Pl_Gain_Wep_Exp *= 1 + ($Pl->Player['fame']/1000);
			}
			if($Op->Player['fame'] < 0){
				$Op_Gain_Wep_Exp *= 1 + ($Op->Player['fame']/1000);
			}
		//Finalize
			$Pl_Gain_Wep_Exp = floor($Pl_Gain_Wep_Exp);
			$Op_Gain_Wep_Exp = floor($Op_Gain_Wep_Exp);
			$Pl_Gain_Exp = floor($Pl_Gain_Exp+10);
			$Op_Gain_Exp = floor($Op_Gain_Exp+1);
			if ($Pl_Gain_Exp < 0) $Pl_Gain_Exp = 0;
			if ($Op_Gain_Exp < 0) $Op_Gain_Exp = 0;
			if ($Pl->Player['fame'] > 1000)  $Pl->Player['fame'] = 1000;
			if ($Pl->Player['fame'] < -1000) $Pl->Player['fame'] = -1000;
		//Experience Multiplier
			$Pl_Gain_Exp *= $Exp_Multiplier;
			$Op_Gain_Exp *= $Exp_Multiplier;
			$Pl_Gain_Wep_Exp *= $Exp_Multiplier;
			$Op_Gain_Wep_Exp *= $Exp_Multiplier;
		//Update All Experiences
			$Pl->Player['expr'] = $Pl->Player['expr'] + $Pl_Gain_Exp;
			$Op->Player['expr'] = $Op->Player['expr'] + $Op_Gain_Exp;
			$Pl->Eq['A']['exp'] = $Pl->Eq['A']['exp'] + $Pl_Gain_Wep_Exp;
			$Op->Eq['A']['exp'] = $Op->Eq['A']['exp'] + $Op_Gain_Wep_Exp;
		//Update Equipment Condition
			$Eq_Cond_Bonus['Op'] = floor(0.2*$Eq_Cond_Bonus['Op']);
			for($i=0;$i<=1;$i++){
				$j = ($i) ? 'Op' : 'Pl';
				if($Eq_Cond_Bonus[$j]){
					if($$j->Eq['D']['id']) $$j->Eq['D']['exp'] = $$j->Eq['D']['exp'] + $Eq_Cond_Bonus[$j];
					if($$j->Eq['E']['id']) $$j->Eq['E']['exp'] = $$j->Eq['E']['exp'] + $Eq_Cond_Bonus[$j];
				}
				if($$j->Player['level'] < $Eq_Damage_IgnoreLv) $Eq_Impact[$j] = 0;
				else{
					$tmpResult = $$j->Eq[$Eq_Equipment_Struck[$j]]['exp'] - floor($Eq_Impact[$j]);
					if($tmpResult < $Eq_Damage_Off_lim && !$AtkOnline){
						// Protective Measure For attacking offline people
						if($$j->Eq[$Eq_Equipment_Struck[$j]]['exp'] > $Eq_Damage_Off_lim){
							$Eq_Impact[$j] = $$j->Eq[$Eq_Equipment_Struck[$j]]['exp'] - $Eq_Damage_Off_lim;
							$$j->Eq[$Eq_Equipment_Struck[$j]]['exp'] = $Eq_Damage_Off_lim;
						}else	$Eq_Impact[$j] = 0;
					}else{
						$$j->Eq[$Eq_Equipment_Struck[$j]]['exp'] = $tmpResult;
					}
				}
				foreach($Eq_Ava_EqPos as $v){
					if ($$j->Eq[$v]['exp'] > $Max_Wep_Exp) $$j->Eq[$v]['exp'] = $Max_Wep_Exp;
					elseif($$j->Eq[$v]['exp'] < $Min_Wep_Exp) $$j->Eq[$v]['exp'] = $Min_Wep_Exp;
				}
			}

		//Update Weapon Info
		$Eq_Update = array();
			for($i=0;$i<=1;$i++){
				$j = ($i) ? 'Op' : 'Pl';
				unset($v,$w);
				foreach($Eq_Ava_EqPos as $v){
					switch($v){
						case 'A': $w = 'wepa';break;
						case 'D': $w = 'eqwep';break;
						case 'E': $w = 'p_equip';break;
					}
					$Eq_Update[$j][$v] = explode('<!>',$$j->Player[$w]);
					$Eq_Update[$j][$v][1] = $$j->Eq[$v]['exp'];
					$$j->Player[$w] = implode('<!>',$Eq_Update[$j][$v]);
				}
			}
		//Update Equipment Info
	//Gain Money
		$Pl_Gain_Money = 0;
		$PlMoneyBGain = mt_rand(($Op->Player['level']*200),($Op->Player['level']*250));
		if ($VictoryFlag == 1)     $Pl_Gain_Money = $PlMoneyBGain;
		elseif ($VictoryFlag == 0) $Pl_Gain_Money = $PlMoneyBGain/10;
		elseif ($VictoryFlag == 3) $Pl_Gain_Money = $PlMoneyBGain/25;
		$Pl_Gain_Money = Floor($Pl_Gain_Money + $Op->Player['rank']/100);
		if(strpos($Pl->Specs,'DoubleMon') !== false) $Pl_Gain_Money *= 2;
		if($Exp_Multiplier > 1) $Pl_Gain_Money *= $Exp_Multiplier;
		if($Strikes['Pl'] == 0) $Pl_Gain_Money = 0;
		$Pl->Player['cash'] += $Pl_Gain_Money;
		//Gain Bounty
		$Gain_Bounty = 0;
		if ($Op->Player['bounty'] > 100 && $VictoryFlag == 1){
			if ($Op->Player['bounty'] <= 50000) $Gain_Bounty = $Op->Player['bounty'];
			elseif ($Op->Player['bounty'] <= 100000) $Gain_Bounty = Floor($Op->Player['bounty']*0.5);
			else $Gain_Bounty = floor($Op->Player['bounty']*0.1);

			$Op->Player['bounty'] -= $Gain_Bounty;

			if ($Gain_Bounty){
			$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_bank` SET `savings` = `savings`+$Gain_Bounty WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($sql);unset($sql);}

			$Gain_BountyFlag = '1';
		}

	// Update Log Tag according to VictoryFlag
		$Salary = 0;
		switch ($VictoryFlag){
			case '1':
				$Result_Tag .="<br>你把對手擊破！";
				$Pl_Log_Tag ="對手的".$Op->MS['msname']."被你擊破！";
				$Op_Log_Tag ="你被對手的".$Pl->MS['msname']."擊破。";
				// Increase Victory Counts, Pay Salary
				$Pl->Player['victory']  += 1;
				$Pl->Player['v_points'] += 1;
				$Salary = floor($Pl->Player['rank']*0.075);
				if($Pl->Player['fame'] > 0) $Salary += floor($Pl->Player['fame'] / 100 * abs($Op->Player['fame']));
				$Pl->Player['cash'] += $Salary;
			break;
			case '2':
				$Result_Tag .="<br>你被對手擊破。";
				$Pl_Log_Tag ="你被對手的".$Op->MS['msname']."擊破。";
				$Op_Log_Tag ="對手的".$Pl->MS['msname']."被你擊破！";
			break;
			case '3':
				$Result_Tag .="<br>你與對手兩敗俱傷。";
				$Pl_Log_Tag = "你與對手兩敗俱傷。";
				$Op_Log_Tag = "對手與你兩敗俱傷。";
			break;
			default:
				$Result_Tag .="<br>你與對手的戰鬥沒有分出勝負。";
				$Pl_Log_Tag = "你與對手的戰鬥沒有分出勝負。";
				$Op_Log_Tag = "對手與你的戰鬥沒有分出勝負。";
		}
	//Level Up
		if ($Pl->Player['level'] < 150) CalcExp($Pl->Player['level']);
		else {$UserNextLvExp = 99999999999;$Pl->Player['expr'] = 0;}
		if ($Op->Player['level'] < 150) CalcExp($Op->Player['level'],'OppoNextLvExp');
		else {$OppoNextLvExp = 99999999999;$Op->Player['expr'] = 0;}
		CalcStatPt('Pl',$Pl->Player['level']);
		CalcStatPt('Op',$Op->Player['level']);
		if ($Pl->Player['expr'] >= $UserNextLvExp){$Pl->Player['level'] += 1;$Pl->Player['spmax'] += 1;if($Pl->Player['level']%10==0)$Pl->Player['spmax'] += 5;$Pl->Player['expr'] = 0;$Pl->Player['growth'] = $Pl->Player['growth'] + $Pl_Stat_Gain;$Result_Tag .="<br>你升了級！<br>獲得 $Pl_Stat_Gain 點成長點數！";$UpD_Pl_level='1';}
		if ($Op->Player['expr'] >= $OppoNextLvExp){$Op->Player['level'] += 1;$Op->Player['spmax'] += 1;if($Op->Player['level']%10==0)$Op->Player['spmax'] += 5;$Op->Player['expr'] = 0;$Op->Player['growth'] = $Op->Player['growth'] + $Op_Stat_Gain;$Result_Tag .="<br>對手升了級！";$UpD_Op_level='1';}

//
// Information Update / Database Phase
//

	//Organization War Ticketing results
		if($isEnemyFlag){
			$W_ID = $lostSet = $sideTicket = array();
			$War_Victory_Flag = false;
			$W_rt['Op'] = "<br><font color=$Op_Org[color]>$Op_Org[name]</font>軍力損失了 <b>".number_format($ticketLoss['Op'])."</b> 點。";
			$W_rt['Pl'] = "<br><font color=$Pl_Org[color]>$Pl_Org[name]</font>軍力損失了 <b>".number_format($ticketLoss['Pl'])."</b> 點。";
			switch($isEnemyFlag){
				case 1:
					$W_ID[1] = $Op_Org['optmissioni'];
					$W_ID[2] = $Pl_Org['optmissioni'];
					$lostSet[1] = $lostSet[2] = 'a';
				break;
				case 2:
					$W_ID[1] = $W_ID[2] = $Pl_Org['optmissioni'];
					$lostSet[1] = 'b';
					$lostSet[2] = 'a';
					$sideTicket['A'] = 'Pl';
					$sideTicket['B'] = 'Op';
				break;
				case 3:
					$W_ID[1] = $W_ID[2] = $Op_Org['optmissioni'];
					$lostSet[1] = 'a';
					$lostSet[2] = 'b';
					$sideTicket['A'] = 'Op';
					$sideTicket['B'] = 'Pl';
				break;
				default:
					echo "<hr>出錯: BTL-2-WTRes-01, 請通知 GM!";
					exit;
				break;
			}
			switch ($VictoryFlag){
				case '1':
					$sqla['op'] = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_war` SET `ticket_".$lostSet[1]."` = `ticket_".$lostSet[1]."`-".$ticketLoss['Op']." WHERE `war_id` = ".$W_ID[1]." LIMIT 1 ;");
					$Result_Tag .= $W_rt['Op'];
				break;
				case '2':
					$sqla['pl'] = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_war` SET `ticket_".$lostSet[2]."` = `ticket_".$lostSet[2]."`-".$ticketLoss['Pl']." WHERE `war_id` = ".$W_ID[2]." LIMIT 1 ;");
					$Result_Tag .= $W_rt['Pl'];
				break;
				case '0':
				case '3':
					$sqla['op'] = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_war` SET `ticket_".$lostSet[1]."` = `ticket_".$lostSet[1]."`-".$ticketLoss['Op']." WHERE `war_id` = ".$W_ID[1]." LIMIT 1 ;");
					$sqla['pl'] = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_war` SET `ticket_".$lostSet[2]."` = `ticket_".$lostSet[2]."`-".$ticketLoss['Pl']." WHERE `war_id` = ".$W_ID[2]." LIMIT 1 ;");
					$Result_Tag .= $W_rt['Op'].$W_rt['Pl'];
				break;
			}
			foreach($sqla as $sql) mysql_query($sql);
			$sql_k = $sql = '';
			if($isEnemyFlag > 1){
				$sql = "SELECT `ticket_a` AS `".$sideTicket['A']."`, `ticket_b` AS `".$sideTicket['B']."`, `victory`, `mission` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = ".$W_ID[1];
				$query = mysql_query($sql) or die("<hr>出錯: BTL-2-WTRes-02, 請通知 GM!");
				if(mysql_num_rows($query) != 1) {echo "<hr>出錯: BTL-2-WTRes-03, 請通知 GM!";exit;}
				$Tickets = mysql_fetch_array($query);
				if(!$Tickets['victory']){
					if($Tickets['Op'] <= 0)     $War_Victory_Flag = 'Pl';
					elseif($Tickets['Pl'] <= 0) $War_Victory_Flag = 'Op';
					if($War_Victory_Flag){
						$winner_org = $War_Victory_Flag.'_Org';
						if($isEnemyFlag == 2 && $War_Victory_Flag == 'Pl'){
							$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_war` SET `victory` = 1 WHERE `war_id` = ".$W_ID[1]." LIMIT 1 ;");
							$sql_k = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` != ".$W_ID[1]." AND `mission` = '".$Tickets['mission']."';");
						}elseif($isEnemyFlag == 3 && $War_Victory_Flag == 'Op'){
							$sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = ".$W_ID[1]." LIMIT 1 ;");
						}else	{echo "<hr>出錯: BTL-2-WTRes-04, 請通知 GM!";exit;}
						$Result_Tag .= "<br><font color=".${$winner_org}['color'].">".${$winner_org}['name']."</font> 勝出這場戰爭！！";
						$HistoryWrite = "<font color=".${$winner_org}['color'].">".${$winner_org}['name']."</font> 勝出了戰爭！！";
						WriteHistory($HistoryWrite);
					}
				}
			}else{
				$sql = "SELECT `war_id`,`ticket_a`,`b_org` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = ".$W_ID[1]." OR `war_id` = ".$W_ID[2];
				$query = mysql_query($sql);
				while($i = mysql_fetch_array($query)){
					if($i['war_id'] == $W_ID[2]){
						$Tickets['Pl'] = $i['ticket_a'];
						if($Tickets['Pl'] <= 0) {$War_Victory_Flag = 2;$w_org = $i['b_org'];}
					}
					else {
						$Tickets['Op'] = $i['ticket_a'];
						if($Tickets['Op'] <= 0) {$War_Victory_Flag = 1;$w_org = $i['b_org'];}
					}
				}
				if($War_Victory_Flag){
					$sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = ".$W_ID[$War_Victory_Flag]." LIMIT 1 ;");
					$winner_org = ($War_Victory_Flag == 2) ? 'Op_Org' : 'Pl_Org';
					$loser_org = ($War_Victory_Flag == 2) ? 'Pl_Org' : 'Op_Org';
					$Result_Tag .= "<br><font color=".$Area_Org['color'].">".$Area_Org['name']."</font> 擊退 <font color=".${$loser_org}['color'].">".${$loser_org}['name']."</font> 勝出這場戰爭！！";
					$HistoryWrite = "<font color=".$Area_Org['color'].">".$Area_Org['name']."</font> 在 <font color=".${$winner_org}['color'].">".${$winner_org}['name']."</font> 協助下擊退 <font color=".${$loser_org}['color'].">".${$loser_org}['name']."</font> ！！";
					WriteHistory($HistoryWrite);
				}
			}
			mysql_query($sql);
			if($sql_k) mysql_query($sql_k);
		}

	//Update Information
		$sqlgen = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET ");
		$sqlgen .= ("`bounty` = '".$Pl->Player['bounty']."',`fame` = '".$Pl->Player['fame']."', `cash` = '".$Pl->Player['cash']."', `hypermode` = '".$Pl->Player['hypermode']."',");
		$sqlgen .= (" `growth` = '".$Pl->Player['growth']."', `time1` = '$t_now', `time2` = '$t_now', `btltime` = '$t_now' ");
		if($UpdateMSFlag['Pl']) $sqlgen .= (" ,`msuit` = '".$Pl->Player['msuit']."' ");
		$sqlgen .= (" WHERE `username` = '".$Pl->Player['name']."' LIMIT 1;");
		if ($AtkFortFlag != 1){
			$sqlgenop = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET ");
			$sqlgenop .= ("`bounty` = '".$Op->Player['bounty']."',`fame` = '".$Op->Player['fame']."', `hypermode` = '".$Op->Player['hypermode']."', ");
			$sqlgenop .= ("`growth` = '".$Op->Player['growth']."', `time1` = '$t_now' ");
			if($UpdateMSFlag['Op']) $sqlgenop .= (" ,`msuit` = '".$Op->Player['msuit']."' ");
			$sqlgenop .= (" WHERE `username` = '".$Op->Player['name']."' LIMIT 1;");
		}
		else $sqlgenop = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `hp` = '".$Resulting_HP['Op']."' WHERE `map_id` = '".$Pl->Player['coordinates']."' LIMIT 1;");
		mysql_query($sqlgen) or die ('<hr>MySQL 資料庫存取錯誤, 請聯絡GM, 錯誤代號 BTL-2-003<br>' . postFooter());
		mysql_query($sqlgenop) or die ('<hr>MySQL 資料庫存取錯誤, 請聯絡GM, 錯誤代號 BTL-2-004<br>' . postFooter());
		$sqlgame = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET ");
		$sqlgame .= ("`hp` = '".$Resulting_HP['Pl']."', ");
		$sqlgame .= ("`en` = '".$Resulting_EN['Pl']."', ");
		$sqlgame .= ("`sp` = '".$Resulting_SP['Pl']."', ");
		if ($UpD_Pl_level) {$sqlgame .= ("`spmax` = '".$Pl->Player['spmax']."', ");
		$sqlgame .= ("`level` = '".$Pl->Player['level']."', ");}
		$sqlgame .= ("`expr` = '".$Pl->Player['expr']."', ");
		$sqlgame .= ("`wepa` = '".$Pl->Player['wepa']."', ");
		//$sqlgame .= ("`wepb` = '".$Pl->Player['wepb']."', ");
		//$sqlgame .= ("`wepc` = '".$Pl->Player['wepc']."', ");
		$sqlgame .= ("`eqwep` = '".$Pl->Player['eqwep']."', ");
		$sqlgame .= ("`p_equip` = '".$Pl->Player['p_equip']."', ");
		$sqlgame .= ("`status` = '".$Pl->Player['status']."', ");
		if ($Pl->Tactics['id'] != $Pl->Player['last_tact'])$sqlgame .= ("`last_tact` = '".$Pl->Tactics['id']."', ");
		$sqlgame .= ("`victory` = '".$Pl->Player['victory']."', ");
		$sqlgame .= ("`v_points` = '".$Pl->Player['v_points']."', ");
		$sqlgame .= ("`spec` = '".$Pl->Player['spec']."', ");
		$sqlgame .= ("`rank` = '".$Pl->Player['rank']."' ");
		$sqlgame .= ("WHERE `username` = '".$Pl->Player['name']."' LIMIT 1;");
		if ($AtkFortFlag != 1){
			$sqlgameop = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET");
			$sqlgameop .= ("`hp` = '".$Resulting_HP['Op']."',");
			$sqlgameop .= ("`en` = '".$Resulting_EN['Op']."',");
			if ($UpD_Op_level) {$sqlgameop .= ("`spmax` = '".$Op->Player['spmax']."',");
			$sqlgameop .= ("`level` = '".$Op->Player['level']."',");}
			if ($Op->SP_Cost || $Op_NewSeed == 1) $sqlgameop .= ("`sp` = '".$Resulting_SP['Op']."',");
			$sqlgameop .= ("`expr` = '".$Op->Player['expr']."',");
			$sqlgameop .= ("`wepa` = '".$Op->Player['wepa']."',");
			$sqlgameop .= ("`eqwep` = '".$Op->Player['eqwep']."', ");
			$sqlgameop .= ("`p_equip` = '".$Op->Player['p_equip']."', ");
			$sqlgameop .= ("`status` = '".$Op->Player['status']."' ");
			$sqlgameop .= ("WHERE `username` = '".$Op->Player['name']."' LIMIT 1;");
			mysql_query($sqlgameop) or die ('<hr>MySQL 資料庫存取錯誤, 請聯絡GM, 錯誤代號 BTL-2-006<br>' . postFooter());
		}
		mysql_query($sqlgame) or die ('<hr>MySQL 資料庫存取錯誤, 請聯絡GM, 錯誤代號 BTL-2-005<br>' . postFooter());
		//Write Logs
		if ($Pl->Player['show_log_num'] || $Op->Player['show_log_num']){
			if ($LogEntries){
				if ($Pl->Player['show_log_num'] > $LogEntries) $Pl_LEnt = $LogEntries;
				else $Pl_LEnt = $Pl->Player['show_log_num'];
				if ($Op->Player['show_log_num'] > $LogEntries) $Op_LEnt = $LogEntries;
				else $Op_LEnt = $Op->Player['show_log_num'];
				$TmpLogVar = array('','','','');
				$sqllog = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_log` SET");
				if ($Pl_LEnt == 5) {$sqllog .= ("`log5` = `log4`,"); $TmpLogVar[3] = '`time5` = `time4`,';}
				if ($Pl_LEnt >= 4) {$sqllog .= ("`log4` = `log3`,"); $TmpLogVar[2] = '`time4` = `time3`,';}
				if ($Pl_LEnt >= 3) {$sqllog .= ("`log3` = `log2`,"); $TmpLogVar[1] = '`time3` = `time2`,';}
				if ($Pl_LEnt >= 2) {$sqllog .= ("`log2` = `log1`,"); $TmpLogVar[0] = '`time2` = `time1`,';}
				$sqllog .= ("`log1` = '你與".$Op->Player['gamename']."交戰！$Pl_Log_Tag',".$TmpLogVar[3].$TmpLogVar[2].$TmpLogVar[1].$TmpLogVar[0]);
				$sqllog .= ("`time1` = '$t_now' WHERE `username` = '".$Pl->Player['name']."' LIMIT 1;");
				$TmpLogVar = array('','','','');
				$sqllogop = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_log` SET");
				if ($Op_LEnt == 5) {$sqllogop .= ("`log5` = `log4`,"); $TmpLogVar[3] = '`time5` = `time4`,';}
				if ($Op_LEnt >= 4) {$sqllogop .= ("`log4` = `log3`,"); $TmpLogVar[2] = '`time4` = `time3`,';}
				if ($Op_LEnt >= 3) {$sqllogop .= ("`log3` = `log2`,"); $TmpLogVar[1] = '`time3` = `time2`,';}
				if ($Op_LEnt >= 2) {$sqllogop .= ("`log2` = `log1`,"); $TmpLogVar[0] = '`time2` = `time1`,';}
				$sqllogop .= ("`log1` = '".$Pl->Player['gamename']."與你交戰！$Op_Log_Tag',".$TmpLogVar[3].$TmpLogVar[2].$TmpLogVar[1].$TmpLogVar[0]);
				$sqllogop .= ("`time1` = '$t_now' WHERE `username` = '".$Op->Player['name']."' LIMIT 1;");
				mysql_query($sqllog) or die ('<hr>MySQL 資料庫存取錯誤, 請聯絡GM, 錯誤代號 BTL-2-007<br>' . postFooter());
				if ($AtkFortFlag != 1)
				mysql_query($sqllogop) or die ('<hr>MySQL 資料庫存取錯誤, 請聯絡GM, 錯誤代號 BTL-2-008<br>' . postFooter());
			}
		}
		//End of Write Logs

//
// Information Display / View Phase
//

	//Echo Results
	echo "<tr align=center>";
	$DisplayXp['Pl']['A'] = ($Pl->Eq['A']['exp'] >= 0) ? '+'.($Pl->Eq['A']['exp']/100) : ($Pl->Eq['A']['exp']/100);
	$DisplayXp['Pl']['D'] = ($Pl->Eq['D']['exp'] >= 0) ? '+'.($Pl->Eq['D']['exp']/100) : ($Pl->Eq['D']['exp']/100);
	$DisplayXp['Pl']['E'] = ($Pl->Eq['E']['exp'] >= 0) ? '+'.($Pl->Eq['E']['exp']/100) : ($Pl->Eq['E']['exp']/100);
	$DisOpayXp['Op']['A'] = ($Op->Eq['A']['exp'] >= 0) ? '+'.($Op->Eq['A']['exp']/100) : ($Op->Eq['A']['exp']/100);
	$DisOpayXp['Op']['D'] = ($Op->Eq['D']['exp'] >= 0) ? '+'.($Op->Eq['D']['exp']/100) : ($Op->Eq['D']['exp']/100);
	$DisOpayXp['Op']['E'] = ($Op->Eq['E']['exp'] >= 0) ? '+'.($Op->Eq['E']['exp']/100) : ($Op->Eq['E']['exp']/100);

	echo "<td>主武器: ".$Pl->Eq['A']['name'].' <font style="font-size: 8pt; font-weight: 700;">('.$DisplayXp['Pl']['A'].'%)</font>'.getEqStatChange('Pl','A').'<br>';
	if ($Pl->Eq['D']['id']) echo '輔助裝備: '.$Pl->Eq['D']['name'].' <font style="font-size: 8pt; font-weight: 700;">('.$DisplayXp['Pl']['D'].'%)</font>'.getEqStatChange('Pl','D').'<br>';
	if ($Pl->Eq['E']['id']) echo '常規裝備: '.$Pl->Eq['E']['name'].' <font style="font-size: 8pt; font-weight: 700;">('.$DisplayXp['Pl']['E'].'%)</font>'.getEqStatChange('Pl','E').'<br>';
	echo "</td><td>主武器: ".$Op->Eq['A']['name'].' <font style="font-size: 8pt; font-weight: 700;">('.$DisOpayXp['Op']['A'].'%)</font>'.getEqStatChange('Op','A').'<br>';
	if ($Op->Eq['D']['id']) echo '輔助裝備: '.$Op->Eq['D']['name'].' <font style="font-size: 8pt; font-weight: 700;">('.$DisOpayXp['Op']['D'].'%)</font>'.getEqStatChange('Op','D').'<br>';
	if ($Op->Eq['E']['id']) echo '常規裝備: '.$Op->Eq['E']['name'].' <font style="font-size: 8pt; font-weight: 700;">('.$DisOpayXp['Op']['E'].'%)</font>'.getEqStatChange('Op','E').'<br>';
	echo "</td></tr>";
	echo "<tr align=center>";
	echo "<td width=50%>";
	$HitTimes = $Strikes['Pl'];$MissTime=0;$MissTime= $Pl->Eq['A']['rd'] - $Strikes['Pl'];
	$HitIcon=$MissIcon=1;
	$TIcons=$CTIcons=0;
	while($HitIcon <= $HitTimes){echo "<img src='$Base_Image_Dir/hit.gif'>";$TIcons++;if($TIcons==10){echo"<br>";$TIcons=0;}$HitIcon++;}
	while($MissIcon <= $MissTime){echo "<img src='$Base_Image_Dir/miss.gif'>";$TIcons++;if($TIcons==10){echo"<br>";$TIcons=0;}$MissIcon++;}
	echo"</td>";
	echo "<td width=50%>";
	$CHitTimes = $Strikes['Op'];
	$CMissTime=0;
	$CMissTime= $Op->Eq['A']['rd'] - $Strikes['Op'];
	$CHitIcon=1;$CMissIcon=1;
	if(!$OpNoENFlag){
		while($CHitIcon <= $CHitTimes){echo "<img src='$Base_Image_Dir/hit.gif'>";$CTIcons++;if($CTIcons==10){echo"<br>";$CTIcons=0;}$CHitIcon++;}
		while($CMissIcon <= $CMissTime){echo "<img src='$Base_Image_Dir/miss.gif'>";$CTIcons++;if($CTIcons==10){echo"<br>";$CTIcons=0;}$CMissIcon++;}
	}
	else {echo "能源不足！！";}
	echo"</td>";
	echo "</tr>";
	echo "<tr align=center>";
	echo "<td>".$Pl->Tactics['name']."<br>";
	if($Strikes['Pl']) echo "你擊中對手 ".$Strikes['Pl']." 次，並造成 ".$Damage['Pl']." 點傷害。</td>";
	else echo "你未能擊中對手！</td>";
	echo "<td>".$Op->Tactics['name']."<br>";
	if($Strikes['Op'] && !$OpNoENFlag) echo "對手擊中你 ".$Strikes['Op']." 次，並造成 ".$Damage['Op']." 點傷害。</td>";
	elseif($OpNoENFlag == '1'){echo "反擊不能。</td>";}
	else echo "對手未能擊中你！</td>";

	echo "</tr>";

	echo "<tr align=center>";
	echo "<td>";

	$Player_init_damaged = ($Pl->Player['hpmax']-$Pl->Player['hp']) / $Pl->Player['hpmax'] * 150;
	$Player_now_dealt = ($Pl->Player['hp']-$Resulting_HP['Pl']) / $Pl->Player['hpmax'] * 150;
	$Player_now_left = $Resulting_HP['Pl'] / $Pl->Player['hpmax'] * 150;
	$Oppo_init_damaged = ($Op->Player['hpmax']-$Op->Player['hp']) / $Op->Player['hpmax'] * 150;
	$Oppo_now_dealt = ($Op->Player['hp']-$Resulting_HP['Op']) / $Op->Player['hpmax'] * 150;
	$Oppo_now_left = $Resulting_HP['Op'] / $Op->Player['hpmax'] * 150;
	echo "<img src='$Base_Image_Dir/hp.gif' hspace=0 height=7 width=$Player_now_left><img src='$Base_Image_Dir/dmg.gif' hspace=0 height=7 width=$Player_now_dealt><img src='$Base_Image_Dir/zen.gif' hspace=0 height=7 width=$Player_init_damaged>";
	echo '<br>HP: <span id=Pl_Res_Hp>'.$Pl->Player['hp'].'</span>/'.$Pl->Player['hpmax'].'<br>消耗EN: '.number_format($Pl->RequireEN)."</td>";
	echo "<td>";
	echo "<img src='$Base_Image_Dir/hp.gif' hspace=0 height=7 width=$Oppo_now_left><img src='$Base_Image_Dir/dmg.gif' hspace=0 height=7 width=$Oppo_now_dealt><img src='$Base_Image_Dir/zen.gif' hspace=0 height=7 width=$Oppo_init_damaged>";
	echo '<br>HP: <span id=Op_Res_Hp>'.$Op->Player['hp'].'</span>/'.$Op->Player['hpmax'].'<br>消耗EN: '.number_format($Op->RequireEN)."</td>";
	echo "</tr>";
	echo "<tr align=center>";
	echo "<td colspan=2>";
		echo "<table width=100% border=0 style=\"border-collapse: collapse\" align=center style=\"font-size: 12pt;font-family: Comic Sans MS;\" cellspacing=0 cellpadding=0>";
		echo "<tr><td colspan=2 align=center>".sprintTHR()."</td></tr><tr>";
		echo "<td style=\"color: #FFFF00;font-size: 10;padding-left: 10px;\" width=40%>";
		echo "得到 $Pl_Gain_Exp 點經驗值。<br>";
		if($Pl_Gain_Money > 0) echo "<br>獲得戰利金 $Pl_Gain_Money 元。";
		if($Salary > 0) echo "<br>獲得薪金 $Salary 元。";
		$Gain_BountyFlag = (isset($Gain_BountyFlag)) ? $Gain_BountyFlag : 0;
		$Gain_Bounty = (isset($Gain_Bounty)) ? $Gain_Bounty : 0;
		if ($Gain_BountyFlag) echo "<br>獲得 $Gain_Bounty 元的懸賞金。";
		echo "$Result_Tag";
		echo "$Spec_Event_Tag";
		echo "</td>";
		echo "<td align=center>";
			//Battle Continual System
			if($VictoryFlag == 0 && !$isAtkFortName) include('includes/btl-continual-sys.inc.php');
		else echo "&nbsp;</td>";
		//End
		echo "</tr></table>";
	echo "</td></tr></table>";
	echo "<p align=center>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	if ($Game_Scrn_Type == 0){
	echo "<input type=button $BStyleB style=\"$BStyleA\" value=\"關閉\" onClick=\"parent.$SecTarget.location.replace('about:blank');parent.document.getElementById('STiF').style.left = -1150;\">";

		//Requires Battle Continual System
		if($VictoryFlag == 0 || $VictoryFlag == 1) {
			echo "<input type=hidden name=\"actionb\" value=\"battle_sel\">";
			echo "<input type=button name=\"shortcutBattle\" $BStyleB style=\"$BStyleA\" disabled value=\"戰鬥(".$Btl_Intv.")\" onClick=\"movebattle();\">";
		}

	$AllowRefreshFormBtl = (isset($AllowRefreshFormBtl)) ? $AllowRefreshFormBtl : 0;
	if ($AllowRefreshFormBtl)
	echo "<input type=submit $BStyleB style=\"$BStyleA\" value=\"重新整理\" onClick=\"parent.$SecTarget.location.replace('about:blank')\"></p>";
	}
	elseif ($Game_Scrn_Type == 1)
	echo "<input type=submit $BStyleB style=\"$BStyleA\" value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<script language=\"JavaScript\">";
	echo "var BtlCD = $Btl_Intv;";
	echo	"function movebattle(){",
		"var enc = parseInt(eval(\"parent.document.getElementById('EqmEnc_A').innerHTML;\"))+parseInt(eval(\"parent.document.getElementById('EqmEnc_D').innerHTML;\"))+parseInt(eval(\"parent.document.getElementById('EqmEnc_E').innerHTML;\"));",
		"if (enc > parseInt(parent.document.getElementById('current_en').innerHTML)) {alert('EN還未足夠！'); return false;}",
		"document.frmreturn.action='battle.php?action=battle_sel';",
		"document.frmreturn.target='$SecTarget';",
		"document.frmreturn.submit();}";
	if($VictoryFlag == 0 || $VictoryFlag == 1) {
		echo "function refreshSCBtl(){";
		echo "if(BtlCD > 0) {document.frmreturn.shortcutBattle.value='戰鬥('+BtlCD+')';BtlCD--;}";
		echo "else if(BtlCD <= 0) {document.frmreturn.shortcutBattle.value='戰鬥';document.frmreturn.shortcutBattle.disabled=false;return;}";
		echo "setTimeout(\"refreshSCBtl()\",1000);}refreshSCBtl();";
	}
	echo "timeID=10;";
	echo "Pl_Dif_Hp=Math.round((".$Pl->Player['hp'].'-'.$Resulting_HP['Pl'].")*0.1);";
	echo "Op_Dif_Hp=Math.round((".$Op->Player['hp'].'-'.$Resulting_HP['Op'].")*0.1);";
	echo "flaga=flagb=flagc=0;";
	echo "setTimeout(\"HEcount()\",2500);";
	echo "function HEcount(){";
	echo "document.getElementById('Pl_Res_Hp').innerHTML=parseInt(document.getElementById('Pl_Res_Hp').innerHTML) - Pl_Dif_Hp;";
	echo "document.getElementById('Op_Res_Hp').innerHTML=parseInt(document.getElementById('Op_Res_Hp').innerHTML) - Op_Dif_Hp;";
	echo "if (parseInt(document.getElementById('Pl_Res_Hp').innerHTML) <= ".$Resulting_HP['Pl']."){document.getElementById('Pl_Res_Hp').innerHTML='".$Resulting_HP['Pl']."';flaga=1;}";
	echo "if (parseInt(document.getElementById('Op_Res_Hp').innerHTML) <= ".$Resulting_HP['Op']."){document.getElementById('Op_Res_Hp').innerHTML='".$Resulting_HP['Op']."';flagb=1;}";
	echo "clearTimeout(timeID);";
	echo "if (!flaga || !flagb){timeID = setTimeout(\"HEcount()\",1);}";
	echo "}";
	echo "</script>";
	if(isset($Tickets)){
		echo "<div style=\"height: 32;position: absolute;top: 50;width: 100%;\" align=center>";
		echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;\" bordercolor=\"#FFFFFF\">";
		echo "<tr height=32>";
		echo "<td id=ticket_td_pl width=120 align=right style=\"padding-top: 10;width: 120;background-image: url($Base_Image_Dir/ticketbar_l_u.gif);background-color: $Pl_Org[color];\">";
		echo "<font id=ticket_pl style=\"padding-right: 45;font-weight: bold;font-size: 12pt;color: ".invertColor($Pl_Org['color']).";\">".number_format($Tickets['Pl'])."</font></td>";
		echo "<td id=ticket_td_op width=120 align=left style=\"padding-top: 10;width: 120;background-image: url($Base_Image_Dir/ticketbar_r_u.gif);background-color: $Op_Org[color];\">";
		echo "<font id=ticket_op style=\"padding-left: 45;font-weight: bold;font-size: 12pt;color: ".invertColor($Op_Org['color']).";\">".number_format($Tickets['Op'])."</font></td>";
		echo "</tr></table>";
		echo "</div>";
	}
	if ($Game_Scrn_Type == 0) {
		echo "<script language=\"JavaScript\">";
		echo "TheNewDate = new Date();";
		echo "parent.r_h = parent.r_e = parent.r_s = 0;";
		echo "parent.m_time = parent.mh_time = parent.me_time = parent.ms_time = TheNewDate.getTime();";
		echo "parent.document.getElementById('current_hp').innerHTML = parent.i_h = parent.h = ".$Resulting_HP['Pl'].";";
		echo "parent.document.getElementById('current_en').innerHTML = parent.i_e = parent.e = ".$Resulting_EN['Pl'].";";
		echo "parent.document.getElementById('current_sp').innerHTML = parent.i_s = parent.s = ".$Resulting_SP['Pl'].";";
		if ($Pl->Player['status'] == '1')
		echo "parent.document.getElementById('status_now').innerHTML = '修理進行中';parent.document.getElementById('status_now').style.color='#FF2200';";
		echo "parent.document.getElementById('pl_cash').innerHTML = '".number_format($Pl->Player['cash'])."';";
		if(isset($Tickets))
		echo "parent.document.getElementById('pl_active_tickets').innerHTML = '".number_format($Tickets['Pl'])."';";
		if ($Pl->Player['fame'] >= 0)
		echo "parent.document.getElementById('type_fame').innerHTML = '名聲';";
		else echo "parent.document.getElementById('type_fame').innerHTML = '惡名';";
		echo "parent.document.getElementById('pl_fame').innerHTML = '".abs($Pl->Player['fame'])."';";
		echo "parent.document.getElementById('EqmExp_A').innerHTML = '".$DisplayXp['Pl']['A']."%';";
		if ($Pl->Eq['D']['id'])
		echo "parent.document.getElementById('EqmExp_D').innerHTML = '".$DisplayXp['Pl']['D']."%';";
		if ($Pl->Eq['E']['id'])
		echo "parent.document.getElementById('EqmExp_E').innerHTML = '".$DisplayXp['Pl']['E']."%';";
		if ($VictoryFlag == 1){
			echo "parent.document.getElementById('pl_vpoints').innerHTML = '".$Pl->Player['v_points']."';";
			echo "parent.document.getElementById('pl_victories').innerHTML = '".$Pl->Player['victory']."';";
		}
		if ($Pl->Player['hypermode'] == 1 || ($Pl->Player['hypermode'] >= 4 && $Pl->Player['hypermode'] <= 6))
			echo "parent.document.getElementById('pltype').style.filter = \"progid:DXImageTransform.Microsoft.Glow(color: 0000FF,strength=2)\";";
		else	echo "parent.document.getElementById('pltype').style.filter = '';";

		if ($Pl->Player['hypermode'] == 1 || $Pl->Player['hypermode'] == 5){
			echo "parent.document.getElementById('seedTxt').innerHTML = 'SEED Mode';";
			echo "parent.document.getElementById('seedTxt').style.color = 'FFFF00';";
			echo "parent.document.getElementById('seedTxt').style.fontWeight = 'bold';";
		}else	echo "parent.document.getElementById('seedTxt').innerHTML = '';";

		if ($Pl->Player['hypermode'] >= 4 && $Pl->Player['hypermode'] <= 6){
			echo "parent.document.getElementById('examTxt').innerHTML = 'EXAM Activated';";
			echo "parent.document.getElementById('examTxt').style.color = 'FF0000';";
			echo "parent.document.getElementById('examTxt').style.fontWeight = 'bold';";
		}else	echo "parent.document.getElementById('examTxt').innerHTML = '';";

		foreach($Pl->Base_Fixes as $p => $i){
			echo "parent.document.getElementById('pl_".$p."f').innerHTML = '".$i."';";
			echo "parent.document.getElementById('pl_".$p."_sum').innerHTML = '".($Pl_Base_Stat[$p]+$i)."';";
		}

		$Show_Exp = $UserNextLvExp = '';
		if ($Pl->Player['level'] < 150) CalcExp($Pl->Player['level']);
		if ($Pl->Player['level'] >= 150) {$UserNextLvExp = false;$Show_Exp = '0';} //Hide upon 150Lv
		else {
			calcExp($Pl->Player['level']);
			$Show_Exp = number_format($Pl->Player['expr'])." / ".number_format($UserNextLvExp);
			echo "parent.document.getElementById('pl_expr').innerHTML = '$Show_Exp';";
			echo "parent.document.getElementById('pl_expr_l').width = '".ceil(($Pl->Player['expr']/$UserNextLvExp)*124)."';";
			echo "parent.document.getElementById('pl_expr_r').width = '".(124-ceil(($Pl->Player['expr']/$UserNextLvExp)*124))."';";
			if($UpD_Pl_level == '1'){
				$enableImg = "$General_Image_Dir/neo/plus_sign.gif";
				echo "function getPElm(sElm){return parent.document.getElementById(sElm);}";
				echo "function getPElmHTMLInt(sElm){return parseInt(getPElm(sElm).innerHTML);}";
				echo "parent.document.getElementById('pl_level').innerHTML = '".$Pl->Player['level']."';";
				echo "parent.document.getElementById('pl_growth').innerHTML = '".$Pl->Player['growth']."';";
				echo "parent.document.getElementById('max_sp').innerHTML = parent.m_s = '".$Pl->Player['spmax']."';";
				echo "parent.sprate =". (0.004 * $Pl->Player['spmax']) .';';
				echo "if (getPElmHTMLInt('attacking_stat_req') <= getPElmHTMLInt('pl_growth'))";
				echo "{getPElm('attacking_addlink').style.cursor = 'pointer';getPElm('attacking_addlink').src = '$enableImg';}";
				echo "if (getPElmHTMLInt('defending_stat_req') <= getPElmHTMLInt('pl_growth'))";
				echo "{getPElm('defending_addlink').style.cursor = 'pointer';getPElm('defending_addlink').src = '$enableImg';}";
				echo "if (getPElmHTMLInt('reacting_stat_req')  <= getPElmHTMLInt('pl_growth'))";
				echo "{getPElm('reacting_addlink').style.cursor = 'pointer';getPElm('reacting_addlink').src = '$enableImg';}";
				echo "if (getPElmHTMLInt('targeting_stat_req') <= getPElmHTMLInt('pl_growth'))";
				echo "{getPElm('targeting_addlink').style.cursor = 'pointer';getPElm('targeting_addlink').src = '$enableImg';}";
				echo "if (getPElmHTMLInt('sp_stat_req') <= getPElmHTMLInt('pl_growth'))";
				echo "{getPElm('spmax_addlink').style.cursor = 'pointer';getPElm('spmax_addlink').src = '$enableImg';}";
			}
		}
		if($Pl_LEnt > 0){
		for($LogShowNum=$Pl_LEnt;$LogShowNum > 1;$LogShowNum--){
			$i = 'time'.$LogShowNum;
			$j = 'log'.$LogShowNum;
			echo "parent.document.getElementById('log$i').innerHTML = parent.document.getElementById('logtime".($LogShowNum-1)."').innerHTML;";
			echo "parent.document.getElementById('log$j').innerHTML = parent.document.getElementById('loglog".($LogShowNum-1)."').innerHTML;";
			}
		echo "parent.document.getElementById('logtime1').innerHTML = '".cfu_time_convert($t_now)."';";
		echo "parent.document.getElementById('loglog1').innerHTML = '你與".$Op->Player['gamename']."交戰！$Pl_Log_Tag';";
		}

		if($Pl_MS_JSUpdate){
			echo $Pl_MS_JSUpdate;
		}
		echo "function numberFormat(num){";
		echo "	var numF = '';";
		echo "	var pNum = num;";
		echo "	var l = num.length;";
		echo "	var tx = Math.floor(l/3);";
		echo "	var rx = (l%3);";
		echo "	if (rx == 1){numF = num.substr(0,1);pNum = num.substr(1);}";
		echo "	else if (rx == 2){numF = num.substr(0,2);pNum = num.substr(2);}";
		echo "	else {numF = num.substr(0,3);pNum = num.substr(3);}";
		echo "	while(pNum.length >= 3){";
		echo "	numF = numF+','+pNum.substr(0,3);";
		echo "	pNum = pNum.substr(3);";
		echo "	}";
		echo "	return numF;";
		echo "}";
		echo "</script>";
	}
	if($Use_Behavior_Checker){
		include_once('includes/behavior_checker.class.php');
		$BhvrChecker = new BehaviorChecker($Pl, $GLOBALS['Btl_Intv'], $VictoryFlag, $GLOBALS['Offline_Time'], $GLOBALS['CFU_Time'], $GLOBALS['DBPrefix']);
		$BhvrChecker->checkInsomnia();
		$BhvrChecker->checkRationalBattle();
	}
	echo "</html>";
}
?>