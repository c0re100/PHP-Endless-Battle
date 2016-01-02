<?php
header('Content-Type: text/html; charset=utf-8');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
postHead('');
AuthUser();
if ($CFU_Time >= $_SESSION['timeauth']+$TIME_OUT_TIME || $_SESSION['timeauth'] <= $CFU_Time-$TIME_OUT_TIME){echo "驗證機制！<br>請重新登入！";exit;}
GetUsrDetails("$_SESSION[username]",'Gen','Game');
$t_now = time();
if ($t_now - $Gen['btltime'] <= 1){echo "動作過快。";postFooter();mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `btltime` = ".intval($t_now+10)." WHERE `username` = '$Gen[username]' LIMIT 1;");exit;}

$Otp_Area_Sql = ("SELECT `name`,`color`,`opttime`,`optstart` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `optmissioni` = 'Atk=($Gen[coordinates])' AND `opttime` > '$CFU_Time' ORDER BY `optstart` ASC LIMIT 1");
$Otp_Area_Q = mysql_query($Otp_Area_Sql) or die(mysql_error());
$Otp_A_ITar = mysql_fetch_array($Otp_Area_Q);

if ($Otp_A_ITar){
if ($Otp_A_ITar['optstart'] > $CFU_Time){
$TimeTSSec = $Otp_A_ITar['optstart'] - $CFU_Time;
$TimetS['hours'] = floor($TimeTSSec/3600);
$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒開始戰爭。";
}
else{
$TimeTSSec = $Otp_A_ITar['opttime'] - $CFU_Time;
$TimetS['hours'] = floor($TimeTSSec/3600);
$TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
$TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
$Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒戰爭宣告終了。";}
}

if ($Otp_A_ITar && $Otp_A_ITar['optstart'] < $CFU_Time){echo "<center>此區域處於戰爭狀態，格納庫關閉以躲避戰爭！<br>$Otp_TellTime";postFooter();exit;}

$UsrWepA = explode('<!>',$Game['wepa']);
$UsrWepB = explode('<!>',$Game['wepb']);
$UsrWepC = explode('<!>',$Game['wepc']);
$UsrWepD = explode('<!>',$Game['eqwep']);
$UsrWepE = explode('<!>',$Game['p_equip']);
GetWeaponDetails("$UsrWepA[0]",'UsWep_A');
if ($UsrWepA[2]){
if ($UsrWepA[2]==1) $UsWep_A['name'] = $UsrWepA[3].$UsWep_A['name']."<sub>?</sub>";
else $UsWep_A['name'] = $UsWep_A['name'].$UsrWepA[3]."<sub>?</sub>";
$UsWep_A['atk'] += $UsrWepA[4];
$UsWep_A['hit'] += $UsrWepA[5];
$UsWep_A['rd'] += $UsrWepA[6];
$UsWep_A['enc'] = $UsrWepA[7];
}
$UsWepSpec_A = ReturnSpecs("$UsWep_A[spec]");
GetWeaponDetails("$UsrWepB[0]",'UsWep_B');
if ($UsrWepB[2]){
if ($UsrWepB[2]==1) $UsWep_B['name'] = $UsrWepB[3].$UsWep_B['name']."<sub>?</sub>";
else $UsWep_B['name'] = $UsWep_B['name'].$UsrWepB[3]."<sub>?</sub>";
$UsWep_B['atk'] += $UsrWepB[4];
$UsWep_B['hit'] += $UsrWepB[5];
$UsWep_B['rd'] += $UsrWepB[6];
$UsWep_B['enc'] = $UsrWepB[7];
}
$UsWepSpec_B = ReturnSpecs("$UsWep_B[spec]");
GetWeaponDetails("$UsrWepC[0]",'UsWep_C');
if ($UsrWepC[2]){
if ($UsrWepC[2]==1) $UsWep_C['name'] = $UsrWepC[3].$UsWep_C['name']."<sub>?</sub>";
else $UsWep_C['name'] = $UsWep_C['name'].$UsrWepC[3]."<sub>?</sub>";
$UsWep_C['atk'] += $UsrWepC[4];
$UsWep_C['hit'] += $UsrWepC[5];
$UsWep_C['rd'] += $UsrWepC[6];
$UsWep_C['enc'] = $UsrWepC[7];
}
$UsWepSpec_C = ReturnSpecs("$UsWep_C[spec]");

GetWeaponDetails("$UsrWepD[0]",'UsWep_D');
if ($UsrWepD[2]){
if ($UsrWepD[2]==1) $UsWep_D['name'] = $UsrWepD[3].$UsWep_D['name']."<sub>?</sub>";
else $UsWep_D['name'] = $UsWep_D['name'].$UsrWepD[3]."<sub>?</sub>";
$UsWep_D['atk'] += $UsrWepD[4];
$UsWep_D['hit'] += $UsrWepD[5];
$UsWep_D['rd'] += $UsrWepD[6];
$UsWep_D['enc'] = $UsrWepD[7];
}
$UsWepSpec_D = ReturnSpecs("$UsWep_D[spec]");

GetWeaponDetails("$UsrWepE[0]",'UsWep_E');
if ($UsrWepE[2]){
if ($UsrWepE[2]==1) $UsWep_E['name'] = $UsrWepE[3].$UsWep_E['name']."<sub>?</sub>";
else $UsWep_E['name'] = $UsWep_E['name'].$UsrWepE[3]."<sub>?</sub>";
$UsWep_E['atk'] += $UsrWepE[4];
$UsWep_E['hit'] += $UsrWepE[5];
$UsWep_E['rd'] += $UsrWepE[6];
$UsWep_E['enc'] = $UsrWepE[7];
}
$UsWepSpec_E = ReturnSpecs("$UsWep_E[spec]");

//Hangar GUI
if ($mode=='main'){

        $SQL_Main = ("SELECT `h_id`, `h_user`, `h_msuit`, `h_hp`, `h_hpmax`, `h_en`, `h_enmax`, `h_ms_custom`, `h_wepa`, `h_wepb`, `h_wepc`, `h_eqwep`, `h_p_equip`, `msname`, `atf`, `def`, `ref`, `taf`  FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` `h`, `".$GLOBALS['DBPrefix']."phpeb_sys_ms` `ms` WHERE `h_user` = '$_SESSION[username]' AND `id` = `h_msuit` ORDER BY `h_id` ASC;");
        $SQL_Query_Main = mysql_query($SQL_Main) or die(mysql_error());
        $NumHangarMS = mysql_num_rows($SQL_Query_Main);

if ($mode=='main' && $actionb == 'procget'){
		$actionc = mysql_real_escape_string($actionc);
        $actionc = intval($actionc);
        if ($Gen['msuit']){$ErrorMsg = '請先安置好正在使用的機體!!';}
        elseif ($Game['wepa'] != '0<!>0' || $Game['wepb'] != '0<!>0' || $Game['wepc'] != '0<!>0' || $Game['eqwep'] != '0<!>0'){$ErrorMsg = '請先安置好備用中的武器和裝備!!';}
        elseif (!$actionc){$ErrorMsg = '請先選定目標機體!!';}
        else {
                $sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` WHERE `h_id` = '$actionc' AND `h_user` = '$_SESSION[username]' LIMIT 1;");
                $sql_query = mysql_query($sql) or die(mysql_error());
                $CountResults = mysql_num_rows($sql_query);
                if ($CountResults != 1) $ErrorMsg = '找不到機體。';
                else {
                        $Hangar = mysql_fetch_array($sql_query);

                        $Eq = explode('<!>',$Hangar['h_eqwep']);
                        $P_Eq = explode('<!>',$Hangar['h_p_equip']);

                        $sql = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $Eq[0] ."'");
                        $query_r = mysql_query($sql);
                        $SyEq = mysql_fetch_array($query_r);

                        $sql = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $P_Eq[0] ."'");
                        $query_r = mysql_query($sql);
                        $SyP_Eq = mysql_fetch_array($query_r);

                        $sql = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE id='". $Hangar['h_msuit'] ."'");
                        $query_r = mysql_query($sql);
                        $SyMs = mysql_fetch_array($query_r);

                        if ((ereg('(EXAMSystem)+',$SyEq['spec']) || ereg('(EXAMSystem)+',$SyP_Eq['spec']) || ereg('(EXAMSystem)+',$SyMs['spec'])) && !ereg('(EXAMSystem)+',$Game['spec']) && ereg('(nat|enh|ext)+',$Gen['typech'])) {
                        $Game['spec'] .= 'EXAMSystem, ';
                        $EXAM_String = ("`spec` = '$Game[spec]', ");
                        }else $EXAM_String = '';

                        $SQL = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `msuit` = '$Hangar[h_msuit]' WHERE `username` = '$_SESSION[username]' LIMIT 1;");
                        mysql_query($SQL) or die(mysql_error());
                        $SQL = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET $EXAM_String `hp` = '$Hangar[h_hp]', `hpmax` = '$Hangar[h_hpmax]', `en` = '$Hangar[h_en]', `enmax` = '$Hangar[h_enmax]', `ms_custom` = '$Hangar[h_ms_custom]', `wepa` = '$Hangar[h_wepa]', `wepb` = '$Hangar[h_wepb]', `wepc` = '$Hangar[h_wepc]', `eqwep` = '$Hangar[h_eqwep]', `p_equip` = '$Hangar[h_p_equip]' WHERE `username` = '$_SESSION[username]' LIMIT 1;");
                        mysql_query($SQL) or die(mysql_error());
                        $SQL = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` WHERE `h_id` = '$actionc' AND `h_user` = '$_SESSION[username]' LIMIT 1;");
                        mysql_query($SQL) or die(mysql_error());
                }
        }
        if (!$ErrorMsg)$ErrorMsg ='成功取出機體和裝備了！';
        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">$ErrorMsg<br><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";

        postFooter();exit;
}
if ($mode=='main' && $actionb == 'prockeep'){

        if (!$Gen['msuit']){$ErrorMsg = '你沒有機體可以存入格納庫!!';}
        elseif ($NumHangarMS >= $Hangar_Limit) {$ErrorMsg = '格納庫空間不足！<Br>已經使用了$NumHangarMS/$Hangar_Limit個空間。';}
        elseif ($Gen['cash'] - $Hangar_Price < 0) {$ErrorMsg = '金錢不足！';}
        else {
                $sql = ("SELECT `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE id='". $Gen['msuit'] ."'");
                $query_r = mysql_query($sql);
                $SyMs = mysql_fetch_array($query_r);
                $hypmd_sql = '';
                $hypmd = 0;

                if ( ( ereg('(EXAMSystem)+',$SyMs['spec']) || ereg('(EXAMSystem)+',$UsWep_D['spec']) || ereg('(EXAMSystem)+',$UsWep_E['spec']) ) && ereg('(EXAMSystem)+',$Game['spec'])) {
                $Game['spec'] = str_replace('EXAMSystem, ','',$Game['spec']);
                $EXAM_String = ("`spec` = '$Game[spec]', ");
                }else $EXAM_String  = '';

                //Remove EXAM Activation
                if ($Gen['hypermode'] >= 4 && $Gen['hypermode'] <= 6){
                        switch($Gen['hypermode']){
                        case 4: $hypmd = 0; break;
                        case 5: $hypmd = 1; break;
                        case 6: $hypmd = 2; break;
                        }
                        $TFlag = 1;
                        $hypmd_sql = ", `hypermode` = $hypmd ";
                }

                $sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_hangar` VALUES('','$_SESSION[username]','$Gen[msuit]','$Game[hp]','$Game[hpmax]','$Game[en]','$Game[enmax]','$Game[ms_custom]','$Game[wepa]','$Game[wepb]','$Game[wepc]','$Game[eqwep]','$Game[p_equip]');");
                mysql_query($sql) or die(mysql_error());
                $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_game_info` SET $EXAM_String `hp` = 0, `hpmax` = 0, `en` = 0 , `enmax` = 0, `ms_custom` = '', `wepa` = '0<!>0', `wepb` = '0<!>0', `wepc` = '0<!>0', `eqwep` = '0<!>0', `p_equip` = '0<!>0' WHERE `username` = '$_SESSION[username]' LIMIT 1;");
                mysql_query($sql) or die(mysql_error());
                $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `msuit` = 0 $hypmd_sql, `cash` = `cash`-$Hangar_Price WHERE `username` = '$_SESSION[username]' LIMIT 1;");
                mysql_query($sql) or die(mysql_error());
        }
        if (!$ErrorMsg)$ErrorMsg ='成功存入機體和裝備了！';
        echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>";
        echo "<p align=center style=\"font-size: 16pt\">$ErrorMsg<br><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "</form>";

        postFooter();exit;
        }

echo "<font style=\"font-size: 12pt\">格納庫<hr>";
if ($Otp_TellTime){echo "$Otp_TellTime<hr>";}
echo "</font><br>";
echo "<form action=hangar.php?action=main method=post name=hnmainform>";
echo "<input type=hidden value='' name=actionb>";
echo "<input type=hidden value='' name=actionc>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"650\">";
        echo "<tr align=center><td colspan=9><b>裝備武器列表: </b></td></tr>";
        echo "<tr align=center>";
        echo "<td width=\"20\">No.</td>";
        echo "<td width=\"195\">武器名稱</td>";
        echo "<td width=\"80\">攻擊力</td>";
        echo "<td width=\"30\">命中</td>";
        echo "<td width=\"30\">回數</td>";
        echo "<td width=\"40\">EN消費</td>";
        echo "<td width=\"120\">特殊效果</td>";
        echo "<td width=\"85\">價錢</td>";
        echo "<td width=\"50\">經驗</td>";
        echo "</tr>";

        if ($UsrWepA[0]){
        echo "<tr align=center>";
        echo "<td width=\"20\">現</td>";
        echo "<td width=\"195\">$UsWep_A[name]</td>";
        echo "<td width=\"80\">". number_format($UsWep_A['atk']) ."</td>";
        echo "<td width=\"30\">$UsWep_A[hit]</td>";
        echo "<td width=\"30\">$UsWep_A[rd]</td>";
        echo "<td width=\"40\">$UsWep_A[enc]</td>";
        echo "<td width=\"120\">$UsWepSpec_A</td>";
        echo "<td width=\"85\">". number_format($UsWep_A['price']) ."</td>";
        echo "<td width=\"50\">$UsrWepA[1]</td>";
        echo "</tr>";}
        if ($UsrWepB[0]){
        echo "<tr align=center>";
        echo "<td width=\"20\">一</td>";
        echo "<td width=\"195\">$UsWep_B[name]</td>";
        echo "<td width=\"80\">". number_format($UsWep_B['atk']) ."</td>";
        echo "<td width=\"30\">$UsWep_B[hit]</td>";
        echo "<td width=\"30\">$UsWep_B[rd]</td>";
        echo "<td width=\"40\">$UsWep_B[enc]</td>";
        echo "<td width=\"120\">$UsWepSpec_B</td>";
        echo "<td width=\"85\">". number_format($UsWep_B['price']) ."</td>";
        echo "<td width=\"50\">$UsrWepB[1]</td>";
        $b_sel = "<option value='wepb'>備用一: $UsWep_B[name]";
        echo "</tr>";}
        if ($UsrWepC[0]){
        echo "<tr align=center>";
        echo "<td width=\"20\">二</td>";
        echo "<td width=\"195\">$UsWep_C[name]</td>";
        echo "<td width=\"80\">". number_format($UsWep_C['atk']) ."</td>";
        echo "<td width=\"30\">$UsWep_C[hit]</td>";
        echo "<td width=\"30\">$UsWep_C[rd]</td>";
        echo "<td width=\"40\">$UsWep_C[enc]</td>";
        echo "<td width=\"120\">$UsWepSpec_C</td>";
        echo "<td width=\"85\">". number_format($UsWep_C['price']) ."</td>";
        echo "<td width=\"50\">$UsrWepC[1]</td>";
        $c_sel = "<option value='wepc'>備用二: $UsWep_C[name]";
        echo "</tr>";}
        if ($UsrWepD[0]){
        echo "<tr align=center>";
        echo "<td width=\"20\">輔</td>";
        echo "<td width=\"195\">$UsWep_D[name]</td>";
        echo "<td width=\"80\">". number_format($UsWep_D['atk']) ."</td>";
        echo "<td width=\"30\">$UsWep_D[hit]</td>";
        echo "<td width=\"30\">$UsWep_D[rd]</td>";
        echo "<td width=\"40\">$UsWep_D[enc]</td>";
        echo "<td width=\"120\">$UsWepSpec_D</td>";
        echo "<td width=\"85\">". number_format($UsWep_D['price']) ."</td>";
        echo "<td width=\"50\">$UsrWepD[1]</td>";
        $c_sel = "<option value='WepD'>輔助裝備: $UsWep_D[name]";
        echo "</tr>";}
        if ($UsrWepE[0]){
        echo "<tr align=center>";
        echo "<td width=\"20\">常</td>";
        echo "<td width=\"195\">$UsWep_E[name]</td>";
        echo "<td width=\"80\">". number_format($UsWep_E['atk']) ."</td>";
        echo "<td width=\"30\">$UsWep_E[hit]</td>";
        echo "<td width=\"30\">$UsWep_E[rd]</td>";
        echo "<td width=\"40\">$UsWep_E[enc]</td>";
        echo "<td width=\"120\">$UsWepSpec_E</td>";
        echo "<td width=\"85\">". number_format($UsWep_E['price']) ."</td>";
        echo "<td width=\"50\">$UsrWepD[1]</td>";
        $c_sel = "<option value='WepD'>常規裝備: $UsWep_E[name]";
        echo "</tr>";}
        echo "</table>";

        echo "<script language=\"Javascript\">";
        echo "function cfmKeep(){
                if (confirm('花 $".number_format($Hangar_Price)." 來存放機體嗎？') == true){hnmainform.actionb.value='prockeep';return true;}
                else {return false;}";
        echo "}</script>";


        echo "<hr width=85%>";
        if (!$Gen['msuit']){echo '<center>你沒有機體可以存入格納庫。';}
        elseif ($NumHangarMS > $Hangar_Limit){echo '<center>格納庫太多機體了！不能再存入格納庫。';}
        else {
        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"200\">";
        echo "<tr><td align=center>存進格納庫:<br>";
        echo "<input type=submit value=確定存放 onClick=\"return cfmKeep()\"></td></tr>";
        echo "</table>";}


        echo "<hr width=85%>";
//In Hangar

        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#FFFFFF\" width=\"980\">";
        echo "<tr align=center><td colspan=15><b>格納庫內的機體: </b></td></tr>";

        echo "<tr align=center>";
        echo "<td width=\"80\">格納庫 ID</td>";
        echo "<td width=\"200\">機體名稱</td>";
        echo "<td width=\"50\">Attacking修正</td>";
        echo "<td width=\"50\">Defending修正</td>";
        echo "<td width=\"50\">Reacting修正</td>";
        echo "<td width=\"50\">Targeting修正</td>";
        echo "<td width=\"50\">HP</td>";
        echo "<td width=\"50\">HP上限</td>";
        echo "<td width=\"50\">EN</td>";
        echo "<td width=\"50\">EN上限</td>";
        echo "<td width=\"50\">武器</td>";
        echo "<td width=\"50\">備用一</td>";
        echo "<td width=\"50\">備用二</td>";
        echo "<td width=\"50\">輔助裝備</td>";
        echo "<td width=\"50\">常規裝備</td>";
        echo "</tr>";

        echo "<script language=\"Javascript\">
function setLayer(posX,posY,Width,Height,msgText){
        var X = posX + document.body.scrollLeft + 10;
        var Y = posY + document.body.scrollTop + 10;
        if(eval(posX + Width + 30) > document.body.clientWidth){
                X = eval(posX - Width + document.body.scrollLeft - 20);
        }if(eval(posY + Height + 30) > document.body.clientHeight){
                Y = eval(posY - Height + document.body.scrollTop - 20);
        }if(X<0){
                X = 0;
        }if(Y<0){
                Y = 0;
        }

        tmpTxt = eval(msgText);

        document.getElementById(\"wepinfo\").style.width = Width;
        document.getElementById(\"wepinfo\").style.height = Height;
        document.getElementById(\"wepinfo\").style.backgroundColor = \"ffffdd\";
        document.getElementById(\"wepinfo\").style.padding = 10;
        document.getElementById(\"wepinfo\").innerHTML = tmpTxt;
        document.getElementById(\"wepinfo\").style.border = \"solid 1px #000000\";
        document.getElementById(\"wepinfo\").style.left = X;
        document.getElementById(\"wepinfo\").style.top  = Y;
}

function offLayer(){
        document.getElementById(\"wepinfo\").style.width = 0;
        document.getElementById(\"wepinfo\").style.height = 0;
        document.getElementById(\"wepinfo\").innerHTML = \"\";
        document.getElementById(\"wepinfo\").style.backgroundColor = \"transparent\";
        document.getElementById(\"wepinfo\").style.border = 0;
}

function confirmTake(h_id){
        if ($Gen[msuit] != 0){alert('請先安置好正在使用的機體');}
        else if ('$Game[wepa]' != '0<!>0' || '$Game[wepb]' != '0<!>0' || '$Game[wepc]' != '0<!>0' || '$Game[eqwep]' != '0<!>0'){alert('請先安置好備用中的武器和裝備!!');}
        else if (confirm('要取出ID: '+h_id+' 的機體嗎?\\n請注意, 附加能源和附加裝甲還存在的話, 將會被棄置!') == true) {hnmainform.actionb.value='procget';hnmainform.actionc.value=h_id;hnmainform.submit();}
}
</script>
";

        $TakeOptions = '';
        while($Hangar = mysql_fetch_array($SQL_Query_Main)){

        if ($Hangar['h_ms_custom']){
                $MS_CFix = split('<!>',$Hangar['h_ms_custom']);
                $Hangar['msname'] = $MS_CFix[0];
                $Hangar['atf'] += $MS_CFix[1];
                $Hangar['def'] += $MS_CFix[2];
                $Hangar['ref'] += $MS_CFix[3];
                $Hangar['taf'] += $MS_CFix[4];
        }
        $TakeOptions .= "<option value='$Hangar[h_id]'>$Hangar[h_id]";
        echo "<tr align=center style=\"cursor: hand\" onClick=\"confirmTake('$Hangar[h_id]');\" onMouseOver=\"this.style.color='yellow'\" onMouseOut=\"this.style.color='white'\">";
        echo "<td>$Hangar[h_id]</td>";
        echo "<td>$Hangar[msname]</td>";
        echo "<td>$Hangar[atf]</td>";
        echo "<td>$Hangar[def]</td>";
        echo "<td>$Hangar[ref]</td>";
        echo "<td>$Hangar[taf]</td>";
        echo "<td>$Hangar[h_hp]</td>";
        echo "<td>$Hangar[h_hpmax]</td>";
        echo "<td>$Hangar[h_en]</td>";
        echo "<td>$Hangar[h_enmax]</td>";
        unset($I);
        $Eq_Listing = Array('A' => 'h_wepa','B' => 'h_wepb','C' => 'h_wepc','D' => 'h_eqwep','E' => 'h_p_equip');
        foreach($Eq_Listing as $I => $V){
                $H_Wep = 'H_Wep'.$I;
                $H_SyWep = 'H_SyWep'.$I;
                $W_Inf = 'W_Inf'.$I;
                if ($Hangar[$V] && $Hangar[$V] != '0<!>0') {
                        $$H_Wep = split('<!>',$Hangar[$V]);
                        GetWeaponDetails(${$H_Wep}[0],$H_SyWep);
                        if (${$H_Wep}[2]){
                                if (${$H_Wep}[2]==1) ${$H_SyWep}['name'] = ${$H_Wep}[3].${$H_SyWep}['name']."<sub>?</sub>";
                                else ${$H_SyWep}['name'] = ${$H_SyWep}['name'].${$H_Wep}[3]."<sub>?</sub>";
                                ${$H_SyWep}['atk'] += ${$H_Wep}[4];
                                ${$H_SyWep}['hit'] += ${$H_Wep}[5];
                                ${$H_SyWep}['rd'] += ${$H_Wep}[6];
                                ${$H_SyWep}['enc'] = ${$H_Wep}[7];
                        }
                        $$W_Inf = ${$H_SyWep}['name']."<br>經驗: ".${$H_Wep}[1]."<hr width=95%>能力:<br>";
                        $$W_Inf .= "　攻擊力: ".${$H_SyWep}['atk']."　　　回數: ".${$H_SyWep}['rd']."<br>　命中: ".${$H_SyWep}['hit']."　　　EN消費: ".${$H_SyWep}['enc']."<br>";
                        $$W_Inf .= "特殊效果:<br>";
                        if (${$H_SyWep}['equip']) $$W_Inf .= "可以裝備<br>";
                        if (${$H_SyWep}['spec']) $$W_Inf .= ReturnSpecs(${$H_SyWep}['spec']);
                        echo "<td OnMouseOver=\"setLayer(event.clientX,event.clientY,200,100,'\'".$$W_Inf."\'')\" OnMouseOut=\"offLayer()\">○</td>";
                }
                else echo "<td>╳</td>";
        }
        echo "</tr>";

        }
        if ($TakeOptions)
        echo "<tr><td colspan=15 align=center>取出機體: <select name=take_id>$TakeOptions</select> <input type=button onClick=confirmTake(hnmainform.take_id.value) value=\"取出\"></td></tr>";
        echo "</table>";
        echo "<hr width=85%>";
echo "</form>";
echo "<div id=wepinfo style=\"position:absolute; z-index:10;color: black;\" align=left></div>";
}//End GUI

else {echo "未定義動作！";}
postFooter();exit;
?>