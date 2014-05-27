<?php
$dirname = dirname(__FILE__);
$pos = strpos($dirname,'public_html');
$def_path = substr($dirname,0, $pos+11);

require_once($def_path."/libs/class.gpio.php");
require_once($def_path."/libs/class.vars.php");
require_once($def_path."/libs/class.history.php");

$gpio = new GPIO();
$vars = new Vars();

 $history = new History();

$g27 = $gpio->read(27);
$is_on = $g27['value'];

$last_is_on = $vars->get('is_on');
$last_is_power = $vars->get('is_power');

$last_data = $vars->get('last_data');
$is_power = (time()-strtotime($last_data) < 30 ? '1' : '0');

if( $is_on != $last_is_on )
{
	$vars->put('is_on', $is_on);
	$history->put('motor', ($is_on =='1' ? 'ON' : 'OFF'));
}

if( $is_power != $last_is_power )
{
	$vars->put('is_power', $is_power);
	$history->put('online', ($is_power =='1' ? 'ONLINE' : 'OFFLINE'));
}

 

//$gpio->cmd(17,1,1);
?>