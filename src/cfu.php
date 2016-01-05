<?php
header('Content-Type: text/html; charset=utf-8');
//-------------------------//-------------------------//-------------------------//
//----------------------------   Core Function Unit   ---------------------------//
//----------------------------   phpeb Version 0.30   ---------------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//
//Detection of Process Time                                //                         //
global $gmcfu_time, $cfu_stime;                                //                         //
$gmcfu_time = explode(' ', microtime());                //    這部份無需設定.         //
$cfu_stime = $gmcfu_time[1] + $gmcfu_time[0];                //    修改前請小心,         //
//Register Globals - Provided By winglunk                //    因為錯誤的更改,         //
if (!ini_get('register_globals'))                        //    可能會使整個程式,         //
{extract($_POST);extract($_GET);extract($_SERVER);        //    無法正常運作!         //
extract($_FILES);extract($_ENV);extract($_COOKIE);        //                         //
if (isset($_SESSION)){extract($_SESSION);}}                //                         //
error_reporting(1);  //關閉部份錯誤回報: PHP5 建議選項        //                         //
//-------------------------//-------------------------//-------------------------//
//Configs - 遊戲及系統設定

//版本資訊
global $cSpec, $vBdNum;
$cSpec = '0.30';                                        //版本名稱, 版本名稱會用作識別用途, 如想使用官方插件、更新, 請避免更改!
$vBdNum = '';                                                //修訂版本, 同上

//資訊設定
global $sSpec, $WebMasterName, $WebMasterSite;
$sSpec = 'Ext4! Version';                                //其他版本資訊, 這項可自由修改
$WebMasterName = 'Husky';                                //站長名稱
$WebMasterSite = 'http://ebs.ext.me/';        //網名網址, 按下 "$sSpec" 時所開啟的網頁
$bbsurl = 'http://ext.me/';                                 //論壇地址,可以輸入絕對地址。默認的就不用更改。

//Database Configs 資料庫設定
global $DBHost, $DBUser, $DBPass, $DBName, $DBPrefix;

$DBHost = '172.17.0.1';                //資料庫位置, 如 localhost, 127.0.0.1, [url]www.yourdomain.com[/url]
$DBUser = 'root';                     //資料庫使用者名稱
$DBPass = '1234';                  //資料庫密碼
$DBName = 'ebs';                   //資料庫名稱
$DBPrefix = 'vsqa_';                //資料表前綴名, 不建議更改!!

//Setting Configs
global $MAX_PLAYERS, $Offline_Time, $TIME_OUT_TIME, $RepairHPCost, $RepairENCost, $OrganizingCost, $HP_BASE_RECOVERY, $EN_BASE_RECOVERY;
global $General_Image_Dir, $Unit_Image_Dir, $Base_Image_Dir, $Org_War_Cost, $Max_Wep_Exp, $ControlSEED;
global $Mod_HP, $Mod_HP_Cost, $Mod_HP_UCost, $Mod_EN, $Mod_EN_Cost, $Mod_EN_UCost,$TFDCostCons;

//基本設定
$TIME_OUT_TIME = 1800;                //逾時時間, 秒數
$Offline_Time =  600;                //判定為「休息中」, 離線的時間, 秒數
$MAX_PLAYERS = 5000;                //登錄人數上限, 若不設定或設定為零, 此參數則無效
$HP_BASE_RECOVERY = 0;                //HP基本回復率
$EN_BASE_RECOVERY = 0;                //EN基本回復率
$OLimit = 300;                        //上線人數上限, 若不設定或設定為零, 此參數則無效

//圖像位置設定
$General_Image_Dir = 'images';        //基本圖片位置(背景圖片)
$Unit_Image_Dir = 'unitimg';        //機體圖片位置
$Base_Image_Dir = 'img1';        //系統圖片位置

//基本等待時間設定
$Btl_Intv = 3;                        //戰鬥等待時間, 若伺服器上線人數多, 請設大一點, 以減少系統資源消耗
$Move_Intv = 5;                //移動等待時間, 若版圖大的話, 可以設少一點, 但請注意國戰時工廠的使用

//銀行設定
$BankRqLv = 30;                        //銀行開戶所需等級 -- 建議高於 26 級, 以防止多重 Account 倒錢
$BankRqMoney = 150000;                //銀行開戶所需要的持有現金 -- 建議高於 150萬, 原因同上
$BankFee = 100000;                //開戶手續費
$Bank_SLog_Entries = 30;        //紀錄每頁顯示的數目, 建議不要超過30

//組織相關設定
$OrganizingCost = '10000000';        //建立組織價錢
$OrganizingFame = '10';                //建立組織所需要名聲 -- 名聲高和惡名高也可以建立組織默認25
$OrganizingNotor = '-10';        //建立組織所需要惡名 (需為負數) -- 名聲高和惡名高也可以建立組織 
$Org_War_Cost = 1000000;                //戰爭1小時所需價錢

//武器設定
$Max_Wep_Exp = 25000;                //武器經驗上限

//機體相關設定
$Max_HP = 30000;                 //HP 上限, 如果不想%回復HP的機體過強的話別設太高
$Max_EN = 5000;                        //EN 上限, 如果附款回EN很貴的話, 可以設高一點(5000已很高)
//機體改造設定
$Mod_HP_Cost = 75000;                //基本改造HP的價錢
$Mod_HP_UCost = 200000;                //高HP量改造HP的價錢, 如上限高的話, 可以把這 Set 高一點
$Mod_EN_Cost = 75000;                //基本改造EN的價錢, 如果附款回EN很貴的話, 可以設低一點
$Mod_EN_UCost = 200000;                //高EN量改造EN的價錢, 同上
//機體「基本改造工程」相關
$Mod_MS_base_success = 25;        //基本成功率, 建議 0 至 100, 但亦可設為負數或大於100
$Mod_MS_cpt_cost = 250000;        //每點改造值所耗金錢
$Mod_MS_vpt_cost = 10;                //每點改造值所耗勝利積分
$Mod_MS_cpt_penalty = 0.25;        //每點改造值扣除的基本成功率(此為百分比, 0.25 即 0.25%)
$Mod_MS_cpt_bonus = 0.25;        //每點改造點數的基本成功率加成(同上)
//機體「機體裝備合成工程」相關
$Mod_MS_pequip_c = 2.5;                //成功率係數, 成功率的公式為: 「((100-機體等級)*係數/100)*100%」

//格納庫相關設定
$Hangar_Price = 4000000;                //格納庫寄存價錢(每次記存), 如出現濫用的情況, 請加價...
$Hangar_Limit = 20;                //格納庫機體上限(每位玩家), 格納庫是十分消耗系統資源的一個系統, 建議不要太多

//修理設定
$RepairHPCost = '5';                //工廠回復1 HP所需價錢, 5 屬於貴的
$RepairENCost = '10';                //工廠回復1 EN所需價錢, 5 屬於比較便宜

//其他設定 - 基本
$VPt2AlloyReq = 1000;                //多少勝利績分才能兌換一個合金
$AlloyID = '969<!>0';                //合金ID (v0.3版 合金武器資料表ID: 969)
$ControlSEED = 1;                //只能為 0 或 1 :        0 -> 不允許種子持有者強制進入/脫離 SEED Mode
                                //                        1 -> 允許種子持有者強制進入/脫離 SEED Mode, SEED Mode 消耗SP -- 由 v0.24Alpha 開始, php-eb 就以這方式作為基礎發展, 建議使用!!
                                //詳情參閱安裝及發展指引

$TFDCostCons = 20000;                //購買合成方法的價錢係數, 公式: [2^(級數)]*價錢係數

$NotoriousIgnore = -25;                //名聲(負數為惡名)多少以下(不是包括這個數字), 自動取消攻擊在線玩家警告

$ModChType_Cost = 300000000;        //人種改造的價格

//Chatroom Configs - 聊天室設定
$SpeakIntv = 5;                        //發言相隔時間, 秒數
$ChatShow = 30;                        //聊天顯示的數目
$ChatSave = 0;               //聊天資訊保留秒數, 可用方程式,「(24*3600)」為一日一夜, 不設定或設為 0 會永久保留
$ChatAutoRefresh = 60;                //聊天資訊自動刷新的秒數, 建議不要少過 60 秒

//Other System Configs - 其他系統設定
global $LogEntries, $Show_ptime, $ChatShow, $ChatSave, $ChatAutoRefresh, $StartZoneRestriction, $dbcharset, $BStyleB;
$NPC_RegKey = '';                //無限型註冊碼值, 需要到SQL Server自行製作
$Show_ptime = 1;                //顯示程式運作時間, 設為 0 則不顯示
$LogEntries = 5;                //戰鬥紀錄數目上限, 請輸入 '0' 至 '5', 輸入零則會關閉戰鬥紀錄系統, 請勿設大於5, 以免系統出錯
                                //平均在線人數多於10人的話, 建議減至3則以下, 以減低資料消耗
$StartZoneRestriction = 5;        //玩家開始時的區域, 隨機分區, 可以設為 '0' 至 '8'
                                //設為 0 時必定會在 A1 開始遊戲
                                //設為 2 時會在 A1 至 A3 隨機出現, 如此類推
                                //如設為 5 時會在 A1 至 B3 隨機出現, 
                                //設為 8 時會在 A1 至 C3 隨機出現, 最高可設為8
                                //請參考 register.php Line 233 至 Line 244
$dbcharset = 'utf8';                //資料庫伺服器文字校對 - 繁體版 php-eb 無需更改
$BStyleB = "onmouseover=\"this.style.color='yellow'\" onmouseout=\"this.style.color='000000'\"";        //同上, 滑鼠移過時會轉色的語法

//Registering Config                //註冊設定
global $CFU_CheckRegKey, $CFU_CheckIP;
$CFU_CheckRegKey = '0';                //If True, Enabled        <-檢查註冊碼, 0為不檢查, 1為檢查, 請確認 Portal 系統正常運作中
$CFU_CheckIP = '0';                //As above                <-檢查IP位置, 0為不檢查, 1為檢查

//Anti Unauthorized Connection Settings
$disabled_AUC = 1;                        //防止盜連繫統的無效化參數: 0為開啟防止盜連繫統, 1是關閉防止盜連繫統
$AUC_Log = "unauthorizedlog.php";        //防止盜連繫統的紀錄檔名稱, 建議使用「.php」結尾

$Allow_AUC = "";
//此為正常連線位置
//請到 index2.php 修改 $HTTP_REFERER 參數
//以Regular Expression表達, 一般於「(」與「)+」之間輸入php-eb的目錄位置便可
//如:        (vsqa.no\-ip.com)+
//        (dai\-ngai.net)+
//        (phpebs.frwonline.com)+
//
//如想多於一個地方, 請如此輸入:
//        (vsqa.no\-ip.com|dai\-ngai.net|phpebs.frwonline.com)+
//在網址或目錄之間加「|」便可以
//請在「-」前加入「\」, 否則會出錯
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//
/*
Account Status:
-1: Administrator
0: Normal
1: Quartine        // Not in Use
2: Lock
*/
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//
//Connect

if(empty($NoConnect)){
mysql_connect ($GLOBALS['DBHost'], $GLOBALS['DBUser'], $GLOBALS['DBPass']) or die ('Could not access database because: ' . mysql_error());
if(mysql_get_server_info() > '4.1') {
        global $charset;
        $charset = 'utf8'; //伺服器文字校對 - 繁體版 php-eb 無需更改
        if(!$dbcharset && in_array(strtolower($charset), array('GB2312', 'big5', 'utf-8'))) {
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
        "NT+",       "NT-",
        "SSS+",      "SSS-",     "SS",
        "S",         "ACE+",     "ACE-",
        "A+",        "A-",       "B+",
        "B-",        "C+",       "C-",
        "D+",        "D-",       "E+",
        "E-",        "F+",       "F-");

global $MainColors;
$MainColors = array(                                                        //Rainbow Swatches By v2Alliance Gary
        "FF5050", "FF2828", "FF0000", "E10000", "C30000", "A50000",         //Red
        "FFDD78", "FFCE3C", "FFBF00", "EBB000", "D7A100", "C39200",         //Orange
        "FFFF78", "FFFF3C", "FFFF00", "EBEB00", "D7D700", "C3C300",         //Yellow
        "78FF78", "3CFF3C", "00FF00", "00E100", "00C300", "00A500",         //Green
        "78FFD2", "3CFFBE", "00FFAA", "00E196", "00C382", "00A56E",         //Light Green
        "78DDFF", "3CCEFF", "00BFFF", "00A9E1", "0092C3", "007CA5",         //Light Blue
        "7878FF", "3C3CFF", "0000FF", "0000E1", "0000C3", "0000A5",         //Blue
        "D278FF", "BE3CFF", "AA00FF", "9600E1", "8200C3", "6E00A5",         //Purple
        "FF78FF", "FF3CFF", "FF00FF", "E100E1", "C300C3", "A500A5",         //Indigo
        "FF78C7", "FF3CAE", "FF0095", "E10083", "C30072", "A50060",         //Violet
);

global $MainRanks;
$MainRanks = array(
'志願兵','二等兵','一等兵','上等兵','兵長',
'下士','中士','上士','曹長','准尉',
'少尉','中尉','上尉','少校','中校',
'上校','准將','少將','中將','四星上將',
'五星上將','元帥','總司令');

global $RightsClass;
$RightsClass = array("Major" => '總帥',"SMajor" => '大元帥');

global $CFU_Time;
$CFU_Time=time();
//Start Time Convert Function
function cfu_time_convert($The_Time){
$DateTime = getdate($The_Time);
switch($DateTime['wday']){case 0: $DateTime['wday']='日';break;
case 1: $DateTime['wday']='一';break;case 2: $DateTime['wday']='二';break;
case 3: $DateTime['wday']='三';break;case 4: $DateTime['wday']='四';break;
case 5: $DateTime['wday']='五';break;case 6: $DateTime['wday']='六';break;
}if (strlen($DateTime['minutes']) == 1){$DateTime['minutes']='0'.$DateTime['minutes'];}
if (strlen($DateTime['seconds']) == 1){$DateTime['seconds']='0'.$DateTime['seconds'];}
if($DateTime['hours'] > 12){$DateTime['period'] = '下午';$DateTime['hours']-=12;}
else $DateTime['period'] = '上午';
if($DateTime['hours'] == 0){$DateTime['hours']=12;}
$FormatDate = "$DateTime[year]年$DateTime[mon]月$DateTime[mday]日, 星期$DateTime[wday], $DateTime[period] $DateTime[hours]:$DateTime[minutes]:$DateTime[seconds]";
return $FormatDate;}
//End Time Convert Function
global $CFU_Date;
$CFU_Date = cfu_time_convert($CFU_Time); //convert the present time

//Anti-Unauthorized Connection
if (!$disabled_AUC){
if (!ereg($Allow_AUC,$HTTP_REFERER)){ //Anti-Direct Connection
echo "Unauthorized Connection Detected<br>Referer: $HTTP_REFERER<br>";
echo "IP: $REMOTE_ADDR Logged<br>";
postFooter();
$contents = '/*'."Date: `$CFU_Date' \n Logged Username: `$_SESSION[username]' \t\t Logged Password: `$_SESSION[password]'\n";
$contents .= "IP: `$REMOTE_ADDR' \t\t Referer: `$HTTP_REFERER'\n";
$contents .= "REQUEST_METHOD: `$REQUEST_METHOD' \t\t SCRIPT_FILENAME: `$SCRIPT_FILENAME' \nQUERY_STRING: `$QUERY_STRING '\n";
$contents .= '_______________________________________________________';
$contents .= '_______________________________________________________*/'."\n";
$fp = fopen($AUC_Log,"r+");
fwrite($fp,$contents) or die('123');
fclose($fp);
exit;
}
}
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_//

//Update Time
$CFU_TIME_USER = 0;
if (isset($session_un)) $CFU_TIME_USER = "$session_un";
elseif (isset($_SESSION['username']))$CFU_TIME_USER="$_SESSION[username]";
if ($CFU_TIME_USER){
$CFU_Time_UpDate_Q = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `time2` = '$CFU_Time' WHERE `username` = '$CFU_TIME_USER' LIMIT 1;");
mysql_query($CFU_Time_UpDate_Q);}
//End of Time Updating
function postFooter(){
        $mcfu_time = explode(' ', microtime());
        $cfu_ptime = number_format(($mcfu_time[1] + $mcfu_time[0] - $GLOBALS['cfu_stime']), 6);
        if ($GLOBALS['Show_ptime'])
        echo "</p><p align=\"center\" style='font-size:16px;color:red'>Processed in {$cfu_ptime} second(s)</p>";
}
function postHead($withoutbody=''){
                echo "<html>";
                echo "<head>";
                echo "<meta http-equiv=\"Pragma\" content=\"no-cache\">";
                echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
                echo "<title>無盡的戰鬥 PHP版</title>";
                echo "</head>";
                echo "<style type=\"text/css\">BODY {FONT-SIZE: 10px; FONT-FAMILY: \"Arial\",  \"新細明體\"; cursor:default}TD {FONT-SIZE: 9pt; FONT-FAMILY: \"Arial\", \"新細明體\"}A:visited {COLOR: #FFFFFF;}</style>";
                if (!$withoutbody) echo "<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;background-color: transparent;\" oncontextmenu=\"return false;\">";
                //if (!$withoutbody) echo "<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" style=\"font-family: Arial;font-size: 10pt\">";
}
function postHead2($withoutbody=''){
                echo "<html>";
                echo "<head>";
                echo "<meta http-equiv=\"Pragma\" content=\"no-cache\">";
                echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
                echo "<title>無盡的戰鬥 PHP版</title>";
                echo "</head>";
                echo "<style type=\"text/css\">BODY {FONT-SIZE: 10px; FONT-FAMILY: \"Arial\",  \"新細明體\"; cursor:default}TD {FONT-SIZE: 9pt; FONT-FAMILY: \"Arial\", \"新細明體\"}A:visited {COLOR: #FFFFFF;}</style>";
                if (!$withoutbody) echo "<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px; oncontextmenu=\"return false;\">";
                //if (!$withoutbody) echo "<body bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" style=\"font-family: Arial;font-size: 10pt\">";
}
function AuthUser(){
				session_start();
				$U = $_SESSION['username'];
				$P = $_SESSION['password'];
				$U = mysql_real_escape_string($U);
				$P = mysql_real_escape_string($P);
                $sql_ugnrli = ("SELECT username, password, acc_status FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE username='". $U ."'");
                $UsrGenrl_Qr = mysql_query ($sql_ugnrli) or die ('錯誤！<br>未能連接到SQL資料庫(PHPEB_ERROR: 001)'.$GLOBALS['DBPrefix'].':' . mysql_error());
                $UsrGenrl = mysql_fetch_array($UsrGenrl_Qr);
				if (!$UsrGenrl['username'] || ($UsrGenrl['password'] != md5($P) && $UsrGenrl['password'] != $P) || $UsrGenrl['username'] != $U){
                echo "<center><br><br>使用者名稱或密碼錯誤。<br><br><a href=\"index.php\" target='_top' style=\"text-decoration: none\">回到首頁</a>";
                postFooter();
                exit;}
                if ($UsrGenrl['acc_status'] == 2){
                echo "<center><br><br>帳號被鎖，請與管理員聯絡！<br><br><a href=\"http://ext4.me\" target='_top' style=\"text-decoration: none\">回到論壇</a>";
                postFooter();
                exit;}
				
}
function GetWeaponDetails($WepId,$AssignedVarible){
global $$AssignedVarible;
$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $WepId ."'");
$query_r = mysql_query($sql);
$$AssignedVarible = mysql_fetch_array($query_r);
}
function ReturnSpecs($Specs){$SpecsTag='';
if (!$Specs)$SpecsTag='沒有';
else{
//Weapon Specs
if(ereg('(DamA)+',$Specs))$SpecsTag .='機體損壞<br>';
if(ereg('(DamB)+',$Specs))$SpecsTag .='戰鬥不能<br>';
if(ereg('(MobA)+',$Specs))$SpecsTag .='加速<br>';
if(ereg('(MobB)+',$Specs))$SpecsTag .='超前<br>';
if(ereg('(MobC)+',$Specs))$SpecsTag .='閃避<br>';
if(ereg('(MobD)+',$Specs))$SpecsTag .='逃離<br>';
if(ereg('(Moba)+',$Specs))$SpecsTag .='簡單推進<br>';
if(ereg('(Mobb)+',$Specs))$SpecsTag .='強力推進<br>';
if(ereg('(Mobc)+',$Specs))$SpecsTag .='最佳化推進<br>';
if(ereg('(Mobd)+',$Specs))$SpecsTag .='高級推進<br>';
if(ereg('(Mobe)+',$Specs))$SpecsTag .='極級推進<br>';
if(ereg('(TarA)+',$Specs))$SpecsTag .='校準<br>';
if(ereg('(TarB)+',$Specs))$SpecsTag .='瞄準<br>';
if(ereg('(TarC)+',$Specs))$SpecsTag .='集中<br>';
if(ereg('(TarD)+',$Specs))$SpecsTag .='預測<br>';
if(ereg('(Tara)+',$Specs))$SpecsTag .='自動鎖定<br>';
if(ereg('(Tarb)+',$Specs))$SpecsTag .='高級校準<br>';
if(ereg('(Tarc)+',$Specs))$SpecsTag .='無誤校準<br>';
if(ereg('(Tard)+',$Specs))$SpecsTag .='多重鎖定<br>';
if(ereg('(Tare)+',$Specs))$SpecsTag .='完美鎖定<br>';
if(ereg('(DefA)+',$Specs))$SpecsTag .='簡單防禦<br>';
if(ereg('(DefB)+',$Specs))$SpecsTag .='正常防禦<br>';
if(ereg('(DefC)+',$Specs))$SpecsTag .='強化防禦<br>';
if(ereg('(DefD)+',$Specs))$SpecsTag .='高級防禦<br>';
if(ereg('(DefE)+',$Specs))$SpecsTag .='最終防禦<br>';
if(ereg('(Defa)+',$Specs))$SpecsTag .='格擋<br>';
if(ereg('(Defb)+',$Specs))$SpecsTag .='抗衡<br>';
if(ereg('(Defc)+',$Specs))$SpecsTag .='干涉<br>';
if(ereg('(Defd)+',$Specs))$SpecsTag .='堅壁<br>';
if(ereg('(Defe)+',$Specs))$SpecsTag .='空間相對位移<br>';
if(ereg('(PerfDef)+',$Specs))$SpecsTag .='完全防禦<br>';
if(ereg('(AntiDam)+',$Specs))$SpecsTag .='自動修復<br>';
if(ereg('(DoubleExp)+',$Specs))$SpecsTag .='經驗雙倍<br>';
if(ereg('(DoubleMon)+',$Specs))$SpecsTag .='金錢雙倍<br>';
if(ereg('(DefX)+',$Specs))$SpecsTag .='底力<br>';
if(ereg('(AtkA)+',$Specs))$SpecsTag .='興奮<br>';
if(ereg('(MeltA)+',$Specs))$SpecsTag .='熔解<br>';
if(ereg('(MeltB)+',$Specs))$SpecsTag .='完全熔解<br>';
if(ereg('(Cease)+',$Specs))$SpecsTag .='禁錮<br>';
if(ereg('(AntiPDef)+',$Specs))$SpecsTag .='貫穿<br>';
if(ereg('(AntiMobS)+',$Specs))$SpecsTag .='網絡干擾<br>';
if(ereg('(AntiTarS)+',$Specs))$SpecsTag .='雷達干擾<br>';
if(ereg('(MirrorDam)+',$Specs))$SpecsTag .='反射鏡<br>';
if(ereg('(NTCustom)+',$Specs))$SpecsTag .='新人類專用<br>';
if(ereg('(NTRequired)+',$Specs))$SpecsTag .='需要新人類力量<br>';
if(ereg('(COCustom)+',$Specs))$SpecsTag .='Coordinator專用<br>';
if(ereg('(PsyRequired)+',$Specs))$SpecsTag .='念動力專用<br>';
if(ereg('(SeedMode)+',$Specs))$SpecsTag .='SEED Mode<br>';
if(ereg('(EXAMSystem)+',$Specs))$SpecsTag .='EXAM系統啟動可能<br>';
if(ereg('(EVASystem)+',$Specs))$SpecsTag .='EVA Mode<br>';
if(ereg('(CostSP)+',$Specs)){$a = ereg_replace('.*CostSP<','',$Specs);$a = intval($a);$SpecsTag .="消耗SP($a)<br>";}
//輔助裝備專用的特殊效果
if(ereg('(HPPcRecA)+',$Specs))$SpecsTag .='HP回復<br>';
if(ereg('(ENPcRecA)+',$Specs))$SpecsTag .='EN回復(小)<br>';
if(ereg('(ENPcRecB)+',$Specs))$SpecsTag .='EN回復(大)<br>';
if(ereg('(ExtHP)+',$Specs)){$a = ereg_replace('.*ExtHP<','',$Specs);$a = intval($a);$SpecsTag .="HP附加($a)<br>";}
if(ereg('(ExtEN)+',$Specs)){$a = ereg_replace('.*ExtEN<','',$Specs);$a = intval($a);$SpecsTag .="EN附加($a)<br>";}
//Others
if(ereg('(FortressOnly)+',$Specs))$SpecsTag .='要塞專用<br>';
if(ereg('(RawMaterials)+',$Specs))$SpecsTag .='原料<br>';
if(ereg('(RawFinal)+',$Specs))$SpecsTag .='合成專用<br>';
if(ereg('(CannotEquip)+',$Specs))$SpecsTag .='無法裝備<br>';
//Attacking Type
if(ereg('(DoubleStrike)+',$Specs))$SpecsTag .='二連擊<br>';
if(ereg('(TripleStrike)+',$Specs))$SpecsTag .='三連擊<br>';
if(ereg('(AllWepStirke)+',$Specs))$SpecsTag .='全彈發射<br>';
if(ereg('(CounterStrike)+',$Specs))$SpecsTag .='反擊<br>';
if(ereg('(FirstStrike)+',$Specs))$SpecsTag .='先制攻擊<br>';
if(ereg('(CplAtk)+',$Specs))$SpecsTag .='完全命中<br>';
if(ereg('(NonDef)+',$Specs))$SpecsTag .='防禦不能<br>';
if(ereg('(AtkSub)+',$Specs))$SpecsTag .='補刀防禦<br>';
if(ereg('(SubAtk)+',$Specs))$SpecsTag .='補刀輸出加成<br>';
if(ereg('(GAtkDef)+',$Specs))$SpecsTag .='傷害減半<br>';
if(ereg('(EVAonly)+',$Specs))$SpecsTag .='EVA機體專用<br>';
if(ereg('(Gaoonly)+',$Specs))$SpecsTag .='勇者王專用<br>';

}
return $SpecsTag;
}
function GetMsDetails($MsId,$AssignedVarible){
global $$AssignedVarible;
$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE id='". $MsId ."'");
$query_r = mysql_query($sql);
$$AssignedVarible = mysql_fetch_array($query_r);
}
function GetTactics($TactId='0'){
$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` WHERE id='". $TactId ."'");
$query_r = mysql_query($sql);
return mysql_fetch_array($query_r);
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
function WriteHistory($Con){
$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_game_history` (`time`, `history`) VALUES (UNIX_TIMESTAMP(), '$Con');");
mysql_query($sql);
}
function GetUsrLog($username){
$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_log` WHERE username='". $username ."'");
$query = mysql_query($sql) or die ('無法取得紀錄資訊, 原因:' . mysql_error() . '<br>');
$Results = mysql_fetch_array($query);
return $Results;
}
function GetChType($Chtypeinput){
$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` WHERE id='". $Chtypeinput ."'");
$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$Assigned = mysql_fetch_array($query);
return $Assigned;
}
//End Get ChTypeFunction
//Start Get Organization Infos
function ReturnOrg($Org){
$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE id='". $Org ."'");
$query = mysql_query($sql) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
return mysql_fetch_array($query);
}
//End Get Organization Infos
//Start Get Map Fucntions
function ReturnMType($Type){
switch($Type){
    case 0: $ReturnType = '格陵蘭大陸';break;
    case 1: $ReturnType = '珊瑚海海域';break;
    case 2: $ReturnType = '空中';break;
    case 3: $ReturnType = '宇宙';break;
    case 4: $ReturnType = '殖民星';break;
    case 5: $ReturnType = '月面';break;
    case 6: $ReturnType = '直布羅陀海峽';break;
    case 7: $ReturnType = '休斯頓基地';break;
    case 8: $ReturnType = '帕米爾高原';break;
    case 9: $ReturnType = '設德蘭群島';break;
    case 10: $ReturnType = '摩爾曼斯克軍港';break;
    case 11: $ReturnType = '乞力馬扎羅';break;
    case 12: $ReturnType = '東南亞基地';break;
    case 13: $ReturnType = '神秘基地1';break;
    case 14: $ReturnType = '神秘基地2';break;
    case 15: $ReturnType = '神秘基地3';break;
    case 16: $ReturnType = '神秘基地4';break;
    case 20: $ReturnType = '馮布朗市';break;
    case 21: $ReturnType = '阿·巴瓦·庫';break;
    case 22: $ReturnType = '所羅門宇宙海';break;
    case 23: $ReturnType = '火星基地';break;
    case 24: $ReturnType = 'SIDE3';break;
    case 25: $ReturnType = '茨之園';break;
    case 26: $ReturnType = 'L3-X18999';break;
    case 27: $ReturnType = '邁錫尼帝國';break;
    case 28: $ReturnType = '天頂星帝國';break;
    
}return $ReturnType;
}
function ReturnMBg($Type){
switch($Type){
    case 0: $ReturnType = '/background/格陵蘭大陸/';break;
    case 1: $ReturnType = '/background/珊瑚海海域/';break;
    case 2: $ReturnType = '/background/空中/';break;
    case 3: $ReturnType = '/background/宇宙/';break;
    case 4: $ReturnType = '/background/殖民星/';break;
    case 5: $ReturnType = '/background/月面/';break;
    case 6: $ReturnType = '/background/直布羅陀海峽/';break;
    case 7: $ReturnType = '/background/休斯頓基地/';break;
    case 8: $ReturnType = '/background/帕米爾高原/';break;
    case 9: $ReturnType = '/background/設德蘭群島/';break;
    case 10: $ReturnType = '/background/摩爾曼斯克軍港/';break;
    case 11: $ReturnType = '/background/乞力馬扎羅/';break;
    case 12: $ReturnType = '/background/東南亞基地/';break;
    case 13: $ReturnType = '/background/神秘基地/';break;
    case 14: $ReturnType = '/background/神秘基地/';break;
    case 15: $ReturnType = '/background/神秘基地/';break;
    case 16: $ReturnType = '/background/神秘基地/';break;
    case 20: $ReturnType = '/background/馮布朗市/';break;
    case 21: $ReturnType = '/background/阿·巴瓦·庫/';break;
    case 22: $ReturnType = '/background/所羅門宇宙海/';break;
    case 23: $ReturnType = '/background/火星基地/';break;
    case 24: $ReturnType = '/background/SIDE3/';break;
    case 25: $ReturnType = '/background/茨之園/';break;
    case 26: $ReturnType = '/background/L3-X18999/';break;
    case 27: $ReturnType = '/background/邁錫尼帝國/';break;
    case 28: $ReturnType = '/background/天頂星帝國/';break;
}return $ReturnType;
}
function ReturnMap($MapID){

$sqls = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_map` WHERE map_id='". $MapID ."'");
$querys = mysql_query($sqls) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$Sys = mysql_fetch_array($querys);

$sqlu = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE map_id='". $MapID ."'");
$queryu = mysql_query($sqlu) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$User = mysql_fetch_array($queryu);

return Array("Sys" => $Sys, "User" => $User);
}
//End Get Map Functions
//Start Converting Functions
function rankConvert($Num,$Bold='Bold'){
$NumRanks = count($GLOBALS["MainRanks"]);
$IndF = ($Num / 100000) * 20;
$Index = floor(20 - $IndF);
if ($Index < 0)$Index = 0;
if ($Index > 19)$Index = 19;
$IndF2 = ($Num / 100000) * $NumRanks;
$Index2 = ceil($IndF2);
if ($Index2 < 0)$Index2 = 0;
if ($Index2 > $NumRanks)$Index2 = $NumRanks;
$Index2-=1;
$VarA = $GLOBALS["ConvColors"];
$VarB = $GLOBALS["MainRanks"];
$NVar = "<font style=\"font-weight: $Bold; color: ".$VarA[$Index]."\">".$VarB[$Index2]."</font>";
Return $NVar;
}
function colorConvert($Num,$Max='150'){
if ($Num > $Max)$Num = $Max;
$ClrIndF = $Num / $Max * 20;
$ClrIndex = floor(20 - $ClrIndF);
if ($ClrIndex < 0)$ClrIndex = 0;
if ($ClrIndex > 19)$ClrIndex = 19;
$Var = $GLOBALS["ConvColors"];
Return $Var[$ClrIndex];
}
function gradeConvert($Num,$Max='150'){
if ($Num > $Max)$Num = $Max;
$GrdIndF = $Num / $Max * 20;
$GrdIndex = floor(20 - $GrdIndF);
if ($GrdIndex < 0)$GrdIndex = 0;
if ($GrdIndex > 19)$GrdIndex = 19;
$Var = $GLOBALS["ConvGrades"];
Return $Var[$GrdIndex];
}
function dualConvert($Num,$Max='150',$Bold='Bold'){
if ($Num > $Max)$Num = $Max;
$IndF = $Num / $Max * 20;
$Index = floor(20 - $IndF);
if ($Index < 0)$Index = 0;
if ($Index > 19)$Index = 19;
$VarA = $GLOBALS["ConvColors"];
$VarB = $GLOBALS["ConvGrades"];
$NVar = "<font style=\"font-weight: $Bold; color: ".$VarA[$Index]."\">".$VarB[$Index]."</font>";
Return $NVar;
}
//End Converting Functions

//Start Auto Repairing Function
function AutoRepair($username){
$sqlgame = ("SELECT `msuit`,`time1`,`hp`,`sp`,`en`,`hpmax`,`spmax`,`enmax`,`eqwep`,`status`,`hypermode` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` b WHERE a.username='". $username ."' AND a.username=b.username");
$query_game = mysql_query($sqlgame) or die ('無法取得遊戲資訊, 原因:' . mysql_error() . '<br>');
$Game = mysql_fetch_array($query_game);
if ($Game['status']){$RepairFlag = 1;}
elseif ($Game['hp'] < $Game['hpmax'] || $Game['sp'] < $Game['spmax'] || $Game['en'] < $Game['enmax']){$RepairFlag = 1;}

if (isset($RepairFlag)){
$Use_Time = time();
$ihp = $Game['hp'];
$isp = $Game['sp'];
$ien = $Game['en'];
$Time_Difference=$Use_Time-$Game['time1'];
if ($Time_Difference >= 3) {
$sql = ("SELECT `hprec`,`enrec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE id='". $Game['msuit'] ."'");
$query_r = mysql_query($sql);
$MS = mysql_fetch_array($query_r);

if ($MS['hprec'] >= 1){$Game['hp'] += $Time_Difference*$MS['hprec'];}//Constant HP Recovery
if ($MS['hprec'] < 1 && $MS['hprec'] >= 0.0001){$Game['hp'] += $Time_Difference*($MS['hprec']*$Game['hpmax']);}//Percentage HP Recovery

if ($MS['enrec'] >= 1){$Game['en'] += $Time_Difference*$MS['enrec'];}//Constant EN Recovery
if ($MS['enrec'] < 1 && $MS['enrec'] >= 0.0001){$Game['en'] += $Time_Difference*($MS['enrec']*$Game['enmax']);}//Percentage EN Recovery


if ($Game['eqwep'] != '0<!>0' && $Game['eqwep']){
$Eq_Id = explode('<!>',$Game['eqwep']);
$Eq_Prep = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $Eq_Id[0] ."'");
$Eq_Query = mysql_query($Eq_Prep);
$Eq = mysql_fetch_array($Eq_Query);
if (ereg('(HPPcRecA)+',$Eq['spec']) && $MS['hprec'] >= 1){$Game['hp'] += $Time_Difference*(0.005*$Game['hpmax']);}
if (ereg('(ENPcRecB)+',$Eq['spec']) && $MS['enrec'] >= 1){$Game['en'] += $Time_Difference*(0.015*$Game['enmax']);}
elseif (ereg('(ENPcRecA)+',$Eq['spec']) && $MS['enrec'] >= 1){$Game['en'] += $Time_Difference*(0.0075*$Game['enmax']);}
}

$SP_RecSpd = $Time_Difference * (0.004*$Game['spmax']);
if ($Game['hypermode'] == 2 || $Game['hypermode'] == 6) $SP_RecSpd *= 2;
$Game['sp'] += $SP_RecSpd;

if ($Game['hp'] >= $Game['hpmax'] && $Game['status'] == 1){$Game['status'] = 0;$Game['hp'] = $Game['hpmax'];}
if ($Game['hp'] > $Game['hpmax']) $Game['hp'] = $Game['hpmax'];
if ($Game['en'] > $Game['enmax']) $Game['en'] = $Game['enmax'];
if ($Game['sp'] > $Game['spmax']) $Game['sp'] = $Game['spmax'];
$sqlg = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET ");
$sqlg .=("`hp` = '$Game[hp]' ,");
$sqlg .=("`en` = '$Game[en]' ,");
$sqlg .=("`sp` = '$Game[sp]' ,");
$sqlg .=("`status` = '$Game[status]' WHERE `username` = '$username' LIMIT 1;");
mysql_query($sqlg) or die ('無法更新遊戲資訊, 原因:' . mysql_error() . '<br>');
$sqln = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `time1` = '$Use_Time' WHERE `username` = '$username' LIMIT 1;");
mysql_query($sqln) or die ('無法更新遊戲資訊, 原因:' . mysql_error() . '<br>錯誤2');
}
}
$Assigned = array("hp" => $Game['hp'],"en" => $Game['en'],"sp" => $Game['sp'],"status" => $Game['status']);
Return $Assigned;
}//End Auto Repairing Function
//Start Status Point Calculation
function CalcStatPt($Prefix,$Lv_N){
$Stat_Gain=3;
for($Lv=1;$Lv<=$Lv_N;$Lv++){
        if ($Lv%5 == 0)$Stat_Gain++;
        }
$AssignmentStat_Gain ="$Prefix".'_Stat_Gain';
global $$AssignmentStat_Gain;
$$AssignmentStat_Gain=$Stat_Gain;
}//EndGain
function CalcStatReq($Prefix,$Stat_N){//Req
$Stat_Req=2;
for($Stat=1;$Stat<=$Stat_N;$Stat++){
        if (($Stat-1)%10 == 0 && $Stat>1)$Stat_Req++;
        }
$AssignmentStat_Req ="$Prefix".'_Stat_Req';
global $$AssignmentStat_Req;
$$AssignmentStat_Req=$Stat_Req;

}//End Stat Point Function




//Start Calc Exp Functions
function CalcExp ($NowLv='',$AssignVar='UserNextLvExp',$ShowFlag=''){
if ($ShowFlag == 1){
        $Lv=1;$Exp=0;
        $i= 0;$n= 0;
        $C[0] = 0;
        echo "Lv --- Exp --- 總經驗<br>";
        while ($Lv <= 1000){

                $n=$i;
                $i = $i + 1;

                if (($Lv%100) == 0){
                $Exp=ceil($Lv*($Lv*0.5) + $Exp+0.00003);}
                elseif(($Lv%500) == 0){
                $Exp=ceil($Lv*($Lv*0.4) + $Exp+0.00001);}
                else{
                $Exp=ceil($Lv*($Lv*0.6) + $Exp+0.00005);
                }
                if($Lv >= 900){
                $Exp=ceil($Lv*($Lv*0.3) + $Exp+0.000001);}
                $ShowExp =number_format($Exp);
                echo "$Lv --- $ShowExp --- ";

                $D=$Exp + $C[$n];
                $C[$i]=$D;
                $ShowD = number_format($D);
                echo "$ShowD<br>";
                $Lv=$Lv + 1;
                }
        }
else        {
        $Lv=1;
        $Exp=0;
        $i= 0;
        $n= 0;
        global $$AssignVar;

        while ($Lv <= $NowLv){

                $n=$i;
                $i = $i + 1;

                if (($Lv%100) == 0){
                $Exp=ceil($Lv*($Lv*0.5) + $Exp+0.00003);}
                elseif(($Lv%500) == 0){
                $Exp=ceil($Lv*($Lv*0.4) + $Exp+0.00001);}
                else{
                $Exp=ceil($Lv*($Lv*0.6) + $Exp+0.00005);
                }
                if($Lv >= 900){
                $Exp=ceil($Lv*($Lv*0.3) + $Exp+0.000001);}

                $D=$Exp + $C[$n];
                $C[$i]=$D;
                if ($Lv == $NowLv) $$AssignVar = $Exp;
                $Lv=$Lv + 1;

                }
}
}//EndOfOldCalcFunction

?>
