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
    <!-- reCaptcha invisible code  -->
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

        header('Location: '.$user->screenName);
        exit();       
    }

    if($_SESSION['rec_pass'] === 1) {
        $_SESSION['rec_pass'] = 0;
        $email = $_SESSION['rec_email'];
        $functions->recover_password($email);
    }

//LOGIN CODE

$eLogin = '';
$sLogin = '';

if(isset($_POST['loginEmail']) && !empty($_POST['loginEmail']) &&isset($_POST['loginPassword'])) {
    $email     = $_POST['loginEmail'];
    $password  = $_POST['loginPassword'];
    $remember  = isset($_POST['remember']);
    
    if(!empty($email) && !empty($password)) {
        $email     = $functions->checkInput($email);
        $password  = $functions->checkInput($password);
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $eLogin = 'Invalid format of email.';
        } else {
            $user = $functions->login_user($email, $password, $remember);
            if($user != null) {
                header('Location: '.BASE_URL.$user->screenName);
                exit();
            }else{
                $eLogin = "Your credentials are not correct.";
            }
        }
        
    } else {
        $eLogin = "Your credentials are not correct.";
    }
}

//FORGOT PASSWORD CODE
if(isset($_POST['forgot-password'])) {
    echo("<script>location.href = '".BASE_URL."'/recover.php</script>");
}


    ?>
    <body>  
    <?php include 'includes/nav.php'; ?>

        <!-- MESSAGE IF USER DELETED ACCOUNT -->
        <?php if(isset($_COOKIE['account_deleted'])) { ?>
            <div class='alert bg-danger text-white alert-dismissable mt-0 mb-4 p-2'>
                <div class="container">
                    <button type="button" class='close' data-dismiss='alert'>
                        <span>&times;</span>
                    </button>
                   <span class='text-white' style='color: #c0c0c0;'>Your account has been deleted. <b>We hope you come back soon.</b></span>
                </div>
            </div>
        <?php }  ?>
            
        <div class="container mt-3">
            <div class="row">

                    <div class="col-12 col-md-10 col-lg-6 offset-md-1 offset-lg-3 mt-5">
                        <div class="card card-body shadow-sm"> 
                            <form method='post'>
                                <input type="text" value='<?php if(isset($email)) {echo $email ;} ?>' class="form-control" placeholder='Email' name='loginEmail'>
                                <input type="Password" class="form-control mt-2" placeholder='Password' name='loginPassword'>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" id="remember" name='remember' checked>
                                    <label class="custom-control-label" for="remember">Remember me</label>
                                </div>
                                <button class="btn btn-primary mt-2" name='login' id='login'>Login</button>
                                
                                <a href="recover.php" class='d-block text-muted mt-1 p-0 d-block'>Forgot Password?</a>
                            </form>
                            <?php
                            $functions->display_error_message($eLogin);
                            $functions->display_success_message($sLogin);
                            if(isset($_SESSION['sLogin'])) {
                                $functions->display_success_message($_SESSION['sLogin']);
                                $_SESSION['sLogin'] = '';
                            }
                            ?>
                        </div> 
                        <a href="<?php echo $loginURL; ?>" class="text-center fb connect mt-2 w-100" id='fb-index-button'>Continue with Facebook</a>                        
                        
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
    <?php if(!$functions->loggedIn() && !isset($_COOKIE['accept-cookies'])) {  ?>

    <div style='margin-top: 150px;'></div>
    <div class='alert alert-dark bg-light text-black alert-dismissable fixed-bottom m-0'>
        <div class="container">

            <div class="d-flex">
                <span style='font-size: 1.1rem;' class='pt-1'>SocialsHub.net uses cookies to give you the best possible experience.<a href="privacy-policy.php"> Read More</a></span>

                <!-- Accept cookie button -->
                <a href="?accept-cookies" class='btn btn-success font-weight-bold ml-auto' style='font-size: 1.1rem;'>OK</a>
            </div>

        </div>
    </div>
    <?php }
    ?>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script>
        $("#fb-index-button").on("click", function() {
            $("#fb-index-button").addClass("btn disabled");
        });
        </script>
    </body>
</html>
