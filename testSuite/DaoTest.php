<?php
use PHPUnit\Framework\TestCase;
include_once 'index.php';

/**
 * Created by PhpStorm.
 * User: micha
 * Date: 16/07/17
 * Time: 11:06
 */
class DaoTest extends TestCase{

    public function testDaotest(){

        $test = true;
        $className = 'stUser';

        $stUser = new $className();
        print_r($stUser);

        $stUser->password = "123456";
        $stUser->username = "test1";

        $dao = new Dao();
        $dao->getDb()->begin_transaction();

        try {
            $dao->insert($stUser);


        }catch (Error $e){
            print_r($e);
            $test =false;
        }
        $this->assertTrue($test);

        $dao->getDb()->rollback();
    }
}
