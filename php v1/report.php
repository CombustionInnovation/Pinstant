<?
	class report{
	
		function addReport($reporter_id,$comment){
		include("account.php");
		//gather data
		//this is the function used to add a comment tot he database
		
			$reporter = $reporter_id;
			$comment_id=$comment;
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO reports(reporter,comment_id,created)VALUES('$reporter','$comment_id','$curDate')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
		}
		
		function getReports()
		{
			//this function gets the fisrt 25 comments
			
			include("account.php");
				$q = "SELECT * FROM  reports";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				require("time.php");
				$c= new timeconvert;
				while($row = mysqli_fetch_array($r)) {
							$results [] = array(
									'report_id' => $row['report_id'],
									'reporter' => $row['reporter'],
									'comment_id' => $row['comment_id'],
									'created' => $c -> dayDifference($row['created']),
									);
				            }
					if(count($results) > 0)
					{
						return $results;
					}
					else
					{
						return $array = [];
					}			
		}
	
		function shouldCommentBeDeleted($comment_id)
		{
			//this function gets the fisrt 25 comments
			
			include("account.php");
				$q = "SELECT * FROM  reports WHERE comment_id='$comment_id'";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				while($row = mysqli_fetch_array($r)) {
							$results [] = array(
									'report_id' => $row['report_id'],
									'reporter' => $row['reporter'],
									'comment_id' => $row['comment_id'],
									);
				            }
					if(count($results) > 9)
					{
						return true;
					}
					else
					{
						return false;
					}			
		}
		
		function deleteReports($comment_id)
			{
			include("account.php");	
			$q = "DELETE FROM reports WHERE comment_id='$comment_id'";
			$r = @mysqli_query($link, $q);	
			}
		function deleteReport($comment_id,$ip)
			{
			include("account.php");	
			$q = "DELETE FROM reports WHERE comment_id='$comment_id' AND reporter='$ip'";
			$r = @mysqli_query($link, $q);	
			}
		
	
	}
	
		
?>