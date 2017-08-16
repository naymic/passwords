<?php

Class Hashtable{
	
	var $array = array();
	
	public function get($key){
		$key = strtolower($key);
		return $this->array[$key];
	}
	
	public function put($key, $value){
		$key = strtolower($key);
		$this->array[$key] = $value;
	}
	
	public function delete($key){
		$key = strtolower($key);
		unset($this->array[$key]);
	}	
	
}



?>