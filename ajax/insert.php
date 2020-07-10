<?php
error_reporting(E_ALL);
session_start();
include "../functions/init.php";

$token_error = false;

//Make sure that the token POST variable exists.
if(!isset($_POST['token_special'])){
	$token_error = true;
}

//It exists, so compare the token we received against the
//token that we have stored as a session variable.
if(hash_equals($_POST['token_special'], $_SESSION['token_special']) === false){
	$token_error = true;
}
	
if(isset($_SESSION['insertError'])) {
	echo $_SESSION['insertError'];
}


	if(isset($_POST['title']) && isset($_POST['id']) && $token_error == false) {
		$date = date('Y-m-d H:i:s');
	
		if(isset($_COOKIE['user_id'])) {
			$account_id = $_COOKIE['user_id'];	
		} else {
			$account_id = $_SESSION['user_id'];
		}

		$id = str_replace('img-', '', $_POST["id"]);
		$title = $functions->checkInput($_POST["title"]);
		$description = $functions->checkInput($_POST["description"]);
		$link = $functions->checkInput($_POST["link"]);

		if(!empty($id)){

			if($stmt = $pdo->prepare("UPDATE `links` SET `title` = ? , `description` = ? , `link` = ? WHERE id = ? AND account_id = ?")->execute([$title,$description,$link,$id,$account_id])){
				$stmt = null;
			} else {
				echo 'Sorry! We have a server problem.';
			}

			if(!empty($_FILES['file']['name'][0])) {

				$validImg = $functions->uploadImage($_FILES['file'], $account_id, '../images4links/'); 

				$stmt = $pdo->prepare("SELECT id FROM `images4links` WHERE `link_id` = :link_id");
				$stmt->bindParam(":link_id", $id, PDO::PARAM_INT);
				$stmt->execute();

				if($stmt->rowCount() > 0 && $validImg != '') {
					//This link has a img included

					$stmt = $pdo->prepare("UPDATE `images4links` SET `link_image` = :link_image WHERE `link_id` = :link_id");
					$stmt->bindParam(":link_image", $validImg, PDO::PARAM_STR);
					$stmt->bindParam(":link_id", $id, PDO::PARAM_INT);
					$stmt->execute();
					
				} elseif($stmt->rowCount() == 0 && $validImg != '') {
					//This link has no img included

					$stmt = $pdo->prepare("INSERT INTO `images4links` (`link_id`,`link_image`)  VALUES (:link_id,:link_image)");
					$stmt->bindParam(":link_id", $id);
					$stmt->bindParam(":link_image", $validImg, PDO::PARAM_STR);
					$stmt->execute();
				}

			}
			
		} else {

			$count  =  $pdo->query("SELECT count(*) AS total FROM links where account_id = ".$account_id)->rowCount();

			$order = (int)$count[0]['total'] + 1;
			
			$stmt = $pdo->prepare("INSERT INTO `links` ( `account_id`,`title`,`description`,`link`,`date`,`order`,`is_active`)  VALUES( :account_id,:title,:description,:link,:date,:order,1)");

			$stmt->bindParam(":account_id", $account_id, PDO::PARAM_STR);
			$stmt->bindParam(":title", $title, PDO::PARAM_STR);
			$stmt->bindParam(":description", $description, PDO::PARAM_STR);
			$stmt->bindParam(":link", $link, PDO::PARAM_STR);
			$stmt->bindParam(":date", $date , PDO::PARAM_STR);
			$stmt->bindParam(":order", $order, PDO::PARAM_STR);	   
			$stmt->execute();

			if(!empty($_FILES['file']['name'][0])) {

				$lastInsertedId = $pdo->lastInsertId();
				$validImg = $functions->uploadImage($_FILES['file'], $account_id, '../images4links/'); 

				if($validImg != '') {
					$stmt = $pdo->prepare("INSERT INTO `images4links` (`link_id`,`link_image`)  VALUES (:link_id,:link_image)");
					$stmt->bindParam(":link_id", $lastInsertedId);
					$stmt->bindParam(":link_image", $validImg, PDO::PARAM_STR);
					$stmt->execute();
				}

			}

		}

	}
?>