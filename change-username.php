<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
include 'includes/head.php'; 
error_reporting(E_ALL);

if(!$functions->loggedIn()) {
    header('Location: index.php');
}

$eUsername = '';
$_SESSION['eUsername'] = '';
?>
<body ondragstart="return false" ondrag="return false">
  <?php include 'includes/nav.php'; 

  // Creating token
  if (empty($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(random_bytes(32));
  }


  if(isset($_POST['username'])) {
      //echo $_POST['token'] .'<br>';
      //echo $_SESSION['token'];

      // Checking if tokens match
      if(hash_equals($_POST['token'], $_SESSION['token'])) {

          $username = $_POST['username'];
          $username = preg_replace("/[^a-zA-Z0-9]/", "", $username);

          if(!empty($username)) {
              if(strlen($username) < 2 || strlen($username) > 25) {
                  $_SESSION['eUsername'] = 'Name must be between 2 and 25 characters.';
              } else if ($username != $user->screenName && $functions->name_exist($username)) {
                  $_SESSION['eUsername'] = 'Sorry, this name is already taken.';
              } else {
                  //Updating user's data
                  $functions->update('users', $user->id, array('screenName' => $username));
                  echo("<script>location.replace('smedia-tutorial.php')</script>");

              }
          } else {
              $_SESSION['eUsername'] = 'Please type in your username.';
          }
      } else {
        $_SESSION['eUsername'] = 'Sorry, server problem.';
      }
  }



  ?>
   
   <div class="container mt-5">
       <div class="row mt-5">
           <div class="col-sm-12 col-md-8 cl-lg-6 mx-auto">
               <div class="card pt-3 pb-2" style="border-bottom: 2px solid #cd6769;">
                   <div class="card-body">
                       <div class="card-title text-center mb-3"><h3><strong style='letter-spacing: 1px;'>Enter Username</strong></h3></div>
                       <form method='post' autocomplete="off">
                           <input type="hidden" value="<?php echo $_SESSION['token']; ?>" name='token'>
                           <input type="text" placeholder='Username' class='form-control mt-2' name='username'>                            
                           <div class="form-group mt-3">
                               <div class="row">
                                  
                                    
                                    <!-- SUBMIT -->
                                    <div class="col-12">
                                        <input type="submit" class="form-control font-weight-bold btn text-white" value="Save Username" name='submit' style="background-color:#cd6769;border: 1px solid #ac393b;"/>
                                    </div>
                                    
                               </div>
                           </div>
                       </form>
                       <div class='d-block text-center'>
                       <?php 
                            $functions->display_error_message($_SESSION['eUsername']);
                            $_SESSION['eUsername'] = '';
                            $functions->display_error_message($eUsername);
                            $eUsername = '';
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
