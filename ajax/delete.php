<?php
	include "../functions/db.php";
	
	if(isset($_COOKIE['user_id'])) {
		$account_id = $_COOKIE['user_id'];	
	} else {
		$account_id = $_SESSION['user_id'];
	}

	$choice = str_replace('img-', '', test_input($_POST["choice"]));
	
	
	// foreach ($data as $value) {
		// $newid = str_replace('cb-','',$value);

        $stmt = $pdo->prepare("UPDATE links SET is_active = ? WHERE id = ? AND account_id = ?")->execute([0,$choice,$account_id]);
        $stmt = null;

	// }

	 echo $var;
