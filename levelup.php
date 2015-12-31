<?php
header('Content-Type: text/html; charset=utf-8');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser();
if ($CFU_Time >= $_SESSION['timeauth']+$TIME_OUT_TIME || $_SESSION['timeauth'] <= $CFU_Time-$TIME_OUT_TIME){echo "驗證機制！<br>請重新登入！";exit;}
GetUsrDetails("$_SESSION[username]",'Gen','Game');
if ($Game['organization'])
$Pl_Org = ReturnOrg("$Game[organization]");
if ($mode == 'Class'){
        echo "<font style=\"font-size: 12pt\">晉升</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if (!$Game['organization'] || $Game['rights'] != 1){echo "以您的身份不能晉升其他人。";postFooter;exit;}

        if ($actionb == 'A'){
        echo "<form action=levelup.php?action=Class method=post name=userlevel>";
		echo "<input type=hidden name=\"class\" value=''>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		
		echo "<script language=\"Javascript\">";
		echo "function upuser(name){";
		echo "        userlevel.action='levelup.php?action=Class';";
		echo "        userlevel.class.value=name;";
		echo "		  userlevel.submit();";
		echo "        }</script>";

		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\"  style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\" width=\"600px\">";
		echo "<tr align=center><td colspan=16><b>國民列表: </b></td></tr>";
		echo "<tr align=center>";
        echo "<td width=\"100\">名稱</td>";
		echo "<td width=\"40\">等級</td>";
		echo "<td width=\"40\">職位</td>";
		echo "<td width=\"140\">最後上線時間</td>";
		echo "<td width=\"40\">操作</td>";
		echo "</tr>";
		
		$list = ("SELECT a.gamename AS gamename, a.level AS level,a.rights AS rights, b.lastlogin AS time FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` a INNER JOIN `".$GLOBALS['DBPrefix']."phpeb_user_general_info` b ON a.username = b.username WHERE a.organization = '$Game[organization]' AND a.rights!=1 ORDER BY a.level DESC");
		$qlist = mysql_query($list);
		
		while ($userlevel = mysql_fetch_array($qlist)){
			echo "<tr align=center>";
			echo "<td width=\"100\">$userlevel[gamename]</td>";
			echo "<td width=\"40\">$userlevel[level]</td>";
			if($userlevel['rights']==0){
				echo "<td width=\"40\">普通國民</td>";
			}
			if($userlevel['rights']==2){
				echo "<td width=\"40\">大元帥</td>";
			}
			$realtime = cfu_time_convert($userlevel['time']);
			echo "<td width=\"140\">$realtime</td>";
			if($userlevel['rights']==0){
				echo "<td width=\"40\"><input type=\"submit\" value=\"晉升\" onclick=\"upuser('$userlevel[gamename]');\"></td>";
			}
			if($userlevel['rights']==2){
				echo "<td width=\"40\"><input type=\"submit\" value=\"無法晉升\" disabled></td>";
			}
			echo "</tr>";
		}
		
		echo "</form></table>";
        }// Action A End

        elseif ($actionb == 'B'){
		$class = mysql_real_escape_string($class);
		if ($class == ''){echo "請先指定目標！";postFooter;exit;};

        $sqlgame = ("SELECT `gamename`,`organization`,`rights` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE gamename='$class'");
        $qgame = mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
        $TarQ = mysql_fetch_array($qgame);
		
		if ($TarQ['rights'] == 1){echo "您沒有權力解僱總帥！";postFooter;exit;};
		if ($TarQ['organization'] != $Game['organization']){echo "該名玩家不在此組織！";postFooter;exit;};

        $HistoryWrite = "<font color=\"$Pl_Org[color]\">$Pl_Org[name]</font> 的 <font color=\"$Gen[color]\">$Game[gamename]</font> 把國家內的 <font color=\"$TarQ[color]\">$TarQ[gamename]</font> 晉升了。";
        WriteHistory($HistoryWrite);


        //更新 Game Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `rank` = '100000', `rights` = '2' WHERE `gamename` = '$class' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">晉升完成了！<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
		
        }// Action B End


        else {echo "未定義動作！";}
}
?>