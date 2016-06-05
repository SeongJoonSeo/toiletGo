<?php
	@header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
	session_start();
	include "connect.php";
	$no = $_GET["review_no"];
	$is_login = $_SESSION['sta'];
	$viewer_no = $_SESSION['no'];
	$oo = $_POST['put_rcmd'];

	$q = "SELECT review.member_no,nickname,wdate,content,image,toilet_name,review.numof_comment,review.rating,building_name,review.toilet_no FROM review JOIN member,toilet,building WHERE review_no = $no and review.member_no = member.member_no and review.toilet_no = toilet.toilet_no and toilet.building_no = building.building_no LIMIT 1";

	$res = mysql_query($q);
	$row = mysql_fetch_array($res);
?>

<!DOCUMENT html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
	<title>쾌변 고!</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/slide-menu.css" />
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="stylesheet" type="text/css" href="css/post.css" />
	<script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.2.js"></script>
	<script> 
	    var sta = '<?php echo $_SESSION['sta'] ?>';
	</script>
	<style type="text/css">
		#cont {
			width: 98%;
			max-width: 580px;
			margin-left: auto;
			margin-right: auto;
		}
		#cont img{
			width: 98%;
			margin-left: auto;
			margin-right: auto;
		}


	</style>
</head>
<body>

	<?php //추천수 처리-------------------

		if($is_login) {
			$q2 = "SELECT recommend_no from recommend where review_no = $no and member_no = $viewer_no";
			$res2 = mysql_query($q2);
			$is_rcmd = mysql_num_rows($res2);
			$row2 = mysql_fetch_array($res2);
			$rcmd_no = $row2['recommend_no'];
			$to_mem = $row['member_no'];

			if($oo =='ok'){
				if($is_rcmd == 0) {
					$q3 = "INSERT INTO recommend (review_no,member_no,to_mem_no) values ('$no','$viewer_no','$to_mem')";
					mysql_query($q3);
					$q3 = "UPDATE review SET rcmd = rcmd+1 WHERE review_no=$no";
					mysql_query($q3);
					$q3 = "UPDATE member SET numof_rcmd = numof_rcmd+1 WHERE member_no=$to_mem";
					mysql_query($q3);
				}
				else {
					$q3 = "DELETE FROM recommend WHERE recommend_no=$rcmd_no";
					mysql_query($q3);
					$q3 = "UPDATE review SET rcmd = rcmd-1 WHERE review_no=$no";
					mysql_query($q3);
					$q3 = "UPDATE member SET numof_rcmd = numof_rcmd-1 WHERE member_no=$to_mem";
					mysql_query($q3);
				}	
			} 
		}  
		else{
			if($oo =='ok') {
				echo "<script> alert('로그인이 필요합니다.');</script>";
			}
		} 
		$q3 = "SELECT rcmd FROM review WHERE review_no = $no";
		$res3 = mysql_query($q3);
		$row3 = mysql_fetch_array($res3);
		$rcmd = $row3['rcmd'];

	 //----------------------- ?> 


	<div id="header" class="reveal-header">
		<a href="index.php"><img id="logo" src="img/logo.png" /></a>
	</div>
	<a href="toilet_board.php?toilet_no=<?php echo $row['toilet_no']; ?>" id="back_a"><img id="back" src="img/backbtn.png" width="40px" /></a>



	<div id="search-wrap">
		<form method="get" action="result.php">
			<input type="search" name="addr" required="required"/>
			<input type="image" src="img/search.png" width= "40" height="40" />
			<img src="img/gps.png" id="gps" width="40" height="40" name="coord"  title="내 위치로 찾기"/>
		</form>
	</div>

	<div id="mobile-nav"></div>
	<nav class="reveal-nav">
      <ul class="menu">
		<div id="status"></div>
		<li style="cursor: pointer;"><a href="login.php">
        	<script type="text/javascript">
        		if(!sta)
        			document.write('login');
        	</script>
        </a>
        </li>

        <li style="cursor: pointer;"><a href="php/logout.php">
        	<script type="text/javascript">
				if(sta)
        			document.write('logout');
        	</script>
        </a>
        </li>
        <li><a href="service.html">Services</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="#">PC version</a></li>
	  </ul>
	</nav>
		
		

	<div id="cont">
		<?php 
			$image = $row['image'];
			if(strlen($image)<3){
				$image = "default_thumb.jpg";
			}

			echo '<div class="element"><div class = "row"><div class ="writer col-xs-5"><p>'.$row['nickname'].'</p><p id="date">'.$row['wdate'].'</p></div><div class = "pic col-xs-7"><img src="'.$image.'" /></div></div><div class ="text"><p><hr>'.$row['building_name'].' '.$row['toilet_name'].'<br>'.$row['content'].'<hr></p></div><div class = "row"><div class = "col-xs-6"><img id="star" src="img/'.$row['rating'].'.png" height="40px"></div>';

			//추천 처리 
			echo '<div class = "col-xs-3"><form method="post" action="post.php?review_no='.$no.'"><input style="display: none" name="put_rcmd" value="ok" /><input type="submit" name="submit" value="추천" /> : '.$rcmd.'</form></div>';


			echo '<div class = "col-xs-3">댓글수: '.$row['numof_comment'].'</div></div></div>';

			//댓글 입력난
			echo '<div class="row"><form action="comment_create.php" method="post"><div style="display: none"><input type="number" name="rev_no" value="'.$no.'" /><input type="text" name="sub" value="ok" /></div><div class="col-xs-10"><input type="text" name="cmt" required /></div><div class="col-xs-2"> <input  type="image" src="img/poo.png" name="submit" value="submit"  align="absmiddle" width="30px"></div></div>';		

			//댓글들 출력 
			$q2="SELECT content,comment.wdate,nickname FROM comment JOIN member WHERE review_no = $no and comment.member_no = member.member_no LIMIT ".$row["numof_comment"];
			$res2=mysql_query($q2);
			while($row2 = mysql_fetch_array($res2)) {
				echo '<div class="row"><hr>	<div class="reply col-xs-6"><p>'.$row2['nickname'].'</p></div><div class="reply col-xs-6"><p>'.$row2['wdate'].'</p></div><div class="reply col-xs-12"> <p>'.$row2['content'].'</p></div><hr></div>';

			}
		?>

	</div>


	<footer>
		<p>&copy; 급하니</p>
	</footer>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="js/slide-menu.js"></script>

</body>
</html>

