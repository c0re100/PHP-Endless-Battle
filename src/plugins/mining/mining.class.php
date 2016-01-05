<?php

class mining {

var $user;
var $userOrg;
var $level;
var $coordinates;
var $products;
var $schedule;
var $s_item;
var $storage;
var $yeild = array();
var $AreaOwner = array();
var $detailsGot = false;
var $storageFetched = false;
private $DBPrefix;
private $Time;
private $Work_Length;
private $Base_Unit_Cost;

function mining($DB_Prefix, $CFU_Time, $Set_Work_Length, $Set_Base_Unit_Cost){
	$this->DBPrefix = $DB_Prefix;
	$this->Time = $CFU_Time;
	$this->Work_Length = $Set_Work_Length;
	$this->Base_Unit_Cost = $Set_Base_Unit_Cost;
}

function doMining(){
	if(!$this->detailsGot) return;
	$t_diff = $this->Time - $this->schedule['mining_start'];
	if($t_diff < $this->Work_Length) return;

	// Determine mining times
	$t_count_done = floor($t_diff / $this->Work_Length);
	if($t_count_done > 10) {
		$t_count_done = 10;
		$this->schedule['mining_start'] = $this->Time;
	}else	$this->schedule['mining_start'] += $t_count_done * $this->Work_Length;

	// Start Mining trials
	for($i = 0; $i < $t_count_done; $i++){
		$target = $this->s_item[$i]['item'];
		if( !$target ) continue;
		$percentage = $this->adjustPercentage($target, $this->s_item[$i]['rate'], $this->s_item[$i]['area']);
		if( mt_rand(0,9999) < $percentage ) {
			$this->storage[$target]++;
			$this->yeild[$target] = (isset($this->yeild[$target])) ? $this->yeild[$target] + 1 : 1;
		}elseif(!isset($this->yeild[$target])){
			$this->yeild[$target] = 0;
		}
		// Bill User
		$this->schedule['mining_bills'] += $this->getUnitCost($this->s_item[$i]['rate']);
		
	}

	// Update Schedule
	for($i = 0; $i + $t_count_done < 10; $i++){
		$this->s_item[$i] = $this->s_item[($i + $t_count_done)];
	}
	for(; $i < 10; $i++){
		$temp = &$this->s_item[$i];
		$temp['area'] = '';
		$temp['item'] = 0;
	}

	$this->updateStorage();
	$this->updateSchedule();
}

function getDetails($username, $location, $user_level, $user_org){
	$this->user = $username;
	$this->userOrg = $user_org;
	$this->coordinates = $location;
	$this->level = $user_level;
	
	$sql = "SELECT `mining_pid`, `rate` FROM `". $this->DBPrefix ."phpeb_mining_mitem` " .
		"WHERE `mining_area` = '".$this->coordinates."' ORDER BY `mining_pid` ASC;";
	$query = mysql_query($sql);

	while($temp = mysql_fetch_array($query)){
		$this->products[$temp['mining_pid']] = $temp['rate'];
	}

	$sql = "SELECT `mining_bills`, `mining_start` " .
		"FROM `". $this->DBPrefix ."phpeb_mining_schedule` " .
		"WHERE `mining_user` = '".$this->user."' LIMIT 1;";
	$query = mysql_query($sql);
	
	if(!mysql_num_rows($query)){
		$sql = "INSERT INTO `". $this->DBPrefix ."phpeb_mining_schedule` ( `mining_user` ) VALUES('".$this->user."');";
		$query = mysql_query($sql);
		
		$temp = ", ('".$this->user."',%d)";
		$sql = "INSERT INTO `". $this->DBPrefix ."phpeb_mining_sitem` ( `mining_user`, `order` ) VALUES('".$this->user."',0) ";
		for($i = 1; $i < 10; $i++){
			$sql .= sprintf($temp,$i);
		}
		$query = mysql_query($sql);
		
		$this->schedule = array('mining_bills' => 0, 'mining_start' => 0);
		for($i = 0; $i < 10; $i++){
			$this->s_item[$i] = 0;
		}
	}
	else{
		$this->schedule = mysql_fetch_array($query);
		
		$sql = "SELECT `area`, `item`, `rate` " .
			"FROM `". $this->DBPrefix ."phpeb_mining_sitem` `s`, `". $this->DBPrefix ."phpeb_mining_mitem` `m` " .
			"WHERE `mining_user` = '".$this->user."' AND s.area = mining_area AND s.item = mining_pid ORDER BY `order` ASC LIMIT 10;";
		$query = mysql_query($sql);

		for($i = 0; $i < 10; $i++){
			$this->s_item[$i] = mysql_fetch_array($query);
		}
		$this->detailsGot = true;
	}
	
	$this->getStorage();
}

function changeSchedule($s_sets){
	if(!$this->detailsGot) return;

	$next_action = $this->s_item[0];

	for($i = $j = 0; $j < 10; $i++, $j++){
		if($s_sets[$j] == 0){
			$this->s_item[(10 - $j + $i)]['area'] = '';
			$this->s_item[(10 - $j + $i)]['item'] = 0;
			$i--;
		}
		else if($s_sets[$j] > 0){
			$this->s_item[$i]['area'] = $this->coordinates;
			$this->s_item[$i]['item'] = $s_sets[$j];
		}
	}
	

	if($next_action['item'] != $this->s_item[0]['item'] && $next_action['area'] != $this->s_item[0]['area']){
		$this->schedule['mining_start'] = $this->Time;
	}

	$this->updateSchedule();
}

function makePayment($cash,$org,$tax){

	$bills = &$this->schedule['mining_bills'];
	
	if($bills > $cash){
		echo "金錢不足！無法支付款項！<hr>";
		return;
	}
	
	$cash -= $bills;
	$orgTax = floor($bills * $tax);
	$bills = 0;
	
	$this->updateSchedule();
	
	$sql = "UPDATE `".$this->DBPrefix."phpeb_user_general_info` SET ";
	$sql .= "`cash` = ".$cash." ";
	$sql .= " WHERE `username` = '".$this->user."' LIMIT 1;";
	$query = mysql_query($sql);

	if($org){
		$sql = "UPDATE `".$this->DBPrefix."phpeb_user_organization` SET ";
		$sql .= "`funds` = `funds` + ".$orgTax." ";
		$sql .= " WHERE `id` = '".$org."' LIMIT 1;";
		$query = mysql_query($sql);
		echo "已支付全部款項, 當中 \$".number_format($orgTax)." 已撥入組織資金。<hr>";
	}
	
	echo "<script language='JavaScript'>parent.document.getElementById('pl_cash').innerHTML = '".number_format($cash)."';</script>";

}

function updateSchedule(){


	$sql = "UPDATE `".$this->DBPrefix."phpeb_mining_schedule` SET ";
	$sql .= "`mining_bills` = '".$this->schedule['mining_bills']."', ";
	$sql .= "`mining_start` = '".$this->schedule['mining_start']."' ";
	$sql .= " WHERE `mining_user` = '".$this->user."' LIMIT 1;";
	$query = mysql_query($sql);

	for($i = 0; $i < 10; $i++){
		$sql = "UPDATE `".$this->DBPrefix."phpeb_mining_sitem` SET ";
		$sql .= " `area` = '".$this->s_item[$i]['area']."'";
		$sql .= ", `item` = '".$this->s_item[$i]['item']."'";
		$sql .= " WHERE `mining_user` = '".$this->user."' AND `order` = $i LIMIT 1;";
		$query = mysql_query($sql);
	}

}

function getStorage(){

	if($this->storageFetched) return;
	$sql = "SELECT `item`, `quantity` FROM `". $this->DBPrefix ."phpeb_mining_storage` " .
		"WHERE `m_store_user` = '".$this->user."' ORDER BY `item` ;";
	$query = mysql_query($sql);

	if(mysql_num_rows($query)){
		while($temp = mysql_fetch_array($query)){
			$this->storage[$temp['item']] = $temp['quantity'];
		}
	}
	
	for($i = 1; $i <= 8; $i++){
		if(!isset($this->storage[$i])){
			$sql = "INSERT INTO `". $this->DBPrefix ."phpeb_mining_storage` ( `m_store_user`, `item` ) VALUES('".$this->user."',$i);";
			$query = mysql_query($sql);
			$this->storage[$i] = 0;
		}
	}

	$this->storageFetched = true;

}

function updateStorage(){

	for($i = 1; $i <= 8; $i++){
		if($this->storage[$i] >= 0){
			$sql = "UPDATE `". $this->DBPrefix ."phpeb_mining_storage` SET " .
				"`quantity` = '" . $this->storage[$i] .
				"' WHERE `m_store_user` = '".$this->user."' AND `item` = $i LIMIT 1;";
			$query = mysql_query($sql);
		}
	}

}

function adjustPercentage($item, $rate, $area, $usrOrg = false, $level = false){

		if(!$usrOrg) $usrOrg = $this->userOrg;
		if(!$level) $level = $this->level;

		$adjustment = $item * 1000 + 2000;
		$level *= 100;
		if($level < $adjustment){
			$rate = $rate - $adjustment + $level;
		}

		$rate = $this->adjustLocality($rate, $area, $usrOrg);

		if($rate < 0) return 0;
		
		return $rate;

}

function adjustLocality($rate, $area, $usrOrg){

		if(count($this->AreaOwner) == 0){
			$sql = "SELECT `map_id`, `occupied` FROM `". $this->DBPrefix ."phpeb_user_map`;";
			$query = mysql_query($sql);
			while($temp = mysql_fetch_row($query)){
				$this->AreaOwner[$temp[0]] = $temp[1];
			}
		}
		
		if($this->AreaOwner[$area] == '0') return ($rate - 2000);
		elseif($this->AreaOwner[$area] == $usrOrg) return $rate;
		else return 0;

}

function getUnitCost($rate){
	if($rate > 0)	return ceil( ($this->Base_Unit_Cost/$rate) * 10000 );
	else return 0;
}

}

?>