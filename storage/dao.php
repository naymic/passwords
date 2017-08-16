<?php


class DAO extends ReflectionClass{


	protected  $db;
	protected  $classObject;
	
	/**
	 * Class constructor
	 * ->set database 
	 */
	public function __construct(){
		$this->setDb(Connect::getInstance()->getCon());
	}
	
	
	/**
	 * Get class object
	 */
	private function getClassObject(){return $this->classObject;}
	/**
	 * Get database object
	 */
	public function getDb():mysqli{return $this->db;}
	
	/**
	 * Set the class object
	 * @param unknown $classObject
	 */
	private function setClassObject($classObject){
		parent::__construct($classObject);
		$this->classObject = $classObject;
	}
	
	/**
	 * Set the database object
	 * @param unknown $db
	 */
	private function setDb($db){$this->db = $db;}
	
	
	
	/**
	 * Insert function
	 * @param Model::inheritence $classObject
	 */
	public function insert($classObject){
		$this->setClassObject($classObject);
		$array   = $this->getProperties();
		$colums = "";
		$values = "";
		
		
		//Set Colums and values
		foreach($array as $value){

			$this->toCrypt($value->getName());
			
			if(!$this->isPK($value->getName())){
				$colums .= " ".$value->getName() .",";
				$values .= " '". trim(mysqli_real_escape_string($this->getDb(), $this->getPropertyValue($value->getName()))) ."',";
			}
		}
		
		$colums = $this->cutEnd($colums, ',');
		$values = $this->cutEnd($values, ',');
		
		
		$query = "INSERT INTO ". $classObject->getTableName() ."(". $colums .") VALUES (". $values .")";
		

		if(!$this->getDb()->query($query)){
			throw new Error($this->getDb()->error . "<br>". $query);
		}

		
	}
	
	/**
	 * Update a row in a table
	 * @param Model::inheritence $classObject
	 * @param string $whereFilter
	 */
	public function update($classObject, $whereFilter = ''){
		$this->setClassObject($classObject);
		$array   = $this->getProperties();
		$query = '';
		$sets = "";
		$where = "";
		
		//Set Colums and values
		foreach($array as $value){
			
			$this->toCrypt($value->getName());
			
			if(!$this->isPK($value->getName())){
				$sets .= " ".$value->getName() ."='". trim(mysqli_real_escape_string($this->getDb(), $this->getPropertyValue($value->getName()))) ."',";
			}else{
				$where .= " ".$value->getName() ."=  '".mysqli_real_escape_string($this->getDb(), $this->getPropertyValue($value->getName())) ."' AND";
			}
		}
		
		//Remove "," and "AND" at the end
		$sets = $this->cutEnd($sets, ',');
		$where = $this->cutEnd($where, 'AND');
		
		//Check if a filter is set
		$where = $this->checkWhere($where, $whereFilter);
		
		
		$query = "UPDATE ". $classObject->getTableName() ." SET ". $sets ." WHERE ". $where;
		if(!$this->getDb()->query($query)){
			new Error($this->getDb()->error . "<br>". $query);
		}
		
	}
	
	/**
	 * Delete a row in a table with pk set in the object
	 * @param Model::inheritence $classObject
	 * @param string $whereFilter
	 */
	public function delete($classItem, $whereFilter = ''){
		$this->setClassObject($classItem);
		
		$array   = $this->getProperties();
		$query = '';
		$sets = "";
		$where = "";
		
		//Set Colums and values
		foreach($array as $value){
			if($this->isPK($value->getName())){
				$where .= " ".$value->getName() ."=  '".mysqli_real_escape_string($this->getDb(), $this->getPropertyValue($value->getName())) ."' AND";
			}
		}
		
		//Remove AND at the end
		$where = $this->cutEnd($where, 'AND');
		
		//Check if a filter is set
		$where = $this->checkWhere($where, $whereFilter);
		
		$query .= "DELETE FROM ". $this->getClassObject()->getTableName() ." WHERE ". $where;
		echo $query;
		if(!$this->getDb()->query($query)){
			new Error($this->getDb()->error . "<br>". $query);
		}
	}
	
	/**
	 * Select a row and return a object
	 * @param Model::inheritence $classObject
	 * @param string $wherefilter
	 */
	public function select($classObject, $wherefilter=''){
		$this->setClassObject($classObject);
		
		
		$array   = $this->getProperties();
		$where = "";
		
		//Set Colums and values
		foreach($array as $value){
			if($this->isPK($value->getName())){
				$where .= " ".$value->getName() ."= '".mysqli_real_escape_string($this->getDb(), $this->getPropertyValue($value->getName())) ."' AND";
			}
		}
		
		//Remove , and AND at the end
		$where = $this->cutEnd($where, 'AND');
		
		//Check if a filter is set
		$where = $this->checkWhere($where, $wherefilter);
		
		$query = "SELECT * FROM ". $this->getClassObject()->getTableName() ." WHERE ". $where ." ";
		
		if ($result = $this->getDb ()->query ( $query )) {
			
			while ( $row = $result->fetch_assoc () ) {
				$object = $this->selectObject ( $row );
			}
		} else {
			new Error ( $this->getDb ()->error . "<br>" . $query );
			return false;
		}
		
		return $object;
		
	}
	
	/**
	 * Select multiple rows and return a array of object
	 * @param Model::inheritence $classObject
	 * @param string $whereFilter
	 */
	public function selectAll($className, $wherefilter = '') {
		$this->setClassObject(new $className());
		$where = " 1";
		$objectArray = array ();
		
		// Check if a filter is set
		$where = $this->checkWhere ( $where, $wherefilter);
		
		$query = "SELECT * FROM " . $this->getClassObject()->getTableName () . " WHERE " . $where . " ";
		
		if ($result = $this->getDb ()->query ( $query )) {
			
			while ( $row = $result->fetch_assoc () ) {
				$objectArray [] = $this->selectObject ( $row );
			}
		} else {
			new Error ( $this->getDb ()->error . "<br>" . $query );
			return false;
		}
		
		return $objectArray;
	}

	

	/* ###
	 * Query Helper Methods
	 */
	
	/**
	 * Method implemented but foreign keys -> not used at 
	 * the moment
	 */
	private function checkForeignKeys(){
		
		foreach($this->getClassObject()->getForeignKeys() as $fk){
			if(strlen($fk['fkTable']) && !$this->checkForeignKey($fk['fkTable'], $fk['atributeName'], $fk['value'])){
				new Error("Foreign Key ". $fk['atributeName'] . " at table " . $fk['fkTable'] . " with value " . $fk['value'] ." doesn't exist.");
				return false;
			}
		}
		
		return true;
		
	}
	
	private function checkForeignKey($table, $columnName, $varValue){
		$db = $this->getDb();
		$query = "SELEC null FROM ". mysqli_real_escape_string($db, $table) ." WHERE ". mysqli_real_escape_string($db, $columnName) ." = '". mysqli_real_escape_string($db, $varValue) ."' ";
		
		$result = $db->query($query);
		
		return $result->num_rows() > 0;
	}
	
	private function cutEnd($string, $type){
		if($type == ','){
			$string = substr($string, 0, strlen($string)-1);
		}else if(strtolower($type) == 'and'){
			$string = substr($string, 0, strlen($string)-3);
		}
		
		return $string;		
	}
	
	/**
	 * Helper method to the sql filter
	 * @param string $where
	 * @param string $wherefilter
	 * @return string
	 */
	private function checkWhere($where, $wherefilter){
		if(strlen($wherefilter) > 0){
			$where = $wherefilter;
		}
	
		return $where;
	}
	
	
	/* ###
	 * Reflection Helper Methods
	 */
	
	/**
	 * Return the value of a atribute
	 * @param string $atributeName	Name of the atribute
	 * @return mixed 				Value of the atribute
	 * 
	 */
	private function getPropertyValue($propertyName){
        $methodName = 'get'.StringUtils::setFirstLetterToUpper($propertyName);
		return $this->getClassObject()->$methodName();
	}

	
	/**
	 * Is Variable a Primary Key?
	 */
	private function isPK($propertyName){
		return $this->helpDocIs($propertyName, '_PK');
	}
	
	/**
	 * Is Variable a Foreign Key?
	 */
	private function isFK($propertyName){
		return $this->helpDocIs($propertyName, '_FK');
	}
	
	/**
	 * Is Variable a Foreign Key?
	 */
	private function isCrypt($propertyName){
		return $this->helpDocIs($propertyName, '_CRYPT');
	}
	
	/**
	 * Helper Function to Find string in 
	 * PHP Documentation Text
	 * @param string $propertyName
	 * @param string $stringToFind
	 */
	private function helpDocIs($propertyName, $stringToFind){
		return is_numeric(strpos(strtolower($this->getProperty($propertyName)->getDocComment()), strtolower($stringToFind)));
	}
	
	/**
	 * Help to create a object of each row
	 * @param array 	$row 	Is a row of the fetch_assoc mysqli result
	 */
	private function selectObject($row) {
		$object = clone $this->getClassObject();
		
		
		foreach ( $row as $key => $value ) {
			
			if($this->isCrypt($key)){
				$cryp = new CryptPass();
				$value = $cryp->unCrypt($value);
			}
				
			$this->setObjectValue($object, $key, $value);
		}
		return $object;
	}

    private function toCrypt($valueName){
		if($this->isCrypt($valueName)){
			$crypt = new CryptPass();
			$this->setObjectValue($this->getClassObject(), $valueName, $crypt->crypt($this->getPropertyValue($valueName)));
		}
	}


    /**
     * Help to set Object Values
     * @param class $object
     * @param string $propertyName
     * @param mixed $value
     */
    private function setObjectValue($object, $propertyName, $value){

        $methodName = 'set'.StringUtils::setFirstLetterToUpper($propertyName);

        try {
            $object->$methodName($value);
        } catch ( ReflectionException $e ) {
            new Error ( $e->getMessage () );
        }

        return $object;
    }

    /**
	 * Return a array of all public properties
	 * {@inheritDoc}
	 * @see ReflectionClass::getProperties()
	 * @return array of all public properties
	 */
	public function getProperties($filter = Null){
		return parent::getProperties(ReflectionProperty::IS_PUBLIC);
	}
	
	
	
	public function getPostItem($className){
		$object = new $className();
		$this->setClassObject($object);

		$properties = $this->getProperties();
		
		foreach ($properties as $value) {
            if (isset($_POST[$value->getname()])) {
                //echo "<br>key". $value->getname() . " | Post". $_POST[$value->getname()];
                $this->setObjectValue($object, $value->getname(), $_POST[$value->getname()]);
            }else{
                $this->setObjectValue($object, $value->getname(), NULL);
            }
		}
		
		return $object;
	}
	

}


