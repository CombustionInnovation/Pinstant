<?
//this controller adds a comment as parameters it uses the comment itself and a pin ID 
//http://combustioninnovation.com/luis/pinstant/php/addCommentFromBrowser.php?comment=(insert comment here)&pin_id=(insert pin id here)
header('Content-Type: application/json');
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
	$pin_ID = $_REQUEST['pin_id'];
	$geo_lat = $_REQUEST['lat'];
	$geo_lng = $_REQUEST['lng'];
	$type = $_REQUEST['type'];
	$picture = $_REQUEST['picture'];
	$gender = $_REQUEST['gender'];
	if($gender=='Select Gender')
	{
	$gender = '';
	}
	$city = $g -> getCity($geo_lat,$geo_lng);
	$p->updateLast_comment($pin_ID,$ccomment);
	$ip=$ips->getIP();
	$imageLoc = $picture;
	$i->resizeImage($imageLoc, 600, 600);
	$hashtag= $c->gethashtags($ccomment);
	$c -> addComment($ccomment,$hashtag,$pin_ID,$ip,$imageLoc,$gender,$type,$geo_lat,$geo_lng);
	
	
	
	$status = '1';
	$output = array(
							'status' =>  $status,
							'hashtag' =>  $c->gethashtags($ccomment),
							'comment' => $ccomment,
							'pic' => $imageLoc,
						);

		
		
	
					
						
	echo json_encode($output);
	
?>