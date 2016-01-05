<?php
	//Bar 5: Money
	echo "<tr><td colspan=3 height=10 style=\"font-size: 1px\">&nbsp;</td></tr>";
	echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Player[color];padding-left: 18px;\" height=30 width=175>";
	echo "<b color=FEFEFE>金錢: &nbsp;</b><span id=pl_cash>".number_format($Player['cash']);
	echo "</spam></td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";

	//Bar 6: Fame / Notor
	$TypeFame = ($Player['fame'] >= 0) ? '名聲' : '惡名';
	$ShowFame = abs($Player['fame']);
	echo "<tr><td colspan=3 height=10 style=\"font-size: 1px\">&nbsp;</td></tr>";
	echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Player[color];padding-left: 18px;\" height=30 width=175>";
	echo "<b color=FEFEFE><span id=type_fame>$TypeFame</span>: &nbsp;</b><span id=pl_fame>$ShowFame</span>";
	echo "</td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";

	//Bar 7: Status
	$StatusShow = $StatusColor = '';
	if ($Player['msuit'])
	switch ($Player['status']){case 0: $StatusShow="發進登錄可能"; $StatusColor='#016CFE';break; case 1: $StatusShow="修理進行中"; $StatusColor='#FF2200';break;}
	else {$StatusShow = '沒有機體'; $StatusColor = '#FF2200';}
	echo "<tr><td colspan=3 height=10 style=\"font-size: 1px\">&nbsp;</td></tr>";
	echo "<tr><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_l.gif');\" width=12>&nbsp;</td><td style=\"background-image: url('$General_Image_Dir/neo/btn_neo_m.gif');background-color: $Player[color];padding-left: 18px;\" height=30 width=175>";
	echo "<b color=FEFEFE>機體狀態:</b>&nbsp; <b style=\"color: $StatusColor;\" id=status_now>$StatusShow</b>";
	echo "</td><td width=13 style=\"background-image: url('$General_Image_Dir/neo/btn_neo_r.gif');\">&nbsp;</td></tr>";
?>