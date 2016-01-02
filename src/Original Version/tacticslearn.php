<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
//Tactics Learning center GUI
if ($mode=='main'){
	unset($CancelFlag,$TactMessage);
	echo "戰術學院<hr>";
	if ($actionb == 'proclearn'){
		$Tactics = GetTactics($learndesired);
		if ($Tactics['price'] > $Gen['cash']){$TactMessage = '金錢不足！';$CancelFlag= '1';}
		if ($Tactics['needlv'] > $Game['level']){$TactMessage .= '等級不足！';$CancelFlag= '1';}
		if(ereg("($Tactics[id])+",$Game['tactics'])){$TactMessage .= "你早就學會了 $Tactics[name] 。";$CancelFlag= '1';}
		if (!$CancelFlag)
		$TactMessage = "成功\以 $Tactics[price] 元學習了 $Tactics[name] 。";
		}
	if (!$TactMessage)$TactMessage = '觀迎來到本學院！<br>請點擊欲學習的戰術。';
	echo "$TactMessage<hr>";
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\"  style=\"border-collapse: collapse;font-size: 9pt;\" bordercolor=\"#FFFFFF\" width=\"740\">";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]></form>";
	echo "<form action=tacticslearn.php?action=main method=post name=mainform target=Beta>";
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
	echo "if (confirm('學習戰術「'+name+'」需要 '+cost+' 元。\\n確定要學習嗎？') == true)";
	echo "{mainform.actionb.value='proclearn';mainform.learndesired.value=id;mainform.submit();frmreturn.submit();return true}";
	echo "else{return false}}}</script>";
while ($TacticsAvail = mysql_fetch_array($query)){
$c+=1;
$TacticsAvail['spinfo'] = ReturnSpecs($TacticsAvail['spec']);
if (ereg('('.$TacticsAvail['id'].')+',$Game['tactics'])){
$LrntTpClr = "3C3CFF";
$LrntTips = "style=\"color: $LrntTpClr\"'";}
echo "<tr align=center $LrntTips class=buymslist onMouseover=\"this.style.color='yellow';\" onMouseout=\"this.style.color='$LrntTpClr'\">";
if (!$LrntTips)
echo "<span onClick=\"mainform.learndesired.value='$TacticsAvail[id]';cmLearn('$TacticsAvail[name]','$TacticsAvail[price]','$TacticsAvail[id]','$TacticsAvail[needlv]')\">";
echo "<td width=\"20\">$c</td>";
echo "<td width=\"100\">$TacticsAvail[name]</td>";
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
echo "<td width=\"30\">$TacticsAvail[needlv]</td>";
echo "<td width=\"80\">$TacticsAvail[price]</td>";
if (!$LrntTips)
echo "</span>";
echo "</tr>";
unset($TacticsAvail,$LrntTips,$LrntTpClr);
	}

	echo "</form></table>";
	if (!$CancelFlag){
		$Gen['cash'] -= $Tactics['price'];
		$Game['tactics'] .= "\n$Tactics[id]";
		$Game['tactics'] = explode("\n",$Game['tactics']);
		sort($Game['tactics']);
		$Game['tactics'] = implode("\n",$Game['tactics']);
		$Game['tactics'] = trim($Game['tactics']);		
		
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `tactics` = '$Game[tactics]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
		unset($sql,$Tactics,$TactMessage);
	}
unset ($sql,$query,$Gen,$Game);
}
else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>