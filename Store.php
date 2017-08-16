<?php


class Store{
	
	private $mapper;
	
	public function __construct(){
		$this->setMapper(new Hashtable());		
		$this->getMapper()->put("user", new UserST());
		$this->getMapper()->put("login", new LoginST());
		$this->getMapper()->put("userlog", new UserLogST());
	}
	
	//Sets 
	private function setMapper($mapper){$this->mapper = $mapper;}
	
	//Gets
	public function getMapper(){return $this->mapper;}
	

	//Storage Functions
	
	public function insert($class, $item=null){
		return	$this->getMapper()->get($class)->insert($item);
	}
	
	public function remove($class, $id){
		return $this->getMapper()->get($class)->remove($id);
	}
	
	public function get($class, $id){
		return $this->getMapper()->get($class)->getItem($id);
	}
	
	public function getPost($class){
		return $this->getMapper()->get($class)->getPostItem();
	}
	
	public function getAll($class, $filter = " Where 1"){
		
		return $this->getMapper()->get($class)->getAll($filter);
	}
	
	public function update($class, $item){
		return $this->getMapper()->get($class)->update($item);
	}

}