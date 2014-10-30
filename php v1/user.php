<?php

	/*
		createUser
		userLogin
		getInfoById
		getInfoByUsername
		getInfoByEmail
		getInfoByName
		editProfile
		changePassword
	
	
	*/

	class UserFunctions {

		//Create a new user entry

		function createUser($un, $pw, $fn, $ln, $em, $fbID, $lng, $lat, $isFB) {

			include("account.php");

			//Gather data

			$username = $un;
			$password = md5($pw);
			$email = $em;
			$user_fname = $fn;
			$user_lname = $ln;
			$user_FBID = $fbID;
			
			
			$login_lng = $lng;
			$login_lat = $lat;
			$user_isFB = $isFB;

			$curDate = date('Y-m-d H:i:s', time());
			
			$created = $curDate;
			$first_login = $curDate;

			//query db

			$q = "INSERT INTO users(user_id, username, password, email, user_fname, user_lname, user_FBID, login_lng, login_lat, user_isFB, first_login, made) VALUES ('', '$username', '$password', '$email', '$user_fname', '$user_lname', '$user_FBID', '$login_lng', '$login_lat', '$isFacebook', '$first_login', '$created')";

			if($r = @mysqli_query($link, $q)) {
				return 1;	
			}
			else {
				return 0;	
			}

			mysqli_close($link);

		}
		
		
			function createUserfb($un, $pw, $fn, $ln, $em, $fbID, $lng, $lat, $isFB,$device,$picture,$gender,$birthday,$age,$ip) {

			include("account.php");

			//Gather data

			$username = $un;
			$password = md5($pw);
			$email = $em;
			$user_fname = $fn;
			$user_lname = $ln;
			$user_FBID = $fbID;
			
			
			$login_lng = $lng;
			$login_lat = $lat;
			$user_isFB = $isFB;

			$curDate = date('Y-m-d H:i:s', time());
			
			$created = $curDate;
			$first_login = $curDate;

			//query db

			$q = "INSERT INTO users(email, user_fname,ip, user_lname, user_FBID, login_lng, login_lat, user_isFB, first_login, made,device,picture,gender,birthday,age) VALUES ( '$email', '$user_fname', '$ip','$user_lname', '$user_FBID', '$login_lng', '$login_lat', '$user_isFB', '$first_login', '$created','$device','$picture','$gender','$birthday','$age')";

			if($r = @mysqli_query($link, $q)) {
				return 1;	
			}
			else {
				return 0;	
			}

			mysqli_close($link);

		}
		//Login with email and password
		function userLogin($un, $pw) {
			
			include("account.php");
			
			//Gather credentials
			$username = $un;
			//md5 encryption on password
			$password = md5($pw);
			
			$q = "SELECT * FROM users WHERE email='$username' AND password='$password'";
			$r = @mysqli_query($link, $q);
			
			if(mysqli_num_rows($r) > 0) {
				return true;	
			}
			else {
				return false;	
			}
		}

		

		//get info by fbid
		function getUserByFBID($facebookId)
		{
			include("account.php");

			//Get userID
			$user_id = $uid;

			//query db
			$q = "SELECT * FROM users WHERE user_FBID='$facebookId'";
			$r = @mysqli_query($link, $q);

			//There can be only one!
			if(mysqli_num_rows($r) == 1) {

				while($row =  mysqli_fetch_array($r)) {

					$results [] = array(

						'user_id' => $row['user_id'],
						'username' => $row['username'],
						'email' => $row['email'],
						'picture' => $row['picture'],
						'user_fname' => $row['user_fname'],
						'user_lname' => $row['user_lname'],
						'user_FBID' => $row['user_FBID'],
						'user_isFB' => $row['user_isFB'],
						'first_login' => $row['first_login'],
						'last_login' => $row['last_login'],
						'login_lng' => $row['login_lng'],
						'login_lat' => $row['login_lat'],
						
						'user_FBID' => $row['user_FBID'],
						'user_isFB' => $row['user_isFB'],
						
						'created' => $row['made']
						

					);

				}

				

				return $results;

			}

			else {
				return $results = [];
			}

			mysqli_close($link);

		
		}
		
		//Retrieve all user info by ID

		function getInfoById($uid) {

			

			include("account.php");

			//Get userID
			$user_id = $uid;

			//query db
			$q = "SELECT * FROM users WHERE user_id='$user_id'";
			$r = @mysqli_query($link, $q);

			//There can be only one!
			if(mysqli_num_rows($r) == 1) {

				while($row =  mysqli_fetch_array($r)) {

					$results [] = array(

						'user_id' => $row['user_id'],
						'username' => $row['username'],
						'email' => $row['email'],
						'picture' => $row['picture'],
						'user_fname' => $row['user_fname'],
						'user_lname' => $row['user_lname'],
						'user_FBID' => $row['user_FBID'],
						'user_isFB' => $row['user_isFB'],
						'first_login' => $row['first_login'],
						'last_login' => $row['last_login'],
						'login_lng' => $row['login_lng'],
						'login_lat' => $row['login_lat'],
						
						'user_FBID' => $row['user_FBID'],
						'user_isFB' => $row['user_isFB'],
						
						'created' => $row['made']
						

					);

				}

				

				return $results;

			}

			else {
				echo false;	
			}

			mysqli_close($link);

		}

		

		

		//Retrieve all user info by email

		function getInfoByEmail($em) {

			include("account.php");

			//Get email
			$email = $em;

			//query db
			$q = "SELECT * FROM users WHERE email='$email'";
			$r = @mysqli_query($link, $q);

			//There can be only one!
			if(mysqli_num_rows($r) == 1) {

				while($row = mysqli_fetch_array($r)) {

					$results [] = array(

						'user_id' => $row['user_id'],
						'username' => $row['username'],
						'email' => $row['email'],
						'user_fname' => $row['user_fname'],
						'picture' => $row['picture'],
						'user_lname' => $row['user_lname'],
						'user_FBID' => $row['user_FBID'],
						'user_isFB' => $row['user_isFB'],
						'first_login' => $row['first_login'],
						'last_login' => $row['last_login'],
						'login_lng' => $row['login_lng'],
						'login_lat' => $row['login_lat'],
						
						'user_FBID' => $row['user_FBID'],
						'user_isFB' => $row['user_isFB'],
						
						'created' => $row['made']

					);

				}

				return $results;

			}

			else {

				return $array = [];	

			}

			mysqli_close($link);

		}

		

		//Retrieve all user info by username
		function getInfoByUsername($un) {

			include("account.php");

			//Get username
			$username = $un;

			//query db
			$q = "SELECT * FROM users WHERE username='$username'";
			$r = @mysqli_query($link, $q);

			//There can be only one!
			if(mysqli_num_rows($r) == 1) {

				while($row = mysqli_fetch_array($r)) {

					$results[0] [] = array(

						'user_id' => $row['user_id'],
						'username' => $row['username'],
						'email' => $row['email'],
						'user_fname' => $row['user_fname'],
						'user_lname' => $row['user_lname'],
						'picture' => $row['picture'],
						'user_FBID' => $row['user_FBID'],
						'user_isFB' => $row['user_isFB'],
						'first_login' => $row['first_login'],
						'last_login' => $row['last_login'],
						'login_lng' => $row['login_lng'],
						'login_lat' => $row['login_lat'],
						
						'user_FBID' => $row['user_FBID'],
						'user_isFB' => $row['user_isFB'],
						
						
						'created' => $row['made']

					);

				}

				echo json_encode($results);

			}

			else {

				echo "No Results";	

			}

			mysqli_close($link);	

		}

		//Retrieve all info by first and last name
		function getInfoByName($fn, $ln) {

			include("account.php");

			//Retrieve first and last name
			$f_name = $fn;
			$l_name = $ln;

			//Query db
			$q = "SELECT * FROM users WHERE f_name='$f_name' AND l_name='$l_name'";
			$r = @mysqli_query($link, $q);

			//There can be only one!
			if(mysqli_num_rows($r) == 1) {

				while($row = mysqli_fetch_array($r)) {

					$results[0] [] = array(

						'user_id' => $row['user_id'],
						'username' => $row['username'],
						'email' => $row['email'],
						'user_fname' => $row['user_fname'],
						'user_lname' => $row['user_lname'],
						'user_FBID' => $row['user_FBID'],
						'user_isFB' => $row['user_isFB'],
						'first_login' => $row['first_login'],
						'last_login' => $row['last_login'],
						'login_lng' => $row['login_lng'],
						'login_lat' => $row['login_lat'],
						
						'user_FBID' => $row['user_FBID'],
						'user_isFB' => $row['user_isFB'],
						
						
						'created' => $row['made']

					);

				}

				echo json_encode($results);

			}

			else {

				echo "No Results";	

			}

			mysqli_close($link);		

		}
		
		//Edit user profile		
		function editProfile($uID, $fn, $ln, $make, $model, $year, $pNum, $pSt ) {
			include("account.php");
			
			//Retrieve data
			$user_id = $uID;
			$user_fname = $fn;
			$user_lname = $ln;
			
			$car_make = $make;
			$car_model = $model;
			$car_year = $year;
			$plate_number = $pNum;
			$plate_state = $pSt;
			
			
		
		}
		
		//Change password
		function changePassword($email, $pw) {
			
			include("account.php");
			
			$user_id = $uid;
			$passwordEnc = md5($pw);
			
			$q = "UPDATE users SET password='$passwordEnc' WHERE email='$email'";
			$r = @mysqli_query($link, $q);
			
		}
		
		function checkEmail($em) {
			
			include("account.php");
			
			$email = $em;
			
			$q = "SELECT * FROM users WHERE email='$email'";
			$r = @mysqli_query($link, $q);
			
			if(mysqli_num_rows($r) > 0) {
				return 1;	
			}
			else {
				return 0;	
			}
		}
		
		function checkUsername($un) {
			
			include("account.php");
			
			$username = $un;
			
			$q = "SELECT * FROM users WHERE username='$username'";
			$r = @mysqli_query($link, $q);
			
			if(mysqli_num_rows($r) > 0) {
				return 1;	
			}
			else {
				return 0;	
			}
		}
		
		function updateLastLogin($un) {
			
			include("account.php");
			
			$username = $un;
			
			$curDate = date('Y-m-d H:i:s', time());
			$last_login = $curDate;
			
			$q = "UPDATE users SET last_login='$last_login' WHERE email='$username'";
			if($r = @mysqli_query($link, $q)) {
				return 1;	
			}
			else {
				return 0;
			}
		}
		
		
				
		function updateLogin($email,$picture,$device)
		{
			include("account.php");
			
			$curDate = date('Y-m-d H:i:s', time());
			
			//removed picture = 'picture' because I added click icon to change user picture. 
			
			$stmt = $link->prepare("UPDATE users SET user_isFB = '1', device = '$device', last_login = '$curDate' WHERE email = '$email'");
			//$stmt ->bind_param("1",'$picture','$device','$curDate','$email');
			$stmt->execute(); 
			$stmt->close();
		}
		
		
		function getUserIdFromEmail($email)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM users WHERE email='$email'";
			$r = @mysqli_query($link, $q);
		
			$row = 	mysqli_fetch_array($r);
			$user_id = $row['user_id'];
		
			return $user_id;
			
		 
		
		
		}
		
		
		function changeProfilePicture($picture,$user_id)
		{
		
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			$stmt = $link->prepare("UPDATE users SET picture = '$picture' WHERE user_id = '$user_id'");
	
			$stmt->execute(); 
			$stmt->close();
		
		
		}
		
		function doesEmailPasswordMatch($email,$password)
		{
			include("account.php");

			//Get username
			$passwordEnc = md5($password);

			//query db
			$q = "SELECT * FROM users WHERE email='$email' AND password = '$passwordEnc'";
			$r = @mysqli_query($link, $q);

			//There can be only one!
			if(mysqli_num_rows($r) > 0) {
						return true;
			}
			else
			{
						return false;
			}
			
		
		}
		
		
		function getStats($theuser)
		{
			
			$reported = $this-> getReporterCount($theuser);
			
			$gotReported = $this-> getReportedCount($theuser);
			
			
			$myranking =  $this-> rankings($this-> getUsefulReportCount($theuser));
			
				$results  = array(

						'reported' => $reported,
						'reportee' => $gotReported,
						'ranking' => $myranking,

					);
		
		return $results;
		
		}
		
		
		
		function getReporterCount($theuser)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM notifications WHERE notification_fromID='$theuser'";
			
			$r = @mysqli_query($link, $q);

			//There can be only one!
			$count = mysqli_num_rows($r);

			mysqli_close($link);
			
			return $count;
			
		}
		
		
		
		function getUsefulReportCount($theuser)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM notifications WHERE notification_fromID='$theuser' AND wasHelpful = '1'";
			
			$r = @mysqli_query($link, $q);

			//There can be only one!
			$count = mysqli_num_rows($r);

			mysqli_close($link);
			
			return $count;
			
		}
		
		function getReportedCount($theuser)
		{
		
			include("account.php");
		
			$q = "SELECT * FROM notifications WHERE plate_number IN(SELECT plate_number FROM vehicles WHERE user_id='$theuser')";
			
			$r = @mysqli_query($link, $q);
			$i = 0;
				while($row = mysqli_fetch_array($r)) {
					
					if($this ->isUsersPlate($row['plate_number'],$row['plate_state'],$theuser))
					{
						$i++;
					}
				}
			//There can be only one!
			$count = mysqli_num_rows($r);

			mysqli_close($link);
			
			return $i;
			
		}
		
		
		function getUserPreferences($theuser)
		{
			include("account.php");
			$q = "SELECT * FROM user_preferences WHERE user='$theuser' LIMIT 0,1";
			
			$r = @mysqli_query($link, $q);

			//There can be only one!
				$count = mysqli_num_rows($r);
			if($count == 0)
			{
				$results  = array(

						'push_notifications' => "0",
						'facebook_notifications' => "0",

					);
			}
			else
			{
			$row = mysqli_fetch_array($r);
			$results  = array(

						'push_notifications' => $row['push_notifications'],
						'facebook_notifications' => $row['facebook_notifications'],

					);
		
			}
				mysqli_close($link);
				return $results;
		}


		function getUserReports($theuser,$requesterId)
		{
			include("account.php");
			
			
		}
		
		function getNotifications($theuser)
		{
				include("account.php");
		
				$q = "SELECT * FROM notifications left join users  ON users.user_id = notifications.notification_fromID  WHERE plate_number IN(SELECT plate_number FROM vehicles WHERE user_id='$theuser') AND   notification_isRead = '0' ";
			
				$time = new timeconvert;
				$r = @mysqli_query($link, $q); 

				//There can be only one!
				$count = mysqli_num_rows($r);
			
					while($row = mysqli_fetch_array($r)) {
					
					if($this ->isUsersPlate($row['plate_number'],$row['plate_state'],$theuser))
					{
					
						$reported = $this-> getReporterCount($row['notification_fromID']);
			
						$gotReported = $this-> getReportedCount($row['notification_fromID']);
						
						$myranking =  $this-> rankings($this-> getUsefulReportCount($row['notification_fromID']));

						$results [] = array(

							'notification_id' => $row['notification_id'],
							'vehicle_type' => $row['vehicle_type'],
							'message' => $row['message'],
							'lights_out' => $row['lights_out'],
							'notification_fromID' => $row['notification_fromID'],
							'user_fname' => $row['user_fname'],
							'user_lname' => $row['user_lname'],
							'created' => $time ->dayDifference($row['created']),
							'notifier_reported_count' => $gotReported,
							'notifier_reporter_count' => $reported,
							'notifier_ranking' => $myranking,
							'plate_number' => $row['plate_number'],
							'picture' => $row['picture'],
						);
					
					}

				}
			
				if($count > 0)
				{
				
				
					if(count($results)>0)
					{
				
						return $results;
					}
					else
					{
					
						return $array = [];
					}
				}
				else
				{
					return $array = [];
				}
			
			
			mysqli_close($link);
		
	
		
		}
		
		
		
		function isUsersPlate($plate_number,$plate_state,$theuser)
		{
			include("account.php");
		
				$q = "SELECT * FROM  vehicles WHERE user_id='$theuser' AND plate_number = '$plate_number' AND plate_state ='$plate_state'";
			
				$time = new timeconvert;
				$r = @mysqli_query($link, $q); 

				//There can be only one!
				$count = mysqli_num_rows($r);
				if($count > 0)
				{
					return true;
				}
				else
				{
					return false;
				}
		
		}
		
		
		function getVehicles($theuser)
		{
		
		
		
			include("account.php");

			//Retrieve first and last name
			$f_name = $fn;
			$l_name = $ln;
			$time = new timeconvert;
			//Query db
			$q = "SELECT * FROM vehicles WHERE user_id ='$theuser'";
			$r = @mysqli_query($link, $q);

			//There can be only one!
			if(mysqli_num_rows($r) > 0) {

				while($row = mysqli_fetch_array($r)) {

					$results[] = array(

						'vehicle_type_id' => $row['vehicle_type_id'],
						'car_model' => $row['car_model'],
						'plate_number' => $row['plate_number'],
						'plate_state' => $row['plate_state'],
						
						
						'created' =>  $time ->dayDifference($row['made']),

					);

				}

				return $results;

			}

			else {

				return $results = [];
		
			}
		
		}
		
		
		function hasUserSavedPreferences($user_id)
		{
		
			include("account.php");
			$q = "SELECT * FROM user_preferences WHERE user ='$user_id'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			if($ttl > 0)
			{
				return true;
			}
			else 
			{
				return false;
			}
		
		
		}
		
		function updateUserPreferences($user_id,$push_notifications,$facebook_notifications)
		{
		
			include("account.php");
			
			$curDate = date('Y-m-d H:i:s', time());
			 
			$stmt = $link->prepare("UPDATE user_preferences SET push_notifications = '$push_notifications', facebook_notifications = '$facebook_notifications' WHERE user = '$user_id'");

			$stmt->execute(); 
			$stmt->close();
		
		
		}
		
		
		function setUserPreferences($user_id,$push_notifications,$facebook_notifications)
		{

			include("account.php");
			
			$curDate = date("Y-m-d H:i:s", time());

			$q = "INSERT INTO user_preferences(user, push_notifications,facebook_notifications) VALUES ('$user_id', '$push_notifications','$facebook_notifications')";
			$r = @mysqli_query($link, $q);	
		
		}
		
		function scoreBoard()
		{
			$num=1;
			include("account.php");
			$q = "SELECT count(*) AS rank, users.* FROM notifications LEFT JOIN users ON notifications.notification_fromID=users.user_id WHERE notifications.wasHelpful='$num' GROUP BY notifications.notification_fromID ORDER BY rank DESC";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			$rankNum=0;
			while($row = mysqli_fetch_array($r)) {

					$results[] = array(
						'rankNum' => $rankNum++,
						'rank' => $row['rowNumber'],
						'user_id' => $row['user_id'],
						'user_name' => $row['username'],
						'email' => $row['email'],
						'f_name' => $row['user_fname'],
						'l_name' => $row['user_lname'],
						'Rank Update' => $this->setRanks($rankNum,$row['user_id']),
					);

				}

				return $results;
		
		
		}
		
		function setRanks($rank,$id)
		{
			include("account.php");
			$stmt = $link->prepare("UPDATE users SET rank = '$rank' WHERE user_id= '$id'");
			$stmt->execute(); 
			$stmt->close();
			return 'updated';
		}





	function setPushKey($pushkey,$email) {
	
	$string = str_replace(' ', '', $pushkey);
	$string = str_replace('<', '', $pushkey);
	$string = str_replace('>', '', $pushkey);
	$st = str_replace('<', '', $string);		
	$str=preg_replace('/\s+/', '', $st);
	
			include("account.php");
			
			$user_id = $uid;
			$passwordEnc = md5($pw);
			
			$q = "UPDATE users SET push_key='$str' WHERE email='$email'";
			$r = @mysqli_query($link, $q);
			
		}







	function rankings($number)
	{
	
		
		if($number > 50)
		{
			return "Road Sage";
		}
		else if($number > 25)
		{
			return "Road Warrior";
		}
		else if($number > 10)
		{
			return "Tailgator";
		}
		else if($number > 3)
		{
			return "Sunday Driver";
		}
		else if($number > 0)
		{
			return "Newbie";
		}
		else 
		{
			return "Pedestrian";
		
		}
		

	
	}

		
		
	
	
}

	





?>