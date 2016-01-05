<?php
ini_set('display_errors','1');
$mode = ( isset($_POST['action']) ) ? $_POST['action'] : '';

include_once('iChat.class.php');
$iChat = new iChat();

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if(!$username || !$password){
	$mode = 'login';
}else $Inf = $iChat->fetchUser($username, $password, $mode);

if(!$mode || $mode == 'login'){

	if(ob_get_length()) ob_clean();
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh">
	<head>
		<title>AJAX Chat</title>
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="chatStyle.css" rel="stylesheet" type="text/css" />
<?php 
	if(!$mode){
?>
		<script type="text/javascript" src="iChat.js" ></script>
	</head>
	<body onload="initiate();" onunload="parentRef.act.noopenchat.value=0;">
		<div id="scroll" class="sMed">
		</div>
		<div>
			<input type="hidden" id="userName" value="<?php echo $Inf['gamename']; ?>" />
			<input type="hidden" id="phpeb_username" value="<?php echo $username; ?>" />
			<input type="hidden" id="phpeb_password" value="<?php echo $password; ?>" />
			<input type="text" id="targetName" maxlength="16" onchange="updateElm('Tar');" />
			<input type="button" class="setChannel" value="公開" onclick="setPublic();" />
			<input type="button" class="setChannel" value="組織" onclick="setOrg();" />
			<input type="text" id="messageBox" maxlength="50" onchange="updateElm('Msg');" onkeydown="handleKey(event)" />
			<input type="button" id="sendButton" value="Send" onclick="postMessage();" />
			<input type="button" class="resizeChat" value="&uarr;" onclick="resizeChat('up');" />
			<input type="button" class="resizeChat" value="&darr;" onclick="resizeChat('down');" />
		</div>
		<div id="settings">
			<input type="button" id="unloadCfmBtn" value="容許關閉" onclick="changeUnloadConfirm();" />
			<input type="button" id="autoNoteBtn" value="關閉提示" onclick="changeAutoNotification();" />
		</div>
	</body>
<?php 
	}else{
	?>
	</head>
	<body>
		<form action=iChat.php method=post name=iChatForm>
			Username: <input type="text" name=username />
			<br />Password: <input type="password" name=password />
			<br /><input type="submit" value="Login" />
		</form>
	</body>
<?php
	}
	echo "</html>";
	exit;
}


if($mode == 'send'){

	$user = $Inf['gamename'];
	$message = $_POST['msg'];
	$FormStr = array("\t",'   ','  ','@@@@@');
	$ToStr = array(	'&nbsp; &nbsp; &nbsp; &nbsp; ','&nbsp; &nbsp;','&nbsp;&nbsp;',' ');
	$message = str_replace($FormStr,$ToStr,$message);
	$message = htmlspecialchars($message, ENT_QUOTES);
	$message = addslashes($message);
	$message = preg_replace("/((f.ck)|(fu.k)|(fuc.)|(shit)|(sh\|t)|(sh1t)|(shlt)|(fxxk)|(sucker)|(bitch)|(bltch)|(b1tch)|(b\|tch)|(asshole)|(fucker)|(motherfucker)|(dickhead))+/i",'&nbsp;',$message);

	$type = $_POST['type'];
	if($type == -1) {
		($Inf['acc_status'] >= 0) ? $target = 0 : $target = -1;
	}
	elseif($type > 3 || $type < 1) exit;

	if($type == 1) $target = 0;
	elseif($type == 2) $target = $_POST['target'];
	elseif($type == 3) $target = $Inf['organization'];
	
	$id = (isset($_POST['lastId'])) ? $_POST['lastId'] : 0;
	$id = $iChat->post($user, $message, $type, $target, $id);
}
elseif($mode == 'retrieve'){
	$id = (isset($_POST['lastId'])) ? $_POST['lastId'] : 0;
}

elseif($mode == 'clear'){
	$id = (isset($_POST['lastId'])) ? $_POST['lastId'] : 0;
	if($Inf['acc_status'] < 0){
		$iChat->clearMsg();
	}
}

else exit;

echo $iChat->retrieve($Inf, $id);


?>








