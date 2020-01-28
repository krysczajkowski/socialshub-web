<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php'; 

if(!$functions->loggedIn()) {
    header('Location: index.php');
}
    
?>
 
<body>
   
    <?php include 'includes/nav.php';
    
        //Downloading all data about user's social medias
        $sm = $functions->showSocialMedia($user->id);
        
        //If everything went good we can redirect to user.php
        $changes_success = 1;


        //Links
        $links = [
            'youtube' => 'https://youtube.com/',
            'facebook' => 'https://facebook.com/',
            'twitter' => 'https://twitter.com/', 
            'instagram' => 'https://instagram.com/',
            'tiktok' => 'https://tiktok.com/@',
            'snapchat' => 'https://snapchat.com/add/',
            'twitch' => 'https://twitch.tv/',
            'soundcloud' => 'https://soundcloud.com/',
            'linkedin' => 'https://linkedin.com/in/',
            'spotify' => 'https://open.spotify.com/artist/',
            'github' => 'https://github.com/',
            'pinterest' => 'https://pinterest.com/'

        ];


        // SETTINGS CODE    
    
        if(isset($_POST['email']) && isset($_POST['name']) && isset($_POST['textarea']) ) {
            if(isset($_FILES['uploadProfile'])) {

                $name   = $_POST['name'];
                $email  = $functions->checkInput($_POST['email']);
                $bio    = $functions->checkInput($_POST['textarea']);

                $name = preg_replace("/[^a-zA-Z0-9]/", "", $name);

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['eSettings'] = 'Invalid email.';
                } else if (strlen($name) < 2 || strlen($name) > 25) {
                    $_SESSION['eSettings'] = 'Name must be between 2 and 25 characters.';
                } else if ($name != $user->screenName && $functions->name_exist($name)) {
                    $_SESSION['eSettings'] = 'Sorry, this name is already taken.';
                } else if ($email != $user->email && $functions->email_exist($email)) {
                    $_SESSION['eSettings'] = 'This email is already in use.';
                } else {
                    //Old names of images
                    $DBprofImage  = $user->profileImage;
                    $DBcoverImage = $user->profileCover;
                    
                    //Checking profile image
                    if(!empty($_FILES['uploadProfile']['name'][0])) {
                        $profileRoot = $functions->uploadImage($_FILES['uploadProfile'], $user->id);
                        if(!empty($profileRoot)) {
                            $DBprofImage = $profileRoot;
                        }
                    }
                    
                    //Checking cover image
                    if(!empty($_FILES['uploadCover']['name'][0])) {
                        $profileRoot = $functions->uploadImage($_FILES['uploadCover'], $user->id);
                        if(!empty($profileRoot)) {
                            $DBcoverImage = $profileRoot;
                        }
                    }   
                    
                    //Updating user's data
                    $functions->update('users', $user->id, array('email' => $email, 'screenName' => $name, 'bio' => $bio, 'profileImage' => $DBprofImage, 'profileCover' => $DBcoverImage));                   


                    // FILTERING SOCIAL MEDIA
                    foreach ($sm as $socialMediaRow) {

                        $smedia = $socialMediaRow->smedia;                    
                                        
                        
                        $smedia_name = $functions->checkInput($_POST[$smedia . '-name']);
                        
                        //Session to hold in input wrong (over 30 chars) social name
                        $_SESSION[$smedia . '-inputName'] = $smedia_name;
                        
                        if((empty($smedia_name)) || (!empty($smedia_name) && strlen($smedia_name) < 30)) { 
                            

                            $smedia_link = $links[$smedia] . $smedia_name;

                            // Setting #2 tutorial for new user
                            if(isset($_SESSION['set-tut2'])) {
                                setcookie('new-user-tut2', '1', time()+20);
                                unset($_SESSION['set-tut2']);
                            }


                            $functions->updateSocialLinks($user->id, $smedia , $smedia_name, $smedia_link);
                            $functions->addNewSocialMedia($user->id);
                                                
                                      
                        } else {
                            $changes_success = 0;
                            $_SESSION['eSettings'] = $smedia . ' name must be under 30 letters.';
                        } 
                                                
                    }
 
                    if($changes_success) {
                        echo("<script>location.href = '".BASE_URL."$user->screenName'</script>");
                    }
                }
                
            }
        
        }

    // Dodaj tego javascripta ale przed praca na obrazkach sprawdź czy uploadProfile itp w ogole istnieje, jeżeli tak to zacznij prace, jak ją skończysz to obowiązkowo po próbuj hackować strone 
    
    ?>

    <div class="bg-white my-5 border rounded container"> 
        <!-- MESSAGE IF USER IS NOT ACTIVE -->
        <?php if(!$functions->isUserActive($user->active)) { ?>
            <div class='alert bg-warning text-white alert-dismissable mt-2 p-2'>
                <div class="container">
                    <button type="button" class='close' data-dismiss='alert'>
                        <span>&times;</span>
                    </button>
                    <span class='text-white' style='font-size: 1.1rem; color: #c0c0c0;'><b>Please activate your email - <?php echo $user->email; ?></b></span>
                </div>
            </div>
        <?php }  ?>

        <!-- MESSAGE TO NEW USERS -->
        <?php if(isset($_COOKIE['new-user-tut1'])) { 
            
            $_SESSION['set-tut2'] = 1;  

            ?>
            <div class='alert bg-success text-white alert-dismissable mt-2 p-2'>
                <div class="container">
                    <button type="button" class='close' data-dismiss='alert'>
                        <span>&times;</span>
                    </button>
                    <span class='text-white' style='font-size: 1.1rem; color: #c0c0c0;'>Hi <b><?php echo $user->screenName?></b>, it’s great to have you! <b>You are one step away from creating your most useful url🥰</b></span>
                </div>
            </div>
        <?php }  ?>

        <div class="row settings-card">
           
            <!-- LEFT SETTINGS PANEL -->
            <div class="d-none d-md-block col-md-4 col-lg-3">
                <div class="row">
                    <div class="col-12 my-3 pl-4 border-left border-dark">
                        <a href="settings.php" class='text-dark h5 none-decoration'>Edit Profile</a>
                    </div>
                    <div class="col-12 my-3 pl-4">
                        <a href="settings-links.php" class='text-dark h5 none-decoration'>My Links</a>
                    </div>
                    <?php if(!$functions->isUserFbUser($user->id)) {?>
                    <div class="col-12 my-3 pl-4">
                        <a href="edit-password.php" class='text-dark h5 none-decoration'>Change Password</a>
                    </div>
                    <?php } ?>
                    <div class="col-12 my-3 pl-4">
                        <a href="privacy_and_security.php" class='text-dark h5 none-decoration'>Privacy and Security</a>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT SETTINGS PANEL -->
            <div class="col-md-8 col-lg-9 border-left">

                <div class="m-4">
                   
                    <!-- Go to custom links message for mobile users -->
                    <div class="row d-block d-md-none d-lg-none d-lg-none border-bottom border-secondary text-center p-2 mb-4">
                        <a href="settings-links.php" class='link'><i class="fas fa-feather-alt"></i> Edit Your Custom Links</a>
                    </div>

                    <!-- FORM -->
                    <form action="" method='POST' enctype="multipart/form-data">
                   
                        <div class="row">
                            <div class="d-flex col-3 py-2 justify-content-end justify-text-md-start">
                                <div class="profileImage-sm border rounded-circle" style='height: 45px; width: 45px;'></div>
                            </div>
                            <div class="col-9 d-flex align-items-center">
                                <strong style='font-size: 1.3rem; font-weight: 400;'><?php echo $user->screenName ?></strong>                  

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-md-3 d-flex justify-content-end justify-text-md-start">
                                
                            </div>
                            <!-- IMAGES IN FORM -->
                            <div class="col-xs-12 col-md-9 d-flex align-items-center">
                                <input type="file" id="uploadProfile" name="uploadProfile" style="visibility: hidden; width: 1px; height: 1px" multiple />
                                <a href=""  class="font-weight-bold none-decoration pl-3"
                                onclick="document.getElementById('uploadProfile').click(); return false">Change Profile Photo</a>

                            </div>
                        </div>
                       
                        <!-- NAME INPUT -->
                        <div class="row pt-3">
                            <div class="col-12 col-md-3 py-2 d-flex justify-content-end justify-text-md-start">
                                <strong>Name</strong>
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center">
                                <input type="text" class="form-control" value='<?php echo $user->screenName ?>' name='name'>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-12 col-md-3 d-flex justify-content-end justify-text-md-start"></div>
                            <div class="col-xs-12 col-md-9 d-flex align-items-center">
                                <p class='text-secondary font-weight-bold align-self-end' style='font-size: 0.8rem;'>Only letters and numbers allowed! </p>
                            </div>
                        </div>

                        <!-- EMAIL INPUT -->
                        <div class="row pt-1">
                            <div class="col-12 col-md-3 py-2 d-flex justify-content-end justify-text-md-start">
                                <strong>Email</strong>
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center">
                                <input type="email" class="form-control" value='<?php echo $user->email ?>' name='email'>
                            </div>
                        </div>

                        <!-- BIO INPUT -->
                        <div class="row pt-3">
                            <div class="col-12 col-md-3 py-2 d-flex justify-content-end justify-text-md-start">
                                <strong>Content</strong>
                            </div>
                            
                            <div class="col-12 col-md-6 d-flex align-items-center">   
                                <textarea spellcheck="false" class='form-control' style="overflow:hidden; height: 200px;" name='textarea' placeholder="Describe yourself."><?php echo $user->bio ?></textarea>
                        
                            </div>
                                                        
                        </div>
                        

                        <!-- Social Links Title -->
                        <div class="row pt-4">
                            <div class="col-xs-12 pr-0 mr-0 col-md-3 py-2 d-flex justify-content-end justify-text-md-start">
                                <strong class='medium-font '>Social Links</strong>
                            </div>
                            <div class="col-xs-12 col-md-9 d-flex align-items-center"></div>  
                        </div>

                        <!-- ADD SOCIAL LINKS -->
                        <div class="row pt-1">
                            <div class="col-xs-12 col-md-11 offset-md-1 d-flex align-items-center">
                                <div class='row'>
                                    <?php    
                                    foreach ($sm as $socialMediaRow) {
                                            

                                        $name = (isset($_SESSION[$socialMediaRow->smedia . '-inputName']) ? $_SESSION[$socialMediaRow->smedia . '-inputName'] : $socialMediaRow->smedia_name);

                                        $smedia = $socialMediaRow->smedia;

                                        echo "
<div class='col-12 col-md-10'>
<div class='row mb-2'>
    <div class='col-12 col-lg-5'>
        <span id='' class='input-group-text settings-social-name px-auto' style=''>
            <span class='medium-font settings-social-text p-0 socicon-$socialMediaRow->smedia'></span>
            $links[$smedia]
        </span>
    </div>
    <div class='col-12 col-lg-7'>
        <input type='text' placeholder='Your ".$socialMediaRow->smedia." name' class='form-control' name='".$socialMediaRow->smedia."-name' id='".$socialMediaRow->smedia."-name' value='$name' >
    </div>
</div>
</div>";

                                        unset($_SESSION[$socialMediaRow->smedia . '-inputName']);
                                    } ?>
                                </div>
                            </div>
                        </div>



                        <!-- SUBMIT -->
                        <div class="row pt-3">
                            <div class="col-xs-12 col-md-3 py-2 d-flex justify-content-end">
                            </div>
                            <div class="col-xs-12 col-md-9 d-flex">
                                <input type="submit" name='submit' value='Save Settings' class="btn btn-primary font-weight-bold py-1" >  
                            </div>
                            
                            <?php   
    
                            if(!empty($_SESSION['eSettings'])) {
                                $functions->display_error_message($_SESSION['eSettings']);
                                $_SESSION['eSettings'] = ''; 
                            }
                            ?>                         
                        </div>

                    </form>
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
