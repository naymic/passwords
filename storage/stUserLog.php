<?php

	
class stUserLog extends Model {
	/**
	 * _pk
	 */
	public $id = -1;
	/**
	 * _fk
	 * _table=User
	 */
	public $userId = -1;
	
	/**
	 * 
	 * @var unknown
	 */
	public $timestamp = '';



	public function __construct() {
		$this->setTableName ( 'UserLog' );
	}


	public function validation() {
		$this->timestamp = now();
		
		if (! is_numeric( $this->id () )) {
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
     * @return unknown
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param unknown $timestamp
     */
    public function setTimestamp( $timestamp)
    {
        $this->timestamp = $timestamp;
    }


}
	
	



