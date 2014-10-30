<?
//controller deducts points as a parameter it uses the comment id
//http://combustioninnovation.com/luis/pinstant/php/deductPoint.php?commentid=18
header('Content-Type: application/json');
	require("comments.php");
	$c= new comment;
	$comments = $_REQUEST['commentid'];
	if($c ->doesCommentHavePoints($comments))
	{
		$myPoint = $c -> deductPointToComment($comments);
		$status = 'true';
		$output = array(
								'status' =>  $status,
							);
		echo json_encode($output);
	}
	else
	{
		$myPoint = $c -> addFirstPointToComment($comments);
		$status = 'false';
		$output = array(
								'status' =>  $status,
							);
		echo json_encode($output);
	}
?>