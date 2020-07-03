<?php

try{
    $pdo = new PDO('mysql:host=198.57.247.224; dbname=kczajkow_socialshub', 'kczajkowski', 'q4y$O_$J2yd9');
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection error!'. $e->getMessage();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//For backward compatibility with the hash_equals function.
//This function was released in PHP 5.6.0.
//It allows us to perform a timing attack safe string comparison.
if(!function_exists('hash_equals')) {
    function hash_equals($str1, $str2) {
        if(strlen($str1) != strlen($str2)) {
            return false;
        } else {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
            return !$ret;
        }
    }
}

?>