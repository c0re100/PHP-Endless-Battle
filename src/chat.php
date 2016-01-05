<?php
//-------------------------//-------------------------//-------------------------//
//----------------------------         php-eb        ----------------------------//
//-------------------------  Chat System Version 1.40  --------------------------//
//---------------------------   Official Open Build   ---------------------------//
//-------------------------//-------------------------//-------------------------//
if (isset($_GET['action'])) $mode = $_GET['action'];
elseif (isset($_POST['action'])) $mode = $_POST['action'];
else $mode = '';

$ErrMsg = (isset($ErrMsg)) ? (String) "$ErrMsg" : '';

include('cfu.php');


if(empty($rmPrcV)){
	// Date in the past
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	// always modified
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
 	// HTTP/1.1
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	// HTTP/1.0
	header("Pragma: no-cache");
	session_name("php-eb_Session");
	session_set_cookie_params(0,mktime(0,0,0,12,31,2010),"/","php-eb_Gen_Session_hd47ula");
	session_save_path("phpeb_session_dir");
	session_start();
	session_register("session_un");
	session_register("session_pwd");
	session_destroy();
	echo "<html>";
	echo "<head>";
	echo "<meta http-equiv=\"Pragma\" content=\"no-cache\">";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">";
	echo "<title>Endless Battle ~ php-eb - &copy; 2005-2008 v2Alliance</title>";
	echo "</head>";
}

if(!$mode){
	if (strpos($HTTP_USER_AGENT, 'MSIE') !== false) $mode = 'default';
	else $mode = "loginA";
}
if($mode == 'loginA'){
echo "<frameset rows='270,*' framespacing=0 border=0 frameborder=0><frame name=\"chatmain\" scrolling=\"no\" src=\"chat.php?action=loginB\">";
echo "<frame name=\"proc\" scrolling=\"auto\" src=\"chat.php?action=loginC\"></frameset></html>";
exit;
}
if($mode == 'loginC'){
echo "<body bgcolor=\"#000000\">";exit;
}
if($mode == 'loginB'){
echo "<script language=\"Javascript\">";
echo "function proc(){document.procer.namep.value=document.chatmainer.namec.value;document.procer.passp.value=document.chatmainer.passc.value;procer.submit();}";
echo "</script>";
echo "<body bgcolor=\"#000000\" text=#FFFFFF link=#FFFFFF style=\"margin:0px 0px 0px 0px;\" oncontextmenu=\"return false;\">";
echo "<form action=chat.php?action=entchat method=post name=chatmainer target=chatmain>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<div align=center style=\"font-size:50px;font-family: 'Milano LET';color:#505050;filter:alpha(opacity=100,finishopacity=0,style=2);height:40px;background-color:#fff0f0;\">";
echo "<b>php-eb Chatroom</b></div><hr style=\"filter: alpha(opacity=100,finishopacity=10,style=2);\">";
echo "<table align=center border=1 cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
echo "<tr>";
echo "<td colspan=2 align=center style=\"font-size: 12pt;font-weight: Bold;\">登入聊天室系統</td>";
echo "</tr><tr>";
echo "<td align=right>使用者名稱:</td>";
echo "<td><input type=text name=Pl_Value[USERNAME] id=namec style=\"height:21px; color:white; font-size:16px; background: transparent; border:0px solid; \" size=\"20\"></td>";
echo "</tr><tr>";
echo "<td align=right>密碼:</td>";
echo "<td><input type=password name=Pl_Value[PASSWORD] id=passc  style=\"height:21px; color:white; font-size:16px; background: transparent; border:0px solid; \" size=\"20\"></td>";
echo "</tr><tr><td colspan=2 align=center>";
echo "<input type=submit value=\"登入\" onClick=\"proc();\">";
echo "</td></tr></table>";
echo "</form>";
echo "<form action=chat.php?action=display method=post name=procer target=proc>";
echo "<input type=hidden value='' name=Pl_Value[USERNAME] id=namep>";
echo "<input type=hidden value='' name=Pl_Value[PASSWORD] id=passp>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
exit;
}
if($mode != 'RemoteDisplay'){
		$sql_ugnrli = ("SELECT username, password FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE username='". $Pl_Value['USERNAME'] ."'");
		$UsrGenrl_Qr = mysql_query ($sql_ugnrli) or die ('錯誤！<br>未能連接到SQL資料庫(PHPEB_ERROR: 001)'.$GLOBALS['DBPrefix'].':' . mysql_error());
		$UsrGenrl = mysql_fetch_array($UsrGenrl_Qr);
		if (!$UsrGenrl['username'] || ($UsrGenrl['password'] != md5($Pl_Value['PASSWORD']) && $UsrGenrl['password'] != $Pl_Value['PASSWORD']) || $UsrGenrl['username'] != $Pl_Value['USERNAME']){
		echo "<center><br><br>使用者名稱或密碼錯誤。<a href=\"index2.php\" target='_top' style=\"text-decoration: none\">回到首頁</a>";
		postFooter();
		exit;}
}

//Start FrameSet
if($mode == 'default'){
echo "<form action=chat.php?action=entchat method=post name=chatmainer target=chatmain>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<script language=\"JavaScript\">setTimeout(\"chatmainer.submit()\",0);</script>";
echo "</form>";
echo "<form action=chat.php?action=display method=post name=procer target=proc>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<script language=\"Javascript\">";
echo "setTimeout(\"procer.submit()\",0);";
echo "</script>";
echo "<frameset rows='270,*' framespacing=0 border=0 frameborder=0><frame name=\"chatmain\" scrolling=\"no\" src=\"chat.php?action=entchat&usr=$Pl_Value[USERNAME]&pwd=$Pl_Value[PASSWORD]\">";
echo "<frame name=\"proc\" scrolling=\"auto\" src=\"chat.php?action=display&usr=$Pl_Value[USERNAME]&pwd=$Pl_Value[PASSWORD]\"></frameset></html>";
exit;
}

if(empty($rmPrcV)){
	echo "<style type=\"text/css\">BODY {SCROLLBAR-FACE-COLOR: #ffffff;SCROLLBAR-3DLIGHT-COLOR: #d0d0d0; SCROLLBAR-ARROW-COLOR: #000000;  SCROLLBAR-HIGHLIGHT-COLOR: #A0A0A0;SCROLLBAR-TRACK-COLOR: #000000; SCROLLBAR-DARKSHADOW-COLOR: #000000; SCROLLBAR-BASE-COLOR: #505050;FONT-SIZE: 10px; FONT-FAMILY: \"Arial\",  \"新細明體\"; cursor:default}TD {FONT-SIZE: 9pt; FONT-FAMILY: \"Arial\", \"新細明體\"}A:visited {COLOR: #FFFFFF;}</style>";
	if (empty($withoutbody)) echo "<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" oncontextmenu=\"return false;\">";
}

if($mode == 'entchat'){

	echo "<form action=chat.php?action=speak method=post name=chatenter target=proc>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='0' name=tempvar>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<div align=center style=\"font-size:50px;font-family: 'Milano LET';color:#505050;filter:alpha(opacity=100,finishopacity=0,style=2);height:40px;background-color:#fff0f0;\">";
	echo "<b>php-eb Chatroom</b></div><hr style=\"filter: alpha(opacity=100,finishopacity=10,style=2);\">";

//Draw Table for Entering Text
	echo "<style type=\"text/css\">.sc {SCROLLBAR-FACE-COLOR: #ffffff;SCROLLBAR-3DLIGHT-COLOR: #d0d0d0; SCROLLBAR-ARROW-COLOR: #000000;  SCROLLBAR-HIGHLIGHT-COLOR: #A0A0A0;SCROLLBAR-TRACK-COLOR: #000000; SCROLLBAR-DARKSHADOW-COLOR: #000000; SCROLLBAR-BASE-COLOR: #505050;}</style>";


	echo "<script language=\"Javascript\">";
	echo "function hideSelect(ob){";
	echo "if(ob == 'players'){selcol.style.visibility='visible';selcol.style.position='relative';chatenter.org.style.visibility='hidden';chatenter.org.style.position='absolute';chatenter.players.style.visibility='visible';chatenter.players.style.position='relative';chatenter.entname.style.visibility='visible';chatenter.entname.style.position='relative';}";
	echo "else if(ob == 'org'){chatenter.entname.style.visibility='hidden';chatenter.entname.style.position='absolute';selcol.style.visibility='visible';selcol.style.position='relative';chatenter.players.style.visibility='hidden';chatenter.players.style.position='absolute';chatenter.org.style.visibility='visible';chatenter.org.style.position='relative';}";
	echo "else{selcol.style.visibility='hidden';chatenter.entname.style.visibility='hidden';chatenter.entname.style.position='absolute';selcol.style.position='absolute';chatenter.players.style.visibility='hidden';chatenter.players.style.position='absolute';chatenter.org.style.visibility='hidden';chatenter.org.style.position='absolute';}";
	echo "}function vldSubmit(){";
	echo "if (!chatenter.message.value){alert(\"請輸入你的說話。\");return false;}";
	echo "else if (chatenter.tempvar.value == 1 && !chatenter.players.value && (!chatenter.entname.value || chatenter.entname.value == '<<手動輸入>>')){alert(\"請指定說話目標人物。\");return false;}";
	echo "else if (chatenter.tempvar.value == 2 && !chatenter.org.value){alert(\"請指定說話目標組織。\");return false;}";
	echo "else {chatenter.action='chat.php?action=speak';chatenter.SbmtBtn.value='請稍等 ".$SpeakIntv." 秒...';chatenter.SbmtBtn.disabled=true;chatenter.submit();chatenter.message.value='';setTimeout(\"chatenter.SbmtBtn.disabled=false;chatenter.SbmtBtn.value='確 認 送 出';\",".round($SpeakIntv*1000).");}}</script>";

	echo "<table align=center border=1 cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr width=300>";
	echo "<td colspan=4>";
	echo "&nbsp;聊天系統";
	echo "</td>";
	echo "<td rowspan=4 valign=top align=left width=150 id=selcol style=\"visibility:hidden;position:absolute\">";
	echo "<select name=players size=10 class=sc style=\"visibility:hidden;position:absolute;width: 100%;font-size: 9pt; color: #ffffff; background-color: #000000;\">";

	$SQL_Users = ("SELECT `username`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` != '$Pl_Value[USERNAME]' ORDER BY `gamename`");
	$Query_Users = mysql_query($SQL_Users);

	while($Users = mysql_fetch_row($Query_Users)){
	echo "<option value='".$Users[0]."'>".$Users[1].' ';}
	echo "</select><input type=text name=\"entname\" value=\"<<手動輸入>>\" style=\"visibility:hidden;position:absolute;width: 100%;font-size: 9pt; color: #ffffff; background-color: #000000;text-align: center\" onfocus=\"this.value='';this.style.textAlign='left'\" onmouseover=\"this.style.color='yellow'\" onmouseout=\"this.style.color='FFFFFF'\">";

	$SQL_Orgs = ("SELECT `id`,`name` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization`");
	$Query_Orgs = mysql_query($SQL_Orgs);

	echo "<select name=org size=12 class=sc style=\"visibility:hidden;position:absolute;width: 100%;font-size: 9pt; color: #ffffff; background-color: #000000;\">";

	while($Orgs = mysql_fetch_row($Query_Orgs)){
	echo "<option value='".$Orgs[0]."'>".$Orgs[1].' ';}

	echo "</select>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan=4 style=\"border-bottom-style:none;\">";
		echo "&nbsp;請輸入你的說話: <br><center><textarea class=sc name=\"message\" rows=5 wrap=\"hard\" cols=36 style=\"font-size: 9pt; color: #ffffff; border: 1px solid;border-color: #7F7F7F; background-color: #000000;\">";
		echo "</textarea></center>";
	echo "說話對象:</td>";
	echo "</tr>";
	echo "<tr style=\"padding-left: 8px\"><td style=\"border-bottom-style:none;border-top-style:none;border-right-style:none;\"><input checked type=radio value='0' name=type onClick=\"hideSelect('');tempvar.value='0';\">全頻</td>";
	echo "<td style=\"border-bottom-style:none;border-top-style:none;border-left-style:none;border-right-style:none;\"><input type=radio value='1' name=type onClick=\"hideSelect('players');tempvar.value='1';\">玩家</td>";
	echo "<td style=\"border-bottom-style:none;border-top-style:none;border-left-style:none;border-right-style:none;\"><input type=radio value='2' name=type onClick=\"hideSelect('org');tempvar.value='2';\">組織</td>";
	echo "<td style=\"border-bottom-style:none;border-top-style:none;border-left-style:none;\"><input type=radio value='3' name=type onClick=\"hideSelect('');tempvar.value='3';\" disabled>拍賣</td></tr>";

	echo "<tr><td colspan=4 style=\"border-top-style:none;\" align=center><input style=\"font-size: 9pt; color: #ffffff; background-color: #000000;\" type=button value='確 認 送 出' onClick='vldSubmit();' onmouseover=\"this.style.color='yellow'\" onmouseout=\"this.style.color='FFFFFF'\" name=SbmtBtn>";
	echo "<input style=\"font-size: 9pt; color: #ffffff; background-color: #000000;\" type=button value='刷 新 資 訊' onClick=\"chatenter.action='chat.php?action=display';chatenter.submit()\" onmouseover=\"this.style.color='yellow'\" onmouseout=\"this.style.color='FFFFFF'\"></td></tr>";

	echo "</table>";

	echo "<hr style=\"filter: alpha(opacity=100,finishopacity=10,style=2);\">";
}
elseif($mode == 'speak' || $mode == 'display'){
	if(empty($rmPrcV)){
	echo "<form action=chat.php?action=speak method=post name=chatenter target=proc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<script language=\"Javascript\">";
	echo "setTimeout(\"chatenter.submit()\",".intval($ChatAutoRefresh*1000).");";
	echo "</script>";
	}

	if ($ChatSave){
	$Del_Prep = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_chat` WHERE $CFU_Time - c_time > $ChatSave");
	mysql_query($Del_Prep);}

if($mode == 'speak'){
unset($M,$T);
$type = (isset($type)) ? $type : '';
if (empty($message)){$ErrMsg = "請輸入你的說話。<br>";}
if ($type == 1 && !$players && (!$entname || $entname == '<<手動輸入>>'))$ErrMsg .= "請指定說話目標人物。<br>";
elseif ($type == 2 && !$org && $org != 0)$ErrMsg .= "請指定說話目標組織。<br>";}
if (!$ErrMsg && $mode == 'speak'){
	$players = (isset($players)) ? $players : '' ;
	if(strpos($message,'phpeb_user_') !== false || strpos($message,'phpeb_sys_') !== false) {echo "<center><br><br>Fatal Error<br><br>";exit;}
	$FormStr = array("\t",'   ','  ','"',"'",
			'<','>','-','+','*',
			',','.',
			'(',')','低能仔','八公','八婆','你媽媽','媽的','女馬白勺','幹',
			'屌鳩','仆街','屌','撚','仆','你老母','您老母',
			'@@@@@');
	$ToStr = array(	'&nbsp; &nbsp; &nbsp; &nbsp; ','&nbsp; &nbsp;','&nbsp;&nbsp;','&quot;','&#39;',
			'&lt;','&gt;','&#45;','&#43;','&#42;',
			'&#44;','&#46;',
			'&#40;','&#41;','','','','','','','',
			'','','','','','','',
			' ');
	$M = nl2br(str_replace($FormStr,$ToStr,$message));
	$message = addslashes($message);
	$M = preg_replace("/((f.ck)|(fu.k)|(fuc.)|(shit)|(sh\|t)|(sh1t)|(shlt)|(fxxk)|(sucker)|(bitch)|(asshole)|(fucker)|(motherfucker))+/i",' ',$M);
	if($type == 1){
		$restriction = array("|","`","'","--","\"","\\");
		$entname = str_replace($restriction,'',$entname);
		$players = str_replace($restriction,'',$players);
		if ($entname && $entname != '<<手動輸入>>') {
			$PrepSQL = ("SELECT `username` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `gamename` = '".($entname)."' LIMIT 1;");
			$SelNameQuery = mysql_query($PrepSQL);
			$SelName = mysql_fetch_row($SelNameQuery) or die("沒有此人物名稱");
			$T = $SelName[0];
		}
		else $T = "$players";
	}
	elseif($type == 2) $T = "$org";
	else {$type = 0;$T = '';}

	$SQL_Prep = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_chat` (`c_user`, `c_time` , `c_msg` , `c_type` , `c_tar` ) VALUES ('$Pl_Value[USERNAME]', '$CFU_Time', '$M', '$type', '$T');");
	mysql_query($SQL_Prep);

	if(isset($rmPrcV)){
		$rmAf = $rmChatAutoRefresh * 5;
		echo "<script language=\"JavaScript\">";
		echo "parent.document.chatUpdate = ".intval($rmAf + 100).";";
		echo "parent.document.chatSpeaker.message.value = '';";
		echo "parent.document.chatSpeaker.message.style.visibility = 'visible';";
		echo "parent.document.chatUpdater.lastCID.value = 'last';";
		echo "parent.document.chatUpdater.submit();";
		echo "parent.document.chatUpdate = 0;";
		echo "parent.chatDisplay_frame.document.getElementById('rmCht_Display').doScroll(\"pageDown\");";
		echo "parent.document.chatSpeaker.message.focus();";
		echo "parent.document.chatSpeaker.message.click();";
		echo "</script>";
		exit;
	}
}
//Start Viewing Section

	$L = (isset($LiS))?intval($LiS):'0';
	$U = (isset($UiS))?intval($UiS):"$ChatShow";

	$SQL_PlData = ("SELECT `g`.`username` name,`organization` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` g,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` n WHERE `g`.`username` = `n`.`username` AND `g`.`username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	$PlData_Query = mysql_query($SQL_PlData);
	$User = mysql_fetch_array($PlData_Query);

	$SQL_ChatData_All = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_chat` WHERE `c_type` = 0 ORDER BY `c_time` DESC LIMIT $L , $U ");
	$ChatData_All_Query = mysql_query($SQL_ChatData_All);

	$SQL_ChatData_Priv = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_chat` WHERE ((`c_tar` = '$User[name]' OR `c_user` = '$User[name]') AND `c_type` = 1) ORDER BY `c_time` DESC LIMIT $L , $U ");
	$ChatData_Priv_Query = mysql_query($SQL_ChatData_Priv);

	$SQL_ChatData_Orgz = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_chat` WHERE ((`c_tar` = '$User[organization]' OR `c_user` = '$User[name]') AND `c_type` = 2) ORDER BY `c_time` DESC LIMIT $L , $U ");
	$ChatData_Orgz_Query = mysql_query($SQL_ChatData_Orgz);

	unset($MsgShow,$MSC);
	$MsgShow = array();
	$MSC = 0;

	//All Msg

	while($ChatData_All = mysql_fetch_array($ChatData_All_Query)){
	if ($ChatData_All['c_user'] != $Pl_Value['USERNAME'])
	$Apre = ("SELECT `gamename`,`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` b WHERE `a`.`username` = `b`.`username` AND `a`.`username` = '$ChatData_All[c_user]'");
	elseif ($ChatData_All['c_user'] == $Pl_Value['USERNAME'])
	$Apre = ("SELECT `gamename`,`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` b WHERE `a`.`username` = `b`.`username` AND `a`.`username` = '$ChatData_All[c_tar]'");
	$Aq = mysql_query($Apre) or die(mysql_error());
	$A = mysql_fetch_row($Aq);
	$MSC ++;
	$MsgShow["gen"] = "<br><div style=\"font-size: 10pt;margin-left: 10px;width: 100%\">$ChatData_All[c_msg]</div></font><hr width=50% align=left style=\"filter: alpha(opacity=100,finishopacity=10,style=1);\">";

	if ($ChatData_All['c_user'] == $Pl_Value['USERNAME'])
		$MsgShow["All"][$MSC] = cfu_time_convert($ChatData_All['c_time'])." 你對全部人說:<font color=coral><B>".$MsgShow["gen"]."</b>";
	else	$MsgShow["All"][$MSC] = cfu_time_convert($ChatData_All['c_time'])." <font color=$A[1]>$A[0]</font> 對全部人說:<font color=$A[1]>".$MsgShow["gen"];

	unset($Apre,$Aq,$A);
	}

	while($ChatData_Priv = mysql_fetch_array($ChatData_Priv_Query)){
	if ($ChatData_Priv['c_user'] != $Pl_Value['USERNAME'])
	$Apre = ("SELECT `gamename`,`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` b WHERE `a`.`username` = `b`.`username` AND `a`.`username` = '$ChatData_Priv[c_user]'");
	elseif ($ChatData_Priv['c_user'] == $Pl_Value['USERNAME'])
	$Apre = ("SELECT `gamename`,`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` b WHERE `a`.`username` = `b`.`username` AND `a`.`username` = '$ChatData_Priv[c_tar]'");
	$Aq = mysql_query($Apre) or die(mysql_error());
	$A = mysql_fetch_row($Aq);
	$MSC ++;
	$MsgShow["gen"] = "<br><div style=\"font-size: 10pt;margin-left: 10px;width: 100%\">$ChatData_Priv[c_msg]</div></font><hr width=50% align=left style=\"filter: alpha(opacity=100,finishopacity=10,style=1);\">";

	if ($ChatData_Priv['c_user'] == $Pl_Value['USERNAME'])
		$MsgShow["Priv"][$MSC] = cfu_time_convert($ChatData_Priv['c_time'])." 你對 <font color=$A[1]>$A[0]</font> 俏俏話:<font color=coral><b>".$MsgShow["gen"]."</b>";
	else 	$MsgShow["Priv"][$MSC] = cfu_time_convert($ChatData_Priv['c_time'])." <font color=$A[1]>$A[0]</font> 對你俏俏話:<font color=$A[1]>".$MsgShow["gen"];

	unset($Apre,$Aq,$A);
	}

	while($ChatData_Orgz = mysql_fetch_array($ChatData_Orgz_Query)){
	$Apre = ("SELECT `name`,`o`.`color`,`gamename`,`g`.`color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` o,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` n,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` g WHERE `id` = '$ChatData_Orgz[c_tar]' AND `g`.`username`=`n`.`username` AND `g`.`username`='$ChatData_Orgz[c_user]'");
	$Aq = mysql_query($Apre) or die(mysql_error());
	$A = mysql_fetch_row($Aq);
	$MSC ++;
	$MsgShow["gen"] = "<br><div style=\"font-size: 10pt;margin-left: 10px;width: 100%\">$ChatData_Orgz[c_msg]</div></font><hr width=50% align=left style=\"filter: alpha(opacity=100,finishopacity=10,style=1);\">";

	if ($ChatData_Orgz['c_user'] == $Pl_Value['USERNAME'])
		$MsgShow["Orgz"][$MSC] = cfu_time_convert($ChatData_Orgz['c_time'])." 你對 <font color=$A[1]>$A[0]</font> 說:<font color=coral><b>".$MsgShow["gen"]."</b>";
	else  	$MsgShow["Orgz"][$MSC] = cfu_time_convert($ChatData_Orgz['c_time'])." <font color=$A[3]>$A[2]</font> 對 <font color=$A[1]>$A[0]</font> 說:<font color=$A[3]>".$MsgShow["gen"];

	unset($Apre,$Aq,$A);
	}

	echo "<table width=100% border=2 bordercolor=\"#D4D4D4\">";
	echo "<tr width=100% valign=top><td width=33%><center><font size=3 color=khaki>———組織頻道———</center></font><hr>";
	if(isset($MsgShow["Orgz"]) && is_array($MsgShow["Orgz"]))
		foreach($MsgShow["Orgz"] as $M_Show_Orgz) echo $M_Show_Orgz;
	else	echo "(沒有)";
	echo "</td><td width=34%><center><font size=3 color=khaki>———公開頻道———</center></font><hr>";
	if(isset($MsgShow["All"]) && is_array($MsgShow["All"]))
		foreach($MsgShow["All"] as $M_Show_All) echo $M_Show_All;
	else	echo "(沒有)";
	echo "</td><td width=33%><center><font size=3 color=khaki>———私人頻道———</center></font><hr>";
	if(isset($MsgShow["Priv"]) && is_array($MsgShow["Priv"]))
		foreach($MsgShow["Priv"] as $M_Show_Priv) echo $M_Show_Priv;
	else	echo "(沒有)";
	echo "</td></tr></table>";
}
//Remote Chat Function - Impletementation of php-eb UE v1.0
//Requires Full Linkage of cfu.php
elseif($mode == 'RemoteDisplay' && $actionb == 'fetch'){
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
	$update = '';echo "$lastCID<hr>";
	if($lastCID != 'new'){
		if($lastCID != 'last'){
			$lastCID = intval($lastCID);
			$sql = ("SELECT `c_id`,`c_msg`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_chat`, `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` = `c_user` AND `c_id` > $lastCID ORDER BY `c_id` ASC");
		}
		else
		$sql = ("SELECT `c_id`,`c_msg`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_chat`, `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` = `c_user` ORDER BY `c_id` DESC LIMIT 1;");
		$query = mysql_query($sql);
		if(mysql_num_rows($query) > 0){
			while($cht = mysql_fetch_array($query)){
				$update .= '<font color=ForestGreen><b>'.$cht['gamename'].'</b>: '.preg_replace('/(<br>|<br( )*\/>)+/i','&nbsp;',$cht['c_msg']).'</font><br>';
				$New_lastCID = $cht['c_id'];
			}
		}else $New_lastCID = $lastCID;
	}elseif($lastCID == 'new'){
		$sql = ("SELECT `c_id` FROM `".$GLOBALS['DBPrefix']."phpeb_chat` ORDER BY `c_id` DESC LIMIT 1;");
		$query = mysql_query($sql);
		$cht = mysql_fetch_array($query);
		$New_lastCID = $cht['c_id'];
	}
	//JavaScript AutoUpdate
		echo "<script language=\"JavaScript\">";
		if($lastCID == 'new' || $lastCID == 'last')
		echo "if(parent.document.getElementById('rmCht_Tar').style.visibility == 'hidden') parent.document.getElementById('rmCht_Tar').style.visibility = 'visible';";
		echo "var msgStr = '';";
		echo "msgStr = parent.chatDisplay_frame.document.getElementById('rmCht_Display').innerHTML;";
		echo "msgStr = msgStr + '".$update."';";
		echo "parent.chatDisplay_frame.document.getElementById('rmCht_Display').innerHTML = msgStr;";
		echo "parent.document.chatUpdater.lastCID.value = '".$New_lastCID."';";
		echo "parent.chatDisplay_frame.scroll(0, 9999);";
		echo "</script>";
	//End
	exit;
}
elseif($mode == 'RemoteDisplay' && $actionb == 'baseline'){
	echo "<div id=\"rmCht_Display\" style=\"height: 205; width: 775\"></div>";
	exit;
}
else{
echo "<center><hr>$ErrMsg<hr>";
}
postFooter();
exit;
?>