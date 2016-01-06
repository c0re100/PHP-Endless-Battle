<?php
//php-eb UE Game Statistics Fetcher Object
//Basics

class player_stats {

var $Player;
var $PiFix = Array('attacking' => 0, 'defending' => 0, 'reacting' => 0, 'targeting' => 0);
var $User;
var $MS;
var $Eq = Array('A' => '', 'B' => '', 'C' => '', 'D' => '', 'E' => '');

// Special Ability Pool
var $Specs;       // Set after generateSpecialAbilityPool() is called

// For Set Spec
var $SetSpec;
var $SetSpecID;

//SetUser - Start
function SetUser($Username) {
	$this->User = $Username;
}
//SetUser - End

//FetchPlayer Stats - Start
function FetchPlayer($FetchEssentialSettings=false,$FetchFilterSettings=false){
$SelectionFeilds = "`Gen`.`username` AS `name`, `gamename`, `cash`, `bounty`, `color`, `avatar`, ".
		"`msuit`, " .
		"`typech`, `hypermode`, `growth`, `coordinates`, `fame`, ".
		"`time1`, `time2`, `btltime`, `acc_status`, ".
		"`hp`, `hpmax`, `en`, `enmax`, `sp`, `spmax`, ".
		"`attacking`, `defending`, `reacting`, `targeting`, ".
		"`ms_custom`, `level`, `expr`, `wepa`, `wepb`, `wepc`, `eqwep`, `p_equip`, ".
		"`spec`, `rank`, `rights`, `organization`, `org_group`, ".
		"`tactics`, `last_tact`, `status`, `victory`, `v_points`";

$SelectionFeilds .= ($FetchEssentialSettings == true) ?
', `gen_img_dir`, `unit_img_dir`, `base_img_dir`, `show_log_num`, `atkonline_alert`, `battle_def_filter`' : '';

$SelectionFeilds .= ($FetchFilterSettings == true) ?
', `fdis_at`, `fdis_de`, `fdis_re`, `fdis_ta`, `fdis_lv`, `fdis_hp`, `fdis_fame`, `fdis_bty`, `fdis_ms`, '.
'`fdis_tch`, `fdis_con`, `filter_at_min`, `filter_at_max`, `filter_de_min`, `filter_de_max`, `filter_re_min`, '.
'`filter_re_max`, `filter_ta_min`, `filter_ta_max`, `filter_lv_min`, `filter_lv_max`, `filter_hp_min`, `filter_hp_max`,'.
' `filter_fame_min`, `filter_fame_max`, `filter_bty_min`, `filter_bty_max`, `filter_con`, `filter_sort`, `filter_sort_asc`' : '';

$SQL = "SELECT ". $SelectionFeilds ." FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `Gen`, `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `Game`";
$SQL .= ($FetchEssentialSettings == true || $FetchFilterSettings == true) ? ', `'.$GLOBALS['DBPrefix'].'phpeb_user_settings` `Settings`' : '';
$SQL .= " WHERE `Gen`.`username` = '". $this->User ."' AND `Gen`.`username` = `Game`.`username`";
$SQL .= ($FetchEssentialSettings == true || $FetchFilterSettings == true) ? ' AND `Gen`.`username` = `Settings`.`username`' : '';

$Query = mysql_query($SQL) or die ('<hr>MySQL 資料庫存取錯誤, 請聯絡GM, 錯誤代號 SFO-000<br>');
$this->Player = mysql_fetch_array($Query);
}
//FetchPlayer Stats - End

//Start Process Weapon Function
function ProcessWeapon($Slot='A') {
	switch($Slot){
		case 'A': $W_Slot = $this->Player['wepa']; break;
		case 'B': $W_Slot = $this->Player['wepb']; break;
		case 'C': $W_Slot = $this->Player['wepc']; break;
		case 'D': $W_Slot = $this->Player['eqwep']; break;
		case 'E': $W_Slot = $this->Player['p_equip']; break;
	}
	$W_Params = explode('<!>',$W_Slot);

	$SQL = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $W_Params[0] ."'");
	$Query = mysql_query($SQL);
	$Weapon = mysql_fetch_array($Query);

	$W_Params[2] = ( isset($W_Params[2]) ) ? $W_Params[2] : 0;

		if ($W_Params[2]){
			if ($W_Params[2] == 1) $Weapon['name'] = $W_Params[3].$Weapon['name']."<sub>&copy;</sub>";
			else $Weapon['name'] = $Weapon['name'].$W_Params[3]."<sub>&copy;</sub>";
			$Weapon['atk'] += $W_Params[4];
			$Weapon['hit'] += $W_Params[5];
			$Weapon['rd'] += $W_Params[6];
			$Weapon['enc'] = $W_Params[7];
		}
	return $Weapon;
}
//End Process Weapon Function

//Start Set Eq Variable Function
function SetEq($Type='All') {
	switch($Type){
		case 'All':
			$this->Eq['A'] = $this->ProcessWeapon();
			$this->Eq['B'] = $this->ProcessWeapon('B');
			$this->Eq['C'] = $this->ProcessWeapon('C');
			$this->Eq['D'] = $this->ProcessWeapon('D');
			$this->Eq['E'] = $this->ProcessWeapon('E');
		break;
		case 'A': $this->Eq['A'] = $this->ProcessWeapon(); break;
		case 'B': $this->Eq['B'] = $this->ProcessWeapon('B'); break;
		case 'C': $this->Eq['C'] = $this->ProcessWeapon('C'); break;
		case 'D': $this->Eq['D'] = $this->ProcessWeapon('D'); break;
		case 'E': $this->Eq['E'] = $this->ProcessWeapon('E'); break;
	}
}
//End Set Eq Variable Function

//Start Process All Weapon Function
function ProcessAllWeapon() {
	$Id_Phrase = '';
	for($i=1;$i <= 5;$i++){
	switch($i){
		case 1: $W_Slot = $this->Player['wepa']; break;
		case 2: $W_Slot = $this->Player['wepb']; break;
		case 3: $W_Slot = $this->Player['wepc']; break;
		case 4: $W_Slot = $this->Player['eqwep']; break;
		case 5: $W_Slot = $this->Player['p_equip']; break;
	}
	$W_Params[$i] = explode('<!>',$W_Slot);
	$Id_Phrase .= ($i == 5) ? 'id =\''. $W_Params[$i][0] .'\'' : 'id =\''. $W_Params[$i][0] .'\' OR ';
	unset($W_Slot);
	}

	$SQL = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE " . $Id_Phrase);
	$Query = mysql_query($SQL);

	$j = 0;
	while($Weapon = mysql_fetch_array($Query)) {$Weapon_Raw[$j] = $Weapon; $j++;}

	for($k=1;$k<=5;$k++){
	$A = 'A';
	switch($k){
		case 2: $A = 'B';break;
		case 3: $A = 'C';break;
		case 4: $A = 'D';break;
		case 5: $A = 'E';break;
	}
		for($l=0;$l < $j;$l++) {
			if ($W_Params[$k][0] != $Weapon_Raw[$l]['id']) continue;
			$this->Eq[$A] = $Weapon_Raw[$l];
		}
		
	$this->Eq[$A]['exp']=$W_Params[$k][1];
	$W_Params[$k][2] = ( isset($W_Params[$k][2]) ) ? $W_Params[$k][2] : 0;
		if ($W_Params[$k][2]){
			if ($W_Params[$k][2] == 1) $this->Eq[$A]['name'] = $W_Params[$k][3].$this->Eq[$A]['name']."<sub>&copy;</sub>";
			else $this->Eq[$A]['name'] = $this->Eq[$A]['name'].$W_Params[$k][3]."<sub>&copy;</sub>";
			$this->Eq[$A]['atk'] += $W_Params[$k][4];
			$this->Eq[$A]['hit'] += $W_Params[$k][5];
			$this->Eq[$A]['rd'] += $W_Params[$k][6];
			$this->Eq[$A]['enc'] = $W_Params[$k][7];
		}
	}

}
//End Process All Weapon Function

//Start ProcessMS
function ProcessMS($RecordBase = false){
	$SQL = ("SELECT `id`, `msname`, `atf`, `def`, `ref`, `taf`, `hpfix`, `enfix`, `hprec`, `enrec`, `spec`, `needlv`, `price`, `image` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE id='". $this->Player['msuit'] ."'");
	$Query = mysql_query($SQL);
	$this->MS = mysql_fetch_array($Query);

	if($this->Player['level'] < $this->MS['needlv']){
		$this->MS['atf']=$this->MS['def']=$this->MS['ref']=$this->MS['taf']=0;
		return;
	}

	//Record Base
	if($RecordBase){
		$this->MS['base']['atf'] = $this->MS['atf'];
		$this->MS['base']['def'] = $this->MS['def'];
		$this->MS['base']['ref'] = $this->MS['ref'];
		$this->MS['base']['taf'] = $this->MS['taf'];
	}

	// Add Modification
	$this->addMSModifications();
}

function addMSModifications(){
	//MS Status Modifications
	if ($this->Player['ms_custom']) $Custom = explode('<!>',$this->Player['ms_custom']);
	else $Custom = array(0,0,0,0,0);
	if ($Custom[0]) $this->MS['msname'] = $Custom[0]."<sub>&copy;</sub>";
	$this->MS['atf']+=$Custom[1];
	$this->MS['def']+=$Custom[2];
	$this->MS['ref']+=$Custom[3];
	$this->MS['taf']+=$Custom[4];
}
//End ProcessMS

function getTypeLevel(){
	$TypeRank = floor($this->Player['level']/10) + 1;
	if($TypeRank > 16) $TypeRank = 16;
	elseif($TypeRank < 1) $TypeRank = 1;
	return $TypeRank;
}

//Start Pilot Fixes
function iniFixes($getName = false){
	$Selection = '`atf`, `def`, `ref`, `taf`';
	if($getName) $Selection .= ', `name`';
	$SQL = ("SELECT $Selection FROM `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` WHERE `id` = '". $this->Player['typech'] ."' AND `typelv` = ".$this->getTypeLevel().";");
	$Query = mysql_query($SQL) or die ('<hr>MySQL 資料庫存取錯誤, 請聯絡GM, 錯誤代號 SFO-001<br>');
	$Type = mysql_fetch_array($Query);
	$this->PiFix['attacking'] = $Type['atf'];
	$this->PiFix['defending'] = $Type['def'];
	$this->PiFix['reacting'] = $Type['ref'];
	$this->PiFix['targeting'] = $Type['taf'];
	if($getName) $this->Player['type_name'] = $Type['name'];
}

// Set Spec Sub-System
function checkSetSpec(){
	if(preg_match('/set<([0-9]+)>/', $this->Eq['E']['spec'], $set)){
		$SetSpecID = $set[1];
	}
	else $SetSpecID = 0;
}

function generateSpecialAbilityPool(){
	$this->Specs = $this->Player['spec']."\n".$this->MS['spec']."\n".$this->Eq['A']['spec'];
	if ($this->Eq['D']['spec'])			$this->Specs .= "\n".$this->Eq['D']['spec'];
	if ($this->Eq['E']['spec'])			$this->Specs .= "\n".$this->Eq['E']['spec'];
}

// Spec Functions

function analyzeHypermodeState(){
	if ($this->Player['level'] >= 70) {
	        if ($this->Player['hypermode'] == 0){
	                if($this->Player['typech'] == 'nt' || $this->Player['typech'] == 'enh') $this->Player['hypermode'] = 2;
	                elseif($this->Player['typech'] == 'psy') $this->Player['hypermode'] = 3;
	                return;
	        }
	        elseif ($this->Player['hypermode'] == 4 && $this->Player['typech'] == 'enh') $this->Player['hypermode'] = 6;
	}
}

function applyEXAM(){
	//EXAM System Effects
	if ($this->Player['hypermode'] >= 4 && $this->Player['hypermode'] <= 6){
		//Natural
		if ($this->Player['typech'] == 'nat') {
			$this->PiFix['attacking'] += 15;
			$this->PiFix['defending'] -= 6;
			$this->PiFix['reacting']  -= 4;
			$this->PiFix['targeting'] += 10;
			if($this->Player['level'] >= 100){
				$this->PiFix['attacking'] += 10;
				$this->PiFix['defending'] -= 3;
				$this->PiFix['reacting']  -= 2;
				$this->PiFix['targeting'] += 5;
			}
		}
		//Enhanced & Extended
		elseif ($this->Player['typech'] == 'enh' || $this->Player['typech'] == 'ext') {
			$this->PiFix['attacking'] += 10;
			$this->PiFix['defending'] -= 3;
			$this->PiFix['reacting']  -= 2;
			$this->PiFix['targeting'] += 10;
			if($this->Player['level'] >= 100){
				$this->PiFix['attacking'] += 5;
				$this->PiFix['targeting'] += 5;
			}
		}
	}
}

function applySEEDMode(){
	//SEED Mode Effects
	if ($this->Player['hypermode'] == 1 || $this->Player['hypermode'] == 5){
		//Coordinator
		if ($this->Player['typech'] == 'co') {
			$this->PiFix['attacking'] += floor($this->Player['attacking'] * 0.15);
			$this->PiFix['defending'] += floor($this->Player['defending'] * 0.15);
			$this->PiFix['reacting']  += floor($this->Player['reacting'] * 0.15);
			$this->PiFix['targeting'] += floor($this->Player['targeting'] * 0.15);
		}
		//Extended
		elseif ($this->Player['typech'] == 'ext') {
			$this->PiFix['attacking'] += floor($this->Player['attacking'] * 0.15);
			$this->PiFix['reacting']  += floor($this->Player['reacting'] * 0.15);
			$this->PiFix['targeting'] += floor($this->Player['targeting'] * 0.05);
		}
		//Natural
		elseif ($this->Player['typech'] == 'nat') {
			$this->PiFix['defending'] += floor($this->Player['defending'] * 0.175);
			$this->PiFix['reacting']  += floor($this->Player['reacting'] * 0.175);
		}
	}
}

function applyTypeCustoms(){
//Specs - Type Customs
	$NT_Power = ($this->Player['typech'] == 'nt' || $this->Player['typech'] == 'enh');
	$CO_Power = ($this->Player['typech'] == 'co' || $this->Player['typech'] == 'ext');
	$PSY_Power = ($this->Player['typech'] == 'psy');
	
	$hasNTCustom = (strpos($this->Eq['A']['spec'],'NTCustom') !== false);
	$hasNTRequired = (strpos($this->Eq['A']['spec'],'NTRequired') !== false);
	$hasCOCustom = (strpos($this->Eq['A']['spec'],'COCustom') !== false);
	$hasPsyRequired = (strpos($this->Eq['A']['spec'],'PsyRequired') !== false);
	
	if($hasNTCustom){
		if(!$NT_Power){
			$this->Eq['A']['atk']	= 0;
			$this->Eq['A']['rd']	= 1;
			$this->Eq['A']['spec']	= 'NTCustom';
		}
	}
	if($hasNTRequired){
		if(!$NT_Power) $this->Eq['A']['atk']	*= 0.5;
	}
	if($hasCOCustom){
		if(!$CO_Power){
			$this->Eq['A']['atk']	= 0;
			$this->Eq['A']['rd']	= 1;
			$this->Eq['A']['spec']	= 'COCustom';
		}
	}
	if($hasPsyRequired){
		if(!$PSY_Power){
			$this->Eq['A']['atk']	= 0;
			$this->Eq['A']['rd']	= 1;
			$this->Eq['A']['spec']	= 'PsyRequired';
		}
	}

	//Specs For Equipments - Type Customs
	$list = array('D','E');
	foreach($list as $v){
		$hasNTCustom = (strpos($this->Eq[$v]['spec'],'NTCustom') !== false);
		$hasNTRequired = (strpos($this->Eq[$v]['spec'],'NTRequired') !== false);
		$hasCOCustom = (strpos($this->Eq[$v]['spec'],'COCustom') !== false);
		$hasPsyRequired = (strpos($this->Eq[$v]['spec'],'PsyRequired') !== false);

		if($hasNTCustom || $hasNTRequired){
			if(!$NT_Power)	$this->Eq[$v]['spec'] = '';
		}
		if($hasCOCustom){
			if(!$CO_Power)	$this->Eq[$v]['spec'] = '';
		}
		if($hasPsyRequired){
			if(!$PSY_Power)	$this->Eq[$v]['spec'] = '';
		}
	}
//End of Type Spec Customs
}

function deterSpecRequirements(){
	$ea = array('A','D','E');
	$rs = array('At' => 'attacking','De' => 'defending','Re' => 'reacting','Ta' => 'targeting');

	$RegenSpecsFlag = false;

	foreach($ea as $k){
		if(preg_match('/ReqEqCond<([0-9]+)>/',$this->Eq[$k]['spec'],$a))
			if($this->Eq[$k]['exp'] < $a[1]){
				$this->Eq[$k]['atk']	= 0;
				$this->Eq[$k]['rd']	= 1;
				$this->Eq[$k]['spec']	= '';
				$RegenSpecsFlag		= true;
				continue;
			}
		unset($a);
		foreach($rs as $l => $m){
			$RegExp = "/ReqStat<$l><([0-9]+)>/";
			if(preg_match($RegExp,$this->Eq[$k]['spec'],$a))
				if($this->Player[$m] < $a[1]){
					$this->Eq[$k]['atk']	= 0;
					$this->Eq[$k]['rd']	= 1;
					$this->Eq[$k]['spec']	= '';
					$RegenSpecsFlag		= true;
					continue;
				}
			unset($a);
		}
	}
	if($RegenSpecsFlag) $this->generateSpecialAbilityPool();
}

function applyMSMobU($Ceaseflag = false){
	//Mob Effects
	if(strpos($this->Specs, 'Mob') !== false){
		if(strpos($this->Specs,'MobD') !== false)     $this->MS['ref'] += 14;
		elseif(strpos($this->Specs,'MobC') !== false) $this->MS['ref'] += 10;
		elseif($CeaseFlag) return;
		elseif(strpos($this->Specs,'MobB') !== false) $this->MS['ref'] += 6;
		elseif(strpos($this->Specs,'MobA') !== false) $this->MS['ref'] += 2;
	}
}

function applyMSTarU($Ceaseflag = false){
	//Tar Effects
	if(strpos($this->Specs, 'Tar') !== false){
		if(strpos($this->Specs,'TarD') !== false)     $this->MS['taf'] += 14;
		elseif(strpos($this->Specs,'TarC') !== false) $this->MS['taf'] += 10;
		elseif($CeaseFlag) return;
		elseif(strpos($this->Specs,'TarB') !== false) $this->MS['taf'] += 6;
		elseif(strpos($this->Specs,'TarA') !== false) $this->MS['taf'] += 2;
	}
}

function applyMSDefU(){
	//Def Effects
	if(strpos($this->Specs, 'Def') !== false){
		if(strpos($this->Specs,'DefE') !== false)     $this->MS['def'] += 15;
		elseif(strpos($this->Specs,'DefD') !== false) $this->MS['def'] += 12;
		elseif(strpos($this->Specs,'DefC') !== false) $this->MS['def'] += 9;
		elseif(strpos($this->Specs,'DefB') !== false) $this->MS['def'] += 6;
		elseif(strpos($this->Specs,'DefA') !== false) $this->MS['def'] += 3;
	}
}

// End of Class Definition
}
?>