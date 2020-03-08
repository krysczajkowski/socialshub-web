<?php 
include '../functions/init.php';

if(isset($_POST['sociallink_id']) && !empty($_POST['sociallink_id'])) {

	$link_id = $_POST['sociallink_id'];
	$functions->addClick($link_id, 'social_links_clicks');

}

if (isset($_POST['customlink_id']) && !empty($_POST['customlink_id'])) {
	$link_id = $_POST['customlink_id'];
	$functions->addClick($link_id, 'custom_links_clicks');
}


?>