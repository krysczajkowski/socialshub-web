<?php 
 include 'functions/init.php';

    if($functions->loggedIn()) {
        
        if(isset($_SESSION['user_id'])) {
            $user = $functions->user_data($_SESSION['user_id']); 
        } else {
            $user = $functions->user_data($_COOKIE['user_id']);
        }
    }

    //error_reporting(0);

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
<html lang="en">

  <!-- reCaptcha invisible code  -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
      function onSubmit(token) {
          document.getElementById("i-recaptcha").submit();
      }
  </script>

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="logo.png">
		<title>Sign Up | SocialsHub.net</title>
    <meta name='description' content='SocialsHub - website with social media of your friends, celebrities and other people.'>
    <meta name='keywords' content='social media, social link, social links, socialhub, social hub, socials hub, friends, celebrity, instagram, twitter, facebook, snapchat, twitch, tiktok, discord, mail, poland, website, bio, book for social media, book, book of social media, wikipedia, socialshub, wroclaw, profile visits, search, social media search, social link search, social links, links hub, social network, network links, one url'>
    <meta name='author' content='Krystian Czajkowski'>

    <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600|Montserrat:200,300,400" rel="stylesheet">

		<link rel="stylesheet" href="assets/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="assets/fonts/ionicons/css/ionicons.min.css">
   <!--  <link rel="stylesheet" href="assets/fonts/law-icons/font/flaticon.css"> -->

    <link rel="stylesheet" href="assets/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/slick-theme.css">

    <link rel="stylesheet" href="assets/css/helpers.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/landing-2.css">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-148899862-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-148899862-1');
    </script>
	</head>


  <?php
  
  
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
                $eRegister = 'Sorry, the email is invalid.';
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

	<body data-spy="scroll" data-target="#pb-navbar" data-offset="200">

    <nav class="navbar navbar-dark pb_navbar pb_scrolled-light" id="pb-navbar">
      <div class="container">
        <a class="navbar-brand font-weight-bold" href="index.php">SocialsHub.net</a> 
        <span class='ml-auto'>
          <a class='btn btn-success font-weight-bold px-4' href='https://socialshub.net/signIn.php'>Log In</a>
        </span>
      </div>
    </nav>
    <!-- END nav -->

    <section class="pb_cover_v3 overflow-hidden cover-bg-indigo cover-bg-opacity text-left pb_gradient_v1" id="section-home">






      <div class="container mb-5">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6">
            <h1 class="mb-3 font-weight-bold text-light">ALL YOUR CONTENT IN ONE LINK</h1>
            <div class="sub-heading">
              <p class="mb-4">FREE tool for instagram bio, twitter posts, tiktok videos etc.</p>
            </div>
          </div>
          <div class="col-md-1">
          </div>
          <div class="col-md-5 relative align-self-center py-5">

            <form action="signUp.php" method="post" id='i-recaptcha' class="bg-white rounded pb_form_v1 my-5">
              <h2 class="mb-4 mt-0 text-center">Sign Up for Free</h2>
              <div class="form-group">
                <input type="text" class="form-control pb_height-50 reverse" placeholder="Username" value='<?php if(isset($reg_name)) {echo $reg_name;} ?>' placeholder='Username' name='nameRegister'>
              </div>
              <div class="form-group">
                <input type="email" class="form-control pb_height-50 reverse" placeholder="Email"  value='<?php if(isset($reg_email)) {echo $reg_email;} ?>' name='emailRegister'>
              </div>
              <div class="form-group">
                <input type="password" class="form-control pb_height-50 reverse" placeholder="Password" value='<?php if(isset($reg_password)) {echo $reg_password;} ?>' name='passwordRegister'>
              </div>
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
              <div class="form-group mt-2">
                <input type="submit" class='g-recaptcha btn btn-primary btn-lg btn-block pb_btn-pill btn-shadow-blue' value = 'Create Account' data-sitekey="6LeSqqAUAAAAACHnB6-dJnds0awuHiG74jqecIcb" data-callback="onSubmit"  id='signUp-submit'>
              </div>

              <?php $functions->display_error_message($eRegister); $eRegister = '';?>

              <!-- Continue With Facebook -->
              <a class="fb connect mt-2 text-center w-100 text-white" id='fb-index-button'>Continue with Facebook</a>      
              <div id="terms-error-message" class='text-danger'></div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->


    <section class="pb_section bg-light pb_slant-white pb_pb-250" id="section-features">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 mb-5 px-5">
            <img src="assets/images/iphone_2.png" alt="Image placeholder" class="img-fluid">
          </div>
          <div class="col-lg-8 pl-md-5 pl-sm-0">
            <div class="row">
              <div class="col">
                <h2 class='font-weight-bold'>Application Features</h2>
              </div>
            </div>
            <div class="row">
              <div class="col-lg">

                <div class="media pb_feature-v2 text-left mb-1 mt-5">
                  <div class="pb_icon d-flex mr-3 align-self-start pb_w-15"><i class="ion-ios-bookmarks-outline pb_icon-gradient"></i></div>
                  <div class="media-body">
                    <h3 class="mt-2 mb-2 heading font-weight-bold text-dark">Minimalist Design</h3>
                    <p class="text-sans-serif pb_font-16">A beautiful and minimalist design.</p>
                  </div>
                </div>

                <div class="media pb_feature-v2 text-left mb-1 mt-5">
                  <div class="pb_icon d-flex mr-3 align-self-start pb_w-15"><i class="ion-ios-infinite-outline pb_icon-gradient"></i></div>
                  <div class="media-body">
                    <h3 class="mt-2 mb-2 heading font-weight-bold text-dark">Unlimited Posibilities</h3>
                    <p class="text-sans-serif pb_font-16">Share all your content by just a one link anywhere you want!</p>
                  </div>
                </div>

              </div>
              <div class="col-lg">

                <div class="media pb_feature-v2 text-left mb-1 mt-5">
                  <div class="pb_icon d-flex mr-3 align-self-start pb_w-15"><i class="ion-ios-speedometer-outline pb_icon-gradient"></i></div>
                  <div class="media-body">
                    <h3 class="mt-2 mb-2 heading font-weight-bold text-dark">Fast Loading</h3>
                    <p class="text-sans-serif pb_font-16">Your profile will always load very fast.</p>
                  </div>
                </div>


              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="pb_section pb_slant-white" id="section-faq">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-6 text-center mb-5">
            <h5 class="text-uppercase pb_font-15 mb-2 pb_color-dark-opacity-3 pb_letter-spacing-2"><strong>FAQ</strong></h5>
            <h2>Frequently Asked Questions</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md">
            <div id="pb_faq" class="pb_accordion" data-children=".item">
              <div class="item">
                <a data-toggle="collapse" data-parent="#pb_faq" href="#pb_faq1" aria-expanded="true" aria-controls="pb_faq1" class="pb_font-22 py-4">What is SocialsHub?</a>
                <div id="pb_faq1" class="collapse show" role="tabpanel">
                  <div class="py-3">
                  <p>SocialsHub is a place, where you store all your social network profiles and any other links. It makes sharing your content to your audience extremally easy.</p>
                  <p>It was created by 16 years old programmer <a href="https://socialshub.net/krysczajkowski" target="_blank">Krystian Czajkowski</a></p>
                  </div>
                </div>
              </div>
              <div class="item">
                <a data-toggle="collapse" data-parent="#pb_faq" href="#pb_faq2" aria-expanded="false" aria-controls="pb_faq2" class="pb_font-22 py-4">How much does it cost?</a>
                <div id="pb_faq2" class="collapse" role="tabpanel">
                  <div class="py-3">
                    <p>It's free and always will be.</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <a data-toggle="collapse" data-parent="#pb_faq" href="#pb_faq3" aria-expanded="false" aria-controls="pb_faq3" class="pb_font-22 py-4">Where can I share my SocialsHub profile?</a>
                <div id="pb_faq3" class="collapse" role="tabpanel">
                  <div class="py-3">
                    <p>It was created for instagram bio, but you can share your SocialsHub profile absolutely anywhere. It's great for twitter or facebook posts, twitch, tiktok, tumblr, pinterest. ANYWHERE</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="pb_xl_py_cover overflow-hidden pb_slant-light pb_gradient_v1 cover-bg-opacity-8"  style="background-image: url(assets/images/1900x1200_img_5.jpg)">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-12 justify-content-center">
            <h2 class="heading mb-5 pb_font-40">Create your most useful URL</h2>
            <p class="mb-4 text-white justify-content-center">and make your life much easier.</p>
          </div>
          <div class="col-12 d-flex justify-content-center" id='get-started-section'>
            <a href="#section-home" class='btn btn-primary font-weight-bold px-4 py-2' style='font-size: 1.4rem;'>GET STARTED FOR FREE</a>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <footer class="pb_footer bg-light" role="contentinfo">
      <div class="container">
        <div class="row">
          <div class="col text-center">
            <p class="pb_font-14">&copy; 2019. All Rights Reserved. <br>  <a href="https://uicookies.com/bootstrap-html-templates/">Bootstrap Templates</a> by uiCookies</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- loader -->
    <div id="pb_loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#1d82ff"/></svg></div>



    <script src="assets/js/jquery.min.js"></script>

    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/jquery.mb.YTPlayer.min.js"></script>

    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/jquery.easing.1.3.js"></script>

    <script src="assets/js/main.js"></script>

    <script src='js/accept-cookies.js'></script>
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

        // Smooth Scrolling
        $('#get-started-section a').on('click', function(e) {
          //Check for hash value
          if(this.hash !== '') {
            //Prevent the default behavior 
            e.preventDefault();

            //Store hash
            const hash = this.hash;

            //Animate smooth scroll
            $('html, body').animate({
              scrollTop: $(hash).offset().top
            }, 900, function() {
              //Add hash to URL after scroll
              window.location.hash = hash;
            });
          }
        })     
    </script>

	</body>
</html>
