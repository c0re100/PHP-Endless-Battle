<?php
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
include('cfu.php');
if (empty($PriTarget)) $PriTarget = 'Alpha';
if (empty($SecTarget)) $SecTarget = 'Beta';
postHead('');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
if ($CFU_Time >= $TIMEAUTH+$TIME_OUT_TIME || $TIMEAUTH <= $CFU_Time-$TIME_OUT_TIME){echo "連線逾時！<br>請重新登入！";exit;}

include('includes/sfo.class.php');

$Pl = new player_stats;
$Pl->SetUser($Pl_Value['USERNAME']);
$Pl->FetchPlayer();

$t_now = time();
if ($t_now - $Pl->Player['btltime'] <= 1){
	echo "動作過快。";
	postFooter();
	mysql_query("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `btltime` = ".intval($t_now+10)." WHERE `username` = '".$Pl->Player['name']."' LIMIT 1;");
	exit;
}

if($Pl->Player['organization'] != 0){
	$sql = "SELECT `occupied`, `tickets` FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE map_id = '".$Pl->Player['coordinates']."';";
	$query = mysql_query($sql);
	$localArea = mysql_fetch_row($query);

	$sql = "SELECT SUM(`tickets`), COUNT(`map_id`) FROM `".$GLOBALS['DBPrefix']."phpeb_user_map` WHERE `occupied` = '".$Pl->Player['organization']."';";
	$query = mysql_query($sql);
	$globalArea = mysql_fetch_row($query);

	$localTickets = ( $localArea[0] == $Pl->Player['organization'] ) ? $localArea[1] : 0;
	$globalTickets = ( ($globalArea[0]) > 0 ) ? $globalArea[0] : 0;
	$occupiedAreas = ( ($globalArea[1]) > 0 ) ? $globalArea[1] : 0;
}
else $localTickets=$globalTickets=$occupiedAreas=0;

$tickImg = $Base_Image_Dir. '/tickImgB.gif';
$crossImg = $Base_Image_Dir. '/crossImgB.gif';

if ($mode=='main'){

	echo "特殊機體生產工場".sprintTHR('75%');

	echo "<form action=buysetms.php?action=main method=post name=setmain>";
	echo "<input type=hidden value='' name=actionb>";
	echo "<input type=hidden value='' name=actionc>";
	echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
	echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
	echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

	
	$sql = "
	SELECT 
	
	`sp_id`, `area_req`, `local_ticket`, `global_ticket`, `ticket_cost`, `cost`,
	`s_hpmax`, `s_enmax`, `s_ms_custom`, `s_wepa`, `s_wepb`, `s_wepc`, `s_eqwep`, `s_p_equip`,
	`msname`, `atf`, `def`, `ref`, `taf`, `hprec`, `enrec`, `needlv`, `image`
	
	FROM 
	`".$GLOBALS['DBPrefix']."phpeb_sys_ms` `ms`, 
	`".$GLOBALS['DBPrefix']."phpeb_sys_ms_setinf` `inf`, 
	`".$GLOBALS['DBPrefix']."phpeb_sys_ms_setpreq` `preq`
	
	WHERE
	`inf_id` = `s_id` AND `s_msuit` = `id`
	
	ORDER BY `needlv` DESC, `msname`, `cost` DESC, `s_id`;
	";

	$query = mysql_query($sql) or die("發生錯誤: 代號 SETMS-000");
	
	$selection_options = "";
	$ms_js = "j_sp_id = new Array();
j_area_req = new Array();
j_local_ticket = new Array();
j_global_ticket = new Array();
j_ticket_cost = new Array();
j_cost = new Array();
j_s_hpmax = new Array();
j_s_enmax = new Array();
j_s_ms_custom = new Array();
j_s_wepa = new Array();
j_s_wepb = new Array();
j_s_wepc = new Array();
j_s_eqwep = new Array();
j_s_p_equip = new Array();
j_msname = new Array();
j_atf = new Array();
j_def = new Array();
j_ref = new Array();
j_taf = new Array();
j_atfc = new Array();
j_defc = new Array();
j_refc = new Array();
j_tafc = new Array();
j_hprec = new Array();
j_enrec = new Array();
j_needlv = new Array();
j_image = new Array();";
	$i = 0;

	while($setMS = mysql_fetch_array($query)){
	
		if ($setMS['s_ms_custom']){
			$MS_CFix = split('<!>',$setMS['h_ms_custom']);
			$setMS['msname'] = $MS_CFix[0];
			$setMS['atf'] += $MS_CFix[1];
			$setMS['def'] += $MS_CFix[2];
			$setMS['ref'] += $MS_CFix[3];
			$setMS['taf'] += $MS_CFix[4];
		}
		else $MS_CFix = array('',0,0,0,0);
		
		$selection_options .= "<option value=".$setMS['sp_id'].">".$setMS['msname'];
		
		$temp = array('sp_id', 'area_req', 'local_ticket', 'global_ticket', 'ticket_cost', 'cost', 's_hpmax', 's_enmax', 'atf', 'def', 'ref', 'taf', 'hprec', 'enrec', 'needlv');
		
		foreach($temp as $v) $ms_js .= "j_".$v."[".$i."] = " . $setMS[$v] .";";
		
		$ms_js .= "j_msname[".$i."] = '".$setMS['msname']."';";
		$ms_js .= "j_image[".$i."] = '".$Unit_Image_Dir."/".$setMS['image']."';";
		$ms_js .= "j_atfc[".$i."] = ".$MS_CFix[1].";";
		$ms_js .= "j_defc[".$i."] = ".$MS_CFix[2].";";
		$ms_js .= "j_refc[".$i."] = ".$MS_CFix[3].";";
		$ms_js .= "j_tafc[".$i."] = ".$MS_CFix[4].";";
		
		$Eq_Listing = Array('A' => 's_wepa','B' => 's_wepb','C' => 's_wepc','D' => 's_eqwep','E' => 's_p_equip');
		foreach($Eq_Listing as $I => $V){
			$S_Wep = 'S_Wep'.$I;
			$S_SyWep = 'S_SyWep'.$I;
			$W_Inf = 'W_Inf'.$I;
			if ($setMS[$V] && $setMS[$V] != '0<!>0') {
				$$S_Wep = split('<!>',$setMS[$V]);
				GetWeaponDetails(${$S_Wep}[0],$S_SyWep);
					${$S_Wep}[2] = (isset(${$S_Wep}[2])) ? ${$S_Wep}[2] : 0;
				if (${$S_Wep}[2]){
					if (${$S_Wep}[2]==1) ${$S_SyWep}['name'] = ${$S_Wep}[3].${$S_SyWep}['name']."<sub>&copy;</sub>";
					else ${$S_SyWep}['name'] = ${$S_SyWep}['name'].${$S_Wep}[3]."<sub>&copy;</sub>";
					${$S_SyWep}['atk'] += ${$S_Wep}[4];
					${$S_SyWep}['hit'] += ${$S_Wep}[5];
					${$S_SyWep}['rd'] += ${$S_Wep}[6];
					${$S_SyWep}['enc'] = ${$S_Wep}[7];
				}
				if (${$S_Wep}[1] > 0) ${$S_Wep}['displayXp'] = '+'.(${$S_Wep}[1]/100).'%';
				elseif (${$S_Wep}[1] < 0) ${$S_Wep}['displayXp'] = (${$S_Wep}[1]/100).'%';
				else ${$S_Wep}['displayXp'] = '±0%';
				$$W_Inf = ${$S_SyWep}['name']."<br>狀態值: ".${$S_Wep}['displayXp']."<hr width=95%>能力:<br>";
				$$W_Inf .= "　攻擊力: ".${$S_SyWep}['atk']."　　　回數: ".${$S_SyWep}['rd']."<br>　命中: ".${$S_SyWep}['hit']."　　　EN消費: ".${$S_SyWep}['enc']."<br>";
				$$W_Inf .= "距離/屬性: ".getRangeAttrb(${$S_SyWep}['range'],${$S_SyWep}['attrb'],${$S_SyWep}['equip'],false)."<br>";
				$$W_Inf .= "特殊效果:<br>";
				if (${$S_SyWep}['equip']) $$W_Inf .= "可以裝備<br>";
				if (${$S_SyWep}['spec']) $$W_Inf .= ReturnSpecs(${$S_SyWep}['spec']);
				$ms_js .= "j_".$V."[".$i."] = '".$$W_Inf."';";
			}
			else $ms_js .= "j_".$V."[".$i."] = '';";
		}
		
		$i++;
	}


	echo "<script language=\"Javascript\">
	$ms_js
	tmpTxt = new Array();
	function returnElm(str){
		return document.getElementById(str);
	}
	function processTable(index){
		returnElm('tr_1').style.visibility = 'visible';
		returnElm('tr_2').style.visibility = 'visible';
		returnElm('tr_3').style.visibility = 'visible';
		returnElm('tr_4').style.visibility = 'visible';
		returnElm('sp_id').innerHTML = j_sp_id[index];
		returnElm('msname').innerHTML = j_msname[index];
		returnElm('needlv').innerHTML = j_needlv[index];
		returnElm('cost').innerHTML = numberFormat(j_cost[index]);
		returnElm('ticket_cost').innerHTML = numberFormat(j_ticket_cost[index]);
		returnElm('area_req').innerHTML = j_area_req[index];
		returnElm('local_ticket').innerHTML = numberFormat(j_local_ticket[index]);
		returnElm('global_ticket').innerHTML = numberFormat(j_global_ticket[index]);
		returnElm('atf').innerHTML = j_atf[index];
		returnElm('def').innerHTML = j_def[index];
		returnElm('ref').innerHTML = j_ref[index];
		returnElm('taf').innerHTML = j_taf[index];
		returnElm('atfc').innerHTML = j_atfc[index];
		returnElm('defc').innerHTML = j_defc[index];
		returnElm('refc').innerHTML = j_refc[index];
		returnElm('tafc').innerHTML = j_tafc[index];
		returnElm('s_hpmax').innerHTML = numberFormat(j_s_hpmax[index]);
		returnElm('s_enmax').innerHTML = numberFormat(j_s_enmax[index]);
		if(j_hprec[index] > 1) returnElm('hprec').innerHTML = j_hprec[index];
		else returnElm('hprec').innerHTML = '' + (Math.round(j_hprec[index]*1000)/10) + '%';
		if(j_enrec[index] > 1) returnElm('enrec').innerHTML = j_enrec[index];
		else returnElm('enrec').innerHTML = '' + (Math.round(j_enrec[index]*1000)/10) + '%';
		returnElm('msImage').src = j_image[index];

		tmpTxt[0] = j_s_wepa[index];
		tmpTxt[1] = j_s_wepb[index];
		tmpTxt[2] = j_s_wepc[index];
		tmpTxt[3] = j_s_eqwep[index];
		tmpTxt[4] = j_s_p_equip[index];
			
		if(!j_s_wepa[index]) returnElm('wepa').src = '$crossImg';
		else returnElm('wepa').src = '$tickImg';
		if(!j_s_wepb[index]) returnElm('wepb').src = '$crossImg';
		else returnElm('wepb').src = '$tickImg';
		if(!j_s_wepc[index]) returnElm('wepc').src = '$crossImg';
		else returnElm('wepc').src = '$tickImg';
		if(!j_s_eqwep[index]) returnElm('eqwep').src = '$crossImg';
		else returnElm('eqwep').src = '$tickImg';
		if(!j_s_p_equip[index]) returnElm('p_equip').src = '$crossImg';
		else returnElm('p_equip').src = '$tickImg';
	}

	function numberFormat(num){
		var numF = '';
		var pNum = new String( num );
		num = pNum;
		var l = num.length;
		var tx = Math.floor(l/3);
		var rx = (l%3);
		if (rx == 1){numF = num.substr(0,1);pNum = num.substr(1);}
		else if (rx == 2){numF = num.substr(0,2);pNum = num.substr(2);}
		else {numF = num.substr(0,3);pNum = num.substr(3);}
		while(pNum.length >= 3){
		numF = numF+','+pNum.substr(0,3);
		pNum = pNum.substr(3);
		}
		return numF;
	}

	function setLayer(posX,posY,Width,Height,slot){
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
		
		if(tmpTxt[slot]){
			document.getElementById(\"wepinfo\").innerHTML = tmpTxt[slot];
			document.getElementById(\"wepinfo\").style.width = Width;
			document.getElementById(\"wepinfo\").style.height = 'auto';
			document.getElementById(\"wepinfo\").style.backgroundColor = \"ffffdd\";
			document.getElementById(\"wepinfo\").style.padding = 10;
			document.getElementById(\"wepinfo\").style.border = \"solid 1px #000000\";
			document.getElementById(\"wepinfo\").style.left = X;
			document.getElementById(\"wepinfo\").style.top  = Y;
		}
	}
	
	function offLayer(){
		document.getElementById(\"wepinfo\").innerHTML = '';
		document.getElementById(\"wepinfo\").style.width = 0;
		document.getElementById(\"wepinfo\").style.height = 0;
		document.getElementById(\"wepinfo\").style.backgroundColor = \"transparent\";
		document.getElementById(\"wepinfo\").style.border = 0;
	}

	function confirmBuy(){
		var i = document.setmain.set_ms.selectedIndex;
		if(j_cost[i] > ".$Pl->Player['cash']."){alert('現金不足！'); return false;}
		else if(j_area_req[i] > ".$occupiedAreas."){alert('國家領地數目不足！'); return false;}
		else if(j_local_ticket[i] > ".$localTickets." || j_ticket_cost > ".($localTickets-1)."){alert('本地軍力不足！'); return false;}
		else if(j_global_ticket[i] > ".$globalTickets."){alert('全國軍力不足！'); return false;}
		else if(j_local_ticket[i] > 0 && !".$Pl->Player['rights']."){alert('沒有使用軍力的權限。'); return false;}
		else if(confirm('確定購買嗎？') == true){
			document.setmain.action = 'buysetms.php?action=process';
			document.setmain.actionb.value = 'buy';
			document.setmain.actionc.value = j_sp_id[i];
			return true;
		}
		else return false;
	}

	</script>";

	echo "<table align=center border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" width=\"750\">";
	echo "<tr align=center><td colspan=5><b>套裝機體一覽: </b></td></tr>";
	echo "<tr align=center><td colspan=5>";
	echo "<select name=set_ms onChange=\"processTable(this.selectedIndex);\">";
	echo $selection_options;
	echo "</select>";
	echo "</td></tr>";
	
	echo "<tr style=\"visibility: hidden;\" id=tr_1>";
	echo "<td width=450 rowspan=4 valign=top>";
	
		echo "&nbsp;&nbsp;<span id=sp_id>1</span>: <span id=msname style=\"color: ForestGreen; font-weight: Bold; font-size: 12pt;\"></span><br>";
		echo "<b>個人需求</b>:";
		echo "<table border=0 width=300 align=center>";
		echo "<tr>";
		echo "<td width=100>等級: <span id=needlv>0</span></td>";
		echo "<td width=200>價錢: <span id=cost>0</span></td>";
		echo "</tr>";
		echo "<tr><td width=300 colspan=2>消耗軍力: <span id=ticket_cost>0</span></td></tr>";
		echo "</table><Br>";

		echo "<b>組織需求</b>:";
		echo "<table border=0 width=300 align=center>";
		echo "<tr><td width=75 align=right>控制區域數目:</td><td align=left><span id=area_req>0</span></td></tr>";
		echo "<tr><td width=75 align=right>本地軍力:</td><td align=left><span id=local_ticket>0</span></td></tr>";
		echo "<tr><td width=75 align=right>全國軍力:</td><td align=left><span id=global_ticket>0</span></td></tr>";
		echo "</table><Br>";

		echo "<b>機體武裝</b>:";
		echo "<table border=0 width=400 align=center>";
		echo "<tr align=center>";
		echo "<td width=80 onMouseOver=''>武器</td>";
		echo "<td width=80>備用一</td>";
		echo "<td width=80>備用二</td>";
		echo "<td width=80>輔助裝備</td>";
		echo "<td width=80>常規裝備</td>";
		echo "</tr>";
		echo "<tr align=center>";
		echo "<td width=80 OnMouseOver=\"setLayer(event.clientX,event.clientY,200,100,0)\" OnMouseOut=\"offLayer()\"><img src='$tickImg' id=wepa></td>";
		echo "<td width=80 OnMouseOver=\"setLayer(event.clientX,event.clientY,200,100,1)\" OnMouseOut=\"offLayer()\" ><img src='$tickImg' id=wepb></td>";
		echo "<td width=80 OnMouseOver=\"setLayer(event.clientX,event.clientY,200,100,2)\" OnMouseOut=\"offLayer()\" ><img src='$tickImg' id=wepc></td>";
		echo "<td width=80 OnMouseOver=\"setLayer(event.clientX,event.clientY,200,100,3)\" OnMouseOut=\"offLayer()\" ><img src='$tickImg' id=eqwep></td>";
		echo "<td width=80 OnMouseOver=\"setLayer(event.clientX,event.clientY,200,100,4)\" OnMouseOut=\"offLayer()\" ><img src='$tickImg' id=p_equip></td>";
		echo "</tr>";
		echo "</table><Br>";
	
	echo "</td>";

	echo "<td width=300 height=200 colspan=4 align=center><img id=msImage src=\"\"></td>";

	echo "</tr>";
	
	echo "<tr style=\"visibility: hidden;\" id=tr_2>";
	echo "<td width=75>Att:<br><span id=atf></span>(+<span id=atfc></span>)</td>";
	echo "<td width=75>Def:<br><span id=def></span>(+<span id=defc></span>)</td>";
	echo "<td width=75>Mob:<br><span id=ref></span>(+<span id=refc></span>)</td>";
	echo "<td width=75>Tar:<br><span id=taf></span>(+<span id=tafc></span>)</td>";
	echo "</tr>";

	echo "<tr style=\"visibility: hidden;\" id=tr_3>";
	echo "<td width=150 colspan=2>HP: <span id=s_hpmax></span></td>";
	echo "<td width=150 colspan=2>EN: <span id=s_enmax></span></td>";
	echo "</tr>";

	echo "<tr style=\"visibility: hidden;\" id=tr_4>";
	echo "<td width=150 colspan=2>回復率: <span id=hprec></span></td>";
	echo "<td width=150 colspan=2>回復率: <span id=enrec></span></td>";
	echo "</tr>";

	echo "<tr><td>&nbsp;</td>";
	echo "<td colspan=4 align=right>".printTHR('75%');
	echo "已方組織控制領地數目: $occupiedAreas <Br>已方組織本地軍力: ".number_format($localTickets) . "<br> 已方組織全國軍力: ".number_format($globalTickets);
	echo "<Br><input type=submit value=購買 onClick=\"return confirmBuy();\">";
	echo "</td></tr>";
	
	echo "</table></form>";
echo "<div id=wepinfo style=\"position:absolute; z-index:10;color: black;\" align=left></div>";
echo "<script language=\"Javascript\">setTimeout(\"processTable(document.setmain.set_ms.selectedIndex);\",500);</script>";

}

elseif($mode=='process' && $actionb == 'buy'){
	$Error = false;
	$actionc = intval($actionc);
	if($actionc < 0) $Error = true;
	
	$sql = "SELECT 
	`area_req`, `local_ticket`, `global_ticket`, `ticket_cost`, `cost`,
	`s_msuit`, `s_hpmax`, `s_enmax`, `s_ms_custom`, `s_wepa`, `s_wepb`, `s_wepc`, `s_eqwep`, `s_p_equip`
	FROM 
	`".$GLOBALS['DBPrefix']."phpeb_sys_ms_setinf` `inf`, 
	`".$GLOBALS['DBPrefix']."phpeb_sys_ms_setpreq` `preq`
	WHERE
	`inf_id` = `s_id` AND `sp_id` = ".$actionc."
	LIMIT 1;";

	$query = mysql_query($sql) or die("發生錯誤: 代號 SETMS-001");
	$choices = mysql_num_rows($query);
	if($choices <= 0) $Error = true;
	
	$setMS = mysql_fetch_array($query);
	
	if($setMS['cost'] > $Pl->Player['cash']) $Error = true;
	elseif($setMS['area_req'] > $occupiedAreas) $Error = true;
	elseif($setMS['local_ticket'] > $localTickets || $setMS['ticket_cost'] > $setMS['local_ticket']-1) $Error = true;
	elseif($setMS['global_ticket'] > $globalTickets) $Error = true;
	elseif($setMS['local_ticket'] > 0 && !$Pl->Player['rights']) $Error = true;
	
	if($Error) echo "出錯！";
	else{

		$sql = "SELECT COUNT(`h_id`) As counter FROM `".$GLOBALS['DBPrefix']."phpeb_user_hangar` WHERE `h_user` = '$Pl_Value[USERNAME]';";
		$query = mysql_query($sql);
		$counter = mysql_fetch_row($query);
		
		if ($counter[0] >= $Hangar_Limit) {echo '格納庫空間不足！<Br>已經使用了$counter[0]/$Hangar_Limit個空間。';postFooter();exit;}

		$sql = ("INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_user_hangar` VALUES('','$Pl_Value[USERNAME]','$setMS[s_msuit]','$setMS[s_hpmax]','$setMS[s_hpmax]','$setMS[s_enmax]','$setMS[s_enmax]','$setMS[s_ms_custom]','$setMS[s_wepa]','$setMS[s_wepb]','$setMS[s_wepc]','$setMS[s_eqwep]','$setMS[s_p_equip]');");
		mysql_query($sql) or die(mysql_error());
		
		$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_general_info` SET `cash` = `cash`-".$setMS['cost']." WHERE `username` = '$Pl_Value[USERNAME]' LIMIT 1;");
		mysql_query($sql) or die(mysql_error());
		
		if($setMS['ticket_cost'] > 0){
			$sql = ("UPDATE `".$GLOBALS['DBPrefix']."phpeb_user_map` SET `tickets` = `tickets`-".$setMS['ticket_cost']." WHERE `map_id` = '".$Pl->Player['coordinates']."' LIMIT 1;");
			mysql_query($sql) or die(mysql_error());
		}
		
		if($Game_Scrn_Type == 0){
			echo "<script language=\"Javascript\">parent.document.getElementById('pl_cash').innerHTML = '".number_format($Pl->Player['cash']-$setMS['cost'])."';</script>";
		}

		echo "<form action=gmscrn_main.php?action=proc method=post name=frmreturn target=$SecTarget>";
		echo "<p align=center style=\"font-size: 16pt\">已成功購入機體！<br><input type=submit value=\"重新整理\" onClick=\"frmreturn.target=$PriTarget\"></p>";
		echo "<center><input type=submit value=\"回到工場\" onClick=\"frmreturn.action='buysetms.php?action=main';\"><input type=submit value=\"進入格納庫\" onClick=\"frmreturn.action='hangar.php?action=main';\"></center>";
		echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
		echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
		echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
		echo "</form>";

	}
	
}

else {echo "未定義動作！";}
postFooter();exit;

?>