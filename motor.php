<?php
require_once("libs/class.gpio.php");

$gpio = new GPIO();
if( isset($_GET['s']) && $_GET['s']=='1')
{
	$g17 = $gpio->read(17);
	echo $g17['value'];
	exit;
}

if( isset($_POST['v']) )
{
	$gpio->mode(17, 'OUT');
	$gpio->write(17, $_POST['v']);
	echo $_POST['v'];
	exit;
}


//$gpio->cmd(17,1,1);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Motor Control</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1 class=" text-center">Send=<span id="startstop"></span> | Response=<span id="gpio17"></span></h1>
        <p><a href="#" class="btn btn-danger btn-lg" role="button" id="btnStop">STOP</a> <a href="#" class="btn btn-success btn-lg pull-right" role="button" id="btnStart">START</a></p>
      </div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript">
$(function(){ 
	aoStart();
	
	$("#btnStart").click(function() { 
		setmotor('1');
		//aoStart();		
		
	});
	
	$("#btnStop").click(function() { 
		setmotor('0');
		//aoStop();
		
	});	

});
var is_start = 0;
function aoStart(){
	if( is_start == 0 )
	{
		is_start = 1;		
		refreshcon = setInterval(function(){
			$('#gpio17').load('motor.php?s=1', function(){  });
		}, 1000);
	}
}		

function aoStop(){
	is_start = 0;
	$('#current_status').html('STOP');
    try{
        clearInterval(refreshcon);
    }catch(err){}
}

function setmotor( s )
{
		$.ajax({
		  type: "POST",
		  url: "<?php echo $_SERVER['PHP_SELF']; ?>",
		  data: { v: s }
		})
		  .done(function( msg ) {
			$('#startstop').html(msg);
			//alert( msg );
		 });	
}
</script>
	
	
  </body>
</html>