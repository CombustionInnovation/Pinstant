<?
//this controller gets the commment function
//http://combustioninnovation.com/luis/pinstant/php/getComments.php
header('Content-Type: application/json');
	require("report.php");
	$b = new report;
	$myComments = $b -> getReports();
	$status = 1;
	echo json_encode($myComments);
?>