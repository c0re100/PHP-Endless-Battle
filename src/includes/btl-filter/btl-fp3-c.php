<?php
//Battle Filter - Part 3: Display Column Contents - Customized
function  DisplayColumns($OpI,$Online,$PlI){
	if ($PlI['fdis_lv'])
	echo "<td width=\"30\">$OpI[level]</td>";
	if ($PlI['fdis_at'])
	echo "<td width=\"30\">".dualConvert($OpI['attacking'])."</td>";
	if ($PlI['fdis_de'])
	echo "<td width=\"30\">".dualConvert($OpI['defending'])."</td>";
	if ($PlI['fdis_re'])
	echo "<td width=\"30\">".dualConvert($OpI['reacting'])."</td>";
	if ($PlI['fdis_ta'])
	echo "<td width=\"30\">".dualConvert($OpI['targeting'])."</td>";
	if ($PlI['fdis_tch']){
		echo "<td width=\"80\">$OpI[t_name]";
		if ($OpI['hypermode'] == 1 || $OpI['hypermode'] == 5)
		echo "<br><font style=\"color: FFFF00;font-weight: bold\">SEED Mode</font>";
		if ($OpI['hypermode'] >= 4 && $OpI['hypermode'] <= 6)
		echo "<br><font style=\"color: FF0000;font-weight: bold\">EXAM Activated</font>";
		echo "</td>";
	}
	if ($PlI['fdis_ms'])
	echo "<td width=\"200\">$OpI[msname]</td>";
	if ($PlI['fdis_hp'])
	echo "<td width=\"100\">".$OpI['hp']."/".$OpI['hpmax']."</td>";
	if ($PlI['fdis_fame']){
	$DisOPFameC = ($OpI['fame'] < 0)?'Red':'Yellow';
	echo "<td width=\"40\" style=\"color: $DisOPFameC\">".abs($OpI['fame'])."</td>";}
	if ($PlI['fdis_bty'])
	echo "<td width=\"60\" style=\"color: white\">".$OpI['bounty']."</td>";
	if ($PlI['fdis_con'])
	echo "<td width=\"75\">$Online</td>";
}
?>