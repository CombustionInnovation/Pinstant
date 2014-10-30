<?

//this is how you insert
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
		
		
//this is how you select data
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
		

		
//update query

		
		function changeProfilePicture($picture,$user_id)
		{
		
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			$stmt = $link->prepare("UPDATE users SET picture = '$picture' WHERE user_id = '$user_id'");
	
			$stmt->execute(); 
			$stmt->close();
		
		
		}