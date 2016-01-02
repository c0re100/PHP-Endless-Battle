<?php

header('Content-Type: text/html; charset=utf-8');
$mode = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
include 'cfu.php';
AuthUser();
postHead('');
if ($mode == 'proc') {
    $sql_ugnrli = ('SELECT * FROM `'.$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE username='".$_SESSION['username']."'");
    $UsrGenrl_Qr = mysql_query($sql_ugnrli) or die('出錯, 原因:'.mysql_error().'，');
    $UsrGenrl = mysql_fetch_array($UsrGenrl_Qr);

    $sql_ugmi = ('SELECT * FROM `'.$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE username='".$UsrGenrl['username']."'");
    $PlGame_Qr = mysql_query($sql_ugmi) or die('出錯, 原因:'.mysql_error().'，');
    $PlGameVal = mysql_fetch_array($PlGame_Qr);
	if ($CFU_Time >= $_SESSION['timeauth'] + $TIME_OUT_TIME || $_SESSION['timeauth'] <= $CFU_Time - $TIME_OUT_TIME) {
        echo "<center>驗證機制！<br>請重新登入！<br><a href=\"index.php\" target='_top' style=\"text-decoration: none;color:red;\">回到首頁</a>";
		postFooter();
        exit;
    }

    $Pl_Settings_Query = ('SELECT `show_log_num`,`gen_img_dir`,`unit_img_dir`,`base_img_dir` FROM `'.$GLOBALS['DBPrefix']."phpeb_user_settings` WHERE username='".$UsrGenrl['username']."'");
    $Pl_Settings = mysql_fetch_array(mysql_query($Pl_Settings_Query));

    $onlineip = $_SERVER['REMOTE_ADDR'];
    $sql_iplog = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_general_info` SET lastip='$onlineip', lastlogin='$CFU_Time' WHERE username='".$_SESSION['username']."'");
    mysql_query($sql_iplog);

    if ($OLimit) {
        $Online_Time = time() - $Offline_Time;
        $OnlineSQL = ('SELECT count(lastlogin) FROM `'.$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `lastlogin` > '$Online_Time'");
        $OnlineSQL_Query = mysql_query($OnlineSQL);
        $OnlinePlNum = mysql_fetch_row($OnlineSQL_Query);
        if ($OnlinePlNum[0] >= $OLimit && $CFU_Time - $UsrGenrl['time2'] < $Offline_Time) {
            echo "<center><br><br>上線人數太多。<br>現上線人數: $OnlinePlNum[0]<br>上線人數上限: $OLimit<br><a href=\"index.php\" target='_top' style=\"text-decoration: none\">回到首頁</a><br><br>";
            postFooter();
            exit;
        }
    }

    if ($Pl_Settings['gen_img_dir']) {
        $General_Image_Dir = $Pl_Settings['gen_img_dir'];
    }
    if ($Pl_Settings['unit_img_dir']) {
        $Unit_Image_Dir = $Pl_Settings['unit_img_dir'];
    }
    if ($Pl_Settings['base_img_dir']) {
        $Base_Image_Dir = $Pl_Settings['base_img_dir'];
    }

    if ($UsrGenrl['msuit'] == 'nil') {
        $UsrGenrl['msuit'] = '0';
    }
    GetMsDetails("$UsrGenrl[msuit]", 'PlMs');
    $Pl_Type = GetChType($UsrGenrl['typech']);
    if ($UsrGenrl['msuit'] && ($CFU_Time - $UsrGenrl['time1']) >= 3) {
        $Pl_Repaired = AutoRepair("$UsrGenrl[username]");
        $PlGameVal['hp'] = $Pl_Repaired['hp'];
        $PlGameVal['en'] = $Pl_Repaired['en'];
        $PlGameVal['sp'] = $Pl_Repaired['sp'];
        $PlGameVal['status'] = $Pl_Repaired['status'];
    }
    switch ($PlGameVal['status']) {case 0: $StatusShow = '正常'; $StatusColor = '#00CD00';break; case 1: $StatusShow = '修理中'; $StatusColor = '#FF2200';break;}

    $ShowAt = $PlGameVal['attacking'] * 0.3;
    $ShowDe = $PlGameVal['defending'] * 0.3;
    $ShowRe = $PlGameVal['reacting'] * 0.3;
    $ShowTa = $PlGameVal['targeting'] * 0.3;

    $AtClr = colorConvert("$PlGameVal[attacking]");
    $DeClr = colorConvert("$PlGameVal[defending]");
    $ReClr = colorConvert("$PlGameVal[reacting]");
    $TaClr = colorConvert("$PlGameVal[targeting]");

    $NextStatPt_At = $PlGameVal['attacking'] + 1;
    $NextStatPt_De = $PlGameVal['defending'] + 1;
    $NextStatPt_Re = $PlGameVal['reacting'] + 1;
    $NextStatPt_Ta = $PlGameVal['targeting'] + 1;

    CalcStatReq('At', "$NextStatPt_At");
    $AtAdd = '';
    CalcStatReq('De', "$NextStatPt_De");
    $DeAdd = '';
    CalcStatReq('Re', "$NextStatPt_Re");
    $ReAdd = '';
    CalcStatReq('Ta', "$NextStatPt_Ta");
    $TaAdd = '';

    $Area = ReturnMap("$UsrGenrl[coordinates]");
    $AreaLandForm = ReturnMType($Area['Sys']['type']);

    $LandFormBg = ReturnMBg($Area['Sys']['type']);

    $AreaOrg = ReturnOrg($Area['User']['occupied']);
    $Pl_Org = ReturnOrg($PlGameVal['organization']);

    if ($UsrGenrl['fame'] >= 0) {
        $TypeFame = '名聲';
    } else {
        $TypeFame = '惡名';
    }
    $ShowFame = abs($UsrGenrl['fame']);
    unset($RightsTitle);
    if ($PlGameVal['rights'] == '1') {
        $RightsTitle = $RightsClass['Major'];
    } elseif ($PlGameVal['rights'] == '2') {
        $RightsTitle = $RightsClass['SMajor'];
    }

    $Pl_Rank = rankConvert($PlGameVal['rank']);

    $Otp_Area_Sql = ('SELECT `name`,`color`,`opttime`,`optstart` FROM `'.$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `optmissioni` = 'Atk=($UsrGenrl[coordinates])' AND `opttime` > '$CFU_Time' ORDER BY `optstart` ASC LIMIT 1");
    $Otp_Area_Q = mysql_query($Otp_Area_Sql) or die(mysql_error());
    $Otp_A_ITar = mysql_fetch_array($Otp_Area_Q);

    if ($Otp_A_ITar) {
        if ($Otp_A_ITar['optstart'] > $CFU_Time) {
            $TimeTSSec = $Otp_A_ITar['optstart'] - $CFU_Time;
            $TimetS['hours'] = floor($TimeTSSec / 3600);
            $TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours'] * 3600)) / 60);
            $TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours'] * 3600) - ($TimetS['minutes'] * 60));
            $Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒開始戰爭。";
        } else {
            $TimeTSSec = $Otp_A_ITar['opttime'] - $CFU_Time;
            $TimetS['hours'] = floor($TimeTSSec / 3600);
            $TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours'] * 3600)) / 60);
            $TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours'] * 3600) - ($TimetS['minutes'] * 60));
            $Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒戰爭宣告終了。";
        }
    }

    echo "<style type=\"text/css\">b {FILTER: glow(color: 0000ff,strength=1);height:1} body {background-image: url('$General_Image_Dir".$LandFormBg."1024.jpg')}</style>";

    echo '<br>';

    echo '<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" height="300px"><tr>';
    echo "<td width=\"80%\" height=\"20\" style=\"font-size: 14pt;\" align=center><font style=\"color: $UsrGenrl[color]; font-weight: Bold\">$PlGameVal[gamename]</font> <font style=\"color: $Pl_Org[color]\">($Pl_Org[name])</font>";
    if ($RightsTitle) {
        echo "<font style=\"color: yellow;font-weight: Bold;\">  $RightsTitle</font>";
    }
    if ($PlGameVal['organization']) {
        echo "  $Pl_Rank";
    }
	if($Pl_Org[id] != 0){
		echo "    國家宗旨: <font style=\"color: $Pl_Org[color]\">$Pl_Org[pose]</font>";
	}
    echo "    <font style=\"font-size: 10pt\">$TypeFame: $ShowFame    所在區域: $UsrGenrl[coordinates]    名稱: $AreaLandForm    統治國家: <font style=\"color: $AreaOrg[color]\">".$AreaOrg[name].'</font>';
    if ($Otp_TellTime) {
        echo " <font style=\"color: red\">[戰爭狀態]</font> $Otp_TellTime";
    }

    echo '</font></td>';

    echo '</tr><tr><td width="100%" height="100%">';
    echo '<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" height=100% width="100%">';
    echo '<tr>';
    echo '<td width="14%" valign=center>';
    echo '<img src="'.$Unit_Image_Dir."/$PlMs[image]\">";

    if ($PlGameVal['ms_custom']) {
        $Pl_CFix = explode('<!>', $PlGameVal['ms_custom']);
    } else {
        $Pl_CFix = array(0,0,0,0,0);
    }

    if ($Pl_CFix[0]) {
        $PlMs['msname'] = $Pl_CFix[0].'<sub>?</sub>';
    }

    echo "<br>$PlMs[msname]<br> 勝利積分/次數: $PlGameVal[v_points]/$PlGameVal[victory]<br>狀態: <b id=status_now style=\"color: $StatusColor\">$StatusShow</b></td>"
,'<td width="2%">　</td>'
,'<td width="21%" valign=top>　<div align="center">'
,'<center>'
,'<table cellpadding=0 cellspacing=0 border=0 style="font-size:14px; border-collapse:collapse" bordercolor="#111111">'
,'<tr>';
    echo '<form action=nil method=post name=addstat target=Beta>';
    echo "<input type=hidden value='none' name=actionb>";
    echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
    echo '</form>';
    echo '<script language="JavaScript">';
    echo 'function add_stat(type){';
    echo "        if (type == 'at'){";
    echo "        if ($UsrGenrl[growth] < $At_Stat_Req || $At_Stat_Req == '0' || $UsrGenrl[growth] == '0'){alert('你的成長點數不足夠！');return false}";
    echo "        if (confirm('你現在有 $UsrGenrl[growth] 成長點數。\\n要把攻擊技術加到 $NextStatPt_At 的話需要 $At_Stat_Req 點數。\\n確定嗎?') == true){";
    echo "        addstat.action='statsmod.php?action=addstat';addstat.target='Alpha';addstat.actionb.value='at';addstat.submit();}else{ataddlink.style.visibility='visible';return false}";
    echo '        }';
    echo "        if (type == 'de'){";
    echo "        if ($UsrGenrl[growth] < $De_Stat_Req || $De_Stat_Req == '0' || $UsrGenrl[growth] == '0'){alert('你的成長點數不足夠！');return false}";
    echo "        if (confirm('你現在有 $UsrGenrl[growth] 成長點數。\\n要把防禦能力加到 $NextStatPt_De 的話需要 $De_Stat_Req 點數。\\n確定嗎?') == true){";
    echo "        addstat.action='statsmod.php?action=addstat';addstat.target='Alpha';addstat.actionb.value='de';addstat.submit();}else{deaddlink.style.visibility='visible';return false}";
    echo '        }';
    echo "        if (type == 're'){";
    echo "        if ($UsrGenrl[growth] < $Re_Stat_Req || $Re_Stat_Req == '0' || $UsrGenrl[growth] == '0'){alert('你的成長點數不足夠！');return false}";
    echo "        if (confirm('你現在有 $UsrGenrl[growth] 成長點數。\\n要把迴避加到 $NextStatPt_Re 的話需要 $Re_Stat_Req 點數。\\n確定嗎?') == true){";
    echo "        addstat.action='statsmod.php?action=addstat';addstat.target='Alpha';addstat.actionb.value='re';addstat.submit();}else{readdlink.style.visibility='visible';return false}";
    echo '        }';
    echo "        if (type == 'ta'){";
    echo "        if ($UsrGenrl[growth] < $Ta_Stat_Req || $Ta_Stat_Req == '0' || $UsrGenrl[growth] == '0'){alert('你的成長點數不足夠！');return false}";
    echo "        if (confirm('你現在有 $UsrGenrl[growth] 成長點數。\\n要把命中能力加到 $NextStatPt_Ta 的話需要 $Ta_Stat_Req 點數。\\n確定嗎?') == true){";
    echo "        addstat.action='statsmod.php?action=addstat';addstat.target='Alpha';addstat.actionb.value='ta';addstat.submit();}else{taaddlink.style.visibility='visible';return false}";
    echo '        }}</script>';
    if ($UsrGenrl['growth'] >= $At_Stat_Req && $PlGameVal['attacking'] < 150) {
        $AtAdd = " style=\"text-decoration: underline overline\" onClick=\"this.style.visibility='hidden';add_stat('at')\" onMouseover=\"this.style.color='yellow'\" onMouseOut=\"this.style.color='';\" id = 'ataddlink'";
    }
    if ($UsrGenrl['growth'] >= $De_Stat_Req && $PlGameVal['defending'] < 150) {
        $DeAdd = " style=\"text-decoration: underline overline\" onClick=\"this.style.visibility='hidden';add_stat('de')\" onMouseover=\"this.style.color='yellow'\" onMouseOut=\"this.style.color='';\" id = 'deaddlink'";
    }
    if ($UsrGenrl['growth'] >= $Re_Stat_Req && $PlGameVal['reacting'] < 100) {
        $ReAdd = " style=\"text-decoration: underline overline\" onClick=\"this.style.visibility='hidden';add_stat('re')\" onMouseover=\"this.style.color='yellow'\" onMouseOut=\"this.style.color='';\" id = 'readdlink'";
    }
    if ($UsrGenrl['growth'] >= $Ta_Stat_Req && $PlGameVal['targeting'] < 140) {
        $TaAdd = " style=\"text-decoration: underline overline\" onClick=\"this.style.visibility='hidden';add_stat('ta')\" onMouseover=\"this.style.color='yellow'\" onMouseOut=\"this.style.color='';\" id = 'taaddlink'";
    }
    $Pl_ATF = $PlMs['atf'] + $Pl_Type['atf'] + $Pl_CFix[1];
    $Pl_DEF = $PlMs['def'] + $Pl_Type['def'] + $Pl_CFix[2];
    $Pl_REF = $PlMs['ref'] + $Pl_Type['ref'] + $Pl_CFix[3];
    $Pl_TAF = $PlMs['taf'] + $Pl_Type['taf'] + $Pl_CFix[4];

    if ($UsrGenrl['hypermode'] >= 4 && $UsrGenrl['hypermode'] <= 6) {
        //Natural
			if (ereg('(nat|co)+', $Pl_Type['id'])) {
				$Pl_ATF += 10;
                $Pl_DEF += 10;
                $Pl_REF += 10;
                $Pl_TAF += 10;
            }
            //Enhanced
            elseif (ereg('(enh|nt)+', $Pl_Type['id'])) {
                $Pl_ATF += 8;
                $Pl_DEF += 5;
                $Pl_REF += 7;
                $Pl_TAF += 10;
			}
            //Extended
            elseif (ereg('(ext|psy)+', $Pl_Type['id'])) {
				$Pl_ATF += 10;
				$Pl_DEF += 7;
				$Pl_REF += 8;
				$Pl_TAF += 7;
            }
    }
	
	if ($UsrGenrl['evamode'] == 1) {
        //Natural
			if (ereg('(nat|co)+', $Pl_Type['id'])) {
				$Pl_ATF += 15;
                $Pl_DEF += 15;
                $Pl_REF += 15;
                $Pl_TAF += 15;
            }
            //Enhanced
            elseif (ereg('(enh|nt)+', $Pl_Type['id'])) {
                $Pl_ATF += 13;
                $Pl_DEF += 10;
                $Pl_REF += 12;
                $Pl_TAF += 15;
			}
            //Extended
            elseif (ereg('(ext|psy)+', $Pl_Type['id'])) {
				$Pl_ATF += 15;
				$Pl_DEF += 12;
				$Pl_REF += 13;
				$Pl_TAF += 12;
            }
    }
    echo '<br><br><br>';
    echo "<td rowspan=3 align=center><span id=attacking$AtAdd>攻擊</span><br>";
    echo "<b style=\"color:$AtClr;\">$PlGameVal[attacking] + $Pl_ATF</b></td>";
    echo "<td align=center><span id=defending$DeAdd>防禦</span><br>";
    echo "<b style=\"color:$DeClr;\">$PlGameVal[defending] + $Pl_DEF</b></td>";
    echo "<td rowspan=3 align=center><span id=reacting$ReAdd>迴避</span><br>";
    echo "<b style=\"color:$ReClr;\">$PlGameVal[reacting] + $Pl_REF</b></td>";
    echo '</tr>',
'<tr>',
'<td valign=top>',
'<table cellpadding=0 cellspacing=0 border=0 bgcolor="#000000">',
'<tr>',
"<td width=30 height=30 align=right valign=bottom background=\"$Base_Image_Dir/btl.gif\"><img src='$Base_Image_Dir/tl.gif' width=$ShowAt height=$ShowDe style=\"position:relative;filter:alpha(opacity=70,finishopacitiy=70);\"></td>",
"<td width=30 height=30 align=left valign=bottom background=\"$Base_Image_Dir/btr.gif\"><img src='$Base_Image_Dir/tr.gif' width=$ShowRe height=$ShowDe style=\"position:relative;filter:alpha(opacity=70,finishopacitiy=70);\"></td>",
'</tr><tr>',
"<td width=30 height=30 align=right valign=top background=\"$Base_Image_Dir/bbl.gif\"><img src='$Base_Image_Dir/bl.gif' width=$ShowAt height=$ShowTa style=\"position:relative;filter:alpha(opacity=70,finishopacitiy=70);\"></td>",
"<td width=30 height=30 align=left valign=top background=\"$Base_Image_Dir/bbr.gif\"><img src='$Base_Image_Dir/br.gif' width=$ShowRe height=$ShowTa style=\"position:relative;filter:alpha(opacity=70,finishopacitiy=70);\"></td>",
'</tr></table></td></tr><tr>';
    echo "<td align=center><span id=targeting$TaAdd>命中</span><br>";
    echo "<b style=\"color:$TaClr;\">$PlGameVal[targeting] + $Pl_TAF</b></td>";
    echo '</tr>';
    echo '</table>';
    echo '</center>';
    echo '</div>';
    echo '</td>';
    echo '<td width="2%"> ';
    echo '</td>';
    echo '<td width="30%" valign=top><div align="center">';
    echo '<center>';
    echo '<table style="font-size:15px;" width="55%"><tr>';
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    if ($UsrGenrl['msuit']) {
        echo '<b>生命值</b></td>';
    } else {
        echo '<b>生命付加值</b></td>';
    }
    $Pl_ShowHP = floor($PlGameVal['hp']);
    $Pl_ShowEN = floor($PlGameVal['en']);
    $Pl_ShowSP = floor($PlGameVal['sp']);
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b id=current_hp>$Pl_ShowHP</b><b> / $PlGameVal[hpmax]</b></td></tr><tr>";
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    if ($UsrGenrl['msuit']) {
        echo '<b>能量值</b></td>';
    } else {
        echo '<b>能量付加值</b></td>';
    }
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b id=current_en>$Pl_ShowEN</b><b> / $PlGameVal[enmax]</b></td></tr><tr>";

    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    echo '<b>氣力</b></td>';
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b id=current_sp>$Pl_ShowSP</b><b> / $PlGameVal[spmax]</b></td></tr><tr>";

    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    echo '<b>等級</b></td>';
    if ($PlGameVal['level'] > 1000) {
        $PlGameVal['level'] = 1000;
    }
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b>$PlGameVal[level]</b></td></tr><tr>";
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    $Show_Exp = '';
    if ($PlGameVal['level'] >= 1000) {
        $UserNextLvExp = false;
        $Show_Exp = '<center>---</center>';
    } else {
        calcExp("$PlGameVal[level]");
        $Show_Exp = "$PlGameVal[expr] / $UserNextLvExp";
    }
    echo '<b>經驗值</b></td>';
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b>$Show_Exp</b></td></tr><tr>";
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    echo '<b>能力</b></td>';
    echo '<td align=right style="border:1px solid #404040;" width="124"><b';
    if ($UsrGenrl['hypermode'] == 1 || ($UsrGenrl['hypermode'] >= 4 && $UsrGenrl['hypermode'] <= 6)) {
        echo ' style="filter: glow(color: 0000FF,strength=2)"';
    }
    echo ">$Pl_Type[name]";
    if ($UsrGenrl['hypermode'] == 1 || $UsrGenrl['hypermode'] == 5) {
        echo '<br><font style="color: FFFF00;font-weight: bold">SEED Mode</font>';
    }
    if ($UsrGenrl['hypermode'] >= 4 && $UsrGenrl['hypermode'] <= 6) {
        echo '<br><font style="color: FF0000;font-weight: bold">EXAM Activated</font>';
    }
	if ($UsrGenrl['evamode'] == 1) {
        echo '<br><font style="color: FF0000;font-weight: bold">EVA Mode</font>';
    }
    echo '</b></td></tr><tr>';
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    echo '<b>成長點數</b></td>';
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b>$UsrGenrl[growth]</b></td></tr><tr>";
    echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
    echo '<b>金錢</b></td>';
    echo '<td align=right style="border:1px solid #404040;" width="124"><b>'.number_format($UsrGenrl['cash']).'</b></td></tr>';
	echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
	echo '<b>合金</b></td>';
    echo '<td align=right style="border:1px solid #404040;" width="124"><b>'.number_format($UsrGenrl['Gold']).'</b></td></tr>';
	echo '<td style="background: '.$BStyleC.';font-size:13px;" align=center width="70">';
	echo '<b>是日戰鬥次數</b></td>';
    echo "<td align=right style=\"border:1px solid #404040;\" width=\"124\"><b>$UsrGenrl[bcount]/1500</b></td></tr><tr></table>";
    echo '</center>';
    echo '</div></td>';
    echo '<td width="2%">　</td>';
    echo '<td width="34%" valign=top>';
    if ($UsrGenrl['msuit']) {
        $UsrWepA = explode('<!>', $PlGameVal['wepa']);
        $UsrWepB = explode('<!>', $PlGameVal['wepb']);
        $UsrWepC = explode('<!>', $PlGameVal['wepc']);
        $UsrWepD = explode('<!>', $PlGameVal['eqwep']);
        $UsrWepE = explode('<!>', $PlGameVal['p_equip']);
        GetWeaponDetails("$UsrWepA[0]", 'SysWepA');
        GetWeaponDetails("$UsrWepB[0]", 'SysWepB');
        GetWeaponDetails("$UsrWepC[0]", 'SysWepC');
        GetWeaponDetails("$UsrWepD[0]", 'SysWepD');
        GetWeaponDetails("$UsrWepE[0]", 'SysWepE');
        if ($UsrWepA[2] == 1) {
            $SysWepA['name'] = $UsrWepA[3].$SysWepA['name'];
        } elseif ($UsrWepA[2] == 2) {
            $SysWepA['name'] = $SysWepA['name'].$UsrWepA[3];
        }
        if ($UsrWepB[2] == 1) {
            $SysWepB['name'] = $UsrWepB[3].$SysWepB['name'];
        } elseif ($UsrWepB[2] == 2) {
            $SysWepB['name'] = $SysWepB['name'].$UsrWepB[3];
        }
        if ($UsrWepC[2] == 1) {
            $SysWepC['name'] = $UsrWepC[3].$SysWepC['name'];
        } elseif ($UsrWepC[2] == 2) {
            $SysWepC['name'] = $SysWepC['name'].$UsrWepC[3];
        }
        if ($UsrWepD[2] == 1) {
            $SysWepD['name'] = $UsrWepD[3].$SysWepD['name'];
        } elseif ($UsrWepD[2] == 2) {
            $SysWepD['name'] = $SysWepD['name'].$UsrWepD[3];
        }
        if ($UsrWepE[2] == 1) {
            $SysWepE['name'] = $UsrWepE[3].$SysWepE['name'];
        } elseif ($UsrWepE[2] == 2) {
            $SysWepE['name'] = $SysWepE['name'].$UsrWepE[3];
        }
    }

    echo '<span style="background-color:  '.$UsrGenrl['color'].'"> <b>裝備</b> </span> ';
    if ($UsrGenrl['msuit']) {
        echo "$SysWepA[name] 經驗: $UsrWepA[1]<br>備用一: $SysWepB[name] 經驗: $UsrWepB[1]<br>備用二: $SysWepC[name] 經驗: $UsrWepC[1]";
    } else {
        echo '<br>沒有機體。<br><br><br>';
    }
    echo '<br><span style="background-color:  '.$UsrGenrl['color'].'">&nbsp<b>輔助裝備</b> </span> ';
    if ($UsrGenrl['msuit']) {
        echo "$SysWepD[name] 經驗: $UsrWepD[1]";
    }
    if ($PlGameVal['p_equip'] && $PlGameVal['p_equip'] != '0<!>0') {
        echo '<br><span style="background-color:  '.$UsrGenrl['color'].'">&nbsp<b>常規裝備</b> </span> ';
        if ($UsrGenrl['msuit']) {
            echo "$SysWepE[name] 經驗: $UsrWepE[1]";
        }
    }

    echo '<script language="JavaScript">';
    echo "var h=$Pl_ShowHP;";
    echo "var e=$Pl_ShowEN;";
    echo "var s=$Pl_ShowSP;";
    echo 'var timerID;';
    echo 'TheDate = new Date();';
    echo 'var m_time=TheDate.getTime();';
    echo 'AutoRepairJ();';
    echo 'function AutoRepairJ(){';
    echo 'TheDate2 = new Date();';
    echo '        n_time=TheDate2.getTime();';
    echo "        ts_gap = (m_time - n_time)/-1000;\n";

    if ($PlMs['hprec'] >= 1) {
        $cfu_HP_AutoRepairType = 1;
    }
    if ($PlMs['hprec'] < 1 && $PlMs['hprec'] >= 0.001) {
        $cfu_HP_AutoRepairType = 2;
    }

    if ($PlMs['enrec'] >= 1) {
        $cfu_EN_AutoRepairType = 1;
    }
    if ($PlMs['enrec'] < 1 && $PlMs['enrec'] >= 0.001) {
        $cfu_EN_AutoRepairType = 2;
    }

    switch ($cfu_HP_AutoRepairType) {
        case 1: echo "hprate = $PlMs[hprec];\n";break;
        case 2: echo "hprate = $PlMs[hprec]*$PlGameVal[hpmax];\n";break;
        default: echo 'hprate = 0;';break;}
    switch ($cfu_EN_AutoRepairType) {
        case 1: echo "enrate = $PlMs[enrec];\n";break;
        case 2: echo "enrate = $PlMs[enrec]*$PlGameVal[enmax];\n";break;
        default: echo 'enrate = 0;';break;}

    $SP_RecRate = 0.004 * $PlGameVal['spmax'];
    if ($UsrGenrl['hypermode'] == 2 || $UsrGenrl['hypermode'] == 6) {
        $SP_RecRate *= 2;
    }

    unset($EqRecHP, $EqRecEN);
    if ($SysWepD['spec']) {
        if (ereg('(HPPcRecA)+', $SysWepD['spec']) && $PlMs['hprec'] >= 1) {
            $EqRecHP = "h += (ts_gap * (0.005 * $PlGameVal[hpmax]));";
        }
        if (ereg('(ENPcRecA)+', $SysWepD['spec']) && $PlMs['enrec'] >= 1) {
            $EqRecEN = "e += (ts_gap * (0.0075 * $PlGameVal[enmax]));";
        } elseif (ereg('(ENPcRecB)+', $SysWepD['spec']) && $PlMs['enrec'] >= 1) {
            $EqRecEN = "e += (ts_gap * (0.015 * $PlGameVal[enmax]));";
        }
    }

    echo "        if (h < 0){h = 0;}\n";
    echo "        if (h < $PlGameVal[hpmax]){h = $Pl_ShowHP + (ts_gap * hprate);".$EqRecHP."}else{h = $PlGameVal[hpmax];}\n";
    echo "        if (e < $PlGameVal[enmax]){e = $Pl_ShowEN + (ts_gap * enrate);".$EqRecEN."}else{e = $PlGameVal[enmax];}\n";
    echo "        if (s < $PlGameVal[spmax]){s = $Pl_ShowSP + (ts_gap * ".$SP_RecRate.");}else{s = $PlGameVal[spmax];}\n";

    echo "        if (h >= $PlGameVal[hpmax] && status_now.innerText=='修理中')";
    echo "        {status_now.innerText='可發進';status_now.style.color='#143DC1';}";

    echo '        current_hp.innerText=Math.round (h);';
    echo '        current_en.innerText=Math.round (e);';
    echo '        current_sp.innerText=Math.round (s);';
    echo '        clearTimeout(timerID);';
    echo '        timerID = setTimeout("AutoRepairJ()",100);';
    echo '        }';
    echo '        </script>';

    if ($UsrGenrl['request']) {
        echo '<form action=organization.php?action=Employ method=post name=requestOrg>';
        echo "<input type=hidden value='C' name=actionb>";
        echo "<input type=hidden name=actionc value=''>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo '<p><span style="font-weight: 700; font-size: 10pt; background-color:  '.$UsrGenrl['color'].'"> <b>邀請信</b> </span><br>';
        echo "$UsrGenrl[request]";
        echo "<input type=submit onClick=\"actionc.value='Accept'\" value='答應'>";
        echo "<input type=submit onClick=\"actionc.value='Refuse'\" value='拒絕'>";
        echo '</form>';
    }

    if ($Pl_Org['opttime'] > $CFU_Time && $Pl_Org['optmissioni']) {
        echo '<p><span style="font-weight: 700; font-size: 10pt; background-color:  '.$Pl_Org['color'].'"> <b>出擊通知書</b> 國家有任務交給您了！ </span><br>';
        echo "<font style=\"font-size: 10pt;color: white\">[任務]</font><font style=\"font-size: 8pt;\">行動代號: $Pl_Org[operation]<br>";
        if (ereg('(Atk=\(.*\))+', $Pl_Org['optmissioni'])) {
            $Pl_Show_Mission = ereg_replace('(Atk=\()|\)', '', $Pl_Org['optmissioni']);

            $Opt_Area = ReturnMap("$Pl_Show_Mission");
            $Opt_Org = ReturnOrg($Opt_Area['User']['occupied']);
            echo "<font style=\"font-size: 10pt;color: white\">[內容]</font>攻擊屬於 <font color=$Opt_Org[color]>$Opt_Org[name]</font> 統治下的",$Opt_Area['Sys']['map_id'],'區域';
            $StartAtk = cfu_time_convert($Pl_Org['optstart']);
            $TimeEnd = cfu_time_convert($Pl_Org['opttime']);
            echo "<br><font style=\"font-size: 10pt;color: white\">[開始時間]</font> $StartAtk <br><font style=\"font-size: 10pt;color: white\">[完結時間]</font> $TimeEnd ";
        }
        echo '</font>';
    }
    if ($LogEntries && $Pl_Settings['show_log_num']) {
        if ($Pl_Settings['show_log_num'] > $LogEntries) {
            $Pl_LEnt = $LogEntries;
        } else {
    $Pl_LEnt = $Pl_Settings['show_log_num'];
}
echo '<script language="JavaScript">';
echo "function showlog(){logspc.style.visibility='visible';logspc.style.position='relative';logbtn.innerText='[X]';logbtn.href=\"Javascript:hidelog();\"}";
echo "function hidelog(){logspc.style.visibility='hidden';logspc.style.position='absolute';logbtn.innerText='[+]';logbtn.href=\"Javascript:showlog();\"}";
echo '</script>';
echo '<p><span style="font-weight: 700; font-size: 10pt; background-color:  '.$UsrGenrl['color'].'"> <b>歷程紀錄</b> <a href="Javascript:showlog();" id=logbtn style="text-decoration: none">[+]</a></span><br><div id=logspc style="font-size: 8pt;position: absolute;visibility: hidden">';
$User_Log = GetUsrLog("$UsrGenrl[username]") or die('無法取得紀錄資訊！！<br>請聯絡管理員！');
for ($LogShowNum = 1;$LogShowNum <= $Pl_LEnt;++$LogShowNum) {
    $i = 'time'.$LogShowNum;
    $j = 'log'.$LogShowNum;
    if ($User_Log[$i]) {
        echo cfu_time_convert($User_Log[$i])."<br>$User_Log[$j]<br>";
    }
    unset($i, $j);
}
    }

    echo '</div></td></tr>';
    echo '</table>';
    echo '</td>';
    echo '</tr>';
    echo '<script language="JavaScript">',
'setTimeout("enablerf();",2000);',
'function movebattle(){',
        "act.action='battle.php?action=battle_sel';",
        "act.actionb.value='battle_sel';",
        "act.target='Beta';",
        'act.submit();}',
'function enablerf(){',
        'act.ig_refresh.disabled=false;',
        '}',
'</script>';

    echo '<form action=nil method=post name=act target=Beta>';
    echo '<tr>';
    echo '<td width="100%" height="11">';
    echo "<input type=hidden value='none' name=actionb>";
    echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='戰鬥' onClick=\"movebattle()\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='移動' onClick=\"act.action='map.php?action=Move';actionb.value='A';act.target='Beta';act.submit();\">";
    if ($Area['User']['hp'] <= 0 && $PlGameVal['rights'] == '1' && ereg_replace('(Atk=\()|\)', '', $Pl_Org['optmissioni']) == $UsrGenrl['coordinates'] && $CFU_Time < $Pl_Org['opttime']) {
        echo "<input style=\"$BStyleA\" $BStyleB type=button value='佔領' onClick=\"act.action='organization.php?action=TakeCity';actionb.value='A';act.target='Beta';act.submit();\">";
    }
	if ($PlGameVal['rights'] && ereg_replace('(Atk=\()|\)', '', $Pl_Org['optmissioni']) == $UsrGenrl['coordinates']) {
		echo "<input style=\"$BStyleA\" $BStyleB type=button value='放棄佔領' onClick=\"act.action='organization.php?action=GiveUp';actionb.value='A';act.target='Beta';act.submit();\">";
	}	
    echo "　<input style=\"$BStyleA\" $BStyleB type=button value='裝備' onClick=\"act.action='equip.php?action=equip';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='機體生產' onClick=\"act.action='equip.php?action=buyms';act.actionb.value='buyms';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='機體改造' onClick=\"act.action='statsmod.php?action=modms';act.actionb.value='buyms';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='兵器製造' onClick=\"act.action='tactfactory.php?action=main';act.actionb.value='none';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='修理工場' onClick=\"act.action='statsmod.php?action=repairms';act.actionb.value='sel';act.target='Beta';act.submit();\">";
    echo "　<input style=\"$BStyleA\" $BStyleB type=button value='戰術學院' onClick=\"act.action='tacticslearn.php?action=main';act.actionb.value='none';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='倉庫' onClick=\"act.action='warehouse.php?action=selection';act.actionb.value='none';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='銀行' onClick=\"act.action='bank.php?action=main';act.actionb.value='none';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='商場' onClick=\"act.action='market.php?action=main';act.actionb.value='none';act.target='Beta';act.submit();\">";
	echo "　<input style=\"$BStyleA\" $BStyleB type=button value='情報' onClick=\"act.action='information.php?action=Main';act.actionb.value='';act.target='Beta';act.submit();\">";
    echo "<input style=\"$BStyleA\" $BStyleB type=button value='排名' onClick=\"act.action='gen_info.php?action=ranks';act.actionb.value='none';act.target='Beta';act.submit();\">";
	echo "　<input style=\"$BStyleA\" $BStyleB type=button value='特殊' onClick=\"act.action='scommand.php?action=main';act.actionb.value='none';act.target='Beta';act.submit();\">";
	if ($UsrGenrl['acc_status'] == '9') {
		echo "　<input style=\"$BStyleA\" $BStyleB type=button value='舊管理中心' onClick=\"act.action='admin.php?action=panel';actionb.value='A';act.target='Beta';act.submit();\">";
		echo "<input style=\"$BStyleA\" $BStyleB type=button value='新管理中心' onClick=\"act.action='manager.php';actionb.value='A';act.target='Beta';act.submit();\">";
	}
    echo "　<input style=\"$BStyleA\" $BStyleB type=button name=ig_refresh value='重新整理' disabled onClick=\"act.action='gmscrn_main.php?action=proc';act.target='Alpha';act.submit();\">";
	echo "　<input style=\"$BStyleA\" $BStyleB type=button name=chat value='聊天' onClick=\"window.open('','$CFU_Time','resizable=1,width=800,height=600');act.action='chat.php';act.target='$CFU_Time';act.submit();\">";
	echo "<input style=\"$BStyleA\" $BStyleB type=button name=forum value='討論區' onClick=\"window.open('http://ext4.me/forum.php');\">";
    echo "　<input style=\"$BStyleA\" $BStyleB type=button value='退出' onClick=\"location.replace('logout.php');\">";
    echo '</td>';
    echo '</tr></form>';
    echo '</table>';

    echo '<table>';
    echo '<tr><td align=center style="filter: chroma(color: black)">';
    echo '<script language="JavaScript">';
    echo "if (screen.availWidth < 1024){document.write('<iframe name=\'Beta\' src=\'gen_info.php\' width=\'800\' height=\'600\' marginheight=0 marginwidth=0 frameborder=0>');} else{";
    echo "document.write('<iframe name=\'Beta\' src=\'gen_info.php\' width=\'1277\' height=\'600\' marginheight=0 marginwidth=0 frameborder=0>');}";
    echo '</script>';
    echo '</td></tr>';
    echo '</table>';
    echo '<table height=100% valign=bottom>';
    postFooter();
    echo '</table>';
    echo '</body>';
    echo '</html>';
    exit;
}

        echo '<br><br><br>Undefined Action';postFooter();
