<?php 



class TestPassCrypt extends \PHPUnit_Framework_TestCase{
	
	public function testCryption(){
		$pc = new PassCrypt();
		$testString = "!@#$%*()_-+=[]{}^;><|1234567890abcdefghijklmnopqrstuvvxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		
		$cryptedString = $pc->crypt($testString);
		
		$cryptedString = $pc->unCrypt($testString);
		
		$this->assertEqual($cryptedString, $testString);
	}
	
	
}



?>