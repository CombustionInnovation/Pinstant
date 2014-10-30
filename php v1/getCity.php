<?
//this controller add pins to the database the parameters are lattitude and longitude 
//http://combustioninnovation.com/luis/pinstant/php/getCity.php
header('Content-Type: application/json');
	
	$gl = $_REQUEST["lat"];
	$glng = $_REQUEST["lng"];

	
	require("geoFunction.php");
	$c= new geoFunction;
	
	
	echo json_encode($c -> getCity($gl,$glng));								
 ?>