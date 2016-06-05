<?php
	session_start();
	require 'naverOAuth.php';

	$nid_ClientID = 'ohwnLHK2JIsECNGfSEAv';
	$nid_ClientSecret = 'Cp5EHzTxv_';
	$nid_RedirectURL = 	'http://165.132.122.160/~u2013147555/php/nick.php';

	$request = new OAuthRequest( $nid_ClientID, $nid_ClientSecret, $nid_RedirectURL );
	$request -> call_accesstoken();
	$request -> get_user_profile(); 
	

	if($_SESSION['nick'] == true) {
    	header("location:http://165.132.122.160/~u2013147555/index.php");
    	exit();		
	} 
	else {
		header("location:http://165.132.122.160/~u2013147555/php/nickInput.php");	
		exit();
	}
?>

