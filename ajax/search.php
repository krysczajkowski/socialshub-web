<?php

include '../functions/init.php';

// Sponsored Account
$sponsored_account = $functions->user_data(38);
$sponsored_account_sm = $functions->showNotEmptySocialMedia(38); 
?>
<div class='col-md-10 offset-md-1'>
    <div class='p-3 row mt-3 border-bottom search-result'>
        <div class='d-none d-md-block col-md-2 pt-3'>
            <h3 class='font-weight-bold ranking-number'>#S</h3>
        </div>

        <div class='col-2'>
            <img src="<?php echo $sponsored_account->profileImage; ?>" class='ranking-picture border rounded-circle shadow-sm' style='width: 5rem; height: 5rem;' >
        </div>

        <div class='col-10 col-md-8'>
            <div class='row'>
                <div class='col-12'>
                    <p class='font-weight-bold w-100 h3 ranking-name'>
                        <a href='<?php echo $sponsored_account->screenName ?>?ref=sponsored' style='word-break: break-all;' class='link text-dark'><?php echo $sponsored_account->screenName ?></a>
                    </p>
                </div>
                <div class='col-12 mb-2 mt-1'>
                    <p class='ranking-bio'>
                        <?php echo substr($sponsored_account->bio, 0, 45) . ' ... ' ?>
                    </p>
                </div>

                <div class="col-12 row">
                    <?php 
                         for($k=0; $k<3; $k++) {
                             if(isset($sponsored_account_sm[$k]->smedia_link)) {
                                 $smedia_link = $sponsored_account_sm[$k]->smedia_link;
                            
                        
                     ?>
                        <a href="<?php echo $sponsored_account_sm[$k]->smedia_link ?>" class='link d-flex social-link-click' data-sociallink='<?php echo $sponsored_account_sm[$k]->id ?>' target='_blank'>
                            <img src='../socialmedia-icons/<?php echo $sponsored_account_sm[$k]->smedia?>.svg' class='smedia-icon-index mr-3'>
                        </span>
                    </a> 
                    <?php } } ?>  
                </div>

            </div>
        </div>
    </div>
</div>


<?php

if(isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $functions->checkInput($_POST['search']);
    $result = $functions->search($search);


    if(!empty($result)) {

    $i=0;   
    //Robimy obiekt każdego wyszukanego usera w html
    foreach($result as $user){
    $userSM = $functions->showNotEmptySocialMedia($user->id); 
    $i++;
    ?>
        <div class='p-3 row col-md-10 offset-md-1 mt-3 border-bottom border-secondary search-result'>
            <div class='d-none d-md-block col-md-2 pt-3'>
                <h3 class='font-weight-bold ranking-number'>#<?php echo $i ?></h3>
            </div>

            <div class='col-2'>
                <img src="<?php echo $user->profileImage; ?>" class='ranking-picture border rounded-circle shadow-sm' style='width: 5rem; height: 5rem;' >
            </div>

            <div class='col-10 col-md-8'>
                <div class='row'>
                    <div class='col-12'>
                        <p class='font-weight-bold w-100 h3 ranking-name'>
                            <a href='<?php echo $user->screenName ?>?ref=ranking' style='word-break: break-all;' class='link text-dark'><?php echo $user->screenName ?></a>
                        </p>
                    </div>
                    <div class='col-12 mb-2 mt-1'>
                        <p class='ranking-bio'>
                            <?php echo substr($user->bio, 0, 45) . ' ... ' ?>
                        </p>
                    </div>

                    <div class="col-12 row">
                        <?php 
                             for($k=0; $k<3; $k++) {
                                 if(isset($userSM[$k]->smedia_link)) {
                                     $smedia_link = $userSM[$k]->smedia_link;
                                
                            
                         ?>
                            <a href="<?php echo $userSM[$k]->smedia_link ?>" class='link d-flex social-link-click' data-sociallink='<?php echo $userSM[$k]->id ?>' target='_blank'>
                                <img src='../socialmedia-icons/<?php echo $userSM[$k]->smedia?>.svg' class='smedia-icon-index mr-3'>
                            </span>
                        </a> 
                        <?php } } ?>  
                    </div>

                </div>
            </div>
        </div>

    <?php } 

    } else {

        echo "<div class='p-3 row col-md-8 offset-md-2 mt-3 lg-font'>No matches.</div>";
    }

} else { ?>

    <div class='col-md-10 offset-md-1'>
    <?php
    
    // Dodaj tego javascripta ale przed praca na obrazkach sprawdź czy uploadProfile itp w ogole istnieje, jeżeli tak to zacznij prace, jak ją skończysz to obowiązkowo po próbuj hackować strone 
        $ranking = $functions->rankingGenerator();
        
        for($i=0; $i < count($ranking); $i++) {
            $rankingUserId   = $ranking[$i]->account_id;
            $rankingUserData = $functions->user_data($rankingUserId);    
            $rankingUserSM   = $functions->showNotEmptySocialMedia($rankingUserId);   
            $rankingPosition = $i + 1;     
    ?>

        <div class="p-3 row mt-3 border-bottom search-result">
            <div class="d-none d-md-block col-md-2 pt-3">
                <h3 class='font-weight-bold ranking-number font-montserrat'><?php echo '#'.$rankingPosition; ?></h3>
            </div>

            <div class="col-2">
                <img src="<?php echo $rankingUserData->profileImage ?> " class='ranking-picture border rounded-circle shadow-sm' style='width: 5rem; height: 5rem;' >
            </div>

            <div class="col-10 col-md-8">
                <div class="row">
                    <div class="col-12">
                        <p class='font-weight-bold w-100 h3 ranking-name'>
                            <a href="<?php echo $rankingUserData->screenName; ?>?ref=ranking" style='word-break: break-all;' class='link text-dark'><?php echo $rankingUserData->screenName; ?></a>
                        </p>
                    </div>
                    <div class="col-12 mb-2 mt-1">
                        <p class='ranking-bio'>
                            <?php echo substr($rankingUserData->bio, 0, 45) . ' ... ' ?>
                        </p>
                    </div>
                    
                    <div class="col-12 row">
                        <?php 
                             for($k=0; $k<3; $k++) {
                                 if(isset($rankingUserSM[$k]->smedia_link)) {
                                     $smedia_link = $rankingUserSM[$k]->smedia_link;
                                
                            
                         ?>
                            <a href="<?php echo $rankingUserSM[$k]->smedia_link ?>" class='link d-flex social-link-click' data-sociallink='<?php echo $rankingUserSM[$k]->id ?>' target='_blank'>
                                <img src='../socialmedia-icons/<?php echo $rankingUserSM[$k]->smedia?>.svg' class='smedia-icon-index mr-3'>
                            </span>
                        </a> 
                        <?php } } ?>  
                    </div>

                </div>
            </div>
        </div>


    <?php } // END OF THE LOOP ?>

    </div>

<?php } ?>


