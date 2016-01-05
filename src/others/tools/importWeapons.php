<?php
// Turn this on (set to true) or delete this file when not using!!
// 不使用時, 記得設定為「True」 或 刪除這個檔案!!
$UseAuth = false;
$Script_Name = 'importWeapons.php';
// Import Weapons
// For v0.50 Version
include('../../cfu.php');
postHead('','../../phpeb_session_dir');

$mode = ( isset($_POST['action']) ) ? $_POST['action'] : '';

//
// Login and authentications
//

if($UseAuth){

	if(!$mode){
	
		echo "<form action=$Script_Name method=post name=main>";
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
	
	$Data = file_get_contents('./weapons.txt');
	
	$Entry = explode("\n",$Data);
	
	$Format = "INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_wep` (`id`, `name`, `complexity`, `tier`, `range`, `attrb`, `buy`, `atk`, `hit`, `rd`, `enc`, `price`, `equip`, `spec`)";
	$Format .= " VALUES('%s', '%s', %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, '%s');";

	$SQL = array();
	foreach($Entry as $v){
		if(!$v) continue;
		$temp = explode("\t", $v);
		if(isset($temp[13])){
			if($temp[13] != '') $temp[13] = str_replace(array('"',"\r","\n"), array('','',''), $temp[13]);
		}
		else $temp[13] = '';
		$SQL[] = vsprintf($Format, $temp);
		unset($temp);
	}
	
	foreach($SQL as $v){
		echo $v. "<br>";
		mysql_query($v) or die(mysql_error().'<hr>');
	}

}
	
echo "<form action=$Script_Name method=post name=main>";
echo "<input type=hidden value='process' name=action>";;
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

echo "<input type=submit value='Import'>";
	
echo "</form>";

postFooter();

?>
