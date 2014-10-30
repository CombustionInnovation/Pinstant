<?
//this controller gets the commment function
//http://combustioninnovation.com/luis/pinstant/php/getComments.php
header('Content-Type: application/json');
	require("comments.php");
	$b = new comment;
	$pin_id = $_REQUEST['pinid']; 
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
	$myComments = $b -> getComments($pin_id,$ip);
	$status = 1;
	echo json_encode($myComments);
?>