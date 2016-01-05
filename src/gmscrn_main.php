<?php
//Game Screen Main Process Unit, for php-eb v0.50
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
include('includes/repairplayer-f.inc.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");

//Online Limit Connection
if ($OLimit){
$Online_Time = time() - $Offline_Time;
$OnlineSQL = ("SELECT count(time2) FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `time2` > '$Online_Time'");
$OnlineSQL_Query = mysql_query($OnlineSQL);
$OnlinePlNum = mysql_fetch_row($OnlineSQL_Query);
if ($OnlinePlNum[0] >= $OLimit && $CFU_Time-$UsrGenrl['time2'] < $Offline_Time){
	echo "<center><br><br>上線人數太多。<br>現上線人數: $OnlinePlNum[0]<br>上線人數上限: $OLimit<br><a href=\"index2.php\" target='_top' style=\"text-decoration: none\">回到首頁</a><br><br>";
	postFooter();exit;
}
}

if ( $mode == 'proc' && $Game_Scrn_Type == 0) include('gmscrn_base.php');
else echo "<br><br><br>Undefined Action<br><br><br>";
postFooter();
?>