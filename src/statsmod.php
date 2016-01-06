<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
include('includes/repairplayer-f.inc.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
if (!isset($Game_Scrn_Type)) $Game_Scrn_Type = 1;
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');

$War_State = false;

function checkWartime($Coord){
	global $CFU_Time,$Otp_TellTime;
	$Otp_Area_Sql = ("SELECT `t_start`,`t_end` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `mission` = 'Atk<$Coord>' AND `t_end` > '$CFU_Time' ORDER BY `t_start` ASC LIMIT 1");
	$Otp_Area_Q = mysql_query($Otp_Area_Sql) or die(mysql_error());
	$Otp_A_ITar = mysql_fetch_array($Otp_Area_Q);
	if ($Otp_A_ITar){
		if ($Otp_A_ITar['t_start'] >= $CFU_Time){
		$TimeTSSec = $Otp_A_ITar['t_start'] - $CFU_Time;
		$TimetS['hours'] = floor($TimeTSSec/3600);
		$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
		$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
		$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒開始戰爭。";
		}
		else{
		$TimeTSSec = $Otp_A_ITar['t_end'] - $CFU_Time;
		$TimetS['hours'] = floor($TimeTSSec/3600);
		$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
		$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
		$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒戰爭宣告終了1。";
		return true;
		}
	}
	return false;
}

if ($mode=='addstat' && $actionb){
	$stat_added = '';
	switch($actionb){
	case 'at': $stat_added = 'attacking';if ($Game['attacking'] >= 150){echo "能力過高！";exit;}$NextStatPt_At=$Game['attacking']+1;CalcStatReq('AtAdd',"$NextStatPt_At");if ($Gen['growth']-$AtAdd_Stat_Req < 0){echo "點數不足！";exit;}$Gen['growth']-=$AtAdd_Stat_Req;$Game['attacking']=$NextStatPt_At;$ShowCompl="攻擊技術變成 $Game[attacking] 了。";break;
	case 'de': $stat_added = 'defending';if ($Game['defending'] >= 150){echo "能力過高！";exit;}$NextStatPt_De=$Game['defending']+1;CalcStatReq('DeAdd',"$NextStatPt_De");if ($Gen['growth']-$DeAdd_Stat_Req < 0){echo "點數不足！";exit;}$Gen['growth']-=$DeAdd_Stat_Req;$Game['defending']=$NextStatPt_De;$ShowCompl="防禦能力變成 $Game[defending] 了。";break;
	case 're': $stat_added = 'reacting';if ($Game['reacting'] >= 150){echo "能力過高！";exit;}$NextStatPt_Re=$Game['reacting']+1; CalcStatReq('ReAdd',"$NextStatPt_Re");if ($Gen['growth']-$ReAdd_Stat_Req < 0){echo "點數不足！";exit;}$Gen['growth']-=$ReAdd_Stat_Req;$Game['reacting'] =$NextStatPt_Re;$ShowCompl="反應變成 $Game[reacting] 了。";break;
	case 'ta': $stat_added = 'targeting';if ($Game['targeting'] >= 150){echo "能力過高！";exit;}$NextStatPt_Ta=$Game['targeting']+1;CalcStatReq('TaAdd',"$NextStatPt_Ta");if ($Gen['growth']-$TaAdd_Stat_Req < 0){echo "點數不足！";exit;}$Gen['growth']-=$TaAdd_Stat_Req;$Game['targeting']=$NextStatPt_Ta;$ShowCompl="命中能力變成 $Game[targeting] 了。";break;
	case 'sp': $stat_added = 'spmax';if ($Gen['growth'] - $SP_Stat_Req < 0){echo "點數不足！";exit;}$Gen['growth'] -= $SP_Stat_Req;$Game['spmax'] += 10;$ShowCompl="SP增加了 10 點。";break;
	default : echo "未定義操作！";
	}
	$sqlgen = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `growth` = '$Gen[growth]' WHERE `username` = '$Gen[username]' LIMIT 1;");
	mysql_query($sqlgen) or die ('無法取得基本資訊, 原因1:' . mysql_error() . '<br>' . postFooter());
	$sqlgame = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET ");
	$sqlgame .=("`$stat_added` = '$Game[$stat_added]' ");
	$sqlgame .=("WHERE `username` = '$Game[username]' LIMIT 1;");
	mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因2:' . mysql_error() . '<br>' . postFooter());

	if ($Game_Scrn_Type == 1){
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<div align=left style=\"font-size: 16pt;height: 100%\">完成了！<br>現在你的$ShowCompl<br>";
	echo "<input type=submit value=\"返回\">";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</div>";
	echo "</form>";
	}
	elseif ($Game_Scrn_Type == 0) {
		$disableImg = "$General_Image_Dir/neo/plus_sign_grey.gif";
		echo "<script type=\"text/JavaScript\">";
		echo "parent.document.getElementById('pl_growth').innerHTML = ".$Gen['growth'].";";
		echo "parent.document.getElementById('".$stat_added."_addlink').style.visibility = 'visible';";
		if($stat_added != 'spmax'){
				CalcStatReq('New',$Game[$stat_added]+1);
				echo "parent.document.getElementById('pl_".$stat_added."').innerHTML = ".$Game[$stat_added].";";
				echo "parent.document.getElementById('pl_".$stat_added."').style.color = '".colorConvert($Game[$stat_added])."';";
			if($Game[$stat_added] < 150)
				echo "parent.document.getElementById('".$stat_added."_stat_req').innerHTML = ".$New_Stat_Req.";";
			echo "if (parseInt(parent.document.getElementById('attacking_stat_req').innerHTML) > parseInt(parent.document.getElementById('pl_growth').innerHTML || parseInt(parent.document.getElementById('pl_attacking').innerHTML) >= 150))";
			echo "{parent.document.getElementById('attacking_addlink').style.cursor = 'default';parent.document.getElementById('attacking_addlink').src = '$disableImg';}";
			echo "if (parseInt(parent.document.getElementById('defending_stat_req').innerHTML) > parseInt(parent.document.getElementById('pl_growth').innerHTML || parseInt(parent.document.getElementById('pl_defending').innerHTML) >= 150))";
			echo "{parent.document.getElementById('defending_addlink').style.cursor = 'default';parent.document.getElementById('defending_addlink').src = '$disableImg';}";
			echo "if (parseInt(parent.document.getElementById('reacting_stat_req').innerHTML) > parseInt(parent.document.getElementById('pl_growth').innerHTML || parseInt(parent.document.getElementById('pl_reacting').innerHTML) >= 150))";
			echo "{parent.document.getElementById('reacting_addlink').style.cursor = 'default';parent.document.getElementById('reacting_addlink').src = '$disableImg';}";
			echo "if (parseInt(parent.document.getElementById('targeting_stat_req').innerHTML) > parseInt(parent.document.getElementById('pl_growth').innerHTML || parseInt(parent.document.getElementById('pl_targeting').innerHTML) >= 150))";
			echo "{parent.document.getElementById('targeting_addlink').style.cursor = 'default';parent.document.getElementById('targeting_addlink').src = '$disableImg';}";
			if($Game[$stat_added] >= 150)
				echo "parent.document.getElementById('".$stat_added."_stat_req').innerHTML = 'N/A';";
		}else{
			echo "parent.document.getElementById('max_sp').innerHTML = parent.m_s = '".$Game['spmax']."';";
			echo "parent.document.getElementById('current_sp').innerHTML = parent.i_s = parent.s = ".$Game['sp'].";";
			echo "parent.sprate =". (0.004 * $Game['spmax']) .';';
		}
			echo "if (parseInt(document.getElementById('pl_growth').innerHTML) < $SP_Stat_Req)";
			echo "{parent.document.getElementById('spmax_addlink').style.cursor = 'default';parent.document.getElementById('spmax_addlink').src = '$disableImg';}";
		echo "</script>";
	}
}

//
// Mode: Modify MS HP/EN - View
//

function getHPModBasePrice($Current, $Default){
	global $Mod_HP_Cost, $Mod_HP_Cost;
	if($Current / $Default < 0.5){
		return $Current * 30 + $Mod_HP_Cost;
	}
	else{
		return $Current * 50 + $Mod_HP_UCost;
	}
}
function getENModBasePrice($Current, $Default){
	global $Mod_EN_Cost, $Mod_EN_Cost;
	$pc = $Current / $Default;
	if($pc < 0.25){
		return $Current * 150 + $Mod_EN_Cost;
	}
	elseif($Current / $Default < 0.5){
		return $Current * 300 + $Mod_EN_Cost;
	}
	elseif($Current / $Default < 0.75){
		return $Current * 600 + $Mod_EN_UCost;
	}
	else{
		return $Current * 1200 + $Mod_EN_UCost;
	}
}
function getExtStat($EqF){
	// Lended to equip.php
	$Ext = array('HP' => 0, 'EN' => 0);
	if ($EqF && $EqF != "0<!>0"){
		unset($Eq_Id,$Eq_Prep,$Eq_Query,$Eq,$a);
		$Eq_Id = explode('<!>',$EqF);
		$Eq_Prep = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $Eq_Id[0] ."'");
		$Eq_Query = mysql_query($Eq_Prep);
		$Eq = mysql_fetch_array($Eq_Query);
		if (preg_match('/ExtHP<([0-9]+)>/',$Eq['spec'],$a)){$Ext['HP'] += intval($a[1]);unset($a);}
		if (preg_match('/ExtEN<([0-9]+)>/',$Eq['spec'],$a)){$Ext['EN'] += intval($a[1]);unset($a);}
	}
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

	$Ext = array('HP' => 0, 'EN' => 0);
	$ExtTemp = getExtStat($Game['eqwep']);
	$Ext['HP'] += $ExtTemp['HP'];
	$Ext['EN'] += $ExtTemp['EN'];
	$ExtTemp = getExtStat($Game['p_equip']);
	$Ext['HP'] += $ExtTemp['HP'];
	$Ext['EN'] += $ExtTemp['EN'];
	
	$Game['hpmax'] -= $Ext['HP'];
	$Game['enmax'] -= $Ext['EN'];

	$HP_Mod_Base_Price = getHPModBasePrice($Game['hpmax'], $Pl_Ms['hpfix']);
	if ($HP_Mod_Base_Price > $Gen['cash']){
		$modhp_dis = 'disabled';
	}
	else{
		$modhp_dis = '';
	}

	$EN_Mod_Base_Price = getENModBasePrice($Game['enmax'], $Pl_Ms['enfix']);
	if ($EN_Mod_Base_Price > $Gen['cash']){
		$moden_dis = 'disabled';
	}
	else{
		$moden_dis='';
	}

	echo "<script langauge=\"Javascript\">";
	echo "function calchp(){";
	echo "var pricemt = document.modmsform.mod_hp_muiltiple.value;";
	echo "var price = pricemt * '$HP_Mod_Base_Price';";
	echo "hpmodprice.innerHTML = price;";
	echo "hpmodprice.style.color='blue';";
	echo "if (price > $Gen[cash]){hpmodprice.style.color='red';document.modmsform.hp_mod_submit.disabled=true;}";
	echo "else{document.modmsform.hp_mod_submit.disabled=false;}";
	echo "if (price == $Gen[cash]){hpmodprice.style.color='yellow';}";
	echo "}function calcen(){";
	echo "var pricemt = document.modmsform.mod_en_muiltiple.value;";
	echo "var price = pricemt * '$EN_Mod_Base_Price';";
	echo "enmodprice.innerHTML = price;";
	echo "enmodprice.style.color='blue';";
	echo "if (price > $Gen[cash]){enmodprice.style.color='red';document.modmsform.en_mod_submit.disabled=true;}";
	echo "else{document.modmsform.en_mod_submit.disabled=false;}";
	echo "if (price == $Gen[cash]){enmodprice.style.color='yellow';}}";
	echo "function returnCheckHP(){var resulthpadd=(document.modmsform.mod_hp_muiltiple.value)*100;";
	echo "if (hpmodprice.innerHTML > $Gen[cash]){alert('金錢不足！');return false;}";
	echo "if (document.modmsform.mod_hp_muiltiple.value > 10){alert('金錢不足！');return false;}";
	echo "if (confirm('用'+hpmodprice.innerHTML+'元改造'+resulthpadd+'點HP\\n碓定嗎？') == true){document.modmsform.actionb.value='hpmodding';return true;}else{return false;}";
	echo "}function returnCheckEN(){var resultenadd=(document.modmsform.mod_en_muiltiple.value)*10;";
	echo "if (enmodprice.innerHTML > $Gen[cash]){alert('金錢不足！');return false;}";
	echo "if (document.modmsform.mod_en_muiltiple.value > 10){alert('金錢不足！');return false;}";
	echo "if (confirm('用'+enmodprice.innerHTML+'元改造'+resultenadd+'點EN\\n碓定嗎？') == true){document.modmsform.actionb.value='enmodding';return true;}else{return false;}";
	echo "}</script>";
	echo "<tr align=center><td><b>機體改造: </b></td></tr>";
	if($Game['hpmax'] + 1000 <= $Game['hpmax'] * $Max_HP){
		echo "<tr align=left>";
		echo "<td width=\"300\"><b>附加裝甲:</b><br>每付加一次增加100點HP<br>";
		echo "所需金錢: $<span id=hpmodprice>$HP_Mod_Base_Price</span><br>";
		echo "改造次數: <select size=1 name=\"mod_hp_muiltiple\" onChange=\"calchp()\">";
		echo "<option value='1'>1<option value='2'>2<option value='3'>3<option value='4'>4<option value='5'>5<option value='6'>6<option value='7'>7<option value='8'>8<option value='9'>9<option value='10'>10";
		echo "</select>次";
		echo "<input type=submit name=hp_mod_submit $modhp_dis value='確認改造' onClick=\"return returnCheckHP()\">";
		echo "</td>";
		echo "</tr>";
	}
	else echo "<tr align=left><td width=\"300\">你的機體不能再進行附加裝甲工程了！<input type=hidden name=\"mod_hp_muiltiple\" value=1></td></tr>";
	if($Game['enmax'] + 100 < $Game['enmax'] * $Max_EN){
		echo "<tr align=left>";
		echo "<td width=\"300\"><b>附加能源CAP:</b><br>每付加一次增加10點EN<br>";
		echo "所需金錢: $<span id=enmodprice>$EN_Mod_Base_Price</span><br>";
		echo "改造次數: <select size=1 name=\"mod_en_muiltiple\" onChange=\"calcen()\">";
		echo "<option value='1'>1<option value='2'>2<option value='3'>3<option value='4'>4<option value='5'>5<option value='6'>6<option value='7'>7<option value='8'>8<option value='9'>9<option value='10'>10";
		echo "</select>次";
		echo "<input type=submit name=en_mod_submit $modhp_dis value='確認改造' onClick=\"return returnCheckEN()\">";
		echo "</td>";
		echo "</tr>";
	}
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

//
// Mode: Modify MS HP/EN - Process
//

elseif ($mode == 'prcmodms' && $actionb && $mod_hp_muiltiple && $mod_en_muiltiple){
if ($mod_hp_muiltiple > 10 || $mod_en_muiltiple > 10){echo "一之過最多只能改十次!!<br>";PostFooter();exit;}
if ($mod_hp_muiltiple <= 0 || $mod_en_muiltiple <= 0){echo "改造次數出了問題!!<br>";PostFooter();exit;}
GetMsDetails("$Gen[msuit]",'Pl_Ms');

	$Ext = array('HP' => 0, 'EN' => 0);
	$ExtTemp = getExtStat($Game['eqwep']);
	$Ext['HP'] += $ExtTemp['HP'];
	$Ext['EN'] += $ExtTemp['EN'];
	$ExtTemp = getExtStat($Game['p_equip']);
	$Ext['HP'] += $ExtTemp['HP'];
	$Ext['EN'] += $ExtTemp['EN'];
	
	$Game['hpmax'] -= $Ext['HP'];
	$Game['enmax'] -= $Ext['EN'];

//
// Sub-action: HP Modding
//

if ($actionb == 'hpmodding'){
	
	$RealMax = $Max_HP * $Pl_Ms['hpfix'];
	
	if ($Game['hpmax'] >= $RealMax){echo "<center>HP改造達到上限了。<br></center>";PostFooter();exit;}

	$HP_Mod_Base_Price = getHPModBasePrice($Game['hpmax'], $Pl_Ms['hpfix']);
	
	$Mod_Cost = $mod_hp_muiltiple * $HP_Mod_Base_Price;
	$Mod_Amnt = $mod_hp_muiltiple * 100;
	
	if ($Gen['cash'] - $Mod_Cost < 0){echo "金錢不足!!<br>";PostFooter();exit;}
	if ($Game['hpmax'] + $Mod_Amnt > $RealMax){
		$mod_hp_muiltiple = ceil(($RealMax - $Game['hpmax'])/100);
		$Mod_Cost = $mod_hp_muiltiple * $HP_Mod_Base_Price;
		$Mod_Amnt = $mod_hp_muiltiple * 100;
	}

	$Gen['cash'] -= $Mod_Cost;
	$Game['hpmax'] += $Mod_Amnt;
}

//
// Sub-action: EN Modding
//

if ($actionb == 'enmodding'){
	
	$RealMax = $Max_EN * $Pl_Ms['enfix'];
	
	if ($Game['enmax'] >= $RealMax){echo "<center>EN改造達到上限了。<br></center>";PostFooter();exit;}

	$EN_Mod_Base_Price = getENModBasePrice($Game['enmax'], $Pl_Ms['enfix']);

	$Mod_Cost = $mod_en_muiltiple * $EN_Mod_Base_Price;
	$Mod_Amnt = $mod_en_muiltiple * 10;
	
	if ($Gen['cash'] - $Mod_Cost < 0){echo "金錢不足!!<br>";PostFooter();exit;}
	if ($Game['enmax'] + $Mod_Amnt > $RealMax){
		$mod_en_muiltiple = ceil(($RealMax - $Game['enmax'])/10);
		$Mod_Cost = $mod_en_muiltiple * $EN_Mod_Base_Price;
		$Mod_Amnt = $mod_en_muiltiple * 10;
	}

	$Gen['cash'] -= $Mod_Cost;
	$Game['enmax'] += $Mod_Amnt;
}

$Game['hpmax'] += $Ext['HP'];
$Game['enmax'] += $Ext['EN'];

$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hpmax` = '".($Game['hpmax'])."', `enmax` = '".($Game['enmax'])."' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql) or die(mysql_error());

$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '".($Gen['cash'])."' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql);

echo "<form action=statsmod.php?action=modms method=post name=frmmodms target=$SecTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<p align=center style=\"font-size: 16pt\">改造完成了！<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
postFooter();
}

//
// Mode: Repair MS - View
//

elseif ($mode == 'repairms' && $actionb == 'sel'){

$War_State = checkWartime($Gen['coordinates']);

	$AreaORG_Prepare = ("SELECT `occupied` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$Gen[coordinates]'");
	$AreaORG_Query = mysql_query($AreaORG_Prepare) or die(mysql_error());
	$AreaORG = mysql_fetch_array($AreaORG_Query);
	$showOccupied = '';
	if ($Game['organization'] == $AreaORG['occupied']){
		$RepairHPCost = ceil($RepairHPCost * 0.5);
		$RepairENCost = ceil($RepairENCost * 0.5);
		$RepairEqCondCost = ceil($RepairEqCondCost * 0.5);
		$showOccupied = '本地居民亦可享有50%折扣優惠。<br>';
	}

	echo "修理工場<hr>";
	if (isset($Otp_TellTime) && $Otp_TellTime){echo "$Otp_TellTime<hr>";}
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
	echo "本工場於國戰進行時不會開啟，".$showOccupied."回復價錢如下:<br>回復1點HP需要 $RepairHPCost 元。<br>回復1點EN需要 $RepairENCost 元。<br>回復 0.01% 裝備狀態值, 基本價錢 $RepairEqCondCost 元, 並依照武器等級上調價格。";
	echo "</td></tr>";
	echo "<script langauge=\"Javascript\">function CheckRepHP(){if (hprepcost.innerHTML > $Gen[cash]){alert('金錢不足！');return false;}if (confirm('回復HP，確定修理嗎？') == true){repairmsform.actionc.value='hprec';return true}else {return false}}";
	echo "function ChangePriceHP(typerepair){if (typerepair == 'pc'){var rephpamt = ($Game[hpmax] - document.getElementById('hp_show').innerHTML) * document.repairmsform.hp_rep_pc_amount.value ;document.getElementById('hppcrep').innerHTML = Math.round(rephpamt);var rehpprc = Math.round($RepairHPCost * rephpamt);";
	echo "document.getElementById('hprepcost').innerHTML = rehpprc;}if (typerepair == 'pt'){var rephpamt = document.repairmsform.hp_rep_amount.value;if (rephpamt > ($Game[hpmax] - document.getElementById('hp_show').innerHTML)){rephpamt = ($Game[hpmax] - document.getElementById('hp_show').innerHTML);}var rehpprc = Math.round($RepairHPCost * rephpamt);";
	echo "document.getElementById('hprepcost').innerHTML = rehpprc;}}function CheckEmergency(){if (".($EmergencyCost*$NowMS['needlv'])." > ".($Gen['cash'])."){alert('金錢不足！');return false;}if (confirm('緊急出擊, 確定嗎？') == true){document.repairmsform.actionc.value='emergency';return true}else {return false}}</script>";
	echo "<tr><td><b>回復HP:</b><br>HP: <span id=hp_show>$Game[hp]</span> / $Game[hpmax]";
	if ($Game['hp'] < $Game['hpmax']){
		if(!$War_State){
			echo "<br>以百分比回復餘下的 <input type=radio checked name='hp_rep_type' value='pc' OnClick=\"hp_rep_pc_amount.disabled=false;hp_rep_amount.disabled=true;hprepcost.innerHTML='0';hp_rep_pc_amount.value='0';\">: 回復 <select name='hp_rep_pc_amount' onChange=\"ChangePriceHP('pc')\"><option value=0>--選擇--<option value=0.1>10%<option value=0.2>20%<option value=0.3>30%<option value=0.4>40%<option value=0.5>50%<option value=0.6>60%<option value=0.7>70%<option value=0.8>80%<option value=0.9>90%<option value=1.0 selected>100%</select>(<span id=hppcrep>0</span>點)";
			echo "<br>手動輸入回復量 <input type=radio value='pt' name='hp_rep_type' OnClick=\"hp_rep_pc_amount.disabled=true;hp_rep_amount.disabled=false;hprepcost.innerHTML='0';hppcrep.innerHTML='0';\">: 回復 <input type=text size=4 maxlength=5 name='hp_rep_amount' value=0 disabled onChange=\"ChangePriceHP('pt')\">點";
			echo "<br>所需金錢: <span id=hprepcost>0</span> 元。<br><input type=submit name=hp_rep_submit value='回復HP' onClick=\"return CheckRepHP();\">";
			
		}
		else	echo "<br>　 - 國戰進行中";
		if($Game['hp'] > $NowMS['hpfix']*0.8){
			echo "<br> - 緊急出擊: ";
			echo "<br>　- HP達到原有的 80% 時 (".number_format(ceil($NowMS['hpfix']*0.8))."), 能使機體進入可發進狀態";
			echo "<br>所需金錢: ".number_format($EmergencyCost*$NowMS['needlv'])." 元。<br><input type=submit name=hp_rep_submit value='緊急出擊' onClick=\"return CheckEmergency();\">";
		}
		echo "</td></tr>";
	}else{echo "<br>　 - 你無需回復HP</td></tr>";}
	echo "<script langauge=\"Javascript\">function CheckRepEN(){if (document.getElementById('enrepcost').innerHTML > $Gen[cash]){alert('金錢不足！');return false;}if (confirm('回復EN，確定修理嗎？') == true){repairmsform.actionc.value='enrec';return true}else {return false}}";
	echo "function ChangePriceEN(typerepair){if (typerepair == 'pc'){var repenamt = ($Game[enmax] - document.getElementById('en_show').innerHTML) * document.repairmsform.en_rep_pc_amount.value ;document.getElementById('enpcrep').innerHTML = Math.round(repenamt);var reenprc = Math.round($RepairENCost * repenamt);";
	echo "document.getElementById('enrepcost').innerHTML = reenprc;}if (typerepair == 'pt'){var repenamt = document.repairmsform.en_rep_amount.value;if (repenamt > ($Game[enmax] - document.getElementById('en_show').innerHTML)){repenamt = ($Game[enmax] - document.getElementById('en_show').innerHTML);}var reenprc = Math.round($RepairENCost * repenamt);";
	echo "document.getElementById('enrepcost').innerHTML = reenprc;}}</script>";
	echo "<tr><td><b>回復EN:</b><br>EN: <span id=en_show>$Game[en]</span> / $Game[enmax]";
	if($War_State){echo "<br>　 - 國戰進行中</td></tr>";}
	elseif ($Game['en'] < $Game['enmax']){
	echo "<br>以百分比回復餘下的 <input type=radio checked name='en_rep_type' value='pc' OnClick=\"en_rep_pc_amount.disabled=false;en_rep_amount.disabled=true;document.getElementById('enrepcost').innerHTML='0';en_rep_pc_amount.value='0';\">: 回復 <select name='en_rep_pc_amount' onChange=\"ChangePriceEN('pc')\"><option value=0>--選擇--<option value=0.1>10%<option value=0.2>20%<option value=0.3>30%<option value=0.4>40%<option value=0.5>50%<option value=0.6>60%<option value=0.7>70%<option value=0.8>80%<option value=0.9>90%<option value=1.0 selected>100%</select>(<span id=enpcrep>0</span>點)";
	echo "<br>手動輸入回復量 <input type=radio value='pt' name='en_rep_type' OnClick=\"en_rep_pc_amount.disabled=true;en_rep_amount.disabled=false;document.getElementById('enrepcost').innerHTML='0';document.getElementById('enpcrep').innerHTML='0';\">: 回復 <input type=text size=4 maxlength=5 name='en_rep_amount' value=0 disabled onChange=\"ChangePriceEN('pt')\">點";
	echo "<br>所需金錢: <span id=enrepcost>0</span> 元。<br><input type=submit name=en_rep_submit value='回復EN' onClick=\"return CheckRepEN();\">";
	echo "</td></tr>";
	}else{echo "<br>　 - 你無需回復EN</td></tr>";}
		//狀態值相關
			//echo "<input type=hidden name=cond_pos value=0>";
			echo "<script language=\"Javascript\">function CheckCond(pos,cost){";
			echo "if (cost > $Gen[cash]){alert('金錢不足！');return false;}";
			echo "if (confirm('確定回復狀態值嗎？') == true){repairmsform.actionb.value='eq_condrep';repairmsform.actionc.value=pos;return true}else {return false}";
			echo "}</script>";
			//Process All Weapons
				$Id_Phrase = '';
				for($i=1;$i <= 5;$i++){
				switch($i){
					case 1: $W_Slot = $Game['wepa']; break;
					case 2: $W_Slot = $Game['wepb']; break;
					case 3: $W_Slot = $Game['wepc']; break;
					case 4: $W_Slot = $Game['eqwep']; break;
					case 5: $W_Slot = $Game['p_equip']; break;
				}
				$W_Params[$i] = explode('<!>',$W_Slot);
				$Id_Phrase .= ($i == 5) ? 'id =\''. $W_Params[$i][0] .'\'' : 'id =\''. $W_Params[$i][0] .'\' OR ';
				unset($W_Slot);
				}

				$SQL = ("SELECT `id`,`name`,`complexity` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE " . $Id_Phrase);
				$Query = mysql_query($SQL);

				$j = 0;
				while($Weapon = mysql_fetch_array($Query)) {$Weapon_Raw[$j] = $Weapon; $j++;}

				for($k=1;$k<=5;$k++){
				$A = 'wepa';
				switch($k){
					case 2: $A = 'wepb';break;
					case 3: $A = 'wepc';break;
					case 4: $A = 'eqwep';break;
					case 5: $A = 'p_equip';break;
				}
					for($l=0;$l < $j;$l++) {
						if ($W_Params[$k][0] != $Weapon_Raw[$l]['id']) continue;
						$EqD[$A] = $Weapon_Raw[$l];
					}

				$EqD[$A]['exp']=$W_Params[$k][1];
				$EqD[$A]['pos']=$A;
				$W_Params[$k][2] = ( isset($W_Params[$k][2]) ) ? $W_Params[$k][2] : 0;
					if ($W_Params[$k][2]){
						if ($W_Params[$k][2] == 1) $EqD[$A]['name'] = $W_Params[$k][3].$EqD[$A]['name']."<sub>&copy;</sub>";
						else $EqD[$A]['name'] = $EqD[$A]['name'].$W_Params[$k][3]."<sub>&copy;</sub>";
					}
				}
			//End of Processing
			//UI
			echo "<tr><td><b>回復武器狀態值:</b><br>";
			$i = 0;
			foreach($EqD as $e) {
				if($e['exp'] < $RepairEqCondMax){
					$DisplayXp = ($e['exp'] >= 0) ? '+'.($e['exp']/100) : ($e['exp']/100);
					$CondRepCost = ($RepairEqCondMax - $e['exp'])*$RepairEqCondCost*($e['complexity']+1);
					echo $e['name'].":<br>　 - 狀態值: <font color=red> ".$DisplayXp.'%</font><br>';
					echo "　 - 所需金錢: ".number_format($CondRepCost)." 元。<Br>";
					echo "　 - <input type=submit name=en_rep_submit value='修理此武器' onClick=\"return CheckCond('".$e['pos']."',$CondRepCost);\"><br>";
				}else $i++;
			}
			if ($i == 5) echo "　 - 沒有可回復狀態值的武器";
			echo "</td></tr>";


	echo "<script language=\"JavaScript\">";
	echo "fetchInstantStat();";
	echo "function fetchInstantStat(){";
	echo "document.getElementById('en_show').innerHTML = parent.document.getElementById('current_en').innerHTML;";
	echo "if(document.repairmsform.en_rep_type != null) if(document.repairmsform.en_rep_type[0].checked) ChangePriceEN('pc');";
	echo "document.getElementById('hp_show').innerHTML = parent.document.getElementById('current_hp').innerHTML;";
	echo "if(document.repairmsform.hp_rep_type != null) if(document.repairmsform.hp_rep_type[0].checked) ChangePriceHP('pc');";
	echo "setTimeout(\"fetchInstantStat()\",100);";
	echo "}";
	echo "</script>";


	echo "</form></table>";
postFooter();exit;
}//End Repair Form

//
// Mode: Repair MS - Process
//

elseif ($mode == 'repairms' && $actionb == 'reppro'){

	$War_State = checkWartime($Gen['coordinates']);

	if(($actionc == 'hprec' || $actionc == 'enrec') && $War_State){
		echo "國戰進行中, 無法進行修理！";
		postFooter();
		exit;
	}

	$AreaORG_Prepare = ("SELECT `occupied` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$Gen[coordinates]'");
	$AreaORG_Q = mysql_query($AreaORG_Prepare) or die(mysql_error());
	$AreaORG = mysql_fetch_array($AreaORG_Q);
	if ($Game['organization'] == $AreaORG['occupied']){
		$RepairHPCost = ceil($RepairHPCost * 0.5);
		$RepairENCost = ceil($RepairENCost * 0.5);
	}

		$plr = array(
		"name" => $Pl_Value['USERNAME'],
		"hp" => $Game['hp'],
		"hpmax" => $Game['hpmax'],
		"en" => $Game['en'],
		"enmax" => $Game['enmax'],
		"sp" => $Game['sp'],
		"spmax" => $Game['spmax'],
		"status" => $Game['status'],
		"msuit" => $Gen['msuit'],
		"time1" => $Gen['time1'],
		"hypermode" => $Gen['hypermode'],
		"eqwep" => $Game['eqwep'],
		"p_equip" => $Game['p_equip']);
		$Pl_Repaired = RepairPlayer($plr,0,0,1);
	$Game['hp'] = $Pl_Repaired['hp'];
	$Game['en'] = $Pl_Repaired['en'];
	$Game['sp'] = $Pl_Repaired['sp'];
	$Game['status'] = $Pl_Repaired['status'];
	$Gen['time1'] = $Pl_Repaired['time1'];

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
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hp` = '$Game[hp]', `en` = '$Game[en]', `sp` = '$Game[sp]', `status` = '$Game[status]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `time1` = '$Gen[time1]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		if($Use_Behavior_Checker){
			$sql = "UPDATE `{$GLOBALS[DBPrefix]}phpeb_behaviour_check` SET `last_rtime` = {$GLOBALS[CFU_Time]} WHERE `username` = '{$Pl_Value[USERNAME]}';";
			$query = mysql_query($sql) or die('Behavior Checker Error! Cannot Update RTime!');
		}
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
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hp` = '$Game[hp]', `en` = '$Game[en]', `sp` = '$Game[sp]', `status` = '$Game[status]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `time1` = '$Gen[time1]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$RepMsg = "以 $PriceRepair 元回復了 $RepairAmt 點EN。";
		}
	elseif ($actionc == 'enrec' && ($Game['enmax'] <= $Game['en'])){echo "EN已經滿了！";postFooter();exit;}
	elseif ($actionc == 'emergency'){
		GetMSDetails($Gen['msuit'],'NowMS');
		$PriceRepair = $EmergencyCost*$NowMS['needlv'];
		if($Game['hp'] < $NowMS['hpfix']*0.8){echo "HP不足！ 未能緊急出擊！";postFooter();exit;}
		if ($Gen['cash'] - $PriceRepair < 0){echo "金錢不足！";postFooter();exit;}
		$Gen['cash'] -= $PriceRepair;
		$Game['status'] = 0;
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `hp` = '$Game[hp]', `en` = '$Game[en]', `sp` = '$Game[sp]', `status` = '0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `time1` = '$Gen[time1]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die (mysql_error());
		$RepMsg = "現在可以出擊了！";
	}
	else {echo "HP/EN已經滿了！";postFooter();exit;}

	if ($Game_Scrn_Type == 0) {
		echo "<script language=\"JavaScript\">";
		echo "TheNewDate = new Date();";
		echo "parent.r_h = parent.r_e = 0;";
		echo "parent.m_time = parent.mh_time = parent.me_time = TheNewDate.getTime();";
		echo "parent.document.getElementById('current_hp').innerHTML = parent.i_h = parent.h = ".$Game['hp'].";";
		echo "parent.document.getElementById('current_en').innerHTML = parent.i_e = parent.e = ".$Game['en'].";";
		if ($Game['status'] == '1') echo "parent.document.getElementById('status_now').innerHTML = '修理進行中';parent.document.getElementById('status_now').style.color='#FF2200';";
		else echo " parent.document.getElementById('status_now').innerHTML='發進登錄可能';parent.document.getElementById('status_now').style.color='#016CFE';";
		echo "parent.document.getElementById('pl_cash').innerHTML = '".number_format($Gen['cash'])."';";
		if ($Gen['fame'] >= 0)
		echo "parent.document.getElementById('type_fame').innerHTML = '名聲';";
		else echo "parent.document.getElementById('type_fame').innerHTML = '惡名';";
		echo "parent.document.getElementById('pl_fame').innerHTML = '".abs($Gen['fame'])."';";
		echo "</script>";
	}

echo "<form action=statsmod.php?action=repairms method=post name=frmrp target=$SecTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden value='sel' name=actionb>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<p align=center style=\"font-size: 16pt\"><br><br><br><br>$RepMsg<br><input type=button value=\"關閉此視窗\" onClick=\"parent.$SecTarget.location.replace('about:blank');parent.document.getElementById('STiF').style.left = -1150;\"><input type=submit value=\"繼續修理\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=submit value=\"重新整理\" onClick=\"parent.$SecTarget.location.replace('about:blank')\">";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";

postFooter();exit;

}//End Repair Mode

//
// Mode: Condition Repairing - Process
//

elseif ($mode == 'repairms' && $actionb == 'eq_condrep'){

$War_State = checkWartime($Gen['coordinates']);

$AreaORG_Prepare = ("SELECT `occupied` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$Gen[coordinates]'");
$AreaORG_Query = mysql_query($AreaORG_Prepare) or die(mysql_error());
$AreaORG = mysql_fetch_array($AreaORG_Query);
$showOccupied = '';
if ($Game['organization'] == $AreaORG['occupied']) $RepairEqCondCost = ceil($RepairEqCondCost * 0.5);
	//Process All Weapons
		$Id_Phrase = '';
		for($i=1;$i <= 5;$i++){
		switch($i){
			case 1: $W_Slot = $Game['wepa']; break;
			case 2: $W_Slot = $Game['wepb']; break;
			case 3: $W_Slot = $Game['wepc']; break;
			case 4: $W_Slot = $Game['eqwep']; break;
			case 5: $W_Slot = $Game['p_equip']; break;
		}
		$W_Params[$i] = explode('<!>',$W_Slot);
		$Id_Phrase .= ($i == 5) ? 'id =\''. $W_Params[$i][0] .'\'' : 'id =\''. $W_Params[$i][0] .'\' OR ';
		unset($W_Slot);
		}

		$SQL = ("SELECT `id`,`name`,`complexity` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE " . $Id_Phrase);
		$Query = mysql_query($SQL);

		$j = 0;
		while($Weapon = mysql_fetch_array($Query)) {$Weapon_Raw[$j] = $Weapon; $j++;}

		$A = 'wepa';$EqmCondDis='EqmExp_A';
		for($k=1;$k<=5;$k++){
		switch($k){
			case 2: $A = 'wepb';$EqmCondDis='EqmExp_B';break;
			case 3: $A = 'wepc';$EqmCondDis='EqmExp_C';break;
			case 4: $A = 'eqwep';$EqmCondDis='EqmExp_D';break;
			case 5: $A = 'p_equip';$EqmCondDis='EqmExp_E';break;
		}
			for($l=0;$l < $j;$l++) {
				if ($W_Params[$k][0] != $Weapon_Raw[$l]['id']) continue;
				$EqD[$A] = $Weapon_Raw[$l];
			}

		$EqD[$A]['exp']=$W_Params[$k][1];
		$EqD[$A]['pos']=$A;
		$EqD[$A]['txt']=$EqmCondDis;
		$W_Params[$k][2] = ( isset($W_Params[$k][2]) ) ? $W_Params[$k][2] : 0;
			if ($W_Params[$k][2]){
				if ($W_Params[$k][2] == 1) $EqD[$A]['name'] = $W_Params[$k][3].$EqD[$A]['name']."<sub>&copy;</sub>";
				else $EqD[$A]['name'] = $EqD[$A]['name'].$W_Params[$k][3]."<sub>&copy;</sub>";
			}
		}
	//End of Processing

$Error_Flag = 0;
$CondRepCost = -1;
$DisMaxXp = '';
if($RepairEqCondMax == 0) $DisMaxXp = "±0%";
else $DisMaxXp = ($RepairEqCondMax >= 0) ? '+'.$RepairEqCondMax.'%' : $RepairEqCondMax.'%';

$isValidSlot = ($actionc == 'wepa' || $actionc == 'wepb' || $actionc == 'wepc' || $actionc == 'eqwep' || $actionc == 'p_equip');
if (!$isValidSlot) {$RepMsg = "位置出錯！<br>";$Error_Flag = 1;}
else {
	$CondRepCost = ($RepairEqCondMax - $EqD[$actionc]['exp'])*$RepairEqCondCost*($EqD[$actionc]['complexity']+1);
	if ($EqD[$actionc]['exp'] >= $RepairEqCondMax) {$RepMsg = "狀態值過高！<br>";$Error_Flag = 1;}
	elseif ($CondRepCost > $Gen['cash'] || $CondRepCost < 0) {$RepMsg = "請留意一下價錢！<br>";$Error_Flag = 1;}
	else $RepMsg = $EqD[$actionc]['name'].' 的修理完成了！<br>狀態值回復至 '.$DisMaxXp;
}

if ($Error_Flag === 0){
	$Gen['cash'] -= $CondRepCost;
	//Update Weapon Info
		$Eq_Update = explode('<!>',$Game[$actionc]);
		$Eq_Update[1] = $RepairEqCondMax;
		$Game[$actionc] = implode('<!>',$Eq_Update);
	//Update Database
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$actionc` = '$Game[$actionc]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql) or die (mysql_error());
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql) or die (mysql_error());
}
echo "<script language=\"Javascript\">";
echo "parent.document.getElementById('pl_cash').innerHTML = '".number_format($Gen['cash'])."';";
echo "parent.document.getElementById('".$EqD[$actionc]['txt']."').innerHTML = '".$DisMaxXp."';";
echo "</script>";
echo "<form action=statsmod.php?action=repairms method=post name=frmrp target=$SecTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden value='sel' name=actionb>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<p align=center style=\"font-size: 16pt\"><br><br><br><br>$RepMsg<br><br><input type=button value=\"關閉此視窗\" onClick=\"parent.$SecTarget.location.replace('about:blank');parent.document.getElementById('STiF').style.left = -1150;\"><input type=submit value=\"繼續修理\">";
echo "</form>";
echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=submit value=\"重新整理\" onClick=\"parent.$SecTarget.location.replace('about:blank')\">";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";

postFooter();
exit;
}
//End Condition Repairing Mode

//
// Mode: Character Type - View
//

elseif ($mode == 'modtypech' && $actionb == 'A'){
	echo "人種改造<hr>";
	if($Gen['typech'] != 'nat'){echo "你不是一般人！不能進行改造！";exit;}

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

//
// Mode: Character Type - Process
//

elseif ($mode == 'modtypech' && $actionb == 'B'){
	echo "人種改造<hr>";
	$Dest_Type = $ModChMsg = (string) '';
	switch($dtype){
		case 1: $Dest_Type = 'enh'; $ModChMsg = '強化人間';break;
		case 2: $Dest_Type = 'ext'; $ModChMsg = 'Extended';break;
		default: echo "目標人種出錯!!";exit;
	}
	if($Gen['typech'] != 'nat'){echo "你不是一般人！不能進行改造！";exit;}
	else {
		if($Gen['cash'] < $ModChType_Cost){echo "現金不足!!";exit;}
		else {
			$Gen['cash'] -= $ModChType_Cost;
			$Gen['typech'] = $Dest_Type;
			$SQL = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `typech` = '$Gen[typech]', `hypermode` = 0 ");
			$SQL .= ("WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($SQL) or die(mysql_error());
		}

	}

echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
echo "<p align=center style=\"font-size: 16pt\">改造完成了！<br>你已改造成 $ModChMsg ！<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "</form>";
postFooter();exit;
}
//End Character Type Modding

//
// Mode: Custom
//

elseif ($mode == 'custom'){
$IncThread = "mscust_200804221814";
include('ms_custom.php');
}
?>