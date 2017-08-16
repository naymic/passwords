<?php
class CryptPass {
	private static $max_password = 40;
	private static $max_position = 36;
	private static $min_ascii = 1;
	private static $max_ascii = 255;
	
	
	public function crypt($password) {
		$crypted_pass = "";
		
		// Total lenght of the password
		$pw_lenght = strlen ( $password );
		
		// Fix number for by numbers
		$fix_number = $this->getNumberInAsciiRange ( pow ( 3, $pw_lenght ) );
		
		// Fix number for odd numbers
		$fix_number2 = rand ( 1, 9 );
		
		// Crypt the Password until ends
		for($i = 0; $i < $pw_lenght; $i ++) {
			// Get Actual char for change
			$charAtPos = $this->charAt ( $password, $i );
			
			// True = by //False = odd
			if ($i % 2 == 0) {
				$crypted_pass .= chr ( $this->getNumberInAsciiRange ( ord ( $charAtPos ) + $fix_number ) );
			} else {
				$crypted_pass .= chr ( $this->getNumberInAsciiRange ( ord ( $charAtPos ) + ($i + 1) * $fix_number2 ) );
			}
		}
		
		// Add some random chars until the max_lenght
		for(; $i <= CryptPass::$max_position; $i ++) {
			$crypted_pass .= $this->randomChar ();
		}
		
		// Add at pos 37 the fix number for odd numbers
		$crypted_pass .= $fix_number2;
		
		$temp = $pw_lenght * 3;
		
		if ($temp < 10) {
			$crypted_pass .= "0" . $temp;
		} else {
			$crypted_pass .= $temp;
		}
		
		return $crypted_pass;
	}
	
	public function unCrypt($crypted_pw) {
		$uncrypted_pw = "";
		
		$pw_lenght = intval ( substr ( $crypted_pw, strlen ( $crypted_pw ) - 2, 2 ) ) / 3;
		
		$fix_number = $this->getNumberInAsciiRange ( pow ( 3, $pw_lenght ) );
		$fix_number2 = $this->charAt ( $crypted_pw, strlen ( $crypted_pw ) - 3 );
		
		// Crypt the Password until ends
		for($i = 0; $i < $pw_lenght; $i ++) {
			// Get Actual char for change
			$charAtPos = $this->charAt ( $crypted_pw, $i );
			
			// True = by //False = odd
			if ($i % 2 == 0) {
				
				$uncrypted_pw .= chr ( $this->getAsciiNumberBack ( ord ( $charAtPos ) - $fix_number ) );
			} else {
				
				$uncrypted_pw .= chr ( $this->getAsciiNumberBack ( ord ( $charAtPos ) - ($i + 1) * $fix_number2 ) );
			}
		}
		
		return $uncrypted_pw;
	}
	
	
	private function getNumberInAsciiRange($numb ){
		
		$numb1 = (($numb % (CryptPass::$max_ascii - CryptPass::$min_ascii) ) + CryptPass::$min_ascii);
		
		return $numb1;
	}
	
	private function getAsciiNumberBack($numb ){
		$numb = $numb - CryptPass::$min_ascii;
		
		while($numb <= CryptPass::$min_ascii){
			$numb += CryptPass::$max_ascii - CryptPass::$min_ascii ;
			
		}

		return $numb;
	}
	
	private function getAscii($number) {
		return chr($number);
	}
	
	
	private function charAt($string, $pos) {
		return substr ( $string, $pos, 1 );
	}
	
	private function randomChar(){
		return chr(rand(CryptPass::$min_ascii, CryptPass::$max_ascii));
	}
}
?>