<?php
//Battle Filter - Part 2: Display Column Headings - Customized

	$CustomColumns = '';
	$ColumnNum = 3;
	if ($Pl->Player['fdis_lv'])	{$CustomColumns .= "<td width=\"30\">等級</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_at'])	{$CustomColumns .= "<td width=\"30\">攻擊</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_de'])	{$CustomColumns .= "<td width=\"30\">防禦</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_re'])	{$CustomColumns .= "<td width=\"30\">反應</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_ta'])	{$CustomColumns .= "<td width=\"30\">命中</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_tch'])	{$CustomColumns .= "<td width=\"80\">類型</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_ms'])	{$CustomColumns .= "<td width=\"200\">機體</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_hp'])	{$CustomColumns .= "<td width=\"100\">HP</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_fame'])	{$CustomColumns .= "<td width=\"40\">名聲</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_bty'])	{$CustomColumns .= "<td width=\"60\">懸賞金</td>";$ColumnNum++;}
	if ($Pl->Player['fdis_con'])	{$CustomColumns .= "<td width=\"75\">狀態</td>";$ColumnNum++;}

	echo "<tr align=center><td colspan=$ColumnNum><b>對手列表: </b></td></tr>";
	echo "<tr align=center>";
	echo "<td width=\"20\">No.</td>";
	echo "<td width=\"250\">對手名稱</td>";
	echo $CustomColumns;
	echo "<td width=\"30\">戰鬥</td>";
	echo "</tr>";

?>