<?
//delte comments by comment id
//http://combustioninnovation.com/luis/pinstant/php/deleteComment.php
header('Content-Type: application/json');
	$comment_id = $_REQUEST["comment_id"];
	require("comments.php");
	$c= new comment;
	echo json_encode($c -> deleteComment($comment_id));								
 ?>