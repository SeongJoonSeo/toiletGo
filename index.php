<?php
	session_start();
?>

<!DOCUMENT html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
	<title>쾌변 고!</title>
	<link rel="stylesheet" type="text/css" href="css/slide-menu.css" />
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="stylesheet" type="text/css" href="css/home.css" />
	<script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.2.js"></script>
	<script type="text/javascript" charset="utf-8" src="oauth/jquery.cookie.js"></script>
    <script type="text/javascript" charset="utf-8" src="oauth/naverLogin.js"></script>
	<script> 
	    var sta = '<?php echo $_SESSION['sta'] ?>';
	</script>
	<style>
		button {
			background-color: none;
		}
	</style>

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
	<div id="site_info">
		<h3>지금 당장 쾌변고!</h3>		
		<p>
		속은 불편한데, 주변에 쾌적한 화장실을 잘 모른다?
		주변 화장실 꿀팁은 많이 알고있는데, 공유할 곳이 없다?
		쾌변고에서 정보공유/화장실검색/화장실평가를 이용하세요!
		</p>		
	</div>

	<div id="content" class="reveal-contents">
		<ul>게시글
			<li>title1</li>
			<li>title2</li>
			<li>title3</li>
			<li>title4</li>
		</ul>
		<ul>순위
			<li>1위</li>
			<li>2위</li>
			<li>3위</li>
			<li>4위</li>
		</ul>
	</div>
	<footer>
		<p>&copy; 급하니</p>
	</footer>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="js/slide-menu.js"></script>
	<script type="text/javascript" language="javascript" src="js/gps.js"></script> 

</body>
</html>
