<?
//comments can be retreaved by the pin lat and lng/
//http://combustioninnovation.com/luis/pinstant/php/getCommentByLatAndLng.php?lat=32&lng=32
header('Content-Type: application/json');
	require("pins.php");
	$c = new pins;
	require("comments.php");
	$b = new comment;
	
	$geo_lat = $_REQUEST['lat'];
	$geo_lng = $_REQUEST['lng'];
	
	$myPins = $c -> getPins($geo_lat,$geo_lng);
	$pin = $myPins[0]["pin_id"];
	$myComment = $b -> getCommentWPin($pin);
	$ccomment = $myComment[1]["comment"];
   
  	echo json_encode($myComment);

?>
