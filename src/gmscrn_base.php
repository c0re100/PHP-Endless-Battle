<?php if ($mode != 'proc') {
  echo 'Invalid Action';
  exit;
} ?>
<?php
//php-eb Game Screen Base Unit
  postHead(1);
  //Assign Variables
  $User = $Pl_Value['USERNAME'];
  $Password = $Pl_Value['PASSWORD'];

  //Fetch Player Information
  include_once('includes/sfo.class.php');
  $Pl = new player_stats;
  $Pl->SetUser($User);
  $Pl->FetchPlayer(true,false,', `request`');

  $Player = &$Pl->Player;

  //Adjust to user's setting
  if ($Player['gen_img_dir'])
  $General_Image_Dir = $Player['gen_img_dir'];
  if ($Player['unit_img_dir'])
  $Unit_Image_Dir = $Player['unit_img_dir'];
  if ($Player['base_img_dir'])
  $Base_Image_Dir = $Player['base_img_dir'];

  //Area and Organization
  $Area = ReturnMap($Player['coordinates']);
  $AreaLandForm = ReturnMType($Area["Sys"]["type"]);
  $LandFormBg = ReturnMBg($Area["Sys"]["type"]);
  $AreaOrg = ReturnOrg($Area["User"]["occupied"]);
  if ($Player['organization'] == $Area["User"]["occupied"]) $Pl_Org = &$AreaOrg;
  else $Pl_Org = ReturnOrg($Player['organization']);

  //Ranks
  $RightsTitle = $Pl_Rank = '';
  if ($Player['rights'] == '1') {$RightsTitle = $RightsClass['Major'];}
  elseif ($Player['rights']) {$RightsTitle = $RightsClass['Leader'];}
  $Pl_Rank = rankConvert($Player['rank']);

  //Process Character Status
  $AtClr = colorConvert($Player['attacking']);
  $DeClr = colorConvert($Player['defending']);
  $ReClr = colorConvert($Player['reacting']);
  $TaClr = colorConvert($Player['targeting']);

  $NextStatPt_At=$Player['attacking']+1;
  $NextStatPt_De=$Player['defending']+1;
  $NextStatPt_Re=$Player['reacting']+1;
  $NextStatPt_Ta=$Player['targeting']+1;

  CalcStatReq('At',"$NextStatPt_At");
  CalcStatReq('De',"$NextStatPt_De");
  CalcStatReq('Re',"$NextStatPt_Re");
  CalcStatReq('Ta',"$NextStatPt_Ta");

  $Stat_Add = array();
  $Stat_Add['at'] = $Stat_Add['de'] = $Stat_Add['re'] = $Stat_Add['ta'] = $Stat_Add['sp'] = array('Style' => '', 'Image' => '');

  setAddStatImg($Player['growth'],$At_Stat_Req,$Player['attacking'],$Stat_Add['at']);
  setAddStatImg($Player['growth'],$De_Stat_Req,$Player['defending'],$Stat_Add['de']);
  setAddStatImg($Player['growth'],$Re_Stat_Req,$Player['reacting'], $Stat_Add['re']);
  setAddStatImg($Player['growth'],$Ta_Stat_Req,$Player['targeting'],$Stat_Add['ta']);
  setAddStatImg($Player['growth'],$SP_Stat_Req,0,$Stat_Add['sp']); // To be set in CFU

  // Process Character Information
  // Using Phase Structure

  //
  // Prephase I
  //

  //Get User MS Stats
  if ($Player['msuit'] == "nil") $Player['msuit'] = '0';
  $Pl->ProcessMS(true);
  $Ms = &$Pl->MS;
  if ($Player['msuit']) {
    // Repair and Update
    $RepUpdateFlag = (($CFU_Time - $Player['time1']) >= 5);
    $Pl_Repaired = RepairPlayer($Pl->Player,$Pl->Eq['D'],$Pl->Eq['E'],0,0,$RepUpdateFlag);
    $Pl->Player['hp'] = $Pl_Repaired['hp'];
    $Pl->Player['en'] = $Pl_Repaired['en'];
    $Pl->Player['sp'] = $Pl_Repaired['sp'];
    $Pl->Player['status'] = $Pl_Repaired['status'];
    $Pl->Player['time1'] = $Pl_Repaired['time1'];
  }

  // Initialize Player Details
  $Pl->iniFixes(true);
  $Pl->analyzeHypermodeState();
  $Pl->ProcessAllWeapon();

  //
  // Prephase II
  //

  // Set Spec Sub-System: Check Requirements
  $Pl->checkSetSpec();
  if ($Pl->SetSpecID) {
    // Include Interface
    include_once('includes/spc/spc.superclass.php');
    // Include Implementation Classes
    include_once('includes/spc/spc.'.$Pl->SetSpecID.'.class.php');
    $str = '$Pl->SetSpec = new sSpc_'.$Pl->SetSpecID.'($Pl);';
    eval($str);
    $Pl->SetSpec->checkSetActivation();
    $Pl->SetSpec->prephase();
  }

  // Apply Weapon/Equipment Type Custom Limitations
  $Pl->applyTypeCustoms();

  //
  // Metaphase
  //

  //Generate Special Ability Pool
  $Pl->generateSpecialAbilityPool();

  // Meta-phase Set Specs
  if ($Pl->SetSpecID) $Pl->SetSpec->metaphase();

  // Pilot Hypermode Effects
  $Pl->applyEXAM();
  $Pl->applySEEDMode();
  $Pl->deterSpecRequirements();

  // MS Effects
  //Upper-case Mob Effects
  $Pl->applyMSMobU();
  //Upper-case Tar Effect
  $Pl->applyMSTarU();
  //Upper-case Def Specs
  $Pl->applyMSDefU();

  //Organization War Information
    $Otp_TellTime = $WarColor = '';
    $Otp_Area_Sql = ("SELECT `t_start`,`t_end`,`a_org`,`b_org`,`ticket_a`,`ticket_b`,`victory` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `mission` = 'Atk<$Player[coordinates]>' AND `t_end` > '$CFU_Time' ORDER BY `t_start` ASC LIMIT 1");
    $Otp_Area_Q = mysql_query($Otp_Area_Sql) or die(mysql_error());
    $Otp_A_ITar = mysql_fetch_array($Otp_Area_Q);
    if ($Otp_A_ITar) {
      $WarColor = 'color: FF7575;';
      if ($Otp_A_ITar['t_start'] >= $CFU_Time) {
      $TimeTSSec = $Otp_A_ITar['t_start'] - $CFU_Time;
      $TimetS['hours'] = floor($TimeTSSec/3600);
      $TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
      $TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
      $Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒開始戰爭。";
      }
      else{
      $TimeTSSec = $Otp_A_ITar['t_end'] - $CFU_Time;
      $TimetS['hours'] = floor($TimeTSSec/3600);
      $TimetS['minutes'] = floor(($TimeTSSec - ($TimetS['hours']*3600))/60);
      $TimetS['seconds'] = floor($TimeTSSec - ($TimetS['hours']*3600) - ($TimetS['minutes']*60));
      $Otp_TellTime = "還有$TimetS[hours]小時$TimetS[minutes]分鐘$TimetS[seconds]秒戰爭宣告終了。";}
    }

  //Behaviour Check
  if ($Use_Behavior_Checker) {
    include_once('includes/behavior_checker.class.php');
    $BChecker = new BehaviorChecker($Pl, $GLOBALS['Btl_Intv'], 0, $GLOBALS['Offline_Time'], $GLOBALS['CFU_Time'], $GLOBALS['DBPrefix']);
    $BChecker->checkInsomnia();
  }

  //
  // View Phase
  //Start Printing
  echo '<script type="text/javascript">';
  echo "window.moveTo(0,0);";
  echo "this.window.name = '$PriTarget';";
  echo "window.PriTarget = '$PriTarget';";
  echo "window.SecTarget = '$SecTarget';";
  echo "resizeTo(screen.availWidth,screen.availHeight);";
  echo "window.SP_Stat_Req = $SP_Stat_Req";
  echo "</script>";

  echo '<link href="/images/gmscrn.style.css" rel="stylesheet" type="text/css" />';
  echo '<script type="text/javascript" src="/js/gmscrn_base.js"></script>';

  echo "<body leftmargin=\"0\" topmargin=\"0\" bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" oncontextmenu=\"return true;\">";

  //Include Left Menu
  include_once('gmscrn_left_menu.php');


  //Include Right Menu
  include_once('gmscrn_right_menu.php');

  //Commands - JavaScript
  echo '<script type="text/javascript">
    setTimeout(enablerf, 2000);
    </script>';

  //Log Display
  if ($Player['show_log_num'] > $LogEntries)
  $Pl_LEnt = $LogEntries;
  else $Pl_LEnt = $Player['show_log_num'];
  echo "<div id=LogDis style=\"position:absolute; right: -945px; top: 100px; width: 320px;z-index: 1;\" onMouseOver=focusZ(this.id) onMouseOut=blurZ(this.id)> ";
  echo "<table class=\"base full-width\"><tr height=114>";
  echo "<td width=26 style=\"background-Image: url('$General_Image_Dir/neo/table_log_l.png');\">&nbsp;</td>";
  echo "<td width=294 style=\"background-color: $Player[color];\"><img src='$General_Image_Dir/neo/table_log_r.png'></td>";
  echo "</tr><tr><td colspan=2 style=\"background-Image: url('$General_Image_Dir/neo/table_bg.gif'); border:solid #707070 1px; border-top: 0px;\" valign=top>";
    echo "<table class=\"base long center-align\">";
      $Pl_Log=GetUsrLog($User) or die ('無法取得紀錄資訊！！<br>請聯絡管理員！<br>錯誤代號: GB-001');
      for($LogShowNum=1;$LogShowNum<=$Pl_LEnt;$LogShowNum++) {
        $i = 'time'.$LogShowNum;
        $j = 'log'.$LogShowNum;
        $Pl_Log[$i] = (isset($Pl_Log[$i])) ? $Pl_Log[$i] : 0;
        $Pl_Log[$j] = (isset($Pl_Log[$j])) ? $Pl_Log[$j] : '';
        if ($Pl_Log[$i]) {
        echo "<tr><td id=log$i style=\"font-weight: Bold\">".cfu_time_convert($Pl_Log[$i])."</td></tr>";
        echo "<tr><td id=log$j style=\"padding-left: 4px;font-size: 8pt\">$Pl_Log[$j]</td></tr>";
        }
      }
    echo "</table>";
  echo "</td></tr>";
  echo "</table>";
  echo "</div>";

  //Equipment Status Screen
  echo "<div id=EqStat style=\"position:absolute; right: -960px; top: 85px; width: 320px;z-index: 1;\" onMouseOver=focusZ(this.id) onMouseOut=blurZ(this.id)> ";
  echo "<table class=\"base full-width\"><tr height=114>";
  echo "<td width=26 style=\"background-Image: url('$General_Image_Dir/neo/table_eq_l.png');\">&nbsp;</td>";
  echo "<td width=294 style=\"background-color: $Player[color];\"><img src='$General_Image_Dir/neo/table_eq_r.png'></td>";
  echo "</tr><tr><td colspan=2 style=\"background-Image: url('$General_Image_Dir/neo/table_bg.gif'); border:solid #707070 1px; border-top: 0px;\" valign=top>";

  //
  // Quick Equip Control - Start
  //

  echo "<table class=\"base long center-align\">";
  echo "<tr><td>";

  // Listing Variable
  $Eq_Listing = Array('A' => 'wepa','B' => 'wepb','C' => 'wepc','D' => 'eqwep','E' => 'p_equip');
  $W_Inf = Array('A' => '','B' => '','C' => '','D' => '','E' => '');
  $Count_Eq = 0;

  // Functions
  include_once('includes/gmscrn.eq_tips.inc.php');

  // Begin Transversing through List
  foreach($Eq_Listing as $I => $V) {

    // Prepare Basic Information
    prepBasixEqInfoString($Pl, $I, $W_Inf);

    // Print name phrase, starts <div> tag
    printQuickEquipNamePhrase($I, $Pl->Eq[$I]['id'], $Pl->Eq[$I]['name'],$W_Inf);

    // Print Condition Level / Exp
    printCondLevel($Pl, $I);

    // Print Controls
    if ($I == 'B' || $I == 'C') {
      echo "<br>";
      $tmpBool = ($Pl->Eq[$I]['id'] != '0' && canEquipAsWep($Pl->Eq[$I]));
      printQuickEquipSpanTag($V,$I,'W','E','equip', $tmpBool, '(裝備此武器)');
      echo "&nbsp;";
      $tmpBool = ($Pl->Eq[$I]['id'] != '0' && $Pl->Eq[$I]['equip']);
      printQuickEquipSpanTag($V,$I,'E','W','equipdef', $tmpBool, '(裝上輔助裝備)');
    }
    elseif ($I == 'D') {
      echo "<br>";
      $tmpBool = ($Pl->Eq[$I]['id'] != '0' && ($Pl->Eq['B']['id'] == '0' || $Pl->Eq['C']['id'] == '0'));
      printQuickEquipSpanTag('eqwep','D','R',false,'equipdef', $tmpBool, '(卸下此裝備)');
    }

    // End Div Tag
    echo "</div>";

    $Count_Eq++;
  }
  if (!$Count_Eq) echo "沒有任何裝備";

  echo "<br></td></tr></table>";

  //
  // Quick Equip Control - End
  //
  echo "</td></tr>";
  echo "</table>";
  echo "</div>";

  //MS Status Screen
  echo "<div id=MSStat style=\"position:absolute; right: -985px; top: 70px; width: 320px;z-index: 1;\" onMouseOver=focusZ(this.id) onMouseOut=blurZ(this.id)> ";
  echo "<table class=\"base full-width\"><tr height=114>";
  echo "<td width=26 style=\"background-Image: url('$General_Image_Dir/neo/table_ms_l.png');\">&nbsp;</td>";
  echo "<td width=294 style=\"background-color: $Player[color];\"><img src='$General_Image_Dir/neo/table_ms_r.png'></td>";
  echo "</tr><tr><td colspan=2 style=\"background-Image: url('$General_Image_Dir/neo/table_bg.gif'); border:solid #707070 1px; border-top: 0px;\" valign=top>";
    $Ms_At_Mod = $Ms['atf']-$Ms['base']['atf'];
    $Ms_De_Mod = $Ms['def']-$Ms['base']['def'];
    $Ms_Re_Mod = $Ms['ref']-$Ms['base']['ref'];
    $Ms_Ta_Mod = $Ms['taf']-$Ms['base']['taf'];
    echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;\" width=\"300\">";
    echo "<tr style=\"font-weight: Bold;\"><td colspan=4>$Ms[msname]</td></tr>";
    echo "<tr><td colspan=4 align=center><img src=\"".$Unit_Image_Dir."/$Ms[image]\" name=ms_img></td></tr>";
    echo "<tr><td colspan=4 align=center><img src='$General_Image_Dir/neo/dot_rule.gif'></td></tr>";
    echo "<tr style=\"font-weight: Bold;\">";
    echo "<td width=60 align=center>Attacking</td>";
    echo "<td width=30 align=right style=\"color: ".colorConvert($Ms['atf'],65)."\" id=ms_at>".$Ms['atf']."</td>";
    echo "<td width=30 style=\"color: yellow\">&nbsp;(+<span id=ms_c_at>$Ms_At_Mod</span>)</td>";
    echo "<td valign=top rowspan=4 width=180 style=\"font-size: 8pt;padding-left: 5px\"><font style=\"font-size: 10pt\">特殊效果:</font><br><div style=\"margin-left: 10px; padding-left: 10px;\">";
    echo ReturnSpecs($Ms['spec']);
    echo "</span></td></tr>";
    echo "<tr style=\"font-weight: Bold;\">";
    echo "<td width=60 align=center>Defending</td>";
    echo "<td width=30 align=right style=\"color: ".colorConvert($Ms['def'],75)."\" id=ms_de>".$Ms['def']."</td>";
    echo "<td width=30 style=\"color: yellow\">&nbsp;(+<span id=ms_c_de>$Ms_De_Mod</span>)</td>";
    echo "</tr>";
    echo "<tr style=\"font-weight: Bold;\">";
    echo "<td width=60 align=center>Mobility</td>";
    echo "<td width=30 align=right style=\"color: ".colorConvert($Ms['ref'],75)."\" id=ms_re>".$Ms['ref']."</td>";
    echo "<td width=30 style=\"color: yellow\">&nbsp;(+<span id=ms_c_re>$Ms_Re_Mod</span>)</td>";
    echo "</tr>";
    echo "<tr style=\"font-weight: Bold;\">";
    echo "<td width=60 align=center>Targeting</td>";
    echo "<td width=30 align=right style=\"color: ".colorConvert($Ms['taf'],75)."\" id=ms_ta>".$Ms['taf']."</td>";
    echo "<td width=30 style=\"color: yellow\">&nbsp;(+<span id=ms_c_ta>$Ms_Ta_Mod</span>)</td>";
    echo "</tr>";
    echo "<tr><td colspan=4>&nbsp;</td></tr>";
    echo "</table>";
  echo "</td></tr>";
  echo "</table>";
  echo "</div>";

  //Pilot Status Screen
  echo "<div id=PilotStat style=\"position:absolute; right: -1125px; top: 55px; height: 294px; width: 320px;z-index: 1;\" onMouseOver=focusZ(this.id) onMouseOut=blurZ(this.id) > ";
  echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" width=\"100%\"><tr height=114>";
  echo "<td width=26 style=\"background-Image: url('$General_Image_Dir/neo/table_pilot_l.png');\">&nbsp;</td>";
  echo "<td width=294 style=\"background-color: $Player[color];\"><img src='$General_Image_Dir/neo/table_pilot_r.png'></td>";
  echo "</tr><tr><td height=180 colspan=2 style=\"background-Image: url('$General_Image_Dir/neo/table_bg.gif');\" valign=top>";
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;\" width=\"100%\">";
    echo "<tr style=\"font-weight: Bold;\">";

    echo "<td width=50>Level:</td>";
    echo "<td width=100>Type:</td>";
    echo "<td width=70>成長點數:</td>";
    echo "<td width=100>勝利:</td>";
    echo "</tr>";

    echo "<tr height=50 align=center valign=top>";
    echo "<td id=pl_level>$Player[level]</td>";
    echo "<td><b id=pltype";
    if ($Player['hypermode'] == 1 || ($Player['hypermode'] >= 4 && $Player['hypermode'] <= 6))
    echo " style=\"filter: glow(color: 0000FF,strength=2)\"";
    echo ">{$Pl->Player[type_name]}";
    if ($Player['hypermode'] == 1 || $Player['hypermode'] == 5)
      echo "<br><span id=seedTxt style=\"color: FFFF00;font-weight: bold\">SEED Mode</span>";
    else  echo "<br><span id=seedTxt>&nbsp;</span>";
    if ($Player['hypermode'] >= 4 && $Player['hypermode'] <= 6)
      echo "<br><span id=examTxt style=\"color: FF0000;font-weight: bold\">EXAM Activated</span>";
    else  echo "<br><span id=examTxt>&nbsp;</span>";
    echo "</b></td>";
    echo "<td id=pl_growth>$Player[growth]</td>";
    echo "<td align=left>績分:<span id=pl_vpoints>$Player[v_points]</span> <br> 次數:<span id=pl_victories>$Player[victory]</span></td>";
    echo "</tr>";

    echo "<tr><td colspan=4 align=center>";
    echo "<img src='$General_Image_Dir/neo/dot_rule.gif'>";
    echo "</td></tr>";
    echo "<tr><td colspan=4 align=center>";
      echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" width=\"300\">";
      echo "<tr style=\"font-weight: Bold;\">";
      echo "<td width=75 align=center>Attacking</td>";
      echo "<td width=35 align=right><span id=pl_attacking style=\"color: $AtClr;\">$Player[attacking]</span>&nbsp;</td>";
      echo "<td width=35>+ <span id=pl_attackingf>".$Pl->PiFix['attacking']."</span></td>";
      echo "<td width=20 align=center><img src='{$Stat_Add[at][Image]}' style=\"{$Stat_Add[at][Style]}\" onClick=\"this.style.visibility='hidden';add_stat('at')\" id = 'attacking_addlink'></td>";
      $At_Show_Stat_Req = "$At_Stat_Req";
      if ($Player['attacking'] >= 150) $At_Show_Stat_Req = 'N/A';
      echo "<td width=30 align=center id=attacking_stat_req>$At_Show_Stat_Req</td>";
      echo "<td width=75 align=center>攻擊值</td>";
      echo "<td width=30 id=pl_attacking_sum>".($Player['attacking'] + $Pl->PiFix['attacking'])."</td>";
      echo "</tr>";
      echo "<tr style=\"font-weight: Bold;\">";
      echo "<td width=75 align=center>Defending</td>";
      echo "<td width=35 align=right><span id=pl_defending style=\"color: $DeClr;\">$Player[defending]</span>&nbsp;</td>";
      echo "<td width=35>+ <span id=pl_defendingf>".$Pl->PiFix['defending']."</span></td>";
      echo "<td width=20 align=center><img src='{$Stat_Add[de][Image]}' style=\"{$Stat_Add[de][Style]}\" onClick=\"this.style.visibility='hidden';add_stat('de')\" id = 'defending_addlink'></td>";
      $De_Show_Stat_Req = "$De_Stat_Req";
      if ($Player['defending'] >= 150) $De_Show_Stat_Req = 'N/A';
      echo "<td width=30 align=center id=defending_stat_req>$De_Show_Stat_Req</td>";
      echo "<td width=75 align=center>防禦值</td>";
      echo "<td width=30 id=pl_defending_sum>".($Player['defending'] + $Pl->PiFix['defending'])."</td>";
      echo "</tr>";
      echo "<tr style=\"font-weight: Bold;\">";
      echo "<td width=75 align=center>Reacting</td>";
      echo "<td width=35 align=right><span id=pl_reacting style=\"color: $ReClr;\">$Player[reacting]</span>&nbsp;</td>";
      echo "<td width=35>+ <span id=pl_reactingf>".$Pl->PiFix['reacting']."</span></td>";
      echo "<td width=20 align=center><img src='{$Stat_Add[re][Image]}' style=\"{$Stat_Add[re][Style]}\" onClick=\"this.style.visibility='hidden';add_stat('re')\" id = 'reacting_addlink'></td>";
      $Re_Show_Stat_Req = "$Re_Stat_Req";
      if ($Player['reacting'] >= 150) $Re_Show_Stat_Req = 'N/A';
      echo "<td width=30 align=center id=reacting_stat_req>$Re_Show_Stat_Req</td>";
      echo "<td width=75 align=center>回避值</td>";
      echo "<td width=30 id=pl_reacting_sum>".($Player['reacting'] + $Pl->PiFix['reacting'])."</td>";
      echo "</tr>";
      echo "<tr style=\"font-weight: Bold;\">";
      echo "<td width=75 align=center>Targeting</td>";
      echo "<td width=35 align=right><span id=pl_targeting style=\"color: $TaClr;\">$Player[targeting]</span>&nbsp;</td>";
      echo "<td width=35>+ <span id=pl_targetingf>".$Pl->PiFix['targeting']."</span></td>";
      echo "<td width=20 align=center><img src='{$Stat_Add[ta][Image]}' style=\"{$Stat_Add[ta][Style]}\" onClick=\"this.style.visibility='hidden';add_stat('ta')\" id = 'targeting_addlink'></td>";
      $Ta_Show_Stat_Req = "$Ta_Stat_Req";
      if ($Player['targeting'] >= 150) $Ta_Show_Stat_Req = 'N/A';
      echo "<td width=30 align=center id=targeting_stat_req>$Ta_Show_Stat_Req</td>";
      echo "<td width=75 align=center>命中值</td>";
      echo "<td width=30 id=pl_targeting_sum>".($Player['targeting'] + $Pl->PiFix['targeting'])."</td>";
      echo "</tr>";
      echo "<tr style=\"font-weight: Bold;\">";
      echo "<td width=75 align=center>SP</td>";
      echo "<td width=35 align=right>&nbsp;</td>";
      echo "<td width=35>&nbsp;</td>";
      echo "<td width=20 align=center><img src='{$Stat_Add[sp][Image]}' style=\"{$Stat_Add[sp][Style]}\" onClick=\"this.style.visibility='hidden';add_stat('sp')\" id = 'spmax_addlink'></td>";
      $SP_Show_Stat_Req = "$SP_Stat_Req";
      echo "<td width=30 align=center id=sp_stat_req>$SP_Show_Stat_Req</td>";
      echo "<td width=105 align=center colspan=2><input type=\"checkbox\" name=\"disableCfm\" id=\"cbDisableCfm\"> 不要確認</td>";
      echo "</tr>";
      echo "</table>";
    echo "</td></tr>";
    echo "</table>";
  echo "</td></tr>";
  echo "</table>";
  echo "<form action=nil method=post name=addstat target='$SecTarget'>";
  echo "<input type=hidden value='none' name=actionb>";
  echo "<input type=hidden value='$User' name=Pl_Value[USERNAME]>";
  echo "<input type=hidden value='$Password' name=Pl_Value[PASSWORD]>";
  echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
  echo "</form>";
  echo "<form action=nil method=post name=proc_tar target='$ProcTarget'>";
  echo "<input type=hidden value='none' name=actionb>";
  echo "<input type=hidden value='validcode' name=actionc>";
  echo "<input type=hidden value='validcode2' name=slot_sw>";
  echo "<input type=hidden value='$User' name=Pl_Value[USERNAME]>";
  echo "<input type=hidden value='$Password' name=Pl_Value[PASSWORD]>";
  echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
  echo "</form>";
  //iChat Form
  echo "<form action=$iChatScript method=post name=iChatForm target='iChat'>";
  echo "<input type=hidden value='$User' name=username>";
  echo "<input type=hidden value='$Password' name=password>";
  echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
  echo "</form>";
  echo "</div>";

  //Equipment Information Div
  echo "<div id=wepinfo style=\"position:absolute; z-index:3;color: black;\" align=left></div>";

  //Secondary Target Window
  echo "<div id=STiF style=\"position:absolute; left: 2150px; top: 20px; height: 650px; width: 800px;\"> ";
  echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" width=\"100%\"><tr bgcolor=black>";
  echo "<td height=20 width=780 id=iFT style=\"padding-left: 8px\">戰鬥畫面</td>";
  echo "<td width=20 align=center onClick=\"HideSTiF();\" style=\"cursor: pointer\">x</td>";
  echo "</tr><tr><td height=630 colspan=2>";
    echo "<iframe name=\"$SecTarget\" ";
    echo " src=\"about:blank\" marginheight=0 marginwidth=0 frameborder=0 height=630 width=800></iframe>";
  echo "</td></tr>";
  echo "</table>";
  echo "</div>";

  //Process Target Window
  echo "<div id=PTiF style=\"position:absolute; visibility:hidden; left: 21px; top: 20px; height: 0px; width: 0px;\"> ";
  echo "<iframe name=\"$ProcTarget\" src=\"about:blank\" marginheight=0 marginwidth=0 frameborder=0 height=0 width=0></iframe>";
  echo "</div>";

  // TODO: look if we can remove chatUpdate.
  echo '<script type="text/javascript">';
  echo "var chatUpdate = 0;";
  list($hpRate, $enRate, $spRate) = getRecoverRate($Ms, $Player, $Pl);
  echo "
    var hpRate = $hpRate;
    var enRate = $enRate;
    var spRate = $spRate;
  ";
  echo "</script>";

  if ($Otp_TellTime) {
    echo '<script type="text/javascript">';
    echo "  var opt_start = $Otp_A_ITar[t_start];";
    echo "  var opt_time = $Otp_A_ITar[t_end];";
    echo "  var cfu_time = $CFU_Time;";
    echo "  cali_cfu_time();";
    echo "</script>";
  }
?>
  <script type="text/javascript">
  // TODO: fix chat in docekr env. Need to make mysqli working.
  var iChat_ref = null;

  function openChatWindow() {
    if (document.act.noopenchat.value == 0) {
      iChat_ref = window.open('','iChat','location=1,menubar=0,toolbar=0,resizable=1,scrollbars=0,status=0,width=755,height=225');
      document.iChatForm.submit();
      document.act.noopenchat.value = 1;
    } else if (iChat_ref != null) {
      iChat_ref.focus();
    }
  }
  <?php if ($OpenChat)  echo " openChatWindow();"; ?>
  </script>
</body>

<?php
// Functions
function getRecoverRate($Ms, $Player, $Pl) {
  $maxHp = $Player['hpmax'];
  $maxEn = $Player['enmax'];
  $maxSp = $Player['spmax'];

  $hpRate = 0;
  $enRate = 0;
  $spRate = 0;
  if ($Ms['hprec'] >= 1) {
    //Constant HP Recovery
    $hpRate = $Ms['hprec'];
  } else if ($Ms['hprec'] < 1 && $Ms['hprec'] >= 0.001) {
    //Percentage HP Recovery
    $hpRate = $Ms['hprec'] * $maxHp;
  }

  if ($Ms['enrec'] >= 1) {
    $enRate = $Ms['enrec'];
  } else if ($Ms['enrec'] < 1 && $Ms['enrec'] >= 0.001) {
    $enRate = $Ms['enrec'] * $maxEn;
  }

  $eqSpecs = array($Pl->Eq['D']['spec'], $Pl->Eq['E']['spec']);
  foreach ($eqSpecs as $spec) {
    if (strpos($spec,'HPPcRecA') !== false) {
      $hpRate += 0.005 * $maxHp;
    }
    if (strpos($spec,'ENPcRecB') !== false) {
      $enRate += 0.015 * $maxEn;
    }
    if (strpos($spec,'ENPcRecA') !== false) {
      $enRate += 0.0075 * $maxEn;
    }
  }

  $spRate = 0.004 * $maxSp;
  if ($Player['hypermode'] == 2 || $Player['hypermode'] == 6) $spRate *= 2;

  return array($hpRate, $enRate, $spRate);
}

function setAddStatImg($Growth, $StatReq, $Stat, &$aCollection, $Limit=150) {
  global $General_Image_Dir;
  if ($Growth >= $StatReq && $Stat < $Limit) {
    $aCollection['Style'] = " cursor: pointer;";
    $aCollection['Image'] = "$General_Image_Dir/neo/plus_sign.gif";
  } else {
    $aCollection['Style'] = " cursor: default; ";
    $aCollection['Image'] = "$General_Image_Dir/neo/plus_sign_grey.gif";
  }
}

?>
