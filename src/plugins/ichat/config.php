<?php

$DBHost = 'localhost';			//資料庫設定, 必須跟 php-eb 一樣
$DBUser = 'phpeb_official';
$DBPass = 'ccgcky';
$DBName = 'phpeb_test';
$DBPrefix = 'vsqa_';

// iChat Settings
$iChatTable = 'phpeb_ichat';	//iChat 即時聊天的 table 名稱, 安裝前可以更改
$Welcomer = 'System';			//發出歡迎訊息的使用者名稱
$WelcomeMessage = 'Welcome';	//歡迎訊息
$MaxChatEntries = 2500;			//執行自動清除的條目數, 自動清除執行時, 會有一兩則訊息未能傳回

?>