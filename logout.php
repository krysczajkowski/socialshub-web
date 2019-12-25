<?php 
session_start();

if(isset($_COOKIE['email'])) {
	unset($_COOKIE['email']); 
	setcookie('email', '', time()-5184000); 
}

if(isset($_COOKIE['user_id'])) {
	unset($_COOKIE['user_id']); 
	setcookie('user_id', '', time()-5184000); 
}

if(isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
}

header('Location: signIn.php');

$_SESSION = array();
session_destroy();
exit();

