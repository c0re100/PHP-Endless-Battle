<?php
//
// 9902 of Set Spec Class
// Requirements: sfo.class, spc.superclass <some may require obattle.ext.php>
// Modifications Required: 
// 1. 把 "sSpc_9902" 更名為 "sSpc_<編號>", <編號> 自定, 不能重覆; 共4處需更改 (Class Name x2, Constructor x2)
// 2. 因需要更改各 Phase 內的 Code
//     - 可以使用所有 sfo.class 的 variables, 及因需要套取 obattle.ext 的 variables
//

class sSpc_9902 extends setSpecSuperClass{
	
	const cName = 'sSpc_9902';

	// Class Variables - 使用者變數
	var $Rq_MS;
	var $Rq_Wep;

	// System Variables - sfo.class/obattle.ext 的變數
	var $Pl;
	var $Op;

	// Constructors
	function __construct($Pl, $Op){
		$this->sSpc_9902($Pl, $Op);
	}
	
	function sSpc_9902($Pl, $Op){
		$this->Activated = false;
		$this->Rq_MS = '9902';        // 需要MS ID
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
		if($this->Op){
			$this->Op->Eq['A']['hit'] = floor($this->Op->Eq['A']['hit'] * 1);
		}
		if($this->Activated){
			$this->removeReqStat();
			$this->Pl->Eq['A']['atk'] += 0;
			$this->Pl->Eq['A']['rd']  += 0;
			$this->Pl->Eq['A']['enc'] += 0;
			$this->Pl->Eq['A']['spec'] .= ' , CostSP<1>, AntiPDef, DamB';
			if($this->Op){
				$this->Pl->SP_Cost += 1;
				$this->Op->SP_Cost += 0;
			}
		}
	}

}

?>