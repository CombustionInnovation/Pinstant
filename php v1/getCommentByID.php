<?
header('Content-Type: application/json');
	require("comments.php");
	$b = new comment;
	$comment_id = $_REQUEST['comment_id'];
	$comment = $b -> webCommentDisplay($comment_id);
  	echo json_encode($comment);
?>
