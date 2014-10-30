<?

		class pins{
					function addpin($lat,$lng,$city,$commennt){
					//this function adds new pins and the parameters needed
					//are teh lat and lng
						include("account.php");
							$curDate = date('Y-m-d H:i:s', time());
							$q = "INSERT INTO pins(pin_geo_lat,pin_geo_lng,city,last_comment,l_comment,created)VALUES('$lat','$lng','$city','$curDate','$commennt','$curDate')";
							$r = @mysqli_query($link, $q);
							mysqli_close($link);
							$value = array(
											'date_made' => $curDate,
											'pin_geo_lat' => $lat,
											'pin_geo_lng' => $lng,
											
									
							);
							return $value;
					}
						
						
					function addpinFromBrowser($lat,$lng){
					//this function adds new pins and the parameters needed
					//are teh lat and lng
						include("account.php");
						require("geoFunction.php");
							$g= new geoFunction;
							$city = $g -> getCity($lat,$lng);
							$commennt='Pin added from browser';
							$curDate = date('Y-m-d H:i:s', time());
							$q = "INSERT INTO pins(pin_geo_lat,pin_geo_lng,city,last_comment,l_comment,created)VALUES('$lat','$lng','$city','$curDate','$commennt','$curDate')";
							$r = @mysqli_query($link, $q);
							mysqli_close($link);
							$value = array(
											'date_made' => $curDate,
											'pin_geo_lat' => $lat,
											'pin_geo_lng' => $lng,
									
							);
							return $value;
					} 
					
					function getPins($lat,$lng){
					//gets pins by lat and lng as parameters
					include("account.php");
						$q = "SELECT * FROM  pins WHERE pin_geo_lat = '$lat' AND pin_geo_lng = '$lng'";
						$r = @mysqli_query($link, $q);
						$ttl = mysqli_num_rows($r);
						require("time.php");
						$c= new timeconvert;
						while($row = mysqli_fetch_array($r)) {
							
									$results ["results"][] = array(
											'pin_id' => $row['pin_id'],
											'pin_geo_lat' => $row['pin_geo_lat'],
											'pin_geo_lng' => $row['pin_geo_lng'],
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
				
				function getPinsTable(){
				//gets pins by ID 
					include("account.php");
					$q = "SELECT * FROM  pins";
						$r = @mysqli_query($link, $q);
						$ttl = mysqli_num_rows($r);
						require("time.php");
						$c= new timeconvert;
						while($row = mysqli_fetch_array($r)) {
							
									$results['results'] [] = array(
											'pin_id' => $row['pin_id'],
											'pin_geo_lat' => $row['pin_geo_lat'],
											'pin_geo_lng' => $row['pin_geo_lng'],
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
				
				function getPinByInfo($lat,$lng,$datemade){//this is used in the add comments to determine the pin id right before is posted so that teh comemnt can have that information 
					//gets pins by lat and lng as parameters
					include("account.php");
						$q = "SELECT pin_id, pin_geo_lat, pin_geo_lng, ( 3959 * acos( cos( radians('$lat') ) * cos( radians( pin_geo_lat ) ) * cos( radians( pin_geo_lng ) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians( pin_geo_lat )))) AS distance FROM pins WHERE created ='$datemade' HAVING distance <'.04' ORDER BY distance   LIMIT 0,1";
						$r = @mysqli_query($link, $q);
						$ttl = mysqli_num_rows($r);
						$row = mysqli_fetch_array($r);
											$pin = $row['pin_id'];
						return $pin;
				
					}
					
				function getClosestPin($lat,$lng){
		//the function uses the geo location and radious to look for pins that are within a certain radious of
		//the desired location.
		include('account.php');//whn oins are posted withon .015 miles of ech other the comments made go to one pin this way the map stays a little cleaner.
			$maxDistance = '0.055';
			$q = "SELECT pin_id, pin_geo_lat, pin_geo_lng, ( 3959 * acos( cos( radians('$lat') ) * cos( radians( pin_geo_lat ) ) * cos( radians( pin_geo_lng ) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians( pin_geo_lat )))) AS distance FROM pins HAVING distance <'$maxDistance' ORDER BY distance   LIMIT 0,1";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			$row = mysqli_fetch_array($r);
			
									$myPinID = $row['pin_id'];
				            
					if($ttl > 0)
					{
						return $myPinID;
					}
					else
					{
						return false;
					}			
			}
			
			
			function deletePin($pin_id)//pin gets deleted
			{
			include("account.php");	
			$q = "DELETE FROM pins WHERE pin_id='$pin_id'";
			$r = @mysqli_query($link, $q);	
			}
			
			
			function getPinsInfoByID($pin_id){
				//gets pins by ID 
					include("account.php");
					$q = "SELECT * FROM  pins WHERE pin_id='$pin_id'";
						$r = @mysqli_query($link, $q);
						$ttl = mysqli_num_rows($r);
						require("time.php");
						$c= new timeconvert;
						while($row = mysqli_fetch_array($r)) {
							
									$results['results'] [] = array(
											'pin_id' => $row['pin_id'],
											'pin_geo_lat' => $row['pin_geo_lat'],
											'pin_geo_lng' => $row['pin_geo_lng'],
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
		
		
		function getCity($pin_id){
			include("account.php");
				$q = "SELECT city FROM pins WHERE pin_id='$pin_id'";
				$r = @mysqli_query($link, $q);// i used a second query to get the city depending on the pin_id fomr the pins table
				$ttll = mysqli_num_rows($r);//and i just added it to the end of the query results
				$row = mysqli_fetch_array($r);
				$city = $row['city'];
				return $city;
				
			}
			
			
		function updateLast_comment($pin_id,$comment){//if the comment aready exists this will just update to one for up or two ffor down.
			////this function subtracts one from the score in the ranking table depending on the comment id
			include("account.php");
			$charset = "UTF-8";
			mysqli_set_charset ($link, $charset);
			$str =  mysqli_real_escape_string ($link ,$comment);
			 $str = @trim($str);
			 if(get_magic_quotes_gpc()) 
				{
					$str = stripslashes($str);
				}	
			 
			$curDate = date('Y-m-d H:i:s', time());
			$stmt = $link->prepare("UPDATE pins SET last_comment = '$curDate',l_comment='$str' WHERE pin_id= '$pin_id'");
			$stmt->execute();
			$stmt->close();
		}
		
		function repeatedCommentOnPin($pin_id,$comment){//checks for the last comment made on the pin and it the comment is the same it wont let the user post.
			include("account.php");
			$time=time();
			$charset = "UTF-8";
			mysqli_set_charset ($link, $charset);
			$str =  mysqli_real_escape_string ($link ,$comment);
			 $str = @trim($str);
			 if(get_magic_quotes_gpc()) 
				{
					$str = stripslashes($str);
				}	
			 
			$q = "SELECT * FROM pins WHERE pin_id='$pin_id' AND l_comment='$str'";
			$r = @mysqli_query($link, $q);
			$ttl = mysqli_num_rows($r);
			$row = mysqli_fetch_array($r);
			$coomments=$row['l_comment'];
			if($ttl> 0)
				{
					return true;
				}
				else
				{
					return false;
				}
				
		}
	}
?>