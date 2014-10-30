<?php
	header('Content-Type: application/json');
	require("user.php");
	$userFunctions = new UserFunctions;
	
$first_name = $_REQUEST['fname'];
$last_name = $_REQUEST['lname'];
$email = $_REQUEST['email'];
$birthday = $_REQUEST['birthday'];
$gender = $_REQUEST['gender'];
$age = $_REQUEST['age'];
$password = $_REQUEST['password'];
$device = $_REQUEST['device'];
$facebookId = $_REQUEST['fbid'];
$login_lat = $_REQUEST['login_lat'];
$login_lng = $_REQUEST['login_lng'];
$username = $_REQUEST['username'];
$picture = $_REQUEST['picture'];
$pushkey = $_REQUEST['pushkey'];
	require("ip.php");
	$ips = new ip;
	$ip=$ips->getIP();

	
	if(count($userFunctions->getInfoByEmail($email)) == 0)
	{
		$userFunctions->	createUserfb("D","D", $first_name, $last_name, $email, $facebookId, $login_lng, $login_lat, "1",$device,$picture,$gender,$birthday,$age,$ip);
	}
	else
	{
		$userFunctions-> updateLogin($email,$picture,$device);
	
	}
	
	$userinfo = $userFunctions ->getUserByFBID($facebookId);
	$pic = $userinfo[0]["picture"];
	
	
			$output   = array(
							'logintype' =>  "Facebook",
							'status' => "one",
							'fname' => ifNull($first_name),
							'lname' => ifNull($last_name),
							'email' => ifNull($email),
							'picture' => ifNull($pic),
				
						);
						
						
						
						echo json_encode($output);
						
	
	function ifNull($value)
	{
		if($value == null)
		{
			return "";
		}
		else
		{
			return $value;
		}
	}
	
	
?>