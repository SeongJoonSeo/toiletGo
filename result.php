<?php
	session_start();
	$connect = mysql_connect("localhost", "u2013147555", "2013147555");
	$db_con = mysql_select_db("d2013147555", $connect);
	$sql = "select * from building;";
	$result = mysql_query($sql, $connect);
	$number=1;
?>


<?php while ($row = mysql_fetch_array($result))
{
	$b_no[]=$row[building_no];
	$latitude[]=$row[latitude];
	$longitude[]=$row[longitude];
	}
	mysql_close();
?>

<!DOCUMENT html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
	<title>검색결과</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/slide-menu.css" />
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="stylesheet" type="text/css" href="css/building_board.css" />
	<!--로그인 필요확인시 필요-->
	<script> 
	    var sta = '<?php echo $_SESSION['sta'] ?>';
	</script>
	<style>
		article {
			padding-left: 20px;
			padding-bottom: 20px;
		}
		#building_info {
			margin-left: auto;
			margin-right: auto;
			width:100%;
			max-width: 580px;
		}

	</style>
</head>

<body>
	<div id="header" class="reveal-header">
		<a href="index.php"><img id="logo" src="img/logo.png" /></a>
	</div>
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
	
	<section class="result">
		<div id="map" style="width: 100%; max-width: 900px; height: 50%;"></div>
		<!--<article>
			<p>검색결과: 연세대학교 제 1공학관</p>
			<p> 평점: </p>
			<a href="result_detail.html">상세페이지</a>
		</article>-->
		<button id="button">건물 새로 추가하기</button>
	</section>

	<div id="building_info">
	</div>

	<footer>
		<p>&copy; 급하니<span id="test"></span></p>
	</footer>
	<script type="text/javascript" language="javascript" src="js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/slide-menu.js"></script>
	<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=ea4eb01e6476186f5885e95baa3657fb&libraries=services"></script>
	<script type="text/javascript" language="javascript" src="js/result.js?version=2"></script>
	<script type="text/javascript" language="javascript">
		var addr = '<?php echo $_GET["addr"]; ?>'; // 맞는 코드(addr에 전달됨)
		
		var b_no = new Array(" <?=implode ( "\",\"" , $b_no); ?> ");
		var lati = new Array(" <?=implode ( "\",\"" , $latitude); ?> ");
		var long = new Array(" <?=implode ( "\",\"" , $longitude); ?> ");
		
		// 주소-좌표 변환 객체를 생성합니다 - 다음의 라이브러리 사용
		var geocoder = new daum.maps.services.Geocoder();
		var coords=null;
		var map = null;
		
		geocoder.addr2coord(addr, function(status, result) {
			// 정상적으로 검색이 완료됐으면
			if (status === daum.maps.services.Status.OK) {
				coords = new daum.maps.LatLng(result.addr[0].lat, result.addr[0].lng);
				map = makeMap(coords,lati,long,b_no); // result.js 파일에 들어있는 함수
			} else { // 없으면 keywordSearch - 다음 라이브러리 사용
				var places = new daum.maps.services.Places();

				var callback = function(status, result) {
					if (status === daum.maps.services.Status.OK) {
						coords = new daum.maps.LatLng(result.places[0].latitude, result.places[0].longitude);
						// 이 함수는 result.js 파일에 들어있다.
					} else {
						document.getElementById('map').textContent = "찾을 수 없습니다.";
					}
					map = makeMap(coords,lati,long,b_no);
				};
				places.keywordSearch(addr, callback);
			}
			//map = makeMap(coords);
		});

		
		var elButton = document.getElementById('button');
		elButton.addEventListener('click', function() {
			makeMarker(map);
		}, false);			// 버튼에 클릭 이벤트를 등록합니다
	</script>
</body>
</html>
