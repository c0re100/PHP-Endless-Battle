<?php
//
// Wing-Zero Custom Set Spec Sub-system
// Requirements: sfo.class, spc.superclass
//

class sSpc_9906 extends setSpecSuperClass{
	
	const cName = 'sSpc_9906';

	// User Variables - 使用者變數
	var $Rq_MS;
	var $Rq_Wep;
	var $Pl;

	// Constructors
	function __construct($Pl){
		$this->sSpc_9906($Pl);
	}
	
	function sSpc_9906($Pl){
		$this->Activated = false;
		$this->Rq_MS = '9906';        // 需要MS ID
		$this->Rq_Wep['A'] = '';  // 需要主武器 ID
		$this->Rq_Wep['B'] = '';  // 需要備用 1 ID
		$this->Rq_Wep['C'] = '';  // 需要備用 2 ID
		$this->Rq_Wep['D'] = false;  // 需要輔助裝備 ID
		$this->Pl = $Pl;
	}

	// Check Set Activation - 基本條件檢測
	public function checkSetActivation(){
		$this->Activated = true;
		if($this->Pl->MS['id'] != $this->Rq_MS) $this->Activated = false;
		else {
			foreach(array('A','B','C','D') as $v){
				if(!$this->Rq_Wep[$v]) continue;
				if ($this->Pl->Eq[$v]['id'] != $this->Rq_Wep[$v]){
					$this->Activated = false;
					break;
				}
			}
		}
	}

	// Prephase Modifications
	public function prephase(){
		$this->Pl->PiFix['attacking'] *= 2;
		$this->Pl->PiFix['defending'] *= 2;
		$this->Pl->PiFix['reacting']  *= 2;
		$this->Pl->PiFix['targeting'] *= 2;
		if($this->Activated){
			$this->removeReqStat();
			$this->Pl->Eq['A']['hit']  = floor($this->Pl->Eq['A']['hit'] * 1.15);
			$this->Pl->Eq['A']['atk'] += 0;
			$this->Pl->Eq['A']['rd']  += 0;
			$this->Pl->Eq['A']['enc'] += 0;
		}
	}

}

?>