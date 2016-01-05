<?php
//-------------------------//-------------------------//-------------------------//
//----------------------------   Configuration Unit   ---------------------------//
//----------------------------   phpeb Version 0.50   ---------------------------//
//---------------------------   Release Candidate 1    --------------------------//
//-------------------------//-------------------------//-------------------------//

//資訊設定
global $sSpec, $WebMasterName, $WebMasterSite;
$sSpec = 'Official RC';                                  //其他版本資訊, 這項可自由修改
$WebMasterName = 'v2Alliance';                           //網主名稱
$WebMasterSite = 'http://v2alliance.no-ip.org/';         //網名網址, 按下 "$sSpec" 時所開啟的網頁

//Database Configs 資料庫設定
global $DBHost, $DBUser, $DBPass, $DBName, $DBPrefix;

$DBHost = 'localhost';                                   //資料庫位置, 如 localhost, 127.0.0.1, www.yourdomain.com
$DBUser = 'root';                                        //資料庫使用者名稱
$DBPass = '';                                            //資料庫密碼
$DBName = 'phpeb';                                       //資料庫名稱
$DBPrefix = 'v2a_';                                      //資料表前綴名, 安裝前請冒必更改!! 安裝後不能再更改!!

//Setting Configs
global $MAX_PLAYERS, $Offline_Time, $TIME_OUT_TIME, $RepairHPCost, $RepairENCost, $EmergencyCost, $OrganizingCost, $HP_BASE_RECOVERY, $EN_BASE_RECOVERY;
global $General_Image_Dir, $Unit_Image_Dir, $Base_Image_Dir, $Org_War_Cost, $Max_Wep_Exp;
global $Mod_HP, $Mod_HP_Cost, $Mod_HP_UCost, $Mod_EN, $Mod_EN_Cost, $Mod_EN_UCost,$TFDCostCons;
global $ticketMax, $dailyTicketLim, $ticketCost;

//基本設定
$TIME_OUT_TIME = 3600;           //逾時時間, 秒數
$Offline_Time =	600;             //判定為「休息中」, 離線的時間, 秒數, 以 user_game 的 time2 作準
$MAX_PLAYERS = 500;              //登錄人數上限, 若不設定或設定為零, 此參數則無效
$HP_BASE_RECOVERY = 0.0033;      //HP基本回復率
$EN_BASE_RECOVERY = 0;           //EN基本回復率, 已無效
$OLimit = 25;                    //上線人數上限, 若不設定或設定為零, 此參數則無效

//圖像位置設定
$General_Image_Dir = 'images';   //基本圖片位置(背景圖片)
$Unit_Image_Dir = 'unitimg';     //機體圖片位置
$Base_Image_Dir = 'img1';        //系統圖片位置

//基本等待時間設定
$Btl_Intv = 3;                   //戰鬥等待時間, 若伺服器上線人數多, 請設大一點, 以減少系統資源消耗
$Move_Intv = 15;                 //移動等待時間, 若版圖大的話, 可以設少一點, 但請注意國戰時工廠的使用

//銀行設定
$BankRqLv = 30;                  //銀行開戶所需等級 -- 建議高於 26 級, 以防止多重 Account 倒錢
$BankRqMoney = 1500000;          //銀行開戶所需要的持有現金 -- 建議高於 150萬, 原因同上
$BankFee = 100000;               //開戶手續費
$Bank_SLog_Entries = 30;         //紀錄每頁顯示的數目, 建議不要超過30

//組織相關設定
$OrganizingCost = '5000000';    //建立組織價錢
$OrganizingFame = '5';          //建立組織所需要名聲 -- 名聲高和惡名高也可以建立組織
$OrganizingNotor = '-5';        //建立組織所需要惡名 (需為負數) -- 名聲高和惡名高也可以建立組織
$Org_War_Cost = 200000;          //戰爭1小時所需價錢
//php-eb Ultimate Edition 相關設定
$ticketMax = 50000;              //軍事力量上限
$dailyTicketLim = 2500;          //軍力每日投資額上限
$ticketCost = 2000;              //每一點軍力的價格

//武器設定
$Max_Wep_Exp = 25000;            //武器狀態上限 -- 不建議大於25000或少於15000, 10000 相等於 「狀態值: +100%」
$Min_Wep_Exp = -10000;           //武器狀態下限 -- 不能少於 -10000, -10000 相等於 「狀態值: -100%」

//機體相關設定
$Max_HP = 10;                    //HP 上限倍數, 如果不想%回復HP的機體過強的話別設太高
$Max_EN = 10;                    //EN 上限倍數, 如果附款回EN很貴的話, 可以設高一點(5000已很高)
//機體改造設定
$Mod_HP_Cost = 50000;            //基本改造HP的價錢
$Mod_HP_UCost = 250000;          //高HP量改造HP的價錢, 如上限高的話, 可以把這 Set 高一點
$Mod_EN_Cost = 50000;            //基本改造EN的價錢, 如果附款回EN很貴的話, 可以設低一點
$Mod_EN_UCost = 250000;          //高EN量改造EN的價錢, 同上
//機體「基本改造工程」相關
$Mod_MS_base_success = 0;        //基本成功率, 建議 0 至 100, 但亦可設為負數或大於100
$Mod_MS_cpt_cost = 250000;       //每點改造值所耗金錢
$Mod_MS_vpt_cost = 10;           //每點改造值所耗勝利積分
$Mod_MS_cpt_penalty = 0.25;      //每點改造值扣除的基本成功率(此為百分比, 0.25 即 0.25%)
$Mod_MS_cpt_bonus = 0.25;        //每點改造點數的基本成功率加成(同上)
//機體「機體裝備合成工程」相關
$Mod_MS_pequip_c = 2.5;          //成功率系數, 成功率的公式為: 「((100-機體等級)*系數/100)*100%」

//格納庫相關設定
$Hangar_Price = 100000;          //格納庫寄存價錢(每次記存), 如出現濫用的情況, 請加價...
$Hangar_Limit = 25;              //格納庫機體上限(每位玩家), 格納庫十分消耗系統資源, 建議不要太多

//修理設定
$RepairHPCost = '5';             //工廠回復1 HP所需價錢, 5 屬於貴的
$RepairENCost = '5';             //工廠回復1 EN所需價錢, 5 屬於比較便宜
$EmergencyCost = 50;             //緊急出擊的價錢, 要乘以機體等級
$RepairEqCondCost = 500;         //工廠回復 0.01% 裝備狀態值所需價錢
$RepairEqCondMax = 0;            //工廠回復裝備狀態值最大值, 0 為 ±0%, -1000 為 -10%, 1000 為 +10%... 不建議大於 0

//其他設定 - 基本
$VPt2AlloyReq = 1000;            //多少勝利績分才能兌換一個合金
$AlloyID = '800690';             //合金ID (v0.3x版 合金武器資料表ID: 800690)
$AlloyPoints = 50;               //合金ID 兌換的改造點數
                                 //詳情參閱安裝及發展指引

$TFDCostCons = 5000;            //購買合成方法的價錢系數, 公式: [2^(級數)]*價錢系數

$NotoriousIgnore = -25;          //名聲(負數為惡名)多少以下(不是包括這個數字), 自動取消攻擊在線玩家警告

$ModChType_Cost = 1000000;       //人種改造的價格

//Chatroom Board Configs - 留言板設定
$rmChatAutoRefresh = 5;          //即時聊天主動更新相隔時間, 秒數, v0.44Beta 後已無作用
$SpeakIntv = 5;                  //發言相隔時間, 秒數
$ChatShow = 30;                  //聊天顯示的數目
$ChatSave = 0;                   //聊天資訊保留秒數, 可用方程式,「(24*3600)」為一日一夜, 不設定或設為 0 會永久保留
$ChatAutoRefresh = 60;           //聊天資訊自動刷新的秒數, 建議不要少過 60 秒

//Instant Chat Plugin Config - 聊天室插件設定
global $iChatInstalled, $iChatScript, $iChatConfig, $iChatTarget;
$iChatInstalled = 1;                          //即時聊天室插件已安裝, 0: 未安裝, 1: 已安裝
$iChatScript = 'plugins/ichat/iChat.php';	    //即時聊天室插件位置
$iChatConfig = 'plugins/ichat/config.php';	  //即時聊天室插件 Config 位置
$iChatTarget = 'iChat';                       //即時聊天室視窗 ID

//Battle System Configs - 戰鬥系統設定
global $Damage_MS_Bias, $Damage_MS_Sense, $Damage_Pi_Bias, $Damage_Pi_Sense, $Acc_MS_Bias, $Acc_MS_Sense, $Acc_Pi_Bias, $Acc_Pi_Sense, $Exp_Multiplier;

$Damage_MS_Bias = 1;                //機體攻防偏重系數, 當「攻方機體攻擊力」與「守方機體防禦力」相同時, 武器攻擊力的成數。設定為 1 時, 即攻防相等時, 打出武器原有攻擊力。
$Damage_MS_Sense = 40;              //機體攻防敏感系數, 當攻高於防多少, 武器攻擊力上升的倍數
$Damage_Pi_Bias = 1;                //機師攻防偏重系數
$Damage_Pi_Sense = 100;             //機師攻防敏感系數
$Acc_MS_Bias = 1;                   //機體命回偏重系數
$Acc_MS_Sense = 40;                 //機體命回敏感系數
$Acc_Pi_Bias = 0.8;                 //機師命回偏重系數
$Acc_Pi_Sense = 100;                //機師命回敏感系數

$Eq_Damage_Co = 1;                  //武器及裝備狀態值損耗系數, 建議設定: 1 (ps. 損耗基本值為 5)
$Eq_Damage_On_Co = 25;              //「在線對決」的狀態值損耗度倍數, 建議設定: 50
$Eq_Damage_Off_lim = 1000;          //下線時, 狀態值免損耗值, 設定為 1000 時, 代表狀態值最多被扣至 「+10%」
$Eq_Damage_Ex = 20;                 //被擊破時, 額外扣的狀態值
$Eq_Cond_Bonus_Basic = 5;           //裝備狀態值增長基本值
$Eq_Cond_Bonus_ExCo = 5;            //戰勝時, 狀態值增長的加成系數
$Eq_Damage_IgnoreLv = 50;           //保護新手機制, 多少級以下狀態值不扣
$Eq_Damage_ReduceLvGap = 20;        //保護新手機制, 攻擊者高反擊者多少級以上, 狀態值扣減量減半

$Exp_Multiplier = 1;               //經驗/金錢倍增系數

$Eq_Cond_Bonus_Basic *= $Exp_Multiplier;
$VPt2AlloyReq = floor($VPt2AlloyReq / $Exp_Multiplier);

//Other System Configs - 其他系統設定
global $LogEntries, $Show_ptime, $ChatShow, $ChatSave, $ChatAutoRefresh, $StartZoneRestriction, $dbcharset, $BStyleA, $BStyleB, $Game_Scrn_Type;
$NPC_RegKey = '';                   //無限型註冊碼值, 需要到SQL Server自行制作
$Game_Scrn_Type = 0;                //遊戲畫面選項, 0: v0.35版本 ; 1: 傳統 php-eb 版本
$AllowRefreshFormBtl = 0;           //顯示戰鬥後重新整理的按鈕, 適用於 v0.35 版本以後的新GUI, 0: 不顯示, 1:顯示
$Show_ptime = 1;                    //顯示程式運作時間, 設為 0 則不顯示
$LogEntries = 5;                    //戰鬥紀錄數目上限, 請輸入 '0' 至 '5', 輸入零則會關閉戰鬥紀錄系統, 請勿設大於5, 以免系統出錯
                                    //平均在線人數多於10人的話, 建議減至3則以下, 以減低資料消耗
$StartZoneRestriction = 8;          //玩家開始時的區域, 隨機分區, 可以設為 '0' 至 '8'
                                    //設為 0 時必定會在 A1 開始遊戲
                                    //設為 2 時會在 A1 至 A3 隨機出現, 如此類推
                                    //如設為 5 時會在 A1 至 B3 隨機出現,
                                    //設為 8 時會在 A1 至 C3 隨機出現, 最高可設為8
                                    //請參考 register.php Line 233 至 Line 244
$dbcharset = 'big5';                //資料庫伺服器文字校對 - 繁體版 php-eb 無需更改
$Time_Fix = 0;                      //與伺服器時差修正, 單位為秒, 如伺服器採用GMT國際時間, 而需要用香港、台北、北京時間, 則輸入 8*3600
$BStyleA = 'font-size: 9pt; color: #ffffff; background-color: #000000;';                          //主畫面的按鈕樣式
$BStyleB = "onmouseover=\"this.style.color='yellow'\" onmouseout=\"this.style.color='FFFFFF'\"";  //同上, 滑鼠移過時會轉色的語法

//v0.35 及 php-eb Ultimate Edition 相關設定
$SP_Stat_Req = 5;           //每點額外 SP 所需成長點數

//GUI - 適用於 v0.35(或更後的版本) 及 其GUI, 傳統GUI不能用的啊!!
$PriTarget = 'Alpha';       //主視窗的 id, php-eb 的所屬 視窗 的 id名稱,
$SecTarget = 'Beta';        //副視窗的 id, 副視窗即傳統介面下半部份的Frame
$ProcTarget = 'Process';    //處理視窗的 id, 用於處理一些指令, 一般不會被玩家看到的

//Registering Config           //註冊設定
global $CFU_CheckRegKey, $CFU_CheckIP;
$CFU_CheckRegKey = '0';        //If True, Enabled	<-檢查註冊碼, 0為不檢查, 1為檢查, 請確認 Portal 系統正常運作中
$CFU_CheckIP = '0';            //As above		<-檢查IP位置, 0為不檢查, 1為檢查
$CFU_RegLowerCaseOnly = '1';   //限制只能使用小寫階英文用戶名稱 - 會比較安全, 建議限制

//Behaviour Checker
$Use_Behavior_Checker = true;


?>