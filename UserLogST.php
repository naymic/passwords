<?php

class UserLogST extends Mapper{
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function insertSTItem($item){
		
		if($item == null){
			$item = $this->getPostSTItem();
		}
		
		$this->getDb()->query("INSERT INTO UserLog 
								(
									id,
									timestamp, 
									userId
								) 
							VALUES 
								(
									'". mysqli_real_escape_string($this->getDb(), $this->getIndex()) ."',
									'". mysqli_real_escape_string($this->getDb(), $item->getTimeNow()) ."',
									'". mysqli_real_escape_string($this->getDb(), $item->getUserId()) ."',				
								)");	
	}
	
	public function removeSTItem(){
		$this->getDb()->query("DELETE FROM UserLog WEHRE id = '". mysqli_real_escape_string($this->getDb(), $this->getIndex()));
	}
	
	public function updateSTItem($item){
		$this->getDb()->query("UPDATE UserLog SET
									timestamp = '". mysqli_real_escape_string($this->getDb(), $this->getTimeNow()) ."'
									userId = '". mysqli_real_escape_string($this->getDb(), $item->getUserId()) ."'		
								WHERE
									id = '". mysqli_real_escape_string($this->getDb(), $this->getIndex()) ."'
							");
	}
	
	public function getSTAll(){
		$array = array();
		
		$sql = $this->getDb()->query("SELECT id, timestamp, userId FROM UserLog WHERE 1");
		
		while($sql && $row = $sql->fetch_assoc()){
			$userLog = new UserLog();
			$userLog->setOID($row[id]);
			$userLog->setTimestamp($row[timestamp]);
			$userLog->setUserId($row[userId]);
			
			$array[] = $userLog;
		}
	
		return $array;
	}
	

	public function getSTItem(){
		
		$stmt = $this->getDb()->prepare("SELECT id, timestamp, userId FROM UserLog WHERE id = ?");
		$stmt->bind_param('i', $this->getIndex());
		$stmt->execute();
		$stmt->bind_result($id, $timestamp, $password);
		$stmt->fetch();
		$stmt->close();
	
		$user = new User();
		$user->setOID($id);
		$user->setTimestamp($username);
		$user->setUserId($password);
		$user->setLoggedin(false);
	
	
		return $user;
		
	}
	
	
	public function getPostSTItem() {
		$item = new Login ();
		
		$item->setOID ( $this->getIndex () );
		$item->setUserId ( $_POST ['userId'] );
		
		return $item;
	}
	
	
	
	
	
}



?>