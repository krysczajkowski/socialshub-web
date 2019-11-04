<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	require_once "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => '951742485224459',
		'app_secret' => '5f0a8359bed6b24f6de11b828cc03198',
		'default_graph_version' => 'v5.0'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>