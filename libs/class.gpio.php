<?php
require_once("class.db.php");
class GPIO extends DB
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function readall()
	{
		$stmt = $this->db->query("SELECT * FROM "._GPIO_STATUS." ");//WHERE gpio='".$gpio."'
		$results = $stmt->fetchAll();
		$list = array();
		foreach($results as $row)
		{
			$list[$row['gpio']] = $row;
		}
		return $list;
	}
	
	public function read($gpio)
	{
		$stmt = $this->db->query("SELECT * FROM "._GPIO_STATUS." WHERE gpio='".$gpio."'");//
		return $stmt->fetch();		
	}
	
	public function mode($gpio, $mode)
	{
		$mode = strtoupper($mode);
		
		$rs = $this->read($gpio);	
		if( $mode != $rs['mode'] )
		{
			//has change, write command
			$this->cmd($gpio, 'mode', $mode);
			return TRUE;
		}	
		else
		{
			return FALSE;
		}
	}
		
	public function write($gpio, $value)
	{
		$this->cmd($gpio, 'write', $value);
	}
	
	protected function cmd($gpio,$field,$value)
	{
		$stmt = $this->db->prepare("INSERT INTO `"._GPIO_COMMAND."` 
								(`id`, `gpio`, `field`, `value`, `created_at`) 
								VALUES
								(NULL, :gpio, :field, :value, :created_at)");
								
		$stmt->execute(array(':gpio'=>$gpio,
						':field'=>$field,
						':value'=>$value,
						':created_at'=>date("YmdHis")));
						
		if (!$stmt) {
			echo "\nPDO::errorInfo():\n";
			print_r($this->db->errorInfo());
		}						
						
	}


}

?>