<?php

	class timeconvert { 
	
    //Takes two datestamps (one a variable, and one current time, and compares them.
	//If the current date is "greater" than the date given it will return false
	function compareDates($time){
		//Set time zone
		$ESTTZ = new DateTimeZone('America/New_York');
		//Get current datetime
		$date = new DateTime();
		//Get passed datetime
		$datetwo = new DateTime($time);
		//Set both dates to EST
		$date->setTimezone($ESTTZ);
		$datetwo->setTimezone($ESTTZ);
		//Format dates into Y-m-d H:i:s
		$one = $date->format('Y-m-d H:i:s');
		$two = $datetwo ->format('Y-m-d H:i:s');
		
		//If current date > passed date, return false
		if($one > $two){
			return false;
		}
		else
		{
			return true;
		}
	}
	

	
	//Format passed timestamp to Y-m-d
	function timeStampToDate($timestamp){
		//Retrieve $timestamp
		$date = new DateTime($timestamp);
		//Format date
		$one = $date->format('Y-m-d');
		return $one;
		
	
	}

	//Calculate difference (in days) between today and passed datetime
	function dayDifference($time){
		
		//Retrieve today's/passed date
		$date = new DateTime(date('Y-m-d H:i:s',time()));
		$datetwo = new DateTime($time);
			
		//Format dates to Y-m-d
				//$one = $date->format('Y-m-d H:i:s');
				//$two = $datetwo ->format('Y-m-d H:i:s');
		
		$one = strtotime($datetwo->format('Y-m-d H:i:s')); 
		$two = strtotime($date->format('Y-m-d H:i:s')); 
		//Calculate difference between dates
		$datediff = $two - $one;
		//Convert difference into days
		$difference = abs(floor($datediff/(60*60*24)));
	
		//If difference < 1, pass to getHourDiff to get diff. in hours
		if($difference < 1){
			return $this -> getHourDiff($date,$datetwo);
		
		}
		//Otherwise return difference
		else{
			return abs($difference)."d";
		}
	}
	
	//Calculate difference (in hours) between passed datetimes
	function getHourDiff($dateone,$mydate){
		
		//Retrieve passed times, convert to Y-m-d g.i a
		$to_time = strtotime($dateone->format('Y-m-d H:i:s')); 
		$from_time = strtotime($mydate->format('Y-m-d H:i:s')); 
			
		//Calculate difference between two dates
		$hourdiff = round(($to_time - $from_time)/3600, 0);
				
		//If difference < 1, pass to getMinuteDiff to get diff. in minutes				
		if($hourdiff < 1){
			return $this -> getMinuteDiff($dateone,$mydate);
		}
		//Otherwise return difference
		else {
			return  $hourdiff."h";
		}
	}
	
	
	//Calculate difference (in minutes) between passed datetimes
	function getMinuteDiff($now, $mydate){
		
		//Retrieve passed times, convert to Y-m-d g.i a
		$to_time = strtotime($now->format('Y-m-d H:i:s')); 
		$from_time = strtotime($mydate->format('Y-m-d H:i:s')); 
		
		//Calculate difference between two dates
		$mindiff =  round(abs($to_time - $from_time) / 60,2);
	
		//If difference < 1, both dates occurring now (simultaneously)
		if($mindiff < 1) {
			return "now";
		}
		//Otherwise return difference
		else {
			return abs(floor($mindiff))."m";
		}
			
			
	
	}	
	
	
	
	function timeStringToDate($time){

		  $test = new DateTime($time);
		return date_format($test, 'Y-m-d H:i:s'); 
		
	}
	
	
	
	function compareTwoDates($thedate)
	{
			$curDate = date('Y-m-d H:i:s', time());
			$today = new DateTime($curDate);
			$dateTwo = new DateTime($thedate);
			
			if($today > $dateTwo)
			{
				return "0";
			}
			else
			{
				return "1";
			}	
	
	}
	
	
	function arrayOfTimes($items){
	
		 $times = explode(" ", $items);
	
	 $newstring = array();
			for($i =1;$i<count($times);$i++){
				array_push($newstring,$this -> dayDifference($times[$i]));
			}
	
		 return $newstring;
	
	}
	
	function friendlyDate($datet){
			$date = new DateTime($datet);
			$friendly = $date->format('M d, o');
				return $friendly;
	}
	
	
	
	function friendlyTime($datet){
			$date = new DateTime($datet);
			$friendly = $date->format('g:i a');
				return $friendly;
	}
	
	function dayOfWeek($date){
		return date('l', strtotime('-1 day', strtotime($date)));
	}
	
	
	function twelveToTwentyFourTime($time){
	
		$time_in_24_hour_format  = DATE("H:i", STRTOTIME($time));
		return $time_in_24_hour_format;
	}
	
	function twentyFourToTwelveTime($time)
	{
		$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($time));
		
		return $time_in_12_hour_format;
	}
	
		
	
	function arrayof12HourTime($items){
	
		 $times = $items;
	
	 $newstring = array();
			for($i =0;$i<count($times);$i++){
				array_push($newstring,$this -> twentyFourToTwelveTime($times[$i]));
			}
	
		 return $newstring;
	
	}
	
	
	
	

} 

?> 