<?
//this controller add pins to the database the parameters are lattitude and longitude 
//http://combustioninnovation.com/luis/pinstant/php/addPinsFromBrowser.php?lat=40.822316800000000000&lng=74.159872500000000000
header('Content-Type: application/json');
	require("pins.php");
	$c= new pins;
	$geo_lat = $_REQUEST['lat'];
	$geo_lng = $_REQUEST['lng'];
	$mypin = $c -> addpinFromBrowser($geo_lat,$geo_lng);
	$pgl= $mypin['pin_geo_lat'];
	$pglng= $mypin['pin_geo_lng'];
	$datemade= $mypin['date_made'];
	$pin_id = $c -> getPinByInfo($pgl,$pglng,$datemade);
	$pin= array('pin' => $pin_id);
	echo json_encode($pin);
?>