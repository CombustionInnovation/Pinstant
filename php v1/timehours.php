<?
	class hours{//Calculate difference (in hours) between passed datetimes
		function getHourDiff($time){
			
			//Retrieve passed times, convert to Y-m-d g.i a
			$date = new DateTime();
			$datetwo = new DateTime($time);
			
			$two = strtotime($datetwo->format('Y-m-d g.i a')); 
			$one = strtotime($date->format('Y-m-d g.i a')); 
				
			//Calculate difference between two dates
			$hourdiff = round(($one - $two)/3600, 0);
					
			//If difference < 1, pass to getMinuteDiff to get diff. in minutes				
			
			//Otherwise return difference
			
			return  $hourdiff;
			
		}
	}