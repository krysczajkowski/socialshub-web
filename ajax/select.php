<?php
	session_start();
	include "../functions/init.php";


	if(isset($_COOKIE['user_id'])) {
		$account_id = $_COOKIE['user_id'];	
	} else {
		$account_id = $_SESSION['user_id'];
	}

    $stm  = $pdo->query("SELECT * FROM links WHERE is_active = '1' and account_id = ".$account_id." ORDER BY 6 DESC");
    $datas =  $stm->fetchAll(PDO::FETCH_ASSOC);
	
	
	$var = '';
	foreach ($datas as $value) {
		
		$linkId = $value['id'];

		$clicks = $functions->showCustomLinksClickCounter($account_id, $linkId);

		$var .= "
		<li class='list-group-item bg-white noselect' id='order-".$value['id']."'>		
		<span class='h5 font-weight-bold'>".$value['title']."</span><br>
		<a href='".$value['link']."' target='_blank'>".$value['link']."</a>
		<i class='fa fa-edit ml-2' id='img-".$value['id']."' data='".$value['title']."'></i>
		<i class='fa fa-trash text-danger mr-3' id='img-".$value['id']."' data='".$value['title']."'></i>		
		<br> 
		<span>This link has been clicked <span class='font-weight-bold'>".$clicks."</span> times.</span>
		</li>";
	}

	echo $var;
