<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
    
<?php include 'includes/head.php'; 

    
if(!$functions->loggedIn()) {
    header('Location: index.php');
}
    
//Setting empty error for incorrect password in delete account form
$eDeleteA = '';   
    
?>
    
<body>
    <?php include 'includes/nav.php'; 
        //We check is user active and if he is not we change his location to welcome.php
        $functions->isUserActive($user->active);
    
       
        // DELETE ACCOUNT CODE
        if(isset($_POST['delete-account'])) {
            // If user was registered with no facebook
            if(isset($_POST['password'])) {
                $password = $functions->checkInput($_POST['password']);
                $correctPassword  = $user->password;

                //Hashing pass from input

                $hash = md5($password);

                if($correctPassword === $hash) {

                    //Usun konto, napisz to w logowaniu ze konto zostalo ususniete, wyslij maila z tym ze konto zostalo usuniete
                    $functions->delete_account($user->id);

                    setcookie('account_deleted', '1', time()+60);

                } else {
                    $eDeleteA = 'Your password is incorrect.';
                }
            }
            
            //If user was registered by facebook
            if(isset($_POST['email-confirm'])) {
                
                $email = $_POST['email-confirm'];
                
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $eDeleteA = 'Invalid Email.';
                } else {
                    $correctEmail  = $user->email;

                    if($correctEmail === $email) {

                        //Deleting Account 
                        $functions->delete_account($user->id);

                        setcookie('account_deleted', '1', time()+60);

                    } else {
                        $eDeleteA = 'Your email is incorrect.';
                    } 
                }
                

            }
        }  
    
    ?>

    <div class="bg-white my-5 border rounded container">
        <div class="row settings-card">
           
            <!-- LEFT SETTINGS PANEL -->
            <div class="d-none d-md-block col-md-4 col-lg-3">
                <div class="row">
                    <div class="col-12 my-3 pl-4">
                        <a href="settings.php" class='text-dark h5 none-decoration'>Edit Profile</a>
                    </div>
                    <?php if(!$functions->isUserFbUser($user->id)) {?>
                    <div class="col-12 my-3 pl-4">
                        <a href="edit-password.php" class='text-dark h5 none-decoration'>Change Password</a>
                    </div>
                    <?php } ?>
                    <div class="col-12 my-3 pl-4 border-left border-dark">
                        <a href="privacy_and_security.php" class='text-dark h5 none-decoration'>Privacy and Security</a>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT SETTINGS PANEL -->
            <div class="col-md-8 col-lg-9 border-left">
                <div class="container my-4">
                    <div class="mt-3 mx-4 border-bottom border-secondary">
                        <div class="font-weight-normal mt-4" style='font-size: 1.8rem;'>Account Data</div>
                        <p class='my-3'><a href="account-data.php" class='font-weight-bold text-primary link'>View account data</a></p>
                    </div>
                    
                    <div class="mt-3 mx-4 border-bottom border-secondary">
                        <div class="font-weight-normal mt-4" style='font-size: 1.8rem;'>Delete Account</div>
                        
                        
                        <!-- COLLAPSED DELETE ACCOUNT FORM -->
                        <div class='mt-3' id='accordion'>
                            <p class='my-3'><a href="#delete-account-collapse" data-parent='#accordion' data-toggle='collapse' class='font-weight-bold text-primary link'>Delete Your Account and Information</a></p>

                            <!-- COLLAPSE -->
                            <div class='collapse' id='delete-account-collapse'>
                                <form method='post'>
                                    <div class="card card-body mb-4 border"> 
                                    <div class="card-title h4 mb-4">Permanently Delete Account</div>   
                                       
                                        <!-- INPUTS -->
                                        <?php if($functions->isUserFbUser($_SESSION['user_id'])) { ?>
                                            <input type="email" class='form-control' placeholder="Confirm Your Email" name='email-confirm'>
                                        <?php } else { ?>
                                            <input type="password" class='form-control' placeholder="Password" name='password'>
                                        <?php } ?>
                                        
                                        
                                        <div class="row">
                                           <div class="col-lg-4 col-xl-3">
                                                <input type="submit" name='delete-account' class='btn btn-danger mt-2' value='Delete Account' style='font-size: 1rem; width:100%;'>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php $functions->display_error_message($eDeleteA); $eDeleteA = '';?>
                        </div>
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