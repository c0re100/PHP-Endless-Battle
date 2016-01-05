<?php
//Battle Continual System Include
//Version 1
//Dated: Wednesday, 23 July, 2008
//Copyright(c) v2Alliance 2008

//Start
echo "<form action=battle.php?action=attack_target method=post name=battle_continual>";
echo "<input type=hidden value='process' name=actionb>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden value=0 name='enc'>";
echo "<input type=hidden value=0 name='spc'>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<input type=hidden name=\"Op_Name\" value=\"".$Op_Name."\">";

//Boolean Variables
$bctlHasExam = (strpos($Pl->Player['spec'],'EXAMSystem') !== false);
$bctlHasSEED = (strpos($Pl->Player['spec'],'SeedMode') !== false);
$bctlExamTypeCh = ($Pl->Player['typech'] == 'nat' || $Pl->Player['typech'] == 'ext' || $Pl->Player['typech'] == 'enh');
$bctlSEEDTypeCh = ($Pl->Player['typech'] == 'co' || $Pl->Player['typech'] == 'ext' || $Pl->Player['typech'] == 'nat');
$bctlHasPrsg = (strpos($Pl->Player['spec'],'NTPresage') !== false);


$baseSpCost = 0;
if($bctlHasExam){
	echo "開啟EXAM System<input type=checkbox name=EXAMStat";
	if($Pl->Player['hypermode'] >= 4 && $Pl->Player['hypermode'] <= 6) echo " checked";
	echo ">(SP消耗: 20)<br>";
	$baseSpCost += 20;
}
if($bctlHasSEED && $bctlSEEDTypeCh){
	echo "進入SEED Mode<input type=checkbox name=SEEDStat";
	if($Pl->Player['hypermode'] == 1 || $Pl->Player['hypermode'] == 5) echo " checked";
	echo ">(SP消耗: 20)<br>";
	$baseSpCost += 20;
}
if($Pl->Player['hypermode'] == 2 && $Pl->Player['typech'] == 'nt' && $Pl->Eq['D']['exp'] >= 2500){
	echo "預感 <input type=checkbox name=NTPresage";
	if($bctlHasPrsg) echo " checked";
	echo ">";
}
echo "以<select $BStyleB style=\"$BStyleA\" name=\"Pl_GTctcs\" onchange='changeEnc();changeSpc();'>";
echo "<option value='0'>通常攻擊";
$Cont_TactSpc_Format = '<input type=hidden name=Tact_%s value=%u>';
$Cont_TactSpc = sprintf($Cont_TactSpc_Format,'0',0);
if ($Pl->Player['tactics']){
	$Pl_TactList = explode("\n",$Pl->Player['tactics']);
	sort($Pl_TactList);
	foreach($Pl_TactList as $Tactics){
		$Tactics =trim($Tactics);
		$TactInf = GetTactics($Tactics,'`spc`, `name`');
		if (!$Tactics) unset($Tactics);
		else{	echo "<option value='$Tactics'";
			if ($Tactics == $Pl->Player['last_tact']) {echo " selected";$baseSpCost += $TactInf['spc'];}
			echo ">$TactInf[name] (SP消耗: $TactInf[spc])";
			$Cont_TactSpc .= sprintf($Cont_TactSpc_Format,$Tactics,$TactInf['spc']);
		}
	}
}
echo "</select>";
echo $Cont_TactSpc;
echo "<input type=submit $BStyleB style=\"$BStyleA\" name=battle_submit value='追擊目標(".$Btl_Intv.")' OnClick=\"this.style.visibility='hidden';return checkAtk();\" disabled><br>";
echo "所需EN: <span id=need_en></span> 　　  所需SP: <span id=need_sp>$baseSpCost</span>";
echo "</form></td>";
echo "<script language=\"JavaScript\">";
echo "var countdown=".$Btl_Intv.";";
echo "function changeEnc(){";
echo "document.battle_continual.enc.value = parseInt(eval(\"parent.document.getElementById('EqmEnc_A').innerHTML;\"))+parseInt(eval(\"parent.document.getElementById('EqmEnc_D').innerHTML;\"))+parseInt(eval(\"parent.document.getElementById('EqmEnc_E').innerHTML;\"));";
echo "document.getElementById('need_en').innerHTML = document.battle_continual.enc.value;";
echo "}function changeSpc(){";
echo "var TactChose;";
echo "var tspc;";
echo "TactChose = 'Tact_'+document.battle_continual.Pl_GTctcs.value;";
echo "tspc = parseInt(eval('document.battle_continual.'+TactChose+'.value;'));";
if($bctlHasExam)
echo "if(document.battle_continual.EXAMStat.checked == true) tspc += 20;";
if($bctlHasSEED && $bctlSEEDTypeCh)
echo "if(document.battle_continual.SEEDStat.checked == true) tspc += 20;";
echo "document.getElementById('need_sp').innerHTML = document.battle_continual.spc.value = tspc;";
echo "}function refreshReq(){";
echo "if(countdown > 0) {document.battle_continual.battle_submit.value='追擊目標('+countdown+')';countdown--;}";
echo "else if(countdown == 0) {document.battle_continual.battle_submit.value='追擊目標';document.battle_continual.battle_submit.disabled=false;}";
echo "changeEnc();changeSpc();setTimeout(\"refreshReq()\",1000);";
echo "}function checkAtk(){";
echo "if(parseInt(document.battle_continual.enc.value) > parseInt(parent.document.getElementById('current_en').innerHTML)) {alert('EN還未足夠！');document.battle_continual.battle_submit.style.visibility='visible';return false;}";
echo "if(parseInt(document.battle_continual.spc.value) > parseInt(parent.document.getElementById('current_sp').innerHTML)) {alert('SP還未足夠！');document.battle_continual.battle_submit.style.visibility='visible';return false;}";
echo "return true;";
echo "}refreshReq();</script>";
?>