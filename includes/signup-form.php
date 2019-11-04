<script>
    function onSubmit(token) {
        document.getElementById("i-recaptcha").submit();
    }
</script>

<?php
$eRegister = '';

if(isset($_POST['nameRegister']) && isset($_POST['emailRegister']) && isset($_POST['passwordRegister'])) {

    //VALIDATE VARIABLES
    $reg_name     = $functions->checkInput($_POST['nameRegister']);
    $reg_email    = $functions->checkInput($_POST['emailRegister']);
    $reg_password = $functions->checkInput($_POST['passwordRegister']);
    $terms    = isset($_POST['accept-terms']);
    $privacy  = isset($_POST['accept-privacy']);


    if(!empty($username) || !empty($reg_email) || !empty($reg_password)) {

        if(!filter_var($reg_email, FILTER_VALIDATE_EMAIL)) {
            $eRegister = 'Invalid email.';
        } else if (strlen($reg_name) < 2 || strlen($reg_name) > 25) {
            $eRegister = 'Name must be between 2 and 25 characters.';
        } else if ($functions->name_exist($reg_name)) {
            $eRegister = 'Sorry, this name is already taken.';
        } else if(!preg_match('/^[a-zA-Z0-9]+$/', $reg_name)) {
            $eRegister = 'Only letters, numbers and white space allowed.';
        } else if ($functions->email_exist($reg_email)) {
            $eRegister = 'This email is already in use.';
        } else if (strlen($reg_password) < 5 || strlen($reg_password) > 25) {
            $eRegister = 'Password must be between 5 and 25 characters';
        }else if ($terms != 'on' || $privacy != 'on'){
            $eRegister = 'All checkbox are required';
        } else {

            // Call the function post_captcha
            $res = $functions->post_captcha($_POST['g-recaptcha-response']);

            if (!$res['success']) {
                // What happens when the reCAPTCHA is not properly set up
                $eRegiseter = "Sorry you can't be registered now.";
            } else {
                //Adding user to database
                $_SESSION['reg_name'] = $reg_name;
                $_SESSION['reg_email'] = $reg_email;
                $_SESSION['reg_password'] = $reg_password;
                
                $_SESSION['registerUser'] = 1;
                echo("<script>location.href = '".BASE_URL."';</script>");  

            }
        }

    } else {
        $eRegister = 'All fields are required.';
    }
}


?>


<form action="" method="post" id='i-recaptcha'>
    <input type="text" value='<?php if(isset($reg_name)) {echo $reg_name;} ?>' class="form-control" placeholder='Name' name='nameRegister'>
    <input type="email" value='<?php if(isset($reg_email)) {echo $reg_email;} ?>' class="form-control mt-2" placeholder='Email' name='emailRegister'>
    <input type="Password" value='<?php if(isset($reg_password)) {echo $reg_password;} ?>' class="form-control mt-2" placeholder='Password' name='passwordRegister'>
    <!-- TERMS CHECKBOX -->
    <div class="custom-control custom-checkbox mt-2">
        <input type="checkbox" class="custom-control-input" id="accept-terms" name='accept-terms'>
        <label class="custom-control-label mt-1" for="accept-terms" style='font-size: 0.95rem;'>I agree to <a href="terms.php" target="_blank" class='text-primary'>Terms of Use</a></label>
    </div>

    <!-- PRIVACY POLICY, COOKIES CHECKBOX -->
    <div class="custom-control custom-checkbox mt-2">
        <input type="checkbox" class="custom-control-input" id="accept-privacy" name='accept-privacy'>
        <label class="custom-control-label" for="accept-privacy" style='font-size: 0.95rem;'>I agree to the <a href="privacy-policy.php" target="_blank" class='text-primary'>Privacy Policy</a>, including use of cookies</label>
    </div>
    <!-- We can't use any name or id on g-recaptcha button -->
    <input type="submit" class='g-recaptcha btn btn-success btn-block mt-2' value = 'Sign Up' data-sitekey="6LeSqqAUAAAAACHnB6-dJnds0awuHiG74jqecIcb" data-callback="onSubmit" >

    <?php $functions->display_error_message($eRegister); $eRegister = '';?>
</form>
