<?php

// Tact Adder: 
// For v0.50 Version

// Activate Program
// Turn this on (set to true) or delete this file when not using!!
// 不使用時, 記得設定為「True」 或 刪除這個檔案!!
$UseAuth = false;
$Script_Name = 'tactAdder.php';
include('../../cfu.php');

		// Header:
		// Date in the past
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		// always modified
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
 		// HTTP/1.1
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		// HTTP/1.0
		header("Pragma: no-cache");
		echo "<html>";
		echo "<head>";
		echo "<meta http-equiv=\"Pragma\" content=\"no-cache\">";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">";
		echo "<title>Endless Battle ~ php-eb - &copy; 2005-2010 v2Alliance</title>";
		echo "<style type=\"text/css\">BODY {FONT-SIZE: 10px; FONT-FAMILY: \"Arial\",  \"新細明體\"; cursor:default}TD {FONT-SIZE: 9pt; FONT-FAMILY: \"Arial\", \"新細明體\"}A:visited {COLOR: #FFFFFF;}</style>";


$mode = ( isset($_POST['action']) ) ? $_POST['action'] : '';

//
// Login and authentications
//

if($UseAuth){

	exit;

}
//
// Start Program
//

$sql = "SELECT id, name FROM `".$GLOBALS['DBPrefix']."phpeb_sys_wep` ORDER BY `id`";
$query = mysql_query($sql);
$Wep = array();

$Format = "Wep[%d] = new Array(\"%s\", \"%s\");\n";
$JSWepArray = '';
$i = 0;
while($temp = mysql_fetch_array($query)){
	$JSWepArray .= sprintf($Format, $i, $temp['id'], addslashes($temp['name']));
	$Wep[$temp['id']] = $temp;
	$i++;
	unset($temp);
}
unset($temp);


?>


<script type="text/javascript" language="javascript">

var Wep = new Array();
var sObjs = new Array();
<?php echo $JSWepArray; ?>

function initiate(){

	for(var i = 1; i <= 21; i++){

		sObjs[i - 1] = document.getElementById('Select' + i);
		for(var j = 0; j < Wep.length; j++){
			var oOption = document.createElement('option');
			oOption.value = Wep[j][0];
			oOption.text = Wep[j][1];
			try{
				sObjs[i - 1].add(oOption,null);
			}
			catch(ex){
				sObjs[i - 1].add(oOption);
			}
		}
		eval('sObjs[' + (i - 1) + '].onchange = function(){handleChange(' + (i - 1) + ')}');
	
	}

}

function handleChange(num){
	
	var obj;
	if(num == 0){
		obj = document.getElementById('WepID');
	}
	else{
		obj = document.getElementById('M' + num);
	}

	obj.value = document.getElementById('Select' + (num + 1)).value;
	

}

</script>
</head>
<body onload="initiate();">

<?php

if($mode == 'process'){
	
	$sqlFormat = "INSERT INTO `".$GLOBALS['DBPrefix']."phpeb_sys_tactfactory` (
	`tact_id` ,`wep_id` ,`blueprint` , `grade` ,`directions` ,
	`m1` ,`m2` ,`m3` ,`m4` ,`m5` ,`m6` ,`m7` ,`m8` ,`m9` ,`m10` ,
	`m11` , `m12` ,`m13` ,`m14` ,`m15` ,`m16` ,`m17` ,`m18` ,`m19` ,`m20` ,
	`raw_materials`)
	VALUES ('%s', '%s', '%s', %s, '%s', %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, '%s');";

	function prepareBinStr($str){
		if(!$str) return ' NULL';
		else{
			$str = "'$str'";
			return $str;
		}
	}
	
	function analyzeRaw($raw){
		$returnStr = '';
		foreach($raw as $k => $v){
			if(!$v) continue;
			$returnStr .= $k.','.$v.';';
		}
		return $returnStr;
	}

	function processDirections($str){
		$from = array('  ', "\t", "\n");
		$to = array('　', "　 　", "\n<br />");
		$str = str_replace($from, $to, $str);
		return addslashes($str);
	}

	if(!$Grade) $Grade = 1;

	$params = array(
		$TactId, $WepID, '', $Grade, processDirections($Directions)
	);
	
	for($i = 1; $i <= count($M); $i++){
		$params[] = prepareBinStr($M[$i]);
	}
	
	$params[] = analyzeRaw($raw);
	
	$sql = vsprintf($sqlFormat, $params);
	echo "$sql<hr>";
	mysql_query($sql) or die(mysql_error().'<hr>');

}

echo "<form action=$Script_Name method=post name=main>";
echo "<input type=hidden value='process' name=action>";;
echo "<input type=hidden value='$Pl_Value[USERNAME]' name=Pl_Value[USERNAME]>";
echo "<input type=hidden value='$Pl_Value[PASSWORD]' name=Pl_Value[PASSWORD]>";
echo "<input type=hidden name=\"TIMEAUTH\" value=\"$CFU_Time\">";

?>

	<table align="center" cellpadding="0" class="style1" style="width: 100%">
		<tr>
			<td style="width: 30%; height: 50%">Tact ID:
			<input name="TactId" type="text" /><br />
			<br />
			WepID: <input name="WepID" type="text" id="WepID" size="5" />:
			<select name="Select1" id="Select1" style="width: 130px">
			<option value=''>取消</option>
			</select><br />
			<br />
			Grade: <input name="Grade" type="text" /><br />
			</td>
			<td>
			<table align="center" cellpadding="0" cellspacing="0" style="width: 100%">
				<tr>
					<td style="width: 50%">1:<input id="M1" name="M[1]" size="5" type="text" />
					<select name="Select2" id="Select2" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
					<td style="width: 50%">11:<input id="M11" name="M[11]" size="5" type="text" />
					<select name="Select12" id="Select12" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
				</tr>
				<tr>
					<td style="width: 50%">2:<input id="M2" name="M[2]" size="5" type="text" />
					<select name="Select3" id="Select3" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
					<td style="width: 50%">12:<input id="M12" name="M[12]" size="5" type="text" />
					<select name="Select13" id="Select13" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
				</tr>
				<tr>
					<td style="width: 50%">3:<input id="M3" name="M[3]" size="5" type="text" />
					<select name="Select4" id="Select4" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
					<td style="width: 50%">13:<input id="M13" name="M[13]" size="5" type="text" />
					<select name="Select14" id="Select14" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
				</tr>
				<tr>
					<td style="width: 50%">4:<input id="M4" name="M[4]" size="5" type="text" />
					<select name="Select5" id="Select5" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
					<td style="width: 50%">14:<input id="M14" name="M[14]" size="5" type="text" />
					<select name="Select15" id="Select15" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
				</tr>
				<tr>
					<td style="width: 50%">5:<input id="M5" name="M[5]" size="5" type="text" />
					<select name="Select6" id="Select6" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
					<td style="width: 50%">15:<input id="M15" name="M[15]" size="5" type="text" />
					<select name="Select16" id="Select16" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
				</tr>
				<tr>
					<td style="width: 50%">6:<input id="M6" name="M[6]" size="5" type="text" />
					<select name="Select7" id="Select7" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
					<td style="width: 50%">16:<input id="M16" name="M[16]" size="5" type="text" />
					<select name="Select17" id="Select17" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
				</tr>
				<tr>
					<td style="width: 50%">7:<input id="M7" name="M[7]" size="5" type="text" />
					<select name="Select8" id="Select8" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
					<td style="width: 50%">17:<input id="M17" name="M[17]" size="5" type="text" />
					<select name="Select18" id="Select18" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
				</tr>
				<tr>
					<td style="width: 50%">8:<input id="M8" name="M[8]" size="5" type="text" />
					<select name="Select9" id="Select9" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
					<td style="width: 50%">18:<input id="M18" name="M[18]" size="5" type="text" />
					<select name="Select19" id="Select19" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
				</tr>
				<tr>
					<td style="width: 50%">9:<input id="M9" name="M[9]" size="5" type="text" />
					<select name="Select10" id="Select10" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
					<td style="width: 50%">19:<input id="M19" name="M[19]" size="5" type="text" />
					<select name="Select20" id="Select20" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
				</tr>
				<tr>
					<td style="width: 50%">10:<input id="M10" name="M[10]" size="5" type="text" />
					<select name="Select11" id="Select11" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
					<td style="width: 50%">20:<input id="M20" name="M[20]" size="5" type="text" />
					<select name="Select21" id="Select21" style="width: 180px">
					<option value=''>沒有</option>
					</select></td>
				</tr>
			</table>
			</td>
			<td>
				原料:
				<br /> 精鋼 <input type=text name="raw[1]" size=3>
				<br /> 原油 <input type=text name="raw[2]" size=3>
				<br /> 複合鋁 <input type=text name="raw[3]" size=3>
				<br /> 純銀 <input type=text name="raw[4]" size=3>
				<br /> 月鈦 <input type=text name="raw[5]" size=3>
				<br /> 超導體 <input type=text name="raw[6]" size=3>
				<br /> 碳纖 <input type=text name="raw[7]" size=3>
				<br /> 重氫 <input type=text name="raw[8]" size=3>
			</td>
		</tr>
		<tr>
			<td style="width: 100%; height: 50%" colspan="3">Directions:<br />
			<textarea name="Directions" rows="20" style="width: 100%"></textarea></td>
		</tr>
		<tr>
			<td style="width: 100%; height: 50%" colspan="3" class="style2">
			<input name="Submit1" type="submit" value="submit" /></td>
		</tr>
	</table>
</form>

<?php


postFooter();
echo "</body>";

?>