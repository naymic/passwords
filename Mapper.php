<?php




abstract class Mapper{
	
	private $index;
	private $db;
	private $item;
	private $filter;
	
	public function __construct(){
		$this->setDb(Connect::getInstance()->getCon());
		$this->index = $this->getLastId();		
	}
	
	protected abstract function insertSTItem($item);
	protected abstract function removeSTItem();
	protected abstract function updateSTItem($item);
	protected abstract function getSTAll();
	protected abstract function getSTItem();
	protected abstract function getPostSTItem();
	
	
	public function insert($item) {


		$this->setIndex($this->getNextIndex());
			
		$this->insertSTItem($item);

		return true;
	}
	
	public function remove($id){
		$this->setIndex($id);
		return $this->removeSTItem();
	}

	public function update($item){
		$this->setIndex($item->getOID());
		return $this->updateSTItem($item);
	}
	
	
	
	public function getAll($filter = ""){ 	
		$this->setFilter($filter);
		return $this->getSTAll();
	}
	
	public function getItem($id) {
		$this->setIndex($id);
		return $this->getSTItem();
	}
	
	public function getPostItem() {
		
		if (! isset ( $_POST ['id'] ))
			$oid = $this->getNextIndex ();
		else
			$oid = $_POST ['id'];
		
		$this->setIndex($oid);
		return $this->getPostSTItem();
	}
	
	protected function createId(){
	
	}
	
	
	
	//Sets
	protected function setIndex($index){$this->index = $index;}
	protected function setDb($db){$this->db = $db;}
	protected function setFilter($filter){$this->filter = $filter;}
	
	//Gets
	protected function getIndex(){return $this->index;}
	protected function getMap(){return $this->map;}
	protected function getDb(){return $this->db;}
	protected function getFilter(){return $this->filter;}
	
	
	protected function getNextIndex(){
		$index = 0;
		
		$index = ($this->getLastId() + 1);
		return $index;
	}
	
	protected function getLastId(){
		$all = $this->getAll();
		$id = 0;
		
		for($i=0; $i<count($all);++$i){
			if($all[$i]->getOID() > $id)
				$id = $all[$i]->getOID();	
		}
		
		return $id;
	}
	
	protected function isStored(ItemToStore $item){
		
		$sql = $item->getAll();
		while($row = $sql->fetch_assoc()){
			if($item->getOID == $row['id'])
				return true;
		}
		
		return false;
	}
	
	
	
	
	
}



?>