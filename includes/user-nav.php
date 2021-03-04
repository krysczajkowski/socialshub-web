<?php 
if(isset($_SESSION['user_id'])) {
    $user = $functions->user_data($_SESSION['user_id']); 
} else {
    $user = $functions->user_data($_COOKIE['user_id']);
}
?>

<nav class="navbar px-0 mx-0 navbar-expand-md navbar-light py-1 shadow-sm sticky-top row" style='opacity: 0.95; background-color: #fff!important;'>
    <a class="col-4 d-flex link" href='settings.php'>
        <span class='link font-weight-bold mx-auto text-dark'>Settings</span>
    </a>  

    <!-- Logo Part -->
    <a class="col-4 d-flex" href="index.php">
        <img src="logo/logo.png" alt="" style='width: auto!important; height: 35px;' class='mx-auto'>
    </a>

    <a class="col-4 d-flex link" href="<?php echo BASE_URL.$user->screenName ?>">
        <span class='link font-weight-bold mx-auto text-dark'>Your Profile</span>
    </a>  
</nav>



