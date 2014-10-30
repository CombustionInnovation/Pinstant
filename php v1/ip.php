<?
	class ip
	{
		function doesIPexist($ip)//checks to se if ipadress has been added to the ip table in the database
		{
			include("account.php");
			$q = "SELECT * FROM ips WHERE ip='$ip'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			if($ttl> 0)
				{
					return true;
				}
				else
				{
					return false;
				}
		}
		
		function addIP($ip)//ducntion adds ip using cutrtent time
		{
			include("account.php");
				$curDate = date('Y-m-d H:i:s', time());
				$time=time();
				$q = "INSERT INTO ips(ip,last_comment,time,created)VALUES('$ip','$curDate','$time','$curDate')";
				$r = @mysqli_query($link, $q);
				mysqli_close($link);
		}
		
		function updateIP($ip){//if the ip exist in the database it will get updated to knwo when the last time it was used was.
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			$time=time();
			$stmt = $link->prepare("UPDATE ips SET last_comment = '$curDate',time='$time' WHERE ip= '$ip'");
			$stmt->execute(); 
			$stmt->close();
		}
		
		function hasUserCommentedNotLongAgo($id){//this is mainly to prevent spam, the user has to wait at least 10 seconds to be able to post again.
			include("account.php");
			$time=time();
			$q = "SELECT * FROM ips HAVING '$time'-time<10";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			if($ttl> 0)
				{
					return true;
				}
				else
				{
					return false;
				}
		}
		
		function getIP(){
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];//this gets teh ip address from the user/,
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
		}
			
	}
?>