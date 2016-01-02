<?php
header('Content-Type: text/html; charset=utf-8');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser();
if ($CFU_Time >= $_SESSION['timeauth']+$TIME_OUT_TIME || $_SESSION['timeauth'] <= $CFU_Time-$TIME_OUT_TIME){echo "驗證機制！<br>請重新登入！";exit;}
GetUsrDetails("$_SESSION[username]",'Gen','Game');

if ($mode == 'main' && $actionb == 'A'){
        $SC_Prsn = $SC_Sys = $SC_Sys_Impt = $SC_Org = $SC_Org_Impt = $SC_Area = (string) ''; // Declare Variables
        echo "<font style=\"font-size: 12pt\">成長點數兌換系統</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";

        echo "<form action=exchange.php?action=main method=post name=mainform>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

		echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=225><b style=\"font-size: 10pt;\">兌換原料: </b></td></tr>";
        echo "<tr><td align=left>";
        echo "您可以在這裡用成長點數兌換隨機原料<br>兌換比率: <b>1 比 200</b><Br>即是200點成長點數可以換到1個原料！<br>注意：原料將會放在您的武器庫內！<br>";
        echo "您的成長點數: $Gen[growth]<br>";
        echo "<script language=\"JavaScript\">";
        echo "function vldPass(){";
                echo "if (document.getElementById('pwd').value != '$_SESSION[password]'){alert('密碼不正確。');return false;}";
                echo "else if (confirm('真的要兌換原料嗎？\\n您只會被問這一次，一旦兌換完成，原料不能還原成成長點數，請考慮清楚！') == true) {return true;}";
                echo "else {return false;}";
        echo "}</script>";
        echo "<hr><center>兌換<select name=amountAlloy>";
        echo "<option value=1>1<br><option value=5>5<br><option value=10>10";
        echo "</select>個原料<br><font color=red>您有5%機會獲得新原料。</font></center>";
        echo "<hr>請輸入密碼: <input type=password name=Pl_Value[PASSWORD] id=pwd><br>";
        echo "確定兌換: <input type=checkbox onClick=\"if (sbm_btn.disabled == true) sbm_btn.disabled = false; else sbm_btn.disabled = true;\"><br>";
        echo "<center><input type=submit name=sbm_btn disabled value=\"兌換原料\" onClick=\"return vldPass();\">";

        echo "</tr></td></form></table>";

}
elseif ($mode == 'main' && $actionb == 'B'){

$amountAlloy = mysql_real_escape_string($amountAlloy);
$amountAlloy = intval($amountAlloy);
if ($amountAlloy > 10 || $amountAlloy <= 0){echo "兌換數量出錯。<br>請檢查一下！";exit;}

//Get Warehouse Information
        //Set DataTable
        $sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $_SESSION['username'] ."'");
        $query_whr = mysql_query($sql);$defineuserc = 0;
        $defineuserc = mysql_num_rows($query_whr);
        if ($defineuserc == 0){
                $sqldfwh = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` (username) VALUES('$_SESSION[username]')");
                mysql_query($sqldfwh) or die ('<br><center>未能建立倉庫資料<br>原因:' . mysql_error() . '<br>');
                $sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` WHERE username='". $_SESSION['username'] ."'");
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
                $oraw = mt_rand(1,4);
				$nraw = mt_rand(1,8);
				$chance = mt_rand(1,100);
				if($chance <= 95){
					if($oraw==1){$rawID='711<!>0';$rawName='青銅';}
					if($oraw==2){$rawID='712<!>0';$rawName='鋼鐵';}
					if($oraw==3){$rawID='715<!>0';$rawName='黃金';}
					if($oraw==4){$rawID='718<!>0';$rawName='水晶';}
				} elseif ($chance >= 96){
					if($nraw==1){$rawID='1020<!>0';$rawName='青銅C0RE';}
					if($nraw==2){$rawID='1021<!>0';$rawName='鋼鐵C0RE';}
					if($nraw==3){$rawID='1022<!>0';$rawName='晶石C0RE';}
					if($nraw==4){$rawID='1023<!>0';$rawName='白銀C0RE';}
					if($nraw==5){$rawID='1024<!>0';$rawName='黃金C0RE';}
					if($nraw==6){$rawID='1025<!>0';$rawName='白金C0RE';}
					if($nraw==7){$rawID='1026<!>0';$rawName='鑽石C0RE';}
					if($nraw==8){$rawID='1027<!>0';$rawName='水晶C0RE';}
				}
				for($i=1;$i<=$amountAlloy;$i++) $Warehouse[1] .="\n".$rawID;
                        $WChacheArrays = explode("\n",$Warehouse[1]);
                        sort($WChacheArrays);
                        $Warehouse[1] = implode("\n",$WChacheArrays);
                        $Warehouse[1] = trim($Warehouse[1]);
                        $Gen['growth'] -= $amountAlloy * 200;
                        if($Gen['growth'] < 0){echo "成長點數不足！";exit;}
                        unset($sql);
                        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_warehouse` SET `warehouse` = '$Warehouse[1]', `timelast` = '$CFU_Time' WHERE `username` = '$_SESSION[username]' LIMIT 1;");
                        mysql_query($sql);unset($sql);
                        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `growth` = '".$Gen['growth']."' WHERE `username` = '$_SESSION[username]' LIMIT 1;");
                        mysql_query($sql);
                        unset($Gen,$Game,$UsrWepB,$UsrWepC,$UsWep_B,$UsWep_C);
                echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
                echo "<p align=center style=\"font-size: 16pt\">兌換完成！<br>獲得 $amountAlloy 個 $rawName ！<br><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
                echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
                echo "</form>";
                
                postFooter();exit;
        }
//End Process
}

?>