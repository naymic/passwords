<?php

class ItemToStore {
	protected $class;
	protected $oid;
	public function __construct($class) {
		$this->setClass ( $class );
	}
	
	// Sets
	public function setOID($oid) {
		$this->oid = $oid;
	}
	
	protected function setClass($class) {
		if (MClasses::checkClass ( $class )) {
			$this->class = $class;
		}
	}
	
	// Gets
	public function getOID() {
		return $this->oid;
	}
	
	public function getClass() {
		return $this->class;
	}
}

?>