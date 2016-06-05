

<!DOCUMENT html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
	<title>쾌변 고!</title>	
	<link rel="stylesheet" type="text/css" href="nick.css" />
</head>
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

<body>
	<div id="wrap">
		<div id="container">
			<div id="header" class="reveal-header">
			<a href="../index.php"><img id="logo" src="../img/logo.png" /></a>
		</div>
		<div class="nickname_input">
			<h2>닉네임을 <br>설정하세요!</h2>
			<form name="nickname" action="./nickprocess.php" method="post">
				<input type="text" name="user_name" id="input_box" />
				<input type="submit" name="submit" value="OK" />
			</form>
		</div>	
		</div>		
	</div>
	<footer>
		<p>&copy; 급하니</p>
	</footer>
</body>
</html>


