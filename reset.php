<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php 
    include 'includes/head.php'; 
    
    $eReset = '';
    
    if(isset($_COOKIE['reset_password_cookie'])) {
        
        if(isset($_GET['email']) && isset($_GET['code'])) {
            
            if(isset($_POST['submit'])) {
                $newPassword    = $functions->checkInput($_POST['newPassword']);
                $confPassword   = $functions->checkInput($_POST['confirmPassword']);
                $email          = $functions->checkInput($_GET['email']);
                $validationCode = $functions->checkInput($_GET['code']);
                
                
                if(strlen($newPassword) < 5 || strlen($newPassword) > 20) {
                    $eReset = 'Password must be between 5 and 20 characters.';
                } else if($newPassword != $confPassword) {
                    $eReset = "You must enter the same password twice in order to confirm it.";
                } else {
                    $functions->reset_password($newPassword, $email, $validationCode);
                }
            
            } 
        } else {
            echo("<script>location.href = '".BASE_URL."'</script>");
        }
        
    } else {
        echo("<script>location.href = '".BASE_URL."recover.php'</script>");
    }
    ?>
    <body>
       
       <div class="container mt-5">
           <div class="row mt-5">
               <div class="col-sm-12 col-md-8 cl-lg-6 mx-auto">
                   <div class="card pt-3 pb-2">
                       <div class="card-body">
                           <div class="card-title text-center mb-3"><h2><strong style='letter-spacing: 1px;'>Reset Password</strong></h2></div>
                           <!-- FORM -->
                           <form method='post' autocomplete="off">
                               <input type="password" placeholder='New Password' class='form-control mt-2' name='newPassword'>                            
                               <input type="password" placeholder='Confirm Password' class='form-control mt-2' name='confirmPassword'>                            
                               <div class="form-group mt-3">
                                   <div class="row">
                                                                              
                                        <!-- SUBMIT -->
                                        <div class="col-12">
                                            <input type="submit" class="form-control btn btn-success" value="Reset Password" name='submit' />
                                        </div>
                                        
                                   </div>
                               </div>
                           </form>
                           <div class='d-block text-center'>
                           <?php $functions->display_error_message($eReset); 
                                if(isset($_SESSION['eReset'])) {
                                    $functions->display_error_message($_SESSION['eReset']);
                                }
                               ?>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
