<?php

    // Turn off all error reporting
    error_reporting(0);

    include 'db.php';
    include 'functions.php';

    global $pdo;

    $functions = new Functions($pdo);

    define('BASE_URL', 'https://socialshub.net/');

?>