<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    
    <?php include 'includes/head.php'; 
    
    if(!$functions->loggedIn()) {
        header('Location: index.php');
        exit();
    }
    ?>
<body>

<div class="container">
    <div class='jumbotron mt-5 w-75 mx-auto'>
        <div class='container'>
            <h1>Welcome to SocialsHub</h1>
            <hr>
            <p class='lead medium-font'><strong>You just need to confirm your email</strong>. Please check your email or spam forlder for an <strong>activation link</strong>. Go to <a href="index.php" style='font-weight: 400;'>Home Page</a>.
            </p> 
        </div>
    </div>
</div>
   
   
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
