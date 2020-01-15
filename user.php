<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
    
<?php include 'includes/head.php'; ?>

<body>
    <?php
    include 'includes/nav.php';

    // Sign Up or Log In popup for new users
    if(!$functions->loggedIn()) {
        include 'includes/signUp-popup.php';
    }

    
    if(isset($_GET['username']) && !empty($_GET['username'])){
        $username    = $functions->checkInput($_GET['username']);
        $profileId   = $functions->userIdByUsername($username);
        $profileData = $functions->user_data($profileId);

        if(!$profileData) {
            echo("<script>location.href = '".BASE_URL."'</script>");
            exit();
        } else {
//            $functions->addView($profileId);
            $functions->addVisitor($profileId);
        }

    } else {
        echo("<script>location.href = '".BASE_URL."'</script>");
        die();
    }
    

?>
   
    <div class="container">

        <!-- MESSAGE TO NEW USERS -->
        <?php if(isset($_COOKIE['new-user-tut2'])) { ?>
        <div class="container">
            <div class='alert bg-success text-white alert-dismissable mt-3 p-2'>
                <div class="container">
                    <button type="button" class='close' data-dismiss='alert'>
                        <span>&times;</span>
                    </button>
                    <span class='text-white' style='font-size: 1.05rem; color: #c0c0c0;'>Hi <?php echo $user->screenName?>, <b>it's time to get your Socialshub URL out there in the world!</b></span>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="row d-flex mt-4">
            <!-- PROFILE IMAGE -->
            <div class="col-md-4 col-sm-12">
                <div class='profileImage border rounded-circle shadow-sm'></div>
            </div>
            
            <!-- RIGHT COLUMN -->
            <div class="col-md-8 col-sm-12">
                <div class="pl-5">
                    <h4 class='my-3 font-open-sans' style='letter-spacing: 0.5px; font-size: 1.7rem; text-transform: capitalize;'><?php echo $profileData->screenName; ?></h4>

                    <div class="my-3">
<pre>
<?php 
    //BIO DISPLAY
    if(!empty($profileData->bio)) {
       echo $functions->text2link($profileData->bio);
    } else {
        echo 'No bio yet.';
    }
?>
</pre>                 
                    </div>                        
                               
                            <?php //FOOTER OF CARD - View counter ?>
                                    <span class='text-muted'>
                                        <strong class='grey-font'>
                                            <?php echo $functions->showVisitors($profileId); ?>
                                        </strong> Profile Visits 
                                        <span class='mx-2'>|</span> 
                                        <strong class='grey-font'>
                                            <?php echo $functions->weekVisitors($profileId); ?>
                                        </strong> Visits This Week
                                    </span>
                                                    
<pre style='font-size: 1.2rem;' class='mt-3'>
<?php

    if ($user->id === $profileId) {
        echo "<a href='https://socialshub.net/settings.php' class='btn btn-light font-weight-bold py-1 px-3'>Edit Profile</a>";
    }

?>
</pre>                
                
                
                </div>
            </div>
        </div>

  
    <div class="container mt-2">
        <div class="row">    

            <div class='col-12 UserSocialLinksBox'>
                <div class="my-3">
                    <div class="row">
                        <div class="col-md-4 pl-2 pl-5 order-md-1 order-2 mt-5">
                            <?php 
                                $sm = $functions->showSocialMedia($profileId);
                                //Displaying social links :D

                                foreach ($sm as $socialMediaRow) {
                                    if(!empty($socialMediaRow->smedia_name)) {
                                        echo "<div class='row my-2'>";
                                        echo "<a class='link d-flex border-0' "; 

                                        if(!empty($socialMediaRow->smedia_link)) {
                                            echo "href='$socialMediaRow->smedia_link'";
                                        } else {
                                            echo '';
                                        }

                                        echo " target='_blank' type='button' name='$socialMediaRow->smedia'>";
                                        echo "<span class='socicon-$socialMediaRow->smedia mr-4' style='font-size: 1.35rem;'></span>";
                                        echo "<p class='user-social-name' style='font-size: 1.15rem; color: #404040;' > $socialMediaRow->smedia_name </p>";
                                        echo "</a>";
                                        echo "</div>";
                                    }
                                }

                            ?> 
                        </div>
                        <div class="col-md-8 order-md-2 order-1 mt-4">
                            <div class="row">
                                <div class='col-md-10 offset-md-1'>
                                    <?php 
                                        $links = $functions->showLinks($profileId);
                                        //Displaying links :D

                                        foreach ($links as $link) {
                                            if(!empty($link->title)) {

                                                echo "<a href='$link->link' class='btn btn-light btn-block font-weight-bold px-2 py-3 small-font mt-2 rounded-0' style='border-bottom: 2px solid #303030;' target='_blank'>$link->title</a>";

                                            }
                                        }

                                    ?> 
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>   

        </div>
    </div>
</div>
    
    <?php include 'includes/footer.php'; ?>
    
    
    <?php 
        //Setting cookie to not show cookie popup and we are refreshing page
        if(isset($_GET['accept-cookies'])){
            setcookie('accept-cookies', 'true', time() + 31556925);
            echo("<script>location.href = '".BASE_URL.$profileData->screenName."'</script>");
        }
    ?>
    
    <!-- This website is using cookies information here -->
    <?php include 'includes/cookie-info.php' ?>
    
   
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='js/search.js'></script>
    <?php include 'js/script.php' ?>
</body>
</html>