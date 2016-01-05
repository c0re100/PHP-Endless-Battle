<?php
//php-eb UE Behavior Checker Object
//Include Once Only

define("INSOMNIA_TIME", 10800);
define("ADDICT_TIME", 21600);

class BehaviorChecker {

	var $SFO;      // player_stats object
	var $Behavior; // Behavior MySQL Object
	var $BtlIntvl; // Battle Interval
	var $TOffline; // Offline Time Interval
	var $CFU_Time; // CFU_Time
	var $DBPrefix; // DB Prefix
	var $nowVFlag; // Victory Flag
	
	function __construct($SFO, $bIntvl, $nowVictoryFlag, $TimeOffline, $ctime, $DB_Prefix){
		$this->SFO = $SFO;
		$this->BtlIntvl = $bIntvl;
		$this->nowVFlag = $nowVictoryFlag;
		$this->TOffline = $TimeOffline;
		$this->CFU_Time = $ctime;
		$this->DBPrefix = $DB_Prefix;
		$this->getBehavior();
	}
	
	function getBehavior(){
		$sql = "SELECT `last_vflag`, `last_btime`, `last_rtime`, `blitz_count`, `rblitz_count`, `last_login`, `time_state`, `insomnia_count`, `addict_count`, `online_record` FROM `{$this->DBPrefix}phpeb_behaviour_check` WHERE `username` = '{$this->SFO->User}'; ";
		$query = mysql_query($sql) or die('Behavior fetch error.');
		
		if(mysql_num_rows($query) == 0){
			$sqlf = "INSERT INTO `{$this->DBPrefix}phpeb_behaviour_check` (`username`, `last_login`) VALUES ('%s',%d)";
			$query = mysql_query(sprintf($sqlf, $this->SFO->User, $this->CFU_Time)) or die('Behavior Checker Error!');
			$this->getBehavior();
			return;
		}
		
		$this->Behavior = mysql_fetch_object($query);
	}
	
	function checkRationalBattle(){
		if($this->Behavior->last_vflag != 0){
			if($this->SFO->Player['btltime'] - $this->Behavior->last_btime <= $this->BtlIntvl) $this->Behavior->blitz_count ++;
		}
		if( time() == $this->Behavior->last_rtime) $this->Behavior->rblitz_count ++;
		$this->updateBlitz();
	}

	function checkInsomnia(){
		if($this->CFU_Time - $this->Behavior->last_btime < $this->TOffline){
			$T_Interval = $this->CFU_Time - $this->Behavior->last_login;
			if($T_Interval > ADDICT_TIME && $this->Behavior->time_state == 0){
				$this->Behavior->addict_count ++;
				$this->updateAddict();
			}
			elseif($T_Interval > INSOMNIA_TIME && $this->Behavior->time_state == 1){
				$this->Behavior->insomnia_count ++;
				$this->updateInsomnia();
			}
			if($T_Interval > $this->Behavior->online_record){
				$this->Behavior->online_record = $T_Interval;
				$this->updateOnlineRecord();
			}
		}
		else{
			$this->updateLogin($this->CFU_Time);
		}
	}

	function updateRTime(){
		$sql = "UPDATE `{$this->DBPrefix}phpeb_behaviour_check` SET `last_rtime` = {$this->CFU_Time} WHERE `username` = '{$this->SFO->User}';";
		$query = mysql_query($sql) or die('Behavior Checker Error! Cannot Update RTime!');
	}

	function updateBlitz(){
		$sql = "UPDATE `{$this->DBPrefix}phpeb_behaviour_check` SET `last_vflag` = {$this->nowVFlag}, `last_btime` = {$this->SFO->Player['btltime']}, `last_rtime` = {$this->CFU_Time}, `blitz_count` = {$this->Behavior->blitz_count}, `rblitz_count` = {$this->Behavior->rblitz_count} WHERE `username` = '{$this->SFO->User}';";
		$query = mysql_query($sql) or die('Behavior Checker Error! Cannot Update Blitz!');
	}
	
	function updateInsomnia(){
		$sql = "UPDATE `{$this->DBPrefix}phpeb_behaviour_check` SET `insomnia_count` = {$this->Behavior->insomnia_count}, `time_state` = 1 WHERE `username` = '{$this->SFO->User}';";
		$query = mysql_query($sql) or die('Behavior Checker Error! Cannot Update Insomnia!');
	}

	function updateAddict(){
		$sql = "UPDATE `{$this->DBPrefix}phpeb_behaviour_check` SET `addict_count` = {$this->Behavior->addict_count}, `time_state` = 2 WHERE `username` = '{$this->SFO->User}';";
		$query = mysql_query($sql) or die('Behavior Checker Error! Cannot Update Addict!');
	}
	
	function updateOnlineRecord(){
		$sql = "UPDATE `{$this->DBPrefix}phpeb_behaviour_check` SET `online_record` = {$this->Behavior->online_record} WHERE `username` = '{$this->SFO->User}';";
		$query = mysql_query($sql) or die('Behavior Checker Error! Cannot Update Online Record!');
	}

	function updateLogin($ltime){
		if($ltime == 0) $ltime = $this->CFU_Time;
		$sql = "UPDATE `{$this->DBPrefix}phpeb_behaviour_check` SET `last_login` = {$ltime}, `time_state` = 0 WHERE `username` = '{$this->SFO->User}';";
		$query = mysql_query($sql) or die('Behavior Checker Error! Cannot Update Login!');
	}

}
?>