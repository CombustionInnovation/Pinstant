<?


$con = mysql_connect('localhost','cbi_pinstant','pinstant','cbi_pinstant');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  
mysql_select_db("cbi_pinstant", $con);

$picture = mysql_real_escape_string($_POST['picture']);
$comment_id = mysql_real_escape_string($_POST['comment_id']);
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	$curDate = date('Y-m-d H:i:s', time());

        mysql_query("INSERT INTO pictures(picture,comment_id,ip,created) 
    	VALUES('$picture','$comment_id','$ip','$curDate'")
     or die(mysql_error());  
	 
	 echo "!";
	 
	 
	 
	 
	 
?>