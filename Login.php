<?php
	
class Login extends Person{
	

	private $description;
	private $link;
	private $userId;
	
	public function __construct(){
		parent::__construct("LOGIN");
	}
	
	public function cryptPassword($password){
		$crypt = new CryptPass();
		return $crypt->crypt($password);
	}
	
	public function unCryptPassword($password){
		$crypt = new CryptPass();
		return $crypt->unCrypt($password);
	}	
	
	
	//sets
	public function setDescription($description){$this->description = $description;}
	public function setLink($link){$this->link = $link;}
	public function setUserId($userId){$this->userId = $userId;}
	
		
	//gets
	public function getDescription(){return $this->description;}
	public function getLink(){return $this->link;}
	public function getUserId(){return $this->userId;}
	
	
}





?>