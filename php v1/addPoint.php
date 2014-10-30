<?
//this controller checks if the comment exist in the database
//if it does it adds a point to the comment score but if it doesnt
//it creates a rank id adding comment id and score starting with one.
//the parameters are just comment id
//http://combustioninnovation.com/luis/pinstant/php/addPoint.php?comment_id=152&score=2
header('Content-Type: application/json');
	require("comments.php");
	$c= new comment;
	$comment_id = $_REQUEST['comment_id'];
	$score = $_REQUEST['score'];
	require("ip.php");
	$ips= new ip;
	$ip= $ips->getIP();//grtd ip from user
	if($c -> getRanking($comment_id,$ip))//check to see if the teh rank exist from this user comparing by ip address
	{
	$myPoint = $c -> updateRank($comment_id,$ip,$score);//if it does it updates it with the liek or dislike number
	
	}
	else
	{
	$myPoint = $c -> addPointToComment($comment_id,$ip,$score);//is the rank does not exist it adds it to the database
	}
		$status = 'true';
		$output = array(
								'status' =>  $status,
							);
		echo json_encode($output);
	
	
?>