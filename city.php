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

$Area = ReturnMap("$Gen[coordinates]");
//$AreaLandForm = ReturnMType($Area["Sys"]["type"]);
$Ar_Org = ReturnOrg($Area["User"]["occupied"]);
//Special Commands GUI
if ($mode=='ModFort'){
        
        if ($Area["User"]["occupied"] != $Game['organization'] || !$Game['rights'])
        {echo "出錯。";postFooter();exit;}

        $Otp_Area_Sql = ("SELECT `opttime`,`optstart` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `optmissioni` = 'Atk=($Gen[coordinates])' AND `opttime` > '$CFU_Time' ORDER BY `optstart` ASC LIMIT 1");
        $Otp_Area_Q = mysql_query($Otp_Area_Sql) or die(mysql_error());
        $Otp_A_ITar = mysql_fetch_array($Otp_Area_Q);
        
        echo "<font style=\"font-size: 12pt\">強化城塞</font>";
        echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        
        $At_Cost = Floor(($Area["User"]["at"]+5)*75000);
        if ($Area["User"]["at"]+5 > 75) $At_Cost *= 2;
        $De_Cost = Floor(($Area["User"]["de"]+5)*125000);
        if ($Area["User"]["de"]+5 > 75) $De_Cost *= 2;
        $Ta_Cost = Floor(($Area["User"]["ta"]+5)*50000);
        if ($Area["User"]["ta"]+5 > 75) $Ta_Cost *= 2;
        $HpMax_Cost = Floor(($Area["User"]["hpmax"]+10000)*1.5);
        
        if ($actionb == 'A'){
        echo "<form action=city.php?action=ModFort method=post name=mainform>";
        echo "<input type=hidden value='B' name=actionb>";
        echo "<input type=hidden value='C' name=actionc>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        echo "<script language=\"Javascript\">";
        echo "function cfmModFort(type){";
        echo "if (type == 'at' && (".$At_Cost." > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
        echo "else if (type == 'de' && (".$De_Cost." > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
        echo "else if (type == 'ta' && (".$Ta_Cost." > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
        echo "else if (type == 'hpmax' && (".$HpMax_Cost." > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
        echo "else if (type == 'ehp' && (50000 > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
		echo "else if (type == 'ebhp' && (50000 > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
        echo "else if (type == 'shp' && (100000 > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
        echo "else if (type == 'lhp' && (200000 > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
		echo "else if (type == 'bhp' && (1000000 > $Pl_Org[funds])){alert('組織資金不足。');return false;}";
        echo "else {if (confirm('確定要強化城塞嗎？')==true){mainform.actionc.value=type;return true;}";
        echo "else {return false;}}";
        echo "}</script>";

        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td align=left width=280><b style=\"font-size: 10pt;\">強化 $Gen[coordinates]區域 的城塞: </b></td></tr>";
        echo "<tr><td>組織資金: ".number_format($Pl_Org['funds'])."元";
        if ($Area["User"]["at"]+5 <= 200) echo "<br>強化要塞攻擊力: <input type=submit value=\"強化5點AT\" onClick=\"return cfmModFort('at');\"> 所需金錢: $". number_format($At_Cost);
        if ($Area["User"]["de"]+5 <= 200) echo "<br>強化要塞防禦力: <input type=submit value=\"強化5點DE\" onClick=\"return cfmModFort('de');\"> 所需金錢: $". number_format($De_Cost);
        if ($Area["User"]["ta"]+5 <= 100) echo "<br>強化要塞命中能力: <input type=submit value=\"強化5點TA\" onClick=\"return cfmModFort('ta');\"> 所需金錢: $". number_format($Ta_Cost);
        if ($Area["User"]["hpmax"]+10000 <= 5000000) echo "<br>強化要塞裝甲耐久度: <input type=submit value=\"增加10000HP\" onClick=\"return cfmModFort('hpmax');\"> 所需金錢: $". number_format($HpMax_Cost);
        
        if ($Otp_A_ITar){
        echo "<br>緊急維修: <input type=submit value=\"回復5000點HP\" onClick=\"return cfmModFort('ehp');\"> 所需金錢: $".number_format(50000);
		echo "<br>緊急維修: <input type=submit value=\"回復10000點HP\" onClick=\"return cfmModFort('ebhp');\"> 所需金錢: $".number_format(100000);
		}else{
        echo "<br>回復部份HP: <input type=submit value=\"回復50000點\" onClick=\"return cfmModFort('shp');\"> 所需金錢: $".number_format(100000);
        echo "<br>回復大量HP: <input type=submit value=\"回復100000點\" onClick=\"return cfmModFort('lhp');\"> 所需金錢: $".number_format(200000);
		echo "<br>回復大量HP: <input type=submit value=\"回復500000點\" onClick=\"return cfmModFort('bhp');\"> 所需金錢: $".number_format(1000000);
        }
        echo "</tr></td>";
        echo "<tr><td>";
        echo "更變要塞防禦武器: (已扣除現有武器的價錢)";
        
        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"600\">";
        echo "<tr align=center><td colspan=8><b>武器列表: </b></td></tr>";
        echo "<tr align=center>";
        echo "<td width=\"20\">購</td>";
        echo "<td width=\"195\">武器名稱</td>";
        echo "<td width=\"80\">攻擊力</td>";
        echo "<td width=\"30\">命中</td>";
        echo "<td width=\"30\">回數</td>";
        echo "<td width=\"40\">EN消費</td>";
        echo "<td width=\"120\">特殊效果</td>";
        echo "<td width=\"85\">價錢</td>";
        echo "</tr>";
        
        GetWeaponDetails($Area["User"]["wepa"],'Ar_Wep');
        
        $wepsqlsel = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `spec` REGEXP '(FortressOnly)+' AND `id` != '".$Area["User"]["wepa"]."' ORDER BY price");
        $reswep = mysql_query($wepsqlsel);
        $syswepbuyinfo = mysql_fetch_array($reswep);
        $syswepbuynumsrows = mysql_num_rows($reswep);
        if ($syswepbuynumsrows > 0){
        $wepbuyoptions='';
        do
        {
        echo "<tr align=center>";
        echo "<td width=\"20\"><input type=radio name=FortWep value='$syswepbuyinfo[id]'></td>";
        echo "<td width=\"195\">$syswepbuyinfo[name]</td>";
        echo "<td width=\"80\">". number_format($syswepbuyinfo['atk']) ."</td>";
        echo "<td width=\"30\">$syswepbuyinfo[hit]</td>";
        echo "<td width=\"30\">$syswepbuyinfo[rd]</td>";
        echo "<td width=\"40\">$syswepbuyinfo[enc]</td>";
        $syswepbuyinfospecs = ReturnSpecs($syswepbuyinfo['spec']);
        echo "<td width=\"120\">$syswepbuyinfospecs</td>";
        $ExchangePrice = ceil($syswepbuyinfo['price'] - $Ar_Wep['price']/2);
        if ($ExchangePrice < 0)$ExchangePrice = 0;
        echo "<td width=\"85\">". number_format($ExchangePrice) ."</td>";
        echo "</tr>";
        }
        while ( $syswepbuyinfo = mysql_fetch_array($reswep) );
        }
        echo "</table><input type=submit value=\"更換\" onClick=\"return cfmModFort('wep');\"></tr></td></form></table>";
        }
        elseif($actionb == 'B' && $actionc){
        unset($InsufFundsFlag);
        if ($actionc == 'at' && (Floor(($Area["User"]["at"]+5)*75000) > $Pl_Org['funds'])){$InsufFundsFlag = 1;}
        if ($actionc == 'de' && (Floor(($Area["User"]["de"]+5)*125000) > $Pl_Org['funds'])){$InsufFundsFlag = 1;}
        if ($actionc == 'ta' && (Floor(($Area["User"]["ta"]+5)*50000) > $Pl_Org['funds'])){$InsufFundsFlag = 1;}
        if ($actionc == 'hpmax' && (Floor(($Area["User"]["hpmax"]+10000)*1.5) > $Pl_Org['funds'])){$InsufFundsFlag = 1;}
        if ($actionc == 'ehp' && (50000 > $Pl_Org['funds'])){$InsufFundsFlag = 1;}
		if ($actionc == 'ebhp' && (100000 > $Pl_Org['funds'])){$InsufFundsFlag = 1;}
        if ($actionc == 'shp' && (100000 > $Pl_Org['funds'])){$InsufFundsFlag = 1;}
        if ($actionc == 'lhp' && (200000 > $Pl_Org['funds'])){$InsufFundsFlag = 1;}
		if ($actionc == 'bhp' && (1000000 > $Pl_Org['funds'])){$InsufFundsFlag = 1;}
        
        if ($InsufFundsFlag == 1){echo "<center>組織資金不足。";postFooter();exit;}
        
        unset($sql,$sqlSet,$Cost);
                
        if ($actionc == 'at'){
                if ($Area["User"]["at"]+5 > 200){
                        echo "<center>不能再加強要塞攻擊力。";
                        postFooter();
                        exit;
                }
                if (!$Otp_A_ITar || $Area["User"]["hp"] > 0){
                        $sqlSet = ("`at` = `at`+5");
                        $Cost = $At_Cost;
                }
                else{echo "<center>現在不能加強要塞。";postFooter();exit;}
        }
        elseif($actionc == 'de'){
                if ($Area["User"]["de"]+5 > 200){
                        echo "<center>不能再加強要塞防禦力。";
                        postFooter();
                        exit;
                }
                if (!$Otp_A_ITar || $Area["User"]["hp"] > 0){
                        $sqlSet = ("`de` = `de`+5");
                        $Cost = $De_Cost;
                }
                else{echo "<center>現在不能加強要塞。";postFooter();exit;}
        }
        elseif($actionc == 'ta'){
                if ($Area["User"]["ta"]+5 > 100){
                        echo "<center>不能再加強要塞命中力。";
                        postFooter();
                        exit;
                }
                if (!$Otp_A_ITar || $Area["User"]["hp"] > 0){
                        $sqlSet = ("`ta` = `ta`+5");
                        $Cost = $Ta_Cost;
                }
                else{echo "<center>現在不能加強要塞。";postFooter();exit;}
        }
        elseif($actionc == 'hpmax'){
                if ($Area["User"]["hpmax"]+10000 > 5000000){
                        echo "<center>不能再加強要塞HP。";
                        postFooter();
                        exit;
                }
                if (!$Otp_A_ITar || $Area["User"]["hp"] > 0){
                        $sqlSet = ("`hpmax` = `hpmax`+10000, `hp` = `hp`+10000");
                        $Cost = $HpMax_Cost;
                }else{echo "<center>現在不能加強要塞。";postFooter();exit;}
        }
        elseif($actionc == 'ehp' && $Area["User"]["hp"] > 0){
                if ($Area["User"]["hp"] + 5000 > $Area["User"]["hpmax"])
                $sqlSet = ("`hp` = `hpmax`");
                else
                $sqlSet = ("`hp` = `hp`+5000");
        $Cost = 50000;
        }
		elseif($actionc == 'ebhp' && $Area["User"]["hp"] > 0){
                if ($Area["User"]["hp"] + 10000 > $Area["User"]["hpmax"])
                $sqlSet = ("`hp` = `hpmax`");
                else
                $sqlSet = ("`hp` = `hp`+10000");
        $Cost = 100000;
        }
        elseif($actionc == 'shp' && !$Otp_A_ITar){
                if ($Area["User"]["hp"] + 50000 > $Area["User"]["hpmax"])
                $sqlSet = ("`hp` = `hpmax`");
                else
                $sqlSet = ("`hp` = `hp`+50000");
        $Cost = 100000;
        }
        elseif($actionc == 'lhp' && !$Otp_A_ITar){
                if ($Area["User"]["hp"] + 100000 > $Area["User"]["hpmax"])
                $sqlSet = ("`hp` = `hpmax`");
                else
                $sqlSet = ("`hp` = `hp`+100000");
        $Cost = 200000;
        }
		elseif($actionc == 'bhp' && !$Otp_A_ITar){
                if ($Area["User"]["hp"] + 500000 > $Area["User"]["hpmax"])
                $sqlSet = ("`hp` = `hpmax`");
                else
                $sqlSet = ("`hp` = `hp`+500000");
        $Cost = 1000000;
        }
        elseif($actionc =='wep'&& !$Otp_A_ITar && $Area["User"]["hp"] > 0){
                if (!$FortWep){echo "<center>請先選擇要換成的武器。";postFooter();exit;}
                else{
                unset($Ex_Wep,$Ar_Wep);
                GetWeaponDetails($FortWep,'Ex_Wep');
                GetWeaponDetails($Area["User"]["wepa"],'Ar_Wep');
                $ExchangePrice = ceil($Ex_Wep['price'] - $Ar_Wep['price']/2);
                if ($ExchangePrice < 0)$ExchangePrice = 0;
                if (!ereg('(FortressOnly)+',$Ex_Wep['spec'])){echo "這不是要塞專用武器。";postFooter();exit;}
                elseif($ExchangePrice > $Pl_Org['funds']){echo "<center>組織資金不足。";postFooter();exit;}
                else{$Cost = $ExchangePrice;$sqlSet = "`wepa` = '$Ex_Wep[id]'";}
                }
        }
        elseif($Otp_A_ITar){
                echo "戰略進行中，未能強化要塞！";
                postFooter();exit;
        }
        elseif($Area["User"]["hp"] <= 0){
                echo "要塞已淪陷！";
                postFooter();exit;
        }
        else {echo "未定義動作！";postFooter();exit;}
        //更新 Map Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET $sqlSet WHERE `occupied` = '".$Game['organization']."' AND `map_id` = '".$Gen['coordinates']."'");
        $query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
        
        //更新 Org Info
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`-$Cost WHERE `id` = '".$Game['organization']."' LIMIT 1");
        $query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
        
        unset($sql,$sqlSet,$Cost);

        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">城塞強化完成了！<input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
        }
}
else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>