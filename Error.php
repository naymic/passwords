<?php

/**
 * 
 * @author naymic
 *
 * Class for preparing Error messages
 */
class MError {
	
	/**
	 * @param string $e	String of the error description
	 */
	function __construct($e) {
		//AdapterVision::getInstance()->sendError($e);
		die($e);
		//exit ( "" );
	}
}

?>