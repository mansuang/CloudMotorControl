<?php
require_once("class.db.php");
class History extends DB
{
	function __construct()
	{
		parent::__construct();
	}

	
	public function getlist()
	{
		$stmt = $this->db->query("SELECT * FROM "._HISTORY." WHERE varname='".$name."'");//
		return $stmt->fetchAll();		
	}
	
	public function getlast($limit=5,$sort='desc')
	{
		$stmt = $this->db->query("SELECT * FROM "._HISTORY."  ORDER BY id ".$sort." LIMIT ".$limit);//
		return $stmt->fetchAll();		
	}	
	
	public function put($name, $status)
	{
		$stmt = $this->db->prepare("INSERT INTO `"._HISTORY."` 
								(`id`, `name`, `status`, `created_at`) 
								VALUES
								(NULL, :name, :status, :created_at)");
								
		$stmt->execute(array(':name'=>$name,
						':status'=>$status,
						':created_at'=>date("YmdHis")));
						
		if (!$stmt) {
			echo "\nPDO::errorInfo():\n";
			print_r($this->db->errorInfo());
		}	
	}



}

?>