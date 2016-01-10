<?php
//php-eb Game Screen Base Unit
if ($mode == 'proc'){
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
  if($Player['organization'] == $Area["User"]["occupied"]) $Pl_Org = &$AreaOrg;
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
  if ($Player['msuit']){
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
  if($Pl->SetSpecID){
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
  if($Pl->SetSpecID) $Pl->SetSpec->metaphase();

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
    if ($Otp_A_ITar){
      $WarColor = 'color: FF7575;';
      if ($Otp_A_ITar['t_start'] >= $CFU_Time){
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

  //
  // View Phase
  //

  //Start Printing
  echo "<script type=\"text/JavaScript\">";
  echo "var bgImgDir = \"$General_Image_Dir".$LandFormBg."\";";
  echo "moveTo(0,0);";
  echo "this.window.name = '$PriTarget';";
  echo "resizeTo(screen.availWidth,screen.availHeight);";
  echo "function highlightSS(elm){";
  echo "document.getElementById(elm).className = 'highLight';";
  echo "}";
  echo "function lowlightSS(elm){";
  echo "document.getElementById(elm).className = 'lowLight';";
  echo "}";
  echo "var active_A = active_B = active_C = active_L = 0;";
  echo "function SetStill(elm){";
  echo "if(elm == 'btn1' && active_A == 0){active_A = 1;}";
  echo "else if(elm == 'btn1' && active_A == 1){active_A = 0;}";
  echo "if(elm == 'btn2' && active_B == 0){active_B = 1;}";
  echo "else if(elm == 'btn2' && active_B == 1){active_B = 0;}";
  echo "if(elm == 'btn3' && active_C == 0){active_C = 1;}";
  echo "else if(elm == 'btn3' && active_C == 1){active_C = 0;}";
  echo "if(elm == 'btnlog' && active_L == 0){active_L = 1;}";
  echo "else if(elm == 'btnlog' && active_L == 1){active_L = 0;}";
  echo "}";
  echo "function menuOver(elm,tbl){";
  echo "var num=0;switch(elm){case 'btn1': num=125;break;case 'btn2': num=140;break;case 'btn3': num=165;case 'btnlog': num=180;break;}";
  echo "highlightSS(elm);document.getElementById(tbl).style.right = num;";
  echo "}";
  echo "function menuOut(elm,tbl){";
  echo "if(elm == 'btn1' && active_A == 1){return false;}";
  echo "else if(elm == 'btn2' && active_B == 1){return false;}";
  echo "else if(elm == 'btn3' && active_C == 1){return false;}";
  echo "else if(elm == 'btnlog' && active_L == 1){return false;}";
  echo "else {lowlightSS(elm);document.getElementById(tbl).style.right = -1250;}";
  echo "}";
  echo "function focusZ(elm){";
  echo "document.getElementById(elm).style.zIndex = 2;";
  echo "}";
  echo "function blurZ(elm){";
  echo "document.getElementById(elm).style.zIndex = 1;";
  echo "}";
  echo "function setLayer(posX,posY,Width,Height,msgText){";
  echo "  var X = posX + document.body.scrollLeft + 10;";
  echo "  var Y = posY + document.body.scrollTop + 10;";
  echo "  if(eval(posX + Width + 30) > document.body.clientWidth){";
  echo "    X = eval(posX - Width + document.body.scrollLeft - 20);";
  echo "  }if(eval(posY + Height + 30) > document.body.clientHeight){";
  echo "    Y = eval(posY - Height + document.body.scrollTop - 20);";
  echo "  }if(X<0){";
  echo "    X = 0;";
  echo "  }if(Y<0){";
  echo "    Y = 0;";
  echo "  }";
  echo "  tmpTxt = eval(msgText);";
  echo "  document.getElementById(\"wepinfo\").style.width = Width;";
  echo "  document.getElementById(\"wepinfo\").style.height = 'auto';";
  echo "  document.getElementById(\"wepinfo\").style.backgroundColor = \"ffffdd\";";
  echo "  document.getElementById(\"wepinfo\").style.padding = 10;";
  echo "  document.getElementById(\"wepinfo\").innerHTML = tmpTxt;";
  echo "  document.getElementById(\"wepinfo\").style.border = \"solid 1px #000000\";";
  echo "  document.getElementById(\"wepinfo\").style.left = X;";
  echo "  document.getElementById(\"wepinfo\").style.top  = Y;";
  echo "}function offLayer(){";
  echo "  document.getElementById(\"wepinfo\").style.width = 0;";
  echo "  document.getElementById(\"wepinfo\").style.height = 0;";
  echo "  document.getElementById(\"wepinfo\").innerHTML = \"\";";
  echo "  document.getElementById(\"wepinfo\").style.backgroundColor = \"transparent\";";
  echo "  document.getElementById(\"wepinfo\").style.border = 0;";
  echo "}";
  echo "function proceedAddStat(typeStr){";
  echo "  HideSTiF();";
  echo "  document.addstat.action='statsmod.php?action=addstat';";
  echo "  document.addstat.target='$SecTarget';";
  echo "  document.addstat.actionb.value=typeStr;";
  echo "  document.addstat.submit();";
  echo "}";
  echo "function failAddStat(oSubject, sMsg){";
  echo "  if(sMsg != '') alert(sMsg);";
  echo "  oSubject.visibility = 'visible';";
  echo "  return false;";
  echo "}";
  echo "function cfmAddSP(iGrowth, bChk){";
  echo "  if(bChk) return true;";
  echo "  return confirm('你現在有 '+iGrowth+' 成長點數。\\n要加 10點 SP 的話需要 $SP_Stat_Req 點數。\\n確定嗎?');";
  echo "}";
  echo "function cfmAddStat(iGrowth, sStat, targetStat, rqStat, bChk){";
  echo "  if(bChk) return true;";
  echo "  targetStat = (parseInt(targetStat) + 1);";
  echo "  return confirm('你現在有 '+ iGrowth +' 成長點數。\\n要把'+ sStat +'加到 '+ targetStat +' 的話需要 '+ rqStat +' 點數。\\n確定嗎?');";
  echo "}";
  echo "function add_stat(type){";
  echo "  var iPlGrowth = parseInt(document.getElementById('pl_growth').innerHTML);";
  echo "  var iPlAtk = parseInt(document.getElementById('pl_attacking').innerHTML);";
  echo "  var iPlDef = parseInt(document.getElementById('pl_defending').innerHTML);";
  echo "  var iPlRef = parseInt(document.getElementById('pl_reacting').innerHTML);";
  echo "  var iPlTar = parseInt(document.getElementById('pl_targeting').innerHTML);";
  echo "  var iRAt = parseInt(document.getElementById('attacking_stat_req').innerHTML);";
  echo "  var iRDe = parseInt(document.getElementById('defending_stat_req').innerHTML);";
  echo "  var iRRe = parseInt(document.getElementById('reacting_stat_req').innerHTML);";
  echo "  var iRTa = parseInt(document.getElementById('targeting_stat_req').innerHTML);";
  echo "  var oAtkLnkStyle = document.getElementById('attacking_addlink').style;";
  echo "  var oDefLnkStyle = document.getElementById('defending_addlink').style;";
  echo "  var oRefLnkStyle = document.getElementById('reacting_addlink').style;";
  echo "  var oTarLnkStyle = document.getElementById('targeting_addlink').style;";
  echo "  var oSPLnkStyle  = document.getElementById('spmax_addlink').style;";
  echo "  var chkCfm = document.getElementById('cbDisableCfm').checked;";
  echo "  if (type == 'at'){";
  echo "  if (iPlAtk >= 150){return failAddStat(oAtkLnkStyle,'已達到上限！');}";
  echo "  if (iPlGrowth < iRAt || iPlGrowth == '0'){return failAddStat(oAtkLnkStyle,'你的成長點數不足夠！');}";
  echo "  if (cfmAddStat(iPlGrowth,'Attacking',iPlAtk,iRAt,chkCfm) == true){proceedAddStat('at');}";
  echo "  else{return failAddStat(oAtkLnkStyle,'');}";
  echo "  }";
  echo "  if (type == 'de'){";
  echo "  if (iPlDef >= 150){return failAddStat(oDefLnkStyle,'已達到上限！');}";
  echo "  if (iPlGrowth < iRDe || iPlGrowth == '0'){return failAddStat(oDefLnkStyle,'你的成長點數不足夠！');}";
  echo "  if (cfmAddStat(iPlGrowth,'Defending',iPlDef,iRDe,chkCfm) == true){proceedAddStat('de');}";
  echo "  else{return failAddStat(oDefLnkStyle,'');}";
  echo "  }";
  echo "  if (type == 're'){";
  echo "  if (iPlRef >= 150){return failAddStat(oRefLnkStyle,'已達到上限！');}";
  echo "  if (iPlGrowth < iRRe || iPlGrowth == '0'){return failAddStat(oRefLnkStyle,'你的成長點數不足夠！');}";
  echo "  if (cfmAddStat(iPlGrowth,'Reacting',iPlRef,iRRe,chkCfm) == true){proceedAddStat('re');}";
  echo "  else{return failAddStat(oRefLnkStyle,'');}";
  echo "  }";
  echo "  if (type == 'ta'){";
  echo "  if (iPlTar >= 150){return failAddStat(oTarLnkStyle,'已達到上限！');}";
  echo "  if (iPlGrowth < iRTa || iPlGrowth == '0'){return failAddStat(oTarLnkStyle,'你的成長點數不足夠！');}";
  echo "  if (cfmAddStat(iPlGrowth,'Targeting',iPlTar,iRTa,chkCfm) == true){proceedAddStat('ta');}";
  echo "  else{return failAddStat(oTarLnkStyle,'');}";
  echo "  }";
  echo "  if (type == 'sp'){";
  echo "  if (iPlGrowth < $SP_Stat_Req || iPlGrowth == '0'){return failAddStat(oSPLnkStyle,'你的成長點數不足夠！');}";
  echo "  if (cfmAddSP(iPlGrowth,chkCfm) == true){proceedAddStat('sp');}";
  echo "  else{return failAddStat(oSPLnkStyle,'');}";
  echo "  }}";
  echo "</script>";

  echo "<body leftmargin=\"0\" topmargin=\"0\" bgcolor=\"#000000\" text=#dcdcdc link=#dcdcdc style=\"margin:0px 0px 0px 0px;\" oncontextmenu=\"return true;\">";

  echo '<link href="'.$General_Image_Dir.'/gmscrn.style.css" rel="stylesheet" type="text/css" />';

  echo "<script language=\"JavaScript\">";
  echo "if(screen.availWidth > 1440) document.body.style.backgroundImage= 'url(' + bgImgDir + '1680.jpg)';";
  echo "else if(screen.availWidth > 1280) document.body.style.backgroundImage= 'url(' + bgImgDir + '1440.jpg)';";
  echo "else if(screen.availWidth > 1024) document.body.style.backgroundImage= 'url(' + bgImgDir + '1280.jpg)';";
  echo "else if(screen.availWidth > 800) document.body.style.backgroundImage= 'url(' + bgImgDir + '1024.jpg)';";
  echo "else if(screen.availWidth <= 800) document.body.style.backgroundImage= 'url(' + bgImgDir + '800.jpg)';";
  echo "</script>";

  //Left Status Bar
  echo "<table class=\"base\">";
  echo "<tr height=109 style=\"padding-left: 12px;padding-top: 8px;\" valign=top>";
  echo "<td style=\"background-image: url('$General_Image_Dir/neo/rt_tab_bg.jpg')\" colspan=3 width=200>";
  echo "<font style=\"font-weight: Bold; font-size: 8pt\">機師名稱:</font><br><span style=\"background-color: black; color: $Player[color]; font-weight: Bold; width: 95%;\">&nbsp; $Player[gamename] &nbsp;</span>";
  echo "<br><font style=\"font-weight: Bold; font-size: 8pt\">所屬組織:</font><br><span style=\"background-color: black;width: 95%\"><font style=\"color: $Pl_Org[color]; font-weight: Bold;\">&nbsp; $Pl_Org[name]</font>";
  if ($RightsTitle)
  echo "<font style=\"color: yellow;font-weight: Bold;\"> &nbsp;$RightsTitle</font>";
  echo "&nbsp;($Pl_Rank) &nbsp;";
  echo "</span>";
  echo "<br><font style=\"font-weight: Bold; font-size: 8pt\">所在地區:</font><br><span style=\"background-color: black;width: 95%;$WarColor\"><font style=\"font-weight: Bold;\">&nbsp; $Player[coordinates] ($AreaLandForm)</font> (<font style=\"color: $AreaOrg[color]\">".$AreaOrg['name']."</font>) &nbsp;</span>";
  echo "</td>";
  echo "</tr>";

  //Bar 1: HP
  echo "<tr><td colspan=3 height=10 style=\"font-size: 1px\">&nbsp;</td></tr>";
  echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Player[color];padding-left: 18px;\" height=30 width=175>";
  echo "<b color=FEFEFE>HP: &nbsp;</b><span id=current_hp>$Player[hp]</span> / <span id=max_hp>$Player[hpmax]</span> <br>";
  if($Player['hpmax'] > 0) $HP_Ratio = ceil(($Player['hp']/$Player['hpmax'])*125);
  else $HP_Ratio = 125;
  echo "<img id=hp_bar_l src='$General_Image_Dir/neo/blue_bar.gif' width=".$HP_Ratio." height=5><img id=hp_bar_r src='$General_Image_Dir/neo/orange_bar.gif' width=".(125-$HP_Ratio)." height=5>";
  echo "</td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";

  //Bar 2: EN
  echo "<tr><td colspan=3 height=10 style=\"font-size: 1px\">&nbsp;</td></tr>";
  echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Player[color];padding-left: 18px;\" height=30 width=175>";
  echo "<b color=FEFEFE>EN: &nbsp;</b><span id=current_en>$Player[en]</span> / <span id=max_en>$Player[enmax]</span> <br>";
  if($Player['enmax'] > 0) $EN_Ratio = ceil(($Player['en']/$Player['enmax'])*125);
  else $EN_Ratio = 125;
  echo "<img id=en_bar_l src='$General_Image_Dir/neo/blue_bar.gif' width=".$EN_Ratio." height=5><img id=en_bar_r src='$General_Image_Dir/neo/orange_bar.gif' width=".(125-$EN_Ratio)." height=5>";
  echo "</td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";

  //Bar 3: SP
  echo "<tr><td colspan=3 height=10 style=\"font-size: 1px\">&nbsp;</td></tr>";
  echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Player[color];padding-left: 18px;\" height=30 width=175>";
  if($Player['spmax'] > 0) $SP_Ratio = ceil(($Player['sp']/$Player['spmax'])*125);
  else $SP_Ratio = 125;
  echo "<b color=FEFEFE>SP: &nbsp;</b><span id=current_sp>".round($Player['sp'])."</span> / <span id=max_sp>$Player[spmax]</span> <br>";
  echo "<img id=sp_bar_l src='$General_Image_Dir/neo/blue_bar.gif' width=".$SP_Ratio." height=5><img id=sp_bar_r src='$General_Image_Dir/neo/orange_bar.gif' width=".(125-$SP_Ratio)." height=5>";
  echo "</td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";

  //Bar 4: Exp
  $Show_Exp = $UserNextLvExp = $Show_Exp_Style = '';
  if ($Player['level'] >= 150) {$UserNextLvExp = false;$Show_Exp = '0';} //Hide upon 150Lv
  else {calcExp("$Player[level]");$Show_Exp = number_format($Player['expr'])." / ".number_format($UserNextLvExp);$Show_Exp_Style = ($UserNextLvExp > 10000000) ? "font-size: 8pt;font-weight: Bold" : "";
  echo "<tr><td colspan=3 height=10 style=\"font-size: 1px\">&nbsp;</td></tr>";
  echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Player[color];padding-left: 18px;\" height=30 width=175>";
  echo "<b color=FEFEFE>EXP: &nbsp;</b> <span id=pl_expr style=\"$Show_Exp_Style\">$Show_Exp</span>";
  echo "<br><img id=pl_expr_l src='$General_Image_Dir/neo/blue_bar.gif' width=".ceil(($Player['expr']/$UserNextLvExp)*124)." height=5>";
  echo "<img id=pl_expr_r src='$General_Image_Dir/neo/empty_bar.gif' width=".(124-ceil(($Player['expr']/$UserNextLvExp)*124))." height=5>";
  echo "<img src='$General_Image_Dir/neo/blue_bar.gif' width=1 height=5>";
  echo "</td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";
  }

  //Include Left Menu
  include_once('gmscrn_left_menu.php');

  //Bar 8: Request
  if ($Player['request']){
  echo "<tr><td colspan=3 height=10 style=\"font-size: 1px\">&nbsp;</td></tr>";
  echo "<form action=organization.php?action=Employ method=post name=requestOrg>";
  echo "<input type=hidden value='C' name=actionb>";
  echo "<input type=hidden name=actionc value=''>";
  echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
  echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
  echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
  echo "<tr height=109 style=\"padding-left: 10px;padding-top: 3px\" valign=top>";
  echo "<td style=\"background-image: url('$General_Image_Dir/neo/rt_tab_bg.jpg');\" colspan=3 width=200>";
  echo "<span style=\"background-color:  ". $Player['color'] ."\">&nbsp;<b>邀請信</b>&nbsp;</span><br>";
  echo "$Player[request]";
  echo "<input type=submit onClick=\"actionc.value='Accept'\" style=\"$BStyleA\" $BStyleB value='答應'>";
  echo "<input type=submit onClick=\"actionc.value='Refuse'\" style=\"$BStyleA\" $BStyleB value='拒絕'>";
  echo "</form></td></tr>";
  }


  //Bar 9 & 10: Tickets & Operation Notice
  $Tickets = 0;
  $Operation_Details = '';
  $atkMissionFlag = 0;

  if ($Pl_Org['optmissioni']){
    if($Pl_Org['id'] == $Otp_A_ITar['a_org']) {
      $Pl_Mission['mission'] = 'Atk<'.$Player['coordinates'].'>';
      $Pl_Mission['t_start'] = $Otp_A_ITar['t_start'];
      $Pl_Mission['t_end'] = $Otp_A_ITar['t_end'];
      $Pl_Mission['ticket_a'] = $Otp_A_ITar['ticket_a'];
      $Pl_Mission['victory'] = $Otp_A_ITar['victory'];
    }
    else{
      $sql = ("SELECT `mission`,`t_start`,`t_end`,`ticket_a`,`victory` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = '$Pl_Org[optmissioni]' AND `t_end` > '$CFU_Time' LIMIT 1;");
      $query = mysql_query($sql);
      if(mysql_num_rows($query) <= 0) {
        $sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = $Pl_Org[optmissioni] LIMIT 1;");
        $query = mysql_query($sql);
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `optmissioni` = 0 WHERE `id` = $Pl_Org[id] LIMIT 1;");
        $query = mysql_query($sql);
      }
      $Pl_Mission = mysql_fetch_array($query);
    }
    $Pl_Show_Mission = array();
    if(preg_match('/Atk<([0-9a-zA-Z]+)>/',$Pl_Mission['mission'],$Pl_Show_Mission)){
      if($Pl_Show_Mission[1] != $Player['coordinates'])  $Opt_Area = ReturnMap($Pl_Show_Mission[1]);
      else $Opt_Area = $Area;
      if($Opt_Area["User"]["occupied"] == $Area["User"]["occupied"])  $Opt_Org = $AreaOrg;
      elseif($Opt_Area["User"]["occupied"] == $Player['organization'])$Opt_Org = $Pl_Org;
      else $Opt_Org = ReturnOrg($Opt_Area["User"]["occupied"]);
      $Operation_Details .= "<font style=\"font-size: 8pt;color: white\">[任務]</font><br><font style=\"font-size: 8pt;\">行動代號: $Pl_Org[operation]</font><br>";
      $Operation_Details .= "<font style=\"font-size: 10pt;color: white\">[內容] 區域攻防戰</font><br>把 <font color=$Opt_Org[color]>$Pl_Show_Mission[1]區域</font> 的 <font color=$Opt_Org[color]>敵方要塞</font> 擊破<br>或<br>殲滅 <font color=$Opt_Org[color]>$Pl_Show_Mission[1]區域</font> 中的<font color=$Opt_Org[color]>$Opt_Org[name]</font>軍力";
      $Operation_Details .= "</td></tr><tr height=109 style=\"padding-left: 10px;padding-top: 3px\" valign=top><td style=\"background-image: url('$General_Image_Dir/neo/rt_tab_bg.jpg');\" colspan=3 width=200>";
      $StartAtk = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Pl_Mission['t_start']));
      $TimeEnd = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Pl_Mission['t_end']));
      $Operation_Details .=  "<font style=\"font-size: 10pt;color: white\">[開始時間]</font><br> $StartAtk <br><font style=\"font-size: 10pt;color: white\">[完結時間]</font><br> $TimeEnd ";
      $Tickets = $Pl_Mission['ticket_a'];
      $atkMissionFlag = 1;
    }
  }
  elseif($Pl_Org['id'] != 0){
    if($Otp_A_ITar['b_org'] == $Pl_Org['id']){
      $Def_Area_Id = $Player['coordinates'];
      $Defend_War['t_start'] = $Otp_A_ITar['t_start'];
      $Defend_War['t_end'] = $Otp_A_ITar['t_end'];
      $Defend_War['a_org'] = $Otp_A_ITar['a_org'];
      $Defend_War['ticket_b'] = $Otp_A_ITar['ticket_b'];
    }else{
      $sql = ("SELECT `t_start`,`t_end`,`a_org`,`mission`,`ticket_b` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `b_org` = '$Pl_Org[id]' AND `t_end` > '$CFU_Time' ORDER BY `t_start` ASC LIMIT 1");
      $query = mysql_query($sql);
      $Defend_War = mysql_fetch_array($query);
      $tmp = array();
      if(preg_match('/Atk<([0-9a-zA-Z]+)>/', $Defend_War['mission'], $tmp)){
        $Def_Area_Id = $tmp[1];
      }else{
        $Def_Area_Id = '';
      }
      unset($tmp);
    }
    if($Defend_War){
      $A_Org = ReturnOrg($Defend_War['a_org']);
      $Operation_Details .= "<font style=\"font-size: 10pt;color: white\">[內容] 區域防禦戰</font><br>殲滅 <font color=$Pl_Org[color]>".$Def_Area_Id."區域</font> 中的<font color=$A_Org[color]>$A_Org[name]</font>軍力";
      $Operation_Details .= "<br>或<br>防止 <font color=$Pl_Org[color]>".$Def_Area_Id."區域要塞</font>,<br>於戰爭結束前被攻陷";

      if($Def_Area_Id == $Player['coordinates'] && $Player['rights'] == '1' && $Defend_War['t_start'] > $CFU_Time && $Defend_War['ticket_b'] == 1)
        $Operation_Details .= "<br><b style=\"cursor: pointer\" onmouseover=\"this.style.color='yellow'\" onmouseout=\"this.style.color='white'\" onClick=\"SetiFT('\'調動兵力迎擊\'');act.action='city.php?action=Reinforcement';act.actionb.value='C';act.target='$SecTarget';act.submit();\"><u>調動兵力迎擊</u></b>";

      $Operation_Details .= "</td></tr><tr height=109 style=\"padding-left: 10px;padding-top: 3px\" valign=top><td style=\"background-image: url('$General_Image_Dir/neo/rt_tab_bg.jpg');\" colspan=3 width=200>";
      $StartAtk = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Defend_War['t_start']));
      $TimeEnd = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Defend_War['t_end']));
      $Operation_Details .=  "<font style=\"font-size: 10pt;color: white\">[開始時間]</font><br> $StartAtk <br><font style=\"font-size: 10pt;color: white\">[完結時間]</font><br> $TimeEnd ";
      $Tickets = $Defend_War['ticket_b'];
    }
  }

  if ($Tickets){
    echo "<tr><td colspan=3 height=10 style=\"font-size: 1px\">&nbsp;</td></tr>";
    echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Player[color];padding-left: 18px;\" height=30 width=175>";
    echo "<b color=FEFEFE>現軍力: &nbsp;</b><span id=pl_active_tickets>".number_format($Tickets);
    echo "</spam></td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";
  }
  if($Operation_Details){
    echo "<tr><td colspan=3 height=10 style=\"font-size: 1px\">&nbsp;</td></tr>";
    echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Pl_Org[color];padding-left: 18px;\" height=30 width=175>";
    echo "<b color=FEFEFE>出擊通知書</span>";
    echo "</td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";
    echo "<tr height=109 style=\"padding-left: 10px;padding-top: 3px\" valign=top>";
    echo "<td style=\"background-image: url('$General_Image_Dir/neo/rt_tab_bg.jpg');\" colspan=3 width=200>";
    echo $Operation_Details;
    echo "</td></tr>";
  }
  echo "</table>";


  if ($Otp_TellTime){
    echo "<div style=\"position: absolute; left: 0; top: 0; width: 100%; text-align: center\">";
    echo "<table class=\"base center-align\">";
    echo "<tr><td colspan=2 style=\"background-image: url('$General_Image_Dir/neo/btn_s_neo.gif');\" width=200 height=30 align=center>";
    echo "<font style=\"color: FF7575;font-size: 8pt;\" id=opt_time_display>$Otp_TellTime</font>";
    echo "</td></tr></table>";
    echo "</div>";
  }

  //Right Command and Status Bar
  echo "<div style=\"position: absolute; right: 0; top: 0;\">";
  echo "<table class=\"base\">";

  //Bar 1: Title
  echo "<tr><td colspan=2 onClick=\"window.open('http://v2alliance.no-ip.org')\" style=\"cursor: pointer;background-image: url('$General_Image_Dir/neo/btn_s_neo.gif');\" width=200 height=30 align=center>";
  echo "<b style=\"font-size: 8pt;\">php-eb &copy; 2005-2010 v2Alliance.</b>";
  echo "</td></tr>";

  //Button 1: Pilot Status
  echo "<tr><td colspan=2 height=5 style=\"font-size: 1px\" align=right>&nbsp;</td></tr>";
  echo "<tr><td width=100></td><td class='lowLight' id=btn1 onClick=\"SetStill('btn1');\" onMouseOver=menuOver('btn1','PilotStat') onMouseOut=menuOut('btn1','PilotStat') onDrag='return false;'>";
  echo "<b style=\"font-size: 8pt;\">機師狀態</b>";
  echo "</td></tr>";

  //Button 2: MS Status
  echo "<tr><td colspan=2 height=3 style=\"font-size: 1px\" align=right>&nbsp;</td></tr>";
  echo "<tr><td width=100></td><td class='lowLight' id=btn2 onClick=\"SetStill('btn2');\" onMouseOver=menuOver('btn2','MSStat') onMouseOut=menuOut('btn2','MSStat') onDrag='return false;'>";
  echo "<b style=\"font-size: 8pt;\">機體狀態</b>";
  echo "</td></tr>";

  //Button 3: Equipment Status
  echo "<tr><td colspan=2 height=3 style=\"font-size: 1px\" align=right>&nbsp;</td></tr>";
  echo "<tr><td width=100></td><td class='lowLight' id=btn3 onClick=\"SetStill('btn3');\" onMouseOver=menuOver('btn3','EqStat') onMouseOut=menuOut('btn3','EqStat') onDrag='return false;'>";
  echo "<b style=\"font-size: 8pt;\">裝備狀態</b>";
  echo "</td></tr>";

  //Button Log: Log Display
  echo "<tr><td colspan=2 height=3 style=\"font-size: 1px\" align=right>&nbsp;</td></tr>";
  echo "<tr><td width=100></td><td class='lowLight' id=btnlog onClick=\"SetStill('btnlog');\" onMouseOver=menuOver('btnlog','LogDis') onMouseOut=menuOut('btnlog','LogDis') onDrag='return false;'>";
  echo "<b style=\"font-size: 8pt;\">戰鬥紀錄</b>";
  echo "</td></tr>";

  //Commands - Submission Form
  echo "<form action=nil method=post name=act target='$SecTarget' id=mainActForm>";
  echo "<input type=hidden value='none' name=actionb>";
  $OpenChat = !(( isset($_POST['noopenchat']) ) ? $_POST['noopenchat'] : 0);
  echo "<input type=hidden value=".($OpenChat ? 0 : 1)." name=noopenchat>";
  echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
  echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
  echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
  echo "</form>";

  //$rmAf = $rmChatAutoRefresh * 5;

  //Commands - JavaScript
  echo "<script language=\"JavaScript\">",
  "setTimeout(\"enablerf();\",2000);",
  "function ShowSTiF(){",
    "document.getElementById('STiF').style.left = 150;}",
  "function HideSTiF(){",
    "document.getElementById('STiF').style.left = -1150;}",
  "function SetiFT(msgText){",
    "ShowSTiF();tmpTxt = eval(msgText);",
    "document.getElementById(\"iFT\").innerHTML = tmpTxt;}",
  "function movebattle(){",
    "if (document.getElementById('status_now').innerHTML=='修理進行中'){alert('修理中！'); return false;}",
    "var enc = parseInt(eval(\"document.getElementById('EqmEnc_A').innerHTML;\"))+parseInt(eval(\"document.getElementById('EqmEnc_D').innerHTML;\"))+parseInt(eval(\"document.getElementById('EqmEnc_E').innerHTML;\"));",
    "if(enc > parseInt(document.getElementById('current_en').innerHTML)) {alert('EN還未足夠！'); return false;}",
    "act.action='battle.php?action=battle_sel';",
    "act.actionb.value='battle_sel';",
    "act.target='$SecTarget';",
    "act.submit();}",
  "function enablerf(){",
    "document.getElementById('ig_refresh_d').style.visibility='hidden';",
    "document.getElementById('ig_refresh_d').style.position='absolute';",
    "document.getElementById('ig_refresh_e').style.visibility='visible';",
    "document.getElementById('ig_refresh_e').style.position='relative';",
    "}",
  "</script>";

  //Use Auto Count
  $bn = 4;

  //Include Right Menu
  include_once('gmscrn_right_menu.php');

  echo "</table>";
  echo "</div>";

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
      for($LogShowNum=1;$LogShowNum<=$Pl_LEnt;$LogShowNum++){
        $i = 'time'.$LogShowNum;
        $j = 'log'.$LogShowNum;
        $Pl_Log[$i] = (isset($Pl_Log[$i])) ? $Pl_Log[$i] : 0;
        $Pl_Log[$j] = (isset($Pl_Log[$j])) ? $Pl_Log[$j] : '';
        if ($Pl_Log[$i]){
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
  foreach($Eq_Listing as $I => $V){

    // Prepare Basic Information
    prepBasixEqInfoString($Pl, $I, $W_Inf);

    // Print name phrase, starts <div> tag
    printQuickEquipNamePhrase($I, $Pl->Eq[$I]['id'], $Pl->Eq[$I]['name'],$W_Inf);

    // Print Condition Level / Exp
    printCondLevel($Pl, $I);

    // Print Controls
    if($I == 'B' || $I == 'C'){
      echo "<br>";
      $tmpBool = ($Pl->Eq[$I]['id'] != '0' && canEquipAsWep($Pl->Eq[$I]));
      printQuickEquipSpanTag($V,$I,'W','E','equip', $tmpBool, '(裝備此武器)');
      echo "&nbsp;";
      $tmpBool = ($Pl->Eq[$I]['id'] != '0' && $Pl->Eq[$I]['equip']);
      printQuickEquipSpanTag($V,$I,'E','W','equipdef', $tmpBool, '(裝上輔助裝備)');
    }
    elseif ($I == 'D'){
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
      if($Player['attacking'] >= 150) $At_Show_Stat_Req = 'N/A';
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
      if($Player['defending'] >= 150) $De_Show_Stat_Req = 'N/A';
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
      if($Player['reacting'] >= 150) $Re_Show_Stat_Req = 'N/A';
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
      if($Player['targeting'] >= 150) $Ta_Show_Stat_Req = 'N/A';
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
  echo "<form action=$iChatScript method=post name=iChatForm target='$iChatTarget'>";
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

  //Recovering Script
  $Pl_ShowHP = floor($Player['hp']);
  $Pl_ShowEN = floor($Player['en']);
  $Pl_ShowSP = floor($Player['sp']);
  $SP_RecRate = 0.004 * $Player['spmax'];  echo "<script language=\"JavaScript\">";
  echo "var m_h = $Player[hpmax];";  // prefix "m_" for max
  echo "var m_e = $Player[enmax];";
  echo "var m_s = $Player[spmax];";
  echo "var i_h = $Pl_ShowHP;";    // prefix "i_" for initial
  echo "var i_e = $Pl_ShowEN;";
  echo "var i_s = $Pl_ShowSP;";
  echo "var h = $Pl_ShowHP;";    // no prefix for now
  echo "var e = $Pl_ShowEN;";
  echo "var s = $Pl_ShowSP;";
  echo "var r_h = 0;";
  echo "var r_e = 0;";
  echo "var r_s = 0;";
  echo "var chatUpdate = 0;";
  echo "var sprate = $SP_RecRate;";
  echo "var timerID;";
  echo "TheDate = new Date();";
  echo "var m_time=TheDate.getTime();";
  echo "var mh_time=TheDate.getTime();";
  echo "var me_time=TheDate.getTime();";
  echo "var ms_time=TheDate.getTime();";
  echo "AutoRepairJ();";
  echo "function AutoRepairJ(){";
  echo "TheDate2 = new Date();";
  echo "  n_time=TheDate2.getTime();";
  echo "  ts_h = (mh_time - n_time)/-1000;";
  echo "  ts_e = (me_time - n_time)/-1000;";
  echo "  ts_s = (ms_time - n_time)/-1000;";

  $HP_AutoRepairType = $EN_AutoRepairType = 0;
  if ($Ms['hprec'] >= 1) $HP_AutoRepairType = 1;//Constant HP Recovery
  if ($Ms['hprec'] < 1 && $Ms['hprec'] >= 0.001) $HP_AutoRepairType = 2;//Percentage HP Recovery

  if ($Ms['enrec'] >= 1)$EN_AutoRepairType = 1;//Constant EN Recovery
  if ($Ms['enrec'] < 1 && $Ms['enrec'] >= 0.001) $EN_AutoRepairType = 2;//Percentage EN Recovery

  switch ($HP_AutoRepairType){
    case 1: echo "hprate = $Ms[hprec];";break;
    case 2: echo "hprate = $Ms[hprec]*m_h;";break;
    default: echo "hprate = 0;";break;}
  switch ($EN_AutoRepairType){
    case 1: echo "enrate = $Ms[enrec];";break;
    case 2: echo "enrate = $Ms[enrec]*m_e;";break;
    default: echo "enrate = 0;";break;}

  if ($Player['hypermode'] == 2 || $Player['hypermode'] == 6) $SP_RecRate *= 2;

  $EqRecHP=$EqRecEN=$PEqRecHP=$PEqRecEN='';
  if ($Pl->Eq['D']['spec']){
    if (strpos($Pl->Eq['D']['spec'],'HPPcRecA') !== false){$EqRecHP = " + (ts_h * (0.005 * m_h))";}
    if (strpos($Pl->Eq['D']['spec'],'ENPcRecB') !== false){$EqRecEN = " + (ts_e * (0.015 * m_e))";}
    elseif (strpos($Pl->Eq['D']['spec'],'ENPcRecA') !== false){$EqRecEN = " + (ts_e * (0.0075 * m_e))";}
  }
  if ($Pl->Eq['E']['spec']){
    if (strpos($Pl->Eq['E']['spec'],'HPPcRecA') !== false){$PEqRecHP = " + (ts_h * (0.005 * m_h))";}
    if (strpos($Pl->Eq['E']['spec'],'ENPcRecB') !== false){$PEqRecEN = " + ts_e * (0.015 * m_e))";}
    elseif (strpos($Pl->Eq['E']['spec'],'ENPcRecA') !== false){$PEqRecEN = " + (ts_e * (0.0075 * m_e))";}
  }
  echo "  if (h < 0){h = 0;}";
  echo "  r_h = (ts_h * hprate)".$EqRecHP.$PEqRecHP.";";
  echo "  r_e = (ts_e * enrate)".$EqRecEN.$PEqRecEN.";";
  echo "  r_s = (ts_s * ".$SP_RecRate.");";
  echo "  if (h < m_h){h = i_h + r_h;}else{h = m_h;i_h = m_h;mh_time = n_time;}";
  echo "  if (e < m_e){e = i_e + r_e;}else{e = m_e;i_e = m_e;me_time = n_time;}";
  echo "  if (s < m_s){s = i_s + r_s;}else{s = m_s;i_s = m_s;ms_time = n_time;}";
  echo "  if (h >= m_h && document.getElementById('status_now').innerHTML=='修理進行中')";
  echo "  {document.getElementById('status_now').innerHTML='發進登錄可能';document.getElementById('status_now').style.color='#016CFE';}";
  echo "  document.getElementById('current_hp').innerHTML=Math.round (h);";
  echo "  document.getElementById('current_en').innerHTML=Math.round (e);";
  echo "  document.getElementById('current_sp').innerHTML=Math.round (s);";
  echo "  if(parseInt(document.getElementById('max_hp').innerHTML) > 0) {document.getElementById('hp_bar_l').width=Math.ceil (h/parseInt(document.getElementById('max_hp').innerHTML)*125);";
  echo "  document.getElementById('hp_bar_r').width=125 - document.getElementById('hp_bar_l').width;}";
  echo "  else document.getElementById('hp_bar_l').width=125;";
  echo "  if(parseInt(document.getElementById('max_en').innerHTML) > 0) {document.getElementById('en_bar_l').width=Math.ceil (e/parseInt(document.getElementById('max_en').innerHTML)*125);";
  echo "  document.getElementById('en_bar_r').width=125 - document.getElementById('en_bar_l').width;}";
  echo "  else document.getElementById('en_bar_l').width=125;";
  echo "  if(parseInt(document.getElementById('max_sp').innerHTML) > 0) {document.getElementById('sp_bar_l').width=Math.ceil (s/parseInt(document.getElementById('max_sp').innerHTML)*125);";
  echo "  document.getElementById('sp_bar_r').width=125 - document.getElementById('sp_bar_l').width;}";
  echo "  else document.getElementById('sp_bar_l').width=125;";
  echo "  clearTimeout(timerID);";
  echo "  timerID = setTimeout(\"AutoRepairJ()\",200);";
  echo "  }";

  if ($Otp_TellTime){
    echo "  var opt_start = $Otp_A_ITar[t_start];";
    echo "  var opt_time = $Otp_A_ITar[t_end];";
    echo "  var cfu_time = $CFU_Time;";
    echo "  cali_cfu_time();";
    echo "  function cali_cfu_time(){";
    echo "  cfu_time++;";
    echo "  getOptTime();";
    echo "  setTimeout(\"cali_cfu_time()\",1000);";
    echo "  }";
    echo "  function getOptTime() {";
    echo "  var opt_t = 0;";
    echo "  var opt_wh = 0;";
    echo "  var opt_wm = 0;";
    echo "  var opt_ws = 0;";
    echo "  if(opt_start > cfu_time){";
    echo "  opt_t = opt_start - cfu_time;";
    echo "  opt_wh = Math.floor(opt_t/3600);";
    echo "  opt_wm = Math.floor((opt_t - (opt_wh*3600))/60);";
    echo "  opt_ws = Math.floor(opt_t - (opt_wh*3600) - (opt_wm*60));";
    echo "  document.getElementById('opt_time_display').innerHTML = '還有'+opt_wh+'小時'+opt_wm+'分鐘'+opt_ws+'秒開始戰爭。';";
    echo "  }";
    echo "  else if(opt_time > cfu_time) {";
    echo "  opt_t = opt_time - cfu_time;";
    echo "  opt_wh = Math.floor(opt_t/3600);";
    echo "  opt_wm = Math.floor((opt_t - (opt_wh*3600))/60);";
    echo "  opt_ws = Math.floor(opt_t - (opt_wh*3600) - (opt_wm*60));";
    echo "  document.getElementById('opt_time_display').innerHTML = '還有'+opt_wh+'小時'+opt_wm+'分鐘'+opt_ws+'秒結束戰爭。';";
    echo "  document.getElementById('opt_time_display').style.color = 'FFFF00';";
    echo "  }";
    echo "  else {";
    echo "  document.getElementById('opt_time_display').innerHTML = '戰爭已宣告終了。';";
    echo "  document.getElementById('opt_time_display').style.color = '';";
    echo "  }}";
  }

  echo "var ".$iChatTarget."_ref = null;";

  echo "function refreshWindow(){";
  echo "document.act.action='gmscrn_main.php?action=proc&';"
    . "document.act.target='$PriTarget';"
    . "document.act.noopenchat.value = 1;"
    . "document.act.submit();";
  echo "}";
  echo "function openChatWindow(){
    if(document.act.noopenchat.value == 0){
      try{
        ".$iChatTarget."_ref = window.open('','$iChatTarget','location=1,menubar=0,toolbar=0,resizable=1,scrollbars=0,status=0,width=755,height=225');
        document.iChatForm.submit();
      }
      catch(e){}
      document.act.noopenchat.value = 1;
    }
    else if(".$iChatTarget."_ref != null) {
      try{
        ".$iChatTarget."_ref.focus();
      }
      catch(e){}
    }
  }";

  if($OpenChat)  echo " openChatWindow();";
  echo "  </script>";

  //Behaviour Check
  if($Use_Behavior_Checker){
    include_once('includes/behavior_checker.class.php');
    $BChecker = new BehaviorChecker($Pl, $GLOBALS['Btl_Intv'], 0, $GLOBALS['Offline_Time'], $GLOBALS['CFU_Time'], $GLOBALS['DBPrefix']);
    $BChecker->checkInsomnia();
  }

  //End Body
  echo "</body>";
  exit;
}
else echo "<br><br><br>Invalid Action<br><br><br>";

// Functions

function drawButton($rSpacing,$Caption,$wTitle,$actions){
  echo "<tr><td colspan=2 height=$rSpacing style=\"font-size: 1px\" align=right>&nbsp;</td></tr>";
  echo "<tr><td width=100></td><td class='lowLight' onClick=\"SetiFT('\'$wTitle\'');$actions\" onMouseOver=\"this.className = 'highLight';\" onMouseOut=\"this.className = 'lowLight';\" onDrag='return false;'>";
  echo "<b style=\"font-size: 8pt;\">$Caption</b>";
  echo "</td></tr>";
}

function drawSButton($rSpacing,$Caption,$actions,$trId = false){
  if($rSpacing) echo "<tr><td colspan=2 height=$rSpacing style=\"font-size: 1px\" align=right>&nbsp;</td></tr>";
  if($trId) echo "<tr id='$trId'>";
  else echo "<tr>";
  echo "<td width=100></td><td class='lowLight' onClick=\"$actions\" onMouseOver=\"this.className = 'highLight';\" onMouseOut=\"this.className = 'lowLight';\" onDrag='return false;'>";
  echo "<b style=\"font-size: 8pt;\">$Caption</b>";
  echo "</td></tr>";
}

function setAddStatImg($Growth, $StatReq, $Stat, &$aCollection, $Limit=150){
  global $General_Image_Dir;
  if ($Growth >= $StatReq && $Stat < $Limit){
    $aCollection['Style'] = " cursor: pointer;";
    $aCollection['Image'] = "$General_Image_Dir/neo/plus_sign.gif";
  } else {
    $aCollection['Style'] = " cursor: default; ";
    $aCollection['Image'] = "$General_Image_Dir/neo/plus_sign_grey.gif";
  }
}

?>
