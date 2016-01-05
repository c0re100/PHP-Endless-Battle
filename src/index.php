<?php
// Workspace UE 屬
$IncludeSCFI = false; $IncludeLFFI = false; $IncludeCVFI = false;
include("cfu.php");
postHead('1');
?> 
<script language='JavaScript'>
function startgame(destination) {
window.open(destination,'<?php echo $PriTarget; ?>','top=20,left=50,width=800,height=600,menubar=0,toolbar=0,resizable=1,scrollbars=0,status=1');
//window.opener=null;
//window.close();
}
</script>
<body>
<center><table width=100% height=100%>
	<tr><td align='center' width=10% height=10%>
		<input type=button value="開始遊戲" onClick=startgame('index2.php')>
	</td></tr>
	<tr><td align='center' width=90% height=90% valign=top>
		<table width=60% border=1 style="border-collapse: collapse;font-size: 12; font-family: Arial" bordercolor="#000000">
			<tr>
				<td colspan=2><B>測試伺服器公告</B></td>
			</tr>
			<!-- 第五十五則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2010年3月6日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>很忙, 不多說了...
					<hr><b style="color: ForestGreen;font-size: 12pt">php-eb v0.50 Dev. Version / Beta Version</b>
					<br>Debug:
					<br>　- 專用化系統
					<br>　　 - 專用名稱不見了的 Bug
					<br>　　 - 無法把合金兌換改造點數的問題(比率 = 1000:1:50, 積分:合金:改造點)
					<br>- 名聲設定
					<br>　- 名聲不加經驗了, 但惡名仍會減經驗
					<br>　- 名聲/惡名影響薪金:
					<br>　　- 公式: 己方名聲 / 100 * 對方名聲或惡名
					<br>　　- 已方名聲名 > 0 才有用的, 薪金要擊破對方才能領
					<hr>置頂 : "<a href="http://php-eb.v2alliance.net/dev/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v3.0α</a>" (2010版連結更新了)
					<br>風之翎 @ 2009年3月06日 AM 1:02
				</td>
			</tr>
			<!-- 第五十四則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2010年2月21日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>假期最後一日也在 debug, 不過比想像中少...
					<br>只出現了一個 "非de不可" 的 Bug
					<br>以下是Debug日誌:
					<hr><b style="color: ForestGreen;font-size: 12pt">php-eb v0.50 Dev. Version / Beta Version</b>
					<br> - 主遊戲畫面: 用1280以下的 Resolution 時, 自動改用 800x600 的背景圖片的 Bug
					<br>　 - 由於大部份地區也沒有 800x600 的圖片, 用 1024x768 玩時會沒背景
					<br> - 採礦系統
					<br>　 - 地區採礦權判斷錯誤的Bug
					<br>　　 - 之前一切採礦權也以現在的位置作準＝_＝||
					<br> - 武器屬性問題: 部份不應該為實體的武器已改回應有的屬性
					<hr>置頂 : "<a href="http://php-eb.v2alliance.net/dev/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v3.0α</a>" (2010版連結更新了)
					<br>風之翎 @ 2009年2月21日 AM 18:34
				</td>
			</tr>
			<!-- 第五十三則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2010年2月20日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>公測正式開始!! (等了三年時間??)
					<br>臨開始前也發現一些 Bug －＿＿－"
					<br>不要緊, De了就好... 可是快沒時間了 (泣
					<br>公測伺服器基本上只是看不到這一頁的封測伺服器...
					<br>連資料也是共通的 XD
					<br>以下是更新日誌:
					<hr><b style="color: ForestGreen;font-size: 12pt">php-eb v0.50 Dev. Version</b>
					<br> - 裝備系統: 看到屬性和距離了, 但卻發現一些武器似乎設錯了屬性 @_@ (未修正)
					<br> - 機體更新: 初級 SEED 系列機體沒有防了, 但有 Phase Shift 和 EN 消耗(新特效), 還有耐熱
					<br> - 暫時移除了3級及以上的合成法購買, 未寫好
					<br> - 加入了部份較高階的裝備, 但暫時無法入手
					<br> - 購買機體時, 可看到相關特效 (Click機體資料會彈出提示), 也修正了「EN回復率」顯示「EN上限」的問題
					<br> - 遊戲設定更變:
					<br>　 - 成立組織費用: 1000萬 -> 500萬
					<br>　 - 起義軍力上限: 日投資率 * 4 (即1萬)
					<br>　 - 要塞機師能力調整: 下限 1, 上限 100; 每 1點 備用軍力提升 0.0025點 能力
					<br> - Debug:
					<br>　 - 國戰: 攻擊中立組織時, 守衛系統衍生的 Bug
					<br>　 - 合成: 購買合成法顯示價錢的 JavaScript Error
					<br>　 - 原料採集: 不用登入也能使用的Bug =__=||
					<br>　 - 刪除帳戶本已 Outdate, 現更新了;
					<br> - 新特效: 消耗EN (數值)
					<br>　- 機體專有的特效
					<br>　- 數值為實數時, 每次出擊扣減這數量的 EN
					<br>　- 數值為 % 時, 每次出擊扣減 EN上限 的指定百分比
					<br>　- 此效果不影響出擊, 只是純粹消耗 EN 的效果
					<hr>置頂 : "<a href="http://php-eb.v2alliance.net/dev/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v3.0α</a>" (2010版連結更新了)
					<br>風之翎 @ 2009年2月20日 AM 17:38
				</td>
			</tr>
			<!-- 第五十二則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2010年2月20日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>新年快樂！(嗎?)
					<br>這這這, (寒~) 是 php-eb v0.50 的更新日誌 (囧, 很冷...)
					<br>上次說:
					<br>下一版 (v0.49) 會有什麼? 呃... 計劃如下:
					<br>&nbsp; - 機體系統重組、重新定義
					<br>&nbsp;　 - 讓格納庫變得更實用
					<br>&nbsp;　 - 優化
					<br>&nbsp; - 對決 PvP 系統 (?)
					<br>&nbsp; - 更新部份機體圖片
					<br>全部都沒有實裝~ XD
					<br>以下是 v0.49 的更新:
					<hr><b style="color: ForestGreen;font-size: 12pt">php-eb v0.49 Dev. Version</b>
					<br>　- 註冊系統 Debug: 新註冊人種是空白的 Bug
					<br>　- PHP Function "eregi" 轉做 "preg_match", 此為優化及為 PHP 5.3 / 6 向上兼容
					<br>　- 地圖系統: 可選性挑選地圖勢力分佈
					<br>　- GUI Back-end: Code Refactor, 更清析; drawButton()
					<br>　- Firefox Support 加強: Virtually same as IE
					<br>　- information.php: 大區玩家資訊
					<br>　- Debug: HP, EN 或 SP 其中一樣是滿的時候, 不會自動回復的 Bug
					<br>　- Debug: 能加入不接受新會員的組織的漏洞
					<br>　- Debug: 守衛在同一大區也能守要塞的 Bug
					<br>　- Debug: 領地投資不受每日一次限制的漏洞
					<hr><b style="color: ForestGreen;font-size: 12pt">php-eb v0.50 Dev. Version</b>
					<br><br><b>套用新武器例表:</b>
					<br>　- 暫有兩條主線: 戰鬥小刀, 機關炮
					<br>　- Tier/Stage 制:
					<br>　　- Tier 階級
					<br>　　　- 每 Tier 間能力也有顯著分別
					<br>　　　- 共 10個 Tier, 分佈在 4個 Stage
					<br>　　- Stage 時期
					<br>　　　- Stage 間能力分別比 Tier 間更大
					<br>　　　- 跨越每個 Stage 也比跨越 Tier 難, 必定要合成
					<br>　　　- 4 個 Stage:
					<br>　　　　 - Early Stage (初期)
					<br>　　　　　 - 3個 Tier, T1 - T3
					<br>　　　　 - Mid Stage (中期)
					<br>　　　　　 - 3個 Tier, T4 - T6
					<br>　　　　 - Late Stage (晚期)
					<br>　　　　　 - 兩個 Tier, T7 & T8
					<br>　　　　 - Final Stage (終期)
					<br>　　　　　 - 兩個 Tier, T9 & T10
					<br><br><b>特效相關:</b>
					<br>　- 距離壓制效果: 遠距離武器對近距離武器一定機率發動「先制攻擊」
					<br>　- 「先制攻擊」效果 Debug (之前怎樣也不會發動)
					<br>　- CFU 處理特效名稱的小優化 (沒太大分別)
					<br>　- 新特效實裝: 實彈擊落
					<br>　　 - 對方使用屬性為「飛彈」的武器, 回數變為原本的60%
					<br>　- 新特效實裝: 密集射擊
					<br>　　 - 已方使用屬性為「飛彈」的武器, 回數以 50% 上升 66.7% (會抵銷實彈擊落)
					<br>　- 新特效實裝: 屬性減免效果
					<br>　　- 實體減免
					<br>　　　- 厚甲　　　　　: 實體傷害減免10%後再減免200點傷害。總減免量不大於1200。
					<br>　　　- 抗衝擊　　　　: 實體傷害減免15%後再減免500點傷害。總減免量不大於2000。
					<br>　　　- 彈開　　　　　: 實體傷害減免20%後再減免1000點傷害。總減免量不大於4000。
					<br>　　　- Phase Shift　 : 實體傷害減免27%後再減免1700點傷害。總減免量不大於6500。
					<br>　　　- V. P. S.　　　: 實體傷害減免35%後再減免2500點傷害。總減免量不大於10000。
					<br>　　- 光束減免(效果同上, 光束版)
					<br>　　　- 耐熱
					<br>　　　- 熱轉移
					<br>　　　- 扭曲
					<br>　　　- 折射
					<br>　　　- 消散
					<br>　　- 特殊減免(效果同上, 特殊版)
					<br>　　　- 念動平預
					<br>　　　- 重力操控
					<br>　　　- 空間干擾
					<br>　　　- 時空擾亂
					<br>　　　- 次元連結
					<br>　- 「貫穿」效果更新
					<br>　　- 無視一切減免效果。(包括全傷害減免)
					<br><br><b>裝備系統:</b>
					<br>　 - 結構更新
					<br>　 - 現在升級改造的需求狀態值不故定了
					<br>　 - <b>現在可以看到所有可能性了 (不再隱藏)</b>
					<br>　　 - 看不到即是沒有, 去<u>合成</u>吧∼∼
					<br>　 - 購買機體時, 列表顯示的機體改為「賣掉現在的機體後, 可以購買的機體」
					<br><br><b>原料採集系統:</b>
					<br>　- 現在「中立組織」的領地歡迎所有人採集原料, 但機率 <b>下降</b> 30%
					<br>　　　 - 下降是指當原本機率為 80% 時, 下降為 50%,
					<br>　　　　 原本機率少於 30% 的話, 將會變為 0%
					<br>　- 修改: 真的沒有採礦權的地區, 即使預早排了程, 也會無收穫, 但費用時收取 XD
					<br><br><b>維修系統:</b>
					<br>　- 現在預設回復 100% HP/EN 了, 按一下便可...
					<br>　- Debug: 維修時, 沒有計算自動回復的陳年舊 Bug =__=||
					<br>　　- 這次真的修正了
					<br>　- 強化 Firefox/Standard Browsers 支援, 不會再被洗 Warning
					<br><br><b>兵器製造工場 / 合成系統:</b>
					<br>　- 購買合成法時, 可清析看到合成材料需求
					<br>　　- 呃... 我們傳統的合成故事還有人看嗎???
					<br>　- 合成前, 可看到現有原料總數 (但專用化則還不行)
					<br><br><b>機師相關:</b>
					<br>　- 額外能力加成更改: 素質總值(含所有加成) 2次方 / 1500 (減少了, 由 /1000 變 /1500 )
					<br>　- 一般人 SEED Mode 加成增加 (防回 +15% -> +17% )
					<br><br><b>其他修正/更新:</b>
					<br>　- 即時聊天 Debug: IE 因上次更新多了個 Object Error, 已修正
					<br>　- 移除「二手市場」 Plugin
					<br><br><b>新增工具/工具修改:</b>
					<br>　- NPC 生成器
					<br>　　- 依等級生成指定數量的 NPC
					<br>　- NPC 肅清器
					<br>　　- 把所有 NPC 洗走的工具
					<br>　- 藍圖生成器
					<br>　　- 自動化生成藍圖的工具
					<br>　　- 會自動 Link 合成法 及改變一號合成庫的需求物品
					<br>　　- 會自動找取上一個(最後的)藍圖物品的 ID
					<br>　- 合成法新增器
					<br>　　- 一個新增合成法比較方便的工具
					<br>　　- 新增完可用「藍圖生成器」生成藍圖
					<br>　- 組織設定初始化器
					<br>　　- 洗 Server 時用的 Orz...
					<hr>傳說中的 v0.50 果然多更新!!
					<br>測試將會於明天正式開始...
					<br><br><b>仍未實裝的東西:</b>
					<br>&nbsp; - 好幾類武器
					<br>&nbsp; - 合成等級3 - 等級10, 所以別去買啊~~~
					<br>&nbsp; - 套機、及其特效
					<br>&nbsp; - Gundam 00 系列的東西 (用了新武器表, 原實裝了, 變到沒有實裝 0_0)
					<hr>置頂 : "<a href="http://php-eb.v2alliance.net/dev/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v3.0α</a>" (2010版連結更新了)
					<br>風之翎 @ 2009年2月20日 AM 3:48 (寫了一天, 不過當中還有不少時間是... 玩 php-eb ^^" ///Orz)
				</td>
			</tr>
			<!-- 第五十二則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2010年2月2日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>又一年了 ||Orz...
					<br>這是 v2Alliance 論壇正式開放後的第一則日誌...
					<br>這個日誌, 是 v0.48 的日誌... 改了什麼... 自己看吧 Orz...
					<br>跟上一版的預測不太一樣...
					<br>話說... 測試伺服器令我有種在「自High」的感覺 ＝　＝|||
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.48 Dev. Version</b>
					<br><br><b>原料採集系統:</b>
					<br>&nbsp; - 加入排程說明
					<br>&nbsp; - 排程1 設定了的時侯不能再更改了
					<br>&nbsp; - 欠款太多時, 會通知玩家了
					<br>&nbsp; - 現在有排程時, 會有時鐘倒數了(可是玩家電腦的時間設錯了的話會有問題)
					<br><br><b>戰鬥系統:</b>
					<br>&nbsp; - 引入 Phase Structure
					<br>&nbsp;　 - 其實是將一些性質相近的計算步驟集中, 令程序更清析
					<br>&nbsp;　 - 有優化成份
					<br>&nbsp; - 套裝系統
					<br>&nbsp;　 - 現在套裝系統基本上已做好, 只是未設定
					<br>&nbsp; - 系統優化
					<br>&nbsp; 　- 10次平均處理速度: 0.0300357 -> 0.0294675, 提升大約 2%
					<br>&nbsp; 　- 　Standard Deviation: 0.001468708 -> 0.00143634, 提升大約 2%
					<br>&nbsp; 　- 　(假如去除最快和最慢的測試, 優化後的穩定性明顯比較高)
					<br>&nbsp; 　- 多了功能, 卻快了一點點; 對於這麼常用的系統來說, 算是不錯的了...
					<br><br><b>人種設定:</b>
					<br>&nbsp; - 現在有第11至第16級人種了
					<br>&nbsp; - 第11級跟第10級一樣
					<br>&nbsp; - 系統更新: 改變了判定人種等級的 algorithm, 現在直接計算出來
					<br>&nbsp; - 系統更新: 資料庫 Data Redundancy 下降, ID 和 等級 已分離, 以 Combined Key 判定
					<br><br><b>主畫面系統更新:</b>
					<br>&nbsp; - 改用了 Phase Structure (但不太完整)
					<br>&nbsp; - 採用了與新戰鬥系統一樣的 sfo.class 玩家資訊處理方法
					<br>&nbsp;　 - 主畫面顯示的資訊跟戰鬥系統更接近了
					<br>&nbsp;　 - 特效的加成(實數那種, 如Hyper-Thruster)現在會顯示了
					<br><br><b>其他/整體更新:</b>
					<br>&nbsp; - Firefox 支援變得更好了
					<br>&nbsp;　 - 自動更新系統在 Firefox 上可以用到了
					<br>&nbsp;　 - 基本上用 Firefox 玩也沒有什麼大問題了, 只是 IE8 會比較好看, FF 沒 Filter...
					<br>&nbsp; - 特效判定變得更快了
					<br>&nbsp; - 新機體表, 加入了 Nu Gundam 和 Sazabi !!
					<br>&nbsp; 　- 新秘密工場機體, 大部份也有套裝版本(比較貴), 但未設定好
					<br>&nbsp; 　- 100級以上機體基本上全都要在秘密工場機體購買~
					<br>&nbsp; - 要塞初始能力更新了
					<br>&nbsp; - 資料庫上為武器類別作出預備了:
					<br>&nbsp;　 - 類別分為兩部份: 「距離」 和 「屬性」
					<br>&nbsp;　 - 距離 - range: 遠 = 0, 近 = 1, 特 = 2
					<br>&nbsp;　　 - 遠距離將會壓制近距離, 特殊距離的不受影響 (未實裝)
					<br>&nbsp;　 - 屬性 - attrb: Beam = 0, 實體 = 1, 飛彈 = 2, 特殊 = 3, 要塞 = 4
					<br>&nbsp;　 - 裝備應該會被定義為特殊距離特殊屬性
					<br>&nbsp;　 - 由於全部也未實裝, 現在全部也是遠距Beam~XD
					<br>&nbsp; - 情報、格納庫、秘密工場顯示裝備那部份, 由 O 和 X 改為: <img src="http://php-eb.v2alliance.net/dev/img1/crossImgW.gif" alt="Cross"> 和 <img src="http://php-eb.v2alliance.net/dev/img1/tickImgW.gif" alt="Tick">
					<br>&nbsp; - 秘密工場更名至「組織研究所」了 ^^, 反正都沒什麼秘密 Orz
					<br>&nbsp; - 開發耆新工具: tactCalculator
					<br>&nbsp; 　- 用來計算武器專用化效果的工具, 網址: <a href="http://php-eb.v2alliance.net/dev/others/tools/tactCalculator.html" style="font-size: 10pt;text-decoration: none;color: ForestGreen">http://php-eb.v2alliance.net/dev/others/tools/tactCalculator.html</a>
					<hr>怎那麼多更新?? Orz...
					<br>下一版 (v0.49) 會有什麼? 呃... 計劃如下:
					<br>&nbsp; - 機體系統重組、重新定義
					<br>&nbsp;　 - 讓格納庫變得更實用
					<br>&nbsp;　 - 優化
					<br>&nbsp; - 對決 PvP 系統 (?)
					<br>&nbsp; - 更新部份機體圖片
					<br>v0.50 預定計劃:
					<br>&nbsp; - 新武器表
					<br>&nbsp; - 套裝系統「實裝」
					<br>&nbsp; - 類別特效實裝
					<br>這些全(?)都是要消耗一定時間的更新...
					<br>話說, 假如新武器表突然出現的話, php-eb 也會突然出現... 嘿嘿... (泣...
					<hr>置頂 : "<a href="http://php-eb.v2alliance.net/dev/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v3.0α</a>" (2010版連結更新了)
					<br>風之翎 @ 2009年2月2日 AM 12:42 to AM 1:51 (寫了一小時多= =)
				</td>
			</tr>
			<!-- 第五十一則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2010年1月18日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>三季又三季, 三季之後又再三季...
					<br>新版 php-eb 已在不知不覺間開發了兩個年頭... =___=||
					<br>讓各位支持 php-eb 的人久等了... ||Orz
					<br>這是差不多一年以來第一次更新的日誌...
					<br>在封測的最後一版 (v0.45Beta) 後, 盡管還有更新, 卻一直沒有寫日誌...
					<br>最近兩個星期, php-eb 已躍進了三個版本, 由 v0.45 -> v0.46 -> v0.47 -> v0.48 ...
					<br>或許有人會問, v0.4x 系列都快變 v0.5 了, 怎還沒公開？
					<br>事實上... 我們早已決定, 由 "v0.xx" 命名的版本, 不會再公開...
					<br>公開的是「php-eb UE v1.0」版...
					<br>至於哪一版是 v1.0 ?
					<br>照現進度不遠了...
					<br>以下是一些計劃中的主要內容:
					<br>　v0.48 - 上位(100級後)人種, 武器類別;
					<br>　　　　　　(工作中... 由於前兩版更新太多, 這版會比較細)
					<br>　v0.49 - 新機體表、武器表; 更新部份機體圖片
					<br>　v0.50 - 套裝系統實裝, 類別特效實裝
					<br>就只有這三個版本,
					<br>v0.50 很有可能就是傳說中的「UE v1.0」版...
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.46 Dev. Version</b>
					<br><br><b>玩家機體能力:</b>
					<br>&nbsp; - HP 改造上限更變
					<br>&nbsp;　　- HP改造上限為基本HP的十倍
					<br>&nbsp; - EN 改造上限更變
					<br>&nbsp;　　- EN改造上限為基本EN的十倍
					<br>&nbsp; - 機體
					<br>&nbsp;　　- 賣出價變更: 現在為原價的 90%
					<br>&nbsp;　　- 賣出機體時, HP/EN 會同時變賣 (以基本價)
					<br><br><b>玩家機師能力:</b>
					<br>&nbsp; - 額外能力加成
					<br>&nbsp; 　 - 每1點能力加 0.1% 能力加成 
					<br>&nbsp; 　 - 公式:  額外能力加成: 素質總值(含所有加成) 2次方 / 1000
					<br>&nbsp; 　 - 「需求能力值」系列特效不會計算額外能力加成 (v0.47 才實裝的)
					<br>&nbsp;　　- SEED Mode 平衡修訂:
					<br>&nbsp;　　　- Coordinator:
					<br>&nbsp;　　　　- 全能力 +20% -> 全能力 +15%
					<br>&nbsp;　　　- Extended:
					<br>&nbsp;　　　　- Attacking, Reacting: +20% -> +15%
					<br>&nbsp;　　　　- Targeting: +10% -> +5%
					<br>&nbsp;　　　- Natural:
					<br>&nbsp;　　　　- 不變 - Defending, Reacting +15%
					<br>&nbsp;　　- Exam System 平衡修訂:
					<br>&nbsp;　　　- 100級前 - 不變:
					<br>&nbsp;　　　　- Enhanced, Extended:
					<br>&nbsp;　　　　　- Attacking: +10
					<br>&nbsp;　　　　　- Defending: -3
					<br>&nbsp;　　　　　- Reacting : -2
					<br>&nbsp;　　　　　- Targeting: +10
					<br>&nbsp;　　　　- Natural:
					<br>&nbsp;　　　　　- Attacking: +15
					<br>&nbsp;　　　　　- Defending: -6
					<br>&nbsp;　　　　　- Reacting : -4
					<br>&nbsp;　　　　　- Targeting: +10
					<br>&nbsp;　　　- 100級及後 - 二次加成:
					<br>&nbsp;　　　　- Enhanced, Extended:
					<br>&nbsp;　　　　　- Attacking: +5
					<br>&nbsp;　　　　　- Targeting: +5
					<br>&nbsp;　　　　- Natural:
					<br>&nbsp;　　　　　- Attacking: +10
					<br>&nbsp;　　　　　- Defending: -3
					<br>&nbsp;　　　　　- Reacting : -2
					<br>&nbsp;　　　　　- Targeting: +10
					<br><br><b>原料採集系統:</b>
					<br>&nbsp; - 即將捨棄舊有「金錢劍」系列
					<br>&nbsp; - 獨立的原料採集系統, 原料和武裝分開了
					<br>&nbsp; - 排程採集製, 每半小時一個排程
					<br>&nbsp; 　- 每個排程只能指定採集一種原料, 成功採集的話, 會獲得該原料一個單位
					<br>&nbsp; 　- 採集過程會失敗
					<br>&nbsp; - 原料分為 8級, 越高越愈罕有、採集成功率越低:
					<br>&nbsp; 　- Lv. 1: 精鋼
					<br>&nbsp; 　- Lv. 2: 原油
					<br>&nbsp; 　- Lv. 3: 複合鋁
					<br>&nbsp; 　- Lv. 4: 純銀
					<br>&nbsp; 　- Lv. 5: 月鈦
					<br>&nbsp; 　- Lv. 6: 超導體
					<br>&nbsp; 　- Lv. 7: 碳纖
					<br>&nbsp; 　- Lv. 8: 重氫
					<br>&nbsp; - 只能有己方組織領地採集、建立排程
					<br>&nbsp; - 每個地區的出產量都不一樣
					<br>&nbsp; - 成功率會受機師等級影響:
					<br>&nbsp; 　- 機師等級低的話, 高級原料的採集成功率會很低
					<br>&nbsp; 　- 影響公式: 實際成功率 = 預設採集成功率 * ( 1 - ( 原料等級/10 + 0.2 - 機師等級/100 ) )
					<br>&nbsp; 　　- 成功率不會高於「預設採集成功率」
					<br>&nbsp; - 收費:
					<br>&nbsp; 　- 每個排程都是一項「工作」, 不論成功與否, 都要收費
					<br>&nbsp; 　- 成功率越高, 價錢越便宜
					<br>&nbsp; 　- 記帳制:
					<br>&nbsp; 　　- 可以稍後再結帳
					<br>&nbsp; 　　- 結帳前原料庫會被鎖定
					<br>&nbsp; 　　- 結帳後, 有 10% 的支出將會納入組織資金
					<br><br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.47 Dev. Version</b>
					<br><br><b>銀行交易系統更新:</b>
					<br>&nbsp; - 可以交易(原料採集系統的)原料了
					<br>&nbsp; - 交易系統源碼重組、優化
					<br><br><b>兵器製造工場(合成及專用化系統)更新:</b>
					<br>&nbsp; - 現在可以用(原料採集系統的)原料了
					<br>&nbsp; 　 - 合成時: 只計較數量, 無次序之別
					<br>&nbsp; 　 - 專用化點數: 每級別的原料專用化點數也不同, 越高級越多點數
					<br>&nbsp; 　　 - 但由於高級原料比較罕見, 「高達尼母合金」和低級原料預計是主要素材
					<br>&nbsp; - 合成系統源碼重組、優化
					<br>&nbsp; 　- 合成時, 平均處理速度: 0.017420 -> 0.006010, 提升大約 3倍, 更快的處理
					<br>&nbsp; 　- 　Standard Deviation: 0.013842 -> 0.001088, 提升大約 13倍, 更穩定
					<br>&nbsp; 　- 重組合成完成的編碼, 隨機失敗的機會預料會大減
					<br>&nbsp; 　- 修正不故顯示「合成失敗」的Bug, 起因為Form進行了兩次Submission
					<br>&nbsp; - 合成藍圖系統
					<br>&nbsp; 　- 購買合成法時, 會得到「設計藍圖」物品(備用武裝)
					<br>&nbsp; 　- 新的合成法, 一般會要求「設計藍圖」放進第一個位
					<br>&nbsp; 　　- 換句話說, 「設計藍圖」是消耗品
					<br>&nbsp; 　　- 大幅降低購買合成法的價格
					<br>&nbsp; 　- 可以用「設計藍圖」物品, 到「兵器製造工場」或「武器庫」進行「檢視」
					<br>&nbsp; 　　- 「檢視」會顯示「設計藍圖」的武器的合成法
					<br>&nbsp; 　- 「設計藍圖」屬一般物品, 可以正常交易
					<br><br><b>武器庫更新:</b>
					<br>&nbsp; - 現在可以檢視「設計藍圖」了
					<br><br><b>情報系統更新:</b>
					<br>&nbsp; - 現在會顯示採集原料的「預設採集成功率」了
					<br>&nbsp; - 現在會顯示地型資訊了 (因為新版本很多設定也與地型有關)
					<br>&nbsp; - 完全支援 Mozilla Firefox 3.5 及 Google Chrome 了
					<br><br><b>玩家機師能力:</b>
					<br>&nbsp; - 「底力」及「念動力底力」
					<br>&nbsp; 　- 「底力」效果更變:
					<br>&nbsp; 　　- 以 60% 的機會, 機師 Defending +15
					<br>&nbsp; 　- 「強化人」 70級後會附送「底力」效果, 此效果不會重疊
					<br>&nbsp; 　- 「念動力底力」 效果改為:
					<br>&nbsp; 　　- 在沒有「底力」效果的場合下, 以 60% 的機會, 機師 Defending +15
					<br>&nbsp; 　　　- 此效果不當作「底力」, 無法觸法「兩倍底力」效果
					<br>&nbsp; 　　-「兩倍底力」
					<br>&nbsp; 　　　- 在有「底力」效果的場合下, 當發動「底力」時, 有 20% 機會「底力」效果加倍
					<br><br><b>其他更新:</b>
					<br>&nbsp; - 移動: 現在會顯示地型資訊了 (原因同上)
					<br>&nbsp; - 機體回復率: 復用「百份比基本回復量」, 所有機都必定會在5分鐘內完全回復
					<br>&nbsp; - 新版本「模擬計算器」, 詳見下方連結
					<br>&nbsp; - Firefox 的支援改善了, 最少可以無障礙地玩吧... 但仍建議使用IE8...
					<br>&nbsp; - 管理用小具:
					<br>&nbsp;　 - 合成配方器(grantTactRaw.php) : 自動把合成原料庫填滿的小工具, 用以測試合成法
					<br>&nbsp;　 - 藍圖生成器(blueprintTact.php): 自動建立「設計藍圖」武裝物品的小工具
					<br><br>
					<hr>置頂 : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v3.0α</a>" (連結更新了)
					<br>風之翎 @ 2010年1月19日 AM 1:30
				</td>
			</tr>
			<!-- 第五十則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2009年2月1日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>遲來的日誌...
					<br>這幾天其實一直都有更新 XD
					<br>只是不明顯和沒有寫日誌~
					<br>呵呵...
					<br>最明顯的更新卻十分明顯~嘿嘿...
					<br>不過花的時間也... 0.0"
					<br>測試也似乎接近尾聲了!?
					<hr>置頂:
					<br><b>測試伺服器設定</b>:
					<br>　- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">沒有改變, 請看看這裡...</a>
					<br><b>武器表及機體表</b>:
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">武器表</a>
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">機體表</a>
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.45β Close Test Version</b>
					<br><br><b>Debug 與 修改:</b>
					<br>&nbsp; - 強化要塞能力、HP
					<br>&nbsp;　 - 之前的設定有問題, 現在修正好了
					<br>&nbsp;　 - 程式結構也 Improve 了
					<br>&nbsp; - 有 Trans-AM 的機體(Exia 和 00)現在只能於正常狀態下進行「基本改造工程」
					<br>&nbsp; - 現在可以調整主視窗的大細了
					<br>&nbsp; - 使用者名稱和密碼現在不能以「0」開頭了
					<br><br><b>背景圖片補完:</b>
					<br>&nbsp; - 補完了四種地型(地面、月面、宇宙、殖民星)
					<br>&nbsp; 　　 的 1024x768、1280x800、1440x1050 和 1680x1050 圖片
					<br><br><b>iChat Plugin:</b>
					<br>&nbsp; - 新即時聊天系統
					<br>&nbsp; 　- 支援 IE 6, 7, 8 及 FF 3 (理論上 FF1 也支援的, 但沒測試)
					<br>&nbsp; 　- 三頻: 公開、密頻、組織頻度
					<br>&nbsp; 　- 舊聊天則易了名為「留言版」
					<br>&nbsp; 　- 有兩個 GM 指令: 清除Database 及 GM頻 (公告)
					<br>&nbsp; 　- 有新的歷史, 會在 即時聊天 顯示
					<br>&nbsp; 　- 自動提示功能: 有新訊息會自動提示(Firefox不支援此功能)
					<br>&nbsp; 　- 可調整視窗大細
					<hr>置頂 : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>" (連結更新了)
					<br>風之翎 @ 2009年2月1日 PM 8:15
				</td>
			</tr>
			<!-- 第四十九則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2009年1月25日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>年三十晚~呵呵呵呵~~ (瘋了 = ="
					<br>終於放假了>_<~
					<Br>Debug, debug 和 debug
					<br>修正了一堆 list 了的 bug...
					<br>建議大家也做一個 "list of bugs and recommendations" 給我, 這樣比較方便
					<hr>置頂:
					<br><b>測試伺服器設定</b>:
					<br>　- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">沒有改變, 請看看這裡...</a>
					<br><b>武器表及機體表</b>:
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">武器表</a>
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">機體表</a>
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.44β Close Test Version</b>
					<br>Debug 與 修改:
					<br>&nbsp; - 改不到要塞能力、HP的bug
					<br>&nbsp;　 - 同時也更改了HP增加量 ( 變少了 )
					<br>&nbsp; - 修理工場
					<br>&nbsp;　 - 現在國戰時用不到了
					<br>&nbsp;　 - 新增功能: 緊急維修
					<br>&nbsp; 　　- 狀態為修理中時使用
					<br>&nbsp; 　　- HP 達原始 HP (不含附加值時) 的 80% 可以使用
					<br>&nbsp; 　　- 把狀態變為可發進
					<br>&nbsp; - 成長點數加 SP 的效果更新: 由 加一點 變成 加 10點
					<br>&nbsp; - 解決改造機體基本能力時,上限數值不正確的問題
					<br>&nbsp; - 把 00 系列機體的 原始EN 提升 (象徵式), 00 Gundam 的 EN 上升為 1 (希望能解決「即時翻生」的Bug)
					<br>&nbsp; - 用 Internet Explorer 7 不能宣戰的問題
					<hr>置頂 : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>" (連結更新了)
					<br>風之翎 @ 2009年1月25日 PM 11:16
				</td>
			</tr>
			<!-- 第四十八則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2009年1月11日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>長話短說, 主要是 Debug
					<hr>置頂:
					<br><b>測試伺服器設定</b>:
					<br>　- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">沒有改變, 請看看這裡...</a>
					<br><b>武器表及機體表</b>:
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">武器表</a>
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">機體表</a>
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.43β Close Test Version</b>
					<br>Debug:
					<br>&nbsp; - 敵方不懂用戰術還擊的Bug
					<br>&nbsp; - 更正部份戰術的 Hit 修正 (機體命中修正)
					<br>&nbsp; - 合成的用詞問題
					<br>&nbsp; - %回復特效無效的問題
					<hr>置頂 : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>" (連結更新了)
					<br>風之翎 @ 2009年1月11日 PM 5:37
				</td>
			</tr>
			<!-- 第四十七則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2009年1月7日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>10倍經驗、金錢正式開始囉, 感謝各位!!<br>前期、中前期測試完結~~!!
					<hr>置頂 : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>" (連結更新了)
					<br>呃... 很忙= ="
					<br>風之翎 @ 2009年1月7日 PM 9:31
				</td>
			</tr>
			<!-- 第四十六則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2009年1月4日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>現版本: v0.42β Build #1
					<hr>置頂:
					<br><b>測試伺服器設定</b>:
					<br>　- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">沒有改變, 請看看這裡...</a>
					<br><b>武器表及機體表</b>:
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">武器表</a>
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">機體表</a>
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.42β Build #1 Close Test Version</b>
					<br>Debug:
					<br>&nbsp; - 國戰無故勝出的Bug, 完來有故的, 應該已 De 掉了
					<br>&nbsp; - 只有一個領地時, 無法調動軍力出征　＝　＝”
					<br>&nbsp; - 兩部 00 機體發動 Trans-AM 時, 不能自動更新自己圖片的問題
					<br>修改:
					<br>&nbsp; - 戰術學院
					<br>&nbsp;　 - 現在學完戰法會「自動更新」學了的戰法
					<br>&nbsp;　 - 現在可以用拉下式選單學習戰術 (針對 Firefox 不能購買戰術的問題)
					<br>&nbsp; - Trans-AM 系統更新
					<br>&nbsp;　 - 效果:  -> 主要延長了 Trans-AM 時間, 代價是「副作用」比較大
					<br>&nbsp;　　 - 戰鬥進行前有 10% 開啟 Trans-AM System
					<br>&nbsp;　　　 - 開啟 Trans-AM System, 機體能力上升 300% (沒改到)
					<br>&nbsp;　　 - 在 Trans-AM System 啟動狀態下, 有 50% 變回 「能力低下狀態」 (之前為 90%)
					<br>&nbsp;　　 - 在 「能力低下狀態」 下, 有 50% 變回 「正常狀態」(之前為 90%)
					<br>&nbsp; - 加入多兩把 GN 系列武器 (計算機已有相關資料), 為 00 Gundam 的武裝
					<br>&nbsp;　 - GN Beam Sabre (高命中、溶解、但沒貫穿)
					<br>&nbsp;　 - GN Sword II (高攻擊力、貫穿)
					<br>&nbsp; - 套機: 兩部 00 機 都會跟隨武裝了 (很實惠的價錢 Orz)
					<br>&nbsp; - 領地每日投資上限: 減半, 現為 2500
					<br>&nbsp; - 軍力價錢上升一倍: 現為 2000
					<br>PM 5:06 補充:
					<br>&nbsp; - 中立組織要塞被攻破也不扣軍力的 Bug 已除去
					<br>&nbsp; - 9和10級的合成武器攻擊力提升了5-10%
					<br>PM 10:12 補充:
					<br>&nbsp; - 加入以下機體圖:
					<br>&nbsp;　 - 00 Gundam & Trans-AM Mode Version
					<br>&nbsp;　 - Tallgeese III
					<br>&nbsp;　 - Hyaku-Shiki
					<br>&nbsp;　 - Gundam MK-II
					<hr>置頂 : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>" (連結更新了)
					<br>修改、Debug!<br>呃... 今天是假期都最後一天了 T^T... (早上9點做到現在Orz)
					<br>風之翎 @ 2009年1月4日 PM 1:50
				</td>
			</tr>
			<!-- 第四十五則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2009年1月3日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>現版本: v0.42β
					<hr>置頂:
					<br><b>測試伺服器設定</b>:
					<br>　- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">沒有改變, 請看看這裡...</a>
					<br><b>武器表及機體表</b>:
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">武器表</a>
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">機體表</a>
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.42β Close Test Version</b>
					<br>修改:
					<br>&nbsp; - 加入 Mobile Suit Gundam 00 的兩部機, 「套機」來的
					<br>&nbsp;　　- Gundam Exia, 有臨時圖
					<br>&nbsp;　　- 00 Gundam
					<br>&nbsp; - 加入 Trans-AM 系統
					<br>&nbsp;　 - 效果: 
					<br>&nbsp;　　 - 戰鬥進行前有 10% 開啟 Trans-AM System
					<br>&nbsp;　　　 - 開啟 Trans-AM System, 機體能力上升 300% (變態的)
					<br>&nbsp;　　 - 在 Trans-AM System 啟動狀態下, 有 90% 變回 「能力低下狀態」
					<br>&nbsp;　　 - 在 「能力低下狀態」 下, 有 90% 變回 「正常狀態」
					<br>&nbsp; - 加入 GN 系列武裝 (計算機有相關資料), 特點: <b>不消耗 EN</b>
					<br>&nbsp;　 - GN-Drive
					<br>&nbsp;　 - GN-Shield
					<br>&nbsp;　 - Seven-Sword System
					<br>&nbsp; - Devil Gundam: 換了新圖片
					<br>&nbsp; - Debug:
					<br>&nbsp;　　- 「中立組織」在「中立組織領地」練金錢劍系列也有經驗加成的Bug
					<br>&nbsp;　　- 修理工場: HP/EN 也會自動更新了 (之前只會更新其中一樣)
					<hr>這是 "大" 更新, XD
					<br>風之翎 @ 2009年1月4日 AM 00:14
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>現版本: v0.41β Build #4
					<hr>置頂:
					<br><b>測試伺服器設定</b>:
					<br>　- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">沒有改變, 請看看這裡...</a>
					<br><b>武器表及機體表</b>:
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">武器表</a>
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">機體表</a>
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.41β Build #4 Close Test Version</b>
					<br>修改:
					<br>&nbsp; - HiMAT 等 「%回避」 效果更正: 敵方命中率 * 「%回避效果」,
					<br>&nbsp;　　- 註: 命中率是可以高過100的, 
					<br>&nbsp;　　　　 - 例: 極端情況下, 如命中型打防型, HiMAT 是閃不掉的
					<br>&nbsp; - 「傷害減免效果」更新: 
					<br>&nbsp;　　- 格擋, 抗衡, 干涉, 堅壁, 空間相對位移: 減免量-> 500, 1000, 1500, 2500, 3500
					<hr>置頂 : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>" (連結更新了)
					<br>先來個小更新... (剛剛還以為今天是一月三日＝　＝")
					<br>風之翎 @ 2009年1月3日 PM 2:00 (前兩則也寫了做 2008 年 Orz)
				</td>
			</tr>
			<!-- 第四十四則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2009年1月2日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>現版本: v0.41β Build #3
					<hr>置頂:
					<br><b>測試伺服器設定</b>:
					<br>　- <a href="#testSettings" style="font-size: 10pt;text-decoration: none;color: ForestGreen">沒有改變, 請看看這裡...</a>
					<br><b>武器表及機體表</b>:
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/wep.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">武器表</a>
					<br>　- <a href="http://vsqa.dai-ngai.net/peb-u/ms.xls" style="font-size: 10pt;text-decoration: none;color: ForestGreen">機體表</a>
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.41β Build #3 Close Test Version</b>
					<br>Debug:
					<br>&nbsp; - 「HP附加」和「EN附加」的Bug
					<br>&nbsp; 　- 不會再 "Double Count" 了
					<br>&nbsp;  - 反擊者必定會使用戰法的Bug
					<br>&nbsp;  - 戰鬥前取消「進入SEED Mode」或「EXAM」時, SP 消耗不會變的問題
					<br>&nbsp;  - 在「中立組織」購買機體時, 資訊偏左的問題
					<br>修改:
					<br>&nbsp; - 用詞改變: 「對手的????被你擊敗」改成「對手的????被你擊破」
					<br>&nbsp; - Menu:
					<br>&nbsp;　 - 戰鬥
					<br>&nbsp;　　 - EN不足或修理中時會有提示了
					<br>&nbsp;　 - 按鈕範圍變大了(現在是整個TD)
					<hr>置頂 : "<a href="http://vsqa.dai-ngai.net/peb-u/program/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>" (連結更新了)
					<br>連續兩日~ Debug ~ Debug~~ 咦, 是兩日吧? (剛剛還以為今天是一月三日＝　＝")
					<br>風之翎 @ 2009年1月2日 PM 11:08
				</td>
			</tr>
			<!-- 第四十三則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2009年1月2日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>現版本: v0.41β Build #2
					<hr>置頂:
					<br><b>測試伺服器設定</b>:
					<br>　- 沒有改變, 請看看上一則日誌...
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.41β Build #2 Close Test Version</b>
					<br>　- 針對狀態值在保護機制下, 明明沒扣狀態值, 卻寫成扣了的 Bug
					<br>　- 針對軍階進行了多項修正
					<br>　　 - 增加兩個軍階「伍長」、「軍曹」, 均在「兵長」與「下士」之間, 現在4000「功績」為一軍階
					<br>　　 - 加入組織/在<u>中立組織</u>被雇用: 上升2000點「功績」
					<br>　　 - 脫離組織/被解雇/逃亡: 下降2000/4000/12000點「功績」
					<br>　　 - 提升「組織人員」(非中立組織者) 獲得「功績」
					<br>　　　 - 除去了「功績」會在國戰中倍增方式異常的Bug
					<br>　　 - 成立組織時, 「功績」改為上升 48000點 (由志願兵升到少尉), 而不是直接成為「總司令」
					<br>　　 - 退位限制: 72000 點 (准將), 副主席所需「功績」: 60000點 (少校)
					<br>　- 現在必須先解雇全組織人員才可以解散組織
					<Br>　- Debug:
					<Br>　　- 國戰無故勝出的Bug, <b>未確定是否已 DE 了</b>, 大家努力測試!!
					<hr>置頂 : "<a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>"
					<br>迎接新的一年 Orz... 想當年... v0.25Final 在 1月1日 的 零晨 推出呢, 熬了數晚夜, 真懷念 >_<"
					<br>風之翎 @ 2009年1月2日 AM 3:19
				</td>
			</tr>
			<!-- 第四十二則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年12月30日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>php-eb Ultimate Edition, 簡稱「peb-u」封測正式開始！
					<br>現版本: v0.41β
					<hr>置頂:
					<br><a name='testSettings'><b>測試伺服器設定</b></a>:
					<br>不定, 會因應情況改變設定
					<br><b>測試目的</b>:
					<br>　- 遊戲難易度  
					<br>　- 平衡檢定
					<br>　- Bug 測試
					<br>　- 安全性 測試
					<br>　- 效能 (遊戲流暢度)
					<br><b>目前規則</b>:
					<br>　- 30級前<b>不可以</b>使用外掛＝　＝"
					<br>　　 - 30級後請找我相討, 封測不是虐待 XD
					<br>　- 找到Bug, 請回報
					<br>　　 - 任何方式, MSN、E-Mail、php-eb聊天室、各論壇的PM、電話 (有的話)、etc...
					<br>　- <b>保密</b>封測內容、相關資料
					<br>　- 風之翎 及 v2Alliance 保留一切更改規則的權利 Orz
					<br><b>註冊格式</b>:
					<br>　- 用我供應的用戶名稱開頭
					<br>　　 - 分身於該用戶名稱後加上數字
					<br>　　 - 例: 我供應的用戶名稱 -> gary
					<br>　　　　- 主帳戶username: gary
					<br>　　　　- 分身: gary1, gary2, gary3 ... (<s>大細階有自主權</s>, <i>原來沒有的</i>)
					<br>　　 - 不明個體被發現會被<b>刪除</b>
					<br>　　 - <b>遊戲內的名稱<u>沒有限制</u></b>
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.41β Close Test Version</b>
					<br>- 狀態值設定更改
					<br>　 - 攻擊離線玩家時, 狀態值不會扣到少於 +10% (即 +10% 以下不會扣)
					<br>　 - 保護新手機制:
					<br>　　　 - 50級以下, 狀態值不會扣減
					<br>　　　 - 攻擊者高反擊者 20級, 扣減量減半
					<br>　 - 國戰設定: 攻擊在線人時, 狀態值扣減量為 2 倍 (雙方)
					<br>　 - 被擊破時, 額外扣的狀態值由 100 減至 20
					<br>　 - 「在線對決」的狀態值損耗度倍數由: 50 減至 25
					<br>　 - 負狀態值時, EN消耗異常地少的Bug已DE了
					<br>- 國戰:
					<br>　 - 中立組織不會再有防守通知書了
					<br>　 - 區域資訊會顯示「軍力、守備能力」了
					<br>- 組織
					<br>　 - 受邀入組織不會初始化軍階了
					<br>- 戰鬥畫面
					<br>　 - 改變了狀態值增減的顯示方式
					<br>　 - 「戰鬥」快捷鍵加入倒數, 防止出現過快的訊息
					<br>- 格納庫
					<br>　 - 沒任何機體時不能再按「取出」和「賭送」了
					<hr>這個還是要置頂 : "<a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>"
					<br>忙了好幾天... 今天終於有時間改改了= =
					<br>風之翎 @ 2008年12月30日 PM 8:27
				</td>
			</tr>
			<!-- 第四十一則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年12月27日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>php-eb Ultimate Edition, 簡稱「peb-u」封測正式開始！
					<br>現版本: v0.4β
					<br>與 v0.4α 版有一定程度的分別...
					<br>不多說了... 下方有日誌...
					<hr>轉貼:
					<br><b>測試伺服器設定</b>:
					<br>不定, 會因應情況改變設定
					<br><b>測試目的</b>:
					<br>　- 遊戲難易度  
					<br>　- 平衡檢定
					<br>　- Bug 測試
					<br>　- 安全性 測試
					<br>　- 效能 (遊戲流暢度)
					<br><b>目前規則</b>:
					<br>　- 30級前<b>不可以</b>使用外掛＝　＝"
					<br>　　 - 30級後請找我相討, 封測不是虐待 XD
					<br>　- 找到Bug, 請回報
					<br>　　 - 任何方式, MSN、E-Mail、php-eb聊天室、各論壇的PM、電話 (有的話)、etc...
					<br>　- <b>保密</b>封測內容、相關資料
					<br>　- 風之翎 及 v2Alliance 保留一切更改規則的權利 Orz
					<br><b>註冊格式</b>:
					<br>　- 用我供應的用戶名稱開頭
					<br>　　 - 分身於該用戶名稱後加上數字
					<br>　　 - 例: 我供應的用戶名稱 -> gary
					<br>　　　　- 主帳戶: gary
					<br>　　　　- 分身: gary1, gary2, gary3 ... (大細階有自主權)
					<br>　　 - 不明個體被發現會被<b>刪除</b>
					<br>　　 - 遊戲內的名稱<B>沒有限制</B>
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.4β Close Test Version</b>
					<br> - 部份武器需求能力值及特效更正
					<br> - 倉庫系統擴充
					<br>　 - 格納庫
					<br>　　 - 贈送機體系統
					<br> 　- 武器庫系統
					<br>　　 - 置放合成系統(不包括原料化)
					<br> - 套裝機體系統
					<Br>　 - 遊戲內稱「組織秘密研究所」
					<br>　 - 部份機體將不能再直接購買
					<Br>　 - 改為需要「領地」才能購買
					<br>　　 - 需要達到「領地數目」、「軍力」的要求
					<br>　　 - 套裝機體一般會附送「常規裝備」, 有的是缺點, 有的是優點...
					<br> - 實裝「副主席」
					<br>　 - 如果「主席」是王, 那麼「副主席」就是相了
					<br>　 - 沒有的權力: 宣戰, 更改組織設定, 解雇主席、退位給主席等
					<br> - Debug
					<Br>　 - 不能佔地Bug: 從扣敵人軍力至零的途徑, 不能佔領領地的 Bug
					<hr>這個要置頂 : "<a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>" 很有用
					<br>遲到了= =... 趕不及, 抱歉...
					<br>沒想到套機系統會那麼消耗時間(尤其那 GUI)...
					<br>封測正式開始, 遲些會設定「偽．NPC」供大家練功...
					<br>努力~
					<br>風之翎 @ 2008年12月27日 AM 1:28
				</td>
			</tr>
			<!-- 第四十則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年12月19日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Debug! 今天 De 了一隻 Bug
					<br>原來之前沒有領地的組織是真的不可以宣戰的！ XD
					<br>這個 Bug 已被 De 了... ||Orz...
					<br>居然忘了這一點呢 = =" 沒領地不能進攻, 那哪來有領地的組織 XD
					<br>另外, 亦順便 De 了某區域沒人就不能攻擊該區要塞的 Bug...
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.4α Build #3</b>
					<br> - 除去沒有領地就不能宣戰的 Bug
					<br>　 - 國戰系統: 加入了「起義」子系統
					<br>　　 - 沒有領地的組織可以透過「起義」宣戰
					<br>　　 - 軍力是即時採購的, 數量由組織人員數目決定, 最多為每日投資上限的兩倍
					<br> - 除去沒有人在某區域沒人就不能攻擊該區要塞的 Bug
					<hr>
					這個要置頂 : "<a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>" 很有用
					<br>快開始封測了~快了快了~~
					<br>ps. 我好像還在 Examination Period = =|| 真那個...
					<br>風之翎 @ 2008年12月19日 PM 4:05
				</td>
			</tr>
			<!-- 第三十九則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年11月29日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>哦哦...
					<br>不知不覺, 這版本的 php-eb 大致上已經完成了,
					<br>這兩、三天亦把未完成而又必須要完成的完成了(繞口令)
					<br>把那個叫做「需要值」的系統引入並實裝後...
					<br>php-eb 的配點需要似乎變了很~~~ 多呢 @_@" ...
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.4α Build #2</b>
					<br> - SP每點需要成長點數由 2點, 加到 5點
					<br> - 更正「需求值」優先程度不及大部份特殊效果的邏輯問題(也就是說, 原本沒有效果 = =)
					<br> - 所改玩家經驗值公式 (狀態值不變)
					<br>	 - 公式:
					<br>　　　 - 基本經驗 = 敵機師等級<suf>2</suf> + 已軍階值 * 0.01 + 敵軍階值 * 0.02 ; 軍階值的範圍 : 0 至 100,000
					<br>　　　 - 攻擊所得經驗 = 基本經驗 * 敵方扣血的比例; 敵方扣血的比例是...
					<br>　　　　　　　 傷害值 / 血量上限, 如剩餘血量不達傷害值, 則 傷害值 = 剩餘血量
					<br>　　　 - 結算所得經驗 = 攻擊所得經驗 * 1 + (已名聲 / 2000) + 10; 即是每點名聲 +0.05% 經驗
					<br>　　 - 攻擊等級比自己少 35 級的, 「攻擊所得經驗」 減半, 超過 50 級, 再減半 (即剩餘原來的 1/4)
					<br>　　 - 最後一擊沒有經驗加成(反而因為傷害值 = 剩餘血量而經驗會比較少), 但有勝利績分 (以前沒有用, 但現在有)
					<br>　　 - 單方面被擊敗, 攻擊所得經驗 * 0.7
					<br>　　 - 雙方同歸於盡, 攻擊所得經驗 * 0.8 (因為活著才是戰爭啊！！)
					<br> - 為百多把武器加入需求值,
					<br>　 - 配點時要好好考慮用哪一把武器啊...
					<br>　　 - 這個 : "<a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>" 很有用
					<hr>封測... 因考慮到11月尾和12頭(或至12月中)是學生們的考試期...
					<br>所以... 順移至12月中至12月尾... (啥!? 還有一個月!!!???)
					<br>不過, 這好像是首次有這麼「確定」的封測日期吧?
					<br>封測版本應該會是「php-eb v0.4β, Build Dev. Version, Official Closed Test Version」
					<br>稍後再會公佈詳情...
					<br>風之翎 @ 2008年11月29日 PM 2:00
				</td>
			</tr>
			<!-- 第三十八則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年11月25日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>你沒看錯...
					<br>這是更新 = =||
					<br>三個月後的更新...
					<br>三個月又三個月... 三個月之後又再三個月... Orz...
					<br>說要 9月1日 前封測, 到現在還沒呢= ="
					<br>新的生活比想像中來得忙碌...
					<br>小覷了... 小覷了 =__=||
					<br>呃...
					<br>還是有新的更新呢...
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.4α</b> (版本不變)
					<br> - 把等級上限提升至 150 級
					<br> - 素質上限也提升至 150
					<br> - 現在可以用 成長點數 換 SP 上限了
					<br> - 經驗公式有所更變
					<br>　 - 把 頭100級 的經驗總和, 由原先的 1.1億 下降至 1億
					<br>　　 - 現在 99級 升 100級 需求經驗: 3,942,611; 比起原先的 1千萬 少很多, 之前 90級 也要用 400萬 了...
					<br>　　 - 但中途難升了...
					<br>　　　　 - 如:
					<br>　　　　　 - 80級由 182萬 上升至 200萬 (90級在新公式下需要比較少經驗)
					<br>　　　　　 - 70級由 95萬 上升至 140萬
					<br>　　　　　 - 60級由 24.8萬 大幅上升至 88.5萬
					<br>　　　　　 - 30級的所需經驗及總和, 都差不多是舊公式下的47級
					<br>　 - 不過增長慢了很多, 希望有助提升早期武器的重要性
					<br>　 - 頭數級不再是一打即升了 = ="
					<br>　 - 經驗需求分佈變得比較平均了
					<br>　 - 150級經驗總和為 506,508,776, 足夠由1級升到100級 5次 (但成長點數只是1倍)
					<br>　 - 125級經驗總和為 252,148,910, 足夠由1級升到100級 2.5次
					<br>　 - 新經驗表: <a href="http://vsqa.dai-ngai.net/php-eb/prog/gen_info.php?action=cal" style="font-size: 10pt;text-decoration: none;color: ForestGreen">http://vsqa.dai-ngai.net/php-eb/prog/gen_info.php?action=cal</a>
					<br>　 - 舊經驗表: <a href="http://vsqa.dai-ngai.net/php-eb/prog_legacy/gen_info.php?action=cal" style="font-size: 10pt;text-decoration: none;color: ForestGreen">http://vsqa.dai-ngai.net/php-eb/prog_legacy/gen_info.php?action=cal</a>
					<br>
					<br><a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>
					<br>　 - 也有更新, 看看那裡的日誌吧...
					<hr>幾時封測?
					<Br>我很想是今個星期六、日...
					<br>但不知道時間能否允許呢...
					<br>希望下次寫日誌會是今個月的 >_<" (也就是本星期內).... 
					<br>風之翎 @ 2008年11月26日 AM 12:09
				</td>
			</tr>
			<!-- 第三十七則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年08月25日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>今天... 終於把「新．戰鬥系統」完完全全的寫好了 (泣)
					<br>好像用了三個月吧?
					<br>很誇張呢...
					<br>回想以前也只是一個大假期就把全部東西寫好...
					<br>現在的工作效率可算比往日更低-＝　＝||
					<br>不過, 完成了就是完成了...
					<br>php-eb 新版本已漸步入封測階段...
					<br>還欠什麼? 就是那些修訂版資料啊...
					<br>要塞初始能力, 要塞專屬機體, 新機體, 武器能力及特效修訂...
					<br>還有那個叫情報的系統= =||
					<br>這些不是系統更新, 卻不缺少...
					<br>希望一切順利吧~
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.4α</b>
					<br>- 戰鬥系統
					<br>　 - 完成實裝「軍力系統」
					<br>　 - Debug: 續戰時不會修理敵人的Bug
					<br>- 國戰系統
					<br>　 - 完成實裝「新國戰系統」及「軍力系統」
					<br>　 - 系統已完善 - 從宣戰至佔領到停戰
					<br>　 - 未回複修理工廠「戰爭期間停止服務」的設定
					<br>- 即時聊天系統
					<br>　 - 這是臨時加入的系統
					<br>　 - 現有聊天系統的擴充
					<br> 　- 提供「公開頻道」的即時聊天
					<br>　　 - 還需微調更新率和被動更新條件 (現在只限計時自動更新)
					<br>- 共九個檔案更新了: cfu.php, chat.php, city.php, gmscrn_base.php, gmscrn_right_menu.php,
					<br>　　　　　　　　　　organization.php, battle-2.php, battle.php, battle-filter.php
					<br>　　　　　　　　　　(index.php 為日誌, 第十個檔案)
					<hr>今天的更新都很有代表性, 也象徵 v0.3x 版的終結、 v0.4 版的來臨...
					<br>話說... 照以往版本命名方式, 這個新版本應該是「v0.40」才對... (部份人可能會叫這做4.0版XD)
					<br>把後面的「0」省略去, 算是向停留了很久的三個 v0.3x 版本致敬吧?
					<br>下一個版本, 可能直接命名為「v0.50」或者... 「最終版」 php-eb Ultimate Edition v1.0
					<br>好, 到此為止~ 封測會另行通知... 大慨九月一日以前會吧?
					<br>風之翎 @ 2008年08月26日 AM 2:49
				</td>
			</tr>
			<!-- 第三十六則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年08月24日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>今天進軍戰鬥系統...
					<br>很複雜, 囧...
					<br>效果算是不錯吧,
					<br>但發現很多Bug...
					<br>應該未來一兩天內能完成了...
					<br>有意者準備封測吧Orz...
					<br>不過好像快回到開學季節了...
					<hr>更新日誌:
					<br>php-eb v0.39α
					<br>- 戰鬥系統 
					<br>　 - 實裝「軍力系統」
					<br>　　 - 基本上已完成, 軍力會扣了
					<br>　　 - 但攻擊要塞和佔領、及判定誰成誰敗還沒搞好
					<br>　　 - 沒怎樣測試過, 很多 Bug 的樣子
					<br>- cv-fi.inc.php
					<br>　 - 加入「對比色」Function, 現在部份地方會用對比色襯托...
					<br>- sfo.inc.php
					<br>　 - 搜索 MS 資料時, 會連 Price 一拼搜尋
					<br>　　 - 這是為了軍力系統...
					<br>- gmscrn_base.php
					<br>　 - 現在會顯示己方「現軍力」了
					<hr>不知明天能否完成呢~?
					<br>ps. 今天身體繼續不適 ㄒ_ㄒ
					<br>風之翎 @ PM 8:05
				</td>
			</tr>
			<!-- 第三十五則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年08月23日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>呃... 今天有點不適, 不能做太多了>_<||
					<br>De 了 Bug... 也只有這麼多 ㄒ_ㄒ
					<hr>更新日誌:
					<br>php-eb v0.39α
					<br>- CFU
					<br>　- Debug + 修改: PM 12:xx 錯誤顯示為 上午 12:xx
					<br>　- 現在 PM 12:xx 會寫成 中午 12:xx; AM 12:00 則變成 零晨 12:00
					<br>- battle-filter.php
					<br>　- Debug: 組織錯誤顯示的Bug
					<hr>唯有... 晚點/明天繼續吧...
					<br>風之翎 @ PM 1:23
				</td>
			</tr>
			<!-- 第三十四則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年08月22日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>又是 "同一日" 有 "兩則" 日誌了...
					<br>今天算是更新得很瘋狂, 不竟快達到目標時, 會比較瘋狂吧 XD
					<br>這是新的日誌:
					<hr>更新日誌:
					<br>php-eb v0.39α
					<br>- 「軍力系統」
					<br>　 - 調動軍力 ~ 修正
					<br>　　 - 現在兩個不同的組織, 對同一地點宣戰, 該區域領主可以分別"回應"了
					<br>　　 - 歷史會有紀錄了
					<br>- 宣戰
					<br>　- 再改善了歷史用詞和顯示方式
					<br>- 「戰鬥系統」
					<br>　- 現在會正確顯示敵人了
					<br>　- 「軍力系統」未完全實裝
					<hr>終點在望囉~
					<br>風之翎 @ 23日 AM 2:19
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>九號風球~ 打到正吧~打正吧！
					<br>來個十號風吧~~XD
					<br>今天打風, 不知何解, 網絡變得很慢...
					<br>所以提早收工...
					<br>不過也完成了「委派守衛」的系統了
					<br>現在, 有軍力、又有守衛, 萬事俱備, 只欠東風~
					<br>來迎接 v0.40Alpha 吧~
					<hr>更新日誌:
					<br>php-eb v0.39α
					<br>- 「守衛系統」
					<br>　 - 「新國戰系統」的一部份
					<br>　 - 現在可以委派守衛了
					<br>　 - 每個區域(子區域)只能配置四個守衛
					<br>　　 - 守衛不會損耗守方軍力(或者會改為扣少點)
					<hr>守衛配置的系統其實未完整想好, 或許會改為每天只能換一次,
					<br>跟投資兵力一起計,
					<br>不扣軍力亦顯得有點「屈機」,
					<br>有待研究研究~
					<br>風之翎 @ PM 2:43 ~ 九號熱帶氣旋警告信號現正生效。
				</td>
			</tr>
			<!-- 第三十三則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年08月21日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>怎麼同一日有 "兩則" 日誌的 XD
					<br>這是創舉 (拍照
					<br>好, 不鬧了 XD
					<br>四點鐘左右又回來繼續...
					<br>已經把「軍力系統」中, 攻守兩方調派軍力的系統寫好了~~
					<br>這是新的日誌:
					<hr>更新日誌:
					<br>php-eb v0.39α
					<br>- 「軍力系統」
					<br>　 - 現在攻守兩方都可以調動軍力了
					<br>　 - 調動軍力或購買軍力時, 數量設定為「」(空白) 或 0 時, 
					<br>　　　 不會用去調動或購買的機會了
					<br>- 宣戰
					<br>　 - 歷史上會把攻方調派的軍力及行動代號顯示
					<br>　　 - 稍為改善了用詞和顯示方式
					<br>- 出擊通知書
					<br>　 - 現在防守方也有「出擊通知書」了
					<br>　 - 改變了用詞, 以配合「軍力系統」
					<hr>終點在望囉~
					<br>風之翎 @ PM 10:11
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>新的宣戰系統已經寫好了, 但應戰、協戰、佔領、攻防還沒...
					<br>要好好加油了@_@
					<hr>更新日誌:
					<br>php-eb v0.39α
					<br>- 「軍力系統」
					<br>　 - 現在宣戰時可以調動軍力了！
					<br>- 宣戰
					<br>　 - 歷史上會把攻方調派的軍力及行動代號顯示
					<hr>晚點可能會繼續~
					<br>風之翎 @ PM 2:08
				</td>
			</tr>
			<!-- 第三十二則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年08月20日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>昨天從 O-Camp 回來, 很累很累, 亦很痛 >_<....
					<br>不過今天還是繼續寫~
					<br>可是進度到目前這刻為止, 不算很多呢 @_@
					<hr>更新日誌:
					<br>php-eb v0.39α
					<br>- 「軍力系統」
					<br>　 - 增強軍力的 GUI 及 系統 都完成了
					<hr>現在只差調動軍力, 和「軍力系統」的主菜...
					<br>風之翎 @ PM 3:03
				</td>
			</tr>
			<!-- 第三十一則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年08月15日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>今天... 進度緩慢... 昨天則去了 Pre-Camp 沒空寫 XD ... <br>未來數天也應該沒時間的 ||Orz...
					<hr>更新日誌:
					<br>php-eb v0.39α
					<br>- 「軍力系統」
					<br>　 - 增強(即購買)軍力的 GUI, 大致上完成了
					<hr>今個星期完成到的機會不大 ＝　＝|||
					<br>那麼... 下次見了 ||Orz
					<br>風之翎 @ PM 10:25
				</td>
			</tr>
			<!-- 第三十則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年08月13日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>今天的進度不算很好, 但仍可以接受, 這幾天都不是有很多空閒時間...
					<br>「新．戰鬥系統」, 其實是引入「軍力系統」的「戰鬥系統」...
					<br>把戰鬥系統複雜化了一點點, 也不再像之前一樣, 那麼單純XD
					<hr>更新日誌:
					<br>php-eb v0.39α
					<br>- Debug
					<br>　 - 昨天不完整地 De 不到的 bug
					<br>- Data table 的更新
					<br>　 - area_map
					<br>　　 - 加入 tickets (紀錄區域的軍力)
					<br>　　 - 改變 development 的用途, 將會用來記錄上次投資軍力的時間
					<br>- 完整定義軍力系統
					<br>　 - Area 附屬
					<br>　　 - 最多 50000, 最少 1
					<br>　　 - 需要「調動」的
					<br>　　 - 需要投資的, 日最高額: 5000點, 每點價錢: $1,000
					<br>　　 - 如之前所說, 有複合的計算, 大約最多扣 100, 計算範圍: 機體、武器、機師
					<hr>希望今個星期完成到~^_^
					<br>下次見~
					<br>風之翎 @ PM 5:44
				</td>
			</tr>
			<!-- 第二十九則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年08月12日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>哈... 距離上一次日誌已經是兩個星期了XD
					<br>這陣子都很忙 XD
					<br>不過, 漸漸回到控制範圍內了
					<br>今日, 正正式式開始動工做這個叫「新．戰鬥系統」的東西
					<br>做了一些準備功夫和建立了 Datatable...
					<br>今天也很忙 XD
					<br>下次(明天?)繼續~
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.39α</b>
					<br>- Debug
					<br>　 - organization.php 一些小 Bug
					<br>- 建立 data table: user_war
					<br>　 - 儲存戰爭的資料
					<br>- 其他 Data table 的更新
					<br>　 - user_organization
					<br>　　 - 刪去 opttime, optstart, optmission, optmissionb, optmissionc
					<br>　 - area_map
					<br>　　 - 加入 defenders (紀錄誰人負責防禦要塞)
					<br>- organization.php
					<br>　 - 新系統 Migration 的準備功作
					<br>　　 - 重新定義 Index: optmissioni
					<Br>　　 - 使用 t_start 和 t_end 取代本來的 opttime 和 optstart (明確清楚很多)
					<hr>戰爭軍力還未定義, 大慨下次就可以定義到的了~
					<br>風之翎 @ PM 6:08
				</td>
			</tr>
			<!-- 第二十八則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月29日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>比想像中完成得早... 正在懷疑這是不是大更新= =||...
					<br>現在地圖擴充了, 由9區變36區, 大了4倍...
					<br>其實... 世界並沒有大了, 只是要塞多了...
					<br>現在每一區也分為「E、S、W、N」(東南西北)四分區, 每分區也有獨立要塞,
					<br>大區與大區之間可以如往常移動, 而且在同一大區內可以攻擊對方(不必處於同一小區內)
					<br>基本上只是多了要塞啦...
					<br>移動的畫面也漂亮了一點點...
					<br>之後會把每分區要塞的設定完整地改改(現在是每分區要塞也是一樣的)
					<br>可是擴充之後... 系統上的自由度會下降呢 //Orz
					<hr>更新日誌:
					<br>php-eb v0.38α
					<br>- Debug
					<br>　 - 自訂戰鬥列表, 沒選「顯示MS」一項時, 會很可怕地列出極多重覆對手的Bug
					<br>- 地圖擴充
					<Br>　 - 現有有更多的要塞可以佔領了
					<br>　 - 以分區的形式擴充
					<br>　　 - 整體上, 區與區之間移動速度不變
					<br>　　 - 能看見處於同大區的對手
					<br>　　 - 只能看見分區所屬的要塞
					<br>　 - 稍為美化了「移動」系統...
					<hr>接下來的「真正的」大更新... 新國戰系統...
					<br>計劃書上是寫得很漂亮沒錯, 但實際會否很好仍是一個迷 @_@||
					<br>風之翎 @ PM 2:31
				</td>
			</tr>
			<!-- 第二十七則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月28日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>昨天去了書展, 暫停一天...
					<br>今天也沒有什麼大更新, 主要都是De一些小bug...
					<br>還有準備接下來的兩個大更新...
					<br>現在的完成度大約有50%-60%吧...
					<hr>更新日誌:
					<br>php-eb v0.38α
					<br>- Debug
					<br>　 - gmscrn_base.php
					<br>　　 - 去除機師加成會包括機體加成的錯誤顯示
					<br>　　 - 現在會顯示爆Seed的能力加成量了
					<br>　 - gen_info.php 和 information.php
					<br>　　 - 設定部份Variable的原始值...
					<BR>　 - equip.php
					<br>　　 - 裝備專用化改造了的輔助裝備時, 會出現「&lt;sub&gt;&amp;copy;&lt;/sub&gt;」字樣
					<hr>大家有沒有發現... 有狀態的的輔助裝備也能夠專用化改造呢XD
					<br>我也沒發覺, 呵呵~
					<br>風之翎 @ PM 1:50
				</td>
			</tr>
			<!-- 第二十六則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月26日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>現在是AM 11:36...
					<br>來得比較早的日誌XD
					<br>今早主要是 Debug...
					<br>更主要的是 De 新「自動維修」系統的Bug...
					<br>而且全部檔案也用了新「自動維修」系統...
					<br>計算亦變得比較精確...
					<br>進度理想... 可惜晚了一天Orz...
					<br>資源消耗則沒什麼改變...
					<hr>更新日誌:
					<br>php-eb v0.38α
					<br>- Debug
					<br>　 - 新「自動維修」系統除錯
					<br>　　 - 現在「自動維修」和自動更新更加配合了
					<br>- 全面採用新「自動維修」系統, repairplayer-f.inc.php
					<hr>不排除晚點會繼續寫...
					<br>風之翎 @ AM 11:40
				</td>
			</tr>
			<!-- 第二十五則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月25日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>今天沒前幾天的那麼順利了...
					<br>優化自動維修的結果不太理想
					<br>甚至變得更消耗資源...
					<br>不過現在的運算公式大體上可能可以節省資源...
					<br>之前的問題好像也解決了一點點...
					<br>戰鬥列表中, 選戰法那裡也採用類似續戰系統的那種方式...
					<br>果然, 要優化自動維修一點也不容易 XD
					<hr>更新日誌:
					<br>php-eb v0.38α
					<br>- 優化「自動維修」
					<br>　 - 我也不知如何說優化了什麼...
					<hr>唉... 風之翎 @ PM 9:08
				</td>
			</tr>
			<!-- 第二十四則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月24日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>今天, 主要都是在做昨天提及過的...
					<br>這個「幫 NT 加的一個有關狀態值的特殊能力」..
					<br>及「更新自訂列表」(即是「戰鬥列表過濾系統設定」的更新)...
					<br>還有作出一些列表優化... 不過效果亦不太明顯...
					<br>用自訂列表當然還是會快很多就是了...
					<br>如果有留意的話, 昨天的版本是 v0.37α, 而今天的則將會是 v0.38α...
					<br>進度整體來說只屬一般... 優化列表花了很多時間... 值不值得就... 不知道了@_@"
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.38α</b>
					<br>- 新增 NT Hyper 化效果
					<br>　 - 這是 NT 獨有的效果, 連強化人也沒有
					<br>　 - 效果名稱: 預感
					<br>　 - 發動條件:
					<br>　　 - NT Hyper 化後(70級後自動發動)
					<br>　　 - 輔助裝備狀態值達 +25%
					<br>　 - 發動方式: 手體啟動(如進入SEED Mode和開Exam System那樣)
					<br>　 - 效果:
					<br>　　 - 無效化一次致命性的攻擊的傷害 (仍然會被判定為被擊中)
					<br>　　　 - 但輔助裝備狀態值會下降 25%
					<br>　 - 風之翎的評語: 很強的效果= =" 攻命型很著數呢... 但代價也很大...
					<br>- 戰鬥列表過濾系統設定
					<br>　 - 自訂列表
					<br>　　 - 採用新架構, 並加以優化(用上了之前在預設列表用到的技術)
					<Br>　 - 整體上的優化
					<br>　 - 不再使用「battle-cfilter.php」及「battle-dfilter.php」
					<br>　　 - 改為使用 include 方式, 局部 include... 也就是說, 這兩個"系統"終於統一了
					<br>　　 - 新增檔案:
					<br>　　　 - battle-filter.php
					<br>　　　　 - 新的「戰鬥列表」系統核心檔案
					<br>　　　 - 6個新 Includes, 全部屬於 Battle Filter 的分檔案...
					<br>　　　　 - btl-fp1-c.php 及 btl-fp1-d.php : 負責 SQL 指令及辦行
					<br>　　　　 - btl-fp2-c.php 及 btl-fp2-d.php : 列表內容的標題
					<br>　　　　 - btl-fp3-c.php 及 btl-fp3-d.php : 列出對手用的 Function
					<hr>今天到此為止... 明天應該會賞試再次優化一下「自動回HP、EN、SP」的 "AutoRepairing' 系統
					<br>不一定成功的, 但似乎有優化的必要... 現在實在太多問題了...
					<br>風之翎 @ PM 7:23
				</td>
			</tr>
			<!-- 第二十三則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月23日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>好, 今天把「續戰系統」寫完了！
					<br>現在利用新GUI和「續戰系統」, 可以達到「換武器後繼續打」的效果, 當然也不少得自動更新!!
					<br>可是, 發現 php-eb 的一些系統上的限制, 有時明明夠 EN/SP 卻回不了、打不到...
					<br>這可能是限制呢...
					<br>不過... 「續戰系統」似乎也挺方便的XD
					<br>至於「幫 NT 加的一個有關狀態值的特殊能力」, 這個還沒寫好
					<br>自訂列表也還沒更新, 嗯, 就是這麼一回事(自言自語中)
					<br>題外: (?)
					<br>昨晚22日 PM 11:15 時曾打開了 register.php, 然後把「Register - 註冊」的 Button 移了位...
					<br>未移位之前... 用Vista/IE7好像會因位置問題而看不到「Register - 註冊」這按鈕呢...
					<hr>更新日誌:
					<br><b style="color: ForestGreen;font-size: 12pt">php-eb v0.37α</b>
					<br>- 續戰系統
					<br>　 - 新增 Include 檔案: btl-continual-sys.inc.php
					<br>　 - 現在可以按「追擊目標」繼續戰鬥了
					<br>　　 - 不必按多次戰鬥打同一目標
					<br>　　 - 能配合「裝備狀態」的直接裝備功能, 換武器或輔助戰鬥
					<hr>沒錯, 今天的日誌就是這麼短... Orz...
					<br>風之翎 @ PM 5:08
					
				</td>
			</tr>
			<!-- 第二十二則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月22日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>囧...
					<br>該死的和記... 昨晚給我平均一分鐘內斷三次線... 
					<br>沒辦法今天只能改用 1.5Mbps 的電聯(後備用)寬頻...
					<br>但 php-eb 今天的進度亦還算是不錯...
					<br>武器狀態值相關的東西, 大致上昨天已經完成了...
					<br>沒錯, 裝備狀態值就是這麼一回事...
					<br>至於今天... 是準備改善戰鬥系統...
					<br>不過, 所謂的改善並不是優化系統、更改公式,
					<br>而是為了「方便玩家」而做的更新...
					<br>主要也是大量地、濫用「自動更新」系統...
					<br>不過在濫用的同時, 也發覺 php-eb 系統結構上的不足...
					<br>沒辦法, 唯有盡量改改吧...
					<br>主要更新檔案: equip.php, gmscrn_base.php
					<br>次要更新檔案: battle-2.php, cfu.php, battle-cfilter.php(只加了不可使用限制), tacticslearn.php
					<hr>更新日誌:
					<br>php-eb v0.36α
					<br>- 主畫面裝備系統
					<br>　 - 現在可以直接在「裝備狀態」的視窗裝備武器及輔助了
					<br>　 - 使用了「自動更新」系統, 不必按返回或重新整理
					<br>- 裝備武器及輔助裝備系統
					<br>　 - 現在裝備武器/輔助時會「自動更新」了
					<br>　　 - 購買新武器和裝備沒有此效果
					<br>　　 - 升級武器也沒有
					<br>- 機師狀態的顯示
					<br>　- Seed Mode 與 EXAM System Activated
					<br>　　 - 現在這兩個 Hyper化 狀態會「自動更新」了
					<br>　- 基本的4項素質加成, 現在不包括機體加成了
					<br>　　 *(在新戰鬥公式下, 機體和機師本來就是分開計算的)
					<br>　- 素質值: 不再是 999, 而是能力總和
					<br>- tacticslearn.php
					<br>　- 修正多餘「0」的問題...
					<hr>看下去更新好像只有少少, 卻極花時間呢...
					<br>相信明天應該會做好續戰系統... 還有幫 NT 加的一個有關狀態值的特殊能力...
					<br>風之翎 @ PM 8:22; PM 8:46 加按 tacticslearn.php
				</td>
			</tr>
			<!-- 第二十一則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月21日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>今天進度不錯, 寫了很多東西...
					<br>主要都是特效的修改~ 狀態值的「主要」作用...
					<br>而系統上則沒有太大更動...
					<hr>更新日誌:
					<br>php-eb v0.36α
					<br>特效的更新:
					<br>機體損壞
					<br>　- 基本效果
					<br>　　- 發動條件
					<br>　　　 - 主武器專屬特效
					<br>　　　 - 主武器狀態值 > ±0%
					<br>　　　 - 擊中敵人(命中率 >0%)
					<br>　　- 效果
					<br>　　　 - 以 15% 機會損耗敵人餘下的 50% EN。
					<br>　　　 - 以較高機會, 損耗敵人武器或裝備狀態值。
					<br>　+ 附加效果
					<br>　　+ 發動條件
					<br>　　　 - 主武器狀態值 > +100%
					<br>　　+ 效果
					<br>　　　 - 以更高機會, 損耗敵人武器或裝備狀態值。
					<br>戰鬥不能
					<br>　- 發動條件: 主武器狀態值 > +10%, 此為主武器專屬特效
					<br>　- 持有此特殊效能的武器，擊中敵人後，以一定機會，使敵人即使敵人HP不是零，會需要進入修理狀態。
					<br>完全防禦
					<br>　- 發動條件: 主武器狀態值 > +10%, 此為主武器專屬特效
					<br>　- 使用此持有此特殊效能的武器時，除非受到極強攻擊，否則不會受到損傷。
					<br>自動修復
					<br>　- 條件: 輔助裝備及常規裝備狀態值 > +10%, 沒有「輔助裝備」及/或「常規裝備」則不受此限
					<br>　- 效果: 敵人的 戰鬥不能 效力無效化。
					<br>　
					<br>%計算的五個加速特效
					<br>　- 基本發動條件:
					<br>　  - 擁有此類特效的裝備, 狀態值 > +10%,+20%,+30%,+40%或+50%(視乎該特效等級而定)。
					<br>　- 效果: 達基本發動條件所需的狀態值後, 每 1% 狀態值增加 1% 完全回避率, 最高分別為: +10%,+20%,+30%,+40% 及 +50%
					<br>　
					<br>熔解
					<br>　- 效果: 減低敵方防禦力 10 點。
					<br>　- 條件: 主武器狀態值 > +10% 。
					<br>高熱能
					<br>　- 效果: 減低敵方防禦力 5 點。
					<br>　- 條件: 主武器狀態值 > +10% 。
					<br>貫穿
					<br>　- 效果: 對方完全防禦無效化。
					<br>　- 條件: 主武器狀態值 > +10% 。
					<br><br>------------- 新效果 ---------------<br>
					<br>需要素質(點數)
					<br>　- 機師未達到所需素質(含人種加成), 則無效化有此能力的裝備
					<br>　
					<br>需要狀態值(狀態值)
					<br>　- 未達到所需狀態值, 則無效化有此能力的裝備
				</td>
			</tr>
			<!-- 第二十則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月19日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>很遺憾... 昨天又沒有時間寫 XD...
					<br>要到今天才比較有空, 所以亦寫了好幾小時... (現在是 下午 6:30 左右)
					<br>今天的更新主要是 修理工廠 及 裝備狀態值的實裝...
					<br>實裝裝備狀態值比我想像中來得要複雜呢...
					<hr>更新日誌:
					<br>php-eb v0.36α
					<br>修理工廠:
					<br>　 - 「回復狀態值」的系統
					<Br>　　 - 現在可以修理裝備了
					<br>　　 - 用了「自動更新」, 不必按返回了
					<br>　 - 引入「自動更新」
					<br>　　 - 跟「回復狀態值」的系統一樣, 不必按返回, 亦可以按「繼續修理」(以前也有用過吧?)
					<br>　 - 「即時計算修理HP/EN」
					<br>　　 - 現在可以即時看到 % 回復 HP/EN 最新的價格
					<br>　　 - % 回復的系統現在會比較準確地判定了
					<br>兵器製造工場:
					<br>　 - 現在不能把低於 ±0% 狀態的裝備放入熔爐了
					<hr>接下來是實裝「裝備狀態值」的主要用途... 應該編寫上不會太麻煩的...
					<Br>不過還需要很多測試
				</td>
			</tr>
			<!-- 第十九則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月17日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>抱歉ˇ︵ˇ... 連日來也很忙碌... 今日也只能勉強的寫了一點點...
					<hr>更新日誌:
					<br>php-eb v0.36α
					<br>修理工廠:
					<br>　- 新增「回復狀態值」的介面
					<br>　　- 目前還沒寫好該系統
					<br>　　- 已定下初步回復價格: 每0.01%狀態值花費 = 500 * (武器等級 + 1)
					<hr>明天繼續吧... 那是有空的話...
				</td>
			</tr>
			<!-- 第十八則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月13日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>今日是星期日, 有相對地多的時間工作... 但事實也只有三、四小時而已... (這也是Copy的 XD, 偷懶主義!?)
					<br>主要也是「武器狀態值」的實裝...
					<br>還有 Debug...
					<hr>更新日誌:
					<br>php-eb v0.36α
					<br>- 戰鬥系統小更新
					<br>　 - 加強對「戰術」的安全性(防止使用未習得戰法)
					<br>　 - 優化有否習得戰術的邏輯
					<br>- 新增戰法: 精確攻擊
					<br>　 - 85Lv 以 1200萬 習得
					<br>　 - 功用:
					<br>　　 - SP消耗: 45點
					<br>　　 - 減 10點 機師 Attacking
					<br>　　 - 增 10點 機師 Targeting
					<br>　　 - 增 2點 機體 Targeting (Hit加成)
					<br>　　 - 「精確攻擊」特效
					<br>- 新增特效:「精確攻擊」
					<br>　 - 敵人的狀態值損耗比平常上升 5 倍
					<br>　 - 必定會損耗敵人的狀態值
				</td>
			</tr>
			<!-- 第十七則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月12日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>今日是星期六, 有相對地多的時間工作... 但事實也只有三、四小時而已...
					<br>主要也是「武器狀態值」的實裝...
					<br>還有 Debug...
					<hr>更新日誌:
					<br>php-eb v0.36α
					<br>- 繼續實裝「武器狀態值」
					<br>　- Debug
					<br>　　 - 去掉「複製Bug」 XD
					<br>　　 - 修正部份邏輯問題
					<br>　　 - 不會再有「有狀態值」的「無武器」武器 XD
					<br>　　　 - 主武器的被擊中率會特別高了
					<br>　　 - 達到原本預計上的條件時, 沒有發動扣狀態值的問題
					<br>　- 實裝其次要用途 (主要用途反而未實裝 XD)
					<br>　　 - 狀態值 > ±0% 時:
					<br>　　　 - EN 消耗減少最多 16.7% - 33.3% *(註1.)
					<br>　　　　 - 狀態值愈高, EN 消耗減少量愈高, 但會是隨機減少的
					<br>　　　　　 - +250% 時, 平均減少 25% 的 EN 消耗
					<br>　　 - 狀態值 < ±0% 時
					<br>　　　 - 攻擊力下降「狀態值」的 % (適用於主武器的狀態值)
					<br>　　　 - EN 消耗增加 「狀態值」的 % *(註1.)
					<br>(註1: 狀態值影響的 EN 消耗, 不會影響出擊所需要的 EN, 而只會影響實際扣除的 EN)
				</td>
			</tr>
			<!-- 第十六則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月11日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>現在是...7月12日 零晨 1:09 ...
					<br> - 繼續實裝「武器狀態值」
					<br>　 - 現階段能扣及增狀態值了...
					<br>　　　 - 主武器、輔助裝備和常規
					<Br>　　　 - 建立一些初期設定
					<br>　　　 - 好像運算上出了錯, 未有時間 Debug...
					<br>　　　　　- 而且還有好多 Bug XD
					<br> - Chat.php 及 sfo.class.php
					<br>　　 - Debug (Minor), 主要都是 Undefined 的 Variable...
				</td>
			</tr>
			<!-- 第十五則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月09日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>今天思考速度比較慢... 還有的是... 我其實只有兩三小時的時間...
					<br> - 繼續實裝「武器狀態值」
					<br>　 - 現階段能扣狀態值了 A_A
					<br>　　　 - 未完成的
					<hr>好... <br> 明天再繼續... XD (這是Copy & Paste...)
				</td>
			</tr>
			<!-- 第十四則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年07月08日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>大家好... 差不多兩個月沒見了 XD ...
					<br>這兩個月風之翎去了工作, 很忙沒時間改進...
					<br>加上又要放榜, 很多事要做 XD
					<br>到最近才能抽空出來改改, 今天算是正正式式復工吧？
					<br>其實昨天也有少少進度的... 但沒什麼用 XD
					<br>2008年07月07日
					<br> - 加入「alternate algorithm for battle_function.php」
					<br>　 - 也許會吃比較少資源, 但現階段無法測試也沒有實裝 XD
					<br>2008年07月08日
					<br> - 開始實裝「武器狀態值」
					<br>　 - 現階段只是把「武器經驗值」的名字改成「武器狀態值」
					<hr>好... <br> 明天繼續 XD
				</td>
			</tr>
			<!-- 第十三則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年05月13日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>現在也是 5月13日 15:11 ...
					<br>今天進度: 初步完成了戰鬥系統的更新, 新公式實裝~
					<br>有興趣可以玩玩...
					<br>但注意新公式和舊公式有很大分別...
					<br>這裡可以參考一下:
					<br>傷害 = 武器攻擊力 * ( 1 + ( ( 機體AT - 機體DE ) / 40 )) * ( 1 + ( 機師At - 機師De ) / 100 );
					<br>命中率 = 武器命中 * ( 1 + ( ( 機體TA - 機體RE ) / 40 )) * ( 0.8 + ( 機師Ta - 機師Re ) / 100 );
					<br>解釋:
					<br>兩者機體及機師攻擊=防禦時,
					<br>扣武器攻擊力
					<br>
					<br>兩者機體及機師命中=回避時,
					<br>命中率 = 80%
					<hr>更新日誌:
					<br>php-eb v0.36α
					<br>- 初步完成戰鬥系統的更新, 已採用新架構
					<br>- Debug: battle-2.php, battle_function.php
				</td>
			</tr>
			<!-- 第十二則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年05月12日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>現在也是 5月13日 2:23am ...
					<br>今天進度: 戰鬥系統大更動; 完成率 75% ... (不計算其他更新...)
					<br>比想像中多東西要寫...
					<br>battle-2.php 的檔案大少, 因邏輯上的問題, 減細了十多KB...
					<br>但還是未成品... 還沒Debug, 沒辦法執行...
					<hr>更新日誌:
					<br>php-eb v0.36α
					<br>- 新增 Include 檔
					<br>　- btl-mirrordam.legacy.php
					<br>　- btl-seed-ncs.inc.php
					<br>　　* 這兩個也是從 battle-2.php 中分割出來、而沒有太大用途的部份
					<br>- 移除「鏡」特效
					<br>　- 使用率 = 0, 也因效果不太實際, 不會用, 因此移除了...
					<br>- battle-2.php 及 battle_function.php
					<br>　- 套用新公式及新架構
					<br>　- 改變部份運算的邏輯, 以減少 檔案Size 及 資料消耗
					<br>　- 更新特殊效果(參考08年05月10日的更新)
					<br>　　- 完美防禦改為減免10000點傷害, 當然依舊會被貫穿...
					<hr>呃... 現在已是 5月13日 2:34am ... >_<"
				</td>
			</tr>
			<!-- 第十一則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年05月11日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>今天主力優化系統, 優化系統也是配合新的版本~ (雖然現在已經05/12 12:24am...)
					<br>現在優化的速度, 似乎比 v0.20 Open 快上 4倍左右...
					<br>比起 v0.30 快上了兩倍...
					<br>果然還有優化的空間...
					<br>此外...
					<br>過了那麼久, php-eb 終於用上了 Objects ...
					<br>話說應該早就用了...
					<hr>更新日誌:
					<br>php-eb v0.36α
					<br>- 建立 includes directory
					<br>　　- 新增檔案
					<br>　　　- auc.inc.php (cfu.php分割出來)
					<br>　　　- autorepair-f.inc.php (cfu.php分割出來)
					<br>　　　- cv-fi.inc.php (cfu.php分割出來)
					<br>　　　- lf-fi.inc.php (cfu.php分割出來)
					<br>　　　- sc-fi.inc.php (cfu.php分割出來)
					<br>　　　- sfo.class.php (採用預先開發的Stat_Fetch_Object.php, 參考08年4月22日更新日誌)
					<br>　　　　- 更新和 Debug
					<br>　　　　- 加入 ProcessAllWeapon 的 Function, 能以單一 Query 處理身上所有裝備
					<br>- cfu.php 的分割
					<br>　　- 把大部份 functions 分割出來, 以減少資料傳送或運輸
					<br>　　- 現用途像連接終端, 如 EBS 的 ebs.cgi
					<br>- battle.php
					<br>　　- 套用 sfo.class.php 中的 「player_stat」 Object
					<br>　　- 把 battle.php 的「很難看」、「混亂」部份「清楚化」...
					<br>- battle-cfilter.php
					<br>　　- 基本上沒什麼變動, 是由於 battle.php 的架構已不同, 暫時不能使用
					<br>- battle-dfilter.php
					<br>　　- 今天最明顯的更新, 預設列表的優化
					<br>　　- 大大減省不必要 Query, 基本上大部份資料也一次Query完成
					<br>- battle-2.php
					<br>　　- 開始進入修改戰鬥系統的步驟
					<br>　　- 慢慢套用 sfo.class.php 的 object 及新架構
					<br>　　- 由於母親節關係, 改到一半便要告終...
				</td>
			</tr>
			<!-- 第十則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年05月10日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>
					<br>模擬計算器的功能及更新日誌內容:
					<br>- 加入戰法的支援
					<br>- 加入新版本 SEED Mode 及 EXAM System 支援
					<br>- 加入的戰法特效支援:
					<br>　 - 二連擊、三連擊 (*只限於戰法)
					<br>不會加入支援的戰法特效: (即另行通知前都不會加入)
					<br>　- 全彈發射, 反擊, 先制攻擊
					<br>- 更新以下特效效果:
					<br>　- 機體定點加速及加命中效果, 分別為: +2, +6, +10, +14
					<br>　- 機體定點加防禦效果, 分別為: +3, +6, +9, +12, +15
					<br>　- 高熱能及熔解效果, 分別為: -5 及 -10
					<br>　- 禁錮效果, 新效果為 -5, 不受其實特效影響
					<br>　- 舊有 % 減免傷害效果, 新效果為定點減少傷害, 分別為: 減 1000, 800, 600, 400 及 200
					<br>　- 舊有 % 加速特效效果大更動, 新效果:
					<br>　　- 以「一定機會」回避敵人攻擊
					<br>　　- 機會分別為: 10%, 20%, 30%, 40% 及 50%
					<br>　　* 實裝時會配合發動條件
					<br>　- 舊有 % 加命中特效效果小更動:
					<br>　　- 不會受敵人效果影響了
					<br>　- 取消網絡干擾及雷達干擾效果 (減將來會更新效果?)
					<br>- 在這裡加入更新日誌
					<br>模擬計算器的開發進入尾聲了~ 之後的更新會是對應實際情況的修正...
					<hr>此外, 已將今天的測試伺服器複製了, 並保存下來,
					<br>接下來會大幅更新測試伺服器, 資料應該會有大變能, 以及會洗Server...
					<br><a href="http://vsqa.dai-ngai.net/php-eb/prog_legacy/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">Legacy Server 入口</a>
					<hr>php-eb v0.36α w/DBV 7
					<br>- 更新人種修正
					<br>　- 現在6個人種的總修正也是45了
					<br>　- 每個人種也有不同修正重視, 各有其特點:
					<br>　　- Natural (一般) 　 　: 　<b><font color=grey>平均</font></b>型
					<br>　　- Enhanced (強化人): 　<b><font color=brown>防</font><font color=ForestGreen>命</font></b>型
					<br>　　- Extended (延伸人) : 　<b><font color=red>攻</font><font color=ForestGreen>命</font></b>型
					<br>　　- 念動力　　　　 　 : 　<b><font color=brown>防</font><font color=Blue>回</font></b>型
					<br>　　- New Type　　　　: 　<b><font color=Blue>回</font><font color=ForestGreen>命</font></b>型
					<br>　　- Coordinator　　　: 　<b><font color=red>攻</font><font color=Blue>回</font></b>型
					<br>- 更新特效(未實裝, 請參考模擬器的更新)
				</td>
			</tr>
			<!-- 第九則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年04月26日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>
					<br>模擬計算器的功能及更新日誌內容:
					<br>- 加入特效支援:
					<br>　 - 完全防禦, 貫穿
					<br>　 - 禁錮
					<br>　 - 加速, 超前, 閃避, 逃離
					<br>　 - 簡單推進, 強力推進, 最佳化推進, 高級推進, 極級推進
					<br>　 - 網絡干擾, 雷達干擾
					<br>　 - 校準, 瞄準, 集中, 預測
					<br>　 - 自動鎖定, 高級校準, 無誤校準, 多重鎖定, 完美鎖定
					<br>　 - 簡單防禦, 正常防禦, 強化防禦, 高級防禦, 最終防禦
					<br>　 - 格擋, 抗衡, 干涉, 堅壁, 空間相對位移
					<br>　 - 高熱能(熔解一段的新名稱), 熔解
					<br>- 基本上已完成, 可作戰鬥系統可行性參考用
				</td>
			</tr>
			<!-- 第八則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年04月24日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>
					<br>模擬計算器的功能及更新日誌內容:
					<br>- 加入特效支援:
					<br>　 - 興奮
					<br>　 - 底力 (包括念動力的底力)
					<br>- 現在會顯示部份計算有效的特效了
				</td>
			</tr>
			<!-- 第七則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年04月23日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>一考完試就不停寫了...
					<br>暫時有新東西完成了:
					<br><a href="http://vsqa.dai-ngai.net/php-eb/prog/ue_btl_calc.php" style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v2.0α</a>
					<br>這是傳說中的模擬計算器, 用來測試新公式的, 也就是說... php-eb 新版本的公式已經初步完成了！
					<br>想看看新公式如何, 可以進去看看~
					<br>模擬計算器的功能及更新日誌內容:
					<br>- v2.0α 版
					<br>　 - 開發自配點「php-eb 配點計算工具」 v1.1 及 v1.2 版
					<br>　　　 - 由於套用配點計算工具時, 誤以為 v1.1 是最新版, 所以主要用 v1.1 改造而成
					<br>　　　 - 已加入所有 v1.2 的公能, 及修正原本 v1.1 有的 Bug
					<br>　 - 自動套取武器、機體、人種加成資料
					<br>　 - 可以連敵方的資料一拼計算
					<br>　　 - 自動計算雙方預計攻擊力、命中率、最終傷害
					<br>未加入的功能:
					<br>　 - 還未設定任何特效, 會盡快加入
					<hr>可是 php-eb 主程式還沒有什麼更新, 即是連「真正」的戰鬥系統也還沒實裝,
					<br>還算是測試階段吧？
					<br>
					<br>還有一點~ <b>請所有來到這裡的封測人員注意!!</b>
					<br>php-eb Ultimate Edition 的所有內容也屬「機密」, <B>請勿</B>公開!!

				</td>
			</tr>
			<!-- 第六則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2008年04月22日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>距離上一次公告, 已經有9個月了 @_@"
					<BR>今天, 正式恢復 php-eb 開發~
					<br>目標版本: php-eb v1.0 Ultimate Edition :: AKA Phantasy Planes of Endless Battle
					<br>請多多留意本頁公告!!
					<br>現在版本: 仍然是 v0.35Alpha
					<hr>今天的進度:
					<br> - 作成 ue_btl_calc.php 及開發「Stat_Fetch_Object.php」Module
					<br>　 - ue_btl_calc.php
					<br>　　　 - php-eb 配點計算工具的 php 版本, 可作計算公式結果之用
					<br>　 - Stat_Fetch_Object.php
					<br>　　　 - 進入模組化的時代, 為戰鬥系統設定優化
					<br>　　　 - 包括: SetUser, FetchPlayer, ProcessWeapon, ProcessMS 四個 Function,
					<br>　　　　 取代舊有 cfu 中的Function
				</td>
			</tr>
			<!-- 第五則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2007年07月19日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>這是遲來的公告Orz...
					<br>封測伺服器，經已在過去數十天內無聲無色作出更新
					<br>現在的版本是 v0.35Alpha 的 Dev. Version 版本
					<br>現階段的進度, 只是換了GUI
					<br>進行遊戲時, 可能會發覺到有「Notice: Undefined ...」,
					<br>對, 這其實是編程時的錯漏, 應該回報的...
					<br>為什麼突然有那麼多? 其實一向也存在的... 只是略過了看不到@_@"
					<br>但數量太多, 能除多少就除多少吧...
				</td>
			</tr>
			<!-- 第四則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2007年03月10日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>這次封測, 隨著安裝工具和更新工具的出現,
					<br>宣告完成了！
					<br>v2Alliance誠意感謝每一位封測人員,
					<br>抽出您們寶貴的時間來進行封測！
					<br>日後也有可能有測試的XD~
					<br>也許到時再來幫忙一下吧~
					<br>測試伺服器會維持運作(留作紀念?)... 直到另外通知~
				</td>
			</tr>
			<!-- 第三則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2007年02月27日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>再次更新了~
					<br>修改/增加內容:
					<br>　- 情報加入Hypermode顯示、機體專用名稱顯示、加成顯示和常規裝備顯示
					<br>　- 格納庫加入拉下式選單, 供選擇要取出的機體, 作為Alternative Method
					<br>Debugging:
					<br>　- 交易內, 顯示專用名稱的Suffix變了Prefix錯誤
					<br>　- 使用 Filter 時, 會看到「隊長」職位和中立組織也有軍階的問題
					<hr>後記:
					<br>各位!
					<br>找Bug努力了ˇˇ
					<br>測平衝努力了ˇˇ"
					<br>因為(我)時日無多喇~
					<br>開學喇~
					<br>忙過不停喇~
					<br>如無意外, 這個周末,
					<br>正式的 php-eb v0.30 就「發行」了...
					<br>現在起只Debug不加新野了ˇˇ
					<br>加油加油~
					<br>Your effort is much appreciated!
					<br>我們感激您們的努力！
				</td>
			</tr>
			<!-- 第二則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2007年02月25日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>這是開封測伺服器第一次的正式「大型更新」！<br>多謝各位封測人員的努力！
					<br>已De了的Bug:
					<br>　- 十大富翁 顯示問題
					<br>　- 刪Account系統出現不能刪Account的問題
					<br>　- EXAM/SEED 異常的SP消耗 (會額外消耗3 SP)
					<br>　- 同時使用SEED Mode 和 EXAM Activated　Hyper化時會 SEED Mode 效果無效
					<br>　- 戰鬥時顯示的EN消耗只是武器和戰法
					<br>　- Chatroom 打過「@」或過長的字所產生的問題
					<hr>新增內容:
					<br>實裝 Super DRAGOON 及其合成法 (10級合成, 此為機密內容), 為CO/Extended專用武
					<br>實裝 EXAM System 合成法 (6級合成, 此為機密內容), 測試用的EXAM System不能再買了ˇˇ`
					<br>實裝 新高達尼姆合金 及合成法 (6級合成, 此為機密內容), 用途是增加專用化點數！
					<br>新增 勝利績分 兌換 新高達尼姆合金 系統 (特殊指令內), 兌換值預設 1:1000, 測服更改值: 1:100 (10倍化)
					<br>分開 勝利績分 和 勝利次數
				</td>
			</tr>
			<!-- 第一則 -->
			<tr>
				<td align=right width=30>日期:</td>
				<td >2007年02月22日</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>測試伺服器正式開啟！<br>新版本 php-eb 定名為 php-eb v0.30, 測試版本為 Alpha Version
					<br>php-eb 這個版本的安穩靠各位封測人員囉！
					<br>此外, 希望各位不要把「機密內容」公開 ^^, 當一個專業的封測人員!!
					<br>&nbsp;&nbsp;測試伺服器設定: 所得 經驗, 金錢 10倍化
					<br>&nbsp;&nbsp;測試期間: 約一至兩星期
					<hr width=75%>未實裝內容:<br> 真正的 EXAM System (輔助裝備, 現在暫時能用 500萬 元購買)<br> 機體圖片 (歡迎提供) <br> 數個高級武器, 當中含有 Super DRAGOON (此為機密內容)
					<br>數個武器裝備的能力調整, 包括 Bit, 浮游炮等 (此為機密內容)
				</td>
			</tr>
		</table>
	</td></tr>
</table>
</body>

</html>
<?php
exit;
?>