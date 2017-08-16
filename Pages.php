
<?php
class Page {
	

	
	public function __construct() {
		$this->path ="./templates/";
		$this->checkExistence();
	}
	

	
	var $path;
	var $title;
	var $head;
	
	var $header;
	var $menu;
	

	
	
	
	public function getTemplate($filename, $array = null) {
		$filename = strtolower($filename);
		if ($this->checkTemplateExistence ( $filename )) {
			$html = "";
			$html .= file_get_contents($this->path . $filename . ".html", true);
			
			
			//Replace with given array
			if ($array != null) {
				foreach ( $array as $key => $value ) {
					$html = str_replace("{{".$key."}}", $value, $html);					
				}
			}
			
			
			//Replace Templates
			$pattern = "#[{][{](template:|temp:)(.*)[}][}]#";
			for(preg_match($pattern, $html,   $matches); count($matches) > 0; preg_match($pattern, $html,   $matches)){				
				
				$html = str_replace($matches[0], $this->getTemplate($matches[2]), $html);

			}
			
			return $html;
		}
	}
	
	
	
	/**
	 * Main Function to construct the page
	 * @param string $content
	 */
	public function constructPage($content, $layout = "LAYOUT_MAIN"){		
		
		
		
		
		
		//>Put the layout of the page together
		$content = $this->getTemplate($layout, Array("CONTENT" => $content));
		
		
		//Print the whole webpage out
		print($content);
		
	}
	
	
	public function printError($e){
		$content = $e . "<br><a href='#' onclick='history.go(-1); return false;'>Zur&uuml;ck</a>";
		$this->constructPage($content);
	}
	
	/**
	 * 
	 * @param string $filename
	 * @return boolean
	 */
	private function checkTemplateExistence($filename){
		return $this->checkExistence($filename. ".html");
	}
	
	/**
	 * 
	 * @param string $filename
	 * @throws Exception
	 * @return boolean
	 */
	private function checkExistence($filename = ""){
		$filename = $this->path . $filename;
		
		try {
			if (!file_exists ($filename)) {
				throw new Exception ( "Directory or File \"". $filename ."\" doesn't exist." );
				return false;
			}
		} catch ( Exception $e ) {
			new Error ( $e );
		}
		
		return true;
		
	}
	

	
	
}

?>