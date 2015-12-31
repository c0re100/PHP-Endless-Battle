<?php
header('Content-Type: text/html; charset=utf-8');
$sql_gen = ("
SELECT `gen`.`username`, `password`, `color`, `msuit`, `typech`, `time2`, `coordinates`, `organization` , `hypermode`, `fame`
FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `gen`, `".$GLOBALS['DBPrefix']."phpeb_user_game_info` `game` 
WHERE `gen`.`username`=`game`.`username` AND `gen`.`username` != '$_SESSION[username]' 
AND        `msuit` != '0' AND `coordinates` = '$Pl_Gen[coordinates]' 
ORDER BY  `organization` DESC, `time2`  $torder,`rank` ASC
");


unset($torder);
$sql_gen_results = mysql_query ($sql_gen) or die ('出錯1, 原因:' . mysql_error() . '<br>');
$numofoppos=mysql_num_rows($sql_gen_results);

        echo "<table align=center border=\"3\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#7CCD7C\" width=\"650\">";
        echo "<form action=battle.php?action=attack_target method=post name=battle_sel_form>";
        echo "<input type=hidden value='process' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "<tr align=center><td colspan=8><b>對手列表: </b></td></tr>";
        echo "<tr align=center>";
        echo "<td width=\"20\">No.</td>";
        echo "<td width=\"150\">對手名稱</td>";
        echo "<td width=\"30\">等級</td>";
        echo "<td width=\"90\">類型</td>";
        echo "<td width=\"100\">機體</td>";
        echo "<td width=\"50\">狀態</td>";
        echo "<td width=\"30\">戰鬥</td>";
        echo "</tr>";
        echo "<script language=\"Javascript\">";
        echo "function cfmAtkOnline(){";
        echo "if (confirm('攻擊在線的玩家可能會有損您的名聲，真的要這樣做？')==true){return true}";
        echo "else {return false}";
        echo "}</script>";
        $mini_c=0;
        $war_c=0;
for ($counter=1;$counter<=$numofoppos;$counter++){
        unset($Op_Rank,$Op_Org,$Op_RightsTitle,$OrgWarOppos);
        $Op_Gen=mysql_fetch_array($sql_gen_results);
        $sql_game = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE username = '$Op_Gen[username]'");
        $sql_game_results = mysql_query ($sql_game) or die ('出錯2, 原因:' . mysql_error() . '<br>');
        $Op_Game = mysql_fetch_array($sql_game_results);
        if ($Op_Gen['msuit']){
        $Op_Repaired = AutoRepair("$Op_Gen[username]");
        $Op_Game['hp'] = $Op_Repaired['hp'];
        $Op_Game['en'] = $Op_Repaired['en'];
        $Op_Game['sp'] = $Op_Repaired['sp'];
        $Op_Game['status'] = $Op_Repaired['status'];}
        $Op_WepA = explode('<!>',$Op_Game['wepa']);

        if ($Op_WepA[0] && !$Op_Game['status']){
        GetWeaponDetails("$Op_WepA[0]",'Op_SyWepA');
        GetMsDetails("$Op_Gen[msuit]",'Op_Ms');
        $Op_Org = ReturnOrg($Op_Game['organization']);
        if ($Op_Game['organization'])
        $Op_Rank = ' '.rankConvert($Op_Game['rank']);
        if ($Op_Game['rights'] == '1'){$Op_RightsTitle = "<font style=\"color: yellow;font-weight: Bold;\"> ".$RightsClass['Major']."</font>";}
        elseif ($Op_Game['rights']){$Op_RightsTitle = "<font style=\"color: yellow;font-weight: Bold;\"> ".$RightsClass['Leader']."</font>";}
        $mini_c++;
        echo "<tr align=center style=\"color: $Op_Gen[color]\">";
        echo "<td width=\"20\">$mini_c</td>";
        echo "<td width=\"150\">";
        echo "$Op_Game[gamename]";
        echo " <font style=\"color: $Op_Org[color]\">($Op_Org[name])$Op_RightsTitle$Op_Rank";
        if ($Area_Org['id'] == $Op_Org['id'] && $AttackFort && $Op_Org['id']){echo "<font color='red'> [敵]</font>";$OrgWarOppos = '1';$war_c++;}
        elseif (ereg_replace('(Atk=\()|\)','',$Op_Org['optmissioni']) == $Pl_Gen['coordinates'] && $CFU_Time < $Op_Org['opttime'] && $Pl_Game['organization'] != '0' && $Area_Org['id'] == $Pl_Game['organization']){
        echo "<font color='red'> [敵]</font>";$OrgWarOppos = '1';}
        elseif ($Op_Org['optmissioni'] == $Pl_Org['optmissioni'] && $CFU_Time < $Op_Org['opttime'] && $CFU_Time < $Pl_Org['opttime'] && ereg_replace('(Atk=\()|\)','',$Op_Org['optmissioni']) == $Pl_Gen['coordinates']){
        echo "<font color='red'> [敵]</font>";$OrgWarOppos = '1';}
        echo "</font></td>";
        echo "<td width=\"30\">$Op_Game[level]</td>";
        $Op_Type=GetChType($Op_Gen['typech']);
        echo "<td width=\"70\">$Op_Type[name]";
        if ($Op_Gen['hypermode'] == 1 || $Op_Gen['hypermode'] == 5)
        echo "<br><font style=\"color: FFFF00;font-weight: bold\">SEED Mode</font>";
        if ($Op_Gen['hypermode'] >= 4 && $Op_Gen['hypermode'] <= 6)
        echo "<br><font style=\"color: FF0000;font-weight: bold\">EXAM Activated</font>";
        echo "</td>";
        if ($Op_Game['ms_custom']) $Op_CFix = explode('<!>',$Op_Game['ms_custom']);
        else $Op_CFix = array(0,0,0,0,0);
        if ($Op_CFix[0]) $Op_Ms['msname'] = $Op_CFix[0]."<sub>?</sub>";
        echo "<td><br><br><img src=\"".$Unit_Image_Dir."/$Op_Ms[image]\"><br></td>";
        if ($CFU_Time-$Op_Gen['time2'] < $Offline_Time){
                $OnlineStat = "<b style=\"color: red\">參戰中</b>";
                if (!$OrgWarOppos && $Op_Gen['fame'] >= 0 && $Pl_Gen['fame'] >= $NotoriousIgnore && $Pl_Settings['atkonline_alert'])
                $OnConfirm = ";return cfmAtkOnline()";
                else unset($OnConfirm);
        }
        else {$OnlineStat = '<font style="color: #11CFFF">休息中</font>';unset($OnConfirm);}
        echo "<td width=\"40\">$OnlineStat</td>";
        echo "<td width=\"30\">";
        echo "<input type=radio name=Op_Name value=\"$Op_Gen[username]\" onClick=\"location.replace('#StartBattle')$OnConfirm\"></td>";
        echo "</tr>";
                        }
        }
        if (!$Area_Org['id'])$war_c = 0;
        if ($mini_c == 0){echo "<tr align=center><td colspan=7 align=center>全部玩家也修理中或暫時沒有任何對手！</td></tr>";$DisAtkButton=' disabled';}
        if ($war_c == 0 && $AttackFort == 'True' && $Area["User"]["hp"] > 0){echo "<tr align=center><td colspan=6 align=center>可以攻擊要塞！</td>";
        echo "<td width=\"30\"><input type=radio name=Op_Name value=\"<AttackFort>\" onClick=\"location.replace('#StartBattle')\"></td></tr>";$DisAtkButton='';}
        echo "<tr align=right>";
        echo "<td width=\"100%\" colspan=7>";
        if(ereg('(EXAMSystem)+',$Pl_Game['spec'])){
        echo "開啟EXAM System<input type=checkbox name=EXAMStat";
        if($Pl_Gen['hypermode'] >= 4 && $Pl_Gen['hypermode'] <= 6) echo " checked";
        echo ">";
        }
        if($ControlSEED && ereg('(SeedMode)+',$Pl_Game['spec']) && ereg('(co|ext|nat)+',$Pl_Gen['typech'])){
        echo "進入SEED Mode<input type=checkbox name=SEEDStat";
        if($Pl_Gen['hypermode'] == 1 || $Pl_Gen['hypermode'] == 5) echo " checked";
        echo ">";
        }
        echo "以<select name=\"Pl_GTctcs\">";
        echo "<option value='0'>通常攻擊";
        if ($Pl_Game['tactics']){
        $Pl_TactList = explode("\n",$Pl_Game['tactics']);
        sort($Pl_TactList);
        foreach($Pl_TactList as $Tactics){
        $Tactics =trim($Tactics);
        $TactInf = GetTactics("$Tactics");
        if (($Pl_Gen['hypermode'] == 1 || $Pl_Gen['hypermode'] == 5) && $ControlSEED) $TactInf['spc'] = ceil($TactInf['spc'] * 1.25) + 5; //SEED Mode SP額外消耗
        if ($Pl_Gen['hypermode'] >= 4 && $Pl_Gen['hypermode'] <= 6) $TactInf['spc'] = ceil($TactInf['spc'] * 1.20) + 3; //EXAM System SP額外消耗
        if (!$Tactics) unset($Tactics);
                else{
                if ($Pl_Game['sp'] - $TactInf['spc'] < 0) unset($Tactics);
                elseif ($Pl_Game['en'] < ($Pl_SyWepA['enc']+$Pl_SyWepD['enc']+$Pl_SyWepE['enc']+$TactInf['enc'])) unset($Tactics);
                else {        echo "<option value='$Tactics'";
                        if ($Tactics == $Pl_Game['last_tact']) echo " selected";
                        echo ">$TactInf[name] (SP消耗: $TactInf[spc])";
                        }
                }
        }        
        }
        echo "</select>";
        echo "<a name=StartBattle>攻擊目標:</a> ";
        echo "<input type=submit $BStyleB style=\"$BStyleA\" name=battle_submit value='確定' OnClick=\"this.style.visibility='hidden';\"";
        echo $DisAtkButton;
        echo ">   ";
        echo "";
        echo "</td>";
        echo "</tr></form></table><br><br>";

?>