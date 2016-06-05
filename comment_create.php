<?php
	@header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
	session_start();
	
	if(!$_SESSION['sta']){
		header("location:http://165.132.122.160/~u2013147555/login.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
</head>
<body>
	<?php
		include "connect.php"; 

		$sub = $_POST["sub"];
		$mem = $_SESSION['no'];		//변경!!!

	//	echo "sub->$sub, mem->$mem<br>";

		if($sub == 'ok') {
			$date = date("Y-m-d H:i:s");
			$cont = $_POST['cmt'];
			$rev_no = $_POST['rev_no'];

		//	echo "cont->$cont, rev_no->$rev_no<br>";

			$q = "UPDATE member SET numof_comment = numof_comment + 1 WHERE member_no = $mem";
			mysql_query($q);
			$q = "UPDATE review SET numof_comment = numof_comment + 1 WHERE review_no = $rev_no ";
			mysql_query($q);
			$q = "INSERT INTO comment(review_no,member_no,content,wdate) VALUES ('$rev_no','$mem','$cont','$date')";
		   	$res = mysql_query($q);
			
			if($res) {
				echo ("<meta http-equiv='Refresh' content='1; URL=post.php?review_no=$rev_no'>");
			}
		}
		else {
			echo 'fail';
		}
	?>
</body>
</html>