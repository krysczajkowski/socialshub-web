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

?>