<?php
header('Content-Type: text/html; charset=utf-8');
include('cfu.php');
postHead('');
$mode = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
if ($mode == 'var'){echo $SCRIPT_FILENAME." <br><hr>".$H."-".$i."-".$nu;}
if ($mode == 'cal'){CalcExp('','','1');postFooter();exit;}
if ($mode == 'Footer'){echo "<br><br><br><br><br><br><br><br><br><br><br><br>";postFooter();exit;}
if ($mode == 'calpt'){$bb=3;$cc=2;$bbc=0;$ccc=0;
for($aa=1;$aa<=100;$aa++){
        if ($aa > 1){$bbc+= $bb;$ccc+= $cc;}
        if ($aa > 1)echo "$aa    ==    $bb (".($bbc+40).")    == $cc ($ccc)<br>";
        else echo "$aa    ==    0(40)    == 0<br>";
        if ($aa%5 == 0)$bb++;
        if (($aa-1)%10 == 0 && $aa>1)$cc++;
        }exit;
}
if ($mode == 'time'){$timenow1 =time();$TT = cfu_time_convert($timenow1);$timenow2 = getdate();$hihihihi=strlen("$CFU_Date"); echo "$timenow1<br>$timenow2[year]年$timenow2[mon]月$timenow2[mday]日<br>$CFU_Date<br>$hihihihi<hr>$TT";exit;}
        //Weapon List
if ($mode == 'weplist'){
        $sql_wep_listQ = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `kind` REGEXP '.*I.*' AND noshow=0 ORDER BY `familyid`,`grade`,`name` ");
        $query_wep_list = mysql_query($sql_wep_listQ);
        $selected_wep = mysql_fetch_array($query_wep_list);
        if ($SearchField['Name']){
        $number_of_weps = mysql_num_rows($query_wep_list);
        $search_wep_inf_listQ = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `name` = '$SearchField[Name]'");
        $search_wep_inf_list = mysql_query($search_wep_inf_listQ);
        $search_wep_inf = mysql_fetch_array($search_wep_inf_list);

        if ($search_wep_inf['nextev']){
        $search_wep_nextev=explode(',',$search_wep_inf['nextev']);
        foreach($search_wep_nextev as $nextevid){
        GetWeaponDetails("$nextevid",'Next_Ev_Inf');
        $Next_Ev .= "$Next_Ev_Inf[name]<br>";
        }
        }
        else $Next_Ev= '沒有';

        if ($search_wep_inf['familyid'] && $search_wep_inf['familyid'] != $search_wep_inf['id']){
        $search_wep_prev_listQ = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` WHERE `nextev` REGEXP '($search_wep_inf[id])+'");
        $search_wep_prev_list = mysql_query($search_wep_prev_listQ) or die(mysql_error());
        $Pre_Ev_Inf  = mysql_fetch_array($search_wep_prev_list);
        $Pre_Ev='';
        do{$Pre_Ev .= "$Pre_Ev_Inf[name]<br>";}
        while ($Pre_Ev_Inf  = mysql_fetch_array($search_wep_prev_list));
        }else $Pre_Ev='沒有';
        }
        else {$Pre_Ev=$Next_Ev=" --- ";}
        echo "<p align=center style=\"font-size: 24; font-family: Arial\">php-eb 武器列表</p>";
        echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 12; font-family: Arial\" bordercolor=\"#FFFFFF\" width=\"600\">";
        echo "<form action=gen_info.php?action=weplist method=post name=searchwepform>";
        echo "<tr align=center valign=top height=75>";
        echo "<td>";
        echo "Previous Evolution<br>$Pre_Ev";
        echo "</td>";
        echo "<td>Current Weapon<br><select name=SearchField[Name]>";
        do
        {
        echo "<option value=\"$selected_wep[name]\"";
        if($selected_wep['name'] == $SearchField['Name'])echo " selected";
        echo ">$selected_wep[name]\n";
        }
        while ($selected_wep = mysql_fetch_array($query_wep_list));
        echo "</select><input type=submit value=查看詳細></td>";
        echo "<td>";
        echo "Next Evolution<br>$Next_Ev</td>";
        echo "</tr></form>";
        if ($SearchField['Name']){
        echo "<tr>";
        echo "<td colspan=3>　<span style=\"font-size: 20;color: yellow;font-weight:600;font-family: Arial\">$search_wep_inf[name]</span><br><hr width=70% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        echo "<table align=center border=\"0\" width=\"100%\" style=\"font-size: 12; font-family: Arial\">";
        echo "<tr align=center>";
        echo "<td width=33%>Evolution Grade:<br>";
        if ($search_wep_inf['familyid']){
                GetWeaponDetails($search_wep_inf['familyid'],"searchfamilyinf");
        echo "<b style=\"font-size: 15; color: blue\">$searchfamilyinf[name]系</b><font style=\"font-size: 15; color: red\">第$search_wep_inf[grade]代</font>";}
        else echo "不適用";
        echo "</font></td>";
        echo "<td width=34%>Price: ".number_format($search_wep_inf['price'])."元</td>";
        echo "<td width=33%>Enery Cost: ".number_format($search_wep_inf['enc'])."</td>";
        echo "</tr><tr><td colspan=3><hr width=70% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\"></td></tr>";
        echo "<tr height=300 style=\"font-size: 16;\">";
        echo "<td valign=top width=20%><b>攻擊力:</b> <br>";
        echo number_format($search_wep_inf['atk']);
        echo "<br><br><b>攻擊回數:</b><br>";
        echo number_format($search_wep_inf['rd']);
        echo "<br><br><b>命中:</b><br>";
        echo number_format($search_wep_inf['hit']);
        echo "</td>";
        echo "<td colspan=2 valign=top width=80%><b>特殊效果:</b><br>";
        $search_wep_specs=ReturnSpecs($search_wep_inf['spec']);
        echo "$search_wep_specs</td>";
        echo "</tr>";
        echo "</table>";
        echo "</td></tr>";
        }
        echo "</table>";
        exit;
}
if ($mode == 'wep_list'){
	$wep_list = ("SELECT * FROM `".$GLOBALS[DBPrefix]."phpeb_sys_wep` WHERE 1 AND noshow=0 ORDER BY `id`");
	$query = mysql_query($wep_list);
	while($temp = mysql_fetch_array($query)) {
	$wep_specs=ReturnSpecs($temp[spec]);
	$weplist .= "<tr></tr><tr height=\"50\"><td align=center width=\"3%\">$temp[id]</td><td align=center width=\"5%\">$temp[name]</td><td align=center width=\"5%\">世代：$temp[grade]</td><td align=center width=\"5%\">改造：$temp[nextev]</td><td align=center width=\"5%\">特殊：$temp[specev]</td><td align=center width=\"5%\">攻擊：$temp[atk]</td><td align=center width=\"5%\">命中：$temp[hit]</td><td align=center width=\"5%\">回合：$temp[rd]</td><td align=center width=\"5%\">EN消費：$temp[enc]</td><td align=center width=\"5%\">價錢：$temp[price]</td><td align=center width=\"10%\">特效：$wep_specs</td></tr>";}

	echo "<p align=center style=\"font-size: 24; font-family: Arial\">php-eb 武器列表</p>";
	echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;font-size: 12; font-family: Arial\" bordercolor=\"#FFFFFF\">";
	echo "<tr><td>";
	echo "<table width=\"100%\" border=\"0\" align=center cellspacing=\"0\" cellpadding=\"0\">";
	echo "$weplist</table></table>";
	exit;
}

        //Ms List
if ($mode == 'mslist'){
        $sql_ms_listQ = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE noshow=0 ORDER BY `msname`");
        $query_ms_list = mysql_query($sql_ms_listQ);
        $selected_ms = mysql_fetch_array($query_ms_list);
        if ($SearchField['Name']){
        $number_of_ms = mysql_num_rows($query_ms_list);
        $search_ms_inf_listQ = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_sys_ms` WHERE `msname` = '$SearchField[Name]' AND noshow=0");
        $search_ms_inf_list = mysql_query($search_ms_inf_listQ);
        $search_ms_inf = mysql_fetch_array($search_ms_inf_list);
        }
        echo "<p align=center style=\"font-size: 24; font-family: Arial\">php-eb 機體列表</p>";
        echo "<hr width=70% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        echo "<div align=center><form action=gen_info.php?action=mslist method=post name=searchmsform><select name=SearchField[Name]>";
        do
        {
        if ($selected_ms['id']) echo "<option value='$selected_ms[msname]'";
        if("$selected_ms[msname]" == "$SearchField[Name]")echo " selected";
        if ($selected_ms['id']) echo ">$selected_ms[msname]\n";
        }
        while ($selected_ms = mysql_fetch_array($query_ms_list));
        echo "</select><input type=submit value=檢視>";
        echo "</form>";
        echo "</div><hr width=70% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        if ($SearchField['Name']){
        echo "<table align=center border=\"0\" width=\"600\" style=\"font-size: 16; font-family: Arial\">";
        echo "<tr valign=top align=left height=400>";
        echo "<td width=20%><b style=\"font-size: 18\">$search_ms_inf[msname]<b><br>";
        echo "<img src='".$Unit_Image_Dir."/$search_ms_inf[image]'></td>";
        echo "<td width=4%>";
        echo "　</td>";
        echo "<td width=38%>";
        echo "Hp上限加成: ".number_format($search_ms_inf['hpfix']);
        echo "<br>En上限加成: ".number_format($search_ms_inf['enfix']);
        echo "<hr width=100% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        echo "Attacking加成: $search_ms_inf[atf]";
        echo "<br>Reacting加成: $search_ms_inf[ref]<hr width=100% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        echo "<br>售價: ".number_format($search_ms_inf['price']);
        echo "</td>";
        if (intval($search_ms_inf['hprec']) >= 1)$ShowHpRec=(intval($search_ms_inf['hprec'])+$HP_BASE_RECOVERY).'/秒';
        elseif ($search_ms_inf['hprec'] < 1 && $search_ms_inf['hprec'] != 0)$ShowHpRec=($search_ms_inf['hprec']*100).'% /秒';
        else $ShowHpRec='不會回復';
        if ($search_ms_inf['enrec'] >= 1)$ShowEnRec=(intval($search_ms_inf['enrec'])+$EN_BASE_RECOVERY).'/秒';
        elseif ($search_ms_inf['enrec'] < 1 && $search_ms_inf['enrec'] != 0)$ShowEnRec=($search_ms_inf['enrec']*100).'% /秒';
        else $ShowEnRec='不會回復';
        echo "<td width=38%>";
        echo "Hp回復率: $ShowHpRec";
        echo "<br>En回復率: $ShowEnRec";
        echo "<hr width=100% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        echo "Defending加成: $search_ms_inf[def]";
        echo "<br>Targeting加成: $search_ms_inf[taf]<hr width=100% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        }
        exit;
}

if ($mode == 'ms_list'){
	$ms_list = ("SELECT * FROM `".$GLOBALS[DBPrefix]."phpeb_sys_ms` WHERE 1 AND noshow=0 ORDER BY `id`");
	$query = mysql_query($ms_list);
	while($temp1 = mysql_fetch_array($query)) {
	if (intval($temp1[hprec]) >= 1)$ShowHpRec=(intval($temp1[hprec])+$HP_BASE_RECOVERY).'/ 秒';
	elseif ($temp1[hprec] < 1 && $temp1[hprec] != 0)$ShowHpRec=($temp1[hprec]*100).'% / 秒';
	else $ShowHpRec='不會回復';
	if ($temp1[enrec] >= 1)$ShowEnRec=(intval($temp1[enrec])+$EN_BASE_RECOVERY).'/ 秒';
	elseif ($temp1[enrec] < 1 && $temp1[enrec] != 0)$ShowEnRec=($temp1[enrec]*100).'% / 秒';
	else $ShowEnRec='不會回復';
        if (!$temp1[spec])$spec='無';
        else $spec=$temp1[spec];
	$mslist .= "<table align=center border=\"0\" width=\"80%\" style=\"font-size: 16; font-family: Arial\">
<tr valign=top align=left height=400><td width=20%><b style=\"font-size: 18\">ID: $temp1[id]   『$temp1[msname]』<b><br>
<img src='".$Unit_Image_Dir."/$temp1[image]'></td><td width=4%></td><td width=38%>
Hp上限加成: $temp1[hpfix]<br>En上限加成: $temp1[enfix]
<hr width=100% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">攻擊加成: $temp1[atf]
<br>反應加成: $temp1[ref]<hr width=100% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">
<br>售價: $temp1[price]<br>特效: $spec</td><td width=38%>Hp回復率: $ShowHpRec<br>En回復率: $ShowEnRec
<hr width=100% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">防禦加成: $temp1[def]
<br>命中加成: $temp1[taf]<hr width=100% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">
<br>需要等級: $temp1[needlv]
</td></tr></table>";}

	echo "<p align=center style=\"font-size: 24; font-family: Arial\">php-eb 機體列表</p>";
	echo "<hr width=80% style=\"filter:alpha(opacity=100,finishopacity=40,style=2)\">";
	echo "$mslist";
	exit;
}

if ($mode == 'ranks'){
echo "<form action=gen_info.php?action=ranks method=post name=typerkfrm>";
echo "<input type=hidden name=\"RkSbAct\" value='none'>";
echo "<input type=hidden name=\"InfSbAct\" value='none'>";
echo "<input type=hidden name=\"Extra\" value=''>";
echo "<input type=hidden name=\"ExtraB\" value=''>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";
echo "<table width=100% height=100%><tr><td align=center>";
echo "<table cellspacing=2 cellpadding=3>";
echo "<tr><td colspan=3><center><b><font size=4>十大排行榜</font></b></center></td></tr>";
echo "<td align=center><input type=submit value=\"十大富翁\" onClick=\"typerkfrm.RkSbAct.value='Property'\">";
echo "<input type=submit value=\"十大名人\" onClick=\"typerkfrm.RkSbAct.value='Famed'\">";
echo "<input type=submit value=\"十大惡人\" onClick=\"typerkfrm.RkSbAct.value='Notorous'\">";
echo "<input type=submit value=\"十大懸賞\" onClick=\"typerkfrm.RkSbAct.value='Bounty'\">";
echo "<input type=submit value=\"十大裝甲\" onClick=\"typerkfrm.RkSbAct.value='HP'\">";
echo "<input type=submit value=\"十大能源\" onClick=\"typerkfrm.RkSbAct.value='EN'\"></td>";
echo "<tr><td align=center><input type=submit value=\"十大攻擊\" onClick=\"typerkfrm.RkSbAct.value='Att'\">";
echo "<input type=submit value=\"十大命中\" onClick=\"typerkfrm.RkSbAct.value='Tar'\">";
echo "<input type=submit value=\"十大迴避\" onClick=\"typerkfrm.RkSbAct.value='Re'\">";
echo "<input type=submit value=\"十大防禦\" onClick=\"typerkfrm.RkSbAct.value='Def'\">";
echo "<input type=submit value=\"十大等級\" onClick=\"typerkfrm.RkSbAct.value='Level'\">";
echo "<input type=submit value=\"十大勝利\" onClick=\"typerkfrm.RkSbAct.value='Victory'\"></td></tr>";
echo "</tr>";
echo "</table></form>";
echo "</td></tr>";
echo "<script language=\"JavaScript\">";
echo "function getInfo(act,a,b){";
echo "        typerkfrm.action='information.php?action=Main';";
echo "        typerkfrm.InfSbAct.value=act;";
echo "        typerkfrm.Extra.value=a;";
echo "        typerkfrm.ExtraB.value=b;";
echo "        typerkfrm.submit();";
echo "        }</script>";

if ($RkSbAct == 'Property'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大富翁排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>財產總值</td><td colspan=2>所用機體</td></tr>";
$sqlgen  = ("SELECT a.cash AS property,gamename,e.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_user_bank` c,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` d,`".$GLOBALS['DBPrefix']."phpeb_user_organization` e ");
$sqlgen .= ("WHERE a.username = b.username AND c.username = a.username AND d.id = msuit AND b.organization = e.id ");
$sqlgen .= ("ORDER BY `property` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($PropInf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$PropInf[gamename]')\">$PropInf[gamename]</a></td><td> $PropInf[org] </td><td>$PropInf[property]</td><td>$PropInf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$PropInf[image]\"></td></tr>";
}


echo "</table>";
echo "</tr></td>";
}

elseif ($RkSbAct == 'Notorous'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大惡人排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>惡名值</td><td colspan=2>所用機體</td></tr>";

$sqlgen  = ("SELECT fame,gamename,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `fame` < 0 ");
$sqlgen .= ("ORDER BY `fame` ASC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$Notoriety = abs($R_Inf['fame']);
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$R_Inf[gamename]')\">$R_Inf[gamename]</a></td><td> $R_Inf[org] </td><td>$Notoriety</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}
echo "</table>";
echo "</tr></td>";
}

elseif ($RkSbAct == 'Famed'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大名人排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>名聲值</td><td colspan=2>所用機體</td></tr>";
$sqlgen  = ("SELECT fame,gamename,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `fame` > 0 ");
$sqlgen .= ("ORDER BY `fame` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$R_Inf[gamename]')\">$R_Inf[gamename]</a></td><td> $R_Inf[org] </td><td>$R_Inf[fame]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}

elseif ($RkSbAct == 'Bounty'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大懸賞金排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>懸賞金</td><td colspan=2>所用機體</td></tr>";
$sqlgen  = ("SELECT bounty,gamename,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `bounty` > 0 ");
$sqlgen .= ("ORDER BY `bounty` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$R_Inf[gamename]')\">$R_Inf[gamename]</a></td><td> $R_Inf[org] </td><td>$R_Inf[bounty]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}

elseif ($RkSbAct == 'Level'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大等級排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>等級</td><td colspan=2>所用機體</td></tr>";
$sqlgen  = ("SELECT level,gamename,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `level` > 0 AND b.isnpc = 0 ");
$sqlgen .= ("ORDER BY `level` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$R_Inf[gamename]')\">$R_Inf[gamename]</a></td><td> $R_Inf[org] </td><td>$R_Inf[level]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'HP'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大裝甲排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>裝甲</td><td colspan=2>所用機體</td></tr>";
$sqlgen  = ("SELECT hpmax,gamename,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `hpmax` > 0 AND b.isnpc=0 ");
$sqlgen .= ("ORDER BY `hpmax` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$R_Inf[gamename]')\">$R_Inf[gamename]</a></td><td> $R_Inf[org] </td><td>$R_Inf[hpmax]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'EN'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大能源排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>能源</td><td colspan=2>所用機體</td></tr>";
$sqlgen  = ("SELECT enmax,gamename,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `enmax` > 0 ");
$sqlgen .= ("ORDER BY `enmax` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$R_Inf[gamename]')\">$R_Inf[gamename]</a></td><td> $R_Inf[org] </td><td>$R_Inf[enmax]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'Victory'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大勝利排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>勝利績分/勝利次數</td><td colspan=2>所用機體</td></tr>";
$sqlgen  = ("SELECT victory,v_points,gamename,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `victory` > 0 ");
$sqlgen .= ("ORDER BY `victory` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$R_Inf[gamename]')\">$R_Inf[gamename]</a></td><td> $R_Inf[org] </td><td>".$R_Inf['v_points'].'/'.$R_Inf['victory']."</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'Att'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大攻擊排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>攻擊力</td><td colspan=2>所用機體</td></tr>";
$sqlgen  = ("SELECT attacking,gamename,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `attacking` > 0 ");
$sqlgen .= ("ORDER BY `attacking` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$R_Inf[gamename]')\">$R_Inf[gamename]</a></td><td> $R_Inf[org] </td><td>$R_Inf[attacking]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'Tar'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大命中排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>命中</td><td colspan=2>所用機體</td></tr>";
$sqlgen  = ("SELECT targeting,gamename,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `targeting` > 0 ");
$sqlgen .= ("ORDER BY `targeting` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$R_Inf[gamename]')\">$R_Inf[gamename]</a></td><td> $R_Inf[org] </td><td>$R_Inf[targeting]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'Re'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大迴避排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>迴避</td><td colspan=2>所用機體</td></tr>";
$sqlgen  = ("SELECT reacting,gamename,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `reacting` > 0 ");
$sqlgen .= ("ORDER BY `reacting` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$R_Inf[gamename]')\">$R_Inf[gamename]</a></td><td> $R_Inf[org] </td><td>$R_Inf[reacting]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
elseif ($RkSbAct == 'Def'){
echo "<tr><td>";
echo "<table width=100% height=100% cellspacing=2 cellpadding=3 style=\"font-size:16px;\" border=1>";
echo "<tr><td colspan=6><center><b>十大防禦排行榜</b></center></td></tr>";
echo "<tr><td>名次</td><td>駕駛員名稱</td><td>所屬國家</td><td>防禦</td><td colspan=2>所用機體</td></tr>";
$sqlgen  = ("SELECT defending,gamename,d.name AS org,msname,image FROM `".$GLOBALS['DBPrefix']."phpeb_user_general_info` a,`".$GLOBALS['DBPrefix']."phpeb_user_game_info` b,`".$GLOBALS['DBPrefix']."phpeb_sys_ms` c,`".$GLOBALS['DBPrefix']."phpeb_user_organization` d ");
$sqlgen .= ("WHERE a.username = b.username AND c.id = msuit AND d.id = organization AND `defending` > 0 ");
$sqlgen .= ("ORDER BY `defending` DESC LIMIT 10");
$query_gen = mysql_query($sqlgen) or die ('無法取得基本資訊, 原因:' . mysql_error() . '<br>');
$counter = 0;
while($R_Inf = mysql_fetch_array($query_gen)){
$counter++;
echo "<tr><td>$counter</td><td><a href=# style=\"text-decoration: none\" onClick=\"getInfo('Player','Single','$R_Inf[gamename]')\">$R_Inf[gamename]</a></td><td> $R_Inf[org] </td><td>$R_Inf[defending]</td><td>$R_Inf[msname]</td><td><img src=\"".$Unit_Image_Dir."/$R_Inf[image]\"></td></tr>";
}

echo "</table>";
echo "</tr></td>";
}
echo "</table>";
}

if ($mode == 'history'){
                
echo "<table align=center border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"70%\" >";

echo "<tr><td align=center style=\"font-size:16px;\"><b>歷史<b></tr></td>";

$sql = ("SELECT * FROM `".$GLOBALS['DBPrefix']."phpeb_game_history` ORDER BY `time` DESC LIMIT 0 , 30");
$query = mysql_query($sql);
$HistoryEntries = mysql_num_rows($query);

for($CountHist=1;$CountHist <= $HistoryEntries;$CountHist++){
$History = mysql_fetch_array($query);
$History['DateTime'] = cfu_time_convert($History['time']);
echo "<tr><td align=left style=\"font-size:10px;\"><b style=\"font-size:12px;\">$History[DateTime]</b><br>";
echo "$History[history]";
echo "</tr></td>";
}

echo "</tr></td>";
echo "</table>";
exit;
}

if (!$mode){

echo "<br><br><br>";
echo "<center><iframe name='history' src='gen_info.php?action=history' width=75% height='350' marginheight=0 marginwidth=0 frameborder=0>";
echo '</iframe>';
}

postFooter();
?>