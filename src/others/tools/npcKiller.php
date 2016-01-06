<?php

// Tact Adder: 
// For v0.50 Version

// Activate Program
// Turn this on (set to true) or delete this file when not using!!
// 不使用時, 記得設定為「True」 或 刪除這個檔案!!
$UseAuth = false;
$Script_Name = 'npcKiller.php';
include('../../cfu.php');
postHead('','../../phpeb_session_dir');
mt_srand ((double) microtime()*1000000);

$mode = ( isset($_POST['action']) ) ? $_POST['action'] : '';

//
// Login and authentications
//

if($UseAuth){

	exit;

}
//
// Start Program
//


?>

</head>
<body>

<?php

if($mode == 'process'){
	$tLevel = intval($tLevel);
	
	if($tLevel < 1) $tLevel = 1;
	elseif($tLevel > 150) $tLevel = 150;
	
	$sql = "SELECT `username` FROM ".$GLOBALS['DBPrefix']."phpeb_user_general_info WHERE regkey = 'npc'; ";
	$query = mysql_query($sql);
	
	$count = mysql_num_rows($query);
	
		//Enter General Info
		$GenStr = "DELETE FROM ".$GLOBALS['DBPrefix']."phpeb_user_general_info WHERE `username` = '%s' LIMIT 1;";
		//Enter Game Info
		$GameStr = "DELETE FROM ".$GLOBALS['DBPrefix']."phpeb_user_game_info WHERE `username` = '%s' LIMIT 1;";
		//Enter Settings
		$SettingsStr = "DELETE FROM ".$GLOBALS['DBPrefix']."phpeb_user_settings WHERE `username` = '%s' LIMIT 1;";
		//Enter Log
		$LogStr = "DELETE FROM ".$GLOBALS['DBPrefix']."phpeb_user_log WHERE `username` = '%s' LIMIT 1;";
		//Enter Bank
		$BankStr = "DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_bank` WHERE `username` = '%s' LIMIT 1;";
		
	while(list($npc) = mysql_fetch_row($query)){
		
		$sqlStack[] = sprintf($GenStr, $npc);
		$sqlStack[] = sprintf($GameStr, $npc);
		$sqlStack[] = sprintf($SettingsStr, $npc);
		$sqlStack[] = sprintf($LogStr, $npc);
		$sqlStack[] = sprintf($BankStr, $npc);
		
		
	}

	echo "<textarea style='width:100%; height: 400px; font-size: 10pt; font-family: Arial;'>";
	foreach($sqlStack as $sql){
		echo $sql."\n";
		mysql_query($sql) or die(mysql_error()."\n");
	}
	echo "</textarea>";


}

echo "<form action=$Script_Name method=post name=main>";
echo "<input type=hidden value='process' name=action>";;
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

?>

<input type=submit value='Submit'>

</form>

<?php


postFooter();
echo "</body>";

?>