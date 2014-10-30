<?
//this controller gets the commment function
//http://combustioninnovation.com/luis/pinstant/php/getPins.php
header('Content-Type: application/json');
	require("pins.php");
	$c = new pins;
	$myPins = $c -> getPinsTable();
	echo json_encode($myPins);
?>