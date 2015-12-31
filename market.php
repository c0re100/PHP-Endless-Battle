 <?php
header('Content-Type: text/html; charset=utf-8');
//二手市場插件
//Provided and Written By: Kermit
//Debug & Amendments By: IE玩 Website: http://www.iewan.com/
//php-eb v0.25Final SP2 Alterations Officially Made By: v2Alliance
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser();
if ($CFU_Time >= $_SESSION['timeauth']+$TIME_OUT_TIME || $_SESSION['timeauth'] <= $CFU_Time-$TIME_OUT_TIME){echo "連線超時！<br>請重新登入！";exit;}
GetUsrDetails("$_SESSION[username]",'Gen','Game');
//GUI
if ($actionb=='none'){
        echo "<b style=\"font-size:12px;\">二手市場<hr>";
        echo "<br>";
        echo "<form action=market.php?action=main method=post name=buylist>";
		echo "<input type=hidden name=\"id\" value=''>";
        echo "<input type=hidden value='remit' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "<script language=\"Javascript\">";
        echo "function buywep(sellid){";
		echo "        buylist.action='market.php?action=main';";
		echo "        buylist.id.value=sellid;";
		echo "		  buylist.submit();";
		echo "        }</script>";
		
		echo "<p align=left>你的現金: ".number_format($Gen['cash']);
		
        $wep_list = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_market` WHERE 1 AND noshow=0 ORDER BY `id`");
        $query = mysql_query($wep_list);
        while($temp = mysql_fetch_array($query)) {
        $OwnerName_SQL = ("SELECT `gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username` = '$temp[owner]' LIMIT 1;");
        $O_Query = mysql_query($OwnerName_SQL);
        $OName = mysql_fetch_array($O_Query);
        $wep_specs=ReturnSpecs($temp['spec']);
        $weplist .= "<tr class=b>
        <td><div align='center'>$OName[gamename]</div></td>
        <td><div align='center'>$temp[name]</div></td>
        <td><div align='center'>$temp[enc]</div></td>
        <td><div align='center'>$temp[atk]</div></td>
        <td><div align='center'>$temp[hit]</div></td>
        <td><div align='center'>$temp[rd]</div></td>
        <td><div align='center'>$wep_specs</div></td>
        <td><div align='center'>$temp[price]</div></td>
        <td><div align='center'><input type=submit value=\"購買\" onClick=\"buywep('$temp[id]');\"></div></td>
        </tr>";
        }
        echo "<p align=center style=\"font-size: 16; font-family: Arial\">委託出售商品一覽:</p>";
        echo "<table width=\"100%\" align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 12; font-family: Arial\" bordercolor=\"#FFFFFF\">";
        echo "<tr><td>";
        echo "<table width=\"100%\" border=\"1\" align=center cellspacing=\"0\" cellpadding=\"0\">";
        echo '<td width="10%"><div align="center">賣家</div></td>';
        echo '<td width="20%"><div align="center">武器名稱</div></td>';
        echo '<td width="5%"><div align="center">EN消耗</div></td>';
        echo '<td width="6%"><div align="center">攻擊</div></td>';
        echo '<td width="5%"><div align="center">命中</div></td>';
        echo '<td width="5%"><div align="center">回合</div></td>';
        echo '<td width="10%"><div align="center">特效</div></td>';
        echo '<td width="10%"><div align="center">價錢</div></td>';
        echo '<td width="5%"><div align="center">操作</div></td>';
        echo "$weplist</table></table>";
        }
elseif ($actionb=='remit'){

		$id = mysql_real_escape_string($id);

        $sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `username` = '$_SESSION[username]'");
        $query = mysql_query($sql);
        $BankUser = mysql_fetch_array($query);

        if ($BankUser['status'] != '1'){echo "你還沒有在銀行開戶，不能購買市場中的武器！";postFooter();exit;}
        
		$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_market` WHERE `id` = '$id' LIMIT 1;");
		$query = mysql_query($sql);
		$wepnum = mysql_num_rows($query);
		$buy = mysql_fetch_array($query);
  
		if ($Gen['cash'] < $buy['price']){echo "你的現金不足呢！";postFooter();exit;}
		if ($wepnum != '1'){echo "該武器已經被其他玩家買走！";postFooter();exit;}

		$UsrWepA = explode('<!>',$Game['wepa']);
        $UsrWepB = explode('<!>',$Game['wepb']);
        $UsrWepC = explode('<!>',$Game['wepc']);
        if($UsrWepA[0] == '0') {$Game['wepa']=$buy['wepid'];$Pos_Flag="購買完成了！你現在正使用這新的武器";}
        elseif($UsrWepB[0] == '0') {$Game['wepb']=$buy['wepid'];$Pos_Flag="購買完成了！新的武器存放在備用一";}
        elseif($UsrWepC[0] == '0') {$Game['wepc']=$buy['wepid'];$Pos_Flag="購買完成了！新的武器存放在備用二";}
        else {$Pos_Flag="你身上沒有空位！本次交易不扣款";$buy['price']=0;}
        if ($buy['price']>0)
        {
        //給武器
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `wepa` = '$Game[wepa]', `wepb` = '$Game[wepb]', `wepc` = '$Game[wepc]' WHERE `username` = '$_SESSION[username]' LIMIT 1;");
        mysql_query($sql);
        //刪除商場物品
        $sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_market` WHERE `id` = '$id' LIMIT 1;");
        mysql_query($sql);
        //扣款
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = cash-'$buy[price]' WHERE `username` = '$_SESSION[username]' LIMIT 1;");
        mysql_query($sql);
        //給錢
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = cash+'$buy[price]' WHERE `username` = '$buy[owner]' LIMIT 1;");
        mysql_query($sql);
  }
        echo "<form action=market.php?actionb=none method=post name=frmeq target=Beta>";
        echo "<p align=center style=\"font-size: 16pt\">$Pos_Flag<br><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('market.php?actionb=none')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";
        }
else {echo "未定義動作！";}
postFooter();exit;
?>