<?
//this controller checks if the comment exist in the database
//if it does it adds a point to the comment score but if it doesnt
//it creates a rank id adding comment id and score starting with one.
//the parameters are just comment id
//http://combustioninnovation.com/luis/pinstant/php/hasUserLiked.php?comment_id=54
header('Content-Type: application/json');
	require("comments.php");
	$c= new comment;
	$comment_id = $_REQUEST['comment_id'];
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	if($c -> getRanking($comment_id,$ip))
	{
		$myscore =$c -> getRankingScore($comment_id,$ip);
	}
	else
	{
	return $myscore=0;
	}
		$status = 'true';
		$output = array(
								'status' =>  $status,
							);
		echo json_encode($myscore);
	
	
?>