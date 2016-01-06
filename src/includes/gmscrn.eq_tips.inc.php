<?php

/*
	Game Screen Equipment Tips Functions Include
	Suitable for gmscrn_base based structures
	Requires use of:
		- php files:
			- sfo.class.php
		- JavaScripts:
			- Layering Script (Embedded)
*/

function returnEqLocation($EqL){
	switch($EqL){
	case 'A':return '使用武器';break;
	case 'B':return '備用一';break;
	case 'C':return '備用二';break;
	case 'D':return '輔助裝備';break;
	case 'E':return '常規裝備';break;
	}
}

function prepBasixEqInfoString($Pl, $I, &$W_Inf){
	$W_Inf[$I] = "裝備能力:<br>";
	$W_Inf[$I] .= "　攻擊力: ".$Pl->Eq[$I]['atk']."　　　回數: ".$Pl->Eq[$I]['rd']."<br>　命中: ".$Pl->Eq[$I]['hit']."　　　EN消費: <span id=EqmEnc_".$I.">".$Pl->Eq[$I]['enc']."</span><br>";

	// Prepare Range/Attribute
	$W_Inf[$I] .= "距離/屬性: ".getRangeAttrb($Pl->Eq[$I]['range'],$Pl->Eq[$I]['attrb'],$Pl->Eq[$I]['equip'],false)."<br>";

	// Prepare Special Effects
	$W_Inf[$I] .= "特殊效果:<br>";
	if (!$Pl->Eq[$I]['spec'] && !$Pl->Eq[$I]['equip']) $W_Inf[$I] .= "沒有";
	else{
		if ($Pl->Eq[$I]['equip']) $W_Inf[$I] .= "可以裝備<br>";
		if ($Pl->Eq[$I]['spec'])  $W_Inf[$I] .= ReturnSpecs($Pl->Eq[$I]['spec']);
	}
}

function printQuickEquipNamePhrase($I,$id,$name,&$W_Inf){
	if ($id == '0') $EqmStyle = 'visibility: hidden; position: absolute;';
	else $EqmStyle = '';
	echo "<b id=EqmL_".$I." style=\"$EqmStyle\">".returnEqLocation($I)."</b>";
	echo "<span id=EqmDis_".$I." style=\"visibility: hidden; position: absolute;\">".$W_Inf[$I]."</span>";
	echo "<div style=\"padding-left: 8px;$EqmStyle\" id=Eqm_".$I;
	echo "  OnMouseOver=\"setLayer(event.clientX,event.clientY,200,100,'document.getElementById(\'EqmDis_".$I."\').innerHTML')\" OnMouseOut=\"offLayer()\" ";
	echo "><span id=EqmName_".$I.">".$name."</span>";
}

function printCondLevel($Pl, $I){
	$Pl->Eq[$I]['displayXp'] = expToStatus($Pl->Eq[$I]['exp']);
	echo "<br>狀態值: <span id=EqmExp_".$I.">".$Pl->Eq[$I]['displayXp']."</span>";
}

function printQuickEquipSpanTag($V,$I,$j,$k,$actb,$boolTag,$boolStr){
	echo "<span id='Eq".$j."_btn_".$I."' style=\"cursor: pointer; font-size: 8pt;color: ForestGreen;\" OnMouseOver=\"this.style.color='Yellow'\" OnMouseOut=\"this.style.color='ForestGreen'\" OnClick=\"";
	echo "this.innerHTML='';";
	if($k) echo "document.getElementById('Eq".$k."_btn_".$I."').innerHTML='';";
	echo "document.proc_tar.action='equip.php?action=equipwep';document.proc_tar.actionb.value='$actb';document.proc_tar.actionc.value='rt_equip';document.proc_tar.slot_sw.value='".$V."';document.proc_tar.submit();\">";
	if($boolTag) echo $boolStr;
	echo "</span>";
}

?>