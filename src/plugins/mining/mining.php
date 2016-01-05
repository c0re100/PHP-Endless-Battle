<?php

//
//	This Plugin must be used in collaboration with cfu.php and sfo.class.php
//

include('../../cfu.php');
include('../../includes/sfo.class.php');
include('mining.class.php');
include('mining.config.php');

AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");

$Pl = new player_stats;
$Pl->SetUser($Pl_Value['USERNAME']);
$Pl->FetchPlayer();

$Area = ReturnMap($Pl->Player['coordinates']);
$AreaLandForm = ReturnMType($Area['Sys']['type']);

$Area_Org = ReturnOrg($Area['User']['occupied']);
$Pl_Org = ($Area['User']['occupied'] != $Pl->Player['organization']) ? ReturnOrg($Pl->Player['organization']) : $Area_Org;

global $Pl_LocalOrgFlag;
$Pl_LocalOrgFlag = 0;
if ($Area['User']['occupied'] == 0) $Pl_LocalOrgFlag = 2;
elseif ($Area['User']['occupied'] == $Pl->Player['organization']) $Pl_LocalOrgFlag = 1;


$mode = ( isset($_POST['action']) ) ? $_POST['action'] : '';

postHead('','../../phpeb_session_dir',$additionalHeader);
$Mining = new mining($DBPrefix, $CFU_Time, $Work_Length, $Base_Unit_Cost);
$Mining->getDetails($Pl->User, $Pl->Player['coordinates'], $Pl->Player['level'], $Pl->Player['organization']);

echo "<font style='font-size: 12pt;'>原料採集</font><hr>";

//
// Make Payment Process
//

if($mode == 'makePayment'){
	$Mining->makePayment($Pl->Player['cash'],$Pl->Player['organization'],$tax);
}

//
// Mining Process
//

$Mining->doMining();

//
// Main Form
//

echo "<form action=mining.php method=post name=miningForm>";
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden value='changeSchedule' name=action>";

//
// Change Schedule Process
//

if($mode == 'changeSchedule'){
	if(!is_array($_POST['s_set'])) exit;
	$Mining->changeSchedule($_POST['s_set']);
}


/* 
// Create Views
*/
//
// Prepare Templates
//

$templateHTML = file_get_contents('main.template.html');
$templateScheduleEntry = file_get_contents('schedule_entry.template.html');

// Show Products
$show_area_products = '<tr><td colspan=2 align=left>區域:' . $Pl->Player['coordinates'] . "<br>統治組織: <font style='color: $Area_Org[color];'>$Area_Org[name]</font><br>採集權限: ";
$show_area_products .= ($Pl_LocalOrgFlag) ? '擁有<br>' : '沒有<br>' ;
$show_area_products .= '基本收費: $<span id="baseCost">'.$Base_Unit_Cost.'</span><br>';
$show_area_products .= '應繳款項: $<span id="billsPending">'.$Mining->schedule['mining_bills'].'</span></td>';
$show_area_products .= '<td colspan=2 align=center><input type=submit onclick="return checkPayment();" value=支付款項></td></tr>';

$TableFormat = '<tr><td class=width10>%s</td><td class=width40>%s</td><td class=width10>%s</td><td class=width40>%s</td></tr>';

$show_area_products .= '<tr><td class=tHeader>原料</td><td class=tHeader>價格 @ 成功率</td><td class=tHeader>原料</td><td class=tHeader>價格 @ 成功率</td></tr>';

function sprintAP($i){
	global $Mining, $Pl;
	$r1 = $Mining->products[$i];
	$p1 = $Mining->adjustPercentage($i, $r1, $Pl->Player['coordinates']) / 100;
	$m1 = number_format($Mining->getUnitCost($r1));
	
	return sprintf('$%s @ %s%%',$m1,$p1);
}

for($i = 1; $i < 8; $i += 2){
	$v1 = $product_id_list[$i];
	$v2 = $product_id_list[$i+1];
	$a1 = sprintAP($i);
	$a2 = sprintAP($i+1);
	$show_area_products .= sprintf($TableFormat,$v1,$a1,$v2,$a2);
}

// Show Yields
$show_yeilds = '<tr><td class=tHeader>原料</td><td class=tHeader>數量</td><td class=tHeader>原料</td><td class=tHeader>數量</td></tr>';

if(count($Mining->yeild)){
	$v = array('','');
	$a = array('','');
	
	for($i = 0, $j = 1; $j <= 8; $j++){
		if($j == 8) $eFlag = true;
		else $eFlag = false;
		
		$y = ( isset($Mining->yeild[$j]) ) ? $Mining->yeild[$j] : 0;
		
		if($y > 0){
			$v[$i] = $product_id_list[$j];
			$a[$i] = $y;
			$i++;
		}
		if($i == 2){
			$show_yeilds .= sprintf($TableFormat,$v[0],$a[0],$v[1],$a[1]);
			$i = 0;
		}
		elseif($eFlag){
			$show_yeilds .= sprintf($TableFormat,$v[0],$a[0],'&nbsp;','&nbsp;');
		}
	}
}
else $show_yeilds = '<tr><td>沒有</td></tr>';

// Show Storage
$TableFormat = '<tr><td class=width10>%s</td><td class=width40c>%s</td><td class=width10>%s</td><td class=width40c>%s</td></tr>';
$show_storage = '<tr><td class=tHeader>原料</td><td class=tHeader>數量</td><td class=tHeader>原料</td><td class=tHeader>數量</td></tr>';
for($i = 1; $i < 8; $i += 2){
	$v1 = $product_id_list[$i];
	$a1 = $Mining->storage[$i];
	$v2 = $product_id_list[$i+1];
	$a2 = $Mining->storage[$i+1];
	$show_storage .= sprintf($TableFormat,$v1,$a1,$v2,$a2);
}

// Show Schedule
$show_schedule = '';
$show_schedule_options = '';

$optionString = '<option value=%s>%s</option>';

if($Pl_LocalOrgFlag){
	for($i = 0; $i < 10; $i++){
		$flagSelected = false;
		$item = $Mining->s_item[$i]['item'];
		$area = $Mining->s_item[$i]['area'];
		
		$show_schedule_options = sprintf($optionString,'0','---');
		// Generate Product list for current area
		foreach($product_id_list as $p => $v){
			$rrate = $Mining->products[$p];
			$rate = $Mining->adjustPercentage($p,$rrate,$Pl->Player['coordinates'])/100;
			if( $item == $p && $area == $Pl->Player['coordinates']){
				// Mark Selected item
				$selected = "$p selected";
				$flagSelected = true;
			}
			else $selected = $p;
			$inf  = "$v @ ".$Pl->Player['coordinates']." / $rate%";
			$inf .= ' / $'.number_format($Mining->getUnitCost($rrate));
			$show_schedule_options .= sprintf($optionString,$selected,$inf);
		}
		// Show selected items from other areas
		if(!$flagSelected && $item && $area != $Pl->Player['coordinates']){
			$rrate = $Mining->s_item[$i]['rate'];
			$rate = $Mining->adjustPercentage($item,$rrate,$area)/100;
			$show_schedule_options .= sprintf($optionString,'-1 selected style="background-color: LightSkyBlue"',$product_id_list[$item]." @ $area / $rate%");
			$flagSelected = true;
		}
		// Deny changing of first scheduled item
		if( $i == 0 ) {
			$disable = 'id="firstSchedule" ';
			if($flagSelected) $disable .= 'disabled';
		}
		else $disable = '';
		$show_schedule .= sprintf($templateScheduleEntry,($i+1).": ",$i,$disable,$show_schedule_options);

	}
	$show_schedule .= '<tr><td>&nbsp;</td><td align=right><input type=submit value=更改排程 onclick="return checkChange();"></td></tr>';
	$show_schedule .= '<tr><td>&nbsp;</td><td><br>距離下次完成尚餘:<span id="timeLeft"></span></td></tr>';
}
else{
	$show_schedule .= '<tr><td>沒有此區域的採集權限</td></tr>';
}


// Display All
$search_str = array('MINING_AREA_INFO','MINING_SCHEDULE_TABLE','MINING_YIELD','MINING_WAREHOUSE');
$replace_str = array($show_area_products,$show_schedule,$show_yeilds,$show_storage);

echo str_replace($search_str,$replace_str,$templateHTML);

echo "<input type='hidden' name='timeEnd' value='".($Mining->schedule['mining_start']+$Work_Length)."'>";

//
// JavaScript
//

echo "<script language='JavaScript'>";
echo "function checkPayment(){";
if($Mining->schedule['mining_bills'] > $Pl->Player['cash'])
	echo "alert('金錢不足！');return false;";
else
	echo "if(confirm('即將支付 $".number_format($Mining->schedule['mining_bills']).", 確定嗎？') == true ){miningForm.action.value='makePayment';return true;}else{return false;}";
echo "}";
?>

function checkChange(){
	if(confirm('要更改排程嗎？') == true ){
		document.miningForm.action.value='changeSchedule';
		document.getElementById("firstSchedule").disabled = false;
		return true;
	}else{
		return false;
	}
}

var oBaseCost = document.getElementById('baseCost');
var oBillsPending = document.getElementById('billsPending');
var iBaseCost = parseInt(oBaseCost.innerHTML);
var iBillsPending = parseInt(oBillsPending.innerHTML);

var iTimeEnd = document.miningForm.timeEnd.value;
var dTimeEnd = new Date(iTimeEnd * 1000);

var dTimeNow = new Date();

oBaseCost.innerHTML = numFormat(iBaseCost);
oBillsPending.innerHTML = numFormat(iBillsPending);

if(iBillsPending > iBaseCost * 1000) alert("你尚欠 $" + oBillsPending.innerHTML + " 採礦費未繳！\n請記得繳付費用，否則將不能使用庫存內的礦產！");

function updateTime(){
	dTimeNow = new Date();
	var nTimeLeft = dTimeEnd.getTime() - dTimeNow.getTime();
	if (document.getElementById("firstSchedule").disabled == false){
		document.getElementById('timeLeft').innerHTML = ' 沒有進行中的排程。';
		return;
	}
	if(nTimeLeft <= 0){
		document.getElementById('timeLeft').innerHTML = ' 排程已完成。<br>重新整理後可看到結果。';
		return;
	}
	var dTimeLeft = new Date(nTimeLeft);
	var h = (dTimeLeft.getHours() + Math.floor(dTimeLeft.getTimezoneOffset()/60));
	var m = (dTimeLeft.getMinutes() + (dTimeLeft.getTimezoneOffset()%60));
	var s = (dTimeLeft.getSeconds());
	document.getElementById('timeLeft').innerHTML = h + ' 小時 ' + m + ' 分鐘 ' + s + ' 秒';
	setTimeout("updateTime();",1000);
}

function numFormat(num){
	num = parseInt(num);
	var r = num%1000;
	var q = Math.floor(num/1000);

	var sR = r + "";
	if( Math.floor(r / 100) < 1 && q != 0){
		if(Math.floor(r / 10) >= 1) sR = "0" + r;
		else sR = "00" + r;
	}

	var output = sR + "";

	while( q != 0 ){
		r = q%1000;
		sR = r + "";
		if( Math.floor(r / 100) < 1 && Math.floor(q / 1000) != 0){
			if(Math.floor(r / 10) >= 1) sR = "0" + r;
			else sR = "00" + r;
		}
		output = sR + "," + output;
		q = Math.floor(q/1000);
	}
	return output;
}

updateTime();
<?php
echo "</script>";


echo "<p></p><br><br>";
echo "</form>";
postFooter();

?>