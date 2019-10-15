<?php

try{
    $pdo = new PDO('mysql:host=198.57.247.224; dbname=kczajkow_socialshub', 'kczajkowski', '3U5L0YNjcOmV');
    
} catch (PDOException $e) {
    echo 'Connection error!'. $e->getMessage();
}

?>