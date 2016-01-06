<?php

require_once('config.php');

class iChat{
		
		private $DB;
		
		function __construct (){
			global $DBHost, $DBUser, $DBPass, $DBName;
			$this->DB = new mysqli($DBHost, $DBUser, $DBPass, $DBName);
			$this->DB->query("SET NAMES 'utf8'");
		}
		
		public function __destruct(){
			$this->DB->close();
		}
		
		public function post($user, $message, $type, $target, $id){
			global $DBPrefix,$iChatTable,$MaxChatEntries;

			$user = $this->DB->real_escape_string($user);
			$message = $this->DB->real_escape_string($message);
			$type = $this->DB->real_escape_string($type);
			$target = $this->DB->real_escape_string($target);
			
			if($type == 2){
				$userExists = $this->checkUser($target);
				if(!$userExists){
					include_once('ajax_xml.inc.php');
					$xml = new AjaxXML(new DOMDocument());
					$xml->createChild("entry");
					$xml->createChild("id","entry");
					$xml->addText($id,"id");
					$xml->createChild("name","entry");
					$xml->addText('System',"name");
					$xml->createChild("message","entry");
					$xml->addText('No user exists',"message");
					$xml->createChild("type","entry");
					$xml->addText(4,"type");
					$xml->createChild("target","entry");
					$xml->addText(0,"target");
					echo $xml->getXML();
					exit;
				}
			}
			
			$sql = 'INSERT INTO `'.$DBPrefix.$iChatTable.'` '
				. '(ic_user, ic_time, ic_message, ic_type, ic_target)'
				. sprintf('VALUES (\'%s\', %d, \'%s\', %d, \'%s\')',$user,time(),$message,$type,$target);
				
			$query = $this->DB->query($sql);
			if($id == -1){
				$sql = "SELECT `ic_id` FROM `".$DBPrefix.$iChatTable."` ORDER BY `ic_id` DESC LIMIT 1;";
				$query = $this->DB->query($sql);
				if($query->num_rows){
					$result = $query->fetch_array(MYSQLI_ASSOC);
					$id = $result['ic_id'];
					$query->close();
				}
			}
			return $id;
		}
		
		public function retrieve($Inf, $id=0){
			global $DBPrefix,$iChatTable, $MaxChatEntries;
			include_once('ajax_xml.inc.php');
			$xml = new AjaxXML(new DOMDocument());

			$id = $this->DB->real_escape_string($id);
			
			if($id > 0){
				$sql = "SELECT `ic_id`, `ic_user`, `ic_time`, `ic_message`, `ic_type`, `ic_target` "
						. "FROM `".$DBPrefix.$iChatTable."` WHERE `ic_id` > " . $id . " AND ("
							. " ( ic_type = -1 OR ic_type = 1  OR ic_type = 5 ) "
							. " OR "
							. " ( ic_type = 2 AND ( ic_user = '".$Inf['gamename']."' OR ic_target = '".$Inf['gamename']."') ) "
							. " OR "
							. " ( ic_type = 3 AND ic_target = '".$Inf['organization']."' ) "
						. ") ORDER BY `ic_id` ASC";

				$query = $this->DB->query($sql) or die();

				if($query->num_rows){
					while($messages = $query->fetch_array(MYSQLI_ASSOC)){
						$id = $messages['ic_id'];
						$xml->createChild("entry");
						
						$xml->createChild("id","entry");
						$xml->addText($id,"id");
						$xml->createChild("name","entry");
						$xml->addText($messages['ic_user'],"name");
						$xml->createChild("message","entry");
						if($messages['ic_type'] != 5)
							$xml->addText($messages['ic_message'],"message");
						else{
							$xml->addText($this->fetchHistory(),"message");
							$messages['ic_type'] = -1;
						}
						$xml->createChild("type","entry");
						$xml->addText($messages['ic_type'],"type");
						$xml->createChild("target","entry");
						$xml->addText($messages['ic_target'],"target");
						
						
					}
				}else{
					$sql = "SELECT `ic_id` FROM `".$DBPrefix.$iChatTable."` ORDER BY `ic_id` DESC LIMIT 1;";
					$query = $this->DB->query($sql) or die();
					$count = $query->fetch_array(MYSQLI_ASSOC);
					if($count["ic_id"] < $id){
						$xml->createChild("entry");
						$xml->createChild("id","entry");
						$xml->addText($count["ic_id"],"id");
						$xml->createChild("name","entry");
						$xml->addText('System',"name");
						$xml->createChild("message","entry");
						$xml->addText('&nbsp;',"message");
						$xml->createChild("type","entry");
						$xml->addText(0,"type");
						$xml->createChild("target","entry");
						$xml->addText(0,"target");
					}
				}
				if($id > $MaxChatEntries){
					$this->clearMsg(false);
				}
				$query->close();
			}
			else{
				global $Welcomer, $WelcomeMessage;
				$sql = "SELECT `ic_id` FROM `".$DBPrefix.$iChatTable."` ORDER BY `ic_id` DESC LIMIT 1;";
				$query = $this->DB->query($sql);

				if($query->num_rows){
					$messages = $query->fetch_array(MYSQLI_ASSOC);
					$xml->createChild("entry");
						
					$xml->createChild("id","entry");
					$xml->addText($messages['ic_id'],"id");
					$xml->createChild("name","entry");
					$xml->addText($Welcomer,"name");
					$xml->createChild("message","entry");
					$xml->addText($WelcomeMessage,"message");
					$xml->createChild("type","entry");
					$xml->addText(-1,"type");
					$xml->createChild("target","entry");
					$xml->addText(false,"target");
				}
				$query->close();
			}
			return $xml->getXML();
			
		}
		
		function clearMsg($returnXML = true){
			global $DBPrefix, $iChatTable, $Welcomer, $WelcomeMessage;
			
			$sql = "TRUNCATE TABLE `".$DBPrefix.$iChatTable."`;";
			$query = $this->DB->query($sql) or die();
			$sql = 'INSERT INTO `'.$DBPrefix.$iChatTable.'` '
				. '(ic_user, ic_time, ic_message, ic_type, ic_target)'
				. sprintf('VALUES (\'%s\', %d, \'%s\', %d, \'%s\')',$Welcomer,time(),$WelcomeMessage,-1,0);
			$query = $this->DB->query($sql);
			if($returnXML){
				include_once('ajax_xml.inc.php');
	
				$xml = new AjaxXML(new DOMDocument());
				$xml->createChild("entry");
				$xml->createChild("id","entry");
				$xml->addText(1,"id");
				$xml->createChild("name","entry");
				$xml->addText('System',"name");
				$xml->createChild("message","entry");
				$xml->addText('Messages Cleared',"message");
				$xml->createChild("type","entry");
				$xml->addText(-2,"type");
				$xml->createChild("target","entry");
				$xml->addText(0,"target");
				echo $xml->getXML();
				exit;
			}
		}
		
		// php-eb linkage functions

		function fetchUser($U,$P,$mode = 0){
			global $DBPrefix;
			$sql = "SELECT gen.username AS name, password, gamename, organization, acc_status ".
					"FROM `".$DBPrefix."phpeb_user_general_info` `gen`, `".
					$DBPrefix."phpeb_user_game_info` `game` WHERE gen.username='". $U ."' AND gen.username = game.username";
			$query = $this->DB->query($sql) or die();
			$user = $query->fetch_array(MYSQLI_ASSOC);

			if (!$user['name'] || ($user['password'] != md5($P) && $user['password'] != $P) || $user['name'] != $U){
				if($mode != 'retrieve' || $mode != 'send'){
					echo "使用者名稱或密碼錯誤。";
				}
				exit;
			}
			return $user;
		}
		
		function checkUser($gamename){
			global $DBPrefix;
			$sql = "SELECT gamename FROM `".$DBPrefix."phpeb_user_game_info` WHERE gamename = '".$gamename."' Limit 1;";
			$query = $this->DB->query($sql) or die();
			if($query->num_rows) return true;
			else return false;
		}
		
		function fetchHistory(){
			global $DBPrefix;
			$sql = "SELECT `history` AS `entry` FROM `".$DBPrefix."phpeb_game_history` ORDER BY `time` DESC LIMIT 1";
			$query = $this->DB->query($sql) or die();
			$history = $query->fetch_array(MYSQLI_ASSOC);
			if($query->num_rows) return $history['entry'];
			else return 'Error';
		}
	
}

?>