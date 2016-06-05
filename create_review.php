<?php
	@header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
	session_start();
	if(!$_SESSION['sta']){
		header("location:http://165.132.122.160/~u2013147555/login.php");
	}
//수정 해야 하는 부분 
	$mem= $_SESSION['no'];
	$part = $_GET['part'];
?>

<!DOCUMENT html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
	<title>쾌변 고!</title>
	<link rel="stylesheet" type="text/css" href="css/slide-menu.css" />
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.2.js"></script>
	<script> 
	    var sta = '<?php echo $_SESSION['sta'] ?>';
	</script>
	<style type="text/css">
		#back_a {
			position: absolute;
			right:8%;
			top: 17px;
		}
	</style>
</head>
<body>
	<div id="header" class="reveal-header">
		<a href="index.php"><img id="logo" src="img/logo.png" /></a>
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
	
	<form action="create.php" method="post" enctype="multipart/form-data" >
	
	<?php
		if($part ==1){	//part 가 1 이면 건물이름부터 써야댐 
			echo "<div id='building'>";
			echo "<label>건물이름:  ";
			echo '<input type="text" name="building_name" required />';
			echo "</label>";
			echo '</div>';

			echo "<div style='display:none;'>";
			echo '<input type="number" name="long" value="'.$_GET['lng'].'" />';
			echo '<input type="number" name="lati" value="'.$_GET['lat'].'" />';
			echo "</div>";
		}
		else if($part ==2){	//part가 2면 빌딩정보도 포스트로 보내야댐 
			echo "<div style='display:none;'>";
			echo '<input type="number" name="building_no" value="'.$_GET['building_no'].'">';
			echo "</div>";
		}
	?>

	<?php
		if($part == 1 || $part == 2){	//part가 1,2면 화장실 이름도 써야댐 
			echo "<div id='toilet'>";
			echo "<label>화장실이름: ";
			echo '<input type="text" name="toilet_name" required />';
			echo "</label>";
			echo '</div>';
		}
		else {	//part가 3이면 화장실 정보도 포스트로 보냄 
			echo "<div style='display:none;'>";
			echo '<input type="number" name="toilet_no" value="'.$_GET['toilet_no'].'">';
			echo "</div>";
		}
	?>
	<div style="display: none;"> <!--보이지 않지만 포스트로 보내야하는 내용 -->
		<input type="number" name="member_no" value=<?php echo '"'.$mem.'"'; ?> />
		<input type="number" name="part" value=<?php echo '"'.$part.'"'; ?> />
		<input type="text" name="sub" value="ok" />

	</div>

	<div id="form-wrap">
		<textarea type="content" name="cont" rows="15" required style="width: 100%;"></textarea>
		<label>평점: 1 <input type="range" name="rating" min= "1" max = "5" /> 5
		</label>
		
		<input type="file" name="image" />
		<br>

		<input type="submit" value="쓰기!">
	</div>
	</form>

	<footer>
		<p>&copy; 급하니</p>
	</footer>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="js/slide-menu.js"></script>


	
</body>
</html>
