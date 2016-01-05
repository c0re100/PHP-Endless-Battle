<?php
//
// Template of Set Spec Class
// Requirements: sfo.class, spc.superclass <some may require obattle.ext.php>
// Modifications Required: 
// 1. 把 "sSpc_template" 更名為 "sSpc_<編號>", <編號> 自定, 不能重覆; 共4處需更改 (Class Name x2, Constructor x2)
// 2. 因需要更改各 Phase 內的 Code
//     - 可以使用所有 sfo.class 的 variables, 及因需要套取 obattle.ext 的 variables
//

class sSpc_template extends setSpecSuperClass{
	
	const cName = 'sSpc_template';

	// Class Variables - 使用者變數
	var $Rq_MS;
	var $Rq_Wep;

	// System Variables - sfo.class/obattle.ext 的變數
	var $Pl;
	var $Op;

	// Constructors
	function __construct($Pl, $Op){
		$this->sSpc_template($Pl, $Op);
	}
	
	function sSpc_template($Pl, $Op){
		$this->Activated = false;
		$this->Rq_MS = 'template';        // 需要MS ID
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
		// Insert Code Here
		if($this->Activated){
			$this->removeReqStat();
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