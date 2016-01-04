<?php
header('Content-Type: text/html; charset=utf-8');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser();
if ($CFU_Time >= $_SESSION['timeauth'] + $TIME_OUT_TIME || $_SESSION['timeauth'] <= $CFU_Time - $TIME_OUT_TIME) {
    echo '驗證機制！<br>請重新登入！';
    exit;
}
GetUsrDetails("$_SESSION[username]",'Gen','Game');
if ($mode == 'panel') {
	if ($Gen['acc_status'] != '9'){echo "你不是管理員！";postFooter;exit;}
	
	if ($actionb == 'A'){
	echo "<font style=\"font-size: 12pt\">管理平台</font>";
    echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
	echo "<form action=admin.php?action=panel method=post name=userlist>";
	echo "<input type=hidden name=\"ban\" value=''>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<script language=\"JavaScript\">";
	echo "function banuser(name){";
	echo "        userlist.action='admin.php?action=panel';";
	echo "        userlist.ban.value=name;";
	echo "		  userlist.submit();";
	echo "        }</script>";
	
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\"  style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\" width=\"1000px\">";
	echo "<tr align=center><td colspan=16><b>玩家列表: </b></td></tr>";
	echo "<tr align=center>";
	echo "<td width=\"100\">玩家名稱</td>";
	echo "<td width=\"40\">金錢</td>";
	echo "<td width=\"40\">懸賞</td>";
	echo "<td width=\"40\">機體</td>";
	echo "<td width=\"40\">所在位置</td>";
	echo "<td width=\"40\">名聲</td>";
	echo "<td width=\"40\">帳戶狀態</td>";
	echo "<td width=\"40\">IP地址</td>";
	echo "<td width=\"140\">最後上線時間</td>";
	echo "<td width=\"40\">操作</td>";
	echo "</tr>";
	
	$requser = ("SELECT * FROM vsqa_phpeb_user_general_info ORDER BY lastip DESC");
	$reqsql = mysql_query($requser);
	
while ($userdata = mysql_fetch_array($reqsql)){

echo "<tr align=center>";
echo "<td width=\"100\">$userdata[username]</td>";
echo "<td width=\"40\">$userdata[cash]</td>";
echo "<td width=\"40\">$userdata[bounty]</td>";
echo "<td width=\"40\">$userdata[msuit]</td>";
echo "<td width=\"40\">$userdata[coordinates]</td>";
echo "<td width=\"40\">$userdata[fame]</td>";
echo "<td width=\"60\">$userdata[acc_status]</td>";
echo "<td width=\"40\">$userdata[lastip]</td>";
$realtime = cfu_time_convert($userdata['lastlogin']);
echo "<td width=\"140\">$realtime</td>";
if($userdata['acc_status'] == '9'){
	echo "<td width=\"40\"><input type=\"submit\" value=\"管理員\" disabled></td>";
}
else
if($userdata['acc_status'] != '2'){
	echo "<td width=\"40\"><input type=\"submit\" value=\"封禁\" onclick=\"banuser('$userdata[username]');\"></td>";
}
else
if($userdata['acc_status'] == '2'){
	echo "<td width=\"40\"><input type=\"submit\" value=\"已封禁\" disabled></td>";
}


echo "</tr>";
}
	echo "</form></table>";
	}
	elseif ($actionb == 'B'){
	if ($Gen['acc_status'] != '9'){echo "你不是管理員！";postFooter;exit;}
	if ($ban == 'c0re'){echo "您無法封禁管理員！";postFooter;exit;}
	if ($ban == ''){echo "請先指定目標！";postFooter;exit;}
	echo "<font style=\"font-size: 12pt\">封禁成功</font>";
    echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
	$ban = mysql_real_escape_string($ban);
	$qban = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `acc_status`='2' WHERE `username`='$ban'");
	mysql_query($qban);
	
	echo "<font color=\"yellow\" size=\"4\">您已成功封禁玩家 <font color=red>$ban</font>！</font>";
	
	$banreq = ("SELECT gamename FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username`='$ban'");
	$banreq2 = mysql_query($banreq);
	$banreq3 = mysql_fetch_row($banreq2);
	$HistoryWrite = "<font color=\"red\" size=\"4\">系統公告：</font> <font color=\"yellow\" size=\"4\">管理員封禁玩家 $banreq3[0]。</font>";
    WriteHistory($HistoryWrite);
	
	}
	else {echo "未定義動作！";}
}
PostFooter();
?>