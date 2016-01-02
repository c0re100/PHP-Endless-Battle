<?
header('Content-Type: text/html; charset=utf-8');
//Settings
$HTTP_REFERER = '';		//請Set作可正常連線地址,cfu.php內的「$Allow_AUC」參數
//End of Settings
$NoConnect=1;
$NoCheckRef=1;
include('cfu.php');
postHead('1');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];

if (!$mode){

session_start();
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['timeauth']);

echo "<link href='$General_Image_Dir/style.css' type=text/css rel=stylesheet>";
echo "<body oncontextmenu=\"return false;\" style=\"background-image: url('$General_Image_Dir/background/atmosphere/a2.gif')\">";
echo "<base target=\"slfrm\">";

echo "<center><table width='750' height='520'><tr><td height='220'>";
//Name
echo "<div align=center style=\"font-size:70px;height:80px;background-color:transparent;\">";
echo "<b>無盡的戰鬥 PHP版</b></div>";
echo "<p align=\"right\" style=\"font-size:16px\">Base on PHP-EB v0.30</p>";
echo "<a href=\"http://ext4.me/\" target=\"_blank\"><p align=\"right\" style=\"font-size:16px\">Ext4! Beta v2.6 (20151227) Optimize: Ext4!</p></a>";

echo "<div align=right><p></p></div>";
echo "</td></tr>";
//<!---[Lower Part - Start]--->
echo "<tr height='300'><td><table width='900' height='300'><tr>";
echo "<td width=135 style=\"background-color: transparent;font-weight: Bold;filter: glow(color=#3366FF,strength=3);\">";
echo "<a href=\"http://ext4.me/forum.php?mod=viewthread&tid=7&page=1\" TARGET=\"_blank\" style='text-decoration: none;font-size:18px'>&nbsp;&nbsp;最新公告</a></p>";
echo "<a href=\"?action=Login\" style='text-decoration: none;font-size:18px'>&nbsp;&nbsp;登入遊戲</a><p>";
echo "<a href=\"?action=Pedia\" style='text-decoration: none;font-size:18px'>&nbsp;&nbsp;遊戲資料</a></p>";
//echo "<p><a href=\"stats.html\" style=\"text-decoration: none\">&nbsp;&nbsp;Game Statistics</a></p>";
echo "<p><a href=\"gen_info.php?action=history\" style='text-decoration: none;font-size:18px'>&nbsp;&nbsp;歷史消息</a></p>";
echo "<a href=\"http://ext4.me\" TARGET=\"_blank\" style='text-decoration: none;font-size:18px'>&nbsp;&nbsp;討論區</a></p>";

//Database Setting For Player Counter
$consql = mysql_connect("localhost","ebs","ebs");
mysql_select_db("ebs", $consql);
$query = mysql_query("SELECT count(username) as num FROM vsqa_phpeb_user_general_info");
$cnt = mysql_result($query, 0);
echo "<p style='color:red;text-decoration: none;font-size:16px'>&nbsp;&nbsp;註冊人數： $cnt</p>";

$Online_Time = time() - $Offline_Time;
$OnlineSQL = ("SELECT count(lastlogin) FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `lastlogin` > '$Online_Time'");
$OnlineSQL_Query = mysql_query($OnlineSQL);
$OnlinePlNum = mysql_result($OnlineSQL_Query, 0);
echo "<p style='color:red;text-decoration: none;font-size:16px'>&nbsp;&nbsp;在線人數： $OnlinePlNum</p>";
mysql_close($consql);

echo "<td width=665>";
echo "<iframe name='slfrm' src='?action=Login' width='650' height='300' marginheight=0 marginwidth=0 frameborder=0 style=\"background: transparent;\">";
echo "</td>";


echo "</tr></table></center>";

//<!---[Lower Part - End]--->


echo "</td></tr></table></body></html></iframe>";
echo "<font style=\"color:blue; font-weight: Bold;\">";
PostFooter();
echo "</font>";
}
elseif ($mode == 'Login'){


echo "<link href='$General_Image_Dir/style.css' type=text/css rel=stylesheet>";

echo "<body oncontextmenu=\"return false;\"><table width='500' height='200'><tr><td>";
echo "<p align='center'><b>";
echo "<form action=\"logins.php\" method=post name=login target=_parent>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<p align='center'>";
echo "<font size=\"5\">用戶:</font> <input type=text name=\"username\" style=\"height:21px; color:#ededed; font-size:16px; background: transparent; border:1px solid white; \" size=\"20\">";
echo "<br>";
echo "<font size=\"5\">密碼:</font> <input type=password name=\"password\" style=\"height:21px; color:#ededed; font-size:16px; background: transparent; border:1px solid white; \" size=\"20\">";
echo "<p align='center'>";
echo "<input type='submit' name='login' value='登入'> <input type='reset' value='清除'></p>";
echo "<center><font onClick=\"login.action='register.php';login.submit();\" style=\"font-size: 16px;font-weight: Bold;filter: glow(color=#3366FF,strength=3); height:10px; color:yellow;\"><a href=\"#\">&nbsp;新建帳號!&nbsp;<br>&nbsp;按此註冊&nbsp;</a></font>";
echo "</form></td></tr></table></body></html>";
echo "<br><br>";
}

elseif ($mode == 'Pedia'){
echo "<link href='$General_Image_Dir/style.css' type=text/css rel=stylesheet>";

echo "<center>";

echo "<br><br><br><br>
<table border=0 cellpadding=0 cellspacing=0 align=center style=\"border:1px solid #606060;font-size:16px;\">
	<tr>
	<td colspan=2>&nbsp;參考資料</td>
	</tr>
	<tr>
	<td><a href=\"gen_info2.php?action=weplist\" target=\"_blank\" style=\"font-size:20px;\"><b>武器列表</b></a></td>
	</tr>
	<tr>
	<td><a href=\"gen_info2.php?action=mslist\" target=\"_blank\" style=\"font-size:20px;\"><b>機體列表</b></a></td>
	</tr>
	<tr>
	<td><a href=\"gen_info2.php?action=calpt\" target=\"_blank\" style=\"font-size:20px;\"><b>Pt Cal</b></a></td>
	</tr>
	<tr>
	<td><a href=\"gen_info2.php?action=cal\" target=\"_blank\" style=\"font-size:20px;\"><b>經驗表</b></a></td>
	</tr>
	<!--
	<tr>
	<td><a href=\"ava_list.php\" target=\"_blank\" style=\"font-size:20px;\"><b>Avatars</b></a></td>
	</tr>
	-->
	</table>
";

echo "</body>";
}
?>
