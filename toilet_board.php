<?php
	session_start();
	include "connect.php";
	$t_no = $_GET["toilet_no"];

	$q_bt ="SELECT building_name,toilet_name FROM toilet JOIN building WHERE toilet.toilet_no = $t_no and building.building_no = toilet.building_no LIMIT 1";
	$res_bt = mysql_query($q_bt);
	$row_bt = mysql_fetch_array($res_bt);

	$b_name = $row_bt['building_name'];
	$t_name = $row_bt['toilet_name'];

	$q= "SELECT review_no,nickname,wdate,thumb,content,rating,rcmd,review.numof_comment FROM review JOIN member WHERE review.toilet_no = $t_no and member.member_no = review.member_no ORDER BY wdate DESC";
	$res = mysql_query($q);

	$img_src = "abc";
	while($row = mysql_fetch_array($res)){
		if($img_src === "abc" && strlen($row['thumb']) > 3){
			$img_src = $row['thumb'];
		}
	}
	if ($img_src =='abc'){
		$img_src = "default_thumb.jpg";
	}
	mysql_data_seek($res, 0);
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
	<link rel="stylesheet" href="css/toilet_board.css">
	<script> 
	    var sta = '<?php echo $_SESSION['sta'] ?>';
	</script>
	<style>
		#cont {
			width: 98%;
			max-width: 580px;
			margin-left: auto;
			margin-right: auto;
		}
	</style>
</head>
<body>
	<div id="header" class="reveal-header">		
		<a href="index.php"><img id="logo" src="img/logo.png" width="200px" height="80px" /></a>
	</div>
	<a href="#" id="back_a"><img id="back" src="img/backbtn.png" width="40px" /></a>

	<script type="text/javascript" language="javascript">
			document.getElementById('back_a').onclick = function(){
				history.back();
			};
	</script>

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
			echo '<div id="main_info"><div id="main_pic" class = "row">	<div class ="col-xs-5"><img src="'.$img_src.'"></div><div id="toilet_info" class = "col-xs-7"><h5>'.$b_name.'</h5><h4>'.$t_name.'</h4></div></div></div>';
			echo '<div id="container">';
			while($row=mysql_fetch_array($res)) {
			echo '<div class="element"><a href="post.php?review_no='.$row['review_no'].'" class="post_a"><div class = "row"><div class ="writer col-xs-6">'.$row['nickname'].'</div><div class = "date col-xs-6">'.$row['wdate'].'</div></div><div class ="text">'.$row['content'].'</div><div class = "row"><div class = "col-xs-6">평점 : '.$row['rating'].'</div>	<div class = "col-xs-3">추천수: '.$row['rcmd'].'</div><div class = "col-xs-3">댓글수: '.$row['numof_comment'].'</div>	</div></a></div>';
			}
			echo '</div>';

			echo '<div id = "write"><a href="create_review.php?part=3&toilet_no='.$t_no.'"><button type="button" class="btn btn-info btn-block">리뷰 쓰기</button></a></div>';
		?>


	
	</div>


	<footer>
		<p>&copy; 급하니</p>
	</footer>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="js/slide-menu.js"></script>
	<script type="text/javascript" language="javascript" src="js/gps.js"></script> <!-- 첫 시작화면에서만 쓰는 geolocation api 가능 여부 알려주는 함수들 모음 -->
</body>
</html>
