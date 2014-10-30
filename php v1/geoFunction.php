<?
	class geoFunction{
		// this gets all pins within a certain radius by lat and lng
		function getPins($rad,$lat,$lng){
		
		
			}
		//gets more pins to our map after weve already gotten our initial pins
		function getMorePins($rad,$lat,$lng,$lastpin,$limit){
		
		
			}
			
		//sees if there are any pins withnin a radius 
		function arePinsClose($rad,$lat,$lng,$arr,$dateFilter){
		//the function uses the geo location and radious to look for pins that are within a certain radious of
		//the desired location.
		include('account.php');
			if($dateFilter=='All'){
				$dateFilter = 232323232332; //dateFilter is parasmeter passed representing days ago, so pins will be uodated on the app by time too.
			}
			else
			{
					$dateFilter=$dateFilter*24;//hours get converted into days
			}
			$maxDistance = $rad;
			$date = new DateTime(date('Y-m-d H:i:s',(time()-(60*60*$dateFilter))));
			$curDate = $date->format('Y-m-d H:i:s');
			require("timehours.php");
			$c= new hours;
			require("time.php");
			$g= new timeconvert;
			$q = "SELECT pin_id, pin_geo_lat, pin_geo_lng,last_comment,( 3959 * acos( cos( radians('$lat') ) * cos( radians( pin_geo_lat ) ) * cos( radians( pin_geo_lng ) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians( pin_geo_lat )))) AS distance,(SELECT count(*) FROM comments WHERE comments.pin_id=pins.pin_id)  as Total FROM pins WHERE pin_id NOT IN ($arr) AND last_comment> '$curDate' HAVING distance <'$maxDistance' AND Total>'0' ORDER BY distance ASC LIMIT 0,1000";
			
			
		//	$q = "SELECT pin_id, pin_geo_lat, pin_geo_lng, ( 3959 * acos( cos( radians('$lat') ) * cos( radians( pin_geo_lat ) ) * cos( radians( pin_geo_lng ) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians( pin_geo_lat )))) AS distance FROM pins WHERE pin_id NOT IN ($arr) HAVING distance<'$maxDistance' ORDER BY distance ASC LIMIT 0,300";
			
			$r = @mysqli_query($link, $q);
			
			while($row = mysqli_fetch_array($r)) {
					
							$results ['results'] [] = array(
									'pin_id' => $row['pin_id'],
									'pin_geo_lat' => $row['pin_geo_lat'],
									'pin_geo_lng' => $row['pin_geo_lng'],
									'hours_ago_of_last_comment' => $c ->  getHourDiff($row['last_comment']),
									'created' => $g -> dayDifference($row['last_comment']),
									'distance' => $row['distance'],
									'total' => $row['Total'],//totall is the ammount of comments inside the pin
									);
				            }
					if(count($results) > 0)
					{
						return $results;
					}
					else
					{
					
						$empty ["results"]  = array();
						return $empty;
					}			
			}
		//tells me which is the closest pin to me
		function closestPin($lat,$lng){
		
		
			}
			
			
			
		//actual distance of closest pin
		function getCity($lat,$lng){
		$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&key=AIzaSyA7J7l1To7kOJvh0qjUKeqYM6fyhuHv-8g');
		$output= json_decode($geocode);
		$city = $output->results[0]->address_components[2]->long_name;//using google geocode api we get the city name and we then add them to the pin
		return $city;
			}
			
		function shouldPinsBeDelted(){
			include("account.php");	
			require ('pins.php');
			$pin = new pins;
			$q = "SELECT pins.pin_id,(SELECT count(*) FROM comments WHERE comments.pin_id=pins.pin_id) as Total FROM pins HAVING Total='0';";
				$r = @mysqli_query($link, $q);
				$ttl = mysqli_num_rows($r);
				while($row = mysqli_fetch_array($r)) {
							$results [] = array(
									'pin_id'=> $row['pin_id'],
									'total'=> $row['Total'],
									);
				            $pin -> deletePin($row['pin_id']);
							}
				return $results;
		}
	}






?>