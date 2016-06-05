<?php

session_start();  

$fbuserid = $_POST[userid];  
$fbusername = $_POST[username];  
$fbaccess = $_POST[fbaccesstoken];
$_SESSION['nick'] = true;
	$host = 'localhost';
	$user = 'u2013147555';
	$pw = '2013147555';
	$dbName = 'd2013147555';
$mysqli = new mysqli($host, $user, $pw, $dbName);

$curDate = date("Y-n-j");
$query = "SELECT * FROM member where member_id='".$fbuserid."'";  
$result = $mysqli->query($query);
$result_count = $result->num_rows;

if($result_count<1) {  
    //facebook으로 로그인한 아이디가 DB에 없을 경우.
    $query2 = "INSERT INTO member (member_id, first_login, last_login) VALUES ('$fbuserid','$curDate','$curDate')";

    $result2 = $mysqli->query($query2);  
      
    $query = "SELECT * FROM member where member_id='".$fbuserid."'";  
    $result = $mysqli->query($query);
    $_SESSION['nick'] = false;
}  

$row = mysqli_fetch_assoc($result);
 
 
if($row['last_login'] != $curDate) {
	$query3 = "UPDATE member set visite = visite + 1 Where member_id='".$fbuserid."'";
	$result2 = $mysqli->query($query3);
}
$q = "UPDATE member SET last_login = '$curDate' where member_id=$fbuserid";
$res = $mysqli->query($q);


$_SESSION['no'] = $row['member_no'];  
$_SESSION['id'] = $row['member_id'];  
$_SESSION['sta'] = true;  
$_SESSION['facebook'] = true;
?>