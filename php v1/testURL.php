<?
//this controller gets the commment function
//http://combustioninnovation.com/luis/pinstant/php/testURL.php
header('Content-Type: application/json');
	require("comments.php");
	$c = new comment;
	$comment= $_REQUEST['com'];
	$myPins = $c -> dowsTextHaveURL($comment);
	echo $myPins;
?>