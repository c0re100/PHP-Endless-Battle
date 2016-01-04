<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
if ($mode=='addstat' && $actionb){
	switch($actionb){
	case 'at': if ($Game['attacking'] >= 100){echo "能力過高！";exit;}$NextStatPt_At=$Game['attacking']+1;CalcStatReq('AtAdd',"$NextStatPt_At");if ($Gen['growth']-$AtAdd_Stat_Req < 0){echo "點數不足！";exit;}$Gen['growth']-=$AtAdd_Stat_Req;$Game['attacking']=$NextStatPt_At;$ShowCompl="攻擊技術變成 $Game[attacking] 了。";break;
	case 'de': if ($Game['defending'] >= 100){echo "能力過高！";exit;}$NextStatPt_De=$Game['defending']+1;CalcStatReq('DeAdd',"$NextStatPt_De");if ($Gen['growth']-$DeAdd_Stat_Req < 0){echo "點數不足！";exit;}$Gen['growth']-=$DeAdd_Stat_Req;$Game['defending']=$NextStatPt_De;$ShowCompl="防禦能力變成 $Game[defending] 了。";break;
	case 're': if ($Game['reacting'] >= 100){echo "能力過高！";exit;}$NextStatPt_Re=$Game['reacting']+1; CalcStatReq('ReAdd',"$NextStatPt_Re");if ($Gen['growth']-$ReAdd_Stat_Req < 0){echo "點數不足！";exit;}$Gen['growth']-=$ReAdd_Stat_Req;$Game['reacting'] =$NextStatPt_Re;$ShowCompl="反應變成 $Game[reacting] 了。";break;
	case 'ta': if ($Game['targeting'] >= 100){echo "能力過高！";exit;}$NextStatPt_Ta=$Game['targeting']+1;CalcStatReq('TaAdd',"$NextStatPt_Ta");if ($Gen['growth']-$TaAdd_Stat_Req < 0){echo "點數不足！";exit;}$Gen['growth']-=$TaAdd_Stat_Req;$Game['targeting']=$NextStatPt_Ta;$ShowCompl="命中能力變成 $Game[targeting] 了。";break;
	default : echo "未定義操作！";
	}
	$sqlgen = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `growth` = '$Gen[growth]' WHERE `username` = '$Gen[username]' LIMIT 1;");
	mysql_query($sqlgen) or die ('無法取得基本資訊, 原因1:' . mysql_error() . '<br>' . postFooter());
	$sqlgame = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET ");
	switch($actionb){
	case 'at': $sqlgame .=("`attacking` = '$Game[attacking]' ");break;
	case 'de': $sqlgame .=("`defending` = '$Game[defending]' ");break;
	case 're': $sqlgame .=("`reacting` = '$Game[reacting]' ");break;
	case 'ta': $sqlgame .=("`targeting` = '$Game[targeting]' ");break;
	default : echo "未定義操作！";
	}
	$sqlgame .=("WHERE `username` = '$Game[username]' LIMIT 1;");
	mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因2:' . mysql_error() . '<br>' . postFooter());
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
	echo "<p align=center style=\"font-size: 16pt\">完成了！<br>現在你的$ShowCompl<input type=submit value=\"返回\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}
if ($mode == 'modms'){
	echo "機體改造<hr>";
	if(!$Gen['msuit']){echo "你沒有機體！不能進行改造工程！";exit;}

	echo "<br><table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"300\">";
	echo "<form action=statsmod.php?action=prcmodms method=post name=modmsform>";
	echo "<input type=hidden value='' name=actionb>";
	echo "<input type=hidden value='validcode2' name=slot_sw>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	GetMsDetails("$Gen[msuit]",'Pl_Ms');

	if ($Game['eqwep'] && $Game['eqwep'] != "0<!>0"){
		unset($Eq_Id,$Eq_Prep,$Eq_Query,$Eq,$a);
		$Eq_Id = explode('<!>',$Game['eqwep']);
		$Eq_Prep = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $Eq_Id[0] ."'");
		$Eq_Query = mysql_query($Eq_Prep);
		$Eq = mysql_fetch_array($Eq_Query);
		if (ereg('(ExtHP)+',$Eq['spec'])){$a = ereg_replace('.*ExtHP<','',$Eq['spec']);$Pl_Ms['hpfix'] += intval($a);}
		if (ereg('(ExtEN)+',$Eq['spec'])){$a = ereg_replace('.*ExtEN<','',$Eq['spec']);$Pl_Ms['enfix'] += intval($a);}
	}
	if ($Game['p_equip'] && $Game['p_equip'] != "0<!>0"){
		unset($P_Eq_Id,$P_Eq_Prep,$P_Eq_Query,$P_Eq,$a);
		$P_Eq_Id = explode('<!>',$Game['p_equip']);
		$P_Eq_Prep = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $P_Eq_Id[0] ."'");
		$P_Eq_Query = mysql_query($P_Eq_Prep);
		$P_Eq = mysql_fetch_array($P_Eq_Query);
		if (ereg('(ExtHP)+',$P_Eq['spec'])){$a = ereg_replace('.*ExtHP<','',$P_Eq['spec']);$Pl_Ms['hpfix'] += intval($a);}
		if (ereg('(ExtEN)+',$P_Eq['spec'])){$a = ereg_replace('.*ExtEN<','',$P_Eq['spec']);$Pl_Ms['enfix'] += intval($a);}
	}

	if($Game['hpmax']-$Pl_Ms['hpfix'] >= 1000){
	$HP_Mod_Base_Price = ($Game['hpmax']-$Pl_Ms['hpfix'])*30+$Mod_HP_Cost;}
	elseif($Game['hpmax']-$Pl_Ms['hpfix'] >= 10000){$HP_Mod_Base_Price = ($Game['hpmax']-$Pl_Ms['hpfix'])*50+$Mod_HP_UCost;}
	else $HP_Mod_Base_Price = $Mod_HP_Cost;$modhp_dis='';
	if ($HP_Mod_Base_Price > $Gen['cash']){$modhp_dis='disabled';}
	
	if($Game['enmax']-$Pl_Ms['enfix'] >= 100){
	$EN_Mod_Base_Price = ($Game['enmax']-$Pl_Ms['enfix'])*300+$Mod_EN_Cost;}
	elseif($Game['enmax']-$Pl_Ms['enfix'] >= 1000){$EN_Mod_Base_Price = ($Game['enmax']-$Pl_Ms['enfix'])*500+$Mod_EN_UCost;}
	else $EN_Mod_Base_Price = $Mod_EN_Cost;$moden_dis='';
	if ($EN_Mod_Base_Price > $Gen['cash']){$moden_dis='disabled';}
	
	echo "<script langauge=\"Javascript\">";
	echo "function calchp(){";
	echo "var pricemt = document.modmsform.mod_hp_muiltiple.value;";
	echo "var price = pricemt * '$HP_Mod_Base_Price';";
	echo "hpmodprice.innerText = price;";
	echo "hpmodprice.style.color='blue';";
	echo "if (price > $Gen[cash]){hpmodprice.style.color='red';document.modmsform.hp_mod_submit.disabled=true;}";
	echo "else{document.modmsform.hp_mod_submit.disabled=false;}";
	echo "if (price == $Gen[cash]){hpmodprice.style.color='yellow';}";
	echo "}function calcen(){";
	echo "var pricemt = document.modmsform.mod_en_muiltiple.value;";
	echo "var price = pricemt * '$EN_Mod_Base_Price';";
	echo "enmodprice.innerText = price;";
	echo "enmodprice.style.color='blue';";
	echo "if (price > $Gen[cash]){enmodprice.style.color='red';document.modmsform.en_mod_submit.disabled=true;}";
	echo "else{document.modmsform.en_mod_submit.disabled=false;}";
	echo "if (price == $Gen[cash]){enmodprice.style.color='yellow';}}";
	echo "function returnCheckHP(){var resulthpadd=(document.modmsform.mod_hp_muiltiple.value)*100;";
	echo "if (hpmodprice.innerText > $Gen[cash]){alert('金錢不足！');return false;}";
	echo "if (document.modmsform.mod_hp_muiltiple.value > 10){alert('金錢不足！');return false;}";
	echo "if (confirm('用'+hpmodprice.innerText+'元改造'+resulthpadd+'點HP\\n碓定嗎？') == true){document.modmsform.actionb.value='hpmodding';return true;}else{return false;}";
	echo "}function returnCheckEN(){var resultenadd=(document.modmsform.mod_en_muiltiple.value)*10;";
	echo "if (enmodprice.innerText > $Gen[cash]){alert('金錢不足！');return false;}";
	echo "if (document.modmsform.mod_en_muiltiple.value > 10){alert('金錢不足！');return false;}";
	echo "if (confirm('用'+enmodprice.innerText+'元改造'+resultenadd+'點EN\\n碓定嗎？') == true){document.modmsform.actionb.value='enmodding';return true;}else{return false;}";
	echo "}</script>";	
	echo "<tr align=center><td><b>機體改造: </b></td></tr>";
	if($Game['hpmax']-$Pl_Ms['hpfix'] < $Max_HP){
	echo "<tr align=left>";
	echo "<td width=\"300\"><b>附加裝甲:</b><br>每付加一次增加100點HP<br>";
	echo "所需金錢: $<span id=hpmodprice>$HP_Mod_Base_Price</span><br>";
	echo "改造次數: <select size=1 name=\"mod_hp_muiltiple\" onChange=\"calchp()\">";
	echo "<option value='1'>1<option value='2'>2<option value='3'>3<option value='4'>4<option value='5'>5<option value='6'>6<option value='7'>7<option value='8'>8<option value='9'>9<option value='10'>10";
	echo "</select>次";
	echo "<input type=submit name=hp_mod_submit $modhp_dis value='確認改造' onClick=\"return returnCheckHP()\">";
	echo "</td>";
	echo "</tr>";}
	else echo "<tr align=left><td width=\"300\">你的機體不能再進行附加裝甲工程了！<input type=hidden name=\"mod_hp_muiltiple\" value=1></td></tr>";
	if($Game['enmax']-$Pl_Ms['enfix'] < $Max_EN){
	echo "<tr align=left>";
	echo "<td width=\"300\"><b>附加能源CAP:</b><br>每付加一次增加10點EN<br>";
	echo "所需金錢: $<span id=enmodprice>$EN_Mod_Base_Price</span><br>";
	echo "改造次數: <select size=1 name=\"mod_en_muiltiple\" onChange=\"calcen()\">";
	echo "<option value='1'>1<option value='2'>2<option value='3'>3<option value='4'>4<option value='5'>5<option value='6'>6<option value='7'>7<option value='8'>8<option value='9'>9<option value='10'>10";
	echo "</select>次";
	echo "<input type=submit name=en_mod_submit $modhp_dis value='確認改造' onClick=\"return returnCheckEN()\">";
	echo "</td>";
	echo "</tr>";}
	else echo "<tr align=left><td width=\"300\">你的機體不能再進行能源CAP工程了！<input type=hidden name=\"mod_en_muiltiple\" value=1></td></tr>";
	
	//MS Customization & Permanant Equipment
	echo "<tr align=left>";
	echo "<td width=\"300\"><b>專用化改造:</b><br>專用化改造工程分為兩項:<br>";
	echo "1: 基本改造工程<br>　　- 透過一些技術, 改良機體, 提升的能力<br>";
	echo "2: 機體裝備合成工程<br>　　- 把輔助裝備, 永久合成在機體上<br>　　- 可使機體可以多持一種輔助裝備<br>";
	echo "兩項工程無直接關係, 可以同時採用, <Br>但每部機體每項工程<b>只能進行一次</b><br>";
	echo "<input type=submit name=ms_custom_submit value='基本改造工程' onClick=\"modmsform.action='ms_custom.php?action=ms_custom';modmsform.actionb.value='GUI';\">";
	echo "<input type=submit name=ms_pequip_submit value='機體裝備合成工程' onClick=\"modmsform.action='ms_custom.php?action=ms_pequip';modmsform.actionb.value='GUI';\">";
	echo "</td>";
	echo "</tr>";
	
	echo "</form></table>";
postFooter();exit;
}
elseif ($mode == 'prcmodms' && $actionb && $mod_hp_muiltiple && $mod_en_muiltiple){
if ($mod_hp_muiltiple > 10 || $mod_en_muiltiple > 10){echo "一之過最多只能改十次!!<br>";PostFooter();exit;}
if ($mod_hp_muiltiple <= 0 || $mod_en_muiltiple <= 0){echo "改造次數出了問題!!<br>";PostFooter();exit;}
GetMsDetails("$Gen[msuit]",'Pl_Ms');

if ($Game['eqwep'] && $Game['eqwep'] != "0<!>0"){
	unset($Eq_Id,$Eq_Prep,$Eq_Query,$Eq,$a);
	$Eq_Id = explode('<!>',$Game['eqwep']);
	$Eq_Prep = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $Eq_Id[0] ."'");
	$Eq_Query = mysql_query($Eq_Prep);
	$Eq = mysql_fetch_array($Eq_Query);
	if (ereg('(ExtHP)+',$Eq['spec'])){$a = ereg_replace('.*ExtHP<','',$Eq['spec']);$Pl_Ms['hpfix'] += intval($a);}
	if (ereg('(ExtEN)+',$Eq['spec'])){$a = ereg_replace('.*ExtEN<','',$Eq['spec']);$Pl_Ms['enfix'] += intval($a);}
}

if ($Game['p_equip'] && $Game['p_equip'] != "0<!>0"){
	unset($P_Eq_Id,$P_Eq_Prep,$P_Eq_Query,$P_Eq,$a);
	$P_Eq_Id = explode('<!>',$Game['p_equip']);
	$P_Eq_Prep = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $P_Eq_Id[0] ."'");
	$P_Eq_Query = mysql_query($P_Eq_Prep);
	$P_Eq = mysql_fetch_array($P_Eq_Query);
	if (ereg('(ExtHP)+',$P_Eq['spec'])){$a = ereg_replace('.*ExtHP<','',$P_Eq['spec']);$Pl_Ms['hpfix'] += intval($a);}
	if (ereg('(ExtEN)+',$P_Eq['spec'])){$a = ereg_replace('.*ExtEN<','',$P_Eq['spec']);$Pl_Ms['enfix'] += intval($a);}
}

if ($actionb == 'hpmodding'){
if (($Game['hpmax']-$Pl_Ms['hpfix']) > $Max_HP){
echo "<center>HP改造達到上限了。<br></center>";PostFooter();exit;
}
if($Game['hpmax']-$Pl_Ms['hpfix'] >= 1000){$HP_Mod_Base_Price = ($Game['hpmax']-$Pl_Ms['hpfix'])*30+$Mod_HP_Cost;}
elseif($Game['hpmax']-$Pl_Ms['hpfix'] >= 10000){$HP_Mod_Base_Price = ($Game['hpmax']-$Pl_Ms['hpfix'])*50+$Mod_HP_UCost;}
else $HP_Mod_Base_Price = $Mod_HP_Cost;
if (($Gen['cash'] - ($mod_hp_muiltiple*$HP_Mod_Base_Price)) < 0){echo "金錢不足!!<br>";PostFooter();exit;}
if ((($Game['hpmax']-$Pl_Ms['hpfix'])+($mod_hp_muiltiple*100)) > $Max_HP){$mod_hp_muiltiple=floor(($Max_HP-($Game['hpmax']-$Pl_Ms['hpfix']))/100);}
$Gen['cash'] -= ($mod_hp_muiltiple*$HP_Mod_Base_Price);
$Game['hpmax'] += ($mod_hp_muiltiple*100);
}
if ($actionb == 'enmodding'){
if (($Game['enmax']-$Pl_Ms['enfix']) > $Max_EN){
echo "<center>EN改造達到上限了。<br></center>";PostFooter();exit;
}

if($Game['enmax']-$Pl_Ms['enfix'] >= 100){$EN_Mod_Base_Price = ($Game['enmax']-$Pl_Ms['enfix'])*300+$Mod_EN_Cost;}
elseif($Game['enmax']-$Pl_Ms['enfix'] >= 1000){$EN_Mod_Base_Price = ($Game['enmax']-$Pl_Ms['enfix'])*500+$Mod_EN_UCost;}
else $EN_Mod_Base_Price = $Mod_EN_Cost;
if (($Gen['cash'] - ($mod_en_muiltiple*$EN_Mod_Base_Price)) < 0){echo "金錢不足!!<br>";PostFooter();exit;}
if ((($Game['enmax']-$Pl_Ms['enfix'])+($mod_en_muiltiple*10)) >= $Max_EN){$mod_en_muiltiple=floor(($Max_EN-($Game['enmax']-$Pl_Ms['enfix']))/10);}
$Gen['cash']-=($mod_en_muiltiple*$EN_Mod_Base_Price);
$Game['enmax'] += ($mod_en_muiltiple*10);
}
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hpmax` = '".($Game['hpmax'])."', `enmax` = '".($Game['enmax'])."' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql) or die(mysql_error());
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '".($Gen['cash'])."' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql);
echo "<form action=statsmod.php?action=modms method=post name=frmmodms target=Beta>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
echo "<p align=center style=\"font-size: 16pt\">改造完成了！<br><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"><input type=submit value=\"繼續改造\" onClick=\"frmmodms.submit()\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
	postFooter();
}//End MS
elseif ($mode == 'repairms' && $actionb == 'sel'){

$Otp_Area_Sql = ("SELECT `name`,`color`,`opttime`,`optstart` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `optmissioni` = 'Atk=($Gen[coordinates])' AND `opttime` > '$CFU_Time' ORDER BY `optstart` ASC LIMIT 1");
$Otp_Area_Q = mysql_query($Otp_Area_Sql) or die(mysql_error());
$Otp_A_ITar = mysql_fetch_array($Otp_Area_Q);

if ($Otp_A_ITar){
if ($Otp_A_ITar['optstart'] > $CFU_Time){
$TimeTSSec = $Otp_A_ITar['optstart'] - $CFU_Time;
$TimetS['hours'] = floor($TimeTSSec/3600);
$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒開始戰爭。";
}
else{
$TimeTSSec = $Otp_A_ITar['opttime'] - $CFU_Time;
$TimetS['hours'] = floor($TimeTSSec/3600);
$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒戰爭宣告終了。";}
}

if ($Otp_A_ITar && $Otp_A_ITar['optstart'] < $CFU_Time){echo "<center>此區域處於戰爭狀態，修理公廠關閉以躲避戰爭！<br>$Otp_TellTime";postFooter();exit;}
	$AreaORG_Prepare = ("SELECT `occupied` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$Gen[coordinates]'");
	$AreaORG_Query = mysql_query($AreaORG_Prepare) or die(mysql_error());
	$AreaORG = mysql_fetch_array($AreaORG_Query);
	$showOccupied = '';
	if ($Game['organization'] == $AreaORG['occupied']){
		$RepairHPCost = ceil($RepairHPCost * 0.5);
		$RepairENCost = ceil($RepairENCost * 0.5);
		$showOccupied = '本地居民亦可享有50%折扣優惠。<br>';
	}
	
	echo "修理工場<hr>";
	if ($Otp_TellTime){echo "$Otp_TellTime<hr>";}
	if(!$Gen['msuit']){echo "<center>你沒有機體！不能進行修理！";exit;}
	echo "<br><table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"400\">";
	echo "<form action=statsmod.php?action=repairms method=post name=repairmsform>";
	echo "<input type=hidden value='reppro' name=actionb>";
	echo "<input type=hidden value='reppro' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<tr align=center><td><b>修理機體</b></td></tr>";
	GetMSDetails($Gen['msuit'],'NowMS');
	echo "<tr><td>你的機體:<br><p align=center><img src='".$Unit_Image_Dir."/$NowMS[image]'><br>$NowMS[msname]</p>";
	echo "本工場有國戰時不會開啟，".$showOccupied."回復價錢如下:<br>回復1點HP需要 $RepairHPCost 元。<br>回復1點EN需要 $RepairHPCost 元。";
	echo "</td></tr>";
	echo "<script langauge=\"Javascript\">function CheckRepHP(){if (hprepcost.innerText > $Gen[cash]){alert('金錢不足！');return false;}if (confirm('回復HP，確定修理嗎？') == true){repairmsform.actionc.value='hprec';return true}else {return false}}";
	echo "function ChangePriceHP(typerepair){if (typerepair == 'pc'){var rephpamt = ($Game[hpmax] - $Game[hp]) * document.repairmsform.hp_rep_pc_amount.value ;hppcrep.innerText = Math.round(rephpamt);var rehpprc = Math.round($RepairHPCost * rephpamt);";
	echo "hprepcost.innerText = rehpprc;}if (typerepair == 'pt'){var rephpamt = document.repairmsform.hp_rep_amount.value;if (rephpamt > ($Game[hpmax] - $Game[hp])){rephpamt = ($Game[hpmax] - $Game[hp]);}var rehpprc = Math.round($RepairHPCost * rephpamt);";
	echo "hprepcost.innerText = rehpprc;}}</script>";
	if ($Game['hp'] < $Game['hpmax']){
	echo "<tr><td><b>回復HP:</b><br>HP: $Game[hp] / $Game[hpmax]<br>以百分比回復餘下的 <input type=radio name='hp_rep_type' value='pc' OnClick=\"hp_rep_pc_amount.disabled=false;hp_rep_amount.disabled=true;hprepcost.innerText='0';hp_rep_pc_amount.value='0';\">: 回復 <select name='hp_rep_pc_amount' disabled onChange=\"ChangePriceHP('pc')\"><option value=0 selected>--選擇--<option value=0.1>10%<option value=0.2>20%<option value=0.3>30%<option value=0.4>40%<option value=0.5>50%<option value=0.6>60%<option value=0.7>70%<option value=0.8>80%<option value=0.9>90%<option value=1.0>100%</select>(<span id=hppcrep>0</span>點)";
	echo "<br>手動輸入回復量 <input type=radio value='pt' name='hp_rep_type' OnClick=\"hp_rep_pc_amount.disabled=true;hp_rep_amount.disabled=false;hprepcost.innerText='0';hppcrep.innerText='0';\">: 回復 <input type=text size=4 maxlength=5 name='hp_rep_amount' value=0 disabled onChange=\"ChangePriceHP('pt')\">點";
	echo "<br>所需金錢: <span id=hprepcost>0</span> 元。<br><input type=submit name=hp_rep_submit value='回復HP' onClick=\"return CheckRepHP();\">";
	echo "</td></tr>";
	}else{echo "<tr><td>你無需回復HP</td></tr>";}
	echo "<script langauge=\"Javascript\">function CheckRepEN(){if (enrepcost.innerText > $Gen[cash]){alert('金錢不足！');return false;}if (confirm('回復EN，確定修理嗎？') == true){repairmsform.actionc.value='enrec';return true}else {return false}}";
	echo "function ChangePriceEN(typerepair){if (typerepair == 'pc'){var repenamt = ($Game[enmax] - $Game[en]) * document.repairmsform.en_rep_pc_amount.value ;enpcrep.innerText = Math.round(repenamt);var reenprc = Math.round($RepairENCost * repenamt);";
	echo "enrepcost.innerText = reenprc;}if (typerepair == 'pt'){var repenamt = document.repairmsform.en_rep_amount.value;if (repenamt > ($Game[enmax] - $Game[en])){repenamt = ($Game[enmax] - $Game[en]);}var reenprc = Math.round($RepairENCost * repenamt);";
	echo "enrepcost.innerText = reenprc;}}</script>";	
	if ($Game['en'] < $Game['enmax']){
	echo "<tr><td><b>回復EN:</b><br>EN: $Game[en] / $Game[enmax]<br>以百分比回復餘下的 <input type=radio name='en_rep_type' value='pc' OnClick=\"en_rep_pc_amount.disabled=false;en_rep_amount.disabled=true;enrepcost.innerText='0';en_rep_pc_amount.value='0';\">: 回復 <select name='en_rep_pc_amount' disabled onChange=\"ChangePriceEN('pc')\"><option value=0 selected>--選擇--<option value=0.1>10%<option value=0.2>20%<option value=0.3>30%<option value=0.4>40%<option value=0.5>50%<option value=0.6>60%<option value=0.7>70%<option value=0.8>80%<option value=0.9>90%<option value=1.0>100%</select>(<span id=enpcrep>0</span>點)";
	echo "<br>手動輸入回復量 <input type=radio value='pt' name='en_rep_type' OnClick=\"en_rep_pc_amount.disabled=true;en_rep_amount.disabled=false;enrepcost.innerText='0';enpcrep.innerText='0';\">: 回復 <input type=text size=4 maxlength=5 name='en_rep_amount' value=0 disabled onChange=\"ChangePriceEN('pt')\">點";
	echo "<br>所需金錢: <span id=enrepcost>0</span> 元。<br><input type=submit name=en_rep_submit value='回復EN' onClick=\"return CheckRepEN();\">";
	echo "</td></tr>";
	}else{echo "<tr><td>你無需回復EN</td></tr>";}
	echo "</form></table>";
postFooter();exit;
}//End Repair Form
elseif ($mode == 'repairms' && $actionb == 'reppro'){

$Otp_Area_Sql = ("SELECT `name`,`color`,`opttime`,`optstart` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `optmissioni` = 'Atk=($Gen[coordinates])' AND `opttime` > '$CFU_Time' ORDER BY `optstart` ASC LIMIT 1");
$Otp_Area_Q = mysql_query($Otp_Area_Sql) or die(mysql_error());
$Otp_A_ITar = mysql_fetch_array($Otp_Area_Q);

$AreaORG_Prepare = ("SELECT `occupied` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$Gen[coordinates]'");
	$AreaORG_Q = mysql_query($AreaORG_Prepare) or die(mysql_error());
	$AreaORG = mysql_fetch_array($AreaORG_Q);
	if ($Game['organization'] == $AreaORG['occupied']){
		$RepairHPCost = ceil($RepairHPCost * 0.5);
		$RepairENCost = ceil($RepairENCost * 0.5);echo "<hr>";
	}

if ($Otp_A_ITar){
if ($Otp_A_ITar['optstart'] > $CFU_Time){
$TimeTSSec = $Otp_A_ITar['optstart'] - $CFU_Time;
$TimetS['hours'] = floor($TimeTSSec/3600);
$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒開始戰爭。";
}
else{
$TimeTSSec = $Otp_A_ITar['opttime'] - $CFU_Time;
$TimetS['hours'] = floor($TimeTSSec/3600);
$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒戰爭宣告終了。";}
}

if ($Otp_A_ITar && $Otp_A_ITar['optstart'] < $CFU_Time){echo "<center>此區域處於戰爭狀態，修理公廠關閉以躲避戰爭！<br>$Otp_TellTime";postFooter();exit;}

	$RepairAmt=0;$PriceRepair=0;
	if ($actionc == 'hprec' && ($Game['hpmax'] != $Game['hp'])){
		if ($hp_rep_type == 'pc'){if ($hp_rep_pc_amount > 1.0 || $hp_rep_pc_amount <= 0 ){echo "回復量出錯";postFooter();exit;}$RepairAmt = floor(($Game['hpmax'] - $Game['hp']) * $hp_rep_pc_amount);if ($RepairAmt > ($Game['hpmax'] - $Game['hp']))$RepairAmt = ($Game['hpmax'] - $Game['hp']);
		$PriceRepair = floor($RepairAmt * $RepairHPCost);
		}elseif ($hp_rep_type == 'pt'){
		if ($hp_rep_amount > $Game['hpmax'] || $hp_rep_amount <= 0 ){echo "回復量出錯";postFooter();exit;}
		$RepairAmt = $hp_rep_amount; if ($RepairAmt > ($Game['hpmax'] - $Game['hp']))$RepairAmt = ($Game['hpmax'] - $Game['hp']);
		$PriceRepair = floor($RepairAmt * $RepairHPCost);
		}else {echo "不明的指令！";postFooter();exit;}
		if ($PriceRepair < 0)$PriceRepair = 0;
		if ($Gen['cash'] - $PriceRepair < 0){echo "金錢不足！";postFooter();exit;}
		$Gen['cash'] -= $PriceRepair;
		$Game['hp'] += $RepairAmt;
		if ($Game['hp'] > $Game['hpmax'])$Game['hp'] = $Game['hpmax'];
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hp` = '$Game[hp]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$RepMsg = "以 $PriceRepair 元回復了 $RepairAmt 點HP。";
		}
	elseif ($actionc == 'hprec' && ($Game['hpmax'] <= $Game['hp'])){echo "HP已經滿了！";postFooter();exit;}
	elseif ($actionc == 'enrec' && ($Game['enmax'] != $Game['en'])){
		if ($en_rep_type == 'pc'){if ($en_rep_pc_amount > 1.0 || $en_rep_pc_amount <= 0 ){echo "回復量出錯";postFooter();exit;}$RepairAmt = floor(($Game['enmax'] - $Game['en']) * $en_rep_pc_amount);if ($RepairAmt > ($Game['enmax'] - $Game['en']))$RepairAmt = ($Game['enmax'] - $Game['en']);
		$PriceRepair = floor($RepairAmt * $RepairENCost);
		}elseif ($en_rep_type == 'pt'){
		if ($en_rep_amount > $Game['enmax'] || $en_rep_amount <= 0 ){echo "回復量出錯";postFooter();exit;}
		$RepairAmt = $en_rep_amount; if ($RepairAmt > ($Game['enmax'] - $Game['en']))$RepairAmt = ($Game['enmax'] - $Game['en']);
		$PriceRepair = floor($RepairAmt * $RepairENCost);
		}else {echo "不明的指令！";postFooter();exit;}
		if ($PriceRepair < 0)$PriceRepair = 0;
		if ($Gen['cash'] - $PriceRepair < 0){echo "金錢不足！";postFooter();exit;}
		$Gen['cash'] -= $PriceRepair;
		$Game['en'] += $RepairAmt;
		if ($Game['en'] > $Game['enmax'])$Game['en'] = $Game['enmax'];
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `en` = '$Game[en]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$RepMsg = "以 $PriceRepair 元回復了 $RepairAmt 點EN。";
		}
	elseif ($actionc == 'enrec' && ($Game['enmax'] <= $Game['en'])){echo "EN已經滿了！";postFooter();exit;}
	else {echo "HP/EN已經滿了！";postFooter();exit;}

echo "<form action=statsmod.php?action=repairms method=post name=frmrp target=Beta>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='sel' name=actionb>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
echo "<p align=center style=\"font-size: 16pt\">修理完成了！<br>$RepMsg<br><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"><input type=submit value=\"繼續修理\" onClick=\"frmrp.submit()\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";

postFooter();exit;	

}//End Repair Mode

//Start Character Type Modding

elseif ($mode == 'modtypech' && $actionb == 'A'){
	echo "人種改造<hr>";
	if(!ereg('nat',$Gen['typech'])){echo "你不是一般人！不能進行改造！";exit;}
	
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"300\">";
	
	echo "<form action=statsmod.php?action=modtypech method=post name=modchform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
	echo "<script langauge=\"Javascript\">function cfmModCh(){";
	echo "if ($Gen[cash] < $ModChType_Cost) {alert('現金不足!!');return false;}";
	echo "else if (confirm('真的要進行改造嗎？') == true) {return true;} else {return false;}";
	echo "}</script>";
	
	echo "<tr><td align=center><b>人種改造</b></td></tr>";
	echo "<tr><td>";
	echo "<b>簡介:</b><br>人種改造是一個為類型(Type)為 一般(Natural) 的人，<br>改造身體，使自己成為:<br><br>1. Enhanced (強化人間)<br>或<br>2. Extended (延伸人)<br>";
	echo "<br>改造有什麼好處？<br>看你會不會認為Enhanced或Extended比一般人強吧！<Br>但請緊記，一經改造，無法還原，亦無法再改造！";
	echo "</td></tr>";
	
	echo "<tr><td>";
	echo "<b>人種改造:</b><br>";
	echo "改造為:<br>";
	echo "<input type=radio name=dtype value=1 checked> Enhanced (強化人間)<br><input type=radio name=dtype value=2> Extended (延伸人)<br>";
	echo "<b>費用:</b> ".number_format($ModChType_Cost)." 元<br>";
	echo "</td></tr>";
	echo "<tr><td align=center>";
	echo "<input type=submit value=改造確定 onClick=\"return cfmModCh();\">";
	echo "</td></tr>";

	echo "</form></table>";
postFooter();exit;	
}
elseif ($mode == 'modtypech' && $actionb == 'B'){
	echo "人種改造<hr>";
	$Dest_Type = $ModChMsg = (string) '';
	switch($dtype){
		case 1: $Dest_Type = 'enh'; $ModChMsg = '強化人間';break;
		case 2: $Dest_Type = 'ext'; $ModChMsg = 'Extended';break;
		default: echo "目標人種出錯!!";exit;
	}
	if(!ereg('nat',$Gen['typech'])){echo "你不是一般人！不能進行改造！";exit;}
	else {
		if($Gen['cash'] < $ModChType_Cost){echo "現金不足!!";exit;}
		else {
			$Gen['cash'] -= $ModChType_Cost;
			$Gen['typech'] = str_replace('nat',$Dest_Type,$Gen['typech']);
			$SQL = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `typech` = '$Gen[typech]', `hypermode` = 0 ");
			$SQL .= ("WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($SQL) or die(mysql_error());
		}
		
	}

echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
echo "<p align=center style=\"font-size: 16pt\">改造完成了！<br>你已改造成 $ModChMsg ！<br><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
postFooter();exit;	
}
//End Character Type Modding

elseif ($mode == 'custom'){
$IncThread = "mscust_200702191832";
include('ms_custom.php');
}
?>