<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
$t_now = time();
if ($Gen['btltime'] == $t_now){echo "動作過快。";postFooter();mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `btltime` = ".intval($t_now+10)." WHERE `username` = '$Gen[username]' LIMIT 1;");exit;}
if ($Game['organization'])
$Pl_Org = ReturnOrg("$Game[organization]");

//Set DataTable
$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE username='". $Pl_Value['USERNAME'] ."'");
$query_bnk = mysql_query($sql);
$defineuserc = 0;
$defineuserc = mysql_num_rows($query_bnk);

if ($defineuserc == 0){
	$sqldfbk = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank` (username) VALUES('$Pl_Value[USERNAME]')");
	mysql_query($sqldfbk) or die ('<br><center>未能建立銀行資料<br>原因:' . mysql_error() . '<br>');
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE username='". $Pl_Value['USERNAME'] ."'");
	$query_bnk = mysql_query($sql) or die ('<br><center>未能建立銀行資料<br>原因:' . mysql_error() . '<br>');
}
$Bank = mysql_fetch_array($query_bnk);

include('includes/bank.inc.php');

//Bank GUI
if ($mode=='main' && $actionb=='none'){
	echo "銀行<hr>";
	echo "<br>";
	echo "<form action=bank.php?action=main method=post name=bkmainform>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<script language=\"Javascript\">";
	echo "function numberFormat(num){";
	echo "	var numF = '';";
	echo "	var pNum = new String( num );";
	echo "	num = pNum;";
	echo "	var l = num.length;";
	echo "	var tx = Math.floor(l/3);";
	echo "	var rx = (l%3);";
	echo "	if (rx == 1){numF = num.substr(0,1);pNum = num.substr(1);}";
	echo "	else if (rx == 2){numF = num.substr(0,2);pNum = num.substr(2);}";
	echo "	else {numF = num.substr(0,3);pNum = num.substr(3);}";
	echo "	while(pNum.length >= 3){";
	echo "		numF = numF+','+pNum.substr(0,3);";
	echo "		pNum = pNum.substr(3);";
	echo "	}";
	echo "	return numF;";
	echo "}function ConfirmBanking(){";
	echo "if (bkmainform.actionb.value == 'deposit'){";
	echo "if (bkmainform.d_amount.value > $Gen[cash]){alert('你沒有那多錢呢...'+numberFormat(bkmainform.d_amount.value)+'元...');bkmainform.banking.style.visibility='visible';return false;}";
	echo "else {if (confirm('確定要把 '+numberFormat(bkmainform.d_amount.value)+'元 存入銀行嗎？') == true)";
	echo "{bkmainform.submit();return true}";
	echo "else {bkmainform.banking.style.visibility='visible';}}}";
	echo "else if(bkmainform.actionb.value == 'withdrawl'){";
	echo "if (bkmainform.w_amount.value > $Bank[savings]){alert('你戶口裡沒有那多錢呢...');bkmainform.banking.style.visibility='visible';return false;}";
	echo "else {if(confirm('確定要把 '+numberFormat(bkmainform.w_amount.value)+'元 取出來嗎？') == true){bkmainform.submit();return true}";
	echo "else {bkmainform.banking.style.visibility='visible';}}}";
	echo "else if(!bkmainform.actionb.value){alert('你不是想打劫銀行吧?');return false;}";
	echo "}function ConfirmAccValid(){";
	echo "if ($Gen[cash] < 1500000){alert('您的所持金不足呢！請加油吧！');bkmainform.AccountValiding.style.visibility='visible';return false;}";
	echo "else if ($Game[level] < 30){alert('您的等不足呢！請加油吧！');bkmainform.AccountValiding.style.visibility='visible';return false;}";
	echo "else {if (confirm('確定要用10萬開戶嗎？') == true){bkmainform.submit();return true}";
	echo "else {bkmainform.AccountValiding.style.visibility='visible';return false;}}";
	echo "}function ConfirmRemit(){";
	echo "if ($Bank[savings] < bkmainform.c_amount.value){alert('您的存款不足呢！');bkmainform.remit.style.visibility='visible';return false;}";
	echo "else if (bkmainform.c_amount.value <= 0){alert('請重新輸入金額。');bkmainform.remit.style.visibility='visible';return false;}";
	echo "else if (bkmainform.c_target.value == '0'){alert('請先指定您要匯給誰。');bkmainform.remit.style.visibility='visible';return false;}";
	echo "else {if (confirm('確定要匯 '+numberFormat(bkmainform.c_amount.value)+'元嗎？') == true){bkmainform.submit();return true}";
	echo "else {bkmainform.remit.style.visibility='visible';return false;}}";
	echo "}function ConfirmBounty(){";
	echo "if ($Bank[savings] < bkmainform.t_amount.value){alert('您的存款不足呢！');bkmainform.bounty.style.visibility='visible';return false;}";
	echo "else if (bkmainform.t_amount.value <= 0){alert('請重新輸入金額。');bkmainform.bounty.style.visibility='visible';return false;}";
	echo "else if (bkmainform.t_target.value == '0'){alert('請先指定您要通緝給誰。');bkmainform.bounty.style.visibility='visible';return false;}";
	echo "else {if (confirm('確定要以 '+numberFormat(bkmainform.t_amount.value)+'元 通緝嗎？') == true){bkmainform.submit();return true}";
	echo "else {bkmainform.bounty.style.visibility='visible';return false;}}";
	echo "}</script>";
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr align=center><td colspan=9><b style=\"font-size: 12	pt;\">銀行服務列表: </b></td></tr>";
	if($Bank['status']){
	echo "<tr align=center>";
	echo "<td width=\"100\"><b style=\"font-size: 12pt;\">金融服務</b></td>";
	echo "<td width=\"300\" align=left>您的現金: ".number_format($Gen['cash']);
	echo "<br>您的存款: ".number_format($Bank['savings'])."<hr align=center width=80%>";
	echo "存款 <input type=radio name=actionc value=deposit onClick=\"bkmainform.actionb.value='deposit';banking.disabled=false;c_amount.disabled=true;remit.disabled=true;depamt.disabled=false;whdlamt.disabled=true;t_amount.disabled=true;bounty.disabled=true;\"> : <input id=depamt disabled type=text maxlength=10 name=d_amount value=0>";
	echo "<br>提款 <input type=radio name=actionc value=withdrawl onClick=\"bkmainform.actionb.value='withdrawl';banking.disabled=false;c_amount.disabled=true;remit.disabled=true;whdlamt.disabled=false;depamt.disabled=true;t_amount.disabled=true;bounty.disabled=true;\"> : <input id=whdlamt disabled type=text maxlength=10 name=w_amount value=0>";
	echo "<br><input type=button disabled name=banking value=確定存取 onClick=\"banking.style.visibility='hidden';ConfirmBanking()\">";
	echo "</td>";
	echo "</tr>";
	echo "<tr align=center>";
	echo "<td width=\"100\"><b style=\"font-size: 12pt;\">匯款服務</b></td>";
	echo "<td width=\"300\" align=left>您的存款: ".number_format($Bank['savings'])."<br>";
	echo "把<input type=text disabled name=c_amount value=0 maxlength=10 size=10>元匯給:<br><select name=c_target>";
	echo "<option value='0'>－－－－－〔請選擇〕－－－－－";
	if ($Game['organization'])
	echo "<option value='<您所屬的組織>' style=\"background: $Pl_Org[color]\">$Pl_Org[name] (組織資金)";
	unset($sql,$query,$BankUsers,$c_rcb);
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `status` = '1' AND `username` != '$Bank[username]'");
	$query = mysql_query($sql);
	$c_rcb = 0;
	while ($BankUsers = mysql_fetch_array($query)){$c_rcb+=1;
		GetUsrDetails($BankUsers['username'],'','BankGame');
		echo "<option value='$BankGame[username]'>$BankGame[gamename]";
		unset($BankGame);
	}
	unset($sql,$query);
	echo "</select>";
	$remit_disabledtrue = (!$c_rcb) ? 'disabled' : '';
	echo "<br>使用匯款服務<input type=radio $remit_disabledtrue name=actionc value=remit onClick=\"bkmainform.actionb.value='remit';c_amount.disabled=false;remit.disabled=false;t_amount.disabled=true;bounty.disabled=true;banking.disabled=true;depamt.disabled=true;whdlamt.disabled=true;\">";
	echo "<br><input type=button name=remit disabled value=確定匯款 onClick=\"remit.style.visibility='hidden';ConfirmRemit()\">";
	echo "</td>";
	echo "</tr>";
	echo "<tr align=center>";
	echo "<td width=\"100\"><b style=\"font-size: 12pt;\">通緝服務</b></td>";
	echo "<td width=\"300\" align=left>您的存款: ".number_format($Bank['savings'])."<br>";
	echo "以<input type=text disabled name=t_amount value=0 maxlength=10 size=10>元通緝:<br><select name=t_target>";
	echo "<option value='0'>－－－－－〔請選擇〕－－－－－";
	unset($sql,$query,$BankUsers,$c_rcb);
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `username` != '$Bank[username]'");
	$query = mysql_query($sql);
	$c_rcb = 0;
	while ($BntyTrgt = mysql_fetch_array($query)){$c_rcb+=1;
		GetUsrDetails($BntyTrgt['username'],'','BntyTrgtGame');
		echo "<option value='$BntyTrgtGame[username]'>$BntyTrgtGame[gamename]";
		unset($BntyTrgtGame);
	}
	unset($sql,$query);
	echo "</select>";
	$bounty_disabledtrue = (!$c_rcb) ? 'disabled' : '';
	echo "<br>使用通緝服務<input type=radio $bounty_disabledtrue name=actionc value=bounty onClick=\"bkmainform.actionb.value='bounty';t_amount.disabled=false;bounty.disabled=false;c_amount.disabled=true;remit.disabled=true;banking.disabled=true;depamt.disabled=true;whdlamt.disabled=true;\">";
	echo "<br><input type=button name=bounty disabled value=確定通緝 onClick=\"bounty.style.visibility='hidden';ConfirmBounty()\">";
	echo "</td>";
	echo "</tr>";
	echo "<tr align=center>";
	echo "<td width=\"100\"><b style=\"font-size: 12pt;\">紀錄服務</b></td>";
	echo "<td width=\"300\" align=left>";
	echo "檢查銀行紀錄: ";
	echo "<br><input type=submit value=紀錄服務 onClick=\"document.bkmainform.action='bank.php?action=CheckLog&actionb=0';bkmainform.actionb.value='GUI'\">";
	echo "</td>";
	echo "</tr>";
	echo "<tr align=center>";
	echo "<td width=\"100\"><b style=\"font-size: 12pt;\">交易服務</b></td>";
	echo "<td width=\"300\" align=left>";
	echo "麻煩閣下請到保險庫部門: ";
	echo "<br><input type=submit value=保險庫部門 onClick=\"document.bkmainform.action='bank.php?action=SafeHouse';bkmainform.actionb.value='GUI'\">";
	echo "</td>";
	echo "</tr>";
	}else {
	echo "<input type=hidden value='AccValidation' name=actionc>";
	echo "<tr align=center>";
	echo "<td width=\"100\"><b style=\"font-size: 12pt;\">開戶服務</b></td>";
	echo "<td width=\"300\" align=left>任何等級達到".$BankRqLv."級、現金有".ceil($BankRqMoney/10000)."萬 (".number_format($BankRqMoney).") 的人也可以開銀行戶口的。<br>開戶會收取您一次性的手續費".ceil($BankFee/10000)."萬 (".number_format($BankFee).") ，之後您便可以享受本銀行的服務！";
	echo "<br>您的現金: ".number_format($Gen['cash'])."<hr align=center width=80%>";
	echo "<center><input type=submit name=AccountValiding value=確定開戶 onClick=\"AccountValiding.style.visibility='hidden';bkmainform.actionb.value='AccValidation';return ConfirmAccValid();\">";
	echo "</td>";
	echo "</tr>";
	}
	echo "</form></table>";

}//End GUI
elseif ($mode=='main' && $actionc == $actionb){


$log_amount = $log_tsaving = $log_tcash = $log_amount = $log_type = 0;
$log_target = $log_tg_name = (string) '';

if ($actionb == 'AccValidation'){
	if (1500000 > $Gen['cash']){echo "抱歉, 您的金錢不足。";postFooter();exit;}
	if (30 > $Game['level']){echo "抱歉, 您的等級不足。";postFooter();exit;}
	$Gen['cash'] -= 100000;
	$log_type = 5;
	}
else{
	if($Bank['status'] == '0'){echo "抱歉, 本銀行暫時未能提供服務給未開戶的人士。";postFooter();exit;}
	if($Bank['status'] == '-1'){echo "抱歉, 閣下的銀行帳戶暫時被凍結了。";postFooter();exit;}


if ($actionb == 'deposit'){
	if($d_amount>$Gen['cash']){echo "抱歉, 本銀行暫時未能提供借款服務, 尤其是借款給客戶用來存款的。";postFooter();exit;}
	if($d_amount <= 0){echo "麻煩閣下重新輸入金額。";postFooter();exit;}
	$d_amount = intval($d_amount);
	$Gen['cash'] -= $d_amount;
	$Bank['savings'] += $d_amount;
	$log_amount = $d_amount;
	$log_type = 1;
}
elseif ($actionb == 'withdrawl'){
	if($w_amount>$Bank['savings']){echo "抱歉, 本銀行暫時未能提供借款服務。";postFooter();exit;}
	if($w_amount <= 0){echo "麻煩閣下重新輸入金額。";postFooter();exit;}
	$w_amount = intval($w_amount);
	$Gen['cash'] += $w_amount;
	$Bank['savings'] -= $w_amount;
	$log_amount = $w_amount;
	$log_type = 2;
}
elseif ($actionb == 'remit'){
	$c_amount = intval($c_amount);
	if($c_amount > $Bank['savings']){echo "抱歉, 您的存款不足, 我們無法幫你匯款。";postFooter();exit;}
	if($c_amount <= 0){echo "麻煩閣下重新輸入金額。";postFooter();exit;}
	if ($c_target && $c_target != '<您所屬的組織>'){
	$sql = ("SELECT `bank`.`status` AS `AcStatus`, `gamename`, `savings`, `cash` FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `gen`,`".$GLOBALS['DBPrefix']."phpeb_user_bank` `bank`,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` `game`  WHERE `bank`.`username` = `game`.`username` AND `bank`.`username` = `gen`.`username` AND `bank`.`username` = '$c_target'");
	$query = mysql_query($sql);
	$BankUser = mysql_fetch_array($query);
	}
	if ($c_target != '<您所屬的組織>'){
	if ($BankUser['AcStatus'] != '1'){echo "抱歉, 您目標的人物沒有有效的銀行帳戶。$BankUser[AcStatus]";postFooter();exit;}
	$Bank['savings'] -= $c_amount;
	}else $BankUser = array('savings' => $Pl_Org['funds'], 'cash' => 0, 'gamename' => $Pl_Org['name']."(組織)");
	$log_target = $c_target;
	$log_amount = $c_amount;
	$log_tsaving = $BankUser['savings'] + $c_amount;
	$log_tcash = $BankUser['cash'];
	$log_tg_name = $BankUser['gamename'];
	$log_type = 3;
}
elseif ($actionb == 'bounty'){
	$t_amount = intval($t_amount);
	if($t_amount > $Bank['savings']){echo "抱歉, 您的存款不足, 我們無法幫你匯款通緝。";postFooter();exit;}
	if($t_amount <= 0){echo "麻煩閣下重新輸入金額。";postFooter();exit;}
	if($t_target == $Pl_Value['USERNAME']){echo "麻煩閣下不要亂來。";postFooter();exit;}
	$sql = ("SELECT `bounty`,`gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `gen`,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` `game` WHERE `gen`.`username` = `game`.`username` AND `gen`.`username` = '$t_target'");
	$query = mysql_query($sql) or die(mysql_error());
	$BntyTrgt = mysql_fetch_array($query);
	GetUsrDetails($t_target,'','BntyTrgtGame');
	$Bank['savings'] -= $t_amount;
	$BntyTrgt['bounty'] += $t_amount;
	$log_target = $t_target;
	$log_amount = $t_amount;
	$log_tg_name = $BntyTrgt['gamename'];
	$log_type = 4;
}else{echo "未定義動作！";postFooter();exit;}
}
if ($actionb == 'remit' && $c_target == '<您所屬的組織>'){
$Bank['savings'] -= $c_amount;
	unset($sql);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `funds` = `funds`+$c_amount WHERE `id` = '$Game[organization]' LIMIT 1;");
	mysql_query($sql);
}
	unset($sql);
	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = '$Gen[cash]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
	mysql_query($sql);unset($sql);
if ($actionb != 'AccValidation')
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_bank` SET `savings` = '$Bank[savings]' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
else
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_bank` SET `status` = '1' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
mysql_query($sql);unset($sql);
if ($actionb == 'remit' && $c_target != '<您所屬的組織>'){
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_bank` SET `savings` = `savings`+'$c_amount' WHERE `username` = '$c_target' LIMIT 1;");
mysql_query($sql);unset($sql);}
if ($actionb == 'bounty'){
$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `bounty` = '$BntyTrgt[bounty]' WHERE `username` = '$t_target' LIMIT 1;");
mysql_query($sql);unset($sql);}

$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank_log` (`time`, `user`, `g_name`, `type`, `amount`, `cash`, `bankamt`, `t_cash`, `t_bankamt`, `target`, `tg_name`) VALUES ('".$CFU_Time."', '$Pl_Value[USERNAME]', '$Game[gamename]', '$log_type', '$log_amount', '$Gen[cash]', '$Bank[savings]', '$log_tcash', '$log_tsaving', '$log_target', '$log_tg_name');");
mysql_query($sql) or die(mysql_error());unset($sql);

	echo "<form action=bank.php?action=main method=post name=frmct target=$SecTarget>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">完成！<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=submit value=\"繼續使用銀行\" onClick=\"frmct.submit()\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
}

//
// Safehouse View
//

elseif($mode == 'SafeHouse' && $actionb=='GUI'){

	//Plugin Mining System
	include('plugins/mining/mining.config.php');

	echo "銀行保險庫<hr>";
	echo "<br>";
	echo "<form action=bank.php?action=SafeHouse method=post name=bkmainform>";
	echo "<input type=hidden value='none' name=actionb>";
	echo "<input type=hidden value='' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "<script langauge=\"Javascript\">";
	echo "function MakeDeal(){";
	echo "if (confirm('建立這一單交易，可以嗎？')==true){bkmainform.actionb.value='MakeDeal';bkmainform.actionc.value= 'none';}";
	echo "else {return false}}";
	echo "function ConfirmDeal(deal){";
	echo "if (confirm('確認這一單交易，可以嗎？')==true){bkmainform.actionb.value='PayDeal';bkmainform.actionc.value= deal;}";
	echo "else {return false}}";
	echo "function RejectDeal(deal){";
	echo "if (confirm('拒絕這一單交易，可以嗎？')==true){bkmainform.actionb.value='RejectDeal';bkmainform.actionc.value= deal;}";
	echo "else {return false}}";
	echo "function CancelDeal(deal){";
	echo "if (confirm('中止這一單交易，可以嗎？')==true){bkmainform.actionb.value='CancelDeal';bkmainform.actionc.value= deal;}";
	echo "else {return false}}</script>";
	echo "<table align=center width=750 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";

	$EmptyMsg = '<Br><center>沒有任何物品</center><Br><Br>';

	$Pl_WepB = explode('<!>',$Game['wepb']);
	$Pl_WepC = explode('<!>',$Game['wepc']);
	if ($Pl_WepB[0] && $Pl_WepC[0])	$disableOnFull = 'disabled';
	else $disableOnFull = '';

	// Inbox Start
	// Display Inbox

	echo "<tr align=center><td colspan=3><b style=\"font-size: 12pt;\">Inbox: </b></td>";
	echo "</tr><tr valign=top>";

	echo "<td width=33%><b style=\"font-size: 12pt;\">一號箱: </b><br>";
	if ($Bank['sh_ina']) getInbox($Bank['sh_ina'],'a');
	else echo "$EmptyMsg";
	echo "</td>";

	echo "<td width=34%><b style=\"font-size: 12pt;\">二號箱: </b><br>";
	if ($Bank['sh_inb']) getInbox($Bank['sh_inb'],'b');
	else echo "$EmptyMsg";
	echo "</td>";

	echo "<td width=33%><b style=\"font-size: 12pt;\">三號箱: </b><br>";
	if ($Bank['sh_inc']) getInbox($Bank['sh_inc'],'c');
	else echo "$EmptyMsg";
	echo "</td>";

	echo "</tr>";

	// Outbox Start
	// Display Outbox

	echo "<tr align=center><td colspan=3><b style=\"font-size: 12pt;\">Outbox: </b></td>";
	echo "</tr><tr valign=top>";

	echo "<td width=33%><b style=\"font-size: 12pt;\">一號箱: </b><br>";
	if ($Bank['sh_outa']) getOutbox($Bank['sh_outa'],'a',$Game['username']);
	else echo "$EmptyMsg";
	echo "</td>";

	echo "<td width=34%><b style=\"font-size: 12pt;\">二號箱: </b><br>";
	if ($Bank['sh_outb']) getOutbox($Bank['sh_outb'],'b',$Game['username']);
	else echo "$EmptyMsg";
	echo "</td>";

	echo "<td width=33%><b style=\"font-size: 12pt;\">三號箱: </b><br>";
	if ($Bank['sh_outc']) getOutbox($Bank['sh_outc'],'c',$Game['username']);
	else echo "$EmptyMsg";
	echo "</td>";

	echo "</tr>";
	echo "</table>";
	printTHR();
	echo "<br>";

	//
	// Create New Deal
	//

	unset($sql,$query,$BankUsers,$c_rcb);
	$c_rcb = 0;
	$exch_disabledtrue = '';
	$Exch_Avail = '';
	$sql  = "SELECT `g`.`username` AS `username`, `gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` `b`, `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `g` ";
	$sql .= "WHERE b.status = '1' AND b.username != '$Bank[username]' AND (!`sh_ina` OR !`sh_inb` OR !`sh_inc`) AND g.username = b.username ORDER BY `gamename`";
	$query = mysql_query($sql);
	while ($BankUsers = mysql_fetch_array($query)){
		$c_rcb+=1;
		$Exch_Avail .= "<option value='$BankUsers[username]'>$BankUsers[gamename]";
	}
	unset($sql,$query);
	if (!$c_rcb) $exch_disabledtrue = 'disabled';

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td align=center width=500 colspan=2><b style=\"font-size: 12pt;\">建立交易: </b></td></tr>";
	echo "<tr><td align=left width=250 valign=top><font style=\"font-size: 11pt; font-weight: Bold\">您將提供的:</font><br>";

	echo "<br><b>武裝:</b>";

	if ($Pl_WepB[0]) echo "<br>　備用武器一:<br>　　".getSHWepName($Pl_WepB)." <input type=radio value='wepb' name=sellslot><br>";
	if ($Pl_WepC[0]) echo "<br>　備用武器二:<br>　　".getSHWepName($Pl_WepC)." <input type=radio value='wepc' name=sellslot><br>";
	if (!$Pl_WepB[0] && !$Pl_WepC[0]) echo "沒有<br>";

	echo "<br><hr>";
	printProductTable('provide_raw');

	echo "</td><td align=left width=250 valign=top><font style=\"font-size: 11pt; font-weight: Bold\">您想換取的:</font><br>";


	echo "資金: <input type=text name=price_sell maxlength=10 size=10><br><br><hr>";

	printProductTable('offer_raw');

	echo "</td></tr>";
	echo "<tr><td align=center width=500 colspan=2><b style=\"font-size: 11pt;\">目標買家: </b>";
	echo "<select name=exch_target $exch_disabledtrue>";
	echo "<option value='0'>－－－－－〔請選擇〕－－－－－";
	echo "$Exch_Avail";
	echo "</select>";
	echo "<input type=submit onClick=\"return MakeDeal()\" value=建立交易>";
	echo "</td></tr>";
	echo "</table>";
	echo "</form>";
}

//
// Safehouse Process
//

elseif($mode == 'SafeHouse' && $actionb && $actionc){
	//Plugin Mining System
	include('plugins/mining/mining.config.php');

	$Pl_WepB = explode('<!>',$Game['wepb']);
	$Pl_WepC = explode('<!>',$Game['wepc']);

	//
	// Accept and Pay for Deal
	//

	if ($actionb=='PayDeal'){

		if ($actionc=='a'){$SafeIN = explode('<#>',$Bank['sh_ina']);$InS = 'sh_ina';}
		elseif ($actionc=='b'){$SafeIN = explode('<#>',$Bank['sh_inb']);$InS = 'sh_inb';}
		elseif ($actionc=='c'){$SafeIN = explode('<#>',$Bank['sh_inc']);$InS = 'sh_inc';}
		else {echo "抱歉, 未能找到需要的資訊。6";postFooter();exit;}

		if (!$SafeIN[0]){
			echo "<center>抱歉, 未能找到需要的資訊。7";postFooter();exit;
		}

		unset($Raw);
		$Raw['Offeror'] = getRaw($SafeIN[4]);
		$Raw['Offeree'] = getRaw($SafeIN[5]);
		$Storage['Offeror'] = getMiningStorage($SafeIN[0]);
		$Storage['Offeree'] = getMiningStorage($Game['username']);

		if($SafeIN[2] != '0<!>0'){
			if (!$Pl_WepB[0]){$FreeSlot = 'wepb';}
			elseif (!$Pl_WepC[0]){$FreeSlot = 'wepc';}
			else {echo "<center>您身上裝備的已滿了，無法完全交易。";postFooter();exit;}
		}else{
			$FreeSlot = false;
		}

		if($Raw['Offeree'][0] > 0){
			if(checkMBillsPending($Pl_Value['USERNAME'])){
				echo "請先支付原料採集費，多謝合作。";postFooter();exit;
			}
			for($i = 1; $i <= 8; $i++){
				if($Raw['Offeree'][$i] > $Storage['Offeree'][$i]){
					echo "原料「".$product_id_list[$i]."」不足。";postFooter();exit;
				}
			}
		}

		if ($Bank['savings'] < $SafeIN[1]){echo "<center>您的存款不足，無法完全交易。";postFooter();exit;}

			$sql = ("SELECT `bank`.`status` AS `status`,`$SafeIN[3]`,`gamename`,`savings`,`cash` FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` `bank`, `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `game`, `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `gen` WHERE `game`.`username`= `bank`.`username` AND `gen`.`username`= `bank`.`username` AND `bank`.`username`='". $SafeIN[0] ."'");
			$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
			$SafeIN_Dealer = mysql_fetch_array($query);

		if (!$SafeIN_Dealer[0] || !$SafeIN_Dealer[1]){echo "<center>抱歉, 未能找到需要的資訊。8";postFooter();exit;}
		else $DealerOUT = explode('<#>',$SafeIN_Dealer[1]);

		if ($DealerOUT[0] != $Game['username']){echo "<center>抱歉, 對方表示此物品不是售給您的。";postFooter();exit;}
		if ($DealerOUT[1] != $SafeIN[1]){echo "<center>抱歉, 對方表示此價錢無法完成交易。";postFooter();exit;}
		if ($DealerOUT[2] != $SafeIN[2]){echo "<center>抱歉, 對方表示不是出售此物品。";postFooter();exit;}
		if ($DealerOUT[4] != $SafeIN[4] || $DealerOUT[5] != $SafeIN[5]){echo "<center>抱歉, 對方原料交易量不正確。";postFooter();exit;}
		if ($DealerOUT[3] != $InS){echo "<center>抱歉, 保險庫的位置出錯。";postFooter();exit;}

		//Input Data

		unset($sqlRawOfferor, $sqlRawOfferee);
		$SQL_Format = 'UPDATE `'.$GLOBALS['DBPrefix'].'phpeb_mining_storage` SET `quantity` = %d WHERE `m_store_user` = \'%s\' AND `item` = %d ;';
		$j = 0;
		if($Raw['Offeror'][0] > 0){
			for($i = 1; $i <= 8; $i++){
				if($Raw['Offeror'][$i] > 0){
					$Storage['Offeree'][$i] += $Raw['Offeror'][$i];
					//SQL to Update Offeree's Storage
					$sqlRawOfferee[$j] = sprintf($SQL_Format,$Storage['Offeree'][$i],$Game['username'],$i);
					$j++;
				}
			}
		}

		$k = 0;
		if($Raw['Offeree'][0] > 0){
			for($i = 1; $i <= 8; $i++){
				if($Raw['Offeree'][$i] > 0){
					$Storage['Offeree'][$i] -= $Raw['Offeree'][$i];
					$Storage['Offeror'][$i] += $Raw['Offeree'][$i];
					//SQL to Update Offeree's Storage
					$sqlRawOfferee[$j] = sprintf($SQL_Format,$Storage['Offeree'][$i],$Game['username'],$i);
					$sqlRawOfferor[$k] = sprintf($SQL_Format,$Storage['Offeror'][$i],$SafeIN[0],$i);
					$j++;
					$k++;
				}
			}
		}

		// Start Queries

		$sql =	("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_bank` SET `savings` = `savings`-".$SafeIN[1].", `$InS` = '' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
		$sql =	("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_bank` SET `savings` = `savings`+".$DealerOUT[1].", `$SafeIN[3]` = '' WHERE `username` = '$SafeIN[0]' LIMIT 1;");
		mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
		if($FreeSlot){
			$sql =	("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$FreeSlot` = '".$SafeIN[2]."' WHERE `username` = '$Game[username]' LIMIT 1;");
			mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
		}
		$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank_log` (`time`, `user`, `g_name`, `type`, `amount`, `cash`, `bankamt`, `t_cash`, `t_bankamt`, `target`, `tg_name`, `safehouse`) VALUES ('".$CFU_Time."', '$Pl_Value[USERNAME]', '$Game[gamename]', '6', '$SafeIN[1]', '$Gen[cash]', '".intval($Bank['savings']-$SafeIN[1])."', '$SafeIN_Dealer[cash]', '".intval($SafeIN_Dealer['savings']+$SafeIN[1])."', '$SafeIN[0]', '$SafeIN_Dealer[gamename]', '$Bank[$InS]');");
		mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');

		if(isset($sqlRawOfferee)){
			foreach($sqlRawOfferee as $sql){
				mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
			}
		}
		if(isset($sqlRawOfferor)){
			foreach($sqlRawOfferor as $sql){
				mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
			}
		}

		$Message = "交易順利完成！";

	}

	//
	// Cancel Deal
	//

	elseif ($actionb=='CancelDeal'){

		if ($actionc=='a'){$SafeOUT = explode('<#>',$Bank['sh_outa']);$OutS = 'sh_outa';}
		elseif ($actionc=='b'){$SafeOUT = explode('<#>',$Bank['sh_outb']);$OutS = 'sh_outb';}
		elseif ($actionc=='c'){$SafeOUT = explode('<#>',$Bank['sh_outc']);$OutS = 'sh_outc';}
		else {echo "抱歉, 未能找到需要的資訊。1";postFooter();exit;}

		if (!$SafeOUT || !$SafeOUT[0] || !$SafeOUT[2] || !$SafeOUT[3])
		{echo "<center>抱歉, 未能找到需要的資訊。2";postFooter();exit;}

		$Raw = getRaw($SafeOUT[4]);
		$Storage = getMiningStorage($Game['username']);
		$sqlStorage = array();
		$SQL_Format = 'UPDATE `'.$GLOBALS['DBPrefix'].'phpeb_mining_storage` SET `quantity` = %d WHERE `m_store_user` = \'%s\' AND `item` = %d ;';
		$j = 0;
		if($Raw[0] > 0){
			for($i = 1; $i <= 8; $i++){
				if($Raw[$i] > 0){
					$Storage[$i] += $Raw[$i];
					//SQL to Update Offeree's Storage
					$sqlStorage[$j] = sprintf($SQL_Format,$Storage[$i],$Game['username'],$i);
					$j++;
				}
			}
		}

		if($SafeOUT[2] != '0<!>0'){
			if (!$Pl_WepB[0]){$FreeSlot = 'wepb';}
			elseif (!$Pl_WepC[0]){$FreeSlot = 'wepc';}
			else {echo "<center>您身上裝備的已滿了，無法中止交易。";postFooter();exit;}
		}else{
			$FreeSlot = false;
		}

			$sql = ("SELECT `gamename`, `$SafeOUT[3]` AS `inbox` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `g`, `".$GLOBALS['DBPrefix']."phpeb_user_bank` `b` WHERE `g`.`username`='". $SafeOUT[0] ."' AND `g`.`username` = `b`.`username`;");
			$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
			$SafeOUT_Dealer = mysql_fetch_array($query);

		$RejectedFlag = false;
		if(!$SafeOUT_Dealer['inbox']) $RejectedFlag = true;
		else{
			$DealerIN = explode('<#>',$SafeOUT_Dealer['inbox']);
			if($DealerIN[0] != $Game['username']) $RejectedFlag = true;
			else{
				for($i = 1; $i < count($DealerIN); $i++){
					if($i == 3) continue;
					if($DealerIN[$i] != $SafeOUT[$i]){
						$RejectedFlag = true;
						break;
					}
				}
			}
		}

		//Input Data

		unset($sql);
		$sql =	("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_bank` SET `$OutS` = '' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');unset($sql);
		if(!$RejectedFlag){
			$sql =	("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_bank` SET  `$SafeOUT[3]` = '' WHERE `username` = '$SafeOUT[0]' LIMIT 1;");
			mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');unset($sql);
		}
		if($FreeSlot != false){
			$sql =	("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `$FreeSlot` = '".$SafeOUT[2]."' WHERE `username` = '$Game[username]' LIMIT 1;");
			mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');unset($sql);
		}
		$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank_log` (`time`, `user`, `g_name`, `type`, `target`, `tg_name`) VALUES ('".$CFU_Time."', '$Pl_Value[USERNAME]', '$Game[gamename]', '7', '$SafeOUT[0]', '$SafeOUT_Dealer[gamename]');");
		mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');unset($sql);

		if(isset($sqlStorage)){
			foreach($sqlStorage as $sql){
				mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
			}
		}

		$Message = "已成功中止交易！";

	}

	//
	// Reject Deal
	//

	elseif ($actionb=='RejectDeal'){

		if ($actionc=='a'){$SafeIN = explode('<#>',$Bank['sh_ina']);$InS = 'sh_ina';}
		elseif ($actionc=='b'){$SafeIN = explode('<#>',$Bank['sh_inb']);$InS = 'sh_inb';}
		elseif ($actionc=='c'){$SafeIN = explode('<#>',$Bank['sh_inc']);$InS = 'sh_inc';}
		else {echo "抱歉, 未能找到需要的資訊。3";postFooter();exit;}

		if (!$SafeIN[1]) {echo "<center>抱歉, 未能找到需要的資訊。4";postFooter();exit;}

			$sql = ("SELECT `gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `username`='". $SafeIN[0] ."'");
			$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
			$SafeIN_Dealer = mysql_fetch_array($query);

		//Input Data

		unset($sql);
		$sql =	("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_bank` SET `$InS` = '' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');unset($sql);
		$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank_log` (`time`, `user`, `g_name`, `type`, `target`, `tg_name`) VALUES ('".$CFU_Time."', '$Pl_Value[USERNAME]', '$Game[gamename]', '8', '$SafeIN[0]', '$SafeIN_Dealer[gamename]');");
		mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');unset($sql);

		$Message = "交易已被拒絕。";

	}

	//
	// Make a New Deal
	//

	elseif($actionb=='MakeDeal'){

		$price_sell = intval($price_sell);
		$rawCount = count($offer_raw);
		$prvCount = count($provide_raw);
		$tempSum = 0;
		$tradeRawOnlyFlag = false;

		if (!$exch_target){echo "麻煩請先輸入目標人物，多謝合作。";postFooter();exit;}
		if ($rawCount <= 0 || $rawCount > 8 || $prvCount <= 0 || $prvCount > 8){echo "原料ID出錯。";postFooter();exit;}
		if ($exch_target == $Pl_Value['USERNAME']){echo "麻煩不要在這搗亂，多謝合作。";postFooter();exit;}

		for($i = 1; $i <= $prvCount; $i++){
			$provide_raw[$i] = intval($provide_raw[$i]);
			if($provide_raw[$i] < 0) $provide_raw[$i] = 0;
			$tempSum += $provide_raw[$i];
		}

		$SQL_Format = 'UPDATE `'.$GLOBALS['DBPrefix'].'phpeb_mining_storage` SET `quantity` = %d WHERE `m_store_user` = \'%s\' AND `item` = %d ;';
		$Storage = array();
		unset($sqlStorage);

		if($tempSum > 0){
			if(checkMBillsPending($Pl_Value['USERNAME'])){
				echo "請先支付原料採集費，多謝合作。";postFooter();exit;
			}
			$Storage = getMiningStorage($Game['username']);
			$j = 0;
			for($i = 1; $i <= 8; $i++){
				if($provide_raw[$i] > $Storage[$i]){
					echo "原料「".$product_id_list[$i]."」不足。";postFooter();exit;
				}
				if($provide_raw[$i] > 0){
					$Storage[$i] -= $provide_raw[$i];
					$sqlStorage[$j] = sprintf($SQL_Format,$Storage[$i],$Game['username'],$i);
					$j++;
				}
			}
		}

		for($i = 1; $i <= $rawCount; $i++){
			$offer_raw[$i] = intval($offer_raw[$i]);
			if($offer_raw[$i] < 0) $offer_raw[$i] = 0;
			$tempSum += $offer_raw[$i];
		}

		if ($price_sell < 0){echo "抱歉, 價錢不能是負數。";postFooter();exit;}
		if ($tempSum == 0){
			if ($price_sell <= 0){echo "抱歉, 沒有進行原料交易時, 價錢不能是零。";postFooter();exit;}
			if ($sellslot !='wepb' && $sellslot !='wepc'){echo "抱歉, 未能找到需要的資訊。5";postFooter();exit;}
		}
		elseif ($sellslot !='wepb' && $sellslot !='wepc'){
				$tradeRawOnlyFlag = true;
				$sellslot = false;
		}

		$sql = ("SELECT `bank`.`status` AS `status`, `sh_ina`, `sh_inb`, `sh_inc`, `gamename`, `savings`, `cash` FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` `bank`, `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `game`, `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `gen` WHERE `game`.`username`= `bank`.`username` AND `gen`.`username`= `bank`.`username` AND `bank`.`username`='$exch_target'");
		$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
		$BankUser = mysql_fetch_array($query);

		if ($BankUser['status'] != '1'){echo "抱歉, 您目標的人物沒有有效的銀行帳戶。";postFooter();exit;}

		unset($PlaceSlotIN,$PlaceSlotOUT);
		if (!$BankUser['sh_ina']){$PlaceSlotIN = 'sh_ina';}
		elseif (!$BankUser['sh_inb']){$PlaceSlotIN = 'sh_inb';}
		elseif (!$BankUser['sh_inc']){$PlaceSlotIN = 'sh_inc';}
		else {echo "抱歉, 您目標的人物保險庫的沒有空間了。";postFooter();exit;}

		if (!$Bank['sh_outa']){$PlaceSlotOUT = 'sh_outa';}
		elseif (!$Bank['sh_outb']){$PlaceSlotOUT = 'sh_outb';}
		elseif (!$Bank['sh_outc']){$PlaceSlotOUT = 'sh_outc';}
		else {echo "抱歉, 您只能同時建立三單交易。";postFooter();exit;}

		$ProvideRawInfo = '';
		for($i = 1; $i <= $prvCount; $i++){
			if($provide_raw[$i] > 0) $ProvideRawInfo .= "$i,$provide_raw[$i];";
		}

		$RawMaterialInfo = '';
		for($i = 1; $i <= $rawCount; $i++){
			if($offer_raw[$i] > 0) $RawMaterialInfo .= "$i,$offer_raw[$i];";
		}

		$WepIndfyr = ($tradeRawOnlyFlag) ? '0<!>0' : $Game[$sellslot];

		//Input Data
		unset($sql);
		$sql =	("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_bank` SET `$PlaceSlotOUT` = '$exch_target<#>$price_sell<#>$WepIndfyr<#>$PlaceSlotIN<#>$ProvideRawInfo<#>$RawMaterialInfo' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');unset($sql);
		$sql =	("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_bank` SET  `$PlaceSlotIN` = '".$Pl_Value['USERNAME']."<#>$price_sell<#>$WepIndfyr<#>$PlaceSlotOUT<#>$ProvideRawInfo<#>$RawMaterialInfo' WHERE `username` = '$exch_target' LIMIT 1;");
		mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');unset($sql);
		if($sellslot != false){
			$sql =	("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET  `$sellslot` = '0<!>0' WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
			mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');unset($sql);
		}
		$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_bank_log` (`time`, `user`, `g_name`, `type`, `target`, `tg_name`) VALUES ('".$CFU_Time."', '$Pl_Value[USERNAME]', '$Game[gamename]', '9', '$exch_target', '$BankUser[gamename]');");
		mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');unset($sql);
		if(isset($sqlStorage)){
			foreach($sqlStorage as $sql){
				mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
			}
		}
		$Message = "已成功建立交易！";

	}
	// No Action Error
	else  {$Message = "未定義動作！";}

	echo "<form action=bank.php?action=SafeHouse method=post name=frmct target=$SecTarget>";
	echo "<input type=hidden value='GUI' name=actionb>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";
	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">$Message<br><input type=submit value=\"返回\" onClick=\"parent.$SecTarget.location.replace('gen_info.php')\"><input type=submit value=\"繼續使用保險庫\" onClick=\"frmct.submit()\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

}

//
// Log Checking Functions
//

elseif($mode == 'CheckLog' && $actionb >= 0){
	echo "銀行日誌紀錄<hr>";
	echo "<br>";

	$L_Lim = intval($actionb)*$Bank_SLog_Entries;
	$U_Lim = $L_Lim + $Bank_SLog_Entries;

	if ($Gen['acc_status'] >= 0) $SQL = ("SELECT `id`, `time`, `user`, `g_name`, `type`, `amount`, `cash`, `bankamt`, `t_cash`, `t_bankamt`, `target`, `tg_name` FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank_log` WHERE `user` = '$Pl_Value[USERNAME]' OR (`target` = '$Pl_Value[USERNAME]' AND `type` != 4) ORDER BY `time` DESC Limit $L_Lim,$U_Lim");
	else $SQL = ("SELECT `id`, `time`, `user`, `g_name`, `type`, `amount`, `cash`, `bankamt`, `t_cash`, `t_bankamt`, `target`, `tg_name` FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank_log` ORDER BY `time` DESC Limit $L_Lim,$U_Lim");

	$SQL_Query = mysql_query($SQL) or die(mysql_error());

	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";

	echo "<form action=bank.php?action=CheckLog method=post name=frmcl target=$SecTarget>";
	echo "<input type=hidden value='".intval($actionb+1)."' name=actionb>";
	echo "<input type=hidden value='' name=log_id>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<tr align=center><td width=225>日期時間</td>";
	echo "<td width=150>支付者</td>";
	echo "<td width=70>動作</td>";
	echo "<td width=150>金額 ($)</td>";
	echo "<td width=140>現金結餘 ($)</td>";
	echo "<td width=140>帳戶結餘 ($)</td>";
	echo "<td width=150>對象帳號</td>";
	echo "</tr>";

	function TypeBanking($act){
		switch($act){
			case 1: $ActionL = '存款';break;
			case 2: $ActionL = '提款';break;
			case 3: $ActionL = '匯款';break;
			case 4: $ActionL = '通緝';break;
			case 5: $ActionL = '開戶';break;
			case 6: $ActionL = '完成交易';break;
			case 7: $ActionL = '取消交易';break;
			case 8: $ActionL = '拒絕交易';break;
			case 9: $ActionL = '提出交易';break;
			default : $ActionL = '未指定';break;
		}
	return $ActionL;
	}

while($Logs = mysql_fetch_array($SQL_Query)){
	echo "<tr align=center><td>".cfu_time_convert($Logs['time'])."</td>";
	if ($Gen['acc_status'] < 0) echo "<td>$Logs[g_name]<br>($Logs[user])</td>";
	else echo "<td>$Logs[g_name]</td>";
	if ($Logs['type'] == 6)
	echo "<td style=\"cursor: pointer\" onClick=\"frmcl.action='bank.php?action=CheckSHLog';frmcl.log_id.value=$Logs[id];frmcl.submit();\">".TypeBanking($Logs['type'])."</td>";
	else
	echo "<td>".TypeBanking($Logs['type'])."</td>";
	if (($Logs['type'] >= 7 && $Logs['type'] <= 9))
	echo "<td>N/A</td>";
	else
	echo "<td>".number_format($Logs['amount'])."</td>";
	if (($Logs['type'] == 3 || $Logs['type'] == 6) && $Logs['target'] == $Pl_Value['USERNAME']){
		echo "<td>".number_format($Logs['t_cash'])."</td>";
		echo "<td>".number_format($Logs['t_bankamt'])."</td>";
	}
	elseif ($Logs['type'] >= 7 && $Logs['type'] <= 9){
		echo "<td>N/A</td>";
		echo "<td>N/A</td>";
	}
	else {
		echo "<td>".number_format($Logs['cash'])."</td>";
		echo "<td>".number_format($Logs['bankamt'])."</td>";
	}
	if ($Logs['type'] >= 3) {
			if ($Gen['acc_status'] < 0) echo "<td>$Logs[tg_name]<br>($Logs[target])</td>";
			else echo "<td>$Logs[tg_name]</td>";
	}
	else echo "<td>N/A</td>";
	echo "</tr>";
}
	echo "<tr align=center>";
	echo "<td colspan=7>";
	if (intval($actionb > 0))
	echo "<input type=button value=\"上一頁\" onClick=\"frmcl.actionb.value='".intval($actionb-1)."';frmcl.submit();\">";
	echo "第<input type=text maxlength=2 style=\"font-size: 10pt; color: #ffffff; background-color: #000000;text-align: center\" size=2 value='".intval($actionb+1)."' onChange=\"frmcl.actionb.value=Math.round(this.value-1);frmcl.submit();\">頁";
	echo "<input type=button value=\"下一頁\" onClick=\"frmcl.submit();\">";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";
}

elseif($mode == 'CheckSHLog' && isset($log_id)){
	echo "銀行保險庫交易項目紀錄<hr>";
	echo "<br>";
	$log_id = intval($log_id);

		unset($query,$sql,$SafeIN,$SafeIN_Wep,$SafeIN_Dealer,$D_Specs);
		$sql = ("SELECT `g_name`,`tg_name`,`safehouse` FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank_log` WHERE `id` = '".$log_id."'");
		$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
		$SafeInf = mysql_fetch_array($query);

		$SafeIN = explode('<#>',$SafeInf['safehouse']);
		$SafeIN_Wep = explode('<!>',$SafeIN[2]);

		$sql = ("SELECT `name`,`atk`,`hit`,`rd`,`enc`,`spec`,`equip` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `id` = '". $SafeIN_Wep[0] ."'");
		$query = mysql_query($sql) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
		$SafeIN_Dealer = mysql_fetch_array($query);
			if (isset($SafeIN_Wep[2])){
				if ($SafeIN_Wep[2]==1) $SafeIN_Dealer['name'] = $SafeIN_Wep[3].$SafeIN_Dealer['name']."<sub>&copy;</sub>";
				else $SafeIN_Dealer['name'] = $SafeIN_Dealer['name'].$SafeIN_Wep[3]."<sub>&copy;</sub>";
				$SafeIN_Dealer['atk'] += $SafeIN_Wep[4];
				$SafeIN_Dealer['hit'] += $SafeIN_Wep[5];
				$SafeIN_Dealer['rd'] += $SafeIN_Wep[6];
				$SafeIN_Dealer['enc'] = $SafeIN_Wep[7];
			}
		echo "<table align=center width=200 border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt;\" bordercolor=\"#FFFFFF\">";
		echo "<tr align=center><td colspan=3><b style=\"font-size: 12pt;\">買賣內容: </b></td>";
		echo "</tr><tr valign=top><td>";

		if ($SafeIN_Wep[1] > 0) $SafeIN_Wep['displayXp'] = '+'.($SafeIN_Wep[1]/100).'%';
		elseif ($SafeIN_Wep[1] < 0) $SafeIN_Wep['displayXp'] = ($SafeIN_Wep[1]/100).'%';
		else $SafeIN_Wep['displayXp'] = '±0%';
		echo "賣家: $SafeInf[tg_name]<br>出價: ".number_format($SafeIN[1]);

		// Plugin Mining Functions
		include('plugins/mining/mining.config.php');
		printRawReq($SafeIN[4], "<br>賣家支付的原料:<br>");
		printRawReq($SafeIN[5], "<br>買家支付的原料:<br>");

		if($SafeIN_Wep[0]){
			echo "<br>裝備: $SafeIN_Dealer[name]<br>狀態值: $SafeIN_Wep[displayXp]<br>能力: <br>";
			echo "　攻擊力: $SafeIN_Dealer[atk]　　　回數: $SafeIN_Dealer[rd]<br>　命中: $SafeIN_Dealer[hit]　　　EN消費: $SafeIN_Dealer[enc]<br>";
			$D_Specs = ReturnSpecs($SafeIN_Dealer['spec']);
			echo "特殊效果:";
			if ($SafeIN_Dealer['equip']) echo "可以裝備<br>";
			if ($SafeIN_Dealer['spec']) echo $D_Specs;
			elseif(!$SafeIN_Dealer['spec'] && !$SafeIN_Dealer['equip']) echo "沒有任何特殊效果<br>";
		}else{
			echo "<BR>此交易沒有涉及武裝交易。<BR>";
		}
		echo "</td></tr>";
		echo "</table>";
}


else {echo "未定義動作！";}
postFooter();exit;
?>