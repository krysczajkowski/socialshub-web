<?php 
session_start();
include "../functions/init.php";
if(isset($_POST['checkbox_value']) && isset($_POST['link_id'])) {
    $checkbox_value = $functions->checkInput($_POST["checkbox_value"]);
    $link_id = $functions->checkInput($_POST["link_id"]);

    if(isset($_COOKIE['user_id'])) {
        $account_id = $_COOKIE['user_id'];	
    } else {
        $account_id = $_SESSION['user_id'];
    }

    if($checkbox_value == 'true') {
        $is_enable = 1;
    } elseif ($checkbox_value == 'false') {
        $is_enable = 0;
    }

    if(!empty($link_id)) {
        $stmt = $pdo->prepare("UPDATE `links` SET `is_enable` = :is_enable WHERE id = :link_id AND account_id = :account_id");
        $stmt->bindParam(":is_enable", $is_enable);
        $stmt->bindParam(":link_id", $link_id);
        $stmt->bindParam(":account_id", $account_id);
        $stmt->execute();
    }
}