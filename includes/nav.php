<?php 
if($functions->loggedIn()) {
    
    if(isset($_SESSION['user_id'])) {
        $user = $functions->user_data($_SESSION['user_id']); 
    } else {
        $user = $functions->user_data($_COOKIE['user_id']);
    }
}

?>

<nav class="navbar px-0 mx-0 navbar-expand-md navbar-light py-1 shadow-sm sticky-top row" style='opacity: 0.95; background-color: #fff!important;'>

    <!-- Log In or Logout part -->
    <?php if(!$functions->loggedIn()) { ?>
        <a class="col-4 d-flex link" href='signIn.php'>
            <span class='link font-weight-bold mx-auto text-dark'>Log In</span>
        </a>  
    <?php } else { ?>
        <a class="col-4 d-flex link" href='settings.php'>
            <span class='link font-weight-bold mx-auto text-dark'>Settings</span>
        </a>  
    <?php } ?>

    <!-- Logo Part -->
    <a class="col-4 d-flex" href="index.php">
        <img src="logo/logo.png" alt="" style='width: auto!important; height: 35px;' class='mx-auto'>
    </a>

    <!-- Sign In or Settings part -->
    <?php if(!$functions->loggedIn()) { ?>
        <a class="col-4 d-flex link" href='signUp.php'>
            <span class='link font-weight-bold mx-auto text-dark'>Sign Up!</span>
        </a>
    <?php } else { ?>  
        <a class="col-4 d-flex link" href="<?php echo BASE_URL.$user->screenName ?>">
            <span class='link font-weight-bold mx-auto text-dark'>Your Profile</span>
        </a>  
    <?php } ?>
</nav>
