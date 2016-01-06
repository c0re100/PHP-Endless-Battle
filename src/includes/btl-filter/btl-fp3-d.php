<?php
//Battle Filter - Part 3: Display Column Contents - Default
function DisplayColumns($OpI,$Online,$PlI){
	echo "<td width=\"30\">".$OpI['level']."</td>";
	echo "<td width=\"80\">$OpI[t_name]";
	if ($OpI['hypermode'] == 1 || $OpI['hypermode'] == 5)
	echo "<br><font style=\"color: FFFF00;font-weight: bold\">SEED Mode</font>";
	if ($OpI['hypermode'] >= 4 && $OpI['hypermode'] <= 6)
	echo "<br><font style=\"color: FF0000;font-weight: bold\">EXAM Activated</font>";
	echo "</td>";
	if ($OpI['ms_custom']) $Op_CFix = explode('<!>',$OpI['ms_custom']);
	else $Op_CFix = array(0,0,0,0,0);
	if ($Op_CFix[0]) $OpI['msname'] = $Op_CFix[0]."<sub>&copy;</sub>";
	echo "<td width=\"200\">$OpI[msname]</td>";
	echo "<td width=\"75\">$Online</td>";
}
?>