<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
$IncludeLFFI = false;
include('cfu.php');
include('includes/repairplayer-f.inc.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
if (!isset($Game_Scrn_Type)) $Game_Scrn_Type = 1;
$additionalHeader = '<link href="images/alphaChannel.css" rel="stylesheet" type="text/css" />';
postHead('','phpeb_session_dir',$additionalHeader);
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}
mt_srand ((double) microtime()*1000000);

include('includes/sfo.class.php');

$Pl = new player_stats;
$Pl->SetUser($Pl_Value['USERNAME']);
$Pl->FetchPlayer(true,true);

if (($CFU_Time - $Pl->Player['btltime']) < $Move_Intv){echo "距離上次攻擊或移動的時間太短了！<br>請在 ".($Move_Intv-($CFU_Time - $Pl->Player['btltime']))." 秒後再移動！";exit;}

if ($Pl->Player['msuit']){
	$Pl->ProcessAllWeapon();
	$Pl_Repaired = RepairPlayer($Pl->Player,$Pl->Eq['D'],$Pl->Eq['E']);
	$Pl->Player['hp'] = $Pl_Repaired['hp'];
	$Pl->Player['en'] = $Pl_Repaired['en'];
	$Pl->Player['sp'] = $Pl_Repaired['sp'];
	$Pl->Player['status'] = $Pl_Repaired['status'];
	$t_now = $Pl->Player['time1'] = $Pl_Repaired['time1'];
	if ($Pl->Player['status']){echo "修理中，無法移動。";postFooter();exit;}
}else {echo "<center>你沒有機體，不能移動。";postFooter();exit;}


//$AreaLandForm = ReturnMType($Area["Sys"]["type"]);

if ($Pl->Player['organization'])
$Pl_Org = ReturnOrg($Pl->Player['organization']);
//Special Commands GUI
if ($mode=='Move' && $actionb == 'A'){

	echo "<style type=\"text/css\">.pointHand{cursor: pointer}</style>";
	echo "<script language=\"JavaScript\">";
	echo "function focusZ(elm){";
	echo "document.getElementById(elm).style.zIndex = 2;";
	echo "}";
	echo "function blurZ(elm){";
	echo "document.getElementById(elm).style.zIndex = 1;";
	echo "}";
	echo "function setLayer(posX,posY,Width,Height,msgText){";
	echo "	var X = posX + document.body.scrollLeft + 10;";
	echo "	var Y = posY + document.body.scrollTop + 10;";
	echo "	if(eval(posX + Width + 30) > document.body.clientWidth){";
	echo "		X = eval(posX - Width + document.body.scrollLeft - 20);";
	echo "	}if(eval(posY + Height + 30) > document.body.clientHeight){";
	echo "		Y = eval(posY - Height + document.body.scrollTop - 20);";
	echo "	}if(X<0){";
	echo "		X = 0;";
	echo "	}if(Y<0){";
	echo "		Y = 0;";
	echo "	}";
	echo "	tmpTxt = eval(msgText);";
	echo "	document.getElementById(\"mapinfo\").style.width = Width;";
	echo "	document.getElementById(\"mapinfo\").style.height = 'auto';";
	echo "	document.getElementById(\"mapinfo\").style.backgroundColor = \"ffffdd\";";
	echo "	document.getElementById(\"mapinfo\").style.padding = 10;";
	echo "	document.getElementById(\"mapinfo\").innerHTML = tmpTxt;";
	echo "	document.getElementById(\"mapinfo\").style.border = \"solid 1px #000000\";";
	echo "	document.getElementById(\"mapinfo\").style.left = X;";
	echo "	document.getElementById(\"mapinfo\").style.top  = Y;";
	echo "}function offLayer(){";
	echo "	document.getElementById(\"mapinfo\").style.width = 0;";
	echo "	document.getElementById(\"mapinfo\").style.height = 0;";
	echo "	document.getElementById(\"mapinfo\").innerHTML = \"\";";
	echo "	document.getElementById(\"mapinfo\").style.backgroundColor = \"transparent\";";
	echo "	document.getElementById(\"mapinfo\").style.border = 0;";
	echo "}";
	echo "function modifyMap(state){";
	echo "var state = parseInt(state);";
	echo "var elm = document.getElementById('mapTable');";
	echo "	switch(state){";
	echo "		case 0: elm.className = 'AlphaChan';break;";
	echo "		case 1: elm.className = 'NormChan';break;";
	echo "		case 2: elm.className = 'HideChan';break;";
	echo "	}";
	echo "}";
	echo "</script>";

	echo "<font style=\"font-size: 12pt\">移動</font>";
	printTHR();

	echo "<form action=map.php?action=Move method=post name=mainform>";
	echo "<input type=hidden value='Process' name=actionb>";
	echo "<input type=hidden name=destination value=''>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	
	
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 10pt; border-color: #FFFFFF\">";
	echo "<tr><td align=left width=250><b style=\"font-size: 10pt;\">從 {$Pl->Player[coordinates]} 移動的可能性: </b></td></tr>";
	echo "<tr><td align=center>";
	echo "<div align=left><b>世界地圖:</b></div>";



	echo "<table align=center border=0 cellpadding=0 cellspacing=0 style=\"color: white; border-collapse: collapse; border-color: #111111\" width=90% height=90%>";
	echo "<tr align=center valign=center><td style=\"background:black url($General_Image_Dir/background/map_bg_s.png)\">";
	
	$Pl->Area = ReturnMap($Pl->Player['coordinates']);
	
	$Areas = array(
	'A1N', 'A1E', 'A1S', 'A1W',
	'A2N', 'A2E', 'A2S', 'A2W',
	'A3N', 'A3E', 'A3S', 'A3W',
	'B1N', 'B1E', 'B1S', 'B1W',
	'B2N', 'B2E', 'B2S', 'B2W',
	'B3N', 'B3E', 'B3S', 'B3W',
	'C1N', 'C1E', 'C1S', 'C1W',
	'C2N', 'C2E', 'C2S', 'C2W',
	'C3N', 'C3E', 'C3S', 'C3W');
	
	$A_Inf = $O_Inf = array();
	$LastOrg = 'none';
	$b = 0;
	$PlayerCount = array();

	
	foreach($Areas as $a){
		$A_Inf[$a] = ReturnMap($a);
		$PlayerCount[$a] = 0;
		if($A_Inf[$a]['User']['occupied'] != $LastOrg){
			$O_Inf[$a] = ReturnOrg($A_Inf[$a]['User']['occupied']);
			$LastOrg = $A_Inf[$a]['User']['occupied'];
		}else $O_Inf[$a] = $O_Inf[$b];
		
		$b = $a;
	}

	$sql = ("SELECT `coordinates`, COUNT( `coordinates` ) AS `count` FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` GROUP BY `coordinates`;");
	$query = mysql_query($sql);
	while( $results = mysql_fetch_array($query) ){
		$PlayerCount[$results['coordinates']] = $results['count'];
	}

		$Tbl_i = array(
				array('C1W','C1N','C2W','C2N','C3W','C3N'),
				array('C1S','C1E','C2S','C2E','C3S','C3E'),
				array('B1W','B1N','B2W','B2N','B3W','B3N'),
				array('B1S','B1E','B2S','B2E','B3S','B3E'),
				array('A1W','A1N','A2W','A2N','A3W','A3N'),
				array('A1S','A1E','A2S','A2E','A3S','A3E')
		);
		
		echo "<table align=center border=0 cellpadding=0 cellspacing=0 class='AlphaChan' width=420 height=312 id='mapTable'>";
		
			foreach($Tbl_i as $i_r){
				echo "<tr>";
				foreach($i_r as $i_c => $a_id){
					$MType = ReturnMType($A_Inf[$a_id]['Sys']['type']);
					echo "<span id=MapDiscription_".$a_id." style=\"visibility: hidden; position: absolute;\">";
					echo $A_Inf[$a_id]['User']['aname']." ($MType)<br>&nbsp;&nbsp;&nbsp;軍力: ".$A_Inf[$a_id]['User']['tickets'];
					echo "<br>&nbsp;&nbsp;&nbsp;所屬國: ".$O_Inf[$a_id]['name'];
					echo "<br>&nbsp;&nbsp;&nbsp;區域人數: ".$PlayerCount[$a_id];
					echo "</span>";
					$cursor = 'default';
					$dis = 'return false;';
					$border = '';
					$label = "<span style='background: black; width: 30px'>$a_id</span>";
					if(strpos($Pl->Area['Sys']['movement'],$A_Inf[$a_id]['Sys']['area']) !== false || ($Pl->Area['Sys']['area'] == $A_Inf[$a_id]['Sys']['area'] && $Pl->Player['coordinates'] != $a_id)){
						$dis = "mainform.destination.value='$a_id';mainform.moveBtn.disabled=false;mainform.moveBtn.value='移動往$a_id';";
						$cursor = 'pointer';
					}
					elseif($a_id == $Pl->Player['coordinates']) $border = 'border: 2px solid white;';
					else{
						$label = '&nbsp;';
					}
					printf("<td align=center width=70 height=52 style=\"background: %s;cursor: %s; %s\" onClick=\"%s\" OnMouseOver=\"setLayer(event.clientX,event.clientY,150,80,'document.getElementById(\'MapDiscription_".$a_id."\').innerHTML')\" OnMouseOut=\"offLayer()\">%s</td>",$O_Inf[$a_id]['color'],$cursor,$border,$dis,$label);
				}
				echo "</tr>";
			}
		
		
		
		echo "</table>";

	echo "</td></tr></table>";
	echo "<hr width=80%><input type=submit value=(請左擊地圖挑選目的地) name=moveBtn disabled $BStyleB style=\"$BStyleA\"><br>";
	echo "顯示國家顏色: <span onClick=\"document.getElementById('rdo0').click()\" class='pointHand'><input type='radio' name='mapCColor' value='0' onClick='modifyMap(0)' checked id=rdo0>半透明</span> ";
	echo "<span onClick=\"document.getElementById('rdo1').click()\" class='pointHand'><input type='radio' name='mapCColor' value='1' onClick='modifyMap(1)' id=rdo1>不透明</span> ";
	echo "<span onClick=\"document.getElementById('rdo2').click()\" class='pointHand'><input type='radio' name='mapCColor' value='2' onClick='modifyMap(2)' id=rdo2>不顯示</span> ";
	echo "</td></tr></form></table>";
	// Map Information Div
	echo "<div id=mapinfo style=\"position:absolute; z-index:3;color: black;\" align=left></div>";

}
elseif ($mode=='Move' && $actionb == 'Process'){

$Area = ReturnMap($Pl->Player['coordinates']);
$dest = substr($destination,0,2);
//$Area_Org = ReturnOrg($Area["User"]["occupied"]);
if (!$destination){echo "錯誤！請先指定要移動到的目的地。";postFooter();exit;}
if(strpos($Area["Sys"]["movement"],$dest) === false && $Area['Sys']['area'] != $dest){echo "錯誤！";postFooter();exit;}

	$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `coordinates` = '$destination',`btltime` = '$CFU_Time' WHERE `username` = '".$Pl->Player['name']."' LIMIT 1");
	$query = mysql_query($sql) or die ('無法取得組織資訊, 原因:' . mysql_error() . '<br>');

	echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$PriTarget>";
	echo "<p align=center style=\"font-size: 16pt\">移動完成了！<input type=submit value=\"返回\" onClick=\"parent.SecTarget.location.replace('gen_info.php')\"></p>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
	echo "</form>";

}
else {echo "未定義動作！";}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>