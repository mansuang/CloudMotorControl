<?php
require_once("class.db.php");
class Vars extends DB
{
	function __construct()
	{
		parent::__construct();
	}

	
	public function get($name)
	{
		$stmt = $this->db->query("SELECT * FROM "._VARS." WHERE varname='".$name."'");//
		$row = $stmt->fetch();		
		return isset($row['value']) ? $row['value'] : FALSE;
	}
	
	public function put($varname, $value)
	{
	
		$stmt = $this->db->prepare("INSERT INTO `"._VARS."` 
								(`varname`, `value`) 
								VALUES
								(:varname, :value) ON DUPLICATE KEY UPDATE value=:value");
								
		$stmt->execute(array(':varname'=>$varname,
						':value'=>$value));
						
		if (!$stmt) {
			echo "\nPDO::errorInfo():\n";
			print_r($this->db->errorInfo());
		}	
	}



}

?>