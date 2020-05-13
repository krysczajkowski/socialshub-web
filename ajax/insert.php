<?php
	session_start();
	include "../functions/db.php";

	$date = date('Y-m-d H:i:s');
	
	if(isset($_COOKIE['user_id'])) {
		$account_id = $_COOKIE['user_id'];	
	} else {
		$account_id = $_SESSION['user_id'];
	}

	$id = str_replace('img-', '', $_POST["id"]);
	$title = test_input($_POST["title"]);
	$link = test_input($_POST["link"]);

	if(!empty($id)){

		if($stmt = $pdo->prepare("UPDATE `links` SET `title` = ? , `link` = ? WHERE id = ? AND account_id = ?")->execute([$title,$link,$id,$account_id])){
			$stmt = null;
		} else {
			echo 'Sorry! We have a server problem.';
		}
		
	} else {

        $count  =  $pdo->query("SELECT count(*) AS total FROM links where account_id = ".$account_id)->rowCount();

        $order = (int)$count[0]['total'] + 1;
		
		$stmt = $pdo->prepare("INSERT INTO `links` ( `account_id`,`title`,`link`,`date`,`order`,`is_active`)  VALUES( :account_id,:title,:link,:date,:order,1)");

	    $stmt->bindParam(":account_id", $account_id, PDO::PARAM_STR);
		$stmt->bindParam(":title", $title, PDO::PARAM_STR);
		$stmt->bindParam(":link", $link, PDO::PARAM_STR);
 	    $stmt->bindParam(":date", $date , PDO::PARAM_STR);
	    $stmt->bindParam(":order", $order, PDO::PARAM_STR);	   
        $stmt->execute();

	/*$statement->bindValue(':link', $link);
	$statement->bindValue(':date', $date);
	$statement->bindValue(':order', $order);
	$statement->bindValue(':is_active', 1);

	$statement->execute();*/


	}
?>