<?
//this controller add pins to the database the parameters are lattitude and longitude 
//http://combustioninnovation.com/luis/pinstant/php/getBestComments.php
header('Content-Type: application/json');	
	$comments= $_REQUEST['comments'];
	require("comments.php");
	$c= new comment;
	echo json_encode($c -> getBestComments($comments));								
 ?>