<?php



Class Connect{
	
	private $con;
	private static $instance;
	
	
	protected function __clone() {}
	protected function __construct() {
		

		try{
			$this->setCon("localhost", "codes-extern", "123456", "codes-extern", "3306");
		}catch(Exception $e){
			new MError($e);
		}

	}
	
	
	public static function getInstance(){
		self::$instance = new static();
		return self::$instance;
	}
	
	
	//Set Connection
	private function setCon($host, $user, $password, $database, $port){
		$this->con = new mysqli($host, $user, $password, $database, $port);

		if ($this->con->connect_error) {
    		new MError('Connect Error (' . $this->con->connect_errno . ') '
            . $this->con->connect_error);
        }


		if (mysqli_connect_error()){
			new MError("Failed to connect to MySQL: " . mysqli_connect_error());
		}

	}
	
	//Get Connection
	public function getCon():mysqli{return $this->con;}
	
	
	public function query():mysqli_result{
		
		try{
			$sql = super.query();
		}catch(Exception $e){
			new MError($e);
		}
		return $sql;
	}

	
	
}


