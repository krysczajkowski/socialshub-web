<?php 

//LOGIN CODE

$eLogin = '';
$sLogin = '';

if(isset($_POST['loginEmail']) && !empty($_POST['loginEmail']) &&isset($_POST['loginPassword'])) {
    $email     = $_POST['loginEmail'];
    $password  = $_POST['loginPassword'];
    $remember  = isset($_POST['remember']);
    
    if(!empty($email) || !empty($password)) {
        $email     = $functions->checkInput($email);
        $password  = $functions->checkInput($password);
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $eLogin = 'Invalid format of email.';
        } else {
            
            if($functions->login_user($email, $password, $remember) == false) {
                $eLogin = "Your credentials are not correct.";
            }
        }
        
    } else {
        $eLogin = "Your credentials are not correct.";
    }
}

//FORGOT PASSWORD CODE
if(isset($_POST['forgot-password'])) {
    echo("<script>location.href = '".BASE_URL."'/recover.php</script>");
}

?>
   

<form method='post'>
    <input type="text" value='<?php if(isset($email)) {echo $email ;} ?>' class="form-control" placeholder='Email' name='loginEmail'>
    <input type="Password" class="form-control mt-2" placeholder='Password' name='loginPassword'>
    <div class="custom-control custom-checkbox mt-2">
        <input type="checkbox" class="custom-control-input" id="remember" name='remember' checked>
        <label class="custom-control-label" for="remember">Remember me</label>
    </div>
    <button class="btn btn-primary mt-2" name='login' id='login'>Login</button>
    
    <a href="recover.php" class='d-block text-muted mt-1 p-0 d-block'>Forgot Password?</a>
</form>
<?php
$functions->display_error_message($eLogin);
$functions->display_success_message($sLogin);
if(isset($_SESSION['sLogin'])) {
    $functions->display_success_message($_SESSION['sLogin']);
    $_SESSION['sLogin'] = '';
}
?>