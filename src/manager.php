<?php
//編寫: fra
//繁體化: 風之翎
include('cfu.php');
postHead('');
$_POST['action'] = ( isset($_POST['action']) ) ? $_POST['action'] : 0;
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
$_POST["operation"] = ( isset($_POST["operation"]) ) ? $_POST["operation"] : false;
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線超時！<br>請重新登入！";exit;}
$db = mysql_connect($DBHost, $DBUser, $DBPass);
mysql_select_db($DBName,$db);

$SQL = ("SELECT `password`,`acc_status` FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` where `username` = '".$Pl_Value['USERNAME']."'");
$Query = mysql_query($SQL);
$Ac = mysql_fetch_array($Query);

if ( ( $Ac['acc_status'] >= 0 && "fra" != $Pl_Value['USERNAME'] ) || ($Ac['password'] != md5($Pl_Value['PASSWORD']) && $Ac['password'] != $Pl_Value['PASSWORD']) ) {
	echo "不是管理員或密碼錯誤！";
	$mcfu_time = explode(' ', microtime());
	$cfu_ptime = number_format(($mcfu_time[1] + $mcfu_time[0] - $GLOBALS['cfu_stime']), 6);
	echo "<p align=center style=\"font-size: 10pt\">php-eb &copy; 2005-2008 v2Alliance. All Rights Reserved.　版權所有 不得轉載<br>";
	echo "<p align=center style=\"font-size: 10pt\">Manager Script &copy; fra. All Rights Reserved.　版權所有 不得轉載<br>";
	if ($GLOBALS['Show_ptime'])
	echo "<font style=\"font-size: 7pt\">Processed in ".$cfu_ptime." second(s).</font></p>";
exit;
}
//請把fra改成你的名字
//或到 phpeb_user_general_info 資料表中, 把目標 GM 的帳戶資料中, acc_status 一項設為負數


//開始介面，可選操作
echo "<table align=center width=30% height=20% cellspacing=0 cellpadding=0 style=\"font-size:16px;\" border=0>";
echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
echo "<tr><td colspan=3><center><input type=radio name=operation value =1>用戶操作<input type=radio name=operation value =2>機體操作<input type=radio name=operation value =3>武器操作<input type=radio name=operation value =4>合成操作</center></td></tr>";
echo "<tr><td colspan=3><center><input type=radio name=operation value =5>批刪用戶<input type=radio name=operation value =6>批增機體<input type=radio name=operation value =7>批增NPC<input type=radio name=operation value =8>SQL命令</center></td></tr>";
echo "<tr><td colspan=3><center><input type=radio name=operation value =9>增加武器<input type=radio name=operation value =A>增加公式</center></td></tr>";

echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
echo "</form></center></td></tr>";
echo "<tr><td colspan=3><center>本後臺由fra製作，有問題和建議請至phpeb官方網站提出</center></td></tr>";
//你可以注釋掉上面一行，但不可刪掉或改動名字。我不想有人有問題和建議卻找不到地方。官方論壇：http://forum.dai-ngai.net/
echo "<tr><td colspan=3><center>__________________________________________________</center></td></tr>";

//輸入用戶名
if ("1" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
	echo "<tr><td colspan=3><center>請輸入你要操作的用戶的遊戲名（留空為列出所有用戶）<br></center></td></tr>";
	echo "<tr><td colspan=3><center><input type=text name='ugamename' size='40' maxlength=50></center></td></tr>";
	echo "<input type=hidden value='11' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
}

//給出用戶屬性
if ("11" == $_POST["operation"] ) {
	$operuser = $_POST["ugamename"];
	$ouserpage = ( isset($ouserpage) ) ? $ouserpage : false;
	if(!$operuser) {
		if ( $ouserpage ) $ouserstart = $_POST["$ouserpage"];	
		else $ouserstart = 0;
		$result1 = mysql_query("SELECT username,gamename,level FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info`",$db);
		$num_rows = mysql_num_rows($result1);
		
		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<table align=center width=500 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr align=center><td width=50>序號</td>";
		echo "<td width=150>ID</td>";
		echo "<td width=250>遊戲名</td>";
		echo "<td width=50>等級</td>";
		echo "<td width=50>選擇</td>";
		$i = 1;
  		while($num_rows--) {
			$myrow1 = mysql_fetch_object($result1); 
			echo "<tr align=center><td width=50>$i</td>";
			echo "<td width=150>$myrow1->username</td>";
			echo "<td width=250>$myrow1->gamename</td>";
			echo "<td width=50>$myrow1->level</td>";
			echo "<td width=50><input type=radio name=ugamename value = '$myrow1->gamename'></td>";
			$i++;			
		}
		echo "<input type=hidden value='11' name=operation>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";

		echo "</tr>";
		echo "</form></center></td></tr>";
		echo "</table>";

		exit;
	}
	
	$result2 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `gamename` = '$operuser'",$db);
	$myrow2 = mysql_fetch_object($result2);
	
	$ousername = $myrow2->username;	
	
	$result1 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `username` = '$ousername'",$db);
	$myrow1 = mysql_fetch_object($result1);

	$result3 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `username` = '$ousername'",$db);
	$myrow3 = mysql_fetch_object($result3);
	if (!$ousername) {
		echo "<tr><td colspan=3><center>查無此人<br></center></td></tr>";
		exit;
	}
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<tr><td colspan=3><center>修改用戶 $operuser 資料：<br></center></td></tr>";

	echo "<table align=center width=400 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>欄位</td>";
	echo "<td width=200>數值</td>";
	echo "<td width=50>選擇</td>";
	
	$UsrWepA = explode('<!>',$myrow2->wepa);
	$UsrWepB = explode('<!>',$myrow2->wepb);
	$UsrWepC = explode('<!>',$myrow2->wepc);

$ouser = array("登陸名","現金","機體","類型","懸賞金","顏色","hypermode","成長點數","名聲惡名","地區","帳戶狀態","戰鬥宣言","遊戲名","hpmax","enmax","spmax",
"attacking","defending","reacting","targeting","等級","經驗","使用武器","備用一","備用二","裝備","常規","spec","組織領導人",
"組織","對戰宣言","是否開戶","存款","特殊","特殊","特殊");
$ofield = array("$myrow1->username","$myrow1->cash","$myrow1->msuit","$myrow1->typech","$myrow1->bounty","$myrow1->color","$myrow1->hypermode","$myrow1->growth","$myrow1->fame",
"$myrow1->coordinates","$myrow1->acc_status","$myrow1->atkword","$myrow2->gamename","$myrow2->hpmax","$myrow2->enmax","$myrow2->spmax",
"$myrow2->attacking","$myrow2->defending","$myrow2->reacting","$myrow2->targeting","$myrow2->level","$myrow2->expr","$UsrWepA[0]，經驗$UsrWepA[1]",
"$UsrWepB[0]，經驗$UsrWepB[1]","$UsrWepC[0]，經驗$UsrWepC[1]","$myrow2->eqwep","$myrow2->p_equip","$myrow2->spec","$myrow2->rights","$myrow2->organization",
"$myrow2->speech","$myrow3->status","$myrow3->savings","更改用戶密碼","刪除此用戶","時間重置");


	$i = 0;
	while($i<=35) {
		echo "<tr align=center><td width=100>$ouser[$i]</td>";
		echo "<td width=200>$ofield[$i]</td>";
		echo "<td width=50><input type=radio name=ouserfield value = '$i'></td>";	
		$i++;
	}	

	echo "<tr><td colspan=3><center><input type=text name='ouserchange' size='40' maxlength=50></center></td></tr>";

	echo "<input type=hidden value='$myrow1->username' name=ousername>";
	echo "<input type=hidden value='12' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
	echo "</table>";	
		 
}

//修改用戶屬性
if ("12" == $_POST["operation"] ) {
	$ouserfield = $_POST["ouserfield"];
	$ouservalue = $_POST["ouserchange"];
	$ousername = $_POST["ousername"];

	if (!$ouserfield) {
		echo "<tr><td colspan=3><center>選項未知<br></center></td></tr>";
		exit;
	}
	if ( $ouserfield <= 11 || 33 == $ouserfield ) {
		$sqlop = $GLOBALS['DBPrefix']."phpeb_user_general_info";
	}
	else if ( $ouserfield > 11 && $ouserfield <= 30 ) {
		$sqlop = $GLOBALS['DBPrefix']."phpeb_user_game_info";
	}	
	else if ( $ouserfield > 30 && $ouserfield <= 32 ) {
		$sqlop = $GLOBALS['DBPrefix']."phpeb_user_bank";
	}
	switch ($ouserfield) {
		case 1: $ousrfield = "cash";break;
		case 2: $ousrfield = "msuit";break;
		case 3: $ousrfield = "typech";break;
		case 4: $ousrfield = "bounty";break;
		case 5: $ousrfield = "color";break;
		case 6: $ousrfield = "hypermode";break;		
		case 7: $ousrfield = "growth";break;
		case 8: $ousrfield = "fame";break;
		case 9: $ousrfield = "coordinates";break;
		case 10: $ousrfield = "acc_status";break;
		case 11: $ousrfield = "atkword";break;
		case 12: $ousrfield = "gamename";break;
		case 13: $ousrfield = "hpmax";break;
		case 14: $ousrfield = "enmax";break;
		case 15: $ousrfield = "spmax";break;
		case 16: $ousrfield = "attacking";break;
		case 17: $ousrfield = "defending";break;
		case 18: $ousrfield = "reacting";break;
		case 19: $ousrfield = "targeting";break;
		case 20: $ousrfield = "level";break;
		case 21: $ousrfield = "expr";break;
		case 22: $ousrfield = "wepa";break;
		case 23: $ousrfield = "wepb";break;
		case 24: $ousrfield = "wepc";break;
		case 25: $ousrfield = "eqwep";break;
		case 26: $ousrfield = "p_equip";break;
		case 27: $ousrfield = "spec";break;
		case 28: $ousrfield = "rights";break;
		case 29: $ousrfield = "organization";break;
		case 30: $ousrfield = "speech";break;
		case 31: $ousrfield = "status";break;
		case 32: $ousrfield = "savings";break;
		case 33: $ousrfield = "password";$ouservalue = md5($ouservalue);break;
		case 34: echo "<tr><td colspan=3><center>刪除用戶的操作是不可逆的<br>請儘量使用禁用帳號功能<br></center></td></tr>";
			 echo "<tr><td colspan=3><center>請再次確認！<br></center></td></tr>";
			 echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
			 echo "<input type=hidden value='13' name=operation>";
			 echo "<input type=hidden value='$ousername' name=ousername>";		
			 echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
			 echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
			 echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
			 echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
			 echo "</form></center></td></tr>";
			 exit;	
		case 35: mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `time1` = '0',`time2` = '0',`btltime` = '0' WHERE `".$GLOBALS['DBPrefix']."phpeb_user_general_info`.`username` = '$ousername' LIMIT 1 ;");
			 echo "<tr><td colspan=3><center>操作完成<br></center></td></tr>";
			 exit;
	}

	$sqlouser = "UPDATE `$sqlop` SET `$ousrfield` = '$ouservalue' WHERE `$sqlop`.`username` = '$ousername' LIMIT 1;";
	echo "<tr><td colspan=3><center>$sqlouser<br></center></td></tr>";
	mysql_query($sqlouser);
	echo "<tr><td colspan=3><center>操作完成<br></center></td></tr>";
}

//刪除用戶操作
if ("13" == $_POST["operation"] ) {
	$ousername = $_POST["ousername"];
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_log` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_settings` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE `username` = '$ousername' Limit 1;");
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` WHERE `username` = '$ousername' Limit 1;");  
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_chat` WHERE `c_user` = '$ousername';");
	echo "<tr><td colspan=3><center>操作完成，用戶$ousername 已刪除<br></center></td></tr>";
}

//輸入機體名

if ("2" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
	echo "<tr><td colspan=3><center>請輸入你要操作的機體名（留空為列出所有機體）<br></center></td></tr>";
	echo "<tr><td colspan=3><center><input type=text name='omsname' size='40' maxlength=50></center></td></tr>";
	echo "<input type=hidden value='21' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
}
//顯示機體操作
if ("21" == $_POST["operation"] ) {
	$omsname = $_POST["omsname"];
	if(!$omsname) {
		$result1 = mysql_query("SELECT id,msname,price FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms`",$db);
		$num_rows = mysql_num_rows($result1);
		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<table align=center width=400 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr align=center><td width=50>ID</td>";
		echo "<td width=150>機體名</td>";
		echo "<td width=80>價格</td>";
		echo "<td width=50>選擇</td>"; 
		$i = 1;
  		while($num_rows--) {
			$myrow1 = mysql_fetch_object($result1); 
			echo "<tr align=center><td width=50>$myrow1->id</td>";
			echo "<td width=150>$myrow1->msname</td>";
			echo "<td width=80>$myrow1->price</td>";
			echo "<td width=50><input type=radio name=omsname value = '$myrow1->msname'></td>";
			$i++;	
			}
		echo "<input type=hidden value='21' name=operation>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
		echo "</tr>";
		echo "</form></center></td></tr>";
		echo "</table>";
		exit;
	}
	$result1 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE `msname` = '$omsname'",$db);
	$myrow1 = mysql_fetch_object($result1);
	if (!$myrow1->id) {
		echo "<tr><td colspan=3><center>查無此機體<br></center></td></tr>";
		exit;
	}

	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<tr><td colspan=3><center>修改機體 $omsname 資料：<br></center></td></tr>";


$omslist = array("編號","機體名","價格","att","def","rct","taf","HP增量","EN增量","HP回復","EN回復","特效","需要等級","圖片目錄","特殊");
$omsfield = array("$myrow1->id","$myrow1->msname","$myrow1->price","$myrow1->atf","$myrow1->def","$myrow1->ref","$myrow1->taf",
"$myrow1->hpfix","$myrow1->enfix","$myrow1->hprec","$myrow1->enrec","$myrow1->spec","$myrow1->needlv","$myrow1->image","刪除機體");
	echo "<table align=center width=400 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>欄位</td>";
	echo "<td width=200>數值</td>";
	echo "<td width=50>選擇</td>";

	$i = 0;
	while($i<=14) {
		echo "<tr align=center><td width=100>$omslist[$i]</td>";
		echo "<td width=200>$omsfield[$i]</td>";
		echo "<td width=50><input type=radio name=omsfield value = '$i'></td>";	
		$i++;
	}

	echo "<tr><td colspan=3><center><input type=text name='omsvalue' size='40' maxlength=50></center></td></tr>";

	echo "<input type=hidden value='$myrow1->id' name=omsid>";
	echo "<input type=hidden value='22' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
	echo "</table>";	
}

//修改機體資料
if ("22" == $_POST["operation"] ) {
	$omsid = $_POST["omsid"];
	$omsfield = $_POST["omsfield"];
	$omsvalue = $_POST["omsvalue"];
	switch ($omsfield) {
		case 1: $omsfield = "msname";break;
		case 2: $omsfield = "price";break;
		case 3: $omsfield = "atf";break;		
		case 4: $omsfield = "def";break;
		case 5: $omsfield = "ref";break;
		case 6: $omsfield = "taf";break;
		case 7: $omsfield = "hpfix";break;
		case 8: $omsfield = "enfix";break;
		case 9: $omsfield = "hprec";break;
		case 10: $omsfield = "enrec";break;
		case 11: $omsfield = "spec";break;		
		case 12: $omsfield = "needlv";break;
		case 13: $omsfield = "image";break;
		case 14: echo "<tr><td colspan=3><center>刪除機體的操作是不可逆的。請再次確認！<br></center></td></tr>";	
			 echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
			 echo "<input type=hidden value='23' name=operation>";
			 echo "<input type=hidden value='$omsid' name=omsid>";		
			 echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
			 echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
			 echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
			 echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
			 echo "</form></center></td></tr>";
			 exit;		
	}
	$sqloms = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_ms` SET `$omsfield` = '$omsvalue' WHERE `id` = '$omsid' LIMIT 1;";
	mysql_query($sqloms);
	echo "<tr><td colspan=3><center>操作完成<br></center></td></tr>";
}

//刪除機體操作
if ("23" == $_POST["operation"] ) {
	$omsid = $_POST["omsid"];
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE `id` = '$omsid' Limit 1;");
	echo "<tr><td colspan=3><center>操作完成，機體 $omsid 已刪除<br></center></td></tr>";
}


//輸入武器名
if ("3" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
	echo "<tr><td colspan=3><center>請輸入武器名（留空為列出所有武器）<br></center></td></tr>";
	echo "<tr><td colspan=3><center><input type=text name='owepname' size='40' maxlength=50></center></td></tr>";
	echo "<input type=hidden value='31' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
}

//顯示武器資料
if ("31" == $_POST["operation"] ) {
	$owepname = $_POST["owepname"];
	if(!$owepname) {
		$result1 = mysql_query("SELECT id,name,price FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep`",$db);
		$num_rows = mysql_num_rows($result1);

		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<table align=center width=500 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr align=center><td width=50>ID</td>";
		echo "<td width=250>武器列表</td>";
		echo "<td width=100>價格</td>";
		echo "<td width=50>選擇</td>";
		$i = 1;
  		while($num_rows--) {
			$myrow1 = mysql_fetch_object($result1); 
			echo "<tr align=center><td width=50>$myrow1->id</td>";
			echo "<td width=200>$myrow1->name</td>";
			echo "<td width=100>$myrow1->price</td>";
			echo "<td width=50><input type=radio name=owepname value = '$myrow1->name'></td>";
			$i++;			
			}
		echo "<input type=hidden value='31' name=operation>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
		echo "</tr>";
		echo "</form></center></td></tr>";
		echo "</table>";
		exit;
	}
	$result1 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `name` = '$owepname'",$db);
	$myrow1 = mysql_fetch_object($result1);
	if (!$myrow1->id) {
		echo "<tr><td colspan=3><center>查無此武器<br></center></td></tr>";
		exit;
	}


	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<tr><td colspan=3><center>修改武器 $owepname 資料：<br></center></td></tr>";


$oweplist = array("編號","名字","世代","性質BDI","初改","改造可能","特殊改造","攻擊","命中","回數","EN消耗","價格","可成輔助","特效","特殊");
$owepvalue = array("$myrow1->id","$myrow1->name","$myrow1->grade","$myrow1->kind","$myrow1->familyid","$myrow1->nextev","$myrow1->specev",
"$myrow1->atk","$myrow1->hit","$myrow1->rd","$myrow1->enc","$myrow1->price","$myrow1->equip","$myrow1->spec","刪除");
	echo "<table align=center width=400 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>欄位</td>";
	echo "<td width=200>數值</td>";
	echo "<td width=50>選擇</td>";

	$i = 0;
	while($i<=14) {
		echo "<tr align=center><td width=100>$oweplist[$i]</td>";
		echo "<td width=200>$owepvalue[$i]</td>";
		echo "<td width=50><input type=radio name=owepfield value = '$i'></td>";	
		$i++;
	}

	echo "<tr><td colspan=3><center><input type=text name='owepvalue' size='40' maxlength=50></center></td></tr>";

	echo "<input type=hidden value='$myrow1->id' name=owepid>";
	echo "<input type=hidden value='32' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
	echo "</table>";		
	wepspec();
}
                        
//修改武器資料
if ("32" == $_POST["operation"] ) {
	$owepid = $_POST["owepid"];
	$owepfield = $_POST["owepfield"];
	$owepvalue = $_POST["owepvalue"];
	switch ($owepfield) {
		case 1: $owepfield = "name";break;
		case 2: $owepfield = "grade";break;
		case 3: $owepfield = "kind";break;	
		case 4: $owepfield = "familyid";break;
		case 5: $owepfield = "nextev";break;
		case 6: $owepfield = "specev";break;	
		case 7: $owepfield = "atk";break;
		case 8: $owepfield = "hit";break;
		case 9: $owepfield = "rd";break;	
		case 10: $owepfield = "enc";break;
		case 11: $owepfield = "price";break;
		case 12: $owepfield = "equip";break;	
		case 13: $owepfield = "spec";break;
		case 14: echo "<tr><td colspan=3><center>刪除武器的操作是不可逆的。請再次確認！<br></center></td></tr>";	
			 echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
			 echo "<input type=hidden value='33' name=operation>";
			 echo "<input type=hidden value='$owepid' name=owepid>";		
			 echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
			 echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
			 echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
			 echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
			 echo "</form></center></td></tr>";
			 exit;		
	}
	$sqlowep = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_wep` SET `$owepfield` = '$owepvalue' WHERE `id` = '$owepid' LIMIT 1;";
//	echo "$sqlowep";
	mysql_query($sqlowep);
	echo "<tr><td colspan=3><center>操作完成<br></center></td></tr>";	

}

//刪除武器操作
if ("33" == $_POST["operation"] ) {
	$owepid = $_POST["owepid"];
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `id` = '$owepid' Limit 1;");
	echo "<tr><td colspan=3><center>操作完成，武器 $owepid 已刪除<br></center></td></tr>";
}

//顯示合成列表
if ("4" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>請輸入你要操作的武器（留空為列出所有合成公式）<br></center></td></tr>";
	echo "<tr><td colspan=3><form action=manager.php?action=main method=post target=_self>";
	echo "<tr><td colspan=3><center><input type=text name='otatname' size='40' maxlength=50></center></td></tr>";
	echo "<input type=hidden value='41' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></td></tr>";
}

//顯示合成資料
if ("41" == $_POST["operation"] ) {
	$otatname = $_POST["otatname"];
	if(!$otatname) {
		$result1 = mysql_query("SELECT tact_id,wep_id,grade FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory`",$db);
		$num_rows = mysql_num_rows($result1);
		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr align=center><td width=50>編號</td>";
		echo "<td width=100>武器ID</td>";
		echo "<td width=50>級別</td>";
		echo "<td width=50>選擇</td>";
		$i = 1;
  		while($num_rows--) {
			$myrow1 = mysql_fetch_object($result1); 
			echo "<tr align=center><td width=50>$myrow1->tact_id</td>";
			echo "<td width=100>$myrow1->wep_id</td>";
			echo "<td width=20>$myrow1->grade</td>";
			echo "<td width=50><input type=radio name=otatname value = '$myrow1->wep_id'></td>";
			$i++;			
			}
		echo "<input type=hidden value='41' name=operation>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
		echo "</tr>";
		echo "</form></center></td></tr>";
		echo "</table>";
		exit;
	}
	$result1 = mysql_query("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` WHERE `wep_id` = '$otatname'",$db);
	$myrow1 = mysql_fetch_object($result1);
	if (!$myrow1->tact_id) {
		echo "<tr><td colspan=3><center>查無此武器<br></center></td></tr>";
		exit;
	}

	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<tr><td colspan=3><center>修改武器 $owepname 資料：<br></center></td></tr>";


$otatlist = array("編號","武器編號","等級","對話","1號爐","2號爐","3號爐","4號爐","5號爐","6號爐","7號爐","8號爐","9號爐","10號爐",
"11號爐","12號爐","13號爐","14號爐","15號爐","16號爐","17號爐","18號爐","19號爐","20號爐","特殊");
$otatvalue = array("$myrow1->tact_id","$myrow1->wep_id","$myrow1->grade","$myrow1->directions",
"$myrow1->m1","$myrow1->m2","$myrow1->m3","$myrow1->m4","$myrow1->m5","$myrow1->m6","$myrow1->m7","$myrow1->m8","$myrow1->m9","$myrow1->m10",
"$myrow1->m11","$myrow1->m12","$myrow1->m13","$myrow1->m14","$myrow1->m15","$myrow1->m16","$myrow1->m17","$myrow1->m18","$myrow1->m19","$myrow1->m20","刪除公式");
	echo "<table align=center width=400 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>欄位</td>";
	echo "<td width=200>數值</td>";
	echo "<td width=50>選擇</td>";

	$i = 0;
	while($i<=24) {
		echo "<tr align=center><td width=100>$otatlist[$i]</td>";
		echo "<td width=200>$otatvalue[$i]</td>";
		echo "<td width=50><input type=radio name=otatfield value = '$i'></td>";	
		$i++;
	}

	echo "<tr><td colspan=3><center><input type=text name='otatvalue' size='40' maxlength=50></center></td></tr>";

	echo "<input type=hidden value='$myrow1->tact_id' name=otatid>";
	echo "<input type=hidden value='42' name=operation>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
	echo "</table>";	
	
	
}

//修改合成資料
if ("42" == $_POST["operation"] ) {
	$otatid = $_POST["otatid"];
	$otatfield = $_POST["otatfield"];
	$otatvalue = $_POST["otatvalue"];
	switch ($otatfield) {
		case 1: $otatfield = "wep_id";break;
		case 2: $otatfield = "grade";break;
		case 3: $otatfield = "directions";break;	
		case 4: $otatfield = "m1";break;
		case 5: $otatfield = "m2";break;
		case 6: $otatfield = "m3";break;	
		case 7: $otatfield = "m4";break;
		case 8: $otatfield = "m5";break;	
		case 9: $otatfield = "m6";break;
		case 10: $otatfield = "m7";break;	
		case 11: $otatfield = "m8";break;
		case 12: $otatfield = "m9";break;
		case 13: $otatfield = "m10";break;
		case 14: $otatfield = "m11";break;
		case 15: $otatfield = "m12";break;
		case 16: $otatfield = "m13";break;	
		case 17: $otatfield = "m14";break;
		case 18: $otatfield = "m15";break;	
		case 19: $otatfield = "m16";break;
		case 20: $otatfield = "m17";break;	
		case 21: $otatfield = "m18";break;
		case 22: $otatfield = "m19";break;
		case 23: $otatfield = "m20";break;
		case 24: echo "<tr><td colspan=3><center>刪除公式的操作是不可逆的。請再次確認！<br></center></td></tr>";	
			 echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
			 echo "<input type=hidden value='43' name=operation>";
			 echo "<input type=hidden value='$otatid' name=otatid>";		
			 echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
			 echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
			 echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
			 echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
			 echo "</form></center></td></tr>";
			 exit;		
	}
	$sqlowep = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` SET `$otatfield` = '$otatvalue' WHERE `tact_id` = '$otatid' LIMIT 1;";
	echo "$sqlowep";
	mysql_query($sqlowep);
	echo "<tr><td colspan=3><center>操作完成<br></center></td></tr>";	

}

//刪除合成列表操作
if ("43" == $_POST["operation"] ) {
	$otatid = $_POST["otatid"];
	mysql_query("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` WHERE `tact_id` = '$otatid' Limit 1;");
	echo "<tr><td colspan=3><center>操作完成，編號 $otatid 已刪除<br></center></td></tr>";
}


//批量刪除用戶
if ("5" == $_POST["operation"] ) {
	$deletelv = $_POST["deletelv"];
	$deletetime = $_POST["deletetime"];
	$predel = $_POST["predel"];
	$deadline = time() - 86400*$deletetime;
	if(!$deletelv &&!$deletetime && !$predel) {
		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<tr><td colspan=3><center>刪除條件。兩選一，同時選的就照級別來算<br></center></td></tr>";
		echo "<tr><td colspan=3><center><input type=text name='deletelv' size='20' maxlength=50>級別</center></td></tr>";
		echo "<tr><td colspan=3><center><input type=text name='deletetime' value = 10 size='20' maxlength=50>天數</center></td></tr>";
		echo "<input type=hidden value='5' name=operation>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
		echo "</form></center></td></tr>";
		exit;	
	}	
        if($deletelv) {
		$result1=mysql_query("SELECT `username` , `gamename` , `level` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `level` <= $deletelv ");
	}
	else {
		$result1=mysql_query("SELECT `username` FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `time2` < $deadline ");
	
	}
	$num_rows = mysql_num_rows($result1);
	if (!$num_rows){
		if($deletelv){
			echo "<tr><td colspan=3><center>當前沒有$deletelv 級以下人物<br></center></td></tr>";
		}
		else 	{	
				echo "<tr><td colspan=3><center>當前沒有$deletetime 天（ $deadline 秒）以上未上線的人物<br></center></td></tr>";
			}
		exit;	
	} 
	echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=50>序號</td>";
	echo "<td width=100>ID</td>";
	echo "<td width=150>名字</td>";
	echo "<td width=50>lv</td>";
	$i = 1;
	while($num_rows--){
		$myrow1 = mysql_fetch_object($result1);
		if (1 == $predel) {
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_log` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_settings` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` WHERE `username` = '$myrow1->username' Limit 1;");
			mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_chat` WHERE `c_user` = '$myrow1->username';");
		}
		echo "<tr align=center><td width=50>$i</td>";
		echo "<td width=100>$myrow1->username</td>";
		echo "<td width=150>$myrow1->gamename</td>";
		echo "<td width=50>$myrow1->level</td>";		
                $i++;
	}
	echo "</tr>";
	echo "</table>";
	if (1 == $predel) {
		echo "<tr><td colspan=3><center>刪除完畢<br></center></td></tr>";	
	}
	
	if (!$predel) {
		echo "<tr><td colspan=3><center>確定以上人物刪除？<br></center></td></tr>";	
		echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
		echo "<input type=hidden value='5' name=operation>";
		echo "<input type=hidden value='1' name=predel>";		
		echo "<input type=hidden value='$deletelv' name=deletelv>";
		echo "<input type=hidden value='$deletetime' name=deletetime>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
		echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
		echo "</form></center></td></tr>";
		exit;	
	}
}

//批量增加機體
if ("6" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>機體格式為機體名加一個數位，機體的圖片編號也是如此<br></center></td></tr>";
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
	
	echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>機體名</td>";
	echo "<td width=150><input type=text name='newmsname' value = 新機體 size='20' maxlength=20></td>";		
	echo "<tr align=center><td width=100>機體數量</td>";
	echo "<td width=150><input type=text name='newmsq' value = 10 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>初始數字</td>";
	echo "<td width=150><input type=text name='newmsnum' value = 1000 size='20' maxlength=5></td>";	
	echo "<tr align=center><td width=100>價格</td>";
	echo "<td width=150><input type=text name='newmsprice' value = 10000 size='20' maxlength=10></td>";		
	echo "<tr align=center><td width=100>atk</td>";
	echo "<td width=150><input type=text name='newmsatk' value = 10 size='20' maxlength=3></td>";	
	echo "<tr align=center><td width=100>def</td>";
	echo "<td width=150><input type=text name='newmsdef' value = 10 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>ref</td>";
	echo "<td width=150><input type=text name='newmsref' value = 10 size='20' maxlength=3></td>";	
	echo "<tr align=center><td width=100>taf</td>";
	echo "<td width=150><input type=text name='newmstaf' value = 10 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>hpfix</td>";
	echo "<td width=150><input type=text name='newmshpfix' value = 10 size='20' maxlength=6></td>";	
	echo "<tr align=center><td width=100>enfix</td>";
	echo "<td width=150><input type=text name='newmsenfix' value = 10 size='20' maxlength=6></td>";		
	echo "<tr align=center><td width=100>hprec</td>";
	echo "<td width=150><input type=text name='newmshprec' value = 10 size='20' maxlength=6></td>";	
	echo "<tr align=center><td width=100>enrec</td>";
	echo "<td width=150><input type=text name='newmsenrec' value = 5 size='20' maxlength=6></td>";		
	echo "<tr align=center><td width=100>spec</td>";
	echo "<td width=150><input type=text name='newmsspec' size='20' maxlength=20></td>";	
	echo "<tr align=center><td width=100>需要等級</td>";
	echo "<td width=150><input type=text name='newmslevel' value = 10 size='20' maxlength=2></td>";		
	echo "<tr align=center><td width=100>圖片目錄</td>";
	echo "<td width=150><input type=text name='newmspicdir' value = 0/ size='20' maxlength=20></td>";	
	echo "<tr align=center><td width=100>圖片格式</td>";
	echo "<td width=150><input type=text name='newmspicformat' value = .jpg size='20' maxlength=5></td>";
	echo "<input type=hidden value='61' name=operation>";	
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
}


if ("61" == $_POST["operation"]) {
	$newmsname = $_POST["newmsname"];
	$newmsq = $_POST["newmsq"];
	$newmsnum = $_POST["newmsnum"];
	$newmsprice = $_POST["newmsprice"];
	$newmsatk = $_POST["newmsatk"];
	$newmsdef = $_POST["newmsdef"];
	$newmsref = $_POST["newmsref"];
	$newmstaf = $_POST["newmstaf"];
	$newmshpfix = $_POST["newmshpfix"];
	$newmsenfix = $_POST["newmsenfix"];
	$newmshprec = $_POST["newmshprec"];
	$newmsenrec = $_POST["newmsenrec"];
	$newmsspec = $_POST["newmsspec"];
	$newmslevel = $_POST["newmslevel"];
	$newmspicdir = $_POST["newmspicdir"];
	$newmsnewmspicformat = $_POST["newmspicformat"];
	if (!$newmsname || !$newmsq || !$newmsnum || !$newmsprice || !$newmsatk || !$newmsdef || !$newmsref || !$newmstaf || !$newmshpfix || !$newmsenfix || !$newmshprec || !$newmsenrec || !$newmspicdir || !$newmsnewmspicformat) {
		echo "<tr><td colspan=3><center>選項有所遺漏<br></center></td></tr>";	
		exit;
	}
	if (!$newmslevel) { $newmslevel = 0; }
	$i = 0;
	while ( $i < $newmsq ) {
		$imsnum = $newmsnum + $i;
		$iname = "$newmsname"."$imsnum";
		$ipic = "$newmspicdir"."$imsnum"."$newmsnewmspicformat";
		mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_ms` (`id` ,`msname` ,`price` ,`atf` ,`def` ,`ref` ,`taf` ,`hpfix` ,`enfix` ,`hprec` ,`enrec` ,`spec` ,`needlv` ,`image`) VALUES ('$imsnum', '$iname', '$newmsprice', '$newmsatk', '$newmsdef', '$newmsref', '$newmstaf', '$newmshpfix', '$newmsenfix', '$newmshprec', '$newmsenrec', '$newmsspec', '$newmslevel', '$ipic');");
		$i++;
        }
	echo "<tr><td colspan=3><center>$newmsq 部$newmsname 機體增加完成<br></center></td></tr>";
}

//批量增加NPC
if ("7" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>NPC的格式為NPC加一個數字<br></center></td></tr>";
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>NPC名字</td>";
	echo "<td width=150><input type=text name='nname' value = NPC size='20' maxlength=15></td>";
	echo "<tr align=center><td width=100>密碼</td>";
	echo "<td width=150><input type=text name='npassword' size='20' maxlength=15></td>";
	echo "<tr align=center><td width=100>起始數字</td>";
	echo "<td width=150><input type=text name='nstart' value = 100 size='20' maxlength=10></td>";		
	echo "<tr align=center><td width=100>NPC數量</td>";
	echo "<td width=150><input type=text name='nq' value = 10 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>等級</td>";	
	echo "<td width=150><input type=text name='nlevel' value = 10 size='20' maxlength=2></td>";
	echo "<tr align=center><td width=100>種族</td>";	
	echo "<td width=150><input type=text name='ntype' value = psy4 size='20' maxlength=5></td>";
	echo "<tr align=center><td width=100>機體</td>";
	echo "<td width=150><input type=text name='nms' value = 101 size='20' maxlength=5></td>";
	echo "<tr align=center><td width=100>武器</td>";
	echo "<td width=150><input type=text name='nwep' value = 701 size='20' maxlength=5></td>";
	echo "<tr align=center><td width=100>atk</td>";
	echo "<td width=150><input type=text name='natk' value = 20 size='20' maxlength=3></td>";	
	echo "<tr align=center><td width=100>def</td>";
	echo "<td width=150><input type=text name='ndef' value = 20 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>ref</td>";
	echo "<td width=150><input type=text name='nref' value = 20 size='20' maxlength=3></td>";	
	echo "<tr align=center><td width=100>taf</td>";
	echo "<td width=150><input type=text name='ntaf' value = 20 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>hp</td>";
	echo "<td width=150><input type=text name='nhp' value = 1000 size='20' maxlength=8></td>";	
	echo "<tr align=center><td width=100>en</td>";
	echo "<td width=150><input type=text name='nen' value = 10000 size='20' maxlength=8></td>";		
	echo "<tr align=center><td width=100>sp</td>";
	echo "<td width=150><input type=text name='nsp' value = 50 size='20' maxlength=6></td>";		
	echo "<tr align=center><td width=100>貓度</td>";
	echo "<td width=150><input type=text name='nfame' value = -50 size='20' maxlength=5></td>";		
	echo "<tr align=center><td width=100>懸賞</td>";
	echo "<td width=150><input type=text name='nbounty' value = 100000 size='20' maxlength=10></td>";	
	echo "<tr align=center><td width=100>地區</td>";
	echo "<td width=150><input type=text name='narea' value = A1 size='20' maxlength=5></td>";
	echo "<input type=hidden value='71' name=operation>";	
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
}

if ("71" == $_POST["operation"]) {
	$nname = $_POST["nname"];
	$npassword = $_POST["npassword"];
	$nstart = $_POST["nstart"];
	$nq = $_POST["nq"];
	$nlevel = $_POST["nlevel"];
	$ntype = $_POST["ntype"];
	$nms = $_POST["nms"];
	$nwep = $_POST["nwep"];
	$natk = $_POST["natk"];
	$ndef = $_POST["ndef"];
	$nref = $_POST["nref"];
	$ntaf = $_POST["ntaf"];
	$nhp = $_POST["nhp"];
	$nen = $_POST["nen"];
	$nsp = $_POST["nsp"];
	$nfame = $_POST["nfame"];
	$nbounty = $_POST["nbounty"];
	$narea = $_POST["narea"];
	
	if (!$npassword || !$nstart || !$nq || !$nlevel || !$ntype || !$nms || !$nwep || !$natk || !$ndef || !$nref || !$ntaf || !$nhp || !$nen || !$nsp || !$nfame || !$nbounty || !$narea) {
		echo "<tr><td colspan=3><center>選項有所遺漏<br></center></td></tr>";	
		exit;
	}
	$npassword = md5($npassword);
	$i = 0;
	while ( $i < $nq ) {
		$npcnum = $nstart + $i;
		$npcname = "$nname"."$npcnum";
		
		$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_general_info (username, password,color,msuit,typech,growth,time1,time2,btltime,coordinates,fame) VALUES('$npcname','$npassword','#FF5050','$nms','$ntype','0','$t_now' ,'$t_now' ,'','$narea','$nfame')");
		mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register01)<br>原因:' . mysql_error() . '<br>');

		$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_game_info (username, gamename,attacking,defending,reacting,targeting,hpmax,enmax,spmax,level,wepa) VALUES('$npcname','$npcname','$natk','$ndef','$nref','$ntaf','$nhp','$nen','$nsp','$nlevel','$nwep')");
		mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register02)<br>原因:' . mysql_error() . '<br>');

		$sql = ("INSERT INTO ".$GLOBALS['DBPrefix']."phpeb_user_settings (username) VALUES('$npcname')");
		mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register05)<br>原因:' . mysql_error() . '<br>');

		$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank` (username) VALUES('$npcname')");
		mysql_query($sql) or die ('<br><center>未能完成註冊 (Location ID: Register04)<br>原因:' . mysql_error() . '<br>');

		$i++;
        }
	echo "<tr><td colspan=3><center>$nq 個NPC增加完成<br></center></td></tr>";
}

//直接資料庫操作
if ("8" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>請輸入SQL語句<br></center></td></tr>";	
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";
	echo "<tr><td colspan=3><center><input type=text name='sql' size='100' maxlength=400><br></center></td></tr>";
	echo "<input type=hidden value='81' name=operation>";	
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
}

if ("81" == $_POST["operation"] ) {
	$sql = $_POST["sql"];
	mysql_query("$sql");
	echo "<tr><td colspan=3><center>$sql<br></center></td></tr>";		
	echo "<tr><td colspan=3><center>不管語句正確與否，它已經被執行了<br></center></td></tr>";	
}

//增加武器
if ("9" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>武器ID不可重複<br></center></td></tr>";
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>武器ID</td>";
	echo "<td width=150><input type=text name='owid' value = 10000 size='20' maxlength=10></td>";
	echo "<tr align=center><td width=100>武器名</td>";
	echo "<td width=150><input type=text name='owname' value = 新武器 size='20' maxlength=20></td>";
	echo "<tr align=center><td width=100>grade</td>";
	echo "<td width=150><input type=text name='owgrade' value = 1 size='20' maxlength=2></td>";		
	echo "<tr align=center><td width=100>kind(BDI)</td>";
	echo "<td width=150><input type=text name='owkind' value = I size='20' maxlength=4></td>";		
	echo "<tr align=center><td width=100>familyid</td>";	
	echo "<td width=150><input type=text name='owfamilyid' value = 0 size='20' maxlength=6></td>";
	echo "<tr align=center><td width=100>nextev</td>";	
	echo "<td width=150><input type=text name='ownextev' size='20' maxlength=6></td>";
	echo "<tr align=center><td width=100>specev</td>";
	echo "<td width=150><input type=text name='owspecev' size='20' maxlength=6></td>";
	echo "<tr align=center><td width=100>攻擊</td>";
	echo "<td width=150><input type=text name='owatk' value = 100 size='20' maxlength=10></td>";
	echo "<tr align=center><td width=100>命中</td>";
	echo "<td width=150><input type=text name='owhit' value = 50 size='20' maxlength=5></td>";	
	echo "<tr align=center><td width=100>回數</td>";
	echo "<td width=150><input type=text name='owrd' value = 10 size='20' maxlength=3></td>";		
	echo "<tr align=center><td width=100>消耗EN</td>";
	echo "<td width=150><input type=text name='owenc' value = 50 size='20' maxlength=10></td>";	
	echo "<tr align=center><td width=100>價格</td>";
	echo "<td width=150><input type=text name='owprice' value = 50000 size='20' maxlength=10></td>";		
	echo "<tr align=center><td width=100>是否可裝備</td>";
	echo "<td width=150><input type=text name='owequip' value = 0 size='20' maxlength=3></td>";	
	echo "<tr align=center><td width=100>特效</td>";
	echo "<td width=150><input type=text name='owspec' size='20' maxlength=20></td>";		

	echo "<input type=hidden value='91' name=operation>";	
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
	wepspec();
}

if ("91" == $_POST["operation"]) {
	$id = $_POST["owid"];
	$name = $_POST["owname"];
	$grade = $_POST["owgrade"];
	$kind = $_POST["owkind"];		
	$familyid = $_POST["owfamilyid"];
	$nextev = $_POST["ownextev"];	
	$specev = $_POST["owspecev"];
	$atk = $_POST["owatk"];
	$hit = $_POST["owhit"];	
	$rd = $_POST["owrd"];		
	$enc = $_POST["owenc"];
	$price = $_POST["owprice"];
	$equip = $_POST["owequip"];
	$spec = $_POST["owspec"];	
	if ( !$id || !$name || !$atk || !$hit || !$rd || !$enc ) {
		echo "<tr><td colspan=3><center>選項有所遺漏<br></center></td></tr>";	
		exit;
	}
	if ( !$price) { $price = 0; }
	if ( !$equip) { $equip = 0; }
	mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` (`id` ,`name` ,`grade` ,`kind` ,`familyid` ,`nextev` ,`specev` ,`atk` ,`hit` ,`rd` ,`enc` ,`price` ,`equip` ,`spec` ) VALUES ('$id', '$name', '$grade', '$kind', '$familyid', '$nextev', '$specev', '$atk', '$hit', '$rd', '$enc', '$price', '$equip', '$spec');");
	echo "<tr><td colspan=3><center>武器 $name 增加完成<br></center></td></tr>";                        
}
//增加公式
if ("A" == $_POST["operation"] ) {
	echo "<tr><td colspan=3><center>看著辦吧<br></center></td></tr>";
	echo "<tr><td colspan=3><center><form action=manager.php?action=main method=post target=_self>";	
	echo "<table align=center width=250 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";

	$result1 = mysql_query("SELECT tact_id,wep_id,grade FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory`",$db);
	$num_rows = mysql_num_rows($result1);

	echo "<tr align=center><td width=100>公式ID</td>";
	echo "<td width=150>$num_rows</td>";
	echo "<tr align=center><td width=100>武器ID</td>";
	echo "<td width=150><input type=text name='otwep' value = 101 size='20' maxlength=10></td>";
	echo "<tr align=center><td width=100>公式等級</td>";
	echo "<td width=150><input type=text name='otgrade' value = 5 size='20' maxlength=2></td>";
	echo "<tr align=center><td width=100>武器介紹</td>";
	echo "<td width=150><input type=text name='otintro' size='20' maxlength=200></td>";		
	for($i = 0;$i<20;$i++){
		echo "<tr align=center><td width=100>第 $i 號爐</td>";
		echo "<td width=150><input type=text name='ot$i' size='20' maxlength=10></td>";		
	}

	echo "<input type=hidden value='A1' name=operation>";
	echo "<input type=hidden value='$num_rows' name=otid>";		
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\"><br>";
	echo "<tr><td colspan=3><center><input type=submit value='確定'></center></td></tr>";
	echo "</form></center></td></tr>";
}

if ("A1" == $_POST["operation"]) {
	$otid = $_POST["otid"];
	$otwep = $_POST["otwep"];
	$otgrade = $_POST["otgrade"];
	$otintro = $_POST["otintro"];
	for($i = 0;$i<20;$i++){ $ot[$i] = $_POST["ot$i"]; }
	if ( !$otwep || !$ot0 ) {
		echo "<tr><td colspan=3><center>選項有所遺漏<br></center></td></tr>";	
		exit;
	}
	
	mysql_query("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` (`tact_id` ,`wep_id` ,`grade` ,`directions` ,`m1` ,`m2` ,`m3` ,`m4` ,`m5` ,`m6` ,`m7` ,`m8` ,`m9` ,`m10` ,`m11` ,`m12` ,`m13` ,`m14` ,`m15` ,`m16` ,`m17` ,`m18` ,`m19` ,`m20` ) VALUES ('$otid', '$otwep', '$otgrade', '$otintro', '$ot0', '$ot1', '$ot2', '$ot3', '$ot4', '$ot5', '$ot6', '$ot7', '$ot8', '$ot9', '$ot10', '$ot11', '$ot12', '$ot13', '$ot14', '$ot15', '$ot16', '$ot17', '$ot18', '$ot19');");
	echo "<tr><td colspan=3><center>武器 $name 增加到合成公式<br></center></td></tr>";                        
}


echo "</table>";

function wepspec() {
	echo "<tr><td colspan=3><center>武器特效一覽表<br></center></td></tr>";
$ospeclist = array("DamA","機體損壞","DamB","戰鬥不能","MobA","加速","MobB","超前","MobC","閃避","MobD","逃離","Moba","簡單推進","Mobb","強力推進",
"Mobc","最佳化推進","Mobd","高級推進","Mobe","極級推進","TarA","校準","TarB","瞄準","TarC","集中","TarD","預測","Tara","自動鎖定",
"Tarb","高級校準","Tarc","無誤校準","Tard","多重鎖定","Tare","完美鎖定","DefA","簡單防禦","DefB","正常防禦","DefC","強化防禦",
"DefD","高級防禦","DefE","最終防禦","Defa","格擋","Defb","抗衡","Defc","干涉","Defd","堅壁","Defe","空間相對位移","PerfDef","完全防禦",
"AntiDam","自動修復","DoubleExp","經驗雙倍","DoubleMon","金錢雙倍","DefX","底力","AtkA","興奮","MeltA","熔解","MeltB","熔解",
"Cease","禁錮","AntiPDef","貫穿","AntiMobS","網路干擾","AntiTarS","雷達干擾","MirrorDam","鏡","NTCustom","精靈專用",
"NTRequired","需要精靈力量","COCustom","血族專用","PsyRequired","魔法師專用","SeedMode","SEED Mode","EXAMSystem","EXAM系統啟動可能",
"CostSP","消耗SP","HPPcRecA","HP回復","ENPcRecA","EN回復(小)","ENPcRecB","EN回復(大)","ExtHP","HP附加","ExtEN","EN附加",
"FortressOnly","要塞專用","RawMaterials","原料","CannotEquip","無法裝備","DoubleStrike","二連擊","TripleStrike","三連擊",
"AllWepStirke","全彈發射","CounterStrike","反擊","FirstStrike","先制攻擊");
	echo "<table align=center width=500 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td width=100>代碼</td>";
	echo "<td width=150>特效</td>";
	echo "<td width=100>代碼</td>";
	echo "<td width=150>特效</td>";
	$i = 0;
	while($i<=130) {
		echo "<tr align=center><td width=100>$ospeclist[$i]</td>";
		$i++;
		echo "<td width=150>$ospeclist[$i]</td>";	
		$i++;
		echo "<td width=100>$ospeclist[$i]</td>";		
		$i++;
		echo "<td width=150>$ospeclist[$i]</td>";
		$i++;
	}
	echo "</table>";
}
?>


      

