<?php
	session_start();
	include "db.php";


	if(isset($_COOKIE['user_id'])) {
		$account_id = $_COOKIE['user_id'];	
	} else {
		$account_id = $_SESSION['user_id'];
	}

    $stm  = $pdo->query("SELECT * FROM links WHERE is_active = '1' and account_id = ".$account_id." ORDER BY 6 DESC");
    $datas =  $stm->fetchAll(PDO::FETCH_ASSOC);
	
	
	$var = '';
	foreach ($datas as $value) {
		// $var .= "
		// <li class='list-group-item' id='order-".$value['id']."'>
		// <input type='checkbox' class='checkbox' id='cb-".$value['id']."'>
		// <span class='badge badge-success'>".$value['title']."</span>
		// <a href='".$value['link']."' target='_blank'>".$value['link']."</a>
		// <i class='fa fa-edit' id='img-".$value['id']."' data='".$value['title']."'></i>	
		
		$var .= "
		<li class='list-group-item bg-white noselect' id='order-".$value['id']."'>		
		<span class='h5 font-weight-bold'>".$value['title']."</span><br>
		<a href='".$value['link']."' target='_blank'>".$value['link']."</a>
		<i class='fa fa-edit ml-2' id='img-".$value['id']."' data='".$value['title']."'></i>
		<i class='fa fa-trash text-danger mr-3' id='img-".$value['id']."' data='".$value['title']."'></i>		
		
		</li>";
	}

	echo $var;
