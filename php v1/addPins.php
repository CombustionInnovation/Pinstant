<?
//this controller add pins to the database the parameters are lattitude and longitude 
//http://combustioninnovation.com/luis/pinstant/php/addPins.php?lat=40.822316800000000000&lng=74.159872500000000000
header('Content-Type: application/json');
	require("pins.php");
	$c= new pins;
	require("geoFunction.php");
	$g= new geoFunction;
	$geo_lat = $_REQUEST['lat'];//data is requested from user
	$geo_lng = $_REQUEST['lng'];
	$comment = $_REQUEST['comment'];
	$city = $g -> getCity($geo_lat,$geo_lng);//using the lat and lng from the user we determine the city the user is in to add to the pin
	$mypin = $c -> addpin($geo_lat,$geo_lng,$city,$comment);//no we add the actual pin alreadyknowing the city
	$pgl= $mypin['pin_geo_lat'];
	$pglng= $mypin['pin_geo_lng'];
	$datemade= $mypin['date_made'];//we request the time stamp to be able to get the pin by the date and time and from there
	$pin_id = $c -> getPinByInfo($pgl,$pglng,$datemade);//we request the id of the pin to return for other uses
	$pin= array('pin' => $pin_id);//pin id gets added to $pin
	echo json_encode($pin);
?>