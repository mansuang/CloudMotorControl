<?php
$dirname = dirname(__FILE__);
$pos = strpos($dirname,'public_html');
$def_path = substr($dirname,0, $pos+11);

include($def_path."/config.php");
class DB 
{
	public $db;
	function __construct()
	{
		$this->db = new PDO('mysql:host='._DBHOST.';dbname='._DBNAME.';charset='._CHARSET.'', _DBUSERNAME, _DBPASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));	
	}
	
	function _dbConnect()
	{
		return $this->db;
	}


}

?>