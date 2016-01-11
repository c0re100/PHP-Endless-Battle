<?php
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

  //Button 4: Battle
  drawButton(10,'戰鬥', '戰鬥畫面','movebattle();');

  //Button 5: Movement
  drawButton(3,'移動', '移動畫面',"act.action='map.php?action=Move';act.actionb.value='A';act.target='$SecTarget';act.submit();");

  //Button 6: Occupy City
  if ($Player['rights'] == '1' && $atkMissionFlag == 1 && $Pl_Mission['victory'] == 1){
    drawButton(3,'佔領地區', '佔領地區',"act.action='organization.php?action=TakeCity';act.actionb.value='A';act.target='$SecTarget';act.submit();");
  }

  //Button 7: Equip
  drawButton(10,'裝備', '裝備',"act.action='equip.php?action=equip';act.target='$SecTarget';act.submit();");

  //Button 8: Buy MS
  drawButton(3,'機體生產工場', '機體生產工場',"act.action='equip.php?action=buyms';act.actionb.value='buyms';act.target='$SecTarget';act.submit();");

  //Button 9: Mod MS
  drawButton(3,'機體改造工場', '機體改造工場',"act.action='statsmod.php?action=modms';act.actionb.value='buyms';act.target='$SecTarget';act.submit();");

  //Button 10: Tactical Weapon Factory
  drawButton(3,'兵器製造工場', '兵器製造工場',"act.action='tactfactory.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

  //Button 11: Repair
  drawButton(3,'修理工場', '修理工場',"act.action='statsmod.php?action=repairms';act.actionb.value='sel';act.target='$SecTarget';act.submit();");


  //Button 12: Tactics Academy
  drawButton(10,'戰術學院', '戰術學院',"act.action='tacticslearn.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

  // Mining
  drawButton(3,'原料採集', '原料採集',"act.action='plugins/mining/mining.php';act.actionb.value='none';act.target='$SecTarget';act.submit();");

  //Button 13: Warehouses
  drawButton(10,'倉庫', '倉庫',"act.action='warehouse.php?action=selection';act.actionb.value='none';act.target='$SecTarget';act.submit();");

  //Button 14: Bank
  drawButton(3,'銀行', '銀行',"act.action='bank.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

  //Button 16: Special Commands
  drawButton(3,'特殊指令', '特殊指令',"act.action='scommand.php?action=main';act.actionb.value='none';act.target='$SecTarget';act.submit();");

  //Button 17: Information
  drawButton(3,'情報', '情報',"act.action='information.php?action=Main';act.actionb.value='';act.target='$SecTarget';act.submit();");


  //Button 18: Rankings
  drawButton(3,'排名', '排名',"act.action='gen_info.php?action=ranks';act.actionb.value='none';act.target='$SecTarget';act.submit();");

  //Button 19: Refresh - Disable
  drawSButton(10,'－－－－','return false;','ig_refresh_d');

  //Button 20: Refresh - Enabled
  drawSButton(0,'重新整理','refreshWindow();',"ig_refresh_e' style='position: absolute;visibility: hidden;");

  //Button 21: Chat Board
  drawSButton(10,'留言板',"window.open('','$CFU_Time','resizable=1,width=800,height=600');act.action='chat.php';act.target='$CFU_Time';act.submit();");

  //Button 22: Instant Chatroom
  drawSButton(10,'聊天室','openChatWindow();');

  //Button 23: Logout
  drawSButton(3,'登出',"location.replace('index2.php');");

  //Button 24: Manager Script
if ( $Player['acc_status'] < 0 ) {
  drawButton(3,'管理', '管理',"act.action='manager.php';act.actionb.value='none';act.target='$SecTarget';act.submit();");
}

  echo "</table>";
  echo "</div>";

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
?>
