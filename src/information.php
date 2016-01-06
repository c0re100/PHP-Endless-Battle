<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
$InfSbAct = (isset($InfSbAct)) ? $InfSbAct : false;
include('cfu.php');
$additionalHeader = '<link href="images/alphaChannel.css" rel="stylesheet" type="text/css" />';
postHead('','phpeb_session_dir',$additionalHeader);
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}

include('includes/sfo.class.php');
$Pl = new player_stats;
$Pl->SetUser($Pl_Value['USERNAME']);
$Pl->FetchPlayer(true,true);

//Adjust to user's setting
if ($Pl->Player['gen_img_dir'])
$General_Image_Dir = $Pl->Player['gen_img_dir'];
if ($Pl->Player['unit_img_dir'])
$Unit_Image_Dir = $Pl->Player['unit_img_dir'];
if ($Pl->Player['base_img_dir'])
$Base_Image_Dir = $Pl->Player['base_img_dir'];

$Pl_Org = ReturnOrg($Pl->Player['organization']);

$textboxStyle = " style=\"font-size: 9pt; color: #ffffff; background-color: #000000; text-align: center;\" onmouseover=\"this.style.color='yellow'\" onmouseout=\"this.style.color='white'\" ";

$hoverPhrase = " onMouseOver=\"this.style.color='yellow'\" onMouseOut=\"this.style.color='white'\" ";

$Areas = array(
	'A1N', 'A1E', 'A1S', 'A1W',
	'A2N', 'A2E', 'A2S', 'A2W',
	'A3N', 'A3E', 'A3S', 'A3W',
	'B1N', 'B1E', 'B1S', 'B1W',
	'B2N', 'B2E', 'B2S', 'B2W',
	'B3N', 'B3E', 'B3S', 'B3W',
	'C1N', 'C1E', 'C1S', 'C1W',
	'C2N', 'C2E', 'C2S', 'C2W',
	'C3N', 'C3E', 'C3S', 'C3W'
);

$P_Areas = array('A1','A2','A3','B1','B2','B3','C1','C2','C3');

$Tbl_i = array(
	array('C1W','C1N','C2W','C2N','C3W','C3N'),
	array('C1S','C1E','C2S','C2E','C3S','C3E'),
	array('B1W','B1N','B2W','B2N','B3W','B3N'),
	array('B1S','B1E','B2S','B2E','B3S','B3E'),
	array('A1W','A1N','A2W','A2N','A3W','A3N'),
	array('A1S','A1E','A2S','A2E','A3S','A3E')
);

$tcImg[0] = $Base_Image_Dir. '/crossImgB.gif';
$tcImg[1] = $Base_Image_Dir. '/tickImgB.gif';

function layerScript($divId = 'mapinfo'){
	echo "function setLayer(posX,posY,Width,Height,msgText){";
	echo "	var X = posX + document.body.scrollLeft + 10;";
	echo "	var Y = posY + document.body.scrollTop + 10;";
	echo "	if(posX + Width + 30 > document.body.clientWidth){";
	echo "		X = posX - Width + document.body.scrollLeft - 20;";
	echo "	}if(posY + Height + 30 > document.body.clientHeight){";
	echo "		Y = posY - Height + document.body.scrollTop - 20;";
	echo "	}if ( X < 0 ){";
	echo "		X = 0;";
	echo "	}if( Y < 0 ){";
	echo "		Y = 0;";
	echo "	}";
	echo "	var tmpTxt = eval(msgText);";
	echo "	document.getElementById(\"$divId\").style.width = Width;";
	echo "	document.getElementById(\"$divId\").style.height = 'auto';";
	echo "	document.getElementById(\"$divId\").style.backgroundColor = \"ffffdd\";";
	echo "	document.getElementById(\"$divId\").style.padding = 10;";
	echo "	document.getElementById(\"$divId\").innerHTML = tmpTxt;";
	echo "	document.getElementById(\"$divId\").style.border = \"solid 1px #000000\";";
	echo "	document.getElementById(\"$divId\").style.left = X;";
	echo "	document.getElementById(\"$divId\").style.top  = Y;";
	echo "}function offLayer(){";
	echo "	document.getElementById(\"$divId\").style.width = 0;";
	echo "	document.getElementById(\"$divId\").style.height = 0;";
	echo "	document.getElementById(\"$divId\").innerHTML = \"\";";
	echo "	document.getElementById(\"$divId\").style.backgroundColor = \"transparent\";";
	echo "	document.getElementById(\"$divId\").style.border = 0;";
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
}

//Special Commands GUI
if ($mode == 'Main'){

echo "<style type=\"text/css\">.pointHand{cursor: pointer}</style>";
echo "<form action=information.php method=post name=infoForm>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden value='Main' name=action>";
echo "<input type=hidden value='false' name=ByID>";
echo "<input type=hidden value='A1N' name=searchArea>";
echo "<input type=hidden name=listMethod value='ByPArea'>";
echo "<input type=hidden name=search value=''>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

echo "<script language=\"JavaScript\">";
layerScript();
echo "function sendAction(action){";
echo "	document.infoForm.action.value=action;";
echo "	document.infoForm.submit();";
echo "}function getPlayerListByPArea(area){";
echo "	document.infoForm.action.value='listPlayers';";
echo "	document.infoForm.listMethod.value='ByPArea';";
echo "	document.infoForm.search.value=area;";
echo "	document.infoForm.submit();";
echo "}function chooseArea(area){";
echo "	document.infoForm.searchArea.value=area;";
echo "}";
echo "</script>";

echo "<table width=100% height=90%><tr><td align=center>";

echo "<table cellspacing=2 cellpadding=3>";
echo "<tr><td colspan=3 align=center style='font-size: 12pt;'><b>情報</b><br>".sprintTHR()."</td></tr>";
echo "<tr align=center><td colspan=3><b>地區情報</b></td></tr>";

echo "<tr align=center><td colspan=2>";
echo "顯示國家顏色: <span onClick=\"document.getElementById('rdo0').click()\" class='pointHand'><input type='radio' name='mapCColor' value='0' onClick='modifyMap(0)' id=rdo0>半透明</span> ";
echo "<span onClick=\"document.getElementById('rdo1').click()\" class='pointHand'><input type='radio' name='mapCColor' value='1' onClick='modifyMap(1)' id=rdo1>不透明</span> ";
echo "<span onClick=\"document.getElementById('rdo2').click()\" class='pointHand'><input type='radio' name='mapCColor' value='2' onClick='modifyMap(2)' checked id=rdo2>不顯示</span> ";
echo "</td><td>&nbsp;</td></tr>";

echo "<tr align=center valign=center><td colspan=2>";

	// Map Info
	echo "<table align=center border=0 cellpadding=0 cellspacing=0 style=\"border-collapse: collapse; width: 420px; height: 312px;\">";
	echo "<tr><td style=\"background: url($General_Image_Dir/background/map_bg_s.png); width: 420px; height: 312px;\" colspan=3>";
	
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

	// Draw Map
	echo "<table align=center border=0 cellpadding=0 cellspacing=0 class='HideChan' id=\"mapTable\" style=\"border-collapse: collapse; border-color: #111111; width: 420px; height: 312px;\">";
		foreach($Tbl_i as $i_r){
			echo "<tr>";
			foreach($i_r as $i_c => $a_id){
				$parentArea = substr($a_id,0,2);
				echo "<span id=MapDiscription_".$a_id." style=\"visibility: hidden; position: absolute;\">";
				echo "$a_id (".ReturnMType($A_Inf[$a_id]['Sys']['type']).")<br>".$A_Inf[$a_id]['User']['aname']."<br>&nbsp;&nbsp;&nbsp;軍力: ".$A_Inf[$a_id]['User']['tickets'];
				echo "<br>&nbsp;&nbsp;&nbsp;所屬國: ".$O_Inf[$a_id]['name'];
				echo "<br>&nbsp;&nbsp;&nbsp;區域人數: ".$PlayerCount[$a_id];
				echo "</span>";
				
				if(isset($PlayerCount[$parentArea])) $PlayerCount[$parentArea] += $PlayerCount[$a_id];
				else $PlayerCount[$parentArea] = $PlayerCount[$a_id];
				
				printf( '<td align=center width=70 height=52 style="cursor: pointer; background: %s;"',$O_Inf[$a_id]['color']);
				echo ' onClick="chooseArea(\''.$a_id.'\');sendAction(\'areaInfo\');"';
				echo ' OnMouseOver="setLayer(event.clientX,event.clientY,150,80,\'document.getElementById(\\\'MapDiscription_'.$a_id.'\\\').innerHTML\');"';
				echo ' OnMouseOut="offLayer();">&nbsp;';
				echo '</td>';
			}
			echo "</tr>";
		}
	echo "</table>";

echo "</table></td>";

echo "<td valign=top align=left>大區情報:<br>";

foreach($P_Areas as $P_Area){
	echo "<div style=\"width: 100%; margin: 0px; padding-left: 5px; cursor: pointer;\" onclick=\"getPlayerListByPArea('$P_Area');\"; ";
	echo " onmouseover=\"this.style.color='yellow';\" onmouseout=\"this.style.color='white';\">";
	echo "$P_Area: $PlayerCount[$P_Area]人</div>";
}

echo "</td></tr>";

echo "<tr align=center><td>組織情報</td><td>玩家情報</td><td>歷史</td></tr>";

echo "<tr><td align=center>";

	// Organization Info
	echo "<input type=text name=searchOrg value='<<輸入組織名稱>>' $textboxStyle onClick=\"this.value='';orgSearchBtn.disabled=false;\"> ";
	echo "<input type=button name=orgSearchBtn value='搜尋' onClick=\"sendAction('searchOrg');\" $textboxStyle disabled>";
	echo "<br><input type=button value='組織列表' onClick=\"sendAction('listOrg');\" $textboxStyle>";
	

echo "</td><td align=center>";

	// Player Info
	echo "<input type=text name=searchPlayer value='<<輸入玩家名稱>>' $textboxStyle onClick=\"this.value='';plSearchBtn.disabled=false;\"> ";
	echo "<input type=button name=plSearchBtn value='搜尋' onClick=\"sendAction('searchPlayer');\" $textboxStyle disabled>";
	echo "<br><input type=button value='線上玩家' $textboxStyle onClick=\"sendAction('onlinePlayers');\">";

echo "</td><td align=center>";

	// History Info
	echo "<input type=button value='查詢歷史' onClick=\"sendAction('History');\" $textboxStyle>";


echo "</td></tr>";

echo "</table>";

echo "</tr></td></table>";
echo "</form>";

// Map Information Div
echo "<div id=mapinfo style=\"position:absolute; z-index:3;color: black;\" align=left></div>";
}
elseif($mode == 'searchPlayer'){

	if(!isset($ByID)) $ByID = 'false';

	$SearchBy = '';
	if($ByID == 'true'){
		$SearchBy = 'username';
	}
	else{
		$SearchBy = 'gamename';
	}

	$restriction = array("|","`","'","--","\"","\\");
	$searchPlayer = str_replace($restriction,'',$searchPlayer);

	$sql = "SELECT `username`, COUNT(*) AS `count` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `$SearchBy` = '".$searchPlayer."';";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	
	$Op = new player_stats;
	
	if($result['count'] != 1){
		echo "<form action=information.php method=post name=infoForm>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden value='listPlayers' name=action>";
		echo "<input type=hidden name=search value='$searchPlayer'>";
		echo "<input type=hidden name=listMethod value='search'>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		if($ByID == 'true'){
			echo "<p align=center style=\"font-size: 12pt; color: white;\"><Br><br><br>找不到目標玩家, 回到情報首頁中！</p>";
			echo "<script language=\"JavaScript\">";
			echo "setTimeout(\"infoForm.action.value='Main';infoForm.submit();\",1000);";
			echo "</script>";
		}
		else{
			echo "<p align=center style=\"font-size: 12pt; color: white;\"><Br><br><br>找不到目標玩家「".$searchPlayer."」, 進行關鍵字搜索中！</p>";
			echo "<script language=\"JavaScript\">";
			echo "setTimeout(\"infoForm.submit();\",1000);";
			echo "</script>";
		}
		echo "</form>";
		exit();
	}
	
	$Op->SetUser($result['username']);
	$Op->FetchPlayer();

	// Get Organization Information
	$sql = ("SELECT `name`, `color` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE id = '". $Op->Player['organization'] ."'");
	$query = mysql_query($sql);
	$Op_Org = mysql_fetch_array($query);

	//Ranks
	$Op_Rank = rankConvert($Op->Player['rank']);
	if ($Op->Player['rights'] == '1') $Op_Rank = "$Op_Rank($RightsClass[Major])";
	elseif ($Op->Player['rights'])    $Op_Rank = "$Op_Rank($RightsClass[Leader])";

	// Process Character Information
	// Using Phase Structure

	//
	// Prephase I
	//
	
	//Get User MS Stats
	if ($Op->Player['msuit'] == "nil") $Op->Player['msuit'] = '0';
	$Op->ProcessMS();
	
	// Initialize Player Details
	$Op->iniFixes(true);
	$Op->analyzeHypermodeState();
	$Op->ProcessAllWeapon();

	//
	// Prephase II
	//

	// Set Spec Sub-System: Check Requirements
	$Op->checkSetSpec();
	if($Op->SetSpecID){
		// Include Interface
		include_once('includes/spc/spc.superclass.php');
		// Include Implementation Classes
		include_once('includes/spc/spc.'.$Op->SetSpecID.'.class.php');
		$str = '$Op->SetSpec = new sSpc_'.$Op->SetSpecID.'($Pl);';
		eval($str);
		$Op->SetSpec->checkSetActivation();
		$Op->SetSpec->prephase();
	}

	// Apply Weapon/Equipment Type Custom Limitations
	$Op->applyTypeCustoms();

	//
	// Metaphase
	//

	//Generate Special Ability Pool
	$Op->generateSpecialAbilityPool();

	// Meta-phase Set Specs
	if($Op->SetSpecID) $Op->SetSpec->metaphase();

	// Pilot Hypermode Effects
	$Op->applyEXAM();
	$Op->applySEEDMode();
	$Op->deterSpecRequirements();

	// MS Effects
	//Upper-case Mob Effects
	$Op->applyMSMobU();
	//Upper-case Tar Effect
	$Op->applyMSTarU();
	//Upper-case Def Specs
	$Op->applyMSDefU();

	//
	// Phase End
	//

	// Process Equipment Information
	echo "<script language=\"JavaScript\">";
	layerScript('wepinfo');

	$Eq_Listing = Array('A' => 'wepa','B' => 'wepb','C' => 'wepc','D' => 'eqwep','E' => 'p_equip');
	$Wep_Sym = Array('A' => '','B' => '','C' => '','D' => '','E' => '');

		$i = 0;
		$ms_js = '';
		foreach($Eq_Listing as $I => $V){
			$displayXp = '±0%';
			$W_Inf = '';
			if ($Op->Player[$V] && $Op->Player[$V] != '0<!>0') {
				if ($Op->Eq[$I]['exp'] > 0) $displayXp = '+'.($Op->Eq[$I]['exp']/100).'%';
				elseif ($Op->Eq[$I]['exp'] < 0) $displayXp = ($Op->Eq[$I]['exp']/100).'%';
				$W_Inf = $Op->Eq[$I]['name']."<br>狀態值: ".$displayXp."<hr width=95%>能力:<br>";
				$W_Inf .= "　攻擊力: ".$Op->Eq[$I]['atk']."　　　回數: ".$Op->Eq[$I]['rd']."<br>　命中: ".$Op->Eq[$I]['hit']."　　　EN消費: ".$Op->Eq[$I]['enc']."<br>";
				$W_Inf .= "距離/屬性: ".getRangeAttrb($Op->Eq[$I]['range'],$Op->Eq[$I]['attrb'],$Op->Eq[$I]['equip'],false)."<br>";
				$W_Inf .= "特殊效果:<br>";
				if ($Op->Eq[$I]['equip']) $W_Inf .= "可以裝備<br>";
				$W_Inf .= ReturnSpecs($Op->Eq[$I]['spec']);
				$ms_js .= "msJsTxt[".$i."] = '".$W_Inf."';\n";
				$Wep_Sym[$I] = 1;
			}
			else {
				$ms_js .= "msJsTxt[".$i."] = '';\n";
				$Wep_Sym[$I] = 0;
			}
			$i++;
		}


	// Script For Generating MS information
	echo "
	var msJsTxt = new Array();
	$ms_js
	
	function trySetLayer(posX,posY,Width,Height,slot){
		if(msJsTxt[slot]){
			setLayer(posX,posY,Width,Height,'msJsTxt['+slot+']');
		}
	}
	</script>";

	// Process Equipment Information Done

	// Draw Table
	if($Pl->Player['organization'] && $Pl->Player['rights'] && !$Op->Player['rights'] && $Op->Player['organization'] != $Pl->Player['organization'] && $Pl->User != $Op->User){
		$orgCmd = true;
		echo "<form action='organization.php?action=Employ' method='post' name='orgForm'>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='{$Op->User}' name=EmployTar>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}else $orgCmd = false;
	echo "<form action=information.php method=post name=infoForm>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name='action' value='Main'>";
	echo "<input type=hidden name='searchOrg' value=''>";
	echo "<input type=hidden name='searchArea' value=''>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"JavaScript\">";
	echo "function getInfo(org){";
	echo "	infoForm.action.value='searchOrg';";
	echo "	infoForm.searchOrg.value=org;";
	echo "	infoForm.submit();";
	echo "}function getAreaInfo(area){";
	echo "	infoForm.action.value='areaInfo';";
	echo "	infoForm.searchArea.value=area;";
	echo "	infoForm.submit();";
	echo "}</script>";


	echo "<table width=100% height=100%><tr><td align=center>";
	
	echo "<table cellspacing=2 cellpadding=3>";
	echo "<tr><td align=center colspan=2><b>玩家 ".$Op->Player['gamename']." $Op_Rank 的資料</b></td></tr>";

	echo "<tr>";
	
	//Pilot Status
	echo "<td align=center valign=top>";
		echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;\" width=\"100%\">";

		echo "<tr><td colspan=2>";
		echo "<b>HP: &nbsp;</b>".$Op->Player['hp']." / ".$Op->Player['hpmax']." <br>";
		if($Op->Player['hpmax'] > 0) $HP_Ratio = ceil(($Op->Player['hp']/$Op->Player['hpmax'])*125);
		else $HP_Ratio = 125;
		echo "<img src='$General_Image_Dir/neo/blue_bar.gif' width=".$HP_Ratio." height=5><img src='$General_Image_Dir/neo/orange_bar.gif' width=".(125-$HP_Ratio)." height=5>";
		echo "</td><td colspan=2>";
		echo "<b>EN: &nbsp;</b>".$Op->Player['en']." / ".$Op->Player['enmax']." <br>";
		if($Op->Player['enmax'] > 0) $EN_Ratio = ceil(($Op->Player['en']/$Op->Player['enmax'])*125);
		else $EN_Ratio = 125;
		echo "<img src='$General_Image_Dir/neo/blue_bar.gif' width=".$EN_Ratio." height=5><img src='$General_Image_Dir/neo/orange_bar.gif' width=".(125-$EN_Ratio)." height=5>";
		echo "</td></tr>";

		echo "<tr><td colspan=4 align=center>";
		echo "<img src='$General_Image_Dir/neo/dot_rule.gif'>";
		echo "</td></tr>";

		echo "<tr style=\"font-weight: Bold;\">";
		echo "<td width=50>Level:</td>";
		echo "<td width=100>Type:</td>";
		echo "<td width=70 rowspan=2><b>所屬組織:</b><br>";
		echo "&nbsp;&nbsp;&nbsp;<span style='color: $Op_Org[color]; cursor: pointer' onClick=\"getInfo('".$Op_Org['name']."');\">".$Op_Org['name']."</span><br>";
		echo "<b>所在區域:</b><br>";
		echo "&nbsp;&nbsp;&nbsp;<span style='cursor: pointer; text-decoration: underline;' onClick=\"getAreaInfo('".$Op->Player['coordinates']."');\" $hoverPhrase>".$Op->Player['coordinates']."</span>";
		echo "</td>";
		echo "<td width=100>勝利:</td>";
		echo "</tr>";

		echo "<tr height=50 align=center valign=top>";
		echo "<td>".$Op->Player['level']."</td>";

		echo "<td><b ";
		if ($Op->Player['hypermode'] == 1 || ($Op->Player['hypermode'] >= 4 && $Op->Player['hypermode'] <= 6))
		echo " style=\"filter: glow(color: 0000FF,strength=2)\"";
		echo ">{$Op->Player[type_name]}";
	
		if ($Op->Player['hypermode'] == 1 || $Op->Player['hypermode'] == 5)
			echo "<br><span id=seedTxt style=\"color: FFFF00;font-weight: bold\">SEED Mode</span>";
		else	echo "<br><span id=seedTxt>&nbsp;</span>";
		if ($Op->Player['hypermode'] >= 4 && $Op->Player['hypermode'] <= 6)
			echo "<br><span id=examTxt style=\"color: FF0000;font-weight: bold\">EXAM Activated</span>";
		else	echo "<br><span id=examTxt>&nbsp;</span>";
		echo "</b></td>";
		echo "<td align=left>績分:".$Op->Player['v_points']." <br> 次數:".$Op->Player['victory']."</td>";
		echo "</tr>";
	
		echo "<tr><td colspan=4 align=center>";
		echo "<img src='$General_Image_Dir/neo/dot_rule.gif'>";
		echo "</td></tr>";
		echo "<tr><td colspan=4 align=center>";
			echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" width=\"300\">";
			echo "<tr style=\"font-weight: Bold;\">";
			echo "<td width=75 align=center>Attacking</td>";
			echo "<td width=35 align=right>".dualConvert($Op->Player['attacking'])."&nbsp;</td>";
			echo "<td width=35>+ ".dualConvert($Op->PiFix['attacking'],30)."</td>";
			echo "<td width=75 align=center>攻擊值</td>";
			echo "<td width=30>".dualConvert($Op->Player['attacking'] + $Op->PiFix['attacking'],200)."</td>";
			echo "</tr>";
			echo "<tr style=\"font-weight: Bold;\">";
			echo "<td width=75 align=center>Defending</td>";
			echo "<td width=35 align=right>".dualConvert($Op->Player['defending'])."&nbsp;</td>";
			echo "<td width=35>+ ".dualConvert($Op->PiFix['defending'],30)."</td>";
			echo "<td width=75 align=center>防禦值</td>";
			echo "<td width=30>".dualConvert($Op->Player['defending'] + $Op->PiFix['defending'],200)."</td>";
			echo "</tr>";
			echo "<tr style=\"font-weight: Bold;\">";
			echo "<td width=75 align=center>Reacting</td>";
			echo "<td width=35 align=right>".dualConvert($Op->Player['reacting'])."&nbsp;</td>";
			echo "<td width=35>+ ".dualConvert($Op->PiFix['reacting'],30)."</td>";
			echo "<td width=75 align=center>回避值</td>";
			echo "<td width=30>".dualConvert($Op->Player['reacting'] + $Op->PiFix['reacting'],200)."</td>";
			echo "</tr>";
			echo "<tr style=\"font-weight: Bold;\">";
			echo "<td width=75 align=center>Targeting</td>";
			echo "<td width=35 align=right>".dualConvert($Op->Player['targeting'])."&nbsp;</td>";
			echo "<td width=35>+ ".dualConvert($Op->PiFix['targeting'],30)."</td>";
			echo "<td width=75 align=center>命中值</td>";
			echo "<td width=30>".dualConvert($Op->Player['targeting'] + $Op->PiFix['targeting'],200)."</td>";
			echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
	// Equipment Information
		echo "<tr><td colspan=4 align=center>";
		echo "<img src='$General_Image_Dir/neo/dot_rule.gif'>";
		echo "</td></tr>";
		echo "<tr><td colspan=4 align=center>";
		echo "<b>機體武裝</b>:";
			echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" width=300>";
			echo "<tr align=center>";
			echo "<td width=60>主武器</td>";
			echo "<td width=60>備用一</td>";
			echo "<td width=60>備用二</td>";
			echo "<td width=60>輔助裝備</td>";
			echo "<td width=60>常規裝備</td>";
			echo "</tr>";
			echo "<tr align=center>";
			echo "<td width=60 OnMouseOver=\"trySetLayer(event.clientX,event.clientY,200,100,0)\" OnMouseOut=\"offLayer()\" ><img src='".$tcImg[$Wep_Sym['A']]."' alt=''></td>";
			echo "<td width=60 OnMouseOver=\"trySetLayer(event.clientX,event.clientY,200,100,1)\" OnMouseOut=\"offLayer()\" ><img src='".$tcImg[$Wep_Sym['B']]."' alt=''></td>";
			echo "<td width=60 OnMouseOver=\"trySetLayer(event.clientX,event.clientY,200,100,2)\" OnMouseOut=\"offLayer()\" ><img src='".$tcImg[$Wep_Sym['C']]."' alt=''></td>";
			echo "<td width=60 OnMouseOver=\"trySetLayer(event.clientX,event.clientY,200,100,3)\" OnMouseOut=\"offLayer()\" ><img src='".$tcImg[$Wep_Sym['D']]."' alt=''></td>";
			echo "<td width=60 OnMouseOver=\"trySetLayer(event.clientX,event.clientY,200,100,4)\" OnMouseOut=\"offLayer()\" ><img src='".$tcImg[$Wep_Sym['E']]."' alt=''></td>";
			echo "</tr>";
			echo "</table>";
		echo "</td></tr>";
		echo "</table>";
	//MS Status
	echo "<td align=center>";
		echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;\" width=\"300\">";
		echo "<tr style=\"font-weight: Bold;\"><td colspan=4>".$Op->MS['msname']."</td></tr>";
		echo "<tr><td colspan=4 align=center><img src=\"".$Unit_Image_Dir."/".$Op->MS['image']."\"></td></tr>";
		echo "<tr><td colspan=4 align=center><img src='$General_Image_Dir/neo/dot_rule.gif'></td></tr>";
		echo "<tr style=\"font-weight: Bold;\">";
		echo "<td width=60 align=center>Attacking</td>";
		echo "<td width=60 colspan=2 align=left>&nbsp;".dualConvert($Op->MS['atf'],65)."</td>";
		echo "<td width=180 rowspan=4 valign=top style=\"font-size: 8pt;padding-left: 5px\"><font style=\"font-size: 10pt\">特殊效果:</font><br><span style=\"padding-left: 10px\">";
		echo ReturnSpecs($Op->MS['spec']);
		echo "</span></td></tr>";
		echo "<tr style=\"font-weight: Bold;\">";
		echo "<td width=60 align=center>Defending</td>";
		echo "<td width=60 colspan=2 align=left>&nbsp;".dualConvert($Op->MS['def'],75)."</td>";
		echo "</tr>";
		echo "<tr style=\"font-weight: Bold;\">";
		echo "<td width=60 align=center>Mobility</td>";
		echo "<td width=60 colspan=2 align=left>&nbsp;".dualConvert($Op->MS['ref'],75)."</td>";
		echo "</tr>";
		echo "<tr style=\"font-weight: Bold;\">";
		echo "<td width=60 align=center>Targeting</td>";
		echo "<td width=60 colspan=2 align=left>&nbsp;".dualConvert($Op->MS['taf'],75)."</td>";
		echo "</tr>";
		echo "<tr><td colspan=4>&nbsp;</td></tr>";
		echo "</table>";
		echo "<br>";
		if($orgCmd) echo "<input type=button value='招募' onClick=\"document.orgForm.submit();\" $textboxStyle>";
	echo "<input type=submit value='返回' onClick=\"infoForm.action.value='Main'\" $textboxStyle>";
	echo "</td></tr></table>";
	echo "</form>";

	// Weapon Information Div
	echo "<div id=wepinfo style=\"position:absolute; z-index:3;color: black;\" align=left></div>";
	
}
elseif ($mode == 'onlinePlayers'){

	echo "<form action=information.php method=post name=infoForm>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden value='Main' name=action>";
	echo "<input type=hidden value='true' name=ByID>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"JavaScript\">";
	echo "function getInfo(player){";
	echo "	infoForm.action.value='searchPlayer';";
	echo "	infoForm.searchPlayer.value=player;";
	echo "	infoForm.submit();";
	echo "	}</script>";
	echo "<input type=hidden name=searchPlayer value=''>";
	echo "<table width=100% height=100% border=0><tr><td align=center valign=center>";
	echo "<table width=100% cellspacing=2 cellpadding=3 style=\"font-size:11px;\" border=1>";
	echo "<tr><td colspan=6><center><b>在線玩家</b></center></td></tr>";
	echo "<tr><td>編號</td><td>駕駛員名稱</td><td>所屬國家</td><td>等級</td><td>所在地區</td></tr>";
	$sqlgen  = ("SELECT gen.username AS `username`, `gamename`, `level`, `coordinates`, org.name As `oname` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` game,`".$GLOBALS['DBPrefix']."phpeb_user_general_info` gen,`".$GLOBALS['DBPrefix']."phpeb_user_organization` org WHERE ($CFU_Time - `time2`) < ".$GLOBALS['Offline_Time']." AND gen.username = game.username AND org.id = organization ORDER BY organization DESC,coordinates,level DESC");
	$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
	$counter = 0;
	while($R_Inf = mysql_fetch_array($query_gen)){
		$counter++;
		$level = abs($R_Inf['level']);
		echo 	"<tr>",
				"<td>$counter</td>",
				"<td><span style=\"cursor: pointer; text-decoration: underline;\" onClick=\"getInfo('$R_Inf[username]')\" $hoverPhrase>$R_Inf[gamename]</span></td>",
				"<td>$R_Inf[oname]</td>",
				"<td>$R_Inf[level]</td>",
				"<td>$R_Inf[coordinates]</td>",
			"</tr>";
	}
	echo "</table>";
	echo "<br><input type=submit value='返回' onClick=\"infoForm.action.value='Main'\" $textboxStyle>";
	echo "</td></tr></table>";
	echo "</form>";
}elseif ($mode == 'listPlayers'){

	$restriction = array("|","`","'","--","\"","\\");
	$search = str_replace($restriction,'',$search);
	$search = preg_replace("/<[^<>]*>/",'',$search);

	$whereClause = '';
	if($listMethod == 'ByOrg'){
		$whereClause = "WHERE `organization` = '".$search."' ";
	}elseif($listMethod == 'ByArea'){
		$whereClause = ", `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `b` WHERE `coordinates` = '".$search."' AND game.username = b.username ";
	}elseif($listMethod == 'ByPArea'){
		$whereClause = ", `".$GLOBALS['DBPrefix']."phpeb_user_general_info` `b` WHERE `coordinates` REGEXP '".$search."' AND game.username = b.username ";
	}elseif($listMethod == 'ByList'){
		$temp = array_unique(explode(',',$search));
		$pList = '';
		foreach($temp as $v){
			if($pList != '') $pList .= " OR `username` = '$v'";
			else $pList = " `username` = '$v' ";
		}
		$whereClause = " WHERE $pList ";
	}elseif($listMethod == 'search'){
		$whereClause = " WHERE `gamename` REGEXP '".$search."' ";
	}else{
		echo "Undefined Method.";
		exit;
	}

	$sql = "SELECT `game`.`username` AS `username`, `gamename` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` AS `game` $whereClause ORDER BY `gamename` ASC;";
	$query = mysql_query($sql) or die(mysql_error() . "<br>SQL: $sql<br>");

	$Players = array();
	for($i = 0; $temp = mysql_fetch_array($query); $i++) {
		$Players[$i] = $temp;
		unset($temp);
	}

	echo "<form action=information.php method=post name=infoForm>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=action value='searchPlayer'>";
	echo "<input type=hidden name=searchPlayer value=''>";
	echo "<input type=hidden name=ByID value='true'>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"JavaScript\">";
	echo "function getInfo(player){";
	echo "	infoForm.searchPlayer.value=player;";
	echo "	infoForm.submit();";
	echo "	}</script>";

	echo "<table width=100% height=100% border=0><tr><td align=center valign=center>";
	echo "<table width=680 cellspacing=2 cellpadding=3 style=\"font-size:11px; border: 1px solid white; border-collapse: collapse;\">";
	echo "<tr><td colspan=4 style=\"border: 1px solid white;\" align=center><b>玩家列表</b></td></tr>";

	$i = count($Players);
	
	if($i > 0){
		$name = '';
		$format = '<span style="text-decoration: underline; cursor: pointer" onClick="getInfo(\'%s\');" '.
				'onMouseOver="this.style.color=\'yellow\'" onMouseOut="this.style.color=\'white\'">%s</span>';
		$formatTd = '<td width=20 align=right>%d:</td><td width=300>%s</td>';
		for($j = 0; $j+1 < $i; $j+=2){
			echo "<tr>";
			$name = sprintf($format, $Players[$j]['username'], $Players[$j]['gamename']);
			printf($formatTd, $j+1, $name);
			$name = sprintf($format, $Players[$j+1]['username'], $Players[$j+1]['gamename']);
			printf($formatTd, $j+2, $name);
			echo "</tr>";
		}
		if( $i % 2 == 1 ){
			echo "<tr>";
			$name = sprintf($format, $Players[$j]['username'], $Players[$j]['gamename']);
			printf($formatTd, $j+1, $name);
			echo "<td>&nbsp;</td><td>&nbsp;</td></tr>";
		}
	}else{
		echo "<td colspan=4>沒有任何玩家。</td></tr>";
	}

	echo "</table>";
	echo "<br><input type=submit value='返回' onClick=\"infoForm.action.value='Main'\" $textboxStyle>";
	echo "</td></tr></table>";
	echo "</form>";



}
elseif ($mode == 'searchOrg'){
	
	if(!isset($ByID)) $ByID = 'false';
	
	$searchBy = 'name';
	if($ByID == 'true'){
		$searchOrg = intval($searchOrg);
		$searchBy = 'id';
	}else{
		$restriction = array("|","`","'","--","\"","\\");
		$searchOrg = str_replace($restriction,'',$searchOrg);
		$searchOrg = preg_replace("/<[^<>]*>/",'',$searchOrg);
	}

	$sql = "SELECT COUNT(*) AS `count` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` WHERE `$searchBy` = '".$searchOrg."';";
	$query = mysql_query($sql);
	$results = mysql_fetch_array($query);

	// Problem
	if( $results['count'] != 1 ) {

		echo "<form action=information.php method=post name=infoForm>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden value='listOrg' name=action>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "<p align=center style=\"font-size: 12pt; color: white;\"><Br><br><br>找不到目標組織, 回到組織列表中...</p>";
		echo "<script language=\"JavaScript\">";
		echo "setTimeout(\"infoForm.submit();\",1000);";
		echo "</script>";
		echo "</form>";
		exit();
	}

	$sql = "SELECT `id`, `funds` , `name` , `license` , `o`.`color` AS `color`, SUM(`tickets`) AS `tickets`, COUNT(`tickets`) AS `occupiedNum`" .
		"FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` `o`, `".$GLOBALS['DBPrefix']."phpeb_user_map` " .
		"WHERE `$searchBy` = '".$searchOrg."' AND `occupied` = `id` LIMIT 1;";
	$query = mysql_query($sql);
	$Info = mysql_fetch_array($query);

	$sql = "SELECT COUNT(*) AS `members` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '".$Info['id'] . "';";
	$query = mysql_query($sql);
	$temp = mysql_fetch_array($query);

	$Info['members'] = $temp['members'];

	$sql = "SELECT `username`, `gamename`, `rights` FROM `".$GLOBALS['DBPrefix']."phpeb_user_game_info` WHERE `organization` = '".$Info['id'] . "' AND rights > 0;";
	$query = mysql_query($sql);

	$noViceName = '--- 未任命 ---';
	$Info['vice'] = $noViceName;
	while($temp = mysql_fetch_array($query)){
		if($temp['rights'] == 1) {
			$Info['leader'] = $temp['gamename'];
			$Info['leader_id'] = $temp['username'];
		}
		else {
			$Info['vice'] = $temp['gamename'];
			$Info['vice_id'] = $temp['username'];
		}
	}

	if($Info['license'] < 2 && $Info['id'] != 0 && $Pl->Player['organization'] == 0){
		$orgCmd = true;
		echo "<form action='organization.php?action=JoinOrg' method='post' name='orgForm'>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden value='B' name=actionb>";
		echo "<input type=hidden value='{$Info['id']}' name=GiveTar>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";
	}else $orgCmd = false;
	echo "<form action=information.php method=post name=infoForm>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden value='Main' name=action>";
	echo "<input type=hidden value='' name=search>";
	echo "<input type=hidden value='true' name=ByID>";
	echo "<input type=hidden value='' name=listMethod>";
	echo "<input type=hidden value='' name=searchPlayer>";
	echo "<input type=hidden value='' name=searchArea>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"JavaScript\">";
	layerScript();
	echo "function getPlayerInfo(player){";
	echo "	document.infoForm.action.value='searchPlayer';";
	echo "	document.infoForm.searchPlayer.value=player;";
	echo "	document.infoForm.submit();";
	echo "}function getPlayerListByOrg(org){";
	echo "	document.infoForm.action.value='listPlayers';";
	echo "	document.infoForm.listMethod.value='ByOrg';";
	echo "	document.infoForm.search.value=org;";
	echo "	document.infoForm.submit();";
	echo "}function listOrg(){";
	echo "	document.infoForm.action.value='listOrg';";
	echo "}function getAreaInfo(area){";
	echo "	document.infoForm.action.value='areaInfo';";
	echo "	document.infoForm.searchArea.value=area;";
	echo "	document.infoForm.submit();";
	echo "}</script>";

	echo "<table width=100% height=100%><tr><td align=center>";

	echo "<table cellspacing=2 cellpadding=3 border=1 width=700 style=\"border-collapse: collapse; border: 1px solid white\">";
	echo "<tr><td align=center colspan=2><b style=\"color: ".$Info['color']."\"> ".$Info['name']." </b></td></tr>";

	echo "<tr>";
	echo "<td width=280 valign=top>";
	echo "組織主席: <span style=\"cursor: pointer;\" onClick=\"getPlayerInfo('$Info[leader_id]');\" $hoverPhrase>$Info[leader]</span><br>";
	echo "代理主席: <span style=\"cursor: pointer;\" onClick=\"". (($Info['vice'] != $noViceName) ? "getPlayerInfo('$Info[vice_id]');" : '')."\" $hoverPhrase>$Info[vice]</span><br>";
	echo "成員人數: $Info[members] 個 <span style=\"cursor: pointer;\" onClick=\"getPlayerListByOrg('".$Info['id']."')\" $hoverPhrase>(查詢)</span><br>";
	echo "組織資金: ".number_format($Info['funds'])."<br>";
	echo "領地數量: ".(($Info['occupiedNum'] > 0) ? $Info['occupiedNum'] : 0)." 個<br>";
	echo "全國軍力: ".(($Info['tickets'] > 0) ? number_format($Info['tickets']) : 0)." 點<br>";
	switch($Info['license']){
		case 0: $licenseDisplay = '自由加入, 自由退出'; break;
		case 1: $licenseDisplay = '自由加入, 限制退出'; break;
		case 2: $licenseDisplay = '限制加入, 自由退出'; break;
		case 3: $licenseDisplay = '限制加入, 限制退出'; break;
	}
	echo "人事方針: $licenseDisplay <br>";
	if($orgCmd) echo "<input type=button value='加入此組織' onClick=\"document.orgForm.submit();\" $textboxStyle>";
	echo "</td>";
	echo "<td width=420 height=312 style=\"background: url($General_Image_Dir/background/map_bg_s.png);\">";

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

	// Draw Map
	echo "<table align=center border=0 cellpadding=0 cellspacing=0 class='AlphaChan' width=420 height=312 id=\"mapTable\">";
		foreach($Tbl_i as $i_r){
			echo "<tr>";
			foreach($i_r as $i_c => $a_id){
				echo "<span id=MapDiscription_".$a_id." style=\"visibility: hidden; position: absolute;\">";
				echo "$a_id (".ReturnMType($A_Inf[$a_id]['Sys']['type']).")<br>".$A_Inf[$a_id]['User']['aname']."<br>&nbsp;&nbsp;&nbsp;軍力: ".$A_Inf[$a_id]['User']['tickets'];
				echo "<br>&nbsp;&nbsp;&nbsp;所屬國: ".$O_Inf[$a_id]['name'];
				echo "<br>&nbsp;&nbsp;&nbsp;區域人數: ".$PlayerCount[$a_id];
				echo "</span>";
				
				echo '<td align=center width=70 height=52 style="cursor: pointer; ';
				if($A_Inf[$a_id]['User']['occupied'] == $Info['id']) echo "background: ".$Info['color'].';"';
				else echo '"'; 
				echo ' onClick="getAreaInfo(\''.$a_id.'\');"';
				echo ' OnMouseOver="setLayer(event.clientX,event.clientY,150,80,\'document.getElementById(\\\'MapDiscription_'.$a_id.'\\\').innerHTML\');"';
				echo ' OnMouseOut="offLayer();">';
				if($A_Inf[$a_id]['User']['occupied'] == $Info['id']) echo "<span style='background: black; width: 30'>$a_id</span>";
				else echo ''; 
				echo '</td>';
			}
			echo "</tr>";
		}
	echo "</table>";

	echo "</td>";
	echo "</tr>";


	echo "</table>";
	echo "<br><input type=submit value='回到組織例表' onClick=\"listOrg();\" $textboxStyle><input type=submit value='返回情報首頁' onClick=\"infoForm.action.value='Main'\" $textboxStyle>";

	echo "</td></tr></table>";
	echo "</form>";

	// Map Information Div
	echo "<div id=mapinfo style=\"position:absolute; z-index:3;color: black;\" align=left></div>";


}
elseif ($mode == 'listOrg'){

	$sql = "SELECT `id`, `name` FROM `".$GLOBALS['DBPrefix']."phpeb_user_organization` ORDER BY `name` ASC";
	$query = mysql_query($sql);

	$Organizations = array();

	for($i = 1; $temp = mysql_fetch_array($query); $i++) {
		if($temp['id'] == '0') {
			$Organizations[0] = $temp;
			$i--;
		}
		else $Organizations[$i] = $temp;
		unset($temp);
	}

	echo "<form action=information.php method=post name=infoForm>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=action value='searchOrg'>";
	echo "<input type=hidden name=searchOrg value=''>";
	echo "<input type=hidden name=ByID value='true'>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"JavaScript\">";
	echo "function getInfo(org){";
	echo "	infoForm.searchOrg.value=org;";
	echo "	infoForm.submit();";
	echo "	}</script>";
	echo "<table width=100% height=100% border=0><tr><td align=center valign=center>";
	echo "<table width=680 cellspacing=2 cellpadding=3 style=\"font-size:11px; border: 1px solid white; border-collapse: collapse;\">";
	echo "<tr><td colspan=4 style=\"border: 1px solid white;\" align=center><b>組織列表</b></td></tr>";

	$i = count($Organizations);
	$name = '';
	$format = '<span style="text-decoration: underline; cursor: pointer" onClick="getInfo(\'%s\');" '.
			'onMouseOver="this.style.color=\'yellow\'" onMouseOut="this.style.color=\'white\'">%s</span>';
	$formatTd = '<td width=20 align=right>%d:</td><td width=300>%s</td>';
	for($j = 0; $j+1 < $i; $j+=2){
		echo "<tr>";
		$name = sprintf($format, $Organizations[$j]['id'], $Organizations[$j]['name']);
		printf($formatTd, $j+1, $name);
		$name = sprintf($format, $Organizations[$j+1]['id'], $Organizations[$j+1]['name']);
		printf($formatTd, $j+2, $name);
		echo "</tr>";
	}
	if( $i % 2 == 1 ){
		echo "<tr>";
		$name = sprintf($format, $Organizations[$j]['id'], $Organizations[$j]['name']);
		printf($formatTd, $j+1, $name);
		echo "<td>&nbsp;</td><td>&nbsp;</td></tr>";
	}

	echo "</table>";
	echo "<br><input type=submit value='返回' onClick=\"infoForm.action.value='Main'\" $textboxStyle>";
	echo "</td></tr></table>";
	echo "</form>";



}
else if($mode == 'areaInfo'){

	$restriction = array("|","`","'","--","\"","\\");
	$searchArea = str_replace($restriction,'',$searchArea);
	$searchArea = preg_replace("/<[^<>]*>/",'',$searchArea);

	$sql = "SELECT COUNT(*) AS `count` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `map_id` = '".$searchArea."';";
	$query = mysql_query($sql);
	$results = mysql_fetch_array($query);

	// Problem
	if( $results['count'] != 1 ) {
		echo "找不到目標區域";
		exit();
	}

	$sql = "SELECT
	u.map_id AS `id`, `aname`, `area`, `movement`, `occprice`, s.hpmax AS `s_hpmax`, s.at AS `s_at`, s.de AS `s_de`, s.ta AS `s_ta`, s.wepa AS `s_wepa`,
	`name` AS `org_name`, o.id AS `org_id`, `color`, `hp`, u.hpmax AS `hpmax`, u.at AS `at`, u.de AS `de`, u.ta AS `ta`, u.wepa AS `wepa`, `defenders`, `tickets`
	FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` `u`, `".$GLOBALS['DBPrefix']."phpeb_sys_map` `s`, `".$GLOBALS['DBPrefix']."phpeb_user_organization` `o`
	WHERE s.map_id = '".$searchArea."' AND s.map_id = u.map_id AND `occupied` = o.id LIMIT 1;";

	$query = mysql_query($sql);
	$Info = mysql_fetch_array($query);

	$sql = ("SELECT COUNT( `coordinates` ) AS `count` FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` WHERE `coordinates` = '".$searchArea."';");
	$query = mysql_query($sql);
	$temp = mysql_fetch_array($query);
	$Info['count'] = $temp['count'];

	$temp = array('s_wepa', 'wepa');
	
	foreach($temp as $v){
		$W_Params = explode('<!>',$Info[$v]);

		$sql = ("SELECT `name` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE id='". $W_Params[0] ."'");
		$query = mysql_query($sql);
		$Info['weapon'][$v] = mysql_fetch_array($query);
	
		$W_Params[2] = ( isset($W_Params[2]) ) ? $W_Params[2] : 0;
	
		if ($W_Params[2]){
			if ($W_Params[2] == 1) $Info['weapon'][$v]['name'] = $W_Params[3].$Info['weapon'][$v]['name']."<sub>&copy;</sub>";
			else $Info['weapon'][$v]['name'] = $Info['weapon'][$v]['name'].$W_Params[3]."<sub>&copy;</sub>";
		}
	}

	$Info['defender_count'] = 0;
	if($Info['defenders']){
		$Defender = array_unique(explode(',',$Info['defenders']));
		$Info['defender_count'] = count($Defender);
	}


	echo "<form action=information.php method=post name=infoForm>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden value='Main' name=action>";
	echo "<input type=hidden name=searchOrg value=''>";
	echo "<input type=hidden name=ByID value='true'>";
	echo "<input type=hidden name=search value=''>";
	echo "<input type=hidden name=listMethod value=''>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<script language=\"JavaScript\">";
	echo "function getOrgInfo(org){";
	echo "	document.infoForm.action.value='searchOrg';";
	echo "	document.infoForm.searchOrg.value=org;";
	echo "	document.infoForm.submit();";
	echo "}function getPlayerListByArea(area){";
	echo "	document.infoForm.action.value='listPlayers';";
	echo "	document.infoForm.listMethod.value='ByArea';";
	echo "	document.infoForm.search.value=area;";
	echo "	document.infoForm.submit();";
	echo "}function getPlayerListByDefenders(){";
	echo "	document.infoForm.action.value='listPlayers';";
	echo "	document.infoForm.listMethod.value='ByList';";
	echo "	document.infoForm.search.value='".$Info['defenders']."';";
	echo "	document.infoForm.submit();";
	echo "}</script>";

	echo "<table width=100% height=100%><tr><td align=center>";

	// Start

	echo "<table cellspacing=2 cellpadding=3 border=1 width=700 style=\"border-collapse: collapse; border: 1px solid white\">";
	echo "<tr><td align=center colspan=2><b style=\"color: ".$Info['color']."\"> ".$Info['aname']." </b> (".$Info['id'].")</td></tr>";

	echo "<tr>";
	echo "<td width=350 valign=top>";
	echo "區域人數: $Info[count] 個 <span style=\"cursor: pointer;\" onClick=\"getPlayerListByArea('".$Info['id']."')\" $hoverPhrase>(查詢)</span><br>";
	echo "所屬區域: $Info[area]<br>";
	echo "連接區域: ".str_replace("\n", ', ', $Info['movement'])."<br>";
	echo "佔領費用: ".number_format($Info['occprice'])."<br>";
	echo "起始能力: <br>";
	echo "&nbsp;&nbsp;&nbsp; HP上限: ".$Info['s_hpmax']."<br>";
	echo "&nbsp;&nbsp;&nbsp; Attacking: ".$Info['s_at']."<br>";
	echo "&nbsp;&nbsp;&nbsp; Defending: ".$Info['s_de']."<br>";
	echo "&nbsp;&nbsp;&nbsp; Targeting: ".$Info['s_ta']."<br>";
	echo "&nbsp;&nbsp;&nbsp; 武器: ".$Info['weapon']['s_wepa']['name']."<br>";
	
	echo "</td>";
	echo "<td width=350 valign=top>";
	echo "區域政權: <span style=\"color: ".$Info['color']."; cursor: pointer; text-decoration: underline\" onClick=\"getOrgInfo('".$Info['org_id']."')\">".$Info['org_name']."</span><br>";
	echo "守衛人數: $Info[defender_count] <span style=\"cursor: pointer;\" onClick=\"".( ($Info['defender_count'] > 0) ? 'getPlayerListByDefenders();' : '')."\" $hoverPhrase>(查詢)</span><br>";
	echo "本區軍力: $Info[tickets]<br>";
	echo "要塞狀態: <br>";
	echo "&nbsp;&nbsp;&nbsp; HP: ".$Info['hp']."/".$Info['hpmax']."<br>";
	echo "&nbsp;&nbsp;&nbsp; Attacking: ".$Info['at']."<br>";
	echo "&nbsp;&nbsp;&nbsp; Defending: ".$Info['de']."<br>";
	echo "&nbsp;&nbsp;&nbsp; Targeting: ".$Info['ta']."<br>";
	echo "&nbsp;&nbsp;&nbsp; 武器: ".$Info['weapon']['wepa']['name']."<br>";
	echo "</td>";
	echo "</tr>";
	
	// Mining Plugin
	include_once('plugins/mining/mining.config.php');

	$sql = "SELECT `mining_pid`, `rate` FROM `".$GLOBALS['DBPrefix']."phpeb_mining_mitem` " .
		"WHERE `mining_area` = '".$searchArea."' ORDER BY `mining_pid` ASC;";
	$query = mysql_query($sql);

	$Abundancy = array(0,0,0,0,0,0,0,0,0);
	while($temp = mysql_fetch_array($query)){
		$Abundancy[$temp['mining_pid']] = $temp['rate']/100;
	}

	echo "<tr><td colspan=2 align=center><b>原料出產:</b>: &nbsp;";
	$pFormatStr = '%s: %s%% &nbsp; &nbsp;';
	for($i = 1; $i <= 8; $i++){
		printf($pFormatStr, $product_id_list[$i], $Abundancy[$i]);
	}
	echo "</td></tr>";
	
	


	echo "</table>";

	// End

	echo "<br><input type=submit value='返回' onClick=\"infoForm.action.value='Main'\" $textboxStyle>";

	echo "</td></tr></table>";
	echo "</form>";
}
elseif($mode = 'History'){
	echo "<form action=information.php method=post name=infoForm>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden value='Main' name=action>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	echo "<table width=100% height=100% border=0><tr><td align=center valign=center>";

	// Start
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"70%\">";
	echo "<tr><td align=center style=\"font-size:16px;\"><b>完整歷史列表<b></tr></td>";

	$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_game_history` ORDER BY `time` DESC");
	$query = mysql_query($sql);
	$HistoryEntries = mysql_num_rows($query);

	for($CountHist=1;$CountHist <= $HistoryEntries;$CountHist++){
	$History = mysql_fetch_array($query);
	$History['DateTime'] = cfu_time_convert($History['time']);
	echo "<tr><td align=left style=\"font-size:10px;\"><b style=\"font-size:12px;\">$History[DateTime]</b><br>";
	echo "$History[history]";
	echo "</tr></td>";
	}

	echo "</table>";
	//End

	echo "<br><input type=submit value='返回' $textboxStyle>";
	echo "</td></tr></table>";
	echo "</form>";
}
else {
	echo "未定義動作！";
}
postFooter();
echo "</body>";
echo "</html>";
exit;
?>