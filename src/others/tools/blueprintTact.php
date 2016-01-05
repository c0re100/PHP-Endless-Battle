<?php
// Blueprint Generator
// Automated Generation of blueprint for tactfactory
include('../../cfu.php');
postHead('','../../phpeb_session_dir');

// Turn this on (set to true) or delete this file when not using!!
// 不使用時, 記得設定為「True」 或 刪除這個檔案!!
$UseAuth = false;

$mode = ( isset($_POST['action']) ) ? $_POST['action'] : '';

if($UseAuth){
	
	//
	// Login and authentications
	//
	
	if(!$mode){
	
		echo "<form action=blueprintTact.php method=post name=main>";
		echo "<input type=hidden value='login' name=action>";
		echo "Username: <input type=text value='' name=Pl_Value[USERNAME]>";
		echo "Password: <input type=password value='' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "<input type=submit value='Login'>";
		echo "</form>";
		
		exit;
	
	}
	
	AuthUser($Pl_Value['USERNAME'],$Pl_Value['PASSWORD']);
	GetUsrDetails("$Pl_Value[USERNAME]",'Gen','Game');
		
	if($Gen['acc_status'] >= 0){
		
		echo "沒有權限存取。<br>如您是管理員, 請先設定管理員身份。<BR>";
		postFooter();
		exit;
	
	}

}

//
// Start Program
//

if($mode == 'process'){

	if(!$beginID){
		$sql = "SELECT id FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE spec = 'blueprint' ORDER BY id DESC LIMIT 1;";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) > 0){
			list($id) = mysql_fetch_row($query);
			$beginID = intval($id) + 1;
		}else $beginID = 901000;
	}

	$sql = "SELECT `tact_id`, `t`.`grade` AS `t_grade`, `w`.`complexity` AS `w_grade`, `name` ";
	$sql .= " FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` `t`, `".$GLOBALS['DBPrefix']."phpeb_sys_wep` `w` ";
	$sql .= " WHERE `wep_id` = `id` AND `blueprint` = '';";

	$query = mysql_query($sql);
	
	echo "SQL: $sql<br>";
	$beginID = intval($beginID);
	if($beginID <= 0){echo "Begin ID invalid!";exit;}
	
	$nowID = $beginID;
	$InsWepStr = "INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` (`id` ,`name` ,`price` ,`spec`) VALUES ('%s', '%s', '%d', 'Blueprint');";
	$UpdTactStr = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` SET `blueprint` = '%s', `m1` = '%s' WHERE `tact_id` = '%s' LIMIT 1 ;";

	$i = 0;
	$InsWepSQL = array();
	$UpdTactSQL = array();

	while($tact = mysql_fetch_array($query)){
		
		$name = $txtPre.$tact['name'].$txtSuf;
		$price = floor($TFDCostCons * pow(2,(($tact['t_grade'] + $tact['w_grade'])/4)) / 1000) * 1000;
		
		$InsWepSQL[$i] = sprintf($InsWepStr,$nowID,$name,$price);
		$UpdTactSQL[$i] = sprintf($UpdTactStr,$nowID,$nowID,$tact['tact_id']);
		
		$nowID++;
		$i++;
		
	}
	
	$nowID--;
	$count = $i;
	
	echo "Range of IDs: $beginID to $nowID, $i entries:<br>";
	for($i = 0; $i < $count; $i++){
		echo "SQL: ".$InsWepSQL[$i];
		mysql_query($InsWepSQL[$i]) or die( "&nbsp;&nbsp;&nbsp;&nbsp; --- Error: ".mysql_error()."<br>");
		echo "&nbsp;&nbsp;&nbsp;&nbsp; --- Executed Successfully<br>";
		echo "SQL: ".$UpdTactSQL[$i];
		mysql_query($UpdTactSQL[$i])or die( "&nbsp;&nbsp;&nbsp;&nbsp; --- Error: ".mysql_error()."<br>");
		echo "&nbsp;&nbsp;&nbsp;&nbsp; --- Executed Successfully<br>";
	}

	echo "<br><br>All Actions Done<br><hr>";

}
	
echo "<form action=blueprintTact.php method=post name=main>";
echo "<input type=hidden value='process' name=action>";;
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
echo "This generator would not generate blueprints for entries that already have one.<br>";
echo "IDs generated would not be checked for vacancy, so do ensure that the range of IDs is clear.<br>";
echo "Begin ID (integer): <input type=text value='' name=beginID> leave blank for auto-detection, default to 901000<br>";
echo "Text Prefix: <input type=text value='' name=txtPre><br>";
echo "Text Suffix: <input type=text value='設計藍圖' name=txtSuf><br>";
echo "<input type=submit value='Generate and Link'>";
	
echo "</form>";

postFooter();

?>