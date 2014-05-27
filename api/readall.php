<?php
$dirname = dirname(__FILE__);
$pos = strpos($dirname,'public_html');
$def_path = substr($dirname,0, $pos+11);

require_once($def_path."/libs/class.db.php");
require_once($def_path."/libs/class.vars.php");

if( isset($_POST['v']) || isset($_GET['test']) )
{
	//sleep(6);
	/*
	$stmt = $dbh->query('SELECT * FROM gpio');
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo "PDO=";
	print_r($results);
		

   $dbh->query("INSERT INTO `gpio` (`id`, `wiringPi`, `gpio`, `phys`, `name`, `mode`, `value`, `set_value`, `updated_at`) VALUES (NULL, '12', '3', '4', '2', '2', '2', '2', '2014-05-22 12:22:22') ON DUPLICATE KEY UPDATE value='xxx'");
	
	*/
	/*
	$stmt = $dbh->prepare("INSERT INTO `"_GPIO."` (`id`, `gpio`, `mode`, `value`, `updated_at`) VALUES
(NULL, :gpio,:mode, :value, :updated_at) 
ON DUPLICATE KEY UPDATE 
gpio=:gpio,
mode=:mode ,
value=:value,
updated_at=:updated_at");
	*/
	$dbh = new DB();
	$stmt = $dbh->db->prepare("UPDATE `"._GPIO_STATUS."` SET  mode=:mode ,value=:value WHERE gpio=:gpio");

	$stmt->bindParam(':gpio', $gpio);
	$stmt->bindParam(':mode', $mode);
	$stmt->bindParam(':value', $value);
	//$stmt->bindParam(':updated_at', $updated_at);


	$rows = json_decode($_POST['v']);
	$data = array();
	foreach($rows as $arr)
	{
		$gpio = $arr[0];
		$mode = $arr[1];
		$value = $arr[2];
		$stmt->execute();	
		
		if(  $stmt->rowCount() > 0 )
		{
			//Update updated_at 
			$dbh->db->exec("UPDATE `"._GPIO_STATUS."` SET updated_at='".date("YmdHis")."'  WHERE gpio='".$gpio."'");
		}
		$data[$arr[2]] = $arr;		
	}
	//update synctime
	$vars = new Vars();
	$vars->put('last_data', date('Y-m-d H:i:s'));
	//$dbh->db->exec("UPDATE `"._GPIO_STATUS."` SET value='".time()."', updated_at='".date("YmdHis")."'  WHERE gpio='999'");
	
	$stmt = $dbh->db->query("SELECT id,gpio,field,value FROM "._GPIO_COMMAND." WHERE id > '".(isset($_POST['syncid']) ? $_POST['syncid'] : 0)."' ORDER BY id ASC");
	$results = $stmt->fetchAll(PDO::FETCH_NUM);
	echo json_encode($results);	
}

?>