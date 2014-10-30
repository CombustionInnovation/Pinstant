<?
//this controller uses the get more comments function to retreave more comments using the last id that is passed as a parameter
//http://combustioninnovation.com/luis/pinstant/php/getReplies.php?comment_id=&last=
header('Content-Type: application/json');
	require("reply.php");
	$b = new reply;
	require("ip.php");
	$ips = new ip;
	$comment_id = $_REQUEST['comment_id'];
	$last_id = $_REQUEST['last'];
	$sort = $_REQUEST['sort'];
	$l_reply= $_REQUEST['last_reply'];
	$ip=$ips->getIP();
	$reply = $b -> getReplies($last_id,$comment_id,$ip,$sort,$l_reply);
  	echo json_encode($reply);
?>