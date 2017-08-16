<?php

Class LoginST extends Mapper{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function insertSTItem($item){
		
		
		if($item == null){
			$item = $this->getPostSTItem();
		}
		
		$sql = "INSERT INTO Login 
									(
										id,
										username, 
										password, 
										description, 
										link, 
										userId
									)
							   VALUES  
									(
										'". mysqli_real_escape_string($this->getDb(), $this->getNextIndex()) ."',
										'". mysqli_real_escape_string($this->getDb(), $item->getUsername()) ."',
										'". mysqli_real_escape_string($this->getDb(), $item->cryptPassword($item->getPassword())) ."',	
										'". mysqli_real_escape_string($this->getDb(), $item->getDescription()) ."',
										'". mysqli_real_escape_string($this->getDb(), $item->getLink()) ."',
										'". mysqli_real_escape_string($this->getDb(), $item->getUserId()) ."'
												  
									 )";
		
		//echo "<br>" .$sql;
		$this->getDb()->query($sql);
	}
	
	public function removeSTItem(){
		$this->getDb()->query("DELETE FROM Login WHERE id='". mysqli_real_escape_string($this->getDb(), $this->getIndex()) ."' ");
	}
	
	public function updateSTItem($item){
	
		$sql = "UPDATE Login SET
									username = '". mysqli_real_escape_string($this->getDb(), $item->getUsername()) ."',
									password = '". mysqli_real_escape_string($this->getDb(), $item->cryptPassword($item->getPassword())) ."',
									description = '". mysqli_real_escape_string($this->getDb(), $item->getDescription()) ."',
									link = '". mysqli_real_escape_string($this->getDb(), $item->getLink()) ."',
									userId = '". mysqli_real_escape_string($this->getDb(), $item->getUserId()) ."'	
							   WHERE id ='". mysqli_real_escape_string($this->getDb(), $this->getIndex()) ."'
							  ";
					   		
		//echo "<br>". $sql ."<br>";
		$this->getDb()->query($sql);
	}
	
	public function getSTAll(){
		$array = array();
		
		
		$query = "SELECT id, username, password, description, link, userId FROM Login " . $this->getFilter();
		//echo "<br>".$query;
		$sql = $this->getDb()->query($query);
		
		
		while($row = $sql->fetch_assoc()){
			
			$login = new Login();
			$login->setOID($row['id']);
			$login->setUsername($row['username']);
			$login->setPassword($login->unCryptPassword($row['password']));
			$login->setDescription($row['description']);
			$login->setLink($row['link']);
			$login->setUserId($row['userId']);
				
			$array[] = $login;
		}
		
	
		return $array;
	}
	
	public function getSTItem(){
		$sql = $this->getDb()->query("SELECT id, username, password, description, link, userId FROM Login WHERE id= '". mysqli_real_escape_string($this->getDb(), $this->getIndex()) ."' ");
		$row = $sql->fetch_assoc();
		
		$login = new Login();
		$login->setOID($row['id']);
		$login->setUsername($row['username']);
		$login->setPassword($login->unCryptPassword($row['password']));
		$login->setDescription($row['description']);
		$login->setLink($row['link']);
		$login->setUserId($row['userId']);
		
		return $login;
	}
	
	
	public function getPostSTItem() {
		$item = new Login ();
		
		$item->setOID ( $this->getIndex() );
		$item->setUsername ( $_POST ['username'] );
		$item->setPassword ( $_POST ['password'] );
		$item->setDescription ( $_POST ['description'] );
		$item->setLink ( $_POST ['link'] );
		$item->setUserId ( $_POST ['userId'] );
		
		//var_dump($item);
		
		return $item;
	}
	
	
}


?>