<?php
if (!$cSpec) include('cfu.php');
AuthUser("$Pl_Value[USERNAME]","$Pl_Value[PASSWORD]");
	function GetAtkL($Atk, $Tar, $Re){
		if ($Tar < $Re/3)
		$AtkL = $Atk/5;
		else
		$AtkL=$Atk * (floor($Tar-$Re/3) * 0.01);
		if ($AtkL < $Atk/5) $AtkL = $Atk/5;
		if ($AtkL > $Atk) $AtkL = $Atk;
		$AtkL = round($AtkL);
		return $AtkL;
	}
	function ReturnWAtkL($Atk,$Hit,$Tar){
		if ($Hit > 100) $Hit=100;
		elseif ($Hit < 20) $Hit = 20;
		$W_AtkL = $Atk * ( $Tar / $Hit );
		if ($W_AtkL < $Atk/5) $W_AtkL = $Atk/5;
		return $W_AtkL;
	}
	function ReturnHitDam($W_Atk,$Rds,$W_Hit,$Tar,$Hit,$Miss,$Atk,$Def,$A_Spec,$B_Spec){
		$Dealt = 0;
		$Damage = 0;
		$StrikeRds = 0;
		mt_srand ((double) microtime()*1000000);
		$HitCalcVal= $Hit*$W_Hit*0.01;
		
		$ResultHitPercent = $HitCalcVal - $Miss + 65;

		$AtkL = GetAtkL($Atk,$Tar,$Miss);
		$W_AtkL = ReturnWAtkL($W_Atk*$Rds,$W_Hit,$Tar);
		$AtkDf = $Atk - $AtkL;
		$W_AtkDf = $W_Atk*$Rds - $W_AtkL;
		
		$N_Rd=1;
		unset($a,$b,$AtkL_Average,$W_Dam_Average);
		
		$InitialRds = $Rds;
		if(ereg('(DoubleStrike)+',$A_Spec)) $Rds*=2;
		if(ereg('(TripleStrike)+',$A_Spec)) $Rds*=3;	

		for($N_Rd=1;$N_Rd<=$Rds;$N_Rd++){
			$StrikePercent = mt_rand(0,100);
			if ($ResultHitPercent >= $StrikePercent){
				$StrikeRds++;
				$a[$N_Rd] = $AtkL + round(mt_rand(0,$AtkDf));
				$b[$N_Rd] = $W_AtkL + round(mt_rand(0,$W_AtkDf));
			}
		}
		if (count($a) > 0)
		$Atk_Average = array_sum($a)/count($a);
		else $Atk_Average = 0;
		
		if (count($b) > 0)
		$W_Dam_Average = (array_sum($b)/count($b));
		else $W_Dam_Average = 0;

		$Damage = pow($Atk_Average,2) * pow($W_Dam_Average,2) * 3.5 * pow(10,-7);

		$Dealt = $Damage * ( 1 - $Def * 0.0058) * ( $StrikeRds / $InitialRds );
		
                if(ereg('(Defe)+',$B_Spec)) $Dealt *= 0.5;
                elseif(ereg('(Defd)+',$B_Spec)) $Dealt *= 0.63;
                elseif(ereg('(Defc)+',$B_Spec)) $Dealt *= 0.74;
                elseif(ereg('(Defb)+',$B_Spec)) $Dealt *= 0.85;
                elseif(ereg('(Defa)+',$B_Spec)) $Dealt *= 0.95;
				
		if(ereg('(PerfDef)+',$B_Spec) && !ereg('(AntiPDef)+',$A_Spec)){
			$Dealt = ($Dealt*0.5 - 150000);
			if ($Dealt < 0) $Dealt = 0;
			}
		
		$Dealt = round($Dealt);
		
		return array($StrikeRds,$Dealt);
	}
?>