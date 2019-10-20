<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php';

if(!$functions->loggedIn()) {
    header('Location: index.php');
    exit();
}

?>

<body>
<?php include 'includes/nav.php';  ?>

<div class="container">
    <div class='jumbotron mt-5 w-75 mx-auto'>
        <div class='container'>
            <h3 class='font-weight-bold'>Please verify your email address.</h3>
            <hr>
            <p class='lead'>To continue using SocialsHub, you'll need to confirm your email address. Please check your email or spam folder for an activation link to activate your account. <br>Go to <a href="index.php" style='font-weight: 400;'>Home Page</a>. We send it to <b><?php echo $user->email; ?></b>
            </p> 
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</div>
   
    <?php
        //Setting cookie to not show cookie popup and we are refreshing page
        if(isset($_GET['accept-cookies'])){
            setcookie('accept-cookies', 'true', time() + 31556925);
            header('Location: '.BASE_URL.$profileData->screenName);
        }
    ?>


    <!-- This website is using cookies information here -->
    <?php if(!$functions->loggedIn() && !isset($_COOKIE['accept-cookies'])) {  ?>

    <div style='margin-top: 150px;'></div>
    <div class='alert alert-dark bg-light text-black alert-dismissable fixed-bottom m-0'>
        <div class="container">

            <div class="d-flex">
                <span style='font-size: 1.1rem;' class='pt-1'>SocialsHub.com uses cookies to give you the best possible experience.<a href="privacy-policy.php"> Read More</a></span>

                <!-- Accept cookie button -->
                <a href="?accept-cookies" class='btn btn-success font-weight-bold ml-auto' style='font-size: 1.1rem;'>OK</a>
            </div>

        </div>
    </div>
    <?php }
    ?>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='js/search.js'></script>
    <?php include 'js/script.php' ?>
</body>
</html>