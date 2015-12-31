<?php
header('Content-Type: text/html; charset=utf-8');
$referer = $_SERVER['HTTP_REFERER'];
if (($CFU_Time - $Pl_Gen['btltime']) < $Btl_Intv) {
    echo '距離上次攻擊或移動的時間太短了！<br>請在 '.($Btl_Intv - ($CFU_Time - $Pl_Gen['btltime'])).' 秒後再進行攻擊！';
    exit;
} elseif ($mode == 'attack_target') {
    unset($AtkFortFlag);
    if (!$Op_Name) {
        echo '請先挑選對手！';
        exit;
    } elseif ($Op_Name == $_SESSION['username']) {
        echo '不能攻擊自己！';
        exit;
    } elseif ($Op_Name != '<AttackFort>') {
        GetUsrDetails("$Op_Name", 'Op_Gen', 'Op_Game');
        $Op_Settings_Query = ('SELECT `show_log_num` FROM `'.$GLOBALS['DBPrefix']."phpeb_user_settings` WHERE username='".$Op_Gen['username']."'");
        $Op_Settings = mysql_fetch_array(mysql_query($Op_Settings_Query));
    } elseif ($Op_Name == '<AttackFort>') {
        if ($AttackFort != 'True' || $CFU_Time < $Pl_Org['optstart'] || $Area['User']['hp'] <= 0) {
            echo '不能攻擊要塞';
            postFooter();
            exit;
        }
        $AtkFortFlag = '1';
        $Op_Gen = array('username' => '<AttackFort>','color' => "$Area_Org[color]",'msuit' => '<AttackFort>',
        'typech' => 'nat1','coordinates' => "$Pl_Gen[coordinates]",'fame' => '0','time2' => '0', );
        $Op_Game = array('username' => '<AttackFort>','gamename' => '防禦要塞','hp' => $Area['User']['hp']*10,
        'hpmax' => $Area['User']['hpmax']*10,'en' => '100000','enmax' => '100000','attacking' => "$Area_At",
        'defending' => "$Area_De",'reacting' => '0','targeting' => "$Area_Ta",'level' => '500',
        'expr' => '0','wepa' => $Area['User']['wepa'].'<!>25000','eqwep' => '','rank' => '100000',
        'rights' => '1','organization' => "$Area_Org[id]",'status' => '0',
        'tactics' => "DefCounterA\nTripleStrike\nMindStrike\nFirstStrike\nSenseStrike", );
    }

	if (ereg('(NPC)+',$Op_Game['gamename'])){
		if(($Op_Game['level']-$Pl_Game['level']) > 100){
        echo '您的等級不能小於NPC的等級！';
        postFooter();
        exit;
		}
    }
	
    if ($Op_Game['status']) {
        echo '對手修理中．．';
        postFooter();
        exit;
    }
    if ($Pl_Game['status']) {
        echo '修理中，無法出擊。';
        postFooter();
        exit;
    }

    if ($Op_Gen['coordinates'] != $Pl_Gen['coordinates']) {
        echo "看不見對手．．<br>對方位置: $Op_Gen[coordinates] 自己位置: $Pl_Gen[coordinates]";
        postFooter();
        exit;
    }

    $Op_Org = ReturnOrg($Op_Game['organization']);

    $Op_LocalOrgFlag = 0;
    if ($Op_Org == $Area_Org) {
        $Op_LocalOrgFlag = 1;
    }

    $Pl_Tactics = GetTactics($Pl_GTctcs);
    $Pl_Game['tactics'] = explode("\n", $Pl_Game['tactics']);
    sort($Pl_Game['tactics']);
    $Pl_Game['tactics'] = implode("\n", $Pl_Game['tactics']);
    $Pl_Game['tactics'] = trim($Pl_Game['tactics']);

    $Op_Tact_Cache = explode("\n", $Op_Game['tactics']);
    sort($Op_Tact_Cache);
    $Op_Game['tactics'] = implode("\n", $Op_Tact_Cache);
    trim($Op_Tact_Cache);
    $Op_Tact_Cache = explode("\n", $Op_Game['tactics']);
    $Op_Tact_Use = mt_rand(0, count($Op_Tact_Cache));
    $Op_Tact = trim($Op_Tact_Cache[$Op_Tact_Use]);
    if ($Op_Tact) {
        $Op_Tactics = GetTactics("$Op_Tact");
    } else {
        $Op_Tactics = GetTactics('0');
    }

    $Pl_SyWepA['enc'] += $Pl_Tactics['enc'];
    $SP_Cost = $Pl_Tactics['spc'];
    if (($Pl_Gen['hypermode'] == 1 || $Pl_Gen['hypermode'] == 5) && $ControlSEED) {
        $SP_Cost = ceil($SP_Cost * 1.25) + 5;
    }        //SEED Mode SP額外消耗
        if ($Pl_Gen['hypermode'] >= 4 && $Pl_Gen['hypermode'] <= 6) {
            $SP_Cost = ceil($SP_Cost * 1.20) + 3;
        }                        //EXAM System SP額外消耗
        $SP_CostOP = 0;
    $Op_Type = GetChType($Op_Gen['typech']);
    $Pl_Type = GetChType($Pl_Gen['typech']);

    if ($Pl_Game['level'] >= 70) {
        if ($Pl_Gen['hypermode'] == 0) {
            if (ereg('(nt|enh)+', $Pl_Type['id'])) {
                $Pl_Gen['hypermode'] = 2;
            }
            if (ereg('(psy)+', $Pl_Type['id'])) {
                $Pl_Gen['hypermode'] = 3;
            }
        } elseif ($Pl_Gen['hypermode'] == 4 && ereg('(enh)+', $Pl_Type['id'])) {
            $Pl_Gen['hypermode'] = 6;
        }
    }
    GetMsDetails("$Pl_Gen[msuit]", 'Pl_Ms');
    $Pl_WepA = explode('<!>', $Pl_Game['wepa']);
    $Pl_WepD = explode('<!>', $Pl_Game['eqwep']);
    $Pl_WepE = explode('<!>', $Pl_Game['p_equip']);

        //MS Status Modifications - Player
        if ($Pl_Game['ms_custom']) {
            $Pl_CFix = explode('<!>', $Pl_Game['ms_custom']);
        } else {
            $Pl_CFix = array(0,0,0,0,0);
        }
    if ($Pl_CFix[0]) {
        $Pl_Ms['msname'] = $Pl_CFix[0].'<sub>?</sub>';
    }
    $Pl_Ms['atf'] += $Pl_CFix[1];
    $Pl_Ms['def'] += $Pl_CFix[2];
    $Pl_Ms['ref'] += $Pl_CFix[3];
    $Pl_Ms['taf'] += $Pl_CFix[4];

    GetWeaponDetails("$Pl_WepA[0]", 'Pl_SyWepA');
    if ($Pl_WepA[2]) {
        if ($Pl_WepA[2] == 1) {
            $Pl_SyWepA['name'] = $Pl_WepA[3].$Pl_SyWepA['name'].'<sub>?</sub>';
        } else {
            $Pl_SyWepA['name'] = $Pl_SyWepA['name'].$Pl_WepA[3].'<sub>?</sub>';
        }
        $Pl_SyWepA['atk'] += $Pl_WepA[4];
        $Pl_SyWepA['hit'] += $Pl_WepA[5];
        $Pl_SyWepA['rd'] += $Pl_WepA[6];
        $Pl_SyWepA['enc'] = $Pl_WepA[7];
    }

    GetWeaponDetails("$Pl_WepD[0]", 'Pl_SyWepD');
    if ($Pl_WepD[2]) {
        if ($Pl_WepD[2] == 1) {
            $Pl_SyWepD['name'] = $Pl_WepD[3].$Pl_SyWepD['name'].'<sub>?</sub>';
        } else {
            $Pl_SyWepD['name'] = $Pl_SyWepD['name'].$Pl_WepD[3].'<sub>?</sub>';
        }
        $Pl_SyWepD['atk'] += $Pl_WepD[4];
        $Pl_SyWepD['hit'] += $Pl_WepD[5];
        $Pl_SyWepD['rd'] += $Pl_WepD[6];
        $Pl_SyWepD['enc'] = $Pl_WepD[7];
        unset($a);
        if (ereg('(CostSP)+', $Pl_SyWepD['spec'])) {
            $a = ereg_replace('.*CostSP<', '', $Pl_SyWepD['spec']);
            $a = intval($a);
            $SP_Cost += $a;
        }
    }

    GetWeaponDetails("$Pl_WepE[0]", 'Pl_SyWepE');
    if ($Pl_WepE[2]) {
        if ($Pl_WepE[2] == 1) {
            $Pl_SyWepE['name'] = $Pl_WepE[3].$Pl_SyWepE['name'].'<sub>?</sub>';
        } else {
            $Pl_SyWepE['name'] = $Pl_SyWepE['name'].$Pl_WepE[3].'<sub>?</sub>';
        }
        $Pl_SyWepE['atk'] += $Pl_WepE[4];
        $Pl_SyWepE['hit'] += $Pl_WepE[5];
        $Pl_SyWepE['rd'] += $Pl_WepE[6];
        $Pl_SyWepE['enc'] = $Pl_WepE[7];
        unset($a);
        if (ereg('(CostSP)+', $Pl_SyWepE['spec'])) {
            $a = ereg_replace('.*CostSP<', '', $Pl_SyWepE['spec']);
            $a = intval($a);
            $SP_Cost += $a;
        }
    }

    unset($a);
    if (ereg('(CostSP)+', $Pl_SyWepA['spec'])) {
        $a = ereg_replace('.*CostSP<', '', $Pl_SyWepA['spec']);
        $a = intval($a);
        $SP_Cost += $a;
    }
    if (ereg('(CostSP)+', $Op_SyWepA['spec'])) {
        $a = ereg_replace('.*CostSP<', '', $Pl_SyWepA['spec']);
        $a = intval($a);
        $SP_CostOP += ceil($a * 0.5);
    }
    unset($a);

    if ($Pl_Tactics['spec'] == 'AllWepStirke') {
        $Pl_WepB = explode('<!>', $Pl_Game['wepb']);
        GetWeaponDetails("$Pl_WepB[0]", 'Pl_SyWepB');
        $Pl_WepC = explode('<!>', $Pl_Game['wepc']);
        GetWeaponDetails("$Pl_WepC[0]", 'Pl_SyWepC');
    }

    if ($AtkFortFlag != '1') {
        GetMsDetails("$Op_Gen[msuit]", 'Op_Ms');
    } else {
        $Op_Ms = array('msname' => "$Pl_Gen[coordinates]區域要塞",'atf' => '0','def' => '0','ref' => '0','taf' => '0',
        'spec' => 'AntiDam','image' => 'fortress.gif', );
    }

        //MS Status Modifications - Opponent
        if ($Op_Game['ms_custom']) {
            $Op_CFix = explode('<!>', $Op_Game['ms_custom']);
        } else {
            $Op_CFix = array(0,0,0,0,0);
        }
    if ($Op_CFix[0]) {
        $Op_Ms['msname'] = $Op_CFix[0].'<sub>?</sub>';
    }
    $Op_Ms['atf'] += $Op_CFix[1];
    $Op_Ms['def'] += $Op_CFix[2];
    $Op_Ms['ref'] += $Op_CFix[3];
    $Op_Ms['taf'] += $Op_CFix[4];

    $Op_WepA = explode('<!>', $Op_Game['wepa']);
    $Op_WepD = explode('<!>', $Op_Game['eqwep']);
    $Op_WepE = explode('<!>', $Op_Game['p_equip']);
    GetWeaponDetails("$Op_WepA[0]", 'Op_SyWepA');
    if ($Op_WepA[2]) {
        if ($Op_WepA[2] == 1) {
            $Op_SyWepA['name'] = $Op_WepA[3].$Op_SyWepA['name'].'<sub>?</sub>';
        } else {
            $Op_SyWepA['name'] = $Op_SyWepA['name'].$Op_WepA[3].'<sub>?</sub>';
        }
        $Op_SyWepA['atk'] += $Op_WepA[4];
        $Op_SyWepA['hit'] += $Op_WepA[5];
        $Op_SyWepA['rd'] += $Op_WepA[6];
        $Op_SyWepA['enc'] = $Op_WepA[7];
    }
    GetWeaponDetails("$Op_WepD[0]", 'Op_SyWepD');
    if ($Op_WepD[2]) {
        if ($Op_WepD[2] == 1) {
            $Op_SyWepD['name'] = $Op_WepD[3].$Op_SyWepD['name'].'<sub>?</sub>';
        } else {
            $Op_SyWepD['name'] = $Op_SyWepD['name'].$Op_WepD[3].'<sub>?</sub>';
        }
        $Op_SyWepD['atk'] += $Op_WepD[4];
        $Op_SyWepD['hit'] += $Op_WepD[5];
        $Op_SyWepD['rd'] += $Op_WepD[6];
        $Op_SyWepD['enc'] = $Op_WepD[7];
        if (ereg('(CostSP)+', $Op_SyWepD['spec'])) {
            $a = ereg_replace('.*CostSP<', '', $Op_SyWepD['spec']);
            $a = intval($a);
            $SP_CostOP += ceil($a * 0.5);
        }
        unset($a);
    }
    GetWeaponDetails("$Op_WepE[0]", 'Op_SyWepE');
    if ($Op_WepE[2]) {
        if ($Op_WepE[2] == 1) {
            $Op_SyWepE['name'] = $Op_WepE[3].$Op_SyWepE['name'].'<sub>?</sub>';
        } else {
            $Op_SyWepE['name'] = $Op_SyWepE['name'].$Op_WepE[3].'<sub>?</sub>';
        }
        $Op_SyWepE['atk'] += $Op_WepE[4];
        $Op_SyWepE['hit'] += $Op_WepE[5];
        $Op_SyWepE['rd'] += $Op_WepE[6];
        $Op_SyWepE['enc'] = $Op_WepE[7];
        if (ereg('(CostSP)+', $Op_SyWepE['spec'])) {
            $a = ereg_replace('.*CostSP<', '', $Op_SyWepE['spec']);
            $a = intval($a);
            $SP_CostOP += ceil($a * 0.5);
        }
        unset($a);
    }
    if ($Op_Tactics['spec'] == 'AllWepStirke') {
        $Op_WepB = explode('<!>', $Op_Game['wepb']);
        GetWeaponDetails("$Op_WepB[0]", 'Op_SyWepB');
        $Op_WepC = explode('<!>', $Op_Game['wepc']);
        GetWeaponDetails("$Op_WepC[0]", 'Op_SyWepC');
    }

    if (ereg('(DoubleStrike)+', $Pl_Tactics['spec'])) {
        $Pl_SyWepA['enc'] *= 2;
    }
    if (ereg('(TripleStrike)+', $Pl_Tactics['spec'])) {
        $Pl_SyWepA['enc'] *= 3;
    }

    if (ereg('(DoubleStrike)+', $Op_Tactics['spec'])) {
        $Op_SyWepA['enc'] *= 2;
    }
    if (ereg('(TripleStrike)+', $Op_Tactics['spec'])) {
        $Op_SyWepA['enc'] *= 3;
    }

    if (!$Pl_WepA[0]) {
        echo '你沒有裝備武器，不能出擊。';
        postFooter();
        exit;
    } elseif ($Pl_Game['en'] < ($Pl_SyWepA['enc'] + $Pl_SyWepD['enc'])) {
        echo 'EN不足，無法出擊。';
        postFooter();
        exit;
    } elseif ($Pl_Game['sp'] < $SP_Cost) {
        echo "SP不足，無法以 $Pl_Tactics[name] 出擊。";
        postFooter();
        exit;
    } elseif (!$Pl_Tactics['name']) {
        echo '不明的戰術。';
        postFooter();
        exit;
    }
        //Specs - Type Customs
        if (ereg('(NTCustom)+', $Pl_SyWepA['spec'])) {
            if (!ereg('(nt|enh)+', $Pl_Type['id'])) {
                $Pl_SyWepA['atk'] = 0;
                $Pl_SyWepA['rd'] = 1;
                $Pl_SyWepA['spec'] = 'NTCustom';
            }
        }
    if (ereg('(NTRequired)+', $Pl_SyWepA['spec'])) {
        if (ereg('(nt|enh)+', $Pl_Type['id'])) {
            $Pl_SyWepA['atk'] *= 1;
        } else {
            $Pl_SyWepA['atk'] *= 0.5;
        }
    }
    if (ereg('(COCustom)+', $Pl_SyWepA['spec'])) {
        if (!ereg('(co|ext)+', $Pl_Type['id'])) {
            $Pl_SyWepA['atk'] = 0;
            $Pl_SyWepA['rd'] = 1;
        }
    }
    if (ereg('(PsyRequired)+', $Pl_SyWepA['spec'])) {
        if (!ereg('(psy)+', $Pl_Type['id'])) {
            $Pl_SyWepA['atk'] = 0;
            $Pl_SyWepA['rd'] = 1;
            $Pl_SyWepA['spec'] = 'PsyRequired';
        }
    }
    if (ereg('(NTCustom)+', $Op_SyWepA['spec'])) {
        if (!ereg('(nt|enh)+', $Op_Type['id'])) {
            $Op_SyWepA['atk'] = 0;
            $Op_SyWepA['rd'] = 1;
            $Op_SyWepA['spec'] = 'NTCustom';
        }
    }
    if (ereg('(NTRequired)+', $Op_SyWepA['spec'])) {
        if (ereg('(nt|enh)+', $Op_Type['id'])) {
            $Op_SyWepA['atk'] *= 1;
        } else {
            $Op_SyWepA['atk'] *= 0.5;
        }
    }
    if (ereg('(COCustom)+', $Op_SyWepA['spec'])) {
        if (!ereg('(co|ext)+', $Op_Type['id'])) {
            $Op_SyWepA['atk'] = 0;
            $Op_SyWepA['rd'] = 1;
            $Op_SyWepA['spec'] = 'COCustom';
        }
    }
    if (ereg('(PsyRequired)+', $Op_SyWepA['spec'])) {
        if (!ereg('(psy)+', $Op_Type['id'])) {
            $Op_SyWepA['atk'] = 0;
            $Op_SyWepA['rd'] = 1;
            $Op_SyWepA['spec'] = 'PsyRequired';
        }
    }
        //Specs For Equipments - Type Customs
        if (ereg('(NTCustom|NTRequired)+', $Pl_SyWepD['spec'])) {
            if (!ereg('(nt|enh)+', $Pl_Type['id'])) {
                unset($Pl_SyWepD['spec']);
            }
        }
    if (ereg('(COCustom)+', $Pl_SyWepD['spec'])) {
        if (!ereg('(co|ext)+', $Pl_Type['id'])) {
            unset($Pl_SyWepD['spec']);
        }
    }
    if (ereg('(PsyRequired)+', $Pl_SyWepD['spec'])) {
        if (!ereg('(psy)+', $Pl_Type['id'])) {
            unset($Pl_SyWepD['spec']);
        }
    }
    if (ereg('(NTCustom|NTRequired)+', $Pl_SyWepE['spec'])) {
        if (!ereg('(nt|enh)+', $Pl_Type['id'])) {
            unset($Pl_SyWepE['spec']);
        }
    }
    if (ereg('(COCustom)+', $Pl_SyWepE['spec'])) {
        if (!ereg('(co|ext)+', $Pl_Type['id'])) {
            unset($Pl_SyWepE['spec']);
        }
    }
    if (ereg('(PsyRequired)+', $Pl_SyWepE['spec'])) {
        if (!ereg('(psy)+', $Pl_Type['id'])) {
            unset($Pl_SyWepE['spec']);
        }
    }
        ///For OP
        if (ereg('(NTCustom|NTRequired)+', $Op_SyWepD['spec'])) {
            if (!ereg('(nt|enh)+', $Op_Type['id'])) {
                unset($Op_SyWepD['spec']);
            }
        }
    if (ereg('(COCustom)+', $Op_SyWepD['spec'])) {
        if (!ereg('(co|ext)+', $Op_Type['id'])) {
            unset($Op_SyWepD['spec']);
        }
    }
    if (ereg('(PsyRequired)+', $Op_SyWepD['spec'])) {
        if (!ereg('(psy)+', $Op_Type['id'])) {
            unset($Op_SyWepD['spec']);
        }
    }
    if (ereg('(NTCustom|NTRequired)+', $Op_SyWepE['spec'])) {
        if (!ereg('(nt|enh)+', $Op_Type['id'])) {
            unset($Op_SyWepE['spec']);
        }
    }
    if (ereg('(COCustom)+', $Op_SyWepE['spec'])) {
        if (!ereg('(co|ext)+', $Op_Type['id'])) {
            unset($Op_SyWepE['spec']);
        }
    }
    if (ereg('(PsyRequired)+', $Op_SyWepE['spec'])) {
        if (!ereg('(psy)+', $Op_Type['id'])) {
            unset($Op_SyWepE['spec']);
        }
    }
        //End of Type Spec Customs
        //Start Battle

        echo "<table width=70% border='0' style=\"border-collapse: collapse\" align=center style=\"font-size: 12pt;font-family: Comic Sans MS;\" cellspacing=0 cellpadding=0>";

    echo '</tr>';
    echo '<tr valign=center align=center>';
    echo '<td><br><br><img src="'.$Unit_Image_Dir."/$Pl_Ms[image]\"><br></td>";
    echo '<td><br><br><img src="'.$Unit_Image_Dir."/$Op_Ms[image]\"><br></td>";
    echo '<tr valign=center align=center>';
    echo "<td  width=20%><font face=\"Comic Sans MS\" style=\"font-size: 18pt;\"><b>$Pl_Game[gamename]</b></font></td>";
    echo "<td  width=20%><font face=\"Comic Sans MS\" style=\"font-size: 18pt;\"><b>$Op_Game[gamename]</b></font></td>";
    echo '</tr>';
    echo '<tr valign=center align=center>';
    echo "<td><br>機體:$Pl_Ms[msname]<br></td>";
    echo "<td><br>機體:$Op_Ms[msname]<br></td>";
    echo '</tr>';
        //Include Functions
                include 'battle_function.php';
        //Generate Special Ability Pool
                $Pl_Spec = $Pl_Game['spec']."\n".$Pl_Ms['spec']."\n".$Pl_SyWepA['spec']."\n".$Pl_Tactics['spec'];
    if ($Pl_SyWepD['spec']) {
        $Pl_Spec .= "\n".$Pl_SyWepD['spec'];
    }
    if ($Pl_SyWepE['spec']) {
        $Pl_Spec .= "\n".$Pl_SyWepE['spec'];
    }
    if ($Pl_Tactics['spec'] == 'AllWepStirke') {
        $Pl_Spec .= "\n".$Pl_SyWepB['spec']."\n".$Pl_SyWepC['spec'];
    }
    $Op_Spec = $Op_Game['spec']."\n".$Op_Ms['spec']."\n".$Op_SyWepA['spec']."\n".$Op_Tactics['spec'];
    if ($Op_SyWepD['spec']) {
        $Op_Spec .= "\n".$Op_SyWepD['spec'];
    }
    if ($Op_SyWepE['spec']) {
        $Op_Spec .= "\n".$Op_SyWepE['spec'];
    }
    if ($Op_Tactics['spec'] == 'AllWepStirke') {
        $Op_Spec .= "\n".$Op_SyWepB['spec']."\n".$Op_SyWepC['spec'];
    }
        //SEED Mode
                $Pl_SEED = 0;
    $Op_SEED = 0;
                //Determine SEED
                if (ereg('(SeedMode)+', $Pl_Game['spec'])) {
                    $Pl_SEED = 1;
                } elseif (ereg('(SeedMode)+', $Pl_Spec)) {
                    $Pl_SEED = 2;
                }
    if (ereg('(SeedMode)+', $Op_Game['spec'])) {
        $Op_SEED = 1;
    } elseif (ereg('(SeedMode)+', $Op_Spec)) {
        $Op_SEED = 2;
    }
                //Analyze SEED Mode End - Non-Controlled Start
                        if (!$ControlSEED) {
                            unset($Pl_PercentageSEED, $Op_PercentageSEED);
                            if ($Pl_Gen['hypermode'] == 1) {
                                if ($Pl_SEED != 0 && $Pl_Game['hp'] / $Pl_Game['hpmax'] <= 0.5 && $Pl_Game['sp'] / $Pl_Game['spmax'] >= 0.95) {
                                    $Pl_PercentageSEED = 5;
                                } elseif ($Pl_SEED == 0) {
                                    $Pl_PercentageSEED = 100;
                                } else {
                                    $Pl_PercentageSEED = 25;
                                }
                                if (mt_rand(0, 100) <= $Pl_PercentageSEED) {
                                    $Pl_Gen['hypermode'] = 0;
                                }
                            }
                            if ($Op_Gen['hypermode'] == 1) {
                                if ($Op_SEED != 0 && $Op_Game['hp'] / $Op_Game['hpmax'] <= 0.5 && $Op_Game['sp'] / $Op_Game['spmax'] >= 0.95) {
                                    $Op_PercentageSEED = 5;
                                } elseif ($Op_SEED == 0) {
                                    $Op_PercentageSEED = 100;
                                } else {
                                    $Op_PercentageSEED = 25;
                                }
                                if (mt_rand(0, 100) <= $Op_PercentageSEED) {
                                    $Op_Gen['hypermode'] = 0;
                                }
                            }
                        }
                //Analyze SEED Mode Start - Non-Controlled Start
                        if (!$ControlSEED) {
                            unset($Pl_PercentageSEED, $Op_PercentageSEED);
                                //Player
                                if (ereg('(co|ext|nat)+', $Pl_Type['id'])) {
                                    if ($Pl_SEED == 2 && $Pl_Game['hp'] / $Pl_Game['hpmax'] <= 0.8 && $Pl_Game['sp'] / $Pl_Game['spmax'] >= 0.7) {
                                        $Pl_PercentageSEED = ceil($Pl_Game['level'] / 10);
                                        if (ereg('(co)+', $Pl_Type['id'])) {
                                            $Pl_PercentageSEED *= 3;
                                        } elseif (ereg('(ext)+', $Pl_Type['id'])) {
                                            $Pl_PercentageSEED *= 2;
                                        }
                                        if ($Pl_Game['hp'] / $Pl_Game['hpmax'] <= 0.3) {
                                            $Pl_PercentageSEED *= 2;
                                        }
                                        if ($Pl_Game['sp'] / $Pl_Game['spmax'] == 1) {
                                            $Pl_PercentageSEED *= 1.5;
                                        }
                                        if (mt_rand(0, 1000) <= $Pl_PercentageSEED) {
                                            $Pl_Gen['hypermode'] = 1;
                                            $Pl_Game['spec'] .= 'SeedMode, ';
                                        }
                                    } elseif ($Pl_SEED == 1) {
                                        if ($Pl_Game['hp'] / $Pl_Game['hpmax'] <= 0.5 && $Pl_Game['sp'] / $Pl_Game['spmax'] >= 0.7) {
                                            $Pl_PercentageSEED = 50;
                                        } else {
                                            $Pl_PercentageSEED = 15 + ceil($Pl_Game['level'] / 20);
                                        }
                                        if ($Pl_Game['hp'] / $Pl_Game['hpmax'] <= 0.3) {
                                            $Pl_PercentageSEED += 20;
                                        }
                                        if ($Pl_Game['sp'] / $Pl_Game['spmax'] == 1) {
                                            $Pl_PercentageSEED += 10;
                                        }
                                        if (mt_rand(0, 100) <= $Pl_PercentageSEED) {
                                            $Pl_Gen['hypermode'] = 1;
                                        }
                                    }
                                }
                                //Opponent
                                if (ereg('(co|ext|nat)+', $Op_Type['id'])) {
                                    if ($Op_SEED == 2 && $Op_Game['hp'] / $Op_Game['hpmax'] <= 0.8 && $Op_Game['sp'] / $Op_Game['spmax'] >= 0.7) {
                                        $Op_PercentageSEED = ceil($Op_Game['level'] / 10);
                                        if (ereg('(co)+', $Op_Type['id'])) {
                                            $Op_PercentageSEED *= 3;
                                        } elseif (ereg('(ext)+', $Op_Type['id'])) {
                                            $Op_PercentageSEED *= 2;
                                        }
                                        if (mt_rand(0, 2000) <= $Op_PercentageSEED) {
                                            $Op_Gen['hypermode'] = 1;
                                            $Op_Game['spec'] .= 'SeedMode, ';
                                        }
                                    } elseif ($Op_SEED == 1) {
                                        if ($Op_Game['hp'] / $Op_Game['hpmax'] <= 0.5 && $Op_Game['sp'] / $Op_Game['spmax'] >= 0.7) {
                                            $Op_PercentageSEED = 50;
                                        } else {
                                            $Op_PercentageSEED = 10 + ceil($Op_Game['level'] / 20);
                                        }
                                        if (mt_rand(0, 100) <= $Op_PercentageSEED) {
                                            $Op_Gen['hypermode'] = 1;
                                        }
                                    }
                                }
                        }
    unset($Pl_PercentageSEED, $Op_PercentageSEED);

                //Analyze SEED Mode - Controlled Start
                $Op_NewSeed = 0;
    if ($ControlSEED) {
        if (ereg('(co|ext|nat)+', $Pl_Type['id']) && $Pl_SEED) {
            if ($Pl_SEED == 2 && $Pl_Game['hp'] / $Pl_Game['hpmax'] <= 0.75 && $Pl_Game['sp'] / $Pl_Game['spmax'] >= 0.85) {
                $Pl_PercentageSEED = ceil($Pl_Game['level'] / 10);
                if (ereg('(co)+', $Pl_Type['id'])) {
                    $Pl_PercentageSEED *= 3;
                } elseif (ereg('(ext)+', $Pl_Type['id'])) {
                    $Pl_PercentageSEED *= 2;
                }
                if ($Pl_Game['hp'] / $Pl_Game['hpmax'] <= 0.3) {
                    $Pl_PercentageSEED *= 2;
                }
                if ($Pl_Game['sp'] / $Pl_Game['spmax'] == 1) {
                    $Pl_PercentageSEED *= 1.5;
                }
                if (mt_rand(0, 1000) <= $Pl_PercentageSEED) {
                    $Pl_Gen['hypermode'] = 1;
                    $Pl_Game['spec'] .= 'SeedMode, ';
                }
            }
            if ($Pl_SEED == 1 && $SEEDStat == true && $Pl_Game['sp'] / $Pl_Game['spmax'] >= 0.15 && $Pl_Game['sp'] >= 10) {
                $Pl_Gen['hypermode'] = 1;
            } else {
                $Pl_Gen['hypermode'] = 0;
            }
        }
        if (ereg('(co|ext|nat)+', $Op_Type['id']) && $Op_SEED) {
            if ($Op_SEED == 2 && $Op_Game['hp'] / $Op_Game['hpmax'] <= 0.75 && $Op_Game['sp'] / $Op_Game['spmax'] >= 0.85) {
                $Op_PercentageSEED = ceil($Op_Game['level'] / 10);
                if (ereg('(co)+', $Op_Type['id'])) {
                    $Op_PercentageSEED *= 3;
                } elseif (ereg('(ext)+', $Op_Type['id'])) {
                    $Op_PercentageSEED *= 2;
                }
                if ($Op_Game['hp'] / $Op_Game['hpmax'] <= 0.3) {
                    $Op_PercentageSEED *= 2;
                }
                if ($Op_Game['sp'] / $Op_Game['spmax'] == 1) {
                    $Op_PercentageSEED *= 1.5;
                }
                if (mt_rand(0, 2000) <= $Op_PercentageSEED) {
                    $Op_Gen['hypermode'] = 1;
                    $Op_Game['spec'] .= 'SeedMode, ';
                    $Op_NewSeed = 1;
                }
            }
            if ($Op_Game['sp'] / $Op_Game['spmax'] < 0.15 && $Op_Game['sp'] < 10) {
                $Op_Gen['hypermode'] = 0;
            }
        }
        unset($Pl_PercentageSEED, $Op_PercentageSEED);

                                //Lose SEED
                                if (!ereg('(co|ext|nat)+', $Pl_Type['id']) && $Pl_SEED == 1) {
                                    $Pl_Game['spec'] = str_replace('SeedMode, ', '', $Pl_Game['spec']);
                                }
        if (!ereg('(co|ext|nat)+', $Op_Type['id']) && $Op_SEED == 1) {
            $Op_Game['spec'] = str_replace('SeedMode, ', '', $Op_Game['spec']);
        }
    }

        //EXAM System
                //Activation
                if (ereg('(EXAMSystem)+', $Pl_Game['spec']) && $EXAMStat == true && $Pl_Game['sp'] >= 10 || ereg('(EXAMSystem)+', $Pl_Ms['spec'])) {
                    //With SEED
                        if ($Pl_Gen['hypermode'] == 1 || $Pl_Gen['hypermode'] == 5) {
                            $Pl_Gen['hypermode'] = 5;
                        }
                        //With NT Hypermode
                        elseif ($Pl_Gen['hypermode'] == 2 || $Pl_Gen['hypermode'] == 6) {
                            $Pl_Gen['hypermode'] = 6;
                        }
                        //EXAM Only
                        elseif ($Pl_Gen['hypermode'] == 0) {
                            $Pl_Gen['hypermode'] = 4;
                        }
                }
                //Deactivation
                if (($Pl_Game['sp'] < 10) ||
                        $EXAMStat == false ||
                        (
                                !ereg('(EXAMSystem)+', $Pl_SyWepD['spec']) &&
                                !ereg('(EXAMSystem)+', $Pl_SyWepE['spec']) &&
                                !ereg('(EXAMSystem)+', $Pl_Ms['spec'])
                        )
                ) {
                    //With EXAM Only
                        if ($Pl_Gen['hypermode'] == 4) {
                            $Pl_Gen['hypermode'] = 0;
                        }
                        //With SEED Only
                        elseif ($Pl_Gen['hypermode'] == 5) {
                            $Pl_Gen['hypermode'] = 1;
                        }
                        //With NT Hypermode Only
                        elseif ($Pl_Gen['hypermode'] == 6) {
                            $Pl_Gen['hypermode'] = 2;
                        }
                }
				//EXAM Re-Activation
				if(ereg('(EXAMSystem)+', $Pl_Ms['spec'])){
					$Pl_Gen['hypermode'] = 6;
				}
                //Status Modification
                        //Player
                        if ($Pl_Gen['hypermode'] >= 4 && $Pl_Gen['hypermode'] <= 6) {
                            //Natural
                                if (ereg('(nat|co)+', $Pl_Type['id'])) {
                                    $Pl_Game['attacking'] += 10;
                                    $Pl_Game['defending'] += 10;
                                    $Pl_Game['reacting'] += 10;
                                    $Pl_Game['targeting'] += 10;
                                }
                                //Enhanced
                                elseif (ereg('(enh|nt)+', $Pl_Type['id'])) {
                                    $Pl_Game['attacking'] += 8;
                                    $Pl_Game['defending'] += 5;
                                    $Pl_Game['reacting'] += 7;
                                    $Pl_Game['targeting'] += 10;
                                }
                                //Extended
                                elseif (ereg('(ext|psy)+', $Pl_Type['id'])) {
                                    $Pl_Game['attacking'] += 10;
									$Pl_Game['defending'] += 7;
                                    $Pl_Game['reacting'] += 8;
                                    $Pl_Game['targeting'] += 7;
                                }
                        }
                        //Opponent
                        if ($Op_Gen['hypermode'] >= 4 && $Op_Gen['hypermode'] <= 6) {
                            //Natural
                                if (ereg('(nat|co)+', $Op_Type['id'])) {
                                    $Op_Game['attacking'] += 10;
                                    $Op_Game['defending'] += 10;
                                    $Op_Game['reacting'] += 10;
                                    $Op_Game['targeting'] += 10;
                                }
                                //Enhanced
                                elseif (ereg('(enh|nt)+', $Op_Type['id'])) {
                                    $Op_Game['attacking'] += 8;
                                    $Op_Game['defending'] += 5;
                                    $Op_Game['reacting'] += 7;
                                    $Op_Game['targeting'] += 10;
                                }
                                //Extended
                                elseif (ereg('(ext|psy)+', $Op_Type['id'])) {
                                    $Op_Game['attacking'] += 10;
									$Op_Game['defending'] += 7;
                                    $Op_Game['reacting'] += 8;
                                    $Op_Game['targeting'] += 7;
                                }
                        }
				//EXAM Deactivation
				if(!ereg('(EXAMSystem)+', $Pl_Ms['spec'])){
					$Pl_Gen['hypermode'] = 0;
				}
						
				//EVA Mode Activation
				if(ereg('(EVASystem)+', $Pl_Ms['spec'])){
					$Pl_Gen['evamode'] = 1;
				}
				//Status Modification
                        //Player
                        if ($Pl_Gen['evamode'] == 1) {
                            //Natural
                                if (ereg('(nat|co)+', $Pl_Type['id'])) {
                                    $Pl_Game['attacking'] += 15;
                                    $Pl_Game['defending'] += 15;
                                    $Pl_Game['reacting'] += 15;
                                    $Pl_Game['targeting'] += 15;
                                }
                                //Enhanced
                                elseif (ereg('(enh|nt)+', $Pl_Type['id'])) {
                                    $Pl_Game['attacking'] += 13;
                                    $Pl_Game['defending'] += 10;
                                    $Pl_Game['reacting'] += 12;
                                    $Pl_Game['targeting'] += 15;
                                }
                                //Extended
                                elseif (ereg('(ext|psy)+', $Pl_Type['id'])) {
                                    $Pl_Game['attacking'] += 15;
									$Pl_Game['defending'] += 12;
                                    $Pl_Game['reacting'] += 13;
                                    $Pl_Game['targeting'] += 12;
                                }
                        }
                        //Opponent
                        if ($Op_Gen['evamode'] == 1) {
                            //Natural
                                if (ereg('(nat|co)+', $Op_Type['id'])) {
                                    $Op_Game['attacking'] += 15;
                                    $Op_Game['defending'] += 15;
                                    $Op_Game['reacting'] += 15;
                                    $Op_Game['targeting'] += 15;
                                }
                                //Enhanced
                                elseif (ereg('(enh|nt)+', $Op_Type['id'])) {
                                    $Op_Game['attacking'] += 13;
                                    $Op_Game['defending'] += 10;
                                    $Op_Game['reacting'] += 12;
                                    $Op_Game['targeting'] += 15;
                                }
                                //Extended
                                elseif (ereg('(ext|psy)+', $Op_Type['id'])) {
                                    $Op_Game['attacking'] += 15;
									$Op_Game['defending'] += 12;
                                    $Op_Game['reacting'] += 13;
                                    $Op_Game['targeting'] += 12;
                                }
                        }
				//EVA Mode Deactivation
				if(!ereg('(EVASystem)+', $Pl_Ms['spec'])){
					$Pl_Gen['evamode'] = 0;
				}
				
        //Modify Opponent Stats
                $Op_SyWepA['enc'] = floor($Op_SyWepA['enc'] / 3);
        //Targeting Values
                $Pl_Tar = $Pl_Game['targeting'] + $Pl_Type['taf'] + $Pl_Tactics['taf'];
    $Op_Tar = $Op_Game['targeting'] + $Op_Type['taf'] + $Op_Tactics['taf'];
                        //SEED Mode on Targeting
                        if ($Pl_Gen['hypermode'] == 1 || $Pl_Gen['hypermode'] == 5) {
                            $Pl_Tar += 5;
                        }
    if ($Op_Gen['hypermode'] == 1 || $Op_Gen['hypermode'] == 5) {
        $Op_Tar += 5;
    }
                //Targeting Bonus
                $Pl_Tar += floor($Pl_Tar / 10);
    $Op_Tar += floor($Op_Tar / 10);
        //Get Hit and Miss Values
                $Pl_Hit = $Pl_Tar + $Pl_Ms['taf'] + floor($Pl_Game['level'] / 2) + floor($Pl_WepA['1'] / 2500) + $Pl_Tactics['hitf'];
    $Op_Hit = $Op_Tar + $Op_Ms['taf'] + floor($Op_Game['level'] / 2) + floor($Op_WepA['1'] / 2500) + $Op_Tactics['hitf'];
    $Pl_Miss = $Pl_Game['reacting'] + $Pl_Ms['ref'] + $Pl_Type['ref'] + floor($Pl_Game['level'] / 2) + floor($Pl_WepA[1] / 1250) + $Pl_Tactics['missf'];
    $Op_Miss = $Op_Game['reacting'] + $Op_Ms['ref'] + $Op_Type['ref'] + floor($Op_Game['level'] / 2) + floor($Op_WepA[1] / 1250) + $Op_Tactics['missf'];
    $Pl_Miss += floor(($Pl_Game['reacting'] + $Pl_Type['ref']) / 10 + $Pl_Tactics['ref']);
    $Op_Miss += floor(($Op_Game['reacting'] + $Op_Type['ref']) / 10 + $Op_Tactics['ref']);
                        //SEED Mode on Hit and Miss Values
                        if ($Pl_Gen['hypermode'] == 1 || $Pl_Gen['hypermode'] == 5) {
                            $Pl_Miss = floor(($Pl_Miss + 10) * 1.1);
                            $Pl_Hit = floor(($Pl_Hit + 5) * 1.1);
                        }
    if ($Op_Gen['hypermode'] == 1 || $Op_Gen['hypermode'] == 5) {
        $Op_Miss = floor(($Op_Miss + 10) * 1.1);
        $Pl_Hit = floor(($Op_Hit + 5) * 1.1);
    }
                //Specs

                        //Type Upper-Case Specs of Hit and Miss Values
                                $CeaseFlag = 0;
    $CeaseFlagP = 0;
    if (ereg('(Cease)+', $Pl_Spec) && !ereg('(Mob)[a-e]', $Op_Spec)) {
        $Op_Miss -= 10;
        $Op_Hit -= 10;
        $CeaseFlagP = 1;
    }
    if (ereg('(Cease)+', $Op_Spec) && !ereg('(Mob)[a-e]', $Pl_Spec)) {
        $Pl_Miss -= 10;
        $Pl_Hit -= 10;
        $CeaseFlag = 1;
    }

    if (ereg('(MobD)+', $Pl_Spec)) {
        $Pl_Miss += 29;
    } elseif (ereg('(MobC)+', $Pl_Spec)) {
        $Pl_Miss += 21;
    } elseif (ereg('(MobB)+', $Pl_Spec) && !$CeaseFlag) {
        $Pl_Miss += 13;
    } elseif (ereg('(MobA)+', $Pl_Spec) && !$CeaseFlag) {
        $Pl_Miss += 5;
    }

    if (ereg('(MobD)+', $Op_Spec) && !$CeaseFlagP) {
        $Op_Miss += 29;
    } elseif (ereg('(MobC)+', $Op_Spec) && !$CeaseFlagP) {
        $Op_Miss += 21;
    } elseif (ereg('(MobB)+', $Op_Spec) && !$CeaseFlagP) {
        $Op_Miss += 13;
    } elseif (ereg('(MobA)+', $Op_Spec) && !$CeaseFlagP) {
        $Op_Miss += 5;
    }

    if (ereg('(TarD)+', $Pl_Spec)) {
        $Pl_Hit += 29;
    } elseif (ereg('(TarC)+', $Pl_Spec)) {
        $Pl_Hit += 21;
    } elseif (ereg('(TarB)+', $Pl_Spec) && !$CeaseFlag) {
        $Pl_Hit += 13;
    } elseif (ereg('(TarA)+', $Pl_Spec) && !$CeaseFlag) {
        $Pl_Hit += 5;
    }

    if (ereg('(TarD)+', $Op_Spec)) {
        $Op_Hit += 29;
    } elseif (ereg('(TarC)+', $Op_Spec)) {
        $Op_Hit += 21;
    } elseif (ereg('(TarB)+', $Op_Spec) && !$CeaseFlagP) {
        $Op_Hit += 13;
    } elseif (ereg('(TarA)+', $Op_Spec) && !$CeaseFlagP) {
        $Op_Hit += 5;
    }

                        //Type Lower-Case Specs of Miss Values
                                $Pl_MobSGd = $Pl_MobSEffect = $Op_MobSGd = $Op_MobSEffect = 0;
                                //Analyze Anti-MobS Effects
                                if (ereg('(AntiMobS)+', $Pl_Spec) && mt_rand(0, 100) >= 50) {
                                    $Pl_MobSGd = 6;
                                    $Spec_Event_Tag .= '<Br>你成功干擾對方的行動！';
                                }
    if (ereg('(AntiMobS)+', $Op_Spec) && mt_rand(0, 100) >= 50) {
        $Op_MobSGd = 6;
        $Spec_Event_Tag .= '<Br>對方成功干擾你的行動！';
    }
                                //Analyze MobS Grade - Basic
                                if ($Pl_MobSGd < 6 && $Op_MobSGd < 6) {
                                    if (ereg('(Moba)+', $Pl_Spec)) {
                                        $Pl_MobSGd = 1;
                                    }
                                    if (ereg('(Mobb)+', $Pl_Spec)) {
                                        $Pl_MobSGd = 2;
                                    }
                                    if (ereg('(Mobc)+', $Pl_Spec)) {
                                        $Pl_MobSGd = 3;
                                    }
                                    if (ereg('(Mobd)+', $Pl_Spec)) {
                                        $Pl_MobSGd = 4;
                                    }
                                    if (ereg('(Mobe)+', $Pl_Spec)) {
                                        $Pl_MobSGd = 5;
                                    }
                                    if (ereg('(Moba)+', $Op_Spec)) {
                                        $Op_MobSGd = 1;
                                    }
                                    if (ereg('(Mobb)+', $Op_Spec)) {
                                        $Op_MobSGd = 2;
                                    }
                                    if (ereg('(Mobc)+', $Op_Spec)) {
                                        $Op_MobSGd = 3;
                                    }
                                    if (ereg('(Mobd)+', $Op_Spec)) {
                                        $Op_MobSGd = 4;
                                    }
                                    if (ereg('(Mobe)+', $Op_Spec)) {
                                        $Op_MobSGd = 5;
                                    }
                                        //Analyze Player MobS Grade - Opponent MobS Applied
                                        if ($Pl_MobSGd > $Op_MobSGd) {
                                            $Pl_MobSEffect = ($Pl_MobSGd - $Op_MobSGd) / 10;
                                            $Pl_Miss *= (1 + $Pl_MobSEffect);
                                        }
                                        //Analyze Opponent MobS Grade - Player MobS Applied
                                        if ($Op_MobSGd > $Pl_MobSGd) {
                                            $Op_MobSEffect = ($Op_MobSGd - $Pl_MobSGd) / 10;
                                            $Op_Miss *= (1 + $Op_MobSEffect);
                                        }
                                }
                        //End Lower-Case Specs of Miss Values
                        //Type Lower-Case Specs of Hit Values
                                $Pl_TarSGd = $Pl_TarSEffect = $Op_TarSGd = $Op_TarSEffect = 0;
                                //Analyze Anti-TarS Effects
                                if (ereg('(AntiTarS)+', $Pl_Spec) && mt_rand(0, 100) >= 50) {
                                    $Pl_TarSGd = 6;
                                    $Spec_Event_Tag .= '<Br>你成功干擾對方的雷達！';
                                }
    if (ereg('(AntiTarS)+', $Op_Spec) && mt_rand(0, 100) >= 50) {
        $Op_TarSGd = 6;
        $Spec_Event_Tag .= '<Br>對方成功干擾你的雷達！';
    }
                                //Analyze TarS Grade - Basic
                                if ($Pl_TarSGd < 6 && $Op_TarSGd < 6) {
                                    if (ereg('(Tara)+', $Pl_Spec)) {
                                        $Pl_TarSGd = 1;
                                    }
                                    if (ereg('(Tarb)+', $Pl_Spec)) {
                                        $Pl_TarSGd = 2;
                                    }
                                    if (ereg('(Tarc)+', $Pl_Spec)) {
                                        $Pl_TarSGd = 3;
                                    }
                                    if (ereg('(Tard)+', $Pl_Spec)) {
                                        $Pl_TarSGd = 4;
                                    }
                                    if (ereg('(Tare)+', $Pl_Spec)) {
                                        $Pl_TarSGd = 5;
                                    }
                                    if (ereg('(Tara)+', $Op_Spec)) {
                                        $Op_TarSGd = 1;
                                    }
                                    if (ereg('(Tarb)+', $Op_Spec)) {
                                        $Op_TarSGd = 2;
                                    }
                                    if (ereg('(Tarc)+', $Op_Spec)) {
                                        $Op_TarSGd = 3;
                                    }
                                    if (ereg('(Tard)+', $Op_Spec)) {
                                        $Op_TarSGd = 4;
                                    }
                                    if (ereg('(Tare)+', $Op_Spec)) {
                                        $Op_TarSGd = 5;
                                    }
                                        //Analyze Player TarS Grade - Opponent TarS Applied
                                        if ($Pl_TarSGd > $Op_TarSGd) {
                                            $Pl_TarSEffect = ($Pl_TarSGd - $Op_TarSGd) / 10;
                                            $Pl_Hit *= (1 + $Pl_TarSEffect);
                                        }
                                        //Analyze Opponent TarS Grade - Player TarS Applied
                                        if ($Op_TarSGd > $Pl_TarSGd) {
                                            $Op_TarSEffect = ($Op_TarSGd - $Pl_TarSGd) / 10;
                                            $Op_Hit *= (1 + $Op_TarSEffect);
                                        }
                                }
                        //End Lower-Case Specs of Hit Values
        //Get Defence Values
                $Pl_Def = $Pl_Game['defending'] + $Pl_Ms['def'] + $Pl_Type['def'] + $Pl_Tactics['def'];
    $Op_Def = $Op_Game['defending'] + $Op_Ms['def'] + $Op_Type['def'] + $Op_Tactics['def'];
                //Specs
                        //Upper Case Def Specs
                                if (ereg('(DefE)+', $Pl_Spec)) {
                                    $Pl_Def += 30;
                                } elseif (ereg('(DefD)+', $Pl_Spec)) {
                                    $Pl_Def += 24;
                                } elseif (ereg('(DefC)+', $Pl_Spec)) {
                                    $Pl_Def += 18;
                                } elseif (ereg('(DefB)+', $Pl_Spec)) {
                                    $Pl_Def += 12;
                                } elseif (ereg('(DefA)+', $Pl_Spec)) {
                                    $Pl_Def += 5;
                                }

    if (ereg('(DefE)+', $Op_Spec)) {
        $Op_Def += 30;
    } elseif (ereg('(DefD)+', $Op_Spec)) {
        $Op_Def += 24;
    } elseif (ereg('(DefC)+', $Op_Spec)) {
        $Op_Def += 18;
    } elseif (ereg('(DefB)+', $Op_Spec)) {
        $Op_Def += 12;
    } elseif (ereg('(DefA)+', $Op_Spec)) {
        $Op_Def += 5;
    }

    $Pl_DefX_pc = mt_rand(0, 100);
    $Pl_DefX2_pc = mt_rand(0, 100);
    $Op_DefX_pc = mt_rand(0, 100);
    $Op_DefX2_pc = mt_rand(0, 100);
    if (ereg('(DefX)+', $Pl_Spec) || $Pl_Gen['hypermode'] == 3) {
        if ($Pl_DefX_pc >= 40) {
            $Pl_Def += 20;
            $Spec_Event_Tag .= '<Br>你的底力爆發了！';
        }
    }
    if (ereg('(DefX)+', $Pl_Spec) && $Pl_Gen['hypermode'] == 3) {
        if ($Pl_DefX2_pc >= 40) {
            $Pl_Def += 20;
            $Spec_Event_Tag .= '<Br>你的念動力之底力爆發了！';
        }
    }
    if (ereg('(DefX)+', $Op_Spec) || $Op_Gen['hypermode'] == 3) {
        if ($Op_DefX_pc >= 40) {
            $Op_Def += 20;
            $Spec_Event_Tag .= '<Br>對手的底力爆發了！';
        }
    }
    if (ereg('(DefX)+', $Op_Spec) && $Op_Gen['hypermode'] == 3) {
        if ($Op_DefX2_pc >= 40) {
            $Op_Def += 20;
            $Spec_Event_Tag .= '<Br>對手的念動力之底力爆發了！';
        }
    }
    if (ereg('(MeltB)+', $Pl_Spec)) {
        $Op_Def -= 20;
        if ($Op_Def >= 195) {
            $Op_Def -= round(mt_rand(5, 15));
        }
        if ($Op_Def >= 180) {
            $Op_Def -= round(mt_rand(5, 10));
        }
        if ($Op_Def >= 175) {
            $Op_Def -= round(mt_rand(2, 5));
        }
    } elseif (ereg('(MeltA)+', $Pl_Spec)) {
        $Op_Def -= 10;
        if ($Op_Def >= 195) {
            $Op_Def -= round(mt_rand(5, 15));
        }
        if ($Op_Def >= 180) {
            $Op_Def -= 5;
        }
        if ($Op_Def >= 175) {
            $Op_Def -= round(mt_rand(2, 5));
        }
    }
    if (ereg('(MeltB)+', $Op_Spec)) {
        $Pl_Def -= 20;
        if ($Pl_Def >= 195) {
            $Pl_Def -= round(mt_rand(5, 15));
        }
        if ($Pl_Def >= 180) {
            $Pl_Def -= round(mt_rand(5, 10));
        }
        if ($Pl_Def >= 175) {
            $Pl_Def -= round(mt_rand(2, 5));
        }
    } elseif (ereg('(MeltA)+', $Op_Spec)) {
        $Pl_Def -= 10;
        if ($Pl_Def >= 195) {
            $Pl_Def -= round(mt_rand(5, 15));
        }
        if ($Pl_Def >= 180) {
            $Pl_Def -= 5;
        }
        if ($Pl_Def >= 175) {
            $Pl_Def -= round(mt_rand(2, 5));
        }
    }
    if ($Pl_Def < 1) {
        $Pl_Def = 1;
    } elseif ($Pl_Def > 172) {
        $Pl_Def = 172;
    }
    if ($Op_Def < 1) {
        $Op_Def = 1;
    } elseif ($Op_Def > 172) {
        $Op_Def = 172;
    }
        //Get Attacking Values
                $Pl_Attacking = $Pl_Game['attacking'] + $Pl_Ms['atf'] + $Pl_Type['atf'] + $Pl_Tactics['atf'];
    $Op_Attacking = $Op_Game['attacking'] + $Op_Ms['atf'] + $Op_Type['atf'] + $Op_Tactics['atf'];
                //Specs
                $Spec_AtkA_R = mt_rand(0, 100);
    $Spec_AtkA_R2 = mt_rand(0, 100);
    if (ereg('(AtkA)+', $Pl_Spec) && $Spec_AtkA_R >= 50) {
        $Pl_Attacking += 20;
        $Spec_Event_Tag .= '<Br>你進入了興奮狀態！';
    }
    if (ereg('(AtkA)+', $Op_Spec) && $Spec_AtkA_R2 >= 50) {
        $Op_Attacking += 20;
        $Spec_Event_Tag .= '<Br>對手進入了興奮狀態！';
    }
                        //SEED Mode
                                if ($Pl_Gen['hypermode'] == 1 || $Pl_Gen['hypermode'] == 5) {
                                    $Pl_Attacking = floor($Pl_Attacking + 20);
                                }
    if ($Op_Gen['hypermode'] == 1 || $Op_Gen['hypermode'] == 5) {
        $Op_Attacking = floor($Op_Attacking + 20);
    }
	
	/*//check hit
    $levelx = mt_rand(5, 10);
    $levelx2 = mt_rand(5, 10);

    $chance = mt_rand(0, 10);
    $chance2 = mt_rand(0, 10);
    $chance3 = mt_rand(0, 1);
    $chance4 = mt_rand(0, 1);

    if ($Pl_Game['en'] != 0 && $Pl_Game['targeting'] + $Pl_Ms['taf'] + $Pl_Type['taf'] + $Pl_Tactics['taf'] + $Pl_SyWepA['taf'] + $Pl_SyWepD['taf'] > $Op_Game['reacting'] + $Op_Ms['ref'] + $Op_Type['ref'] + $Op_Tactics['ref'] + $Op_SyWepA['ref'] + $Op_SyWepD['ref'] && $chance == 1 || $chance == 1 && $Pl_SyWepA['weptype'] == '2') {
        $StrikeRds = $Pl_SyWepA['rd'];
        if ($Pl_SyWepA['name'] == '天上天下念動破碎劍') {
            $Pls_Dealt = floor(($Pl_Game['level'] * $levelx) + (3200 * $Pl_SyWepA['rd'] * 2) + ($Pl_Game['atk'] * 1.5) + ($Pl_SyWepD['atk'] * $levelx) - (($Op_Game['defending'] + $Op_Ms['def'] + $Op_SyWepD['def']) * 1.3));
        } elseif ($Pl_SyWepA['name'] == '天上天下念動爆碎劍') {
            $Pls_Dealt = floor(($Pl_Game['level'] * $levelx) + (2800 * $Pl_SyWepA['rd'] * 2) + ($Pl_Game['atk'] * 1.5) + ($Pl_SyWepD['atk'] * $levelx) - (($Op_Game['defending'] + $Op_Ms['def'] + $Op_SyWepD['def']) * 1.3));
        } elseif ($Pl_SyWepA['name'] == '天上天下無敵劍') {
            $Pls_Dealt = floor(($Pl_Game['level'] * $levelx) + (2300 * $Pl_SyWepA['rd'] * 2) + ($Pl_Game['atk'] * 1.5) + ($Pl_SyWepD['atk'] * $levelx) - (($Op_Game['defending'] + $Op_Ms['def'] + $Op_SyWepD['def']) * 1.3));
		} elseif ($Pl_SyWepA['weptype'] == '2') {
            $Pls_Dealt = floor(($Pl_Game['level'] * 10) + ($Pl_SyWepA['atk'] * $Pl_SyWepA['rd'] * 2) + ($Pl_Game['atk'] * 2) + ($Pl_SyWepD['atk'] * 10));
        } else {
            $Pls_Dealt = floor(($Pl_Game['level'] * $levelx) + ($Pl_SyWepA['atk'] * $Pl_SyWepA['rd'] * 2) + ($Pl_Game['atk'] * 1.5) + ($Pl_SyWepD['atk'] * $levelx) - (($Op_Game['defending'] + $Op_Ms['def'] + $Op_SyWepD['def']) * 5));
        }
        $Op_Resulting_HP = $Op_Game['hp'] - $Pl_Dealt;
		$Spec_Event_Tag .= '<Br>補刀成功！';
    }

    if ($Op_Game['en'] != 0 && $Op_Game['targeting'] + $Op_Ms['taf'] + $Op_Type['taf'] + $Op_Tactics['taf'] + $Op_SyWepA['taf'] + $Op_SyWepD['taf']  > $Pl_Game['reacting'] + $Pl_Ms['ref'] + $Pl_Type['ref'] + $Pl_Tactics['ref'] + $Pl_SyWepA['ref'] + $Pl_SyWepD['ref']  && $chance2 == 1 || $chance1 == 1 && $Op_SyWepA['weptype'] == '2') {
        $CStrikeRds = $Op_SyWepA['rd'];
        if ($Op_SyWepA['name'] == '天上天下念動破碎劍') {
            $Ops_Dealt = floor(($Op_Game['level'] * $levelx) + (3200 * $Op_SyWepA['rd'] * 2) + ($Pl_Game['atk'] * 1.5) + ($Op_SyWepD['atk'] * $levelx) - (($Pl_Game['defending'] + $Pl_Ms['def'] + $Pl_SyWepD['def']) * 1.3));
        } elseif ($Op_SyWepA['name'] == '天上天下念動爆碎劍') {
            $Ops_Dealt = floor(($Op_Game['level'] * $levelx) + (2800 * $Op_SyWepA['rd'] * 2) + ($Pl_Game['atk'] * 1.5) + ($Op_SyWepD['atk'] * $levelx) - (($Pl_Game['defending'] + $Pl_Ms['def'] + $Pl_SyWepD['def']) * 1.3));
        } elseif ($Op_SyWepA['name'] == '天上天下無敵劍') {
            $Ops_Dealt = floor(($Op_Game['level'] * $levelx) + (2300 * $Op_SyWepA['rd'] * 2) + ($Pl_Game['atk'] * 1.5) + ($Op_SyWepD['atk'] * $levelx) - (($Pl_Game['defending'] + $Pl_Ms['def'] + $Pl_SyWepD['def']) * 1.3));
		} elseif ($Op_SyWepA['weptype'] == '2') {
            $Ops_Dealt = floor(($Op_Game['level'] * 10) + ($Op_SyWepA['atk'] * $Op_SyWepA['rd'] * 2) + ($Op_Game['atk'] * 2) + ($Op_SyWepD['atk'] * 10));
        } else {
            $Ops_Dealt = floor(($Op_Game['level'] * $levelx) + ($Op_SyWepA['atk'] * $Op_SyWepA['rd'] * 2) + ($Pl_Game['atk'] * 1.5) + ($Op_SyWepD['atk'] * $levelx) - (($Pl_Game['defending'] + $Pl_Ms['def'] + $Pl_SyWepD['def']) * 5));
        }
        $Pl_Resulting_HP = $Pl_Game['hp'] - $Op_Dealt;
		$Spec_Event_Tag .= '<Br>對方補刀成功！';
    }*/
	
        //Calculate Hit Times and Damage Values
    $Pl_Calc = ReturnHitDam($Pl_SyWepA['atk'], $Pl_SyWepA['rd'], $Pl_SyWepA['hit'], $Pl_Tar, $Pl_Hit, $Op_Miss, $Pl_Attacking, $Op_Def, $Pl_Spec, $Op_Spec);
	/*if($Pl_SyWepA['weptype'] == '2'){
		$Pl_Calc = ReturnHitDam($Pl_SyWepA['atk'], $Pl_SyWepA['rd'], $Pl_SyWepA['hit'], $Pl_Tar, $Pl_Hit, $Op_Miss, $Pl_Attacking, 0, $Pl_Spec, $Op_Spec);
	}*/
    $StrikeRds = $Pl_Calc[0];
    $Pl_Dealt = $Pl_Calc[1];
    $Op_Calc = ReturnHitDam($Op_SyWepA['atk'], $Op_SyWepA['rd'], $Op_SyWepA['hit'], $Op_Tar, $Op_Hit, $Pl_Miss, $Op_Attacking, $Pl_Def, $Op_Spec, $Pl_Spec);
	/*if($Op_SyWepA['weptype'] == '2'){
		$Op_Calc = ReturnHitDam($Op_SyWepA['atk'], $Op_SyWepA['rd'], $Op_SyWepA['hit'], $Op_Tar, $Op_Hit, $Pl_Miss, $Op_Attacking, 0, $Op_Spec, $Pl_Spec);
	}*/
    $CStrikeRds = $Op_Calc[0];
    $Op_Dealt = $Op_Calc[1];
    if (($Op_Game['en'] - $Op_SyWepA['enc']) < 0) {
        $Op_Dealt = 0;
        $OpNoENFlag = 1;
    }
        //Calculate Left HP and EN
                //Spec - Reflect
                if (!$OpNoENFlag) {
                    if (ereg('(MirrorDam)+', $Pl_Spec) && mt_rand(0, 100) >= (95 + ($Op_Tar * 0.7))) {
                        $Pl_Dealt = $Op_Dealt;
                        $Op_Dealt = 0;
                        $Spec_Event_Tag .= '<br>你完全反彈了對方的攻擊！';
                    } elseif (ereg('(MirrorDam)+', $Pl_Spec) && mt_rand(0, 100) >= (80 + ($Op_Tar * 0.7))) {
                        $Pl_Dealt = floor($Op_Dealt * 0.8);
                        $Op_Dealt = floor($Op_Dealt * 0.2);
                        $Spec_Event_Tag .= '<br>對方的攻擊大部份被你反彈了！';
                    } elseif (ereg('(MirrorDam)+', $Pl_Spec) && mt_rand(0, 100) >= (25 + ($Op_Tar * 0.7))) {
                        $Pl_Dealt = floor($Op_Dealt * 0.5);
                        $Op_Dealt = floor($Op_Dealt * 0.5);
                        $Spec_Event_Tag .= '<br>對方的攻擊有一半被你反彈了！';
                    }
                    if (ereg('(MirrorDam)+', $Op_Spec) && mt_rand(0, 100) >= (95 + ($Pl_Tar * 0.7))) {
                        $Op_Dealt = $Pl_Dealt;
                        $Pl_Dealt = 0;
                        $Spec_Event_Tag .= '<br>對方完全反彈了你的攻擊！';
                    } elseif (ereg('(MirrorDam)+', $Op_Spec) && mt_rand(0, 100) >= (80 + ($Pl_Tar * 0.7))) {
                        $Op_Dealt = floor($Pl_Dealt * 0.8);
                        $Pl_Dealt = floor($Pl_Dealt * 0.2);
                        $Spec_Event_Tag .= '<br>你的攻擊大部份對方被反彈了！';
                    } elseif (ereg('(MirrorDam)+', $Op_Spec) && mt_rand(0, 100) >= (25 + ($Pl_Tar * 0.7))) {
                        $Op_Dealt = floor($Pl_Dealt * 0.5);
                        $Pl_Dealt = floor($Pl_Dealt * 0.5);
                        $Spec_Event_Tag .= '<br>你的攻擊有一半對方被反彈了！';
                    }
                }
                //Spec - Counter Strike
                        if (ereg('(CounterStrike)+', $Pl_Spec) && !ereg('(CounterStrike)+', $Op_Spec) && mt_rand(0, 100) <= (50 + ($Pl_Game['level'] - $Op_Game['level']))) {
                            $Op_Dealt = 0;
                            $CStrikeRds = 0;
                            $Spec_Event_Tag .= '<br>你成功反擊對方的攻擊！';
                        }
    if (ereg('(CounterStrike)+', $Op_Spec) && !ereg('(CounterStrike)+', $Pl_Spec) && mt_rand(0, 100) <= (50 + ($Op_Game['level'] - $Pl_Game['level']))) {
        $Pl_Dealt = 0;
        $StrikeRds = 0;
        $Spec_Event_Tag .= '<br>對方成功反擊你的攻擊！';
    }
                //Spec - First Strike
                        if (ereg('(FirstStrike)+', $Pl_Spec) && !ereg('(FirstStrike)+', $Op_Spec) && mt_rand(0, 100) <= (85 + ($Pl_Game['level'] - $Op_Game['level'])) && floor($Op_Game['hp'] - $Pl_Dealt) <= 0) {
                            $Op_Dealt = 0;
                            $CStrikeRds = 0;
                            $Spec_Event_Tag .= '<br>你的先制攻擊把對方即時擊敗！';
                        }
    if (ereg('(FirstStrike)+', $Op_Spec) && !ereg('(FirstStrike)+', $Pl_Spec) && mt_rand(0, 100) <= (85 + ($Op_Game['level'] - $Pl_Game['level'])) && floor($Pl_Game['hp'] - $Op_Dealt) <= 0) {
        $Pl_Dealt = 0;
        $StrikeRds = 0;
        $Spec_Event_Tag .= '<br>對方的先制攻擊把你即時擊敗！';
    }
	
                /*
                if($Pl_Dealt < 0 && $chance3 == 1)
                {
                    $StrikeRds = 1;
                    $Pl_Dealt = -2000;
                    $Op_Resulting_HP = $Op_Game['hp']-$Pl_Dealt;
                }

                if($Op_Dealt < 0 && $chance4 == 1)
                {
                    $CStrikeRds = 1;
                    $Op_Dealt = -2000;
                    $Pl_Resulting_HP = $Pl_Game['hp']-$Op_Dealt;
                }
                */
	
	$evasuit = array('EVA Type F','EVA 零號機','EVA 二號機','EVA 三號機');
	
	//EVA槍傷害無效化
	if($Pl_SyWepA['weptype'] == '2' && !in_array($Pl_Ms['msname'],$evasuit)){
		$StrikeRds = 0;
		$Pl_Dealt = 0;
		$Op_Resulting_HP = $Op_Resulting_HP - $Pl_Dealt;
	}
	
	if($Op_SyWepA['weptype'] == '2' && !in_array($Op_Ms['msname'],$evasuit)){
		$CStrikeRds = 0;
		$Op_Dealt = 0;
		$Pl_Resulting_HP = $Pl_Resulting_HP - $Op_Dealt;
	}
	
	//勇者槍傷害無效化
	if($Pl_SyWepA['name'] == 'Goldion Hammer' && !ereg('勇者王', $Pl_Ms['msname']) || $Pl_SyWepA['name'] == 'Hell and Heaven' && !ereg('勇者王', $Pl_Ms['msname'])){
		$StrikeRds = 0;
		$Pl_Dealt = 0;
		$Op_Resulting_HP = $Op_Resulting_HP - $Pl_Dealt;
	}
	
	if($Op_SyWepA['name'] == 'Goldion Hammer' && !ereg('勇者王',$Op_Ms['msname']) || $Op_SyWepA['name'] == 'Hell and Heaven' && !ereg('勇者王', $Op_Ms['msname'])){
		$CStrikeRds = 0;
		$Op_Dealt = 0;
		$Pl_Resulting_HP = $Pl_Resulting_HP - $Op_Dealt;
	}
	
	//EVA槍傷害減半
	if($Pl_SyWepA['weptype'] == '2' && ereg('GAtkDef', $Op_SyWepA['spec']))
	{
		$Pl_Dealt = floor($Pl_Dealt/2);
		$Op_Resulting_HP = $Op_Resulting_HP - $Pl_Dealt;
	}
	
	if($Op_SyWepA['weptype'] == '2' && ereg('GAtkDef', $Pl_SyWepA['spec']))
	{
		$Op_Dealt = floor($Op_Dealt/2);
		$Pl_Resulting_HP = $Pl_Resulting_HP - $Op_Dealt;
	}
	
	/*//要塞傷害固定化
	if ($Op_Name == '<AttackFort>'){
		$Pl_Dealt = floor(($Pl_Game['level'] * 10) + ($Pl_SyWepA['atk'] * $Pl_SyWepA['rd'] * 3) + ($Pl_Game['atk'] * 3));
		$Op_Resulting_HP = $Op_Resulting_HP - $Pl_Dealt;
	}*/
	
	/*
	$crchance = mt_rand(1,10);
	$rdchance = mt_rand(0,100);
	
	if ($Pl_Gen['coordinates'] == "D10" && $crchance == 3){
		if($rdchance >= 1 && $rdchance <= 20){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 21 && $rdchance <= 40){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 41 && $rdchance <= 60){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 61 && $rdchance <= 80){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 81 && $rdchance <= 100){
			$Spec_Event_Tag .= '<Br>！';
		}
	}
	if ($Pl_Gen['coordinates'] == "D11" && $crchance == 6){
		if($rdchance >= 1 && $rdchance <= 20){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 21 && $rdchance <= 40){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 41 && $rdchance <= 60){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 61 && $rdchance <= 80){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 81 && $rdchance <= 100){
			$Spec_Event_Tag .= '<Br>！';
		}
	}
	if ($Pl_Gen['coordinates'] == "D12" && $crchance == 9){
		if($rdchance >= 1 && $rdchance <= 20){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 21 && $rdchance <= 40){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 41 && $rdchance <= 60){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 61 && $rdchance <= 80){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 81 && $rdchance <= 100){
			$Spec_Event_Tag .= '<Br>！';
		}
	}
	if ($Pl_Gen['coordinates'] == "D13" && $crchance == 10){
		if($rdchance >= 1 && $rdchance <= 20){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 21 && $rdchance <= 40){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 41 && $rdchance <= 60){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 61 && $rdchance <= 80){
			$Spec_Event_Tag .= '<Br>！';
		}
		else
		if($rdchance >= 81 && $rdchance <= 100){
			$Spec_Event_Tag .= '<Br>！';
		}
	}
	*/
	
	if ($Pl_Dealt < 0) {
		$StrikeRds = 0;
		$Pl_Dealt = 0;
		$Op_Resulting_HP = $Op_Game['hp'];
	}

    if ($Op_Dealt < 0) {
        $CStrikeRds = 0;
        $Op_Dealt = 0;
        $Pl_Resulting_HP = $Pl_Game['hp'];
    }

                //Normal
                if ($Pl_Game['hp'] > $Pl_Game['hpmax']) {
                    $Pl_Game['hp'] = $Pl_Game['hpmax'];
                }
    if ($Pl_Game['en'] > $Pl_Game['enmax']) {
        $Pl_Game['en'] = $Pl_Game['enmax'];
    }
    if ($Op_Game['hp'] > $Op_Game['hpmax']) {
        $Op_Game['hp'] = $Op_Game['hpmax'];
    }
    if ($Op_Game['en'] > $Op_Game['enmax']) {
        $Op_Game['en'] = $Op_Game['enmax'];
    }
    if (floor($Pl_Game['hp'] - $Op_Dealt) < 0) {
        $Pl_Resulting_HP = 0;
    } else {
        $Pl_Resulting_HP = floor($Pl_Game['hp'] - $Op_Dealt - $Pl_Tactics['hpc']);
    }
    if (floor($Op_Game['hp'] - $Pl_Dealt) < 0) {
        $Op_Resulting_HP = 0;
    } else {
        $Op_Resulting_HP = floor($Op_Game['hp'] - $Pl_Dealt - $Op_Tactics['hpc']);
    }

    if (floor($Pl_Game['en'] - $Pl_SyWepA['enc']) < 0) {
        $Pl_Resulting_EN = 0;
    } else {
        $Pl_Resulting_EN = floor($Pl_Game['en'] - $Pl_SyWepA['enc']);
    }
    if (floor($Op_Game['en'] - $Op_SyWepA['enc']) < 0) {
        $Op_Resulting_EN = 0;
    } else {
        $Op_Resulting_EN = floor($Op_Game['en'] - $Op_SyWepA['enc']);
    }

    if (floor($Pl_Resulting_EN - $Pl_SyWepD['enc'] - $Pl_SyWepE['enc']) < 0) {
        $Pl_Resulting_EN = 0;
    } else {
        $Pl_Resulting_EN = floor($Pl_Resulting_EN - $Pl_SyWepD['enc'] - $Pl_SyWepE['enc']);
    }
    if (floor($Op_Resulting_EN - $Op_SyWepD['enc'] - $Op_SyWepE['enc']) < 0) {
        $Op_Resulting_EN = 0;
    } else {
        $Op_Resulting_EN = floor($Op_Resulting_EN - $Op_SyWepD['enc'] - $Op_SyWepE['enc']);
    }

    if (floatval($Pl_Game['sp'] - intval($SP_Cost)) < 0) {
        $Pl_Resulting_SP = 0;
    } else {
        $Pl_Resulting_SP = floatval($Pl_Game['sp'] - intval($SP_Cost));
    }

    if ($SP_CostOP) {
        $Op_Game['sp'] -= $SP_CostOP;
    }

                //Special Event Status
                        //武器特效 - 機體損壞
                        $S_Event_ENdam_Rand = mt_rand(0, 100);
    $S_Event_ENdam_Rand2 = mt_rand(0, 100);

    $specdam = mt_rand(1, 4);
    $specdam2 = mt_rand(1, 4);

    $damevent = mt_rand(0, 100);
    $damevent2 = mt_rand(0, 100);

    if (ereg('[DamA]{4}', $Pl_SyWepA['spec']) && $S_Event_ENdam_Rand >= 90 && $VictoryFlag != 2 || ereg('[DamA]{4}', $Pl_SyWepA['spec']) && $S_Event_ENdam_Rand >= 95 && $VictoryFlag == 2) {
        $Op_Resulting_EN = floor($Op_Resulting_EN * 0.5);
        $Spec_Event_Tag .= '<br>對手的機體被損壞，剩餘能源下降！';
        if ($specdam == 1 && $damevent >= 90) {
            $Spec_Event_Tag .= '<br>對手的機體被損壞，能力值下降！';
            $atksp = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `attacking` = attacking-1 WHERE `username` = '$Op_Gen[username]';");
            mysql_query($atksp);
        } elseif ($specdam == 2 && $damevent >= 90) {
            $Spec_Event_Tag .= '<br>對手的機體被損壞，能力值下降！';
            $defsp = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `defending` = defending-1 WHERE `username` = '$Op_Gen[username]';");
            mysql_query($defsp);
        } elseif ($specdam == 3 && $damevent >= 90) {
            $Spec_Event_Tag .= '<br>對手的機體被損壞，能力值下降！';
            $reasp = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `reacting` = reacting-1 WHERE `username` = '$Op_Gen[username]';");
            mysql_query($reasp);
        } elseif ($specdam == 4 && $damevent >= 90) {
            $Spec_Event_Tag .= '<br>對手的機體被損壞，能力值下降！';
            $tarsp = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `targeting` = targeting-1 WHERE `username` = '$Op_Gen[username]';");
            mysql_query($tarsp);
        }
    }

    if (ereg('[DamA]{4}', $Op_SyWepA['spec']) && $S_Event_ENdam_Rand2 >= 90 && $VictoryFlag != 1 || ereg('[DamA]{4}', $Op_SyWepA['spec']) && $S_Event_ENdam_Rand2 >= 90 && $VictoryFlag == 1) {
        $Pl_Resulting_EN = floor($Pl_Resulting_EN * 0.5);
        $Spec_Event_Tag .= '<br>你的機體被對手損壞，剩餘能源下降！';
        if ($specdam2 == 1 && $damevent2 >= 90) {
            $Spec_Event_Tag .= '<br>你的機體被對手損壞，能力值下降！';
            $atksp2 = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `attacking` = attacking-1 WHERE `username` = '$Pl_Gen[username]';");
            mysql_query($atksp2);
        } elseif ($specdam2 == 2 && $damevent2 >= 90) {
            $Spec_Event_Tag .= '<br>你的機體被對手損壞，能力值下降！';
            $defsp2 = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `defending` = defending-1 WHERE `username` = '$Pl_Gen[username]';");
            mysql_query($defsp2);
        } elseif ($specdam2 == 3 && $damevent2 >= 90) {
            $Spec_Event_Tag .= '<br>你的機體被對手損壞，能力值下降！';
            $reasp2 = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `reacting` = reacting-1 WHERE `username` = '$Pl_Gen[username]';");
            mysql_query($reasp2);
        } elseif ($specdam2 == 4 && $damevent2 >= 90) {
            $Spec_Event_Tag .= '<br>你的機體被對手損壞，能力值下降！';
            $tarsp2 = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_game_info` SET `targeting` = targeting-1 WHERE `username` = '$Pl_Gen[username]';");
            mysql_query($tarsp2);
        }
    }
        //Weapon Stats
                //Nil
        //Fame and Notorous Modifier
                unset($AtkOnline, $AttackEnemy);
    if ($CFU_Time - $Op_Gen['time2'] < $Offline_Time) {
        $AtkOnline = '1';
    }
    if ($AttackFort && $Area_Org['id'] == $Op_Game['organization']) {
        $AtkOnline = '0';
    }
    if (ereg_replace('(Atk=\()|\)', '', $Op_Org['optmissioni']) == $Pl_Gen['coordinates'] && $CFU_Time < $Op_Org['opttime'] && $Pl_Game['organization'] != '0') {
        $AttackEnemy = 'True';
    }
    if ($Op_Org['optmissioni'] == $Pl_Org['optmissioni'] && $CFU_Time < $Op_Org['opttime'] && $CFU_Time < $Pl_Org['opttime']) {
        $AttackEnemy = 'SameTarget';
    }
    if ($Area_Org['id'] == $Pl_Game['organization'] && $AttackEnemy) {
        $AtkOnline = '0';
    } elseif ($AttackEnemy == 'SameTarget' && ereg_replace('(Atk=\()|\)', '', $Op_Org['optmissioni']) == $Pl_Gen['coordinates']) {
        $AtkOnline = '0';
    }
    if ($Op_Gen['fame'] < 0) {
        if (rand(0, 100) > 95) {
            ++$Pl_Gen['fame'];
        }
        if (rand(0, 100) > 80) {
            ++$Op_Gen['fame'];
        }
        if ($AtkOnline == '1') {
            if (rand(0, 100) > 5) {
                ++$Pl_Gen['fame'];
            }
            if (rand(0, 100) > 20) {
                ++$Op_Gen['fame'];
            }
        }
    }
    if ($Op_Gen['fame'] >= 0 && $AtkOnline == '1') {
        --$Pl_Gen['fame'];
        $Pl_Gen['bounty'] += 100;
        if ($Pl_Gen['fame'] < 0) {
            $Pl_Gen['bounty'] += 25 * abs($Pl_Gen['fame']);
        }
        if ($Pl_Gen['fame'] < -10) {
            $Pl_Gen['bounty'] += 900;
        }
        if ($Pl_Gen['fame'] < -50) {
            $Pl_Gen['bounty'] += 9000;
        }
        if ($Pl_Gen['fame'] < -100) {
            $Pl_Gen['bounty'] += floor(10 * abs($Pl_Gen['fame'] - 1));
        }
    }

                //Modify by Level
                if ($AtkOnline == '1' && $Op_Gen['fame'] >= 0) {
                    if ($Pl_Game['level'] - $Op_Game['level'] > 25) {
                        --$Pl_Gen['fame'];
                    }
                    if ($Pl_Game['level'] - $Op_Game['level'] > 35) {
                        $Pl_Gen['fame'] -= 4;
                    }
                }

        //Analyze Results
                //VictoryFlag: 0=no results, 1=victory, 2=lost, 3=both lost
                unset($HistoryWrite);
    $VictoryFlag = 0;
    if ($Pl_Resulting_HP > 0 && $Op_Resulting_HP <= 0) {
        $VictoryFlag = 1;
        $Op_Resulting_HP = 0;
        if ($Op_Name == '<AttackFort>') {
            $Pl_Gen['fame'] += 20;
            if (mt_rand(0, 100) >= 75) {
                $Pl_Gen['growth'] += 1;
            }
            $sql = ('INSERT INTO `'.$GLOBALS['DBPrefix']."phpeb_game_history` (`time`, `history`) VALUES (UNIX_TIMESTAMP(), '<font color=$Pl_Org[color]>$Pl_Org[name]</font>的<font color=$Pl_Gen[color]>$Pl_Game[gamename]</font>，成功攻陷由<font color=$Area_Org[color]>$Area_Org[name]統治下的$Pl_Gen[coordinates]區域</font>！');");
            mysql_query($sql) or die(mysql_error());
        }
        if ($Op_Gen['fame'] < 0) {
            if (rand(0, 100) > 80) {
                ++$Pl_Gen['fame'];
            }
            if (rand(0, 100) > 90) {
                ++$Op_Gen['fame'];
            }
        }
    } elseif ($Pl_Resulting_HP <= 0) {
        $VictoryFlag = 2;
        $Pl_Resulting_HP = 0;
        if ($Op_Resulting_HP <= 0) {
            $VictoryFlag = 3;
            $Op_Resulting_HP = 0;
            if ($Op_Name == '<AttackFort>') {
                $Pl_Gen['fame'] += 5;
                if (mt_rand(0, 100) >= 90) {
                    $Pl_Gen['growth'] += 1;
                }
                $sql = ('INSERT INTO `'.$GLOBALS['DBPrefix']."phpeb_game_history` (`time`, `history`) VALUES (UNIX_TIMESTAMP(), '<font color=$Pl_Org[color]>$Pl_Org[name]</font>的<font color=$Pl_Gen[color]>$Pl_Game[gamename]</font>，成功攻陷由<font color=$Area_Org[color]>$Area_Org[name]統治下的$Pl_Gen[coordinates]區域</font>！');");
                mysql_query($sql);
            }
        } elseif (rand(0, 100) > 70 && $Pl_Gen['fame'] > 0) {
            --$Pl_Gen['fame'];
        }
    }
                //Gain Experience
                        $Pl_Gain_Wep_Exp = 10;
    $Op_Gain_Wep_Exp = 10;
    $Pl_Gain_Exp = 0;
    $Op_Gain_Exp = 0;
    $PlBGain = (pow($Op_Game['level'], 2));
    $OpBGain = (pow($Pl_Game['level'], 2));

    switch ($VictoryFlag) {
                        case 1: $Pl_Gain_Exp = $PlBGain + ($Pl_Game['rank'] * 0.05) + ($Op_Game['rank'] * 0.08);$Pl_Gain_Wep_Exp = 6;break;
                        case 0: $Pl_Gain_Exp = $PlBGain / 1.5;$Op_Gain_Exp = $OpBGain / 8;break;
                        case 3: $Pl_Gain_Exp = $PlBGain / 3;break;
                        case 2: $Op_Gain_Exp = $OpBGain / 3 + ($Pl_Game['rank'] * 0.5);$Op_Gain_Wep_Exp = 1;break;
                        }

                //Gain Extra Weapon Experience
                        $StrikePercentage = ($StrikeRds / $Pl_SyWepA['rd']) * 100;
    $CStrikePercentage = ($CStrikeRds / $Op_SyWepA['rd']) * 100;
    $PlBWGain = mt_rand(Floor($StrikePercentage / 30), Floor($StrikePercentage / 10));
    $OpBWGain = mt_rand(Floor($CStrikePercentage / 60), Floor($CStrikePercentage / 20));
    if ($Pl_LocalOrgFlag == 1) {
        $Pl_Gain_Wep_Exp *= 1.1;
        if (ereg('DoubleMon', $Pl_SyWepA['spec'])) {
            $Pl_Gain_Wep_Exp *= 1.85;
        }
    }
    if ($Op_LocalOrgFlag == 1) {
        $Op_Gain_Wep_Exp *= 1.1;
        if (ereg('DoubleMon', $Op_SyWepA['spec'])) {
            $Op_Gain_Wep_Exp *= 1.85;
        }
    }
    $Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp + $PlBWGain;
    $Op_Gain_Wep_Exp = $Op_Gain_Wep_Exp + $OpBWGain;
                //Level Gap Experience Fix
                        if ($Pl_Game['level'] >= 850 && $Pl_Game['level'] <= 1000) {
                            $Pl_Gain_Exp = $Pl_Gain_Exp * 1.1;
                            $Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp / 1.5;
						} elseif ($Pl_Game['level'] >= 750 && $Pl_Game['level'] <= 849) {
                            $Pl_Gain_Exp = $Pl_Gain_Exp * 1.15;
                            $Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp / 1.5;
						} elseif ($Pl_Game['level'] >= 650 && $Pl_Game['level'] <= 749) {
                            $Pl_Gain_Exp = $Pl_Gain_Exp * 1.2;
                            $Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp / 1.5;
						} elseif ($Pl_Game['level'] >= 550 && $Pl_Game['level'] <= 649) {
                            $Pl_Gain_Exp = $Pl_Gain_Exp * 1.25;
                            $Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp / 1.5;
                        } elseif ($Pl_Game['level'] >= 450 && $Pl_Game['level'] <= 549) {
                            $Pl_Gain_Exp = $Pl_Gain_Exp * 1.3;
                            $Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp / 1.5;
                        } elseif ($Pl_Game['level'] >= 350 && $Pl_Game['level'] <= 449) {
                            $Pl_Gain_Exp = $Pl_Gain_Exp * 1.2;
                            $Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp / 1.5;
                        } elseif ($Pl_Game['level'] >= 250 && $Pl_Game['level'] <= 349) {
                            $Pl_Gain_Exp = $Pl_Gain_Exp * 1.1;
                            $Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp / 1.5;
                        } elseif ($Pl_Game['level'] >= 150 && $Pl_Game['level'] <= 249) {
                            $Pl_Gain_Exp = $Pl_Gain_Exp * 1.2;
                            $Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp / 1.5;
                        } elseif ($Pl_Game['level'] >= 50 && $Pl_Game['level'] <= 149) {
                            $Pl_Gain_Exp = $Pl_Gain_Exp * 1.3;
                            $Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp / 1.5;
                        } elseif ($Pl_Game['level'] < 50) {
                            $Pl_Gain_Exp = $Pl_Gain_Exp * 1.5;
                            $Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp / 1.5;
                        }

                //Gain Rankings
                        if ($VictoryFlag == 1) {
                            $Pl_Game['rank'] += Ceil($Op_Game['rank'] / 1000) + 10;
                            if ($Op_Name == '<AttackFort>') {
                                $Pl_Game['rank'] += 10000;
                            }
                        } elseif ($VictoryFlag == 2) {
                            $Pl_Game['rank'] -= 100;
                        } elseif ($VictoryFlag == 3) {
                            $Pl_Game['rank'] += 2;
                        } elseif ($VictoryFlag == 0) {
                            $Pl_Game['rank'] += Ceil($Op_Game['rank'] / 100) + 2;
                        }
    if ($Pl_Game['rank'] > 100000) {
        $Pl_Game['rank'] = 100000;
    } elseif ($Pl_Game['rank'] < 0) {
        $Pl_Game['rank'] = 0;
    }

                //Finalize Experience Gain
                        //Spec
                        if (ereg('(DoubleExp)+', $Pl_Spec)) {
                            $Pl_Gain_Exp *= 2;
                            $Pl_Gain_Wep_Exp *= 2;
                        }
                                //Fame and Notoriety Modifier
                                        //$Pl_Gain_Wep_Exp *= 1+($Pl_Gen['fame']/1000);
                                        //$Op_Gain_Wep_Exp *= 1+($Op_Gen['fame']/1000);
                                        //$Pl_Gain_Exp *= 1+($Pl_Gen['fame']/1000);
                                        //$Op_Gain_Exp *= 1+($Op_Gen['fame']/1000);

    //Finalize
	$Pl_Gain_Wep_Exp = Floor($Pl_Gain_Wep_Exp * 3);
    $Op_Gain_Wep_Exp = Floor($Op_Gain_Wep_Exp);
    if ($StrikePercentage == 0) {
        $Pl_Gain_Wep_Exp = 0;
    }
    if ($CStrikePercentage == 0) {
        $Op_Gain_Wep_Exp = 0;
    }
    $Pl_Gain_Exp = Floor($Pl_Gain_Exp + 10);
    $Op_Gain_Exp = Floor($Op_Gain_Exp + 1);
    if ($Pl_Gain_Exp < 0) {
        $Pl_Gain_Exp = 0;
    }
    if ($Op_Gain_Exp < 0) {
        $Op_Gain_Exp = 0;
    }
    if ($Pl_Gain_Wep_Exp < 0) {
        $Pl_Gain_Wep_Exp = 0;
    }
    if ($Op_Gain_Wep_Exp < 0) {
        $Op_Gain_Wep_Exp = 0;
    }
    if ($Pl_Gen['fame'] > 1000) {
        $Pl_Gen['fame'] = 1000;
    }
    if ($Pl_Gen['fame'] < -1000) {
        $Pl_Gen['fame'] = -1000;
    }

    if ($Pl_Gain_Wep_Exp <= 0) {
        $Pl_Gain_Wep_Exp = 10;
    }

	$checkarea = ("SELECT protect FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$Pl_Gen[coordinates]'");
	$area = mysql_query($checkarea);
	$isprotect = mysql_fetch_row($area);
	
                //check attacker
                if ($Pl_Game['level'] - $Op_Game['level'] > 50 && $CFU_Time - $Op_Gen['time2'] < $Offline_Time && $Op_Gen[fame] >= 0 && $isprotect[0] != 1) {
                    $Pl_Game['status'] = '1';
                    $Pl_Game['expr'] = '0';
                    $Op_Resulting_HP = $Op_Game['hp'];
                    $Op_Resulting_EN = $Op_Game['en'];
                    $Op_Game['status'] = '0';
                    $Pl_Dealt = 0;
                    $Op_Dealt = 100000;
                    $StrikeRds = 0;
                    $CStrikeRds = 10;
                    $Pl_Gain_Exp = 0;
                    $Pl_Gain_Wep_Exp = 0;
                    $Pl_Resulting_HP = 0;
                    $Pl_Resulting_EN = 0;
                    $Pl_Gain_Money = 0;
					$Spec_Event_Tag .= '<br>新手保護限制！';
                }

    $expgain = mt_rand(50000, 100000);

    if ($Pl_Dealt <= 0 && $Pl_Game['targeting'] > $Op_Game['reacting'] && $chance == 1) {
        $Pl_Gain_Exp = $expgain;
        $Pl_Game['expr'] = $Pl_Game['expr'] + $expgain;
        $Pl_Gain_Wep_Exp = 20;
    }

                /*if($Pl_Dealt < 0 && $chance3 == 1)
                {
                    $Pl_Gain_Exp = 1000;
                    $Pl_Game['expr'] = $Pl_Game['expr'] + $Pl_Gain_Exp;;
                    $Pl_Gain_Wep_Exp = 4;
                }*/

                if ($Pl_Dealt < 0 && $Pl_Dealt != -2000) {
                    $Pl_Gain_Exp = 1000;
                    $Pl_Game['expr'] = $Pl_Game['expr'] + $Pl_Gain_Exp;
                    $Pl_Gain_Wep_Exp = 10;
                }

	//check if occupied
	$checkocc = ("SELECT occupied FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '$Pl_Gen[coordinates]'");
	$areaocc = mysql_query($checkocc);
	$isocc = mysql_fetch_row($areaocc);
	
	//check player online
	if ($CFU_Time - $Op_Gen['time2'] < $Offline_Time && $isprotect[0] != 1) {
		$Pl_Gain_Exp = floor($Pl_Gain_Exp*0.5);
		$Spec_Event_Tag .= '<Br>攻擊線上玩家 獲得經驗扣減50%！';
    }
	
	if($Pl_Game['organization'] == 0){
		$Pl_Gain_Wep_Exp = $Pl_Gain_Wep_Exp;
	} elseif ($isocc[0] == $Pl_Game['organization']){
		$Pl_Gain_Wep_Exp = floor($Pl_Gain_Wep_Exp*1.3);
		$Spec_Event_Tag .= '<Br>在國家領土戰鬥 獲得130%經驗加成！';
	}
	
	if ($Pl_Gen['bcount'] >= 1500 && $Pl_Gen['bcount'] <= 2000){
		$Pl_Gain_Exp = floor($Pl_Gain_Exp/2);
		$Pl_Gain_Wep_Exp = floor($Pl_Gain_Wep_Exp/2);
		$Spec_Event_Tag .= '<Br>每日戰鬥次數已達1500次，獲得經驗扣減50%！';
	}
	
	if ($Pl_Gen['bcount'] >= 2000 && $Pl_Gen['bcount'] <= 2500){
		$Pl_Gain_Exp = 0;
		$Pl_Gain_Wep_Exp = 0;
		$Spec_Event_Tag .= '<Br>每日戰鬥次數已達2000次，不能獲得經驗！';
	}
	
	if ($Pl_Gen['bcount'] >= 2500){
		$Pl_Gain_Exp = 0;
		$Pl_Gain_Wep_Exp = 0;
		$Spec_Event_Tag .= '<Br>每日戰鬥次數已達2500次，甚麼都沒有！';
	}
	
	/*//double exp
	$Pl_Gain_Exp = floor($Pl_Gain_Exp*2);
	$Op_Gain_Exp = floor($Op_Gain_Exp*2);
	$Spec_Event_Tag .= '<Br>雙經活動 獲得200%經驗加成！';*/
	
	//Update All Experiences
	$Pl_Game['expr'] = $Pl_Game['expr'] + $Pl_Gain_Exp;
    $Op_Game['expr'] = $Op_Game['expr'] + $Op_Gain_Exp;
    if ($Pl_Game['level'] - $Op_Game['level'] > 50 && $CFU_Time - $Op_Gen['time2'] < $Offline_Time) {
        $Pl_WepA[1] = $Pl_WepA[1];
        $Op_WepA[1] = $Op_WepA[1] + $Op_Gain_Wep_Exp;
    } else {
        $Pl_WepA[1] = $Pl_WepA[1] + $Pl_Gain_Wep_Exp;
        $Op_WepA[1] = $Op_WepA[1] + $Op_Gain_Wep_Exp;
    };
    if ($Pl_WepA[1] > $Max_Wep_Exp) {
        $Pl_WepA[1] = $Max_Wep_Exp;
    }
    if ($Op_WepA[1] > $Max_Wep_Exp) {
        $Op_WepA[1] = $Max_Wep_Exp;
    }
                //Update Weapon Info
                        $Pl_Game['wepa'] = implode('<!>', $Pl_WepA);
    $Op_Game['wepa'] = implode('<!>', $Op_WepA);
                //Gain Money
                $Pl_Gain_Money = 0;
    $PlMoneyBGain = mt_rand(($Op_Game['level'] * 1000), ($Op_Game['level'] * 1500));
    if ($VictoryFlag == 1) {
        $Pl_Gain_Money = $PlMoneyBGain;
    } elseif ($VictoryFlag == 0) {
        $Pl_Gain_Money = $PlMoneyBGain / 10;
    } elseif ($VictoryFlag == 3) {
        $Pl_Gain_Money = $PlMoneyBGain / 25;
    }
    $Pl_Gain_Money = Floor($Pl_Gain_Money + $Op_Game['rank'] / 80);
    if (ereg('(DoubleMon)+', $Pl_Spec)) {
        $Pl_Gain_Money *= 2;
    }
    if ($StrikePercentage == 0) {
        $Pl_Gain_Money = 0;
    }
	if ($Pl_Game['level'] < 50) {
		$Pl_Gain_Money = $Pl_Gain_Money*5;
	}
	if ($Pl_Game['level'] < 50 && $Pl_Gain_Money==0) {
		$Pl_Gain_Money = 10000;
	}
	if ($Pl_Gen['bcount'] >= 2500){
		$Pl_Gain_Money = 0;
	}
	//check if occupied
	if($Pl_Game['organization'] == 0){
		$Pl_Gain_Money = $Pl_Gain_Money;
	} elseif ($isocc[0] == $Pl_Game['organization'] && $Pl_Gen['bcount'] <= 2500){
		$Pl_Gain_Money = floor($Pl_Gain_Money*1.5);
		$Spec_Event_Tag .= '<Br>在國家領土戰鬥 獲得150%金錢加成！';
	}
	
	//check attacker
	if ($Pl_Game['level'] - $Op_Game['level'] > 50 && $CFU_Time - $Op_Gen['time2'] < $Offline_Time && $Op_Gen[fame] >= 0 && $isprotect[0] != 1) {
		$Pl_Gain_Money = 0;
    }
    if ($Pl_Game['level'] - $Op_Game['level'] > 50 && $CFU_Time - $Op_Gen['time2'] < $Offline_Time || $Pl_Gen['bcount'] >= 2500) {
        $Pl_Gen['cash'] = $Pl_Gen['cash'];
    } else {
        $Pl_Gen['cash'] += floor($Pl_Gain_Money + $Pl_Game['rank'] * 0.075);
    }
	
                //Gain Bounty
                $Gain_Bounty = 0;
    if ($Op_Gen['bounty'] > 100 && $VictoryFlag == 1) {
        $Gain_Bounty = $Op_Gen['bounty'];

        $Op_Gen['bounty'] -= $Gain_Bounty;

        if ($Gain_Bounty) {
            $sql = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_bank` SET `savings` = `savings`+$Gain_Bounty WHERE `username` = '$_SESSION[username]' LIMIT 1;");
            mysql_query($sql);
            unset($sql);
        }

        $Gain_BountyFlag = '1';
    }
	
        //Update Player Status
                switch ($VictoryFlag) {case '1': $Op_Game['status'] = '1';$Pl_Game['victory'] += 1;$Pl_Game['v_points'] += 1;$Result_Tag .= '<br>你把對手擊敗！';$Pl_Log_Tag = "對手的$Op_Ms[msname]被你擊敗！";$Op_Log_Tag = "你被對手的$Pl_Ms[msname]擊敗。";break;
                case '2': $Pl_Game['status'] = '1';$Result_Tag .= '<br>你被對手擊敗。';$Pl_Log_Tag = "你被對手的$Op_Ms[msname]擊敗。";$Op_Log_Tag = "對手的$Pl_Ms[msname]被你擊敗！";break;
                case '3': $Op_Game['status'] = '1';$Pl_Game['status'] = '1';$Result_Tag .= '<br>你與對手兩敗俱傷。';$Pl_Log_Tag = '你與對手兩敗俱傷。';$Op_Log_Tag = '對手與你兩敗俱傷。';break;
                default: $Result_Tag .= '<br>你與對手的戰鬥沒有分出勝負。';$Pl_Log_Tag = '你與對手的戰鬥沒有分出勝負。';$Op_Log_Tag = '對手與你的戰鬥沒有分出勝負。';};
	if ($Pl_Gen['bcount'] >= 2500 && $VictoryFlag == 1){
		$Pl_Game['victory'] -= 1;
		$Pl_Game['v_points'] -= 1;
	}
	//Special Event Status
	//武器特效 - 戰鬥不能
	$S_Event_Status_Rand = mt_rand(0, 100);
    $S_Event_Status_Rand2 = mt_rand(0, 100);
    if (ereg('(AntiDam)+', $Op_Spec)) {
        $S_Event_Status_Rand = 0;
    } else {
        if (ereg('(DamB)+', $Pl_SyWepA['spec']) && $S_Event_Status_Rand >= 90 && $VictoryFlag == 0) {
            $Op_Game['status'] = '1';
            $Spec_Event_Tag .= '<br>對手的機體被損壞，戰鬥不能！';
        } elseif (ereg('(DamB)+', $Pl_SyWepA['spec']) && $S_Event_Status_Rand >= 98 && $VictoryFlag == 2) {
            $Op_Game['status'] = '1';
            $Spec_Event_Tag .= '<br>對手的機體被損壞，戰鬥不能！';
        }
    }
    if (ereg('(AntiDam)+', $Pl_Spec)) {
        $S_Event_Status_Rand2 = 0;
    } else {
        if (ereg('(DamB)+', $Op_SyWepA['spec']) && $S_Event_Status_Rand2 >= 90 && $VictoryFlag == 0) {
            $Pl_Game['status'] = '1';
            $Spec_Event_Tag .= '<br>你的機體被對手損壞，戰鬥不能，需要修理！';
        } elseif (ereg('(DamB)+', $Op_SyWepA['spec']) && $S_Event_Status_Rand2 >= 95 && $VictoryFlag == 1) {
            $Pl_Game['status'] = '1';
            $Spec_Event_Tag .= '<br>你的機體被對手損壞，戰鬥不能，需要修理！';
        }
    }
        //Level Up
                if ($Pl_Game['level'] < 1000) {
                    CalcExp("$Pl_Game[level]");
                } else {
                    $UserNextLvExp = 99999999999;
                    $Pl_Game['expr'] = 0;
                }
    if ($Op_Game['level'] < 1000) {
        CalcExp("$Op_Game[level]", 'OppoNextLvExp');
    } else {
        $OppoNextLvExp = 99999999999;
        $Op_Game['expr'] = 0;
    }
    CalcStatPt('Pl', "$Pl_Game[level]");
    CalcStatPt('Op', "$Op_Game[level]");
    if ($Pl_Game['expr'] >= $UserNextLvExp) {
        $Pl_Game['level'] += 1;
        $Pl_Game['spmax'] += 1;
        if ($Pl_Game['level'] % 10 == 0) {
            $Pl_Game['spmax'] += 5;
        }
        $Pl_Game['expr'] = 0;
        $Pl_Gen['growth'] = $Pl_Gen['growth'] + $Pl_Stat_Gain;
        $Result_Tag .= "<br>你升了級！<br>獲得 $Pl_Stat_Gain 點成長點數！";
        $UpD_Pl_level = '1';
    }
    if ($Op_Game['expr'] >= $OppoNextLvExp) {
        $Op_Game['level'] += 1;
        $Op_Game['spmax'] += 1;
        if ($Op_Game['level'] % 10 == 0) {
            $Op_Game['spmax'] += 5;
        }
        $Op_Game['expr'] = 0;
        $Op_Gen['growth'] = $Op_Gen['growth'] + $Op_Stat_Gain;
        $Result_Tag .= '<br>對手升了級！';
        $UpD_Op_level = '1';
    }
        //Type Level Up
                $TypeRank = 0;
    if ($Pl_Game['level'] >= 900) {
        $TypeRank = 10;
    } elseif ($Pl_Game['level'] >= 800) {
        $TypeRank = 9;
    } elseif ($Pl_Game['level'] >= 700) {
        $TypeRank = 8;
    } elseif ($Pl_Game['level'] >= 600) {
        $TypeRank = 7;
    } elseif ($Pl_Game['level'] >= 500) {
        $TypeRank = 6;
    } elseif ($Pl_Game['level'] >= 400) {
        $TypeRank = 5;
    } elseif ($Pl_Game['level'] >= 300) {
        $TypeRank = 4;
    } elseif ($Pl_Game['level'] >= 200) {
        $TypeRank = 3;
    } elseif ($Pl_Game['level'] >= 100) {
        $TypeRank = 2;
    }
    $UpDateSQL_TypeCH = '';
    if ($TypeRank) {
        if (eregi('[nat]{3}', $Pl_Gen['typech'])) {
            $TypeCH_An = '[nat]{3}';
        } elseif (eregi('[enh]{3}', $Pl_Gen['typech'])) {
            $TypeCH_An = '[enh]{3}';
        } elseif (eregi('[ext]{3}', $Pl_Gen['typech'])) {
            $TypeCH_An = '[ext]{3}';
        } elseif (eregi('[psy]{3}', $Pl_Gen['typech'])) {
            $TypeCH_An = '[psy]{3}';
        } elseif (eregi('[nt]{2}', $Pl_Gen['typech'])) {
            $TypeCH_An = '[nt]{2}';
        } elseif (eregi('[co]{2}', $Pl_Gen['typech'])) {
            $TypeCH_An = '[co]{2}';
        }
        $sqltypeup = ('SELECT `id`, `typelv` FROM `'.$GLOBALS['DBPrefix']."phpeb_sys_chtype` WHERE `id` REGEXP '$TypeCH_An' AND `typelv` = '$TypeRank' LIMIT 1;");
        $TypeCH_Q = mysql_query($sqltypeup) or die('無法更新基本資訊1, 原因:'.mysql_error().'<br>');
        $TypeCH_New = mysql_fetch_array($TypeCH_Q) or die('無法更新基本資訊2, 原因:'.mysql_error().'<br>');
        if ($TypeCH_New['id'] != $Pl_Gen['typech']) {
            $UpDateSQL_TypeCH = (", `typech` = '$TypeCH_New[id]'");
        }
    }
        //Update Information
                $t_now = time();
    $sqlgen = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `bounty` = '$Pl_Gen[bounty]',`fame` = '$Pl_Gen[fame]', `cash` = '$Pl_Gen[cash]', `hypermode` = '$Pl_Gen[hypermode]', `growth` = '$Pl_Gen[growth]', `time1` = '$t_now', `time2` = '$t_now', `btltime` = '$t_now', `bcount` = `bcount`+1, `evamode` = '$Pl_Gen[evamode]' $UpDateSQL_TypeCH WHERE `username` = '$Pl_Gen[username]' LIMIT 1;");
    if ($AtkFortFlag != '1') {
        $sqlgenop = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `bounty` = '$Op_Gen[bounty]',`fame` = '$Op_Gen[fame]', `hypermode` = '$Op_Gen[hypermode]', `growth` = '$Op_Gen[growth]', `time1` = '$t_now', `evamode` = '$Op_Gen[evamode]' WHERE `username` = '$Op_Gen[username]' LIMIT 1;");
    } else {
		$Op_Resulting_HP = floor($Op_Resulting_HP/10);
        $sqlgenop = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_map` SET `hp` = '$Op_Resulting_HP' WHERE `map_id` = '$Pl_Gen[coordinates]' LIMIT 1;");
    }
    mysql_query($sqlgen) or die('無法取得基本資訊, 原因:'.mysql_error().'<br>'.postFooter());
    mysql_query($sqlgenop) or die('無法取得基本資訊, 原因:'.mysql_error().'<br>'.postFooter());
    $sqlgame = ('UPDATE `'.$GLOBALS['DBPrefix'].'phpeb_user_game_info` SET ');
    $sqlgame .= ("`hp` = '$Pl_Resulting_HP', ");
    $sqlgame .= ("`en` = '$Pl_Resulting_EN', ");
    $sqlgame .= ("`sp` = '$Pl_Resulting_SP', ");
    if ($UpD_Pl_level) {
        $sqlgame .= ("`spmax` = '$Pl_Game[spmax]', ");
        $sqlgame .= ("`level` = '$Pl_Game[level]', ");
    }
    $sqlgame .= ("`expr` = '$Pl_Game[expr]', ");
    $sqlgame .= ("`wepa` = '$Pl_Game[wepa]', ");
    $sqlgame .= ("`wepb` = '$Pl_Game[wepb]', ");
    $sqlgame .= ("`wepc` = '$Pl_Game[wepc]', ");
    $sqlgame .= ("`eqwep` = '$Pl_Game[eqwep]', ");
    $sqlgame .= ("`status` = '$Pl_Game[status]', ");
    if ($Pl_Tactics['id'] != $Pl_Tactics['last_tact']) {
        $sqlgame .= ("`last_tact` = '$Pl_Tactics[id]', ");
    }
    $sqlgame .= ("`victory` = '$Pl_Game[victory]', ");
    $sqlgame .= ("`v_points` = '$Pl_Game[v_points]', ");
    $sqlgame .= ("`spec` = '$Pl_Game[spec]', ");
    $sqlgame .= ("`rank` = '$Pl_Game[rank]' ");
    $sqlgame .= ("WHERE `username` = '$Pl_Game[username]' LIMIT 1;");
    $sqlgameop = ('UPDATE `'.$GLOBALS['DBPrefix'].'phpeb_user_game_info` SET');
    $sqlgameop .= ("`hp` = '$Op_Resulting_HP',");
    $sqlgameop .= ("`en` = '$Op_Resulting_EN',");
    if ($UpD_Op_level) {
        $sqlgameop .= ("`spmax` = '$Op_Game[spmax]',");
        $sqlgameop .= ("`level` = '$Op_Game[level]',");
    }
    if ($SP_CostOp) {
        $sqlgameop .= ("`sp` = '$Op_Game[sp]',");
    }
    $sqlgameop .= ("`expr` = '$Op_Game[expr]',");
    $sqlgameop .= ("`wepa` = '$Op_Game[wepa]',");
    $sqlgameop .= ("`status` = '$Op_Game[status]',");
    if ($Op_NewSeed == 1) {
        $sqlgameop .= ("`spec` = '$Op_Game[spec]', ");
    }
    $sqlgameop .= ("`tactics` = '$Op_Game[tactics]'");
    $sqlgameop .= ("WHERE `username` = '$Op_Game[username]' LIMIT 1;");
    mysql_query($sqlgame) or die('無法更新遊戲資訊( 1 ), 原因:'.mysql_error().'<br>'.postFooter());
    if ($AtkFortFlag != '1') {
        mysql_query($sqlgameop) or die('無法更新遊戲資訊( 2 ), 原因:'.mysql_error().'<br>'.postFooter());
    }

                //Write Logs
                if ($Pl_Settings['show_log_num'] || $Op_Settings['show_log_num']) {
                    if ($LogEntries) {
                        if ($Pl_Settings['show_log_num'] > $LogEntries) {
                            $Pl_LEnt = $LogEntries;
                        } else {
                            $Pl_LEnt = $Pl_Settings['show_log_num'];
                        }
                        if ($Op_Settings['show_log_num'] > $LogEntries) {
                            $Op_LEnt = $LogEntries;
                        } else {
                            $Op_LEnt = $Op_Settings['show_log_num'];
                        }
                        unset($TmpLogVar);
                        $sqllog = ('UPDATE `'.$GLOBALS['DBPrefix'].'phpeb_user_log` SET');
                        if ($Pl_LEnt == 5) {
                            $sqllog .= ('`log5` = `log4`,');
                            $TmpLogVar[3] = '`time5` = `time4`,';
                        }
                        if ($Pl_LEnt >= 4) {
                            $sqllog .= ('`log4` = `log3`,');
                            $TmpLogVar[2] = '`time4` = `time3`,';
                        }
                        if ($Pl_LEnt >= 3) {
                            $sqllog .= ('`log3` = `log2`,');
                            $TmpLogVar[1] = '`time3` = `time2`,';
                        }
                        if ($Pl_LEnt >= 2) {
                            $sqllog .= ('`log2` = `log1`,');
                            $TmpLogVar[0] = '`time2` = `time1`,';
                        }
                        $sqllog .= ("`log1` = '你與$Op_Game[gamename]交戰！$Pl_Log_Tag',".$TmpLogVar[3].$TmpLogVar[2].$TmpLogVar[1].$TmpLogVar[0]);
                        $sqllog .= ("`time1` = '$t_now' WHERE `username` = '$Pl_Gen[username]' LIMIT 1;");
                        unset($TmpLogVar);
                        $sqllogop = ('UPDATE `'.$GLOBALS['DBPrefix'].'phpeb_user_log` SET');
                        if ($Op_LEnt == 5) {
                            $sqllogop .= ('`log5` = `log4`,');
                            $TmpLogVar[3] = '`time5` = `time4`,';
                        }
                        if ($Op_LEnt >= 4) {
                            $sqllogop .= ('`log4` = `log3`,');
                            $TmpLogVar[2] = '`time4` = `time3`,';
                        }
                        if ($Op_LEnt >= 3) {
                            $sqllogop .= ('`log3` = `log2`,');
                            $TmpLogVar[1] = '`time3` = `time2`,';
                        }
                        if ($Op_LEnt >= 2) {
                            $sqllogop .= ('`log2` = `log1`,');
                            $TmpLogVar[0] = '`time2` = `time1`,';
                        }
                        $sqllogop .= ("`log1` = '$Pl_Game[gamename]與你交戰！$Op_Log_Tag',".$TmpLogVar[3].$TmpLogVar[2].$TmpLogVar[1].$TmpLogVar[0]);
                        $sqllogop .= ("`time1` = '$t_now' WHERE `username` = '$Op_Gen[username]' LIMIT 1;");
                        mysql_query($sqllog) or die('無法取得基本資訊, 原因:'.mysql_error().'<br>'.postFooter());
                        if ($AtkFortFlag != '1') {
                            mysql_query($sqllogop) or die('無法取得基本資訊, 原因:'.mysql_error().'<br>'.postFooter());
                        }
                    }
                }
                //End of Write Logs

                $seltime = time();
    $atkname = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_game_info` SET lastatk='$Op_Game[gamename]' WHERE username='$Pl_Game[username]'");
    mysql_query($atkname);
    $attime = ('UPDATE `'.$GLOBALS['DBPrefix']."phpeb_user_game_info` SET atktime='$seltime' WHERE username='$Pl_Game[username]'");
    mysql_query($attime);

        //Echo Results
        echo '<tr align=center>';
    echo "<td>武器: $Pl_SyWepA[name] 經驗: $Pl_WepA[1]<br>";
    if ($Pl_WepD[0]) {
        echo "輔助裝備: $Pl_SyWepD[name] 經驗: $Pl_WepD[1]<br>";
    }
    if ($Pl_WepE[0]) {
        echo "常規裝備: $Pl_SyWepE[name] 經驗: $Pl_WepE[1]<br>";
    }
    echo "</td><td>武器: $Op_SyWepA[name] 經驗: $Op_WepA[1]<br>";
    if ($Op_WepD[0]) {
        echo "輔助裝備: $Op_SyWepD[name] 經驗: $Op_WepD[1]<br>";
    }
    if ($Op_WepE[0]) {
        echo "常規裝備: $Op_SyWepE[name] 經驗: $Op_WepE[1]<br>";
    }
    echo '</td></tr>';
    echo '<tr align=center>';
    echo '<td width=50%>';
    $HitTimes = $StrikeRds;
    $MissTime = 0;
    $MissTime = $Pl_SyWepA['rd'] - $StrikeRds;
    $HitIcon = 1;
    $MissIcon = 1;
    if (!ereg('[MirrorDam]{9}', $Pl_SyWepA['spec'])) {
        while ($HitIcon <= $HitTimes) {
            echo "<img src='$Base_Image_Dir/hit.gif'>";
            ++$TIcons;
            if ($TIcons == 10) {
                echo'<br>';
                $TIcons = 0;
            }
            ++$HitIcon;
        }
        while ($MissIcon <= $MissTime) {
            echo "<img src='$Base_Image_Dir/miss.gif'>";
            ++$TIcons;
            if ($TIcons == 10) {
                echo'<br>';
                $TIcons = 0;
            }
            ++$MissIcon;
        }
    } else {
        echo '--- 反射 ---';
    }
    echo'</td>';
    echo '<td width=50%>';
    $CHitTimes = $CStrikeRds;
    $CMissTime = 0;
    $CMissTime = $Op_SyWepA['rd'] - $CStrikeRds;
    $CHitIcon = 1;
    $CMissIcon = 1;
    if (!ereg('[MirrorDam]{9}', $Op_SyWepA['spec']) && !$OpNoENFlag) {
        while ($CHitIcon <= $CHitTimes) {
            echo "<img src='$Base_Image_Dir/hit.gif'>";
            ++$CTIcons;
            if ($CTIcons == 10) {
                echo'<br>';
                $CTIcons = 0;
            }
            ++$CHitIcon;
        }
        while ($CMissIcon <= $CMissTime) {
            echo "<img src='$Base_Image_Dir/miss.gif'>";
            ++$CTIcons;
            if ($CTIcons == 10) {
                echo'<br>';
                $CTIcons = 0;
            }
            ++$CMissIcon;
        }
    } elseif ($OpNoENFlag) {
        echo '能源不足！！';
    } else {
        echo '--- 反射 ---';
    }
    echo'</td>';
    echo '</tr>';
    echo '<tr align=center>';
    echo "<td>$Pl_Tactics[name]<br>";
	if ($AtkFortFlag == '1'){
		$Pl_Dealt = floor($Pl_Dealt/10);
		echo "你擊中對手 $StrikeRds 次，並造成 $Pl_Dealt 點傷害。</td>";
	} elseif ($StrikeRds) {
        echo "你擊中對手 $StrikeRds 次，並造成 $Pl_Dealt 點傷害。</td>";
    } elseif (ereg('[MirrorDam]{9}', $Pl_SyWepA['spec']) && $Pl_Dealt) {
        echo "反射傷害，造成 $Pl_Dealt 點傷害。</td>";
    } else {
        echo '你未能擊中對手！</td>';
    }
    echo "<td>$Op_Tactics[name]<br>";
    if ($CStrikeRds && !$OpNoENFlag) {
        echo "對手擊中你 $CStrikeRds 次，並造成 $Op_Dealt 點傷害。</td>";
    } elseif ($OpNoENFlag == '1') {
        echo '反擊不能。</td>';
    } elseif (ereg('[MirrorDam]{9}', $Op_SyWepA['spec']) && $Op_Dealt) {
        echo "反射傷害，造成 $Op_Dealt 點傷害。</td>";
    } else {
        echo '對手未能擊中你！</td>';
    }

    echo '</tr>';

    echo '<tr align=center>';
    echo '<td>';

    $Player_init_damaged = ($Pl_Game['hpmax'] - $Pl_Game['hp']) / $Pl_Game['hpmax'] * 150;
    $Player_init_endamaged = ($Pl_Game['enmax'] - $Pl_Game['en']) / $Pl_Game['enmax'] * 130;
    $Player_now_dealt = ($Pl_Game['hp'] - $Pl_Resulting_HP) / $Pl_Game['hpmax'] * 150;
    $Player_now_endealt = ($Pl_Game['en'] - $Pl_Resulting_EN) / $Pl_Game['enmax'] * 130;
    $Player_now_left = $Pl_Resulting_HP / $Pl_Game['hpmax'] * 150;
    $Player_now_enleft = $Pl_Resulting_EN / $Pl_Game['enmax'] * 130;
    $Oppo_init_damaged = ($Op_Game['hpmax'] - $Op_Game['hp']) / $Op_Game['hpmax'] * 150;
    $Oppo_now_dealt = ($Op_Game['hp'] - $Op_Resulting_HP) / $Op_Game['hpmax'] * 150;
    $Oppo_now_left = $Op_Resulting_HP / $Op_Game['hpmax'] * 150;
    echo "<img src='$Base_Image_Dir/hp.gif' hspace=0 height=7 width=$Player_now_left><img src='$Base_Image_Dir/hp.gif' hspace=0 height=7 width=$Player_now_left><img src='$Base_Image_Dir/dmg.gif' hspace=0 height=7 width=$Player_now_dealt><img src='$Base_Image_Dir/zen.gif' hspace=0 height=7 width=$Player_init_damaged>";
    echo "<br>生命值: <span id=Pl_Res_Hp>$Pl_Game[hp]</span>/$Pl_Game[hpmax]<br>";
    echo "<img src='$Base_Image_Dir/hp.gif' hspace=0 height=7 width=$Player_now_left><img src='$Base_Image_Dir/hp.gif' hspace=0 height=7 width=$Player_now_enleft><img src='$Base_Image_Dir/dmg.gif' hspace=0 height=7 width=$Player_now_endealt><img src='$Base_Image_Dir/zen.gif' hspace=0 height=7 width=$Player_init_endamaged>";
    echo "<br>能量值: <span id=Pl_Res_Hp>$Pl_Game[en]</span>/$Pl_Game[enmax]<br>消耗能量: ".number_format($Pl_SyWepA['enc'] + $Pl_SyWepD['enc'] + $Pl_SyWepE['enc']).'</td>';
    echo '<td>';
    echo "<img src='$Base_Image_Dir/hp.gif' hspace=0 height=7 width=$Oppo_now_left><img src='$Base_Image_Dir/dmg.gif' hspace=0 height=7 width=$Oppo_now_dealt><img src='$Base_Image_Dir/zen.gif' hspace=0 height=7 width=$Oppo_init_damaged>";
    echo "<br>生命值: <span id=Op_Res_Hp>$Op_Game[hp]</span>/$Op_Game[hpmax]<br>消耗能量: ".number_format($Op_SyWepA['enc'] + $Op_SyWepD['enc'] + $Op_SyWepE['enc']).'</td>';
    echo '</tr>';
    echo '<tr align=center>';
    echo '<td colspan=2 style="color: #C0FF3E;font-size: 10">';
    echo "得到 $Pl_Gain_Exp 點經驗值和武器經驗 $Pl_Gain_Wep_Exp 點。<br>";
    echo "獲得金錢 $Pl_Gain_Money 元。";
    if ($Gain_BountyFlag) {
        echo "另外獲得 $Gain_Bounty 元的懸賞金。";
    }
    echo "$Result_Tag";
    echo "$Spec_Event_Tag";
    echo '</td>';
    echo '</tr>';
    echo '</table>';
	echo "<script type=\"text/javascript\" src=\"js/battle.js\"></script>";
    if ($CFU_Time - $Op_Gen['time2'] < $Offline_Time) {
        if (!$OrgWarOppos && $Op_Gen['fame'] >= 0 && $Pl_Gen['fame'] >= $NotoriousIgnore && $Pl_Settings['atkonline_alert']) {
            $OnConfirm = ';return cfmAtkOnline()';
        } else {
            unset($OnConfirm);
        }
    }
    if ($Op_Game['status']) {
        echo '<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=Alpha>';
        echo "<p align=center><input type=submit value=\"返回\" onClick=\"parent.Beta.location.replace('gen_info.php')\"></p>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo '</form>';
    } else {
        echo '<form action=battle.php?action=attack_target method=post name=battle_sel_form>';
        echo "<p align=center><input type=submit name=battle_submit value='再戰' id=\"battle_submit\" onClick=\"$OnConfirm\" disabled=disabled></p>";
		echo "<input type=hidden value='process' name=actionb>";
        echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
        echo "<input type=hidden name=Op_Name value=\"$Op_Name\">";
        $LastTctcs = $Pl_GTctcs;
        if ($LastTctcs != '0') {
            $TactInf = GetTactics("$LastTctcs");
            if ($Pl_Gen['hypermode'] == 1 && $ControlSEED) {
                $TactInf['spc'] = ceil($TactInf['spc'] * 1.25) + 5;
            } //SEED Mode SP額外消耗
                if ($Pl_Gen['hypermode'] >= 4 && $Pl_Gen['hypermode'] <= 6) {
                    $TactInf['spc'] = ceil($TactInf['spc'] * 1.20) + 3;
                } //EXAM System SP額外消耗
                if ($Pl_Game['sp'] - $TactInf['spc'] < 0) {
                    $LastTctcs = 0;
                } elseif ($Pl_Game['en'] < ($Pl_SyWepA['enc'] + $Pl_SyWepD['enc'] + $Pl_SyWepE['enc'] + $TactInf['enc'])) {
                    $LastTctcs = 0;
                }
        }
        echo "<input type=hidden name=Pl_GTctcs value=\"$LastTctcs\">";
        if (ereg('(EXAMSystem)+', $Pl_Game['spec'])) {
            echo "<input type=hidden name='EXAMStat' value=\"$EXAMStat\">";
        }
        if ($ControlSEED && ereg('(SeedMode)+', $Pl_Game['spec']) && ereg('(co|ext|nat)+', $Pl_Gen['typech'])) {
            echo "<input type=hidden name='SEEDStat' value=\"$SEEDStat\"></form>";
        }
    }
    postFooter();
    echo '<script language="JavaScript">';
    echo 'timeID=10;';
    echo "Pl_Dif_Hp=Math.round(($Pl_Game[hp]-$Pl_Resulting_HP)*0.1);";
    echo "Op_Dif_Hp=Math.round(($Op_Game[hp]-$Op_Resulting_HP)*0.1);";
    echo 'flaga=flagb=flagc=0;';
    echo 'setTimeout("HEcount()",2500);';
    echo 'function HEcount(){';
    echo 'Pl_Res_Hp.innerText-=Pl_Dif_Hp;';
    echo 'Op_Res_Hp.innerText-=Op_Dif_Hp;';
    echo "if (eval(Pl_Res_Hp.innerText) <= $Pl_Resulting_HP){Pl_Res_Hp.innerText='$Pl_Resulting_HP';flaga=1;}";
    echo "if (eval(Op_Res_Hp.innerText) <= $Op_Resulting_HP){Op_Res_Hp.innerText='$Op_Resulting_HP';flagb=1;}";
    echo 'clearTimeout(timeID);';
    echo 'if (!flaga || !flagb){timeID = setTimeout("HEcount()",1);}';
    echo '}';
    echo '</script>';
    echo '</html>';
}
?>
