<?php
//
// DX Set Spec Class
// Requirements: sfo.class, spc.superclass
//

class sSpc_9903 extends setSpecSuperClass{
	
	const cName = 'sSpc_9903';

	// Class Variables - 使用者變數
	var $Rq_MS;
	var $Rq_Wep;

	// System Variables - sfo.class/obattle.ext 的變數
	var $Pl;
	var $Op;

	// Constructors
	function __construct($Pl, $Op){
		$this->sSpc_9903($Pl, $Op);
	}
	
	function sSpc_9903($Pl, $Op){
		$this->Activated = false;
		$this->Rq_MS = '9903';        // 需要MS ID
		$this->Rq_Wep['A'] = '';  // 需要主武器 ID, 設為 false 則不限制
		$this->Rq_Wep['B'] = '';  // 需要備用 1 ID, 同上
		$this->Rq_Wep['C'] = '';  // 需要備用 2 ID, 同上
		$this->Rq_Wep['D'] = '';  // 需要輔助裝備 ID, 同上
		$this->Pl = $Pl;
		$this->Op = $Op;
	}

	// Check Set Activation - 基本條件檢測
	// Checks whether MS and Equipment match required.
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
		if( $this->Pl->Eq['A']['id'] == '單衛' || $this->Activated ){
			str_replace(array('NTCustom','CostSP'),'rm',$this->Pl->Eq['A']['spec']);
			if(this->Activated){
				$this->removeReqStat();
				$this->Pl->Eq['A']['atk'] += 0;
				$this->Pl->Eq['A']['rd']  += 0;
				$this->Pl->Eq['A']['enc'] += 0;
			}
		}
	}

	// Metaphase Modifications
	public function metaphase(){
		// Insert Code Here
	}

	// Battle Phase (Outer) Modifications
	public function battlephase(){
		// Insert Code Here
	}

}

?>