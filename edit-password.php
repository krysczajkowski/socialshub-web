<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
    
<?php include 'includes/head.php'; 

    
if(!$functions->loggedIn()) {
    header('Location: index.php');
    exit();
}
    
// CHANGE PASSWORD CODE
$eChangePassword = '';
$sChangePassword = '';
    
if(isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confPassword'])) {
    $oldPassword   = $functions->checkInput($_POST['oldPassword']);
    $newPassword   = $functions->checkInput($_POST['newPassword']);
    $confPassword  = $functions->checkInput($_POST['confPassword']);

    $user_id = $_SESSION['user_id'];

    //checkPassword() check is this correct password
    if($functions->checkPassword($oldPassword, $user_id)) {
        if(strlen($newPassword) < 5 || strlen($newPassword) > 25) {
            $eChangePassword = 'New password must be between 5 and 25 characters';
        } else if($newPassword != $confPassword) {
            $eChangePassword = 'You must enter the same password twice in order to confirm it.';
        } else {
            $hash = md5($newPassword);
            $functions->update('users', $user_id, array('password' => "$hash"));
            $sChangePassword = 'Your password has been updated.';
        }
    } else {
        $eChangePassword = 'Your current password is incorrect.';
    }
}    
    
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
                    <div class="col-12 my-3 pl-4 border-left border-dark">
                        <a href="edit-password.php" class='text-dark h5 none-decoration'>Change Password</a>
                    </div>
                    <div class="col-12 my-3 pl-4">
                        <a href="privacy_and_security.php" class='text-dark h5 none-decoration'>Privacy and Security</a>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT SETTINGS PANEL -->
            <div class="col-md-8 col-lg-9 border-left">
                <div class="m-4">
                    <div class="row">
                        <div class="col-3 py-2 d-flex justify-content-end justify-text-md-start">
                            <div class="profileImage-sm border rounded-circle" style='height: 45px; width: 45px;'></div>
                        </div>
                        <div class="col-9 d-flex align-items-center">
                            <strong class='h5'><?php echo $user->screenName ?></strong>
                        </div>
                    </div>
                    
                    <!-- FORM -->
                    <form action="" method='POST'>
                       
                        <!-- CURRENT PASSWORD -->
                        <div class="row pt-3">
                            <div class="col-xs-12 col-md-3 py-2 d-flex justify-content-end justify-text-md-start">
                                <strong>Current Password</strong>
                            </div>
                            <div class="col-xs-12 col-md-9 d-flex align-items-center">
                                <input type="password" value='<?php if(isset($oldPassword)) {echo $oldPassword;} ?>' class="form-control" style='width: 65%;' name='oldPassword'>
                            </div>
                        </div>
        
                        <!-- NEW PASSWORD -->
                        <div class="row pt-3">
                            <div class="col-xs-12 col-md-3 py-2 d-flex justify-content-end justify-text-md-start">
                                <strong>New Password</strong>
                            </div>
                            <div class="col-xs-12 col-md-9 d-flex align-items-center">
                                <input type="password" value='<?php if(isset($newPassword)) {echo $newPassword;} ?>' class="form-control" style='width: 65%;' name='newPassword'>
                            </div>
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div class="row pt-3">
                            <div class="col-xs-12 col-md-3 py-2 d-flex justify-content-end justify-text-md-start">
                                <strong>Confirm New <br> Password</strong>
                            </div>
                            <div class="col-xs-12 col-md-9 d-flex align-items-center">
                                <input type="password" class="form-control" style='width: 65%;' name='confPassword'>
                            </div>
                        </div>

                        <!-- SUBMIT -->
                        <div class="row pt-3">
                            <div class="col-xs-12 col-md-3 py-2 d-flex justify-content-end">
                            </div>
                            <div class="col-xs-12 col-md-9 d-flex align-items-center">
                                <input type="submit" name='submit' id='submit' value='Submit' class="btn btn-primary font-weight-bold py-1">
                            </div>
                        <?php $functions->display_error_message($eChangePassword); $eChangePassword = '';
                        $functions->display_success_message($sChangePassword);
                        $sChangePassword = '';
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