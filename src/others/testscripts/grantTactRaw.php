<?php

//Grants raw materials for a given tact
include('../../cfu.php');
postHead('','../../phpeb_session_dir');

$mode = ( isset($_POST['action']) ) ? $_POST['action'] : '';

if(!$mode){

	echo "<form action=grantTactRaw.php method=post name=main>";
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

if($mode == 'process'){

	$sql = "SELECT `m1`, `m2`, `m3`, `m4`, `m5`, `m6`, `m7`, `m8`, `m9`, `m10`, `m11`, `m12`, `m13`, `m14`, `m15`, `m16`, `m17`, `m18`, `m19`, `m20` ";
	$sql .= " FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` ";
	$sql .= " WHERE `tact_id` = '$t_tid';";

	$query = mysql_query($sql);
	
	echo "SQL: $sql<br>";
	
	if(mysql_num_rows($query) > 0){
		$tact = mysql_fetch_array($query);
		
		$sql = "UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_tactfactory` SET ";
		$first = true;
		for($i = 1; $i <= 20; $i++){
			$k = 'm'.$i;
			$v = $tact[$k];
			if($first){
				$sql .= " `$k` = '$v'";
				$first = false;
			}
			else{
				$sql .= ", `$k` = '$v'";
			}
		}
		$sql .= " WHERE `username` = '$t_user' LIMIT 1;";
		$query = mysql_query($sql);
		echo "SQL: $sql<br>Action Done<hr>";
	}else{
		echo "tact_id not found: ".$t_tid."<br>target user: ".$t_user."<hr>";
	}

}
	
echo "<form action=grantTactRaw.php method=post name=main>";
echo "<input type=hidden value='process' name=action>";;
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
echo "Target username: <input type=text value='".(isset($t_user) ? $t_user : $Pl_Value['USERNAME'])."' name=t_user><br>";
echo "Target tact_id: <input type=text value='' name=t_tid><br>";
echo "<input type=submit value='Grant'>";
	
echo "</form>";

postFooter();

?>