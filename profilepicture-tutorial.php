<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php'; 

if(!$functions->loggedIn()) {
    header('Location: index.php');
}

// Creating token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
    
?>
 
<body ondragstart="return false" ondrag="return false">
    <?php include 'includes/nav.php';
        //If everything went good we can redirect to user.php
        $changes_success = 1;



        if(isset($_POST['submit'])) {

            // Checking if tokens match
            if(hash_equals($_POST['token'], $_SESSION['token'])) {

                $bio = $functions->checkInput($_POST['bio']);

                //Old names of images
                $DBprofImage = $user->profileImage;
                
                //Checking profile image
                if(!empty($_FILES['uploadProfile']['name'][0])) {
                    $profileRoot = $functions->uploadImage($_FILES['uploadProfile'], $user->id, 'images/');
                    if(!empty($profileRoot)) {
                        $DBprofImage = $profileRoot;
                    }
                }
                
                //Updating user's data
                $functions->update('users', $user->id, array('bio' => $bio, 'profileImage' => $DBprofImage));                   
                
                if($changes_success) {
                    echo("<script>location.replace('".$user->screenName."')</script>");
                }
            } else {
                echo "<p class='text-danger'>Sorry. Server problem. Please try again later.</p>";
            }
        }
        
    ?>

     
    <div class="container">
        <div class="row">
            <div class="col-10 col-md-6 col-lg-4 offset-1 offset-md-3 offset-lg-4 border mt-5 p-4">
                <form action="" method='POST' enctype='multipart/form-data'>
                    <input type="hidden" value="<?php echo $_SESSION['token']; ?>" name='token'>
                    <h5 class='text-center font-weight-bold'>@<?php echo $user->screenName; ?></h5>

                    <div class="form-group text-center">
                        <img src="images/defaultProfileImage.png" id='profileDisplay' class='rounded-circle d-block mx-auto my-3' style='width: 40%!important; height: 40%!important;' alt="" onclick='uploadProfileClick()'>
                        <label for="uploadProfile" class='text-muted'>[Click to upload profile image]</label>
                        <input type="file" onchange='displayImage(this)' name='uploadProfile' id='uploadProfile' class='form-control' style='display:none;'>
                    </div>

                    <div class="form-group">
                        <label for="bio" class='font-weight-bold'>Bio</label>
                        <textarea name="bio" id="bio" class='form-control' placeholder='Message to all your followers'></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" name='submit' class='btn text-white btn-block' style="background-color:#cd6769;border: 1px solid #ac393b;">Finish! Go to profile</button>
                    </div>
                </form>
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
    <script>
        //Make it look active in nav
        $('#nav-settings').css({"border-bottom": "2px solid #fff"});
        $('#nav-settings').css({"font-weight": "700"});

        function uploadProfileClick () {
            document.querySelector('#uploadProfile').click();
        }

        function displayImage(e) {
            if(e.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
                }

                reader.readAsDataURL(e.files[0]);
            }
        }
    </script>
</body>
</html>
