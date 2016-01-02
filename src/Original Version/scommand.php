<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
$Pl_Settings_Query = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_settings` WHERE username='". $Gen['username'] ."'");
$Pl_Settings = mysql_fetch_array(mysql_query ($Pl_Settings_Query));
if ($Game['organization'])
$Pl_Org = ReturnOrg("$Game[organization]");
$Area = ReturnMap("$Gen[coordinates]");
//$AreaLandForm = ReturnMType($Area["Sys"]["type"]);
$Ar_Org = ReturnOrg($Area["User"]["occupied"]);
//Special Commands GUI
if ($mode=='main'){
	$SC_Prsn = $SC_Sys = $SC_Sys_Impt = $SC_Org = $SC_Org_Impt = $SC_Area = (string) ''; // Declare Variables
	echo "<font style=\"font-size: 12pt\">特殊指令</font>";
	echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";

	echo "<form action=scommand.php?action=main method=post name=mainform>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";


	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=250><b style=\"font-size: 10pt;\">特殊指令列表: </b></td></tr>";
	echo "<tr><td align=center>";

//組織指令
	
	if ($Gen['cash'] > $OrganizingCost && !$Game['organization'] && ($Gen['fame'] >= $OrganizingFame || $Gen['fame'] <= $OrganizingNotor))
	$SC_Org .= "<input type=\"submit\" value=\"成立組織\" onClick=\"mainform.action='organization.php?action=Start';actionb.value='A';\">";

	if (!$Game['organization'])
	$SC_Org .= "<input type=\"submit\" value=\"加入組織\" onClick=\"mainform.action='organization.php?action=JoinOrg';actionb.value='A';\">";

	if ($Game['organization'] && $Game['rights']){
	$SC_Org .= "<input type=\"submit\" value=\"招募人才\" onClick=\"mainform.action='organization.php?action=Employ';actionb.value='A';\">";
	$SC_Org .= "<input type=\"submit\" value=\"退位\" onClick=\"mainform.action='organization.php?action=LeavePlace';actionb.value='A';\">";
	$SC_Org .= "<input type=\"submit\" value=\"解雇\" onClick=\"mainform.action='organization.php?action=Dismiss';actionb.value='A';\">";
	}
	if ($Game['organization'] && $Game['rights'] == '1'){
	$SC_Org .= "<input type=\"submit\" value=\"組織設定\" onClick=\"mainform.action='organization.php?action=Settings';actionb.value='A';\">";
	$SC_Org .= "<input type=\"submit\" value=\"攻略計劃\" onClick=\"mainform.action='organization.php?action=CityAtk';actionb.value='A';\">";
	}
	if ($Game['organization'] && !$Game['rights'] && $Pl_Org['license'] != 1 && $Pl_Org['license'] != 3){
	echo "<script language=\"Javascript\">";
	echo "function cfmLeaveOrg(){";
	echo "if (confirm('真的要離開組織嗎？\\n您只會被問這一次，請考慮清楚。')==true){";
	echo "mainform.action='organization.php?action=LeaveOrg';mainform.actionb.value='A';return true;}";
	echo "else {return false;}";
	echo "}</script>";
	$SC_Org_Impt .= "<input type=\"submit\" value=\"脫離組織\" onClick=\"return cfmLeaveOrg();\">";
	}
	elseif ($Game['organization'] && !$Game['rights'] && $Pl_Org['license'] != 0 && $Pl_Org['license'] != 2 && $Gen['fame'] >= 10){
	echo "<script language=\"Javascript\">";
	echo "function cfmLeaveOrg(){";
	echo "if (confirm('逃亡有損您的名聲\\n真的要離開組織嗎？\\n您只會被問這一次，請考慮清楚。')==true){";
	echo "mainform.action='organization.php?action=LeaveOrg';mainform.actionb.value='B';return true;}";
	echo "else {return false;}";
	echo "}</script>";
	$SC_Org_Impt .= "<input type=\"submit\" value=\"逃亡\" onClick=\"return cfmLeaveOrg();\">";
	}
	elseif ($Game['organization'] && !$Game['rights'] && $Pl_Org['license'] != 0 && $Pl_Org['license'] != 2 && $Gen['fame'] < 10){
	echo "<script language=\"Javascript\">";
	echo "function cfmLeaveOrg(){";
	echo "if (confirm('逃亡會敗壞你的名聲\\n真的要逃亡離開組織嗎？\\n您只會被問這一次，請考慮清楚。')==true){";
	echo "mainform.action='organization.php?action=LeaveOrg';mainform.actionb.value='C';return true;}";
	echo "else {return false;}";
	echo "}</script>";
	$SC_Org_Impt .= "<input type=\"submit\" value=\"逃亡\" onClick=\"return cfmLeaveOrg();\">";
	}
	if ($Game['organization'] && $Game['rights'] == '1'){
	echo "<script language=\"Javascript\">";
	echo "function cfmBreakOrg(){";
	echo "if (confirm('真的要解散組織嗎？\\n您只會被問這一次，請考慮清楚。')==true){";
	echo "mainform.action='organization.php?action=Break';mainform.actionb.value='A';return true;}";
	echo "else {return false;}";
	echo "}</script>";
	$SC_Org_Impt .= "<input type=\"submit\" value=\"解散組織\" onClick=\"return cfmBreakOrg()\">";
	}

//區域指令
	if ($Area["User"]["occupied"] == $Game['organization'] && $Game['rights'] == '1')
	$SC_Area .= "<input type=\"submit\" value=\"強化城塞\" onClick=\"mainform.action='city.php?action=ModFort';actionb.value='A';\">";

//系統指令
	$SC_Sys = "<input type=\"submit\" value=\"更改密碼\" onClick=\"mainform.action='scommand.php?action=chpass';actionb.value='A';\">";
	$SC_Sys .= "<input type=\"submit\" value=\"遊戲設定\" onClick=\"mainform.action='scommand.php?action=settings';actionb.value='A';\">";
	
	//重要指令
	$SC_Sys_Impt = "<input type=\"submit\" value=\"刪除帳戶\" onClick=\"mainform.action='scommand.php?action=delete_account';actionb.value='A';\">";

//個人指令
	if (ereg('nat',$Gen['typech']) && $Gen['cash'] >= $ModChType_Cost)
	$SC_Prsn .= "<input type=\"submit\" value=\"人種改造\" onClick=\"mainform.action='statsmod.php?action=modtypech';actionb.value='A';\">";
	if ($Game['v_points'] >= $VPt2AlloyReq)
	$SC_Prsn .= "<input type=\"submit\" value=\"兌換合金\" onClick=\"mainform.action='scommand.php?action=redeemAlloy';actionb.value='A';\">";

//列出指令
	if ($SC_Prsn){
	echo "<div align=left><b>個人指令:</b></div>";
	echo "$SC_Prsn";}

	if ($SC_Sys){
	echo "<div align=left><b>系統指令:</b></div>";
	echo "$SC_Sys";}
	if ($SC_Sys_Impt)
	echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\"><b>重要指令:</b><br>$SC_Sys_Impt";

	if ($SC_Org){
	echo "<div align=left><b>組織相關指令:</b></div>";
	echo "$SC_Org";}
	if ($SC_Org_Impt)
	echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\"><b>重要指令:</b><br>$SC_Org_Impt";

	if ($SC_Area){
	echo "<div align=left><b>區域相關指令:</b></div>";
	echo "$SC_Area";}
	echo "</tr></td></form></table>";
}
elseif ($mode=='chpass' && $actionb == 'A'){

	echo "<font style=\"font-size: 12pt\">特殊指令</font>";
	echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";

	echo "<form action=scommand.php?action=chpass method=post name=mainform target=_parent>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=225><b style=\"font-size: 10pt;\">更改密碼: </b></td></tr>";
	echo "<tr><td align=center>";

	echo "<script language=\"JavaScript\">";
	echo "function vldPass(){";
	echo "if (document.getElementById('pwd').value != '$Pl_Value[PASSWORD]'){alert('密碼不正確。');return false;}";
	echo "else if(!mainform.new_password.value){alert('重新輸入新密碼。');return false;}";
	echo "else if(mainform.new_password.value != mainform.vld_password.value){alert('重新輸入的密碼與新密碼不相同，請重新輸入。');return false;}";
	echo "else {return true;}";
	echo "}</script>";

	echo "現在密碼: <input type=password name=Pl_Value[PASSWORD] id=pwd><br>";
	echo "新的密碼: <input type=password name=new_password value='' maxlength=16><br>";
	echo "重新輸入: <input type=password name=vld_password value='' maxlength=16><br>";
	echo "<input type=submit value=\"確定\" onClick=\"return vldPass();\"><input type=reset value=\"重新設定\">";

	echo "</tr></td></form></table>";


}
elseif ($mode=='chpass' && $actionb == 'B'){
if ($new_password) {
	if ($new_password != $vld_password){echo "<center><br><br>兩組新密碼不相符。<br><br>";postFooter();exit;}
	mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `password` = md5('".$new_password."') WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;") or die(mysql_error());
	}
	echo "<br><br><br><br><br><p align=center style=\"font-size: 16pt\">密碼更新完成！<br>";
	echo "<form action=\"gmscrn_main.php?action=proc\" method=post name=login>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$new_password' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<input type=submit value=\"返回遊戲\">";
	echo "</form>";
	echo "<br><br><br>";
}
elseif ($mode=='settings' && $actionb == 'A'){
	echo "<font style=\"font-size: 12pt\">特殊指令</font>";
	echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";

	echo "<form action=scommand.php?action=settings method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=500><b style=\"font-size: 10pt;\">遊戲設定: ";
	if ($ModifiedFlag) echo "<br><font color=yellow>更新完成！</font>";
	echo "</b></td></tr>";
	echo "<tr><td align=left>";

	if ($LogEntries){
	echo "顯示戰鬥歷程紀錄則數: <select name=Pl_Set_LogNum>";
	for ($i=0;$i<=$LogEntries;$i++) {echo "<option value='".$i."'"; if ($Pl_Settings['show_log_num'] == $i)echo " selected";echo ">".$i;}
	echo "</select><br>";}


	echo "攻擊在線玩家警告: <input type=radio name=Pl_Set_AtkOnlineAlrt value=1";
	if($Pl_Settings['atkonline_alert']) echo " checked";
	echo "> 開啟 <input type=radio name=Pl_Set_AtkOnlineAlrt value=0";
	if(!$Pl_Settings['atkonline_alert']) echo " checked";echo "> 關閉<br><br>";

	echo "<b>圖片集位置設定</b><br>以下不設定(空白)則會使用伺服器預設<br>請勿使用全型字元(包括中文字), 以避免亂碼!<br>請用以下方式輸入:<br>";
	echo "　http://你的網址/路徑 &nbsp; &nbsp; &nbsp; &nbsp; (這例子會讀取別伺服器的圖片檔)<br>";
	echo "　file:///C:/路徑 &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (這例子會讀取自己電腦上的圖片檔)<br>";
	echo "背景圖片: ";
	echo "<input type=text name='gen_img_dir' size='32' maxlength=128 value='$Pl_Settings[gen_img_dir]'><br>";
	echo "機體圖片: ";
	echo "<input type=text name='unit_img_dir' size='32' maxlength=128 value='$Pl_Settings[unit_img_dir]'><br>";
	echo "系統圖片: ";
	echo "<input type=text name='base_img_dir' size='32' maxlength=128 value='$Pl_Settings[base_img_dir]'><br><br>";

	echo "<b>戰鬥列表過濾系統設定</b><br>";
	echo "戰鬥列表過濾系統設定能加快遊戲速度, 更可方便玩家練功\<br>如要使用的話, 請先選取<b>不使用</b>預設設定<br><br>";
	echo "請注意不要顯示太多欄位, 否則會<b>嚴重減慢遊戲速度</b>!<br>另外請注意: <b>不使用預設設定</b><u style=\"color: red\">無法攻擊要塞</u>！<br><br>";
	echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>使用預設設定</b>: <input type=radio name=Pl_Set_BatDefFilter value=1";
	if($Pl_Settings['battle_def_filter']) echo " checked";
	echo "> 使用 <input type=radio name=Pl_Set_BatDefFilter value=0";
	if(!$Pl_Settings['battle_def_filter']) echo " checked";echo "> 不使用<br><br>";

	echo "　　<b>欄位顯示</b><br>";
	echo "<table width=50% border=0>";

	echo "<tr>";
	echo "<td align=right>Attacking 級數:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_at value=1";
	if($Pl_Settings['fdis_at']) echo " checked";
	echo "> 顯示 <input type=radio name=Pl_Set_fdis_at value=0";
	if(!$Pl_Settings['fdis_at']) echo " checked";echo "> 不顯示<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>Defending 級數:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_de value=1";
	if($Pl_Settings['fdis_de']) echo " checked";
	echo "> 顯示 <input type=radio name=Pl_Set_fdis_de value=0";
	if(!$Pl_Settings['fdis_de']) echo " checked";echo "> 不顯示<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>Reacting 級數:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_re value=1";
	if($Pl_Settings['fdis_re']) echo " checked";
	echo "> 顯示 <input type=radio name=Pl_Set_fdis_re value=0";
	if(!$Pl_Settings['fdis_re']) echo " checked";echo "> 不顯示<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>Targeting 級數:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_ta value=1";
	if($Pl_Settings['fdis_ta']) echo " checked";
	echo "> 顯示 <input type=radio name=Pl_Set_fdis_ta value=0";
	if(!$Pl_Settings['fdis_ta']) echo " checked";echo "> 不顯示<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>Level:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_lv value=1";
	if($Pl_Settings['fdis_lv']) echo " checked";
	echo "> 顯示 <input type=radio name=Pl_Set_fdis_lv value=0";
	if(!$Pl_Settings['fdis_lv']) echo " checked";echo "> 不顯示<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>HP:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_hp value=1";
	if($Pl_Settings['fdis_hp']) echo " checked";
	echo "> 顯示 <input type=radio name=Pl_Set_fdis_hp value=0";
	if(!$Pl_Settings['fdis_hp']) echo " checked";echo "> 不顯示<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>名聲及惡名:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_fame value=1";
	if($Pl_Settings['fdis_fame']) echo " checked";
	echo "> 顯示 <input type=radio name=Pl_Set_fdis_fame value=0";
	if(!$Pl_Settings['fdis_fame']) echo " checked";echo "> 不顯示<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>懸賞金:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_bty value=1";
	if($Pl_Settings['fdis_bty']) echo " checked";
	echo "> 顯示 <input type=radio name=Pl_Set_fdis_bty value=0";
	if(!$Pl_Settings['fdis_bty']) echo " checked";echo "> 不顯示<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>使用MS:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_ms value=1";
	if($Pl_Settings['fdis_ms']) echo " checked";
	echo "> 顯示 <input type=radio name=Pl_Set_fdis_ms value=0";
	if(!$Pl_Settings['fdis_ms']) echo " checked";echo "> 不顯示<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>人物Type:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_tch value=1";
	if($Pl_Settings['fdis_tch']) echo " checked";
	echo "> 顯示 <input type=radio name=Pl_Set_fdis_tch value=0";
	if(!$Pl_Settings['fdis_tch']) echo " checked";echo "> 不顯示<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right>上線及下線狀態:</td>";
	echo "<td><input type=radio name=Pl_Set_fdis_con value=1";
	if($Pl_Settings['fdis_con']) echo " checked";
	echo "> 顯示 <input type=radio name=Pl_Set_fdis_con value=0";
	if(!$Pl_Settings['fdis_con']) echo " checked";echo "> 不顯示<br>";
	echo "</td></tr>";
	echo "</table>";

	echo "<br>　　<b>過濾選項</b><br>";
	echo "<table width=60% border=0>";

	echo "<tr>";
	echo "<td align=right width=37.5%>Attacking 範圍:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_at_min] name='Pl_Set_filter_at_min' size=2 maxlength=3>至";
	echo "<input type=text value=$Pl_Settings[filter_at_max] name='Pl_Set_filter_at_max' size=2 maxlength=3>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> Defending 範圍:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_de_min] name='Pl_Set_filter_de_min' size=2 maxlength=3>至";
	echo "<input type=text value=$Pl_Settings[filter_de_max] name='Pl_Set_filter_de_max' size=2 maxlength=3>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> Reacting 範圍:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_re_min] name='Pl_Set_filter_re_min' size=2 maxlength=3>至";
	echo "<input type=text value=$Pl_Settings[filter_re_max] name='Pl_Set_filter_re_max' size=2 maxlength=3>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> Targeting 範圍:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_ta_min] name='Pl_Set_filter_ta_min' size=2 maxlength=3>至";
	echo "<input type=text value=$Pl_Settings[filter_ta_max] name='Pl_Set_filter_ta_max' size=2 maxlength=3>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> Level 範圍:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_lv_min] name='Pl_Set_filter_lv_min' size=2 maxlength=3>至";
	echo "<input type=text value=$Pl_Settings[filter_lv_max] name='Pl_Set_filter_lv_max' size=2 maxlength=3>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> HP上限範圍:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_hp_min] name='Pl_Set_filter_hp_min' size=5 maxlength=6>至";
	echo "<input type=text value=$Pl_Settings[filter_hp_max] name='Pl_Set_filter_hp_max' size=5 maxlength=6>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> 懸賞金範圍:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_bty_min] name='Pl_Set_filter_bty_min' size=8 maxlength=10>至";
	echo "<input type=text value=$Pl_Settings[filter_bty_max] name='Pl_Set_filter_bty_max' size=8 maxlength=10>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> 名聲及惡名範圍:</td>";
	echo "<td><input type=text value=$Pl_Settings[filter_fame_min] name='Pl_Set_filter_fame_min' size=8 maxlength=10>至";
	echo "<input type=text value=$Pl_Settings[filter_fame_max] name='Pl_Set_filter_fame_max' size=8 maxlength=10>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> 上線或下線:</td>";
	echo "<td><input type=radio name=Pl_Set_filter_con value=1";
	if($Pl_Settings['filter_con'] == 1) echo " checked";
	echo "> 顯示上線 <input type=radio name=Pl_Set_filter_con value=2";
	if($Pl_Settings['filter_con'] == 2) echo " checked";
	echo "> 顯示離線<br><input type=radio name=Pl_Set_filter_con value=0";
	if(!$Pl_Settings['filter_con']) echo " checked";echo "> 同時顯示<br>";
	echo "</td></tr>";

	echo "<tr>";
	echo "<td align=right> 排列參照:</td>";
	echo "<td><select name=filter_sort>";
	unset($i,$e);
	foreach(array('組織','攻擊能力','防禦能力','反應','命中','等級','HP','懸賞金','時間') as $i => $e){
	echo "<option value=".$i;
	if ($Pl_Settings['filter_sort'] == $i) echo " selected";
	echo ">$e";
	}
	unset($i,$e);
	echo "</select></td></tr>";

	echo "<tr>";
	echo "<td align=right> 排列次序:</td>";
	echo "<td><input type=radio name=filter_sort_asc value=1";
	if($Pl_Settings['filter_sort_asc']) echo " checked";
	echo "> 小至大 <input type=radio name=filter_sort_asc value=0";
	if(!$Pl_Settings['filter_sort_asc']) echo " checked";echo "> 大至小<br>";
	echo "</td></tr>";


	echo "</table>";

	echo "<input type=submit value=\"確定\"><input type=reset value=\"重新設定\">";

	echo "</tr></td></form></table>";


}
elseif ($mode=='settings' && $actionb == 'B'){

unset($Set,$i);
$i = 0;

$Pl_Set_LogNum = intval($Pl_Set_LogNum);
if ($Pl_Settings['show_log_num'] != $Pl_Set_LogNum && $Pl_Set_LogNum <= $LogEntries && $Pl_Set_LogNum >= 0){
$Set[$i] = "`show_log_num` = '$Pl_Set_LogNum'";$i++;}

if ($Pl_Settings['atkonline_alert'] != $Pl_Set_AtkOnlineAlrt){
$Set[$i] = ($Pl_Set_AtkOnlineAlrt) ? "`atkonline_alert` = '1'" : "`atkonline_alert` = '0'";$i++;
}

if ($Pl_Settings['gen_img_dir'] != $gen_img_dir){
$gen_img_dir = ereg_replace("[\*\?\"\<\>\|\'\`]+",'',$gen_img_dir);
$Set[$i] = "`gen_img_dir` = '$gen_img_dir'";$i++;
}

if ($Pl_Settings['unit_img_dir'] != $unit_img_dir){
$unit_img_dir = ereg_replace("[\*\?\"\<\>\|\'\`]+",'',$unit_img_dir);
$Set[$i] = "`unit_img_dir` = '$unit_img_dir'";$i++;
}

if ($Pl_Settings['base_img_dir'] != $base_img_dir){
$base_img_dir = ereg_replace("[\*\?\"\<\>\|\'\`]+",'',$base_img_dir);
$Set[$i] = "`base_img_dir` = '$base_img_dir'";$i++;
}

if ($Pl_Settings['battle_def_filter'] != $Pl_Set_BatDefFilter){
$Set[$i] = ($Pl_Set_BatDefFilter) ? "`battle_def_filter` = '1'" : "`battle_def_filter` = '0'";$i++;
}

//Displays

if ($Pl_Settings['fdis_at'] != $Pl_Set_fdis_at){
$Set[$i] = ($Pl_Set_fdis_at) ? "`fdis_at` = '1'" : "`fdis_at` = '0'";$i++;
}

if ($Pl_Settings['fdis_de'] != $Pl_Set_fdis_de){
$Set[$i] = ($Pl_Set_fdis_de) ? "`fdis_de` = '1'" : "`fdis_de` = '0'";$i++;
}

if ($Pl_Settings['fdis_re'] != $Pl_Set_fdis_re){
$Set[$i] = ($Pl_Set_fdis_re) ? "`fdis_re` = '1'" : "`fdis_re` = '0'";$i++;
}

if ($Pl_Settings['fdis_ta'] != $Pl_Set_fdis_ta){
$Set[$i] = ($Pl_Set_fdis_ta) ? "`fdis_ta` = '1'" : "`fdis_ta` = '0'";$i++;
}

if ($Pl_Settings['fdis_lv'] != $Pl_Set_fdis_lv){
$Set[$i] = ($Pl_Set_fdis_lv) ? "`fdis_lv` = '1'" : "`fdis_lv` = '0'";$i++;
}

if ($Pl_Settings['fdis_hp'] != $Pl_Set_fdis_hp){
$Set[$i] = ($Pl_Set_fdis_hp) ? "`fdis_hp` = '1'" : "`fdis_hp` = '0'";$i++;
}

if ($Pl_Settings['fdis_fame'] != $Pl_Set_fdis_fame){
$Set[$i] = ($Pl_Set_fdis_fame) ? "`fdis_fame` = '1'" : "`fdis_fame` = '0'";$i++;
}

if ($Pl_Settings['fdis_bty'] != $Pl_Set_fdis_bty){
$Set[$i] = ($Pl_Set_fdis_bty) ? "`fdis_bty` = '1'" : "`fdis_bty` = '0'";$i++;
}

if ($Pl_Settings['fdis_ms'] != $Pl_Set_fdis_ms){
$Set[$i] = ($Pl_Set_fdis_ms) ? "`fdis_ms` = '1'" : "`fdis_ms` = '0'";$i++;
}

if ($Pl_Settings['fdis_tch'] != $Pl_Set_fdis_tch){
$Set[$i] = ($Pl_Set_fdis_tch) ? "`fdis_tch` = '1'" : "`fdis_tch` = '0'";$i++;
}

if ($Pl_Settings['fdis_con'] != $Pl_Set_fdis_con){
$Set[$i] = ($Pl_Set_fdis_con) ? "`fdis_con` = '1'" : "`fdis_con` = '0'";$i++;
}

if ($Pl_Settings['fdis_con'] != $Pl_Set_fdis_con){
$Set[$i] = ($Pl_Set_fdis_con) ? "`fdis_con` = '1'" : "`fdis_con` = '0'";$i++;
}

//Filters

unset($l,$m);
$l = array('at','de','re','ta','lv');

foreach($l as $m){
	unset($j,$k,$vi,$va,$Vi,$Va);
	$Vi = 'Pl_Set_filter_'.$m.'_min';
	$Va = 'Pl_Set_filter_'.$m.'_max';
	$vi = 'filter_'.$m.'_min';
	$va = 'filter_'.$m.'_max';
	$j = intval($$Vi);$k = intval($$Va);
	if ($j > 100) $j = 100;elseif ($j < 0) $j = 0;
	if ($k > 100) $k = 100;elseif ($k < 0) $k = 0;
	if ($Pl_Settings[$vi] != $j && $j <= $k){
	$Set[$i] = "`$vi` = '$j'";$i++;
	}
	if ($Pl_Settings[$va] != $k && $j <= $k){
	$Set[$i] = "`$va` = '$k'";$i++;
	}
}

unset($j,$k);
$j = intval($Pl_Set_filter_hp_min);$k = intval($Pl_Set_filter_hp_max);
if ($j > 9999999) $j = 9999999;elseif ($j < 0) $j = 0;
if ($k > 9999999) $k = 9999999;elseif ($k < 0) $k = 0;
if ($Pl_Settings['filter_hp_min'] != $j && $j <= $k){
$Set[$i] = "`filter_hp_min` = '$j'";$i++;
}
if ($Pl_Settings['filter_hp_max'] != $k && $j <= $k){
$Set[$i] = "`filter_hp_max` = '$k'";$i++;
}

unset($j,$k);
$j = intval($Pl_Set_filter_fame_min);$k = intval($Pl_Set_filter_fame_max);
if ($j > 1000) $j = 1000;elseif ($j < -1000) $j = -1000;
if ($k > 1000) $k = 1000;elseif ($k < -1000) $k = -1000;
if ($Pl_Settings['filter_fame_min'] != $j && $j <= $k){
$Set[$i] = "`filter_fame_min` = '$j'";$i++;
}
if ($Pl_Settings['filter_fame_max'] != $k && $j <= $k){
$Set[$i] = "`filter_fame_max` = '$k'";$i++;
}

unset($j,$k);
$j = intval($Pl_Set_filter_bty_min);$k = intval($Pl_Set_filter_bty_max);
if ($j > 9999999999) $j = 9999999999;elseif ($j < 0) $j = 0;
if ($k > 9999999999) $k = 9999999999;elseif ($k < 0) $k = 0;
if ($Pl_Settings['filter_bty_min'] != $j && $j <= $k){
$Set[$i] = "`filter_bty_min` = '$j'";$i++;
}
if ($Pl_Settings['filter_bty_max'] != $k && $j <= $k){
$Set[$i] = "`filter_bty_max` = '$k'";$i++;
}

if ($Pl_Settings['filter_con'] != $Pl_Set_filter_con){
if ($Pl_Set_filter_con == 1) $Set[$i] = "`filter_con` = '1'";
elseif ($Pl_Set_filter_con == 2) $Set[$i] = "`filter_con` = '2'";
else $Set[$i] = "`filter_con` = '0'";
$i++;
}

$filter_sort = intval($filter_sort);
if ($Pl_Settings['filter_sort'] != $filter_sort && $filter_sort >= 0 && $filter_sort <= 8){
$Set[$i] = "`filter_sort` = '$filter_sort'";
$i++;
}

if ($Pl_Settings['filter_sort_asc'] != $filter_sort_asc){
$Set[$i] = ($filter_sort_asc) ? "`filter_sort_asc` = '1'" : "`filter_sort_asc` = '0'";$i++;
}

unset($v,$k,$l,$SettingsQuery);
$SettingsQuery = '';
foreach($Set as $k => $v){$l = $k + 1;
	$SettingsQuery .= "$v";
	if ($l < $i) $SettingsQuery .= ', ';
}

if ($SettingsQuery)
mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_settings` SET ".$SettingsQuery." WHERE `username` = '".$Pl_Value['USERNAME']."' LIMIT 1 ;") or die(mysql_error()."<br>$SettingsQuery");

	echo "<form action=scommand.php?action=settings method=post name=mainform>";
	echo "<input type=hidden value='A' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<input type=hidden name=\"ModifiedFlag\" value=1></form>";
	//echo "<script language=\"JavaScript\">setTimeout(\"mainform.submit();\",1000);</script>";

	echo "<script language=\"JavaScript\">mainform.submit()</script>";
}
//開始刪除帳戶系統
elseif ($mode == 'delete_account' && $actionb == 'A'){

	echo "<font style=\"font-size: 12pt\">特殊指令</font>";
	echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";

	echo "<form action=scommand.php?action=delete_account method=post name=mainform target=_parent>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=225><b style=\"font-size: 10pt;\">刪除帳戶: </b></td></tr>";
	echo "<tr><td align=left>";
	echo "<b>警告</b><Br>您可以在這裡刪除這個帳戶<br>不過組織領導人需要先行解散組織<br>一經刪除，所有資料，包括倉庫內的裝備<Br>都會被刪去，請閣下考慮清楚！<Br>";
	echo "<script language=\"JavaScript\">";
	echo "function vldPass(){";
		echo "if (document.getElementById('pwd').value != '$Pl_Value[PASSWORD]'){alert('密碼不正確。');return false;}";
		echo "else if (confirm('真的要刪除帳戶嗎？\\n您只會被問這一次，一旦刪除，便不能復原，請考慮清楚！') == true) {return true;}";
		echo "else {return false;}";
	echo "}</script>";
	echo "<hr>輸入密碼: <input type=password name=Pl_Value[PASSWORD] id=pwd><br>";
	echo "確定刪除: <input type=checkbox onClick=\"if (sbm_btn.disabled == true) sbm_btn.disabled = false; else sbm_btn.disabled = true;\"><br>";
	echo "<center><input type=submit name=sbm_btn disabled value=\"刪除帳戶\" onClick=\"return vldPass();\">";

	echo "</tr></td></form></table>";

}
elseif ($mode == 'delete_account' && $actionb == 'B'){
	
	if ($Game['rights'] == '1'){
	echo "<br><br><br><br><br><p align=center style=\"font-size: 16pt\">組織領導人要先行解散組織！<br>";
	echo "<form action=\"gmscrn_main.php?action=proc\" method=post name=login>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<input type=submit value=\"返回遊戲\">";
	echo "</form>";
	echo "<br><br><br>";
	exit;
	}
	
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_log` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_settings` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	mysql_query ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE `username` = '".$Pl_Value['USERNAME']."' Limit 1;");
	
	echo "<br><br><br><br><br><p align=center style=\"font-size: 16pt\">已經刪除帳戶 <b style='color: red'>$Pl_Value[USERNAME]</b> 。。。<br>";
	echo "<input type=button value=\"返回主頁\" onclick=\"location.replace('index2.php');\">";
	echo "<br><br><br>";
}
//完結刪除帳戶系統
//開始兌換合金系統
elseif ($mode == 'redeemAlloy' && $actionb == 'A'){

	echo "<font style=\"font-size: 12pt\">特殊指令</font>";
	echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";

	echo "<form action=scommand.php?action=redeemAlloy method=post name=mainform>";
	echo "<input type=hidden value='B' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=left width=225><b style=\"font-size: 10pt;\">兌換合金: </b></td></tr>";
	echo "<tr><td align=left>";
	echo "您可以在這裡用勝利績分兌換 「新高達尼姆合金」 <br>兌換比率: <b>1 比 ".number_format($VPt2AlloyReq)."</b><Br>即是 ".number_format($VPt2AlloyReq)."點 勝利績分 可以換到 1 個合金！<br>";
	echo "所兌換的合金，會直接存到閣下的倉庫，請先確定倉庫有沒有多餘空間！<br>";
	echo "您的勝利績分: $Game[v_points]<br>";
	echo "<script language=\"JavaScript\">";
	echo "function vldPass(){";
		echo "if (document.getElementById('pwd').value != '$Pl_Value[PASSWORD]'){alert('密碼不正確。');return false;}";
		echo "else if (confirm('真的要兌換合金嗎？\\n您只會被問這一次，一旦兌換完成，合金不能還原成勝利績分，請考慮清楚！') == true) {return true;}";
		echo "else {return false;}";
	echo "}</script>";
	echo "<hr><center>兌換<select name=amountAlloy>";
	$MaxAmount = floor($Game['v_points']/$VPt2AlloyReq);
	for($i=1;$i<=$MaxAmount;$i++) echo "<option value=$i>$i";
	echo "</select>個合金</center>";
	echo "<hr>請輸入密碼: <input type=password name=Pl_Value[PASSWORD] id=pwd><br>";
	echo "確定兌換: <input type=checkbox onClick=\"if (sbm_btn.disabled == true) sbm_btn.disabled = false; else sbm_btn.disabled = true;\"><br>";
	echo "<center><input type=submit name=sbm_btn disabled value=\"兌換合金\" onClick=\"return vldPass();\">";

	echo "</tr></td></form></table>";

}
elseif ($mode == 'redeemAlloy' && $actionb == 'B'){

$amountAlloy = intval($amountAlloy);
$MaxAmount = floor($Game['v_points']/$VPt2AlloyReq);
if ($amountAlloy > $MaxAmount || $amountAlloy <= 0){echo "兌換數量出錯。<br>請檢查一下！";exit;}

//Get Warehouse Information
	//Set DataTable
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
	$query_whr = mysql_query($sql);$defineuserc = 0;
	$defineuserc = mysql_num_rows($query_whr);
	if ($defineuserc == 0){
		$sqldfwh = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` (username) VALUES('$Pl_Value[USERNAME]')");
		mysql_query($sqldfwh) or die ('<br><center>未能建立倉庫資料<br>原因:' . mysql_error() . '<br>');
		$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $Pl_Value['USERNAME'] ."'");
		$query_whr = mysql_query($sql) or die ('<br><center>未能取得倉庫資料<br>原因:' . mysql_error() . '<br>');
	}
	$Warehouse = mysql_fetch_row($query_whr);
	$WarehseWeps = explode("\n",$Warehouse[1]);
	$Countnumwhwp = count($WarehseWeps);
	if (($CFU_Time - $Warehouse[2]) <= 1){echo "你實在按的太快了。請於兩秒後再按。<br>多謝合作！";exit;}
//End Getting Warehouse Information
//Process
	unset($i);
	if ($Countnumwhwp+$amountAlloy > 100){echo "武器庫空間不足。<br>請先清理一下，多謝合作！";exit;}
	else {
		for($i=1;$i<=$amountAlloy;$i++) $Warehouse[1] .="\n".$AlloyID;
			$WChacheArrays = explode("\n",$Warehouse[1]);
			sort($WChacheArrays);
			$Warehouse[1] = implode("\n",$WChacheArrays);
			$Warehouse[1] = trim($Warehouse[1]);
			$Game['v_points'] -= $amountAlloy * $VPt2AlloyReq;
			if($Game['v_points'] < 0){echo "勝利績分不足！";exit;}
			unset($sql);
			$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` SET `warehouse` = '$Warehouse[1]', `timelast` = '$CFU_Time' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($sql);unset($sql);
			$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `v_points` = '".$Game['v_points']."' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($sql);
			unset($Gen,$Game,$UsrWepB,$UsrWepC,$UsWep_B,$UsWep_C);
		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
		echo "<p align=center style=\"font-size: 16pt\">兌換完成！<br><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
		
		postFooter();exit;
	}
//End Process
}
//完成兌換合金系統
else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>