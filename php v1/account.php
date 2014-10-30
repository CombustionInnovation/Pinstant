<?php
	$user = "cbi_pinstant";
	$pass = "pinstant";
	$host = "localhost";
	$proj = "cbi_pinstant";
	$link = @mysqli_connect( $host, $user, $pass, $proj) OR die('Could not connect to MySQL: ' . mysqli_connect_error() );
?>