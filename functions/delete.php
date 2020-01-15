<?php
	include "db.php";
	
	//$database = new cbSQLConnect($databaseSetup, cbSQLConnectVar::FETCH_ASSOC);

	$choice = str_replace('img-', '', test_input($_POST["choice"]));
	
	
	// foreach ($data as $value) {
		// $newid = str_replace('cb-','',$value);

        $stmt = $pdo->prepare("UPDATE links SET is_active = ? WHERE id = ?")->execute([0,$choice]);
        $stmt = null;

	// }

	 echo $var;
