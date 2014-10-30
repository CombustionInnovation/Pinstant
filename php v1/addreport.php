<?
//http://combustioninnovation.com/luis/pinstant/php/addreport.php?comment_id=51
header('Content-Type: application/json');
	require("report.php");
	$reports = new report;
	require("comments.php");
	$b = new comment;
	require("pins.php");
	$p= new pins;
	require("ip.php");
	$ips= new ip;
	$ip=$ips->getIP();
	$comment_id = $_REQUEST['comment_id'];
	$pin_id= $b ->getPinIdFromComment($comment_id);
	$status = "worked";
	if($b ->hasUserReported($comment_id,$ip)==0)//when report is added it checks if the report has been made oir not
		{
			$reports -> addReport($ip,$comment_id);
			if($reports ->shouldCommentBeDeleted($comment_id))//if the numebr of report reaches ten the comment wil
			{												//auto delete.
				$b -> deleteComment($comment_id);
				$reports -> deleteReports($comment_id);
				if($b ->shouldPinBeDeleted($pin_id))//every time the comment is deleted the php will chekc if the pin has any more comments
				{
					$p -> deletePin($pin_id);//in the case that the pin is empty the pin will get deleted/
				}
			}
		}
		else if ($b ->hasUserReported($comment_id,$ip)==1)
		{
			$reports ->deleteReport($comment_id,$ip);
		}
	$output = array(
							'status' =>  $status,
						);

	echo json_encode($output);
?>