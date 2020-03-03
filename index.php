<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php'; ?>
 
<body> 
    <?php include 'includes/nav.php'; 

    // Sign Up or Log In popup for new users
    if(!$functions->loggedIn()) {
        include 'includes/signUp-popup.php';
    }
    
    ?>


     <div class="p-3 row col-md-8 offset-md-2 mt-3">
         <h3 class='ml-2 font-weight-bold'>The Most Interesting Profiles</h3>
     </div>

    <div class="container">
        <div class="row">

     <?php
        $ranking = $functions->rankingGenerator();
        
        for($i=0; $i < count($ranking); $i++) {
            $rankingUserId   = $ranking[$i]->account_id;
            $rankingUserData = $functions->user_data($rankingUserId);    
            $rankingUserSM   = $functions->showNotEmptySocialMedia($rankingUserId);   
            $rankingPosition = $i + 1;    
    ?>
        <div class="p-3 row col-md-8 offset-md-2 mt-3 border-bottom border-secondary">
            <div class="col-2 pt-3">
                <h3 class='font-weight-bold ranking-number'><?php echo '#'.$rankingPosition; ?></h3>
            </div>

            <div class="col-2">
                <img src="<?php echo $rankingUserData->profileImage ?> " class='ranking-picture border rounded-circle shadow-sm' style='width: 5rem; height: 5rem;' >
            </div>

            <div class="col-8">
                <div class="row">
                    <div class="col-12">
                        <p class='font-weight-bold w-75 h3 ranking-name'>
                            <a href="<?php echo $rankingUserData->screenName; ?>" class='link text-dark'><?php echo $rankingUserData->screenName; ?></a>
                        </p>
                    </div>
                    <div class="col-12 mb-2 mt-1">
                        <p class='ranking-bio'>
                            <?php echo substr($rankingUserData->bio, 0, 45) . ' ... ' ?>
                        </p>
                    </div>
                    
                    <div class="row">
                        <?php 
                             for($k=0; $k<3; $k++) {
                                 if(isset($rankingUserSM[$k]->smedia_link)) {
                                     $smedia_link = $rankingUserSM[$k]->smedia_link;
                                
                            
                         ?>
                            <a href="<?php echo $rankingUserSM[$k]->smedia_link ?>" class='link col d-flex' target='_blank'><span class='socicon-<?php echo $rankingUserSM[$k]->smedia ?> smedia-icon' style='font-size: 1.9rem;'>
                            </span></a> 
                        <?php } } ?>  
                    </div>

                </div>
            </div>
        </div>

    <?php } // END OF THE LOOP ?>

            </div>
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
    <script src='js/accept-cookies.js'></script>
</body>
</html>
