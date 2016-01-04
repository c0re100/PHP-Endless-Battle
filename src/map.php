<?php
header('Content-Type: text/html; charset=utf-8');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser();
if ($CFU_Time >= $_SESSION['timeauth']+$TIME_OUT_TIME || $_SESSION['timeauth'] <= $CFU_Time-$TIME_OUT_TIME){echo "驗證機制！<br>請重新登入！";exit;}
GetUsrDetails("$_SESSION[username]",'Gen','Game');

$Otp_Area_Sql = ("SELECT `name`,`color`,`opttime`,`optstart` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `optmissioni` = 'Atk=($Gen[coordinates])' AND `opttime` > '$CFU_Time' ORDER BY `optstart` ASC LIMIT 1");
$Otp_Area_Q = mysql_query($Otp_Area_Sql) or die(mysql_error());
$Otp_A_ITar = mysql_fetch_array($Otp_Area_Q);

if ($Otp_A_ITar){
if ($Otp_A_ITar['optstart'] > $CFU_Time){
$TimeTSSec = $Otp_A_ITar['optstart'] - $CFU_Time;
$TimetS['hours'] = floor($TimeTSSec/3600);
$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒開始戰爭。";
}
else{
$TimeTSSec = $Otp_A_ITar['opttime'] - $CFU_Time;
$TimetS['hours'] = floor($TimeTSSec/3600);
$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒戰爭宣告終了。";}
}

if ($Otp_A_ITar && $Otp_A_ITar['optstart'] < $CFU_Time){echo "<center>此區域處於戰爭狀態，移動功能暫時關閉！<br>$Otp_TellTime";postFooter();exit;}

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



$Area = ReturnMap("$Gen[coordinates]");
$AreaLandForm = ReturnMType($Area["Sys"]["type"]);

if ($Game['organization'])
$Pl_Org = ReturnOrg("$Game[organization]");
//Special Commands GUI
if ($mode=='Move' && $actionb == 'A'){
        echo "<font style=\"font-size: 12pt\">移動</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";   

        echo "<form action=map.php?action=Move method=post name=mainform>";
        echo "<input type=hidden value='Process' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        
        
        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";

        echo "<tr><td align=left width=250><b style=\"font-size: 10pt;\">現在位置: $AreaLandForm </b></td></tr>";
        echo "<tr><td align=center>";
        echo "<div align=left><b>宇宙地圖:</b></div>";



echo "<table align=center border=0 background=\"unitimg/space.gif\" cellpadding=\"0\" cellspacing=\"0\" style=\"color: white; border-collapse: collapse bordercolor=#111111\" width=90% id=AutoNumber1 height=90%>";
echo "<tr align=center valign=center>";

//Start Non Intelligent mode


$Area = ReturnMap("$Gen[coordinates]");
//$Area_Org = ReturnOrg($Area["User"]["occupied"]);

//$Movements = explode("\n",$Area["Sys"]["movement"]);

echo "</tr><tr align=center valign=center>";


echo "<td width=100 align=center style=\"background: ". $C1_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(C1)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='C1'><br>所羅門宇宙海(C1)</td>";
echo "<td width=100 align=right style=\"background: ". $A2_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(A2)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='A2'><br>火星基地(A2)</td>";
echo "<td width=120 align=right style=\"background: ". $A3_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(A3)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='A3'><br>L3-X18999(A3)</td>";

echo "</tr><tr align=center valign=center>";

echo "<td width=100 align=left style=\"background: ". $B1_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(B1)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='B1'><br>阿·巴瓦·庫(B1)</td>";
echo "<td width=70 align=right style=\"background: ". $B2_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(B2)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='B2'><br>SIDE3(B2)</td>";
echo "<td width=100 style=\"background: ". $B3_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(B3)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='B3'><br>邁錫尼帝國(B3)</td>";

echo "</tr><tr align=center valign=center>";

echo "<td width=100 align=right style=\"background= ". $A1_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(A1)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='A1'><br>馮布朗市(A1)</td>";
echo "<td width=100 valign=top align=right style=\"background: ". $C2_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(C2)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='C2'><br>茨之園(C2)</td>";
echo "<td width=130 align=right style=\"background: ". $C3_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(C3)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='C3'><br>天頂星帝國(C3)</td>";
echo "</tr></table>";

echo "<table align=center border=1 cellpadding=\"0\" cellspacing=\"0\" style=\"color: white; border-collapse: collapse bordercolor=#111111\" width=90% id=AutoNumber1 height=90%>";
echo "<tr align=center valign=center>";
echo "<td width=33% align=left style=\"background= ". $E1_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(E1)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='E1'><br>進入太空(E1)</td>";
echo "<td width=33% align=right style=\"background: ". $E2_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(E2)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='E2'><br>降落地球(E2)</td>";
echo "</tr></table>";

/*echo "<tr><td align=center>";
	echo "<div align=left><b>世界地圖:</b></div>";


echo "<table align=center border=0 background=\"unitimg/earth.gif\" cellpadding=\"0\" cellspacing=\"0\" style=\"color: white; border-collapse: collapse bordercolor=#111111\" width=90% id=AutoNumber1 height=90%>";
echo "<tr align=center valign=center>";

//Start Non Intelligent mode


$Area = ReturnMap("$Gen[coordinates]");
//$Area_Org = ReturnOrg($Area["User"]["occupied"]);

//$Movements = explode("\n",$Area["Sys"]["movement"]);

echo "</tr><tr align=center valign=center>";

echo "<td width=100 align=right style=\"background: ". $D1_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(D1)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='D1'><br>格陵蘭大陸(D1)</td>";
echo "<td width=30% style=\"background: ". $D2_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(D2)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='D2'><br>設德蘭群島(D2)</td>";
echo "<td width=120 align=right style=\"background: ". $D3_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(D3)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='D3'><br>摩爾曼斯克軍港(D3)</td>";

echo "</tr><tr align=center valign=center>";

echo "<td width=70 valign=bottom align=right style=\"background: ". $D4_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(D4)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='D4'><br>休斯頓基地(D4)</td>";
echo "<td width=90 valign=top style=\"background: ". $D5_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(D5)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='D5'><br>直布羅陀海峽(D5)</td>";
echo "<td width=40 valign=top style=\"background: ". $D6_Org[color] ."\">
<input type=radio name=destination";
if(!ereg('(D6)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='D6'><br>帕米爾高原(D6)</td>";

echo "<td width=40 align=left style=\"background: ". $D10_Org[color] ."\">";
if(!ereg('(D10)+',$Area["Sys"]["movement"])) echo "<img src=images/star.gif>";
echo "<br></td>";
echo "</tr><tr align=center valign=center>";


echo "<td width=33% align=left style=\"background= ". $D7_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(D7)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='D7'><br>珊瑚海海域(D7)</td>";
echo "<td width=80 align=right style=\"background: ". $D8_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(D8)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='D8'><br>乞力馬扎羅(D8)</td>";
echo "<td width=90 style=\"background: ". $D9_Org[color] ."\"><input type=radio name=destination";
if(!ereg('(D9)+',$Area["Sys"]["movement"])) echo " disabled";
echo " value='D9'><br>東南亞基地(D9)</td>";

echo "</tr></table>";*/

echo "<tr><td align=center>";
	echo "<div align=left><b>神秘地圖(未開放區域):</b></div>";

	echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\"><input type=submit value=移動>";
	echo "</tr></td></form></table>";
//End Non Intelligent Mode
}
elseif ($mode=='Move' && $actionb == 'Process'){

$Area = ReturnMap("$Gen[coordinates]");
//$Area_Org = ReturnOrg($Area["User"]["occupied"]);
$destination = mysql_real_escape_string($destination);
if (ereg('(D)+',$destination) && $Gen['acc_status'] != '9'){echo "您沒有權限進入禁區。";postFooter();exit;}
if (!$destination){echo "錯誤！請先指定要移動到的目的地。";postFooter();exit;}
if(!ereg('('.$destination.')+',$Area["Sys"]["movement"])){echo "錯誤！";postFooter();exit;}

        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `coordinates` = '$destination',`btltime` = '$CFU_Time' WHERE `username` = '".$Gen['username']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">移動完成了！<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";

}
else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>