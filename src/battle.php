<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
$IncludeLFFI = false;
include('cfu.php');
include('includes/repairplayer-f.inc.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
if (!isset($Game_Scrn_Type)) $Game_Scrn_Type = 1;
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
mt_srand ((double) microtime()*1000000);

include('includes/sfo.class.php');
include('includes/obattle.ext.php');

$Pl = new oBattle;
$Pl->SetUser($Pl_Value['USERNAME']);
$Pl->FetchPlayer(true,true);

if (($CFU_Time - $Pl->Player['btltime']) < $Btl_Intv){echo "距離上次攻擊或移動的時間太短了！<br>請在 ".($Btl_Intv-($CFU_Time - $Pl->Player['btltime']))." 秒後再進行攻擊！";exit;}

if ($Pl->Player['msuit']){
	$Pl->ProcessAllWeapon();
	$Pl_Repaired = RepairPlayer($Pl->Player,$Pl->Eq['D'],$Pl->Eq['E']);
	$Pl->Player['hp'] = $Pl_Repaired['hp'];
	$Pl->Player['en'] = $Pl_Repaired['en'];
	$Pl->Player['sp'] = $Pl_Repaired['sp'];
	$Pl->Player['status'] = $Pl_Repaired['status'];
	$t_now = $Pl->Player['time1'] = $Pl_Repaired['time1'];
	if ($Pl->Player['status']){echo "修理中，無法出擊。";postFooter();exit;}
}else {echo "<center>你沒有機體，不能出擊。";postFooter();exit;}

//Adjust to user's setting
if ($Pl->Player['gen_img_dir'])
$General_Image_Dir = $Pl->Player['gen_img_dir'];
if ($Pl->Player['unit_img_dir'])
$Unit_Image_Dir = $Pl->Player['unit_img_dir'];
if ($Pl->Player['base_img_dir'])
$Base_Image_Dir = $Pl->Player['base_img_dir'];


$Area = ReturnMap($Pl->Player['coordinates']);
//$AreaLandForm = ReturnMType($Area["Sys"]["type"]);

$Area_Org = ReturnOrg($Area['User']['occupied']);
$Pl_Org = ($Area['User']['occupied'] != $Pl->Player['organization']) ? ReturnOrg($Pl->Player['organization']) : $Area_Org;

$Pl_LocalOrgFlag = 0;
if ($Area['User']['occupied'] == $Pl->Player['organization'] && $Pl->Player['organization'] != '0') $Pl_LocalOrgFlag = 1;

//要塞基本能力
$Area_At = $Area["User"]["at"];
$Area_De = $Area["User"]["de"];
$Area_Ta = $Area["User"]["ta"];
$Area_Pi = ceil($Area["User"]["tickets"] * 0.0025);
if($Area_Pi > 100) $Area_Pi = 100;
elseif($Area_Pi < 1) $Area_Pi = 1;

//國戰相關
$WarMessage = $WarFlag = $AttackFort = $FortDestoryedMsg = '';
$Defenders = array();
if($Area['User']['defenders'])	$Defenders = explode(',',$Area['User']['defenders']);
if ($Area["User"]["hp"] <= 0)	$FortDestoryedMsg = "<br><font color=red><b>要塞已經淪陷！</b></font>";

$enemyOrgs = array();

$sql = ("SELECT `a_org`, `t_start` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `b_org` = '$Pl_Org[id]' AND  `b_org` != 0 AND `victory` = 0 AND `ticket_b` > 0 AND `t_end` > '$CFU_Time' AND `mission` REGEXP '".$Pl->Player['coordinates']."' ORDER BY `t_start`");
$query = mysql_query($sql);
$i = 0;
while($enemyOrgs_fetch = mysql_fetch_array($query)){
	$enemyOrgs[] = $enemyOrgs_fetch['a_org'];
	if($CFU_Time > $enemyOrgs_fetch['t_start']) $i++;
}
if(count($enemyOrgs) > 0) {
	if($i > 0) $WarFlag = '<defend>';
	else $enemyOrgs = array();
	$WarMessage = "<font color=green>[防守目標]</font> ";
}

if($Pl_Org['optmissioni']){
	$enemyOrgs_copy = $enemyOrgs;
	unset($enemyOrgs);
	$enemyOrgs = array();
	//攻方判定
	$sql = ("SELECT `war_id`,`t_start`,`a_org`,`b_org` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `t_end` > '".$CFU_Time."' AND `mission` REGEXP '".$Pl->Player['coordinates']."' ORDER BY `t_start`");
	$query = mysql_query($sql);
	while($enemyOrgs_fetch = mysql_fetch_array($query)){
		if($enemyOrgs_fetch['war_id'] == $Pl_Org['optmissioni']){
			if($enemyOrgs_fetch['b_org'] != 0) $enemyOrgs[] = $enemyOrgs_fetch['b_org'];
			$WarMessage = "<font color=red>[攻略目標]</font> ";
			if(!$Pl->Player['battle_def_filter']) $WarMessage .= '<br><b>請先到「特殊指令」->「遊戲設定」改用「預設設定」！</b><br>';
			if ($CFU_Time > $enemyOrgs_fetch['t_start']){
				$AttackFort = 'True';
				$WarFlag = $enemyOrgs_fetch['b_org'];
			}
		}else	$enemyOrgs[] = $enemyOrgs_fetch['a_org'];
	}
	if(!$AttackFort) $enemyOrgs = $enemyOrgs_copy;
}

//判定出擊 EN 及武器
$RequireEN['Pl'] = ($Pl->Eq['A']['enc'] + $Pl->Eq['D']['enc'] + $Pl->Eq['E']['enc']);
if (!$Pl->Eq['A']['id']) {echo "你沒有裝備武器，不能出擊。";postFooter();exit;}
elseif ($Pl->Player['en'] < $RequireEN['Pl']) {echo 'EN不足，無法出擊。<br>現有EN: '.$Pl->Player['en'].' 所需EN: '.$RequireEN['Pl'];postFooter();exit;}

if ($mode == 'battle_sel')		include('battle-filter.php');
elseif ($mode == 'attack_target')	include('battle-2.php');

postFooter();

?>

