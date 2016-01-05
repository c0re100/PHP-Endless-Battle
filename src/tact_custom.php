<?php
if ($IncThread != "tcust_200509241855"){echo "Unauthorized";exit;}
mt_srand ((double) microtime()*1000000);
//Process with Put Weapon @ Custom
if ($actionb=='put' && $actionc){
unset($counter,$sql,$CustomPoint);


$Storage = array();
$sqlStorage = array();

$CustomPoint = 0;

// Raw Materials From Mining
if($actionc == 'rawMaterials'){
	$raw[0] = 0;
	for($i = 1; $i <= 8; $i++){
		$raw[$i] = intval($raw[$i]);
		if($raw[$i] < 0) $raw[$i] = 0;
		$raw[0] += $raw[$i];
		$CustomPoint += round(($i + 2) * $i / 2) * $raw[$i];
	}
	
	$j = 0;
	$SQL_Format = 'UPDATE `'.$GLOBALS['DBPrefix'].'phpeb_mining_storage` SET `quantity` = %d WHERE `m_store_user` = \''.$Game['username'].'\' AND `item` = %d ;';
	if($raw[0] <= 0){echo "請填入原料數量";postFooter();exit;}
	else{
		if(checkMBillsPending($Game['username'])){
			echo "請先支付原料採集費，多謝合作。";postFooter();exit;
		}
		$Storage = getMiningStorage($Game['username']);
		for($i = 1; $i <= 8; $i++){
			if($raw[$i] > 0){
				$Storage[$i] -= $raw[$i];
				if($Storage[$i] < 0){
					echo "<br><p align=center style='font-size: 12pt'>原料不足！</p>";
					postFooter();
					exit;
				}
				$sqlStorage[$j] = sprintf($SQL_Format,$Storage[$i],$i);
				$j++;
			}
		}
	}
}
else{
	$TargetPutWep = explode('<!>',$Game[$actionc]);
	$TargetPutWep[2] = (isset($TargetPutWep[2])) ? $TargetPutWep[2]: 0;
	if ($TactFactory['c_wep'] && $TargetPutWep[0] != $AlloyID){echo "請先回收之前的武器。";postFooter();exit;}
	if (!$Game[$actionc] || !$TargetPutWep[0]){echo "沒有此裝備存在。";postFooter();exit;}
	if ($actionc == 'wepa'){echo "有此裝備存在，可是我們無法把武器從您機體的手中拆下來。";postFooter();exit;}
	if ($actionc != 'wepb' && $actionc != 'wepc'){echo "您想把你自己當作原料嗎？";postFooter();exit;}
	
	if ($TargetPutWep[2]){echo "已進行過專用化改造的裝備無法再次進行改造。";postFooter();exit;}
	if ($TargetPutWep[1] < $Max_Wep_Exp && $TargetPutWep[0] != $AlloyID){echo "武器狀態值不足！";postFooter();exit;}
	
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$actionc` = '0<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);unset($sql);

	if ($TargetPutWep[0] == $AlloyID){$CustomPoint = $AlloyPoints;}
	else {
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` SET `time` = '$CFU_Time', `c_wep` = '$TargetPutWep[0]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
	}
}


if ($CustomPoint > 0){
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` SET `time` = '$CFU_Time', `c_point` = `c_point`+$CustomPoint WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);
	if(count($sqlStorage) > 0){
		foreach($sqlStorage As $sql) mysql_query($sql);
	}
}

echo "<form action=tactfactory.php?action=custom method=post name=freect target=$SecTarget>";
echo "<input type=hidden value='none' name=actionb>";
echo "<input type=hidden value='none' name=actionc>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<p align=center style=\"font-size: 16pt\">置放完成了！<br><input type=submit value=\"重新整體\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"繼續\" onClick=\"freect.submit()\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";	
}
//Start Customing
elseif ($actionb=='start' && $actionc){
if (!$TactFactory['c_wep']){echo "找不到所需改造的武器。";postFooter();exit;}
if (!$UsrWepB[0]){$TargetRec = 'wepb';}
elseif (!$UsrWepC[0]){$TargetRec = 'wepc';}
else{echo "沒空位裝備。";postFooter();exit;}

unset($sql);
$atkc_pt = intval($atkc_pt);if ($atkc_pt < 0) $atkc_pt = 0;
$hitc_pt = intval($hitc_pt);if ($hitc_pt < 0) $hitc_pt = 0;
$rdc_pt = intval($rdc_pt);if ($rdc_pt < 0) $rdc_pt = 0;
$encc_pt = intval($encc_pt);if ($encc_pt < 0) $encc_pt = 0;
$namefix = intval($namefix);
$ttlused_pt = intval($atkc_pt+$hitc_pt+$rdc_pt+$encc_pt);
if ($ttlused_pt > $TactFactory['c_point'] || $ttlused_pt <= 0){echo "改造點數不足或出錯！";postFooter();exit;}

GetWeaponDetails("$TactFactory[c_wep]",'CustWepS');

if (isset($secureCustom)){
	$secureCustom = 1;
	if ($ttlused_pt+($CustWepS['complexity']*10) > $TactFactory['c_point'] || $ttlused_pt <= 0){echo "改造點數不足或出錯！";postFooter();exit;}
}
else $secureCustom = 0;

$CustomedAtk = Floor($CustWepS['atk']*$atkc_pt*0.005);
$CustomedHit = Floor($CustWepS['hit']*$hitc_pt*0.005);
$CustomedRd = Floor($CustWepS['rd']*$rdc_pt*0.005);
$CustomedENCc = $CustWepS['enc']*(1+($atkc_pt)*0.01)*(1+($rdc_pt)*0.01)*(1+($hitc_pt)*0.01);
$CustomedENC = Ceil($CustomedENCc-($CustomedENCc*$encc_pt*0.005));

$fixedname = preg_replace('/([!@#$%^&*()[\]\\{}\'",.\/<>?|]|--)+/','',$fixedname);

if($namefix > 2 || $namefix < 1){echo "Cannot Get Fix Type";postFooter();exit;}

unset($sql);
if(strlen($fixedname) > 32){echo "專用名稱過長！";postFooter();exit;}
$costPt = $ttlused_pt;
if ($secureCustom) $costPt += intval($CustWepS['complexity']*10);
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` SET `time` = '$CFU_Time', `c_wep` = '', `c_point`=`c_point`-$costPt WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql) or die(mysql_error());unset($sql);

$pt_use_max = (100-($CustWepS['complexity']-1)*2)+(50-($CustWepS['complexity']-1)*2)+100+60;
$pc_cust_suc = floor(($pt_use_max-$ttlused_pt)/$pt_use_max*100+50-($CustWepS['complexity']*2));
$pc_res_suc = mt_rand(0,100);
if($pc_res_suc <= $pc_cust_suc){
unset($sql);
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$TargetRec` = '".$TactFactory['c_wep']."<!>0<!>".$namefix."<!>".$fixedname."<!>".$CustomedAtk."<!>".$CustomedHit."<!>".$CustomedRd."<!>".$CustomedENC."' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
$sql = preg_replace("/(--)+/",'',$sql);
mysql_query($sql);
$Message = "成功\改造了！<br>效果值: $pc_res_suc < 成功\率: $pc_cust_suc";
}
else {
	$Message = "改造失敗了。<br>效果值: $pc_res_suc > 成功\率: $pc_cust_suc";
	if ($secureCustom){
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$TargetRec` = '".$TactFactory['c_wep']."<!>0<!>0<!>0<!>0<!>0<!>0<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		$sql = preg_replace("/(--)+/",'',$sql);
		mysql_query($sql);
		unset($sql);
		$Message .= "<br>工程師們成功\修好損壞了的武器";
	}
}

echo "<form action=tactfactory.php?action=main method=post name=freect target=$SecTarget>";
echo "<input type=hidden value='none' name=actionb>";
echo "<input type=hidden value='none' name=actionc>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<p align=center style=\"font-size: 16pt\">$Message<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=submit value=\"繼續\" onClick=\"freect.submit()\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";	
}
//Process Customing Main
elseif ($actionb == 'none' && $actionc=='none'){
	echo "兵器專用化工場<hr>";
	echo "<form action=tactfactory.php?action=custom method=post name=mainform target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

//Start Table -- User's Information
echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12pt; border-collapse: collapse\" bordercolor=\"#111111\" width=\"400\" id=\"AutoNumber1\">";
echo "<tr><td width=400 colspan=2><b>說明</b></td></tr>";
echo "<tr><td width=400 colspan=2>當武器狀態值達 +250% 時，可以進行專用化。<br>專用化能夠讓你改造武器、提升威力和效率。";
echo "<br>條件如下:<br>";
echo "&nbsp;- 武器狀態值達 +250%<br>";
echo "&nbsp;- 武器曾沒有進行專用化<br>";
echo "&nbsp;- 專用化完成後，武器狀態值歸零 (±0%)。<br>";
echo "請注意，任何置放在熔解爐(包括武器專用化改造的熔解爐)的武器，將會失去所有狀態值！<br>還有，過份改造可能會令武器及原料永久破壞！請小心！<br>";
echo "另外，原料無法專用化，被置放的原料會直接轉化為改造點數。<br>您的改造點數: $TactFactory[c_point]";
echo "<hr></td></tr>";
echo "<tr><td width=350><b>備用裝備B:</b><font style=\"font-size: 10pt\"><br>".getWeaponName($UsrWepB[0]);

if($UsrWepB[1] == 0) $DisXpB = '±0%';
else $DisXpB = ($UsrWepB[1] > 0) ? '+'.($UsrWepB[1]/100) : ($UsrWepB[1]/100);
if($UsrWepC[1] == 0) $DisXpC = '±0%';
else $DisXpC = ($UsrWepC[1] > 0) ? '+'.($UsrWepC[1]/100) : ($UsrWepC[1]/100);

if ($UsrWepB[1]) echo "<br>(狀態值: ".$DisXpB."%)";
echo "</font></td><td width=50 align=center>";
if (($UsrWepB[0] && $UsrWepB[1] >= 25000 && !$UsrWepB[2] && !$TactFactory['c_wep']) || $UsrWepB[0] == $AlloyID) echo "<input type=button name='putb' value='置放' onClick=\"actionb.value='put';actionc.value='wepb';mainform.submit()\">";
else echo "&nbsp;";
echo "</td></tr>";
echo "<tr><td width=350><b>備用裝備C:</b><font style=\"font-size: 10pt\"><br>".getWeaponName($UsrWepC[0]);
if ($UsrWepC[1]) echo "<br>(狀態值: ".$DisXpC."%)";
echo "</font></td><td width=50 align=center>";
if (($UsrWepC[0] && $UsrWepC[1] >= 25000 && !$UsrWepC[2] && !$TactFactory['c_wep']) || $UsrWepC[0] == $AlloyID) echo "<input type=button name='putc' value='置放' onClick=\"actionb.value='put';actionc.value='wepc';mainform.submit()\">";
else echo "&nbsp;";
echo "</td></tr>";

		// Raw Materials
		echo "<tr><td align=center colspan=2><b>加入原料</b></td></tr><tr><td align=center>";
		$pFormatStr = '%s: <input type=text maxlength=3 name="raw[%d]" value=0 style="height: 14pt; width: 30px; text-align: center; '.$BStyleA.'" onClick="this.value=\'\'" onChange="this.value=parseInt(this.value)"> &nbsp; &nbsp;';
		for($i = 1; $i <= 8; $i++){
			printf($pFormatStr, $product_id_list[$i], $i);
			if($i == 4) echo '<br>';
			if($i == 1 || $i == 6) echo '　';
		}
		echo "</td><td><input type=button name='putc' value='加入' onClick=\"actionb.value='put';actionc.value='rawMaterials';mainform.submit()\"></td>";
		echo "</tr>";

echo "</table><hr>";
//End Table -- User's Information
echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"700\">";
echo "<tr><td colspan=6 align=center>專用化改造的原料庫</td></tr>";
echo "<tr><td width=150>即將進行專用化工序的武器:</td>";
if (!$TactFactory['c_wep'])
echo "<td colspan=5>沒有";
else {
GetWeaponDetails("$TactFactory[c_wep]",'CustWepS');
echo "<td colspan=4 width=500>$CustWepS[name]</td><td width=50 align=right><input type=button name='reclaimc' value='回收' onClick=\"mainform.action='tactfactory.php?action=main';actionb.value='reclaim';actionc.value='c_wep';mainform.submit()\">";}
echo "</td></tr>";
if ($TactFactory['c_wep']){
echo "<tr><td colspan=6>";
echo "<table align=center border=\"0\" width=\"100%\">";
echo "<tr>";
echo "<td width=50%>";
echo "<b>已使用的改造點數: </b><span style=\"color: DodgerBlue\" id=pt_left>0</span> / <span id=\"c_points\">$TactFactory[c_point]</span>";
echo "</td><td><b>改造成功\率: </b><span id=successpc>100</span>% (武器複雜度: <span id='SysGrade'>$CustWepS[complexity]</span>)";
echo "</td></tr><tr><td>";
$ENCMin = ceil($CustWepS['enc']*0.7);
$AtkMax = floor($CustWepS['atk']+$CustWepS['atk']*(100-($CustWepS['complexity']-1)*2)*0.005);

echo "<b style=\"color: yellow\">攻擊力強化: </b><br><span id='SysAtk'>$CustWepS[atk]</span> => <b style=\"color: DodgerBlue\" id=atkc>$CustWepS[atk]</b> (上限: $AtkMax)<br>使用點數: <select name=\"atkc_pt\" onchange=\"custom('atk');\">";
for($PtUse_Atk=0;$PtUse_Atk <= $TactFactory['c_point'] && $PtUse_Atk <= (100-($CustWepS['complexity']-1)*2);$PtUse_Atk++){
echo "<option value=$PtUse_Atk>$PtUse_Atk";}
echo "</select>點";
echo "</td><td>";
$HitMax = floor($CustWepS['hit']+$CustWepS['hit']*(50-($CustWepS['complexity']-1)*2)*0.005);
echo "<b style=\"color: yellow\">命中力強化: </b><br><span id='SysHit'>$CustWepS[hit]</span> => <b style=\"color: DodgerBlue\" id=hitc>$CustWepS[hit]</b> (上限: $HitMax)<br>使用點數: <select name=\"hitc_pt\" onchange=\"custom('hit');\">";
for($PtUse_Hit=0;$PtUse_Hit <= $TactFactory['c_point'] && $PtUse_Hit <= (50-($CustWepS['complexity']-1)*2);$PtUse_Hit++){
echo "<option value=$PtUse_Hit>$PtUse_Hit";}
echo "</select>點";
echo "</td></tr><tr><td>";
$RdMax = floor($CustWepS['rd']*1.5);
echo "<b style=\"color: yellow\">回數增加: </b><br><span id='SysRds'>$CustWepS[rd]</span> => <b style=\"color: DodgerBlue\" id=rdc>$CustWepS[rd]</b> (上限: $RdMax)<br>使用點數: <select name=\"rdc_pt\" onchange=\"custom('rd');\">";
for($PtUse_Rd=0;$PtUse_Rd <= $TactFactory['c_point'] && $PtUse_Rd <= 100;$PtUse_Rd++){
echo "<option value=$PtUse_Rd>$PtUse_Rd";}
echo "</select>點";
echo "</td><td>";
echo "<b style=\"color: yellow\">能源消耗: </b><br><span id='SysEnc'>$CustWepS[enc]</span> => <b style=\"color: DodgerBlue\" id=encc>$CustWepS[enc]</b> (下限: <span id=enccmin>$ENCMin</span>)<br>使用點數: <select name=\"encc_pt\" onchange=\"custom('enc');\">";
for($PtUse_EN=0;$PtUse_EN <= $TactFactory['c_point'] && $PtUse_EN <= 60;$PtUse_EN++){
echo "<option value=$PtUse_EN>$PtUse_EN";}
echo "</select>點";
echo "</td></tr><tr><td>";
echo "武器名稱更變: <input type=text value=\"$Game[gamename]專用\" name=fixedname maxlength=32 onChange=\"ModName(this.value);\"><br>更變類型: <input type=radio name=namefix value=1 checked onclick=\"switchnfix('pre');\"> 字首附加 <input type=radio name=namefix value=2 onclick=\"switchnfix('suf');\"> 字尾附加";
echo "</td><td>名稱預覽:<br><span id=namepre>$Game[gamename]專用</span>$CustWepS[name]<span id=namesuf></span><sub>&copy;</sub>";
echo "</td></tr>";
echo "<tr>";
echo "<td>保險機制: <input type=checkbox name=secureCustom onClick=\"custom('');\" value=true> (消耗 ".($CustWepS['complexity']*10)." 點改造點數)</td><td>消耗一定的改造點於失敗後挽回損壞的武器。</td>";
echo "</tr><tr><td colspan=2 align=center>";
echo "<input type=submit value='確認改造' onClick='return confirmCustom()'>";
echo "</td></tr></table>";
echo "</td></tr>";


echo "<script language=\"JavaScript\">
var usePointCalc = true;
var oAtkC = document.getElementById('atkc');
var oHitC = document.getElementById('hitc');
var oRdsC = document.getElementById('rdc');
var oEncC = document.getElementById('encc');
var oEncCMin = document.getElementById('enccmin');
var oPtLeft = document.getElementById('pt_left');
var oCPoints = document.getElementById('c_points');
var oSuccessPc = document.getElementById('successpc');
var oSecureCust = document.mainform.secureCustom;

var oSysAtk = document.getElementById('SysAtk');
var oSysGrade = document.getElementById('SysGrade');
var oSysHit = document.getElementById('SysHit');
var oSysRds = document.getElementById('SysRds');
var oSysEnc = document.getElementById('SysEnc');

var oAtkCPt = document.mainform.atkc_pt;
var oHitCPt = document.mainform.hitc_pt;
var oRdsCPt = document.mainform.rdc_pt;
var oEncCPt = document.mainform.encc_pt;

function switchnfix(type){
if(type == 'pre'){
	document.mainform.fixedname.value='$Game[gamename]專用';
	document.getElementById('namepre').innerHTML='$Game[gamename]專用';
	document.getElementById('namesuf').innerHTML='';
}
else if(type == 'suf'){
	document.mainform.fixedname.value='$Game[gamename]Custom';
	document.getElementById('namepre').innerHTML='';
	document.getElementById('namesuf').innerHTML='$Game[gamename]Custom';
}
}
function ModName(val){
val = val.replace(/[&!?=.,<>@#$%\^\*\#\/\\\\[\]\{\}\'\"]+/,'');
if (document.getElementById('namepre').innerHTML!=''){
document.getElementById('namepre').innerHTML=val;
}
else if (document.getElementById('namesuf').innerHTML!=''){
document.getElementById('namesuf').innerHTML=val;
}
mainform.fixedname.value=val;
}
function confirmCustom(){
	if (document.getElementById('pt_left').innerHTML > $TactFactory[c_point]){alert('改造點數不足！\\n無法進行改造。');return false;}
	else {
		if (confirm('即將進行改造，請確保所有資料正確。\\n可以開始改造嗎？')==true){mainform.actionb.value='start';return true;}
		else {return false;}
	}
}
</script>
<script language=\"javascript\" type=\"text/javascript\" src=\"includes/tact_custom.js\"></script>";

}
echo "</table></form><hr><br><br><br><br>";
}

?>