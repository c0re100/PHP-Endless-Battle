<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
if (!isset($Game_Scrn_Type)) $Game_Scrn_Type = 1;
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
if ($Game['organization'])
$Pl_Org = ReturnOrg("$Game[organization]");
else $Pl_Org = false;
//Special Commands GUI
if ($mode=='Start'){
	echo "<font style=\"font-size: 12pt\">成立組織</font>";
	printTHR();
	if ($actionb == 'A'){
	echo "<form action=organization.php?action=Start method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmStartOrg(){";
	echo "if ($OrganizingCost > $Gen[cash]){alert('金錢不足。');return false;}";
	echo "else if (mainform.org_name.value == ''){alert('請先輸入組織名稱。');return false;}";
	echo "else {if (confirm('成立組織需要 ". number_format($OrganizingCost) ." 元，確定嗎？')==true){return true;}";
	echo "else {return false;}}";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">成立組織所需資料: </b></td></tr>";
	echo "<tr><td align=left>成立組織需要: ". number_format($OrganizingCost) ." 元<br>";
	echo "組織名稱: <input type=text name=org_name maxlength=32 size=27><br>(注意不能與現有國家名稱一樣)<br>";
	echo "代表顏色: <br><center>";
	$br=$ct_default=0;
	foreach ($MainColors as $TheColor){$br++;$ct_default++;
	echo "<input type=\"radio\" name=\"org_color\" value=#".$TheColor;
	if ($ct_default==1) echo " checked";
	echo "><font color=#".$TheColor.">◆</font> &nbsp;&nbsp; ";
	if ($br==6){echo"<br>";$br=0;}	}
	echo "<input type=submit value=\"確定成立組織\" onClick=\"return cfmStartOrg();\">";
	echo "</tr></td></form></table>";
	}

	if ($actionb == 'B'){
	if ($OrganizingCost > $Gen['cash']){echo "金錢不足。";postFooter();exit;}
	if ($Gen['fame'] < $OrganizingFame && $Gen['fame'] > $OrganizingNotor){echo "名聲不足。";postFooter();exit;}

	$Gen['cash'] -= $OrganizingCost;
	$Gen['fame'] += 1;
	if( $Game['rank'] < 48000 ) $Game['rank'] = 48000;

	$HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> 創立 <font color=\"$org_color\">$org_name</font> 組織，並歡迎所有人自由加入及退出。";
	WriteHistory($HistoryWrite);
	//Enter Organization Info
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_organization (id, name, color) VALUES('$CFU_Time','$org_name','$org_color')");
	mysql_query($sql) or die ('<br><center>未能完成註冊<br>原因:' . mysql_error() . '<br>');

	$restriction = array("|","`","'","--","\"","\\");
	$org_name = str_replace($restriction,'',$org_name);
	$org_name = preg_replace('/<[^<>]*>/','',$org_name);

	$sql = ("SELECT id FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE name='". $org_name ."'");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	$New_Org = mysql_fetch_row($query);

	//更新 Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '1', `organization` = '$New_Org[0]' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

	//更新 General Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]', `fame` = '$Gen[fame]' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">成立組織完成了！<br>閣下的名聲上升1點。<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}
}
elseif($mode == 'Employ'){
	if ($actionb == 'C'){
		$CancelFlag = '';
		if (!$Employer){echo "你被誰邀請呀？";postFooter();exit;}
		elseif ($Game['rights']=='1'){echo "主席不能被邀請。";postFooter();exit;}
		else {$Og_Org=$Pl_Org;$Pl_Org = ReturnOrg($Employer);}if (!$Og_Org){$Og_Org =  ReturnOrg('0');}
	
		if(strpos($Pl_Org['request_list'],'!'.$Pl_Value['USERNAME'].',') === false){$EmployMsg = "該組織沒有邀請您。";$CancelFlag = '1';}
		else{
			$str = "/(!$Pl_Value[USERNAME], )+/";
			$Pl_Org['request_list'] = preg_replace($str,'',$Pl_Org['request_list']);
		}
	
		//更新 Org Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `request_list` = '$Pl_Org[request_list]' WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');
	
		//更新 General Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `request` = '' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	
		if ($actionc == 'Accept' && !$CancelFlag){
			if($Game['organization'] == 0)	$Game['rank'] += 2000;
			if($Game['rank'] > 100000)	$Game['rank'] = 100000;
			//更新 Game Info
			$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = ".($Game['rank']).", `rights` = '0', `organization` = '$Pl_Org[id]' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
			$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
			$EmployMsg = "成功加入組織！";
			$HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 受邀請加入 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>。";
			WriteHistory($HistoryWrite);
		}
	
		elseif ($actionc == 'Refuse' && !$CancelFlag){
			$EmployMsg = "成功拒絕加入組織。";
			$HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 拒絕了加入 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>的邀請。";
			WriteHistory($HistoryWrite);
		}
	
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn>";
		echo "<p align=center style=\"font-size: 16pt\"><br><br><br>$EmployMsg<input type=submit value=\"返回\" ";
		if($Game_Scrn_Type == 1)
		echo "onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"";
		echo "></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
		postFooter();
		echo "</body>";
		echo "</html>";
		exit;
	}

	//
	// End of Action C
	//

echo "<font style=\"font-size: 12pt\">招募人才</font>";
printTHR();

if ($actionb == 'A'){
		echo "<form action=organization.php?action=Employ method=post name=mainform>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
		echo "<script language=\"Javascript\">";
		echo "function cfmEmploy(){";
		echo "if (mainform.EmployTar.value == ''){alert('請先輸入要招攬的人。');return false;}";
		echo "else {if (confirm('邀請目標加入組織，確定嗎？')==true){return true;}";
		echo "else {return false;}}";
		echo "}</script>";
	
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">招募人才: </b></td></tr>";
	
		unset($sql,$query,$AvailPersons);
		$sql = ("SELECT `username`,`gamename`,`organization` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$Pl_Value['USERNAME']."' AND `organization` != '$Game[organization]' AND !`rights` OR !`organization` ORDER BY `organization` ASC");
		$query = mysql_query($sql) or die(mysql_error());
		$AvailPersons = mysql_fetch_array($query);
		$EmployOpt = '';
		do{
		$TarOrg = ReturnOrg($AvailPersons['organization']);
		$EmployOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename] ($TarOrg[name])";
		unset($AvailPersons,$TarOrg);
		}
		while ($AvailPersons = mysql_fetch_array($query));
	
		if ($EmployOpt){
			echo "<tr><td align=left>向 <select name=EmployTar>$EmployOpt</select><br><input type=submit value=\"邀請\" onClick=\"return cfmEmploy();\"> 發出邀請信。</td></tr>";
		}
	
	
		if(strpos($Pl_Org['request_list'],'!'.$Pl_Value['USERNAME'].',') !== false){
			$str = "/(!$Pl_Value[USERNAME], )+/";
			$Pl_Org['request_list'] = preg_replace($str,'',$Pl_Org['request_list']);
		}
	
		if ($Pl_Org['request_list']){
		echo "<tr><td align=left>未得到回覆的邀請信: <br>";
	
		$Pl_Org['request_list'] = preg_replace('/!| /','',$Pl_Org['request_list']);
		$List_of_Letters = explode(',',$Pl_Org['request_list']);
		unset($TargetName,$TarInfo);
		foreach($List_of_Letters as $TargetName){
		if ($TargetName){
		$sqle = ("SELECT `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`gamename`, `".$GLOBALS['DBPrefix']."phpeb_user_organization`.`name`, `".$GLOBALS['DBPrefix']."phpeb_user_organization`.`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info`, `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`username`='". $TargetName ."' AND `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`organization` = `".$GLOBALS['DBPrefix']."phpeb_user_organization`.`id`");
		$querye = mysql_query($sqle) or die ('無法取得資訊, 原因:' . mysql_error() . '<br>');
		$TarInfo = mysql_fetch_array($querye);
		echo "<font color=\"$TarInfo[color]\">$TarInfo[name] 的 $TarInfo[gamename]</font><br>";}
		}
		echo "</td></tr>";
		}
		echo "</form></table>";
	}

//
// End of Action A
//

	if ($actionb == 'B'){
	
		if (!$EmployTar || $EmployTar == $Pl_Value['USERNAME']){echo "你要招攬誰呀？";postFooter();exit;}
	
		$Pl_Org = ReturnOrg($Game['organization']);
	
		$Pl_Org['request_list'] .= '!'.$EmployTar.', ';
	
		//更新 Org Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `request_list` = '$Pl_Org[request_list]' WHERE `id` = '".$Game['organization']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	
		$requesttx = "$Pl_Org[name] 的 $Game[gamename] 向您發出加入組織的邀請信。<br>你要加入組織嗎？<br>";
		$requesttx .= "<input type=hidden name=Employer value=\'$Pl_Org[id]\'>";
	
		//更新 General Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `request` = '$requesttx' WHERE `username` = '".$EmployTar."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">組織邀請信已發出。<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}

//
// End of Action B
//
}//End of Employ
elseif ($mode == 'LeaveOrg'){
	if (!$Game['organization'] || $Game['rights']){echo "以您的身份不能脫離組織。";postFooter();exit;}
	if ($actionb != 'A' && $actionb != 'B' && $actionb != 'C') {echo "未定義動作！<br>";exit;}
	if ($actionb == 'A'){
		if ($Pl_Org['license'] == 1 || $Pl_Org['license'] == 3)
			{echo "您的組織不容許你私自脫離，若真的想離開就請您逃亡吧。";postFooter();exit;}
		$Game['rank'] -= 4000;
	}
	else {
		if ($Pl_Org['license'] != 1 && $Pl_Org['license'] != 3)
			{echo "您無需逃亡。";postFooter();exit;}
		if ($actionb == 'C') $Gen['fame'] -= 10;
		$Gen['fame'] = floor($Gen['fame']*0.9);
		$Game['rank'] -= 12000;
	}
	if( $Game['rank'] < 0 ) $Game['rank'] = 0;
	//更新 Gen Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `fame` = '$Gen[fame]' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');

	if (abs($Gen['fame']) >= 100){
	$HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> 脫離 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>。";
	WriteHistory($HistoryWrite);}

	//更新 Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '0' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">已脫離組織。<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}
//End of LeaveOrg
elseif ($mode == 'LeavePlace'){
	echo "<font style=\"font-size: 12pt\">退位</font>";
	printTHR();
	if (!$Game['organization'] || !$Game['rights']){echo "以您的身份不能退位。";postFooter();exit;}

	if ($Game['rights'] == '1'){$RightsTitle = $RightsClass['Major'];$AllowWho = "`rights` != '1'";}
	elseif ($Game['rights']){$RightsTitle = $RightsClass['Leader'];$AllowWho = "!`rights`";}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=LeavePlace method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmLeavePlace(){";
	echo "if (mainform.GiveTar.value == ''){alert('請先輸入要讓給的人。');return false;}";
	echo "else {if (confirm('退位給目標人物，確定嗎？')==true){return true;}";
	echo "else {return false;}}";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">退位讓賢: </b></td></tr>";

	unset($sql,$query,$AvailPersons);
	$sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$Pl_Value['USERNAME']."'  AND `organization` = '$Game[organization]' AND $AllowWho AND `rank` > 72000 ORDER BY `rank` DESC");
	$query = mysql_query($sql) or die(mysql_error());
	$GiveTarOpt = '';
	while ($AvailPersons = mysql_fetch_array($query))
		$GiveTarOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename]";
	unset($AvailPersons);

	echo "<tr><td align=left>您的權力: $RightsTitle <br>";

	if ($GiveTarOpt)
		echo "可退位給的人:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"退位\" onClick=\"return cfmLeavePlace();\">";
	else 	echo "沒有適合的人選。<br>接位的人必須有一定的軍階。";
	echo "</td></tr></form></table>";
	}// Action A End

	elseif ($actionb == 'B'){

	if (!$GiveTar){echo "請先指定目標。";postFooter();exit;}

	$sqlgame = ("SELECT `gamename`,`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info`,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`username`='". $GiveTar ."'");
	$query_game = mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
	$GiveTarOpt = mysql_fetch_array($query_game);

	$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 把 $RightsTitle 之權力讓給 <font color=\"$GiveTarOpt[color]\">$GiveTarOpt[gamename]</font> 。";
	WriteHistory($HistoryWrite);

	//更新 Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '".$Game['rights']."', `organization` = '$Game[organization]' WHERE `username` = '".$GiveTar."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

	//更新 Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '0', `organization` = '$Game[organization]' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">退位完成了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

	}// Action B End


	else {echo "未定義動作！";}
}//End of LeavePlace
elseif ($mode == 'Vice'){

	if ($Game['rights'] != '1'){echo "你沒有權力任命副主席。";postFooter();exit;}
	if ($Game['rights'] == '1'){$RightsTitle = $RightsClass['Major'];}
	elseif ($Game['rights']){$RightsTitle = $RightsClass['Leader'];}

	if ($actionb == 'A'){
		echo "<form action=organization.php?action=Vice method=post name=mainform>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
		echo "<script language=\"Javascript\">";
		echo "function cfmVice(){";
		echo "if (mainform.GiveTar.value == ''){alert('請先輸入要任命為副主席的人。');return false;}";
		echo "else {if (confirm('任命目標人物，確定嗎？')==true){return true;}";
		echo "else {return false;}}";
		echo "}</script>";
	
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">任命副主席: </b></td></tr>";
	
		unset($sql,$query,$AvailPersons);
		$sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$Pl_Value['USERNAME']."'  AND `organization` = '$Game[organization]' AND `rank` > 60000 ORDER BY `rank` DESC");
		$query = mysql_query($sql) or die(mysql_error());
		$GiveTarOpt = '';
		while ($AvailPersons = mysql_fetch_array($query))
			$GiveTarOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename]";
		unset($AvailPersons);
		echo "<tr><td align=left>您的權力: $RightsTitle <br>";
	
		if ($GiveTarOpt)
			echo "任命為副主席的人:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"任命\" onClick=\"return cfmVice();\">";
		else 	echo "沒有可以被任命的人, 副主席必須有一定的功績、軍階。";
		echo "</td></tr></form></table>";
	}// Action A End

	elseif ($actionb == 'B'){

	if (!$GiveTar){echo "請先指定目標。";postFooter();exit;}

	$sqlgame = ("SELECT gen.username AS name, `color`, `gamename`, `rights` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `game`, `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `gen` WHERE gen.username = game.username AND organization = $Game[organization] AND (gen.username = '". $GiveTar ."' OR `rights` = 2) LIMIT 2;");
	$qgame = mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
	$TarQnum = mysql_num_rows($qgame);
	if($TarQnum > 1){
		$mem[0] = mysql_fetch_array($qgame);
		$mem[1] = mysql_fetch_array($qgame);
		if($mem[0]['rights'] == '2') {
			$TarQ = $mem[1];
			$TarXQ = $mem[0];
		}else{
			$TarQ = $mem[0];
			$TarXQ = $mem[1];
		}
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 宣佈, <font color=\"$TarQ[color]\">$TarQ[gamename]</font> 將接任 <font color=\"$TarXQ[color]\">$TarXQ[gamename]</font> 為 ".$RightsClass['Leader']." 了。";
		//更新 Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '2' WHERE `username` = '".$TarQ['name']."' LIMIT 1");
		$query = mysql_query($sql);
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '0' WHERE `username` = '".$TarXQ['name']."' LIMIT 1");
		$query = mysql_query($sql);
	}
	else {
		$TarQ = mysql_fetch_array($qgame);
		$TarXQ = false;
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 把組織內的 <font color=\"$TarQ[color]\">$TarQ[gamename]</font> 任命為 ".$RightsClass['Leader']." 了。";
		//更新 Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '2' WHERE `username` = '".$GiveTar."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	}

	WriteHistory($HistoryWrite);

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">任命完成了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

	}// Action B End


	else {echo "未定義動作！";}
}//End of Vice Presidency
elseif ($mode == 'Break'){
if ($actionb = 'A'){
	if (!$Game['organization'] && $Game['rights'] != '1'){echo "以您的身份不能解散組織。";postFooter();exit;}

	$sql = ("SELECT count(username) FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '".$Game['organization']."'");
	$query = mysql_query($sql);
	$result = mysql_fetch_row($query);
	if($result[0] > 1) {echo "請先解雇所以組織人員。";postFooter();exit;}

	$HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> 把 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 解散了。";
	WriteHistory($HistoryWrite);
	
	$Game['rank'] -= 48000;
	if($Game['rank'] < 0) $Game['rank'] = 0;

	//更新 Game Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '0' WHERE `username` = '".$Pl_Value['USERNAME']."'");
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
	//更新 Map Info
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `occupied` = '0' WHERE `occupied` = '".$Game['organization']."'");
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
	//消除 Org Info
	$sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE id='". $Game['organization'] ."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">組織已被解散。<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}// Action A End
}// End of Break Organization

elseif ($mode == 'Dismiss'){
	echo "<font style=\"font-size: 12pt\">解雇</font>";
	printTHR();
	if (!$Game['organization'] || !$Game['rights']){echo "以您的身份不能解雇其他人。";postFooter();exit;}

	if ($Game['rights'] == '1'){$RightsTitle = $RightsClass['Major'];$AllowWho = "`rights` != '1'";}
	elseif ($Game['rights']){$RightsTitle = $RightsClass['Leader'];$AllowWho = "!`rights`";}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=Dismiss method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmDismiss(){";
	echo "if (mainform.GiveTar.value == ''){alert('請先輸入要解雇的人。');return false;}";
	echo "else {if (confirm('解雇目標人物，確定嗎？')==true){return true;}";
	echo "else {return false;}}";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">解雇人員: </b></td></tr>";

	unset($sql,$query,$AvailPersons);
	$sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$Pl_Value['USERNAME']."'  AND `organization` = '$Game[organization]' AND $AllowWho ORDER BY `rank` DESC");
	$query = mysql_query($sql) or die(mysql_error());
	$GiveTarOpt = '';
	while ($AvailPersons = mysql_fetch_array($query))
		$GiveTarOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename]";
	unset($AvailPersons);
	echo "<tr><td align=left>您的權力: $RightsTitle <br>";

	if ($GiveTarOpt)
		echo "可解雇的人:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"解雇\" onClick=\"return cfmDismiss();\">";
	else 	echo "沒有可以被解雇的人。";
	echo "</td></tr></form></table>";
	}// Action A End

	elseif ($actionb == 'B'){

		if (!$GiveTar){echo "請先指定目標。";postFooter();exit;}
	
		$sqlgame = ("SELECT `gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE username='". $GiveTar ."'");
		$qgame = mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
		$TarQ = mysql_fetch_array($qgame);
	
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 把組織內的 <font color=\"$TarQ[color]\">$TarQ[gamename]</font> 解雇了。";
		WriteHistory($HistoryWrite);
	
		$Game['rank'] -= 2000;
		if($Game['rank'] < 0) $Game['rank'] = 0;
	
		//更新 Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '0' WHERE `username` = '".$GiveTar."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">解雇完成了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";

	}// Action B End


	else {echo "未定義動作！";}
}//End of Dismiss
elseif ($mode == 'JoinOrg'){
	echo "<font style=\"font-size: 12pt\">加入組織</font>";
	printTHR();
	if ($Game['organization']){echo "你已有所屬的組織了。";postFooter();exit;}

	if ($actionb == 'A'){
		echo "<form action=organization.php?action=JoinOrg method=post name=mainform>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
		echo "<script language=\"Javascript\">";
		echo "function cfmJoinOrg(){";
		echo "if (mainform.GiveTar.value == ''){alert('請先輸入要加入的組織。');return false;}";
		echo "else {if (confirm('加入目標組織，確定嗎？')==true){return true;}";
		echo "else {return false;}}";
		echo "}</script>";
	
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">加入組織接受新會員的組織: </b></td></tr>";
	
		unset($sql,$query,$AvailPersons);
		$sql = ("SELECT `id`,`name` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `id` != '0' AND `license` < 2  ORDER BY `id` DESC");
		$query = mysql_query($sql) or die(mysql_error());
		$AvailPersons = mysql_fetch_array($query);
		
		$GiveTarOpt = '';
		do{
		$GiveTarOpt .= "<option value='$AvailPersons[id]'>$AvailPersons[name]";
		unset($AvailPersons);
		}
		while ($AvailPersons = mysql_fetch_array($query));
	
		if ($GiveTarOpt)
		echo "<tr><td align=left>可加入的組織:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"加入\" onClick=\"return cfmJoinOrg();\"></td></tr>";
		else echo "<tr><td align=left>沒有可以被加入的組織。</td></tr>";
		echo "</form></table>";
	}// Action A End

	elseif ($actionb == 'B'){

		if (!$GiveTar){echo "請先指定要加入的組織。";postFooter();exit;}

		$Og_Org = ReturnOrg($Game['organization']);
		$Pl_Org = ReturnOrg($GiveTar);
		if($Pl_Org['license'] >= 2){echo "目標組織不接受新會員。";postFooter();exit;}

		if (abs($Gen['fame']) >= 100){
			$HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 加入 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>。";
			WriteHistory($HistoryWrite);
		}

		$Game['rank'] += 2000;
		if($Game['rank'] > 100000) $Game['rank'] = 100000;

		//更新 Game Info
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '".($Game['rank'])."', `rights` = '0', `organization` = '".$GiveTar."' WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">加入組織完成了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";

	}// Action B End


	else {echo "未定義動作！";}
}//End of JoinOrg
elseif ($mode == 'Settings'){
	echo "<font style=\"font-size: 12pt\">組織設定</font>";
	printTHR();
	if (!$Game['organization'] || $Game['rights'] != '1'){echo "你的權力不足。";postFooter();exit;}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=ModOrg method=post name=mainform>";
	echo "<input type=hidden value='' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmModOrgLi(){";
	echo "if (confirm('修改組織自由度, 確定嗎？')==true){mainform.actionb.value='ModLi';return true;}";
	echo "else {return false;}";
	echo "}</script>";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">設定組織組態: </b></td></tr>";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">組織資金: ".number_format($Pl_Org['funds'])."元</b></td></tr>";
	echo "<tr><td align=left>組織自由度:<br><input type=radio name=\"license\" checked value=\"0\">: 自由加入、退出<br><input type=radio name=\"license\" value=\"1\">: 自由加入，限制退出<br><input type=radio name=\"license\" value=\"2\">: 限制加入，自由退出<br><input type=radio name=\"license\" value=\"3\">: 限制加入、退出<br>";
	echo "<input type=submit value=\"設定\" onClick=\"return cfmModOrgLi();\">";
	echo "</td></tr>";

	if ($Pl_Org['funds'] > 1000000){

	echo "<script language=\"Javascript\">";
	echo "function cfmModOrgC(){";
	echo "if (confirm('以 1,000,000元 修改組織代表色, 確定嗎？')==true){mainform.actionb.value='ModC';return true;}";
	echo "else {return false;}";
	echo "}</script>";

	echo "<tr><td align=left>組織代表色:<br>更變代表色需要使用 1,000,000元 組織資金。<br>";
	$br=$ct_default=0;
	foreach ($MainColors as $TheColor){$br++;$ct_default++;
	echo "<input type=\"radio\" name=\"org_color\" value=#".$TheColor;
	if ($ct_default==1) echo " checked";
	echo "><font color=#".$TheColor.">◆</font> &nbsp;&nbsp; ";
	if ($br==6){echo"<br>";$br=0;}	}
	echo "<input type=submit value=\"設定\" onClick=\"return cfmModOrgC();\">";
	echo "</td></tr>";
	}
	if ($Pl_Org['funds'] > 10000000){
	echo "<script language=\"Javascript\">";
	echo "function cfmModOrgN(){";
	echo "if (confirm('以 10,000,000元 修改組織名稱, 確定嗎？')==true){mainform.actionb.value='ModN';return true;}";
	echo "else {return false;}";
	echo "}</script>";

	echo "<tr><td align=left>組織名稱:<br>更變組織名稱需要使用 10,000,000元 組織資金。<br>";
	echo "新名稱: <input type=text name=NewOrgName maxlength=32>";
	echo "<input type=submit value=\"設定\" onClick=\"return cfmModOrgN();\">";
	echo "</td></tr>";
	}
	echo "</form></table>";
	}// Action A End
	else {echo "未定義動作！";}
}//End of Settings
elseif ($mode == 'ModOrg'){
	if (!$Game['organization'] || $Game['rights'] != '1'){echo "你的權力不足。";postFooter();exit;}

	if ($actionb == 'ModLi'){
		//更新 Org Info
		if ($license > 3 || $license < 0){echo "Hacking Attempt.";postFooter();exit;}
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `license` = '$license' WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');
		if ($license == 0) $LiText = "即日起<b>接受新會員</b>加入而且會員可以<b>自由脫離</b>組織";
		elseif ($license == 1) $LiText = "即日起<b>接受新會員<b>加入但<b>限制會員自行退出</b>";
		elseif ($license == 2) $LiText = "即日起<b>不再接受新會員</b>加入但會員可以<b>自由脫離</b>組織";
		elseif ($license == 3) $LiText = "即日起<b>不再接受新會員</b>加入而且<b>限制會員自行退出</b>";
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 宣佈組織".$LiText."。";
		WriteHistory($HistoryWrite);
	}// Action A End
	elseif ($actionb == 'ModC'){
		if (1000000 > $Pl_Org['funds']){echo "組織資金不足。";postFooter();exit;}
		if (!$org_color){echo "請先選好顏色。";postFooter();exit;}
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `color` = '$org_color', `funds` = `funds`-1000000 WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');
		$Gen['cash']-=1000000;
		$HistoryWrite = "<font color=\"$org_color\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 宣佈組織更變代表顏色。";
		WriteHistory($HistoryWrite);
	}
	elseif ($actionb == 'ModN'){
		if (10000000 > $Pl_Org['funds']){echo "組織資金不足。";postFooter();exit;}
		if (!$NewOrgName){echo "請先選好組織名稱。";postFooter();exit;}
		$NewOrgName = preg_replace('/<[^<>]*>/','',$NewOrgName);
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `name` = '$NewOrgName', `funds` = `funds`-10000000 WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
		$query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');
		$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 宣佈組織更名為 <font color=\"$Pl_Org[color]\">$NewOrgName</font> 。";
		WriteHistory($HistoryWrite);
	}
	else {echo "未定義動作！";}
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">組織設定完成了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

}//End of ModOrg
elseif ($mode == 'CityAtk'){
	echo "<font style=\"font-size: 12pt\">攻略計劃</font>";
	printTHR();
	if (!$Game['organization'] || $Game['rights'] != '1'){echo "你的權力不足。";postFooter();exit;}
	
	if($Pl_Org['optmissioni']){
		$sql = ("SELECT COUNT(`t_end`) FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = '$Pl_Org[optmissioni]' AND `t_end` > '$CFU_Time' LIMIT 1;");
		$query = mysql_query($sql);
		$result = mysql_fetch_row($query);
		if($result[0] > 0) {echo "<p style='font-size: 12pt; color: coral' align=center>戰爭已發動。";postFooter();exit;}
	}

	if ($actionb == 'A'){
		echo "<form action=organization.php?action=CityAtk method=post name=mainform>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='1' name=reinforcements>";
		echo "<input type=hidden value='0' name=revolutionPrice>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

		echo "<script language=\"Javascript\">";
		echo "function changeDuration(){price.innerHTML= $Org_War_Cost * mainform.duration.value;}";
		echo "function cfmDeclare(){";
		echo "if ($Pl_Org[funds] < parseInt(price.innerHTML) + parseInt(mainform.revolutionPrice.value)){alert('組織資金不足！');return false;}";
		echo "else if (confirm('即將發動戰爭, 可以嗎？')==true){return true;}";
		echo "else {return false;}";
		echo "}function makeVal(val,max){";
		echo "val = val.replace(/[a-zA-Z\-+&!?=,<>@#$%\^\*\#\/\\\\[\]\{\}\'\"]+/,'');";
		echo "val = Math.round(val);";
		echo "if(!val) val = 1;";
		echo "if(val > max) val = max;";
		echo "if(val < 1) val = 1;";
		echo "return val;";
		echo "}function detectArea(){";
		echo "if(mainform.atkArea[0])";
		echo "for(i=0;mainform.atkArea[i];i++){";
		echo "	if(mainform.atkArea[i].checked) {";
		echo "		avaVal = parseInt(document.getElementById('rnfrcmnt_'+mainform.atkArea[i].value).innerHTML);avaVal -= 1;";
		echo "		inputVal = prompt('請輸入調動軍力的數量( 1 - '+avaVal+' )', '1');";
		echo "		if(inputVal == null) {mainform.atkArea[i].checked = false;return false;}";
		echo "		inputVal = makeVal(inputVal,avaVal); alert('即將調動 '+inputVal+' 點軍力。');";
		echo "		mainform.reinforcements.value = inputVal;";
		echo "		sel_msg.innerHTML = '從 '+mainform.atkArea[i].value+' 調動 '+numberFormat(inputVal)+' 點軍力進攻。';";
		echo "		continue;";
		echo "	}";
		echo "}";
		echo "else {";
		echo "		avaVal = parseInt(document.getElementById('rnfrcmnt_'+mainform.atkArea.value).innerHTML);avaVal -= 1;";
		echo "		inputVal = prompt('請輸入調動軍力的數量( 1 - '+avaVal+' )', '1');";
		echo "		if(inputVal == null) {mainform.atkArea.checked = false;return false;}";
		echo "		inputVal = makeVal(inputVal,avaVal); alert('即將調動 '+inputVal+' 點軍力。');";
		echo "		mainform.reinforcements.value = inputVal;";
		echo "		sel_msg.innerHTML = '從 '+mainform.atkArea.value+' 調動 '+numberFormat(inputVal)+' 點軍力進攻。';";
		echo "}";
		echo "}";
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
		echo "}</script>";

		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr><td align=left width=475><b style=\"font-size: 10pt;\">計劃對區域發動戰爭: </b></td></tr>";
		echo "<tr><td align=left><b style=\"font-size: 10pt;\">組織資金: ".number_format($Pl_Org['funds'])."元</b></td></tr>";
		echo "<tr><td align=left>需要資金: 每小時 ".number_format($Org_War_Cost)."元<br>共需要: <span id=price>$Org_War_Cost</span> 元<br>";


		unset($sql,$query,$AtTarPosblty,$nums);
		$sql = ("SELECT `map_id`,`name`,`aname` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map`,`".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `occupied`=`id` AND `occupied` != ". $Pl_Org['id']." ORDER BY `map_id` ASC");
		$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
		$nums = mysql_num_rows($query);
		$AtTarPosblty = $AtkDisabled = '';
		if ($nums){
			while ($AtkInfo = mysql_fetch_array($query))
				$AtTarPosblty .= "<option value='$AtkInfo[map_id]'>$AtkInfo[aname] ($AtkInfo[map_id] - $AtkInfo[name])";
			echo "於<select name=sttimedelay style=\"$BStyleA;text-align: center;\"><option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10<option value=11>11<option value=12>12<option value=13>13<option value=14>14<option value=15>15<option value=16>16<option value=17>17<option value=18>18</select>小時後";
			echo "向<select name=target style=\"$BStyleA;text-align: center;\">$AtTarPosblty</select> 發動<br>";
			echo "維持<select name=duration onChange=\"changeDuration()\" style=\"$BStyleA;text-align: center;\"><option value=1>1<option value=2>2<option value=3>3</select>小時的戰爭";
			$DefaultOName = $CFU_Date."的戰爭";
			echo "<br>行動代號: <input type=text name=Opt_Name maxlength=32 size=39 $BStyleB style=\"$BStyleA;text-align: center;\" value='$DefaultOName'>";
			echo "<hr width=80% align=center>";

			echo "<b style=\"font-size: 10pt;\">調動軍力: </b>";
			echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
				$sql = ("SELECT `map_id`, `aname`, `development`, `defenders`, `tickets` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `occupied` = '$Game[organization]' ORDER BY `map_id`");
				$query = mysql_query($sql);

				$O_Area = array();

				while($j = mysql_fetch_array($query))	$O_Area[$j['map_id']] = $j;
				unset($j);
				
				if(mysql_num_rows($query) > 0){
					echo "<tr>";
					echo "<td width=400 valign=top>";
					echo "各管轄區的軍事力量:";
						echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 12pt;\" bordercolor=\"#FFFFFF\">";
						echo "<tr align=center><td width=50>區域</td><td width=150>區域名稱</td><td width=75>總軍力</td><td width=75>從此區調動</td></tr>";
							foreach($O_Area as $a)
								printf ('<tr align=center><td>%s</td><td>%s</td><td id=rnfrcmnt_%1$s>%s</td><td><input type=radio name=atkArea value="%1$s" onClick="detectArea();"></td></tr>',$a['map_id'],$a['aname'],$a['tickets']);
						echo "</table>";
					echo "</td></tr>";
				}
				else{
					$sql = ("SELECT count(username) as `num` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '$Game[organization]';");
					$query = mysql_query($sql);
					$members = mysql_fetch_row($query);
					echo "<script language=\"Javascript\">";
					echo "function checkRevolution(){";
					echo "		inputVal = makeVal(mainform.atkArea.value,".($members[0]*1000)."); alert('即將調動 '+numberFormat(inputVal)+' 點軍力起義。');";
					echo "		mainform.reinforcements.value = mainform.atkArea.value = inputVal; mainform.revolutionPrice.value = mainform.reinforcements.value*$ticketCost;";
					echo "		sel_msg.innerHTML = '召集 '+inputVal+' 點軍力起義。<br>起義所需組織資金(包括宣戰費): \$' + numberFormat(parseInt(mainform.revolutionPrice.value)+parseInt(price.innerHTML));";
					echo "	}";
					echo "</script>";
					echo "<tr>";
					echo "<td width=400 valign=top>";
					echo "<b>起義</b>:";
					echo "<br>　- 由於己方組織並沒有領地, 因此可以進行「起義」<br>　- 起義軍力的計算方式:<br>　　- 軍力數量: 組織人數 * 1000 (".number_format($members[0]*1000)." 點)<br>　　- 上限: " . ($dailyTicketLim * 4) . "<br>　- 每一點軍力的價錢: ".$ticketCost."<br>";
						echo "<br> 輸入起義軍力數量: <input type=text name=atkArea value=0 onChange=\"checkRevolution();\">";
					echo "</td></tr>";
				}
				echo "<tr><td id=sel_msg>&nbsp;</td></tr>";
			echo "</td></tr>";
			echo "</table>";
		}
		else {echo "沒有可攻略的城市。"; $AtkDisabled = ' disabled';}
		echo "<hr width=80% align=center>";
		echo "<center><input type=submit value=\"宣戰\"$AtkDisabled onClick=\"return cfmDeclare();\" $BStyleB style=\"$BStyleA;\">";
		echo "</td></tr></form></table>";
	}

	elseif ($actionb == 'B'){
		if ($duration > 3){echo "戰爭時間嚴重過長。";postFooter();exit;}
		elseif ($duration < 0){echo "戰爭時間嚴重出錯。";postFooter();exit;}
		if ($sttimedelay > 18 || $sttimedelay < 6){echo "戰爭延時時問出錯。";postFooter();exit;}
		$Cost = $Org_War_Cost * $duration;
		if ($Cost < 0){echo "Hacking Attempt！";postFooter();exit;}
		if (!$Pl_Org['id']){echo "組織出錯！";postFooter();exit;}
		if ($Pl_Org['funds'] < $Cost){echo "組織資金不足。";postFooter();exit;}
		if ($Pl_Org['optmissioni']){echo "上一次的戰爭還沒完結！";postFooter();exit;}

		unset($sql,$query);
		$sql = ("SELECT `occupied` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$target'");
		$query = mysql_query($sql) or die();
		$count = mysql_num_rows($query);

		if($count == 0){echo "找不到目標區域！";postFooter();exit;}
		else{
			$TargetInf = mysql_fetch_array($query);
			if($TargetInf['occupied'] == $Pl_Org['id']) {echo "此區域已經為已方所有！不能進行攻略。";postFooter();exit;}
		}
		
		$revolutionFlag = false;
		$reinforcements = intval($reinforcements);
		if($reinforcements < 1) $reinforcements = 1;
		
		if($revolutionPrice > 0){
		
			$sql = ("SELECT count(map_id) as `aNum` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `occupied` = '$Game[organization]'");
			$query = mysql_query($sql);
			$areaCount = mysql_fetch_row($query);
			if($areaCount[0] > 0){
				echo "錯誤: 已有領地, 不能進行起義。";
				postFooter();
				exit;
			}
			$revolutionFlag = true;
			
			$sql = ("SELECT count(username) as `mNum` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '$Game[organization]'");
			$query = mysql_query($sql);
			$memberCount = mysql_fetch_row($query);

			if ($reinforcements > $memberCount[0] * 1000 || $reinforcements > $dailyTicketLim * 4){echo "起義軍力過高！";postFooter();exit;}

			$Cost += $reinforcements*$ticketCost;

			if ($Cost < 0){echo "Hacking Attempt！";postFooter();exit;}
			if ($Pl_Org['funds'] < $Cost){echo "組織資金不足。";postFooter();exit;}
			
			$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 以 <b style=\"color: $Pl_Org[color]\">".$reinforcements."點</b> 軍力起義, 對 ".$target." 區域宣戰！<br>行動代號『<font color=\"$Pl_Org[color]\">".$Opt_Name."</font>』！";

		}
		else{
			$sql = ("SELECT `occupied`,`tickets` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$atkArea'");
			$query = mysql_query($sql) or die();
			$AtkAreaInf = mysql_fetch_array($query);
			if($reinforcements > $AtkAreaInf['tickets']-1){echo "軍力不足！";postFooter();exit;}
			$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 派出 <b style=\"color: $Pl_Org[color]\">".$reinforcements."點</b> 軍力對 ".$target." 區域宣戰！<br>行動代號『<font color=\"$Pl_Org[color]\">".$Opt_Name."</font>』！";
		}

		if($AtkAreaInf['occupied'] != $Pl_Org['id'] && !$revolutionFlag){echo "錯誤: 調動軍力、發動攻擊的區域, 非己方組織所有！<br>請挑選己方組織的領地調動軍力、發動攻擊。";postFooter();exit;}

		WriteHistory($HistoryWrite);

		$StartTime = $CFU_Time + $sttimedelay * 3600;
		$EndTime = $StartTime + $duration * 3600;

		$war_id = $CFU_Time;

		if(!$revolutionFlag){
			$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `tickets` = ".($AtkAreaInf['tickets']-$reinforcements)." WHERE `map_id` = '$atkArea' LIMIT 1;");
			mysql_query($sql);
		}

		$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_war` (`war_id`, `t_start`, `t_end`, `a_org`, `b_org`, `ticket_a`, `ticket_b`, `mission`) VALUES('$war_id', '$StartTime', '$EndTime', '$Game[organization]', $TargetInf[occupied], $reinforcements, 1, 'Atk<$target>');");
		mysql_query($sql);

		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`-$Cost, `optmissioni` = '$war_id', `operation` = '$Opt_Name' WHERE `id` = '$Game[organization]' LIMIT 1;");
		mysql_query($sql);

		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
		echo "<p align=center style=\"font-size: 16pt\">戰爭發動了！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}

	else {echo "未定義動作！";}
}//End of CityAtk


elseif ($mode == 'TakeCity'){
	echo "<font style=\"font-size: 12pt\">佔領區域</font>";
	printTHR();
	if (!$Game['organization'] || $Game['rights'] != '1'){echo "你的權力不足。";postFooter();exit;}
	if ($Game['status']){echo "修理中，無法佔領區域。";postFooter();exit;}
	$Area = ReturnMap("$Gen[coordinates]");

	$sql = ("SELECT `mission`,`t_start`,`t_end`,`ticket_a`,`victory` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = '".$Pl_Org['optmissioni']."' AND `t_end` > '$CFU_Time' LIMIT 1;");
	$query = mysql_query($sql);
	$Opt_Info = mysql_fetch_array($query);
	
	$ErrorFlag = '';
	$tmp = array();
	if(preg_match('/Atk<([0-9a-zA-Z]+)>/', $Opt_Info['mission'], $tmp)){
		$Mission_Area_Id = $tmp[1];
	}else{
		$Mission_Area_Id = '';
	}
	unset($tmp);

	if(!$Opt_Info) $ErrorFlag .= '無法取得戰鬥資訊或戰爭已完結！<br>';
	if($Mission_Area_Id != $Gen['coordinates']) $ErrorFlag .= '無法佔領區域，沒有對此地區宣戰！<br>';
	if ($Opt_Info['victory'] != 1){$ErrorFlag .= "無法佔領區域，仍未勝出戰爭。<br>";}
	if ($Area["Sys"]["occprice"] > $Pl_Org['funds'])$ErrorFlag .= "組織資金不足！不能佔領區域。<br>";

	if($ErrorFlag) {echo $ErrorFlag;postFooter();exit;}

	if ($actionb == 'A'){
	echo "<form action=organization.php?action=TakeCity method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"Javascript\">";
	echo "function cfmOccupy(){";
	echo "if ($Pl_Org[funds] < ".$Area["Sys"]["occprice"]."){alert('組織資金不足！');return false;}";
	echo "else if (confirm('以 ".$Area["Sys"]["occprice"]." 佔地此地區, 可以嗎？')==true){return true;}";
	echo "else {return false;}";
	echo "}</script>";
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">佔領此區域: </b></td></tr>";

	echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">區域: $Gen[coordinates]</b><br>";
	echo "組織資金: ".number_format($Pl_Org['funds'])."元<br>";
	echo "佔領費用: ".number_format($Area["Sys"]["occprice"])."元<br>";
	$Area_At = $Area["Sys"]["at"];
	$Area_De = $Area["Sys"]["de"];
	$Area_Ta = $Area["Sys"]["ta"];
	echo "要塞初期能力:<br>HP上限: ". $Area["Sys"]["hpmax"];
	echo "<br>攻擊力: $Area_At 防衛力: $Area_De 命中: $Area_Ta<br>";
	GetWeaponDetails($Area["Sys"]["wepa"],'FortDfltWep');
	echo "防禦武器: $FortDfltWep[name]<br>";
	echo "<input type=submit value=佔領此區域 onClicl=\"return cfmOccupy()\">";
	echo "</td></tr>";
	echo "</form></table>";
	}
	elseif ($actionb == 'B'){

	if($Opt_Info['ticket_a'] < 1) $Opt_Info['ticket_a'] = 1;
	elseif($Opt_Info['ticket_a'] > $ticketMax) $Opt_Info['ticket_a'] = $ticketMax;

	$HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 成功\把 $Gen[coordinates] 區域佔領了！";
	WriteHistory($HistoryWrite);

	unset($sql,$query);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `hpmax` = '".$Area["Sys"]["hpmax"]."' ,`hp`=`hpmax` ,`at` ='".$Area["Sys"]["at"]."', `de` ='".$Area["Sys"]["de"]."', `ta` ='".$Area["Sys"]["ta"]."', `wepa` ='".$Area["Sys"]["wepa"]."', `occupied` = '$Game[organization]', `tickets` = '' WHERE `map_id` = '$Gen[coordinates]' LIMIT 1;");
	$query = mysql_query($sql) or die(mysql_error());

	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`-".$Area["Sys"]["occprice"].", `optmissioni` = 0, `operation` = '' WHERE `id` = '$Game[organization]' LIMIT 1;");
	mysql_query($sql);

	$sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = $Pl_Org[optmissioni] LIMIT 1;");
	$query = mysql_query($sql);

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">成功\佔領了此區域！<input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	}

	else {echo "未定義動作！";}
}//End of TakeCity

else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>