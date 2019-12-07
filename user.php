<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
    
<?php include 'includes/head.php'; ?>

<body>
    <?php
    include 'includes/nav.php';

    
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
        <?php } ?>

        <!-- COVER IMAGE -->
        <div class='coverImage shadow'></div>
        <div class="row d-flex">
            <!-- PROFILE IMAGE -->
            <div class="col-lg-3 col-md-4 col-sm-5 col-6">
                <div class='profileImage border rounded-circle'></div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
            <div class="row">
                <!-- LEFT COLUMN -->
                <div class="col-xs-12 col-md-4">
                    <div class="card my-3 shadow-sm">

                        <div class="card-header bg-white border-0 mt-1"><span class='pl-1 font-open-sans lg-font'>Social Links</span>
                        </div>

                        <div class="card-body">
                            <?php 
                                $sm = $functions->showSocialMedia($profileId);
                                //Displaying social links :D

                                foreach ($sm as $socialMediaRow) {
                                    if(!empty($socialMediaRow->smedia_name)) {
                                        echo "<p class='p-0 ml-2'>";
                                        echo "<a class='link d-flex' "; 

                                        if(!empty($socialMediaRow->smedia_link)) {
                                            echo "href='$socialMediaRow->smedia_link'";
                                        } else {
                                            echo '';
                                        }

                                        echo " target='_blank'>";
                                        echo "<span class='socicon-$socialMediaRow->smedia' style='font-size: 1.9rem;'></span>";
                                        echo "<span class='mb-2 ml-3 w-75 user-social-name' style='font-size: 1.3rem; color: #404040;' > $socialMediaRow->smedia_name </span>";
                                        echo "</a>";
                                        echo "</p>";
                                    }
                                }



                                //If this is logged in user's socials, add Edit button
                                if($user->id === $profileId) {
                                   echo "<div class='container text-center text-muted' style='font-size: 1.1rem;'><br><a href='https://socialshub.net/settings.php' class='link'><i class='far fa-comment'></i> Edit Social Links</a></div>";
                                }

                            ?> 
                        </div>
                    </div>

                </div>


                <!-- RIGHT COLUMN -->
                <div class="col-xs-12 col-md-8">
                    <div class="card my-3 shadow-sm">
                        <div class="card-header bg-light"><h4 class='pl-3 font-open-sans' style='letter-spacing: 0.5px; font-size: 1.7rem; text-transform: capitalize;'><?php echo $profileData->screenName; ?></h4>

                            <?php //FOOTER OF CARD - View counter
                                if(isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])) {
                                    if($profileId === $_SESSION['user_id'] || $profileId === $_COOKIE['user_id']) { ?>
                                    <span class='text-muted ml-3'>
                                        <strong class='grey-font'>
                                            <?php echo $functions->showVisitors($profileId); ?>
                                        </strong> Profile Visits 
                                        <span class='mx-2'>|</span> 
                                        <strong class='grey-font'>
                                            <?php echo $functions->weekVisitors($profileId); ?>
                                        </strong> Visits This Week
                                    </span>

                                    <!-- <span class='ml-2 pl-2 text-muted border-left'><strong style='color: #555;'> -->
                            <?php //echo $functions->showViews($profileId) ; ?>
                                    <!-- </strong> Profile Views</span> -->
                        <?php } } ?>
                        </div>
                        <div class="card-body pb-1 mb-0">
                            <div class="container">
<pre style='font-size: 1.2rem;'>
<?php

    if(!empty($profileData->bio)) {
       echo $functions->text2link($profileData->bio);
    } else if (empty($profileData->bio) && $user->id === $profileData->id) {
       echo "<div class='container text-center text-muted' style='font-size: 1.1rem;'><a href='https://socialshub.net/settings.php' class='link'>Set your bio, name and pictures here</a></div>";
    }

    if ($user->id === $profileId) {
        echo "<div class='container text-center text-muted' style='font-size: 1.1rem;'><br><a href='https://socialshub.net/settings.php' class='link'><i class='far fa-edit'></i> Edit Your Bio</a></div>";
    }


?>
</pre>
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
    <?php } ?>
    
   
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='js/search.js'></script>
    <?php include 'js/script.php' ?>
</body>
</html>