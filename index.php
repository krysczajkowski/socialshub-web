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
       
    <?php include 'includes/head.php'; 
    
    //ReCaptcha Invisble code
    
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
        
        $functions->register_user($reg_email, $reg_password, $reg_name, 0);
        echo("<script>location.href = '".BASE_URL."welcome.php';</script>");  
        //header('Location: welcome.php');
        
        
    }
    
    ?>
    <body>  
       
        <div class='alert alert-white bg-dark text-white alert-dismissable m-0'>
            <div class="container">
                <button type="button" class='close' style='color: #fff;' data-dismiss='alert'>
                    <span>&times;</span>
                </button>
               <span class='' style='font-size: 0.9rem; color: #c0c0c0;'>SocialsHub uses cookies to give you the best possible experience. <a href="privacy-policy.php" style='color: #c0c0c0;'>Read More</a></span>
            </div>
        </div>

       
        <!-- MESSAGE IF USER DELETED ACCOUNT -->
        <?php if(isset($_COOKIE['account_deleted'])) { ?>
            <div class='alert bg-danger text-white alert-dismissable mt-0 mb-4 p-2'>
                <div class="container">
                    <button type="button" class='close' data-dismiss='alert'>
                        <span>&times;</span>
                    </button>
                   <span class='text-white' style='font-size: 1rem; color: #c0c0c0;'>Your account has been deleted. We hope you come back soon.</span>
                </div>
            </div>
        <?php }  ?>
        
        
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-6 medium-font mt-4 ">
                    <div class="container mt-4 font-open-sans">
                            
                            
                            <span style="font-size: 2.3rem;" class='font-weight-bold'>SocialsHub</span> 
                            <p  style="font-weight: 600; font-size: 1.4rem;">SocialsHub is social links book.</p>   
                    </div>

                    <!-- LEFT LIST -->

                    <div class="row mt-4 pt-3 ml-1">
                        <div class="col-2">
                            <i class="far fa-address-book fa-2x mt-2 ml-2 bookmark-color"></i>
                        </div>
                        <div class="col-10">
                            <div class="d-block">
                                <span class='index-list-header'>Book of social links</span>
                            </div>
                            <div class="d-block" style='line-height: 28px;'>
                                <span class='index-list-text'>Find everyone's social links and store your own</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 pt-3 ml-1">
                        <div class="col-2">
                            <i class="fas fa-hashtag fa-2x mt-2 ml-2 vanishing-posts-color"></i>
                        </div>
                        <div class="col-10">
                            <div class="d-block">
                                <span class='index-list-header'>Vanishing Posts</span>
                            </div>
                            <div class="d-block" style='line-height: 28px;'>
                                <span class='index-list-text'>Posts that disappear - you can only see newest posts</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 pt-3 ml-1">
                        <div class="col-2">
                            <i class="fas fa-share fa-2x mt-2 ml-2 share-color"></i>
                        </div>
                        <div class="col-10">
                            <div class="d-block">
                                <span class='index-list-header'>Share</span>
                            </div>
                            <div class="d-block" style='line-height: 28px;'>
                                <span class='index-list-text'>Share your all social media by only one link</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT PANEL -->
                    
                    <div class="col-md-6 mt-3">
                        <div class="col-md-10">
                            <div class="card card-body shadow-sm">
                                <?php include 'includes/login.php'; ?>
                                <a href="<?php echo $loginURL; ?>" class="fb connect mt-2" style='width: 65%;'>Continue with Facebook</a>
                            </div>
                        </div>

                        <div class="col-md-10 mt-3 mb-4">
                            <div class="card card-body shadow-sm">
                                <div class="font-open-sans">
                                    <p class='h5 font-weight-bold'>Join future world largest social media website.</p>
                                    <p class='text-muted'><strong style='letter-spacing: 0.5px;'>It's easy and quick.</strong></p>
                                </div>
                                 <?php include 'includes/signup-form.php'; ?>

                            </div>
                            
                        </div>
                    </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
