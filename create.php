<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
</head>

<body>
<?php
	@header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
	session_start();
include "connect.php"; 
$sub = $_POST["sub"];
if($sub == 'ok'){

	$part= $_POST["part"];
	$mem = $_SESSION['no'];
	$date = date("Y-m-d H:i:s");
	$cont = $_POST["cont"];
	$rate = $_POST["rating"];

	$b_no = $_POST["building_no"] ? $_POST["building_no"] : 1;
	$t_no = $_POST["toilet_no"] ? $_POST["toilet_no"] :1;

	if( $_FILES['image']['error']==1){
	    echo "이미지 파일 용량이 너무큽니다.<br>";
	    echo "뒤로 돌아가 주세요!";
	    exit();
	}

	//이미지 있는지 확인 
	if(strlen($_FILES['image']['tmp_name']) > 2) {
		$img_dir = "/home/u2013147555/public_html/upload"; //저장 디렉토리
		$img_tmp = $_FILES['image']['tmp_name']; //임시 파일명
		$img_name = $_FILES['image']['name']; //파일명(ex: xxxx.jpg)

		$filename = explode(".",$img_name); //파일명 및 확장자를 분리한 배열
		$extension = strtolower($filename[sizeof($filename)-1]); //확장자 추출

		$cur = date("Y-m-d_H-i-s")."_".rand(1,10000);

		$up_filename = $cur.'ori.'.$extension;
		$save_name = $img_dir."/".$up_filename;	

		$uploadOk=1;




		if($_FILES['image']['size'] > 15*1024*1024) {
				echo "이미지 파일 크기가 너무 큽니다.<br>";
				$uploadOk = 0;
			}
		if($extension != "jpg" && $extension != "png" && $extension != "jpeg"
		&& $extension != "gif" && $extension != "bmp") {
		    echo "오직 JPG, JPEG, PNG, BMP & GIF 파일 형식만 됩니다.<br> ";
		    $uploadOk = 0;
		}

		if ($uploadOk == 0) {
		    echo "이미지 파일 에러로 게시물을 올리지 못했습니다.<br>";
		    echo "뒤로 돌아가 주세요!";
		    exit();
		// if everything is ok, try to upload file
		} else {
			if(move_uploaded_file($img_tmp, $save_name)) {
		//		unlink($img_tmp);
			//	echo "upload ok!<br>";
			}
			else {
		   		echo "이미지 파일 에러로 게시물을 올리지 못했습니다.<br>";
		   		echo "뒤로 돌아가 주세요!";
		    	exit();
			}
		}
		//thumbnail
		$ori;
		if($extension =="jpg"|| $extension =="jpeg"){
			$ori = imagecreatefromjpeg($save_name);
		}
		else if($extension == "png") {
			$ori = imagecreatefrompng($save_name);
		}
		else if($extension == "gif") {
			$ori = imagecreatefromgif($save_name);
		}
		else if($extension == "bmp") {
			$ori = imagecreatefromwbmp($save_name);
		}

		$ori_w = imagesx($ori);
		$ori_h = imagesy($ori);

		$thumb_des = $img_dir."/thumb_".$cur.'.'.$extension;
		$mid_des = $img_dir.'/'.$cur.'.'.$extension;

		$thumb = imagecreatetruecolor(180,180);
		imagecopyresampled($thumb, $ori, 0, 0, 0, 0, 180, 180, $ori_w, $ori_h);

		$mid_w;
		$mid_h;
		if($ori_w > 800 || $ori_h > 800){
			if($ori_h > $ori_w) {
				$mid_h = 800;
				$mid_w = round(800 * $ori_w / $ori_h);
			}
			else if($ori_h <= $ori_w) {
				$mid_w = 800;
				$mid_h = round(800 * $ori_h / $ori_w);
			}
		}
		else {
			$mid_w = $ori_w;
			$mid_h = $ori_h;
		}

		$mid = imagecreatetruecolor($mid_w,$mid_h);
		imagecopyresampled($mid, $ori, 0, 0, 0, 0, $mid_w, $mid_h, $ori_w, $ori_h);

		if($extension =="jpg"|| $extension =="jpeg"){
			imagejpeg($thumb,$thumb_des);
			imagejpeg($mid,$mid_des);
		}
		else if($extension == "png") {
			imagepng($thumb,$thumb_des);
			imagepng($mid,$mid_des);
		}
		else if($extension == "gif") {
			imagegif($thumb,$thumb_des);
			imagegif($mid,$mid_des);
		}
		else if($extension == "bmp") {
			imagewbmp($thumb,$thumb_des);
			imagewbmp($mid,$mid_des);
		}

		$s_mid_des = "upload/".$cur.'.'.$extension;		//경로 주의
		$s_thumb_des = "upload"."/thumb_".$cur.'.'.$extension;	//경로 주의

		unlink($save_name);

		if($part == 1){
			$b_name=$_POST["building_name"];
			$long=$_POST["long"];
			$lati=$_POST["lati"];
			$q = "INSERT INTO building (building_name, latitude, longitude) VALUES ('$b_name','$lati','$long')";
			$res = mysql_query($q,$connect);

			$q = "SELECT building_no FROM building ORDER BY building_no DESC LIMIT 0,1";
			$rpl= mysql_query($q,$connect);
			mysql_data_seek($rpl, 0);
			$row = mysql_fetch_array($rpl);
			$b_no = $row["building_no"];

			//빌딩의 화장실겟수 업.
			$q = "UPDATE building SET numof_toilet = numof_toilet + 1 WHERE building_no = $b_no";
			mysql_query($q);
		}
		if($part == 1 || $part ==2) {
			$t_name = $_POST["toilet_name"];
			$q = "INSERT INTO toilet (building_no,toilet_name) VALUES ('$b_no','$t_name')";
			$res = mysql_query($q,$connect);

			$q = "SELECT toilet_no FROM toilet ORDER BY toilet_no DESC LIMIT 0,1";
			$rpl= mysql_query($q,$connect);
			mysql_data_seek($rpl, 0);
			$row = mysql_fetch_array($rpl);
			$t_no = $row["toilet_no"];

			//화장실의 리뷰수 업.
			$q = "UPDATE toilet SET numof_review = numof_review + 1 WHERE toilet_no = $t_no";
			mysql_query($q);
			$q = "UPDATE toilet SET rating = rating + $rate WHERE toilet_no = $t_no";
			mysql_query($q);
		}
		if($part == 2) {
			$q = "UPDATE building SET numof_toilet = numof_toilet + 1 WHERE building_no = $b_no";
			mysql_query($q);
		}
		if($part == 3) {
			$q = "UPDATE toilet SET numof_review = numof_review + 1 WHERE toilet_no = $t_no";
			mysql_query($q);
			$q = "UPDATE toilet SET rating = rating + $rate WHERE toilet_no = $t_no";
			mysql_query($q);
		}
		$q = "UPDATE member SET numof_writing = numof_writing + 1 WHERE member_no = $mem";
		mysql_query($q);

		$q = "INSERT INTO review (toilet_no, member_no, wdate, content, rating,image,thumb) VALUES ('$t_no','$mem','$date','$cont','$rate','$s_mid_des','$s_thumb_des')";
		$res = mysql_query($q,$connect);

		$q = "SELECT review_no FROM review ORDER BY review_no DESC LIMIT 0,1";
		$res = mysql_query($q);
		$row = mysql_fetch_array($res);
		$rev_no = $row['review_no'];
		echo ("<meta http-equiv='Refresh' content='1; URL=post.php?review_no=$rev_no'>");
	}
	//이미지 없을떄 
	else {
		if($part == 1){
			$b_name=$_POST["building_name"];
			$long=$_POST["long"];
			$lati=$_POST["lati"];
			$q = "INSERT INTO building (building_name, latitude, longitude) VALUES ('$b_name','$lati','$long')";
			$res = mysql_query($q,$connect);

			$q = "SELECT building_no FROM building ORDER BY building_no DESC LIMIT 0,1";
			$rpl= mysql_query($q,$connect);
			mysql_data_seek($rpl, 0);
			$row = mysql_fetch_array($rpl);
			$b_no = $row["building_no"];

			//빌딩의 화장실겟수 업.
			$q = "UPDATE building SET numof_toilet = numof_toilet + 1 WHERE building_no = $b_no";
			mysql_query($q);
		}
		if($part == 1 || $part ==2) {
			$t_name = $_POST["toilet_name"];
			$q = "INSERT INTO toilet (building_no,toilet_name) VALUES ('$b_no','$t_name')";
			$res = mysql_query($q,$connect);

			$q = "SELECT toilet_no FROM toilet ORDER BY toilet_no DESC LIMIT 0,1";
			$rpl= mysql_query($q,$connect);
			mysql_data_seek($rpl, 0);
			$row = mysql_fetch_array($rpl);
			$t_no = $row["toilet_no"];

			//화장실의 리뷰수 업.
			$q = "UPDATE toilet SET numof_review = numof_review + 1 WHERE toilet_no = $t_no";
			mysql_query($q);
			$q = "UPDATE toilet SET rating = rating + $rate WHERE toilet_no = $t_no";
			mysql_query($q);
		}
		if($part == 2) {
			$q = "UPDATE building SET numof_toilet = numof_toilet + 1 WHERE building_no = $b_no";
			mysql_query($q);
		}
		if($part == 3) {
			$q = "UPDATE toilet SET numof_review = numof_review + 1 WHERE toilet_no = $t_no";
			mysql_query($q);
			$q = "UPDATE toilet SET rating = rating + $rate WHERE toilet_no = $t_no";
			mysql_query($q);
		}

		$q = "UPDATE member SET numof_writing = numof_writing + 1 WHERE member_no = $mem";
		mysql_query($q);
		
		$q = "INSERT INTO review (toilet_no, member_no, wdate, content, rating) VALUES ('$t_no','$mem','$date','$cont','$rate')";
		$res = mysql_query($q,$connect);

		$q = "SELECT review_no FROM review ORDER BY review_no DESC LIMIT 0,1";
		$res = mysql_query($q);
		$row = mysql_fetch_array($res);
		$rev_no = $row['review_no'];
		echo ("<meta http-equiv='Refresh' content='1; URL=post.php?review_no=$rev_no'>");
	}
}
?>
</body>
</html>


