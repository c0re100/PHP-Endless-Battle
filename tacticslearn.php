<?php
header('Content-Type: text/html; charset=utf-8');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser();
if ($CFU_Time >= $_SESSION['timeauth']+$TIME_OUT_TIME || $_SESSION['timeauth'] <= $CFU_Time-$TIME_OUT_TIME){echo "驗證機制！<br>請重新登入！";exit;}
GetUsrDetails("$_SESSION[username]",'Gen','Game');
//Tactics Learning center GUI
if ($mode=='main'){
        unset($CancelFlag,$TactMessage);
        echo "<br>戰術學院<hr>";
        if ($actionb == 'proclearn'){
                $Tactics = GetTactics($learndesired);
                if ($Tactics['price'] > $Gen['cash']){$TactMessage = '金錢不足！';$CancelFlag= '1';}
                if ($Tactics['needlv'] > $Game['level']){$TactMessage .= '等級不足！';$CancelFlag= '1';}
                if(ereg("($Tactics[id])+",$Game['tactics'])){$TactMessage .= "你早就學會了 $Tactics[name] 。";$CancelFlag= '1';}
                if (!$CancelFlag)
                $TactMessage = "成功以 $Tactics[price] 元學習了 $Tactics[name] 。";
                }
        if (!$TactMessage)$TactMessage = '觀迎來到本學院！';
        echo "$TactMessage<hr>";
        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\"  style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\" width=\"1000px\">";
        echo "<form action=tacticslearn.php?action=main method=post name=mainform target=Beta>";
        echo "<input type=hidden value='none' name=actionb>";
        echo "<input type=hidden value='' name=learndesired>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "<tr align=center><td colspan=16><b>戰術列表: </b></td></tr>";
        echo "<tr align=center>";
        echo "<td width=\"20\">No.</td>";
        echo "<td width=\"100\">戰術名稱</td>";
        echo "<td width=\"60\">攻擊修正</td>";
        echo "<td width=\"50\">防禦修正</td>";
        echo "<td width=\"60\">迴避修正</td>";
        echo "<td width=\"60\">命中修正</td>";
        echo "<td width=\"60\">擊中修正</td>";
        echo "<td width=\"60\">失誤修正</td>";
        echo "<td width=\"60\">其他效果</td>";
        echo "<td width=\"80\">生命消耗量</td>";
        echo "<td width=\"80\">能量消耗量</td>";
        echo "<td width=\"80\">氣力消耗量</td>";
        echo "<td width=\"60\">所需等級</td>";
        echo "<td width=\"80\">價錢</td>";
		echo "<td width=\"80\">操作</td>";
        echo "</tr>";
unset ($sql,$query);
$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` WHERE id != '0' ORDER BY `price` ASC, `needlv` ASC");
$query = mysql_query($sql);
        echo "<script language=\"Javascript\">";
        echo "function cmLearn(name,cost,id,needlv){if (needlv > $Game[level]){alert('你的等級不足。');return false;}if (cost > $Gen[cash]){alert('金錢不足!!');}else{";
        echo "if (confirm('學習戰術「'+name+'」需要 '+cost+' 元。\\n確定要學習嗎？') == true)";
        echo "{mainform.actionb.value='proclearn';mainform.learndesired.value=id;mainform.submit();frmreturn.submit();return true}";
        echo "else{return false}}}</script>";
while ($TacticsAvail = mysql_fetch_array($query)){
$c+=1;
$TacticsAvail['spinfo'] = ReturnSpecs($TacticsAvail['spec']);
if (ereg('('.$TacticsAvail['id'].')+',$Game['tactics'])){
$LrntTpClr = "RED";
$LrntTips = "style=\"color: $LrntTpClr\"'";}
echo "<tr align=center $LrntTips class=buymslist onMouseover=\"this.style.color='yellow';\" onMouseout=\"this.style.color='$LrntTpClr'\">";
if (!$LrntTips)
echo "";
echo "<td width=\"20\">$c</td>";
echo "<td width=\"100\">$TacticsAvail[name]</td>";
echo "<td width=\"50\">$TacticsAvail[atf]</td>";
echo "<td width=\"50\">$TacticsAvail[def]</td>";
echo "<td width=\"50\">$TacticsAvail[ref]</td>";
echo "<td width=\"50\">$TacticsAvail[taf]</td>";
echo "<td width=\"50\">$TacticsAvail[hitf]</td>";
echo "<td width=\"50\">$TacticsAvail[missf]</td>";
echo "<td width=\"60\">$TacticsAvail[spinfo]</td>";
echo "<td width=\"30\">$TacticsAvail[hpc]</td>";
echo "<td width=\"30\">$TacticsAvail[enc]</td>";
echo "<td width=\"30\">$TacticsAvail[spc]</td>";
echo "<td width=\"60\">$TacticsAvail[needlv]</td>";
echo "<td width=\"80\">$TacticsAvail[price]</td>";
if(!ereg('('.$TacticsAvail['id'].')+',$Game['tactics'])){
	echo "<td width=\"80\"><input type=\"button\" name=\"info_show\" value=\"學習\" onclick=\"mainform.learndesired.value='$TacticsAvail[id]';cmLearn('$TacticsAvail[name]','$TacticsAvail[price]','$TacticsAvail[id]','$TacticsAvail[needlv]');\"></td>";
}
else
{
	echo "<td width=\"80\"><input type=\"button\" name=\"info_show\" value=\"已學習\" disabled></td>";
}
if (!$LrntTips)
echo "";
echo "</tr>";
unset($TacticsAvail,$LrntTips,$LrntTpClr);
        }

        echo "</form></table>";
        if (!$CancelFlag){
                $Gen['cash'] -= $Tactics['price'];
                $Game['tactics'] .= "\n$Tactics[id]";
                $Game['tactics'] = explode("\n",$Game['tactics']);
                sort($Game['tactics']);
                $Game['tactics'] = implode("\n",$Game['tactics']);
                $Game['tactics'] = trim($Game['tactics']);                
                
                $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `tactics` = '$Game[tactics]' WHERE `username` = '$_SESSION[username]' LIMIT 1;");
                mysql_query($sql);
                $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '$_SESSION[username]' LIMIT 1;");
                mysql_query($sql);
                unset($sql,$Tactics,$TactMessage);
        }
unset ($sql,$query,$Gen,$Game);
}
else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>