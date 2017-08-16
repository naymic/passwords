<?php


/**
 * 
 * @author naymic
 *	
 * Class for the Grafical User Interface
 * All starts from here
 */
class Vision{
	
	/**
	 * @var Class Pages
	 */
	var $page;

	/**
	 * @var Class Adapter
	 */
	var $control;
	
	/**
	 * @var static self instance
	 */
	private static $instance;
	
	
	protected function __clone() {}
	
	/**
	 * Part of singleton
	 */
	public static function getInstance(){
		if(null === self::$instance){
			self::$instance = new static();
		}
	
		return self::$instance;
	}
	
	/**
	 * Part of singleton
	 * Class Construct
	 */
	protected function __construct(){
		$this->setPage(new Page());
		$this->setControl(Control::getInstance());
		
	}	
	
	
	//sets
	public function setPage($page){$this->page = $page;}
	public function setAdapter($adapter){$this->adapter = $adapter;}
	public function setControl($control){$this->control = $control;}
	
	//gets
	public function getPage(){return $this->page;}
	public function getAdapter(){return $this->adapter;}
	public function getControl(){return $this->control;}
	
	

	/**
	 * Get all commands and get informations from control
	 * It is the main Function to show the hole page 
	 */
	public function showPage() {
		(isset($_GET ['page'])) ? $page = $_GET ['page'] : $page = '';
		(isset($_GET ['ac'])) ? $get_ac = $_GET ['ac']: $get_ac = '';
		(isset($_GET ['class'])) ? $get_class = $_GET ['class']: $get_class = '';
		(isset($_REQUEST ['id'])) ? $request_id = $_REQUEST['id']: $request_id = '';
		(isset($_POST ['username1'])) ? $post_username1 = $_POST ['username1']: $post_username1 = '';
		(isset($_POST ['password1'])) ? $post_password1 = $_POST ['password1']: $post_password1 = '';
		(!isset($_GET['limit'])) ? $limit = 0 : $limit = $_GET['limit'];
		(isset($_GET['filter'])) ? $get_filter = $_GET['filter']: $get_filter = '';
		
		
		// Authenticate User
		$this->getControl()->getUser ()->authUser ();
	
		// Any actions?
		$item = NULL;
		$item = $this->getControl()->actions ( $get_ac, $get_class, $request_id, $post_username1, $post_password1 );
		$page = $this->getControl()->getUser ()->checkContent ( $page );
		// echo "<br>1";
	
		if ($page == "main" && $this->getControl()->getUser ()->getLoggedin ()) {
			// echo "<br>1_1";
				
			
			$html = $this->getUserContent($limit, $get_filter, $item);
				
			
		} else if ( !$this->getControl()->getUser ()->getFailedLogin ()) {
			$html = $this->getPage ()->getTemplate ( $page, Array (
					"NACHRICHT" => ""
					) );
		} else if ($this->getControl()->getUser ()->getFailedLogin ()) {
			// echo "2";
			$html = $this->getPage ()->getTemplate ( 'login', Array (
					"NACHRICHT" => "Invalid username or password"
					) );
		}
	
		/*
		 * $user = new User();
		 * $user->setUsername("Micha");
		 * $user->setPassword("iMT_1903");
		 *
		 * $user = $control->getStore()->insert("USER", $user);
		 */
	
		$this->getPage ()->constructPage ( $html, "LAYOUT_MAIN");
	}
	
	
	/**
	 * Get the hole user content
	 * @param int $limit	Table Row Limit
	 */
	public function getUserContent($limit, $get_filter, $item){
		$html = $this->getPage ()->getTemplate ( 'main', Array (
				"ROWS" => $this->getUserContentTableRows ($limit, $get_filter),
				"PAGE_CONTROL" => $this->getUserContentPageControl("?page=main", $limit , count($this->getUserContentRows($get_filter))),
				"USERNAME" => $this->getControl()->getUser ()->getUsername (),
				"FORM_USERNAME" => (isset($item)) ? $item->username : "",
				"FORM_PASSWORD" => (isset($item)) ? $item->password : "",
				"FORM_DESCRIPTION" => (isset($item)) ? $item->description : "",
				"FORM_LINK" => (isset($item)) ? $item->link : "",
				"FORM_ID" => (isset($item)) ? $item->id : "",
				"FORM_USERID" => $this->getControl()->getUser ()->getOID ()
				) );
		
		return $html;
	}
	
	/**
	 * Function to create each line for the logins table
	 * @param int 	 $i
	 * @param string $filter
	 */
	public function getUserContentTableRows($i = 0, $filter = ""){
		$count= $i + 10;
		$page = $i;
	
		$logins = array();
		$html = "";
	
	
		/*foreach($logins as $key => $value){
		 if($logins[$key]->getUserId() == $this->getUser()->getOID()){
		 $rows[] = $logins[$key];
		 }
			}*/
		$logins = $this->getUserContentRows($filter);
		$numRows = count($logins);
	
		for( ; $i<$numRows && $i < $count ; $i++){
				
			$html .= $this->getPage()->getTemplate('main_rows', Array(
					"USERNAME" => $logins[$i]->username,
					"PASSWORD" => $logins[$i]->password,
					"DESCRIPTION" => $logins[$i]->description,
					"LINK" => $logins[$i]->link,
					"OID" => $logins[$i]->id,
					"FILTER" => $filter,
					"LIMIT" => $page,
					));
				
		}
	
	
		return $html;
	
	}
	
	/**
	 * Get all rows of a user
	 * @param string $filter	Search paramenter on the main page
	 * @return string			All login rows of a user
	 */
	private function getUserContentRows($filter){

		$logins = array();
	
		$filter = "		(username LIKE '%". $filter ."%' OR
						password LIKE '%". $filter ."%' OR
						description LIKE '%". $filter ."%' OR
						link LIKE '%". $filter ."%') AND
						userId = '". $this->getControl()->getUser()->getOID() ."'
					";
		//echo $filter;
		$logins = $this->getControl()->getDao()->selectAll("stLogin", $filter);
		//$logins = $this->getControl()->getStore()->getAll("LOGIN", $filter);
	
		return $logins;
	}
	
	
	/**
	 * Function to get pagenumber and make a page control in tables
	 * @param string $getString GET string to add to url
	 * @param int $count	row Limit
	 * @param int $numRows	total row number
	 */
	private function getUserContentPageControl($getString, $count ,$numRows){
		$html ='';
	
		//echo $numRows;
	
	
		if($numRows > 10){
				
	
			$query_string = preg_replace("/&limit=[0-9]*/", "", $_SERVER['QUERY_STRING']);
				
				
			//Back Link
			if($count >= 10){
				$back_link = $this->getPage()->getTemplate('page_control/page_link', Array(
						'LINK' => "index.php?". $query_string."&limit=".($count-10),
						'NAME' => 'back'
						));
			}else{
				$back_link = "back";
			}
				
			//Forward Link
			if($count+10 <= $numRows){
				$forward_link = $this->getPage()->getTemplate('page_control/page_link', Array(
						'LINK' => "index.php?". $query_string ."&limit=".($count+10),
						'NAME' => 'next'
						));
			}else{
				$forward_link = 'next';
			}
				
			//echo $_SERVER['QUERY_STRING'];
				
			//Pagenumber Links
			for($i=0, $page_links=''; $i<$numRows; $i+=10){
				if($i == $count){
					$page_links .= $this->getPage()->getTemplate('page_control/page_link', Array(
							'LINK' => "index.php?". $query_string ."&limit=".($i),
							'NAME' => '<b>'. (($i+10)/10) .'</b>'
							));
				}else{
					$page_links .= $this->getPage()->getTemplate('page_control/page_link', Array(
							'LINK' => "index.php?". $query_string ."&limit=".($i),
							'NAME' => ''. (($i+10)/10) .''
							));
				}
	
	
			}
				
			$html .= $this->getPage()->getTemplate('page_control/page_control', Array(
					'BACK_LINK'=> $back_link,
					'PAGE_LINKS'=> $page_links,
					'FORWARD_LINK'=> $forward_link,
					));
				
		}else{
				
		}
	
		return $html;
	
	}



}



