<?php
session_start();
require_once "../functions/init.php";

if(!isset($_SESSION['access_token'])) {
    header('Location: ../index.php');
}

if($functions->userIdByEmail($_SESSION['fb-userData']['email'])) {
    //User exist, logIn him

    $email = $_SESSION['fb-userData']['email'];
    $userId = $functions->userIdByEmail($email);
    
    $_SESSION['user_id'] = $userId;
    
    $user = $functions->user_data($userId);
        
    setcookie('email', $email, time() + 5184000, '/'); //Setting cookie to not log out user
    setcookie('user_id', $userId, time() + 5184000, '/');  

    header('Location: '. BASE_URL. $user->screenName);
    
    exit();
} else {
    //User does not exist, make him an account
    
    // Setting mini tutorial for user
    setcookie('new-user-tut1', '1', time()+20, '/'); 

    $email = $_SESSION['fb-userData']['email'];
    
    //Filtering and deleting whitespace characters from first name and last name
    $firstName = $functions->checkInput(preg_replace('/\s+/', '', $_SESSION['fb-userData']['first_name']));
    $lastName  = $functions->checkInput(preg_replace('/\s+/', '', $_SESSION['fb-userData']['last_name']));
    $validationCode = md5(microtime() . $lastName);
    $randomNumber = rand(9,14);
    
    //Making as unique as possibble screenName for new user
    $screenName = substr($firstName, 0, 4) . substr($lastName, 0, 4) . substr($validationCode, 0, $randomNumber);
    
    
    $functions->register_user($email, '', $screenName, 1);
    
    $userId = $functions->userIdByEmail($email);
    $user = $functions->user_data($userId);
    
    setcookie('email', $email, time() + 5184000, '/'); //Ustawiamy sesje zeby go kilka miesiecy nie wylogowywalo
    setcookie('user_id', $userId, time() + 5184000, '/');   
    
    
    $_SESSION['user_id'] = $userId;
    
    header('Location: '. BASE_URL .'settings.php');

    exit();

}


?>