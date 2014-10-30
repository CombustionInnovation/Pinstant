<?php

	header('Content-Type: application/json');

	require("require.php");
	
	$email = $_REQUEST['email'];
	$trip_id = $_REQUEST['trip_id'];
	$picture = $_REQUEST['picture'];
	
	$user_id =  $user->getUserIdFromEmail($email);
	
	$imageLoc = $imageFuncs->uploadImage($email, $trip_id);
	
	$user->insertPicture($picture, $user_id, $trip_id);

	

?>	