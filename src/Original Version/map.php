<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
if (($CFU_Time - $Gen['btltime']) < $Move_Intv){echo "距離上次攻擊或移動的時間太短了！<br>請在 ".($Move_Intv-($CFU_Time - $Gen['btltime']))." 秒後再移動！";exit;}
else{
if ($Gen['msuit']){
	$Pl_Repaired = AutoRepair("$Gen[username]");
	$Game['hp'] = $Pl_Repaired['hp'];
	$Game['en'] = $Pl_Repaired['en'];
	$Game['sp'] = $Pl_Repaired['sp'];
	$Game['status'] = $Pl_Repaired['status'];
	}
else {echo "<center>你沒有機體，不能移動。";postFooter();exit;}
if ($Game['status']){echo "<center>修理中，無法移動。";postFooter();exit;}
}


//$AreaLandForm = ReturnMType($Area["Sys"]["type"]);

if ($Game['organization'])
$Pl_Org = ReturnOrg("$Game[organization]");
//Special Commands GUI
if ($mode=='Move' && $actionb == 'A'){
	echo "<font style=\"font-size: 12pt\">移動</font>";
	echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";

	echo "<form action=map.php?action=Move method=post name=mainform>";
	echo "<input type=hidden value='Process' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
	
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=250><b style=\"font-size: 10pt;\">移動的可能性: </b></td></tr>";
	echo "<tr><td align=center>";
	echo "<div align=left><b>世界地圖:</b></div>";



echo "<table align=center border=0 cellpadding=0 cellspacing=0 style=\"color: white; border-collapse: collapse bordercolor=#111111\" width=90% id=AutoNumber1 height=90%>";
echo "<tr align=center valign=center>";


//Start Non Intelligent mode


$Area = ReturnMap("$Gen[coordinates]");
//$Area_Org = ReturnOrg($Area["User"]["occupied"]);

$A1_Inf = ReturnMap("A1");
$A1_Org = ReturnOrg($A1_Inf["User"]["occupied"]);

$A2_Inf = ReturnMap("A2");
$A2_Org = ReturnOrg($A2_Inf["User"]["occupied"]);

$A3_Inf = ReturnMap("A3");
$A3_Org = ReturnOrg($A3_Inf["User"]["occupied"]);

$B1_Inf = ReturnMap("B1");
$B1_Org = ReturnOrg($B1_Inf["User"]["occupied"]);

$B2_Inf = ReturnMap("B2");
$B2_Org = ReturnOrg($B2_Inf["User"]["occupied"]);

$B3_Inf = ReturnMap("B3");
$B3_Org = ReturnOrg($B3_Inf["User"]["occupied"]);

$C1_Inf = ReturnMap("C1");
$C1_Org = ReturnOrg($C1_Inf["User"]["occupied"]);

$C2_Inf = ReturnMap("C2");
$C2_Org = ReturnOrg($C2_Inf["User"]["occupied"]);

$C3_Inf = ReturnMap("C3");
$C3_Org = ReturnOrg($C3_Inf["User"]["occupied"]);

//$Movements = explode("\n",$Area["Sys"]["movement"]);
echo "<td width=33% style=\"background: ". $C1_Org['color'] ."\"><input type=radio name=destination";
if(!ereg('(C1)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='C1'><br>C1</td>";
echo "<td width=33% style=\"background: ". $C2_Org['color'] ."\"><input type=radio name=destination";
if(!ereg('(C2)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='C2'><br>C2</td>";
echo "<td width=34% style=\"background: ". $C3_Org['color'] ."\"><input type=radio name=destination";
if(!ereg('(C3)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='C3'><br>C3</td>";

echo "</tr><tr align=center valign=center>";

echo "<td width=33% style=\"background: ". $B1_Org['color'] ."\"><input type=radio name=destination";
if(!ereg('(B1)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='B1'><br>B1</td>";
echo "<td width=33% style=\"background: ". $B2_Org['color'] ."\"><input type=radio name=destination";
if(!ereg('(B2)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='B2'><br>B2</td>";
echo "<td width=34% style=\"background: ". $B3_Org['color'] ."\"><input type=radio name=destination";
if(!ereg('(B3)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='B3'><br>B3</td>";

echo "</tr><tr align=center valign=center>";

echo "<td width=33% style=\"background: ". $A1_Org['color'] ."\"><input type=radio name=destination";
if(!ereg('(A1)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='A1'><br>A1</td>";
echo "<td width=33% style=\"background: ". $A2_Org['color'] ."\"><input type=radio name=destination";
if(!ereg('(A2)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='A2'><br>A2</td>";
echo "<td width=34% style=\"background: ". $A3_Org['color'] ."\"><input type=radio name=destination";
if(!ereg('(A3)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='A3'><br>A3</td>";

echo "</tr></table>";
	echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\"><input type=submit value=移動>";
	echo "</tr></td></form></table>";
//End Non Intelligent Mode
}
elseif ($mode=='Move' && $actionb == 'Process'){

$Area = ReturnMap("$Gen[coordinates]");
//$Area_Org = ReturnOrg($Area["User"]["occupied"]);
if (!$destination){echo "錯誤！請先指定要移動到的目的地。";postFooter();exit;}
if(!ereg('('.$destination.')+',$Area["Sys"]["movement"])){echo "錯誤！";postFooter();exit;}

	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `coordinates` = '$destination',`btltime` = '$CFU_Time' WHERE `username` = '".$Gen['username']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
	echo "<p align=center style=\"font-size: 16pt\">移動完成了！<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

}
else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>