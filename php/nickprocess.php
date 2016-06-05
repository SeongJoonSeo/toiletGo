<?php
	session_start();

	$nick = $_POST['user_name'];
//	$fbuserid = $_SESSION['id'];
	$no = $_SESSION['no'];

	$host = 'localhost';
	$user = 'u2013147555';
	$pw = '2013147555';
	$dbName = 'd2013147555';
	
	$mysqli = new mysqli($host, $user, $pw, $dbName);

	$query3 = "UPDATE member set nickname = '$nick' Where member_no='".$no."'";
	$result2 = $mysqli->query($query3);

	header("location:http://165.132.122.160/~u2013147555/index.php");	
	exit();
?>