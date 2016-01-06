<?php
//-------------------------//-------------------------//-------------------------//
//----------------------   Converting Functions Include   -----------------------//
//-------------------  php-eb Ultimate Edition Version v1.0  --------------------//
//---------------------------   Official Open Build    --------------------------//
//-------------------------//-------------------------//-------------------------//

//Start Converting Functions
function expToStatus($xp){
	if ($xp > 0) return '+'.($xp/100).'%';
	elseif ($xp < 0) return ($xp/100).'%';
	else return '±0%';
}
function getRangeAttrb($range, $attrb, $equip, $colored = true){
	$rStr = '';
	$aStr = '';
	$rClr = '';
	$aClr = '';
	if($equip == 2) return '不適用';
	switch($range){
		case 0: $rStr = '遠'; $rClr= 'Yellow'; break;
		case 1: $rStr = '近'; $rClr= 'DodgerBlue'; break;
		case 2: if($colored){ $rStr = '特'; $rClr= 'Red';} break;
	}
	switch($attrb){
		case 0: $aStr = 'Beam'; $aClr = 'Yellow'; break;
		case 1: $aStr = '實體'; $aClr= 'DodgerBlue'; break;
		case 2: $aStr = '飛彈'; $aClr= 'ForestGreen'; break;
		case 3: $aStr = '特殊'; $aClr= 'Red'; break;
		case 4: $aStr = '要塞武器'; $aClr= 'Blue'; break;
	}
	if($colored){
		return sprintf('<font style="color: %s">[%s] </font><font style="color: %s">%s</font>',$rClr,$rStr,$aClr,$aStr);
	}
	else {
		if($rStr) $rStr .= '距離';
		return sprintf('%s%s',$rStr,$aStr);
	}
}
function rankConvert($Num,$Bold='Bold'){
$NumRanks = count($GLOBALS["MainRanks"]);
$rankIndex = ($Num == 100000) ? $NumRanks - 1 : floor(($Num / 100000) * $NumRanks);
$Ranks = $GLOBALS["MainRanks"];
Return "<font style=\"font-weight: $Bold; color: ".colorConvert($Num,100000)."\">".$Ranks[$rankIndex]."</font>";
}
function colorConvert($Num,$Max=150){
if ($Num > $Max) $Num = $Max;
$ClrIndex = floor(20 - ($Num / $Max * 20));
if ($ClrIndex > 19)$ClrIndex = 19;
elseif ($ClrIndex < 0)$ClrIndex = 0;
$Var = $GLOBALS["ConvColors"];
Return $Var[$ClrIndex];
}
function gradeConvert($Num,$Max='150'){
if ($Num > $Max)$Num = $Max;
$GrdIndF = $Num / $Max * 20;
$GrdIndex = floor(20 - $GrdIndF);
if ($GrdIndex < 0)$GrdIndex = 0;
if ($GrdIndex > 19)$GrdIndex = 19;
$Var = $GLOBALS["ConvGrades"];
Return $Var[$GrdIndex];
}
function dualConvert($Num,$Max='150',$Bold='Bold'){
if ($Num > $Max)$Num = $Max;
$IndF = $Num / $Max * 20;
$Index = floor(20 - $IndF);
if ($Index < 0)$Index = 0;
if ($Index > 19)$Index = 19;
$VarA = $GLOBALS["ConvColors"];
$VarB = $GLOBALS["ConvGrades"];
$NVar = "<font style=\"font-weight: $Bold; color: ".$VarA[$Index]."\">".$VarB[$Index]."</font>";
Return $NVar;
}
function invertColor($color){
	$color = str_replace('#','',$color);
	$str['r'] = substr($color,0,2);
	$str['g'] = substr($color,2,2);
	$str['b'] = substr($color,4,2);
	foreach($str as $e => $v){
		$i = 255 - hexdec($v);
		$n_str[$e] = dechex($i);
		if(strlen($n_str[$e]) == 1) $n_str[$e] = '0'.$n_str[$e];
	}
	$n_str['n'] = '#'.$n_str['r'].$n_str['g'].$n_str['b'];
	return $n_str['n'];
}
//End Converting Functions
?>