<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
    
<?php include 'includes/head.php'; 

    
if(!$functions->loggedIn()) {
    header('Location: index.php');
    exit();
}

//Downloading user social medias
$sm = $functions->showSocialMedia($user->id);
?>
    
<body>
    <?php include 'includes/nav.php'; 
        //We check is user active and if he is not we change his location to welcome.php
        $functions->isUserActive($user->active);
    ?>

    <div class="bg-white my-5 border rounded container">
        <div class="row">
           
            <!-- LEFT SETTINGS PANEL -->
            <div class="d-none d-md-block col-md-4 col-lg-3">
                <div class="row">
                    <div class="col-12 my-3 pl-4">
                        <a href="settings.php" class='text-dark h5 none-decoration'>Edit Profile</a>
                    </div>
                    <div class="col-12 my-3 pl-4">
                        <a href="edit-password.php" class='text-dark h5 none-decoration'>Change Password</a>
                    </div>
                    <div class="col-12 my-3 pl-4 border-left border-dark">
                        <a href="privacy_and_security.php" class='text-dark h5 none-decoration'>Privacy and Security</a>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT SETTINGS PANEL -->
            <div class="col-md-8 col-lg-9 border-left">
                <div class="container my-4">
                    <div class="mt-3 mx-4">
                        <div class="font-weight-bold mt-4" style='font-size: 1.4rem;'>Account Data</div>
                        <div class='my-2'><span class='font-weight-bold'>Email:</span> <?php echo $user->email; ?></div>
                        <div class='my-2'><span class='font-weight-bold'>Username:</span> <?php echo $user->screenName; ?></div>
                        <div class='my-2'><span class='font-weight-bold'>Bio:<br></span> <?php echo $user->bio; ?></div>
                        <div class="my-2"><span class="font-weight-bold">Profile Visits: </span><?php echo $functions->showVisitors($user->id); ?></div>


                        <div class="font-weight-bold mt-4" style='font-size: 1.2rem;'>Social Media Names & Links</div>

                        <?php 
                        foreach ($sm as $socialMediaRow) {
                            if(!empty($socialMediaRow->smedia_name)) {
                                echo "<div class='mt-3 ml-2'><span class='font-weight-bold'>$socialMediaRow->smedia</span></div>";
                                echo "<div class='ml-4'><span class='font-weight-bold'>Username: </span>$socialMediaRow->smedia_name</div>";
                                echo "<div class='ml-4'><span class='font-weight-bold'>Link: </span>$socialMediaRow->smedia_link</div>";

                            }
                        } 
                        ?>   
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Including footer -->
    <?php include 'includes/footer.php'; ?>
   
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <?php include 'js/script.php' ?>
    <script src='js/search.js'></script>
</body>
</html>