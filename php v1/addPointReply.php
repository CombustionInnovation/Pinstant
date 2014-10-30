<?
//this controller checks if the comment exist in the database
//if it does it adds a point to the comment score but if it doesnt
//it creates a rank id adding comment id and score starting with one.
//the parameters are just comment id
//http://combustioninnovation.com/luis/pinstant/php/addPointReply.php?reply_id=7&score=1
header('Content-Type: application/json');
	require("reply.php");
	$c= new reply;
	$reply_id = $_REQUEST['reply_id'];
	$score = $_REQUEST['score'];
	require("ip.php");
	$ips= new ip;
	$ip= $ips->getIP();
	if($c -> getRanking($reply_id,$ip))
	{
	$myPoint = $c -> updateRank($reply_id,$ip,$score);
	}
	else
	{
	$myPoint = $c -> addPoint($reply_id,$ip,$score);
	}
		$status = 'true';
		$output = array(
								'status' =>  $status,
							);
		echo json_encode($output);
	
	
?>