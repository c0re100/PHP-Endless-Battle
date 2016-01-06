<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
//Tactics Learning center GUI
if ($mode=='main'){
	$CancelFlag=$TactMessage=$Tactics='';
	echo "戰術學院<hr>";
	if ($actionb == 'proclearn'){
		if (!$learndesired) {$TactMessage = '請先挑選要學習的戰術！';$CancelFlag = 1;}
		$Tactics = GetTactics($learndesired);
		if (!$Tactics) {$TactMessage = '不明戰術！';$CancelFlag = 1;}
		if ($Tactics['price'] > $Gen['cash']){$TactMessage = '金錢不足！';$CancelFlag = 1;}
		if ($Tactics['needlv'] > $Game['level']){$TactMessage .= '等級不足！';$CancelFlag = 1;}
		if (strpos($Game['tactics'],$Tactics['id']) !== false){$TactMessage .= "你早就學會了 $Tactics[name] 。";$CancelFlag = 1;}
		if (!$CancelFlag) {
			$TactMessage = "成功\以 ".number_format($Tactics['price'])." 元學習了 $Tactics[name] 。";
		}
	}else $CancelFlag = 1;
	if (empty($TactMessage) || !$TactMessage) $TactMessage = '觀迎來到本學院！';
	echo "$TactMessage<hr>";
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\"  style=\"border-collapse: collapse;font-size: 9pt;\" bordercolor=\"#FFFFFF\" width=\"740\">";
	echo "<form action=tacticslearn.php?action=main method=post name=mainform target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden value='' name=learndesired>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<tr align=center><td colspan=14><b>戰術列表: </b></td></tr>";
	echo "<tr align=center>";
	echo "<td width=\"20\">No.</td>";
	echo "<td width=\"100\">戰術名稱</td>";
	echo "<td width=\"50\">Attacking 修正</td>";
	echo "<td width=\"50\">Defending 修正</td>";
	echo "<td width=\"50\">Reacting 修正</td>";
	echo "<td width=\"50\">Targeting 修正</td>";
	echo "<td width=\"60\">命中修正</td>";
	echo "<td width=\"60\">回避修正</td>";
	echo "<td width=\"100\">其他效果</td>";
	echo "<td width=\"30\">HP消耗量</td>";
	echo "<td width=\"30\">EN消耗量</td>";
	echo "<td width=\"30\">SP消耗量</td>";
	echo "<td width=\"30\">所需等級</td>";
	echo "<td width=\"80\">價錢</td>";
	echo "</tr>";

	unset ($sql,$query);
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` WHERE id != '0' ORDER BY `price` DESC, `needlv` DESC");
	$query = mysql_query($sql);

	echo "<script language=\"Javascript\">";
	echo "function cmLearn(name,cost,id,needlv){if (needlv > $Game[level]){alert('你的等級不足。');return false;}if (cost > $Gen[cash]){alert('所持金不足!!');}else{";
	echo "if (confirm('學習戰術「'+name+'」需要 '+numberFormat(cost)+' 元。\\n確定要學習嗎？') == true)";
	echo "{mainform.actionb.value='proclearn';mainform.learndesired.value=id;mainform.submit();return true}";
	echo "else{return false}}}";
	echo "function cmLearnAlt(name,cost,id,needlv){if (needlv > $Game[level]){alert('你的等級不足。');return false;}if (cost > $Gen[cash]){alert('所持金不足!!');}else{";
	echo "if (confirm('學習戰術「'+name+'」需要 '+numberFormat(cost)+' 元。\\n確定要學習嗎？') == true) return true;";
	echo "else{return false}}}";
	echo "function numberFormat(num){";
	echo "	var numF = '';";
	echo "	var pNum = num;";
	echo "	var l = num.length;";
	echo "	var tx = Math.floor(l/3);";
	echo "	var rx = (l%3);";
	echo "	if (rx == 1){numF = num.substr(0,1);pNum = num.substr(1);}";
	echo "	else if (rx == 2){numF = num.substr(0,2);pNum = num.substr(2);}";
	echo "	else {numF = num.substr(0,3);pNum = num.substr(3);}";
	echo "	while(pNum.length >= 3){";
	echo "	numF = numF+','+pNum.substr(0,3);";
	echo "	pNum = pNum.substr(3);";
	echo "	}";
	echo "	return numF;";
	echo "}";
	echo "</script>";

	$c=$t_id=0;
	$TacticsAvail=$LrntTips=$LrntTpClr=false;
	$TacticsOptions = '';
	$learndesired = ( isset($_POST['learndesired']) ) ? $_POST['learndesired'] : false;
	while ($TacticsAvail = mysql_fetch_array($query)){
		$c++;
		$TacticsAvail['spinfo'] = ReturnSpecs($TacticsAvail['spec']);
		if (strpos($Game['tactics'],$TacticsAvail['id']) !== false || $TacticsAvail['id'] == $learndesired){
			$LrntTpClr = "3C3CFF";
			$LrntTips = "style=\"color: $LrntTpClr\"'";
		}else{
			$t_id = $TacticsAvail['id'];
			$TacticsOptions .= sprintf('<option value=%s>%s',$t_id,$TacticsAvail['name']);
		}
		echo "<tr align=center $LrntTips class=buymslist onMouseover=\"this.style.color='yellow';\" onMouseout=\"this.style.color='$LrntTpClr'\">";
		if (!$LrntTips) echo "<span onClick=\"mainform.learndesired.value='$TacticsAvail[id]';cmLearn('$TacticsAvail[name]','$TacticsAvail[price]','$t_id','$TacticsAvail[needlv]')\">";
		echo "<td width=\"20\">$c</td>";
		echo "<td width=\"100\" id=".$t_id."_name>$TacticsAvail[name]</td>";
		echo "<td width=\"50\">$TacticsAvail[atf]</td>";
		echo "<td width=\"50\">$TacticsAvail[def]</td>";
		echo "<td width=\"50\">$TacticsAvail[ref]</td>";
		echo "<td width=\"50\">$TacticsAvail[taf]</td>";
		echo "<td width=\"50\">$TacticsAvail[hitf]</td>";
		echo "<td width=\"50\">$TacticsAvail[missf]</td>";
		echo "<td width=\"100\">$TacticsAvail[spinfo]</td>";
		echo "<td width=\"30\">$TacticsAvail[hpc]</td>";
		echo "<td width=\"30\">$TacticsAvail[enc]</td>";
		echo "<td width=\"30\">$TacticsAvail[spc]</td>";
		echo "<td width=\"30\" id=".$t_id."_needlv>$TacticsAvail[needlv]</td>";
		echo "<td width=\"80\" id=".$t_id."_price>$TacticsAvail[price]</td>";
		if (!$LrntTips) echo "</span>";
		echo "</tr>";
		$TacticsAvail=$LrntTips=$LrntTpClr=false;
	}

	echo "</form></table>";
	echo "<p style=\"font-size: 10pt\" align=center>請點擊欲學習的戰術。";
	if($TacticsOptions != ''){
		echo "<form action=tacticslearn.php?action=main method=post name=alternate target=$SecTarget>";
		echo "<input type=hidden value='proclearn' name=actionb>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "另外亦可從這個選單挑選:";
		echo "<select name=learndesired>";
		echo $TacticsOptions;
		echo "</select>";
		echo "<input type=submit value=學習 onClick=\"return cmLearnAlt(";
		echo	"eval(alternate.learndesired.value+'_name.innerHTML'),",
			"eval('parseInt('+ alternate.learndesired.value + '_price.innerHTML)'),",
			"alternate.learndesired.value,",
			"eval('parseInt('+ alternate.learndesired.value + '_needlv.innerHTML)')",
			");\">";
		echo "</form>";
	}
	echo "</p>";
	
	if (!$CancelFlag){
		$Tactics['price'] = (isset($Tactics['price'])) ? $Tactics['price'] : 0;
		$Tactics['id'] = (isset($Tactics['id'])) ? $Tactics['id'] : 0;
		$Gen['cash'] -= $Tactics['price'];
		$Game['tactics'] .= "\n$Tactics[id]";
		$Game['tactics'] = explode("\n",$Game['tactics']);
		$i = 0;
		foreach($Game['tactics'] as $t){
			if (!$t) unset($Game['tactics'][$i]);
			else $Game['tactics'][$i] = trim($t);
			$i++;
		}
		sort($Game['tactics']);
		$Game['tactics'] = implode("\n",$Game['tactics']);
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `tactics` = '$Game[tactics]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
		unset($sql,$Tactics,$TactMessage,$i,$t);
	}
unset ($sql,$query,$Gen,$Game);
}
else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>