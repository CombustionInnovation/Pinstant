<?
//this controller adds a comment as parameters it uses the comment itself and a pin ID 
//http://combustioninnovation.com/luis/pinstant/php/addComments.php?comment=(insert comment here)&pin_id=(insert pin id here)
header('Content-Type: application/json');
	require("comments.php");
	$c= new comment;
	require("pins.php");
	$p= new pins;
	require("images.php");//these are the classes required for this controller.
	$i= new images;	
	require("geoFunction.php");
	$g= new geoFunction;
	require("ip.php");
	$ips= new ip;
	$ccomment = $_REQUEST['comment'];
	$pin_ID = $_REQUEST['pin_id'];//all the date is gathered
	$geo_lat = $_REQUEST['lat'];
	$geo_lng = $_REQUEST['lng'];
	$picture = $_REQUEST['picture'];
	$gender = $_REQUEST['gender'];
	$type = $_REQUEST['type'];
	if($gender=='Select Gender')
	{
	$gender = '';//if gender isnt sent from the app it will replace with empty string
	}
	$city = $g -> getCity($geo_lat,$geo_lng);//using sity fnction we get the citi to be adder to pin table
	$ip = $ips->getIP();//ip function is used to get the ip address of the user
	if(!$c->dowsTextHaveURL($ccomment)){//this functon checks for any urls in the comments and if so does not let the comment get posted
			if(!$ips->hasUserCommentedNotLongAgo($id)){//gives a 10 second window where the user cannot post. is mainly used so that the copmment doesnt get posted twice by any errros
				if(!$p->repeatedCommentOnPin($pin_ID,$ccomment)||$ccomment==''){//if the last comment on the pin has been repeted it does not let them post the only time where it can go trhu is 
							$p->updateLast_comment($pin_ID,$ccomment);//if coment iis "" becasue you can post blnk comments when you post a picture 
							$status='one';//if status returs ass one means all the if staments were true and comment can now be added
								$imageLoc = $i->uploadImage($ip);//this function will uoload the image into the server folder and it will return the path 
								if(!$imageLoc=='')//if the image is not blank it return an image location of the URL (actual location of the picture)
								{
								
									$imageLoc = $imageLoc;//if the miage location is not empty it will 
									$pic = "yes";//array returns with a picture states as yes
									$hashtag= "picture,photo,image,".$c->gethashtags($ccomment);//when we add a photo we add hastags to the comment by default to be able to look them up
								}//later on when you hastag picture or photo or even image
								else
								{
									$imageLoc = "";//if the location is blank it reasures that it gets sent blank
									$pic = "no";//for the pcture status no returns to let us no that there was no picture in the comment
									$hashtag= $c->gethashtags($ccomment);//since no picture was added the hastag returns as original comment would have them.
								}
								
							if(!isset($pin_ID)||$pin_ID=="new"){//if the pin is dropped somewhere wher no other pins exist a new pin will be dropped
								$mypin = $p -> addpin($geo_lat,$geo_lng,$city,$ccomment);//function to add pin
								$pgl= $mypin['pin_geo_lat'];//requesting lat
								$pglng= $mypin['pin_geo_lng'];//requesting lng
								$datemade= $mypin['date_made'];//time the pin was dropped to know exatly what pin it was
								$pin_ID = $p -> getPinByInfo($pgl,$pglng,$datemade);//we get the pin id from this function to add it to the comment
									$c -> addComment($ccomment,$hashtag,$pin_ID,$ip,$imageLoc,$gender,$type,$geo_lat,$geo_lng);//when the comment is added we know the new pin id already
							}
							else
							{
									$c -> addComment($ccomment,$hashtag,$pin_ID,$ip,$imageLoc,$gender,$type,$geo_lat,$geo_lng);//is there was a pin already exciting the pin id is obtained in line 16
							}
								if($ips->doesIPexist($ip))//now we check to see if the ip address has be unsed before in the app
								{
									$ips->updateIP($ip);//if the ip address is in the database it updates the last time it was used
								}
								else
								{
									$ips->addIP($ip);//if the ip address is new we add it to the databaes and also put a time stamp on it to see when it was used
								}
				}
				else
				{
				$status = 'three';//if status three returns it means the comment has been repeated  this is to prevent spam and bugs in the app and aovid sending double messages 
				}
			}
			else
			{
			$status = 'two';//if two is returned it means the user has posted less than 10 secons ago this is also to prevent spam and bugs that may happen
			}
	}
	else
	{
	$status = 'four';//is status four is sent back it means the comment contains a url or similas this is also to prevent spamming and promotion on pins
	}
	
	$output = array(
							'status' =>  $status,
							
						);

		
		
	
					
						
	echo json_encode($output);
	
?>