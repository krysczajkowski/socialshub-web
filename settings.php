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
        //We check is user active and if he is not we change his location to welcome.php
        $functions->isUserActive($user->active);
    
        
        //If everything went good we can redirect to user.php
        $changes_success = 1;


        // SETTINGS CODE    
    
        if(isset($_POST['email']) && isset($_POST['name']) && isset($_POST['textarea']) ) {
            if(isset($_FILES['uploadProfile']) && isset($_FILES['uploadCover'])) {

                $name   = $functions->checkInput($_POST['name']);
                $email  = $functions->checkInput($_POST['email']);
                $bio    = $functions->checkInput($_POST['textarea']);

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['eSettings'] = 'Invalid email.';
                } else if (strlen($name) < 2 || strlen($name) > 25) {
                    $_SESSION['eSettings'] = 'Name must be between 2 and 25 characters.';
                } else if ($name != $user->screenName && $functions->name_exist($name)) {
                    $_SESSION['eSettings'] = 'Sorry, this name is already taken.';
                } else if(!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
                    $_SESSION['eSettings'] = 'The name field must consist of numbers and letters.';
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
 
                    $socialmedia = ['youtube', 'instagram', 'tiktok', 'twitch', 'twitter', 'discord', 'snapchat','facebook', 'mail'];
 
                    for($i = 0; $i < count($socialmedia); $i++) {
                        $sm = $functions->showSocialMediaName($user->id, $socialmedia[$i]);
                        $name = $functions->checkInput($_POST[$sm[0]->smedia . '-name']);
                        //Dodaje social medie
                        //$functions->addSocialMedia($user->id, $socialmedia[$i]);
                        
                        
                        if((empty($name)) || (!empty($name) && strlen($name) < 30)) {

                            //Checking instagram link input
                            if (!empty($_POST[$sm[0]->smedia . '-link'])) {
                                $link = $functions->checkInput($_POST[$sm[0]->smedia .'-link']);
                                if($functions->isTextLink($link)) {

                                    $functions->updateSocialMedia($user->id, $sm[0]->smedia , $name, $link);

                                } else {
                                    $changes_success = 0;
                                    $_SESSION['eSettings'] = $link . ' is not link';
                                }
                            } else {
                                $functions->updateSocialMedia($user->id, $sm[0]->smedia, $name, '');
                            }
                        } else {
                            $changes_success = 0;
                            $_SESSION['eSettings'] = $sm[0]->smedia . ' name must be under 30 letters.';
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
        <div class="row settings-card">
           
            <!-- LEFT SETTINGS PANEL -->
            <div class="d-none d-md-block col-md-4 col-lg-3">
                <div class="row">
                    <div class="col-12 my-3 pl-4 border-left border-dark">
                        <a href="settings.php" class='text-dark h5 none-decoration'>Edit Profile</a>
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

                                <input type="file" id="uploadCover" name="uploadCover" style="visibility: hidden; width: 1px; height: 1px" multiple />
                                <a href=""  class="font-weight-bold none-decoration px-2 d-block "
                                onclick="document.getElementById('uploadCover').click(); return false">Change Cover Photo</a>  
                            </div>
                        </div>
                       
                        <!-- NAME INPUT -->
                        <div class="row pt-3">
                            <div class="col-xs-12 col-md-3 py-2 d-flex justify-content-end justify-text-md-start">
                                <strong>Name</strong>
                            </div>
                            <div class="col-xs-12 col-md-9 d-flex align-items-center">
                                <input type="text" class="form-control" value='<?php echo $user->screenName ?>' style='width: 65%;' name='name'>
                            </div>
                        </div>
                    
                        <!-- EMAIL INPUT -->
                        <div class="row pt-3">
                            <div class="col-xs-12 col-md-3 py-2 d-flex justify-content-end justify-text-md-start">
                                <strong>Email</strong>
                            </div>
                            <div class="col-xs-12 col-md-9 d-flex align-items-center">
                                <input type="email" class="form-control" style='width: 65%;' value='<?php echo $user->email ?>' name='email'>
                            </div>
                        </div>

                        <!-- BIO INPUT -->
                        <div class="row pt-3">
                            <div class="col-xs-12 col-md-3 py-2 d-flex justify-content-end justify-text-md-start">
                                <strong>Content</strong>
                            </div>
                            
                            <div class="col-xs-12 col-md-9 d-flex align-items-center">   
                                <textarea spellcheck="false" class='form-control' style="overflow:hidden; height: 200px; width: 78%;" name='textarea' placeholder="Describe yourself."><?php echo $user->bio ?></textarea>
                        
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

                                <!-- Instagram INPUTS -->
                                <?php 
                                    // Downloading name and url of social media 
                                    $sm = $functions->showSocialMediaName($user->id, 'instagram'); 
                                ?>

                                <div class='row'>

                                <?php 
           
                                    $socialmedia = ['youtube', 'instagram', 'tiktok', 'twitch', 'twitter', 'discord', 'snapchat','facebook', 'mail'];

                                    for($i = 0; $i < count($socialmedia); $i++) {
                                        $sm = $functions->showSocialMediaName($user->id, $socialmedia[$i]);
                                        //$functions->addSocialMedia($user->id, $socialmedia[$i]);
                                        $smName = $sm[0]->smedia_name;
                                        
                                        echo "
                                            <div class='col-10'>
                                            <div class='input-group settings-social-input'>
                                                <div class='input-group-prepend settings-social-name-div'>
                                                    <span id='' class='input-group-text settings-social-name' style=''>
                                                        <span class='settings-social-text'>".$socialmedia[$i]."</span>
                                                    </span>
                                                </div>
                                                <input type='text' placeholder='Name' class='form-control' name='".$sm[0]->smedia."-name' id='".$sm[0]->smedia."-name' value='$smName' >
                                                <input type='url' placeholder='Url Link (optional)' class='form-control' name='".$sm[0]->smedia."-link' id='".$sm[0]->smedia."-link' value=". $sm[0]->smedia_link .">
                                            </div>
                                            </div>";
                                    }

                                ?>

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
