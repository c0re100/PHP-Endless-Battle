<?php
//-------------------------//-------------------------//-------------------------//
//----------------------------   Tactfactory System   ---------------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//

$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
$UsrWepB = explode('<!>',$Game['wepb']);
$UsrWepB[2] = (isset($UsrWepB[2])) ? $UsrWepB[2]: 0;
$UsrWepC = explode('<!>',$Game['wepc']);
$UsrWepC[2] = (isset($UsrWepC[2])) ? $UsrWepC[2]: 0;

include('includes/tactfactory.inc.php');
include('plugins/mining/mining.config.php');

unset($IncThread);

$TargetPut = 0;

//Set DataTable
$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` WHERE username='". $Pl_Value['USERNAME'] ."'");
$query_ttf = mysql_query($sql);$defineuserc = 0;
$defineuserc = mysql_num_rows($query_ttf);

if ($defineuserc == 0){
	$sqldftf = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` (username,time) VALUES('$Pl_Value[USERNAME]','$CFU_Time')");
	mysql_query($sqldftf) or die ('<br><center>未能建立兵器製造工場資料<br>原因:' . mysql_error() . '<br>');
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` WHERE username='". $Pl_Value['USERNAME'] ."'");
	$query_ttf = mysql_query($sql) or die ('<br><center>未能取得兵器製造工場資料<br>原因:' . mysql_error() . '<br>');
}

global $TactFactory;
$TactFactory = mysql_fetch_array($query_ttf);

if (($CFU_Time - $TactFactory['time']) < 1 && $defineuserc){
	echo "你實在按的太快了。請於兩秒後再按。<br>多謝合作！";
	postFooter();
	exit;
}

//Weapon Casting GUI
if ($mode=='main' && $actionb=='none'){
	echo "兵器製造工場<Hr>";
	echo "<form action=tactfactory.php?action=main method=post name=mainform target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	//Start Table -- User's Information
	
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-size: 12pt; border-collapse: collapse\" bordercolor=\"#111111\" width=\"400\" id=\"AutoNumber1\">";
	echo "<tr><td width=400 colspan=2>$Game[gamename] 的裝備</td></tr>";
	printPutOption($UsrWepB,'b');
	printPutOption($UsrWepC,'c');
	echo "</table>";
	
	//End Table -- User's Information

	echo "<hr align=center width=80%>";

	//Start Table -- Factory's Information
	$checkPresence = false;
	for($a = 1;$a <= 20;$a++){
		$c = 'm'.$a;
		if (isset($TactFactory[$c])){
			if ($TactFactory[$c]) {
				$checkPresence = true;
				break;
			}
		}
	}

	if($checkPresence){
		// JavaScripts
		echo "<script language=\"Javascript\">function CfmCast(){if (confirm('真的要開始合成工序嗎？\\n一但失敗了，所有原料就會消失！\\n已考慮清楚嗎？')==true){";
		echo "mainform.action='tactfactory.php?action=cast';mainform.actionb.value='start';mainform.submit();}";
		echo "else {return false;}";
		echo "}</script>";

		// 合成原料庫 Table
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"700\">";
		echo "<tr><td width=700 colspan=6 align=center>武裝合成庫</td></tr>";
		for($i = 1; $i <= 10; $i++){
			$ii = $i + 10;
			echo '<tr><td width=40 align=right>'.$i.'號:&nbsp;</td>';
			printBinDetails($i);
			echo '<td width=40 align=right>'.$ii.'號:&nbsp;</td>';
			printBinDetails($ii);
			echo "</tr>";
		}
		// Raw Materials
		echo "<tr><td colspan=6 align=center><b>加入原料</b>: &nbsp;";
		$pFormatStr = '%s: <input type=text maxlength=3 name="raw[%d]" value=0 style="height: 14pt; width: 30px; text-align: center; '.$BStyleA.'" onClick="this.value=\'\'" onChange="this.value=parseInt(this.value)"> &nbsp; &nbsp;';
		$pFormatStrB = '%s: <input type=text maxlength=3 name="rawCur[%d]" disabled value="%d" style="height: 14pt; width: 30px; text-align: center; '.$BStyleA.'" > &nbsp; &nbsp;';
		for($i = 1; $i <= 8; $i++){
			printf($pFormatStr, $product_id_list[$i], $i);
		}
		$rawBins = getMiningStorage($Pl_Value['USERNAME']);
		echo "<br><b>現有原料</b>: &nbsp;";
		for($i = 1; $i <= 8; $i++){
			printf($pFormatStrB, $product_id_list[$i], $i, $rawBins[$i]);
		}
		echo "</td></tr>";
		echo "</table>";

		// Confirmation Button
		echo "<br><center><input type=button name='start' value='開始合成工序' onClick=\"CfmCast()\"></center>";
		echo "<hr align=center width=80%>";
	}

	echo "<p align=center><input type=button value='工場說明' onClick=\"mainform.action='tactfactory.php?action=readme';mainform.submit();\"><input type=button value='專用化改造' onClick=\"mainform.action='tactfactory.php?action=custom';mainform.submit();\"><input type=button value='工程師工會' onClick=\"mainform.action='tactfactory.php?action=guild';mainform.submit();\"><input type=button value='進入武器庫' onClick=\"mainform.action='warehouse.php?action=main';mainform.submit();\"></p>";
	echo "</form>";
}
//Process with Put Weapon
elseif ($mode=='main' && $actionb=='put' && $actionc){

	if (!$Game[$actionc] && $actionc != 'wh'){echo "沒有此裝備存在。";postFooter();exit;}
	if ($actionc == 'wepa'){echo "有此裝備存在，可是我們無法把武器從您機體的手中拆下來。";postFooter();exit;}
	if ($actionc != 'wepb' && $actionc != 'wepc' && $actionc != 'wh'){echo "您想把你自己當作原料嗎？";postFooter();exit;}

	$counter = 1;
	$TargetPut = 0;
	while($counter <= 20){
		$mc='m'.$counter;
		if (!$TactFactory[$mc]){
			$TargetPut = $mc;
			break;
		}
		$counter++;
	}

	if (!$TargetPut){echo "原料庫已滿了，你真的覺得有需要用那麼多原料嗎？";postFooter();exit;};
	unset($counter,$sql);

	if($actionc != 'wh') $TargetPutWep = explode('<!>',$Game[$actionc]);
	else{
		$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
		$query_whr = mysql_query($sql);
		$defineuserc = mysql_num_rows($query_whr);
		if ($defineuserc == 0){
			$sqldfwh = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` (username) VALUES('$Pl_Value[USERNAME]')");
			mysql_query($sqldfwh) or die ('<br><center>未能建立倉庫資料<br>原因:' . mysql_error() . '<br>');
			$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
			$query_whr = mysql_query($sql) or die ('<br><center>未能取得倉庫資料<br>原因:' . mysql_error() . '<br>');
		}elseif ($defineuserc > 1){echo "用戶名稱出現問題，請聯絡管理員。";exit;}
		$Warehouse = mysql_fetch_row($query_whr);
		
		if ($getwep == 'none'){echo '請指定要置放的裝備。';postFooter();exit;}
		else {
			$WChacheArrays = explode("\n",$Warehouse[1]);
			sort($WChacheArrays);
			$Warehouse[1] = implode("\n",$WChacheArrays);
			$Warehouse[1] = trim($Warehouse[1]);
	
			$GetWarehseWeps = explode("\n",$Warehouse[1]);
			$TargetPutWep = explode('<!>',$GetWarehseWeps[$getwep]);
	
			unset($GetWarehseWeps[$getwep]);
			sort($GetWarehseWeps);
	
			$Warehouse[1] = implode("\n",$GetWarehseWeps);
			$Warehouse[1] = trim($Warehouse[1]);
		}
	}

	$TargetPutWep[2]= (isset($TargetPutWep[2])) ? $TargetPutWep[2]: 0;
	if ($TargetPutWep[2]){echo "進行過專用化改造的裝備無法成為材料。";postFooter();exit;}
	if ($TargetPutWep[1] < $RepairEqCondMax){echo "此裝備狀態太差, 無法成為材料。";postFooter();exit;}
	
	if($actionc != 'wh'){
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$actionc` = '0<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);unset($sql);
	}
	else{
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` SET `warehouse` = '$Warehouse[1]', `timelast` = '$CFU_Time' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
	}

	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` SET `time` = '$CFU_Time', `".$mc."` = '$TargetPutWep[0]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql) or die(mysql_error());unset($sql);
	
	echo "<form action=tactfactory.php?action=main method=post name=freect target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">置放完成了！<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\">";
	echo "<input type=button value=\"回到工場\" onClick=\"freect.submit()\"><input type=button value='進入武器庫' onClick=\"freect.action='warehouse.php?action=main';freect.submit();\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";	
}
//Process with View Blueprint
elseif ($mode=='main' && $actionb=='view' && $actionc){

	if ($actionc == 'wepa'){echo "藍圖位置出錯。";postFooter();exit;}
	if ($actionc != 'wepb' && $actionc != 'wepc' && $actionc != 'wh'){echo "藍圖位置出錯。";postFooter();exit;}
	if (!$Game[$actionc] && $actionc != 'wh'){echo "沒有此裝備存在。";postFooter();exit;}

	if($actionc != 'wh') $TargetView = explode('<!>',$Game[$actionc]);
	else{
		$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
		$query_whr = mysql_query($sql);
		if (mysql_num_rows($query_whr) != 1){echo "用戶名稱出現問題，請聯絡管理員。";exit;}

		$Warehouse = mysql_fetch_row($query_whr);
		
		if ($getwep == 'none'){echo '請指定要檢查的藍圖。';postFooter();exit;}
		else {
			$WChacheArrays = explode("\n",$Warehouse[1]);
			sort($WChacheArrays);
			$Warehouse[1] = implode("\n",$WChacheArrays);
			$Warehouse[1] = trim($Warehouse[1]);
			$GetWarehseWeps = explode("\n",$Warehouse[1]);
			$TargetView = explode('<!>',$GetWarehseWeps[$getwep]);
		}
	}

	$sql = ("SELECT `directions`,
	`m1` ,`m2` ,`m3` ,`m4` ,`m5` ,`m6` ,`m7` ,`m8` ,`m9` ,`m10` ,
	`m11` , `m12` ,`m13` ,`m14` ,`m15` ,`m16` ,`m17` ,`m18` ,`m19` ,`m20` ,
	`raw_materials` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` WHERE `blueprint` = '$TargetView[0]'");
	$query = mysql_query($sql);

	if (mysql_num_rows($query) != 1){echo "<br><br><p align=center style='font-size: 14pt' >找不到目標藍圖。<br>請確認該物品是否為「設計藍圖」。";}
	else{
		$Directions = mysql_fetch_row($query);
		echo "<table><tr><td><font color=orange>對話</font></td></tr>";
		echo "<tr><td>". str_replace('\"','"',$Directions[0]) ."</td></tr>";
		echo "<tr><td style='text-align: center;'>";
		printBPTable($Directions, $product_id_list);
		echo "</td></tr>";
		echo "<tr><td><font color=orange>請你記低下這些對話</font></td></tr></table>";
	}
	
	echo "<form action=tactfactory.php?action=main method=post name=freect target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\">";
	echo "<input type=button value=\"回到工場\" onClick=\"freect.submit()\"><input type=button value='進入武器庫' onClick=\"freect.action='warehouse.php?action=main';freect.submit();\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";	
}

//Process with Reclaim Weapon
elseif ($mode=='main' && $actionb=='reclaim' && $actionc){
	if (!$TactFactory[$actionc]){echo "沒有此裝備存在。";postFooter();exit;}
	if (!$UsrWepB[0]){$TargetRec = 'wepb';}
	elseif (!$UsrWepC[0]){$TargetRec = 'wepc';}
	else{echo "沒空位裝備。";postFooter();exit;}
	unset($sql);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$TargetRec` = '".$TactFactory[$actionc]."<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);unset($sql);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` SET `time` = '$CFU_Time', `".$actionc."` = '' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql) or die(mysql_error());unset($sql);
	echo "<form action=tactfactory.php?action=main method=post name=freect target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">回收完成了！<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"繼續\" onClick=\"freect.submit()\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";	
}//End Reclaim and Put

//Start Cast
elseif($mode == 'cast' && $actionb == 'start' && $actionc=='none'){
	if(isset($ChosenTact)){echo "你想幹什麼？";postFooter();exit;}
	if (!$UsrWepB[0]){$TargetGrant = 'wepb';}
	elseif (!$UsrWepC[0]){$TargetGrant = 'wepc';}
	else{echo "沒空位裝備。";postFooter();exit;}
	
	$raw[0] = 0;
	$Storage = array();
	for($i = 1; $i <= 8; $i++){
		$raw[$i] = intval($raw[$i]);
		if($raw[$i] < 0) $raw[$i] = 0;
		$raw[0] += $raw[$i];
	}
	
	$j = 0;
	$sqlStorage = array();
	$SQL_Format = 'UPDATE `'.$GLOBALS['DBPrefix'].'phpeb_mining_storage` SET `quantity` = %d WHERE `m_store_user` = \''.$Game['username'].'\' AND `item` = %d ;';
	if($raw[0] > 0){
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
	
	$CastResult='';
	
	unset($sql,$query,$counter,$StopFlag,$mc);
	$sql = "SELECT `wep_id`, `m1`, `m2`, `m3`, `m4`, `m5`, `m6`, `m7`, `m8`, `m9`, `m10`, `m11`, `m12`, `m13`, `m14`, `m15`, `m16`, `m17`, `m18`, `m19`, `m20`, `raw_materials` ";
	$sql .= " FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` ";
	$sql .= " WHERE `m1` = '$TactFactory[m1]' ORDER BY `grade` DESC;";	// Refine results
	$query = mysql_query($sql) or die ('<br><center>未能取得兵器製造工場資料<br>原因:' . mysql_error() . '<br>');
	$nosrow = mysql_num_rows($query);
	unset($counter,$counterb,$counterc,$mb,$ChosenTact);

	// Analyse ID of attempted tact
	$ChosenTact = 0;
	$RawReq = '';
	$counter=1;
	while($Tacticals = mysql_fetch_array($query)){
		//Calculate number of bins required to analyse
		$counterb = 1;
		while($counterb <= 20 && !$StopFlagB){
			$mb='m'.$counterb;
			if (isset($Tacticals[$mb])){
				if($Tacticals[$mb] && $Tacticals[$mb] != 'NULL'){
					$counterb++;
					continue;
				}
			}
			break;
		}
		//Number of Bins actually needed calculated
		// `$counterb` = Actual Number of Bins + 1, reflect in for-loop
		$counterc = 1;
		$mc = '';
		$WrongFlag = false;
		for(; $counterc < $counterb; $counterc++){
			$mc='m'.$counterc;
			if ($TactFactory[$mc] != $Tacticals[$mc]){
				$WrongFlag = true;
				break;
			}
		}
		//Analysed right or wrong
		if(!$WrongFlag){
			$ChosenTact = $Tacticals['wep_id'];
			$RawReq = $Tacticals['raw_materials'];
			break;	// Prevent Further Analysis
		}
	}
	//Analysed attempt tact/weapon ID

	//Analyse Sufficiency of Raw Materials
	$RawReqs = getRaw($RawReq);
	if($RawReqs[0] > 0){
		if($raw[0] <= 0){
				$ChosenTact = 0;
		}
		else{
			for($i = 1; $i <= 8; $i++){
				if($raw[$i] < $RawReqs[$i]){
					$ChosenTact = 0;
					break;
				}
			}
		}
	}

	//Grant Chosen Weapon
	if ($ChosenTact){
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$TargetGrant` = '".$ChosenTact."<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql);
		$CastResult = "合成工序順利完成!!<br>已製造出 <font color=blue>".getWeaponName($ChosenTact)."</font> ！";
	}else{
		$CastResult = "製造失敗了。也許你應改改配方和增加原料數量。";
	}

	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` SET `time` = '$CFU_Time', `m1` = '', `m2` = '', `m3` = NULL, `m4` = NULL, `m5` = NULL, `m6` = NULL, `m7` = NULL, `m8` = NULL, `m9` = NULL, `m10` = NULL, `m11` = NULL, `m12` = NULL, `m13` = NULL, `m14` = NULL, `m15` = NULL, `m16` = NULL, `m17` = NULL, `m18` = NULL, `m19` = NULL, `m20` = NULL WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1"); 
	mysql_query($sql) or die(mysql_error());unset($sql);

	if(count($sqlStorage) > 0){
		foreach($sqlStorage As $sql) mysql_query($sql);
	}

	echo "<form action=tactfactory.php?action=main method=post name=freect target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">$CastResult<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"繼續\" onClick=\"freect.submit()\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";	
}
elseif($mode == 'readme' && $actionb == 'none' && $actionc=='none'){
echo "兵器製造工場<hr>";
	if($RepairEqCondMax == 0) $DisMinXp = '±0%';
	else $DisMinXp = ($RepairEqCondMax > 0) ? '+'.($RepairEqCondMax/100) : ($RepairEqCondMax/100);
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=center width=400><b style=\"font-size: 10pt;\">兵器製造工場說明</b></td></tr>";
	echo "<tr><td align=left>";
	echo "<b>兵器製造工場</b><Br>　- 可以不同的原料、武器、裝備, 合成新的武器和裝備<br>　- 合成武器時, 必須衣照指示(設計藍圖/合成法)進行, 否則合成會失敗<br>　- 失敗的話, 會失去所有原料和任何在熔解爐內的物品<br>　- 任何置放在熔解爐的物品, 都會失去所有狀態值<br>　- 裝備狀態不能太差, 必須為 $DisMinXp 以上, 否則無法成為材料。<br>";
	echo "<b>專用化改造工場</b><Br>　- 專用化能夠讓你改造武器、提升威力和效率。<br>　- 當武器符合一定的條件時，可以進行專用化。<br>　- 條件如下:<br>　 　 - 武器狀態值達 +250% <br>　 　 - 武器曾沒有進行專用化 <br>　 　 - 專用化完成後，武器經驗歸零。<br>　- 失敗的話, 會失去所有原料和進行專用化的武器<br>　- 任何置放在熔解爐的物品, 都會失去所有經驗<br>";
	echo "<b>工程師工會</b><Br>　- 可以在這購買合成藍圖<br>　- 每次購買後也會得到某武裝的<B>設計藍圖</B>一幅<br>";
	echo "</tr></td></table>";
}
elseif($mode == 'guild' && $actionb == 'none' && $actionc=='none'){
	echo "兵器製造工場 -- 工程師工會<hr>";
	echo "
	<table>
	<tr><td>使用說明</td></tr>
	<tr>
	<td style=\"font-size: 10pt\">
	這裡是工程師工會，你可以在這購買合成藍圖，會有一至三個位工程師回答你的，但只有一個人說的話是完正確的。
	<br>請注意, 武裝合成庫內的材料和原料, 即使放多了, 也不會影響合成結果。
	<br>可是, 原料數量不足, 或是武器、裝備的次序錯了，卻會合成失敗、功\虧一簣！
	<br>合成武器有分等級，分別是由一級至十級。十級為最高級。
	<br>情報價錢<font color=red>隨級數上升</font>。公式為: 二的級別次方乘".($TFDCostCons)." (即 2<sup>n</sup> * ".($TFDCostCons)." )
	</td></tr>
	<tr><td>
	<form action=tactfactory.php?action=guild method=post name=mainform>";
	echo "<input type=hidden value='buy' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "購買: 
	<script langauge=\"Javascript\">
	function changeprice(){
		document.getElementById('cost').innerHTML = (Math.pow(2,document.mainform.grade.value))*".($TFDCostCons).";
		if (cost.innerHTML > $Gen[cash]){document.getElementById('cost').style.color='Red';}
		else {document.getElementById('cost').style.color='DodgerBlue';}
	}
	function ChkBuy(){
	if (document.getElementById('cost').innerHTML > $Gen[cash]){alert('金錢不足！');return false;}
	else {if (confirm('確定要購買嗎？')==true){return true;}else{return false;}}
	}</script>
	<select name='grade' onchange=\"changeprice()\">
	<option value=1 selected>一級</option>
	<option value=2>二級</option>
	<!--
	<option value=3>三級</option>
	<option value=4>四級</option>
	<option value=5>五級</option>
	<option value=6>六級</option>
	<option value=7>七級</option>
	<option value=8>八級</option>
	<option value=9>九級</option>
	<option value=10>十級</option>
	-->
	</select>合成法。<br>
	所需金額: <span id=cost style='color: DodgerBlue;'>".intval(2*$TFDCostCons)."</span><br>
	<input type=submit value=購買 OnClick=\"return ChkBuy()\">
	</td></tr></form>";
	echo "<tr><td><form action=tactfactory.php?action=main method=post name=freect target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='none' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=left style=\"font-size: 16pt\">$CastResult<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=button value=\"繼續\" onClick=\"freect.submit()\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form></tr></td>";
	echo "</table>";
}
elseif ($mode == 'guild' && $actionb == 'buy' && $actionc=='none'){
	$grade = intval($grade);
	if ($grade < 0 || $grade > 10){echo "級別出錯!!<br>";PostFooter();exit;}
	$TrueCost = intval(pow(2,$grade) * $TFDCostCons);
	if ( $TrueCost > $Gen['cash']){echo "金錢不足!!<br>";PostFooter();exit;}
	else {$Gen['cash'] -= $TrueCost;}

	if (!$UsrWepB[0]){$TargetGrant = 'wepb';}
	elseif (!$UsrWepC[0]){$TargetGrant = 'wepc';}
	else{echo "沒空位放置合成設計藍圖, 請先空出備用一或二再試。";postFooter();exit;}

	unset($sql);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);
	
	unset($sql,$query,$counter,$TheTString,$TheBpString);

	$sql = ("SELECT `directions`,
	`m1` ,`m2` ,`m3` ,`m4` ,`m5` ,`m6` ,`m7` ,`m8` ,`m9` ,`m10` ,
	`m11` , `m12` ,`m13` ,`m14` ,`m15` ,`m16` ,`m17` ,`m18` ,`m19` ,`m20` ,
	`raw_materials`, `blueprint` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` WHERE `grade` = '$grade'");
	$query = mysql_query($sql);
	
	$TactEntries = array();
	
	$i = 0;
	while($TactEntries[$i] = mysql_fetch_array($query)){
		$i++;
	}
	$RandSelect = mt_rand(0, ($i - 1));
	$Result = $TactEntries[$RandSelect];

	echo "<table><tr><td><font color=orange>對話</font></td></tr>";
	echo "<tr><td>". str_replace('\"','"',$Result['directions']) ."</td></tr>";
	echo "<tr><td style='text-align: center;' align=center>";
	printBPTable($Result, $product_id_list);
	echo "</td></tr><tr><td><font color=orange>請你記低下這些對話</font></td></tr>";
	echo "</table>";
	
	unset($sql);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$TargetGrant` = '". $Result['blueprint'] ."<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);
	unset($sql);

}
elseif($mode == 'custom'){
$IncThread = "tcust_200509241855";
include('tact_custom.php');
}
else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>