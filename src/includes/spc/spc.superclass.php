<?php
//
// Set Spec Sub-system Superclass
//

class setSpecSuperClass{

	var $Activated;
	
	function __construct(){
		$this->setSpecSuperClass();
	}
	
	function setSpecSuperClass(){
		$this->Activated = false;
	}
	
	public function checkSetActivation();
	public function prephase();
	public function metaphase();
	public function battlephase();
	
	public function removeReqStat(){
		foreach($this->Eq as $Equip){
			if(!isset($Equip['spec']) || $Equip['spec'] == '') continue;
			str_replace('ReqStat','rm',$Equip['spec']);
		}
	}

}

?>