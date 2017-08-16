<?php


class Person extends  ItemToStore{
	protected $username;
	protected $password;
	
	//Sets
	public function setUsername($username){$this->username = $username;}
	public function setPassword($password){$this->password = $password;}
	
	//Gets
	public function getUsername(){return $this->username;}
	public function getPassword(){return $this->password;}
}


class User extends Person{
	

	private $loggedin;
	private $failedLogin;

	
	public function __construct(){
		parent::__construct("USER");
	}
	
	public function logout(){
		$_SESSION["user"] = array("username"=>NULL,
				"password"=>NULL,
				"id"=>NULL,
				"loggedin"=>false);
		header("Location: index.php?page=login");

		
		$this->setOID(null);
		$this->setPassword(null);
		$this->setUsername(null);
		$this->setLoggedin(false);
	}
	
	
	public function login($username, $password){
		//Check Login
		if(($id = $this->checkUser($username, $password)) != false){
				
			//echo "<br>Functionou". $id;
			
			//Make the Log
			$userLog = new UserLog();
			$userLog->setUserId($id);
			Control::getInstance()->getStore()->insert("UserLog", $userLog);
			
			//Set Cookie
			$_SESSION["user"] = serialize(array("id"=>$id, "loggedin"=>true, "time"=> time() + 60*5));
			
			
			header("location: index.php");
		}else{
			$this->setFailedLogin(true);
			$_SESSION["user"] = serialize(array("id"=>NULL,"loggedin"=>false, "time"=> time() + 60*5));
		}
		
		
		$this->authUser();	
	}
	
	/**
	 * Authenticate User all the time
	 */
	public function authUser(){
		//Check all the time if user is loggedin
		if(isset($_SESSION['user']) or $this->getFailedLogin()){
			if($this->checkSession($_SESSION['user'])){
				return true;
			}
		}
		
		
		return false;
	}
	
	
	private function checkSession($session) {
		$userArray = unserialize ( $session );
		
		if (time () > $userArray ['time'] || ! $userArray ['loggedin']) {
			$this->setOID ( NULL );
			$this->setLoggedin ( false );
			return false;
		} else {
			
			$this->setOID ( $userArray ['id'] );
			$this->setLoggedin ( true );
			$this->setFailedLogin ( false );
			
			return true;
		}
	}
	
	
	private function checkUser($username, $password){
		$users = Control::getInstance()->getStore()->getAll("USER");
		
		foreach($users as $key => $value){
			
			//echo "<br>OID USER:". $value->getOID();
			//echo "<br>" .crypt($password, $value->getPassword()) .  "  <br>" . $value->getPassword();
			//echo "<br>U1" . $username .  "  <br>U2" . $value->getUsername();
			
			if(crypt($password, $value->getPassword()) == $value->getPassword() && $value->getUsername() == $username){				
				return $value->getOID();
			}
		}
		

		return false;
	}
	
	/**
	 * Function to crypt a password
	 * @param 	string $password
	 * @return 	string 			
	 */
	public static function cryptPassword($password){
		return crypt($password);

	}
	
	/**
	 * Return an array with the userinformations
	 */
	public function userInfo(){
		
		$user = array();
		$user[loggedin] = $this->loggedin;
		$user[username] = $this->username;
		$user[password] = $this->username;
		
		return $user;		
	}
	
	
	/**
	 * Check if contet ist available for user
	 * $page string Name of the page
	 * $user object	Object of the user
	 */
	public function checkContent($page){
	
		if($page == 'signup'){
			return $page;
		}else if(!$this->getLoggedin()){
			return 'login';
		}else if($this->getLoggedin() == true){
			return 'main';
		}else{
			return true;
		}
	
	
	}
	
	
	//Sets
	public function setLoggedin($loggedin){$this->loggedin = $loggedin;}
	public function setFailedLogin($failedLogin){$this->failedLogin = $failedLogin;}
	
	//Gets
	public function getLoggedin(){return $this->loggedin;}
	public function getFailedLogin(){return $this->failedLogin;}
	
}

