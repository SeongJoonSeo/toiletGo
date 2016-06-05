<?php
	session_start();
	require 'php/naverOAuth.php';
	//$referer_domain = $_SERVER['HTTP_REFERER'];
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
	<script type="text/javascript" src="http://connect.facebook.net/ko_KR/all.js"></script>
	<script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.2.js"></script>
	<script type="text/javascript" charset="utf-8" src="oauth/jquery.cookie.js"></script>
    <script type="text/javascript" charset="utf-8" src="oauth/naverLogin.js"></script> 
	
	<script>
		var m_no ='<?php echo $_SESSION['no'] ?>'; 
	    var sta = '<?php echo $_SESSION['sta'] ?>';
	</script>

	<style>
		html {
			margin: 0 0;
		}
		body {
			margin: 0px 0px;
			/*padding: 0 0;*/
		}
		div {
			margin: 0px 0px;
			padding: 0 0;
		}
		#header {
			width: 100%;
			height: 70px;
			background-color: rgb(0, 192, 221);
		}
		#header a {
			width: 175px;
			height: 70px;
			margin: 0 auto 0 auto;
			padding: 0 0;
			display: block;
		}
		#logo {
			width: 175px;
			height: 70px;
			margin: 0 auto 0 auto;
		}
		input[type=search] {
			width: 80%;
			height: 40px;
			border: 2px solid black;
			border-radius: 10px;
			font-size: 26px;
			padding: 2px 5px;
		}
		input[type=image] {
			margin-bottom: -11px;
		}
		#search-wrap {
			background-color: rgb(220, 220, 220);
			text-align: center;
			padding: 10px 0;
		}
		#content {
			width: 300px;
			margin: 10px auto 20px auto;
		}
		#content img {
			margin-top: 20px;
		}
		footer {
			background-color: rgb(0, 192, 221);
			margin-bottom: 0;
			height: 70px;
		}
		footer p {
			color: white;
			font-size: 30px;
			margin: auto;
			padding-top: 10px;
			width: 150px;
		}
		@media all and (min-width: 768px) {
			div#content {
				width: 90%;
				margin: auto;
				height: 200px;
			}
			#content ul {
				float: left;
				width: 38%;
				margin: auto 5%;
			}
		}
		img {
			width: 300px;
		}
		</style>
</head>
<body>
	<script>
  /*********************************************************************************/

	window.fbAsyncInit = function() {  
	    FB.init({appId: '759307620878577', status: true, cookie: true,xfbml: true});  
	   
	};    
	      
	(function(d){  
	   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];  
	   if (d.getElementById(id)) {return;}  
	   js = d.createElement('script'); js.id = id; js.async = true;  
	   ref.parentNode.insertBefore(js, ref);  
	 }(document));   


	function facebooklogin() {  
    //페이스북 로그인 버튼을 눌렀을 때의 루틴.  
        FB.login(function(response) {  

            var fbname;  
            var accessToken = response.authResponse.accessToken;  
            FB.api('/me', function(user) {  

                fbname = user.name;
                //response.authResponse.userID
                $.post("./php/fbloginprocess.php", { "userid": user.id, "username": fbname, "fbaccesstoken": accessToken},
                function (responsephp) {
                    //댓글을 처리한 다음 해당 웹페이지를 갱신 시키기 위해 호출.  
                    location.replace('./php/nick.php');
                });
            });    
        }, {scope: 'public_profile,email'}); 
    }

    var a;
	</script>


	
	<div id="header" class="reveal-header">
		<a href="index.php"><img id="logo" src="img/logo.png" /></a>
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

	<div id="content" class="reveal-contents">
		<img onclick="facebooklogin()" style="cursor: pointer;" src="img/facebook.png"/>
	

		<a href="php/naverlogin.php"><img style="cursor: pointer;" src="img/naver.png"></a>

	</div>
	<footer>
		<p>&copy; 급하니</p>
	</footer>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="js/slide-menu.js"></script>

</body>
</html>
