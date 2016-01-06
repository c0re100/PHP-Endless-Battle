<?php
//
// Mining Configuration File
//

$Mining_Configured = true;

$Work_Length = 1800;
$Base_Unit_Cost = 2500;
$tax = 0.1;
$product_id_list = array(1 => '精鋼', 2 => '原油', 3 => '複合鋁', 4 => '純銀', 5 => '月鈦', 6 => '超導體', 7 => '碳纖', 8 => '重氫');
$additionalHeader = '<link href="mining.style.css" rel="stylesheet" type="text/css" />';

//
// Extra Functions For Outsourcing
//

// Mining System Function - Print check mining bills pending
function checkMBillsPending($user){
	$sql = "SELECT `mining_bills` FROM `".$GLOBALS['DBPrefix']."phpeb_mining_schedule` WHERE `mining_user` = '$user' LIMIT 1;";
	$query = mysql_query($sql);
	if(!mysql_num_rows($query)){
		echo "找不到目標儲存庫, 請到「原料採集」一遊。";
		postFooter();
		exit;
	}
	$r = mysql_fetch_array($query);
	if($r['mining_bills'] > 0) return true;
	else return false;
}

// Mining System Function - Borrowed Function from mining.class.php, modified
function getMiningStorage($user){

	$storage = array();

	$sql = "SELECT `item`, `quantity` FROM `".$GLOBALS['DBPrefix']."phpeb_mining_storage` " .
		"WHERE `m_store_user` = '".$user."' ORDER BY `item` ;";
	$query = mysql_query($sql);

	if(mysql_num_rows($query)){
		while($temp = mysql_fetch_array($query)){
			$storage[$temp['item']] = $temp['quantity'];
		}
	}else{
		echo "找不到目標儲存庫, 請到「原料採集」一遊。";
		postFooter();
		exit;
	}

	return $storage;

}

// Mining System Function - Get Raw Material requirement array
// Format: id,amount;id,amount;id,amount;
function getRaw($Str){
	$R = explode(';',$Str);
	$type = array(0,0,0,0,0,0,0,0,0); // [1] to [8] corresponds to mining PIDs
	foreach($R as $v){
		$entry = explode(',',$v);
		$type[$entry[0]] = $entry[1];
		$type[0] += $entry[1];          // $type[0] is the Sum of all entries
	}
	return $type;
}

?>