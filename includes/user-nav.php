<?php 
if($functions->loggedIn()) {
    
    if(isset($_SESSION['user_id'])) {
        $user = $functions->user_data($_SESSION['user_id']); 
    } else {
        $user = $functions->user_data($_COOKIE['user_id']);
    }
}

?>

<nav class="navbar navbar-expand-md navbar-dark py-2 shadow bg-dark sticky-top row" style='opacity: 0.95; background-color: #111!important;'>

    <a class="col-4 d-flex link" href='signIn.php'>
        <span class='link font-weight-bold mx-auto'  style='color: rgba(250, 250, 250, 0.9);'>Log In</span>
    </a>  
    <a class="col-4 d-flex" href="index.php">
            <img src="logo.png" alt="" style='width: 35px; height: 35px;' class='mx-auto'>
    </a>
    <a class="col-4 d-flex link" href='signUp.php'>
        <span class='link font-weight-bold mx-auto'  style='color: rgba(250, 250, 250, 1);'>Sign Up!</span>
    </a>    
</nav>


