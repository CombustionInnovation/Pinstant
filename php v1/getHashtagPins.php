<?
//this controller uses the get more comments function to retreave more comments using the last id that is passed as a parameter
//http://combustioninnovation.com/pinstantapp.com/php/getHashtagPins.php?rad=10000&last=0&lat=40.8223168&lng=-74.1598725&tag=lol&hours=all
header('Content-Type: application/json');
	require("comments.php");
	$b = new comment;
	$tag ='';
	$rad = $_REQUEST['rad'];
	$geo_lat = $_REQUEST['lat'];
	$geo_lng = $_REQUEST['lng'];
	$tag = $_REQUEST['tag'];
	$currentPins = $_REQUEST["currpins"];
	$timeFilter=$_REQUEST["hours"];
	$ar = explode(",",$currentPins);
	$please =  join( "' , '" , $ar);
	$help = "'$please'";
	
	//if($timeFilter == "All" || $timeFilter == "all")
	//{
	//	$timeFilter =45454545;
	//}
	
	$pin_id = $b -> getHastagPinID($rad,$geo_lat,$geo_lng,$help,$tag,$timeFilter);
	
  	echo json_encode($pin_id);
?>
