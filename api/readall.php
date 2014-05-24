<?php
require_once('../config.php');

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
	$stmt = $dbh->prepare("UPDATE `gpio` SET  mode=:mode ,value=:value WHERE gpio=:gpio");

	$stmt->bindParam(':gpio', $gpio);
	$stmt->bindParam(':mode', $mode);
	$stmt->bindParam(':value', $value);
	//$stmt->bindParam(':updated_at', $updated_at);


	$rows = explode("|",$_POST['v']);
	$data = array();
	foreach($rows as $row)
	{
		$arr = explode("_",$row);
		$gpio = $arr[0];
		$mode = $arr[1];
		$value = $arr[2];
		$stmt->execute();	
		
		if(  $stmt->rowCount() > 0 )
		{
			//Update updated_at 
			$dbh->exec("UPDATE `gpio` SET updated_at='".date("YmdHis")."'  WHERE gpio='".$gpio."'");
		}
		$data[$arr[2]] = $arr;		
	}
	print_r($data);
}

?>