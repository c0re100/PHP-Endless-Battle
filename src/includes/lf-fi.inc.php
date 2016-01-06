<?php
//-------------------------//-------------------------//-------------------------//
//------------------------   Legacy Functions Include   -------------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//

function GetWeaponDetails($WepId,$AssignedVarible){
	global $$AssignedVarible;
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $WepId ."'");
	$query_r = mysql_query($sql);
	$$AssignedVarible = mysql_fetch_array($query_r);
}
function GetMsDetails($MsId,$AssignedVarible){
	global $$AssignedVarible;
	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE id='". $MsId ."'");
	$query_r = mysql_query($sql);
	$$AssignedVarible = mysql_fetch_array($query_r);
}
function GetUsrDetails($username,$AssignedforGen,$AssignedforGame=''){
	global $$AssignedforGen;global $$AssignedforGame;
	if ($AssignedforGen){
	$sqlgen = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE username='". $username ."'");
	$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	$$AssignedforGen = mysql_fetch_array($query_gen);}
	if ($AssignedforGame){
	$sqlgame = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE username='". $username ."'");
	$query_game = mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
	$$AssignedforGame = mysql_fetch_array($query_game);}
}

?>