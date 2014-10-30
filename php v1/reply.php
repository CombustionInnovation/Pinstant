<?
	class reply{
	
		function addReply($comment_id,$reply,$hashtag,$pin_id,$ip,$gender,$em,$logintype){//set to add comments to the comments table
		include("account.php");
		//gather data
		//this is the function used to add a reply tot he database
			$charset = "UTF-8";
			mysqli_set_charset ($link, $charset);
			$str =  mysqli_real_escape_string ($link ,$reply);//this chunck of code takes care of any apostrophy issues encountered before
			 $str = @trim($str);
			 if(get_magic_quotes_gpc()) 
				{
					$str = stripslashes($str);
				}
			$vpinid = $pin_id;
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO reply (reply,repy_hashtag,comment_replied,ip,pin_id,gender,type,email,created) VALUES('$str',LOWER('$hashtag'),'$comment_id','$ip','$pin_id',LOWER('$gender'),'$logintype','$em','$curDate')";
			$r = @mysqli_query($link, $q);//replly not being added to the database 12:12 07/21/2014
			mysqli_close($link);
		}
		
		function getReplies($last_id,$comment_id,$ip,$sort,$l_reply)
		{	//get more comments its one of the most important controllers in this class, it gets all comments for every pi
			//gathering information like if pin was liked reported counts of lieks and dislikes all within the same query.
			//the sort parameter is to sore the query by 1(popularity) or by 0(chronological order)
			//the tag parameter is to query using hash tags 
			include("account.php");
							//if($sort==1){
							//$q = "SELECT reply.*, (SELECT count(*) FROM reply_ranking WHERE reply_ranking.reply_id=reply.reply_id) AS popularity FROM  reply LEFT JOIN reply_ranking ON reply_ranking.reply_id=reply.reply_id WHERE reply.reply_id='$reply_id' GROUP BY reply_reply_id ORDER BY popularity DESC, created DESC LIMIT $lastID,25";
							//}
							//else if($sort==0){
				$q = $this->getQueryReply($last_id,$sort,$l_reply,$comment_id);//gets the right query depending on the saort, weather is by popularity or date posted
							//}
				//and i just added it to the end of the query results
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				require("time.php");
				$c= new timeconvert;
				require("pins.php");
				$p= new pins;
				$string=true;
				while($row = mysqli_fetch_array($r)) {
					
							$results ["results"][] = array(
									'comment_id' => $row['reply_id'],
									'the_comment' => $row['comment_replied'],
									'comment' => $row['reply'],
									'pin_id' => $row['pin_id'],
									'gender' => $row['gender'],
									'created' => $c -> dayDifference($row['created']),//gets the difference between now and when the comment was posted
									'did_user_like' => $this ->getRankingScore($row['reply_id'],$ip),
									'did_user_report' => $this ->hasUserReported($ip,$row['reply_id']),//this report function is in the comments class.
									'dislikes' => $this ->countDislikes($row['reply_id']),
									'likes' => $this ->countLikes($row['reply_id']),
									'popularity' => $row['popularity'],//if the sort here is 0 the poopularity will come back as null 
									);
				            }
					if(count($results) > 0)
					{
						return $results;
					}
					else
					{
						$res ["results"]=array();
						return $res;
					}			
			}
	
	
		function addPoint($reply_id,$ip,$score){//this function adds and subtractas a code and its senf rom the parameters on ther controller.
			//this function adds one on score in the ranking table depending on the comment id
			include("account.php");
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO reply_ranking(reply_id,score,ip,created)VALUES('$reply_id','$score','$ip','$curDate')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
		}
		
		
		function updateRank($reply_id,$ip,$score){//if the person decides to downvoate the comment when it had alreay been upvotaed or vice versa the rank will update
			include("account.php");
			$vcommentid = $comment_id;
			$stmt = $link->prepare("UPDATE reply_ranking SET score = '$score' WHERE reply_id= '$reply_id' AND ip='$ip'");
			$stmt->execute(); 
			$stmt->close();
		}
		
		function getRanking($reply_id,$ip)//function useed to determine if the relationship of the comment and user looking at date exists 
		{
			include("account.php");
				$q = "SELECT * FROM  reply_ranking WHERE reply_id ='$reply_id' AND ip='$ip';";
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
		
		function getRankingScore($reply_id,$ip)//this functiuon checks for the client ip address then sees if this user 
		//looking at the data has liked at all and weather it was an up vote with a 1 or a down vote with a 2 
		{
			include("account.php");
				$q = "SELECT * FROM  reply_ranking WHERE reply_id ='$reply_id' AND ip='$ip';";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				$row = mysqli_fetch_array($r);		
				$score =$row['score'];				         
					if($ttl > 0)
					{
						return $score;
					}
					else
					{
						return '0';
					}			
		}
		
		function hasUserReported($reporter,$reported)//this checks relationship between comment and user looking at data to see if he had previously reported .
		{//checks if teh user has done a report on the specific comment before or not
		include("account.php");
		$q = "SELECT * FROM  reply_reports WHERE reported='$reported' AND reporter='$reporter'";
		$r = @mysqli_query($link, $q);
		$ttl = mysqli_num_rows($r);	 
		$row = mysqli_fetch_array($r);					
		$report =$row['report_id'];
					if($ttl > 0)
					{
						return '1';
					}
					else
					{
						return '0';
					}
		}
		
		function addReport($reporter,$reported){
		include("account.php");
		//gather data
		//this is the function used to add a comment tot he database
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO reply_reports(reporter,reported,created)VALUES('$reporter','$reported','$curDate')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
		}
		
		function countDislikes($reply_id)//this function counst the dislikes to every comment
		{
			include("account.php");
			$num=2;				
			$q = "SELECT count(*) as total FROM reply_ranking WHERE reply_id ='$reply_id' AND score='$num';";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				$row = mysqli_fetch_array($r);
				$data = $row['total'];
				return $data;
		}
		
		function countLikes($reply_id)//this function counst the amount of lieks in every comment
		{
			include("account.php");
			$num=1;				
			$q = "SELECT count(*) as total FROM reply_ranking WHERE reply_id ='$reply_id' AND score='$num';";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				$row = mysqli_fetch_array($r);
				$data = $row['total'];
				return $data;
		}
		
		function deleteReport($reported)
			{
			include("account.php");//and if the pin is empty i will simply delete it	
			$stmt = $link->prepare("UPDATE reply SET  banned = '1' WHERE reply_id= '$reported'");
			$stmt->execute(); 
			$stmt->close();
			}
			
		
		function getQueryReply($last_id,$sort,$l_reply,$comment_id){
			 $query = array(
								'0'=>"SELECT * FROM  reply  WHERE banned='0' AND comment_replied='$comment_id' ORDER BY created DESC LIMIT $last_id,25",
								'1'=>"SELECT * FROM  reply  WHERE banned='0' AND comment_replied='$comment_id' AND reply_id>'$l_reply' ORDER BY created ASC LIMIT 0,25",
							);
							
							return $query[$sort];
		}
		
		function shouldReplyBeDeleted($comment_id)
		{
			//this function gets the fisrt 25 comments
			
			include("account.php");
				$q = "SELECT * FROM  reply_reports WHERE reply_id='$comment_id'";
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
	}
	
	
	
	
	