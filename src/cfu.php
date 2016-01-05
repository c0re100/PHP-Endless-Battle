<?php
//-------------------------//-------------------------//-------------------------//
//----------------------------   Core Function Unit   ---------------------------//
//----------------------------   phpeb Version 0.50   ---------------------------//
//---------------------------   Release Candidate 1    --------------------------//
//-------------------------//-------------------------//-------------------------//
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//
//Detection of Process Time                             //                       //
global $gmcfu_time, $cfu_stime;                         //    這部份無需設定.    //
$gmcfu_time = explode(' ', microtime());                //    修改前請小心,      //
$cfu_stime = $gmcfu_time[1] + $gmcfu_time[0];           //    因為錯誤的更改,    //
if (!ini_get('register_globals'))                       //    可能會使整個程式,  //
{extract($_POST);extract($_GET);extract($_SERVER);      //    無法正常運作!      //
if (isset($_SESSION)){extract($_SESSION);}}             //                       //
error_reporting(0);  //關閉部份錯誤回報: PHP5 建議選項  //                       //
//-------------------------//-------------------------//-------------------------//
//Configs - 遊戲及系統設定

//版本資訊
global $cSpec, $vBdNum;
$cSpec = '0.50';                                         //版本名稱
$vBdNum = 'RC1';                                         //修訂版本

include('config.php');

//Anti Unauthorized Connection Settings
$disabled_AUC = 1;                  //防止盜連系統的無效化參數: 0為開啟防止盜連系統, 1是關閉防止盜連系統
$AUC_Log = "unauthorizedlog.php";   //防止盜連系統的紀錄檔名稱, 建議使用「.php」結尾

$Allow_AUC = "/(vsqa.no\-ip.com|v2alliance.net|php-eb.v2alliance.net)+/";
//此為正常連線位置
//請到 index2.php 修改 $HTTP_REFERER 參數
//以Regular Expression表達, 一般於「(」與「)+」之間輸入php-eb的目錄位置便可
//如:	(vsqa.no\-ip.com)+
//	(dai\-ngai.net)+
//	(phpebs.frwonline.com)+
//
//如想多於一個地方, 請如此輸入:
//	(vsqa.no\-ip.com|dai\-ngai.net|phpebs.frwonline.com)+
//在網址或目錄之間加「|」便可以
//請在「-」前加入「\」, 否則會出錯
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//
/*
Account Status:
-1: Administrator
0: Normal
1: Quarantine	// Not in Use
2: Lock
*/
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//


//End of Configurations

//Connect

if(empty($NoConnect)){
mysql_connect ($GLOBALS['DBHost'], $GLOBALS['DBUser'], $GLOBALS['DBPass']) or die ('Could not access database because: ' . mysql_error());
if(mysql_get_server_info() > '4.1') {
	global $charset;
	$charset = 'big5'; //伺服器文字校對 - 繁體版 php-eb 無需更改
	if(!$dbcharset && in_array(strtolower($charset), array('gbk', 'big5', 'utf-8'))) {
		$dbcharset = str_replace('-', '', $charset);
	}
	if($dbcharset) {
		mysql_query("SET NAMES '$dbcharset'");
	}
}
if(mysql_get_server_info() > '5.0.1') {
	mysql_query("SET sql_mode=''");
}

//-------------------------//
//--------Select DB--------//
//-------------------------//

mysql_select_db ($GLOBALS['DBName']);
}
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//

global $ConvColors;
$ConvColors=array(
	"#FFFF00","#FFFF78",
	"#FF0000","#FF2828","#FF5050",
	"#FFBF00","#FFCE3C","#FFDD78",
	"#00FF00","#3CFF3C","#78FF78",
	"#0000FF","#3C3CFF","#7878FF",
	"#FF3CFF","#FF00FF","#E100E1",
	"#FF3CAE","#FF0095","#E10083");

global $ConvGrades;
$ConvGrades=array(
	"ACE",	"S",
	"A+",	"A",	"A-",
	"B+",	"B",	"B-",
	"C+",	"C",	"C-",
	"D+",	"D",	"D-",
	"E+",	"E",	"E-",
	"F+",	"F",	"F-");

global $MainColors;
$MainColors = array(                                            //Rainbow Swatches By v2Alliance Gary
	"FF5050", "FF2828", "FF0000", "E10000", "C30000", "A50000",   //Red
	"FFDD78", "FFCE3C", "FFBF00", "EBB000", "D7A100", "C39200",   //Orange
	"FFFF78", "FFFF3C", "FFFF00", "EBEB00", "D7D700", "C3C300",   //Yellow
	"78FF78", "3CFF3C", "00FF00", "00E100", "00C300", "00A500",   //Green
	"78FFD2", "3CFFBE", "00FFAA", "00E196", "00C382", "00A56E",   //Light Green
	"78DDFF", "3CCEFF", "00BFFF", "00A9E1", "0092C3", "007CA5",   //Light Blue
	"7878FF", "3C3CFF", "0000FF", "0000E1", "0000C3", "0000A5",   //Blue
	"D278FF", "BE3CFF", "AA00FF", "9600E1", "8200C3", "6E00A5",   //Purple
	"FF78FF", "FF3CFF", "FF00FF", "E100E1", "C300C3", "A500A5",   //Indigo
	"FF78C7", "FF3CAE", "FF0095", "E10083", "C30072", "A50060",   //Violet
);

global $MainRanks;
$MainRanks = array(
'志願兵','二等兵','一等兵','上等兵','兵長','伍長',
'軍曹','下士','中士','上士','曹長',
'准尉','少尉','中尉','上尉',
'少校','中校','上校',
'准將','少將','中將','上將','一級上將',
'元帥','總司令');

global $RightsClass;
$RightsClass = array("Major" => '主席',"Leader" => '副主席');

global $CFU_Time;
$CFU_Time = time() + $Time_Fix;
//Start Time Convert Function
function cfu_time_convert($The_Time){
	$DateTime = getdate($The_Time);
	switch($DateTime['wday']){
		case 0: $DateTime['wday']='日';break;
		case 1: $DateTime['wday']='一';break;case 2: $DateTime['wday']='二';break;
		case 3: $DateTime['wday']='三';break;case 4: $DateTime['wday']='四';break;
		case 5: $DateTime['wday']='五';break;case 6: $DateTime['wday']='六';break;
	}
	if (strlen($DateTime['minutes']) == 1){$DateTime['minutes']='0'.$DateTime['minutes'];}
	if (strlen($DateTime['seconds']) == 1){$DateTime['seconds']='0'.$DateTime['seconds'];}
	if($DateTime['hours'] > 12){$DateTime['period'] = '下午';$DateTime['hours']-=12;}
	elseif($DateTime['hours'] == 12){$DateTime['period'] = '中午';}
	elseif($DateTime['hours'] == 0){$DateTime['period'] = '零晨';}
	else $DateTime['period'] = '上午';
	if($DateTime['hours'] == 0){$DateTime['hours']=12;}
	$FormatDate = "$DateTime[year]年$DateTime[mon]月$DateTime[mday]日, 星期$DateTime[wday], $DateTime[period] $DateTime[hours]:$DateTime[minutes]:$DateTime[seconds]";
	return $FormatDate;
}
//End Time Convert Function
global $CFU_Date;
$CFU_Date = cfu_time_convert($CFU_Time); //convert the present time

//Anti-Unauthorized Connection
if (!$disabled_AUC) include("includes/auc.inc.php");

//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//

//Update Time
$CFU_TIME_USER = 0;
if (isset($session_un)) $CFU_TIME_USER = "$session_un";
elseif (isset($Pl_Value['USERNAME']))$CFU_TIME_USER="$Pl_Value[USERNAME]";
if ($CFU_TIME_USER){
	$CFU_Time_UpDate_Q = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `time2` = '$CFU_Time' WHERE `username` = '$CFU_TIME_USER' LIMIT 1;");
	mysql_query($CFU_Time_UpDate_Q);
}
//End of Time Updating


//Start Primary Functions
function postFooter(){
	$mcfu_time = explode(' ', microtime());
	$cfu_ptime = number_format(($mcfu_time[1] + $mcfu_time[0] - $GLOBALS['cfu_stime']), 6);
	echo "<p align=center style=\"font-size: 10pt\">&copy; 2005-2010 v2Alliance. All Rights Reserved.　版權所有 不得轉載<br>";
	if ($GLOBALS['Show_ptime'])
	echo "<font style=\"font-size: 7pt\">Processed in ".$cfu_ptime." second(s).</font></p>";
}
function postHead($withoutbody='',$session_dir='phpeb_session_dir',$additionalHeadings=''){
		// Date in the past
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		// always modified
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
 		// HTTP/1.1
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		// HTTP/1.0
		header("Pragma: no-cache");
		session_name("php-eb_Session");
		session_set_cookie_params(0,mktime(0,0,0,12,31,2015),"/","php-eb_Gen_Session_lv89ina");
		session_save_path($session_dir);
		session_start();
		session_register("session_un");
		session_register("session_pwd");
		session_destroy();
		echo "<html>";
		echo "<head>";
		echo "<meta http-equiv=\"Pragma\" content=\"no-cache\">";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">";
		echo "<title>Endless Battle ~ php-eb - &copy; 2005-2010 v2Alliance</title>";
		echo "<style type=\"text/css\">BODY {FONT-SIZE: 10px; FONT-FAMILY: \"Arial\",  \"新細明體\"; cursor:default}TD {FONT-SIZE: 9pt; FONT-FAMILY: \"Arial\", \"新細明體\"}A:visited {COLOR: #FFFFFF;}</style>";
		echo $additionalHeadings;
		echo "</head>";
		if (!$withoutbody) echo "<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" oncontextmenu=\"return true;\">";
}
function AuthUser($U,$P){
		$sql_ugnrli = ("SELECT username, password, acc_status FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE username='". $U ."'");
		$UsrGenrl_Qr = mysql_query ($sql_ugnrli) or die ('錯誤！<br>未能連接到SQL資料庫(PHPEB_ERROR: 001)'.$GLOBALS['DBPrefix'].':' . mysql_error());
		$UsrGenrl = mysql_fetch_array($UsrGenrl_Qr);
		if (!$UsrGenrl['username'] || ($UsrGenrl['password'] != md5($P) && $UsrGenrl['password'] != $P) || $UsrGenrl['username'] != $U){
		echo "<center><br><br>使用者名稱或密碼錯誤。<br><br><a href=\"index2.php\" target='_top' style=\"text-decoration: none\">回到首頁</a>";
		postFooter();
		exit;}
		if ($UsrGenrl['acc_status'] == 2){
		echo "<center><br><br>帳號被鎖，請與管理員聯絡！<br><br><a href=\"index2.php\" target='_top' style=\"text-decoration: none\">回到首頁</a>";
		postFooter();
		exit;}
}
function ReturnSpecs($Specs){$SpecsTag='';
if (!$Specs)$SpecsTag='沒有';
else{
//Weapon Specs
if( strpos($Specs,'DamA') !== false ) $SpecsTag .='機體損壞<br>';
if( strpos($Specs,'DamB') !== false ) $SpecsTag .='戰鬥不能<br>';
if( strpos($Specs,'Mob') !== false ){
	if( strpos($Specs,'MobA') !== false ) $SpecsTag .='加速<br>';
	if( strpos($Specs,'MobB') !== false ) $SpecsTag .='超前<br>';
	if( strpos($Specs,'MobC') !== false ) $SpecsTag .='閃避<br>';
	if( strpos($Specs,'MobD') !== false ) $SpecsTag .='逃離<br>';
	if( strpos($Specs,'Moba') !== false ) $SpecsTag .='簡單推進<br>';
	if( strpos($Specs,'Mobb') !== false ) $SpecsTag .='強力推進<br>';
	if( strpos($Specs,'Mobc') !== false ) $SpecsTag .='最佳化推進<br>';
	if( strpos($Specs,'Mobd') !== false ) $SpecsTag .='高級推進<br>';
	if( strpos($Specs,'Mobe') !== false ) $SpecsTag .='極級推進<br>';
}
if( strpos($Specs,'Tar') !== false ){
	if( strpos($Specs,'TarA') !== false ) $SpecsTag .='校準<br>';
	if( strpos($Specs,'TarB') !== false ) $SpecsTag .='瞄準<br>';
	if( strpos($Specs,'TarC') !== false ) $SpecsTag .='集中<br>';
	if( strpos($Specs,'TarD') !== false ) $SpecsTag .='預測<br>';
	if( strpos($Specs,'Tara') !== false ) $SpecsTag .='自動鎖定<br>';
	if( strpos($Specs,'Tarb') !== false ) $SpecsTag .='高級校準<br>';
	if( strpos($Specs,'Tarc') !== false ) $SpecsTag .='無誤校準<br>';
	if( strpos($Specs,'Tard') !== false ) $SpecsTag .='多重鎖定<br>';
	if( strpos($Specs,'Tare') !== false ) $SpecsTag .='完美鎖定<br>';
}
if( strpos($Specs,'Def') !== false ){
	if( strpos($Specs,'DefA') !== false ) $SpecsTag .='簡單防禦<br>';
	if( strpos($Specs,'DefB') !== false ) $SpecsTag .='正常防禦<br>';
	if( strpos($Specs,'DefC') !== false ) $SpecsTag .='強化防禦<br>';
	if( strpos($Specs,'DefD') !== false ) $SpecsTag .='高級防禦<br>';
	if( strpos($Specs,'DefE') !== false ) $SpecsTag .='最終防禦<br>';
	if( strpos($Specs,'Defa') !== false ) $SpecsTag .='格擋<br>';
	if( strpos($Specs,'Defb') !== false ) $SpecsTag .='抗衡<br>';
	if( strpos($Specs,'Defc') !== false ) $SpecsTag .='干涉<br>';
	if( strpos($Specs,'Defd') !== false ) $SpecsTag .='堅壁<br>';
	if( strpos($Specs,'Defe') !== false ) $SpecsTag .='空間相對位移<br>';
	if( strpos($Specs,'PerfDef') !== false ) $SpecsTag .='完全防禦<br>';
}
if( strpos($Specs,'Pv') !== false ){
	if( strpos($Specs,'PvPhy') !== false ){
		if( strpos($Specs,'PvPhyA') !== false ) $SpecsTag .='厚甲<br>';
		if( strpos($Specs,'PvPhyB') !== false ) $SpecsTag .='抗衝擊<br>';
		if( strpos($Specs,'PvPhyC') !== false ) $SpecsTag .='彈開<br>';
		if( strpos($Specs,'PvPhyD') !== false ) $SpecsTag .='Phase Shift<br>';
		if( strpos($Specs,'PvPhyE') !== false ) $SpecsTag .='V. P. S.<br>';
	}
	if( strpos($Specs,'PvBeam') !== false ){
		if( strpos($Specs,'PvBeamA') !== false ) $SpecsTag .='耐熱<br>';
		if( strpos($Specs,'PvBeamB') !== false ) $SpecsTag .='熱轉移<br>';
		if( strpos($Specs,'PvBeamC') !== false ) $SpecsTag .='扭曲<br>';
		if( strpos($Specs,'PvBeamD') !== false ) $SpecsTag .='折射<br>';
		if( strpos($Specs,'PvBeamE') !== false ) $SpecsTag .='消散<br>';
	}
	if( strpos($Specs,'PvUni') !== false ){
		if( strpos($Specs,'PvUniA') !== false ) $SpecsTag .='念動干擾<br>';
		if( strpos($Specs,'PvUniB') !== false ) $SpecsTag .='重力操縱<br>';
		if( strpos($Specs,'PvUniC') !== false ) $SpecsTag .='空間干擾<br>';
		if( strpos($Specs,'PvUniD') !== false ) $SpecsTag .='時空擾亂<br>';
		if( strpos($Specs,'PvUniE') !== false ) $SpecsTag .='次元連結<br>';
	}
}

if( strpos($Specs,'ShootDown') !== false ) $SpecsTag .='實彈擊落<br>';
if( strpos($Specs,'DenseShot') !== false ) $SpecsTag .='密集射擊<br>';

if( strpos($Specs,'AntiDam')   !== false ) $SpecsTag .='自動修復<br>';
if( strpos($Specs,'DoubleExp') !== false ) $SpecsTag .='經驗雙倍<br>';
if( strpos($Specs,'DoubleMon') !== false ) $SpecsTag .='金錢雙倍<br>';
if( strpos($Specs,'DefX')      !== false ) $SpecsTag .='底力<br>';
if( strpos($Specs,'AtkA')      !== false ) $SpecsTag .='興奮<br>';
if( strpos($Specs,'MeltA')     !== false ) $SpecsTag .='高熱能<br>';
if( strpos($Specs,'MeltB')     !== false ) $SpecsTag .='熔解<br>';
if( strpos($Specs,'Cease')     !== false ) $SpecsTag .='禁錮<br>';
if( strpos($Specs,'AntiPDef')  !== false ) $SpecsTag .='貫穿<br>';
if( strpos($Specs,'Sniping')   !== false ) $SpecsTag .='狙擊<br>';
if( strpos($Specs,'ChargeUp')  !== false ) $SpecsTag .='能量填充必要<br>';
if( strpos($Specs,'NTCustom')  !== false ) $SpecsTag .='新人類專用<br>';
if( strpos($Specs,'NTRequired')  !== false ) $SpecsTag .='需要新人類力量<br>';
if( strpos($Specs,'COCustom')    !== false ) $SpecsTag .='Coordinator專用<br>';
if( strpos($Specs,'PsyRequired') !== false ) $SpecsTag .='念動力專用<br>';
if( strpos($Specs,'SeedMode')   !== false ) $SpecsTag .='SEED Mode<br>';
if( strpos($Specs,'EXAMSystem') !== false ) $SpecsTag .='EXAM系統啟動可能<br>';
// Specified Value Specs
if(preg_match('/CostSP<([0-9]+)>/',$Specs,$a))      $SpecsTag .= '消耗SP('.$a[1].')<br>';
if(preg_match('/CostEN<([0-9.]+)>/',$Specs,$a)){
	if($a[1] < 1) $a[1] = (floor($a[1]*10000)/100).'%';
	$SpecsTag .= '消耗EN('.$a[1].')<br>';
}
if(preg_match('/ReqStat<At><([0-9]+)>/',$Specs,$a)) $SpecsTag .= '需要Attacking('.$a[1].')<br>';
if(preg_match('/ReqStat<De><([0-9]+)>/',$Specs,$a)) $SpecsTag .= '需要Defending('.$a[1].')<br>';
if(preg_match('/ReqStat<Re><([0-9]+)>/',$Specs,$a)) $SpecsTag .= '需要Reacting('.$a[1].')<br>';
if(preg_match('/ReqStat<Ta><([0-9]+)>/',$Specs,$a)) $SpecsTag .= '需要Targeting('.$a[1].')<br>';
if(preg_match('/ReqEqCond<([0-9]+)>/',$Specs,$a)){
	if ($a[1] > 0) $dXp = '+'.($a[1]/100).'%';
	elseif ($a[1] < 0) $dXp = ($a[1]/100).'%';
	else $dXp = '±0%';
	$SpecsTag .= '需要狀態值('.$dXp.')<br>';
}
if(strpos($Specs,'GNWeapon') !== false) $SpecsTag .="GN粒子武器<br>";
// TransAM En, Ex, No 狀態
if(preg_match('/TransAM<([EnxNo]{2})><([0-9]+)>/',$Specs,$a)){
	if($a[1] == 'En') $SpecsTag .= 'TransAM 進入可能<br>';
	elseif($a[1] == 'Ex') $SpecsTag .= 'TransAM 發動中<br>';
	else $SpecsTag .= 'TransAM 能力下降狀態<br>';
}
//輔助裝備專用的特殊效果
if(strpos($Specs,'GNParticles') !== false) $SpecsTag .="GN粒子產生<br>";
if(strpos($Specs,'HPPcRecA') !== false) $SpecsTag .='HP回復<br>';
if(strpos($Specs,'ENPcRecA') !== false) $SpecsTag .='EN回復(小)<br>';
if(strpos($Specs,'ENPcRecB') !== false) $SpecsTag .='EN回復(大)<br>';
if(preg_match('/ExtHP<([0-9]+)>/',$Specs,$a)) $SpecsTag .="HP附加($a[1])<br>";
if(preg_match('/ExtEN<([0-9]+)>/',$Specs,$a)) $SpecsTag .="EN附加($a[1])<br>";
//Others
if(strpos($Specs,'FortressOnly') !== false) $SpecsTag .='要塞專用<br>';
if(strpos($Specs,'RawMaterials') !== false) $SpecsTag .='原料<br>';
if(strpos($Specs,'Blueprint') !== false)    $SpecsTag .='設計藍圖<br>';
if(strpos($Specs,'CannotEquip') !== false)  $SpecsTag .='無法裝備<br>';
//Attacking Type
if(strpos($Specs,'DoubleStrike') !== false)   $SpecsTag .='二連擊<br>';
if(strpos($Specs,'TripleStrike') !== false)   $SpecsTag .='三連擊<br>';
if(strpos($Specs,'AllWepStirke') !== false)   $SpecsTag .='全彈發射<br>';
if(strpos($Specs,'CounterStrike') !== false)  $SpecsTag .='反擊<br>';
if(strpos($Specs,'FirstStrike') !== false)    $SpecsTag .='先制攻擊<br>';
if(strpos($Specs,'PrecisionStrike') !== false)$SpecsTag .='精確攻擊<br>';
}
return $SpecsTag;
}

//Include Secondary Functions
$IncludeSCFI = ( isset($IncludeSCFI) ) ? $IncludeSCFI : true;
if($IncludeSCFI == true) include("includes/sc-fi.inc.php");

//Include Legacy Fetching Functions
$IncludeLFFI = ( isset($IncludeLFFI) ) ? $IncludeLFFI : true;
if($IncludeLFFI == true) include("includes/lf-fi.inc.php");

//Include Converting Functions
$IncludeCVFI = ( isset($IncludeCVFI) ) ? $IncludeCVFI : true;
if($IncludeCVFI == true) include("includes/cv-fi.inc.php");


?>