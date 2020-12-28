<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php'; ?>
 
<body> 
    <script type='text/javascript' src='https://ko-fi.com/widgets/widget_2.js'></script>  
    <script>kofiwidget2.init('Support Me on Ko-fi', '#cd6769', 'W7W11MI6Y'); </script> 
    <?php include 'includes/nav.php'; 

    // Sign Up or Log In popup for new users
    if(!$functions->loggedIn()) {
        include 'includes/signUp-popup.php';
    }

    if($functions->loggedIn()) {
        $name = '@'.$user->screenName;
    } else {
        $name = 'you';
    }

    
    ?>

    <div class='w-100 text-center index-gradient p-5'>
        <h2 class='text-white text-shadow font-montserrat font-weigt-bold'>SOCIALSHUB'S TOP 10</h2>
        <p class='text-white font-montserrat'>Hey! Check out SocialsHub's most popular profiles!</p>
    </div>

     <div class="p-3 row col-12 col-md-10 offset-md-1 px-5 mt-3">
        <!-- <h3 class='ml-2 font-weight-bold'>The Most Interesting Profiles</h3> -->
        <input type="text" class='form-control form-control-lg search w-100' placeholder='Search users by name, email'>
     </div>

    <div class="container">
        <div class="row search-result">  

        <?php include 'ajax/search.php'; ?>
    
<!-- 
        <div class='d-none d-lg-block col-lg-3 offset-lg-1'>
            <div class="card p-0" style='border: 2px solid #cd6769; margin-top: -50px;'>
                <div class="card-body text-center">
                    <img src="socialshub-images/me.jpg" alt="" class=' rounded-circle img-fluid' style='width: 60px;'>
                    <br>
                    <p class='mt-3 mb-3'>

                        <p>Hey <?php #echo $name; ?>!</p>
                        <p>My name is Krystian Czajkowski, I’m 16 and I am the creator of SocialsHub.net. </p>

                        <p>I know people hate ads, so if you find the site helpful or useful then please consider throwing a coffee my way to help support my work 😊</p>
                    </p>
                    <script type='text/javascript'>kofiwidget2.draw();</script>

                </div>
            </div>
        </div>  -->


    </div>
    <!-- Including footer -->
    <?php include 'includes/footer.php'; ?>
    
    <!-- This website is using cookies information here -->
    <?php include 'includes/cookie-info.php' ?>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <?php include 'js/script.php' ?>
    <script src='js/search.js'></script>
    <script src='js/click.js'></script>
    <script src='js/accept-cookies.js'></script>
</body>
</html>
