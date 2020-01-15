<?php
	include "db.php";	

	$data = $_POST["choices"];

	$newarray = explode("&", $data[0]);

	$i = count($newarray);
	foreach ($newarray as $key => $value) {
		$ides = explode("=", $value);

		$order = (int)$ides[1];

        $stmt = $pdo->prepare("UPDATE `links` SET `order` = ? WHERE id = ?")->execute([$i,$order]);
        $stmt = null;		
		$i--;
	}
