<?php

class UserLog extends ItemToStore{
	
	private $timestamp;
	private $userId;
	
	
	public function __construct(){
		parent::__construct("USERLOG");
	}
	
	//sets
	public function setTimestamp($timestamp){$this->timespamp = $timestamp;}
	public function setUserId($userId){$this->userId = $userId;}
	
	
	//gets
	public function getTimestamp(){return $this->timestamp;}
	public function getUserId(){return $this->userId;}
	public function getTimeNow(){return time();} 
	
	
}




?>