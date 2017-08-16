<?php
class stLogin extends Model {
	/**
	 * _pk
	 */
	public $id = -1;
	public $link = '';
	
	/**
	 * _crypt
	 */
	public $password = '';
	/**
	 * _fk
	 * _table=User
	 */
	public $userId = -1;
	public $username = '';
	
	public $description;
	
	
	public function __construct() {
		$this->setTableName ( 'Login' );
	}
	
	
	public function validation() {
		if (! is_string ( $this->link () )) {
			return false;
		} else if (! is_string ( $this->password () )) {
			return false;
		} else if (! is_string ( $this->username () )) {
			return false;
		} else if (! is_numeric( $this->id () )) {
			return false;
		}else if (! is_numeric( $this->userId() )) {
			return false;
		}   else {
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
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link)
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}

