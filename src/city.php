<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
if ($Game['organization'])
$Pl_Org = ReturnOrg("$Game[organization]");

$Area = ReturnMap("$Gen[coordinates]");
//$AreaLandForm = ReturnMType($Area["Sys"]["type"]);
$Ar_Org = ReturnOrg($Area["User"]["occupied"]);

//Special Commands GUI
if ($mode=='ModFort'){
	if ($Area["User"]["occupied"] != $Game['organization'] || !$Game['rights']){
		echo "出錯。";
		postFooter();
		exit;
	}
	
	function getModFortPrice($cur, $max){
		$C = 56; // Threshold = 55
		$Multi = 120000;
		$Const = 1000000;
		$Num = $C - ($max - $cur);
		if($Num < 0) $Num = 0;
		$GS = 1;
		for($i = 1; $i <= $Num; $i++){
			if($i < 11) $Geo = 1.05;
			elseif($i > 45) $Geo = 1.15;
			else $Geo = 1.1;
			$GS *= $Geo;
		}
		return ($Multi * $GS + $Const);
	}
	
	function getSequencePrice($cur, $tar, $max){
		$Price = 0;
		if($tar > $max) $tar = $max;
		for($i = $cur; $i <= $tar; $i++){
			$Price += getModFortPrice($i, $max);
		}
		return $Price;
	}
	
	// Fort Modification Settings
	$At_Cost = getModFortPrice($Area["User"]["at"], $Area["Sys"]["max_at"]);
	$De_Cost = getModFortPrice($Area["User"]["de"], $Area["Sys"]["max_de"]);
	$Ta_Cost = getModFortPrice($Area["User"]["ta"], $Area["Sys"]["max_ta"]);
	$HpMax_Cost = ($Area["User"]["hpmax"]+1000) * 25;
	
	$FortRecHpCost = floor($RepairHPCost*2);
	$eRecCost = 2*$FortRecHpCost;
	$eRec = 1000;
	$sRec = 25000;
	$lRec = 50000;

	$Otp_Area_Sql = ("SELECT `war_id` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `mission` = 'Atk<$Gen[coordinates]>' AND `t_start` >= '$CFU_Time' AND `t_end` < '$CFU_Time' ORDER BY `t_start` ASC LIMIT 1");
	$Otp_Area_Q = mysql_query($Otp_Area_Sql) or die(mysql_error());
	$Otp_A_I_W = mysql_num_rows($Otp_Area_Q);
	$Otp_A_ITar = ($Otp_A_I_W > 0) ? 1 : 0;

	echo "<font style=\"font-size: 12pt\">強化城塞</font>";
	printTHR();

	//Selection of Modification
	if ($actionb == 'A'){
		echo "<form action=city.php?action=ModFort method=post name=mainform>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='C' name=actionc>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
		echo "<script language=\"Javascript\">";
		echo "function cfmModFort(type){";
		echo "if (type == 'at' && (".$At_Cost." > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
		echo "else if (type == 'de' && (".$De_Cost." > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
		echo "else if (type == 'ta' && (".$Ta_Cost." > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
		echo "else if (type == 'hpmax' && (".$HpMax_Cost." > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
		echo "else if (type == 'ehp' && (".($eRecCost*$eRec)." > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
		echo "else if (type == 'shp' && (".($FortRecHpCost*$sRec)." > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
		echo "else if (type == 'lhp' && (".($FortRecHpCost*$lRec)." > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
		echo "else {if (confirm('確定要強化城塞嗎？')==true){mainform.actionc.value=type;return true;}";
		echo "else {return false;}}";
		echo "}</script>";
	
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">強化 $Gen[coordinates]區域 的城塞: </b></td></tr>";
		echo "<tr><td>組織資金: ".number_format($Pl_Org['funds'])."元";
		if ($Area["User"]["at"] < $Area["Sys"]["max_at"]) echo "<br>強化要塞攻擊力: <input type=submit value=\"強化1點AT\" onClick=\"return cfmModFort('at');\"> 所需金錢: $". number_format($At_Cost);
		if ($Area["User"]["de"] < $Area["Sys"]["max_de"]) echo "<br>強化要塞防禦力: <input type=submit value=\"強化1點DE\" onClick=\"return cfmModFort('de');\"> 所需金錢: $". number_format($De_Cost);
		if ($Area["User"]["ta"] < $Area["Sys"]["max_ta"]) echo "<br>強化要塞命中能力: <input type=submit value=\"強化1點TA\" onClick=\"return cfmModFort('ta');\"> 所需金錢: $". number_format($Ta_Cost);
		if ($Area["User"]["hpmax"] + 1000 <= $Area["Sys"]["hpmax"]*2.5) echo "<br>強化要塞裝甲耐久度: <input type=submit value=\"增加1000HP\" onClick=\"return cfmModFort('hpmax');\"> 所需金錢: $". number_format($HpMax_Cost);
	
		if ($Otp_A_ITar) echo "<br>緊急維修: <input type=submit value=\"回復".$eRec."點HP\" onClick=\"return cfmModFort('ehp');\"> 所需金錢: $".number_format($eRecCost*$eRec);
		else{
			echo "<br>回復部份HP: <input type=submit value=\"回復".$sRec."點\" onClick=\"return cfmModFort('shp');\"> 所需金錢: $".number_format($FortRecHpCost*$sRec);
			echo "<br>回復大量HP: <input type=submit value=\"回復".$lRec."點\" onClick=\"return cfmModFort('lhp');\"> 所需金錢: $".number_format($FortRecHpCost*$lRec);
		}
	
		echo "</tr></td>";
		echo "</form></table>";
	}
	//Process with modification
	elseif($actionb == 'B' && $actionc){
		$bCost = $Pl_Org['funds'] + 1;
		$statMod = $emergencyFlag = $recoverHPFlag = 0;
		$statLim = -1;
		$statDeg = 1;
		$sql = $sqlSet = '';
	
		switch($actionc){
			case 'at':	
				$bCost = $At_Cost;
				$statMod = $Area["User"]["at"];
				$statLim = $Area["Sys"]["at"] * 2;
				if($statLim > 100) $statLim = 100;
				$sqlSet = ("`at` = `at` + ".$statDeg);
				break;
			case 'de':	
				$bCost = $De_Cost;
				$statMod = $Area["User"]["de"];
				$statLim = $Area["Sys"]["de"] * 2;
				if($statLim > 100) $statLim = 100;
				$sqlSet = ("`de` = `de` + ".$statDeg);
				break;
			case 'ta':	
				$bCost = $Ta_Cost;
				$statMod = $Area["User"]["ta"];
				$statLim = $Area["Sys"]["ta"] * 2;
				if($statLim > 100) $statLim = 100;
				$sqlSet = ("`ta` = `ta` + ".$statDeg);
				break;
			case 'hpmax':
				$bCost = $HpMax_Cost;
				$statMod = $Area["User"]["hpmax"];
				$statLim = $Area["Sys"]["hpmax"] * 2.5;
				$statDeg = 1000;
				$sqlSet = ("`hpmax` = `hpmax` + ".$statDeg.", `hp` = `hp` + ".$statDeg);
				break;
			case 'ehp':
				$bCost = $eRecCost * $eRec;
				$statDeg = $eRec;
				$emergencyFlag = $recoverHPFlag = 1;
				break;
			case 'shp':
				$bCost = $FortRecHpCost * $sRec;
				$statDeg = $sRec;
				$recoverHPFlag = 1;
				break;
			case 'lhp':
				$bCost = $FortRecHpCost * $lRec;
				$statDeg = $lRec;
				$recoverHPFlag = 1;
				break;
			case 'wep':
				if (!$FortWep){
					echo "<center>請先選擇要換成的武器。";
					postFooter();
					exit;
				}
				else{
					unset($Ex_Wep,$Ar_Wep);
					GetWeaponDetails($FortWep,'Ex_Wep');
					GetWeaponDetails($Area["User"]["wepa"],'Ar_Wep');
					$ExchangePrice = ceil($Ex_Wep['price'] - $Ar_Wep['price']/2);
					if ($ExchangePrice < 0) $ExchangePrice = 0;
					if (strpos($Ex_Wep['spec'],'FortressOnly') === false){echo "這不是要塞專用武器。";postFooter();exit;}
					elseif($ExchangePrice > $Pl_Org['funds']){echo "<center>組織資金不足。";postFooter();exit;}
					else{
						$bCost = $ExchangePrice;
						$sqlSet = "`wepa` = '$Ex_Wep[id]'";
					}
				}
				break;
			default:
				echo "<center>Undefined";
				postFooter();
				exit;
		}
	
		if ($bCost > $Pl_Org['funds'] || $bCost < 0){echo "<center>組織資金不足。";postFooter();exit;}

		
		if($statMod + $statDeg > $statLim && !$recoverHPFlag && $actionc != 'wep'){
			echo "<center>指定的能力已達上限。";
			postFooter();
			exit;
		}elseif($Otp_A_ITar && ($Area["User"]["hp"] <= 0 || !$emergencyFlag)){
			echo "<center>";
			echo ($Area["User"]["hp"] > 0) ? "戰略進行中，未能強化要塞！<br>只能進行緊急修理" : "要塞已淪陷！";
			postFooter();
			exit;
		}
		
		if($recoverHPFlag){
			if ($Area["User"]["hp"] + $statDeg >= $Area["User"]["hpmax"])
				$sqlSet = ("`hp` = `hpmax`");
			else	$sqlSet = ("`hp` = `hp` + " . $statDeg);
		}
		
		if(!$sqlSet){
			echo "<center>SQL Error";
			postFooter();
			exit;
		}
	
		//更新 Map Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET $sqlSet WHERE `occupied` = '".$Game['organization']."' AND `map_id` = '".$Gen['coordinates']."'");
		$query = mysql_query($sql) or die ('MYSQL Error at city.php Line 237');

		//更新 Org Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds` - ".intval($bCost)." WHERE `id` = '".$Game['organization']."' LIMIT 1");
		$query = mysql_query($sql) or die ('MYSQL Error at city.php Line 241');
	
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">城塞強化完成了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}
}
elseif ($mode=='Reinforcement'){
	if ($Area["User"]["occupied"] != $Game['organization'] || !$Game['rights'])
	{echo "出錯。";postFooter();exit;}

	function analyseDay($time){
		$DateNow = getdate($GLOBALS['CFU_Time']);
		$DateTime = getdate($time);
		if ($DateNow['year'] < $DateTime['year'])	return false;
		elseif ($DateNow['year'] > $DateTime['year'])	return true;
		elseif ($DateNow['yday'] > $DateTime['yday'])	return true;
		else return false;
	}

	echo "<font style=\"font-size: 12pt\">軍事力量投資</font>";
	printTHR();


	if ($actionb == 'A'){
	echo "<form action=city.php?action=Reinforcement method=post name=mainform onSubmit=\"return confirmReinforcement();\">";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='C' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function makeVal(val,unlim){";
	echo "val = val.replace(/[a-zA-Z\-+&!?=,<>@#$%\^\*\#\/\\\\[\]\{\}\'\"]+/,'');";
	echo "val = Math.round(val);";
	echo "if(val > $dailyTicketLim && !unlim) val = $dailyTicketLim;";
	echo "return val;";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=600 colspan=2><b style=\"font-size: 10pt;\">軍事力量投資: </b></td></tr>";

		$sql = ("SELECT `map_id`, `aname`, `development`, `tickets` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `occupied` = '$Game[organization]' ORDER BY `map_id`");
		$query = mysql_query($sql);

		$O_Area = array();

		while($j = mysql_fetch_array($query))	$O_Area[$j['map_id']] = $j;
		unset($j);

		echo "<tr>";
		echo "<td width=200 valign=top>";
		echo "組織資金: ".number_format($Pl_Org['funds'])."元<br>";
		echo "國家所控制領地一覽:<br>";

		$j = 0;
		foreach($O_Area as $a)	{echo "&nbsp;- ".$a['map_id'].' ('.$a['aname'].')<br>';$j++;}
		if(!$j) echo "沒有領地。";
		echo "</td>";
		echo "<td width=400 valign=top>";
		echo "各管轄區的軍事力量:";
			echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 12pt;\" bordercolor=\"#FFFFFF\">";
			echo "<tr align=center><td width=50>區域</td><td width=150>區域名稱</td><td width=75>現有軍力</td><td width=75>增強軍力</td></tr>";
				$i = 0;
				foreach($O_Area as $a){
				echo "<tr align=center>";
					printf ('<td>%s</td><td>%s</td><td id=%s>%s</td>',$a['map_id'],$a['aname'],"tkt_".$a['map_id'],$a['tickets']);
					echo "<td>";
					if(analyseDay($a['development']) && $a['tickets'] < $ticketMax){
						echo "<input type=text $BStyleB style=\"$BStyleA;text-align: center;\" size=4 maxlength=4 ";
						echo "onChange=\"this.value=makeVal(this.value);if(makeVal(tkt_".$a['map_id'].".innerHTML,1) + parseInt(this.value) > $ticketMax) {this.value = $ticketMax - makeVal(tkt_".$a['map_id'].".innerHTML,1);}c_".$i.".innerHTML=this.value;changeCost();\" ";
						echo "name=\"reinforce[".$a['map_id']."]\">點";
						echo "<span style=\"visibility: hidden;position: absolute;\" id=c_".$i.">0</span>";
						$i++;
					}
					elseif($a['tickets'] >= $ticketMax) echo "已達上限";
					elseif(!analyseDay($a['development'])) echo "今天已投資";
					echo "</td>";
				echo "</tr>";
				}
				if($i > 0){
					echo "<script language=\"Javascript\">";
					echo "function numberFormat(num){";
					echo "	var numF = '';";
					echo "	var pNum = new String( num );";
					echo "	num = pNum;";
					echo "	var l = num.length;";
					echo "	var tx = Math.floor(l/3);";
					echo "	var rx = (l%3);";
					echo "	if (rx == 1){numF = num.substr(0,1);pNum = num.substr(1);}";
					echo "	else if (rx == 2){numF = num.substr(0,2);pNum = num.substr(2);}";
					echo "	else {numF = num.substr(0,3);pNum = num.substr(3);}";
					echo "	while(pNum.length >= 3){";
					echo "		numF = numF+','+pNum.substr(0,3);";
					echo "		pNum = pNum.substr(3);";
					echo "	}";
					echo "	return numF;";
					echo "}function changeCost(){";
					echo "var b_cost = $ticketCost;";
					echo "var c_cost = 0;";
					echo "for(i=0;i<$i;i++){";
					echo "c_cost += b_cost * makeVal(eval('c_'+i+'.innerHTML;'));";
					echo "}";
					echo "cost_n.innerHTML = c_cost;";
					echo "c_cost = numberFormat(c_cost);";
					echo "cost.innerHTML = c_cost;";
					echo "}function confirmReinforcement(){";
					echo "if (parseInt(cost.innerHTML) > $Pl_Org[funds]){alert('組織資金不足。');return false;}";
					echo "else {if (confirm('確定要增強軍力嗎？')==true){return true;} else {return false}}";
					echo "}</script>";
					echo "<tr><td colspan=4><hr width=80%>所需組織資金: $<span id=cost>0</span><span id=cost_n style=\"visibility: hidden; position: absolute;\">0</span></td></tr>";
					echo "<tr><td colspan=4 align=center><input type=submit name=rnf_submit value=確定 $BStyleB style=\"$BStyleA;\"></td></tr>";
				}else	echo "<tr><td colspan=4 align=center>沒有可以投資的領地。</td></tr>";
			echo "</table>";
		echo "</td>";
		echo "</tr>";

	echo "</form></table>";
	}
	elseif($actionb == 'B'){
		$Cost = 0;
		$A = array();
		$D = array();
		$sql_m = array();
		$sql = ("SELECT `map_id`,`tickets`,`development` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `occupied` = '$Game[organization]' ORDER BY `map_id`");
		$query = mysql_query($sql);
		$j = 0;

		while($i = mysql_fetch_array($query)){
			if($i['tickets'] <= 0) $i['tickets'] = 1;
			$A[$i['map_id']] = $i['tickets'];
			$D[$i['map_id']] = $i['development'];
		}

		foreach($reinforce as $Id => $t){
			if(!$t) continue;
			$j++;
			if(empty($A[$Id])){echo "<center>領地主權出錯。";postFooter();exit;}
			if(!analyseDay($D[$Id])) {echo "今天已投資";postFooter();exit;}
			$t = intval($t);
			if($t > $dailyTicketLim) $t = $dailyTicketLim;
			elseif($t < 0) $t = 0;
			if($A[$Id] + $t > $ticketMax) $t = $ticketMax - $A[$Id];
			$Cost += $t * $ticketCost;
			//Map Info SQL
			$sql_m[$Id] = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `tickets` = ".($A[$Id] + $t).", `development` = ".$CFU_Time." WHERE `occupied` = '".$Game['organization']."' AND `map_id` = '".$Id."' LIMIT 1;");
		}

		if($j <= 0) {echo "<center>並沒有進行任何投資。";postFooter();exit;}

		if($Cost > $Pl_Org['funds']) {echo "<center>組織資金不足。";postFooter();exit;}

		//Org Info SQL
		$sql_o = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`-$Cost WHERE `id` = '".$Game['organization']."' LIMIT 1");

		//Update Org Info
		$query = mysql_query($sql_o);
		//Update Map Info
		foreach($sql_m as $sql)	$query = mysql_query($sql);

		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">軍力增強了！<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('about:blank')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}
	elseif ($actionb == 'C'){
	echo "<form action=city.php?action=Reinforcement method=post name=mainform onSubmit=\"return confirmReinforcement();\">";
	echo "<input type=hidden value='D' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function makeVal(val,max,min){";
	echo "max = parseInt(max);";
	echo "if(max > $ticketMax) max = $ticketMax;";
	echo "val = val.replace(/[a-zA-Z\-+&!?=,<>@#$%\^\*\#\/\\\\[\]\{\}\'\"]+/,'');";
	echo "val = Math.round(val);";
	echo "if(val > max) val = max;";
	echo "else if(val < min) val = min;";
	echo "return parseInt(val);";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=650 colspan=2><b style=\"font-size: 10pt;\">迎擊準備: </b></td></tr>";

	$sql = ("SELECT `t_start`,`t_end`,`a_org`,`name`,`mission`,`ticket_b`,`map_id`, `aname`, `development`, `tickets` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map`, `".$GLOBALS['DBPrefix']."phpeb_user_war`, `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `b_org` = `occupied` AND `occupied` = '$Pl_Org[id]' AND `mission` REGEXP `map_id` AND `a_org` = `id` AND `t_end` > '$CFU_Time' ORDER BY `t_start`;");
	$query = mysql_query($sql);

	$O_Area = array();

	while($j = mysql_fetch_array($query))	{
		$tmp = array();
		$O_Area[$j['map_id']][$j['a_org']] = $j;
		if(preg_match('/Atk<([0-9a-zA-Z]+)>/',$j['mission'],$tmp)){
			$O_Area[$j['map_id']][$j['a_org']]['opta_id'] = $tmp[1];
		}
		unset($tmp);
	}

	echo "<tr>";
	echo "<td width=250 valign=top>";
	echo "組織資金: ".number_format($Pl_Org['funds'])."元<br>";
	echo "處於戰爭或備戰狀態領地一覽:<br>";

	$j = 0;
	foreach($O_Area as $a)	{
		foreach($a as $o) echo "&nbsp;- ".$o['map_id'].' ('.$o['aname'].')<br>';
		$j++;
	}
	if(!$j) echo "沒有領地處於戰爭或備戰狀態。";

	$helpString = '<b>說明:</b><div style="padding-left: 5pt;">- 當有敵對組織向己方領地宣戰時, 已方組織必須<b>調派軍力</b>作好迎擊準備。<br>';
	$helpString .= '- <b>調派軍力</b>必須於戰役<u>開始前完成</u>, 並且<u>只能調派<b>一次</b></u>;<br>所調軍派的軍力, 同時也只對<u><b>一個</b>攻方組織</u>有效<br>';
	$helpString .= '- 如有多於一個組織向己方領地宣戰, 不論是否相同的領地,<br>也必須分別<b>調動軍力</b>一次。</div>';

	printf ("</td><td width=400 valign=top>%s</td></tr><tr>",$helpString);
	echo "<td valign=top colspan=2>";
	echo "軍事力量:";
		echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 12pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr align=center><td width=50>區域</td><td width=150>區域名稱</td><td width=100>攻方組織</td><td width=75>現有軍力</td><td width=75>已調動軍力</td><td width=75>調動軍力</td><td width=75>緊急徵召</td></tr>";
			$i = 0;
			foreach($O_Area as $a){
				foreach($a as $o){
					$j = $k = '';
						if($o['ticket_b'] == 1 && $o['t_start'] > $CFU_Time){
							$j .= "<input type=text $BStyleB style=\"$BStyleA;text-align: center;\" size=5 maxlength=5 ";
							$j .= "onChange=\"this.value=makeVal(this.value,".($o['tickets']-1).",1);c_".$i.".innerHTML=this.value;changeCost();\" ";
							$j .= "name=\"reinforce[".$o['map_id']."][".$o['a_org']."]\" value=1>點";
							$j .= "<span style=\"visibility: hidden;position: absolute;\" id=c_".$i.">0</span>";
							$exTickets = $ticketMax - $o['tickets'] + 1;
							if($exTickets > 0){
								if($exTickets > $dailyTicketLim*2) $exTickets = $dailyTicketLim*2;
								$k .= "<input type=text $BStyleB style=\"$BStyleA;text-align: center;\" size=5 maxlength=5 ";
								$k .= "onChange=\"this.value=makeVal(this.value,$exTickets,0);cx_".$i.".innerHTML=this.value;changeCost();\" ";
								$k .= "name=\"xreinforce[".$o['map_id']."][".$o['a_org']."]\" value=0>點";
								$k .= "<span style=\"visibility: hidden;position: absolute;\" id=cx_".$i.">0</span>";
							}
							$i++;
						}
						elseif($o['ticket_b'] > 1) {$j .= "已調動"; $k .= '不適用';}
						elseif($o['t_start'] <= $CFU_Time) {$j .= "戰爭進行中"; $k .= '不適用';}

					printf ('<tr align=center><td>%s</td><td>%s</td><td>%s</td><td id=tkt_%1$s_%s>%s</td><td id=act_%1$s>%s</td><td>%s</td><td>%s</td></tr>',$o['map_id'],$o['aname'],$o['name'],$o['a_org'],$o['tickets'],$o['ticket_b'],$j,$k);
				}
			}
			if($i > 0){
				echo "<script language=\"Javascript\">";
				echo "function numberFormat(num){";
				echo "	var numF = '';";
				echo "	var pNum = new String( num );";
				echo "	num = pNum;";
				echo "	var l = num.length;";
				echo "	var tx = Math.floor(l/3);";
				echo "	var rx = (l%3);";
				echo "	if (rx == 1){numF = num.substr(0,1);pNum = num.substr(1);}";
				echo "	else if (rx == 2){numF = num.substr(0,2);pNum = num.substr(2);}";
				echo "	else {numF = num.substr(0,3);pNum = num.substr(3);}";
				echo "	while(pNum.length >= 3){";
				echo "		numF = numF+','+pNum.substr(0,3);";
				echo "		pNum = pNum.substr(3);";
				echo "	}";
				echo "	return numF;";
				echo "}function changeCost(){";
				echo "var b_cost = $ticketCost * 5;";
				echo "var c_cost = 0;";
				echo "for(i=0;i<$i;i++){";
				echo "var cx_amt = parseInt(eval('cx_'+i+'.innerHTML;'));";
				echo "var c_amt = parseInt(eval('c_'+i+'.innerHTML;'));";
				echo "if(cx_amt + c_amt > $ticketMax) {cx_amt = document.getElementById('cx_'+i).innerHTML = $ticketMax - c_amt;}";
				echo "c_cost += b_cost * cx_amt;";
				echo "}";
				echo "cost_n.innerHTML = c_cost;";
				echo "c_cost = numberFormat(c_cost);";
				echo "cost.innerHTML = c_cost;";
				echo "}function confirmReinforcement(){";
				echo "if (parseInt(cost_n.innerHTML) > $Pl_Org[funds]){alert('組織資金不足。');return false;}";
				echo "else {if (confirm('確定要調動軍力嗎？')==true){return true;} else {return false}}";
				echo "}</script>";
				echo "<tr><td colspan=7><hr width=80%>所需組織資金: $<span id=cost>0</span><span id=cost_n style=\"visibility: hidden; position: absolute;\">0</span></td></tr>";
				echo "<tr><td colspan=7 align=center><input type=submit name=rnf_submit value=確定 $BStyleB style=\"$BStyleA;\"></td></tr>";
			}else	echo "<tr><td colspan=7 align=center>沒有可以調動軍力的領地。</td></tr>";
		echo "</table>";
	echo "</td>";
	echo "</tr>";
	echo "</form></table>";
	}
	elseif($actionb == 'D'){
		$Cost = 0;
		$A = array();
		$sql_m = array();
		$sql = ("SELECT `a_org`,`name`,`color`,`mission`,`ticket_b`,`map_id`, `war_id`, `tickets` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map`, `".$GLOBALS['DBPrefix']."phpeb_user_war`, `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `b_org` = `occupied` AND `occupied` = '$Pl_Org[id]' AND `mission` REGEXP `map_id` AND `a_org` = `id` AND `t_end` > '$CFU_Time' ORDER BY `t_start`;");
		$query = mysql_query($sql);
		$j = 0;
		$HistoryWrite = "為了保護國土, <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 進行了軍事調動！<br>";

		while($i = mysql_fetch_array($query)){
			if($i['tickets'] <= 0) $i['tickets'] = 1;
			$A[$i['map_id']]['t_area'] = $i['tickets'];
			$A[$i['map_id']][$i['a_org']]['war_id'] = $i['war_id'];
			$A[$i['map_id']][$i['a_org']]['name'] = $i['name'];
			$A[$i['map_id']][$i['a_org']]['color'] = $i['color'];
			$A[$i['map_id']][$i['a_org']]['ticket_b'] = $i['ticket_b'];
		}

		foreach($reinforce as $M_Id => $c){
			foreach($c as $o_id => $o_c){
				if(empty($A[$M_Id])){echo "<center>領地主權出錯。";postFooter();exit;}
				if(empty($A[$M_Id][$o_id])){echo "<center>找不到相關組織資料。";postFooter();exit;}
				if($A[$M_Id][$o_id]['ticket_b'] > 1) continue;
				$o_c = intval($o_c);
				$xreinforce[$M_Id][$o_id] = intval($xreinforce[$M_Id][$o_id]);

				if($o_c > $A[$M_Id]['t_area'] - 1) $o_c = $A[$M_Id]['t_area'] - 1;
				if($o_c + $xreinforce[$M_Id][$o_id] > $ticketMax) $xreinforce[$M_Id][$o_id] = $ticketMax - $o_c;
				if($xreinforce[$M_Id][$o_id] > $dailyTicketLim * 2) $xreinforce[$M_Id][$o_id] = $dailyTicketLim * 2;
				if($xreinforce[$M_Id][$o_id] < 0 || $o_c < 0){echo "<center>軍力調動數量出錯。";postFooter();exit;}

				$t = $o_c + $xreinforce[$M_Id][$o_id];
				$Cost += $xreinforce[$M_Id][$o_id] * $ticketCost * 5;

				$A[$M_Id]['t_area'] -= $o_c;

				if($xreinforce[$M_Id][$o_id] || $o_c){
					$HistoryWrite .= "己調動 <b style=\"color: $Pl_Org[color]\">".$t."點</b> 軍力前往 ".$M_Id." 對抗 <b style=\"color: ".$A[$M_Id][$o_id]['color'].";\">".$A[$M_Id][$o_id]['name']."</b>！<br>";
					//Map Info SQL
					$sql_m[$M_Id] = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `tickets` = ".($A[$M_Id]['t_area'])." WHERE `occupied` = '".$Game['organization']."' AND `map_id` = '".$M_Id."' LIMIT 1;");
					//War Info SQL
					$sql_w[$M_Id][$o_id] = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_war` SET `ticket_b` = ".($t)." WHERE `war_id` = '".$A[$M_Id][$o_id]['war_id']."' LIMIT 1;");
					$j++;
				}
			}
		}

		if($Cost > $Pl_Org['funds']) {echo "<center>組織資金不足。";postFooter();exit;}

		//Org Info SQL
		$sql_o = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`-$Cost WHERE `id` = '".$Game['organization']."' LIMIT 1");

		//Update Org Info
		$query = mysql_query($sql_o);

		if($j >= 1){
			//Update Map Info
			foreach($sql_m as $sql) $query = mysql_query($sql);
			//Update War Info
			foreach($sql_w as $osql) foreach($osql as $sql) $query = mysql_query($sql);
			WriteHistory($HistoryWrite);
		}

		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">軍力調動完成了！<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('about:blank')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}else{echo "未定義動作！";}
}
elseif ($mode=='AssignDefender'){
	if ($Area["User"]["occupied"] != $Game['organization'] || !$Game['rights']){echo "出錯。";postFooter();exit;}

	echo "<font style=\"font-size: 12pt\">委派守衛</font>";
	printTHR();

	if ($actionb == 'A'){
		echo "<form action=city.php?action=AssignDefender method=post name=mainform onSubmit=\"return confirmAssignment();\">";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=780><b style=\"font-size: 10pt;\">委派守衛: </b></td></tr>";

			$sql = ("SELECT `map_id`, `aname`, `defenders` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `occupied` = '$Game[organization]' ORDER BY `map_id`");
			$query = mysql_query($sql);

			$O_Area = array();

			while($j = mysql_fetch_array($query))	$O_Area[$j['map_id']] = $j;
			unset($j);

			$sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '$Game[organization]' ORDER BY `rank` DESC");
			$query = mysql_query($sql);

			$Members = array();

			while($j = mysql_fetch_array($query))	$Members[$j['username']] = $j['gamename'];
			unset($j);

			echo "<tr>";

			echo "<td width=780 valign=top>";
			echo "各管轄區的守衛:";
				echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 12pt;\" bordercolor=\"#FFFFFF\">";
				echo "<tr align=center><td width=40>區域</td><td width=185>守衛一</td><td width=185>守衛二</td><td width=185>守衛三</td><td width=185>守衛四</td></tr>";
					$j = 0;
					foreach($O_Area as $a){
						$j++;
						echo "<tr align=center>";
							echo "<td>$a[map_id]</td>";
							if($a['defenders'])	$Defender = explode(',',$a['defenders']);
							else $Defender = array('','','','');
							for($k=0;$k < 4;$k++){
								if(empty($Defender[$k])) $Defender[$k] = '';
								echo "<td><select name=Defender[".$a['map_id']."][$k] $BStyleB style=\"$BStyleA;width: 185px;\">";
								echo "<option value=''>－－－－ 沒有守衛 －－－－";
								foreach($Members as $u => $g){
									if($Defender[$k] == $u) $selected = "selected";
									else $selected = '';
									printf('<option value="%s" %s>%s',$u,$selected,$g);
								}
								echo "</select></td>";
							}
						echo "</tr>";
					}
					if($j > 0){
						echo "<script language=\"Javascript\">";
						echo "function confirmAssignment(){";
						echo "if (confirm('確定要用這個守衛配置嗎？')==true){return true;} else {return false}";
						echo "}</script>";
						echo "<tr><td colspan=5 align=center><input type=submit name=asgndfnr_submit value=確定 $BStyleB style=\"$BStyleA;\"></td></tr>";
					}else	echo "<tr><td colspan=5 align=center>沒有可以委派守衛的領地。</td></tr>";
				echo "</table>";
			echo "</td>";
			echo "</tr>";

		echo "</form></table>";
	}
	elseif($actionb == 'B'){
		$Cost = 0;
		$A = array();
		$sql_m = array();
		$sql = ("SELECT `map_id` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `occupied` = '$Game[organization]' ORDER BY `map_id`");
		$query = mysql_query($sql);
		$j = 0;
		while($i = mysql_fetch_array($query))	$A[$i['map_id']] = true;

		$sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '$Game[organization]' ORDER BY `rank` DESC");
		$query = mysql_query($sql);

		$Members = array();

		while($j = mysql_fetch_array($query))	$Members[$j['username']] = $j['gamename'];
		unset($j);

		foreach($Defender as $M_Id => $d){
			if(empty($A[$M_Id])){echo "<center>領地主權出錯。";postFooter();exit;}
			$d = array_unique($d);
			if(count($d) > 4) $d = array($d[0],$d[1],$d[2],$d[3]);
			$c = 0;
			foreach($d as $dr){
				if(!array_key_exists($dr, $Members) && $dr){echo "<center>目標人物非己方組織的人員。";postFooter();exit;}
				elseif(!$dr) unset($d[$c]);
				$c++;
			}
			if(empty($d[0])) $d[0] = '';
			$setDefender = (count($d) > 1) ? implode(',',$d) : $d[0];

			//Map Info SQL
			$sql_sd[$M_Id] = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `defenders` = '$setDefender' WHERE `occupied` = '".$Game['organization']."' AND `map_id` = '".$M_Id."' LIMIT 1;");
		}

		//Update Map Info
		foreach($sql_sd as $sql)	$query = mysql_query($sql);

		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">守衛配置完成！<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('about:blank')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}else{echo "未定義動作！";}

}
else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>