<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php 
    include 'includes/head.php'; 
    
    $eRecoverEmail = '';
    $_SESSION['eRecoverEmail'] = '';
    
    if(isset($_POST['email'])) {
        $email = $functions->checkInput($_POST['email']);
        if(!empty($email)) {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                
                if($functions->email_exist($email)) {
                    
                    $_SESSION['rec_pass'] = 1;
                    $_SESSION['rec_email'] = $email;
                    echo("<script>location.href = '".BASE_URL."'</script>");  
                    
                } else {
                    $eRecoverEmail = "Sorry, this email doesn't exist.";
                }
                
            } else {
                $eRecoverEmail = "Invalid Email";
            }
            
        } else {
            $eRecoverEmail = "Email field is require.";
        }
    }
    
    if(isset($_POST['cancel'])) {
        echo("<script>location.href = '".BASE_URL."'</script>");
        exit();
    }
    
    ?>
    <body>
       
       <div class="container mt-5">
           <div class="row mt-5">
               <div class="col-sm-12 col-md-8 cl-lg-6 mx-auto">
                   <div class="card pt-3 pb-2">
                       <div class="card-body">
                           <div class="card-title text-center mb-3"><h2><strong style='letter-spacing: 1px;'>Recover Password</strong></h2></div>
                           <form method='post' autocomplete="off">
                               <input type="email" placeholder='Email Adress' class='form-control mt-2' name='email'>                            
                               <div class="form-group mt-3">
                                   <div class="row">
                                      
                                       <!-- CANCEL -->
                                       <div class="col-lg-6 col-sm-6 col-xs-6">
                                            <input type='submit' class="form-control btn btn-danger" name='cancel' value='Cancel'/>
                                        </div>
                                        
                                        <!-- SUBMIT -->
                                        <div class="col-lg-6 col-sm-6 col-xs-6">
                                            <input type="submit" class="form-control btn btn-success" value="Send Password Reset Link" name='submit' />
                                        </div>
                                        
                                   </div>
                               </div>
                           </form>
                           <div class='d-block text-center'>
                           <?php 
                                $functions->display_error_message($_SESSION['eRecoverEmail']);
                                $_SESSION['eRecoverEmail'] = '';
                                $functions->display_error_message($eRecoverEmail);
                                $eRecoverEmail = '';
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
