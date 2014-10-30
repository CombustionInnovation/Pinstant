<?php
	header('Content-Type: application/json');
	require('video.php');
	$video = new Videos;		
			require("comments.php");
			$c= new comment;
			require("pins.php");
			$p= new pins;
			require("images.php");
			$i= new images;	
			require("geoFunction.php");
			$g= new geoFunction;
			require("ip.php");
			$ips= new ip;
			$ccomment = $_REQUEST['comment'];
			$pin_ID = $_REQUEST['pin_id'];//all the date is gathered
			$geo_lat = $_REQUEST['lat'];
			$geo_lng = $_REQUEST['lng'];
			$gender = $_REQUEST['gender'];
			$type = $_REQUEST['type'];
	
	
	$folder = "/home/cbi/public_html/pinstantapp.com/videos/";
	
	if (is_uploaded_file($_FILES['filename']['tmp_name'])){
		 if (move_uploaded_file($_FILES['filename']['tmp_name'], $folder.$_FILES ['filename'] ['name'])) 
		 {
				$file = "http://pinstantapp.com/videos/".$_FILES ['filename'] ['name'];
			
		
				
				$thumb = 	$video -> thumbnail($file);
				$status="one";
				
				if($gender=='Select Gender')
				{
				$gender = '';
				}
				$city = $g -> getCity($geo_lat,$geo_lng);
				$ip = $ips->getIP();
				if(!$c->dowsTextHaveURL($ccomment)){//this functon checks for any urls in the comments and if so does not let the comment get posted
						if(!$ips->hasUserCommentedNotLongAgo($id)){//gives a 10 second window where the user cannot post. is mainly used so that the copmment doesnt get posted twice by any errros
							if(!$p->repeatedCommentOnPin($pin_ID,$ccomment)||$ccomment==''){//if the last comment on the pin has been repeted it does not let them post the only time where it can go trhu is 
										$p->updateLast_comment($pin_ID,$ccomment);//if coment iis "" becasue you can post blnk comments when you post a picture 
										$status='one';
											$imageLoc = $i->uploadImage($ip);//this function will uoload the image into the server folder and it will return the path 
											if(!$imageLoc=='')
											{
												$imageLoc = $imageLoc;//if the miage location is not empty it will 
												$pic = "yes";
											}
											else
											{
												$imageLoc = "";
												$pic = "no";
											}
											
										if(!isset($pin_ID)||$pin_ID=="new"){
											$hashtag= $c->gethashtags($ccomment);
											$mypin = $p -> addpin($geo_lat,$geo_lng,$city,$ccomment);
											$pgl= $mypin['pin_geo_lat'];
											$pglng= $mypin['pin_geo_lng'];
											$datemade= $mypin['date_made'];
											$pin_id = $p -> getPinByInfo($pgl,$pglng,$datemade);
												$c -> addCommentWithVideo($ccomment,$c->gethashtags($ccomment),$pin_id,$ip,$imageLoc,$gender,$type,$file,$thumb,$geo_lat,$geo_lng);
										}
										else
										{
												$c -> addCommentWithVideo($ccomment,$c->gethashtags($ccomment),$pin_ID,$ip,$imageLoc,$gender,$type,$file,$thumb,$geo_lat,$geo_lng);
										}
									
										 	if($ips->doesIPexist($ip))
											{
												$ips->updateIP($ip);
											}
											else
											{
												$ips->addIP($ip);
											}
								}
								else
								{
								$status = 'three';
								}
							}
							else
							{
							$status = 'two';
							}
					}
					else
					{
					$status = 'four';
					}				
			} 
			else 
			{
				$status = "five";
			}
		
		} else {
			$status = "six";
		}
		$output = array(
					'status' => $status,
				);
				
		

		print_r(json_encode($output));
	?>

