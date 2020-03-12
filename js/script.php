<?php

// We check here if is set $_GET['username'] and if so we change images

if(isset($_GET['username'])) {
?>
    
<script>
    $('.profileImage').css('background-image', 'url(<?php echo $profileData->profileImage ?>)');
</script>

<?php 
if($functions->loggedIn()) { ?>
    <script>
        $('.profileImage-sm').css('background-image', 'url(<?php echo $user->profileImage ?>)');
    </script>
    
<?php
}
} else { ?>
  
<script>
    $('.profileImage-sm').css('background-image', 'url(<?php echo $user->profileImage ?>)');
</script>
    
      
<?php  
} 
?>



