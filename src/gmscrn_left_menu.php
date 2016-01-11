<?php
  //Player info panel
  echo '<div class="player-info">';
    echo '<div>機師名稱:</div>';
    echo "<div style=\"color: $Player[color];\">&nbsp; $Player[gamename] &nbsp;</div>";

    echo '<div>所屬組織:</div>';
    echo "<div>";
      echo "<span style=\"color: $Pl_Org[color];\">&nbsp; $Pl_Org[name]</span>";
      if ($RightsTitle) echo "<span style=\"color: yellow;\"> &nbsp;$RightsTitle</span>";
      echo "&nbsp;($Pl_Rank) &nbsp;";
    echo "</div>";

    echo "<div>所在地區:</div>";
    echo "<div $WarColor>&nbsp; $Player[coordinates] ($AreaLandForm) (<span style=\"color: $AreaOrg[color]\">".$AreaOrg['name']."</span>) &nbsp;</div>";
  echo "</div>";
  echo "<div class=\"empty-row\"></div>";

  //Bar 1: HP
  printLeftMenuItem($Player[color],
    "<b color=FEFEFE>HP: &nbsp;</b><span id=current_hp>$Player[hp]</span> / <span id=max_hp>$Player[hpmax]</span>" .
    printRatioBar('hpBar', $Player['hp'], $Player['hpmax'])
  );

  //Bar 2: EN
  printLeftMenuItem($Player[color],
    "<b color=FEFEFE>EN: &nbsp;</b><span id=current_en>$Player[en]</span> / <span id=max_en>$Player[enmax]</span>" .
    printRatioBar('enBar', $Player['en'], $Player['enmax'])
  );

  //Bar 3: SP
  printLeftMenuItem($Player[color],
    "<b color=FEFEFE>SP: &nbsp;</b><span id=current_sp>".round($Player['sp'])."</span> / <span id=max_sp>$Player[spmax]</span>" .
    printRatioBar('spBar', $Player['sp'], $Player['spmax'])
  );

  //Bar 4: Exp
  $Show_Exp = $UserNextLvExp = $Show_Exp_Style = '';
  if ($Player['level'] >= 150) {$UserNextLvExp = false;$Show_Exp = '0';} //Hide upon 150Lv
  else {calcExp("$Player[level]");$Show_Exp = number_format($Player['expr'])." / ".number_format($UserNextLvExp);$Show_Exp_Style = ($UserNextLvExp > 10000000) ? "font-size: 8pt;font-weight: Bold" : "";
    printLeftMenuItem($Player[color],
      "<b color=FEFEFE>EXP: &nbsp;</b> <span id=pl_expr style=\"$Show_Exp_Style\">$Show_Exp</span> <br>" .
      "<img id=pl_expr_l src='$General_Image_Dir/neo/blue_bar.gif' width=".ceil(($Player['expr']/$UserNextLvExp)*124)." height=5>" .
      "<img id=pl_expr_r src='$General_Image_Dir/neo/empty_bar.gif' width=".(124-ceil(($Player['expr']/$UserNextLvExp)*124))." height=5>" .
      "<img src='$General_Image_Dir/neo/blue_bar.gif' width=1 height=5>"
    );
  }

  //Bar 5: Money
  echo "<table class=\"base\">";
  echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Player[color];padding-left: 18px;\" height=30 width=175>";
  echo "<b color=FEFEFE>金錢: &nbsp;</b><span id=pl_cash>".number_format($Player['cash']);
  echo "</spam></td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";
  echo "</table>";

  //Bar 6: Fame / Notor
  $TypeFame = ($Player['fame'] >= 0) ? '名聲' : '惡名';
  $ShowFame = abs($Player['fame']);
  echo "<div class=\"empty-row\"></div>";
  echo "<table class=\"base\">";
  echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Player[color];padding-left: 18px;\" height=30 width=175>";
  echo "<b color=FEFEFE><span id=type_fame>$TypeFame</span>: &nbsp;</b><span id=pl_fame>$ShowFame</span>";
  echo "</td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";
  echo "</table>";

  //Bar 7: Status
  $StatusShow = $StatusColor = '';
  if ($Player['msuit'])
  switch ($Player['status']){case 0: $StatusShow="發進登錄可能"; $StatusColor='#016CFE';break; case 1: $StatusShow="修理進行中"; $StatusColor='#FF2200';break;}
  else {$StatusShow = '沒有機體'; $StatusColor = '#FF2200';}
  echo "<div class=\"empty-row\"></div>";
  echo "<table class=\"base\">";
  echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Player[color];padding-left: 18px;\" height=30 width=175>";
  echo "<b color=FEFEFE>機體狀態:</b>&nbsp; <b style=\"color: $StatusColor;\" id=status_now>$StatusShow</b>";
  echo "</td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";
  echo "</table>";

  //Bar 8: Request
  if ($Player['request']) {
  echo "<div class=\"empty-row\"></div>";
  echo "<table class=\"base\">";
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
  echo "</table>";
  }


  //Bar 9 & 10: Tickets & Operation Notice
  $Tickets = 0;
  $Operation_Details = '';
  $atkMissionFlag = 0;

  if ($Pl_Org['optmissioni']) {
    if ($Pl_Org['id'] == $Otp_A_ITar['a_org']) {
      $Pl_Mission['mission'] = 'Atk<'.$Player['coordinates'].'>';
      $Pl_Mission['t_start'] = $Otp_A_ITar['t_start'];
      $Pl_Mission['t_end'] = $Otp_A_ITar['t_end'];
      $Pl_Mission['ticket_a'] = $Otp_A_ITar['ticket_a'];
      $Pl_Mission['victory'] = $Otp_A_ITar['victory'];
    }
    else{
      $sql = ("SELECT `mission`,`t_start`,`t_end`,`ticket_a`,`victory` FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = '$Pl_Org[optmissioni]' AND `t_end` > '$CFU_Time' LIMIT 1;");
      $query = mysql_query($sql);
      if (mysql_num_rows($query) <= 0) {
        $sql = ("DELETE FROM `".$GLOBALS['DBPrefix']."phpeb_user_war` WHERE `war_id` = $Pl_Org[optmissioni] LIMIT 1;");
        $query = mysql_query($sql);
        $sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_organization` SET `optmissioni` = 0 WHERE `id` = $Pl_Org[id] LIMIT 1;");
        $query = mysql_query($sql);
      }
      $Pl_Mission = mysql_fetch_array($query);
    }
    $Pl_Show_Mission = array();
    if (preg_match('/Atk<([0-9a-zA-Z]+)>/',$Pl_Mission['mission'],$Pl_Show_Mission)) {
      if ($Pl_Show_Mission[1] != $Player['coordinates'])  $Opt_Area = ReturnMap($Pl_Show_Mission[1]);
      else $Opt_Area = $Area;
      if ($Opt_Area["User"]["occupied"] == $Area["User"]["occupied"])  $Opt_Org = $AreaOrg;
      elseif ($Opt_Area["User"]["occupied"] == $Player['organization'])$Opt_Org = $Pl_Org;
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
  elseif ($Pl_Org['id'] != 0) {
    if ($Otp_A_ITar['b_org'] == $Pl_Org['id']) {
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
      if (preg_match('/Atk<([0-9a-zA-Z]+)>/', $Defend_War['mission'], $tmp)) {
        $Def_Area_Id = $tmp[1];
      }else{
        $Def_Area_Id = '';
      }
      unset($tmp);
    }
    if ($Defend_War) {
      $A_Org = ReturnOrg($Defend_War['a_org']);
      $Operation_Details .= "<font style=\"font-size: 10pt;color: white\">[內容] 區域防禦戰</font><br>殲滅 <font color=$Pl_Org[color]>".$Def_Area_Id."區域</font> 中的<font color=$A_Org[color]>$A_Org[name]</font>軍力";
      $Operation_Details .= "<br>或<br>防止 <font color=$Pl_Org[color]>".$Def_Area_Id."區域要塞</font>,<br>於戰爭結束前被攻陷";

      if ($Def_Area_Id == $Player['coordinates'] && $Player['rights'] == '1' && $Defend_War['t_start'] > $CFU_Time && $Defend_War['ticket_b'] == 1)
        $Operation_Details .= "<br><b style=\"cursor: pointer\" onmouseover=\"this.style.color='yellow'\" onmouseout=\"this.style.color='white'\" onClick=\"SetiFT('\'調動兵力迎擊\'');act.action='city.php?action=Reinforcement';act.actionb.value='C';act.target='$SecTarget';act.submit();\"><u>調動兵力迎擊</u></b>";

      $Operation_Details .= "</td></tr><tr height=109 style=\"padding-left: 10px;padding-top: 3px\" valign=top><td style=\"background-image: url('$General_Image_Dir/neo/rt_tab_bg.jpg');\" colspan=3 width=200>";
      $StartAtk = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Defend_War['t_start']));
      $TimeEnd = preg_replace('/星期(.*), /','星期\\1<br>',cfu_time_convert($Defend_War['t_end']));
      $Operation_Details .=  "<font style=\"font-size: 10pt;color: white\">[開始時間]</font><br> $StartAtk <br><font style=\"font-size: 10pt;color: white\">[完結時間]</font><br> $TimeEnd ";
      $Tickets = $Defend_War['ticket_b'];
    }
  }

  if ($Tickets) {
    printLeftMenuItem($Player[color],
      "<b color=FEFEFE>現軍力: &nbsp;</b><span id=pl_active_tickets>".number_format($Tickets)
    );
  }
  if ($Operation_Details) {
    printLeftMenuItem($Pl_Org[color],
      "<b color=FEFEFE>出擊通知書</b></br>$Operation_Details"
    );
  }


  if ($Otp_TellTime) {
    echo "<div style=\"position: absolute; left: 0; top: 0; width: 100%; text-align: center\">";
    echo "<table class=\"base center-align\">";
    echo "<tr><td colspan=2 style=\"background-image: url('$General_Image_Dir/neo/btn_s_neo.gif');\" width=200 height=30 align=center>";
    echo "<font style=\"color: FF7575;font-size: 8pt;\" id=opt_time_display>$Otp_TellTime</font>";
    echo "</td></tr></table>";
    echo "</div>";
  }


function printLeftMenuItem($color, $content) {
  global $General_Image_Dir;
  echo "<table class=\"base\">";
  echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $color;padding-left: 18px;\" height=30 width=175>";
  echo $content;
  echo "</td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";
  echo "</table>";
  echo "<div class=\"empty-row\"></div>";
}

function printRatioBar($id, $current, $max) {
  $percent = 100 * ($max > 0 ? $current/$max : 1);

  $leftPercentWidth = $percent . '%';
  $rightPercentWidth = (100 - $percent) . '%';

  global $General_Image_Dir;
  return "<div id=\"$id\" style=\"width: 125px; height: 5px;\">" .
    "<img class=\"left\" src='$General_Image_Dir/neo/blue_bar.gif' width=$leftPercentWidth height=100%>" .
    "<img class=\"right\" src='$General_Image_Dir/neo/orange_bar.gif' width=$rightPercentWidth height=100%>" .
    "</div>";
}
?>
