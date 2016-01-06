<?php

class oBattle extends player_stats {

var $SP_Cost;        // Set after initSpCost() and checkTactics() is called
var $RequireEN;      // Set after calc_required_en() is called
var $Tactics;        // Must be retrieved by itself
var $Base_Fixes;     // Set after applySpecFixEffects() is called

// Set after Pre-phase I: 0 = Normal, 1 = Active Attacker, 2 = Active Fort Assault, 3 = Active Defender,
var $MyStanceState;  //   4 = Passive Attacker, 5 = Passive Defender, 6 = Passive Fort Defence

function initSpCost(){
	$SP_Cost = 0;
}

function checkTactics($Chosen){
	// Called by active player only
	if(strpos($this->Player['tactics'],$Chosen) === false && $Chosen) $this->sendError("未習得該戰術。");
	elseif (empty($this->Tactics['name'])) $this->sendError("不明的戰術。");
	elseif (!$this->Tactics['name']) $this->sendError("不明的戰術。");

	// Init. EN cost and SP cost
	$this->Tactics['enc'] = (isset($this->Tactics['enc'])) ? $this->Tactics['enc'] : 0;
	$this->SP_Cost = $this->Tactics['spc'];
	$this->Eq['A']['enc'] += $this->Tactics['enc'];
}

function analyzeEnhHM(){
	 if($this->Player['hypermode'] != 2 && $this->Player['hypermode'] != 6) return;
	 if(strpos($this->Player['spec'],'DefX') !== false) return;
	 if($this->Player['typech'] != 'enh') return;
	 $this->Player['spec'] .= 'DefX, ';
}

function apply_condition_bonus(){
	// Requires Weapons to be processed first
	$Bonus_Rand = mt_rand(75,150) * 1000;

	if($this->Eq['A']['exp'] < 0){
		$i = (10000+$this->Eq['A']['exp'])/10000;
		$this->Eq['A']['atk'] = floor($this->Eq['A']['atk'] * $i);
		$i = 1 + abs($this->Eq['A']['exp'])/10000;
	}else	$i = 1 - $this->Eq['A']['exp']/$Bonus_Rand;
	$this->Eq['A']['enc'] = floor($this->Eq['A']['enc'] * $i);

	if($this->Eq['D']['exp'] < 0)	$i = ($this->Eq['D']['exp'])/-5000;
	else				$i = 1 - $this->Eq['D']['exp']/$Bonus_Rand;
	$this->Eq['D']['enc'] = floor($this->Eq['D']['enc'] * $i);

	if($this->Eq['E']['exp'] < 0)	$i = ($this->Eq['E']['exp'])/-5000;
	else				$i = 1 - $this->Eq['E']['exp']/$Bonus_Rand;
	$this->Eq['E']['enc'] = floor($this->Eq['E']['enc'] * $i);

}

function calc_extra_sp_cost($Discount = 1){
	// Requires Weapons to be processed first
	$list = array('D','E','A');
	foreach($list as $v){
		if(preg_match('/CostSP<([0-9]+)>/',$this->Eq[$v]['spec'],$array)){
			$a = intval($array[1]);
			$this->SP_Cost += ceil($a * $Discount);
		}
	}
}

function calc_required_en(){
	// Requires Weapons & Tactics to be processed first
	if(strpos($this->Tactics['spec'],'DoubleStrike') !== false) $this->Eq['A']['enc'] *= 2;
	if(strpos($this->Tactics['spec'],'TripleStrike') !== false) $this->Eq['A']['enc'] *= 3;
	$MSEnCpos = strpos($this->MS['spec'],'CostEN');
	if($MSEnCpos !== false) {
		$temp = array();
		preg_match('/CostEN<([0-9.]+)>/',$this->MS['spec'],$temp,0,$MSEnCpos);
		$MSEnC = floatval($temp[1]);
		if($MSEnC < 1) $MSEnC = floor($this->Player['enmax'] * $MSEnC);
		$this->Eq['A']['enc'] += $MSEnC;
	}
	$this->RequireEN = ($this->Eq['A']['enc'] + $this->Eq['D']['enc'] + $this->Eq['E']['enc']);
}

// Override ProcessMS
function ProcessMS(){
	$SQL = ("SELECT `id`, `msname`, `atf`, `def`, `ref`, `taf`, `hpfix`, `enfix`, `spec`, `needlv`, `price`, `image` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE id='". $this->Player['msuit'] ."'");
	$Query = mysql_query($SQL);
	$this->MS = mysql_fetch_array($Query);

	if($this->Player['level'] < $this->MS['needlv']){
		$this->MS['atf']=$this->MS['def']=$this->MS['ref']=$this->MS['taf']=0;
		return;
	}

	// Add Modification
	$this->addMSModifications();
}

function checkStart(){
	// Requires EN cost & SP Cost to be processed first
	if (!$this->Eq['A']['id']) $this->sendError("你沒有裝備武器，不能出擊。");
	elseif ($this->Player['en'] < $this->RequireEN) $this->sendError("EN不足，無法出擊。");
	elseif ($this->Player['sp'] < $this->SP_Cost) $this->sendError("SP不足，無法以 $Pl->Tactics[name] 出擊。");
}

function processGundam00specs(&$UpdateMSFlag){
	// Analyse Trans-AM System
	if(preg_match('/TransAM<([EnxNo]{2})><([0-9]+)>/',$this->MS['spec'],$a)){
		$TransAM_P = mt_rand(0,99);
		$Req_P = ( $a[1] == 'En' ) ? 10 : 50;
		if($TransAM_P < $Req_P){
			$UpdateMSFlag = true;
			$this->Player['msuit'] = $a[2];
			$this->ProcessMS();
		}
	}
	// GN-Customs
	$E_GN_Flag = (strpos($this->Eq['E']['spec'],'GNParticles') === false);
	if(strpos($this->Eq['A']['spec'],'GNWeapon') !== false && $E_GN_Flag ){
		$this->Eq['A']['atk']	= 0;
		$this->Eq['A']['rd']	= 1;
		$this->Eq['A']['spec']	= '';
	}
	if(strpos($this->Eq['D']['spec'],'GNWeapon') !== false && $E_GN_Flag )	$this->Eq['D']['spec'] = '';
	// End of GN-Customs
}

function generateSpecialAbilityPool(){

	// Overriding Function, Adds tactics
	$this->Specs = $this->Player['spec']."\n".$this->MS['spec']."\n".$this->Eq['A']['spec']."\n".$this->Tactics['spec'];
	if ($this->Eq['D']['spec'])			$this->Specs .= "\n".$this->Eq['D']['spec'];
	if ($this->Eq['E']['spec'])			$this->Specs .= "\n".$this->Eq['E']['spec'];
	if ($this->Tactics['spec'] == 'AllWepStirke')	$this->Specs .= "\n".$this->Eq['B']['spec']."\n".$this->Eq['C']['spec'];

}

function analyseSeedMode($SEEDStat, $isPlayer = true, $Bias = 1){
//Analyze SEED Mode - Controlled Start
	$SEED_Controlled = false;

	//Determine SEED
	if(strpos($this->Player['spec'], 'SeedMode') !== false) $SEED_Controlled = true;
	elseif(strpos($this->Specs, 'SeedMode') === false) return false;

	// SEED Controlled
	if($SEED_Controlled){
		$allowedType = ($this->Player['typech'] == 'co' || $this->Player['typech'] == 'ext' || $this->Player['typech'] == 'nat');
		$SP_State = ($this->Player['sp']/$this->Player['spmax'] >= 0.2 && $this->Player['sp'] >= 20);
		// Lose SEED if not designated types
		if(!$allowedType){
			$this->Player['hypermode'] = 0;
			$this->Player['spec'] = str_replace('SeedMode, ','',$this->Player['spec']);
			return true;	// Update SeedMode State on Specs
		}
		// Control Deactivation / Force Deactivation
		elseif((!$SEEDStat && $isPlayer) || !$SP_State){
			$this->Player['hypermode'] = 0;
		}
		// Control Activation
		elseif($SEEDStat && $isPlayer){
			$this->Player['hypermode'] = 1;
		}
	}

	// SEED Trigger
	else{
		$Trigger_State = ($this->Player['hp']/$this->Player['hpmax'] <= 0.75 && $this->Player['sp']/$this->Player['spmax'] >= 0.85);
		if($Trigger_State){
			$PercentageSEED = ceil($this->Player['level']/10);
			if($this->Player['typech'] == 'co')                    $PercentageSEED *= 3;
			elseif($this->Player['typech'] == 'ext')               $PercentageSEED *= 2;
			if ($this->Player['hp']/$this->Player['hpmax'] <= 0.3) $PercentageSEED *= 2;
			if ($this->Player['sp'] == $this->Player['spmax'])     $PercentageSEED *= 1.5;
			if (mt_rand(0,(1000 * $Bias)) <= $PercentageSEED){
				$this->Player['hypermode'] = 1;
				$this->Player['spec'] .= 'SeedMode, ';
				return true;
			}
		}
	}

	// Default: Do not Update SeedMode State
	return false;
}

function applySpecFixEffects(&$Spec_Event_Tag, $isActive = true){

	//SEED Mode Effects
	$this->applySEEDMode();

	$this->Base_Fixes = $this->PiFix;

	//Tactic Fixes
	$this->PiFix['attacking'] += $this->Tactics['atf'];
	$this->PiFix['defending'] += $this->Tactics['def'];
	$this->PiFix['reacting']  += $this->Tactics['ref'];
	$this->PiFix['targeting'] += $this->Tactics['taf'];

	//AtkA Effect
	$Spec_AtkA_R= mt_rand(0,100);
	if(strpos($this->Specs,'AtkA') !== false && $Spec_AtkA_R >= 50){
		$this->PiFix['attacking'] += 20;
		$Spec_Event_Tag .= ( $isActive ) ? "<Br>你進入了興奮狀態！" : "<Br>對手進入了興奮狀態！";
	}

	//DefX Effect
	$DefX_pc = mt_rand(0,99);
	$DefX2_pc = mt_rand(0,99);
	$hasDefXinSpec = (strpos($this->Specs,'DefX') !== false);
	if($hasDefXinSpec || $this->Player['hypermode'] == 3){
		if($DefX_pc >= 40) {
			$this->PiFix['defending'] += 15;
			$Spec_Event_Tag .= ( $isActive ) ? "<Br>你的底力爆發了！" : "<Br>對方底力爆發了！";
			if($hasDefXinSpec && $this->Player['hypermode'] == 3){
				if($DefX2_pc >= 80) {
					$this->PiFix['defending'] += 15;
					$Spec_Event_Tag .= ( $isActive ) ? "<Br>你念動力之底力爆發了！" : "<Br>對方念動力之底力爆發了！";
				}
			}
		}
	}

	//Apply Fixes
	$this->Player['attacking'] += $this->PiFix['attacking'];
	$this->Player['defending'] += $this->PiFix['defending'];
	$this->Player['reacting']  += $this->PiFix['reacting'];
	$this->Player['targeting'] += $this->PiFix['targeting'];
	
}

function applyBonus(){
	//Fix Bonus
	//1% Ability Bonus Every 15% Ability
	$this->Player['attacking'] += floor( $this->Player['attacking'] * $this->Player['attacking']/1500 );
	$this->Player['defending'] += floor( $this->Player['defending'] * $this->Player['defending']/1500 );
	$this->Player['reacting']  += floor( $this->Player['reacting']  * $this->Player['reacting']/1500  );
	$this->Player['targeting'] += floor( $this->Player['targeting'] * $this->Player['targeting']/1500 );
}

function applyEffectsForMS(&$Op){

	//Kill Certain Specs
		//PerfDef
		if(strpos($this->Specs,'PerfDef') !== false && (($this->Eq['D']['id'] != 0 && $this->Eq['D']['exp'] < 1000) || ($this->Eq['E']['id'] != 0 && $this->Eq['E']['exp'] < 1000)))
			$this->Specs = str_replace('PerfDef','',$this->Specs);
		if(strpos($Op->Specs,'PerfDef') !== false && (($Op->Eq['D']['id'] != 0 && $Op->Eq['D']['exp'] < 1000) || ($Op->Eq['E']['id'] != 0 && $Op->Eq['E']['exp'] < 1000)))
			$Op->Specs = str_replace('PerfDef','',$Op->Specs);
		//AntiPDef
		if(strpos($this->Specs,'AntiPDef') !== false && $this->Eq['A']['exp'] < 1000) $this->Specs = str_replace('AntiPDef','',$this->Specs);
		if(strpos($Op->Specs,'AntiPDef') !== false && $Op->Eq['A']['exp'] < 1000) $Op->Specs = str_replace('AntiPDef','',$Op->Specs);

	// Loop Pl & Op
	$Pl = &$this;
	$k = array('Pl','Op');
	$ee = array('A','D','E');
	foreach($k as $u){
		//Lower-case Mob Alterations
		$i = array();	$p = 0;
			foreach($ee as $e){
				$pos = strpos($$u->Eq[$e]['spec'],'Mob');
				if($pos !== false && $$u->Eq[$e]['exp'] > 1000){
					$str = substr($$u->Eq[$e]['spec'], $pos + 3, 1);
					switch($str){
						case 'e': $j = $$u->Eq[$e]['exp'] - 5000; $i[$p] = ($j > 5000) ? 5000 : $j; break;
						case 'd': $j = $$u->Eq[$e]['exp'] - 4000; $i[$p] = ($j > 4000) ? 4000 : $j; break;
						case 'c': $j = $$u->Eq[$e]['exp'] - 3000; $i[$p] = ($j > 3000) ? 3000 : $j; break;
						case 'b': $j = $$u->Eq[$e]['exp'] - 2000; $i[$p] = ($j > 2000) ? 2000 : $j; break;
						case 'a': $j = $$u->Eq[$e]['exp'] - 1000; $i[$p] = ($j > 1000) ? 1000 : $j; break;
					}
				} else $i[$p] = 0;
				$p++;
			}
		rsort($i);
		if($i[0] > 0) $$u->Specs .= "\nMobS<".$i[0].'>, ';
	}

	$list = array('Pl', 'Op');
	//Type Lower-Case Specs of Hit Values
	$TarSGd['Pl']=$TarSEffect['Pl']=$TarSGd['Op']=$TarSEffect['Op']=0;
	foreach($list as $v){
		if(strpos($$v->Specs,'Tare') !== false) $TarSGd[$v] = 5;
		elseif(strpos($$v->Specs,'Tard') !== false) $TarSGd[$v] = 4;
		elseif(strpos($$v->Specs,'Tarc') !== false) $TarSGd[$v] = 3;
		elseif(strpos($$v->Specs,'Tarb') !== false) $TarSGd[$v] = 2;
		elseif(strpos($$v->Specs,'Tara') !== false) $TarSGd[$v] = 1;
	}
	//End Lower-Case Specs of Hit Values
	//Type Upper-Case Specs of Hit and Miss Values
	for($i=0;$i<=1;$i++){
		$j = ( $i == 0 ) ? 'Pl' : 'Op';
		$k = ( $i == 0 ) ? 'Op' : 'Pl';
		//Tactics Fixes for Miss & Hit
			$$j->MS['ref'] += $$j->Tactics['missf'];
			$$j->MS['taf'] += $$j->Tactics['hitf'];
		//Cease Effect
			$CeaseFlag[$j]=0;
			if(strpos($$k->Specs, 'Cease') !== false){
				$$j->MS['ref']-=5;
				$$j->MS['taf']-=5;
				$CeaseFlag[$j]=1;
			}

		//Upper-case Mob Effects
		$$j->applyMSMobU($CeaseFlag[$j]);

		//Upper-case Tar Effect
		$$j->applyMSTarU($CeaseFlag[$j]);

		//Upper-case Def Specs
		$$j->applyMSDefU();

		//Melt Effects
		if(strpos($$j->Specs,'MeltB') !== false && $$j->Eq['A']['exp'] > 1000)      $$k->MS['def']	-= 10;
		elseif(strpos($$j->Specs,'MeltA') !== false && $$j->Eq['A']['exp'] > 1000)  $$k->MS['def']	-= 5;
	}
	//Apply TarS
	if($TarSGd['Pl'] > $TarSGd['Op']){
		$TarSEffect['Pl'] = ($TarSGd['Pl'])/10;
		$this->MS['taf'] = floor($this->MS['taf'] * (1 + $TarSEffect['Pl']));
	}
	if($TarSGd['Op'] > $TarSGd['Pl']){
		$TarSEffect['Op'] = ($TarSGd['Op'])/10;
		$Op->MS['taf'] = floor($Op->MS['taf'] * (1 + $TarSEffect['Op']));
	}

}

function msDamageSpec(&$Spec_Event_Tag, &$Resulting_EN, &$DamA_S_Flag, $StrikePercentage, $isActive=true){
	$DamA_S_R = mt_rand(0,100);
	if(strpos($this->Eq['A']['spec'],'DamA') !== false && $DamA_S_R >= 85 && $this->Eq['A']['exp'] >= 0 && $StrikePercentage > 0){
		$Resulting_EN	=  floor($Resulting_EN * 0.5);
		$Spec_Event_Tag	.= ($isActive) ? "<br>對手的機體被損壞，剩餘能源下降！" : "<br>你的機體被對手損壞，剩餘能源下降！";
		$DamA_S_Flag	= ($this->Eq['A']['exp'] > 10000) ? 30 : 10;
	}
}

function sendError($Msg){
	echo $Msg;
	postFooter();
	exit;
}

}

?>