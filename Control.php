<?php



class Control{
	
	private $page;
	private $user;
	private $store;
	private $dao;
	private $errorMsg = array();
	var $int;
	
	private static $instance;
	
	protected function __clone() {}
	
	protected function __construct() {
		
		$this->setPage(new Page());
		$this->setUser(new User());
		$this->setStore(new Store());
		$this->setDao(new DAO());
		
	}
	
	public static function getInstance(){
		if(null === self::$instance){
			self::$instance = new static();
		}
	
		return self::$instance;
	}
	
	
	//Adds
	public function addErrorMsg($errorMsg){$this->errorMsg[] = $errorMsg;}
	
	//Sets
	private function setPage($page){$this->page = $page;}
	private function setUser($user){$this->user = $user;}
	private function setStore($store){$this->store = $store;}
	private function setDao($dao){$this->dao = $dao;}
	
	//Gets
	public function getPage(){return $this->page;}
	public function getUser(){return $this->user;}
	public function getStore(){return $this->store;}
	public function getErrorMsg(){return $this->errorMsg;}
	public function getDao(){return $this->dao;}
	
	

	public function actions($action, $class, $id, $username='', $password=''){
		$item = NULL;
		
		if(isset($class) && strlen($class) > 0 ){
			$item = new $class();
		
			if(isset($id))
				$item->id = $id;
			
		}
		
		switch($action){
			
			case "save":
				
				$item = $this->getDao()->getPostItem($class);
				//var_dump($item);

				//echo "<br>ac Save: 1";
				if ($id) {
					$this->getDao ()->update ( $item );
				} else {
					//echo "<br>ac Save: 2<br>";
					
					$this->getDao ()->insert ($item );
				}
				
				
				$item = null;
				header("location: index.php");
				break;
			case "update":
                $item = $this->getDao()->select($item);
				break;
			
			case "delete":
				if($class == 'stLogin'){
					
					$item = $this->getDao()->select($item);
					
					if($item->userId == $this->getUser()->getOID()){
						$this->getDao()->delete($item);
						
					}else{
						new MError("This action is not allowed.!!");
					}
				}
				$item = null;
				header("location: index.php");
				break;
				
			case "logout":
				$this->getUser()->logout();
				
			case "login" :
				$this->getUser()->login($username, $password);
				
	
				break;
		}
		
		//Clean all POST Vars
		foreach ($_POST as $key => $value){
			$_POST[$key] = "";
		}
		
		return $item;
		
	}
	
	
	
	
	
	
}





?>