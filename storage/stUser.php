<?php

class stUser extends  Model{
		/**
	 * _pk
	 */
	public  $id;
	/**
	 * 
	 * @var unknown
	 */
	public	$username;
	/**
	 * 
	 * @var unknown
	 */
	public  $password;
	
	
	public function __construct(){
		$this->setTableName('User');
	}
	
	
	public function validation() {
		if (! is_string ( $this->getUsername () )) {
			return false;
			
		} else if (! is_string ( $this->getPassword () )) {
			return false;
			
		} else {
			return true;
			
		}
	}

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return unknown
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param unknown $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return unknown
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param unknown $password
     */
    public function setPassword(string $password)
    {
        if(strlen($password) < 20){
            $this->password = crypt($password);
        }else {
            $this->password = $password;
        }
    }



}

?>