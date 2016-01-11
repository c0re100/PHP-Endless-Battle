<?php
//Battle Function
//For php-eb Ultimate Edition v1.0
//Copyright v2Alliance 2005-2010
if (!$cSpec) {
	include('cfu.php');
	AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
}
function selectOpponentTactic($Tact){
	//$Tact is $Op->Player['tactics']
	$Op_Tact = '';
	if($Tact){
		$Op_Tact_Cache = explode("\n",$Tact);
		$Op_Tact_Avail = array('0');
		foreach($Op_Tact_Cache as $v) {
			if(isset($v) && $v != '0' && $v != '') $Op_Tact_Avail[] = $v;
		}
		$Op_Tact_Use = mt_rand(0,(count($Op_Tact_Avail)-1));
		$Op_Tact = trim($Op_Tact_Avail[$Op_Tact_Use]);
		return GetTactics($Op_Tact);
	}
	else return GetTactics('0');
}

function actDeacEXAM(&$Usr,$EXAMStat){
	//Activation
	$isEXAMtypch = ($Usr->Player['typech'] == 'nat' || $Usr->Player['typech'] == 'enh' || $Usr->Player['typech'] == 'ext');
	if (strpos($Usr->Player['spec'],'EXAMSystem') !== false && $isEXAMtypch && $EXAMStat == true && $Usr->Player['sp']/$Usr->Player['spmax'] >= 0.15 && $Usr->Player['sp'] >= 10) {
		//With SEED
		if ($Usr->Player['hypermode'] == 1 || $Usr->Player['hypermode'] == 5) $Usr->Player['hypermode'] = 5;
		//With NT Hypermode
		elseif ($Usr->Player['hypermode'] == 2 || $Usr->Player['hypermode'] == 6) $Usr->Player['hypermode'] = 6;
		//EXAM Only
		elseif ($Usr->Player['hypermode'] == 0) $Usr->Player['hypermode'] = 4;
	}
	//Deactivation
	if (	($Usr->Player['sp']/$Usr->Player['spmax'] < 0.15 && $Usr->Player['sp'] < 10) ||
		$EXAMStat == false ||
		(
			strpos($Usr->Eq['D']['spec'],'EXAMSystem') === false &&
			strpos($Usr->Eq['E']['spec'],'EXAMSystem') === false &&
			strpos($Usr->MS['spec'],'EXAMSystem') === false
		)
	) {
		//With EXAM Only
		if ($Usr->Player['hypermode'] == 4) $Usr->Player['hypermode'] = 0;
		//With SEED Only
		elseif ($Usr->Player['hypermode'] == 5) $Usr->Player['hypermode'] = 1;
		//With NT Hypermode Only
		elseif ($Usr->Player['hypermode'] == 6) $Usr->Player['hypermode'] = 2;
	}
}

function actDeacPresage(&$Usr,$NTPresage){
	//Activation
	if($Usr->Player['hypermode'] == 2 && $Usr->Player['typech'] == 'nt' && $Usr->Eq['D']['exp'] >= 2500 && $NTPresage == true){
		if(strpos($Usr->Player['spec'],'NTPresage') === false) $Usr->Player['spec'] .= 'NTPresage, ';
	}
	//Deactivation
	else	$Usr->Player['spec'] = str_replace('NTPresage, ','',$Usr->Player['spec']);
}

function tryCounterStrike($A_Spec, $B_Spec, $A_Lv, $B_Lv, &$Spec_Event_Tag, $isActive=true){
	if(strpos($A_Spec,'CounterStrike') !== false && strpos($B_Spec,'CounterStrike') === false && mt_rand(0,100) <= (50+$A_Lv-$B_Lv) ){
		$Spec_Event_Tag .= ( $isActive ) ? "<br>你成功反擊對方的攻擊！" : "<br>對方成功反擊你的攻擊！";
		return 1;
	}
	else return 0;
}

function tryPresage($Spec,$Xp){
	if(strpos($Spec,'NTPresage') !== false && $Xp >= 2500) return 1;
	else return 0;
}

function getEqStatChange($Usr, $Eqm){
	global $Eq_Equipment_Struck,$Eq_Impact,$Pl_Gain_Wep_Exp,$Op_Gain_Wep_Exp,$Eq_Cond_Bonus;
	$change = 0;
	$clr = $text = '';
	if($Eq_Equipment_Struck[$Usr] != $Eqm && $Eqm != 'A' && !$Eq_Cond_Bonus) return;
	$change = $Eq_Impact[$Usr];
	if($Eqm == 'A') $change -= ${$Usr."_Gain_Wep_Exp"};
	else		$change -= $Eq_Cond_Bonus[$Usr];
	if($change == 0) return;
	if($change < 0){
		$clr = "ForestGreen";
		$text = '↑';
	}
	elseif($change > 0){
		$clr = "Red";
		$text = '↓';
	}
	$change = abs($change)/100;
	return " <font style=\"font-size: 8pt; font-weight: 700; color: $clr;\"> (".$text.$change."%)</font>";
}
function GetWAtkL($Atk, $Tar, $Re){
	//攻方攻擊值, 攻方Targeting, 守方回避值
	if ($Tar < $Re/3) $AtkL = $Atk/5;
	else
	$AtkL=$Atk * (floor($Tar-$Re/3) * 0.01);
	if ($AtkL < $Atk/5) $AtkL = $Atk/5;
	if ($AtkL > $Atk) $AtkL = $Atk;
	$AtkL = round($AtkL);
	return $AtkL; //攻方攻擊值計算下限
}

function ReturnHitDam($W_Atk,$Rds,$W_Hit,$Atf,$Def,$Ref,$Taf,$At,$De,$Re,$Ta,$A_Spec,$B_Spec,$A_Range,$B_Range,$A_Attrb,$B_Attrb){
	// 攻方武器攻擊力, 回數, 武器命中率, 攻方Targeting, 攻方命中值, 守方回避力, 攻方攻擊值, 守方防禦值,
	// 攻方特效, 守方特效, 攻方距離, 守方距離, 攻方屬性, 守方屬性

	global $Damage_MS_Bias, $Damage_MS_Sense, $Damage_Pi_Bias, $Damage_Pi_Sense, $Acc_MS_Bias, $Acc_MS_Sense, $Acc_Pi_Bias, $Acc_Pi_Sense;
	mt_srand ((double) microtime()*1000000);
	
	$AtkByMS = $Damage_MS_Bias + ( ( $Atf - $Def ) / $Damage_MS_Sense );
	$AtkByPi = $Damage_Pi_Bias + ( $At - $De ) / $Damage_Pi_Sense ;

	if($AtkByMS < 0) $AtkByMS = 0;
	elseif($AtkByPi < 0) $AtkByPi = 0;

	$Damage_prd_Max = $W_Atk * $AtkByMS * $AtkByPi;
	$Damage_prd_Min = GetWAtkL($Damage_prd_Max,$Ta,$Re);

	$Rds_Multiplier = 1;
	if (strpos($A_Spec,'TripleStrike') !== false)    $Rds_Multiplier = 3;
	elseif(strpos($A_Spec,'DoubleStrike') !== false) $Rds_Multiplier = 2;
	
	if(strpos($B_Spec,'ShootDown') !== false && $A_Attrb == 2) $Rds_Multiplier *= 0.6;
	if(strpos($A_Spec,'DenseShot') !== false && mt_rand() % 2 == 0) $Rds_Multiplier /= 0.6;

	$T_Rds = round($Rds * $Rds_Multiplier);
	$DamagePrevent = 0;

	if(strpos($B_Spec,'AntiPDef') === false){
		if(strpos($B_Spec,'Def') !== false){
			if(strpos($B_Spec,'Defe') !== false)	   $DamagePrevent = 5000;
			elseif(strpos($B_Spec,'Defd') !== false) $DamagePrevent = 3500;
			elseif(strpos($B_Spec,'Defc') !== false) $DamagePrevent = 2000;
			elseif(strpos($B_Spec,'Defb') !== false) $DamagePrevent = 1000;
			elseif(strpos($B_Spec,'Defa') !== false) $DamagePrevent = 400;
		}
		if(strpos($B_Spec,'Pv') !== false){
			$DamAvg = ($Damage_prd_Max + $Damage_prd_Min) / 2 * $T_Rds;
			$DamagePrevent += tryGetPv($DamAvg, $B_Spec, $A_Attrb, 0, 'PvBeam');
			$DamagePrevent += tryGetPv($DamAvg, $B_Spec, $A_Attrb, 1, 'PvPhy');
			$DamagePrevent += tryGetPv($DamAvg, $B_Spec, $A_Attrb, 3, 'PvUni');
		}
	}

	if($DamagePrevent > 0){
		$Damage_prd_Max -= $DamagePrevent/$T_Rds;
		$Damage_prd_Min -= $DamagePrevent/$T_Rds;
	}

	if($Damage_prd_Max < 0) $Damage_prd_Max = 0;
	if($Damage_prd_Min < 0) $Damage_prd_Min = 0;

	$Damage_prd_Max = floor($Damage_prd_Max);
	$Damage_prd_Min = floor($Damage_prd_Min);

	$MobS_Fix = 1;$i=array();
	if(preg_match('/MobS<([0-9]+)>/',$B_Spec,$i)) $MobS_Fix = 1 - intval($i[1])/10000;
	if ($MobS_Fix > 1) $MobS_Fix = 1;

	$AccByMS = $Acc_MS_Bias + ( $Taf - $Ref ) / $Acc_MS_Sense;
	$AccByPi = $Acc_Pi_Bias + ( $Ta - $Re ) / $Acc_Pi_Sense ;

	if($AccByMS < 0) $AtkByMS = 0;
	elseif($AccByPi < 0) $AtkByPi = 0;

	$Accuracy = floor( 10000 * $W_Hit * $AccByMS * $AccByPi )/10000;
	$Accuracy *= $MobS_Fix;
	if ($Accuracy > 100)	$Accuracy = 100;
	if ($Accuracy < 0)	$Accuracy = 0;

	$Dealt = $Strike = array();
	for($i=0;$i < $T_Rds;$i++){
		if(mt_rand(0,100) <= $Accuracy){
		$Dealt[$i] = mt_rand($Damage_prd_Min,$Damage_prd_Max);
		$Strike[$i] = 1;
		}else $Dealt[$i]=$Strike[$i]=0;
	}
	return array($Dealt,$Strike);

}

function wXpIsLowerThan($Usr,$Slot,$expReq){
	return ($Usr->Eq[$Slot]['id'] != 0 && $Usr->Eq[$Slot]['exp'] < $expReq);
}
			
function getAntiDamFlag($Usr){
	if(strpos($Usr->Specs,'AntiDam') === false) return 0;
	if(wXpIsLowerThan($Usr,'D',1000) || wXpIsLowerThan($Usr,'E',1000)) return 0;
	else return 1;
}

function tryDamB($Pl,$Op,$VFlag,$VReq1,$VReq2){
	if(strpos($Usr->Specs,'DamB') === false) return false;
	if($Pl->Eq['A']['exp'] < 1000) return false;
	$DamB_S_R = mt_rand(0, 99);
	if(($DamB_S_R < 10 && $VFlag == $VReq1) || ($DamB_S_R < 2 && $VFlag == $VReq2)){
		$Op->Player['status'] = '1';
		return true;
	}
	else return false;
}

function rangeAnalysis($A_Range, $B_Range){
	// Long-range Suppresses Short-range
	if($A_Range == 0 && $B_Range == 1 && mt_rand(0, 99) < 50){
		// Strike priority increased by 1
		return 1;
	}
	else{
		return 0;
	}
}

function analyzeFirstStrike($Specs, $PA, $PB){
	// flag = strike priority
	$flag = 0;
	if(strpos($Specs,'FirstStrike') !== false){
		$flag++;
		if(strpos($PA['A']['spec'],'FirstStrike') !== false){
			// Weapon FirstStrike Bonus
			$flag++;
		}
	}
	$flag += rangeAnalysis($PA['A']['range'], $PB['A']['range']);
	
	// Charge-up Penalty
	if(strpos($Specs,'ChargeUp') !== false){
		$flag--;
	}
	
	// Sniping weapone bonus
	if(strpos($Specs,'Sniping') !== false){
		$flag += 5;
	}

	// Return Priority
	return $flag;
}

function tryFirstStrike($Pl, $Op, $Damage, $f1, $f2){
	$LevelModifier = 85 + ($Pl->Player['level'] - $Op->Player['level']);
	$Chance = mt_rand(0, 99);
	$hasPassedThreshold = ( floor( $Op->Player['hp'] - $Damage ) <= 0 );
	return (($f1 - $f2) > 0 && $Chance < $LevelModifier && $hasPassedThreshold);
}

function getPvAmount($Atk, $ByPc, $ByValue, $Max){
	$Pv = $Atk * $ByPc + $ByValue;
	return ($Pv < $Max) ? $Pv : $Max;
}

function tryGetPv($DamAvg, $B_Spec, $A_Attrb, $AttrbVal, $Str){
	
	$DamagePrevent = 0;

	if(strpos($B_Spec,$Str) !== false && $A_Attrb == $AttrbVal){
		if (strpos($B_Spec,$Str.'A') !== false) $DamagePrevent += getPvAmount($DamAvg, 0.10, 200, 1200);
		if (strpos($B_Spec,$Str.'B') !== false) $DamagePrevent += getPvAmount($DamAvg, 0.15, 500, 2000);
		if (strpos($B_Spec,$Str.'C') !== false) $DamagePrevent += getPvAmount($DamAvg, 0.20, 1000, 4000);
		if (strpos($B_Spec,$Str.'D') !== false) $DamagePrevent += getPvAmount($DamAvg, 0.27, 1700, 6500);
		if (strpos($B_Spec,$Str.'E') !== false) $DamagePrevent += getPvAmount($DamAvg, 0.35, 2500, 10000);
	}
	
	return $DamagePrevent;

}

?>
