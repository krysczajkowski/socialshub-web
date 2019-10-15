<?php

    //session_start();
    //ob_start();

    include 'db.php';
    include 'functions.php';

    global $pdo;

    $functions = new Functions($pdo);

    define('BASE_URL', 'https://socialshub.net/');

?>