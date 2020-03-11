<?php

class Functions {
    protected $pdo;

    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    //       HELPER FUNCTIONS
    public function checkInput($var) {
        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripslashes($var);
        return $var;
    }

    public function display_error_message($message) {
        if(!empty($message)) {
            echo "<p class='text-danger'>$message</p>";
        }

    }

    public function display_success_message($message) {
        if(!empty($message)) {
            echo "<p class='text-success'>$message</p>";
        }
    }

    public function token_generator() {
        $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        return $token;
    }

    //       HELPER DATABASE FUNCTIONS
    public function user_data($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update($table, $user_id, $fields = array()){
        $columns = '';
        $i = 1;

        foreach($fields as $name => $value) {
            $columns .= "`{$name}` = :{$name}";
            //Funkcja count liczy ilość elementów/obiektów w tablicy (zależy od jej typu)
            if($i < count($fields)) {
                $columns .= ', ';
            }
            //I będzie zwiększało swoją wartość dopuki nie osiągnie wartości o 1 mniejszej niż fields - warto to sobie rozrysować
            $i++;
        }

        $sql = "UPDATE $table SET $columns WHERE `id` = $user_id";
        if($stmt = $this->pdo->prepare($sql)) {
            foreach($fields as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->execute();
        }
    }

    public function userIdByUsername($screenName) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE screenName = :screenName");
        $stmt->bindParam(':screenName', $screenName);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user->id;
    }

    public function userIdByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user->id;
    }
    
    public function isUserFbUser($id) {
        $stmt = $this->pdo->prepare("SELECT fb_user FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user->fb_user;
    }
    
    
    //       ACTIVATE USER FUNCTIONS
    public function activate_user() {

        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if(isset($_GET['email'])) {
                $email = $this->checkInput($_GET['email']);
                $validationCode = $this->checkInput($_GET['code']);

                $stmt = $this->pdo->prepare("SELECT `id` FROM `users` WHERE `email` = :email AND `validationCode` = :validationCode");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':validationCode', $validationCode, PDO::PARAM_STR);
                $stmt->execute();

                $user = $stmt->FETCH(PDO::FETCH_OBJ);
                $id = $user->id;

                if($stmt->rowCount() > 0) {
                    $stmt2 = $this->pdo->prepare("UPDATE `users` SET `active` = 1, `validationCode` = 0 WHERE `id` = :id");
                    $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt2->execute();                              
                    
                    header('Location: '.BASE_URL. 'settings.php');    
                } else {
                    header('Location: welcome.php');
                }
            } else {
                header('Location: welcome.php'); //If we are not logged in, from welcome.php we go back to index.php
            }
        }
    }

    public function isUserActive($active) {
        if($active == 0){
            return false;
        } else {
            return true;
        }
    }

    public function redirectNotActiveUser($active) {
        if($active == 0){
            header('Location: welcome.php');
        }
    }

    //       USER LOGIN FUNCTION
    public function login_user($email, $password, $remember) {
        $hash = md5($password);
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email AND password = :password AND fb_user = 0");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hash, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if($remember == 'on') {
                setcookie('email', $email, time() + 5184000, '/'); //Ustawiamy sesje zeby go kilka miesiecy nie wylogowywalo
                setcookie('user_id', $user->id, time() + 5184000, '/');
            }

            $_SESSION['user_id'] = $user->id;
            return $user;
        }
        return null;
    }


    //       USER REGISTER FUNCTION
    public function register_user($email, $password, $screenName, $fb_user) {
        $user_active = 0;
        
        if($fb_user == 1) {
            $hash = '';
            $user_active = 1;
            $profilePicture = $_SESSION['fb-userData']['picture']['url'];
        } else {
            $hash = md5($password);
            $profilePicture = 'images/defaultProfileImage.png';
        }
        
        $validationCode = md5($screenName . microtime());
        $remember = 0;

        $stmt = $this->pdo->prepare("INSERT INTO `users` (`email`, `password`, `screenName`, `validationCode`, `active` , `profileImage`, `profileCover`, `fb_user`) VALUES (:email, :password, :screenName, :validationCode, $user_active ,:profilePicture, 'images/defaultCoverImage.png', $fb_user)");

	    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
 	    $stmt->bindParam(":password", $hash , PDO::PARAM_STR);
	    $stmt->bindParam(":screenName", $screenName, PDO::PARAM_STR);
	    $stmt->bindParam(":validationCode", $validationCode, PDO::PARAM_STR);
	    $stmt->bindParam(":profilePicture", $profilePicture);
        $stmt->execute();
        
        $user_id = $this->pdo->lastInsertId();
        $_SESSION['user_id'] = $user_id;

        //Creating rows in Social_links table
        
        $socialmedia = ['youtube', 'instagram', 'tiktok', 'twitch', 'twitter', 'snapchat','facebook', 'github', 'linkedin', 'pinterest', 'spotify', 'soundcloud'];

        for($i = 0; $i < count($socialmedia); $i++) {

            $stmt2 = $this->pdo->prepare("INSERT INTO `social_links` (`account_id`, `smedia`) VALUES (:account_id, :smedia)");
            $stmt2->bindParam(":account_id", $user_id);
            $stmt2->bindParam(":smedia", $socialmedia[$i]);
            $stmt2->execute();
        }
        
        //Sending Email
        if($fb_user == 0) {
        $subject = "SocialsHub - Activate Your Account";
        $message = "
<html>
<head>
    <meta>
    <title>SocialsHub - Password Reset</title>
</head>
<body style='font-family: Helvetica; background-color: #fafafa;'>
    <div style='background-color: #fff; margin-top: 2%; padding: 2% 5% 1% 5%; text-align: center;'>
        <img src='https://socialshub.net/logo.png' style='width: 80px; height: 80px; margin-bottom: 1%;' alt=''> <br>
        <h2 style='font-size 1.5rem;'>Activate Account</h2>

        <h2 style='font-size: 1.4rem;'>Dear User,</h2>
        <p style='font-size: 1.2rem;'>Thank you for registration in <b>SocialsHub</b>!</p>
        <p style='font-size: 1.2rem;'>You just need to confirm your email. </p>
        <a style='background-color: #28a745; border: 1px solid #28a745; padding: 9px 15px; font-weight: bold; border-radius: 4px; font-size: 1.2rem; color: #fff; cursor: pointer; text-decoration: none;' href='https://socialshub.net/activate.php?email=$email&code=$validationCode'>Confirm Email</a>
        <p style='margin-top: 10%;'>Thank You, <a href='https://socialshub.net' style='color: #0000EE; text-decoration: none;'>SocialsHub</a></p>
    </div>
</body>
</html>
";
        
            $header = "MIME-Version: 1.0" . "\r\n";
            //$header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $header .= "From: SocialsHub <socialshub@socialshub.net>";


            mail($email, $subject, $message, $header);
        }
    }


    //       LOGGED IN FUNCTION
    public function loggedIn() {
        if(isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])) {
            return true;
        } else {
            return false;
        }
    }


    //       PASSWORD FUNCTIONS

    public function checkPassword($password, $id) {
        $hash = md5($password);
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE password = :password AND id = :id");
        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function reset_password($newPassword, $email, $validationCode) {
        $hash = md5($newPassword);
        $stmt = $this->pdo->prepare("UPDATE users SET password = :password, validationCode = 0 WHERE email = :email AND validationCode = :validationCode");
        $stmt->bindParam(":password", $hash , PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":validationCode", $validationCode, PDO::PARAM_STR);

        if($stmt->execute()) {
            $_SESSION['sLogin'] = 'Your password has been updated.';
            header('Location: index.php');
        } else {
            $_SESSION['eReset'] = "Sorry you can't update your password now. Please try again in a few hours.";
        }
    }

    public function recover_password($email) {

        $validationCode = md5($email . microtime());

        $stmt = $this->pdo->prepare("UPDATE users SET validationCode = :validationCode WHERE email = :email");
        $stmt->bindParam(':validationCode', $validationCode);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
            //Sending Email
            $subject = "SocialsHub - Reset Your Password";
            $message = "
<html>
<head>
    <meta>
    <title>SocialsHub - Password Reset</title>
</head>
<body style='font-family: Helvetica; background-color: #fafafa;'>
    <div style='background-color: #fff; margin-top: 2%; padding: 2% 5% 1% 5%; text-align: center;'>
        <img src='https://socialshub.net/logo.png' style='width: 80px; height: 80px; margin-bottom: 1%;' alt=''> <br>
        <h2 style='font-size 1.5rem;'>Password Reset</h2>

        <h2 style='font-size: 1.4rem;'>Dear User,</h2>
        <p style='font-size: 1.2rem;'>To reset your <b>SocialsHub</b> account password please click <a href='https://socialshub.net/reset.php?email=$email&code=$validationCode' style='color: #0000EE; text-decoration: none;'>here</a>.</p>
        <p style='margin-top: 10%;'>Thank you, <a href='https://socialshub.net' style='color: #0000EE; text-decoration: none;'>SocialsHub</a></p>
    </div>
</body>
</html>
";
        
            $header = "MIME-Version: 1.0" . "\r\n";
            //$header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $header .= "From: SocialsHub <socialshub@socialshub.net>";


            mail($email, $subject, $message, $header);
            //          $eRecoverEmail = "Sorry, we can't sent you an email";
            $_SESSION['sLogin'] = 'Please check your email or spam folder for a password reset link.';

            setcookie('reset_password_cookie', 1, time()+ 420);

            //            echo("<script>location.href = '".BASE_URL."';</script>");

    }


    //       EXIST FUNCTIONS
    public function email_exist($email) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();

        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function name_exist($screenName) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE screenName = :screenName");
        $stmt->bindParam(':screenName', $screenName, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();

        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    //      IMAGE FUNCTIONS
    public function uploadImage($file, $id) {
        
        // File information
        $uploaded_name = basename($file['name']);
        $uploaded_ext  = substr( $uploaded_name, strrpos( $uploaded_name, '.' ) + 1);
        $uploaded_size = $file[ 'size' ];
        $uploaded_type = $file[ 'type' ];
        $uploaded_tmp  = $file[ 'tmp_name' ];

        // Where are we going to be writing to?
        $target_path   = 'images/';

        //$target_file   = basename( $uploaded_name, '.' . $uploaded_ext ) . '-';
        $target_file   =  md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
        $temp_file     = ( ( ini_get( 'upload_tmp_dir' ) == '' ) ? ( sys_get_temp_dir() ) : ( ini_get( 'upload_tmp_dir' ) ) );
        $temp_file    .= DIRECTORY_SEPARATOR . md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;

        // Is it an image?
        if( ( strtolower( $uploaded_ext ) == 'jpg' || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) &&          
            ( $uploaded_size < 4192751 ) &&
            ( $uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png' ) &&
            getimagesize( $uploaded_tmp ) ) {
            // Strip any metadata, by re-encoding image (Note, using php-Imagick is recommended over php-GD)
            if( $uploaded_type == 'image/jpeg' ) {
                $img = imagecreatefromjpeg( $uploaded_tmp );
                imagejpeg( $img, $temp_file, 100);
            }
            else {
                $img = imagecreatefrompng( $uploaded_tmp );
                imagepng( $img, $temp_file, 9);
            }
            imagedestroy( $img );

            if( rename( $temp_file, ( getcwd() . DIRECTORY_SEPARATOR . $target_path . $target_file))) {

                move_uploaded_file($target_path, $target_file);
                $fileRoot = $target_path . $target_file;
                return $fileRoot;


            } else {
                $_SESSION['eSettings'] = 'Sorry, your image was not uploaded.1';
            }



            // Delete any temp files
            if( file_exists( $temp_file ) )
                unlink( $temp_file );
        }
        else {
            // Invalid file
            $_SESSION['eSettings'] = 'Your image was not uploaded. We can only accept JPEG or PNG images.';
        }

    }


    //      reCAPTCHA FUNCTIONS
    public function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '6LeSqqAUAAAAALQLOTjt83aHAMfDL7GEyl5QPcJv', //Secret key
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }


    //      SEARCH FUNCTIONS
    public function search($search) {
        $stmt = $this->pdo->prepare("SELECT id, screenName, profileImage, profileCover, bio FROM users WHERE email LIKE ? OR screenName LIKE ? LIMIT 6");
        $stmt->bindValue(1, $search."%", PDO::PARAM_STR);
        $stmt->bindValue(2, $search."%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    //       DELETE ACCOUNT FUNCTIONS

    public function delete_account($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();


        $stmt2 = $this->pdo->prepare("DELETE FROM account_views WHERE account_id = :account_id");
        $stmt2->bindParam(':account_id', $id);
        $stmt2->execute();

        $stmt3 = $this->pdo->prepare("DELETE FROM visitors WHERE account_id = :account_id");
        $stmt3->bindParam(':account_id', $id);
        $stmt3->execute();

        $stmt4 = $this->pdo->prepare("DELETE FROM social_links WHERE account_id = :account_id");
        $stmt4->bindParam(':account_id', $id);
        $stmt4->execute(); 

        $stmt5 = $this->pdo->prepare("DELETE FROM links WHERE account_id = :account_id");
        $stmt5->bindParam(':account_id', $id);
        $stmt5->execute(); 
        
        //Sending Email
        $subject = "Your Account Has Been Deleted";
        $message = "
        Your account has been successfully deleted.
        ";
        $header = "From: support@socialshub.net";
        mail($email, $subject, $message, $header);

        header('Location: logout.php');

    }


    //       BIO/LINKS FUNCTIONS

    public function text2link ($text) {
        // The Regular Expression filter
        $reg_exUrl = "/((((http|https|ftp|ftps)\:\/\/)|www\.)[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}(\/\S*)?)/";


        // Check if there is a url in the text
        if(preg_match($reg_exUrl, $text, $url)) {

            // make the urls hyper links
            echo preg_replace( $reg_exUrl, "<a class='link' target='_blank' href=\"$1\">$1</a> ", $text );

        } else {

           // if no urls in the text just return the text
           echo $text;

        }
    }

    public function isTextLink ($text) {
        $has_link = stristr($text, 'http://') ?: stristr($text, 'https://');
        return $has_link;
    }
    //       VIEWERS FUNCTION

//    public function showViews ($account_id) {
//        $stmt = $this->pdo->prepare("SELECT * FROM account_views WHERE account_id = :account_id");
//        $stmt->bindParam(':account_id', $account_id);
//        $stmt->execute();
//        $accountData = $stmt->fetch(PDO::FETCH_OBJ);
//
//        return $accountData->views;
//    }
//
//    public function addView($account_id) {
//
//        if((!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) || (($_SESSION['user_id'] !== $account_id && $_SESSION['user_id'] != "") || $_COOKIE['user_id'] !== $account_id) ) {
//            $stmt = $this->pdo->prepare("UPDATE account_views SET views = views +1 WHERE account_id = :account_id");
//            $stmt->bindParam(':account_id', $account_id);
//            $stmt->execute();
//        }
//    }
    
    //       VISITORS FUNCTIONS

    public function showVisitors($account_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM visitors WHERE account_id = :account_id");
        $stmt->bindParam(':account_id', $account_id);
        $stmt->execute();
        $visitors = $stmt->rowCount();
        return $visitors;
    }

    public function addVisitor($account_id) {
        $visitor_ip = $_SERVER['REMOTE_ADDR'];

        $stmt = $this->pdo->prepare("SELECT * FROM visitors WHERE account_id = :account_id AND visitor_ip = :visitor_ip");
        $stmt->bindParam(':account_id', $account_id);
        $stmt->bindParam(':visitor_ip', $visitor_ip);
        $stmt->execute();
        
        if($stmt->rowCount() == 0) {
            $stmt = $this->pdo->prepare("INSERT INTO visitors (id, account_id, visitor_ip) VALUES (NULL, :account_id, :visitor_ip)");
            $stmt->bindParam(':account_id', $account_id);
            $stmt->bindParam(':visitor_ip', $visitor_ip);
            $stmt->execute();
        }

    }
    
    
    //       SOCIAL MEDIA FUNCTIONS 

    public function updateSocialLinks ($account_id, $socialmedia, $name, $link) {
        $stmt = $this->pdo->prepare("UPDATE social_links SET smedia_name = :smedia_name , smedia_link = :smedia_link WHERE account_id = :account_id AND smedia = :smedia");
        
        $stmt->bindParam(':smedia_name', $name);
        $stmt->bindParam(':smedia_link', $link);
        $stmt->bindParam(':account_id', $account_id);
        $stmt->bindParam(':smedia', $socialmedia);
        $stmt->execute();           
    }

    public function addNewSocialMedia ($account_id) {

        $newSocialMedia = ['github', 'linkedin', 'pinterest', 'spotify', 'soundcloud'];

        for($i=0; $i < count($newSocialMedia); $i++) {
            $stmt = $this->pdo->prepare("SELECT * FROM social_links WHERE account_id = :account_id AND smedia = :smedia");
            $stmt->bindParam(':account_id', $account_id);
            $stmt->bindParam(':smedia', $newSocialMedia[$i]);
            $stmt->execute();

            if($stmt->rowCount() == 0) {
                $stmt = $this->pdo->prepare("INSERT INTO social_links (id, account_id, smedia) VALUES (NULL, :account_id, :smedia)");
    
                $stmt->bindParam(':account_id', $account_id);
                $stmt->bindParam(':smedia', $newSocialMedia[$i]);
                $stmt->execute(); 
                        
            }
        }

    }


    public function showSocialMedia ($account_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM social_links WHERE account_id = :account_id");
        $stmt->bindParam(':account_id', $account_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function showNotEmptySocialMedia ($account_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM social_links WHERE account_id = :account_id AND smedia_link != ''");
        $stmt->bindParam(':account_id', $account_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function showSocialMediaName ($account_id, $smedia) {
        $stmt = $this->pdo->prepare("SELECT smedia_name, smedia_link, smedia FROM social_links WHERE account_id = :account_id AND smedia = :smedia");
        $stmt->bindParam(':account_id', $account_id);
        $stmt->bindParam(':smedia', $smedia);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }
    
    public function weekVisitors($id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(id) as weekVisits FROM visitors WHERE visit_date BETWEEN date_sub(now(),INTERVAL 1 WEEK) AND now()  AND account_id = :account_id");
        $stmt->bindParam(':account_id', $id);
        $stmt->execute();

        //Returning number of visitors this week
        return $stmt->fetch(PDO::FETCH_OBJ)->weekVisits;
    }    
 
     public function addClick($link_id, $table) {
        $stmt = $this->pdo->prepare("INSERT INTO $table (id, clickOn) VALUES (NULL, :link_id)");
        $stmt->bindParam(':link_id', $link_id);
        $stmt->execute();
    }

    public function showClickCounter($account_id, $link_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM social_links, social_links_clicks WHERE social_links.account_id = :account_id and social_links.id = :link_id and social_links.id = social_links_clicks.clickOn");
        $stmt->bindParam(':account_id', $account_id);
        $stmt->bindParam('link_id', $link_id);
        $stmt->execute();

        return $stmt->rowCount();

    }

    //       CUSTOM LINKS FUNCTIONS  

    public function showActiveLinks ($account_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM links WHERE account_id = :account_id and is_active = 1 ORDER BY `order` DESC");
        $stmt->bindParam(':account_id', $account_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function showNotActiveLinks ($account_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM links WHERE account_id = :account_id and is_active = 0 ORDER BY `order` DESC");
        $stmt->bindParam(':account_id', $account_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function showCustomLinksClickCounter($account_id, $link_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM links, custom_links_clicks WHERE links.account_id = :account_id and links.id = :link_id and links.id = custom_links_clicks.clickOn");
        $stmt->bindParam(':account_id', $account_id);
        $stmt->bindParam('link_id', $link_id);
        $stmt->execute();

        return $stmt->rowCount();

    }

    //       RANKING FUNCTIONS 

    public function rankingGenerator() {
        $stmt = $this->pdo->prepare("SELECT COUNT(id) as weekVisits, account_id FROM visitors WHERE visit_date BETWEEN date_sub(now(),INTERVAL 1 WEEK) AND now() GROUP BY account_id ORDER BY COUNT(id) DESC LIMIT 10 ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

?>
