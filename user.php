<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
    
<?php include 'includes/head-user.php'; ?>

<body>
    <?php

    // Including copy link popup
    if($functions->loggedIn()) {
        include 'includes/user-nav.php';
    }

    // Including copy link popup
    if($functions->loggedIn()) {
        include 'includes/user-link-popup.php';
    }

    
    if(isset($_GET['username']) && !empty($_GET['username'])){
        $username    = $functions->checkInput($_GET['username']);
        $profileId   = $functions->userIdByUsername($username);
        $profileData = $functions->user_data($profileId);

        if(!$profileData) {
            echo("<script>location.href = '".BASE_URL."page404.html'</script>");
            exit();
        } else {
            //Protection against extra profile views from bots
            echo "<img src='".$functions->addVisitor($profileId)."' class='d-none'>";
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
                <div class="container text-center">
                    <button type="button" class='close' data-dismiss='alert'>
                        <span>&times;</span>
                    </button>
                    <span class='text-white' style='font-size: 1.05rem; color: #c0c0c0;'>Hi <?php echo $user->screenName; ?>, <b>share your profile in <a href="https://www.instagram.com/accounts/edit/" target='_blank' class='text-white'><u>instagram bio here!</u></a></b></span>
                </div>
            </div>

        </div>
        <?php } ?>

        <div class="row d-flex mt-4">
            <!-- PROFILE IMAGE -->
            <div class="col-12 col-md-5">
                <div class='profileImage border rounded-circle shadow-sm'></div>
            </div>
            
            <!-- RIGHT COLUMN -->
            <div class="col-12 col-md-7">
                <div class="text-center text-md-left w-100">
                    <h4 class='font-weight-bold mt-3 mb-0 pb-0 user-screenName'>@<?php echo $profileData->screenName; ?></h4>

                    <div class="mb-3">
<p style="white-space: pre-line; font-size: 1rem; margin-top: -10px!important;" class='p-0 col-lg-9'>
<?php 
    //BIO DISPLAY
    if(!empty($profileData->bio)) {
       echo $functions->text2link($profileData->bio);
    } else {
        echo 'No bio yet.';
    }
?>
</p>                 
                    </div>                        
                               
<?php 
// View counter 
if ($user->id === $profileId) {
?>

    <span class='text-muted'>
        <strong class='grey-font'>
            <?php echo $functions->showVisitors($profileId); ?>
        </strong> Profile Visits 
        <span class='mx-2'>|</span> 
        <strong class='grey-font'>
            <?php echo $functions->weekVisitors($profileId); ?>
        </strong> Visits This Week
    </span>

<?php  } ?>
              
                
                
                </div>
            </div>
        </div>

  
    <div class="container">
        <div class="row">    
            <div class='col-12'>
                <div class="only-lg-devices-margin">
                    <div class="row">
                        <div class="col-12 col-md-10 offset-md-1 mt-2">
                            <div class="row">
                                <div class='col-12 col-md-10 offset-md-1 px-0'>
                                    <?php 
                                        $links = $functions->showActiveLinks($profileId);
                                        //Displaying links :D

                                        $theme = $functions->getLinkTheme($profileId);

                                        if(empty($theme)) {
                                            $theme = 'gradient-button-1';
                                        }

                                        foreach ($links as $link) {
                                            // Check if image is included to this link
                                            $linkImageRawPath = $functions->getLinkImage($link->id);

                                            if($link->isBouncing == 1) {
                                                $bouncingLink = 'pulse-link';
                                            } else {
                                                $bouncingLink = '';
                                            }

                                            if(!empty($linkImageRawPath)) {
                                                $linkImagePath = substr($linkImageRawPath, 3);

                                                // Display link with image
                                                if(!empty($link->title)) {
                                                    echo "
                                                    <a href='$link->link' class='btn-block custom-link-click small-font mt-2 gradient-button mx-0 row d-flex $theme $bouncingLink' target='_blank' data-customlink='$link->id'>
                                                        <div class='col-1 col-md-2 ml-2 ml-md-0' style='display: flex; align-items: center; justify-content: center;'><img src='$linkImagePath' class='rounded link-image'></div>
                                                        <div class='col-9 col-md-8 py-2' style='display: flex; align-items: center; justify-content: center;'>
                                                            <div class='d-flex flex-column link-title'>
                                                                $link->title
                                                                <span class='normal-font mb-0 pb-0' style='font-size: 0.75rem!important;font-weight: 400!important;'>$link->description</span>
                                                            </div>
                                                        </div>
                                                    </a>";
                                                }
                                            } else {
                                                // Display link without image
                                                if(!empty($link->title)) {
                                                    echo "<a href='$link->link' class='btn-block custom-link-click small-font mt-2 mx-0 gradient-button link-title $theme $bouncingLink' target='_blank' data-customlink='$link->id'>
                                                    $link->title
                                                    <p class='normal-font mb-0 pb-0 px-3' style='font-size: 0.75rem!important;font-weight: 400!important;'>$link->description</p>
                                                    </a>";
                                                }
                                            }
                                        }

                                        if($user->id === $profileId && empty($links)) {
                                            echo "<div class='text-center mt-4'>";
                                            echo "<a style='font-size: 1.1rem' class='btn-block custom-link-click small-font mt-2 gradient-button button-4' href='settings-links.php'>Hey @$user->screenName! Click here to add your own links</a>";
                                            echo "</div>";
                                        }

                                    ?> 
                                </div>
                            </div>
                        </div>
                        <div class="col-10 offset-1 mt-4">
                            <div class="row my-2 d-flex justify-content-center">
                                <?php 
                                    $sm = $functions->showSocialMedia($profileId);
                                    //Displaying social links :D

                                    foreach ($sm as $socialMediaRow) {

                                        if($socialMediaRow->isBouncing == 1) {
                                            $bouncingClass = 'pulse';
                                        } else {
                                            $bouncingClass = '';
                                        }

                                        if(!empty($socialMediaRow->smedia_name)) {
                                            echo "<a class='link d-flex social-link-click mt-1 mb-2 col-3 col-md-1 $bouncingClass' data-sociallink='$socialMediaRow->id'"; 

                                            if(!empty($socialMediaRow->smedia_link)) {
                                                echo "href='$socialMediaRow->smedia_link'";
                                            } else {
                                                echo '';
                                            }

                                            echo " target='_blank' type='button' name='$socialMediaRow->smedia'>";
                                            echo "<img src='socialmedia-icons/$socialMediaRow->smedia.svg' class='smedia-icon'>";
                                            echo "</a>";
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
<?php 
    if(!$functions->loggedIn()) {
        echo "<footer class='text-center font-weight-bold text-muted mt-5 pt-3'><a href='https://socialshub.net/signUp-box.php?ref=".$profileData->screenName."' class='text-muted' style='font-size: 0.9rem;'><img src='logo/logo-little.png' style='height: 15px; width: auto' class='mb-1 mr-1'> Made with SocialsHub.net</a></footer>";
    }

?>
    
    <!-- This website is using cookies information here -->
    <?php //include 'includes/cookie-info.php' ?>
    
   
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='js/search.js'></script>
    <script src='js/click.js'></script>
    <?php include 'js/script.php' ?>
    <script src='js/accept-cookies.js'></script>
    <script>
        // Change title 
        document.title = "@<?php echo $profileData->screenName . ' | SocialsHub.net'; ?>";

        // OG TAGS
        // Change title tag
        // document.querySelector('meta[property="og:title"]').setAttribute("content", "@<?php echo $profileData->screenName?> | SocialsHub.net");

        // Change image tag
        // document.querySelector('meta[property="og:image"]').setAttribute("content", "https://socialshub.net/<?php echo $profileData->profileImage?>");
    </script>
</body>
</html>