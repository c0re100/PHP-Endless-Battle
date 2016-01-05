<?php
// Output for Online Players
// For http://frwonline.com
// Written By: Gary Chu 
// Web Site: http://v2alliance.no-ip.org

include('cfu.php');
$SQL = "SELECT `gamename` FROM `".$GLOBALS["DBPrefix"]."phpeb_user_general_info` `a`,`".$GLOBALS["DBPrefix"]."phpeb_user_game_info` `b` WHERE ";
$SQL .= "($CFU_Time - `time2`) < ".$GLOBALS['Offline_Time']." AND a.username = b.username ORDER BY `time2` DESC";

$Query = mysql_query($SQL);

$Info = array();
$i = 0;

while($Online = mysql_fetch_row($Query)){
$Info[$i] = $Online[0];
$i++;
}

echo "document.write('<font size=2>目前線上參戰者共有".($i)."人:";

if($i > 0){
	foreach($Info As $In){
	echo ' '.$In;
	}
}
else echo " 沒有";

echo " </font>'); ";

?>