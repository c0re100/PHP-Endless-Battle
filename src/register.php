<?php
include('cfu.php');
if (empty($CFU_RegLowerCaseOnly)) $CFU_RegLowerCaseOnly = '1';
?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>User Registration - 用戶註冊</title>
</head>

<?php

function reg_pFoot(){
	$mcfu_time = explode(' ', microtime());
	$cfu_ptime = number_format(($mcfu_time[1] + $mcfu_time[0] - $GLOBALS['cfu_stime']), 6);
	echo "<p align=center style=\"font-size: 10pt\">Registration System - v0.5 Version";
	echo "<br>&copy; 2005-2006 v2Alliance. All Rights Reserved.　版權所有 不得轉載<br>";
	if ($GLOBALS['Show_ptime'])
	echo "<font style=\"font-size: 7pt\">Processed in ".$cfu_ptime." second(s).</font></p>";
}

//Anti-Direct Connection
if (!$disabled_AUC){
	if (strpos($HTTP_REFERER,'index2.php') === false && strpos($HTTP_REFERER,'register.php') === false){
	echo "Unauthorized Connection Detected<br>Referer: $HTTP_REFERER<br>";
	echo "IP: $REMOTE_ADDR Logged<br>";
	postFooter();
	$contents = '/*'."Date: `$CFU_Date' \n Logged Username: `$Pl_Value[USERNAME]' \t\t Logged Password: `$Pl_Value[PASSWORD]'\n";
	$contents .= "IP: `$REMOTE_ADDR' \t\t Referer: `$HTTP_REFERER'\n";
	$contents .= "REQUEST_METHOD: `$REQUEST_METHOD' \t\t SCRIPT_FILENAME: `$SCRIPT_FILENAME' \nQUERY_STRING: `$QUERY_STRING '\n";
	$contents .= '_______________________________________________________';
	$contents .= '_______________________________________________________*/'."\n";
	$fp = fopen($AUC_Log,"r+");
	fwrite($fp,$contents);
	fclose($fp);
	exit;
	}
}

if ($MAX_PLAYERS){
$NumPlSQL = ("SELECT count(*) FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `regkey` != 'npc';");
$NumPlSQL_Query = mysql_query($NumPlSQL);
$NumPl = mysql_fetch_row($NumPlSQL_Query);
	if ($NumPl[0] >= $MAX_PLAYERS){
		echo "<center><br><br>登錄人數太多。<br>現登錄人數: $OnlinePlNum[0]<br>登錄人數上限: $MAX_PLAYERS<br><a href=\"index2.php\" target='_top' style=\"text-decoration: none\">回到首頁</a><br><br>";
		postFooter();exit;
	}
}

if ($OLimit){
	$Online_Time = time() - $Offline_Time;
	$OnlineSQL = ("SELECT count(time2) FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `time2` > '$Online_Time' AND `regkey` != 'npc';");
	$OnlineSQL_Query = mysql_query($OnlineSQL);
	$OnlinePlNum = mysql_fetch_row($OnlineSQL_Query);
		if ($OnlinePlNum[0] >= $OLimit){
			echo "<center><br><br>上線人數太多。<br>現上線人數: $OnlinePlNum[0]<br>上線人數上限: $OLimit<br><a href=\"index2.php\" target='_top' style=\"text-decoration: none\">回到首頁</a><br><br>";
			postFooter();exit;
		}
}

$REGISTER_S1 = (isset($REGISTER_S1)) ? $REGISTER_S1 : 0;
if (!$REGISTER_S1){
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br><a href=\"index2.php\" target='_top' style=\"text-decoration: none\">回到首頁</a>";exit;}
echo "<script langauge=\"Javascript\">";
echo "window.status ='";
if ($MAX_PLAYERS)
echo "　登錄人數: ".$NumPl[0]."/".$MAX_PLAYERS;
if ($OLimit)
echo "　上線人數: ".$OnlinePlNum[0]."/".$OLimit;

echo "';";
	$restriction = array("|","`","'","--","\"","\\");
echo "
function checkGname(name){
	if(name == '') return false;
	else if(name.match(/['\"|\\\`(--)]+/g)) return false;
	else if(name.match(/^0.*/g)) return false;
	return true;
}
function checkC(str){
		var word = str;
		if(word.match(/^0.*/g)) return false;
		for(var c = 0 ; c < word.length ; c++){
			var code = word.charAt(c);
			if((code >= '0') && (code <= '9')){
				continue;
			}
			else if((code >= 'a') && (code <= 'z')){
				continue;
			}";
if(!$CFU_RegLowerCaseOnly)
echo "			else if((code >= 'A') && (code <= 'Z')){
				continue;
			}";
echo "			else{
				return false;
			}
		}
		return true;
	}
function checkRegister(){
	if (document.regform.reg_username.value ==''){alert('請輸入使用者名稱。');return false}
	else if(checkGname(document.regform.reg_gamename.value) == false){alert('遊戲內的名稱出錯。\\n請確定名稱沒含有「\\\」, 「|」, 「`」, 「\\'」,「\"」');return false}
	else if(document.regform.reg_password.value ==''){alert('請輸入密碼。');return false}
	else if(checkC(document.regform.reg_username.value) == false){alert('使用者名稱只可以是";if($CFU_RegLowerCaseOnly) echo "小寫";echo "英文字母與數字組成！\\n而且不能以「0」開首！');return false;}
	else if(checkC(document.regform.reg_password.value) == false){alert('密碼只可以是";if($CFU_RegLowerCaseOnly) echo "小寫";echo "英文字母與數字組成！\\n而且不能以「0」開首！');return false;}
	else if(document.regform.reg_password.value != document.regform.reg_passwordconf.value){alert('重新輸入的密碼不相同，請重新輸入。');return false;}
	else if(pt_cal.innerHTML != 22){alert('能力點數合計不是22！');return false;}
	else {if (confirm('以上資料皆正確、可以開始登錄嗎？') == true){return true}else {return false}}
}
function calstatpt(){
	var At = 1*(document.regform.reg_at.value);
	var De = 1*(document.regform.reg_de.value);
	var Ta = 1*(document.regform.reg_ta.value);
	var Re = 1*(document.regform.reg_re.value);
	var statsum = At;
	statsum += De;
	statsum += Ta;
	statsum += Re;
	pt_cal.innerHTML = statsum;
	pt_cal.style.color='blue';
	if (statsum > 22){pt_cal.style.color='red';}
	if (statsum == 4){pt_cal.style.color='white';}
	if (statsum == 22){pt_cal.style.color='yellow';}

	}
</script>
<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" style=\"font-family: Arial\" oncontextmenu=\"return false;\">

<p align=\"center\" style=\"font-size: 18pt;font-weight: 800\">User Registration - 用戶註冊</p>
<form action=register.php method=POST name=regform>
<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">
  <center>
  <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"80%\" id=\"AutoNumber1\">
    <tr>
      <td width=\"33%\" style=\"font-size: 12pt;font-weight: 800\">ID:";if($CFU_RegLowerCaseOnly) echo "<font style=\"font-size: 9pt\">(只能用小寫英文字母及數字)</font>";echo "<br><input type=text name=reg_username maxlength=16></td>
      <td width=\"33%\" rowspan=\"4\" align=center><input type=\"submit\" name=\"Form[Submitbutton]\" value =\"Register - 註冊\" onClick=\"return checkRegister()\"></td>
      <td width=\"34%\" rowspan=\"4\">&#12288;</td>
    </tr>
    <tr>
      <td width=\"33%\" style=\"font-size: 12pt;font-weight: 800\">Game Name:<font style=\"font-size: 9pt\">(角色名稱)</font><br><input type=text name=reg_gamename maxlength=16></td>
    </tr>
    <tr>
      <td width=\"33%\" style=\"font-size: 12pt;font-weight: 800\">Password:<font style=\"font-size: 9pt\">(密碼)</font><br><input type=password name=reg_password maxlength=16></td>
    </tr>
    <tr>
      <td width=\"33%\" style=\"font-size: 12pt;font-weight: 800\">Re-Enter:<font style=\"font-size: 9pt\">(重新確認密碼)</font><br><input type=password name=reg_passwordconf maxlength=16></td>
    </tr>
  </table>
  </center>

  <center>
  <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"95%\" id=\"AutoNumber2\">
    <tr>
      <td width=\"100%\" style=\"font-size: 12pt;font-weight: 800\">註冊碼: ";
if ($CFU_CheckRegKey) echo "<input type=text name=reg_key maxlength=10>";
else echo "N/A - 不適用";
echo "</td>
    </tr>
  </table>
  </center>


<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"100%\" id=\"AutoNumber3\">
  <tr rowspan=2>
    <td width=\"50%\" rowspan=\"3\" valign=top style=\"font-size: 12pt;font-weight: 800\">Color:<font style=\"font-size: 9pt\">(請挑選顏色)</font><br>";

$br=0;$ct_default=0;
foreach ($MainColors as $CVAL){$br++;$ct_default++;
echo "<input type=\"radio\" name=\"REG_VAL[COLOR]\" value=#".$CVAL;
if ($ct_default==1) echo " checked";
echo "><font color=#".$CVAL.">■</font>&nbsp;";
if ($br==6){echo"<br>";$br=0;}
}


echo "</td>
    <td width=\"33%\" style=\"font-size: 12pt;font-weight: 800\">Type:<font style=\"font-size: 9pt\">(請挑選人物類型)</font><br><select size=6 name=\"REG_VAL[TYPE]\">
    <option value='nat' selected>一般人</option>
    <option value='ext'>Extended</option>
    <option value='enh'>強化人</option>
    <option value='psy'>念動力</option>
    <option value='nt'>NT</option>
    <option value='co'>Coordinator</option>
    </select></td>
  </tr>
    <tr style=\"font-size: 10pt;\">
    <td width=\"34%\"><span lang=\"zh-tw\" style=\"font-size: 12pt;font-weight: 800\">能力點數(合計需要為22點):</span><br>攻擊技巧: <select size=1 name=\"reg_at\"  onChange=\"calstatpt()\">
    <option value='1'>1<option value='2'>2<option value='3'>3<option value='4'>4<option value='5'>5<option value='6'>6<option value='7'>7<option value='8'>8<option value='9'>9<option value='10'>10
    </select><br>防禦能力: <select size=1 name=\"reg_de\" onChange=\"calstatpt()\">
    <option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10
    </select><br>命中能力: <select size=1 name=\"reg_ta\" onChange=\"calstatpt()\">
    <option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10
    </select><br>反應力: <select size=1 name=\"reg_re\" onChange=\"calstatpt()\">
    <option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10
    </select><br>合計值: <span id=pt_cal style>4</span>
    </td>
  </tr>
</table>
<input type=hidden name=REGISTER_S1 value='1'>
</form>
</body>

";
}

elseif ($REGISTER_S1){
echo "<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" oncontextmenu=\"return false;\" style=\"font-family: Arial\">";
if ($reg_password != $reg_passwordconf) {echo "密碼不相對";
exit;
}

if ($reg_username == '<AttackFort>'){echo "名稱不可以是要塞。";exit;}
if (preg_match("/^NPC/",$reg_username)){echo "名稱不可以是NPC開首。";exit;}
if (preg_match("/^NPC/",$reg_gamename)){echo "名稱不可以是NPC開首。";exit;}
$reg_username = str_replace("[\|\`(--)]+",'',$reg_username);
if ($CFU_RegLowerCaseOnly) $reg_username = strtolower($reg_username);

if($CFU_CheckRegKey){
	if ($reg_key != $NPC_RegKey){
unset($sql);
$sql= ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_regkeys` WHERE `regkey` = ".$reg_key." ");
$RegKeyQuery = mysql_query($sql);
$numsRKey = mysql_num_rows($RegKeyQuery);
if (!$numsRKey){echo "未能取得註冊碼的資訊。";postFooter();exit;}
$RegKeyData = mysql_fetch_array($RegKeyQuery);
if ($RegKeyData['status']){echo "註冊碼已經被使用。";postFooter();exit;}
if($CFU_CheckIP){
$sql= ("SELECT count(*) FROM `".$GLOBALS['DBPrefix']."phpeb_regkeys` WHERE `ip` = ".$REMOTE_ADDR." ");
$ReadyReg = 0;
$RegKeyQuery = mysql_query($sql) or $ReadyReg = 1;
if(!$ReadyReg)
$RegKeyIPCheck = mysql_fetch_row($RegKeyQuery);
if ($RegKeyIPCheck >= 1){echo "IP已經被使用。";postFooter();exit;}
}
}}
else $reg_key = '';
$statusptmax=22;
if ($reg_at+$reg_de+$reg_ta+$reg_re != $statusptmax){
echo "能力點數總和不是 $statusptmax ！";postFooter();exit;
}
$CASH_BASE=120000;
$CASH=$CASH_BASE;
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！";exit;}
if (!preg_match('/^(nat|ext|enh|psy|nt|co)$/',$REG_VAL['TYPE'])) {echo "系統未能確認您的類型，請重新賞試。";postFooter();exit;}
else $CASH=$CASH_BASE*3;

if ($reg_at>10 || $reg_de>10 || $reg_ta>10 || $reg_re>10){echo "能力過高！";postFooter();exit;}
if ($reg_at<=0 || $reg_de<=0 || $reg_ta<=0 || $reg_re<=0){echo "能力過低！";postFooter();exit;}

$CASH=floor($CASH);
$t_now=time();

//Analyze Coordinates
mt_srand ((double) microtime()*1000000);
switch(mt_rand(0,$StartZoneRestriction)){
	case 0: $CoordinatesSt='A1';break;
	case 1: $CoordinatesSt='A2';break;
	case 2: $CoordinatesSt='A3';break;
	case 3: $CoordinatesSt='B1';break;
	case 4: $CoordinatesSt='B2';break;
	case 5: $CoordinatesSt='B3';break;
	case 6: $CoordinatesSt='C1';break;
	case 7: $CoordinatesSt='C2';break;
	case 8: $CoordinatesSt='C3';break;
	default : $CoordinatesSt='A1';break;
}
switch(mt_rand(0,3)){
	case 0: $CoordinatesSt .= 'N';break;
	case 1: $CoordinatesSt .= 'E';break;
	case 2: $CoordinatesSt .= 'S';break;
	default: $CoordinatesSt .= 'W';break;
}

	//Check Username
	$sql= ("SELECT `username` FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info`");
	$CheckUsrQ = mysql_query($sql);
	$UsrC_Halt = 0;
	while($UsrC = mysql_fetch_row($CheckUsrQ)){
		$str1 = strtoupper($reg_username);
		$str2 = strtoupper($UsrC[0]);
		if($str1 == $str2) $UsrC_Halt++;
		break;
	}
	if($UsrC_Halt) {
		echo "<p align=center>ID已有人使用<br>ID is already in use<br>ID: $reg_username";
		echo "<form action=index2.php method=post>";
		echo "<center><input type=submit value=Back name=backtoindex></form>";
		reg_pFoot();
		exit;
	}
	//Check Gamename
	$restriction = array("|","`","'","--","\"","\\");
	$reg_gamename = str_replace($restriction,'',$reg_gamename);
	$sql= ("SELECT COUNT(*) FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `gamename` = '$reg_gamename'");
	$CheckGnmQ = mysql_query($sql);
	$GnmC_Halt = 0;
	list($CountGameName) = mysql_fetch_row($CheckGnmQ);
	$GnmC_Halt += $CountGameName;

	if($GnmC_Halt) {
		echo "<p align=center>遊戲名稱已有人使用<br>Game Name is already in use<br>Game Name: $reg_gamename";
		echo "<form action=index2.php method=post>";
		echo "<center><input type=submit value=Back name=backtoindex></form>";
		reg_pFoot();
		exit;
	}

	//Enter General Info
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_general_info (username, password, regkey,cash,color,avatar,msuit,typech,growth,time1,time2,btltime,coordinates) VALUES('$reg_username',md5('$reg_password'),'$reg_key','$CASH','$REG_VAL[COLOR]','nil','0','$REG_VAL[TYPE]','0','$t_now' ,'$t_now' ,'','$CoordinatesSt')");
	mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register01)<br>原因:' . mysql_error() . '<br>');

	//Enter Game Info
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_game_info (username, gamename,attacking,defending,reacting,targeting) VALUES('$reg_username','$reg_gamename','$reg_at','$reg_de','$reg_re','$reg_ta')");
	mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register02)<br>原因:' . mysql_error() . '<br>');

	//Enter Settings
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_settings (username) VALUES('$reg_username')");
	mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register05)<br>原因:' . mysql_error() . '<br>');

	//Enter Log
	$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_log (username,log1, time1) VALUES('$reg_username','歡迎來到php-eb的世界！',UNIX_TIMESTAMP())");
	mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register03)<br>原因:' . mysql_error() . '<br>');

	//Enter Bank
	$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank` (username) VALUES('$reg_username')");
	mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register04)<br>原因:' . mysql_error() . '<br>');


	if($CFU_CheckRegKey){
	//Update Reg Key
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_regkeys` SET `username` = '$reg_username',`status`  = '1', `ip` = '$REMOTE_ADDR' WHERE  `regkey` = '$RegKeyData[regkey]' LIMIT 1 ;");
	mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register04)<br>原因:' . mysql_error() . '<br>');
	}

	echo "<p align=center>Register Complete!<br>註冊完成！<br>ID: $reg_username<br>Please Remeber Your ID!<br>請緊記您的 ID ！";
	echo "<br><br><br><font color=".$REG_VAL['COLOR'].">This is your Color! ~ 這就是您的代表顏色！</font>";
	?>
<form action=index2.php method=post>
<center><input type=submit value=Back name=backtoindex>
</form>
<?php
reg_pFoot();
}
?>




</html>