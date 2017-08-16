<?php
	
class UserST extends Mapper{
	
	
	
	public function __construct(){
		parent::__construct();
	}
	
	public function insertSTItem($item){
		
		if($item == null){
			$item = $this->getPostSTItem();
		}
		
		$sql = "INSERT INTO User 
								(id, 
								username, 
								password) 
							  VALUES (
								'". mysqli_real_escape_string($this->getDb(), $this->getIndex()) ."',
								'". mysqli_real_escape_string($this->getDb(), $item->getUsername()) ."', 
								'". mysqli_real_escape_string($this->getDb(), crypt($item->getPassword())) ."')
							  ";
		//echo $sql;
		$this->getDb()->query($sql);
		
		return true;
	}
	
	public function removeSTItem(){
		$this->getDb()->query("DELETE FROM User WHERE id ='". mysqli_real_escape_string($this->getDb(), $this->getIndex()));
		
		return true;
	}
	
	public function updateSTItem($item){
		$this->getDb()->query("UPDATE User SET  
									username='". mysqli_real_escape_string($this->getDb(), $item->username) ."', 
									password='". mysqli_real_escape_string($this->getDb(), $item->password) ."' 
							   WHERE id='". mysqli_real_escape_string($this->getDb(), $this->getIndex()) ."'
							 ");
		return true;
	}
	
	public function getSTAll(){
		$array = array();
		
		$sql = $this->getDb()->query("SELECT id, username, password FROM User Where 1");
		try{
		while($row = $sql->fetch_assoc()){
			$user = new User();
			$user->setOID($row['id']);
			$user->setUsername($row['username']);
			$user->setPassword($row['password']);
			$user->setLoggedin(false);
			
			$array[] = $user;
		}
		}catch(Exception $e){
			new MError($e);
		}
	
		
		return $array;
	}
	
	public function getSTItem(){


		$stmt = $this->getDb()->prepare("SELECT id, username, password FROM User WHERE id = ?");
		$stmt->bind_param('i', $this->getIndex());
		$stmt->execute();
		$stmt->bind_result($id, $username, $password);
		$stmt->fetch();
		$stmt->close();
		
		
		
		$user = new User();
		$user->setOID($id);
		$user->setUsername($username);
		$user->setPassword($password);
		$user->setLoggedin(false);
		
		
		return $user;
	}
	
	
	public function getPostSTItem() {
		$item = new User ();
		
		$item->setOID ( $this->getIndex() );
		$item->setUsername ( $_POST ['username'] );
		$item->setPassword ( $_POST ['password'] );
		$item->setLoggedin ( false );
		
		return $item;
	}
	
	
}

?>