<?php
	include "../functions/db.php";	

	if(isset($_COOKIE['user_id'])) {
		$account_id = $_COOKIE['user_id'];	
	} else {
		$account_id = $_SESSION['user_id'];
	}

	$data = $_POST["choices"];

	$newarray = explode("&", $data[0]);

	$i = count($newarray);
	foreach ($newarray as $key => $value) {
		$ides = explode("=", $value);

		$order = (int)$ides[1];

        $stmt = $pdo->prepare("UPDATE `links` SET `order` = ? WHERE id = ? AND account_id = ?")->execute([$i,$order,$account_id]);
        $stmt = null;		
		$i--;
	}
