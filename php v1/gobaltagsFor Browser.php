<?
//this controller uses the get more comments function to retreave more comments using the last id that is passed as a parameter
//http://combustioninnovation.com/luis/pinstant/php/globalTagSearch.php?&pinid=163&sort=1&last=25
header('Content-Type: application/json');
	require("comments.php");
	require("ip.php");
	$b = new comment;
	$tag ='';
	$last_id = $_REQUEST['last'];
	$sort = $_REQUEST['sort'];
	$tag = $_REQUEST['tag'];
	$re = $_REQUEST['is_refresh'];
	if($re==1)
	{
		$lcommentid = $_REQUEST['last_comment_id'];
		$sort =2;
	}
	else
	{
		$lcommentid=0;
	}
	$ips= new ip;
	$ip= $ips->getIP();
	$myComment = $b -> getAllCommentFromTag($last_id,$ip,$sort,$tag,$lcommentid);
  	echo json_encode($myComment);
?>
