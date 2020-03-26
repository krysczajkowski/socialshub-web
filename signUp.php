<?php 
 include 'functions/init.php';

    if($functions->loggedIn()) {
        
        if(isset($_SESSION['user_id'])) {
            $user = $functions->user_data($_SESSION['user_id']); 
        } else {
            $user = $functions->user_data($_COOKIE['user_id']);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name='description' content='SocialsHub - website with social media of your friends, celebrities and other people.'>
    <meta name='keywords' content='social media, social link, social links, socialhub, social hub, socials hub, friends, celebrity, instagram, twitter, facebook, snapchat, twitch, tiktok, discord, mail, poland, website, bio, book for social media, book, book of social media, wikipedia, socialshub, wroclaw, profile visits, search, social media search, social link search, social links, links hub, social network, network links, one url'>
    <meta name='author' content='Krystian Czajkowski'>
    <link rel="icon" href="logo/logo-little.png">
    <title>SocialsHub. One link to All your content | Sign Up</title>
    <link rel="shortcut icon" href="">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-148899862-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-148899862-1');
    </script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/signUp.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900&display=swap" rel="stylesheet">
</head>
<body>
    <script src="https://kit.fontawesome.com/d0961e5063.js" crossorigin="anonymous"></script>


    <?php include 'includes/nav.php' ?>


    <section class='row'>
        <div class="col-12 intro">
            <p class='h1 font-weight-900 lax' data-lax-preset='zoomOut-0.5 fadeOut'>All Your Content in One Link</p>
            <p class='lax' data-lax-preset='zoomOut-0.5 fadeOut'>Free instagram, twitter, twitch, tiktok tool for everyone.</p>
            <a href="signUp-box.php" class="btn btn-danger font-weight-bold px-5 py-2 mt-2 mx-auto lax" data-lax-preset='zoomOut-0.5 fadeOut' style='font-size: 1.2rem;'>
                GET STARTED FOR FREE 
            </a>

            <div class="arrow arrow-first d-none d-lg-block lax" data-lax-preset='zoomOut-0.5 fadeOut'></div>
            <div class="arrow arrow-second d-none d-lg-block lax"  data-lax-preset='zoomOut-0.5 fadeOut'></div>
        </div>
    </section>

    <section class="row">
        <div class="col-10 offset-1">
            <img src="signup-img/profile.png" alt="" class='img-fluid lax rounded border' data-lax-preset='zoomIn-0.8'>
        </div>
    </section>

    <section class="row lax" data-lax-preset='zoomIn-0.8'>
        <div class="col-12 col-lg-6" >
            <div class="col-10 offset-1 tiles-text">
                <p class="h3 font-weight-bold">
                    Link to Everywhere
                </p>
                <p>Link driving your audience to your shop, book, music or social network profiles. Now you have one link to share everything.</p>
        </div>
        </div>
        <div class="col-12 col-lg-6 container">
            <div class="col-10 offset-1">
                <img src="signup-img/mobileMarketing.jpg" alt="" class='img-fluid'>
            </div>
        </div>
    </section>


    <section class="row lax" data-lax-preset='zoomIn-0.8'>
        <div class="col-12 col-lg-6 container ">
            <div class="col-10 offset-1">
                <img src="signup-img/woman.jpg" alt="" class='img-fluid'>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="col-10 offset-1 tiles-text">
                <p class="h3 font-weight-bold">
                    Track Your Links's Clicks
                </p>
                <p>Track where your followers are clicking, post it more often and skyrocket 🚀</p>
            </div>
        </div>
    </section>


    
    <section class="row lax" data-lax-preset='zoomIn-0.8'>
        <div class="col-10 offset-1 text-center container-text">
            <p class="h3 font-weight-bold">
                Your Profile Looks Perfect on Every Device.
            </p>
            <p>Everyone will get to your content.</p>
        </div>
        <div class="col-10 offset-1">
            <img src="signup-img/laptop2.png" alt="" class='img-fluid'>
        </div>
    </section>



    <section class="trial-block shadow3 lax" id="ContactUs" data-lax-preset='zoomIn-0.8'>
        <div class="height250">
            <div class="social-overlap process-scetion mt100">
               <div class="container">
                   <div class="row justify-content-center">
                       <div class="col-md-10">
                           <div class="social-bar">
                               <div class="social-icons mb-3 iconpad text-center">
                                   
                                   <a href="signUp-box.php" class="slider-nav-item" ><i class="fab fa-youtube"></i></a>
                                   <a href="signUp-box.php" class="slider-nav-item"><i class="fab fa-instagram"></i></a>
                                   <a href="signUp-box.php" class="slider-nav-item"><i class="fab fa-twitter"></i></a>
                                   <a href="signUp-box.php" class="slider-nav-item"><i class="fab fa-twitch"></i></a>
                                   <a href="signUp-box.php" class="slider-nav-item"><i class="fab fa-snapchat"></i></a>
                                   <a href="signUp-box.php" class="slider-nav-item"><i class="fab fa-facebook"></i></a>
                                   <a href="signUp-box.php" class="slider-nav-item"><i class="fab fa-linkedin"></i></a>                                
                                   <a href="signUp-box.php" class="slider-nav-item"><i class="fab fa-soundcloud"></i></a>
                                   <a href="signUp-box.php" class="behance slider-nav-item"><i class="fab fa-spotify"></i></a>
                                   <a href="signUp-box.php" target="_blank" class="slider-nav-item"><i class="fab fa-pinterest"></i></a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
         </div>
        </div> 
    </section>


    <section class="row lax" data-lax-preset='zoomIn-0.8'>
        <div class="col-10 offset-1 text-center container-text ">
            <p class="h3 font-weight-bold">
                Increse Your Social Reach
            </p>
            <p>Increse your reach by getting on SocialsHub's interesting profiles page.</p>
        </div>
        <div class="col-10 offset-1">
            <img src="signup-img/laptop1.png" alt="" class='img-fluid'>
        </div>
    </section>

    
    <section class="row lax my-5" data-lax-preset='zoomIn-0.8'>
        <div class="col-10 offset-1 ">
            <a href="signUp-box.php" class="btn btn-block btn-danger font-weight-bold px-5 py-3 mx-auto" style='font-size: 1.2rem;'>
                GET STARTED FOR FREE 
            </a>
        </div>
    </section>



    <section class="row mb-5">
        <div class="row col-10 offset-1">
            <div class="col-3 col-lg-1 my-2"><a href="index.php" class="font-weight-bold text-muted link">Home</a></div>
            <div class="col-3 col-lg-1 my-2"><a href="privacy-policy.php" class="font-weight-bold text-muted link">Policy</a></div>
            <div class="col-3 col-lg-1 my-2"><a href="terms.php" class="font-weight-bold text-muted link">Terms</a></div>
            <div class="col-lg-3 my-2 offset-6">
                <div class="d-flex">
                    <span class="ml-auto font-weight-bold text-muted">© 2020 SocialsHub</span>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/lax.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  
    <script>
        window.onload = function() {
            lax.setup() // init

            const updateLax = () => {
                lax.update(window.scrollY)
                window.requestAnimationFrame(updateLax)
            }

            window.requestAnimationFrame(updateLax)
        }
    </script>

</body>
</html>