<?
//this controller uses the get more comments function to retreave more comments using the last id that is passed as a parameter
//http://combustioninnovation.com/luis/pinstant/php/getMoreComments.php?&pinid=209&sort=1&last=25
header('Content-Type: application/json');
	require("comments.php");
	$b = new comment;
	require("ip.php");
	$ips = new ip;
	$tag ='';
	$pin_id = $_REQUEST['pinid'];
	$last_id = $_REQUEST['last'];
	$sort = $_REQUEST['sort'];
	$tag = $_REQUEST['tag'];//if tag is no entered the comments will still be send regularly.
	$re = $_REQUEST['is_refresh'];
	if($re==1)
	{
		$lcommentid = $_REQUEST['last_comment_id'];
		$sort='4';
	}
	else
	{
		$lcommentid=0;
	}
	
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
	$myComment = $b -> getMoreComments($last_id,$pin_id,$ip,$sort,$tag,$lcommentid);
  	echo json_encode($myComment);
?>
