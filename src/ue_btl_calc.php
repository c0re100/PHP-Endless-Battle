<?php
//-------------------------//-------------------------//-------------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//
//----------------  php-eb UE Battle Result Calculator/Simulator ----------------//
//-------------------                v3.0Alpha               --------------------//
//-------------------------//-------------------------//-------------------------//

$IncludeSCFI = false;
$IncludeLFFI = false;
$IncludeCVFI = false;

include('cfu.php');

//Select Type Character
$SQL = ("SELECT `id`, `name`, `typelv`, `atf`, `def`, `ref`, `taf` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_chtype` ORDER BY `id`");
$Query = mysql_query($SQL);

$Type_ID = '';

while($TypeCh = mysql_fetch_array($Query))
	$Type_ID .= "\nTypeID[\"". $TypeCh['id'] ."\"][".$TypeCh["typelv"]."] =new Array(\"$TypeCh[name]\",$TypeCh[atf],$TypeCh[def],$TypeCh[ref],$TypeCh[taf]);";

//Select Weapon
$SQL = ("SELECT `id`, `name`, `atk`, `hit`, `rd`, `enc`, `spec`, `range`, `attrb` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `spec` != 'Blueprint' ORDER BY `id`");
$Query = mysql_query($SQL) or die(mysql_error());

$Wep_Selection = '';
$Wep_ID = '';

while($Weapon = mysql_fetch_array($Query)){
	$Wep_Selection .= "\n<option value='". $Weapon['id'] ."'>".$Weapon['name'];
	$Specs = ReturnSpecs($Weapon['spec']);
	$Wep_ID .= "\nWepID[\"". $Weapon['id'] ."\"] =new Array(\"$Weapon[name]\",$Weapon[atk],$Weapon[rd],$Weapon[hit],$Weapon[enc],\"$Specs\",$Weapon[range],$Weapon[attrb]);";
}

//Select MS
$SQL = ("SELECT `id`, `msname`, `atf`, `def`, `ref`, `taf`, `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` ORDER BY `price`");
$Query = mysql_query($SQL);

$MS_Selection = '';
$MS_ID = '';

while($MS = mysql_fetch_array($Query)){
	$MS_Selection .= "\n<option value='". $MS['id'] ."'>".$MS['msname'];
	$Specs = ReturnSpecs($MS['spec']);
	$MS_ID .= "\nMSID[\"". $MS['id'] ."\"] =new Array(\"$MS[msname]\",$MS[atf],$MS[def],$MS[ref],$MS[taf],\"$Specs\");";
}


//Select Tactics Information
$SQL = ("SELECT `id`, `name`, `atf`, `def`, `ref`, `taf`, `hitf`, `missf`, `spec` FROM `".$GLOBALS['DBPrefix']."phpeb_sys_tactics` ORDER BY `needlv`");
$Query = mysql_query($SQL);

$Tactics_Selection = '';
$Tactics_ID = '';

while($Tactics = mysql_fetch_array($Query)){
	$Tactics_Selection .= "\n<option value='". $Tactics['id'] ."'>".$Tactics['name'];
	$Specs = ReturnSpecs($Tactics['spec']);
	$Tactics_ID .= "\nTacticsID[\"". $Tactics['id'] ."\"] =new Array(\"$Tactics[name]\",$Tactics[atf],$Tactics[def],$Tactics[ref],$Tactics[taf],$Tactics[hitf],$Tactics[missf],\"$Specs\");";
}

?>

<html>
	<head>
		<title>PHP x JavaScript :: php-eb Ultimate Edition :: 模擬計算器 v3.0α ~ &copy; 2005-2010 v2Alliance</title>
		<meta http-equiv="Content-Type" content="text/html; charset=Big5">
		<meta http-equiv="content-language" content="zh">
	</head>
<body>


<!-- Insert Javascipt -->
<script language="JavaScript">
	var TypeID = new Array();
	TypeID["nat"] = new Array();
	TypeID["ext"] = new Array();
	TypeID["enh"] = new Array();
	TypeID["psy"] = new Array();
	TypeID["co"] = new Array();
	TypeID["nt"] = new Array();

	<?php echo $Type_ID; ?>
	
	var WepID = new Array();
	var MSID = new Array();
	var TacticsID = new Array();
	
	<?php echo $Wep_ID ."\n". $MS_ID ."\n". $Tactics_ID; ?>

</script>
<script language="JavaScript" src="includes/btl_calc.js"></script>
<script language="JavaScript">
	// Player Object: Pl
	var objPl = new player;
	// Player Object: Op
	var objOp = new player;
</script>

<table>
<tr><td>
<form name=Main>

輸入等級:<input type="text" name="Level"><br>
<input type="button" onClick="document.getElementById('StatptG').innerHTML=CalcStatPt(document.Main.Level.value);" value='計算可得的成長點數'><br>
<input type="button" onClick="document.getElementById('TStatptG').innerHTML=CalcTotalStatPtsG(document.Main.Level.value);" value='計算可得的總成長點數''><br>
<input type="button" onClick="document.getElementById('ExpR').innerHTML=numFormat(CalcExp(document.Main.Level.value));" value='計算所需經驗'><br>

輸入想計算的能力值:<input type="text" name="Status"><br>
<input type="button" onClick="document.getElementById('StatptR').innerHTML=CalcStatReq(document.Main.Status.value);" value='計算所需成長點數'><br>
<input type="button" onClick="document.getElementById('TStatptR').innerHTML=CalcTotalStatPtsR(document.Main.Status.value);" value='計算所需總成長點數'><br>
<input type="button" onClick="document.getElementById('TLevelStR').innerHTML=CalcLevelRec(document.Main.Status.value);" value='計算所需級數'><br>
<br>

</form>
</td>
<td>
<table>
	<tr>
		<td align=right>下一級可得成長點數:</td>
		<td><span id=StatptG>&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>(至本等級)總成長點數:</td>
		<td><span id=TStatptG>&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>本素質值所需成長點數:</td>
		<td><span id=StatptR>&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>(至本素質值)所需總成長點數:</td>
		<td><span id=TStatptR>&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>(至本素質值)所需級數:</td>
		<td><span id=TLevelStR>&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>下一級所需經驗:</td>
		<td><span id=ExpR>&nbsp;</span></td>
	</tr>
</table>
</td>
</tr>
</table>
<hr>
能力等級成長點數計算器:
<table align=center>
	<tr><td>

<form name=Calculator>
<table border=0>
	<tr>
		<td>Attacking:<select name="At" onChange="objPl.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
		</select> + <span id="pl_pi_atf">0</span> ( + <span id="pl_pi_xat">0</span>)</td>
		<td>Defending:<select name="De" onChange="objPl.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
		</select> + <span id="pl_pi_def">0</span> ( + <span id="pl_pi_xde">0</span>)</td>
	</tr>
	<tr>
		<td>Reacting:<select name="Re" onChange="objPl.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
		</select> + <span id="pl_pi_ref">0</span> ( + <span id="pl_pi_xre">0</span>)</td>
		<td>Targeting:<select name="Ta" onChange="objPl.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
		</select> + <span id="pl_pi_taf">0</span> ( + <span id="pl_pi_xta">0</span>)</td>
	</tr>
</table>

</td><td>

<table>
	<tr>
		<td align=right>等級:</td>
		<td><span id="LevelR">1</span></td>
	</tr>
	<tr>
		<td align=right>所需總成長點數:</td>
		<td><span id="GrowR">&nbsp;</span></td>
	</tr>
	<tr>
		<td align=right>尚餘成長點數:</td>
		<td><span id="PtLeft">&nbsp;</span></td>
	</tr>
</table>
</td>
</tr>
<tr>
	<td align=center colspan=2>
		手動輸入等級 <input name="Pl_dis_spcflv" type=checkbox onClick="objPl.chk_dis_spcflv();objPl.statChanged();">: <input disabled onChange="numParse(this);objPl.statChanged();" style="text-align: center;" type="text" name="Pl_Calc_Level" value=1 size=3 maxlength=3>&nbsp;&nbsp;&nbsp;&nbsp;
		額外成長點數: <input style="text-align: center;" type="text" name="Pl_Calc_xGrowth" size=3 maxlength=4 value=0 onChange="numParse(this);objPl.statChanged();"></td>
</tr>
<tr>
	<td align=center colspan=2>人種類型:<select name="pl_type" onChange="objPl.statChanged();">
		<option value=nat selected>一般人
		<option value=ext>Extended
		<option value=enh>強化人
		<option value=psy>念動力
		<option value=nt>NT
		<option value=co>Coordinator
	</select> (<span id=pl_type_dis_name>一般</span>)</td>
</tr>
<tr>
	<td align=center>SEED Mode: <input name=pl_seed_mode type=checkbox onClick="objPl.statChanged();"></td>
	<td align=left>EXAM System Activated: <input name=pl_exam_activate type=checkbox onClick="objPl.statChanged();"></td>
</tr>
<tr>
	<td colspan=2><hr>Cookies 儲存/載入:
		<select name="selSlotA">
			<option value='1'>記錄 (1)</option>
			<option value='2'>記錄 (2)</option>
			<option value='3'>記錄 (3)</option>
			<option value='4'>記錄 (4)</option>
			<option value='5'>記錄 (5)</option>
		</select>
		<input type="button" value="儲存" name="SaveBtn" onClick="objPl.saveToCookie(document.Calculator.selSlotA.value);alert('資料已儲存！');">
		<input type="button" value="載入" name="LoadBtn" onClick="objPl.LoadFromCookie(document.Calculator.selSlotA.value, objOp);">
		&nbsp; &nbsp; &nbsp; 字串匯出/匯入: 
		<input type="button" value="匯出" name="ExportStr" onClick="document.Calculator.dataString.value=objPl.dataToStr();alert('資料已匯出！');">
		<input type="button" value="匯入" name="ImportStr" onClick="objPl.strToData(document.Calculator.dataString.value,objOp);">
	</td>
</tr>
<tr>
	<td colspan=2><input type="text" name="dataString" value="" style="width: 100%"></td>
</tr>
</table>

</form>
<form name=player_calc>
<hr>

武器、裝備、機體挑選器:

<table border=0 width=100%>
	<tr>
		<td>
			<table align=center width=800>
				<tr valign=top>
					<td align=right width=350>武器: <select name=wepa onChange="objPl.switchWep(objOp,'a');"> <?php echo $Wep_Selection; ?> </select>
						<br>輔助裝備: <select name=eq_wep onChange="objPl.switchWep(objOp,'e');"><?php echo $Wep_Selection; ?></select>
						<br>常規裝備: <select name=p_equip onChange="objPl.switchWep(objOp,'p');"><?php echo $Wep_Selection; ?></select>
						<hr>
						<table width=100%>
							<tr>
								<td align=left>特殊能力池:
								<br><span id=pl_spec_pool></span>
								<br>距離/屬性:
								<br><span id=pl_range></span><span id=pl_attribute></span>
								</td>
							</tr>
						</table>
					</td>
					<td align=left>武器基本攻擊力: <span id=weapon_atk_raw>0</span> + 改造加成 <input type=text name=weapon_atk_add value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=4>
						<br>武器攻擊力: <span id=weapon_atk>0</span>
						<br>武器基本回數: <span id=weapon_rds_raw>0</span>+ 改造加成 <input type=text name=weapon_rds_add value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=4>
						<br>武器回數: <span id=weapon_rds>0</span>
						<br>武器基本命中: <span id=weapon_hit_raw>0</span>+ 改造加成 <input type=text name=weapon_hit_add value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=4>
						<br>武器命中: <span id=weapon_hit>0</span>
						<br>武器理論總傷害力: <span id=weapon_t_dam>0</span>
					</td>
				</tr>
				<tr><td colspan=2><hr width=90%></td></tr>
				<tr valign=top>
					<td align=center valign=center width=350>
						機體: <select name=pl_ms onChange="objPl.switchWep(objOp,'ms');"> <?php echo $MS_Selection; ?> </select>
					</td>
					<td align=left>
						機體能力:<br>
						<table align=center width=400>
							<tr>
								<td>Attacking: <span id="ms_atf">0</span> + <input type=text name="ms_atf_c" value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=2 maxlength=2> (<span id="ms_atf_t">0</span>)</td>
								<td>Defending: <span id="ms_def">0</span> + <input type=text name="ms_def_c" value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=2 maxlength=2> (<span id="ms_def_t">0</span>)</td>
							</tr>
							<tr>
								<td>Mobility: <span id="ms_ref">0</span> + <input type=text name="ms_ref_c" value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=2 maxlength=2> (<span id="ms_ref_t">0</span>)</td>
								<td>Targeting: <span id="ms_taf">0</span> + <input type=text name="ms_taf_c" value=0 style="text-align: center;" onChange="numParse(this);objPl.AdjustSt(objOp);" size=2 maxlength=2> (<span id="ms_taf_t">0</span>)</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<hr>

敵人挑選器:

<table align=center width=800>
	<tr valign=top>
		<td align=right width=350>武器: <select name=op_wepa onChange="objOp.switchWep(objPl,'a');"> <?php echo $Wep_Selection; ?> </select>
			<br>輔助裝備: <select name=op_eq_wep onChange="objOp.switchWep(objPl,'e');"><?php echo $Wep_Selection; ?></select>
			<br>常規裝備: <select name=op_p_equip onChange="objOp.switchWep(objPl,'p');"><?php echo $Wep_Selection; ?></select>
			<hr><table width=100%>
				<tr>
					<td align=left>特殊能力池:
						<br><span id=op_spec_pool></span>
						<br>距離/屬性:
						<br><span id=op_range></span><span id=op_attribute></span>
					</td>
				</tr>
			</table>
		</td>
		<td align=left>武器基本攻擊力: <span id="op_weapon_atk_raw">0</span> + 改造加成 <input type=text name="op_weapon_atk_add" style="text-align: center;" value=0 onChange="numParse(this);objOp.AdjustSt(objPl);" size=4>
			<br>武器攻擊力: <span id="op_weapon_atk">0</span>
			<br>武器基本回數: <span id="op_weapon_rds_raw">0</span>+ 改造加成 <input type=text name="op_weapon_rds_add" style="text-align: center;" value=0 onChange="numParse(this);objOp.AdjustSt(objPl);" size=4>
			<br>武器回數: <span id="op_weapon_rds">0</span>
			<br>武器基本命中: <span id="op_weapon_hit_raw">0</span>+ 改造加成 <input type=text name="op_weapon_hit_add" style="text-align: center;" value=0 onChange="numParse(this);objOp.AdjustSt(objPl);" size=4>
			<br>武器命中: <span id="op_weapon_hit">0</span>
			<br>武器理論總傷害力: <span id="op_weapon_t_dam">0</span>
		</td>
	</tr>
	<tr><td colspan=2><hr width=90%></td></tr>
	<tr>
		<td width=350>機體: <select name="op_ms" onChange="objOp.switchWep(objPl,'ms');">
			<?php echo $MS_Selection;?>
			</select>
		</td>
		<td>
			機體能力:<br>
			<table align=center width=400>
				<tr>
					<td>Attacking: <span id="op_ms_atf">0</span> + <input type=text name="op_ms_atf_c" value=0 style="text-align: center;" onChange="numParse(this);objOp.AdjustSt(objPl);" size=2 maxlength=2> (<span id="op_ms_atf_t">0</span>)</td>
					<td>Defending: <span id="op_ms_def">0</span> + <input type=text name="op_ms_def_c" value=0 style="text-align: center;" onChange="numParse(this);objOp.AdjustSt(objPl);" size=2 maxlength=2> (<span id="op_ms_def_t">0</span>)</td>
				</tr>
				<tr>
					<td>Mobility: <span id="op_ms_ref">0</span> + <input type=text name="op_ms_ref_c" value=0 style="text-align: center;" onChange="numParse(this);objOp.AdjustSt(objPl);" size=2 maxlength=2> (<span id="op_ms_ref_t">0</span>)</td>
					<td>Targeting: <span id="op_ms_taf">0</span> + <input type=text name="op_ms_taf_c" value=0 style="text-align: center;" onChange="numParse(this);objOp.AdjustSt(objPl);" size=2 maxlength=2> (<span id="op_ms_taf_t">0</span>)</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align=left colspan=2>
			<table align=center>
				<tr>
					<td colspan=4 align=left>機師能力:</td>
				</tr>
				<tr>
					<td>Attacking:<select name="Op_At" style="text-align: center;" onChange="objOp.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
					</select> + <span id="op_pi_atf">0</span> ( + <span id="op_pi_xat">0</span> )</td>
					<td>Defending:<select name="Op_De" style="text-align: center;" onChange="objOp.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
					</select> + <span id="op_pi_def">0</span> ( + <span id="op_pi_xde">0</span> )</td>
					<td align=right>等級:</td>
					<td width=50><span id="LevelR_Op">1</span></td>
					</tr>
				<tr>
					<td>Reacting:<select name="Op_Re" style="text-align: center;" onChange="objOp.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
					</select> + <span id="op_pi_ref">0</span> ( + <span id="op_pi_xre">0</span> )</td>
					<td>Targeting:<select name="Op_Ta" style="text-align: center;" onChange="objOp.statChanged();"><script language="JavaScript">for(a=1;a<=150;a++){document.write('<option value='+a+'>'+a)}</script>
					</select> + <span id="op_pi_taf">0</span> ( + <span id="op_pi_xta">0</span> )</td>
					<td align=right>所需總成長點數:</td>
					<td><span id=GrowR_Op>&nbsp;</span></td>
				</tr>
				<tr>
					<td align=right colspan=3>尚餘成長點數:</td>
					<td><span id=PtLeft_Op>&nbsp;</span></td>
				</tr>
				<tr>
					<td align=center colspan=2>
						手動輸入等級 <input name="Op_dis_spcflv" type=checkbox onClick="objOp.chk_dis_spcflv();objOp.statChanged();">: <input disabled onChange="numParse(this);objOp.statChanged();" style="text-align: center;" type="text" name="Op_Calc_Level" value=1 size=3 maxlength=3>&nbsp;&nbsp;&nbsp;&nbsp;
						額外成長點數: <input style="text-align: center;" type="text" name="Op_Calc_xGrowth" size=3 maxlength=4 value=0 onChange="numParse(this);objOp.statChanged();"></td>
				</tr>
				<tr>
					<td align=center colspan=2>人種類型:<select name="op_type" onChange="objOp.statChanged();">
						<option value='nat' selected >一般人</option>
						<option value='ext'>Extended</option>
						<option value='enh'>強化人</option>
						<option value='psy'>念動力</option>
						<option value='nt'>NT</option>
						<option value='co'>Coordinator
					</select> (<span id=op_type_dis_name>一般</span>)</td>
				</tr>
				<tr>
					<td align=center>SEED Mode: <input name=op_seed_mode type=checkbox onClick="objOp.statChanged();"></td>
					<td align=left>EXAM System Activated: <input name=op_exam_activate type=checkbox onClick="objOp.statChanged();"></td>
				</tr>
				<tr>
					<td colspan=2>Cookies 儲存/載入:
						<select name="selSlotB">
							<option value='1'>記錄 (1)</option>
							<option value='2'>記錄 (2)</option>
							<option value='3'>記錄 (3)</option>
							<option value='4'>記錄 (4)</option>
							<option value='5'>記錄 (5)</option>
						</select>
						<input type="button" value="儲存" name="SaveBtn" onClick="objOp.saveToCookie(document.player_calc.selSlotB.value);alert('資料已儲存！');">
						<input type="button" value="載入" name="LoadBtn" onClick="objOp.LoadFromCookie(document.player_calc.selSlotB.value, objPl);">
						&nbsp; &nbsp; &nbsp; 字串匯出/匯入: 
						<input type="button" value="匯出" name="ExportStr" onClick="document.player_calc.OpdataString.value=objOp.dataToStr();alert('資料已匯出！');">
						<input type="button" value="匯入" name="ImportStr" onClick="objOp.strToData(document.player_calc.OpdataString.value,objPl);">
					</td>
				</tr>
				<tr>
					<td colspan=2><input type="text" name="OpdataString" value="" style="width: 100%"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<hr>
預計結果計算器:


<form name=prediction_calc>

己方戰法: <select name="pl_tactics" onChange="objPl.switchTactics(objOp);"> <?php echo $Tactics_Selection; ?> </select><br>
敵方戰法: <select name="op_tactics" onChange="objOp.switchTactics(objPl);"> <?php echo $Tactics_Selection; ?> </select><br>
<br>
<input type=button onClick="pd_Calc(objPl, objOp);" value='開始計算'>

<table align=center width=800 border=1 bordercolor=#111111 style="border-collapse: collapse">
	<tr>
		<td colspan=4>己方:</td>
	</tr>
	<tr>
		<td width=200 align=right>每回預計傷害力:</td>
		<td width=200 align=center><span id="pl_dam_per_rd_min">0</span> ~ <span id="pl_dam_per_rd_max">0</span></td>
		<td width=200 align=right>每回平均傷害力:</td>
		<td width=200 align=center><span id="pl_dam_average">0</span></td>
	</tr>
	<tr>
		<td width=200 align=right>每回預計命中率:</td>
		<td width=200 align=center><span id="pl_accuracy">0</span>%</td>
		<td width=200 align=right>預計命中次數:</td>
		<td width=200 align=center><span id="pl_expected_hits">0</span>次</td>
	</tr>
	<tr>
		<td width=200 align=right>預計總傷害力:</td>
		<td width=200 align=center><span id="pl_dam_min">0</span> ~ <span id="pl_dam_max">0</span></td>
		<td width=200 align=right>預計平均總傷害力:</td>
		<td width=200 align=center><span id="pl_expected_damage">0</span></td>
	</tr>
	<tr>
		<td colspan=4>敵方:</td>
	</tr>
	<tr>
		<td width=200 align=right>每回預計傷害力:</td>
		<td width=200 align=center><span id="op_dam_per_rd_min">0</span> ~ <span id="op_dam_per_rd_max">0</span></td>
		<td width=200 align=right>每回平均傷害力:</td>
		<td width=200 align=center><span id="op_dam_average">0</span></td>
	</tr>
	<tr>
		<td width=200 align=right>每回預計命中率:</td>
		<td width=200 align=center><span id="op_accuracy">0</span>%</td>
		<td width=200 align=right>預計命中次數:</td>
		<td width=200 align=center><span id="op_expected_hits">0</span>次</td>
	</tr>
	<tr>
		<td width=200 align=right>預計總傷害力:</td>
		<td width=200 align=center><span id="op_dam_min">0</span> ~ <span id="op_dam_max">0</span></td>
		<td width=200 align=right>預計平均總傷害力:</td>
		<td width=200 align=center><span id="op_expected_damage">0</span></td>
	</tr>
</table>

</form>

<!-- Insert JavaScript-->

<script language="JavaScript">

	// Object: Pl Initialize

	objPl.setElements(document.getElementById("LevelR"), document.getElementById("GrowR"), document.getElementById("PtLeft"), document.Calculator.pl_seed_mode, document.Calculator.pl_exam_activate);
	objPl.setAbilityElm(document.getElementById("pl_pi_atf"), document.getElementById("pl_pi_def"), document.getElementById("pl_pi_ref"), document.getElementById("pl_pi_taf"), document.getElementById("pl_pi_xat"), document.getElementById("pl_pi_xde"), document.getElementById("pl_pi_xre"), document.getElementById("pl_pi_xta"));

	// Basics
	objPl.oTypeName = document.getElementById('pl_type_dis_name');
	objPl.oTypeInf = document.Calculator.pl_type;
	objPl.setXGrowth(document.Calculator.Pl_Calc_xGrowth);
	objPl.setLevel(document.Calculator.Pl_Calc_Level);
	objPl.setSpcLv(document.Calculator.Pl_dis_spcflv);
	objPl.setBase(document.Calculator.At,document.Calculator.De,document.Calculator.Re,document.Calculator.Ta);

	// MS Elements
	objPl.setMS_elms(document.player_calc.pl_ms);
	objPl.setMS_At_Elms(document.getElementById("ms_atf"), document.getElementById("ms_atf_t"), document.player_calc.ms_atf_c);
	objPl.setMS_De_Elms(document.getElementById("ms_def"), document.getElementById("ms_def_t"), document.player_calc.ms_def_c);
	objPl.setMS_Re_Elms(document.getElementById("ms_ref"), document.getElementById("ms_ref_t"), document.player_calc.ms_ref_c);
	objPl.setMS_Ta_Elms(document.getElementById("ms_taf"), document.getElementById("ms_taf_t"), document.player_calc.ms_taf_c);
	
	// Weapon Elements
	objPl.setWeaponElms(document.player_calc.wepa, document.player_calc.eq_wep, document.player_calc.p_equip, document.getElementById('weapon_t_dam'), document.getElementById('pl_spec_pool'), document.getElementById('pl_range'), document.getElementById('pl_attribute'));
	objPl.setWeaponARH(document.getElementById("weapon_atk"), document.getElementById("weapon_rds"), document.getElementById("weapon_hit"));
	objPl.setWeaponARH_Raw(document.getElementById("weapon_atk_raw"), document.getElementById("weapon_rds_raw"), document.getElementById("weapon_hit_raw"));
	objPl.setWeaponARH_Add(document.player_calc.weapon_atk_add, document.player_calc.weapon_rds_add, document.player_calc.weapon_hit_add);
	
	// Calculator Elements
	objPl.setTactics(document.prediction_calc.pl_tactics);
	objPl.oDprd_Max = document.getElementById("pl_dam_per_rd_max");
	objPl.oDprd_Min = document.getElementById("pl_dam_per_rd_min");
	objPl.oAccPrd   = document.getElementById("pl_accuracy");
	objPl.oExpdHits = document.getElementById("pl_expected_hits");
	objPl.oDamMin   = document.getElementById("pl_dam_min");
	objPl.oDamMax   = document.getElementById("pl_dam_max");
	objPl.oDamAvg   = document.getElementById("pl_dam_average");
	objPl.oExpdDam  = document.getElementById("pl_expected_damage");
	
	// Object: Op Initialize

	objOp.setElements(document.getElementById("LevelR_Op"), document.getElementById("GrowR_Op"), document.getElementById("PtLeft_Op"), document.player_calc.op_seed_mode, document.player_calc.op_exam_activate);
	objOp.setAbilityElm(document.getElementById("op_pi_atf"), document.getElementById("op_pi_def"), document.getElementById("op_pi_ref"), document.getElementById("op_pi_taf"), document.getElementById("op_pi_xat"), document.getElementById("op_pi_xde"), document.getElementById("op_pi_xre"), document.getElementById("op_pi_xta"));

	// Basics
	objOp.oTypeName = document.getElementById('op_type_dis_name');
	objOp.oTypeInf = document.player_calc.op_type;
	objOp.setXGrowth(document.player_calc.Op_Calc_xGrowth);
	objOp.setLevel(document.player_calc.Op_Calc_Level);
	objOp.setSpcLv(document.player_calc.Op_dis_spcflv);
	objOp.setBase(document.player_calc.Op_At,document.player_calc.Op_De,document.player_calc.Op_Re,document.player_calc.Op_Ta);

	// MS Elements
	objOp.setMS_elms(document.player_calc.op_ms);
	objOp.setMS_At_Elms(document.getElementById("op_ms_atf"), document.getElementById("op_ms_atf_t"), document.player_calc.op_ms_atf_c);
	objOp.setMS_De_Elms(document.getElementById("op_ms_def"), document.getElementById("op_ms_def_t"), document.player_calc.op_ms_def_c);
	objOp.setMS_Re_Elms(document.getElementById("op_ms_ref"), document.getElementById("op_ms_ref_t"), document.player_calc.op_ms_ref_c);
	objOp.setMS_Ta_Elms(document.getElementById("op_ms_taf"), document.getElementById("op_ms_taf_t"), document.player_calc.op_ms_taf_c);
	
	// Weapon Elements
	objOp.setWeaponElms(document.player_calc.op_wepa, document.player_calc.op_eq_wep, document.player_calc.op_p_equip, document.getElementById('op_weapon_t_dam'), document.getElementById('op_spec_pool'), document.getElementById('op_range'), document.getElementById('op_attribute'));
	objOp.setWeaponARH(document.getElementById("op_weapon_atk"), document.getElementById("op_weapon_rds"), document.getElementById("op_weapon_hit"));
	objOp.setWeaponARH_Raw(document.getElementById("op_weapon_atk_raw"), document.getElementById("op_weapon_rds_raw"), document.getElementById("op_weapon_hit_raw"));
	objOp.setWeaponARH_Add(document.player_calc.op_weapon_atk_add, document.player_calc.op_weapon_rds_add, document.player_calc.op_weapon_hit_add);
	
	// Calculator Elements
	objOp.setTactics(document.prediction_calc.op_tactics);
	objOp.oDprd_Max = document.getElementById("op_dam_per_rd_max");
	objOp.oDprd_Min = document.getElementById("op_dam_per_rd_min");
	objOp.oAccPrd   = document.getElementById("op_accuracy");
	objOp.oExpdHits = document.getElementById("op_expected_hits");
	objOp.oDamMin   = document.getElementById("op_dam_min");
	objOp.oDamMax   = document.getElementById("op_dam_max");
	objOp.oDamAvg   = document.getElementById("op_dam_average");
	objOp.oExpdDam  = document.getElementById("op_expected_damage");

</script>

<hr>

<table align=center width=60% border=1 style="border-collapse: collapse;font-size: 12; font-family: Arial" bordercolor="#000000">
	<tr>
		<td colspan=2><B>更新日誌</B></td>
	</tr>
	<!-- 第九則 -->
	<tr>
		<td align=right width=30>日期:</td>
		<td >2010年2月16日</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- v3.0β 版
			<br>　 - php-eb 版本支援: v0.49 戰鬥系統, 屬性效果
			<br>　 　 - SEED 的效果更新 (一般人加強)
			<br>　 　 - 人種等級 11 - 16 (Debugged)
			<br>　 　 - 點數加成更新 (每15%能力 +1%效果)
			<br>　 - 不支援距離效果、套機
		</td>
	</tr>
	<!-- 第八則 -->
	<tr>
		<td align=right width=30>日期:</td>
		<td >2010年1月17日</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- v3.0α 版
			<br>　 - 改用 Object-based 結構
			<br>　 - 瀏覽器支援: 對應最新版本 Mozilla Firefox 及 Google Chrome 瀏覽器, 不再限於 Internet Explorer 了
			<br>　 - php-eb 版本支援: v0.47 戰鬥系統, 合成系統
			<br>　 　 - 已過濾各藍圖物品
			<br>　 - 儲存、載入、匯出、匯入功能
		</td>
	</tr>
	<!-- 第七則 -->
	<tr>
		<td align=right width=30>日期:</td>
		<td >2009年1月3日</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- 更新「傷害減免效果」
			<br>- 減免量: 3500, 2500, 1500, 1000, 500
		</td>
	</tr>
	<!-- 第六則 -->
	<tr>
		<td align=right width=30>日期:</td>
		<td >2008年11月25日</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- 採用了新經驗公式
			<br>- 經驗會以數字格式輸出了
		</td>
	</tr>
	<!-- 第五則 -->
	<tr>
		<td align=right width=30>日期:</td>
		<td >2008年11月13日</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- 能力上限提升
			<br>　- 現在提升到 150 了
		</td>
	</tr>
	<!-- 第四則 -->
	<tr>
		<td align=right width=30>日期:</td>
		<td >2008年05月10日</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- 加入戰法的支援
			<br>- 加入新版本 SEED Mode 及 EXAM System 支援
			<br>加入的戰法特效支援:
			<br>　 - 二連擊、三連擊 (*只限於戰法)
			<br>不會加入支援的戰法特效: (即另行通知前都不會加入)
			<br>　- 全彈發射, 反擊, 先制攻擊
			<br>- 在這裡加入更新日誌
		</td>
	</tr>
	<!-- 第三則 -->
	<tr>
		<td align=right width=30>日期:</td>
		<td >2008年04月26日</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>加入特效支援:
			<br>　 - 完全防禦, 貫穿
			<br>　 - 禁錮
			<br>　 - 加速, 超前, 閃避, 逃離
			<br>　 - 簡單推進, 強力推進, 最佳化推進, 高級推進, 極級推進
			<br>　 - 網絡干擾, 雷達干擾
			<br>　 - 校準, 瞄準, 集中, 預測
			<br>　 - 自動鎖定, 高級校準, 無誤校準, 多重鎖定, 完美鎖定
			<br>　 - 簡單防禦, 正常防禦, 強化防禦, 高級防禦, 最終防禦
			<br>　 - 格擋, 抗衡, 干涉, 堅壁, 空間相對位移
			<br>　 - 高熱能(熔解一段的新名稱), 熔解
			<br>- 基本上已完成, 可作戰鬥系統可行性參考用
		</td>
	</tr>
	<!-- 第二則 -->
	<tr>
		<td align=right width=30>日期:</td>
		<td >2008年04月24日</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>加入特效支援:
			<br>　 - 興奮
			<br>　 - 底力 (包括念動力的底力)
			<br>- 現在會顯示部份計算有效的特效了
		</td>
	</tr>
	<!-- 第一則 -->
	<tr>
		<td align=right width=30>日期:</td>
		<td >2008年04月23日</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>- v2.0α 版
			<br>　 - 開發自配點「php-eb 配點計算工具」 v1.1 及 v1.2 版
			<br>　　　 - 由於套用配點計算工具時, 誤以為 v1.1 是最新版, 所以主要用 v1.1 改造而成
			<br>　　　 - 已加入所有 v1.2 的公能, 及修正原本 v1.1 有的 Bug
			<br>　 - 自動套取武器、機體、人種加成資料
			<br>　 - 可以連敵方的資料一拼計算
			<br>　　 - 自動計算雙方預計攻擊力、命中率、最終傷害
			<br>未加入的功能:
			<br>　 - 還未設定任何特效, 會盡快加入
		</td>
	</tr>
</table>


<!--- --- Separating Line--- -->

<br>
<br>
<a href='http://v2alliance.no-ip.org' style="font-size: 10pt;text-decoration: none;color: ForestGreen">PHP x JavaScript :: php-eb Ultimate Edition :: Emulator &copy; 2005-2010 v2Alliance All Rights Reserved<Br>Script Based on php-eb StatusPoint Calculator v1.2 &copy; 2005-2008 v2Alliance All Rights Reserved</a>
</body>
</html>