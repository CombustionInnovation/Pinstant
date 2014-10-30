<?
//controller for time it uses the comment by id function and at the end it returns the object witht he time at the end or the array
//http://combustioninnovation.com/luis/pinstant/php/timeDifference.php?commentid=18
header('Content-Type: application/json');
	require("comments.php");
	$b= new comment;
	$commentID = $_REQUEST['commentid'];
	$myComment = $b -> getCommentByID($commentID);
	echo json_encode($myComment);
?>