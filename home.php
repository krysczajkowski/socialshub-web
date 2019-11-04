<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'includes/head.php'; ?>
 
<body> 
    <?php include 'includes/nav.php'; ?>


    <div class="container mt-5">
        <h3 class='mb-3'><b>Most Popular This Week</b></h3>
        <div class="row"> 

     <?php
    
    // Dodaj tego javascripta ale przed praca na obrazkach sprawdź czy uploadProfile itp w ogole istnieje, jeżeli tak to zacznij prace, jak ją skończysz to obowiązkowo po próbuj hackować strone 

        $ranking = $functions->rankingGenerator();

        for($i=0; $i < count($ranking); $i++) {
            $rankingUserId   = $ranking[$i]->account_id;
            $rankingUserData = $functions->user_data($rankingUserId);    
            $rankingUserSM   = $functions->showSocialMedia($rankingUserId);
            
    ?>
    <a href="<?php echo BASE_URL . $rankingUserData->screenName ?>" target='_blank' class='link'>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="tile">
                <div class="wrapper">
                    <div class="header"><strong><?php echo $rankingUserData->screenName ?></strong></div>

                    <div class="banner-img">
                        <img src="<?php echo $rankingUserData->profileImage ?>" alt="Image 1" style='height: 200px;'>
                    </div>

                    <div class="dates">
                        <div class="">
                            <strong>New visitors last week</strong> <?php echo $ranking[$i]->weekVisits; ?> new visitors
                            <span></span>
                        </div>
                    </div>

                    <div>
                        <div class="stats">

                            <?php for($k=0; $k < 3; $k++) { ?>
                            <div class='d-flex'>
                                <a href="<?php 

                                if(!empty($rankingUserSM[$k]->smedia_link)) {
                                    echo $rankingUserSM[$k]->smedia_link;
                                } else { echo BASE_URL . $rankingUserData->screenName; }

                                 ?>" class='link w-100' style='word-wrap: break-word;' target="_blank">
                                    <strong class='mx-1'>
                                    <?php 
                                        if(!empty($rankingUserSM[$k]->smedia_name)) {
                                            echo $rankingUserSM[$k]->smedia_name; 
                                        } else {
                                            echo '---';
                                        }
                                    ?>
                                    </strong> <?php echo "<span class='socicon-".$rankingUserSM[$k]->smedia."' style='font-size: 1.9rem;'></span>"; ?>
                                </a>
                            </div>
                            <?php } ?>

                        </div>

                        <div class="stats">
                            <?php for($k=3; $k < 6; $k++) { ?>
                            <div class='d-flex'>
                                <a href="<?php 

                                if(!empty($rankingUserSM[$k]->smedia_link)) {
                                    echo $rankingUserSM[$k]->smedia_link;
                                } else { echo BASE_URL . $rankingUserData->screenName; }

                                 ?>" class='link w-100' style='word-wrap: break-word;' target="_blank">
                                    <strong class='mx-1'>
                                    <?php 
                                        if(!empty($rankingUserSM[$k]->smedia_name)) {
                                            echo $rankingUserSM[$k]->smedia_name; 
                                        } else {
                                            echo '---';
                                        }
                                    ?>
                                    </strong> <?php echo "<span class='socicon-".$rankingUserSM[$k]->smedia."' style='font-size: 1.9rem;'></span>"; ?>
                                </a>
                            </div>
                            <?php } ?>

                        </div>    
                    </div>

                </div>
            </div> 
        </div>

    </a>

    <?php } // END OF THE LOOP ?>

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
