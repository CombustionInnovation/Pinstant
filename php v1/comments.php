<?
	class comment{
	
		function addComment($comment,$hashtag,$pinID,$ip,$pic,$gender,$type,$lat,$lng){//set to add comments to the comments table
		include("account.php");
		//gather data
		//this is the function used to add a comment tot he database
				
			$charset = "UTF-8";
			mysqli_set_charset ($link, $charset);
			$str =  mysqli_real_escape_string ($link ,$comment);//this chunck of code takes care of any apostrophy issues encountered before
			 $str = @trim($str);
			 if(get_magic_quotes_gpc()) 
				{
					$str = stripslashes($str);
				}	
			 
			$vcomment = $comment;
			$vpinid = $pinID;
			$curDate = date('Y-m-d H:i:s', time());//current date stamp is added to comments
			$q = "INSERT INTO comments(comment,hastag,pin_id,Opin_id,gender,ip,pin_geo_lat,pin_geo_lng,pic,type,created)VALUES('$str',LOWER('$hashtag'),'$vpinid','$vpinid','$gender','$ip','$lat','$lng','$pic','$type','$curDate')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
		}
		
		function addCommentWithVideo($comment,$hashtag,$pinID,$ip,$pic,$gender,$type,$video,$thumbnail,$lat,$lng){//set to add comments to the comments table
		include("account.php");
		//gather data
		//this is the function used to add a comment tot he database
		//if a comment has videos it still gets added to the databse but in the parameters  it has video and thumbnail to add. that is teh main difference 
			$charset = "UTF-8";
			mysqli_set_charset ($link, $charset);
			$str =  mysqli_real_escape_string ($link ,$comment);//this chunck of code takes care of any apostrophy issues encountered before
			 $str = @trim($str);
			 if(get_magic_quotes_gpc()) 
				{
					$str = stripslashes($str);
				}	
			 
			$vcomment = $comment;
			$vpinid = $pinID;
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO comments(comment,hastag,pin_id,Opin_id,gender,ip,pin_geo_lat,pin_geo_lng,pic,type,video,thumbnail,created)VALUES('$str',CONCAT('video,clip,',LOWER('$hashtag')),'$vpinid','$vpinid','$gender','$ip','$lat','$lng','$pic','$type','$video','$thumbnail','$curDate')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
		}
		
		function doesCommentHavePoints($commentID){//checks if comments have votes
		//function check to see if the comment entered inthe parameter has any points
			include("account.php");
			$vcommentID = $commentID;
			$q = "SELECT * FROM ranking WHERE comment_id='$vcommentID'";
			$r = @mysqli_query($link, $q);
			if(mysqli_num_rows($r) > 0)
				{
					
					return true;
				}
				else
				{
					
					return false;
				}
		}
		
		
		function addPointToComment($comment_ID,$ip,$score){//this function adds and subtractas a code and its senf rom the parameters on ther controller.
			//this function adds one on score in the ranking table depending on the comment id
			include("account.php");
			$vcommentID = $comment_ID;
			$curDate = date('Y-m-d H:i:s', time());
			$q = "INSERT INTO ranking(comment_id,score,ip,created)VALUES('$vcommentID','$score','$ip','$curDate')";
			$r = @mysqli_query($link, $q);
			mysqli_close($link);
		}
		
		function deductPointToComment($comment_ID){//this function isnt used
			////this function subtracts one from the score in the ranking table depending on the comment id
			include("account.php");
			$vcommentID = $comment_ID;
			$stmt = $link->prepare("UPDATE ranking SET score = score - 1 WHERE comment_id= '$vcommentID'");
			$stmt->execute(); 
			$stmt->close();
		}
		function updateRank($comment_id,$ip,$score){//if the person decides to downvoate the comment when it had alreay been upvotaed or vice versa the rank will update
			include("account.php");
			$vcommentid = $comment_id;
			$stmt = $link->prepare("UPDATE ranking SET score = '$score' WHERE comment_id= '$comment_id' AND ip='$ip'");
			$stmt->execute(); 
			$stmt->close();
		}
		function getRanking($comment_id,$ip)//function useed to determine if the relationship of the comment and user looking at date exists 
		{
			
			echo $pin_id;
			include("account.php");
				$q = "SELECT * FROM  ranking WHERE comment_id ='$comment_id' AND ip='$ip';";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				require("time.php");
				$c= new timeconvert;
				while($row = mysqli_fetch_array($r)) {
							$results [] = array(
									'comment_id' => $row['comment_id'],
									'comment' => $row['comment'],
									'pin_id' => $row['pin_id'],
									'created' => $c -> dayDifference($row['created']),
									);
				            }
					if(count($results) > 0)
					{
						return true;
					}
					else
					{
						return false;
					}			
		}
		
		function getRankingScore($comment_id,$ip)//this functiuon checks for the client ip address then sees if this user 
		//looking at the data has liked at all and weather it was an up vote with a 1 or a down vote with a 2 
		{
			
			
			include("account.php");
				$q = "SELECT * FROM  ranking WHERE comment_id ='$comment_id' AND ip='$ip';";
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
		
		function countDislikes($comment_id)//this function counst the dislikes to every comment
		{
			include("account.php");
			$num=2;				
			$q = "SELECT count(*) as total FROM ranking WHERE comment_id ='$comment_id' AND score='$num';";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				$row = mysqli_fetch_array($r);
				$data = $row['total'];
				return $data;
		}
		
		function countLikes($comment_id)//this function counst the amount of lieks in every comment
		{
			include("account.php");
			$num=1;				
			$q = "SELECT count(*) as total FROM ranking WHERE comment_id ='$comment_id' AND score='$num';";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				$row = mysqli_fetch_array($r);
				$data = $row['total'];
				return $data;
		}
		function getComments($pin_id,$ip)
		{
			//this function gets the fisrt 25 comments
			
			include("account.php");
				$q = "SELECT * FROM  comments LEFT JOIN pins ON comments.pin_id=pins.pin_id WHERE comments.pin_id ='$pin_id' ORDER BY comment_id ASC LIMIT 0,25";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				require("time.php");
				$c= new timeconvert;
				while($row = mysqli_fetch_array($r)) {
							$results [] = array(
									'comment_id' => $row['comment_id'],
									'comment' => $row['comment'],
									'pin_id' => $row['pin_id'],
									'city' => $row['city'],
									'created' => $c -> dayDifference($row['created']),
									'did_user_like' => $this ->getRankingScore($row['comment_id'],$ip),
									'did_user_report' => $this ->hasUserReported($row['comment_id'],$ip),
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
		
		function getMoreComments($lastID,$pin_id,$ip,$sort,$tag,$lcommentid)
		{	//get more comments its one of the most important controllers in this class, it gets all comments for every pi
			//gathering information like if pin was liked reported counts of lieks and dislikes all within the same query.
			//the sort parameter is to sore the query by 1(popularity) or by 0(chronological order)
			//the tag parameter is to query using hash tags 
			include("account.php");
				if($tag=='')
				{
					$query = $this->getNoneHashtagQuery($sort,$pin_id,$lastID,$lcommentid);//query is determined from the array if the array does not have a hashtag
					$q= $query;
				}
				else{
					$query = $this->getQueryHashtag($sort,$pin_id,$lastID,$tag,$lcommentid);//query is determined from the array depending on the sort thsi querry will ahve tags
					$q= $query;
				}
				
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
									'comment_id' => $row['comment_id'],
									'comment' => $row['comment'],
									'pin_id' => $row['pin_id'],
									'created' => $c -> dayDifference($row['created']),//gets the difference between now and when the comment was posted
									'did_user_like' => $this ->getRankingScore($row['comment_id'],$ip),//this returns wheather the comment has a like or a dislike
									'did_user_report' => $this ->hasUserReported($row['comment_id'],$ip),//this report function is in the comments class.
									'dislikes' => $this ->countDislikes($row['comment_id']),//this counts the total dislikes of the comment
									'likes' => $this ->countLikes($row['comment_id']),//this counts the total lieks that the comment has
									'popularity' => $row['popularity'],//popularity is only user when sort is one otherwise it iwll be returned as null
									'replies' => $this->countReplies($row['comment_id']),//thsi counst the amount of replies that every comment has
									'gender' => $row['gender'],
									'picture' => $row['pic'],
									'video' => $row['video'],
									'thumbnail' => $row['thumbnail'],
									'type' => $row['type'],//in type os type is 0 its a comment with no video or picture is its 1 its a picture of its a 2 the comment has a video added to is
									'city' => $p->getCity($row['pin_id']),//the get city from the pin
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
			
			
			
			
			
			
			//this piece of code is working
			//this function gets more comments deoending on the last comment ID 
			/*include("account.php");
				if($lastID == 0){
					$q = "SELECT * FROM  comments WHERE pin_id='$pin_id' ORDER BY comment_id DESC LIMIT 0,25";
				}
			else{
					$q = "SELECT * FROM  comments WHERE pin_id='$pin_id' AND comment_id<'$lastID' ORDER BY comment_id DESC LIMIT 0,25";
				}
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				require("time.php");
				$c= new timeconvert;
				while($row = mysqli_fetch_array($r)) {
					
							$results ["results"][] = array(
									'comment_id' => $row['comment_id'],
									'comment' => $row['comment'],
									'pin_id' => $row['pin_id'],
									'created' => $c -> dayDifference($row['created']),
									'did_user_like' => $this ->getRankingScore($row['comment_id'],$ip),
									'did_user_report' => $this ->hasUserReported($row['comment_id'],$ip),
									'dislikes' => $this ->countDislikes($row['comment_id']),
									'likes' => $this ->countLikes($row['comment_id']),
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
					}	*/		
		}
		
		function getCity($pin_id) //this gets the where the comment was placed andfrom the pins tablels gets the city from the field city.
		{
			$q = "SELECT city FROM  pins WHERE pin_id='$pin_id'";
			$r = @mysqli_query($link, $q);// i used a second query to get the cuty depending on the pin_id fomr the pins table
			$ttl = mysqli_num_rows($r);
			$row = mysqli_fetch_array($r);
			$city=$row['city'];
			return $city;
		}
		function hasUserReported($comment_id,$ip)//this checks relationship between comment and user looking at data to see if he had previously reported .
		{//checks if teh user has done a report on the specific comment before or not
		include("account.php");
		$q = "SELECT * FROM  reports WHERE comment_id='$comment_id' AND reporter='$ip'";//this determines if the ip beuing used byu the client has repirted the comment before
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
		function getCommentWPin($pin_id){//i believe this isnt used for pinstant
			//this function gets comments by pin ID
					include("account.php");
					$q = "SELECT * FROM  comments WHERE pin_id = '$pin_id'";
						$r = @mysqli_query($link, $q);
						$ttl = mysqli_num_rows($r);
						require("time.php");
						$c= new timeconvert;
						while($row = mysqli_fetch_array($r)) {
							
									$results [] = array(
											'comment_id' => $row['comment_id'],
											'comment' => $row['comment'],
											'pin_id' => $row['pin_id'],
											'created' => $c -> dayDifference($row['created']),
											);
									}

							if(count($results) > 0)
							{
								return $results;
							}
							else
							{
								return $results = [];
							}			
				}				
		function getPinIdFromComment($comment_id){
		//this function gets comments by the comment id and it also displays the time difference between created and now.
					include("account.php");
					$q = "SELECT * FROM  comments WHERE comment_id = '$comment_id'";
						$r = @mysqli_query($link, $q);
						$ttl = mysqli_num_rows($r);
						$row = mysqli_fetch_array($r);
						$pin_id=$row['pin_id'];
						return $pin_id;			
				}			
			function insertImage($pic, $ip) {//this function adds the picture location to the database.
		
			include("account.php");			
			$user_id = $ip;
			$picture = $pic;
			$q = "UPDATE comments SET pic = '$picture' WHERE ip='$ip'";
			$r = @mysqli_query($link, $q);	
		}				
			function deleteComment($comment_id)//every time a comment is deleted it will automatically check to see if the pin is encountered
			{
			include("account.php");//and if the pin is empty i will simply delete it	
			$stmt = $link->prepare("UPDATE comments SET  banned = '1',pin_id='0' WHERE comment_id= '$comment_id'");//pins should have hidden comment connected to them, insted they are all 
								//conencted to pin 0 dosent exist in the map
			$stmt->execute(); 
			$stmt->close();
			}
			
		function shouldPinBeDeleted($pin_id){//this will do a aut chekc every time a comment is reported if the number of reports is 10 the comment with automatically be deleted
				//this will only return true or false 
					include("account.php");
						$q = "SELECT * FROM  comments WHERE pin_id='$pin_id' AND banned='0'";//this determines if the pin ahs any comments in it
						$r = @mysqli_query($link, $q);
						$ttl = mysqli_num_rows($r);
						require("time.php");
						$c= new timeconvert;
						while($row = mysqli_fetch_array($r)) {
							
									$results ["results"][] = array(
											'pin_id' => $row['pin_id'],
											'pin_geo_lat' => $row['pin_geo_lat'],
											'pin_geo_lng' => $row['pin_geo_lng'],
											'created' => $c -> dayDifference,
											);
									}

							if(count($results) == 0)
							{
								return true;
							}
							else
							{
								return false;
							}			
					}
					
					function gethashtags($text)
					{
					  //Match the hashtags
					  preg_match_all('/(^|[^a-z0-9_])#([a-z0-9_]+)/i', $text, $matchedHashtags);
					  $hashtag = '';
					  // For each hashtag, strip all characters but alpha numeric
					  if(!empty($matchedHashtags[0])) {
						  foreach($matchedHashtags[0] as $match) {
							  $hashtag .= preg_replace("/[^a-z0-9]+/i", "", $match).',';
						  }
					  }
					  
						//to remove last comma in a string
					return rtrim($hashtag, ',');
					}
					
					/*function dowsTextHaveURLL($comment_id)
					{
						include("account.php");
						$num=1;				
						$q = "SELECT * FROM comments WHERE comment_id ='$comment_id' AND (comment LIKE '%www%' OR comment LIKE '%www.%' OR comment LIKE '%.com%';";
							$r = @mysqli_query($link, $q);
							$ttl = mysqli_num_rows($r);
							$row = mysqli_fetch_array($r);
							$data = $row['total'];
							return $data;
						if(preg_match($reg_exUrl, $comment, $url)) {

							  return true;// returns true of the comment has any www.
							  
						}
						else
						{
							return false;
						}
						
						
					}*/
					
					function dowsTextHaveURL($comment)
					{
						// force http: on www.
						$comment = ereg_replace( "www\.", "http://www.", $comment );
						
						$pattern = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
						$comment = preg_replace($pattern, "  http ", $comment);
						// The Regular Expression filter
						$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

						
						// Check if there is a url in the text
						if(ttl>0) {

							  return true;// returns true of the comment has any www.
							  
						}
						else
						{
							return false;
						}
						
						
					}
		
	
	
	
	function getAllCommentFromTag($lastID,$ip,$sort,$ttag,$lcommentid)//this array gets the global comments form the tag in any pin
		{	//this is the function for the hastag search . it will look up any comment anywhere that has the hashtag searched 
			include("account.php");
				$q=$this->getQueryGlobalHashtag($lastID,$sort,$ttag,$lcommentid);
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				require("time.php");
				$c= new timeconvert;
				require("pins.php");
				$p= new pins;
				while($row = mysqli_fetch_array($r)) {
					
							$results ["results"][] = array(
									'comment_id' => $row['comment_id'],
									'comment' => $row['comment'],
									'pin_id' => $row['pin_id'],
									'created' => $c -> dayDifference($row['created']),
									'did_user_like' => $this ->getRankingScore($row['comment_id'],$ip),
									'did_user_report' => $this ->hasUserReported($row['comment_id'],$ip),//this report function is in the comments class.
									'dislikes' => $this ->countDislikes($row['comment_id']),
									'likes' => $this ->countLikes($row['comment_id']),
									'popularity' => $row['popularity'],
									'gender' => $row['gender'],
									'picture' => $row['pic'],
									'video' => $row['video'],
									'type' => $row['type'],
									'replies' => $this->countReplies($row['comment_id']),
									'thumbnail' => $row['thumbnail'],
									'city' => $p->getCity($row['pin_id']),//result comes from second query
									);
							}
				            
					if($ttl > 0)
					{
						return $results;
					}
					else
					{
						$res ["results"]=array();
						return $res;
					}
			
			
			
			
			
				
		}
		
		function getHastagPinID($rad,$lat,$lng,$arr,$tag,$dateFilter)
		{	//this pin function gets the pins that have comments within them that have the hashtag that was searched.
			//also works with the time filter
			include("account.php");
				$maxDistance = $rad;
				if($dateFilter=='All' || $dateFilter =='all'){
				$dateFilter = 2323534645623232332;
				$date = new DateTime(date('Y-m-d H:i:s',(time()+(60*60*$dateFilter))));
				}
				else
				{
					$dateFilter=$dateFilter*24;//hours get multiplied by 24 to get converted into hours.
					$date = new DateTime(date('Y-m-d H:i:s',(time()-(60*60*$dateFilter))));
				}
				
				$curDate = $date->format('Y-m-d H:i:s');
			//	echo $curDate;
				$q = "SELECT DISTINCT comments.pin_id, pins.pin_geo_lat, pins.pin_geo_lng, comments.hastag,( 3959 * acos( cos( radians('$lat') ) * cos( radians( pins.pin_geo_lat ) ) * cos( radians( pins.pin_geo_lng ) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians( pins.pin_geo_lat )))) AS distance FROM  comments LEFT JOIN pins ON comments.pin_id=pins.pin_id WHERE pins.pin_id NOT IN ($arr) AND (comments.hastag LIKE '$tag,%' OR comments.hastag LIKE '%,$tag,%' OR comments.hastag LIKE '%,$tag' OR comments.hastag LIKE '$tag') AND last_comment>'$curDate' HAVING distance <'$maxDistance' ORDER BY distance ASC LIMIT 0,300";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				while($row = mysqli_fetch_array($r)) {
					
							$results ['results'][] = array(
							
							'pin_id' =>$row['pin_id'],	
							'pin_geo_lat' =>$row['pin_geo_lat'],	
							'pin_geo_lng' =>$row['pin_geo_lng'],
							'hashtag' =>$row['hastag'],
							'distance' =>$row['distance'],
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
		
		
		function webCommentDisplay($comment_id)//this fucntion is used to  display on the web. Pinstantapp.com/stroy
		{
				include("account.php");
				$q = "SELECT * FROM comments WHERE comment_id='$comment_id'";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				require("time.php");
				$c= new timeconvert;
				require("pins.php");
				$p= new pins;
				while($row = mysqli_fetch_array($r)) {
					
							$results ['results'][] = array(
									'comment_id' => $row['comment_id'],
									'comment' => $row['comment'],
									'pin_id' => $row['pin_id'],
									'created' => $c -> dayDifference($row['created']),
									'did_user_like' => $this ->getRankingScore($row['comment_id'],$ip),
									'did_user_report' => $this ->hasUserReported($row['comment_id'],$ip),//this report function is in the comments class.
									'dislikes' => $this ->countDislikes($row['comment_id']),
									'likes' => $this ->countLikes($row['comment_id']),
									'picture' => $row['pic'],
									'video' => $row['video'],
									'thumbnail' => $row['thumbnail'],
									'city' => $p->getCity($row['pin_id']),//result comes from second query
									);
							}
				if(!$ttl==0)
				{
					return $results;
				}
				else
				{
					return false;
				}
		}
		function getBestComments($comments){//this is used for the control panel used in combustion. this is only displaed for staff.
				include("account.php");//it will get the most popular comments and display them 
				$q = "SELECT comments.*,(SELECT count(*) FROM ranking WHERE ranking.comment_id=comments.comment_id) AS popularity FROM comments LEFT JOIN ranking ON ranking.comment_id=comments.comment_id GROUP BY comments.comment_id ORDER BY popularity DESC,comments.comment_id ASC LIMIT $comments,300";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				require("time.php");
				$c= new timeconvert;
				require("pins.php");
				$p= new pins;
				while($row = mysqli_fetch_array($r)) {
					
							$results ['results'][] = array(
									'comment_id' => $row['comment_id'],
									'comment' => $row['comment'],
									'pin_id' => $row['pin_id'],
									'created' => $c -> dayDifference($row['created']),
									'dislikes' => $this ->countDislikes($row['comment_id']),
									'likes' => $this ->countLikes($row['comment_id']),
									'picture' => $row['pic'],
									'video' => $row['video'],
									'thumbnail' => $row['thumbnail'],
									'city' => $p->getCity($row['pin_id']),//result comes from second query
									'popularity' => $row['popularity'],
									);
							}
				return $results;
		}
		
		function repeatedReplyOnComment($comment_id,$reply){//checks for the last comment made on the pin and it the comment is the same it wont let the user post.
			include("account.php");
			$charset = "UTF-8";
			mysqli_set_charset ($link, $charset);
			$str =  mysqli_real_escape_string ($link ,$comment);
			 $str = @trim($str);
			 if(get_magic_quotes_gpc()) 
				{
					$str = stripslashes($str);
				}	
			 
			$q = "SELECT * FROM comments WHERE comment_id='$comment_id' AND last_reply='$str'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			$row = mysqli_fetch_array($r);
			if($ttl> 0)
				{
					return true;
				}
				else
				{
					return false;
				}
				
		}
		
		
		function updateLastReply($comment_id,$reply){
			include("account.php");
			$charset = "UTF-8";
			mysqli_set_charset ($link, $charset);
			$str =  mysqli_real_escape_string ($link ,$reply);
			 $str = @trim($str);
			 if(get_magic_quotes_gpc()) 
				{
					$str = stripslashes($str);
				}	
			 
			$stmt = $link->prepare("UPDATE comments SET  last_reply = '$str' WHERE comment_id= '$comment_id'");
			$stmt->execute(); 
			$stmt->close();
		}
		
		function getNoneHashtagQuery($sort,$pin_id,$lastid,$lcommentid){
			 $query = array(
								'0'=>"SELECT * FROM  comments WHERE banned='0' AND pin_id='$pin_id' AND comment_id>'$lcommentid' ORDER BY created DESC LIMIT $lastid,25",
								'1'=>"SELECT comments.*, (SELECT count(*) FROM ranking WHERE ranking.comment_id=comments.comment_id) AS popularity FROM  comments LEFT JOIN ranking ON ranking.comment_id=comments.comment_id WHERE comments.banned='0' AND comments.pin_id='$pin_id' GROUP BY comment_id ORDER BY popularity DESC, created DESC LIMIT $lastid,25",
								'2'=>"SELECT * FROM  comments WHERE banned='0' AND pin_id='$pin_id'AND type='1' AND comment_id>'$lcommentid' ORDER BY created DESC LIMIT $lastid,25",
								'3'=>"SELECT * FROM  comments WHERE banned='0' AND pin_id='$pin_id'AND type='2' AND comment_id>'$lcommentid' ORDER BY created DESC LIMIT $lastid,25",
								'4'=>"SELECT * FROM  comments WHERE banned='0' AND pin_id='$pin_id' AND comment_id>'$lcommentid' ORDER BY created ASC LIMIT $lastid,25",
							);
							
							return $query[$sort];
		}
		
		function getQueryHashtag($sort,$pin_id,$lastid,$tag,$lcommentid){
			 $query = array(
								'0'=>"SELECT * FROM  comments WHERE banned='0' AND pin_id='$pin_id' AND comment_id>'$lcommentid' AND (hastag LIKE '$tag,%' OR hastag LIKE '%,$tag,%' OR hastag LIKE '%,$tag' OR hastag LIKE '$tag') ORDER BY created DESC LIMIT $lastid,25",
								'1'=>"SELECT comments.*, (SELECT count(*) FROM ranking WHERE ranking.comment_id=comments.comment_id) AS popularity FROM  comments LEFT JOIN ranking ON ranking.comment_id=comments.comment_id WHERE comments.banned='0' AND comments.pin_id='$pin_id' AND (hastag LIKE '$tag,%' OR hastag LIKE '%,$tag,%' OR hastag LIKE '%,$tag' OR hastag LIKE '$tag') GROUP BY comment_id ORDER BY popularity DESC, created DESC LIMIT $lastid,25",
								'2'=>"SELECT * FROM  comments WHERE banned='0' AND pin_id='$pin_id' AND type='1' AND AND comment_id>'$lcommentid' (hastag LIKE '$tag,%' OR hastag LIKE '%,$tag,%' OR hastag LIKE '%,$tag' OR hastag LIKE '$tag') ORDER BY created DESC LIMIT $lastid,25",
								'3'=>"SELECT * FROM  comments WHERE banned='0' AND pin_id='$pin_id' AND type='2' AND comment_id>'$lcommentid' AND (hastag LIKE '$tag,%' OR hastag LIKE '%,$tag,%' OR hastag LIKE '%,$tag' OR hastag LIKE '$tag') ORDER BY created DESC LIMIT $lastid,25",
								'4'=>"SELECT * FROM  comments WHERE banned='0' AND pin_id='$pin_id' AND type='2' AND comment_id>'$lcommentid' AND (hastag LIKE '$tag,%' OR hastag LIKE '%,$tag,%' OR hastag LIKE '%,$tag' OR hastag LIKE '$tag') ORDER BY created ASC LIMIT $lastid,25",
							);
							
							return $query[$sort];
		}
		
		function getQueryGlobalHashtag($lastID,$sort,$ttag,$lcommentid){
			 $tag = trim($ttag);
			 $query = array(
								'0'=>"SELECT * FROM  comments WHERE comment_id>'$lcommentid' AND banned='0' AND (hastag LIKE '$tag,%' OR hastag LIKE '%,$tag,%' OR hastag LIKE '%,$tag' OR hastag LIKE '$tag') ORDER BY created DESC LIMIT $lastID,25",
								'1'=>"SELECT comments.*, (SELECT count(*) FROM ranking WHERE ranking.comment_id=comments.comment_id) AS popularity FROM  comments LEFT JOIN ranking ON ranking.comment_id=comments.comment_id WHERE AND (hastag LIKE '$tag,%' OR hastag LIKE '%,$tag,%' OR hastag LIKE '%,$tag' OR hastag LIKE '$tag') AND banned='0' AND comment_id>'$lcommentid' GROUP BY comment_id ORDER BY popularity DESC, created DESC LIMIT $lastID,25",
								'2'=>"SELECT * FROM  comments WHERE comment_id>'$lcommentid' AND banned='0' AND (hastag LIKE '$tag,%' OR hastag LIKE '%,$tag,%' OR hastag LIKE '%,$tag' OR hastag LIKE '$tag') ORDER BY created ASC LIMIT $lastID,25",
							);
							
							return $query[$sort];
		}
		
		function countReplies($comment_id)//this function counst the dislikes to every comment
		{
			include("account.php");			
				$q = "SELECT count(*) as total FROM reply WHERE comment_replied ='$comment_id'";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				$row = mysqli_fetch_array($r);
				$data=0;
				$data = $row['total'];
				return $data;
		}
		
		
	}	

?>