<?php
	require './naverOAuth.php';

	$nid_ClientID = 'ohwnLHK2JIsECNGfSEAv';
	$nid_ClientSecret = 'Cp5EHzTxv_';
	$nid_RedirectURL = 	'http://165.132.122.160/~u2013147555/php/nick.php';

	$request = new OAuthRequest( $nid_ClientID, $nid_ClientSecret, $nid_RedirectURL );
	$request -> set_state();
	$request -> request_auth();

?>