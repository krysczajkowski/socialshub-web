<?php
include '../functions/init.php';

if(isset($_POST['search']) && !empty($_POST['search'])) {
     $search = $functions->checkInput($_POST['search']);
     $result = $functions->search($search);

     if(!empty($result)) {
         
     echo "<div class='kurwa'>";

     //Robimy obiekt każdego wyszukanego usera w html
         foreach($result as $user){ 

         echo "<div>";
            echo "<a href='".BASE_URL."$user->screenName' class='search-link'>";
                echo "<div class='search-row row py-3 px-2'>";
                    echo "<div class='col-3 p-0 m-0'><img src='$user->profileImage' alt='' class='rounded-circle ml-3' style='width: 32px; height: 32px;'></div>";
                    echo "<div class='col-9 m-0 pl-1 text-dark pt-1 font-open-sans' style='font-size: 1.1rem; '>$user->screenName</div>";
                echo "</div>";
            echo "</a>";
         echo "</div>";

         }
     
    echo "</div>";
}   
}
?>
