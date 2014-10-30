<?
//this controller add pins to the database the parameters are lattitude and longitude 
//http://combustioninnovation.com/luis/pinstant/php/getClosestPin.php?lat=40.810409&lng-74.153697
header('Content-Type: application/json');
	
	$gl = $_REQUEST["lt"];
	$glng = $_REQUEST["lg"];

	
	require("pins.php");
	$c= new pins;
	
	
	$cl = $c -> getClosestPin($gl,$glng);

	if (!$cl)
	{
			$pin = "new";
	}
	else
	{
	   $pin = $cl;
	}
	
	
		$results = array(
											'pin_id' => $pin,
											);
											
											
  echo json_encode($results);