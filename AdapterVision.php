<?php

class AdapterVision{
	
	private static $instance;
	private $vision;
	
	protected function __clone() {}
	
	protected function __construct() {
		$this->setVision(Vision::getInstance());		
	}
	
	public static function getInstance(){
		if(null === self::$instance){
			self::$instance = new static();
		}
	
		return self::$instance;
	}
	
	public function sendError($e){
		$this->getVsion()->getPage()->printError ($e);
	}
	
	public function showPage(){
		$this->getVision()->showPage();
	}
	
	
	
	//Sets
	public function setVision($vision){$this->vision = $vision;}
	
	//Gets
	public function getVision(){return $this->vision;}
	
}


?>