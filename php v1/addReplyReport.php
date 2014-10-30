<?
//http://combustioninnovation.com/luis/pinstant/php/addreport.php?comment_id=51
header('Content-Type: application/json');
	require("reply.php");
	$reports = new reply;
	require("pins.php");
	$p= new pins;
	require("ip.php");
	$ips= new ip;
	$reporter=$ips->getIP();
	$reported = $_REQUEST['comment_id'];
	$status = "no bueno";
	if($reports ->hasUserReported($reporter,$reported)==0)//when report is added it checks if the report has been made oir not
		{
			$status = "created";
			$reports -> addReport($reporter,$reported);
			if($reports -> shouldReplyBeDeleted($reported))
			{
				$reports ->deleteReport($reported);
			}
		}
		else if ($reports ->hasUserReported($reporter,$reported)==1)
		{
			$status = "deleted";
			$reports ->deleteReport($reporter,$reported);
		}
	$output = array(
							'status' =>  $status,
						);

	echo json_encode($output);
?>