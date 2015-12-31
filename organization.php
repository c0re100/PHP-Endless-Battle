<?php
header('Content-Type: text/html; charset=utf-8');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser();
$now=time();
if ($CFU_Time >= $_SESSION['timeauth']+$TIME_OUT_TIME || $_SESSION['timeauth'] <= $CFU_Time-$TIME_OUT_TIME){echo "驗證機制！<br>請重新登入！";exit;}
GetUsrDetails("$_SESSION[username]",'Gen','Game');
if ($Game['organization'])
$Pl_Org = ReturnOrg("$Game[organization]");
//Special Commands GUI
if ($mode=='Start' && $Game['organization']==0){
		if ($Gen['cash'] < $OrganizingCost && !$Game['organization']){echo "條件不符";postFooter;exit;}
		if ($CFU_Time - $Game['lastorg'] < 86400){echo "24小時內只能成立國家一次。";postFooter();exit;}
	
        echo "<font style=\"font-size: 12pt\">成立國家</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if ($actionb == 'A'){
        echo "<form action=organization.php?action=Start method=post name=mainform>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        echo "<script language=\"Javascript\">";
        echo "function cfmStartOrg(){";
        echo "if ($OrganizingCost > $Gen[cash]){alert('金錢不足。');return false;}";
        echo "else if (mainform.org_name.value == '' || mainform.org_name.value.trim().length == 0){alert('請先輸入國家名稱。');return false;}";
        echo "else {if (confirm('成立國家需要 ". number_format($OrganizingCost) ." 元及100勝利積分，確定嗎？')==true){return true;}";
        echo "else {return false;}}";
        echo "}</script>";

        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">成立國家所需資料: </b></td></tr>";
        echo "<tr><td align=left>成立國家需要: ". number_format($OrganizingCost) ." 元及100勝利積分<br>";
        echo "國家名稱: <input type=text name=org_name maxlength=32 size=27><br>(注意不能與現有國家名稱一樣)<br>";
		echo "國家宗旨: <input type=text name=org_pose maxlength=90 size=27><br>(注意：30個字內)<br>";
        echo "代表顏色: <br><center>";
        foreach ($MainColors as $TheColor){$br++;$ct_default++;
        echo "<input type=\"radio\" name=\"org_color\" value=#".$TheColor;
        if ($ct_default==1) echo " checked";
        echo "><font color=#".$TheColor.">◆</font>    ";
        if ($br==6){echo"<br>";$br=0;}        }
        
        echo "<input type=submit value=\"確定成立國家\" onClick=\"return cfmStartOrg();\">";
        echo "</tr></td></form></table>";
        }

        if ($actionb == 'B'){
		$org_name = mysql_real_escape_string($org_name);
		$org_color = mysql_real_escape_string($org_color);
		$org_pose = mysql_real_escape_string($org_pose);
		if ($Game['v_points'] < 100){echo "您沒有足夠勝利積分！";postFooter();exit;}
		if ($org_name == "中立組織"){echo "您以為您真的是中立嗎？";postFooter();exit;}
        if ($OrganizingCost > $Gen['cash']){echo "金錢不足。";postFooter();exit;}
        if ($Gen['fame'] < $OrganizingFame && $Gen['fame'] > $OrganizingNotor){echo "名聲不足。";postFooter();exit;}
		
		$points = ("UPDATE ".$GLOBALS['DBPrefix']."phpeb_user_game_info SET v_points = v_points-100 WHERE `username` = '".$_SESSION['username']."'");
		$minpts = mysql_query($points);
        
		$Gen['cash'] -= $OrganizingCost;

        $HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> 創立 <font color=\"$org_color\">$org_name</font> 國家，並歡迎所有人自由加入及退出。<br>國家宗旨: <font color=\"$org_color\">$org_pose</font>";
        WriteHistory($HistoryWrite);
        //Enter Organization Info
        $sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_organization (id, name, color, pose) VALUES('$CFU_Time','$org_name','$org_color','$org_pose')");
        mysql_query($sql) or die ('<br><center>未能完成註冊<br>原因:' . mysql_error() . '<br>');

        $org_name = ereg_replace("\<([^\<\>]*)\>",'',$org_name);

        $sql = ("SELECT id FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE name='". $org_name ."'");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
        $New_Org = mysql_fetch_row($query);

        //更新 Game Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '100000', `rights` = '1', `organization` = '$New_Org[0]', `lastorg` = '$now' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

        //更新 General Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">成立國家完成了！<br><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
        }
}
elseif($mode == 'Employ'){
        if ($actionb == 'C'){
        unset($CancelFlag);
        if (!$Employer){echo "你被誰邀請呀？";postFooter;exit;}
        elseif ($Game['rights']=='1'){echo "總帥不能被邀請。";postFooter;exit;}
        else {$Og_Org=$Pl_Org;$Pl_Org = ReturnOrg($Employer);}if (!$Og_Org){$Og_Org =  ReturnOrg('0');}

        if(!ereg('(\!'.$_SESSION['username'].'\, )+',$Pl_Org['request_list'])){$EmployMsg = "該國家沒有邀請您。";$CancelFlag = '1';}
        else{$Pl_Org['request_list'] = ereg_replace('(\!'.$_SESSION['username'].'\, )+','',$Pl_Org['request_list']);}

        //更新 Org Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `request_list` = '$Pl_Org[request_list]' WHERE `id` = '".$Pl_Org[id]."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得國家資訊, 原因:' . mysql_error() . '<br>');

        //更新 General Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `request` = '' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

        if ($actionc == 'Accept' && !$CancelFlag){
        //更新 Game Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '0', `rights` = '0', `organization` = '$Pl_Org[id]' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
        $EmployMsg = "成功加入國家！";
        $HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 受邀請加入 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>。";
        WriteHistory($HistoryWrite);
        }

        elseif ($actionc == 'Refuse' && !$CancelFlag){
        $EmployMsg = "成功拒絕加入國家。";
        $HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 拒絕了加入 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>的邀請。";
        WriteHistory($HistoryWrite);
        }

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\"><br><br><br>$EmployMsg<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
        echo "</body>";
        echo "</html>";
        exit;
        } // End of Action C

        echo "<font style=\"font-size: 12pt\">招募人才</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if ($actionb == 'A'){
        echo "<form action=organization.php?action=Employ method=post name=mainform>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        echo "<script language=\"Javascript\">";
        echo "function cfmEmploy(){";
        echo "if (mainform.EmployTar.value == ''){alert('請先輸入要招攬的人。');return false;}";
        echo "else {if (confirm('邀請目標加入國家，確定嗎？')==true){return true;}";
        echo "else {return false;}}";
        echo "}</script>";

        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">招募人才: </b></td></tr>";

        unset($sql,$query,$AvailPersons);
        $sql = ("SELECT `username`,`gamename`,`organization` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$_SESSION['username']."' AND `organization` != '$Game[organization]' AND !`rights` OR !`organization` ORDER BY `organization` ASC");
        $query = mysql_query($sql) or die(mysql_error());
        $AvailPersons = mysql_fetch_array($query);
        do{
        $TarOrg = ReturnOrg($AvailPersons['organization']);
        $EmployOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename] ($TarOrg[name])";
        unset($AvailPersons,$TarOrg);
        }
        while ($AvailPersons = mysql_fetch_array($query));

        if ($EmployOpt)
        echo "<tr><td align=left>向 <input type=text name=EmployTar value=請輸入玩家名稱><br><input type=submit value=\"邀請\" onClick=\"return cfmEmploy();\"> 發出邀請信。</td></tr>";

        if(!ereg('(\!'.$_SESSION['username'].'\, )+',$Pl_Org['request_list'])){$EmployMsg = "該國家沒有邀請您。";$CancelFlag = '1';}
        else{$Pl_Org['request_list'] = ereg_replace('(\!'.$_SESSION['username'].'\, )+','',$Pl_Org['request_list']);}

        if ($Pl_Org['request_list']){
        echo "<tr><td align=left>未得到回覆的邀請信: <br>";

        $Pl_Org['request_list'] = ereg_replace('!| ','',$Pl_Org['request_list']);
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
        } // End of Action A
        if ($actionb == 'B'){
		$EmployTar = mysql_real_escape_string($EmployTar);
		$getun = ("SELECT username FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `gamename` = '".$EmployTar."' AND rights='0'");
		$getfull = mysql_query($getun) or die ('遊戲名稱輸入錯誤 或 對方是總帥呀！');
		$tarname = mysql_fetch_row($getfull);

        if (!$EmployTar || $EmployTar == $_SESSION['username']){echo "你要招攬誰呀？";postFooter;exit;}

        $Pl_Org = ReturnOrg($Game['organization']);

        $Pl_Org['request_list'] .= '!'.$tarname[0].', ';

        //更新 Org Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `request_list` = '$Pl_Org[request_list]' WHERE `id` = '".$Game['organization']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

        $requesttx = "$Pl_Org[name] 的 $Game[gamename] 向您發出加入國家的邀請信。<br>你要加入國家嗎？<br>";
        $requesttx .= "<input type=hidden name=Employer value=\'$Pl_Org[id]\'>";

        //更新 General Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `request` = '$requesttx' WHERE `username` = '$tarname[0]' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">國家邀請信已發出。<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
        } // End of Action B
}//End of Employ
elseif ($mode == 'LeaveOrg'){
        if (!$Game['organization'] || $Game['rights']){echo "以您的身份不能脫離國家。";postFooter;exit;}
        if ($actionb != 'A' && $actionb != 'B' && $actionb != 'C') {echo "未定義動作！<br>";exit;}
        if ($actionb == 'A'){
                if ($Pl_Org['license'] == 1 || $Pl_Org['license'] == 3)
                        {echo "您的國家不容許你私自脫離，若真的想離開就請您逃亡吧。";postFooter;exit;}
        }
        else {
                if ($Pl_Org['license'] != 1 && $Pl_Org['license'] != 3)
                        {echo "您無需逃亡。";postFooter;exit;}
                if ($actionb == 'C') $Gen['fame'] -= 10;
                $Gen['fame'] = floor($Gen['fame']*0.9);
        }
        //更新 Gen Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `fame` = '$Gen[fame]' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');

        if (abs($Gen['fame']) >= 100){
        $HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> 脫離 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>。";
        WriteHistory($HistoryWrite);}

        //更新 Game Info
		$sql2 = ("SELECT count(*) FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '$Pl_Org[id]'");
		$query2 = mysql_query($sql2);
		$cquery = mysql_result($query2, 0);
		$sql3 = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `cnum` = cnum-1 WHERE `id` = '$Pl_Org[id]'");
		$query2 = mysql_query($sql3);
		
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '0', `rights` = '0', `organization` = '0', `lastorg` = '$now' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
		
		

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">已脫離國家。<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
        }
//End of LeaveOrg
elseif ($mode == 'LeavePlace'){
        echo "<font style=\"font-size: 12pt\">退位</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if (!$Game['organization'] || $Game['rights'] != 1){echo "以您的身份不能退位。";postFooter;exit;}

        if ($Game['rights'] == '1'){$RightsTitle = $RightsClass['Major'];$AllowWho = "`rights` != '1'";}
        elseif ($Game['rights']){$RightsTitle = $RightsClass['SMajor'];$AllowWho = "!`rights`";}

        if ($actionb == 'A'){
        echo "<form action=organization.php?action=LeavePlace method=post name=mainform>";
        echo "<input type=hidden value='B' name=actionb>";
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
        $sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$_SESSION['username']."'  AND `organization` = '$Game[organization]' AND $AllowWho ORDER BY `rank` DESC");
        $query = mysql_query($sql) or die(mysql_error());
        $AvailPersons = mysql_fetch_array($query);

        do{
        $GiveTarOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename]";
        unset($AvailPersons);
        }
        while ($AvailPersons = mysql_fetch_array($query));

        if ($GiveTarOpt)
        echo "<tr><td align=left>您的權力: $RightsTitle <br>可退位給的人:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"退位\" onClick=\"return cfmLeavePlace();\"></td></tr>";
        else echo "<tr><td align=left>您的權力: $RightsTitle <br>沒有適合的人選。</td></tr>";
        echo "</form></table>";
        }// Action A End

        elseif ($actionb == 'B'){
		$GiveTar= mysql_real_escape_string($GiveTar);
		
        if (!$GiveTar){echo "請先指定目標。";postFooter;exit;}

        $sqlgame = ("SELECT `gamename`,`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info`,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `".$GLOBALS['DBPrefix']."phpeb_user_game_info`.`username`='". $GiveTar ."'");
        $query_game = mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
        $GiveTarOpt = mysql_fetch_array($query_game);

        $HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 把 $RightsTitle 之權力讓給 <font color=\"$GiveTarOpt[color]\">$GiveTarOpt[gamename]</font> 。";
        WriteHistory($HistoryWrite);

        //更新 Game Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '100000', `rights` = '1', `organization` = '$Game[organization]' WHERE `username` = '".$GiveTar."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

        //更新 Game Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rights` = '0', `organization` = '$Game[organization]' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">退位完成了！<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";

        }// Action B End


        else {echo "未定義動作！";}
}//End of LeavePlace

elseif ($mode == 'Break'){
if ($actionb = 'A'){
        if (!$Game['organization'] && $Game['rights'] != '1'){echo "以您的身份不能解散國家。";postFooter;exit;}

        $HistoryWrite = "<font color=\"$Gen[color]\">$Game[gamename]</font> 把 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 解散了。";
        WriteHistory($HistoryWrite);

        //更新 Game Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '0', `rights` = '0', `organization` = '0', `lastorg` = '$now' WHERE `organization` = '".$Game['organization']."'");
        $query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
        //更新 Map Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `occupied` = '0' WHERE `occupied` = '".$Game['organization']."'");
        $query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
        //消除 Org Info
        $sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE id='". $Game['organization'] ."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">國家已被解散。<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
        }// Action A End
}// End of Break Organization

elseif ($mode == 'Dismiss'){
        echo "<font style=\"font-size: 12pt\">解雇</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if (!$Game['organization'] || !$Game['rights']){echo "以您的身份不能解雇其他人。";postFooter;exit;}

        /*if ($Game['rights'] == '1'){$RightsTitle = $RightsClass['Major'];$AllowWho = "`rights` != '1'";}
        elseif ($Game['rights']){$RightsTitle = $RightsClass['SMajor'];$AllowWho = "!`rights`";}*/

        if ($actionb == 'A'){
        echo "<form action=organization.php?action=Dismiss method=post name=userlist>";
		echo "<input type=hidden name=\"kick\" value=''>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        /*echo "<script language=\"Javascript\">";
        echo "function cfmDismiss(){";
        echo "if (mainform.GiveTar.value == ''){alert('請先輸入要解僱的人。');return false;}";
        echo "else {if (confirm('解僱目標人物，確定嗎？')==true){return true;}";
        echo "else {return false;}}";
        echo "}</script>";*/
		
		echo "<script language=\"Javascript\">";
		echo "function kickuser(name){";
		echo "        userlist.action='organization.php?action=Dismiss';";
		echo "        userlist.kick.value=name;";
		echo "		  userlist.submit();";
		echo "        }</script>";
        
		/*echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">解僱國民: </b></td></tr>";

        unset($sql,$query,$AvailPersons);
        $sql = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '".$_SESSION['username']."'  AND `organization` = '$Game[organization]' AND $AllowWho ORDER BY `rank` DESC");
        $query = mysql_query($sql) or die(mysql_error());
        $AvailPersons = mysql_fetch_array($query);

        do{
        $GiveTarOpt .= "<option value='$AvailPersons[username]'>$AvailPersons[gamename]";
        unset($AvailPersons);
        }
        while ($AvailPersons = mysql_fetch_array($query));

        if ($GiveTarOpt)
        echo "<tr><td align=left>您的權力: $RightsTitle <br>可解雇的人:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"解雇\" onClick=\"return cfmDismiss();\"></td></tr>";
        else echo "<tr><td align=left>您的權力: $RightsTitle <br>沒有可以被解雇的人。</td></tr>";
        echo "</form></table><br>";*/
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\"  style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\" width=\"600px\">";
		echo "<tr align=center><td colspan=16><b>國民列表: </b></td></tr>";
		echo "<tr align=center>";
        echo "<td width=\"100\">名稱</td>";
		echo "<td width=\"40\">等級</td>";
		echo "<td width=\"140\">最後上線時間</td>";
		echo "<td width=\"40\">操作</td>";
		echo "</tr>";
		
		$list = ("SELECT a.gamename AS gamename, a.level AS level, b.time2 AS time FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` a INNER JOIN `".$GLOBALS['DBPrefix']."phpeb_user_general_info` b ON a.username = b.username WHERE a.organization = '$Game[organization]' AND a.rights!=1 ORDER BY a.level DESC");
		$qlist = mysql_query($list);
		
		while ($userlist = mysql_fetch_array($qlist)){
			echo "<tr align=center>";
			echo "<td width=\"100\">$userlist[gamename]</td>";
			echo "<td width=\"40\">$userlist[level]</td>";
			$realtime = cfu_time_convert($userlist['time']);
			echo "<td width=\"140\">$realtime</td>";
			echo "<td width=\"40\"><input type=\"submit\" value=\"解僱\" onclick=\"kickuser('$userlist[gamename]');\"></td>";
			echo "</tr>";
		}
		
		echo "</form></table>";
        }// Action A End

        elseif ($actionb == 'B'){
		
		if ($kick == ''){echo "請先指定目標！";postFooter;exit;};

        $sqlgame = ("SELECT `gamename`,`organization`,`rights` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE gamename='$kick'");
        $qgame = mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
        $TarQ = mysql_fetch_array($qgame);
		
		if ($TarQ['rights'] == 1){echo "您沒有權力解僱總帥！";postFooter;exit;};
		if ($TarQ['organization'] != $Game['organization']){echo "該名玩家不在此組織！";postFooter;exit;};

        $HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 把國家內的 <font color=\"$TarQ[color]\">$TarQ[gamename]</font> 解雇了。";
        WriteHistory($HistoryWrite);


        //更新 Game Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '0', `rights` = '0', `organization` = '0' WHERE `gamename` = '$kick' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">解雇完成了！<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
		
        }// Action B End


        else {echo "未定義動作！";}
}//End of Dismiss
elseif ($mode == 'JoinOrg'){
		if ($CFU_Time - $Game['lastorg'] < 43200){echo "12小時內只能加入國家一次。";postFooter();exit;}
	
        echo "<font style=\"font-size: 12pt\">加入國家</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if ($Game['organization']){echo "你已有所屬的國家了。";postFooter;exit;}

        if ($actionb == 'A'){
        echo "<form action=organization.php?action=JoinOrg method=post name=joinlist>";
		echo "<input type=hidden name=\"join\" value=''>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        /*echo "<script language=\"Javascript\">";
        echo "function cfmJoinOrg(){";
        echo "if (mainform.GiveTar.value == ''){alert('請先輸入要加入的國家。');return false;}";
        echo "else {if (confirm('加入目標國家，確定嗎？')==true){return true;}";
        echo "else {return false;}}";
        echo "}</script>";

        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">加入國家接受新會員的國家: </b></td></tr>";

        unset($sql,$query,$AvailPersons);
        $sql = ("SELECT `id`,`name` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `id` != '0' AND `license` < 2  ORDER BY `id` DESC");
        $query = mysql_query($sql) or die(mysql_error());
        $AvailPersons = mysql_fetch_array($query);

        do{
        $GiveTarOpt .= "<option value='$AvailPersons[id]'>$AvailPersons[name]";
        unset($AvailPersons);
        }
        while ($AvailPersons = mysql_fetch_array($query));

        if ($GiveTarOpt)
        echo "<tr><td align=left>可加入的國家:<select name=GiveTar>$GiveTarOpt</select><br><input type=submit value=\"加入\" onClick=\"return cfmJoinOrg();\"></td></tr>";
        else echo "<tr><td align=left>沒有可以被加入的國家。</td></tr>";
        echo "</form></table>";
        }// Action A End*/
		
		echo "<script language=\"Javascript\">";
		echo "function joinog(org){";
		echo "        joinlist.action='organization.php?action=JoinOrg';";
		echo "        joinlist.join.value=org;";
		echo "		  joinlist.submit();";
		echo "        }</script>";
		
		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\"  style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\" width=\"600px\">";
		echo "<tr align=center><td colspan=16><b>國家列表: </b></td></tr>";
		echo "<tr align=center>";
        echo "<td width=\"100\">國家名稱</td>";
		echo "<td width=\"100\">統治者</td>";
		echo "<td width=\"140\">國家宗旨</td>";
		echo "<td width=\"40\">人數</td>";
		echo "<td width=\"40\">操作</td>";
		echo "</tr>";

		$sql = ("SELECT a.id AS id, a.name AS name, a.cnum AS num, a.pose AS pose, a.license AS license, b.gamename AS gamename FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` a INNER JOIN `".$GLOBALS['DBPrefix']."phpeb_user_game_info` b ON a.id=b.organization WHERE a.id != '0' AND b.rights=1 ORDER BY a.id DESC");
        $query = mysql_query($sql);
       
		while($joinlist = mysql_fetch_array($query)){
			echo "<tr align=center>";
			echo "<td width=\"100\">$joinlist[name]</td>";
			echo "<td width=\"100\">$joinlist[gamename]</td>";
			echo "<td width=\"140\">$joinlist[pose]</td>";
			echo "<td width=\"40\">$joinlist[num] / 10</td>";
			if($joinlist['license'] >= 2){
			echo "<td width=\"40\"><input type=\"submit\" value=\"無法加入\" disabled></td>";}
			elseif($joinlist['license'] < 2){
			echo "<td width=\"40\"><input type=\"submit\" value=\"加入\" onclick=\"joinog('$joinlist[id]');\"></td>";}
		}
		echo "</form></table>";		
		
}
        elseif ($actionb == 'B'){
		
		$join = mysql_real_escape_string($join);
        if ($join==''){echo "請先指定要加入的國家。";postFooter;exit;}
		
		$ppl = ("SELECT count(*) FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '".$join."'");
		$qppl = mysql_query($ppl);
		$lastp = mysql_fetch_row($qppl);
		
		if ($lastp[0] >= 10){echo "該國家人數過多，暫時無法加入<br>請加入其他國家或自行成立國家。";postFooter;exit;}

        $Og_Org = ReturnOrg($Game['organization']);
        $Pl_Org = ReturnOrg($join);

        if (abs($Gen['fame']) >= 100){
        $HistoryWrite = "<font color=\"$Og_Org[color]\">$Og_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 加入 <font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>。";
        WriteHistory($HistoryWrite);}

        //更新 Game Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '0', `rights` = '0', `organization` = '".$join."', `lastorg` = '$now' WHERE `username` = '".$_SESSION['username']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
		
		$sql2 = ("SELECT count(*) FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '".$join."'");
		$query2 = mysql_query($sql2);
		$cquery = mysql_result($query2, 0);
		$sql3 = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `cnum` = '$cquery' WHERE `id` = '".$join."'");
		$query2 = mysql_query($sql3);

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">加入國家完成了！<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";

        }// Action B End


        else {echo "未定義動作！";}
}//End of JoinOrg
elseif ($mode == 'Settings'){
        echo "<font style=\"font-size: 12pt\">國家設定</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if (!$Game['organization'] || $Game['rights'] != '1'){echo "你的權力不足。";postFooter;exit;}

        if ($actionb == 'A'){
        echo "<form action=organization.php?action=ModOrg method=post name=mainform>";
        echo "<input type=hidden value='' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        echo "<script language=\"Javascript\">";
        echo "function cfmModOrgLi(){";
        echo "if (confirm('修改國家自由度, 確定嗎？')==true){mainform.actionb.value='ModLi';return true;}";
        echo "else {return false;}";
        echo "}</script>";

        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">設定國家組態: </b></td></tr>";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">國家資金: ".number_format($Pl_Org['funds'])."元</b></td></tr>";
        echo "<tr><td align=left>國家自由度:<br><input type=radio name=\"license\" checked value=\"0\">: 自由加入、退出<br><input type=radio name=\"license\" value=\"1\">: 自由加入，限制退出<br><input type=radio name=\"license\" value=\"2\">: 限制加入，自由退出<br><input type=radio name=\"license\" value=\"3\">: 限制加入、退出<br>";
        echo "<input type=submit value=\"設定\" onClick=\"return cfmModOrgLi();\">";
        echo "</td></tr>";

        if ($Pl_Org['funds'] > 10000000){

        echo "<script language=\"Javascript\">";
        echo "function cfmModOrgC(){";
        echo "if (confirm('以 10,000,000元 修改國家代表色, 確定嗎？')==true){mainform.actionb.value='ModC';return true;}";
        echo "else {return false;}";
        echo "}</script>";

        echo "<tr><td align=left>國家代表色:<br>更變代表色需要使用 1,000,000元 國家資金。<br>";
        foreach ($MainColors as $TheColor){$br++;$ct_default++;
        echo "<input type=\"radio\" name=\"org_color\" value=#".$TheColor;
        if ($ct_default==1) echo " checked";
        echo "><font color=#".$TheColor.">◆</font>    ";
        if ($br==6){echo"<br>";$br=0;}        }
        echo "<input type=submit value=\"設定\" onClick=\"return cfmModOrgC();\">";
        echo "</td></tr>";
        }
        if ($Pl_Org['funds'] > 100000000){
        echo "<script language=\"Javascript\">";
        echo "function cfmModOrgN(){";
        echo "if (confirm('以 100,000,000元 修改國家名稱, 確定嗎？')==true){mainform.actionb.value='ModN';return true;}";
        echo "else {return false;}";
        echo "}</script>";

        echo "<tr><td align=left>國家名稱:<br>更變國家名稱需要使用 100,000,000元 國家資金。<br>";
        echo "新名稱: <input type=text name=NewOrgName maxlength=32>";
        echo "<input type=submit value=\"設定\" onClick=\"return cfmModOrgN();\">";
        echo "</td></tr>";
        }
		if ($Pl_Org['funds'] > 10000000){
        echo "<script language=\"Javascript\">";
        echo "function cfmModOrgX(){";
        echo "if (confirm('以 10,000,000元 修改國家宗旨, 確定嗎？')==true){mainform.actionb.value='ModX';return true;}";
        echo "else {return false;}";
        echo "}</script>";

        echo "<tr><td align=left>國家宗旨:<br>更換國家宗旨需要使用 10,000,000元 國家資金。<br>";
        echo "新宗旨: <input type=text name=NewOrgPose maxlength=90 value=$Pl_Org[pose]>";
        echo "<input type=submit value=\"設定\" onClick=\"return cfmModOrgX();\">";
        echo "</td></tr>";
        }
        echo "</form></table>";
        }// Action A End
        else {echo "未定義動作！";}
}//End of Settings
elseif ($mode == 'ModOrg'){
        if (!$Game['organization'] || $Game['rights'] != '1'){echo "你的權力不足。";postFooter;exit;}

        if ($actionb == 'ModLi'){
        //更新 Org Info
		$license = mysql_real_escape_string($license);
        if ($license > 3 || $license < 0){echo "Hacking Attempt.";postFooter;exit;}
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `license` = '$license' WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得國家資訊, 原因:' . mysql_error() . '<br>');
        if ($license == 0) $LiText = "即日起<b>接受新會員</b>加入而且會員可以<b>自由脫離</b>國家";elseif ($license == 1) $LiText = "即日起<b>接受新會員<b>加入但<b>限制會員自行退出</b>";
        elseif ($license == 2) $LiText = "即日起<b>不再接受新會員</b>加入但會員可以<b>自由脫離</b>國家";elseif ($license == 3) $LiText = "即日起<b>不再接受新會員</b>加入而且<b>限制會員自行退出</b>";
        $HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 宣佈國家".$LiText."。";
        WriteHistory($HistoryWrite);
        }// Action A End
        elseif ($actionb == 'ModC'){
		$org_color = mysql_real_escape_string($org_color);
        if (10000000 > $Pl_Org['funds']){echo "國家資金不足。";postFooter();exit;}
        if (!$org_color){echo "請先選好顏色。";postFooter();exit;}
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `color` = '$org_color', `funds` = `funds`-1000000 WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得國家資訊, 原因:' . mysql_error() . '<br>');
        $Gen['cash']-=10000000;
        $HistoryWrite = "<font color=\"$org_color\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 宣佈國家更換代表顏色。";
        WriteHistory($HistoryWrite);
        }
        elseif ($actionb == 'ModN'){
		$NewOrgName = mysql_real_escape_string($NewOrgName);
        if (100000000 > $Pl_Org['funds']){echo "國家資金不足。";postFooter();exit;}
        if (!$NewOrgName){echo "請先選好國家名稱。";postFooter();exit;}
        $NewOrgName = ereg_replace("\<([^\<\>]*)\>",'',$NewOrgName);
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `name` = '$NewOrgName', `funds` = `funds`-100000000 WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得國家資訊, 原因:' . mysql_error() . '<br>');
        $HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 宣佈國家更名為 <font color=\"$Pl_Org[color]\">$NewOrgName</font> 。";
        WriteHistory($HistoryWrite);
        }
		elseif ($actionb == 'ModX'){
		$NewOrgPose = mysql_real_escape_string($NewOrgPose);
        if (10000000 > $Pl_Org['funds']){echo "國家資金不足。";postFooter();exit;}
        if (!$NewOrgPose){echo "請先選好國家宗旨。";postFooter();exit;}
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `pose` = '$NewOrgPose', `funds` = `funds`-10 WHERE `id` = '".$Pl_Org['id']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得國家資訊, 原因:' . mysql_error() . '<br>');
        }
        else {echo "未定義動作！";}
        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">國家設定完成了！<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";

}//End of ModOrg
elseif ($mode == 'CityAtk'){
        echo "<font style=\"font-size: 12pt\">攻略計劃</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if (!$Game['organization'] || !$Game['rights']){echo "你的權力不足。";postFooter;exit;}
		
		if ($CFU_Time - $Pl_Org['lastopt'] < 43200){echo "12小時內只能發動一次戰爭。";postFooter();exit;}
		if ($Pl_Org['optmissioni'] != ''){echo "請先放棄上一次佔領才發動新一次戰爭！";postFooter();exit;}

        if ($actionb == 'A'){
        echo "<form action=organization.php?action=CityAtk method=post name=mainform>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        echo "<script language=\"Javascript\">";
        echo "function changeDuration(){price.innerText= $Org_War_Cost * mainform.duration.value;}";
        echo "function cfmDeclare(){";
        echo "if ($Pl_Org[funds] < price.innerText){alert('國家資金不足！');return false;}";
        echo "else if (confirm('即將發動戰爭, 可以嗎？')==true){return true;}";
        echo "else {return false;}";
        echo "}</script>";

        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">計劃對區域發動戰爭: </b></td></tr>";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">國家資金: ".number_format($Pl_Org['funds'])."元</b></td></tr>";
        echo "<tr><td align=left>需要資金: 每小時 ".number_format($Org_War_Cost)."元<br>共需要: <span id=price>$Org_War_Cost</span> 元<br>";


        unset($sql,$query,$AtTarPosblty,$nums);
        $sql = ("SELECT `map_id`,`name` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map`,`".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `occupied`=`id` AND nonatk=0 AND `occupied` != ". $Pl_Org['id']);
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
        $nums = mysql_num_rows($query);
        if ($nums){
        while ($AtkInfo = mysql_fetch_array($query))
        {
        $AtTarPosblty .= "<option value='$AtkInfo[map_id]'>$AtkInfo[map_id] ($AtkInfo[name])";
        }

        echo "於<select name=sttimedelay><option value=1>1<option value=2>2<option value=3>3<option value=8>8<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10<option value=11>11<option value=12>12<option value=13>13</select>小時後";
        echo "向<select name=target>$AtTarPosblty</select> 發動<br>";
        echo "維持<select name=duration onChange=\"changeDuration()\"><option value=1>1</select>小時的戰爭";
        $DefaultOName = $CFU_Date."的戰爭";
        echo "<br>行動代號: <input type=text name=Opt_Name maxlength=32 value='$DefaultOName'>";
        }
        else {echo "沒有可攻略的城市。"; $AtkDisabled = ' disabled';}
        echo "<Br><input type=submit value=\"宣戰\"$AtkDisabled onClick=\"return cfmDeclare();\">";
        echo "</td></tr></table>";
        }
        elseif ($actionb == 'B'){
		$sttimedelay = mysql_real_escape_string($sttimedelay);
		$duration = mysql_real_escape_string($duration);
		$target = mysql_real_escape_string($target);
		if ($sttimedelay <= 0){echo "不能即時開始戰爭！";postFooter();exit;}
        if ($duration > 1){echo "戰爭時間嚴重過長。";postFooter();exit;}
        elseif ($duration < 0){echo "戰爭時間嚴重出錯。";postFooter();exit;}
        if ($sttimedelay > 13 || $sttimedelay < 0){echo "戰爭延時時間出錯。";postFooter();exit;}
        if ($Pl_Org['funds'] < ($Org_War_Cost * $duration)){echo "國家資金不足。";postFooter();exit;}
        if ($Pl_Org['opttime'] > $CFU_Time){echo "上一次的戰爭還沒完結！";postFooter();exit;}
		if ($target=='E1' || $target=='E2' || ereg('(D)+',$target)){echo "無法佔領此區域！";postFooter();exit;}

        $StartTime = $CFU_Time + $sttimedelay * 3600;
        $EndTime = $StartTime + $duration * 3600;
        $Cost = $Org_War_Cost * $duration;
        if ($Cost < 0){echo "Hacking Attempt！";postFooter();exit;}

        $HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font>的<font color=\"$Gen[color]\">$Game[gamename]</font> 對 $target 區域宣戰！將於<font color=\"$Pl_Org[color]\"> $sttimedelay 小時</font> 後發動！";
        WriteHistory($HistoryWrite);

        unset($sql,$query);
        $sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$target'");
        $query = mysql_query($sql) or die(mysql_error());

        unset($sql);
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`-$Cost, `optmissioni` = 'Atk=($target)', `opttime` = '$EndTime', `optstart` = '$StartTime', `operation` = '$Opt_Name' WHERE `id` = '$Game[organization]' LIMIT 1;");
        mysql_query($sql);
		
		$protecting = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET protect='1' WHERE `map_id` = '$target';");
		mysql_query($protecting);
		
		$opttime = time();
		$opt = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET lastopt='$opttime' WHERE `id` = '$Game[organization]'");
		mysql_query($opt);

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">戰爭將於<font color=\"$Pl_Org[color]\"> $sttimedelay 小時</font> 後發動！！<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
        }

        else {echo "未定義動作！";}
}//End of CityAtk


elseif ($mode == 'TakeCity'){
        echo "<font style=\"font-size: 12pt\">佔領區域</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if (!$Game['organization'] || $Game['rights'] != '1'){echo "你的權力不足。";postFooter;exit;}
        if ($Pl_Game['status']){echo "修理中，無法佔領區域。";postFooter();exit;}
        $Area = ReturnMap("$Gen[coordinates]");
        if ($Area["User"]["hp"] > 0){echo "無法佔領區域，仍然有敵軍守備著。";postFooter();exit;}
        if (ereg_replace('(Atk=\()|\)','',$Pl_Org['optmissioni']) != $Gen['coordinates'] && $CFU_Time > $Pl_Org['opttime'])
        {echo "無法佔領區域，沒有對此地區宣戰。";postFooter();exit;}

        if ($Area["Sys"]["occprice"] > $Pl_Org['funds']){echo "國家資金不足！不能佔領區域。";postFooter();exit;}

        if ($actionb == 'A'){
        echo "<form action=organization.php?action=TakeCity method=post name=mainform>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        echo "<script language=\"Javascript\">";
        echo "function cfmOccupy(){";
        echo "if ($Pl_Org[funds] < ".$Area["Sys"]["occprice"]."){alert('國家資金不足！');return false;}";
        echo "else if (confirm('以 ".$Area["Sys"]["occprice"]." 佔領此區域嗎？')==true){return true;}";
        echo "else {return false;}";
        echo "}</script>";
        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">佔領此區域: </b></td></tr>";

        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">區域: $Gen[coordinates]</b><br>";
        echo "國家資金: ".number_format($Pl_Org['funds'])."元<br>";
        echo "佔領費用: ".number_format($Area["Sys"]["occprice"])."元<br>";
        $Area_At = $Area["Sys"]["at"] + 20;
        $Area_De = $Area["Sys"]["de"] + 25;
        $Area_Ta = $Area["Sys"]["ta"] + 100;
        echo "要塞初期能力:<br>HP上限: ". $Area["Sys"]["hpmax"];
        echo "<br>攻擊力: $Area_At 防衛力: $Area_De 命中: $Area_Ta<br>";
        GetWeaponDetails($Area["Sys"]["wepa"],'FortDfltWep');
        echo "防禦武器: $FortDfltWep[name]<br>";
        echo "<input type=submit value=佔領此區域 onClick=\"return cfmOccupy()\">";
        echo "</td></tr>";
        echo "</form></table>";
        }
        elseif ($actionb == 'B'){

        $HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 成功把 $Gen[coordinates] 區域佔領了！";
        WriteHistory($HistoryWrite);

        unset($sql,$query);
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `hpmax` = '".$Area["Sys"]["hpmax"]."' ,`hp`=`hpmax` ,`at` ='".$Area["Sys"]["at"]."', `de` ='".$Area["Sys"]["de"]."', `ta` ='".$Area["Sys"]["ta"]."', `wepa` ='".$Area["Sys"]["wepa"]."', `occupied` = '$Game[organization]' WHERE `map_id` = '$Gen[coordinates]' LIMIT 1;");
        $query = mysql_query($sql) or die(mysql_error());

        unset($sql);
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`-".$Area["Sys"]["occprice"].", `optmissioni` = '', `opttime` = '', `optstart` = '', `operation` = '' WHERE `id` = '$Game[organization]' LIMIT 1;");
        mysql_query($sql);unset($sql);
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `optmissioni` = '', `opttime` = '', `optstart` = '', `operation` = '' WHERE `optmissioni` = '$Gen[coordinates]'");
        mysql_query($sql);
		
		$cancel = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET protect='0' WHERE `map_id` = '$Gen[coordinates]'");
        mysql_query($cancel);

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">成功佔領此區域！<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
        }

        else {echo "未定義動作！";}
}//End of TakeCity

elseif ($mode == 'GiveUp'){
        echo "<font style=\"font-size: 12pt\">放棄佔領區域</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if (!$Game['organization'] || !$Game['rights']){echo "你的權力不足。";postFooter;exit;}
        $Area = ReturnMap("$Gen[coordinates]");
        if (ereg_replace('(Atk=\()|\)','',$Pl_Org['optmissioni']) != $Gen['coordinates'] && $CFU_Time > $Pl_Org['opttime'])
        {echo "無法放棄佔領，沒有對此地區發動佔領。";postFooter();exit;}

        if ($actionb == 'A'){
        echo "<form action=organization.php?action=GiveUp method=post name=mainform>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        echo "<script language=\"Javascript\">";
        echo "function cfmGiveup(){";
        echo "if (confirm('放棄佔領此區域嗎？')==true){return true;}";
        echo "else {return false;}";
        echo "}</script>";
        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">佔領此區域: </b></td></tr>";

        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">區域: $Gen[coordinates]</b><br>";
        echo "國家資金: ".number_format($Pl_Org['funds'])."元<br>";
        echo "放棄佔領費用: 1,000,000元<br>";
        echo "<input type=submit value=放棄佔領此區域 onClick=\"return cfmGiveup()\">";
        echo "</td></tr>";
        echo "</form></table>";
        }
        elseif ($actionb == 'B'){
		
		$checkt = ("SELECT `opttime` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `name` = '$Pl_Org[name]'");
        $qcheck = mysql_query($checkt) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
        $times = mysql_fetch_array($qcheck);
		
		if($times['opttime'] < $CFU_Time){
			$fee = 0;
			$text = "放棄已過時的戰爭，無須繳交投降費用。";
		} else if($times['opttime'] > $CFU_Time){
			$fee = 1000000;
			$text = "繳交投降費用 $1000000。";
		}
		
        $HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 放棄佔領 $Gen[coordinates] 區域了！";
        WriteHistory($HistoryWrite);

        $upsql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `optmissioni` = '', `opttime` = '0', `optstart` = '0', `operation` = '', `funds` = funds-$fee, lastopt='0' WHERE `name` = '$Pl_Org[name]'");
        mysql_query($upsql);
		
		$cancel = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET protect='0' WHERE `map_id` = '$Gen[coordinates]'");
        mysql_query($cancel);

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">已放棄佔領此區域！<br> $text <br><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
        }

        else {echo "未定義動作！";}
}//End of GiveUp

else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>