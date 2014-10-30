<?
//this controller adds a comment as parameters it uses the comment itself and a pin ID 
//http://combustioninnovation.com/luis/pinstant/php/addReply.php?reply=second%20reply&pin_id=270&comment_id=775&gender=male
header('Content-Type: application/json');
	require("reply.php");
	$r= new reply;
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
	$reply = $_REQUEST['reply'];
	$pin_id = $_REQUEST['pin_id'];//all the date is gathered
	$gender = $_REQUEST['gender'];
	$comment_id = $_REQUEST['comment_id'];
	$logintype = $_REQUEST['login_type'];
	$em = $_REQUEST['email'];
	if($gender=='Select Gender')
	{
	$gender = '';
	}
	$ip=$ips->getIP();
	if(!$c->dowsTextHaveURL($reply)){//this functon checks for any urls in the comments and if so does not let the comment get posted
			if(!$ips->hasUserCommentedNotLongAgo($id)){//gives a 10 second window where the user cannot post. is mainly used so that the copmment doesnt get posted twice by any errros
				if(!$reply==''){//if the last comment on the pin has been repeted it does not let them post the only time where it can go trhu is 
							$status='one';
									$hashtag= $c->gethashtags($reply);
									$r -> addReply($comment_id,$reply,$hashtag,$pin_id,$ip,$gender,$em,$logintype);
									$c ->  updateLastReply($comment_id,$reply);//every comment has a last reply field to avoid repeated replies one after the otehr.
									if($ips->doesIPexist($ip))//takes the ip adress and ties puts it in the ip table 
									{
										$ips->updateIP($ip);//if ip already exist it updates when he comented last
									}
									else
									{
										$ips->addIP($ip);//if it doesnt creates it and give it a time stamp 
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
	
	$output = array(
							'status' =>  $status,
							
						);

		
		
	
					
						
	echo json_encode($output);
	
?>