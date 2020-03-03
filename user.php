<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
    
<?php include 'includes/head.php'; ?>

<body>
    <?php

    include 'includes/user-nav.php';

    // Including copy link popup
    if($functions->loggedIn()) {
        include 'includes/user-link-popup.php';
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
                    <h4 class='font-open-sans mt-3 mb-0 pb-0 user-screenName'>@<?php echo $profileData->screenName; ?></h4>

                    <div class="mb-3">
<p style="white-space: pre-line; font-size: 1rem;">
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
                                <div class='col-12 col-md-10 offset-md-1'>
                                    <?php 
                                        $links = $functions->showActiveLinks($profileId);
                                        //Displaying links :D

                                        foreach ($links as $link) {
                                            if(!empty($link->title)) {
                                                echo "<a href='$link->link' class='btn-block px-2 py-2 small-font mt-2 gradient-button gradient-button-1' target='_blank'>$link->title</a>";
                                            }
                                        }

                                        if($user->id === $profileId && empty($links)) {
                                            echo "<div class='text-center mt-4'>";
                                            echo "<a class='link font-weight-bold small-font' href='settings-links.php'>[Add Your Custom Links]</a>";
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
                                        if(!empty($socialMediaRow->smedia_name)) {
                                            echo "<a class='link d-flex mt-1 mb-2 col-3 col-md-1' "; 

                                            if(!empty($socialMediaRow->smedia_link)) {
                                                echo "href='$socialMediaRow->smedia_link'";
                                            } else {
                                                echo '';
                                            }

                                            echo " target='_blank' type='button' name='$socialMediaRow->smedia'>";
                                            echo "<span class='socicon-$socialMediaRow->smedia mx-auto smedia-icon'></span>";
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
    
    <?php include 'includes/footer.php'; ?>
    
    <!-- This website is using cookies information here -->
    <?php include 'includes/cookie-info.php' ?>
    
   
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='js/search.js'></script>
    <?php include 'js/script.php' ?>
    <script src='js/accept-cookies.js'></script>
</body>
</html>