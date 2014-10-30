<?
//this controller is to see if tehre are any pins with close geo location
//the parameter is uses is the radious EX 10 miles just imput 10. also the lat and lng wich 
//are taken from your current position
//http://combustioninnovation.com/luis/pinstant/php/getPinsByDistance.php?rad=10000000&lat=40.8567662&lng=-74.1284764&hours=56163
header('Content-Type: application/json');
	require("geoFunction.php");
	$c = new geoFunction;
	//$test=$c->shouldPinsBeDelted();//checks if pins have any comments and if they dont they get deleted.
	$rad = $_REQUEST['rad'];
	$geo_lat = $_REQUEST['lat'];
	$geo_lng = $_REQUEST['lng'];
	$currentPins = $_REQUEST["currpins"];
	$timeFilter=$_REQUEST["hours"];
	$arr = explode(' ',trim($timeFilter));
	$diy= $arr[0];
	$ar = explode(",",$currentPins);//code currently used for current pins in the map
	$please =  join( "' , '" , $ar);
	$help = "'$please'";
	$closePins = $c -> arePinsClose($rad,$geo_lat,$geo_lng,$help,$diy);
	echo json_encode($closePins);
?>