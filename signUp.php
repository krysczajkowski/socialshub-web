<?php 
    error_reporting(0);

    ob_start();

    require_once "fb-files/config.php"; //session start is in this file 

    if (isset($_SESSION['access_token'])) {
        header('Location: fb-files/fb-logIn.php');
        exit();
    }

    $redirectURL = "https://socialshub.net/fb-files/fb-callback.php";
    $permissions = ['email'];
    $loginURL = $helper->getLoginUrl($redirectURL, $permissions);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> 
<script>
    function onSubmit(token) {
        document.getElementById("i-recaptcha").submit();
    }
</script>
       
    <?php include 'includes/head.php'; 
    
    
    if($functions->loggedIn()) {
        
        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else if (isset($_COOKIE['user_id'])) {
            $user_id = $_COOKIE['user_id'];
        }
        
        $user = $functions->user_data($user_id);
        echo("<script>location.href = '".BASE_URL.$user->screenName."'</script>");
        exit();       
    }
    
    if($_SESSION['rec_pass'] === 1) {
        $_SESSION['rec_pass'] = 0;
        $email = $_SESSION['rec_email'];
        $functions->recover_password($email);
    }
    
    
    if($_SESSION['registerUser'] === 1) {
        $_SESSION['registerUser'] = 0;
        $reg_email = $_SESSION['reg_email'];
        $reg_password = $_SESSION['reg_password'];
        $reg_name = $_SESSION['reg_name'];
        
        // Setting mini tutorial for user
        setcookie('new-user-tut1', '1', time()+20); 

        $functions->register_user($reg_email, $reg_password, $reg_name, 0);
        echo("<script>location.href = '".BASE_URL."settings.php';</script>");  
    }
    
    //Register Code
    $eRegister = '';

    if(isset($_POST['nameRegister']) && isset($_POST['emailRegister']) && isset($_POST['passwordRegister'])) {

        //VALIDATE VARIABLES
        $reg_name     = $functions->checkInput($_POST['nameRegister']);
        $reg_email    = $functions->checkInput($_POST['emailRegister']);
        $reg_password = $functions->checkInput($_POST['passwordRegister']);
        $terms    = isset($_POST['accept-terms']);
        $privacy  = isset($_POST['accept-privacy']);


        if(!empty($username) || !empty($reg_email) || !empty($reg_password)) {

            if(!filter_var($reg_email, FILTER_VALIDATE_EMAIL)) {
                $eRegister = 'Invalid email.';
            } else if (strlen($reg_name) < 2 || strlen($reg_name) > 25) {
                $eRegister = 'Name must be between 2 and 25 characters.';
            } else if ($functions->name_exist($reg_name)) {
                $eRegister = 'Sorry, this name is already taken.';
            } else if(!preg_match('/^[a-zA-Z0-9]+$/', $reg_name)) {
                $eRegister = 'Only letters, numbers and white space allowed in name field.';
            } else if ($functions->email_exist($reg_email)) {
                $eRegister = 'This email is already in use.';
            } else if (strlen($reg_password) < 5 || strlen($reg_password) > 25) {
                $eRegister = 'Password must be between 5 and 25 characters';
            }else if ($terms != 'on' || $privacy != 'on'){
                $eRegister = 'All checkbox are required';
            } else {

                // Call the function post_captcha
                $res = $functions->post_captcha($_POST['g-recaptcha-response']);

                if (!$res['success']) {
                    // What happens when the reCAPTCHA is not properly set up
                    $_SESSION['reg_password'] = "Sorry you can't be registered now.";
                } else {
                    //Adding user to database
                                 
                    // Setting mini tutorial for user
                    setcookie('new-user-tut1', '1', time()+20); 

                    $functions->register_user($reg_email, $reg_password, $reg_name, 0);
                    echo("<script>location.href = '".BASE_URL."settings.php';</script>");              
                }
            }

        } else {
            $eRegister = 'All fields are required.';
        }
    }

    ?>
    <body>  
       <?php include 'includes/nav.php'; ?>

       
        <!-- MESSAGE IF USER DELETED ACCOUNT -->
        <?php 
            if(isset($_COOKIE['account_deleted'])) { 
                include 'includes/delete-account-popup.php';
            }  
        ?>
        
        
        <div class="container">
            <div class="d-flex justify-content-center">
                <img src="socialshub-images/signUp-link.png" alt="Sign Up 'Your link' image by Ksawery Sokalski" class='img-fluid img-responsive mt-4 signUp-link'> 
            </div>

            <div class="row">
                <div class="col-md-5 medium-font mt-4 mb-4 order-md-1 order-2">
                    <!-- LEFT LIST -->
                    <div class="row mt-2 ml-1">
                        <img src="gifs/signUp-iphone-gif.gif" class='signUp-iphone-gif'/>
                    </div>
                </div>

                <!-- RIGHT PANEL -->
                    <div class='col-md-6 mt-5 order-md-2 order-1'>

                        <div class="col-md-10 mt-3 mb-4">
                            <div class="pt-2">
                                <div class="font-open-sans">
                                    <p class='font-weight-bold my-0' style='font-size: 1.1rem;'>One link driving your followers to all your content.</p>
                                    <p class='text-muted font-weight-bold my-1' style='font-size: 0.9rem;'>Tool for everyone.</p>
                                </div>

                                <form action="signUp.php" method="post" id='i-recaptcha'>
                                    <input type="text" value='<?php if(isset($reg_name)) {echo $reg_name;} ?>' class="form-control" placeholder='Name' name='nameRegister'>
                                    <input type="email" value='<?php if(isset($reg_email)) {echo $reg_email;} ?>' class="form-control mt-2" placeholder='Email' name='emailRegister'>
                                    <input type="Password" value='<?php if(isset($reg_password)) {echo $reg_password;} ?>' class="form-control mt-2" placeholder='Password' name='passwordRegister'>
                                    <!-- TERMS CHECKBOX -->
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input" id="accept-terms" name='accept-terms'>
                                        <label class="custom-control-label mt-1" for="accept-terms" style='font-size: 0.95rem;'>I agree to <a href="terms.php" target="_blank" class='text-primary'>Terms of Use</a></label>
                                    </div>

                                    <!-- PRIVACY POLICY, COOKIES CHECKBOX -->
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input" id="accept-privacy" name='accept-privacy'>
                                        <label class="custom-control-label" for="accept-privacy" style='font-size: 0.95rem;'>I agree to the <a href="privacy-policy.php" target="_blank" class='text-primary'>Privacy Policy</a>, including use of cookies</label>
                                    </div>
                                    <!-- We can't use any name or id on g-recaptcha button -->
                                    <input type="submit" class='g-recaptcha btn btn-dark py-2 font-weight-bold btn-block mt-2' value = 'Create Account' data-sitekey="6LeSqqAUAAAAACHnB6-dJnds0awuHiG74jqecIcb" data-callback="onSubmit" id='signUp-submit'>

                                    <?php $functions->display_error_message($eRegister); $eRegister = '';?>
</form>

                            </div>
                            <a class="fb connect mt-2 w-100 text-center text-white" id='fb-index-button'>Continue with Facebook</a>
                            <div id="terms-error-message" class='text-danger'></div>

                        </div>
                    </div>
            </div>
        </div>
       
    <?php
        //Setting cookie to not show cookie popup and we are refreshing page
        if(isset($_GET['accept-cookies'])){
            setcookie('accept-cookies', 'true', time() + 31556925);
            header('Location: '.BASE_URL.$profileData->screenName);
        }
    ?>


    <!-- This website is using cookies information here -->
    <?php include 'includes/cookie-info.php' ?>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='js/search.js'></script>
    <script>
        // Disable FB Button after click
        $("#fb-index-button").click(function(){
            if($('#accept-terms').is(':checked') && $('#accept-privacy').is(':checked')) {
                $("#fb-index-button").addClass("btn disabled");
                var loginURL = "<?php echo $loginURL; ?>";
                window.location.assign(loginURL);
            }
            else {
                $("#terms-error-message").text("Please accept the terms & privacy policy.")
            }
        });

        // Disable Register Button after click
        $("#signUp-submit").click(function(){
            if($('#accept-terms').is(':checked') && $('#accept-privacy').is(':checked')) {
                $("#signUp-submit").addClass("btn disabled");
            }
        });        
    </script>
    </body>
</html>
