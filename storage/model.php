<?php

abstract class Model{
	
	protected $tableName;
	
	
	
	/**
	 * Every Model child needs to know how to 
	 * validate his own variables
	 */
	public abstract function validation();
	
	

	public function existAtribute($classObject, $atributeName){
		$reflect = new ReflectionClass($classObject);
		$array   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
		
		foreach ($array as $value){
			if($value == $atributeName) {
                return true;
            }
		}
		
		return false;
	}
	
	/**
	 * In some cases is important to 
	 * verify if a user has access to data	 
	 *  
	 * @param  object $user	User class Object
	 * @return boolean 		[true = user has access | false = user has not access]
	 */
	protected  function verifyAccess($user){
		return true; 
	}
	
	
	public function setTableName($tableName){$this->tableName = $tableName;}
	public function getTableName(){return $this->tableName;}
	


	
	
	
}




