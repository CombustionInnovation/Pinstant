<?
//http://combustioninnovation.com/luis/pinstant/php/deleteReport.php?comment_id=51
header('Content-Type: application/json');
	require("report.php");
	$reports = new report;
	$comment_id = $_REQUEST['comment_id'];
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	$reports ->deleteReport($comment_id,$ip);
	$status='done';
	$output = array(
							'status' =>  $status,
						);

	echo json_encode($output);
?>