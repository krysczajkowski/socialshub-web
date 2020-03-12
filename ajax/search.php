<?php
error_reporting(E_ALL & ~E_WARNING);

include '../functions/init.php';

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
        <div class='p-3 row col-md-8 offset-md-2 mt-3 border-bottom border-secondary search-result'>
            <div class='col-2 pt-3'>
                <h3 class='font-weight-bold ranking-number'>#<?php echo $i ?></h3>
            </div>

            <div class='col-2'>
                <img src="<?php echo $user->profileImage; ?>" class='ranking-picture border rounded-circle shadow-sm' style='width: 5rem; height: 5rem;' >
            </div>

            <div class='col-8'>
                <div class='row'>
                    <div class='col-12'>
                        <p class='font-weight-bold w-75 h3 ranking-name'>
                            <a href='<?php echo $user->screenName ?>' class='link text-dark'><?php echo $user->screenName ?></a>
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
                                <span class='socicon-<?php echo $userSM[$k]->smedia ?> mx-3 smedia-icon ranking-social' style='font-size: 1.9rem;'>
                            </span>
                        </a> 
                        <?php } } ?>  
                    </div>

                </div>
            </div>
        </div>

    <?php
         }



} else {

    echo "<div class='p-3 row col-md-8 offset-md-2 mt-3 lg-font'>No matches.</div>";
}

} else {
    
    // Dodaj tego javascripta ale przed praca na obrazkach sprawdź czy uploadProfile itp w ogole istnieje, jeżeli tak to zacznij prace, jak ją skończysz to obowiązkowo po próbuj hackować strone 
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
                    
                    <div class="col-12 row">
                        <?php 
                             for($k=0; $k<3; $k++) {
                                 if(isset($rankingUserSM[$k]->smedia_link)) {
                                     $smedia_link = $rankingUserSM[$k]->smedia_link;
                                
                            
                         ?>
                            <a href="<?php echo $rankingUserSM[$k]->smedia_link ?>" class='link d-flex social-link-click' data-sociallink='<?php echo $rankingUserSM[$k]->id ?>' target='_blank'>
                                <span class='socicon-<?php echo $rankingUserSM[$k]->smedia ?> mx-3 smedia-icon ranking-social' style='font-size: 1.9rem;'>
                            </span>
                        </a> 
                        <?php } } ?>  
                    </div>

                </div>
            </div>
        </div>


    <?php } // END OF THE LOOP
}
